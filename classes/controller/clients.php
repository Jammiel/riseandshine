<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


class CLIENT_DATA extends database_crud {
    protected $table="clients";
    protected $pk="clientid";

//    SELECT `clientid`, `clientdataid`, `regdate`, `accountname`, `accountno`,
//    `savingaccount`, `shareaccount_amount`, `numberofshares`, `loanaccount`
//    FROM `clients` WHERE 1

//	SELECT `indid`, `firstname`, `secondname`, `lastname`, `gender`,
// `nationalidno`, `nationality`, `dateofbirth`, `maritalstatus`,
// `occupation`, `employer`, `mobilenumber`, `physicaladress`, `subcounty`, `district`,
// `photo`, `kinname`, `relationship`, `contactdetails`, `address`, `securityqtn`, `answer`
// FROM `individualaccount` WHERE 1

    public static $accountname;     public static $accountno;       public static $firstname;
    public static $secondname;      public static $lastname;        public static $gender;
    public static $mobilenumber;    public static $physicaladress;  public static $subcounty;
    public static $district;        public static $savingaccount;   public static $loanaccount;
    public static $no_of_shares;    public static $shares;          public static $writeoffstatus;
    public static $photo;           public static $members;         public static $loanbalances;
    public static $interest;
    
    static $sql =   "SELECT * FROM clients";
    static $sql1 =  "SELECT * FROM individualaccount";
    static $sql2 =  "SELECT * FROM groupaccount";
    static $sql3 =  "SELECT * FROM businessaccount";
    public static $clientid;
    
    public static function DASH_VALUES(){
        $db = new DB();
        foreach ($db->query("SELECT COUNT(clientid) as id, SUM(loanaccount) as loan FROM `clients`") as $row){
            self::$loanbalances = $row['loan'];            self::$members = $row['id'];
        }
    }

