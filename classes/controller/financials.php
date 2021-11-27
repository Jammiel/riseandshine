<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class EXPENSES  extends database_crud{
    protected $table = "expensestracs";
    protected $pk = "expenseid";
    public static $code;
    //SELECT `expenseid`, `expensecode`, `paymode`, `paydesc`, `slipno`, `description`, `paidamount`,
    // `boughtdate`, `inserteddate`, `handledby`, `status` FROM `expensestracs` WHERE 1
    public static $tot;

    public static function GET_EXPESEACCOUTS(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM sections WHERE seccode='LVL002'") as $rows) {
            foreach ($db->query("SELECT * FROM level2 WHERE level1id='" . $rows['sec_id'] . "'") as $row) {
                echo '<optgroup label="' . $row['level1name'] . '">';
				$rip = array();
				foreach ($db->query("SELECT * FROM level3 WHERE level2act='1' AND level2id='" . $row['lvl1_id'] . "'") as $rowx) {
					$dd[] = $rowx['level2id'];
					$codej[] = $rowx['level2name'];
					$codek[] = $rowx['lvl2_id'];
					$procode[] = $rowx['level2code'];
				}
				$pp = array();
				$yy = array();
				$hh = array();
				foreach ($db->query("SELECT * FROM level3 WHERE level2act='1' AND level2id='" . $row['lvl1_id'] . "'") as $rowd) {
					array_push($pp,$rowd['lvl2_id']);
				}
				foreach ($db->query("SELECT * FROM level4") as $rowd) {
					array_push($yy,$rowd['level3id']);
				}
				$codes =array_unique($yy);
				foreach($codes as $k){
					for ($i = 0; $i <= count($pp); $i++) {
						if($pp[$i]==$k){
							if($k!=""){
								foreach ($db->query("SELECT * FROM level4 WHERE level3id='" . $k . "'") as $rowd) {
									echo '<option value="' . $rowd['level3code'] . '">' . $rowd['level3name'] . '</option>';
								}
							}
						}else if(!in_array($pp[$i], $codes)){
							array_push($hh,$pp[$i]);
							
						}
					}
				}
				
				$ff = array_unique($hh);
				for ($i = 0; $i <= count($hh); $i++) {
					if($hh[$i]==$hh[$i-2] || $hh[$i]==$hh[$i-3]){
						
					}else{
						if($hh[$i]!=""){
							foreach ($db->query("SELECT * FROM level3 WHERE lvl2_id='" . $hh[$i] . "'") as $rowd) {
								echo '<option value="' . $rowd['level2code'] . '">' . $rowd['level2name'] . '</option>';
							}
						}
					}
				}
					
				echo '</optgroup>';
            }
        }

    }

    public static function GET_BANKACCOUNTS(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM sections WHERE seccode='LVL004'") as $rows) {
            foreach ($db->query("SELECT * FROM level2 WHERE level1id='" . $rows['sec_id'] . "' AND level1code='402'") as $row) {
                foreach ($db->query("SELECT * FROM level3 WHERE level2id='" . $row['lvl1_id'] . "'") as $rowxl) {
                    echo '<optgroup label="' . $rowxl['level2name'] . '">';
                    foreach ($db->query("SELECT * FROM level4 WHERE level3id='" . $rowxl['lvl2_id'] . "'") as $rowx) {
                        echo '<option value="' . $rowx['level3code'] . '">' . $rowx['level3name'] . '</option>';
                    }
                    echo '</optgroup>';
                }
            }
        }

    }

    public static function CODE_CHECKER(){
        $db = new DB();
        $code = explode(" ", static::$code);
        $returned = "";

        if ($code[1]) {
            foreach ($db->query("SELECT * FROM level3 WHERE level2code='" . static::$code . "'") as $row) {
                $coded1[] = $row['lvl2_id'];
                foreach ($db->query("SELECT * FROM level4 WHERE level3id='" . $row['lvl2_id'] . "'") as $rowl) {
                    $rips[] = $rowl['level3id'];
                }
            }
            if ($rips) {
                echo '<br>
                    <select onchange="" id="rtnvalues" class="selectpicker show-tick form-control" data-live-search="true">
                       <option value="">select Expense Account</option>';
                foreach ($db->query("SELECT * FROM level3 WHERE level2code='" . static::$code . "'") as $row) {
                    foreach ($db->query("SELECT * FROM level4 WHERE level3id='" . $row['lvl2_id'] . "'") as $rowdl) {
                        $dd[] = $rowdl['level3id'];
                        $codej[] = $rowdl['level3name'];
                        $codek[] = $rowdl['lvl3_id'];
                        $procode[] = $rowdl['level3code'];
                    }
                }
                for ($i = 0; $i <= count($dd); $i++) {
                    foreach ($db->query("SELECT * FROM level5 WHERE level4id='" . $codek[$i] . "'") as $rowd) {
                        $rip[] = $codek[$i];
                    }
                }
                for ($i = 0; $i <= count($dd); $i++) {
                    if (in_array($codek[$i], $rip)) {
                        echo '<optgroup label="' . $codej[$i] . '">';
                        foreach ($db->query("SELECT * FROM level5 WHERE level4id='" . $codek[$i] . "'") as $rowd) {
                            echo '<option value="' . $rowd['level4code'] . '">' . $rowd['level4name'] . '</option>';
                        }
                        echo '</optgroup>';
                    } else {
                        echo '<option value="' . $procode[$i] . '">' . $codej[$i] . '</option>';
                    }
                }
                echo '</select><br>';
            }
        }
    }

    public static function SAVE_EXPENSE(){
        $expense = new EXPENSES();  NOW_DATETIME::NOW();
        $data = explode("?::?",$_GET['saveexpense']);   session_start(); $db = new DB();
        $da = explode("/",$data[4]);
        $date = $da[2]."-".$da[0]."-".$da[1];
        $expense->expensecode = $data[0];
        $expense->paymode = $data[1];
        // if($data[6]){$expense->paydesc = $data[6];}
        $expense->slipno = $data[2];
        $expense->description = $data[5];
        $expense->paidamount = $data[3];
        $expense->boughtdate = $date;
        $expense->inserteddate = NOW_DATETIME::$Date_Time;
        $expense->handledby = $_SESSION['user_id'];
        $expense->status = "0";
		if($data[6]){
			$expense->expenseid = $data[6];
			foreach($db->query("SELECT * FROM expensestracs WHERE expenseid='".$data[6]."'") as $row){
				$addt = $row['paidamount'] - $data[3];
			}
			$expense->save();
			$db->query("UPDATE pettycash SET pettycashamt=pettycashamt + '".$addt."' WHERE pettyid='1'");
		}else{
			$expense->create();
			$db->query("UPDATE pettycash SET pettycashamt=pettycashamt-'".$data[3]."' WHERE pettyid='1'");
		}
        
		
        self::GET_TOTAL();
        self::CANCEL_EXPENSE();
        echo '|<><>|';
        echo '
                <div class="alert alert-success" style="background-color: #8bc34a">
                   <b style="font-weight: 900;font-size: 28px;color: #ffffff">Total Expenses:  &nbsp;&nbsp; '.number_format(EXPENSES::$tot).'</b>
                </div>
                <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr class="info">
                            <th width="20%">Date</th>
                            <th width="20%">Expense Account</th>
                            <th width="20%">Description</th>
                            <th width="50%">Amount</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    '; EXPENSES::GET_EXPENSES(); echo'
                    </tbody>
                </table>
        ';

    }

    public static function GET_TOTAL(){
        $db = new DB();  NOW_DATETIME::NOW();
        foreach ($db->query("SELECT SUM(paidamount) as totamt FROM expensestracs WHERE YEAR(boughtdate)='".NOW_DATETIME::$year."'") as $rowd){ self::$tot = $rowd['totamt']; }
    }

    public static function GET_EXPENSES(){
        $db = new DB(); NOW_DATETIME::NOW();
        foreach ($db->query("SELECT MAX(expenseid) as maxid FROM expensestracs") as $rowd){ $maxid = $rowd['maxid']; }
        foreach ($db->query("SELECT * FROM expensestracs ORDER BY boughtdate DESC") as $row){
            SECTIONS::$search_code = $row['expensecode'];
            SECTIONS::SEARCH_CODE();
            $date = explode(':',$row['inserteddate']);

            echo '<tr>';
            echo '<td width="15%" data-order="2017-00-00">'.$row['boughtdate'].'</td>';
            echo '<td width="25%">'.SECTIONS::$resultname.' <br><b>('.$row['expensecode'].')</b></td>';
            SECTIONS::$search_code = $row['paydesc'];
            SECTIONS::SEARCH_CODE();
            echo '<td width="40%">'.$row['description'].'<br>'.(($row['paymode']=="1")?"<b>".$row['slipno']."</b> &nbsp;&nbsp; <b>@ cash</b>":"<b>".$row['slipno']."</b> &nbsp;&nbsp; <b>@ bank -> ".SECTIONS::$resultname."</b>").'</td>';
            echo '<td width="15%"><b>'.number_format($row['paidamount']).'</b></td>';
			echo '<td width="15%">
					<button style="border:0;background-color:transparent;padding:0px" onclick="editexpenses('.$row['expenseid'].')"><i style="" class="fa fa-pencil fa-2x"></i></button>
					<button style="border:0;background-color:transparent;padding:0px" onclick="deleteexpenses('.$row['expenseid'].')"><i style="color: #cd332d" class="fa fa-trash fa-2x"></i></button>
				</td>';
            echo '</tr>';
        }
    }

    public static function CANCEL_EXPENSE(){
		VAULT_TRACS::GET_TOTAL1(); 
        echo '
			<div id="pettycash" hidden>'.VAULT_TRACS::$tot1.'</div>
			<div id="expenseid" hidden></div>
			<div class="alert alert-success" style="background-color: #00af6e">
			   <b style="font-weight: 900;font-size: 20px;color: #ffffff">Available Petty cash:  &nbsp;&nbsp; '.number_format(VAULT_TRACS::$tot1).'</b>
			</div>
            <label class="labelcolor">Expense Account</label>
            <select onchange="Returnedoption()" id="codereturn" class="selectpicker show-tick form-control" data-live-search="true">
                <option value="">select Expense Account</option>';
        EXPENSES::GET_EXPESEACCOUTS();
        echo'
            </select><br>
            <div id="returnedoptionss"></div>
            <label class="labelcolor">Cash Accounts</label>
            <select onchange="ReturnedCash()" id="cashoptions" class="form-control">
                <option value="">select Cash Account</option>
                <option value="1">Cash</option>
                <option value="3">Cheque</option>
            </select><br>
            <div id="returnedbanks"></div>
            <label class="labelcolor">Slip No./ Cheque No.</label>
            <input onclick="" id="slipno" type="number" class="form-control" placeholder="Enter Slip No. or Cheque No."><br>
            <label class="labelcolor">Item Description</label>
            <TextArea onclick="" id="itemdescription" type="text" class="form-control" placeholder="Enter Item Description"></TextArea><br>
            <label class="labelcolor">Transaction Amount</label>
            <input onclick="" id="transacamount" type="number" class="form-control" placeholder="Enter Transaction Amount"><br>
            <label class="labelcolor">Transaction Date</label>
            <input onclick="" id="datepicker1" type="text" class="form-control" placeholder="Enter Transaction Date"><br><br>
            <center>
                <button class="btn-primary btn" type="" onclick="SaveExpense()">Submit Expense</button>
                <button onclick="cancelexpense()" class="btn btn-default">Cancel</button>
            </center> <br><br>
        ';
    }

    public static function EDIT_EXPENSE(){
		$db = new DB();
		foreach($db->query("SELECT * FROM expensestracs WHERE expenseid='".$_GET['editexpensedata']."'") as $row){
			VAULT_TRACS::GET_TOTAL1(); 
			$dateint = new DateTime($row['boughtdate']);
			SECTIONS::$search_code = $row['expensecode'];
			SECTIONS::SEARCH_CODE();
			echo '
				<div id="pettycash" hidden>'.VAULT_TRACS::$tot1.'</div>
				<div id="expenseid" hidden>'.$_GET['editexpensedata'].'</div>
				<div class="alert alert-success" style="background-color: #00af6e">
				   <b style="font-weight: 900;font-size: 20px;color: #ffffff">Available Petty cash:  &nbsp;&nbsp; '.number_format(VAULT_TRACS::$tot1).'</b>
				</div>
				<label class="labelcolor">Expense Account</label>
				<select onchange="Returnedoption()" id="codereturn" class="selectpicker show-tick form-control" data-live-search="true">
					<option value="'.$row['expensecode'].'">'.SECTIONS::$resultname.'</option>
					<option value="">select Expense Account</option>';
					EXPENSES::GET_EXPESEACCOUTS();
			echo'
				</select><br>
				<div id="returnedoptionss"></div>
				<label class="labelcolor">Cash Accounts</label>
				<select onchange="ReturnedCash()" id="cashoptions" class="form-control">
				<option value="'.$row['paymode'].'">'.(($row['paymode']=="1")?"Cash":"Cheque").'</option>
					<option value="">select Cash Account</option>
					<option value="1">Cash</option>
					<option value="3">Cheque</option>
				</select><br>
				<div id="returnedbanks"></div>
				<label class="labelcolor">Slip No./ Cheque No.</label>
				<input  value="'.$row['slipno'].'" id="slipno" type="number" class="form-control" placeholder="Enter Slip No. or Cheque No."><br>
				<label class="labelcolor">Item Description</label>
				<TextArea onclick="" id="itemdescription" type="text" class="form-control" placeholder="Enter Item Description">'.$row['description'].'</TextArea><br>
				<label class="labelcolor">Transaction Amount</label>
				<input value="'.$row['paidamount'].'" id="transacamount" type="number" class="form-control" placeholder="Enter Transaction Amount"><br>
				<label class="labelcolor">Transaction Date</label>
				<input value="'.$dateint->format('m/d/Y').'" onclick="" id="datepicker1" type="text" class="form-control" placeholder="Enter Transaction Date"><br><br>
				<center>
					<button class="btn-primary btn" type="" onclick="SaveExpense()">Submit Expense</button>
					<button onclick="cancelexpense()" class="btn btn-default">Cancel</button>
				</center> <br><br>
			';
		}
    }
	public static function REMOVE_EXPENSE(){
		$db = new DB();
		$db->query("DELETE FROM expensestracs WHERE expenseid='".$_GET['deleteexpenseid']."'");
		self::GET_TOTAL();
        echo '
                <div class="alert alert-success" style="background-color: #8bc34a">
                   <b style="font-weight: 900;font-size: 28px;color: #ffffff">Total Expenses:  &nbsp;&nbsp; '.number_format(EXPENSES::$tot).'</b>
                </div>
                <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr class="info">
                            <th width="20%">Date</th>
                            <th width="20%">Expense Account</th>
                            <th width="20%">Description</th>
                            <th width="50%">Amount</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    '; EXPENSES::GET_EXPENSES(); echo'
                    </tbody>
                </table>
        ';

	}
	public static function GET_STATEMENT(){
		
		$data = explode("?::?",$_GET['expensereports']);
		if($data[0]=="1"){
			$db = new DB(); 
			echo'
				<table cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
					<thead>
						<tr>
							<th width="60%">Particulars</th>
							<th width="40%">Amount</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><b>NON-OPERATING EXPENDITURES</b></td>
							<td></td>
						</tr>';
						$ql = (($data[2]=="all")?"":" && MONTHNAME(boughtdate)='".$data[2]."'");
					foreach ($db->query("SELECT DISTINCT(expensecode) as expcode FROM expensestracs WHERE YEAR(boughtdate)='".$data[1]."'".$ql) as $rowh){
						SECTIONS::$search_code = $rowh['expcode'];
						SECTIONS::SEARCH_CODE();
						foreach ($db->query("SELECT SUM(paidamount) as amts FROM expensestracs WHERE expensecode='".$rowh['expcode']."' AND YEAR(inserteddate)='".$data[1]."'".$ql) as $row){}
						echo '
							<tr>
								<td>'.SECTIONS::$resultname.'</td>
								<td>'.number_format($row['amts']).'</td>
							</tr>
						';
					}
					foreach ($db->query("SELECT * FROM expensestracs WHERE YEAR(boughtdate)='".$data[1]."'".$ql) as $rowh1){
						$expense = $expense + $rowh1['paidamount'];
					}
					$prft = $income - $expense;
			echo'			<tr>
							<td><b>TOTAL EXPENDITURES</b></td>
							<td><b>'.number_format($expense).'</b></td>
						</tr>
					</tbody>
				</table>
		';
		}
		if($data[0]=="2"){
			$db = new DB(); 
			echo'
				<table cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
					<thead>
						<tr>
							<th width="60%">Particulars</th>
							<th width="40%">Amount</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><b>OPERATING EXPENDITURES</b></td>
							<td></td>
						</tr>';
						$ql = (($data[2]=="all")?"":" && MONTHNAME(boughtdate)='".$data[2]."'");
					foreach ($db->query("SELECT DISTINCT(expensecode) as expcode FROM expensestracs WHERE YEAR(boughtdate)='".$data[1]."'".$ql) as $rowh){
						SECTIONS::$search_code = $rowh['expcode'];
						SECTIONS::SEARCH_CODE();
						foreach ($db->query("SELECT SUM(paidamount) as amts FROM expensestracs WHERE expensecode='".$rowh['expcode']."' AND YEAR(inserteddate)='".$data[1]."'".$ql) as $row){}
						echo '
							<tr>
								<td>'.SECTIONS::$resultname.'</td>
								<td>'.number_format($row['amts']).'</td>
							</tr>
						';
					}
					foreach ($db->query("SELECT * FROM expensestracs WHERE YEAR(boughtdate)='".$data[1]."'".$ql) as $rowh1){
						$expense = $expense + $rowh1['paidamount'];
					}
					$prft = $income - $expense;
			echo'			<tr>
							<td><b>TOTAL EXPENDITURES</b></td>
							<td><b>'.number_format($expense).'</b></td>
						</tr>
					</tbody>
				</table>
		';
		}
		if($data[0]=="3"){
			$db = new DB(); 
			echo'
				<table cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
					<thead>
						<tr>
							<th width="60%">Particulars</th>
							<th width="40%">Amount</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><b>NON-OPERATING EXPENDITURES</b></td>
							<td></td>
						</tr>';
						$ql = (($data[2]=="all")?"":" && MONTHNAME(boughtdate)='".$data[2]."'");
					foreach ($db->query("SELECT DISTINCT(expensecode) as expcode FROM expensestracs WHERE YEAR(boughtdate)='".$data[1]."'".$ql) as $rowh){
						SECTIONS::$search_code = $rowh['expcode'];
						SECTIONS::SEARCH_CODE();
						foreach ($db->query("SELECT SUM(paidamount) as amts FROM expensestracs WHERE expensecode='".$rowh['expcode']."' AND YEAR(inserteddate)='".$data[1]."'".$ql) as $row){}
						echo '
							<tr>
								<td>'.SECTIONS::$resultname.'</td>
								<td>'.number_format($row['amts']).'</td>
							</tr>
						';
					}
					foreach ($db->query("SELECT * FROM expensestracs WHERE YEAR(boughtdate)='".$data[1]."'".$ql) as $rowh1){
						$expense = $expense + $rowh1['paidamount'];
					}
					$prft = $income - $expense;
			echo'			<tr>
							<td><b>TOTAL EXPENDITURES</b></td>
							<td><b>'.number_format($expense).'</b></td>
						</tr>
					</tbody>
				</table>
		';
		}
		
	}
}
class ASSETSMANAGEMENT extends database_crud{
    protected $table = "assets";
    protected $pk = "assetsid";
    //    SELECT `assetsid`, `assetcode`, `assetnumber`, `purchase_date`, `asset_description`, `asset_value`,
    //    `working_life`, `registration_date`, `handledby`, `years`, `valueby_year`, `depreciation_detail` FROM `assets` WHERE 1

