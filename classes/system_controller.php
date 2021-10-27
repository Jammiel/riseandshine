<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'controller/Loans.php';
require_once 'controller/clients.php';
require_once 'controller/financials.php';
require_once 'controller/reports.php';
require_once 'controller/transactions.php';
require_once 'controller/utils.php';

/**
 * Description of system_controller
 *
 * @author jammieluvie
 **/

class MONTHLYCHARGE extends database_crud{
    protected $table = "monthlycharges";
    protected $pk = "mchargeid";
	//SELECT `mchargeid`, `clientid`, `dedmonth`, `amount`, `balance`, `mdate`, `mtime` FROM `monthlycharges` WHERE 1
    public static function monthlycharges(){   
        
        $db = new DB(); NOW_DATETIME::NOW(); GENERAL_SETTINGS::GEN();
        $month = new MONTHLYCHARGE(); $merge = new MERGERWD();
        foreach ($db->query("SELECT * FROM clients") as $row){
            if($row['monthcharges'] == NOW_DATETIME::$yearmonth || GENERAL_SETTINGS::$monthlycharges=="0"){

            }else{
                if($row['savingaccount'] > GENERAL_SETTINGS::$monthlycharges){
                    $db->query("UPDATE clients SET monthcharges='".NOW_DATETIME::$yearmonth."', savingaccount=savingaccount-'".GENERAL_SETTINGS::$monthlycharges."' WHERE clientid='".$row['clientid']."'");
                    $month->clientid = $row['clientid'];
                    $month->dedmonth = NOW_DATETIME::$yearmonth;
                    $month->amount = GENERAL_SETTINGS::$monthlycharges;
                    $month->balance = ($row['savingaccount'] - GENERAL_SETTINGS::$monthlycharges);
                    $month->mdate = NOW_DATETIME::$Date;
                    $month->mtime = NOW_DATETIME::$Time;
                    $month->create();

                    $merge->transactiontype = "9";
                    $merge->transactionid = $month->pk;
                    $merge->insertiondate = NOW_DATETIME::$Date_Time;
                    $merge->clientid = $row['clientid'];
                    $merge->create();
                }
            }
        }
    }
}
class LOANANALYSIS extends database_crud{
	protected $table = "loananalysis";
	protected $pk = "anaid";
	//SELECT `anaid`, `year`, `months`, `loanbals` FROM `loananalysis` WHERE 1
}
class FIXEDDEPOSITACCOUNT extends database_crud{
	protected $table = "fixeddepositaccount";
	protected $pk = "fixid";
	// SELECT `fixid`, `clientid`, `period`, `startdate`, `enddate`, `interestamt`, `user_handle` FROM `fixeddepositaccount` WHERE 1
}
class DEPRECIATION extends database_crud{
    protected $table = "depreciation";
    protected $pk = "decptid";
    //SELECT `decptid`, `assetcode`, `rate`, `typecode` FROM `depreciation` WHERE 1

    public static function SET_DEPRECIATION(){
        $depreciation = new DEPRECIATION(); $db = new DB();
        $data = explode("?::?",$_GET['setdepreciation']);
        $depreciation->assetcode = $data[0];
        $depreciation->rate = $data[1];
        $depreciation->typecode = $data[2];
        foreach ($db->query("SELECT * FROM depreciation WHERE assetcode='".$data[0]."'") as $row){}
        if($row['assetcode']){
            $depreciation->decptid = $row['decptid'];
            $depreciation->save();
        }else{
            $depreciation->create();
        }


        echo '
            <div class="col-md-6">
                <label class="labelcolor">Asset Account</label>
                <select id="assetaccount" class="selectpicker show-tick form-control" data-live-search="true">
                    <option value="">select Asset Account</option>
                    '; ASSETSMANAGEMENT::GET_ASSETACCOUTSDEPECITION(); echo'
                </select>
            </div>
            <div class="col-md-6">
                <label class="labelcolor">Depreciation Percentages</label>
                <input id="assetaccountpercentage" type="number" class="form-control" placeholder="Enter Percentage (00)">
                <label class="labelcolor">Depreciation Type</label>
                <select onchange="setdeptype()" id="depreciationtype" class="form-control">
                    <option value="0">Reducing Balance Method</option>
                    <option value="1">Straight line Method</option>
                </select>
            </div>
        ';
        echo '|<><>|';
        echo '
            <label class="labelcolor">Modify Depreciation Percentages</label>
            <select id="modeloantype" class="form-control">
                <option value="">select Depreciation Percentages to Modify</option>
                '; DEPRECIATION::GET_DEPRECIATION(); echo'
            </select>
        ';
    }

