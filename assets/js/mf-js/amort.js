/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * @author Joel Nutt
 * ITEC136-V1WW(FA11) - Franklin U.
 * David Crossmier - Instructor
 * Assigment 8-3 (HW07)
 * 11/06/2011
 * 
*/

function getValues(){
    //button click gets values from inputs
    var balance = parseFloat(document.getElementById("principal").value);
    var interestRate = parseFloat(document.getElementById("interest").value/100.0);
    var terms = parseInt(document.getElementById("terms").value);
    var lntype = document.getElementById("loantype").value;
    var dates = document.getElementById("mydates").value;
alert(terms."----".lntype);
    //set the div string
    var div = document.getElementById("Result");

    //in case of a re-calc, clear out the div!
    div.innerHTML = "";

    //validate inputs - display error if invalid, otherwise, display table
    var balVal = validateInputs(balance);
    var intrVal = validateInputs(interestRate);

    if (balVal && intrVal){
        //Returns div string if inputs are valid
        if(lntype ==="0"){
//            div.innerHTML += amortSimple(balance, interestRate, terms, dates);
        }else if(lntype ==="1"){
  //          div.innerHTML += amortReducing(balance, interestRate, terms, dates);
        }else{
    //        div.innerHTML += amortCompound(balance, interestRate, terms, dates);
        }
        
    }else{
        //returns error if inputs are invalid
        div.innerHTML += "Please Check your inputs and retry - invalid values.";
    }
}

/**
 * Amort function:
 * Calculates the necessary elements of the loan using the supplied user input
 * and then displays each months updated amortization schedule on the page
*/
function amortCompound(balance, interestRate, terms, dates){
    //Calculate the per month interest rate
    var monthlyRate = interestRate/12;
	
    //Calculate the payment
    var payment = balance * (monthlyRate/(1-Math.pow(1+monthlyRate, -terms)));
	    
    //begin building the return string for the display of the amort table
    var result = "Loan amount: <b>Ugx :" + thousands_separators(balance.toFixed(0)) +  "</b><br/><br/>" + 
                 "Interest rate: <b>" + thousands_separators((interestRate*100).toFixed(0)) +  "</b>%<br/><br/>" +
                 "Number of months: <b>" + terms + "</b><br/><br/>" +
                 "Monthly payment: <b>Ugx :" + thousands_separators(payment.toFixed(0)) + "</b><br/><br/>" +
                 "Total interest: <b>Ugx :" + thousands_separators(((payment * terms) - balance).toFixed(0)) + "</b><br/><br/>" +
                 "Total paid: <b>Ugx :" + thousands_separators((payment * terms).toFixed(0)) + "</b><br/><br/>";
        
    //add header row for table to return string
	result += "<table  border='1'>\n\
                        <tr><th style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'> <center>Month #</center></th>\n\
                        <th style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'><center>Principal</center></th>\n\
                        <th style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'><center>Interest</center></th>\n\
                        <th style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'><center>Balance Before</center></th>\n\
                        <th style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'><center>Balance After</center></th>\n\
                        <th style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'><center>Monthly Payment</center></th>";
    
    /**
     * Loop that calculates the monthly Loan amortization amounts then adds 
     * them to the return string 
     */
    var bal = balance;
    var loanAmount = balance.toFixed(0);
    var months = terms.toFixed(0);
    var monthlypay = payment.toFixed(0);
    var totalpay = (payment * terms).toFixed(0);
    balance = balance + ((payment * terms) - balance);
    var monthnum="",MonthBalance="",MonthInterest="",MonthPrincipalAmt="",Monthrepayments=""; 
    var ddates = addMonths(dates, 1);
    for (var count = 0; count < terms; ++count){ 
        //in-loop interest amount holder
        var interest = 0;

        //in-loop monthly principal amount holder
        var monthlyPrincipal = 0;

        //start a new table row on each loop iteration
        result += "<tr align=center>";

        //display the month number in col 1 using the loop count variable
        result += "<td style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'>" + addMonths(ddates, count) + "</td>";

  //calc the in-loop monthly principal and display
        interest = balance * monthlyRate;
        monthlyPrincipal = payment - interest;
        var total = (monthlyPrincipal + interest).toFixed(0);
        result += "<td style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'> " + thousands_separators(monthlyPrincipal.toFixed(0)) + "</td>";
        

        //calc the in-loop interest amount and display
        
        result += "<td style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'> " + thousands_separators(interest.toFixed(0)) + "</td>";
        
        //code for displaying in loop balance
        result += "<td style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'> " + thousands_separators(balance.toFixed(0)) + "</td>";

        
        //code for displaying in loop balance
        result += "<td style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'> " + thousands_separators(balance.toFixed(0)) + "</td>";

        
        result += "<td style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'> " + thousands_separators(total)+ "</td>";
        //end the table row on each iteration of the loop	
        result += "</tr>";

        monthnum = monthnum +","+addMonths(ddates, count); 
        MonthBalance = MonthBalance +","+ balance.toFixed(0);
        MonthInterest = MonthInterest+","+ interest.toFixed(0);
        MonthPrincipalAmt = MonthPrincipalAmt+","+monthlyPrincipal.toFixed(0);
        Monthrepayments = Monthrepayments+","+total;

        //update the balance for each loop iteration
        balance = balance - monthlyPrincipal;		
    }
	var dt = bal+":"+(payment * terms).toFixed(0)+":"+terms+":"+monthnum+":"+MonthBalance+":"+MonthBalance+":"+MonthInterest+":"+
                MonthPrincipalAmt+":"+Monthrepayments+":"+((payment * terms) - bal).toFixed(0)+":"+(interestRate*100);
        
	var dt1 = bal+"<br>:"+(payment * terms).toFixed(0)+"<br>:"+terms+"<br>:"+monthnum+"<br>:"+MonthBalance+"<br>:"+MonthBalance+"<br>:"+MonthInterest+"<br>:"+
                MonthPrincipalAmt+"<br>:"+Monthrepayments+"<br>:"+((payment * terms) - bal).toFixed(0)+"<br>:"+(interestRate*100);
	//Final piece added to return string before returning it - closes the table
    result += "</table><div hidden id='scheduledata'>"+dt+"</div>"
	
    //returns the concatenated string to the page
    return result;
}

