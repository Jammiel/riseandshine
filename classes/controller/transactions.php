<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class SHARESDATA extends database_crud{
	protected $table = "sharetransferecords";
	protected $pk = "transferid";
	
	// SELECT `transferid`, `fromclient`, `toclient`, `amount`, `user_handle`, 
	// `shrdate`, `shrtime` FROM `sharetransferecords` WHERE 1

	public static function SAVETRANSFERSHARE(){
		$transfer = new SHARESDATA();	$db = new DB();				session_start(); 
        NOW_DATETIME::NOW(); 			$merge = new MERGERWD();   	GENERAL_SETTINGS::GEN();
		
		$data = explode("?::?",$_GET['savesharetransferrecords']);  
		
		
		
		$db->query("UPDATE clients SET shareaccount_amount = shareaccount_amount + '".$data[2]."' WHERE clientid = '".$data[1]."'");
		$db->query("UPDATE clients SET shareaccount_amount = shareaccount_amount - '".$data[2]."' WHERE clientid = '".$data[0]."'");
		
		$db->query("UPDATE clients SET numberofshares = numberofshares + '".($data[2]/GENERAL_SETTINGS::$sharevalue)."' WHERE clientid = '".$data[1]."'");
		$db->query("UPDATE clients SET numberofshares = numberofshares - '".($data[2]/GENERAL_SETTINGS::$sharevalue)."' WHERE clientid = '".$data[0]."'");
		
		CLIENT_DATA::$clientid = $data[1];
		CLIENT_DATA::CLIENTDATAMAIN();
		$tobal = CLIENT_DATA::$shares;
		
		CLIENT_DATA::$clientid = $data[0];
		CLIENT_DATA::CLIENTDATAMAIN();
		$frombal = CLIENT_DATA::$shares;
		
		$transfer->fromclient = $data[0];
        $transfer->toclient = $data[1];
        $transfer->amount = $data[2];
        $transfer->tobal = $tobal;
        $transfer->frombal = $frombal;
        $transfer->shrdate = NOW_DATETIME::$Date;
        $transfer->shrtime = NOW_DATETIME::$Time;
        $transfer->user_handle = $_SESSION['user_id'];
        $transfer->create();
		
		$merge->transactiontype = "7";
        $merge->transactionid = $transfer->pk;
        $merge->insertiondate = NOW_DATETIME::$Date_Time;
        $merge->clientid = $data[1];
        $merge->create();
		
		$merge->transactiontype = "7";
        $merge->transactionid = $transfer->pk;
        $merge->insertiondate = NOW_DATETIME::$Date_Time;
        $merge->clientid = $data[0];
        $merge->create();
		
		self::CANCELSHARETRANSFER();
		echo '|<><>|';
		self::RETURNEDSHARETRANSFER();
	}
	
	public static function GETFROMSHARE(){
		
		CLIENT_DATA::$clientid = $_GET['getshareclientstand'];
		CLIENT_DATA::CLIENTDATAMAIN();
		
		echo number_format(CLIENT_DATA::$shares);
		echo '|<><>|';
		echo number_format(CLIENT_DATA::$no_of_shares);
	}
	
	public static function SHARECASHCHECK(){	
		$data = explode("?::?",$_GET['sharecashcheck']);	$db = new DB();
		$message = "2";
		
		CLIENT_DATA::$clientid = $data[0];
		CLIENT_DATA::CLIENTDATAMAIN();
		
		 if(CLIENT_DATA::$shares < $data[2]){   
			$message= "1"; 
		 }
		 
		echo $message; 
	}
	
	public static function CANCELSHARETRANSFER(){
		echo '
			<div class="alert alert-info" style="background-color: #00af6e">
				<b style="font-weight: 900;font-size: 18px;color: #ffffff">Client\'s Share Stand</b><br>
				<hr>
				<b style="font-weight: 900;font-size: 18px;color: #ffffff">Share Amount <span id="amtshare" class="pull-right">'.number_format(0).'</span></b><br>
				<b style="font-weight: 900;font-size: 18px;color: #ffffff">Share Number <span id="numshare" class="pull-right">'.number_format(0).'</span></b><br>
			</div><br><br>
			<label class="labelcolor">From Client Name</label>
			<select onchange="getshareclientstand()" id="fromclient" class="selectpicker show-tick form-control" data-live-search="true">
				  <option value="">select member...</option>
				  ';CLIENT_DATA::CLIENT_OPTIONSEARCH();  echo'
			</select><br> 
			<label class="labelcolor">To Client Name</label>
			<select onchange="shareclientverify()" id="toclient" class="selectpicker show-tick form-control" data-live-search="true">
				  <option value="">select member...</option>
				  ';CLIENT_DATA::CLIENT_OPTIONSEARCH();  echo'
			</select><br>
			<label class="labelcolor">Share Amount</label> 
			<input onclick="" id="amtrcvd" type="text" class="form-control" placeholder="Enter Amount Received"><br>
			<center>
				<button id="subtrac1" class="btn-primary btn" onclick="savesharetransferrecords()" >Submit Share Record</button>
				<button onclick="canceltransfershare()" class="btn btn-default" >Cancel</button>  
			</center> <br><br> 
		';
	}
		
	public static function RETURNEDSHARETRANSFER(){	
		$db = new DB(); GENERAL_SETTINGS::GEN();
		echo '
		<table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
			<thead>
				<tr class="info">
					<th width="40%">Account Detail</th>
					<th width="30%">Transfer Detail</th>
					<th width="25%">Date and Time</th>
					<th width="5%">Actions</th>
				</tr>
			</thead>
			<tbody>
			'; 
			foreach($db->query("SELECT * FROM sharetransferecords ORDER BY transferid DESC") as $row){
				
				CLIENT_DATA::$clientid = $row['fromclient'];
				CLIENT_DATA::CLIENTDATAMAIN();
				$accname1 = CLIENT_DATA::$accountname;
				$accn01 = CLIENT_DATA::$accountno;
				
				CLIENT_DATA::$clientid = $row['toclient'];
				CLIENT_DATA::CLIENTDATAMAIN();
				$accname2 = CLIENT_DATA::$accountname;
				$accn02 = CLIENT_DATA::$accountno;
				
				echo "<tr>";
				echo "<td data-order='1'><b style='color: #b9151b;'>Share Transfer</b><br>From : <b>".$accname1." </b> <b class='pull-right'>(".$accn01.")</b><br>To : <b>".$accname2." </b> <b class='pull-right'>(".$accn02.")</b></td>";
				echo "<td>Transfer Amount : <b>".number_format($row['amount'])."</b><br>No of Shares : <b>".$row['amount']/GENERAL_SETTINGS::$sharevalue."</b><br>From Balance : <b>".number_format($row['frombal'])."</b><b class='pull-right'>".$row['frombal']/GENERAL_SETTINGS::$sharevalue."</b><br>To Balance : <b>".number_format($row['tobal'])."</b><b class='pull-right'>".$row['tobal']/GENERAL_SETTINGS::$sharevalue."</b></td>";
				echo "<td>Transfer Date: <b>".$row['shrdate']."</b><br>Time : <b> ".$row['shrtime']."</b></td>";
				echo "<td></td>";
				echo "</tr>";
			} 
		echo'
			</tbody>
		</table>
		';
         
	}
	
	public static function SHARELEDGER(){
		$db = new DB();
		CLIENT_DATA::$clientid = $_GET['getsharedata'];
		CLIENT_DATA::CLIENTDATAMAIN();
		echo '
			<div class="alert alert-success" style="background-color: #00af6e">
				<b style="font-weight: 900;font-size: 28px;color: #ffffff">
					Total Amount of Shares:  &nbsp;&nbsp; '.number_format(CLIENT_DATA::$shares).'<hr>
					Total No of Shares:  &nbsp;&nbsp; '.number_format(CLIENT_DATA::$no_of_shares).'
				</b>
			</div><br>
			<table id="example" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
				<thead>
					<tr>
						<th width="6%">Date</th>
						<th width="8%">Reference #</th>
						<th width="15%">Withdrawals<hr><center>DEBIT</center></th>
						<th width="15%">Purchased<hr><center>CREDIT</center></th>
						<th width="18%">Paid Capital Maintainance<hr><center>CREDIT</center></th>
						<th width="18%">Divideneds on Shares<hr><center>CREDIT</center></th>
						<th width="10%">Balance</th>
					</tr>
				</thead>
				<tbody>
				';
				foreach ($db->query("SELECT * FROM mergerwd WHERE clientid='".$_GET['getsharedata']."' ORDER BY mergeid DESC") as $rowt){
					if($rowt['transactiontype']=="1"){
						foreach($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."' ORDER BY inserteddate DESC") as $row){
							$tracsaveitem = explode(",",$row['depositeditems']);
							$tracsaveamt = explode(",",$row['depositedamts']);
							for($t = 0;$t <= count($tracsaveitem); $t++){
								if($tracsaveitem[$t] == "2"){
									echo "<tr>";
									echo "<td data-order='2017-00-00'>".$rowt['insertiondate']."</td>";
									echo "<td></td>";
									echo "<td></td>";
									echo "<td><b>".number_format($tracsaveamt[$t])."</b></td>";
									echo "<td></td>";
									echo "<td></td>";
									echo "<td><b>".number_format($row['sbal'])."</b></td>";
									echo "</tr>";
								}
							}

						}
					}
					if($rowt['transactiontype']=="6"){
						foreach ($db->query("SELECT * FROM noncashtracs WHERE nontracid='".$rowt['transactionid']."'") as $row1){
							
							if($row1['accountcode']=="2"){
								echo "<tr>";
								echo "<td data-order='2017-00-00'>".$rowt['insertiondate']."</td>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td><b>".number_format($row1['amount'])."</b></td>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td><b>".number_format($row1['shrbal'])."</b></td>";
								echo "</tr>";
							}
						}
					}
					if($rowt['transactiontype']=="7"){
						foreach($db->query("SELECT * FROM sharetransferecords WHERE transferid ='".$rowt['transactionid']."'") as $row2){
				
							if($row2['toclient'] == $rowt['clientid']){
								echo "<tr>";
								echo "<td data-order='2017-00-00'>".$rowt['insertiondate']."</td>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td><b>".number_format($row2['amount'])."</b></td>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td><b>".number_format($row2['tobal'])."</b></td>";
								echo "</tr>";
							}
							if($row2['fromclient'] == $rowt['clientid']){
								echo "<tr>";
								echo "<td data-order='2017-00-00'>".$rowt['insertiondate']."</td>";
								echo "<td></td>";
								echo "<td><b>".number_format($row2['amount'])."</b></td>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td></td>";
								echo "<td><b>".number_format($row2['frombal'])."</b></td>";
								echo "</tr>";
							}
							
						} 
					}
				}
					
				echo'
				</tbody>
			</table>
		';
	}
}
class DIVIDENDS extends database_crud{
	protected $table = "divideneds";
	protected $pk = "divid";
	
	// SELECT `divid`, `clientid`, `divamt`, `divbal`, `savbal`, `user_handle`, `ddate`, `dtime` FROM `divideneds` WHERE 1
	
	public static function AWARDDIVIDENDS(){
		$db = new DB(); $divd = new DIVIDENDS();  session_start();
		$merge = new MERGERWD(); GENERAL_SETTINGS::GEN();
		NOW_DATETIME::NOW();
		
		foreach($db->query("SELECT * FROM clients WHERE shareaccount_amount >= '".GENERAL_SETTINGS::$sharevalue."'") as $row){
			$clientid = $clientid."?--?". $row['clientid'];
			$sharecut = $sharecut."?--?". $row['shareaccount_amount'];
		}
			$vals = SYS_CODES::split_on($clientid,4);
			$res = $vals[1];
			
			$valshar = SYS_CODES::split_on($sharecut,4);
			$reshr = $valshar[1];
			
			$clientdatavals = explode("?--?",$res);
			$clientshare= explode("?--?",$reshr);
		for($i = 0; $i< count($clientdatavals); $i++){
			$shareamt = (GENERAL_SETTINGS::$dividends/100)*$clientshare[$i];
			
			$db->query("UPDATE clients SET savingaccount = savingaccount + '".$shareamt."' WHERE clientid = '".$clientdatavals[$i]."'");
			foreach ($db->query("SELECT * FROM clients WHERE clientid = '".$clientdatavals[$i]."'") as $row){$shrbalnce = $row['shareaccount_amount']; $savingbalnce = $row['savingaccount'];}

			
			$divd->clientid = $clientdatavals[$i];
			$divd->divamt = $shareamt;
			$divd->user_handle = $_SESSION['user_id'];
			$divd->divbal = $shrbalnce;
			$divd->savbal = $savingbalnce;
			$divd->ddate = NOW_DATETIME::$Date;
			$divd->dtime = NOW_DATETIME::$Time;
			$divd->create();

			$merge->transactiontype = "8";
			$merge->transactionid = $divd->pk;
			$merge->insertiondate = NOW_DATETIME::$Date_Time;
			$merge->clientid = $clientdatavals[$i];
			$merge->create();
		}
		self::RETURNEDDIVIDENDS();
	}
	
	public static function RETURNEDDIVIDENDS(){	
		$db = new DB();
		echo '
		<table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
			<thead>
				<tr class="info">
					<th width="44%">Account Detail</th>
					<th width="20%">Date and Time</th>
					<th width="30%">Transfer Detail</th>
				</tr>
			</thead>
			<tbody>
			'; 
			foreach($db->query("SELECT * FROM divideneds ORDER BY divid DESC") as $row){
				CLIENT_DATA::$clientid = $row['clientid'];
				CLIENT_DATA::CLIENTDATAMAIN();
				
				echo "<tr>";
				echo "<td data-order='1'><b style='color: #b9151b;'>Dividends Deposit</b><br><b>".CLIENT_DATA::$accountname." </b> <b class='pull-right'>(".CLIENT_DATA::$accountno.")</b></td>";
				echo "<td>Transfer Date: <b>".$row['ddate']."</b><br>Time : <b> ".$row['dtime']."</b></td>";
				echo "<td>Transfer Amount : <b>".number_format($row['divamt'])."</b><br>Saving Balance : <b>".number_format($row['savbal'])."</b></td>";
				echo "</tr>";
			} 
		echo'
			</tbody>
		</table>
		';
         
	}
}
class CASHIER_TRACS extends database_crud{
	protected $table = "cashier";
	protected $pk = "cahierid";
	// SELECT `cahierid`, `cashier`, `amount`, `day`, `time` FROM `cashier` WHERE 1
}
class INCHARGE_CASHIER extends database_crud{
	protected $table = "cashierincharge";
	protected $pk = "inid";
	// SELECT `inid`, `cashier`, `amount` FROM `cashierincharge` WHERE 1
}
class CASHIER_RECONSILIATION extends database_crud{
	protected $table = "casierreconsil";
	protected $pk = "reconid";
	// SELECT `reconid`, `recondate`, `recontime`, `shortage`, `overage`, `cashathand`, 
	// `expectedamt`, `openingamt`, `totdep`, `totwithd`, `cashier` FROM `casierreconsil` WHERE 1
	
	
	public static function SAVERECON(){
		$recon = new CASHIER_RECONSILIATION();	NOW_DATETIME::NOW();	session_start();
		$data = explode("?::?",$_GET['savesocheckamt']);
		$db = new DB();
		$recon->recondate = NOW_DATETIME::$Date;
		$recon->recontime = NOW_DATETIME::$Time;
		$recon->cashathand = $data[0];
		$recon->shortage = $data[1];
		$recon->overage = $data[2];
		$recon->expectedamt = $data[3];
		$recon->openingamt = $data[6];
		$recon->totdep = $data[5];
		$recon->totwithd = $data[4];
		$recon->cashier = $_SESSION['user_id'];
		$recon->create();
		$db->query("UPDATE cashierincharge SET status='2' WHERE cashier='".$_SESSION['user_id']."'");
		$db->query("UPDATE deposits SET status='1' WHERE user_handle='".$_SESSION['user_id']."'");
		$db->query("UPDATE withdraws SET status='1' WHERE user_handle='".$_SESSION['user_id']."'");
		
	}
}
class OVERAGESHORTAGE_CASHIER extends database_crud{
	protected $table = "cashiershortageoverage";
	protected $pk = "soid";
	// SELECT `soid`, `cashier`, `state`, `amount` FROM `cashiershortageoverage` WHERE 1
}
class CASH_TRACS extends database_crud{
	protected $table = "cashiertracs";
	protected $pk = "ctracsid";
		// SELECT `ctracsid`, `camount`, `exptdamt`, `rcvdamt`, `cdep`,
		// `cwithd`, `shortage`, `overage`, `cashier`, `ctype`, `ctime`, `cdate` FROM `cashiertracs` WHERE 1
    public static $cashieramt;

	public static function SAVECASHIER(){
		$cash = new CASH_TRACS();		NOW_DATETIME::NOW();      $incash = new INCHARGE_CASHIER();
		$db = new DB(); $cashier = "";
		$data = explode("?::?",$_GET['savecashiertracs']);
		$cash->camount = $data[2];
		$cash->cashier = $data[0];
		$cash->ctype = $data[1];
		$cash->ctime = NOW_DATETIME::$Time;
		$cash->cdate = NOW_DATETIME::$Date;
		
        foreach($db->query("SELECT * FROM cashierincharge WHERE cashier='".$data[0]."'") as $incharge){$cashier = $incharge['cashier'];}
        if($cashier){}else{$incash->cashier = $data[0]; $incash->amount = "0"; $incash->create();}
		if($data[1]=="1"){
			$db->query("UPDATE cashiercash SET ccashamt=ccashamt+'".$data[2]."' WHERE cashid='1'");
            foreach($db->query("SELECT * FROM cashierincharge WHERE cashier='".$data[0]."'") as $incharge){
				$expted = ($incharge['amount']+$incharge['dep']-$incharge['withd']);
				$res= $data[2] - $expted;
				$cash->cdep = $incharge['dep'];
				$cash->cwithd = $incharge['withd'];
				$cash->rcvdamt = $incharge['amount'];
				$cash->exptdamt = $expted;
				
				if($res < "0"){$shortage = -$res; $overage = "0";}
				if($res > "0"){$overage = $res;	$shortage = "0";}
				if($res == "0"){$shortage = "0" ;	$overage = "0";}
				
				$cash->shortage = $shortage;
				$cash->overage = $overage;
				
                $db->query("UPDATE cashierincharge SET amount='0', dep='0', withd='0', status='0' WHERE cashier='".$data[0]."'");
                $db->query("UPDATE cashiertracs SET status='1' WHERE cashier='".$data[0]."'");
            }
		}
		if($data[1]=="2"){
		    $db->query("UPDATE cashiercash SET ccashamt=ccashamt-'".$data[2]."' WHERE cashid='1'");
            foreach($db->query("SELECT * FROM cashierincharge WHERE cashier='".$data[0]."'") as $incharge){
                $db->query("UPDATE cashierincharge SET amount=amount+'".$data[2]."' WHERE cashier='".$data[0]."'");
				$db->query("UPDATE cashierincharge SET status='1' WHERE cashier='".$data[0]."'");
            }
		}
		$cash->create();
		self::RETURNED_CASHIER();
		echo '|<><>|';
		VAULT_TRACS::RETURNED_CASHIER();
		echo '|<><>|';
		self::cancelcashier();
		echo '|<><>|';
		VAULT_TRACS::CASHSUMMARY();
		
	}
	
	public static function CASHCASHCHECK(){	
		$db = new DB(); $data = explode("?::?", $_GET['cashcashcheck']);
		foreach($db->query("SELECT * FROM cashiercash") as $row){
			if($row['ccashamt'] < $data[2] && $data[1]== "2"){$message= "1";}else{$message = "0";}
		}
		// foreach($db->query("SELECT * FROM cashierincharge WHERE cashier='".$data[0]."'") as $row){
			// if($row['status'] == "0"){$message= "2";}
		// }
		echo $message; 
	}
	
	public static function INOUTCASHCHECK(){	
		$data = explode("?::?",$_GET['inoutcashcheck']);	$db = new DB();
		
		 if($data[1] == "1"){   
			foreach($db->query("SELECT * FROM cashierincharge WHERE cashier='".$data[0]."'") as $row){
				if($row['status'] == "1"){if($row['dep']!= "0" || $row['withd']!= "0"){$message= "1";}}
			} 
		 }else{}
		 
		echo $message; 
	}
	
	public static function RETURNED_CASHIER(){
		$db = new DB();
		echo '
				<table id="example" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr class="info">
                            <th width="30%">Date</th>
							<th width="40%">Description</th>
							<th width="30%">Teller</th>
                        </tr>
                    </thead>
                    <tbody>';
                        foreach($db->query("SELECT * FROM cashiertracs  ORDER BY ctracsid DESC") as $row){
							echo '<tr>';
							echo '<td data-order="2017-00-00"><b>'.$row['cdate'].'</b><br>'.$row['ctime'].' </td>';
							echo '	<td>';
								if($row['ctype']=="1"){
									echo '<b style="color: #00af6e">Cash In</b><br>';
									echo '<b>Deposits</b><b class="pull-right">'.number_format($row['cdep']).'</b>';
									echo '<br><b>Withdraws</b><b class="pull-right">'.number_format($row['cwithd']).'</b>';
									echo '<br><b>Returned Amount</b> : <b class="pull-right">'.number_format($row['camount']).'</b>';
									echo '<br><b>Expected Amount</b><b class="pull-right">'.number_format($row['exptdamt']).'</b>';
									echo '<br><b>Shotage</b><b class="pull-right">('.number_format($row['shortage']).')</b>';
									echo '<br><b>Overage</b><b class="pull-right">'.number_format($row['overage']).'</b>';
									
								}
								if($row['ctype']=="2"){echo '<b style="color: #af0005">Cash Out</b><br>Amount : <b class="pull-right">'.number_format($row['camount']).'</b>';}
										
							echo'	</td>';
							echo '<td><center><b>';
								foreach($db->query("SELECT * FROM users WHERE user_id='".$row['cashier']."'") as $rows){ echo '<b>'.$rows['names'].'</b>';}
							echo'</b></center></td>';
							echo '</tr>';
						}
            echo'   </tbody>
                </table>
		';
		
	}
	
	public static function cancelcashier(){
		AUTH_PAGE::CASHIER();
		echo '
			<label class="labelcolor">Action Type</label> 
			<select onchange="inoutcheckcash()" id="actiontype" class="form-control">
				<option value="">select Action Type</option>
				<option value="1">Cash In</option>
				<option value="2">Cash Out</option>
			</select><br>
			<label class="labelcolor">Transaction Amount.</label> 
			<input onclick="" id="tracamt" type="text" class="form-control" placeholder="Enter Transaction Amount"><br>
			<br><br>
			<center>
				<button id="subtrac1" class="btn-info btn" type="" onclick="savecashiertransaction()">submit transaction</button>
				<button class="btn-default btn" type="" onclick="cancelcashiercash()">cancel</button> 
			</center> 
			<br><br>
		';
	}

    public static function CASHIERAMT(){
        $db = new DB(); session_start();
        foreach($db->query("SELECT * FROM cashierincharge WHERE cashier='".$_SESSION['user_id']."'") as $incharge){ }
        static::$cashieramt = $incharge['amount'];
	}

