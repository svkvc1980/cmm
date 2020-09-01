 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                
                <div class="portlet-body">                  
                    <form id="mmtc_bulkreceipt" method="post" action="<?php echo @$form_action;?>" class="form-horizontal">
                      
                        <div class="alert alert-danger display-hide" style="display: none;">
                           <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Product Code <span class="font-red required_fld">*</span></label>
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select class="form-control" name="oil_name" id="oil_name" >
                                        <option value="">Select Oil Name</option>
                                        <option value="1"> Red Palmolein Oil</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Received Date <span class="font-red required_fld">*</span></label>
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control date-picker date" data-date-format="yyyy-mm-dd"  placeholder="Received Date" name="received_date" value="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Received Qty <span class="font-red required_fld">*</span></label>
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input class="form-control" name="received_quantity" value="<?php echo @$broker_row['concerned_person'];?>" placeholder="Received Qty" type="text">
                                </div>
                            </div>
                        </div>                        
                        
                        <div class="form-group">
                            <label class="col-md-3 control-label">Vessel Number <span class="font-red required_fld">*</span></label>
                            <div class="col-md-6">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input class="form-control" name="vessel_number" value="<?php echo @$broker_row['phone_number'];?>" placeholder="Vessel Number" type="text">
                                </div>
                            </div>
                        </div>                   
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-6">
                                    <button type="submit" value="1" class="btn blue">Submit</button>
                                    <a href="<?php echo SITE_URL.'broker';?>" class="btn default">Cancel</a>
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
