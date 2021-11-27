/**
 * Created by jammieluvie on 1/13/17.
 */

$(document).ready(function (e) {
    $("#uploadimage").on('submit',(function(e) {
            e.preventDefault();
            $("#message").empty();
            $('#loading').show();
            $.ajax({
                url: "classes/ajax_php_file.php", // Url to which the request is send
                type: "POST",             // Type of request to be send, called as method
                data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false,       // The content type used when sending data to the server.
                cache: false,             // To unable request pages to be cached
                processData:false,        // To send DOMDocument or non processed data file it is set to false
                success: function(data) {  // A function to be called if request succeeds
                
                    // new PNotify({
                            // title: 'MISSING INPUT!',
                            // text: 'Enter and try again.'+data,
                            // type: 'warning',
                            // icon: 'ti ti-close',
                            // styling: 'fontawesome'
                    // });
                    saveaccount(data);
                    $('#loading').hide();
                    $("#message").html(data);
                }
            });
    }));
    $("#uploadexcelform").on('submit',(function(e) {
            document.getElementById("exceldataarea1").innerHTML = '<br>'+
                '<div class="row" style="margin-bottom: 80px">'+
                        '<span style="font-size:80px;"><i style="left:1em;top:1em" class="fa-li fa fa-spinner fa-spin"></i></span>'+
                        ''+
                '</div><br>uploading process please wait...';
            e.preventDefault();
            $("#message").empty();
            $('#loading').show();
            $.ajax({
                    url: "classes/excel/excelssl.php", // Url to which the request is send
                    type: "POST",             // Type of request to be send, called as method
                    data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                    contentType: false,       // The content type used when sending data to the server.
                    cache: false,             // To unable request pages to be cached
                    processData:false,        // To send DOMDocument or non processed data file it is set to false
                    success: function(data)   // A function to be called if request succeeds
                    {
                            var responseArray = data.split("|<><>|");
                            new PNotify({
                                    title: 'IMPORTATION FEEDBACK',
                                    text: responseArray[0],
                                    type: 'success',
                                    icon: 'ti ti-close',
                                    styling: 'fontawesome'
                            });
                            document.getElementById('exceldataarea').innerHTML = responseArray[1];
                            document.getElementById("exceldataarea1").innerHTML = '';
                            // $("#excelsheetupload").modal("hide"); 
                            $('#loading').hide();
                            $("#message").html(data);
                    }
            });
    }));
    $("#uploadmemberexcel").on('submit',(function(e) {
		document.getElementById("uploadexcelclient").disabled = true;
		document.getElementById("exceldataarea1").innerHTML = '<br>'+
                    '<div class="row" style="margin-bottom: 80px">'+
                            '<span style="font-size:80px;"><i style="left:1em;top:1em" class="fa-li fa fa-spinner fa-spin"></i></span>'+
                            ''+
                    '</div><br>uploading process please wait...';
		
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
	}));

});
 