function amortReducing(balance, interestRate, terms, dates){
    //Calculate the per month interest rate
    var monthlyRate = interestRate;
	
    //Calculate the payment
    var payment = balance * (monthlyRate/(1-Math.pow(1+monthlyRate, -terms)));
	    
    //begin building the return string for the display of the amort table
    var result = "";
        
    //add header row for table to return string
	result += "<table  border='1'>\n\
                        <tr><th style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'> <center>Month #</center></th>\n\
                        <th style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'><center>Principal</center></th>\n\
                        <th style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'><center>Interest</center></th>\n\
                        <th style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'><center>Balance Before</center></th>\n\
                        <th style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'><center>Balance After</center></th>\n\
                        <th style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'><center>Monthly Payment</center></th>";
    
    /**
     * Loop that calculates the monthly Loan amortization amounts then adds 
     * them to the return string 
     */
    var bal = balance;
    var balc = balance;
    var balc1 = balance;
    var loanAmount = balance.toFixed(0);
    var months = terms.toFixed(0);
    var monthlypay = payment.toFixed(0);
    var totalpay = (payment * terms).toFixed(0);
    balance = balance + ((payment * terms) - balance);
    var monthnum="",MonthBalance="",MonthBalanceA="",MonthInterest="",MonthPrincipalAmt="",Monthrepayments=""; 
    var totalInterest1 = 0;
    
    for (var count = 0; count < terms; ++count){ 
        var monthlyPrincipal = 0;
        monthlyPrincipal = bal/terms;
        var inter = (balc1 * interestRate);
        totalInterest1 += inter;
        balc1 = balc1 - monthlyPrincipal;
    }
    var balc2 = bal + totalInterest1;
    var balcAfter = 0;
    var totalInterest = 0; 
    var ddates = addMonths(dates, 1);
    for (var count = 0; count < terms; ++count){ 
        //in-loop interest amount holder
        var interest = 0;

        //in-loop monthly principal amount holder
        var monthlyPrincipal = 0;

        //start a new table row on each loop iteration
        result += "<tr align=center>";

        //display the month number in col 1 using the loop count variable
        result += "<td style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'>" + addMonths(ddates, count) + "</td>";

  //calc the in-loop monthly principal and display
        interest = balance * monthlyRate;
//        monthlyPrincipal = payment - interest;
        monthlyPrincipal = bal/terms;
        
        result += "<td style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'> " + thousands_separators(monthlyPrincipal.toFixed(0)) + "</td>";
        
        var inter = (balc * interestRate);
        totalInterest += inter;
        balc = balc - monthlyPrincipal;
        var total = (monthlyPrincipal + inter).toFixed(0);
        //calc the in-loop interest amount and display
        
        result += "<td style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'> " + thousands_separators(inter.toFixed(0)) + "</td>";
        
        //code for displaying in loop balance
        result += "<td style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'> " + thousands_separators(balc2.toFixed(0)) + "</td>";
        
        
        balcAfter = balc2 - (monthlyPrincipal+inter);
        //code for displaying in loop balance
        result += "<td style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'> " + thousands_separators(balcAfter.toFixed(0)) + "</td>";
        
        result += "<td style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'> " + thousands_separators(total)+ "</td>";
        //end the table row on each iteration of the loop	
        result += "</tr>";

        monthnum = monthnum +","+addMonths(ddates, count); 
        MonthBalance = MonthBalance +","+ balc2.toFixed(0);
        MonthBalanceA = MonthBalanceA +","+ balcAfter.toFixed(0);
        MonthInterest = MonthInterest+","+ inter.toFixed(0);
        MonthPrincipalAmt = MonthPrincipalAmt+","+monthlyPrincipal.toFixed(0);
        Monthrepayments = Monthrepayments+","+total;

        //update the balance for each loop iteration
        balc2 = balc2 -(total);
        balance = balance - monthlyPrincipal;		
    }
    
    var dt = bal+":"+(bal + totalInterest).toFixed(0)+":"+terms+":"+monthnum+":"+MonthBalance+":"+MonthBalanceA+":"+MonthInterest+":"+
            MonthPrincipalAmt+":"+Monthrepayments+":"+totalInterest.toFixed(0)+":"+(interestRate*100);

    var dt1 = bal+"<br>:"+(bal + totalInterest).toFixed(0)+"<br>:"+terms+"<br>:"+monthnum+"<br>:"+MonthBalance+"<br>:"+MonthBalanceA+"<br>:"+MonthInterest+"<br>:"+
            MonthPrincipalAmt+"<br>:"+Monthrepayments+"<br>:"+totalInterest.toFixed(0)+"<br>:"+(interestRate*100);
	//Final piece added to return string before returning it - closes the table
    result += "</table><div hidden id='scheduledata'>"+dt+"</div>"
    
    var details = "Loan amount: <b>Ugx :" + thousands_separators(bal.toFixed(0)) +  "</b><br/><br/>" + 
                 "Interest rate: <b>" + thousands_separators((interestRate*100).toFixed(0)) +  "</b>%<br/><br/>" +
                 "Number of months: <b>" + terms + "</b><br/><br/>" +
                 "Total interest: <b>Ugx :" + thousands_separators(totalInterest.toFixed(0)) + "</b><br/><br/>" +
                 "Total paid: <b>Ugx :" + thousands_separators((bal + totalInterest).toFixed(0)) + "</b><br/><br/>";
	
    //returns the concatenated string to the page
    return details+result;
}

