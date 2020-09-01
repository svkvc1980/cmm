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
                      <form id="po_fg_product_form" method="post" action="<?php echo SITE_URL.'po_fg_product_details_change';?>"  class="form-horizontal">
                        <div class="row ">  
                            <div class="col-md-offset-3 col-md-5"> 
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Enter PO Number</label>
                                    <div class="col-md-7">
                                        <input type="text" name="po_no" required class="form-control numeric"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-5"></div>
                                        <div class="col-md-6">
                                            <input type="submit" class="btn blue tooltips"  value="Proceed" name="submit">
                                            <a href="<?php echo SITE_URL.'po_fg_product_change';?>" class="btn default">Cancel</a>
                                        </div>                                 
                                </div>
                            </div>
                        </div>
                    </form><?php  
                    } 
                    if($flag==2)
                    { ?>
                       <form id="po_fg_product_form" method="post" action="<?php echo SITE_URL.'insert_po_fg_product_change';?>" class="form-horizontal">
                            <input type="hidden" name="po_fg_id" value="<?php echo $po_list['po_fg_id']; ?>">
                            <input type="hidden" name="existing_product" value="<?php echo $po_list['fg_name']; ?>">
                            <input type="hidden" name="existing_product_id" value="<?php echo $po_list['free_gift_id']; ?>">
                             <input type="hidden" name="po_number" value="<?php echo $po_list['po_number'] ?>">
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
                                        <label class="col-md-4 control-label">Existing Product Name :</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo  $po_list['fg_name'];?></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Supplier :</label>
                                        <div class="col-md-6">
                                           <b class="form-control-static"><?php echo  $po_list['supplier_name'].'['.$po_list['supplier_code'].']';?></b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Rate :</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo  $po_list['unit_price'];?></b>
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Quantity :</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo  $po_list['quantity'];?></b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Select New Product Name</label>
                                        <div class="col-md-6">
                                            <select  class="form-control" name="fg_name" >
                                                <option selected value="">-Select Product Name-</option>
                                                <?php 
                                                    foreach($product_list as $row)
                                                    {
                                                        echo '<option value="'.$row['free_gift_id'].'" '.$selected.' >'.$row['name'].'</option>';
                                                    }
                                                ?>
                                            </select> 
                                        </div>
                                    </div>    
                                </div>
                                <div class=" col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Remarks <span class="font-red required_fld">*</span></label>
                                        <div class="col-md-6">
                                            <textarea class="form-control" name="remarks" required ></textarea> 
                                        </div>
                                    </div>    
                                </div>    
                            </div>
                                <div class="row">
                                    <div class="col-md-offset-5 col-md-6">
                                        <button type="submit" class="btn blue"  name="submit">Submit</button>
                                        <a href="<?php echo SITE_URL.'po_fg_product_change';?>" class="btn default">Cancel</a>
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