<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
               <div class="portlet-body">
               <?php if($flag==1)
               { ?>
                    <form method="post" action="<?php echo SITE_URL.'pm_mrr_details';?>" class="form-horizontal mrr_loose_oil">
                        <div class="row">  
                            <div class="col-md-offset-3 col-md-6 well"> 
                                <div class="form-group">
                                    <label class="col-xs-5 control-label">Tanker Number<span class="font-red required_fld">*</span></label>
                                    <div class="col-xs-5">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" name="tanker_number" placeholder="Tanker Number"  maxlength="20" class="form-control" >
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label class="col-xs-5 control-label">PO Number<span class="font-red required_fld">*</span></label>
                                    <div class="col-xs-5">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" name="po_number" maxlength="20" placeholder="PO Number"  class="form-control" >
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-group">
                                   <div class="col-xs-4"></div>
                                    <div class="col-xs-8">
                                        <input type="submit" class="btn blue tooltips" value="Submit" name="submit">
                                        <a href="<?php echo SITE_URL.'pm_mrr';?>" class="btn default">Cancel</a>
                                    </div>                                 
                                </div>
                            </div>
                        </div>
                    </form>  
                    <?php }
                    else if($flag ==2) { 
                    ?> 
                    <form class="form-horizontal mrr_loose_oil " role="form" method="post" action="<?php echo SITE_URL.'insert_pm_mrr_details';?>">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i>Material Receipt Report(MRR) </div>
                        </div>
                         <?php
                        if($mrr_results['pm_category_id']==get_film_cat_id())
                        {
                            $units='Kgs';
                        } 
                        elseif($mrr_results['pm_id']==get_tape_650mt() || $mrr_results['pm_id']==get_tape_65mt())
                        {
                            $units='units';
                        }
                        else
                        {
                            $units='units';
                        }
                        ?>
                        <div class="portlet-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><b>MRR Reference Number :</b><?php echo ' '. $mrr_number; ?></td>
                                            <td><b>Tanker Register Number :</b><?php echo ' '. $mrr_results['tanker_number']; ?></td>  
                                            <td><b>PO Number :</b><?php echo ' '.$mrr_results['po_number']; ?></td> 
                                            <td><b>Date : </b> <?php echo date('d-m-Y'); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Invoice Number :</b><?php echo ' '. $mrr_results['invoice_number']; ?></td>
                                            <td><b>Packing Material :</b><?php echo ' '. $mrr_results['packing_material_name']; ?></td>  
                                            <!-- <td><b>Broker:</b><?php echo ' '.$mrr_results['broker_name']; ?></td> -->
                                            <td colspan="2"><b>Supplier :</b><?php echo ' '.$mrr_results['supplier_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Unit Name :</b><?php echo ' '. $mrr_results['plant_name']; ?></td>
                                            <td><b>PO Date:</b><?php echo ' '.$mrr_results['po_date']; ?></td>
                                            <td><b>Vehicle Number :</b><?php echo ' '.$mrr_results['vehicle_number']; ?></td>
                                            <td><b>Purchase Mode :</b><?php echo ' '. $mrr_results['purchase_type']; ?></td> 
                                        </tr>
                                        <tr>
                                            <!-- <td><b>DC Number :</b><?php echo ' '. $mrr_results['dc_number']; ?></td> -->
                                            <td><b>Unit Price :</b><?php echo ' '. $mrr_results['unit_price']; ?></td>
                                            <td><b>Net Weight :</b><?php echo ' '. $mrr_results['net_weight'].' Kgs'; ?>
                                            <input type="hidden" name="net_weight" value="<?php echo $mrr_results['net_weight'].' '.'Kgs'; ?> "></td>
                                            <td><b>Gross Weight :</b><?php echo ' '. $mrr_results['gross_weight'].' '.'Kgs'; ?></td>
                                            <td><b>Tier Weight :</b><?php echo ' '. $mrr_results['tier_weight'].' '.'Kgs'; ?></td>  
                                        </tr>
                                         <tr>
                                            <td colspan="1"><b>DC Number :</b><?php echo ' '. $mrr_results['dc_number']; 
                                             ?></td> 
                                            <td colspan="1"><b>Quoted Quantity :</b><?php echo ' '. $mrr_results['pp_quantity'].$units; ?></td> 
                                            <?php $diff= $mrr_results['net_weight'] -$mrr_results['invoice_net_weight'] ; ?>
                                            <td colspan="2"><b> Qty Difference:</b><?php if($diff > 0){ echo ' +'. $diff.' '.'Kgs'; } else { echo ' '. $diff.' '.'Kgs'; } ?></td>
                                           <!--  <?php if($mrr_results['pp_quantity'] >= $mrr_results['net_weight']) { ?>
                                            <td><b>Pending Quantity :</b><?php echo $mrr_results['pp_quantity']- $mrr_results['net_weight'];?></td> 
                                            <?php } else { ?> 
                                            <td colspan="2"><b>Exceeded Quantity :</b><?php echo $mrr_results['net_weight']- $mrr_results['pp_quantity'];?></td>
                                            <?php } ?>  -->
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                             <div class="form-group">
                                <label class="col-md-3 control-label">Folio Number<span class="font-red required_fld">*</span></label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control input-sm" placeholder="Folio Number" name="folio_number"> </div>
                                </div>
                             </div>
                        </div>
                        <input type="hidden" name="tanker_pm_id" value="<?php echo $mrr_results['tanker_pm_id'] ;?>">
                        <input type="hidden" name="tanker_id" value="<?php echo $mrr_results['tanker_id'] ;?>">
                        <input type="hidden" name="po_pm_id" value="<?php  echo $mrr_results['po_pm_id']; ?>">
                        <input type="hidden" name="invoice_net_weight" value="<?php  echo $mrr_results['invoice_net_weight']; ?>">
                        <input type="hidden" name="invoice_quantity" value="<?php  echo $mrr_results['invoice_quantity']; ?>">
                        <!--/span-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Ledger Number<span class="font-red required_fld">*</span></label>
                                <div class="col-md-9">
                                <div class="input-icon right">
                                <i class="fa"></i>
                                    <input type="text" class="form-control input-sm" placeholder="Ledger Number" name="ledger_number"> </div>
                                </div> 
                             </div>
                        </div>
                        <!--/span-->
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">PO Status<span class="font-red required_fld" >*</span></label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select class="form-control input-sm" required name="po_status">
                                       <option value="">Select Status</option>
                                       <option value="2">Partially Completed</option>
                                       <option value="3">Completed</option>  
                                    </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                       <?php 
                        if($mrr_results['pm_category_id']==get_film_cat_id()) { ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Select Film Type<span class="font-red required_fld">*</span></label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select class="form-control pb"  required name="micron">
                                        <option value="">Select Unit</option>
                                            <?php 
                                                foreach($micron as $result) 
                                                { ?>
                                                    <option value="<?php echo $result['micron_id']; ?>"><?php echo $result['name']; ?></option>
                                                <?php }                                        
                                            ?>                                          
                                    </select>  
                                    </div>
                                </div>
                             </div>
                        </div>
                        <?php } 
                         elseif($mrr_results['pm_id']==get_tape_650mt() || $mrr_results['pm_id']==get_tape_65mt() ) { ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Enter Roles<span class="font-red required_fld">*</span></label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control input-sm" name="received_qty" placeholder="Roles"> </div>
                                </div>
                             </div>
                        </div>
                        <?php } else { ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Received Qty<span class="font-red required_fld">*</span></label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                    <input type="text" class="form-control input-sm" name="received_qty" placeholder="quantity"> </div>
                                </div>
                             </div>
                        </div>
                        <?php } ?>
                    </div>
                    <?php  if($mrr_results['pm_category_id']==get_film_cat_id()) { ?>
                    <div class="row">
                        <div class="col-md-6">
                             <div class="form-group">
                                <label class="col-md-3 control-label">Rolls<span class="font-red required_fld">*</span></label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control input-sm" placeholder="Enter Rolls" name="rolls"> </div>
                                </div>
                             </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Core Weight<span class="font-red required_fld">*</span></label>
                                <div class="col-md-9">
                                <div class="input-icon right">
                                <i class="fa"></i>
                                    <input type="text" class="form-control input-sm" placeholder="Core Weight" name="core_weight"> </div>
                                </div> 
                             </div>
                        </div>
                        <!--/span-->
                    </div>
                <?php } 
                if($mrr_results['pm_category_id']==get_film_cat_id()) {
                 ?>
                  <div class="row">
                        <div class="col-md-6">
                             <div class="form-group">
                                <label class="col-md-3 control-label">Carton Weight<span class="font-red required_fld">*</span></label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control input-sm" placeholder="Carton Weight" name="carton_weight"> </div>
                                </div>
                             </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Remarks</label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                     <textarea class="form-control" name="remarks" rows="3"></textarea> </div>
                                </div>
                             </div>
                        </div>
                        <!--/span-->
                    </div>
                    <?php } ?>
                     <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-4 col-md-8">
                                <input type="submit" name="submit"  value="submit" class="btn blue">
                                <a href="<?php echo SITE_URL.'pm_mrr';?>" class="btn default">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
                    <?php } 
                    else if($flag==3) {?>
                    <form class="form-horizontal " role="form" method="post" action="">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                        <?php
                        if($mrr_results['pm_category_id']==get_film_cat_id())
                        {
                            $units='Kgs';
                        } 
                        elseif($mrr_results['pm_id']==get_tape_650mt() || $mrr_results['pm_id']==get_tape_65mt())
                        {
                            $units='Units';
                        }
                        else
                        {
                            $units='Units';
                        }
                        ?>
                            <div class="caption">
                                <i class="fa fa-cogs"></i>Material Receipt Report(MRR) </div>
                        </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Ledger Number:</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"><?php echo ' '. $mrr_details['ledger_number']; ?> </p>
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Folio Number:</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"><?php echo ' '. $mrr_details['folio_number']; ?> </p>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="tanker_id" value="<?php echo $mrr_results['tanker_id'] ;?>">
                                <input type="hidden" name="mrr_pm_id" value="<?php echo $mrr_details['mrr_pm_id'] ;?>">
                                <!--/span-->
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><b>MRR Reference Number :</b><?php echo ' '. $mrr_details['mrr_pm_id']; ?></td>
                                            <td><b>Tanker Register Number :</b><?php echo ' '. $mrr_results['tanker_number']; ?></td>  
                                            <td><b>PO Number :</b><?php echo ' '.$mrr_results['po_number']; ?></td> 
                                            <td><b>Date : </b> <?php echo date('d-m-Y'); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Invoice Number :</b><?php echo ' '. $mrr_results['invoice_number']; ?></td>
                                            <td><b>Loose Oil :</b><?php echo ' '. $mrr_results['packing_material_name']; ?></td>  
                                           <!--  <td><b>Broker:</b><?php echo ' '.$mrr_results['broker_name']; ?></td> -->
                                            <td colspan="2"><b>Supplier :</b><?php echo ' '.$mrr_results['supplier_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Unit Name :</b><?php echo ' '. $mrr_results['plant_name']; ?></td>
                                            <td><b>PO Date:</b><?php echo ' '.$mrr_results['po_date']; ?></td>
                                            <td><b>Vehicle Number :</b><?php echo ' '.$mrr_results['vehicle_number']; ?></td>
                                            <td><b>Purchase Mode :</b><?php echo ' '. $mrr_results['purchase_type']; ?></td> 
                                        </tr>
                                        <tr>
                                            <td><b>Unit Price :</b><?php echo ' '. $mrr_results['unit_price']; ?></td>
                                            <td><b>Net Weight :</b><?php echo ' '. $mrr_results['net_weight'].' Kgs'; ?></td>
                                            <td><b>Gross Weight :</b><?php echo ' '. $mrr_results['gross_weight'].' Kgs'; ?></td>
                                            <td><b>Tier Weight :</b><?php echo ' '. $mrr_results['tier_weight'].' Kgs'; ?></td>   
                                        </tr>
                                         <tr> 
                                            <td><b>DC Number :</b><?php echo ' '. $mrr_results['dc_number']; ?></td> 
                                            <?php $diff= $mrr_results['net_weight'] -$mrr_results['invoice_net_weight'] ; ?>
                                            <td ><b>Quoted Quantity :</b><?php echo ' '. $mrr_results['pp_quantity'].$units; ?></td> 
                                            <td><b> Qty Difference:</b><?php if($diff > 0){ echo ' +'. $diff.' Kgs'; } else { echo ' '. $diff.' Kgs'; } ?></td>
                                            <?php if($mrr_results['pp_quantity'] >= ($pm_received_qty/$meters)) { ?>
                                            <td><b>Pending Quantity :</b><?php echo $mrr_results['pp_quantity']- ($pm_received_qty/$meters).$units;?></td> 
                                            <?php } else { ?> 
                                            <td ><b>Exceeded Quantity :</b><?php echo ($pm_received_qty/$meters)- $mrr_results['pp_quantity'].$units;?></td>
                                            <?php } ?> 
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php if($mrr_details['remarks'] !='') { ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Remarks:</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"><?php echo ' '. $mrr_details['remarks']; ?> </p>
                                        </div>
                                    </div>
                                </div>
                            
                            <?php } 
                              if(($mrr_received_qty/$meters) !='') { ?>
                           
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-9">Received Quantity:</label>
                                        <div class="col-md-3">
                                            <p class="form-control-static"><?php echo ' '. ($mrr_received_qty/$meters).$units?> </p>
                                        </div>
                                    </div>
                                </div>
                            <!-- </div> -->
                            <?php } 
                            if(@$total_meters !='') { ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-9">Total Meters:</label>
                                        <div class="col-md-3">
                                            <p class="form-control-static"><?php echo ' '. $total_meters.'Mts'; ?> </p>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <?php } ?>
                                
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-10 col-md-8">
                                        <button type="submit" name="download" value="1" formaction="<?php echo SITE_URL.'download_pm_mrr';?>" class="btn blue"><i class="fa fa-cloud-download fa-lg"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                </form>

                    <?php } ?>

                </div>
            </div>
        </div>
            <!-- END BORDERED TABLE PORTLET-->
    </div>
</div>               
<!-- </div> -->
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>