	public static function CASHIERAMTSUMMARY(){
	    $db = new DB();  NOW_DATETIME::NOW();
        foreach($db->query("SELECT * FROM cashierincharge WHERE cashier='".$_GET['cashieramtsummary']."'") as $incharge){ }
        foreach($db->query("SELECT SUM(amount+dep-withd) as overall FROM cashierincharge") as $overall){ }
       echo'
            <div class="alert alert-info" style="background-color: #00af6e">
                <b style="font-weight: 900;font-size: 18px;color: #ffffff">Recevied Cash:  <span class="pull-right"> '.number_format($incharge['amount']).'</span></b><br>
                <b style="font-weight: 900;font-size: 18px;color: #ffffff">Total Deposits:  <span class="pull-right"> '.number_format($incharge['dep']).'</span></b><br>
                <b style="font-weight: 900;font-size: 18px;color: #ffffff">Total Withdraws:  <span class="pull-right"> '.number_format($incharge['withd']).'</span></b><br>
                <b style="font-weight: 900;font-size: 18px;color: #ffffff">Expected Return: <span class="pull-right">  '.number_format($incharge['amount']+$incharge['dep']-$incharge['withd']).'</span></b><br>
                <hr>
                <b style="font-weight: 900;font-size: 18px;color: #ffffff">OverAll Expected Return: <span class="pull-right">  '.number_format($overall['overall']).'</span></b><br>
            </div>
        ';
    }
}
class CASHIER_CASH extends database_crud{
	protected $table = "cashiercash";
	protected $pk = "cashid";
        // SELECT `cashid`, `ccashamt` FROM `cashiercash` WHERE 1
}
class PETTYCASH extends database_crud{
	protected $table = "pettycash";
	protected $pk = "pettyid";
	// SELECT `pettyid`, `pettycashamt` FROM `pettycash` WHERE 1
}
class PETTYTRACS extends database_crud{
	protected $table = "pettytracs";
	protected $pk = "ptracs";
	// SELECT `ptracs`, `tracamt`, `pdate`, `ptime` FROM `pettytracs` WHERE 1
}
class VAULT extends database_crud{
	protected $table = "vault";
	protected $pk = "vaultid";
	// SELECT `vaultid`, `vaultamount` FROM `vault` WHERE 1
}
class VAULT_TRACS extends database_crud{
	protected $table = "vault_tracs";
	protected $pk = "vtracid";
	public static $tot;
	public static $tot1;
	public static $tot2;
	// SELECT `vtracid`, `transamount`, `operation`, `direction`, `vdate`, `vtime` FROM `vault_tracs` WHERE 1
	public static function VAULTCASHCHECK(){	
		$db = new DB(); $data = explode("?::?", $_GET['vaultcashcheck']);
		foreach($db->query("SELECT * FROM vault") as $row){
			if($row['vaultamount'] < $data[1] && $data[0] == "2"){$message= "1";}else{$message = "0";}
		}
		foreach($db->query("SELECT * FROM cashiercash") as $row){
			if($row['ccashamt'] < $data[1] && $data[0]== "1" && $data[2] == "1"){$message= "2";}else{$message = "0";}
		}
		echo $message; 
	}
	public static function CASHSUMMARY(){
	    self::GET_TOTAL();  self::GET_TOTAL1();  self::GET_TOTAL2(); $db = new DB();
        foreach($db->query("SELECT SUM(amount+dep-withd) as overall, SUM(amount) as amt, SUM(dep) as dep, SUM(withd) as withd FROM cashierincharge") as $overall){ }
        echo'
            <div class="alert alert-info" style="background-color: #00af6e">
                <b style="font-weight: 900;font-size: 20px;color: #ffffff">Petty cash:  <span class="pull-right"> '.number_format(VAULT_TRACS::$tot1).'</span></b><br>
                <b style="font-weight: 900;font-size: 20px;color: #ffffff">Cashier Cash: <span class="pull-right">  '.number_format(VAULT_TRACS::$tot2).'</span></b><br>
                <b style="font-weight: 900;font-size: 20px;color: #ffffff">Vault cash:  <span class="pull-right"> '.number_format(VAULT_TRACS::$tot).'</span></b><br>
                <hr>
                <b style="font-weight: 900;font-size: 20px;color: #ffffff">Available in Tellers:  <span class="pull-right"> '.number_format($overall['amt']).'</span></b><br>
                <b style="font-weight: 900;font-size: 20px;color: #ffffff">Total Deposits: <span class="pull-right">  '.number_format($overall['dep']).'</span></b><br>
                <b style="font-weight: 900;font-size: 20px;color: #ffffff">Total Withdraws:  <span class="pull-right"> ('.number_format($overall['withd']).')</span></b><br>
                <hr>
                <b style="font-weight: 900;font-size: 24px;color: #ffffff">Total Cash:  <span class="pull-right"> '.number_format(VAULT_TRACS::$tot+VAULT_TRACS::$tot2+VAULT_TRACS::$tot1+$overall['overall']).'</span></b>
            </div>
        ';
    }
	public static function GET_TOTAL(){
        $db = new DB();
        foreach ($db->query("SELECT SUM(vaultamount) as totamt FROM vault WHERE vaultid='1'") as $rowd){ self::$tot = $rowd['totamt']; }
    }
	public static function GET_TOTAL1(){
        $db = new DB();
        foreach ($db->query("SELECT SUM(pettycashamt) as totamt FROM pettycash WHERE pettyid='1'") as $rowd){ self::$tot1 = $rowd['totamt']; }
    }
	public static function GET_TOTAL2(){
        $db = new DB();
        foreach ($db->query("SELECT SUM(ccashamt) as totamt FROM cashiercash WHERE cashid='1'") as $rowd){ self::$tot2 = $rowd['totamt']; }
    }
	public static function SAVE_VAULTTRACS(){
		$valtracs = new VAULT_TRACS(); $db = new DB();
		$petty = new PETTYTRACS(); $balance=0;
		$cash = new CASHIER_TRACS(); 
		NOW_DATETIME::NOW();
		$data = explode("?::?", $_GET['savevaulttracs']);
		if($data[0]=="2"){
			if($data[2]=="2"){
				$db->query("UPDATE vault SET vaultamount=vaultamount-'".$data[1]."' WHERE vaultid='1'");
				$db->query("UPDATE cashiercash SET ccashamt=ccashamt+'".$data[1]."' WHERE cashid='1'");
				foreach($db->query("SELECT * FROM vault WHERE vaultid='1'") as $bal){$balance = $bal['vaultamount'];}
				$valtracs->transamount = $data[1];		$valtracs->operation = $data[0];
				$valtracs->direction = $data[2];		$valtracs->vdate = NOW_DATETIME::$Date;
				$valtracs->vtime = NOW_DATETIME::$Time;
				$valtracs->balance = $balance;
				$valtracs->create();
				
				$cash->amount = $data[1];
				$cash->vbal = $balance;
				$cash->cday = NOW_DATETIME::$Date;
				$cash->ctime = NOW_DATETIME::$Time;
				$cash->vtracs = $valtracs->pk;
				$cash->create();
			}else if($data[2]=="3"){
				
			}else{
				$db->query("UPDATE vault SET vaultamount=vaultamount-'".$data[1]."' WHERE vaultid='1'");
				$db->query("UPDATE pettycash SET pettycashamt=pettycashamt+'".$data[1]."' WHERE pettyid='1'");
				foreach($db->query("SELECT * FROM vault WHERE vaultid='1'") as $bal){$balance = $bal['vaultamount'];}
				$valtracs->transamount = $data[1];		$valtracs->operation = $data[0];
				$valtracs->direction = $data[2];		$valtracs->vdate = NOW_DATETIME::$Date;
				$valtracs->vtime = NOW_DATETIME::$Time;
				$valtracs->balance = $balance;
				$valtracs->create();
				
				$petty->tracamt = $data[1];
				$petty->pdate = NOW_DATETIME::$Date;
				$petty->ptime = NOW_DATETIME::$Time;
				$petty->vtracs = $valtracs->pk;
				$petty->create();
			}
		}else{
			if($data[2]=="1"){
				$db->query("UPDATE vault SET vaultamount=vaultamount+'".$data[1]."' WHERE vaultid='1'");
				$db->query("UPDATE cashiercash SET ccashamt=ccashamt-'".$data[1]."' WHERE cashid='1'");
				foreach($db->query("SELECT * FROM vault WHERE vaultid='1'") as $bal){$balance = $bal['vaultamount'];}
				$valtracs->transamount = $data[1];		$valtracs->operation = $data[0];
				$valtracs->direction = $data[2];		$valtracs->vdate = NOW_DATETIME::$Date;
				$valtracs->vtime = NOW_DATETIME::$Time;
				$valtracs->balance = $balance;
				$valtracs->create();
				
				$cash->amount = $data[1];
				$cash->vbal = $balance;
				$cash->cday = NOW_DATETIME::$Date;
				$cash->ctime = NOW_DATETIME::$Time;
				$cash->vtracs = $valtracs->pk;
				$cash->create();
			}else{
				$db->query("UPDATE vault SET vaultamount=vaultamount+'".$data[1]."' WHERE vaultid='1'");
				foreach($db->query("SELECT * FROM vault WHERE vaultid='1'") as $bal){$balance = $bal['vaultamount'];}
					$valtracs->transamount = $data[1];				$valtracs->operation = $data[0];
					$valtracs->direction = $data[2]; 				$valtracs->vdate = NOW_DATETIME::$Date;
					$valtracs->vtime = NOW_DATETIME::$Time;
					$valtracs->balance = $balance;
					$valtracs->create();
				}
			
		}
		VAULT_TRACS::GET_TOTAL();
		echo '
				<div class="alert alert-success" style="background-color: #8bc34a">
                   <b style="font-weight: 900;font-size: 28px;color: #ffffff">Available Vault cash:  &nbsp;&nbsp; '.number_format(VAULT_TRACS::$tot).'</b>
                </div>
                <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr class="info">
                            <th width="15%">Date</th>
							<th width="20%">Action Type</th>
							<th width="25%">Description</th>
							<th width="20%">Vault Amount</th>
							<th width="20%">Balance</th>
                        </tr>
                    </thead>
                    <tbody>';
                        VAULT_TRACS::RETURNED_VAULT();
            echo'   </tbody>
                </table>
		';
            echo '|<><>|';
            echo '
				<label class="labelcolor">Vault Amount</label> 
                <input onclick="" id="transactionamt" type="number" class="form-control" placeholder="Enter Transaction Amount"><br>
                <label class="labelcolor">Action Type</label> 
                <select onchange="checktranstype()" id="transactiontype" class="form-control">
                    <option value="">select Action Type</option>
                    <option value="1">Vault In</option>
                    <option value="2">Vault Out</option>
                </select><br>
                <div id="sdtype">
                    <label class="labelcolor">Destination/Source</label> 
                    <select disabled id="destination" class="form-control">
                        <option value="">select Destination/Source</option>
                        <option value="1">Petty Cash</option>
                        <option value="2">Cashier Accounts</option>
                        <option value="3">To Bank</option>
                    </select><br>
                </div>
                <div id="cashieridspace"></div>
                <center>
                   <button id="subtrac" class="btn-primary btn" type="" onclick="savevaulttransaction()">Submit Transaction</button>
                   <button onclick="cancelvault()" type="reset" class="btn btn-default">Cancel</button> 
                </center> <br><br>  
            ';
			echo '|<><>|';
			self::RETURNED_PETTY();
			echo '|<><>|';
			self::RETURNED_CASHIER();
			echo '|<><>|';
			self::CASHSUMMARY();
	}
	public static function RETURNED_VAULT(){
		$db = new DB();	NOW_DATETIME::NOW();
		foreach($db->query("SELECT * FROM vault_tracs ORDER BY vtracid DESC") as $row){
			echo '<tr>';
			echo '<td data-order="2017-00-00"><b>'.$row['vdate'].'</b><br>'.$row['vtime'].' </td>';
			echo '<td>'.(($row['operation']=="1")?"<b style='color: #00af6e'>Vault In</b>":"<b style='color: #af0005'>Vault Out</b>").'</td>';
			echo '<td>';
					if($row['operation']=="1"){
						if($row['direction']=="1"){echo "Cashier Collections";}
						if($row['direction']=="2"){echo "From Bank";}
						if($row['direction']=="3"){echo "Payment Source";}
						if($row['direction']=="4"){echo "Borrowings";}
						if($row['direction']=="6"){echo "MTN";}
						if($row['direction']=="7"){echo "AIRTEL";}
						if($row['direction']=="8"){echo "Agency Banking";}
						if($row['direction']=="5"){echo "From Petty Cash";}
					}else{
						if($row['direction']=="1"){echo "Petty Cash";}
						if($row['direction']=="2"){
							echo "Cashier Accounts<br>";
						}
						if($row['direction']=="3"){echo "To Bank";}
						if($row['direction']=="4"){echo "MTN";}
						if($row['direction']=="5"){echo "AIRTEL";}
						if($row['direction']=="6"){echo "Agency Banking";}
					}
			echo'</td>';
			echo '<td><b>'.number_format($row['transamount']).'</b></td>';
			echo '<td><b>'.number_format($row['balance']).'</b></td>';
			echo '</tr>';
		}
	}
	public static function RETURNED_PETTY(){
		$db = new DB();	NOW_DATETIME::NOW(); self::GET_TOTAL1();
		echo '
				<div class="alert alert-success" style="background-color: #8bc34a">
				   <b style="font-weight: 900;font-size: 28px;color: #ffffff">Available Petty cash:  &nbsp;&nbsp; '.number_format(VAULT_TRACS::$tot1).'</b>
				</div>
                <table id="grat2" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr class="info">
                            <th width="30%">Date</th>
							<th width="40%">PettyCash Amount</th>
							<th width="30%">Vault Balance</th>
                        </tr>
                    </thead>
                    <tbody>';
                        foreach($db->query("SELECT * FROM pettytracs p,vault_tracs v WHERE p.vtracs=v.vtracid  ORDER BY p.ptracs DESC") as $row){
							echo '<tr>';
							echo '<td data-order="2017-00-00"><b>'.$row['pdate'].'</b><br>'.$row['ptime'].' </td>';
							echo '<td><center><b>'.number_format($row['tracamt']).'</b></center></td>';
							echo '<td><center><b>'.number_format($row['balance']).'</b></center></td>';
							echo '</tr>';
						}
            echo'   </tbody>
                </table>
		';
		
	}
	public static function RETURNED_CASHIER(){
		$db = new DB();	NOW_DATETIME::NOW(); 
		self::GET_TOTAL2();
		echo '
				<div class="alert alert-success" style="background-color: #8bc34a">
				   <b style="font-weight: 900;font-size: 28px;color: #ffffff">Available Cashier Cash:  &nbsp;&nbsp; '.number_format(VAULT_TRACS::$tot2).'</b>
				</div>
                <table id="grat1" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr class="info">
                            <th width="30%">Date</th>
							<th width="40%">Description</th>
							<th width="30%">Vault Balance</th>
                        </tr>
                    </thead>
                    <tbody>';
                        foreach($db->query("SELECT * FROM cashier p,vault_tracs v WHERE p.vtracs=v.vtracid  ORDER BY p.cahierid DESC") as $row){
							echo '<tr>';
							echo '<td data-order="2017-00-00"><b>'.$row['cday'].'</b><br>'.$row['ctime'].' </td>';
							echo '<td>Action : <b class="pull-right">'.(($row['operation']=="1")?"<b>Vault In</b>":"Vault Out").'</b><br>Amount : <b class="pull-right">'.number_format($row['amount']).'</b></td>';
							echo '<td><center><b>'.number_format($row['vbal']).'</b></center></td>';
							echo '</tr>';
						}
            echo'   </tbody>
                </table>
		';
		
	}
}
class BANKTRANSACTIONS extends database_crud{
    protected $table  = "bank_transaction";
    protected $pk  = "transac_id";
    //SELECT `transac_id`, `type`, `slipno`, `amount`, `bank_balance`, `accountid`, `feesamount`, `transactiondate` FROM `bank_transaction` WHERE 1
    public static function SAVE_TRANSACTIONS(){
        $bank = new BANKTRANSACTIONS(); $db = new DB();
        NOW_DATETIME::NOW();
        $data = explode("?::?",$_GET['savebanktransaction']);


        $da = explode("/",$data[5]);
        $date = $da[2]."-".$da[0]."-".$da[1];
        $bank->slipno = $data[1];
        $bank->amount = $data[4];
        $bank->feesamount = $data[3];
        $bank->accountid = $data[0];
        $bank->transactiondate = $date;

        if($data[6]){
            foreach ($db->query("SELECT * FROM cashaccounts WHERE coacode='".$data[0]."'") as $rowacc){}
            foreach ($db->query("SELECT * FROM bank_transaction WHERE transac_id='".$data[6]."'") as $rowtracs){}
            if($rowtracs['feesamount'] == $data[3]) {}else{
                if($data[3] > $rowtracs['feesamount']){
                    $amts = $data[3] - $rowtracs['feesamount'];
                    $accountbal =  $rowtracs['bank_balance'] - $amts;
                    $db->query("UPDATE cashaccounts SET descbalance=descbalance-'".$amts."' WHERE coacode='".$data[0]."'");
                }elseif($data[3] < $rowtracs['amount']){
                    $amts = $rowtracs['feesamount'] - $data[3];
                    $accountbal = $rowtracs['bank_balance'] + $amts;
                    $db->query("UPDATE cashaccounts SET descbalance=descbalance+'".$amts."' WHERE coacode='".$data[0]."'");
                }
            }
            if($data[2]=="2" && $rowtracs['type']=="1"){
                // from deposit to withdraw
                $bank->type = $data[2];
                if($data[4] == $rowtracs['amount']){
                    $accountbal = $rowtracs['bank_balance'] - ($rowtracs['amount']*2);
                    $db->query("UPDATE cashaccounts SET descbalance=descbalance-'".($rowtracs['amount']*2)."' WHERE coacode='".$data[0]."'");
                }else{
                    $accountbal =  $rowtracs['bank_balance'] - ($rowtracs['amount']*2);
                    $db->query("UPDATE bank_transaction SET bank_balance='".$accountbal."' WHERE transac_id='".$data[6]."'");
                    $db->query("UPDATE cashaccounts SET descbalance=descbalance-'".($rowtracs['amount']*2)."' WHERE coacode='".$data[0]."'");
                    foreach ($db->query("SELECT * FROM bank_transaction WHERE transac_id='".$data[6]."'") as $rowtracs){}
                    if($data[4] > $rowtracs['amount']){
                        $amt = $data[4] - $rowtracs['amount'];
                        $accountbal = $rowtracs['bank_balance'] - $amt;
                        $db->query("UPDATE cashaccounts SET descbalance=descbalance-'".$amt."' WHERE coacode='".$data[0]."'");
                    }elseif($data[4] < $rowtracs['amount']){
                        $amt = $rowtracs['amount'] - $data[4];
                        $accountbal = $rowtracs['bank_balance'] + $amt;
                        $db->query("UPDATE cashaccounts SET descbalance=descbalance+'".$amt."' WHERE coacode='".$data[0]."'");
                    }
                }
            }elseif ($data[2]=="1" && $rowtracs['type']=="2"){
                // from withdraw to deposit
                $bank->type = $data[2];

                if($data[4] == $rowtracs['amount']){
                    $accountbal = ($rowtracs['amount']*2) + $rowtracs['bank_balance'];
                    $db->query("UPDATE cashaccounts SET descbalance=descbalance+'".($rowtracs['amount']*2)."' WHERE coacode='".$data[0]."'");
                }else{
                    $accountbal = ($rowtracs['amount']*2) + $rowtracs['bank_balance'];
                    $db->query("UPDATE bank_transaction SET bank_balance='".$accountbal."' WHERE transac_id='".$data[6]."'");
                    $db->query("UPDATE cashaccounts SET descbalance=descbalance+'".($rowtracs['amount']*2)."' WHERE coacode='".$data[0]."'");
                    foreach ($db->query("SELECT * FROM bank_transaction WHERE transac_id='".$data[6]."'") as $rowtracs){}
                    if($data[4] > $rowtracs['amount']){
                        $amt = $data[4] - $rowtracs['amount'];
                        $accountbal = $amt + $rowtracs['bank_balance'];
                        $db->query("UPDATE cashaccounts SET descbalance=descbalance+'".$amt."' WHERE coacode='".$data[0]."'");
                    }elseif($data[4] < $rowtracs['amount']){
                        $amt = $rowtracs['amount'] - $data[4];
                        $accountbal = $rowtracs['bank_balance'] - $amt;
                        $db->query("UPDATE cashaccounts SET descbalance=descbalance-'".$amt."' WHERE coacode='".$data[0]."'");
                    }
                }

            }else{
                if($data[2]=="1"){
                    if($data[4] > $rowtracs['amount']){
                        $amt = $data[4] - $rowtracs['amount'];
                        $accountbal = $amt + $rowtracs['bank_balance'];
                        $db->query("UPDATE cashaccounts SET descbalance=descbalance+'".$amt."' WHERE coacode='".$data[0]."'");
                    }elseif($data[4] < $rowtracs['amount']){
                        $amt = $rowtracs['amount'] - $data[4];
                        $accountbal = $rowtracs['bank_balance'] - $amt;
                        $db->query("UPDATE cashaccounts SET descbalance=descbalance-'".$amt."' WHERE coacode='".$data[0]."'");
                    }
                }
                if($data[2]=="2"){
                    if($data[4] > $rowtracs['amount']){
                        $amt = $data[4] - $rowtracs['amount'];
                        $accountbal = $rowtracs['bank_balance'] - $amt;
                        $db->query("UPDATE cashaccounts SET descbalance=descbalance-'".$amt."' WHERE coacode='".$data[0]."'");
                    }elseif($data[4] < $rowtracs['amount']){
                        $amt = $rowtracs['amount'] - $data[4];
                        $accountbal = $rowtracs['bank_balance'] + $amt;
                        $db->query("UPDATE cashaccounts SET descbalance=descbalance+'".$amt."' WHERE coacode='".$data[0]."'");
                    }
                }
            }
            $bank->transac_id = $data[6];
            $bank->bank_balance = $accountbal;
            $bank->save();
        }else{
            if($data[2]=="1"){
                $db->query("UPDATE cashaccounts SET descbalance=descbalance+'".$data[4]."'-'".$data[3]."' WHERE coacode='".$data[0]."'");
                foreach ($db->query("SELECT * FROM cashaccounts WHERE coacode='".$data[0]."'") as $row){$accountbal = $row['descbalance'];}
            }
            if($data[2]=="2"){
                $db->query("UPDATE cashaccounts SET descbalance=descbalance-'".$data[4]."'-'".$data[3]."' WHERE coacode='".$data[0]."'");
                foreach ($db->query("SELECT * FROM cashaccounts WHERE coacode='".$data[0]."'") as $row){$accountbal = $row['descbalance'];}
            }
            $bank->type = $data[2];
            $bank->inserted_date = NOW_DATETIME::$Date_Time;
            $bank->bank_balance = $accountbal;
            $bank->create();
        }

        echo '
            <div hidden id="banktracteditcode"></div>
            <label class="labelcolor">Bank Account</label>
            <select onchange="" id="bankaccountcode" class="selectpicker show-tick form-control" data-live-search="true">
                <option value="">select Bank Account</option>';
        CASHACCOUNT::GET_BANKACCOUNT();
        echo'
            </select><br>
            <label class="labelcolor">Slip No.</label>
            <input onclick="" id="slipno" type="date" class="form-control" placeholder="Enter Slip No."><br>
            <label class="labelcolor">Transaction Type</label>
            <select id="transactiontype" class="form-control">
                <option value="">select Transaction Type</option>
                <option value="1">Deposit</option>
                <option value="2">Withdraw</option>
            </select><br>
            <label class="labelcolor">Transaction Charges</label>
            <input onclick="" id="transactioncharge" type="number" class="form-control" placeholder="Enter Transaction Charges"><br>
            <label class="labelcolor">Transaction Amount</label>
            <input onclick="" id="transactionamount" type="number" class="form-control" placeholder="Enter Transaction Amount"><br>
            <label class="labelcolor">Transaction Date</label>
            <input onclick="" id="datepicker" type="text" class="form-control" placeholder="Enter Transaction Date"><br><br>
            <center>
                <button class="btn-primary btn" type="" onclick="SaveBankTransaction()">Submit Transaction</button>
                <button onclick="ClearBANKTRANCS()" type="reset" class="btn btn-default">Cancel</button>
            </center> <br><br>
        ';
        echo '|<><>|';
        echo '
                <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr class="info">
                            <th width="15%">Date</th>
                            <th width="25%">Account Name</th>
                            <th width="25%">Amount</th>
                            <th width="25%">Account Balance</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
        self::GET_TRANSACTIONS();
        echo'   </tbody>
                </table>
            ';
        echo '|<><>|';
        CASHACCOUNT::GET_BANKTRANSACTION();

    }
    public static function GET_TRANSACTIONS(){
        $db = new DB(); NOW_DATETIME::NOW();
        foreach ($db->query("SELECT MAX(transac_id) as maxid FROM bank_transaction") as $rowd){ $maxid = $rowd['maxid']; }
        foreach ($db->query("SELECT * FROM bank_transaction ORDER BY transac_id DESC") as $rowz){
            foreach($db->query("SELECT * FROM cashaccounts WHERE coacode='".$rowz['accountid']."'") as $row){
                foreach($db->query("SELECT * FROM level4 WHERE level3code='".$row['coacode']."'") as $rows){}
            }
            echo '<tr>';
            echo '<td data-order="2017-00-00"><b>'.$rowz['transactiondate'].'</b></td>';
            echo '<td>'.$rows['level3name'].'<br>'.(($rowz['type']==2)?'<b style="color: #9f1904">Withdraw</b>':'<b style="color: #069f4b">Deposit</b> -'.$rowz['slipno']).'</td>';
            echo '<td><b>'.number_format($rowz['amount']).'</b><br>Charges : <b style="color: #0a377e">'.$rowz['feesamount'].'</b></td>';
            echo '<td><b>'.number_format($rowz['bank_balance']).'</b></td>';
            echo '<td><center><button style="border:0;background-color:transparent;" onclick="GetBankTransaction('.$rowz['transac_id'].')"><i class="fa fa-pencil fa-2x"></i></button></center></td>';
            echo '</tr>';
        }
    }
    public static function RETURN_TRANSACTIONS(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM bank_transaction WHERE transac_id='".$_GET['getbanktransaction']."'") as $rowz){
            foreach($db->query("SELECT * FROM cashaccounts WHERE coacode='".$rowz['accountid']."'") as $row){
                foreach($db->query("SELECT * FROM level4 WHERE level3code='".$row['coacode']."'") as $rows){}
            }
            $da = explode("-",$rowz['transactiondate']);
            $date = $da[1]."/".$da[2]."/".$da[0];
            echo '
            <div hidden id="banktracteditcode">'.$_GET['getbanktransaction'].'</div>
            <label class="labelcolor">Bank Account</label>
            <select onchange="" id="bankaccountcode" class="selectpicker show-tick form-control" data-live-search="true">
                <option value="'.(($row['coacode'])?$row['coacode']:"").'">'.(($row['coacode'])?$rows['level3name'].'&nbsp;&nbsp;&nbsp;'.$row['descno']:"").'</option>';
            CASHACCOUNT::GET_BANKACCOUNT();
            echo'
            </select><br>
            <label class="labelcolor">Slip No.</label>
            <input onclick="" id="slipno" type="text" value="'.$rowz['slipno'].'" class="form-control" placeholder="Enter Slip No."><br>
            <label class="labelcolor">Transaction Type</label>
            <select id="transactiontype" class="form-control">
            <option value="'.(($rowz['type'])?$rowz['type']:"").'">'.(($rowz['type']=='1')?'Deposit':(($rowz['type']=="2")?'Withdraw':"")).'</option>
                <option value="1">Deposit</option>
                <option value="2">Withdraw</option>
            </select><br>
            <label class="labelcolor">Transaction Charges</label>
            <input onclick="" id="transactioncharge" type="number" value="'.$rowz['feesamount'].'" class="form-control" placeholder="Enter Transaction Charges"><br>
            <label class="labelcolor">Transaction Amount</label>
            <input onclick="" id="transactionamount" type="number" value="'.$rowz['amount'].'" class="form-control" placeholder="Enter Transaction Amount"><br>
            <label class="labelcolor">Transaction Date</label>
            <input onclick="" id="datepicker" type="text" value="'.$date.'" class="form-control" placeholder="Enter Transaction Date"><br><br>
            <center>
                <button class="btn-primary btn" type="" onclick="SaveBankTransaction()">Submit Transaction</button>
                <button onclick="ClearBANKTRANCS()" type="reset" class="btn btn-default">Cancel</button>
            </center> <br><br>
        ';
        }
    }
    public static function CANCEL_TRANSACTIONS(){
        echo '
            <div hidden id="banktracteditcode"></div>
            <label class="labelcolor">Bank Account</label>
            <select onchange="" id="bankaccountcode" class="selectpicker show-tick form-control" data-live-search="true">
                <option value="">select Bank Account</option>';
        CASHACCOUNT::GET_BANKACCOUNT();
        echo'
            </select><br>
            <label class="labelcolor">Slip No.</label>
            <input onclick="" id="slipno" type="" class="form-control" placeholder="Enter Slip No."><br>
            <label class="labelcolor">Transaction Type</label>
            <select id="transactiontype" class="form-control">
                <option value="">select Transaction Type</option>
                <option value="1">Deposit</option>
                <option value="2">Withdraw</option>
            </select><br>
            <label class="labelcolor">Transaction Charges</label>
            <input onclick="" id="transactioncharge" type="number" class="form-control" placeholder="Enter Transaction Charges"><br>
            <label class="labelcolor">Transaction Amount</label>
            <input onclick="" id="transactionamount" type="number" class="form-control" placeholder="Enter Transaction Amount"><br>
            <label class="labelcolor">Transaction Date</label>
            <input onclick="" id="datepicker" type="text" class="form-control" placeholder="Enter Transaction Date"><br><br>
            <center>
                <button class="btn-primary btn" type="" onclick="SaveBankTransaction()">Submit Transaction</button>
                <button onclick="ClearBANKTRANCS()" type="reset" class="btn btn-default">Cancel</button>
            </center> <br><br>
        ';
    }
}
class DEPOSIT_TRANSACTION extends database_crud {
    protected $table="deposits";
    protected $pk="depositid";

    //  SELECT `depositid`, `clientid`, `depositor`, `amount`, `amount_inwords`, `e_tag`, `inserteddate`,
    //  `modifieddate`, `user_handle`, `balance` FROM `deposits` WHERE 1

    public static function MAKE_DEPOSIT(){
        $deposit = new DEPOSIT_TRANSACTION(); $db = new DB();
        session_start();  NOW_DATETIME::NOW(); $chart = new POST_CHART();
        $merge = new MERGERWD();   GENERAL_SETTINGS::GEN();
        $data = explode("?::?",$_GET['savedeposit']);
        $message = "";
		
        // saving handler algorithm
        $tracsaveitem = explode(",",$data[3]);
        $tracsaveamt = explode(",",$data[4]);
	
        for($t = 0;$t <= count($tracsaveitem); $t++){
            if($tracsaveitem[$t] == "1" || $tracsaveitem[$t] == "8"){
                $db->query("UPDATE clients SET savingaccount = savingaccount + '".$tracsaveamt[$t]."' WHERE clientid = '".$data[1]."'");
                foreach ($db->query("SELECT * FROM clients WHERE clientid = '".$data[1]."'") as $row){$savingbalnce = $row['savingaccount'];}
            }else{
                foreach ($db->query("SELECT * FROM clients WHERE clientid = '".$data[1]."'") as $row){$savingbalnce = $row['savingaccount'];}
            }
			if($savingbalnce < 0){
				$overdraftamt = $tracsaveamt[$t] - $savingbalnce;
				foreach($db->query("SELECT * FROM overdrafts WHERE clientid='".$data[1]."' AND status='1'") as $rows){}
				if($rows['clientid']){
					$db->query("UPDATE overdrafts SET overdraftamt = overdraftamt - '".$tracsaveamt[$t]."' WHERE clientid = '".$data[1]."' AND status='1'");
				}else{
					$db->query("UPDATE overdrafts SET overdraftamt = '0' , status='0' WHERE clientid = '".$data[1]."'");
				}
			}else{
				$db->query("UPDATE overdrafts SET overdraftamt = '0' , status='0' WHERE clientid = '".$data[1]."'");
			}
        }
		
        // share handle
        for($t = 0;$t <= count($tracsaveitem); $t++){
            if($tracsaveitem[$t] == "2"){
                $db->query("UPDATE clients SET shareaccount_amount = shareaccount_amount + '".$tracsaveamt[$t]."' WHERE clientid = '".$data[1]."'");
                $db->query("UPDATE clients SET numberofshares = numberofshares + '".($tracsaveamt[$t]/GENERAL_SETTINGS::$sharevalue)."' WHERE clientid = '".$data[1]."'");
                foreach ($db->query("SELECT * FROM clients WHERE clientid = '".$data[1]."'") as $row){$savingbalnce = $row['savingaccount']; $sharebal = $row['shareaccount_amount'];}
            }
        }
        // loan repayment
        for($t = 0;$t <= count($tracsaveitem); $t++){
            if($tracsaveitem[$t] == "3"){
                foreach ($db->query("SELECT * FROM clients WHERE clientid='".$data[1]."'") as $clnt){
                    if(($clnt['loanaccount'] - $tracsaveamt[$t]) <= "0"){
                        $difft = -($clnt['loanaccount'] - $tracsaveamt[$t]);
                        $db->query("UPDATE clients SET savingaccount = savingaccount + '".$difft."' WHERE clientid = '".$data[1]."'");
                        $db->query("UPDATE clients SET clientdataid = '0' , loanaccount = '0' WHERE clientid = '".$data[1]."'");
                    }else{
                        $db->query("UPDATE clients SET loanaccount = loanaccount - '".$tracsaveamt[$t]."' WHERE clientid = '".$data[1]."'");
                    }

                    
                    if($clnt['clientdataid']=="1"){
                        foreach ($db->query("SELECT * FROM clients WHERE clientid = '".$data[1]."'") as $row){$loanaccount = $row['loanaccount'];}
                        $lnstat = new LOANSTATBALS();
                        $lnstat->clientid = $data[0];
                        $lnstat->amount = $data[2];
                        $lnstat->balance = $loanaccount;
                        $lnstat->handle = $_SESSION['user_id'];
                        $lnstat->paydate = NOW_DATETIME::$Date_Time;
                        $lnstat->create();
                    }else{
                        foreach ($db->query("SELECT * FROM loan_approvals WHERE disburse='1' AND member_id='".$data[1]."'") as $row){
                            foreach ($db->query("SELECT * FROM loan_schedules WHERE approveid='".$row['desc_id']."'") as $rows){
                                foreach ($db->query("SELECT * FROM clients WHERE clientid = '".$data[1]."'") as $row){$loanaccount = $row['loanaccount'];}
                                $repay = new LOAN_REPAYMENT();
                                $repay->sheduleid     = $rows['schudele_id'];
                                $repay->amount        = $tracsaveamt[$t];
                                $repay->loanbals      = $loanaccount;
                                $repay->repay_type    = "1";
                                $repay->interestbal   = $clnt['loan_interest'];
                                $repay->interestpaid   = $clnt['loan_interest'];
                                $repay->inserted_date = NOW_DATETIME::$Date_Time;
                                $repay->create();
                            }
                        }
                        if(($clnt['loanaccount'] - $data[2]) < "0"){
                            $db->query("UPDATE loan_approvals SET disburse = '2' WHERE member_id = '".$data[1]."'");
                            $db->query("UPDATE loan_schedules SET loanstatus = '1' WHERE schudele_id = '".$rows['schudele_id']."'");
                        }else{
                            if(($clnt['loanaccount'] - $data[2]) == "0"){
                                $db->query("UPDATE loan_approvals SET disburse = '2' WHERE member_id = '".$data[1]."'");
                                $db->query("UPDATE loan_schedules SET loanstatus = '1' WHERE schudele_id = '".$rows['schudele_id']."'");
                            }
                        }
                    }
//                    if($clnt['clientdataid']=="1"){
//                        foreach ($db->query("SELECT * FROM clients WHERE clientid = '".$data[1]."'") as $row){$loanaccount = $row['loanaccount'];}
//                        $lnstat = new LOANSTATBALS();
//                        $lnstat->clientid = $data[1];
//                        $lnstat->amount = $tracsaveamt[$t];
//                        $lnstat->balance = $loanaccount;
//                        $lnstat->handle = $_SESSION['user_id'];
//                        $lnstat->paydate = NOW_DATETIME::$Date_Time;
//                        $lnstat->create();
//                    }else{
//                        foreach ($db->query("SELECT * FROM loan_approvals WHERE disburse='1' AND member_id='".$data[1]."'") as $row){
//                            foreach ($db->query("SELECT * FROM loan_schedules WHERE approveid='".$row['desc_id']."'") as $rows){
//                                        $data6 = SYS_CODES::split_on($rows['reviewdate'],1);
//                                        $data1 = SYS_CODES::split_on($rows['paycheck'],1);
//                                        $data2 = SYS_CODES::split_on($rows['total'],1);
//                                        $data3 = SYS_CODES::split_on($rows['loanbal'],1);
//                                        $data4 = SYS_CODES::split_on($rows['fines'],1);
//                                        $data5 = SYS_CODES::split_on($rows['principal'],1);
//                                        $repaydate = explode(",",$data6[1]);
//                                        $repaycheck = explode(",",$data1[1]);
//                                        $repayamt = explode(",",$data2[1]);
//                                        $loanbal = explode(",",$data3[1]);
//                                        $finescheck = explode(",",$data4[1]);
//                                        $principal = explode(",",$data5[1]);
//                                        $dates = NOW_DATETIME::$Date;
//                                        $sloanbal = ""; $spaycheck = "";
//                                        $amt = $tracsaveamt[$t];
//                                        for($i = 0;$i < count($repaydate); $i++ ){
//                                                if($repaycheck[$i]=="0"){
//                                                        $diff= $repayamt[$i]-$loanbal[$i];
//                                                        if($amt >= $diff){
//                                                                $sloanbal .=",".$repayamt[$i];
//                                                                $spaycheck .=","."1";
//                                                                $amt -=$diff;
//                                                        }else{
//                                                                $spaycheck .=","."0";
//                                                                $sloanbal .=",".($amt+$loanbal[$i]);
//                                                                $amt='0';
//                                                        }
//                                                }else{
//                                                        $sloanbal .=",".$loanbal[$i];
//                                                        $spaycheck .=",".$repaycheck[$i];
//                                                }
//                                        }
//
//                                        $db->query("UPDATE loan_schedules SET
//                                                                                                paycheck = '".$spaycheck."',
//                                                                                                loanbal = '".$sloanbal."'
//                                                                                                WHERE schudele_id = '".$rows['schudele_id']."'");
//                                        foreach ($db->query("SELECT * FROM clients WHERE clientid = '".$data[1]."'") as $rowt){$savingbalnce = $rowt['savingaccount'];}
//                                        CLIENT_DATA::$clientid = $data[1];
//                                        CLIENT_DATA::CLIENTDATAMAIN();
//                                        $interestamt="0";$totprinc="0";
//                                        foreach ($db->query("SELECT * FROM loan_schedules WHERE approveid='".$row['desc_id']."'") as $rowz){
//                                                $repaycheck1 = explode(",",$rowz['paycheck']);
//                                                $repayamt1 = explode(",",$rowz['total']);
//                                                $loanbal1 = explode(",",$rowz['loanbal']);
//                                                $intra = explode(",",$rowz['interest']);
//                                                $princ= explode(",",$rowz['principal']);
//                                                for($i = 1;$i < count($repaycheck1); $i++ ){
//                                                        if($repaycheck1[$i]=="0"){
//                                                                if($loanbal1[$i] > $princ[$i]){
//                                                                        $interestamt += ($intra[$i] - ($loanbal1[$i] - $princ[$i]));
//                                                                        $totprinc +=  0;
//                                                                }else{
//                                                                        if($loanbal1[$i] < $princ[$i] && $loanbal1[$i] > 0){
//                                                                                $interestamt += $intra[$i];
//                                                                                $totprinc +=  ($princ[$i]-$loanbal1[$i]);
//                                                                        }else{
//                                                                                $interestamt += $intra[$i];
//                                                                                $totprinc +=  $princ[$i];
//                                                                        }
//                                                                }
//                                                        }
//
//                                                }
//                                        }
//
//                                        $repay = new LOAN_REPAYMENT();
//                                        $repay->sheduleid     = $rows['schudele_id'];
//                                        $repay->amount        = $tracsaveamt[$t];
//                                        $repay->loanbals      = CLIENT_DATA::$loanaccount;
//                                        $repay->repay_type    = "1";
//                                        $repay->interestbal   = $interestamt;
//                                        $repay->interestpaid   = (($rowz['totalinterest'] <= "0")?"0":"".($rowz['totalinterest'] - $interestamt)."");
//                                        $repay->princbal      = $totprinc;
//                                        $repay->inserted_date = NOW_DATETIME::$Date_Time;
//                                        $repay->create();
//                                        $db->query("UPDATE loan_schedules SET
//                                                        totalprinc = '".$totprinc."',
//                                                        totalinterest = '".$interestamt."'
//                                                        WHERE schudele_id = '".$rows['schudele_id']."'");
//
//                                }
//                        }
//
//                        if(($clnt['loanaccount'] - $tracsaveamt[$t]) < "0"){
//                            $db->query("UPDATE loan_approvals SET disburse = '2' WHERE member_id = '".$data[1]."'");
//                            $db->query("UPDATE loan_schedules SET loanstatus = '1' WHERE schudele_id = '".$rows['schudele_id']."'");
//                        }else{
//                            if(($clnt['loanaccount'] - $tracsaveamt[$t]) == "0"){
//                                $db->query("UPDATE loan_approvals SET disburse = '2' WHERE member_id = '".$data[1]."'");
//                                $db->query("UPDATE loan_schedules SET loanstatus = '1' WHERE schudele_id = '".$rows['schudele_id']."'");
//                            }
//                        }
//                    }

                }
                
            }
        }
        
        for($t = 0;$t <= count($tracsaveitem); $t++){
            if (strpos($tracsaveitem[$t], "charges") !== false) {
                $dataxx = explode("charges",$tracsaveitem[$t]);
                if($dataxx[1]=="2"){ $datasss = $data[1];

                    $db->query("UPDATE clients SET loan_fines = loan_fines - '".$tracsaveamt[$t]."' WHERE clientid = '".$data[1]."'");
                    foreach ($db->query("SELECT * FROM loan_schedules s, loan_approvals a WHERE a.desc_id=s.approveid AND a.member_id='".$data[1]."'") as $rows){}
                    
                    if($rows['finetotal'] != "0"){ //$message .= ".".$tracsaveamt[$t]."..".$rows['finetotal'];
                        if($tracsaveamt[$t]<=$rows['finetotal']){ 
                            $db->query("UPDATE loan_schedules SET finetotal = finetotal - '".$tracsaveamt[$t]."' WHERE schudele_id = '".$rows['schudele_id']."'");
                        }
                        foreach ($db->query("SELECT * FROM loan_schedules s, loan_approvals a WHERE a.desc_id=s.approveid AND a.member_id='".$data[1]."'") as $rows){}
                        $fines = new LOAN_FINES();
                        $fines->sheduleid     = $rows['schudele_id'];
                        $fines->amount        = $tracsaveamt[$t];
                        $fines->balance       = $rows['finetotal'];
                        $fines->inserted_date = NOW_DATETIME::$Date_Time;
                        $fines->create();
                    }

                }else if($dataxx[1]=="3"){ 
                    $datasss = $data[1];
                    $db->query("UPDATE clients SET loan_interest = loan_interest - '".$tracsaveamt[$t]."' WHERE clientid = '".$data[1]."'");      
                    $ln = new LOANINTEREST();
                    $ln->clientid =  $data[1];
                    $ln->amount  = $tracsaveamt[$t];
                    $ln->create();
                }else{
                    $charges = new OTHER_CHARGESTRANSACTIONS();
                    $charges->otherid     = $dataxx[1];
                    $charges->amount        = $tracsaveamt[$t];
                    $charges->clientid      = $data[1];
                    $charges->inserted_date = NOW_DATETIME::$Date_Time;
                    $charges->create();
                }
            }

        }

        CLIENT_DATA::$clientid = $data[1];  CLIENT_DATA::CLIENTDATAMAIN();
        foreach ($db->query("SELECT * FROM clients WHERE clientid = '".$data[1]."'") as $row){$lnbal = $row['loanaccount'];}
        $deposit->clientid = $data[1];
        $deposit->depositor = $data[2];
        $deposit->amount = $data[0];
        $deposit->amount_inwords = $data[0];
        $deposit->e_tag = "0";
        $deposit->inserteddate = NOW_DATETIME::$Date;
        $deposit->modifieddate = NOW_DATETIME::$Date_Time;
        $deposit->user_handle = $_SESSION['user_id'];
        $deposit->depositeditems = $data[3];
        $deposit->depositedamts = $data[4];
        $deposit->balance = CLIENT_DATA::$savingaccount;
        $deposit->sbal = $sharebal;
        $deposit->lnbal = $lnbal;
        $deposit->create();
        $dept = $deposit->pk;

        $chart->clientid = $data[1];
        $chart->depositeditems = $data[3];
        $chart->depositedamts = $data[4];
        $chart->inserteddate = NOW_DATETIME::$Date;
        $chart->e_tag = "0";
        $chart->userhandle = $_SESSION['user_id'];
        $chart->amount = $data[0];
        $chart->create();


        $merge->transactiontype = "1";
        $merge->transactionid = $dept;
        $merge->insertiondate = NOW_DATETIME::$Date;
        $merge->clientid = $data[1];
        $merge->create();
        echo '
            <table class="table table-bordered" width="100%">
                <tr class="info">
                    <th width="1%">#</th>
                    <th width="59%">Description</th>
                    <th width="40%">Amount</th>
                </tr>
                <tbody>';
        DEPOSIT_CATEGORY::GET_DCATS();
        echo'</tbody>
            </table>
        ';
        $dataxx = explode("charges",$tracsaveitem[$t]);
        echo '|<><>|';
        CLIENT_DATA::$clientid = $data[1];
        CLIENT_DATA::RETURN_TRANSACTIONWD();
        echo '|<><>|';
        CLIENT_DATA::RETURN_CLIENTLEDGER();
        echo '|<><>|';
        CLIENT_DATA::RETURN_GENERALCLIENTLEDGER();
        echo '|<><>|';
        echo $message;
    }

