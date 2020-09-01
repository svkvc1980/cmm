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
                    <form id="rollback_invoice_form" method="post" action="<?php echo SITE_URL.'rollback_invoice_product_delete';?>" class="form-horizontal">
                        <div class="row">  
                            <div class="col-md-offset-3 col-md-5 well"> 
                                <div class="form-group">
                                   <div class="form-group">
                                    <label class="col-md-5 control-label">Enter Invoice Number <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <input type="text" required name="invoice_id" maxlength="15" class="form-control numeric">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-5"></div>
                                    <div class="col-md-6">
                                        <input type="submit" class="btn blue tooltips"  value="submit" name="submit">
                                        <a href="<?php echo SITE_URL;?>" class="btn default">Cancel</a>
                                    </div>                                 
                                </div>
                            </div>
                        </div>
                    </form> 
                    <?php }
                    if($flag==2) { 
                    ?> 
                    <form id="invoice_date_form" method="post" action="<?php echo SITE_URL.'delete_invoice_product';?>" class="form-horizontal">
                    <input type="hidden" name="invoice_id" value="<?php echo $results['invoice_id']; ?>">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-6 control-label">Invoice Number :</label>
                                    <div class="col-md-6">
                                        <b class="form-control-static"><?php echo @$results['invoice_number'] ?></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Invoice Date :</label>
                                    <div class="col-md-6">
                                        <b class="form-control-static"><?php echo date('d-m-Y', strtotime(@$results['invoice_date'])); ?></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Distributor :</label>
                                    <div class="col-md-8">
                                        <b class="form-control-static"><?php echo @$results['agency_name'].' -'.' ['. $results['distributor_code'].' ]' ; ?></b>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-6 control-label">OB Number :</label>
                                    <div class="col-md-6">
                                        <b class="form-control-static"><?php echo @$inv_obs ; ?></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">DO Number :</label>
                                    <div class="col-md-6">
                                        <b class="form-control-static"><?php echo @$inv_dos; ?></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Truck No :</label>
                                    <div class="col-md-8">
                                        <b class="form-control-static"><?php echo @$results['vehicle_number'] ?></b>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-6 control-label">TIN no :</label>
                                    <div class="col-md-6">
                                        <b class="form-control-static"><?php echo @$results['tin_num'] ; ?></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Mobile :</label>
                                    <div class="col-md-6">
                                        <b class="form-control-static"><?php echo @$results['mobile'] ; ?></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">From :</label>
                                    <div class="col-md-8">
                                        <b class="form-control-static"><?php echo @$results['lifting'] ; ?></b>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-6 control-label">To :</label>
                                    <div class="col-md-6">
                                        <b class="form-control-static"><?php echo @$results['location'] ?></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Address :</label>
                                    <div class="col-md-6">
                                        <b class="form-control-static"><?php echo @$results['address'] ; ?></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Total Value :</label>
                                    <div class="col-md-8">
                                        <b class="form-control-static"><?php echo price_format(@$sum); ?></b>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>S. No</th>
                                        <th>Product</th>
                                        <th>Units</th>
                                        <th>Cartons</th>
                                        <th>Quantity(kg)</th>
                                        <th>Price per Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sn = 1;
                                    if($invoice_dist_product)
                                    {
                                        foreach($invoice_dist_product as $row)
                                        {
                                    ?>
                                    <tr>
                                        <td><input type="checkbox" name="checkbox[]" value="<?php echo $row['invoice_do_product_id']?>"></td>
                                        <td><?php echo $sn++; ?> </td>
                                        <td><?php echo $row['product']; ?></td>
                                        <td align="right"><?php echo $row['packets'] ?></td>
                                        <td align="right"><?php echo round($row['carton_qty'],2); ?></td>
                                        <td align="right"><?php echo qty_format($row['qty_in_kg']); ?></td>
                                        <td align="right"><?php echo price_format($row['rate']) ?></td>
                                    </tr>
                                    <?php } 
                                    }
                                    else 
                                    {
                                    ?>  
                                        <tr><td colspan="6" align="center"><span class="label label-primary">No Records</span></td></tr>
                                    <?php   
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row ">
                            <div class="col-md-offset-3 col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Remarks <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7">
                                        <textarea class="form-control" name="remarks" required></textarea> 
                                    </div>
                                </div>    
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-md-offset-5 col-md-5">
                                <button type="submit" class="btn blue" onclick="return confirm('Are you sure you want to Delete Items?')" name="submit">Delete Item</button>
                                <a href="<?php echo SITE_URL.'invoice_product_delete';?>" class="btn default">Cancel</a>
                            </div>
                        </div>  
                    </form><?php
                    }
                    if($flag==3) { 
                    ?> 
                    <form id="invoice_date_form" method="post" action="<?php echo SITE_URL.'delete_invoice_product';?>" class="form-horizontal">
                    <input type="hidden" name="invoice_id" value="<?php echo $results['invoice_id']; ?>">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-6 control-label">Invoice Number :</label>
                                    <div class="col-md-6">
                                        <b class="form-control-static"><?php echo @$results['invoice_number'] ?></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Invoice Date :</label>
                                    <div class="col-md-6">
                                        <b class="form-control-static"><?php echo date('d-m-Y', strtotime(@$results['invoice_date'])); ?></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">From :</label>
                                    <div class="col-md-8">
                                        <b class="form-control-static"><?php echo @$results['from'] ; ?></b>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-6 control-label">OB Number :</label>
                                    <div class="col-md-6">
                                        <b class="form-control-static"><?php echo @$inv_obs ; ?></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">DO Number :</label>
                                    <div class="col-md-6">
                                        <b class="form-control-static"><?php echo @$inv_dos; ?></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">To :</label>
                                    <div class="col-md-8">
                                        <b class="form-control-static"><?php echo @$results['to'] ?></b>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-6 control-label">TIN no :</label>
                                    <div class="col-md-6">
                                        <b class="form-control-static"><?php echo @$tin_num ; ?></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Truck Number :</label>
                                    <div class="col-md-6">
                                        <b class="form-control-static"><?php echo @$results['vehicle_number'] ?></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Total Value :</label>
                                    <div class="col-md-8">
                                        <b class="form-control-static"><?php echo price_format(@$sum); ?></b>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>S. No</th>
                                        <th>Product</th>
                                        <th>Units</th>
                                        <th>Cartons</th>
                                        <th>Quantity(kg)</th>
                                        <th>Price per Unit</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $sn = 1;
                                    if($invoice_plant_product)
                                    {
                                        foreach($invoice_plant_product as $row)
                                        {
                                    ?>
                                    <tr>
                                        <td><input type="checkbox" name="checkbox[]" value="<?php echo $row['invoice_do_product_id']?>"></td>
                                        <td><?php echo $sn++; ?></td>
                                        <td><?php echo $row['product']; ?></td>
                                        <td align="right"><?php echo $row['packets'] ?></td>
                                        <td align="right"><?php echo round($row['carton_qty'],2); ?></td>
                                        <td align="right"><?php echo qty_format($row['qty_in_kg']); ?></td>
                                        <td align="right"><?php echo price_format($row['rate']) ?></td>
                                    </tr>
                                    <?php } 
                                    }
                                    else 
                                    {
                                    ?>  
                                        <tr><td colspan="6" align="center"><span class="label label-primary">No Records</span></td></tr>
                                    <?php   
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row ">
                            <div class="col-md-offset-3 col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Remarks <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7">
                                        <textarea class="form-control" name="remarks" required></textarea> 
                                    </div>
                                </div>    
                            </div>    
                        </div>
                        <div class="row">
                            <div class="col-md-offset-5 col-md-5">
                                <button type="submit" class="btn blue" onclick="return confirm('Are you sure you want to Delete Items?')" name="submit">Delete Item</button>
                                <a href="<?php echo SITE_URL.'invoice_product_delete';?>" class="btn default">Cancel</a>
                            </div>
                        </div>   
                    </form><?php
                    }?>
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>             