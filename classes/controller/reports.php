<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class NONCASH_TRASNSACTIONS extends database_crud {
    protected $table="noncashtracs";
    protected $pk="nontracid";
    //SELECT `nontracid`, `clientid`, `user_handle`, `accountcode`, `amount`, `sbal`, `ndate`, `ntime` FROM `noncashtracs` WHERE 1

    public static function SAVETRANSFERSAVINGS(){
        $nocash = new NONCASH_TRASNSACTIONS();    $db = new DB();
        session_start();     NOW_DATETIME::NOW();     
        $merge = new MERGERWD(); GENERAL_SETTINGS::GEN(); $chart = new POST_CHART();
        $data = explode("?::?",$_GET['savetransfersavings']);
        
        $db->query("UPDATE clients SET savingaccount = savingaccount - '".$data[2]."' WHERE clientid = '".$data[0]."'");
        // share handle
        
        if($data[1] == "2"){
            $db->query("UPDATE clients SET shareaccount_amount = shareaccount_amount + '".$data[2]."' WHERE clientid = '".$data[0]."'");
            $db->query("UPDATE clients SET numberofshares = numberofshares + '".($data[2]/GENERAL_SETTINGS::$sharevalue)."' WHERE clientid = '".$data[0]."'");
            foreach ($db->query("SELECT * FROM clients WHERE clientid = '".$data[0]."'") as $row){$savingbalnce = $row['savingaccount']; $sharebal = $row['shareaccount_amount'];}
        }
        // loan repayment
        
        if($data[1] == "3"){
            foreach ($db->query("SELECT * FROM clients WHERE clientid='".$data[0]."'") as $clnt){

                if(($clnt['loanaccount'] - $data[2]) <= "0"){
                    $db->query("UPDATE clients SET loanaccount = '0' WHERE clientid = '".$data[0]."'");
                }else{
                    $db->query("UPDATE clients SET loanaccount = loanaccount - '".$data[2]."' WHERE clientid = '".$data[0]."'");
                }
                
                if($clnt['clientdataid']=="1"){
                    foreach ($db->query("SELECT * FROM clients WHERE clientid = '".$data[0]."'") as $row){$loanaccount = $row['loanaccount'];}
                    $lnstat = new LOANSTATBALS();
                    $lnstat->clientid = $data[0];
                    $lnstat->amount = $data[2];
                    $lnstat->balance = $loanaccount;
                    $lnstat->handle = $_SESSION['user_id'];
                    $lnstat->paydate = NOW_DATETIME::$Date_Time;
                    $lnstat->create();
                    $db->query("UPDATE clients SET clientdataid = '0' WHERE clientid = '".$data[0]."'");
                }else{
                    foreach ($db->query("SELECT * FROM loan_approvals WHERE disburse='1' AND member_id='".$data[0]."'") as $row){
                        foreach ($db->query("SELECT * FROM loan_schedules WHERE approveid='".$row['desc_id']."'") as $rows){
                            foreach ($db->query("SELECT * FROM clients WHERE clientid = '".$data[0]."'") as $row){$loanaccount = $row['loanaccount'];}
                            $repay = new LOAN_REPAYMENT();
                            $repay->sheduleid     = $rows['schudele_id'];
                            $repay->amount        = $data[2];
                            $repay->loanbals      = $loanaccount;
                            $repay->repay_type    = "1";
                            $repay->interestbal   = $clnt['loan_interest'];
                            $repay->interestpaid   = $clnt['loan_interest'];
                            $repay->inserted_date = NOW_DATETIME::$Date_Time;
                            $repay->create();
                        }
                    }
                    foreach ($db->query("SELECT * FROM clients WHERE clientid = '".$data[0]."'") as $rowy){}
                    
                    if(($rowy['loanaccount'] - $data[2]) < "0"){
                        $db->query("UPDATE loan_approvals SET disburse = '2' WHERE member_id = '".$data[0]."'");
                        $db->query("UPDATE loan_schedules SET loanstatus = '1' WHERE schudele_id = '".$rows['schudele_id']."'");
                    }else{
                        if(($rowy['loanaccount'] - $data[2]) == "0"){
                            $db->query("UPDATE loan_approvals SET disburse = '2' WHERE member_id = '".$data[0]."'");
                            $db->query("UPDATE loan_schedules SET loanstatus = '1' WHERE schudele_id = '".$rows['schudele_id']."'");
                        }
                    }
                }
            }
        }
        
        if($data[1] == "9"){
            
            $db->query("UPDATE clients SET loan_fines = loan_fines - '".$data[2]."' WHERE clientid = '".$data[0]."'");
            foreach ($db->query("SELECT * FROM loan_schedules s, loan_approvals a WHERE a.desc_id=s.approveid AND a.member_id='".$data[0]."'") as $rows){}

            if($rows['finetotal'] != "0"){ //$message .= ".".$tracsaveamt[$t]."..".$rows['finetotal'];
                if($tracsaveamt[$t]<=$rows['finetotal']){ 
                    $db->query("UPDATE loan_schedules SET finetotal = finetotal - '".$tracsaveamt[$t]."' WHERE schudele_id = '".$rows['schudele_id']."'");
                }
                foreach ($db->query("SELECT * FROM loan_schedules s, loan_approvals a WHERE a.desc_id=s.approveid AND a.member_id='".$data[0]."'") as $rows){}
                $fines = new LOAN_FINES();
                $fines->sheduleid     = $rows['schudele_id'];
                $fines->amount        = $data[2];
                $fines->balance       = $rows['finetotal'];
                $fines->inserted_date = NOW_DATETIME::$Date_Time;
                $fines->create();
            }
        }
            
        if($data[1] == "5"){
            $chart->clientid = $data[0];
            $chart->depositeditems = ",5";
            $chart->depositedamts = ",".$data[2];
            $chart->inserteddate = NOW_DATETIME::$Date;
            $chart->e_tag = "0";
            $chart->userhandle = $_SESSION['user_id'];
            $chart->amount = $data[0];
            $chart->create();
        }
        
        if($data[1] == "11"){
            $db->query("UPDATE clients SET loan_interest = loan_interest - '".$data[2]."' WHERE clientid = '".$data[0]."'");
            $ln = new LOANINTEREST();
            $ln->clientid =  $data[0];
            $ln->amount  = $data[2];
            $ln->create();
        }
        
        foreach ($db->query("SELECT * FROM clients WHERE clientid = '".$data[0]."'") as $row){$savingbalnce = $row['savingaccount'];}

        $nocash->ttype  = "0";
        $nocash->clientid = $data[0];
        $nocash->accountcode = $data[1];
        $nocash->amount = $data[2];
        $nocash->user_handle = $_SESSION['user_id'];
        $nocash->sbal = $savingbalnce;
        $nocash->shrbal = $sharebal;
        $nocash->ndate = NOW_DATETIME::$Date;
        $nocash->ntime = NOW_DATETIME::$Time;
        $nocash->create();

        $merge->transactiontype = "6";
        $merge->transactionid = $nocash->pk;
        $merge->insertiondate = NOW_DATETIME::$Date_Time;
        $merge->clientid = $data[0];
        $merge->create();

        ;
        self::RETURNEDNONCASHTRANSFER();
        echo '|<><>|';
        self::CANCELNONCASHTRANSFER();
    }
    
    public static function SAVINGBAL(){
            CLIENT_DATA::$clientid = $_GET['getsavingbalance'];
            CLIENT_DATA::CLIENTDATAMAIN();
            echo number_format(CLIENT_DATA::$savingaccount);
            echo "|<><>|";
            echo CLIENT_DATA::$savingaccount;
    }

    public static function RETURNEDNONCASHTRANSFER(){   
            $db = new DB();
            echo '
            <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                            <tr class="info">
                                    <th width="30%">Account Detail</th>
                                    <th width="40%">Date and Time</th>
                                    <th width="25%">Transfer Detail</th>
                                    <th width="5%">Actions</th>
                            </tr>
                    </thead>
                    <tbody>
                    '; 
                    foreach($db->query("SELECT * FROM noncashtracs WHERE ttype='0' ORDER BY nontracid DESC") as $row){
                            CLIENT_DATA::$clientid = $row['clientid'];
                            CLIENT_DATA::CLIENTDATAMAIN();
                            if($row['accountcode']=="2"){$accountcodename = "Share Capital";}
                            if($row['accountcode']=="3"){$accountcodename = "Loan Repayment";}
                            if($row['accountcode']=="5"){$accountcodename = "Loan Application Fee";}
                            if($row['accountcode']=="6"){$accountcodename = "MemberShip Fee";}
                            if($row['accountcode']=="7"){$accountcodename = "Pass Book / Stationary";}
                            if($row['accountcode']=="8"){$accountcodename = "School Fees";}
                            if($row['accountcode']=="d"){$accountcodename = "Multiple Deposit";}
                            if($row['accountcode']=="9"){$accountcodename = "Loan Penalty";}
                            if($row['accountcode']=="10"){$accountcodename = "Loan Recovery";}
                            if($row['accountcode']=="11"){$accountcodename = "Loan Interest";}
                            if($row['accountcode']=="12"){$accountcodename = "Pass Book";}
                            if($row['accountcode']=="13"){$accountcodename = "Ledger Book";}
                            if($row['accountcode']=="14"){$accountcodename = "Withdraw Book";}
                            echo "<tr>";
                            echo "<td data-order='1'><b style='color: #b9151b;'>".$accountcodename."</b><br><b>".CLIENT_DATA::$accountname." </b> <b class='pull-right'>(".CLIENT_DATA::$accountno.")</b></td>";
                            echo "<td>".$row['investiment_description']."<br>Transfer Date: <b>".$row['ndate']."</b><br>Time : <b> ".$row['ntime']."</b></td>";
                            echo "<td>Transfer Amount : <b>".number_format($row['amount'])."</b><br>Saving Balance : <b>".number_format($row['sbal'])."</b></td>";
                            echo "<td></td>";
                            echo "</tr>";
                    } 
            echo'
                    </tbody>
            </table>
            ';

    }

    public static function CANCELNONCASHTRANSFER(){
        echo '
            <div class="alert alert-info" style="background-color: #00af6e">
                <div hidden id="savbal"></div>
                <b style="font-weight: 900;font-size: 18px;color: #ffffff">Client\'s Saving Balance</b><br>
                <hr>
                <b style="font-weight: 900;font-size: 18px;color: #ffffff">Amount <span id="savingbal" class="pull-right">'.number_format(0).'</span></b><br>
            </div><br><br>
            <label class="labelcolor">Client Name</label>
            <select onchange="getsavingbalance()" id="basic" class="selectpicker show-tick form-control" data-live-search="true">
                <option value="">select member...</option>
                ';CLIENT_DATA::CLIENT_OPTIONSEARCH();  echo'
            </select><br>
            <label class="labelcolor">Transfer Account</label> 
            <select onchange="transferaccountchoice()" id="transferoptions" class="form-control">
                <option value="">select Transfer Account</option>
                ';DEPOSIT_CATEGORY::GET_DCATSOPTIONS();  echo'
            </select><br>
            <label class="labelcolor">Transfer Amount</label> 
            <input onclick="" id="amtrcvd" type="text" class="form-control" placeholder="Enter Amount Received"><br>
            <center>
                <button class="btn-primary btn" type="" onclick="savetransfersavings()" >Submit Record</button>
                <button onclick="canceltransfersavings()" class="btn btn-default" >Cancel</button>  
            </center> <br><br>
        ';
    }
}

class DEPWITH_REPORTS{
    
    public static function DEPOSITWITHDRAW_REPORTS(){
            $data = explode("?::?",$_GET['depwithreport']);
            $db = new DB(); 
            $ql = (($data[2]=="all")?"":" AND MONTHNAME(insertiondate) = '".$data[2]."'");
            $ql1 = (($data[2]=="all")?"":" AND MONTHNAME(inserteddate) = '".$data[2]."'");

            if($data[0] == "1"){
                    $dep = "0";
                    $sub = "0";
                    $savg = "0";
                    $shrs = "0";
                    $lnrepay = "0";
                    $lnapp = "0";
                    $mmshp = "0";
                    $psbk = "0";
                    $sch = "0";
                    $othercharge = "0";
                    foreach ($db->query("SELECT * FROM mergerwd WHERE YEAR(insertiondate)='".$data[1]."' ".$ql." ORDER BY mergeid DESC") as $rowt){

                            if($rowt['transactiontype']=="1"){
                                    foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."'") as $row1){
                                            $dep = $dep + $row1['amount'];
                                            $dec = explode(",",$row1['depositeditems']);
                                                    $fig = explode(",",$row1['depositedamts']);
                                                    $descriptions = "";
                                                    for($i = 1; $i<=count($dec); $i++){
                                                            if($dec[$i]=="1"){
                                                                    $savg = $savg + $fig[$i];
                                                            }
                                                            if($dec[$i]=="2"){
                                                                    $shrs = $shrs + $fig[$i];
                                                            }

                                                            if($dec[$i]=="3"){
                                                                    $lnrepay = $lnrepay + $fig[$i];
                                                            }

                                                            if($dec[$i]=="4"){
                                                                    $sub = $sub + $fig[$i];
                                                            }

                                                            if($dec[$i]=="5"){
                                                                    $lnapp = $lnapp + $fig[$i];
                                                            }

                                                            if($dec[$i]=="6"){
                                                                    $mmshp = $mmshp + $fig[$i];
                                                            }

                                                            if($dec[$i]=="7"){
                                                                    $psbk = $psbk + $fig[$i];
                                                            }

                                                            if($dec[$i]=="8"){
                                                                    $sch = $sch + $fig[$i];
                                                            }

                                                            $dataxx = explode("charges",$dec[$i]);
                                                            if($dataxx[1]){
                                                                    foreach ($db->query('SELECT * FROM othercharges WHERE otherid="'.$dataxx[1].'"') as $row){}
                                                                    $othercharge = $othercharge + $fig[$i];

                                                            }

                                                    }
                                    }


                            }
                    }


                    echo'
                        <table>
                            <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                                <td>Savings:</td>
                                <td>&nbsp;&nbsp;<b>'.number_format($savg).'</b></td>
                                <td>&nbsp;&nbsp;Share Capital:</td>
                                <td>&nbsp;&nbsp;<b>'.number_format($shrs).'</b></td>
                            <tr>
                            <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                                <td>Loan Repayment:</td>
                                <td>&nbsp;&nbsp;<b>'.number_format($lnrepay).'</b></td>
                                <td>&nbsp;&nbsp;Loan Application Fees:</td>
                                <td>&nbsp;&nbsp;<b>'.number_format($lnapp).'</b></td>
                            <tr>
                            <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                                <td>Membership Fees:</td>
                                <td>&nbsp;&nbsp;<b>'.number_format($mmshp).'</b></td>
                                <td>&nbsp;&nbsp;Pass Books:</td>
                                <td>&nbsp;&nbsp;<b>'.number_format($psbk).'</b></td>
                            <tr>
                            <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                                <td>School Fees:</td>
                                <td>&nbsp;&nbsp;<b>'.number_format($sch).'</b></td>
                                <td>&nbsp;&nbsp;Other Charges:</td>
                                <td>&nbsp;&nbsp;<b>'.number_format($othercharge).'</b></td>
                            <tr>
                            <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                                <td>Subscription Fees:</td>
                                <td>&nbsp;&nbsp;<b>'.number_format($sub).'</b></td>
                            <tr>
                        </table><br>
                    ';