    public static function GET_ASSETACCOUTS(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM sections WHERE seccode='LVL004'") as $rows) {
            foreach ($db->query("SELECT * FROM level2 WHERE level1id='" . $rows['sec_id'] . "' AND level1code='407' OR level1code='409'") as $row) {
                echo '<optgroup label="' . $row['level1name'] . '">';
                foreach ($db->query("SELECT * FROM level3 WHERE level2id='" . $row['lvl1_id'] . "' AND level2act='1'") as $rowx) {
                    echo '<option value="' . $rowx['level2code'] . '">' . $rowx['level2name'] . '</option>';
                }
                foreach ($db->query("SELECT * FROM level3 WHERE level2id='" . $row['lvl1_id'] . "' AND level2act='2'") as $rowe) {
                    foreach ($db->query("SELECT * FROM depreciation WHERE assetcode='".$rowe['level2code']."'") as $rowd){
                        echo '<option value="' . $rowe['level2code'] . '">' . $rowe['level2name'] . ' &nbsp;&nbsp;&nbsp;  ' .(($rowd['typecode']=="0")?' @ '.$rowd['rate'].'%':'')  . '</option>';
                    }


                }
                echo '</optgroup>';
            }
        }

    }
    public static function GET_ASSETACCOUTSDEPECITION(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM sections WHERE seccode='LVL004'") as $rows) {
            foreach ($db->query("SELECT * FROM level2 WHERE level1id='" . $rows['sec_id'] . "'") as $row) {
                echo '<optgroup label="' . $row['level1name'] . '">';
                foreach ($db->query("SELECT * FROM level3 WHERE level2act='2' AND level2id='" . $row['lvl1_id'] . "'") as $rowx) {
                    echo '<option value="' . $rowx['level2code'] . '">' . $rowx['level2name'] . '</option>';
                }
                echo '</optgroup>';
            }
        }

    }
    public static function SAVE_ASSET(){
        $assets = new ASSETSMANAGEMENT(); $db = new DB();
        NOW_DATETIME::NOW();        session_start(); $result = "";
		$datas1 = explode("?||?",$_GET['saveassets']);
        $data = explode("?::?",$datas1[1]);
        $da = explode("/",$data[2]);
        $date = $da[2]."-".$da[0]."-".$da[1];
        $assets->assetcode = $data[0];
        $assets->assetnumber = $data[1];
        $assets->purchase_date = $date;
        $assets->asset_description = $data[3];
        $assets->asset_value = $data[4];
        $assets->registration_date = NOW_DATETIME::$Date;
        $assets->handledby = $_SESSION['user_id'];
        $dateint = new DateTime($date);
		$datedata = "";
		$depamts = "";
		$depmt = "";
		$asstval = $data[4];
		foreach ($db->query("SELECT * FROM depreciation WHERE assetcode='".$data[0]."'") as $row){$res = $row['typecode'];}
			
			if($res=="0" || $res=="1"){
				if($res=="0"){
					
					if($data[5] !="nill"){
						for($i=1;$i<=$data[5];$i++){
							$dateint->add(new DateInterval('P1Y'));
							$depmt = ($data[4]-$data[6])/$data[5];
							$asstval -= $depmt;
							$datedata = $datedata .",".$dateint->format('Y-m-d');
							$depamts = $depamts .",". $asstval;
						}
					}else{
						
						$i = 1;
						for(;;){
							
							$depmt = ($row['rate']*$data[4])/100;
							$asstval -= $depmt;
							$dateint->add(new DateInterval('P1Y'));
							$datedata = $datedata .",".$dateint->format('Y-m-d');
							$depamts = $depamts .",". $asstval;
							if($asstval <= 0){
								break;
							}
							
						}
					}
				   
				}else{
					for($i=1;$i<=$data[5];$i++){
						$dateint->add(new DateInterval('P1Y'));
						$depmt = ($data[4]-$data[6])/$data[5];
						$asstval -= $depmt;
						$datedata = $datedata .",".$dateint->format('Y-m-d');
						$depamts = $depamts .",". $asstval;
						
					}
				}
			}else{

			}
		$assets->working_life = $data[5];
		$assets->scrapvalue = $data[6];
		$assets->years = $datedata;
		$assets->valueby_year  = $depamts;
		$assets->depreciation_detail  = $depmt;
		// echo $datedata.'<br>'.$depamts.'<br>'.$depmt.'<br>'.$date;
		if($datas1[0]){
			$assets->assetsid = $datas1[0];
			$assets->save();
		}else{
			$assets->create();
		}
        
        self::CANCELASSETS();
        echo '|<><>|';
        echo '
            <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr class="info">
                        <th width="30%">Asset Account</th>
                        <th width="40%">Asset Description</th>
                        <th width="25%">Asset Value</th>
                        <th width="5%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                '; ASSETSMANAGEMENT::ASSETLIST(); echo'
                </tbody>
            </table>
        ';

    }
    public static function ASSETLIST(){
        $db = new DB();
		foreach ($db->query("SELECT MAX(assetsid) as maxid FROM assets") as $rowd){ $maxid = $rowd['maxid']; }
        foreach($db->query("SELECT * FROM assets ORDER BY assetsid DESC") as $row){
            SECTIONS::$search_code = $row['assetcode'];
            SECTIONS::SEARCH_CODE();
			$date = explode(":",$row['registration_date']);
            echo "<tr>";
            echo "<td width='30%' data-order='1'>".SECTIONS::$resultname."  <b>(".$row['assetcode'].")</b><br>Asset Number: <b>".$row['assetnumber']."</b></td>";
            echo "<td width='40%'>".$row['asset_description']."<br>Purchase Date: <b>".$row['purchase_date']."</b></td>";
            echo "<td width='15%'><b>".number_format($row['asset_value'])."</b></td>";
            echo '<td width="15%">
                        <button style="border:0;background-color:transparent;padding:0px" onclick="assetschedule('.$row['assetsid'].')" data-target="#scheduleassetmodal" data-toggle="modal"><i style="color: #2053ac" class="fa fa-eye fa-2x"></i></button>
                        <button style="border:0;background-color:transparent;padding:0px" '.(($maxid==$row['assetsid'])?((NOW_DATETIME::$Date != $date[0])?'disabled':''):'disabled').' onclick="GetAssetTracs('.$row['assetsid'].')"><i style="" class="fa fa-pencil fa-2x"></i></button>
                        <button style="border:0;background-color:transparent;padding:0px" '.(($maxid==$row['assetsid'])?((NOW_DATETIME::$Date != $date[0])?'disabled':''):'disabled').' onclick="DeleteAssetTracs('.$row['assetsid'].')"><i style="color: #cd332d" class="fa fa-trash fa-2x"></i></button>
                    </td>';
            echo "</tr>";
        }
    }
    public static function DELETEASSET(){
            $db = new DB();
            $db->query("DELETE FROM assets WHERE assetsid='".$_GET['deleteassettracs']."'");
            self::CANCELASSETS();
    echo '|<><>|';
    echo '
        <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
            <thead>
                <tr class="info">
                    <th width="30%">Asset Account</th>
                    <th width="40%">Asset Description</th>
                    <th width="25%">Asset Value</th>
                    <th width="5%">Actions</th>
                </tr>
            </thead>
            <tbody>
            '; ASSETSMANAGEMENT::ASSETLIST(); echo'
            </tbody>
        </table>
    ';
    }
    public static function GET_ASSETTYPE(){
		$db = new DB();
		foreach($db->query("SELECT * FROM depreciation WHERE assetcode = '".$_GET['getassetype']."'") as $row){}
		if($row['assetcode']){
			if($row['typecode']=="1"){
				echo '<div hidden id="typecode">1</div>
					<label class="labelcolor">Scrap Value</label>
                    <input id="scrapvalue" type="text" class="form-control" placeholder="Enter Scrap Value"><br>
					<label class="labelcolor">Estimated Working Life</label>
                    <input id="workinglife" type="text" class="form-control" placeholder="Enter Estimated Working Life"><br>
				';
			}else{
				echo '<div hidden id="typecode">0</div>
					<b>Depreciation Creteria</b><br><br>
					<table>
						<tr>
							<td><input onchange="depreciationcreteria()" id="yesacc" value="1" name="optionadiosInline"  type="radio"></td>
							<td>&nbsp;Working Life&nbsp;&nbsp;&nbsp;</td>
							<td><input disabled id="workinglife" type="text" class="form-control" placeholder="Enter Estimated Working Life"></td>
						</tr>
						<tr>
							<td><input onchange="depreciationcreteria()" id="noacc" value="0" name="optionadiosInline"  type="radio"></td>
							<td>&nbsp;Until Zero.</td>
						</tr>
					</table><br><br>
				';
			}
		}else{
			echo "";
		}
	}
    public static function CANCELASSETS(){
        SYS_CODES::ASSET_NO();
        echo '
			<div id="asseteditid"></div>
            <label class="labelcolor">Asset Account</label>
            <select onchange="getassettype()" id="assetaccountid" class="selectpicker show-tick form-control" data-live-search="true">
                <option value="">select Asset Account</option>';
        ASSETSMANAGEMENT::GET_ASSETACCOUTS();
        echo'
            </select><br>
            <div id="returnedoptionss"></div>
            <label class="labelcolor">Asset Number</label>
            <input disabled onclick="" value="'.SYS_CODES::$assetno.'" style="font-weight: bold" id="assetnumber" type="text" class="form-control"><br>
            <label class="labelcolor">Purchase Date</label>
            <input onclick="" id="datepicker1" type="" class="form-control" placeholder="Enter Purchase Date"><br>
            <label class="labelcolor">Asset Description</label>
            <TextArea onclick="" id="assetdescription" type="text" class="form-control" placeholder="Enter Item Description"></TextArea><br>
            <label class="labelcolor">Asset Purchased Value</label>
            <input onclick="" id="assetvalue" type="" class="form-control" placeholder="Enter Asset Value"><br>
            <div id="assettypecheck"></div>
            <center>
                <button class="btn-primary btn" type="" onclick="SaveAsset()" >Submit Assets</button>
                <button onclick="cancelAssets()" class="btn btn-default" >Cancel</button>
            </center> <br><br>
        ';
    }
    public static function ASSETDATA(){
            $db = new DB();
            foreach($db->query("SELECT * FROM assets WHERE assetsid='".$_GET['getassettracs']."'") as $row){
                    SYS_CODES::ASSET_NO();
                    $dateint = new DateTime($row['purchase_date']);
                    SECTIONS::$search_code = $row['assetcode'];
                    SECTIONS::SEARCH_CODE();
                    echo '
                            <div hidden id="asseteditid">'.$row['assetsid'].'</div>
                            <label class="labelcolor">Asset Account</label>
                            <select onchange="getassettype()" id="assetaccountid" class="selectpicker show-tick form-control" data-live-search="true">
                                    <option value="'.$row['assetcode'].'">'.SECTIONS::$resultname.'</option>
                                    <option value="">select Asset Account</option>';
                                    ASSETSMANAGEMENT::GET_ASSETACCOUTS();
                    echo'
                            </select><br>
                            <div id="returnedoptionss"></div>
                            <label class="labelcolor">Asset Number</label>
                            <input disabled onclick="" value="'.$row['assetnumber'].'" style="font-weight: bold" id="assetnumber" type="text" class="form-control"><br>
                            <label class="labelcolor">Purchase Date</label>
                            <input value="'.$dateint->format('m/d/Y').'" id="datepicker1" type="" class="form-control" placeholder="Enter Purchase Date"><br>
                            <label class="labelcolor">Asset Description</label>
                            <TextArea onclick="" id="assetdescription" type="text" class="form-control" placeholder="Enter Item Description">'.$row['asset_description'].'</TextArea><br>
                            <label class="labelcolor">Asset Purchased Value</label>
                            <input value="'.$row['asset_value'].'" id="assetvalue" type="" class="form-control" placeholder="Enter Asset Value"><br>
                            <div id="assettypecheck">';
                                    foreach($db->query("SELECT * FROM depreciation WHERE assetcode = '".$row['assetcode']."'") as $rowx){}
                                    if($rowx['assetcode']){
                                            if($rowx['typecode']=="1"){
                                                    echo '<div hidden id="typecode">1</div>
                                                            <label class="labelcolor">Scrap Value</label>
                                                            <input value="'.$row['scrapvalue'].'" id="scrapvalue" type="text" class="form-control" placeholder="Enter Scrap Value"><br>
                                                            <label class="labelcolor">Estimated Working Life</label>
                                                            <input value="'.$row['working_life'].'" id="workinglife" type="text" class="form-control" placeholder="Enter Estimated Working Life"><br>
                                                    ';
                                            }else{
                                                    echo '<div hidden id="typecode">0</div>
                                                            <b>Depreciation Creteria</b><br><br>
                                                            <table>
                                                                    <tr>
                                                                            <td><input '.(($row['working_life']=="nill")?"":"checked").' onchange="depreciationcreteria()" id="yesacc" value="1" name="optionadiosInline"  type="radio"></td>
                                                                            <td>&nbsp;Working Life&nbsp;&nbsp;&nbsp;</td>
                                                                            <td><input '.(($row['working_life']=="nill")?"disabled":"").' value="'.(($row['working_life']=="nill")?"":$row['working_life']).'"  id="workinglife" type="text" class="form-control" placeholder="Enter Estimated Working Life"></td>
                                                                    </tr>
                                                                    <tr>
                                                                            <td><input '.(($row['working_life']=="nill")?"checked":"").' onchange="depreciationcreteria()" id="noacc" value="0" name="optionadiosInline"  type="radio"></td>
                                                                            <td>&nbsp;Until Zero.</td>
                                                                    </tr>
                                                            </table><br><br>
                                                    ';
                                            }
                                    }else{
                                            echo "";
                                    }
                    echo'	
                            </div>
                            <center>
                                    <button class="btn-primary btn" type="" onclick="SaveAsset()" >Submit Assets</button>
                                    <button onclick="cancelAssets()" class="btn btn-default" >Cancel</button>
                            </center> <br><br>
                    ';
            }
    }
    public static function ASSETCHART(){
        $db = new DB();
        echo '
        <div class="row">
            <div class="col-md-12">
                <button style="margin-right:2em;" onclick="printAssetChart()" class="btn btn-social btn-facebook pull-right">
                    <i class="ti ti-printer"></i>
                    &nbsp;&nbsp;Print
                </button>
            </div>
        <div id="assetchartdata">
        <div class="col-md-5">
            <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr class="info">
                        <th width="30%">Date</th>
                        <th width="40%">Asset Value</th>
                    </tr>    
                </thead>
                <tbody>
        ';
        foreach($db->query("SELECT * FROM assets WHERE assetsid='".$_GET['assetschedule']."'") as $row){}
        $depdate = explode(",",$row['years']);
        $assetval = explode(",",$row['valueby_year']);

        $actdate = "";
        $currentassetvalue = "0";
        $Accudepreciation = $row['depreciation_detail'];

        echo '
            <tr>
                <td style="color: '.$color.'"><b>'.$row['purchase_date'].'</b></td>
                <td style="color: '.$color.'">'.number_format($row['asset_value']).'</td>
            </tr>
        ';

        for($i = 1;$i < count($depdate); $i++ ){
            NOW_DATETIME::NOW();
            $datadate = explode("-",$depdate[$i]);
            if($datadate[0] == NOW_DATETIME::$year){
                    $dateint = new DateTime($depdate[$i]);
                    $dateint->add(new DateInterval('P1Y'));
                    $actdate = $dateint->format('Y-m-d');
            }
            if($depdate[$i] >= NOW_DATETIME::$Date && $depdate[$i] < $actdate){
                $color = "red";
                $actdate = "";
                $currentassetvalue = $assetval[$i];
            }else if($depdate[$i] == $actdate){
                $color = "red";
                $actdate = "";
                $currentassetvalue = $assetval[$i];
            }else{
                $color = "";
            }
            if($depdate[$i] >= NOW_DATETIME::$Date && $depdate[$i] < $actdate){
                if($currentassetvalue >= $assetval[$i]){}else{$Accudepreciation += $row['depreciation_detail'];}
            }else if($depdate[$i] == $actdate){
                if($currentassetvalue >= $assetval[$i]){}else{$Accudepreciation += $row['depreciation_detail'];}
            }else{
                if($currentassetvalue >= $assetval[$i]){}else{$Accudepreciation += $row['depreciation_detail'];}
            }
            echo '<tr>';
            echo '<td style="color: '.$color.'"><b>'.$depdate[$i].'</b></td>';
            echo '<td style="color: '.$color.'">'.((!empty($color))?"<b>".(($assetval[$i] < "0")?"0":number_format($assetval[$i]))."</>":(($assetval[$i] < "0")?"0":number_format($assetval[$i]))).'</b></td>';
            echo '</tr>';
        }
        echo '
            </tbody>
        </table>
        </div>
        <div class="col-md-7">
            <table>
                <tr>
                    <td><b>Asset Number</b></td>
                    <td>  &nbsp;'.$row['assetnumber'].'</td>
                </tr>
                <tr>
                    <td><b>Asset Description</b></td>
                    <td>  &nbsp;'.$row['asset_description'].'</td>
                </tr>
            </table>
            <br><br>
            <table>
                <tr>
                    <td><b>Depreciation Amount</b></td>
                    <td>  &nbsp;&nbsp;'.number_format($row['depreciation_detail']).'<b>&nbsp;@ per annum</b></td>
                </tr>
                <tr>
                    <td><b>Current Asset Value</b></td>
                    <td>  &nbsp;<b style="font-family:New Courier;font-weight:800;font-size: 24">'.number_format($currentassetvalue).'</b></td>
                </tr>
                <tr>
                    <td><b>Accumulated Depreciation</b></td>
                    <td>  &nbsp;<b style="font-family:New Courier;font-weight:800;font-size: 24">'.number_format($Accudepreciation).'</b></td>
                </tr>
            </table>
        </div>
        </div>
    </div>';
    }
}
class CREDITPURCHASE extends database_crud{
    protected $table = "credit_purchase";
    protected $pk = "pcreditid";
//    SELECT `pcreditid`, `creditor_name`, `purchase_date`, `asset_description`, `qty`,
// `totalamount`, `paidamount`, `payableamount`, `handledby`, `inserteddate` FROM `credit_purchase` WHERE 1