    public static function GET_DEPRECIATION(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM depreciation") as $row){
            SECTIONS::$search_code = $row['assetcode'];
            SECTIONS::SEARCH_CODE();
            echo '<option value="' . $row['decptid'] . '">' . SECTIONS::$resultname . (($row['typecode']=="0")?' at '.$row['rate']." %":number_format($row['rate'])) . '</option>';
        }
    }
}
class LOANSTATBALS extends database_crud{
	protected $table = "loanstartbalancespayments";
	protected $pk = "statid";
	// SELECT `statid`, `clientid`, `amount`, `balance`, `handle`, `paydate` FROM `loanstartbalancespayments` WHERE 1
}
class BUDGET_ITEM extends database_crud{
    protected $table="budget_details";
    protected $pk="item_id";
    
    public static $cat_id;	public static $cat_name;    public static $subcat_id;	public static $subcat_name;
    public static $itemname;	public static $qty;	    public static $uom;		public static $unitcost;
    public static $totalcost;
	
	// SELECT `item_id`, `budget_id`, `item_name`, `accountcode`, `quatity`, `uom`, `unitcost`, `totalcost`, 
	// `adjustments`, `comments` FROM `budget_details` WHERE 1

    public static function EDIT_BUDGET(){
		$item = new BUDGET_ITEM();	session_start();
		if(isset($_POST['sub_budgetedit'])){
			$item->category = $_POST['catid'];	    $item->subcategory = $_POST['subcatid'];
			$item->quatity = $_POST['qty'];	    $item->uom = $_POST['uom'];
			$item->unitcost = $_POST['unit'];	    $item->totalcost = $_POST['total'];
			$item->item_id = $_POST['itemid'];	    $item->item_name = $_POST['itemname'];
			$item->save();
			unset($_SESSION['month']);  unset($_SESSION['year']);
		}
    }
    
    public static function GENERATE_BUDGET(){
	$item = new BUDGET_ITEM();	$db = new DB();
	$data = explode("|<>|",$_GET['budgetitem']);
	BUDGET::ADD_BUDGET($data[6],$data[7]);
	$category = explode(":??:", $data[1]);
	$quantity = explode(":??:", $data[2]);
	$uom = explode(":??:", $data[3]);
	$unitcost = explode(":??:", $data[4]);
	$totals = explode(":??:", $data[5]);
	$itemname = explode(":??:", $data[0]);
	// die($data[1]);
	for($i=1;$i<=count($category);$i++){
	    if($category[$i]!=""){
			foreach($db->query("SELECT * FROM budget_details WHERE accountcode='".$category[$i]."' AND budget_id='".BUDGET::$budget_id."'") as $row){}
			if($row['item_id']){
				
			}else{
				$item->accountcode = $category[$i];
				$item->type = "1";
				$item->quatity = $quantity[$i];			$item->uom = $uom[$i];
				$item->unitcost = $unitcost[$i];		$item->totalcost = $totals[$i];
				$item->budget_id = BUDGET::$budget_id;  $item->item_name = $itemname[$i];
				$item->create(); 
			}
			 
	    }
	}
	echo '
	    <table id="exptab" class="table table-striped table-bordered"style="width: 100%; cellspacing: 0;">
			<tr>
				<th width="15%">ITEM</th>
				<th width="15%">ITEM NAME</th>
				<th width="10%">QUANTITY</th>
				<th width="10%">UOM</th>
				<th width="15%">UNIT COST</th>
				<th width="15%">TOTAL COST</th>
				<th width="5%"><center><button disabled class="btn btn-danger btn-social btn-sm"><i class="ti ti-close"></i></button></center></th>
			</tr>
			<tr id="row1">
				<td>
					<select id="catname"  class="form-control" onclick="returnsubcat1(this.value)">
						<option value="">select</option>
						'; BUDGET::GET_EXPESEACCOUTS(); echo'
					</select>
				</td>
				<td><input class="form-control" type="text" id="item"></td>
				<td><input onkeyup="gettotals1()" class="form-control" type="text" id="qty"></td>
				<td><input class="form-control" type="text" id="uom"></td>
				<td><input onkeyup="gettotals1()" class="form-control" type="text" id="unit"></td>
				<td><input class="form-control" type="text" id="total"></td>
				<td><center><button disabled class="btn btn-danger btn-social btn-sm"><i class="ti ti-close"></i></button></center></td>
			</tr>
		</table>
	';
	echo '|<><>|';
	echo '
		<select onchange="getbudgetchange()" id="budgetsearch" class="selectpicker show-tick form-control" data-live-search="true">
			<option value="">select Budget</option>
			'; BUDGET::GET_BUDGETOPTION(); echo'
		</select>
		';
	echo '|<><>|';
	echo '
		<select onchange="getbudgetchange1()" id="budgetsearch1" class="selectpicker show-tick form-control" data-live-search="true">
			<option value="">select Budget</option>
			'; BUDGET::GET_BUDGETOPTION(); echo'
		</select>
		';
    }
    
