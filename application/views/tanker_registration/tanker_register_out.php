<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                <?php if($flag==1)
                {
                ?>  <form method="post" action="<?php echo SITE_URL.'register_out_details';?>" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-offset-3 col-md-5 jumbotron">
                                <div class="form-group">
                                    <label class="col-xs-6 control-label">Tanker Register No
                                    </label>
                                    <div class="col-xs-6">
                                       <input type="text" name="tank_reg_no" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-4"></div>
                                     <div class="col-xs-8">
                                   <input type="submit" class="btn blue tooltips" name="submit" value="submit">
                                     <a href="<?php echo SITE_URL.'tanker_register_out';?>" class="btn default">Cancel</a>
                                    </div>                                 
                                </div>
                            </div>
                        </div>
                    </form> 
                <?php 
                }
                else if($flag==2)
                {
                ?>
                    <form method="post" action="<?php echo SITE_URL.'tanker_register_out'?>">
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">S.No</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="s_no" value="<?php echo @$s_no;?>">
                                        <b><?php echo  1;?></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Date</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="party_name" value="<?php echo @$party_name;?>">
                                        <b><?php echo date('Y-m-d');?></b>
                                    </div>
                                </div>
                            </div>
                        </div></br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Purchase Order no<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="purchase_order" value="<?php echo @$purchase_order;?>">
                                        <b><?php echo 2?></b>   
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Party Name<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="party_name" value="<?php echo @$oil_name;?>">
                                        <b><?php echo "Prasad Suppliers ";?></b>
                                    </div>
                                </div>
                            </div>
                        </div></br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label ">Oil Name</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="oil_name" value="<?php echo @$oil_name;?>">
                                        <b><?php echo "Sunflower Oil";?></b>
                                    </div>
                                </div>
                            </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">DC NO</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="rate" value="<?php echo @$rate;?>">
                                        <b><?php echo 190; ?></b>
                                    </div>
                                </div>
                            </div>
                        </div></br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Invoice no/Bill no</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="invoice_no" value="<?php echo @$invoice_no;?>">
                                        <b><?php echo 1090; ?></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Vehicle No</label>
                                    <div class="col-md-6">
                                       <input type="hidden" name="vehicle_no" value="<?php echo @$vehicle_no;?>">
                                       <b><?php echo "AP 7Z TU 301"; ?></b>
                                    </div>
                                </div>
                            </div>
                        </div></br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Invoice Qty</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="invoice_qty" value="<?php echo @$invoice_qty;?>">
                                         <b><?php echo 100; ?></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">In Time</label>
                                    <div class="col-md-6">
                                       <input type="hidden" name="dc_no" value="<?php echo @$dc_no;?>">
                                       <b> <?php echo "10:05"; ?></b>
                                    </div>
                                </div>
                            </div>
                        </div></br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Net Weight</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="invoice_qty" value="<?php echo @$invoice_qty;?>">
                                         <b><?php echo 500; ?></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Shortage Of Oil</label>
                                    <div class="col-md-6">
                                       <input type="hidden" name="dc_no" value="<?php echo @$dc_no;?>">
                                       <b> <?php echo "0"; ?></b>
                                    </div>
                                </div>
                            </div>
                        </div></br>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label date-picker date">Out Date</label>
                                    <div class="col-md-6">
                                        <input type="text"class="date-picker date" name="invoice_date" placeholder="Select Date" value="<?php echo @$invoice_date;?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label ">Out Time</label>
                                    <div class="col-md-3">
                                        <input type="hidden" name="invoice_date" value="<?php echo @$invoice_date;?>">
                                        <b><?php echo date('h:i');?></b>
                                    </div>
                                </div>
                            </div>
                        </div></br>
                         <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label date-picker date">Out Date</label>
                                    <div class="col-md-6">
                                        <select name="status">
                                            <option value="">Select Status</option>
                                            <option value="1">Accepted</option>
                                            <option value="2">Rejected</option>
                                            </select>
                                    </div>
                                </div>
                            </div>
                           
                        </div></br>
                        <div>
                            <div class="row">
                                <div class="col-md-offset-5 col-md-4">
                                     <input type="submit" class="btn blue tooltips" name="submit" value="submit">
                                     <a href="<?php echo SITE_URL.'tanker_register_out';?>" class="btn default">Cancel</a>
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

