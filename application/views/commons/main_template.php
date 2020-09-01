<?php 
//if(!is_authorized_page($this->session->userdata('block_designation_id'),$cur_page))
//{
    //redirect(SITE_URL.'unauthorized_request'); exit();
//}
?>
<!DOCTYPE html>
<html lang="en">
    
    <!-- BEGIN HEAD -->

    <head>
<script>
    var SITE_URL = "<?php echo SITE_URL; ?>";
  
</script>    
        <meta charset="utf-8" />
        <title><?php echo $pageTitle; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="<?php echo assets_url(); ?>global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo assets_url(); ?>global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo assets_url(); ?>global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo assets_url(); ?>global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?php echo assets_url(); ?>global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo assets_url(); ?>global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo assets_url(); ?>global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo assets_url(); ?>global/css/components-md.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo assets_url(); ?>global/css/plugins-md.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <link href="<?php echo assets_url(); ?>layouts/layout3/css/layout.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo assets_url(); ?>layouts/layout3/css/themes/default.min.css" rel="stylesheet" type="text/css" id="style_color" />
        <link href="<?php echo assets_url(); ?>layouts/layout3/css/custom.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME LAYOUT STYLES -->
        <!-- BEGIN CUSTOM/EXTERNAL STYLES -->
        <link href="<?php echo assets_url(); ?>custom/css/style.css" rel="stylesheet" type="text/css" />
        <?php
        if(isset($css_includes))
        {
            if(count($css_includes)>0)
            {
              foreach($css_includes as $css_file)
              {
                 echo @$css_file;
              }
            }
        }
        ?>
        <!-- END CUSTOM/EXTERNAL STYLES -->
        <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 

    </head>
    <!-- END HEAD -->
    <body class="page-container-bg-solid page-header-menu-fixed page-md">
        <div class="page-wrapper">
            <div class="page-wrapper-row">
                <div class="page-wrapper-top">
                    <!-- BEGIN HEADER -->
                    <div class="page-header">
                        <!-- BEGIN HEADER TOP -->
                        <div class="page-header-top">
                            <div class="container">
                                <!-- BEGIN LOGO -->
                                <div class="page-logo">
                                    <a href="<?php echo SITE_URL; ?>">
                                        <img src="<?php echo assets_url(); ?>layouts/layout3/img/logo.jpg" alt="logo" class="logo-default" style="max-width:100%; height:auto; padding: 13px; margin:2px;">
                                    </a>
                                </div>
                                <!-- END LOGO -->
                                <!-- BEGIN RESPONSIVE MENU TOGGLER -->
                                <a href="javascript:;" class="menu-toggler"></a>
                                <!-- END RESPONSIVE MENU TOGGLER -->
                                <!-- BEGIN TOP NAVIGATION MENU -->
                                <div class="top-menu">
                                    <ul class="nav navbar-nav pull-right">
                                        <!-- BEGIN USER LOGIN DROPDOWN -->
                                        <li class="dropdown dropdown-user dropdown-dark">
                                            
                                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                                <img alt="" class="img-circle" src="<?php echo assets_url();?>layouts/layout3/img/avatar.png">
                                                <span class="username username-hide-mobile"><?php echo $this->session->userdata('userFullName');
                                                if($this->session->userdata('block_id')!=5){ echo ' ('.$this->session->userdata('designation_name').' '.'- '.$this->session->userdata('block_name').')';}  ?></span>
                                                <i class="fa fa-angle-down"> </i>
                                            </a>
                                            <ul class="dropdown-menu dropdown-menu-default">
                                                <li>
                                                    <a href="<?php echo SITE_URL.'profile' ?>">
                                                        <i class="icon-user"></i> My Profile </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo SITE_URL; ?>changePassword">
                                                        <i class="icon-key"></i> Change Password </a>
                                                </li>
                                                <li class="divider"> </li>
                                                <li>
                                                    <a href="<?php echo SITE_URL ?>logout">
                                                        <i class="icon-logout"></i> Log Out </a>
                                                </li>
                                            </ul>
                                        </li>
                                        <!-- END USER LOGIN DROPDOWN -->
                                    </ul>
                                </div>
                                <!-- END TOP NAVIGATION MENU -->
                            </div>
                        </div>
                        <!-- END HEADER TOP -->
                        <!-- BEGIN HEADER MENU -->
                        <div class="page-header-menu">
                            <div class="container">
                                <!-- BEGIN MEGA MENU -->
                                <!-- DOC: Apply "hor-menu-light" class after the "hor-menu" class below to have a horizontal menu with white background -->
                                <!-- DOC: Remove data-hover="dropdown" and data-close-others="true" attributes below to disable the dropdown opening on mouse hover -->
                                <div class="hor-menu  ">
                                    <ul class="nav navbar-nav">
                                        <?php 
                                        $designation_id = $this->session->userdata('designation_id');
                                        switch(get_logged_user_role())
                                        {
                                            
                                            case 1: 
                                                if($designation_id == get_admin_designation())
                                                {
                                                    include('menu/admin-headoffice.php');
                                                }
                                                else if($designation_id == get_executive_designation())
                                                {
                                                    include('menu/executive-headoffice.php');
                                                }
                                                else if($designation_id == get_deputy_manager_designation())
                                                {
                                                    //include('menu/deputy_manager-headoffice.php');
                                                    include('menu/executive-headoffice.php');
                                                }
                                                else if($designation_id == get_manager_designation())
                                                {
                                                    //include('menu/manager-headoffice.php');
                                                    include('menu/executive-headoffice.php');
                                                }
                                                else if($designation_id == get_vc_designation())
                                                {
                                                    //include('menu/vc-md-headoffice.php');
                                                    include('menu/executive-headoffice.php');
                                                }
                                                break;
                                            case 2: 
                                                 if($designation_id == get_manager_designation())
                                                {
                                                    include('menu/manager-ops.php');
                                                }
                                                else if($designation_id == get_production_designation())
                                                {
                                                    include('menu/production-ops.php');
                                                }
                                                else if($designation_id == get_lab_technician_designation())
                                                {
                                                    include('menu/lab-ops.php');
                                                }
                                                else if($designation_id == get_weigh_bridge_designation())
                                                {
                                                    include('menu/weigh_bridge-ops.php');
                                                }
                                                else if($designation_id == get_security_designation())
                                                {
                                                    include('menu/security-ops.php');
                                                }
                                                break;
                                            case 3: 
                                                 if($designation_id == get_manager_designation())
                                                {
                                                    include('menu/manager-stockpoint.php');
                                                }
                                                break;
                                            case 4: 
                                                if($designation_id == get_manager_designation())
                                                {
                                                    include('menu/manager-candf.php');
                                                }
                                                break;
                                            case 5: 
                                                include('menu/distributor.php');
                                                break;
                                        }
                                    ?>    

                                    </ul>
                                </div>
                                <!-- END MEGA MENU -->
                            </div>
                        </div>
                        <!-- END HEADER MENU -->
                    </div>
                    <!-- END HEADER -->
                </div>
            </div>
            <div class="page-wrapper-row full-height">
                <div class="page-wrapper-middle">
                    <!-- BEGIN CONTAINER -->
                    <div class="page-container">
                        <!-- BEGIN CONTENT -->
                        <div class="page-content-wrapper">
                            <!-- BEGIN CONTENT BODY -->
                            <!-- BEGIN PAGE HEAD-->

                            <div class="page-head">
                                <div class="container">

                                    <div class="col-sm-7">
                                        <div class="page-title" style="padding:13px 0;">
                                        <span style="color:#697882; font-size:22px; font-weight: 400;"><?php echo $heading; ?></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-5" align="right">
                                    <small><?php include_once('breadCrumb.php');?></small>
                                    </div>
                                    <!-- BEGIN PAGE TITLE -->
                                    <!-- END PAGE TITLE -->
                                </div>
                            </div>
                            <!-- END PAGE HEAD-->
                            <!-- BEGIN PAGE CONTENT BODY -->
                            <div class="page-content">
                                <div class="container">
                                    <?php echo $this->session->flashdata('response'); ?>