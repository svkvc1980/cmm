 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                
                <div class="portlet-body">
                	<form id="leakages_form" method="post" action="leakages" class="form-horizontal">
                				<div class="form-group">
                					<label class="col-md-3 control-label">Product Code <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <?php echo form_dropdown('product', $product, @$search_data['product_id'],'class="form-control" value="" name="product"');?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Leakage Entry Date <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control date-picker date" data-date-format="yyyy-mm-dd" name="leakage_date" value="" placeholder="Select leakage date" type="text" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Leakage Quantity <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control" name="leakage_qunatity" value="" placeholder="Leakage Quantity" type="text" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Unit Name <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                           <select class="form-control" name="unit_name">
                                           <option value="" >Select Unit Name</option>
                                           <option>vijayawada</option>
                                           </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-6">
                                            <button type="submit" value="1" class="btn blue">Submit</button>
                                            <a href="<?php echo SITE_URL.'leakages';?>" class="btn default">Cancel</a>
                                        </div>
                                    </div>  
                        			</div>
                        		</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('commons/main_footer', $nestedView); ?>       