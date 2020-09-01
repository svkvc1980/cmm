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
                            <form id="free_sample_form" method="post" action="#" class="form-horizontal">
                                <?php
                                if($flg==2){
                                    ?>
                                    <input type="hidden" name="encoded_id" value="<?php echo eip_encode($free_sample_row['free_sample_id']);?>">
                                    <?php
                                }
                                ?>
                                <input type="hidden" id="free_sample_id" name="free_sample_id" value="<?php echo @$free_sample_row['free_sample_id'] ?>">

                                <div class="alert alert-danger display-hide" style="display: none;">
                                   <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                                </div>                                
                            <div class="form-group">
                                    <label class="col-md-3 control-label">DD Number<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control" name="DD_number" value="<?php echo @$free_sample_row['DD_number'];?>" placeholder="DD number" type="text">
                                        </div>
                                    </div>
                                </div>    
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Date<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control date-picker date" date-date-format="yyyy-mm-dd" name="date" value="<?php echo @$free_sample_row['Date'];?>" placeholder="Date" type="text">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Sample Name<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                <select class="form-control" name="Sample_name" >
                                                     <option value="">Sample Name</option>
                                                      <option value="packet">packet</option>
                                                      <option value="sachet">sachet</option>
                                                       <option value="jar">jar</option>
                                                        <option value="bag">bag</option>
                                                  
                                                 </select>
                                                 </div>
                                    </div>
                                </div>
                                
                            <div class="form-group">
                                    <label class="col-md-3 control-label">Product  Name<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                                <?php echo form_dropdown('product', $product, @$search_data['product_id'],'class="form-control" value="" name="product"');?>
                                        </div>
                                    </div>
                            </div>  
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Quantity<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control" name="Quantity" value="<?php echo @$free_sample_row['Quantity'];?>" placeholder="Quantity" type="text">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Description<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control" name="Description" value="<?php echo @$free_sample_row['Description'];?>" placeholder="Description" type="text area">
                                        </div>
                                    </div>
                                </div>
                               <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-6">
                                            <button type="submit" value="1" class="btn blue">Submit</button>
                                            <a href="<?php echo SITE_URL.'add_free_sample';?>" class="btn default">Cancel</a>
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