// -------------------------------
// Initialize Data Tables
// -------------------------------

$(document).ready(function() {
    $('#disb').dataTable({
    	"language": {
    		"lengthMenu": "_MENU_"
    	}
    });
	$('#balncd').dataTable({
    	"language": {
    		"lengthMenu": "_MENU_"
    	}
    });
	$('#oppsd').dataTable({
    	"language": {
    		"lengthMenu": "_MENU_"
    	}
    });
	$('#example').dataTable({
    	"language": {
    		"lengthMenu": "_MENU_"
    	}
    });
	$('#grat1').dataTable({
		"language": {
			"lengthMenu": "_MENU_"
		}
	});
	$('#grat2').dataTable({
		"language": {
			"lengthMenu": "_MENU_"
		}
	});
	$('#grn').dataTable({
            "language": {
                "lengthMenu": "_MENU_"
            },
            "dom": 'Bfrtip',
                "buttons": [
                    'csv', 'excel', 'pdf', 'print'
                ]
	});
        

//    $('.dataTables_filter input').attr('placeholder','Search...');


    //DOM Manipulation to move datatable elements integrate to panel
	$('.panel-ctrls').append($('.dataTables_filter').addClass("pull-right")).find("label").addClass("panel-ctrls-center");
	$('.panel-ctrls').append("<i class='separator'></i>");
	$('.panel-ctrls').append($('.dataTables_length').addClass("pull-left")).find("label").addClass("panel-ctrls-center");

	$('.panel-footer').append($(".dataTable+.row"));
	$('.dataTables_paginate>ul.pagination').addClass("pull-right m-n");

});