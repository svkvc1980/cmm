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
                                
                                
                                    <input type="hidden" name="loose_oil_id" value="<?php echo cmm_encode($loose_oil_id);?>">
                                    <input type="hidden" name="test_group_id" value="<?php echo cmm_encode($test_group_id);?>">
                                    
                                <div class="alert alert-danger display-hide" style="display: none;">
                                   <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                                </div>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-md-3">
                                        <h4><?php echo '<b>Loose Oil:</b>'.$loose_oil;?></h4>
                                    </div>
                                    <div class="col-md-3">
                                       <h4> <?php echo '<b>Test Group:</b>'.@$test_group;?></h4>
                                    </div>
                                    <div class="col-md-1">
                                        
                                    </div>
                                    <div class="col-md-1 addtest">
                                        <a  id="" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i>Add New Test</a>
                                    </div>                                    
                                    
                                </div>
                                
                                <div class="well col-md-12 testdiv ">
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-md-1">
                                                <span class="test_sno">1)</span>                                                
                                            </div>                                                                                                 
                                            <div class="col-md-4  testname">
                                                <label class="col-xs-2 control-label">Name</label>
                                                <div class="col-xs-10 form-group"> 
                                                    <div class="input-icon right">
                                                        <i class="fa"></i> 
                                                        <input type="text" required="required" name="test_name[1]" class="form-control input-sm" placeholder="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3 testunit">
                                                <label class="col-xs-2 control-label">Unit</label>
                                                <div class="col-xs-10 ">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>   
                                                        <select class="form-control"  name="test_unit[1]"  >
                                                            <option value="">Select Unit</option>
                                                            <?php
                                                              foreach($test_unit_details as $row)
                                                              {
                                                              $selected = (@$row['test_unit_id']==@$parentInfo['test_unit_id'])?'selected="selected"':'';
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
                                                        <select class="form-control range_type" required="required" name="range_type[1]"  >
                                                            <option value="">Select Range Type</option>
                                                            <?php
                                                              foreach($range_type_details as $row)
                                                              {
                                                                $selected = (@$row['range_type_id']==@$parentInfo['range_type_id'])?'selected="selected"':'';
                                                                echo '<option value="'.@$row['range_type_id'].'"  '.$selected.'>'.@$row['name'].'</option>';
                                                              }
                                                              ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>                                           
                                            <div class="col-md-1 delete_test_div hidden">                                        
                                                <a  class="btn btn-sm btn-danger tooltips delete_test" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-times"></i></a>
                                            </div>                                            
                                    
                                        </div>     
                                    </div>  <hr>

                                    <div class="row">
                                        <div class="form-group col-md-12 textbox hidden">
                                            <div class="col-md-3">
                                                <label class="col-md-6 control-label"> Lower Limit  <span class="font-red required_fld">*</span></label>
                                                <div class="col-md-6 form-group">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>
                                                        <input type="text" name="lower_limit[1]"   value="<?php echo @$employee_details['first_name'];?>"  class="form-control lower_limit" />
                                                    </div>
                                                </div>    
                                            </div>  
                                            <div class="col-md-3">
                                                <div class="mt-checkbox-list">
                                                    <label class="mt-checkbox outline">
                                                        <input name="lower_check[1]" value="1" type="checkbox"> Include Lower Limit
                                                        <span></span>
                                                    </label>
                                                </div>    
                                            </div>
                                            <div class="col-md-3"><span class="font-red up_limit "></span>
                                                <label class="col-md-6 control-label"> Upper Limit  <span class="font-red required_fld">*</span></label>
                                                <div class="col-md-6 form-group">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>
                                                        <input type="text" name="upper_limit[1]"  value="<?php echo @$employee_details['first_name'];?>"  class="form-control upper_limit" />
                                                        
                                                    </div>
                                                </div>    
                                            </div>
                                            <div class="col-md-3">
                                                <div class="mt-checkbox-list">
                                                    <label class="mt-checkbox outline">
                                                        <input name="upper_check[1]" value="1" type="checkbox"> Include Upper Limit
                                                        <span></span>
                                                    </label>
                                                </div>    
                                            </div>                            
                                        </div>
                                    </div>
                                    <div class="row">
                                        <input type="hidden" name="t_counter[]" class="t_counter" value="1">
                                        <div class="col-md-offset-2 col-md-9">                                            
                                            <div class="form-group radio_dropdown hidden">
                                                <div class="col-md-12 specification">
                                                <label class="col-md-2 control-label"> Specification  <span class="font-red required_fld">*</span></label>
                                                    <div class="col-md-7 form-group">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input class="form-control value" name="specification[1]" id="" type="text">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 key_value_div">

                                                     <div class="form-group">
                                                         <label class="col-md-1 control-label"> &nbsp;</label>
                                                         <div class="col-md-3">
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input class="form-control key" placeholder="Key" name="key[1][1]"  type="text">
                                                                <input type="hidden" name="op_counter[]" class="op_counter" value="1">

                                                            </div> 
                                                        </div>
                                                         <div class="col-md-3 value_div">
                                                             <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input class="form-control value" placeholder="Value" name="value[1][1]"  type="text">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3 allowed_div ">
                                                            <div class="mt-checkbox-list">
                                                                <label class="mt-checkbox ">
                                                                    <input name="allowed[1][1]"  class="form-control allowed" value="1" checked="checked" type="checkbox"> Allowed 
                                                                     
                                                                    <span></span>
                                                                </label>
                                                            </div>    
                                                        </div>
                                                        
                                                        <div class="col-md-2 mybutton_div">
                                                            <a  class="btn btn-sm blue tooltips mybutton" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                                        </div>
                                                        <div class="col-md-2 deletebutton_div hide">
                                                            <a   class="btn btn-sm btn-danger deletebutton" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-remove"></i></a>
                                                        </div>
                                                    </div>
                                                </div>                             
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="col-md-offset-2 col-md-9">
                                        <div class="form-group exactvalue hidden">
                                            <label class="col-md-3 control-label"> Exact Value  <span class="font-red required_fld">*</span></label>
                                            <div class="col-md-6 form-group">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input  name="exact_value[1]" class="form-control" value="<?php echo @$broker_row['broker_code'];?>"  type="text">  
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-5 col-md-6">
                                            <button type="submit" value="1" name="submit" class="btn blue">Submit</button>
                                            <a href="<?php echo SITE_URL.'loose_oil_lab_test';?>" class="btn default">Cancel</a>
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
                                <label class="col-md-3 control-label">Loose Oil <span class="font-red required_fld">*</span></label>
                                <div class="col-md-6">                                       
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <select class="form-control" id="" name="loose_oil"  >
                                            <option value="">Select Loose Oil</option>
                                            <?php
                                              foreach($loose_oil_details as $row)
                                              {
                                                  $selected = (@$row['loose_oil_id']==@$parentInfo['loose_oil_id'])?'selected="selected"':'';
                                                  echo '<option value="'.@$row['loose_oil_id'].'"  '.$selected.'>'.@$row['name'].'</option>';
                                              }
                                              ?>
                                        </select> 
                                    </div>    
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Test Group <span class="font-red required_fld">*</span></label>
                                <div class="col-md-6">                                       
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <select class="form-control" id="" name="test_group"  >
                                            <option value="">Select Test Group</option>
                                            <?php
                                              foreach($test_group_details as $row)
                                              {
                                              $selected = (@$row['test_group_id']==@$parentInfo['test_group_id'])?'selected="selected"':'';
                                              echo '<option value="'.@$row['test_group_id'].'"  '.$selected.'>'.@$row['name'].'</option>';
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
                                        <a href="<?php echo SITE_URL.'loose_oil_lab_test';?>" class="btn default">Cancel</a>
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