                    echo'
                            <table>
                                    <tr style="font-weight: 800; font-family: Courier New;font-size: 16px">
                                            <td>Total Deposited Amount:</td>
                                            <td>&nbsp;&nbsp;<b>'.number_format($dep).'</b></td>
                                    <tr>
                            </table><br>
                    ';
                    echo '
                        <div>
                        <table id="oppsd" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                            <thead>
                                <tr>
                                    <th width="15%">Date Deposited</th>
                                    <th width="15%">A/C</th>
                                    <th width="32%">Deposit Description</th>
                                    <th width="15%">Amount</th>
                                    <th width="15%">A/C Bal</th>
                                    <th width="18%">Handled</th>
                                </tr>
                            </thead>
                            <tbody>';
                                    foreach ($db->query("SELECT * FROM mergerwd WHERE YEAR(insertiondate)='".$data[1]."' ".$ql." ORDER BY mergeid DESC") as $rowt){
                                            CLIENT_DATA::$clientid = $rowt['clientid'];
                                            CLIENT_DATA::CLIENTDATAMAIN();
                                            if($rowt['transactiontype']=="1"){
                                                    foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."'") as $row1){
                                                    foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
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
                                                            echo '<td width="15%" data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                                                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                                                            echo '<td width="32%">
                                                                    <b style="font-size: 12px">'.$descriptions.'</b><br>
                                                                    <b style="color: #08b44d">Deposited By: </b> '.$row1['depositor'].'
                                                                    </td>';
                                                            echo '<td width="12%">'.number_format($row1['amount']).'</td>';
                                                            echo '<td width="13%">'.number_format($row1['balance']).'</td>';
                                                            echo '<td width="20%">'.$rowuser['user_name'].'</td>';
                                                            echo '</tr>';
                                                    }
                                            }
                                    }


                    echo '
                                    </tbody>
                            </table>
                            </div>
                    ';      
            }

            if($data[0] == "2"){
                    $dep = "0";
                    $sub = "0";
                    $savg = "0";
                    $shrs = "0";
                    $lnrepay = "0";
                    $lnapp = "0";
                    $mmshp = "0";
                    $psbk = "0";
                    $sch = "0";
                    $othercharge = "0";
                    foreach ($db->query("SELECT * FROM mergerwd WHERE YEAR(insertiondate)='".$data[1]."' AND clientid='".$data[3]."' ".$ql." ORDER BY mergeid DESC") as $rowt){

                            if($rowt['transactiontype']=="1"){
                                    foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."'") as $row1){
                                            $dep = $dep + $row1['amount'];
                                            $dec = explode(",",$row1['depositeditems']);
                                                    $fig = explode(",",$row1['depositedamts']);
                                                    $descriptions = "";
                                                    for($i = 1; $i<=count($dec); $i++){
                                                            if($dec[$i]=="1"){
                                                                    $savg = $savg + $fig[$i];
                                                            }
                                                            if($dec[$i]=="2"){
                                                                    $shrs = $shrs + $fig[$i];
                                                            }

                                                            if($dec[$i]=="3"){
                                                                    $lnrepay = $lnrepay + $fig[$i];
                                                            }

                                                            if($dec[$i]=="4"){
                                                                    $sub = $sub + $fig[$i];
                                                            }

                                                            if($dec[$i]=="5"){
                                                                    $lnapp = $lnapp + $fig[$i];
                                                            }

                                                            if($dec[$i]=="6"){
                                                                    $mmshp = $mmshp + $fig[$i];
                                                            }

                                                            if($dec[$i]=="7"){
                                                                    $psbk = $psbk + $fig[$i];
                                                            }

                                                            if($dec[$i]=="8"){
                                                                    $sch = $sch + $fig[$i];
                                                            }

                                                            $dataxx = explode("charges",$dec[$i]);
                                                            if($dataxx[1]){
                                                                    foreach ($db->query('SELECT * FROM othercharges WHERE otherid="'.$dataxx[1].'"') as $row){}
                                                                    $othercharge = $othercharge + $fig[$i];

                                                            }

                                                    }
                                    }


                            }
                    }


                    echo'
                            <table>
                                    <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                                            <td>Savings:</td>
                                            <td>&nbsp;&nbsp;<b>'.number_format($savg).'</b></td>
                                            <td>&nbsp;&nbsp;Share Capital:</td>
                                            <td>&nbsp;&nbsp;<b>'.number_format($shrs).'</b></td>
                                    <tr>
                                    <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                                            <td>Loan Repayment:</td>
                                            <td>&nbsp;&nbsp;<b>'.number_format($lnrepay).'</b></td>
                                            <td>&nbsp;&nbsp;Loan Application Fees:</td>
                                            <td>&nbsp;&nbsp;<b>'.number_format($lnapp).'</b></td>
                                    <tr>
                                    <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                                            <td>Membership Fees:</td>
                                            <td>&nbsp;&nbsp;<b>'.number_format($mmshp).'</b></td>
                                            <td>&nbsp;&nbsp;Pass Books:</td>
                                            <td>&nbsp;&nbsp;<b>'.number_format($psbk).'</b></td>
                                    <tr>
                                    <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                                            <td>School Fees:</td>
                                            <td>&nbsp;&nbsp;<b>'.number_format($sch).'</b></td>
                                            <td>&nbsp;&nbsp;Other Charges:</td>
                                            <td>&nbsp;&nbsp;<b>'.number_format($othercharge).'</b></td>
                                    <tr>

                                    <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                                            <td>Subscription Fees:</td>
                                            <td>&nbsp;&nbsp;<b>'.number_format($sub).'</b></td>
                                    <tr>
                            </table><br>
                    ';
                    echo'
                            <table>
                                    <tr style="font-weight: 800; font-family: Courier New;font-size: 16px">
                                            <td>Total Deposited Amount:</td>
                                            <td>&nbsp;&nbsp;<b>'.number_format($dep).'</b></td>
                                    <tr>
                            </table><br>
                    ';
                    echo '
                    <table id="oppsd" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                        <thead>
                            <tr>
                                <th width="15%">Date Deposited</th>
                                <th width="15%">A/C</th>
                                <th width="32%">Deposit Description</th>
                                <th width="15%">Amount</th>
                                <th width="15%">A/C Bal</th>
                                <th width="18%">Handled</th>
                            </tr>
                        </thead>
                        <tbody>';
                    foreach ($db->query("SELECT * FROM mergerwd WHERE YEAR(insertiondate)='".$data[1]."' AND clientid='".$data[3]."' ".$ql." ORDER BY mergeid DESC") as $rowt){
                                            CLIENT_DATA::$clientid = $rowt['clientid'];
                                            CLIENT_DATA::CLIENTDATAMAIN();
                                            if($rowt['transactiontype']=="1"){
                                                    foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."'") as $row1){
                                                    foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
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
                                                            echo '<td width="15%" data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                                                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                                                            echo '<td width="32%">
                                                                    <b style="font-size: 12px">'.$descriptions.'</b><br>
                                                                    <b style="color: #08b44d">Deposited By: </b> '.$row1['depositor'].'
                                                                    </td>';
                                                            echo '<td width="12%">'.number_format($row1['amount']).'</td>';
                                                            echo '<td width="13%">'.number_format($row1['balance']).'</td>';
                                                            echo '<td width="20%">'.$rowuser['user_name'].'</td>';
                                                            echo '</tr>';
                                                    }
                                            }
                                    }
                echo '
                        </tbody>
                    </table>
                    ';      
            }

            if($data[0] == "3"){
                    $dep = "0"; $withd = "0";
                    $savg = "0";
                    $shrs = "0";
                    $lnrepay = "0";
                    $lnapp = "0";
                    $mmshp = "0";
                    $psbk = "0";
                    $sch = "0";
                    $othercharge = "0";
                    foreach ($db->query("SELECT * FROM mergerwd WHERE YEAR(insertiondate)='".$data[1]."' AND clientid='".$data[3]."' ".$ql." ORDER BY mergeid DESC") as $rowt){
                        if($rowt['transactiontype']=="1"){
                            foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."'") as $row1){
                                $dep = $dep + $row1['amount'];
                                $dec = explode(",",$row1['depositeditems']);
                                $fig = explode(",",$row1['depositedamts']);
                                $descriptions = "";
                                for($i = 1; $i<=count($dec); $i++){
                                    if($dec[$i]=="1"){
                                            $savg = $savg + $fig[$i];
                                    }
                                    if($dec[$i]=="2"){
                                            $shrs = $shrs + $fig[$i];
                                    }
                                    if($dec[$i]=="3"){
                                            $lnrepay = $lnrepay + $fig[$i];
                                    }
                                    if($dec[$i]=="5"){
                                            $lnapp = $lnapp + $fig[$i];
                                    }
                                    if($dec[$i]=="6"){
                                            $mmshp = $mmshp + $fig[$i];
                                    }
                                    if($dec[$i]=="7"){
                                            $psbk = $psbk + $fig[$i];
                                    }
                                    if($dec[$i]=="8"){
                                            $sch = $sch + $fig[$i];
                                    }
                                    $dataxx = explode("charges",$dec[$i]);
                                    if($dataxx[1]){
                                        foreach ($db->query('SELECT * FROM othercharges WHERE otherid="'.$dataxx[1].'"') as $row){}
                                        $othercharge = $othercharge + $fig[$i];
                                    }
                                }
                            }
                        }
                    }
                    echo'
                        <table>
                            <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                                <td>Savings:</td>
                                <td>&nbsp;&nbsp;<b>'.number_format($savg).'</b></td>
                                <td>&nbsp;&nbsp;Share Capital:</td>
                                <td>&nbsp;&nbsp;<b>'.number_format($shrs).'</b></td>
                            <tr>
                            <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                                <td>Loan Repayment:</td>
                                <td>&nbsp;&nbsp;<b>'.number_format($lnrepay).'</b></td>
                                <td>&nbsp;&nbsp;Loan Application Fees:</td>
                                <td>&nbsp;&nbsp;<b>'.number_format($lnapp).'</b></td>
                            <tr>
                            <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                                <td>Membership Fees:</td>
                                <td>&nbsp;&nbsp;<b>'.number_format($mmshp).'</b></td>
                                <td>&nbsp;&nbsp;Pass Books:</td>
                                <td>&nbsp;&nbsp;<b>'.number_format($psbk).'</b></td>
                            <tr>
                            <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                                <td>School Fees:</td>
                                <td>&nbsp;&nbsp;<b>'.number_format($sch).'</b></td>
                                <td>&nbsp;&nbsp;Other Charges:</td>
                                <td>&nbsp;&nbsp;<b>'.number_format($othercharge).'</b></td>
                            <tr>
                        </table><br>
                    ';
                    foreach ($db->query("SELECT * FROM mergerwd WHERE YEAR(insertiondate)='".$data[1]."' AND clientid='".$data[3]."' ".$ql." ORDER BY mergeid DESC") as $rowt){
                        if($rowt['transactiontype']=="2"){
                            foreach ($db->query("SELECT * FROM withdraws WHERE withdrawid='".$rowt['transactionid']."'") as $row1){
                                $withd = $withd + $row1['amount'];
                            }
                        }
                    }
                    echo'
                        <table>
                            <tr style="font-weight: 800; font-family: Courier New;font-size: 16px">
                                <td>Total Deposited Amount:</td>
                                <td>&nbsp;&nbsp;<b>'.number_format($dep).'</b></td>
                            <tr>
                            <tr style="font-weight: 800; font-family: Courier New;font-size: 16px">
                                <td>Total Withdrawn Amount:</td>
                                <td>&nbsp;&nbsp;<b>'.number_format($withd).'</b></td>
                            <tr>
                        </table><br>
                    ';
                    echo '
                        <table id="oppsd" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                            <thead>
                                <tr>
                                    <th width="15%">Date Deposited</th>
                                    <th width="15%">A/C</th>
                                    <th width="32%">Deposit Description</th>
                                    <th width="15%">Amount</th>
                                    <th width="15%">A/C Bal</th>
                                    <th width="18%">Handled</th>
                                </tr>
                            </thead>
                            <tbody>';
                foreach ($db->query("SELECT * FROM mergerwd WHERE YEAR(insertiondate)='".$data[1]."' AND clientid='".$data[3]."' ".$ql." ORDER BY mergeid DESC") as $rowt){
                                            CLIENT_DATA::$clientid = $rowt['clientid'];
                                            CLIENT_DATA::CLIENTDATAMAIN();
                                            if($rowt['transactiontype']=="1"){
                                                    foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."'") as $row1){
                                                    foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
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
                                                            echo '<td width="15%" data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                                                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                                                            echo '<td width="32%">
                                                                    <b style="font-size: 12px">'.$descriptions.'</b><br>
                                                                    <b style="color: #08b44d">Deposited By: </b> '.$row1['depositor'].'
                                                                    </td>';
                                                            echo '<td width="12%">'.number_format($row1['amount']).'</td>';
                                                            echo '<td width="13%">'.number_format($row1['balance']).'</td>';
                                                            echo '<td width="20%">'.$rowuser['user_name'].'</td>';
                                                            echo '</tr>';
                                                    }
                                            }
                                            if($rowt['transactiontype']=="2"){
                                                    foreach ($db->query("SELECT * FROM withdraws WHERE withdrawid='".$rowt['transactionid']."'") as $row1){
                                                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                                                            echo '<tr>';
                                                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                                                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                                                            echo '<td><b style="color: #b44443">Withdrawn By: </b> '.$row1['withdrawor'].'</td>';
                                                            echo '<td>'.number_format($row1['amount']).'</td>';
                                                            echo '<td>'.number_format($row1['balance']).'</td>';
                                                            echo '<td>'.$rowuser['user_name'].'</td>';
                                                            echo '</tr>';
                                                    }
                                            }
                                    }
                    echo '
                        </tbody>
                    </table>';      
            }

            if($data[0] == "4"){
                    $withd = "0";
                    foreach ($db->query("SELECT * FROM mergerwd WHERE YEAR(insertiondate)='".$data[1]."' ".$ql." ORDER BY mergeid DESC") as $rowt){

                            if($rowt['transactiontype']=="2"){
                                    foreach ($db->query("SELECT * FROM withdraws WHERE withdrawid='".$rowt['transactionid']."'") as $row1){
                                            $withd = $withd + $row1['amount'];
                                    }
                            }
                    }
                    echo'<br><br>
                            <table>
                                    <tr style="font-weight: 800; font-family: Courier New;font-size: 16px">
                                            <td>Total Withdrawn Amount:</td>
                                            <td>&nbsp;&nbsp;<b>'.number_format($withd).'</b></td>
                                    <tr>
                            </table><br>
                    ';
                    echo '
            <table id="oppsd" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr>
                        <th width="15%">Date Deposited</th>
                        <th width="15%">A/C</th>
                        <th width="32%">Deposit Description</th>
                        <th width="15%">Amount</th>
                        <th width="15%">A/C Bal</th>
                        <th width="18%">Handled</th>
                    </tr>
                </thead>
                <tbody>';
                                    foreach ($db->query("SELECT * FROM mergerwd WHERE YEAR(insertiondate)='".$data[1]."' ".$ql." ORDER BY mergeid DESC") as $rowt){
                                            CLIENT_DATA::$clientid = $rowt['clientid'];
                                            CLIENT_DATA::CLIENTDATAMAIN();

                                            if($rowt['transactiontype']=="2"){
                                                    foreach ($db->query("SELECT * FROM withdraws WHERE withdrawid='".$rowt['transactionid']."'") as $row1){
                                                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                                                            echo '<tr>';
                                                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                                                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                                                            echo '<td><b style="color: #b44443">Withdrawn By: </b> '.$row1['withdrawor'].'</td>';
                                                            echo '<td>'.number_format($row1['amount']).'</td>';
                                                            echo '<td>'.number_format($row1['balance']).'</td>';
                                                            echo '<td>'.$rowuser['user_name'].'</td>';
                                                            echo '</tr>';
                                                    }
                                            }
                                    }


                    echo '
                                    </tbody>
                            </table>
                    ';      
            }

            if($data[0] == "5"){
                    $withd = "0";
                    foreach ($db->query("SELECT * FROM mergerwd WHERE YEAR(insertiondate)='".$data[1]."' AND clientid='".$data[3]."' ".$ql." ORDER BY mergeid DESC") as $rowt){

                            if($rowt['transactiontype']=="2"){
                                    foreach ($db->query("SELECT * FROM withdraws WHERE withdrawid='".$rowt['transactionid']."'") as $row1){
                                            $withd = $withd + $row1['amount'];
                                    }
                            }
                    }
                    echo'<br><br>
                            <table>
                                    <tr style="font-weight: 800; font-family: Courier New;font-size: 16px">
                                            <td>Total Withdrawn Amount:</td>
                                            <td>&nbsp;&nbsp;<b>'.number_format($withd).'</b></td>
                                    <tr>
                            </table><br>
                    ';
                    echo '
            <table id="oppsd" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr>
                        <th width="15%">Date Deposited</th>
                        <th width="15%">Account Details</th>
                        <th width="32%">Withdraw Description</th>
                        <th width="15%">Amount</th>
                        <th width="15%">Account Balance</th>
                        <th width="18%">Handled</th>
                    </tr>
                </thead>
                <tbody>';
                                    foreach ($db->query("SELECT * FROM mergerwd WHERE YEAR(insertiondate)='".$data[1]."' AND clientid='".$data[3]."' ".$ql." ORDER BY mergeid DESC") as $rowt){
                                            CLIENT_DATA::$clientid = $rowt['clientid'];
                                            CLIENT_DATA::CLIENTDATAMAIN();

                                            if($rowt['transactiontype']=="2"){
                                                    foreach ($db->query("SELECT * FROM withdraws WHERE withdrawid='".$rowt['transactionid']."'") as $row1){
                                                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                                                            echo '<tr>';
                                                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                                                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                                                            echo '<td><b style="color: #b44443">Withdrawn By: </b> '.$row1['withdrawor'].'</td>';
                                                            echo '<td>'.number_format($row1['amount']).'</td>';
                                                            echo '<td>'.number_format($row1['balance']).'</td>';
                                                            echo '<td>'.$rowuser['user_name'].'</td>';
                                                            echo '</tr>';
                                                    }
                                            }
                                    }


                    echo '
                                    </tbody>
                            </table>
                    ';      
            }

            if($data[0] == "6"){
                    $dep = "0"; $withd = "0";
                    $savg = "0";
                    $sub = "0";
                    $shrs = "0";
                    $lnrepay = "0";
                    $lnapp = "0";
                    $mmshp = "0";
                    $psbk = "0";
                    $sch = "0";
                    $othercharge = "0";
                    foreach ($db->query("SELECT * FROM mergerwd WHERE YEAR(insertiondate)='".$data[1]."' ".$ql." ORDER BY mergeid DESC") as $rowt){

                            if($rowt['transactiontype']=="1"){
                                    foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."'") as $row1){
                                            $dep = $dep + $row1['amount'];
                                            $dec = explode(",",$row1['depositeditems']);
                                                    $fig = explode(",",$row1['depositedamts']);
                                                    $descriptions = "";
                                                    for($i = 1; $i<=count($dec); $i++){
                                                            if($dec[$i]=="1"){
                                                                    $savg = $savg + $fig[$i];
                                                            }
                                                            if($dec[$i]=="2"){
                                                                    $shrs = $shrs + $fig[$i];
                                                            }

                                                            if($dec[$i]=="3"){
                                                                    $lnrepay = $lnrepay + $fig[$i];
                                                            }

                                                            if($dec[$i]=="4"){
                                                                    $sub = $sub + $fig[$i];
                                                            }

                                                            if($dec[$i]=="5"){
                                                                    $lnapp = $lnapp + $fig[$i];
                                                            }

                                                            if($dec[$i]=="6"){
                                                                    $mmshp = $mmshp + $fig[$i];
                                                            }

                                                            if($dec[$i]=="7"){
                                                                    $psbk = $psbk + $fig[$i];
                                                            }

                                                            if($dec[$i]=="8"){
                                                                    $sch = $sch + $fig[$i];
                                                            }

                                                            $dataxx = explode("charges",$dec[$i]);
                                                            if($dataxx[1]){
                                                                    foreach ($db->query('SELECT * FROM othercharges WHERE otherid="'.$dataxx[1].'"') as $row){}
                                                                    $othercharge = $othercharge + $fig[$i];

                                                            }

                                                    }
                                    }


                            }
                    }


                    echo'
                            <table>
                                    <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                                            <td>Savings:</td>
                                            <td>&nbsp;&nbsp;<b>'.number_format($savg).'</b></td>
                                            <td>&nbsp;&nbsp;Share Capital:</td>
                                            <td>&nbsp;&nbsp;<b>'.number_format($shrs).'</b></td>
                                    <tr>
                                    <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                                            <td>Loan Repayment:</td>
                                            <td>&nbsp;&nbsp;<b>'.number_format($lnrepay).'</b></td>
                                            <td>&nbsp;&nbsp;Loan Application Fees:</td>
                                            <td>&nbsp;&nbsp;<b>'.number_format($lnapp).'</b></td>
                                    <tr>
                                    <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                                            <td>Membership Fees:</td>
                                            <td>&nbsp;&nbsp;<b>'.number_format($mmshp).'</b></td>
                                            <td>&nbsp;&nbsp;Pass Books:</td>
                                            <td>&nbsp;&nbsp;<b>'.number_format($psbk).'</b></td>
                                    <tr>
                                    <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                                            <td>School Fees:</td>
                                            <td>&nbsp;&nbsp;<b>'.number_format($sch).'</b></td>
                                            <td>&nbsp;&nbsp;Other Charges:</td>
                                            <td>&nbsp;&nbsp;<b>'.number_format($othercharge).'</b></td>
                                    <tr>

                                    <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                                            <td>Subscription Fees:</td>
                                            <td>&nbsp;&nbsp;<b>'.number_format($sub).'</b></td>
                                    <tr>
                            </table><br>
                    ';
                    foreach ($db->query("SELECT * FROM mergerwd WHERE MONTHNAME(insertiondate)='".$data[2]."' AND YEAR(insertiondate)='".$data[1]."' ORDER BY mergeid DESC") as $rowt){

                            if($rowt['transactiontype']=="2"){
                                    foreach ($db->query("SELECT * FROM withdraws WHERE withdrawid='".$rowt['transactionid']."'") as $row1){
                                            $withd = $withd + $row1['amount'];
                                    }
                            }
                    }
                    echo'
                            <table>
                                    <tr style="font-weight: 800; font-family: Courier New;font-size: 16px">
                                            <td>Total Deposited Amount:</td>
                                            <td>&nbsp;&nbsp;<b>'.number_format($dep).'</b></td>
                                    <tr>
                                    <tr style="font-weight: 800; font-family: Courier New;font-size: 16px">
                                            <td>Total Withdrawn Amount:</td>
                                            <td>&nbsp;&nbsp;<b>'.number_format($withd).'</b></td>
                                    <tr>
                            </table><br>
                    ';
                    echo '
            <table id="oppsd" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr>
                        <th width="15%">Date Deposited</th>
                        <th width="15%">A/C</th>
                        <th width="32%">Deposit Description</th>
                        <th width="15%">Amount</th>
                        <th width="15%">A/C Bal</th>
                        <th width="18%">Handled</th>
                    </tr>
                </thead>
                <tbody>';
                foreach ($db->query("SELECT * FROM mergerwd WHERE MONTHNAME(insertiondate)='".$data[2]."' AND YEAR(insertiondate)='".$data[1]."' ORDER BY mergeid DESC") as $rowt){
                                            CLIENT_DATA::$clientid = $rowt['clientid'];
                                            CLIENT_DATA::CLIENTDATAMAIN();
                                            if($rowt['transactiontype']=="1"){
                                                    foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."'") as $row1){
                                                    foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
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
                                                            echo '<td width="15%" data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                                                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                                                            echo '<td width="32%">
                                                                    <b style="font-size: 12px">'.$descriptions.'</b><br>
                                                                    <b style="color: #08b44d">Deposited By: </b> '.$row1['depositor'].'
                                                                    </td>';
                                                            echo '<td width="12%">'.number_format($row1['amount']).'</td>';
                                                            echo '<td width="13%">'.number_format($row1['balance']).'</td>';
                                                            echo '<td width="20%">'.$rowuser['user_name'].'</td>';
                                                            echo '</tr>';
                                                    }
                                            }
                                            if($rowt['transactiontype']=="2"){
                                                    foreach ($db->query("SELECT * FROM withdraws WHERE withdrawid='".$rowt['transactionid']."'") as $row1){
                                                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                                                            echo '<tr>';
                                                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                                                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                                                            echo '<td><b style="color: #b44443">Withdrawn By: </b> '.$row1['withdrawor'].'</td>';
                                                            echo '<td>'.number_format($row1['amount']).'</td>';
                                                            echo '<td>'.number_format($row1['balance']).'</td>';
                                                            echo '<td>'.$rowuser['user_name'].'</td>';
                                                            echo '</tr>';
                                                    }
                                            }
                                    }


                    echo '
                                    </tbody>
                            </table>
                    ';      
            }       

            if($data[0] == "7"){
        echo ' <br><br>
            <table cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n" id="oppsd">
                    <thead>
                        <tr class="success">
                             <th width = "40%">Account Details</th>
                             <th width = "20%">Savings</th>
                             <th width = "20%">Shares</th>
                             <th width = "20%">Loan Deposit</th>
                        </tr>
                    </thead>
                    <tbody>
            ';
            foreach ($db->query("SELECT DISTINCT(clientid) FROM deposits WHERE YEAR(inserteddate)='".$data[1]."' ".$ql1) as $rowx1){
                $sav ="0";
                $shr ="0";
                $lnz ="0";
                CLIENT_DATA::$clientid = $rowx1['clientid'];
                CLIENT_DATA::CLIENTDATAMAIN();  
                foreach ($db->query("SELECT * FROM deposits WHERE YEAR(inserteddate)='".$data[1]."' AND clientid='".$rowx1['clientid']."' ".$ql1) as $row1){
                    $dec = explode(",",$row1['depositeditems']);
                    $decamt = explode(",",$row1['depositedamts']);
                    
                    
                    
                    for($i = 1; $i<=count($dec); $i++){
                        if($dec[$i]=="1"){$sav = $decamt[$i]; }
                    }
                    // echo number_format($sav);
                    // echo'</td>';
                    // echo '<td>';
                    for($i = 1; $i<=count($dec); $i++){
                        if($dec[$i]=="2"){$shr = $decamt[$i];}
                    }   
                    // echo number_format($shr);
                    // echo'</td>';
                    // echo '<td>';
                    for($i = 1; $i<=count($dec); $i++){
                        if($dec[$i]=="3"){$lnz += $decamt[$i];}
                    }   
                    // echo number_format($lnz);
                    // echo'</td>';
                    // echo '</tr>';

                }
                echo '<tr>';
                echo '<td> ('.CLIENT_DATA::$accountno.') '.CLIENT_DATA::$accountname.'</td>';
                echo '<td>'.number_format($sav).'</td>';
                echo '<td>'.number_format($shr).'</td>';
                echo '<td>'.number_format($lnz).'</td>';
                echo '</tr>';
            }
                        
            echo '
                    </tbody>
                </table>
            ';      
        }
        
    }
    
    public static function DAYTILLSHEETREPORT(){
        $db = new DB();
        $data = explode("?::?",$_GET['dtsheetsreport']);
        $da = explode("/",$data[1]);
        $date = $da[2]."-".$da[0]."-".$da[1];
        
        if($data[0]=="1"){
            $dep = "0"; $withd = "0";
            foreach ($db->query("SELECT * FROM mergerwd WHERE DATE(insertiondate)='".$date."' ORDER BY mergeid DESC") as $rowt){
                        
                if($rowt['transactiontype']=="1"){
                    foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."'") as $row1){
                        $dep = $dep + $row1['amount'];
                    }
                }
                if($rowt['transactiontype']=="2"){
                    foreach ($db->query("SELECT * FROM withdraws WHERE withdrawid='".$rowt['transactionid']."'") as $row1){
                        $withd = $withd + $row1['amount'];
                    }
                }
            }
            echo'<br><br>
                <table>
                    <tr style="font-weight: 800; font-family: Courier New;font-size: 16px">
                        <td>Total Deposited Amount:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($dep).'</b></td>
                    <tr>
                    <tr style="font-weight: 800; font-family: Courier New;font-size: 16px">
                        <td>Total Withdrawn Amount:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($withd).'</b></td>
                    <tr>
                </table><br>
            ';
            echo '
                <table cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n" id="grn">
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
                    foreach ($db->query("SELECT SUM(camount) as camount 
                                        FROM cashiertracs 
                                        WHERE ctype='2' 
                                        AND cashier='".$_SESSION['user_id']."' 
                                        AND cdate='".NOW_DATETIME::$Date."'") as $rowass){}
                    foreach ($db->query("SELECT * FROM mergerwd WHERE DATE(insertiondate)='".$date."' ORDER BY insertiondate DESC") as $rowt){
                        if($rowt['transactiontype']=="1"){
                            foreach ($db->query("SELECT * FROM deposits 
                                                    WHERE depositid='".$rowt['transactionid']."'") as $row1){
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
                            foreach ($db->query("SELECT * FROM withdraws WHERE withdrawid='".$rowt['transactionid']."'") as $row1){
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
            </table><br';
        }
        if($data[0]=="2"){
            $dep = "0"; $withd = "0";
            foreach ($db->query("SELECT * FROM mergerwd WHERE DATE(insertiondate)='".$date."' ORDER BY mergeid DESC") as $rowt){
                        
                if($rowt['transactiontype']=="1"){
                    foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."' AND user_handle='".$_SESSION['user_id']."'") as $row1){
                        $dep = $dep + $row1['amount'];
                    }
                }
                if($rowt['transactiontype']=="2"){
                    foreach ($db->query("SELECT * FROM withdraws WHERE withdrawid='".$rowt['transactionid']."' AND user_handle='".$_SESSION['user_id']."'") as $row1){
                        $withd = $withd + $row1['amount'];
                    }
                }
            }
            echo'<br><br>
                <table>
                    <tr style="font-weight: 800; font-family: Courier New;font-size: 16px">
                        <td>Total Deposited Amount:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($dep).'</b></td>
                    <tr>
                    <tr style="font-weight: 800; font-family: Courier New;font-size: 16px">
                        <td>Total Withdrawn Amount:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($withd).'</b></td>
                    <tr>
                </table><br>
            ';
            echo '
                <table cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n" id="grn">
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
                    foreach ($db->query("SELECT SUM(camount) as camount 
                                        FROM cashiertracs 
                                        WHERE ctype='2' 
                                        AND cashier='".$_SESSION['user_id']."' 
                                        AND cdate='".NOW_DATETIME::$Date."'") as $rowass){}
                    foreach ($db->query("SELECT * FROM mergerwd WHERE DATE(insertiondate)='".$date."' ORDER BY insertiondate DESC") as $rowt){
                        if($rowt['transactiontype']=="1"){
                            foreach ($db->query("SELECT * FROM deposits 
                                                    WHERE depositid='".$rowt['transactionid']."' 
                                                    AND user_handle='".$_SESSION['user_id']."'") as $row1){
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
            </table><br';
        }
    }
    
    public static function SAVERSTATEMENT(){
        $data = explode("?::?", $_GET['saverstatementreport']);
        $db = new DB(); 
//        $ql = (($data[2]=="all")?"":" AND MONTHNAME(insertiondate) = '".$data[2]."'");
//        $ql1 = (($data[2]=="all")?"":" AND MONTHNAME(inserteddate) = '".$data[2]."'");
        
        foreach ($db->query("SELECT * FROM mergerwd WHERE YEAR(insertiondate)='".$data[1]."' AND clientid='".$data[0]."'  AND insertiondate BETWEEN '".$data[1]."' AND '".$data[2]."' ORDER BY mergeid DESC") as $rowt){
            
            if($rowt['transactiontype']=="1"){
                foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."'") as $row1){
                    $dep = $dep + $row1['amount'];
                }
            }
            if($rowt['transactiontype']=="2"){
                foreach ($db->query("SELECT * FROM withdraws WHERE withdrawid='".$rowt['transactionid']."'") as $row1){
                    $withd = $withd + $row1['amount'];
                }
            }
        }
        echo'
            <table>
                <tr style="font-weight: 800; font-family: Courier New;font-size: 16px">
                    <td>Total Deposited Amount:</td>
                    <td>&nbsp;&nbsp;<b>'.number_format($dep).'</b></td>
                <tr>
                <tr style="font-weight: 800; font-family: Courier New;font-size: 16px">
                    <td>Total Withdrawn Amount:</td>
                    <td>&nbsp;&nbsp;<b>'.number_format($withd).'</b></td>
                <tr>
            </table><br>
        ';
     
        echo '
            <table id="grat1" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr>
                        <th width="15%">Date Deposited</th>
                        <th width="15%">Account Details</th>
                        <th width="32%">Description</th>
                        <th width="15%">Deposited Amount</th>
                        <th width="15%">Account Balance</th>
                        <th width="18%">Handled</th>
                    </tr>
                </thead>
                <tbody>';
                foreach ($db->query("SELECT * FROM mergerwd WHERE  clientid='".$data[0]."' AND insertiondate BETWEEN '".$data[1]."' AND '".$data[2]."' ORDER BY mergeid ASC") as $rowt){
                    CLIENT_DATA::$clientid = $rowt['clientid'];
                    CLIENT_DATA::CLIENTDATAMAIN();
                    if($rowt['transactiontype']=="1"){
                        foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."'") as $row1){
                        foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                            $dec = explode(",",$row1['depositeditems']);
                            $fig = explode(",",$row1['depositedamts']);
                            $descriptions = "";
                            for($i = 1; $i<=count($dec); $i++){
                                if($dec[$i]=="1"){
                                    foreach ($db->query("SELECT * FROM deposit_cats WHERE depart_id='".$dec[$i]."'") as $rowd){
                                        $descriptions = $rowd['deptname'];
                                    }
                                    echo '<tr>';
                                    echo '<td width="15%" data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                                    echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                                    echo '<td width="30%">
                                        <b style="font-size: 12px">'.$descriptions.'</b><br>
                                        <b style="color: #08b44d">Deposited By: </b> '.$row1['depositor'].'
                                        </td>';
                                    echo '<td width="14%">'.number_format($fig[$i]).'</td>';
                                    echo '<td width="13%">'.number_format($row1['balance']).'</td>';
                                    echo '<td width="20%">'.$rowuser['user_name'].'</td>';
                                    echo '</tr>';
                                }
                            }
                        }
                    }
                    if($rowt['transactiontype']=="2"){
                        foreach ($db->query("SELECT * FROM withdraws WHERE withdrawid='".$rowt['transactionid']."'") as $row1){
                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                            echo '<tr>';
                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            echo '<td><b style="color: #b44443">Withdrawn By: </b> '.$row1['withdrawor'].'</td>';
                            echo '<td>'.number_format($row1['amount']).'</td>';
                            echo '<td>'.number_format($row1['balance']).'</td>';
                            echo '<td>'.$rowuser['user_name'].'</td>';
                            echo '</tr>';
                        }
                    }
                    if($rowt['transactiontype']=="3"){
                        foreach ($db->query("SELECT * FROM loan_schedules WHERE schudele_id='".$rowt['transactionid']."'") as $row1){
                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                            echo '<tr>';
                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            echo '<td><b style="color: #02a6ac;">Loan Deposit</b><b class="pull-right"> - D</b></td>';
                            echo '<td>'.number_format($row1['amount_given']).'</td>';
                            echo '<td>'.number_format($row1['balance']).'</td>';
                            echo '<td>'.$rowuser['user_name'].'</td>';
                            echo '</tr>';
                        }
                    }
                    if($rowt['transactiontype']=="4"){
                        foreach ($db->query("SELECT * FROM loan_insurance WHERE ins_id='".$rowt['transactionid']."'") as $row1){
                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                            echo '<tr>';
                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            echo '<td><b style="color: #02a6ac;">Loan Insurance Fund</b><b class="pull-right"> - W</b></td>';
                            echo '<td>'.number_format($row1['amount']).'</td>';
                            echo '<td>'.number_format($row1['balance']).'</td>';
                            echo '<td>'.$rowuser['user_name'].'</td>';
                            echo '</tr>';
                        }
                    }
                    if($rowt['transactiontype']=="5"){
                        foreach ($db->query("SELECT * FROM loan_processcharges WHERE charge_id='".$rowt['transactionid']."'") as $row1){
                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                            echo '<tr>';
                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            echo '<td><b style="color: #02a6ac;">Loan Process Fees</b><b class="pull-right"> - W</b></td>';
                            echo '<td>'.number_format($row1['amount']).'</td>';
                            echo '<td>'.number_format($row1['balance']).'</td>';
                            echo '<td>'.$rowuser['user_name'].'</td>';
                            echo '</tr>';
                        }
                    }
                    if($rowt['transactiontype']=="6"){
                        foreach ($db->query("SELECT * FROM noncashtracs WHERE nontracid='".$rowt['transactionid']."'") as $row1){
                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                            if($row1['accountcode']=="2"){$accountcodename = "Share Capital";}
                            if($row1['accountcode']=="3"){$accountcodename = "Loan Repayment";}
                            if($row1['accountcode']=="5"){$accountcodename = "Loan Application Fee";}
                            if($row1['accountcode']=="6"){$accountcodename = "MemberShip Fee";}
                            if($row1['accountcode']=="7"){$accountcodename = "Pass Book / Stationary";}
                            if($row1['accountcode']=="8"){$accountcodename = "School Fees";}
                            if($row1['accountcode']=="d"){$accountcodename = "Multiple Deposit";}
                            if($row1['accountcode']=="9"){$accountcodename = "Loan Penalty";}
                            if($row1['accountcode']=="10"){$accountcodename = "Loan Recovery";}
                            if($row1['accountcode']=="11"){$accountcodename = "Loan Interest";}
                            if($row1['accountcode']=="12"){$accountcodename = "Pass Book";}
                            if($row1['accountcode']=="13"){$accountcodename = "Ledger Book";}
                            if($row1['accountcode']=="14"){$accountcodename = "Withdraw Book";}
                            echo '<tr>';
                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            echo '<td><b style="color: #b9151b;">'.$accountcodename.'</td>';
                            echo '<td>'.number_format($row1['amount']).'</td>';
                            echo '<td>'.number_format($row1['sbal']).'</td>';
                            echo '<td>'.$rowuser['user_name'].'</td>';
                            echo '</tr>';
                        }
                    }
                    if($rowt['transactiontype']=="8"){
                        foreach ($db->query("SELECT * FROM divideneds WHERE divid='".$rowt['transactionid']."'") as $row2){
                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$row2['user_handle']."'") as $rowuser){}
                            echo '<tr>';
                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            echo '<td><b style="color: #03a9f4;">Dividend Deposit</b><b class="pull-right"> - D</b></td>';
                            echo '<td>'.number_format($row2['divamt']).'</td>';
                            echo '<td>'.number_format($row2['savbal']).'</td>';
                            echo '<td>'.$rowuser['user_name'].'</td>';
                            echo '</tr>';
                        }
                    }
                    if($rowt['transactiontype']=="9"){
                        foreach ($db->query("SELECT * FROM monthlycharges WHERE mchargeid='".$rowt['transactionid']."'") as $rowm){
                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$rowm['user_handle']."'") as $rowuser){}
                            echo '<tr>';
                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            echo '<td><b style="color: #03a9f4;">Monthly Charge</b><b class="pull-right"> - W</b></td>';
                            echo '<td>'.number_format($rowm['amount']).'</td>';
                            echo '<td>'.number_format($rowm['balance']).'</td>';
                            echo '<td>'.$rowuser['user_name'].'</td>';
                            echo '</tr>';
                        }
                    }
                }                                
        echo '
                </tbody>
            </table>
        ';
    }
    
    public static function SAVINGTRANSACTIONSREPORT(){
        $data = explode("?::?",$_GET['savingtransactionreport']);
        $db = new DB();
        $dep = "0"; $withd = "0";
        
        foreach ($db->query("SELECT * FROM mergerwd WHERE MONTHNAME(insertiondate)='".$data[1]."' AND YEAR(insertiondate)='".$data[0]."' ORDER BY mergeid DESC") as $rowt){
                    
            if($rowt['transactiontype']=="1"){
                foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."'") as $row1){
                    $dep = $dep + $row1['amount'];
                }
            }
            if($rowt['transactiontype']=="2"){
                foreach ($db->query("SELECT * FROM withdraws WHERE withdrawid='".$rowt['transactionid']."'") as $row1){
                    $withd = $withd + $row1['amount'];
                }
            }
            if($rowt['transactiontype']=="3"){
                foreach ($db->query("SELECT * FROM loan_schedules WHERE schudele_id='".$rowt['transactionid']."'") as $row1){
                    $dep = $dep + $row1['amount_given'];
                }
            }
            if($rowt['transactiontype']=="4"){
                foreach ($db->query("SELECT * FROM loan_insurance WHERE ins_id='".$rowt['transactionid']."'") as $row1){
                    $withd = $withd + $row1['amount'];
                }
            }
            if($rowt['transactiontype']=="5"){
                foreach ($db->query("SELECT * FROM loan_processcharges WHERE charge_id='".$rowt['transactionid']."'") as $row1){
                    $withd = $withd + $row1['amount'];
                }
            }
            if($rowt['transactiontype']=="6"){
                foreach ($db->query("SELECT * FROM noncashtracs WHERE nontracid='".$rowt['transactionid']."'") as $row1){
                    if($row1['accountcode']=="2"){$withd = $withd + $row1['amount'];}
                    if($row1['accountcode']=="3"){$withd = $withd + $row1['amount'];}
                    if($row1['accountcode']=="5"){$withd = $withd + $row1['amount'];}
                    if($row1['accountcode']=="6"){$withd = $withd + $row1['amount'];}
                    if($row1['accountcode']=="7"){$withd = $withd + $row1['amount'];}
                    if($row1['accountcode']=="8"){$withd = $withd + $row1['amount'];}
                    if($row1['accountcode']=="d"){$dep = $dep + $row1['amount'];}
                }
            }
            if($rowt['transactiontype']=="8"){
                foreach ($db->query("SELECT * FROM divideneds WHERE divid='".$rowt['transactionid']."'") as $row2){
                    $dep = $dep + $row2['divamt'];
                }
            }
            if($rowt['transactiontype']=="9"){
                foreach ($db->query("SELECT * FROM monthlycharges WHERE mchargeid='".$rowt['transactionid']."'") as $rowm){
                    $withd = $withd + $row1['amount'];
                }
            }
        }
        echo'<br><br>
            <table>
                <tr style="font-weight: 800; font-family: Courier New;font-size: 16px">
                    <td>Total Deposited Amount:</td>
                    <td>&nbsp;&nbsp;<b>'.number_format($dep).'</b></td>
                <tr>
                <tr style="font-weight: 800; font-family: Courier New;font-size: 16px">
                    <td>Total Withdrawn Amount:</td>
                    <td>&nbsp;&nbsp;<b>'.number_format($withd).'</b></td>
                <tr>
            </table><br>
        ';
        echo '
            <table id="grat2" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr>
                        <th width="15%">Date Deposited</th>
                        <th width="15%">A/C</th>
                        <th width="32%">Deposit Description</th>
                        <th width="15%">Amount</th>
                        <th width="15%">A/C Bal</th>
                        <th width="18%">Handled</th>
                    </tr>
                </thead>
                <tbody>';
                foreach ($db->query("SELECT * FROM mergerwd WHERE MONTHNAME(insertiondate)='".$data[1]."' AND YEAR(insertiondate)='".$data[0]."' ORDER BY mergeid DESC") as $rowt){
                    CLIENT_DATA::$clientid = $rowt['clientid'];
                    CLIENT_DATA::CLIENTDATAMAIN();
                    if($rowt['transactiontype']=="1"){
                        foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."'") as $row1){
                        foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                            $dec = explode(",",$row1['depositeditems']);
                            $fig = explode(",",$row1['depositedamts']);
                            $descriptions = "";
                            for($i = 1; $i<=count($dec); $i++){
                                if($dec[$i]=="1"){
                                    foreach ($db->query("SELECT * FROM deposit_cats WHERE depart_id='".$dec[$i]."'") as $rowd){
                                        $descriptions = $rowd['deptname'];
                                    }
                                    echo '<tr>';
                                    echo '<td width="15%" data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                                    echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                                    echo '<td width="30%">
                                        <b style="font-size: 12px">'.$descriptions.'</b><br>
                                        <b style="color: #08b44d">Deposited By: </b> '.$row1['depositor'].'
                                        </td>';
                                    echo '<td width="14%">'.number_format($fig[$i]).'</td>';
                                    echo '<td width="13%">'.number_format($row1['balance']).'</td>';
                                    echo '<td width="20%">'.$rowuser['user_name'].'</td>';
                                    echo '</tr>';
                                }
                            }
                        }
                    }
                    if($rowt['transactiontype']=="2"){
                        foreach ($db->query("SELECT * FROM withdraws WHERE withdrawid='".$rowt['transactionid']."'") as $row1){
                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                            echo '<tr>';
                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            echo '<td><b style="color: #b44443">Withdrawn By: </b> '.$row1['withdrawor'].'</td>';
                            echo '<td>'.number_format($row1['amount']).'</td>';
                            echo '<td>'.number_format($row1['balance']).'</td>';
                            echo '<td>'.$rowuser['user_name'].'</td>';
                            echo '</tr>';
                        }
                    }
                    if($rowt['transactiontype']=="3"){
                        foreach ($db->query("SELECT * FROM loan_schedules WHERE schudele_id='".$rowt['transactionid']."'") as $row1){
                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                            echo '<tr>';
                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            echo '<td><b style="color: #02a6ac;">Loan Deposit</b><b class="pull-right"> - D</b></td>';
                            echo '<td>'.number_format($row1['amount_given']).'</td>';
                            echo '<td>'.number_format($row1['balance']).'</td>';
                            echo '<td>'.$rowuser['user_name'].'</td>';
                            echo '</tr>';
                        }
                    }
                    if($rowt['transactiontype']=="4"){
                        foreach ($db->query("SELECT * FROM loan_insurance WHERE ins_id='".$rowt['transactionid']."'") as $row1){
                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                            echo '<tr>';
                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            echo '<td><b style="color: #02a6ac;">Loan Insurance Fund</b><b class="pull-right"> - W</b></td>';
                            echo '<td>'.number_format($row1['amount']).'</td>';
                            echo '<td>'.number_format($row1['balance']).'</td>';
                            echo '<td>'.$rowuser['user_name'].'</td>';
                            echo '</tr>';
                        }
                    }
                    if($rowt['transactiontype']=="5"){
                        foreach ($db->query("SELECT * FROM loan_processcharges WHERE charge_id='".$rowt['transactionid']."'") as $row1){
                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                            echo '<tr>';
                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            echo '<td><b style="color: #02a6ac;">Loan Process Fees</b><b class="pull-right"> - W</b></td>';
                            echo '<td>'.number_format($row1['amount']).'</td>';
                            echo '<td>'.number_format($row1['balance']).'</td>';
                            echo '<td>'.$rowuser['user_name'].'</td>';
                            echo '</tr>';
                        }
                    }
                    if($rowt['transactiontype']=="6"){
                        foreach ($db->query("SELECT * FROM noncashtracs WHERE nontracid='".$rowt['transactionid']."'") as $row1){
                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                            if($row1['accountcode']=="2"){$accountcodename = "Share Capital";}
                            if($row1['accountcode']=="3"){$accountcodename = "Loan Repayment";}
                            if($row1['accountcode']=="5"){$accountcodename = "Loan Application Fee";}
                            if($row1['accountcode']=="6"){$accountcodename = "MemberShip Fee";}
                            if($row1['accountcode']=="7"){$accountcodename = "Pass Book / Stationary";}
                            if($row1['accountcode']=="8"){$accountcodename = "School Fees";}
                            if($row1['accountcode']=="d"){$accountcodename = "Multiple Deposit";}
                            if($row1['accountcode']=="9"){$accountcodename = "Loan Penalty";}
                            if($row1['accountcode']=="10"){$accountcodename = "Loan Recovery";}
                            if($row1['accountcode']=="11"){$accountcodename = "Loan Interest";}
                            if($row1['accountcode']=="12"){$accountcodename = "Pass Book";}
                            if($row1['accountcode']=="13"){$accountcodename = "Ledger Book";}
                            if($row1['accountcode']=="14"){$accountcodename = "Withdraw Book";}
                            echo '<tr>';
                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            echo '<td><b style="color: #b9151b;">'.$accountcodename.'</td>';
                            echo '<td>'.number_format($row1['amount']).'</td>';
                            echo '<td>'.number_format($row1['sbal']).'</td>';
                            echo '<td>'.$rowuser['user_name'].'</td>';
                            echo '</tr>';
                        }
                    }
                    if($rowt['transactiontype']=="8"){
                        foreach ($db->query("SELECT * FROM divideneds WHERE divid='".$rowt['transactionid']."'") as $row2){
                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$row2['user_handle']."'") as $rowuser){}
                            echo '<tr>';
                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            echo '<td><b style="color: #03a9f4;">Dividend Deposit</b><b class="pull-right"> - D</b></td>';
                            echo '<td>'.number_format($row2['divamt']).'</td>';
                            echo '<td>'.number_format($row2['savbal']).'</td>';
                            echo '<td>'.$rowuser['user_name'].'</td>';
                            echo '</tr>';
                        }
                    }
                    if($rowt['transactiontype']=="9"){
                        foreach ($db->query("SELECT * FROM monthlycharges WHERE mchargeid='".$rowt['transactionid']."'") as $rowm){
                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$rowm['user_handle']."'") as $rowuser){}
                            echo '<tr>';
                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            echo '<td><b style="color: #03a9f4;">Monthly Charge</b><b class="pull-right"> - W</b></td>';
                            echo '<td>'.number_format($rowm['amount']).'</td>';
                            echo '<td>'.number_format($rowm['balance']).'</td>';
                            echo '<td>'.$rowuser['user_name'].'</td>';
                            echo '</tr>';
                        }
                    }
                }
                
                
        echo '
                </tbody>
            </table>
        ';
    }
    
    public static function PERSONAL_LEDGER(){
        $data = $_GET['personalledgerreport'];
        $db = new DB();
        
        $savg = "0";
        $sub = "0";
        $shrs = "0";
        $lnrepay = "0";
        $lnapp = "0";
        $mmshp = "0";
        $psbk = "0";
        $sch = "0";
        $othercharge = "0";
        foreach ($db->query("SELECT * FROM mergerwd WHERE clientid='".$data."' ORDER BY mergeid DESC") as $rowt){
                    
            if($rowt['transactiontype']=="1"){
                foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."'") as $row1){
                    $dep = $dep + $row1['amount'];
                    $dec = explode(",",$row1['depositeditems']);
                        $fig = explode(",",$row1['depositedamts']);
                        $descriptions = "";
                        for($i = 1; $i<=count($dec); $i++){
                            if($dec[$i]=="1"){
                                $savg = $savg + $fig[$i];
                            }
                            if($dec[$i]=="2"){
                                $shrs = $shrs + $fig[$i];
                            }
                            
                            if($dec[$i]=="3"){
                                $lnrepay = $lnrepay + $fig[$i];
                            }

                            if($dec[$i]=="4"){
                                $sub = $sub + $fig[$i];
                            }

                            if($dec[$i]=="5"){
                                $lnapp = $lnapp + $fig[$i];
                            }

                            if($dec[$i]=="6"){
                                $mmshp = $mmshp + $fig[$i];
                            }
                            
                            if($dec[$i]=="7"){
                                $psbk = $psbk + $fig[$i];
                            }
                            
                            if($dec[$i]=="8"){
                                $sch = $sch + $fig[$i];
                            }

                            $dataxx = explode("charges",$dec[$i]);
                            if($dataxx[1]){
                                foreach ($db->query('SELECT * FROM othercharges WHERE otherid="'.$dataxx[1].'"') as $row){}
                                $othercharge = $othercharge + $fig[$i];
                                
                            }

                        }
                }
                
                
            }
        }
    
        
        echo' <div class="row"><div class="col-md-5">
            <label>Cash Transactions</label><br>
            <table>
                <tr style="font-weight: 100; font-family: Courier New;font-size: 10px">
                    <td>Savings:</td>
                    <td>&nbsp;&nbsp;<b>'.number_format($savg).'</b></td>
                    <td>&nbsp;&nbsp;Share Capital:</td>
                    <td>&nbsp;&nbsp;<b>'.number_format($shrs).'</b></td>
                <tr>
                <tr style="font-weight: 100; font-family: Courier New;font-size: 10px">
                    <td>Loan Repayment:</td>
                    <td>&nbsp;&nbsp;<b>'.number_format($lnrepay).'</b></td>
                    <td>&nbsp;&nbsp;Loan Application Fees:</td>
                    <td>&nbsp;&nbsp;<b>'.number_format($lnapp).'</b></td>
                <tr>
                <tr style="font-weight: 100; font-family: Courier New;font-size: 10px">
                    <td>Membership Fees:</td>
                    <td>&nbsp;&nbsp;<b>'.number_format($mmshp).'</b></td>
                    <td>&nbsp;&nbsp;Pass Books:</td>
                    <td>&nbsp;&nbsp;<b>'.number_format($psbk).'</b></td>
                <tr>
                <tr style="font-weight: 100; font-family: Courier New;font-size: 10px">
                    <td>School Fees:</td>
                    <td>&nbsp;&nbsp;<b>'.number_format($sch).'</b></td>
                    <td>&nbsp;&nbsp;Other Charges:</td>
                    <td>&nbsp;&nbsp;<b>'.number_format($othercharge).'</b></td>
                <tr>
                
                <tr style="font-weight: 100; font-family: Courier New;font-size: 10px">
                    <td>Subscription Fees:</td>
                    <td>&nbsp;&nbsp;<b>'.number_format($sub).'</b></td>
                <tr>
            </table><br></div><div class="col-md-5">
        ';
                $lndep = "0";
        $lninsu = "0";
        $lnprcs = "0";
        $shrs1 = "0";
        $lnrepay1 = "0";
        $lnapp1 = "0";
        $mmshp1 = "0";
        $sub1 = "0";
        $psbk1 = "0";
        $sch1 = "0";
        $mmdep = "0";
        $mmchrge = "0";
        $lnwrite = "0";
        CLIENT_DATA::$clientid = $data;
        CLIENT_DATA::CLIENTDATAMAIN();
            foreach ($db->query("SELECT * FROM mergerwd WHERE clientid='".$data."' ORDER BY mergeid DESC") as $rowt){
                    if($rowt['transactiontype']=="3"){
                        foreach ($db->query("SELECT * FROM loan_schedules WHERE schudele_id='".$rowt['transactionid']."'") as $row1){
                        $lndep = $lndep + $row1['amount_given'];
                        }
                    }
                    if($rowt['transactiontype']=="4"){
                        foreach ($db->query("SELECT * FROM loan_insurance WHERE ins_id='".$rowt['transactionid']."'") as $row1){
                            $lninsu = $lninsu + $row1['amount'];
                        }
                    }
                    if($rowt['transactiontype']=="5"){
                        foreach ($db->query("SELECT * FROM loan_processcharges WHERE charge_id='".$rowt['transactionid']."'") as $row1){
                            $lnprcs = $lnprcs + $row1['amount'];
                        }
                    } 
                    if($rowt['transactiontype']=="6"){
                        foreach ($db->query("SELECT * FROM noncashtracs WHERE nontracid='".$rowt['transactionid']."'") as $row1){
                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                            if($row1['accountcode']=="2"){$shrs1 = $shr1 + $row1['amount'];}
                            if($row1['accountcode']=="3"){$lnrepay1 = $lnrepay1 + $row1['amount'];}
                            if($row1['accountcode']=="4"){$sub1 = $sub1 + $row1['amount'];}
                            if($row1['accountcode']=="5"){$lnapp1 = $lnapp1 + $row1['amount'];}
                            if($row1['accountcode']=="6"){$mmshp1 = $mmshp1 + $row1['amount'];}
                            if($row1['accountcode']=="7"){$psbk1 = $psbk1 + $row1['amount'];}
                            if($row1['accountcode']=="8"){$sch1 = $sch1 + $row1['amount'];}
                            if($row1['accountcode']=="d"){$mmdep= $mmdep + $row1['amount'];}
                        }
                    }
                    if($rowt['transactiontype']=="8"){
                        foreach ($db->query("SELECT * FROM divideneds WHERE divid='".$rowt['transactionid']."'") as $row2){
                            echo '<td>'.number_format($row2['divamt']).'</td>';
                        }
                    }
                    if($rowt['transactiontype']=="9"){
                        foreach ($db->query("SELECT * FROM monthlycharges WHERE mchargeid='".$rowt['transactionid']."'") as $rowm){
                            $mmchrge = $mmchrge + $rowm['amount'];
                        }
                    }
                    if($rowt['transactiontype']=="10"){
                        foreach ($db->query("SELECT * FROM loanwriteoff_repay WHERE reapayid='".$rowt['transactionid']."'") as $rowmtt){
                            $lnwrite = $lnwrite + $rowmtt['ramount'];
                        }
                    }
                
                }
                echo'
                <label>Non Cash Transactions</label><br>
                <table>
                    <tr style="font-weight: 100; font-family: Courier New;font-size: 10px">
                        <td>Loan Deposits:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($lndep).'</b></td>
                        <td>&nbsp;&nbsp;Loan Insurances:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($lninsu).'</b></td>
                    <tr>
                    <tr style="font-weight: 100; font-family: Courier New;font-size: 10px">
                        <td>Loan Process Fees:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($lnprcs).'</b></td>
                        <td>&nbsp;&nbsp;Share Capital:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($shrs1).'</b></td>
                    <tr>
                    <tr style="font-weight: 100; font-family: Courier New;font-size: 10px">
                        <td>Loan Repayment:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($lnrepay1).'</b></td>
                        <td>&nbsp;&nbsp;Loan Application Fees:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($lnapp1).'</b></td>
                    <tr>
                    <tr style="font-weight: 100; font-family: Courier New;font-size: 10px">
                        <td>Membership Fees:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($mmshp1).'</b></td>
                        <td>&nbsp;&nbsp;Pass Books:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($psbk1).'</b></td>
                    <tr>
                    <tr style="font-weight: 100; font-family: Courier New;font-size: 10px">
                        <td>School Fees:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($sch1).'</b></td>
                        <td>&nbsp;&nbsp;Mulitple Deposit:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($mmdep).'</b></td>
                    <tr>
                    <tr style="font-weight: 100; font-family: Courier New;font-size: 10px">
                        <td>Monthly Charges:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($mmchrge).'</b></td>
                        <td>&nbsp;&nbsp;Loan WriteOff Repay:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($lnwrite).'</b></td>
                    <tr>
                    <tr style="font-weight: 100; font-family: Courier New;font-size: 10px">
                        <td>Subscription Fees:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($sub1).'</b></td>
                    <tr>
                </table><br>
                </div>
                                    <div class="col-md-2">
                                        <center>
                                            <table>
                                                <tr>
                                                    <td>';
                                                    foreach ($db->query("SELECT * FROM clients WHERE clientid ='".$data."'") as $row){
                                                if($row['accounttype'] == "1" || $row['accounttype'] == "3"){
                                                        echo '<img src="'.((CLIENT_DATA::$photo)?"classes/upload/".CLIENT_DATA::$photo:"images/default.png").'" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:80px;height: 80px;image-orientation: from-image">';
                                                }
                                                if($row['accounttype'] == "2"){

                                                        foreach ($db->query("SELECT * FROM groupaccount WHERE acc_no='".$data."'") as $row1){
                                                                $pht .= "?::?".$row1['photofile'];
                                                        }
                                                        $pht1 = explode("?::?",$pht) ;
                                                        echo '<div class="row">';
                                                        echo '<div class="col-sm-6"><img src="'.(($pht1[1])?"classes/upload/".$pht1[1]:"images/default.png").'" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px;height: 60px;image-orientation: from-image"></div>';
                                                        echo '<div class="col-sm-6"><img src="'.(($pht1[2])?"classes/upload/".$pht1[2]:"images/default.png").'" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px;height: 60px;image-orientation: from-image"></div>';
                                                        echo '<div class="col-sm-6 col-sm-offset-3"><img src="'.(($pht1[3])?"classes/upload/".$pht1[3]:"images/default.png").'" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px;height: 60px;image-orientation: from-image"></div>';
                                                        echo '</div>';
                                                }
                                        }
                                                echo' </td>
                                                </tr>
                                                <tr>
                                                    <td><br>
                                                        <b style="font-size: 11px"><center>A/C: '.CLIENT_DATA::$accountno.'</center>'.CLIENT_DATA::$accountname.' </b>
                                                    </td>
                                                </tr>
                                            </table>
                                        </center>
                                    </div>
                </div>
            ';

        echo '
            <table id="disb"  cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr>
                        <th rowspan="2">Date</th>
                        <th>Receipt No</th>
                        <th colspan="3"><center>SHARES</center></th>
                        <th colspan="3"><center>SAVINGS</center></th>
                        <th colspan="3"><center>LOANS</center></th>
                    </tr>
                    <tr>
                        <th>Voucher No</th>
                        <th>Paid in</th>
                        <th>Paid out</th>
                        <th>Balance</th> 
                        <th>Withdraw</th>
                        <th>Deposit</th>
                        <th>Balance</th> 
                        <th>Loaned</th>
                        <th>Repaid</th>
                        <th>Balance</th>
                    </tr>
                </thead>
                <tbody>';
                foreach ($db->query("SELECT * FROM individualaccount WHERE acc_no='".$data."'") as $rowstat){
                    echo '
                        <tr>
                            <td data-order="00-00-2014:00:00:00">31-12-2017</td>
                            <td></td>
                            <td><span class="pull-right">'.number_format($rowstat['sshares']).'</span></td>
                            <td></td>
                            <td><span class="pull-right">'.number_format($rowstat['sshares']).'</span></td>
                            <td></td>
                            <td><span class="pull-right">'.number_format($rowstat['ssaving']).'</span></td>
                            <td><span class="pull-right">'.number_format($rowstat['ssaving']).'</span></td>
                            <td><span class="pull-right">'.number_format($rowstat['sloans']).'</span></td>
                            <td></td>
                            <td><span class="pull-right">'.number_format($rowstat['sloans']).'</span></td>
                        </tr>
                    ';
                }
                foreach ($db->query("SELECT * FROM mergerwd WHERE clientid='".$data."' ORDER BY insertiondate ASC, mergeid ASC") as $rowt){
                                    
                    CLIENT_DATA::$clientid = $rowt['clientid'];
                    CLIENT_DATA::CLIENTDATAMAIN();
                    if($rowt['transactiontype']=="1"){
                                            
                                            foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."'") as $row1){
                                                
                                                $dec = explode(",",$row1['depositeditems']);
                                                $fig = explode(",",$row1['depositedamts']);
                                                $descriptions = "";
                                                $share = "0";   $shbal = "0";
                                                $savg = "0";    $sbal = "0";
                                                $loan = "0";    $lbal = "0";
                                                $antdate = new DateTime($rowt['insertiondate']);
                                                echo'
                                                    <tr>
                                                        <td data-order="00-00-2014:00:00:00">'.$antdate->format('d-m-Y').'</td>
                                                        <td><center>'.$row1['rct'].'</center></td>';
                                                    for($i = 1; $i<=count($dec); $i++){
                                                        if($dec[$i]=="1"){$savg= $fig[$i];  $sbal = $row1['balance'];}
                                                        if($dec[$i]=="2"){$share= $fig[$i]; $shbal = $row1['sbal'];}
                                                        if($dec[$i]=="3"){$loan= $fig[$i];  $lbal = $row1['lnbal'];}
                                                    }
                                                    echo '
                                                        <td><span class="pull-right">'.(($share == "0" && $share == "")?:number_format($share)).'</span></td>
                                                        <td></td>
                                                        <td><span class="pull-right">'.(($shbal == "0" && $shbal == "")?:number_format($shbal)).'</span></td>
                                                        <td></td>
                                                        <td><span class="pull-right">'.(($savg == "0" && $savg == "")?:number_format($savg)).'</span></td>
                                                        <td><span class="pull-right">'.number_format($sbal).'</td>
                                                        <td></td>
                                                        <td><span class="pull-right">'.(($loan == "0" && $loan == "")?:number_format($loan)).'</span></td>
                                                        <td><span class="pull-right">'.(($lbal == "0" && $lbal == "")?:number_format($lbal)).'</span></td>
                                                    ';
                                                    $share = "0";   $shbal = "0";
                                                    $savg = "0";    $sbal = "0";
                                                    $loan = "0";    $lbal = "0";
                                                echo' </tr> ';  

                                            }
                    }
                    if($rowt['transactiontype']=="2"){
                                            foreach ($db->query("SELECT * FROM withdraws WHERE withdrawid='".$rowt['transactionid']."'") as $row1){
                        $antdate = new DateTime($rowt['insertiondate']);
                                                echo '
                                                    <tr>
                                                        <td data-order="00-00-2014:00:00:00">'.$antdate->format('d-m-Y').'</td>
                                                        <td><center>'.$row1['vct'].'</center></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><span  class="pull-right">'.number_format($row1['amount']).'</span></td>
                                                        <td></td>
                                                        <td><span  class="pull-right">'.number_format($row1['balance']).'</span></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>';
                                            }
                    }
                    if($rowt['transactiontype']=="3"){     
                                            foreach ($db->query("SELECT * FROM loan_schedules WHERE schudele_id='".$rowt['transactionid']."'") as $row1){
                                                $datet = explode(":",$rowt['insertiondate']);
                                                echo '
                                                    <tr>
                                                        <td data-order="00-00-2014:00:00:00">'.$antdate->format('d-m-Y').'</td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><span  class="pull-right">'.number_format($row1['balance']).'</span></td>
                                                        <td><span  class="pull-right">'.number_format($row1['amount_given']).'</span></td>
                                                        <td></td>
                                                        <td><span  class="pull-right">'.number_format($row1['amount_disb']).'</span></td>
                                                    </tr>';
                                            }
                    }
                                        
                                        if($rowt['transactiontype']=="6"){    
                                            foreach ($db->query("SELECT * FROM noncashtracs WHERE nontracid='".$rowt['transactionid']."'") as $row1){
                                                foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                                                if($row1['accountcode']=="2"){$accountcodename = "Share Capital";}
                                                if($row1['accountcode']=="3"){$accountcodename = "Loan Repayment";}
                                                if($row1['accountcode']=="5"){$accountcodename = "Loan Application Fee";}
                                                if($row1['accountcode']=="6"){$accountcodename = "MemberShip Fee";}
                                                if($row1['accountcode']=="7"){$accountcodename = "Pass Book / Stationary";}
                                                if($row1['accountcode']=="8"){$accountcodename = "School Fees";}
                                                if($row1['accountcode']=="d"){$accountcodename = "Multiple Deposit";}
                                                $antdate1 = new DateTime($row1['ndate']);
                                                echo '
                                                    <tr>
                                                        <td data-order="00-00-2014:00:00:00">'.$antdate1->format('d-m-Y').'</td>
                                                        <td><center>'.$row1['vct'].'</center></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td><span  class="pull-right">'.number_format($row1['amount']).'<br><span style="font-size: 10px"><b>(NC) '.$accountcodename.'</b></span></span></td>
                                                        <td></td>
                                                        <td><span  class="pull-right">'.number_format($row1['sbal']).'</span></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                    </tr>'; 
                                            }
                     }
                                        
                    // if($rowt['transactiontype']=="4"){
                        // foreach ($db->query("SELECT * FROM loan_insurance WHERE ins_id='".$rowt['transactionid']."'") as $row1){
                            // foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                            // echo '<tr>';
                            // echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            // echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            // echo '<td><b style="color: #02a6ac;">Loan Insurance Fund</td>';
                            // echo '<td>'.number_format($row1['amount']).'</td>';
                            // echo '<td>'.number_format($row1['balance']).'</td>';
                            // echo '<td>'.$rowuser['user_name'].'</td>';
                            // echo '</tr>';
                        // }
                    // }
                    // if($rowt['transactiontype']=="5"){
                        // foreach ($db->query("SELECT * FROM loan_processcharges WHERE charge_id='".$rowt['transactionid']."'") as $row1){
                            // foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                            // echo '<tr>';
                            // echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            // echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            // echo '<td><b style="color: #02a6ac;">Loan Process Fees</td>';
                            // echo '<td>'.number_format($row1['amount']).'</td>';
                            // echo '<td>'.number_format($row1['balance']).'</td>';
                            // echo '<td>'.$rowuser['user_name'].'</td>';
                            // echo '</tr>';
                        // }
                    // } 
                     
                    // if($rowt['transactiontype']=="8"){
                        // foreach ($db->query("SELECT * FROM divideneds WHERE divid='".$rowt['transactionid']."'") as $row2){
                            // foreach ($db->query("SELECT * FROM users WHERE user_id='".$row2['user_handle']."'") as $rowuser){}
                            // echo '<tr>';
                            // echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            // echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            // echo '<td><b style="color: #03a9f4;">Dividend Deposit<span class="badge badge-info pull-right">non cash transaction</span></td>';
                            // echo '<td>'.number_format($row2['divamt']).'</td>';
                            // echo '<td>'.number_format($row2['savbal']).'</td>';
                            // echo '<td>'.$rowuser['user_name'].'</td>';
                            // echo '</tr>';
                        // }
                    // }
                    // if($rowt['transactiontype']=="9"){
                        // foreach ($db->query("SELECT * FROM monthlycharges WHERE mchargeid='".$rowt['transactionid']."'") as $rowm){
                            // foreach ($db->query("SELECT * FROM users WHERE user_id='".$rowm['user_handle']."'") as $rowuser){}
                            // echo '<tr>';
                            // echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            // echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            // echo '<td><b style="color: #03a9f4;">Monthly Charge<span class="badge badge-info pull-right">non cash transaction</span></td>';
                            // echo '<td>'.number_format($rowm['amount']).'</td>';
                            // echo '<td>'.number_format($rowm['balance']).'</td>';
                            // echo '<td>'.$rowuser['user_name'].'</td>';
                            // echo '</tr>';
                        // }
                    // }
                    // if($rowt['transactiontype']=="10"){
                        // foreach ($db->query("SELECT * FROM loanwriteoff_repay WHERE reapayid='".$rowt['transactionid']."'") as $rowmtt){
                            // foreach ($db->query("SELECT * FROM users WHERE user_id='".$rowmtt['user_handle']."'") as $rowuser){}
                            // echo '<tr>';
                            // echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            // echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            // echo '<td><b style="color: #03a9f4;">Loan-WritenOff Repay</b></td>';
                            // echo '<td>'.number_format($rowmtt['ramount']).'</td>';
                            // echo '<td>'.number_format($rowmtt['sbal']).'</td>';
                            // echo '<td>'.$rowuser['user_name'].'</td>';
                            // echo '</tr>';
                        // }
                    // }
                
                }
                
                
        echo '
                </tbody>
            </table>
        ';  
    }
    
    public static function ACCOUNT_BALANCESREPORT(){
        $db = new DB(); $loop = "1"; $amt = "0"; NOW_DATETIME::NOW();
        foreach ($db->query("SELECT * FROM clients") as $rowt){$amt = $amt + $rowt['savingaccount'];}
        echo'
            <table>
                <tr style="font-weight: 800; font-family: Courier New;font-size: 13px">
                    <td>Total Saving Balances Amount:</td>
                    <td>&nbsp;&nbsp;<b>'.number_format($amt).'</b></td>
                </tr>
                <tr style="font-weight: 800; font-family: Courier New;font-size: 13px">
                    <td><b>As of '.NOW_DATETIME::$Date.'</b></td>
                </tr>
            </table><br>
        ';
        echo '
            <table id="grat1" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr>
                        <th width="5%">N0</th>
                        <th width="30%">Account Name</th>
                        <th width="30%">Account No.</th>
                        <th width="35%">Account Balance</th>
                    </tr>
                </thead>
                <tbody>';
                foreach ($db->query("SELECT * FROM clients") as $rowt){
                    CLIENT_DATA::$clientid = $rowt['clientid'];
                    CLIENT_DATA::CLIENTDATAMAIN();
                    
                    echo '<tr>';
                    echo '<td width="5%">'.$loop.'</td>';
                    echo '<td width="30%">'.CLIENT_DATA::$accountname.'</td>';
                    echo '<td width="30%">'.CLIENT_DATA::$accountno.'</td>';
                    echo '<td width="35%"><b>'.number_format(CLIENT_DATA::$savingaccount).'</b></td>';
                    echo '</tr>';
                    $loop++;
                                
                }
                    echo '
                </tbody>
            </table>
        ';
        
    }
    
    public static function NONCASH_TRASNSACTIONSREPORT(){
        $db = new DB(); $data = explode("?::?",$_GET['noncashtransactionreport']);
        $lndep = "0";
        $sub = "0";
        $lninsu = "0";
        $lnprcs = "0";
        $shrs = "0";
        $lnrepay = "0";
        $lnapp = "0";
        $mmshp = "0";
        $psbk = "0";
        $sch = "0";
        $mmdep = "0";
        $mmchrge = "0";
        $lnwrite = "0";
        $lnfines = "0";
        $lnrecover = "0";
            foreach ($db->query("SELECT * FROM mergerwd WHERE MONTHNAME(insertiondate)='".$data[1]."' AND YEAR(insertiondate)='".$data[0]."' ORDER BY mergeid DESC") as $rowt){
                    if($rowt['transactiontype']=="3"){
                        foreach ($db->query("SELECT * FROM loan_schedules WHERE schudele_id='".$rowt['transactionid']."'") as $row1){
                        $lndep = $lndep + $row1['amount_given'];
                        }
                    }
                    if($rowt['transactiontype']=="4"){
                        foreach ($db->query("SELECT * FROM loan_insurance WHERE ins_id='".$rowt['transactionid']."'") as $row1){
                            $lninsu = $lninsu + $row1['amount'];
                        }
                    }
                    if($rowt['transactiontype']=="5"){
                        foreach ($db->query("SELECT * FROM loan_processcharges WHERE charge_id='".$rowt['transactionid']."'") as $row1){
                            $lnprcs = $lnprcs + $row1['amount'];
                        }
                    } 
                    if($rowt['transactiontype']=="6"){
                        foreach ($db->query("SELECT * FROM noncashtracs WHERE nontracid='".$rowt['transactionid']."'") as $row1){
                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                            if($row1['accountcode']=="2"){$shrs = $shr + $row1['amount'];}
                            if($row1['accountcode']=="3"){$lnrepay = $lnrepay + $row1['amount'];}
                            if($row1['accountcode']=="4"){$sub = $sub + $row1['amount'];}
                            if($row1['accountcode']=="5"){$lnapp = $lnapp + $row1['amount'];}
                            if($row1['accountcode']=="6"){$mmshp = $mmshp + $row1['amount'];}
                            if($row1['accountcode']=="7"){$psbk = $psbk + $row1['amount'];}
                            if($row1['accountcode']=="8"){$sch = $sch + $row1['amount'];}
                            if($row1['accountcode']=="d"){$mmdep= $mmdep + $row1['amount'];}
                            if($row1['accountcode']=="9"){$lnfines= $lnfines + $row1['amount'];}
                        }
                    }
                    if($rowt['transactiontype']=="8"){
                        foreach ($db->query("SELECT * FROM divideneds WHERE divid='".$rowt['transactionid']."'") as $row2){
                            echo '<td>'.number_format($row2['divamt']).'</td>';
                        }
                    }
                    if($rowt['transactiontype']=="9"){
                        foreach ($db->query("SELECT * FROM monthlycharges WHERE mchargeid='".$rowt['transactionid']."'") as $rowm){
                            $mmchrge = $mmchrge + $rowm['amount'];
                        }
                    }
                    if($rowt['transactiontype']=="10"){
                        foreach ($db->query("SELECT * FROM loanwriteoff_repay WHERE reapayid='".$rowt['transactionid']."'") as $rowmtt){
                            $lnwrite = $lnwrite + $rowmtt['ramount'];
                        }
                    }
                }
            echo'
                <table>
                    <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                        <td>Loan Deposits:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($lndep).'</b></td>
                        <td>&nbsp;&nbsp;Loan Insurances:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($lninsu).'</b></td>
                    <tr>
                    <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                        <td>Loan Process Fees:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($lnprcs).'</b></td>
                        <td>&nbsp;&nbsp;Share Capital:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($shrs).'</b></td>
                    <tr>
                    <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                        <td>Loan Repayment:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($lnrepay).'</b></td>
                        <td>&nbsp;&nbsp;Loan Application Fees:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($lnapp).'</b></td>
                    <tr>
                    <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                        <td>Membership Fees:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($mmshp).'</b></td>
                        <td>&nbsp;&nbsp;Pass Books:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($psbk).'</b></td>
                    <tr>
                    <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                        <td>School Fees:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($sch).'</b></td>
                        <td>&nbsp;&nbsp;Mulitple Deposit:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($mmdep).'</b></td>
                    <tr>
                    <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                        <td>Monthly Charges:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($mmchrge).'</b></td>
                        <td>&nbsp;&nbsp;Loan WriteOff Repay:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($lnwrite).'</b></td>
                    <tr>
                    <tr style="font-weight: 100; font-family: Courier New;font-size: 12px">
                        <td>Subscription Fees:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($sub).'</b></td>
                                                <td>&nbsp;&nbsp;Loan Penalty:</td>
                        <td>&nbsp;&nbsp;<b>'.number_format($lnfines).'</b></td>
                    <tr>
                </table><br>
            ';
        echo '
            <table id="example" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr>
                        <th width="15%">Date Deposited</th>
                        <th width="20%">A/C</th>
                        <th width="30%">DW Description</th>
                        <th width="20%">Amount</th>
                        <th width="15%">Handled</th>
                    </tr>
                </thead>
                <tbody>';
                foreach ($db->query("SELECT * FROM mergerwd WHERE MONTHNAME(insertiondate)='".$data[1]."' AND YEAR(insertiondate)='".$data[0]."' ORDER BY mergeid DESC") as $rowt){
                    CLIENT_DATA::$clientid = $rowt['clientid'];
                    CLIENT_DATA::CLIENTDATAMAIN();
                    if($rowt['transactiontype']=="3"){
                        foreach ($db->query("SELECT * FROM loan_schedules WHERE schudele_id='".$rowt['transactionid']."'") as $row1){
                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                            echo '<tr>';
                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            echo '<td><b style="color: #02a6ac;">Loan Deposit</td>';
                            echo '<td>'.number_format($row1['amount_given']).'</td>';
                            echo '<td>'.$rowuser['user_name'].'</td>';
                            echo '</tr>';
                        }
                    }
                    if($rowt['transactiontype']=="4"){
                        foreach ($db->query("SELECT * FROM loan_insurance WHERE ins_id='".$rowt['transactionid']."'") as $row1){
                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                            echo '<tr>';
                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            echo '<td><b style="color: #02a6ac;">Loan Insurance Fund</td>';
                            echo '<td>'.number_format($row1['amount']).'</td>';
                            echo '<td>'.$rowuser['user_name'].'</td>';
                            echo '</tr>';
                        }
                    }
                    if($rowt['transactiontype']=="5"){
                        foreach ($db->query("SELECT * FROM loan_processcharges WHERE charge_id='".$rowt['transactionid']."'") as $row1){
                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                            echo '<tr>';
                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            echo '<td><b style="color: #02a6ac;">Loan Process Fees</td>';
                            echo '<td>'.number_format($row1['amount']).'</td>';
                            echo '<td>'.$rowuser['user_name'].'</td>';
                            echo '</tr>';
                        }
                    } 
                    if($rowt['transactiontype']=="6"){
                        foreach ($db->query("SELECT * FROM noncashtracs WHERE nontracid='".$rowt['transactionid']."'") as $row1){
                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$row1['user_handle']."'") as $rowuser){}
                            if($row1['accountcode']==="2"){$accountcodename = "Share Capital";}
                            if($row1['accountcode']==="3"){$accountcodename = "Loan Repayment";}
                            if($row1['accountcode']==="5"){$accountcodename = "Loan Application Fee";}
                            if($row1['accountcode']==="6"){$accountcodename = "MemberShip Fee";}
                            if($row1['accountcode']==="7"){$accountcodename = "Pass Book / Stationary";}
                            if($row1['accountcode']==="8"){$accountcodename = "School Fees";}
                            if($row1['accountcode']==="d"){$accountcodename = "Multiple Deposit";}
                            if($row1['accountcode']==="9"){$accountcodename = "Loan Penalty";}
                            if($row1['accountcode']==="10"){$accountcodename = "Loan Recovery";}
                            if($row1['accountcode']=="11"){$accountcodename = "Loan Interest";}
                            if($row1['accountcode']=="12"){$accountcodename = "Pass Book";}
                            if($row1['accountcode']=="13"){$accountcodename = "Ledger Book";}
                            if($row1['accountcode']=="14"){$accountcodename = "Withdraw Book";}
                            echo '<tr>';
                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            echo '<td><b style="color: #b9151b;">'.$accountcodename.'</td>';
                            echo '<td>'.number_format($row1['amount']).'</td>';
                            echo '<td>'.$rowuser['user_name'].'</td>';
                            echo '</tr>';
                        }
                    }
                    if($rowt['transactiontype']=="8"){
                        foreach ($db->query("SELECT * FROM divideneds WHERE divid='".$rowt['transactionid']."'") as $row2){
                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$row2['user_handle']."'") as $rowuser){}
                            echo '<tr>';
                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            echo '<td><b style="color: #03a9f4;">Dividend Deposit</td>';
                            echo '<td>'.number_format($row2['divamt']).'</td>';
                            echo '<td>'.$rowuser['user_name'].'</td>';
                            echo '</tr>';
                        }
                    }
                    if($rowt['transactiontype']=="9"){
                        foreach ($db->query("SELECT * FROM monthlycharges WHERE mchargeid='".$rowt['transactionid']."'") as $rowm){
                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$rowm['user_handle']."'") as $rowuser){}
                            echo '<tr>';
                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            echo '<td><b style="color: #03a9f4;">Monthly Charge</td>';
                            echo '<td>'.number_format($rowm['amount']).'</td>';
                            echo '<td>'.$rowuser['user_name'].'</td>';
                            echo '</tr>';
                        }
                    }
                    if($rowt['transactiontype']=="10"){
                        foreach ($db->query("SELECT * FROM loanwriteoff_repay WHERE reapayid='".$rowt['transactionid']."'") as $rowmtt){
                            foreach ($db->query("SELECT * FROM users WHERE user_id='".$rowmtt['user_handle']."'") as $rowuser){}
                            echo '<tr>';
                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            echo '<td width="18%">'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            echo '<td><b style="color: #03a9f4;">Loan-WritenOff Repay</b></td>';
                            echo '<td>'.number_format($rowmtt['ramount']).'</td>';
                            echo '<td>'.$rowuser['user_name'].'</td>';
                            echo '</tr>';
                        }
                    }
                
                }
                
                
        echo '
                </tbody>
            </table>
        ';
    }
    
    public static function STANDINGORDERSREPORT(){
        $db = new DB();
        $data = explode("?::?",$_GET['standingorderreport']);
        if($data[0] == "1"){
            echo '
                <table cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n" id="balncd">
                    <thead>
                        <tr class="success">
                             <th width = "10%">Date</th>
                             <th width = "15%">Order Account</th>
                             <th width = "15%">Order Date</th>
                             <th width = "55%">Order Details</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach($db->query("SELECT * FROM standingorders WHERE YEAR(indate)='".$data[1]."' AND status='0' ORDER BY orderid DESC") as $row){
                        CLIENT_DATA::$clientid = $row['orderaccount'];
                        CLIENT_DATA::CLIENTDATAMAIN();
                        $cln = explode(",",$row['clients']);
                        $cln1 = explode(",",$row['orderamount']);
                        echo '<tr>';
                        echo '<td>'.$row['indate'].'</td>';
                        echo '<td>'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                        echo '<td>'.$row['orderdate'].'</td>';
                        echo "<td>";
                            for($i = 0;$i < count($cln); $i++){
                                if($cln[$i] == ""){}else{
                                    CLIENT_DATA::$clientid = $cln[$i];
                                    CLIENT_DATA::CLIENTDATAMAIN();
                                echo ' <span style="line-height: 2.3" class="label label-primary">'.CLIENT_DATA::$accountname.' - '.number_format($cln1[$i]).'</span> ';
                                }
                                
                            }
                        echo"</td>";
                        echo '</tr>';
                    }
                    
            echo '
                    </tbody>
                </table>
            ';
        }
        if($data[0] == "2"){
            echo '
                <table cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n" id="balncd">
                    <thead>
                        <tr class="success">
                             <th width = "10%">Date</th>
                             <th width = "15%">Order Account</th>
                             <th width = "15%">Order Date</th>
                             <th width = "55%">Order Details</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach($db->query("SELECT * FROM standingorders WHERE YEAR(indate)='".$data[1]."' AND status='1' ORDER BY orderid DESC") as $row){
                        CLIENT_DATA::$clientid = $row['orderaccount'];
                        CLIENT_DATA::CLIENTDATAMAIN();
                        $cln = explode(",",$row['clients']);
                        $cln1 = explode(",",$row['orderamount']);
                        echo '<tr>';
                        echo '<td>'.$row['indate'].'</td>';
                        echo '<td>'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                        echo '<td>'.$row['orderdate'].'</td>';
                        echo "<td>";
                            for($i = 0;$i < count($cln); $i++){
                                if($cln[$i] == ""){}else{
                                    CLIENT_DATA::$clientid = $cln[$i];
                                    CLIENT_DATA::CLIENTDATAMAIN();
                                echo ' <span style="line-height: 2.3" class="label label-primary">'.CLIENT_DATA::$accountname.' - '.number_format($cln1[$i]).'</span> ';
                                }
                                
                            }
                        echo"</td>";
                        echo '</tr>';
                    }
                    
            echo '
                    </tbody>
                </table>
            ';
        }
        if($data[0] == "3"){
            echo '
                <table cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n" id="balncd">
                    <thead>
                        <tr class="success">
                             <th width = "10%">Date</th>
                             <th width = "15%">Order Account</th>
                             <th width = "15%">Order Date</th>
                             <th width = "55%">Order Details</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach($db->query("SELECT * FROM standingorders WHERE YEAR(indate)='".$data[1]."' AND status='2' ORDER BY orderid DESC") as $row){
                        CLIENT_DATA::$clientid = $row['orderaccount'];
                        CLIENT_DATA::CLIENTDATAMAIN();
                        $cln = explode(",",$row['clients']);
                        $cln1 = explode(",",$row['orderamount']);
                        echo '<tr>';
                        echo '<td>'.$row['indate'].'</td>';
                        echo '<td>'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                        echo '<td>'.$row['orderdate'].'</td>';
                        echo "<td>";
                            for($i = 0;$i < count($cln); $i++){
                                if($cln[$i] == ""){}else{
                                    CLIENT_DATA::$clientid = $cln[$i];
                                    CLIENT_DATA::CLIENTDATAMAIN();
                                echo ' <span style="line-height: 2.3" class="label label-primary">'.CLIENT_DATA::$accountname.' - '.number_format($cln1[$i]).'</span> ';
                                }
                                
                            }
                        echo"</td>";
                        echo '</tr>';
                    }
                    
            echo '
                    </tbody>
                </table>
            ';
        }       
    }  
}

