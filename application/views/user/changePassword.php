 <?php $this->load->view('commons/main_template', $nestedView); ?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="portlet light portlet-fit ">
        <div class="portlet-title">
            <div class="caption">
                <i class=" fa fa-lock font-green"></i>
                <span class="caption-subject font-green bold uppercase">Enter Details Below to Change Password</span>
            </div>
            <div class="actions">   
            </div>
        </div>
        <div class="portlet-body">
            <!-- BEGIN FORM-->
            <form action="<?php echo SITE_URL; ?>changePassword" class="form-horizontal changePassword-form" method="post">
                <div class="form-body">
                    
                    <div class="form-group">
                        <label class="control-label col-md-4">Old Password <span class="font-red required_fld">*</span>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <i class="fa"></i>
                                <input type="password" class="form-control" name="oldPassword" placeholder="Old Password" /> 
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">New Password <span class="font-red required_fld">*</span>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <i class="fa"></i>
                                <input type="text" placeholder="New Password" class="form-control" name="newPassword" id="newPassword"/> 
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-4">Confirm New Password <span class="font-red required_fld">*</span>
                        </label>
                        <div class="col-md-4">
                            <div class="input-icon right">
                                <i class="fa"></i>
                                <input type="text" placeholder="Confirm New Password" class="form-control" name="cnewPassword" /> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-5 col-md-8">
                            <button type="submit" class="btn green" onclick="return confirm('Are you sure you want to Change Password?')" >Submit</button>
                            <a href="<?php echo SITE_URL;?>" class="btn default">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END FORM-->

        </div>
    </div>
</div>
<?php //print_r($_SESSION); ?>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer.php', $nestedView); ?>