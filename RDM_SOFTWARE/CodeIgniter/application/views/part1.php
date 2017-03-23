<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>RDM - Private Area</title>

        <!-- start: Mobile Specific -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
            <!-- end: Mobile Specific -->

            <link id="bootstrap-style" href="<?= base_url() ?>public/css/bootstrap.min.css" rel="stylesheet">
                <link href="<?= base_url() ?>public/css/bootstrap-responsive.min.css" rel="stylesheet"> 

                    <link id="base-style" href="<?= base_url() ?>public/css/style.css" rel="stylesheet">

                        <link id="base-style-responsive" href="<?= base_url() ?>public/css/style-responsive.css" rel="stylesheet"> 



                            <link id="base-style" href="<?= base_url() ?>public/css/materialize/css/materialize.min.css" rel="stylesheet">



                                <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>


                                    </head>
                                    <body>

                                        <div class="navbar">
                                            <div class="navbar-inner">
                                                <div class="container-fluid">
                                                    <a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
                                                        <span class="icon-bar"></span>
                                                        <span class="icon-bar"></span>
                                                        <span class="icon-bar"></span>
                                                    </a>
                                                    <a class="brand" href="viewMeter"><span>Home</span></a>
                                                    <a class="brand" href="home/logout"><span>Log-out</span></a>				
                                                    <!-- start: Header Menu -->
                                                    <div class="nav-no-collapse header-nav">
                                                        <ul class="nav pull-right">
                                                            <li class="dropdown hidden-phone">
                                                                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                                                    <i class="halflings-icon white warning-sign"></i>
                                                                </a>
                                                                <ul class="dropdown-menu notifications">
                                                                    <li class="dropdown-menu-title">
                                                                        <span>You have 11 notifications</span>
                                                                        <a href="#refresh"><i class="icon-repeat"></i></a>
                                                                    </li>	
                                                                    <li>
                                                                        <a href="#">
                                                                            <span class="icon blue"><i class="icon-user"></i></span>
                                                                            <span class="message">New user registration</span>
                                                                            <span class="time">1 min</span> 
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <span class="icon green"><i class="icon-comment-alt"></i></span>
                                                                            <span class="message">New comment</span>
                                                                            <span class="time">7 min</span> 
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <span class="icon green"><i class="icon-comment-alt"></i></span>
                                                                            <span class="message">New comment</span>
                                                                            <span class="time">8 min</span> 
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <span class="icon green"><i class="icon-comment-alt"></i></span>
                                                                            <span class="message">New comment</span>
                                                                            <span class="time">16 min</span> 
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <span class="icon blue"><i class="icon-user"></i></span>
                                                                            <span class="message">New user registration</span>
                                                                            <span class="time">36 min</span> 
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <span class="icon yellow"><i class="icon-shopping-cart"></i></span>
                                                                            <span class="message">2 items sold</span>
                                                                            <span class="time">1 hour</span> 
                                                                        </a>
                                                                    </li>
                                                                    <li class="warning">
                                                                        <a href="#">
                                                                            <span class="icon red"><i class="icon-user"></i></span>
                                                                            <span class="message">User deleted account</span>
                                                                            <span class="time">2 hour</span> 
                                                                        </a>
                                                                    </li>
                                                                    <li class="warning">
                                                                        <a href="#">
                                                                            <span class="icon red"><i class="icon-shopping-cart"></i></span>
                                                                            <span class="message">New comment</span>
                                                                            <span class="time">6 hour</span> 
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <span class="icon green"><i class="icon-comment-alt"></i></span>
                                                                            <span class="message">New comment</span>
                                                                            <span class="time">yesterday</span> 
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <span class="icon blue"><i class="icon-user"></i></span>
                                                                            <span class="message">New user registration</span>
                                                                            <span class="time">yesterday</span> 
                                                                        </a>
                                                                    </li>
                                                                    <li class="dropdown-menu-sub-footer">
                                                                        <a>View all notifications</a>
                                                                    </li>	
                                                                </ul>
                                                            </li>
                                                            <!-- start: Notifications Dropdown -->
                                                            <li class="dropdown hidden-phone">
                                                                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                                                    <i class="halflings-icon white tasks"></i>
                                                                </a>
                                                                <ul class="dropdown-menu tasks">
                                                                    <li class="dropdown-menu-title">
                                                                        <span>You have 17 tasks in progress</span>
                                                                        <a href="#refresh"><i class="icon-repeat"></i></a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <span class="header">
                                                                                <span class="title">iOS Development</span>
                                                                                <span class="percent"></span>
                                                                            </span>
                                                                            <div class="taskProgress progressSlim red">80</div> 
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <span class="header">
                                                                                <span class="title">Android Development</span>
                                                                                <span class="percent"></span>
                                                                            </span>
                                                                            <div class="taskProgress progressSlim green">47</div> 
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <span class="header">
                                                                                <span class="title">ARM Development</span>
                                                                                <span class="percent"></span>
                                                                            </span>
                                                                            <div class="taskProgress progressSlim yellow">32</div> 
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <span class="header">
                                                                                <span class="title">ARM Development</span>
                                                                                <span class="percent"></span>
                                                                            </span>
                                                                            <div class="taskProgress progressSlim greenLight">63</div> 
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <span class="header">
                                                                                <span class="title">ARM Development</span>
                                                                                <span class="percent"></span>
                                                                            </span>
                                                                            <div class="taskProgress progressSlim orange">80</div> 
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-menu-sub-footer">View all tasks</a>
                                                                    </li>	
                                                                </ul>
                                                            </li>
                                                            <!-- end: Notifications Dropdown -->
                                                            <!-- start: Message Dropdown -->
                                                            <li class="dropdown hidden-phone">
                                                                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                                                    <i class="halflings-icon white envelope"></i>
                                                                </a>
                                                                <ul class="dropdown-menu messages">
                                                                    <li class="dropdown-menu-title">
                                                                        <span>You have 9 messages</span>
                                                                        <a href="#refresh"><i class="icon-repeat"></i></a>
                                                                    </li>	
                                                                    <li>
                                                                        <a href="#">
                                                                            <span class="avatar"><img src="img/avatar.jpg" alt="Avatar"></span>
                                                                            <span class="header">
                                                                                <span class="from">
                                                                                    <?= $username ?>
                                                                                </span>
                                                                                <span class="time">
                                                                                    6 min
                                                                                </span>
                                                                            </span>
                                                                            <span class="message">
                                                                                Lorem ipsum dolor sit amet consectetur adipiscing elit, et al commore
                                                                            </span>  
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <span class="avatar"><img src="img/avatar.jpg" alt="Avatar"></span>
                                                                            <span class="header">
                                                                                <span class="from">
                                                                                    <?= $username ?>
                                                                                </span>
                                                                                <span class="time">
                                                                                    56 min
                                                                                </span>
                                                                            </span>
                                                                            <span class="message">
                                                                                Lorem ipsum dolor sit amet consectetur adipiscing elit, et al commore
                                                                            </span>  
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <span class="avatar"><img src="img/avatar.jpg" alt="Avatar"></span>
                                                                            <span class="header">
                                                                                <span class="from">
                                                                                    <?= $username ?>
                                                                                </span>
                                                                                <span class="time">
                                                                                    3 hours
                                                                                </span>
                                                                            </span>
                                                                            <span class="message">
                                                                                Lorem ipsum dolor sit amet consectetur adipiscing elit, et al commore
                                                                            </span>  
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <span class="avatar"><img src="img/avatar.jpg" alt="Avatar"></span>
                                                                            <span class="header">
                                                                                <span class="from">
                                                                                    <?= $username ?>
                                                                                </span>
                                                                                <span class="time">
                                                                                    yesterday
                                                                                </span>
                                                                            </span>
                                                                            <span class="message">
                                                                                Lorem ipsum dolor sit amet consectetur adipiscing elit, et al commore
                                                                            </span>  
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#">
                                                                            <span class="avatar"><img src="img/avatar.jpg" alt="Avatar"></span>
                                                                            <span class="header">
                                                                                <span class="from">
                                                                                    <?= $username ?>
                                                                                </span>
                                                                                <span class="time">
                                                                                    Jul 25, 2012
                                                                                </span>
                                                                            </span>
                                                                            <span class="message">
                                                                                Lorem ipsum dolor sit amet consectetur adipiscing elit, et al commore
                                                                            </span>  
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-menu-sub-footer">View all messages</a>
                                                                    </li>	
                                                                </ul>
                                                            </li>
                                                            <!-- end: Message Dropdown -->
                                                            <li>
                                                                <a class="btn" href="#">
                                                                    <i class="halflings-icon white wrench"></i>
                                                                </a>
                                                            </li>
                                                            <!-- start: User Dropdown -->
                                                            <li class="dropdown">
                                                                <a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                                                                    <i class="halflings-icon white user"></i>  User Name:	<strong><?= $username ?></strong>

                                                                </a>
                                                                <ul class="dropdown-menu">
                                                                    <li class="dropdown-menu-title">
                                                                        <span>Account Settings</span>
                                                                    </li>
                                                                    <li><a href="#"><i class="halflings-icon user"></i> Profile</a></li>
                                                                    <li><a href="login.html"><i class="halflings-icon off"></i> Logout</a></li>
                                                                </ul>
                                                            </li>
                                                            <!-- end: User Dropdown -->
                                                        </ul>
                                                    </div>
                                                    <!-- end: Header Menu -->

                                                </div>
                                            </div>
                                        </div>
                                        <!-- start: Header -->

                                        <div class="container-fluid-full">
                                            <div class="row-fluid">

                                                <!-- start: Main Menu -->
                                                <div id="sidebar-left" class="span2">
                                                    <div class="nav-collapse sidebar-nav">
                                                        <ul class="nav nav-tabs nav-stacked main-menu">






                                                            <?php
                                                            if ($member == "Admin") {

                                                                echo "<li><a href='newMeter'><i class='icon-edit'></i><span class='hidden-tablet'> Add New meter</span></a></li>
                                              <!--<li><a href='viewMeter'><i class='icon-edit'></i><span class='hidden-tablet'> Add New meter Device</span></a></li>-->
                                              <li><a href='viewMeter'><i class='icon-edit'></i><span class='hidden-tablet'> View Meters</span></a></li>
                                              <li><a href='viewMeterStatus'><i class='icon-edit'></i><span class='hidden-tablet'> View Meters STATUS</span></a></li>

                                              <li><a href='newMessage'><i class='icon-edit'></i><span class='hidden-tablet'> New VGW Messages</span></a></li>
                                              <li><a href='viewMessage'><i class='icon-edit'></i><span class='hidden-tablet'> View VGW Messages</span></a></li>
                                              <li><a href='creaUser'><i class='icon-edit'></i><span class='hidden-tablet'> Create Users</span></a></li>";
                                                            } else {

                                                                echo "
                                              <li><a href='viewMeter'><i class='icon-edit'></i><span class='hidden-tablet'>View Meters</span></a></li>
                                             ";
                                                            }
                                                            ?>


                                                          

                                                        </ul>
                                                    </div>
                                                </div>
                                                <!-- end: Main Menu -->

                                                <noscript>
                                                    <div class="alert alert-block span10">
                                                        <h4 class="alert-heading">Warning!</h4>
                                                        <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
                                                    </div>
                                                </noscript>

                                                <!-- start: Content -->
                                                <div id="content" class="span10">


                                                    <ul class="breadcrumb">
                                                        <li>
                                                            <i class="icon-home"></i>
                                                            <a href="index.html">Home</a> 
                                                            <i class="icon-angle-right"></i>
                                                        </li>
                                                        <li><a href="#">Dashboard</a></li>
                                                    </ul>
