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
                    <form id="broker_form" method="post" action="<?php echo $form_action;?>"  autocomplete="on" class="form-horizontal">
                        <?php
                        if($flg==2){
                            ?>
                            <input type="hidden" name="encoded_id" value="<?php echo cmm_encode($broker_row['broker_id']);?>">
                            <?php
                        }
                        ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Broker Code <span class="font-red required_fld">*</span></label>
                                        <div class="col-md-6">
                                          <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input  class="form-control numeric" value="<?php echo @$broker_row['broker_code'];?>" style="height:30px;" type="text" name="broker_code">  
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Agency Name <span class="font-red required_fld">*</span></label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input  class="form-control" value="<?php echo @$broker_row['agency_name'];?>" style="height:30px;" type="text" name="agency_name">  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                  <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Concerned Person </label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input  class="form-control" value="<?php echo @$broker_row['concerned_person'];?>" style="height:30px;" type="text" name="concerned_person">  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label" for="form-field-1">Address </label>
                                                <div class="col-md-6">
                                                    <textarea   id="dateFrom" class="form-control form-control" style="height:30px;"  name="address"><?php echo @$broker_row['address'];?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                   </div>
                                    <div class="row"> 
                                       <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label" for="form-field-1">State </label>
                                                <div class="col-md-6">
                                                <div class="input-icon right">
                                                        <i class="fa"></i>
                                                    <select name="state" class="form-control state" style="height:30px;"> 
                                                    <option value="">-Select State-</option>
                                                    <?php 

                                                foreach($state as $stat)
                                                {
                                                    $selected = "";
                                                    if($stat['location_id']== @$loacation_parent_id)
                                                        { 
                                                            $selected='selected';
                                                        }
                                                    echo '<option value="'.$stat['location_id'].'" '.$selected.' >'.$stat['name'].'</option>';
                                                }
                                            ?>
                                            </select>   
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="col-md-4 control-label" for="form-field-1">Region</label>
                                        <div class="col-md-6">
                                          <div class="input-icon right">
                                            <i class="fa"></i>
                                             <select name="region" class="form-control region_id" style="height:30px;"> 
                                             <option value="">-Select Region-</option>
                                             <?php if($flg==2)
                                             {
                                               foreach($region as $reg)
                                                {
                                                    $selected = "";
                                                    if($reg['location_id']== @$region_parent_id)
                                                        { 
                                                            $selected='selected';
                                                        }
                                                    echo '<option value="'.$reg['location_id'].'" '.$selected.' >'.$reg['name'].'</option>';
                                                }
                                            }
                                            ?>
                                            </select>   
                                          </div>
                                        </div>
                                     </div>
                                  </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="form-field-1">District</label>
                                            <div class="col-md-6">
                                              <div class="input-icon right">
                                                <i class="fa"></i>
                                                <select name="district" class="form-control district" style="height:30px;"> 
                                                <option value="">-Select District-</option>
                                                 <?php if($flg==2)
                                                  {
                                                    foreach($district as $dis)
                                                    {
                                                        $selected = "";
                                                        if($dis['location_id']== @$district_parent_id)
                                                            { 
                                                                $selected='selected';
                                                            }
                                                        echo '<option value="'.$dis['location_id'].'" '.$selected.' >'.$dis['name'].'</option>';
                                                    }
                                                }
                                                ?>
                                                </select>   
                                             </div>
                                         </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <label class="col-md-4 control-label" for="form-field-1">Mandal</label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                <i class="fa"></i>
                                                <select name="mandal" class="form-control mandal" style="height:30px;"> 
                                                <option value="">-Select Mandal-</option>
                                                 <?php if($flg==2)
                                                  {
                                                    foreach($mandal as $man)
                                                    {
                                                        $selected = "";
                                                        if($man['location_id']== @$mandal_parent_id)
                                                            { 
                                                                $selected='selected';
                                                            }
                                                        echo '<option value="'.$man['location_id'].'" '.$selected.' >'.$man['name'].'</option>';
                                                    }
                                                }
                                                ?>
                                                </select>   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                         <div class="form-group">
                                           <label class="col-md-4 control-label" for="form-field-1">City/Town </label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                <i class="fa"></i>
                                                <select name="city" class="form-control area" style="height:30px;"> 
                                                    <option value="">-Select City/Town-</option>
                                                      <?php if($flg==2)
                                                      {
                                                        foreach($city as $cit)
                                                        {
                                                            $selected = "";
                                                            if($cit['location_id']== @$city_parent_id)
                                                                { 
                                                                    $selected='selected';
                                                                }
                                                            echo '<option value="'.$cit['location_id'].'" '.$selected.' >'.$cit['name'].'</option>';
                                                        }
                                                    }
                                                    ?>
                                                </select>   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="form-field-1">Pin Code </label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input class="form-control numeric" value="<?php echo @$broker_row['pincode'];?>" style="height:30px;" type="text" name="pincode">   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="col-md-6">
                                           <div class="form-group">
                                            <label class="col-md-4 control-label" for="form-field-1"> Mobile No.</label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input class="form-control" value="<?php echo @$broker_row['mobile'];?>"  type="number" name="mobile">        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="form-field-1"> Alternate Mobile No.</label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input  class="form-control" value="<?php echo @$broker_row['alternate_mobile'];?>"  type="number" name="alternate_mobile">        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="form-field-1">VAT No</label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input class="form-control" value="<?php echo @$broker_row['vat_no'];?>"  type="text" name="vat_no">
                                                </div>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="form-field-1">Adharcard Number</label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input   class="form-control" value="<?php echo @$broker_row['aadhar_no'];?>" type="text" name="aadhar_no">
                                                </div>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="form-field-1">PAN No</label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input    class="form-control" value="<?php echo @$broker_row['pan_no'];?>" style="height:30px;" type="text" name="pan_no">
                                                </div>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label" for="form-field-1">TAN No</label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input   id="dateFrom" class="form-control" value="<?php echo @$broker_row['tan_no'];?>" style="height:30px;" type="text" name="tan_no">
                                                </div>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <a  id="add_bank_info" class="btn blue tooltips">Add New</i></a>
                                <div class="table-scrollable form-body">
                                    <table class="table table-bordered table-striped table-hover bank_table">
                                        <thead>
                                            <tr>
                                                <th style="width:20%">Bank Name</th>
                                                <th style="width:20%">Account No.</th>
                                                <th style="width:20%">IFSC Code</th>
                                                <!-- <th style="width:15%">BG Amount</th>
                                                <th style="width:13%">Start Date</th>
                                                <th style="width:13%">End Date</th> -->
                                                <th style="width:10%">Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if(count(@$bank_g)>0)
                                            {
                                                $i=0;
                                                foreach($bank_g as $bg)
                                                {
                                                    //print_r($bank_type); exit();
                                                $disabled=($i==0)?'style="display:none" ':'';
                                                $i++;
                                            ?>  
                                            <tr>
                                                <td style="width:17%">
                                                    <div class="dummy">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <select name="bank_id[]" class="form-control" > 
                                                                <option value="">Select Bank</option>
                                                                <?php 
                                                                    foreach($bank as $ban)
                                                                    {
                                                                        $selected = '';
                                                                        if($ban['bank_id'] == @$bg['bank_id'])
                                                                        {
                                                                            $selected = 'selected';
                                                                        }
                                                                        echo '<option value="'.$ban['bank_id'].'" '.$selected.'>'.$ban['name'].'</option>';
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="width:17%">
                                                    <div class="dummy">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input type="text" class="form-control" maxlength="25" name="account_no[]" value="<?php echo $bg['account_no'];?>"/>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="width:15%">
                                                    <div class="dummy">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input type="text" class="form-control" name="ifsc_code[]" value="<?php echo $bg['ifsc_code'];?>"/>
                                                        </div>
                                                    </div>
                                                </td>
                                               <!--  <td style="width:15%">
                                                    <div class="dummy">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input type="text" class="form-control numeric" onkeyup="javascript:this.value=Comma(this.value);" name="bg_amount[]" value="<?php echo $bg['bg_amount'];?>"/>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="width:13%">
                                                    <div class="dummy">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input class="form-control date-picker start_date" placeholder="Start Date" name="start_date[]" data-date-format="dd-mm-yyyy" type="text" value="<?php echo date('d-m-Y',strtotime(@$bg['start_date']));?>">
                                                        </div>  
                                                    </div>
                                                </td>
                                                <td style="width:13%">
                                                    <div class="dummy">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input class="form-control date-picker end_date" placeholder="End Date" name="end_date[]" data-date-format="dd-mm-yyyy" type="text" value="<?php echo date('d-m-Y',strtotime(@$bg['end_date']));?>"/>
                                                        </div>  
                                                    </div>
                                                </td> -->
                                                <td <?php echo $disabled;?> style="width:10%" ><a  class="btn btn-danger btn-sm remove_bank_row" > <i class="fa fa-trash-o"></i></a></td>
                                            </tr>
                                        <?php      
                                        } 
                                        }
                                        else
                                        {
                                       ?>          
                                            <tr>
                                                <td>
                                                    <div class="dummy">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <select name="bank_id[]" class="form-control" > 
                                                                <option value="">Select Bank</option>
                                                                <?php 
                                                                    foreach($bank as $bank)
                                                                    {
                                                                        echo '<option value="'.$bank['bank_id'].'">'.$bank['name'].'</option>';
                                                                    }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="dummy">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input type="text" class="form-control" maxlength="25" name="account_no[]">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="dummy">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input type="text" class="form-control" name="ifsc_code[]">
                                                        </div>
                                                    </div>
                                                </td>
                                                <!-- <td>
                                                    <div class="dummy">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input type="text" class="form-control numeric"onkeyup="javascript:this.value=Comma(this.value);" name="bg_amount[]" />
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="dummy">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input class="form-control date-picker start_date" placeholder="Start Date" name="start_date[]" data-date-format="dd-mm-yyyy" type="text" />
                                                        </div>  
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="dummy">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input class="form-control date-picker start_date" placeholder="End Date" name="end_date[]" data-date-format="dd-mm-yyyy" type="text" />
                                                        </div>  
                                                    </div>
                                                </td> -->
                                                <td style="display:none;" ><a class="btn btn-danger btn-sm remove_bank_row"> <i class="fa fa-trash-o"></i></a></td>
                                            </tr>
                                        <?php  
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-5 col-md-6">
                                            <button type="submit" class="btn blue">Submit</button>
                                            <a href="<?php echo SITE_URL.'broker';?>" class="btn default">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                    <?php
                    }
                    if(isset($display_results)&&$display_results==1)
                    {
                    ?>
                        <form method="post" action="<?php echo SITE_URL.'broker'?>">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input class="form-control numeric" name="broker_code" value="<?php echo @$search_data['broker_code'];?>" placeholder="Broker Code" type="text">
                                    </div>
                                </div>
                                  <div class="col-sm-3">
                                    <div class="form-group">
                                       <input class="form-control" name="agency_name" value="<?php echo @$search_data['agency_name'];?>" placeholder="Agency Name" type="text">
                                    </div>
                                 </div>
                                   <div class="col-sm-4">
                                     <div class="form-actions">
                                        <button type="submit" name="search_broker" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                        <button type="submit" name="download_broker" value="1" formaction="<?php echo SITE_URL.'download_broker';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
                                        <!-- <a  class="btn blue tooltips" href="<?php echo SITE_URL.'broker';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a> -->
                                        <a href="<?php echo SITE_URL.'add_broker';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                        
                                    </div>
                                </div>
                            </div>
                        </form>
                           <div class="table-scrollable">
                             <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th> Broker Code </th>
                                        <th> Agency Name </th>
                                        <th> Mobile No </th>
                                        <th> Alternate Mobile No </th>
                                        <th> Actions </th>            
                                    </tr>
                                </thead>
                                  <tbody>
                                     <?php

                                     if(count($broker_results)>0){

                                    foreach($broker_results as $row){
                                     ?>
                                     <tr>
                                        <td> <?php echo $sn++;?></td>
                                        <td> <?php echo $row['broker_code'];?> </td>
                                        <td> <?php echo $row['agency_name'];?> </td>
                                        <td> <?php echo $row['mobile'];?> </td>
                                        <td> <?php echo $row['alternate_mobile'];?> </td>
                                        <td>
                                            <a class="btn btn-default btn-xs tooltips" href="<?php echo SITE_URL.'edit_broker/'.cmm_encode($row['broker_id']);?>"  data-container="body" data-placement="top" data-original-title="Edit Details"><i class="fa fa-pencil"></i></a>
                                            <?php
                                            if($row['status']==1){
                                            ?>
                                            <a class="btn btn-danger btn-xs tooltips"  onclick="return confirm('Are you sure you want to Deactivate?')" href="<?php echo SITE_URL.'deactivate_broker/'.cmm_encode($row['broker_id']);?>" data-container="body" data-placement="top" data-original-title="DeActivate"><i class="fa fa-trash-o"></i></a>
                                            <?php
                                            }
                                            if($row['status']==2){
                                            ?>
                                            <a class="btn btn-info btn-xs tooltips"  onclick="return confirm('Are you sure you want to Activate?')" href="<?php echo SITE_URL.'activate_broker/'.cmm_encode($row['broker_id']);?>" data-container="body" data-placement="top" data-original-title="Activate"><i class="fa fa-check"></i></a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                }
                                else
                                {
                            ?>      <tr><td colspan="6" align="center"> No Records Found</td></tr>      
                        <?php   }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-5 col-sm-5">
                                <div class="dataTables_info" role="status" aria-live="polite">
                                    <?php echo @$pagermessage; ?>
                                </div>
                            </div>
                            <div class="col-md-7 col-sm-7">
                                <div class="dataTables_paginate paging_bootstrap_full_number">
                                    <?php echo @$pagination_links; ?>
                                </div>
                            </div>
                        </div> 
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