<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class NOW_DATETIME{
    public static $Date_Time;	public static $Date;	public static $Time;
    public static $year;	public static $month;	public static $yearmonth;
    public static function NOW(){

        date_default_timezone_set("Africa/Kampala");
        $date = new DateTime();
        static::$Date_Time = $date->format('Y-m-d:H:i:s');
        static::$Date = $date->format('Y-m-d');
        static::$Time = $date->format('H:i:s');
        static::$year = $date->format('Y');
        static::$month = $date->format('m');
        static::$yearmonth = $date->format('Y-m');
    }
}
class PERIOD_MODULES{
    public static function MONTH(){
        $monthArray = range(1, 12);
        foreach ($monthArray as $month) {
            // padding the month with extra zero
            $monthPadding = str_pad($month, 2, "0", STR_PAD_LEFT);
            // you can use whatever year you want
            // you can use 'M' or 'F' as per your month formatting preference
            $fdate = date("F", strtotime("2015-$monthPadding-01"));
            echo '<option value="'.$fdate.'">'.$fdate.'</option>';
        }
    }
    public static function YEAR(){
        $yearArray = range(2010, 2090);
        $da = new DateTime();
        foreach ($yearArray as $year) {
            // if you want to select a particular year
            $selected = ($year == $da->format("Y")) ? 'selected' : '';
            echo '<option '.$selected.' value="'.$year.'">'.$year.'</option>';
        }
    }
}
class SYS_CODES {
    public static $level1id;  public static $level2id;
    public static $level3id;  public static $level4id;
    public static $seccode;   public static $assetno;

    public static function split_on($string, $num) {
        $length = strlen($string);
        $output[0] = substr($string, 0, $num);
        $output[1] = substr($string, $num, $length);
        return $output;
    }
    static function array_max_key($array) {
        $max_val = -1;
        $result = null;

        foreach ($array as $key => $value) {
            if ($value > $max_val) {
                $max_val = $value;
                $result = $value;
            }
        }
        if(empty($result)){ $result = 0; return $result;}else{return $max_val;}
    }
    public static function SECCODES(){
        $db = new DB();   $res =null;    $rest = array();
        foreach ($db->query("SELECT seccode FROM sections") as $row){
            $code = static::split_on($row['seccode'],3);
            $rest[] = $code[1];
        }
        if(!empty($rest)){
            $num = static::array_max_key($rest) + 1;
            static::$seccode = "LVL00".$num;
        }else{
            static::$seccode = "LVL"."001";
        }
    }
    public static function LEVEL2(){
        $db = new DB();   $res =null;    $rest = array();
        foreach ($db->query("SELECT * FROM level2 l, sections s WHERE s.sec_id=l.level1id AND l.level1id='".static::$level1id."'") as $row){
            $rest = static::split_on($row['level1code'],2);
            $code1 = static::split_on($row['seccode'],5);
            $code[] =  $rest[1];
        }
        if(!empty($code)){
            $num = static::array_max_key($code) + 1;
            static::$level1id = $code1[1]."0".$num;
        }else{
            foreach ($db->query("SELECT * FROM sections s WHERE sec_id='".static::$level1id."'") as $row){
                $code1 = static::split_on($row['seccode'],5);
                static::$level1id = $code1[1]."01";
            }
        }
    }
    public static function LEVEL3(){
        $db = new DB();   $res =null;    $rest = array();
        foreach ($db->query("SELECT * FROM level3 l, level2 s WHERE s.lvl1_id=l.level2id AND l.level2id='".static::$level2id."'") as $row){
            $rest = explode(" ",$row['level2code']);
            $code[] =  $rest[1];
            $code1 =  $row['level1code'];
        }
        if(!empty($code)){
            $num = static::array_max_key($code) + 1;
            static::$level2id = $code1." ".$num;
        }else{
            foreach ($db->query("SELECT * FROM level2 WHERE lvl1_id='".static::$level2id."'") as $row){
                static::$level2id = $row['level1code']." 1";
            }
        }
    }
    public static function LEVEL4(){
        $db = new DB();   $res =null;    $rest = array();
        foreach ($db->query("SELECT * FROM level4 l, level3 s WHERE s.lvl2_id=l.level3id AND l.level3id='".static::$level3id."'") as $row){
            $rest = explode(" ",$row['level3code']);
            $code[] =  $rest[2];
            $code1 =  $row['level2code'];
        }
        if(!empty($code)){
            $num = static::array_max_key($code) + 1;
            static::$level3id = $code1." ".$num;
        }else{
            foreach ($db->query("SELECT * FROM level3 WHERE lvl2_id='".static::$level3id."'") as $row){
                static::$level3id = $row['level2code']." 1";
            }
        }
    }
    public static function LEVEL5(){
        $db = new DB();   $res =null;    $rest = array();
        foreach ($db->query("SELECT * FROM level5 l, level4 s WHERE s.lvl3_id=l.level4id AND l.level4id='".static::$level4id."'") as $row){
            $rest = explode(" ",$row['level4code']);
            $code[] =  $rest[3];
            $code1 =  $row['level3code'];
        }
        if(!empty($code)){
            $num = static::array_max_key($code) + 1;
            static::$level4id = $code1." ".$num;
        }else{
            foreach ($db->query("SELECT * FROM level4 WHERE lvl3_id='".static::$level4id."'") as $row){
                static::$level4id = $row['level3code']." 1";
            }
        }
    }
    public static function ASSET_NO(){
        $db = new DB();    $res =null;   $rest = array();
        foreach ($db->query("SELECT assetnumber FROM assets") as $row){
            $code = static::split_on($row['assetnumber'],6);
            $rest[] = $code[1];
        }
        if(!empty($rest)){
            $num = static::array_max_key($rest) + 1;
            static::$assetno =  "ASSET-00".$num ;
        }else{
            static::$assetno = "ASSET-"."001";
        }
    }
}
class GENERAL_SETTINGS extends database_crud{
    //SELECT `gen_id`, `loaninterestrate`, `loanappl_fees`, `loandelay_fine`, `sharevalue`,
    // `minsavingbal`, `membershipfees`, `gross_period`, `accountopeningfees` FROM `general_settings` WHERE 1
    public static $loaninterestrate;        public static $loanappl_fees;       public static $monthlycharges;
    public static $sharevalue;              public static $minsavingbal;        public static $membershipfees;
    public static $gross_period;            public static $accountopeningfees;  public static $loanschedule;
    public static $grosstype;               public static $loan_insurancefund;  public static $passbook;
    public static $loanprocessfees;         public static $bankcharges;		public static $loanpenalty;
    public static $withdrawcharges;         public static $transferfees;	public static $dividends;
    public static $specialmention;          public static $substandardloan;	public static $doubtfullloan;
    public static $lossloans;               public static $overdraft;		public static $subscription;
    public static $legalfees;


    public static function GEN(){
        $db = new DB(); $gen="";  $val =  "";
        foreach ($db->query("SELECT * FROM gensettings") as $row){$gen .="?::?".$row['gencode'];  $val .="?::?".$row['value']; }
		$gencode = explode("?::?",$gen);
		$value = explode("?::?",$val);
		for($i = 1;$i <= count($gencode); $i++){
                    if($gencode[$i]=="gen01"){static::$loaninterestrate = $value[$i];}
                    if($gencode[$i]=="gen02"){static::$loanappl_fees = $value[$i];}
                    if($gencode[$i]=="gen03"){static::$monthlycharges = $value[$i];}
                    if($gencode[$i]=="gen04"){static::$sharevalue = $value[$i];}
                    if($gencode[$i]=="gen05"){static::$minsavingbal = $value[$i];}
                    if($gencode[$i]=="gen06"){static::$membershipfees = $value[$i];}
                    if($gencode[$i]=="gen07"){static::$grosstype =  $value[$i];}
                    if($gencode[$i]=="gen08"){static::$gross_period = $value[$i];}
                    if($gencode[$i]=="gen09"){static::$accountopeningfees = $value[$i];}
                    if($gencode[$i]=="gen10"){static::$loanschedule = $value[$i];}
                    if($gencode[$i]=="gen11"){static::$loan_insurancefund = $value[$i];}
                    if($gencode[$i]=="gen12"){static::$loanprocessfees = $value[$i];}
                    if($gencode[$i]=="gen13"){static::$passbook = $value[$i];}
                    if($gencode[$i]=="gen14"){static::$bankcharges  = $value[$i];}
                    if($gencode[$i]=="gen15"){static::$loanpenalty  = $value[$i];}
                    if($gencode[$i]=="gen16"){static::$withdrawcharges  = $value[$i];}
                    if($gencode[$i]=="gen17"){static::$transferfees  = $value[$i];}
                    if($gencode[$i]=="gen18"){static::$dividends  = $value[$i];}
                    if($gencode[$i]=="gen19"){static::$specialmention  = $value[$i];}
                    if($gencode[$i]=="gen20"){static::$substandardloan  = $value[$i];}
                    if($gencode[$i]=="gen21"){static::$doubtfullloan  = $value[$i];}
                    if($gencode[$i]=="gen22"){static::$lossloans  = $value[$i];}
                    if($gencode[$i]=="gen23"){static::$overdraft  = $value[$i];}
                    if($gencode[$i]=="gen24"){static::$subscription  = $value[$i];}
                    if($gencode[$i]=="gen25"){static::$legalfees  = $value[$i];}
		}
    }