function amortSimple(balance, interestRate, terms, dates){
    //Calculate the per month interest rate
    var monthlyRate = interestRate/12;
	
    //Calculate the payment
    var payment = balance * (monthlyRate/(1-Math.pow(1+monthlyRate, -terms)));
	    
    //begin building the return string for the display of the amort table
    var result = "Loan amount: <b>Ugx :" + thousands_separators(balance.toFixed(0)) +  "</b><br/><br/>" + 
                 "Interest rate: <b>" + thousands_separators((interestRate*100).toFixed(0)) +  "</b>%<br/><br/>" +
                 "Number of months: <b>" + terms + "</b><br/><br/>" +
                 "Monthly payment: <b>Ugx :" + thousands_separators(((balance * interestRate)+(balance/terms)).toFixed(0)) + "</b><br/><br/>" +
                 "Total interest: <b>Ugx :" + thousands_separators(((balance * interestRate)* terms).toFixed(0)) + "</b><br/><br/>" +
                 "Total paid: <b>Ugx :" + thousands_separators((((balance * interestRate)+(balance/terms))* terms).toFixed(0)) + "</b><br/><br/>";
        
    //add header row for table to return string
    result += "<table  border = '1'>\n\
                    <tr><th style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'> <center>Month #</center></th>\n\
                    <th style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'><center>Principal</center></th>\n\
                    <th style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'><center>Interest</center></th>\n\
                    <th style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'><center>Balance Before</center></th>\n\
                    <th style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'><center>Balance After</center></th>\n\
                    <th style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'><center>Monthly Payment</center></th>";

    /**
     * Loop that calculates the monthly Loan amortization amounts then adds 
     * them to the return string 
     */
    var interestAmt = balance * interestRate;
    var months = terms.toFixed(0);
    var monthprincipal = (balance/terms);
    var monthlypay = monthprincipal + interestAmt;
    
    var monthbalbefore = (balance + (interestAmt*months));
    var monthbal = (balance + (interestAmt*months)) - monthlypay; 
    var ddates = addMonths(dates, 1);
    
    var monthnum="", MonthBalanceAfter="",MonthBalanceBefore="", MonthInterest="", MonthPrincipalAmt="", Monthrepayments=""; 
    var mydate = new Date("2015-03-25");
    for (var count = 0; count < terms; ++count){ 
        //in-loop interest amount holder
        var interest = 0;
        
        //in-loop monthly principal amount holder
        var monthlyPrincipal = 0;

        //start a new table row on each loop iteration
        result += "<tr align=center>";

        //display the month number in col 1 using the loop count variable
        result += "<td style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'>" + addMonths(ddates, count) + "</td>";


        //calc the in-loop monthly principal and display
        result += "<td style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'> " + thousands_separators(monthprincipal.toFixed(0)) + "</td>";
        
        //calc the in-loop interest amount and display
        result += "<td style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'> " + thousands_separators(interestAmt.toFixed(0)) + "</td>";


        //code for displaying in loop balance
        result += "<td style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'> " + thousands_separators(monthbalbefore.toFixed(0)) + "</td>";

        //code for displaying in loop balance
        result += "<td style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'> " + thousands_separators(monthbal.toFixed(0)) + "</td>";


        result += "<td style='padding-left: 10px;padding-right: 10px';padding-top: 2px;padding-bottom: 2px;'> " + thousands_separators(monthlypay.toFixed(0))+ "</td>";
        //end the table row on each iteration of the loop	
        result += "</tr>";

        monthnum = monthnum +","+addMonths(ddates, count); 
        MonthBalanceAfter = MonthBalanceAfter +","+ monthbal.toFixed(0);
        MonthBalanceBefore = MonthBalanceBefore +","+ monthbalbefore.toFixed(0);
        MonthInterest = MonthInterest+","+ interestAmt.toFixed(0);
        MonthPrincipalAmt = MonthPrincipalAmt+","+monthprincipal.toFixed(0);
        Monthrepayments = Monthrepayments+","+monthlypay;

        //update the balance for each loop iteration
        monthbal = monthbal - monthlypay;		
        monthbalbefore = monthbalbefore - monthlypay;		
    }
    var dt = balance+":"+(balance + (interestAmt*months))+":"+terms+":"+monthnum+":"+MonthBalanceBefore+":"+MonthBalanceAfter+":"+MonthInterest+":"+MonthPrincipalAmt+":"+Monthrepayments+":"+((balance * interestRate)* terms).toFixed(0)+":"+(interestRate*100);
    var dt1 = balance+"<br>:"+(balance + (interestAmt*months))+"<br>:"+terms+"<br>:"+monthnum+"<br>:"+MonthBalanceBefore+"<br>:"+
            MonthBalanceAfter+"<br>:"+MonthInterest+"<br>:"+MonthPrincipalAmt+"<br>:"+Monthrepayments+"<br>:"+
            ((balance * interestRate)* terms).toFixed(0)+"<br>:"+(interestRate*100);
	//Final piece added to return string before returning it - closes the table
    result += "</table><div hidden id='scheduledata'>"+dt+"</div>"	
    //returns the concatenated string to the page
    return result;
}

function validateInputs(value){
    //some code here to validate inputs
    if ((value === null) || (value === "")){
        return false;
    } else{
        return true;
    }
}

function thousands_separators(num){
    var num_parts = num.toString().split(".");
    num_parts[0] = num_parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    return num_parts.join(".");
}

function addMonths (isoDate, numberMonths) {
    var dateObject = new Date(isoDate),
        day = dateObject.getDate(); // returns day of the month number

    // avoid date calculation errors
    dateObject.setHours(20);

    // add months and set date to last day of the correct month
    dateObject.setMonth(dateObject.getMonth() + numberMonths + 1, 0);

    // set day number to min of either the original one or last day of month
    dateObject.setDate(Math.min(day, dateObject.getDate()));

    return dateObject.toISOString().split('T')[0];
};
function assertEqual(a,b) {
    return a === b;
}


