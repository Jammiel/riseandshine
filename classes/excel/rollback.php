<?php
error_reporting(0);	
require_once 'simplexlsx.class.php';
require_once '../db_class.php';
require_once '../database_crud.php';
require_once '../system_controller.php';

	$deposit = new DEPOSIT_TRANSACTION(); $db = new DB();
	session_start();  NOW_DATETIME::NOW(); $chart = new POST_CHART();
	$merge = new MERGERWD();   GENERAL_SETTINGS::GEN();
//	$sslimpts = new SSLIMPORTDATA();
	
	
	$imgFile = $_FILES['file']['name'];   
	$tmp_dir = $_FILES['file']['tmp_name'];  
	$imgSize = $_FILES['file']['size'];
	$upload_dir = 'uploads/'; 
	$mimes = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet'];
	// $valid_extensions = array('application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet');
	$valid_extensions = array("xlsx", "xls", "ms-excel","ods");
	
	$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
	// if(in_array($_FILES["file"]["type"],$valid_extensions)){
		$userpic = "rollback.".$imgExt;
        if(in_array($imgExt, $valid_extensions)){
                
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            // error_reporting(E_ALL);
            //error_reporting(0);

		error_reporting(0);
		
		$uploadFilePath = $upload_dir.$userpic;
		unlink($upload_dir.$user_pic); 
		move_uploaded_file($tmp_dir,$upload_dir.$userpic);

		//$totalSheet = count($Reader->sheets());
		
		
		
		//echo "You have total ".$totalSheet." sheets";
		/* For Loop for all sheets */
		for($i=0;$i<1;$i++){
			$xlsx = new SimpleXLSX($uploadFilePath);
			foreach ($xlsx->rows() as $Row){
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
				if($Row[2]=="0" && $Row[3]=="0" && $Row[4]=="0"){}else{
                                    foreach($db->query("SELECT * FROM clients WHERE accountno='".$client_acc."'") as $dataent){
                                        // saving handler algorithm
                                        if($saving_amt !="0" || $saving_amt !="-" || $saving_amt !=""){
                                            $db->query("UPDATE clients SET savingaccount = savingaccount - '".$saving_amt."' WHERE clientid = '".$dataent['clientid']."'");
                                            foreach ($db->query("SELECT * FROM clients WHERE clientid = '".$dataent['clientid']."'") as $row){$savingbalnce = $row['savingaccount'];}                       
                                        }

                                        // share handle
                                        if($share_amt !="0" || $share_amt !="-" || $share_amt !=""){
                                            $db->query("UPDATE clients SET shareaccount_amount = shareaccount_amount - '".$share_amt."' WHERE clientid = '".$dataent['clientid']."'");
                                            $db->query("UPDATE clients SET numberofshares = numberofshares - '".($share_amt/GENERAL_SETTINGS::$sharevalue)."' WHERE clientid = '".$dataent['clientid']."'");
                                            foreach ($db->query("SELECT * FROM clients WHERE clientid = '".$dataent['clientid']."'") as $row){$savingbalnce = $row['savingaccount']; $sharebal = $row['shareaccount_amount'];}
                                        }
						
                                        // loan repayment
                                        if($loans_amt !="0" || $loans_amt !="-" || $loans_amt !=""){
                                            foreach ($db->query("SELECT * FROM clients WHERE clientid='".$dataent['clientid']."'") as $clnt){

                                                if(($clnt['loanaccount'] - $loans_amt) < "0"){
                                                    $difft = -($clnt['loanaccount'] - $loans_amt);
                                                    $db->query("UPDATE clients SET savingaccount = savingaccount - '".$difft."' WHERE clientid = '".$dataent['clientid']."'");
                                                    $db->query("UPDATE clients SET loanaccount = '0' WHERE clientid = '".$dataent['clientid']."'");
                                                }else{
                                                    $db->query("UPDATE clients SET loanaccount = loanaccount + '".$loans_amt."' WHERE clientid = '".$dataent['clientid']."'");
                                                }

                                            }
							
                                        }
					
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

                                if($Row[2]=="0"){}else{			
                                    foreach($db->query("SELECT * FROM clients WHERE accountno='".$client_acc."'") as $dataent){
                                        
                                        $db->query("UPDATE clients SET savingaccount = savingaccount - '".$amount."' WHERE clientid = '".$dataent['clientid']."'");
                                        foreach ($db->query("SELECT * FROM clients WHERE clientid = '".$client_acc."'") as $row){$savingbalnce = $row['savingaccount'];}
                                    }
                                }
                            }

			}
		
		echo "<br />Data Inserted in dababase";

	}else { 
            die("<br/>Sorry, File type is not allowed. Only Excel file."); 
	}       
error_reporting(0);
?>