    public static function DETAILED_DEPOSITDESC(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$_GET['transactionid']."'") as $row1){$savingbal = $row1['balance'];}
		CLIENT_DATA::$clientid = $row1['clientid'];
		CLIENT_DATA::CLIENTDATAMAIN();
		
        echo '
		<br>
			<b style="font-weight: 300;font-size: 20px;">'.CLIENT_DATA::$accountname.'</b>
			-
			<b style="font-weight: 300;font-size: 20px;">'.CLIENT_DATA::$accountno.'</b><br>';
		foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$_GET['transactionid']."'") as $row1x){
			echo '<b style="font-weight: 300;font-size: 20px;">'.$row1x['inserteddate'].'</b><br>';
		}	
		echo ' <br><br>
        <table cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n" id="grat1">
                <thead>
                    <tr class="success">
                         <th width = "50%">Deposit Category</th>
                         <th width = "50%">Amount Deposited</th>
                    </tr>
                </thead>
                <tbody>
        ';
        foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$_GET['transactionid']."'") as $row1){
            $dec = explode(",",$row1['depositeditems']);
            $decamt = explode(",",$row1['depositedamts']);
            $descriptions = "";
            for($i = 1; $i<=count($dec); $i++){
                $dataxx = explode("charges",$dec[$i]);
                if($dataxx[1]){
                    foreach ($db->query('SELECT * FROM othercharges WHERE otherid="'.$dataxx[1].'"') as $row){}
                    echo '<tr>';
                    echo '<td> '. $row['oname'].'</td>';
                    echo '<td>'.number_format($decamt[$i]).'</td>';
                    echo '</tr>';
                }else{
                    foreach ($db->query("SELECT * FROM deposit_cats WHERE depart_id='".$dec[$i]."'") as $rowd){
                        echo '<tr>';
                        echo '<td> '. $rowd['deptname'].'</td>';
                        echo '<td>'.number_format($decamt[$i]).'</td>';
                        echo '</tr>';
                    }
                }
            }

        }

        echo'
					<thead>
						<tr>
							<th>Total Deposit Amount: </th>
							<th><b class="pull-right">'.number_format($row1['amount']).' </b></th>
						</tr>
						<tr>
							<th>Saving Balance: </th>
							<th><b class="pull-right">'.number_format($row1['balance']).' </b></th>
						</tr>
					</thead>
				</tbody>
            </table>
            <br>
			';
    }

    public static function DEPOSITCASHCHECK(){	
		$db = new DB(); session_start();  $incash = new INCHARGE_CASHIER();
		
		foreach($db->query("SELECT * FROM cashierincharge WHERE cashier='".$_SESSION['user_id']."'") as $incharge){} 
		if($incharge['cashier']){
			if($incharge['status'] == '0'|| $incharge['status'] == "2"){$message= "1";}else{ $message = "0";}
		}else{
			$incash->cashier = $_SESSION['user_id']; $incash->amount = "0"; $incash->create();
			$message= "1";
		}
		 
		echo $message; 
	}
	
    public static function SHARERECORDS(){
        $db = new DB();  GENERAL_SETTINGS::GEN();
		foreach ($db->query("SELECT * FROM mergerwd ORDER BY mergeid DESC") as $rowt){
		
			if($rowt['transactiontype']=="1"){
				foreach($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."' ORDER BY inserteddate DESC") as $row){
					$tracsaveitem = explode(",",$row['depositeditems']);
					$tracsaveamt = explode(",",$row['depositedamts']);
					for($t = 0;$t <= count($tracsaveitem); $t++){
						if($tracsaveitem[$t] == "2"){
							CLIENT_DATA::$clientid = $rowt['clientid'];
							CLIENT_DATA::CLIENTDATAMAIN();
							echo "<tr>";
							echo "<td data-order='2017-00-00'>".$rowt['insertiondate']."</td>";
							echo "<td data-order='1'>".CLIENT_DATA::$accountname." <br> <b>(".CLIENT_DATA::$accountno.")</b></br></td>";
							echo "<td><b>Deposited Share</b></td>";
							echo "<td>Amount : <b>".number_format($tracsaveamt[$t])."</b><br>No. : <b>".$tracsaveamt[$t]/GENERAL_SETTINGS::$sharevalue."</b></td>";
							echo "</tr>";
						}
					}

				}
			}
			if($rowt['transactiontype']=="6"){
				foreach ($db->query("SELECT * FROM noncashtracs WHERE nontracid='".$rowt['transactionid']."'") as $row1){
					
					if($row1['accountcode']=="2"){
						
						CLIENT_DATA::$clientid = $rowt['clientid'];
						CLIENT_DATA::CLIENTDATAMAIN();
						echo "<tr>";
						echo "<td data-order='2017-00-00'>".$rowt['insertiondate']."</td>";
						echo "<td data-order='1'>".CLIENT_DATA::$accountname." <br> <b>(".CLIENT_DATA::$accountno.")</b></br></td>";
						echo "<td><b>Non Cash Deposited Share</b></td>";
						echo "<td>Amount : <b>".number_format($row1['amount'])."</b><br>No. : <b>".$row1['amount']/GENERAL_SETTINGS::$sharevalue."</b></td>";
						echo "</tr>";
					}
				}
			}
			if($rowt['transactiontype']=="7"){
				foreach($db->query("SELECT * FROM sharetransferecords WHERE transferid ='".$rowt['transactionid']."'") as $row2){
		
					if($row2['toclient'] == $rowt['clientid']){
						CLIENT_DATA::$clientid = $rowt['clientid'];
						CLIENT_DATA::CLIENTDATAMAIN();
						echo "<tr>";
						echo "<td data-order='2017-00-00'>".$rowt['insertiondate']."</td>";
						echo "<td data-order='1'>".CLIENT_DATA::$accountname." <br> <b>(".CLIENT_DATA::$accountno.")</b></br></td>";
						echo "<td><b>Purchased Shares</b></td>";
						echo "<td>Amount : <b>".number_format($row2['amount'])."</b><br>No. : <b>".$row2['amount']/GENERAL_SETTINGS::$sharevalue."</b></td>";
						echo "</tr>";
					}
					if($row2['fromclient'] == $rowt['clientid']){
						CLIENT_DATA::$clientid = $rowt['clientid'];
						CLIENT_DATA::CLIENTDATAMAIN();
						echo "<tr>";
						echo "<td data-order='2017-00-00'>".$rowt['insertiondate']."</td>";
						echo "<td data-order='1'>".CLIENT_DATA::$accountname." <br> <b>(".CLIENT_DATA::$accountno.")</b></br></td>";
						echo "<td><b>Sold Shares</b></td>";
						echo "<td>Amount : <b>".number_format($row2['amount'])."</b><br>No. : <b>".$row2['amount']/GENERAL_SETTINGS::$sharevalue."</b></td>";
						echo "</tr>";
					}
					
				} 
			}
		}	
    }
}
class FINANCIALSTATEMENTS{
	public static function PROFIT_LOSS(){
		$db = new DB(); NOW_DATETIME::NOW();
		$fees = "0"; $pasbk = "0"; $income = "0"; $expense = "0"; $interestamt = "0";
		$data = explode("?::?",$_GET['profitnloss']);
		$yrs = (($data[0])?$data[0]:NOW_DATETIME::$year);
		$totamt = "0";
		foreach ($db->query("SELECT * FROM mergerwd ORDER BY mergeid DESC") as $rowt){
			if($rowt['transactiontype']=="1"){
				foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."' && YEAR(inserteddate)='".$yrs."' AND MONTHNAME(inserteddate)='".$data[1]."'") as $row1){
					$dec = explode(",",$row1['depositeditems']);
					$fig = explode(",",$row1['depositedamts']);
					$descriptions = "";
					for($i = 1; $i<=count($dec); $i++){
						if($dec[$i]=="4"){
							$totamt  = $totamt + $fig[$i];
						}
						if($dec[$i]=="5"){
							$totamt  = $totamt + $fig[$i];
						}
					}
					
				}
			}				
			if($rowt['transactiontype']=="4"){
				foreach ($db->query("SELECT * FROM loan_insurance WHERE ins_id='".$rowt['transactionid']."' && YEAR(inserted_date)='".$yrs."' AND MONTHNAME(inserted_date)='".$data[1]."'") as $row1){
					$lpf  = $lpf + $row1['amount'];
				}
			}
			if($rowt['transactiontype']=="5"){
				foreach ($db->query("SELECT * FROM loan_processcharges WHERE charge_id='".$rowt['transactionid']."' && YEAR(inserted_date)='".$yrs."' AND MONTHNAME(inserted_date)='".$data[1]."'") as $row1){
					$processcharge  = $processcharge + $row1['amount'];
				}
			}					
		}
		foreach($db->query("SELECT * FROM loan_schedules s, loan_approvals a WHERE a.desc_id=s.approveid AND YEAR(s.disbursed_date)='".$yrs."' AND MONTHNAME(s.disbursed_date)='".$data[1]."'") as $rowx1){
			CLIENT_DATA::$clientid = $rowx1['member_id'];
			CLIENT_DATA::CLIENTDATAMAIN();
			$difft = $rowx1['amount_disb'] - $rowx1['amount_given'];
			$difft1 = $rowx1['amount_disb'] - CLIENT_DATA::$loanaccount; 
			if($difft1 > $difft){ $interestamt += $difft; } 
			$difft = "0";
		}
		foreach($db->query("SELECT SUM(amount) as amts FROM loan_fines WHERE YEAR(inserted_date)='".$yrs."' AND MONTHNAME(inserted_date)='".$data[1]."'") as $rowx2){}
		foreach($db->query("SELECT SUM(amount) as mnths FROM monthlycharges WHERE YEAR(mdate)='".$yrs."' AND MONTHNAME(mdate)='".$data[1]."'") as $rowx3){}
		foreach($db->query("SELECT SUM(amount) as procs FROM loan_processcharges WHERE YEAR(inserted_date)='".$yrs."' AND MONTHNAME(inserted_date)='".$data[1]."'") as $rowx4){}
		foreach($db->query("SELECT SUM(amount) as insu FROM loan_insurance WHERE YEAR(inserted_date)='".$yrs."' AND MONTHNAME(inserted_date)='".$data[1]."'") as $rowx5){}
		foreach ($db->query("SELECT * FROM mergerwd WHERE YEAR(insertiondate)='".$yrs."' AND MONTHNAME(insertiondate)='".$data[1]."' ORDER BY mergeid DESC") as $rowt){					
			if($rowt['transactiontype']=="1"){
				foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."' && YEAR(inserteddate)='".$yrs."' AND MONTHNAME(inserteddate)='".$data[1]."'") as $row1){
					$dep = $dep + $row1['amount'];
					$dec = explode(",",$row1['depositeditems']);
					$fig = explode(",",$row1['depositedamts']);
					$descriptions = "";
					for($i = 1; $i<=count($dec); $i++){
						if($dec[$i]=="4"){
							$fees = $fees + $fig[$i];
						}
						
						if($dec[$i]=="5"){
							$app = $app + $fig[$i];
						}

						if($dec[$i]=="6"){
							$mbr = $mbr + $fig[$i];
						}
						
						if($dec[$i]=="7"){
							$pasbk = $pasbk + $fig[$i];
						}
						$dataxx = explode("charges",$dec[$i]);
						if($dataxx[1]=="1"){
							foreach ($db->query('SELECT * FROM othercharges WHERE  otherid="'.$dataxx[1].'"') as $row){
								if($row['oname']=="bank charges"){
									$bankcharge = $bankcharge  + $fig[$i];
								}
								if($row['oname']=="Loan Fines"){
									$loanfine= $loanfine  + $fig[$i];
								}
								if($row['oname']=="Loan Interest"){
									$loaninterest = $loaninterest  + $fig[$i];
								}
								if($row['oname']=="Ledger Card"){
									$Ledger = $Ledger  + $fig[$i];
								}
								if($row['oname']=="Passbook"){
									$pasbk1 = $pasbk1  + $fig[$i];
								}
								if($row['oname']=="Deposit Slip"){
									$depositslip = $depositslip  + $fig[$i];
								}
								if($row['oname']=="Withdraw Slip"){
									$withd = $withd  + $fig[$i];
								}

								$oamt = $oamt + $fig[$i];
							}
							
						}
					}
				}		
			}
		}
		$incomeitems = $fees + $app + $mbr + $rowx3['mnths'] + $rowx4['procs']+ $lpf + $processcharge;
		$income = $incomeitems + $pasbk + $interestamt + $oamt;
		
		echo '
			<table cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
				<thead>
					<tr>
						<th width="60%">Particulars</th>
						<th width="40%">Amount</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><b>INCOME</b></td>
						<td></td>
					</tr>
					<tr>
						<td>Interest On Loans</td>
						<td>'.number_format($interestamt).'</td>
					</tr>
					<tr>
						<td>Loan Protection Fees</td>
						<td>'.number_format($fees).'</td>
					</tr>
					<tr>
						<td>Loan Application Fees</td>
						<td>'.number_format($app).'</td>
					</tr>
					<tr>
						<td>MemberShip Fees</td>
						<td>'.number_format($mbr).'</td>
					</tr>
					<tr>
						<td>Pass Book / Stationary</td>
						<td>'.number_format($pasbk).'</td>
					</tr>
					<tr>
						<td>Bank Charges</td>
						<td>'.number_format($bankcharge).'</td>
					</tr>
					<tr>
						<td>Loan Interest</td>
						<td>'.number_format($loaninterest).'</td>
					</tr>
					<tr>
						<td>Ledger Card</td>
						<td>'.number_format($Ledger).'</td>
					</tr>
					<tr>
						<td>Deposit Slip</td>
						<td>'.number_format($depositslip).'</td>
					</tr>
					<tr>
						<td>Withdraw Slip</td>
						<td>'.number_format($withd).'</td>
					</tr>
					<tr>
						<td>Pass Books</td>
						<td>'.number_format($pasbk1).'</td>
					</tr>
					<tr>
						<td>Loan Protection Fees (NC)</td>
						<td>'.number_format($lpf).'</td>
					</tr>
					<tr>
						<td>Loan Process Charges (NC)</td>
						<td>'.number_format($processcharge).'</td>
					</tr>';
					foreach ($db->query("SELECT SUM(amount) as amount FROM noncashtracs WHERE accountcode='5'  AND MONTHNAME(ndate)='".$data[1]."' AND YEAR(ndate)='".$data[0]."'") as $rownoc){
						echo '<tr>';
						echo '<td>Loan Application Fee (NC)</td>';
						echo '<td>'.number_format($rownoc['amount']).'</td>';
						echo '</tr>';
						$income +=$rownoc['amount'];
					}
					foreach ($db->query("SELECT SUM(amount) as amount FROM noncashtracs WHERE accountcode='6'  AND MONTHNAME(ndate)='".$data[1]."' AND YEAR(ndate)='".$data[0]."'") as $rownoc){
						echo '<tr>';
						echo '<td>MemberShip Fee (NC)</td>';
						echo '<td>'.number_format($rownoc['amount']).'</td>';
						echo '</tr>';
						$income +=$rownoc['amount'];
					}
					foreach ($db->query("SELECT SUM(amount) as amount FROM noncashtracs WHERE accountcode='7'  AND MONTHNAME(ndate)='".$data[1]."' AND YEAR(ndate)='".$data[0]."'") as $rownoc){
						echo '<tr>';
						echo '<td>Pass Book / Stationary (NC)</td>';
						echo '<td>'.number_format($rownoc['amount']).'</td>';
						echo '</tr>';
						$income +=$rownoc['amount'];
					}
					foreach ($db->query("SELECT SUM(amount) as amount FROM noncashtracs WHERE accountcode='9' AND MONTHNAME(ndate)='".$data[1]."' AND YEAR(ndate)='".$data[0]."'") as $rownoc){
						echo '<tr>';
						echo '<td>Loan Penalty (NC)</td>';
						echo '<td>'.number_format($rownoc['amount']).'</td>';
						echo '</tr>';
						$income +=$rownoc['amount'];
					}
					foreach ($db->query("SELECT SUM(amount) as amount FROM noncashtracs WHERE accountcode='10' AND MONTHNAME(ndate)='".$data[1]."' AND YEAR(ndate)='".$data[0]."'") as $rownoc){
						echo '<tr>';
						echo '<td>Loan Recovery (NC)</td>';
						echo '<td>'.number_format($rownoc['amount']).'</td>';
						echo '</tr>';
						$income +=$rownoc['amount'];
					}
					foreach ($db->query("SELECT SUM(amount) as amount FROM noncashtracs WHERE accountcode='11' AND MONTHNAME(ndate)='".$data[1]."' AND YEAR(ndate)='".$data[0]."'") as $rownoc){
						echo '<tr>';
						echo '<td>Loan Interest (NC)</td>';
						echo '<td>'.number_format($rownoc['amount']).'</td>';
						echo '</tr>';
						$income +=$rownoc['amount'];
					}
					foreach ($db->query("SELECT SUM(amount) as amount FROM noncashtracs WHERE accountcode='12' AND MONTHNAME(ndate)='".$data[1]."' AND YEAR(ndate)='".$data[0]."'") as $rownoc){
						echo '<tr>';
						echo '<td>Pass Book (NC)</td>';
						echo '<td>'.number_format($rownoc['amount']).'</td>';
						echo '</tr>';
						$income +=$rownoc['amount'];
					}
					foreach ($db->query("SELECT SUM(amount) as amount FROM noncashtracs WHERE accountcode='13' AND MONTHNAME(ndate)='".$data[1]."' AND YEAR(ndate)='".$data[0]."'") as $rownoc){
						echo '<tr>';
						echo '<td>Ledger Book (NC)</td>';
						echo '<td>'.number_format($rownoc['amount']).'</td>';
						echo '</tr>';
						$income +=$rownoc['amount'];
					}
					foreach ($db->query("SELECT SUM(amount) as amount FROM noncashtracs WHERE accountcode='14' AND MONTHNAME(ndate)='".$data[1]."' AND YEAR(ndate)='".$data[0]."'") as $rownoc){
						echo '<tr>';
						echo '<td>Withdraw Book (NC)</td>';
						echo '<td>'.number_format($rownoc['amount']).'</td>';
						echo '</tr>';
						$income +=$rownoc['amount'];
					}
					foreach ($db->query("SELECT SUM(amount) as amount FROM monthlycharges WHERE MONTHNAME(mdate)='".$data[1]."' AND YEAR(mdate)='".$data[0]."'") as $rowm){
						echo '<tr>';
						echo '<td>Monthly Charge (NC)</td>';
						echo '<td>'.number_format($rowm['amount']).'</td>';
						echo '</tr>';
						$income +=$rowm['amount'];
					}

					foreach ($db->query("SELECT SUM(amount) as amount FROM legal_fees WHERE YEAR(inserted_date)='".$yrs."' AND MONTHNAME(inserted_date)='".$data[1]."'") as $rowl){
						echo '<tr>';
						echo '<td>Loan Legal Fees (NC)</td>';
						echo '<td>'.number_format($rowl['amount']).'</td>';
						echo '</tr>';
						$income +=$rowl['amount'];
					}
					foreach($db->query("SELECT DISTINCT(accountcode) as accountcode FROM incometrail WHERE YEAR(income_date)='".$yrs."' AND MONTHNAME(income_date)='".$data[1]."'") as $rowcrd){
						foreach($db->query("SELECT SUM(amount) as amount FROM incometrail WHERE accountcode='".$rowcrd['accountcode']."' AND YEAR(income_date)='".$yrs."' AND MONTHNAME(income_date)='".$data[1]."'") as $rowcrdamt){}
						SECTIONS::$search_code = $rowcrd['accountcode'];
						SECTIONS::SEARCH_CODE();
						echo "<tr>";
						echo "<td>".SECTIONS::$resultname."</td>";
						echo "<td>".number_format($rowcrdamt['amount'])."</td>";
						echo "</tr>";
					}
					$income +=$rowcrdamt['amount'];
					echo'
					<tr>
						<td><b>TOTAL INCOMES</b></td>
						<td><b>'.number_format($income).'</b></td>
					</tr>
					<tr>
						<td><b>EXPENDITURE</b></td>
						<td></td>
					</tr>';
				foreach ($db->query("SELECT DISTINCT(expensecode) as expcode FROM expensestracs WHERE YEAR(boughtdate)='".$yrs."' AND MONTHNAME(boughtdate)='".$data[1]."'") as $rowh){
					SECTIONS::$search_code = $rowh['expcode'];
					SECTIONS::SEARCH_CODE();
					foreach ($db->query("SELECT SUM(paidamount) as amts FROM expensestracs WHERE expensecode='".$rowh['expcode']."' AND YEAR(boughtdate)='".$yrs."' AND MONTHNAME(boughtdate)='".$data[1]."'") as $row){}
					echo '
						<tr>
							<td>'.SECTIONS::$resultname.'</td>
							<td>'.number_format($row['amts']).'</td>
						</tr>
					';
				}
				foreach ($db->query("SELECT * FROM expensestracs WHERE YEAR(boughtdate)='".$yrs."' AND MONTHNAME(boughtdate)='".$data[1]."'") as $rowh1){
					$expense = $expense + $rowh1['paidamount'];
				}
				$prft = $income - $expense;
		echo'			<tr>
						<td><b>TOTAL EXPENDITURES</b></td>
						<td><b>'.number_format($expense).'</b></td>
					</tr>
					<tr>
						<td><b>PROFIT / LOSS</b></td>
						<td><b>'.(($prft < "0")?"(".number_format(-$prft).")":number_format($prft)).'</b></td>
					</tr>
				</tbody>
			</table>
		';
	}
	
	public static function TRIALBALANCE(){
		$db = new DB(); NOW_DATETIME::NOW();
		
		$currentassetvalue = "0";
		foreach($db->query("SELECT * FROM assets") as $rowasset){
			$depdate = explode(",",$rowasset['years']);
			$assetval = explode(",",$rowasset['valueby_year']);
			$actdate = "";
			for($i = 1;$i < count($depdate); $i++ ){
					NOW_DATETIME::NOW();
					$datadate = explode("-",$depdate[$i]);
					
					if($datadate[0] == NOW_DATETIME::$year){
						$dateint = new DateTime($depdate[$i]);
						$dateint->add(new DateInterval('P1Y'));
						$actdate = $dateint->format('Y-m-d');
					}
					
					if($depdate[$i] >= NOW_DATETIME::$Date && $depdate[$i] < $actdate){
						$currentassetvalue += $assetval[$i];
						$actdate = "";
					}else if($depdate[$i] == $actdate){
						$currentassetvalue += $assetval[$i];
						$actdate = "";
					}else{
						
					}
			}
		}
		
		$fees = "0"; $pasbk = "0"; $income = "0"; $expense = "0";
		$totamt = "0";
		foreach ($db->query("SELECT * FROM mergerwd ORDER BY mergeid DESC") as $rowt){
						
				if($rowt['transactiontype']=="1"){
					foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."'") as $row1){
						$dec = explode(",",$row1['depositeditems']);
						$fig = explode(",",$row1['depositedamts']);
						$descriptions = "";
						for($i = 1; $i<=count($dec); $i++){
							if($dec[$i]=="5"){
								$totamt  = $totamt + $fig[$i];
							}
							
						}
						
					}
				}				
				if($rowt['transactiontype']=="4"){
					foreach ($db->query("SELECT * FROM loan_insurance WHERE ins_id='".$rowt['transactionid']."'") as $row1){
						$totamt  = $totamt + $row1['amount'];
					}
				}
				if($rowt['transactiontype']=="5"){
						foreach ($db->query("SELECT * FROM loan_processcharges WHERE charge_id='".$rowt['transactionid']."'") as $row1){
							$totamt  = $totamt + $row1['amount'];
						}
					}
				
								
		}
		$yrs = (($_GET['profitnloss'])?$_GET['profitnloss']:NOW_DATETIME::$year);
		foreach($db->query("SELECT SUM(interestpaid) as intert FROM loan_repayment WHERE YEAR(inserted_date)='".$yrs."'") as $rowx1){}
		foreach($db->query("SELECT SUM(amount) as amts FROM loan_fines WHERE YEAR(inserted_date)='".$yrs."'") as $rowx2){}
		foreach($db->query("SELECT SUM(amount) as mnths FROM monthlycharges WHERE YEAR(mdate)='".$yrs."'") as $rowx3){}
		foreach($db->query("SELECT SUM(amount) as procs FROM loan_processcharges WHERE YEAR(inserted_date)='".$yrs."'") as $rowx4){}
		foreach($db->query("SELECT SUM(amount) as insu FROM loan_insurance WHERE YEAR(inserted_date)='".$yrs."'") as $rowx5){}
		foreach ($db->query("SELECT * FROM mergerwd WHERE YEAR(insertiondate)='".$yrs."' ORDER BY mergeid DESC") as $rowt){					
			if($rowt['transactiontype']=="1"){
				foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."'") as $row1){
					$dep = $dep + $row1['amount'];
					$dec = explode(",",$row1['depositeditems']);
						$fig = explode(",",$row1['depositedamts']);
						$descriptions = "";
						for($i = 1; $i<=count($dec); $i++){
							if($dec[$i]=="5"){
								$fees = $fees + $fig[$i];
							}

							if($dec[$i]=="6"){
								$fees = $fees + $fig[$i];
							}
							
							if($dec[$i]=="7"){
								$pasbk = $pasbk + $fig[$i];
							}
							$dataxx = explode("charges",$dec[$i]);
							if($dataxx[1]=="1"){
								foreach ($db->query('SELECT * FROM othercharges WHERE  otherid="'.$dataxx[1].'"') as $row){}
								$fees = $fees + $fig[$i];
								
							}

						}
				}
					
			}
		}
		$fees = $fees + $rowx3['mnths'] + $rowx4['procs'] + $totamt;
		$income = $fees + $pasbk + $rowx1['intert'] + $rowx2['amts'] + $rowx5['insu'];
		foreach($db->query("SELECT SUM(loanaccount) as outstanding,SUM(shareaccount_amount) as shrs FROM clients WHERE writeoffstatus='0'") as $rowout){}
		$outbalfig = $rowout['outstanding'];
		$shrfigamt = $rowout['shrs'];
		echo '
			<table cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
				<thead>
					<tr class="success">
						<th width="40%">Particulars</th>
						<th width="30%">DR</th>
						<th width="30%">CR</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><b>FIXED ASSETS</b></td>
						<td></td>
					</tr>
					<tr>
						<td>Non Current Assets</td>
						<td>'.number_format($currentassetvalue).'</td>
						<td></td>
					</tr>
					<tr>
						<td><b>CURRENT ASSETS</b></td>
						<td></td>
					</tr>';
					 VAULT_TRACS::GET_TOTAL();  VAULT_TRACS::GET_TOTAL1();  VAULT_TRACS::GET_TOTAL2(); 
			foreach($db->query("SELECT SUM(amount+dep-withd) as overall, SUM(amount) as amt, SUM(dep) as dep, SUM(withd) as withd FROM cashierincharge") as $overall){ }
					echo '<tr>';
					echo '<td>Cash</td>';
					echo '<td>'.number_format(VAULT_TRACS::$tot+VAULT_TRACS::$tot2+VAULT_TRACS::$tot1+$overall['overall']).'</td>';
					echo '<td></td>';
					echo '</tr>';
			foreach($db->query("SELECT * FROM cashaccounts") as $row){
				foreach($db->query("SELECT * FROM level4 WHERE level3code='".$row['coacode']."'") as $rows){
					echo '<tr>';
					echo '<td>'.$rows['level3name'].'</td>';
					echo '<td>'.number_format($row['descbalance']).'</td>';
					echo '<td></td>';
					echo '</tr>';
				}

			}
					
			echo'
					<tr>
						<td><b>RECIEVABLES</b></td>
						<td></td>
					</tr>
					<tr>
						<td>Loans</td>
						<td>'.number_format($outbalfig).'</td>
						<td></td>
					</tr>';
			foreach($db->query("SELECT DISTINCT(accountcode) as accountcode FROM credit_sale") as $rowcrd){
			foreach($db->query("SELECT * FROM credit_sale WHERE accountcode='".$rowcrd['accountcode']."'") as $rowcrdamt){}
				SECTIONS::$search_code = $rowcrd['accountcode'];
				SECTIONS::SEARCH_CODE();
				echo "<tr>";
				echo "<td data-order='1'>".SECTIONS::$resultname."</td>";
				echo "<td>".number_format($rowcrdamt['receivableamount'])."</td>";
				echo "<td></td>";
				echo "</tr>";
			}
					
			echo'	<tr>
						<td><b></b></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><b>CAPITAL & RESERVES</b></td>
						<td></td>
					</tr>
					<tr>
						<td>Shares</td>
						<td>'.number_format($shrfigamt).'</td>
						<td></td>
					</tr>
					<tr>
						<td><b></b></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td><b>PAYABLES / LIABILITIES</b></td>
						<td></td>
					</tr>';
					$amtz = "0";
			foreach ($db->query("SELECT * FROM clients") as $rowt){$amtz = $amtz + $rowt['savingaccount'];}
				echo '
					<tr>
						<td>Savings</td>
						<td></td>
						<td>'.number_format($amtz).'</td>
					</tr>
				';
			foreach($db->query("SELECT DISTINCT(accountcode) as accountcode FROM credit_purchase") as $rowcrd){
			foreach($db->query("SELECT * FROM credit_purchase WHERE accountcode='".$rowcrd['accountcode']."'") as $rowcrdamt){}
				SECTIONS::$search_code = $rowcrd['accountcode'];
				SECTIONS::SEARCH_CODE();
				echo "<tr>";
				echo "<td data-order='1'>".SECTIONS::$resultname."</td>";
				echo "<td></td>";
				echo "<td>".number_format($rowcrdamt['payableamount'])."</td>";
				echo "</tr>";
			}			
			foreach($db->query("SELECT * FROM borrowings b, financialinstitutions f WHERE f.instid=b.intitutionid ORDER BY borrowingid DESC") as $rowz){
				$date = explode(":",$rowz['inserted_date']);
				echo '<tr>';
				echo '<td>'.$rowz['instname'].'</td>';
				echo '<td></td>';
				echo '<td>'.number_format($rowz['principal']+$rowz['interest']).'</td>';
				echo '</tr>';
			}
			echo'	
					<tr>
						<td><b>INCOME</b></td>
						<td></td>
					</tr>
					<tr>
						<td>Interest On Loans</td>
						<td></td>
						<td>'.number_format($rowx1['intert']).'</td>
					</tr>
					<tr>
						<td>Client Fees Paid</td>
						<td></td>
						<td>'.number_format($fees).'</td>
					</tr>
					<tr>
						<td>Client Penalties</td>
						<td></td>
						<td>'.number_format($rowx2['amts']).'</td>
					</tr>
					<tr>
						<td>Pass Books</td>
						<td></td>
						<td>'.number_format($pasbk).'</td>
					</tr>';
				foreach($db->query("SELECT DISTINCT(accountcode) as accountcode FROM incometrail") as $rowcrd){
					foreach($db->query("SELECT * FROM incometrail WHERE accountcode='".$rowcrd['accountcode']."'") as $rowcrdamt){}
					SECTIONS::$search_code = $rowcrd['accountcode'];
					SECTIONS::SEARCH_CODE();
					echo "<tr>";
					echo "<td data-order='1'>".SECTIONS::$resultname."</td>";
					echo "<td></td>";
					echo "<td>".number_format($rowcrdamt['amount'])."</td>";
					echo "</tr>";
				}
			echo'	<tr>
						<td>Other Incomes</td>
						<td></td>
						<td>'.number_format($rowx5['insu']).'</td>
					</tr>
					<tr>
						<td><b>EXPENDITURE</b></td>
						<td></td>
					</tr>';
				foreach ($db->query("SELECT DISTINCT(expensecode) as expcode FROM expensestracs WHERE YEAR(inserteddate)='".$yrs."'") as $rowh){
					SECTIONS::$search_code = $rowh['expcode'];
					SECTIONS::SEARCH_CODE();
					foreach ($db->query("SELECT SUM(paidamount) as amts FROM expensestracs WHERE expensecode='".$rowh['expcode']."'") as $row){}
					echo '
						<tr>
							<td>'.SECTIONS::$resultname.'</td>
							<td>'.number_format($row['amts']).'</td>
							<td></td>
						</tr>
					';
				}
				foreach ($db->query("SELECT * FROM expensestracs WHERE YEAR(inserteddate)='".$yrs."'") as $rowh1){
					$expense = $expense + $rowh1['paidamount'];
				}
				$prft = $income - $expense;
		echo'			<tr>
						<td><b></b></td>
						<td><b class="pull-right">'.number_format($expense).'</b></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		';
	}
	
	public static function BALANCESHEET(){
		$db = new DB(); NOW_DATETIME::NOW();
		$cash =  "0";
		$cashbank =  "0";
		$cashrecv =  "0";
		$currentassetvalue = "0";
		$payable = "0";
		$liability = "0";
		foreach($db->query("SELECT * FROM assets") as $rowasset){
			$depdate = explode(",",$rowasset['years']);
			$assetval = explode(",",$rowasset['valueby_year']);
			$actdate = "";
			for($i = 1;$i < count($depdate); $i++ ){
					NOW_DATETIME::NOW();
					$datadate = explode("-",$depdate[$i]);
					
					if($datadate[0] == NOW_DATETIME::$year){
						$dateint = new DateTime($depdate[$i]);
						$dateint->add(new DateInterval('P1Y'));
						$actdate = $dateint->format('Y-m-d');
					}
					
					if($depdate[$i] >= NOW_DATETIME::$Date && $depdate[$i] < $actdate){
						$currentassetvalue += $assetval[$i];
						$actdate = "";
					}else if($depdate[$i] == $actdate){
						$currentassetvalue += $assetval[$i];
						$actdate = "";
					}else{
						
					}
			}
		}
		
		$fees = "0"; $pasbk = "0"; $income = "0"; $expense = "0";
		$totamt = "0";
		foreach ($db->query("SELECT * FROM mergerwd ORDER BY mergeid DESC") as $rowt){
						
				if($rowt['transactiontype']=="1"){
					foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."'") as $row1){
						$dec = explode(",",$row1['depositeditems']);
						$fig = explode(",",$row1['depositedamts']);
						$descriptions = "";
						for($i = 1; $i<=count($dec); $i++){
							if($dec[$i]=="5"){
								$totamt  = $totamt + $fig[$i];
							}
							
						}
						
					}
				}				
				if($rowt['transactiontype']=="4"){
					foreach ($db->query("SELECT * FROM loan_insurance WHERE ins_id='".$rowt['transactionid']."'") as $row1){
						$totamt  = $totamt + $row1['amount'];
					}
				}
				if($rowt['transactiontype']=="5"){
						foreach ($db->query("SELECT * FROM loan_processcharges WHERE charge_id='".$rowt['transactionid']."'") as $row1){
							$totamt  = $totamt + $row1['amount'];
						}
					}
				
								
		}
		$yrs = (($_GET['profitnloss'])?$_GET['profitnloss']:NOW_DATETIME::$year);
		foreach($db->query("SELECT SUM(interestpaid) as intert FROM loan_repayment WHERE YEAR(inserted_date)='".$yrs."'") as $rowx1){}
		foreach($db->query("SELECT SUM(amount) as amts FROM loan_fines WHERE YEAR(inserted_date)='".$yrs."'") as $rowx2){}
		foreach($db->query("SELECT SUM(amount) as mnths FROM monthlycharges WHERE YEAR(mdate)='".$yrs."'") as $rowx3){}
		foreach($db->query("SELECT SUM(amount) as procs FROM loan_processcharges WHERE YEAR(inserted_date)='".$yrs."'") as $rowx4){}
		foreach($db->query("SELECT SUM(amount) as insu FROM loan_insurance WHERE YEAR(inserted_date)='".$yrs."'") as $rowx5){}
		foreach ($db->query("SELECT * FROM mergerwd WHERE YEAR(insertiondate)='".$yrs."' ORDER BY mergeid DESC") as $rowt){					
			if($rowt['transactiontype']=="1"){
				foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."'") as $row1){
					$dep = $dep + $row1['amount'];
					$dec = explode(",",$row1['depositeditems']);
						$fig = explode(",",$row1['depositedamts']);
						$descriptions = "";
						for($i = 1; $i<=count($dec); $i++){
							if($dec[$i]=="5"){
								$fees = $fees + $fig[$i];
							}

							if($dec[$i]=="6"){
								$fees = $fees + $fig[$i];
							}
							
							if($dec[$i]=="7"){
								$pasbk = $pasbk + $fig[$i];
							}
							$dataxx = explode("charges",$dec[$i]);
							if($dataxx[1]=="1"){
								foreach ($db->query('SELECT * FROM othercharges WHERE  otherid="'.$dataxx[1].'"') as $row){}
								$fees = $fees + $fig[$i];
								
							}

						}
				}
					
			}
		}
		$fees = $fees + $rowx3['mnths'] + $rowx4['procs'] + $totamt;
		$income = $fees + $pasbk + $rowx1['intert'] + $rowx2['amts'] + $rowx5['insu'];
		foreach($db->query("SELECT SUM(loanaccount) as outstanding,SUM(shareaccount_amount) as shrs FROM clients WHERE writeoffstatus='0'") as $rowout){}
		$outbalfig = $rowout['outstanding'];
		$shrfigamt = $rowout['shrs'];
		echo '
			<table width = "100%"><tr><td style="background-color: #00AE01!important;padding: 0.3em;color: #FFFFFF;font-family:Segoe UI;font-size:20px;font-weight:600"><span>Assets</span></td></tr></table>
			<table cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
				<tbody>
					<tr>
						<td width="50%"><b>FIXED ASSETS</b></td>
						<td></td>
					</tr>
					<tr>
						<td>Non Current Assets</td>
						<td>'.number_format($currentassetvalue).'</td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td>'.number_format($currentassetvalue).'</td>
					</tr>
					<tr>
						<td><b>CURRENT ASSETS</b></td>
						<td></td>
					</tr>';
					 VAULT_TRACS::GET_TOTAL();  VAULT_TRACS::GET_TOTAL1();  VAULT_TRACS::GET_TOTAL2(); 
			foreach($db->query("SELECT SUM(amount+dep-withd) as overall, SUM(amount) as amt, SUM(dep) as dep, SUM(withd) as withd FROM cashierincharge") as $overall){ }
					echo '<tr>';
					echo '<td>Cash</td>';
					echo '<td>'.number_format(VAULT_TRACS::$tot+VAULT_TRACS::$tot2+VAULT_TRACS::$tot1+$overall['overall']).'</td>';
					echo '<td></td>';
					echo '</tr>';
					$cashbank = VAULT_TRACS::$tot+VAULT_TRACS::$tot2+VAULT_TRACS::$tot1+$overall['overall'];
			foreach($db->query("SELECT * FROM cashaccounts") as $row){
				foreach($db->query("SELECT * FROM level4 WHERE level3code='".$row['coacode']."'") as $rows){
					echo '<tr>';
					echo '<td>'.$rows['level3name'].'</td>';
					echo '<td>'.number_format($row['descbalance']).'</td>';
					echo '<td></td>';
					echo '</tr>';
					$cash += $row['descbalance'];
				}

			}
			
			echo'
				<tr>
					<td></td>
					<td></td>
					<td>'.number_format($cashbank+$cash).'</td>
				</tr>
				<tr>
					<td><b>RECIEVABLES</b></td>
					<td></td>
				</tr>
				<tr>
					<td>Loans</td>
					<td>'.number_format($outbalfig).'</td>
					<td></td>
				</tr>';
			foreach($db->query("SELECT DISTINCT(accountcode) as accountcode FROM credit_sale") as $rowcrd){
			foreach($db->query("SELECT * FROM credit_sale WHERE accountcode='".$rowcrd['accountcode']."'") as $rowcrdamt){}
				SECTIONS::$search_code = $rowcrd['accountcode'];
				SECTIONS::SEARCH_CODE();
				echo "<tr>";
				echo "<td data-order='1'>".SECTIONS::$resultname."</td>";
				echo "<td>".number_format($rowcrdamt['receivableamount'])."</td>";
				echo "<td></td>";
				echo "</tr>";
				$cashrecv += $rowcrdamt['receivableamount'];
			}
			echo'
				<tr>
					<td></td>
					<td></td>
					<td>'.number_format($cashrecv+$outbalfig).'</td>
				</tr>';
					
			echo'
					<tr>
						<td><b>TOTAL ASSETS</b></td>
						<td></td>
						<td><b>'.number_format($cashrecv+$outbalfig+$cashbank+$cash+$currentassetvalue).'</b></td>
					</tr>
				</tbody>
			</table>
			<table width = "100%"><tr><td style="background-color: #00AE01 !important;padding: 0.3em;color: #FFFFFF;font-family:Segoe UI;font-size:20px;font-weight:600"><span>Liabilities and Owner\'s Equity</span></td></tr></table>
			<table width = "100%" class="table table-bordered m-n">
				<tbody>
				<tr>
						<td width="50%"><b>LIABILITIES</b></td>
						<td></td>
					</tr>';
					$amtz = "0";
			foreach ($db->query("SELECT * FROM clients") as $rowt){$amtz = $amtz + $rowt['savingaccount'];}
				echo '
					<tr>
						<td>Savings</td>
						<td>'.number_format($amtz).'</td>
						<td></td>
					</tr>
					';
			foreach($db->query("SELECT DISTINCT(accountcode) as accountcode FROM credit_purchase") as $rowcrd){
			foreach($db->query("SELECT * FROM credit_purchase WHERE accountcode='".$rowcrd['accountcode']."'") as $rowcrdamt){}
				SECTIONS::$search_code = $rowcrd['accountcode'];
				SECTIONS::SEARCH_CODE();
				echo "<tr>";
				echo "<td data-order='1'>".SECTIONS::$resultname."</td>";
				echo "<td>".number_format($rowcrdamt['payableamount'])."</td>";
				echo "<td></td>";
				echo "</tr>";
				$payable += $rowcrdamt['payableamount'];
			}
			echo'
				<tr>
					<td></td>
					<td></td>
					<td>'.number_format($amtz+$payable).'</td>
				</tr>			
				<tr>
					<td><b>Long Term Liabilities</b></td>
					<td></td>
				</tr>';			
			foreach($db->query("SELECT * FROM borrowings b, financialinstitutions f WHERE f.instid=b.intitutionid ORDER BY borrowingid DESC") as $rowz){
				$date = explode(":",$rowz['inserted_date']);
				echo '<tr>';
				echo '<td>'.$rowz['instname'].'</td>';
				echo '<td>'.number_format($rowz['principal']+$rowz['interest']).'</td>';
				echo '<td></td>';
				echo '</tr>';
				$liability += $rowz['principal']+$rowz['interest'];
			}	
			echo'
				<tr>
					<td></td>
					<td></td>
					<td>'.number_format($liability).'</td>
				</tr>			
				<tr>
					<td><b>Owner\'s Equity</b></td>
					<td></td>
				</tr>
				<tr>
					<td>Shares</td>
					<td>'.number_format($shrfigamt).'</td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td>'.number_format($shrfigamt).'</td>
				</tr>
				<tr>
					<td><b>TOTAL LIABILITIES & OWNER\'S EQUITY</b></td>
					<td></td>
					<td><b>'.number_format($liability+$shrfigamt+$amtz+$payable).'</b></td>
				</tr>
				';
				
		echo'
				</tbody>
			</table>
		';
	}
	
	public static function CASHFLOW(){
	    $db = new DB();
	    $data = explode("?::?",$_GET['inoutstatement']);

	    if($data[0] == "1"){
        	echo '
	            <table id="" cellpadding="0" width = "80%" cellspacing="0" border="0" class="table table-bordered m-n">
	                <thead>
	                    <tr>
	                        <th width="14%">Description</th>
	                        <th width="6%">B/F</th>
	                        <th width="6%">January</th>
	                        <th width="6%">February</th>
	                        <th width="6%">March</th>
	                        <th width="6%">April</th>
	                        <th width="6%">May</th>
	                        <th width="6%">June</th>
	                        <th width="6%">July</th>
	                        <th width="6%">August</th>
	                        <th width="6%">September</th>
	                        <th width="6%">October</th>
	                        <th width="6%">November</th>
	                        <th width="6%">December</th>
	                        <th width="6%">Total</th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <tr style="font-size: 11px !important">
	                        <td><b>INFLOWS</b></td>
	                        <td></td>
	                        <td></td>
	                        <td></td>
	                        <td></td>
	                        <td></td>
	                        <td></td>
	                        <td></td>
	                        <td></td>
	                        <td></td>
	                        <td></td>
	                        <td></td>
	                        <td></td>
	                        <td></td>
	                        <td></td>
	                    </tr>';
		                    $data1 = array();
		                    $data2 = array();
		                    $data3 = array();
		                    $sav = "";		$shr = "";		$lnt = "";		$sub = "";		$lrf = "";
		                    $mbf = "";		$sav1 = "0";	$shr1 = "0";	$lnt1 = "0";
		                    $sub1 = "0";	$lrf1 = "0";	$mbf1 = "0"; $passtot = "0";	$mnths = "";
		                    $mnths1 = "";	$mnths2 = "";	$mnths3 = "";	$mnths4 = "";	$mnths5 = "";
		                    foreach ($db->query("SELECT * FROM mergerwd WHERE YEAR(insertiondate)= '".$data[1]."' ORDER BY mergeid DESC") as $rowt){
		                        CLIENT_DATA::$clientid = $rowt['clientid'];
		                        CLIENT_DATA::CLIENTDATAMAIN();

		                        if($rowt['transactiontype']=="1"){
		                            for($d=1;$d <= 12; $d++){
		                                foreach ($db->query("SELECT * FROM deposits WHERE YEAR(inserteddate)='".$data[1]."' AND MONTH(inserteddate)='".$d."' AND depositid='".$rowt['transactionid']."'") as $row1){
		                                    $dec = explode(",",$row1['depositeditems']);
		                                    $fig = explode(",",$row1['depositedamts']);
		                                    $dates = explode(":",$row1['inserteddate']);
		                                    $descriptions = "";
		                                    for($i = 1; $i<=count($dec); $i++){
		                                        array_push($data1,$dec[$i]);
		                                        if($dec[$i]=="1"){ $sav .=",". $fig[$i]; $mnths .=",". $d; array_push($data2,$dates[0]); $tisp .=",".$row1['inserteddate']; }
		                                        if($dec[$i]=="2"){ $shr .=",". $fig[$i]; $mnths1 .=",". $d;}
		                                        if($dec[$i]=="3"){ $lnt .=",". $fig[$i]; $mnths2 .=",". $d;}
		                                        if($dec[$i]=="4"){ $sub .=",". $fig[$i]; $mnths3 .=",". $d;}
		                                        if($dec[$i]=="5"){ $lrf .=",". $fig[$i]; $mnths4 .=",". $d;}
		                                        if($dec[$i]=="6"){ $mbf .=",". $fig[$i]; $mnths5 .=",". $d;}

		                                        $dataxx = explode("charges",$dec[$i]);
		                                        if($dataxx[1]){	$othfs.$d += $fig[$i]; }
		                                    }
		                                }
		                            }
		                        }
		                    }
	                    $codes =array_unique($data1);
	                    foreach ($db->query("SELECT * FROM deposit_cats") as $rowd){
	                        $descriptions = $rowd['deptname'];
	                        foreach($codes as $k){
	                            if($k == $rowd['depart_id']){
	                                        echo '
                                                <tr style="font-size: 11px !important">
                                                    <td><b class="pull-right">'.$rowd['deptname'].'</b></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>';
                                                $dat1 = array();
                                                foreach ($db->query("SELECT * FROM deposits WHERE YEAR(inserteddate)='".$data[1]."'") as $rowdate){
                                                        $dec1 = explode(",",$rowdate['depositeditems']);
                                                        for($i = 1; $i<=count($dec1); $i++){
                                                            if($dec1[$i]==$k){		
                                                                $indat = explode(":",$rowdate['inserteddate']);
                                                                array_push($dat1,$indat[0]);
                                                            }
                                                        }
                                                }	

                                                $cods =array_unique($dat1);
                                                $oftot = "";
                                                foreach($cods as $kl){
                                                    echo'<tr style="font-size: 11px !important">
                                                            <td><span class="pull-right">'.$kl.'</span></td>
                                                            <td>0</td>';
			                                                    for($p=1;$p <= 12; $p++){
			                                                        $totpop = "0";
			                                                        foreach ($db->query("SELECT * FROM deposits WHERE  YEAR(inserteddate)='".$data[1]."' AND inserteddate='".$kl."' AND MONTH(inserteddate)='".$p."'") as $rowdat){
			                                                            $decs = explode(",",$rowdat['depositeditems']);
			                                                            $figs = explode(",",$rowdat['depositedamts']);
			                                                            for($i = 1; $i<=count($decs); $i++){
			                                                                if($decs[$i] == $k){$totpiop += $figs[$i];}

			                                                            }
			                                                        }
			                                                        $totrow += $totpiop;
			                                                        echo'<td><span class="pull-right">'.number_format($totpiop).'</span></td>';
			                                                        $totpiop ="0";
			                                                    }
			                                                    echo'<td><b class="pull-right">'.number_format($totrow).'</b></td>';
			                                                    echo'</tr>';
			                                                    $totrow = "0";
                                                }
                                        echo'	
                                                <tr style="font-size: 11px !important">
                                                    <td><b>Total</b></td>
                                                    <td></td>';
                                                    $lsav = explode(",",$sav);
                                                    $lshr = explode(",",$shr);
                                                    $llnt = explode(",",$lnt);
                                                    $lsub = explode(",",$sub);
                                                    $llrf = explode(",",$lrf);
                                                    $lmbf = explode(",",$mbf);
                                                    $lpasstot = explode(",",$passtot);
                                                    $lmnths = explode(",",$mnths);		
                                                    $lmnths1 = explode(",",$mnths1);		
                                                    $lmnths2 = explode(",",$mnths2);		
                                                    $lmnths3 = explode(",",$mnths3);		
                                                    $lmnths4 = explode(",",$mnths4);		
                                                    $lmnths5 = explode(",",$mnths5);

			                                        for($p=1;$p <= 12; $p++){	
			                                        echo'	<td><b class="pull-right">';
                                                        for($f=0;$f <=count($lsav); $f++){if($lmnths[$f] ==$p){$sav1 += $lsav[$f];}}
                                                        for($f=0;$f <=count($lshr); $f++){if($lmnths1[$f]==$p){$shr1 += $lshr[$f];}}
                                                        for($f=0;$f <=count($llnt); $f++){if($lmnths2[$f]==$p){$lnt1 += $llnt[$f];}}
                                                        for($f=0;$f <=count($lsub); $f++){if($lmnths3[$f]==$p){$sub1 += $lsub[$f];}}
                                                        for($f=0;$f <=count($llrf); $f++){if($lmnths4[$f]==$p){$lrf1 += $llrf[$f];}}
                                                        for($f=0;$f <=count($lmbf); $f++){if($lmnths5[$f]==$p){$mbf1 += $lmbf[$f];}}
                                                        if($rowd['depart_id']=="1"){ 
                                                                $savtot += $sav1; echo number_format($sav1); 
                                                                if($p=="1"){$jantot += $sav1;} 
                                                                if($p=="2"){$febtot += $sav1;}	
                                                                if($p=="3"){$martot += $sav1;}	
                                                                if($p=="4"){$aprtot += $sav1;}	
                                                                if($p=="5"){$maytot += $sav1;}	
                                                                if($p=="6"){$juntot += $sav1;}	
                                                                if($p=="7"){$jultot += $sav1;}	
                                                                if($p=="8"){$augtot += $sav1;}	
                                                                if($p=="9"){$septot += $sav1;}	
                                                                if($p=="10"){$octtot += $sav1;}	
                                                                if($p=="11"){$novtot += $sav1;}	
                                                                if($p=="12"){$dectot += $sav1;}	
                                                                $sav1="0"; $shr1="0"; $lnt1="0"; $sub1="0"; $lrf1="0"; $mbf1="0";}
                                                        if($rowd['depart_id']=="2"){ 
                                                                $shrtot += $shr1; echo number_format($shr1); 
                                                                if($p=="1"){$jantot += $shr1;} 
                                                                if($p=="2"){$febtot += $shr1;} 
                                                                if($p=="3"){$martot += $shr1;} 
                                                                if($p=="4"){$aprtot += $shr1;} 
                                                                if($p=="5"){$maytot += $shr1;} 
                                                                if($p=="6"){$juntot += $shr1;} 
                                                                if($p=="7"){$jultot += $shr1;} 
                                                                if($p=="8"){$augtot += $shr1;} 
                                                                if($p=="9"){$septot += $shr1;} 
                                                                if($p=="10"){$octtot += $shr1;} 
                                                                if($p=="11"){$novtot += $shr1;} 
                                                                if($p=="12"){$dectot += $shr1;} 
                                                                $sav1="0"; $shr1="0"; $lnt1="0"; $sub1="0"; $lrf1="0"; $mbf1="0";}
                                                        if($rowd['depart_id']=="3"){ 
                                                                $lnttot += $lnt1; echo number_format($lnt1); 
                                                                if($p=="1"){$jantot += $lnt1;} 
                                                                if($p=="2"){$febtot += $lnt1;} 
                                                                if($p=="3"){$martot += $lnt1;} 
                                                                if($p=="4"){$aprtot += $lnt1;} 
                                                                if($p=="5"){$maytot += $lnt1;} 
                                                                if($p=="6"){$juntot += $lnt1;} 
                                                                if($p=="7"){$jultot += $lnt1;} 
                                                                if($p=="8"){$augtot += $lnt1;} 
                                                                if($p=="9"){$septot += $lnt1;} 
                                                                if($p=="10"){$octtot += $lnt1;} 
                                                                if($p=="11"){$novtot += $lnt1;} 
                                                                if($p=="12"){$dectot += $lnt1;} 
                                                                $sav1="0"; $shr1="0"; $lnt1="0"; $sub1="0"; $lrf1="0"; $mbf1="0";}
                                                        if($rowd['depart_id']=="4"){ 
                                                                $subtot += $sub1; echo number_format($sub1); 
                                                                if($p=="1"){$jantot += $sub1;}
                                                                if($p=="2"){$febtot += $sub1;}											
                                                                if($p=="3"){$martot += $sub1;}											
                                                                if($p=="4"){$aprtot += $sub1;}											
                                                                if($p=="5"){$maytot += $sub1;}											
                                                                if($p=="6"){$juntot += $sub1;}											
                                                                if($p=="7"){$jultot += $sub1;}											
                                                                if($p=="8"){$augtot += $sub1;}											
                                                                if($p=="9"){$septot += $sub1;}											
                                                                if($p=="10"){$octtot += $sub1;}											
                                                                if($p=="11"){$novtot += $sub1;}											
                                                                if($p=="12"){$dectot += $sub1;}											
                                                                $sav1="0"; $shr1="0"; $lnt1="0"; $sub1="0"; }
                                                        if($rowd['depart_id']=="5"){ 
                                                                $lrftot += $lrf1; echo number_format($lrf1); 
                                                                if($p=="1"){$jantot += $lrf1;} 
                                                                if($p=="2"){$febtot += $lrf1;}	
                                                                if($p=="3"){$martot += $lrf1;}	
                                                                if($p=="4"){$aprtot += $lrf1;}	
                                                                if($p=="5"){$maytot += $lrf1;}	
                                                                if($p=="6"){$juntot += $lrf1;}	
                                                                if($p=="7"){$jultot += $lrf1;}	
                                                                if($p=="8"){$augtot += $lrf1;}	
                                                                if($p=="9"){$septot += $lrf1;}	
                                                                if($p=="10"){$octtot += $lrf1;}	
                                                                if($p=="11"){$novtot += $lrf1;}	
                                                                if($p=="12"){$dectot += $lrf1;}	
                                                                $sav1="0"; $shr1="0"; $lnt1="0"; $sub1="0"; $lrf1="0"; $mbf1="0"; }
                                                        if($rowd['depart_id']=="6"){ 
                                                                $mbftot += $mbf1; echo number_format($mbf1); 
                                                                if($p=="1"){$jantot += $mbf1;}
                                                                if($p=="2"){$febtot += $mbf1;}												
                                                                if($p=="3"){$martot += $mbf1;}												
                                                                if($p=="4"){$aprtot += $mbf1;}												
                                                                if($p=="5"){$maytot += $mbf1;}												
                                                                if($p=="6"){$juntot += $mbf1;}												
                                                                if($p=="7"){$jultot += $mbf1;}												
                                                                if($p=="8"){$augtot += $mbf1;}												
                                                                if($p=="9"){$septot += $mbf1;}												
                                                                if($p=="10"){$octtot += $mbf1;}												
                                                                if($p=="11"){$novtot += $mbf1;}												
                                                                if($p=="12"){$dectot += $mbf1;}												
                                                                $sav1="0"; $shr1="0"; $lnt1="0"; $sub1="0"; $lrf1="0"; $mbf1="0"; }
                                                        if($rowd['depart_id']=="7"){ 
                                                                $passtot += $passtot; echo number_format($passtot); 
                                                                if($p=="1"){$jantot += $passtot;}
                                                                if($p=="2"){$febtot += $passtot;}												
                                                                if($p=="3"){$martot += $passtot;}												
                                                                if($p=="4"){$aprtot += $passtot;}												
                                                                if($p=="5"){$maytot += $passtot;}												
                                                                if($p=="6"){$juntot += $passtot;}												
                                                                if($p=="7"){$jultot += $passtot;}												
                                                                if($p=="8"){$augtot += $passtot;}												
                                                                if($p=="9"){$septot += $passtot;}												
                                                                if($p=="10"){$octtot += $passtot;}												
                                                                if($p=="11"){$novtot += $passtot;}												
                                                                if($p=="12"){$dectot += $passtot;}												
                                                                $sav1="0"; $shr1="0"; $lnt1="0"; $sub1="0"; $lrf1="0"; $mbf1="0"; }

                                        echo'	</b></td>';
                                        }
                                        echo'	
                                                        <td><b class="pull-right">';
                                                        if($rowd['depart_id']=="1"){echo number_format($savtot);}
                                                        if($rowd['depart_id']=="2"){echo number_format($shrtot);}
                                                        if($rowd['depart_id']=="3"){echo number_format($lnttot);}
                                                        if($rowd['depart_id']=="4"){echo number_format($subtot);}
                                                        if($rowd['depart_id']=="5"){echo number_format($lrftot);}
                                                        if($rowd['depart_id']=="6"){echo number_format($mbftot);}
                                                        if($rowd['depart_id']=="7"){echo number_format($passtot);}
                                        echo'	</b></td>
                                                </tr>
                                        ';
                                }
                        }
                    }

                            $dat1 = array();
                            $dat2 = array();
                            foreach ($db->query("SELECT * FROM incometrail") as $rowdate){
                                $indat = explode(":",$rowdate['income_date']);
                                array_push($dat1,$indat[0]);
                                array_push($dat2,$rowdate['accountcode']);
                            }
                            $cods1 =array_unique($dat1);
                            $cods2 =array_unique($dat2);
                            foreach($cods2 as $kl){
                                    SECTIONS::$search_code = $kl;
                                    SECTIONS::SEARCH_CODE();
                                    echo '
                                        <tr style="font-size: 11px !important">
                                            <td>'.SECTIONS::$resultname.'</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    ';
                                    foreach($cods1 as $kl1){
                                            $totpiop = "0";
                                            $totpop = "0";
                                            foreach($db->query("SELECT DISTINCT(income_date) FROM incometrail WHERE YEAR(income_date)='".$data[1]."' AND income_date='".$kl1."' AND accountcode='".$kl."'") as $rowcrd2){
                                                    echo'<tr style="font-size: 11px !important">
                                                                    <td><span class="pull-right"><b>'.$kl1.'</b></span></td>
                                                                    <td></td>';
                                                    for($p=1;$p <= 12; $p++){
                                                            foreach($db->query("SELECT * FROM incometrail WHERE income_date='".$rowcrd2['income_date']."' AND MONTH(income_date)='".$p."' AND accountcode='".$kl."'") as $rowcrd1){
                                                                    $totpiop += $rowcrd1['amount'];
                                                            }
                                                            if($p=="1"){$febtots += $totpiop;}												
                                                            if($p=="2"){$febtots += $totpiop;}												
                                                            if($p=="3"){$martots += $totpiop;}												
                                                            if($p=="4"){$aprtots += $totpiop;}												
                                                            if($p=="5"){$maytots += $totpiop;}												
                                                            if($p=="6"){$juntots += $totpiop;}												
                                                            if($p=="7"){$jultots += $totpiop;}												
                                                            if($p=="8"){$augtots += $totpiop;}												
                                                            if($p=="9"){$septots += $totpiop;}												
                                                            if($p=="10"){$octtots += $totpiop;}												
                                                            if($p=="11"){$novtots += $totpiop;}												
                                                            if($p=="12"){$dectots += $totpiop;}
                                                            $totrow += $totpiop;
                                                            echo'<td><span class="pull-right">'.number_format($totpiop).'</span></td>';
                                                            $totpiop ="0";

                                                    }
                                                    echo'<td><b class="pull-right">'.number_format($totrow).'</b></td>';
                                                    $totrow = "0";
                                                    echo "<tr>";
                                            }
                                    }
                                    echo "<tr>";
                                    echo "<td><b>Total</b></td>";
                                    echo "<td></td>";
                                    $amt = $rowcrd1['amount'];
                                    //$amttot += $amt;
                                    echo '
                                            <td><b class="pull-right">'.number_format($jantots).'</b></td>
                                            <td><b class="pull-right">'.number_format($febtots).'</b></td>
                                            <td><b class="pull-right">'.number_format($martots).'</b></td>
                                            <td><b class="pull-right">'.number_format($aprtots).'</b></td>
                                            <td><b class="pull-right">'.number_format($maytots).'</b></td>
                                            <td><b class="pull-right">'.number_format($juntots).'</b></td>
                                            <td><b class="pull-right">'.number_format($jultots).'</b></td>
                                            <td><b class="pull-right">'.number_format($augtots).'</b></td>
                                            <td><b class="pull-right">'.number_format($septots).'</b></td>
                                            <td><b class="pull-right">'.number_format($octtots).'</b></td>
                                            <td><b class="pull-right">'.number_format($novtots).'</b></td>
                                            <td><b class="pull-right">'.number_format($dectots).'</b></td>
                                    ';
                                    $grandtot = $jantots+$febtots+$martots+$aprtots+$maytots+$juntots+$jultots+$augtots+$septots+$octtots+$novtots+$dectots;

                                    echo "<td><b class='pull-right'>".number_format($grandtot)."</b></td>";
                                    echo "</tr>";
                                    $jantot += $jantots;
                                    $febtot += $febtots;												
                                    $martot += $martots;												
                                    $aprtot += $aprtots;												
                                    $maytot += $maytots;												
                                    $juntot += $juntots;												
                                    $jultot += $jultots;												
                                    $augtot += $augtots;												
                                    $septot += $septots;												
                                    $octtot += $octtots;												
                                    $novtot += $novtots;												
                                    $dectot += $dectots;
                                    $jantots = "0";
                                    $febtots = "0";												
                                    $martots = "0";												
                                    $aprtots = "0";												
                                    $maytots = "0";												
                                    $juntots = "0";												
                                    $jultots = "0";												
                                    $augtots = "0";												
                                    $septots = "0";												
                                    $octtots = "0";												
                                    $novtots = "0";												
                                    $dectots = "0";
                            }
                    $grandtot1 = $jantot+$febtot+$martot+$aprtot+$maytot+$juntot+$jultot+$augtot+$septot+$octtot+$novtot+$dectot;	
                    echo '
                                    <tr style="font-size: 11px !important">
                                            <td><b>TOTAL RECEIPTS (INFLOWS)</b></td>
                                            <td></td>
                                            <td><b class="pull-right">'.number_format($jantot).'</b></td>
                                            <td><b class="pull-right">'.number_format($febtot).'</b></td>
                                            <td><b class="pull-right">'.number_format($martot).'</b></td>
                                            <td><b class="pull-right">'.number_format($aprtot).'</b></td>
                                            <td><b class="pull-right">'.number_format($maytot).'</b></td>
                                            <td><b class="pull-right">'.number_format($juntot).'</b></td>
                                            <td><b class="pull-right">'.number_format($jultot).'</b></td>
                                            <td><b class="pull-right">'.number_format($augtot).'</b></td>
                                            <td><b class="pull-right">'.number_format($septot).'</b></td>
                                            <td><b class="pull-right">'.number_format($octtot).'</b></td>
                                            <td><b class="pull-right">'.number_format($novtot).'</b></td>
                                            <td><b class="pull-right">'.number_format($dectot).'</b></td>
                                            <td><b class="pull-right">'.number_format($grandtot1).'</b></td>
                                    </tr>
                                    </tbody>
                            </table>
                    ';
            }
            if($data[0] == "2"){
                    echo '
            <table id="" cellpadding="0" width = "80%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr>
                        <th width="14%">Description</th>
                        <th width="6%">B/F</th>
                        <th width="6%">January</th>
                        <th width="6%">February</th>
                        <th width="6%">March</th>
                        <th width="6%">April</th>
                        <th width="6%">May</th>
                        <th width="6%">June</th>
                        <th width="6%">July</th>
                        <th width="6%">August</th>
                        <th width="6%">September</th>
                        <th width="6%">October</th>
                        <th width="6%">November</th>
                        <th width="6%">December</th>
                        <th width="6%">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="font-size: 11px !important">
                        <td><b>OUTFLOWS</b></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>';
                    foreach ($db->query("SELECT DISTINCT(expensecode) as expcode FROM expensestracs WHERE YEAR(boughtdate)= '".$data[1]."'") as $rowcrd){
                            SECTIONS::$search_code = $rowcrd['expcode'];
                            SECTIONS::SEARCH_CODE();
                            echo '
                                    <tr style="font-size: 11px !important">
                                            <td>'.SECTIONS::$resultname.'</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                    </tr>
                    ';
                                            for($p=1;$p <= 12; $p++){
                                                    $amttot = "0";
                                                    foreach($db->query("SELECT * FROM expensestracs WHERE YEAR(boughtdate)= '".$data[1]."' AND MONTH(boughtdate)='".$p."' AND expensecode='".$rowcrd['expcode']."'") as $rowcrd1){
                                                            echo "<tr>";
                                                            echo "<td><b class='pull-right'>".$rowcrd1['boughtdate']."</b></td>";
                                                            echo "<td></td>";
                                                            $amt = $rowcrd1['paidamount'];
                                                            $amttot += $amt;
                                                            for($d=1;$d <= 12; $d++){
                                                                    if($p==$d){
                                                                        echo "<td><span class='pull-right'>".number_format($amt)."</span></td>";
                                                                        if($d=="1"){$jantots += $amt;}
                                                                        if($d=="2"){$febtots += $amt;}												
                                                                        if($d=="3"){$martots += $amt;}												
                                                                        if($d=="4"){$aprtots += $amt;}												
                                                                        if($d=="5"){$maytots += $amt;}												
                                                                        if($d=="6"){$juntots += $amt;}												
                                                                        if($d=="7"){$jultots += $amt;}												
                                                                        if($d=="8"){$augtots += $amt;}												
                                                                        if($d=="9"){$septots += $amt;}												
                                                                        if($d=="10"){$octtots += $amt;}												
                                                                        if($d=="11"){$novtots += $amt;}												
                                                                        if($d=="12"){$dectots += $amt;}									
                                                                    }else{
                                                                            echo "<td><span class='pull-right'>".number_format(0)."</span></td>";
                                                                    }

                                                            }
                                                            echo "<td><b class='pull-right'>".number_format($amttot)."</b></td>";
                                                            echo "</tr>";
                                                            $amttot = "0";
                                                    }
                                            }

                                            echo "<tr>";
                                            echo "<td><b>Total</b></td>";
                                            echo "<td></td>";
                                            $amt = $rowcrd1['amount'];
                                            //$amttot += $amt;
                                            echo '
                                                    <td><b class="pull-right">'.number_format($jantots).'</b></td>
                                                    <td><b class="pull-right">'.number_format($febtots).'</b></td>
                                                    <td><b class="pull-right">'.number_format($martots).'</b></td>
                                                    <td><b class="pull-right">'.number_format($aprtots).'</b></td>
                                                    <td><b class="pull-right">'.number_format($maytots).'</b></td>
                                                    <td><b class="pull-right">'.number_format($juntots).'</b></td>
                                                    <td><b class="pull-right">'.number_format($jultots).'</b></td>
                                                    <td><b class="pull-right">'.number_format($augtots).'</b></td>
                                                    <td><b class="pull-right">'.number_format($septots).'</b></td>
                                                    <td><b class="pull-right">'.number_format($octtots).'</b></td>
                                                    <td><b class="pull-right">'.number_format($novtots).'</b></td>
                                                    <td><b class="pull-right">'.number_format($dectots).'</b></td>
                                            ';

                                    $grandtot = $jantots+$febtots+$martots+$aprtots+$maytots+$juntots+$jultots+$augtots+$septots+$octtots+$novtots+$dectots;

                                    echo "<td><b class='pull-right'>".number_format($grandtot)."</b></td>";
                                    echo "</tr>";
                                    $jantot += $jantots;
                                    $febtot += $febtots;												
                                    $martot += $martots;												
                                    $aprtot += $aprtots;												
                                    $maytot += $maytots;												
                                    $juntot += $juntots;												
                                    $jultot += $jultots;												
                                    $augtot += $augtots;												
                                    $septot += $septots;												
                                    $octtot += $octtots;												
                                    $novtot += $novtots;												
                                    $dectot += $dectots;
                                    $jantots = "0";
                                    $febtots = "0";												
                                    $martots = "0";												
                                    $aprtots = "0";												
                                    $maytots = "0";												
                                    $juntots = "0";												
                                    $jultots = "0";												
                                    $augtots = "0";												
                                    $septots = "0";												
                                    $octtots = "0";												
                                    $novtots = "0";												
                                    $dectots = "0";
                            }
                        echo "<tr>";
                        echo "<td><b>Total Expenses</b></td>";
                        echo "<td></td>";
                        echo '
                            <td><b class="pull-right">'.number_format($jantot).'</b></td>
                            <td><b class="pull-right">'.number_format($febtot).'</b></td>
                            <td><b class="pull-right">'.number_format($martot).'</b></td>
                            <td><b class="pull-right">'.number_format($aprtot).'</b></td>
                            <td><b class="pull-right">'.number_format($maytot).'</b></td>
                            <td><b class="pull-right">'.number_format($juntot).'</b></td>
                            <td><b class="pull-right">'.number_format($jultot).'</b></td>
                            <td><b class="pull-right">'.number_format($augtot).'</b></td>
                            <td><b class="pull-right">'.number_format($septot).'</b></td>
                            <td><b class="pull-right">'.number_format($octtot).'</b></td>
                            <td><b class="pull-right">'.number_format($novtot).'</b></td>
                            <td><b class="pull-right">'.number_format($dectot).'</b></td>
                            <td><b class="pull-right">'.number_format($grandtot1).'</b></td>
                        ';
                            echo '
                                <tr style="font-size: 11px !important">
                                    <td>Loan Disbursements</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>';
                                    $dat1 = array();
                                    $hh = array();
                                    $pp = array();
                                    foreach ($db->query("SELECT * FROM loan_schedules s, mergerwd m WHERE s.schudele_id = m.transactionid AND m.transactiontype='3' AND YEAR(disbursed_date)= '".$data[1]."'") as $rowdate){
                                        $indat = explode(":",$rowdate['disbursed_date']);
                                        $indat2 = explode(" ",$indat[0]);
                                        array_push($dat1,$indat2[0]);
                                    }	
                                    $cods1 =array_unique($dat1);
                                    foreach($cods1 as $kl){
                                        echo'<tr style="font-size: 11px !important">
                                            <td><span class="pull-right">'.$kl.'</span></td>
                                            <td></td>';
                                        for($p=1;$p <= 12; $p++){
                                            $totpop = "0";
                                            foreach ($db->query("SELECT * FROM loan_schedules WHERE disbursed_date='".$kl."' AND MONTH(disbursed_date)='".$p."'") as $rowdat){
                                                $totpiop += $rowdat['amount_given'];
                                            }
                                            if($p=="1"){$jantots += $totpiop;}
                                            if($p=="2"){$febtots += $totpiop;}												
                                            if($p=="3"){$martots += $totpiop;}												
                                            if($p=="4"){$aprtots += $totpiop;}												
                                            if($p=="5"){$maytots += $totpiop;}												
                                            if($p=="6"){$juntots += $totpiop;}												
                                            if($p=="7"){$jultots += $totpiop;}												
                                            if($p=="8"){$augtots += $totpiop;}												
                                            if($p=="9"){$septots += $totpiop;}												
                                            if($p=="10"){$octtots += $totpiop;}												
                                            if($p=="11"){$novtots += $totpiop;}												
                                            if($p=="12"){$dectots += $totpiop;}
                                            $totrow += $totpiop;
                                            echo'<td><span class="pull-right">'.number_format($totpiop).'</span></td>';
                                            $totpiop ="0";
                                        }
                                        echo'<td><b class="pull-right">'.number_format($totrow).'</b></td>';
                                        echo'</tr>';
                                        $totrow = "0";
                                    }
                                    echo "<tr>";
                                    echo "<td><b>Total</b></td>";
                                    echo "<td></td>";
                                    $amt = $rowcrd1['amount'];
                                    //$amttot += $amt;
                                    echo '
                                        <td><b class="pull-right">'.number_format($jantots).'</b></td>
                                        <td><b class="pull-right">'.number_format($febtots).'</b></td>
                                        <td><b class="pull-right">'.number_format($martots).'</b></td>
                                        <td><b class="pull-right">'.number_format($aprtots).'</b></td>
                                        <td><b class="pull-right">'.number_format($maytots).'</b></td>
                                        <td><b class="pull-right">'.number_format($juntots).'</b></td>
                                        <td><b class="pull-right">'.number_format($jultots).'</b></td>
                                        <td><b class="pull-right">'.number_format($augtots).'</b></td>
                                        <td><b class="pull-right">'.number_format($septots).'</b></td>
                                        <td><b class="pull-right">'.number_format($octtots).'</b></td>
                                        <td><b class="pull-right">'.number_format($novtots).'</b></td>
                                        <td><b class="pull-right">'.number_format($dectots).'</b></td>
                                    ';
                                    $grandtot = $jantots+$febtots+$martots+$aprtots+$maytots+$juntots+$jultots+$augtots+$septots+$octtots+$novtots+$dectots;

                                    echo "<td><b class='pull-right'>".number_format($grandtot)."</b></td>";
                                    echo "</tr>";
                                    $jantot += $jantots;
                                    $febtot += $febtots;												
                                    $martot += $martots;												
                                    $aprtot += $aprtots;												
                                    $maytot += $maytots;												
                                    $juntot += $juntots;												
                                    $jultot += $jultots;												
                                    $augtot += $augtots;												
                                    $septot += $septots;												
                                    $octtot += $octtots;												
                                    $novtot += $novtots;												
                                    $dectot += $dectots;
                                    $jantots = "0";
                                    $febtots = "0";												
                                    $martots = "0";												
                                    $aprtots = "0";												
                                    $maytots = "0";												
                                    $juntots = "0";												
                                    $jultots = "0";												
                                    $augtots = "0";												
                                    $septots = "0";												
                                    $octtots = "0";												
                                    $novtots = "0";												
                                    $dectots = "0";

                                    echo '
                                    <tr style="font-size: 11px !important">
                                        <td>Withdraws</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>';
                                    $dat1 = array();
                                    foreach ($db->query("SELECT * FROM withdraws w, mergerwd m WHERE w.withdrawid = m.transactionid AND m.transactiontype='2' AND YEAR(inserteddate)= '".$data[1]."'") as $rowdate){
                                            $indat = explode(":",$rowdate['inserteddate']);
                                            $indat2 = explode(" ",$indat[0]);
                                            array_push($dat1,$indat2[0]);
                                    }	
                                    $cods =array_unique($dat1);
                                    $oftot = "";
                                    $cods1 =array_unique($cods);
                                    foreach($cods1 as $kl){
                                            $ttwrd .=", ".$kl."<br>";
                                            echo'<tr style="font-size: 11px !important">
                                                    <td><span class="pull-right">'.$kl.'</span></td>
                                                    <td></td>';
                                            for($p=1;$p <= 12; $p++){
                                                    $totpop = "0";
                                                    $totpop1 = "0";
                                                    foreach ($db->query("SELECT * FROM withdraws WHERE YEAR(inserteddate)= '".$data[1]."' AND  inserteddate='".$kl."' AND MONTH(inserteddate)='".$p."'") as $rowdat){
                                                        $totpiop += $rowdat['amount'];
                                                    }
                                                    foreach ($db->query("SELECT * FROM withdraws WHERE YEAR(inserteddate)= '".$data[1]."' AND DATE(inserteddate)='".$kl."' AND MONTH(inserteddate)='".$p."'") as $rowdat1){
                                                        $totpiop1 += $rowdat1['amount'];
                                                    }
                                                    $amt = $totpiop1-$totpiop;
                                                    $totrow += $amt;
                                                    if($p=="1"){$jantots += $amt;}
                                                    if($p=="2"){$febtots += $amt;}												
                                                    if($p=="3"){$martots += $amt;}												
                                                    if($p=="4"){$aprtots += $amt;}												
                                                    if($p=="5"){$maytots += $amt;}												
                                                    if($p=="6"){$juntots += $amt;}												
                                                    if($p=="7"){$jultots += $amt;}												
                                                    if($p=="8"){$augtots += $amt;}												
                                                    if($p=="9"){$septots += $amt;}												
                                                    if($p=="10"){$octtots += $amt;}												
                                                    if($p=="11"){$novtots += $amt;}												
                                                    if($p=="12"){$dectots += $amt;}
                                                    echo'<td><span class="pull-right">'.number_format($amt).'</span></td>';
                                                    $totpiop ="0";
                                                    $totpiop1 ="0";
                                            }
                                            echo'<td><b class="pull-right">'.number_format($totrow).'</b></td>';
                                            echo'</tr>';
                                            $totrow = "0";

                                    }
                                    echo "<tr>";
                                    echo "<td><b>Total</b></td>";
                                    echo "<td></td>";
                                    $amt = $rowcrd1['amount'];
                                    //$amttot += $amt;
                                    echo '
                                        <td><b class="pull-right">'.number_format($jantots).'</b></td>
                                        <td><b class="pull-right">'.number_format($febtots).'</b></td>
                                        <td><b class="pull-right">'.number_format($martots).'</b></td>
                                        <td><b class="pull-right">'.number_format($aprtots).'</b></td>
                                        <td><b class="pull-right">'.number_format($maytots).'</b></td>
                                        <td><b class="pull-right">'.number_format($juntots).'</b></td>
                                        <td><b class="pull-right">'.number_format($jultots).'</b></td>
                                        <td><b class="pull-right">'.number_format($augtots).'</b></td>
                                        <td><b class="pull-right">'.number_format($septots).'</b></td>
                                        <td><b class="pull-right">'.number_format($octtots).'</b></td>
                                        <td><b class="pull-right">'.number_format($novtots).'</b></td>
                                        <td><b class="pull-right">'.number_format($dectots).'</b></td>
                                    ';
                                    $grandtot = $jantots+$febtots+$martots+$aprtots+$maytots+$juntots+$jultots+$augtots+$septots+$octtots+$novtots+$dectots;

                                    echo "<td><b class='pull-right'>".number_format($grandtot)."</b></td>";
                                    echo "</tr>";
                                    $jantot += $jantots;
                                    $febtot += $febtots;												
                                    $martot += $martots;												
                                    $aprtot += $aprtots;												
                                    $maytot += $maytots;												
                                    $juntot += $juntots;												
                                    $jultot += $jultots;												
                                    $augtot += $augtots;												
                                    $septot += $septots;												
                                    $octtot += $octtots;												
                                    $novtot += $novtots;												
                                    $dectot += $dectots;
                                    $jantots = "0";
                                    $febtots = "0";												
                                    $martots = "0";												
                                    $aprtots = "0";												
                                    $maytots = "0";												
                                    $juntots = "0";												
                                    $jultots = "0";												
                                    $augtots = "0";												
                                    $septots = "0";												
                                    $octtots = "0";												
                                    $novtots = "0";												
                                    $dectots = "0";
                    $grandtot1 = $jantot+$febtot+$martot+$aprtot+$maytot+$juntot+$jultot+$augtot+$septot+$octtot+$novtot+$dectot;	
                    echo '
                                    <tr style="font-size: 11px !important">
                                            <td><b>TOTAL OUTFLOWS</b></td>
                                            <td></td>
                                            <td><b class="pull-right">'.number_format($jantot).'</b></td>
                                            <td><b class="pull-right">'.number_format($febtot).'</b></td>
                                            <td><b class="pull-right">'.number_format($martot).'</b></td>
                                            <td><b class="pull-right">'.number_format($aprtot).'</b></td>
                                            <td><b class="pull-right">'.number_format($maytot).'</b></td>
                                            <td><b class="pull-right">'.number_format($juntot).'</b></td>
                                            <td><b class="pull-right">'.number_format($jultot).'</b></td>
                                            <td><b class="pull-right">'.number_format($augtot).'</b></td>
                                            <td><b class="pull-right">'.number_format($septot).'</b></td>
                                            <td><b class="pull-right">'.number_format($octtot).'</b></td>
                                            <td><b class="pull-right">'.number_format($novtot).'</b></td>
                                            <td><b class="pull-right">'.number_format($dectot).'</b></td>
                                            <td><b class="pull-right">'.number_format($grandtot1).'</b></td>
                                    </tr>
                                    </tbody>
                            </table>
                    ';
            }
            if($data[0] == "3"){
			
                echo '
                    <table id="" cellpadding="0" width = "130%" cellspacing="0" border="0" class="table table-bordered m-n">
                        <thead>
                            <tr>
                                <th width="24%">Description</th>
                                <th width="6%">B/F</th>
                                <th width="6%">January</th>
                                <th width="6%">February</th>
                                <th width="6%">March</th>
                                <th width="6%">April</th>
                                <th width="6%">May</th>
                                <th width="6%">June</th>
                                <th width="6%">July</th>
                                <th width="6%">August</th>
                                <th width="6%">September</th>
                                <th width="6%">October</th>
                                <th width="6%">November</th>
                                <th width="6%">December</th>
                                <th width="6%">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style="font-size: 11px !important">
                                <td><b>INFLOWS</b></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>';
                                $data1 = array();
                                $sav = "";
                                $shr = "";
                                $lnt = "";
                                $sub = "";
                                $lrf = "";
                                $mbf = "";
                                $passtot = "";
                                $sav1 = "0";
                                $shr1 = "0";
                                $lnt1 = "0";
                                $sub1 = "0";
                                $lrf1 = "0";
                                $lpasstot = "0";
                                $mnths = "";
                                $mnths1 = "";
                                $mnths2 = "";
                                $mnths3 = "";
                                $mnths4 = "";
                                $mnths5 = "";
                                $mnths6 = "";
                                foreach ($db->query("SELECT * FROM mergerwd ORDER BY mergeid DESC") as $rowt){
                                    CLIENT_DATA::$clientid = $rowt['clientid'];
                                    CLIENT_DATA::CLIENTDATAMAIN();

                                    if($rowt['transactiontype']=="1"){
                                        for($d=1;$d <= 12; $d++){
                                            foreach ($db->query("SELECT * FROM deposits WHERE MONTH(inserteddate)='".$d."' AND depositid='".$rowt['transactionid']."'") as $row1){
                                                $dec = explode(",",$row1['depositeditems']);
                                                $fig = explode(",",$row1['depositedamts']);
                                                $descriptions = "";
                                                for($i = 1; $i<=count($dec); $i++){
                                                    array_push($data1,$dec[$i]);
                                                    if($dec[$i]=="1"){ $sav .=",". $fig[$i]; $mnths .=",". $d; }
                                                    if($dec[$i]=="2"){ $shr .=",". $fig[$i]; $mnths1 .=",". $d;}
                                                    if($dec[$i]=="3"){ $lnt .=",". $fig[$i]; $mnths2 .=",". $d;}
                                                    if($dec[$i]=="4"){ $sub .=",". $fig[$i]; $mnths3 .=",". $d;}
                                                    if($dec[$i]=="5"){ $lrf .=",". $fig[$i]; $mnths4 .=",". $d;}
                                                    if($dec[$i]=="6"){ $mbf .=",". $fig[$i]; $mnths5 .=",". $d;}
                                                    if($dec[$i]=="7"){ $passtot .=",". $fig[$i]; $mnths6 .=",". $d;}

                                                    $dataxx = explode("charges",$dec[$i]);
                                                    if($dataxx[1]){	$othfs.$d += $fig[$i]; }
                                                }

                                            }
                                        }
                                    }
                                }
                                            // echo $lnt."<br>".$mnths2."<br>";
                                            $codes =array_unique($data1);
                                            foreach ($db->query("SELECT * FROM deposit_cats") as $rowd){
                                                    $descriptions = $rowd['deptname'];
                                                    foreach($codes as $k){
                                                            if($k == $rowd['depart_id']){
                                                                    echo '
                                                                        <tr style="font-size: 11px !important">
                                                                            <td>'.$rowd['deptname'].'</td>
                                                                            <td></td>';
                                                                            $lsav = explode(",",$sav);
                                                                            $lshr = explode(",",$shr);
                                                                            $llnt = explode(",",$lnt);
                                                                            $lsub = explode(",",$sub);
                                                                            $llrf = explode(",",$lrf);
                                                                            $lmbf = explode(",",$mbf);
                                                                            $lpasstot = explode(",",$passtot);
                                                                            $lmnths = explode(",",$mnths);		
                                                                            $lmnths1 = explode(",",$mnths1);		
                                                                            $lmnths2 = explode(",",$mnths2);		
                                                                            $lmnths3 = explode(",",$mnths3);		
                                                                            $lmnths4 = explode(",",$mnths4);		
                                                                            $lmnths5 = explode(",",$mnths5);
                                                                            $lmnths6 = explode(",",$mnths6);

                                                                    for($p=1;$p <= 12; $p++){	
                                                                        echo'<td><span class="pull-right">';
                                                                            for($f=0;$f <=count($lsav); $f++){if($lmnths[$f] ==$p){$sav1 += $lsav[$f];}}
                                                                            for($f=0;$f <=count($lshr); $f++){if($lmnths1[$f]==$p){$shr1 += $lshr[$f];}}
                                                                            for($f=0;$f <=count($llnt); $f++){if($lmnths2[$f]==$p){$lnt1 += $llnt[$f];}}
                                                                            for($f=0;$f <=count($lsub); $f++){if($lmnths3[$f]==$p){$sub1 += $lsub[$f];}}
                                                                            for($f=0;$f <=count($llrf); $f++){if($lmnths4[$f]==$p){$lrf1 += $llrf[$f];}}
                                                                            for($f=0;$f <=count($lmbf); $f++){if($lmnths5[$f]==$p){$mbf1 += $lmbf[$f];}}
                                                                            for($f=0;$f <=count($lpasstot); $f++){if($lmnths6[$f]==$p){$passtot1 += $lpasstot[$f];}}
                                                                            if($rowd['depart_id']=="1"){ 
                                                                                $savtot += $sav1; 
                                                                                echo number_format($sav1); 
                                                                                if($p=="1"){$jantot += $sav1;} 
                                                                                if($p=="2"){$febtot += $sav1;}	
                                                                                if($p=="3"){$martot += $sav1;}	
                                                                                if($p=="4"){$aprtot += $sav1;}	
                                                                                if($p=="5"){$maytot += $sav1;}	
                                                                                if($p=="6"){$juntot += $sav1;}	
                                                                                if($p=="7"){$jultot += $sav1;}	
                                                                                if($p=="8"){$augtot += $sav1;}	
                                                                                if($p=="9"){$septot += $sav1;}	
                                                                                if($p=="10"){$octtot += $sav1;}	
                                                                                if($p=="11"){$novtot += $sav1;}	
                                                                                if($p=="12"){$dectot += $sav1;}	
                                                                                $sav1="0"; $shr1="0"; $lnt1="0"; $sub1="0"; $lrf1="0"; $mbf1="0";}
                                                                            if($rowd['depart_id']=="2"){ 
                                                                                $shrtot += $shr1; echo number_format($shr1); 
                                                                                if($p=="1"){$jantot += $shr1;} 
                                                                                if($p=="2"){$febtot += $shr1;} 
                                                                                if($p=="3"){$martot += $shr1;} 
                                                                                if($p=="4"){$aprtot += $shr1;} 
                                                                                if($p=="5"){$maytot += $shr1;} 
                                                                                if($p=="6"){$juntot += $shr1;} 
                                                                                if($p=="7"){$jultot += $shr1;} 
                                                                                if($p=="8"){$augtot += $shr1;} 
                                                                                if($p=="9"){$septot += $shr1;} 
                                                                                if($p=="10"){$octtot += $shr1;} 
                                                                                if($p=="11"){$novtot += $shr1;} 
                                                                                if($p=="12"){$dectot += $shr1;} 
                                                                                $sav1="0"; $shr1="0"; $lnt1="0"; $sub1="0"; $lrf1="0"; $mbf1="0";}
                                                                            if($rowd['depart_id']=="3"){ 
                                                                                    $lnttot += $lnt1; echo number_format($lnt1); 
                                                                                    if($p=="1"){$jantot += $lnt1;} 
                                                                                    if($p=="2"){$febtot += $lnt1;} 
                                                                                    if($p=="3"){$martot += $lnt1;} 
                                                                                    if($p=="4"){$aprtot += $lnt1;} 
                                                                                    if($p=="5"){$maytot += $lnt1;} 
                                                                                    if($p=="6"){$juntot += $lnt1;} 
                                                                                    if($p=="7"){$jultot += $lnt1;} 
                                                                                    if($p=="8"){$augtot += $lnt1;} 
                                                                                    if($p=="9"){$septot += $lnt1;} 
                                                                                    if($p=="10"){$octtot += $lnt1;} 
                                                                                    if($p=="11"){$novtot += $lnt1;} 
                                                                                    if($p=="12"){$dectot += $lnt1;} 
                                                                                    $sav1="0"; $shr1="0"; $lnt1="0"; $sub1="0"; $lrf1="0"; $mbf1="0";}
                                                                            if($rowd['depart_id']=="4"){ 
                                                                                    $subtot += $sub1; echo number_format($sub1); 
                                                                                    if($p=="1"){$jantot += $sub1;}
                                                                                    if($p=="2"){$febtot += $sub1;}											
                                                                                    if($p=="3"){$martot += $sub1;}											
                                                                                    if($p=="4"){$aprtot += $sub1;}											
                                                                                    if($p=="5"){$maytot += $sub1;}											
                                                                                    if($p=="6"){$juntot += $sub1;}											
                                                                                    if($p=="7"){$jultot += $sub1;}											
                                                                                    if($p=="8"){$augtot += $sub1;}											
                                                                                    if($p=="9"){$septot += $sub1;}											
                                                                                    if($p=="10"){$octtot += $sub1;}											
                                                                                    if($p=="11"){$novtot += $sub1;}											
                                                                                    if($p=="12"){$dectot += $sub1;}											
                                                                                    $sav1="0"; $shr1="0"; $lnt1="0"; $sub1="0"; }
                                                                            if($rowd['depart_id']=="5"){ 
                                                                                    $lrftot += $lrf1; echo number_format($lrf1); 
                                                                                    if($p=="1"){$jantot += $lrf1;} 
                                                                                    if($p=="2"){$febtot += $lrf1;}	
                                                                                    if($p=="3"){$martot += $lrf1;}	
                                                                                    if($p=="4"){$aprtot += $lrf1;}	
                                                                                    if($p=="5"){$maytot += $lrf1;}	
                                                                                    if($p=="6"){$juntot += $lrf1;}	
                                                                                    if($p=="7"){$jultot += $lrf1;}	
                                                                                    if($p=="8"){$augtot += $lrf1;}	
                                                                                    if($p=="9"){$septot += $lrf1;}	
                                                                                    if($p=="10"){$octtot += $lrf1;}	
                                                                                    if($p=="11"){$novtot += $lrf1;}	
                                                                                    if($p=="12"){$dectot += $lrf1;}	
                                                                                    $sav1="0"; $shr1="0"; $lnt1="0"; $sub1="0"; $lrf1="0"; $mbf1="0"; }
                                                                            if($rowd['depart_id']=="6"){ 
                                                                                    $mbftot += $mbf1; echo number_format($mbf1); 
                                                                                    if($p=="1"){$jantot += $mbf1;}
                                                                                    if($p=="2"){$febtot += $mbf1;}												
                                                                                    if($p=="3"){$martot += $mbf1;}												
                                                                                    if($p=="4"){$aprtot += $mbf1;}												
                                                                                    if($p=="5"){$maytot += $mbf1;}												
                                                                                    if($p=="6"){$juntot += $mbf1;}												
                                                                                    if($p=="7"){$jultot += $mbf1;}												
                                                                                    if($p=="8"){$augtot += $mbf1;}												
                                                                                    if($p=="9"){$septot += $mbf1;}												
                                                                                    if($p=="10"){$octtot += $mbf1;}												
                                                                                    if($p=="11"){$novtot += $mbf1;}												
                                                                                    if($p=="12"){$dectot += $mbf1;}												
                                                                                    $sav1="0"; $shr1="0"; $lnt1="0"; $sub1="0"; $lrf1="0"; $mbf1="0"; }
                                                                            if($rowd['depart_id']=="7"){ 
                                                                                $passtot += $passtot1; echo number_format($passtot1); 
                                                                                if($p=="1"){$jantot += $passtot1;}
                                                                                if($p=="2"){$febtot += $passtot1;}												
                                                                                if($p=="3"){$martot += $passtot1;}												
                                                                                if($p=="4"){$aprtot += $passtot1;}												
                                                                                if($p=="5"){$maytot += $passtot1;}												
                                                                                if($p=="6"){$juntot += $passtot1;}												
                                                                                if($p=="7"){$jultot += $passtot1;}												
                                                                                if($p=="8"){$augtot += $passtot1;}												
                                                                                if($p=="9"){$septot += $passtot1;}												
                                                                                if($p=="10"){$octtot += $passtot1;}												
                                                                                if($p=="11"){$novtot += $passtot1;}												
                                                                                if($p=="12"){$dectot += $passtot1;}												
                                                                                $sav1="0"; $shr1="0"; $lnt1="0"; $sub1="0"; $lrf1="0"; $mbf1="0"; $passtot1="0"; 
                                                                            }
                                                                        echo'</span></td>';
                                                                    }
                                                                    echo'	
                                                                                    <td><b class="pull-right">';
                                                                                    if($rowd['depart_id']=="1"){echo number_format($savtot);}
                                                                                    if($rowd['depart_id']=="2"){echo number_format($shrtot);}
                                                                                    if($rowd['depart_id']=="3"){echo number_format($lnttot);}
                                                                                    if($rowd['depart_id']=="4"){echo number_format($subtot);}
                                                                                    if($rowd['depart_id']=="5"){echo number_format($lrftot);}
                                                                                    if($rowd['depart_id']=="6"){echo number_format($mbftot);}
                                                                                    if($rowd['depart_id']=="6"){echo number_format($mbftot);}
                                                                                    if($rowd['depart_id']=="7"){echo number_format($passtot);}
                                                                    echo'	</b></td>
                                                                            </tr>
                                                                    ';
                                                            }
                                                    }
                                            }
                                    for($d=1;$d <= 12; $d++){
                                            foreach ($db->query("SELECT DISTINCT(accountcode) as accountcode FROM incometrail WHERE MONTH(income_date)='".$d."'") as $row1){
                                            foreach($db->query("SELECT SUM(amount) as amount FROM incometrail WHERE accountcode='".$rowcrd['accountcode']."'") as $rowcrdamt){}
                                            SECTIONS::$search_code = $rowcrd['accountcode'];
                                            SECTIONS::SEARCH_CODE();


                                            }
                                    }

                                    foreach($db->query("SELECT DISTINCT(accountcode) as accountcode FROM incometrail") as $rowcrd){

                                            SECTIONS::$search_code = $rowcrd['accountcode'];
                                            SECTIONS::SEARCH_CODE();
                                            echo "<tr>";
                                            echo "<td>".SECTIONS::$resultname."</td>";
                                            echo "<td></td>";
                                            $inctot = "0";
                                            for($d=1;$d <= 12; $d++){
                                                    foreach($db->query("SELECT SUM(amount) as amount FROM incometrail WHERE MONTH(income_date)='".$d."' AND accountcode='".$rowcrd['accountcode']."'") as $rowcrdamt){}
                                                    echo "<td><span class='pull-right'>".number_format($rowcrdamt['amount'])."</span></td>";
                                                    if($d=="1"){$jantot += $rowcrdamt['amount'];}
                                                    if($d=="2"){$febtot += $rowcrdamt['amount'];}												
                                                    if($d=="3"){$martot += $rowcrdamt['amount'];}												
                                                    if($d=="4"){$aprtot += $rowcrdamt['amount'];}												
                                                    if($d=="5"){$maytot += $rowcrdamt['amount'];}												
                                                    if($d=="6"){$juntot += $rowcrdamt['amount'];}												
                                                    if($d=="7"){$jultot += $rowcrdamt['amount'];}												
                                                    if($d=="8"){$augtot += $rowcrdamt['amount'];}												
                                                    if($d=="9"){$septot += $rowcrdamt['amount'];}												
                                                    if($d=="10"){$octtot += $rowcrdamt['amount'];}												
                                                    if($d=="11"){$novtot += $rowcrdamt['amount'];}												
                                                    if($d=="12"){$dectot += $rowcrdamt['amount'];}
                                                    $inctot += $rowcrdamt['amount'];	

                                            }
                                            echo "<td><b class='pull-right'>".number_format($inctot)."</b></td>";
                                            echo "</tr>";

                                    }
                                    $grandtot = $jantot+$febtot+$martot+$aprtot+$maytot+$juntot+$jultot+$augtot+$septot+$octtot+$novtot+$dectot;
                            echo '
                                            <tr style="font-size: 11px !important">
                                                    <td width="24%"><b>TOTAL (INFLOWS)</b></td>
                                                    <td></td>
                                                    <td><b class="pull-right">'.number_format($jantot).'</b></td>
                                                    <td><b class="pull-right">'.number_format($febtot).'</b></td>
                                                    <td><b class="pull-right">'.number_format($martot).'</b></td>
                                                    <td><b class="pull-right">'.number_format($aprtot).'</b></td>
                                                    <td><b class="pull-right">'.number_format($maytot).'</b></td>
                                                    <td><b class="pull-right">'.number_format($juntot).'</b></td>
                                                    <td><b class="pull-right">'.number_format($jultot).'</b></td>
                                                    <td><b class="pull-right">'.number_format($augtot).'</b></td>
                                                    <td><b class="pull-right">'.number_format($septot).'</b></td>
                                                    <td><b class="pull-right">'.number_format($octtot).'</b></td>
                                                    <td><b class="pull-right">'.number_format($novtot).'</b></td>
                                                    <td><b class="pull-right">'.number_format($dectot).'</b></td>
                                                    <td><b class="pull-right">'.number_format($grandtot).'</b></td>
                                            </tr>
                                            <tr style="font-size: 11px !important">
                                                    <td><b>OUTFLOWS</b></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                            </tr>';
                                    foreach ($db->query("SELECT DISTINCT(expensecode) as expcode FROM expensestracs") as $rowcrd){
                                            SECTIONS::$search_code = $rowcrd['expcode'];
                                            SECTIONS::SEARCH_CODE();
                                            echo '
                                                    <tr>
                                                            <td>'.SECTIONS::$resultname.'</td>
                                                            <td></td>

                                            ';
                                            $inctot = "0";
                                            for($d=1;$d <= 12; $d++){
                                                    foreach($db->query("SELECT SUM(paidamount) as amount FROM expensestracs WHERE MONTH(boughtdate)='".$d."' AND expensecode='".$rowcrd['expcode']."'") as $rowcrdamt){}
                                                    echo "<td><span class='pull-right'>".number_format($rowcrdamt['amount'])."</span></td>";
                                                    if($d=="1"){$jantot1 += $rowcrdamt['amount'];}
                                                    if($d=="2"){$febtot1 += $rowcrdamt['amount'];}												
                                                    if($d=="3"){$martot1 += $rowcrdamt['amount'];}												
                                                    if($d=="4"){$aprtot1 += $rowcrdamt['amount'];}												
                                                    if($d=="5"){$maytot1 += $rowcrdamt['amount'];}												
                                                    if($d=="6"){$juntot1 += $rowcrdamt['amount'];}												
                                                    if($d=="7"){$jultot1 += $rowcrdamt['amount'];}												
                                                    if($d=="8"){$augtot1 += $rowcrdamt['amount'];}												
                                                    if($d=="9"){$septot1 += $rowcrdamt['amount'];}												
                                                    if($d=="10"){$octtot1 += $rowcrdamt['amount'];}												
                                                    if($d=="11"){$novtot1 += $rowcrdamt['amount'];}												
                                                    if($d=="12"){$dectot1 += $rowcrdamt['amount'];}
                                                    $inctot += $rowcrdamt['amount'];
                                            }
                                            echo "<td><b class='pull-right'>".number_format($inctot)."</b></td>";
                                            echo "</tr>";
                                    }
                                    $jantot = "0";
                                    $febtot = "0";												
                                    $martot = "0";												
                                    $aprtot = "0";												
                                    $maytot = "0";												
                                    $juntot = "0";												
                                    $jultot = "0";												
                                    $augtot = "0";												
                                    $septot = "0";												
                                    $octtot = "0";												
                                    $novtot = "0";												
                                    $dectot = "0";
                                    $dat1 = array();
                                    foreach ($db->query("SELECT * FROM withdraws w, mergerwd m WHERE w.withdrawid = m.transactionid") as $rowdate){
                                            $indat = explode(":",$rowdate['inserteddate']);
                                            $indat2 = explode(" ",$indat[0]);
                                            array_push($dat1,$indat2[0]);
                                    }	
                                    $cods =array_unique($dat1);
                                    $oftot = "";
                                    $cods1 =array_unique($cods);
                                    echo'<tr style="font-size: 11px !important">
                                            <td>Withdraws</td>
                                            <td></td>';
                                            for($p=1;$p <= 12; $p++){
                                                    $totpop = "0";
                                                    $totpop1 = "0";
                                                    foreach($cods1 as $kl){
                                                            foreach ($db->query("SELECT * FROM withdraws WHERE inserteddate='".$kl."' AND MONTH(inserteddate)='".$p."'") as $rowdat){
                                                                    $totpiop += $rowdat['amount'];
                                                            }
                                                            $amt = $totpiop;
                                                            $totrow += $amt;
                                                    }

                                                    if($p=="1"){$jantot += $amt;}
                                                    if($p=="2"){$febtot += $amt;}												
                                                    if($p=="3"){$martot += $amt;}												
                                                    if($p=="4"){$aprtot += $amt;}												
                                                    if($p=="5"){$maytot += $amt;}												
                                                    if($p=="6"){$juntot += $amt;}												
                                                    if($p=="7"){$jultot += $amt;}												
                                                    if($p=="8"){$augtot += $amt;}												
                                                    if($p=="9"){$septot += $amt;}												
                                                    if($p=="10"){$octtot += $amt;}												
                                                    if($p=="11"){$novtot += $amt;}												
                                                    if($p=="12"){$dectot += $amt;}
                                                    echo'<td><span class="pull-right">'.number_format($amt).'</span></td>';
                                                    $totpiop ="0";
                                                    $totpiop1 ="0";
                                            }
                                    $totrow = $jantot+$febtot+$martot+$aprtot+$maytot+$juntot+$jultot+$augtot+$septot+$octtot+$novtot+$dectot;
                                    $grandtot1 += $totrow;
                                    echo'<td><b class="pull-right">'.number_format($totrow).'</b></td>';
                                    echo'</tr>';
                                    $totrow = "0";
                                    $jantot = "0";
                                    $febtot = "0";												
                                    $martot = "0";												
                                    $aprtot = "0";												
                                    $maytot = "0";												
                                    $juntot = "0";												
                                    $jultot = "0";												
                                    $augtot = "0";												
                                    $septot = "0";												
                                    $octtot = "0";												
                                    $novtot = "0";												
                                    $dectot = "0";
                                    $dat1 = array();
                                    foreach ($db->query("SELECT * FROM withdraws w, mergerwd m WHERE w.withdrawid = m.transactionid") as $rowdate){
                                            $indat = explode(":",$rowdate['inserteddate']);
                                            $indat2 = explode(" ",$indat[0]);
                                            array_push($dat1,$indat2[0]);
                                    }	
                                    $cods =array_unique($dat1);
                                    $oftot = "";
                                    $cods1 =array_unique($cods);
                                    echo'<tr style="font-size: 11px !important">
                                            <td>Loan Disbursements</td>
                                            <td></td>';
                                            for($p=1;$p <= 12; $p++){
                                                    $totpop = "0";
                                                    $totpop1 = "0";
                                                    foreach($cods1 as $kl){
                                                            foreach ($db->query("SELECT * FROM withdraws WHERE inserteddate='".$kl."' AND MONTH(inserteddate)='".$p."'") as $rowdat){
                                                                    $totpiop += $rowdat['amount'];
                                                            }
                                                            foreach ($db->query("SELECT * FROM withdraws WHERE DATE(inserteddate)='".$kl."' AND MONTH(inserteddate)='".$p."'") as $rowdat1){
                                                                    $totpiop1 += $rowdat1['amount'];
                                                            }
                                                            $amt = $totpiop1-$totpiop;
                                                            $totrow += $amt;
                                                    }
                                                    if($p=="1"){$jantot += $amt;}
                                                    if($p=="2"){$febtot += $amt;}												
                                                    if($p=="3"){$martot += $amt;}												
                                                    if($p=="4"){$aprtot += $amt;}												
                                                    if($p=="5"){$maytot += $amt;}												
                                                    if($p=="6"){$juntot += $amt;}												
                                                    if($p=="7"){$jultot += $amt;}												
                                                    if($p=="8"){$augtot += $amt;}												
                                                    if($p=="9"){$septot += $amt;}												
                                                    if($p=="10"){$octtot += $amt;}												
                                                    if($p=="11"){$novtot += $amt;}												
                                                    if($p=="12"){$dectot += $amt;}
                                                    echo'<td><span class="pull-right">'.number_format($amt).'</span></td>';
                                                    $totpiop ="0";
                                                    $totpiop1 ="0";
                                            }
                                    $totrow = $jantot+$febtot+$martot+$aprtot+$maytot+$juntot+$jultot+$augtot+$septot+$octtot+$novtot+$dectot;
                                    $grandtot1 += $totrow;				
                                    echo'<td><b class="pull-right">'.number_format($totrow).'</b></td>';
                                    echo'</tr>';
                                    $totrow = "0";



                            echo'
                                            <tr style="font-size: 11px !important">
                                                    <td><b>TOTAL (OUTFLOWS)</b></td>
                                                    <td></td>
                                                    <td><b class="pull-right">'.number_format($jantot1).'</b></td>
                                                    <td><b class="pull-right">'.number_format($febtot1).'</b></td>
                                                    <td><b class="pull-right">'.number_format($martot1).'</b></td>
                                                    <td><b class="pull-right">'.number_format($aprtot1).'</b></td>
                                                    <td><b class="pull-right">'.number_format($maytot1).'</b></td>
                                                    <td><b class="pull-right">'.number_format($juntot1).'</b></td>
                                                    <td><b class="pull-right">'.number_format($jultot1).'</b></td>
                                                    <td><b class="pull-right">'.number_format($augtot1).'</b></td>
                                                    <td><b class="pull-right">'.number_format($septot1).'</b></td>
                                                    <td><b class="pull-right">'.number_format($octtot1).'</b></td>
                                                    <td><b class="pull-right">'.number_format($novtot1).'</b></td>
                                                    <td><b class="pull-right">'.number_format($dectot1).'</b></td>
                                                    <td><b class="pull-right">'.number_format($grandtot1).'</b></td>
                                            </tr>
                                            <tr style="font-size: 11px !important">
                                                    <td><b>CASH AT HAND/BANK</b></td>
                                                    <td></td>
                                                    <td><b class="pull-right">'.number_format($jantot-$jantot1).'</b></td>
                                                    <td><b class="pull-right">'.number_format($febtot-$febtot1).'</b></td>
                                                    <td><b class="pull-right">'.number_format($martot-$martot1).'</b></td>
                                                    <td><b class="pull-right">'.number_format($aprtot-$aprtot1).'</b></td>
                                                    <td><b class="pull-right">'.number_format($maytot-$maytot1).'</b></td>
                                                    <td><b class="pull-right">'.number_format($juntot-$juntot1).'</b></td>
                                                    <td><b class="pull-right">'.number_format($jultot-$jultot1).'</b></td>
                                                    <td><b class="pull-right">'.number_format($augtot-$augtot1).'</b></td>
                                                    <td><b class="pull-right">'.number_format($septot-$septot1).'</b></td>
                                                    <td><b class="pull-right">'.number_format($octtot-$octtot1).'</b></td>
                                                    <td><b class="pull-right">'.number_format($novtot-$novtot1).'</b></td>
                                                    <td><b class="pull-right">'.number_format($dectot-$dectot1).'</b></td>
                                                    <td><b class="pull-right">'.number_format($grandtot-$grandtot1).'</b></td>
                                            </tr>
                                            <tr style="font-size: 11px !important">
                                                    <td><b>BALANCE C/F()</b></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                            </tr>
                                    </tbody>
                            </table>
                            ';			
		}
	}
}
class BUDGET extends database_crud{
    protected $table="budget";
    protected $pk="budget_id";
    public static $budget_id;    public static $budgetCheck;

