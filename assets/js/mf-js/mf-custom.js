/**
 * Created by jammieluvie on 12/20/16.
 */

$(function () {
    $("#btnPrint").click(function () {
        var contents = $("#dvContents").html();
        var frame1 = $('<iframe />');
        frame1[0].name = "frame1";
        frame1.css({ "position": "absolute", "top": "-1000000px" });
        $("body").append(frame1);
        var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
        frameDoc.document.open();
        //Create a new HTML document.
        frameDoc.document.write('<html><head><title>DIV Contents</title>');
        frameDoc.document.write('</head><body>');
        //Append the external CSS file.
        frameDoc.document.write('<link href="style.css" rel="stylesheet" type="text/css" />');
        //Append the DIV contents.
        frameDoc.document.write(contents);
        frameDoc.document.write('</body></html>');
        frameDoc.document.close();
        setTimeout(function () {
            window.frames["frame1"].focus();
            window.frames["frame1"].print();
            frame1.remove();
        }, 500);
    });
});

function datatest(){
    
    if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                    var responseArray = xmlhttp.responseText.split("|<><>|");
                    alert(responseArray[0]);

                }
            };
            xmlhttp.open("GET", "classes/ajax_res.php?datatest=1" , true);
            xmlhttp.send();
}
function PrintElem(elem,title){

            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                    var responseArray = xmlhttp.responseText.split("|<><>|");

                    var ttl = title.split("|<><>|");
                    var frame1 = $('<iframe />');
                    frame1[0].name = "frame1";
                    frame1.css({ "position": "absolute", "top": "-1000000px" });
                    $("body").append(frame1);
                    var frameDoc = frame1[0].contentWindow ? frame1[0].contentWindow : frame1[0].contentDocument.document ? frame1[0].contentDocument.document : frame1[0].contentDocument;
                    frameDoc.document.open();
                    //Create a new HTML document.
                    frameDoc.document.write('<html><head><center>'+responseArray[0]+'</center>');
                    frameDoc.document.write('<center><span style="font-size: 18px;font-family: times new roman;font-weight: 700">' + ttl[0]  + '</span></center>');
                    if(ttl[1]){frameDoc.document.write('<center><span style="font-size: 16px;font-family: times new roman;font-weight: 700">As of ' + ttl[1]  + '</span></center>');}
                    frameDoc.document.write('</head><body>');
                    frameDoc.document.write('<link rel="stylesheet" type="text/css" media="print" href="assets/dist/css/bootstrap.min.css"/>');
                    frameDoc.document.write('<link type="text/css" href="assets/plugins/gridforms/gridforms/gridforms.css" rel="stylesheet">');
                    frameDoc.document.write('<div style="font-family: Verdana,sans-serif;line-height: 1.8em">'+document.getElementById(elem).innerHTML+'</div>');

                    frameDoc.document.close();
                    setTimeout(function () {
                            window.frames["frame1"].focus();
                            window.frames["frame1"].print();
                            frame1.remove();
                    }, 500);


                }
            };
            xmlhttp.open("GET", "classes/ajax_res.php?systeminfo=" + "1", true);
            xmlhttp.send();
}

function PrintElem1(elem,title){
        var mywindow = window.open('', 'PRINT', 'height=400,width=600');
		var ttl = title.split("|<><>|");
        var css = '' +
            ' <link rel="stylesheet" type="text/css" media="print" href="assets/css/styles.css">' +
            ' <link rel="stylesheet" type="text/css" media="print" href="assets/dist/css/bootstrap.min.css"/>';

        mywindow.document.write('<html><head><title></title>');
        mywindow.document.write('</head><body >');
		mywindow.document.write(css);
        mywindow.document.write('<center><h1>' + ttl[0]  + '</h1></center>');
		if(ttl[1]){mywindow.document.write('<center><h3>As of ' + ttl[1]  + '</h3></center>');}
        mywindow.document.write(document.getElementById(elem).innerHTML);
        mywindow.document.write('</body></html>');
        mywindow.document.close(); // necessary for IE >= 10
        //mywindow.focus(); // necessary for IE >= 10*/
		setTimeout(function () {
            mywindow.focus();
            mywindow.print();
            mywindow.remove();
        }, 500);


        return true;
 }

function validateinputs(evt) {
    var theEvent = evt || window.event;
    var key  = theEvent.keyCode || theEvent.which;
    key =  String.fromCharCode(key);
    var regex =  /[0-9]|\./;
    if(!regex.test(key)){
        theEvent.returnValue =  false;
        if(theEvent.preventDefault) theEvent.preventDefault();
    }
}
function getcontentdata() {
    if(document.getElementById("basic").value != ""){
        var table = $("grn").DataTable();
        result2data(document.getElementById("basic").value)
        var id = document.getElementById("basic").value
        $(document).ready(function () {
            $('#grn').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });
            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");

            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
        });


    }else {
        document.getElementById("payrecord").innerHTML = '' +
            '<div class="w3-container" style=""> ' +
                '<div class="w3-card-4" style="width:100%;border-radius: 10px"> ' +
                    '<header class="w3-container w3-light-green" style="color: #fff;border-top-left-radius: 10px;border-top-right-radius: 10px;"> ' +
                        '<h4 style="color: #fff;">' +
						'	<b>Acc Name:</b> &nbsp;' +
						'	<b style="font-size: 16px"> &nbsp;&nbsp;&nbsp;Acc Number: &nbsp;</b>' +
						'	<button class="icon-bg pull-right incard1" style=""><i class="ti ti-printer"></i></button>' +
						'	<button data-target="#excelsheetupload" data-toggle="modal"  class="icon-bg pull-right incard2" style="margin-right: 4px"><img src="images/excel.png" width="15px" height="20px"></button></h4>' +
						'</h4>' +
                    '</header> ' +
                    '<div class="w3-container"><hr> ' +
                        '<div class="col-md-2"> ' +
                            '<img src="images/default.png" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px;height: 60px"> ' +
                        '</div> ' +
                        '<div class="col-md-3"> ' +
                            '<b>Savings Account</b><br><br> ' +
                            '<p>Acc Balance: <b>0</b></p> ' +
                        '</div> ' +
                        '<div class="col-md-3"> ' +
                            '<b>Share Capital</b><br><br> ' +
                            '<p style="font-size: 12px">Share Amount: <b>0</b></p> ' +
                            '<p style="font-size: 12px">No. of Shares: <b>0</b></p> ' +
                        '</div> ' +
                        '<div class="col-md-4"> ' +
                            '<b>Loan Information</b><br><br> ' +
                            '<p style="font-size: 12px">Outstanding Balance: <b>0</b></p> ' +
                            '<p style="font-size: 12px">Loan Penalty: <b>0</b></p> ' +
                        '</div> ' +
                    '</div><hr> ' +
                    '<button disabled class="w3-btn-block w3-dark-grey" style="border-bottom-right-radius: 10px;border-bottom-left-radius: 10px"><i class="fa fa-refresh"></i> &nbsp;&nbsp;Refresh Info</button> ' +
                '</div> ' +
            '</div><br>'
        document.getElementById("grn").innerHTML = '' +
            '<div class="col-md-12" id="payrecord"></div> ' +
            '<table cellpadding="0" width = "100%" cellspacing="0" border="0" class="table table-bordered m-n" id="grn">' +
                '<thead> ' +
                    '<tr>' +
                        '<th width = "10%">Date</th>' +
                        '<th width = "30%">Description</th>' +
                        '<th width = "15%"><b style="font-size: 12px">Withdrawls<br>DEBIT</b></th>' +
                        '<th width = "15%"><b style="font-size: 12px">Deposits<br>CREDIT</b></th>' +
                        '<th width = "20%">Balance</th><th width = "10%">Initials</th>' +
                    '</tr>' +
                '</thead>' +
                '<tbody>' +
                '</tbody>' +
            '</table>' +
            '<br>';
        $('#grn').DataTable({
            "bDestroy": true,
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "sDom": 'lfrtip'
        });
        $('.dataTables_filter input').attr('placeholder','Search...');
        $('.panel-ctrls').append($('.dataTables_empty').add("empty"));
        $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
        $('.panel-ctrls').append("<i class='separator'></i>");
        $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");

        $('.panel-footer').append($(".dataTable+.row"));
        $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
    }
}
function result2data(str) {

    if(document.getElementById("basic").value === ""){}else {

        if (str === "") {
            document.getElementById("payrecord").innerHTML = '' +
                'Amount Paid To Farmer So Far: <input readonly id="amtr" type="text" class="form-control"  name="amount_recovered" style="border:1px;border-bottom-style: dotted;border-top-style: none;border-right-style: none;border-left-style: none;"  required>' +
                'Remaining Amount To Be Paid: <input readonly id="amtb" type="text" class="form-control"  name="balance" style="border:1px;border-bottom-style: dotted;border-top-style: none;border-right-style: none;border-left-style: none;"  required />';
            return;
        } else {
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                    var responseArray = xmlhttp.responseText.split("|<><>|");
                    document.getElementById("payrecord").innerHTML = responseArray[0];
                    document.getElementById("clientledger").innerHTML = responseArray[1];
                    document.getElementById("deposittable").innerHTML = responseArray[2];
                    document.getElementById("deposittotamt").value = "";
                    document.getElementById("depositor").value = "";
                    document.getElementById("withdrawamt").value = "";
                    document.getElementById("withdrawor").value = "";

                    $('#grn').DataTable({
                        "bDestroy": true,
                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": true,
                        "sDom": 'lfrtip'
                    });

                    $('.dataTables_filter input').attr('placeholder','Search...');
                    $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
                    $('.panel-ctrls').append("<i class='separator'></i>");
                    $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
                    $('.panel-footer').append($(".dataTable+.row"));
                    $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
                }
            };
            xmlhttp.open("GET", "classes/ajax_res.php?payrecord=" + str, true);
            xmlhttp.send();
        }
    }
}
function refreshledger(){
	var str = document.getElementById("basic").value;
	if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                    var responseArray = xmlhttp.responseText.split("|<><>|");
                    document.getElementById("payrecord").innerHTML = responseArray[0];
                    document.getElementById("clientledger").innerHTML = responseArray[1];

                    $('#grn').DataTable({
                        "bDestroy": true,
                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": true,
                        "sDom": 'lfrtip'
                    });

                    $('.dataTables_filter input').attr('placeholder','Search...');
                    $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
                    $('.panel-ctrls').append("<i class='separator'></i>");
                    $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
                    $('.panel-footer').append($(".dataTable+.row"));
                    $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
                }
            };
            xmlhttp.open("GET", "classes/ajax_res.php?refreshledger=" + str, true);
            xmlhttp.send();
}
function depositchoices(str) {
    if(document.getElementById('basic').value==''){
        new PNotify({
            title: 'MISSING INPUT!',
            text: 'Enter Client and try again.',
            type: 'warning',
            icon: 'ti ti-close',
            styling: 'fontawesome'
        });
        document.getElementById('deptbox'+str).checked = false;
    }else{
        if(document.getElementById('deptbox'+str).checked == true){
            document.getElementById('deptinput'+str).disabled = false;
            var supvalues = document.getElementById('supvalues'+str).innerHTML+"?::?"+str+"?::?"+document.getElementById('basic').value;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                    var responseArray = xmlhttp.responseText.split("|<><>|");
                        if(responseArray[0]==""){
                             document.getElementById("deptinput"+str).value = "";
                             document.getElementById("deptinput"+str).disabled = false;
                        }else{
                             document.getElementById("deptinput"+str).value = responseArray[0];
                             document.getElementById("deptinput"+str).disabled = true;
                        }

                    sumdepositamt(str);
                    if(responseArray[1]){
                        document.getElementById("others"+str).innerHTML=responseArray[1];
						$('#basic1').selectpicker({
							"livesearch":true
						});
                    }
                    if(responseArray[2]=="1"){
                          document.getElementById("deptinput"+str).value = "";
                          document.getElementById("deptinput"+str).disabled = true
                          document.getElementById('deptbox'+str).checked = false;
                          new PNotify({
                            title: 'WARNING',
                            text: 'Client Doesnt Have An Active Loan',
                            type: 'warning',
                            icon: 'ti ti-close',
                            styling: 'fontawesome'
                          });

                   }
                   if(responseArray[2]=="2"){
						  document.getElementById("deptinput"+str).value = "";
						  document.getElementById("deptinput"+str).disabled = true
						  document.getElementById('deptbox'+str).checked = false;
						  new PNotify({
							title: 'WARNING',
							text: 'Client Has A pending Application',
							type: 'warning',
							icon: 'ti ti-close',
							styling: 'fontawesome'
						  });

                   }

                }
            };
            xmlhttp.open("GET", "classes/ajax_res.php?depositsupvalues=" + supvalues, true);
            xmlhttp.send();
        }else{
            sumdepositamt(str);
            document.getElementById('deptinput'+str).disabled = true;
            document.getElementById('deptinput'+str).value = "";
            document.getElementById('others'+str).innerHTML = "";
        }
    }
}
function getothercharges(str) {
    var supvalues = document.getElementById("othercharges").value+"?::?"+document.getElementById("basic").value;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById("deptinput"+str).value = responseArray[0];
                sumdepositamt(str);
                if(responseArray[1]=="2"){
                          document.getElementById("deptinput"+str).value = "";
                          document.getElementById("deptinput"+str).disabled = true
                          new PNotify({
                            title: 'WARNING',
                            text: 'Client Doesnt Have A Loan Penalty',
                            type: 'warning',
                            icon: 'ti ti-close',
                            styling: 'fontawesome'
                          });

                }
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?getotherchargesvalues=" + supvalues, true);
    xmlhttp.send();
}
function sumdepositamt(str) {
    if(document.getElementById('deptinput'+str).value == ""){
        document.getElementById('deptinput'+str).value = 0;
    }
    var trs = document.getElementById('deposittable').getElementsByTagName('tr');
    var tot = 0;
    for( var k = 1;k < trs.length;k++){
        var tds = trs[k].getElementsByTagName('td');
        if(tds[0].getElementsByTagName('input')[0].checked===true){
            if(tds[2].getElementsByTagName('input')[0].value==""){tds[2].getElementsByTagName('input')[0].value=0;}
            tot += parseInt(tds[2].getElementsByTagName('input')[0].value);
        }
    }
    document.getElementById('deposittotamt').value = tot;
}
function savedeposit() {
    var depcheckval ="1";
    if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
    } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");


            if(responseArray[0] == "1"){
                new PNotify({
                        title: 'YOU ARE UNDER A CLOSED COUNTER, CONTACT CHIEF CASHIER TO OPEN!',
                        text: 'And try again.',
                        type: 'warning',
                        icon: 'ti ti-close',
                        styling: 'fontawesome'
                    });
            }else{
                if(document.getElementById('basic').value==''){
                    new PNotify({
                        title: 'MISSING INPUT!',
                        text: 'Enter Client and try again.',
                        type: 'warning',
                        icon: 'ti ti-close',
                        styling: 'fontawesome'
                    });
                }else if(document.getElementById('depositor').value=='') {
                    new PNotify({
                        title: 'MISSING INPUT!',
                        text: 'Enter Depositor and try again.',
                        type: 'warning',
                        icon: 'ti ti-close',
                        styling: 'fontawesome'
                    });
                }else if(document.getElementById('deposittotamt').value=='' || document.getElementById('deposittotamt').value=='0') {
                    new PNotify({
                        title: 'MISSING INPUT!',
                        text: 'Enter Valid entries and try again.',
                        type: 'warning',
                        icon: 'ti ti-close',
                        styling: 'fontawesome'
                    });
                } else{
                    document.getElementById('savebutdeposit').disabled = true;
                    var cats = "?::?";
                    var inputvals = "?::?";
                    var trs = document.getElementById('deposittable').getElementsByTagName('tr');

                    for( var k = 1;k < trs.length;k++){
                        var tds = trs[k].getElementsByTagName('td');
                        if(tds[0].getElementsByTagName('input')[0].checked===true){
                                if(tds[3].innerHTML=="9"){
                                        cats += ",charges"+tds[2].getElementsByTagName('select')[0].value ;

                                }else{
                                        cats += "," + tds[3].innerHTML;
                                }
                                inputvals += "," + tds[2].getElementsByTagName('input')[0].value;
                        }
                    }

                    var data =  document.getElementById('deposittotamt').value+"?::?"+document.getElementById('basic').value+"?::?"+document.getElementById('depositor').value+cats+inputvals;
                    if (window.XMLHttpRequest) {
                            xmlhttp = new XMLHttpRequest();
                    } else {
                            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                            var responseArray = xmlhttp.responseText.split("|<><>|");
                            document.getElementById("deposittable").innerHTML = responseArray[0];
                            document.getElementById("payrecord").innerHTML = responseArray[1];
                            document.getElementById("clientledger").innerHTML = responseArray[2];
                            document.getElementById("wdtransactionledger").innerHTML = responseArray[3];
                            document.getElementById("deposittotamt").value = "";
                            document.getElementById("depositor").value = ""; 
                            document.getElementById('savebutdeposit').disabled = false; 
                            if(responseArray[4]){
                                if(responseArray[4]===""){}
                            }

                            $('#grn').DataTable({
                                "bDestroy": true,
                                "paging": true,
                                "lengthChange": true,
                                "searching": true,
                                "ordering": true,
                                "info": true,
                                "autoWidth": true,
                                "sDom": 'lfrtip'
                            });

                            $('#example').DataTable({
                                "bDestroy": true,
                                "paging": true,
                                "lengthChange": true,
                                "searching": true,
                                "ordering": true,
                                "info": true,
                                "autoWidth": true,
                                "sDom": 'lfrtip'
                            });

                            $('.dataTables_filter input').attr('placeholder','Search...');
                            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
                            $('.panel-ctrls').append("<i class='separator'></i>");
                            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
                            $('.panel-footer').append($(".dataTable+.row"));
                            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
                        }
                    };
                    xmlhttp.open("GET", "classes/ajax_res.php?savedeposit=" + data, true);
                    xmlhttp.send();
                }
            }
        }

    };

    xmlhttp.open("GET", "classes/ajax_res.php?depositcashcheck=" + depcheckval, true);
    xmlhttp.send();
}
function savewithdraw() {
	var datas = document.getElementById("withdrawamt").value+"?::?"+document.getElementById('basic').value;
	if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");

				if(responseArray[0] == "1"){
					new PNotify({
						title: 'WITHDRAW AMOUNT IS GREATER THAN CASH AT HAND!',
						text: 'Increase Cash at HAnd and try again.',
						type: 'warning',
						icon: 'ti ti-close',
						styling: 'fontawesome'
					});
				}else if(responseArray[0] == "2"){
					new PNotify({
						title: 'Please Withdraw Within Your OverDraft Limit!',
						text: 'OverDraft Limit is '+ responseArray[1],
						type: 'warning',
						icon: 'ti ti-close',
						styling: 'fontawesome'
					});

				}else if(responseArray[0] == "3"){
					new PNotify({
						title: 'INSUFFICIENT FUNDS ON YOU ACCOUNT!',
						text: 'Enter Amount within range and try again.',
						type: 'warning',
						icon: 'ti ti-close',
						styling: 'fontawesome'
					});
				}else if(responseArray[0] == "4"){
					new PNotify({
						title: 'STILL HAVING UNPAID OVERDRAFTS',
						text: 'Repay '+responseArray[1]+' and try again.',
						type: 'warning',
						icon: 'ti ti-close',
						styling: 'fontawesome'
					});
				}else if(responseArray[0] == "5"){
					new PNotify({
						title: 'THIS ACCOUNT IS FIXED',
						text: 'You Can\'t WithDraw',
						type: 'warning',
						icon: 'ti ti-close',
						styling: 'fontawesome'
					});
				}else{

					    if(document.getElementById('basic').value==''){
							new PNotify({
								title: 'MISSING INPUT!',
								text: 'Enter Client and try again.',
								type: 'warning',
								icon: 'ti ti-close',
								styling: 'fontawesome'
							});
						}else if(document.getElementById('withdrawor').value=='') {
							new PNotify({
								title: 'MISSING INPUT!',
								text: 'Enter Withdrawer and try again.',
								type: 'warning',
								icon: 'ti ti-close',
								styling: 'fontawesome'
							});
						}else if(document.getElementById('withdrawamt').value=='' || document.getElementById('withdrawamt').value=='0') {
							new PNotify({
								title: 'MISSING INPUT!',
								text: 'Enter Valid entries and try again.',
								type: 'warning',
								icon: 'ti ti-close',
								styling: 'fontawesome'
							});
						}else {
							var data = document.getElementById('withdrawamt').value + "?::?" +
								document.getElementById('basic').value + "?::?" +
								document.getElementById('withdrawor').value;

							if (window.XMLHttpRequest) {
								xmlhttp = new XMLHttpRequest();
							} else {
								xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
							}
							xmlhttp.onreadystatechange = function () {
								if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
									var responseArray = xmlhttp.responseText.split("|<><>|");
									document.getElementById("payrecord").innerHTML = responseArray[0];
									document.getElementById("clientledger").innerHTML = responseArray[1];
									document.getElementById("wdtransactionledger").innerHTML = responseArray[2];
									document.getElementById("withdrawamt").value = "";
									document.getElementById("withdrawor").value = "";

									$('#grn').DataTable({
										"bDestroy": true,
										"paging": true,
										"lengthChange": true,
										"searching": true,
										"ordering": true,
										"info": true,
										"autoWidth": true,
										"sDom": 'lfrtip'
									});

									$('#example').DataTable({
										"bDestroy": true,
										"paging": true,
										"lengthChange": true,
										"searching": true,
										"ordering": true,
										"info": true,
										"autoWidth": true,
										"sDom": 'lfrtip'
									});

									$('.dataTables_filter input').attr('placeholder', 'Search...');
									$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
									$('.panel-ctrls').append("<i class='separator'></i>");
									$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
									$('.panel-footer').append($(".dataTable+.row"));
									$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
								}
							};
							xmlhttp.open("GET", "classes/ajax_res.php?savewithdraw=" + data, true);
							xmlhttp.send();
						}
				}
			}

		};

		xmlhttp.open("GET", "classes/ajax_res.php?withdrawcashcheck=" + datas, true);
		xmlhttp.send();
}