function applicattype() {
    if(document.getElementById("getacctype").selectedIndex == 1 || document.getElementById("getacctype").selectedIndex == 0 || document.getElementById("getacctype").selectedIndex == 4){
        document.getElementById("applicantdata").innerHTML = '' +
            '<div id="applicantdata"><div hidden id="editindacc"></div>' +
            '<div class="col-md-12"><center><b style="color: #3C8DBC">Applicant Details</b><br><br></center></div>' +
            '<div class="col-md-6">' +
            '<label class="labelcolor">First Name</label>' +
            '<input id="fname" type="text" class="form-control">' +
            '<label class="labelcolor">Last Name</label>' +
            '<input id="lname" type="text" class="form-control">' +
            '<label class="labelcolor">ID/Passport No.</label>' +
            '<input id="idnum" type="text" class="form-control">' +
            '<label class="labelcolor">Nationality</label>' +
            '<input id="nationality" type="text" class="form-control">' +
            '<label class="labelcolor">Occupation</label>' +
            '<input id="occupation" type="text" class="form-control">' +
            '<label class="labelcolor">Mobile Number</label>' +
            '<input id="mobilenumber" type="text" class="form-control">' +
            '<label class="labelcolor">Sub County</label>' +
            '<input id="subcounty" type="text" class="form-control">' +
            '</div>' +
            '<div class="col-md-6">' +
            '<label class="labelcolor">Middle Name</label>' +
            '<input id="mname" type="text" class="form-control">' +
            '<label class="labelcolor">Sex</label>' +
            '<select id="gender" class="form-control">' +
            '<option value="">select gender</option>' +
            '<option value="Female">Female</option>' +
            '<option value="Male">Male</option>' +
			'<option value="Female Youth">Female Youth</option>' +
			'<option value="Male Youth">Male Youth</option>' +
            '<option value="Other">other</option>' +
            '</select>' +
            '<label class="labelcolor">Date of Birth</label>' +
            '<input id="dateofbirth" type="text" class="form-control">' +
            '<label  id="maritalstatus" class="labelcolor">Marital Status</label>' +
            '<select class="form-control">' +
            '<option value="">select status</option>' +
            '<option value="Single">Single</option>' +
            '<option value="Married">Married</option>' +
            '<option value="Other">other</option>' +
            '</select>' +
            '<label class="labelcolor">Employer</label>' +
            '<input id="employer" type="text" class="form-control">' +
            '<label class="labelcolor">Physical Address/Village</label>' +
            '<select id="physicaladdress" class="form-control">' +
            '<option value="">select Address</option>' +
            '</select>' +
            '<label class="labelcolor">District</label>' +
            '<input id="district" type="text" class="form-control"><br><br>' +
            '</div>' +
            '<div class="col-md-12"><center><b style="color: #3C8DBC">Next of Kin</b><br><br></center></div>' +
            '<div class="col-md-6">' +
            '<label class="labelcolor">Names</label>' +
            '<input id="kname" type="text" class="form-control">' +
            '<label class="labelcolor">Address</label>' +
            '<input id="kaddress" type="text" class="form-control">' +
            '<label class="labelcolor">Security Question</label>' +
            '<input id="security" type="text" class="form-control">' +
            '</div>' +
            '<div class="col-md-6">' +
            '<label class="labelcolor">Relationship</label>' +
            '<input id="krelationship" type="text" class="form-control">' +
            '<label class="labelcolor">Contact Detail</label>' +
            '<input id="contactdetail" type="text" class="form-control">' +
            '<label class="labelcolor">Answer</label>' +
            '<input id="sanswer" type="text" class="form-control"><br><br>' +
            '</div>' +
			'<div class="col-md-8">' +
			'	<label class="labelcolor">Browse to Add Applicant Photo</label>' +
			'	<input class="" type="file" name="file1" id="file" onchange="readURL(this);" />' +
			'</div>' +
			'<div class="col-md-4" id="imageplace">' +
			'	<img id="blah" src="images/default.png" class="img-rounded" style="width; 100px;height:100px;image-orientation:from-image" />' +
			'	</b><br><br>' +
			'</div>' +
            '<div class="col-md-12"><center><b style="color: #3C8DBC">Account Details</b><br><br></center></div>' +
            '<div class="col-md-6">' +
            '<label class="labelcolor">Account Name</label>' +
            '<input id="accountname" type="text" class="form-control">' +
            '</div>' +
            '<div class="col-md-6">' +
            '<label class="labelcolor">Account Number</label>' +
            '<input id="accountnumber" type="text" class="form-control"><br><br>' +
            '</div>' +
            '</div>';
    }
    if(document.getElementById("getacctype").selectedIndex == 2){
        document.getElementById("applicantdata").innerHTML ='' +
            '<div id="accountdataid" hidden></div><div class="col-md-12"><center><b style="color: #3C8DBC">Account Details</b><br><br></center></div>' +
            '<div class="col-md-12>' +
            '<form name="myForm" action="#" id="basicwizard" class="form-horizontal">' +
            '<fieldset title="1st Applicant">' +
            '<legend></legend><div id="groupidedit1" hidden></div>' +
            '<div class="col-md-12"><center><label class="labelcolor">Browse to Add Applicant Photo</label><input class="" type="file" name="file1" accept="image/*" onchange="readURL(this);" /></b><br><br></center></div>' +
            '<center><div id="imagespace1"><img id="blah" src="images/default.png" class="img-rounded" style="width; 100px;height:100px;image-orientation:from-image" /></div></center>' +
            '<table class="table table-bordered">' +
            '<th>First Name</th>' +
            '<th>Middle Name</th>' +
            '<th>Last Name</th>' +
            '<tbody>' +
            '<tr>' +
            '<td><input  type="text" name="fname" id="fname"></td>' +
            '<td><input  type="text" id="mname"></td>' +
            '<td><input  type="text" id="lname"></td>' +
            '</tr>' +
            '</tbody>' +
            '<th>ID/Passport No.</th>' +
            '<th>Date of Birth</th>' +
            '<th>Sex</th>' +
            '<tbody>' +
            '<tr>' +
            '<td><input  type="text" id="idnum"></td>' +
            '<td><input  type="text" id="dob"></td>' +
            '<td><select style="width: 100%;" id="gender"><option>select gender</option><option>Female</option><option>Male</option><option>other</option></select></td>' +
            '</tr>' +
            '</tbody>' +
            '<th>Nationality</th>' +
            '<th>Mobile Number</th>' +
            '<th>Marital Status</th>' +
            '<tbody>' +
            '<tr>' +
            '<td><input  type="text" id="nationality"></td>' +
            '<td><input  type="text" id="mobilenumber"></td>' +
            '<td><select style="width: 100%;" id="maritalstatus">><option>select status</option><option>Single</option><option>Married</option><option>other</option></select></td>' +
            '</tr>' +
            '</tbody>' +
            '<th>Occupation</th>' +
            '<th>Employer</th>' +
            '<th>Physical Address</th>' +
            '<tbody>' +
            '<tr>' +
            '<td><input  type="text" id="occupation"></td>' +
            '<td><input  type="text" id="employer"></td>' +
            '<td><select style="width: 100%;" id="physicaladdress"><option>select address</option></select></td>' +
            '</tr>' +
            '</tbody>' +
            '<th>Sub County</th>' +
            '<th>District</th>' +
            '<th>Next of Kin</th>' +
            '<tbody>' +
            '<tr>' +
            '<td><input  type="text" id="subcounty"></td>' +
            '<td><input  type="text" id="district"></td>' +
            '<td><input  type="text" id="kname"></td>' +
            '</tr>' +
            '</tbody>' +
            '<th>Relationship</th>' +
            '<th>Address</th>' +
            '<th>Contact Detail</th>' +
            '<tbody>' +
            '<tr>' +
            '<td><input  type="text" id="relationship"></td>' +
            '<td><input  type="text" id="address"></td>' +
            '<td><input  type="text" id="contactdetails"></td>' +
            '</tr>' +
            '</tbody>' +
            '</table>' +
            '</fieldset>' +
            '<fieldset title="2nd Applicant">' +
            '<legend></legend><div id="groupidedit2" hidden></div>' +
            '<div class="col-md-12"><center><label class="labelcolor">Browse to Add Applicant Photo</label><input class="" type="file" name="file2" accept="image/*" onchange="readURL1(this);" /></b><br><br></center></div> ' +
            '<center><div id="imagespace2"><img id="blah1" src="images/default.png" class="img-rounded" style="width; 100px;height:100px;image-orientation:from-image" /></div></center>' +
            '<table class="table table-bordered">' +
            '<th>First Name</th>' +
            '<th>Middle Name</th>' +
            '<th>Last Name</th>' +
            '<tbody>' +
            '<tr>' +
            '<td><input  type="text" id="fname1"></td>' +
            '<td><input  type="text" id="mname1"></td>' +
            '<td><input  type="text" id="lname1"></td>' +
            '</tr>' +
            '</tbody>' +
            '<th>ID/Passport No.</th>' +
            '<th>Date of Birth</th>' +
            '<th>Sex</th>' +
            '<tbody>' +
            '<tr>' +
            '<td><input  type="text" id="idnum1"></td>' +
            '<td><input  type="text" id="dob1"></td>' +
            '<td><select style="width: 100%;" id="gender1"><option>select gender</option><option>Female</option><option>Male</option><option>other</option></select></td>' +
            '</tr>' +
            '</tbody>' +
            '<th>Nationality</th>' +
            '<th>Mobile Number</th>' +
            '<th>Marital Status</th>' +
            '<tbody>' +
            '<tr>' +
            '<td><input  type="text" id="nationality1"></td>' +
            '<td><input  type="text" id="mobilenumber1"></td>' +
            '<td><select style="width: 100%;" id="maritalstatus1"><option>select status</option><option>Single</option><option>Married</option><option>other</option></select></td>' +
            '</tr>' +
            '</tbody>' +
            '<th>Occupation</th>' +
            '<th>Employer</th>' +
            '<th>Physical Address</th>' +
            '<tbody>' +
            '<tr>' +
            '<td><input  type="text" id="occupation1"></td>' +
            '<td><input  type="text" id="employer1"></td>' +
            '<td><select style="width: 100%;" id="physicaladdress1"><option>select address</option></select></td>' +
            '</tr>' +
            '</tbody>' +
            '<th>Sub County</th>' +
            '<th>District</th>' +
            '<th>Next of Kin</th>' +
            '<tbody>' +
            '<tr>' +
            '<td><input  type="text" id="subcounty1"></td>' +
            '<td><input  type="text" id="district1"></td>' +
            '<td><input  type="text" id="kname1"></td>' +
            '</tr>' +
            '</tbody>' +
            '<th>Relationship</th>' +
            '<th>Address</th>' +
            '<th>Contact Detail</th>' +
            '<tbody>' +
            '<tr>' +
            '<td><input  type="text" id="relationship1"></td>' +
            '<td><input  type="text" id="address1"></td>' +
            '<td><input  type="text" id="contactdetails1"></td>' +
            '</tr>' +
            '</tbody>' +
            '</table>' +
            '</fieldset>' +
            '<fieldset title="3rd Applicant">' +
            '<legend></legend><div id="groupidedit3" hidden></div>' +
            '<div class="col-md-12"><center><label class="labelcolor">Browse to Add Applicant Photo</label><input class="" type="file" name="file3" accept="image/*" onchange="readURL2(this);" /></b><br><br></center></div> ' +
            '<center><div id="imagespace3"><img id="blah2" src="images/default.png" class="img-rounded" style="width; 100px;height:100px;image-orientation:from-image" /></div></center>' +
            '<table class="table table-bordered">'+
            '<th>First Name</th>' +
            '<th>Middle Name</th>' +
            '<th>Last Name</th>' +
            '<tbody>' +
            '<tr>' +
            '<td><input  type="text" id="fname2"></td>' +
            '<td><input  type="text" id="mname2"></td>' +
            '<td><input  type="text" id="lname2"></td>' +
            '</tr>' +
            '</tbody>' +
            '<th>ID/Passport No.</th>' +
            '<th>Date of Birth</th>' +
            '<th>Sex</th>' +
            '<tbody>' +
            '<tr>' +
            '<td><input  type="text" id="idnum2"></td>' +
            '<td><input  type="text" id="dob2"></td>' +
            '<td><select style="width: 100%;" id="gender2"><option>select gender</option><option>Female</option><option>Male</option><option>other</option></select></td>' +
            '</tr>' +
            '</tbody>' +
            '<th>Nationality</th>' +
            '<th>Mobile Number</th>' +
            '<th>Marital Status</th>' +
            '<tbody>' +
            '<tr>' +
            '<td><input  type="text" id="nationality2"></td>' +
            '<td><input  type="text" id="mobilenumber2"></td>' +
            '<td><select style="width: 100%;" id="maritalstatus2">><option>select status</option><option>Single</option><option>Married</option><option>other</option></select></td>' +
            '</tr>' +
            '</tbody>' +
            '<th>Occupation</th>' +
            '<th>Employer</th>' +
            '<th>Physical Address</th>' +
            '<tbody>' +
            '<tr>' +
            '<td><input  type="text" id="occupation2"></td>' +
            '<td><input  type="text" id="employer2"></td>' +
            '<td><select style="width: 100%;" id="physicaladdress2"><option>select address</option></select></td>' +
            '</tr>' +
            '</tbody>' +
            '<th>Sub County</th>' +
            '<th>District</th>' +
            '<th>Next of Kin</th>' +
            '<tbody>' +
            '<tr>' +
            '<td><input  type="text" id="subcounty2"></td>' +
            '<td><input  type="text" id="district2"></td>' +
            '<td><input  type="text" id="kname2"></td>' +
            '</tr>' +
            '</tbody>' +
            '<th>Relationship</th>' +
            '<th>Address</th>' +
            '<th>Contact Detail</th>' +
            '<tbody>' +
            '<tr>' +
            '<td><input  type="text" id="relationship2"></td>' +
            '<td><input  type="text" id="address2"></td>' +
            '<td><input  type="text" id="contactdetails2"></td>' +
            '</tr>' +
            '</tbody>' +
            '</table>' +
            '</fieldset>' +
            '<br><br>' +
            '</form>' +
            '</div>' +
            '<div class="col-md-12"><center><b style="color: #3C8DBC">Account Details</b><br><br></center></div> ' +
            '<div class="col-md-6">' +
            '<label class="labelcolor">Account Name</label>' +
            '<input type="text" class="form-control" id="accountname">' +
            '</div><div class="col-md-6">' +
            '<label class="labelcolor">Account Number</label> ' +
            '<input type="text" class="form-control" id="accountno"><br><br>' +
            '</div>';
        $('#basicwizard').stepy();
        $('#wizard').stepy({finishButton: true, titleClick: true, block: true, validate: true});

        //Add Wizard Compability - see docs
        $('.stepy-navigator').wrapInner('<div class="pull-right"></div>');
    }
    if(document.getElementById("getacctype").selectedIndex == 3){
        document.getElementById("applicantdata").innerHTML ='' +
            '<div id="applicantdata"><div hidden id="buzaccountid"></div><div hidden id="buzdetailid"></div>' +
            '<div class="col-md-12"><center><b style="color: #3C8DBC">Business/Institution Details</b><br><br></center></div>' +
            '<div class="col-md-12">' +
			'Check <b>(yes)</b> if institution/business is a school and <b>(no)</b> if not.<br>' +
			'<table>' +
			'	<tr>' +
			'		<td><input onchange="" id="yesacc" value="1" name="optionadiosInline"  type="radio"></td>' +
			'		<td>&nbsp;Yes</td>' +
			'		<td>&nbsp;&nbsp;&nbsp;<input onchange="" id="noacc" value="0" name="optionadiosInline"  type="radio"></td>' +
			'		<td>&nbsp;No</td>' +
			'	</tr>' +
			'</table><br><br>' +
            '<label class="labelcolor">Details of Nature of Business / Sector</label>' +
            '<input id="natureofbusiness" type="text" class="form-control">' +
            '</div>' +
            '<div class="col-md-12">' +
            '<label class="labelcolor">Certificate of Registration/ Incorporation</label>' +
            '<input id="certfofreg" type="text" class="form-control">' +
            '</div>' +
            '<div class="col-md-12">' +
            '<label class="labelcolor">Date Of Business/ Company/ Institution Registration</label>' +
            '<input id="dateofbusiness" type="text" class="form-control">' +
            '</div>' +
            '<div class="col-md-6">' +
            '<label class="labelcolor">Office Tel.No/ Mobile No.</label>' +
            '<input id="mobilenumber" type="text" class="form-control">' +
            '</div>' +
            '<div class="col-md-6">' +
            '<label class="labelcolor">Email Address</label>' +
            '<input id="emailaddress" type="text" class="form-control">' +
            '</div>' +
            '<div class="col-md-12">' +
            '<label class="labelcolor">Business /Institution Location/ (Town / Shopping Center)</label>' +
            '<input id="location" type="text" class="form-control">' +
            '</div>' +
            '<div class="col-md-6">' +
            '<label class="labelcolor">T.I.N (If Any)</label>' +
            '<input id="tin" type="text" class="form-control">' +
            '</div>' +
            '<div class="col-md-6">' +
            '<label class="labelcolor">Physical Address</label>' +
            '<input id="physicaladdress" type="text" class="form-control">' +
            '</div>' +
            '<div class="col-md-6">' +
            '<label class="labelcolor">Sub County</label>' +
            '<input id="subcountry" type="text" class="form-control">' +
            '</div>' +
            '</div>' +
            '<div class="col-md-6">' +
            '<label class="labelcolor">District</label>' +
            '<input id="district" type="text" class="form-control"><br><br>' +
            '</div>' +
            '<div class="col-md-8">' +
			'	<label class="labelcolor">Browse to Add Applicant Photo</label>' +
			'	<input class="" type="file" name="file1" id="file" onchange="readURL(this);" />' +
			'</div>' +
			'<div class="col-md-4" id="imageplace">' +
			'	<img id="blah" src="images/default.png" class="img-rounded" style="width; 100px;height:100px;image-orientation:from-image" />' +
			'	</b><br><br>' +
			'</div>' +'<div class="col-md-12"><center><b style="color: #3C8DBC">Account Signatory(s)</b><br><br></center></div>' +
            '<table class="table table-bordered">' +
            '<th>Names in Full</th>' +
            '<th>National ID/ Passport No.</th>' +
            '<tbody>' +
            '<tr>' +
            '<td><input id="signame1" type="text"></td>' +
            '<td><input id="indent1" type="text"></td>' +
            '</tr>' +
            '<tr>' +
            '<td><input id="signame2" type="text"></td>' +
            '<td><input id="indent2" type="text"></td>' +
            '</tr>' +
            '<tr>' +
            '<td><input id="signame3" type="text"></td>' +
            '<td><input id="indent3" type="text"></td>' +
            '</tr>' +
            '</tbody>' +
            '</table><br><br>' +
            '<div class="col-md-12"><center><b style="color: #3C8DBC">Account Details</b><br><br></center></div>' +
            '<div class="col-md-6">' +
            '<label class="labelcolor">Account Name</label>' +
            '<input id="accountname" type="text" class="form-control">' +
            '</div>' +
            '<div class="col-md-6">' +
            '<label class="labelcolor">Account Number</label>' +
            '<input id="accountnumber" type="text" class="form-control"><br><br>' +
            '</div>' +
            '</div>';
    }
}