    public static function GENERATE_BUDGET1(){
	$item = new BUDGET_ITEM();	$db = new DB();
	$data = explode("|<>|",$_GET['budgetitem1']);
	BUDGET::ADD_BUDGET($data[3],$data[4]);
	$category = explode(":??:", $data[1]);
	$totals = explode(":??:", $data[2]);
	$itemname = explode(":??:", $data[0]);
	// die($data[1]);
	for($i=1;$i<=count($category);$i++){
	    if($category[$i]!=""){
			foreach($db->query("SELECT * FROM budget_details WHERE accountcode='".$category[$i]."' AND budget_id='".BUDGET::$budget_id."'") as $row){}
			if($row['item_id']){
				
			}else{
				$item->accountcode = $category[$i];
				$item->type = "2";
				$item->totalcost = $totals[$i];
				$item->budget_id = BUDGET::$budget_id;  
				$item->item_name = $itemname[$i];
				$item->create(); 
			}
			 
	    }
	}
	echo '
	    <table id="exptab1" class="table table-striped table-bordered"style="width: 100%; cellspacing: 0;">
			<tr>
				<th width="15%">ITEM</th>
				<th width="15%">ITEM NAME</th>
				<th width="15%">TOTAL COST</th>
				<th width="5%"><center><button disabled class="btn btn-danger btn-social btn-sm"><i class="ti ti-close"></i></button></center></th>
			</tr>
			<tr id="row1">
				<td>
					<select id="inccatname"  class="form-control" onclick="">
						<option value="">select</option>
						'; BUDGET::GET_EXPESEACCOUTS(); echo'
					</select>
				</td>
				<td><input class="form-control" type="text" id="incitem"></td>
				<td><input class="form-control" type="text" id="inctotal"></td>
				<td><center><button disabled class="btn btn-danger btn-social btn-sm"><i class="ti ti-close"></i></button></center></td>
			</tr>
		</table>
	';
	echo '|<><>|';
	echo '
		<select onchange="getbudgetchange()" id="budgetsearch" class="selectpicker show-tick form-control" data-live-search="true">
			<option value="">select Budget</option>
			'; BUDGET::GET_BUDGETOPTION(); echo'
		</select>
		';
	echo '|<><>|';
	echo '
		<select onchange="getbudgetchange1()" id="budgetsearch1" class="selectpicker show-tick form-control" data-live-search="true">
			<option value="">select Budget</option>
			'; BUDGET::GET_BUDGETOPTION(); echo'
		</select>
		';
    }
    
    public static function TRIGGER_BUDGETEDIT(){
	session_start(); 
	if(isset($_POST['editbudget'])){
	    $_SESSION['month'] = $_POST['monthdropdown'];
	    $_SESSION['year'] = $_POST['yeardropdown'];
	    redirect_to('expense.php?content=3');
	}
    }