class LOAN_REPORTS{
    
    public static function REPORT(){
        $db = new  DB(); $month = ""; NOW_DATETIME::NOW();
        $year = explode("?::?",$_GET["getloananalysisreport"]);
        $loan_amount = "0";
        
        echo '
            <table id="" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr>
                        <th width="10%">Months</th>
                        <th width="15%">B/F</th>
                        <th width="15%">Disbursed Loan</th>
                        <th width="15%">Interest Got</th>
                        <th width="15%">Recovered</th>
                        <th width="15%">Outstanding Balance</th>
                        <th width="15%">No. of Clients</th>
                    </tr>
                </thead>
                <tbody>';
                    $yrs =  $year['0']-"1"; 
                    $lastyrbf = "";
                    foreach($db->query("SELECT * FROM loananalysis WHERE year='".$yrs."'") as $rowx1){}
                    if($rowx1['loanbals']){
                            $lstbf = explode(",",$rowx1['loanbals']);
                            $lastyrbf = max($lstbf);
                    }
                    foreach($db->query("SELECT * FROM loananalysis WHERE year='".$year['0']."'") as $rowx){}
                    if($rowx['loanbals']!=""){$amts = explode(",",$rowx['loanbals']);}

            for($i = 1; $i <= 12; $i++){
                $noclients = "0";
                $disb = "0";
                $repay = "0";
                $intert = "0";
                $dt = DateTime::createFromFormat('!m',$i);    //   date('M',mktime(0,0,0,$i,10))
                foreach($db->query("SELECT * FROM loan_schedules s, loan_approvals a WHERE a.desc_id = s.approveid AND a.disburse!='3' AND MONTH(s.disbursed_date)='".$i."' AND YEAR(s.disbursed_date)='".$year[0]."'") as $rowoff){
                        //foreach ($db->query("SELECT * FROM loan_schedules WHERE MONTH(disbursed_date)='".$i."' AND YEAR(disbursed_date)='".$year[0]."' AND approveid='".$rowoff['desc_id']."'") as $row){
                    $noclients = $noclients + "1";
                    $disb = $disb + $rowoff['c_amt']; 
                        //}

                }
                foreach($db->query("SELECT * FROM loan_schedules s, loan_approvals a WHERE a.desc_id = s.approveid AND a.disburse!='3'") as $rowoff1){
                        $interestamt = $rowoff1['amount_disb']-$rowoff1['amount_given'];
                        foreach ($db->query("SELECT  SUM(amount) as inter FROM loan_repayment WHERE MONTH(inserted_date)='".$i."' AND YEAR(inserted_date)='".$year[0]."' AND sheduleid ='".$rowoff1['schudele_id']."'") as $rows){
                                // $intert += $interestamt
                                $intert += (($rows['inter']=="")?"0":$rows['inter']);
                                // echo $intert."<br>";
                                // $intert = $intert + $rows['interestpaid'];
                        }
                }

                foreach ($db->query("SELECT * FROM deposits WHERE MONTH(inserteddate)='".$i."' AND YEAR(inserteddate)='".$year['0']."'") as $row1){
                    $dec = explode(",",$row1['depositeditems']);
                    $fig = explode(",",$row1['depositedamts']);
                    for($j = 1; $j<=count($dec); $j++){
                        if($dec[$j]=="3"){ $repay += $fig[$j];}
                    }
                    
                }
               
                
                echo "<tr>";
                echo "<td>".$dt->format('F')."</td>";
                echo "<td><b>".(($lastyrbf != "" && $i =="1")?number_format($lastyrbf):(($amts[$i]=="0")?"":number_format($amts[$i-1])))."</b></td>";
                echo "<td><b>".(($disb=="0"||$disb=="")?"":number_format($disb))."</b></td>";
                echo "<td><b>".(($intert=="0"||$intert=="")?"":number_format($intert))."</b></td>";
                echo "<td><b>".(($repay=="0"||$repay=="")?"":number_format($repay))."</b></td>";
                echo "<td><b>".(($lastyrbf != "" && $i =="1")?number_format($disb + $lastyrbf-$repay):(($amts[$i]=="0")?"":number_format($disb+ $amts[$i-1]-$repay)))."</b></td>";
                echo "<td><b>".(($noclients=="0")?"":$noclients)."</b></td>";
                echo "</tr>";
                // echo $amts[$i-1]."  ---  ".$i."<br>";
                $noclients = "0";
                $disb = "0";
                $repay = "0";
                $intert = "0";
                
            }
       echo '
                </tbody>
            </table>';
    }
    