    public static function ADD_BUDGET($month,$year){
	$budget = new BUDGET();  $db = new DB();
	$budget->month = $month;    $budget->year = $year; 
    foreach ($db->query("SELECT * FROM budget WHERE month='".$month."' AND year='".$year."'") as $row){
		static::$budgetCheck = "no";  
		static::$budget_id = $row['budget_id'];
    }
    if($row['budget_id']){
		static::$budget_id = $row['budget_id'];
	}else{
		$budget->create();
		static::$budget_id = $budget->pk;
    }
	
    }
	
	public static function GET_EXPESEACCOUTS(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM sections WHERE seccode='LVL002'") as $rows) {
           foreach ($db->query("SELECT * FROM level3 WHERE views='1' AND level2code like '2%'") as $rowx) {
				echo '<option value="' . $rowx['level2code'] . '"><b>('.$rowx['level2code'].')</b>  ' . $rowx['level2name'] . '</option>';
			}
			foreach ($db->query("SELECT * FROM level4 WHERE views='1' AND level3code like '2%'") as $rowx) {
				echo '<option value="' . $rowx['level3code'] . '"><b>('.$rowx['level3code'].')</b>  ' . $rowx['level3name'] . '</option>';
			}
			foreach ($db->query("SELECT * FROM level5 WHERE views='1' AND level4code like '2%'") as $rowx) {
				echo '<option value="' . $rowx['level4code'] . '"><b>('.$rowx['level4code'].')</b>  ' . $rowx['level4name'] . '</option>';
			}
        }

    }
	public static function GET_INCOMEACCOUTS(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM sections WHERE seccode='LVL003'") as $rows) {
           foreach ($db->query("SELECT * FROM level3 WHERE views='1' AND level2code like '3%'") as $rowx) {
				echo '<option value="' . $rowx['level2code'] . '"><b>('.$rowx['level2code'].')</b>  ' . $rowx['level2name'] . '</option>';
			}
			foreach ($db->query("SELECT * FROM level4 WHERE views='1' AND level3code like '3%'") as $rowx) {
				echo '<option value="' . $rowx['level3code'] . '"><b>('.$rowx['level3code'].')</b>  ' . $rowx['level3name'] . '</option>';
			}
			foreach ($db->query("SELECT * FROM level5 WHERE views='1' AND level4code like '3%'") as $rowx) {
				echo '<option value="' . $rowx['level4code'] . '"><b>('.$rowx['level4code'].')</b>  ' . $rowx['level4name'] . '</option>';
			}
        }

    }

	public static function GET_BUDGETOPTION(){
		$db = new DB();
		foreach($db->query("SELECT * FROM budget") as $row){
			echo '<option value="'.$row['budget_id'].'">'.$row['year'].' - '.$row['month'].'</option>';
		}
	}
	public static function GET_BUDGET(){
		$db = new DB();
		echo'<div class="panel-body scroll-pane" style="height: 420px;"><div  class="scroll-content"><center><label>INCOME BUDGET</label></center>
			<table id="budgetdata" class="table table-striped table-bordered"style="width: 100%; cellspacing: 0;">
					<tr>
						<th width="35%">ITEM</th>
						<th width="40%">DESCRIPTION</th>
						<th width="20%">AMOUNT</th>
						<th width="5%">EDIT</th></th>
					</tr>';
					
		foreach($db->query("SELECT * FROM budget_details WHERE budget_id='".$_GET['getbudgetview']."' AND type='2'") as $row){
			SECTIONS::$search_code = $row['accountcode'];
			SECTIONS::SEARCH_CODE();
			echo '<tr>';
			echo '<td width="35%">('.$row['accountcode'].') '.SECTIONS::$resultname.'</td>';
			echo '<td width="40%">'.$row['item_name'].'</td>';
			echo '<td width="20%">'.number_format($row['totalcost']).'</td>';
			echo '<td width="5%"><button onclick="getbudgeteditdata('.$row['item_id'].')" style="border: 0;background-color: transparent;"><i class="fa fa-pencil fa-2x"></i></button></td>';
			echo '</tr>';
		}
		echo '
			</table><br>
		';
		echo'<center><label>EXPENSE BUDGET</label></center>
			<table id="budgetdata" class="table table-striped table-bordered"style="width: 100%; cellspacing: 0;">
				<tr>
					<th width="35%">ITEM</th>
					<th width="40%">DESCRIPTION</th>
					<th width="20%">AMOUNT</th>
					<th width="5%">EDIT</th></th>
				</tr>';
		$data = array();
			foreach($db->query("SELECT accountcode FROM budget_details WHERE type='1'") as $row1){
				$indata = explode(" ",$row1['accountcode']);
				array_push($data,$indata[0]);
			}
			
			$codes =array_unique($data);
			
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
				foreach($db->query("SELECT * FROM budget_details WHERE budget_id='".$_GET['getbudgetview']."' AND type='1' AND accountcode like '".$k."%'") as $row){
					SECTIONS::$search_code = $row['accountcode'];
					SECTIONS::SEARCH_CODE();
					echo '<tr>';
					echo '<td width="35%">('.$row['accountcode'].') '.SECTIONS::$resultname.'</td>';
					echo '<td width="40%">'.$row['item_name'].','.$row['quatity'].' '.$row['uom'].', <b>@</b>'.$row['unitcost'].'</td>';
					echo '<td width="20%">'.number_format($row['totalcost']).'</td>';
					echo '<td width="5%"><button onclick="getbudgeteditdata('.$row['item_id'].')" style="border: 0;background-color: transparent;"><i class="fa fa-pencil fa-2x"></i></button></td>';
					echo '</tr>';
					$tot += $row['totalcost'];
				}
				echo '<tr>';
				echo '<td width="40%"></td>';
				echo '<td width="20%"></td>';
				echo '<td width="20%"><b>SUB TOTAL</b></td>';
				echo '<td width="20%"><b>'.number_format($tot).'</b></td>';
				echo '</tr>';
			}
		echo '
				</table>
			</div>
		</div>
		';
	}
	public static function GET_BUDGET1(){
		$db = new DB();
		echo'<center><label>INCOME BUDGET</label></center>
			<table id="budgetdata" class="table table-striped table-bordered"style="width: 100%; cellspacing: 0;">
					<tr>
						<th width="35%">ITEM</th>
						<th width="40%">DESCRIPTION</th>
						<th width="20%">AMOUNT</th>
					</tr>';
		foreach($db->query("SELECT * FROM budget_details WHERE budget_id='".$_GET['budgetviewdisplay']."' AND type='2'") as $row){
			SECTIONS::$search_code = $row['accountcode'];
			SECTIONS::SEARCH_CODE();
			echo '<tr>';
			echo '<td width="35%">('.$row['accountcode'].') '.SECTIONS::$resultname.'</td>';
			echo '<td width="40%">'.$row['item_name'].'</td>';
			echo '<td width="20%">'.number_format($row['totalcost']).'</td>';
			echo '</tr>';
		}
		echo '
			</table><br>
		';
		echo'<center><label>EXPENSE BUDGET</label></center>
			<table id="budgetdata" class="table table-striped table-bordered"style="width: 100%; cellspacing: 0;">
				<tr>
					<th width="35%">ITEM</th>
					<th width="40%">DESCRIPTION</th>
					<th width="20%">AMOUNT</th>
				</tr>';
			$data = array();
			foreach($db->query("SELECT accountcode FROM budget_details WHERE type='1'") as $row1){
				$indata = explode(" ",$row1['accountcode']);
				array_push($data,$indata[0]);
			}
			
			$codes =array_unique($data);
			$oftot = "";
			foreach($codes as $k){
				SECTIONS::$search_code = $k;
				SECTIONS::SEARCH_CODE();
				echo '<tr>';
				echo '<td width="35%"><b> '.SECTIONS::$resultname.'</b></td>';
				echo '<td width="40%"></td>';
				echo '<td width="20%"></td>';
				echo '</tr>';
				$tot = "";
				foreach($db->query("SELECT * FROM budget_details WHERE budget_id='".$_GET['budgetviewdisplay']."' AND type='1' AND accountcode like '".$k."%'") as $row){
					SECTIONS::$search_code = $row['accountcode'];
					SECTIONS::SEARCH_CODE();
					echo '<tr>';
					echo '<td width="35%">('.$row['accountcode'].') '.SECTIONS::$resultname.'</td>';
					echo '<td width="40%">'.$row['item_name'].','.$row['quatity'].' '.$row['uom'].', <b>@</b>'.$row['unitcost'].'</td>';
					echo '<td width="20%">'.number_format($row['totalcost']).'</td>';
					echo '</tr>';
					$tot += $row['totalcost'];
				}
				echo '<tr>';
				echo '<td width="35%"></td>';
				echo '<td width="40%"><b>SUB TOTAL</b></td>';
				echo '<td width="20%"><b>'.number_format($tot).'</b></td>';
				echo '</tr>';
				$oftot += $tot;
			}
			echo '<tr>';
				echo '<td width="35%"></td>';
				echo '<td width="40%"><b>TOTAL</b></td>';
				echo '<td width="20%"><b>'.number_format($oftot).'</b></td>';
				echo '</tr>';
		echo '
			</table>
		';
	}
	public static function GET_BUDGETEDITDATA(){
		$db = new DB();
		foreach($db->query("SELECT * FROM budget_details WHERE item_id='".$_GET['getbudgeteditdata']."'") as $row){
			SECTIONS::$search_code = $row['accountcode'];
			SECTIONS::SEARCH_CODE();
			if($row['type']=="1"){
				echo '
					<label class="labelcolor">Item Name</label>
					<input onclick="" id="items" type="text" class="form-control" value="'.$row['item_name'].'" placeholder="Enter Item Name"><br>
					<label class="labelcolor">Quantity</label>
					<input onclick="" id="qtys" type="text" class="form-control" value="'.$row['quatity'].'" placeholder="Enter Quantity"><br>
					<label class="labelcolor">UOM</label>
					<input onclick="" id="uoms" type="text" class="form-control" value="'.$row['uom'].'"  placeholder="Enter UOM"><br>
					<label class="labelcolor">Unit Cost</label>
					<input onclick="" id="unitcosts" type="text" class="form-control" value="'.$row['unitcost'].'"  placeholder="Enter Unit Cost"><br>
					<label class="labelcolor">Total Cost</label>
					<input onclick="" id="ttcosts" type="text" class="form-control" value="'.$row['totalcost'].'"  placeholder="Enter Total Cost"><br>
					<center>
						<button class="btn-primary btn" type="" onclick="SaveBudgetEditData('.$row['item_id'].','.$row['budget_id'].')" >Edit Record</button>
					</center> <br><br>
				';
			}
			if($row['type']=="2"){
				echo '
					<label class="labelcolor">Item Name</label>
					<input onclick="" id="items" type="text" class="form-control" value="'.$row['item_name'].'" placeholder="Enter Item Name"><br>
					<label class="labelcolor">Total Cost</label>
					<input onclick="" id="ttcosts" type="text" class="form-control" value="'.$row['totalcost'].'"  placeholder="Enter Total Cost"><br>
					<center>
						<button class="btn-primary btn" type="" onclick="SaveBudgetEditData1('.$row['item_id'].','.$row['budget_id'].')" >Edit Record</button>
					</center> <br><br>
				';
			}
		}
	}
	public static function BUDGETEDITCONTENT(){
		$db = new DB();
		$getval = (($_GET['budgetedit1'])?$_GET['budgetedit1']:$_GET['savebudgetedit']);
		$data = explode("?::?",$getval);
		if($_GET['budgetedit1']){
			$sql = 'UPDATE budget_details SET 
					item_name="'.$data[2].'",
					totalcost="'.$data[3].'"
				WHERE item_id ="'.$data[0].'"
			
			';
		}else{
			$sql = 'UPDATE budget_details SET 
						item_name="'.$data[2].'",
						quatity="'.$data[3].'",
						uom="'.$data[4].'",
						unitcost="'.$data[5].'",
						totalcost="'.$data[6].'"
					WHERE item_id ="'.$data[0].'"
			
			';
		}
		$db->query($sql);
		
		echo'<div class="panel-body scroll-pane" style="height: 420px;"><div  class="scroll-content"><center><label>INCOME BUDGET</label></center>
			<table id="budgetdata" class="table table-striped table-bordered"style="width: 100%; cellspacing: 0;">
					<tr>
						<th width="35%">ITEM</th>
						<th width="40%">DESCRIPTION</th>
						<th width="20%">AMOUNT</th>
						<th width="5%">EDIT</th></th>
					</tr>';
		foreach($db->query("SELECT * FROM budget_details WHERE budget_id='".$data[1]."' AND type='2'") as $row){
			SECTIONS::$search_code = $row['accountcode'];
			SECTIONS::SEARCH_CODE();
			echo '<tr>';
			echo '<td width="35%">('.$row['accountcode'].') '.SECTIONS::$resultname.'</td>';
			echo '<td width="40%">'.$row['item_name'].'</td>';
			echo '<td width="20%">'.number_format($row['totalcost']).'</td>';
			echo '<td width="5%"><button onclick="getbudgeteditdata('.$row['item_id'].')" style="border: 0;background-color: transparent;"><i class="fa fa-pencil fa-2x"></i></button></td>';
			echo '</tr>';
		}
		echo '
			</table><br>
		';
		echo'<center><label>EXPENSE BUDGET</label></center>
			<table id="budgetdata" class="table table-striped table-bordered"style="width: 100%; cellspacing: 0;">
				<tr>
					<th width="35%">ITEM</th>
					<th width="40%">DESCRIPTION</th>
					<th width="20%">AMOUNT</th>
					<th width="5%">EDIT</th></th>
				</tr>';
		foreach($db->query("SELECT * FROM budget_details WHERE budget_id='".$data[1]."' AND type='1'") as $row){
			SECTIONS::$search_code = $row['accountcode'];
			SECTIONS::SEARCH_CODE();
			echo '<tr>';
			echo '<td width="35%">('.$row['accountcode'].') '.SECTIONS::$resultname.'</td>';
			echo '<td width="40%">'.$row['item_name'].','.$row['quatity'].' '.$row['uom'].', <b>@</b>'.$row['unitcost'].'</td>';
			echo '<td width="20%">'.number_format($row['totalcost']).'</td>';
			echo '<td width="5%"><button onclick="getbudgeteditdata('.$row['item_id'].')" style="border: 0;background-color: transparent;"><i class="fa fa-pencil fa-2x"></i></button></td>';
			echo '</tr>';
		}
		echo '
				</table>
			</div>
		</div>
		';
	}
}
class POST_CHART extends database_crud {
    protected $table="post_chart";
    protected $pk="chartid";
    //SELECT `chartid`, `amount`, `depositeditems`, `depositedamts`, `inserteddate`,
    // `e_tag`, `clientid`, `userhandle` FROM `post_chart` WHERE 1
}
class MERGERWD extends database_crud {
    protected $table="mergerwd";
    protected $pk="mergeid";
    //SELECT `mergeid`, `transactiontype`, `transactionid`, `insertiondate`, `clientid` FROM `mergerwd` WHERE 1
}
class WITHDRAWS extends database_crud {
    protected $table="withdraws";
    protected $pk="withdrawid";
    //SELECT `withdrawid`, `clientid`, `amount`, `amount_inwords`, `user_handle`,
    // `re_tag`, `inserteddate`, `modifieddate`, `withdrawor` FROM `withdraws` WHERE 1