    public static function GET_ASSETACCOUTS(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM sections WHERE seccode='LVL005'") as $rows) {
            foreach ($db->query("SELECT * FROM level2 WHERE level1id='" . $rows['sec_id'] . "'") as $row) {
                echo '<optgroup label="' . $row['level1name'] . '">';
                foreach ($db->query("SELECT * FROM level3 WHERE level2id='" . $row['lvl1_id'] . "' AND level2act='1'") as $rowx) {
                    echo '<option value="' . $rowx['level2code'] . '">' . $rowx['level2name'] . '</option>';
                }
                foreach ($db->query("SELECT * FROM level3 WHERE level2id='" . $row['lvl1_id'] . "' AND level2act='2'") as $rowe) {
                    foreach ($db->query("SELECT * FROM depreciation WHERE assetcode='".$rowe['level2code']."'") as $rowd){
                        echo '<option value="' . $rowe['level2code'] . '">' . $rowe['level2name'] . '</option>';
                    }


                }
                echo '</optgroup>';
            }
        }

    }
    public static function GET_ASSETACCOUTSDEPECITION(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM sections WHERE seccode='LVL004'") as $rows) {
            foreach ($db->query("SELECT * FROM level2 WHERE level1id='" . $rows['sec_id'] . "'") as $row) {
                echo '<optgroup label="' . $row['level1name'] . '">';
                foreach ($db->query("SELECT * FROM level3 WHERE level2act='2' AND level2id='" . $row['lvl1_id'] . "'") as $rowx) {
                    echo '<option value="' . $rowx['level2code'] . '">' . $rowx['level2name'] . '</option>';
                }
                echo '</optgroup>';
            }
        }

    }
    public static function SAVE_CREDITPURCHASE(){
        $purchasecredit = new CREDITPURCHASE(); $db = new DB();
        NOW_DATETIME::NOW();        session_start(); $result = "";
        $data = explode("?::?",$_GET['savecreditpurchase']);
        $da = explode("/",$data[2]);
        $date = $da[2]."-".$da[0]."-".$da[1];
        $purchasecredit->accountcode = $data[0];
        $purchasecredit->creditor_name = $data[1];
        $purchasecredit->purchase_date = $date;
        $purchasecredit->asset_description = $data[3];
        $purchasecredit->qty = $data[4];
        $purchasecredit->totalamount = $data[5];
        $purchasecredit->paidamount = $data[6];
        $purchasecredit->payableamount = $data[7];
        $purchasecredit->inserteddate = NOW_DATETIME::$Date_Time;
        $purchasecredit->handledby = $_SESSION['user_id'];
        $purchasecredit->create();
        self::CANCELPURCHASECREDIT();
        echo '|<><>|';
        echo '
            <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr class="info">
                        <th width="30%">Account Name</th>
                        <th width="40%">Item Description</th>
                        <th width="25%">Payment Detail</th>
                        <th width="5%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                '; self::ASSETLIST(); echo'
                </tbody>
            </table>
        ';

    }
    public static function ASSETLIST(){
        $db = new DB();
        foreach($db->query("SELECT * FROM credit_purchase ORDER BY pcreditid DESC") as $row){
            SECTIONS::$search_code = $row['accountcode'];
            SECTIONS::SEARCH_CODE();
            echo "<tr>";
            echo "<td data-order='1'>".SECTIONS::$resultname."  <b>(".$row['accountcode'].")</b></b><br>Creditor : <b>".$row['creditor_name']."</b></td>";
            echo "<td>".$row['asset_description']."<br>Purchase Date: <b>".$row['purchase_date']."</b><br>QTY : <b> ".$row['qty']."</b></td>";
            echo "<td>Total : <b>".number_format($row['totalamount'])."</b>
                    <br>Paid : <b>".number_format($row['paidamount'])."</b><br>Payable : <b>".number_format($row['payableamount'])."</b><br></td>";
            echo "<td></td>";
            echo "</tr>";
        }
    }
    public static function CANCELPURCHASECREDIT(){
        //SYS_CODES::ASSET_NO();
        echo '
			<label class="labelcolor">
				<input onclick="findassetpayable()" id="assestcheck" style="" type="checkbox">
				Can this Payable be taken as an Asset?
			</label><br>
			<div id="findassetpayable"></div>
            <label class="labelcolor">Account Name</label>
            <select onchange="getassettype()" id="assetaccountid1" class="selectpicker show-tick form-control" data-live-search="true">
                <option value="">select Account Name</option>';
			CREDITPURCHASE::GET_ASSETACCOUTS();
        echo'
            </select><br>
            <label class="labelcolor">Cash Accounts</label>
            <select onchange="ReturnedCash()" id="cashoptions" class="form-control">
                <option value="">select Cash Account</option>
                <option value="1">Cash at Hand</option>
                <option value="3">Cash at Bank (Cheque)</option>
            </select><br>
            <div id="returnedbanks"></div>
            <label class="labelcolor">Creditors Name</label>
            <input onclick="" id="creditorsname" type="text" class="form-control" placeholder="Enter Creditors Name"><br>
            <label class="labelcolor">Purchase Date</label>
            <input onclick="" id="datepicker1" type="" class="form-control" placeholder="Enter Purchase Date"><br>
            <label class="labelcolor">Item Description</label>
            <TextArea onclick="" id="assetdesc" type="text" class="form-control" placeholder="Enter Item Description"></TextArea><br>
            <div id="returnedoptionss"></div>
            <div class="col-md-6">
            <label class="labelcolor">Quantity</label>
            <input onclick="" placeholder="Enter Quantity" id="qty" type="number" class="form-control"><br>
            </div>
            <div class="col-md-6">
            <label class="labelcolor">Total Amount</label>
            <input onclick="" id="amount" type="number" class="form-control" placeholder="Enter Total Amount"><br>
            </div>
            <div class="col-md-6">
            <label class="labelcolor">Amount Paid</label>
            <input onclick="" placeholder="Enter Amount Paid" id="amtpaid" type="number" class="form-control"><br>
            </div>
            <div class="col-md-6">
            <label class="labelcolor">Amount Payable</label>
            <input onclick="" id="amtpayable" type="number" class="form-control" placeholder="Enter Amount Payable"><br>
            </div>
            <center>
                <button class="btn-primary btn" type="" onclick="SaveCreditPurchase()" >Submit Asset Purchase</button>
                <button onclick="cancelCreditPurchase()" class="btn btn-default" >Cancel</button>
            </center> <br><br>
        ';
    }

}
class CREDITSALE extends database_crud{
    protected $table = "credit_sale";
    protected $pk = "screditid";
//    SELECT `screditid`, `accountcode`, `debitor_name`, `sale_date`, `asset_description`,
// `qty`, `totalamount`, `rcvamount`, `receivableamount`, `handledby`, `inserteddate` FROM `credit_sale` WHERE 1
	public static $code;
	
