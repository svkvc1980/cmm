 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                      <form id="update_settings" method="post" action="<?php echo $form_action;?>" class="form-horizontal">
                        <?php foreach ($preference_list as $pre) {?>
                        <input type="hidden" name="old[<?php echo $pre['preference_id']; ?>]"  value="<?php echo $pre['value']; ?>">
                        <div class="form-group">
                            <label class="col-md-4 control-label"><?php echo $pre['lable'];?> <span class="font-red required_fld">*</span></label>
                            <div class="col-md-5">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input class="form-control" type="text" name="preference[<?php echo $pre['preference_id']; ?>]" value="<?php echo $pre['value'];?>">
                                 </div>
                            </div>
                        </div>
                        <?php }?>                                            
                       <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-5 col-md-6">
                                    <button type="submit" value="1" name="submit" class="btn blue">Submit</button>
                                    <a href="<?php echo SITE_URL.'edit_general_settings';?>" class="btn default">Cancel</a>
                                </div>
                            </div>  
                        </div>
                      </form>
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->

<?php $this->load->view('commons/main_footer', $nestedView); ?>


