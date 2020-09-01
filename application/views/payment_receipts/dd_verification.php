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
                    <form id="receipt_form" method="post" action="<?php SITE_URL;?>dd_verification" class="form-horizontal">
                        <div class="form-group">
                        <label for="inputName" class="col-sm-3 control-label">Distributor Code <span class="font-red required_fld">*</span></label>
                            <div class="col-sm-6">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <?php echo form_dropdown('distributor', $distributor, @$search_data['distributor_id'],'class="form-control" value="" name="distributor"');?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        <label for="inputName" class="col-sm-3 control-label">DD Number <span class="font-red required_fld">*</span></label>
                            <div class="col-sm-6">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="name" class="form-control" id="dd_number" placeholder="DD Number" name="dd_number" value="" maxlength="15">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        <label for="inputName" class="col-sm-3 control-label">DD Date <span class="font-red required_fld">*</span></label>
                            <div class="col-sm-6">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="name" class="form-control date-picker date" data-date-format="yyyy-mm-dd" id="dd_date" placeholder="DD Date" name="dd_date" value="" maxlength="150">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        <label for="inputName" class="col-sm-3 control-label">DD Amount <span class="font-red required_fld">*</span></label>
                            <div class="col-sm-6">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="name" class="form-control numeric" onkeyup="javascript:this.value=Comma(this.value);" id="dd_amount" placeholder="DD Amount" name="dd_amount" value="" maxlength="15">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        <label for="inputName" class="col-sm-3 control-label">Bank Name <span class="font-red required_fld">*</span></label>
                            <div class="col-sm-6">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <?php echo form_dropdown('bank', $bank, @$search_data['bank_id'],'class="form-control" value="" name="bank"');?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-10">
                                <button class="btn blue" type="submit" name="submit" value="button"><i class="fa fa-check"></i> Submit</button>
                                <a class="btn default" href="<?php echo SITE_URL;?>dd_verification"><i class="fa fa-times"></i> Cancel</a>
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