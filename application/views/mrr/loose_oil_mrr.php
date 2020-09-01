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
                    <form method="post" action="<?php echo SITE_URL.'mrr_loose_oil_details';?>" class="form-horizontal mrr_loose_oil">
                        <div class="row">  
                            <div class="col-md-offset-3 col-md-6 well"> 
                                <div class="form-group">
                                <label class="col-xs-5 control-label">Tanker Number<span class="font-red required_fld">*</span></label>
                                    <div class="col-xs-5">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" name="tanker_number" maxlength="20" placeholder="Tanker Number"  class="form-control" >
                                        </div>
                                    </div>
                                </div>                        
                               <div class="form-group">
                                   <div class="col-xs-4"></div>
                                    <div class="col-xs-8">
                                        <input type="submit" class="btn blue tooltips" value="Submit" name="submit">
                                        <a href="<?php echo SITE_URL.'loose_oil_mrr';?>" class="btn default">Cancel</a>
                                    </div>                                 
                                </div>
                            </div>
                        </div>
                    </form>  
                    <?php }
                    else if($flag ==2) { 
                    ?> 
                    <form class="form-horizontal mrr_loose_oil " role="form" method="post" action="<?php echo SITE_URL.'insert_mrr_details';?>">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-cogs"></i>Material Receipt Report(MRR) </div>
                        </div>
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
                                            <td><b>Loose Oil :</b><?php echo ' '. $mrr_results['loose_oil_name']; ?></td>  
                                            <td><b>Broker:</b><?php echo ' '.$mrr_results['broker_name']; ?></td>
                                            <td><b>Supplier :</b><?php echo ' '.$mrr_results['supplier_name']; ?></td>
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
                                            <td><b>Net Weight :</b><?php echo ' '. ($mrr_results['net_weight']*1000).''.'Kgs'; ?></td>
                                            <td><b>Gross Weight :</b><?php echo ' '. $mrr_results['gross_weight'].''.'kgs'; ?></td>
                                            <td><b>Tier Weight :</b><?php echo ' '. $mrr_results['tier_weight'].''.'kgs'; ?></td>  
                                        </tr>
                                         <tr>
                                            <td><b>DC Number :</b><?php echo ' '. $mrr_results['dc_number']; ?></td> 
                                            <?php $diff= ($mrr_results['net_weight'] -$mrr_results['invoice_net_weight']) * 1000  ; ?>
                                            <td><b> Qty Difference:</b><?php if($diff > 0){ echo ' +'. $diff.'Kgs'; } else { echo ' '. $diff.'Kgs'; } ?></td>
                                            <?php if($mrr_results['po_quantity'] >= $received_qty) { ?>
                                            <td colspan="2"><b>Pending Quantity :</b><?php echo ($mrr_results['po_quantity']- $received_qty).'MT';?></td> 
                                            <?php } else { ?> 
                                            <td colspan="2"><b>Exceeded Quantity :</b><?php echo ($received_qty- $mrr_results['po_quantity']).'MT';?></td>
                                            <?php } ?> 
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
                        <input type="hidden" name="tanker_oil_id" value="<?php echo $mrr_results['tanker_oil_id'] ;?>">
                        <input type="hidden" name="tanker_id" value="<?php echo $mrr_results['tanker_id'] ;?>">
                        <input type="hidden" name="po_oil_id" value="<?php  echo $mrr_results['po_oil_id']; ?>">
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
                                <label class="col-md-3 control-label">Oil Tank<span class="font-red required_fld">*</span></label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                     <?php echo form_dropdown('tank_name', $tank_details,'','class="form-control input-sm"'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-3 control-label">PO Status<span class="font-red required_fld">*</span></label>
                                <div class="col-md-9">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                     <select class="form-control input-sm" name="po_status">
                                       <option value="">Select Status</option>
                                       <option value="2">Partially Completed</option>
                                       <option value="3">Completed</option>  
                                     </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row">
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
                    </div>
                     <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-4 col-md-8">
                                <input type="submit" name="submit"  value="submit" class="btn blue">
                                <a href="<?php echo SITE_URL.'loose_oil_mrr';?>" class="btn default">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
                <?php } 
                else if($flag==3) {?>
                <form class="form-horizontal " role="form" method="post" action="">
                    <div class="portlet box blue">
                        <div class="portlet-title">
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
                                <input type="hidden" name="mrr_oil_id" value="<?php echo $mrr_details['mrr_oil_id'] ;?>">
                                <!--/span-->
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td><b>MRR Reference Number :</b><?php echo ' '. $mrr_details['mrr_number']; ?></td>
                                            <td><b>Tanker Register Number :</b><?php echo ' '. $mrr_results['tanker_number']; ?></td>  
                                            <td><b>PO Number :</b><?php echo ' '.$mrr_results['po_number']; ?></td> 
                                            <td><b>Date : </b> <?php echo date('d-m-Y'); ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Invoice Number :</b><?php echo ' '. $mrr_results['invoice_number']; ?></td>
                                            <td><b>Loose Oil :</b><?php echo ' '. $mrr_results['loose_oil_name']; ?></td>  
                                            <td><b>Broker:</b><?php echo ' '.$mrr_results['broker_name']; ?></td>
                                            <td><b>Supplier :</b><?php echo ' '.$mrr_results['supplier_name']; ?></td>
                                        </tr>
                                        <tr>
                                            <td><b>Unit Name :</b><?php echo ' '. $mrr_results['plant_name']; ?></td>
                                            <td><b>PO Date:</b><?php echo ' '.$mrr_results['po_date']; ?></td>
                                            <td><b>Vehicle Number :</b><?php echo ' '.$mrr_results['vehicle_number']; ?></td>
                                            <td><b>Purchase Mode :</b><?php echo ' '. $mrr_results['purchase_type']; ?></td> 
                                        </tr>
                                        <tr>
                                            <td><b>Unit Price :</b><?php echo ' '. $mrr_results['unit_price']; ?></td>
                                            <td><b>Net Weight :</b><?php echo ' '. ($mrr_results['net_weight']*1000).'Kgs'; ?></td>
                                            <td><b>Gross Weight :</b><?php echo ' '. $mrr_results['gross_weight'].'Kgs'; ?></td>
                                            <td><b>Tier Weight :</b><?php echo ' '. $mrr_results['tier_weight'].'Kgs'; ?></td>   
                                        </tr>
                                         <tr>
                                            <td><b>DC Number :</b><?php echo ' '. $mrr_results['dc_number']; ?></td> 
                                            <?php $diff= ($mrr_results['net_weight'] -$mrr_results['invoice_net_weight'])*1000; ?>
                                            <td><b> Qty Difference:</b><?php if($diff > 0){ echo ' +'. $diff.'Kgs'; } else { echo ' '. $diff.'Kgs'; } ?></td>
                                            <?php if($mrr_results['po_quantity'] >= $received_qty) { ?>
                                            <td colspan="2"><b>Pending Quantity :</b><?php echo ($mrr_results['po_quantity']- $received_qty).'MT';?></td> 
                                            <?php } else { ?> 
                                            <td colspan="2"><b>Exceeded Quantity :</b><?php echo ($received_qty- $mrr_results['po_quantity']).'MT';?></td>
                                            <?php } ?> 
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <?php 
                            if($mrr_results['loose_oil_id']==gn_loose_oil_id())
                            { ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr><?php 
                                             $rebate=($total_rebate*$mrr_results['unit_price']* $mrr_results['net_weight'])/100;
                                             $payable_amount=($mrr_results['unit_price']* $mrr_results['net_weight'])-$rebate; ?>
                                            <td><b>Total Amount :</b><?php echo ' '. $mrr_results['unit_price']* $mrr_results['net_weight']; ?></td>
                                            <td><b>FFA :</b><?php echo ' '. $ffa_value; ?></td>
                                            <td><b>Rebate :</b><?php echo ' '.$rebate; ?></td>
                                            <td><b>Payable Amount :</b><?php echo ' '. $payable_amount; ?></td>   
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } 
                            else
                            { ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr><?php 
                                             $rebate=0;
                                             $payable_amount=($mrr_results['unit_price']* $mrr_results['net_weight'])-$rebate; ?>
                                            <td><b>Total Amount :</b><?php echo ' '. $mrr_results['unit_price']* $mrr_results['net_weight']; ?></td>
                                            <td><b>Rebate (if any):</b><?php echo ' '.'0'; ?></td>
                                            <td colspan="2"><b>Payabale Amount :</b><?php echo ' '. $payable_amount; ?></td>   
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                           <?php } 

                             if($mrr_details['remarks'] !='') { ?>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Remarks:</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"><?php echo ' '. $mrr_details['remarks']; ?> </p>
                                        </div>
                                    </div>
                                </div>
                                 <?php } ?>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-3">Oil Tank:</label>
                                        <div class="col-md-9">
                                            <p class="form-control-static"><?php echo ' '. $mrr_details['name']; ?> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                        
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-5 col-md-8">
                                        <button type="submit" name="download" value="1" formaction="<?php echo SITE_URL.'download_loose_oil_mrr';?>" class="btn blue"><i class="fa fa-cloud-download fa-lg"></i></button>
                                        <a href="<?php echo SITE_URL.'loose_oil_mrr';?>" class="btn default">Back</a>
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
<?php unset($_SESSION['response']); $this->load->view('commons/main_footer', $nestedView); ?>