    public static function EDIT_BUDGET_LIST(){
	$db = new DB();	session_start(); 
	foreach ($db->query("SELECT * FROM budget WHERE month='".$_SESSION['month']."' AND year='".$_SESSION['year']."'") as $rowx){
	    foreach ($db->query("SELECT * FROM budget_cat c, budget_details d,budget_subcat s WHERE s.subcat_id=d.subcategory AND c.cat_id=d.category AND budget_id='".$rowx['budget_id']."'") as $row){
		echo '
		    <tr>
			<td>'.$row['cat_name'].'</td>
			<td>'.(($row['subcat_name']=='NIL')?'':$row['subcat_name']).'</td>
			<td>'.$row['item_name'].'</td>
			<td>'.number_format($row['quatity']).'&nbsp;&nbsp;&nbsp;'.$row['uom'].'</td>
			<td>'.number_format($row['unitcost']).'</td>
			<td>'.number_format($row['totalcost']).'</td>
			<td><a href="classess/page_contents/ajax_res.php?edit_budget='.$row['item_id'].'" data-target="#edit_budget" data-toggle="modal" class="btn btn-xs btn-primary">EDIT</a></td>
		    </tr>
		';
	    }
	}
    }
    
    public static function DATA_BUDGET(){
	$db = new DB();
	    foreach ($db->query("SELECT * FROM budget_cat c, budget_details d,budget_subcat s WHERE s.subcat_id=d.subcategory AND c.cat_id=d.category AND item_id='".$_GET['edit_budget']."'") as $row){
		static::$cat_id = $row['cat_id'];		static::$cat_name = $row['cat_name'];
		static::$subcat_id = $row['subcat_id'];		static::$subcat_name = $row['subcat_name'];
		static::$itemname = $row['item_name'];			static::$qty = $row['quatity'];
		static::$uom = $row['uom'];			static::$unitcost = $row['unitcost'];
		static::$totalcost = $row['totalcost'];
	    }
    }
	
	public static function BUDGETPERFORMANCE(){
		$db = new DB();
		$data = $_GET['budgetperformance'];
		
		
			
		foreach($db->query("SELECT * FROM budget WHERE budget_id='".$data."'") as $rowym){}
		$ql = (($data[2]=="all")?"":" AND MONTHNAME(boughtdate) = '".$rowym['month']."'");
		$ql2 = (($data[2]=="all")?"":" AND MONTHNAME(inserted_date) = '".$rowym['month']."'");
		echo'<center><label>INCOME PERFORMANCE</label></center>
			<table id="budgetdata" class="table table-striped table-bordered"style="width: 100%; cellspacing: 0;">
					<tr>
						<th width="40%">ITEM</th>
						<th width="20%">ESTIMATED</th>
						<th width="20%">ACTUAL</th>
						<th width="20%">BALANCE</th>
					</tr>';
		
		foreach($db->query("SELECT * FROM budget_details WHERE budget_id='".$rowym['budget_id']."' AND type='2'") as $row){
			SECTIONS::$search_code = $row['accountcode'];
			SECTIONS::SEARCH_CODE();
			echo '<tr>';
			echo '<td width="40%">('.$row['accountcode'].') '.SECTIONS::$resultname.'</td>';
			echo '<td width="20%">'.number_format($row['totalcost']).'</td>';
			foreach($db->query("SELECT SUM(amount) as amount FROM incometrail WHERE accountcode='".$row['accountcode']."' AND YEAR(inserted_date)='".$rowym['year']."'".$ql2) as $row1){}
			$bal = $row['totalcost'] - (($row1['amount'])?$row1['amount']:"0");
			$valz = (($bal < 0)?"<b>+</b>":"").number_format($bal);
			echo '<td width="20%">'.number_format($row1['amount']).'</td>';
			echo '<td width="20%">'.$valz.'</td>';
			echo '</tr>';
		}
		echo '
			</table><br>
		';
		echo'<center><label>EXPENSE PERFORMANCE</label></center>
			<table id="budgetdata" class="table table-striped table-bordered"style="width: 100%; cellspacing: 0;">
				<tr>
					<th width="40%">ITEM</th>
					<th width="20%">ESTIMATED</th>
					<th width="20%">ACTUAL</th>
					<th width="20%">BALANCE</th>
				</tr>';
				
		$data1 = array();
		foreach($db->query("SELECT accountcode FROM budget_details WHERE type='1'") as $row1){
			$indata = explode(" ",$row1['accountcode']);
			array_push($data1,$indata[0]);
		}
		
		$codes =array_unique($data1);
		$oftot = "";
		foreach($codes as $k){
			SECTIONS::$search_code = $k;
			SECTIONS::SEARCH_CODE();
			
			echo '<tr>';
			echo '<td width="40%"><b> '.SECTIONS::$resultname.'</b></td>';
			echo '<td width="20%"></td>';
			echo '<td width="20%"></td>';
			echo '<td width="20%"></td>';
			echo '</tr>';
			$tot = "";
			foreach($db->query("SELECT * FROM budget_details WHERE type='1' AND budget_id='".$rowym['budget_id']."' AND accountcode like '".$k."%'") as $row){
				SECTIONS::$search_code = $row['accountcode'];
				SECTIONS::SEARCH_CODE();
				echo '<tr>';
				echo '<td width="40%">('.$row['accountcode'].') '.SECTIONS::$resultname.'</td>';
				echo '<td width="20%">'.number_format($row['totalcost']).'</td>';
				foreach($db->query("SELECT SUM(paidamount) as paidamount FROM expensestracs WHERE expensecode='".$row['accountcode']."' AND YEAR(boughtdate)='".$rowym['year']."'".$ql) as $row1){}
				$bal = $row['totalcost'] - (($row1['paidamount'])?$row1['paidamount']:"0");
				$valz = number_format($bal);
				echo '<td width="20%">'.number_format($row1['paidamount']).'</td>';
				echo '<td width="20%">'.$valz.'</td>';
				echo '</tr>';
				$tot += $bal;
			}
			echo '<tr>';
			echo '<td width="40%"></td>';
			echo '<td width="20%"></td>';
			echo '<td width="20%"><b>SUB TOTAL</b></td>';
			echo '<td width="20%"><b>'.number_format($tot).'</b></td>';
			echo '</tr>';
			$oftot += $tot;
		}
		echo '<tr>';
			echo '<td width="40%"></td>';
			echo '<td width="20%"></td>';
			echo '<td width="20%"><b>TOTAL</b></td>';
			echo '<td width="20%"><b>'.number_format($oftot).'</b></td>';
			echo '</tr>';
		echo '
			</table>
		';	
	
	}
}
class IMPORTSSL extends database_crud{
	protected $table = "items";
	protected $pk = "ids";
	
