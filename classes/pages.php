<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pages
 *
 * @author jammieluvie
 */

class PAGE {
    public static function page_load(){
          AUTH_PAGE::LOGIN_CHECK(); //TIMELYTRACKER::tracker();
          if($_GET['page']==1){AUTH_PAGE::$page_no = 1;        AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==2){AUTH_PAGE::$page_no = 2;    AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==3){AUTH_PAGE::$page_no = 3;    AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==4){AUTH_PAGE::$page_no = 4;    AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==5){AUTH_PAGE::$page_no = 5;    AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==6){AUTH_PAGE::$page_no = 6;    AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==7){AUTH_PAGE::$page_no = 7;    AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==8){AUTH_PAGE::$page_no = 8;    AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==9){AUTH_PAGE::$page_no = 9;    AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==10){AUTH_PAGE::$page_no = 10;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==11){AUTH_PAGE::$page_no = 11;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==12){AUTH_PAGE::$page_no = 12;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==13){AUTH_PAGE::$page_no = 13;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==14){AUTH_PAGE::$page_no = 14;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==15){AUTH_PAGE::$page_no = 15;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==16){AUTH_PAGE::$page_no = 16;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==17){AUTH_PAGE::$page_no = 17;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==18){AUTH_PAGE::$page_no = 18;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==19){AUTH_PAGE::$page_no = 19;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==20){AUTH_PAGE::$page_no = 20;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==21){AUTH_PAGE::$page_no = 21;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==22){AUTH_PAGE::$page_no = 22;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==23){AUTH_PAGE::$page_no = 23;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==24){AUTH_PAGE::$page_no = 24;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==25){AUTH_PAGE::$page_no = 25;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==26){AUTH_PAGE::$page_no = 26;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==27){AUTH_PAGE::$page_no = 27;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==28){AUTH_PAGE::$page_no = 28;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==29){AUTH_PAGE::$page_no = 29;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==30){AUTH_PAGE::$page_no = 30;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==31){AUTH_PAGE::$page_no = 31;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==32){AUTH_PAGE::$page_no = 32;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==33){AUTH_PAGE::$page_no = 33;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==34){AUTH_PAGE::$page_no = 34;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==35){AUTH_PAGE::$page_no = 35;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==36){AUTH_PAGE::$page_no = 36;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==37){AUTH_PAGE::$page_no = 37;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==38){AUTH_PAGE::$page_no = 38;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==39){AUTH_PAGE::$page_no = 39;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==40){AUTH_PAGE::$page_no = 40;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==41){AUTH_PAGE::$page_no = 41;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==42){AUTH_PAGE::$page_no = 42;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==43){AUTH_PAGE::$page_no = 43;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==44){AUTH_PAGE::$page_no = 44;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==45){AUTH_PAGE::$page_no = 45;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==46){AUTH_PAGE::$page_no = 46;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==47){AUTH_PAGE::$page_no = 47;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==48){AUTH_PAGE::$page_no = 48;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==49){AUTH_PAGE::$page_no = 49;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==50){AUTH_PAGE::$page_no = 50;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==51){AUTH_PAGE::$page_no = 51;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==52){AUTH_PAGE::$page_no = 52;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==53){AUTH_PAGE::$page_no = 53;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==54){AUTH_PAGE::$page_no = 54;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==55){AUTH_PAGE::$page_no = 55;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==56){AUTH_PAGE::$page_no = 56;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          elseif($_GET['page']==57){AUTH_PAGE::$page_no = 57;  AUTH_PAGE::AUTETICATION_VALIDATION();}
          else{}
    }
    static function page_shifting(){
          if($_GET['page']==1){self::dashboard();}
          elseif($_GET['page']==2){}
          elseif($_GET['page']==3){self::depositnwithdraw();}
          elseif($_GET['page']==4){self::client_accounts();}
          elseif($_GET['page']==5){}
          elseif($_GET['page']==6){}
          elseif($_GET['page']==7){self::client_blacklist();}
          elseif($_GET['page']==8){self::client_contact();}
          elseif($_GET['page']==9){}
          elseif($_GET['page']==10){}
          elseif($_GET['page']==11){self::ImportMemberData();}
          elseif($_GET['page']==12){self::shares();}
          elseif($_GET['page']==13){self::ShareTransfers();}
          elseif($_GET['page']==14){}
          elseif($_GET['page']==15){self::Dividends();}
          elseif($_GET['page']==16){}
          elseif($_GET['page']==17){}
          elseif($_GET['page']==18){self::Multiple_Deposits();}
          elseif($_GET['page']==19){self::NonCashTransactions();}
          elseif($_GET['page']==20){}
          elseif($_GET['page']==21){self::SavingAccountTypes();}
          elseif($_GET['page']==22){}
          elseif($_GET['page']==23){self::OverDraft();}
          elseif($_GET['page']==24){self::StandingOrders();}
          elseif($_GET['page']==25){self::savings_report();}
          elseif($_GET['page']==26){self::loan_process();}
          elseif($_GET['page']==27){self::loan_disbursement();}
          elseif($_GET['page']==28){self::loan_postduedates();}
          elseif($_GET['page']==29){self::loan_repayment();}
          elseif($_GET['page']==30){}
          elseif($_GET['page']==31){}
          elseif($_GET['page']==32){self::loan_writeoff();}
          elseif($_GET['page']==33){self::loan_report();}
          elseif($_GET['page']==34){self::CashTransactions();}
          elseif($_GET['page']==35){}
          elseif($_GET['page']==36){}
          elseif($_GET['page']==37){}
          elseif($_GET['page']==38){}
          elseif($_GET['page']==39){}
          elseif($_GET['page']==40){self::Investiments();}
          elseif($_GET['page']==41){}
          elseif($_GET['page']==42){self::Incomes();}
          elseif($_GET['page']==43){}
          elseif($_GET['page']==44){self::chartofaccounts();}
          elseif($_GET['page']==45){self::Purchases();}
          elseif($_GET['page']==46){self::Assets();}
          elseif($_GET['page']==47){}
          elseif($_GET['page']==48){self::Budgeting();}
          elseif($_GET['page']==49){}
          elseif($_GET['page']==50){self::TrialBalance();}
          elseif($_GET['page']==51){self::BalanceSheet();}
          elseif($_GET['page']==52){self::CashFlowStatement();}
          elseif($_GET['page']==53){self::ProfitnLoss();}
          elseif($_GET['page']==54){}
          elseif($_GET['page']==55){self::generalsettings();}
          elseif($_GET['page']==56){self::Expenses();}
          elseif($_GET['page']==57){self::BankTransactions();}
          else{self::dashboard();}
    }
    static function depositnwithdraw(){
          NOW_DATETIME::NOW();
          AUTH_PAGE::$page_no = 3;  AUTH_PAGE::AUTETICATION_VALIDATION();
          echo '
                  <div class="row">
              <div class="col-md-12">
              <div class="panel panel-midnightblue" style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
              <div class="panel-heading">
                <h2><i class="ti ti-mouse"></i>Deposit & Withdraws</h2>
                <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                <div class="options">
                  <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                    <li class="active"><a href="#tab-6-1" data-toggle="tab">WITHDRAW / DEPOSIT</a></li>
                    <li><a href="#tab-6-2" data-toggle="tab">TRANSACTION RECORDS</a></li>
                  </ul>
                </div>
              </div>
              <div class="panel-body">
                <div class="tab-content">
                  <div class="tab-pane active" id="tab-6-1">
                    <div class="row">
                                    <div class="col-md-4">
                                        <label>Search for Client</label>
                                            <select onchange="getcontentdata()" id="basic" class="selectpicker show-tick form-control" data-live-search="true">
                                                  <option value="">select member...</option>
                                                  ';CLIENT_DATA::CLIENT_OPTIONSEARCH();  echo'
                                            </select><br><br>
                                        <div id="result2">
                                            <div  class="panel panel-teal" style="background-color: #8BC34A">
                                                <div class="panel-heading">
                                                    <h2>
                                                        <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                                            <li class="active" style="border-bottom: 0px;"><a href="#tab-10-1" data-toggle="tab">Deposit</a></li>
                                                            <li><a href="#tab-10-2" data-toggle="tab">Withdraw</a></li>
                                                        </ul>
                                                    </h2>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="tab-10-1">
                                                           <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label class="control-label">Total Deposit Amount</label><br>
                                                                    <div class="">
                                                                        <input style="font-size: 22px;font-weight: 900;color: #f73609" disabled id="deposittotamt" class="form-control" type="text">
                                                                    </div>
                                                                </div>
                                                           </div>
                                                           <div class="col-md-12">
                                                           <div id="deposittable">
                                                                <table class="table table-bordered table-responsive" width="100%">
                                                                    <tr class="info">
                                                                        <th width="1%">#</th>
                                                                        <th width="59%">Description</th>
                                                                        <th width="40%">Amount</th>
                                                                    </tr>
                                                                    <tbody>';
                                                                        DEPOSIT_CATEGORY::GET_DCATS();
                                            echo'                   </tbody>
                                                                </table>
                                                                </div>
                                                                <div>
                                                                    <div class="form-group">
                                                                        <label class="control-label">Deposited By</label><br>
                                                                        <div class="">
                                                                            <input id="depositor" class="form-control" type="text">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="clearfix pt-md">
                                                                    <div class="pull-right">
                                                                        <button id="savebutdeposit" class="btn btn-social btn-google" type="" onclick="savedeposit()">Submit Deposit</button>
                                                                        <a type="reset" class="btn btn-social btn-apple" href="">Cancel</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="tab-10-2">
                                                            <div class="">
                                                                <div class="form-group">
                                                                    <label class="control-label">Withdraw Amount</label><br>
                                                                    <div class="">
                                                                        <input id="withdrawamt" class="form-control" type="text">
                                                                    </div>
                                                                </div>
                                                           </div>
                                                           <div>
                                                                <div class="form-group">
                                                                    <label class="control-label">Withdrawn By</label><br>
                                                                    <div class="">
                                                                        <input id="withdrawor" class="form-control" type="text">
                                                                    </div>
                                                                </div>
                                                           </div>
                                                           <div class="clearfix pt-md">
                                                                <div class="pull-right">
                                                                    <button class="btn btn-social btn-google" type="" onclick="savewithdraw()">Submit Withdraw</button>
                                                                    <a type="reset" class="btn btn-social btn-apple" href="">Cancel</a>
                                                                </div>
                                                           </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-md-8">
                                        <div id="payrecord">
                                            <div class="w3-container" style="">
                                              <div class="w3-card-4" style="width:100%;border-radius: 10px">
                                                <header class="w3-container w3-light-green" style="color: #fff;border-top-left-radius: 10px;border-top-right-radius: 10px;">
                            <h4 style="color: #fff;">
                              <b>Acc Name:</b> &nbsp;
                              <b style="font-size: 16px"> &nbsp;&nbsp;&nbsp;Acc Number: &nbsp;</b>
                              <button class="icon-bg pull-right incard1" style=""><i class="ti ti-printer"></i></button>
                              <button data-target="#excelsheetupload" data-toggle="modal" class="icon-bg pull-right incard2" style="margin-right: 4px"><img src="images/excel.png" width="15px" height="20px"></button></h4>
                            </h4>

                                                </header>
                                                <div class="w3-container"><hr>
                                                  <div class="col-md-2">
                                                    <img src="images/default.png" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px;height: 60px">
                                                  </div>
                                                  <div class="col-md-3">
                                                     <b>Savings Account</b><br><br>
                                                     <p>Acc Balance: <b>0</b></p>
                                                  </div>
                                                  <div class="col-md-3">
                                                     <b>Share Capital</b><br><br>
                                                     <p style="font-size: 12px">Share Amount: <b>0</b></p>
                                                     <p style="font-size: 12px">No. of Shares: <b>0</b></p>
                                                  </div>
                                                  <div class="col-md-4">
                                                     <b>Loan Information</b><br><br>
                                                     <p style="font-size: 12px">Outstanding Balance: <b>0</b></p>
                                                     <p style="font-size: 12px">Loan Penalty: <b>0</b></p>
                                                  </div>
                                                </div><hr>
                                                <button disabled class="w3-btn-block w3-dark-grey" style="border-bottom-right-radius: 10px;border-bottom-left-radius: 10px"><i class="fa fa-refresh"></i> &nbsp;&nbsp;Refresh Info</button>
                                              </div>
                                            </div><br>
                                        </div>
                                        <div id="clientledger">
                                            <table cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n" id="grn">
                                                <thead>
                                                    <tr class="success">
                                                         <th width = "10%">Date</th>
                                                         <th width = "30%">Description</th>
                                                         <th width = "15%"><b style="font-size: 12px">Withdrawls<br>DEBIT</b></th>
                                                         <th width = "15%"><b style="font-size: 12px">Deposits<br>CREDIT</b></th>
                                                         <th width = "20%">Balance</th>
                                                         <th width = "10%">Initials</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                            <br>
                                        </div>
                                        </div>


                    </div>
                  </div>
                  <div class="tab-pane" id="tab-6-2">
                                <div id="wdtransactionledger">
                                    '; CLIENT_DATA::RETURN_GENERALCLIENTLEDGER(); echo '
                                </div>
                  </div>
                </div>
              </div>
            </div>
            </div>
          ';
          form_modals::transactionmodal();  form_modals::schoolfees();  form_modals::uploadexcel1();
    }
    static function client_accounts(){
        NOW_DATETIME::NOW();
        AUTH_PAGE::$page_no = 2;  AUTH_PAGE::AUTETICATION_VALIDATION();
       echo '
       <div class="row">
           <div class="col-md-12">
                <div class="panel panel-midnightblue">
                    <div class="panel-heading" >
                        <h2><i class="ti ti-mouse"></i>Account Management</h2>
            <center>
              <h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <button class="btn btn-sm btn-social btn-flickr pull-right"><i class="fa fa-plus-square"></i>Add Physical Address</button>
              </h2>
                <h2>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <button data-target="#addgroup" data-toggle="modal" class="btn btn-sm btn-social btn-success pull-right"><i class="fa fa-plus-square"></i>Add Group Account</button>
                </h2>
            </center>
            <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-6">
                            <div class="panel panel-teal">
                                <center><h3><b>ACCOUNT OPENING FORM</b></h3></center>
                                <div class="panel-body" id="domwizard">
                                <center><b style="color: #3C8DBC">Applicant Type</b><br><br></center>
                                    <div class="col-md-6">
                                        <label class="labelcolor">Applicant Type</label>
                                        <select id="getacctype" onchange="applicattype()" class="form-control">
                                            <option>select type</option>
                                            <option>Individual Category</option>
                                            <option>Joint Category</option>
                                            <option>Business Category</option>
                                        </select><br><br>
                                    </div>
                                    <div class="col-md-6">

                                    </div>
                                    <form id="uploadimage" action="" method="post" enctype="multipart/form-data">
                                    <div id="applicantdata"><div hidden id="editindacc"></div>
                                    <div class="col-md-12"><center><b style="color: #3C8DBC">Applicant Details</b><br><br></center></div>
                                    <div class="col-md-6">
                                        <label class="labelcolor">First Name</label>
                                        <input id="fname" type="text" class="form-control">
                                        <label class="labelcolor">Last Name</label>
                                        <input id="lname" type="text" class="form-control">
                                        <label class="labelcolor">ID/Passport No.</label>
                                        <input id="idnum" type="text" class="form-control">
                                        <label class="labelcolor">Nationality</label>
                                        <input id="nationality" type="text" class="form-control">
                                        <label class="labelcolor">Occupation</label>
                                        <input id="occupation" type="text" class="form-control">
                                        <label class="labelcolor">Mobile Number</label>
                                        <input id="mobilenumber" type="text" class="form-control">
                                        <label class="labelcolor">Sub County</label>
                                        <input id="subcounty" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="labelcolor">Middle Name</label>
                                        <input id="mname" type="text" class="form-control">
                                        <label class="labelcolor">Sex</label>
                                        <select id="gender" class="form-control">
                                            <option value="">select gender</option>
                                            <option value="Female">Female</option>
                                            <option value="Male">Male</option>
                                            <option value="Female Youth">Female Youth</option>
                                            <option value="Male Youth">Male Youth</option>
                                            <option value="Other">other</option>
                                        </select>
                                        <label class="labelcolor">Date of Birth</label>
                                        <input id="dateofbirth" type="text" class="form-control">
                                        <label class="labelcolor">Marital Status</label>
                                        <select id="maritalstatus" class="form-control">
                                            <option value="">select status</option>
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Other">other</option>
                                        </select>
                                        <label class="labelcolor">Employer</label>
                                        <input id="employer" type="text" class="form-control">
                                        <label class="labelcolor">Physical Address/Village</label>
                                        <select id="physicaladdress" class="form-control">
                                            <option value="">select Address</option>
                                        </select>
                                         <label class="labelcolor">District</label>
                                        <input id="district" type="text" class="form-control"><br><br>
                                    </div>
                                    <div class="col-md-12"><center><b style="color: #3C8DBC">Next of Kin</b><br><br></center></div>
                                    <div class="col-md-6">
                                        <label class="labelcolor">Names</label>
                                        <input id="kname" type="text" class="form-control">
                                        <label class="labelcolor">Address</label>
                                        <input id="kaddress" type="text" class="form-control">
                                        <label class="labelcolor">Security Question</label>
                                        <input id="security" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="labelcolor">Relationship</label>
                                        <input id="krelationship" type="text" class="form-control">
                                        <label class="labelcolor">Contact Detail</label>
                                        <input id="contactdetail" type="text" class="form-control">
                                        <label class="labelcolor">Answer</label>
                                        <input id="sanswer" type="text" class="form-control"><br><br>
                                    </div>
                  <div class="col-md-8">
                                    <label class="labelcolor">Browse to Add Applicant Photo</label>
                  <input class="" type="file" name="file1" id="file" onchange="readURL(this);" />
                  </div>
                  <div class="col-md-4" id="imageplace">
                    <img id="blah" src="images/default.png" class="img-rounded" style="width; 100px;height:100px;image-orientation:from-image" />
                    </b><br><br>
                  </div>


                                    <div class="col-md-12"><center><b style="color: #3C8DBC">Account Details</b><br><br></center></div>
                                    <div class="col-md-6">
                                        <label class="labelcolor">Account Name</label>
                                        <input id="accountname" type="text" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                         <label class="labelcolor">Account Number</label>
                                        <input id="accountnumber" type="text" class="form-control"><br><br>
                                    </div>
                                    </div>
                                    <div class="col-md-12"><center><button id="saveacc" type="submit" class="btn btn-social btn-google"><i class="fa fa-save"></i> Save Account Details</button></center></div>
                                    </div>
                                    </form>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div id="accountdatarecords">';
                               CLIENT_DATA::CLIENTDATA();
                echo '      </div>
                        </div>
                    </div>
                </div>
            </div>
       </div>
       <script language="JavaScript">
            function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        $(\'#blah\')
                            .attr(\'src\', e.target.result)
                            .width(100)
                            .height(100);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
            function readURL1(input) {
                if (input.files && input.files[0]) {
                var reader = new FileReader();
                    reader.onload = function (e) {
                        $(\'#blah1\')
                            .attr(\'src\', e.target.result)
                            .width(100)
                            .height(100);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
            function readURL2(input) {
                if (input.files && input.files[0]) {
                var reader = new FileReader();
                    reader.onload = function (e) {
                        $(\'#blah2\')
                            .attr(\'src\', e.target.result)
                            .width(100)
                            .height(100);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
        </script>
       ';
        form_modals::individualmodal();     form_modals::groupdatamodal();  form_modals::businessdatamodal();
        form_modals::addgroup();
    }
    static function client_blacklist(){
          NOW_DATETIME::NOW();
          AUTH_PAGE::$page_no = 2;  AUTH_PAGE::AUTETICATION_VALIDATION();
         echo '
         <div class="row">
             <div class="col-md-12">
                  <div class="panel panel-midnightblue">
                      <div class="panel-heading" >
                          <h2><i class="ti ti-user"></i>Client Black List</h2>
                          <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                          <div class="options">
                              <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                              <li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">BlackList</a></li>
                              <li class=""><a href="#tab-6-2" data-toggle="tab" aria-expanded="true">BlackListed Clients</a></li>
                              <li class=""><a href="#tab-6-3" data-toggle="tab" aria-expanded="true">Retrieved Clients</a></li>
                              </ul>
                          </div>
                      </div>
                      <div class="panel-body">
                          <div class="tab-content">
                              <div class="tab-pane  active" id="tab-6-1">
                                  <div class="row">
                                      <div class="col-md-10 col-md-offset-1">
                                          <div id="accountblacklist">';
                                             CLIENT_DATA::CLIENTBLACKLISTWORK();
                              echo '      </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="tab-pane" id="tab-6-2">
                                  <div class="row">
                                      <div class="col-md-10 col-md-offset-1">
                                          <div id="blacklist">';
                                             CLIENT_DATA::CLIENTBLACKLIST();
                              echo '      </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="tab-pane" id="tab-6-3">
                                  <div class="row">
                                      <div class="col-md-10 col-md-offset-1">
                                          <div id="retreivedblacklist">';
                                             CLIENT_DATA::CLIENTBLACKLISTRETREIVE();
                              echo '      </div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
         ';
          form_modals::individualmodal();     form_modals::groupdatamodal();
      }
    static function client_contact(){
          NOW_DATETIME::NOW();
          AUTH_PAGE::$page_no = 2;  AUTH_PAGE::AUTETICATION_VALIDATION();
         echo '
         <div class="row">
             <div class="col-md-12">
                  <div class="panel panel-midnightblue">
                      <div class="panel-heading" >
                          <h2><i class="ti ti-telephone"></i>Client Contacts</h2>
                          <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                      </div>
                      <div class="panel-body">
                          <div class="col-md-10 col-md-offset-1">
                              <div id="accountdatarecords">';
                                 CLIENT_DATA::CLIENTCONTACTS();
                  echo '      </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
         ';

    }
    static function dashboard(){
          NOW_DATETIME::NOW();CLIENT_DATA::DASH_VALUES();
          echo '
                  <div class="row">
                          <div class="col-md-3">
                              <div class="info-tile tile-orange">
                                  <div class="tile-icon"><i class="ti ti-user"></i></div>
                                  <div class="tile-heading"><span>Members</span></div>
                                  <div class="tile-body"><span>UGX '. number_format(CLIENT_DATA::$members).'</span></div>
                                  <div class="tile-footer"><span class="text-success">22.5% <i class="fa fa-level-up"></i></span></div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="info-tile tile-success">
                                  <div class="tile-icon"><i class="ti ti-bar-chart"></i></div>
                                  <div class="tile-heading"><span>Amount Payable</span></div>
                                  <div class="tile-body"><span>UGX 0</span></div>
                                  <div class="tile-footer"><span class="text-danger">12.7% <i class="fa fa-level-down"></i></span></div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="info-tile tile-info">
                                  <div class="tile-icon"><i class="ti ti-stats-up"></i></div>
                                  <div class="tile-heading"><span>Amount Receiveable</span></div>
                                  <div class="tile-body"><span>UGX 0</span></div>
                                  <div class="tile-footer"><span class="text-success">5.2% <i class="fa fa-level-up"></i></span></div>
                              </div>
                          </div>
                          <div class="col-md-3">
                              <div class="info-tile tile-danger">
                                  <div class="tile-icon"><i class="ti ti-bar-chart-alt"></i></div>
                                  <div class="tile-heading"><span>Outstanding Loan Balances</span></div>
                                  <div class="tile-body"><span>UGX '. number_format(CLIENT_DATA::$loanbalances).'</span></div>
                                  <div class="tile-footer"><span class="text-danger">10.5% <i class="fa fa-level-down"></i></span></div>
                              </div>
                          </div>
                  </div>
              <div data-widget-group="group1">
                    <div class="row">
                        <div class="col-md-12">
                            <div style="background-color: #4caf50;color: #f5f5f5" class="alert alert-success">
                            <div class="row">
                                <div class="col-md-4 col-md-offset-5">
                                      <li><a href=""><i class="fa fa-home"></i>
                                      <span>
                                        <b style="font-size: 16px;color: saddlebrown;font-family: Courier New, Courier, monospace"><span><?php echo strtoupper($_SESSION[\'department\']);?></span></b>
                                      </span></a></li>
                                </div>
                                <span style="margin-right: 2em;font-size: 24px;font-family: Courier;font-weight: 900" class="pull-right">Date : '.NOW_DATETIME::$Date.'</span>
                            </div>
                        </div>
                  
                        <div class="col-md-3">
                            <button onclick="datatest()" >see data</button>
                        </div>



                          <!-- Colorpicker Modal -->
                          <div class="modal fade modals" id="tpicker_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog" style = "width:1290px;">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                          <h2 class="modal-title">SELECT RECONCILIATION STATEMENT </h2>
                                      </div>
                                      <div class="modal-body">
                                          <script type="text/javascript">
                                              function validateForm()
                                              {
                                                  var con = confirm("Are u sure of this?");
                                                  if (con ==false)
                                                  {
                                                      return false;
                                                  }
                                              }
                                          </script>


                                      </div>
                                      <div class="modal-footer">
                                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                          <!--          <button type="button" class="btn btn-primary">Save changes</button> -->
                                      </div>
                                  </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                          </div><!-- /.modal -->



                      </div>
                  </div> <!-- .container-fluid -->
              </div>
              ';
    }
    static function loan_process(){
          NOW_DATETIME::NOW();  session_start();
          echo '
              <div class="row">
                  <div class="col-md-12">
                      <div class="panel panel-midnightblue" style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                          <div class="panel-heading">
                              <h2><i class="ti ti-mouse"></i>Loan Process</h2>
                              <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                              <div class="options">
                                  <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                 '.(($_SESSION['handletag']=="0")?'<li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">Loan Application</a></li><li class=""><a href="#tab-6-2" data-toggle="tab" aria-expanded="true">Loan Approval</a></li>':(($_SESSION['handletag']=="1")?'<li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">Loan Application</a></li>':(($_SESSION['handletag']=="2")?'<li class="active"><a href="#tab-6-2" data-toggle="tab" aria-expanded="true">Loan Approval</a></li>':""))).'
                                  </ul>
                              </div>
                          </div>
                          <div class="panel-body">
                              <div class="tab-content">
                                  <div class="tab-pane  '.(($_SESSION['handletag']=="0" || $_SESSION['handletag']=="1")?"active":"").'" id="tab-6-1">
                                      <center><h2><b>Loan Applications</b></h2></center>
                                      <div class="row">
                                          <div class="col-md-10 col-md-offset-1">
                                          <div id="loandatatable">
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
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <div class="tab-pane  '.(($_SESSION['handletag']=="2")?"active":"").'" id="tab-6-2">
                                      <center><h2><b>Loan Approval Details</b></h2></center>
                                      <div class="row">
                                          <div class="col-md-10 col-md-offset-1">
                                          <div class="pull-right"><button onclick="getdeclinedloans()"  data-target="#declinedloansmodal" data-toggle="modal" class="btn btn-info">View Declined Applications</button></div><br><br><br>
                                              <div id="approvaltabledata">
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
          form_modals::addloanapplication();      form_modals::addloanappraisal();   form_modals::makedecision();  form_modals::declinedloans();
    }
    static function loan_disbursement(){
          NOW_DATETIME::NOW();
          echo '
              <div class="row">
                  <div class="col-md-12">
                      <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                           <div class="panel-heading">
                              <h2><i class="ti ti-mouse"></i>Loan Disbursement</h2>
                              <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                              <div class="options">
                                  <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                  <li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">Loan Disbursement</a></li>
                                  <li class=""><a href="#tab-6-2" data-toggle="tab" aria-expanded="true">Disbursed Loans</a></li>
                                  </ul>
                              </div>
                          </div>
                           <div class="panel-body">
                              <div class="tab-content">
                                   <div class="tab-pane  active" id="tab-6-1">
                                      <div class="row">
                                          <div class="col-md-10 col-md-offset-1">
                                          <center><h2><b>Approved Loans</b></h2></center>
                                          <div id="loandatatable">
                                              <table id="grat2" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered table-striped m-n">
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
                                              </table>
                                              </div>
                                          </div>
                                      </div>
                                   </div>
                                   <div class="tab-pane" id="tab-6-2">
                                      <div class="row">
                                          <div class="col-md-10 col-md-offset-1">
                                          <center><h2><b>Disbursed Active Loans</b></h2></center>
                                          <div id="loanschudletable">
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
          form_modals::loanschedule();    form_modals::DisburseDetail();  form_modals::addloanapplication();      form_modals::addloanappraisal(); 
    }
    static function loan_postduedates(){
          NOW_DATETIME::NOW();
          echo '
              <div class="row">
                  <div class="col-md-12">
                      <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                           <div class="panel-heading">
                              <h2><i class="ti ti-mouse"></i>Postpone Due Dates</h2>
                              <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                              <div class="options">
                                  <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                  <li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">Loan Postponding</a></li>
                                  <li class=""><a href="#tab-6-2" data-toggle="tab" aria-expanded="true">Postponded Loans List</a></li>
                                  </ul>
                              </div>
                          </div>
                           <div class="panel-body">
                              <div class="tab-content">
                                   <div class="tab-pane  active" id="tab-6-1">
                                      <div class="row">
                                          <div class="col-md-10 col-md-offset-1">
                                          <center><h2><b>Postpone Due Dates</b></h2></center>
                                          <div id="loandatatable">
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
                                              </div>
                                          </div>
                                      </div>
                                   </div>
                                   <div class="tab-pane" id="tab-6-2">
                                      <div class="row">
                                          <div class="col-md-10 col-md-offset-1">
                                          <center><h2><b>Postponed List</b></h2></center>
                                          <div id="loanschudletable">
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
          form_modals::loanschedule();
    }
    static function loan_repayment(){
        NOW_DATETIME::NOW();
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                         <div class="panel-heading">
                            <h2><i class="ti ti-mouse"></i>Loan Repayments</h2>
                            <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                            <div class="options">
                                <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                <li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">Loan Repayment</a></li>
                                <li class=""><a href="#tab-6-2" data-toggle="tab" aria-expanded="true">Today Repayment</a></li>
                                <li class=""><a href="#tab-6-3" data-toggle="tab" aria-expanded="true">Loan Penalties</a></li>
                                <li class=""><a href="#tab-6-4" data-toggle="tab" aria-expanded="true">Paid Loan Penalties</a></li>
                                </ul>
                            </div>
                        </div>
                         <div class="panel-body">
                            <div class="tab-content">
                                 <div class="tab-pane  active" id="tab-6-1">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                        <center><h2><b>General Loan Repayments</b></h2></center>
                                        <div id="loandatatable">
                                            <table id="grat2" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                                                <thead>
                                                    <tr>
                                                        <th width="10%">Date</th>
                                                        <th width="20%">Account Name</th>
                                                        <th width="15%">Paid Amount</th>
                                                        <th width="15%">Outstanding Bal</th>
                                                        <th width="15%">Total Interest Bal</th>
                                                        <th width="15%">Total Loan Bal</th>
                                                        <th width="10%">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    '; LOAN_REPAYMENT::REPAYMENT_LIST();  echo '
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="tab-pane" id="tab-6-2">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                        <center><h2><b>Today Loan Repayments</b></h2></center>
                                        <div id="loandatatable">
                                            <table id="grat1" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                                                <thead>
                                                    <tr>
                                                        <th width="10%">Date</th>
                                                        <th width="20%">Account Name</th>
                                                        <th width="15%">Amount to be Paid</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    '; LOAN_REPAYMENT::TODAY_REPAYMENT_LIST();  echo '
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="tab-pane" id="tab-6-3">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                        <center><h2><b>Loan Penalty List</b></h2></center>
                                        <div id="loanschudletable">
                                            <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                                                <thead>
                                                    <tr>
                                                        <th width="40%">Account Details</th>
                                                        <th width="30%">Loan Balance</th>
                                                        <th width="30%">Penalty Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    ';  LOAN_PROCESSCLASS::PENALTYLIST();  echo '
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="tab-pane" id="tab-6-4">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                        <center><h2><b>Loan Penalty Paid List</b></h2></center>
                      <div id="loanschudletable">
                        ';  LOAN_PROCESSCLASS::PENALITIES_PAID();  echo '
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
        form_modals::loanledgercard();
    }
    static function loan_writeoff(){
        NOW_DATETIME::NOW();
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                         <div class="panel-heading">
                            <h2><i class="ti ti-mouse"></i>Loan Write-off</h2>
                            <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                            <div class="options">
                                <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                <li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">Loan Write-Off</a></li>
                                <li><a href="#tab-6-2" data-toggle="tab" aria-expanded="false">Repayment of Write-Off Loans</a></li>
                                </ul>
                            </div>
                        </div>
                         <div class="panel-body">
                            <div class="tab-content">
                                 <div class="tab-pane  active" id="tab-6-1">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                        <center><h2><b>Loan Write-Off</b></h2></center>
                      <div id="writeofftable">
                        ';   LOAN_WRITEOFF::WRITE_OFF_LIST();  echo'
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="tab-pane" id="tab-6-2">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                        <center><h2><b>Repayment of Write-Off Loans</b></h2></center>
                      <div id="repaywriteoff">
                        ';   LOAN_WRITEOFF::REPAY_WRITE_OFF_LIST();  echo'
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="tab-pane" id="tab-6-3">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                        <center><h2><b>Loan Penalty List</b></h2></center>
                                        <div id="loanschudletable">
                                            <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                                                <thead>
                                                    <tr>
                                                        <th width="40%">Account Details</th>
                                                        <th width="30%">Loan Balance</th>
                                                        <th width="30%">Penalty Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    ';  LOAN_PROCESSCLASS::PENALTYLIST();  echo '
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="tab-pane" id="tab-6-4">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                        <center><h2><b>Loan Penalty List</b></h2></center>
                                        <div id="loanschudletable">
                                            <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                                                <thead>
                                                    <tr>
                                                        <th width="40%">Account Details</th>
                                                        <th width="30%">Loan Balance</th>
                                                        <th width="30%">Penalty Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    ';  LOAN_PROCESSCLASS::PENALTYLIST();  echo '
                                                </tbody>
                                            </table>
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
    static function loan_report(){
        NOW_DATETIME::NOW();
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
            <div class="panel-heading">
                            <h2><i class="ti ti-mouse"></i>Loan Reports</h2>
                            <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                            <div class="options">
                                <ul class="nav nav-tabs">
                                    <li class="dropdown pull-right tabdrop hide">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                            <i class="fa fa-angle-down"></i>
                                        </a><ul class="dropdown-menu"></ul>
                                    </li>
                                    <li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">Reports on Repayments</a></li>
                                    <li><a href="#tab-6-2" data-toggle="tab" aria-expanded="false">Analysis Reports</a></li>
                                    <li><a href="#tab-6-3" data-toggle="tab" aria-expanded="false">Reports on Dues</a></li>
                                    <li><a href="#tab-6-4" data-toggle="tab" aria-expanded="false">Outstanding Balance Report</a></li>
                                    <li><a href="#tab-6-5" data-toggle="tab" aria-expanded="false">Disbursement Report</a></li>
                                    <li><a href="#tab-6-6" data-toggle="tab" aria-expanded="false">Approved/Rejected/Pending Loans</a></li>
                                    <li><a href="#tab-6-7" data-toggle="tab" aria-expanded="false">Guarantors and Collateral Report</a></li>
                                    <li><a href="#tab-6-8" data-toggle="tab" aria-expanded="false">Account Balances Report</a></li>
                                </ul>
                            </div>
                        </div>
                         <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane  active" id="tab-6-1">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                      <center><h2><b>Reports on Repayments</b></h2></center>
                      <center>
                        <table>
                          <tr>
                            <td><label>Select Report Type</label>&nbsp;&nbsp;</td>
                            <td>
                              <select onchange="reportchange()" id="report1" class="form-control">
                                <option value="">select report type</option>
                                <option value="1">Repayments List</option>
                                <option value="8">Repayments Per Individual</option>
                                <option value="2">Pre-payment Report</option>
                                <option value="3">Penalties Charged Report</option>
                                <option value="4">Penalties Paid</option>
                                <option value="5">Fully Repaid Loans Report</option>
                                <option value="6">Repayments of Written-Off Loans Report</option>
                                <option value="7">Report on Fees Received</option>
                              </select>
                              <span hidden id="perind">
                                <select onchange="getcontentdata()" id="basic" class="selectpicker show-tick form-control" data-live-search="true">
                                    <option value="">select member...</option>
                                    ';CLIENT_DATA::CLIENT_OPTIONSEARCH();  echo'
                                </select><br>
                              </span><br>
                            </td>
                          </tr>
                          <tr>
                            <td><label>Select Year</label>&nbsp;&nbsp;</td>
                            <td>
                              <select id="yearid1" class="form-control">';
                               PERIOD_MODULES::YEAR();
                               echo '
                              </select>
                            </td>
                            <td>
                              &nbsp;&nbsp;
                              <button onclick="GetLoanRepaymentReport()" class="btn"><i class="ti ti-eye"></i>&nbsp;&nbsp;view</button>
                            </td>
                            <td>&nbsp;&nbsp;
                              <button onclick="printLoanRepaymentReport()" class="btn btn-social btn-facebook">
                                <i class="ti ti-printer"></i>
                                &nbsp;&nbsp;Print
                              </button>
                            </td>
                          </tr>
                        </table>
                      </center><br><br>
                                            <div id="loanrepaymentreport"></div>
                                            <div hidden id="loanrepaymentreport1"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-6-2">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                      <center><h2><b>Loan Analysis Reports</b></h2></center>
                      <center>
                        <table>
                          <tr>
                            <td><label>Select Report Type</label>&nbsp;&nbsp;</td>
                            <td>
                              <select onchange="reportchange1()" id="report2" class="form-control">
                                <option value="">select report type</option>
                                <option value="1">Written-Off Loans Report</option>
                                <option value="2">Top Borrowers Report</option>
                                <option value="3">Arrears Report</option>
                                <option value="4">Ageing Report</option>
                                <option value="5">PortFolio at Risk Report</option>
                                <option value="6">Loan PortFolio Report</option>
                              </select><br>
                            </td>
                          </tr>
                          <tr>
                            <td><label>Select Year</label>&nbsp;&nbsp;</td>
                            <td>
                              <select onchange="" id="yearid2" class="form-control">';
                               PERIOD_MODULES::YEAR();
                               echo '
                              </select>
                            </td>
                            <td>
                              &nbsp;&nbsp;
                              <button onclick="GetAnalysisReport()" class="btn"><i class="ti ti-eye"></i>&nbsp;&nbsp;view</button>
                            </td>
                            <td>&nbsp;&nbsp;
                              <button onclick="printLoanAnalysistReport()" class="btn btn-social btn-facebook">
                                <i class="ti ti-printer"></i>
                                &nbsp;&nbsp;Print
                              </button>
                            </td>
                          </tr>
                        </table>
                      </center><br><br>
                      <div id="loananalysisreport"></div>
                      <div hidden id="loananalysisreport1"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-6-3">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                      <center><h2><b>Loan Dues Report</b></h2></center>
                      <center>
                        <table>
                          <tr>
                            <td><label>Select Period</label>&nbsp;&nbsp;</td>
                            <td>
                              <select onchange="GetLoanDuesReport()" id="report3" class="form-control">
                                <option value="7">1 Week</option>
                                <option value="14">2 Weeks</option>
                                <option value="21">3 Weeks</option>
                                <option value="30">1 Month</option>
                                <option value="60">2 Months</option>
                                <option value="90">3 Months</option>
                              </select>
                            </td>
                            <td>&nbsp;&nbsp;
                              <button onclick="printLoanDuesReport()" class="btn btn-social btn-facebook">
                                <i class="ti ti-printer"></i>
                                &nbsp;&nbsp;Print
                              </button>
                            </td>
                          </tr>
                        </table>
                      </center><br><br>
                      <div id="loanduesreport">
                        ';LOAN_REPORTS::DUESREPORT(); echo '
                      </div>
                      <div hidden id="loandues">';LOAN_REPORTS::DUESREPORT(); echo '</div>
                                        </div>
                                    </div>
                                </div>
                <div class="tab-pane" id="tab-6-4">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                      <center><h2><b>Outstanding Balance Report</b></h2></center>
                      <center>
                        <table>
                          <tr>
                            <td><label>Select Year</label>&nbsp;&nbsp;</td>
                            <td>
                              <select onchange="GetOutStandingBalanceReport()" id="yearsid3" class="form-control">';
                               PERIOD_MODULES::YEAR();
                               echo '
                              </select>
                            </td>
                            <td>&nbsp;&nbsp;
                              <button onclick="printOutStandingBalanceeReport()" class="btn btn-social btn-facebook">
                                <i class="ti ti-printer"></i>
                                &nbsp;&nbsp;Print
                              </button>
                            </td>
                          </tr>
                        </table>
                      </center><br><br>
                      <div id="outstandingbalance">
                        ';LOAN_REPORTS::OUTSTANDINGBALANCEREPORT(); echo '
                      </div>
                      <div hidden id="outstandingbal">';LOAN_REPORTS::OUTSTANDINGBALANCEREPORT(); echo '</div>
                                        </div>
                                    </div>
                                </div>
                <div class="tab-pane" id="tab-6-5">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                      <center><h2><b>Disbursement Report</b></h2></center>
                      <center>
                        <table>
                          <tr>
                            <td><label>Select Year</label>&nbsp;&nbsp;</td>
                            <td>
                              <select onchange="GetDisbursemnetReport()" id="yearsid4" class="form-control">';
                               PERIOD_MODULES::YEAR();
                               echo '
                              </select>
                            </td>
                            <td>&nbsp;&nbsp;
                              <button onclick="printDisbursementReport()" class="btn btn-social btn-facebook">
                                <i class="ti ti-printer"></i>
                                &nbsp;&nbsp;Print
                              </button>
                            </td>
                          </tr>
                        </table>
                      </center><br><br>
                      <div id="disbursementreport">
                        ';LOAN_REPORTS::DISBURSEMENTREPORT(); echo '
                      </div>
                      <div hidden id="disbursreport">';LOAN_REPORTS::DISBURSEMENTREPORT(); echo '</div>
                                        </div>
                                    </div>
                                </div>
                <div class="tab-pane" id="tab-6-6">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                      <center><h2><b>Approved/Rejected/Pending Loans Report</b></h2></center>
                      <center>
                        <table>
                          <tr>
                            <td><label>Select Year</label>&nbsp;&nbsp;</td>
                            <td>
                              <select onchange="GetApprovalsReport()" id="yearsid5" class="form-control">';
                               PERIOD_MODULES::YEAR();
                               echo '
                              </select>
                            </td>
                            <td>&nbsp;&nbsp;
                              <button onclick="printApprovalsReport()" class="btn btn-social btn-facebook">
                                <i class="ti ti-printer"></i>
                                &nbsp;&nbsp;Print
                              </button>
                            </td>
                          </tr>
                        </table>
                      </center><br><br>
                      <div id="approvaalsreports">
                        ';LOAN_REPORTS::APPROVALSREPORT(); echo '
                      </div>
                      <div hidden id="approvaalsreports1">';LOAN_REPORTS::APPROVALSREPORT(); echo '</div>
                                        </div>
                                    </div>
                                </div>
                                              <div class="tab-pane" id="tab-6-8">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                      <center><h2><b>Account Balances Report</b></h2></center>
                      <center>
                        <table>
                          <tr>
                            <td>&nbsp;&nbsp;
                              <button onclick="printAccountBalancesReport()" class="btn btn-social btn-facebook">
                                <i class="ti ti-printer"></i>
                                &nbsp;&nbsp;Print
                              </button>
                            </td>
                          </tr>
                        </table>
                      </center><br><br>
                      <div id="accountbalssreport">
                        ';DEPWITH_REPORTS::ACCOUNT_BALANCESREPORT(); echo '
                      </div>
                      <div hidden id="accountbalssreport1">';DEPWITH_REPORTS::ACCOUNT_BALANCESREPORT(); echo '</div>
                                        </div>
                                    </div>
                                </div>
                <div class="tab-pane" id="tab-6-7">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                      <center><h2><b>Guarantors and Collateral Report</b></h2></center>
                      <center>
                        <table>
                          <tr>
                            <td><label>Select Year</label>&nbsp;&nbsp;</td>
                            <td>
                              <select onchange="GetLoanGCsReport()" id="yearsid6" class="form-control">';
                               PERIOD_MODULES::YEAR();
                               echo '
                              </select>
                            </td>
                            <td>&nbsp;&nbsp;
                              <button onclick="printLoanGCReport()" class="btn btn-social btn-facebook">
                                <i class="ti ti-printer"></i>
                                &nbsp;&nbsp;Print
                              </button>
                            </td>
                          </tr>
                        </table>
                      </center><br><br>
                      <div id="loangcreport">
                        ';LOAN_REPORTS::GCREPORT(); echo '
                      </div>
                      <div hidden id="loangcreport1">';LOAN_REPORTS::GCREPORT(); echo '</div>
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
    static function savings_report(){
        NOW_DATETIME::NOW();
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
            <div class="panel-heading">
                            <h2><i class="ti ti-mouse"></i>Savings Reports</h2>
                            <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                            <div class="options">
                                <ul class="nav nav-tabs">
                                    <li class="dropdown pull-right tabdrop hide">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                            <i class="fa fa-angle-down"></i>
                                        </a><ul class="dropdown-menu"></ul>
                                    </li>
                                    <li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">Deposit/Withdraw Transactions</a></li>
                                    <li><a href="#tab-6-2" data-toggle="tab" aria-expanded="false">Day/ Till Sheets</a></li>
                                    <li><a href="#tab-6-3" data-toggle="tab" aria-expanded="false">Savers Statements</a></li>
                                    <li><a href="#tab-6-4" data-toggle="tab" aria-expanded="false">Savings Transaction Report</a></li>
                                    <li><a href="#tab-6-5" data-toggle="tab" aria-expanded="false">Member\'s Ledger</a></li>
                                    <li><a href="#tab-6-6" data-toggle="tab" aria-expanded="false">Account Balances Report</a></li>
                                    <li><a href="#tab-6-7" data-toggle="tab" aria-expanded="false">Non Cash Transaction Report</a></li>
                                    <li><a href="#tab-6-8" data-toggle="tab" aria-expanded="false">Standing Order Reports</a></li>
                                    <li><a href="#tab-6-9" data-toggle="tab" aria-expanded="false">Over Draft Reports</a></li>
                                    <li><a href="#tab-6-10" data-toggle="tab" aria-expanded="false">Fixed Deposit Reports</a></li>
                                </ul>
                            </div>
                        </div>
                         <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane  active" id="tab-6-1">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                      <center><h2><b>Reports on Deposits/Withdraws</b></h2></center>
                      <center>
                        <table>
                          <tr>
                            <td><label>Select Report Type</label>&nbsp;&nbsp;</td>
                            <td>
                              <select onchange="reportchange2()" id="report1" class="form-control">
                                <option value="">select report type</option>
                                <option value="1">General Deposits</option>
                                <option value="2">Individual Deposits</option>
                                <option value="3">Individual Deposits & Withdraws</option>
                                <option value="4">General Withdraws</option>
                                <option value="5">Individual Withdraws</option>
                                <option value="6">General Deposits & Withraws</option>
                                <option value="7">SSL Deposits</option>
                              </select>
                              <span hidden id="perind">
                                <select onchange="getcontentdata()" id="basic" class="selectpicker show-tick form-control" data-live-search="true">
                                    <option value="">select member...</option>
                                    ';CLIENT_DATA::CLIENT_OPTIONSEARCH();  echo'
                                </select><br>
                              </span><br>
                            </td>
                          </tr>
                          <tr>
                            <td><label>Select Year</label>&nbsp;&nbsp;</td>
                            <td>
                              <select id="yearid1" class="form-control">';
                                PERIOD_MODULES::YEAR();
                              echo '
                              </select>
                            </td>
                            <td>&nbsp;<label>month</label>&nbsp;</td>
                            <td>
                              <select id="monthid1" class="form-control">';
                                PERIOD_MODULES::MONTH();
                              echo '
                                <option value="all">All Months</option>
                              </select>
                            </td>
                            <td>
                              &nbsp;&nbsp;
                              <button onclick="GetDWReport()" class="btn"><i class="ti ti-eye"></i>&nbsp;&nbsp;view</button>
                            </td>
                            <td>&nbsp;&nbsp;
                              <button onclick="printDWReport()" class="btn btn-social btn-facebook">
                                <i class="ti ti-printer"></i>
                                &nbsp;&nbsp;Print
                              </button>
                            </td>
                          </tr>
                        </table>
                      </center><br><br>
                                            <div id="withdrawdeposittreport"></div>
                                            <div hidden id="withdrawdeposittreport1"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-6-2">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                      <center><h2><b>Day/ Till Sheet Reports</b></h2></center>
                      <center>
                        <table>
                          <tr>
                            <td><label>Select Report Type</label>&nbsp;&nbsp;</td>
                            <td>
                              <select onchange="reportchange3()" id="report2" class="form-control">
                                <option value="">select report type</option>
                                <option value="1">Day Sheet</option>
                                <option value="2">Till Sheet</option>
                              </select><br>
                            </td>
                          </tr>
                          <tr>
                            <td><label>Select Date</label>&nbsp;&nbsp;</td>
                            <td>
                              <input placeholder="select date" class="form-control" id="datepicker">
                            </td>
                            <td>
                              &nbsp;&nbsp;
                              <button onclick="GetDTSheetReport()" class="btn"><i class="ti ti-eye"></i>&nbsp;&nbsp;view</button>
                            </td>
                            <td>&nbsp;&nbsp;
                              <button onclick="printDTSheetReport()" class="btn btn-social btn-facebook">
                                <i class="ti ti-printer"></i>
                                &nbsp;&nbsp;Print
                              </button>
                            </td>
                          </tr>
                        </table>
                      </center><br><br>
                      <div id="DTSheetreport"></div>
                      <div hidden id="DTSheetreport1"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab-6-3">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                      <center><h2><b>Saver Statement</b></h2></center>
                      <center>
                        <table>
                            <tr>
                                <td><label>Select Client Account</label>&nbsp;&nbsp;</td>
                                <td width="50%">
                                  <select onchange="getcontentdata()" id="basic1" class="selectpicker show-tick form-control" data-live-search="true">
                                    <option value="">select member...</option>
                                    ';CLIENT_DATA::CLIENT_OPTIONSEARCH();  echo'
                                  </select>
                                </td>
                            </tr>
                            <tr>
                            <td><label>Select date range</label></td>
                            <td>
                                <input type="text" id="datepicker2" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">
                                <input type="text" id="datepicker3" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:">
                            </td>
                            <td>
                                <button onclick="GetSaversReport()" class="btn"><i class="ti ti-eye"></i>&nbsp;&nbsp;view</button>
                                
                            </td>
                            <td>&nbsp;&nbsp;
                                  <button onclick="printSaversReport()" class="btn btn-social btn-facebook">
                                    <i class="ti ti-printer"></i>
                                    &nbsp;&nbsp;Print
                                  </button>
                            </td>
                            </tr>
                        </table>
                      </center><br><br>
                      <div id="saverstatementreport"></div>
                      <div hidden id="saverstatementreport1"></div>
                                        </div>
                                    </div>
                                </div>
                <div class="tab-pane" id="tab-6-4">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                      <center><h2><b>Savings Transaction Report</b></h2></center>
                      <center>
                        <table>
                          <tr>
                            <td><label>Select Year</label>&nbsp;&nbsp;</td>
                            <td>
                              <select id="yearid2" class="form-control">';
                               PERIOD_MODULES::YEAR();
                               echo '
                              </select>
                            </td>
                            <td>&nbsp;<label>month</label>&nbsp;</td>
                            <td>
                              <select id="monthid2" class="form-control">';
                               PERIOD_MODULES::MONTH();
                               echo '
                              </select>
                            </td>
                            <td>
                              &nbsp;&nbsp;
                              <button onclick="GetSTransactionReport()" class="btn"><i class="ti ti-eye"></i>&nbsp;&nbsp;view</button>
                            </td>
                            <td>&nbsp;&nbsp;
                              <button onclick="printSTransactionReport()" class="btn btn-social btn-facebook">
                                <i class="ti ti-printer"></i>
                                &nbsp;&nbsp;Print
                              </button>
                            </td>
                          </tr>
                        </table>
                      </center><br><br>
                      <div id="savingtransactionreport"></div>
                      <div hidden id="savingtransactionreport1"></div>
                                        </div>
                                    </div>
                                </div>
                <div class="tab-pane" id="tab-6-5">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
            <center><h2><b>MEMBER\'S LEDGER</b></h2></center>
            <center>
              <table>
                <tr>
                  <td><label>Select Client Account</label>&nbsp;&nbsp;</td>
                  <td width="50%">
                    <select onchange="getcontentdata()" id="basic2" class="selectpicker show-tick form-control" data-live-search="true">
                      <option value="">select member...</option>
                      ';CLIENT_DATA::CLIENT_OPTIONSEARCH();  echo'
                    </select>
                  </td>
                  <td>
                    &nbsp;&nbsp;
                    <button onclick="GetPersonalLedgerReport()" class="btn"><i class="ti ti-eye"></i>&nbsp;&nbsp;view</button>
                  </td>
                  <td>&nbsp;&nbsp;
                    <button onclick="printPersonalLedgerReport()" class="btn btn-social btn-facebook">
                      <i class="ti ti-printer"></i>
                      &nbsp;&nbsp;Print
                    </button>
                  </td>
                </tr>
              </table>
            </center><br><br>
            <div id="personalledgerreport"></div>
            <div style="margin-top:-150" hidden id="personalledgerreport1"></div>
                                        </div>
                                    </div>
                                </div>
                <div class="tab-pane" id="tab-6-6">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
            <center><h2><b>Account Balances Report</b></h2></center>
            <center>
              <table>
                <tr>
                  <td>&nbsp;&nbsp;
                    <button onclick="printAccountBalancesReport()" class="btn btn-social btn-facebook">
                      <i class="ti ti-printer"></i>
                      &nbsp;&nbsp;Print
                    </button>
                  </td>
                </tr>
              </table>
            </center><br><br>
            <div id="accountbalssreport">
              ';DEPWITH_REPORTS::ACCOUNT_BALANCESREPORT(); echo '
            </div>
            <div hidden id="accountbalssreport1">';DEPWITH_REPORTS::ACCOUNT_BALANCESREPORT(); echo '</div>
                                        </div>
                                    </div>
                                </div>
                <div class="tab-pane" id="tab-6-7">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                      <center><h2><b>Non Cash Transactions Report</b></h2></center>
                      <center>
                        <table>
                          <tr>
                            <td><label>Select Year</label>&nbsp;&nbsp;</td>
                            <td>
                              <select id="yearid3" class="form-control">';
                               PERIOD_MODULES::YEAR();
                               echo '
                              </select>
                            </td>
                            <td>&nbsp;<label>month</label>&nbsp;</td>
                            <td>
                              <select id="monthid3" class="form-control">';
                               PERIOD_MODULES::MONTH();
                               echo '
                              </select>
                            </td>
                            <td>
                              &nbsp;&nbsp;
                              <button onclick="GetNonCashTReport()" class="btn"><i class="ti ti-eye"></i>&nbsp;&nbsp;view</button>
                            </td>
                            <td>&nbsp;&nbsp;
                              <button onclick="printNoCashTransactionReport()" class="btn btn-social btn-facebook">
                                <i class="ti ti-printer"></i>
                                &nbsp;&nbsp;Print
                              </button>
                            </td>
                          </tr>
                        </table>
                      </center><br><br>
                      <div id="noncashtransactionreport"></div>
                      <div hidden id="noncashtransactionreport1"></div>
                                        </div>
                                    </div>
                                </div>
                <div class="tab-pane" id="tab-6-8">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                      <center><h2><b>Standing Orders Report</b></h2></center>
                      <center>
                        <table>
                          <tr>
                            <td><label>Select Report Type</label>&nbsp;&nbsp;</td>
                            <td>
                              <select onchange="reportchange2()" id="report5" class="form-control">
                                <option value="">select report type</option>
                                <option value="1">Active Standing Orders</option>
                                <option value="2">Executed Standing Orders</option>
                                <option value="3">Failed Standing Orders</option>
                              </select><br>
                            </td>
                          </tr>
                          <tr>
                            <td><label>Select Year</label>&nbsp;&nbsp;</td>
                            <td>
                              <select id="yearid5" class="form-control">';
                               PERIOD_MODULES::YEAR();
                               echo '
                              </select>
                            </td>
                            <td>
                              &nbsp;&nbsp;
                              <button onclick="GetStandingOrderReport()" class="btn"><i class="ti ti-eye"></i>&nbsp;&nbsp;view</button>
                            </td>
                            <td>&nbsp;&nbsp;
                              <button onclick="printStandingOrderReport()" class="btn btn-social btn-facebook">
                                <i class="ti ti-printer"></i>
                                &nbsp;&nbsp;Print
                              </button>
                            </td>
                          </tr>
                        </table>
                      </center><br><br>
                      <div id="standingorderreport"></div>
                      <div hidden id="standingorderreport1"></div>
                                        </div>
                                    </div>
                                </div>
                <div class="tab-pane" id="tab-6-9">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
            <center><h2><b>Non Cash Transactions Report</b></h2></center>
            <center>
              <table>
                <tr>
                  <td><label>Select Year</label>&nbsp;&nbsp;</td>
                  <td>
                    <select id="yearid3" class="form-control">';
                     PERIOD_MODULES::YEAR();
                     echo '
                    </select>
                  </td>
                  <td>&nbsp;<label>month</label>&nbsp;</td>
                  <td>
                    <select id="monthid3" class="form-control">';
                     PERIOD_MODULES::MONTH();
                     echo '
                    </select>
                  </td>
                  <td>
                    &nbsp;&nbsp;
                    <button onclick="GetNonCashTReport()" class="btn"><i class="ti ti-eye"></i>&nbsp;&nbsp;view</button>
                  </td>
                  <td>&nbsp;&nbsp;
                    <button onclick="printNoCashTransactionReport()" class="btn btn-social btn-facebook">
                      <i class="ti ti-printer"></i>
                      &nbsp;&nbsp;Print
                    </button>
                  </td>
                </tr>
              </table>
            </center><br><br>
            <div id="noncashtransactionreport"></div>
            <div hidden id="noncashtransactionreport1"></div>
                                        </div>
                                    </div>
                                </div>
                <div class="tab-pane" id="tab-6-10">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                      <center><h2><b>Non Cash Transactions Report</b></h2></center>
                      <center>
                        <table>
                          <tr>
                            <td><label>Select Year</label>&nbsp;&nbsp;</td>
                            <td>
                              <select id="yearid3" class="form-control">';
                               PERIOD_MODULES::YEAR();
                               echo '
                              </select>
                            </td>
                            <td>&nbsp;<label>month</label>&nbsp;</td>
                            <td>
                              <select id="monthid3" class="form-control">';
                               PERIOD_MODULES::MONTH();
                               echo '
                              </select>
                            </td>
                            <td>
                              &nbsp;&nbsp;
                              <button onclick="GetNonCashTReport()" class="btn"><i class="ti ti-eye"></i>&nbsp;&nbsp;view</button>
                            </td>
                            <td>&nbsp;&nbsp;
                              <button onclick="printNoCashTransactionReport()" class="btn btn-social btn-facebook">
                                <i class="ti ti-printer"></i>
                                &nbsp;&nbsp;Print
                              </button>
                            </td>
                          </tr>
                        </table>
                      </center><br><br>
                      <div id="noncashtransactionreport"></div>
                      <div hidden id="noncashtransactionreport1"></div>
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
    static function generalsettings(){
          NOW_DATETIME::NOW();  GENERAL_SETTINGS::GEN();
          echo '
              <div class="row">
                  <div class="col-md-12">
                      <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                           <div class="panel-heading">
                              <h2><i class="ti ti-mouse"></i>General Settings</h2>
                              <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                              <div class="options">
                                  <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                  <li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">Settings</a></li>
                                  </ul>
                              </div>
                          </div>
                           <div class="panel-body">
                              <div class="tab-content">
                                   <div class="tab-pane  active" id="tab-6-1">
                                      <div class="row">
                                          <div class="col-md-12">
                                          <center><h3><b>GENERAL SYSTEM SETTINGS</b></h3></center><br>
                                              <div id="generalsettings">
                                                  <table class="table table-bordered">
                                                      <tr><td><h3><b>Account and Share Settings</b></h3></td></tr>
                                                      <tr class="info">
                                                          <td width="40%">
                                                              <label class="labelcolor">Account Requirement Amounts</label>
                                                              <input id="accshrval" type="number" class="form-control" placeholder="Modify Account Requirement Amounts">
                                                          </td>
                                                          <td width="40%">
                                                              <label class="labelcolor">Modify Account Requirement Amounts</label>
                                                              <select onchange="accountnsharesettingdata(document.getElementById(\'accountshare\').value,1)" id="accountshare" class="form-control">
                                                                  <option value="">Select Account Requirement Amounts to Modify</option>
                                                                  <option value="gen03">Monthly Charges</option>
                                                                  <option value="gen06">MemberShip Fees</option>
                                                                  <option value="gen24">Subscription Fees</option>
                                                                  <option value="gen14">Bank Charges</option>
                                                                  <option value="gen05">Minimum Saving Balance</option>
                                                                  <option value="gen13">Pass Book</option>
                                                                  <option value="gen16">WithDraw Charges</option>
                                                                  <option value="gen17">Transfer Charges</option>
                                                                  <option value="gen23">Over Drafts</option>
                                                              </select>
                                                          </td>
                                                          <td width="20%"><br><br>
                                                              <center>
                                                                  <button onclick="savesettings(document.getElementById(\'accountshare\').value,1,document.getElementById(\'accshrval\').value)" class="btn btn-info btn-sm btn-social btn-facebook">save</button>
                                                              </center>
                                                          </td>
                                                      </tr>
                                                      <tr class="info">
                                                          <td width="40%">
                                                              <label class="labelcolor">Share Capital Amounts</label>
                                                              <input id="sharedata1" type="number" class="form-control" placeholder="Modify Share Capital Amounts">
                                                          </td>
                                                          <td width="40%">
                                                              <label class="labelcolor">Modify Share Capital Amounts</label>
                                                              <select onclick="accountnsharesettingdata(document.getElementById(\'getshareid\').value,2)" id="getshareid" class="form-control">
                                                                  <option value="">Select Share Capital Amounts to Modify</option>
                                                                  <option value="gen04">Share Value</option>
                                                                  <option value="gen18">Dividends</option>
                                                              </select>
                                                          </td>
                                                          <td width="20%"><br><br>
                                                              <center>
                                                                  <button onclick="savesettings(document.getElementById(\'getshareid\').value,2,document.getElementById(\'sharedata1\').value)" class="btn btn-info btn-sm btn-social btn-facebook">save</button>
                                                              </center>
                                                          </td>
                                                      </tr>
                                                                                                          <tr class="info">
                                                          <td width="40%">
                                                              <label class="labelcolor">Saving Account Type</label>
                                                              <input id="savingtypedata" type="text" class="form-control" placeholder="Enter Saving Account Type">
                                                          </td>
                                                          <td width="40%">
                                                              <label class="labelcolor">Modify Saving Account</label>
                                                                                                                          <div id="getsavetype">
                                                              <select id="modsavetype" onchange="savingtypefunc()" class="form-control">
                                                                  <option value="">select Saving Account to Modify</option>
                                                                                                                                  '; ACCOUNTTYPE::GETSAVINGTYPE(); echo'
                                                              </select>
                                                                                                                          </div>
                                                          </td>
                                                          <td width="20%"><br><br>
                                                              <center>
                                                                  <button onclick="addsavingtype()" class="btn btn-info btn-sm btn-social btn-facebook">save</button>
                                                                  <button id="delsavetypebut" disabled onclick="removesavetype()" class="btn btn-success btn-sm btn-social btn-youtube">Delete</button>
                                                              </center>
                                                          </td>
                                                      </tr>
                                                                                                          <tr class="info">
                                                          <td width="40%">
                                                                                                                          <label class="labelcolor">Interest as per Saving Account</label>
                                                                                                                          <input id="interestsavetypeinput" type="number" class="form-control" placeholder="Enter Loan Type Interest">
                                                          </td>
                                                          <td width="40%">
                                                              <label class="labelcolor">Modify Interest as per Save Type</label>
                                                              <div id="getsavetypeemodal">
                                                                                                                                  <select id="modesavetypeint" class="form-control">
                                                                                                                                          <option value="">select Interest to Modify</option>
                                                                                                                                          '; ACCOUNTTYPE::GETSAVETYPEPERIOD(); echo'
                                                                                                                                  </select>
                                                                                                                          </div>
                                                          </td>
                                                          <td width="20%"><br><br>
                                                              <center>
                                                                  <button onclick="ModifySaveInterest()" class="btn btn-info btn-sm btn-social btn-facebook">save</button>
                                                              </center>
                                                          </td>
                                                      </tr>
                                                      <tr><td><h3><b>Loan Settings</b></h3></td></tr>
                                                      <tr class="danger">
                                                          <td width="40%">
                                                              <label class="labelcolor">Loan Charges</label>
                                                              <input id="loanchargesid" type="number" class="form-control" placeholder="Modify Loan Charge">
                                                          </td>
                                                          <td width="40%">
                                                              <label class="labelcolor">Modify Loan Charges</label>
                                                              <select onchange="accountnsharesettingdata(document.getElementById(\'loanchargesdataid\').value,3)" id="loanchargesdataid" class="form-control">
                                                                  <option value="">select Loan Charges to Modify</option>
                                                                  <option value="gen02">Loan Application Fees</option>
                                                                  <option value="gen12">Loan Process Fees</option>
                                                                  <option value="gen11">Loan Insurance Fund</option>
                                                                  <option value="gen15">Loan Fines Percentage</option>
                                                                  <option value="gen25">Legal Fees</option>
                                                              </select>
                                                          </td>
                                                          <td width="20%"><br><br>
                                                              <center>
                                                                  <button onclick="savesettings(document.getElementById(\'loanchargesdataid\').value,3,document.getElementById(\'loanchargesid\').value)" class="btn btn-info btn-sm btn-social btn-facebook">save</button>
                                                              </center>
                                                          </td>
                                                      </tr>
                                                      <tr class="danger">
                                                          <td width="40%">
                                                              <label class="labelcolor">Loan Type</label>
                                                              <input id="loantypedata" type="text" class="form-control" placeholder="Enter Loan Type">
                                                          </td>
                                                          <td width="40%">
                                                              <label class="labelcolor">Modify Loan Type</label>
                                                                                                                          <div id="getloantype">
                                                              <select id="modloantype" onchange="loanfunc()" class="form-control">
                                                                  <option value="">select Loan Type to Modify</option>
                                                                                                                                  '; ACCOUNTTYPE::GETLOANTYPE(); echo'
                                                              </select>
                                                                                                                          </div>
                                                          </td>
                                                          <td width="20%"><br><br>
                                                              <center>
                                                                  <button onclick="addloantype()" class="btn btn-info btn-sm btn-social btn-facebook">save</button>
                                                                  <button id="delloantypebut" disabled onclick="removeloantype()" class="btn btn-success btn-sm btn-social btn-youtube">Delete</button>
                                                              </center>
                                                          </td>
                                                      </tr>
                                                      <tr class="danger">
                                                          <td width="40%">
                                                                                                                          <label class="labelcolor">Interest as per Loan Type</label>
                                                                                                                          <input id="interestloantypeinput" type="number" class="form-control" placeholder="Enter Loan Type Interest">
                                                          </td>
                                                          <td width="40%">
                                                              <label class="labelcolor">Modify Interest as per Loan Type</label>
                                                              <div id="getloantypemodal">
                                                                                                                                  <select id="modeloantypeint" class="form-control">
                                                                                                                                          <option value="">select Interest to Modify</option>
                                                                                                                                          '; ACCOUNTTYPE::GETLOANTYPEINTEREST(); echo'
                                                                                                                                  </select>
                                                                                                                          </div>
                                                          </td>
                                                          <td width="20%"><br><br>
                                                              <center>
                                                                  <button onclick="ModifyLoanInterest()" class="btn btn-info btn-sm btn-social btn-facebook">save</button>
                                                              </center>
                                                          </td>
                                                      </tr>
                                                      <tr class="danger">
                                                          <td width="40%">
                                                                                                                          <label class="labelcolor">Grace Period per Loan Type</label>
                                                                                                                          <input id="graceperoid" type="number" class="form-control" placeholder="Enter Loan Type Grace Period">
                                                          </td>
                                                          <td width="40%">
                                                              <label class="labelcolor">Modify Grace Period per Loan Type</label>
                                                                                                                          <div id="modgraceperoid">
                                                              <select id="modgraceperiod" class="form-control">
                                                                  <option value="">select Grace Period to Modify</option>
                                                                                                                                  '; ACCOUNTTYPE::GETLOANTYPEPERIOD(); echo'
                                                              </select>
                                                                                                                          </div>
                                                          </td>
                                                          <td width="20%"><br><br>
                                                              <center>
                                                                  <button onclick="ModifyLoanPeroid()" class="btn btn-info btn-sm btn-social btn-facebook">save</button>
                                                              </center>
                                                          </td>
                                                      </tr>
                                                      <tr class="danger">
                                                          <td width="40%">
                                                              <label class="labelcolor">Loan Provision Percentages</label>
                                                              <input id="perloanprov" type="number" class="form-control" placeholder="Modify Loan Provision Percentages">
                                                          </td>
                                                          <td width="40%">
                                                              <label class="labelcolor">Modify Loan Provision Percentages</label>
                                                              <select id="loanprov"  onchange="accountnsharesettingdata(document.getElementById(\'loanprov\').value,4)"  class="form-control">
                                                                  <option value="">select Loan Provision Percentages to Modify</option>
                                                                  <option value="gen19">Special Mention Loans (> 1 days)</option>
                                                                  <option value="gen20">Substandard Loans (> 30 days)</option>
                                                                  <option value="gen21">Doubtful Loans (> 90 days)</option>
                                                                  <option value="gen22">Loss Loans (> 180 days)</option>
                                                              </select>
                                                          </td>
                                                          <td width="20%"><br><br>
                                                              <center>
                                                                  <button onclick="savesettings(document.getElementById(\'loanprov\').value,4,document.getElementById(\'perloanprov\').value)" class="btn btn-info btn-sm btn-social btn-facebook">save</button>
                                                              </center>
                                                          </td>
                                                      </tr>
                                                      <tr class="danger">
                                                          <td width="40%">
                                                              <label class="labelcolor">Loan Schedule Type</label>
                                                              <select id="schedule" class="form-control">
                                                                  <option value="">select Loan Schedule Type to Activate</option>
                                                                  <option value="2">Reducing Balance Rate</option>
                                                                  <option value="1">Flat Balance Rate</option>
                                                              </select>
                                                          </td>
                                                          <td width="40%">
                                                              <label class="labelcolor">Active Loan Schedule Type</label>
                                                              <input disabled value="'.((GENERAL_SETTINGS::$loanschedule=="1")?"Flat Balance Rate":"Reducing Balance Rate").'" id="veiwschedule" type="text" class="form-control" placeholder="Loan Schedule Type">
                                                          </td>
                                                          <td width="20%"><br><br>
                                                              <center>
                                                                  <button onclick="savesettings(\'gen10\',5,document.getElementById(\'schedule\').value)" class="btn btn-info btn-sm btn-social btn-android">Activate</button>
                                                              </center>
                                                          </td>
                                                      </tr>
                                                      <tr><td><h3><b>Asset Depreciation Settings</b></h3></td></tr>
                                                       <tr class="success">
                                                          <td width="40%">
                                                              <div id="assetdata">
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
                                                              </div>
                                                          </td>
                                                          <td width="40%">
                                                              <div id="deprmodify">
                                                                  <label class="labelcolor">View Depreciation Percentages</label>
                                                                  <select id="modeloantype" class="form-control">
                                                                      <option value="">select Depreciation Percentages to view</option>
                                                                      '; DEPRECIATION::GET_DEPRECIATION(); echo'
                                                                  </select>
                                                              </div>
                                                          </td>
                                                          <td width="20%"><br><br>
                                                              <center>
                                                                  <button onclick="setDepreciation()" class="btn btn-info btn-sm btn-social btn-facebook">save</button>
                                                              </center>
                                                          </td>
                                                      </tr>
                                                      <tr class="warning">
                                                          <td></td>
                                                          <td></td>
                                                          <td></td>
                                                      </tr>
                                                  </table>
                                              </div>
                                          </div>
                                          <div class="col-md-4"></div>
                                      </div>
                                   </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          ';
          form_modals::loanschedule();
    }
    static function chartofaccounts(){
          NOW_DATETIME::NOW();    $db = new DB();
          echo '
              <div class="row">
                  <div class="col-md-12">
                      <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                           <div class="panel-heading">
                              <h2><i class="ti ti-mouse"></i>Chart of Accounts</h2>
                              <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                              <div class="options">
                                  <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                  <li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">Chart of Accounts</a></li>
                                  <li class=""><a href="#tab-6-2" data-toggle="tab" aria-expanded="true">Chart of Accounts Preview</a></li>
                                  </ul>
                              </div>
                          </div>
                           <div class="panel-body">
                              <div class="tab-content">
                                   <div class="tab-pane  active" id="tab-6-1">
                                      <div class="row">
                                          <div class="col-md-6">
                                              <div class="panel panel-teal">
                                              <center><h3><b>CHART OF ACCOUNTS GENERATION</b></h3></center><br>
                                              <div class="col-md-12">
                                                  <div id="chartops">
                                                  <table width="100%" class="table table-bordered table-m-n">
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
                                                              </select><div id="returnedoptions"></div>
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
                                                      echo '
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
                                                  </div>
                                              </div>
                                              </div>
                                          </div>
                                          <div class="col-md-6">
                                          <div class="panel panel-teal">
                                              <center><h2><b>Chart of Accounts Records</b></h2></center></div>
                                              <div id="chartrecords">
                                                  <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                                                      <thead>
                                                          <tr class="info">
                                                              <th width="25%">Code</th>
                                                              <th width="50%">Account Name</th>
                                                              <th width="25%">Actions</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                      </tbody>
                                                  </table>
                                              </div>
                                          </div>
                                      </div>
                                   </div>
                                   <div class="tab-pane" id="tab-6-2">
                                      <div class="row">
                                          <div class="col-md-10 col-md-offset-1">
                                              <center><h2><b>COA Preview</b></h2></center><br>
                                              <div class="panel panel-teal scroll-pane" style="height: 500px;">
                                                  <div class="scroll-content" id="chartpreview">
                                                     ';   SECTIONS::CHART_PREVIEW();    echo '
                                                  </div>
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
    static function Expenses(){
          NOW_DATETIME::NOW();    $db = new DB();    EXPENSES::GET_TOTAL(); VAULT_TRACS::GET_TOTAL1();
          echo '
              <div class="row">
                  <div class="col-md-12">
                      <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                           <div class="panel-heading">
                              <h2><i class="ti ti-mouse"></i>Expenses</h2>
                              <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                              <div class="options">
                                  <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                  <li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">Record General Expenses</a></li>
                                  <li class=""><a href="#tab-6-2" data-toggle="tab" aria-expanded="true">Expense Report</a></li>
                                  </ul>
                              </div>
                          </div>
                           <div class="panel-body">
                              <div class="tab-content">
                                   <div class="tab-pane  active" id="tab-6-1">
                                      <div class="row">
                                          <div class="col-md-5">
                                              <div class="panel panel-teal">
                                              <center><h3><b>Record Expenses</b></h3></center><br>
                                              <div class="col-md-8 col-md-offset-2">
                                                  <div id="expensesdata">
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
                                                  </div>
                                              </div>
                                              </div>
                                          </div>
                                          <div class="col-md-7">
                                          <div class="panel panel-teal">
                                              <center><h2><b>Expense Records</b></h2></center></div>
                                                
                                              <div id="expensetable">
                                                  <div class="alert alert-success" style="background-color: #8bc34a">
                                                     <b style="font-weight: 900;font-size: 28px;color: #ffffff">Total Expenses:  &nbsp;&nbsp; '.number_format(EXPENSES::$tot).'</b>
                                                  </div>
                                                    <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Select date range</label>
                                                        <div class="input-group input-daterange">

                                                        <input type="text" id="datepicker2" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="From:">

                                                        <div class="input-group-addon">to</div>

                                                        <input type="text" id="datepicker3" class="form-control date-range-filter" data-date-format="yyyy-mm-dd" placeholder="To:">
                                                        <div class="input-group-addon"><button id="filterdates"><i class="fa fa-eye">Search</i></button></div>

                                                      </div>
                                                    </div>
                                                    </div><br>
                                                  <table id="grn" cellpadding="0" width="100%" cellspacing="0" border="0" class="table table-bordered m-n">
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
                                              </div>
                                          </div>
                                      </div>
                                   </div>

                                                                  <div class="tab-pane" id="tab-6-2">
                                                                          <div class="row">
                                                                                  <div class="col-md-10 col-md-offset-1">
                                                                                          <center><h2><b>Expense Report</b></h2></center>
                                                                                          <center>
                                                                                                  <table>
                                                                                                          <tr>
                                                                                                                  <td><label>Select Expense Report Type</label>&nbsp;&nbsp;</td>
                                                                                                                  <td>
                                                                                                                          <select onchange="reportchange2()" id="report1" class="form-control">
                                                                                                                                  <option value="">select Expense Report type</option>
                                                                                                                                  <option value="1">Non-Operating Expense Report</option>
                                                                                                                                  <option value="2">Operating Expense Report</option>
                                                                                                                                  <option value="3">General Expense Report</option>
                                                                                                                          </select>
                                                                                                                  </td>
                                                                                                          </tr>
                                                                                                          <tr>
                                                                                                                  <td><label>Select Year</label>&nbsp;&nbsp;</td>
                                                                                                                  <td>
                                                                                                                          <select id="yearid1" class="form-control">
                                                                                                                                  '; PERIOD_MODULES::YEAR(); echo'
                                                                                                                          </select>
                                                                                                                  </td>
                                                                                                                  <td>&nbsp;<label>Month</label>&nbsp;</td>
                                                                                                                  <td>
                                                                                                                          <select id="monthid1" class="form-control">
                                                                                                                                  ';  PERIOD_MODULES::MONTH(); echo'
                                                                                                                                  <option value="all">All Months</option>
                                                                                                                          </select>
                                                                                                                  </td>
                                                                                                                  <td>
                                                                                                                          &nbsp;&nbsp;
                                                                                                                          <button onclick="GetEXPReport()" class="btn"><i class="ti ti-eye"></i>&nbsp;&nbsp;view</button>
                                                                                                                  </td>
                                                                                                                  <td>&nbsp;&nbsp;
                                                                                                                          <button onclick="printSTReport()" class="btn btn-social btn-facebook">
                                                                                                                                  <i class="ti ti-printer"></i>
                                                                                                                                  &nbsp;&nbsp;Print
                                                                                                                          </button>
                                                                                                                  </td>
                                                                                                          </tr>
                                                                                                  </table>
                                                                                          </center><br><br>
                                                                                          <div id="withdrawdeposittreport"></div>
                                                                                          <div hidden id="withdrawdeposittreport1"></div>
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
    static function Assets(){
          NOW_DATETIME::NOW();    $db = new DB();    SYS_CODES::ASSET_NO();
          echo '
              <div class="row">
                  <div class="col-md-12">
                      <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                           <div class="panel-heading">
                              <h2><i class="fa fa-book"></i>Assets</h2>
                              <h2 class="pull-right"><i class="fa fa-calendar"></i>&nbsp;Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                              <div class="options">
                                  <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                  <li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">Record Assets</a></li>
                                  <li class=""><a href="#tab-6-2" data-toggle="tab" aria-expanded="true">Disposeable Assets</a></li>
                                  </ul>
                              </div>
                          </div>
                           <div class="panel-body">
                              <div class="tab-content">
                                   <div class="tab-pane  active" id="tab-6-1">
                                      <div class="row">
                                          <div class="col-md-5">
                                              <div class="panel panel-teal">
                                              <center><h3><b>Record Assets</b></h3></center><br>
                                              <div class="col-md-8 col-md-offset-2">
                                                  <div id="assetdata">
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
                                                  </div>
                                              </div>
                                              </div>
                                          </div>
                                          <div class="col-md-7">
                                          <div class="panel panel-teal">
                                              <center><h2><b>Asset Records</b></h2></center></div>
                                              <div id="assettable">
                                                  <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                                                      <thead>
                                                          <tr class="info">
                                                              <th width="30%">Asset Account</th>
                                                              <th width="40%">Asset Description</th>
                                                              <th width="20%">Asset Value</th>
                                                              <th width="10%">Actions</th>
                                                          </tr>
                                                      </thead>
                                                      <tbody>
                                                      '; ASSETSMANAGEMENT::ASSETLIST(); echo'
                                                      </tbody>
                                                  </table>
                                              </div>
                                          </div>
                                      </div>
                                   </div>
                                                                          <div class="tab-pane" id="tab-6-3">
                                      <div class="row">
                                          <div class="col-md-5">

                                              <div class="panel panel-teal">
                                                  <div class="col-md-8 col-md-offset-2">
                                                  <center><h2><b>Record Asset Purchase</b></h2></center><br>
                                                  <br>
                                                      <div id="assetpurchase">
                                                         <label class="labelcolor">Asset Account</label>
                                                          <select onchange="getassettype()" id="assetaccountid1" class="selectpicker show-tick form-control" data-live-search="true">
                                                              <option value="">select Asset Account</option>';
                                                              ASSETSMANAGEMENT::GET_ASSETACCOUTS();
                                                          echo'
                                                          </select><br>
                                                          <label class="labelcolor">Cash Accounts</label>
                                                          <select onchange="ReturnedCash()" id="cashoptions" class="form-control">
                                                              <option value="">select Cash Account</option>
                                                              <option value="1">Cash at Hand</option>
                                                              <option value="3">Cash at Bank (Cheque)</option>
                                                          </select><br>
                                                          <div id="returnedbanks"></div>
                                                          <label class="labelcolor">Purchase Date</label>
                                                          <input onclick="" id="datepicker2" type="" class="form-control" placeholder="Enter Purchase Date"><br>
                                                          <label class="labelcolor">Asset Description</label>
                                                          <TextArea onclick="" id="assetdesc" type="text" class="form-control" placeholder="Enter Item Description"></TextArea><br>
                                                          <div id="returnedoptionss"></div>
                                                          <label class="labelcolor">Quantity</label>
                                                          <input onclick="" placeholder="Enter Quantity" id="qty" type="number" class="form-control"><br>
                                                          <label class="labelcolor">Total Amount</label>
                                                          <input onclick="" id="amount" type="number" class="form-control" placeholder="Enter Total Amount"><br>
                                                          <center>
                                                              <button class="btn-primary btn" type="" onclick="SaveAsset1()" >Submit Asset Purchase</button>
                                                              <button onclick="cancelAssets1()" class="btn btn-default" >Cancel</button>
                                                          </center> <br><br>
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-7">
                                              <div class="panel panel-teal">
                                                  <center><h2><b>Purchased Asset Records</b></h2></center></div>
                                                  <div id="assetpurchasetable">
                                                      <table id="example" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
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
                                                  </div>
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
          form_modals::assetschedule();
    }
    static function Purchases(){
          NOW_DATETIME::NOW();    $db = new DB();    SYS_CODES::ASSET_NO();
          echo '
              <div class="row">
                  <div class="col-md-12">
                      <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                           <div class="panel-heading">
                              <h2><i class="ti ti-mouse"></i>Credit Transaction</h2>
                              <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                              <div class="options">
                                  <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                  <li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">Credit Purchases</a></li>
                                  <li class=""><a href="#tab-6-2" data-toggle="tab" aria-expanded="true">Credit Sales</a></li>
                                  <li class=""><a href="#tab-6-3" data-toggle="tab" aria-expanded="true">Credit Transactions Report</a></li>
                                  </ul>
                              </div>
                          </div>
                           <div class="panel-body">
                              <div class="tab-content">
                                   <div class="tab-pane  active" id="tab-6-1">
                                      <div class="row">
                                          <div class="col-md-5">
                                              <div class="panel panel-teal">
                                              <center><h3><b>Record Credit Purchase (PAYABLES)</b></h3></center><br>
                                              <div class="col-md-10 col-md-offset-1">
                                                  <div id="purchasecreditdata">
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
                                                  </div>
                                              </div>
                                              </div>
                                          </div>
                                          <div class="col-md-7">
                                          <div class="panel panel-teal">
                                              <center><h2><b>Credit Purchase Records</b></h2></center></div>
                                              <div id="purchasecredittable">
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
                                                      '; CREDITPURCHASE::ASSETLIST(); echo'
                                                      </tbody>
                                                  </table>
                                              </div>
                                          </div>
                                      </div>
                                   </div>
                                   <div class="tab-pane" id="tab-6-2">
                                      <div class="row">
                                          <div class="col-md-5">

                                              <div class="panel panel-teal">
                                                  <div class="col-md-10 col-md-offset-1">
                                                  <center><h3><b>Record Credit Sales (RECEIVEABLES)</b></h3></center><br>
                                                  <br>
                                                      <div id="creditsale">
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
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-7">
                                              <div class="panel panel-teal">
                                                  <center><h2><b>Credit Sales Records</b></h2></center></div>
                                                  <div id="creditsaletable">
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
                                                          '; CREDITSALE::ASSETLIST(); echo'
                                                          </tbody>
                                                      </table>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
                                                                          <div class="tab-pane" id="tab-6-3">
                                      <div class="row">
                                          <div class="col-md-5">

                                              <div class="panel panel-teal">
                                                  <div class="col-md-10 col-md-offset-1">
                                                  <center><h3><b>Record Credit Sales (RECEIVEABLES)</b></h3></center><br>
                                                  <br>
                                                      <div id="creditsale">
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
                                                      </div>
                                                  </div>
                                              </div>
                                          </div>
                                          <div class="col-md-7">
                                              <div class="panel panel-teal">
                                                  <center><h2><b>Credit Sales Records</b></h2></center></div>
                                                  <div id="creditsaletable">
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
                                                          '; CREDITSALE::ASSETLIST(); echo'
                                                          </tbody>
                                                      </table>
                                                  </div>
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
    static function Investiments(){
        NOW_DATETIME::NOW();    $db = new DB();    //SYS_CODES::ASSET_NO();
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                         <div class="panel-heading">
                            <h2><i class="fa fa-bar-chart"></i>Investiments</h2>
                            <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                            <div class="options">
                                <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                <li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">Record Investiment</a></li>
                                <li class=""><a href="#tab-6-2" data-toggle="tab" aria-expanded="true">Investiment Report</a></li>
                                </ul>
                            </div>
                        </div>
                         <div class="panel-body">
                            <div class="tab-content">
                                 <div class="tab-pane  active" id="tab-6-1">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="panel panel-teal">
                                            <center><h3><b>Record Investiment</b></h3></center><br>
                                            <div class="col-md-10 col-md-offset-1">
                                                <div id="incomedata">
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
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                        <div class="panel panel-teal">
                                            <center><h2><b>Investiments Records</b></h2></center></div>
                                            <div id="incometable">
                                                <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                                                    <thead>
                                                        <tr class="info">
                                                            <th width="30%">Account Name</th>
                                                            <th width="40%">Investiment Description</th>
                                                            <th width="25%">Capital Detail</th>
                                                            <th width="5%">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    '; INVESTIMENT::INVESTIMENTLIST(); echo'
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="tab-pane" id="tab-6-2">
                                    <div class="row">
                                        <div class="col-md-5">

                                            <div class="panel panel-teal">
                                                <div class="col-md-10 col-md-offset-1">
                                                <center><h2><b>Record Credit Sales</b></h2></center><br>
                                                <br>
                                                    <div id="creditsale">
                                                        <label class="labelcolor">Account Name</label>
                                                        <select onchange="getassettype()" id="assetaccountid" class="selectpicker show-tick form-control" data-live-search="true">
                                                            <option value="">select Account Name</option>';

                                                        echo'
                                                        </select><br>
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
                                                        <input onclick="" id="datepicker2" type="date" class="form-control" placeholder="Enter Sales Date"><br>
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
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="panel panel-teal">
                                                <center><h2><b>Purchased Asset Records</b></h2></center></div>
                                                <div id="creditsaletable">
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
                                                        '; echo'
                                                        </tbody>
                                                    </table>
                                                </div>
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
    static function ShareTransfers(){
        NOW_DATETIME::NOW();    $db = new DB();    SYS_CODES::ASSET_NO();
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                         <div class="panel-heading">
                            <h2><i class="fa fa-bar-chart"></i>Share Transfer</h2>
                            <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                            <div class="options">
                                <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                <li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">Record Share Transfer</a></li>

                                </ul>
                            </div>
                        </div>
                         <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane  active" id="tab-6-1">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="panel panel-teal">
                                            <center><h3><b>Record Share Transfer</b></h3></center><br>
                                            <div class="col-md-10 col-md-offset-1">
                                                <div id="noncashtransferdata">
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
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                        <div class="panel panel-teal">
                                            <center><h2><b>Share Transfer Records</b></h2></center></div>
                                            <div id="noncashtransfertable">
                                                                                                '; SHARESDATA::RETURNEDSHARETRANSFER(); echo'
                                            </div>
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
    static function Multiple_Deposits(){
        NOW_DATETIME::NOW();    $db = new DB();    SYS_CODES::ASSET_NO();
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                         <div class="panel-heading">
                            <h2><i class="fa fa-bar-chart"></i>Multiple Deposits</h2>
                            <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                            <div class="options">
                                <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                <li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">Record Multiple Deposit</a></li>

                                </ul>
                            </div>
                        </div>
                         <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane  active" id="tab-6-1">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="panel panel-teal">
                                            <center><h3><b>Record Multiple Deposit</b></h3></center><br>
                                            <div class="col-md-10 col-md-offset-1">
                                                <div id="noncashtransferdata">
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
                                                                                                        <div id="clientspace" class="alert alert alert-dismissable alert-danger"></div>
                                                    <label class="labelcolor">Client Name</label>
                                                                                                        <div id="clientdatatrail">
                                                    <select disabled onchange="addclientstotrail()" id="basic" class="selectpicker show-tick form-control" data-live-search="true">
                                                                                                                  <option value="">select member...</option>
                                                                                                                  ';CLIENT_DATA::CLIENT_OPTIONSEARCH();  echo '
                                                                                                        </select><br>
                                                                                                        </div>
                                                    <label class="labelcolor">Deposit Amount</label>
                                                    <input onclick="" id="amtrcvd" type="text" class="form-control" placeholder="Enter Amount Received"><br>
                                                    <center>
                                                        <button class="btn-primary btn" type="" onclick="savemultipledeposit()" >Submit Deposit Record</button>
                                                        <button onclick="cancelmultipledeposit()" class="btn btn-default" >Cancel</button>
                                                    </center> <br><br>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                        <div class="panel panel-teal">
                                            <center><h2><b>Multiple Deposit Records</b></h2></center></div>
                                            <div id="noncashtransfertable">
                                                                                                '; MULTIPLE_DEPOSITS::RETURNEDNONCASHTRANSFER(); echo'
                                            </div>
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
    static function StandingOrders(){
        NOW_DATETIME::NOW();    $db = new DB();    SYS_CODES::ASSET_NO();
        echo '
            <div class="row">
                                <div class="col-md-12">
                                        <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                                                 <div class="panel-heading">
                                                        <h2><i class="fa fa-bar-chart"></i>Standing Orders</h2>
                                                        <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                                                        <div class="options">
                                                                <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                                                <li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">Record Standing Orders</a></li>

                                                                </ul>
                                                        </div>
                                                </div>
                                                 <div class="panel-body">
                                                        <div class="tab-content">
                                                                <div class="tab-pane  active" id="tab-6-1">
                                                                        <div class="row">
                                                                                <div class="col-md-5">
                                                                                        <div class="panel panel-teal">
                                                                                                <center><h3><b>Record Standing Orders</b></h3></center><br>
                                                                                                <div class="col-md-10 col-md-offset-1">
                                                                                                        <div id="noncashtransferdata">
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
                                                                                                        </div>
                                                                                                </div>
                                                                                        </div>
                                                                                </div>
                                                                                <div class="col-md-7">
                                                                                        <div class="panel panel-teal">
                                                                                                <center><h2><b>Standing Order Records</b></h2></center>
                                                                                        </div>
                                                                                        <div id="noncashtransfertable">
                                                                                                '; STANDING_ORDERS::RETURNEDSTANDINGORDER(); echo'
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
    static function SavingAccountTypes(){
        NOW_DATETIME::NOW();    $db = new DB();    SYS_CODES::ASSET_NO();
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                         <div class="panel-heading">
                            <h2><i class="fa fa-bar-chart"></i>Saving Account SetUp</h2>
                            <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                            <div class="options">
                                <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                <li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">Saving Account SetUp</a></li>

                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane  active" id="tab-6-1">
                                    <div class="row">
                                        <div class="col-md-8 col-md-offset-2">
                                        <div class="panel panel-teal">
                                            <center><h2><b>Saving Account SetUp Records</b></h2></center></div>
                                            <div id="noncashtransfertable">
                                                                                                '; ACCOUNTTYPE::SAVINGACCOUNT_SETUP(); echo'
                                            </div>
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
    static function OverDraft(){
        NOW_DATETIME::NOW();    $db = new DB();    SYS_CODES::ASSET_NO();
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                         <div class="panel-heading">
                            <h2><i class="fa fa-bar-chart"></i>OverDraft</h2>
                            <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                            <div class="options">
                                <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                <li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">OverDraft</a></li>

                                </ul>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane  active" id="tab-6-1">
                                    <div class="row">
                                        <div class="col-md-8 col-md-offset-2">
                                        <div class="panel panel-teal">
                                            <center><h2><b>OverDraft SetUp Records</b></h2></center></div>
                                            <div id="noncashtransfertable">
                                                                                                '; CLIENT_DATA::OVERDRAFTLIST(); echo'
                                            </div>
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
    static function Dividends(){
        NOW_DATETIME::NOW();    $db = new DB();    SYS_CODES::ASSET_NO();
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                         <div class="panel-heading">
                            <h2><i class="fa fa-bar-chart"></i>Dividends on Shares</h2>
                            <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                            <div class="options">
                                <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                <li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">Dividends</a></li>

                                </ul>
                            </div>
                        </div>
                         <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane  active" id="tab-6-1">
                                    <div class="row">
                                        <div class="col-md-8 col-md-offset-2">
                                        <div class="panel panel-teal"><center><h2><b>Dividends Records</b></h2></center></div>
                                                                                        <center>
                                                                                                <button id="subbut" class="btn-primary btn" type="" onclick="awarddividends()">Award Dividends</button>
                                                                                        </center> <br>
                                            <div id="noncashtransfertable">
                                                                                                '; DIVIDENDS::RETURNEDDIVIDENDS(); echo'
                                            </div>
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
    static function NonCashTransactions(){
        NOW_DATETIME::NOW();    $db = new DB();    SYS_CODES::ASSET_NO();
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                         <div class="panel-heading">
                            <h2><i class="fa fa-bar-chart"></i>Non-Cash Transactions</h2>
                            <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                            <div class="options">
                                <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                <li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">Record Non Cash Transaction</a></li>

                                </ul>
                            </div>
                        </div>
                         <div class="panel-body">
                            <div class="tab-content">
                                 <div class="tab-pane  active" id="tab-6-1">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="panel panel-teal">
                                            <center><h3><b>Record Non Cash Transaction</b></h3></center><br>
                                            <div class="col-md-10 col-md-offset-1">
                                                <div id="noncashtransferdata">
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
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                        <div class="panel panel-teal">
                                            <center><h2><b>Non Cash Transaction Records</b></h2></center></div>
                                            <div id="noncashtransfertable">
                                                '; NONCASH_TRASNSACTIONS::RETURNEDNONCASHTRANSFER(); echo'
                                            </div>
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
    static function Incomes(){
        NOW_DATETIME::NOW();    $db = new DB();    SYS_CODES::ASSET_NO();
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                         <div class="panel-heading">
                            <h2><i class="fa fa-bar-chart"></i>Income</h2>
                            <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                            <div class="options">
                                <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                    <li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">Record Income</a></li>
                                </ul>
                            </div>
                        </div>
                         <div class="panel-body">
                            <div class="tab-content">
                                 <div class="tab-pane  active" id="tab-6-1">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="panel panel-teal">
                                            <center><h3><b>Record Incomes</b></h3></center><br>
                                            <div class="col-md-10 col-md-offset-1">
                                                <div id="incomedata">
                          <div hidden id="incomeedditdata">'.$row['incomeid'].'</div>
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
                                                    <input onclick="" id="datepicker1" class="form-control" placeholder="Enter Transaction Date"><br>
                                                    <label class="labelcolor">Income Description</label>
                                                    <TextArea onclick="" id="incomedesc" type="text" class="form-control" placeholder="Enter Income Description"></TextArea><br>
                                                    <div id="returnedoptionss"></div>
                                                    <label class="labelcolor">Amount Received</label>
                                                    <input onclick="" id="amtrcvd" type="text" class="form-control" placeholder="Enter Amount Received"><br>
                                                    <center>
                                                        <button class="btn-primary btn" type="" onclick="SaveIncometrail()" >Submit Income Record</button>
                                                        <button onclick="cancelIncome()" class="btn btn-default" >Cancel</button>
                                                    </center> <br><br>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                        <div class="panel panel-teal">
                                            <center><h2><b>Income Records</b></h2></center></div>
                                            <div id="incometable">
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
                                                    '; INCOMETRAIL::INCOMELIST(); echo'
                                                    </tbody>
                                                </table>
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
    static function shares(){
        NOW_DATETIME::NOW();    $db = new DB();    SYS_CODES::ASSET_NO();
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                         <div class="panel-heading">
                            <h2><i class="fa fa-exchange"></i>Shares</h2>
                            <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                            <div class="options">
                                <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                <li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">Share Transactions</a></li>
                                <li class=""><a href="#tab-6-2" data-toggle="tab" aria-expanded="true">Share Ledgers</a></li>
                                </ul>
                            </div>
                        </div>
                         <div class="panel-body">
                            <div class="tab-content">
                                 <div class="tab-pane  active" id="tab-6-1">
                                    <div class="row">
                                        <div class="col-md-8 col-md-offset-2">
                                        <div class="panel panel-teal">
                                            <center><h2><b>Share Records</b></h2></center></div>
                                            <div id="incometable">
                                                <table id="grn" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                                                    <thead>
                                                        <tr class="info">
                                                            <th width="25%">Transaction Date</th>
                                                            <th width="20%">Account Details</th>
                                                            <th width="25%">Transaction Description</th>
                                                            <th width="35%">Share Detail</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    '; DEPOSIT_TRANSACTION::SHARERECORDS(); echo'
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="tab-pane" id="tab-6-2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="panel panel-teal">
                                                <center><h2><b>Client Share Ledger Records</b></h2></center></div>
                                                <div class="row">
                          <div class="col-md-4">
                            <label>Search for Client</label>
                            <select onchange="getsharedata()" id="basic" class="selectpicker show-tick form-control" data-live-search="true">
                                <option value="">select member...</option>
                                ';CLIENT_DATA::CLIENT_OPTIONSEARCH();  echo'
                            </select><br><br>
                          </div>
                        </div>
                        <div id="shareledgertable">
                                                    <table id="example" cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n">
                                                        <thead>
                                                            <tr>
                                                                <th width="6%">Date</th>
                                                                <th width="6%">Reference #</th>
                                <th width="15%">Withdrawals<hr><center>DEBIT</center></th>
                                <th width="15%">Purchased<hr><center>CREDIT</center></th>
                                <th width="20%">Paid Capital Maintainance<hr><center>CREDIT</center></th>
                                <th width="18%">Divideneds on Shares<hr><center>CREDIT</center></th>
                                <th width="10%">Balance</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        ';   echo'
                                                        </tbody>
                                                    </table>
                                                </div>
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
    static function BankTransactions(){
        NOW_DATETIME::NOW();    $db = new DB();
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                         <div class="panel-heading">
                            <h2><i class="fa fa-bank"></i>Bank Transactions&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                            <div class="options">
                                <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                <li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">Bank Transactions</a></li>
                                <li class=""><a href="#tab-6-5" data-toggle="tab" aria-expanded="false">Bank Accounts</a></li>
                                <li class=""><a href="#tab-6-4" data-toggle="tab" aria-expanded="true">Cheques</a></li>
                                <li class=""><a href="#tab-6-2" data-toggle="tab" aria-expanded="true">Borrowings/Loans</a></li>
                                <li class=""><a href="#tab-6-3" data-toggle="tab" aria-expanded="true">Activate Bank Accounts</a></li>
                                </ul>
                            </div>
                        </div>
                         <div class="panel-body">
                            <div class="tab-content">
                                 <div class="tab-pane  active" id="tab-6-1">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="panel panel-teal">
                                            <center><h3><b>Record Bank Transactions</b></h3></center><br>
                                            <div class="col-md-8 col-md-offset-2">
                                                <div id="returnedbanktracs">
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
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                        <div class="panel panel-teal">
                                            <center><h2><b>Transaction Records</b></h2></center></div>
                                            <div id="returnedbanktracstable">
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
                                                        BANKTRANSACTIONS::GET_TRANSACTIONS();
                                            echo'   </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="tab-pane" id="tab-6-5">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                            <center><h2><b>Bank Account Balances</b></h2></center><br>
                                            <div class="panel panel-teal">
                                                <div id="bankaccountbalances">
                                                   ';   CASHACCOUNT::GET_BANKTRANSACTION();    echo '
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="tab-pane" id="tab-6-4">
                                   <div class="row">
                                        <div class="col-md-5">

                                            <div class="panel panel-teal">
                                            <div class="col-md-10 col-md-offset-1">
                                            <center><h2><b>Issue Cheques</b></h2></center><br>
                                                <div id="issuechequesection">
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
                                                    <input onclick="" id="chequeno" type="" class="form-control" placeholder="Enter Cheque No."><br>
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
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="panel panel-teal">
                                                <center><h2><b>Cheque Records</b></h2></center></div>
                                                <div id="returnedchequetable">
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
                                                            CHEQUES::GET_TRANSACTIONS();
                                                echo'   </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                 </div>
                                 <div class="tab-pane" id="tab-6-2">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="panel panel-teal">
                                                <center><h2><b>Add Borrowings/Loan</b></h2></center><br>
                                                <div class="col-md-10 col-md-offset-1">
                                                    <div id="boworringsection">
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
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel panel-teal">
                                                <div id="returnfina">
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
                                                    </div>
                                                    <div id="bankchoice"></div>
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
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="panel panel-teal"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                                                 <div class="panel-heading">
                                                    <h2><i class="ti ti-money"></i>Transactions Records</h2>
                                                    <div class="options">
                                                        <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                                        <li class="active"><a href="#tab-6-7" data-toggle="tab" aria-expanded="false">Borrowing/Loan Records</a></li>
                                                        <li class=""><a href="#tab-6-8" data-toggle="tab" aria-expanded="false">Repayments</a></li>
                                                        </ul>
                                                    </div>
                                                 </div>
                                                 <div class="panel-body">
                                                    <div class="tab-content">
                                                         <div class="tab-pane  active" id="tab-6-7">
                                                            <div id="returnedborrowingtable">
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
                                                                        BORROWINGS::GET_BORROWINGS();
                                                            echo'   </tbody>
                                                                </table>
                                                            </div>
                                                         </div>
                                                         <div class="tab-pane" id="tab-6-8">
                                                            <div id="returnfina">
                                                            <div class="row">
                                                                <center><h5><b>Repayment</b></h5></center>
                                                                <div class="col-md-12">
                                                                    <div class="alert alert-success" style="background-color: #8bc34a">
                                                                        <div id="borroweddetails">
                                                                                <table width="100%">
                                                                                    <tr>
                                                                                        <td width="30%"><b style="color: #ffffff;font-weight: 900">Amount Borrowed :</b></td>
                                                                                        <td width="18%">&nbsp;&nbsp;&nbsp;<b>'.number_format(0).'</b></td>
                                                                                        <td width="10%">&nbsp;&nbsp;&nbsp;<b style="color: #ffffff;font-weight: 900">Bal :</b></td>
                                                                                        <td width="16%">&nbsp;&nbsp;&nbsp;<b>'.number_format(0).'</b></td>
                                                                                        <td width="10%">&nbsp;&nbsp;&nbsp;<b style="color: #ffffff;font-weight: 900">Paid :</b></td>
                                                                                        <td width="16%">&nbsp;&nbsp;&nbsp;<b>'.number_format(0).'</b></td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td><b style="color: #ffffff;font-weight: 900">Interest to be Paid :</b></td>
                                                                                        <td>&nbsp;&nbsp;&nbsp;<b>'.number_format(0).'</b></td>
                                                                                        <td>&nbsp;&nbsp;&nbsp;<b style="color: #ffffff;font-weight: 900">Bal :</b></td>
                                                                                        <td>&nbsp;&nbsp;&nbsp;<b>'.number_format(0).'</b></td>
                                                                                        <td>&nbsp;&nbsp;&nbsp;<b style="color: #ffffff;font-weight: 900">Paid :</b></td>
                                                                                        <td>&nbsp;&nbsp;&nbsp;<b>'.number_format(0).'</b></td>
                                                                                    </tr>
                                                                                </table>
                                                                        </div>
                                                                    </div>
                                                                    <div id="bankchoice12"></div>
                                                                    <div id="repaymentchecks">
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
                                                                                <td><input onclick="" id="reprincipal" type="text" class="form-control" placeholder="Principal"></td>
                                                                                <td><input onclick="" id="reinterest" type="text" class="form-control" placeholder="Interest"></td>
                                                                                <td><input onclick="" id="recharge" type="text" class="form-control" placeholder="Fines/Charges"></td>
                                                                                <td>
                                                                                    <center>
                                                                                        <button class="btn-info btn-social btn" type="" onclick="saverepaymentborrowing()">save</button>
                                                                                    </center>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                </div>
                                                            </div>
                                                            <div id="returnedchequetable1">
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
                                                            </div>
                                                         </div>
                                                    </div>
                                                 </div>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="tab-pane" id="tab-6-3">
                                    <div class="row">
                                        <div class="col-md-6 col-md-offset-3 panel panel-teal">
                                            <center><h2><b>Activate Bank Account</b></h2></center><br>
                                            <div class="col-md-8 col-md-offset-2">
                                                <div id="bankactivatesection">

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
                                                </div>
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
    static function CashTransactions(){
        NOW_DATETIME::NOW();    $db = new DB();
        VAULT_TRACS::GET_TOTAL();
        VAULT_TRACS::GET_TOTAL1();
        VAULT_TRACS::GET_TOTAL2();
        echo '
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                         <div class="panel-heading">
                            <h2><i class="fa fa-bank"></i>Cash Entries&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                            <div class="options">
                                <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                <li class="active"><a href="#tab-6-1" data-toggle="tab" aria-expanded="false">Vault Transactions</a></li>
                                <li class=""><a href="#tab-6-5" data-toggle="tab" aria-expanded="false">Petty Accounts</a></li>
                                <li class=""><a href="#tab-6-2" data-toggle="tab" aria-expanded="true">Cashiers</a></li>
                                </ul>
                            </div>
                        </div>
                         <div class="panel-body">
                            <div class="tab-content">
                                 <div class="tab-pane  active" id="tab-6-1">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="panel panel-teal">
                                            <center><h3><b>Add Vault Record</b></h3></center><br>
                                            <div class="col-md-8 col-md-offset-2">
                                                <div id="returnedvaulttracs">
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
                                                </div>
                                            </div>
                                            </div>
                                            <div id="cashsummay">
                                                '; VAULT_TRACS::CASHSUMMARY(); echo'
                      </div>
                                        </div>
                                        <div class="col-md-7">
                                        <div class="panel panel-teal">
                                            <center><h2><b>Vault Records</b></h2></center></div>
                                            <div id="returnedvaulttracstable">
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
                                           echo'    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="tab-pane" id="tab-6-5">
                                    <div class="row">
                                        <div class="col-md-10 col-md-offset-1">
                                            <center><h2><b>Petty Cash Entry Records</b></h2></center><br>
                                            <div class="panel">
                                                <div id="pettycash">
                                                   ';   VAULT_TRACS::RETURNED_PETTY();    echo '
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 </div>
                                 <div class="tab-pane" id="tab-6-2">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="panel panel-teal">
                                                <center><h2><b>Give/Receive Cash</b></h2></center><br>
                                                <div class="col-md-10 col-md-offset-1">
                                                    <div id="cashieramtsummary"></div>
                                                    <div id="cashiersection">
                                                        '; AUTH_PAGE::CASHIER(); echo'
                            <label class="labelcolor">Action Type</label>
                            <select onchange="inoutcheckcash()" id="actiontype" class="form-control">
                              <option value="">select Action Type</option>
                              <option value="1">Cash In</option>
                              <option value="2">Cash Out</option>
                            </select><br>
                                                        <label class="labelcolor">Transaction Amount</label>
                                                        <input onclick="" id="tracamt" type="text" class="form-control" placeholder="Enter Transaction Amount"><br>
                            <br><br>
                                                        <center>
                                                            <button id="subtrac1" class="btn-info btn" type="" onclick="savecashiertransaction()">submit transaction</button>
                                                            <button class="btn-default btn" type="" onclick="cancelcashiercash()">cancel</button>
                                                        </center> <br><br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <div class="panel panel-teal"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                                                 <div class="panel-heading">
                                                    <h2><i class="ti ti-money"></i>Cashier Records</h2>
                                                    <div class="options">
                                                        <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                                        <li class="active"><a href="#tab-6-7" data-toggle="tab" aria-expanded="false">Cashier In/Out Records</a></li>
                                                        <li class=""><a href="#tab-6-8" data-toggle="tab" aria-expanded="false">Vault To Cashier\'s Record</a></li>
                                                        </ul>
                                                    </div>
                                                 </div>
                                                 <div class="panel-body">
                                                    <div class="tab-content">
                                                         <div class="tab-pane  active" id="tab-6-7">
                                                            <div id="cashierrecords">
                                                               '; CASH_TRACS::RETURNED_CASHIER(); echo'
                                                            </div>
                                                         </div>
                                                         <div class="tab-pane" id="tab-6-8">
                                                            <div id="vaultcashiercash">
                                                                '; VAULT_TRACS::RETURNED_CASHIER();  echo'
                                                            </div>
                                                         </div>
                                                    </div>
                                                 </div>
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

    static function ProfitnLoss(){
        NOW_DATETIME::NOW();  // AUTH_PAGE::$page_no = 2;  AUTH_PAGE::AUTETICATION_VALIDATION();
       echo '
       <div class="row">
           <div class="col-md-12">
                <div class="panel panel-midnightblue">
                    <div class="panel-heading" >
                        <h2><i class="ti ti-bar-chart"></i>Profit & Loss</h2>
                        <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-6 col-md-offset-3">
                                <center><h2><b>Profit & Loss Statement</b></h2></center>
                                <center>
                                    <table>
                                        <tr>
                                            <td><label>Select Year</label>&nbsp;&nbsp;</td>
                                            <td>
                                                <select id="yearid6" class="form-control">';
                                                 PERIOD_MODULES::YEAR();
                                                 echo '
                                                </select>
                                            </td>
                                             <td>&nbsp;<label>month</label>&nbsp;</td>
                                            <td>
                                              <select id="monthid1" class="form-control">';
                                                PERIOD_MODULES::MONTH();
                                              echo '
                                                <option value="all">All Months</option>
                                              </select>
                                            </td>
                                            <td>
                                                &nbsp;&nbsp;
                                                <button onclick="GetPLReport()" class="btn"><i class="ti ti-eye"></i>&nbsp;&nbsp;view</button>
                                            </td>
                                            <td>&nbsp;&nbsp;
                                                <button onclick="printPLReport()" class="btn btn-social btn-facebook">
                                                    <i class="ti ti-printer"></i>
                                                    &nbsp;&nbsp;Print
                                                </button>
                                            </td>
                                        </tr>
                                    </table>
                                </center><br><br>
                            <div id="profitnloss">';
                               FINANCIALSTATEMENTS::PROFIT_LOSS();
                      echo '</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       ';
    }
    static function TrialBalance(){
        NOW_DATETIME::NOW();// AUTH_PAGE::$page_no = 2;  AUTH_PAGE::AUTETICATION_VALIDATION();
       echo '
       <div class="row">
           <div class="col-md-12">
                <div class="panel panel-midnightblue">
                    <div class="panel-heading" >
                        <h2><i class="ti ti-bar-chart"></i>Trial Balance</h2>
                        <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                    </div>
                    <div class="panel-body">
                        <div class="col-md-6 col-md-offset-3">
                                                <center><h2><b>Trial Balance Statement</b></h2></center>
                                                <center>
                                                        <table>
                                                                <tr>
                                                                        <td><label>Select Year</label>&nbsp;&nbsp;</td>
                                                                        <td>
                                                                                <select id="yearid6" class="form-control">';
                                                                                 PERIOD_MODULES::YEAR();
                                                                                 echo '
                                                                                </select>
                                                                        </td>
                                                                        <td>
                                                                                &nbsp;&nbsp;
                                                                                <button onclick="GetTBReport()" class="btn"><i class="ti ti-eye"></i>&nbsp;&nbsp;view</button>
                                                                        </td>
                                                                        <td>&nbsp;&nbsp;
                                                                                <button onclick="printTBReport()" class="btn btn-social btn-facebook">
                                                                                        <i class="ti ti-printer"></i>
                                                                                        &nbsp;&nbsp;Print
                                                                                </button>
                                                                        </td>
                                                                </tr>
                                                        </table>
                                                </center><br><br>
                            <div id="profitnloss">';
                               FINANCIALSTATEMENTS::TRIALBALANCE();
                echo '      </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       ';
    }
    static function BalanceSheet(){
        NOW_DATETIME::NOW();// AUTH_PAGE::$page_no = 2;  AUTH_PAGE::AUTETICATION_VALIDATION();
        echo '
         <div class="row">
             <div class="col-md-12">
                  <div class="panel panel-midnightblue">
                      <div class="panel-heading" >
                          <h2><i class="ti ti-bar-chart"></i>Balance Sheet</h2>
                          <h2 class="pull-right">Date: &nbsp;'.NOW_DATETIME::$Date.'</h2>
                      </div>
                      <div class="panel-body">
                          <div class="col-md-6 col-md-offset-3">
                                                  <center><h2><b>Balance Sheet Statement</b></h2></center>
                                                  <center>
                                                          <table>
                                                                  <tr>
                                                                          <td><label>Select Year</label>&nbsp;&nbsp;</td>
                                                                          <td>
                                                                                  <select id="yearid6" class="form-control">';
                                                                                   PERIOD_MODULES::YEAR();
                                                                                   echo '
                                                                                  </select>
                                                                          </td>
                                                                          <td>
                                                                                  &nbsp;&nbsp;
                                                                                  <button onclick="GetBSReport()" class="btn"><i class="ti ti-eye"></i>&nbsp;&nbsp;view</button>
                                                                          </td>
                                                                          <td>&nbsp;&nbsp;
                                                                                  <button onclick="printBSReport()" class="btn btn-social btn-facebook">
                                                                                          <i class="ti ti-printer"></i>
                                                                                          &nbsp;&nbsp;Print
                                                                                  </button>
                                                                          </td>
                                                                  </tr>
                                                          </table>
                                                  </center><br><br>
                              <div id="profitnloss">';
                                 FINANCIALSTATEMENTS::BALANCESHEET();
                  echo '      </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
         ';
    }
    static function Budgeting(){
            echo '
                    <div class="row">
                                                    <div class="col-md-12">
                                                            <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                                                                    <div class="panel-heading">
                                                                            <h2><i class="fa fa-file-archive-o"></i>Budget Managements</h2>
                                                                            <div class="options">
                                                                                    <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                                                                            <li class="active"><a href="#tab-6-7" data-toggle="tab" aria-expanded="false"><i class="fa fa-level-up"></i> Create Expense Budget</a></li>
                                                                                            <li class=""><a href="#tab-6-8" data-toggle="tab" aria-expanded="false"><i class="fa fa-level-down"></i> Create Income Budget</a></li>
                                                                                            <li class=""><a href="#tab-6-9" data-toggle="tab" aria-expanded="false"><i class="fa fa-pencil"></i> Edit  Budget</a></li>
                                                                                            <li class=""><a href="#tab-6-10" data-toggle="tab" aria-expanded="false"><i class="fa fa-eye"></i> View  Budget</a></li>
                                                                                            <li class=""><a href="#tab-6-11" data-toggle="tab" aria-expanded="false"><i class="ti ti-stats-up"></i> Budget Performance Report</a></li>
                                                                                    </ul>
                                                                            </div>
                                                                    </div>
                                                                    <div class="panel-body">
                                                                            <div class="tab-content">
                                                                                     <div class="tab-pane  active" id="tab-6-7">
                                                                                     <center><h2><b>Generate Expense Budget</b></h2></center>
                                                                                            <div class="col-md-12">
                                                                                                    <table>
                                                                                                            <tr>
                                                                                                                    <td>Year:&nbsp;&nbsp;</td>
                                                                                                                    <td><select id="yeardropdown" class="form-control">'; PERIOD_MODULES::YEAR(); echo '</select></td>
                                                                                                                    <td>&nbsp;Month:&nbsp;</td>
                                                                                                                    <td>
                                                                                                                            <select id="monthdropdown" class="form-control">
                                                                                                                                    ';  PERIOD_MODULES::MONTH(); echo'
                                                                                                                            </select>
                                                                                                                    </td>
                                                                                                            </tr>
                                                                                                    </table><br>
                                                                                            </div>
                                                                                            <div class="col-md-12">
                                                                                                    <input class="btn btn-google btn-social btn-sm" type="button" class="add" onclick="add_row1();" value="Add Row">
                                                                                                    <input class="btn btn-apple btn-social btn-sm" type="button" onclick="generatebudget();" value="GENERATE BUDGET">
                                                                                                    <br><br>
                                                                                                    <div id="feed">
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
                                                                                                    </div>
                                                                                                    <br>
                                                                                            </div>
                                                                                     </div>
                                                                                     <div class="tab-pane" id="tab-6-8">
                                                                                     <center><h2><b>Generate Income Budget</b></h2></center>
                                                                                            <div class="col-md-12">
                                                                                                    <table>
                                                                                                            <tr>
                                                                                                                    <td>Year:&nbsp;&nbsp;</td>
                                                                                                                    <td><select id="yeardropdown1" class="form-control">'; PERIOD_MODULES::YEAR(); echo '</select></td>
                                                                                                                    <td>&nbsp;Month:&nbsp;</td>
                                                                                                                    <td>
                                                                                                                            <select id="monthdropdown1" class="form-control">
                                                                                                                                    ';  PERIOD_MODULES::MONTH(); echo'
                                                                                                                            </select>
                                                                                                                    </td>
                                                                                                            </tr>
                                                                                                    </table><br>
                                                                                            </div>
                                                                                            <div class="col-md-12">
                                                                                                    <input class="btn btn-google btn-social btn-sm" type="button" class="add" onclick="add_row();" value="Add Row">
                                                                                                    <input class="btn btn-apple btn-social btn-sm" type="button" onclick="generatebudget1();" value="GENERATE BUDGET">
                                                                                                    <br><br>
                                                                                                    <div id="feed1">
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
                                                                                                                                            ';  BUDGET::GET_INCOMEACCOUTS(); echo '
                                                                                                                                    </select>
                                                                                                                            </td>
                                                                                                                            <td><input class="form-control" type="text" id="incitem"></td>
                                                                                                                            <td><input class="form-control" type="text" id="inctotal"></td>
                                                                                                                            <td><center><button disabled class="btn btn-danger btn-social btn-sm"><i class="ti ti-close"></i></button></center></td>
                                                                                                                    </tr>
                                                                                                            </table>
                                                                                                    </div>
                                                                                                    <br>
                                                                                            </div>
                                                                                     </div>
                                                                                     <div class="tab-pane" id="tab-6-9">
                                                                                            <div class="row">
                                                                                            <center><h2><b>EDIT Budget</b></h2></center>
                                                                                                    <div class="col-md-12">
                                                                                                            <center>
                                                                                                                    <table>
                                                                                                                            <tr>
                                                                                                                                    <td><label>Select Budget</label>&nbsp;&nbsp;</td>
                                                                                                                                    <td>
                                                                                                                                            <div id="areasearch">
                                                                                                                                            <select onchange="getbudgetchange()" id="budgetsearch" class="selectpicker show-tick form-control" data-live-search="true">
                                                                                                                                                    <option value="">select Budget</option>
                                                                                                                                                    '; BUDGET::GET_BUDGETOPTION(); echo'
                                                                                                                                            </select>
                                                                                                                                            </div>
                                                                                                                                    </td>
                                                                                                                            </tr>
                                                                                                                    </table>
                                                                                                            </center><br><br>
                                                                                                    </div>
                                                                                                    <div class="col-md-4">
                                                                                                            <div id="budgeteditarea"></div>
                                                                                                    </div>
                                                                                                    <div class="col-md-8">
                                                                                                            <div id="budgeteditdata"></div>
                                                                                                    </div>
                                                                                            </div>
                                                                                     </div>
                                                                                     <div class="tab-pane" id="tab-6-10">
                                                                                            <div class="col-md-12">
                                                                                            <center><h2><b>VIEW Budget</b></h2></center>
                                                                                                    <center>
                                                                                                            <table>
                                                                                                                    <tr>
                                                                                                                            <td><label>Select Budget</label>&nbsp;&nbsp;</td>
                                                                                                                            <td>
                                                                                                                                    <div id="areasearch1">
                                                                                                                                    <select onchange="getbudgetchange1()" id="budgetsearch1" class="selectpicker show-tick form-control" data-live-search="true">
                                                                                                                                            <option value="">select Budget</option>
                                                                                                                                            ';  BUDGET::GET_BUDGETOPTION(); echo'
                                                                                                                                    </select>
                                                                                                                                    </div>
                                                                                                                            </td>
                                                                                                                            <td>
                                                                                                                                    &nbsp;&nbsp;
                                                                                                                                    <button onclick="printBUDGETReport()" class="btn btn-social btn-facebook">
                                                                                                                                            <i class="ti ti-printer"></i>
                                                                                                                                            &nbsp;&nbsp;Print
                                                                                                                                    </button>
                                                                                                                            </td>
                                                                                                                    </tr>
                                                                                                            </table>
                                                                                                    </center><br><br>
                                                                                            </div>
                                                                                            <div class="col-md-12">
                                                                                                    <div id="budgetviewdisplay"></div>
                                                                                            </div>
                                                                                     </div>
                                                                                     <div class="tab-pane" id="tab-6-11">
                                                                                            <div class="col-md-12">
                                                                                            <center><h2><b>Budget Performance Report</b></h2></center>
                                                                                                    <center>
                                                                                                            <table>
                                                                                                                    <tr>
                                                                                                                            <td><label>Select Budget</label>&nbsp;&nbsp;</td>
                                                                                                                            <td>
                                                                                                                                    <div id="areasearch1">
                                                                                                                                    <select onchange="getbudgetchange2()" id="budgetsearch2" class="selectpicker show-tick form-control" data-live-search="true">
                                                                                                                                            <option value="">select Budget</option>
                                                                                                                                            ';  BUDGET::GET_BUDGETOPTION(); echo'
                                                                                                                                    </select>
                                                                                                                                    </div>
                                                                                                                            </td>
                                                                                                                            <td>
                                                                                                                                    &nbsp;&nbsp;
                                                                                                                                    <button onclick="printBUDGETReport()" class="btn btn-social btn-facebook">
                                                                                                                                            <i class="ti ti-printer"></i>
                                                                                                                                            &nbsp;&nbsp;Print
                                                                                                                                    </button>
                                                                                                                            </td>
                                                                                                                    </tr>
                                                                                                            </table>
                                                                                                    </center><br><br>
                                                                                            </div>
                                                                                            <div class="col-md-12">
                                                                                                    <div id="budgetperformancew"></div>
                                                                                            </div>
                                                                                     </div>
                                                                            </div>
                                                                    </div>
                                                            </div>
                                                    </div>
                                            </div>
            ';
    }
    static function CashFlowStatement(){
            echo '
                    <div class="row">
                            <div class="col-md-12">
                                    <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                                            <div class="panel-heading">
                                                    <h2><i class="ti ti-money"></i>CASHFLOW STATEMENTS</h2>
                                                    <div class="options">
                                                            <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                                                                    <li class="active"><a href="#tab-6-7" data-toggle="tab" aria-expanded="false"><i class="fa fa-money"></i><i class="ti ti-money"></i> CASH FLOW</a></li>
                                                            </ul>
                                                    </div>
                                            </div>
                                            <div class="panel-body">
                                                    <div class="tab-content">
                                                             <div class="tab-pane  active" id="tab-6-7">
                                                             <center><h2><b>CASHFLOW STATEMENT RECORDS</b></h2></center>
                                                                    <div class="row">
                                                                            <div class="col-sm-12">
                                                                                    <center>
                                                                                            <table>
                                                                                                    <tr>
                                                                                                            <td><label>Select Type</label>&nbsp;&nbsp;</td>
                                                                                                            <td>
                                                                                                                    <select onchange="reportchange2()" id="report1" class="form-control">
                                                                                                                            <option value="">select Type</option>
                                                                                                                            <option value="1">Inflows Statement</option>
                                                                                                                            <option value="2">OutFlows Statement</option>
                                                                                                                            <option value="3">InFlows & OutFlows Statement</option>
                                                                                                                    </select>
                                                                                                            </td>
                                                                                                    </tr>
                                                                                                    <tr>
                                                                                                            <td><label>Select Year</label>&nbsp;&nbsp;</td>
                                                                                                            <td>
                                                                                                                    <select id="yearid1" class="form-control">
                                                                                                                            '; PERIOD_MODULES::YEAR(); echo'
                                                                                                                    </select>
                                                                                                            </td>
                                                                                                            <td>
                                                                                                                    &nbsp;&nbsp;
                                                                                                                    <button onclick="GetSTATReport()" class="btn"><i class="ti ti-eye"></i>&nbsp;&nbsp;view</button>
                                                                                                            </td>
                                                                                                            <td>&nbsp;&nbsp;
                                                                                                                    <button onclick="printCASHFLOWReport()" class="btn btn-social btn-facebook">
                                                                                                                            <i class="ti ti-printer"></i>
                                                                                                                            &nbsp;&nbsp;Print
                                                                                                                    </button>
                                                                                                            </td>
                                                                                                    </tr>
                                                                                            </table>
                                                                                    </center><br><br>
                                                                                    <div id="withdrawdeposittreport"></div>
                                                                                    <div hidden id="withdrawdeposittreport1"></div>
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
    static function ImportMemberData(){
        echo '
          <div class="row">
            <div class="col-md-12">
              <div class="panel panel-midnightblue"  style="visibility: visible; opacity: 1; display: block; transform: translateY(0px);">
                <div class="panel-heading">
                  <h2><img class="img-rounded" style="background-color: #fff" src="images/excel.png" width="20" height="20">&nbsp;&nbsp;IMPORTATION OF CLIENTS</h2>
                  <div class="options">
                    <ul class="nav nav-tabs"><li class="dropdown pull-right tabdrop hide"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="fa fa-angle-down"></i> </a><ul class="dropdown-menu"></ul></li>
                      <li class="active"><a href="#tab-6-7" data-toggle="tab" aria-expanded="false"><img class="img-rounded" src="images/excel.png" width="20" height="20"> IMPORT MEMBER DATA</a></li>
                    </ul>
                  </div>
                </div>
                <div class="panel-body">
                  <div class="tab-content">
                     <div class="tab-pane  active" id="tab-6-7">
                     <center><h2><b>IMPORTATION OF CLIENTS FROM EXCEL</b></h2></center>
                      <div class="row">
                        <div class="col-md-6 col-md-offset-3">
                          <form id="uploadmemberexcel" method="post" action="" enctype="multipart/form-data">
                            <br><br>
                            <label>Upload Excel File</label>
                            <div id="exceldataarea">
                              <input type="file" name="file" class="">
                              <div id="exceldataarea1"></div>
                            </div>
                            <br><br>
                            <button type="submit" id="uploadexcelclient" name="uploadexcel" class="btn btn-success"><i class="fa fa-upload"></i> &nbsp;Upload to save client data</button>
                          </form>
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

}

?>
