<?php
require_once 'classes/initialising.php';
/**
 * Created by PhpStorm.
 * User: Jammieluvie
 * Date: 1/18/17
 * Time: 4:47 PM
 */
AUTH_PAGE::ACCOUNT_LOGIN();
?>
<!DOCTYPE html>
<html lang="en" class="coming-soon">
<head>    <meta charset="utf-8">
    <title>MFI MANAGER Login</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="author" content="">

    <link type="text/css" href="assets/plugins/iCheck/skins/minimal/blue.css" rel="stylesheet">
    <link type="text/css" href="assets/fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link type="text/css" href="assets/fonts/themify-icons/themify-icons.css" rel="stylesheet">               <!-- Themify Icons -->
    <link type="text/css" href="assets/css/styles.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholder.js enables the placeholder attribute -->
    <!--[if lt IE 9]>
    <link type="text/css" href="assets/css/ie8.css" rel="stylesheet">
    <script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- The following CSS are included as plugins and can be removed if unused-->

</head>
<body class="" style="background: url('images/16.jpg')">
<div class="container" id="login-form">
    <div class="row" style="padding-top: 8%">
        <div class="col-md-6 col-md-offset-3">
            <center>
            <div class="panel panel-teal">
                <div class="panel-heading">
                    <h2 style="font-size: 2em;">
						<table>
							<tr>
								<td><img style="" class="img-rounded" src="images/mflogo.png" height="50"></td>
								<td ><span style="margin-left: 4em">Login</span></td>
							</tr>
						</table>
					
					</h2>
                </div>
                <form method="post">
                <div class="panel-body">
						<center><i style="color: #2053ac;font-size: 10em" class="fa fa-unlock-alt"></i><center>

                        <div class="form-group mb-md">
                            <div class="col-xs-12">
                                <div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-user fa-2x"></i>
										</span>
                                    <input style="font-size: 2em;height:2em" type="text" class="form-control" name="Username" placeholder="Username" data-parsley-minlength="6" placeholder="At least 6 characters" required>
									
								</div>
                            </div>
                        </div>
<br><br><br>
                        <div class="form-group mb-md">
                            <div class="col-xs-12">
                                <div class="input-group">
										<span class="input-group-addon">
											<i class="fa fa-key fa-2x"></i>
										</span>
                                    <input style="font-size: 2em;height:2em" type="password" class="form-control" name="Password" id="exampleInputPassword1" placeholder="Password">
                                </div>
                            </div>
                        </div>
                </div>
                <div class="panel-footer">
                    <div class="clearfix">
						<center>
                        <button style="border-radius: 20px"  name="login_but" type="submit" class="btn btn-social btn-google"><i class="fa fa-sign-in fa-2x"></i>&nbsp;&nbsp; <span style="font-size: 2em;">Login</span></button>
						</center>
					</div>
                </div>
                </form>
            </div>
			</center>

        </div>
    </div>
</div>

<!-- Load site level scripts -->

<!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script> -->

<script type="text/javascript" src="assets/js/jquery-1.10.2.min.js"></script> 							<!-- Load jQuery -->
<script type="text/javascript" src="assets/js/jqueryui-1.10.3.min.js"></script> 							<!-- Load jQueryUI -->
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script> 								<!-- Load Bootstrap -->
<script type="text/javascript" src="assets/js/enquire.min.js"></script> 									<!-- Load Enquire -->

<script type="text/javascript" src="assets/plugins/velocityjs/velocity.min.js"></script>					<!-- Load Velocity for Animated Content -->
<script type="text/javascript" src="assets/plugins/velocityjs/velocity.ui.min.js"></script>

<script type="text/javascript" src="assets/plugins/wijets/wijets.js"></script>     						<!-- Wijet -->

<script type="text/javascript" src="assets/plugins/codeprettifier/prettify.js"></script> 				<!-- Code Prettifier  -->
<script type="text/javascript" src="assets/plugins/bootstrap-switch/bootstrap-switch.js"></script> 		<!-- Swith/Toggle Button -->

<script type="text/javascript" src="assets/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js"></script>  <!-- Bootstrap Tabdrop -->

<script type="text/javascript" src="assets/plugins/iCheck/icheck.min.js"></script>     					<!-- iCheck -->

<script type="text/javascript" src="assets/plugins/nanoScroller/js/jquery.nanoscroller.min.js"></script> <!-- nano scroller -->

<script type="text/javascript" src="assets/js/application.js"></script>
<script type="text/javascript" src="assets/demo/demo.js"></script>
<script type="text/javascript" src="assets/demo/demo-switcher.js"></script>

<!-- End loading site level scripts -->
<!-- Load page level scripts-->


<!-- End loading page level scripts-->
</body>
</html>