    public static function MAKE_WITHDRAW(){
        $withdraw = new WITHDRAWS();    $db = new DB();
        session_start();     NOW_DATETIME::NOW();     $merge = new MERGERWD();  $overdraft = new OVERDRAFT();
        $data = explode("?::?",$_GET['savewithdraw']);

        $db->query("UPDATE clients SET savingaccount = savingaccount - '".$data[0]."' WHERE clientid = '".$data[1]."'");
        foreach ($db->query("SELECT * FROM clients WHERE clientid = '".$data[1]."'") as $row){$savingbalnce = $row['savingaccount'];}
		
		// overdraft recording here
		if($row['savingaccount'] < $data[0]){
			
			$overdraftamt = $data[0] - $row['savingaccount'];
			foreach($db->query("SELECT * FROM overdrafts WHERE clientid='".$data[1]."' AND status='1'") as $rows){}
			if($rows['clientid']){
				
			}else{
				$overdraft->status = "1";
				$overdraft->clientid = $data[1];
				$overdraft->overdraftamt = -$row['savingaccount'];
				$overdraft->recordamt = -$row['savingaccount'];
				$overdraft->user_handle = $_SESSION['user_id'];
				$overdraft->odate = NOW_DATETIME::$Date;
				$overdraft->otime = NOW_DATETIME::$Time;
				$overdraft->create();
			}
		}
		
        $withdraw->clientid = $data[1];
        $withdraw->amount = $data[0];
        $withdraw->amount_inwords = $data[0];
        $withdraw->user_handle = $_SESSION['user_id'];
        $withdraw->re_tag = "0";
        $withdraw->balance = $savingbalnce;
        $withdraw->inserteddate = NOW_DATETIME::$Date_Time;
        $withdraw->modifieddate = NOW_DATETIME::$Date_Time;
        $withdraw->withdrawor = $data[2];
        $withdraw->create();

        $merge->transactiontype = "2";
        $merge->transactionid = $withdraw->pk;
        $merge->insertiondate = NOW_DATETIME::$Date;
        $merge->clientid = $data[1];
        $merge->create();

        CLIENT_DATA::$clientid = $data[1];
        CLIENT_DATA::RETURN_TRANSACTIONWD();
        echo '|<><>|';
        CLIENT_DATA::RETURN_CLIENTLEDGER();
        echo '|<><>|';
        CLIENT_DATA::RETURN_GENERALCLIENTLEDGER();
    }
	
