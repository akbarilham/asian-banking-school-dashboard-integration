<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Asian Banking School | Dashboard</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="css/font-awesome.css" rel="stylesheet" type="text/css" />        
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
        <link href="css/style.css" rel="stylesheet" type="text/css"  />
        <link href="fancybox/jquery.fancybox-1.3.1.css" rel="stylesheet" type="text/css"  media="screen" />
        <link href="css/jquery-ui.css" rel="stylesheet" type="text/css"  />
        

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
        <?php 
        
        require_once("../And_config.php") ; //this assumes your php file is in a subdirectory of your moodle 
		require_once("data.php") ; //databases

        if ($USER->id == 0) {
		require_login(); //Won't do any good to 'get' a username 'til sombody's logged in.
        }
        function file_rewrite_pluginfile_urls($text, $file, $contextid, $component, $filearea, $itemid, array $options=null) {
        $CFG = new stdClass();
                $options = (array)$options;
                if (!isset($options['forcehttps'])) {
                        $options['forcehttps'] = false;
                }
                $baseurl = "$CFG->wwwroot/pluginfile.php/$contextid/$component/$filearea/";

                if ($itemid !== null) {
                        $baseurl .= "$itemid/";
                }

                if ($options['forcehttps']) {
                        $baseurl = str_replace('http://', 'https://', $baseurl);
                }

           return str_replace('@@PLUGINFILE@@/', $baseurl, $text);
        }
            
        ?>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?php echo $CFG->wwwroot; ?>" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                <img src="img/AIP-EID/LOGO.png" />
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        
                        <?php 
                        $hasilpesan = array_search($USER->id, $arke);
                        //$hasilpesan2 = in_array($USER->id, $arke);
                        //$firsthasilpesan = reset($hasilpesan);
                        if($hasilpesan !== FALSE || $hasilpesan == TRUE){ 
                        ?>
                        <!-- Messages: style can be found in dropdown.less-->
                        <li class="dropdown messages-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope"></i>
                                <span class="label label-warning"><?php echo $arnotif[$hasilpesan]; ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have new <?php echo $arnotif[$hasilpesan]; ?> messages</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <?php for ($k=$hasilpesan;$k<$hasilpesan+$arnotif[$hasilpesan];$k++){ ?>
                                        <li><!-- start message -->
                                            <?php echo '<a href="'.$CFG->wwwroot.'/message/index.php?user1='.$USER->id.'&user2='.$ardari[$k].'">';?>
                                                <div class="pull-left">
                                                    <?php echo '<img src="'.$CFG->wwwroot.'/user/pix.php/'.$ardari[$k].' /f1.jpg" class="img-circle" alt="User Image" />' ?>
                                                </div>
                                                <h4>
                                                    <?php echo $arsubjek[$k]; ?>
                                                    <small><i class="fa fa-clock-o"></i><?php echo date('d/m/Y', $arwarpen[$k]); ?></small>
                                                </h4>
                                                <p><?php echo $arsmallmesej[$k]; ?></p>
                                            </a>
                                        </li><!-- end message -->
                                        <?php } ?>
                                    </ul>
                                </li>
                                <li class="footer"><?php echo $firsthasilpesan; echo '<a href="'.$CFG->wwwroot.'/message/index.php">';?> See All Messages</a></li>
                            </ul>
                        </li>
                        <?php
                        }
                        /*
                        ?>
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-warning"></i>
                                <span class="label label-warning">10</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 10 notifications</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-people info"></i> 5 new members joined today
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-warning danger"></i> Very long description here that may not fit into the page and may cause design problems
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-users warning"></i> 5 new members joined
                                            </a>
                                        </li>

                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-cart success"></i> 25 sales made
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="ion ion-ios7-person danger"></i> You changed your username
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="footer"><a href="#">View all</a></li>
                            </ul>
                        </li>
                        <!-- Tasks: style can be found in dropdown.less -->
                        <li class="dropdown tasks-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-tasks"></i>
                                <span class="label label-danger">9</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">You have 9 tasks</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Design some buttons
                                                    <small class="pull-right">20%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">20% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Create a nice theme
                                                    <small class="pull-right">40%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">40% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Some task I need to do
                                                    <small class="pull-right">60%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">60% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                        <li><!-- Task item -->
                                            <a href="#">
                                                <h3>
                                                    Make beautiful transitions
                                                    <small class="pull-right">80%</small>
                                                </h3>
                                                <div class="progress xs">
                                                    <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                        <span class="sr-only">80% Complete</span>
                                                    </div>
                                                </div>
                                            </a>
                                        </li><!-- end task item -->
                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="#">View all tasks</a>
                                </li>
                            </ul>
                        </li>
                         * 
                         */
                        ?>
                        
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo $USER->firstname; echo " "; echo $USER->lastname; ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header bg-blue-aus">
                                    <?php echo '<img src="'.$CFG->wwwroot.'/user/pix.php/'.$USER->id.'/f1.jpg" class="img-circle" alt="User Image" />'; ?>
                                    <p>
                                       <?php echo $USER->firstname; echo " "; echo $USER->lastname; ?> - <?php $hasilstatus = array_search($USER->id, $arucer); if($hasilstatus !== FALSE) { echo $arstatus[$hasilstatus]; ?>
                                        <small>AICB Member since <?php echo date('d/m/Y', $armembersince[$hasilstatus]); } ?></small>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body">
                                    <div class="col-xs-4 text-center">
                                        <?php echo '<a href="'.$CFG->wwwroot.'/badges/mybadges.php">Badges</a>';?>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <?php echo '<a href="'.$CFG->wwwroot.'/mod/forum/user.php?id='.$USER->id.'">Forum</a>';?>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <?php echo '<a href="'.$CFG->wwwroot.'/blog/index.php?userid='.$USER->id.'">Blog</a>';?>
                                    </div>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <?php echo '<a href="'.$CFG->wwwroot.'/user/profile.php?id='.$USER->id.'" class="btn btn-default btn-flat">Profile</a>' ;?>
                                    </div>
                                    <div class="pull-right">
                                        <a href="?log=1" class="btn btn-default btn-flat">Sign out</a>			
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <?php echo '<img src="'.$CFG->wwwroot.'/user/pix.php/'.$USER->id.'/f1.jpg" class="img-circle" alt="User Image" />'; ?>
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo $USER->firstname; ?></p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <br/>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="active">
                            <a href="index.php">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <?php echo'<a href="'.$CFG->wwwroot.'/my/">'; ?>
                                <i class="fa fa-home"></i> <span>My Home</span> 
                            </a>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-laptop"></i>
                                <span>Site Page</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <?php
                                echo '<li><a href="'.$CFG->wwwroot.'/blog/index.php?courseid=0"><i class="fa fa-tablet"></i> Site Blog</a></li>';
                                echo '<li><a href="'.$CFG->wwwroot.'/badges/view.php?type=1"><i class="fa fa-trophy"></i> Site Badges</a></li>';
                                echo '<li><a href="'.$CFG->wwwroot.'/tag/search.php"><i class="fa fa-tags"></i> Tags</a></li>';
                                echo '<li><a href="'.$CFG->wwwroot.'/calendar/view.php?view=month"><i class="fa fa-calendar"></i> Calendar</a></li>';
                                ?>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-users"></i> <span>My Profile</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <?php
                                echo '<li><a href="'.$CFG->wwwroot.'/user/profile.php?id='.$USER->id.'"><i class="fa fa-user"></i> View Profile</a></li>';
                                echo '<li><a href="'.$CFG->wwwroot.'/message/index.php"><i class="fa fa-envelope"></i> Messages</a></li>';
                                echo '<li><a href="'.$CFG->wwwroot.'/user/files.php"><i class="fa fa-lock"></i> My Private Files</a></li>';
                                echo '<li><a href="'.$CFG->wwwroot.'/badges/mybadges.php"><i class="fa fa-star"></i> My Badges</a></li>';
                                echo '<li><a href="'.$CFG->wwwroot.'/user/edit.php?id='.$USER->id.'&course='.$COURSE->id.'"><i class="fa fa-edit"></i> Edit Profile</a></li>';
                                echo '<li><a href="'.$CFG->wwwroot.'/login/change_password.php?id='.$USER->id.'"><i class="fa fa-gears"></i> Change Password</a></li>';
                                ?>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#">
                                <i class="fa fa-book"></i> <span>My Courses</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                                <?php
					if($USER->id == 2 OR $USER->id == 5 OR $USER->id == 6 OR $USER->id == 7 OR $USER->id == 8 OR $USER->id == 9 OR $USER->id == 10 OR $USER->id == 11 OR $USER->id == 12 OR $USER->id == 13 OR $USER->id == 14 OR $USER->id == 15 OR $USER->id == 16 OR $USER->id == 17 OR $USER->id == 18 OR $USER->id == 19){
					      for($i=1;$i<$resultrow2;$i++){
						echo '<li><a href="'.$CFG->wwwroot.'/course/view.php?id='.$arcourseidd[$i].'"><i class="fa fa-file"></i>'.$arcoursenamed[$i].'</a></li>';
						}
							}
								$studentenroll = array_search($USER->id, $arcourseidTS);
								$studentenroll2 = array_search('student', $arstatusnameTS);
								if($studentenroll !== FALSE && $studentenroll2 !== FALSE && $arstatusnameTS[$studentenroll2]){
									$hasilprogress5 = array_search($USER->id, $cc);
									$lasthasilprogress5 = array_search($USER->id, $arJmhEnrollCid);
									if ($hasilprogress5 !== FALSE && $lasthasilprogress5 !== FALSE) {
										for ($i=$hasilprogress5;$i<$hasilprogress5+$arJmhEnrollCourse[$lasthasilprogress5];$i++){
											$tmp2 = $aa[$i];
											$link2 = $bb[$i];
									echo '<li><a href="'.$CFG->wwwroot.'/course/view.php?id='.$link2.'"><i class="fa fa-file"></i>'.$tmp2.'</a></li>';
										}
									}
								}
								$teacherenroll = array_search($USER->id, $arcourseidTS);
								$teacherenroll2 = array_search('editingteacher', $arstatusnameTS);								
								if($teacherenroll !== FALSE && $teacherenroll2 !== FALSE && $arstatusnameTS[$teacherenroll2]){
									$Thasilprogress5 = array_search($USER->id, $Tcc);
									$Tlasthasilprogress5 = array_search($USER->id, $TarJmhEnrollCid); //Student 
									//$Tlasthasilprogress5 = array_search($USER->id, $TarJmhEnrollCid); //Teacher
									if ($Thasilprogress5 !== FALSE && $Tlasthasilprogress5 !== FALSE) {								
										for ($i=$Thasilprogress5;$i<$Thasilprogress5+$TarJmhEnrollCourse[$Tlasthasilprogress5];$i++){
											$Ttmp2 = $Taa[$i];
											$Tlink2 = $Tbb[$i];
									echo '<li><a href="'.$CFG->wwwroot.'/course/view.php?id='.$Tlink2.'"><i class="fa fa-file"></i>'.$Ttmp2.'</a></li>';									
										}
									}
								}									
                                ?>
                            </ul>
                        </li>
                        <?php if($USER->id == 2 OR $USER->id == 5 OR $USER->id == 6 OR $USER->id == 7 OR $USER->id == 8 OR $USER->id == 9 OR $USER->id == 10 OR $USER->id == 11 OR $USER->id == 12 OR $USER->id == 13 OR $USER->id == 14 OR $USER->id == 15 OR $USER->id == 16 OR $USER->id == 17 OR $USER->id == 18 OR $USER->id == 19){ 
                            echo '<li class="treeview">';
                            echo '<a href="#">';
                            echo '<i class="fa fa-folder"></i> <span>Site Administration</span>';
                            echo '<i class="fa fa-angle-left pull-right"></i>';
                            echo '</a>';
                            echo '<ul class="treeview-menu">';
                                echo '<li><a href="'.$CFG->wwwroot.'/admin/index.php"><i class="fa fa-exclamation-circle"></i> Notifications</a></li>';
                                echo '<li><a href="'.$CFG->wwwroot.'/admin/registration/register.php?huburl=http%3A%2F%2Fhub.moodle.org&hubname=Moodle.org"><i class="fa fa-check-square"></i> Registration</a></li>';
                                echo '<li><a href="'.$CFG->wwwroot.'/admin/cron.php"><i class="fa fa-bolt"></i> Cron</a></li>';                                
                                echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=optionalsubsystems"><i class="fa fa-archive"></i> Advanced Features</a></li>';
                                echo '<li class="treeview">';
                                echo '<a href="#">';
                                echo '<i class="fa fa-folder-o"></i> <span>Users</span>';
                                echo '<i class="fa fa-angle-left pull-right"></i>';
                                echo '</a>';
                                echo '<ul class="treeview-menu">';
                                    echo '<li class="treeview">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-sign-in"></i> <span>Account</span>';
                                    echo '<i class="fa fa-angle-left pull-right"></i>';
                                    echo '</a>';
                                    echo '<ul class="treeview-menu">';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/user.php"><i class="fa fa-angle-double-right"></i> Browse list of users</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/user/user_bulk.php"><i class="fa fa-angle-double-right"></i> Bulk user actions</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/user/editadvanced.php?id=-1"><i class="fa fa-angle-double-right"></i> Add a new user</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/user/profile/index.php"><i class="fa fa-angle-double-right"></i> User profile fields</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/cohort/index.php"><i class="fa fa-angle-double-right"></i> Cohorts</a></li>';                                         
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/tool/uploaduser/index.php"><i class="fa fa-angle-double-right"></i> Upload users</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/tool/uploaduser/picture.php"><i class="fa fa-angle-double-right"></i> Upload user pictures</a></li>';                                              
                                    echo '</ul>';
                                    echo '</li>';                             
                                    echo '<li class="treeview">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-sign-in"></i> <span>Permissions</span>';
                                    echo '<i class="fa fa-angle-left pull-right"></i>';
                                    echo '</a>';
                                    echo '<ul class="treeview-menu">';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=userpolicies"><i class="fa fa-angle-double-right"></i> User policies</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/roles/admins.php"><i class="fa fa-angle-double-right"></i> Site administrators</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/roles/manage.php"><i class="fa fa-angle-double-right"></i> Define roles</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/roles/assign.php?contextid=1"><i class="fa fa-angle-double-right"></i> Assign system roles</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/roles/check.php?contextid=1"><i class="fa fa-angle-double-right"></i> Check system permissions</a></li>';                                                                               
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/tool/capability/index.php"><i class="fa fa-angle-double-right"></i> Capability overview</a></li>';                                        
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/tool/unsuproles/index.php"><i class="fa fa-angle-double-right"></i> Unsupported role assignments</a></li>';                                                                                                                  
                                    echo '</ul>';
                                    echo '</li>';
                                echo '</ul>';
                                echo '</li>';  
                                echo '<li class="treeview">';
                                echo '<a href="#">';
                                echo '<i class="fa fa-folder-o"></i> <span>Courses</span>';
                                echo '<i class="fa fa-angle-left pull-right"></i>';
                                echo '</a>';
                                echo '<ul class="treeview-menu">';    
                                    echo '<li><a href="'.$CFG->wwwroot.'/course/manage.php"><i class="fa fa-angle-double-right"></i> Add/edit courses</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=coursesettings"><i class="fa fa-angle-double-right"></i> Course default settings</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=courserequest"><i class="fa fa-angle-double-right"></i> Course request</a></li>';
                                    echo '<li class="treeview">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-sign-in"></i> <span>Backup</span>';
                                    echo '<i class="fa fa-angle-left pull-right"></i>';
                                    echo '</a>';
                                    echo '<ul class="treeview-menu">';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=backupgeneralsettings"><i class="fa fa-angle-double-right"></i> General backup default</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=importgeneralsettings"><i class="fa fa-angle-double-right"></i> General import default</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=automated"><i class="fa fa-angle-double-right"></i> Automatic backup setup</a></li>';
                                    echo '</ul>';
                                    echo '</li>';                                                                        
                                echo '</ul>';
                                echo '</li>';
                                echo '<li class="treeview">';
                                echo '<a href="#">';
                                echo '<i class="fa fa-folder-o"></i> <span>Grades</span>';
                                echo '<i class="fa fa-angle-left pull-right"></i>';
                                echo '</a>';
                                echo '<ul class="treeview-menu">';  
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=gradessettings"><i class="fa fa-angle-double-right"></i> General settings</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=gradecategorysettings"><i class="fa fa-angle-double-right"></i> Grade category settings</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=gradeitemsettings"><i class="fa fa-angle-double-right"></i> Grade item settings</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/grade/edit/scale/index.php"><i class="fa fa-angle-double-right"></i> Scales</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/grade/edit/letter/index.php"><i class="fa fa-angle-double-right"></i> Letters</a></li>';                                    
                                    echo '<li class="treeview">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-sign-in"></i> <span>Report settings</span>';
                                    echo '<i class="fa fa-angle-left pull-right"></i>';
                                    echo '</a>';
                                    echo '<ul class="treeview-menu">';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=gradereportgrader"><i class="fa fa-angle-double-right"></i> Grader report</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=gradereportoverview"><i class="fa fa-angle-double-right"></i> Overview report</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=gradereportuser"><i class="fa fa-angle-double-right"></i> User report</a></li>';
                                    echo '</ul>';
                                    echo '</li>';                                                                                                            
                                echo '</ul>';
                                echo '</li>';                               
                                echo '<li class="treeview">';
                                echo '<a href="#">';
                                echo '<i class="fa fa-folder-o"></i> <span>Badges</span>';
                                echo '<i class="fa fa-angle-left pull-right"></i>';
                                echo '</a>';
                                echo '<ul class="treeview-menu">';    
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=badgesettings"><i class="fa fa-angle-double-right"></i> Badge settings</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/badges/index.php?type=1"><i class="fa fa-angle-double-right"></i> Manage Badges</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/badges/newbadge.php?type=1"><i class="fa fa-angle-double-right"></i> Add a new badge</a></li>';                                
                                echo '</ul>';
                                echo '</li>';                               
                                echo '<li class="treeview">';
                                echo '<a href="#">';
                                echo '<i class="fa fa-folder-o"></i> <span>Location</span>';
                                echo '<i class="fa fa-angle-left pull-right"></i>';
                                echo '</a>';
                                echo '<ul class="treeview-menu">';          
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=locationsettings"><i class="fa fa-angle-double-right"></i> Location settings</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/tool/timezoneimport/index.php"><i class="fa fa-angle-double-right"></i> Update timezone</a></li>';                                
                                echo '</ul>';
                                echo '</li>';                               
                                echo '<li class="treeview">';
                                echo '<a href="#">';
                                echo '<i class="fa fa-folder-o"></i> <span>Language</span>';
                                echo '<i class="fa fa-angle-left pull-right"></i>';
                                echo '</a>';
                                echo '<ul class="treeview-menu">';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=langsettings"><i class="fa fa-angle-double-right"></i> Language settings</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/tool/customlang/index.php"><i class="fa fa-angle-double-right"></i> Language customisation</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/tool/langimport/index.php"><i class="fa fa-angle-double-right"></i> Language packs</a></li>';                                                                
                                echo '</ul>';
                                echo '</li>';                               
                                echo '<li class="treeview">';
                                echo '<a href="#">';
                                echo '<i class="fa fa-folder-o"></i> <span>Plugins</span>';
                                echo '<i class="fa fa-angle-left pull-right"></i>';
                                echo '</a>';
                                echo '<ul class="treeview-menu">';          
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/plugins.php"><i class="fa fa-angle-double-right"></i> Plugins overview</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/tool/installaddon/index.php"><i class="fa fa-angle-double-right"></i> Install add-ons</a></li>';                                   
                                    echo '<li class="treeview">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-sign-in"></i> <span>Activiy modules</span>';
                                    echo '<i class="fa fa-angle-left pull-right"></i>';
                                    echo '</a>';
                                    echo '<ul class="treeview-menu">';      
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/modules.php"><i class="fa fa-angle-double-right"></i> Manage activities</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=modsettingassign"><i class="fa fa-angle-double-right"></i> Assignment</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=modsettingbook"><i class="fa fa-angle-double-right"></i> Book</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=modsettingcertificate"><i class="fa fa-angle-double-right"></i> Certificate</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=modsettingchat"><i class="fa fa-angle-double-right"></i> Chat</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=modsettingdata"><i class="fa fa-angle-double-right"></i> Database</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=modsettingfolder"><i class="fa fa-angle-double-right"></i> Folder</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=modsettingforum"><i class="fa fa-angle-double-right"></i> Forum</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=modsettingglossary"><i class="fa fa-angle-double-right"></i> Glossary</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=modsettingimscp"><i class="fa fa-angle-double-right"></i> IMS Content Package</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=modsettinglabel"><i class="fa fa-angle-double-right"></i> Label</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=modsettinglesson"><i class="fa fa-angle-double-right"></i> Lesson</a></li>';                                        
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=modsettinglti"><i class="fa fa-angle-double-right"></i> LTI</a></li>';                                        
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=modsettingpage"><i class="fa fa-angle-double-right"></i> Page</a></li>';                                        
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=modsettingquiz"><i class="fa fa-angle-double-right"></i> Quiz</a></li>';                                        
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=modsettingresource"><i class="fa fa-angle-double-right"></i> File</a></li>';                                        
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=modsettingscorm"><i class="fa fa-angle-double-right"></i> SCORM package</a></li>';                                        
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=modsettingurl"><i class="fa fa-angle-double-right"></i> URL</a></li>';                                        
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=modsettingworkshop"><i class="fa fa-angle-double-right"></i> Workshop</a></li>';                                        
                                    echo '</ul>';
                                    echo '</li>';
                                    echo '<li class="treeview">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-sign-in"></i> <span>Assignment plugins</span>';
                                    echo '<i class="fa fa-angle-left pull-right"></i>';
                                    echo '</a>';
                                    echo '<ul class="treeview-menu">';          
                                        echo '<li class="treeview">';
                                        echo '<a href="#">';
                                        echo '<i class="fa fa-asterisk"></i> <span>Submissions plugins</span>';
                                        echo '<i class="fa fa-angle-left pull-right"></i>';
                                        echo '</a>';
                                        echo '<ul class="treeview-menu">';          
                                            echo '<li><a href="'.$CFG->wwwroot.'/mod/assign/adminmanageplugins.php?subtype=assignsubmission"><i class="fa fa-angle-double-right"></i> Manage assignment submission plugins</a></li>';
                                            echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=assignsubmission_file"><i class="fa fa-angle-double-right"></i> File submissions</a></li>';
                                            echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=assignsubmission_onlinetext"><i class="fa fa-angle-double-right"></i> Online text submissions</a></li>';
                                            echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=assignsubmission_comments"><i class="fa fa-angle-double-right"></i> Submission comments</a></li>';
                                        echo '</ul>';
                                        echo '</li>';                                    
                                        echo '<li class="treeview">';
                                        echo '<a href="#">';
                                        echo '<i class="fa fa-asterisk"></i> <span>Feedback plugins</span>';
                                        echo '<i class="fa fa-angle-left pull-right"></i>';
                                        echo '</a>';
                                        echo '<ul class="treeview-menu">';          
                                             echo '<li><a href="'.$CFG->wwwroot.'/mod/assign/adminmanageplugins.php?subtype=assignfeedback"><i class="fa fa-angle-double-right"></i> Manage assignment feedback plugins</a></li>';
                                             echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=assignfeedback_comments"><i class="fa fa-angle-double-right"></i> Feedback comments</a></li>';
                                             echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=assignfeedback_file"><i class="fa fa-angle-double-right"></i> File feedback</a></li>';
                                             echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=assignfeedback_offline"><i class="fa fa-angle-double-right"></i> Offline grading worksheet</a></li>';
                                        echo '</ul>';
                                        echo '</li>';                                                                            
                                    echo '</ul>';
                                    echo '</li>';  
                                    echo '<li class="treeview">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-sign-in"></i> <span>Course formats</span>';
                                    echo '<i class="fa fa-angle-left pull-right"></i>';
                                    echo '</a>';
                                    echo '<ul class="treeview-menu">';    
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=manageformats"><i class="fa fa-angle-double-right"></i> Manage course formats</a></li>';
                                    echo '</ul>';
                                    echo '</li>';
                                    echo '<li class="treeview">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-sign-in"></i> <span>Blocks</span>';
                                    echo '<i class="fa fa-angle-left pull-right"></i>';
                                    echo '</a>';
                                    echo '<ul class="treeview-menu">';    
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/blocks.php"><i class="fa fa-angle-double-right"></i> Manage blocks</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=blocksettingcourse_list"><i class="fa fa-angle-double-right"></i> Courses</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=blocksettinghtml"><i class="fa fa-angle-double-right"></i> HTML</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/settings.php?section=blocksettingrss_client"><i class="fa fa-angle-double-right"></i> Remote RSS feeds</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=blocksettingsection_links"><i class="fa fa-angle-double-right"></i> Section links</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=blocksettingtags"><i class="fa fa-angle-double-right"></i> Tags</a></li>';
                                    echo '</ul>';
                                    echo '</li>';
                                    echo '<li class="treeview">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-sign-in"></i> <span>Message outputs</span>';
                                    echo '<i class="fa fa-angle-left pull-right"></i>';
                                    echo '</a>';
                                    echo '<ul class="treeview-menu">';    
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/message.php"><i class="fa fa-angle-double-right"></i> Manage message outputs</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/message/defaultoutputs.php"><i class="fa fa-angle-double-right"></i> Default message outputs</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=messagesettingemail"><i class="fa fa-angle-double-right"></i> Email</a></li>';
                                    echo '</ul>';
                                    echo '</li>';             
                                    echo '<li class="treeview">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-sign-in"></i> <span>Authentication</span>';
                                    echo '<i class="fa fa-angle-left pull-right"></i>';
                                    echo '</a>';
                                    echo '<ul class="treeview-menu">';    
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=manageauths"><i class="fa fa-angle-double-right"></i> Manage Authentication</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/auth_config.php?auth=email"><i class="fa fa-angle-double-right"></i> Email-based self-registration</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/auth_config.php?auth=manual"><i class="fa fa-angle-double-right"></i> Manual accounts</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/auth_config.php?auth=nologin"><i class="fa fa-angle-double-right"></i> No login</a></li>';
                                    echo '</ul>';
                                    echo '</li>';  
                                    echo '<li class="treeview">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-sign-in"></i> <span>Enrolments</span>';
                                    echo '<i class="fa fa-angle-left pull-right"></i>';
                                    echo '</a>';
                                    echo '<ul class="treeview-menu">';  
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=manageenrols"><i class="fa fa-angle-double-right"></i> Manage enrol plugins</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=enrolsettingscohort"><i class="fa fa-angle-double-right"></i> Cohort sync</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=enrolsettingsguest"><i class="fa fa-angle-double-right"></i> Guest access</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=enrolsettingsmanual"><i class="fa fa-angle-double-right"></i> Manual enrolments</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=enrolsettingsself"><i class="fa fa-angle-double-right"></i> Self enrolments</a></li>';
                                    echo '</ul>';
                                    echo '</li>';
                                    echo '<li class="treeview">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-sign-in"></i> <span>Text editors</span>';
                                    echo '<i class="fa fa-angle-left pull-right"></i>';
                                    echo '</a>';
                                    echo '<ul class="treeview-menu">';    
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=manageeditors"><i class="fa fa-angle-double-right"></i> Manage editors</a></li>';
                                        echo '<li class="treeview">';
                                        echo '<a href="#">';
                                        echo '<i class="fa fa-asterisk"></i> <span>TinyMCE HTML editor</span>';
                                        echo '<i class="fa fa-angle-left pull-right"></i>';
                                        echo '</a>';
                                        echo '<ul class="treeview-menu">';    
                                             echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=editorsettingstinymce"><i class="fa fa-angle-double-right"></i> General settings</a></li>';
                                             echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=tinymcedragmathsettings"><i class="fa fa-angle-double-right"></i> Insert equation</a></li>';
                                             echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=tinymcemoodleemoticonsettings"><i class="fa fa-angle-double-right"></i> Insert emoticon</a></li>';
                                             echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=tinymcespellcheckersettings"><i class="fa fa-angle-double-right"></i> Legacy spell checker</a></li>'; 
                                        echo '</ul>';
                                        echo '</li>';
                                    echo '</ul>';
                                    echo '</li>';                                    
                                    echo '<li class="treeview">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-sign-in"></i> <span>Licenses</span>';
                                    echo '<i class="fa fa-angle-left pull-right"></i>';
                                    echo '</a>';
                                    echo '<ul class="treeview-menu">';    
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=managelicenses"><i class="fa fa-angle-double-right"></i> Manage licences</a></li>';
                                    echo '</ul>';
                                    echo '</li>';                                                                        
                                    echo '<li class="treeview">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-sign-in"></i> <span>Filters</span>';
                                    echo '<i class="fa fa-angle-left pull-right"></i>';
                                    echo '</a>';
                                    echo '<ul class="treeview-menu">';    
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/filters.php"><i class="fa fa-angle-double-right"></i> Manage filters</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=commonfiltersettings"><i class="fa fa-angle-double-right"></i> Common filter settings</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=filtersettingurltolink"><i class="fa fa-angle-double-right"></i> Convert URLs into links and images</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=filtersettingemoticon"><i class="fa fa-angle-double-right"></i> Display emoticons as images</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=filtersettingmultilang"><i class="fa fa-angle-double-right"></i> Multi-Language Content</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=filtersettingtex"><i class="fa fa-angle-double-right"></i> TeX notation</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=filtersettingcensor"><i class="fa fa-angle-double-right"></i> Word censorship</a></li>';
                                    echo '</ul>';
                                    echo '</li>';     
                                    echo '<li class="treeview">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-sign-in"></i> <span>Repositories</span>';
                                    echo '<i class="fa fa-angle-left pull-right"></i>';
                                    echo '</a>';
                                    echo '<ul class="treeview-menu">';    
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/repository.php"><i class="fa fa-angle-double-right"></i> Manage repositories</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=blocksettingtags"><i class="fa fa-angle-double-right"></i> Common repository settings</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/repository.php?sesskey='.$USER->sesskey.'=edit&repos=local"><i class="fa fa-angle-double-right"></i> Server files</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/repository.php?sesskey='.$USER->sesskey.'=edit&repos=recent"><i class="fa fa-angle-double-right"></i> Recent files</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/repository.php?sesskey='.$USER->sesskey.'=edit&repos=upload"><i class="fa fa-angle-double-right"></i> Upload a file</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/repository.php?sesskey='.$USER->sesskey.'=edit&repos=url"><i class="fa fa-angle-double-right"></i> URL downloader</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/repository.php?sesskey='.$USER->sesskey.'=edit&repos=user"><i class="fa fa-angle-double-right"></i> Private files</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/repository.php?sesskey='.$USER->sesskey.'=edit&repos=wikimedia"><i class="fa fa-angle-double-right"></i> Wikimedia</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/repository.php?sesskey='.$USER->sesskey.'=edit&repos=youtube"><i class="fa fa-angle-double-right"></i> Youtube videos</a></li>';
                                    echo '</ul>';
                                    echo '</li>';          
                                    echo '<li class="treeview">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-sign-in"></i> <span>Web services</span>';
                                    echo '<i class="fa fa-angle-left pull-right"></i>';
                                    echo '</a>';
                                    echo '<ul class="treeview-menu">';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=mobile"><i class="fa fa-angle-double-right"></i> Mobile</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=webservicesoverview"><i class="fa fa-angle-double-right"></i> Overview</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/webservice/documentation.php"><i class="fa fa-angle-double-right"></i> API Documentation</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=externalservices"><i class="fa fa-angle-double-right"></i> External services</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=webserviceprotocols"><i class="fa fa-angle-double-right"></i> Manage protocols</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=webservicetokens"><i class="fa fa-angle-double-right"></i> Manage tokens</a></li>';
                                    echo '</ul>';
                                    echo '</li>';          
                                    echo '<li class="treeview">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-sign-in"></i> <span>Question behaviours</span>';
                                    echo '<i class="fa fa-angle-left pull-right"></i>';
                                    echo '</a>';
                                    echo '<ul class="treeview-menu">';    
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/qbehaviours.php"><i class="fa fa-angle-double-right"></i> Manage question behaviours</a></li>';
                                    echo '</ul>';
                                    echo '</li>';          
                                    echo '<li class="treeview">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-sign-in"></i> <span>Question types</span>';
                                    echo '<i class="fa fa-angle-left pull-right"></i>';
                                    echo '</a>';
                                    echo '<ul class="treeview-menu">';    
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/qtypes.php"><i class="fa fa-angle-double-right"></i> Manage question types</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=qdefaultsetting"><i class="fa fa-angle-double-right"></i> Question preview defaults</a></li>';
                                    echo '</ul>';
                                    echo '</li>';          
                                    echo '<li class="treeview">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-sign-in"></i> <span>Reports</span>';
                                    echo '<i class="fa fa-angle-left pull-right"></i>';
                                    echo '</a>';
                                    echo '<ul class="treeview-menu">';    
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/reports.php"><i class="fa fa-angle-double-right"></i> Manage reports</a></li>';
                                    echo '</ul>';
                                    echo '</li>';          
                                    echo '<li class="treeview">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-sign-in"></i> <span>Admin tools</span>';
                                    echo '<i class="fa fa-angle-left pull-right"></i>';
                                    echo '</a>';
                                    echo '<ul class="treeview-menu">';    
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/tools.php"><i class="fa fa-angle-double-right"></i> Manage admin tools</a></li>';
                                    echo '</ul>';
                                    echo '</li>';          
                                    echo '<li class="treeview">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-sign-in"></i> <span>Caching</span>';
                                    echo '<i class="fa fa-angle-left pull-right"></i>';
                                    echo '</a>';
                                    echo '<ul class="treeview-menu">';    
                                        echo '<li><a href="'.$CFG->wwwroot.'/cache/admin.php"><i class="fa fa-angle-double-right"></i> Configuration</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/cache/testperformance.php"><i class="fa fa-angle-double-right"></i> Test Performance</a></li>';
                                        echo '<li class="treeview">';
                                        echo '<a href="#">';
                                        echo '<i class="fa fa-asterisk"></i> <span>Cache stores</span>';
                                        echo '<i class="fa fa-angle-left pull-right"></i>';
                                        echo '</a>';
                                        echo '<ul class="treeview-menu">';    
                                            echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=cachestore_memcache_settings"><i class="fa fa-angle-double-right"></i> Memcache</a></li>';
                                            echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=cachestore_memcached_settings"><i class="fa fa-angle-double-right"></i> Memcached</a></li>';
                                            echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=cachestore_mongodb_settings"><i class="fa fa-angle-double-right"></i> MongoDB</a></li>';
                                        echo '</ul>';
                                        echo '</li>';
                                    echo '</ul>';
                                    echo '</li>';          
                                    echo '<li class="treeview">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-sign-in"></i> <span>Local plugins</span>';
                                    echo '<i class="fa fa-angle-left pull-right"></i>';
                                    echo '</a>';
                                    echo '<ul class="treeview-menu">';    
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/localplugins.php"><i class="fa fa-angle-double-right"></i> Manage local plugins</a></li>';
                                    echo '</ul>';
                                    echo '</li>';                                              
                                echo '</ul>';
                                echo '</li>';                               
                                echo '<li class="treeview">';
                                echo '<a href="#">';
                                echo '<i class="fa fa-folder-o"></i> <span>Security</span>';
                                echo '<i class="fa fa-angle-left pull-right"></i>';
                                echo '</a>';
                                echo '<ul class="treeview-menu">';          
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=ipblocker"><i class="fa fa-angle-double-right"></i> IP blocker</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=sitepolicies"><i class="fa fa-angle-double-right"></i> Site policies</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=httpsecurity"><i class="fa fa-angle-double-right"></i> HTTP security</a></li>';                                                                
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=notifications"><i class="fa fa-angle-double-right"></i> Notifications</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=antivirus"><i class="fa fa-angle-double-right"></i> Anti-Virus</a></li>';                                
                                echo '</ul>';
                                echo '</li>';  
                                echo '<li class="treeview">';
                                echo '<a href="#">';
                                echo '<i class="fa fa-folder-o"></i> <span>Appearance</span>';
                                echo '<i class="fa fa-angle-left pull-right"></i>';
                                echo '</a>';
                                echo '<ul class="treeview-menu">';  
                                    echo '<li class="treeview">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-sign-in"></i> <span>Themes</span>';
                                    echo '<i class="fa fa-angle-left pull-right"></i>';
                                    echo '</a>';
                                    echo '<ul class="treeview-menu">';    
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=themesettings"><i class="fa fa-angle-double-right"></i> Theme settings</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/theme/index.php"><i class="fa fa-angle-double-right"></i> Theme selector</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=themesettingafterburner"><i class="fa fa-angle-double-right"></i> Afterburner</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=antivirus"><i class="fa fa-angle-double-right"></i> Anomaly</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=antivirus"><i class="fa fa-angle-double-right"></i> Arialist</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=antivirus"><i class="fa fa-angle-double-right"></i> Brick</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=antivirus"><i class="fa fa-angle-double-right"></i> Clean</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=antivirus"><i class="fa fa-angle-double-right"></i> Format white</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=antivirus"><i class="fa fa-angle-double-right"></i> Fusion</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=antivirus"><i class="fa fa-angle-double-right"></i> Magazine</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=antivirus"><i class="fa fa-angle-double-right"></i> Nimble</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=antivirus"><i class="fa fa-angle-double-right"></i> Nonzero</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=antivirus"><i class="fa fa-angle-double-right"></i> Overlay</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=antivirus"><i class="fa fa-angle-double-right"></i> Sky High</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=antivirus"><i class="fa fa-angle-double-right"></i> Splash</a></li>';
                                    echo '</ul>';
                                    echo '</li>';                             
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=calendar"><i class="fa fa-angle-double-right"></i> Calendar</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=blog"><i class="fa fa-angle-double-right"></i> Blog</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=navigation"><i class="fa fa-angle-double-right"></i> Navigation</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=htmlsettings"><i class="fa fa-angle-double-right"></i> HTML settings</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=mediasettings"><i class="fa fa-angle-double-right"></i> Media embedding</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=documentation"><i class="fa fa-angle-double-right"></i> Moodle Docs</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/my/indexsys.php"><i class="fa fa-angle-double-right"></i> Default My home page</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/user/profilesys.php"><i class="fa fa-angle-double-right"></i> Default profile page</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=coursecontact"><i class="fa fa-angle-double-right"></i> Courses</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=ajax"><i class="fa fa-angle-double-right"></i> Ajax and Javascript</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/tag/manage.php"><i class="fa fa-angle-double-right"></i> Manage tags</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=additionalhtml"><i class="fa fa-angle-double-right"></i> Additional HTML</a></li>';
                                echo '</ul>';
                                echo '</li>';                                    
                                echo '<li class="treeview">';
                                echo '<a href="#">';
                                echo '<i class="fa fa-folder-o"></i> <span>Front Page</span>';
                                echo '<i class="fa fa-angle-left pull-right"></i>';
                                echo '</a>';
                                echo '<ul class="treeview-menu">';          
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=frontpagesettings"><i class="fa fa-angle-double-right"></i> Front page settings</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/roles/assign.php?contextid=2"><i class="fa fa-angle-double-right"></i> Front page roles</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/filter/manage.php?contextid=2"><i class="fa fa-angle-double-right"></i> Front page filters</a></li>';                                                                                                
                                    echo '<li><a href="'.$CFG->wwwroot.'/backup/backup.php?id=1"><i class="fa fa-angle-double-right"></i> Front page backup</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/backup/restorefile.php?contextid=2"><i class="fa fa-angle-double-right"></i> Front page restore</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/question/edit.php?courseid=1"><i class="fa fa-angle-double-right"></i> Front page questions</a></li>';                                                                                                    
                                echo '</ul>';
                                echo '</li>';                               
                                echo '<li class="treeview">';
                                echo '<a href="#">';
                                echo '<i class="fa fa-folder-o"></i> <span>Server</span>';
                                echo '<i class="fa fa-angle-left pull-right"></i>';
                                echo '</a>';
                                echo '<ul class="treeview-menu">';  
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=systempaths"><i class="fa fa-angle-double-right"></i> System paths</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=supportcontact"><i class="fa fa-angle-double-right"></i> Support contact</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/filter/manage.php?contextid=2"><i class="fa fa-angle-double-right"></i> Session handling</a></li>';                                                                                                
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=stats"><i class="fa fa-angle-double-right"></i> Statistics</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=http"><i class="fa fa-angle-double-right"></i> HTTP</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=maintenancemode"><i class="fa fa-angle-double-right"></i> Maintenance mode</a></li>';                                                                                                    
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=cleanup"><i class="fa fa-angle-double-right"></i> Cleanup</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/environment.php"><i class="fa fa-angle-double-right"></i> Environment</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/phpinfo.php"><i class="fa fa-angle-double-right"></i> PHP info</a></li>';                                                                                                
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=performance"><i class="fa fa-angle-double-right"></i> Performance</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/registration/index.php"><i class="fa fa-angle-double-right"></i> Hubs</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=updatenotifications"><i class="fa fa-angle-double-right"></i> Update notifications</a></li>';                                                                                                                                        
                                echo '</ul>';
                                echo '</li>';                                
                                echo '<li class="treeview">';
                                echo '<a href="#">';
                                echo '<i class="fa fa-folder-o"></i> <span>Reports</span>';
                                echo '<i class="fa fa-angle-left pull-right"></i>';
                                echo '</a>';
                                echo '<ul class="treeview-menu">';          
                                    echo '<li><a href="'.$CFG->wwwroot.'/comment/"><i class="fa fa-angle-double-right"></i> Comments</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/report/backups/index.php"><i class="fa fa-angle-double-right"></i> Backup</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/report/configlog/index.php"><i class="fa fa-angle-double-right"></i> Config change</a></li>';                                                                                                
                                    echo '<li><a href="'.$CFG->wwwroot.'/report/courseoverview/index.php"><i class="fa fa-angle-double-right"></i> Course overview</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/report/log/index.php?id=1"><i class="fa fa-angle-double-right"></i> Logs</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/report/loglive/index.php"><i class="fa fa-angle-double-right"></i> Live logs</a></li>';                                                                                                    
                                    echo '<li><a href="'.$CFG->wwwroot.'/report/overviewstats/index.php"><i class="fa fa-angle-double-right"></i> Overview Statistics</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/report/performance/index.php"><i class="fa fa-angle-double-right"></i> Performance overview</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/report/questioninstances/index.php"><i class="fa fa-angle-double-right"></i> Question instances</a></li>';                                                                                                
                                    echo '<li><a href="'.$CFG->wwwroot.'/report/security/index.php"><i class="fa fa-angle-double-right"></i> Security overview</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/report/stats/index.php"><i class="fa fa-angle-double-right"></i> Statistics</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/tool/spamcleaner/index.php"><i class="fa fa-angle-double-right"></i> Spam Cleaner</a></li>';                                                                                                                                                                        
                                echo '</ul>';
                                echo '</li>';                               
                                echo '<li class="treeview">';
                                echo '<a href="#">';
                                echo '<i class="fa fa-folder-o"></i> <span>Development</span>';
                                echo '<i class="fa fa-angle-left pull-right"></i>';
                                echo '</a>';
                                echo '<ul class="treeview-menu">';   
                                    echo '<li class="treeview">';
                                    echo '<a href="#">';
                                    echo '<i class="fa fa-sign-in"></i> <span>Experimental</span>';
                                    echo '<i class="fa fa-angle-left pull-right"></i>';
                                    echo '</a>';
                                    echo '<ul class="treeview-menu">';          
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=experimentalsettings"><i class="fa fa-angle-double-right"></i> Experimental settings</a></li>';
                                        echo '<li><a href="'.$CFG->wwwroot.'/admin/tool/dbtransfer/index.php"><i class="fa fa-angle-double-right"></i> Database migration</a></li>';
                                    echo '</ul>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/settings.php?section=debugging"><i class="fa fa-angle-double-right"></i> Debugging</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/webservice/testclient.php"><i class="fa fa-angle-double-right"></i> Web services client test</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/purgecaches.php"><i class="fa fa-angle-double-right"></i> Purge all caches</a></li>';                                                                                                
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/tool/behat/index.php"><i class="fa fa-angle-double-right"></i> Acceptance testing</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/tool/phpunit/index.php"><i class="fa fa-angle-double-right"></i> PHPUnit Tests</a></li>';
                                    echo '<li><a href="'.$CFG->wwwroot.'/admin/tool/xmldb/"><i class="fa fa-angle-double-right"></i> XMLDB Editor</a></li>';                                                                                                                                        
                                echo '</ul>';
                                echo '<li><a href="'.$CFG->wwwroot.'/admin/tool/assignmentupgrade/index.php"><i class="fa fa-gear"></i> Assignment upgrade helper</a></li>';
                                echo '<li><a href="'.$CFG->wwwroot.'/admin/tool/qeupgradehelper/index.php"><i class="fa fa-gear"></i> Question engine upgrade helper</a></li>';                                
                                echo '</li>';                                                               
                            echo '</ul>';
                            echo '</li>';
                         }  ?>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
                <!-- Content Header (Page header) -->
                <section class="content-header" >
                    <h1>
                        Dashboard
                        <small>Control panel</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-trello"></i> Home</a></li>
                        <li class="active">Dashboard</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <!-- Small boxes (Stat box) --> 
                <div id="content">
                <div class="row">
                    <div class="gallery-wrap">
                        <div class="gallery clearfix">
							<?php 
									if ($USER->id == 2) {
										for ($i=0;$i<$resultrow22;$i++){
											$tmp5 = $arcoursenamed2[$i];
											$link5 = $arcourseidd2[$i];
											$idgmbr5 = $arcoursegambarid2[$i];
											$gmbr5 = $arcoursegambard2[$i];							
							?>
								<div class="gallery__item">
								<div class="col-lg-3 col-xs-6">
									<!-- small box -->
									<div class="gallery__img" >
									<?php 
									  echo '<img src="'.$CFG->wwwroot.'/pluginfile.php/'.$idgmbr5.'/course/summary/'.$gmbr5.'" style="position: relative; width: 252px; height: 189px;" />';
									?>
									<div class="small-box bg-light-blue" >
										<div class="inner">
										   <p color="white">
											 <?php echo $tmp5;?>
										   </p>
										</div>
										<?php echo '<a href="'.$CFG->wwwroot.'/course/view.php?id='.$link5.'" class="small-box-footer">'?>
										Click Course <i class="fa fa-arrow-circle-right"></i></a>
									</div>
									</div>
								</div>
								</div><!-- ./col -->						
							<?php 
									}
								}
								//IF Student
								$studentenroll = array_search($USER->id, $arcourseidTS);
								$studentenroll2 = array_search('student', $arstatusnameTS);
								//echo $arstatusnameTS[$studentenroll];
								if($studentenroll !== FALSE && $studentenroll2 !== FALSE && $arstatusnameTS[$studentenroll2]){
									//COURSE ENROLL LIST STUDENT
									$hasilprogress5 = array_search($USER->id, $cc);
									$lasthasilprogress5 = array_search($USER->id, $arJmhEnrollCid); //Student 
									//$Tlasthasilprogress5 = array_search($USER->id, $TarJmhEnrollCid); //Teacher
									if ($hasilprogress5 !== FALSE && $lasthasilprogress5 !== FALSE) {
										for ($i=$hasilprogress5;$i<$hasilprogress5+$arJmhEnrollCourse[$lasthasilprogress5];$i++){
											$tmp = $aa[$i];
											$link = $bb[$i];
											$idgmbr = $e[$i];
											$gmbr = $f[$i];							
							?>
								<div class="gallery__item">
								<div class="col-lg-3 col-xs-6">
									<!-- small box -->
									<div class="gallery__img" >
									<?php 
									  echo '<img src="'.$CFG->wwwroot.'/pluginfile.php/'.$idgmbr.'/course/summary/'.$gmbr.'" style="position: relative; width: 252px; height: 189px;" />';
									?>
									<div class="small-box bg-light-blue" >
										<div class="inner">
										   <p color="white">
											 <?php echo $tmp;?>
										   </p>
										</div>
										<?php echo '<a href="'.$CFG->wwwroot.'/course/view.php?id='.$link.'" class="small-box-footer">'?>
										Click Course <i class="fa fa-arrow-circle-right"></i></a>
									</div>
									</div>
								</div>
								</div><!-- ./col -->
							<?php 
										}
									}
								} 
							?>
                        </div>
                    </div>
                </div>
                </div><!-- /.row -->
                <br/>
                <div class="gallery__controls clearfix">
                    <div href="#" class="gallery__controls-prev">
                        <img src="img/prev.png" alt="" />
                    </div>
                    <div href="#" class="gallery__controls-next">
                        <img src="img/next.png" alt="" />
                    </div>
                </div>
                <br/>
                    
                <!-- top row -->
                <div class="row">
                    <div class="col-xs-12 connectedSortable">

                    </div><!-- /.col -->
                </div>
                <!-- /.row -->


                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-6 connectedSortable"> 
                        
                        <!-- Most Popular Course User -->
                        <div hidden class="box box-solid box-success">
                            <div class="box-header">
                                <h3 class="box-title"><i class="fa fa-comments-o"></i> Most Popular Courses</h3>
                            </div>
                            <div class="box-body chat" id="chat-box">
                                <!-- chat item -->
                                <div class="item" id="most-2">
                                    <?php  
                                    for ($kl=0;$kl<1;$kl++) {
                                        $idthumbss = $h[$kl];
                                        $thumbdepanss = $g[$kl];
                                    echo '<center>';
                                    echo '<img src="'.$CFG->wwwroot.'/pluginfile.php/'.$idthumbss.'/course/summary/'.$thumbdepanss.'" style="position: relative; width: 100%; height: 100%;" />';
                                    echo '</center><br/>';
				}
                                    echo '<table class="table table-striped">';
                                    echo '<tr>';
                                    echo '<td><font color="3c8dbc">Nama Course&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td>';
                                    echo '<td><font color="3c8dbc">Jumlah Enrol </font></td>';
                                    echo '</tr>';
                                    for($i=0;$i<$resultrow3;$i++){
                                        echo '<tr>';
                                        echo '<td>'.$c[$i].'</td>';
                                        echo '<td>'.$d[$i].'</td>';
                                        echo '</tr>';        
                                    }
                                    echo '</table>';
                                    ?>
                                </div><!-- /.chat -->
                            </div><!-- /.box (chat box) -->
                        </div>                

                        <!-- Most Popular Course User -->
                        <div class="box box-solid box-success">
                            <div class="box-header">
                                <h3 class="box-title"><i class="fa fa-comments-o"></i> Most Popular Courses</h3>
                            </div>
                            <div class="box-body chat" id="chat-box">
                                <!-- chat item -->
                                <div class="item" id="most-2">
                                    <?php  
                                    for ($kl=0;$kl<1;$kl++) {
                                        $idthumbss = $h[$kl];
                                        $thumbdepanss = $g[$kl];
                                    echo '<center>';
                                    echo '<img src="'.$CFG->wwwroot.'/pluginfile.php/'.$idthumbss.'/course/summary/'.$thumbdepanss.'" style="position: relative; width: 100%; height: 100%;" />';
                                    echo '</center><br/>';
				}
                                    echo '<table class="table table-striped">';
                                    echo '<tr>';
                                    echo '<td><font color="3c8dbc">Nama Course&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td>';
                                    echo '<td><font color="3c8dbc">Jumlah Enrol </font></td>';
                                    echo '</tr>';
                                    for($i=0;$i<$resultrow3;$i++){
                                        echo '<tr>';
                                        echo '<td>'.$c[$i].'</td>';
                                        echo '<td>'.$d[$i].'</td>';
                                        echo '</tr>';        
                                    }
                                    echo '</table>';
                                    ?>
                                </div><!-- /.chat -->
                            </div><!-- /.box (chat box) -->
                        </div>  
                        
                        <?php if ($USER->id == 2) { ?>
                         <!-- Box (with bar chart) -->
                         <div class="box-header box-danger">
                             <!-- Custom tabs (Charts with tabs)-->
                             <div id="tabs" class="nav-tabs-custom">
                                 <!-- Tabs within a box -->
                                 <ul class="nav nav-tabs pull-right bg-red">
                                     <li class="bg-red"><a href="#tabs-2" data-toggle="tab">Most Participatory</a></li>
                                     <li class="active"><a href="#tabs-1" data-toggle="tab">Most Active</a></li>
                                     <li class="pull-left header bg-red"><i class="fa fa-inbox"></i>Course Overview</li> 
                                 </ul>
                                 <div class="tab-content no-padding">
                                     <!-- Morris chart - Sales -->
                                     <div class="chart tab-pane active" id="tabs-1">
                                         <?php 
                                         $senin = date("d m Y",strtotime('monday this week'));
                                        // if($senin){
                                      //       for(){   
                                       //     }
                                      //   }
                                         echo '<img src="'.$CFG->wwwroot.'/report/courseoverview/reportsgraph.php?time=7&report=11&numcourses=20" style="position: relative; width: 100%; height: 100%;" alt="Only Admin who can view this graph in periodic time"/>';                                            
                                         ?>
                                     </div>
                                     <div class="chart tab-pane" id="tabs-2">
                                         <?php echo '<img src="'.$CFG->wwwroot.'/report/courseoverview/reportsgraph.php?time=7&report=14&numcourses=20" style="position: relative; width: 100%; height: 100%;" alt="Only Admin who can view this graph in periodic time"/>';?>
                                     </div>    
                                 </div><!-- /.nav-tabs-custom -->
                             </div>
                         </div>
                         <?php } ?>                                
                        						
                        <!-- Calendar -->
                        <div class="box box-solid box-warning">
                            <div class="box-header">
                                <i class="fa fa-calendar"></i>
                                <div class="box-title">Calendar</div>

                                <!-- tools box -->
                                <div class="pull-right box-tools">

                                </div><!-- /. tools -->                                    
                            </div><!-- /.box-header -->
                            <div class="box-body no-padding">
                                <!--The calendar -->
                                <div id="calendar"></div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                        
						
                    </section><!-- /.Left col -->
                    <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    <section class="col-lg-6 connectedSortable">
						
                        <!-- Most Viewed -->
                        <div hidden class="box box-solid box-success">
                            <div class="box-header">
                                <h3 class="box-title"><i class="fa fa-comments-o"></i> Most Viewed</h3>
                            </div>
                            <div class="box-body chat" id="chat-box">
                                <!-- chat item -->
                                <div class="item" id="most-1">
                                    <?php  
                                    for ($k = 0;$k<1;$k++) {
                                        $idgmbr2 = $ee[$k];
                                        $gmbr2 = $ff[$k];
                                    echo '<center>';
                                    echo '<img src="'.$CFG->wwwroot.'/pluginfile.php/'.$idgmbr2.'/course/summary/'.$gmbr2.'" style="position: relative; width: 100%; height: 100%;" />';
                                    echo '</center><br/>';
                                    }
                                    echo '<table class="table table-striped" style="width:100%; height:100%;">';
                                    echo '<tr>';
                                    echo '<td><font color="3c8dbc">Nama Course&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td>';
                                    echo '<td><font color="3c8dbc">Jumlah View </font></td>';
                                    echo '</tr>';
                                    for($i=0;$i<$resultrow3;$i++){
                                        echo '<tr>';
                                        echo '<td>'.$a[$i].'</td>';
                                        echo '<td>'.$b[$i].'</td>';
                                        echo '</tr>';        
                                    }
                                    echo '</table>';
                                    ?>
                                </div><!-- /.chat -->
                            </div><!-- /.box (chat box) -->
                        </div>

                        <!-- Most Viewed -->
                        <div class="box box-solid box-success">
                            <div class="box-header">
                                <h3 class="box-title"><i class="fa fa-comments-o"></i> Most Viewed</h3>
                            </div>
                            <div class="box-body chat" id="chat-box">
                                <!-- chat item -->
                                <div class="item" id="most-1">
                                    <?php  
                                    for ($k=0;$k<1;$k++) {
                                        $idgmbr2 = $ee[$k];
                                        $gmbr2 = $ff[$k];
                                    echo '<center>';
                                    echo '<img src="'.$CFG->wwwroot.'/pluginfile.php/'.$idgmbr2.'/course/summary/'.$gmbr2.'" style="position: relative; width: 100%; height: 100%;" />';
                                    echo '</center><br/>';                                     
                                    }
                                    echo '<table class="table table-striped">';
                                    echo '<tr>';
                                    echo '<td><font color="3c8dbc">Nama Course&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</font></td>';
                                    echo '<td><font color="3c8dbc">Jumlah View </font></td>';
                                    echo '</tr>';
                                    for($i=0;$i<$resultrow;$i++){
                                        echo '<tr>';
                                        echo '<td>'.$a[$i].'</td>';
                                        echo '<td>'.$b[$i].'</td>';
                                        echo '</tr>';        
                                    }
                                    echo '</table>';
                                    ?>
                                </div><!-- /.chat -->
                            </div><!-- /.box (chat box) -->
                        </div>							

                        <?php  if ($USER->id == 2) { ?>
                        <!-- SLIDE -->
                        <!-- Course Statistic -->
                        <div class="box box-solid box-danger">
                            <div class="box-header">
                                <h3 class="box-title"><i class="fa fa-inbox"> &nbsp;Course Statistic</i></h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                    <ol class="carousel-indicators">
                                        <?php for($d=0;$d<1;$d++){?>
                                        <li data-target="#carousel-example-generic" data-slide-to="<?php echo $d; ?>" class="active"></li>
                                        <?php }
                                        for($dd=1;$dd<$resultrow2;$dd++){ 
                                        ?>
                                        <li data-target="#carousel-example-generic" data-slide-to="<?php echo $dd; ?>" class=""></li>
                                        <?php } ?>
                                    </ol>
                                    <div class="carousel-inner">
                                        <?php
                                        $senin = date('d-m-Y', strtotime('monday this week'));
                                        if($senin) {
                                            for($lo=0;$lo<1;$lo++){
                                                $gue3 = 12;
                                            }
                                            $gue = $gue3 + $lo;
                                        }
                                        for($e=1;$e<2;$e++){
                                            $arini = $arcoursenamed[$e];
                                        ?>
                                        <div class="item active">
                                            <?php echo '<img src="'.$CFG->wwwroot.'/report/stats/graph.php?mode=1&course=3&time='.$gue.'&report=5&roleid=6" style="position: relative; width: 100%; height: 100%;" alt="Course never activity in a week ago" />';?>
                                            <div class="carousel-caption">
                                            <?php echo $arini; ?>
                                            </div>
                                        </div>
                                        <?php }
                                            for($f=2;$f<$resultrow2;$f++){  
                                                $ff = $f+1;
                                                $arindu = $arcoursenamed[$f];
                                                ?>
                                        <div class="item">
                                            <?php echo '<img src="'.$CFG->wwwroot.'/report/stats/graph.php?mode=1&course='.$ff.'&time='.$gue.'&report=5&roleid=6" style="position: relative; width: 100%; height: 100%;" alt="Course never activity in a week ago" />';?>
                                            <div class="carousel-caption">
                                               <?php echo $arindu; ?>
                                            </div>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left"></span>
                                    </a>
                                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                    </a>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->                
                        <?php } ?>

                        <!-- Course Progress User-->
                        <!-- Box (with bar chart) -->
                        <div class="box-header">    
                            <!-- Custom tabs (Charts with tabs)-->
                            <div id="tabs" class="nav-tabs-custom">
                                <!-- Tabs within a box -->
                                <ul class="nav nav-tabs pull-right bg-red">
                                    <li class="bg-red"><a href="#tabs-15" data-toggle="tab">Not Attempted</a></li>
                                    <li class="bg-red"><a href="#tabs-13" data-toggle="tab">Completed</a></li>
                                    <li class="active"><a href="#tabs-14" data-toggle="tab">Incomplete</a></li>
                                    <li class="pull-left header bg-red"><i class="fa fa-inbox"></i>Course Progress</li>
                                </ul>  
                                <!-- Course Progress Completed -->
                                <div class="tab-content no-padding">                                
                                    <div class="chart tab-pane" id="tabs-13">
                                    <table class="table table-striped">
                                    <tr>
                                        <td><font color="3c8dbc">Nama Course</font></td>
                                        <td><font color="3c8dbc">Percentage </font></td>
                                        <td><font color="3c8dbc">Progress </font></td>
                                    </tr>
                                    <?php
                                    $hasilprogress3 = array_search($USER->id, $arnilaiid3);
                                    //$firsthasilprogress = reset($hasilprogress);
                                    $lasthasilprogress3 = array_search($USER->id, $aridk3);
                                    if ($hasilprogress3 !== FALSE && $lasthasilprogress3 !== FALSE) {
                                        for ($r=$hasilprogress3;$r<$hasilprogress3+$arjmhenrol3[$lasthasilprogress3];$r++){
                                            $tmp33 = $arnilaivalue3[$r];
                                            $jmhnc3 = $arnilaicourse3[$r];
                                            $jmhcc3 = $arnilaichart3[$r];
                                            echo '<tr>';
                                            echo '<td>'.$jmhnc3.'</td>';
                                            echo '<td>'.$jmhcc3.'</td>';
                                            echo '<td class="progress xs"><progress class="progress-bar" value="'.$tmp33.'" max="100" ></progress></td>';
                                            echo '</tr>';
                                        } 
                                    } 
                                    ?>
                                    </table>                                          
                                    </div>
                                    <!-- Course Progress Incomplete -->
                                    <div class="chart tab-pane active" id="tabs-14">
                                    <table class="table table-striped">
                                    <tr>
                                        <td><font color="3c8dbc">Nama Course</font></td>
                                        <td><font color="3c8dbc">Percentage </font></td>
                                        <td><font color="3c8dbc">Progress </font></td>
                                    </tr>
                                    <?php
                                    $hasilprogress = array_search($USER->id, $arnilaiid);
                                    //$firsthasilprogress = reset($hasilprogress);
                                    $lasthasilprogress = array_search($USER->id, $aridk);
                                    if ($hasilprogress !== FALSE && $lasthasilprogress !== FALSE) {
                                        for ($w=$hasilprogress;$w<$hasilprogress+$arjmhenrol[$lasthasilprogress];$w++){
                                            $tmp3 = $arnilaivalue[$w];
                                            $jmhnc = $arnilaicourse[$w];
                                            $jmhcc = $arnilaichart[$w];
                                            echo '<tr>';
                                            echo '<td>'.$jmhnc.'</td>';
                                            echo '<td>'.$jmhcc.'</td>';
                                            echo '<td class="progress xs"><progress class="progress-bar" value="'.$tmp3.'" max="100" ></progress></td>';
                                            echo '</tr>';
                                        } 
                                    } 
                                    ?>
                                    </table>
                                    </div>   
                                    <!-- Course Progress Not Attempted -->
                                    <div class="chart tab-pane" id="tabs-15">
                                    <table class="table table-striped">
                                    <tr>
                                        <td><font color="3c8dbc">Nama Course</font></td>
                                        <td><font color="3c8dbc">Percentage </font></td>
                                        <td><font color="3c8dbc">Progress </font></td>
                                    </tr>
                                    <?php
                                    $hasilprogress4 = array_search($USER->id, $arnilaiid4);
                                    //$firsthasilprogress = reset($hasilprogress);
                                    $lasthasilprogress4 = array_search($USER->id, $aridk4);
                                    if ($hasilprogress4 !== FALSE && $lasthasilprogress4 !== FALSE) {
                                        for ($e=$hasilprogress4;$e<$hasilprogress4+$arjmhenrol4[$lasthasilprogress4];$e++){
                                            $tmp34 = $arnilaivalue4[$e];
                                            $jmhnc4 = $arnilaicourse4[$e];
                                            $jmhcc4 = $arnilaichart4[$e];
                                            echo '<tr>';
                                            echo '<td>'.$jmhnc4.'</td>';
                                            echo '<td>'.$jmhcc4.'</td>';
                                            echo '<td class="progress xs"><progress class="progress-bar" value="'.$tmp34.'" max="100" ></progress></td>';
                                            echo '</tr>';
                                        } 
                                    } 
                                    ?>
                                    </table>
                                    </div>                                       
                                </div>
                            </div>                                
                        </div>                          
<?php /*
                        <!-- Visitors User-->
                        <div class="box box-solid box-primary">
                            <div class="box-header">
                                <!-- tools box -->
                                <div class="pull-right box-tools">                                        
                                   <!-- <button class="btn btn-primary btn-sm daterange pull-right" data-toggle="tooltip" title="Date range"><i class="fa fa-calendar"></i></button> <-->
                                    <button class="btn btn-primary btn-sm pull-right" data-widget='collapse' data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-minus"></i></button>
                                </div><!-- /. tools -->

                                <i class="fa fa-map-marker"></i>
                                <h3 class="box-title">
                                    Top 5 Regions Active
                                </h3>
                            </div>
                            <div class="box-body no-padding">
                                <div class="table-responsive">
                                    <!-- .table - Uses sparkline charts-->
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Region</th>
                                            <th>Registered</th>
                                            <th>Enroll</th>
                                        </tr>
                                        <?php
                                            for($h=0;$h<5;$h++){
                                                $idregionss = $arregionss[$h];
                                                $idregis = $arregis[$h];													
                                                $idJmhEnroll = $arJmhEnrollReg[$h];
                                                echo '<tr>';
                                                echo '<td><a href="#" style="color:#3c8dbc;">'.$idregionss.'</a></td>';
                                                echo '<td>'.$idregis.'</td>';
                                                echo '<td>'.$idJmhEnroll.'</td>';
                                                echo '</tr>';
                                            }
                                        ?>	
                                    </table><!-- /.table -->
                                </div>
                            </div><!-- /.box-body-->
                        </div> */
                            ?>
                    </section><!-- right col -->
                </div><!-- /.row (main row) -->

            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->

        <?php
        
		//Logout //
        if($_GET["log"]!=null){ 
		?>
		
		<script>
                window.open ('<?php echo $CFG->wwwroot ?>/login/And_logout.php?sesskey="<?php echo $sesskey ?>"','_self',false);
		</script>
		
		<?php
        }

        ?>
		
        <!-- add new calendar event modal -->

		
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
        <!-- Fancybox -->
        <script type="text/javascript" src="./fancybox/jquery.fancybox-1.3.1.js"></script>
        <!-- Map Light -->
        <script src="js/plugins/others/jquery.maphilight.js" type="text/javascript"></script>        

        <!-- AdminLTE App -->
        <script src="js/AdminLTE/app.js" type="text/javascript"></script>

        <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
        <script src="js/AdminLTE/dashboard.js" type="text/javascript"></script>     

        <!-- AdminLTE for demo purposes -->
        <!-- <script src="js/AdminLTE/demo.js" type="text/javascript"></script> -->
	
        <script type="text/javascript">     
	    function showtext(text){
                alert(text);
            }
            
            $(function() {
		$('.map').maphilight();
            });            
			
            $(function() {
              $( "#most" ).tabs();
            });
            
            $(function() {
              $( "#tabs" ).tabs();
            });            

             // Only run everything once the page has completely loaded
             $(window).load(function(){

                 // Set general variables
                 // ====================================================================
                 var totalWidth = 0;

                 // Total width is calculated by looping through each gallery item and
                 // adding up each width and storing that in `totalWidth`
                 $(".gallery__item").each(function(){
                     totalWidth = totalWidth + $(this).outerWidth(true);
                 });

                 // The maxScrollPosition is the furthest point the items should
                 // ever scroll to. We always want the viewport to be full of images.
                 var maxScrollPosition = totalWidth - $(".gallery-wrap").outerWidth();

                 // This is the core function that animates to the target item
                 // ====================================================================
                 function toGalleryItem($targetItem){
                     // Make sure the target item exists, otherwise do nothing
                     if($targetItem.length){

                         // The new position is just to the left of the targetItem
                         var newPosition = $targetItem.position().left;

                         // If the new position isn't greater than the maximum width
                         if(newPosition <= maxScrollPosition){

                             // Add active class to the target item
                             $targetItem.addClass("gallery__item--active");

                             // Remove the Active class from all other items
                             $targetItem.siblings().removeClass("gallery__item--active");

                             // Animate .gallery element to the correct left position.
                             $(".gallery").animate({
                                 left : - newPosition
                             });
                         } else {
                             // Animate .gallery element to the correct left position.
                             $(".gallery").animate({
                                 left : - maxScrollPosition
                             });
                         };
                     };
                 };

                 // Basic HTML manipulation
                 // ====================================================================
                 // Set the gallery width to the totalWidth. This allows all items to
                 // be on one line.
                 $(".gallery").width(totalWidth);

                 // Add active class to the first gallery item
                 $(".gallery__item:first").addClass("gallery__item--active");

                 // When the prev button is clicked
                 // ====================================================================
                 $(".gallery__controls-prev").click(function(){
                     // Set target item to the item before the active item
                     var $targetItem = $(".gallery__item--active").prev();
                     toGalleryItem($targetItem);
                 });

                 // When the next button is clicked
                 // ====================================================================
                 $(".gallery__controls-next").click(function(){
                     // Set target item to the item after the active item
                     var $targetItem = $(".gallery__item--active").next();
                     toGalleryItem($targetItem);
                 });
             });

        // Fancybox specific
        // To make images pretty. Not important
        $(document).ready(function(){
            $(".gallery__link").fancybox({
                'titleShow'     : false,
                'transitionIn'  : 'elastic',
                'transitionOut' : 'elastic'
            });
        });
         
        </script>      
        
    </body>
</html>