function saveaccount(photo) {
	
    document.getElementById("saveacc").disabled = true;
    if(document.getElementById("getacctype").selectedIndex == 1 || document.getElementById("getacctype").selectedIndex == 0){

        var data = document.getElementById("fname").value +"?::?"+
                   document.getElementById("lname").value+"?::?"+
                   document.getElementById("idnum").value+"?::?"+
                   document.getElementById("nationality").value+"?::?"+
                   document.getElementById("occupation").value+"?::?"+
                   document.getElementById("mobilenumber").value+"?::?"+
                   document.getElementById("subcounty").value+"?::?"+
                   document.getElementById("mname").value+"?::?"+
                   document.getElementById("gender").value+"?::?"+
                   document.getElementById("dateofbirth").value+"?::?"+
                   document.getElementById("maritalstatus").value+"?::?"+
                   document.getElementById("employer").value+"?::?"+
                   document.getElementById("physicaladdress").value+"?::?"+
                   document.getElementById("district").value+"?::?"+
                   document.getElementById("kname").value+"?::?"+
                   document.getElementById("kaddress").value+"?::?"+
                   document.getElementById("security").value+"?::?"+
                   document.getElementById("krelationship").value+"?::?"+
                   document.getElementById("contactdetail").value+"?::?"+
                   document.getElementById("sanswer").value+"?::?"+
                   document.getElementById("accountname").value+"?::?"+
                   document.getElementById("accountnumber").value+"?::?"+photo;
				 
        if(document.getElementById("editindacc").innerHTML !=""){data +="?::?"+ document.getElementById("editindacc").innerHTML;}else{}
  
        if (window.XMLHttpRequest) {xmlhttp = new XMLHttpRequest();} else {xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");}
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
					var responseArray = xmlhttp.responseText.split("|<><>|");
                    document.getElementById("applicantdata").innerHTML = responseArray[0];
                    document.getElementById("accountdatarecords").innerHTML = responseArray[1] ;
                    $('#grn').DataTable({
                        "bDestroy": true,
                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": true,
                        "sDom": 'lfrtip',
                        "dom": 'Bfrtip',
                        "buttons": [
                            'excelHtml5', 'csv','pdf'
                        ]
                    });

                    $('.dataTables_filter input').attr('placeholder','Search...');
                    $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
                    $('.panel-ctrls').append("<i class='separator'></i>");
                    $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
                    $('.panel-footer').append($(".dataTable+.row"));
                    $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");

                    				
                }
            }
            xmlhttp.open("GET","classes/ajax_res.php?saveindividualaccountdata="+data,true);
            xmlhttp.send();
    }
    if(document.getElementById("getacctype").selectedIndex == 2){
        var data =  document.getElementById("fname").value +"?::?"+
                    document.getElementById("lname").value +"?::?"+
                    document.getElementById("mname").value +"?::?"+
                    document.getElementById("gender").value +"?::?"+
                    document.getElementById("idnum").value +"?::?"+
                    document.getElementById("nationality").value +"?::?"+
                    document.getElementById("dob").value +"?::?"+
                    document.getElementById("maritalstatus").value +"?::?"+
                    document.getElementById("occupation").value +"?::?"+
                    document.getElementById("employer").value +"?::?"+
                    document.getElementById("mobilenumber").value +"?::?"+
                    document.getElementById("physicaladdress").value +"?::?"+
                    document.getElementById("subcounty").value +"?::?"+
                    document.getElementById("district").value +"?::?"+
                    document.getElementById("kname").value +"?::?"+
                    document.getElementById("relationship").value +"?::?"+
                    document.getElementById("contactdetails").value +"?::?"+
                    document.getElementById("address").value +"?::?"+
                    document.getElementById("fname1").value +"?::?"+
                    document.getElementById("lname1").value +"?::?"+
                    document.getElementById("mname1").value +"?::?"+
                    document.getElementById("gender1").value +"?::?"+
                    document.getElementById("idnum1").value +"?::?"+
                    document.getElementById("nationality1").value +"?::?"+
                    document.getElementById("dob1").value +"?::?"+
                    document.getElementById("maritalstatus1").value +"?::?"+
                    document.getElementById("occupation1").value +"?::?"+
                    document.getElementById("employer1").value +"?::?"+
                    document.getElementById("mobilenumber1").value +"?::?"+
                    document.getElementById("physicaladdress1").value +"?::?"+
                    document.getElementById("subcounty1").value +"?::?"+
                    document.getElementById("district1").value +"?::?"+
                    document.getElementById("kname1").value +"?::?"+
                    document.getElementById("relationship1").value +"?::?"+
                    document.getElementById("contactdetails1").value +"?::?"+
                    document.getElementById("address1").value +"?::?"+
                    document.getElementById("fname2").value +"?::?"+
                    document.getElementById("lname2").value +"?::?"+
                    document.getElementById("mname2").value +"?::?"+
                    document.getElementById("gender2").value +"?::?"+
                    document.getElementById("idnum2").value +"?::?"+
                    document.getElementById("nationality2").value +"?::?"+
                    document.getElementById("dob2").value +"?::?"+
                    document.getElementById("maritalstatus2").value +"?::?"+
                    document.getElementById("occupation2").value +"?::?"+
                    document.getElementById("employer2").value +"?::?"+
                    document.getElementById("mobilenumber2").value +"?::?"+
                    document.getElementById("physicaladdress2").value +"?::?"+
                    document.getElementById("subcounty2").value +"?::?"+
                    document.getElementById("district2").value +"?::?"+
                    document.getElementById("kname2").value +"?::?"+
                    document.getElementById("relationship2").value +"?::?"+
                    document.getElementById("contactdetails2").value +"?::?"+
                    document.getElementById("address2").value +"?::?"+
                    document.getElementById("accountname").value +"?::?"+
                    document.getElementById("accountno").value+"?::?"+photo;
        if(document.getElementById('groupidedit1').innerHTML !="" && document.getElementById('groupidedit2').innerHTML !="" && document.getElementById('groupidedit3').innerHTML !=""){
            data += "?::?"+ document.getElementById('groupidedit1').innerHTML + "?::?" +
                            document.getElementById('groupidedit2').innerHTML +"?::?"+
                            document.getElementById('groupidedit3').innerHTML +"?::?"+
                            document.getElementById('accountdataid').innerHTML; 

        }else{}

        if (window.XMLHttpRequest) {xmlhttp = new XMLHttpRequest();} else {xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");}
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
					var responseArray = xmlhttp.responseText.split("|<><>|");
                    document.getElementById("applicantdata").innerHTML = responseArray[0];
                    document.getElementById("accountdatarecords").innerHTML = responseArray[1] ;
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
					
					$('#basicwizard').stepy();
					$('#wizard').stepy({finishButton: true, titleClick: true, block: true, validate: true});

					//Add Wizard Compability - see docs
					$('.stepy-navigator').wrapInner('<div class="pull-right"></div>');
                   
                }
            }
            xmlhttp.open("GET","classes/ajax_res.php?savegroupaccountdata="+data,true);
            xmlhttp.send();
    }
    if(document.getElementById("getacctype").selectedIndex == 3){

        var data =  document.getElementById("natureofbusiness").value +"?::?"+
                    document.getElementById("certfofreg").value +"?::?"+
                    document.getElementById("dateofbusiness").value +"?::?"+
                    document.getElementById("mobilenumber").value +"?::?"+
                    document.getElementById("emailaddress").value +"?::?"+
                    document.getElementById("location").value +"?::?"+
                    document.getElementById("tin").value +"?::?"+
                    document.getElementById("physicaladdress").value +"?::?"+
                    document.getElementById("subcountry").value +"?::?"+
                    document.getElementById("district").value +"?::?"+
                    document.getElementById("signame1").value +"?::?"+
                    document.getElementById("signame2").value +"?::?"+
                    document.getElementById("signame3").value +"?::?"+
                    document.getElementById("indent1").value +"?::?"+
                    document.getElementById("indent2").value +"?::?"+
                    document.getElementById("indent3").value +"?::?"+
                    document.getElementById("accountname").value +"?::?"+
                    document.getElementById("accountnumber").value +"?::?"+photo;
					if(document.getElementById('yesacc').checked==true){
						data += "?::?"+"1";
					}else{
						data += "?::?"+"0";
					}
        if(document.getElementById('buzaccountid').innerHTML && document.getElementById('buzdetailid').innerHTML){
            data += "?::?"+ document.getElementById("buzdetailid").innerHTML +"?::?"+ document.getElementById("buzaccountid").innerHTML;
        }else {

        }
        if (window.XMLHttpRequest) {xmlhttp = new XMLHttpRequest();} else {xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");}
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                var responseArray = xmlhttp.responseText.split("|<><>|");
				document.getElementById("applicantdata").innerHTML = responseArray[0];
				document.getElementById("accountdatarecords").innerHTML = responseArray[1] ;
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
        xmlhttp.open("GET","classes/ajax_res.php?savebusinessaccount="+data,true);
        xmlhttp.send();
    }
    if(document.getElementById("getacctype").selectedIndex == 4){

        var data = document.getElementById("fname").value +"?::?"+
                   document.getElementById("lname").value+"?::?"+
                   document.getElementById("idnum").value+"?::?"+
                   document.getElementById("nationality").value+"?::?"+
                   document.getElementById("occupation").value+"?::?"+
                   document.getElementById("mobilenumber").value+"?::?"+
                   document.getElementById("subcounty").value+"?::?"+
                   document.getElementById("mname").value+"?::?"+
                   document.getElementById("gender").value+"?::?"+
                   document.getElementById("dateofbirth").value+"?::?"+
                   document.getElementById("maritalstatus").value+"?::?"+
                   document.getElementById("employer").value+"?::?"+
                   document.getElementById("physicaladdress").value+"?::?"+
                   document.getElementById("district").value+"?::?"+
                   document.getElementById("kname").value+"?::?"+
                   document.getElementById("kaddress").value+"?::?"+
                   document.getElementById("security").value+"?::?"+
                   document.getElementById("krelationship").value+"?::?"+
                   document.getElementById("contactdetail").value+"?::?"+
                   document.getElementById("sanswer").value+"?::?"+
                   document.getElementById("accountname").value+"?::?"+
                   document.getElementById("accountnumber").value+"?::?"+photo;
				 
        if(document.getElementById("editindacc").innerHTML !=""){data +="?::?"+ document.getElementById("editindacc").innerHTML;}else{}
  
        if (window.XMLHttpRequest) {xmlhttp = new XMLHttpRequest();} else {xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");}
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
					var responseArray = xmlhttp.responseText.split("|<><>|");
                    document.getElementById("applicantdata").innerHTML = responseArray[0];
                    document.getElementById("accountdatarecords").innerHTML = responseArray[1] ;
                    $('#grn').DataTable({
                        "bDestroy": true,
                        "paging": true,
                        "lengthChange": true,
                        "searching": true,
                        "ordering": true,
                        "info": true,
                        "autoWidth": true,
                        "sDom": 'lfrtip',
                        "dom": 'Bfrtip',
                        "buttons": [
                            'excelHtml5', 'csv','pdf'
                        ]
                    });

                    $('.dataTables_filter input').attr('placeholder','Search...');
                    $('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
                    $('.panel-ctrls').append("<i class='separator'></i>");
                    $('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");
                    $('.panel-footer').append($(".dataTable+.row"));
                    $('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");

                    				
                }
            }
            xmlhttp.open("GET","classes/ajax_res.php?saveindividualaccountdata1="+data,true);
            xmlhttp.send();
    }
    document.getElementById("saveacc").disabled = false;
}

function individualdetail(e) {

       if (window.XMLHttpRequest) {xmlhttp = new XMLHttpRequest();} else {xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");}
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                document.getElementById("individualclientdata").innerHTML = xmlhttp.responseText;

            }
        }
        xmlhttp.open("GET","classes/ajax_res.php?individualdata="+e,true);
        xmlhttp.send();
}

function groupdetail(e) {

       if (window.XMLHttpRequest) {xmlhttp = new XMLHttpRequest();} else {xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");}
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                document.getElementById("groupclientdata").innerHTML = xmlhttp.responseText;

            }
        }
        xmlhttp.open("GET","classes/ajax_res.php?groupdata="+e,true);
        xmlhttp.send();
}

