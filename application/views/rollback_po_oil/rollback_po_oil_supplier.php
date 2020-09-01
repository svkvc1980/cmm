<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <?php
                    if($flag==1)
                    {
                      ?>
                      <form id="dd_date_form" method="post" action="<?php echo SITE_URL.'rollback_po_oil_supplier';?>" class="form-horizontal">
                        <div class="row ">  
                            <div class="col-md-offset-3 col-md-5"> 
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Enter PO Number <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7">
                                        <input type="text" name="po_no" class="form-control numeric" required> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-5"></div>
                                        <div class="col-md-6">
                                            <input type="submit" class="btn blue tooltips"  value="Submit" name="submit">
                                            <a href="<?php echo SITE_URL;?>" class="btn default">Cancel</a>
                                        </div>                                 
                                </div>
                            </div>
                        </div>
                        
                    </form><?php  
                    } 
                    if($flag==2)
                    { 
                      //echo "<pre>"; print_r($dd_list); exit;
                       ?>
                       <form id="dd_date_form" method="post" action="<?php echo SITE_URL.'insert_rollback_po_oil_supplier';?>" class="form-horizontal">
                            <input type="hidden" name="po_oil_id" value="<?php echo $po_list['po_oil_id']; ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">PO Number :</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo  $po_list['po_number'] ;?></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">PO Date :</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo  date('d-m-Y', strtotime($po_list['po_date']));?></b>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Product Name :</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo  $po_list['oil_name'];?></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label"> Price :</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo  $po_list['unit_price'];?></b>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Quantity :</label>
                                        <div class="col-md-6">
                                            <p><b class="form-control-static"><?php echo  $po_list['quantity'];?></b> </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Broker :</label>
                                        <div class="col-md-6">
                                            <p><b class="form-control-static"><?php echo  $po_list['broker_name'];?></b> </p>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Existing Supplier :</label>
                                        <div class="col-md-6">
                                            <p><b class="form-control-static"><?php echo  $po_list['supplier_name'];?></b> </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Plant :</label>
                                        <div class="col-md-6">
                                            <p><b class="form-control-static"><?php echo  $po_list['plant_name'];?></b> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-offset-2 col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">New Supplier <span class="font-red required_fld">*</span></label>
                                        <div class="col-md-8">
                                            <select  class="form-control" name="supplier_id" required>
                                                <option value="">-Select Supplier-</option>
                                                <?php 
                                                    foreach($supplier as $row)
                                                    {
                                                        echo '<option value="'.$row['supplier_id'].'">'.$row['agency_name'].' - ('.$row['supplier_code'].') </option>';
                                                        
                                                    }
                                                ?>
                                            </select> 
                                        </div>
                                    </div>    
                                </div>    
                            </div>
                            <div class="row ">
                                <div class="col-md-offset-2 col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Remarks <span class="font-red required_fld">*</span></label>
                                        <div class="col-md-8">
                                            <textarea class="form-control" name="remarks" required></textarea> 
                                        </div>
                                    </div>    
                                </div>    
                            </div>
                                <div class="row">
                                    <div class="col-md-offset-5 col-md-6">
                                        <button type="submit" class="btn blue" onclick="return confirm('Are you sure you want to Submit?')"  name="submit">Submit</button>
                                        <a href="<?php echo SITE_URL.'po_oil_supplier';?>" class="btn default">Cancel</a>
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