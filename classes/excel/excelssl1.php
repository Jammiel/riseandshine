<?php
error_reporting(0);	
require('library/php-excel-reader/excel_reader2.php');
require('library/SpreadsheetReader.php');
require_once '../db_class.php';
require_once '../database_crud.php';
require_once '../system_controller.php';

	$deposit = new DEPOSIT_TRANSACTION(); $db = new DB();
	session_start();  NOW_DATETIME::NOW(); $chart = new POST_CHART();
	$merge = new MERGERWD();   GENERAL_SETTINGS::GEN();
	$sslimpts = new SSLIMPORTDATA();
	
	
	$imgFile = $_FILES['file']['name'];   
	$tmp_dir = $_FILES['file']['tmp_name'];  
	$imgSize = $_FILES['file']['size'];
	$upload_dir = 'uploads/'; 
	$mimes = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet'];
	// $valid_extensions = array('application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet');
	$valid_extensions = array("xlsx", "xls", "ms-excel","ods");
	$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
	// if(in_array($_FILES["file"]["type"],$valid_extensions)){
	$userpic = "sslexcel.".$imgExt;

	foreach($db->query("SELECT * FROM sslimports WHERE filename='".$imgFile."'") as $tissy){}
if($tissy){
	echo "This File Was Imported Already!.<br>Please Choose Another File For Importation.";
}else{	
	if(in_array($imgExt, $valid_extensions)){
	
	
	
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		// error_reporting(E_ALL);
		//error_reporting(0);

		
		$uploadFilePath = $upload_dir.$userpic;
		unlink($upload_dir.$user_pic); 
		move_uploaded_file($tmp_dir,$upload_dir.$userpic);
		
		$Reader = new SpreadsheetReader($uploadFilePath);

		$totalSheet = count($Reader->sheets());
		
		
		
		echo "You have total ".$totalSheet." sheets";
		
		/* For Loop for all sheets */
			for($i=0;$i<1;$i++){
				$Reader->ChangeSheet($i);
				foreach ($Reader as $Row){
					/* Check If sheet not emprt */
					$saving_amt = "0";
					$share_amt = "0";
					$loans_amt = "0";
					
					$depdate = isset($Row[0]) ? $Row[0] : '';
					$client_acc = isset($Row[1]) ? $Row[1] : '';
					$share_amt = isset($Row[2]) ? $Row[2] : '';
					$saving_amt = isset($Row[3]) ? $Row[3] : '';
					$loans_amt = isset($Row[4]) ? $Row[4] : '';
					$totalamt = isset($Row[5]) ? $Row[5] : '';
					$rcpts = isset($Row[6]) ? $Row[6] : '';
					$depitems = (($Row[2] != "0") ? ",2" : '').(($Row[3] != "0") ? ",1" : '').(($Row[4] != "0") ? ",3" : '');
					$depamts = (($Row[2] != "0") ? ",".$Row[2] : '').(($Row[3] != "0") ? ",".$Row[3] : '').(($Row[4]) ? ",".$Row[4] : '');
					// $deb .=$client_acc."...".$share_amt."...".$saving_amt."...".$loans_amt."...".$totalamt."<br>";
				if($Row[2]=="0" && $Row[3]=="0" && $Row[4]=="0"){}elseif($Row[2]=="" && $Row[3]=="0" && $Row[4]==""){}else{
					foreach($db->query("SELECT * FROM clients WHERE accountno='".$client_acc."'") as $dataent){
						// saving handler algorithm
						if($saving_amt !="0" || $saving_amt !="-" || $saving_amt !=""){
								$db->query("UPDATE clients SET savingaccount = savingaccount + '".$saving_amt."' WHERE clientid = '".$dataent['clientid']."'");
								foreach ($db->query("SELECT * FROM clients WHERE clientid = '".$dataent['clientid']."'") as $row){$savingbalnce = $row['savingaccount'];}
							
							if($savingbalnce < 0){
								$overdraftamt = $Row[2]- $savingbalnce;
								foreach($db->query("SELECT * FROM overdrafts WHERE clientid='".$dataent['clientid']."' AND status='1'") as $rows){}
								if($rows['clientid']){
									$db->query("UPDATE overdrafts SET overdraftamt = overdraftamt - '".$saving_amt."' WHERE clientid = '".$dataent['clientid']."' AND status='1'");
								}else{
									$db->query("UPDATE overdrafts SET overdraftamt = '0' , status='0' WHERE clientid = '".$dataent['clientid']."'");
								}
							}else{
								$db->query("UPDATE overdrafts SET overdraftamt = '0' , status='0' WHERE clientid = '".$dataent['clientid']."'");
							}
						}
						
						// share handle
						if($share_amt !="0" || $share_amt !="-" || $share_amt !=""){
							$db->query("UPDATE clients SET shareaccount_amount = shareaccount_amount + '".$share_amt."' WHERE clientid = '".$dataent['clientid']."'");
							$db->query("UPDATE clients SET numberofshares = numberofshares + '".($share_amt/GENERAL_SETTINGS::$sharevalue)."' WHERE clientid = '".$dataent['clientid']."'");
							foreach ($db->query("SELECT * FROM clients WHERE clientid = '".$dataent['clientid']."'") as $row){$savingbalnce = $row['savingaccount']; $sharebal = $row['shareaccount_amount'];}
						}
						
						// loan repayment
						if($loans_amt !="0" || $loans_amt !="-" || $loans_amt !=""){
							foreach ($db->query("SELECT * FROM clients WHERE clientid='".$dataent['clientid']."'") as $clnt){
								
									if(($clnt['loanaccount'] - $loans_amt) < "0"){
										$difft = -($clnt['loanaccount'] - $loans_amt);
										$db->query("UPDATE clients SET savingaccount = savingaccount + '".$difft."' WHERE clientid = '".$dataent['clientid']."'");
										$db->query("UPDATE clients SET loanaccount = '0' WHERE clientid = '".$dataent['clientid']."'");
									}else{
										$db->query("UPDATE clients SET loanaccount = loanaccount - '".$loans_amt."' WHERE clientid = '".$dataent['clientid']."'");
									}
									
									foreach ($db->query("SELECT * FROM loan_approvals WHERE disburse='1' AND member_id='".$dataent['clientid']."'") as $row){
										foreach ($db->query("SELECT * FROM loan_schedules WHERE approveid='".$row['desc_id']."'") as $rows){
											$data6 = SYS_CODES::split_on($rows['reviewdate'],1);
											$data1 = SYS_CODES::split_on($rows['paycheck'],1);
											$data2 = SYS_CODES::split_on($rows['total'],1);
											$data3 = SYS_CODES::split_on($rows['loanbal'],1);
											$data4 = SYS_CODES::split_on($rows['fines'],1);
											$data5 = SYS_CODES::split_on($rows['principal'],1);
											$repaydate = explode(",",$data6[1]);
											$repaycheck = explode(",",$data1[1]);
											$repayamt = explode(",",$data2[1]);
											$loanbal = explode(",",$data3[1]);
											$finescheck = explode(",",$data4[1]);
											$principal = explode(",",$data5[1]);
											$dates = $depdate;
											$sloanbal = ""; $spaycheck = "";
											$amt = $Row[4];
											for($i = 0;$i < count($repaydate); $i++ ){
												if($repaycheck[$i]=="0"){
													$diff= $repayamt[$i]-$loanbal[$i];
													if($amt >= $diff){
														$sloanbal .=",".$repayamt[$i];
														$spaycheck .=","."1";
														$amt -=$diff;
													}else{
														$spaycheck .=","."0";
														$sloanbal .=",".($amt+$loanbal[$i]);
														$amt='0';
													}
												}else{
													$sloanbal .=",".$loanbal[$i];
													$spaycheck .=",".$repaycheck[$i];
												}
											}
											
											$db->query("UPDATE loan_schedules SET
																		paycheck = '".$spaycheck."',
																		loanbal = '".$sloanbal."'
																		WHERE schudele_id = '".$rows['schudele_id']."'");
											foreach ($db->query("SELECT * FROM clients WHERE clientid = '".$dataent['clientid']."'") as $rowt){$savingbalnce = $rowt['savingaccount'];}
											CLIENT_DATA::$clientid = $dataent['clientid'];
											CLIENT_DATA::CLIENTDATAMAIN();
											$interestamt="0";$totprinc="0";
											foreach ($db->query("SELECT * FROM loan_schedules WHERE approveid='".$row['desc_id']."'") as $rowz){
												$repaycheck1 = explode(",",$rowz['paycheck']);
												$repayamt1 = explode(",",$rowz['total']);
												$loanbal1 = explode(",",$rowz['loanbal']);
												$intra = explode(",",$rowz['interest']);
												$princ= explode(",",$rowz['principal']);
												for($i = 1;$i < count($repaycheck1); $i++ ){
													if($repaycheck1[$i]=="0"){
														if($loanbal1[$i] > $princ[$i]){
															$interestamt += ($intra[$i] - ($loanbal1[$i] - $princ[$i]));
															$totprinc +=  0;
														}else{
															if($loanbal1[$i] < $princ[$i] && $loanbal1[$i] > 0){
																$interestamt += $intra[$i];
																$totprinc +=  ($princ[$i]-$loanbal1[$i]);
															}else{
																$interestamt += $intra[$i];
																$totprinc +=  $princ[$i];
															}
														}
													}

												}
											}
											
											$repay = new LOAN_REPAYMENT();
											$repay->sheduleid     = $rows['schudele_id'];
											$repay->amount        = $Row[4];
											$repay->loanbals      = CLIENT_DATA::$loanaccount;
											$repay->repay_type    = "1";
											$repay->interestbal   = $interestamt;
											$repay->interestpaid   = (($rowz['totalinterest'] <= "0")?"0":"".($rowz['totalinterest'] - $interestamt)."");
											$repay->princbal      = $totprinc;
											$repay->inserted_date = $depdate;
											$repay->create();
											$db->query("UPDATE loan_schedules SET
																		totalprinc = '".$totprinc."',
																		totalinterest = '".$interestamt."'
																		WHERE schudele_id = '".$rows['schudele_id']."'");

										}
									}
									
									if(($clnt['loanaccount'] - $loans_amt) < "0"){
										$db->query("UPDATE loan_approvals SET disburse = '2' WHERE member_id = '".$dataent['clientid']."'");
										$db->query("UPDATE loan_schedules SET loanstatus = '1' WHERE schudele_id = '".$rows['schudele_id']."'");
									}else{
										if(($clnt['loanaccount'] - $loans_amt) == "0"){
											$db->query("UPDATE loan_approvals SET disburse = '2' WHERE member_id = '".$dataent['clientid']."'");
											$db->query("UPDATE loan_schedules SET loanstatus = '1' WHERE schudele_id = '".$rows['schudele_id']."'");
										}
									}
							}
							
						}
						
						CLIENT_DATA::$clientid = $dataent['clientid'];  CLIENT_DATA::CLIENTDATAMAIN();
						$data = $saving_amt + $share_amt + $loans_amt;
						$deposit->clientid = $dataent['clientid'];
						$deposit->depositor = "Excel Deposit";
						$deposit->amount = $totalamt;
						$deposit->e_tag = "0";
						$deposit->inserteddate = $depdate;
						$deposit->modifieddate = NOW_DATETIME::$Date_Time;
						$deposit->user_handle = $_SESSION['user_id'];
						$deposit->depositeditems = $depitems;
						$deposit->depositedamts = $depamts;
						$deposit->balance = CLIENT_DATA::$savingaccount;
						$deposit->sbal = $sharebal;
						$deposit->lnbal = CLIENT_DATA::$loanaccount;
						$deposit->rct = $rcpts;
						$deposit->create();
						foreach ($db->query("SELECT MAX(depositid) as depositid FROM deposits") as $clnt){}
						$dept = $clnt['depositid'];

						$chart->clientid = $dataent['clientid'];
						$chart->depositeditems = $depitems;
						$chart->depositedamts = $depamts;
						$chart->inserteddate = $depdate;
						$chart->e_tag = "0";
						$chart->userhandle = $_SESSION['user_id'];
						$chart->amount = $totalamt;
						$chart->create();


						$merge->transactiontype = "1";
						$merge->transactionid = $dept;
						$merge->insertiondate = $depdate;
						$merge->clientid = $dataent['clientid'];
						$merge->create();
						
					}
					
				}
					
				}
			}
		
			for($i=1;$i<2;$i++){
				$Reader->ChangeSheet($i);
				foreach ($Reader as $Row){
					/* Check If sheet not emprt */
					$saving_amt = "0";
					$share_amt = "0";
					$loans_amt = "0";
					
					$depdate = isset($Row[0]) ? $Row[0] : '';
					$client_acc = isset($Row[1]) ? $Row[1] : '';
					$amount = isset($Row[2]) ? $Row[2] : '';
					$vourcher = isset($Row[3]) ? $Row[3] : '';
					
					if($Row[2]=="0"){}elseif($Row[2]==""){}else{			
						foreach($db->query("SELECT * FROM clients WHERE accountno='".$client_acc."'") as $dataent){
							$withdraw = new WITHDRAWS(); 
							session_start();     NOW_DATETIME::NOW();     
							$merge = new MERGERWD();  $overdraft = new OVERDRAFT();

							$db->query("UPDATE clients SET savingaccount = savingaccount - '".$amount."' WHERE clientid = '".$dataent['clientid']."'");
							foreach ($db->query("SELECT * FROM clients WHERE clientid = '".$client_acc."'") as $row){$savingbalnce = $row['savingaccount'];}
							
							// overdraft recording here
							if($row['savingaccount'] < $amount){
								$overdraftamt = $amount - $row['savingaccount'];
								foreach($db->query("SELECT * FROM overdrafts WHERE clientid='".$dataent['clientid']."' AND status='1'") as $rows){}
								if($rows['clientid']){
									
								}else{
									$overdraft->status = "1";
									$overdraft->clientid = $dataent['clientid'];
									$overdraft->overdraftamt = -$row['savingaccount'];
									$overdraft->recordamt = -$row['savingaccount'];
									$overdraft->user_handle = $_SESSION['user_id'];
									$overdraft->odate = $depdate;
									$overdraft->otime = $depdate;
									$overdraft->create();
								}
							}
							
							$withdraw->clientid = $dataent['clientid'];
							$withdraw->amount = $amount;
							$withdraw->amount_inwords = $amount;
							$withdraw->user_handle = $_SESSION['user_id'];
							$withdraw->re_tag = "0";
							$withdraw->balance = $savingbalnce;
							$withdraw->inserteddate = $depdate;
							$withdraw->modifieddate = $depdate;
							$withdraw->vct = $vourcher;
							$withdraw->withdrawor = "Excel Withdraw";
							$withdraw->create();
							foreach ($db->query("SELECT MAX(withdrawid) as depositid FROM withdraws") as $clnt){}
							$withid = $clnt['depositid'];
							
							$merge->transactiontype = "2";
							$merge->transactionid = $withid;
							$merge->insertiondate = $depdate;
							$merge->clientid = $dataent['clientid'];
							$merge->create();
						}
					
					}
				}

			}
		
		echo "<br />Data Inserted in dababase";

	}else { 
		die("<br/>Sorry, File type is not allowed. Only Excel file."); 
	}
	
	$sslimpts->filename = $imgFile;
	$sslimpts->addedate = NOW_DATETIME::$Date_Time;
	$sslimpts->create();
}
	echo '|<><>|';
	IMPORTSSL::UPLOADFORM();
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
       
error_reporting(0);
?>
