<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">  
                <div class="portlet-body">
                    <div class="alert alert-danger display-hide" style="display: none;">
                       <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                    </div>
                       <form id="receipt_form" method="post" action="<?php SITE_URL;?>dd_receipts" class="form-horizontal">
                          <div class="form-group">
                              <label for="inputName" class="col-sm-3 control-label"> Date <span class="font-red required_fld">*</span></label>
                                 <div class="col-sm-6">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="name" class="form-control date-picker date" data-date-format="yyyy-mm-dd" id="date" placeholder="Date" name="date" value="" maxlength="150">
                                    </div>
                                </div>
                            </div>
                               <div class="form-group">
                                 <label class="col-md-3 control-label"> Sample Name<span class="font-notered required_fld">*</span></label>
                                   <div class="col-md-6">
                                     <div class="input-icon right">
                                       <i class="fa"></i>
                                       <input class="form-control" name="sample_name" value="<?php echo @$lrow['sample_name'];?>" id="SampleName" placeholder="Sample Name" type="text">
                                       <!-- <p id="banknameValidating" class="hidden"><i class="fa fa-spinner fa-spin"></i> Checking...</p>
                                       <p id="bankError" class="error hidden"></p> -->
                                     </div>
                                   </div>
                                </div>
                           <div class="form-group">
                             <label for="inputName" class="col-sm-3 control-label">Quantity<span class="font-red required_fld">*</span></label>
                               <div class="col-sm-6">
                                 <div class="input-icon right">
                                     <i class="fa"></i>
                                     <input type="name" class="form-control" id="quantity" placeholder="Quantity" name="quantity" value="" maxlength="15">
                                 </div>
                               </div>
                            </div>
                          <div class="form-group">
                            <label for="inputName" class="col-sm-3 control-label">Select Unit Code<span class="font-red required_fld">*</span></label>
                                <div class="col-sm-6">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <?php echo form_dropdown('unit', $unit, @$search_data['unit_id'],'class="form-control" value="" name="unit"');?>
                                    </div>
                                </div>
                            </div>
                           <div class="form-group">
                                <label class="col-md-3 control-label">Description</label>
                                <div class="col-md-6">      
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                          <textarea class="form-control" name="description" placeholder=""><?php echo @$lrow['description'];?></textarea>
                                    </div>
                                </div>
                            </div>
                          <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-10">
                                  <button class="btn blue" type="submit" name="submit" value="button"><i class="fa fa-check"></i> Submit</button>
                                  <a class="btn default" href="<?php echo SITE_URL;?>dd_verificaton"><i class="fa fa-times"></i> Cancel</a>
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