    public static function GET_ASSETACCOUTS(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM sections WHERE seccode='LVL004'") as $rows) {
            foreach ($db->query("SELECT * FROM level2 WHERE level1id='" . $rows['sec_id'] . "' AND level1code='406' OR level1code='408'") as $row) {
                echo '<optgroup label="' . $row['level1name'] . '">';
                foreach ($db->query("SELECT * FROM level3 WHERE level2id='" . $row['lvl1_id'] . "' AND level2act='1'") as $rowx) {
                    echo '<option value="' . $rowx['level2code'] . '">' . $rowx['level2name'] . '</option>';
                }
                foreach ($db->query("SELECT * FROM level3 WHERE level2id='" . $row['lvl1_id'] . "' AND level2act='2'") as $rowe) {
                    foreach ($db->query("SELECT * FROM depreciation WHERE assetcode='".$rowe['level2code']."'") as $rowd){
                        echo '<option value="' . $rowe['level2code'] . '">' . $rowe['level2name'] . '</option>';
                    }
                }
                echo '</optgroup>';
            }
        }

    }
    public static function GET_ASSETACCOUTSDEPECITION(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM sections WHERE seccode='LVL004'") as $rows) {
            foreach ($db->query("SELECT * FROM level2 WHERE level1id='" . $rows['sec_id'] . "'") as $row) {
                echo '<optgroup label="' . $row['level1name'] . '">';
                foreach ($db->query("SELECT * FROM level3 WHERE level2act='2' AND level2id='" . $row['lvl1_id'] . "'") as $rowx) {
                    echo '<option value="' . $rowx['level2code'] . '">' . $rowx['level2name'] . '</option>';
                }
                echo '</optgroup>';
            }
        }

    }
    public static function SAVE_CREDITSALE(){
        $purchasecredit = new CREDITSALE(); $db = new DB();
        NOW_DATETIME::NOW();        session_start(); $result = "";
        $data = explode("?::?",$_GET['savecreditsale']);
        $da = explode("/",$data[2]);
        $date = $da[2]."-".$da[0]."-".$da[1];
        $purchasecredit->accountcode = $data[0];
        $purchasecredit->debitor_name = $data[1];
        $purchasecredit->sale_date = $date;
        $purchasecredit->asset_description = $data[3];
        $purchasecredit->qty = $data[4];
        $purchasecredit->totalamount = $data[5];
        $purchasecredit->rcvamount = $data[6];
        $purchasecredit->receivableamount = $data[7];
        $purchasecredit->inserteddate = NOW_DATETIME::$Date_Time;
        $purchasecredit->handledby = $_SESSION['user_id'];
        $purchasecredit->create();
        self::CANCELSALECREDIT();
        echo '|<><>|';
        echo '
            <table id="example" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr class="info">
                        <th width="30%">Account Name</th>
                        <th width="40%">Item Description</th>
                        <th width="25%">Payment Detail</th>
                        <th width="5%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                '; self::ASSETLIST(); echo'
                </tbody>
            </table>
        ';

    }
    public static function ASSETLIST(){
        $db = new DB();
        foreach($db->query("SELECT * FROM credit_sale ORDER BY screditid DESC") as $row){
            SECTIONS::$search_code = $row['accountcode'];
            SECTIONS::SEARCH_CODE();
            echo "<tr>";
            echo "<td data-order='1'>".SECTIONS::$resultname."  <b>(".$row['accountcode'].")</b></b><br>Debitor : <b>".$row['debitor_name']."</b></td>";
            echo "<td>".$row['asset_description']."<br>Sale Date: <b>".$row['sale_date']."</b><br>QTY : <b> ".$row['qty']."</b></td>";
            echo "<td>Total : <b>".number_format($row['totalamount'])."</b>
                    <br>Received : <b>".number_format($row['rcvamount'])."</b><br>Receiveable : <b>".number_format($row['receivableamount'])."</b><br></td>";
            echo "<td></td>";
            echo "</tr>";
        }
    }
    public static function CANCELSALECREDIT(){
        SYS_CODES::ASSET_NO();
        echo '
            <label class="labelcolor">Account Name</label>
			<select onchange="getreceiveable()" id="receiveableid" class="selectpicker show-tick form-control" data-live-search="true">
				<option value="">select Account Name</option>';
				CREDITSALE::GET_ASSETACCOUTS();
			echo'
			</select><br>
			<div id="assettypecheck"></div>
            <label class="labelcolor">Cash Accounts</label>
            <select onchange="ReturnedCash()" id="cashoptions" class="form-control">
                <option value="">select Cash Account</option>
                <option value="1">Cash at Hand</option>
                <option value="3">Cash at Bank (Cheque)</option>
            </select><br>
            <div id="returnedbanks"></div>
            <label class="labelcolor">Debitors Name</label>
            <input onclick="" id="debitorname" type="text" class="form-control" placeholder="Enter Debitors Name"><br>
            <label class="labelcolor">Sales Date</label>
            <input onclick="" id="datepicker2" type="" class="form-control" placeholder="Enter Sales Date"><br>
            <label class="labelcolor">Item Description</label>
            <TextArea onclick="" id="assetdesc1" type="text" class="form-control" placeholder="Enter Item Description"></TextArea><br>
            <div id="returnedoptionss"></div>
            <div class="col-md-6">
            <label class="labelcolor">Quantity</label>
            <input onclick="" placeholder="Enter Quantity" id="qty1" type="number" class="form-control"><br>
            </div>
            <div class="col-md-6">
            <label class="labelcolor">Total Amount</label>
            <input onclick="" id="amount1" type="number" class="form-control" placeholder="Enter Total Amount"><br>
            </div>
            <div class="col-md-6">
            <label class="labelcolor">Amount Received</label>
            <input onclick="" placeholder="Enter Amount Received" id="rcvamt" type="number" class="form-control"><br>
            </div>
            <div class="col-md-6">
            <label class="labelcolor">Amount Receiveable</label>
            <input onclick="" id="amtrcvable" type="number" class="form-control" placeholder="Enter Amount Receivable"><br>
            </div>
            <center>
                <button class="btn-primary btn" type="" onclick="SaveCreditSale()" >Submit Credit Sale</button>
                <button onclick="cancelCreditSale()" class="btn btn-default" >Cancel</button>
            </center> <br><br>
        ';
    }
	
    public static function CODE_CHECKER(){
        $db = new DB();
        $code = explode(" ", static::$code);
        $returned = "";

        if ($code[1]) {
            foreach ($db->query("SELECT * FROM level3 WHERE level2code='" . static::$code . "'") as $row) {
                $coded1[] = $row['lvl2_id'];
                foreach ($db->query("SELECT * FROM level4 WHERE level3id='" . $row['lvl2_id'] . "'") as $rowl) {
                    $rips[] = $rowl['level3id'];
                }
            }
            if ($rips) {
                echo '<br>
                    <select onchange="" id="rtnvalues" class="selectpicker show-tick form-control" data-live-search="true">
                       <option value="">select Account</option>';
                foreach ($db->query("SELECT * FROM level3 WHERE level2code='" . static::$code . "'") as $row) {
                    foreach ($db->query("SELECT * FROM level4 WHERE level3id='" . $row['lvl2_id'] . "'") as $rowdl) {
                        $dd[] = $rowdl['level3id'];
                        $codej[] = $rowdl['level3name'];
                        $codek[] = $rowdl['lvl3_id'];
                        $procode[] = $rowdl['level3code'];
                    }
                }
                for ($i = 0; $i <= count($dd); $i++) {
                    foreach ($db->query("SELECT * FROM level5 WHERE level4id='" . $codek[$i] . "'") as $rowd) {
                        $rip[] = $codek[$i];
                    }
                }
                for ($i = 0; $i <= count($dd); $i++) {
                    if (in_array($codek[$i], $rip)) {
                        echo '<optgroup label="' . $codej[$i] . '">';
                        foreach ($db->query("SELECT * FROM level5 WHERE level4id='" . $codek[$i] . "'") as $rowd) {
                            echo '<option value="' . $rowd['level4code'] . '">' . $rowd['level4name'] . '</option>';
                        }
                        echo '</optgroup>';
                    } else {
                        echo '<option value="' . $procode[$i] . '">' . $codej[$i] . '</option>';
                    }
                }
                echo '</select><br>';
            }
        }
    }

}
class INCOMETRAIL extends database_crud{
    protected $table = "incometrail";
    protected $pk = "incomeid";
//    SELECT `incomeid`, `accountcode`, `income_date`, `income_description`, `slipno`,
// `amount`, `inserted_date`, `handledby` FROM `incometrail` WHERE 1