function printLoanDuesReport(){
	var data = "";
	if(document.getElementById("report3").value =="7"){ data = "1 Week";}
	if(document.getElementById("report3").value =="14"){ data = "2 Weeks";}
	if(document.getElementById("report3").value =="21"){ data = "3 Weeks";}
	if(document.getElementById("report3").value =="30"){ data = "1 Month"}
	if(document.getElementById("report3").value =="60"){ data = "2 Months";}
	if(document.getElementById("report3").value =="90"){ data = "3 Months";}
	if(document.getElementById("loandues").innerHTML ==""){ }else{PrintElem('loandues',"Loan Dues Report"+"|<><>|"+data);}

}
function reportchange(){
	document.getElementById("loanrepaymentreport").innerHTML = "";
	document.getElementById("loanrepaymentreport1").innerHTML = "";
	if(document.getElementById("report1").value =="8"){
		document.getElementById("perind").hidden = false
	}else{
		document.getElementById("perind").hidden = true
	}
}
function reportchange1(){
	document.getElementById("loananalysisreport").innerHTML = "";
	document.getElementById("loananalysisreport1").innerHTML = "";
}
function reportchange2(){
	document.getElementById("withdrawdeposittreport").innerHTML = "";
	document.getElementById("withdrawdeposittreport1").innerHTML = "";
	if(document.getElementById("report1").value =="2" || document.getElementById("report1").value =="3" || document.getElementById("report1").value =="5"){
		document.getElementById("perind").hidden = false
	}else{
		document.getElementById("perind").hidden = true
	}
}
function reportchange3(){
	document.getElementById("DTSheetreport").innerHTML = "";
	document.getElementById("DTSheetreport1").innerHTML = "";
}

function printAssetChart(){
		if(document.getElementById("assetchartdata").innerHTML ==""){ }else{PrintElem('assetchartdata',"Asset Depreciation Chart");}
}
function printStandingOrderReport(){
	var data = "";
	if(document.getElementById("report5").value =="1"){ data = "Active Standing Orders Report";}
	if(document.getElementById("report5").value =="2"){ data = "Executed Standing Orders Report";}
	if(document.getElementById("report5").value =="3"){ data = "Failed Standing Orders Report";}
	if(document.getElementById("standingorderreport1").innerHTML ==""){ }else{PrintElem('standingorderreport1',data+"|<><>|"+document.getElementById("yearid5").value);}

}
function printPLReport(){
	var data = "";
	if(document.getElementById("profitnloss").innerHTML ==""){ }else{PrintElem('profitnloss',"Income Statement(Profit & Loss)"+"|<><>|"+document.getElementById("yearid6").value);}
}
function printTBReport(){
	var data = "";
	if(document.getElementById("profitnloss").innerHTML ==""){ }else{PrintElem('profitnloss',"TRIAL BALANCE"+"|<><>|"+document.getElementById("yearid6").value);}
}
function printBSReport(){
	var data = "";
	if(document.getElementById("profitnloss").innerHTML ==""){ }else{PrintElem('profitnloss',"BALANCE SHEET"+"|<><>|"+document.getElementById("yearid6").value);}
}
function printDWReport(){
	var data = "";
	if(document.getElementById("report1").value =="1"){ data = "General Deposits Report";}
	if(document.getElementById("report1").value =="2"){ data = "Individual Deposits Report";}
	if(document.getElementById("report1").value =="3"){ data = "Individual Deposits & Withdraws Report";}
	if(document.getElementById("report1").value =="4"){ data = "General Withdraws Report"}
	if(document.getElementById("report1").value =="5"){ data = "Individual Withdraws Report";}
	if(document.getElementById("report1").value =="6"){ data = "General Deposits & Withraws Report";}
	if(document.getElementById("report1").value =="7"){ data = "Savings, Shares & Loans Deposits Reports";}
	if(document.getElementById("withdrawdeposittreport1").innerHTML ==""){ }else{PrintElem('withdrawdeposittreport1',data+"|<><>|"+document.getElementById("yearid1").value+"<br>"+document.getElementById("monthid1").value);}
}
function printDTSheetReport(){
	var data = "";
	if(document.getElementById("report2").value =="1"){ data = "Day Sheet Report";}
	if(document.getElementById("report2").value =="2"){ data = "Till Sheet Report";}
	if(document.getElementById("DTSheetreport1").innerHTML ==""){ }else{PrintElem('DTSheetreport1',data+"|<><>|"+document.getElementById("datepicker").value);}
}
function printSaversReport(){
	if(document.getElementById("saverstatementreport1").innerHTML ==""){ }else{PrintElem('saverstatementreport1','Savers Statement');}
}
function printSTransactionReport(){
	if(document.getElementById("savingtransactionreport1").innerHTML ==""){ }else{PrintElem('savingtransactionreport1','Savings Transaction Report'+"|<><>|"+document.getElementById("yearid2").value+"<br>"+document.getElementById("monthid2").value);}
}
function printNoCashTransactionReport(){
	if(document.getElementById("noncashtransactionreport1").innerHTML ==""){ }else{PrintElem('noncashtransactionreport1','Non Cash Transactions Report'+"|<><>|"+document.getElementById("yearid3").value+"<br>"+document.getElementById("monthid3").value);}
}
function printPersonalLedgerReport(){
	if(document.getElementById("personalledgerreport1").innerHTML ==""){ }else{PrintElem('personalledgerreport1','MEMBER\'S LEDGER');}
}
function printAccountBalancesReport(){
	if(document.getElementById("accountbalssreport1").innerHTML ==""){ }else{PrintElem('accountbalssreport1','Account Balances Report');}
}
function printLoanRepaymentReport(){
	var data = "";
	if(document.getElementById("report1").value =="1"){ data = "Loan Repayments Report";}
	if(document.getElementById("report1").value =="2"){ data = "Loan Pre-payment Report";}
	if(document.getElementById("report1").value =="3"){ data = "Loan Penalties Charged Report";}
	if(document.getElementById("report1").value =="4"){ data = "Loan Penalties Paid"}
	if(document.getElementById("report1").value =="5"){ data = "Fully Repaid Loans Report";}
	if(document.getElementById("report1").value =="6"){ data = "Repayments of Written-Off Loans Report";}
	if(document.getElementById("report1").value =="7"){ data = "Report on Fees Received From Loans";}
	if(document.getElementById("report1").value =="8"){ data = "Individual Loan Repayments Report";}
	if(document.getElementById("loanrepaymentreport1").innerHTML ==""){ }else{PrintElem('loanrepaymentreport1',data+"|<><>|"+document.getElementById("yearid1").value);}
}
function printLoanAnalysistReport(){
	var data = "";

	if(document.getElementById("report2").value =="1"){ data = "Written-Off Loans Report";}
	if(document.getElementById("report2").value =="2"){ data = "Loan Top Borrowers Report";}
	if(document.getElementById("report2").value =="3"){ data = "Loan Arrears Report";}
	if(document.getElementById("report2").value =="4"){ data = "Loan Ageing Report"}
	if(document.getElementById("report2").value =="5"){ data = "PortFolio at Risk Report";}
	if(document.getElementById("report2").value =="6"){ data = "Loan PortFolio Report";}
	if(document.getElementById("loananalysisreport1").innerHTML ==""){ }else{PrintElem('loananalysisreport1',data+"|<><>|"+document.getElementById("yearid2").value);}
}
function printOutStandingBalanceeReport(){
	if(document.getElementById("outstandingbal").innerHTML ==""){ }else{PrintElem('outstandingbal','Outstanding Balance Report'+"|<><>|"+document.getElementById("yearsid3").value);}
}
function printDisbursementReport(){
	if(document.getElementById("disbursreport").innerHTML ==""){ }else{PrintElem('disbursreport','Disbursement Report'+"|<><>|"+document.getElementById("yearsid4").value);}
}
function printApprovalsReport(){
	if(document.getElementById("approvaalsreports1").innerHTML ==""){ }else{PrintElem('approvaalsreports1','Approved/Rejected/Pending Loans Report'+"|<><>|"+document.getElementById("yearsid5").value);}
}
function printLoanGCReport(){
	if(document.getElementById("loangcreport1").innerHTML ==""){ }else{PrintElem('loangcreport1','Guarantors and Collateral  Report'+"|<><>|"+document.getElementById("yearsid6").value);}
}
function printLoanLedger(){
	PrintElem('loanledger','Loan Ledger')
}

function GetLoanRepaymentReport(){
	document.getElementById("loanrepaymentreport").innerHTML = ''+
												'<div class="row" style="margin-bottom: 200px">'+
													'<span style="font-size:80px;"><i style="left:6em;top:2.5em" class="fa-li fa fa-spinner fa-spin"></i></span>'+
													''+
												'</div>';

    var data = document.getElementById("yearid1").value+"?::?"+document.getElementById("report1").value;
	if(document.getElementById("report1").value =="8"){ data = data +"?::?"+ document.getElementById("basic").value;}

	if(document.getElementById("report1").value == "" || document.getElementById("yearid1").value == ""){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
		document.getElementById("loanrepaymentreport").innerHTML = "";
	}else if(document.getElementById("basic").value =="" && document.getElementById("report1").value =="8"){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
		document.getElementById("loanrepaymentreport").innerHTML = "";
		document.getElementById("loanrepaymentreport1").innerHTML = "";
	}else{
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById("loanrepaymentreport").innerHTML = "";
				document.getElementById("loanrepaymentreport").innerHTML = responseArray[0];
				document.getElementById("loanrepaymentreport1").innerHTML = responseArray[0];

				if(document.getElementById("report1").value =="8"){}else{
					$('#grat1').DataTable({
						"bDestroy": true,
						"paging": true,
						"lengthChange": true,
						"searching": true,
						"ordering": true,
						"info": true,
						"autoWidth": true,
						"sDom": 'lfrtip'
					});

					$('.dataTables_filter input').attr('placeholder','Search...');
					$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
					$('.panel-ctrls').append("<i class='separator'></i>");
					$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
					$('.panel-footer').append($(".dataTable+.row"));
					$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
				}
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?getloanrepaymentreport=" + data, true);
		xmlhttp.send();
	}
}
function GetAnalysisReport(){
	document.getElementById("loananalysisreport").innerHTML = ''+
												'<div class="row" style="margin-bottom: 200px"><center>'+
													'<span style="font-size:80px;"><i style="left:6em;top:2.5em" class="fa-li fa fa-spinner fa-spin"></i></span>'+
													'</center>'+
												'</div>';
    var data = document.getElementById("yearid2").value+"?::?"+document.getElementById("report2").value;
	if(document.getElementById("report2").value == "" || document.getElementById("yearid2").value == ""){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
		document.getElementById("loananalysisreport").innerHTML = "";
	}else{
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById("loananalysisreport").innerHTML = "";
				document.getElementById("loananalysisreport").innerHTML = responseArray[0];
				document.getElementById("loananalysisreport1").innerHTML = responseArray[0];
				if(document.getElementById("report2").value =="6"){ }else{
				$('#grn').DataTable({
					"bDestroy": true,
					"paging": true,
					"lengthChange": true,
					"searching": true,
					"ordering": true,
					"info": true,
					"autoWidth": true,
					"sDom": 'lfrtip'
				});

				$('.dataTables_filter input').attr('placeholder','Search...');
				$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
				$('.panel-ctrls').append("<i class='separator'></i>");
				$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
				$('.panel-footer').append($(".dataTable+.row"));
				$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
				}
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?getloananalysisreport=" + data, true);
		xmlhttp.send();
	}
}
function GetLoanDuesReport(){
	document.getElementById("loanduesreport").innerHTML = ''+
												'<div class="row" style="margin-bottom: 200px">'+
													'<span style="font-size:80px;"><i style="left:6em;top:2.5em" class="fa-li fa fa-spinner fa-spin"></i></span>'+
													''+
												'</div>';
    var data = document.getElementById("report3").value;
  	if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById("loanduesreport").innerHTML = responseArray[0];
            document.getElementById("loandues").innerHTML = responseArray[0];

            $('#grat2').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?loanduesreport=" + data, true);
    xmlhttp.send();
}
function GetOutStandingBalanceReport(){
	document.getElementById("outstandingbalance").innerHTML = ''+
												'<div class="row" style="margin-bottom: 200px">'+
													'<span style="font-size:80px;"><i style="left:6em;top:2.5em" class="fa-li fa fa-spinner fa-spin"></i></span>'+
													''+
												'</div>';
    var data = document.getElementById("yearsid3").value;
  	if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById("outstandingbalance").innerHTML = responseArray[0];
            document.getElementById("outstandingbal").innerHTML = responseArray[0];

            $('#example').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?outstandingbalancereport=" + data, true);
    xmlhttp.send();
}
function GetDisbursemnetReport(){
	document.getElementById("disbursementreport").innerHTML = ''+
												'<div class="row" style="margin-bottom: 200px">'+
													'<span style="font-size:80px;"><i style="left:6em;top:2.5em" class="fa-li fa fa-spinner fa-spin"></i></span>'+
													''+
												'</div>';
    var data = document.getElementById("yearsid4").value;
  	if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById("disbursementreport").innerHTML = responseArray[0];
            document.getElementById("disbursreport").innerHTML = responseArray[0];

            $('#disb').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?disbursementreport=" + data, true);
    xmlhttp.send();
}
function GetApprovalsReport(){
	document.getElementById("approvaalsreports").innerHTML = ''+
												'<div class="row" style="margin-bottom: 200px">'+
													'<span style="font-size:80px;"><i style="left:6em;top:2.5em" class="fa-li fa fa-spinner fa-spin"></i></span>'+
													''+
												'</div>';
    var data = document.getElementById("yearsid5").value;
  	if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById("approvaalsreports").innerHTML = responseArray[0];
            document.getElementById("approvaalsreports1").innerHTML = responseArray[0];

            $('#balncd').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?approvalsreport=" + data, true);
    xmlhttp.send();
}
function GetLoanGCsReport(){
	document.getElementById("loangcreport").innerHTML = ''+
												'<div class="row" style="margin-bottom: 200px">'+
													'<span style="font-size:80px;"><i style="left:6em;top:2.5em" class="fa-li fa fa-spinner fa-spin"></i></span>'+
													''+
												'</div>';
    var data = document.getElementById("yearsid6").value;
  	if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById("loangcreport").innerHTML = responseArray[0];
            document.getElementById("loangcreport1").innerHTML = responseArray[0];

            $('#oppsd').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?loangcreport=" + data, true);
    xmlhttp.send();
}

