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
                            <form id="send_loose_oil_form" method="post" action="#" class="form-horizontal">
                                <?php
                                if($flg==2){
                                    ?>
                                    <input type="hidden" name="encoded_id" value="<?php echo eip_encode($send_loose_oil_row['send_loose_oil_id']);?>">
                                    <?php
                                }
                                ?>
                                <input type="hidden" id="send_loose_oil_id" name="send_loose_oil_id" value="<?php echo @$send_loose_oil_row['send_loose_oil_id'] ?>">

                                <div class="alert alert-danger display-hide" style="display: none;">
                                   <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                                </div>                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Loose Oil Product<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <?php echo form_dropdown('loose_oil_product',$loose_oil_product,@$search_data['loose_oil_product_name'],'class="form-control", name="loose_oil_product"');?>
                                         </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Send Date<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                             <input class="form-control date-picker date" date-date-format="yyyy-mm-dd" name="send_date" value="<?php echo @$send_loose_oil_row['send_date'];?>" placeholder="" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Qty(MT)<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control" name="quantity" value="<?php echo @$send_loose_oil_row['quantity'];?>" placeholder="quantity" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">From(OPS)<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <select class="form-control" name="ops">
                                                <option value="">Select ops</option>
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
                                            <a href="<?php echo SITE_URL.'add_send_loose_oil';?>" class="btn default">Cancel</a>
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