	public static function UPLOADFORM(){
		echo'
				<input type="file" name="file" class="">
				<div id="exceldataarea1"></div>
		';
	}
}
class AUTH_PAGE extends database_crud{
    public static $page_no;
	
    public static function ACCOUNT_LOGIN(){
        $db = new DB();  session_start();
        unset($_SESSION['username']);
        unset($_SESSION['user_id']);
        if(isset($_POST['login_but'])){
            $sql ="SELECT * FROM users u,user_roles r WHERE u.role_id=r.user_role_id AND u.user_name='".$_POST['Username']."' AND u.password='".$_POST['Password']."'";
            foreach ($db->query($sql) as $row){
                if($row['names']){
                    $_SESSION['user'] = $row['role_name'];      $_SESSION['user_id'] = $row['user_id'];   $_SESSION['username'] = $row['names'];
                    $_SESSION['handletag'] = $row['handle_status'];
                    redirect_to('index.php');
                }
            }
        }
    }
	
    public static function CASHIER(){
		$db = new DB();
		echo '
			<label class="labelcolor">Teller</label> 
			<select id="cashierid" onchange="cashieramountsummary()" class="form-control">
				<option value="">select Teller</option>
		';
		foreach ($db->query("SELECT * FROM users") as $row){
            $pages = explode(",",$row['pages']);
            for($j=0; $j<=count($pages);$j++){
				if($pages[$j] == "3"){
					echo '
						<option value="'.$row['user_id'].'">'.$row['names'].'</option>
					';
				}
            }
        }
		echo '</select><br>';
	}

    public static function AUTETICATION_VALIDATION(){
        session_start(); $db = new DB();
        foreach ($db->query("SELECT * FROM users WHERE user_id='".$_SESSION['user_id']."'") as $row){$pages = explode(",",$row['pages']);}
        if(in_array(static::$page_no,$pages)){

        }else{
            redirect_to('index.php');
        }
    }

    public static function LOGIN_CHECK(){
        session_start();
        if (empty($_SESSION['username'])){redirect_to('login.php');}
    }

