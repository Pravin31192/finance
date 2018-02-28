<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>SPUNK | Dashboard</title>

    <link href="<?php echo base_url("assets");?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url("assets");?>/font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Toastr style -->
    <link href="<?php echo base_url("assets");?>/css/plugins/toastr/toastr.min.css" rel="stylesheet">

    <!-- Gritter -->
    <!-- <link href="<?php echo base_url("assets");?>/js/plugins/gritter/jquery.gritter.css" rel="stylesheet"> -->

    <link href="<?php echo base_url("assets");?>/css/animate.css" rel="stylesheet">
    <link href="<?php echo base_url("assets");?>/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url("assets") ?>/css/plugins/clockpicker/clockpicker.css" rel="stylesheet">
    <link href="<?php echo base_url("assets") ?>/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
    <link href="<?php echo base_url("assets") ?>/css/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet">
    <link href="<?php echo base_url("assets") ?>/css/plugins/select2/select2.min.css" rel="stylesheet">
    <link href="<?php echo base_url("assets") ?>/css/plugins/chosen/bootstrap-chosen.css" rel="stylesheet">
    
    
    <!-- Loading the CSS from the front end for admin side court booking-->
    <link rel='stylesheet' href='/spunk/assets/frontend/css/style.css' type='text/css' />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    

    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="<?php echo base_url("assets/");?>js/jquery-2.1.1.js"></script>
    <script src="<?php echo base_url("assets/")?>/js/plugins/clockpicker/clockpicker.js"></script>
    <script src="<?php echo base_url("assets/");?>js/plugins/datapicker/bootstrap-datepicker.js"></script>
    <!-- Date range use moment.js same as full calendar plugin -->
    <script src="<?php echo base_url("assets/");?>js/plugins/fullcalendar/moment.min.js"></script>

    <!-- Date range picker -->
    <script src="<?php echo base_url("assets/");?>js/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Chosen -->
    <script src="<?php echo base_url("assets/");?>js/plugins/chosen/chosen.jquery.js"></script>
    

</head>

<body>
    
    
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element"> <span>
                            <img alt="image" class="img-circle" src="<?php echo base_url("assets/");?>img/profile_small.jpg" />
                             </span>
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">David Williams</strong>
                             </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span> </span> </a>
                            <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                <li><a href="profile.html">Profile</a></li>
                                <li><a href="contacts.html">Contacts</a></li>
                                <li><a href="mailbox.html">Mailbox</a></li>
                                <li class="divider"></li>
                                <li>
                                    <a href="login.html">Logout</a>
                                </li>
                            </ul>
                        </div>
                        <div class="logo-element">
                            IN+
                        </div>
                    </li>
                    
                    <li>
                        <a href="<?php echo base_url('admin/customer/create');?>"><i class="fa fa-road"></i> <span class="nav-label">Customers</span></a>
                    </li>

                    <li>
                        <a href="<?php echo base_url('admin/customer/saveVehicle');?>"><i class="fa fa-clock-o"></i> <span class="nav-label">Vehicle</span>  </a>
                    </li>
                    
                    <li>
                        <a href="<?php echo base_url('slots');?>"><i class="fa fa-clock-o"></i> <span class="nav-label">Slots</span>  </a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('admin/bookings');?>"><i class="fa fa-search"></i>
                            <span class="nav-label">Availability</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo base_url('admin/current-bookings') ?>"><i class="fa fa-laptop"></i> <span class="nav-label">Current Bookings</span></a>
                    </li>
                    <li>
                        <a href="package.html"><i class="fa fa-database"></i> <span class="nav-label">TBD</span></a>
                    </li>
                </ul>

            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg dashbard-1">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                        <form role="search" class="navbar-form-custom" action="search_results.html">
                            <div class="form-group">
                                <input type="text" placeholder="Search for something..." class="form-control" name="top-search" id="top-search">
                            </div>
                        </form>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <span class="m-r-sm text-muted welcome-message">Welcome to Spunk Admin portal.</span>
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                <i class="fa fa-envelope"></i>  
                                <span class="label label-warning"></span>
                            </a>
                            
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                <i class="fa fa-bell"></i>  
                                <span class="label label-primary">8</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url('logout');?>">
                                <i class="fa fa-sign-out"></i> Log out
                            </a>
                        </li>
                        <li>
                            <a class="right-sidebar-toggle">
                                <i class="fa fa-tasks"></i>
                            </a>
                        </li>
                     </ul>
                </nav>
            </div>

            

            <!-- <div class="row border-bottom white-bg">
                <div class="col-sm-12">
                    <h2>This is where the contents are displayed</h2>
                </div>
            </div> -->