    public static function GCREPORT(){
        $db = new DB();  NOW_DATETIME::NOW();
        $year = (($_GET["loangcreport"])?$_GET["loangcreport"]:NOW_DATETIME::$year);
        
        $loop = "1";    
        echo '<br>
            <table id="oppsd" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr>
                        <th width="15%">Application Date</th>
                        <th width="25%">Account Details</th>
                        <th width="15%">Loan Amount</th>
                        <th width="25%">Guarantors</th>
                        <th width="25%">Collateral</th>
                    </tr>
                </thead>
                <tbody>';
                foreach ($db->query("SELECT * FROM loan_application1 s, loan_approvals a WHERE a.loan_id = s.loan_id AND YEAR(a.insertion_date)='".$year."' ORDER BY a.insertion_date DESC") as $row){
                    
                    CLIENT_DATA::$clientid = $row['grt1_id'];
                    CLIENT_DATA::CLIENTDATAMAIN();
                    $grtname1 = CLIENT_DATA::$accountname;
                    
                    CLIENT_DATA::$clientid = $row['grt2_id'];
                    CLIENT_DATA::CLIENTDATAMAIN();
                    $grtname2 = CLIENT_DATA::$accountname;
                    
                    CLIENT_DATA::$clientid = $row['member_id'];
                    CLIENT_DATA::CLIENTDATAMAIN();
                    
                    echo "<tr>";
                    echo "<td width='15%' data-order='2017-00-00'>".$row['insertion_date']."</td>";
                    echo "<td width='25%'>".CLIENT_DATA::$accountname." - ".CLIENT_DATA::$accountno."</td>";
                    echo "<td width='10%'>".number_format($row['loan_amount'])."</td>";
                    echo "<td width='30%'>".$grtname1." , <b>".$grtname2."</b></td>";
                    echo "<td width='20%'><b>".$row['collateral_assests']."</b></td>";
                    echo "</tr>";
                    $loop++;
                }
                
        echo'   </tbody>
            </table>';
    }
    
