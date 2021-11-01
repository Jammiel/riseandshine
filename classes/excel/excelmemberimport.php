<?php
error_reporting(0);	
require_once 'simplexlsx.class.php';
require_once '../db_class.php';
require_once '../database_crud.php';
require_once '../system_controller.php';

	
	$imgFile = $_FILES['file']['name'];   
	$tmp_dir = $_FILES['file']['tmp_name'];  
	$imgSize = $_FILES['file']['size'];
	$upload_dir = 'uploads/'; 
	$mimes = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet'];
	// $valid_extensions = array('application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.oasis.opendocument.spreadsheet');
	$valid_extensions = array("xlsx", "xls", "ms-excel","ods");
	$imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
	// if(in_array($_FILES["file"]["type"],$valid_extensions)){
		$userpic = "clientexcel.".$imgExt;
	if(in_array($imgExt, $valid_extensions)){
		$clientdata = new CLIENT_DATA();    
		NOW_DATETIME::NOW(); 
		$db = new DB();
		$individual = new INDIVIDUAL_ACCOUNTDATA();
		GENERAL_SETTINGS::GEN();
		
		ini_set('display_errors', 1);
		ini_set('display_startup_errors', 1);
		
		error_reporting(0);
		

		$uploadFilePath = $upload_dir.$userpic;
		unlink($upload_dir.$user_pic); 
		move_uploaded_file($tmp_dir,$upload_dir.$userpic);

		//$Reader = new SpreadsheetReader($uploadFilePath);

		//$totalSheet = count($Reader->sheets());
		
		
		
		echo "You have total ".$totalSheet." sheets";
		/* For Loop for all sheets */
		for($i=0;$i<1;$i++){
			$xlsx = new SimpleXLSX($uploadFilePath);
                foreach ($xlsx->rows() as $Row){
				/* Check If sheet not emprt */
				
		        $data1 = isset($Row[0]) ? $Row[0] : '';
				$data2 = isset($Row[1]) ? $Row[1] : '';
				$data3 = isset($Row[2]) ? $Row[2] : '';
				$data4 = isset($Row[3]) ? $Row[3] : '';
				$data5 = isset($Row[4]) ? $Row[4] : '';
				$data6 = isset($Row[5]) ? $Row[5] : '';
				$data7 = isset($Row[6]) ? $Row[6] : '';
				$data8 = isset($Row[7]) ? $Row[7] : '';
				$data9 = isset($Row[8]) ? $Row[8] : '';
				
				$data10 = isset($Row[9]) ? $Row[9] : '';
				$data11 = isset($Row[10]) ? $Row[10] : '';
				$data12 = isset($Row[11]) ? $Row[11] : '';
				$data13 = isset($Row[12]) ? $Row[12] : '';
				$data14 = isset($Row[13]) ? $Row[13] : '';
				$data15 = isset($Row[14]) ? $Row[14] : '';
				$data16 = isset($Row[15]) ? $Row[15] : '';
				$data17 = isset($Row[16]) ? $Row[16] : '';
				$data18 = isset($Row[17]) ? $Row[17] : '';
				$data19 = isset($Row[18]) ? $Row[18] : '';
				$data20 = isset($Row[19]) ? $Row[19] : '';
				$data21 = isset($Row[20]) ? $Row[20] : '';
				$data22 = isset($Row[21]) ? $Row[21] : '';
				$data23 = isset($Row[22]) ? $Row[22] : '';
				$data24 = isset($Row[23]) ? $Row[23] : '';
				$data25 = isset($Row[24]) ? $Row[24] : '';
				$data26 = isset($Row[25]) ? $Row[25] : '';
				$data27 = isset($Row[26]) ? $Row[26] : '';
				$data28 = isset($Row[27]) ? $Row[27] : '';
				if($data1=="FIRST NAME"){
					
				}else if($data1!="" || $data3!="" || $data4!=""){
					$clientdata->accountname = $data21;
					$clientdata->accountno = $data22;
					
					$individual->firstname = $data1;
					$individual->lastname = $data3;
					$individual->secondname = $data2;
					$individual->gender = $data4;
					$individual->nationalidno = $data5;
					$individual->nationality = $data7;
					$individual->dateofbirth = $data6;
					$individual->maritalstatus = $data8;
					$individual->occupation = $data9;
					$individual->employer = $data10;
					$individual->mobilenumber = $data11;
					$individual->physicaladress = $data12;
					$individual->subcounty = $data13;
					$individual->district = $data14;
					$individual->kinname = $data15;
					$individual->relationship = $data16;
					$individual->contactdetails = $data18;
					$individual->address = $data17;
					$individual->securityqtn = $data19;
					$individual->answer = $data20;
					$individual->sshares = $data23;
					$individual->sloans = $data25;
					$individual->ssaving = $data24;
					$individual->csaving = $data28;
					
					$clientdata->accounttype = "1";
					$clientdata->regdate = NOW_DATETIME::$Date;
					if($data24){$clientdata->savingaccount = $data24;}
					if($data23){$clientdata->shareaccount_amount = $data23;}
					if($data23){$clientdata->numberofshares = $data23/GENERAL_SETTINGS::$sharevalue;}
					if($data25){$clientdata->loanaccount = $data25;}
					if($data26){$clientdata->loan_fines = $data27;}
					if($data27){$clientdata->loan_interest = $data27;}
					if($data28){$clientdata->commitment_saving = $data28;}
					
					// $clientdata->shareaccount_amount = $data23;
					// $clientdata->numberofshares = $data23/GENERAL_SETTINGS::$sharevalue;
					// $clientdata->loanaccount = $data25;
					$clientdata->clientdataid  = (($data25=="" || $data25=="0")?"0":"1");
					$clientdata->create();
					foreach($db->query("SELECT MAX(clientid) as clientdata FROM clients") as $row){}
					$individual->acc_no = $row['clientdata'];
					$individual->photo = $data26.".png";
					// die("<br>".$data21."-".$data22."-".$data23."-".$data24."-".$data25."-".$data6."-".$data7);
					$individual->create();
				}
	        }
		}

		echo "<br />Data Inserted in dababase";

	}else { 
		echo "<br/>Sorry, File type is not allowed. Only Excel file.";
		echo '|<><>|';
		IMPORTSSL::UPLOADFORM(); 
	}
	echo '|<><>|';
	IMPORTSSL::UPLOADFORM();
error_reporting(0);
?>