	public static function WITHDRAWCASHCHECK(){	
		$db = new DB(); session_start();
		$data = explode("?::?",$_GET['withdrawcashcheck']);
		$overdraftlimt = ""; 
		
		foreach($db->query("SELECT * FROM cashierincharge WHERE cashier='".$_SESSION['user_id']."'") as $incharge){
			$expted = ($incharge['amount']+$incharge['dep']-$incharge['withd']);
			if($expted < $data[0]){
				echo "1";
			}else{ 
				foreach($db->query("SELECT * FROM clients WHERE clientid='".$data[1]."'") as $row){
					
					if($row['savingaccount'] < $data[0]){
						if($row['overdraftstatus'] == "1"){
							$overdraft = $data[0] - $row['savingaccount'];
							if($overdraft > $row['overdraftamt']){
								echo  "2"; echo "|<><>|"; echo number_format($row['overdraftamt']);
							}else{
								foreach($db->query("SELECT * FROM overdrafts WHERE clientid='".$data[1]."' AND status = '1'") as $rows){}
								if($rows['clientid']){
									echo "4"; echo "|<><>|"; echo number_format($rows['overdraftamt']);
								}else{
									echo "0";
								}
								
							}
						}else{
							echo "3";
						}
						
					}else{
						if($row['savetype'] == "5"){
							echo '5';
						}else{
							echo '0';
						}
						
					}
				}
			}
		} 
		 
		 
	}
}
class OVERDRAFT extends database_crud{
	protected $table = "overdrafts";
	protected $pk = "overdraftid";
	// SELECT `overdraftid`, `clientid`, `overdraftamt`, `user_handle`, `odate`, `otime` FROM `overdrafts` WHERE 1
}
class MULTIPLE_DEPOSITS extends database_crud {
    protected $table="noncashtracs";
    protected $pk="nontracid";
    //	SELECT `nontracid`, `clientid`, `user_handle`, `accountcode`, `amount`, `sbal`, `shrbal`,
	// `balance`, `ndate`, `ntime`, `ttype`, `rewardddeposit` FROM `noncashtracs` WHERE 1

