<?php $this->load->view('commons/main_template', $nestedView); ?>

<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">  
                <div class="portlet-body">
                    <div class="alert alert-danger display-hide" style="display: none;">
                       <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                    </div>
                	<div class="clearfix">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab_1" data-toggle="tab"> <b>Between Units/C&F's</b> </a>
                            </li>
                            <li>
                                <a href="#tab_2" data-toggle="tab"> <b>From Dealers</b> </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <form id="receipt_form" method="post" action="#" class="form-horizontal">
	                                <div class="scroller" style="height: 320px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
	                                	<div class="form-group">
				                        <label for="inputName" class="col-sm-3 control-label">Stock Return From - To <span class="font-red required_fld">*</span></label>
				                            <div class="col-sm-6">
				                                <div class="input-icon right col-sm-6">
				                                    <i class="fa"></i>
				                                    <?php echo form_dropdown('unit', $unit, @$search_data['unit_id'],'class="form-control" value="" name="unit_from"');?>
				                                </div>
				                                <div class="input-icon right col-sm-6">
				                                    <i class="fa"></i>
				                                    <?php echo form_dropdown('unit', $unit, @$search_data['unit_id'],'class="form-control" value="" name="unit_from"');?>
				                                </div>
				                            </div>
				                        </div>
				                        <div class="form-group">
				                        <label for="inputName" class="col-sm-3 control-label">Vehicle No <span class="font-red required_fld">*</span></label>
				                            <div class="col-sm-6">
				                                <div class="input-icon right">
				                                    <i class="fa"></i>
				                                    <input type="text" class="form-control" id="vehicle" placeholder="Vehicle No" name="vehicle_no" value="" maxlength="15">
				                                </div>
				                            </div>
				                        </div>
				                        <div class="form-group">
				                        <label for="inputName" class="col-sm-3 control-label">Remarks <span class="font-red required_fld">*</span></label>
				                            <div class="col-sm-6">
				                                <div class="input-icon right">
				                                    <i class="fa"></i>
				                                    <textarea type="text" class="form-control" id="remarks" placeholder="Enter Remarks Here..." name="remarks" value="" maxlength="150"></textarea>
				                                </div>
				                            </div>
				                        </div>
								        <div class="form-group">
				                            <div class="col-sm-offset-3 col-sm-10">
				                                <button class="btn blue" type="submit" name="submit" value="button"><i class="fa fa-check"></i> Submit</button>
				                                <a class="btn default" href="<?php echo SITE_URL;?>stock_returns"><i class="fa fa-times"></i> Cancel</a>
				                            </div>
				                        </div>
	                                </div>
                                </form>
                            </div>
                            <div class="tab-pane" id="tab_2">
                            	<form id="receipt_form" method="post" action="#" class="form-horizontal">
	                                <div class="scroller" style="height: 337px;" data-always-visible="1" data-rail-visible1="0" data-handle-color="#D7DCE2">
	                                	<div class="form-group">
				                        <label for="inputName" class="col-sm-3 control-label">Stock Return From - To <span class="font-red required_fld">*</span></label>
				                            <div class="col-sm-6">
				                                <div class="input-icon right col-sm-6">
				                                    <i class="fa"></i>
				                                    <?php echo form_dropdown('distributor', $distributor, @$search_data['distributor_id'],'class="form-control" value="" name="distributor"');?>
				                                </div>
				                                <div class="input-icon right col-sm-6">
				                                    <i class="fa"></i>
				                                    <?php echo form_dropdown('distributor', $distributor, @$search_data['distributor_id'],'class="form-control" value="" name="distributor"');?>
				                                </div>
				                            </div>
				                        </div>
				                        <div class="form-group">
				                        <label for="inputName" class="col-sm-3 control-label">Vehicle No <span class="font-red required_fld">*</span></label>
				                            <div class="col-sm-6">
				                                <div class="input-icon right">
				                                    <i class="fa"></i>
				                                    <input type="text" class="form-control" id="vehicle" placeholder="Vehicle No" name="vehicle_no" value="" maxlength="15">
				                                </div>
				                            </div>
				                        </div>
				                        <div class="form-group">
				                        <label for="inputName" class="col-sm-3 control-label">Remarks <span class="font-red required_fld">*</span></label>
				                            <div class="col-sm-6">
				                                <div class="input-icon right">
				                                    <i class="fa"></i>
				                                    <textarea type="text" class="form-control" id="remarks" placeholder="Enter Remarks Here..." name="remarks" value="" maxlength="150"></textarea>
				                                </div>
				                            </div>
				                        </div>
								        <div class="form-group">
				                            <div class="col-sm-offset-3 col-sm-10">
				                                <button class="btn blue" type="submit" name="submit" value="button"><i class="fa fa-check"></i> Submit</button>
				                                <a class="btn default" href="<?php echo SITE_URL;?>stock_returns"><i class="fa fa-times"></i> Cancel</a>
				                            </div>
				                        </div>
	                                </div>
                                </form>
                            </div>
                        </div>           
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>                    

<?php $this->load->view('commons/main_footer', $nestedView); ?>