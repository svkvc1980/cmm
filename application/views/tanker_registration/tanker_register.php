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
                ?>  <form method="post" action="<?php echo SITE_URL.'registration_details';?>" class="form-horizontal">
                        <div class="row">                        
                            <div class="col-md-offset-3 col-md-6 well">
                                <div class="form-group">
                                    <label class="col-xs-4 col-md-4 control-label">Vehicle Type</label>
                                    <div class="col-xs-7 col-md-7">
                                      <select class="form-control" name="tanker_type_id" required>
                                          <option value="">- Select Vehicle Type -</option>
                                          <?php
                                                foreach($tanker_type as $row)
                                                {                                                    
                                                   echo '<option value="'.$row['tanker_type_id'].'">'.$row['name'].'</option>';
                                                }
                                            ?>
                                      </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-4"></div>
                                     <div class="col-xs-7">
                                    <button type="submit" class="btn blue tooltips" name="submit">Submit</button>                                    
                                       <a href="<?php echo SITE_URL.'tanker_registration';?>" class="btn default">Cancel</a>  
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
                    <form method="post" action="<?php echo SITE_URL.'insert_tanker_registration_details'?>" class="form-horizontal tanker_in_details">
                    <input type="hidden" name="tanker_type_id" value="<?php echo @$tanker_type_id?>">
                    <div class="col-md-offset-1 col-md-10 well">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                <label class="col-md-5 control-label">Vehicle Type :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo $tanker_type_name; ?></b></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Vehicle In No :</label>
                                    <div class="col-md-7">
                                       <p class="form-control-static"><b><?php echo $tanker_in_number; ?></b></p>
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
                                        <input type="text" name="vehicle_no" maxlength="20" class="form-control" name="vehicle_number">
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Intime :</label>
                                    <div class="col-md-7">
                                       <p class="form-control-static"><b><span id="timer"></span></b></p>
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
                                        <select name="loose_oil_id" class="form-control"> 
                                                    <option value="">-Select Oil-</option>
                                                    <?php 

                                                foreach($oillist as $oil_id => $oil_name)
                                                {
                                                    echo '<option value="'.$oil_id.'">'.$oil_name.'</option>';
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
                                            <input type="text" name="dc_no" maxlength="20" class="form-control"> 
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
                                            <input type="text" name="invoice_no" maxlength="20" class="form-control">
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
                                        <input type="text" name="invoice_qty" maxlength="20" class="form-control">
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
                                        <input type="text" name="gross" maxlength="20" class="form-control">  
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
                                            <input type="text" name="tier" maxlength="20" class="form-control">  
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
                                        
                                        <textarea class="form-control" name="party_name"></textarea>
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
                                        <textarea class="form-control" name="broker_name"></textarea>
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
                                     <a href="<?php echo SITE_URL.'tanker_registration';?>" class="btn default">Cancel</a>
                               </div>
                            </div>
                       </div>
                    </form>
                    <?php }
                    else if($flag==2)
                {
                ?>
                    <form method="post" action="<?php echo SITE_URL.'insert_pm_registration_details'?>" class="form-horizontal tanker_in_details">
                    <input type="hidden" name="tanker_type_id" value="<?php echo @$tanker_type_id?>">
                    <div class="col-md-offset-1 col-md-10 well">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                <label class="col-md-5 control-label">Vehicle Type :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo $tanker_type_name; ?></b></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Vehicle In No :</label>
                                    <div class="col-md-7">
                                       <p class="form-control-static"><b><?php echo $tanker_in_number; ?></b></p>
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
                                        <input type="text" name="vehicle_no" maxlength="20" class="form-control" name="vehicle_number">
                                    </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Intime :</label>
                                    <div class="col-md-7">
                                       <p class="form-control-static"><b><span id="timer"></span></b></p>
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
                                        <select name="pm_id" class="form-control pm_id select2"> 
                                                    <option value="">-Packing Material-</option>
                                                    <?php 

                                                foreach($packingmaterial as $pm)
                                                {
                                                    echo '<option value="'.$pm['pm_id'].'" data-pm-category="'.$pm['pm_category_id'].'">'.$pm['name'].'</option>';
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
                                            <input type="text" name="dc_no" maxlength="20" class="form-control"> 
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
                                            <input type="text" name="invoice_no" maxlength="20" class="form-control">
                                        </div>                                       
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                <label class="col-md-5 control-label invoice_qty">Invoice Qty<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="text" name="invoice_qty" maxlength="20" class="form-control">
                                        </div>   
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <div class="row gross_tare">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Invoice Gross <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="text" name="gross" maxlength="20" class="form-control">  
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
                                            <input type="text" name="tier" maxlength="20" class="form-control">  
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
                                        <textarea class="form-control" name="party_name"></textarea> 
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
                                     <a href="<?php echo SITE_URL.'tanker_registration';?>" class="btn default">Cancel</a>
                               </div>
                            </div>
                       </div>
                    </form>
                    <?php }
                    else if($flag == 3)
                    { ?>
                    <form method="post" action="<?php echo SITE_URL.'insert_empty_truck_registration_details'?>" class="form-horizontal tanker_in_details">
                        <input type="hidden" name="tanker_type_id" value="<?php echo @$tanker_type_id?>">
                        <div class="col-md-offset-1 col-md-10 well">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                    <label class="col-md-5 control-label">Vehicle Type :</label>
                                        <div class="col-md-7">
                                            <p class="form-control-static"><b><?php echo $tanker_type_name; ?></b></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Vehicle In No :</label>
                                        <div class="col-md-7">
                                           <p class="form-control-static"><b><?php echo $tanker_in_number; ?></b></p>
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
                                            <input type="text" name="vehicle_no" maxlength="20" class="form-control" name="vehicle_number">
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Intime :</label>
                                        <div class="col-md-7">
                                           <p class="form-control-static"><b><span id="timer"></span></b></p>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                    <label class="col-md-5 control-label">Invoice No.</label>
                                        <div class="col-md-7">
                                            <input type="text" name="invoice_num" maxlength="20" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Party Name <span class="font-red required_fld">*</span></label>
                                        <div class="col-md-7">
                                            <div class="input-icon right">
                                            <i class="fa"></i> 
                                            <textarea class="form-control" name="party_name"></textarea>
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
                                            <textarea class="form-control" cols="2" name="remarks1"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-offset-5 col-md-4">
                                    <button type="submit" class="btn blue tooltips" name="submit">Submit</button>
                                    <a href="<?php echo SITE_URL.'tanker_registration';?>" class="btn default">Cancel</a>
                               </div>
                            </div>                    
                        </div>                       
                        
                    </form>

                    <?php }
                    else if($flag==5)
                    {
                        ?>
                        <form method="post" action="<?php echo SITE_URL.'insert_freegift_tanker_details'?>" class="form-horizontal tanker_in_details">
                            <input type="hidden" name="tanker_type_id" value="<?php echo @$tanker_type_id?>">
                            <div class="col-md-offset-1 col-md-10 well">
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                        <label class="col-md-5 control-label">Vehicle Type :</label>
                                            <div class="col-md-7">
                                                <p class="form-control-static"><b><?php echo $tanker_type_name; ?></b></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label">Vehicle In No :</label>
                                            <div class="col-md-7">
                                               <p class="form-control-static"><b><?php echo $tanker_in_number; ?></b></p>
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
                                                <input type="text" name="vehicle_no" class="form-control" name="vehicle_number">
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="col-md-5 control-label">Intime : </label>
                                            <div class="col-md-7">
                                               <p class="form-control-static"><b><span id="timer"></span></b></p>
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
                                                    <select name="free_gift_id" class="form-control"> 
                                                                <option value="">-Select Free Gift-</option>
                                                                <?php 

                                                            foreach($freegiftlist as $free_gift_id => $name)
                                                            {
                                                                echo '<option value="'.$free_gift_id.'">'.$name.'</option>';
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
                                                    <input type="text" name="dc_no" class="form-control"> 
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
                                                    <input type="text" name="invoice_no" class="form-control">
                                                </div>                                       
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                        <label class="col-md-5 control-label">Invoice Quantity <span class="font-red required_fld">*</span></label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                <i class="fa"></i>
                                                <input type="text" name="invoice_qty" class="form-control">
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
                                        <textarea class="form-control" name="party_name"></textarea>
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
                                         <a href="<?php echo SITE_URL.'tanker_registration';?>" class="btn default">Cancel</a>
                                   </div>
                                </div>
                           </div>    
                        </form> <?php
                    }
                    else if($flag == 6)
                    { ?>
                    <form method="post" action="<?php echo SITE_URL.'insert_packed_product_registration_details'?>" class="form-horizontal tanker_in_details">
                        <input type="hidden" name="tanker_type_id" value="<?php echo @$tanker_type_id?>">
                        <div class="col-md-offset-1 col-md-10 well">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                    <label class="col-md-5 control-label">Vehicle Type :</label>
                                        <div class="col-md-7">
                                            <p class="form-control-static"><b><?php echo $tanker_type_name; ?></b></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Vehicle In No :</label>
                                        <div class="col-md-7">
                                           <p class="form-control-static"><b><?php echo $tanker_in_number; ?></b></p>
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
                                            <input type="text" name="vehicle_no" maxlength="20" class="form-control" name="vehicle_number">
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Intime :</label>
                                        <div class="col-md-7">
                                           <p class="form-control-static"><b><span id="timer"></span></b></p>
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
                                            <textarea class="form-control" name="party_name"></textarea> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Remarks</label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" cols="2" name="remarks1"></textarea>
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            </div>
                            <div class="row">
                                <div class="col-md-offset-5 col-md-4">
                                    <button type="submit" class="btn blue tooltips" name="submit">Submit</button>
                                    <a href="<?php echo SITE_URL.'tanker_registration';?>" class="btn default">Cancel</a>
                               </div>
                            </div>                    
                        </div>                       
                        
                    </form>

                    <?php }
                    ?>
                    
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->

<?php $this->load->view('commons/main_footer', $nestedView); ?>