function GetStandingOrderReport(){
	document.getElementById("standingorderreport").innerHTML = ''+
												'<div class="row" style="margin-bottom: 200px">'+
													'<span style="font-size:80px;"><i style="left:6em;top:2.5em" class="fa-li fa fa-spinner fa-spin"></i></span>'+
													''+
												'</div>';
    var data = document.getElementById("report5").value+"?::?"+document.getElementById("yearid5").value;

	if(document.getElementById("report5").value == ""){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
		document.getElementById("standingorderreport").innerHTML = "";
		document.getElementById("standingorderreport1").innerHTML = "";
	}else{
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById("standingorderreport").innerHTML = responseArray[0];
				document.getElementById("standingorderreport1").innerHTML = responseArray[0];

				$('#balncd').DataTable({
					"bDestroy": true,
					"paging": true,
					"lengthChange": true,
					"searching": true,
					"ordering": true,
					"info": true,
					"autoWidth": true,
					"sDom": 'lfrtip'
				});

				$('.dataTables_filter input').attr('placeholder','Search...');
				$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
				$('.panel-ctrls').append("<i class='separator'></i>");
				$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
				$('.panel-footer').append($(".dataTable+.row"));
				$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?standingorderreport=" + data, true);
		xmlhttp.send();
	}
}
function GetPLReport(){
	document.getElementById("profitnloss").innerHTML = ''+
												'<div class="row" style="margin-bottom: 200px">'+
													'<span style="font-size:80px;"><i style="left:6em;top:2.5em" class="fa-li fa fa-spinner fa-spin"></i></span>'+
													''+
												'</div>';
    var data = document.getElementById("yearid6").value+"?::?"+document.getElementById('monthid1').value;
	if(document.getElementById("yearid6").value == ""){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
		document.getElementById("profitnloss").innerHTML = "";
	}else{
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById("profitnloss").innerHTML = responseArray[0];
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?profitnloss=" + data, true);
		xmlhttp.send();
	}
}
function GetTBReport(){
	document.getElementById("profitnloss").innerHTML = ''+
												'<div class="row" style="margin-bottom: 200px">'+
													'<span style="font-size:80px;"><i style="left:6em;top:2.5em" class="fa-li fa fa-spinner fa-spin"></i></span>'+
													''+
												'</div>';
    var data = document.getElementById("yearid6").value;
	if(document.getElementById("yearid6").value == ""){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
		document.getElementById("profitnloss").innerHTML = "";
	}else{
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById("profitnloss").innerHTML = responseArray[0];
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?GetTBReport=" + data, true);
		xmlhttp.send();
	}
}
function GetDWReport(){
	document.getElementById("withdrawdeposittreport").innerHTML = ''+
												'<div class="row" style="margin-bottom: 200px">'+
													'<span style="font-size:80px;"><i style="left:6em;top:2.5em" class="fa-li fa fa-spinner fa-spin"></i></span>'+
													''+
												'</div>';
    var data = document.getElementById("report1").value+"?::?"+document.getElementById("yearid1").value+"?::?"+document.getElementById("monthid1").value;
  	if(document.getElementById("report1").value =="2" || document.getElementById("report1").value =="3" || document.getElementById("report1").value =="5"){ data = data +"?::?"+ document.getElementById("basic").value;}
	if(document.getElementById("report1").value == ""){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
		document.getElementById("withdrawdeposittreport").innerHTML = "";
		document.getElementById("withdrawdeposittreport1").innerHTML = "";
	}else if(document.getElementById("basic").value =="" && document.getElementById("report1").value =="2"){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
		document.getElementById("withdrawdeposittreport").innerHTML = "";
		document.getElementById("withdrawdeposittreport1").innerHTML = "";
	}else if(document.getElementById("basic").value =="" && document.getElementById("report1").value =="3"){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
		document.getElementById("withdrawdeposittreport").innerHTML = "";
		document.getElementById("withdrawdeposittreport1").innerHTML = "";
	}else if(document.getElementById("basic").value =="" && document.getElementById("report1").value =="5"){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
		document.getElementById("withdrawdeposittreport").innerHTML = "";
		document.getElementById("withdrawdeposittreport1").innerHTML = "";
	}else{
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById("withdrawdeposittreport").innerHTML = responseArray[0];
				document.getElementById("withdrawdeposittreport1").innerHTML = responseArray[0];

				$('#oppsd').DataTable({
					"bDestroy": true,
					"paging": true,
					"lengthChange": true,
					"searching": true,
					"ordering": true,
					"info": true,
					"autoWidth": true,
					"sDom": 'lfrtip'
				});

				$('.dataTables_filter input').attr('placeholder','Search...');
				$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
				$('.panel-ctrls').append("<i class='separator'></i>");
				$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
				$('.panel-footer').append($(".dataTable+.row"));
				$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?depwithreport=" + data, true);
		xmlhttp.send();
	}
}
function GetDTSheetReport(){
	document.getElementById("DTSheetreport").innerHTML = ''+
												'<div class="row" style="margin-bottom: 200px">'+
													'<span style="font-size:80px;"><i style="left:6em;top:2.5em" class="fa-li fa fa-spinner fa-spin"></i></span>'+
													''+
												'</div>';
    var data = document.getElementById("report2").value+"?::?"+document.getElementById("datepicker").value;
  	if(document.getElementById("report2").value == "" || document.getElementById("datepicker").value==""){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
		document.getElementById("DTSheetreport").innerHTML = "";
		document.getElementById("DTSheetreport1").innerHTML = "";
	}else{
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById("DTSheetreport").innerHTML = responseArray[0];
				document.getElementById("DTSheetreport1").innerHTML = responseArray[0];

				$('#grn').DataTable({
					"bDestroy": true,
					"paging": true,
					"lengthChange": true,
					"searching": true,
					"ordering": true,
					"info": true,
					"autoWidth": true,
					"sDom": 'lfrtip'
				});

				$('.dataTables_filter input').attr('placeholder','Search...');
				$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
				$('.panel-ctrls').append("<i class='separator'></i>");
				$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
				$('.panel-footer').append($(".dataTable+.row"));
				$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?dtsheetsreport=" + data, true);
		xmlhttp.send();
	}
}
function GetSaversReport(){
    document.getElementById("saverstatementreport").innerHTML = ''+
        '<div class="row" style="margin-bottom: 200px">'+
                '<span style="font-size:80px;"><i style="left:6em;top:2.5em" class="fa-li fa fa-spinner fa-spin"></i></span>'+
                ''+
        '</div>';
    var data = document.getElementById("basic1").value+"?::?"+document.getElementById("datepicker2").value+"?::?"+document.getElementById("datepicker3").value;
    if(document.getElementById("basic1").value == ""){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
		document.getElementById("saverstatementreport").innerHTML = "";
		document.getElementById("saverstatementreport1").innerHTML = "";
        }else if(document.getElementById("datepicker2").value == "" || document.getElementById("datepicker2").value == ""){  
            new PNotify({
                title: 'MISSING DATE RANGE!',
                text: 'Enter and try again.',
                type: 'warning',
                icon: 'ti ti-close',
                styling: 'fontawesome'
            });
            document.getElementById("saverstatementreport").innerHTML = "";
            document.getElementById("saverstatementreport1").innerHTML = "";
	}else{
            if (window.XMLHttpRequest) {
                    xmlhttp = new XMLHttpRequest();
            } else {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                            var responseArray = xmlhttp.responseText.split("|<><>|");
                            document.getElementById("saverstatementreport").innerHTML = responseArray[0];
                            document.getElementById("saverstatementreport1").innerHTML = responseArray[0];

                            $('#grat1').DataTable({
                                    "bDestroy": true,
                                    "paging": true,
                                    "lengthChange": true,
                                    "searching": true,
                                    "ordering": true,
                                    "info": true,
                                    "autoWidth": true,
                                    "sDom": 'lfrtip'
                            });

                            $('.dataTables_filter input').attr('placeholder','Search...');
                            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
                            $('.panel-ctrls').append("<i class='separator'></i>");
                            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
                            $('.panel-footer').append($(".dataTable+.row"));
                            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
                    }
            };
            xmlhttp.open("GET", "classes/ajax_res.php?saverstatementreport=" + data, true);
            xmlhttp.send();
	}
}
function GetPersonalLedgerReport(){
	document.getElementById("personalledgerreport").innerHTML = ''+
												'<div class="row" style="margin-bottom: 200px">'+
													'<span style="font-size:80px;"><i style="left:6em;top:2.5em" class="fa-li fa fa-spinner fa-spin"></i></span>'+
													''+
												'</div>';
    var data = document.getElementById("basic2").value;
  	if(document.getElementById("basic2").value == ""){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
		document.getElementById("personalledgerreport").innerHTML = "";
		document.getElementById("personalledgerreport1").innerHTML = "";
	}else{
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById("personalledgerreport").innerHTML = responseArray[0];
				document.getElementById("personalledgerreport1").innerHTML = responseArray[0];

				$('#disb').DataTable({
					"bDestroy": true,
					"paging": true,
					"lengthChange": true,
					"searching": true,
					"ordering": true,
					"info": true,
					"autoWidth": true,
					"sDom": 'lfrtip'
				});

				$('.dataTables_filter input').attr('placeholder','Search...');
				$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
				$('.panel-ctrls').append("<i class='separator'></i>");
				$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
				$('.panel-footer').append($(".dataTable+.row"));
				$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?personalledgerreport=" + data, true);
		xmlhttp.send();
	}
}
function GetSTransactionReport(){
	document.getElementById("savingtransactionreport").innerHTML = ''+
												'<div class="row" style="margin-bottom: 200px">'+
													'<span style="font-size:80px;"><i style="left:6em;top:2.5em" class="fa-li fa fa-spinner fa-spin"></i></span>'+
													''+
												'</div>';
    var data = document.getElementById("yearid2").value+"?::?"+document.getElementById('monthid2').value;
  	if(document.getElementById("yearid2").value == "" || document.getElementById('monthid2').value==""){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
		document.getElementById("savingtransactionreport").innerHTML = "";
		document.getElementById("savingtransactionreport1").innerHTML = "";
	}else{
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById("savingtransactionreport").innerHTML = responseArray[0];
				document.getElementById("savingtransactionreport1").innerHTML = responseArray[0];

				$('#grat2').DataTable({
					"bDestroy": true,
					"paging": true,
					"lengthChange": true,
					"searching": true,
					"ordering": true,
					"info": true,
					"autoWidth": true,
					"sDom": 'lfrtip'
				});

				$('.dataTables_filter input').attr('placeholder','Search...');
				$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
				$('.panel-ctrls').append("<i class='separator'></i>");
				$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
				$('.panel-footer').append($(".dataTable+.row"));
				$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?savingtransactionreport=" + data, true);
		xmlhttp.send();
	}
}
function GetNonCashTReport(){
	document.getElementById("noncashtransactionreport").innerHTML = ''+
		'<div class="row" style="margin-bottom: 200px">'+
			'<span style="font-size:80px;"><i style="left:6em;top:2.5em" class="fa-li fa fa-spinner fa-spin"></i></span>'+
			''+
		'</div>';
    var data = document.getElementById("yearid3").value+"?::?"+document.getElementById('monthid3').value;
  	if(document.getElementById("yearid3").value == "" || document.getElementById('monthid3').value==""){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
		document.getElementById("noncashtransactionreport").innerHTML = "";
		document.getElementById("noncashtransactionreport1").innerHTML = "";
	}else{
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById("noncashtransactionreport").innerHTML = responseArray[0];
				document.getElementById("noncashtransactionreport1").innerHTML = responseArray[0];

				$('#example').DataTable({
					"bDestroy": true,
					"paging": true,
					"lengthChange": true,
					"searching": true,
					"ordering": true,
					"info": true,
					"autoWidth": true,
					"sDom": 'lfrtip'
				});

				$('.dataTables_filter input').attr('placeholder','Search...');
				$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
				$('.panel-ctrls').append("<i class='separator'></i>");
				$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
				$('.panel-footer').append($(".dataTable+.row"));
				$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?noncashtransactionreport=" + data, true);
		xmlhttp.send();
	}
}

function printdepositdetail(e){
	if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById("depositprt").innerHTML = responseArray[0];

			PrintElem('depositprt','Deposit Slip')
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?transactionid=" + e, true);
    xmlhttp.send();
}
function gettranstiondetail(e) {

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById("depositdetaileddescription").innerHTML = responseArray[0];

            $('#grat1').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?transactionid=" + e, true);
    xmlhttp.send();
}
function getguarantor1data() {

    var data =  document.getElementById('grt1_name').value;

    if(data===""){
        document.getElementById("acount1").value = "";
        document.getElementById("village1").value = "";
        document.getElementById("residence1").value = "";
        document.getElementById("contact1").value = "";
    }else{
        if(data === document.getElementById('grt2_name').value || data === document.getElementById('clientdata').value){
            document.getElementById("acount1").value = "";
            document.getElementById("village1").value = "";
            document.getElementById("residence1").value = "";
            document.getElementById("contact1").value = "";
            document.getElementById("grt1_name").value = "";
            new PNotify({
                title: 'Warning!',
                text: 'Client Already used as guarantor here please choose another one',
                type: 'warning',
                icon: 'ti ti-close',
                styling: 'fontawesome'
            });
        }else{
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                    var responseArray = xmlhttp.responseText.split("|<><>|");

                    document.getElementById("acount1").value = responseArray[0];
                    document.getElementById("village1").value = responseArray[1];
                    document.getElementById("residence1").value = responseArray[2];
                    document.getElementById("contact1").value = responseArray[3];
                }
            };
            xmlhttp.open("GET", "classes/ajax_res.php?guarantor1data=" + data, true);
            xmlhttp.send();
        }

    }


}

function getguarantor2data() {

    var data =  document.getElementById('grt2_name').value;

    if(data===""){
        document.getElementById("acount2").value = "";
        document.getElementById("village2").value = "";
        document.getElementById("residence2").value = "";
        document.getElementById("contact2").value = "";
        document.getElementById("grt2_name").value = "";
    }else{

        if(data === document.getElementById('grt1_name').value || data === document.getElementById('clientdata').value){
            document.getElementById("acount2").value = "";
            document.getElementById("village2").value = "";
            document.getElementById("residence2").value = "";
            document.getElementById("contact2").value = "";
            document.getElementById("grt2_name").value = "";
            new PNotify({
                title: 'Warning!',
                text: 'Client Already used as guarantor here please choose another one',
                type: 'warning',
                icon: 'ti ti-close',
                styling: 'fontawesome'
            });
        }else{
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                    var responseArray = xmlhttp.responseText.split("|<><>|");

                    document.getElementById("acount2").value = responseArray[0];
                    document.getElementById("village2").value = responseArray[1];
                    document.getElementById("residence2").value = responseArray[2];
                    document.getElementById("contact2").value = responseArray[3];
                }
            };
            xmlhttp.open("GET", "classes/ajax_res.php?guarantor2data=" + data, true);
            xmlhttp.send();
        }
    }

}
function closemodal() {
    $('#addloanappdetails').modal('hide')
}
function closemodal1() {
    $('#addloanappraisaldetails').modal('hide')
}
function closemodal2() {
    $('#makedecision').modal('hide')
}

function getloanapplicationdata(data) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById("loanapplicationdetails").innerHTML = responseArray[0];
            if(responseArray[1]){
                document.getElementById('clientbiodata').innerHTML = responseArray[1];
            }
			$("#datepicker").datepicker({todayHighlight: true});
            $('#grt1_name').selectpicker({
                "livesearch":true
            });
            $('#grt2_name').selectpicker({
                "livesearch":true
            });
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?getloanapplicationdata=" + data, true);
    xmlhttp.send();
}
function saveapplication() {
	var data =  document.getElementById('type_of_business').value +"?::?"+
                document.getElementById('ln_amount_figure').value +"?::?"+
                document.getElementById('ln_amount_words').value +"?::?"+
                document.getElementById('ln_intent').value +"?::?"+
                document.getElementById('ln_source').value +"?::?"+
                document.getElementById('ln_duration').value +"?::?"+
                document.getElementById('ln_schedule').value +"?::?"+
                document.getElementById('loan_type').value +"?::?"+
                document.getElementById('own_assests').value +"?::?"+
                document.getElementById('col_assests').value +"?::?"+
                document.getElementById('other_debt').value +"?::?"+
                document.getElementById('ln_purpose').value +"?::?"+
                document.getElementById('net_worth').value +"?::?"+
                document.getElementById('ablity_pay').value +"?::?"+
                document.getElementById('lc_name').value +"?::?"+
                document.getElementById('lc_address').value +"?::?"+
                document.getElementById('lc_contact').value +"?::?"+
                document.getElementById('grt1_name').value +"?::?"+
                document.getElementById('grt2_name').value +"?::?"+
                document.getElementById('clientdata').value +"?::?"+
                document.getElementById('chartdata').value +"?::?"+
                document.getElementById('datepicker').value;

		if(document.getElementById('acctype').value=="1"){
			data +=	"?::?"+ document.getElementById('lvl_of_educ').value+"?::?"+
							document.getElementById('spouse_name').value +"?::?"+
							document.getElementById('spouse_contact').value;
		}else{}

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById("loandatatable").innerHTML = responseArray[0];
            $('#addloanappdetails').modal('hide');
            $('#example').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");

        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?saveloanapplicationdata=" + data, true);
    xmlhttp.send();

}

function appsum1() {
    var trs = document.getElementById('expensetable').getElementsByTagName('tr');
    var tot = 0;
    for( var k = 1;k < trs.length-1;k++){
        var tds = trs[k].getElementsByTagName('td');
        if(tds[1].getElementsByTagName('input')[0].value===""){tds[1].getElementsByTagName('input')[0].value=0;}
        tot += parseInt(tds[1].getElementsByTagName('input')[0].value);
    }
    document.getElementById('ttl_1').value = tot;
}
function appsum2() {
    var trs = document.getElementById('incometable').getElementsByTagName('tr');
    var tot = 0;
    for( var k = 1;k < trs.length-1;k++){
        var tds = trs[k].getElementsByTagName('td');
        if(tds[1].getElementsByTagName('input')[0].value===""){tds[1].getElementsByTagName('input')[0].value=0;}
        tot += parseInt(tds[1].getElementsByTagName('input')[0].value);
    }
    document.getElementById('total').value = tot;
}
function saveappraisal() {

    var data =  document.getElementById('ln_officer').value +"?::?"+
                document.getElementById('clientdata').value +"?::?"+
                document.getElementById('loandata').value +"?::?"+
                document.getElementById('chartdata').value +"?::?"+
                document.getElementById('proj_type').value +"?::?"+
                document.getElementById('proj_age').value +"?::?"+
                document.getElementById('proj_loc').value +"?::?"+
                document.getElementById('honesty').value +"?::?"+
                document.getElementById('repay_hist').value +"?::?"+
                document.getElementById('time_in_area').value +"?::?"+
                document.getElementById('new_applnt_from').value +"?::?"+
                document.getElementById('residence_status').value +"?::?"+
                document.getElementById('no_ofhousehousde').value +"?::?"+
                document.getElementById('no_children').value +"?::?"+
                document.getElementById('ease_migrat').value +"?::?"+
                document.getElementById('sale_prod').value +"?::?"+
                document.getElementById('sale_animal_pro').value +"?::?"+
                document.getElementById('ani_sales').value +"?::?"+
                document.getElementById('salary').value +"?::?"+
                document.getElementById('bldg').value +"?::?"+
                document.getElementById('others').value +"?::?"+
                document.getElementById('total').value +"?::?"+
                document.getElementById('food').value +"?::?"+
                document.getElementById('medicine').value +"?::?"+
                document.getElementById('clothing').value +"?::?"+
                document.getElementById('school_fees').value +"?::?"+
                document.getElementById('transp').value +"?::?"+
                document.getElementById('utility').value +"?::?"+
                document.getElementById('entertainment').value +"?::?"+
                document.getElementById('others_2').value +"?::?"+
                document.getElementById('ttl_1').value +"?::?"+
                document.getElementById('dis_amt').value +"?::?"+
                document.getElementById('behave_savg').value +"?::?"+
                document.getElementById('avg_monnthly_saving').value +"?::?"+
                document.getElementById('prev_loan').value +"?::?"+
                document.getElementById('savg_bal').value +"?::?"+
                document.getElementById('cond_avail').value +"?::?"+
                document.getElementById('bus_season').value +"?::?"+
                document.getElementById('social_obligation').value +"?::?"+
                document.getElementById('col_offer').value +"?::?"+
                document.getElementById('val_own').value +"?::?"+
                document.getElementById('ln_off_val').value +"?::?"+
                document.getElementById('new_applnt_from').value +"?::?"+
                document.getElementById('no_ofshares').value +"?::?"+
                document.getElementById('actual_savg').value ;


    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            if(responseArray[1]){
                document.getElementById("approvaltabledata").innerHTML = responseArray[0];
            }else{
                document.getElementById("loandatatable").innerHTML = responseArray[0];
            }
            $('#addloanappraisaldetails').modal('hide');
            $('#example').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });
            $('#grn').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");

        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?saveloanappraisaldata=" + data, true);
    xmlhttp.send();

}
function getloanappraisaldata(data) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById("loanappraisaldetails").innerHTML = responseArray[0];
            if(responseArray[1]){
                document.getElementById('clientbiodata').innerHTML = responseArray[1];
            }
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?getloanappraisaldata=" + data, true);
    xmlhttp.send();
}
function forwardforapproval(data) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById("loandatatable").innerHTML = responseArray[0];
            document.getElementById("approvaltabledata").innerHTML = responseArray[1];
            $('#example').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });
            $('#grn').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");

        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?forwardforapproval=" + data, true);
    xmlhttp.send();
}

function loanapproval(data) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById("makeloandecision").innerHTML = responseArray[0];

            $('#grn').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
            
            if(document.getElementById('m_lnamt').value != ""){
                getValues();
            }

        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?loanapproval=" + data, true);
    xmlhttp.send();
}

function updateloanAmt(val){
    document.getElementById('principal').value = val
}

function updateterms(val){
    document.getElementById('terms').value = val
}

function saveloandecisions() {

    var data =  document.getElementById('o_lnamt').value +"?::?"+
                document.getElementById('o_lnprd').value +"?::?"+
                document.getElementById('o_desc').value +"?::?"+
                document.getElementById('m_lnamt').value +"?::?"+
                document.getElementById('m_lnprd').value +"?::?"+
                document.getElementById('m_desc').value +"?::?"+
                document.getElementById('c_desc').value +"?::?"+
                document.getElementById('principal').value +"?::?"+
                document.getElementById('interest').value +"?::?"+
                document.getElementById('terms').value +"?::?"+
                document.getElementById('scheduledata').innerHTML +"?::?"+
                document.getElementById('approvalid').value +"?::?"+
                document.getElementById('loantype').value  +"?::?"+
                document.getElementById('penaltyid').value ;


    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
                document.getElementById("approvaltabledata").innerHTML = responseArray[0];

            $('#makedecision').modal('hide');
            $('#grn').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");

        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?saveloandecisiondata=" + data, true);
    xmlhttp.send();

}
function getdeclinedloans() {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById("declinedloans").innerHTML = responseArray[0];

            $('#declinedloans').modal('hide');
            $('#grat1').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");

        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?declinedloans=" + "1", true);
    xmlhttp.send();

}
function retrievedeclinedloans(data) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById("approvaltabledata").innerHTML = responseArray[0];

            $('#declinedloansmodal').modal('hide');
            $('#grn').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");

        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?retivedeclinedloans=" + data, true);
    xmlhttp.send();

}
function declineloan(data) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById("approvaltabledata").innerHTML = responseArray[0];

            $('#grn').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");

        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?declineloans=" + data, true);
    xmlhttp.send();

}