function businessdetail(e) {

       if (window.XMLHttpRequest) {xmlhttp = new XMLHttpRequest();} else {xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");}
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
                document.getElementById("businessclientdata").innerHTML = xmlhttp.responseText;

            }
        }
        xmlhttp.open("GET","classes/ajax_res.php?businessdata="+e,true);
        xmlhttp.send();
}

function editindividualdetail(e) {
    if (window.XMLHttpRequest) {xmlhttp = new XMLHttpRequest();} else {xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");}
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            document.getElementById("applicantdata").innerHTML = xmlhttp.responseText;
			
		}
    }
    xmlhttp.open("GET","classes/ajax_res.php?editindividualdata="+e,true);
    xmlhttp.send();
}

function editgroupdetail(id){
    if (window.XMLHttpRequest) {xmlhttp = new XMLHttpRequest();} else {xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");}
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            document.getElementById("applicantdata").innerHTML = xmlhttp.responseText;
            document.getElementById("getacctype").selectedIndex = 2;
            $('#basicwizard').stepy();
            $('#wizard').stepy({finishButton: true, titleClick: true, block: true, validate: true});

            //Add Wizard Compability - see docs
            $('.stepy-navigator').wrapInner('<div class="pull-right"></div>');
        }
    }
    xmlhttp.open("GET","classes/ajax_res.php?groupeditdata="+id,true);
    xmlhttp.send();
}

function editbusinessdetail(id){

    if (window.XMLHttpRequest) {xmlhttp = new XMLHttpRequest();} else {xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");}
    xmlhttp.onreadystatechange = function () {
        if (xmlhttp.readyState === 4 && xmlhttp.status === 200) {
            document.getElementById("applicantdata").innerHTML = xmlhttp.responseText;
            document.getElementById("getacctype").selectedIndex = 3;
        }
    }
    xmlhttp.open("GET","classes/ajax_res.php?businesseditdata="+id,true);
    xmlhttp.send();
}

