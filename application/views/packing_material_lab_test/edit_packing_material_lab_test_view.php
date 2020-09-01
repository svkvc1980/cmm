 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                
                <div class="portlet-body">
                    
                    <form id="labtest_form" method="post" action="<?php echo $form_action;?>"  autocomplete="on" class="form-horizontal">
                        
                        
                        <input type="hidden" name="pm_test_id" value="<?php echo cmm_encode($packing_material_test[0]['pm_test_id']);?>">
                        <input type="hidden" name="edit_range_type_id" value="<?php echo cmm_encode($packing_material_test[0]['range_type_id']);?>">
                        <div class="alert alert-danger display-hide" style="display: none;">
                           <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                        </div>
                        
                        
                        <?php 
                            if($range_type_id==1)
                            {
                                $text_div='';$radio_dropdown_div='hidden';$exactvalue_div='hidden';
                            }
                            else
                            {
                                if($range_type_id==4)
                                {
                                    $text_div='hidden';$radio_dropdown_div='hidden';$exactvalue_div='';
                                }
                                else
                                {
                                    $text_div='hidden';$radio_dropdown_div='';$exactvalue_div='hidden';
                                }
                            }
                        ?>
                        <div class="well col-md-12 testdiv ">
                            <div class="row">
                                <div class="form-group">
                                                                                                                                     
                                    <div class="col-md-4  testname">
                                        <label class="col-xs-2 control-label">Name</label>
                                        <div class="col-xs-10 form-group"> 
                                            <div class="input-icon right">
                                                <i class="fa"></i> 
                                                <input type="text" name="test_name"  value="<?php echo $packing_material_test[0]['name'];?>" class="form-control input-sm" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 testunit">
                                        <label class="col-xs-2 control-label">Unit</label>
                                        <div class="col-xs-10 ">
                                            <div class="input-icon right">
                                                <i class="fa"></i>   
                                                <select class="form-control"  name="test_unit"  >
                                                    <option value="">Select Unit</option>
                                                    <?php
                                                      foreach($test_unit_details as $row)
                                                      {
                                                      $selected = (@$row['test_unit_id']==@$packing_material_test[0]['test_unit_id'])?'selected="selected"':'';
                                                      echo '<option value="'.@$row['test_unit_id'].'"  '.$selected.'>'.@$row['name'].'</option>';
                                                      }
                                                      ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 rangetype">
                                        <label class="col-xs-2 control-label">Type</label>
                                        <div class="col-xs-10 ">  
                                           <div class="input-icon right">
                                                <i class="fa"></i>
                                                <select class="form-control range_type"  name="range_type"  >
                                                    <option value="">Select Range Type</option>
                                                    <?php
                                                      foreach($range_type_details as $row)
                                                      {
                                                        $selected = (@$row['range_type_id']==@$packing_material_test[0]['range_type_id'])?'selected="selected"':'';
                                                        echo '<option value="'.@$row['range_type_id'].'"  '.$selected.'>'.@$row['name'].'</option>';
                                                      }
                                                      ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>                                           
                                                                               
                            
                                </div>     
                            </div>  <hr>
                            <div class="row">
                                <div class="form-group col-md-12 textbox <?php echo $text_div;?> ">
                                    <div class="col-md-3">
                                        <label class="col-md-6 control-label"> Lower Limit  <span class="font-red required_fld">*</span></label>
                                        <div class="col-md-6 form-group">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <input type="text" name="lower_limit"   value="<?php echo @$packing_material_test[0]['lower_limit'];?>"  class="form-control lower_limit" />
                                            </div>
                                        </div>    
                                    </div>  
                                    <div class="col-md-3 ">
                                        <div class="mt-checkbox-list ">
                                            <label class="mt-checkbox outline">
                                                <?php if($packing_material_test[0]['lower_check']==1){?>
                                                <input name="lower_check"  class="form-control lower_check_val" checked="checked" type="checkbox"> Include Lower Limit
                                                <?php }
                                                else
                                                    {?>
                                                    <input name="lower_check"  class="form-control lower_check_val" type="checkbox"> Include Lower Limit
                                                   <?php }?>
                                                <span></span>
                                            </label>
                                        </div>    
                                    </div>
                                    <div class="col-md-3"><span class="font-red up_limit "></span>
                                        <label class="col-md-6 control-label"> Upper Limit  <span class="font-red required_fld">*</span></label>
                                        <div class="col-md-6 form-group">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <input type="text" name="upper_limit"  value="<?php echo @$packing_material_test[0]['upper_limit'];?>"  class="form-control upper_limit" />
                                                
                                            </div>
                                        </div>    
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mt-checkbox-list upper_check_div">
                                            <label class="mt-checkbox outline">
                                                <?php if($packing_material_test[0]['upper_check']==1){?>
                                                <input name="upper_check"  class="form-control lower_check_val" checked="checked" type="checkbox"> Include Upper Limit
                                                <?php }
                                                else
                                                    {?>
                                                    <input name="upper_check"  class="form-control lower_check_val" type="checkbox"> Include Upper Limit
                                                   <?php }?>
                                                <span></span>
                                            </label>
                                        </div>    
                                    </div>                            
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-offset-2 col-md-9">                                            
                                    <div class="form-group radio_dropdown <?php echo $radio_dropdown_div;?> ">
                                        <div class="col-md-12 specification">
                                            <label class="col-md-2 control-label"> Specification  <span class="font-red required_fld">*</span></label>
                                            <div class="col-md-7 form-group">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input class="form-control specification_val"  value="<?php echo @$packing_material_test[0]['specification'];?>" name="specification"  type="text">
                                                </div>
                                            </div>
                                        </div>
                                        <?php 
                                        if(isset($options))
                                        { 
                                            $option_counter = 1;
                                            ?>
                                            <div class="col-md-12 key_value_div">
                                                <input type="hidden" name="new_options[1]" class="edit_option_id" value="1">
                                                <div class="form-group">
                                                    <label class="col-md-1 control-label"> &nbsp;</label>
                                                    <div class="col-md-3">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input class="form-control key" placeholder="Key" name="key[1]"  type="text">
                                                        </div> 
                                                    </div>
                                                    <div class="col-md-3 value_div">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input class="form-control value" placeholder="Value" name="value[1]"  type="text">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 allowed_div ">
                                                        <div class="mt-checkbox-list">
                                                            <label class="mt-checkbox ">
                                                                <input name="allowed[1]"  class="form-control allowed" value="1" checked="checked" type="checkbox"> Allowed 
                                                                 
                                                                <span></span>
                                                            </label>
                                                        </div>    
                                                    </div>
                                                    
                                                    <div class="col-md-2 mybutton_div">
                                                        <a  class="btn btn-sm blue tooltips mybutton" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                                    </div>
                                                    <div class="col-md-2 deletebutton_div hidden">
                                                        <a   class="btn btn-sm btn-danger deletebutton" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-remove"></i></a>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php
                                        }
                                        else
                                        {
                                            $i=1;
                                           foreach ($test_options as $key => $value)
                                            {
                                                $checked=($value['allowed']==1)?'checked':'';
                                                $display_add=($i==1)?'':'hidden';
                                                $display_delete=($i==1)?'hidden':'';
                                                $i++;
                                                $option_counter = $value['option_id'];
                                                ?>
                                            
                                             <div class="col-md-12 key_value_div">
                                                <input type="hidden" name="edit_option_id[]" class="edit_option_id" value="<?php echo $value['option_id'];?>">
                                                <div class="form-group">
                                                    <label class="col-md-1 control-label"> &nbsp;</label>
                                                    <div class="col-md-3">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input class="form-control key"  value="<?php echo @$value['key'];?>" placeholder="Key" name="key[<?php echo $value['option_id'];?>]"  type="text">
                                                        </div> 
                                                    </div>
                                                    <div class="col-md-3 value_div">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input class="form-control value"  value="<?php echo @$value['value'];?>" placeholder="Value" name="value[<?php echo $value['option_id'];?>]"  type="text">
                                                        </div>
                                                    </div>
                                                                                                            
                                                    
                                                    <div class="col-md-3 allowed_div ">
                                                        <div class="mt-checkbox-list">
                                                            <label class="mt-checkbox ">
                                                                <input name="allowed[<?php echo $value['option_id'];?>]"  class="form-control allowed"  <?php echo $checked;?> type="checkbox"> Allowed 
                                                                <span></span>
                                                            </label>
                                                        </div>    
                                                    </div> 
                                                   
                                                    
                                                           
                                                       
                                                    <div class="col-md-2 mybutton_div <?php echo $display_add;?>">
                                                        <a  class="btn btn-sm blue tooltips mybutton" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                                    </div>
                                                    <div class="col-md-2 deletebutton_div <?php echo $display_delete;?>">
                                                        <a   class="btn btn-sm btn-danger deletebutton" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-remove"></i></a>
                                                    </div>         
                                                </div>
                                            </div>
                                        

                                        <?php }
                                        }
                                       ?>         
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-offset-2 col-md-9">
                                <div class="form-group exactvalue <?php echo $exactvalue_div;?> ">
                                    <label class="col-md-3 control-label"> Exact Value  <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6 form-group">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input  name="exact_value" class="form-control exact_val" value="<?php echo @$packing_material_test[0]['lower_limit'];?>"  type="text">  
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>                           
                        </div>
                        
                        
                        
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-5 col-md-6">
                                    <button type="submit" value="1" name="submit" class="btn blue">Submit</button>
                                    <a href="<?php echo SITE_URL.'view_packing_material_lab_tests/'.cmm_encode(@$packing_material_test[0]['pm_category_id']);?>" class="btn default">Cancel</a>
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
<script type="text/javascript">
    var option_counter = <?php echo ($option_counter+1);?>;
</script>
<?php $this->load->view('commons/main_footer', $nestedView); ?>