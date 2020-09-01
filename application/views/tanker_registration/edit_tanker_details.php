<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                <?php if($flag==0)
                {
                ?>  <form method="post" action="<?php echo SITE_URL.'edit_tanker_details_view';?>" class="form-horizontal">
                        <div class="row"> 
                            <div class="col-md-offset-3 col-md-6 jumbotron">                       
                                <div class="col-md-12">
                                    <div class="form-group">
                                      <label class="col-md-5 control-label">Tanker In Number <span class="font-red required_fld">*</span></label>
                                      <div class="col-md-6">
                                          <div class="input-icon right">
                                              <i class="fa"></i>
                                              <input class="form-control " type="text" name="tanker_in_number" placeholder="Tanker In Number" required>  
                                          </div>
                                      </div>
                                     </div>  
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <button type="submit" class="btn blue" name="bridge">Submit</button>
                                            <a href="<?php echo SITE_URL.'edit_tanker_details';?>" class="btn default">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </form> 
                <?php 
                }
                else if($flag==1)
                {
                ?>
                    <form method="post" action="<?php echo SITE_URL.'update_tanker_registration_details'?>" class="form-horizontal">
                    <input type="hidden" name="tanker_in_number" value="<?php echo @$edit_tanker['tanker_in_number']?>">
                    <input type="hidden" name="tanker_id" value="<?php echo @$edit_tanker['tanker_id']?>">
                    <div class="col-md-offset-1 col-md-10 well">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                <label class="col-md-5 control-label">Vehicle Type :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo $edit_tanker['tanker_type_name']; ?></b></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Vehicle In No :</label>
                                    <div class="col-md-7">
                                       <p class="form-control-static"><b><?php echo $edit_tanker['tanker_in_number']; ?></b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Vehicle No <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7"> 
                                    <div class="input-icon right">
                                    <i class="fa"></i>                                      
                                        <input type="text" name="vehicle_no" maxlength="20" class="form-control" value="<?php echo @$edit_tanker['vehicle_number'];?>"  name="vehicle_number">
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Intime :</label>
                                    <div class="col-md-7">
                                       <p class="form-control-static"><b><?php echo @$edit_tanker['in_time']; ?></b></p>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="col-md-5 control-label">Oil Type <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7">
                                    <div class="input-icon right">
                                    <i class="fa"></i>
                                        <select class="form-control" name="loose_oil_id">
                                            <option value="">-Select Loose Oil -</option>
                                            <?php 
                                                foreach($oillist as $row)
                                                {
                                                    $selected = "";
                                                    if($row['loose_oil_id']== @$edit_tanker['loose_oil_id'] )
                                                        { 
                                                            $selected='selected';
                                                        }
                                                    echo '<option value="'.$row['loose_oil_id'].'" '.$selected.' >'.$row['loose_name'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>                                      
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">DC No.</label>
                                    <div class="col-md-7">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                            <input type="text" name="dc_no" value="<?php echo @$edit_tanker['dc_number'];?>" maxlength="20" class="form-control"> 
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                <label class="col-md-5 control-label">Invoice No. <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                            <input type="text" name="invoice_no" value="<?php echo @$edit_tanker['invoice_number'];?>" maxlength="20" class="form-control">
                                        </div>                                       
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                <label class="col-md-5 control-label">Invoice Qty (MT)<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="text" name="invoice_qty" value="<?php echo @$edit_tanker['invoice_qty'];?>" maxlength="20" class="form-control">
                                        </div>   
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Invoice Gross <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="text" name="gross" value="<?php echo @$edit_tanker['invoice_gross'];?>" maxlength="20" class="form-control">  
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Invoice Tare <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" name="tier" value="<?php echo @$edit_tanker['invoice_tier'];?>" maxlength="20" class="form-control">  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Party Name <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                        <textarea class="form-control" name="party_name"><?php echo @$edit_tanker['party_name'];?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Broker Name <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                        <textarea class="form-control" name="broker_name"><?php echo @$edit_tanker['broker_name'];?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                       
                    </div>                       
                        <div>
                            <div class="row">
                                <div class="col-md-offset-5 col-md-4">
                                     <button type="submit" class="btn blue tooltips" name="submit">Submit</button>
                                     <a href="<?php echo SITE_URL.'edit_tanker_details';?>" class="btn default">Cancel</a>
                               </div>
                            </div>
                       </div>
                    </form>
                    <?php }
                    else if($flag==2)
                    {
                    ?>
                    <form method="post" action="<?php echo SITE_URL.'update_pm_registration_details'?>" class="form-horizontal tanker_in_details">
                    <input type="hidden" name="tanker_in_number" value="<?php echo @$edit_tanker['tanker_in_number']?>">
                    <input type="hidden" name="tanker_id" value="<?php echo @$edit_tanker['tanker_id']?>">
                    <div class="col-md-offset-1 col-md-10 well">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                <label class="col-md-5 control-label">Vehicle Type :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo $edit_tanker['tanker_type_name']; ?></b></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Vehicle In No :</label>
                                    <div class="col-md-7">
                                       <p class="form-control-static"><b><?php echo $edit_tanker['tanker_in_number']; ?></b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Vehicle No <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7"> 
                                    <div class="input-icon right">
                                    <i class="fa"></i>                                      
                                        <input type="text" name="vehicle_no" maxlength="20" class="form-control" value="<?php echo @$edit_tanker['vehicle_number'];?>"  name="vehicle_number">
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Intime :</label>
                                    <div class="col-md-7">
                                       <p class="form-control-static"><b><?php echo @$edit_tanker['in_time']; ?></b></p>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="col-md-5 control-label">Packing Material<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7">
                                    <div class="input-icon right">
                                    <i class="fa"></i>
                                        <select class="form-control pm_id select2" name="pm_id">
                                            <option value="">-Select Packing Material -</option>
                                            <?php 
                                                foreach($packingmaterial as $row)
                                                {
                                                    $selected = "";
                                                    if($row['pm_id']== @$edit_tanker['pm_id'] )
                                                        { 
                                                            $selected='selected';
                                                        }
                                                    echo '<option value="'.$row['pm_id'].'" '.$selected.' >'.$row['packing_name'].'</option>';
                                                }
                                            ?>
                                        </select>
                                        </div>                                      
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">DC No.</label>
                                    <div class="col-md-7">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                            <input type="text" name="dc_no" value="<?php echo @$edit_tanker['dc_number'];?>" maxlength="20" class="form-control"> 
                                        </div>  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                <label class="col-md-5 control-label">Invoice No. <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                            <input type="text" name="invoice_no" value="<?php echo @$edit_tanker['invoice_number'];?>" maxlength="20" class="form-control">
                                        </div>                                       
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                <label class="col-md-5 control-label">Invoice Qty<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="text" name="invoice_qty" value="<?php echo @$edit_tanker['invoice_quantity'];?>" maxlength="20" class="form-control">
                                        </div>   
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Invoice Gross <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="text" name="gross" value="<?php echo @$edit_tanker['invoice_gross'];?>" maxlength="20" class="form-control">  
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Invoice Tare <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" name="tier" value="<?php echo @$edit_tanker['invoice_tier'];?>" maxlength="20" class="form-control">  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Party Name <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                         <textarea class="form-control" name="party_name"><?php echo @$edit_tanker['party_name'];?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                 
                    </div>                       
                    <div>
                        <div class="row">
                            <div class="col-md-offset-5 col-md-4">
                                 <button type="submit" class="btn blue tooltips" name="submit">Submit</button>
                                 <a href="<?php echo SITE_URL.'edit_tanker_details';?>" class="btn default">Cancel</a>
                           </div>
                        </div>
                    </div>
                    </form>
                    <?php }
                    else if($flag == 3)
                    { ?>
                    <form method="post" action="<?php echo SITE_URL.'update_empty_truck_registration_details'?>" class="form-horizontal tanker_in_details">
                    <input type="hidden" name="tanker_in_number" value="<?php echo @$edit_tanker['tanker_in_number']?>">
                    <input type="hidden" name="tanker_id" value="<?php echo @$edit_tanker['tanker_id']?>">
                        <div class="col-md-offset-1 col-md-10 well">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                    <label class="col-md-5 control-label">Vehicle Type :</label>
                                        <div class="col-md-7">
                                            <p class="form-control-static"><b><?php echo $edit_tanker['tanker_type_name']; ?></b></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Vehicle In No :</label>
                                        <div class="col-md-7">
                                           <p class="form-control-static"><b><?php echo $edit_tanker['tanker_in_number']; ?></b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Vehicle No <span class="font-red required_fld">*</span></label>
                                        <div class="col-md-7"> 
                                        <div class="input-icon right">
                                        <i class="fa"></i>                                      
                                            <input type="text" name="vehicle_no" maxlength="20" class="form-control" value="<?php echo @$edit_tanker['vehicle_number'];?>"  name="vehicle_number">
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Intime :</label>
                                        <div class="col-md-7">
                                           <p class="form-control-static"><b><?php echo @$edit_tanker['in_time']; ?></b></p>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                    <label class="col-md-5 control-label">Invoice No. <span class="font-red required_fld">*</span></label>
                                        <div class="col-md-7">
                                            <div class="input-icon right">
                                            <i class="fa"></i>
                                                <input type="text" name="invoice_no" value="<?php echo @$edit_tanker['invoice_number'];?>" maxlength="20" class="form-control">
                                            </div>                                       
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Party Name <span class="font-red required_fld">*</span></label>
                                        <div class="col-md-7">
                                            <div class="input-icon right">
                                            <i class="fa"></i>
                                             <textarea class="form-control" name="party_name"><?php echo @$edit_tanker['party_name'];?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Remarks</label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" cols="2" name="remarks1"><?php echo @$edit_tanker['remarks1'];?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-offset-5 col-md-4">
                                    <button type="submit" class="btn blue tooltips" name="submit">Submit</button>
                                    <a href="<?php echo SITE_URL.'edit_tanker_details';?>" class="btn default">Cancel</a>
                               </div>
                            </div>                    
                        </div>                       
                        
                    </form>

                    <?php }
                    else if($flag==5)
                    {?>
                        <form method="post" action="<?php echo SITE_URL.'update_freegift_tanker_details'?>" class="form-horizontal tanker_in_details">
                            <input type="hidden" name="tanker_in_number" value="<?php echo @$edit_tanker['tanker_in_number']?>">
                            <input type="hidden" name="tanker_id" value="<?php echo @$edit_tanker['tanker_id']?>">
                            <div class="col-md-offset-1 col-md-10 well">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                        <label class="col-md-5 control-label">Vehicle Type :</label>
                                            <div class="col-md-7">
                                                <p class="form-control-static"><b><?php echo $edit_tanker['tanker_type_name']; ?></b></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label">Vehicle In No :</label>
                                            <div class="col-md-7">
                                               <p class="form-control-static"><b><?php echo $edit_tanker['tanker_in_number']; ?></b></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label">Vehicle No <span class="font-red required_fld">*</span></label>
                                            <div class="col-md-7"> 
                                            <div class="input-icon right">
                                            <i class="fa"></i>                                      
                                                <input type="text" name="vehicle_no" maxlength="20" class="form-control" value="<?php echo @$edit_tanker['vehicle_number'];?>"  name="vehicle_number">
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label">Intime :</label>
                                            <div class="col-md-7">
                                               <p class="form-control-static"><b><?php echo $edit_tanker['in_time']; ?></b></p>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label">Free Gift <span class="font-red required_fld">*</span></label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                       <select class="form-control" name="free_gift_id">
                                                            <option value="">-Select Free Gift -</option>
                                                            <?php 
                                                                foreach($freegiftlist as $row)
                                                                {
                                                                    $selected = "";
                                                                    if($row['free_gift_id']== @$edit_tanker['free_gift_id'] )
                                                                        { 
                                                                            $selected='selected';
                                                                        }
                                                                    echo '<option value="'.$row['free_gift_id'].'" '.$selected.' >'.$row['free_gift_name'].'</option>';
                                                                }
                                                            ?>
                                                       </select>
                                                </div>                                      
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label">DC No.</label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                <i class="fa"></i>
                                                    <input type="text" name="dc_no" value="<?php echo @$edit_tanker['dc_number'];?>" maxlength="20" class="form-control"> 
                                                </div>  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                        <label class="col-md-5 control-label">Invoice No. <span class="font-red required_fld">*</span></label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                <i class="fa"></i>
                                                    <input type="text" name="invoice_no" value="<?php echo @$edit_tanker['invoice_number'];?>" maxlength="20" class="form-control">
                                                </div>                                       
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                        <label class="col-md-5 control-label">Invoice Qty<span class="font-red required_fld">*</span></label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                <i class="fa"></i>
                                                <input type="text" name="invoice_qty" value="<?php echo @$edit_tanker['invoice_qty'];?>" maxlength="20" class="form-control">
                                                </div>   
                                            </div>
                                        </div>
                                    </div>
                                </div>   
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label">Party Name <span class="font-red required_fld">*</span></label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                <i class="fa"></i>
                                                <textarea class="form-control" name="party_name"><?php echo @$edit_tanker['party_name'];?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                       
                            </div>                       
                            <div>
                                <div class="row">
                                    <div class="col-md-offset-5 col-md-4">
                                         <button type="submit" class="btn blue tooltips" name="submit">Submit</button>
                                         <a href="<?php echo SITE_URL.'edit_tanker_details';?>" class="btn default">Cancel</a>
                                   </div>
                                </div>
                           </div>    
                        </form> 
                    <?php
                    } ?>
                </div>
            </div>
        </div>
    </div>
</div>