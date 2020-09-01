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
                            <form id="labtest_form" method="post" action="<?php echo $form_action;?>"  autocomplete="on" class="form-horizontal">
                                <input type="hidden" name="product_id" value="<?php echo $product_id;?>">
                                <div class="alert alert-danger display-hide" style="display: none;">
                                   <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                                </div>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-3">
                                        <h4><?php echo '<b>Product:</b>'.get_product_name($product_id);?></h4>
                                        <input type="hidden" name="product_id" value="<?php echo $product_id;?>">
                                    </div>                                    
                                    <div class="col-md-1">                                        
                                    </div>                                
                                </div>
                                
                                <div class="well col-md-12  ">
                                    <h4> Primary Material </h4>
                                    <div class="row testdiv1"> 
                                        <div class="form-group">
                                            <div class="col-md-1">
                                                <span class="test_sno1">1)</span>                                                
                                            </div>                                                                                 
                                            
                                            <div class="col-md-5 ">
                                                <label class="col-xs-6 control-label">Packing Material</label>
                                                <div class="col-xs-6 ">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>   
                                                        <select class="form-control pm_id1_cls" required name="pm_id1[]"  >
                                                            <option value="">Select Packing Material</option>
                                                            <?php
                                                              foreach($primary_type as $row)
                                                              {
                                                              //$selected = (@$row['pm_id']==@$parentInfo['test_unit_id'])?'selected="selected"':'';
                                                              echo '<option value="'.@$row['pm_id'].'" data-p-type1="'.@$row['u_type'].'"  data-c-type1="'.@$row['c_id'].'"  >'.@$row['name'].'</option>';
                                                              }
                                                              ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 ">
                                                <label class="col-xs-6 control-label">Quantity</label>
                                                <div class="col-xs-6 ">  
                                                   <div class="input-icon right">
                                                        <i class="fa"></i>
                                                         <input class="form-control quantity1_cls" required value="" name="quantity1[]"  type="text">
                                                         <input class="form-control capacity1_cls"  value="" name="capacity1[]"  type="hidden">
                                                         <span class="u_type1"></span>   
                                                    </div>
                                                </div>
                                            </div>                                           
                                            <div class="col-md-1 mybutton_div1">
                                                <a  class="btn btn-sm blue tooltips mybutton1" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                            </div>
                                            <div class="col-md-1 deletebutton_div1 hidden">
                                                <a   class="btn btn-sm btn-danger deletebutton1" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-remove"></i></a>
                                            </div>                                            
                                    
                                        </div>     
                                    </div>                                    
                                </div>
                                <div class="well col-md-12 ">
                                    <h4> Secondary Material</h4>
                                    <div class="row testdiv2">
                                        
                                        <div class="form-group">
                                            <div class="col-md-1">
                                                <span class="test_sno2">1)</span>                                                
                                            </div>                                                                                                 
                                            
                                            <div class="col-md-5 ">
                                                <label class="col-xs-7 control-label">Secondary Packing Material</label>
                                                <div class="col-xs-5 ">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>   
                                                        <select class="form-control pm_id2_cls" name="pm_id2[]"  >
                                                            <option value="">Select PM</option>
                                                            <?php
                                                              foreach($secondary_type as $row)
                                                              {
                                                              $selected = (@$row['pm_id']==@$parentInfo['test_unit_id'])?'selected="selected"':'';
                                                              echo '<option value="'.@$row['pm_id'].'"  data-p-type2="'.@$row['u_type'].'" data-c-type2="'.@$row['c_id'].'" >'.@$row['name'].'</option>';
                                                              }
                                                              ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 ">
                                                <label class="col-xs-6 control-label">Quantity</label>
                                                <div class="col-xs-6">  
                                                   <div class="input-icon right">
                                                        <i class="fa"></i>
                                                         <input class="form-control" value="" name="quantity2[]"  type="text"> 
                                                         <input class="form-control capacity2_cls"  value="" name="capacity2[]"  type="hidden"> 
                                                         <span class="u_type2"></span>    
                                                    </div>
                                                </div>
                                            </div>                                           
                                           <div class="col-md-1 mybutton_div2">
                                                <a  class="btn btn-sm blue tooltips mybutton2" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                            </div>
                                            <div class="col-md-1 deletebutton_div2 hidden">
                                                <a   class="btn btn-sm btn-danger deletebutton2" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-remove"></i></a>
                                            </div>                                
                                    
                                        </div>     
                                    </div>                                    
                                </div>                  
                                
                                
                                
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-5 col-md-6">
                                            <button type="submit" value="1" name="submit" class="btn blue">Submit</button>
                                            <a href="<?php echo SITE_URL.'manage_pm_consumption';?>" class="btn default">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php
                    }

                    
                    if(isset($display_results)&&$display_results==3)
                    {?>
                        <form id="add_loose_oil_lab_test_form" method="post" action="<?php echo $form_action;?>"  autocomplete="on" class="form-horizontal">
                            <?php
                            if(@$flg==2){
                                ?>
                                <input type="hidden" name="encoded_id" value="<?php echo cmm_encode($broker_row['broker_id']);?>">
                                <?php
                            }
                            ?>
                            <div class="alert alert-danger display-hide" style="display: none;">
                               <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Product <span class="font-red required_fld">*</span></label>
                                <div class="col-md-6">                                       
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <select class="form-control" id="" required name="product_id"  >
                                            <option value="">Select Product</option>
                                            <?php
                                              foreach($products as $row)
                                              {
                                                  $selected = (@$row['product_id']==@$parentInfo['loose_oil_id'])?'selected="selected"':'';
                                                  echo '<option value="'.@$row['product_id'].'"  '.$selected.'>'.@$row['name'].'</option>';
                                              }
                                              ?>
                                        </select> 
                                    </div>    
                                </div>
                            </div>
                                                       
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-5 col-md-6">
                                        <button type="submit" value="1" name="submit" class="btn blue">Submit</button>
                                        <a href="<?php echo SITE_URL.'manage_pm_consumption';?>" class="btn default">Cancel</a>
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