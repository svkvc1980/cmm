<!DOCTYPE html>
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
<script>
    var SITE_URL = "<?php echo SITE_URL; ?>";
  
</script>     
        <meta charset="utf-8" />
        <title>AP Oil Fed - CMM - Login</title>
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
        <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile1.png" /> </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="<?php echo SITE_URL; ?>login">
                <img src="<?php echo assets_url(); ?>layouts/layout3/img/logo.jpg" alt=""/> 
            </a>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" id="check" action="<?php echo SITE_URL; ?>login" method="post">
                <h3 class="form-title font-green uppercase">Sign In</h3>
                <?php echo $this->session->flashdata('response'); ?>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Username and Password cannot be empty. </span>
                </div>
                <div class="form-group">
                    <div class="input-icon right">
                        <i class="fa"></i>
                        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                        <!--<label class="control-label visible-ie8 visible-ie9">Username</label>-->
                        <input class="form-control form-control-solid placeholder-no-fix" maxlength="20" required type="text" autocomplete="off" placeholder="Username" name="username" /> </div>
                    </div>
                <div class="form-group">
                    <div class="input-icon right">
                        <i class="fa"></i>
                        <!--<label class="control-label visible-ie8 visible-ie9">Password</label>-->
                        <input class="form-control form-control-solid placeholder-no-fix" maxlength="20" required type="password" autocomplete="off" placeholder="Password" name="password" /> </div>
                    </div>  
                <div class="form-actions" style="margin-left:100px;">
                    <button type="submit" name="login" value="1" class="btn green uppercase">Login</button>
                    <!-- <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a> -->
                </div>
            </form>
            
                                    
                                
            <!-- END LOGIN FORM -->
            <!-- BEGIN FORGOT PASSWORD FORM -->
            <form class="forget-form" action="<?php echo SITE_URL; ?>forgotPassword" method="post">
                <h3 class="font-green uppercase">Forgot Password ?</h3>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Username cannot be empty. </span>
                </div>
                <p> Enter your Username to reset your password. </p>
                <div class="form-group">
                   <div class="input-icon right">
                        <i class="fa"></i>
                        <input class="form-control placeholder-no-fix" type="text" maxlength="20"  required autocomplete="off" placeholder="username" name="username" /> </div>
                    </div>
                <div class="form-actions">
                    <button type="button" id="back-btn" class="btn green btn-outline">Back</button>
                    <button type="submit" name="forgetPassword" value="1" class="btn btn-success uppercase pull-right">Submit</button>
                </div>

            </form>
            <!-- END FORGOT PASSWORD FORM -->
            <!-- BEGIN REGISTRATION FORM -->
            <form class="register-form" action="<?php echo SITE_URL; ?>registerUser" method="post">
                <h3 class="font-green">Sign Up</h3>
                <p class="hint"> Enter your personal details below: </p>
                <div class="form-group">
                   <div class="input-icon right">
                        <i class="fa"></i>
                        <label class="control-label visible-ie8 visible-ie9">Full Name</label>
                        <input class="form-control placeholder-no-fix" maxlength="50"  type="text" placeholder="Full Name" name="name" /> </div>
                    </div>
                <div class="form-group">
                   <div class="input-icon right">
                        <i class="fa"></i>
                        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                        <label class="control-label visible-ie8 visible-ie9">Email</label>
                        <input class="form-control placeholder-no-fix" type="text" maxlength="100"  placeholder="Email" name="email" /> </div>
                    </div>
                <div class="form-group">
                   <div class="input-icon right">
                        <i class="fa"></i>
                        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                        <label class="control-label visible-ie8 visible-ie9">Phone</label>
                        <input class="form-control placeholder-no-fix" type="text" maxlength="15" placeholder="Phone" name="phone" /> </div>
                    </div>
                <div class="form-group">
                   <div class="input-icon right">
                        <i class="fa"></i>
                        <label class="control-label visible-ie8 visible-ie9">Address</label>
                        <input class="form-control placeholder-no-fix" type="text" maxlength="255" placeholder="Address" name="address" /> </div>
                    </div>
                <div class="form-group">
                   <div class="input-icon right">
                        <i class="fa"></i>
                        <label class="control-label visible-ie8 visible-ie9">City/Town</label>
                        <input class="form-control placeholder-no-fix" type="text" maxlength="100" placeholder="City/Town" name="city" /> </div>
                    </div>
                <p class="hint"> Enter your account details below: </p>
                <div class="form-group">
                   <div class="input-icon right">
                        <i class="fa"></i>
                        <label class="control-label visible-ie8 visible-ie9">Username</label>
                        <input class="form-control placeholder-no-fix" type="text" maxlength="20" id="registerUserName" autocomplete="off" placeholder="Username" name="username" /> </div>
                        <p id="usernameValidating" class="hidden"><i class="fa fa-spinner fa-spin"></i> Checking...</p>
                        <p id="usernameError" class="error hidden"></p>

                    </div>
                <div class="form-group">
                   <div class="input-icon right">
                        <i class="fa"></i>
                        <label class="control-label visible-ie8 visible-ie9">Password</label>
                        <input class="form-control placeholder-no-fix" type="password" maxlength="20" autocomplete="off" id="register_password" placeholder="Password" name="password" /> </div>
                    </div>
                <div class="form-group">
                   <div class="input-icon right">
                        <i class="fa"></i>
                        <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
                        <input class="form-control placeholder-no-fix" type="password" maxlength="20" autocomplete="off" placeholder="Re-type Your Password" name="rpassword" /> </div>
                    </div>
                <!--
                <div class="form-group margin-top-20 margin-bottom-20">
                    <label class="mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="tnc" /> I agree to the
                        <a href="javascript:;">Terms of Service </a> &
                        <a href="javascript:;">Privacy Policy </a>
                        <span></span>
                    </label>
                    <div id="register_tnc_error"> </div>
                </div>
                -->
                <div class="form-actions">
                    <button type="button" id="register-back-btn" class="btn green btn-outline">Back</button>
                    <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">Sign Up</button>
                </div>
            </form>
            <!-- END REGISTRATION FORM -->
        </div>
        <div class="copyright"> <?php echo date('Y');?> © AP Oil Fed </div>
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
        <script src="<?php echo assets_url(); ?>pages/scripts/login.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
    </body>

</html>