    public static function APPROVALSREPORT(){
        $db = new DB();  NOW_DATETIME::NOW();
        $year = (($_GET["approvalsreport"])?$_GET["approvalsreport"]:NOW_DATETIME::$year);
        
        $loop = "1";    $appr = "0"; $rej = "0"; $pend = "0";
        
        foreach ($db->query("SELECT * FROM loan_application1 s, loan_approvals a WHERE a.loan_id = s.loan_id AND YEAR(a.insertion_date)='".$year."' ORDER BY a.insertion_date DESC") as $rowd){
            
            $appr = $appr + (($rowd['disburse']=="1" || $rowd['disburse']=="2" || $rowd['disburse']=="3")?"1":"0");
            $rej  = $rej  + (($rowd['disburse']=="0" && $rowd['decline']=="1")?"1":"0");
            $pend = $pend + (($rowd['disburse']=="0" && $rowd['decline']=="0")?"1":"0");
        }
        echo'<br><br>
            <table>
                <tr style="font-weight: 800; font-family: Courier New;font-size: 25px">
                    <td>Total Approved:</td>
                    <td>&nbsp;&nbsp;<b>'.number_format($appr).'</b></td>
                <tr>
                <tr style="font-weight: 800; font-family: Courier New;font-size: 25px">
                    <td>Total Rejected:</td>
                    <td>&nbsp;&nbsp;<b>'.number_format($rej).'</b></td>
                <tr>
                <tr style="font-weight: 800; font-family: Courier New;font-size: 25px">
                    <td>Total Pending:</td>
                    <td>&nbsp;&nbsp;<b>'.number_format($pend).'</b></td>
                <tr>
            </table><br>
        ';
        echo '<br>
            <table id="balncd" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr>
                        <th width="25%">Application Date</th>
                        <th width="25%">Account Details</th>
                        <th width="25%">Loan Amount</th>
                        <th width="25%">Status</th>
                    </tr>
                </thead>
                <tbody>';
                foreach ($db->query("SELECT * FROM loan_application1 s, loan_approvals a WHERE a.loan_id = s.loan_id AND YEAR(a.insertion_date)='".$year."' ORDER BY a.insertion_date DESC") as $row){
                    CLIENT_DATA::$clientid = $row['member_id'];
                    CLIENT_DATA::CLIENTDATAMAIN();
                    
                    echo "<tr>";
                    echo "<td width='25%' data-order='2017-00-00'>".$row['insertion_date']."</td>";
                    echo "<td width='25%'>".CLIENT_DATA::$accountname." - ".CLIENT_DATA::$accountno."</td>";
                    echo "<td width='25%'>".number_format($row['loan_amount'])."</td>";
                    echo "<td width='25%'><b>".(($row['disburse']=="1" || $row['disburse']=="2" || $row['disburse']=="3")?"Approved":(($row['disburse']=="0" && $row['decline']=="1")?"rejected":"pending"))."</b></td>";
                    echo "</tr>";
                    $loop++;
                }
                
        echo'   </tbody>
            </table>';
    }
    