    public static function CLIENT_OPTIONSEARCH(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM clients WHERE blacklist='0'") as $row){
            echo '<option value='.$row['clientid'].'>('.$row['accountno'].')&nbsp;&nbsp;'.$row['accountname'].'</option>';
        }
    }
    public static function SCHOOL_OPTIONSEARCH(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM clients WHERE accounttype='3' AND blacklist='0' AND school='1'") as $row){
			$wrds  = str_split($row['accountname'],8);
            echo '<option value='.$row['clientid'].'>('.$row['accountno'].')&nbsp;&nbsp;'.$wrds[0].'...</option>';
        }
    }
    public static function BLACKLISTACTION(){
		$db = new DB();
		$db->query("UPDATE clients SET blacklist='1' WHERE clientid='".$_GET['blacklist']."'");
		self::CLIENTBLACKLISTWORK();
		echo "|<><>|";
		self::CLIENTBLACKLIST();
		echo "|<><>|";
		self::CLIENTBLACKLISTRETREIVE();
	}
    public static function UNBLACKLISTACTION(){
		$db = new DB();
		$db->query("UPDATE clients SET blacklist='0', retr='1' WHERE clientid='".$_GET['undoblacklist']."'");
		self::CLIENTBLACKLISTWORK();
		echo "|<><>|";
		self::CLIENTBLACKLIST();
		echo "|<><>|";
		self::CLIENTBLACKLISTRETREIVE();
	}
    public static function OVERDRAFTLIST(){
		$db = new DB(); $loop = "1";
		echo '
		<table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
			<thead>
				<tr class="info">
					<th width="30%">Account Detail</th>
					<th width="35%">OverDraft Detail</th>
					<th width="35%">Actions</th>
				</tr>
			</thead>
			<tbody>
			'; 
			foreach($db->query("SELECT * FROM clients ORDER BY clientid DESC") as $row){
				CLIENT_DATA::$clientid = $row['clientid'];
				CLIENT_DATA::CLIENTDATAMAIN();
				
				echo "<tr>";
				echo "<td data-order='1'><b>".CLIENT_DATA::$accountname." </b> <br><b>(".CLIENT_DATA::$accountno.")</b></td>";
				echo "<td>
						OverDraft Status : <b class='label label-".(($row['overdraftstatus'] == "0")?"default":"danger")." pull-right'>".(($row['overdraftstatus']=="0")?"no active":"Active OverDraft")."</b><br>
						Overdraft Limit : <b class='pull-right'> ".number_format($row['overdraftamt'])."</b>
					</td>";
				echo '<td>
						<div id="overdraftspace'.$loop.'"></div><br>
						<div  style="padding: 5px">
							<select id="savetypeint'.$loop.'" onchange="overdraftstatus('.$loop.')" class="form-control" style="width: 80%;margin-bottom: 4px">
								<option value="">select status</option>
								<option value="0">In-Active</option>
								<option value="1">Active</option>
							</select>
							<button onclick="setoverdraft('.$loop.','.$row['clientid'].')" class="btn btn-social btn-primary"><i class="ti ti-save"></i></button>
						</div>
						</td>';
				echo "</tr>";
				$loop++;
			} 
		echo'
			</tbody>
		</table>
		';
	}
    public static function UPDATEOVERDRAFT(){
		$db = new DB();  session_start();
		$data = explode("?::?",$_GET['setoverdraft']);
		$db->query("UPDATE clients SET overdraftstatus='".$data[2]."', overdraftamt='".$data[0]."' WHERE clientid='".$data[1]."'");
		self::OVERDRAFTLIST();
    }
	
    public static function RETURN_TRANSACTIONWD(){
        $db = new DB(); $pht = "";	$pht1 = "";
        foreach ($db->query(static::$sql." WHERE clientid ='".static::$clientid."'") as $row){
			self::CLIENTDATAMAIN();
            echo '
        <div class="w3-container" style="">
          <div class="w3-card-4" style="width:100%;border-radius: 10px">
            <header class="w3-container w3-light-green" style="color: #fff;border-top-left-radius: 10px;border-top-right-radius: 10px;">
              <h4 style="color: #fff;">
				<b>Acc Name:</b> &nbsp;'.$row['accountname'].'
				<b style="font-size: 16px"> &nbsp;&nbsp;&nbsp;Acc Number: &nbsp;'.$row['accountno']. '</b>
				<button class="icon-bg pull-right incard1" style=""><i class="ti ti-printer"></i></button>
				<button data-target="#excelsheetupload" data-toggle="modal" class="icon-bg pull-right incard2" style="margin-right: 4px"><img src="images/excel.png" width="15px" height="20px"></button></h4>

            </header>
            <div class="w3-container"><hr>
              <div class="col-md-2">';
			if($row['accounttype'] == "1" || $row['accounttype'] == "3"){
                echo '<img src="'.((self::$photo)?"classes/upload/".self::$photo:"images/default.png").'" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:100px;height: 100px;image-orientation: from-image">';
			}
			if($row['accounttype'] == "2"){
				
				foreach ($db->query(static::$sql2." WHERE acc_no='".static::$clientid."'") as $row1){
					$pht .= "?::?".$row1['photofile'];
				}
				$pht1 = explode("?::?",$pht) ;
				echo '<div class="row">';
				echo '<div class="col-sm-6"><img src="'.(($pht1[1])?"classes/upload/".$pht1[1]:"images/default.png").'" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px;height: 60px;image-orientation: from-image"></div>';
				echo '<div class="col-sm-6"><img src="'.(($pht1[2])?"classes/upload/".$pht1[2]:"images/default.png").'" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px;height: 60px;image-orientation: from-image"></div>';
				echo '<div class="col-sm-6 col-sm-offset-3"><img src="'.(($pht1[3])?"classes/upload/".$pht1[3]:"images/default.png").'" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px;height: 60px;image-orientation: from-image"></div>';
				echo '</div>';
			}
			echo'  
			  </div>
              <div class="col-md-4">
                 <b>Savings Account</b><br><br>
                 <p>Acc Balance: <b>' .number_format($row['savingaccount']).'</b></p>
              </div>
              <div class="col-md-3">
                 <b>Share Capital</b><br><br>
                 <p style="font-size: 12px">Share Amount: <b>'.number_format($row['shareaccount_amount']).'</b></p>
                 <p style="font-size: 12px">No. of Shares: <b>'.$row['numberofshares'].'</b></p>
              </div>
              <div class="col-md-3">
                 <b>Loan Information</b><br><br>
                 <p style="font-size: 12px">Loan Balance: <b>'.number_format($row['loanaccount']).'</b></p>
                 <p style="font-size: 12px">Loan Interest: <b>'.number_format($row['loan_interest']).'</b></p>
                 <p style="font-size: 12px">Loan Penalty: <b>'.number_format($row['loan_fines']).'</b></p>
              </div>
            </div><hr>
            <button onclick="refreshledger()" class="w3-btn-block w3-dark-grey" style="border-bottom-right-radius: 10px;border-bottom-left-radius: 10px"><i class="fa fa-refresh"></i> &nbsp;&nbsp;Refresh Info</button>
          </div>
        </div><br>';
        }
    }
    public static function RETURN_CLIENTLEDGER(){
        $db = new DB();
        foreach ($db->query(static::$sql." WHERE clientid ='".static::$clientid."'") as $row){

            echo '<div hidden id="depositprt"></div>
                    <table cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n table-responsive" id="grn">
                        <thead>
                            <tr class="success">
                                 <th width = "10%">Date</th>
                                 <th width = "35%">Description</th>
                                 <th width = "15%"><b style="font-size: 12px">Withdrawls<br>DEBIT</b></th>
                                 <th width = "15%"><b style="font-size: 12px">Deposits<br>CREDIT</b></th>
                                 <th width = "15%">Balance</th>
                                 <th width = "10%">Initials</th>
                            </tr>
                        </thead>
                    <tbody>';

            foreach ($db->query("SELECT * FROM mergerwd WHERE clientid='".$row['clientid']."' ORDER BY  insertiondate DESC , mergeid DESC") as $rowt){
                if($rowt['transactiontype']=="1"){
                    foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."'") as $row1){
                        $dec = explode(",",$row1['depositeditems']);
                        $descriptions = "";
                        for($i = 1; $i<=count($dec); $i++){
                            $dataxx = explode("charges",$dec[$i]);
                            if($dataxx[1]){
                                foreach ($db->query('SELECT * FROM othercharges WHERE otherid="'.$dataxx[1].'"') as $row){}
                                $descriptions .=",". $row['oname'];
                            }else{
                                foreach ($db->query("SELECT * FROM deposit_cats WHERE depart_id='".$dec[$i]."'") as $rowd){
                                    $descriptions .= ",".$rowd['deptname'];
                                }
                            }

                        }
                        echo '<tr>';
                        echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                        echo '<td>
							<b style="font-size: 12px">'.$descriptions.'</b><br>
							<b style="color: #08b44d">Deposited By: </b> '.$row1['depositor'].'
							<span class="pull-right">
								<button onclick="gettranstiondetail('.$row1['depositid'].')"  data-target="#trasacdetail" data-toggle="modal" class="btn btn-info-alt"><i class="fa fa-eye"></i></button>
								<button onclick="printdepositdetail('.$row1['depositid'].')" class="btn btn-default-alt"><i class="fa fa-print"></i></button>
							</span>
							</td>';
                        echo '<td></td>';
                        echo '<td>'.number_format($row1['amount']).'</td>';
                        echo '<td>'.number_format($row1['balance']).'</td>';
                        echo '<td></td>';
                        echo '</tr>';
                    }
                }
                if($rowt['transactiontype']=="2"){
                    foreach ($db->query("SELECT * FROM withdraws WHERE withdrawid='".$rowt['transactionid']."'") as $row1){
                        echo '<tr>';
                        echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                        echo '<td><b style="color: #b44443">Withdrawn By: </b> '.$row1['withdrawor'].'</td>';
                        echo '<td>'.number_format($row1['amount']).'</td>';
                        echo '<td></td>';
                        echo '<td>'.number_format($row1['balance']).'</td>';
                        echo '<td></td>';
                        echo '</tr>';
                    }
                }
                if($rowt['transactiontype']=="3"){
                    foreach ($db->query("SELECT * FROM loan_schedules WHERE schudele_id='".$rowt['transactionid']."'") as $row1){
                        echo '<tr>';
                        echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                        echo '<td><b style="color: #02a6ac;">Loan Deposit</td>';
                        echo '<td></td>';
                        echo '<td>'.number_format($row1['amount_given']).'</td>';
                        echo '<td>'.number_format($row1['balance']).'</td>';
                        echo '<td></td>';
                        echo '</tr>';
                    }
                }
                if($rowt['transactiontype']=="4"){
                    foreach ($db->query("SELECT * FROM loan_insurance WHERE ins_id='".$rowt['transactionid']."'") as $row1){
                        echo '<tr>';
                        echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                        echo '<td><b style="color: #02a6ac;">Loan Insurance Fund</td>';
                        echo '<td>'.number_format($row1['amount']).'</td>';
                        echo '<td></td>';
                        echo '<td>'.number_format($row1['balance']).'</td>';
                        echo '<td></td>';
                        echo '</tr>';
                    }
                }
                if($rowt['transactiontype']=="5"){
                    foreach ($db->query("SELECT * FROM loan_processcharges WHERE charge_id='".$rowt['transactionid']."'") as $row1){
                        echo '<tr>';
                        echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                        echo '<td><b style="color: #02a6ac;">Loan Process Fees</td>';
                        echo '<td>'.number_format($row1['amount']).'</td>';
                        echo '<td></td>';
                        echo '<td>'.number_format($row1['balance']).'</td>';
                        echo '<td></td>';
                        echo '</tr>';
                    }
                } 
                if($rowt['transactiontype']=="6"){
                    foreach ($db->query("SELECT * FROM noncashtracs WHERE nontracid='".$rowt['transactionid']."'") as $row1){
                        if($row1['accountcode']=="2"){$accountcodename = "Share Capital";}
                        if($row1['accountcode']=="3"){$accountcodename = "Loan Repayment";}
                        if($row1['accountcode']=="5"){$accountcodename = "Loan Application Fee";}
                        if($row1['accountcode']=="6"){$accountcodename = "MemberShip Fee";}
                        if($row1['accountcode']=="7"){$accountcodename = "Pass Book / Stationary";}
                        if($row1['accountcode']=="8"){$accountcodename = "School Fees";}
                        if($row1['accountcode']=="d"){$accountcodename = "Multiple Deposit";}
                        if($row1['accountcode']=="9"){$accountcodename = "Loan Penalty";}
                        if($row1['accountcode']=="10"){$accountcodename = "Loan Recovery";}
                        $antdate1 = new DateTime($row1['ndate']);
                        echo '<tr>';
                        echo '<td data-order="2014-00-00:00:00:00">'.$antdate1->format('Y-m-d').'</td>';
                        echo '<td><b style="color: #b9151b;">'.$accountcodename.'<span class="badge badge-info pull-right">non cash transaction</span></td>';
                        echo '<td>'.(($row1['accountcode']=="d")?'':number_format($row1['amount'])).'</td>';
                        echo '<td>'.(($row1['accountcode']=="d")?number_format($row1['amount']):'').'</td>';
                        echo '<td>'.number_format($row1['sbal']).'</td>';
                        echo '<td></td>';
                        echo '</tr>';
                    }
                }
                if($rowt['transactiontype']=="8"){
            foreach ($db->query("SELECT * FROM divideneds WHERE divid='".$rowt['transactionid']."'") as $row2){
            echo '<tr>';
            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
            echo '<td><b style="color: #03a9f4;">Dividend Deposit<span class="badge badge-info pull-right">non cash transaction</span></td>';
            echo '<td></td>';
            echo '<td>'.number_format($row2['divamt']).'</td>';
            echo '<td>'.number_format($row2['savbal']).'</td>';
            echo '<td></td>';
            echo '</tr>';
        }
}
                if($rowt['transactiontype']=="9"){
    foreach ($db->query("SELECT * FROM monthlycharges WHERE mchargeid='".$rowt['transactionid']."'") as $rowm){
        echo '<tr>';
        echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
        echo '<td><b style="color: #03a9f4;">Monthly Charge<span class="badge badge-info pull-right">non cash transaction</span></td>';
        echo '<td>'.number_format($rowm['amount']).'</td>';
        echo '<td></td>';
        echo '<td>'.number_format($rowm['balance']).'</td>';
        echo '<td></td>';
        echo '</tr>';
    }
}
                if($rowt['transactiontype']=="10"){
                    foreach ($db->query("SELECT * FROM loanwriteoff_repay WHERE reapayid='".$rowt['transactionid']."'") as $rowmtt){
                        echo '<tr>';
                        echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                        echo '<td><b style="color: #03a9f4;">Loan-WritenOff Repay</b></td>';
                        echo '<td></td>';
                        echo '<td>'.number_format($rowmtt['ramount']).'</td>';
                        echo '<td>'.number_format($rowmtt['sbal']).'</td>';
                        echo '<td></td>';
                        echo '</tr>';
                    }
                }
            }

            echo'</tbody>
            </table>
            <br>';
        }
    }
    public static function RETURN_GENERALCLIENTLEDGER(){
        $db = new DB(); 
        NOW_DATETIME::NOW();   
        $date = explode(":",NOW_DATETIME::$Date); 
        session_start();
        CASH_TRACS::CASHIERAMT();	
		
        foreach ($db->query("SELECT * FROM cashierincharge WHERE cashier='".$_SESSION['user_id']."'") as $row){
            $cashierstate = $row['status'];
        } 
        foreach ($db->query("SELECT SUM(camount) as camount FROM cashiertracs WHERE ctype='2' AND status='0' AND cashier='".$_SESSION['user_id']."' AND cdate='".NOW_DATETIME::$Date."'") as $rowas){} 
        foreach ($db->query("SELECT SUM(camount) as camount FROM cashiertracs WHERE ctype='2' AND status='0' AND cashier='".$_SESSION['user_id']."'") as $rowast){
            $db->query("UPDATE cashierincharge SET amount='".$rowast['camount']."' WHERE cashier='".$_SESSION['user_id']."'");
        } 
                foreach ($db->query("SELECT SUM(amount) as totdeposit FROM deposits WHERE status='0' AND DATE(inserteddate)='".$date[0]."' AND user_handle='".$_SESSION['user_id']."'") as $row){
            $totdeposist = $row['totdeposit'];
        }
        if($totdeposist){if($cashierstate == "0"){$totdeposist = "0";}}else{$totdeposist = "0";}
        foreach ($db->query("SELECT SUM(amount) as totdeposit FROM deposits WHERE status='0' AND user_handle='".$_SESSION['user_id']."'") as $deps){
			if($deps['totdeposit']==null){$dep="0";}else{$dep=$deps['totdeposit'];}
			$db->query("UPDATE cashierincharge SET dep='".$dep."' WHERE cashier='".$_SESSION['user_id']."'");
		}
        foreach ($db->query("SELECT SUM(amount) as totwithdraw FROM withdraws WHERE status='0' AND DATE(inserteddate)='".$date[0]."' AND user_handle='".$_SESSION['user_id']."'") as $row){
            $totwithdraw = $row['totwithdraw'];
        }
        if($totwithdraw){if($cashierstate == "0"){$totwithdraw = "0";}}else{$totwithdraw = "0";}
        foreach ($db->query("SELECT SUM(amount) as totwithdraw FROM withdraws WHERE status='0' AND user_handle='".$_SESSION['user_id']."'") as $withd){
			if($withd['totwithdraw']==null){$withd="0";}else{$withd=$withd['totwithdraw'];}
			$db->query("UPDATE cashierincharge SET withd='".$withd."' WHERE cashier='".$_SESSION['user_id']."'");
		}
        echo '
            <div class="col-md-8">
		    <center><h4><b>DAILY WITHDRAW & DEPOSIT TRANSACTION RECORDS</b></h4></center><br><br>
            <table cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n" id="example">
                <thead>
                    <tr class="success">
                         <th width = "10%">Date</th>
                         <th width = "45%">Description</th>
                         <th width = "15%"><b style="font-size: 12px">Withdrawls<br>DEBIT</b></th>
                         <th width = "15%"><b style="font-size: 12px">Deposits<br>CREDIT</b></th>
                         <th width = "15%">Account No.</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($db->query("SELECT SUM(camount) as camount FROM cashiertracs WHERE ctype='2' AND cashier='".$_SESSION['user_id']."' AND cdate='".NOW_DATETIME::$Date."'") as $rowass){}
        foreach ($db->query("SELECT * FROM mergerwd WHERE DATE(insertiondate)='".$date[0]."' ORDER BY insertiondate DESC") as $rowt){
            if($rowt['transactiontype']=="1"){
                foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."' AND user_handle='".$_SESSION['user_id']."'") as $row1){
                    foreach ($db->query("SELECT * FROM clients WHERE clientid='".$rowt['clientid']."'") as $row){$acc_no = $row['accountno'];}
                    $dec = explode(",",$row1['depositeditems']);
                    $descriptions = "";
                    for($i = 1; $i<=count($dec); $i++){
                        foreach ($db->query("SELECT * FROM deposit_cats WHERE depart_id='".$dec[$i]."'") as $rowd){
                            $descriptions .= ",".$rowd['deptname'];
                        }
                    }
                    echo '<tr>';
                    echo '<td width = "10%" data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                    echo '<td width = "45%"><b style="font-size: 12px">'.$descriptions.'</b>'.(($row1['status']=="1")?'<span class="badge badge-info pull-right"># Reported</span>':"").'<br><b style="color: #08b44d">Deposited By: </b> '.$row1['depositor'].'</td>';
                    echo '<td width = "15%"></td>';
                    echo '<td width = "15%">'.number_format($row1['amount']).'</td>';
                    echo '<td width = "15%"><b>'.$acc_no.'</b></td>';
                    echo '</tr>';
                }
            }
            if($rowt['transactiontype']=="2"){
                foreach ($db->query("SELECT * FROM withdraws WHERE withdrawid='".$rowt['transactionid']."' AND user_handle='".$_SESSION['user_id']."'") as $row1){
                    foreach ($db->query("SELECT * FROM clients WHERE clientid='".$rowt['clientid']."'") as $row){$acc_no = $row['accountno'];}
                    echo '<tr>';
                    echo '<td width = "10%" data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                    echo '<td width = "45%"><b style="color: #b44443">Withdrawn By: </b> '.$row1['withdrawor'].(($row1['status']=="1")?'<span class="badge badge-info pull-right"># Reported</span>':"").'</td>';
                    echo '<td width = "15%">'.number_format($row1['amount']).'</td>';
                    echo '<td width = "15%"></td>';
                    echo '<td width = "15%"><b>'.$acc_no.'</b></td>';
                    echo '</tr>';
                }
            }
        }
		$exptedtot = $totdeposist+$rowass['camount']-$totwithdraw;
		;
        echo'</tbody>
        </table><br></div>
        <div class="col-md-4"><br><br><br><br><br>
            <div class="w3-container" style="">
          <div class="w3-card-4" style="width:100%;border-radius: 10px">
            <header class="w3-container w3-light-green" style="color: #fff;border-top-left-radius: 10px;border-top-right-radius: 10px;">
              <h4 style="color: #fff;"><b>Daily Transaction Reconciliation Summary</b></h4>

            </header>
            <div class="w3-container"><hr>
              <div class="col-md-12">
                 <b>Opening Operational Amount</b><br><br>
                 <p><b style="color: #25b669;font-size: 18px">'.number_format($rowass['camount']).'</b></p>
              </div>
              <div class="col-md-12">
                 <b>Total Deposit Amount</b><br><br>
                 <p><b style="color: #2c88cf;font-size: 18px">'.number_format($totdeposist).'</b></p>
              </div>
              <div class="col-md-12">
                 <b>Total Withdraw Amount</b><br><br>
                 <p><b style="color: #b64556;font-size: 18px">'.number_format($totwithdraw).'</b></p><hr><br><br>
              </div>
              <div class="col-md-12">
                 <b>Cash At Hand</b><br><br>
                 <p style="font-size: 18px">Expected: <b style="color: #25b669;font-size: 18px">'.number_format($exptedtot).'</b></p>
                 <p><input '.(($cashierstate == "0" || $cashierstate == "2")?'disabled':'').' id="socheckamt" onkeyup="socheckamt('.$exptedtot.')" class="form-control" placeholder="enter actual cash at hand" type="text"></p>
                 <p>Overage:&nbsp;&nbsp;<b style="font-size: 12px" id="overage">'.number_format(0).'</b></p>
                 <p>Shortage:&nbsp;<b style="font-size: 12px" id="shortage">'.number_format(0).'</b></p>
              </div>
            </div><hr>
            <button onclick="savesocheckamt('.$exptedtot.','.$totwithdraw.','.$totdeposist.','.CASH_TRACS::$cashieramt.')" class="w3-btn-block w3-dark-grey" style="border-bottom-right-radius: 10px;border-bottom-left-radius: 10px">save reconciliation</button>
          </div>
        </div><br>
        </div>';
    }
    
    public static function SAVE_INDIVIDUALDATA(){
        $clientdata = new CLIENT_DATA();    NOW_DATETIME::NOW(); $db = new DB();
        $individual = new INDIVIDUAL_ACCOUNTDATA();
        $data = explode("?::?",$_GET['saveindividualaccountdata']);



        $clientdata->accountname = $data[20];
        $clientdata->accountno = $data[21];
        $individual->photo = $data[22];

        $individual->firstname = $data[0];
        $individual->lastname = $data[1];
        $individual->secondname = $data[7];
        $individual->gender = $data[8];
        $individual->nationalidno = $data[2];
        $individual->nationality = $data[3];
        $individual->dateofbirth = $data[9];
        $individual->maritalstatus = $data[10];
        $individual->occupation = $data[4];
        $individual->employer = $data[11];
        $individual->mobilenumber = $data[5];
        $individual->physicaladress = $data[12];
        $individual->subcounty = $data[6];
        $individual->district = $data[13];
        $individual->kinname = $data[14];
        $individual->relationship = $data[17];
        $individual->contactdetails = $data[18];
        $individual->address = $data[15];
        $individual->securityqtn = $data[16];
        $individual->answer = $data[19];
        if($data[23]){
            foreach ($db->query("SELECT * FROM individualaccount WHERE indid='".$data[23]."'") as $row){
                $clientdata->clientid = $row['acc_no'];  $clientdata->save();
            }
            $individual->indid = $data[23]; $individual->save();
        }else{
            $clientdata->accounttype = "1";
            $clientdata->regdate = NOW_DATETIME::$Date;
            $clientdata->savingaccount = "0";
            $clientdata->shareaccount_amount = "0";
            $clientdata->numberofshares = "0";
            $clientdata->loanaccount = "0";
            $clientdata->create();
            $individual->acc_no = $clientdata->pk;
            $individual->create();
        }

        self::CLEARIND();
		echo "|<><>|";
		self::CLIENTDATA();
    }
    public static function SAVE_GROUPDATA(){
        $clientdata = new CLIENT_DATA();    NOW_DATETIME::NOW();
        $group = new GROUP_ACCOUNTDATA();
        $data = explode("?::?",$_GET['savegroupaccountdata']);

        $clientdata->accountname = $data[54];
        $clientdata->accountno = $data[55];
		if($data[56]){
			$photos = explode(",",$data[56]);
		}
        if($data[60]){
            $clientdata->clientid = $data[60];
            $clientdata->save();
        }else{
            $clientdata->accounttype = "2";
            $clientdata->regdate = NOW_DATETIME::$Date;
            $clientdata->savingaccount = "0";
            $clientdata->shareaccount_amount = "0";
            $clientdata->numberofshares = "0";
            $clientdata->loanaccount = "0";
            $clientdata->create();
        }

        $group->firstname = $data[0];
        $group->lastname = $data[1];
        $group->middlename = $data[2];
        $group->gender = $data[3];
        $group->passportno = $data[4];
        $group->nationality = $data[5];
        $group->dateofbirth = $data[6];
        $group->maritalstatus = $data[7];
        $group->occupation = $data[8];
        $group->employer = $data[9];
        $group->mobilenumber = $data[10];
        $group->physicaladdress = $data[11];
        $group->subcounty = $data[12];
        $group->district = $data[13];
        $group->nextofkin = $data[14];
        $group->relationship = $data[15];
        $group->contactdetail = $data[16];
        $group->address = $data[17];
		$group->photofile = $photos[0];
        if($data[57]){
			
            $group->groupid = $data[57];
            $group->save();
        }else{
            $group->acc_no = $clientdata->pk;
            $group->create();
        }



        $group->firstname = $data[18];
        $group->lastname = $data[19];
        $group->middlename = $data[20];
        $group->gender = $data[21];
        $group->passportno = $data[22];
        $group->nationality = $data[23];
        $group->dateofbirth = $data[24];
        $group->maritalstatus = $data[25];
        $group->occupation = $data[26];
        $group->employer = $data[27];
        $group->mobilenumber = $data[28];
        $group->physicaladdress = $data[29];
        $group->subcounty = $data[30];
        $group->district = $data[31];
        $group->nextofkin = $data[32];
        $group->relationship = $data[33];
        $group->contactdetail = $data[34];
        $group->address = $data[35];$group->photofile = $photos[1];
        if($data[58]){
			
            $group->groupid = $data[58];
            $group->save();
        }else{
            $group->acc_no = $clientdata->pk;
            $group->create();
        }


        $group->firstname = $data[36];
        $group->lastname = $data[37];
        $group->middlename = $data[38];
        $group->gender = $data[39];
        $group->passportno = $data[40];
        $group->nationality = $data[41];
        $group->dateofbirth = $data[42];
        $group->maritalstatus = $data[43];
        $group->occupation = $data[44];
        $group->employer = $data[45];
        $group->mobilenumber = $data[46];
        $group->physicaladdress = $data[47];
        $group->subcounty = $data[48];
        $group->district = $data[49];
        $group->nextofkin = $data[50];
        $group->relationship = $data[51];
        $group->contactdetail = $data[52];
        $group->address = $data[53];
		$group->photofile = $photos[2];
        if($data[59]){
			
            $group->groupid = $data[59];
            $group->save();
        }else{
            $group->acc_no = $clientdata->pk;
            $group->create();
        }
		self::CLEARGRP();
		echo "|<><>|";
        self::CLIENTDATA();
    }
    public static function SAVE_BUSINESSDATA(){
        $clientdata = new CLIENT_DATA();    NOW_DATETIME::NOW();
        $bussiness = new BUSINESS_ACCOUNTDATA();
        $data = explode("?::?",$_GET['savebusinessaccount']);

        $clientdata->accountname = $data[16];
        $clientdata->accountno = $data[17];
		$clientdata->school = $data[19];

        if($data[21]){
            $clientdata->clientid = $data[21];
            $clientdata->save();
        }else{
            $clientdata->accounttype = "3";
            $clientdata->regdate = NOW_DATETIME::$Date;
            $clientdata->savingaccount = "0";
            $clientdata->shareaccount_amount = "0";
            $clientdata->numberofshares = "0";
            $clientdata->loanaccount = "0";
            $clientdata->create();
        }

        $bussiness->natureofbusines = $data[0];
        $bussiness->certificateofreg = $data[1];
        $bussiness->registrationdate = $data[2];
        $bussiness->officetel = $data[3];
        $bussiness->email = $data[4];
        $bussiness->businesslocation = $data[5];
        $bussiness->tin = $data[6];
        $bussiness->physicaladdress = $data[7];
        $bussiness->subcounty = $data[8];
        $bussiness->district = $data[9];
        $bussiness->name1 = $data[10];
        $bussiness->name2 = $data[11];
        $bussiness->name3 = $data[12];
        $bussiness->certificate1 = $data[13];
        $bussiness->certificate2 = $data[14];
        $bussiness->certificate3 = $data[15];
        $bussiness->photofile = $data[18];
        if($data[20]){
            $bussiness->busid = $data[20];
            $bussiness->save();
        }else{
            $bussiness->acc_no = $clientdata->pk;
            $bussiness->create();
        }
         self::CLEARBUZ();
		echo "|<><>|";
		self::CLIENTDATA();
    }
    
    public static function CLIENTDATAMAIN(){
        $db = new DB();
        foreach ($db->query(static::$sql." WHERE clientid='".static::$clientid."'") as $row){
			static::$no_of_shares = $row['numberofshares'];
			static::$shares = $row['shareaccount_amount'];
			static::$writeoffstatus = $row['writeoffstatus'];
                        static::$interest = $row['loan_interest'];
            if($row['accounttype'] == "1"){
                foreach ($db->query(static::$sql1." WHERE acc_no='".static::$clientid."'") as $row1){
                    static::$accountname = $row['accountname'];     	static::$accountno = $row['accountno'];             	static::$firstname = $row1['firstname'];
                    static::$secondname = $row1['secondname'];       	static::$lastname = $row1['lastname'];               	static::$gender = $row1['gender'];
                    static::$mobilenumber = $row1['mobilenumber'];   	static::$physicaladress = $row1['physicaladress'];   	static::$subcounty = $row1['subcounty'];
                    static::$district = $row1['district'];           	static::$savingaccount =   $row['savingaccount'];    	static::$loanaccount = $row['loanaccount'];
					static::$photo = $row1['photo'];
				}
            }
            if($row['accounttype'] == "2"){
				foreach ($db->query(static::$sql2." WHERE acc_no='".static::$clientid."'") as $row1){
                    static::$accountname = $row['accountname'];     		static::$accountno = $row['accountno'];             
                    static::$physicaladress = $row1['physicaladress'];   	static::$district = $row1['district'];
					static::$savingaccount =   $row['savingaccount'];    	static::$loanaccount = $row['loanaccount'];
                
					$data = "";
					$data1 = "";
					foreach ($db->query(static::$sql2." WHERE acc_no='".$row["clientid"]."'") as $row2){
						$data .=", ".$row2['mobilenumber'];
						$data1 .=", ".$row2['subcounty'];
					}
					static::$mobilenumber = $data;
					static::$subcounty = $data1;
            }
            
        }
		if($row['accounttype'] == "3"){
			foreach ($db->query(static::$sql3." WHERE acc_no='".static::$clientid."'") as $row1){
				static::$accountname = $row['accountname'];     	static::$accountno = $row['accountno'];             	static::$firstname = $row1['firstname'];
				static::$secondname = $row1['secondname'];       	static::$lastname = $row1['lastname'];               	static::$gender = $row1['gender'];
				static::$mobilenumber = $row1['officetel'];   	static::$physicaladress = $row1['physicaladress'];   	static::$subcounty = $row1['subcounty'];
				static::$district = $row1['district'];           	static::$savingaccount =   $row['savingaccount'];    	static::$loanaccount = $row['loanaccount'];
				static::$photo = $row1['photofile'];
			}
		}

		}
	}

    public static function CLIENTDATA(){
        $db = new DB();
        foreach ($db->query("SELECT COUNT(clientid) as totclient FROM clients") as $clientrow){}
        foreach ($db->query("SELECT COUNT(clientid) as totclient FROM clients WHERE accounttype='1'") as $clientrow1){}
        foreach ($db->query("SELECT COUNT(clientid) as totclient FROM clients WHERE accounttype='2'") as $clientrow2){}
        foreach ($db->query("SELECT COUNT(clientid) as totclient FROM clients WHERE accounttype='3'") as $clientrow3){}
        foreach ($db->query("SELECT COUNT(indid) as totclient FROM individualaccount WHERE gender='Male'") as $clientrow4){}
        foreach ($db->query("SELECT COUNT(indid) as totclient FROM individualaccount WHERE gender='Female'") as $clientrow5){}
        foreach ($db->query("SELECT COUNT(indid) as totclient FROM individualaccount WHERE gender='Female Youth'") as $clientrow8){}
        foreach ($db->query("SELECT COUNT(indid) as totclient FROM individualaccount WHERE gender='Male Youth'") as $clientrow9){}
        foreach ($db->query("SELECT COUNT(groupid) as totclient FROM groupaccount WHERE gender='Male'") as $clientrow6){}
        foreach ($db->query("SELECT COUNT(groupid) as totclient FROM groupaccount WHERE gender='Female'") as $clientrow7){}
        echo '
                <div class="alert alert-success" style="background-color: #8bc34a">
                    <table width="100%">
                        <tr>
                            <td><b style="font-weight: 900;font-size: 17px;color: #ffffff">Total Male: </b></td>
                            <td><b style="font-weight: 900;font-size: 17px;color: #ffffff">&nbsp;&nbsp; '.number_format($clientrow4['totclient']+$clientrow6['totclient']).'</b></td>
                        </tr>
                        <tr>
                            <td><b style="font-weight: 900;font-size: 17px;color: #ffffff">Total Female: </b></td>
                            <td><b style="font-weight: 900;font-size: 17px;color: #ffffff">&nbsp;&nbsp; '.number_format($clientrow5['totclient']+$clientrow7['totclient']).'</b></td>
                        </tr>
                        <tr>
                            <td><b style="font-weight: 900;font-size: 17px;color: #ffffff">Total Male Youth: </b></td>
                            <td><b style="font-weight: 900;font-size: 17px;color: #ffffff">&nbsp;&nbsp; '.number_format($clientrow9['totclient']).'</b></td>
                        </tr>
                        <tr>
                            <td><b style="font-weight: 900;font-size: 17px;color: #ffffff">Total Female Youth: </b></td>
                            <td><b style="font-weight: 900;font-size: 17px;color: #ffffff">&nbsp;&nbsp; '.number_format($clientrow8['totclient']).'</b></td>
                        </tr>
                    </table>
                    <hr>
                    <table width="100%">
                        <tr>
                            <td><b style="font-weight: 900;font-size: 17px;color: #ffffff">Individual Clients:</b></td>
                            <td><b style="font-weight: 900;font-size: 17px;color: #ffffff">&nbsp;&nbsp; '.number_format($clientrow1['totclient']).'</b></td>
                        </tr>
                        <tr>
                            <td><b style="font-weight: 900;font-size: 17px;color: #ffffff">Group Clients:  </b></td>
                            <td><b style="font-weight: 900;font-size: 17px;color: #ffffff">&nbsp;&nbsp; '.number_format($clientrow2['totclient']).'</b></td>
                        </tr>
                        <tr>
                            <td><b style="font-weight: 900;font-size: 17px;color: #ffffff">Business Clients:  </b></td>
                            <td><b style="font-weight: 900;font-size: 17px;color: #ffffff">&nbsp;&nbsp; '.number_format($clientrow3['totclient']).'</b></td>
                        </tr>
                        <tr>
                            <td><b style="font-weight: 900;font-size: 17px;color: #ffffff">Total Clients: </b></td>
                            <td><b style="font-weight: 900;font-size: 17px;color: #ffffff">&nbsp;&nbsp; '.number_format($clientrow['totclient']).'</b></td>
                        </tr>
                    </table>

                </div>
                <table cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered table-striped m-n" id="grn">
                    <thead>
                        <tr class="info">
                             <th width = "40%">Holder Description</th>
                             <th width = "20%">Opened Date</th>
                             <th width = "25%">Account Type</th>
                             <th width = "15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($db->query(static::$sql. " ORDER BY clientid ASC") as $row){
            if($row['accounttype'] == "1"){
                foreach ($db->query(static::$sql1." WHERE acc_no='".$row["clientid"]."'") as $row1){
                    echo '<tr>';
                    echo '<td data-order="1"><b style="color: #3C8DBC">'.$row['accountname'].'</b><br><b>'.$row['accountno'].'</b></td>';
                    echo '<td>'.$row['regdate'].'</td>';
                    echo '<td>'.(($row['accounttype']=="1")?"<b>Individual Account</b>":(($row['accounttype']=="2")?"<b style='color: #27a7b4'>Group Account</b>":(($row['accounttype']=="3")?"<b style='color: #af1100'>Business Account</b>":""))).'</td>';
                    echo '
						<td>
							<center>
								<i style="color: #2053ac" onclick="'.(($row['accounttype']=="1")?'individualdetail('.$row1['indid'].')':"").'" '.(($row['accounttype']=="1")?"data-target='#transactionsmodal'":(($row['accounttype']=="2")?:(($row['accounttype']=="3")?:""))).' data-toggle="modal" class="fa fa-eye fa-2x"></i>
								<i onclick="'.(($row['accounttype']=="1")?'editindividualdetail('.$row1['indid'].')':"").'" class="fa fa-pencil fa-2x""></i>
							</center>
						</td>';
                    echo '</tr>';
                }
            }
            if($row['accounttype'] == "2"){
                echo '<tr>';
                echo '<td data-order="1"><b style="color: #3C8DBC">'.$row['accountname'].'</b><br><b>'.$row['accountno'].'</b></td>';
                echo '<td>'.$row['regdate'].'</td>';
                echo '<td>'.(($row['accounttype']=="1")?"<b>Group Account</b>":(($row['accounttype']=="2")?"<b style='color: #27a7b4'>Group Account</b>":(($row['accounttype']=="3")?"<b style='color: #af1100'>Business Account</b>":""))).'</td>';
                echo '
                    <td>
						<center>
							<i style="color: #2053ac" onclick="'.(($row['accounttype']=="2")?'groupdetail('.$row['clientid'].')':"").'" data-target="#groupmodal" data-toggle="modal" class="fa fa-eye fa-2x"></i>
							<i onclick="'.(($row['accounttype']=="2")?'editgroupdetail('.$row['clientid'].')':"").'"  class="fa fa-pencil fa-2x""></i>
						</center>
                    </td>';
                echo '</tr>';
            }
            if($row['accounttype'] == "3"){
                echo '<tr>';
                echo '<td data-order="1"><b style="color: #3C8DBC">'.$row['accountname'].'</b><br><b>'.$row['accountno'].'</b></td>';
                echo '<td>'.$row['regdate'].'</td>';
                echo '<td>'.(($row['accounttype']=="1")?"<b>Group Account</b>":(($row['accounttype']=="2")?"<b style='color: #27a7b4'>Group Account</b>":(($row['accounttype']=="3")?"<b style='color: #af1100'>Business Account</b>":""))).'</td>';
                echo '
                    <td>
						<center>
							<i style="color: #2053ac" onclick="'.(($row['accounttype']=="3")?'businessdetail('.$row['clientid'].')':"").'" data-target="#businessmodal" data-toggle="modal" class="fa fa-eye fa-2x"></i>
							<i onclick="'.(($row['accounttype']=="3")?'editbusinessdetail('.$row['clientid'].')':"").'" class="fa fa-pencil fa-2x""></i>
						</center>
                    </td>';
                echo '</tr>';
            }
        }
        echo '</tbody>
                </table>';

    }
    public static function CLIENTBLACKLISTWORK(){
        $db = new DB();
        echo '
                <center><h2><b>Client BlackListing Records</b></h2></center>
                <table cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered table-striped m-n" id="grn">
                    <thead>
                        <tr class="info">
                             <th width = "30%">Holder Description</th>
                             <th width = "20%">Opened Date</th>
                             <th width = "25%">Account Type</th>
                             <th width = "15%">Status</th>
                             <th width = "10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($db->query(static::$sql) as $row){
            if($row['accounttype'] == "1"){
                foreach ($db->query(static::$sql1." WHERE acc_no='".$row["clientid"]."'") as $row1){
                    echo '<tr>';
                    echo '<td><b style="color: #3C8DBC">'.$row['accountname'].'</b><br><b>'.$row['accountno'].'</b></td>';
                    echo '<td>'.$row['regdate'].'</td>';
                    echo '<td>'.(($row['accounttype']=="1")?"<b>Individual Account</b>":(($row['accounttype']=="2")?"<b style='color: #27a7b4'>Group Account</b>":(($row['accounttype']=="3")?"<b style='color: #b48f8b'>Business Account</b>":""))).'</td>';
                    echo '<td>'.(($row['blacklist']=="0")?"<b style='color: #00af6f'>Active</b>":"<b style='color: #af0005'>Black Listed</b>").'</td>';
                    echo '
                                    <td>
                                        <center>
                                           <button onclick="blacklist('.$row['clientid'].')" class="btn btn-danger btn-sm"><i class="ti ti-close"></i></button>
                                           <button onclick="undoblacklist('.$row['clientid'].')" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>
                                        </center>
                                    </td>';
                    echo '</tr>';
                }
            }
            if($row['accounttype'] == "2"){
                echo '<tr>';
                echo '<td><b style="color: #3C8DBC">'.$row['accountname'].'</b><br><b>'.$row['accountno'].'</b></td>';
                echo '<td>'.$row['regdate'].'</td>';
                echo '<td>'.(($row['accounttype']=="1")?"<b>Group Account</b>":(($row['accounttype']=="2")?"<b style='color: #27a7b4'>Group Account</b>":(($row['accounttype']=="3")?"<b style='color: #b48f8b'>Business Account</b>":""))).'</td>';
                echo '<td>'.(($row['blacklist']=="0")?"<b style='color: #00af6f'>Active</b>":"<b style='color: #af0005'>Black Listed</b>").'</td>';
                echo '
                                    <td>
                                        <center>
                                           <button onclick="blacklist('.$row['clientid'].')" class="btn btn-danger btn-sm"><i class="ti ti-close"></i></button>
                                           <button onclick="undoblacklist('.$row['clientid'].')" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>
                                        </center>
                                    </td>';
                echo '</tr>';
            }
            if($row['accounttype'] == "3"){
                echo '<tr>';
                echo '<td><b style="color: #3C8DBC">'.$row['accountname'].'</b><br><b>'.$row['accountno'].'</b></td>';
                echo '<td>'.$row['regdate'].'</td>';
                echo '<td>'.(($row['accounttype']=="1")?"<b>Group Account</b>":(($row['accounttype']=="2")?"<b style='color: #27a7b4'>Group Account</b>":(($row['accounttype']=="3")?"<b style='color: #b48f8b'>Business Account</b>":""))).'</td>';
                echo '<td>'.(($row['blacklist']=="0")?"<b style='color: #00af6f'>Active</b>":"<b style='color: #af0005'>Black Listed</b>").'</td>';
                echo '
                                    <td>
                                        <center>
                                           <button onclick="blacklist('.$row['clientid'].')" class="btn btn-danger btn-sm"><i class="ti ti-close"></i></button>
                                           <button onclick="undoblacklist('.$row['clientid'].')" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>
                                        </center>
                                    </td>';
                echo '</tr>';
            }
        }
        echo '</tbody>
                </table>';

    }
    public static function CLIENTBLACKLISTRETREIVE(){
        $db = new DB();
        echo '
                <center><h2><b>Retrieved Clients List</b></h2></center>
                <table cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered table-striped m-n" id="grat1">
                    <thead>
                        <tr class="info">
                             <th width = "30%">Holder Description</th>
                             <th width = "20%">Opened Date</th>
                             <th width = "25%">Account Type</th>
                             <th width = "25%">Status</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($db->query(static::$sql." WHERE retr='1'") as $row){
            if($row['accounttype'] == "1"){
                foreach ($db->query(static::$sql1." WHERE acc_no='".$row["clientid"]."'") as $row1){
                    echo '<tr>';
                    echo '<td><b style="color: #3C8DBC">'.$row['accountname'].'</b><br><b>'.$row['accountno'].'</b></td>';
                    echo '<td>'.$row['regdate'].'</td>';
                    echo '<td>'.(($row['accounttype']=="1")?"<b>Individual Account</b>":(($row['accounttype']=="2")?"<b style='color: #27a7b4'>Group Account</b>":(($row['accounttype']=="3")?"<b style='color: #b48f8b'>Business Account</b>":""))).'</td>';
                    echo '<td>'.(($row['blacklist']=="0")?"<b style='color: #00af6f'>Active</b>":"<b style='color: #af0005'>BlackList</b>").'</td>';

                }
            }
            if($row['accounttype'] == "2"){
                echo '<tr>';
                echo '<td><b style="color: #3C8DBC">'.$row['accountname'].'</b><br><b>'.$row['accountno'].'</b></td>';
                echo '<td>'.$row['regdate'].'</td>';
                echo '<td>'.(($row['accounttype']=="1")?"<b>Group Account</b>":(($row['accounttype']=="2")?"<b style='color: #27a7b4'>Group Account</b>":(($row['accounttype']=="3")?"<b style='color: #b48f8b'>Business Account</b>":""))).'</td>';
                echo '<td>'.(($row['blacklist']=="0")?"<b style='color: #00af6f'>Active</b>":"<b style='color: #af0005'>BlackList</b>").'</td>';

            }
        }
        echo '</tbody>
                </table>';

    }
    public static function CLIENTBLACKLIST(){
        $db = new DB();
        echo '
                <center><h2><b>BlackListed Client List</b></h2></center>
                <table cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered table-striped m-n" id="example">
                    <thead>
                        <tr class="info">
                             <th width = "30%">Holder Description</th>
                             <th width = "20%">Opened Date</th>
                             <th width = "25%">Account Type</th>
                             <th width = "25%">Status</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($db->query(static::$sql." WHERE blacklist='1'") as $row){
            if($row['accounttype'] == "1"){
                foreach ($db->query(static::$sql1." WHERE acc_no='".$row["clientid"]."'") as $row1){
                    echo '<tr>';
                    echo '<td><b style="color: #3C8DBC">'.$row['accountname'].'</b><br><b>'.$row['accountno'].'</b></td>';
                    echo '<td>'.$row['regdate'].'</td>';
                    echo '<td>'.(($row['accounttype']=="1")?"<b>Individual Account</b>":(($row['accounttype']=="2")?"<b style='color: #27a7b4'>Group Account</b>":(($row['accounttype']=="3")?"<b style='color: #b48f8b'>Business Account</b>":""))).'</td>';
                    echo '<td>'.(($row['blacklist']=="0")?"<b style='color: #00af6f'>Active</b>":"<b style='color: #af0005'>BlackList</b>").'</td>';

                }
            }
            if($row['accounttype'] == "2"){
                echo '<tr>';
                echo '<td><b style="color: #3C8DBC">'.$row['accountname'].'</b><br><b>'.$row['accountno'].'</b></td>';
                echo '<td>'.$row['regdate'].'</td>';
                echo '<td>'.(($row['accounttype']=="1")?"<b>Group Account</b>":(($row['accounttype']=="2")?"<b style='color: #27a7b4'>Group Account</b>":(($row['accounttype']=="3")?"<b style='color: #b48f8b'>Business Account</b>":""))).'</td>';
                echo '<td>'.(($row['blacklist']=="0")?"<b style='color: #00af6f'>Active</b>":"<b style='color: #af0005'>BlackList</b>").'</td>';

            }
            if($row['accounttype'] == "3"){
                echo '<tr>';
                echo '<td><b style="color: #3C8DBC">'.$row['accountname'].'</b><br><b>'.$row['accountno'].'</b></td>';
                echo '<td>'.$row['regdate'].'</td>';
                echo '<td>'.(($row['accounttype']=="1")?"<b>Group Account</b>":(($row['accounttype']=="2")?"<b style='color: #27a7b4'>Group Account</b>":(($row['accounttype']=="3")?"<b style='color: #b48f8b'>Business Account</b>":""))).'</td>';
                echo '<td>'.(($row['blacklist']=="0")?"<b style='color: #00af6f'>Active</b>":"<b style='color: #af0005'>BlackList</b>").'</td>';

            }
        }
        echo '</tbody>
                </table>';

    }
    public static function CLIENTCONTACTS(){
        $db = new DB();
        echo '
                <center><h2><b>Client Contact List</b></h2></center>
                <table cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered table-striped m-n" id="example">
                    <thead>
                        <tr class="info">
                             <th width = "30%">Holder Description</th>
                             <th width = "20%">Opened Date</th>
                             <th width = "20%">Account Type</th>
                             <th width = "30%">Contact</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($db->query(static::$sql) as $row){
            if($row['accounttype'] == "1"){
                foreach ($db->query(static::$sql1." WHERE acc_no='".$row["clientid"]."'") as $row1){
                    echo '<tr>';
                    echo '<td><b style="color: #3C8DBC">'.$row['accountname'].'</b><br><b>'.$row['accountno'].'</b></td>';
                    echo '<td>'.$row['regdate'].'</td>';
                    echo '<td>'.(($row['accounttype']=="1")?"<b>Individual Account</b>":(($row['accounttype']=="2")?"<b style='color: #27a7b4'>Group Account</b>":(($row['accounttype']=="3")?"<b style='color: #b48f8b'>Business Account</b>":""))).'</td>';
                    echo '<td>'.$row1['mobilenumber'].'</td>';

                }
            }
            if($row['accounttype'] == "2"){
                    echo '<tr>';
                    echo '<td><b style="color: #3C8DBC">'.$row['accountname'].'</b><br><b>'.$row['accountno'].'</b></td>';
                    echo '<td>'.$row['regdate'].'</td>';
                    echo '<td>'.(($row['accounttype']=="1")?"<b>Group Account</b>":(($row['accounttype']=="2")?"<b style='color: #27a7b4'>Group Account</b>":(($row['accounttype']=="3")?"<b style='color: #b48f8b'>Business Account</b>":""))).'</td>';
                    echo '<td>';
                    $data = "";
                        foreach ($db->query(static::$sql2." WHERE acc_no='".$row["clientid"]."'") as $row2){
                            $data .=", ".$row2['mobilenumber'];
                        }
                        echo $data;
                    echo'</td>';
            }
            if($row['accounttype'] == "3"){
                    echo '<tr>';
                    echo '<td><b style="color: #3C8DBC">'.$row['accountname'].'</b><br><b>'.$row['accountno'].'</b></td>';
                    echo '<td>'.$row['regdate'].'</td>';
                    echo '<td>'.(($row['accounttype']=="1")?"<b>Group Account</b>":(($row['accounttype']=="2")?"<b style='color: #27a7b4'>Group Account</b>":(($row['accounttype']=="3")?"<b style='color: #b48f8b'>Business Account</b>":""))).'</td>';
                    
					foreach ($db->query(static::$sql3." WHERE acc_no='".$row["clientid"]."'") as $row2){
						echo '<td>'.$row2['officetel'].'</td>';
					}
            }
        }
        echo '</tbody>
                </table>';

    }

    public static function INDIVIDUALDATA(){
        $db = new DB();
        foreach ($db->query(static::$sql1." i, clients c WHERE c.clientid = i.acc_no AND i.indid='".$_GET['individualdata']."'") as $row){
            echo '
                <div class="row">
                    <div class="col-md-6">
                        <center><h4 style="color: #3C8DBC"><b>Client Data</b></h4></center>
						
                        <table width="100%">
                            <tr>
                                <td style="font-size: 12px" width="40%"><label class="control-label">Client Names: </label></td>
                                <td width="60%"> '.$row['firstname'].' '.$row['secondname'].' '.$row['lastname'].'</td>
                            </tr>
                            <tr>
                                <td style="font-size: 12px"><label class="control-label">Gender: </label></td>
                                <td>'.$row['gender'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Date of Birth: </label></td>
                                <td>'.$row['dateofbirth'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Marital Status: </label></td>
                                <td>'.$row['maritalstatus'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Occupation: </label></td>
                                <td>'.$row['occupation'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Employer: </label></td>
                                <td>'.$row['employer'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Mobile Number: </label></td>
                                <td>'.$row['mobilenumber'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Physical Address: </label></td>
                                <td>'.$row['physicaladress'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Sub County: </label></td>
                                <td>'.$row['subcounty'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">District: </label></td>
                                <td>'.$row['district'].'</td>
                            </tr>
                        </table>
                            <h5 style="color: #3C8DBC;margin-left: 20%"><b>Next of Kin</b></h5>
                        <table width="100%">
                             <tr>
                                <td style="font-size: 12px" width="40%"><label class="control-label">Names: </label></td>
                                <td width="60%">'.$row['kinname'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Relationship: </label></td>
                                <td>'.$row['relationship'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Address: </label></td>
                                <td>'.$row['address'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Contact Details: </label></td>
                                <td>'.$row['contactdetails'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Security Question: </label></td>
                                <td>'.$row['securityqtn'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Answer: </label></td>
                                <td>'.$row['answer'].'</td>
                            </tr>
                        </table>
                        </div>
                    <div class="col-md-6">
                        <table>
                            <tr>
                                <td width="50%"><label class="control-label">Account Name: </label></td>
                                <td width="50%">'.$row['accountname'].'</td>
                            </tr>
                            <tr>
                                <td><label class="control-label">Account No.: </label></td>
                                <td>'.$row['accountno']. '</td>
                            </tr>
                        </table><br><br>
                        <center><img src="'.(($row['photo'])?"classes/upload/".$row['photo']:"images/default.png").'" class="img-rounded"  style="width; 300px;height:300px;image-orientation:from-image"></center>
                    </div>
                </div>
                ';
        }
    }
    public static function GROUPDATA(){
        $db = new DB();
        foreach ($db->query(static::$sql." WHERE clientid ='".$_GET['groupdata']."'") as $row){
            echo '
                <center>
                    <table>
                        <tr>
                            <td width="50%" style="font-size: 12px"><label class="control-label">Account Name: </label></td>
                            <td width="50%">'.$row['accountname'].'</td>
                        </tr>
                        <tr>
                            <td><label class="control-label" style="font-size: 12px">Account No.: </label></td>
                            <td>'.$row['accountno'].'</td>
                        </tr>
                    </table></center>
                ';
        }
        echo '<div class="row">';
        foreach ($db->query(static::$sql2." i, clients c WHERE c.clientid = i.acc_no AND i.acc_no='".$_GET['groupdata']."'") as $row){
            echo '
                    <div class="col-md-4">
                        <center><h4 style="color: #3C8DBC"><b>Client Data</b></h4></center>
                        <center><img src="'.(($row['photofile'])?"classes/upload/".$row['photofile']:"images/default.png").'" class="img-rounded" style="width; 100px;height:100px;image-orientation:from-image"></center>
                        <table width="100%">
                            <tr>
                                <td width="40%" style="font-size: 12px"><label class="control-label">Client Names: </label></td>
                                <td width="60%"> ' .$row['firstname'].' '.$row['middlename'].' '.$row['lastname'].'</td>
                            </tr>
                            <tr>
                                <td style="font-size: 12px"><label class="control-label">Gender: </label></td>
                                <td>'.$row['gender'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Date of Birth: </label></td>
                                <td>'.$row['dateofbirth'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Marital Status: </label></td>
                                <td>'.$row['maritalstatus'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Occupation: </label></td>
                                <td>'.$row['occupation'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Employer: </label></td>
                                <td>'.$row['employer'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Mobile Number: </label></td>
                                <td>'.$row['mobilenumber'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Physical Address: </label></td>
                                <td>'.$row['physicaladress'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Sub County: </label></td>
                                <td>'.$row['subcounty'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">District: </label></td>
                                <td>'.$row['district'].'</td>
                            </tr>
                        </table>
                            <h5 style="color: #3C8DBC;margin-left: 20%"><b>Next of Kin</b></h5>
                        <table width="100%">
                             <tr>
                                <td width="40%" style="font-size: 12px"><label class="control-label">Names: </label></td>
                                <td width="60%">'.$row['nextofkin'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Relationship: </label></td>
                                <td>'.$row['relationship'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Address: </label></td>
                                <td>'.$row['address'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Contact Details: </label></td>
                                <td>'.$row['contactdetail'].'</td>
                            </tr>
                        </table>
                        </div>
                ';
        }
        echo '</div>';
    }
    public static function BUSINESSDATA(){
        $db = new DB();
        echo '<div class="row">';
        foreach ($db->query(static::$sql3." i, clients c WHERE c.clientid = i.acc_no AND i.acc_no='".$_GET['businessdata']."'") as $row){
            echo '
                    <center>
                        <table>
                            <tr>
                                <td width="50%" style="font-size: 14px"><label class="control-label">Account Name: </label></td>
                                <td width="50%">'.$row['accountname'].'</td>
                            </tr>
                            <tr>
                                <td><label class="control-label" style="font-size: 14px">Account No.: </label></td>
                                <td>'.$row['accountno'].'</td>
                            </tr>
                        </table>
                    </center>

                    <div class="col-md-12">
                        <center><h4 style="color: #3C8DBC"><b>Client Data</b></h4></center>

                        <table width="100%">
                            <tr>
                                <td style="font-size: 12px" width="60%"><label class="control-label">Details of Nature of Business / Sector </label></td>
                                <td width="40%"> '.$row['natureofbusines'].'</td>
                            </tr>
                            <tr>
                                <td style="font-size: 12px"><label class="control-label">Certificate of Registration/ Incorporation </label></td>
                                <td>'.$row['certificateofreg'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Date Of Business/ Company/ Institution Registration </label></td>
                                <td>'.$row['registrationdate'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Office Tel.No/ Mobile No.</label></td>
                                <td>'.$row['officetel'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Email Address </label></td>
                                <td>'.$row['email'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Business /Institution Location/ (Town / Shopping Center) </label></td>
                                <td>'.$row['businesslocation'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">T.I.N (If Any) </label></td>
                                <td>'.$row['tin'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Physical Address: </label></td>
                                <td>'.$row['physicaladdress'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">Sub County: </label></td>
                                <td>'.$row['subcounty'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 12px"><label class="control-label">District: </label></td>
                                <td>'.$row['district'].'</td>
                            </tr>
                        </table>
                            <center><h5 style="color: #3C8DBC;"><b>Account Signatory(s)</b></h5></center>
                        <table width="100%">
                             <tr>
                                <td width="50%"><label class="control-label">Names in Full </label></td>
                                <td width="50%"><label class="control-label">National ID/ Passport No.</label></td>
                            </tr>
                             <tr>
                                <td style="font-size: 16px">'.$row['name1'].'</td>
                                <td>'.$row['certificate1'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 16px">'.$row['name2'].'</td>
                                <td>'.$row['certificate2'].'</td>
                            </tr>
                             <tr>
                                <td style="font-size: 16px">'.$row['name3'].'</td>
                                <td>'.$row['certificate3'].'</td>
                            </tr>
                        </table>
                        </div>
                    <div class="col-md-12">
                        <br><br>
                        <center><img src="'.(($row['photofile'])?"classes/upload/".$row['photofile']:"images/default.png").'" class="img-rounded" style="width; 400px;height:400px;image-orientation:from-image"></center>
                    </div>
                </div>
                ';
        }
        echo '</div>';
    }

    public static function CLEARIND(){
		 echo '
                <div class="col-md-12"><center><b style="color: #3C8DBC">Applicant Details</b><br><br></center></div>
                    <div class="col-md-6">
                        <label class="labelcolor">First Name</label>
                        <input id="fname" type="text" class="form-control" value="'.$row['firstname'].'">
                        <label class="labelcolor">Last Name</label>
                        <input id="lname" type="text" class="form-control" value="'.$row['lastname'].'">
                        <label class="labelcolor">ID/Passport No.</label>
                        <input id="idnum" type="text" class="form-control" value="'.$row['nationalidno'].'">
                        <label class="labelcolor">Nationality</label>
                        <input id="nationality" type="text" class="form-control" value="'.$row['nationality'].'">
                        <label class="labelcolor">Occupation</label>
                        <input id="occupation" type="text" class="form-control" value="'.$row['occupation'].'">
                        <label class="labelcolor">Mobile Number</label>
                        <input id="mobilenumber" type="text" class="form-control" value="'.$row['mobilenumber'].'">
                        <label class="labelcolor">Sub County</label>
                        <input id="subcounty" type="text" class="form-control" value="'.$row['subcounty'].'">
                    </div>
                    <div class="col-md-6">
                        <label class="labelcolor">Middle Name</label>
                        <input id="mname" type="text" class="form-control" value="'.$row['secondname'].'">
                        <label class="labelcolor">Sex</label>
                        <select id="gender" class="form-control">
                            <option value="'.$row['gender'].'">'.$row['gender'].'</option>
                            <option value="">select gender</option>
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
							<option value="Female Youth">Female Youth</option>
							<option value="Youth Male">Youth Male</option>
                            <option value="Other">other</option>
                        </select>
                        <label class="labelcolor">Date of Birth</label>
                        <input id="dateofbirth" type="text" class="form-control" value="'.$row['dateofbirth'].'">
                        <label class="labelcolor">Marital Status</label>
                        <select id="maritalstatus" class="form-control">
                            <option value="'.$row['maritalstatus'].'">'.$row['maritalstatus'].'</option>
                            <option value="">select status</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
                            <option value="Other">other</option>
                        </select>
                        <label class="labelcolor">Employer</label>
                        <input id="employer" type="text" class="form-control" value="'.$row['employer'].'">
                        <label class="labelcolor">Physical Address/Village</label>
                        <input id="physicaladdress" class="form-control" value="'.$row['physicaladdress'].'">
                         <label class="labelcolor">District</label>
                        <input id="district" type="text" class="form-control" value="'.$row['district'].'"><br><br>
                    </div>
                    <div class="col-md-12"><center><b style="color: #3C8DBC">Next of Kin</b><br><br></center></div>
                    <div class="col-md-6">
                        <label class="labelcolor">Names</label>
                        <input id="kname" type="text" class="form-control" value="'.$row['kinname'].'">
                        <label class="labelcolor">Address</label>
                        <input id="kaddress" type="text" class="form-control" value="'.$row['address'].'">
                        <label class="labelcolor">Security Question</label>
                        <input id="security" type="text" class="form-control" value="'.$row['securityqtn'].'">
                    </div>
                    <div class="col-md-6">
                        <label class="labelcolor">Relationship</label>
                        <input id="krelationship" type="text" class="form-control" value="'.$row['relationship'].'">
                        <label class="labelcolor">Contact Detail</label>
                        <input id="contactdetail" type="text" class="form-control" value="'.$row['contactdetails'].'">
                        <label class="labelcolor">Answer</label>
                        <input id="sanswer" type="text" class="form-control" value="'.$row['answer'].'"><br><br>
                    </div>
					
                    <div class="col-md-8">
						<label class="labelcolor">Browse to Add Applicant Photo</label>
						<input class="" type="file" name="file1" id="file" onchange="readURL(this);" />
					</div>
					<div class="col-md-4" id="imageplace">
						<img id="blah" src="'.(($row['photo'])?"classes/upload/".$row['photo']:"images/default.png").'" class="img-rounded" style="width; 100px;height:100px;image-orientation:from-image"/>
						</b><br><br>
					</div>
                    
					<div class="col-md-12"><center><b style="color: #3C8DBC">Account Details</b><br><br></center></div>
                    <div class="col-md-6">
                        <label class="labelcolor">Account Name</label>
                        <input id="accountname" type="text" class="form-control" value="'.$row['accountname'].'">
                    </div>
                    <div class="col-md-6">
                         <label class="labelcolor">Account Number</label>
                        <input id="accountnumber" type="text" class="form-control" value="'.$row['accountno'].'"><br><br>
                    </div>
                ';
	}
    public static function CLEARGRP(){
		 echo '
            <div hidden id="accountdataid">'.$_GET['groupeditdata'].'</div>
            <input id="userpic1" hidden value="'.$photofile1[1].'" name="userpic1">
            <input id="userpic2" hidden value="'.$photofile1[2].'" name="userpic2">
            <input id="userpic3" hidden value="'.$photofile1[3].'" name="userpic3">
            <div class="col-md-12"><center><b style="color: #3C8DBC">Account Details</b><br><br></center></div>
            <div class="col-md-12>
            <form action="#" id="basicwizard" class="form-horizontal">
            <fieldset title="1st Applicant">
            <legend></legend><div id="groupidedit1" hidden>'.$client1[1].'</div>
            <div class="col-md-12"><center><label class="labelcolor">Browse to Add Applicant Photo</label><input class="" type="file" name="file1" accept="image/*" onchange="readURL(this);" /></b><br><br></center></div>
            <center><div id="imagespace1"><img id="blah" src="'.(($photofile1[1])?"classes/upload/".$photofile1[1]:"images/default.png").'" class="img-rounded" style="width; 100px;height:100px;image-orientation:from-image" /></div></center>
            <table class="table table-bordered">
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <tbody>
            <tr>
            <td><input value="'.$firstname1[1].'"  type="text" name="fname" id="fname"></td>
            <td><input value="'.$middlename1[1].'"  type="text" id="mname"></td>
            <td><input value="'.$lastname1[1].'"  type="text" id="lname"></td>
            </tr>
            </tbody>
            <th>ID/Passport No.</th>
            <th>Date of Birth</th>
            <th>Sex</th>
            <tbody>
            <tr>
            <td><input value="'.$passportno1[1].'" type="text" id="idnum"></td>
            <td><input value="'.$dateofbirth1[1].'" type="text" id="dob"></td>
            <td><select style="width: 100%;" id="gender"><option>'.$gender1[1].'</option><option>select gender</option><option>Female</option><option>Male</option><option>other</option></select></td>
            </tr>
            </tbody>
            <th>Nationality</th>
            <th>Mobile Number</th>
            <th>Marital Status</th>
            <tbody>
            <tr>
            <td><input value="'.$nationality1[1].'" type="text" id="nationality"></td>
            <td><input value="'.$mobilenumber1[1].'" type="text" id="mobilenumber"></td>
            <td><select style="width: 100%;" id="maritalstatus"><option>'.$maritalstatus1[1].'</option><option>select status</option><option>Single</option><option>Married</option><option>other</option></select></td>
            </tr>
            </tbody>
            <th>Occupation</th>
            <th>Employer</th>
            <th>Physical Address</th>
            <tbody>
            <tr>
            <td><input value="'.$occupation1[1].'" type="text" id="occupation"></td>
            <td><input value="'.$employer1[1].'" type="text" id="employer"></td>
            <td><input id="physicaladdress" class="form-control"></td>
            </tr>
            </tbody>
            <th>Sub County</th>
            <th>District</th>
            <th>Next of Kin</th>
            <tbody>
            <tr>
            <td><input value="'.$subcounty1[1].'" type="text" id="subcounty"></td>
            <td><input value="'.$district1[1].'" type="text" id="district"></td>
            <td><input value="'.$nextofkin1[1].'" type="text" id="kname"></td>
            </tr>
            </tbody>
            <th>Relationship</th>
            <th>Address</th>
            <th>Contact Detail</th>
            <tbody>
            <tr>
            <td><input value="'.$relationship1[1].'" type="text" id="relationship"></td>
            <td><input value="'.$address1[1].'" type="text" id="address"></td>
            <td><input value="'.$contactdetail1[1].'" type="text" id="contactdetails"></td>
            </tr>
            </tbody>
            </table>
            </fieldset>
            <fieldset title="2nd Applicant">
            <legend></legend><div id="groupidedit2" hidden>'.$client1[2].'</div>
            <div class="col-md-12"><center><label class="labelcolor">Browse to Add Applicant Photo</label><input class="" type="file" name="file2" accept="image/*" onchange="readURL1(this);" /></b><br><br></center></div>
            <center><div id="imagespace2"><img id="blah1" src="'.(($photofile1[2])?"classes/upload/".$photofile1[2]:"images/default.png").'" class="img-rounded" style="width; 100px;height:100px;image-orientation:from-image" /></div></center>
            <table class="table table-bordered">
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <tbody>
            <tr>
            <td><input value="'.$firstname1[2].'" type="text" id="fname1"></td>
            <td><input value="'.$middlename1[2].'" type="text" id="mname1"></td>
            <td><input value="'.$lastname1[2].'" type="text" id="lname1"></td>
            </tr>
            </tbody>
            <th>ID/Passport No.</th>
            <th>Date of Birth</th>
            <th>Sex</th>
            <tbody>
            <tr>
            <td><input value="'.$passportno1[2].'" type="text" id="idnum1"></td>
            <td><input value="'.$dateofbirth1[2].'" type="text" id="dob1"></td>
            <td><select style="width: 100%;" id="gender1"><option>select gender</option><option>Female</option><option>Male</option><option>other</option></select></td>
            </tr>
            </tbody>
            <th>Nationality</th>
            <th>Mobile Number</th>
            <th>Marital Status</th>
            <tbody>
            <tr>
            <td><input value="'.$nationality1[2].'" type="text" id="nationality1"></td>
            <td><input value="'.$mobilenumber1[2].'" type="text" id="mobilenumber1"></td>
            <td><select style="width: 100%;" id="maritalstatus1"><option>'.$maritalstatus1[2].'</option><option>select status</option><option>Single</option><option>Married</option><option>other</option></select></td>
            </tr>
            </tbody>
            <th>Occupation</th>
            <th>Employer</th>
            <th>Physical Address</th>
            <tbody>
            <tr>
            <td><input value="'.$occupation1[2].'" type="text" id="occupation1"></td>
            <td><input value="'.$employer1[2].'" type="text" id="employer1"></td>
            <td><input id="physicaladdress1" class="form-control"></td>
            </tr>
            </tbody>
            <th>Sub County</th>
            <th>District</th>
            <th>Next of Kin</th>
            <tbody>
            <tr>
            <td><input value="'.$subcounty1[2].'" type="text" id="subcounty1"></td>
            <td><input value="'.$district1[2].'" type="text" id="district1"></td>
            <td><input value="'.$nextofkin1[2].'" type="text" id="kname1"></td>
            </tr>
            </tbody>
            <th>Relationship</th>
            <th>Address</th>
            <th>Contact Detail</th>
            <tbody>
            <tr>
            <td><input value="'.$relationship1[2].'" type="text" id="relationship1"></td>
            <td><input value="'.$address1[2].'" type="text" id="address1"></td>
            <td><input value="'.$contactdetail1[2].'" type="text" id="contactdetails1"></td>
            </tr>
            </tbody>
            </table>
            </fieldset>
            <fieldset title="3rd Applicant">
            <legend></legend><div id="groupidedit3" hidden>'.$client1[3].'</div>
            <div class="col-md-12"><center><label class="labelcolor">Browse to Add Applicant Photo</label><input class="" type="file" name="file3" accept="image/*" onchange="readURL2(this);" /></b><br><br></center></div>
            <center><div id="imagespace3"><img id="blah2" src="'.(($photofile1[3])?"classes/upload/".$photofile1[3]:"images/default.png").'" class="img-rounded" style="width; 100px;height:100px;image-orientation:from-image" /></div></center>
            <table class="table table-bordered">
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <tbody>
            <tr>
            <td><input value="'.$firstname1[3].'" type="text" id="fname2"></td>
            <td><input value="'.$middlename1[3].'" type="text" id="mname2"></td>
            <td><input value="'.$lastname1[3].'" type="text" id="lname2"></td>
            </tr>
            </tbody>
            <th>ID/Passport No.</th>
            <th>Date of Birth</th>
            <th>Sex</th>
            <tbody>
            <tr>
            <td><input value="'.$passportno1[3].'" type="text" id="idnum2"></td>
            <td><input value="'.$dateofbirth1[3].'" type="text" id="dob2"></td>
            <td><select style="width: 100%;" id="gender2"><option>'.$gender1[3].'</option><option>select gender</option><option>Female</option><option>Male</option><option>other</option></select></td>
            </tr>
            </tbody>
            <th>Nationality</th>
            <th>Mobile Number</th>
            <th>Marital Status</th>
            <tbody>
            <tr>
            <td><input value="'.$nationality1[3].'" type="text" id="nationality2"></td>
            <td><input value="'.$mobilenumber1[3].'" type="text" id="mobilenumber2"></td>
            <td><select style="width: 100%;" id="maritalstatus2"><option>'.$maritalstatus1[3].'</option><option>select status</option><option>Single</option><option>Married</option><option>other</option></select></td>
            </tr>
            </tbody>
            <th>Occupation</th>
            <th>Employer</th>
            <th>Physical Address</th>
            <tbody>
            <tr>
            <td><input value="'.$occupation1[3].'" type="text" id="occupation2"></td>
            <td><input value="'.$employer1[3].'" type="text" id="employer2"></td>
            <td><input id="physicaladdress2" class="form-control"></td>
            </tr>
            </tbody>
            <th>Sub County</th>
            <th>District</th>
            <th>Next of Kin</th>
            <tbody>
            <tr>
            <td><input value="'.$subcounty1[3].'" type="text" id="subcounty2"></td>
            <td><input value="'.$district1[3].'" type="text" id="district2"></td>
            <td><input value="'.$nextofkin1[3].'" type="text" id="kname2"></td>
            </tr>
            </tbody>
            <th>Relationship</th>
            <th>Address</th>
            <th>Contact Detail</th>
            <tbody>
            <tr>
            <td><input value="'.$relationship1[3].'" type="text" id="relationship2"></td>
            <td><input value="'.$address1[3].'" type="text" id="address2"></td>
            <td><input value="'.$contactdetail1[3].'" type="text" id="contactdetails2"></td>
            </tr>
            </tbody>
            </table>
            </fieldset>
            <br><br>
            </form>
			</div>
            <div class="col-md-12"><center><b style="color: #3C8DBC">Account Details</b><br><br></center></div>
            <div class="col-md-6">
            <label class="labelcolor">Account Name</label>
            <input value="'.$row['accountname'].'" type="text" class="form-control" id="accountname">
            </div>
            <div class="col-md-6">
            <label class="labelcolor">Account Number</label>
            <input value="'.$row['accountno'].'" type="text" class="form-control" id="accountno"><br><br>
            </div> </div>
        ';
	}
    public static function CLEARBUZ(){
		echo '
                <div id="applicantdata"><div hidden id="buzaccountid">'.$_GET['businesseditdata'].'</div><div hidden id="buzdetailid">'.$row['busid'].'</div>
                <div class="col-md-12"><center><b style="color: #3C8DBC">Business/Institution Details</b><br><br></center></div>
                <div class="col-md-12">
				Check <b>(yes)</b> if institution/business is a school and <b>(no)</b> if not.<br>
				<table>
					<tr>
						<td><input onchange="" id="yesacc" value="1" name="optionadiosInline"  type="radio"></td>
						<td>&nbsp;Yes</td>
						<td>&nbsp;&nbsp;&nbsp;<input onchange="" id="noacc" value="0" name="optionadiosInline"  type="radio"></td>
						<td>&nbsp;No</td>
					</tr>
				</table><br><br>
                <label class="labelcolor">Details of Nature of Business / Sector</label>
                <input value="'.$row['natureofbusines'].'" id="natureofbusiness" type="text" class="form-control">
                </div>
                <div class="col-md-12">
                <label class="labelcolor">Certificate of Registration/ Incorporation</label>
                <input value="'.$row['certificateofreg'].'" id="certfofreg" type="text" class="form-control">
                </div>
                <div class="col-md-12">
                <label class="labelcolor">Date Of Business/ Company/ Institution Registration</label>
                <input value="'.$row['registrationdate'].'" id="dateofbusiness" type="text" class="form-control">
                </div>
                <div class="col-md-6">
                <label class="labelcolor">Office Tel.No/ Mobile No.</label>
                <input value="'.$row['officetel'].'" id="mobilenumber" type="text" class="form-control">
                </div>
                <div class="col-md-6">
                <label class="labelcolor">Email Address</label>
                <input value="'.$row['email'].'" id="emailaddress" type="text" class="form-control">
                </div>
                <div class="col-md-12">
                <label class="labelcolor">Business /Institution Location/ (Town / Shopping Center)</label>
                <input value="'.$row['businesslocation'].'" id="location" type="text" class="form-control">
                </div><div class="col-md-6">
                <label class="labelcolor">T.I.N (If Any)</label>
                <input value="'.$row['tin'].'" id="tin" type="text" class="form-control">
                </div><div class="col-md-6">
                <label class="labelcolor">Physical Address</label>
                <input value="'.$row['physicaladdress'].'" id="physicaladdress" type="text" class="form-control">
                </div>
                <div class="col-md-6">
                <label class="labelcolor">Sub County</label>
                <input value="'.$row['subcounty'].'" id="subcountry" type="text" class="form-control">
                </div>
                </div>
                <div class="col-md-6">
                <label class="labelcolor">District</label>
                <input value="'.$row['district'].'" id="district" type="text" class="form-control"><br><br>
                </div>
                <div class="col-md-8">
					<label class="labelcolor">Browse to Add Applicant Photo</label>
					<input class="" type="file" name="file1" id="file" onchange="readURL(this);" />
				</div>
				<div class="col-md-4" id="imageplace">
					<img id="blah" src="'.(($row['photo'])?"classes/upload/".$row['photo']:"images/default.png").'" class="img-rounded" style="width; 100px;height:100px;image-orientation:from-image"/>
					</b><br><br>
				</div>
				<div class="col-md-12"><center><b style="color: #3C8DBC">Account Signatory(s)</b><br><br></center></div>
                <table class="table table-bordered">
                <th>Names in Full</th>
                <th>National ID/ Passport No.</th>
                <tbody>
                <tr>
                <td><input value="'.$row['name1'].'" id="signame1" type="text"></td>
                <td><input value="'.$row['certificate1'].'" id="indent1" type="text"></td>
                </tr>
                <tr>
                <td><input value="'.$row['name2'].'" id="signame2" type="text"></td>
                <td><input value="'.$row['certificate2'].'" id="indent2" type="text"></td>
                </tr>
                <tr>
                <td><input value="'.$row['name3'].'" id="signame3" type="text"></td>
                <td><input value="'.$row['certificate3'].'" id="indent3" type="text"></td>
                </tr>
                </tbody>
                </table><br><br>

                </div>
                </div>
				
				<div class="col-md-12"><center><b style="color: #3C8DBC">Account Details</b><br><br></center></div>
                <div class="col-md-6">
                <label class="labelcolor">Account Name</label>
                <input value="'.$row['accountname'].'" id="accountname" type="text" class="form-control">
                </div>
                <div class="col-md-6">
                <label class="labelcolor">Account Number</label>
                <input value="'.$row['accountno'].'" id="accountnumber" type="text" class="form-control"><br><br>
				</div></div>
            ';
	}
	
    public static function EDIT_INDIVIDUALDATA(){
        $db = new DB();
        foreach ($db->query(static::$sql1." i, clients c WHERE c.clientid = i.acc_no AND i.indid='".$_GET['editindividualdata']."'") as $row){
            echo '
                <div id="editindacc" hidden>'.$_GET['editindividualdata'].'</div>
				<input id="userpic1" hidden value="'.$row['photo'].'" name="userpic">
                <div class="col-md-12"><center><b style="color: #3C8DBC">Applicant Details</b><br><br></center></div>
                    <div class="col-md-6">
                        <label class="labelcolor">First Name</label>
                        <input id="fname" type="text" class="form-control" value="'.$row['firstname'].'">
                        <label class="labelcolor">Last Name</label>
                        <input id="lname" type="text" class="form-control" value="'.$row['lastname'].'">
                        <label class="labelcolor">ID/Passport No.</label>
                        <input id="idnum" type="text" class="form-control" value="'.$row['nationalidno'].'">
                        <label class="labelcolor">Nationality</label>
                        <input id="nationality" type="text" class="form-control" value="'.$row['nationality'].'">
                        <label class="labelcolor">Occupation</label>
                        <input id="occupation" type="text" class="form-control" value="'.$row['occupation'].'">
                        <label class="labelcolor">Mobile Number</label>
                        <input id="mobilenumber" type="text" class="form-control" value="'.$row['mobilenumber'].'">
                        <label class="labelcolor">Sub County</label>
                        <input id="subcounty" type="text" class="form-control" value="'.$row['subcounty'].'">
                    </div>
                    <div class="col-md-6">
                        <label class="labelcolor">Middle Name</label>
                        <input id="mname" type="text" class="form-control" value="'.$row['secondname'].'">
                        <label class="labelcolor">Sex</label>
                        <select id="gender" class="form-control">
                            <option value="'.$row['gender'].'">'.$row['gender'].'</option>
                            <option value="">select gender</option>
                            <option value="Female">Female</option>
                            <option value="Male">Male</option>
                            <option value="Other">other</option>
                        </select>
                        <label class="labelcolor">Date of Birth</label>
                        <input id="dateofbirth" type="text" class="form-control" value="'.$row['dateofbirth'].'">
                        <label class="labelcolor">Marital Status</label>
                        <select id="maritalstatus" class="form-control">
                            <option value="'.$row['maritalstatus'].'">'.$row['maritalstatus'].'</option>
                            <option value="">select status</option>
                            <option value="Single">Single</option>
                            <option value="Married">Married</option>
							<option value="Male">Male</option>
							<option value="Female Youth">Female Youth</option>
                            <option value="Other">other</option>
                        </select>
                        <label class="labelcolor">Employer</label>
                        <input id="employer" type="text" class="form-control" value="'.$row['employer'].'">
                        <label class="labelcolor">Physical Address/Village</label>
                        <select id="physicaladdress" class="form-control">
                            <option value="">select Address</option>
                        </select>
                         <label class="labelcolor">District</label>
                        <input id="district" type="text" class="form-control" value="'.$row['district'].'"><br><br>
                    </div>
                    <div class="col-md-12"><center><b style="color: #3C8DBC">Next of Kin</b><br><br></center></div>
                    <div class="col-md-6">
                        <label class="labelcolor">Names</label>
                        <input id="kname" type="text" class="form-control" value="'.$row['kinname'].'">
                        <label class="labelcolor">Address</label>
                        <input id="kaddress" type="text" class="form-control" value="'.$row['address'].'">
                        <label class="labelcolor">Security Question</label>
                        <input id="security" type="text" class="form-control" value="'.$row['securityqtn'].'">
                    </div>
                    <div class="col-md-6">
                        <label class="labelcolor">Relationship</label>
                        <input id="krelationship" type="text" class="form-control" value="'.$row['relationship'].'">
                        <label class="labelcolor">Contact Detail</label>
                        <input id="contactdetail" type="text" class="form-control" value="'.$row['contactdetails'].'">
                        <label class="labelcolor">Answer</label>
                        <input id="sanswer" type="text" class="form-control" value="'.$row['answer'].'"><br><br>
                    </div>
					
                    <div class="col-md-8">
						<label class="labelcolor">Browse to Add Applicant Photo</label>
						<input class="" type="file" name="file1" id="file" onchange="readURL(this);" />
					</div>
					<div class="col-md-4" id="imageplace">
						<img id="blah" src="'.(($row['photo'])?"classes/upload/".$row['photo']:"images/default.png").'" class="img-rounded" style="width; 100px;height:100px;image-orientation:from-image"/>
						</b><br><br>
					</div>
                    
					<div class="col-md-12"><center><b style="color: #3C8DBC">Account Details</b><br><br></center></div>
                    <div class="col-md-6">
                        <label class="labelcolor">Account Name</label>
                        <input id="accountname" type="text" class="form-control" value="'.$row['accountname'].'">
                    </div>
                    <div class="col-md-6">
                         <label class="labelcolor">Account Number</label>
                        <input id="accountnumber" type="text" class="form-control" value="'.$row['accountno'].'"><br><br>
                    </div>
                ';
        }
    }
    public static function GROUPEDITDATA(){
        $db = new DB();
        $firstname ="";
        $middlename ="";
        $lastname ="";
        $passportno ="";
        $dateofbirth ="";
        $gender ="";
        $nationality ="";
        $mobilenumber ="";
        $maritalstatus ="";
        $occupation ="";
        $employer ="";
        $physicaladdress ="";
        $subcounty ="";
        $district ="";
        $address ="";
        $nextofkin ="";
        $relationship ="";
        $contactdetail ="";
        $photofile ="";
        $client ="";
        echo '<div class="row">';
        foreach ($db->query(static::$sql2." WHERE acc_no='".$_GET['groupeditdata']."'") as $row){
        //            SELECT `groupid`, `acc_no`, `firstname`, `middlename`, `lastname`, `passportno`, `dateofbirth`,
        //            `gender`, `nationality`, `mobilenumber`, `maritalstatus`, `occupation`, `employer`, `physicaladdress`, `subcounty`,
        //             `district`, `address`, `nextofkin`, `relationship`, `contactdetail`, `photofile` FROM `groupaccount` WHERE 1
            $firstname .= "?::?".$row['firstname'];
            $middlename .= "?::?".$row['middlename'];
            $lastname .= "?::?".$row['lastname'];
            $passportno .= "?::?".$row['passportno'];
            $dateofbirth .= "?::?".$row['dateofbirth'];
            $gender .= "?::?".$row['gender'];
            $nationality .= "?::?".$row['nationality'];
            $mobilenumber .= "?::?".$row['mobilenumber'];
            $maritalstatus .= "?::?".$row['maritalstatus'];
            $occupation .= "?::?".$row['occupation'];
            $employer .= "?::?".$row['employer'];
            $physicaladdress .= "?::?".$row['physicaladdress'];
            $subcounty .= "?::?".$row['subcounty'];
            $district .= "?::?".$row['district'];
            $address .= "?::?".$row['address'];
            $nextofkin .= "?::?".$row['nextofkin'];
            $relationship .= "?::?".$row['relationship'];
            $contactdetail .= "?::?".$row['contactdetail'];
            $photofile .= "?::?".$row['photofile'];
            $client .= "?::?".$row['groupid'];
        }
        $firstname1 = explode("?::?",$firstname) ;
        $middlename1 = explode("?::?",$middlename) ;
        $lastname1 = explode("?::?",$lastname) ;
        $passportno1 = explode("?::?",$passportno) ;
        $dateofbirth1 = explode("?::?",$dateofbirth) ;
        $gender1 = explode("?::?",$gender) ;
        $nationality1 = explode("?::?",$nationality) ;
        $mobilenumber1 = explode("?::?",$mobilenumber) ;
        $maritalstatus1 = explode("?::?",$maritalstatus) ;
        $occupation1 = explode("?::?",$occupation) ;
        $employer1 = explode("?::?",$employer) ;
        $physicaladdress1 = explode("?::?",$physicaladdress) ;
        $subcounty1 = explode("?::?",$subcounty) ;
        $district1 = explode("?::?",$district) ;
        $address1 = explode("?::?",$address) ;
        $nextofkin1 = explode("?::?",$nextofkin) ;
        $relationship1 = explode("?::?",$relationship) ;
        $contactdetail1 = explode("?::?",$contactdetail) ;
        $photofile1 = explode("?::?",$photofile) ;
        $client1 = explode("?::?",$client) ;

        echo '
            <div hidden id="accountdataid">'.$_GET['groupeditdata'].'</div>
            <input id="userpic1" hidden value="'.$photofile1[1].'" name="userpic1">
            <input id="userpic2" hidden value="'.$photofile1[2].'" name="userpic2">
            <input id="userpic3" hidden value="'.$photofile1[3].'" name="userpic3">
            <div class="col-md-12"><center><b style="color: #3C8DBC">Account Details</b><br><br></center></div>
            <div class="col-md-12>
            <form action="#" id="basicwizard" class="form-horizontal">
            <fieldset title="1st Applicant">
            <legend></legend><div id="groupidedit1" hidden>'.$client1[1].'</div>
            <div class="col-md-12"><center><label class="labelcolor">Browse to Add Applicant Photo</label><input class="" type="file" name="file1" accept="image/*" onchange="readURL(this);" /></b><br><br></center></div>
            <center><div id="imagespace1"><img id="blah" src="'.(($photofile1[1])?"classes/upload/".$photofile1[1]:"images/default.png").'" class="img-rounded" style="width; 100px;height:100px;image-orientation:from-image" /></div></center>
            <table class="table table-bordered">
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <tbody>
            <tr>
            <td><input value="'.$firstname1[1].'"  type="text" name="fname" id="fname"></td>
            <td><input value="'.$middlename1[1].'"  type="text" id="mname"></td>
            <td><input value="'.$lastname1[1].'"  type="text" id="lname"></td>
            </tr>
            </tbody>
            <th>ID/Passport No.</th>
            <th>Date of Birth</th>
            <th>Sex</th>
            <tbody>
            <tr>
            <td><input value="'.$passportno1[1].'" type="text" id="idnum"></td>
            <td><input value="'.$dateofbirth1[1].'" type="text" id="dob"></td>
            <td><select style="width: 100%;" id="gender"><option>'.$gender1[1].'</option><option>select gender</option><option>Female</option><option>Male</option><option>other</option></select></td>
            </tr>
            </tbody>
            <th>Nationality</th>
            <th>Mobile Number</th>
            <th>Marital Status</th>
            <tbody>
            <tr>
            <td><input value="'.$nationality1[1].'" type="text" id="nationality"></td>
            <td><input value="'.$mobilenumber1[1].'" type="text" id="mobilenumber"></td>
            <td><select style="width: 100%;" id="maritalstatus"><option>'.$maritalstatus1[1].'</option><option>select status</option><option>Single</option><option>Married</option><option>other</option></select></td>
            </tr>
            </tbody>
            <th>Occupation</th>
            <th>Employer</th>
            <th>Physical Address</th>
            <tbody>
            <tr>
            <td><input value="'.$occupation1[1].'" type="text" id="occupation"></td>
            <td><input value="'.$employer1[1].'" type="text" id="employer"></td>
            <td><select style="width: 100%;" id="physicaladdress"><option>select address</option></select></td>
            </tr>
            </tbody>
            <th>Sub County</th>
            <th>District</th>
            <th>Next of Kin</th>
            <tbody>
            <tr>
            <td><input value="'.$subcounty1[1].'" type="text" id="subcounty"></td>
            <td><input value="'.$district1[1].'" type="text" id="district"></td>
            <td><input value="'.$nextofkin1[1].'" type="text" id="kname"></td>
            </tr>
            </tbody>
            <th>Relationship</th>
            <th>Address</th>
            <th>Contact Detail</th>
            <tbody>
            <tr>
            <td><input value="'.$relationship1[1].'" type="text" id="relationship"></td>
            <td><input value="'.$address1[1].'" type="text" id="address"></td>
            <td><input value="'.$contactdetail1[1].'" type="text" id="contactdetails"></td>
            </tr>
            </tbody>
            </table>
            </fieldset>
            <fieldset title="2nd Applicant">
            <legend></legend><div id="groupidedit2" hidden>'.$client1[2].'</div>
            <div class="col-md-12"><center><label class="labelcolor">Browse to Add Applicant Photo</label><input class="" type="file" name="file2" accept="image/*" onchange="readURL1(this);" /></b><br><br></center></div>
            <center><div id="imagespace2"><img id="blah1" src="'.(($photofile1[2])?"classes/upload/".$photofile1[2]:"images/default.png").'" class="img-rounded" style="width; 100px;height:100px;image-orientation:from-image" /></div></center>
            <table class="table table-bordered">
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <tbody>
            <tr>
            <td><input value="'.$firstname1[2].'" type="text" id="fname1"></td>
            <td><input value="'.$middlename1[2].'" type="text" id="mname1"></td>
            <td><input value="'.$lastname1[2].'" type="text" id="lname1"></td>
            </tr>
            </tbody>
            <th>ID/Passport No.</th>
            <th>Date of Birth</th>
            <th>Sex</th>
            <tbody>
            <tr>
            <td><input value="'.$passportno1[2].'" type="text" id="idnum1"></td>
            <td><input value="'.$dateofbirth1[2].'" type="text" id="dob1"></td>
            <td><select style="width: 100%;" id="gender1"><option>select gender</option><option>Female</option><option>Male</option><option>other</option></select></td>
            </tr>
            </tbody>
            <th>Nationality</th>
            <th>Mobile Number</th>
            <th>Marital Status</th>
            <tbody>
            <tr>
            <td><input value="'.$nationality1[2].'" type="text" id="nationality1"></td>
            <td><input value="'.$mobilenumber1[2].'" type="text" id="mobilenumber1"></td>
            <td><select style="width: 100%;" id="maritalstatus1"><option>'.$maritalstatus1[2].'</option><option>select status</option><option>Single</option><option>Married</option><option>other</option></select></td>
            </tr>
            </tbody>
            <th>Occupation</th>
            <th>Employer</th>
            <th>Physical Address</th>
            <tbody>
            <tr>
            <td><input value="'.$occupation1[2].'" type="text" id="occupation1"></td>
            <td><input value="'.$employer1[2].'" type="text" id="employer1"></td>
            <td><select style="width: 100%;" id="physicaladdress1"><option>select address</option></select></td>
            </tr>
            </tbody>
            <th>Sub County</th>
            <th>District</th>
            <th>Next of Kin</th>
            <tbody>
            <tr>
            <td><input value="'.$subcounty1[2].'" type="text" id="subcounty1"></td>
            <td><input value="'.$district1[2].'" type="text" id="district1"></td>
            <td><input value="'.$nextofkin1[2].'" type="text" id="kname1"></td>
            </tr>
            </tbody>
            <th>Relationship</th>
            <th>Address</th>
            <th>Contact Detail</th>
            <tbody>
            <tr>
            <td><input value="'.$relationship1[2].'" type="text" id="relationship1"></td>
            <td><input value="'.$address1[2].'" type="text" id="address1"></td>
            <td><input value="'.$contactdetail1[2].'" type="text" id="contactdetails1"></td>
            </tr>
            </tbody>
            </table>
            </fieldset>
            <fieldset title="3rd Applicant">
            <legend></legend><div id="groupidedit3" hidden>'.$client1[3].'</div>
            <div class="col-md-12"><center><label class="labelcolor">Browse to Add Applicant Photo</label><input class="" type="file" name="file3" accept="image/*" onchange="readURL2(this);" /></b><br><br></center></div>
            <center><div id="imagespace3"><img id="blah2" src="'.(($photofile1[3])?"classes/upload/".$photofile1[3]:"images/default.png").'" class="img-rounded" style="width; 100px;height:100px;image-orientation:from-image" /></div></center>
            <table class="table table-bordered">
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <tbody>
            <tr>
            <td><input value="'.$firstname1[3].'" type="text" id="fname2"></td>
            <td><input value="'.$middlename1[3].'" type="text" id="mname2"></td>
            <td><input value="'.$lastname1[3].'" type="text" id="lname2"></td>
            </tr>
            </tbody>
            <th>ID/Passport No.</th>
            <th>Date of Birth</th>
            <th>Sex</th>
            <tbody>
            <tr>
            <td><input value="'.$passportno1[3].'" type="text" id="idnum2"></td>
            <td><input value="'.$dateofbirth1[3].'" type="text" id="dob2"></td>
            <td><select style="width: 100%;" id="gender2"><option>'.$gender1[3].'</option><option>select gender</option><option>Female</option><option>Male</option><option>other</option></select></td>
            </tr>
            </tbody>
            <th>Nationality</th>
            <th>Mobile Number</th>
            <th>Marital Status</th>
            <tbody>
            <tr>
            <td><input value="'.$nationality1[3].'" type="text" id="nationality2"></td>
            <td><input value="'.$mobilenumber1[3].'" type="text" id="mobilenumber2"></td>
            <td><select style="width: 100%;" id="maritalstatus2"><option>'.$maritalstatus1[3].'</option><option>select status</option><option>Single</option><option>Married</option><option>other</option></select></td>
            </tr>
            </tbody>
            <th>Occupation</th>
            <th>Employer</th>
            <th>Physical Address</th>
            <tbody>
            <tr>
            <td><input value="'.$occupation1[3].'" type="text" id="occupation2"></td>
            <td><input value="'.$employer1[3].'" type="text" id="employer2"></td>
            <td><select style="width: 100%;" id="physicaladdress2"><option>select address</option></select></td>
            </tr>
            </tbody>
            <th>Sub County</th>
            <th>District</th>
            <th>Next of Kin</th>
            <tbody>
            <tr>
            <td><input value="'.$subcounty1[3].'" type="text" id="subcounty2"></td>
            <td><input value="'.$district1[3].'" type="text" id="district2"></td>
            <td><input value="'.$nextofkin1[3].'" type="text" id="kname2"></td>
            </tr>
            </tbody>
            <th>Relationship</th>
            <th>Address</th>
            <th>Contact Detail</th>
            <tbody>
            <tr>
            <td><input value="'.$relationship1[3].'" type="text" id="relationship2"></td>
            <td><input value="'.$address1[3].'" type="text" id="address2"></td>
            <td><input value="'.$contactdetail1[3].'" type="text" id="contactdetails2"></td>
            </tr>
            </tbody>
            </table>
            </fieldset>
            <br><br>
            </form>

        ';
        foreach ($db->query(static::$sql." WHERE clientid ='".$_GET['groupeditdata']."'") as $row){
            echo '
            </div>
            <div class="col-md-12"><center><b style="color: #3C8DBC">Account Details</b><br><br></center></div>
            <div class="col-md-6">
            <label class="labelcolor">Account Name</label>
            <input value="'.$row['accountname'].'" type="text" class="form-control" id="accountname">
            </div>
            <div class="col-md-6">
            <label class="labelcolor">Account Number</label>
            <input value="'.$row['accountno'].'" type="text" class="form-control" id="accountno"><br><br>
            </div> </div>
            ';
        }
        echo '</div></div>';
    }
    public static function BUSINESSEDITDATA(){
        $db = new DB();
        echo '<div class="row">';
        foreach ($db->query(static::$sql3." WHERE acc_no='".$_GET['businesseditdata']."'") as $row){
			foreach ($db->query(static::$sql." WHERE clientid ='".$_GET['businesseditdata']."'") as $rows){}
            echo '
                <div id="applicantdata" xmlns="http://www.w3.org/1999/html"><div hidden id="buzaccountid">'.$_GET['businesseditdata'].'</div><div hidden id="buzdetailid">'.$row['busid'].'</div>
                <div class="col-md-12"><center><b style="color: #3C8DBC">Business/Institution Details</b><br><br></center></div>
                <div class="col-md-12">
				Check <b>(yes)</b> if institution/business is a school and <b>(no)</b> if not.<br>
				<table>
					<tr>
						<td><input '.(($rows['school']=="1")?'checked':'').' onchange="" id="yesacc" value="1" name="optionadiosInline"  type="radio"></td>
						<td>&nbsp;Yes</td>
						<td>&nbsp;&nbsp;&nbsp;<input '.(($rows['school']=="0")?'checked':'').' onchange="" id="noacc" value="0" name="optionadiosInline"  type="radio"></td>
						<td>&nbsp;No</td>
					</tr>
				</table><br><br>
                <label class="labelcolor">Details of Nature of Business / Sector</label>
                <input value="'.$row['natureofbusines'].'" id="natureofbusiness" type="text" class="form-control">
                </div>
                <div class="col-md-12">
                <label class="labelcolor">Certificate of Registration/ Incorporation</label>
                <input value="'.$row['certificateofreg'].'" id="certfofreg" type="text" class="form-control">
                </div>
                <div class="col-md-12">
                <label class="labelcolor">Date Of Business/ Company/ Institution Registration</label>
                <input value="'.$row['registrationdate'].'" id="dateofbusiness" type="text" class="form-control">
                </div>
                <div class="col-md-6">
                <label class="labelcolor">Office Tel.No/ Mobile No.</label>
                <input value="'.$row['officetel'].'" id="mobilenumber" type="text" class="form-control">
                </div>
                <div class="col-md-6">
                <label class="labelcolor">Email Address</label>
                <input value="'.$row['email'].'" id="emailaddress" type="text" class="form-control">
                </div>
                <div class="col-md-12">
                <label class="labelcolor">Business /Institution Location/ (Town / Shopping Center)</label>
                <input value="'.$row['businesslocation'].'" id="location" type="text" class="form-control">
                </div><div class="col-md-6">
                <label class="labelcolor">T.I.N (If Any)</label>
                <input value="'.$row['tin'].'" id="tin" type="text" class="form-control">
                </div><div class="col-md-6">
                <label class="labelcolor">Physical Address</label>
                <input value="'.$row['physicaladdress'].'" id="physicaladdress" type="text" class="form-control">
                </div>
                <div class="col-md-6">
                <label class="labelcolor">Sub County</label>
                <input value="'.$row['subcounty'].'" id="subcountry" type="text" class="form-control">
                </div>
                </div>
                <div class="col-md-6">
                <label class="labelcolor">District</label>
                <input value="'.$row['district'].'" id="district" type="text" class="form-control"><br><br>
                </div>
                <div class="col-md-8">
					<label class="labelcolor">Browse to Add Applicant Photo</label>
					<input class="" type="file" name="file1" id="file" onchange="readURL(this);" />
				</div>
				<div class="col-md-4" id="imageplace">
					<img id="blah" src="'.(($row['photofile'])?"classes/upload/".$row['photofile']:"images/default.png").'" class="img-rounded" style="width; 100px;height:100px;image-orientation:from-image"/>
					</b><br><br>
				</div>
				<div class="col-md-12"><center><b style="color: #3C8DBC">Account Signatory(s)</b><br><br></center></div>
                <table class="table table-bordered">
                <th>Names in Full</th>
                <th>National ID/ Passport No.</th>
                <tbody>
                <tr>
                <td><input value="'.$row['name1'].'" id="signame1" type="text"></td>
                <td><input value="'.$row['certificate1'].'" id="indent1" type="text"></td>
                </tr>
                <tr>
                <td><input value="'.$row['name2'].'" id="signame2" type="text"></td>
                <td><input value="'.$row['certificate2'].'" id="indent2" type="text"></td>
                </tr>
                <tr>
                <td><input value="'.$row['name3'].'" id="signame3" type="text"></td>
                <td><input value="'.$row['certificate3'].'" id="indent3" type="text"></td>
                </tr>
                </tbody>
                </table><br><br>

                </div>
                </div>
            ';
        }

        foreach ($db->query(static::$sql." WHERE clientid ='".$_GET['businesseditdata']."'") as $row){
            echo '
                <div class="col-md-12"><center><b style="color: #3C8DBC">Account Details</b><br><br></center></div>
                <div class="col-md-6">
                <label class="labelcolor">Account Name</label>
                <input value="'.$row['accountname'].'" id="accountname" type="text" class="form-control">
                </div>
                <div class="col-md-6">
                <label class="labelcolor">Account Number</label>
                <input value="'.$row['accountno'].'" id="accountnumber" type="text" class="form-control"><br><br>
            ';
        }
        echo '</div></div>';
    }

    public static function GUARANTORSCLIENT(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM clients WHERE loangrat_status='0'") as $row){
            echo '<option value='.$row['clientid'].'>'.$row['accountname'].'</option>';
        }
    }
    public static function GUARANTORSCLIENTRESULT(){
        $db = new DB();
        foreach ($db->query(static::$sql." WHERE clientid='".static::$clientid."'") as $row){
            if($row['accounttype'] == "1"){
                foreach ($db->query(static::$sql1." WHERE acc_no='".static::$clientid ."'") as $row1){
                    echo $row['accountno'];
                    echo '|<><>|';
                    echo $row1['subcounty'];
                    echo '|<><>|';
                    echo $row1['physicaladress'];
                    echo '|<><>|';
                    echo $row1['mobilenumber'];
                }
            }
            if($row['accounttype'] == "2"){
                foreach ($db->query(static::$sql2." WHERE acc_no='".static::$clientid ."'") as $row1){
					$data = "";
					$data1 = "";
					foreach ($db->query(static::$sql2." WHERE acc_no='".$row["clientid"]."'") as $row2){
						$data .=", ".$row2['mobilenumber'];
						$data1 .=", ".$row2['subcounty'];
					}
                    echo $row['accountno'];
                    echo '|<><>|';
                    echo $data1;
                    echo '|<><>|';
                    echo $row1['physicaladress'];
                    echo '|<><>|';
                    echo $data;
                }
            }
            if($row['accounttype'] == "3"){
                foreach ($db->query(static::$sql3." WHERE acc_no='".static::$clientid ."'") as $row1){
					echo $row['accountno'];
                    echo '|<><>|';
                    echo $row1['subcounty'];
                    echo '|<><>|';
                    echo $row1['physicaladress'];
                    echo '|<><>|';
                    echo $row1['officetel'];
                }
            }
        }
    }
    public static function LOANAPPLICATIONDATA(){
        $db = new DB(); session_start();
        foreach ($db->query("SELECT * FROM users WHERE user_id='".$_SESSION['user_id']."'") as $rowpass){}
        foreach ($db->query("SELECT * FROM loan_application1 WHERE chartid='".$_GET['getloanapplicationdata']."'") as $row1){
            $chartid = $row1['chartid'];
        }
        if($chartid){
            foreach ($db->query("SELECT * FROM post_chart WHERE chartid='".$_GET['getloanapplicationdata']."'") as $row1){$client = CLIENT_DATA::$clientid = $row1['clientid'];}
            foreach ($db->query("SELECT * FROM loan_application1 WHERE chartid='".$_GET['getloanapplicationdata']."'") as $rowapp){
				$da = explode("-",$rowapp['dateexpected']);
				$date = $da[1]."/".$da[2]."/".$da[0];
                foreach ($db->query(static::$sql." WHERE clientid='".static::$clientid."'") as $row){

                    if($row['accounttype'] == "1"){
                        foreach ($db->query(static::$sql1." WHERE acc_no='".static::$clientid."'") as $row1){
                            CLIENT_DATA::$clientid = $rowapp['grt1_id'];
                            self::CLIENTDATAMAIN();
                            $data1 = static::$accountname;
                            $data2 = static::$accountno;
                            $data3 = static::$mobilenumber;
                            $data4 = static::$physicaladress;
                            $data5 = static::$subcounty;
                            CLIENT_DATA::$clientid = $rowapp['grt2_id'];
                            self::CLIENTDATAMAIN();
                            $data8 = static::$accountname;
                            $data9 = static::$accountno;
                            $data10 = static::$mobilenumber;
                            $data11= static::$physicaladress;
                            $data12 = static::$subcounty;
                            echo '
                            <div class="grid-form">
                                <fieldset>
                                    <legend>Client Data</legend>

                                    <div data-row-span="4">
                                        <div data-field-span="1" style="height: 41px;">
                                            <label>First Name:</label>
                                            <input type="hidden" name = "farmer_id" value="">
                                            <input required type="text" value="'.$row1['firstname'].'" style="border: 0px;width: 600px;" id = "ln_fname" autofocus >
                                        </div>
                                        <div data-field-span="1" style="height: 41px;">
                                            <label>Middle Name</label>
                                            <input value="'.$row1['secondname'].'" type="text" id="mname">
                                        </div>
                                        <div data-field-span="2" style="height: 41px;">
                                            <label>Last Name</label>
                                            <input value="'.$row1['lastname'].'" type="text" id="lname">
                                        </div>
                                    </div>
                                    <div data-row-span="4">
                                        <div data-field-span="1" style="height: 41px;">
                                             <label>Marital Status:</label>
                                            <input type="text" style="border: 0px; " id = "marital_status"  value="'.$row1['maritalstatus'].'"   autofocus>
                                        </div>
                                        <div style="height: 41px;width: 25%;" data-field-span="1">
                                            <label>Physical Address:</label>
                                            <input required  type="text" value="'.$row1['physicaladress'].'" style="border: 0px;" id = "applic_address"   autofocus >
                                        </div>
                                        <div style="height: 41px;width: 25%;" data-field-span="1">
                                            <label>Tel No:</label>
                                            <input required  type="text" value="'.$row1['mobilenumber'].'" style="border: 0px;" id = "tel_no"   autofocus >
                                        </div>
                                    </div>
                                    <div data-row-span="4">
                                         <div data-field-span="1">
                                                <label>Sub County:</label>
                                                <input value="'.$row1['subcounty'].'" type="text" style="border: 0px;height: 31px;" id = "sub_county"  autofocus >
                                            </div>
                                            <div data-field-span="1">
                                                <label>District:</label>
                                                <input value="'.$row1['district'].'" type="text" style="border: 0px;height: 31px;" id = "district"   autofocus >
                                            </div>
                                            <div data-field-span="1">
                                                <label>Age:</label>
                                                <input value="'.$row1['dateofbirth'].'" type="text" style="border: 0px;height: 31px;" id = "age"   autofocus >
                                            </div>
                                            <div data-field-span="1">
                                                <label>Gender:</label>
                                                <input value="'.$row1['gender'].'" type="text" style="border: 0px;height: 31px;" id = "gender"   autofocus >
                                            </div>
                                    </div>
                                    <div data-row-span="2">
                                        <div data-field-span="1">
                                            <label>Highest Level of Education:</label>
                                            <input value="'.$rowapp['lvl_education'].'" type="text" style="border: 0px;" id = "lvl_of_educ" autofocus>
                                        </div>
                                        <div data-field-span="1">
                                            <label>Type of Business:</label>
                                            <input value="'.$rowapp['type_of_business'].'" type="text" style="border: 0px;" id = "type_of_business" autofocus >
                                        </div>
                                    </div>
                                    <div data-row-span="3">
                                        <div data-field-span="1">
                                            <label>Date When you Need the Loan:</label>
                                            <input  value="'.$date.'" type="text" style="border: 0px;" id = "datepicker" autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>Loan amount Requested in Figures:</label>
                                            <input  value="'.$rowapp['loan_amount'].'" type="text" style="border: 0px;" id = "ln_amount_figure" autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>Amount in Words:</label>
                                            <input value="'.$rowapp['amount_in_word'].'" type="text" style="border: 0px;width: 500px;" id = "ln_amount_words" autofocus >
                                        </div>
                                    </div>
                                    <div data-row-span="5">
                                        <div data-field-span="1">
                                            <label>Intended Purpose:</label>
                                            <input value="'.$rowapp['int_purpose'].'" type="text" style="border: 0px;height: 31px;" id = "ln_intent" autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>Source of Repayment:</label>
                                            <input value="'.$rowapp['source_ofpayment'].'" type="text" style="border: 0px;height: 31px;" id = "ln_source" autofocus >
                                        </div>
                                         <div data-field-span="1">
                                            <label>Duration:</label>
                                            <input value="'.$rowapp['duration'].'" type="text" style="border: 0px;height: 31px;" id = "ln_duration" autofocus >
                                        </div>
                                         <div data-field-span="1">
                                            <label>Repayment Schedule (weekly,monthly,other):</label>
											<select class="form-control" style="border: 0px;height: 21px;" id = "ln_schedule" autofocus>
												<option value="'.(($rowapp['repayment_schedule'])?$rowapp['repayment_schedule']:"").'">'.(($rowapp['repayment_schedule']=="2")?"Weekly":(($rowapp['repayment_schedule']=="1")?"Monthly":"Select Type")).'</option>
												<option value = "1">Monthly</option>
												<option value = "2">Weekly</option>
											</select>
                                        </div>
                                        <div data-field-span="1">
                                            <label>Type of Loan:</label>
											<select class="form-control" style="border: 0px;height: 21px;" id = "loan_type" autofocus>
												'; 
												foreach($db->query("SELECT * FROM accounttypes WHERE typeid='".$rowapp['type_of_loan']."'") as $rowt){
													echo "<option value=".$rowt['typeid'].">".$rowt['typename']."</option>";
												}
												ACCOUNTTYPE::GETLOANTYPE(); echo'
											</select>
                                        </div>
                                    </div>
                                <fieldset>
                                        <legend>CAPITAL</legend>
                                        <div data-row-span="2">
                                            <div data-field-span="1">
                                                <label>Number of shares:</label>
                                                <input required  type="text" value="'.number_format($row['shareaccount_amount']).'" style="border: 0px;" id = "no_of_shares" autofocus >
                                            </div>
                                            <div data-field-span="1">
                                                <label>assets owned like house, land, vehicle, business etc (indicate estimated value)? :</label>
                                                <input value="'.$rowapp['assests_owned'].'" type="text" style="border: 0px;" id = "own_assests" autofocus >
                                            </div>
                                        </div>
                                        <div data-row-span="2">
                                            <div data-field-span="1">
                                                <label>can assets be taken as collateral? which ones:</label>
                                                <input value="'.$rowapp['collateral_assests'].'" type="text" style="border: 0px;" id = "col_assests" autofocus >
                                            </div>
                                            <div data-field-span="1">
                                                <label>do you have another loan with another financial institution:</label>
                                                <input value="'.$rowapp['debts'].'" type="text" style="border: 0px;" id = "other_debt" autofocus >
                                            </div>
                                        </div>
                                        <div data-row-span="2">
                                            <div data-field-span="1">
                                                <label>purpose of previous loans:</label>
                                                <input value="'.$rowapp['purpose_of_previous'].'" type="text" style="border: 0px;" id = "ln_purpose" autofocus >
                                            </div>
                                            <div data-field-span="1">
                                                <label>net worth:</label>
                                                <input value="'.$rowapp['net_worth'].'" type="text" style="border: 0px;" id = "net_worth" autofocus >
                                            </div>
                                        </div>
                                    </fieldset>
                                </fieldset>

                                <fieldset>
                                    <legend>ABILITY TO PAY</legend>
                                        <div data-row-span="1">
                                            <div data-field-span="1">
                                                <label>how much can you afford to pay monthly:</label>
                                                <input value="'.$rowapp['ability_to_pay'].'" type="text" style="border: 0px;" id = "ablity_pay"  autofocus >
                                            </div>
                                        </div>
                                        <legend>SPOUSE/NEXT OF KIN</legend>
                                        <div data-row-span="2">
                                            <div data-field-span="1">
                                                <label>spouse/next of kin name:</label>
                                                <input value="'.$rowapp['kin_name'].'" type="text" style="border: 0px;" id = "spouse_name"  autofocus >
                                            </div>
                                            <div data-field-span="1">
                                                <label>contact/phone:</label>
                                                <input value="'.$rowapp['kin_contact'].'" type="text" style="border: 0px; " id = "spouse_contact"  autofocus >
                                            </div>
                                        </div>
                                    <legend>LC 1 RECOMMENDATION</legend>
                                    <div data-row-span="3">
                                        <div data-field-span="1">
                                            <label>Name:</label>
                                            <input value="'.$rowapp['lc_name'].'" type="text" style="border: 0px; " id = "lc_name"  autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>Address:</label>
                                            <input value="'.$rowapp['lc_address'].'" type="text" style="border: 0px; " id = "lc_address"  autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>contact/phone:</label>
                                            <input value="'.$rowapp['lc_contact'].'"type="text" style="border: 0px; " id = "lc_contact"  autofocus >
                                        </div>
                                    </div>
                                    <legend>GUARANTEE UNDERTAKING 1</legend>
                                    <div data-row-span="4">
                                        <div data-field-span="1">
                                            <label>Name:</label>
                                            <select onchange="getguarantor1data()" id="grt1_name" class="selectpicker show-tick form-control" data-live-search="true">
                                                  <option value="'.$rowapp['grt1_id'].'">'.$data1.'</option>
                                                  ';CLIENT_DATA::GUARANTORSCLIENT();echo'
                                            </select>
                                        </div>
                                        <div data-field-span="1">
                                            <label>village:</label>
                                            <input  type="text" value="'.$data5.'" style="border: 0px;height: 34px" id="village1"  autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>place of residence:</label>
                                            <input style="border: 0px;height: 34px" id="residence1"  autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>contact/phone:</label>
                                            <input  type="text" value="'.$data3.'" style="border: 0px;height: 34px" id="contact1"  autofocus >
                                        </div>
                                    </div>
                                    <div data-row-span="1">
                                        <div data-field-span="1">
                                            <label>Acount no.:</label>
                                            <input   type="text" value="'.$data2.'" style="border: 0px;" id="acount1"  autofocus >
                                        </div>
                                    </div>
                                    <legend>GUARANTEE UNDERTAKING 2</legend>
                                    <div data-row-span="4">
                                        <div data-field-span="1">
                                            <label>Name:</label>
                                            <select onchange="getguarantor2data()" id="grt2_name" class="selectpicker show-tick form-control" data-live-search="true">
                                                  <option value="'.$rowapp['grt2_id'].'">'.$data8.'</option>
                                                  ';CLIENT_DATA::GUARANTORSCLIENT();echo'
                                            </select>
                                        </div>
                                        <div data-field-span="1">
                                            <label>village:</label>
                                            <input  type="text" value="'.$data12.'" style="border: 0px;height: 34px" id = "village2"  autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>place of residence:</label>
                                            <input style="border: 0px;height: 34px" id = "residence2" value="'.$data11.'"  autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>contact/phone:</label>
                                            <input  type="text" value="'.$data10.'" style="border: 0px;height: 34px" id = "contact2"  autofocus >
                                        </div>
                                    </div>
                                    <div data-row-span="1">
                                        <div data-field-span="1">
                                            <label>Account no.:</label>
                                            <input   type="text" value="'.$data9.'" style="border: 0px;height: 34px" id = "acount2"  autofocus >
                                        </div>
                                    </div>
                                </fieldset>

                                <div class="clearfix pt-md">
                                    <div class="pull-right">
                                        <input id="clientdata" hidden value="'.$client.'">
										<input id="acctype" hidden value="'.$row['accounttype'].'">
                                        <input id="chartdata" hidden value="'.$_GET['getloanapplicationdata'].'">
                                        '.(($rowpass['handle_status']=="0" || $rowpass['handle_status']=="1")?'<button onclick="saveapplication()" class="btn-primary btn"><i class="ti ti-save"></i> Save Application</button>':"").'
                                        <button onclick="closemodal()" class="btn-default btn">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        ';
                        }
                    }
                    if($row['accounttype'] == "2"){
                        $loop = 1;
						
						CLIENT_DATA::$clientid = $rowapp['grt1_id'];
						self::CLIENTDATAMAIN();
						$data1 = static::$accountname;
						$data2 = static::$accountno;
						$data3 = static::$mobilenumber;
						$data4 = static::$physicaladress;
						$data5 = static::$subcounty;
						CLIENT_DATA::$clientid = $rowapp['grt2_id'];
						self::CLIENTDATAMAIN();
						$data8 = static::$accountname;
						$data9 = static::$accountno;
						$data10 = static::$mobilenumber;
						$data11= static::$physicaladress;
						$data12 = static::$subcounty; 
						
                        echo '
                            <div class="grid-form">
                                <fieldset>
                                    <legend>Client Data</legend>
                                    <div id="clientbiodata">

                                    </div>
                                    <legend></legend>
                                    <div data-row-span="1">
                                        <div data-field-span="1">
                                            <label>Type of Business:</label>
                                            <input value="'.$rowapp['type_of_business'].'" type="text" style="border: 0px;" id = "type_of_business" autofocus >
                                        </div>
                                    </div>
                                    <div data-row-span="3">
                                        <div data-field-span="1">
                                            <label>Date When you Need the Loan:</label>
                                            <input value="'.$date.'" type="text" style="border: 0px;" id = "datepicker" autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>Loan amount Requested in Figures:</label>
                                            <input value="'.$rowapp['loan_amount'].'" type="text" style="border: 0px;" id = "ln_amount_figure" autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>Amount in Words:</label>
                                            <input value="'.$rowapp['amount_in_word'].'" type="text" style="border: 0px;width: 500px;" id = "ln_amount_words" autofocus >
                                        </div>
                                    </div>
                                    <div data-row-span="5">
                                        <div data-field-span="1">
                                            <label>Intended Purpose:</label>
                                            <input value="'.$rowapp['int_purpose'].'" type="text" style="border: 0px;height: 31px;" id = "ln_intent" autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>Source of Repayment:</label>
                                            <input value="'.$rowapp['source_ofpayment'].'" type="text" style="border: 0px;height: 31px;" id = "ln_source" autofocus >
                                        </div>
                                         <div data-field-span="1">
                                            <label>Duration:</label>
                                            <input value="'.$rowapp['duration'].'" type="text" style="border: 0px;height: 31px;" id = "ln_duration" autofocus >
                                        </div>
                                         <div data-field-span="1">
                                            <label>Repayment Schedule (weekly,monthly,other):</label>
											<select class="form-control" style="border: 0px;height: 21px;" id = "ln_schedule" autofocus>
												<option value="'.(($rowapp['repayment_schedule'])?$rowapp['repayment_schedule']:"").'">'.(($rowapp['repayment_schedule']=="2")?"Weekly":(($rowapp['repayment_schedule']=="1")?"Monthly":"Select Type")).'</option>
												<option value = "1">Monthly</option>
												<option value = "2">Weekly</option>
											</select>
                                            <input value="'.$rowapp['repayment_schedule'].'" type="text" style="border: 0px;height: 21px;" id = "ln_schedule" autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>Type of Loan:</label>
                                            <select class="form-control" style="border: 0px;height: 21px;" id = "loan_type" autofocus>
												'; 
												foreach($db->query("SELECT * FROM accounttypes WHERE typeid='".$rowapp['type_of_loan']."'") as $rowt){
													echo "<option value=".$rowt['typeid'].">".$rowt['typename']."</option>";
												}
												ACCOUNTTYPE::GETLOANTYPE(); echo'
											</select>
                                        </div>
                                    </div>
                                <fieldset>
                                        <legend>CAPITAL</legend>
                                        <div data-row-span="2">
                                            <div data-field-span="1">
                                                <label>Number of shares:</label>
                                                <input required  type="text" value="'.number_format($row['shareaccount_amount']).'" style="border: 0px;" id = "no_of_shares" autofocus >
                                            </div>
                                            <div data-field-span="1">
                                                <label>assets owned like house, land, vehicle, business etc (indicate estimated value)? :</label>
                                                <input value="'.$rowapp['assests_owned'].'" type="text" style="border: 0px;" id = "own_assests" autofocus >
                                            </div>
                                        </div>
                                        <div data-row-span="2">
                                            <div data-field-span="1">
                                                <label>can assets be taken as collateral? which ones:</label>
                                                <input value="'.$rowapp['collateral_assests'].'" type="text" style="border: 0px;" id = "col_assests" autofocus >
                                            </div>
                                            <div data-field-span="1">
                                                <label>do you have another loan with another financial institution:</label>
                                                <input value="'.$rowapp['debts'].'" type="text" style="border: 0px;" id = "other_debt" autofocus >
                                            </div>
                                        </div>
                                        <div data-row-span="2">
                                            <div data-field-span="1">
                                                <label>purpose of previous loans:</label>
                                                <input value="'.$rowapp['purpose_of_previous'].'" type="text" style="border: 0px;" id = "ln_purpose" autofocus >
                                            </div>
                                            <div data-field-span="1">
                                                <label>net worth:</label>
                                                <input value="'.$rowapp['net_worth'].'" type="text" style="border: 0px;" id = "net_worth" autofocus >
                                            </div>
                                        </div>
                                    </fieldset>
                                </fieldset>

                                <fieldset>
                                    <legend>ABILITY TO PAY</legend>
                                        <div data-row-span="1">
                                            <div data-field-span="1">
                                                <label>how much can you afford to pay monthly:</label>
                                                <input value="'.$rowapp['ability_to_pay'].'" type="text" style="border: 0px;" id = "ablity_pay"  autofocus >
                                            </div>
                                        </div>
                                    <legend>LC 1 RECOMMENDATION</legend>
                                    <div data-row-span="3">
                                        <div data-field-span="1">
                                            <label>Name:</label>
                                            <input value="'.$rowapp['lc_name'].'" type="text" style="border: 0px; " id = "lc_name"  autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>Address:</label>
                                            <input value="'.$rowapp['lc_address'].'" type="text" style="border: 0px; " id = "lc_address"  autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>contact/phone:</label>
                                            <input value="'.$rowapp['lc_contact'].'" type="text" style="border: 0px; " id = "lc_contact"  autofocus >
                                        </div>
                                    </div>
                                      <legend>GUARANTEE UNDERTAKING 1</legend>
                                    <div data-row-span="4">
                                        <div data-field-span="1">
                                            <label>Name:</label>
                                            <select onchange="getguarantor1data()" id="grt1_name" class="selectpicker show-tick form-control" data-live-search="true">
                                                  <option value="'.$rowapp['grt1_id'].'">'.$data1.'</option>
                                                  ';CLIENT_DATA::GUARANTORSCLIENT();echo'
                                            </select>
                                        </div>
                                        <div data-field-span="1">
                                            <label>village:</label>
                                            <input  type="text" value="'.$data5.'" style="border: 0px;height: 34px" id="village1"  autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>place of residence:</label>
                                            <input style="border: 0px;height: 34px" id="residence1"  autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>contact/phone:</label>
                                            <input  type="text" value="'.$data3.'" style="border: 0px;height: 34px" id="contact1"  autofocus >
                                        </div>
                                    </div>
                                    <div data-row-span="1">
                                        <div data-field-span="1">
                                            <label>Account no.:</label>
                                            <input   type="text" value="'.$data2.'" style="border: 0px;" id="acount1"  autofocus >
                                        </div>
                                    </div>
                                    <legend>GUARANTEE UNDERTAKING 2</legend>
                                    <div data-row-span="4">
                                        <div data-field-span="1">
                                            <label>Name:</label>
                                            <select onchange="getguarantor2data()" id="grt2_name" class="selectpicker show-tick form-control" data-live-search="true">
                                                  <option value="'.$rowapp['grt2_id'].'">'.$data8.'</option>
                                                  ';CLIENT_DATA::GUARANTORSCLIENT();echo'
                                            </select>
                                        </div>
                                        <div data-field-span="1">
                                            <label>village:</label>
                                            <input type="text" value="'.$data12.'" style="border: 0px;height: 34px" id = "village2"  autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>place of residence:</label>
                                            <input style="border: 0px;height: 34px" id = "residence2" value="'.$data11.'"  autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>contact/phone:</label>
                                            <input type="text" value="'.$data10.'" style="border: 0px;height: 34px" id = "contact2"  autofocus >
                                        </div>
                                    </div>
                                    <div data-row-span="1">
                                        <div data-field-span="1">
                                            <label>Account no.:</label>
                                            <input type="text" value="'.$data9.'" style="border: 0px;height: 34px" id = "acount2"  autofocus >
                                        </div>
                                    </div>
                                </fieldset>

                                <div class="clearfix pt-md">
                                    <div class="pull-right">
                                        <input id="clientdata" hidden value="'.$rowapp['member_id'].'">
										<input id="acctype" hidden value="'.$row['accounttype'].'">
                                        <input id="chartdata" hidden value="'.$_GET['getloanapplicationdata'].'">
                                        '.(($rowpass['handle_status']=="0" || $rowpass['handle_status']=="1")?'<button onclick="saveapplication()" class="btn-primary btn"><i class="ti ti-save"></i> Save Application</button>':"").'
                                        <button onclick="closemodal()" class="btn-default btn">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        ';
                        echo '|<><>|';
                        foreach ($db->query(static::$sql2." WHERE acc_no='".$rowapp['member_id']."'") as $row1) {
                            echo '
                                <div class="col-md-4">
                                <legend>Group Member '.$loop.'</legend>
                                <table width="100%">
                                    <tr>
                                        <td width="50%" style="font-size: 12px"><label class="control-label">Client Names: </label></td>
                                        <td width="50%"> '.$row['firstname'].' '.$row['middlename'].' '.$row1['lastname'].'</td>
                                    </tr>
                                    <tr>
                                        <td style="font-size: 12px"><label class="control-label">Gender: </label></td>
                                        <td>'.$row1['gender'].'</td>
                                    </tr>
                                     <tr>
                                        <td style="font-size: 12px"><label class="control-label">Date of Birth: </label></td>
                                        <td>'.$row1['dateofbirth'].'</td>
                                    </tr>
                                     <tr>
                                        <td style="font-size: 12px"><label class="control-label">Marital Status: </label></td>
                                        <td>'.$row1['maritalstatus'].'</td>
                                    </tr>
                                     <tr>
                                        <td style="font-size: 12px"><label class="control-label">Mobile Number: </label></td>
                                        <td>'.$row1['mobilenumber'].'</td>
                                    </tr>
                                     <tr>
                                        <td style="font-size: 12px"><label class="control-label">Physical Address: </label></td>
                                        <td>'.$row1['physicaladress'].'</td>
                                    </tr>
                                     <tr>
                                        <td style="font-size: 12px"><label class="control-label">Sub County: </label></td>
                                        <td>'.$row1['subcounty'].'</td>
                                    </tr>
                                     <tr>
                                        <td style="font-size: 12px"><label class="control-label">District: </label></td>
                                        <td>'.$row1['district'].'</td>
                                    </tr>
                                </table>
                                </div>';
                            $loop++;
                        }

                    }
					if($row['accounttype'] == "3"){
                        $loop = 1;
						
						CLIENT_DATA::$clientid = $rowapp['grt1_id'];
						self::CLIENTDATAMAIN();
						$data1 = static::$accountname;
						$data2 = static::$accountno;
						$data3 = static::$mobilenumber;
						$data4 = static::$physicaladress;
						$data5 = static::$subcounty;
						CLIENT_DATA::$clientid = $rowapp['grt2_id'];
						self::CLIENTDATAMAIN();
						$data8 = static::$accountname;
						$data9 = static::$accountno;
						$data10 = static::$mobilenumber;
						$data11= static::$physicaladress;
						$data12 = static::$subcounty; 
						
                        echo '
                            <div class="grid-form">
                                <fieldset>
                                    <legend>Client Data</legend>
                                    <div id="clientbiodata">

                                    </div>
                                    <legend></legend>
                                    <div data-row-span="1">
                                        <div data-field-span="1">
                                            <label>Type of Business:</label>
                                            <input value="'.$rowapp['type_of_business'].'" type="text" style="border: 0px;" id = "type_of_business" autofocus >
                                        </div>
                                    </div>
                                    <div data-row-span="3">
                                        <div data-field-span="1">
                                            <label>Date When you Need the Loan:</label>
                                            <input value="'.$date.'" type="text" style="border: 0px;" id = "datepicker" autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>Loan amount Requested in Figures:</label>
                                            <input value="'.$rowapp['loan_amount'].'" type="text" style="border: 0px;" id = "ln_amount_figure" autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>Amount in Words:</label>
                                            <input value="'.$rowapp['amount_in_word'].'" type="text" style="border: 0px;width: 500px;" id = "ln_amount_words" autofocus >
                                        </div>
                                    </div>
                                    <div data-row-span="5">
                                        <div data-field-span="1">
                                            <label>Intended Purpose:</label>
                                            <input value="'.$rowapp['int_purpose'].'" type="text" style="border: 0px;height: 31px;" id = "ln_intent" autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>Source of Repayment:</label>
                                            <input value="'.$rowapp['source_ofpayment'].'" type="text" style="border: 0px;height: 31px;" id = "ln_source" autofocus >
                                        </div>
                                         <div data-field-span="1">
                                            <label>Duration:</label>
                                            <input value="'.$rowapp['duration'].'" type="text" style="border: 0px;height: 31px;" id = "ln_duration" autofocus >
                                        </div>
                                         <div data-field-span="1">
                                            <label>Repayment Schedule (weekly,monthly,other):</label>
											<select class="form-control" style="border: 0px;height: 21px;" id = "ln_schedule" autofocus>
												<option value="'.(($rowapp['repayment_schedule'])?$rowapp['repayment_schedule']:"").'">'.(($rowapp['repayment_schedule']=="2")?"Weekly":(($rowapp['repayment_schedule']=="1")?"Monthly":"Select Type")).'</option>
												<option value = "1">Monthly</option>
												<option value = "2">Weekly</option>
											</select>
										</div>
                                        <div data-field-span="1">
                                            <label>Type of Loan:</label>
                                            <select class="form-control" style="border: 0px;height: 21px;" id = "loan_type" autofocus>
												'; 
												foreach($db->query("SELECT * FROM accounttypes WHERE typeid='".$rowapp['type_of_loan']."'") as $rowt){
													echo "<option value=".$rowt['typeid'].">".$rowt['typename']."</option>";
												}
												ACCOUNTTYPE::GETLOANTYPE(); echo'
											</select>
                                        </div>
                                    </div>
                                <fieldset>
                                        <legend>CAPITAL</legend>
                                        <div data-row-span="2">
                                            <div data-field-span="1">
                                                <label>Number of shares:</label>
                                                <input required  type="text" value="'.number_format($row['shareaccount_amount']).'" style="border: 0px;" id = "no_of_shares" autofocus >
                                            </div>
                                            <div data-field-span="1">
                                                <label>assets owned like house, land, vehicle, business etc (indicate estimated value)? :</label>
                                                <input value="'.$rowapp['assests_owned'].'" type="text" style="border: 0px;" id = "own_assests" autofocus >
                                            </div>
                                        </div>
                                        <div data-row-span="2">
                                            <div data-field-span="1">
                                                <label>can assets be taken as collateral? which ones:</label>
                                                <input value="'.$rowapp['collateral_assests'].'" type="text" style="border: 0px;" id = "col_assests" autofocus >
                                            </div>
                                            <div data-field-span="1">
                                                <label>do you have another loan with another financial institution:</label>
                                                <input value="'.$rowapp['debts'].'" type="text" style="border: 0px;" id = "other_debt" autofocus >
                                            </div>
                                        </div>
                                        <div data-row-span="2">
                                            <div data-field-span="1">
                                                <label>purpose of previous loans:</label>
                                                <input value="'.$rowapp['purpose_of_previous'].'" type="text" style="border: 0px;" id = "ln_purpose" autofocus >
                                            </div>
                                            <div data-field-span="1">
                                                <label>net worth:</label>
                                                <input value="'.$rowapp['net_worth'].'" type="text" style="border: 0px;" id = "net_worth" autofocus >
                                            </div>
                                        </div>
                                    </fieldset>
                                </fieldset>

                                <fieldset>
                                    <legend>ABILITY TO PAY</legend>
                                        <div data-row-span="1">
                                            <div data-field-span="1">
                                                <label>how much can you afford to pay monthly:</label>
                                                <input value="'.$rowapp['ability_to_pay'].'" type="text" style="border: 0px;" id = "ablity_pay"  autofocus >
                                            </div>
                                        </div>
                                    <legend>LC 1 RECOMMENDATION</legend>
                                    <div data-row-span="3">
                                        <div data-field-span="1">
                                            <label>Name:</label>
                                            <input value="'.$rowapp['lc_name'].'" type="text" style="border: 0px; " id = "lc_name"  autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>Address:</label>
                                            <input value="'.$rowapp['lc_address'].'" type="text" style="border: 0px; " id = "lc_address"  autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>contact/phone:</label>
                                            <input value="'.$rowapp['lc_contact'].'" type="text" style="border: 0px; " id = "lc_contact"  autofocus >
                                        </div>
                                    </div>
                                      <legend>GUARANTEE UNDERTAKING 1</legend>
                                    <div data-row-span="4">
                                        <div data-field-span="1">
                                            <label>Name:</label>
                                            <select onchange="getguarantor1data()" id="grt1_name" class="selectpicker show-tick form-control" data-live-search="true">
                                                  <option value="'.$rowapp['grt1_id'].'">'.$data1.'</option>
                                                  ';CLIENT_DATA::GUARANTORSCLIENT();echo'
                                            </select>
                                        </div>
                                        <div data-field-span="1">
                                            <label>village:</label>
                                            <input  type="text" value="'.$data5.'" style="border: 0px;height: 34px" id="village1"  autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>place of residence:</label>
                                            <input style="border: 0px;height: 34px" id="residence1"  autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>contact/phone:</label>
                                            <input  type="text" value="'.$data3.'" style="border: 0px;height: 34px" id="contact1"  autofocus >
                                        </div>
                                    </div>
                                    <div data-row-span="1">
                                        <div data-field-span="1">
                                            <label>Account no.:</label>
                                            <input   type="text" value="'.$data2.'" style="border: 0px;" id="acount1"  autofocus >
                                        </div>
                                    </div>
                                    <legend>GUARANTEE UNDERTAKING 2</legend>
                                    <div data-row-span="4">
                                        <div data-field-span="1">
                                            <label>Name:</label>
                                            <select onchange="getguarantor2data()" id="grt2_name" class="selectpicker show-tick form-control" data-live-search="true">
                                                  <option value="'.$rowapp['grt2_id'].'">'.$data8.'</option>
                                                  ';CLIENT_DATA::GUARANTORSCLIENT();echo'
                                            </select>
                                        </div>
                                        <div data-field-span="1">
                                            <label>village:</label>
                                            <input type="text" value="'.$data12.'" style="border: 0px;height: 34px" id = "village2"  autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>place of residence:</label>
                                            <input style="border: 0px;height: 34px" id = "residence2" value="'.$data11.'"  autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>contact/phone:</label>
                                            <input type="text" value="'.$data10.'" style="border: 0px;height: 34px" id = "contact2"  autofocus >
                                        </div>
                                    </div>
                                    <div data-row-span="1">
                                        <div data-field-span="1">
                                            <label>Account no.:</label>
                                            <input type="text" value="'.$data9.'" style="border: 0px;height: 34px" id = "acount2"  autofocus >
                                        </div>
                                    </div>
                                </fieldset>

                                <div class="clearfix pt-md">
                                    <div class="pull-right">
                                        <input id="clientdata" hidden value="'.$rowapp['member_id'].'">
										<input id="acctype" hidden value="'.$row['accounttype'].'">
                                        <input id="chartdata" hidden value="'.$_GET['getloanapplicationdata'].'">
                                        '.(($rowpass['handle_status']=="0" || $rowpass['handle_status']=="1")?'<button onclick="saveapplication()" class="btn-primary btn"><i class="ti ti-save"></i> Save Application</button>':"").'
                                        <button onclick="closemodal()" class="btn-default btn">Cancel</button>
                                    </div>
                                </div>
                            </div>
                        ';
                        echo '|<><>|';
                        foreach ($db->query(static::$sql3." WHERE acc_no='".$row['clientid']."'") as $row1) {
                        echo '
                            <div class="col-md-12">
                            <legend>Business/Organisation/Association Detail</legend>
                            <table width="100%">
                                <tr>
                                    <td width="50%" style="font-size: 12px"><label class="control-label">Business/Organisation/Association Name: </label></td>
                                    <td width="50%"> '.$row['accountname'].'</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px"><label class="control-label">Account Signatories: </label></td>
                                    <td>'.$row1['name1']." ,".$row1['name2']." ,".$row1['name3'].'</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px"><label class="control-label">Physical Address: </label></td>
                                    <td>'.$row1['physicaladress'].'</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px"><label class="control-label">Sub County: </label></td>
                                    <td>'.$row1['subcounty'].'</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px"><label class="control-label">District: </label></td>
                                    <td>'.$row1['district'].'</td>
                                </tr>
                            </table>
                            </div>';
                    }

                    }
                }
            }
        }else{
            foreach ($db->query("SELECT * FROM post_chart WHERE chartid='".$_GET['getloanapplicationdata']."'") as $row1){CLIENT_DATA::$clientid = $row1['clientid'];}
            foreach ($db->query(static::$sql." WHERE clientid='".static::$clientid."'") as $row){
                if($row['accounttype'] == "1"){
                    foreach ($db->query(static::$sql1." WHERE acc_no='".static::$clientid ."'") as $row1){
                        echo '
                        <div class="grid-form">
                            <fieldset>
                                <legend>Client Data</legend>

                                <div data-row-span="4">
                                    <div data-field-span="1" style="height: 41px;">
                                        <label>First Name:</label>
                                        <input type="hidden" name = "farmer_id" value="">
                                        <input required type="text" value="'.$row1['firstname'].'" style="border: 0px;width: 600px;" id = "ln_fname" autofocus >
                                    </div>
                                    <div data-field-span="1" style="height: 41px;">
                                        <label>Middle Name</label>
                                        <input value="'.$row1['secondname'].'" type="text" id="mname">
                                    </div>
                                    <div data-field-span="2" style="height: 41px;">
                                        <label>Last Name</label>
                                        <input value="'.$row1['lastname'].'" type="text" id="lname">
                                    </div>
                                </div>
                                <div data-row-span="4">
                                    <div data-field-span="1" style="height: 41px;">
                                         <label>Marital Status:</label>
                                        <input type="text" style="border: 0px; " id = "marital_status"  value="'.$row1['maritalstatus'].'"   autofocus>
                                    </div>
                                    <div style="height: 41px;width: 25%;" data-field-span="1">
                                        <label>Physical Address:</label>
                                        <input required  type="text" value="'.$row1['physicaladress'].'" style="border: 0px;" id = "applic_address"   autofocus >
                                    </div>
                                    <div style="height: 41px;width: 25%;" data-field-span="1">
                                        <label>Tel No:</label>
                                        <input required  type="text" value="'.$row1['contactdetails'].'" style="border: 0px;" id = "tel_no"   autofocus >
                                    </div>
                                </div>
                                <div data-row-span="4">
                                     <div data-field-span="1">
                                            <label>Sub County:</label>
                                            <input value="'.$row1['subcounty'].'" type="text" style="border: 0px;height: 31px;" id = "sub_county"  autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>District:</label>
                                            <input value="'.$row1['district'].'" type="text" style="border: 0px;height: 31px;" id = "district"   autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>Age:</label>
                                            <input value="'.$row1['dateofbirth'].'" type="text" style="border: 0px;height: 31px;" id = "age"   autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>Gender:</label>
                                            <input value="'.$row1['gender'].'" type="text" style="border: 0px;height: 31px;" id = "gender"   autofocus >
                                        </div>
                                </div>
                                <div data-row-span="2">
                                    <div data-field-span="1">
                                        <label>Highest Level of Education:</label>
                                        <input value="" type="text" style="border: 0px;" id = "lvl_of_educ" autofocus>
                                    </div>
                                    <div data-field-span="1">
                                        <label>Type of Business:</label>
                                        <input value="" type="text" style="border: 0px;" id = "type_of_business" autofocus >
                                    </div>
                                </div>
                                <div data-row-span="3">
                                    <div data-field-span="1">
                                        <label>Date When you Need the Loan:</label>
                                        <input  value="" type="text" style="border: 0px;" id = "datepicker" autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>Loan amount Requested in Figures:</label>
                                        <input  value="" type="text" style="border: 0px;" id = "ln_amount_figure" autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>Amount in Words:</label>
                                        <input value="" type="text" style="border: 0px;width: 500px;" id = "ln_amount_words" autofocus >
                                    </div>
                                </div>
                                <div data-row-span="5">
                                    <div data-field-span="1">
                                        <label>Intended Purpose:</label>
                                        <input value="" type="text" style="border: 0px;height: 31px;" id = "ln_intent" autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>Source of Repayment:</label>
                                        <input value="" type="text" style="border: 0px;height: 31px;" id = "ln_source" autofocus >
                                    </div>
                                     <div data-field-span="1">
                                        <label>Duration:</label>
                                        <input value="" type="text" style="border: 0px;height: 31px;" id = "ln_duration" autofocus >
                                    </div>
                                     <div data-field-span="1">
                                        <label>Repayment Schedule (weekly,monthly,other):</label>
                                        <select class="form-control" style="border: 0px;height: 21px;" id = "ln_schedule" autofocus>
											<option value = "">Select Type</option>
											<option value = "1">Monthly</option>
											<option value = "2">Weekly</option>
										</select>
                                    </div>
                                    <div data-field-span="1">
                                        <label>Type of Loan:</label>
                                        <select id="loan_type" class="form-control" style="border: 0px;height: 21px;" id = "loan_type" autofocus>
											<option value="">select Loan Type</option>
											'; ACCOUNTTYPE::GETLOANTYPE(); echo'
										</select>
                                    </div>
                                </div>
                            <fieldset>
                                    <legend>CAPITAL</legend>
                                    <div data-row-span="2">
                                        <div data-field-span="1">
                                            <label>Number of shares:</label>
                                            <input required  type="text" value="'.number_format($row['shareaccount_amount']).'" style="border: 0px;" id = "no_of_shares" autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>assets owned like house, land, vehicle, business etc (indicate estimated value)? :</label>
                                            <input value="" type="text" style="border: 0px;" id = "own_assests" autofocus >
                                        </div>
                                    </div>
                                    <div data-row-span="2">
                                        <div data-field-span="1">
                                            <label>can assets be taken as collateral? which ones:</label>
                                            <input value="" type="text" style="border: 0px;" id = "col_assests" autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>do you have another loan with another financial institution:</label>
                                            <input value="" type="text" style="border: 0px;" id = "other_debt" autofocus >
                                        </div>
                                    </div>
                                    <div data-row-span="2">
                                        <div data-field-span="1">
                                            <label>purpose of previous loans:</label>
                                            <input value="" type="text" style="border: 0px;" id = "ln_purpose" autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>net worth:</label>
                                            <input value="" type="text" style="border: 0px;" id = "net_worth" autofocus >
                                        </div>
                                    </div>
                                </fieldset>
                            </fieldset>

                            <fieldset>
                                <legend>ABILITY TO PAY</legend>
                                    <div data-row-span="1">
                                        <div data-field-span="1">
                                            <label>how much can you afford to pay monthly:</label>
                                            <input value="" type="text" style="border: 0px;" id = "ablity_pay"  autofocus >
                                        </div>
                                    </div>
                                    <legend>SPOUSE/NEXT OF KIN</legend>
                                    <div data-row-span="2">
                                        <div data-field-span="1">
                                            <label>spouse/next of kin name:</label>
                                            <input value="" type="text" style="border: 0px;" id = "spouse_name"  autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>contact/phone:</label>
                                            <input value="" type="text" style="border: 0px; " id = "spouse_contact"  autofocus >
                                        </div>
                                    </div>
                                <legend>LC 1 RECOMMENDATION</legend>
                                <div data-row-span="3">
                                    <div data-field-span="1">
                                        <label>Name:</label>
                                        <input value=""  type="text" style="border: 0px; " id = "lc_name"  autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>Address:</label>
                                        <input value="" type="text" style="border: 0px; " id = "lc_address"  autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>contact/phone:</label>
                                        <input value="" type="text" style="border: 0px; " id = "lc_contact"  autofocus >
                                    </div>
                                </div>
                                <legend>GUARANTEE UNDERTAKING 1</legend>
                                <div data-row-span="4">
                                    <div data-field-span="1">
                                        <label>Name:</label>
                                        <select onchange="getguarantor1data()" id="grt1_name" class="selectpicker show-tick form-control" data-live-search="true">
                                              <option value="">select guarantor...</option>
                                              ';CLIENT_DATA::GUARANTORSCLIENT();echo'
                                        </select>
                                    </div>
                                    <div data-field-span="1">
                                        <label>village:</label>
                                        <input  type="text" value="" style="border: 0px;height: 34px" id="village1"  autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>place of residence:</label>
                                        <input style="border: 0px;height: 34px" id="residence1"  autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>contact/phone:</label>
                                        <input  type="text" value="" style="border: 0px;height: 34px" id="contact1"  autofocus >
                                    </div>
                                </div>
                                <div data-row-span="1">
                                    <div data-field-span="1">
                                        <label>Acount no.:</label>
                                        <input   type="text" value="" style="border: 0px;" id="acount1"  autofocus >
                                    </div>
                                </div>
                                <legend>GUARANTEE UNDERTAKING 2</legend>
                                <div data-row-span="4">
                                    <div data-field-span="1">
                                        <label>Name:</label>
                                        <select onchange="getguarantor2data()" id="grt2_name" class="selectpicker show-tick form-control" data-live-search="true">
                                              <option value="">select guarantor...</option>
                                              ';CLIENT_DATA::GUARANTORSCLIENT();echo'
                                        </select>
                                    </div>
                                    <div data-field-span="1">
                                        <label>village:</label>
                                        <input  type="text" value="" style="border: 0px;height: 34px" id = "village2"  autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>place of residence:</label>
                                        <input style="border: 0px;height: 34px" id = "residence2" value=""  autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>contact/phone:</label>
                                        <input  type="text" value="" style="border: 0px;height: 34px" id = "contact2"  autofocus >
                                    </div>
                                </div>
                                <div data-row-span="1">
                                    <div data-field-span="1">
                                        <label>Account no.:</label>
                                        <input   type="text" value="" style="border: 0px;height: 34px" id = "acount2"  autofocus >
                                    </div>
                                </div>
                            </fieldset>

                            <div class="clearfix pt-md">
                                <div class="pull-right">
                                    <input id="clientdata" hidden value="'.static::$clientid.'">
									<input id="acctype" hidden value="'.$row['accounttype'].'">
                                    <input id="chartdata" hidden value="'.$_GET['getloanapplicationdata'].'">
                                    '.(($rowpass['handle_status']=="0" || $rowpass['handle_status']=="1")?'<button onclick="saveapplication()" class="btn-primary btn"><i class="ti ti-save"></i> Save Application</button>':"").'
                                    <button onclick="closemodal()" class="btn-default btn">Cancel</button>
                                </div>
                            </div>
                        </div>
                    ';
                    }
                }
                if($row['accounttype'] == "2"){
                    $loop = 1;
                    echo '
                        <div class="grid-form">
                            <fieldset>
                                <legend>Client Data</legend>
                                <div id="clientbiodata">

                                </div>
                                <legend></legend>
                                <div data-row-span="1">
                                    <div data-field-span="1">
                                        <label>Type of Business:</label>
                                        <input value="" type="text" style="border: 0px;" id = "type_of_business" autofocus >
                                    </div>
                                </div>
                                <div data-row-span="3">
                                    <div data-field-span="1">
                                        <label>Date When you Need the Loan:</label>
                                        <input  value="" type="text" style="border: 0px;" id = "datepicker" autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>Loan amount Requested in Figures:</label>
                                        <input value="" type="text" style="border: 0px;" id = "ln_amount_figure" autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>Amount in Words:</label>
                                        <input value="" type="text" style="border: 0px;width: 500px;" id = "ln_amount_words" autofocus >
                                    </div>
                                </div>
                                <div data-row-span="5">
                                    <div data-field-span="1">
                                        <label>Intended Purpose:</label>
                                        <input value="" type="text" style="border: 0px;height: 31px;" id = "ln_intent" autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>Source of Repayment:</label>
                                        <input value="" type="text" style="border: 0px;height: 31px;" id = "ln_source" autofocus >
                                    </div>
                                     <div data-field-span="1">
                                        <label>Duration:</label>
                                        <input value="" type="text" style="border: 0px;height: 31px;" id = "ln_duration" autofocus >
                                    </div>
                                     <div data-field-span="1">
                                        <label>Repayment Schedule (weekly,monthly,other):</label>
                                        <select class="form-control" style="border: 0px;height: 21px;" id = "ln_schedule" autofocus>
											<option value = "">Select Type</option>
											<option value = "1">Monthly</option>
											<option value = "2">Weekly</option>
										</select>
                                    </div>
                                    <div data-field-span="1">
                                        <label>Type of Loan:</label>
                                        <select class="form-control" style="border: 0px;height: 21px;" id = "loan_type" autofocus>
											<option value="">select Loan Type</option>
											'; ACCOUNTTYPE::GETLOANTYPE(); echo'
										</select>
                                    </div>
                                </div>
                            <fieldset>
                                    <legend>CAPITAL</legend>
                                    <div data-row-span="2">
                                        <div data-field-span="1">
                                            <label>Number of shares:</label>
                                            <input required  type="text" value="'.number_format($row['shareaccount_amount']).'" style="border: 0px;" id = "no_of_shares" autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>assets owned like house, land, vehicle, business etc (indicate estimated value)? :</label>
                                            <input value="" type="text" style="border: 0px;" id = "own_assests" autofocus >
                                        </div>
                                    </div>
                                    <div data-row-span="2">
                                        <div data-field-span="1">
                                            <label>can assets be taken as collateral? which ones:</label>
                                            <input value="" type="text" style="border: 0px;" id = "col_assests" autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>do you have another loan with another financial institution:</label>
                                            <input value="" type="text" style="border: 0px;" id = "other_debt" autofocus >
                                        </div>
                                    </div>
                                    <div data-row-span="2">
                                        <div data-field-span="1">
                                            <label>purpose of previous loans:</label>
                                            <input value="" type="text" style="border: 0px;" id = "ln_purpose" autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>net worth:</label>
                                            <input value="" type="text" style="border: 0px;" id = "net_worth" autofocus >
                                        </div>
                                    </div>
                                </fieldset>
                            </fieldset>

                            <fieldset>
                                <legend>ABILITY TO PAY</legend>
                                    <div data-row-span="1">
                                        <div data-field-span="1">
                                            <label>how much can you afford to pay monthly:</label>
                                            <input value="" type="text" style="border: 0px;" id = "ablity_pay"  autofocus >
                                        </div>
                                    </div>
                                <legend>LC 1 RECOMMENDATION</legend>
                                <div data-row-span="3">
                                    <div data-field-span="1">
                                        <label>Name:</label>
                                        <input value=""  type="text" style="border: 0px; " id = "lc_name"  autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>Address:</label>
                                        <input value="" type="text" style="border: 0px; " id = "lc_address"  autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>contact/phone:</label>
                                        <input value="" type="text" style="border: 0px; " id = "lc_contact"  autofocus >
                                    </div>
                                </div>
                                <legend>GUARANTEE UNDERTAKING 1</legend>
                                <div data-row-span="4">
                                    <div data-field-span="1">
                                        <label>Name:</label>
                                        <select onchange="getguarantor1data()" id="grt1_name" class="selectpicker show-tick form-control" data-live-search="true">
                                              <option value="">select guarantor...</option>
                                              ';CLIENT_DATA::GUARANTORSCLIENT();echo'
                                        </select>
                                    </div>
                                    <div data-field-span="1">
                                        <label>village:</label>
                                        <input  type="text" value="" style="border: 0px;height: 34px" id="village1"  autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>place of residence:</label>
                                        <input style="border: 0px;height: 34px" id="residence1"  autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>contact/phone:</label>
                                        <input  type="text" value="" style="border: 0px;height: 34px" id="contact1"  autofocus >
                                    </div>
                                </div>
                                <div data-row-span="1">
                                    <div data-field-span="1">
                                        <label>Account no.:</label>
                                        <input   type="text" value="" style="border: 0px;" id="acount1"  autofocus >
                                    </div>
                                </div>
                                <legend>GUARANTEE UNDERTAKING 2</legend>
                                <div data-row-span="4">
                                    <div data-field-span="1">
                                        <label>Name:</label>
                                        <select onchange="getguarantor2data()" id="grt2_name" class="selectpicker show-tick form-control" data-live-search="true">
                                              <option value="">select guarantor...</option>
                                              ';CLIENT_DATA::GUARANTORSCLIENT();echo'
                                        </select>
                                    </div>
                                    <div data-field-span="1">
                                        <label>village:</label>
                                        <input  type="text" value="" style="border: 0px;height: 34px" id = "village2"  autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>place of residence:</label>
                                        <input style="border: 0px;height: 34px" id = "residence2" value=""  autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>contact/phone:</label>
                                        <input  type="text" value="" style="border: 0px;height: 34px" id = "contact2"  autofocus >
                                    </div>
                                </div>
                                <div data-row-span="1">
                                    <div data-field-span="1">
                                        <label>Account no.:</label>
                                        <input   type="text" value="" style="border: 0px;height: 34px" id = "acount2"  autofocus >
                                    </div>
                                </div>
                            </fieldset>

                            <div class="clearfix pt-md">
                                <div class="pull-right">
                                    <input id="clientdata" hidden value="'.static::$clientid.'">
                                    <input id="acctype" hidden value="'.$row['accounttype'].'">
                                    <input id="chartdata" hidden value="'.$_GET['getloanapplicationdata'].'">
                                    '.(($rowpass['handle_status']=="0" || $rowpass['handle_status']=="1")?'<button onclick="saveapplication()" class="btn-primary btn"><i class="ti ti-save"></i> Save Application</button>':"").'
                                    <button onclick="closemodal()" class="btn-default btn">Cancel</button>
                                </div>
                            </div>
                        </div>
                    ';

                    echo '|<><>|';
                    foreach ($db->query(static::$sql2." WHERE acc_no='".static::$clientid ."'") as $row1) {
                        echo '
                            <div class="col-md-4">
                            <legend>Group Member '.$loop.'</legend>
                            <table width="100%">
                                <tr>
                                    <td width="50%" style="font-size: 12px"><label class="control-label">Client Names: </label></td>
                                    <td width="50%"> '.$row['firstname'].' '.$row['middlename'].' '.$row1['lastname'].'</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px"><label class="control-label">Gender: </label></td>
                                    <td>'.$row1['gender'].'</td>
                                </tr>
                                 <tr>
                                    <td style="font-size: 12px"><label class="control-label">Date of Birth: </label></td>
                                    <td>'.$row1['dateofbirth'].'</td>
                                </tr>
                                 <tr>
                                    <td style="font-size: 12px"><label class="control-label">Marital Status: </label></td>
                                    <td>'.$row1['maritalstatus'].'</td>
                                </tr>
                                 <tr>
                                    <td style="font-size: 12px"><label class="control-label">Mobile Number: </label></td>
                                    <td>'.$row1['mobilenumber'].'</td>
                                </tr>
                                 <tr>
                                    <td style="font-size: 12px"><label class="control-label">Physical Address: </label></td>
                                    <td>'.$row1['physicaladress'].'</td>
                                </tr>
                                 <tr>
                                    <td style="font-size: 12px"><label class="control-label">Sub County: </label></td>
                                    <td>'.$row1['subcounty'].'</td>
                                </tr>
                                 <tr>
                                    <td style="font-size: 12px"><label class="control-label">District: </label></td>
                                    <td>'.$row1['district'].'</td>
                                </tr>
                            </table>
                            </div>';
                        $loop++;
				}
				}
				if($row['accounttype'] == "3"){
                    $loop = 1;
                    echo '
                        <div class="grid-form">
                            <fieldset>
                                <legend>Client Data</legend>
                                <div id="clientbiodata">

                                </div>
                                <legend></legend>
                                <div data-row-span="1">
                                    <div data-field-span="1">
                                        <label>Type of Business:</label>
                                        <input value="" type="text" style="border: 0px;" id = "type_of_business" autofocus >
                                    </div>
                                </div>
                                <div data-row-span="3">
                                    <div data-field-span="1">
                                        <label>Date When you Need the Loan:</label>
                                        <input  value="" type="text" style="border: 0px;" id = "datepicker" autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>Loan amount Requested in Figures:</label>
                                        <input value="" type="text" style="border: 0px;" id = "ln_amount_figure" autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>Amount in Words:</label>
                                        <input value="" type="text" style="border: 0px;width: 500px;" id = "ln_amount_words" autofocus >
                                    </div>
                                </div>
                                <div data-row-span="5">
                                    <div data-field-span="1">
                                        <label>Intended Purpose:</label>
                                        <input value="" type="text" style="border: 0px;height: 31px;" id = "ln_intent" autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>Source of Repayment:</label>
                                        <input value="" type="text" style="border: 0px;height: 31px;" id = "ln_source" autofocus >
                                    </div>
                                     <div data-field-span="1">
                                        <label>Duration:</label>
                                        <input value="" type="text" style="border: 0px;height: 31px;" id = "ln_duration" autofocus >
                                    </div>
                                     <div data-field-span="1">
                                        <label>Repayment Schedule (weekly,monthly,other):</label>
                                        <select class="form-control" style="border: 0px;height: 21px;" id = "ln_schedule" autofocus>
											<option value = "">Select Type</option>
											<option value = "1">Monthly</option>
											<option value = "2">Weekly</option>
										</select>
                                    </div>
                                    <div data-field-span="1">
                                        <label>Type of Loan:</label>
                                        <select class="form-control" style="border: 0px;height: 21px;" id = "loan_type" autofocus>
											<option value="">select Loan Type</option>
											'; ACCOUNTTYPE::GETLOANTYPE(); echo'
										</select>
                                    </div>
                                </div>
                            <fieldset>
                                    <legend>CAPITAL</legend>
                                    <div data-row-span="2">
                                        <div data-field-span="1">
                                            <label>Number of shares:</label>
                                            <input required  type="text" value="'.number_format($row['shareaccount_amount']).'" style="border: 0px;" id = "no_of_shares" autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>assets owned like house, land, vehicle, business etc (indicate estimated value)? :</label>
                                            <input value="" type="text" style="border: 0px;" id = "own_assests" autofocus >
                                        </div>
                                    </div>
                                    <div data-row-span="2">
                                        <div data-field-span="1">
                                            <label>can assets be taken as collateral? which ones:</label>
                                            <input value="" type="text" style="border: 0px;" id = "col_assests" autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>do you have another loan with another financial institution:</label>
                                            <input value="" type="text" style="border: 0px;" id = "other_debt" autofocus >
                                        </div>
                                    </div>
                                    <div data-row-span="2">
                                        <div data-field-span="1">
                                            <label>purpose of previous loans:</label>
                                            <input value="" type="text" style="border: 0px;" id = "ln_purpose" autofocus >
                                        </div>
                                        <div data-field-span="1">
                                            <label>net worth:</label>
                                            <input value="" type="text" style="border: 0px;" id = "net_worth" autofocus >
                                        </div>
                                    </div>
                                </fieldset>
                            </fieldset>

                            <fieldset>
                                <legend>ABILITY TO PAY</legend>
                                    <div data-row-span="1">
                                        <div data-field-span="1">
                                            <label>how much can you afford to pay monthly:</label>
                                            <input value="" type="text" style="border: 0px;" id = "ablity_pay"  autofocus >
                                        </div>
                                    </div>
                                <legend>LC 1 RECOMMENDATION</legend>
                                <div data-row-span="3">
                                    <div data-field-span="1">
                                        <label>Name:</label>
                                        <input value=""  type="text" style="border: 0px; " id = "lc_name"  autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>Address:</label>
                                        <input value="" type="text" style="border: 0px; " id = "lc_address"  autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>contact/phone:</label>
                                        <input value="" type="text" style="border: 0px; " id = "lc_contact"  autofocus >
                                    </div>
                                </div>
                                <legend>GUARANTEE UNDERTAKING 1</legend>
                                <div data-row-span="4">
                                    <div data-field-span="1">
                                        <label>Name:</label>
                                        <select onchange="getguarantor1data()" id="grt1_name" class="selectpicker show-tick form-control" data-live-search="true">
                                              <option value="">select guarantor...</option>
                                              ';CLIENT_DATA::GUARANTORSCLIENT();echo'
                                        </select>
                                    </div>
                                    <div data-field-span="1">
                                        <label>village:</label>
                                        <input  type="text" value="" style="border: 0px;height: 34px" id="village1"  autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>place of residence:</label>
                                        <input style="border: 0px;height: 34px" id="residence1"  autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>contact/phone:</label>
                                        <input  type="text" value="" style="border: 0px;height: 34px" id="contact1"  autofocus >
                                    </div>
                                </div>
                                <div data-row-span="1">
                                    <div data-field-span="1">
                                        <label>Account no.:</label>
                                        <input   type="text" value="" style="border: 0px;" id="acount1"  autofocus >
                                    </div>
                                </div>
                                <legend>GUARANTEE UNDERTAKING 2</legend>
                                <div data-row-span="4">
                                    <div data-field-span="1">
                                        <label>Name:</label>
                                        <select onchange="getguarantor2data()" id="grt2_name" class="selectpicker show-tick form-control" data-live-search="true">
                                              <option value="">select guarantor...</option>
                                              ';CLIENT_DATA::GUARANTORSCLIENT();echo'
                                        </select>
                                    </div>
                                    <div data-field-span="1">
                                        <label>village:</label>
                                        <input  type="text" value="" style="border: 0px;height: 34px" id = "village2"  autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>place of residence:</label>
                                        <input style="border: 0px;height: 34px" id = "residence2" value=""  autofocus >
                                    </div>
                                    <div data-field-span="1">
                                        <label>contact/phone:</label>
                                        <input  type="text" value="" style="border: 0px;height: 34px" id = "contact2"  autofocus >
                                    </div>
                                </div>
                                <div data-row-span="1">
                                    <div data-field-span="1">
                                        <label>Account no.:</label>
                                        <input   type="text" value="" style="border: 0px;height: 34px" id = "acount2"  autofocus >
                                    </div>
                                </div>
                            </fieldset>

                            <div class="clearfix pt-md">
                                <div class="pull-right">
                                    <input id="clientdata" hidden value="'.static::$clientid.'">
                                    <input id="acctype" hidden value="'.$row['accounttype'].'">
                                    <input id="chartdata" hidden value="'.$_GET['getloanapplicationdata'].'">
                                    '.(($rowpass['handle_status']=="0" || $rowpass['handle_status']=="1")?'<button onclick="saveapplication()" class="btn-primary btn"><i class="ti ti-save"></i> Save Application</button>':"").'
                                    <button onclick="closemodal()" class="btn-default btn">Cancel</button>
                                </div>
                            </div>
                        </div>
                    ';

                    echo '|<><>|';
                    foreach ($db->query(static::$sql3." WHERE acc_no='".static::$clientid ."'") as $row1) {
                        echo '
                            <div class="col-md-12">
                            <legend>Business/Organisation/Association Detail</legend>
                            <table width="100%">
                                <tr>
                                    <td width="50%" style="font-size: 12px"><label class="control-label">Business/Organisation/Association Name: </label></td>
                                    <td width="50%"> '.$row['accountname'].'</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px"><label class="control-label">Account Signatories: </label></td>
                                    <td>'.$row1['name1']." ,".$row1['name2']." ,".$row1['name3'].'</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px"><label class="control-label">Physical Address: </label></td>
                                    <td>'.$row1['physicaladress'].'</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px"><label class="control-label">Sub County: </label></td>
                                    <td>'.$row1['subcounty'].'</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px"><label class="control-label">District: </label></td>
                                    <td>'.$row1['district'].'</td>
                                </tr>
                            </table>
                            </div>';
                    }

                }
            }
        }

    }
    public static function LOANAPPRAISALDATA(){
        $db = new DB();  session_start();
        foreach ($db->query("SELECT * FROM users WHERE user_id='".$_SESSION['user_id']."'") as $rowpass){}
        foreach ($db->query("SELECT * FROM loan_appraisal WHERE chartid='".$_GET['getloanappraisaldata']."'") as $row1){
            $chartid = $row1['appraisal_id'];
        }
        if($chartid){
            foreach ($db->query("SELECT * FROM post_chart WHERE chartid='".$_GET['getloanappraisaldata']."'") as $row1){$client = CLIENT_DATA::$clientid = $row1['clientid'];}
            foreach ($db->query("SELECT * FROM loan_appraisal WHERE chartid='".$_GET['getloanappraisaldata']."'") as $rowapp1){
                foreach ($db->query("SELECT * FROM loan_application1 WHERE chartid='".$_GET['getloanappraisaldata']."'") as $rowapp){
                    foreach ($db->query(static::$sql." WHERE clientid='".static::$clientid."'") as $row){
                        if($row['accounttype'] == "1"){
                            foreach ($db->query(static::$sql1." WHERE acc_no='".static::$clientid ."'") as $row1){
                                CLIENT_DATA::$clientid = $rowapp['grt1_id'];
                                self::CLIENTDATAMAIN();
                                $data1 = static::$accountname;
                                $data2 = static::$accountno;
                                $data3 = static::$mobilenumber;
                                $data4 = static::$physicaladress;
                                $data5 = static::$subcounty;
                                CLIENT_DATA::$clientid = $rowapp['grt2_id'];
                                self::CLIENTDATAMAIN();
                                $data8 = static::$accountname;
                                $data9 = static::$accountno;
                                $data10 = static::$mobilenumber;
                                $data11= static::$physicaladress;
                                $data12 = static::$subcounty;
                                $sql ="SELECT * FROM users WHERE user_id='".$rowapp1['ln_officer']."'";
                                foreach ($db->query($sql) as $rows){
                                    $officer = $rows['names'];
                                }
                                echo '
                                        <div class="grid-form">
                                            <fieldset>
                                                <legend>Appraisal form</legend>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Loan officer\'s Name:</label>
                                                        <input value="'.$officer.'" type="text" style="border: 0px;width: 600px;"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <legend>PERSONAL DATA OF APPLICANT</legend>
                                                <div data-row-span="2">
                                                    <div data-field-span="1">
                                                        <label>Name of Applicant:</label>
                                                        <input value="'.$row1['firstname'].' '.$row1['secondname'].' '.$row1['lastname'].'" type="text" style="border: 0px; width: 300px;" id = "ln_lname"  autofocus required = "">
                                                    </div>
                                                    <div data-field-span="1">
                                                        <label>Tel:</label>
                                                        <input value="'.$row1['mobilenumber'].'" type="text" style="border: 0px; width: 300px;" id = "ln_lname"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Account No.:</label>
                                                        <input value="'.$row['accountno'].'" type="text" style="border: 0px;width: 300px;" id = "ln_fname"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="2">
                                                    <div style="height: 30px;width: 25%;" data-field-span="1">
                                                        <label>Location of residence:</label>
                                                        <input value="'.$row1['subcounty'].'" type="text" style="border: 0px; width: 300px;" name = "residence"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Name of spouse:</label>
                                                        <input value="'.$rowapp['kin_name'].'" type="text" style="border: 0px;width: 300px;" name = "ln_spname"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <legend>PROJECT TO BE FINANCED</legend>
                                                <div data-row-span="3">
                                                    <div style="height: 30px;width: 25%;" data-field-span="1">
                                                        <label>Type of project:</label>
                                                        <input value="'.$rowapp['type_of_business'].'" type="text" style="border: 0px;width: 300px;" id = "proj_type"  autofocus required = "">
                                                    </div>
                                                    <div style="height: 30px;width: 25%;" data-field-span="1">
                                                        <label>Age of project:</label>
                                                        <input value="'.$rowapp1['proj_age'].'"  type="text" style="border: 0px;width: 300px;" id = "proj_age"  autofocus required = "">
                                                    </div>
                                                    <div style="height: 30px; width: 25%;" data-field-span="1">
                                                        <label>Location:</label>
                                                        <input value="'.$rowapp1['proj_loc'].'" type="text" style="border: 0px;width: 300px;" id = "proj_loc"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <legend>DATA ON CREDIT APPLICATION</legend>
                                                <div data-row-span="2">
                                                    <div data-field-span="1">
                                                        <label>Amount applied for:</label>
                                                        <input value="'.number_format($rowapp['loan_amount']).'" type="text" style="border: 0px;width: 300px;" name = "ln_fname"  autofocus required = "">
                                                    </div>
                                                    <div data-field-span="1">
                                                        <label>Loan Period:</label>
                                                        <input value="'.$rowapp['duration'].'" type="text" style="border: 0px;width: 300px;" name = "ln_fname"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Purpose of the loan(specify):</label>
                                                        <input value="'.$rowapp['int_purpose'].'" type="text" style="border: 0px;width: 300px;" name = "ln_fname"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Applicant\'s proposed installment(amount he/she thinks can pay every month):</label>
                                                        <input value="'.number_format($rowapp['ability_to_pay']).'"  type="text" style="border: 0px;width: 300px;" name = "proposed_instal" autofocus required = "">
                                                    </div>
                                                </div>
                                                <legend>CHARACTER</legend>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Honesty:</label>
                                                        <input value="'.$rowapp1['honesty'].'" type="text" style="border: 0px;width: 300px;" id = "honesty"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Load repayment history:</label>
                                                        <input value="'.$rowapp1['repay_hist'].'" type="text" style="border: 0px;width: 300px;" id = "repay_hist"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>How long has applicant lived in that area?:</label>
                                                        <input value="'.$rowapp1['time_in_area'].'" type="text" style="border: 0px;width: 300px;" id = "time_in_area"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>if new, where did the applicant come from and why?:</label>
                                                        <input value="'.$rowapp1['new_applnt_from'].'" type="text" style="border: 0px;width: 300px;" id = "new_applnt_from"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>is the applicant permanent resident of your area or he is simply renting business and residential premises?:</label>
                                                        <input value="'.$rowapp1['residence_status'].'" type="text" style="border: 0px;width: 300px;" id = "residence_status"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="2">
                                                    <div data-field-span="1">
                                                        <label>Total number of household member:</label>
                                                        <input value="'.$rowapp1['no_ofhousehousde'].'"  type="text" style="border: 0px;width: 300px;" id = "no_ofhousehousde" autofocus required = "">
                                                    </div>
                                                    <div data-field-span="1">
                                                        <label>Number of Children:</label>
                                                        <input value="'.$rowapp1['no_children'].'"  type="text" style="border: 0px;width: 300px;" id = "no_children" autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Specify ease of migration to another area:</label>
                                                        <input value="'.$rowapp1['ease_migrat'].'" type="text" style="border: 0px;width: 300px;" id = "ease_migrat"  autofocus required = "">
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <legend>CAPACITY TO REPAY THE LOAN</legend>
                                                <div class="row">
                                                    <div class="col-xs-6">

                                                        <div class="panel-body">
                                                            <p>(a)   Monthly income from all sources(these could include)</p>
                                                            <table id="incometable" class="table table-bordered m-n">
                                                                <thead>
                                                                <tr>

                                                                    <th><b>DESCRIPTION</b></th>
                                                                    <th><b>AMOUNT</b></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>

                                                                    <td>Sale of products</td>
                                                                    <td><input onkeyup="appsum2()" id="sale_prod" value="'.$rowapp1['sale_prod'].'" type="text"></td>
                                                                </tr>
                                                                <tr>

                                                                    <td>Sale of animals products e.g milk,ghee,meat etc</td>
                                                                    <td><input onkeyup="appsum2()" id="sale_animal_pro" value="'.$rowapp1['sale_animal_pro'].'" type="text"></td>
                                                                </tr>
                                                                <tr>

                                                                    <td>Animal Sales</td>
                                                                    <td><input onkeyup="appsum2()" id="ani_sales" value="'.$rowapp1['ani_sales'].'" type="text"></td>
                                                                </tr>
                                                                <tr>

                                                                    <td>Salary if employed/salary of spouse</td>
                                                                    <td><input onkeyup="appsum2()" id="salary" value="'.$rowapp1['salary'].'" type="text"></td>
                                                                </tr>
                                                                <tr>

                                                                    <td>Building/ land for renting etc</td>
                                                                    <td><input onkeyup="appsum2()" id="bldg" value="'.$rowapp1['bldg'].'" type="text"></td>
                                                                </tr>
                                                                <tr>

                                                                    <td>Others</td>
                                                                    <td><input onkeyup="appsum2()"  id="others" value="'.$rowapp1['others'].'" type="text"></td>
                                                                </tr>
                                                                <tr>

                                                                    <td><b>TOTAL INCOME</b></td>
                                                                    <td><input id="total" value="'.$rowapp1['total'].'" type="text"></td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6">

                                                        <div class="panel-body">
                                                            <p>(b)  Monthly expenses</p>
                                                            <table id="expensetable" class="table table-bordered m-n">
                                                                <thead>
                                                                <tr>
                                                                    <th><b>DESCRIPTION</b></th>
                                                                    <th><b>AMOUNT</b></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td>Food</td>
                                                                    <td><input onkeyup="appsum1()" id="food" value="'.$rowapp1['food'].'" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Medicine</td>
                                                                    <td><input onkeyup="appsum1()" id="medicine" value="'.$rowapp1['medicine'].'" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Clothing</td>
                                                                    <td><input onkeyup="appsum1()" id="clothing" value="'.$rowapp1['clothing'].'" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>School fees</td>
                                                                    <td><input onkeyup="appsum1()" id="school_fees" value="'.$rowapp1['school_fees'].'" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Transport</td>
                                                                    <td><input onkeyup="appsum1()" id="transp" value="'.$rowapp1['transport'].'" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Utilities</td>
                                                                    <td><input onkeyup="appsum1()" id="utility" value="'.$rowapp1['utility'].'" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Entertainment (visitors,alcohol,donations etc)</td>
                                                                    <td><input onkeyup="appsum1()" id="entertainment" value="'.$rowapp1['entertainment'].'" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Others</td>
                                                                    <td><input onkeyup="appsum1()" id="others_2" value="'.$rowapp1['others_2'].'" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><b>TOTAL EXPENSES</b></td>
                                                                    <td><input id="ttl_1" value="'.$rowapp1['ttl_1'].'" type="text"></td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <p>(c)  Disposal amount (Total income-total expenses)shs</p>
                                                    <input type="text" style="border: 0px;width: 300px;" id = "dis_amt" value="'.$rowapp1['dis_amt'].'"  autofocus required = "">
                                                    <b>It is from the disposal amount that you can determine the size of the loan monthly installments which the applicant can pay with ease and therefore use it to determine the size of the loan to be granted depending on the loan period</b>
                                                </div>
                                                <legend>CAPITAL/CONTRIBUTION</legend>
                                                <div data-row-span="1">
                                                    <label>What is the saving behaviour of the applicant as judged from the saving account:</label>
                                                    <input value="'.$rowapp1['behave_savg'].'"  type="text" style="border: 0px;width: 300px;" id = "behave_savg" autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Monthly average saving balance:</label>
                                                    <input value="'.$rowapp1['avg_monthly_saving'].'" type="text" style="border: 0px;width: 300px;" id = "avg_monnthly_saving"  autofocus required = "">
                                                    <b>(Be careful with dormant savings accounts which carry fairy good balances. They could be a trap)</b>
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Value of shares in shillings(shs).:</label>
                                                    <input value="'.(($rowapp1['no_ofshares'])?$rowapp1['no_ofshares']:$row['shareaccount_amount']).'" type="text" style="border: 0px;width: 300px;" id = "no_ofshares"  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Saving Balance:</label>
                                                    <input value="'.(($rowapp1['actual_savg'])?$rowapp1['actual_savg']:$row['savingaccount']).'" type="text" style="border: 0px;width: 300px;" id = "actual_savg"  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Previous Loan Amount:</label>
                                                    <input value="'.$rowapp1['prev_loan'].'"  type="text" style="border: 0px; width: 300px;" id = "prev_loan" autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Out Standing Balance:</label>
                                                    <input value="'.$rowapp1['savg_bal'].'"  type="text" style="border: 0px; width: 300px;" id = "savg_bal" autofocus required = "">
                                                </div>
                                                <legend>CONDITIONS</legend>
                                                <p>Are Conditions favorable for the loan applied for? Such conditions can be:</p>
                                                <div data-row-span="1">
                                                    <label>Climate:</label>
                                                    <input value="'.$rowapp1['cond_avail'].'" type="text" style="border: sss0px;width: 300px;" id = "cond_avail"  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Business Season:</label>
                                                    <input value="'.$rowapp1['bus_season'].'"  type="text" style="border: 0px; width: 300px;" id = "bus_season" value=""  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Time of social obligation such as school fees period:</label>
                                                    <input value="'.$rowapp1['social_obligation'].'" type="text" style="border: 0px; width: 300px;" id = "social_obligation"  autofocus required = "">
                                                </div>
                                                <legend>COLLATERAL</legend>
                                                <div data-row-span="1">
                                                    <label>What collateral are being offered:</label>
                                                    <input value="'.$rowapp1['col_offer'].'" type="text" style="border: 0px;width: 300px;" id = "col_offer"  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>What is the Value according to the Owner?</label>
                                                    <input value="'.$rowapp1['val_own'].'"  type="text" style="border: 0px; width: 300px;" id = "val_own"  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>What is the Loan offer\'s value?</label>
                                                    <input value="'.$rowapp1['ln_off_val'].'" type="text" style="border: 0px; width: 300px;" id = "ln_off_val"  autofocus required = "">
                                                </div>
                                                <legend>Who are the guarantors of the loan?</legend>
                                                <div data-row-span="1">
                                                    <label>Names (1):</label>
                                                    <input value=" '.$data1.'" type="text" style="border: 0px;width: 300px;" name = "guat_name1"  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Names (2):</label>
                                                    <input value=" '.$data8.'" type="text" style="border: 0px; width: 300px;" name = "guat_name2"  autofocus required = "">
                                                </div>
                                            </fieldset>

                                            <div class="modal-footer">
                                                <input id="clientdata" hidden value="'.static::$clientid.'">
                                                <input id="ln_officer" hidden value="'.$_SESSION['user_id'].'">
                                                <input id="loandata" hidden value="'.$rowapp['loan_id'].'">
                                                <input id="chartdata" hidden value="'.$_GET['getloanappraisaldata'].'">
                                                '.(($rowpass['handle_status']=="0")?"<button onclick=\"saveappraisal()\"  class=\"btn btn-primary\">Submit Appraisal</button>":"").'
                                                <button type="reset" class="btn btn-default" onclick="closemodal1()">Cancel</button>
                                                <a onclick="PrintElem(\'loanappraisaldetails\',\'\')"  class="btn btn-inverse" data-target="#loanreport" data-toggle="modal"><i class="ti ti-printer" ></i></a>
                                            </div>
                                        </div>
                            ';
                            }
                        }
                        if($row['accounttype'] == "2"){
                            $loop = 1;
							CLIENT_DATA::$clientid = $rowapp['grt1_id'];
							self::CLIENTDATAMAIN();
							$data1 = static::$accountname;
							$data2 = static::$accountno;
							$data3 = static::$mobilenumber;
							$data4 = static::$physicaladress;
							$data5 = static::$subcounty;
							CLIENT_DATA::$clientid = $rowapp['grt2_id'];
							self::CLIENTDATAMAIN();
							$data8 = static::$accountname;
							$data9 = static::$accountno;
							$data10 = static::$mobilenumber;
							$data11= static::$physicaladress;
							$data12 = static::$subcounty;
							$sql ="SELECT * FROM users WHERE user_id='".$rowapp1['ln_officer']."'";
							foreach ($db->query($sql) as $rows){
								$officer = $rows['names'];
							}
							$data = "";
							foreach ($db->query(static::$sql2." WHERE acc_no='".$row["clientid"]."'") as $row2){
								$data .=", ".$row2['mobilenumber'];
							}
                             echo '
                                        <div class="grid-form">
                                            <fieldset>
                                                <legend>Appraisal form</legend>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Loan officer\'s Name:</label>
                                                        <input value="'.$officer.'" type="text" style="border: 0px;width: 600px;"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <legend>PERSONAL DATA OF APPLICANT</legend>
												<div data-row-span="2">
													<div data-field-span="1">
														<label>Name of Applicant:</label>
														<input value="'.$row['accountname'].'" type="text" style="border: 0px; width: 300px;" id = "ln_lname"  autofocus required = "">
													</div>
													<div data-field-span="1">
														<label>Tel:</label>
														<input value="'.$data.'" type="text" style="border: 0px; width: 500px;" id = "ln_lname"  autofocus required = "">
													</div>
												</div>
												<div data-row-span="1">
													<div data-field-span="1">
														<label>Account No.:</label>
														<input value="'.$row['accountno'].'" type="text" style="border: 0px;width: 300px;" id = "ln_fname"  autofocus required = "">
													</div>
												</div>
                                                <legend>PROJECT TO BE FINANCED</legend>
                                                <div data-row-span="3">
                                                    <div style="height: 30px;width: 25%;" data-field-span="1">
                                                        <label>Type of project:</label>
                                                        <input value="'.$rowapp['type_of_business'].'" type="text" style="border: 0px;width: 300px;" id = "proj_type"  autofocus required = "">
                                                    </div>
                                                    <div style="height: 30px;width: 25%;" data-field-span="1">
                                                        <label>Age of project:</label>
                                                        <input value="'.$rowapp1['proj_age'].'"  type="text" style="border: 0px;width: 300px;" id = "proj_age"  autofocus required = "">
                                                    </div>
                                                    <div style="height: 30px; width: 25%;" data-field-span="1">
                                                        <label>Location:</label>
                                                        <input value="'.$rowapp1['proj_loc'].'" type="text" style="border: 0px;width: 300px;" id = "proj_loc"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <legend>DATA ON CREDIT APPLICATION</legend>
                                                <div data-row-span="2">
                                                    <div data-field-span="1">
                                                        <label>Amount applied for:</label>
                                                        <input value="'.number_format($rowapp['loan_amount']).'" type="text" style="border: 0px;width: 300px;" name = "ln_fname"  autofocus required = "">
                                                    </div>
                                                    <div data-field-span="1">
                                                        <label>Loan Period:</label>
                                                        <input value="'.$rowapp['duration'].'" type="text" style="border: 0px;width: 300px;" name = "ln_fname"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Purpose of the loan(specify):</label>
                                                        <input value="'.$rowapp['int_purpose'].'" type="text" style="border: 0px;width: 300px;" name = "ln_fname"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Applicant\'s proposed installment(amount he/she thinks can pay every month):</label>
                                                        <input value="'.number_format($rowapp['ability_to_pay']).'"  type="text" style="border: 0px;width: 300px;" name = "proposed_instal" autofocus required = "">
                                                    </div>
                                                </div>
                                                <legend>CHARACTER</legend>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Honesty:</label>
                                                        <input value="'.$rowapp1['honesty'].'" type="text" style="border: 0px;width: 300px;" id = "honesty"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Load repayment history:</label>
                                                        <input value="'.$rowapp1['repay_hist'].'" type="text" style="border: 0px;width: 300px;" id = "repay_hist"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>How long has applicant lived in that area?:</label>
                                                        <input value="'.$rowapp1['time_in_area'].'" type="text" style="border: 0px;width: 300px;" id = "time_in_area"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>if new, where did the applicant come from and why?:</label>
                                                        <input value="'.$rowapp1['new_applnt_from'].'" type="text" style="border: 0px;width: 300px;" id = "new_applnt_from"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>is the applicant permanent resident of your area or he is simply renting business and residential premises?:</label>
                                                        <input value="'.$rowapp1['residence_status'].'" type="text" style="border: 0px;width: 300px;" id = "residence_status"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="2">
                                                    <div data-field-span="1">
                                                        <label>Total number of household member:</label>
                                                        <input value="'.$rowapp1['no_ofhousehousde'].'"  type="text" style="border: 0px;width: 300px;" id = "no_ofhousehousde" autofocus required = "">
                                                    </div>
                                                    <div data-field-span="1">
                                                        <label>Number of Children:</label>
                                                        <input value="'.$rowapp1['no_children'].'"  type="text" style="border: 0px;width: 300px;" id = "no_children" autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Specify ease of migration to another area:</label>
                                                        <input value="'.$rowapp1['ease_migrat'].'" type="text" style="border: 0px;width: 300px;" id = "ease_migrat"  autofocus required = "">
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <legend>CAPACITY TO REPAY THE LOAN</legend>
                                                <div class="row">
                                                    <div class="col-xs-6">

                                                        <div class="panel-body">
                                                            <p>(a)   Monthly income from all sources(these could include)</p>
                                                            <table id="incometable" class="table table-bordered m-n">
                                                                <thead>
                                                                <tr>

                                                                    <th><b>DESCRIPTION</b></th>
                                                                    <th><b>AMOUNT</b></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>

                                                                    <td>Sale of products</td>
                                                                    <td><input onkeyup="appsum2()" id="sale_prod" value="'.$rowapp1['sale_prod'].'" type="text"></td>
                                                                </tr>
                                                                <tr>

                                                                    <td>Sale of animals products e.g milk,ghee,meat etc</td>
                                                                    <td><input onkeyup="appsum2()" id="sale_animal_pro" value="'.$rowapp1['sale_animal_pro'].'" type="text"></td>
                                                                </tr>
                                                                <tr>

                                                                    <td>Animal Sales</td>
                                                                    <td><input onkeyup="appsum2()" id="ani_sales" value="'.$rowapp1['ani_sales'].'" type="text"></td>
                                                                </tr>
                                                                <tr>

                                                                    <td>Salary if employed/salary of spouse</td>
                                                                    <td><input onkeyup="appsum2()" id="salary" value="'.$rowapp1['salary'].'" type="text"></td>
                                                                </tr>
                                                                <tr>

                                                                    <td>Building/ land for renting etc</td>
                                                                    <td><input onkeyup="appsum2()" id="bldg" value="'.$rowapp1['bldg'].'" type="text"></td>
                                                                </tr>
                                                                <tr>

                                                                    <td>Others</td>
                                                                    <td><input onkeyup="appsum2()"  id="others" value="'.$rowapp1['others'].'" type="text"></td>
                                                                </tr>
                                                                <tr>

                                                                    <td><b>TOTAL INCOME</b></td>
                                                                    <td><input id="total" value="'.$rowapp1['total'].'" type="text"></td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6">

                                                        <div class="panel-body">
                                                            <p>(b)  Monthly expenses</p>
                                                            <table id="expensetable" class="table table-bordered m-n">
                                                                <thead>
                                                                <tr>
                                                                    <th><b>DESCRIPTION</b></th>
                                                                    <th><b>AMOUNT</b></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td>Food</td>
                                                                    <td><input onkeyup="appsum1()" id="food" value="'.$rowapp1['food'].'" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Medicine</td>
                                                                    <td><input onkeyup="appsum1()" id="medicine" value="'.$rowapp1['medicine'].'" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Clothing</td>
                                                                    <td><input onkeyup="appsum1()" id="clothing" value="'.$rowapp1['clothing'].'" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>School fees</td>
                                                                    <td><input onkeyup="appsum1()" id="school_fees" value="'.$rowapp1['school_fees'].'" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Transport</td>
                                                                    <td><input onkeyup="appsum1()" id="transp" value="'.$rowapp1['transport'].'" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Utilities</td>
                                                                    <td><input onkeyup="appsum1()" id="utility" value="'.$rowapp1['utility'].'" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Entertainment (visitors,alcohol,donations etc)</td>
                                                                    <td><input onkeyup="appsum1()" id="entertainment" value="'.$rowapp1['entertainment'].'" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Others</td>
                                                                    <td><input onkeyup="appsum1()" id="others_2" value="'.$rowapp1['others_2'].'" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><b>TOTAL EXPENSES</b></td>
                                                                    <td><input id="ttl_1" value="'.$rowapp1['ttl_1'].'" type="text"></td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <p>(c)  Disposal amount (Total income-total expenses)shs</p>
                                                    <input type="text" style="border: 0px;width: 300px;" id = "dis_amt" value="'.$rowapp1['dis_amt'].'"  autofocus required = "">
                                                    <b>It is from the disposal amount that you can determine the size of the loan monthly installments which the applicant can pay with ease and therefore use it to determine the size of the loan to be granted depending on the loan period</b>
                                                </div>
                                                <legend>CAPITAL/CONTRIBUTION</legend>
                                                <div data-row-span="1">
                                                    <label>What is the saving behaviour of the applicant as judged from the saving account:</label>
                                                    <input value="'.$rowapp1['behave_savg'].'"  type="text" style="border: 0px;width: 300px;" id = "behave_savg" autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Monthly average saving balance:</label>
                                                    <input value="'.$rowapp1['avg_monthly_saving'].'" type="text" style="border: 0px;width: 300px;" id = "avg_monnthly_saving"  autofocus required = "">
                                                    <b>(Be careful with dormant savings accounts which carry fairy good balances. They could be a trap)</b>
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Value of shares in shillings(shs).:</label>
                                                    <input value="'.(($rowapp1['no_ofshares'])?$rowapp1['no_ofshares']:$row['shareaccount_amount']).'" type="text" style="border: 0px;width: 300px;" id = "no_ofshares"  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Saving Balance:</label>
                                                    <input value="'.(($rowapp1['actual_savg'])?$rowapp1['actual_savg']:$row['savingaccount']).'" type="text" style="border: 0px;width: 300px;" id = "actual_savg"  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Previous Loan Amount:</label>
                                                    <input value="'.$rowapp1['prev_loan'].'"  type="text" style="border: 0px; width: 300px;" id = "prev_loan" autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Out Standing Balance:</label>
                                                    <input value="'.$rowapp1['savg_bal'].'"  type="text" style="border: 0px; width: 300px;" id = "savg_bal" autofocus required = "">
                                                </div>
                                                <legend>CONDITIONS</legend>
                                                <p>Are Conditions favorable for the loan applied for? Such conditions can be:</p>
                                                <div data-row-span="1">
                                                    <label>Climate:</label>
                                                    <input value="'.$rowapp1['cond_avail'].'" type="text" style="border: sss0px;width: 300px;" id = "cond_avail"  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Business Season:</label>
                                                    <input value="'.$rowapp1['bus_season'].'"  type="text" style="border: 0px; width: 300px;" id = "bus_season" value=""  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Time of social obligation such as school fees period:</label>
                                                    <input value="'.$rowapp1['social_obligation'].'" type="text" style="border: 0px; width: 300px;" id = "social_obligation"  autofocus required = "">
                                                </div>
                                                <legend>COLLATERAL</legend>
                                                <div data-row-span="1">
                                                    <label>What collateral are being offered:</label>
                                                    <input value="'.$rowapp1['col_offer'].'" type="text" style="border: 0px;width: 300px;" id = "col_offer"  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>What is the Value according to the Owner?</label>
                                                    <input value="'.$rowapp1['val_own'].'"  type="text" style="border: 0px; width: 300px;" id = "val_own"  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>What is the Loan offer\'s value?</label>
                                                    <input value="'.$rowapp1['ln_off_val'].'" type="text" style="border: 0px; width: 300px;" id = "ln_off_val"  autofocus required = "">
                                                </div>
                                                <legend>Who are the guarantors of the loan?</legend>
                                                <div data-row-span="1">
                                                    <label>Names (1):</label>
                                                    <input value=" '.$data1.'" type="text" style="border: 0px;width: 300px;" name = "guat_name1"  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Names (2):</label>
                                                    <input value=" '.$data8.'" type="text" style="border: 0px; width: 300px;" name = "guat_name2"  autofocus required = "">
                                                </div>
                                            </fieldset>

                                            <div class="modal-footer">
                                                <input id="clientdata" hidden value="'.static::$clientid.'">
                                                <input id="ln_officer" hidden value="'.$_SESSION['user_id'].'">
                                                <input id="loandata" hidden value="'.$rowapp['loan_id'].'">
                                                <input id="chartdata" hidden value="'.$_GET['getloanappraisaldata'].'">
                                                '.(($rowpass['handle_status']=="0")?"<button onclick=\"saveappraisal()\"  class=\"btn btn-primary\">Submit Appraisal</button>":"").'
                                                <button type="reset" class="btn btn-default" onclick="closemodal1()">Cancel</button>
                                                <a onclick="PrintElem(\'loanappraisaldetails\',\'\')"  class="btn btn-inverse" data-target="#loanreport" data-toggle="modal"><i class="ti ti-printer" ></i></a>
                                            </div>
                                        </div>
                            ';
                        }
						if($row['accounttype'] == "3"){
                            $loop = 1;
							CLIENT_DATA::$clientid = $rowapp['grt1_id'];
							self::CLIENTDATAMAIN();
							$data1 = static::$accountname;
							$data2 = static::$accountno;
							$data3 = static::$mobilenumber;
							$data4 = static::$physicaladress;
							$data5 = static::$subcounty;
							CLIENT_DATA::$clientid = $rowapp['grt2_id'];
							self::CLIENTDATAMAIN();
							$data8 = static::$accountname;
							$data9 = static::$accountno;
							$data10 = static::$mobilenumber;
							$data11= static::$physicaladress;
							$data12 = static::$subcounty;
							$sql ="SELECT * FROM users WHERE user_id='".$rowapp1['ln_officer']."'";
							foreach ($db->query($sql) as $rows){
								$officer = $rows['names'];
							}
							
							foreach ($db->query(static::$sql3." WHERE acc_no='".$row["clientid"]."'") as $row2){}
                             echo '
                                        <div class="grid-form">
                                            <fieldset>
                                                <legend>Appraisal form</legend>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Loan officer\'s Name:</label>
                                                        <input value="'.$officer.'" type="text" style="border: 0px;width: 600px;"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <legend>PERSONAL DATA OF APPLICANT</legend>
												<div data-row-span="2">
													<div data-field-span="1">
														<label>Name of Applicant:</label>
														<input value="'.$row['accountname'].'" type="text" style="border: 0px; width: 300px;" id = "ln_lname"  autofocus required = "">
													</div>
													<div data-field-span="1">
														<label>Tel:</label>
														<input value="'.$row2['officetel'].'" type="text" style="border: 0px; width: 500px;" id = "ln_lname"  autofocus required = "">
													</div>
												</div>
												<div data-row-span="1">
													<div data-field-span="1">
														<label>Account No.:</label>
														<input value="'.$row['accountno'].'" type="text" style="border: 0px;width: 300px;" id = "ln_fname"  autofocus required = "">
													</div>
												</div>
                                                <legend>PROJECT TO BE FINANCED</legend>
                                                <div data-row-span="3">
                                                    <div style="height: 30px;width: 25%;" data-field-span="1">
                                                        <label>Type of project:</label>
                                                        <input value="'.$rowapp['type_of_business'].'" type="text" style="border: 0px;width: 300px;" id = "proj_type"  autofocus required = "">
                                                    </div>
                                                    <div style="height: 30px;width: 25%;" data-field-span="1">
                                                        <label>Age of project:</label>
                                                        <input value="'.$rowapp1['proj_age'].'"  type="text" style="border: 0px;width: 300px;" id = "proj_age"  autofocus required = "">
                                                    </div>
                                                    <div style="height: 30px; width: 25%;" data-field-span="1">
                                                        <label>Location:</label>
                                                        <input value="'.$rowapp1['proj_loc'].'" type="text" style="border: 0px;width: 300px;" id = "proj_loc"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <legend>DATA ON CREDIT APPLICATION</legend>
                                                <div data-row-span="2">
                                                    <div data-field-span="1">
                                                        <label>Amount applied for:</label>
                                                        <input value="'.number_format($rowapp['loan_amount']).'" type="text" style="border: 0px;width: 300px;" name = "ln_fname"  autofocus required = "">
                                                    </div>
                                                    <div data-field-span="1">
                                                        <label>Loan Period:</label>
                                                        <input value="'.$rowapp['duration'].'" type="text" style="border: 0px;width: 300px;" name = "ln_fname"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Purpose of the loan(specify):</label>
                                                        <input value="'.$rowapp['int_purpose'].'" type="text" style="border: 0px;width: 300px;" name = "ln_fname"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Applicant\'s proposed installment(amount he/she thinks can pay every month):</label>
                                                        <input value="'.number_format($rowapp['ability_to_pay']).'"  type="text" style="border: 0px;width: 300px;" name = "proposed_instal" autofocus required = "">
                                                    </div>
                                                </div>
                                                <legend>CHARACTER</legend>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Honesty:</label>
                                                        <input value="'.$rowapp1['honesty'].'" type="text" style="border: 0px;width: 300px;" id = "honesty"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Load repayment history:</label>
                                                        <input value="'.$rowapp1['repay_hist'].'" type="text" style="border: 0px;width: 300px;" id = "repay_hist"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>How long has applicant lived in that area?:</label>
                                                        <input value="'.$rowapp1['time_in_area'].'" type="text" style="border: 0px;width: 300px;" id = "time_in_area"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>if new, where did the applicant come from and why?:</label>
                                                        <input value="'.$rowapp1['new_applnt_from'].'" type="text" style="border: 0px;width: 300px;" id = "new_applnt_from"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>is the applicant permanent resident of your area or he is simply renting business and residential premises?:</label>
                                                        <input value="'.$rowapp1['residence_status'].'" type="text" style="border: 0px;width: 300px;" id = "residence_status"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="2">
                                                    <div data-field-span="1">
                                                        <label>Total number of household member:</label>
                                                        <input value="'.$rowapp1['no_ofhousehousde'].'"  type="text" style="border: 0px;width: 300px;" id = "no_ofhousehousde" autofocus required = "">
                                                    </div>
                                                    <div data-field-span="1">
                                                        <label>Number of Children:</label>
                                                        <input value="'.$rowapp1['no_children'].'"  type="text" style="border: 0px;width: 300px;" id = "no_children" autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Specify ease of migration to another area:</label>
                                                        <input value="'.$rowapp1['ease_migrat'].'" type="text" style="border: 0px;width: 300px;" id = "ease_migrat"  autofocus required = "">
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <legend>CAPACITY TO REPAY THE LOAN</legend>
                                                <div class="row">
                                                    <div class="col-xs-6">

                                                        <div class="panel-body">
                                                            <p>(a)   Monthly income from all sources(these could include)</p>
                                                            <table id="incometable" class="table table-bordered m-n">
                                                                <thead>
                                                                <tr>

                                                                    <th><b>DESCRIPTION</b></th>
                                                                    <th><b>AMOUNT</b></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>

                                                                    <td>Sale of products</td>
                                                                    <td><input onkeyup="appsum2()" id="sale_prod" value="'.$rowapp1['sale_prod'].'" type="text"></td>
                                                                </tr>
                                                                <tr>

                                                                    <td>Sale of animals products e.g milk,ghee,meat etc</td>
                                                                    <td><input onkeyup="appsum2()" id="sale_animal_pro" value="'.$rowapp1['sale_animal_pro'].'" type="text"></td>
                                                                </tr>
                                                                <tr>

                                                                    <td>Animal Sales</td>
                                                                    <td><input onkeyup="appsum2()" id="ani_sales" value="'.$rowapp1['ani_sales'].'" type="text"></td>
                                                                </tr>
                                                                <tr>

                                                                    <td>Salary if employed/salary of spouse</td>
                                                                    <td><input onkeyup="appsum2()" id="salary" value="'.$rowapp1['salary'].'" type="text"></td>
                                                                </tr>
                                                                <tr>

                                                                    <td>Building/ land for renting etc</td>
                                                                    <td><input onkeyup="appsum2()" id="bldg" value="'.$rowapp1['bldg'].'" type="text"></td>
                                                                </tr>
                                                                <tr>

                                                                    <td>Others</td>
                                                                    <td><input onkeyup="appsum2()"  id="others" value="'.$rowapp1['others'].'" type="text"></td>
                                                                </tr>
                                                                <tr>

                                                                    <td><b>TOTAL INCOME</b></td>
                                                                    <td><input id="total" value="'.$rowapp1['total'].'" type="text"></td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6">

                                                        <div class="panel-body">
                                                            <p>(b)  Monthly expenses</p>
                                                            <table id="expensetable" class="table table-bordered m-n">
                                                                <thead>
                                                                <tr>
                                                                    <th><b>DESCRIPTION</b></th>
                                                                    <th><b>AMOUNT</b></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td>Food</td>
                                                                    <td><input onkeyup="appsum1()" id="food" value="'.$rowapp1['food'].'" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Medicine</td>
                                                                    <td><input onkeyup="appsum1()" id="medicine" value="'.$rowapp1['medicine'].'" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Clothing</td>
                                                                    <td><input onkeyup="appsum1()" id="clothing" value="'.$rowapp1['clothing'].'" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>School fees</td>
                                                                    <td><input onkeyup="appsum1()" id="school_fees" value="'.$rowapp1['school_fees'].'" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Transport</td>
                                                                    <td><input onkeyup="appsum1()" id="transp" value="'.$rowapp1['transport'].'" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Utilities</td>
                                                                    <td><input onkeyup="appsum1()" id="utility" value="'.$rowapp1['utility'].'" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Entertainment (visitors,alcohol,donations etc)</td>
                                                                    <td><input onkeyup="appsum1()" id="entertainment" value="'.$rowapp1['entertainment'].'" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Others</td>
                                                                    <td><input onkeyup="appsum1()" id="others_2" value="'.$rowapp1['others_2'].'" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><b>TOTAL EXPENSES</b></td>
                                                                    <td><input id="ttl_1" value="'.$rowapp1['ttl_1'].'" type="text"></td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <p>(c)  Disposal amount (Total income-total expenses)shs</p>
                                                    <input type="text" style="border: 0px;width: 300px;" id = "dis_amt" value="'.$rowapp1['dis_amt'].'"  autofocus required = "">
                                                    <b>It is from the disposal amount that you can determine the size of the loan monthly installments which the applicant can pay with ease and therefore use it to determine the size of the loan to be granted depending on the loan period</b>
                                                </div>
                                                <legend>CAPITAL/CONTRIBUTION</legend>
                                                <div data-row-span="1">
                                                    <label>What is the saving behaviour of the applicant as judged from the saving account:</label>
                                                    <input value="'.$rowapp1['behave_savg'].'"  type="text" style="border: 0px;width: 300px;" id = "behave_savg" autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Monthly average saving balance:</label>
                                                    <input value="'.$rowapp1['avg_monthly_saving'].'" type="text" style="border: 0px;width: 300px;" id = "avg_monnthly_saving"  autofocus required = "">
                                                    <b>(Be careful with dormant savings accounts which carry fairy good balances. They could be a trap)</b>
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Value of shares in shillings(shs).:</label>
                                                    <input value="'.(($rowapp1['no_ofshares'])?$rowapp1['no_ofshares']:$row['shareaccount_amount']).'" type="text" style="border: 0px;width: 300px;" id = "no_ofshares"  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Saving Balance:</label>
                                                    <input value="'.(($rowapp1['actual_savg'])?$rowapp1['actual_savg']:$row['savingaccount']).'" type="text" style="border: 0px;width: 300px;" id = "actual_savg"  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Previous Loan Amount:</label>
                                                    <input value="'.$rowapp1['prev_loan'].'"  type="text" style="border: 0px; width: 300px;" id = "prev_loan" autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Out Standing Balance:</label>
                                                    <input value="'.$rowapp1['savg_bal'].'"  type="text" style="border: 0px; width: 300px;" id = "savg_bal" autofocus required = "">
                                                </div>
                                                <legend>CONDITIONS</legend>
                                                <p>Are Conditions favorable for the loan applied for? Such conditions can be:</p>
                                                <div data-row-span="1">
                                                    <label>Climate:</label>
                                                    <input value="'.$rowapp1['cond_avail'].'" type="text" style="border: sss0px;width: 300px;" id = "cond_avail"  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Business Season:</label>
                                                    <input value="'.$rowapp1['bus_season'].'"  type="text" style="border: 0px; width: 300px;" id = "bus_season" value=""  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Time of social obligation such as school fees period:</label>
                                                    <input value="'.$rowapp1['social_obligation'].'" type="text" style="border: 0px; width: 300px;" id = "social_obligation"  autofocus required = "">
                                                </div>
                                                <legend>COLLATERAL</legend>
                                                <div data-row-span="1">
                                                    <label>What collateral are being offered:</label>
                                                    <input value="'.$rowapp1['col_offer'].'" type="text" style="border: 0px;width: 300px;" id = "col_offer"  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>What is the Value according to the Owner?</label>
                                                    <input value="'.$rowapp1['val_own'].'"  type="text" style="border: 0px; width: 300px;" id = "val_own"  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>What is the Loan offer\'s value?</label>
                                                    <input value="'.$rowapp1['ln_off_val'].'" type="text" style="border: 0px; width: 300px;" id = "ln_off_val"  autofocus required = "">
                                                </div>
                                                <legend>Who are the guarantors of the loan?</legend>
                                                <div data-row-span="1">
                                                    <label>Names (1):</label>
                                                    <input value=" '.$data1.'" type="text" style="border: 0px;width: 300px;" name = "guat_name1"  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Names (2):</label>
                                                    <input value=" '.$data8.'" type="text" style="border: 0px; width: 300px;" name = "guat_name2"  autofocus required = "">
                                                </div>
                                            </fieldset>

                                            <div class="modal-footer">
                                                <input id="clientdata" hidden value="'.static::$clientid.'">
                                                <input id="ln_officer" hidden value="'.$_SESSION['user_id'].'">
                                                <input id="loandata" hidden value="'.$rowapp['loan_id'].'">
                                                <input id="chartdata" hidden value="'.$_GET['getloanappraisaldata'].'">
                                                '.(($rowpass['handle_status']=="0")?"<button onclick=\"saveappraisal()\"  class=\"btn btn-primary\">Submit Appraisal</button>":"").'
                                                <button type="reset" class="btn btn-default" onclick="closemodal1()">Cancel</button>
                                                <a onclick="PrintElem(\'loanappraisaldetails\',\'\')"  class="btn btn-inverse" data-target="#loanreport" data-toggle="modal" href="../includes/classes/TCPDF/rpts.php?apprpt=<?php echo $_GET[\'appraisal_id\'];?>"><i class="ti ti-printer" ></i></a>
                                            </div>
                                        </div>
                            ';
                        }
                    }
                }
				
            }
        }else{
            foreach ($db->query("SELECT * FROM post_chart WHERE chartid='".$_GET['getloanappraisaldata']."'") as $row1){$client = CLIENT_DATA::$clientid = $row1['clientid'];}
            foreach ($db->query("SELECT * FROM loan_application1 WHERE chartid='".$_GET['getloanappraisaldata']."'") as $rowapp){
                foreach ($db->query(static::$sql." WHERE clientid='".static::$clientid."'") as $row){
                    if($row['accounttype'] == "1"){
                        foreach ($db->query(static::$sql1." WHERE acc_no='".static::$clientid ."'") as $row1){
                            CLIENT_DATA::$clientid = $rowapp['grt1_id'];
                            self::CLIENTDATAMAIN();
                            $data1 = static::$accountname;
                            $data2 = static::$accountno;
                            $data3 = static::$mobilenumber;
                            $data4 = static::$physicaladress;
                            $data5 = static::$subcounty;
                            CLIENT_DATA::$clientid = $rowapp['grt2_id'];
                            self::CLIENTDATAMAIN();
                            $data8 = static::$accountname;
                            $data9 = static::$accountno;
                            $data10 = static::$mobilenumber;
                            $data11= static::$physicaladress;
                            $data12 = static::$subcounty;

                            echo '
                                        <div class="grid-form">
                                            <fieldset>
                                                <legend>Appraisal form</legend>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Loan officer\'s Name:</label>
                                                        <input value="'.$_SESSION['username'].'" type="text" style="border: 0px;width: 600px;"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <legend>PERSONAL DATA OF APPLICANT</legend>
                                                <div data-row-span="2">
                                                    <div data-field-span="1">
                                                        <label>Name of Applicant:</label>
                                                        <input value="'.$row1['firstname'].' '.$row1['secondname'].' '.$row1['lastname'].'" type="text" style="border: 0px; width: 300px;" id = "ln_lname"  autofocus required = "">
                                                    </div>
                                                    <div data-field-span="1">
                                                        <label>Tel:</label>
                                                        <input value="'.$row1['mobilenumber'].'" type="text" style="border: 0px; width: 300px;" id = "ln_lname"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Account No.:</label>
                                                        <input value="'.$row['accountno'].'" type="text" style="border: 0px;width: 300px;" id = "ln_fname"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="2">
                                                    <div style="height: 30px;width: 25%;" data-field-span="1">
                                                        <label>Location of residence:</label>
                                                        <input value="'.$row1['subcounty'].'" type="text" style="border: 0px; width: 300px;" name = "residence"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Name of spouse:</label>
                                                        <input value="'.$rowapp['kin_name'].'" type="text" style="border: 0px;width: 300px;" name = "ln_spname"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <legend>PROJECT TO BE FINANCED</legend>
                                                <div data-row-span="3">
                                                    <div style="height: 30px;width: 25%;" data-field-span="1">
                                                        <label>Type of project:</label>
                                                        <input value="'.$rowapp['type_of_business'].'" type="text" style="border: 0px;width: 300px;" id = "proj_type"  autofocus required = "">
                                                    </div>
                                                    <div style="height: 30px;width: 25%;" data-field-span="1">
                                                        <label>Age of project:</label>
                                                        <input value=""  type="text" style="border: 0px;width: 300px;" id = "proj_age"  autofocus required = "">
                                                    </div>
                                                    <div style="height: 30px; width: 25%;" data-field-span="1">
                                                        <label>Location:</label>
                                                        <input type="text" style="border: 0px;width: 300px;" id = "proj_loc" value=""  autofocus required = "">
                                                    </div>
                                                </div>
                                                <legend>DATA ON CREDIT APPLICATION</legend>
                                                <div data-row-span="2">
                                                    <div data-field-span="1">
                                                        <label>Amount applied for:</label>
                                                        <input value="'.number_format($rowapp['loan_amount']).'" type="text" style="border: 0px;width: 300px;" name = "ln_fname"  autofocus required = "">
                                                    </div>
                                                    <div data-field-span="1">
                                                        <label>Loan Period:</label>
                                                        <input value="'.$rowapp['duration'].'" type="text" style="border: 0px;width: 300px;" name = "ln_fname"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Purpose of the loan(specify):</label>
                                                        <input value="'.$rowapp['int_purpose'].'" type="text" style="border: 0px;width: 300px;" name = "ln_fname"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Applicant\'s proposed installment(amount he/she thinks can pay every month):</label>
                                                        <input value="'.number_format($rowapp['ability_to_pay']).'"  type="text" style="border: 0px;width: 300px;" name = "proposed_instal" autofocus required = "">
                                                    </div>
                                                </div>
                                                <legend>CHARACTER</legend>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Honesty:</label>
                                                        <input value="" type="text" style="border: 0px;width: 300px;" id = "honesty"  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Load repayment history:</label>
                                                        <input type="text" style="border: 0px;width: 300px;" id = "repay_hist" value=""  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>How long has applicant lived in that area?:</label>
                                                        <input type="text" style="border: 0px;width: 300px;" id = "time_in_area" value=""  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>if new, where did the applicant come from and why?:</label>
                                                        <input type="text" style="border: 0px;width: 300px;" id = "new_applnt_from" value=""  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>is the applicant permanent resident of your area or he is simply renting business and residential premises?:</label>
                                                        <input type="text" style="border: 0px;width: 300px;" id = "residence_status" value=""  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="2">
                                                    <div data-field-span="1">
                                                        <label>Total number of household member:</label>
                                                        <input type="text" style="border: 0px;width: 300px;" id = "no_ofhousehousde" value=""  autofocus required = "">
                                                    </div>
                                                    <div data-field-span="1">
                                                        <label>Number of Children:</label>
                                                        <input type="text" style="border: 0px;width: 300px;" id = "no_children" value=""  autofocus required = "">
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <div data-field-span="1">
                                                        <label>Specify ease of migration to another area:</label>
                                                        <input type="text" style="border: 0px;width: 300px;" id = "ease_migrat" value=""  autofocus required = "">
                                                    </div>
                                                </div>
                                            </fieldset>
                                            <fieldset>
                                                <legend>CAPACITY TO REPAY THE LOAN</legend>
                                                <div class="row">
                                                    <div class="col-xs-6">

                                                        <div class="panel-body">
                                                            <p>(a)   Monthly income from all sources(these could include)</p>
                                                            <table id="incometable" class="table table-bordered m-n">
                                                                <thead>
                                                                <tr>

                                                                    <th><b>DESCRIPTION</b></th>
                                                                    <th><b>AMOUNT</b></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>

                                                                    <td>Sale of products</td>
                                                                    <td><input onkeyup="appsum2()" id="sale_prod" value="" type="text"></td>
                                                                </tr>
                                                                <tr>

                                                                    <td>Sale of animals products e.g milk,ghee,meat etc</td>
                                                                    <td><input onkeyup="appsum2()" id="sale_animal_pro" value="" type="text"></td>
                                                                </tr>
                                                                <tr>

                                                                    <td>Animal Sales</td>
                                                                    <td><input onkeyup="appsum2()" id="ani_sales" value="" type="text"></td>
                                                                </tr>
                                                                <tr>

                                                                    <td>Salary if employed/salary of spouse</td>
                                                                    <td><input onkeyup="appsum2()" id="salary" value="" type="text"></td>
                                                                </tr>
                                                                <tr>

                                                                    <td>Building/ land for renting etc</td>
                                                                    <td><input onkeyup="appsum2()" id="bldg" value="" type="text"></td>
                                                                </tr>
                                                                <tr>

                                                                    <td>Others</td>
                                                                    <td><input onkeyup="appsum2()"  id="others" value="" type="text"></td>
                                                                </tr>
                                                                <tr>

                                                                    <td><b>TOTAL INCOME</b></td>
                                                                    <td><input id="total" value="" type="text"></td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6">

                                                        <div class="panel-body">
                                                            <p>(b)  Monthly expenses</p>
                                                            <table id="expensetable" class="table table-bordered m-n">
                                                                <thead>
                                                                <tr>
                                                                    <th><b>DESCRIPTION</b></th>
                                                                    <th><b>AMOUNT</b></th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <tr>
                                                                    <td>Food</td>
                                                                    <td><input onkeyup="appsum1()" id="food" value="" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Medicine</td>
                                                                    <td><input onkeyup="appsum1()" id="medicine" value="" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Clothing</td>
                                                                    <td><input onkeyup="appsum1()" id="clothing" value="" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>School fees</td>
                                                                    <td><input onkeyup="appsum1()" id="school_fees" value="" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Transport</td>
                                                                    <td><input onkeyup="appsum1()" id="transp" value="" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Utilities</td>
                                                                    <td><input onkeyup="appsum1()" id="utility" value="" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Entertainment (visitors,alcohol,donations etc)</td>
                                                                    <td><input onkeyup="appsum1()" id="entertainment" value="" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Others</td>
                                                                    <td><input onkeyup="appsum1()" id="others_2" value="" type="text"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><b>TOTAL EXPENSES</b></td>
                                                                    <td><input id="ttl_1" value="" type="text"></td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div data-row-span="1">
                                                    <p>(c)  Disposal amount (Total income-total expenses)shs</p>
                                                    <input type="text" style="border: 0px;width: 300px;" id = "dis_amt" value=""  autofocus required = "">
                                                    <b>It is from the disposal amount that you can determine the size of the loan monthly installments which the applicant can pay with ease and therefore use it to determine the size of the loan to be granted depending on the loan period</b>
                                                </div>
                                                <legend>CAPITAL/CONTRIBUTION</legend>
                                                <div data-row-span="1">
                                                    <label>What is the saving behaviour of the applicant as judged from the saving account:</label>
                                                    <input type="text" style="border: 0px;width: 300px;" id = "behave_savg" value=""  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Monthly average saving balance:</label>
                                                    <input type="text" style="border: 0px;width: 300px;" id = "avg_monnthly_saving" value=""  autofocus required = "">
                                                    <b>(Be careful with dormant savings accounts which carry fairy good balances. They could be a trap)</b>
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Value of shares in shillings(shs).:</label>
                                                    <input value="'.$row['shareaccount_amount'].'" type="text" style="border: 0px;width: 300px;" id = "no_ofshares"  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Saving Balance:</label>
                                                    <input value="'.$row['savingaccount'].'" type="text" style="border: 0px;width: 300px;" id = "actual_savg"  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Previous Loan Amount:</label>
                                                    <input value=""  type="text" style="border: 0px; width: 300px;" id = "prev_loan" autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Out Standing Balance:</label>
                                                    <input value=""  type="text" style="border: 0px; width: 300px;" id = "savg_bal" autofocus required = "">
                                                </div>
                                                <legend>CONDITIONS</legend>
                                                <p>Are Conditions favorable for the loan applied for? Such conditions can be:</p>
                                                <div data-row-span="1">
                                                    <label>Climate:</label>
                                                    <input type="text" style="border: 0px;width: 300px;" id = "cond_avail" value=""  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Business Season:</label>
                                                    <input type="text" style="border: 0px; width: 300px;" id = "bus_season" value=""  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Time of social obligation such as school fees period:</label>
                                                    <input type="text" style="border: 0px; width: 300px;" id = "social_obligation" value=""  autofocus required = "">
                                                </div>
                                                <legend>COLLATERAL</legend>
                                                <div data-row-span="1">
                                                    <label>What collateral are being offered:</label>
                                                    <input type="text" style="border: 0px;width: 300px;" id = "col_offer" value=""  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>What is the Value according to the Owner?</label>
                                                    <input type="text" style="border: 0px; width: 300px;" id = "val_own" value=""  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>What is the Loan offer\'s value?</label>
                                                    <input type="text" style="border: 0px; width: 300px;" id = "ln_off_val" value=""  autofocus required = "">
                                                </div>
                                                <legend>Who are the guarantors of the loan?</legend>
                                                <div data-row-span="1">
                                                    <label>Names (1):</label>
                                                    <input value=" '.$data1.'" type="text" style="border: 0px;width: 300px;" name = "guat_name1"  autofocus required = "">
                                                </div>
                                                <div data-row-span="1">
                                                    <label>Names (2):</label>
                                                    <input value=" '.$data8.'" type="text" style="border: 0px; width: 300px;" name = "guat_name2"  autofocus required = "">
                                                </div>
                                            </fieldset>

                                            <div class="modal-footer">
                                                <input id="clientdata" hidden value="'.static::$clientid.'">
                                                <input id="ln_officer" hidden value="'.$_SESSION['user_id'].'">
                                                <input id="loandata" hidden value="'.$rowapp['loan_id'].'">
                                                <input id="chartdata" hidden value="'.$_GET['getloanappraisaldata'].'">
                                                '.(($rowpass['handle_status']=="0")?"<button onclick=\"saveappraisal()\"  class=\"btn btn-primary\">Submit Appraisal</button>":"").'
                                                <button type="reset" class="btn btn-default" onclick="closemodal1()">Cancel</button>
                                                <a onclick="PrintElem(\'loanappraisaldetails\',\'\')"  class="btn btn-inverse" data-target="#loanreport" data-toggle="modal" href="../includes/classes/TCPDF/rpts.php?apprpt=<?php echo $_GET[\'appraisal_id\'];?>"><i class="ti ti-printer" ></i></a>
                                            </div>
                                        </div>
                            ';
                        }
                    }
                    if($row['accounttype'] == "2"){
                        $loop = 1;
						CLIENT_DATA::$clientid = $rowapp['grt1_id'];
						self::CLIENTDATAMAIN();
						$data1 = static::$accountname;
						$data2 = static::$accountno;
						$data3 = static::$mobilenumber;
						$data4 = static::$physicaladress;
						$data5 = static::$subcounty;
						CLIENT_DATA::$clientid = $rowapp['grt2_id'];
						self::CLIENTDATAMAIN();
						$data8 = static::$accountname;
						$data9 = static::$accountno;
						$data10 = static::$mobilenumber;
						$data11= static::$physicaladress;
						$data12 = static::$subcounty;
						$data = "";
                        foreach ($db->query(static::$sql2." WHERE acc_no='".$row["clientid"]."'") as $row2){
                            $data .=", ".$row2['mobilenumber'];
                        }
                        echo '
							<div class="grid-form">
								<fieldset>
									<legend>Appraisal form</legend>
									<div data-row-span="1">
										<div data-field-span="1">
											<label>Loan officer\'s Name:</label>
											<input value="'.$_SESSION['username'].'" type="text" style="border: 0px;width: 600px;"  autofocus required = "">
										</div>
									</div>
									<legend>PERSONAL DATA OF APPLICANT</legend>
									<div data-row-span="2">
										<div data-field-span="1">
											<label>Name of Applicant:</label>
											<input value="'.$row['accountname'].'" type="text" style="border: 0px; width: 300px;" id = "ln_lname"  autofocus required = "">
										</div>
										<div data-field-span="1">
											<label>Tel:</label>
											<input value="'.$data.'" type="text" style="border: 0px; width: 500px;" id = "ln_lname"  autofocus required = "">
										</div>
									</div>
									<div data-row-span="1">
										<div data-field-span="1">
											<label>Account No.:</label>
											<input value="'.$row['accountno'].'" type="text" style="border: 0px;width: 300px;" id = "ln_fname"  autofocus required = "">
										</div>
									</div>
									
									<legend>PROJECT TO BE FINANCED</legend>
									<div data-row-span="3">
										<div style="height: 30px;width: 25%;" data-field-span="1">
											<label>Type of project:</label>
											<input value="'.$rowapp['type_of_business'].'" type="text" style="border: 0px;width: 300px;" id = "proj_type"  autofocus required = "">
										</div>
										<div style="height: 30px;width: 25%;" data-field-span="1">
											<label>Age of project:</label>
											<input value=""  type="text" style="border: 0px;width: 300px;" id = "proj_age"  autofocus required = "">
										</div>
										<div style="height: 30px; width: 25%;" data-field-span="1">
											<label>Location:</label>
											<input type="text" style="border: 0px;width: 300px;" id = "proj_loc" value=""  autofocus required = "">
										</div>
									</div>
									<legend>DATA ON CREDIT APPLICATION</legend>
									<div data-row-span="2">
										<div data-field-span="1">
											<label>Amount applied for:</label>
											<input value="'.number_format($rowapp['loan_amount']).'" type="text" style="border: 0px;width: 300px;" name = "ln_fname"  autofocus required = "">
										</div>
										<div data-field-span="1">
											<label>Loan Period:</label>
											<input value="'.$rowapp['duration'].'" type="text" style="border: 0px;width: 300px;" name = "ln_fname"  autofocus required = "">
										</div>
									</div>
									<div data-row-span="1">
										<div data-field-span="1">
											<label>Purpose of the loan(specify):</label>
											<input value="'.$rowapp['int_purpose'].'" type="text" style="border: 0px;width: 300px;" name = "ln_fname"  autofocus required = "">
										</div>
									</div>
									<div data-row-span="1">
										<div data-field-span="1">
											<label>Applicant\'s proposed installment(amount he/she thinks can pay every month):</label>
											<input value="'.number_format($rowapp['ability_to_pay']).'"  type="text" style="border: 0px;width: 300px;" name = "proposed_instal" autofocus required = "">
										</div>
									</div>
									<legend>CHARACTER</legend>
									<div data-row-span="1">
										<div data-field-span="1">
											<label>Honesty:</label>
											<input value="" type="text" style="border: 0px;width: 300px;" id = "honesty"  autofocus required = "">
										</div>
									</div>
									<div data-row-span="1">
										<div data-field-span="1">
											<label>Load repayment history:</label>
											<input type="text" style="border: 0px;width: 300px;" id = "repay_hist" value=""  autofocus required = "">
										</div>
									</div>
									<div data-row-span="1">
										<div data-field-span="1">
											<label>How long has applicant lived in that area?:</label>
											<input type="text" style="border: 0px;width: 300px;" id = "time_in_area" value=""  autofocus required = "">
										</div>
									</div>
									<div data-row-span="1">
										<div data-field-span="1">
											<label>if new, where did the applicant come from and why?:</label>
											<input type="text" style="border: 0px;width: 300px;" id = "new_applnt_from" value=""  autofocus required = "">
										</div>
									</div>
									<div data-row-span="1">
										<div data-field-span="1">
											<label>is the applicant permanent resident of your area or he is simply renting business and residential premises?:</label>
											<input type="text" style="border: 0px;width: 300px;" id = "residence_status" value=""  autofocus required = "">
										</div>
									</div>
									<div data-row-span="2">
										<div data-field-span="1">
											<label>Total number of household member:</label>
											<input type="text" style="border: 0px;width: 300px;" id = "no_ofhousehousde" value=""  autofocus required = "">
										</div>
										<div data-field-span="1">
											<label>Number of Children:</label>
											<input type="text" style="border: 0px;width: 300px;" id = "no_children" value=""  autofocus required = "">
										</div>
									</div>
									<div data-row-span="1">
										<div data-field-span="1">
											<label>Specify ease of migration to another area:</label>
											<input type="text" style="border: 0px;width: 300px;" id = "ease_migrat" value=""  autofocus required = "">
										</div>
									</div>
								</fieldset>
								<fieldset>
									<legend>CAPACITY TO REPAY THE LOAN</legend>
									<div class="row">
										<div class="col-xs-6">

											<div class="panel-body">
												<p>(a)   Monthly income from all sources(these could include)</p>
												<table id="incometable" class="table table-bordered m-n">
													<thead>
													<tr>

														<th><b>DESCRIPTION</b></th>
														<th><b>AMOUNT</b></th>
													</tr>
													</thead>
													<tbody>
													<tr>

														<td>Sale of products</td>
														<td><input onkeyup="appsum2()" id="sale_prod" value="" type="text"></td>
													</tr>
													<tr>

														<td>Sale of animals products e.g milk,ghee,meat etc</td>
														<td><input onkeyup="appsum2()" id="sale_animal_pro" value="" type="text"></td>
													</tr>
													<tr>

														<td>Animal Sales</td>
														<td><input onkeyup="appsum2()" id="ani_sales" value="" type="text"></td>
													</tr>
													<tr>

														<td>Salary if employed/salary of spouse</td>
														<td><input onkeyup="appsum2()" id="salary" value="" type="text"></td>
													</tr>
													<tr>

														<td>Building/ land for renting etc</td>
														<td><input onkeyup="appsum2()" id="bldg" value="" type="text"></td>
													</tr>
													<tr>

														<td>Others</td>
														<td><input onkeyup="appsum2()"  id="others" value="" type="text"></td>
													</tr>
													<tr>

														<td><b>TOTAL INCOME</b></td>
														<td><input id="total" value="" type="text"></td>
													</tr>
													</tbody>
												</table>
											</div>
										</div>
										<div class="col-xs-6">

											<div class="panel-body">
												<p>(b)  Monthly expenses</p>
												<table id="expensetable" class="table table-bordered m-n">
													<thead>
													<tr>
														<th><b>DESCRIPTION</b></th>
														<th><b>AMOUNT</b></th>
													</tr>
													</thead>
													<tbody>
													<tr>
														<td>Food</td>
														<td><input onkeyup="appsum1()" id="food" value="" type="text"></td>
													</tr>
													<tr>
														<td>Medicine</td>
														<td><input onkeyup="appsum1()" id="medicine" value="" type="text"></td>
													</tr>
													<tr>
														<td>Clothing</td>
														<td><input onkeyup="appsum1()" id="clothing" value="" type="text"></td>
													</tr>
													<tr>
														<td>School fees</td>
														<td><input onkeyup="appsum1()" id="school_fees" value="" type="text"></td>
													</tr>
													<tr>
														<td>Transport</td>
														<td><input onkeyup="appsum1()" id="transp" value="" type="text"></td>
													</tr>
													<tr>
														<td>Utilities</td>
														<td><input onkeyup="appsum1()" id="utility" value="" type="text"></td>
													</tr>
													<tr>
														<td>Entertainment (visitors,alcohol,donations etc)</td>
														<td><input onkeyup="appsum1()" id="entertainment" value="" type="text"></td>
													</tr>
													<tr>
														<td>Others</td>
														<td><input onkeyup="appsum1()" id="others_2" value="" type="text"></td>
													</tr>
													<tr>
														<td><b>TOTAL EXPENSES</b></td>
														<td><input id="ttl_1" value="" type="text"></td>
													</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div data-row-span="1">
										<p>(c)  Disposal amount (Total income-total expenses)shs</p>
										<input type="text" style="border: 0px;width: 300px;" id = "dis_amt" value=""  autofocus required = "">
										<b>It is from the disposal amount that you can determine the size of the loan monthly installments which the applicant can pay with ease and therefore use it to determine the size of the loan to be granted depending on the loan period</b>
									</div>
									<legend>CAPITAL/CONTRIBUTION</legend>
									<div data-row-span="1">
										<label>What is the saving behaviour of the applicant as judged from the saving account:</label>
										<input type="text" style="border: 0px;width: 300px;" id = "behave_savg" value=""  autofocus required = "">
									</div>
									<div data-row-span="1">
										<label>Monthly average saving balance:</label>
										<input type="text" style="border: 0px;width: 300px;" id = "avg_monnthly_saving" value=""  autofocus required = "">
										<b>(Be careful with dormant savings accounts which carry fairy good balances. They could be a trap)</b>
									</div>
									<div data-row-span="1">
										<label>Value of shares in shillings(shs).:</label>
										<input value="'.$row['shareaccount_amount'].'" type="text" style="border: 0px;width: 300px;" id = "no_ofshares"  autofocus required = "">
									</div>
									<div data-row-span="1">
										<label>Saving Balance:</label>
										<input value="'.$row['savingaccount'].'" type="text" style="border: 0px;width: 300px;" id = "actual_savg"  autofocus required = "">
									</div>
									<div data-row-span="1">
										<label>Previous Loan Amount:</label>
										<input value=""  type="text" style="border: 0px; width: 300px;" id = "prev_loan" autofocus required = "">
									</div>
									<div data-row-span="1">
										<label>Out Standing Balance:</label>
										<input value=""  type="text" style="border: 0px; width: 300px;" id = "savg_bal" autofocus required = "">
									</div>
									<legend>CONDITIONS</legend>
									<p>Are Conditions favorable for the loan applied for? Such conditions can be:</p>
									<div data-row-span="1">
										<label>Climate:</label>
										<input type="text" style="border: 0px;width: 300px;" id = "cond_avail" value=""  autofocus required = "">
									</div>
									<div data-row-span="1">
										<label>Business Season:</label>
										<input type="text" style="border: 0px; width: 300px;" id = "bus_season" value=""  autofocus required = "">
									</div>
									<div data-row-span="1">
										<label>Time of social obligation such as school fees period:</label>
										<input type="text" style="border: 0px; width: 300px;" id = "social_obligation" value=""  autofocus required = "">
									</div>
									<legend>COLLATERAL</legend>
									<div data-row-span="1">
										<label>What collateral are being offered:</label>
										<input type="text" style="border: 0px;width: 300px;" id = "col_offer" value=""  autofocus required = "">
									</div>
									<div data-row-span="1">
										<label>What is the Value according to the Owner?</label>
										<input type="text" style="border: 0px; width: 300px;" id = "val_own" value=""  autofocus required = "">
									</div>
									<div data-row-span="1">
										<label>What is the Loan offer\'s value?</label>
										<input type="text" style="border: 0px; width: 300px;" id = "ln_off_val" value=""  autofocus required = "">
									</div>
									<legend>Who are the guarantors of the loan?</legend>
									<div data-row-span="1">
										<label>Names (1):</label>
										<input value=" '.$data1.'" type="text" style="border: 0px;width: 300px;" name = "guat_name1"  autofocus required = "">
									</div>
									<div data-row-span="1">
										<label>Names (2):</label>
										<input value=" '.$data8.'" type="text" style="border: 0px; width: 300px;" name = "guat_name2"  autofocus required = "">
									</div>
								</fieldset>

								<div class="modal-footer">
									<input id="clientdata" hidden value="'.static::$clientid.'">
									<input id="ln_officer" hidden value="'.$_SESSION['user_id'].'">
									<input id="loandata" hidden value="'.$rowapp['loan_id'].'">
									<input id="chartdata" hidden value="'.$_GET['getloanappraisaldata'].'">
									'.(($rowpass['handle_status']=="0")?"<button onclick=\"saveappraisal()\"  class=\"btn btn-primary\">Submit Appraisal</button>":"").'
									<button type="reset" class="btn btn-default" onclick="closemodal1()">Cancel</button>
									<a onclick="return validateForm()"  class="btn btn-inverse" data-target="#loanreport" data-toggle="modal" href="../includes/classes/TCPDF/rpts.php?apprpt=<?php echo $_GET[\'appraisal_id\'];?>"><i class="ti ti-printer" ></i></a>
								</div>
							</div>
                            ';

                    }
					if($row['accounttype'] == "3"){
                        $loop = 1;
						CLIENT_DATA::$clientid = $rowapp['grt1_id'];
						self::CLIENTDATAMAIN();
						$data1 = static::$accountname;
						$data2 = static::$accountno;
						$data3 = static::$mobilenumber;
						$data4 = static::$physicaladress;
						$data5 = static::$subcounty;
						CLIENT_DATA::$clientid = $rowapp['grt2_id'];
						self::CLIENTDATAMAIN();
						$data8 = static::$accountname;
						$data9 = static::$accountno;
						$data10 = static::$mobilenumber;
						$data11= static::$physicaladress;
						$data12 = static::$subcounty;
						
                        foreach ($db->query(static::$sql2." WHERE acc_no='".$row["clientid"]."'") as $row2){}
                        echo '
							<div class="grid-form">
								<fieldset>
									<legend>Appraisal form</legend>
									<div data-row-span="1">
										<div data-field-span="1">
											<label>Loan officer\'s Name:</label>
											<input value="'.$_SESSION['username'].'" type="text" style="border: 0px;width: 600px;"  autofocus required = "">
										</div>
									</div>
									<legend>PERSONAL DATA OF APPLICANT</legend>
									<div data-row-span="2">
										<div data-field-span="1">
											<label>Name of Applicant:</label>
											<input value="'.$row['accountname'].'" type="text" style="border: 0px; width: 300px;" id = "ln_lname"  autofocus required = "">
										</div>
										<div data-field-span="1">
											<label>Tel:</label>
											<input value="'.$row2['officetel'].'" type="text" style="border: 0px; width: 500px;" id = "ln_lname"  autofocus required = "">
										</div>
									</div>
									<div data-row-span="1">
										<div data-field-span="1">
											<label>Account No.:</label>
											<input value="'.$row['accountno'].'" type="text" style="border: 0px;width: 300px;" id = "ln_fname"  autofocus required = "">
										</div>
									</div>
									
									<legend>PROJECT TO BE FINANCED</legend>
									<div data-row-span="3">
										<div style="height: 30px;width: 25%;" data-field-span="1">
											<label>Type of project:</label>
											<input value="'.$rowapp['type_of_business'].'" type="text" style="border: 0px;width: 300px;" id = "proj_type"  autofocus required = "">
										</div>
										<div style="height: 30px;width: 25%;" data-field-span="1">
											<label>Age of project:</label>
											<input value=""  type="text" style="border: 0px;width: 300px;" id = "proj_age"  autofocus required = "">
										</div>
										<div style="height: 30px; width: 25%;" data-field-span="1">
											<label>Location:</label>
											<input type="text" style="border: 0px;width: 300px;" id = "proj_loc" value=""  autofocus required = "">
										</div>
									</div>
									<legend>DATA ON CREDIT APPLICATION</legend>
									<div data-row-span="2">
										<div data-field-span="1">
											<label>Amount applied for:</label>
											<input value="'.number_format($rowapp['loan_amount']).'" type="text" style="border: 0px;width: 300px;" name = "ln_fname"  autofocus required = "">
										</div>
										<div data-field-span="1">
											<label>Loan Period:</label>
											<input value="'.$rowapp['duration'].'" type="text" style="border: 0px;width: 300px;" name = "ln_fname"  autofocus required = "">
										</div>
									</div>
									<div data-row-span="1">
										<div data-field-span="1">
											<label>Purpose of the loan(specify):</label>
											<input value="'.$rowapp['int_purpose'].'" type="text" style="border: 0px;width: 300px;" name = "ln_fname"  autofocus required = "">
										</div>
									</div>
									<div data-row-span="1">
										<div data-field-span="1">
											<label>Applicant\'s proposed installment(amount he/she thinks can pay every month):</label>
											<input value="'.number_format($rowapp['ability_to_pay']).'"  type="text" style="border: 0px;width: 300px;" name = "proposed_instal" autofocus required = "">
										</div>
									</div>
									<legend>CHARACTER</legend>
									<div data-row-span="1">
										<div data-field-span="1">
											<label>Honesty:</label>
											<input value="" type="text" style="border: 0px;width: 300px;" id = "honesty"  autofocus required = "">
										</div>
									</div>
									<div data-row-span="1">
										<div data-field-span="1">
											<label>Load repayment history:</label>
											<input type="text" style="border: 0px;width: 300px;" id = "repay_hist" value=""  autofocus required = "">
										</div>
									</div>
									<div data-row-span="1">
										<div data-field-span="1">
											<label>How long has applicant lived in that area?:</label>
											<input type="text" style="border: 0px;width: 300px;" id = "time_in_area" value=""  autofocus required = "">
										</div>
									</div>
									<div data-row-span="1">
										<div data-field-span="1">
											<label>if new, where did the applicant come from and why?:</label>
											<input type="text" style="border: 0px;width: 300px;" id = "new_applnt_from" value=""  autofocus required = "">
										</div>
									</div>
									<div data-row-span="1">
										<div data-field-span="1">
											<label>is the applicant permanent resident of your area or he is simply renting business and residential premises?:</label>
											<input type="text" style="border: 0px;width: 300px;" id = "residence_status" value=""  autofocus required = "">
										</div>
									</div>
									<div data-row-span="2">
										<div data-field-span="1">
											<label>Total number of household member:</label>
											<input type="text" style="border: 0px;width: 300px;" id = "no_ofhousehousde" value=""  autofocus required = "">
										</div>
										<div data-field-span="1">
											<label>Number of Children:</label>
											<input type="text" style="border: 0px;width: 300px;" id = "no_children" value=""  autofocus required = "">
										</div>
									</div>
									<div data-row-span="1">
										<div data-field-span="1">
											<label>Specify ease of migration to another area:</label>
											<input type="text" style="border: 0px;width: 300px;" id = "ease_migrat" value=""  autofocus required = "">
										</div>
									</div>
								</fieldset>
								<fieldset>
									<legend>CAPACITY TO REPAY THE LOAN</legend>
									<div class="row">
										<div class="col-xs-6">

											<div class="panel-body">
												<p>(a)   Monthly income from all sources(these could include)</p>
												<table id="incometable" class="table table-bordered m-n">
													<thead>
													<tr>

														<th><b>DESCRIPTION</b></th>
														<th><b>AMOUNT</b></th>
													</tr>
													</thead>
													<tbody>
													<tr>

														<td>Sale of products</td>
														<td><input onkeyup="appsum2()" id="sale_prod" value="" type="text"></td>
													</tr>
													<tr>

														<td>Sale of animals products e.g milk,ghee,meat etc</td>
														<td><input onkeyup="appsum2()" id="sale_animal_pro" value="" type="text"></td>
													</tr>
													<tr>

														<td>Animal Sales</td>
														<td><input onkeyup="appsum2()" id="ani_sales" value="" type="text"></td>
													</tr>
													<tr>

														<td>Salary if employed/salary of spouse</td>
														<td><input onkeyup="appsum2()" id="salary" value="" type="text"></td>
													</tr>
													<tr>

														<td>Building/ land for renting etc</td>
														<td><input onkeyup="appsum2()" id="bldg" value="" type="text"></td>
													</tr>
													<tr>

														<td>Others</td>
														<td><input onkeyup="appsum2()"  id="others" value="" type="text"></td>
													</tr>
													<tr>

														<td><b>TOTAL INCOME</b></td>
														<td><input id="total" value="" type="text"></td>
													</tr>
													</tbody>
												</table>
											</div>
										</div>
										<div class="col-xs-6">

											<div class="panel-body">
												<p>(b)  Monthly expenses</p>
												<table id="expensetable" class="table table-bordered m-n">
													<thead>
													<tr>
														<th><b>DESCRIPTION</b></th>
														<th><b>AMOUNT</b></th>
													</tr>
													</thead>
													<tbody>
													<tr>
														<td>Food</td>
														<td><input onkeyup="appsum1()" id="food" value="" type="text"></td>
													</tr>
													<tr>
														<td>Medicine</td>
														<td><input onkeyup="appsum1()" id="medicine" value="" type="text"></td>
													</tr>
													<tr>
														<td>Clothing</td>
														<td><input onkeyup="appsum1()" id="clothing" value="" type="text"></td>
													</tr>
													<tr>
														<td>School fees</td>
														<td><input onkeyup="appsum1()" id="school_fees" value="" type="text"></td>
													</tr>
													<tr>
														<td>Transport</td>
														<td><input onkeyup="appsum1()" id="transp" value="" type="text"></td>
													</tr>
													<tr>
														<td>Utilities</td>
														<td><input onkeyup="appsum1()" id="utility" value="" type="text"></td>
													</tr>
													<tr>
														<td>Entertainment (visitors,alcohol,donations etc)</td>
														<td><input onkeyup="appsum1()" id="entertainment" value="" type="text"></td>
													</tr>
													<tr>
														<td>Others</td>
														<td><input onkeyup="appsum1()" id="others_2" value="" type="text"></td>
													</tr>
													<tr>
														<td><b>TOTAL EXPENSES</b></td>
														<td><input id="ttl_1" value="" type="text"></td>
													</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div data-row-span="1">
										<p>(c)  Disposal amount (Total income-total expenses)shs</p>
										<input type="text" style="border: 0px;width: 300px;" id = "dis_amt" value=""  autofocus required = "">
										<b>It is from the disposal amount that you can determine the size of the loan monthly installments which the applicant can pay with ease and therefore use it to determine the size of the loan to be granted depending on the loan period</b>
									</div>
									<legend>CAPITAL/CONTRIBUTION</legend>
									<div data-row-span="1">
										<label>What is the saving behaviour of the applicant as judged from the saving account:</label>
										<input type="text" style="border: 0px;width: 300px;" id = "behave_savg" value=""  autofocus required = "">
									</div>
									<div data-row-span="1">
										<label>Monthly average saving balance:</label>
										<input type="text" style="border: 0px;width: 300px;" id = "avg_monnthly_saving" value=""  autofocus required = "">
										<b>(Be careful with dormant savings accounts which carry fairy good balances. They could be a trap)</b>
									</div>
									<div data-row-span="1">
										<label>Value of shares in shillings(shs).:</label>
										<input value="'.$row['shareaccount_amount'].'" type="text" style="border: 0px;width: 300px;" id = "no_ofshares"  autofocus required = "">
									</div>
									<div data-row-span="1">
										<label>Saving Balance:</label>
										<input value="'.$row['savingaccount'].'" type="text" style="border: 0px;width: 300px;" id = "actual_savg"  autofocus required = "">
									</div>
									<div data-row-span="1">
										<label>Previous Loan Amount:</label>
										<input value=""  type="text" style="border: 0px; width: 300px;" id = "prev_loan" autofocus required = "">
									</div>
									<div data-row-span="1">
										<label>Out Standing Balance:</label>
										<input value=""  type="text" style="border: 0px; width: 300px;" id = "savg_bal" autofocus required = "">
									</div>
									<legend>CONDITIONS</legend>
									<p>Are Conditions favorable for the loan applied for? Such conditions can be:</p>
									<div data-row-span="1">
										<label>Climate:</label>
										<input type="text" style="border: 0px;width: 300px;" id = "cond_avail" value=""  autofocus required = "">
									</div>
									<div data-row-span="1">
										<label>Business Season:</label>
										<input type="text" style="border: 0px; width: 300px;" id = "bus_season" value=""  autofocus required = "">
									</div>
									<div data-row-span="1">
										<label>Time of social obligation such as school fees period:</label>
										<input type="text" style="border: 0px; width: 300px;" id = "social_obligation" value=""  autofocus required = "">
									</div>
									<legend>COLLATERAL</legend>
									<div data-row-span="1">
										<label>What collateral are being offered:</label>
										<input type="text" style="border: 0px;width: 300px;" id = "col_offer" value=""  autofocus required = "">
									</div>
									<div data-row-span="1">
										<label>What is the Value according to the Owner?</label>
										<input type="text" style="border: 0px; width: 300px;" id = "val_own" value=""  autofocus required = "">
									</div>
									<div data-row-span="1">
										<label>What is the Loan offer\'s value?</label>
										<input type="text" style="border: 0px; width: 300px;" id = "ln_off_val" value=""  autofocus required = "">
									</div>
									<legend>Who are the guarantors of the loan?</legend>
									<div data-row-span="1">
										<label>Names (1):</label>
										<input value=" '.$data1.'" type="text" style="border: 0px;width: 300px;" name = "guat_name1"  autofocus required = "">
									</div>
									<div data-row-span="1">
										<label>Names (2):</label>
										<input value=" '.$data8.'" type="text" style="border: 0px; width: 300px;" name = "guat_name2"  autofocus required = "">
									</div>
								</fieldset>

								<div class="modal-footer">
									<input id="clientdata" hidden value="'.static::$clientid.'">
									<input id="ln_officer" hidden value="'.$_SESSION['user_id'].'">
									<input id="loandata" hidden value="'.$rowapp['loan_id'].'">
									<input id="chartdata" hidden value="'.$_GET['getloanappraisaldata'].'">
									'.(($rowpass['handle_status']=="0")?"<button onclick=\"saveappraisal()\"  class=\"btn btn-primary\">Submit Appraisal</button>":"").'
									<button type="reset" class="btn btn-default" onclick="closemodal1()">Cancel</button>
									<a onclick="return validateForm()"  class="btn btn-inverse" data-target="#loanreport" data-toggle="modal" href="../includes/classes/TCPDF/rpts.php?apprpt=<?php echo $_GET[\'appraisal_id\'];?>"><i class="ti ti-printer" ></i></a>
								</div>
							</div>
                            ';

                    }
                }
            }
        }

    }

}
class BUSINESS_ACCOUNTDATA extends database_crud {
    protected $table="businessaccount";
    protected $pk="busid";
//SELECT `busid`, `natureofbusines`, `certificateofreg`, `registrationdate`, `officetel`, `email`,
// `businesslocation`, `tin`, `physicaladdress`, `subcounty`, `district`, `photofile`, `certificatefile`,
// `name1`, `name2`, `name3`, `certificate1`, `certificate2`, `certificate3` FROM `businessaccount` WHERE 1
}
class INDIVIDUAL_ACCOUNTDATA extends database_crud {
    protected $table="individualaccount";
    protected $pk="indid";
//SELECT `indid`, `firstname`, `secondname`, `lastname`, `gender`,
// `nationalidno`, `nationality`, `dateofbirth`, `maritalstatus`,
// `occupation`, `employer`, `mobilenumber`, `physicaladress`, `subcounty`, `district`,
// `photo`, `kinname`, `relationship`, `contactdetails`, `address`, `securityqtn`, `answer`
// FROM `individualaccount` WHERE 1
}
class GROUP_ACCOUNTDATA extends database_crud {
    protected $table="groupaccount";
    protected $pk="groupid";
    //SELECT `groupid`, `firstname`, `middlename`, `lastname`, `passportno`, `dateofbirth`,
    // `gender`, `nationality`, `mobilenumber`, `maritalstatus`, `occupation`, `employer`,
    // `physicaladdress`, `subcounty`, `address`, `nextofkin`, `contactdetail`, `photofile`
    // FROM `groupaccount` WHERE 1
}
class GROUPDATA_ACCOUNT extends database_crud {
    protected $table="groups";
    protected $pk="groupid";
    // SELECT `groupid`, `group_name`, `address`, `groups`, `added` FROM `groups` WHERE 1
    public static function save_group(){
      $group = new GROUPDATA_ACCOUNT();
      $data = explode("?::?",$_GET['save_groupdata']);

      $group->group_name =  $data[0];
      $group->address    =  $data[1];
      $group->groups     =  $data[2];
      $group->create();
      // die($_GET['save_groupdata']);

      echo '
          <b>Selected Client Area</b><br>
          <div id="amtclientloopid"></div><br>
          <div hidden id="clientloopid"></div>
          <div id="clientspace" class="alert alert alert-dismissable alert-danger"></div>
          <label class="labelcolor">Group Name</label>
          <input id="groupname" class="form-control"><br>
          <label class="labelcolor">Address</label>
          <input id="address" class="form-control"><br>
          <label class="labelcolor">Client Name</label>
          <div id="clientdatatrail">
              <select onchange="addclientstotrail2()" id="basic" class="selectpicker show-tick form-control" data-live-search="true">
                  <option value="">select member...</option>
                  ';CLIENT_DATA::CLIENT_OPTIONSEARCH();  echo '
              </select><br><br><br>
          </div>
          <center>
              <button class="btn-primary btn" type="" onclick="save_group()" >Submit Record</button>

          </center> <br><br>
      ';
    }
}