    public static function GET_INCOMEACCOUTS(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM sections WHERE seccode='LVL003'") as $rows) {
            foreach ($db->query("SELECT * FROM level2 WHERE level1id='" . $rows['sec_id'] . "' AND level1code='302'") as $row) {
                echo '<optgroup label="' . $row['level1name'] . '">';
				$rip = array();
				foreach ($db->query("SELECT * FROM level3 WHERE level2act='1' AND level2id='" . $row['lvl1_id'] . "'") as $rowx) {
					echo '<option value="' . $rowx['level2code'] . '">' . $rowx['level2name'] . '</option>';
				}
				echo '</optgroup>';
            }
        }

    }
    public static function GET_ASSETACCOUTSDEPECITION(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM sections WHERE seccode='LVL004'") as $rows) {
            foreach ($db->query("SELECT * FROM level2 WHERE level1id='" . $rows['sec_id'] . "'") as $row) {
                echo '<optgroup label="' . $row['level1name'] . '">';
                foreach ($db->query("SELECT * FROM level3 WHERE level2act='2' AND level2id='" . $row['lvl1_id'] . "'") as $rowx) {
                    echo '<option value="' . $rowx['level2code'] . '">' . $rowx['level2name'] . '</option>';
                }
                echo '</optgroup>';
            }
        }

    }
    public static function SAVE_INCOME(){
        $purchasecredit = new INCOMETRAIL(); $db = new DB();
        NOW_DATETIME::NOW();        session_start(); $result = "";
        $data = explode("?::?",$_GET['saveincometrail']);
        $da = explode("/",$data[2]);
        $date = $da[2]."-".$da[0]."-".$da[1];
        $purchasecredit->accountcode = $data[0];
        $purchasecredit->slipno = $data[1];
        $purchasecredit->income_description = $data[3];
        $purchasecredit->amount = $data[4];
        $purchasecredit->income_date = $date;
        $purchasecredit->inserted_date = NOW_DATETIME::$Date_Time;
        $purchasecredit->handledby = $_SESSION['user_id'];
		if($data[5]){
			$purchasecredit->incomeid = $data[5];
			$purchasecredit->save();
		}else{
			$purchasecredit->create();
		}
        self::CANCELINCOME();
        echo '|<><>|';
        echo '
            <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr class="info">
                        <th width="30%">Account Name</th>
                        <th width="40%">Income Description</th>
                        <th width="25%">Payment Detail</th>
                        <th width="5%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                '; self::INCOMELIST(); echo'
                </tbody>
            </table>
        ';

    }
    public static function INCOMELIST(){
        $db = new DB();
        foreach($db->query("SELECT * FROM incometrail ORDER BY incomeid DESC") as $row){
            SECTIONS::$search_code = $row['accountcode'];
            SECTIONS::SEARCH_CODE();
            echo "<tr>";
            echo "<td data-order='1'>".SECTIONS::$resultname."  <b>(".$row['accountcode'].")</b></b></td>";
            echo "<td>".$row['income_description']."<br>Income Date: <b>".$row['income_date']."</b><br>Slip No : <b> ".$row['slipno']."</b></td>";
            echo "<td>Total Amount : <b>".number_format($row['amount'])."</b></td>";
            echo '<td width="15%">
					<button style="border:0;background-color:transparent;padding:0px" onclick="editincome('.$row['incomeid'].')"><i style="" class="fa fa-pencil fa-2x"></i></button>
					<button style="border:0;background-color:transparent;padding:0px" onclick="deleteincome('.$row['incomeid'].')"><i style="color: #cd332d" class="fa fa-trash fa-2x"></i></button>
				</td>';
            echo "</tr>";
        }
    }
    public static function CANCELINCOME(){
        echo '
	    <div hidden id="incomeedditdata"></div>
            <label class="labelcolor">Account Name</label>
            <select onchange="getassettype()" id="incomeaccount" class="selectpicker show-tick form-control" data-live-search="true">
                <option value="">select Account Name</option>';
        INCOMETRAIL::GET_INCOMEACCOUTS();
        echo'
            </select><br>
            <label class="labelcolor">Cash Accounts</label>
            <select onchange="ReturnedCash()" id="cashoptions" class="form-control">
                <option value="">select Cash Account</option>
                <option value="1">Cash</option>
                <option value="3">Cheque</option>
            </select><br>
            <div id="returnedbanks"></div>
            <label class="labelcolor">Receipt No/ Cheque No</label>
            <input onclick="" id="slipno" type="text" class="form-control" placeholder="Enter Receipt No/ Cheque No"><br>
            <label class="labelcolor">Transaction Date</label>
            <input onclick="" id="datepicker1" type="" class="form-control" placeholder="Enter Transaction Date"><br>
            <label class="labelcolor">Income Description</label>
            <TextArea onclick="" id="incomedesc" type="text" class="form-control" placeholder="Enter Income Description"></TextArea><br>
            <div id="returnedoptionss"></div>
            <label class="labelcolor">Amount Received</label>
            <input onclick="" id="amtrcvd" type="text" class="form-control" placeholder="Enter Amount Received"><br>
            <center>
                <button class="btn-primary btn" type="" onclick="SaveIncometrail()" >Submit Income Record</button>
                <button onclick="cancelIncome()" class="btn btn-default" >Cancel</button>
            </center> <br><br>
        ';
    }
	
    public static function EDIT_INCOME(){
		$db = new DB();
		foreach($db->query("SELECT * FROM incometrail WHERE incomeid='".$_GET['editincomedata']."'") as $row){
			$dateint = new DateTime($row['income_date']);
			SECTIONS::$search_code = $row['accountcode'];
			SECTIONS::SEARCH_CODE();
			 echo '
				<div hidden id="incomeedditdata">'.$row['incomeid'].'</div>
				<label class="labelcolor">Account Name</label>
				<select onchange="getassettype()" id="incomeaccount" class="selectpicker show-tick form-control" data-live-search="true">
				<option value="'.$row['accountcode'].'">'.SECTIONS::$resultname.'</option>
					<option value="">select Account Name</option>';
			INCOMETRAIL::GET_INCOMEACCOUTS();
			echo'
				</select><br>
				<label class="labelcolor">Cash Accounts</label>
				<select onchange="ReturnedCash()" id="cashoptions" class="form-control">
					<option value="'.$row['paymode'].'">'.(($row['paymode']=="3")?"Cheque":"Cash").'</option>
					<option value="">select Cash Account</option>
					<option value="1">Cash</option>
					<option value="3">Cheque</option>
				</select><br>
				<div id="returnedbanks"></div>
				<label class="labelcolor">Receipt No/ Cheque No</label>
				<input value="'.$row['slipno'].'" id="slipno" type="text" class="form-control" placeholder="Enter Receipt No/ Cheque No"><br>
				<label class="labelcolor">Transaction Date</label>
				<input value="'.$dateint->format('m/d/Y').'" id="datepicker1" type="" class="form-control" placeholder="Enter Transaction Date"><br>
				<label class="labelcolor">Income Description</label>
				<TextArea onclick="" id="incomedesc" type="text" class="form-control" placeholder="Enter Income Description">'.$row['income_description'].'</TextArea><br>
				<div id="returnedoptionss"></div>
				<label class="labelcolor">Amount Received</label>
				<input value="'.$row['amount'].'" id="amtrcvd" type="text" class="form-control" placeholder="Enter Amount Received"><br>
				<center>
					<button class="btn-primary btn" type="" onclick="SaveIncometrail()" >Submit Income Record</button>
					<button onclick="cancelIncome()" class="btn btn-default" >Cancel</button>
				</center> <br><br>
			';
		}
    }
	public static function REMOVE_INCOME(){
		$db = new DB();
		$db->query("DELETE FROM incometrail WHERE incomeid='".$_GET['deleteincomeid']."'");
		echo '
            <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr class="info">
                        <th width="30%">Account Name</th>
                        <th width="40%">Income Description</th>
                        <th width="25%">Payment Detail</th>
                        <th width="5%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                '; self::INCOMELIST(); echo'
                </tbody>
            </table>
        ';

	}
}
class INVESTIMENT extends database_crud{
    protected $table = "investiment";
    protected $pk = "investid";
	// SELECT `investid`, `accountcode`, `acquired_date`, `investiment_description`, `slipno`, `amount`,
	// `inserted_date`, `handledby` FROM `investiment` WHERE 1