    public static function DISBURSEMENTREPORT(){
        $db = new DB();  NOW_DATETIME::NOW();
        $year = (($_GET["disbursementreport"])?$_GET["disbursementreport"]:NOW_DATETIME::$year);
        
        $loop = "1";    $amt = "0";
        
        foreach ($db->query("SELECT * FROM loan_schedules s, loan_approvals a WHERE a.desc_id = s.approveid AND YEAR(s.disbursed_date)='".$year."'") as $rowd){
            CLIENT_DATA::$clientid = $rowd['member_id'];
            CLIENT_DATA::CLIENTDATAMAIN();
            $amt = $amt + $rowd['amount_disb'];
        }
        
        echo '<br><span style="font-weight: 800; font-family: Courier New;font-size: 25px">Total Disbursement Amount: <b>'.number_format($amt).'</b></span><br><br>';       
        echo '<br>
            <table id="disb" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                            <thead>
                                <tr>
                                    <th width="2%">Disbursed Date</th>
                                    <th width="10%">Account Details</th>
                                    <th width="10%">Loan Amount</th>
                                    <th width="10%">Interest</th>
                                    <th width="10%">Period (months)</th>
                                    <th width="10%">Start Date</th>
                                    <th width="10%">End Date</th>
                                    <th width="10%">Status</th>
                                </tr>
                            </thead>
                            <tbody>';
                            foreach ($db->query("SELECT * FROM loan_schedules s, loan_approvals a WHERE a.desc_id = s.approveid AND YEAR(s.disbursed_date)='".$year."' ORDER BY s.disbursed_date DESC") as $row){
                                CLIENT_DATA::$clientid = $row['member_id'];
                                CLIENT_DATA::CLIENTDATAMAIN();
                                $data = SYS_CODES::split_on($row['reviewdate'],1);
                                $repaydate = explode(",",$data[1]);
                                echo "<tr>";
                                echo "<td width='10%' data-order='2017-00-00'>".$row['disbursed_date']."</td>";
                                echo "<td width='20%'>".CLIENT_DATA::$accountname." - ".CLIENT_DATA::$accountno."</td>";
                                echo "<td width='10%'>".number_format($row['amount_given'])."</td>";
                                echo "<td width='10%'>".number_format($row['amount_disb'] - $row['amount_given'])."</td>";
                                echo "<td width='10%'>".$row['period']."</td>";
                                echo "<td width='10%'>".min($repaydate)."</td>";
                                echo "<td width='10%'>".max($repaydate)."</td>";
                                echo "<td width='10%'><b>".(($row['loanstatus']=="1")?'<b style="color: #1b9f3f;">cleared</b>':(($row['disburse']=="3")?'<b style="color: red;">In Arrears</b>':"active"))."</b></td>";
                                echo "</tr>";
                                $loop++;
                            }
                
        echo'   </tbody>
            </table>';
    }
    
    public static function OUTSTANDINGBALANCEREPORT(){
        $db = new DB();  NOW_DATETIME::NOW();
        $year = (($_GET["outstandingbalancereport"])?$_GET["outstandingbalancereport"]:NOW_DATETIME::$year);
        
        $loop = "1";    $amt = "0";
        
        foreach ($db->query("SELECT * FROM loan_schedules s, loan_approvals a WHERE s.loanstatus='0' AND a.desc_id = s.approveid AND YEAR(s.disbursed_date)='".$year."'") as $rowd){
            CLIENT_DATA::$clientid = $rowd['member_id'];
            CLIENT_DATA::CLIENTDATAMAIN();
            if(CLIENT_DATA::$writeoffstatus == "0"){
                $amt = $amt + (($rowd['disburse'] == "3")?CLIENT_DATA::$loanaccount:($rowd['totalprinc']+$rowd['totalinterest']));
            }
        }
        
        echo '<br><span style="font-weight: 800; font-family: Courier New;font-size: 25px">Total OutStanding Balance: <b>'.number_format($amt).'</b></span><br><br>';       
        echo '<br>
                <table id="example" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr>
                            <th width="2%">No.</th>
                            <th width="10%">Name</th>
                            <th width="10%">A/C No.</th>
                            <th width="10%">Amount</th>
                            <th width="10%">Interest</th>
                            <th width="10%">Paid</th>
                            <th width="10%">Balance</th>
                        </tr>
                    </thead>
                    <tbody>';
                    foreach ($db->query("SELECT * FROM loan_schedules s, loan_approvals a WHERE s.loanstatus='0' AND a.desc_id = s.approveid AND YEAR(s.disbursed_date)='".$year."'") as $row){
                        CLIENT_DATA::$clientid = $row['member_id'];
                        CLIENT_DATA::CLIENTDATAMAIN();
                        if(CLIENT_DATA::$writeoffstatus == "0"){
                            $amt = "0";
                            foreach ($db->query("SELECT SUM(amount) as amt FROM loan_repayment WHERE sheduleid ='".$row['schudele_id']."'") as $rows){}
                            echo "<tr>";
                            echo "<td width='5%'>".$loop."</td>";
                            echo "<td width='15%'>".CLIENT_DATA::$accountname."</td>";
                            echo "<td width='10%'>".CLIENT_DATA::$accountno."</td>";
                            echo "<td width='15%'>".number_format($row['amount_given'])."</td>";
                            echo "<td width='15%'>".number_format($row['amount_disb'] - $row['amount_given'])."</td>";
                            echo "<td width='15%'>".number_format($row['amount_given']- CLIENT_DATA::$loanaccount)."</td>";
                            echo "<td width='15%'>".number_format(CLIENT_DATA::$loanaccount)."</td>";
                            echo "</tr>";
                            $loop++;
                        }
                    }
                
        echo'   </tbody>
            </table>';
    }
    
