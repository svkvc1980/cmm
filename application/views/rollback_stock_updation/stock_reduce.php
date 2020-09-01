<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <form  method="post" action="<?php echo SITE_URL.'reduce_stock_updation';?>"  class="form-horizontal stock_updation">
                        <div class="row "> 
                            <div class="form-group">
                                <label class="col-md-4 control-label">Select Unit <span class="font-red required_fld">*</span></label>
                                <div class="col-md-4">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select  class="form-control plant_id" name="plant_id">
                                        <option selected value="">-Select Unit-</option>
                                        <?php 
                                            foreach($ops as $op)
                                            {
                                                $selected = '';
                                                if($op['plant_id'] ==@$plant_id) $selected = 'selected';
                                                echo '<option value="'.$op['plant_id'].'" '.$selected.' >'.$op['plant_name'].'</option>';
                                            }
                                        ?>
                                    </select> 
                                </div>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-md-4 control-label">Select Product <span class="font-red required_fld">*</span></label>
                                <div class="col-md-4">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                    <select  class="form-control product_id" name="product_id">
                                        <option selected value="">-Select Product-</option>
                                        <?php 
                                            foreach($product as $pro)
                                            {
                                                echo '<option value="'.$pro['product_id'].'">'.$pro['product_name'].'</option>';
                                            }
                                        ?>
                                    </select> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Available Stock(in Sachets)</label>
                                <div class="col-md-4">
                                    <p class="old_quantity form-control-static" name="old_quantity"><b>--</b></p> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Reduce Quantity(in Sachets) <span class="font-red required_fld">*</span></label>
                                <div class="col-md-4">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" name="new_quantity" maxlength="15" class="form-control numeric">
                                </div>
                                </div>
                            </div> 
                            <div class="form-group">
                                <label class="col-md-4 control-label">Remarks <span class="font-red required_fld">*</span></label>
                                <div class="col-md-4">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <textarea name="remarks" class="form-control"></textarea>
                                </div>
                                </div>
                            </div> 
                            
                            <div class="form-group">
                                <div class="col-md-5"></div>
                                    <div class="col-md-6">
                                        <input type="submit" class="btn blue tooltips" onclick="return confirm('Are you sure you want to Reduce Stock?')" value="Reduce Stock" name="submit">
                                        <a href="<?php echo SITE_URL;?>" class="btn default">Cancel</a>
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