function getschedule(data) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById("loandatatable").innerHTML = responseArray[0];
            document.getElementById("loanschudletable").innerHTML = responseArray[1];

            $('#grat2').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });
            $('#grn').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");

        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?loanschedule=" + data, true);
    xmlhttp.send();

}
function returnschedule(data) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById("loanschedule").innerHTML = responseArray[0];

            $('#grn').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");

        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?returnloanschedule=" + data, true);
    xmlhttp.send();
}

function dispalyforward(data) {
    document.getElementById('forward'+data+'').hidden =  false;
}
function hideforward1(data) {
    document.getElementById('forward'+data+'').hidden =  true;
}
function hideforward(data) {
    var senddata =  document.getElementById('lwr'+data+'').innerHTML+"?::?" +
                    document.getElementById('grt'+data+'').innerHTML+"?::?" +
                    document.getElementById('forwardeddate'+data+'').value+"?::?" +
                    document.getElementById('scheduleid'+data+'').innerHTML;
    if(document.getElementById('forwardeddate'+data+'').value ==""){
        new PNotify({
            title: 'MISSING INPUT!',
            text: 'Enter Date try again.',
            type: 'error',
            icon: 'ti ti-close',
            styling: 'fontawesome'
        });
    }else {
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                var responseArray = xmlhttp.responseText.split("|<><>|");

                if(responseArray[0]=="1"){
                    new PNotify({
                        title: 'INVALID!',
                        text: 'incorrect date.',
                        type: 'error',
                        icon: 'ti ti-close',
                        styling: 'fontawesome'
                    });

                }else {
                    document.getElementById("loandatatable").innerHTML = responseArray[0];
                    document.getElementById("loanschudletable").innerHTML = responseArray[1];

                    $('#grat2').DataTable({
                        "bDestroy": true,
                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": true,
                        "sDom": 'lfrtip'
                    });
                    $('#grn').DataTable({
                        "bDestroy": true,
                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": true,
                        "sDom": 'lfrtip'
                    });

                    $('.dataTables_filter input').attr('placeholder','Search...');
                    $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
                    $('.panel-ctrls').append("<i class='separator'></i>");
                    $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
                    $('.panel-footer').append($(".dataTable+.row"));
                    $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
                }


            }
        };
        xmlhttp.open("GET", "classes/ajax_res.php?savepostponeduedate=" + senddata, true);
        xmlhttp.send();
    }

}
function resetforward(data) {
    var senddata =  document.getElementById('lwr'+data+'').innerHTML+"?::?" +
                    document.getElementById('grt'+data+'').innerHTML+"?::?" +
                    document.getElementById('forwardeddate'+data+'').value+"?::?" +
                    document.getElementById('scheduleid'+data+'').innerHTML;

        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                var responseArray = xmlhttp.responseText.split("|<><>|");

                    document.getElementById("loandatatable").innerHTML = responseArray[0];
                    document.getElementById("loanschudletable").innerHTML = responseArray[1];

                    $('#grat2').DataTable({
                        "bDestroy": true,
                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": true,
                        "sDom": 'lfrtip'
                    });
                $('#grn').DataTable({
                    "bDestroy": true,
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": true,
                    "sDom": 'lfrtip'
                });

                    $('.dataTables_filter input').attr('placeholder','Search...');
                    $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
                    $('.panel-ctrls').append("<i class='separator'></i>");
                    $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
                    $('.panel-footer').append($(".dataTable+.row"));
                    $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");

            }
        };
        xmlhttp.open("GET", "classes/ajax_res.php?restpostponeduedate=" + senddata, true);
        xmlhttp.send();
}

function returnloanledger(data) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById("loanledgercard").innerHTML = responseArray[0];

            $('#grn').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");

        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?returnloanledger=" + data, true);
    xmlhttp.send();
}
function returndisbursedetail(data) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById("disbursedetail").innerHTML = responseArray[0];

        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?disbursedetail=" + data, true);
    xmlhttp.send();
}
function sectionlevel(data){
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById("chartrecords").innerHTML = responseArray[0];
            $('#grn').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?sectionlevel=" + data, true);
    xmlhttp.send();
}
function savesectionlevel(data){
    var values = "";
    if(data=="1"){
        values = data+"?::?"+document.getElementById('inputlevel1').value;
    }
    if(data=="2"){
        values = data+"?::?"+document.getElementById('inputlevel2').value+"?::?"+document.getElementById('level1').value;
    }
    if(data=="3"){
        values = data+"?::?"+document.getElementById('inputlevel3').value+"?::?"+document.getElementById('level2').value;
    }
    if(data=="4"){
        values = data+"?::?"+document.getElementById('inputlevel4').value+"?::?"+document.getElementById('level3').value;
    }
    if(data=="5"){
        values = data+"?::?"+document.getElementById('inputlevel5').value+"?::?"+document.getElementById('level4').value;
    }
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById("chartrecords").innerHTML = responseArray[0];
            document.getElementById('chartops').innerHTML = responseArray[1];
            document.getElementById('chartpreview').innerHTML = responseArray[2];
            $('#grn').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });
            $('#level1').selectpicker({
                "livesearch":true
            })
            $('#level2').selectpicker({
                "livesearch":true
            })
            $('#level3').selectpicker({
                "livesearch":true
            })
            $('#level4').selectpicker({
                "livesearch":true
            })

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?savesectionlevel=" + values, true);
    xmlhttp.send();
}
function Returnedoption(){
    var val = document.getElementById('codereturn').value;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById("returnedoptionss").innerHTML = responseArray[0];

            $('#rtnvalues').selectpicker({
                "livesearch":true
            });
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?returnedexpenseaccount=" + val, true);
    xmlhttp.send();
}
function ActivateBankActivate(){
    var val = document.getElementById('bankaccountact').value+"?::?"+document.getElementById('accountno').value+"?::?"+document.getElementById('accountbalance').value;
    if(document.getElementById('bankaccountact').value===""){
        new PNotify({
            title: 'MISSING INPUT!',
            text: 'Enter Account to Continue',
            icon: 'ti ti-close',
            styling: 'fontawesome'
        });
    }else {
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                var responseArray = xmlhttp.responseText.split("|<><>|");
                if(responseArray[0]==="1"){
                    new PNotify({
                        title: 'INVALID INPUT!',
                        text: 'Account is Activated Already',
                        icon: 'ti ti-close',
                        styling: 'fontawesome'
                    });
                }else{

                }
                document.getElementById('bankactivatesection').innerHTML = responseArray[1];
                $('#bankaccountact').selectpicker({
                    "livesearch":true
                })

            }
        };
        xmlhttp.open("GET", "classes/ajax_res.php?activatebankactivate=" + val, true);
        xmlhttp.send();
    }

}

function ReturnedCash(){
    var val = document.getElementById('cashoptions').value;
    if(val==="3"){
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                var responseArray = xmlhttp.responseText.split("|<><>|");
                document.getElementById("returnedbanks").innerHTML = responseArray[0];

                $('#bankaccounts').selectpicker({
                    "livesearch":true
                });

            }
        };
        xmlhttp.open("GET", "classes/ajax_res.php?returnedcashaccount=" + val, true);
        xmlhttp.send();
    }else{
        document.getElementById("returnedbanks").innerHTML = "";
    }

}
function SaveBankTransaction() {
    var vals =  document.getElementById('bankaccountcode').value+"?::?"+
                document.getElementById('slipno').value+"?::?"+
                document.getElementById('transactiontype').value+"?::?"+
                document.getElementById('transactioncharge').value+"?::?"+
                document.getElementById('transactionamount').value+"?::?"+
                document.getElementById('datepicker').value+"?::?"+
                document.getElementById('banktracteditcode').innerHTML;

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('returnedbanktracs').innerHTML = responseArray[0];
            document.getElementById('returnedbanktracstable').innerHTML = responseArray[1];
            document.getElementById('bankaccountbalances').innerHTML = responseArray[2];

            $('#grn').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
            $('#bankaccountcode').selectpicker({
                "livesearch":true
            });
            $("#datepicker").datepicker({todayHighlight: true});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?savebanktransaction=" + vals, true);
    xmlhttp.send();
}
function SaveChequeTransaction() {
    var vals =  document.getElementById('datepicker1').value+"?::?"+
                document.getElementById('datepicker2').value+"?::?"+
                document.getElementById('amountissued').value+"?::?"+
                document.getElementById('accounttoissue').value+"?::?"+
                document.getElementById('chequeno').value+"?::?"+
                document.getElementById('descriptionissue').value+"?::?"+
                document.getElementById('accno').value+"?::?"+
                document.getElementById('accname').value+"?::?"+
                document.getElementById('bankoname').value+"?::?"+
                document.getElementById('chequetracteditcode').innerHTML;


    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('issuechequesection').innerHTML = responseArray[0];
            document.getElementById('returnedchequetable').innerHTML = responseArray[1];
            document.getElementById('bankaccountbalances').innerHTML = responseArray[2];

            $('#grat1').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
            $('#accounttoissue').selectpicker({
                "livesearch":true
            });
            $("#datepicker1").datepicker({todayHighlight: true});
            $("#datepicker2").datepicker({todayHighlight: true});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?savechequetransaction=" + vals, true);
    xmlhttp.send();
}

function GetBankTransaction(res) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('returnedbanktracs').innerHTML = responseArray[0];
            $('#bankaccountcode').selectpicker({
                "livesearch":true
            });
            $("#datepicker").datepicker({todayHighlight: true});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?getbanktransaction=" + res, true);
    xmlhttp.send();

}
function GetChequeTransaction(res) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('issuechequesection').innerHTML = responseArray[0];
            $('#accounttoissue').selectpicker({
                "livesearch":true
            });
            $("#datepicker1").datepicker({todayHighlight: true});
            $("#datepicker2").datepicker({todayHighlight: true});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?getchequetransaction=" + res, true);
    xmlhttp.send();

}
function ClearBANKTRANCS() {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('returnedbanktracs').innerHTML = responseArray[0];
            $('#bankaccountcode').selectpicker({
                "livesearch":true
            });
            $("#datepicker").datepicker({todayHighlight: true});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?clearbanktracs=" +"1", true);
    xmlhttp.send();

}
function ClearISSUECHEQUE() {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('issuechequesection').innerHTML = responseArray[0];
            $('#accounttoissue').selectpicker({
                "livesearch":true
            });
            $("#datepicker1").datepicker({todayHighlight: true});
            $("#datepicker2").datepicker({todayHighlight: true});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?clearissuechequesection=" +"1", true);
    xmlhttp.send();

}
function getchequecheck(res) {
    document.getElementById('chequetrac'+res).hidden = false;
}
function cancelchequecheck(res) {
    document.getElementById('inputchequecheck'+res).value = "";
    document.getElementById('chequetrac'+res).hidden = true;
}
function savechequecheck(res,vals) {
    if(document.getElementById('inputchequecheck'+res).value == ""){
        new PNotify({
            title: 'MISSING INPUT!',
            text: 'Enter Charge Amount and try again.',
            type: 'warning',
            icon: 'ti ti-close',
            styling: 'fontawesome'
        });
    }else{
        var data = document.getElementById('inputchequecheck'+res).value +"?::?"+ vals;
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                var responseArray = xmlhttp.responseText.split("|<><>|");
                document.getElementById('returnedchequetable').innerHTML = responseArray[0];
                document.getElementById('bankaccountbalances').innerHTML = responseArray[1];
                $('#grat1').DataTable({
                    "bDestroy": true,
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": true,
                    "sDom": 'lfrtip'
                });

                $('.dataTables_filter input').attr('placeholder','Search...');
                $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
                $('.panel-ctrls').append("<i class='separator'></i>");
                $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
                $('.panel-footer').append($(".dataTable+.row"));
                $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");

                $('#accounttoissue').selectpicker({
                    "livesearch":true
                });
                $("#datepicker1").datepicker({todayHighlight: true});
                $("#datepicker2").datepicker({todayHighlight: true});
            }
        };
        xmlhttp.open("GET", "classes/ajax_res.php?savechequecheck=" + data, true);
        xmlhttp.send();
    }
}

function savefinancialinstitution() {
        var data = document.getElementById('financialint').value + "?::?" + document.getElementById('returnfinainst').value;
        if(document.getElementById('financialint').value == "" || document.getElementById('yesacc').checked==false && document.getElementById('noacc').checked==false){
            new PNotify({
                title: 'MISSING INPUT!',
                text: 'Enter and it try again.',
                type: 'warning',
                icon: 'ti ti-close',
                styling: 'fontawesome'
            });
        }else {
            if(document.getElementById('yesacc').checked==true){
                if(document.getElementById('bankaccountchoice').value==""){
                    new PNotify({
                        title: 'MISSING INPUT!',
                        text: 'Enter Bank Account and try again.',
                        type: 'warning',
                        icon: 'ti ti-close',
                        styling: 'fontawesome'
                    });
                }else{
                    data = data+"?::?"+document.getElementById('bankaccountchoice').value
                    if (window.XMLHttpRequest) {
                        xmlhttp = new XMLHttpRequest();
                    } else {
                        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                            var responseArray = xmlhttp.responseText.split("|<><>|");
                            document.getElementById('returnfina').innerHTML = responseArray[0];
                            document.getElementById('boworringsection').innerHTML = responseArray[1];
                            if(responseArray[2]=="1"){
                                new PNotify({
                                    title: 'INVALID INPUT!',
                                    text: 'Enter Institution Already Exists.',
                                    type: 'info',
                                    icon: 'ti ti-close',
                                    styling: 'fontawesome'
                                });
                            }
                            $('#finaintname').selectpicker({
                                "livesearch":true
                            });
                            $("#datepicker3").datepicker({todayHighlight: true});
                            $("#datepicker4").datepicker({todayHighlight: true});
                        }
                    };
                    xmlhttp.open("GET", "classes/ajax_res.php?savefinancialint=" + data, true);
                    xmlhttp.send();
                }
            }
            if(document.getElementById('noacc').checked==true){
                if (window.XMLHttpRequest) {
                    xmlhttp = new XMLHttpRequest();
                } else {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                        var responseArray = xmlhttp.responseText.split("|<><>|");
                        document.getElementById('returnfina').innerHTML = responseArray[0];
                        document.getElementById('boworringsection').innerHTML = responseArray[1];
                        if(responseArray[2]=="1"){
                            new PNotify({
                                title: 'INVALID INPUT!',
                                text: 'Enter Institution Already Exists.',
                                type: 'info',
                                icon: 'ti ti-close',
                                styling: 'fontawesome'
                            });
                        }
                        $('#finaintname').selectpicker({
                            "livesearch":true
                        });
                        $("#datepicker3").datepicker({todayHighlight: true});
                        $("#datepicker4").datepicker({todayHighlight: true});
                    }
                };
                xmlhttp.open("GET", "classes/ajax_res.php?savefinancialint=" + data, true);
                xmlhttp.send();
            }



        }

}
function getfinancialinstitution() {
        var data = document.getElementById('returnfinainst').value;
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                var responseArray = xmlhttp.responseText.split("|<><>|");
                document.getElementById('financialint').value = responseArray[0];
            }
        };
        xmlhttp.open("GET", "classes/ajax_res.php?getfinancialint=" + data, true);
        xmlhttp.send();
}
function cancelfinancialinstitution() {

        var data = "1";
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                var responseArray = xmlhttp.responseText.split("|<><>|");
                document.getElementById('returnfina').innerHTML = responseArray[0];
            }
        };
        xmlhttp.open("GET", "classes/ajax_res.php?cancelfinancialinstitution=" + data, true);
        xmlhttp.send();
}

function saveBorrowings() {
  var data
    if(document.getElementById('accountafftchoice').innerHTML ===""){
        data =  document.getElementById('finaintname').value+"?::?"+
                document.getElementById('borrowedamount').value+"?::?"+
                document.getElementById('loaninterest').value+"?::?"+
                document.getElementById('processcharge').value+"?::?"+
                document.getElementById('datepicker3').value+"?::?"+
                document.getElementById('datepicker4').value+"?::?"+
                document.getElementById('banktracteditcode').innerHTML;
    }else{
        if(document.getElementById('bankchoice1').innerHTML === ""){
            data =  document.getElementById('finaintname').value+"?::?"+
                    document.getElementById('borrowedamount').value+"?::?"+
                    document.getElementById('loaninterest').value+"?::?"+
                    document.getElementById('processcharge').value+"?::?"+
                    document.getElementById('datepicker3').value+"?::?"+
                    document.getElementById('datepicker4').value+"?::?"+
                    document.getElementById('banktracteditcode').innerHTML+"?::?"+
                    document.getElementById('noacc1').value;
        }else{
            data =  document.getElementById('finaintname').value+"?::?"+
                    document.getElementById('borrowedamount').value+"?::?"+
                    document.getElementById('loaninterest').value+"?::?"+
                    document.getElementById('processcharge').value+"?::?"+
                    document.getElementById('datepicker3').value+"?::?"+
                    document.getElementById('datepicker4').value+"?::?"+
                    document.getElementById('banktracteditcode').innerHTML+"?::?"+
                    document.getElementById('yesacc1').value+"?::?"+
                    document.getElementById('bankaccountchoice1').value;
        }
    }

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('boworringsection').innerHTML = responseArray[0];
            document.getElementById('returnedborrowingtable').innerHTML = responseArray[1];
            document.getElementById('bankaccountbalances').innerHTML = responseArray[2];
            document.getElementById('repaymentchecks').innerHTML = responseArray[3];

            $('#grat2').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
            $('#finaintname').selectpicker({
                "livesearch":true
            });
            $('#getfinaintname').selectpicker({
                "livesearch":true
            });
            $("#datepicker3").datepicker({todayHighlight: true});
            $("#datepicker4").datepicker({todayHighlight: true});
        }
    };
    if(document.getElementById('accountafftchoice').innerHTML ===""){
        xmlhttp.open("GET", "classes/ajax_res.php?saveborrowing=" + data, true);
        xmlhttp.send();
    }else{
        if(document.getElementById('bankchoice1').innerHTML === ""){
            xmlhttp.open("GET", "classes/ajax_res.php?saveborrowing=" + data, true);
            xmlhttp.send();
        }else{
            if(document.getElementById('bankaccountchoice1').value ===""){
                new PNotify({
                    title: 'MISSING INPUT!',
                    text: 'Enter and it try again.',
                    type: 'warning',
                    icon: 'ti ti-close',
                    styling: 'fontawesome'
                });
            }else{
                xmlhttp.open("GET", "classes/ajax_res.php?saveborrowing=" + data, true);
                xmlhttp.send();
            }
        }
    }

}
function cancelborrowing() {

    var data = "1";
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('boworringsection').innerHTML = responseArray[0];
            $('#finaintname').selectpicker({
                "livesearch":true
            });
            $("#datepicker3").datepicker({todayHighlight: true});
            $("#datepicker4").datepicker({todayHighlight: true});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?cancelborrowing=" + data, true);
    xmlhttp.send();
}
function GetBorrowingTransaction(res) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('boworringsection').innerHTML = responseArray[0];
            $('#finaintname').selectpicker({
                "livesearch":true
            });
            $("#datepicker3").datepicker({todayHighlight: true});
            $("#datepicker4").datepicker({todayHighlight: true});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?getborrowingtransaction=" + res, true);
    xmlhttp.send();
}
function getborrowedinfo() {
    var res = document.getElementById('getfinaintname').value;
    if(document.getElementById('getfinaintname').value == ""){
        document.getElementById('borroweddetails').innerHTML = '' +
            '<table width="100%"> ' +
                '<tr> ' +
                    '<td><b style="color: #ffffff;font-weight: 900">Amount Borrowed :</b></td> <td>&nbsp;&nbsp;&nbsp;<b>0</b></td> ' +
                    '<td>&nbsp;&nbsp;&nbsp;<b style="color: #ffffff;font-weight: 900">Bal :</b></td> ' +
                    '<td>&nbsp;&nbsp;&nbsp;<b>0</b></td> ' +
                '</tr> ' +
                '<tr> ' +
                '<td><b style="color: #ffffff;font-weight: 900">Interest to be Paid :</b></td> ' +
                    '<td>&nbsp;&nbsp;&nbsp;<b>0</b></td> <td>&nbsp;&nbsp;&nbsp;<b style="color: #ffffff;font-weight: 900">Bal :</b></td> ' +
                    '<td>&nbsp;&nbsp;&nbsp;<b>0</b></td> ' +
                '</tr> ' +
            '</table>';
        document.getElementById('bankchoice12').innerHTML = "";
    }else{
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                var responseArray = xmlhttp.responseText.split("|<><>|");
                document.getElementById('borroweddetails').innerHTML = responseArray[0];
                document.getElementById('bankchoice12').innerHTML = responseArray[1];
                document.getElementById('returnedchequetable1').innerHTML = responseArray[2];
                $('#example').DataTable({
                    "bDestroy": true,
                    "paging": true,
                    "lengthChange": true,
                    "searching": true,
                    "ordering": true,
                    "info": true,
                    "autoWidth": true,
                    "sDom": 'lfrtip'
                });

                $('.dataTables_filter input').attr('placeholder','Search...');
                $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
                $('.panel-ctrls').append("<i class='separator'></i>");
                $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
                $('.panel-footer').append($(".dataTable+.row"));
                $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
                $('#getfinaintname').selectpicker({
                    "livesearch":true
                });
                $("#datepicker5").datepicker({todayHighlight: true});
            }
        };
        xmlhttp.open("GET", "classes/ajax_res.php?getborrowingdetails=" + res, true);
        xmlhttp.send();
    }

}
function bankchoicefun(){
    if(document.getElementById('yesacc').checked==true){
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                var responseArray = xmlhttp.responseText.split("|<><>|");
                document.getElementById('bankchoice').innerHTML = responseArray[0];
                $('#bankaccountchoice').selectpicker({
                    "livesearch":true
                });
            }
        };
        xmlhttp.open("GET", "classes/ajax_res.php?getbankchoicedetails=" + "1", true);
        xmlhttp.send();
    }
    if(document.getElementById('noacc').checked==true){
        document.getElementById('bankchoice').innerHTML = "";
    }
}
function bankchoicefun1(){
    if(document.getElementById('yesacc1').checked==true){
        if (window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                var responseArray = xmlhttp.responseText.split("|<><>|");
                document.getElementById('bankchoice1').innerHTML = responseArray[0];
                $('#bankaccountchoice1').selectpicker({
                    "livesearch":true
                });
            }
        };
        xmlhttp.open("GET", "classes/ajax_res.php?getbankchoicedetails1=" + "1", true);
        xmlhttp.send();
    }
    if(document.getElementById('noacc1').checked==true){
        document.getElementById('bankchoice1').innerHTML = "";
    }
}
function returnbankinfochoice(){
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('financialint').value = responseArray[0];
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?getbankchoicedetailsinfo=" + document.getElementById('bankaccountchoice').value, true);
    xmlhttp.send();
}