    public static function LoanAgeingReport(){
        $db = new DB();  NOW_DATETIME::NOW();
        $year = explode("?::?",$_GET["getloananalysisreport"]);
        $loop = "1";
        echo '
            <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr>
                        <th width="2%">No.</th>
                        <th width="10%">Name</th>
                        <th width="10%">A/C No.</th>
                        <th width="10%">Amount</th>
                        <th width="10%">Interest</th>
                        <th width="10%">Paid</th>
                        <th width="10%">Balance</th>
                        <th width="10%">1-30</th>
                        <th width="10%">30-90</th>
                        <th width="10%">90-180</th>
                        <th width="10%">180 ></th>
                    </tr>
                </thead>
                <tbody>';
                foreach ($db->query("SELECT * FROM loan_schedules s, loan_approvals a WHERE a.desc_id = s.approveid AND a.disburse = '1' AND YEAR(s.disbursed_date)='".$year[0]."'") as $row){
                    CLIENT_DATA::$clientid = $row['member_id'];
                    CLIENT_DATA::CLIENTDATAMAIN();
                    $data = SYS_CODES::split_on($row['reviewdate'],1);
                    $data1 = SYS_CODES::split_on($row['paycheck'],1);
                    $data2 = SYS_CODES::split_on($row['principal'],1);
                    $repaydate = explode(",",$data[1]);
                    $repaycheck = explode(",",$data1[1]);
                    $principal = explode(",",$data2[1]);
                    if($row['loanstatus']=="0"){
                        
                        for($i = 0;$i < count($repaydate); $i++){
                            if($repaydate[$i] <= NOW_DATETIME::$Date && $repaycheck[$i] ==""){
                                //$repaydate = explode(",",$data[1]);
//                                $amt += $principal[$i]; 
                                $from=date_create($repaydate[$i]);
                                $to=date_create(NOW_DATETIME::$Date);
                                $tttime = date_diff($from,$to)->format('%R%a');
                                $day1 = "";$day2 = "";$day3 = "";$day4 = "";
                                if($tttime >="1" && $tttime <= "30"){ $day1 = $tttime;$amt += $principal[$i]; }
                                if($tttime >"30" && $tttime <= "90"){ $day2 = $tttime;$amt += $principal[$i]; }
                                if($tttime >"90" && $tttime <= "180"){ $day3 = $tttime;$amt += $principal[$i]; }
                                if($tttime >"180" ){ $day4 = $tttime; $amt += $principal[$i]; }
                                break;
                            }
                        }
//                        echo CLIENT_DATA::$accountno.":  ".$day1."----<br>";
//                        echo CLIENT_DATA::$accountno.":  ".$day2."++++<br>";
//                        echo CLIENT_DATA::$accountno.":  ".$day3."@@@@<br>";CLIENT_DATA::$loanaccount
                    }else{
                        $day1 = "";$day2 = "";$day3 = "";$day4 = "";
                    }
                    
                    if(CLIENT_DATA::$writeoffstatus == "0"){
                        foreach ($db->query("SELECT SUM(amount) as amt FROM loan_repayment WHERE sheduleid ='".$row['approveid']."'") as $rows){}
                        echo "<tr>";
                        echo "<td width='0%'>".$loop."</td>";
                        echo "<td width='15%'>".CLIENT_DATA::$accountname."</td>";
                        echo "<td width='9%'>".CLIENT_DATA::$accountno."</td>";
                        echo "<td width='9%'>".number_format($row['amount_given'])."</td>";
                        echo "<td width='9%'>".number_format($row['amount_disb'] - $row['amount_given'])."</td>";
                        echo "<td width='9%'><small>Princ: <b>".number_format($rows['amt'])."</b><br> Int: <b>".number_format(($row['amount_disb'] - $row['amount_given'])- CLIENT_DATA::$interest)."</b></small></td>";
                        echo "<td width='9%'>".number_format(CLIENT_DATA::$loanaccount + CLIENT_DATA::$interest)."</td>";
                        echo "<td width='10%'>".(($day1)?number_format($amt).'<b style="font-size: 10px" class="pull-right">('.$day1.')</b>':"")."</td>";
                        echo "<td width='10%'>".(($day2)?number_format($amt).'<b style="font-size: 10px" class="pull-right">('.$day2.')</b>':"")."</td>";
                        echo "<td width='10%'>".(($day3)?number_format($amt).'<b style="font-size: 10px" class="pull-right">('.$day3.')</b>':"")."</td>";
                        echo "<td width='10%'>".(($day4)?number_format($amt).'<b style="font-size: 10px" class="pull-right">('.$day4.')</b>':"")."</td>";
                        echo "</tr>";
                        $day1 = "";$day2 = "";$day3 = "";$day4 = "";$amt = "";
                        $loop++;
                    }
                }
                
        echo'   </tbody>
            </table>';
    }

    public static function REPAYMENT_LIST(){
        $db = new  DB();    
        
        $year = explode("?::?",$_GET["getloanrepaymentreport"]);
        echo '
            <table id="grat1" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr>
                        <th width="10%">Date</th>
                        <th width="20%">Account Name</th>
                        <th width="15%">Paid Amount</th>
                        <th width="20%">Outstanding Bal</th>
                        <th width="15%">Total Interest Bal</th>
                        <th width="20%">Total Loan Bal</th>
                    </tr>
                </thead>
                <tbody>
            ';
        foreach ($db->query("SELECT * FROM loan_repayment p, loan_schedules s, loan_approvals a WHERE a.desc_id=s.approveid AND s.schudele_id=p.sheduleid AND YEAR(p.inserted_date) = '".$year[0]."'  ORDER BY p.inserted_date DESC") as $row){
            CLIENT_DATA::$clientid = $row['member_id'];
            CLIENT_DATA::CLIENTDATAMAIN();
            echo "<tr>";
            echo "<td data-order='2017-00-00'>".$row['inserted_date']."</td>";
            echo "<td>".CLIENT_DATA::$accountname."</td>";
            echo "<td><b>".number_format($row['amount'])."</b></td>";
            echo "<td>".number_format($row['loanbals'])."</td>";
            echo "<td>".number_format($row['interestbal'])."</td>";
            echo "<td><b>".number_format($row['loanbals'])."</b></td>";
            echo "</tr>";
        }
        echo '
                </tbody>
            </table>
        ';
    }
    
    public static function REPAYMENT_INDIVIDUAL(){
        $db = new  DB();    
        
        $data = explode("?::?",$_GET["getloanrepaymentreport"]);
        foreach ($db->query("SELECT * FROM loan_schedules s, loan_approvals a WHERE a.desc_id=s.approveid AND a.member_id = '".$data[2]."' ORDER BY s.disbursed_date DESC") as $rows){
            foreach ($db->query("SELECT SUM(amount) as repay FROM loan_repayment WHERE sheduleid='".$rows['schudele_id']."'") as $rowt){}
            echo '
                <table>
                    <tr style="font-size:13px">
                        <td><b>Loan Amount Given : </b></td>
                        <td>&nbsp;&nbsp;'.number_format($rows['amount_given']).'</td>
                    </tr>
                    <tr style="font-size:13px">
                        <td><b>Loan Interest : </b></td>
                        <td>&nbsp;&nbsp;'.number_format($rows['amount_disb'] - $rows['amount_given']).'</td>
                    </tr>
                    <tr style="font-size:13px">
                        <td><b>Loan Period : </b></td>
                        <td>&nbsp;&nbsp;'.$rows['period'].' Months</td>
                    </tr>
                    <tr style="font-size:13px">
                        <td><b>Amount Paid : </b></td>
                        <td>&nbsp;&nbsp;'.number_format($rowt['repay']).'</td>
                    </tr>
                    <tr style="font-size:13px">
                        <td><b>Loan Penalty : </b></td>
                        <td>&nbsp;&nbsp;'.number_format($rows['finetotal']).'</td>
                    </tr>
                </table><br>
            ';
            echo '
                <table id="grat1" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr>
                            <th width="10%">Date</th>
                            <th width="20%">Account Name</th>
                            <th width="15%">Paid Amount</th>
                            <th width="20%">Outstanding Bal</th>
                            <th width="15%">Total Interest Bal</th>
                            <th width="20%">Total Loan Bal</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
            foreach ($db->query("SELECT * FROM loan_repayment p, loan_schedules s WHERE s.approveid = '".$rows['desc_id']."' AND s.schudele_id=p.sheduleid AND YEAR(p.inserted_date) = '".$data[0]."' ORDER BY p.inserted_date DESC") as $row){
                CLIENT_DATA::$clientid = $rows['member_id'];
                CLIENT_DATA::CLIENTDATAMAIN();
                echo "<tr>";
                echo "<td data-order='2017-00-00'>".$row['inserted_date']."</td>";
                echo "<td>".CLIENT_DATA::$accountname."</td>";
                echo "<td><b>".number_format($row['amount'])."</b></td>";
                echo "<td>".number_format($row['princbal'])."</td>";
                echo "<td>".number_format($row['interestbal'])."</td>";
                echo "<td><b>".number_format($row['loanbals'])."</b></td>";
                echo "</tr>";
            }
            echo '
                    </tbody>
                </table><br><br><br>
            ';
        }
    }
    
    public static function ACTIVELOAN_PREPAYMENTS(){
        $db = new DB();     NOW_DATETIME::NOW();
        $data = explode("?::?",$_GET["getloanrepaymentreport"]);
        $loop = "1";    $amt1 = "0";
        foreach ($db->query("SELECT * FROM loan_approvals p, loan_schedules s WHERE p.disburse = '1' AND s.approveid=p.desc_id AND YEAR(s.disbursed_date) = '".$data[0]."' ORDER BY s.disbursed_date DESC") as $row){
                CLIENT_DATA::$clientid = $row['member_id'];
                CLIENT_DATA::CLIENTDATAMAIN();
                
                $data6 = SYS_CODES::split_on($row['reviewdate'],1);
                $data1 = SYS_CODES::split_on($row['paycheck'],1);
                $data2 = SYS_CODES::split_on($row['loanbal'],1);
                
                $repaydate = explode(",",$data6[1]);
                $repaycheck = explode(",",$data1[1]);
                $payments = explode(",",$data2[1]);
                
                 $spaycheck = "";
                
                for($i = 0;$i < count($repaydate); $i++ ){
                    if($repaydate[$i] > NOW_DATETIME::$Date){
                        $amt1 += $payments[$i];
                    }else{
                        $amt1 += "0";
                    }
                }
        }
        echo '<br><span style="font-weight: 800; font-family: Courier New;font-size: 28px">Total Prepayment Amount: <b>'.number_format($amt1).'</b></span><br><br>';
        echo '
                <table id="grat1" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr>
                            <th width="5%">No.</th>
                            <th width="20%">Account Name</th>
                            <th width="15%">Account No.</th>
                            <th width="15%">Disbursed Amount</th>
                            <th width="25%">Outstanding Bal</th>
                            <th width="30%">Prepayment Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
            foreach ($db->query("SELECT * FROM loan_approvals p, loan_schedules s WHERE p.disburse = '1' AND s.approveid=p.desc_id AND YEAR(s.disbursed_date) = '".$data[0]."' ORDER BY s.disbursed_date DESC") as $row){
                CLIENT_DATA::$clientid = $row['member_id'];
                CLIENT_DATA::CLIENTDATAMAIN();
                
                $data6 = SYS_CODES::split_on($row['reviewdate'],1);
                $data1 = SYS_CODES::split_on($row['paycheck'],1);
                $data2 = SYS_CODES::split_on($row['loanbal'],1);
                
                $repaydate = explode(",",$data6[1]);
                $repaycheck = explode(",",$data1[1]);
                $payments = explode(",",$data2[1]);
                
                $amt = "0"; $spaycheck = "";
                
                for($i = 0;$i < count($repaydate); $i++ ){
                    if($repaydate[$i] > NOW_DATETIME::$Date){
                        $amt += $payments[$i];
                    }else{
                        $amt += "0";
                    }
                }
                if($amt == "0"){}else{
                    echo "<tr>";
                    echo "<td>".$loop."</td>";
                    echo "<td>".CLIENT_DATA::$accountname."</td>";
                    echo "<td>".CLIENT_DATA::$accountno."</td>";
                    echo "<td>".number_format($row['amount_disb'])."</td>";
                    echo "<td>".number_format($row['totalprinc'])."</td>";
                    echo "<td><b style='color: darkred'>".number_format($amt)."</b></td>";
                    echo "</tr>";
                    $loop++;
                }
                
                
            }
            echo '
                    </tbody>
                </table><br><br><br>
            ';
    }
    
    public static function PENALITIES_CHARGED(){
        $db = new DB();     NOW_DATETIME::NOW();
        $data = explode("?::?",$_GET["getloanrepaymentreport"]);
        $loop = "1";    $amt1 = "0";
        foreach ($db->query("SELECT SUM(s.fintot) as fines FROM loan_approvals p, loan_schedules s WHERE s.fintot !='0' AND s.approveid=p.desc_id AND YEAR(s.disbursed_date) = '".$data[0]."' ORDER BY s.disbursed_date DESC") as $row){
                
            echo '<br><span style="font-weight: 800; font-family: Courier New;font-size: 25px">Total Penalty Charged Amount: <b>'.number_format($row['fines']).'</b></span><br><br>';
        }
        echo '
                <table id="grat1" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr>
                            <th width="5%">No.</th>
                            <th width="20%">Account Name</th>
                            <th width="15%">Account No.</th>
                            <th width="15%">Disbursed Amount</th>
                            <th width="25%">Outstanding Bal</th>
                            <th width="30%">Penalty Charged</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
            foreach ($db->query("SELECT * FROM loan_approvals p, loan_schedules s WHERE s.fintot !='0' AND s.approveid=p.desc_id AND YEAR(s.disbursed_date) = '".$data[0]."' ORDER BY s.disbursed_date DESC") as $row){
                CLIENT_DATA::$clientid = $row['member_id'];
                CLIENT_DATA::CLIENTDATAMAIN();
                
                $data6 = SYS_CODES::split_on($row['reviewdate'],1);
                $data1 = SYS_CODES::split_on($row['paycheck'],1);
                $data2 = SYS_CODES::split_on($row['loanbal'],1);
                
                $repaydate = explode(",",$data6[1]);
                $repaycheck = explode(",",$data1[1]);
                $payments = explode(",",$data2[1]);
                
                $amt = "0"; $spaycheck = "";
                
                echo "<tr>";
                echo "<td>".$loop."</td>";
                echo "<td>".CLIENT_DATA::$accountname."</td>";
                echo "<td>".CLIENT_DATA::$accountno."</td>";
                echo "<td>".number_format($row['amount_disb'])."</td>";
                echo "<td>".number_format($row['totalprinc'])."</td>";
                echo "<td><b style='color: darkred'>".number_format($row['fintot'])."</b></td>";
                echo "</tr>";
                $loop++;
                
                
            }
            echo '
                    </tbody>
                </table><br><br><br>
            ';
    }
    
    public static function PENALITIES_PAID(){
        $db = new DB();     NOW_DATETIME::NOW();
        $data = explode("?::?",$_GET["getloanrepaymentreport"]);
        $loop = "1";    $amt1 = "0";
        foreach ($db->query("SELECT SUM(s.fintot) as fines, SUM(s.finetotal) as tots FROM loan_approvals p, loan_schedules s WHERE s.fintot !='0' AND s.approveid=p.desc_id AND YEAR(s.disbursed_date) = '".$data[0]."' ORDER BY s.disbursed_date DESC") as $row1){     
        }
        foreach ($db->query("SELECT SUM(f.amount) as fines FROM loan_approvals p, loan_schedules s,loan_fines f WHERE s.schudele_id=f.sheduleid AND s.approveid=p.desc_id AND YEAR(s.disbursed_date) = '".$data[0]."' ORDER BY s.disbursed_date DESC") as $row2){       
        }
        echo'<br><br>
            <table>
                <tr style="font-weight: 800; font-family: Courier New;font-size: 25px">
                    <td>Total Paid Penalty Amount:</td>
                    <td>&nbsp;&nbsp;<b>'.number_format($row2['fines']).'</b></td>
                <tr>
                <tr style="font-weight: 800; font-family: Courier New;font-size: 25px">
                    <td>Total Penalty Charged Amount:</td>
                    <td>&nbsp;&nbsp;<b>'.number_format($row1['fines']).'</b></td>
                <tr>
                <tr style="font-weight: 800; font-family: Courier New;font-size: 25px">
                    <td>Outstanding Penalty Amount:</td>
                    <td>&nbsp;&nbsp;<b>'.number_format($row1['tots']).'</b></td>
                <tr>
            </table><br>
        ';
        echo '
                <table id="grat1" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr>
                            <th width="15%">Date</th>
                            <th width="15%">Account Name</th>
                            <th width="10%">Account No.</th>
                            <th width="15%">Disbursed Amount</th>
                            <th width="15%">Penalty</th>
                            <th width="15%">Paid</th>
                            <th width="15%">Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
            foreach ($db->query("SELECT * FROM loan_approvals p, loan_schedules s,loan_fines f WHERE s.schudele_id=f.sheduleid AND s.approveid=p.desc_id AND YEAR(s.disbursed_date) = '".$data[0]."' ORDER BY f.inserted_date DESC") as $row){
                CLIENT_DATA::$clientid = $row['member_id'];
                CLIENT_DATA::CLIENTDATAMAIN();
                
                $data6 = SYS_CODES::split_on($row['reviewdate'],1);
                $data1 = SYS_CODES::split_on($row['paycheck'],1);
                $data2 = SYS_CODES::split_on($row['loanbal'],1);
                
                $repaydate = explode(",",$data6[1]);
                $repaycheck = explode(",",$data1[1]);
                $payments = explode(",",$data2[1]);
                
                $amt = "0"; $spaycheck = "";
                
                echo "<tr>";
                echo "<td data-order='2017-00-00'>".$row['inserted_date']."</td>";
                echo "<td>".CLIENT_DATA::$accountname."</td>";
                echo "<td>".CLIENT_DATA::$accountno."</td>";
                echo "<td>".number_format($row['amount_disb'])."</td>";
                echo "<td>".number_format($row['fintot'])."</td>";
                echo "<td><b style='color: darkred'>".number_format($row['amount'])."</b></td>";
                echo "<td><b>".number_format($row['balance'])."</b></td>";
                echo "</tr>";
                $loop++;
                
                
            }
            echo '
                    </tbody>
                </table><br><br><br>
            ';
    }
    
    public static function FULLYPAIDLOANS(){
        $db = new  DB();
        $data = explode("?::?",$_GET["getloanrepaymentreport"]);
        foreach ($db->query("SELECT SUM(s.amount_disb) as tots FROM loan_schedules s, loan_approvals a WHERE a.desc_id=s.approveid AND a.disburse='2' AND YEAR(s.disbursed_date) = '".$data[0]."' ORDER BY s.disbursed_date DESC") as $row){
                
            echo '<br><span style="font-weight: 800; font-family: Courier New;font-size: 25px">Total Paid Loans: <b>'.number_format($row['tots']).'</b></span><br><br>';
        }       
        echo '
                <table id="grat1" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr>
                            <th width="25%">Date Disbursed</th>
                            <th width="25%">Account Name</th>
                            <th width="25%">Paid Principal</th>
                            <th width="25%">Paid Interest</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
        
        foreach ($db->query("SELECT * FROM loan_schedules s, loan_approvals a WHERE a.desc_id=s.approveid AND a.disburse='2' AND a.disburse='2' AND YEAR(s.disbursed_date) = '".$data[0]."' ORDER BY s.disbursed_date DESC") as $rows){
            
            
                CLIENT_DATA::$clientid = $rows['member_id'];
                CLIENT_DATA::CLIENTDATAMAIN();
                echo "<tr>";
                echo "<td data-order='2017-00-00'>".$rows['disbursed_date']."</td>";
                echo "<td>".CLIENT_DATA::$accountname."</td>";
                echo "<td><b>".number_format($rows['amount_given'])."</b></td>";
                echo "<td>".number_format($rows['amount_disb']-$rows['amount_given'])."</td>";
                echo "</tr>";
        }
        echo '
                    </tbody>
                </table><br><br><br>
            ';
    }
    
    public static function REAYMENTSOFWRITTENOFFLOANS(){
        $db = new  DB();
        $data = explode("?::?",$_GET["getloanrepaymentreport"]);
        foreach ($db->query("SELECT SUM(r.ramount) as tots FROM loanwriteoff s, loanwriteoff_repay r , loan_approvals a WHERE s.offid=r.offid AND a.desc_id=s.approveid  AND YEAR(r.rdate) = '".$data[0]."'") as $row){
                
            echo '<br><span style="font-weight: 800; font-family: Courier New;font-size: 25px">Total Loan-WrittenOff Repayment Amount: <b>'.number_format($row['tots']).'</b></span><br><br>';
        }       
        echo '
                <table id="grat1" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr>
                            <th width="25%">Repay Date</th>
                            <th width="25%">Account Details</th>
                            <th width="25%">Amount Paid</th>
                            <th width="25%">Balance</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
        
        foreach ($db->query("SELECT * FROM loanwriteoff s, loanwriteoff_repay r , loan_approvals a WHERE s.offid=r.offid AND a.desc_id=s.approveid  AND YEAR(r.rdate) = '".$data[0]."' ORDER BY reapayid DESC") as $rows){
            
            
                CLIENT_DATA::$clientid = $rows['member_id'];
                CLIENT_DATA::CLIENTDATAMAIN();
                echo "<tr>";
                echo "<td data-order='2017-00-00'>".$rows['rdate']." at <b>".$rows['rtime']."</b></td>";
                echo "<td>".CLIENT_DATA::$accountname." - ".CLIENT_DATA::$accountno."</td>";
                echo "<td><b>".number_format($rows['ramount'])."</b></td>";
                echo "<td>".number_format($rows['bal'])."</td>";
                echo "</tr>";
        }
        echo '
                    </tbody>
                </table><br><br><br>
            ';
    }
    
