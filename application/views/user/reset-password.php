<!DOCTYPE html>
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
<script>
    var SITE_URL = "<?php echo SITE_URL; ?>";
  
</script>     
        <meta charset="utf-8" />
        <title>HRMS - Password Reset</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <!--<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />-->
        <link href="<?php echo assets_url(); ?>global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo assets_url(); ?>global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo assets_url(); ?>global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo assets_url(); ?>global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="<?php echo assets_url(); ?>global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo assets_url(); ?>global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo assets_url(); ?>global/css/components-md.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo assets_url(); ?>global/css/plugins-md.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="<?php echo assets_url(); ?>pages/css/login.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="<?php echo assets_url(); ?>pages/img/LOGO_TRANSS.png" /> </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="<?php echo SITE_URL; ?>login">
                <img src="<?php echo assets_url(); ?>pages/img/l_trans.png" alt=""/> 
            </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">

            <?php
            $link_createdTime = sps_decode(@$_GET['st']);
            $link_time = strtotime($link_createdTime);
            $cur_time = strtotime(date('Y-m-d H:i:s'));
            $diff = $cur_time-$link_time;
            /*echo $link_createdTime;
            echo '<br>'.$link_time;
            echo '<br>'.$cur_time.'<br>';
            echo $diff;*/
            // check if link created time is less than 24 hours or not
            if($diff>(24*60*60)){
                echo '<div class="alert alert-danger">
                    <button class="close" data-close="alert"></button>
                    <span> Password Link Expired. </span>
                </div>
';
            }
            else{
            
            ?>

            <!-- BEGIN RESET PASSWORD FORM -->
            <form class="reset-form" action="<?php echo SITE_URL; ?>resetPasswordAction" method="post">
                <h3 class="form-title font-green uppercase">Reset Password</h3>
                <div class="form-group">
                   <div class="input-icon right">
                        <i class="fa"></i>
                        <input type="hidden" name="encrypt_id" value="<?php echo @$_GET['reset']?>">
                        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                        <label class="control-label visible-ie8 visible-ie9">New Password</label>
                        <input class="form-control form-control-solid placeholder-no-fix" maxlength="20" required type="password" id="confirm_password" autocomplete="off" placeholder="New Password" name="newPassword" /> </div>
                    </div>
                <div class="form-group">
                   <div class="input-icon right">
                        <i class="fa"></i>
                        <label class="control-label visible-ie8 visible-ie9">Confirm Password</label>
                        <input class="form-control form-control-solid placeholder-no-fix" maxlength="20" required type="password" autocomplete="off" placeholder="Confirm Password" name="confirmPassword" /> </div>
                    </div>
                <div class="form-actions" style="margin-left:100px;">
                    <button type="submit" name="submitForgetPassword" value="1" class="btn green uppercase">Submit</button>
                </div>
            </form>
            <?php 
            }
            ?>
            <!-- END RESET PASSWORD FORM -->
        </div>
        <div class="copyright"> 2016 © Entransys Private Limited </div>
        <!--[if lt IE 9]>
<script src="<?php echo assets_url(); ?>global/plugins/respond.min.js"></script>
<script src="<?php echo assets_url(); ?>global/plugins/excanvas.min.js"></script> 
<script src="<?php echo assets_url(); ?>global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo assets_url(); ?>global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_url(); ?>global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_url(); ?>global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_url(); ?>global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_url(); ?>global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_url(); ?>global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo assets_url(); ?>global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_url(); ?>global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_url(); ?>global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo assets_url(); ?>global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="<?php echo assets_url(); ?>pages/scripts/passReset.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
    </body>

</html>