function getOrganisation(){
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('accountafftchoice').innerHTML = responseArray[0];
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?getorganisationchoice=" + document.getElementById('finaintname').value, true);
    xmlhttp.send();
}
function saverepaymentborrowing(){
    var data =  document.getElementById('reprincipal').value + "?::?" +
                document.getElementById('reinterest').value + "?::?" +
                document.getElementById('recharge').value + "?::?" +
                document.getElementById('datepicker5').value + "?::?" +
                document.getElementById('getfinaintname').value;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('repaymentchecks').innerHTML = responseArray[0];
            document.getElementById('borroweddetails').innerHTML = '' +
                '<table width="100%"> ' +
                '<tr> ' +
                '<td><b style="color: #ffffff;font-weight: 900">Amount Borrowed :</b></td> <td>&nbsp;&nbsp;&nbsp;<b>0</b></td> ' +
                '<td>&nbsp;&nbsp;&nbsp;<b style="color: #ffffff;font-weight: 900">Bal :</b></td> ' +
                '<td>&nbsp;&nbsp;&nbsp;<b>0</b></td> ' +
                '<td>&nbsp;&nbsp;&nbsp;<b style="color: #ffffff;font-weight: 900">Paid :</b></td> ' +
                '<td>&nbsp;&nbsp;&nbsp;<b>0</b></td> ' +
                '</tr> ' +
                '<tr> ' +
                '<td><b style="color: #ffffff;font-weight: 900">Interest to be Paid :</b></td> ' +
                '<td>&nbsp;&nbsp;&nbsp;<b>0</b></td> ' +
                '<td>&nbsp;&nbsp;&nbsp;<b style="color: #ffffff;font-weight: 900">Bal :</b></td> ' +
                '<td>&nbsp;&nbsp;&nbsp;<b>0</b></td> ' +
                '<td>&nbsp;&nbsp;&nbsp;<b style="color: #ffffff;font-weight: 900">Paid :</b></td> ' +
                '<td>&nbsp;&nbsp;&nbsp;<b>0</b></td> ' +
                '</tr> ' +
                '</table>';
            document.getElementById('bankchoice12').innerHTML = "";
            document.getElementById('returnedchequetable1').innerHTML = responseArray[1];
            $('#example').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
            $('#getfinaintname').selectpicker({
                "livesearch":true
            });
            $('#getfinaintname').selectpicker({
                "livesearch":true
            });
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?getrepaymentborrowing=" + data, true);
    xmlhttp.send();
}
function SaveExpense(){
    var data;

    if(document.getElementById('returnedoptionss').innerHTML === ""){
        data =  document.getElementById('codereturn').value +"?::?"+
                document.getElementById('cashoptions').value +"?::?"+
                document.getElementById('slipno').value +"?::?"+
                document.getElementById('transacamount').value +"?::?"+
                document.getElementById('datepicker1').value +"?::?"+
                document.getElementById('itemdescription').value;
        if(document.getElementById('returnedbanks').innerHTML === ""){}else{
            data += "?::?" + document.getElementById('bankaccounts').value;
        }
    }else{
        data =  document.getElementById('rtnvalues').value +"?::?"+
                document.getElementById('cashoptions').value +"?::?"+
                document.getElementById('slipno').value +"?::?"+
                document.getElementById('transacamount').value +"?::?"+
                document.getElementById('datepicker1').value +"?::?"+
                document.getElementById('itemdescription').value;
        if(document.getElementById('returnedbanks').innerHTML === ""){ }else{
            data += "?::?" + document.getElementById('bankaccounts').value;
        }
    }

    if(document.getElementById('expenseid').innerHTML === ""){}else{data += "?::?" + document.getElementById('expenseid').innerHTML;}

    if(document.getElementById('cashoptions').value === "1" && parseInt(document.getElementById('pettycash').innerHTML) < parseInt(document.getElementById('transacamount').value)){
		new PNotify({
			title: 'INSUFFIENT AMOUNT AVAILABLE, INCREASE IT FIRST!',
			text: 'And try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
	}else{
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById('expensesdata').innerHTML = responseArray[0];
				document.getElementById('expensetable').innerHTML = responseArray[1];
				$('#grn').DataTable({
                                    "bDestroy": true,
                                    "paging": true,
                                    "lengthChange": true,
                                    "searching": true,
                                    "ordering": true,
                                    "info": true,
                                    "autoWidth": true,
                                    "dom": 'Bfrtip',
                                    "buttons": [
                                        'csv', 'excel', 'pdf', 'print'
                                    ]
				});
                                

//				$('.dataTables_filter input').attr('placeholder','Search...');
				$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
				$('.panel-ctrls').append("<i class='separator'></i>");
				$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
				$('.panel-footer').append($(".dataTable+.row"));
				$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
				$('#codereturn').selectpicker({
					"livesearch":true
				});
				$("#datepicker1").datepicker({todayHighlight: true});
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?saveexpense=" + data, true);
		xmlhttp.send();
	}


}
function cancelexpense(){

    var data = "1";
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('expensesdata').innerHTML = responseArray[0];
            $('#codereturn').selectpicker({
                "livesearch":true
            });
            $("#datepicker1").datepicker({todayHighlight: true});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?cancelexpense=" + data, true);
    xmlhttp.send();
}

function updatechartcoadestatus(data){

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('chartpreview').innerHTML = responseArray[0];
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?updatechartcoadestatus=" + data, true);
    xmlhttp.send();

}
function updatechartcoadestatus1(data){

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('chartpreview').innerHTML = responseArray[0];
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?updatechartcoadestatus1=" + data, true);
    xmlhttp.send();

}
function setDepreciation(){

    var data =  document.getElementById('assetaccount').value +"?::?"+
                document.getElementById('assetaccountpercentage').value +"?::?"+
                document.getElementById('depreciationtype').value;
	if(document.getElementById('depreciationtype').value == "0" && document.getElementById('assetaccountpercentage').value == "" || document.getElementById('assetaccount').value == ""){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
	}else{
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById('assetdata').innerHTML = responseArray[0];
				document.getElementById('deprmodify').innerHTML = responseArray[1];
				$('#assetaccount').selectpicker({
					"livesearch":true
				});
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?setdepreciation=" + data, true);
		xmlhttp.send();
	}

}
function SaveAsset() {
    var data;
	data = document.getElementById('asseteditid').innerHTML+"?||?";
    if(document.getElementById('assettypecheck').innerHTML == ""){
        data +=  document.getElementById('assetaccountid').value +"?::?"+
                document.getElementById('assetnumber').value +"?::?"+
                document.getElementById('datepicker1').value +"?::?"+
                document.getElementById('assetdescription').value +"?::?"+
                document.getElementById('assetvalue').value;
    }else{
        data +=  document.getElementById('assetaccountid').value +"?::?"+
                document.getElementById('assetnumber').value +"?::?"+
                document.getElementById('datepicker1').value +"?::?"+
                document.getElementById('assetdescription').value +"?::?"+
                document.getElementById('assetvalue').value;

				if(document.getElementById('typecode').innerHTML =="1"){
					data = 	data +"?::?"+ document.getElementById('workinglife').value +"?::?"+
							document.getElementById('scrapvalue').value;
				}else{
					if(document.getElementById('yesacc').checked==true){
						data = 	data +"?::?"+ document.getElementById('workinglife').value +"?::?"+"nill";
					}else{
						data = 	data +"?::?"+ "nill" +"?::?"+"nill";
					}
				}
    }

	if(document.getElementById('assetaccountid').value==""||document.getElementById('assetnumber').value==""||document.getElementById('datepicker1').value==""||document.getElementById('assetdescription').value==""||document.getElementById('assetvalue').value==""){

		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});

    }else{
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById('assetdata').innerHTML = responseArray[0];
				document.getElementById('assettable').innerHTML = responseArray[1];
				$('#grn').DataTable({
					"bDestroy": true,
					"paging": true,
					"lengthChange": true,
					"searching": true,
					"ordering": true,
					"info": true,
					"autoWidth": true,
					"sDom": 'lfrtip'
				});

				$('.dataTables_filter input').attr('placeholder','Search...');
				$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
				$('.panel-ctrls').append("<i class='separator'></i>");
				$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
				$('.panel-footer').append($(".dataTable+.row"));
				$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
				$('#assetaccountid').selectpicker({
					"livesearch":true
				});
				$("#datepicker1").datepicker({todayHighlight: true});
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?saveassets=" + data, true);
		xmlhttp.send();
    }

}
function SaveAsset1() {
    var data;
        data =  document.getElementById('assetaccountid1').value +"?::?"+
                document.getElementById('datepicker2').value +"?::?"+
                document.getElementById('assetdesc').value +"?::?"+
                document.getElementById('qty').value +"?::?"+
                document.getElementById('amount').value;


    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('assetpurchase').innerHTML = responseArray[0];
            document.getElementById('assetpurchasetable').innerHTML = responseArray[1];
            $('#example').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
            $('#assetaccountid1').selectpicker({
                "livesearch":true
            });
            $("#datepicker2").datepicker({todayHighlight: true});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?saveassetpurchase=" + data, true);
    xmlhttp.send();
}
function cancelAssets(){

    var data = "1";
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('assetdata').innerHTML = responseArray[0];
            $('#assetaccountid').selectpicker({
                "livesearch":true
            });
            $("#datepicker1").datepicker({todayHighlight: true});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?cancelassets=" + data, true);
    xmlhttp.send();
}
function cancelAssets1(){

    var data = "1";
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('assetpurchase').innerHTML = responseArray[0];
            $('#assetaccountid1').selectpicker({
                "livesearch":true
            });
            $("#datepicker1").datepicker({todayHighlight: true});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?cancelassets1=" + data, true);
    xmlhttp.send();
}
function getassettype(){
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('assettypecheck').innerHTML = responseArray[0];
            $('#assetaccount').selectpicker({
                "livesearch":true
            });
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?getassetype=" + document.getElementById('assetaccountid').value, true);
    xmlhttp.send();
}
function getreceiveable(){
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('assettypecheck').innerHTML = responseArray[0];
            $('#rtnvalues').selectpicker({
                "livesearch":true
            });
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?getreceiveable=" + document.getElementById('receiveableid').value, true);
    xmlhttp.send();
}

function SaveCreditPurchase(){
   var data =  document.getElementById('assetaccountid1').value+"?::?"+
               document.getElementById('creditorsname').value+"?::?"+
               document.getElementById('datepicker1').value+"?::?"+
               document.getElementById('assetdesc').value+"?::?"+
               document.getElementById('qty').value+"?::?"+
               document.getElementById('amount').value+"?::?"+
               document.getElementById('amtpaid').value+"?::?"+
               document.getElementById('amtpayable').value;

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('purchasecreditdata').innerHTML = responseArray[0];
            document.getElementById('purchasecredittable').innerHTML = responseArray[1];
            $('#grn').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
            $('#assetaccountid1').selectpicker({
                "livesearch":true
            });
            $("#datepicker1").datepicker({todayHighlight: true});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?savecreditpurchase=" + data, true);
    xmlhttp.send();
}
function cancelCreditPurchase(){

    var data = "1";
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('purchasecreditdata').innerHTML = responseArray[0];
            $('#assetaccountid1').selectpicker({
                "livesearch":true
            });
            $("#datepicker1").datepicker({todayHighlight: true});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?cancelcreditpurchase=" + data, true);
    xmlhttp.send();
}
function SaveCreditSale(){
    var data;

	if(document.getElementById('assettypecheck').innerHTML === ""){
        data =  document.getElementById('receiveableid').value+"?::?"+
                document.getElementById('debitorname').value+"?::?"+
                document.getElementById('datepicker2').value+"?::?"+
                document.getElementById('assetdesc1').value+"?::?"+
                document.getElementById('qty1').value+"?::?"+
                document.getElementById('amount1').value+"?::?"+
                document.getElementById('rcvamt').value+"?::?"+
                document.getElementById('amtrcvable').value;
    }else{
        data =  document.getElementById('rtnvalues').value+"?::?"+
                document.getElementById('debitorname').value+"?::?"+
                document.getElementById('datepicker2').value+"?::?"+
                document.getElementById('assetdesc1').value+"?::?"+
                document.getElementById('qty1').value+"?::?"+
                document.getElementById('amount1').value+"?::?"+
                document.getElementById('rcvamt').value+"?::?"+
                document.getElementById('amtrcvable').value;
	}
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('creditsale').innerHTML = responseArray[0];
            document.getElementById('creditsaletable').innerHTML = responseArray[1];
            $('#example').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
            $('#assetaccountid').selectpicker({
                "livesearch":true
            });
            $("#datepicker2").datepicker({todayHighlight: true});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?savecreditsale=" + data, true);
    xmlhttp.send();
}
function cancelCreditSale(){

    var data = "1";
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('creditsale').innerHTML = responseArray[0];
            $('#receiveableid').selectpicker({
                "livesearch":true
            });
            $("#datepicker2").datepicker({todayHighlight: true});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?cancelcreditsale=" + data, true);
    xmlhttp.send();
}
function SaveIncometrail(){

    var data =  document.getElementById('incomeaccount').value+"?::?"+
                document.getElementById('slipno').value+"?::?"+
                document.getElementById('datepicker1').value+"?::?"+
                document.getElementById('incomedesc').value+"?::?"+
                document.getElementById('amtrcvd').value;
if(document.getElementById('incomeedditdata').innerHTML === ""){}else{data += "?::?" + document.getElementById('incomeedditdata').innerHTML;}

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('incomedata').innerHTML = responseArray[0];
            document.getElementById('incometable').innerHTML = responseArray[1];
            $('#grn').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
            $('#incomeaccount').selectpicker({
                "livesearch":true
            });
            $("#datepicker1").datepicker({todayHighlight: true});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?saveincometrail=" + data, true);
    xmlhttp.send();
}
function SaveInvestiment(){

    var data =  document.getElementById('incomeaccount').value+"?::?"+
                document.getElementById('slipno').value+"?::?"+
                document.getElementById('datepicker1').value+"?::?"+
                document.getElementById('incomedesc').value+"?::?"+
                document.getElementById('amtrcvd').value;

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('incomedata').innerHTML = responseArray[0];
            document.getElementById('incometable').innerHTML = responseArray[1];
            $('#grn').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
            $('#incomeaccount').selectpicker({
                "livesearch":true
            });
            $("#datepicker1").datepicker({todayHighlight: true});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?saveinvestment=" + data, true);
    xmlhttp.send();
}
function cancelIncome(){
    var data = "1";
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('incomedata').innerHTML = responseArray[0];
            $('#incomeaccount').selectpicker({
                "livesearch":true
            });
            $("#datepicker1").datepicker({todayHighlight: true});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?cancelincometrail=" + data, true);
    xmlhttp.send();
}
function cancelInvestiment(){
    var data = "1";
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('incomedata').innerHTML = responseArray[0];
            $('#incomeaccount').selectpicker({
                "livesearch":true
            });
            $("#datepicker1").datepicker({todayHighlight: true});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?cancelinvestiment=" + data, true);
    xmlhttp.send();
}

function blacklist(data){

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('accountblacklist').innerHTML = responseArray[0];
            document.getElementById('blacklist').innerHTML = responseArray[1];
            document.getElementById('retreivedblacklist').innerHTML = responseArray[2];
			$('#grn').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });
			$('#grat1').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });
			$('#example').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?blacklist=" + data, true);
    xmlhttp.send();
}
function undoblacklist(data){

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
             document.getElementById('accountblacklist').innerHTML = responseArray[0];
            document.getElementById('blacklist').innerHTML = responseArray[1];
            document.getElementById('retreivedblacklist').innerHTML = responseArray[2];
			$('#grn').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });
			$('#grat1').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });
			$('#example').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?undoblacklist=" + data, true);
    xmlhttp.send();
}
function getsharedata(){
	var data;
	if(document.getElementById('basic').value==""){data="emp";}else{data = document.getElementById('basic').value;}
	if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
             document.getElementById('shareledgertable').innerHTML = responseArray[0];
			$('#example').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?getsharedata=" + data, true);
    xmlhttp.send()
}
function accountnsharesettingdata(data,typ){

	if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
			if(typ == "1"){document.getElementById('accshrval').value = responseArray[0];}
			if(typ == "2"){document.getElementById('sharedata1').value = responseArray[0];}
			if(typ == "3"){document.getElementById('loanchargesid').value = responseArray[0];}
			if(typ == "4"){document.getElementById('perloanprov').value = responseArray[0];}
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?getaccountsharedata=" + data, true);
    xmlhttp.send()
}