    public static function REPORTONFEESRECEIVED(){
        $db = new  DB();
        $data = explode("?::?",$_GET["getloananalysisreport"]);
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
        echo '<br><span style="font-weight: 800; font-family: Courier New;font-size: 25px">Total Fees Received: <b>'.number_format($totamt).'</b></span><br><br>';
        echo '
            <table id="grat1" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr>
                        <th width="25%">Received date</th>
                        <th width="25%">Account Details</th>
                        <th width="25%">Description</th>
                        <th width="25%">Amount</th>
                    </tr>
                </thead>
                <tbody>
        ';
        foreach ($db->query("SELECT * FROM mergerwd ORDER BY mergeid DESC") as $rowt){
                CLIENT_DATA::$clientid = $rowt['clientid'];
                CLIENT_DATA::CLIENTDATAMAIN();          
                if($rowt['transactiontype']=="1"){
                    foreach ($db->query("SELECT * FROM deposits WHERE depositid='".$rowt['transactionid']."'") as $row1){
                        $dec = explode(",",$row1['depositeditems']);
                        $fig = explode(",",$row1['depositedamts']);
                        $descriptions = "";
                        for($i = 1; $i<=count($dec); $i++){
                            if($dec[$i]=="5"){
                                foreach ($db->query("SELECT * FROM deposit_cats WHERE depart_id='".$dec[$i]."'") as $rowd){
                                    $descriptions = $rowd['deptname'];
                                }
                                echo '<tr>';
                                echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                                echo '<td>'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                                echo '<td>
                                        <b>'.$descriptions.'</b><br>
                                    </td>';
                                echo '<td>'.number_format($fig[$i]).'</td>';
                                echo '</tr>';
                            }
                            
                        }
                        
                    }
                }               
                if($rowt['transactiontype']=="4"){
                    foreach ($db->query("SELECT * FROM loan_insurance WHERE ins_id='".$rowt['transactionid']."'") as $row1){
                        echo '<tr>';
                        echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                        echo '<td>'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                        echo '<td><b style="color: #02a6ac;">Loan Insurance Fund</td>';
                        echo '<td>'.number_format($row1['amount']).'</td>';
                        echo '</tr>';
                    }
                }
                if($rowt['transactiontype']=="5"){
                        foreach ($db->query("SELECT * FROM loan_processcharges WHERE charge_id='".$rowt['transactionid']."'") as $row1){
                            echo '<tr>';
                            echo '<td data-order="2014-00-00:00:00:00">'.$rowt['insertiondate'].'</td>';
                            echo '<td>'.CLIENT_DATA::$accountname.' - '.CLIENT_DATA::$accountno.'</td>';
                            echo '<td><b style="color: #02a6ac;">Loan Process Fees</td>';
                            echo '<td>'.number_format($row1['amount']).'</td>';;
                            echo '</tr>';
                        }
                    }
                
                                
        }
        echo '
            </tbody>
        </table>
        ';
    }
    
    public static function WRITTENOFFLOANS(){
        $db = new  DB();
        $data = explode("?::?",$_GET["getloananalysisreport"]);
        foreach ($db->query("SELECT SUM(s.loan_balance) as tots FROM loanwriteoff s, loan_approvals a WHERE a.desc_id=s.approveid  AND YEAR(s.odate) = '".$data[0]."' ORDER BY offid DESC") as $row){
                
            echo '<br><span style="font-weight: 800; font-family: Courier New;font-size: 25px">Total Loan-WrittenOff Amount: <b>'.number_format($row['tots']).'</b></span><br><br>';
        }       
        echo '
                <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr>
                            <th width="30%">Write-Off Date</th>
                            <th width="30%">Account Details</th>
                            <th width="40%">Loan Amount Written-Off</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
        
        foreach ($db->query("SELECT * FROM loanwriteoff s, loan_approvals a WHERE a.desc_id=s.approveid  AND YEAR(s.odate) = '".$data[0]."' ORDER BY offid DESC") as $rows){
            
            
                CLIENT_DATA::$clientid = $rows['member_id'];
                CLIENT_DATA::CLIENTDATAMAIN();
                echo "<tr>";
                echo "<td data-order='2017-00-00'>".$rows['odate']." at <b>".$rows['otime']."</b></td>";
                echo "<td>".CLIENT_DATA::$accountname." - ".CLIENT_DATA::$accountno."</td>";
                echo "<td><b>".number_format($rows['loan_balance'])."</b></td>";
                echo "</tr>";
        }
        echo '
                    </tbody>
                </table><br><br><br>
            ';
    }   
    
    public static function TOPBORROERS_REPORT(){
        $db = new  DB();
        $data = explode("?::?",$_GET["getloananalysisreport"]);
        $amt = "0";
        foreach ($db->query("SELECT DISTINCT(a.member_id) as member_id FROM loan_schedules s, loan_approvals a WHERE a.desc_id=s.approveid  AND YEAR(s.disbursed_date) = '".$data[0]."'") as $rowd){
            foreach ($db->query("SELECT SUM(s.amount_given) as amt, COUNT(a.member_id) as nos FROM loan_schedules s, loan_approvals a WHERE a.desc_id=s.approveid  AND YEAR(s.disbursed_date) = '".$data[0]."' AND a.member_id='".$rowd['member_id']."' ORDER BY s.disbursed_date DESC") as $rows){}
            $amt = $amt + $rows['amt'];     
            
        }   
        echo '<br><span style="font-weight: 800; font-family: Courier New;font-size: 25px">Total Loan Amount: <b>'.number_format($amt).'</b></span><br><br>';       
        echo '
                <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr>
                            <th width="30%">Account Details</th>
                            <th width="30%">Amount Borrowed</th>
                            <th width="30%">No of Times</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
        
        foreach ($db->query("SELECT DISTINCT(a.member_id) as member_id FROM loan_schedules s, loan_approvals a WHERE a.desc_id=s.approveid  AND YEAR(s.disbursed_date) = '".$data[0]."'") as $rowd){
            foreach ($db->query("SELECT SUM(s.amount_given) as amt, COUNT(a.member_id) as nos FROM loan_schedules s, loan_approvals a WHERE a.desc_id=s.approveid  AND YEAR(s.disbursed_date) = '".$data[0]."' AND a.member_id='".$rowd['member_id']."'") as $rows){}
            
                CLIENT_DATA::$clientid = $rowd['member_id'];
                CLIENT_DATA::CLIENTDATAMAIN();
                echo "<tr>";
                echo "<td>".CLIENT_DATA::$accountname." - ".CLIENT_DATA::$accountno."</b></td>";
                echo "<td>".number_format($rows['amt'])."</td>";
                echo "<td><b>".$rows['nos']."</b></td>";
                echo "</tr>";
        }
        echo '
                    </tbody>
                </table><br><br><br>
            ';
    }
    
    public static function ARREARSREPORT(){
        $db = new  DB();
        $data = explode("?::?",$_GET["getloananalysisreport"]);
        $amt = "0";
        foreach ($db->query("SELECT * FROM loan_schedules s, loan_approvals a WHERE a.desc_id = s.approveid AND s.loanstatus='0' AND YEAR(s.disbursed_date) = '".$data[0]."'") as $row){
            
            CLIENT_DATA::$clientid = $row['member_id'];
            CLIENT_DATA::CLIENTDATAMAIN();
            if(CLIENT_DATA::$writeoffstatus == "0"){
                $data3 = SYS_CODES::split_on($row['reviewdate'],1);
                $data1 = SYS_CODES::split_on($row['paycheck'],1);
                $data2 = SYS_CODES::split_on($row['loanbal'],1);
                $paycheck = explode(",", $data1[1]);
                $paydate = explode(",", $data3[1]);
                $payamt = explode(",", $data2[1]);
                for($i = 0;$i < count($paycheck); $i++){
                    if($paycheck[$i] ==""){
                        $payday = $paydate[$i];
                        break;
                    }
                }
                $lnbal = 0;
                for($i = 0;$i < count($paycheck); $i++){
                    if($paycheck[$i] ==""){
                        $from=date_create($paydate[$i]); $to=date_create(NOW_DATETIME::$Date);
                        if($from > $to){break;}else{
                            $lnbal += $payamt[$i];
                        }
                    }
                }

                $from=date_create($payday);//max($repaydate)
                $to=date_create(NOW_DATETIME::$Date);
                $tttime = date_diff($from,$to)->format('%R%a');
                $day1 = "";$day2 = "";$day3 = "";$day4 = "";
                if($tttime >= "1"){ 
                    $amt = $amt + (($row['disburse'] == "3")?CLIENT_DATA::$loanaccount:($lnbal));
//                    $amt = $amt + (($row['disburse'] == "3")?CLIENT_DATA::$loanaccount:($row['totalprinc']+$row['totalinterest']));
                }   
            }
                
        }   
        echo '<br><span style="font-weight: 800; font-family: Courier New;font-size: 25px">Total Amount in Arrears: <b>'.number_format($amt).'</b></span><br><br>';     
        echo '
                <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr>
                            <th width="30%">Account Details</th>
                            <th width="30%">Loan Balance</th>
                            <th width="30%">Arrears Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
        
        foreach ($db->query("SELECT * FROM loan_schedules s, loan_approvals a WHERE a.desc_id = s.approveid AND s.loanstatus='0' AND YEAR(s.disbursed_date) = '".$data[0]."'") as $rowd){
            CLIENT_DATA::$clientid = $rowd['member_id'];
            CLIENT_DATA::CLIENTDATAMAIN();
            if(CLIENT_DATA::$writeoffstatus == "0"){
                $data = SYS_CODES::split_on($rowd['reviewdate'],1);
                $data1 = SYS_CODES::split_on($rowd['paycheck'],1);
                $data2 = SYS_CODES::split_on($rowd['loanbal'],1);
                $paycheck = explode(",", $data1[1]);
                $paydate = explode(",", $data[1]);
                $payamt = explode(",", $data2[1]);
                for($i = 0;$i < count($paycheck); $i++){
                    if($paycheck[$i] ==""){
                        $payday = $paydate[$i];
                        break;
                    }
                }
                $lnbal = 0;
                for($i = 0;$i < count($paycheck); $i++){
                    if($paycheck[$i] ==""){
                        $from=date_create($paydate[$i]); $to=date_create(NOW_DATETIME::$Date);
                        if($from > $to){break;}else{
                            $lnbal += $payamt[$i];
                        }
                    }
                }

                $repaydate = explode(",",$data[1]);
                $from=date_create($payday);//max($repaydate)
                $to=date_create(NOW_DATETIME::$Date);
                $tttime = date_diff($from,$to)->format('%R%a');
                $day1 = "";$day2 = "";$day3 = "";$day4 = "";
                if($tttime >= "1"){ 
                    echo "<tr>";
                    echo "<td>".CLIENT_DATA::$accountname." - ".CLIENT_DATA::$accountno."</b></td>";
//                    echo "<td>".(($rowd['disburse'] == "3")?number_format(CLIENT_DATA::$loanaccount):number_format($rowd['totalprinc']+$rowd['totalinterest']))."<br>".$lnbal."</td>";
                    echo "<td>".(($rowd['disburse'] == "3")?number_format(CLIENT_DATA::$loanaccount):number_format($lnbal))."<br></td>";
                    echo "<td><b style='font-size: 10px'>from</b>&nbsp;&nbsp;".$payday."<b style='font-size: 10px' class='pull-right'>(".$tttime.")</b></td>";
                    echo "</tr>";
                }  
            }   
        }
        echo '
                    </tbody>
                </table><br><br><br>
            ';
    }
    
    public static function PORTFOLIOATRISK(){
        $db = new  DB();
        $data = explode("?::?",$_GET["getloananalysisreport"]);
        $amt = "0";
        foreach ($db->query("SELECT * FROM loan_schedules s, loan_approvals a WHERE a.desc_id = s.approveid AND s.loanstatus='0' AND YEAR(s.disbursed_date) = '".$data[0]."'") as $row){
            
            CLIENT_DATA::$clientid = $row['member_id'];
            CLIENT_DATA::CLIENTDATAMAIN();
            if(CLIENT_DATA::$writeoffstatus == "0"){
                 $data3 = SYS_CODES::split_on($row['reviewdate'],1);
                $data1 = SYS_CODES::split_on($row['paycheck'],1);
                $data2 = SYS_CODES::split_on($row['loanbal'],1);
                $paycheck = explode(",", $data1[1]);
                $paydate = explode(",", $data3[1]);
                $payamt = explode(",", $data2[1]);
                for($i = 0;$i < count($paycheck); $i++){
                    if($paycheck[$i] ==""){
                        $payday = $paydate[$i];
                        break;
                    }
                }
                $lnbal = 0;
                for($i = 0;$i < count($paycheck); $i++){
                    if($paycheck[$i] ==""){
                        $from=date_create($paydate[$i]); $to=date_create(NOW_DATETIME::$Date);
                        if($from > $to){break;}else{
                            $lnbal += $payamt[$i];
                        }
                    }
                }

                $from=date_create($payday);//max($repaydate)
                $to=date_create(NOW_DATETIME::$Date);
                $tttime1 = date_diff($from,$to)->format('%R%a');
                $day1 = "";$day2 = "";$day3 = "";$day4 = "";
                
                if($tttime1 >="30"){ 
                    $amt = $amt + (($row['disburse'] == "3")?CLIENT_DATA::$loanaccount:($lnbal));
                }
            }           
                
        }   
        echo '<br><span style="font-weight: 800; font-family: Courier New;font-size: 25px">Total Portfolio at Rist: <b>'.number_format($amt).'</b></span><br><br>';     
        echo '
                <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr>
                            <th width="30%">Account Details</th>
                            <th width="30%">Loan Balance</th>
                            <th width="30%">Arrears[Ageing] Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                ';
        
        foreach ($db->query("SELECT * FROM loan_schedules s, loan_approvals a WHERE a.desc_id = s.approveid AND s.loanstatus='0' AND YEAR(s.disbursed_date) = '".$data[0]."'") as $rowd){
            
                CLIENT_DATA::$clientid = $rowd['member_id'];
                CLIENT_DATA::CLIENTDATAMAIN();
                
                if(CLIENT_DATA::$writeoffstatus == "0"){
                    $repaydate = explode(",",$data[1]);
                    $data = SYS_CODES::split_on($rowd['reviewdate'],1);
                    $data1 = SYS_CODES::split_on($rowd['paycheck'],1);
                    $data2 = SYS_CODES::split_on($rowd['loanbal'],1);
                    $paycheck = explode(",", $data1[1]);
                    $paydate = explode(",", $data[1]);
                    $payamt = explode(",", $data2[1]);
                    for($i = 0;$i < count($paycheck); $i++){
                        if($paycheck[$i] ==""){
                            $payday = $paydate[$i];
                            break;
                        }
                    }
                    $lnbal = 0;
                    for($i = 0;$i < count($paycheck); $i++){
                        if($paycheck[$i] ==""){
                            $from=date_create($paydate[$i]); $to=date_create(NOW_DATETIME::$Date);
                            if($from > $to){break;}else{
                                $lnbal += $payamt[$i];
                            }
                        }
                    }

                    $repaydate = explode(",",$data[1]);
                    $from=date_create($payday);//max($repaydate)
                    $to=date_create(NOW_DATETIME::$Date);
                    $tttime = date_diff($from,$to)->format('%R%a');
                    $day1 = "";$day2 = "";$day3 = "";$day4 = "";
                    if($tttime >="30"){ 
                        echo "<tr>";
                        echo "<td>".CLIENT_DATA::$accountname." - ".CLIENT_DATA::$accountno."</b></td>";
                        echo "<td>".(($rowd['disburse'] == "3")?number_format(CLIENT_DATA::$loanaccount):number_format($lnbal))."</td>";
                        echo "<td><b style='font-size: 10px'>from</b>&nbsp;&nbsp;".$payday."<b style='font-size: 10px' class='pull-right'>(".$tttime.")</b></td>";
                        echo "</tr>";
                    }   
                                
                }   
                
        }
        echo '
                    </tbody>
                </table><br><br><br>
            ';
    }
    
    public static function DUESREPORT(){
        $db = new DB(); $amt="0"; $loop =  1;   NOW_DATETIME::NOW();
        foreach ($db->query("SELECT * FROM loan_approvals p,loan_schedules s WHERE s.approveid=p.desc_id AND s.loanstatus ='0' AND p.disburse='1' ORDER BY s.disbursed_date DESC") as $row){
            foreach ($db->query("SELECT * FROM clients WHERE clientid='".$row['member_id']."'") as $rowclient) {
                $data = SYS_CODES::split_on($row['reviewdate'],1);
                $data1 = SYS_CODES::split_on($row['paycheck'],1);
                $data2 = SYS_CODES::split_on($row['total'],1);
                $data3 = SYS_CODES::split_on($row['loanbal'],1);
                $repaydate = explode(",",$data[1]);
                $repaycheck = explode(",",$data1[1]);
                $repayamt = explode(",",$data2[1]);
                $repayamt1 = explode(",",$data3[1]);
                $datas = "";    $datas1 = "";
                $endperiod = (($_GET['loanduesreport'])?$_GET['loanduesreport']:"7");
                for($i = 0;$i < count($repaydate); $i++ ){
                    
                    $from=date_create(NOW_DATETIME::$Date);
                    $to=date_create($repaydate[$i]);
                    $tttime = date_diff($from,$to)->format('%R%a');
                    
                    if($tttime >= "0" && $tttime <= $endperiod){
                        $actamt = $repayamt[$i] - $repayamt1[$i];
                        $amt = $amt + $actamt;
                    }
                }
            }
        }
        echo '<br><span style="font-weight: 800; font-family: Courier New;font-size: 25px">Total Period Loan Dues Amount: <b>'.number_format($amt).'</b></span><br><br>';       
        echo '<br><br>
            <table id="grat2" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                            <thead>
                                <tr>
                                    <th width="25%">Due Date</th>
                                    <th width="25%">Account Name</th>
                                    <th width="25%">Amount to be Paid</th>
                                    <th width="25%">No of Days to Due</th>
                                </tr>
                            </thead>
                        <tbody>
        ';
        foreach ($db->query("SELECT * FROM loan_approvals p,loan_schedules s WHERE s.approveid=p.desc_id AND s.loanstatus ='0' AND p.disburse='1' ORDER BY s.disbursed_date DESC") as $row){
            foreach ($db->query("SELECT * FROM clients WHERE clientid='".$row['member_id']."'") as $rowclient) {
                $data = SYS_CODES::split_on($row['reviewdate'],1);
                $data1 = SYS_CODES::split_on($row['paycheck'],1);
                $data2 = SYS_CODES::split_on($row['total'],1);
                $data3 = SYS_CODES::split_on($row['loanbal'],1);
                $repaydate = explode(",",$data[1]);
                $repaycheck = explode(",",$data1[1]);
                $repayamt = explode(",",$data2[1]);
                $repayamt1 = explode(",",$data3[1]);
                $datas = "";    $datas1 = "";
                $endperiod = (($_GET['loanduesreport'])?$_GET['loanduesreport']:"7");
                for($i = 0;$i < count($repaydate); $i++ ){
                    
                    $from=date_create(NOW_DATETIME::$Date);
                    $to=date_create($repaydate[$i]);
                    $tttime = date_diff($from,$to)->format('%R%a');
                    
                    if($tttime >= "0" && $tttime <= $endperiod){
                        $actamt = $repayamt[$i] - $repayamt1[$i];
                        if($actamt == "0"){}else{
                            echo '<tr>';
                            echo '<td width="25%" data-order="2017-00-00">'.$repaydate[$i] . '</td>';
                            echo '<td width="25%"><b> ' .$rowclient['accountname']. ' - '.$rowclient['accountno'].' </b></td>';
                            echo '<td width="25%"><b style="font-size: 18px;color: #1b9f3f;font-weight: 900">'.number_format($actamt) . '</b></td>';
                            echo '<td width="25%"><b> ' .($tttime * 1). ' </b></td>';
                            echo '</tr>';
                        }
                    }
                }
             
                $loop++;
            }
        }
        echo '
                            </tbody>
            </table>    
        ';
    }
}