    public static function UPDATE_SETTING(){
		$data = explode("?::?", $_GET['updatesetttings']);	$db = new DB();
		$db->query("UPDATE gensettings SET value='".$data[1]."' WHERE gencode='".$data[0]."'");
		if($data[0]=="gen10"){ static::GEN(); echo ((GENERAL_SETTINGS::$loanschedule=="1")?"Flat Balance Rate":"Reducing Balance Rate");}
	}
}
class SYSTEMINFO extends database_crud{
	protected $table = "";
	protected $pk = "";
	// SELECT `mf_id`, `sacconame`, `logo`, `address`, `headertext` FROM `details_mf` WHERE 1
	public static function GET_HEADER(){
		$db = new DB();
		foreach($db->query("SELECT * FROM details_mf WHERE mf_id='1'") as $row){}
		echo '
			<table>
                            <tr>
                                <td>
                                    <img src="images/logo.png" alt="" class="w3-left w3-circle w3-margin-right" style="width:45px;height: 45px">
                                    &nbsp;&nbsp;
                                </td>
                                    <td>
                                        <b style="font-family: times new roman;font-weight: 600">';
                                    echo $row['headertext'].(($row['address'])?"<br><span style='font-size: 10px'>".$row['address']."<span>":"");
                                echo'	
                                        </b>
                                    </td>
                            </tr>
			</table>
		';
	}
}
class SSLIMPORTDATA extends database_crud{
	protected $table = "sslimports";
	protected $pk = "imptid";
	// SELECT `imptid`, `addedate`, `filename` FROM `sslimports` WHERE 1
}
class TIMELYTRACKER{
    public static function tracker(){
//        self::loantracker();
        MONTHLYCHARGE::monthlycharges();
        self::loan_analysis();
        self::autopayloan();
    }
    public static function autopayloan(){
        $db = new DB(); $rep=""; $loop =  1;   NOW_DATETIME::NOW();
        GENERAL_SETTINGS::GEN();$merge = new MERGERWD();
        $nocash = new NONCASH_TRASNSACTIONS(); session_start();
        foreach ($db->query("SELECT * FROM loan_approvals p,loan_schedules s WHERE s.approveid=p.desc_id AND p.disburse='1' ORDER BY s.disbursed_date DESC") as $row){
            foreach ($db->query("SELECT * FROM clients WHERE clientid='".$row['member_id']."'") as $rowclient) {
                if($row['loanstatus'] == "0"){
                    $data = SYS_CODES::split_on($row['reviewdate'],1);
                    $data1 = SYS_CODES::split_on($row['paycheck'],1);
                    $data2 = SYS_CODES::split_on($row['loanbal'],1);
                    $data3 = SYS_CODES::split_on($row['loanbal'],1);
                    $data4 = SYS_CODES::split_on($row['finestat'],1);
                    $data5 = SYS_CODES::split_on($row['loanbal'],1);
                    $repaydate = explode(",",$data[1]);
                    $repaycheck = explode(",",$data1[1]);
                    $repayamt = explode(",",$data2[1]);
                    $finestat = explode(",",$data4[1]);
                    $loanbals = explode(",",$data5[1]);
                    
                    for($i = 0;$i < count($repaydate); $i++){
                        if($repaydate[$i] <= NOW_DATETIME::$Date && $repaycheck[$i] ==""){

                            $from=date_create(NOW_DATETIME::$Date);
                            $to=date_create($repaydate[$i]);
                            $days = (date_diff($to,$from)->format('%R%a'))*1;

                            if($days < 365 && $days >=0){
                                $loan_deductableamount = "0";
                                $interest_deductableamount = "0";
                                $signal = "";
                                $signalx = "";
                                
                                if($repayamt[$i] < $rowclient['savingaccount']){$loan_deductableamount = $repayamt[$i];$signal ="1";}else{$loan_deductableamount = $rowclient['savingaccount'];}
                                if($finestat[$i] < $rowclient['savingaccount']){$interest_deductableamount = $finestat[$i];$signalx ="1";}else{$interest_deductableamount = $rowclient['savingaccount'];}
                                if($loan_deductableamount == "0"){}else{
                                    $interestamt = $row['amount_disb'] - $row['amount_given'];
                                    $db->query("UPDATE clients SET savingaccount = savingaccount - '".$loan_deductableamount."', loanaccount = loanaccount - '".$loan_deductableamount."' WHERE clientid = '".$row['member_id']."'");
                                    CLIENT_DATA::$clientid = $row['member_id'];
                                    CLIENT_DATA::CLIENTDATAMAIN();
                                    $repay = new LOAN_REPAYMENT();
                                    $repay->sheduleid     = $row['schudele_id'];
                                    $repay->amount        = $loan_deductableamount;
                                    $repay->loanbals      = CLIENT_DATA::$loanaccount;
                                    $repay->repay_type    = "1";
                                    $repay->interestbal   = $rowclient['loan_interest'];
                                    $repay->interestpaid  = $interestamt - $rowclient['loan_interest'];
                                    $repay->princbal      = $rowclient['loanaccount'];
                                    $repay->inserted_date = NOW_DATETIME::$Date_Time;
                                    $repay->create();
                                    $repaycheck[$i] = $signal;
                                    $loanbals[$i] = ($repayamt[$i] -$loan_deductableamount);
                                    $bpaycheck =""; $lnbal = "";
//                                    var_dump("====++======+++=====".$signal);
                                    for($i = 0;$i < count($repaycheck); $i++){
                                        $bpaycheck .=",".$repaycheck[$i];
                                        $lnbal .=",".$loanbals[$i];
                                    }
                                    
                                    if(($rowclient['loanaccount'] - $loan_deductableamount) < "0"){
                                        $db->query("UPDATE loan_approvals SET disburse = '2' WHERE member_id = '".$row['member_id']."'");
                                        $db->query("UPDATE loan_schedules SET loanstatus = '1' WHERE schudele_id = '".$row['schudele_id']."'");
                                    }else{
                                        if(($rowclient['loanaccount'] - $loan_deductableamount)  == "0"){
                                            $db->query("UPDATE loan_approvals SET disburse = '2' WHERE member_id = '".$row['member_id']."'");
                                            $db->query("UPDATE loan_schedules SET loanstatus = '1' WHERE schudele_id = '".$row['schudele_id']."'");
                                        }
                                    }
                                    $db->query("UPDATE loan_schedules SET paycheck = '".$bpaycheck."', loanbal = '".$lnbal."'  WHERE schudele_id = '".$row['schudele_id']."'");
                                    
                                    $nocash->ttype  = "1";
                                    $nocash->clientid = $row['member_id'];
                                    $nocash->accountcode = "3";
                                    $nocash->amount = $loan_deductableamount;
                                    $nocash->user_handle = $_SESSION['user_id'];
                                    $nocash->sbal = CLIENT_DATA::$savingaccount;
                                    $nocash->shrbal = CLIENT_DATA::$shares;
                                    $nocash->ndate = NOW_DATETIME::$Date;
                                    $nocash->ntime = NOW_DATETIME::$Time;
                                    $nocash->create();
                                    foreach ($db->query("SELECT MAX(nontracid) as id FROM noncashtracs") as $maxid) {}
                                    $merge->transactiontype = "6";
                                    $merge->transactionid = $maxid['id'];
                                    $merge->insertiondate = NOW_DATETIME::$Date_Time;
                                    $merge->clientid = $row['member_id'];
                                    $merge->create();
                                }
                            }
                        }
                    }
                    
                   
                }
            }	
        }
    }   
    public static function loanpenalty(){
        $db = new DB(); $rep=""; $loop =  1;   NOW_DATETIME::NOW();
        GENERAL_SETTINGS::GEN();$merge = new MERGERWD();
        $nocash = new NONCASH_TRASNSACTIONS(); session_start();
        foreach ($db->query("SELECT * FROM loan_approvals p,loan_schedules s WHERE s.approveid=p.desc_id AND p.disburse='1' ORDER BY s.disbursed_date DESC") as $row){
            foreach ($db->query("SELECT * FROM clients WHERE clientid='".$row['member_id']."'") as $rowclient) {
                if($row['loanstatus'] == "0"){
                    $data = SYS_CODES::split_on($row['reviewdate'],1);
                    $data1 = SYS_CODES::split_on($row['paycheck'],1);
                    $data2 = SYS_CODES::split_on($row['loanbal'],1);
                    $data3 = SYS_CODES::split_on($row['loanbal'],1);
                    $data4 = SYS_CODES::split_on($row['finestat'],1);
                    $data5 = SYS_CODES::split_on($row['loanbal'],1);
                    $repaydate = explode(",",$data[1]);
                    $repaycheck = explode(",",$data1[1]);
                    $repayamt = explode(",",$data2[1]);
                    $fines = explode(",",$data3[1]);
                    $finestat = explode(",",$data4[1]);
                    $loanbals = explode(",",$data5[1]);
                    $datas = "";    $datas1 = "";
                    $fina = "";
                    $finastat = "";
                    $fintot = "0";
                    
                    for($i = 0;$i < count($repaydate); $i++){
                        if($repaydate[$i] <= NOW_DATETIME::$Date && $repaycheck[$i] ==""){

                            $from=date_create(NOW_DATETIME::$Date);
                            $to=date_create($repaydate[$i]);
                            $days = (date_diff($to,$from)->format('%R%a'))*1;

                            if($days < 60 && $days >=30){
                                
                                $fina = $fina.",".($repayamt[$i]*(GENERAL_SETTINGS::$loanpenalty/100))*$days;
                                $fintot = $fintot + ($repayamt[$i]*(GENERAL_SETTINGS::$loanpenalty/100))*$days;
                                $finastat = $finastat .",1";
                                $loan_deductableamount = "0";
                                $interest_deductableamount = "0";
                                $signal = "";
                                $signalx = "";
                                
                                if($repayamt[$i] < $rowclient['savingaccount']){$loan_deductableamount = $repayamt[$i];$signal ="1";}else{$loan_deductableamount = $rowclient['savingaccount'];}
                                if($finestat[$i] < $rowclient['savingaccount']){$interest_deductableamount = $finestat[$i];$signalx ="1";}else{$interest_deductableamount = $rowclient['savingaccount'];}
                                if($loan_deductableamount == "0"){}else{
                                    $interestamt = $row['amount_disb'] - $row['amount_given'];
                                    $db->query("UPDATE clients SET savingaccount = savingaccount - '".$loan_deductableamount."', loanaccount = loanaccount - '".$loan_deductableamount."' WHERE clientid = '".$row['member_id']."'");
                                    
                                    $repaycheck[$i] = $signal;
                                    $loanbals[$i] = ($repayamt[$i] -$loan_deductableamount);
                                    $bpaycheck =""; $lnbal = "";
//                                    var_dump("====++======+++=====".$signal);
                                    for($i = 0;$i < count($repaycheck); $i++){
                                        $bpaycheck .=",".$repaycheck[$i];
                                        $lnbal .=",".$loanbals[$i];
                                    }
                                    $db->query("UPDATE loan_schedules SET insertion_date = '".NOW_DATETIME::$Date."' WHERE schudele_id = '".$row['schudele_id']."'");
                                    $db->query("UPDATE loan_schedules SET fintot = fintot + '".($penatot)."' WHERE schudele_id = '".$row['schudele_id']."'");
                                    $db->query("UPDATE loan_schedules SET finetotal = finetotal + '".($penatot)."' WHERE schudele_id = '".$row['schudele_id']."'");
                                    $db->query("UPDATE clients SET loan_fines = loan_fines + '".($diifft + $penatot)."' WHERE clientid = '".$row['member_id']."'");
                                    $db->query("UPDATE loan_schedules SET paycheck = '".$bpaycheck."', loanbal = '".$lnbal."'  WHERE schudele_id = '".$row['schudele_id']."'");
                                    
                                }
                            }
                        }
                    }
                    
                   
                }
            }	
        }
    }   
    public static function loanpenaltycv(){
        $db = new DB(); $rep=""; $loop =  1;   NOW_DATETIME::NOW();
        GENERAL_SETTINGS::GEN();
        foreach ($db->query("SELECT * FROM loan_approvals p,loan_schedules s WHERE s.approveid=p.desc_id AND p.penalty = '0' AND p.disburse='1' ORDER BY s.disbursed_date DESC") as $row){
            foreach ($db->query("SELECT * FROM clients WHERE clientid='".$row['member_id']."'") as $rowclient) {
                if($row['loanstatus'] == "0"){
                    $data = SYS_CODES::split_on($row['reviewdate'],1);
                    $data1 = SYS_CODES::split_on($row['paycheck'],1);
                    $data2 = SYS_CODES::split_on($row['principal'],1);
                    $data3 = SYS_CODES::split_on($row['fines'],1);
                    $data4 = SYS_CODES::split_on($row['finestat'],1);
                    $repaydate = explode(",",$data[1]);
                    $repaycheck = explode(",",$data1[1]);
                    $repayamt = explode(",",$data2[1]);
                    $fines = explode(",",$data3[1]);
                    $finestat = explode(",",$data4[1]);
                    $datas = "";    $datas1 = "";
                    $fina = "";
                    $finastat = "";
                    $fintot = "0";
                    for($i = 0;$i < count($repaydate); $i++){
                        if($repaydate[$i] < NOW_DATETIME::$Date && $repaycheck[$i] == "" && $finestat[$i] == ""){
                            $datas .=",".$repaydate[$i]; $datas1 .=",".$repayamt[$i];
                            $from=date_create($repaydate[$i]);
                            $to=date_create($repaydate[$i+1]);
                            $tttime = date_diff($from,$to)->format('%R%a');
                            
                            if($days < 4 && $days >=0){
                                $fina = $fina.",".($repayamt[$i]*(GENERAL_SETTINGS::$loanpenalty/100))*$tttime;
                                $fintot = $fintot + ($repayamt[$i]*(GENERAL_SETTINGS::$loanpenalty/100))*$tttime;
                                $finastat = $finastat .",1";
                            }
                        }else{
                            $fina = $fina.",".$fines[$i];
                            $finastat = $finastat.",".$finestat[$i];
                            $fintot = $fintot + $fines[$i];
                        }
                    }
                    
                    $penatot = "0";
                    if($row['insertion_date'] == NULL && max($repaydate) < NOW_DATETIME::$Date){
                    $from1=date_create(max($repaydate));
                        $to1=date_create(NOW_DATETIME::$Date);
                        $tttime1 = date_diff($from1,$to1)->format('%R%a');
                        $penatot = (max($repayamt) *(GENERAL_SETTINGS::$loanpenalty/100))*$tttime1;
                        $db->query("UPDATE loan_schedules SET insertion_date = '".NOW_DATETIME::$Date."' WHERE schudele_id = '".$row['schudele_id']."'");
                        $db->query("UPDATE loan_schedules SET finetotal = finetotal + '".($penatot)."' WHERE schudele_id = '".$row['schudele_id']."'");
                        $db->query("UPDATE loan_schedules SET fintot = fintot + '".($penatot)."' WHERE schudele_id = '".$row['schudele_id']."'");
                        $db->query("UPDATE clients SET loan_fines = loan_fines + '".($penatot)."' WHERE clientid = '".$row['member_id']."'");
                    }else if($row['insertion_date'] < NOW_DATETIME::$Date && $row['insertion_date'] != NULL && $row['insertion_date'] !=""){
                        $from1=date_create($row['insertion_date']);
                        $to1=date_create(NOW_DATETIME::$Date);
                        $tttime1 = date_diff($from1,$to1)->format('%R%a');
                        $penatot = (max($repayamt) *(GENERAL_SETTINGS::$loanpenalty/100))*$tttime1;
                        $db->query("UPDATE loan_schedules SET insertion_date = '".NOW_DATETIME::$Date."' WHERE schudele_id = '".$row['schudele_id']."'");
                        $db->query("UPDATE loan_schedules SET fintot = fintot + '".($penatot)."' WHERE schudele_id = '".$row['schudele_id']."'");
                        $db->query("UPDATE loan_schedules SET finetotal = finetotal + '".($penatot)."' WHERE schudele_id = '".$row['schudele_id']."'");
                        $db->query("UPDATE clients SET loan_fines = loan_fines + '".($diifft + $penatot)."' WHERE clientid = '".$row['member_id']."'");
                    }else{}
                    //echo "<br>".$fina."---".$fintot;
                            
                    
                    if($row['actfinetots'] < $fintot){
                        
                        $diifft = $fintot - $row['actfinetots'];
                        $db->query("UPDATE loan_schedules SET finetotal = finetotal + '".$diifft."' WHERE schudele_id = '".$row['schudele_id']."'");
                        $db->query("UPDATE loan_schedules SET fintot = fintot + '".$diifft."' WHERE schudele_id = '".$row['schudele_id']."'");
                        $db->query("UPDATE clients SET loan_fines = loan_fines + '".$diifft."' WHERE clientid = '".$row['member_id']."'");
                    }
                    $db->query("UPDATE loan_schedules SET
                                                    actfinetots = '".$fintot."',
                                                    finestat = '".$finastat."',
                                                    fines = '".$fina."'
                                                    WHERE schudele_id = '".$row['schudele_id']."'");
                    $loop++;
                }
            }
        }   
    }
    public static function loantracker(){
        $db = new DB(); $rep=""; $loop =  1;   NOW_DATETIME::NOW();
        GENERAL_SETTINGS::GEN();
        foreach ($db->query("SELECT * FROM loan_approvals p,loan_schedules s WHERE s.approveid=p.desc_id AND p.penalty = '0' ORDER BY s.disbursed_date DESC") as $row){
            foreach ($db->query("SELECT * FROM clients WHERE clientid='".$row['member_id']."'") as $rowclient) {
                if($row['loanstatus'] == "0"){
                    $data = SYS_CODES::split_on($row['reviewdate'],1);
                    $data1 = SYS_CODES::split_on($row['paycheck'],1);
                    $data2 = SYS_CODES::split_on($row['principal'],1);
                    $data3 = SYS_CODES::split_on($row['fines'],1);
                    $data4 = SYS_CODES::split_on($row['finestat'],1);
                    $repaydate = explode(",",$data[1]);
                    $repaycheck = explode(",",$data1[1]);
                    $repayamt = explode(",",$data2[1]);
                    $fines = explode(",",$data3[1]);
                    $finestat = explode(",",$data4[1]);
                    $datas = "";    $datas1 = "";
                    $fina = "";
                    $finastat = "";
                    $fintot = "0";
                    for($i = 0;$i < count($repaydate); $i++ ){
                        if($repaydate[$i] < NOW_DATETIME::$Date && $repaycheck[$i] == "" && $finestat[$i] == ""){
                            $datas .=",".$repaydate[$i]; $datas1 .=",".$repayamt[$i];
                            $from=date_create($repaydate[$i]);
                            $to=date_create($repaydate[$i+1]);
                            $tttime = date_diff($from,$to)->format('%R%a');

                            $fina = $fina.",".($repayamt[$i]*(GENERAL_SETTINGS::$loanpenalty/100))*$tttime;
                            $fintot = $fintot + ($repayamt[$i]*(GENERAL_SETTINGS::$loanpenalty/100))*$tttime;
                            $finastat = $finastat .",1";
                        }else{
                            $fina = $fina.",".$fines[$i];
                            $finastat = $finastat.",".$finestat[$i];
                            $fintot = $fintot + $fines[$i];
                        }
                    }
                    
                    $penatot = "0";
                    if($row['insertion_date'] == NULL && max($repaydate) < NOW_DATETIME::$Date){
                    $from1=date_create(max($repaydate));
                        $to1=date_create(NOW_DATETIME::$Date);
                        $tttime1 = date_diff($from1,$to1)->format('%R%a');
                        $penatot = (max($repayamt) *(GENERAL_SETTINGS::$loanpenalty/100))*$tttime1;
                        $db->query("UPDATE loan_schedules SET insertion_date = '".NOW_DATETIME::$Date."' WHERE schudele_id = '".$row['schudele_id']."'");
                        $db->query("UPDATE loan_schedules SET finetotal = finetotal + '".($penatot)."' WHERE schudele_id = '".$row['schudele_id']."'");
                        $db->query("UPDATE loan_schedules SET fintot = fintot + '".($penatot)."' WHERE schudele_id = '".$row['schudele_id']."'");
                        $db->query("UPDATE clients SET loan_fines = loan_fines + '".($penatot)."' WHERE clientid = '".$row['member_id']."'");
                    }else if($row['insertion_date'] < NOW_DATETIME::$Date && $row['insertion_date'] != NULL && $row['insertion_date'] !=""){
                        $from1=date_create($row['insertion_date']);
                        $to1=date_create(NOW_DATETIME::$Date);
                        $tttime1 = date_diff($from1,$to1)->format('%R%a');
                        $penatot = (max($repayamt) *(GENERAL_SETTINGS::$loanpenalty/100))*$tttime1;
                        $db->query("UPDATE loan_schedules SET insertion_date = '".NOW_DATETIME::$Date."' WHERE schudele_id = '".$row['schudele_id']."'");
                        $db->query("UPDATE loan_schedules SET fintot = fintot + '".($penatot)."' WHERE schudele_id = '".$row['schudele_id']."'");
                        $db->query("UPDATE loan_schedules SET finetotal = finetotal + '".($penatot)."' WHERE schudele_id = '".$row['schudele_id']."'");
                        $db->query("UPDATE clients SET loan_fines = loan_fines + '".($diifft + $penatot)."' WHERE clientid = '".$row['member_id']."'");
                    }else{}
                    //echo "<br>".$fina."---".$fintot;
                            
                    
                    if($row['actfinetots'] < $fintot){
                        
                        $diifft = $fintot - $row['actfinetots'];
                        $db->query("UPDATE loan_schedules SET finetotal = finetotal + '".$diifft."' WHERE schudele_id = '".$row['schudele_id']."'");
                        $db->query("UPDATE loan_schedules SET fintot = fintot + '".$diifft."' WHERE schudele_id = '".$row['schudele_id']."'");
                        $db->query("UPDATE clients SET loan_fines = loan_fines + '".$diifft."' WHERE clientid = '".$row['member_id']."'");
                    }
                    $db->query("UPDATE loan_schedules SET
                                                    actfinetots = '".$fintot."',
                                                    finestat = '".$finastat."',
                                                    fines = '".$fina."'
                                                    WHERE schudele_id = '".$row['schudele_id']."'");
                    $loop++;
                }
            }
        }   
    }
    public static function loan_analysis(){
		$db = new DB();  NOW_DATETIME::NOW(); $anal = new LOANANALYSIS();
		$loan_amount = "0";
		foreach($db->query("SELECT * FROM clients WHERE writeoffstatus='0'") as $rows){
			$loan_amount = $loan_amount  + $rows['loanaccount'];
		}
		foreach($db->query("SELECT * FROM loananalysis WHERE year='".NOW_DATETIME::$year."'") as $row){}
		
		if($row['year']){
			$lnamts1 = "";
			foreach($db->query("SELECT * FROM loananalysis WHERE year='".NOW_DATETIME::$year."'") as $rowds){
				$amts1 = explode(",",$rowds['loanbals']);
				for($i=1;$i<=12;$i++){
					if(NOW_DATETIME::$month == $i){
						$lnamts1 = $lnamts1.",".$loan_amount;
					}else{
						$lnamts1 = $lnamts1.",".$amts1[$i];
					}
				}
				$db->query("UPDATE loananalysis SET loanbals = '".$lnamts1."' WHERE year='".NOW_DATETIME::$year."'");
			}
		}else{
			$anal->year =  NOW_DATETIME::$year;
			$anal->months =",1,2,3,4,5,6,7,8,9,10,11,12";
			$anal->loanbals =",0,0,0,0,0,0,0,0,0,0,0,0";
			$anal->create();
			$lnamts = "";
			foreach($db->query("SELECT * FROM loananalysis WHERE year='".NOW_DATETIME::$year."'") as $rowd){
				$data1 = SYS_CODES::split_on($rowd['loanbals'],1);
				$amts = explode(",",$data1[1]);
				for($i=1;$i<=12;$i++){
					if(NOW_DATETIME::$month == $i){
						$lnamts = $lnamts.",".$loan_amount;
					}else{
						$lnamts = $lnamts.",".$amts[$i];
					}
				}
				$db->query("UPDATE loananalysis SET loanbals = '".$lnamts."' WHERE year='".NOW_DATETIME::$year."'");
			}
		}
	}
}

class DEPOSIT_CATEGORY extends database_crud{
    protected $table = "deposit_cats";
    protected $pk = "decat_id";
    //SELECT `depart_id`, `deptname` FROM `deposit_cats` WHERE 1
    public static  function GET_DCATSOPTIONS(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM deposit_cats") as $row){
            if($row['depart_id'] == "1" ){

            }elseif ($row['depart_id'] == "9"){
                echo '<option value="'.$row['depart_id'].'">Loan Penalty</option>';
                echo '<option value="10">Loan Recovery</option>';
                echo '<option value="11">Loan Interest</option>';
                echo '<option value="12">Pass Book</option>';
                echo '<option value="13">Ledger Book</option>';
                echo '<option value="14">Withdraw Book</option>';
                echo '<option value="15">Statement</option>';
                echo '<option value="16">T-Shirt</option>';
            }else{
                echo '<option value="'.$row['depart_id'].'">'.$row['deptname'].'</option>';
            }
            
        }
    }
    public static  function GET_DCATS(){
        $db = new DB(); $loop= 1;
        foreach ($db->query("SELECT * FROM deposit_cats") as $row){
            echo '
            <tr>
                <td width="1%"><input id="deptbox'.$loop.'" onchange="depositchoices('.$loop.')" type="checkbox"></td>
                <td width="59%">'.$row['deptname'].'</td>
                <td width="40%">
                    <input onkeyup="sumdepositamt('.$loop.')" disabled style="width: 100%" type="number" id="deptinput'.$loop.'" class="">
                    <div id="others'.$loop.'"></div>
                </td>
                <td id="supvalues'.$loop.'" hidden>'.$row['depart_id'].'</td>
            </tr>
            ';
            $loop++;
        }
    }
    public static  function GET_VALUES(){
        $db = new DB(); GENERAL_SETTINGS::GEN();
        $ressult = $_GET['depositsupvalues'];
        $data = explode("?::?",$ressult);
		
        if($data[0] == "3"){
            foreach ($db->query("SELECT * FROM loan_approvals WHERE member_id='".$data[2]."' AND disburse='1'") as $rowt){}
            foreach ($db->query("SELECT * FROM clients WHERE clientid='".$data[2]."'") as $rowt1){}
            echo "";
            echo "|<><>|";
            echo "";
            echo "|<><>|";
            if($rowt['member_id']){}else{echo "1";}
            if($rowt1['clientdataid']=="1"){echo "1";}
        }
        if($data[0] == "4"){
			echo GENERAL_SETTINGS::$subscription;
        }
        if($data[0] == "5"){
			
			foreach ($db->query("SELECT MAX(chartid) FROM post_chart WHERE clientid='".$data[2]."' AND loan_tag='0'") as $rowt){}
			if($rowt['clientid']){echo "";}else{echo GENERAL_SETTINGS::$loanappl_fees.$rowt['clientid'];}
			echo "|<><>|";
			echo "";
			echo "|<><>|";
			if($rowt['clientid']){echo "2";}
            
        }
        if($data[0] == "6"){
            foreach ($db->query("SELECT * FROM clients WHERE clientid='".$data[2]."'") as $rows){}
            if($rows['accounttype']=="4"){
                echo "5000";
            }else{
                echo GENERAL_SETTINGS::$membershipfees;
            }
            
        }
        if($data[0] == "7"){
            echo GENERAL_SETTINGS::$passbook;
        } 
        if($data[0] == "8"){
            echo "";
            echo "|<><>|";
			echo '
				<select onchange="setschoolfees()" id="basic1" class="selectpicker show-tick form-control" data-live-search="true">
					<option value="">select school...</option>
					';CLIENT_DATA::SCHOOL_OPTIONSEARCH();  echo'
				</select>
				<div id="schoolid"></div>
			';
        }
        if($data[0] == "9"){
            echo "";
            echo "|<><>|";
            echo '<select id="othercharges" onchange="getothercharges('.$data[1].')" class="form-control">
                    <option value="">--select--</option>';
            foreach ($db->query('SELECT * FROM othercharges') as $row){
                echo  '<option  value="'.$row['otherid'].'">'.$row['oname'].'</option>';
            }
            echo'</select>';
        }
    }
    public static  function GET_CHARGES(){
        $db = new DB();
        $ressult = $_GET['getotherchargesvalues'];
        $data = explode("?::?",$ressult);

        if($data[0]=="2"){
            foreach ($db->query("SELECT * FROM clients WHERE clientid='".$data[1]."'") as $rows){}
                echo  $rows['loan_fines'];
                if($rows['loan_fines'] <= "0"){
                    echo "|<><>|";
                    echo "2";
                }
            
			
        }else{
            GENERAL_SETTINGS::GEN();
            echo  GENERAL_SETTINGS::$bankcharges;
        }
    }
}
class SECTIONS extends database_crud{
    protected $table = "sections";
    protected $pk = "sec_id";
    public static $search_code  ,$resultname , $resultid , $resultstatus;