function savesettings(vals,typ,e){
	if(vals == ""){
		new PNotify({
            title: 'MISSING INPUT!',
            text: 'Select first and try again.',
            type: 'warning',
            icon: 'ti ti-close',
            styling: 'fontawesome'
        });
	}else{
		data = vals+"?::?"+e;
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				if(typ == "1"){document.getElementById('accshrval').value = ""; document.getElementById('accountshare').selectedIndex = 0;}
				if(typ == "2"){document.getElementById('sharedata1').value = ""; document.getElementById('getshareid').selectedIndex = 0;}
				if(typ == "3"){document.getElementById('loanchargesid').value = ""; document.getElementById('loanchargesdataid').selectedIndex = 0;}
				if(typ == "4"){document.getElementById('perloanprov').value = ""; document.getElementById('loanprov').selectedIndex = 0;}
				if(typ == "5"){document.getElementById('veiwschedule').value = responseArray[0]; document.getElementById('schedule').selectedIndex = 0;}
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?updatesetttings=" + data, true);
		xmlhttp.send()
	}
}
function addloantype(){
	var data;
	if(document.getElementById('modloantype').value== ""){
		data = document.getElementById('loantypedata').value;
	}else{
		data = document.getElementById('loantypedata').value+"?::?"+document.getElementById('modloantype').value;
	}
	if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('loantypedata').value = "";
            document.getElementById('getloantype').innerHTML = responseArray[0];
            document.getElementById('getloantypemodal').innerHTML = responseArray[1];
            document.getElementById('modgraceperoid').innerHTML = responseArray[2];
            document.getElementById('modloantype').selectedIndex = 0;
			document.getElementById('delloantypebut').disabled  = true;
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?getloantype=" + data, true);
    xmlhttp.send()
}
function addsavingtype(){
	var data;
	if(document.getElementById('modsavetype').value== ""){
		data = document.getElementById('savingtypedata').value;
	}else{
		data = document.getElementById('savingtypedata').value+"?::?"+document.getElementById('modsavetype').value;
	}
	if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('savingtypedata').value = "";
            document.getElementById('getsavetype').innerHTML = responseArray[0];
            document.getElementById('getsavetypeemodal').innerHTML = responseArray[1];
            document.getElementById('modsavetype').selectedIndex = 0;
			document.getElementById('delsavetypebut').disabled  = true;
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?addsavingtype=" + data, true);
    xmlhttp.send()
}
function removeloantype(){
	var data = document.getElementById('modloantype').value;

	if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('loantypedata').value = "";
            document.getElementById('getloantype').innerHTML = responseArray[0];
            document.getElementById('getloantypemodal').innerHTML = responseArray[1];
            document.getElementById('modgraceperoid').innerHTML = responseArray[2];
            document.getElementById('modloantype').selectedIndex = 0;
			document.getElementById('delloantypebut').disabled  = true;
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?delloantype=" + data, true);
    xmlhttp.send()
}
function removesavetype(){
	var data = document.getElementById('modsavetype').value;

	if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('savingtypedata').value = "";
            document.getElementById('getsavetype').innerHTML = responseArray[0];
            document.getElementById('getsavetypeemodal').innerHTML = responseArray[1];
            document.getElementById('modsavetype').selectedIndex = 0;
			document.getElementById('delsavetypebut').disabled  = true;
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?delsavetype=" + data, true);
    xmlhttp.send()
}
function ModifyLoanInterest(){
	var data = document.getElementById('modeloantypeint').value+"?::?"+document.getElementById('interestloantypeinput').value;

	if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('interestloantypeinput').value = "";
            document.getElementById('getloantypemodal').innerHTML = responseArray[0];
            document.getElementById('modeloantypeint').selectedIndex = 0;
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?modloantypeint=" + data, true);
    xmlhttp.send()
}
function ModifySaveInterest(){
	var data = document.getElementById('modesavetypeint').value+"?::?"+document.getElementById('interestsavetypeinput').value;

	if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('interestsavetypeinput').value = "";
            document.getElementById('getsavetypeemodal').innerHTML = responseArray[0];
            document.getElementById('modesavetypeint').selectedIndex = 0;
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?modsavetypeint=" + data, true);
    xmlhttp.send()
}
function ModifyLoanPeroid(){
	var data = document.getElementById('graceperoid').value+"?::?"+document.getElementById('modgraceperiod').value;

	if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('graceperoid').value = "";
            document.getElementById('modgraceperoid').innerHTML = responseArray[0];
            document.getElementById('modgraceperiod').selectedIndex = 0;
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?modloantypepreoid=" + data, true);
    xmlhttp.send()
}
function loanfunc(){
	if(document.getElementById('modloantype').value == ""){
		document.getElementById('delloantypebut').disabled  = true;
	}else{
		document.getElementById('delloantypebut').disabled  = false;
	}
}
function savingtypefunc(){
	if(document.getElementById('modsavetype').value == ""){
		document.getElementById('delsavetypebut').disabled  = true;
	}else{
		document.getElementById('delsavetypebut').disabled  = false;
	}
}
function checktranstype(){
	if(document.getElementById('transactiontype').value == ""){
		document.getElementById('sdtype').innerHTML  = '' +
            '<label class="labelcolor">Destination/Source</label>' +
            '<select disabled id="destination" class="form-control">' +
            '<option value="">select Destination/Source</option>' +
            '<option value="1">Petty Cash</option><option value="2">Cashier Accounts</option>' +
            '</select><br>';
	}
	if(document.getElementById('transactiontype').value == "1"){
		document.getElementById('sdtype').innerHTML  = '' +
            '<label class="labelcolor">Source</label>' +
            '<select id="destination" class="form-control">' +
            '<option value="">select Source</option>' +
            '<option value="1">Cashier Collections</option>' +
            '<option value="2">From Bank</option>' +
            '<option value="3">Payment Source</option>' +
            '<option value="4">Borrowings</option>' +
            '<option value="5">From Petty Cash</option>' +
            '</select><br>';
	}
	if(document.getElementById('transactiontype').value == "2"){
		document.getElementById('sdtype').innerHTML  = '' +
            '<label class="labelcolor">Destination</label>' +
            '<select id="destination" class="form-control">' +
            '<option value="">select Destination</option>' +
            '<option value="1">Petty Cash</option>' +
            '<option value="2">Cashier Accounts</option>' +
            '<option value="3">To Bank</option>' +
            '</select><br>';
	}
}
function savevaulttransaction(){
	document.getElementById('subtrac').disabled = true;
	var data = 	document.getElementById('transactiontype').value+"?::?"+
				document.getElementById('transactionamt').value+"?::?"+
				document.getElementById('destination').value

			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			} else {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function () {
				if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
					var responseArray = xmlhttp.responseText.split("|<><>|");


					if(responseArray[0] == "1"){
						document.getElementById('transactiontype').value = "";
						document.getElementById('subtrac').disabled = false;
							new PNotify({
								title: 'INSUFFIENT AMOUNT AVAILABLE, INCREASE IT FIRST!',
								text: 'And try again.',
								type: 'warning',
								icon: 'ti ti-close',
								styling: 'fontawesome'
							});
					}else if(responseArray[0] == "2"){
						document.getElementById('subtrac1').disabled = false;
						document.getElementById('transactiontype').value = "";
							new PNotify({
								title: 'INSUFFIENT AMOUNT AVAILABLE, INCREASE IT FIRST!',
								text: 'And try again.',
								type: 'warning',
								icon: 'ti ti-close',
								styling: 'fontawesome'
							});
					}else{
							if(document.getElementById('transactiontype').value=="" || document.getElementById('transactionamt').value=="" || document.getElementById('destination').value==""){
									new PNotify({
									title: 'MISSING INPUT!',
									text: 'Enter and try again.',
									type: 'warning',
									icon: 'ti ti-close',
									styling: 'fontawesome'
								});
							}else{
								if (window.XMLHttpRequest) {
									xmlhttp = new XMLHttpRequest();
								} else {
									xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
								}
								xmlhttp.onreadystatechange = function () {
									if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
										var responseArray = xmlhttp.responseText.split("|<><>|");
										document.getElementById("returnedvaulttracstable").innerHTML = responseArray[0];
										document.getElementById("returnedvaulttracs").innerHTML = responseArray[1];
										document.getElementById("pettycash").innerHTML = responseArray[2];
										document.getElementById("vaultcashiercash").innerHTML = responseArray[3];
										document.getElementById("cashsummay").innerHTML = responseArray[4];


									$('#grn').DataTable({
										"bDestroy": true,
										"paging": true,
										"lengthChange": true,
										"searching": true,
										"ordering": true,
										"info": true,
										"autoWidth": true,
										"sDom": 'lfrtip'
									});
									$('#grat1').DataTable({
										"bDestroy": true,
										"paging": true,
										"lengthChange": true,
										"searching": true,
										"ordering": true,
										"info": true,
										"autoWidth": true,
										"sDom": 'lfrtip'
									});
									$('#grat2').DataTable({
										"bDestroy": true,
										"paging": true,
										"lengthChange": true,
										"searching": true,
										"ordering": true,
										"info": true,
										"autoWidth": true,
										"sDom": 'lfrtip'
									});

									$('.dataTables_filter input').attr('placeholder','Search...');
									$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
									$('.panel-ctrls').append("<i class='separator'></i>");
									$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
									$('.panel-footer').append($(".dataTable+.row"));
									$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n")
									}
								};
								xmlhttp.open("GET", "classes/ajax_res.php?savevaulttracs=" + data, true);
								xmlhttp.send();
							}

					}
				}

			};

			xmlhttp.open("GET", "classes/ajax_res.php?vaultcashcheck=" + data, true);
			xmlhttp.send();
}

function savecashiertransaction(){
	document.getElementById('subtrac1').disabled = true;
	var data = 	document.getElementById('cashierid').value+"?::?"+
				document.getElementById('actiontype').value+"?::?"+
				document.getElementById('tracamt').value

	if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");


				if(responseArray[0] == "1"){
					document.getElementById('subtrac1').disabled = false;
					    new PNotify({
							title: 'INSUFFIENT AMOUNT AVAILABLE, INCREASE IT FIRST!',
							text: 'And try again.',
							type: 'warning',
							icon: 'ti ti-close',
							styling: 'fontawesome'
						});
				}else if(responseArray[0] == "2"){
					document.getElementById('subtrac1').disabled = false;
					    new PNotify({
							title: 'CLOSED ACCOUNT, OPEN IT FIRST!',
							text: 'And try again.',
							type: 'warning',
							icon: 'ti ti-close',
							styling: 'fontawesome'
						});
				}else{
					if(document.getElementById('cashierid').value=="" || document.getElementById('actiontype').value=="" || document.getElementById('tracamt').value==""){
							new PNotify({
							title: 'MISSING INPUT!',
							text: 'Enter and try again.',
							type: 'warning',
							icon: 'ti ti-close',
							styling: 'fontawesome'
						});
					}else{
						if (window.XMLHttpRequest) {
							xmlhttp = new XMLHttpRequest();
						} else {
							xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
						}
						xmlhttp.onreadystatechange = function () {
							if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
								var responseArray = xmlhttp.responseText.split("|<><>|");
								document.getElementById("cashierrecords").innerHTML = responseArray[0];
								document.getElementById("vaultcashiercash").innerHTML = responseArray[1];
								document.getElementById("cashiersection").innerHTML = responseArray[2];
								document.getElementById("cashsummay").innerHTML = responseArray[3];
								document.getElementById('cashieramtsummary').innerHTML = "";
							$('#example').DataTable({
								"bDestroy": true,
								"paging": true,
								"lengthChange": true,
								"searching": true,
								"ordering": true,
								"info": true,
								"autoWidth": true,
								"sDom": 'lfrtip'
							});
							$('#grat1').DataTable({
								"bDestroy": true,
								"paging": true,
								"lengthChange": true,
								"searching": true,
								"ordering": true,
								"info": true,
								"autoWidth": true,
								"sDom": 'lfrtip'
							});
							$('.dataTables_filter input').attr('placeholder','Search...');
							$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
							$('.panel-ctrls').append("<i class='separator'></i>");
							$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
							$('.panel-footer').append($(".dataTable+.row"));
							$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n")
							}
						};
						xmlhttp.open("GET", "classes/ajax_res.php?savecashiertracs=" + data, true);
						xmlhttp.send();
					}
				}
			}

		};

		xmlhttp.open("GET", "classes/ajax_res.php?cashcashcheck=" + data, true);
		xmlhttp.send();
}
function addclientstotrail(){
	var data = 	document.getElementById('basic').value+"?::?"+document.getElementById('clientloopid').innerHTML
	if(document.getElementById('basic').value == ""){

	}else{
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");

				document.getElementById('clientspace').innerHTML = responseArray[1];
				document.getElementById('clientloopid').innerHTML = responseArray[0];
			}

		};

		xmlhttp.open("GET", "classes/ajax_res.php?addclientstotrail=" + data, true);
		xmlhttp.send();
	}

}
function addclientstotrail2(){
	var data = 	document.getElementById('basic').value+"?::?"+document.getElementById('clientloopid').innerHTML
	if(document.getElementById('basic').value == ""){

	}else{
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");

				document.getElementById('clientspace').innerHTML = responseArray[1];
				document.getElementById('clientloopid').innerHTML = responseArray[0];
			}

		};

		xmlhttp.open("GET", "classes/ajax_res.php?addclientstotrail=" + data, true);
		xmlhttp.send();
	}

}
function addclientstotrail1(){
	var data = 	document.getElementById('basic').value+"?::?"+
				document.getElementById('clientloopid').innerHTML+"?::?"+
				document.getElementById('amtrcvd').value+"?::?"+
				document.getElementById('amtclientloopid').innerHTML
	if(document.getElementById('basic').value == "" || document.getElementById('amtrcvd').value == "" || document.getElementById('orderaccount').value == ""){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
	}else if(document.getElementById('basic').value == document.getElementById('orderaccount').value){
		new PNotify({
			title: 'THIS IS AN ORDERING ACCOUNT!',
			text: 'Choose Another and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
	}else{
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById('clientspace').innerHTML = responseArray[2];
				document.getElementById('clientloopid').innerHTML = responseArray[0];
				document.getElementById('amtclientloopid').innerHTML = responseArray[1];
			}

		};

		xmlhttp.open("GET", "classes/ajax_res.php?addclientstotrail1=" + data, true);
		xmlhttp.send();
	}

}
function removeclientid(vals){
	var data = 	vals+"?::?"+document.getElementById('clientloopid').innerHTML

	if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");

				document.getElementById('clientspace').innerHTML = responseArray[1];
				document.getElementById('clientloopid').innerHTML = responseArray[0];
			}

		};

		xmlhttp.open("GET", "classes/ajax_res.php?removeclientid=" + data, true);
		xmlhttp.send();
}
function removeclientid1(vals){
	var data = 	vals+"?::?"+document.getElementById('clientloopid').innerHTML+"?::?"+document.getElementById('amtclientloopid').innerHTML

	if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");

				document.getElementById('clientspace').innerHTML = responseArray[2];
				document.getElementById('clientloopid').innerHTML = responseArray[0];
				document.getElementById('amtclientloopid').innerHTML = responseArray[1];
			}

		};

		xmlhttp.open("GET", "classes/ajax_res.php?removeclientid1=" + data, true);
		xmlhttp.send();
}
function inoutcheckcash(){

	var data = 	document.getElementById('cashierid').value+"?::?"+
				document.getElementById('actiontype').value


	if(document.getElementById('cashierid').value=="" || document.getElementById('actiontype').value==""){
		    new PNotify({
            title: 'MISSING INPUT!',
            text: 'Enter and try again.',
            type: 'warning',
            icon: 'ti ti-close',
            styling: 'fontawesome'
        });
	}else{
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");


				if(responseArray[0] == "1"){
					document.getElementById('actiontype').selectedIndex = 0;
					    new PNotify({
							title: 'LET CASHIER SAVE FIRST!',
							text: 'And try again.',
							type: 'warning',
							icon: 'ti ti-close',
							styling: 'fontawesome'
						});
				}
			}

		};

		xmlhttp.open("GET", "classes/ajax_res.php?inoutcashcheck=" + data, true);
		xmlhttp.send();

	}
}
function transferaccountchoice(){

			var supvalues = document.getElementById('transferoptions').value;
            if (window.XMLHttpRequest) {
                xmlhttp = new XMLHttpRequest();
            } else {
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                    var responseArray = xmlhttp.responseText.split("|<><>|");
					if(responseArray[0]==""){
						document.getElementById("amtrcvd").disabled = false;
						document.getElementById("amtrcvd").value = "";
					}else{
						document.getElementById("amtrcvd").value = responseArray[0];
						document.getElementById("amtrcvd").disabled = true;
					}


                }
            };
            xmlhttp.open("GET", "classes/ajax_res.php?depositsupvalues=" + supvalues, true);
            xmlhttp.send();
}
function savetransfersavings(){
    var data = document.getElementById('basic').value+"?::?"+document.getElementById('transferoptions').value+"?::?"+document.getElementById('amtrcvd').value
    var a
    var b;
    a = parseInt(document.getElementById('amtrcvd').value);
    b = parseInt(document.getElementById('savbal').innerHTML);
    if(document.getElementById('basic').value==""){
		document.getElementById('savingbal').innerHTML = "0";
	}else if(document.getElementById('transferoptions').value =="" || document.getElementById('amtrcvd').value ==""){
		new PNotify({
            title: 'MISSING INPUT!',
            text: 'Enter and try again.',
            type: 'warning',
            icon: 'ti ti-close',
            styling: 'fontawesome'
        });
	}else{
            if(a > b){
                new PNotify({
                        title: 'INSUFFICIENT FUNDS!',
                        text: 'Enter Amount in Range and try again.',
                        type: 'warning',
                        icon: 'ti ti-close',
                        styling: 'fontawesome'
                });
            }else{
                    if (window.XMLHttpRequest) {
                            xmlhttp = new XMLHttpRequest();
                    } else {
                            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    }
                    xmlhttp.onreadystatechange = function () {
                        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                            var responseArray = xmlhttp.responseText.split("|<><>|");
                            document.getElementById('noncashtransfertable').innerHTML = responseArray[0];
                            document.getElementById('noncashtransferdata').innerHTML = responseArray[1];

                            $('#grn').DataTable({
                                    "bDestroy": true,
                                    "paging": true,
                                    "lengthChange": true,
                                    "searching": true,
                                    "ordering": true,
                                    "info": true,
                                    "autoWidth": true,
                                    "sDom": 'lfrtip'
                            });

                            $('.dataTables_filter input').attr('placeholder','Search...');
                            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
                            $('.panel-ctrls').append("<i class='separator'></i>");
                            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
                            $('.panel-footer').append($(".dataTable+.row"));
                            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
                            $('#basic').selectpicker({
                                "livesearch":true
                            });
                        }
                    };

                    xmlhttp.open("GET", "classes/ajax_res.php?savetransfersavings=" + data, true);
                    xmlhttp.send();
		}
	}
}
function getsavingbalance(){
	var data = 	document.getElementById('basic').value


	if(document.getElementById('basic').value==""){
		document.getElementById('savingbal').innerHTML = "0";
	}else{
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
					document.getElementById('savingbal').innerHTML = responseArray[0];
					document.getElementById('savbal').innerHTML = responseArray[1];
			}

		};

		xmlhttp.open("GET", "classes/ajax_res.php?getsavingbalance=" + data, true);
		xmlhttp.send();

	}
}
function cancelvault(){
	document.getElementById("returnedvaulttracs").innerHTML = '' +
        '<label class="labelcolor">Vault Amount</label> ' +
        '<input onclick="" id="transactionamt" type="number" class="form-control" placeholder="Enter Transaction Amount"><br> ' +
        '<label class="labelcolor">Action Type</label> ' +
        '<select onchange="checktranstype()" id="transactiontype" class="form-control"> ' +
        '<option value="">select Action Type</option> ' +
        '<option value="1">Vault In</option> ' +
        '<option value="2">Vault Out</option> ' +
        '</select><br> ' +
        '<div id="sdtype"> ' +
        '<label class="labelcolor">Destination/Source</label> ' +
        '<select disabled id="destination" class="form-control"> ' +
        '<option value="">select Destination/Source</option> ' +
        '<option value="1">Petty Cash</option> ' +
        '<option value="2">Cashier Accounts</option> ' +
        '<option value="3">To Bank</option> ' +
        '</select><br> ' +
        '</div> ' +
        '<div id="cashieridspace"></div> ' +
        '<center> ' +
        '<button id="subtrac" class="btn-primary btn" type="" onclick="savevaulttransaction()">Submit Transaction</button> ' +
        '<button onclick="cancelvault()" type="reset" class="btn btn-default">Cancel</button> ' +
        '</center> <br><br>';
}
function canceltransfersavings(){

    var data = "1";
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('noncashtransferdata').innerHTML = responseArray[0];

			$('#basic').selectpicker({
				"livesearch":true
			});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?canceltransfersavings=" + data, true);
    xmlhttp.send();
}
function cancelmultipledeposit(){

    var data = "1";
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('noncashtransferdata').innerHTML = responseArray[0];

			$('#basic').selectpicker({
				"livesearch":true
			});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?cancelmultipledeposit=" + data, true);
    xmlhttp.send();
}
function cancelstandingorder(){

    var data = "1";
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('noncashtransferdata').innerHTML = responseArray[0];
			$("#datepicker").datepicker({todayHighlight: true});
			$('#basic').selectpicker({
				"livesearch":true
			});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?cancelstandingorders=" + data, true);
    xmlhttp.send();
}
function cancelcashiercash(){

    var data = "1";
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('cashiersection').innerHTML = responseArray[0];
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?cancelcashiersection=" + data, true);
    xmlhttp.send();
}
function cashieramountsummary(){

    var data = document.getElementById('cashierid').value;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('cashieramtsummary').innerHTML = responseArray[0];
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?cashieramtsummary=" + data, true);
    xmlhttp.send();
}

