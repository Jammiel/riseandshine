<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Loans
 *
 * @author ucatch
 */
class LOAN_PROCESSCLASS extends database_crud {
    protected $table="loan_application1";
    protected $pk="loan_id";

    //  SELECT `loan_id`, `member_id`, `ln_serial`, `marital_status`, `sub_county`, `district`, `age`, `gender`,
    // `lvl_education`, `type_of_business`, `loan_amount`, `amount_in_word`, `int_purpose`, `source_ofpayment`,
    // `duration`, `repayment_schedule`, `type_of_loan`, `no_of_shares`, `assests_owned`, `collateral_assests`,
    // `debts`, `purpose_of_previous`, `net_worth`, `ability_to_pay`, `kin_name`, `kin_contact`, `lc_name`, `lc_contact`,
    // `lc_address`, `grt1_id`, `grt2_id`, `grat1_residence`, `grat2_residence`, `grt1_name`, `grt2_name`,
    // `status_tag` FROM `loan_application1` WHERE 1

    public static function GET_CLIENTLOAN_APPLICATION(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM post_chart WHERE loan_tag!='3' ORDER BY inserteddate DESC") as $row1){
            $dec = explode(",",$row1['depositeditems']);
            for($i = 1; $i<=count($dec); $i++){
                if($dec[$i] == "5"){
                    foreach ($db->query("SELECT * FROM clients WHERE clientid='".$row1['clientid']."'")as $row){
                        echo '<tr>';
                        echo '<td data-order="2017-00-00"> '. $row1['inserteddate'].'</td>';
                        echo '<td><b> '. $row['accountname'].' </b></td>';
                        echo '<td> '. (($row1['loan_tag']== "0")?"<span style='color: #b60b1a'>no records</span>":(($row1['loan_tag']== "1")?"<span style='color: #3884ac'><i class='fa fa-check'></i>Application Available</span> , <b style='color: #abac15'> Appraisal pending...</b>":(($row1['loan_tag']== "2")?"<b style='color: #26ac51'> Forward for Approval...</b>":""))).'</td>';
                        echo '<td>
                                <center>
                                  <button onclick="getloanapplicationdata('.$row1['chartid'].')" class="btn btn-social btn-info btn-sm" data-target="#addloanappdetails" data-toggle="modal" data-placement="top" title="Add Loan Application Details" type="button"><i class="fa fa-plus"><i class="fa fa-book"></i></i></button>
                                  <button onclick="getloanappraisaldata('.$row1['chartid'].')" '.(($row1["loan_tag"]=="0")?"disabled":"").' class="btn '.(($row1["loan_tag"]=="0")?"btn-social btn-apple":"btn-social btn-warning").' btn-sm" data-target="#addloanappraisaldetails" data-toggle="modal" data-placement="top" title="Add Loan Appraisal Details" type="button"><i class="fa fa-plus"><i class="fa fa-book"></i></i></button>
                                  <button onclick="forwardforapproval('.$row1['chartid'].')"  '.(($row1["loan_tag"]=="2")?"":"disabled").' class="btn '.(($row1["loan_tag"]=="2")?"btn-social btn-success":"btn-social btn-apple").' btn-sm" data-toggle="tooltip" data-placement="top" title="Forward for Approval" type="button"><i class="fa fa-check"></i></button>
                                </center>
                              </td>';
                        echo '</tr>';
                    }
                }
            }

        }
    }
    public static function GET_APPROVEDLOANS(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM loan_approvals a,loan_application1 n WHERE n.loan_id=a.loan_id AND a.decline !='1' AND disburse ='0' ORDER BY insertion_date DESC") as $row1){
            foreach ($db->query("SELECT * FROM clients WHERE clientid='".$row1['member_id']."'")as $row){
                echo '<tr>';
                echo '<td width="10%" data-order="2017-00-00">'. $row1['insertion_date'].'</td>';
                echo '<td width="16%"><b> '.$row['accountname'].' </b></td>';
                echo '<td width="17%"> '.number_format($row1['loan_amount']).'</td>';
                echo '<td width="25%">
                        '. (($row1['status']== "0")?"<b style='color: #b60b1a'>no records</b>":"").'
                        '. (($row1['status']== "1")?"<b style='color: #ff6f09'>Only Loan officer Reviewed</b>":"").'
                        '. (($row1['status']== "2")?"<b style='color: #ff6f09'>Only Manager Reviewed</b>":"").'
                        '. (($row1['status']== "3")?"<b style='color: #ff6f09'>Only Committee Reviewed</b>":"").'
                        '. (($row1['status']== "4")?"<b style='color: #00a9dd'>Both Loan Officer & Manager Reviewed</b>":"").'
                        '. (($row1['status']== "5")?"<b style='color: #00a9dd'>Both Loan Officer & Committee Reviewed</b>":"").'
                        '. (($row1['status']== "6")?"<b style='color: #00a9dd'>Both Manager & Committee Reviewed</b>":"").'
                        '. (($row1['status']== "7")?"<b style='color: #1b9f3f'>All parties Reviewed</b>":"").'
                        </td>';
                echo '<td>'. (($row1['status']== "0")?"<span style='color: #b60b1a'>no records</span>":(($row1['status']== "3" ||$row1['status']== "5" || $row1['status']== "6" || $row1['status']== "7" )?"<b style='color: #1b9f3f'>".number_format($row1['c_amt'])."</b>":"<span style='color: #00a9dd'>amount pending...</span>")).'</td>';
                echo '<td width="16%">
                        <center>
                          <button onclick="getloanapplicationdata('.$row1['chartid'].')" class="btn btn-social btn-info btn-sm" data-target="#addloanappdetails" data-toggle="modal" data-placement="top" title="Add Loan Application Details" type="button"><i class="fa fa-plus"><i class="fa fa-book"></i></i></button>
                          <button onclick="getloanappraisaldata('.$row1['chartid'].')" '.(($row1["loan_tag"]=="0")?"disabled":"").' class="btn '.(($row1["loan_tag"]=="0")?"btn-social btn-apple":"btn-social btn-warning").' btn-sm" data-target="#addloanappraisaldetails" data-toggle="modal" data-placement="top" title="Add Loan Appraisal Details" type="button"><i class="fa fa-plus"><i class="fa fa-book"></i></i></button>
                          <button onclick="loanapproval('.$row1['chartid'].')"   class="btn btn-social btn-success btn-sm" data-target="#makedecision" data-toggle="modal" data-toggle="tooltip" data-placement="top" title="make decision on loan" type="button"><i class="ti ti-angle-double-right"></i></button>
                          <button onclick="declineloan('.$row1['desc_id'].')" class="btn btn-social btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Decline Application" type="button"><i class="fa fa-close"></i></button>
                        </center>
                      </td>';
                echo '</tr>';
            }
        }
    }
    public static function GET_DECLINEDLOANS(){
        $db = new DB();
        echo '
            <table id="grat1" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered table-striped m-n">
                <thead>
                    <tr class="danger">
                        <th width="10%">Date</th>
                        <th width="10%">Account Name</th>
                        <th width="15%">Amount Applied For</th>
                        <th width="25%">Approval Details</th>
                        <th width="20%">Amount Approved</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    ';
        foreach ($db->query("SELECT * FROM loan_approvals a,loan_application1 n WHERE n.loan_id=a.loan_id AND a.decline ='1' ORDER BY insertion_date DESC") as $row1){
            foreach ($db->query("SELECT * FROM clients WHERE clientid='".$row1['member_id']."'")as $row){
                echo '<tr>';
                echo '<td width="10%" data-order="2017-00-00">'. $row1['insertion_date'].'</td>';
                echo '<td width="16%"><b> '.$row['accountname'].' </b></td>';
                echo '<td width="17%"> '.number_format($row1['loan_amount']).'</td>';
                echo '<td width="25%">
                        '. (($row1['status']== "0")?"<b style='color: #b60b1a'>no records</b>":"").'
                        '. (($row1['status']== "1")?"<b style='color: #ff6f09'>Only Loan officer Reviewed</b>":"").'
                        '. (($row1['status']== "2")?"<b style='color: #ff6f09'>Only Manager Reviewed</b>":"").'
                        '. (($row1['status']== "3")?"<b style='color: #ff6f09'>Only Committee Reviewed</b>":"").'
                        '. (($row1['status']== "4")?"<b style='color: #00a9dd'>Both Loan Officer & Manager Reviewed</b>":"").'
                        '. (($row1['status']== "5")?"<b style='color: #00a9dd'>Both Loan Officer & Committee Reviewed</b>":"").'
                        '. (($row1['status']== "6")?"<b style='color: #00a9dd'>Both Manager & Committee Reviewed</b>":"").'
                        '. (($row1['status']== "7")?"<b style='color: #1b9f3f'>All parties Reviewed</b>":"").'
                        </td>';
                echo '<td>'. (($row1['status']== "0")?"<span style='color: #b60b1a'>no records</span>":(($row1['status']== "3" ||$row1['status']== "5" || $row1['status']== "6" || $row1['status']== "7" )?"<b style='color: #1b9f3f'>".number_format($row1['c_amt'])."</b>":"<span style='color: #00a9dd'>amount pending...</span>")).'</td>';
                echo '<td width="16%">
                        <center>
                          <button onclick="retrievedeclinedloans('.$row1['desc_id'].')" class="btn btn-social btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="Decline Application" type="button"><i class="fa fa-check"></i></button>
                        </center>
                      </td>';
                echo '</tr>';
            }
        }
        echo '
                </tbody>
            </table>
        ';

    }
    public static function SAVE_APPLICATION(){
        $ln_launch =new LOAN_PROCESSCLASS();
        $db = new DB();

        $data = explode("?::?",$_GET['saveloanapplicationdata']);

        foreach ($db->query("SELECT * FROM loan_application1 WHERE chartid='".$data[20]."'") as $row1){
            $chartid = $row1['loan_id'];
        }
		
	$da = explode("/",$data[21]);
        $date = $da[2]."-".$da[0]."-".$da[1];
		
        $ln_launch->member_id=$data[19];                           
        $ln_launch->type_of_business=$data[0];                     $ln_launch->loan_amount=$data[1];
        $ln_launch->amount_in_word=$data[2];                       $ln_launch->int_purpose=$data[3];
        $ln_launch->source_ofpayment=$data[4];                     $ln_launch->duration=$data[5];
        $ln_launch->repayment_schedule=$data[6];                   $ln_launch->type_of_loan=$data[7];
        $ln_launch->assests_owned=$data[8];                        $ln_launch->dateexpected = $date;
        $ln_launch->collateral_assests=$data[9];                   $ln_launch->debts=$data[10];
        $ln_launch->purpose_of_previous=$data[11];                 $ln_launch->net_worth=$data[12];
        $ln_launch->ability_to_pay=$data[13];                      $ln_launch->lc_name=$data[14];
        $ln_launch->lc_contact=$data[16];                          $ln_launch->lc_address=$data[15];
        $ln_launch->grt1_id=$data[17];                             $ln_launch->grt2_id=$data[18];
        $ln_launch->chartid=$data[20];

        if($chartid){
            foreach ($db->query("SELECT * FROM clients WHERE clientid='".$data[19]."'") as $row){
                if($row['accounttype'] == "1"){
                    $ln_launch->kin_name=$data[23];
                    $ln_launch->kin_contact=$data[24];
                    $ln_launch->loan_id=$chartid;
                    $ln_launch->save();
                    foreach ($db->query("SELECT * FROM post_chart WHERE chartid='".$data[20]."'")as $row){}
                    if($row['loan_tag']=="3" || $row['loan_tag']=="2"){}else{$db->query("UPDATE post_chart SET loan_tag='1' WHERE chartid='".$data[20]."'");}
                }
                if($row['accounttype'] == "2"){
					$ln_launch->loan_id=$chartid;
                    $ln_launch->save();
                    foreach ($db->query("SELECT * FROM post_chart WHERE chartid='".$data[20]."'")as $row){}
                    if($row['loan_tag']=="3" || $row['loan_tag']=="2"){}else{$db->query("UPDATE post_chart SET loan_tag='1' WHERE chartid='".$data[20]."'");}
                }
                if($row['accounttype'] == "3"){
					$ln_launch->loan_id=$chartid;
                    $ln_launch->save();
                    foreach ($db->query("SELECT * FROM post_chart WHERE chartid='".$data[20]."'")as $row){}
                    if($row['loan_tag']=="3" || $row['loan_tag']=="2"){}else{$db->query("UPDATE post_chart SET loan_tag='1' WHERE chartid='".$data[20]."'");}
                }
            }
        }else{
            foreach ($db->query("SELECT * FROM clients WHERE clientid='".$data[19]."'") as $row){
                if($row['accounttype'] == "1"){
                    $ln_launch->kin_name=$data[23];
                    $ln_launch->kin_contact=$data[24];
                    $ln_launch->lvl_education=$data[22];
                    $ln_launch->create();
                    $db->query("UPDATE post_chart SET loan_tag='1' WHERE chartid='".$data[20]."'");
                }
                if($row['accounttype'] == "2"){
                    $ln_launch->create();
                    $db->query("UPDATE post_chart SET loan_tag='1' WHERE chartid='".$data[20]."'");
                }
                if($row['accounttype'] == "3"){
                    $ln_launch->create();
                    $db->query("UPDATE post_chart SET loan_tag='1' WHERE chartid='".$data[20]."'");
                }
            }
        }

        echo '
            <table id="example" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered table-striped m-n">
                <thead>
                    <tr class="info">
                        <th width="20%">Date</th>
                        <th width="30%">Account Name</th>
                        <th width="30%">Application Details</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    ';  LOAN_PROCESSCLASS::GET_CLIENTLOAN_APPLICATION();  echo '
                </tbody>
            </table>
        ';
    }
    public static function FORWARD_LOANFORAPPROVAL(){
        $db = new DB(); $approve = new LOAN_APPROVAL(); NOW_DATETIME::NOW();
        foreach ($db->query("SELECT * FROM loan_application1 WHERE chartid='".$_GET['forwardforapproval']."'") as $rowapp){$loanapplicationid = $rowapp['loan_id'];$clietid = $rowapp['member_id'];}
        foreach ($db->query("SELECT * FROM loan_appraisal WHERE chartid='".$_GET['forwardforapproval']."'") as $rowapp){$loanappraisalid = $rowapp['appraisal_id'];}

        $approve->loan_id  = $loanapplicationid;
        $approve->appras_id = $loanappraisalid;
        $approve->member_id = $clietid;
        $approve->chartid = $_GET['forwardforapproval'];
        $approve->insertion_date = NOW_DATETIME::$Date_Time;
        $approve->create();
        $db->query("UPDATE post_chart SET loan_tag='3' WHERE chartid='".$_GET['forwardforapproval']."'");

        echo '
            <table id="example" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered table-striped m-n">
                <thead>
                    <tr class="info">
                        <th width="20%">Date</th>
                        <th width="30%">Account Name</th>
                        <th width="30%">Application Details</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    ';  LOAN_PROCESSCLASS::GET_CLIENTLOAN_APPLICATION();    echo '
                </tbody>
            </table>
        ';
        echo '|<><>|';
        echo '
            <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered table-striped m-n">
                <thead>
                    <tr class="success">
                        <th width="10%">Date</th>
                        <th width="10%">Account Name</th>
                        <th width="15%">Amount Applied For</th>
                        <th width="25%">Approval Details</th>
                        <th width="20%">Amount Approved</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    ';  LOAN_PROCESSCLASS::GET_APPROVEDLOANS();    echo '
                </tbody>
            </table>
        ';
    }
    public static function MAKE_LOANDECISION(){
        $db = new DB(); $approve = new LOAN_APPROVAL(); NOW_DATETIME::NOW();    session_start();    GENERAL_SETTINGS::GEN();
        foreach ($db->query("SELECT * FROM loan_approvals a,loan_application1 n WHERE n.loan_id=a.loan_id AND n.chartid='".$_GET['loanapproval']."'")as $row){}
        foreach ($db->query("SELECT * FROM clients WHERE clientid='".$row['member_id']."'") as $rowclient){}
        foreach ($db->query("SELECT * FROM users WHERE user_id='".$_SESSION['user_id']."'") as $rowpass){}
        foreach ($db->query("SELECT * FROM loan_approvals WHERE chartid='".$_GET['loanapproval']."'") as $rowapproval){}
        foreach ($db->query("SELECT * FROM accounttypes WHERE typeid='".$row['type_of_loan']."'") as $rowacc){}
	
        $data = explode("-",$row['dateexpected']);
        $date = $data[2]."-".$data[1]."-".$data[0];
        $optionval = $row['m_lntype'];
        $optionpenval = $row['penalty'];
        $optionnames = $row['m_lntype'] == "0" ? "Flat Interest" : ($row['m_lntype']== "1" ? "Reducing Interest" : "Compund Interest");
        $optionpentalty = $row['penalty'] == "1" ? "Dont Charge Penalty" : "Charge Penalty";
        echo '
            <div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-3">
                            <legend><b>Client data</b></legend>
                            <table>
                                <tbody>
                                <input  value="' .$rowapproval['desc_id'].'" id="approvalid" type="hidden">
                                <input  value="" name="loan_id" type="hidden">
                                <input  value="" name="appras_id" type="hidden">
                                <tr>
                                    <td style="font-size: 12px"><b>Names of applicant :</b></td>
                                    <td>&nbsp;&nbsp;<b style="color: green;">'.$rowclient['accountname'].'</b></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px"><b>Account No.:</b></td>
                                    <td>&nbsp;&nbsp;<b style="color: green;">'.$rowclient['accountno'].'</b></td>
                                </tr>
                                </tbody>
                            </table>
                            <legend><b>Credit Decision By the Loan Officer</b></legend>
                            <table>
                                <tbody>
                                <tr>
                                    <td style="font-size: 12px"><b>Loan Amount:</b></td>
                                    <td><input '.(($rowpass['loan_handle']=="0")?"":"disabled").'  value="'.$rowapproval['o_lnamt'].'" id="o_lnamt" type="text"></b></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px"><b>Loan Period:</b></td>
                                    <td><input '.(($rowpass['loan_handle']=="0")?"":"disabled").' id="o_lnprd" value="'.$rowapproval['o_lnprd'].'" type="text"></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px"><b>Reasons For Approval/Rejection:</b></td>
                                    <td><input '.(($rowpass['loan_handle']=="0")?"":"disabled").' id="o_desc" value="'.$rowapproval['o_desc'].'" type="text" ></td>
                                </tr>
                                </tbody>
                            </table>
                            <legend><b>Recommendation By the Manager</b></legend>
                            <table>
                                <tbody>
                                <tr>
                                    <td style="font-size: 12px"><b>Decision:</b></td>
                                    <td>
                                        <select '.(($rowpass['loan_handle']=="2")?"":"disabled").' class="form-control" id="c_desc" style="width: 150px;">
                                            <option value="'.(($rowapproval['c_desc'])?$rowapproval['c_desc']:'').'">'.(($rowapproval['c_desc']=='0')?'Approved':(($rowapproval['c_desc']=='1')?'Rejected':'select decision')).'</option>
                                            <option value="0">Approved</option>
                                            <option value="1">Rejected</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px"><b>Loan Amount:</b></td>
                                    <td><input onkeyup="updateloanAmt(this.value)" '.(($rowpass['loan_handle']=="1" || $rowpass['loan_handle']=="2")?"":"disabled").' id="m_lnamt" value="'.$rowapproval['c_amt'].'" type="text"></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px"><b>Loan Period:</b></td>
                                    <td><input onkeyup="updateterms(this.value)" '.(($rowpass['loan_handle']=="1" || $rowpass['loan_handle']=="2")?"":"disabled").' id="m_lnprd" value="'.$rowapproval['c_prd'].'" type="text" ></td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px"><b>Reasons For Approval/Rejection:</b></td>
                                    <td><input '.(($rowpass['loan_handle']=="1" || $rowpass['loan_handle']=="2")?"":"disabled").' id="m_desc" value="'.$rowapproval['c_rsn_desc'].'" type="text"></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-xs-9">
                            <div class="row">
                                <div class="col-xs-4">
                                    <legend><b>Proposed Loan Details</b></legend>
                                    <table>
                                        <tbody>
                                        <input  value="" id="member_id" type="hidden">
                                        <input  value="" id="loan_id" type="hidden">
                                        <input  value="" id="appras_id" type="hidden">
                                        <tr>
                                            <td style="font-size: 12px"><b>Loan Amount :</b></td>
                                            <td>&nbsp;&nbsp;<b style="color: green;">'.number_format($row['loan_amount']).'</b></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px"><b>Loan Duration :</b></td>
                                            <td>&nbsp;&nbsp;<b style="color: green;">'.$row['duration'].'  months</b></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px"><b>Loan Type :</b></td>
                                            <td>&nbsp;&nbsp;<b style="color: green;">'.$rowacc['typename'].'</b></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px"><b>Interest Rate :</b></td>
                                            <td>&nbsp;&nbsp;<b style="color: green;">'.$rowacc['interest'].'</b></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px"><b>Grace Period :</b></td>
                                            <td>&nbsp;&nbsp;<b style="color: green;">'.$rowacc['period'].'</b></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px"><b>Receiving Date:</b></td>
                                            <td>&nbsp;&nbsp;<b style="color: green;">'.$date.'</b></td>
                                        </tr>
                                        </tbody>
                                    </table><br><br>
                                    <legend><b>Loan Calculator</b></legend>
                                    
                                   
                                    <input hidden type="text" id="mydates" value="'.$row['dateexpected'].'" />
                                    <table>
                                        <tbody>
                                        <tr>
                                            <td style="font-size: 12px">Penalty Chargeable</td>
                                            <td>
                                                <select name="penalty" id="penaltyid">
                                                    <option value="'.$optionpenval.'">'.$optionpentalty.'</option>
                                                    <option value="0">Charge Penalty</option>
                                                    <option value="1">Dont Charge Penalty</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px">Choose Type</td>
                                            <td>
                                                <select name="cars" id="loantype">
                                                    <option value="'.$optionval.'">'.$optionnames.'</option>
                                                    <option value="0">Flat Interest</option>
                                                    <option value="1">Reducing Interest</option>
                                                    <option value="2">Compund Interest</option>
                                                </select> <br><br>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px"><b>Loan Amount</b></td>
                                            <td><input disabled type="text" id="principal" value="'.$rowapproval['c_amt'].'" /></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px"><b>Interest Rate (in percentage)</b></td>
                                            <td><input type="text" id="interest" value="'.$rowapproval['m_lninterest'].'"/></td>
                                        </tr>
                                        <tr>
                                       <br/>
                                            <td style="font-size: 12px"><b>Repayment Period (Months)</b></td>
                                            <td><input disabled type="text" id="terms" value="'.$rowapproval['c_prd'].'" /></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 12px"></td>
                                            <td><input type="button" value="Calculate Now" onclick="getValues()" /></td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-xs-8">
                                    <form>
                                        <legend><b>Loan Details and Repayment Schedule</b></legend>
                                        <div id="Result"> <div hidden id="scheduledata"></div><b>Add Loan Amount, Interest and Number of Months<br> Then press Calculate Now to Loan view details.</b></div>	
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button onclick="saveloandecisions()" id="make_decision" class="btn btn-primary">Submit Decisions</button>
                    <button onclick="closemodal2()" type="button" class="btn btn-default">Close</button>
                </div>
            </div>
        ';
    }
    public static function SAVE_DECISIONS(){
        $launc_desc =new LOAN_APPROVAL();   $db = new DB();     session_start();
        NOW_DATETIME::NOW();
        $data = explode("?::?",$_GET['saveloandecisiondata']);
        foreach ($db->query("SELECT * FROM loan_approvals WHERE desc_id='".$data[11]."'") as $row){}
        foreach ($db->query("SELECT * FROM users WHERE user_id='".$_SESSION['user_id']."'") as $rowpass){}
        if($rowpass['loan_handle'] == "0"){
            if($row['status'] == "0"){$db->query("UPDATE loan_approvals SET status='1' WHERE desc_id='".$data[11]."'");}
            if($row['status'] == "1"){}
            if($row['status'] == "2"){$db->query("UPDATE loan_approvals SET status='4' WHERE desc_id='".$data[11]."'");}
            if($row['status'] == "3"){$db->query("UPDATE loan_approvals SET status='5' WHERE desc_id='".$data[11]."'");}
            if($row['status'] == "4"){}
            if($row['status'] == "5"){}
            if($row['status'] == "6"){$db->query("UPDATE loan_approvals SET status='7' WHERE desc_id='".$data[11]."'");}
        }
        if($rowpass['loan_handle'] == "1"){
            if($row['status'] == "0"){$db->query("UPDATE loan_approvals SET status='2' WHERE desc_id='".$data[11]."'");}
            if($row['status'] == "1"){$db->query("UPDATE loan_approvals SET status='4' WHERE desc_id='".$data[11]."'");}
            if($row['status'] == "2"){}
            if($row['status'] == "3"){$db->query("UPDATE loan_approvals SET status='6' WHERE desc_id='".$data[11]."'");}
            if($row['status'] == "4"){}
            if($row['status'] == "5"){$db->query("UPDATE loan_approvals SET status='7' WHERE desc_id='".$data[11]."'");}
            if($row['status'] == "6"){}
        }
        if($rowpass['loan_handle'] == "2"){
            if($row['status'] == "0"){$db->query("UPDATE loan_approvals SET status='3' WHERE desc_id='".$data[11]."'");}
            if($row['status'] == "1"){$db->query("UPDATE loan_approvals SET status='5' WHERE desc_id='".$data[11]."'");}
            if($row['status'] == "2"){$db->query("UPDATE loan_approvals SET status='6' WHERE desc_id='".$data[11]."'");}
            if($row['status'] == "3"){}
            if($row['status'] == "4"){$db->query("UPDATE loan_approvals SET status='7' WHERE desc_id='".$data[11]."'");}
            if($row['status'] == "5"){}
            if($row['status'] == "6"){}
        }
        $datasch = explode(":",$data[10]);
        $launc_desc->o_lnamt = $data[0];
        $launc_desc->o_lnprd = $data[1];
        $launc_desc->o_desc = $data[2];
        $launc_desc->m_lnamt = $data[3];
        $launc_desc->m_lnprd = $data[4];
        $launc_desc->m_desc = $data[5];
        $launc_desc->c_desc = $data[6];
        $launc_desc->c_date = $data[7];
        $launc_desc->c_amt = $data[3];
        $launc_desc->c_prd = $data[9];
        $launc_desc->m_lninterest = $datasch[10];
        $launc_desc->desc_id = $data[11];
        $launc_desc->m_lntype = $data[12];
        $launc_desc->penalty = $data[13];
        if($data[6]=="0" || $data[6] == ""){}else{$launc_desc->decline = $data[6];}
        $launc_desc->save();
        
        for($i = 0;$i < $datasch[2]; $i++ ){
            $paycheck .= ",";
            $finestat .= ",";
        }
        
        CLIENT_DATA::$clientid =  $row['member_id'];
        CLIENT_DATA::CLIENTDATAMAIN();
        $schedule = new  LOAN_DISBURSEMENT();
        $schedule->approveid  =  $data[11];
        $schedule->disbursed_date  =  NOW_DATETIME::$Date;
        $schedule->balance      	=  CLIENT_DATA::$savingaccount;
        $schedule->amount_given 	=  $datasch[0];
        $schedule->period       	=  $datasch[2];
        $schedule->repay_date   	=  $datasch[3];
        $schedule->amount_disb  	=  $datasch[1];
        $schedule->reviewdate   	=  $datasch[3];
        $schedule->paycheck     	=  $paycheck;
        $schedule->principal    	=  $datasch[7];
        $schedule->interest     	=  $datasch[6];
        $schedule->total        	=  $datasch[8];
        $schedule->bal_bef      	=  $datasch[4];
        $schedule->bal_aft      	=  $datasch[5];
        $schedule->fines       		=  $finestat;
        $schedule->finestat       	=  $finestat;
        $schedule->loanbal      	=  $datasch[7];
        $schedule->type         	=  "1";
//        $schedule->monthlypay         	=  "...";
        $schedule->totalprinc   	=  $datasch[1];
        $schedule->totalinterest        =  $datasch[9];
        
        foreach ($db->query("SELECT * FROM loan_schedules WHERE approveid='".$data[11]."'") as $rowx){}
        
        if($rowx['approveid']){echo $rowx['schudele_id'];
            $schedule->schudele_id = $rowx['schudele_id'];
            $schedule->save();
        }else{
            $schedule->create();
        }
        
        echo'
            <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr>
                        <th width="10%">Date</th>
                        <th width="10%">Account Name</th>
                        <th width="15%">Amount Applied For</th>
                        <th width="25%">Approval Details</th>
                        <th width="20%">Amount Approved</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    ';  LOAN_PROCESSCLASS::GET_APPROVEDLOANS();    echo '
                </tbody>
            </table>
        ';
    }
    public static function RETRIVE_DECLINEDLOANS(){
        $launc_desc =new LOAN_APPROVAL();

        $launc_desc->decline = "0";
        $launc_desc->c_desc = "";
        $launc_desc->desc_id = $_GET['retivedeclinedloans'];
        $launc_desc->save();

        echo '
            <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered table-striped m-n">
                <thead>
                    <tr class="danger">
                        <th width="10%">Date</th>
                        <th width="10%">Account Name</th>
                        <th width="15%">Amount Applied For</th>
                        <th width="25%">Approval Details</th>
                        <th width="20%">Amount Approved</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    ';  LOAN_PROCESSCLASS::GET_APPROVEDLOANS();    echo '
                </tbody>
            </table>
        ';
    }
    public static function DECLINE_LOAN(){
        $launc_desc =new LOAN_APPROVAL();

        $launc_desc->decline = "1";
        $launc_desc->desc_id = $_GET['declineloans'];
        $launc_desc->save();

        echo '
            <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered table-striped m-n">
                <thead>
                    <tr class="danger">
                        <th width="10%">Date</th>
                        <th width="10%">Account Name</th>
                        <th width="15%">Amount Applied For</th>
                        <th width="25%">Approval Details</th>
                        <th width="20%">Amount Approved</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    ';  LOAN_PROCESSCLASS::GET_APPROVEDLOANS();    echo '
                </tbody>
            </table>
        ';
    }
    public static function APPROVED_LOANS(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM loan_approvals WHERE decline ='0' AND disburse='0' AND c_desc!='1' AND c_desc!=''") as $row){
            foreach ($db->query("SELECT * FROM clients WHERE clientid='".$row['member_id']."'") as $rowclient) {
                if ($row['status'] == "3") {
                    echo '<tr>';
                    echo '<td width="25%" data-order="2017-00-00">'.$row['insertion_date'] . '</td>';
                    echo '<td width="25%"><b> ' . $rowclient['accountname'] . ' - '.$rowclient['accountno'].' </b></td>';
                    echo '<td width="25%"><b style="font-size: 18px;color: #1b9f3f;font-weight: 900">'.number_format($row['c_amt']) . '</b><br><b>Disburse Date:</b> '.$row['c_date'].'</td>';
                    echo '<td width="25%">
                        <center>
                          <button onclick="getschedule('.$row['desc_id'].')"  class="btn btn-social btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Disburse" type="button"><i class="fa fa-check"></i></button>
                        </center>
                      </td>';
                    echo '</tr>';
                }
                if ($row['status'] == "4") {

                }
                if ($row['status'] == "5") {
                    echo '<tr>';
                    echo '<td width="25%" data-order="2017-00-00">' . $row['insertion_date'] . '</td>';
                    echo '<td width="25%"><b> ' . $rowclient['accountname'] . '  - '.$rowclient['accountno'].'</b></td>';
                    echo '<td width="25%"><b style="font-size: 18px;color: #1b9f3f;font-weight: 900">'.number_format($row['c_amt']) . '</b><br><b>Disburse Date:</b> '.$row['c_date'].'</td>';
                    echo '<td width="25%">
                        <center>
                          <button onclick="getschedule('.$row['desc_id'].')"  class="btn btn-social btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Disburse" type="button"><i class="fa fa-check"></i></button>
                        </center>
                      </td>';
                    echo '</tr>';
                }
                if ($row['status'] == "6") {
                    echo '<tr>';
                    echo '<td width="25%" data-order="2017-00-00">' . $row['insertion_date'] . '</td>';
                    echo '<td width="25%"><b> ' . $rowclient['accountname'] . ' - '.$rowclient['accountno'].' </b></td>';
                    echo '<td width="25%"><b style="font-size: 18px;color: #1b9f3f;font-weight: 900">'.number_format($row['c_amt']) . '</b><br><b>Disburse Date:</b> '.$row['c_date'].'</td>';
                    echo '<td width="25%">
                        <center>
                          <button onclick="getschedule('.$row['desc_id'].')"  class="btn btn-social btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Disburse" type="button"><i class="fa fa-check"></i></button>
                        </center>
                      </td>';
                    echo '</tr>';
                }
                if ($row['status'] == "7") {
                    echo '<tr>';
                    echo '<td width="25%" data-order="2017-00-00">' . $row['insertion_date'] . '</td>';
                    echo '<td width="25%"><b> ' . $rowclient['accountname'] . '  - '.$rowclient['accountno'].'</b></td>';
                    echo '<td width="25%"><b style="font-size: 18px;color: #1b9f3f;font-weight: 900">'.number_format($row['c_amt']) . '</b><br><b>Disburse Date:</b> '.$row['c_date'].'</td>';
                    echo '<td width="25%">
                        <center>
                          <button onclick="getschedule('.$row['desc_id'].')"  class="btn btn-social btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Disburse" type="button"><i class="fa fa-check"></i></button>
                        </center>
                      </td>';
                    echo '</tr>';
                }
            }
        }

    }
    public static function DISBURSED_LOANS(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM loan_approvals WHERE decline ='0' AND disburse='1' ORDER BY insertion_date DESC") as $row){
            foreach ($db->query("SELECT * FROM clients WHERE clientid='".$row['member_id']."'") as $rowclient) {
                if ($row['status'] == "3") {
                    echo '<tr>';
                    echo '<td width="25%" data-order="2017-00-00">'.$row['insertion_date'] . '</td>';
                    echo '<td width="25%"><b> ' . $rowclient['accountname'] . '  - '.$rowclient['accountno'].'</b></td>';
                    echo '<td width="25%"><b style="font-size: 18px;color: #1b9f3f;font-weight: 900">'.number_format($row['c_amt']) . '</b><br><b>Disburse Date:</b> '.$row['c_date'].'</td>';
                    echo '<td width="25%">
                        <center>
                            <button onclick="getloanapplicationdata('.$row['chartid'].')" class="btn btn-social btn-info btn-sm" data-target="#addloanappdetails" data-toggle="modal" data-placement="top" title="Add Loan Application Details" type="button"><i class="fa fa-plus"><i class="fa fa-book"></i></i></button>
                            <button onclick="getloanappraisaldata('.$row['chartid'].')" '.(($row["loan_tag"]=="0")?"disabled":"").' class="btn '.(($row["loan_tag"]=="0")?"btn-social btn-apple":"btn-social btn-warning").' btn-sm" data-target="#addloanappraisaldetails" data-toggle="modal" data-placement="top" title="Add Loan Appraisal Details" type="button"><i class="fa fa-plus"><i class="fa fa-book"></i></i></button>
                            <button onclick="returnschedule('.$row['desc_id'].')" data-target="#scheduleloansmodal"  data-toggle="modal" class="btn btn-social btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="View Schedule" type="button"><i class="fa fa-file"></i></button>
                            <button onclick="returndisbursedetail('.$row['desc_id'].')" data-target="#disbursedetailmodal"  data-toggle="modal" class="btn btn-social btn-reddit btn-sm" data-toggle="tooltip" data-placement="top" title="Disburse Detail" type="button"><i class="fa fa-file"></i></button>
                        </center>
                      </td>';
                    echo '</tr>';
                }
                if ($row['status'] == "4") {

                }
                if ($row['status'] == "5") {
                    echo '<tr>';
                    echo '<td width="25%" data-order="2017-00-00">' . $row['insertion_date'] . '</td>';
                    echo '<td width="25%"><b> ' . $rowclient['accountname'] . ' - '.$rowclient['accountno'].' </b></td>';
                    echo '<td width="25%"><b style="font-size: 18px;color: #1b9f3f;font-weight: 900">'.number_format($row['c_amt']) . '</b><br><b>Disburse Date:</b> '.$row['c_date'].'</td>';
                    echo '<td width="25%">
                        <center>
                            <button onclick="getloanapplicationdata('.$row['chartid'].')" class="btn btn-social btn-info btn-sm" data-target="#addloanappdetails" data-toggle="modal" data-placement="top" title="Add Loan Application Details" type="button"><i class="fa fa-plus"><i class="fa fa-book"></i></i></button>
                            <button onclick="getloanappraisaldata('.$row['chartid'].')" '.(($row["loan_tag"]=="0")?"disabled":"").' class="btn '.(($row["loan_tag"]=="0")?"btn-social btn-apple":"btn-social btn-warning").' btn-sm" data-target="#addloanappraisaldetails" data-toggle="modal" data-placement="top" title="Add Loan Appraisal Details" type="button"><i class="fa fa-plus"><i class="fa fa-book"></i></i></button>                          
                            <button onclick="returnschedule('.$row['desc_id'].')" data-target="#scheduleloansmodal"  data-toggle="modal" class="btn btn-social btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="View Schedule" type="button"><i class="fa fa-file"></i></button>
                            <button onclick="returndisbursedetail('.$row['desc_id'].')" data-target="#disbursedetailmodal"  data-toggle="modal" class="btn btn-social btn-reddit btn-sm" data-toggle="tooltip" data-placement="top" title="Disburse Detail" type="button"><i class="fa fa-file"></i></button>
                        </center>
                      </td>';
                    echo '</tr>';
                }
                if ($row['status'] == "6") {
                    echo '<tr>';
                    echo '<td width="25%" data-order="2017-00-00">' . $row['insertion_date'] . '</td>';
                    echo '<td width="25%"><b> ' . $rowclient['accountname'] . ' - '.$rowclient['accountno'].' </b></td>';
                    echo '<td width="25%"><b style="font-size: 18px;color: #1b9f3f;font-weight: 900">'.number_format($row['c_amt']) . '</b><br><b>Disburse Date:</b> '.$row['c_date'].'</td>';
                    echo '<td width="25%">
                        <center>
                            <button onclick="getloanapplicationdata('.$row['chartid'].')" class="btn btn-social btn-info btn-sm" data-target="#addloanappdetails" data-toggle="modal" data-placement="top" title="Add Loan Application Details" type="button"><i class="fa fa-plus"><i class="fa fa-book"></i></i></button>
                            <button onclick="getloanappraisaldata('.$row['chartid'].')" '.(($row["loan_tag"]=="0")?"disabled":"").' class="btn '.(($row["loan_tag"]=="0")?"btn-social btn-apple":"btn-social btn-warning").' btn-sm" data-target="#addloanappraisaldetails" data-toggle="modal" data-placement="top" title="Add Loan Appraisal Details" type="button"><i class="fa fa-plus"><i class="fa fa-book"></i></i></button>                         
                            <button onclick="returnschedule('.$row['desc_id'].')" data-target="#scheduleloansmodal"  data-toggle="modal" class="btn btn-social btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="View Schedule" type="button"><i class="fa fa-file"></i></button>
                            <button onclick="returndisbursedetail('.$row['desc_id'].')" data-target="#disbursedetailmodal"  data-toggle="modal" class="btn btn-social btn-reddit btn-sm" data-toggle="tooltip" data-placement="top" title="Disburse Detail" type="button"><i class="fa fa-file"></i></button>
                        </center>
                      </td>';
                    echo '</tr>';
                }
                if ($row['status'] == "7") {
                    echo '<tr>';
                    echo '<td width="25%" data-order="2017-00-00">' . $row['insertion_date'] . '</td>';
                    echo '<td width="25%"><b> ' . $rowclient['accountname'] . ' - '.$rowclient['accountno'].' </b></td>';
                    echo '<td width="25%"><b style="font-size: 18px;color: #1b9f3f;font-weight: 900">'.number_format($row['c_amt']) . '</b><br><b>Disburse Date:</b> '.$row['c_date'].'</td>';
                    echo '<td width="25%">
                        <center>
                            <button onclick="getloanapplicationdata('.$row['chartid'].')" class="btn btn-social btn-info btn-sm" data-target="#addloanappdetails" data-toggle="modal" data-placement="top" title="Add Loan Application Details" type="button"><i class="fa fa-plus"><i class="fa fa-book"></i></i></button>
                            <button onclick="getloanappraisaldata('.$row['chartid'].')" '.(($row["loan_tag"]=="0")?"disabled":"").' class="btn '.(($row["loan_tag"]=="0")?"btn-social btn-apple":"btn-social btn-warning").' btn-sm" data-target="#addloanappraisaldetails" data-toggle="modal" data-placement="top" title="Add Loan Appraisal Details" type="button"><i class="fa fa-plus"><i class="fa fa-book"></i></i></button>                          
                            <button onclick="returnschedule('.$row['desc_id'].')" data-target="#scheduleloansmodal"  data-toggle="modal" class="btn btn-social btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="View Schedule" type="button"><i class="fa fa-file"></i></button>
                            <button onclick="returndisbursedetail('.$row['desc_id'].')" data-target="#disbursedetailmodal"  data-toggle="modal" class="btn btn-social btn-reddit btn-sm" data-toggle="tooltip" data-placement="top" title="Disburse Detail" type="button"><i class="fa fa-file"></i></button>
                        </center>
                      </td>';
                    echo '</tr>';
                }
            }
        }

    }
    public static function POSTDUEDATE_LOANS(){
        $db = new DB(); $rep=""; $loop =  1;   NOW_DATETIME::NOW();
        foreach ($db->query("SELECT * FROM loan_approvals p,loan_schedules s WHERE s.approveid=p.desc_id AND p.decline ='0' AND p.disburse='1' ORDER BY s.disbursed_date DESC") as $row){
            foreach ($db->query("SELECT * FROM clients WHERE clientid='".$row['member_id']."'") as $rowclient) {
                $data = SYS_CODES::split_on($row['reviewdate'],1);
                $data1 = SYS_CODES::split_on($row['paycheck'],1);
                $data2 = SYS_CODES::split_on($row['total'],1);
                $repaydate = explode(",",$data[1]);
                $repaycheck = explode(",",$data1[1]);
                $repayamt = explode(",",$data2[1]);
                $datas = "";    $datas1 = "";
                for($i = 0;$i < count($repaydate); $i++ ){
                    if(NOW_DATETIME::$Date > $repaydate[$i]){}else{$datas .=",".$repaydate[$i]; $datas1 .=",".$repayamt[$i];}
                }
                $ndata = SYS_CODES::split_on($datas,1);
                $mdata1 = explode(",",$ndata[1]);
                $ndata = SYS_CODES::split_on($datas1,1);
                $mdata2 = explode(",",$ndata[1]);
                for($i = 0;$i < count($mdata1); $i++ ){
                    if(min($mdata1)==$mdata1[$i]){$rep=$mdata2[$i];}
                }
                $range = "";
                for($i = 0;$i < count($mdata1); $i++ ){
                    if(min($mdata1)==$mdata1[$i]){}else{$range .=",".$mdata1[$i];}
                }
                $rdata = SYS_CODES::split_on($range,1);
                $rdata2 = explode(",",$rdata[1]);
                echo '<tr>';
                echo '<td width="15%" data-order="2017-00-00">'.$row['disbursed_date'] . '</td>';
                echo '<td width="20%"><b> ' .$rowclient['accountname']. ' </b></td>';
                echo '<td width="20%"><b style="font-size: 18px;color: #1b9f3f;font-weight: 900">'.number_format($rowclient['loanaccount']) . '</b></td>';
                echo '<td width="25%">
                        <div class="col-md-4"><b>Amount:</b></div>
                        <div class="col-md-8">
                            <b style="font-size: 18px;color: #1b9f3f;font-weight: 900">'.number_format($rep) . '</b>
                        </div><br>
                        <div class="col-md-4"><b>Date:</b></div>
                        <div class="col-md-8"> '.min($mdata1).'&nbsp;&nbsp;
                            <button onclick="dispalyforward('.$loop.')" class="btn btn-xs btn-social btn-apple" data-toggle="tooltip" data-placement="top" title="forward repay date"><i class="fa fa-forward"></i></button>
                        </div><br>
                        <center>
                            <div id="forward'.$loop.'" hidden>
                                <b hidden id="lwr'.$loop.'">'.min($mdata1).'</b>
                                <b hidden id="grt'.$loop.'">'.min($rdata2).'</b>
                                <b hidden id="scheduleid'.$loop.'">'.$row['schudele_id'].'</b>
                                <b style="font-size: 10px;">Date Range</b>&nbsp;
                                <b style="font-size: 10px;color: #f73609">'.min($mdata1).'</b> - <b style="font-size: 10px;color: #f73609">'.min($rdata2).'</b><br>
                                <input id="forwardeddate'.$loop.'"  style="width: 50%;height: 28px">&nbsp;

                                <button onclick="hideforward('.$loop.')" class="btn btn-xs btn-social btn-info">save</button>
                                <button onclick="hideforward1('.$loop.')" class="btn btn-xs btn-social btn-danger"><i class="fa fa-close"></i></button>
                                <button onclick="resetforward('.$loop.')" data-toggle="tooltip" data-placement="top" title="rest date range" class="badge badge-info"><i class="fa fa-repeat"></i></button>
                            </div>
                        </center>
                        </td>';
                echo '<td width="20%">
                    <center>
                      <button onclick="returnschedule('.$row['desc_id'].')" data-target="#scheduleloansmodal"  data-toggle="modal" class="btn btn-social btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Disburse" type="button"><i class="fa fa-file"></i></button>
                    </center>
                  </td>';
                echo '</tr>';
                $loop++;
            }
        }

    }
    public static function POSTDUEDATE_LOANS_LIST(){
        $db = new DB(); $rep=""; $loop =  1;   NOW_DATETIME::NOW();
        foreach ($db->query("SELECT * FROM loan_approvals p,loan_schedules s WHERE s.approveid=p.desc_id AND p.decline ='0' AND p.disburse='1' ORDER BY s.disbursed_date DESC") as $row){
            foreach ($db->query("SELECT * FROM clients WHERE clientid='".$row['member_id']."'") as $rowclient) {
                $data = SYS_CODES::split_on($row['reviewdate'],1);
                $data1 = SYS_CODES::split_on($row['repay_date'],1);
                $data2 = SYS_CODES::split_on($row['total'],1);
                $reviewdate = explode(",",$data[1]);
                $repaydate = explode(",",$data1[1]);
                $repayamt = explode(",",$data2[1]);
                $datas = "";    $datas1 = "";
                for($i = 0;$i < count($repaydate); $i++ ){
                    if($repaydate[$i]==$reviewdate[$i]){}else{
                        $datas .=",".$repaydate[$i]; $datas1 .=",".$repayamt[$i];
                        echo '<tr>';
                        echo '<td width="15%" data-order="2017-00-00">'.$row['disbursed_date'] . '</td>';
                        echo '<td width="20%"><b> ' .$rowclient['accountname']. ' </b></td>';
                        echo '<td width="20%"><b style="font-size: 18px;color: #1b9f3f;font-weight: 900">'.number_format($rowclient['loanaccount']) . '</b></td>';
                        echo '<td width="25%">
                        <div class="col-md-4"><b>Amount:</b></div>
                        <div class="col-md-8">
                            <b style="font-size: 18px;color: #1b9f3f;font-weight: 900">'.number_format($repayamt[$i]) . '</b>
                        </div><br>
                        <div class="col-md-4"><b>Date:</b></div>
                        <div class="col-md-8"  style="font-size: 12px"> <b>from:</b> '.$repaydate[$i].'  <br><b>to:</b> '.$reviewdate[$i].'</div><br>

                        </td>';
                        echo '<td width="20%">
								<center>
								  <button onclick="returnschedule('.$row['desc_id'].')" data-target="#scheduleloansmodal"  data-toggle="modal" class="btn btn-social btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Disburse" type="button"><i class="fa fa-file"></i></button>
								</center>
						  	</td>';
                        echo '</tr>';
                    }
                }
                $loop++;
            }
        }

    }
    public static function PENALTYLIST(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM clients WHERE loan_fines > 0") as $row){
            echo "<tr>";
            echo "<td>".$row['accountname']."<br>".$row['accountno']."</td>";
            echo "<td>".number_format($row['loanaccount'])."</td>";
            echo "<td><b>".number_format($row['loan_fines'])."</b></td>";
            echo "</tr>";
        }
    }
    public static function PENALITIES_PAID(){
        $db = new DB();		NOW_DATETIME::NOW();
        $data = explode("?::?",$_GET["getloanrepaymentreport"]);
        $loop = "1";	$amt1 = "0";
        foreach ($db->query("SELECT SUM(s.fintot) as fines, SUM(s.finetotal) as tots FROM loan_approvals p, loan_schedules s WHERE s.fintot !='0' AND s.approveid=p.desc_id ORDER BY s.disbursed_date DESC") as $row1){		
        }
        foreach ($db->query("SELECT SUM(f.amount) as fines FROM loan_approvals p, loan_schedules s,loan_fines f WHERE s.schudele_id=f.sheduleid AND s.approveid=p.desc_id ORDER BY s.disbursed_date DESC") as $row2){		
        }
        echo'
            <table>
                    <tr style="font-weight: 800; font-family: Courier New;font-size: 25px">
                            <td>Total Paid Penalty Amount:</td>
                            <td>&nbsp;&nbsp;<b>'.number_format($row2['fines']).'<b></td>
                    <tr>
                    <tr style="font-weight: 800; font-family: Courier New;font-size: 25px">
                            <td>Total Penalty Charged Amount:</td>
                            <td>&nbsp;&nbsp;<b>'.number_format($row1['fines']).'<b></td>
                    <tr>
                    <tr style="font-weight: 800; font-family: Courier New;font-size: 25px">
                            <td>Outstanding Penalty Amount:</td>
                            <td>&nbsp;&nbsp;<b>'.number_format($row1['tots']).'<b></td>
                    <tr>
            </table><br>
        ';
        echo '
            <table id="example" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
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
        foreach ($db->query("SELECT * FROM loan_approvals p, loan_schedules s,loan_fines f WHERE s.schudele_id=f.sheduleid AND s.approveid=p.desc_id ORDER BY f.inserted_date DESC") as $row){
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
}

class LOAN_APPRASAILS extends database_crud{
    protected $table = 'loan_appraisal';
    protected $pk = 'appraisal_id';

    // SELECT `appraisal_id`, `ln_officer`, `clientid`, `loan_id`, `place_birth`, `proj_type`, `proj_age`,
    // `proj_loc`, `residence`, `residate`, `proposed_instal`, `honesty`, `repay_hist`, `time_in_area`,
    // `new_applnt_from`, `residence_status`, `no_ofhousehousde`, `no_children`, `ease_migrat`, `sale_prod`,
    // `sale_animal_pro`, `ani_sales`, `salary`, `bldg`, `others`, `total`, `food`, `medicine`, `clothing`,
    // `school_fees`, `transport`, `utility`, `entertainment`, `others_2`, `ttl_1`, `dis_amt`, `behave_savg`,
    // `avg_monnthly_saving`, `prev_loan`, `savg_bal`, `cond_avail`, `bus_season`, `social_obligation`,
    // `col_offer`, `val_own`, `ln_off_val`, `insertion_date`, `status`, `dateadded` FROM `loan_appraisal` WHERE 1

    static $sql1 = "SELECT * FROM loan_application1 s, loan_appraisal a WHERE a.loan_id = s.loan_id";
    public static function loan_appraisal(){
        $launch_appraisal = new LOAN_APPRASAILS();  $db = new DB();
        $data = explode("?::?",$_GET['saveloanappraisaldata']);

        foreach ($db->query("SELECT * FROM loan_appraisal WHERE chartid='".$data[3]."'") as $row1){
            $chartid = $row1['appraisal_id'];
        }
        $launch_appraisal->ln_officer  = $data[0];              $launch_appraisal->clientid  = $data[1];
        $launch_appraisal->loan_id  = $data[2];                	$launch_appraisal->chartid  = $data[3];
	$launch_appraisal->proj_type  = $data[4];
        $launch_appraisal->proj_age  = $data[5];                $launch_appraisal->proj_loc  = $data[6];
        $launch_appraisal->honesty  = $data[7];                 $launch_appraisal->repay_hist  = $data[8];
        $launch_appraisal->time_in_area  = $data[9];           	$launch_appraisal->new_applnt_from  = $data[10];
        $launch_appraisal->residence_status  = $data[11];       $launch_appraisal->no_ofhousehousde  = $data[12];
        $launch_appraisal->no_children  = $data[13];            $launch_appraisal->ease_migrat  = $data[14];
        $launch_appraisal->sale_prod  = $data[15];              $launch_appraisal->sale_animal_pro  = $data[16];
        $launch_appraisal->ani_sales  = $data[17];              $launch_appraisal->salary  = $data[18];
        $launch_appraisal->bldg  = $data[19];                   $launch_appraisal->others  = $data[20];
        $launch_appraisal->total  = $data[21];                  $launch_appraisal->food  = $data[22];
        $launch_appraisal->medicine  = $data[23];               $launch_appraisal->clothing  = $data[24];
        $launch_appraisal->school_fees  = $data[25];            $launch_appraisal->transport  = $data[26];
        $launch_appraisal->utility  = $data[27];                $launch_appraisal->entertainment  = $data[28];
        $launch_appraisal->others_2  = $data[29];               $launch_appraisal->ttl_1  = $data[30];
        $launch_appraisal->dis_amt  = $data[31];                $launch_appraisal->behave_savg  = $data[32];
        $launch_appraisal->avg_monnthly_saving  = $data[33];    $launch_appraisal->prev_loan  = $data[34];
        $launch_appraisal->savg_bal  = $data[35];               $launch_appraisal->cond_avail  = $data[36];
        $launch_appraisal->bus_season  = $data[37];             $launch_appraisal->social_obligation  = $data[38];
        $launch_appraisal->col_offer  = $data[39];              $launch_appraisal->val_own  = $data[40];
        $launch_appraisal->ln_off_val  = $data[41];             $launch_appraisal->new_applnt_from  = $data[42];
        $launch_appraisal->no_ofshares  = $data[43];
        $launch_appraisal->actual_savg  = $data[44];
		
        if($chartid){
            $launch_appraisal->appraisal_id = $chartid;
            $launch_appraisal->save();
        }else{
            foreach ($db->query("SELECT * FROM post_chart WHERE chartid='".$data[3]."'")as $row){}
            if($row['loan_tag']=="3" || $row['loan_tag']=="2"){}else{$db->query("UPDATE post_chart SET loan_tag='2' WHERE chartid='".$data[3]."'");}
            $launch_appraisal->create();
        }

        foreach ($db->query("SELECT * FROM post_chart WHERE chartid='".$data[3]."'")as $row){
            if($row['loan_tag']=="3"){
                echo '
                <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr>
                            <th width="10%">Date</th>
                            <th width="10%">Account Name</th>
                            <th width="20%">Amount Applied For</th>
                            <th width="20%">Approved Amount</th>
                            <th width="20%">Committee\'s Decision </th >
                            <th width = "20%" > Action</th >
                        </tr >
                    </thead >
                    <tbody >
                ';  LOAN_PROCESSCLASS::GET_APPROVEDLOANS();    echo '
                    </tbody>
                </table>
                ';
                echo '|<><>|';
                echo 'hello';
            }
            if($row['loan_tag']=="2"){
                echo '
                    <table id="example" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                        <thead>
                            <tr>
                                <th width="20%">Date</th>
                                <th width="30%">Account Name</th>
                                <th width="30%">Application Details</th>
                                <th width="20%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            ';  LOAN_PROCESSCLASS::GET_CLIENTLOAN_APPLICATION();    echo '
                        </tbody>
                    </table>
                ';
            }
        }

    }
}

class LOAN_APPROVAL extends database_crud{
    protected $table = "loan_approvals";
    protected $pk = "desc_id";
    //SELECT `desc_id`, `member_id`, `loan_id`, `appras_id`, `ded_amt`, `o_lnamt`, `o_lnprd`,
    // `o_lntype`, `o_lninterest`, `o_graceprd`, `o_desc`, `m_lnamt`, `m_lnprd`, `m_lntype`,
    // `m_lninterest`, `m_graceprd`, `m_desc`, `c_desc`, `c_amt`, `c_prd`, `c_rsn_desc`, `status`,
    // `npmts`, `mrate`, `tpmnt`, `tint`, `pmnt`, `insertion_date` FROM `loan_approvals` WHERE 1
}

class LOAN_DISBURSEMENT extends database_crud{
    protected $table="loan_schedules";
    protected $pk="schudele_id";
    //SELECT `schudele_id`, `approveid`, `disbursed_date`, `repay_date`, `principal`, `interest`, `total`, `bal_bef`, `bal_aft`,
    // `insertion_date` FROM `loan_schedules` WHERE 1
    static $clientid;   static $chargefees;
    public static function Generate_Repay_schedule(){
        $db = new DB(); GENERAL_SETTINGS::GEN();    $schedule = new  LOAN_DISBURSEMENT();
        $merge = new MERGERWD();
        foreach ($db->query("SELECT * FROM loan_approvals a,loan_application1 n WHERE n.loan_id=a.loan_id AND a.decline !='1' AND a.desc_id = '".$_GET['loanschedule']."' ORDER BY insertion_date DESC") as $row){
            foreach ($db->query("SELECT * FROM clients WHERE clientid='".$row['member_id']."'")as $rowclient){}
            foreach ($db->query("SELECT * FROM accounttypes WHERE typeid='".$row['type_of_loan']."'")as $rowloan){}
            //            if($row[]){}
            
        }
        
        $principal = "";    $interest = "";   $total = "";    $balance_before = "";     $balance_after = "";
        $date = "";         $incr = $rowloan['period'] + 1;                    $totalloan = "";
        $princ = "";        $intt = "";   $tot = "";    $bal_bef = "";     $bal_aft = "";  $dated = "";
        NOW_DATETIME::NOW();
        $date = new DateTime(NOW_DATETIME::$Date);

        if($row['repayment_schedule'] =="1"){
            $interval =new DateInterval('P'.$incr.'M');
            $interval1 =new DateInterval('P1M');
        }
        if($row['repayment_schedule']=="2"){
            $interval =new DateInterval('P7D');
            $interval1 =new DateInterval('P7D');
        }
       
        if ($row['status'] == "3") {
            $loan_amount =  $row['c_amt'];
            $period =  $row['c_prd'];
        }
        if ($row['status'] == "4") {

        }
        if ($row['status'] == "5") {
            $loan_amount = $row['c_amt'];
            $period =  $row['c_prd'];
        }
        if ($row['status'] == "6") {
            $loan_amount = $row['c_amt'];
            $period =  $row['c_prd'];
        }
        if ($row['status'] == "7") {
            $loan_amount = $row['c_amt'];
            $period =  $row['c_prd'];
        }

        $la = $loan_amount;    $ir = $rowloan['interest']/100;  $pr = $period;
        $totalloan = $la;

        foreach ($db->query("SELECT * FROM loan_schedules WHERE approveid = '".$_GET['loanschedule']."'") as $rowlnsch){}
        foreach ($db->query("SELECT * FROM loan_approvals a,loan_schedules n WHERE n.approveid=a.desc_id AND a.decline !='1' AND a.desc_id = '".$_GET['loanschedule']."'") as $rowgrant){}
        $db->query("UPDATE loan_approvals SET disburse='1' WHERE desc_id = '".$_GET['loanschedule']."'");
        $db->query("UPDATE loan_schedules SET disbursed_date='".$row['dateexpected']."' WHERE approveid = '".$_GET['loanschedule']."'");
        $db->query("UPDATE clients SET loanaccount=loanaccount+'".$totalloan."' , savingaccount=savingaccount+'".$loan_amount."' WHERE clientid = '".$rowclient['clientid']."'");
        $db->query("UPDATE clients SET loan_interest = loan_interest+'".$rowlnsch['totalinterest']."' WHERE clientid = '".$rowclient['clientid']."'");
        CLIENT_DATA::$clientid =  $rowclient['clientid'];   CLIENT_DATA::CLIENTDATAMAIN();
        $schedule->approveid  =  $_GET['loanschedule'];
        

        $merge->transactiontype = "3";
        $merge->transactionid = $rowlnsch['schudele_id'];
        $merge->insertiondate = NOW_DATETIME::$Date;
        $merge->clientid = $rowclient['clientid'];
        $merge->create();

        $insfund = (GENERAL_SETTINGS::$loan_insurancefund/100)*$loan_amount;
        $db->query("UPDATE clients SET savingaccount=savingaccount-'".$insfund."' WHERE clientid = '".$rowclient['clientid']."'");
        CLIENT_DATA::$clientid =  $rowclient['clientid'];   CLIENT_DATA::CLIENTDATAMAIN();
        NOW_DATETIME::NOW();
        LOAN_INSURANCE::$inserted_date = NOW_DATETIME::$Date_Time;
        LOAN_INSURANCE::$sheduleid = $rowlnsch['schudele_id'];
        LOAN_INSURANCE::$amount    = $insfund;
        LOAN_INSURANCE::$balance   = CLIENT_DATA::$savingaccount;
        LOAN_INSURANCE::SAVE_INSURANCE();

        $merge->transactiontype = "4";
        $merge->transactionid = LOAN_INSURANCE::$ins_id;
        $merge->insertiondate = NOW_DATETIME::$Date;
        $merge->clientid = $rowclient['clientid'];
        $merge->create();

        GENERAL_SETTINGS::GEN();
        $charges = (GENERAL_SETTINGS::$loanprocessfees/100)*$loan_amount;
        $db->query("UPDATE clients SET savingaccount = savingaccount-'".$charges."' WHERE clientid = '".$rowclient['clientid']."'");
        CLIENT_DATA::$clientid =  $rowclient['clientid'];   CLIENT_DATA::CLIENTDATAMAIN();
        static::$clientid = $rowclient['clientid'];     static::$chargefees = $charges;
        LOAN_PROCESSCHARGES::$inserted_date = NOW_DATETIME::$Date_Time;
        LOAN_PROCESSCHARGES::$sheduleid = $rowlnsch['schudele_id'];
        LOAN_PROCESSCHARGES::$amount    = $charges;
        LOAN_PROCESSCHARGES::$balance   = CLIENT_DATA::$savingaccount;
        LOAN_PROCESSCHARGES::SAVE_PROCESSCHARGE();


        $merge->transactiontype = "5";
        $merge->transactionid = LOAN_PROCESSCHARGES::$charge_id;
        $merge->insertiondate = NOW_DATETIME::$Date;
        $merge->clientid = $rowclient['clientid'];
        $merge->create();

        GENERAL_SETTINGS::GEN();
        $charges = GENERAL_SETTINGS::$legalfees;
        $db->query("UPDATE clients SET savingaccount = savingaccount-'".$charges."' WHERE clientid = '".$rowclient['clientid']."'");
        CLIENT_DATA::$clientid =  $rowclient['clientid'];   CLIENT_DATA::CLIENTDATAMAIN();
        static::$clientid = $rowclient['clientid'];     static::$chargefees = $charges;
        LEGALFEES::$inserted_date = NOW_DATETIME::$Date_Time;
        LEGALFEES::$sheduleid = $rowlnsch['schudele_id'];
        LEGALFEES::$amount    = GENERAL_SETTINGS::$legalfees;
        LEGALFEES::$balance   = CLIENT_DATA::$savingaccount;
        LEGALFEES::SAVE_PROCESSCHARGE();

        $merge->transactiontype = "7";
        $merge->transactionid = LOAN_PROCESSCHARGES::$charge_id;
        $merge->insertiondate = NOW_DATETIME::$Date;
        $merge->clientid = $rowclient['clientid'];
        $merge->create();

        echo
        '<table id="grat2" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered table-striped m-n">
                <thead>
                    <tr class="success">
                        <th width="25%">Date</th>
                        <th width="25%">Account Name</th>
                        <th width="25%">Loan Amount</th>
                        <th width="25%">Disburse Loan</th>
                    </tr>
                </thead>
                <tbody>
                    ';  LOAN_PROCESSCLASS::APPROVED_LOANS();  echo '
                </tbody>
            </table>';

        echo '|<><>|';
        echo '
            <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered table-striped m-n">
                <thead>
                    <tr class="danger">
                        <th width="25%">Date</th>
                        <th width="25%">Account Name</th>
                        <th width="25%">Loan Amount</th>
                        <th width="25%">Repayment Schedule</th>
                    </tr>
                </thead>
                <tbody>
                    ';  LOAN_PROCESSCLASS::DISBURSED_LOANS();  echo '
                </tbody>
            </table>
        ';
    }
    public static function Return_Repay_schedule(){
        $db = new DB();

        foreach ($db->query("SELECT * FROM loan_schedules WHERE approveid = '".$_GET['returnloanschedule']."'") as $row){
            foreach ($db->query("SELECT * FROM loan_approvals a,loan_application1 n WHERE n.loan_id=a.loan_id AND a.desc_id = '".$_GET['returnloanschedule']."'") as $rowclient){}
        }
        $repaydate = explode(",",$row['repay_date']);
        $principal = explode(",",$row['principal']);
        $interest= explode(",",$row['interest']);
        $total = explode(",",$row['total']);
        $balance_before = explode(",",$row['bal_bef']);
        $balance_after = explode(",",$row['bal_aft']);
        CLIENT_DATA::$clientid = $rowclient['member_id'];   CLIENT_DATA::CLIENTDATAMAIN();

        echo '
            <div class="col-md-6 col-md-offset-3">
            <center><button class="btn btn-social btn-facebook" onclick="PrintElem(\'printableArea\',\'Loan Schedule\')"><i class="fa fa-print"></i> PRINT LOAN SCHEDULE</button><br><br></center>
            </div>
			<div id="printableArea">
			<div class="col-md-6 col-md-offset-3">
				<div class="alert alert-inverse">
					<center>
						<table>
							<tr>
								<td><label>'.CLIENT_DATA::$accountname.'</label></td>
								<td>&nbsp;&nbsp;'.CLIENT_DATA::$accountno.'</td>
							</tr>
							<tr>
								<td><label style="color: grey;font-size: 13px;">Amount Disbursed: </label></td>
								<td><b style="color: black">&nbsp;&nbsp;'.number_format($row['amount_given']).'</b></td>
							</tr>
							<tr>
								<td><label style="color: grey;font-size: 13px;">Interest: </label></td>
								<td><b style="color: black">&nbsp;&nbsp;'.number_format($row['amount_disb']-$row['amount_given']).'</b></td>
							</tr>
							<tr>
								<td><label style="color: grey;font-size: 13px;">Period: </label></td>
								<td><b style="color: black">&nbsp;&nbsp;'.$row['period'].(($rowclient['repayment_schedule']=="1")?"  months":"Weeks").'</b></td>
							</tr>
						</table>
					</center>
				</div>
			</div>
            <br><br><br>
            <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered  m-n">
                <thead>
                    <tr>
                        <th width="15%">Repay Date</th>
                        <th width="15%">principal</th>
                        <th width="15%">interest</th>
                        <th width="15%">total</th>
                        <th width="20%">balance before</th>
                        <th width="20%">balance after</th>
                    </tr>
                </thead>
                <tbody>
        ';
        for($i = 1;$i < count($principal); $i++ ){
            echo '<tr>';
            echo '<td><b>'.$repaydate[$i].'</b></td>';
            echo '<td>'.number_format($principal[$i]).'</td>';
            echo '<td>'.number_format($interest[$i]).'</td>';
            echo '<td>'.number_format($total[$i]).'</td>';
            echo '<td>'.number_format($balance_before[$i]).'</td>';
            echo '<td>'.number_format($balance_after[$i]).'</td>';
            echo '</tr>';

        }
        echo '
                </tbody>
            </table>
		</div>
        ';
    }
    public static function SAVE_POSTDUEDATE_LOANS(){
        $db = new DB(); $repo=""; $loop =  1;   NOW_DATETIME::NOW();
        $post = explode("?::?",$_GET['savepostponeduedate']);
        foreach ($db->query("SELECT * FROM loan_schedules WHERE schudele_id ='".$post[3]."'") as $row){
            $data = SYS_CODES::split_on($row['reviewdate'],1);
            $repaydate = explode(",",$data[1]);
            for($i = 0;$i < count($repaydate); $i++ ){
                if($repaydate[$i]==$post[0] &&  $post[2] < $repaydate[$i]) {
                    echo 1;
                }elseif ($repaydate[$i]==$post[1] &&  $post[2] > $repaydate[$i]){
                    echo 1;
                }else{
                    if($post[2] <= $post[1] && $post[2] >= $post[0]){$repo='1';}else{}
                }
            }
            if($repo){
                $datas = "";
                for($i = 0;$i < count($repaydate); $i++ ){
                    if($repaydate[$i]==$post[0] ){ $datas .=",".$post[2];}else{$datas .=",".$repaydate[$i];}
                }
                $db->query("UPDATE loan_schedules SET reviewdate='".$datas."' WHERE schudele_id ='".$post[3]."'");
                echo '
                    <table cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                        <thead>
                            <tr>
                                <th width="20%">Date</th>
                                <th width="20%">Account Name</th>
                                <th width="20%">Loan Balance</th>
                                <th width="20%">Next Payment</th>
                                <th width="20%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            ';  LOAN_PROCESSCLASS::POSTDUEDATE_LOANS();  echo '
                        </tbody>
                    </table>
                ';
                echo '|<><>|';
                echo '
                <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr>
                            <th width="20%">Date</th>
                            <th width="20%">Account Name</th>
                            <th width="20%">Loan Balance</th>
                            <th width="20%">Next Payment</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        ';  LOAN_PROCESSCLASS::POSTDUEDATE_LOANS_LIST();  echo '
                    </tbody>
                </table>
             ';
            }

        }
    }
    public static function RESET_POSTDUEDATE_LOANS(){
        $db = new DB(); $repo=""; $loop =  1;   NOW_DATETIME::NOW();
        $post = explode("?::?",$_GET['restpostponeduedate']);
        foreach ($db->query("SELECT * FROM loan_schedules WHERE schudele_id ='".$post[3]."'") as $row){
            $data = SYS_CODES::split_on($row['reviewdate'],1);
            $reviewdate = explode(",",$data[1]);
            $repaydate1 = SYS_CODES::split_on($row['repay_date'],1);
            $repaydate = explode(",",$repaydate1[1]);
            $datas = "";
            for($i = 0;$i < count($repaydate); $i++ ){
                if($reviewdate[$i]==$post[0]) {
                    $datas .=",".$repaydate[$i];
                }else{
                    $datas .=",".$reviewdate[$i];
                }
            }
            $db->query("UPDATE loan_schedules SET reviewdate='".$datas."' WHERE schudele_id ='".$post[3]."'");

            echo '
                <table id="grat2" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr>
                            <th width="20%">Date</th>
                            <th width="20%">Account Name</th>
                            <th width="20%">Loan Balance</th>
                            <th width="20%">Next Payment</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        ';  LOAN_PROCESSCLASS::POSTDUEDATE_LOANS();  echo '
                    </tbody>
                </table>
            ';
            echo '|<><>|';
            echo '
                <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr>
                            <th width="20%">Date</th>
                            <th width="20%">Account Name</th>
                            <th width="20%">Loan Balance</th>
                            <th width="20%">Next Payment</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        ';  LOAN_PROCESSCLASS::POSTDUEDATE_LOANS_LIST();  echo '
                    </tbody>
                </table>
             ';


        }
    }
    public static function DISBURSEMENT_DETAIL(){
        $db = new DB();  NOW_DATETIME::NOW();
        foreach ($db->query("SELECT * FROM loan_schedules s, loan_approvals a WHERE a.desc_id=s.approveid AND a.desc_id = '".$_GET['disbursedetail']."'") as $row){}
        echo '
                <center><button onclick="PrintElem(\'disburseprt\',\'Client Disbursement Detail\')" class="btn btn-social btn-facebook"><i class="fa fa-print"></i> PRINT DISBURSEMENT DETAIL</button><br><br></center>
                <br><br>
				<div id="disburseprt">
                <table width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <tr>
                        <td width="50%">Total Principal</td>
                        <td width="50%"><b>'.number_format($row['amount_given']).'</b></td>
                    </tr>
                    <tr>
                        <td width="50%">Total Interest</td>
                        <td width="50%"><b>'.number_format($row['amount_disb']-$row['amount_given']).'</b></td>
                    </tr>
                    <tr>
                        <td width="50%"><b>Total Loan Amount</b></td>
                        <td width="50%"><b class="pull-right">'.number_format($row['amount_disb']).'</b></td>
                    </tr>
                </table>
                <center><b><h4 style="font-weight: 900"> Deductions</h4></b><br></center>
            ';
        foreach ($db->query("SELECT * FROM loan_insurance WHERE sheduleid = '".$row['schudele_id']."'") as $rowi){}
        foreach ($db->query("SELECT * FROM loan_processcharges WHERE sheduleid = '".$row['schudele_id']."'") as $rowc){}
        foreach ($db->query("SELECT * FROM legal_fees WHERE sheduleid = '".$row['schudele_id']."'") as $rowl){}
        echo '
                <table width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <tr>
                        <td width="40%">Loan Protection Fund</td>
                        <td width="60%"><b>'.number_format($rowi['amount']).'</b></td>
                    </tr>
                    <tr>
                        <td width="50%">Loan Process Fees</td>
                        <td width="50%"><b>'.number_format($rowc['amount']).'</b></td>
                    </tr>
                    <tr>
                        <td width="50%">Legal Fees</td>
                        <td width="50%"><b>'.number_format($rowl['amount']).'</b></td>
                    </tr>
                    <tr>
                        <td width="50%"><b>Amount Deposit on Savings Account</b></td>
                        <td width="50%"><b class="pull-right">'.number_format($row['amount_given']-($rowi['amount']+$rowc['amount']+$rowl['amount'])).'</b></td>
                    </tr>
                </table>
				</div>
            ';
    }
}

class LOAN_INSURANCE extends database_crud{
    protected $table="loan_insurance";
    protected $pk="ins_id";

    //SELECT `ins_id`, `sheduleid`, `amount`, `balance`, `inserted_date` FROM `loan_insurance` WHERE 1
    public static $sheduleid;       public static $amount;  public static $balance;
    public static $inserted_date;   public static $ins_id;

    public static function SAVE_INSURANCE(){
        $insurance = new LOAN_INSURANCE();
        $insurance->sheduleid = static::$sheduleid;
        $insurance->amount    = static::$amount;
        $insurance->balance   = static::$balance;
        $insurance->inserted_date = static::$inserted_date;
        $insurance->create();
        static::$ins_id  = $insurance->pk;
    }
}

class LOAN_FINES extends database_crud{
    protected $table="loan_fines";
    protected $pk="finne_id";

    public static $sheduleid;       public static $amount;  public static $balance;
    public static $inserted_date;   public static $ins_id;

    public static function SAVE_FINES(){
        $fines = new LOAN_FINES();
        $fines->sheduleid = static::$sheduleid;
        $fines->amount    = static::$amount;
        $fines->balance   = static::$balance;
        $fines->inserted_date = static::$inserted_date;
        $fines->create();
        static::$ins_id  = $fines->pk;
    }
}

class LOANINTEREST extends database_crud{
    protected $table="loan_interest";
    protected $pk="id";
}

class OTHER_CHARGESTRANSACTIONS extends database_crud{
    protected $table="other_chargestracs";
    protected $pk="charge_id";

    //SELECT `charge_id`, `otherid`, `amount`, `clientid`, `inserted_date` FROM `other_chargestracs` WHERE 1
}

class LOAN_PROCESSCHARGES extends database_crud{
    protected $table="loan_processcharges";
    protected $pk="charge_id";

    //SELECT `charge_id`, `sheduleid`, `amount`, `balance`, `inserted_date` FROM `loan_processcharges` WHERE 1
    public static $sheduleid;       public static $amount;  public static $balance;
    public static $inserted_date;   public static $charge_id;

    public static function SAVE_PROCESSCHARGE(){
        $charge = new LOAN_PROCESSCHARGES();
        $charge->sheduleid = static::$sheduleid;
        $charge->amount    = static::$amount;
        $charge->balance   = static::$balance;
        $charge->inserted_date = static::$inserted_date;
        $charge->create();
        static::$charge_id  = $charge->pk;
    }
}

class LEGALFEES extends database_crud{
    protected $table="legal_fees";
    protected $pk="charge_id";

    //SELECT `charge_id`, `sheduleid`, `amount`, `balance`, `inserted_date` FROM `loan_processcharges` WHERE 1
    public static $sheduleid;       public static $amount;  public static $balance;
    public static $inserted_date;   public static $charge_id;

    public static function SAVE_PROCESSCHARGE(){
        $charge = new LEGALFEES();
        $charge->sheduleid = static::$sheduleid;
        $charge->amount    = static::$amount;
        $charge->balance   = static::$balance;
        $charge->inserted_date = static::$inserted_date;
        $charge->create();
        static::$charge_id  = $charge->pk;
    }
}

class LOAN_REPAYMENT extends database_crud{
    protected $table="loan_repayment";
    protected $pk="loan_rpid";

    //SELECT `loan_rpid`, `sheduleid`, `repay_type`, `amount`, `loanbals`, `inserted_date` FROM `loan_repayment` WHERE 1
    public static $sheduleid;       public static $amount;      public static $loanbal;
    public static $inserted_date;   public static $loan_rpid;   public static $repay_type;

    public static function REPAYMENT_LIST(){
        $db = new  DB();
        foreach ($db->query("SELECT * FROM loan_repayment p, loan_schedules s, loan_approvals a WHERE a.desc_id=s.approveid AND s.schudele_id=p.sheduleid  ORDER BY p.inserted_date DESC") as $row){
            CLIENT_DATA::$clientid = $row['member_id'];
            CLIENT_DATA::CLIENTDATAMAIN();
            echo "<tr>";
            echo "<td data-order='2017-00-00'>".$row['inserted_date']."</td>";
            echo "<td>".CLIENT_DATA::$accountname."</td>";
            echo "<td><b>".number_format($row['amount'])."</b></td>";
            echo "<td>".number_format($row['princbal'])."</td>";
            echo "<td>".number_format($row['interestbal'])."</td>";
            echo "<td><b>".number_format($row['loanbals'])."</b></td>";
            echo '<td>
                    <center>
                      <button onclick="returnloanledger('.$row['desc_id'].')" data-target="#loanledgermodal"  data-toggle="modal" class="btn btn-social btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Loan Ledger" type="button"><i class="fa fa-file"></i></button>
                    </center>
                  </td>';
            echo '</tr>';
            echo "</tr>";
        }
    }
	
    public static function TODAY_REPAYMENT_LIST(){
        $db = new DB(); $rep=""; $loop =  1;   NOW_DATETIME::NOW();
        foreach ($db->query("SELECT * FROM loan_approvals p,loan_schedules s WHERE s.approveid=p.desc_id AND p.decline ='0' AND p.disburse='1' ORDER BY s.disbursed_date DESC") as $row){
            foreach ($db->query("SELECT * FROM clients WHERE clientid='".$row['member_id']."'") as $rowclient) {
                $data = SYS_CODES::split_on($row['reviewdate'],1);
                $data1 = SYS_CODES::split_on($row['paycheck'],1);
                $data2 = SYS_CODES::split_on($row['total'],1);
                $repaydate = explode(",",$data[1]);
                $repaycheck = explode(",",$data1[1]);
                $repayamt = explode(",",$data2[1]);
                $datas = "";    $datas1 = "";
				
                for($i = 0;$i < count($repaydate); $i++ ){
                    if($repaydate[$i] == NOW_DATETIME::$Date){
						echo '<tr>';
						echo '<td width="15%" data-order="2017-00-00">'.$repaydate[$i] . '</td>';
						echo '<td width="20%"><b> ' .$rowclient['accountname']. ' </b></td>';
						echo '<td width="20%"><b style="font-size: 18px;color: #1b9f3f;font-weight: 900">'.number_format($repayamt[$i]) . '</b></td>';
						echo '</tr>';
					}
                }
             
                $loop++;
            }
        }
    }

    public static function Return_LoanLedger(){
        $db = new DB();

        foreach ($db->query("SELECT * FROM loan_repayment p, loan_schedules s, loan_approvals a WHERE a.desc_id=s.approveid AND s.schudele_id=p.sheduleid AND a.desc_id = '".$_GET['returnloanledger']."'  ORDER BY p.inserted_date DESC") as $row){}
        CLIENT_DATA::$clientid = $row['member_id'];   CLIENT_DATA::CLIENTDATAMAIN();

        echo '
            <div class="col-md-6 col-md-offset-3">
            <center><button onclick="printLoanLedger()" class="btn btn-social btn-facebook"><i class="fa fa-print"></i> PRINT LOAN LEDGER</button><br><br></center>
            </div>
            <div id="loanledger">
            <div class="col-md-6 col-md-offset-3">
            <div class="alert alert-inverse">
				<center>
                    <table>
                        <tr>
                            <td><label>'.CLIENT_DATA::$accountname.'</label></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><label style="color: grey;font-size: 13px;">Amount Disbursed: </label></td>
                            <td><b style="color: black">&nbsp;&nbsp;'.number_format($row['amount_given']).'</b></td>
                        </tr>
                        <tr>
                            <td><label style="color: grey;font-size: 13px;">Interest: </label></td>
                            <td><b style="color: black">&nbsp;&nbsp;'.number_format($row['amount_disb']-$row['amount_given']).'</b></td>
                        </tr>
                        <tr>
                            <td><label style="color: grey;font-size: 13px;">Loan Balance: </label></td>
                            <td><b style="color: black">&nbsp;&nbsp;'.number_format(CLIENT_DATA::$loanaccount).'</b></td>
                        </tr>
                        <tr>
                            <td><label style="color: grey;font-size: 13px;">Period: </label></td>
                            <td><b style="color: black">&nbsp;&nbsp;'.$row['period'].'  months</b></td>
                        </tr>
                    </table>
				</center>
			</div>
			</div>
            <br><br><br>
            <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr>
                        <th width="15%">Payment Date</th>
                        <th width="20%">Paid Amount</th>
                        <th width="20%">Interest Balance</th>
                        <th width="20%">Principal Balance </th>
                        <th width="25%">Total Loan Balance</th>
                    </tr>
                </thead>
                <tbody>
            ';
        foreach ($db->query("SELECT * FROM loan_repayment p, loan_schedules s, loan_approvals a WHERE a.desc_id=s.approveid AND s.schudele_id=p.sheduleid AND a.desc_id = '".$_GET['returnloanledger']."'  ORDER BY p.inserted_date DESC") as $row){
            echo '<tr>';
            echo '<td><b>'.$row['inserted_date'].'</b></td>';
            echo '<td>'.number_format($row['amount']).'</td>';
            echo '<td>'.number_format($row['interestbal']).'</td>';
            echo '<td>'.number_format($row['princbal']).'</td>';
            echo '<td>'.number_format($row['loanbals']).'</td>';
            echo '</tr>';
        }
        echo '
                </tbody>
            </table>
            </div>
        ';


    }
}

class WRITEOFF_REPAY extends database_crud{
	protected $table = "loanwriteoff_repay";
	protected $pk = "reapayid";
	// SELECT `reapayid`, `offid`, `ramount`, `bal`,'sbal', `rdate`, `rtime` FROM `loanwriteoff_repay` WHERE 1
	
	public static function REPAY_WRITEOFF(){
		$data = explode("?::?" , $_GET['repaywriteoffloan']);
		$repay = new WRITEOFF_REPAY();		NOW_DATETIME::NOW(); session_start();
		$db = new DB();		$merge = new MERGERWD();
		foreach ($db->query("SELECT * FROM clients WHERE clientid = '".$data[3]."'") as $row){$savingbalnce = $row['savingaccount'];}
		$repay->offid		= $data[0];
		$repay->ramount		= $data[1];
		$repay->sbal		= $savingbalnce;
		$repay->bal			= ".($data[2]-$data[1]).";
		$repay->rdate		= NOW_DATETIME::$Date;
		$repay->rtime		= NOW_DATETIME::$Time;
		$repay->user_handle	= $_SESSION['user_id'];
		$repay->create();
		
		$merge->transactiontype = "10";
        $merge->transactionid = $repay->pk;
        $merge->insertiondate = NOW_DATETIME::$Date_Time;
        $merge->clientid = $data[3];
        $merge->create();
		
		
		$db->query("UPDATE loanwriteoff SET balance = '".($data[2]-$data[1])."' WHERE offid = '".$data[0]."'");
		$db->query("UPDATE clients SET loanaccount = loanaccount - '".$data[1]."' WHERE clientid = '".$data[3]."'");
		
		if(($data[2]-$data[1]) == "0"){
			foreach ($db->query("SELECT * FROM loanwriteoff s, loanwriteoff_repay r, loan_approvals a, loan_schedules l WHERE s.offid=r.offid AND a.desc_id=s.approveid AND l.approveid=a.desc_id AND s.offid='".$data[0]."'") as $rows){}
			$data1 = SYS_CODES::split_on($rows['paycheck'],1);
			$repaycheck = explode(",",$data1[1]);
			$finastat = "";
			for($i = 0;$i < count($repaycheck); $i++ ){
				$finastat = $finastat .",1";
			}
			$db->query("UPDATE clients SET writeoffstatus = '0' WHERE clientid = '".$data[3]."'");
			$db->query("UPDATE loan_schedules SET loanstatus = '1', totalprinc = '0', totalinterest = '0', paycheck = '".$finastat."' WHERE approveid = '".$rows['desc_id']."'");
		}
		LOAN_WRITEOFF::REPAY_WRITE_OFF_LIST();
	} 
}

class LOAN_WRITEOFF extends database_crud{
	protected $table = "loanwriteoff";
	protected $pk = "offid";
	// SELECT `offid`, `approveid`, `loan_balance`, `balance`, `status`, `odate`, `otime` FROM `loanwriteoff` WHERE 1
	public static function WRITE_OFF(){
		$data = $_GET['writeoffloan']; 	
		$db = new DB(); 
		$write = new LOAN_WRITEOFF();	NOW_DATETIME::NOW(); session_start();
		
		foreach ($db->query("SELECT * FROM loan_schedules s, loan_approvals a WHERE a.desc_id = s.approveid AND a.desc_id='".$data."'") as $row){
			$write->approveid       = $data;
			$write->loan_balance	= $row['totalprinc']+$row['totalinterest'];
			$write->balance			= $row['totalprinc']+$row['totalinterest'];
			$write->status			= "0";
			$write->odate			= NOW_DATETIME::$Date;
			$write->otime			= NOW_DATETIME::$Time;
			$write->user_handle		= $_SESSION['user_id'];
			$write->create();
			$db->query("UPDATE loan_approvals SET disburse = '3' WHERE desc_id = '".$data."'");
			$db->query("UPDATE clients SET writeoffstatus = '1' WHERE clientid = '".$row['member_id']."'");
			$lnamts1  = "";
			foreach($db->query("SELECT MONTH(s.disbursed_date) as mnth, YEAR(s.disbursed_date) as yr FROM loan_schedules s, loan_approvals a WHERE a.desc_id = s.approveid AND a.desc_id='".$data."'") as $rowoff){
				foreach($db->query("SELECT * FROM loananalysis WHERE year='".$rowoff['yr']."'") as $rowd){
					$amts1 = explode(",",$rowd['months']);
					$mny = explode(",",$rowd['loanbals']);
					
					for($i=1;$i<=count($amts1);$i++){
						
						if($amts1[$i] >= $rowoff['mnth']){
							$lnamts1 = $lnamts1.",".($mny[$i]-($amount_disb));
						}else{
							$lnamts1 = $lnamts1.",".$mny[$i];
						}
						$db->query("UPDATE loananalysis SET loanbals = '".$lnamts1."' WHERE year='".$rowoff['yr']."'");
					}
				}
			}
			
			self::WRITE_OFF_LIST();
			echo '|<><>|';
			self::REPAY_WRITE_OFF_LIST();
		}
		
		
	}
	public static function WRITE_OFF_LIST(){
		$db = new DB();  NOW_DATETIME::NOW();
		$year = explode("?::?",$_GET["getloananalysisreport"]);
		$loop = "1";
		echo '
			<table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
				<thead>
					<tr>
						<th width="30%">Acount Detail</th>
						<th width="30%">Loan Balance</th>
						<th width="30%">Ageing Period</th>
						<th width="10%">Action</th>
					</tr>
				</thead>
				<tbody>';
				foreach ($db->query("SELECT * FROM loan_schedules s, loan_approvals a WHERE a.desc_id = s.approveid AND a.disburse !='3'") as $row){
					CLIENT_DATA::$clientid = $row['member_id'];
					CLIENT_DATA::CLIENTDATAMAIN();
					$data = SYS_CODES::split_on($row['reviewdate'],1);
					$repaydate = explode(",",$data[1]);
					$from=date_create(max($repaydate));
					$to=date_create(NOW_DATETIME::$Date);
					$tttime = date_diff($from,$to)->format('%R%a');
					$day1 = "";$day2 = "";$day3 = "";$day4 = "";
					if($tttime >="1"){
						$day1 = $tttime; 
						echo "<tr>";
						echo "<td width='30%'>".CLIENT_DATA::$accountname."</td>";
						echo "<td width='30%'>".number_format($row['totalprinc']+$row['totalinterest'])."</td>";
						echo "<td width='30%'><b style='font-size: 10px'>from</b>&nbsp;&nbsp;".max($repaydate)."<b style='font-size: 10px' class='pull-right'>(".$tttime.")</b></td>";
						echo '<td width="10%">
								<button onclick="writeoffloan('.$row['desc_id'].')"  class="btn btn-social btn-info btn-sm" data-toggle="tooltip" data-placement="top" title="Write Off Loan" type="button"><i class="fa fa-check"></i></button>
							</td>';
						echo "</tr>";
					}
					
				}
                
		echo'	</tbody>
			</table>';
	}
	public static function REPAY_WRITE_OFF_LIST(){
		$db = new DB();  NOW_DATETIME::NOW();
		$year = explode("?::?",$_GET["getloananalysisreport"]);
		$loop = "1";
		echo '
			<table id="grat1" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
				<thead>
					<tr>
						<th width="20%">Acount Detail</th>
						<th width="20%">Loan Balance</th>
						<th width="30%">Ageing Period</th>
						<th width="30%">Action</th>
					</tr>
				</thead>
				<tbody>';
				foreach ($db->query("SELECT * FROM loan_schedules s, loan_approvals a,loanwriteoff f  WHERE s.loanstatus='0' AND f.approveid = a.desc_id AND a.desc_id = s.approveid AND a.disburse ='3'") as $row){
					CLIENT_DATA::$clientid = $row['member_id'];
					CLIENT_DATA::CLIENTDATAMAIN();
					$data = SYS_CODES::split_on($row['reviewdate'],1);
					$repaydate = explode(",",$data[1]);
					$from=date_create(max($repaydate));
					$to=date_create(NOW_DATETIME::$Date);
					$tttime = date_diff($from,$to)->format('%R%a');
					$day1 = "";$day2 = "";$day3 = "";$day4 = "";
					if($tttime >="1"){
						$day1 = $tttime; 
						echo "<tr>";
						echo "<td width='20%'>".CLIENT_DATA::$accountname."</td>";
						echo "<td width='20%'>".number_format($row['balance'])."</td>";
						echo "<td width='30%'><b style='font-size: 10px'>from</b>&nbsp;&nbsp;".max($repaydate)."<b style='font-size: 10px' class='pull-right'>(".$tttime.")</b></td>";
						echo '<td width="30%">
								<input id="amtrepay'.$loop.'" class="form-control" style="width: 120px">
								<button onclick="repaywriteoffloan('.$row['offid'].','.$loop.','.$row['balance'].','.$row['member_id'].')"  class="btn btn-social btn-info btn-sm" type="button"><i class="fa fa-check"></i> Repay Write-Off</button>
							</td>';
						echo "</tr>";
						$loop++;
					}
					
				}
                
		echo'	</tbody>
			</table>';
	}
}

class SOLAR extends database_crud{
    protected $table = "stock";
    protected $pk = "Id";   // SELECT `Id`, `cat`, `name`, `qty`, `amount`, `added`, `modified` FROM `stock` WHERE 1
    
    public static function SAVE_STOCK(){
        $bank = new SOLAR(); $db = new DB();
        NOW_DATETIME::NOW();
        $data = explode("?::?",$_GET['savestocking']);


        $da = explode("/",$data[4]);
        $date = $da[2]."-".$da[0]."-".$da[1];
        $bank->cat = $data[0];
        $bank->productname = $data[1];
        $bank->qty = $data[2];
        $bank->amount = $data[3];
        $bank->modified = $date;
        
        

        if($data[5]){
            $bank->Id = $data[5];
            $bank->save();
        }else{
            $bank->added = $date;
            $bank->create();
        }

        echo '
            <div hidden id="stockeditcode"></div>
            <label class="labelcolor">Product Type</label>
            <select id="stocktype" class="form-control">
                <option value="">select Product Type</option>
                <option value="1">Solar</option>
                <option value="2">Others</option>
            </select><br>
            <label class="labelcolor">Product Name</label>
            <input onclick="" id="productname" type="text" class="form-control" placeholder="Enter Product Name"><br>
            <label class="labelcolor">Quantity</label>
            <input onclick="" id="quantity" type="number" class="form-control" placeholder="Enter Quantity"><br>
            <label class="labelcolor">Amount</label>
            <input onclick="" id="amount" type="number" class="form-control" placeholder="Enter Amount"><br>
            <label class="labelcolor">Stock Date</label>
            <input onclick="" id="datepicker" type="text" class="form-control" placeholder="Enter Stock Date"><br><br>
            <center>
               <button class="btn-primary btn" type="" onclick="SaveStock()">Stock</button>
               <button onclick="ClearSTOCK()" type="reset" class="btn btn-default">Cancel</button>
            </center> <br><br>
        ';
        echo '|<><>|';
        echo '
                <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                    <thead>
                        <tr class="info">
                            <th width="15%">Date</th>
                            <th width="25%">Product Name</th>
                            <th width="25%">Amount</th>
                            <th width="25%">Quantity</th>
                            <th width="10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>';
        self::GET_STOCKING();
        echo'   </tbody>
                </table>
            ';
        echo '|<><>|';
        CASHACCOUNT::GET_BANKTRANSACTION();

    }
    public static function GET_STOCKING(){
        $db = new DB(); NOW_DATETIME::NOW();
        foreach ($db->query("SELECT * FROM stock ORDER BY Id DESC") as $rowz){
            
            echo '<tr>';
            echo '<td data-order="2017-00-00"><b>'.$rowz['modified'].'</b></td>';
            echo '<td>'.$rowz['productname'].'</td>';
            echo '<td><b>'.number_format($rowz['amount']).'</b></td>';
            echo '<td><b>'.number_format($rowz['qty']).'</b></td>';
            echo '<td><center><button style="border:0;background-color:transparent;" onclick="GetStocks('.$rowz['Id'].')"><i class="fa fa-pencil fa-2x"></i></button></center></td>';
            echo '</tr>';
        }
    }
    public static function RETURN_STOCKING(){
        $db = new DB();
        foreach ($db->query("SELECT * FROM stock WHERE Id='".$_GET['getstockid']."'") as $rowz){
           
            $da = explode("-",$rowz['modified']);
            $date = $da[1]."/".$da[2]."/".$da[0];
            echo '
                <div hidden id="stockeditcode">'.$_GET['getstockid'].'</div>
                <label class="labelcolor">Product Type</label>
                <select id="stocktype" class="form-control">
                    <option value="'.(($rowZ['cat'])?$rowZ['cat']:"").'">'.(($rowz['cat']=='1')?'Solar':"Others").'</option>
                    <option value="">select Product Type</option>
                    <option value="1">Solar</option>
                    <option value="2">Others</option>
                </select><br>
                <label class="labelcolor">Product Name</label>
                <input onclick="" id="productname" type="text" value="'.$rowz['productname'].'" class="form-control" placeholder="Enter Product Name"><br>
                <label class="labelcolor">Quantity</label>
                <input onclick="" id="quantity" type="number" value="'.$rowz['qty'].'" class="form-control" placeholder="Enter Quantity"><br>
                <label class="labelcolor">Amount</label>
                <input onclick="" id="amount" type="number" value="'.$rowz['amount'].'" class="form-control" placeholder="Enter Amount"><br>
                <label class="labelcolor">Stock Date</label>
                <input onclick="" id="datepicker" type="text" value="'.$date.'" class="form-control" placeholder="Enter Stock Date"><br><br>
                <center>
                   <button class="btn-primary btn" type="" onclick="SaveStock()">Stock</button>
                   <button onclick="ClearSTOCK()" type="reset" class="btn btn-default">Cancel</button>
                </center> <br><br>
            
        ';
        }
    }
    public static function CANCEL_STOCKING(){
        echo '
            <div hidden id="stockeditcode"></div>
            <label class="labelcolor">Product Type</label>
            <select id="stocktype" class="form-control">
                <option value="">select Product Type</option>
                <option value="1">Solar</option>
                <option value="2">Others</option>
            </select><br>
            <label class="labelcolor">Product Name</label>
            <input onclick="" id="productname" type="text" class="form-control" placeholder="Enter Product Name"><br>
            <label class="labelcolor">Quantity</label>
            <input onclick="" id="quantity" type="number" class="form-control" placeholder="Enter Quantity"><br>
            <label class="labelcolor">Amount</label>
            <input onclick="" id="amount" type="number" class="form-control" placeholder="Enter Amount"><br>
            <label class="labelcolor">Stock Date</label>
            <input onclick="" id="datepicker" type="text" class="form-control" placeholder="Enter Stock Date"><br><br>
            <center>
               <button class="btn-primary btn" type="" onclick="SaveStock()">Stock</button>
               <button onclick="ClearSTOCK()" type="reset" class="btn btn-default">Cancel</button>
            </center> <br><br>
        ';
    }
    public static function GET_SOLAR_LOANS(){
        $db = new DB(); NOW_DATETIME::NOW();
        echo '<table id="example" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                <thead>
                    <tr class="info">
                        <th width="15%">Date</th>
                        <th width="25%">Account Name</th>
                        <th width="25%">Loan Amount</th>
                        <th width="25%">Outstanding Balance</th>
                        <th width="10%">Quantity</th>
                    </tr>
                </thead>
                <tbody>';
        foreach ($db->query("SELECT * FROM loan_application1 a, loan_approvals l,loan_schedules p where p.approveid=l.desc_id AND a.loan_id=l.loan_id AND a.type_of_loan='7' ORDER BY a.loan_id DESC") as $rowz){
            CLIENT_DATA::$clientid = $rowz['member_id'];
            CLIENT_DATA::CLIENTDATAMAIN();
            $amt = 0;
            $data = explode(",", $rowz['bal_aft']);
            for($i =0; $i < count($data);$i++){
                $amt +=$data[$i];
            }
            
            echo '<tr>';
            echo '<td data-order="2017-00-00"><b>'.$rowz['disbursed_date'].'</b></td>';
            echo '<td>'.CLIENT_DATA::$accountname.'</td>';
            echo '<td><b>'.number_format($rowz['c_amt']).'</b></td>';
            echo '<td><b>'.number_format($amt).'</b></td>';
            echo '<td></td>';
            echo '</tr>';
        }
        echo'   </tbody>
            </table>';
    }   
}
