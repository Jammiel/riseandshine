<?php
require_once 'db_class.php';
require_once 'database_crud.php';
require_once 'system_controller.php';
/**
 * Created by PhpStorm.
 * User: jammieluvie
 * Date: 8/8/16
 * Time: 4:40 PM
 */
error_reporting(0);
AUTH_PAGE::LOGIN_CHECK();
TIMELYTRACKER::tracker();
//if($_GET['datatest']){
//    TIMELYTRACKER::autopayloan();
//}
if($_GET['systeminfo']){
    SYSTEMINFO::GET_HEADER();
}
if($_GET['payrecord']){
    CLIENT_DATA::$clientid = $_GET['payrecord'];
    CLIENT_DATA::RETURN_TRANSACTIONWD();
    echo '|<><>|';
    CLIENT_DATA::RETURN_CLIENTLEDGER();
    echo '|<><>|';
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
}
if($_GET['refreshledger']){
	CLIENT_DATA::$clientid = $_GET['refreshledger'];
    CLIENT_DATA::RETURN_TRANSACTIONWD();
    echo '|<><>|';
    CLIENT_DATA::RETURN_CLIENTLEDGER();
}
if($_GET['withdrawcashcheck']){
    WITHDRAWS::WITHDRAWCASHCHECK();
}
if($_GET['savewithdraw']){
    WITHDRAWS::MAKE_WITHDRAW();
}
if($_GET['depositcashcheck']){
    DEPOSIT_TRANSACTION::DEPOSITCASHCHECK();
}
if($_GET['savedeposit']){
    DEPOSIT_TRANSACTION::MAKE_DEPOSIT();
}
if($_GET['getotherchargesvalues']){
    DEPOSIT_CATEGORY::GET_CHARGES();
}
if($_GET['depositsupvalues']){
    DEPOSIT_CATEGORY::GET_VALUES();
}
if($_GET['saveindividualaccountdata']){
    CLIENT_DATA::SAVE_INDIVIDUALDATA();
}
if($_GET['savegroupaccountdata']){
    CLIENT_DATA::SAVE_GROUPDATA();
}
if($_GET['savebusinessaccount']){
    CLIENT_DATA::SAVE_BUSINESSDATA();
}
if($_GET['individualdata']){
    CLIENT_DATA::INDIVIDUALDATA();
}
if($_GET['groupdata']){
    CLIENT_DATA::GROUPDATA();
}
if($_GET['editindividualdata']){
    CLIENT_DATA::EDIT_INDIVIDUALDATA();
}
if($_GET['groupeditdata']){
    CLIENT_DATA::GROUPEDITDATA();
}
if($_GET['businessdata']){
    CLIENT_DATA::BUSINESSDATA();
}
if($_GET['businesseditdata']){
    CLIENT_DATA::BUSINESSEDITDATA();
}
if($_GET['transactionid']){
    DEPOSIT_TRANSACTION::DETAILED_DEPOSITDESC();
}
if($_GET['guarantor1data']){
    CLIENT_DATA::$clientid = $_GET['guarantor1data'];
    CLIENT_DATA::GUARANTORSCLIENTRESULT();
}
if($_GET['guarantor2data']){
    CLIENT_DATA::$clientid = $_GET['guarantor2data'];
    CLIENT_DATA::GUARANTORSCLIENTRESULT();
}
if($_GET['getloanapplicationdata']){
    CLIENT_DATA::LOANAPPLICATIONDATA();
}
if($_GET['saveloanapplicationdata']){
    LOAN_PROCESSCLASS::SAVE_APPLICATION();
}
if($_GET['saveloanappraisaldata']){
    LOAN_APPRASAILS::loan_appraisal();
}
if($_GET['getloanappraisaldata']){
    CLIENT_DATA::LOANAPPRAISALDATA();
}
if($_GET['forwardforapproval']){
    LOAN_PROCESSCLASS::FORWARD_LOANFORAPPROVAL();
}
if($_GET['loanapproval']){
    LOAN_PROCESSCLASS::MAKE_LOANDECISION();
}
if($_GET['saveloandecisiondata']){
    LOAN_PROCESSCLASS::SAVE_DECISIONS();
}
if($_GET['declinedloans']){
    LOAN_PROCESSCLASS::GET_DECLINEDLOANS();
}
if($_GET['retivedeclinedloans']){
    LOAN_PROCESSCLASS::RETRIVE_DECLINEDLOANS();
}
if($_GET['declineloans']){
    LOAN_PROCESSCLASS::DECLINE_LOAN();
}
if($_GET['loanschedule']){
    LOAN_DISBURSEMENT::Generate_Repay_schedule();
}
if($_GET['returnloanschedule']){
    LOAN_DISBURSEMENT::Return_Repay_schedule();
}
if($_GET['returnloanledger']){
    LOAN_REPAYMENT::Return_LoanLedger();
}
if($_GET['savepostponeduedate']){
    LOAN_DISBURSEMENT::SAVE_POSTDUEDATE_LOANS();
}
if($_GET['restpostponeduedate']){
    LOAN_DISBURSEMENT::RESET_POSTDUEDATE_LOANS();
}
if($_GET['disbursedetail']){
    LOAN_DISBURSEMENT::DISBURSEMENT_DETAIL();
}
if($_GET['sectionlevel']){
    SECTIONS::GET_SECTIONDATA();
}
if($_GET['updatechartcoadestatus']){
    SECTIONS::UPDATE_STATUS();
}
if($_GET['updatechartcoadestatus1']){
    SECTIONS::UPDATE_STATUS1();
}
if($_GET['savesectionlevel']){
    SECTIONS::SAVE_SECTIONS();
}
if($_GET['returnedexpenseaccount']){
    EXPENSES::$code = $_GET['returnedexpenseaccount'];
    EXPENSES::CODE_CHECKER();
}
if($_GET['getreceiveable']){
    CREDITSALE::$code = $_GET['getreceiveable'];
    CREDITSALE::CODE_CHECKER();
}
if($_GET['activatebankactivate']){
    CASHACCOUNT::ACTIVATEACCOUNTS();
}
if($_GET['returnedcashaccount']){
    CASHACCOUNT::GET_BANKACCOUNTS();
}
if($_GET['savebanktransaction']){
    BANKTRANSACTIONS::SAVE_TRANSACTIONS();
}
if($_GET['getbanktransaction']){
    BANKTRANSACTIONS::RETURN_TRANSACTIONS();
}
if($_GET['clearbanktracs']){
    BANKTRANSACTIONS::CANCEL_TRANSACTIONS();
}
if($_GET['clearissuechequesection']){
    CHEQUES::CANCEL_TRANSACTIONS();
}
if($_GET['savechequetransaction']){
    CHEQUES::SAVE_CHEQUETRANSACTIONS();
}
if($_GET['getchequetransaction']){
    CHEQUES::RETURN_TRANSACTIONS();
}
if($_GET['savechequecheck']){
    CHEQUES::SAVE_CHEQUECHECK();
}
if($_GET['savefinancialint']){
    FINANCIALINSTITUTION::SAVE_INSTITUTION();
}
if($_GET['getfinancialint']){
    FINANCIALINSTITUTION::GET_INSTITUTION();
}
if($_GET['cancelfinancialinstitution']){
    FINANCIALINSTITUTION::CANCEL_INSTITUTION();
}
if($_GET['cancelborrowing']){
    BORROWINGS::CANCEL_BORROWING();
}
if($_GET['getborrowingtransaction']){
    BORROWINGS::RETURN_BORROWING();
}
if($_GET['saveborrowing']){
    BORROWINGS::SAVE_BORROWING();
}
if($_GET['getborrowingdetails']){
    BORROWINGS::DETAILS_BORROWING();
}
if($_GET['getbankchoicedetails']){
    FINANCIALINSTITUTION::GET_BANK();
}
if($_GET['getbankchoicedetails1']){
    FINANCIALINSTITUTION::GET_BANK1();
}
if($_GET['getbankchoicedetailsinfo']){
    FINANCIALINSTITUTION::GET_BANKACCOUNT();
}
if($_GET['getorganisationchoice']){
    FINANCIALINSTITUTION::GET_ORGANISATION();
}
if($_GET['getrepaymentborrowing']){
    BORROWINGREPAYMENT::SAVE_REPAYMENT();
}
if($_GET['saveexpense']){
    EXPENSES::SAVE_EXPENSE();
}
if($_GET['cancelexpense']){
    EXPENSES::CANCEL_EXPENSE();
}
if($_GET['setdepreciation']){
    DEPRECIATION::SET_DEPRECIATION();
}
if($_GET['cancelassets']){
    ASSETSMANAGEMENT::CANCELASSETS();
}
if($_GET['getassetype']){
    ASSETSMANAGEMENT::GET_ASSETTYPE();
}
if($_GET['saveassets']){
    ASSETSMANAGEMENT::SAVE_ASSET();
}
if($_GET['savecreditpurchase']){
    CREDITPURCHASE::SAVE_CREDITPURCHASE();
}
if($_GET['cancelcreditpurchase']){
    CREDITPURCHASE::CANCELPURCHASECREDIT();
}
if($_GET['savecreditsale']){
    CREDITSALE::SAVE_CREDITSALE();
}
if($_GET['cancelcreditsale']){
    CREDITSALE::CANCELSALECREDIT();
}
if($_GET['saveinvestment']){
    INVESTIMENT::SAVE_INVESTIMENT();
}
if($_GET['saveincometrail']){
    INCOMETRAIL::SAVE_INCOME();
}
if($_GET['cancelinvestiment']){
    INVESTIMENT::CANCELINVESTIMENT();
}
if($_GET['cancelincometrail']){
    INCOMETRAIL::CANCELINCOME();
}
if($_GET['blacklist']){
    CLIENT_DATA::BLACKLISTACTION();
}
if($_GET['undoblacklist']){
    CLIENT_DATA::UNBLACKLISTACTION();
}
if($_GET['getsharedata']){
    SHARESDATA::SHARELEDGER();
}
if($_GET['getaccountsharedata']){
	GENERAL_SETTINGS::GEN();
	if($_GET['getaccountsharedata']=="gen02"){echo GENERAL_SETTINGS::$loanappl_fees;}
	if($_GET['getaccountsharedata']=="gen03"){echo GENERAL_SETTINGS::$monthlycharges;}
	if($_GET['getaccountsharedata']=="gen06"){echo GENERAL_SETTINGS::$membershipfees;}
	if($_GET['getaccountsharedata']=="gen14"){echo GENERAL_SETTINGS::$bankcharges;}
	if($_GET['getaccountsharedata']=="gen04"){echo GENERAL_SETTINGS::$sharevalue;}
	if($_GET['getaccountsharedata']=="gen05"){echo GENERAL_SETTINGS::$minsavingbal;}
	if($_GET['getaccountsharedata']=="gen11"){echo GENERAL_SETTINGS::$loan_insurancefund;}
	if($_GET['getaccountsharedata']=="gen12"){echo GENERAL_SETTINGS::$loanprocessfees;}
	if($_GET['getaccountsharedata']=="gen13"){echo GENERAL_SETTINGS::$passbook;}
	if($_GET['getaccountsharedata']=="gen15"){echo GENERAL_SETTINGS::$loanpenalty;}
	if($_GET['getaccountsharedata']=="gen16"){echo GENERAL_SETTINGS::$withdrawcharges;}
	if($_GET['getaccountsharedata']=="gen17"){echo GENERAL_SETTINGS::$transferfees;}
	if($_GET['getaccountsharedata']=="gen18"){echo GENERAL_SETTINGS::$dividends;}
	if($_GET['getaccountsharedata']=="gen19"){echo GENERAL_SETTINGS::$specialmention;}
	if($_GET['getaccountsharedata']=="gen20"){echo GENERAL_SETTINGS::$substandardloan;}
	if($_GET['getaccountsharedata']=="gen21"){echo GENERAL_SETTINGS::$doubtfullloan;}
	if($_GET['getaccountsharedata']=="gen22"){echo GENERAL_SETTINGS::$lossloans;}
	if($_GET['getaccountsharedata']=="gen23"){echo GENERAL_SETTINGS::$overdraft;}
	if($_GET['getaccountsharedata']=="gen24"){echo GENERAL_SETTINGS::$subscription;}
	if($_GET['getaccountsharedata']=="gen25"){echo GENERAL_SETTINGS::$legalfees;}
}
if($_GET['updatesetttings']){
	GENERAL_SETTINGS::UPDATE_SETTING();
}
if($_GET['getloantype']){
	ACCOUNTTYPE::ADDLOANTYPE();
}
if($_GET['addsavingtype']){
	ACCOUNTTYPE::ADDSAVETYPE();
}
if($_GET['delloantype']){
	ACCOUNTTYPE::DELLOANTYPE();
}
if($_GET['delsavetype']){
	ACCOUNTTYPE::DELSAVETYPE();
}
if($_GET['modloantypeint']){
	ACCOUNTTYPE::MODLOANTYPEINTEREST();
}
if($_GET['modsavetypeint']){
	ACCOUNTTYPE::MODSAVETYPEINTEREST();
}
if($_GET['modloantypepreoid']){
	ACCOUNTTYPE::MODLOANTYPEPEROID();
}
if($_GET['cashierdestination']){
	AUTH_PAGE::CASHIER();
}
if($_GET['savevaulttracs']){
	VAULT_TRACS::SAVE_VAULTTRACS();
}
if($_GET['savecashiertracs']){
	CASH_TRACS::SAVECASHIER();
}
if($_GET['cancelcashiersection']){
	CASH_TRACS::cancelcashier();
}
if($_GET['cashieramtsummary']){
    CASH_TRACS::CASHIERAMTSUMMARY();
}
if($_GET['vaultcashcheck']){
    VAULT_TRACS::VAULTCASHCHECK();
}
if($_GET['cashcashcheck']){
    CASH_TRACS::CASHCASHCHECK();
}
if($_GET['inoutcashcheck']){
    CASH_TRACS::INOUTCASHCHECK();
}
if($_GET['getsavingbalance']){
    NONCASH_TRASNSACTIONS::SAVINGBAL();
}
if($_GET['savesocheckamt']){
    CASHIER_RECONSILIATION::SAVERECON();
}
if($_GET['savetransfersavings']){
    NONCASH_TRASNSACTIONS::SAVETRANSFERSAVINGS();
}
if($_GET['canceltransfersavings']){
    NONCASH_TRASNSACTIONS::CANCELNONCASHTRANSFER();
}
if($_GET['cancelmultipledeposit']){
    MULTIPLE_DEPOSITS::CANCELMULTIPLEDEPOSIT();
}
if($_GET['addclientstotrail']){
    MULTIPLE_DEPOSITS::ADDCLIENTS();
}
if($_GET['addclientstotrail1']){
    STANDING_ORDERS::ADDCLIENTS();
}
if($_GET['removeclientid1']){
    STANDING_ORDERS::REMOVECLIENTS();
}
if($_GET['removeclientid']){
    MULTIPLE_DEPOSITS::REMOVECLIENTS();
}
if($_GET['clientsizeparticular']){
    MULTIPLE_DEPOSITS::CLIENTSIZEPARTICULAR();
}
if($_GET['savemultipledeposit']){
    MULTIPLE_DEPOSITS::SAVEMULTIPLEDEPOSIT();
}
if($_GET['getshareclientstand']){
    SHARESDATA::GETFROMSHARE();
}
if($_GET['sharecashcheck']){
    SHARESDATA::SHARECASHCHECK();
}
if($_GET['savesharetransferrecords']){
    SHARESDATA::SAVETRANSFERSHARE();
}
if($_GET['canceltransfershare']){
    SHARESDATA::CANCELSHARETRANSFER();
}
if($_GET['awarddividends']){
    DIVIDENDS::AWARDDIVIDENDS();
}
if($_GET['setsavingaccount']){
    ACCOUNTTYPE::UPDATESAVINGTYPE();
}
if($_GET['setoverdraft']){
    CLIENT_DATA::UPDATEOVERDRAFT();
}
if($_GET['cancelstandingorders']){
	STANDING_ORDERS::CANCELSTANDINGORDER();
}
if($_GET['savestandingorder']){
	STANDING_ORDERS::SAVESTANDING_ORDERS();
}
if($_GET['getloanrepaymentreport']){
	$data = explode("?::?",$_GET['getloanrepaymentreport']);
	if($data[1] == "1"){LOAN_REPORTS::REPAYMENT_LIST();}
	if($data[1] == "2"){LOAN_REPORTS::ACTIVELOAN_PREPAYMENTS();}
	if($data[1] == "3"){LOAN_REPORTS::PENALITIES_CHARGED();}
	if($data[1] == "4"){LOAN_REPORTS::PENALITIES_PAID();}
	if($data[1] == "5"){LOAN_REPORTS::FULLYPAIDLOANS();}
	if($data[1] == "6"){LOAN_REPORTS::REAYMENTSOFWRITTENOFFLOANS();}
	if($data[1] == "7"){LOAN_REPORTS::REPORTONFEESRECEIVED();}
	if($data[1] == "8"){LOAN_REPORTS::REPAYMENT_INDIVIDUAL();}
}
if($_GET['getloananalysisreport']){
	$data = explode("?::?",$_GET['getloananalysisreport']);

	if($data[1] == "1"){LOAN_REPORTS::WRITTENOFFLOANS();}
	if($data[1] == "2"){LOAN_REPORTS::TOPBORROERS_REPORT();}
	if($data[1] == "3"){LOAN_REPORTS::ARREARSREPORT();}
	if($data[1] == "4"){LOAN_REPORTS::LoanAgeingReport();}
	if($data[1] == "5"){LOAN_REPORTS::PORTFOLIOATRISK();}
	if($data[1] == "6"){LOAN_REPORTS::REPORT();}
}
if($_GET['writeoffloan']){
	LOAN_WRITEOFF::WRITE_OFF();
}
if($_GET['repaywriteoffloan']){
	WRITEOFF_REPAY::REPAY_WRITEOFF();
}
if($_GET['loanduesreport']){
	LOAN_REPORTS::DUESREPORT();
}
if($_GET['outstandingbalancereport']){
	LOAN_REPORTS::OUTSTANDINGBALANCEREPORT();
}
if($_GET['disbursementreport']){
	LOAN_REPORTS::DISBURSEMENTREPORT();
}
if($_GET['approvalsreport']){
	LOAN_REPORTS::APPROVALSREPORT();
}
if($_GET['loangcreport']){
	LOAN_REPORTS::GCREPORT();
}
if($_GET['depwithreport']){
	DEPWITH_REPORTS::DEPOSITWITHDRAW_REPORTS();
}
if($_GET['dtsheetsreport']){
	DEPWITH_REPORTS::DAYTILLSHEETREPORT();
}
if($_GET['saverstatementreport']){
	DEPWITH_REPORTS::SAVERSTATEMENT();
}
if($_GET['savingtransactionreport']){
	DEPWITH_REPORTS::SAVINGTRANSACTIONSREPORT();
}
if($_GET['personalledgerreport']){
	DEPWITH_REPORTS::PERSONAL_LEDGER();
}
if($_GET['noncashtransactionreport']){
	DEPWITH_REPORTS::NONCASH_TRASNSACTIONSREPORT();
}
if($_GET['standingorderreport']){
	DEPWITH_REPORTS::STANDINGORDERSREPORT();
}
if($_GET['profitnloss']){
	FINANCIALSTATEMENTS::PROFIT_LOSS();
}
if($_GET['findassetpayable']){
	echo '
		<label class="labelcolor">Asset Account</label>
		<select onchange="getassettype()" id="assetaccountck" class="selectpicker show-tick form-control" data-live-search="true">
			<option value="">select Asset Account</option>';
			ASSETSMANAGEMENT::GET_ASSETACCOUTS();
		echo'
		</select><br><br>
	';
}
if($_GET['assetschedule']){
	ASSETSMANAGEMENT::ASSETCHART();
}
if($_GET['getassettracs']){
	ASSETSMANAGEMENT::ASSETDATA();
}
if($_GET['deleteassettracs']){
	ASSETSMANAGEMENT::DELETEASSET();
}
if($_GET['gettbreport']){
	FINANCIALSTATEMENTS::TRIALBALANCE();
}
if($_GET['expensereports']){
	EXPENSES::GET_STATEMENT();
}
if($_GET['inoutstatement']){
	FINANCIALSTATEMENTS::CASHFLOW();
}
if($_GET['budgetitem']){
	BUDGET_ITEM::GENERATE_BUDGET();
}