function savesocheckamt(a,b,c,d){
	var data  = document.getElementById('socheckamt').value+"?::?"+
				document.getElementById('shortage').innerHTML+"?::?"+
				document.getElementById('overage').innerHTML+"?::?"+
				a+"?::?"+
				b+"?::?"+
				c+"?::?"+d;

	if(document.getElementById('socheckamt').value==""){
		    new PNotify({
            title: 'MISSING INPUT!',
            text: 'Enter and try again.',
            type: 'warning',
            icon: 'ti ti-close',
            styling: 'fontawesome'
        });
	}else{
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById('socheckamt').disabled = true;
				document.getElementById('socheckamt').value = "";
			}

		};

		xmlhttp.open("GET", "classes/ajax_res.php?savesocheckamt=" + data, true);
		xmlhttp.send();

	}
}
function socheckamt(vals){
	var res= parseInt(document.getElementById('socheckamt').value) - parseInt(vals)

	if(res < 0){document.getElementById('shortage').innerHTML = -res;document.getElementById('overage').innerHTML=0;}
	if(res > 0){document.getElementById('overage').innerHTML = res;document.getElementById('shortage').innerHTML = 0 }
	if(res == 0){document.getElementById('shortage').innerHTML = 0 ;document.getElementById('overage').innerHTML=0;}
	if(document.getElementById('socheckamt').value == ""){document.getElementById('shortage').innerHTML = 0 ;document.getElementById('overage').innerHTML=0;}
}
function clientsizeparticular(){
	var data;
    if(document.getElementById('yesacc1').checked==true){
		data = "1"
        document.getElementById('clientloopid').innerHTML = "";
        document.getElementById('clientspace').innerHTML = "";
    }
    if(document.getElementById('noacc1').checked==true){
		data = "2"
    }

	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var responseArray = xmlhttp.responseText.split("|<><>|");
			document.getElementById('clientdatatrail').innerHTML = responseArray[0];

			$('#basic').selectpicker({
				"livesearch":true
			});
		}
	};
	xmlhttp.open("GET", "classes/ajax_res.php?clientsizeparticular=" + data, true);
	xmlhttp.send();
}
function savestandingorder(){
	var data = 	document.getElementById('amtclientloopid').innerHTML +"?::?"+
				document.getElementById('clientloopid').innerHTML +"?::?"+
				document.getElementById('datepicker').value +"?::?"+
				document.getElementById('orderaccount').value;


	if(document.getElementById("amtclientloopid").innerHTML == "" || document.getElementById("clientloopid").innerHTML == "" || document.getElementById("datepicker").value == ""){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
	}else{
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			} else {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function () {
				if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
					var responseArray = xmlhttp.responseText.split("|<><>|");
					document.getElementById('noncashtransfertable').innerHTML = responseArray[0];
					document.getElementById('noncashtransferdata').innerHTML = responseArray[1];

					$('#grn').DataTable({
						"bDestroy": true,
						"paging": true,
						"lengthChange": true,
						"searching": true,
						"ordering": true,
						"info": true,
						"autoWidth": true,
						"sDom": 'lfrtip'
					});

					$('.dataTables_filter input').attr('placeholder','Search...');
					$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
					$('.panel-ctrls').append("<i class='separator'></i>");
					$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
					$('.panel-footer').append($(".dataTable+.row"));
					$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
					$('#basic').selectpicker({
						"livesearch":true
					});
					$('#orderaccount').selectpicker({
						"livesearch":true
					});
					$("#datepicker").datepicker({todayHighlight: true});
				}
			};
			xmlhttp.open("GET", "classes/ajax_res.php?savestandingorder=" + data, true);
			xmlhttp.send();
	}


}
function savemultipledeposit(){
	var data;
    if(document.getElementById('yesacc1').checked==true){
		data = "1"+"?::?"+document.getElementById('amtrcvd').value
        document.getElementById('clientloopid').innerHTML = "";
        document.getElementById('clientspace').innerHTML = "";
    }
    if(document.getElementById('noacc1').checked==true){
		data = "2"+"?::?"+document.getElementById('amtrcvd').value+"?::?"+document.getElementById('clientloopid').innerHTML
    }
    if(document.getElementById('dep1').checked==true){
		data = data+"?::?"+"1"
    }
    if(document.getElementById('dep2').checked==true){
		data = data+"?::?"+"0"
    }

	if(document.getElementById("yesacc1").checked == false && document.getElementById("noacc1").checked == false){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
	}else if(document.getElementById("dep1").checked == false && document.getElementById("dep2").checked == false){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
	}else if(document.getElementById("amtrcvd").value == ""){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
	}else if (document.getElementById("noacc1").checked == true && document.getElementById("clientloopid").innerHTML == ""){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
	}else{
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			} else {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function () {
				if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
					var responseArray = xmlhttp.responseText.split("|<><>|");
					document.getElementById('noncashtransfertable').innerHTML = responseArray[0];
					document.getElementById('noncashtransferdata').innerHTML = responseArray[1];

					$('#grn').DataTable({
                                            "bDestroy": true,
                                            "paging": true,
                                            "lengthChange": true,
                                            "searching": true,
                                            "ordering": true,
                                            "info": true,
                                            "autoWidth": true,
                                            "sDom": 'lfrtip'
					});

					$('.dataTables_filter input').attr('placeholder','Search...');
					$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
					$('.panel-ctrls').append("<i class='separator'></i>");
					$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
					$('.panel-footer').append($(".dataTable+.row"));
					$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
					$('#basic').selectpicker({
						"livesearch":true
					});

				}
			};
			xmlhttp.open("GET", "classes/ajax_res.php?savemultipledeposit=" + data, true);
			xmlhttp.send();
	}


}
function save_group(){
    var data;
    data = document.getElementById('groupname').value+"?::?"+document.getElementById('address').value+"?::?"+document.getElementById('clientloopid').innerHTML
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");//console.log(responseArray[0])
            document.getElementById('noncashtransferdata').innerHTML = responseArray[0];

            $('#grn').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
            $('#basic').selectpicker({
                    "livesearch":true
            });
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?save_groupdata=" + data, true);
    xmlhttp.send();

}
function getshareclientstand(){
	var data = document.getElementById('fromclient').value;

	if(document.getElementById('fromclient').value == document.getElementById('toclient').value){
		document.getElementById('fromclient').selectedIndex = 0;
		document.getElementById('amtshare').innerHTML = "0";
		document.getElementById('numshare').innerHTML = "0";
	}else{
		if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var responseArray = xmlhttp.responseText.split("|<><>|");
			document.getElementById('amtshare').innerHTML = responseArray[0];
			document.getElementById('numshare').innerHTML = responseArray[1];

			$('#fromclient').selectpicker({
				"livesearch":true
			});
		}
	};
	xmlhttp.open("GET", "classes/ajax_res.php?getshareclientstand=" + data, true);
	xmlhttp.send();
	}


}
function shareclientverify(){
	if(document.getElementById('fromclient').value == document.getElementById('toclient').value){
		document.getElementById('toclient').selectedIndex = 0;
		new PNotify({
			title: 'Client Already Exist Above, Choose Another!',
			text: 'And try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});

	}
}
function savesharetransferrecords(){
	document.getElementById('subtrac1').disabled = true;
	var data = 	document.getElementById('fromclient').value+"?::?"+
				document.getElementById('toclient').value+"?::?"+
				document.getElementById('amtrcvd').value

	if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");


				if(responseArray[0] == "1"){
					document.getElementById('subtrac1').disabled = false;
					    new PNotify({
							title: 'INSUFFIENT AMOUNT AVAILABLE, INCREASE IT FIRST!',
							text: 'And try again.',
							type: 'warning',
							icon: 'ti ti-close',
							styling: 'fontawesome'
						});
				}else{

					if(document.getElementById('fromclient').value=="" || document.getElementById('toclient').value=="" || document.getElementById('amtrcvd').value==""){
						new PNotify({
							title: 'MISSING INPUT!',
							text: 'Enter and try again.',
							type: 'warning',
							icon: 'ti ti-close',
							styling: 'fontawesome'
						});
					}else{
						if (window.XMLHttpRequest) {
							xmlhttp = new XMLHttpRequest();
						} else {
							xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
						}
						xmlhttp.onreadystatechange = function () {
							if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
								var responseArray = xmlhttp.responseText.split("|<><>|");

								document.getElementById("noncashtransferdata").innerHTML = responseArray[0];
								document.getElementById("noncashtransfertable").innerHTML = responseArray[1];

							$('#grn').DataTable({
								"bDestroy": true,
								"paging": true,
								"lengthChange": true,
								"searching": true,
								"ordering": true,
								"info": true,
								"autoWidth": true,
								"sDom": 'lfrtip'
							});

							$('.dataTables_filter input').attr('placeholder','Search...');
							$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
							$('.panel-ctrls').append("<i class='separator'></i>");
							$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
							$('.panel-footer').append($(".dataTable+.row"));
							$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
							$('#fromclient').selectpicker({
								"livesearch":true
							});
							$('#toclient').selectpicker({
								"livesearch":true
							});
							}
						};
						xmlhttp.open("GET", "classes/ajax_res.php?savesharetransferrecords=" + data, true);
						xmlhttp.send();
					}
				}
			}

		};
		xmlhttp.open("GET", "classes/ajax_res.php?sharecashcheck=" + data, true);
		xmlhttp.send();
}
function canceltransfershare(){

    var data = "1";
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('noncashtransferdata').innerHTML = responseArray[0];

			$('#fromclient').selectpicker({
				"livesearch":true
			});
			$('#toclient').selectpicker({
				"livesearch":true
			});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?canceltransfershare=" + data, true);
    xmlhttp.send();
}
function awarddividends(){

    var data = "1";
	document.getElementById('subbut').disabled = true;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('noncashtransfertable').innerHTML = responseArray[0];
			document.getElementById('subbut').disabled = false;
			$('#grn').DataTable({
				"bDestroy": true,
				"paging": true,
				"lengthChange": true,
				"searching": true,
				"ordering": true,
				"info": true,
				"autoWidth": true,
				"sDom": 'lfrtip'
			});

			$('.dataTables_filter input').attr('placeholder','Search...');
			$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
			$('.panel-ctrls').append("<i class='separator'></i>");
			$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
			$('.panel-footer').append($(".dataTable+.row"));
			$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?awarddividends=" + data, true);
    xmlhttp.send();
}
function checkfixeddeposit(ab){

	if(document.getElementById('savetypeint'+ab).value == "5"){
		document.getElementById('fixdepositspace'+ab).innerHTML = '' +
		'		<label class="labelcolor">Start Date</label> ' +
		'		<input onclick="" id="datepicker3" type="text" class="form-control" placeholder="Enter Start Date"><br>' +
		'		<label class="labelcolor">End Date</label>' +
		'		<input onclick="" id="datepicker4" type="text" class="form-control" placeholder="Enter End Date"><br>';
	}else{
		document.getElementById('fixdepositspace'+ab).innerHTML = "";
	}
	$("#datepicker3").datepicker({todayHighlight: true});
	$("#datepicker4").datepicker({todayHighlight: true});
}
function overdraftstatus(ab){

	if(document.getElementById('savetypeint'+ab).value == "1"){
		document.getElementById('overdraftspace'+ab).innerHTML = '' +
		'		<label class="labelcolor">OverDraft Limit Amount</label>' +
		'		<input id="overdraftlimit'+ab+'" type="text" class="form-control" placeholder="Enter OverDraft Limit Amount"><br>';
	}else{
		document.getElementById('overdraftspace'+ab).innerHTML = "";
	}
}
function setsavingaccount(ab,vals){
	var data ;
	if(document.getElementById('savetypeint'+ab).value == "5"){
		data = 	document.getElementById('savetypeint'+ab).value+"?::?"+
				vals+"?::?"+document.getElementById('datepicker3').value+"?::?"+
				document.getElementById('datepicker4').value;
	}else{
		data = document.getElementById('savetypeint'+ab).value+"?::?"+vals;
	}

	if(document.getElementById('savetypeint'+ab).value == ""){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
	}else{

			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			} else {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function () {
				if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
					var responseArray = xmlhttp.responseText.split("|<><>|");
					document.getElementById('noncashtransfertable').innerHTML = responseArray[0];
					$('#grn').DataTable({
						"bDestroy": true,
						"paging": true,
						"lengthChange": true,
						"searching": true,
						"ordering": true,
						"info": true,
						"autoWidth": true,
						"sDom": 'lfrtip'
					});

					$('.dataTables_filter input').attr('placeholder','Search...');
					$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
					$('.panel-ctrls').append("<i class='separator'></i>");
					$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
					$('.panel-footer').append($(".dataTable+.row"));
					$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
				}
			};
			xmlhttp.open("GET", "classes/ajax_res.php?setsavingaccount=" + data, true);
			xmlhttp.send();
	}

}
function setoverdraft(ab,vals){
	var data ;
	if(document.getElementById('savetypeint'+ab).value == "1"){
		data = document.getElementById('overdraftlimit'+ab).value+"?::?"+vals+"?::?"+"1";
	}else{
		data = "0"+"?::?"+vals+"?::?"+"0";
	}

	if(document.getElementById('savetypeint'+ab).value == ""){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
	}else{

			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			} else {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function () {
				if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
					var responseArray = xmlhttp.responseText.split("|<><>|");
					document.getElementById('noncashtransfertable').innerHTML = responseArray[0];
					$('#grn').DataTable({
						"bDestroy": true,
						"paging": true,
						"lengthChange": true,
						"searching": true,
						"ordering": true,
						"info": true,
						"autoWidth": true,
						"sDom": 'lfrtip'
					});

					$('.dataTables_filter input').attr('placeholder','Search...');
					$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
					$('.panel-ctrls').append("<i class='separator'></i>");
					$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
					$('.panel-footer').append($(".dataTable+.row"));
					$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
				}
			};
			xmlhttp.open("GET", "classes/ajax_res.php?setoverdraft=" + data, true);
			xmlhttp.send();
	}

}
function writeoffloan(data){
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById("writeofftable").innerHTML = responseArray[0];
				document.getElementById("repaywriteoff").innerHTML = responseArray[1];

				$('#grn').DataTable({
					"bDestroy": true,
					"paging": true,
					"lengthChange": true,
					"searching": true,
					"ordering": true,
					"info": true,
					"autoWidth": true,
					"sDom": 'lfrtip'
				});

				$('#grat1').DataTable({
					"bDestroy": true,
					"paging": true,
					"lengthChange": true,
					"searching": true,
					"ordering": true,
					"info": true,
					"autoWidth": true,
					"sDom": 'lfrtip'
				});

				$('.dataTables_filter input').attr('placeholder','Search...');
				$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
				$('.panel-ctrls').append("<i class='separator'></i>");
				$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
				$('.panel-footer').append($(".dataTable+.row"));
				$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?writeoffloan=" + data, true);
		xmlhttp.send();
}
function repaywriteoffloan(val,val1,val2,val3){
	    var data = val +"?::?"+ document.getElementById('amtrepay'+val1).value+"?::?"+val2+"?::?"+val3
		if(document.getElementById('amtrepay'+val1).value == ""){
			new PNotify({
				title: 'MISSING INPUT!',
				text: 'Enter and try again.',
				type: 'warning',
				icon: 'ti ti-close',
				styling: 'fontawesome'
			});
		}else if(parseInt(document.getElementById('amtrepay'+val1).value) > parseInt(val2)){
			new PNotify({
				title: 'INCORRECT INPUT!',
				text: 'Enter Amount Within Range and try again.',
				type: 'warning',
				icon: 'ti ti-close',
				styling: 'fontawesome'
			});
			document.getElementById('amtrepay'+val1).value = ""
		}else{
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			} else {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function () {
				if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
					var responseArray = xmlhttp.responseText.split("|<><>|");
					document.getElementById("repaywriteoff").innerHTML = responseArray[0];

					$('#grat1').DataTable({
						"bDestroy": true,
						"paging": true,
						"lengthChange": true,
						"searching": true,
						"ordering": true,
						"info": true,
						"autoWidth": true,
						"sDom": 'lfrtip'
					});

					$('.dataTables_filter input').attr('placeholder','Search...');
					$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
					$('.panel-ctrls').append("<i class='separator'></i>");
					$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
					$('.panel-footer').append($(".dataTable+.row"));
					$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
				}
			};
			xmlhttp.open("GET", "classes/ajax_res.php?repaywriteoffloan=" + data, true);
			xmlhttp.send();
		}
}
function setschoolfees(){
	$("#schoolfeesmodal").modal("show");
}
function attachschfeesdetails(){
	$("#schoolfeesmodal").modal("show");
}

function setdeptype(){
	if(document.getElementById('depreciationtype').value == "1"){
		document.getElementById('assetaccountpercentage').disabled = true
	}else{
		document.getElementById('assetaccountpercentage').disabled = false
	}
}
function findassetpayable(){
	if(document.getElementById('assestcheck').checked == true){
		if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById("findassetpayable").innerHTML = responseArray[0];

				$('#assetaccountck').selectpicker({
					"livesearch":true
				});
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?findassetpayable=" + "1", true);
		xmlhttp.send();
	}else{
		document.getElementById('findassetpayable').innerHTML = "";
	}
}
function depreciationcreteria(){
	if(document.getElementById('yesacc').checked==true){
		document.getElementById('workinglife').disabled = false;
	}else{
		document.getElementById('workinglife').disabled = true;
	}
}
function assetschedule(data){
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var responseArray = xmlhttp.responseText.split("|<><>|");
			document.getElementById('assetschedule').innerHTML = responseArray[0];
		}
	};
	xmlhttp.open("GET", "classes/ajax_res.php?assetschedule=" + data, true);
	xmlhttp.send();
}
function GetAssetTracs(data){
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var responseArray = xmlhttp.responseText.split("|<><>|");
			document.getElementById('assetdata').innerHTML = responseArray[0];
			$('#assetaccountid').selectpicker({
				"livesearch":true
			});
			$("#datepicker1").datepicker({todayHighlight: true});
		}
	};
	xmlhttp.open("GET", "classes/ajax_res.php?getassettracs=" + data, true);
	xmlhttp.send();
}
function DeleteAssetTracs(data){
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	} else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
			var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById('assetdata').innerHTML = responseArray[0];
				document.getElementById('assettable').innerHTML = responseArray[1];
				$('#grn').DataTable({
					"bDestroy": true,
					"paging": true,
					"lengthChange": true,
					"searching": true,
					"ordering": true,
					"info": true,
					"autoWidth": true,
					"sDom": 'lfrtip'
				});

				$('.dataTables_filter input').attr('placeholder','Search...');
				$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
				$('.panel-ctrls').append("<i class='separator'></i>");
				$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
				$('.panel-footer').append($(".dataTable+.row"));
				$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
				$('#assetaccountid').selectpicker({
					"livesearch":true
				});
				$("#datepicker1").datepicker({todayHighlight: true});
		}
	};
	xmlhttp.open("GET", "classes/ajax_res.php?deleteassettracs=" + data, true);
	xmlhttp.send();
}