    //SELECT `sec_id`, `seccode`, `secname`, `secact` FROM `sections` WHERE 1
    public static function GET_SECTIONDATA(){
        $db = new DB();
        if($_GET['sectionlevel']=="1"){
            echo '
                <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr class="info">
                            <th width="25%">Code</th>
                            <th width="50%">Account Name</th>
                            <th width="25%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    ';
            foreach($db->query("SELECT * FROM sections") as $row){
                echo '<tr>';
                echo '<td>'.$row['seccode'].'</td>';
                echo '<td>'.$row['secname'].'</td>';
                echo '<td></td>';
                echo '</tr>';
            }
            echo'
                    </tbody>
                </table>
            ';
        }
        if($_GET['sectionlevel']=="2"){
            echo '
                <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr class="info">
                            <th width="10%">Code</th>
                            <th width="40%">Account Name</th>
                            <th width="40%">Section Name</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    ';
            foreach($db->query("SELECT * FROM level2 l, sections s WHERE s.sec_id=l.level1id") as $row){
                echo '<tr>';
                echo '<td>'.$row['level1code'].'</td>';
                echo '<td>'.$row['level1name'].'</td>';
                echo '<td>'.$row['secname'].'&nbsp;&nbsp;<b>'.$row['seccode'].'</b></td>';
                echo '<td></td>';
                echo '</tr>';
            }
            echo'
                    </tbody>
                </table>
            ';
        }
        if($_GET['sectionlevel']=="3"){
            echo '
                <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr class="info">
                            <th width="10%">Code</th>
                            <th width="40%">Level 3</th>
                            <th width="40%">Account Name</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                            ';
            foreach($db->query("SELECT * FROM level3 l, level2 s WHERE s.lvl1_id=l.level2id") as $row){
                echo'<tr>';
                echo '<td>'.$row['level2code'].'</td>';
                echo '<td>'.$row['level2name'].'</td>';
                echo '<td>'.$row['level1name'].'&nbsp;&nbsp;<b>'.$row['level1code'].'</b></td>';
                echo '<td></td>';
                echo '</tr>';
            }
            echo'
                    </tbody>
                </table>
            ';
        }
        if($_GET['sectionlevel']=="4"){
            echo '
                <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr class="info">
                            <th width="15%">Code</th>
                            <th width="40%">Level 4</th>
                            <th width="40%">Level 3</th>
                            <th width="5%">Actions</th>
                        </tr>
                    </thead>';
            foreach($db->query("SELECT * FROM level4 l, level3 s WHERE s.lvl2_id=l.level3id") as $row){
                echo'<tr>';
                echo '<td>'.$row['level3code'].'</td>';
                echo '<td>'.$row['level3name'].'</td>';
                echo '<td>'.$row['level2name'].'&nbsp;&nbsp;<b>'.$row['level2code'].'</b></td>';
                echo '<td></td>';
                echo '</tr>';
            }
            echo'
                    <tbody>
                    </tbody>
                </table>
            ';
        }
        if($_GET['sectionlevel']=="5"){
            echo '
                <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr class="info">
                            <th width="15%">Code</th>
                            <th width="40%">Level 5</th>
                            <th width="40%">Level 4</th>
                            <th width="5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    ';
            foreach($db->query("SELECT * FROM level5 l, level4 s WHERE s.lvl3_id=l.level4id") as $row){
                echo'<tr>';
                echo '<td>'.$row['level4code'].'</td>';
                echo '<td>'.$row['level4name'].'</td>';
                echo '<td>'.$row['level3name'].'&nbsp;&nbsp;<b>'.$row['level3code'].'</b></td>';
                echo '<td></td>';
                echo '</tr>';
            }
            echo'
                    </tbody>
                </table>
            ';
        }

    }
    public static function SAVE_SECTIONS(){
        $db = new DB(); GENERAL_SETTINGS::GEN();
        $ressult = $_GET['savesectionlevel'];
        $data = explode("?::?",$ressult);
        if($data[0] == "1"){
            SYS_CODES::SECCODES();
            $sec = new SECTIONS();
            $sec->secname = $data[1];
            $sec->seccode = SYS_CODES::$seccode;
            $sec->create();
            echo '
                <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr class="info">
                            <th width="25%">Code</th>
                            <th width="50%">Account Name</th>
                            <th width="25%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    ';
            foreach($db->query("SELECT * FROM sections") as $row){
                echo '<tr>';
                echo '<td>'.$row['seccode'].'</td>';
                echo '<td>'.$row['secname'].'</td>';
                echo '<td></td>';
                echo '</tr>';
            }
            echo'
                    </tbody>
                </table>
            ';
            echo '|<><>|';
            static::CHART_UI();
            echo '|<><>|';
            static::CHART_PREVIEW();
        }
        if($data[0] == "2"){
            SYS_CODES::$level1id=$data[2];SYS_CODES::LEVEL2();
            $sec = new LEVEL2();
            $sec->level1id = $data[2];
            $sec->level1name = $data[1];
            $sec->level1code = SYS_CODES::$level1id;
            $sec->create();
            echo '
                <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr class="info">
                            <th width="10%">Code</th>
                            <th width="40%">Account Name</th>
                            <th width="40%">Section Name</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    ';
            foreach($db->query("SELECT * FROM level2 l, sections s WHERE s.sec_id=l.level1id") as $row){
                echo '<tr>';
                echo '<td>'.$row['level1code'].'</td>';
                echo '<td>'.$row['level1name'].'</td>';
                echo '<td>'.$row['secname'].'&nbsp;&nbsp;<b>'.$row['seccode'].'</b></td>';
                echo '<td></td>';
                echo '</tr>';
            }
            echo'
                    </tbody>
                </table>
            ';
            echo '|<><>|';
            static::CHART_UI();
            echo '|<><>|';
            static::CHART_PREVIEW();
        }
        if($data[0] == "3"){
            SYS_CODES::$level2id=$data[2];SYS_CODES::LEVEL3();
            $sec = new LEVEL3();
            $sec->level2id = $data[2];
            $sec->level2name = $data[1];
            $sec->level2code = SYS_CODES::$level2id;
            $sec->create();
            echo '
                <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr class="info">
                            <th width="10%">Code</th>
                            <th width="40%">Account Name</th>
                            <th width="40%">Section Name</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    ';
            foreach($db->query("SELECT * FROM level3 l, level2 s WHERE s.lvl1_id=l.level2id") as $row){
                echo '<tr>';
                echo '<td>'.$row['level2code'].'</td>';
                echo '<td>'.$row['level2name'].'</td>';
                echo '<td>'.$row['level1name'].'&nbsp;&nbsp;<b>'.$row['level1code'].'</b></td>';
                echo '<td></td>';
                echo '</tr>';
            }
            echo'
                    </tbody>
                </table>
            ';
            echo '|<><>|';
            static::CHART_UI();
            echo '|<><>|';
            static::CHART_PREVIEW();
        }
        if($data[0] == "4"){
            SYS_CODES::$level3id=$data[2];SYS_CODES::LEVEL4();
            $sec = new LEVEL4();
            $sec->level3id = $data[2];
            $sec->level3name = $data[1];
            $sec->level3code = SYS_CODES::$level3id;
            $sec->create();
            echo '
                <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr class="info">
                            <th width="15%">Code</th>
                            <th width="40%">Level 4</th>
                            <th width="40%">Level 3</th>
                            <th width="5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    ';
            foreach($db->query("SELECT * FROM level4 l, level3 s WHERE s.lvl2_id=l.level3id") as $row){
                echo'<tr>';
                echo '<td>'.$row['level3code'].'</td>';
                echo '<td>'.$row['level3name'].'</td>';
                echo '<td>'.$row['level2name'].'&nbsp;&nbsp;<b>'.$row['level2code'].'</b></td>';
                echo '<td></td>';
                echo '</tr>';
            }
            echo'
                    </tbody>
                </table>
            ';
            echo '|<><>|';
            static::CHART_UI();
            echo '|<><>|';
            static::CHART_PREVIEW();
        }
        if($data[0] == "5"){
            SYS_CODES::$level4id=$data[2];SYS_CODES::LEVEL5();
            $sec = new LEVEL5();
            $sec->level4id = $data[2];
            $sec->level4name = $data[1];
            $sec->level4code = SYS_CODES::$level4id;
            $sec->create();
            echo '
                <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr class="info">
                            <th width="15%">Code</th>
                            <th width="40%">Level 5</th>
                            <th width="40%">Level 4</th>
                            <th width="5%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    ';
            foreach($db->query("SELECT * FROM level5 l, level4 s WHERE s.lvl3_id=l.level4id") as $row){
                echo'<tr>';
                echo '<td>'.$row['level4code'].'</td>';
                echo '<td>'.$row['level4name'].'</td>';
                echo '<td>'.$row['level3name'].'&nbsp;&nbsp;<b>'.$row['level3code'].'</b></td>';
                echo '<td></td>';
                echo '</tr>';
            }
            echo'
                    </tbody>
                </table>
            ';
            echo '|<><>|';
            static::CHART_UI();
            echo '|<><>|';
            static::CHART_PREVIEW();
        }
    }
    public static function CHART_UI(){
        $db = new DB();
        echo '
            <table width="100%" class="table table-bordered">
                <tr class="danger">
                    <td width="40%"> </td>
                    <td width="40%">
                        <label class="labelcolor">Level 1</label>
                        <input onclick="sectionlevel(1)" id="inputlevel1" type="text" class="form-control" placeholder="Section Name">
                    </td>
                    <td width="40%">
                        <center><br><br>
                            <button onclick="savesectionlevel(1)" class="btn btn-info btn-sm btn-social btn-facebook">save</button>
                            <button disabled class="btn btn-success btn-sm btn-social btn-reddit">edit</button>
                        </center>
                    </td>
                </tr>
                <tr class="success">
                    <td>
                        <label class="labelcolor">Level 2</label>
                        <input onclick="sectionlevel(2)" id="inputlevel2" type="text" class="form-control" placeholder="Account Name">
                    </td>
                    <td>
                        <label class="labelcolor">Level 1</label>
                        <select id="level1" class="selectpicker show-tick form-control" data-live-search="true">
                            <option value="">select level 1</option>';
        foreach($db->query("SELECT * FROM sections") as $row){
            echo '<option value="'.$row['sec_id'].'">'.$row['secname'].'</option>';
        }
        echo'
                        </select>
                    </td>
                    <td>
                        <center><br><br>
                            <button onclick="savesectionlevel(2)" class="btn btn-info btn-sm btn-social btn-facebook">save</button>
                            <button disabled class="btn btn-success btn-sm btn-social btn-reddit">edit</button>
                        </center>
                    </td>
                </tr>
                <tr class="success">
                    <td>
                        <label class="labelcolor">Level 3</label>
                        <input onclick="sectionlevel(3)" id="inputlevel3" type="text" class="form-control" placeholder="Level 3">
                    </td>
                    <td>
                        <label class="labelcolor">Level 2</label>
                        <select id="level2" class="selectpicker show-tick form-control" data-live-search="true">
                            <option value="">select Account Name</option>';
        foreach($db->query("SELECT * FROM sections") as $rows){
            echo '<optgroup label="'.$rows['secname'].'">';
            foreach($db->query("SELECT * FROM level2 WHERE level1id='".$rows['sec_id']."'") as $row){
                echo '<option value="'.$row['lvl1_id'].'">'.$row['level1code'].'&nbsp;&nbsp;'.$row['level1name'].'</option>';
            }
            echo '</optgroup>';
        }
        echo'
                        </select>
                    </td>
                     <td>
                        <center><br><br>
                            <button onclick="savesectionlevel(3)" class="btn btn-info btn-sm btn-social btn-facebook">save</button>
                            <button disabled class="btn btn-success btn-sm btn-social btn-reddit">edit</button>
                        </center>
                    </td>
                </tr>
                <tr class="success">
                    <td>
                        <label class="labelcolor">Level 4</label>
                        <input onclick="sectionlevel(4)" id="inputlevel4" type="text" class="form-control" placeholder="Level 4">
                    </td>
                    <td>
                        <label class="labelcolor">Level 3</label>
                        <select id="level3" class="selectpicker show-tick form-control" data-live-search="true">
                            <option value="">select level 3</option>';
        foreach($db->query("SELECT * FROM level2") as $rows){
            echo '<optgroup label="'.$rows['level1name'].'">';
            foreach($db->query("SELECT * FROM level3 WHERE level2id='".$rows['lvl1_id']."'") as $row){
                echo '<option value="'.$row['lvl2_id'].'">'.$row['level2code'].'&nbsp;&nbsp;'.$row['level2name'].'</option>';
            }
            echo '</optgroup>';
        }
        echo'
                        </select>
                    </td>
                     <td>
                        <center><br><br>
                            <button onclick="savesectionlevel(4)" class="btn btn-info btn-sm btn-social btn-facebook">save</button>
                            <button disabled class="btn btn-success btn-sm btn-social btn-reddit">edit</button>
                        </center>
                    </td>
                </tr>
                <tr class="success">
                    <td>
                        <label class="labelcolor">Level 5</label>
                        <input onclick="sectionlevel(5)" id="inputlevel5" type="text" class="form-control" placeholder="Level 5">
                    </td>
                    <td>
                        <label class="labelcolor">Level 4</label>
                        <select id="level4" class="selectpicker show-tick form-control" data-live-search="true">
                            <option value="">select level 4</option>';
        foreach($db->query("SELECT * FROM level3") as $rows){
            echo '<optgroup label="'.$rows['level2name'].'">';
            foreach($db->query("SELECT * FROM level4 WHERE level3id='".$rows['lvl2_id']."'") as $row){
                echo '<option value="'.$row['lvl3_id'].'">'.$row['level3code'].'&nbsp;&nbsp;'.$row['level3name'].'</option>';
            }
            echo '</optgroup>';
        }
        echo'
                        </select>
                    </td>
                     <td>
                        <center><br><br>
                            <button onclick="savesectionlevel(5)" class="btn btn-info btn-sm btn-social btn-facebook">save</button>
                            <button disabled class="btn btn-success btn-sm btn-social btn-reddit">edit</button>
                        </center>
                    </td>
                </tr>
            </table>
        ';
    }
    public static function CHART_PREVIEW(){
        $db = new DB();
        echo'

            <div class="row">
                <br><br>
                <div class="col-md-11 col-md-offset-1">
                <div class="col-md-12">';

        foreach($db->query("SELECT * FROM sections") as $rows){
            echo ''.$rows['seccode'].'&nbsp;&nbsp;&nbsp;<label style="color: #4368ac">'.$rows['secname'].'</label><br>';
            echo '<div class="col-md-12 col-md-offset-1"><br>';
            foreach($db->query("SELECT * FROM level2 WHERE level1id='".$rows['sec_id']."'") as $row){
                echo ''.$row['level1code'].'&nbsp;&nbsp;&nbsp;<b><span>'.$row['level1name'].'</span></b><br><br>';
                echo '<div class="col-md-12 col-md-offset-1">';
                foreach($db->query("SELECT * FROM level3 WHERE level2id='".$row['lvl1_id']."'") as $rowx){
                    echo ''.$rowx['level2code'].'&nbsp;&nbsp;&nbsp;<span>'.$rowx['level2name'].'
                                        <select onchange="updatechartcoadestatus(this.value)" style="height: 20px;width: 40px"><option value="'.$rowx['level2act'].','.$rowx['level2code'].'">'.$rowx['level2act'].'</option><option value="0,'.$rowx['level2code'].'">0</option><option value="1,'.$rowx['level2code'].'">1</option><option value="2,'.$rowx['level2code'].'">2</option></select>
                                        <select onchange="updatechartcoadestatus1(this.value)" style="height: 20px;width: 40px"><option value="'.$rowx['views'].','.$rowx['level2code'].'">'.$rowx['views'].'</option><option value="0,'.$rowx['level2code'].'">0</option><option value="1,'.$rowx['level2code'].'">1</option></select>
                                        </span><br><br>';
                    echo '<div class="col-md-12 col-md-offset-1">';
                    foreach($db->query("SELECT * FROM level4 WHERE level3id='".$rowx['lvl2_id']."'") as $rowd){
                        echo ''.$rowd['level3code'].'&nbsp;&nbsp;&nbsp;<span>'.$rowd['level3name'].'
                                            <select onchange="updatechartcoadestatus(this.value)" style="height: 20px;width: 40px"><option value="'.$rowd['level3act'].','.$rowd['level3code'].'">'.$rowd['level3act'].'</option><option value="0,'.$rowd['level3code'].'">0</option><option value="1,'.$rowd['level3code'].'">1</option><option value="2,'.$rowd['level3code'].'">2</option></select>
                                            <select onchange="updatechartcoadestatus1(this.value)" style="height: 20px;width: 40px"><option value="'.$rowd['views'].','.$rowd['level3code'].'">'.$rowd['views'].'</option><option value="0,'.$rowd['level3code'].'">0</option><option value="1,'.$rowd['level3code'].'">1</option></select>
                                        </span><br><br>';
                        echo '<div class="col-md-12 col-md-offset-1">';
                        foreach($db->query("SELECT * FROM level5 WHERE level4id='".$rowd['lvl3_id']."'") as $rowe){
                            echo ''.$rowe['level4code'].'&nbsp;&nbsp;&nbsp;<span>'.$rowe['level4name'].'
                                            <select onchange="updatechartcoadestatus(this.value)" style="height: 20px;width: 40px"><option value="'.$rowe['level4act'].','.$rowe['level4code'].'">'.$rowe['level4act'].'</option><option value="0,'.$rowe['level4code'].'">0</option><option value="1,'.$rowe['level4code'].'">1</option><option value="2,'.$rowe['level4code'].'">2</option></select>
                                            <select onchange="updatechartcoadestatus1(this.value)" style="height: 20px;width: 40px"><option value="'.$rowe['views'].','.$rowe['level4code'].'">'.$rowe['views'].'</option><option value="0,'.$rowe['level4code'].'">0</option><option value="1,'.$rowe['level4code'].'">1</option></select>
                                            </span><br><br>';
                        }
                        echo '</div><br>';
                    }
                    echo '</div><br>';
                }
                echo '</div><br>';
            }
            echo '</div><br><br>';
        }
        echo '
                <br>
                </div>
            </div>
        </div>';
    }
    public static function SEARCH_CODE(){
        $db = new DB();
        foreach($db->query("SELECT * FROM level2 WHERE level1code='".self::$search_code."'") as $row){
            self::$resultname = $row["level1name"];     self::$resultid = $row["lvl1_id"];      self::$resultstatus = $row["level1act"];
        }
        foreach($db->query("SELECT * FROM level3 WHERE level2code='".self::$search_code."'") as $row){
            self::$resultname = $row["level2name"];     self::$resultid = $row["lvl2_id"];      self::$resultstatus = $row["level2act"];
        }
        foreach($db->query("SELECT * FROM level4 WHERE level3code='".self::$search_code."'") as $row){
            self::$resultname = $row["level3name"];     self::$resultid = $row["lvl3_id"];      self::$resultstatus = $row["level3act"];
        }
        foreach($db->query("SELECT * FROM level5 WHERE level4code='".self::$search_code."'") as $row){
            self::$resultname = $row["level4name"];     self::$resultid = $row["lvl4_id"];      self::$resultstatus = $row["level4act"];
        }
    }
    public static function UPDATE_STATUS(){
        $db = new DB();
        $data = explode(',',$_GET['updatechartcoadestatus']);
        self::$search_code = $data[1];
        foreach($db->query("SELECT * FROM level2 WHERE level1code='".self::$search_code."'") as $row){
            $db->query("UPDATE level2 SET level1act='".$data[0]."' WHERE lvl1_id='".$row['lvl1_id']."'");
        }
        foreach($db->query("SELECT * FROM level3 WHERE level2code='".self::$search_code."'") as $row){
            $db->query("UPDATE level3 SET level2act='".$data[0]."' WHERE lvl2_id='".$row['lvl2_id']."'");
        }
        foreach($db->query("SELECT * FROM level4 WHERE level3code='".self::$search_code."'") as $row){
            $db->query("UPDATE level4 SET level3act='".$data[0]."' WHERE lvl3_id='".$row['lvl3_id']."'");
        }
        foreach($db->query("SELECT * FROM level5 WHERE level4code='".self::$search_code."'") as $row){
            $db->query("UPDATE level5 SET level4act='".$data[0]."' WHERE lvl4_id='".$row['lvl4_id']."'");
        }
        self::CHART_PREVIEW();
    }
    public static function UPDATE_STATUS1(){
        $db = new DB();
        $data = explode(',',$_GET['updatechartcoadestatus1']);
        self::$search_code = $data[1];
        foreach($db->query("SELECT * FROM level3 WHERE level2code='".self::$search_code."'") as $row){
            $db->query("UPDATE level3 SET views='".$data[0]."' WHERE lvl2_id='".$row['lvl2_id']."'");
        }
        foreach($db->query("SELECT * FROM level4 WHERE level3code='".self::$search_code."'") as $row){
            $db->query("UPDATE level4 SET views='".$data[0]."' WHERE lvl3_id='".$row['lvl3_id']."'");
        }
        foreach($db->query("SELECT * FROM level5 WHERE level4code='".self::$search_code."'") as $row){
            $db->query("UPDATE level5 SET views='".$data[0]."' WHERE lvl4_id='".$row['lvl4_id']."'");
        }
        self::CHART_PREVIEW();
    }
}
class LEVEL2 extends database_crud{
    protected $table = "level2";
    protected $pk = "lvl1_id";
    //SELECT `lvl1_id`, `level1id`, `level1name`, `level1code`, `level1act` FROM `level2` WHERE 1
}
class LEVEL3 extends database_crud{
    protected $table = "level3";
    protected $pk = "lvl2_id";
    //SELECT `lvl2_id`, `level2id`, `level2name`, `level2code`, `level2act` FROM `level3` WHERE 1
}
class LEVEL4 extends database_crud{
    protected $table = "level4";
    protected $pk = "lvl3_id";
    //SELECT `lvl3_id`, `level3id`, `level3name`, `level3code`, `level3act` FROM `level4` WHERE 1
}
class LEVEL5 extends database_crud{
    protected $table = "level5";
    protected $pk = "lvl4_id";
    //SELECT `lvl4_id`, `level4id`, `level4name`, `level4code`, `level4act` FROM `level5` WHERE 1
}
class ACCOUNTTYPE extends database_crud{
	protected $table = "accounttypes";
	protected $pk = "typeid";
	// SELECT `typeid`, `typecat`, `typename`, `interest` FROM `accounttypes` WHERE 1
	public static function ADDSAVETYPE(){
		$type = new ACCOUNTTYPE();	$data = explode("?::?",$_GET['addsavingtype']);
		$type->typecat = "2";
		$type->typename = $data[0];
		if($data[1]){
			$type->typeid = $data[1];
			$type->save();
		}else{
			$type->create();
		}
		echo '
			<select id="modsavetype" onchange="savingtypefunc()" class="form-control">
				<option value="">select Saving Account to Modify</option>
				'; ACCOUNTTYPE::GETSAVINGTYPE(); echo'
			</select>
		';
		echo '|<><>|';
		echo '
			<select id="modesavetypeint" class="form-control">
				<option value="">select Interest to Modify</option>
				'; ACCOUNTTYPE::GETSAVETYPEINTEREST(); echo'
			</select>
		';
	}
	public static function ADDLOANTYPE(){
		$type = new ACCOUNTTYPE();	$data = explode("?::?",$_GET['getloantype']);
		$type->typecat = "1";
		$type->typename = $data[0];
		if($data[1]){
			$type->typeid = $data[1];
			$type->save();
		}else{
			$type->create();
		}
		echo '
			<select id="modloantype" onchange="loanfunc()" class="form-control">
				<option value="">select Loan Type to Modify</option>
				'; ACCOUNTTYPE::GETLOANTYPE(); echo'
			</select>
		';
		echo '|<><>|';
		echo '
			<select id="modeloantypeint" class="form-control">
				<option value="">select Interest to Modify</option>
				'; ACCOUNTTYPE::GETLOANTYPEINTEREST(); echo'
			</select>
		';
		echo '|<><>|';
		echo '
			<select id="modgraceperiod" class="form-control">
				<option value="">select Grace Period to Modify</option>
				'; ACCOUNTTYPE::GETLOANTYPEPERIOD(); echo'
			</select>
		';
	}
	public static function MODLOANTYPEINTEREST(){
		$type = new ACCOUNTTYPE();	$data = explode("?::?",$_GET['modloantypeint']);
		$type->interest = $data[1];
		$type->typeid = $data[0];
		$type->save();
		echo '
			<select id="modeloantypeint" class="form-control">
				<option value="">select Interest to Modify</option>
				'; ACCOUNTTYPE::GETLOANTYPEINTEREST(); echo'
			</select>
		';
	}
	public static function MODSAVETYPEINTEREST(){
		$type = new ACCOUNTTYPE();	$data = explode("?::?",$_GET['modsavetypeint']);
		$type->interest = $data[1];
		$type->typeid = $data[0];
		$type->save();
		echo '
			<select id="modesavetypeint" class="form-control">
				<option value="">select Interest to Modify</option>
				'; ACCOUNTTYPE::GETSAVETYPEINTEREST(); echo'
			</select>
		';
	}
	public static function MODLOANTYPEPEROID(){
		$type = new ACCOUNTTYPE();	$data = explode("?::?",$_GET['modloantypepreoid']);
		$type->period = $data[0];
		$type->typeid = $data[1];
		$type->save();
		echo '
			<select id="modgraceperiod" class="form-control">
				<option value="">select Grace Period to Modify</option>
				'; ACCOUNTTYPE::GETLOANTYPEPERIOD(); echo'
			</select>
		';
	}
	public static function GETLOANTYPE(){
		$db = new DB();
		foreach($db->query("SELECT * FROM accounttypes WHERE typecat='1'") as $row){
			echo "<option value=".$row['typeid'].">".$row['typename']."</option>";
		}
	}
	public static function GETSAVINGTYPE(){
		$db = new DB();
		foreach($db->query("SELECT * FROM accounttypes WHERE typecat='2'") as $row){
			echo "<option value=".$row['typeid'].">".$row['typename']."</option>";
		}
	}	
	public static function GETSAVETYPEINTEREST(){
		$db = new DB();
		foreach($db->query("SELECT * FROM accounttypes WHERE typecat='2'") as $row){
			echo "<option value=".$row['typeid'].">".$row['typename']."&nbsp;&nbsp;&nbsp; at &nbsp;&nbsp;".$row['interest']."%</option>";
		}
	}
	public static function GETLOANTYPEINTEREST(){
		$db = new DB();
		foreach($db->query("SELECT * FROM accounttypes WHERE typecat='1'") as $row){
			echo "<option value=".$row['typeid'].">".$row['typename']."&nbsp;&nbsp;&nbsp; at &nbsp;&nbsp;".$row['interest']."%</option>";
		}
	}
	public static function GETLOANTYPEPERIOD(){		
		$db = new DB();
		foreach($db->query("SELECT * FROM accounttypes WHERE typecat='1'") as $row){
			echo "<option value=".$row['typeid'].">".$row['typename']."&nbsp;&nbsp;&nbsp; at &nbsp;&nbsp;".$row['period']."</option>";
		}
	}
	public static function GETSAVETYPEPERIOD(){		
		$db = new DB();
		foreach($db->query("SELECT * FROM accounttypes WHERE typecat='2'") as $row){
			echo "<option value=".$row['typeid'].">".$row['typename']."&nbsp;&nbsp;&nbsp; at &nbsp;&nbsp;".$row['period']."</option>";
		}
	}
	public static function DELSAVETYPE(){
		$db = new DB();
		$db->query("DELETE FROM accounttypes WHERE typeid='".$_GET['delsavetype']."'");
		echo '
			<select id="modsavetype" onchange="savingtypefunc()" class="form-control">
				<option value="">select Saving Account to Modify</option>
				'; ACCOUNTTYPE::GETSAVINGTYPE(); echo'
			</select>
		';
		echo '|<><>|';
		echo '
			<select id="modesavetypeint" class="form-control">
				<option value="">select Interest to Modify</option>
				'; ACCOUNTTYPE::GETSAVETYPEINTEREST(); echo'
			</select>
		';
	}
	public static function DELLOANTYPE(){
		$db = new DB();
		$db->query("DELETE FROM accounttypes WHERE typeid='".$_GET['delloantype']."'");
		echo '
			<select id="modloantype" onchange="loanfunc()" class="form-control">
				<option value="">select Loan Type to Modify</option>
				'; ACCOUNTTYPE::GETLOANTYPE(); echo'
			</select>
		';
		echo '|<><>|';
		echo '
			<select id="modeloantype" class="form-control">
				<option value="">select Interest to Modify</option>
				'; ACCOUNTTYPE::GETLOANTYPEINTEREST(); echo'
			</select>
		';
		echo "|<><>|";
		echo '
			<select id="modgraceperiod" class="form-control">
				<option value="">select Grace Period to Modify</option>
				'; ACCOUNTTYPE::GETLOANTYPEPERIOD(); echo'
			</select>
		';
	}	
	public static function UPDATESAVINGTYPE(){
		$db = new DB();  session_start();
		$data = explode("?::?",$_GET['setsavingaccount']);
		if($data[0] == "5"){
                    $db->query("UPDATE clients SET savingaccount = savingaccount - $data[4], savetype='".$data[0]."',fixedamount='".$data[4]."'  WHERE clientid='".$data[1]."'");
                    foreach($db->query("SELECT * FROM fixeddepositaccount WHERE clientid='".$data[1]."'") as $row){}
                    $fix = new FIXEDDEPOSITACCOUNT();
                    $da = explode("/",$data[2]);
                    $da1 = explode("/",$data[3]);
                    $date = $da[2]."-".$da[0]."-".$da[1];
                    $date1 = $da1[2]."-".$da1[0]."-".$da1[1];
                    if($row['clientid']){
                        $db->query("UPDATE fixeddepositaccount SET fixedamount='".$data[4]."',startdate='".$date."', enddate='".$date1."', user_handle='".$_SESSION['user_id']."' WHERE clientid='".$data[1]."'");
                    }else{
                        $fix->clientid = $data[1];
                        $fix->fixedamount = $data[4];
                        $fix->startdate = $date;
                        $fix->enddate  = $date1;
                        $fix->user_handle  = $_SESSION['user_id'];
                        $fix->create();	
                    }	
		} else {
                    foreach($db->query("SELECT * FROM clients WHERE clientid='".$data[1]."'") as $row){
                        $db->query("UPDATE clients SET savingaccount = savingaccount + fixedamount, savetype='".$data[0]."',fixedamount='0' WHERE clientid='".$data[1]."'");    
                    }
                }
		self::SAVINGACCOUNT_SETUP();
	}
	public static function SAVINGACCOUNT_SETUP(){
		$db = new DB(); $loop = "1";
		echo '
		<table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr class="info">
                            <th width="30%">Account Detail</th>
                            <th width="30%">Account type and Balance</th>
                            <th width="40%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    '; 
                    foreach($db->query("SELECT * FROM clients ORDER BY clientid DESC") as $row){
				CLIENT_DATA::$clientid = $row['clientid'];
				CLIENT_DATA::CLIENTDATAMAIN();
				foreach($db->query("SELECT * FROM accounttypes WHERE typeid='".$row['savetype']."'") as $rows){
					$savetype = $rows['typename'];  
					if($rows['typeid']=="5"){
                                            foreach($db->query("SELECT * FROM fixeddepositaccount WHERE clientid='".$row['clientid']."'") as $rowx){
                                                $startdate = $rowx['startdate'];
                                                $enddate = $rowx['enddate'];
                                                $fixamt = $rowx['fixedamount'];
                                            }
                                            $des = "1";
					}else{
                                            $des= "";
                                            $startdate = "";
                                            $enddate = "";
					}
				}
                                
				echo "<tr>";
				echo "<td data-order='1'><b>".CLIENT_DATA::$accountname." </b> <br><b>(".CLIENT_DATA::$accountno.")</b></td>";
				echo "<td>
                                        Account Type: <b class='label label-".(($des == "1")?"danger":"info")." pull-right'>".(($row['savetype']=="0")?"":$savetype)."</b><br>
                                        Saving Balance : <b class='pull-right'> ".number_format($row['savingaccount'])."</b>
                                        ".(($rows['typeid'] == "5")?"<br><b>Start Date: </b><b class='pull-right'>".$startdate."</b><br><b>End Date : </b><b class='pull-right'>".$enddate."</b><br>Fixed Amount : </b><b class='pull-right'>".$fixamt."":"")."
					</td>";
				echo '<td>
                                        <div id="fixdepositspace'.$loop.'"></div><br>
                                        <div  style="padding: 5px">
                                            <select id="savetypeint'.$loop.'" onchange="checkfixeddeposit('.$loop.')" class="form-control" style="width: 80%;margin-bottom: 4px">
                                                <option value="">select Saving Account Type</option>
                                                '; ACCOUNTTYPE::GETSAVINGTYPE(); echo'
                                            </select>
                                            <button onclick="setsavingaccount('.$loop.','.$row['clientid'].')" class="btn btn-social btn-primary"><i class="ti ti-save"></i></button>
                                        </div>
                                        </td>';
				echo "</tr>";
                                $savetype= "";
                                $startdate = "";
                                $enddate = "";
                                $fixamt = "";
				$loop++;
			} 
		echo'
			</tbody>
		</table>
		';
	}
}