<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Asian Banking School | Dashboard</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Morris chart -->
        <link href="css/morris/morris.css" rel="stylesheet" type="text/css" />
        <!-- jvectormap -->
        <link href="css/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <!-- fullCalendar -->
        <link href="css/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" />
        <!-- Daterange picker -->
        <link href="css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <!-- bootstrap wysihtml5 - text editor -->
        <link href="css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="css/AdminLTE.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <?php
   // GLOBAL $CFG;
        require_once("../And_config.php") ;
        ?>
    <body class="skin-blue" style="background-image: url('img/AIP-EID/padi.gif');background-repeat: no-repeat;background-position: center; position:relative; background-size:100% 100%;">

        <div class="form-box" id="login-box" style="opacity: 0.8;">
            <div class="header" style="opacity: 0.8;">Asian Banking School | Sign in</div>
            <form id='login' action="<?php echo $CFG->wwwroot; ?>/login/index.php" method="post" accept-charset="UTF-8" name="form1">
                <div class="body bg-light-gray">
                    <div class="form-group">
                        <input type="text" name="username" class="form-control" id="username" value="Enter your user name" onblur="if(this.value == '') {this.style='font-style:italic'; this.value='Enter your user name';}" onfocus="if (this.value == 'Enter your user name') {this.value=''; this.style='font-style:normal'; }" />
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" id="password" value="Enter your password" onblur="if(this.value == '') { this.type='text'; this.value='Enter your password';}" onfocus="if (this.value == 'Enter your password') {  this.value=''; this.type='password';}"/>
                    </div>          
                    <div class="form-group">
                        <input type="checkbox" name="remember_me"/><font color="white"> Remember me </font>
                    </div>
                </div>
                <div class="footer" style="opacity: 1.0;">        
					<input type="hidden" name="submitted" id="submitted" value="1"/>
                                        <input type="submit" class="btn bg-blue-aus btn-block" name="Submit" value="Sign me in" style="color:white;"/>
                    
                    <p><?php echo '<a href="'.$CFG->wwwroot.'/login/forgot_password.php" style="color:#202e61;">I forgot my password</a>'; ?></p>
                    
                    <?php  echo '<a href="'.$CFG->wwwroot.'/login/signup.php" style="color:#202e61;">Register a new membership</a>'; ?>
                </div>
            </form>

            <div class="margin text-center">
  
                <br/>

            </div>
        </div>


        <!-- jQuery 2.0.2 -->
        <script src="js/jquery.min.js"></script>
        <!-- jQuery UI 1.10.3 -->
        <script src="js/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <!-- Bootstrap -->
        <script src="js/bootstrap.min.js" type="text/javascript"></script>
        <!-- Morris.js charts -->
        <script src="js/raphael-min.js"></script>
        <script src="js/plugins/morris/morris.min.js" type="text/javascript"></script>
        <!-- Sparkline -->
        <script src="js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <!-- fullCalendar -->
        <script src="js/plugins/fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <script src="js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="js/AdminLTE/dashboard.js" type="text/javascript"></script>     

        <!-- AdminLTE for demo purposes -->
        <script src="js/AdminLTE/demo.js" type="text/javascript"></script>

    </body>
</html>