function GetEXPReport(){

	document.getElementById("withdrawdeposittreport").innerHTML = ''+
												'<div class="row" style="margin-bottom: 200px">'+
													'<span style="font-size:80px;"><i style="left:6em;top:2.5em" class="fa-li fa fa-spinner fa-spin"></i></span>'+
													''+
												'</div>';
    var data = document.getElementById("report1").value+"?::?"+document.getElementById("yearid1").value+"?::?"+document.getElementById("monthid1").value;

	if(document.getElementById("report1").value == ""){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
		document.getElementById("withdrawdeposittreport").innerHTML = "";
		document.getElementById("withdrawdeposittreport1").innerHTML = "";
	}else{
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById("withdrawdeposittreport").innerHTML = responseArray[0];
				document.getElementById("withdrawdeposittreport1").innerHTML = responseArray[0];

				$('#oppsd').DataTable({
					"bDestroy": true,
					"paging": true,
					"lengthChange": true,
					"searching": true,
					"ordering": true,
					"info": true,
					"autoWidth": true,
					"sDom": 'lfrtip'
				});

				$('.dataTables_filter input').attr('placeholder','Search...');
				$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
				$('.panel-ctrls').append("<i class='separator'></i>");
				$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
				$('.panel-footer').append($(".dataTable+.row"));
				$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?expensereports=" + data, true);
		xmlhttp.send();
	}
}
function GetSTATReport(){

	document.getElementById("withdrawdeposittreport").innerHTML = ''+
												'<div class="row" style="margin-bottom: 200px">'+
													'<span style="font-size:80px;"><i style="left:6em;top:2.5em" class="fa-li fa fa-spinner fa-spin"></i></span>'+
													''+
												'</div>';
    var data = document.getElementById("report1").value+"?::?"+document.getElementById("yearid1").value;

	if(document.getElementById("report1").value == ""){
		new PNotify({
			title: 'MISSING INPUT!',
			text: 'Enter and try again.',
			type: 'warning',
			icon: 'ti ti-close',
			styling: 'fontawesome'
		});
		document.getElementById("withdrawdeposittreport").innerHTML = "";
		document.getElementById("withdrawdeposittreport1").innerHTML = "";
	}else{
		if (window.XMLHttpRequest) {
			xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById("withdrawdeposittreport").innerHTML = responseArray[0];
				document.getElementById("withdrawdeposittreport1").innerHTML = responseArray[0];

				$('#oppsd').DataTable({
					"bDestroy": true,
					"paging": true,
					"lengthChange": true,
					"searching": true,
					"ordering": true,
					"info": true,
					"autoWidth": true,
					"sDom": 'lfrtip'
				});

				$('.dataTables_filter input').attr('placeholder','Search...');
				$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
				$('.panel-ctrls').append("<i class='separator'></i>");
				$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
				$('.panel-footer').append($(".dataTable+.row"));
				$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?inoutstatement=" + data, true);
		xmlhttp.send();
	}
}
function printBUDGETReport(){
	var data = "BUDGET REPORT"
	if(document.getElementById("budgetviewdisplay").innerHTML ==""){ }else{PrintElem('budgetviewdisplay',data+"|<><>|"+document.getElementById("budgetsearch1").options[document.getElementById("budgetsearch1").selectedIndex].text);}

}
function printCASHFLOWReport(){
	var data = document.getElementById("yearid1").value;
	if(document.getElementById("withdrawdeposittreport1").innerHTML ==""){ }else{PrintElem('withdrawdeposittreport1',document.getElementById("report1").options[document.getElementById("report1").selectedIndex].text+"|<><>|"+data);}

}
function generatebudget() {
        var i;
        var month = document.getElementById('monthdropdown').value;
        var year = document.getElementById('yeardropdown').value;

		var catname=document.getElementById("catname").value;
		var item=document.getElementById("item").value;
		var qty=document.getElementById("qty").value;
		var uom=document.getElementById("uom").value;
		var unit=document.getElementById("unit").value;
		var total=document.getElementById("total").value;

		var table=document.getElementById("exptab");
		var table_len=(table.rows.length)-2;

		for(i = 1; i <= table_len; i++){
		   catname = catname +":??:"+  document.getElementById("catname"+i).value;
		   item = item +":??:"+  document.getElementById("item"+i).value;
		   qty = qty +":??:"+  document.getElementById("qty"+i).value;
		   uom = uom +":??:"+  document.getElementById("uom"+i).value;
		   unit = unit +":??:"+  document.getElementById("unit"+i).value;
		   total = total +":??:"+  document.getElementById("total"+i).value;
		}

	    catname = catname +":??:"+  document.getElementById("catname").value;
	    item = item +":??:"+  document.getElementById("item").value;
	    qty = qty +":??:"+  document.getElementById("qty").value;
	    uom = uom +":??:"+  document.getElementById("uom").value;
	    unit = unit +":??:"+  document.getElementById("unit").value;
	    total = total +":??:"+  document.getElementById("total").value;

	    var data = item+"|<>|"+catname+"|<>|"+qty+"|<>|"+uom+"|<>|"+unit+"|<>|"+total+"|<>|"+month+"|<>|"+year
		if(document.getElementById("catname").value==""){
			new PNotify({
				title: 'MISSING INPUT!',
				text: 'Select first and try again.',
				type: 'warning',
				icon: 'ti ti-close',
				styling: 'fontawesome'
			});
		}else{
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			} else {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					var responseArray = xmlhttp.responseText.split("|<><>|");
					document.getElementById("feed").innerHTML = responseArray[0];
					document.getElementById("areasearch").innerHTML = responseArray[1];
					document.getElementById("areasearch1").innerHTML = responseArray[2];
					$('#budgetsearch').selectpicker({
						"livesearch":true
					});
					$('#budgetsearch1').selectpicker({
						"livesearch":true
					});
				}
			};
			xmlhttp.open("GET","classes/ajax_res.php?budgetitem="+data,true);
			xmlhttp.send();
		}

}
function generatebudget1() {
        var i;
        var month = document.getElementById('monthdropdown1').value;
        var year = document.getElementById('yeardropdown1').value;

		var catname=document.getElementById("inccatname").value;
		var item=document.getElementById("incitem").value;
		var total=document.getElementById("inctotal").value;

		var table=document.getElementById("exptab1");
		var table_len=(table.rows.length)-2;

		for(i = 1; i <= table_len; i++){
			catname = catname +":??:"+  document.getElementById("inccatname"+i).value;
			item = item +":??:"+  document.getElementById("incitem"+i).value;
			total = total +":??:"+  document.getElementById("inctotal"+i).value;
		}

	    catname = catname +":??:"+  document.getElementById("inccatname").value;
	    item = item +":??:"+  document.getElementById("incitem").value;
	    total = total +":??:"+  document.getElementById("inctotal").value;

	    var data = item+"|<>|"+catname+"|<>|"+total+"|<>|"+month+"|<>|"+year
		if(document.getElementById("inccatname").value==""){
			new PNotify({
				title: 'MISSING INPUT!',
				text: 'Select first and try again.',
				type: 'warning',
				icon: 'ti ti-close',
				styling: 'fontawesome'
			});
		}else{
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			} else {
				xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange = function() {
				if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					var responseArray = xmlhttp.responseText.split("|<><>|");
					document.getElementById("feed1").innerHTML = responseArray[0];
					document.getElementById("areasearch").innerHTML = responseArray[1];
					document.getElementById("areasearch1").innerHTML = responseArray[2];
					$('#budgetsearch').selectpicker({
						"livesearch":true
					});
					$('#budgetsearch1').selectpicker({
						"livesearch":true
					});
				}
			};
			xmlhttp.open("GET","classes/ajax_res.php?budgetitem1="+data,true);
			xmlhttp.send();
		}

}

function add_row(){
	var catname=document.getElementById("inccatname").options[document.getElementById("inccatname").selectedIndex].text;
	var catname1=document.getElementById("inccatname").value;
	var item=document.getElementById("incitem").value;
	var total=document.getElementById("inctotal").value;
	var table=document.getElementById("exptab1");
	var table_len=(table.rows.length)-1;
	if(document.getElementById("inccatname").value==""){
		new PNotify({
            title: 'MISSING INPUT!',
            text: 'Select first and try again.',
            type: 'warning',
            icon: 'ti ti-close',
            styling: 'fontawesome'
        });
	}else{
		var row = table.insertRow(table_len).outerHTML="<tr id='row"+table_len+"'>\n\
			<td><select class='form-control'  id='inccatname"+table_len+"'><option value='"+catname1+"'>"+catname+"</option></select></td>\n\
			<td><input id='incitem"+table_len+"' class='form-control' value="+item+"></td>\n\
			<td><input id='inctotal"+table_len+"' class='form-control' value="+total+"></td>\n\
			<td><center><button onclick='delete_row("+table_len+")' class='btn btn-danger btn-social btn-sm'><i class='ti ti-close'></i></button></center></td></tr>";

			document.getElementById("inccatname").selectedIndex = "0";
			document.getElementById("incitem").value="";
			document.getElementById("inctotal").value="";
	}
}
function add_row1(){
	var catname=document.getElementById("catname").options[document.getElementById("catname").selectedIndex ].text;
	var catname1=document.getElementById("catname").value;
	var item=document.getElementById("item").value;
	var qty=document.getElementById("qty").value;
	var uom=document.getElementById("uom").value;
	var unit=document.getElementById("unit").value;
	var total=document.getElementById("total").value;
	var table=document.getElementById("exptab");
	var table_len=(table.rows.length)-1;
	if(document.getElementById("catname").value==""){
		new PNotify({
            title: 'MISSING INPUT!',
            text: 'Select first and try again.',
            type: 'warning',
            icon: 'ti ti-close',
            styling: 'fontawesome'
        });
	}else{
		var row = table.insertRow(table_len).outerHTML="<tr id='row"+table_len+"'>\n\
			<td><select class='form-control'  id='catname"+table_len+"'><option value='"+catname1+"'>"+catname+"</option></select></td>\n\
			<td><input id='item"+table_len+"' class='form-control' value="+item+"></td>\n\
			<td><input id='qty"+table_len+"' class='form-control' value='"+qty+"' onkeyup='gettotals("+table_len+")'></td>\n\
			<td><input id='uom"+table_len+"' class='form-control' value="+uom+"></td>\n\
			<td><input id='unit"+table_len+"' class='form-control' value='"+unit+"' onkeyup='gettotals("+table_len+")'></td>\n\
			<td><input id='total"+table_len+"' class='form-control' value="+total+"></td>\n\
			<td><center><button onclick='delete_row1("+table_len+")' class='btn btn-danger btn-social btn-sm'><i class='ti ti-close'></i></button></center></td></tr>";

			document.getElementById("catname").selectedIndex = "0";
			document.getElementById("item").value="";
			document.getElementById("qty").value="";
			document.getElementById("uom").value="";
			document.getElementById("unit").value="";
			document.getElementById("total").value="";
	}
}
function delete_row(no){
	var table=document.getElementById("exptab1");
	var table_len=(table.rows.length)-2;
	document.getElementById("row"+no+"").outerHTML="";
}
function delete_row1(no){
	var table=document.getElementById("exptab");
	var table_len=(table.rows.length)-2;
	document.getElementById("row"+no+"").outerHTML="";
}
function returncat(catname,catname1) {
	var table=document.getElementById("exptab");
	var table_len=(table.rows.length)-2;
       if (window.XMLHttpRequest) {xmlhttp = new XMLHttpRequest();} else {xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");}
            xmlhttp.onreadystatechange = function() {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
					document.getElementById("catname"+table_len).innerHTML = xmlhttp.responseText;
				}
            };
            xmlhttp.open("GET","resp.php?getitems="+catname+'?::?'+catname1,true);
            xmlhttp.send();
}
function gettotals(ids){
	var qty=parseFloat(document.getElementById("qty"+ids).value);
	var unit=parseFloat(document.getElementById("unit"+ids).value);
	var tot
	if(document.getElementById("qty"+ids).value===""){tot=1*unit}else{tot=qty*unit}
	if(document.getElementById("unit"+ids).value===""){tot=1*qty}else{tot=qty*unit}
	document.getElementById("total"+ids).value = tot
}
function gettotals1(){
	var qty=parseFloat(document.getElementById("qty").value);
	var unit=parseFloat(document.getElementById("unit").value);
	var tot
	if(document.getElementById("qty").value===""){tot=1*unit}else{tot=qty*unit}
	if(document.getElementById("unit").value===""){tot=1*qty}else{tot=qty*unit}
	document.getElementById("total").value = tot
}
function gettotals2(){
	var qty=parseFloat(document.getElementById("qty").value);
	var unit=parseFloat(document.getElementById("unit").value);
	var tot
	if(document.getElementById("qty").value===""){tot=1*unit}else{tot=qty*unit}
	if(document.getElementById("unit").value===""){tot=1*qty}else{tot=qty*unit}
	document.getElementById("total").value = tot
}

function getbudgetchange(){
	 var data = document.getElementById("budgetsearch").value;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('budgeteditdata').innerHTML = responseArray[0];
            document.getElementById('budgeteditarea').innerHTML = "";
            // $('#incomeaccount').selectpicker({
                // "livesearch":true
            // });
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?getbudgetview=" + data, true);
    xmlhttp.send();
}
function getbudgetchange1(){
	 var data = document.getElementById("budgetsearch1").value;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('budgetviewdisplay').innerHTML = responseArray[0];
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?budgetviewdisplay=" + data, true);
    xmlhttp.send();
}
function getbudgetchange2(){
	 var data = document.getElementById("budgetsearch2").value;
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('budgetperformancew').innerHTML = responseArray[0];
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?budgetperformance=" + data, true);
    xmlhttp.send();
}
function getbudgeteditdata(data){
	    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById('budgeteditarea').innerHTML = responseArray[0];
				// $('#incomeaccount').selectpicker({
					// "livesearch":true
				// });
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?getbudgeteditdata=" + data, true);
		xmlhttp.send();
}
function SaveBudgetEditData(data,ids){

		var datas = data +"?::?"+ ids +"?::?"+ document.getElementById('items').value +"?::?"+ document.getElementById('qtys').value +"?::?"+
					document.getElementById('uoms').value +"?::?"+ document.getElementById('unitcosts').value +"?::?"+ document.getElementById('ttcosts').value;
		if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById('budgeteditarea').innerHTML = "";
				document.getElementById('budgeteditdata').innerHTML = responseArray[0];
				// $('#incomeaccount').selectpicker({
					// "livesearch":true
				// });
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?savebudgetedit=" + datas, true);
		xmlhttp.send();
}
function SaveBudgetEditData1(data,ids){

		var datas = data +"?::?"+ ids +"?::?"+ document.getElementById('items').value +"?::?"+ document.getElementById('ttcosts').value;

		if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById('budgeteditarea').innerHTML = "";
				document.getElementById('budgeteditdata').innerHTML = responseArray[0];
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?budgetedit1=" + datas, true);
		xmlhttp.send();
}

function uploadexcel(){
	document.getElementById("uploadexcelclient").disabled = true;
		document.getElementById("exceldataarea1").innerHTML = '<br>'+
			'<div class="row" style="margin-bottom: 80px">'+
				'<span style="font-size:80px;"><i style="left:1em;top:1.5em" class="fa-li fa fa-spinner fa-spin"></i></span>'+
				''+
			'</div>';

		e.preventDefault();
		$("#message").empty();
		$('#loading').show();
		$.ajax({
			url: "classes/excel/excelmemberimport.php", // Url to which the request is send
			type: "POST",             // Type of request to be send, called as method
			data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false,       // The content type used when sending data to the server.
			cache: false,             // To unable request pages to be cached
			processData:false,        // To send DOMDocument or non processed data file it is set to false
			success: function(data)   // A function to be called if request succeeds
			{
				var responseArray = data.split("|<><>|");
				new PNotify({
					title: 'MEMBER IMPORTATION FEEDBACK',
					text: responseArray[0],
					type: 'success',
					icon: 'ti ti-close',
					styling: 'fontawesome'
				});
				document.getElementById("uploadexcelclient").disabled = false;
				document.getElementById('exceldataarea').innerHTML = responseArray[1];
				document.getElementById("exceldataarea1").innerHTML = '';
				$('#loading').hide();
				$("#message").html(data);
			}
		});
}
function editexpenses(data){
		if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById('expensesdata').innerHTML = responseArray[0];
				$('#codereturn').selectpicker({
					"livesearch":true
				});
				$("#datepicker1").datepicker({todayHighlight: true});
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?editexpensedata=" + data, true);
		xmlhttp.send();
}
function editincome(data){
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById('incomedata').innerHTML = responseArray[0];
				$('#incomeaccount').selectpicker({
					"livesearch":true
				});
				$("#datepicker1").datepicker({todayHighlight: true});
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?editincomedata=" + data, true);
		xmlhttp.send();
}
function deleteincome(data){
		if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById('incometable').innerHTML = responseArray[0];
					$('#grn').DataTable({
						"bDestroy": true,
						"paging": true,
						"lengthChange": true,
						"searching": true,
						"ordering": true,
						"info": true,
						"autoWidth": true,
						"sDom": 'lfrtip'
					});

					$('.dataTables_filter input').attr('placeholder','Search...');
					$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
					$('.panel-ctrls').append("<i class='separator'></i>");
					$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
					$('.panel-footer').append($(".dataTable+.row"));
					$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?deleteincomeid=" + data, true);
		xmlhttp.send();
}
function deleteexpenses(data){
		if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
		} else {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
				var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById('expensetable').innerHTML = responseArray[0];
					$('#grn').DataTable({
						"bDestroy": true,
						"paging": true,
						"lengthChange": true,
						"searching": true,
						"ordering": true,
						"info": true,
						"autoWidth": true,
						"sDom": 'lfrtip'
					});

					$('.dataTables_filter input').attr('placeholder','Search...');
					$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
					$('.panel-ctrls').append("<i class='separator'></i>");
					$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
					$('.panel-footer').append($(".dataTable+.row"));
					$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
			}
		};
		xmlhttp.open("GET", "classes/ajax_res.php?deleteexpenseid=" + data, true);
		xmlhttp.send();
}

function SaveStock() {
    var vals =  document.getElementById('stocktype').value+"?::?"+
                document.getElementById('productname').value+"?::?"+
                document.getElementById('quantity').value+"?::?"+
                document.getElementById('amount').value+"?::?"+
                document.getElementById('datepicker').value+"?::?"+
                document.getElementById('stockeditcode').innerHTML;
 

    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('returnedbanktracs').innerHTML = responseArray[0];
            document.getElementById('returnedbanktracstable').innerHTML = responseArray[1];
            document.getElementById('bankaccountbalances').innerHTML = responseArray[2];

            $('#grn').DataTable({
                "bDestroy": true,
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "sDom": 'lfrtip'
            });

            $('.dataTables_filter input').attr('placeholder','Search...');
            $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
            $('.panel-ctrls').append("<i class='separator'></i>");
            $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
            $('.panel-footer').append($(".dataTable+.row"));
            $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");
            
            $("#datepicker").datepicker({todayHighlight: true});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?savestocking=" + vals, true);
    xmlhttp.send();
}
function ClearSTOCK() {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('returnedbanktracs').innerHTML = responseArray[0];
            $("#datepicker").datepicker({todayHighlight: true});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?clearstock=" +"1", true);
    xmlhttp.send();

}
function GetStocks(res) {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            var responseArray = xmlhttp.responseText.split("|<><>|");
            document.getElementById('returnedbanktracs').innerHTML = responseArray[0];
            $('#bankaccountcode').selectpicker({
                "livesearch":true
            });
            $("#datepicker").datepicker({todayHighlight: true});
        }
    };
    xmlhttp.open("GET", "classes/ajax_res.php?getstockid=" + res, true);
    xmlhttp.send();

}