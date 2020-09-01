<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
	                <form method="post"  action="<?php echo SITE_URL.'individual_unit_do_detail';?>" class="form-horizontal">
                        <div class="row">
                           <div class="col-md-offset-3 col-md-6 well">
                                <div class="form-group">
                                  <label for="inputName" class="col-sm-5 control-label"> Enter Delivery Order No:<span class="font-red required_fld">*</span></label>
                                    <div class="col-sm-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" class="form-control" required id="" placeholder="Enter Delivery Order No" name="order_number" value="" maxlength="150">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6"></div>
                                 	<div class="col-xs-4">
                               			<input type="submit" class="btn blue" name="submit" value="submit">
                                 		<a href="<?php echo SITE_URL.'individual_unit_do';?>" class="btn default">Cancel</a>
                                	</div>                                 
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