if($_GET['budgetitem1']){
	BUDGET_ITEM::GENERATE_BUDGET1();
}

if($_GET['getbudgetview']){
	BUDGET::GET_BUDGET();
}
if($_GET['getbudgeteditdata']){
	BUDGET::GET_BUDGETEDITDATA();
}
if($_GET['savebudgetedit']){
	BUDGET::BUDGETEDITCONTENT();
}
if($_GET['budgetedit1']){
	BUDGET::BUDGETEDITCONTENT();
}
if($_GET['budgetviewdisplay']){
	BUDGET::GET_BUDGET1();
}
if($_GET['budgetperformance']){
	BUDGET_ITEM::BUDGETPERFORMANCE();
}
if($_GET['editexpensedata']){
	EXPENSES::EDIT_EXPENSE();
}
if($_GET['editincomedata']){
	INCOMETRAIL::EDIT_INCOME();
}

if($_GET['deleteincomeid']){
	INCOMETRAIL::REMOVE_INCOME();
}

if($_GET['deleteexpenseid']){
	EXPENSES::REMOVE_EXPENSE();
}
if($_GET['save_groupdata']){
	GROUPDATA_ACCOUNT::save_group();
}

if($_GET['savestocking']){
    SOLAR::SAVE_STOCK();
}
if($_GET['clearstock']){
    SOLAR::CANCEL_STOCKING();
}
if($_GET['getstockid']){
    SOLAR::RETURN_STOCKING();
}
if($_GET['addmonths']){
    die("hello people");
    $date = $_GET['mydates'];
    $interval =new DateInterval('P'.$_GET['addmonths'].'M');
    $date->add($interval);
    echo $date->format('Y-m-d');
}
?>
