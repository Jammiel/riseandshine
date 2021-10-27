<?php
// require_once "pages.php";
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of views
 *
 * @author jammie luvie
 */
/*#9c27b0*/
class SCRIPT_CONTROLLER {
    public static $special_Scripts;    public static $special_css;

    public static function TOP_SCRIPTS(){
	$title='MF MANAGER';
	$description='UCATCH TECHNOLOGIES LIMITED';
	$author='SSEMITEGO JAMES';
        echo
           '<meta charset="utf-8">
            <title>'.$title.'</title>
            <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
            <meta name="apple-mobile-web-app-capable" content="yes">
            <meta name="apple-touch-fullscreen" content="yes">
            <meta name="description" content="'.$description.'">
            <meta name="author" content="'.$author.'">
            <link rel="icon" href="currentlogo.jpg" >
            <link type="text/css" href="assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet">
            <link type="text/css" href="assets/fonts/themify-icons/themify-icons.css" rel="stylesheet">
            <link type="text/css" href="assets/css/styles.css" rel="stylesheet">
            <link type="text/css" href="assets/plugins/codeprettifier/prettify.css" rel="stylesheet">
            <link type="text/css" href="assets/plugins/iCheck/skins/minimal/blue.css" rel="stylesheet">
            <link type="text/css" href="assets/plugins/gridforms/gridforms/gridforms.css" rel="stylesheet">
            <link type="text/css" href="assets/plugins/pines-notify/pnotify.css" rel="stylesheet">
            <link rel="stylesheet" href="assets/dist/css/bootstrap.min.css">
            <link rel="stylesheet" href="assets/dist/css/bootstrap-select.css">
            <link rel="stylesheet" href="assets/css/w3cards.css">
            <link rel="stylesheet" href="assets/datatable/datatables.min.css">
            <link rel="stylesheet" href="assets/datatable/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
            <link rel="stylesheet" href="assets/datatable/Buttons-1.5.4/css/buttons.bootstrap.min.css">
            <link type="text/css" href="assets/plugins/form-daterangepicker/daterangepicker-bs3.css" rel="stylesheet">    <!-- DateRangePicker -->
            <link type="text/css" href="assets/plugins/iCheck/skins/minimal/blue.css" rel="stylesheet">                   <!-- Custom Checkboxes / iCheck -->
            <link type="text/css" href="assets/plugins/clockface/css/clockface.css" rel="stylesheet">

            <link type="text/css" href="assets/plugins/fullcalendar/fullcalendar.css" rel="stylesheet"> 						<!-- FullCalendar -->
            <link type="text/css" href="assets/plugins/jvectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"> 			<!-- jVectorMap -->
            <link type="text/css" href="assets/plugins/switchery/switchery.css" rel="stylesheet">
           ';
	echo ((static::$special_css !="")?static::$special_css:'');
    }
    public static function LOW_SCRIPTS(){
    echo '
            <script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script>
            <script type="text/javascript" src="assets/js/jqueryui-1.10.3.min.js"></script>
            <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>

            <script type="text/javascript" src="assets/datatable/DataTables-1.10.18/js/jquery.dataTables.min.js"></script>
            <script type="text/javascript" src="assets/datatable/DataTables-1.10.18/js/dataTables.bootstrap4.min.js"></script>
            <script type="text/javascript" src="assets/datatable/Buttons-1.5.4/js/dataTables.buttons.min.js"></script>
            <script type="text/javascript" src="assets/datatable/Buttons-1.5.4/js/buttons.bootstrap.min.js"></script>
            <script type="text/javascript" src="assets/datatable/Buttons-1.5.4/js/buttons.flash.min.js"></script>
            <script type="text/javascript" src="assets/datatable/Buttons-1.5.4/js/buttons.colVis.min.js"></script>
            <script type="text/javascript" src="assets/datatable/Buttons-1.5.4/js/buttons.html5.min.js"></script>
            <script type="text/javascript" src="assets/datatable/Buttons-1.5.4/js/buttons.print.min.js"></script>
            <script type="text/javascript" src="assets/demo/demo-datatables.js"></script>
            <script type="text/javascript" src="assets/js/enquire.min.js"></script>


            <script type="text/javascript" src="assets/plugins/velocityjs/velocity.min.js"></script>
            <script type="text/javascript" src="assets/plugins/velocityjs/velocity.ui.min.js"></script>

            <script type="text/javascript" src="assets/plugins/wijets/wijets.js"></script>

            <script type="text/javascript" src="assets/plugins/codeprettifier/prettify.js"></script>
            <script type="text/javascript" src="assets/plugins/bootstrap-switch/bootstrap-switch.js"></script>

            <script type="text/javascript" src="assets/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js"></script>

            <script type="text/javascript" src="assets/plugins/iCheck/icheck.min.js"></script>

            <script type="text/javascript" src="assets/plugins/nanoScroller/js/jquery.nanoscroller.min.js"></script>

            <script type="text/javascript" src="assets/js/application.js"></script>
            <script type="text/javascript" src="assets/demo/demo.js"></script>
            <script type="text/javascript" src="assets/demo/demo-switcher.js"></script>

            <script type="text/javascript" src="assets/plugins/gridforms/gridforms/gridforms.js"></script>

            <script type="text/javascript" src="assets/plugins/gridforms/gridforms/gridforms.js"></script>
            <script type="text/javascript" src="assets/plugins/pines-notify/pnotify.min.js"></script>
            <script type="text/javascript" src="assets/js/jquery.autocomplete.min.js"></script>
            <script type="text/javascript" src="assets/js/currency-autocomplete.js"></script>
            <script src="assets/dist/js/bootstrap-select.js"></script>
            <script src="assets/js/mf-js/mf-custom.js"></script>
            <script src="assets/js/mf-js/amort.js"></script>
            <script src="assets/js/mf-js/accountopening.js"></script>
            <script type="text/javascript" src="assets/plugins/form-validation/jquery.validate.min.js"></script>  					<!-- Validate Plugin -->
            <script type="text/javascript" src="assets/plugins/form-stepy/jquery.stepy.js"></script>
            <script type="text/javascript" src="assets/demo/demo-formwizard.js"></script>

            <script type="text/javascript" src="assets/plugins/form-daterangepicker/moment.min.js"></script>              			<!-- Moment.js for Date Range Picker -->
            <script type="text/javascript" src="assets/plugins/form-colorpicker/js/bootstrap-colorpicker.min.js"></script> 			<!-- Color Picker -->

            <script type="text/javascript" src="assets/plugins/form-daterangepicker/daterangepicker.js"></script>     				<!-- Date Range Picker -->
            <script type="text/javascript" src="assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>      			<!-- Datepicker -->
            <script type="text/javascript" src="assets/plugins/bootstrap-timepicker/bootstrap-timepicker.js"></script>      			<!-- Timepicker -->
            <script type="text/javascript" src="assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js"></script> <!-- DateTime Picker -->

            <script type="text/javascript" src="assets/plugins/clockface/js/clockface.js"></script>     								<!-- Clockface -->
            <script type="text/javascript" src="assets/demo/demo-pickers.js"></script>

            <!-- Charts -->
            <script type="text/javascript" src="assets/plugins/charts-flot/jquery.flot.min.js"></script>             	<!-- Flot Main File -->
            <script type="text/javascript" src="assets/plugins/charts-flot/jquery.flot.pie.min.js"></script>             <!-- Flot Pie Chart Plugin -->
            <script type="text/javascript" src="assets/plugins/charts-flot/jquery.flot.stack.min.js"></script>       	<!-- Flot Stacked Charts Plugin -->
            <script type="text/javascript" src="assets/plugins/charts-flot/jquery.flot.orderBars.min.js"></script>   	<!-- Flot Ordered Bars Plugin-->
            <script type="text/javascript" src="assets/plugins/charts-flot/jquery.flot.resize.min.js"></script>          <!-- Flot Responsive -->
            <script type="text/javascript" src="assets/plugins/charts-flot/jquery.flot.tooltip.min.js"></script> 		<!-- Flot Tooltips -->
            <script type="text/javascript" src="assets/plugins/charts-flot/jquery.flot.spline.js"></script> 				<!-- Flot Curved Lines -->

            <script type="text/javascript" src="assets/plugins/sparklines/jquery.sparklines.min.js"></script> 			 <!-- Sparkline -->

            <script type="text/javascript" src="assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>       <!-- jVectorMap -->
            <script type="text/javascript" src="assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>   <!-- jVectorMap -->

            <script type="text/javascript" src="assets/plugins/switchery/switchery.js"></script>     					<!-- Switchery -->
            <script type="text/javascript" src="assets/plugins/easypiechart/jquery.easypiechart.js"></script>
            <script type="text/javascript" src="assets/plugins/fullcalendar/moment.min.js"></script> 		 			<!-- Moment.js Dependency -->
            <script type="text/javascript" src="assets/plugins/fullcalendar/fullcalendar.min.js"></script>   			<!-- Calendar Plugin -->

            <script type="text/javascript" src="assets/demo/demo-index.js"></script>

             <script>
				$(function () {
					$(".panel-color-list>li>span").click(function(e) {
						$(".panel").attr(\'class\',\'panel\').addClass($(this).attr(\'data-style\'));
					});

				});
				$(document).ready(function () {
                    var mySelect = $(\'#first-disabled2\');

                    $(\'#special\').on(\'click\', function () {
                      mySelect.find(\'option:selected\').prop(\'disabled\', true);
                      mySelect.selectpicker(\'refresh\');
                    });

                    $(\'#special2\').on(\'click\', function () {
                      mySelect.find(\'option:disabled\').prop(\'disabled\', false);
                      mySelect.selectpicker(\'refresh\');
                    });

                    $(\'#basic2\').selectpicker({
                      liveSearch: true,
                      maxOptions: 1
                    });
                  });
            </script>

	';
    echo ((static::$special_Scripts !="")?static::$special_Scripts:'');
    }
}
class PAGE_CONTROLLER{

    public static function PAGE_BUILD(){
        $navbar_topcolor = "blue";
        $navbar_sidecolor = "teal";
        $companyandyear = '2017 M.F MANAGER';
        session_start();
        $msg = strtoupper($_SESSION['user']);
        PAGE::page_load();
        echo '
	<html lang="en">
	    <head>';
        SCRIPT_CONTROLLER::TOP_SCRIPTS();
        echo'   </head>
	    <body class="animated-content">
		<header id="topnav" class="navbar navbar-fixed-top navbar-'.$navbar_topcolor.'" style="background-color: #3c8dbc;color: #fff" role="banner">
		    <div class="col-md-4">
			<div class="logo-area">
			    <span id="trigger-sidebar" class="toolbar-trigger toolbar-icon-bg">
				<a data-toggle="tooltips" data-placement="right" title="Toggle Sidebar">
				    <span class="icon-bg">
					<i class="ti ti-menu"></i>
				    </span>
				</a>
			    </span>
			    <h3><img style="" class="img-rounded" src="images/mflogo.png" height="40"></h3>
			    <a class="navbar-brand" href="">Avenxo</a>
			</div><!-- logo-area -->
		    </div>
		    <div class="col-md-4">
			<center><br>
			    <b class="col-md-offset-1" style="text-align: justify;font-size: 25px;color: white;font-family: Courier New, Courier, monospace">'.$msg.'</b><br>
			    <b style="color: lightblue;font-size: 15px;font-family: Courier New, Courier, monospace">'.(($_SESSION['username'])?'LOGGEDIN IS:':'').'</b><b class="col-md-offset-1" style="text-align: justify;font-size: 13px;color: white;font-family: Courier New, Courier, monospace">'.strtoupper($_SESSION['username']).'</b>
			</center>
		    </div>
		    <div class="col-md-4">
			<ul  class="nav navbar-nav toolbar pull-right">
			    <li class="toolbar-icon-bg visible-xs-block" id="trigger-toolbar-search">
				    <a href="#"><span class="icon-bg"><i class="ti ti-search"></i></span></a>
			    </li>
			    <li class="toolbar-icon-bg hidden-xs">
				    <a href="login.php"><span class="icon-bg"><i class="ti ti-power-off"></i></span></i></a>
			    </li>
			    <li class="toolbar-icon-bg hidden-xs" id="trigger-fullscreen">
				    <a href="#" class="toggle-fullscreen"><span class="icon-bg"><i class="ti ti-fullscreen"></i></span></i></a>
			    </li>
			    <li class="toolbar-icon-bg hidden-xs" id="trigger-fullscreen">
				    <a href="#" class="toggle-fullscreen"><span class="icon-bg"><i class="ti ti-hummer"></i></span></i></a>
			    </li>
			    <li class="toolbar-icon-bg hidden-xs" id="trigger-fullscreen">
				    <a href="#" class="toggle-fullscreen"><span class="icon-bg"><i class="ti ti-help"></i></span></i></a>
			    </li>
			</ul>
		    </div>
		</header>
		<div id="wrapper">
		    <div id="layout-static">
			<div class="static-sidebar-wrapper sidebar-'.$navbar_sidecolor.'">
			    <div class="static-sidebar">
				<div class="sidebar">
				    <div class="widget">
					<div class="widget-body">
					    <div class="userinfo">
						<div class="avatar">
						    <img src="images/default.jpg" class="img-responsive img-circle">
						</div>
						<div class="info">
						    <span class="username">'.strtoupper($_SESSION['username']).'</span>
						    <span class="useremail">'.$_SESSION['user'].'</span>
						</div>
					    </div>
					</div>
				    </div>
				    <div class="widget stay-on-collapse" id="widget-sidebar">
					<nav role="navigation" class="widget-body"  style="">
					    <ul class="acc-menu">
						<li class="nav-separator"><span><b style="color: yellow;">Control Panel</b></span></li>';
                            AUTH_PAGE::GENERAL_MENU();
        echo '		    </ul>
					</nav>
				    </div>

				</div>
			    </div>
			</div>
			<div class="static-content-wrapper">';
        static::PAGE_MAIN();
        echo'			<footer role="contentinfo">
			    <div class="clearfix">
				<ul class="list-unstyled list-inline pull-left">
				    <li><h6 style="margin: 0;">&copy; '.$companyandyear.'</h6></li>
				</ul>
				<button class="pull-right btn btn-link btn-xs hidden-print" id="back-to-top"><i class="ti ti-arrow-up"></i></button>
			    </div>
			</footer>
			</div>
		    </div>
		</div>';
    }
    static function PAGE_MAIN(){
        echo '
	    <div class="static-content">
		    <div class="page-content">
		        <br>
			    <div class="container-fluid">';
        PAGE::page_shifting();
        echo '		</div>
            </div>
		</div>';
        SCRIPT_CONTROLLER::LOW_SCRIPTS();
        echo '
		</body>
	    </html>';
    }
}
class VIEW_PAGE{

}