    public static function GET_INVESTIMENTACCOUNTS(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM sections WHERE seccode='LVL004'") as $rows) {
            foreach ($db->query("SELECT * FROM level2 WHERE level1id='" . $rows['sec_id'] . "'") as $row) {
                echo '<optgroup label="' . $row['level1name'] . '">';
                foreach ($db->query("SELECT * FROM level3 WHERE level2id='" . $row['lvl1_id'] . "' AND level2act='1'") as $rowx) {
                    echo '<option value="' . $rowx['level2code'] . '">' . $rowx['level2name'] . '</option>';
                }
                foreach ($db->query("SELECT * FROM level3 WHERE level2id='" . $row['lvl1_id'] . "' AND level2act='2'") as $rowe) {
                    foreach ($db->query("SELECT * FROM depreciation WHERE assetcode='".$rowe['level2code']."'") as $rowd){
                        echo '<option value="' . $rowe['level2code'] . '">' . $rowe['level2name'] . '</option>';
                    }


                }
                echo '</optgroup>';
            }
        }

    }
    public static function GET_ASSETACCOUTSDEPECITION(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM sections WHERE seccode='LVL004'") as $rows) {
            foreach ($db->query("SELECT * FROM level2 WHERE level1id='" . $rows['sec_id'] . "'") as $row) {
                echo '<optgroup label="' . $row['level1name'] . '">';
                foreach ($db->query("SELECT * FROM level3 WHERE level2act='2' AND level2id='" . $row['lvl1_id'] . "'") as $rowx) {
                    echo '<option value="' . $rowx['level2code'] . '">' . $rowx['level2name'] . '</option>';
                }
                echo '</optgroup>';
            }
        }

    }
    public static function SAVE_INVESTIMENT(){
        $invest = new INVESTIMENT(); $db = new DB();
        NOW_DATETIME::NOW();        session_start(); $result = "";
        $data = explode("?::?",$_GET['saveinvestment']);
        $da = explode("/",$data[2]);
        $date = $da[2]."-".$da[0]."-".$da[1];
        $invest->accountcode = $data[0];
        $invest->slipno = $data[1];
        $invest->investiment_description = $data[3];
        $invest->amount = $data[4];
        $invest->acquired_date = $date;
        $invest->inserted_date = NOW_DATETIME::$Date_Time;
        $invest->handledby = $_SESSION['user_id'];
        $invest->create();
        self::CANCELINVESTIMENT();
        echo '|<><>|';
        echo '
            <table id="example" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr class="info">
                        <th width="30%">Account Name</th>
                        <th width="40%">Investiment Description</th>
                        <th width="25%">Capital Detail</th>
                        <th width="5%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                '; self::INVESTIMENTLIST(); echo'
                </tbody>
            </table>
        ';

    }
    public static function INVESTIMENTLIST(){
        $db = new DB();
        foreach($db->query("SELECT * FROM investiment ORDER BY investid DESC") as $row){
            SECTIONS::$search_code = $row['accountcode'];
            SECTIONS::SEARCH_CODE();
            echo "<tr>";
            echo "<td data-order='1'>".SECTIONS::$resultname."  <b>(".$row['accountcode'].")</b></b></td>";
            echo "<td>".$row['investiment_description']."<br>Acquired Date: <b>".$row['acquired_date']."</b><br>Slip No : <b> ".$row['slipno']."</b></td>";
            echo "<td>Total Amount : <b>".number_format($row['amount'])."</b></td>";
            echo "<td></td>";
            echo "</tr>";
        }
    }
    public static function CANCELINVESTIMENT(){
        //SYS_CODES::ASSET_NO();
        echo '
            <label class="labelcolor">Account Name</label>
			<select onchange="getassettype()" id="incomeaccount" class="selectpicker show-tick form-control" data-live-search="true">
				<option value="">select Account Name</option>';
				INVESTIMENT::GET_INVESTIMENTACCOUNTS();
			echo'
			</select><br>
			<label class="labelcolor">Cash Accounts</label> 
			<select onchange="ReturnedCash()" id="cashoptions" class="form-control">
				<option value="">select Cash Account</option>
				<option value="1">Cash at Hand</option>
				<option value="3">Cash at Bank (Cheque)</option>
			</select><br>
			<div id="returnedbanks"></div>
			<label class="labelcolor">Receipt No/ Cheque No</label> 
			<input onclick="" id="slipno" type="text" class="form-control" placeholder="Enter Receipt No/ Cheque No"><br>
			<label class="labelcolor">Acquired Date</label> 
			<input onclick="" id="datepicker1" type="text" class="form-control" placeholder="Enter Acquired Date"><br>
			<label class="labelcolor">Investiment Description</label> 
			<TextArea onclick="" id="incomedesc" type="text" class="form-control" placeholder="Enter Investiment Description"></TextArea><br>
			<div id="returnedoptionss"></div>
			<label class="labelcolor">Investiment Capital</label> 
			<input onclick="" id="amtrcvd" type="text" class="form-control" placeholder="Enter Amount Received"><br>
			<center>
				<button class="btn-primary btn" type="" onclick="SaveInvestiment()" >Submit Income Record</button>
				<button onclick="cancelInvestiment()" class="btn btn-default" >Cancel</button>  
			</center> <br><br>   
        ';
    }

}