    public static function SAVEMULTIPLEDEPOSIT(){
        $nocash = new MULTIPLE_DEPOSITS();    $db = new DB();
        session_start();     NOW_DATETIME::NOW();     $merge = new MERGERWD(); GENERAL_SETTINGS::GEN();
        $data = explode("?::?",$_GET['savemultipledeposit']);
		$res = ""; $clientid = "";
		if($data[0]=="1"){
			foreach($db->query("SELECT * FROM clients") as $row){ $clientid =$clientid."?--?". $row['clientid'];}
			$vals = SYS_CODES::split_on($clientid,4);
			$res = $vals[1];
		}else{
			$res = $data[2];
		}
		
		$clientdatavals = explode("?--?",$res);
		for($i = 0; $i< count($clientdatavals); $i++){
			$db->query("UPDATE clients SET savingaccount = savingaccount + '".$data[1]."' WHERE clientid = '".$clientdatavals[$i]."'");
			foreach ($db->query("SELECT * FROM clients WHERE clientid = '".$clientdatavals[$i]."'") as $row){$savingbalnce = $row['savingaccount'];}

			$nocash->ttype	= "1";
			$nocash->rewardddeposit	= $data[3];
			$nocash->clientid = $clientdatavals[$i];
			$nocash->accountcode = "d";
			$nocash->amount = $data[1];
			$nocash->user_handle = $_SESSION['user_id'];
			$nocash->sbal = $savingbalnce;
			$nocash->ndate = NOW_DATETIME::$Date;
			$nocash->ntime = NOW_DATETIME::$Time;
			$nocash->create();

			$merge->transactiontype = "6";
			$merge->transactionid = $nocash->pk;
			$merge->insertiondate = NOW_DATETIME::$Date_Time;
			$merge->clientid = $clientdatavals[$i];
			$merge->create();
		}

        self::RETURNEDNONCASHTRANSFER();
        echo '|<><>|';
        self::CANCELMULTIPLEDEPOSIT();
    }
	
	public static function CLIENTSIZEPARTICULAR(){
		
		if($_GET['clientsizeparticular'] == "2"){
			
			echo '
				<select onchange="addclientstotrail()" id="basic" class="selectpicker show-tick form-control" data-live-search="true">
					  <option value="">select member...</option>
					  ';CLIENT_DATA::CLIENT_OPTIONSEARCH();  echo'
				</select><br>
			';
		}else{
			echo '
				<select disabled onchange="addclientstotrail()" id="basic" class="selectpicker show-tick form-control" data-live-search="true">
					  <option value="">select member...</option>
					  ';CLIENT_DATA::CLIENT_OPTIONSEARCH();  echo'
				</select><br>
			';
		}
	}

	public static function ADDCLIENTS(){
		$data = explode("?::?", $_GET['addclientstotrail']);	$res = "";
		
		if($data[1] == ""){
			$res = $data[0];
			echo $res;
		}else{
			if($data[0] == ""){
				$res = $data[1];
			}else{
				$clne = explode("?--?",$data[1]);
				if(in_array($data[0],$clne)){$res = $data[1];}else{$res = $data[1]."?--?".$data[0];}
			}
			
			echo $res;
		}
		echo "|<><>|";
		$cln = explode("?--?",$res);
		for($i = 0;$i < count($cln); $i++){
			CLIENT_DATA::$clientid = $cln[$i];
			CLIENT_DATA::CLIENTDATAMAIN();
			echo ' <span style="line-height: 2.3" class="label label-primary">'.CLIENT_DATA::$accountname.'  <button onclick="removeclientid('.$cln[$i].')" class="btn btn-xs btn-danger-alt">x</button></span> ';
		}
	}
	
	public static function REMOVECLIENTS(){
		$data = explode("?::?", $_GET['removeclientid']);	$res = ""; $tes = ""; $pes = "";
		
		$clne = explode("?--?",$data[1]);
		// if(in_array($data[0],$clne)){$res = $data[1];}else{$res = $data[1]."?--?".$data[0];}
		for($i = 0;$i < count($clne); $i++){
			if($data[0] == $clne[$i]){$res = $res;}else{$res = $res."?--?".$clne[$i];}
		}
		$clnes = explode("?--?",$res);
		for($i = 0;$i < count($clnes); $i++){
			if($clnes[$i] == ""){$tes = $clnes[$i];}else{$tes = $tes."?--?".$clnes[$i];}
		}
		$dos = SYS_CODES::split_on($tes,4);
		$res = $dos[1];
		echo $res;
		echo "|<><>|";
		$cln = explode("?--?",$res);
		for($i = 0;$i < count($cln); $i++){
			if($cln[$i] == ""){}else{
				CLIENT_DATA::$clientid = $cln[$i];
				CLIENT_DATA::CLIENTDATAMAIN();
			echo ' <span style="line-height: 2.3" class="label label-primary">'.CLIENT_DATA::$accountname.'  <button onclick="removeclientid('.$cln[$i].')" class="btn btn-xs btn-danger-alt">x</button></span> ';
			}
			
		}
	}
	
	public static function RETURNEDNONCASHTRANSFER(){	
		$db = new DB();
		echo '
		<table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
			<thead>
				<tr class="info">
					<th width="40%">Account Detail</th>
					<th width="35%">Date and Time</th>
					<th width="25%">Transfer Detail</th>
				</tr>
			</thead>
			<tbody>
			'; 
			foreach($db->query("SELECT * FROM noncashtracs WHERE ttype='1' ORDER BY nontracid DESC") as $row){
				CLIENT_DATA::$clientid = $row['clientid'];
				CLIENT_DATA::CLIENTDATAMAIN();
				if($row['accountcode']=="2"){$accountcodename = "Share Capital";}
				if($row['accountcode']=="3"){$accountcodename = "Loan Repayment";}
				if($row['accountcode']=="5"){$accountcodename = "Loan Application Fee";}
				if($row['accountcode']=="6"){$accountcodename = "MemberShip Fee";}
				if($row['accountcode']=="7"){$accountcodename = "Pass Book / Stationary";}
				if($row['accountcode']=="8"){$accountcodename = "School Fees";}
				if($row['accountcode']=="d"){$accountcodename = "Multiple Deposit";}
				echo "<tr>";
				echo "<td data-order='1'><b style='color: #b9151b;'>".$accountcodename."</b>".(($row['rewardddeposit'] == "0")?" - <b style='color: #00af6e;'>Normal Deposit</b>":" - <b style='color: #03a9f4;'>Rewards</b>")."<br><b>".CLIENT_DATA::$accountname." </b> <b class='pull-right'>(".CLIENT_DATA::$accountno.")</b></td>";
				echo "<td>Transfer Date: <b>".$row['ndate']."</b><br>Time : <b> ".$row['ntime']."</b></td>";
				echo "<td>Transfer Amount : <b>".number_format($row['amount'])."</b><br>Saving Balance : <b>".number_format($row['sbal'])."</b></td>";
				echo "</tr>";
			} 
		echo'
			</tbody>
		</table>
		';
         
	}
	
