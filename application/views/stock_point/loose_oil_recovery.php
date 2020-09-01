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
                    <form id="loose_oil_form" method="post" action="#" class="form-horizontal">
                        <div class="form-group">
                        <label for="inputName" class="col-sm-3 control-label">Product Name <span class="font-red required_fld">*</span></label>
                            <div class="col-sm-6">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <?php echo form_dropdown('product', $product, @$search_data['product_id'],'class="form-control" value="" name="product"');?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        <label for="inputName" class="col-sm-3 control-label">Recovery Date <span class="font-red required_fld">*</span></label>
                            <div class="col-sm-6">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control date-picker date" data-date-format="yyyy-mm-dd" id="recovery_date" placeholder="Recovery Date" name="recovery_date" value="" maxlength="150">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        <label for="inputName" class="col-sm-3 control-label">Recovery Quantity (Kg's) <span class="font-red required_fld">*</span></label>
                            <div class="col-sm-6">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control numeric" id="dd_amount" placeholder="Recovery Quantity" name="recovery_quantity" value="" maxlength="15">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        <label for="inputName" class="col-sm-3 control-label">Unit Name <span class="font-red required_fld">*</span></label>
                            <div class="col-sm-6">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <?php echo form_dropdown('unit', $unit, @$search_data['unit_id'],'class="form-control" value="" name="unit"');?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-10">
                                <button class="btn blue" type="submit" name="submit" value="button"><i class="fa fa-check"></i> Submit</button>
                                <a class="btn default" href="<?php echo SITE_URL;?>loose_oil_recovery"><i class="fa fa-times"></i> Cancel</a>
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