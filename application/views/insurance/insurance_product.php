<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <?php 
                    if(@$flag==1)
                    {
                    ?>
                    <form role="form" id="" class="form-horizontal" method="post" action="<?php echo SITE_URL;?>submit_insurance_product">
                        <div class="form-group">
                            <label class="col-md-5 control-label">Enter Invoice Number<span class="font-red required_fld">*</span></label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <input type="text" name="invoice_no" required class="form-control" placeholder="Invoice Number">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-5">
                                <button type="submit" title="Submit" name="submit" value="submit" class="btn blue">Submit</button>
                                <a title="Cancel" href="<?php echo SITE_URL.'insurance_product';?>" class="btn default">Cancel</a>
                            </div>
                        </div>
                    </form>
                    <?php 
                    }
                    if(@$flag==3)
                    { ?>
                        <form role="form" id="" class="form-horizontal" method="post" action="<?php echo SITE_URL;?>submit_insurance_product_plant">
                        <div class="form-group">
                            <label class="col-md-5 control-label">Enter Invoice Number<span class="font-red required_fld">*</span></label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <input type="text" name="invoice_no" required class="form-control" placeholder="Invoice Number">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-5">
                                <button type="submit" title="Submit" name="submit" value="submit" class="btn blue">Submit</button>
                                <a title="Cancel" href="<?php echo SITE_URL.'plant_insurance_product';?>" class="btn default">Cancel</a>
                            </div>
                        </div>
                    </form>
                  <?php  }
                    if(@$flag==2)
                    { if($type['invoice_type']==1)
                       {
                    ?>
                    <div class="padding">
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                           <div class="form-group">
                                                <label><b>TO</b></label>                                                
                                                <h5><b><?php 
                                                    $to_location = ($inv_products[0]['location_id']==2||$inv_products[0]['location_id']==3)?$inv_products[0]['distributor_place']:$inv_products[0]['location_name'];
                                                    echo  @$inv_products[0]['agency_name'].' <b> '.'['. @$inv_products[0]['distributor_code'].']</b>';?></b></h5>
                                                <h5><b><?php echo @$inv_products[0]['address'].',  '.@$to_location;?></b></h5>
                                                <h5><b>Ph No<b style="padding-left:35px;">:&nbsp;&nbsp;&nbsp;<?php echo @$inv_products[0]['mobile'];?></b></h5>
                                                <h5><b>Tin No<b style="padding-left:30px;">:&nbsp;&nbsp;&nbsp;<?php echo @$inv_products[0]['vat_no'];?></b></h5><br>
                                                <h5><b>Despatch through<b style="padding-left:30px;">:&nbsp;&nbsp;&nbsp;<?php echo '';?></b></h5>
                                                <h5><b>LR/RR Truck No<b style="padding-left:50px;">:&nbsp;&nbsp;&nbsp;<?php echo @$inv_products[0]['vehicle_number'];?></b></h5>
                                                <h5><b>From<b style="padding-left:20px;">:&nbsp;&nbsp;&nbsp;<?php echo get_m_plant_name();?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>To<b style="padding-left:20px;">:&nbsp;&nbsp;&nbsp;
                                                <?php 
                                                $to_location = ($inv_products[0]['location_id']==2||$inv_products[0]['location_id']==3)?$inv_products[0]['distributor_place']:$inv_products[0]['location_name'];
                                                echo $to_location;
                                                ?></b></h5><br>
                                             </div>
                                        </div>
                                        <div class="padding">
                                            <div class="col-md-6">
                                                <div class="form-group">                                               
                                                    <label ></label> 
                                                    <h5><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Invoice No</b><b style="padding-left:30px;">:&nbsp;&nbsp;<?php echo $inv_products[0]['invoice_number'];?></b><b style="padding-left:90px;">Date</b><b style="padding-left:30px;">&nbsp;:&nbsp;&nbsp;<?php echo date('d-m-Y',strtotime($inv_products[0]['invoice_date']));?></b></h5> 
                                                    <h5><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O.B No</b><b style="padding-left:55px;">:&nbsp;&nbsp;<?php echo $inv_obs;?></b></h5>
                                                    <h5><b style="padding-left:20px;">Date</b><b style="padding-left:70px;">&nbsp;:&nbsp;&nbsp;<?php echo $inv_ob_dates;?></b></h5><br>
                                                    <h5><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;D.O No</b><b style="padding-left:55px;">:&nbsp;&nbsp;<?php echo $inv_dos;?></b></h5>
                                                    <h5><b style="padding-left:20px;">Date</b><b style="padding-left:70px;">&nbsp;:&nbsp;&nbsp;<?php echo $inv_do_dates;?></b></h5> 
                                                </div>                                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } elseif($type['invoice_type'] ==2) { ?>
                                <div class="padding">
                            <div class="row">
                                
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><b>TO</b></label> 
                                                <h5><b><?php echo get_plant_name_not_in_session($inv_products[0]['receiving_plant_id']);?></b></h5>
                                                <h5><b>Despatch through<b style="padding-left:30px;">:&nbsp;&nbsp;&nbsp;<?php echo '';?></b></h5>
                                                <h5><b>LR/RR Truck No<b style="padding-left:50px;">:&nbsp;&nbsp;&nbsp;<?php echo @$inv_products[0]['vehicle_number'];?></b></h5>
                                                <h5><b>From<b style="padding-left:20px;">:&nbsp;&nbsp;&nbsp;<?php echo get_m_plant_name();?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>To<b style="padding-left:20px;">:&nbsp;&nbsp;&nbsp;<?php echo get_plant_name_not_in_session($inv_products[0]['receiving_plant_id']);?></b></h5><br>
                                            </div>
                                        </div>
                                        <div class="padding">
                                            <div class="col-md-6">
                                                <div class="form-group">                        
                                                   <h5><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Invoice No</b><b style="padding-left:30px;">:&nbsp;&nbsp;<?php echo $inv_products[0]['invoice_number'];?></b></b><b style="padding-left:90px;">Date</b><b style="padding-left:30px;">&nbsp;:&nbsp;&nbsp;<?php echo $inv_products[0]['invoice_date'];?></b></h5> 
                                                    <h5><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O.B No</b><b style="padding-left:55px;">:&nbsp;&nbsp;<?php echo $inv_obs;?></b><b style="padding-left:100px;">Date</b><b style="padding-left:30px;">&nbsp;:&nbsp;&nbsp;<?php echo $inv_ob_dates?></b></h5><br>
                                                    <h5><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;D.O No</b><b style="padding-left:55px;">:&nbsp;&nbsp;<?php echo $inv_dos;?></b><b style="padding-left:55px;">Date</b><b style="padding-left:30px;">&nbsp;:&nbsp;&nbsp;<?php echo $inv_do_dates;?></b></h5>
                                                </div>                                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php } ?>
                    <div class="table-scrollable">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Pouches</th>
                                    <th>Cartons</th>
                                    <th>value</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sn = 1;
                                $total=0;
                                if($invoice_product)
                                {   
                                    foreach ($invoice_product as $row) 
                                    {?>
                                        <tr>
                                            <td><?php echo $sn++ ?></td>
                                            <td><?php echo $row['product']?></td>
                                            <td><?php echo $row['product_price']?></td>
                                            <td><?php echo $row['quantity']*$row['ipc']?></td>
                                            <td><?php echo $row['quantity']?></td>
                                            <td align="right"><?php echo price_format($row['product_price']*$row['quantity']*$row['ipc'])?></td>
                                        </tr>
                              <?php $total+=$row['product_price']*$row['quantity']*$row['ipc'];
                                  } ?>
                                <tr>
                                <td colspan="5" align="right">Grand Total</td>
                                <td align="right"><?php echo price_format($total);?></td>
                                </tr>
                             <?php   }
                                ?>
                            </tbody>
                        </table>        
                    </div>
                    <h4 class="text-primary">Insurance Product Entry:</h4>
                    <form role="form" class="form-horizontal" method="post" action="<?php echo SITE_URL.'insert_insurance_product'; ?>">
                        <div class="form-group">
                            <label class="col-md-2 control-label">Enter LR Number:<span class="font-red required_fld">*</span></label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                    <input type="text" required name="lr_no" class="form-control" placeholder="Lr Number">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" class="invoice_id" name="invoice_id" value="<?php echo $invoice_no ?>">
                        <div class="table-scrollable">
                            <table id="insurance" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Leaked Pouches</th>
                                        <th>Recovered Oil (KG's)</th>
                                        <th>Net Loss</th>
                                        <th>Net Loss Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="ins_row">
                                        <td>
                                            
                                            <input type="hidden" class="product_count" name="product_count" value="<?php echo $count ?>">
                                            <select name="product_id[]" class="form-control product">
                                                <option value="">Select Product</option>
                                                <?php
                                                foreach ($products as $rrow)
                                                {
                                                    echo '<option value="'.$rrow['product_id'].'">'.$rrow['product'].'</option>';
                                                }
                                                ?>
                                                <input type="hidden" name="oil_weight" class="oil_weight">
                                                <input type="hidden" name="price" class="price">
                                                <input type="hidden" name="invoice_do_product_id[]" class="invoice_product">
                                            </select>
                                        </td>
                                        <td>
                                            <div class="ip">
                                                <input type="text" name="leaked_pouches[]" required placeholder="Leaked Pouches" class="form-control numeric leaked_pouches">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="ip">
                                                <input type="text" name="recovered_oil[]" required placeholder="Recovered Oil" class="form-control numeric recovered_oil">
                                                <span style="display:none; color:red;" class="span">Recovery oil should not exceed leaked weight</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="ip">
                                                <input type="text" name="net_loss[]" readonly required placeholder="Net Loss" class="form-control numeric net_loss">
                                            </div>    
                                        </td>
                                        <td>
                                            <div class="ip">
                                                <input type="text" name="net_loss_amount[]" readonly required placeholder="Net Loss Amount" class="form-control numeric net_loss_amount">
                                            </div>
                                        </td>
                                        <td align="center">
                                            <button class="btn blue btn-xs add" name="add" id="add" value="ADD"><i class="fa fa-plus"></i></button>
                                            <button style="display:none" class="btn red btn-xs remove" type="submit" name="remove" id="remove" value="button"><i class="fa fa-trash"></i></button>
                                        </td>   
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-offset-5 col-md-3">
                                <button type="submit" name="submit" value="Submit" class="btn blue submit">Submit</button>
                                <a title="Cancel" href="<?php echo SITE_URL.'insurance_product';?>" class="btn blue">Back</a>
                            </div>
                        </div>
                    </form>      
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>  
<?php $this->load->view('commons/main_footer', $nestedView); ?>