	public static function CANCELMULTIPLEDEPOSIT(){
		echo '
			<b>Specify Deposit Type</b><br>
			<table>
				<tr>
					<td><input id="dep1" value="1" name="deptype"  type="radio"></td>
					<td>&nbsp;Rewards</td>
					<td>&nbsp;&nbsp;&nbsp;<input id="dep2" value="0" name="deptype"  type="radio"></td>
					<td>&nbsp;Normal Deposit</td>
				</tr>
			</table><br>
			<b>Specify Client Size</b><br>
			<table>
				<tr>
					<td><input onchange="clientsizeparticular()" id="yesacc1" value="1" name="bankcoice"  type="radio"></td>
					<td>&nbsp;All Clients</td>
					<td>&nbsp;&nbsp;&nbsp;<input onchange="clientsizeparticular()" id="noacc1" value="0" name="bankcoice"  type="radio"></td>
					<td>&nbsp;Selected Clients</td>
				</tr>
			</table>
			<div id="bankchoice1"></div><br>
			<div hidden id="clientloopid"></div>
			<div id="clientspace" class="alert alert-danger">
			</div>
			
			<label class="labelcolor">Client Name</label>
			<div id="clientdatatrail">
			<select disabled onchange="addclientstotrail()" id="basic" class="selectpicker show-tick form-control" data-live-search="true">
				  <option value="">select member...</option>
				  ';CLIENT_DATA::CLIENT_OPTIONSEARCH();  echo'
			</select><br>
			</div>
			<label class="labelcolor">Deposit Amount</label> 
			<input onclick="" id="amtrcvd" type="text" class="form-control" placeholder="Enter Amount Received"><br>
			<center>
				<button class="btn-primary btn" type="" onclick="savemultipledeposit()" >Submit Deposit Record</button>
				<button onclick="cancelmultipledeposit()" class="btn btn-default" >Cancel</button>  
			</center> <br><br>
		';
	}
}
class CASHACCOUNT  extends database_crud{
    protected $table = "cashaccounts";
    protected $pk = "cashid";
    //SELECT `cashid`, `coacode`, `descno`, `descbalance` FROM `cashaccounts` WHERE 1
    public static function ACTIVATEACCOUNTS(){
        $db = new DB(); $bank = new CASHACCOUNT();
        $data = explode("?::?",$_GET['activatebankactivate']);
        foreach($db->query("SELECT * FROM cashaccounts WHERE coacode='".$data[0]."'") as $rows){$code[]=$rows['descno'];}
        if($code){
            echo "1";
        }else{
            $bank->coacode = $data[0];
            $bank->descno = $data[1];
            $bank->descbalance = $data[2];
            $bank->create();
            echo "0";
        }
        echo '|<><>|';
        echo '
            <label class="labelcolor">Bank Account</label>
                <select onchange="" id="bankaccountact" class="selectpicker show-tick form-control" data-live-search="true">
                    <option value="">Select Bank Account</option>';
        EXPENSES::GET_BANKACCOUNTS();
        echo'
                </select><br><br>
                <label class="labelcolor">Bank Account No.</label>
                <input onclick="" id="accountno" type="" class="form-control" placeholder="Enter Account No."><br>
                <br>
                <label class="labelcolor">Bank Account Balance</label>
                <input onclick="" id="accountbalance" type="" class="form-control" placeholder="Enter Account Balance"><br>
                <br>
                <center>
                    <button class="btn-success btn" type="" onclick="ActivateBankActivate()">Activate Account</button>
                </center> <br><br>
            ';

    }
    public static function GET_BANKACCOUNT(){
        $db = new DB();
        foreach($db->query("SELECT * FROM cashaccounts") as $row){
            foreach($db->query("SELECT * FROM level4 WHERE level3code='".$row['coacode']."'") as $rows){
                echo '<option value="'.$row['coacode'].'">'.$rows['level3name'].'&nbsp;&nbsp;&nbsp;'.$row['descno'].'</option>';
            }
        }
    }
    public static function GET_BANKTRANSACTION(){
        $db = new DB();
        echo '
            <table cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
            <thead>
                <tr class="info">
                    <th width="30%">Account Name</th>
                    <th width="30%">Account Number</th>
                    <th width="40%">Account Balance</th>
                </tr>
            </thead>
            <tbody>';
        foreach($db->query("SELECT * FROM cashaccounts") as $row){
            foreach($db->query("SELECT * FROM level4 WHERE level3code='".$row['coacode']."'") as $rows){
                echo '<tr>';
                echo '<td style="font-size: 30px">'.$rows['level3name'].'</td>';
                echo '<td style="font-size: 30px">'.$row['descno'].'</td>';
                echo '<td style="font-size: 30px"><center><b>'.number_format($row['descbalance']).'</b></center></td>';
                echo '</tr>';
            }

        }
        echo'   </tbody>
        </table>
        ';
    }
    public static function GET_BANKACCOUNTS(){
        $db = new DB();
        echo'
            <select onchange="" id="bankaccounts" class="selectpicker show-tick form-control" data-live-search="true">
               <option value="">select Bank Account</option>';
        self::GET_BANKACCOUNT();
        echo '</select><br>';
    }
}
class CHEQUES extends database_crud{
    protected $table  = "chequeissues";
    protected $pk  = "chequeid";
    //SELECT `chequeid`, `issue_date`, `mature_date`, `issuedamt`, `bankaccount`, `chequeno`, `description`,
    // `accountno`, `accountname`, `status`, `feesamount`,'bankname', `inserteddate` FROM `chequeissues` WHERE 1
    public static function SAVE_CHEQUETRANSACTIONS(){
        $bank = new CHEQUES(); $db = new DB();
        NOW_DATETIME::NOW();
        $data = explode("?::?",$_GET['savechequetransaction']);

        $da = explode("/",$data[0]);
        $da1 = explode("/",$data[1]);
        $date = $da[2]."-".$da[0]."-".$da[1];
        $date1 = $da1[2]."-".$da1[0]."-".$da1[1];
        $bank->issue_date = $date;
        $bank->mature_date = $date1;
        $bank->issuedamt = $data[2];
        $bank->bankaccount = $data[3];
        $bank->chequeno = $data[4];
        $bank->description = $data[5];
        $bank->accountno = $data[6];
        $bank->accountname = $data[7];
        $bank->bankname = $data[8];
        $bank->status = "0";
        $bank->inserteddate = NOW_DATETIME::$Date_Time;

        if($data[9]){
            $bank->chequeid = $data[9];
            $bank->save();
        }else{
            $bank->create();
        }

        self::CANCEL_TRANSACTIONS();
        echo '|<><>|';
        echo '
                <table id="grat1" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr class="info">
                            <th width="10%">Date</th>
                            <th width="30%">Account Name</th>
                            <th width="50%">Description</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
        self::GET_TRANSACTIONS();
        echo'   </tbody>
                </table>
            ';
        echo '|<><>|';
        CASHACCOUNT::GET_BANKTRANSACTION();

    }
    public static function SAVE_CHEQUECHECK(){
        $bank = new CHEQUES(); $db = new DB();
        NOW_DATETIME::NOW();
        $data = explode("?::?",$_GET['savechequecheck']);
        foreach ($db->query("SELECT * FROM chequeissues  WHERE chequeid='".$data[1]."'") as $rowz){
            foreach($db->query("SELECT * FROM cashaccounts WHERE coacode='".$rowz['bankaccount']."'") as $row){
                foreach($db->query("SELECT * FROM level4 WHERE level3code='".$row['coacode']."'") as $rows){}
            }
        }
        $db->query("UPDATE cashaccounts SET descbalance=descbalance-'".$rowz['issuedamt']."'-'".$data[0]."' WHERE coacode='".$row['coacode']."'");
        $bank->status = "1";
        $bank->feesamount = $data[0];
        $bank->chequeid = $data[1];
        $bank->save();
        echo '
            <table id="grat1" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr class="info">
                        <th width="10%">Date</th>
                        <th width="30%">Account Name</th>
                        <th width="50%">Description</th>
                        <th width="10%">Actions</th>
                    </tr>
                </thead>
                <tbody>';
        self::GET_TRANSACTIONS();
        echo'   </tbody>
            </table>
        ';
        echo '|<><>|';
        CASHACCOUNT::GET_BANKTRANSACTION();

    }
    public static function GET_TRANSACTIONS(){
        $db = new DB(); NOW_DATETIME::NOW(); $loop= 1;
        foreach ($db->query("SELECT MAX(chequeid) as maxid FROM chequeissues") as $rowd){ $maxid = $rowd['maxid']; }
        foreach ($db->query("SELECT * FROM chequeissues ORDER BY inserteddate DESC") as $rowz){
            foreach($db->query("SELECT * FROM cashaccounts WHERE coacode='".$rowz['bankaccount']."'") as $row){
                foreach($db->query("SELECT * FROM level4 WHERE level3code='".$row['coacode']."'") as $rows){}
            }

            $da = explode(":",$rowz['inserteddate']);
            echo '<tr>';
            echo '<td width="10%" data-order="2017-00-00"><b>'.$rowz['inserteddate'].'</b></td>';
            echo '<td width="30%">
                <b>'.$rows['level3name'].'</b><br>
                Cheque No. : <b style="color: #009f51">'.$rowz['chequeno'].'</b><br>
                Issued Date : <b>'.$rowz['issue_date'].'</b><br>
                Mature Date : <b>'.$rowz['mature_date'].'</b><br>
                <b>Status : </b>'.(($rowz['status']=="0")?" UnPresented":(($rowz['status']=="1")?"<b style='color: #9f2d19'>Banked Already</b>":"")).'</td>';
            echo '<td width="50%">
                <b>'.$rowz['description'].'</b><br>
                Bank Name : <b>'.$rowz['bankname'].'</b><br>
                Account Name : <b>'.$rowz['accountname'].'</b><br>
                Account No. : <b>'.$rowz['accountno'].'</b><br>
                Issued Amount : <b>'.number_format($rowz['issuedamt']).'</b><br>
                Cheque Process Charges : <b style="color: #0a377e">'.$rowz['feesamount'].'</b> <br>
                <div hidden id="chequetrac'.$loop.'">
                <b>Enter Charges</b> <input id="inputchequecheck'.$loop.'" style="width:100px;height: 28px;">&nbsp;&nbsp;
                <button onclick="savechequecheck('.$loop.','.$rowz['chequeid'].')" class="btn btn-xs btn-social btn-info" >save</button>
                <button onclick="cancelchequecheck('.$loop.')" class="btn btn-xs btn-social btn-apple" >cancel</button>
                </div></td>';
            echo '<td width="10%">
                    <center>
                        <button style="border:0;background-color:transparent;" '.(($rowz['status']=="1")?'disabled':(($maxid==$rowz['chequeid'])?((NOW_DATETIME::$Date != $da[0])?'disabled':''):'disabled')).' onclick="GetChequeTransaction('.$rowz['chequeid'].')"><i class="fa fa-pencil fa-2x"></i></button><br><br>
                        <button '.(($rowz['status']=="1")?'disabled':'').' onclick="getchequecheck('.$loop.')" class="btn btn-sm btn-social btn-success"><i class="fa fa-check fa-2x"></i></button>
                    </center></td>';
            echo '</tr>';
            $loop++;
        }
    }
    public static function RETURN_TRANSACTIONS(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM chequeissues WHERE chequeid='".$_GET['getchequetransaction']."'") as $rowz){
            foreach($db->query("SELECT * FROM cashaccounts WHERE coacode='".$rowz['bankaccount']."'") as $row){
                foreach($db->query("SELECT * FROM level4 WHERE level3code='".$row['coacode']."'") as $rows){}
            }
            $da = explode("-",$rowz['issue_date']);
            $da1 = explode("-",$rowz['mature_date']);
            $date = $da[1]."/".$da[2]."/".$da[0];
            $date1 = $da1[1]."/".$da1[2]."/".$da1[0];
            echo '
        <div hidden id="chequetracteditcode">'.$_GET['getchequetransaction'].'</div>
        <label class="labelcolor">Bank Account</label>
        <select onchange="" id="accounttoissue" class="selectpicker show-tick form-control" data-live-search="true">
           <option value="'.(($row['coacode'])?$row['coacode']:"").'">'.(($row['coacode'])?$rows['level3name'].'&nbsp;&nbsp;&nbsp;'.$row['descno']:"").'</option>';
            CASHACCOUNT::GET_BANKACCOUNT();
            echo'
        </select><br><br>
        <label class="labelcolor">Amount Issued.</label>
        <input onclick="" id="amountissued" type="date" value="'.$rowz['issuedamt'].'" class="form-control" placeholder="Enter Amount Issued."><br>
        <br>
        <label class="labelcolor">Description</label>
        <TextArea onclick="" id="descriptionissue" type="text" class="form-control" placeholder="Enter Description">'.$rowz['description'].'</TextArea><br>
        <div class="col-md-6">
        <label class="labelcolor">Issued Date</label>
        <input onclick="" id="datepicker1" type="text" value="'.$date.'" class="form-control" placeholder="Enter Issued Date"><br>
        </div>
        <div class="col-md-6">
        <label class="labelcolor">Mature Date</label>
        <input onclick="" id="datepicker2" type="text" value="'.$date1.'" class="form-control" placeholder="Enter Mature Date"><br>
        </div><br>
        <label class="labelcolor">Cheque No.</label>
        <input onclick="" id="chequeno" type="text" value="'.$rowz['chequeno'].'" class="form-control" placeholder="Enter Cheque No."><br>
        <h4 style="font-weight: 900">Received By</h4><hr>
        <div class="col-md-6">
        <label class="labelcolor">Account Name</label>
        <input onclick="" id="accname" type="text" value="'.$rowz['accountname'].'" class="form-control" placeholder="Enter Account Name"><br>
        </div>
        <div class="col-md-6">
        <label class="labelcolor">Account No.</label>
        <input onclick="" id="accno" type="text" value="'.$rowz['accountno'].'" class="form-control" placeholder="Enter Account No."><br>
        </div><br><br>
         <label class="labelcolor">Bank Name</label>
        <input onclick="" id="bankoname" type="text" value="'.$rowz['bankname'].'" class="form-control" placeholder="Enter Bank Name"><br>
        <center>
            <button class="btn-success btn" type="" onclick="SaveChequeTransaction()">Issue Cheque</button>
            <button onclick="ClearISSUECHEQUE()" type="reset" class="btn btn-default">Cancel</button>
        </center> <br><br>
        ';
        }
    }
    public static function CANCEL_TRANSACTIONS(){
        echo '
        <div hidden id="chequetracteditcode"></div>
        <label class="labelcolor">Bank Account</label>
        <select onchange="" id="accounttoissue" class="selectpicker show-tick form-control" data-live-search="true">
            <option value="">Select Bank Account</option>';
        CASHACCOUNT::GET_BANKACCOUNT();
        echo'
        </select><br><br>
        <label class="labelcolor">Amount Issued.</label>
        <input onclick="" id="amountissued" type="" class="form-control" placeholder="Enter Amount Issued."><br>
        <br>
        <label class="labelcolor">Description</label>
        <TextArea onclick="" id="descriptionissue" type="text" class="form-control" placeholder="Enter Description"></TextArea><br>
        <div class="col-md-6">
        <label class="labelcolor">Issued Date</label>
        <input onclick="" id="datepicker1" type="" class="form-control" placeholder="Enter Issued Date"><br>
        </div>
        <div class="col-md-6">
        <label class="labelcolor">Mature Date</label>
        <input onclick="" id="datepicker2" type="" class="form-control" placeholder="Enter Mature Date"><br>
        </div><br>
        <label class="labelcolor">Cheque No.</label>
        <input onclick="" id="accountno" type="" class="form-control" placeholder="Enter Cheque No."><br>
        <h4 style="font-weight: 900">Received By</h4><hr>
        <div class="col-md-6">
        <label class="labelcolor">Account Name</label>
        <input onclick="" id="accname" type="text" class="form-control" placeholder="Enter Account Name"><br>
        </div>
        <div class="col-md-6">
        <label class="labelcolor">Account No.</label>
        <input onclick="" id="accno" type="text" class="form-control" placeholder="Enter Account No."><br>
        </div><br><br>
        <label class="labelcolor">Bank Name</label>
        <input onclick="" id="bankoname" type="" class="form-control" placeholder="Enter Bank Name"><br>
        <center>
            <button class="btn-success btn" type="" onclick="SaveChequeTransaction()">Issue Cheque</button>
            <button onclick="ClearISSUECHEQUE()" type="reset" class="btn btn-default">Cancel</button>
        </center> <br><br>
        ';
    }
}
class FINANCIALINSTITUTION extends database_crud{
    protected $table = "financialinstitutions";
    protected $pk = "instid";
    //SELECT `instid`, `instname`, `status` FROM `financialinstitutions` WHERE 1
    public static function SAVE_INSTITUTION(){
        $int = new FINANCIALINSTITUTION();  $returnedmsg = "";  $db = new DB();
        $data = explode("?::?",$_GET['savefinancialint']);
        foreach($db->query("SELECT * FROM financialinstitutions WHERE instname='".$data[0]."'") as $row){
            $rdata = $row['instname'];
        }
        if($rdata){$returnedmsg="1";}else{
            if($data[2]){
                $db = new DB();
                foreach($db->query("SELECT * FROM cashaccounts WHERE coacode='".$data[2]."'") as $row){
                    foreach($db->query("SELECT * FROM level4 WHERE level3code='".$row['coacode']."'") as $rows){
                        $int->instname = $rows['level3name'];
                        $int->coacodeds = $data[2];
                    }
                }
            }else{
                $int->instname = $data[0];
            }
            if($data[1]){
                $int->instid = $data[1];
                $int->save();
            }else{
                $int->create();
            }
        }


        self::CANCEL_INSTITUTION();
        echo '|<><>|';
        BORROWINGS::CANCEL_BORROWING();
        echo '|<><>|';
        echo $returnedmsg;
    }
    public static function OPTION_INSTITUTION(){
        $db = new DB();
        foreach($db->query("SELECT * FROM financialinstitutions") as $row){
            echo '<option value="'.$row['instid'].'">'.$row['instname'].'</option>';
        }
    }
    public static function GET_BANK(){
        echo'
        <div class="row">
            <div class="col-md-6 col-md-offset-1">
                <label class="labelcolor">Bank Account</label>
                <select onchange="returnbankinfochoice()" id="bankaccountchoice" class="selectpicker show-tick form-control" data-live-search="true">
                    <option value="">select Bank Account</option>';
        CASHACCOUNT::GET_BANKACCOUNT();
        echo'
                </select><br><br>
            </div></div>';

    }
    public static function GET_BANK1(){
        echo'
        <div class="row">
            <div class="col-md-8 col-md-offset-0">
                <label class="labelcolor">Bank Account</label>
                <select onchange="returnbankinfochoice()" id="bankaccountchoice1" class="selectpicker show-tick form-control" data-live-search="true">
                    <option value="">select Bank Account</option>';
        CASHACCOUNT::GET_BANKACCOUNT();
        echo'
                </select><br><br>
            </div></div>';

    }
    public static function GET_BANKACCOUNT(){
        $db = new DB();
        foreach($db->query("SELECT * FROM cashaccounts WHERE coacode='".$_GET['getbankchoicedetailsinfo']."'") as $row){
            foreach($db->query("SELECT * FROM level4 WHERE level3code='".$row['coacode']."'") as $rows){
                echo $rows['level3name'];
            }

        }
    }
    public static function GET_INSTITUTION(){
        $db = new DB();
        foreach($db->query("SELECT * FROM financialinstitutions WHERE instid='".$_GET['getfinancialint']."'") as $row){
            echo $row['instname'];
        }
    }
    public static function CANCEL_INSTITUTION(){
        echo '
            <center><h5><b>Add Financial Institution</b></h5></center><br>
            <div class="col-md-12">
            <b>Do you have an account in this institution?</b><br>
            <table>
                <tr>
                    <td><input onchange="bankchoicefun()" id="yesacc" value="1" name="optionadiosInline"  type="radio"></td>
                    <td>&nbsp;Yes</td>
                    <td>&nbsp;&nbsp;&nbsp;<input onchange="bankchoicefun()" id="noacc" value="0" name="optionadiosInline"  type="radio"></td>
                    <td>&nbsp;No</td>
                </tr>
            </table>
            <div id="bankchoice"></div>
            </div>
            <div class="col-md-6">
            <label class="labelcolor">Financial Institution</label>
            <input onclick="" id="financialint" type="text" class="form-control" placeholder="Enter Financial Institution"><br>
            <center>
                <button class="btn-info btn-social btn" type="" onclick="savefinancialinstitution()">save</button>
                <button class="btn-apple btn-social btn" type="" onclick="cancelfinancialinstitution()">cancel</button>
            </center><br>
            </div>
            <div class="col-md-6">
            <label class="labelcolor">Select to Modify Institution</label>
            <select onchange="getfinancialinstitution()" id="returnfinainst" class="form-control">
                    <option value="">Select Financial Institution</option>';
        FINANCIALINSTITUTION::OPTION_INSTITUTION();
        echo'
            </select><br>
            <br></div>
        ';
    }
    public static function GET_ORGANISATION(){
        $db = new DB();
        foreach($db->query("SELECT * FROM financialinstitutions WHERE instid='".$_GET['getorganisationchoice']."'") as $row){
            if($row['coacodeds']==null){
                echo '
                    <div class="col-md-12">
                        <b>Specify Payment Method</b><br>
                        <table>
                            <tr>
                                <td><input onchange="bankchoicefun1()" id="yesacc1" value="1" name="bankcoice"  type="radio"></td>
                                <td>&nbsp;Bank</td>
                                <td>&nbsp;&nbsp;&nbsp;<input onchange="bankchoicefun1()" id="noacc1" value="0" name="bankcoice"  type="radio"></td>
                                <td>&nbsp;Cash</td>
                            </tr>
                        </table>
                        <div id="bankchoice1"></div>
                    </div>
                ';
            }else{
                echo '';
            }
        }
    }
    public static function GET_ORGANISATION1(){
        $db = new DB();
        foreach($db->query("SELECT * FROM financialinstitutions WHERE instid='".$_GET['getorganisationchoice']."'") as $row){
            if($row['coacodeds']==null){
                echo '
                    <div class="col-md-12">
                        <b>Specify Payment Method</b><br>
                        <table>
                            <tr>
                                <td><input onchange="bankchoicefun1()" id="yesacc1" value="1" name="bankcoice"  type="radio"></td>
                                <td>&nbsp;Bank</td>
                                <td>&nbsp;&nbsp;&nbsp;<input onchange="bankchoicefun1()" id="noacc1" value="0" name="bankcoice"  type="radio"></td>
                                <td>&nbsp;Cash</td>
                            </tr>
                        </table>
                        <div id="bankchoice1"></div>
                    </div>
                ';
            }else{
                echo '';
            }
        }
    }
}
class BORROWINGS extends database_crud{
    protected $table = "borrowings";
    protected $pk = "borrowingid";
    //SELECT `borrowingid`, `intitutionid`, `acctype`, `description`, `borrowedamt`, `interesttobepaid`,
    //`processingcharge`, `principal`, `interest`, `charges`, `inserted_date`, `Startdate`, `Enddate` FROM `borrowings` WHERE 1
    public static function SAVE_BORROWING(){
        $int = new BORROWINGS();    NOW_DATETIME::NOW();
        $debt = new TRANSACTION_MAPPER();   $db = new DB();
        $data = explode("?::?",$_GET['saveborrowing']);
        $da = explode("/",$data[4]);
        $da1 = explode("/",$data[5]);
        $date = $da[2]."-".$da[0]."-".$da[1];
        $date1 = $da1[2]."-".$da1[0]."-".$da1[1];
        $int->intitutionid = $data[0];
        $int->borrowedamt = $data[1];
        $int->interesttobepaid = $data[2];
        $int->processingcharge = $data[3];
        $int->principal = $data[1];
        $int->interest = $data[2];
        $int->charges = $data[3];
        $int->Startdate = $date;
        $int->Enddate = $date1;
        if($data[7]){
            if($data[7]=="1"){
                $int->acctype = $data[7];  $int->description  = $data[8];
                $db->query("UPDATE cashaccounts SET descbalance=descbalance+'".$data[1]."'-'".$data[3]."' WHERE coacode='".$data[8]."'");
            }else {
                $int->acctype = $data[7];
            }
        }else{
            $db->query("UPDATE cashaccounts SET descbalance=descbalance+'".$data[1]."'-'".$data[3]."' WHERE coacode='".$data[0]."'");
            foreach($db->query("SELECT * FROM financialinstitutions WHERE instid='".$data[0]."'") as $row){
                $int->description  = $row['coacodeds'];
            }
        }
        if($data[6]){

            $int->borrowingid = $data[6];
            $int->save();
        }else{
            $int->inserted_date = NOW_DATETIME::$Date_Time;
            $int->create();
            $debt->transaction_amount = $data[3];
            $debt->transac_id = $int->pk;
            $debt->trans_code = "202 1";
            $debt->gotfrom = "1";
            $debt->trans_date = NOW_DATETIME::$Date_Time;
            $debt->create();
        }
        self::CANCEL_BORROWING();
        echo '|<><>|';
        echo '
            <table id="grat2" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr class="info">
                        <th width="10%">Date</th>
                        <th width="30%">Borrowed From</th>
                        <th width="50%">Description</th>
                        <th width="10%">Actions</th>
                    </tr>
                </thead>
                <tbody>';
        self::GET_BORROWINGS();
        echo'   </tbody>
            </table>
        ';
        echo '|<><>|';
        CASHACCOUNT::GET_BANKTRANSACTION();
        echo '|<><>|';
        echo '
            <table class="table table-bordered" >
                <tr>
                    <td width="40%"><b>Borrowed From</b></td>
                    <td width="20%"><b>Principal</b></td>
                    <td width="20%"><b>Interest</b></td>
                    <td width="20%"><b>Fines/Charges</b></td>
                    <td width="5%"><b>Action</b></td>
                </tr>
                <tr>
                    <td>
                        <select onchange="getborrowedinfo()" id="getfinaintname" class="selectpicker show-tick form-control" data-live-search="true">
                            <option value="">Select Borrowed From</option>';
        BORROWINGS::OPTION_BORROWING();
        echo'
                        </select>
                    </td>
                    <td><input onclick="" id="financialint" type="text" class="form-control" placeholder="Principal"></td>
                    <td><input onclick="" id="financialint" type="text" class="form-control" placeholder="Interest"></td>
                    <td><input onclick="" id="financialint" type="text" class="form-control" placeholder="Fines/Charges"></td>
                    <td>
                        <center>
                            <button class="btn-info btn-social btn" type="" onclick="saverepaymentborrowing()">save</button>
                        </center>
                    </td>
                </tr>
            </table>
        ';
    }
    public static function OPTION_BORROWING(){
        $db = new DB();
        foreach($db->query("SELECT * FROM borrowings b, financialinstitutions f WHERE f.instid=b.intitutionid") as $row){
            echo '<option value="'.$row['borrowingid'].'">'.$row['instname'].'</option>';
        }
    }
    public static function DETAILS_BORROWING(){
        $db = new DB();
        foreach($db->query("SELECT * FROM borrowings b, financialinstitutions f WHERE f.instid=b.intitutionid AND b.borrowingid='".$_GET['getborrowingdetails']."'") as $row){
            foreach($db->query("SELECT SUM(reprincipal) as princ,SUM(reinterest) as interbal FROM borrowingrepayments WHERE borrowingid='".$_GET['getborrowingdetails']."'") as $rowz){}

            echo '
                <table width="100%">
                    <tr>
                        <td width="30%"><b style="color: #ffffff;font-weight: 900">Amount Borrowed :</b></td>
                        <td width="18%">&nbsp;&nbsp;&nbsp;<b>'.number_format($row['borrowedamt']).'</b></td>
                        <td width="10%">&nbsp;&nbsp;&nbsp;<b style="color: #ffffff;font-weight: 900">Bal :</b></td>
                        <td width="16%">&nbsp;&nbsp;&nbsp;<b>'.number_format($row['principal']).'</b></td>
                        <td width="10%">&nbsp;&nbsp;&nbsp;<b style="color: #ffffff;font-weight: 900">Paid :</b></td>
                        <td width="16%">&nbsp;&nbsp;&nbsp;<b>'.number_format($rowz['princ']).'</b></td>
                    </tr>
                    <tr>
                        <td><b style="color: #ffffff;font-weight: 900">Interest to be Paid :</b></td>
                        <td>&nbsp;&nbsp;&nbsp;<b>'.number_format($row['interesttobepaid']).'</b></td>
                        <td>&nbsp;&nbsp;&nbsp;<b style="color: #ffffff;font-weight: 900">Bal :</b></td>
                        <td>&nbsp;&nbsp;&nbsp;<b>'.number_format($row['interest']).'</b></td>
                        <td>&nbsp;&nbsp;&nbsp;<b style="color: #ffffff;font-weight: 900">Paid :</b></td>
                        <td>&nbsp;&nbsp;&nbsp;<b>'.number_format($rowz['interbal']).'</b></td>
                    </tr>
                </table>
            ';
            echo '|<><>|';
            if($row['coacodeds']==null){
                echo '
                    <div class="col-md-4">
                        <table>
                            <tr>
                                <td>&nbsp;<label class="labelcolor">Repayment Date</label>
                                <input onclick="" id="datepicker5" type="text" class="form-control" placeholder="Enter Repayment Date"></td>
                            </tr>
                        </table><br>
                    </div>
                    <div class="col-md-6">
                        <b>Specify Payment Method</b><br>
                        <table>
                            <tr>
                                <td><input onchange="" id="yesacc1" value="1" name="bankcoice"  type="radio"></td>
                                <td>&nbsp;Bank</td>
                                <td>&nbsp;&nbsp;&nbsp;<input onchange="" id="noacc1" value="0" name="bankcoice"  type="radio"></td>
                                <td>&nbsp;Cash</td>
                            </tr>
                        </table>
                    </div>
                ';
                echo '|<><>|';
                echo '
                    <table id="example" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                        <thead>
                            <tr class="info">
                                <th width="25%">Date</th>
                                <th width="25%">Paid Principal</th>
                                <th width="25%">Interest</th>
                                <th width="25%">Fines</th>
                            </tr>
                        </thead>
                        <tbody>';
                foreach($db->query("SELECT * FROM borrowingrepayments WHERE borrowingid='".$_GET['getborrowingdetails']."' ORDER BY repaydate DESC") as $row){
                    echo '<tr>';
                    echo '<td data-order="2017-00-00">'.$row['repaydate'].'</td>';
                    echo '<td><b>Paid:</b>'.number_format($row['reprincipal']).'<br><b>Bal:</b>&nbsp;&nbsp;'.number_format($row['princbal']).'</td>';
                    echo '<td><b>Paid:</b>'.number_format($row['reinterest']).'<br><b>Bal:</b>&nbsp;&nbsp;'.number_format($row['interbal']).'</td>';
                    echo '<td>'.number_format($row['recharge']).'</td>';
                    echo '</tr>';
                }
                echo'</tbody>
                    </table>
                ';
            }else{
                echo'
                    <div class="col-md-4">
                        <table>
                            <tr>
                                <td>&nbsp;<label class="labelcolor">Repayment Date</label>
                                <input onclick="" id="datepicker5" type="text" class="form-control" placeholder="Enter Repayment Date"></td>
                            </tr>
                        </table><br>
                    </div>
                ';
				echo '|<><>|';
                echo '
                    <table id="example" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                        <thead>
                            <tr class="info">
                                <th width="25%">Date</th>
                                <th width="25%">Paid Principal</th>
                                <th width="25%">Interest</th>
                                <th width="25%">Fines</th>
                            </tr>
                        </thead>
                        <tbody>';
                foreach($db->query("SELECT * FROM borrowingrepayments WHERE borrowingid='".$_GET['getborrowingdetails']."' ORDER BY repaydate DESC") as $row){
                    echo '<tr>';
                    echo '<td data-order="2017-00-00">'.$row['repaydate'].'</td>';
                    echo '<td><b>Paid:</b>'.number_format($row['reprincipal']).'<br><b>Bal:</b>&nbsp;&nbsp;'.number_format($row['princbal']).'</td>';
                    echo '<td><b>Paid:</b>'.number_format($row['reinterest']).'<br><b>Bal:</b>&nbsp;&nbsp;'.number_format($row['interbal']).'</td>';
                    echo '<td>'.number_format($row['recharge']).'</td>';
                    echo '</tr>';
                }
                echo'</tbody>
                    </table>
                ';
            }
        }

    }
    public static function GET_BORROWINGS(){
        $db = new DB();
        foreach ($db->query("SELECT MAX(borrowingid) as maxid FROM borrowings") as $rowd){ $maxid = $rowd['maxid']; }
        foreach($db->query("SELECT * FROM borrowings b, financialinstitutions f WHERE f.instid=b.intitutionid ORDER BY borrowingid DESC") as $rowz){
            $date = explode(":",$rowz['inserted_date']);
            echo '<tr>';
            echo '<td width="10%" data-order="2017-00-00"><b>'.$rowz['inserted_date'].'</b></td>';
            echo '<td width="30%"><b>'.$rowz['instname'].'</b><br>
                    Start Date: <b>'.$rowz['Startdate'].'</b><br>
                    End Date: <b>'.$rowz['Enddate'].'</b>
                </td>';
            echo '<td width="50%">
                    Amount Borrowed : <b>'.number_format($rowz['borrowedamt']).'</b><br>
                    Interest to be Paid : <b>'.number_format($rowz['interesttobepaid']).'</b><br>
                    Fees & Charges : <b>'.number_format($rowz['processingcharge']).'</b><br>
                </td>';
            echo '<td width="10%">
                    <center>
                        <button style="border:0;background-color:transparent;" '.(($maxid==$rowz['borrowingid'])?((NOW_DATETIME::$Date != $date[0])?'disabled':''):'disabled').' onclick="GetBorrowingTransaction('.$rowz['borrowingid'].')"><i class="fa fa-pencil fa-2x"></i></button>
                    </center>
                 </td>';
            echo '</tr>';
        }
    }
    public static function RETURN_BORROWING(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM borrowings b, financialinstitutions f WHERE f.instid=b.intitutionid AND b.borrowingid='".$_GET['getborrowingtransaction']."'") as $rowz) {
            $da = explode("-",$rowz['Startdate']);
            $da1 = explode("-",$rowz['Enddate']);
            $date = $da[1]."/".$da[2]."/".$da[0];
            $date1 = $da1[1]."/".$da1[2]."/".$da1[0];
            echo '
            <label class="labelcolor">Borrowed From</label>
            <select onchange="getOrganisation()" id="finaintname" class="selectpicker show-tick form-control" data-live-search="true">
                <option value="'.$rowz['instid'].'">'.$rowz['instname'].'</option>';
            FINANCIALINSTITUTION::OPTION_INSTITUTION();
            echo '
            </select><br><br>
            <div id="accountafftchoice"></div>
            <label class="labelcolor">Borrowed Amount.</label>
            <input onclick="" id="borrowedamount" type="text" value="'.$rowz['borrowedamt'].'" class="form-control" placeholder="Enter Borrowed Amount"><br>
            <label class="labelcolor">Interest To Be Paid</label>
            <input onclick="" id="loaninterest" type="text" value="'.$rowz['interesttobepaid'].'" class="form-control" placeholder="Enter Interest"><br>
            <label class="labelcolor">Fees & Charges</label>
            <input onclick="" id="processcharge" type="text" value="'.$rowz['processingcharge'].'" class="form-control" placeholder="Enter Fees & Charges"><br>
            <div class="col-md-6">
            <label class="labelcolor">Start Date</label>
            <input onclick="" id="datepicker3" type="text" value="'.$date.'" class="form-control" placeholder="Enter Start Date"><br>
            </div>
            <div class="col-md-6">
            <label class="labelcolor">End Date</label>
            <input onclick="" id="datepicker4" type="text" value="'.$date1.'" class="form-control" placeholder="Enter End Date"><br>
            </div><br><br>
            <center>
                <button class="btn-success btn" type="" onclick="saveBorrowings()">save</button>
                <button class="btn-default btn" type="" onclick="cancelborrowing()">cancel</button>
            </center> <br><br>
        ';
        }
    }
    public static function CANCEL_BORROWING(){
        echo '
            <label class="labelcolor">Borrowed From</label>
            <select onchange="getOrganisation()" id="finaintname" class="selectpicker show-tick form-control" data-live-search="true">
                <option value="">Select Borrowed From</option>';
        FINANCIALINSTITUTION::OPTION_INSTITUTION();
        echo'
            </select><br><br>
            <div id="accountafftchoice"></div>
            <label class="labelcolor">Borrowed Amount.</label>
            <input onclick="" id="borrowedamount" type="text" class="form-control" placeholder="Enter Borrowed Amount"><br>
            <label class="labelcolor">Interest To Be Paid</label>
            <input onclick="" id="loaninterest" type="text" class="form-control" placeholder="Enter Interest"><br>
            <label class="labelcolor">Fees & Charges</label>
            <input onclick="" id="processcharge" type="text" class="form-control" placeholder="Enter Fees & Charges"><br>
            <div class="col-md-6">
            <label class="labelcolor">Start Date</label>
            <input onclick="" id="datepicker3" type="text" class="form-control" placeholder="Enter Start Date"><br>
            </div>
            <div class="col-md-6">
            <label class="labelcolor">End Date</label>
            <input onclick="" id="datepicker4" type="text" class="form-control" placeholder="Enter End Date"><br>
            </div><br><br>
            <center>
                <button class="btn-success btn" type="" onclick="saveBorrowings()">save</button>
                <button class="btn-default btn" type="" onclick="cancelborrowing()">cancel</button>
            </center> <br><br>
        ';
    }
}
class TRANSACTION_MAPPER  extends database_crud{
    protected $table = "coatransactionchart";
    protected $pk = "chart_id";
    //SELECT `chart_id`, `trans_code`, `transaction_amount`, `trans_date` FROM `coatransactionchart` WHERE 1
}
class BORROWINGREPAYMENT  extends database_crud{
    protected $table = "borrowingrepayments";
    protected $pk = "repayid";
    //SELECT `repayid`, `reprincipal`, `reinterest`, `recharge`,
    // `repaydate`, `inserteddate`, `handledby` FROM `borrowingrepayments` WHERE 1
    public static function SAVE_REPAYMENT(){
        $db = new DB(); $repay = new BORROWINGREPAYMENT(); session_start();
        $debt = new TRANSACTION_MAPPER(); NOW_DATETIME::NOW();
        $data = explode("?::?",$_GET['getrepaymentborrowing']);
        foreach($db->query("SELECT * FROM borrowings WHERE borrowingid='".$data[4]."'") as $row){
            $db->query("UPDATE borrowings SET principal=principal-'".$data[0]."', interest=interest-'".$data[1]."' WHERE borrowingid='".$data[4]."'");
        }
        foreach($db->query("SELECT * FROM borrowings WHERE borrowingid='".$data[4]."'") as $rowz){}
        $da = explode("/",$data[3]);
        $date = $da[2]."-".$da[0]."-".$da[1];
        $repay->reprincipal = $data[0];
        $repay->reinterest = $data[1];
        $repay->recharge = $data[2];
        $repay->repaydate = $date;
        $repay->borrowingid = $data[4];
        $repay->princbal = $rowz["principal"];
        $repay->interbal = $rowz["interest"];
        $repay->inserteddate = NOW_DATETIME::$Date_Time;
        $repay->handledby = $_SESSION['user_id'];
        $repay->create();
        if($data[2]=="0" || $data[2]==""){}else{
            $debt->transaction_amount = $data[2];
            $debt->transac_id = $repay->pk;
            $debt->trans_code = "202 1";
            $debt->gotfrom = "2";
            $debt->trans_date = NOW_DATETIME::$Date_Time;
            $debt->create();
        }
        echo '
            <table class="table table-bordered" >
                <tr>
                    <td width="40%"><b>Borrowed From</b></td>
                    <td width="20%"><b>Principal</b></td>
                    <td width="20%"><b>Interest</b></td>
                    <td width="20%"><b>Fines/Charges</b></td>
                    <td width="5%"><b>Action</b></td>
                </tr>
                <tr>
                    <td>
                        <select onchange="getborrowedinfo()" id="getfinaintname" class="selectpicker show-tick form-control" data-live-search="true">
                            <option value="">Select Borrowed From</option>';
        BORROWINGS::OPTION_BORROWING();
        echo'
                        </select>
                    </td>
                    <td><input onclick="" id="financialint" type="text" class="form-control" placeholder="Principal"></td>
                    <td><input onclick="" id="financialint" type="text" class="form-control" placeholder="Interest"></td>
                    <td><input onclick="" id="financialint" type="text" class="form-control" placeholder="Fines/Charges"></td>
                    <td>
                        <center>
                            <button class="btn-info btn-social btn" type="" onclick="saverepaymentborrowing()">save</button>
                        </center>
                    </td>
                </tr>
            </table>
        ';
        echo '|<><>|';
        echo '
            <table id="example" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr class="info">
                        <th width="25%">Date</th>
                        <th width="25%">Paid Principal</th>
                        <th width="25%">Interest</th>
                        <th width="25%">Fines</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        ';
    }
}
class STANDING_ORDERS extends database_crud{
	protected $table = "standingorders";
	protected $pk = "orderid";
	
	//  SELECT `orderid`, `orderno`, `clients`, `orderdate`, `orderamount`, `indate`, 
	// `intime`, `user_handle` FROM `standingorders` WHERE 1
	
	public static function ADDCLIENTS(){
		$data = explode("?::?", $_GET['addclientstotrail1']);	$res = ""; $amt = "";
		
		if($data[1] == ""){
			$res = $data[0];
			$amt = $data[2];
			echo $res;
			echo "|<><>|";
			echo $amt;
		}else{
			if($data[0] == ""){
				$res = $data[1];
				$amt = $data[3];
			}else{
				$clne = explode("?--?",$data[1]);
				if(in_array($data[0],$clne)){$res = $data[1];}else{$res = $data[1].",".$data[0];}
				$clne1 = explode("?--?",$data[1]);
				if(in_array($data[0],$clne1)){$amt = $data[3];}else{$amt = $data[3].",".$data[2];}
			}
			
			echo $res;
			echo "|<><>|";
			echo $amt;
		}
		echo "|<><>|";
		$cln = explode(",",$res);
		$cln1 = explode(",",$amt);
		for($i = 0;$i < count($cln); $i++){
			CLIENT_DATA::$clientid = $cln[$i];
			CLIENT_DATA::CLIENTDATAMAIN();
			echo ' <span style="line-height: 2.3" class="label label-primary">'.CLIENT_DATA::$accountname.'-'.$cln1[$i].'  <button onclick="removeclientid1('.$cln[$i].')" class="btn btn-xs btn-danger-alt">x</button></span> ';
		}
	}
	
	public static function REMOVECLIENTS(){
		$data = explode("?::?", $_GET['removeclientid1']);	$res = ""; $tes = ""; $amt = ""; $amt1 = "";
		
		$clne = explode(",",$data[1]);
		$clne1 = explode(",",$data[2]);
		// if(in_array($data[0],$clne)){$res = $data[1];}else{$res = $data[1]."?--?".$data[0];}
		for($i = 0;$i < count($clne); $i++){
			if($data[0] == $clne[$i]){
				$res = $res; 
				$amt = $amt;
			}else{
				$res = $res.",".$clne[$i]; 
				$amt = $amt.",".$clne1[$i];
			}
		}
		$clnes = explode(",",$res);
		$clnes1 = explode(",",$amt);
		
		for($i = 0;$i < count($clnes); $i++){
			if($clnes[$i] == ""){
				$tes = $clnes[$i]; 
				$amt1 = $clnes1[$i];
			}else{
				$tes = $tes.",".$clnes[$i]; 
				$amt1 = $amt1.",".$clnes1[$i];
			}
		}
		$dos = SYS_CODES::split_on($tes,4);
		$dos1 = SYS_CODES::split_on($amt1,4);
		
		$res = $dos[1];
		$amt = $dos1[1];
		
		echo $res;
		echo "|<><>|";
		echo $amt;
		echo "|<><>|";
		
		$cln = explode(",",$res);
		$cln1 = explode(",",$amt);
		
		for($i = 0;$i < count($cln); $i++){
			if($cln[$i] == ""){}else{
				CLIENT_DATA::$clientid = $cln[$i];
				CLIENT_DATA::CLIENTDATAMAIN();
			echo ' <span style="line-height: 2.3" class="label label-primary">'.CLIENT_DATA::$accountname.'-'.$cln1[$i].' <button onclick="removeclientid1('.$cln[$i].')" class="btn btn-xs btn-danger-alt">x</button></span> ';
			}
			
		}
	}
	
	public static function SAVESTANDING_ORDERS(){
		$data = explode("?::?",$_GET['savestandingorder']);  
		$stndords = new STANDING_ORDERS();
		NOW_DATETIME::NOW(); session_start();
		$da = explode("/",$data[2]);
        $date = $da[2]."-".$da[0]."-".$da[1];
		
		$stndords->orderno = rand(10000,100000000);
		$stndords->clients = $data[1];
		$stndords->orderdate = $date;
		$stndords->orderamount = $data[0];
		$stndords->orderaccount = $data[3];
		$stndords->indate = NOW_DATETIME::$Date;
		$stndords->intime = NOW_DATETIME::$Time;
		$stndords->user_handle = $_SESSION['user_id'];
		$stndords->create();
		
		self::RETURNEDSTANDINGORDER();
		echo '|<><>|';
		self::CANCELSTANDINGORDER();
	}
	
	public static function RETURNEDSTANDINGORDER(){	
		$db = new DB();
		echo '
		<table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
			<thead>
				<tr class="info">
					<th width="15%">Date Detail</th>
					<th width="60%">Client Accounts</th>
					<th width="25%">Order Details</th>
				</tr>
			</thead>
			<tbody>
			'; 
			foreach($db->query("SELECT * FROM standingorders ORDER BY orderid DESC") as $row){
				
				$cln = explode(",",$row['clients']);
				$cln1 = explode(",",$row['orderamount']);
				
				echo "<tr>";
				echo "<td data-order='1'>".$row['indate']."<br>".$row['intime']."</td>";
				echo "<td>";
					for($i = 0;$i < count($cln); $i++){
						if($cln[$i] == ""){}else{
							CLIENT_DATA::$clientid = $cln[$i];
							CLIENT_DATA::CLIENTDATAMAIN();
						echo ' <span style="line-height: 2.3" class="label label-primary">'.CLIENT_DATA::$accountname.' - '.number_format($cln1[$i]).'</span> ';
						}
						
					}
				echo"</td>";
				CLIENT_DATA::$clientid = $row['orderaccount'];
				CLIENT_DATA::CLIENTDATAMAIN();
				echo "<td>Order Account : <b>".CLIENT_DATA::$accountno."</b><br>Order Date : <b>".$row['orderdate']."</b></td>";
				echo "</tr>";
			} 
		echo'
			</tbody>
		</table>
		';
         
	}
	
	public static function CANCELSTANDINGORDER(){
		
		echo '
			<b>Specify Client Size</b><br>
			<div id="bankchoice1"></div><br>
			<div hidden id="clientloopid"></div>
			<div hidden id="amtclientloopid"></div>
			<label class="labelcolor">Ordering Account</label>
			<select id="orderaccount" class="selectpicker show-tick form-control" data-live-search="true">
				  <option value="">select member...</option>
				  ';CLIENT_DATA::CLIENT_OPTIONSEARCH();  echo '
			</select><br><br>
			<div id="clientspace" class="alert alert alert-dismissable alert-danger"></div>
			<label class="labelcolor">Client Name</label>
			<div id="clientdatatrail">
			<select onchange="addclientstotrail1()" id="basic" class="selectpicker show-tick form-control" data-live-search="true">
				  <option value="">select member...</option>
				  ';CLIENT_DATA::CLIENT_OPTIONSEARCH();  echo '
			</select><br>
			</div>
			<label class="labelcolor">Order Date</label> 
			<input onclick="" id="datepicker" type="text" class="form-control" placeholder="Enter Date"><br>
			<label class="labelcolor">Order Amount</label> 
			<input onclick="" id="amtrcvd" type="text" class="form-control" placeholder="Enter Amount Received"><br>
			<center>
				<button class="btn-primary btn" type="" onclick="savestandingorder()" >Submit Standing Order</button>
				<button onclick="cancelstandingorder()" class="btn btn-default">Cancel</button>  
			</center> <br><br> 
		';
	}
}