    public static function GENERAL_MENU(){
        session_start(); $db = new DB();
        foreach ($db->query("SELECT * FROM users WHERE user_id='".$_SESSION['user_id']."'") as $row){
            $pages = explode(",",$row['pages']); $menus = explode(",",$row['menus']);
            for($j=0;$j<=count($menus);$j++){
                foreach($db->query("SELECT * FROM menutitle  WHERE menu_id ='".$menus[$j]."'") as $row1){
                    echo '<li><a href = "javascript:;" ><i class="'.$row1['icons'].'" ></i ><span > '.$row1['titles'].' </span ></a >
                            <ul class="acc-menu">';
                    for ($i=0;$i<=count($pages);$i++){
                        foreach ($db->query("SELECT *  FROM pages WHERE page_no='".$pages[$i]."' AND icon='".$row1['menu_id']."'") as $rws1){
                            echo '<li><a href = "?page='.$rws1['page_url'].'" ><span> '.$rws1['page_name'].' </span></a></li>';
                        }
                    }
                    echo '</ul></li>';
                }
            }
        }
    }
}
class form_modals{
    public static function individualmodal(){
        echo '
             <div class="modal fade modals" id="transactionsmodal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal hide" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" style="width: 60%">
                <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <center><h4 class="modal-title"><b>Account Details</b></h4></center>
                        </div>
                    <div class="form-horizontal">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12" id="individualclientdata">
                                    '.CLIENT_DATA::INDIVIDUALDATA().'
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            ';
    }
    public static function groupdatamodal(){
        echo '
             <div class="modal fade modals" id="groupmodal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal hide" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" style="width: 90%">
                <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <center><h4 class="modal-title"><b>Account Details</b></h4></center>
                        </div>
                    <div class="form-horizontal">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12" id="groupclientdata">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            ';
    }
    public static function businessdatamodal(){
        echo '
             <div class="modal fade modals" id="businessmodal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal hide" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" style="width: 70%">
                <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <center><h4 class="modal-title"><b>Account Details</b></h4></center>
                        </div>
                    <div class="form-horizontal">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12" id="businessclientdata">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            ';
    }
    public static function transactionmodal(){
        echo '
             <div class="modal fade modals" id="trasacdetail"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal hide" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" style="width: 40%">
                <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <center><h4 class="modal-title"><b>Deposit Description</b></h4></center>
                        </div>
                    <div class="form-horizontal">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12" id="depositdetaileddescription">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            ';
    }
    public static function addloanapplication(){
        echo '
             <div class="modal fade modals" id="addloanappdetails"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal hide" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" style="width: 70%">
                <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <center><h4 class="modal-title"><b>Loan Application</b></h4></center>
                        </div>
                    <div class="form-horizontal">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12" id="loanapplicationdetails">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            ';
    }
    public static function addloanappraisal(){
        echo '
             <div class="modal fade modals" id="addloanappraisaldetails"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal hide" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" style="width: 70%">
                <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <center><h4 class="modal-title"><b>Loan Appraisal</b></h4></center>
                        </div>
                    <div class="form-horizontal">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12" id="loanappraisaldetails">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            ';
    }
    public static function makedecision(){
        echo '
             <div class="modal fade modals" id="makedecision"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal hide" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" style="width: 90%">
                <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <center><h4 class="modal-title"><b>MAKE DECISIONS ABOUT THIS LOAN</b></h4></center>
                        </div>
                    <div class="form-horizontal">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12" id="makeloandecision">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            ';
    }
    public static function declinedloans(){
        echo '
             <div class="modal fade modals" id="declinedloansmodal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal hide" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" style="width: 80%">
                <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <center><h4 class="modal-title"><b>DECLINED LOANS</b></h4></center>
                        </div>
                    <div class="form-horizontal">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12" id="declinedloans">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            ';
    }
    public static function loanschedule(){
        echo '
             <div class="modal fade modals" id="scheduleloansmodal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal hide" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" style="width: 80%">
                <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <center><h4 class="modal-title"><b>Repayment Schedule</b></h4></center>
                        </div>
                    <div class="form-horizontal">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12" id="loanschedule">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            ';
    }
    public static function loanledgercard(){
        echo '
             <div class="modal fade modals" id="loanledgermodal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal hide" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" style="width: 80%">
                <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <center><h4 class="modal-title"><b>Client Loan Ledger</b></h4></center>
                        </div>
                    <div class="form-horizontal">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12" id="loanledgercard">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            ';
    }
    public static function DisburseDetail(){
        echo '
             <div class="modal fade modals" id="disbursedetailmodal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal hide" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" style="width: 45%">
                <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <center><h4 class="modal-title"><b>Client Disbursement Detail</b></h4></center>
                        </div>
                    <div class="form-horizontal">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12" id="disbursedetail">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            ';
    }
    public static function schoolfees(){
    	echo '
         <div class="modal fade modals" id="schoolfeesmodal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal hide" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" style="width: 40%">
            <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <center><h4 class="modal-title"><b>School Fees Handle</b></h4></center>
                    </div>
                <div class="form-horizontal">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12" id="schoolfeesdata">
                                <div class="row">
                                                                            <div class="col-sm-6 col-sm-offset-3">
                                                                                    <label>select term</label>
                                                                                    <select class="form-control">
                                                                                            <option value="1">TERM 1</option>
                                                                                            <option value="2">TERM 2</option>
                                                                                            <option value="3">TERM 3</option>
                                                                                    </select><br><br>
                                                                                    <label>Students Class</label>
                                                                                    <input class="form-control"><br><br>
                                                                                    <label>Students Names</label>
                                                                                    <input class="form-control"><br><br>
                                                                                    <center><button class="btn-flickr btn btn-social" type="" onclick="attachschfeesdetails()"><i class="fa fa-paperclip"></i> Attach</button></center>
                                                                            </div>
                                                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        ';
	}
    public static function assetschedule(){
        echo '
         <div class="modal fade modals" id="scheduleassetmodal"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal hide" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" style="width: 60%">
            <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <center><h4 class="modal-title"><b>Asset Depeciation Chart</b></h4></center>
                    </div>
                <div class="form-horizontal">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12" id="assetschedule">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        ';
    }
    public static function uploadexcel1(){
        echo '
         <div class="modal fade modals" id="excelsheetupload"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal hide" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" style="width: 30%">
            <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <center><h4 class="modal-title"><b>DEPOSIT TO SHARES,SAVINGS & LOANS TO MULTIPLE ACCOUNTS.</b></h4></center>
                    </div>
                <div class="form-horizontal">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12" >
                                                                    <form id="uploadexcelform" method="POST" action="" enctype="multipart/form-data">
                                                                            <label>Upload Excel File</label>
                                                                            <div id="exceldataarea">
                                                                            <input type="file" name="file" class="">
                                                                            <div id="exceldataarea1"></div>
                                                                            </div>
                                                                            <br><br>
                                                                            <button type="submit" name="uploadexcelbutton" class="btn btn-success"><i class="fa fa-upload"></i> &nbsp;Upload</button>
                                                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
        ';
    }
    public static function addphysicaladdress(){
        echo '
             <div class="modal fade modals" id="excelsheetupload"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal hide" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" style="width: 30%">
                <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <center><h4 class="modal-title"><b>DEPOSIT TO SHARES,SAVINGS & LOANS TO MULTIPLE ACCOUNTS.</b></h4></center>
                        </div>
                    <div class="form-horizontal">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12" >
									<form id="uploadexcelform" method="POST" action="" enctype="multipart/form-data">
										<label>Upload Excel File</label>
										<div id="exceldataarea">
										<input type="file" name="file" class="">
										</div>
										<br><br>
										<button type="submit" name="uploadexcelbutton" class="btn btn-success"><i class="fa fa-upload"></i> &nbsp;Upload</button>
									</form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
            ';
    }
    public static function addgroup(){
          echo '
               <div class="modal fade modals" id="addgroup"  tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" class="modal hide" data-backdrop="static" data-keyboard="false">
                  <div class="modal-dialog" style="width: 40%">
                  <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                              <center><h4 class="modal-title"><b>Add Clients to Group</b></h4></center>
                          </div>
                      <div class="form-horizontal">
                          <div class="modal-body">';

                          NOW_DATETIME::NOW();    $db = new DB();    SYS_CODES::ASSET_NO();
                          echo '
                              <div class="row">
                                  <div class="col-md-12">
                                      <div class="panel panel-teal">
                                          <center><h3><b>Record</b></h3></center><br>
                                          <div class="col-md-10 col-md-offset-1">
                                              <div id="noncashtransferdata">
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
                                                </div>
                                            </div>
                                        </div>
                                      </div>
                                  </div>
                              </div>
                            ';

                  echo '
                          </div>
                      </div>
                  </div>
                  </div>
              </div>
              ';
     }
}

