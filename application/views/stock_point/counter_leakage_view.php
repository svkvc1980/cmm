 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                
                <div class="portlet-body">
                    <?php
                    if(isset($flg))
                    {
                        ?>
                            <form id="counter_leakage_form" method="post" action="#" class="form-horizontal">
                                <?php
                                if($flg==2){
                                    ?>
                                    <input type="hidden" name="encoded_id" value="<?php echo eip_encode($counter_leakage_row['counter_leakage_id']);?>">
                                    <?php
                                }
                                ?>
                                <input type="hidden" id="counter_leakage_id" name="counter_leakage_id" value="<?php echo @$counter_leakage_row['counter_leakage_id'] ?>">

                                <div class="alert alert-danger display-hide" style="display: none;">
                                   <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                                </div>                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Product Code<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <?php echo form_dropdown('product',$product,@$search_data['product_code'],'class="form-control", name="product"');?>
                                         </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Leakage Date<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                             <input class="form-control date-picker date" date-date-format="yyyy-mm-dd"name="leakage_date" value="<?php echo @$counter_leakage_row['leakage_date'];?>" placeholder="leakage date" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">LeakageEntry Qty<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control" name="leakage_qty" value="<?php echo @$counter_leakage_row['leakage_qty'];?>" placeholder="Leakage qty" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Unit Name<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <select class="form-control" name="unit_name" id="unit name" >
                                                <option value="">Select Unit</option>
                                                <option value="vijayawada">Vijayawada</option>
                                                <option value="hyderabad">Hyderabad</option>                                                        
                                            </select>
                                        </div>
                                    </div>
                                </div>
                               <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-6">
                                            <button type="submit" value="1" class="btn blue">Submit</button>
                                            <a href="<?php echo SITE_URL.'counter_leakage_view';?>" class="btn default">Cancel</a>
                                        </div>
                                    </div>  
                                </div>
                            </form> 
                     <?php
                       }
                     ?>                    
                    </div>
               </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>
