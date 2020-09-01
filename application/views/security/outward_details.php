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
                ?>  <form method="post" action="<?php echo SITE_URL.'outward_details';?>" class="form-horizontal">
                        <div class="row">                        
                            <div class="col-md-offset-3 col-md-5 jumbotron">
                                <div class="form-group">
                                    <label class="col-xs-5 control-label">Ticket No</label>
                                    <div class="col-xs-7">
                                       <input type="text" name="serial_num" class="form-control" required>
                                    </div>

                                </div>
                                <div class="form-group">
                                    <div class="col-xs-3"></div>
                                     <div class="col-xs-8">
                                    <input type="submit" class="btn blue tooltips" name="submit" value="Submit">                                    
                                       <a href="<?php echo SITE_URL.'outward';?>" class="btn default">Cancel</a>  
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
                    <form method="post" action="<?php echo SITE_URL.'outward'?>" >
                        <div class="row">
                            <div class="col-md-offset-1 col-md-10">
                             <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-5 control-label">S.No</label>
                                    <div class="col-xs-7">
                                        <input type="hidden" name="serial_num" value="<?php echo @$serial_num;?>">
                                        <b><?php echo  $serial_num;?></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Date</label>
                                    <div class="col-md-7">
                                        <input type="hidden" name="party_name" value="<?php echo date("Y-m-d");?>">
                                        <b><?php echo $details['date']?></b>
                                    </div>
                                </div>
                            </div></div><br>
                             <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Type</label>
                                    <div class="col-md-7">
                                        <input type="hidden" name="party_name" value="<?php echo @$type;?>">
                                        <b><?php echo $details['Type'] ;?></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-xs-5 control-label">Invoice / PO NO</label>
                                    <div class="col-xs-7">
                                        <input type="hidden" name="s_no" value="<?php //echo $serial_num;?>">
                                        <b><?php echo $details['InvoiceNo'];?></b>
                                    </div>
                                </div>
                            </div></div><br>
                             <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Ticket No</label>
                                    <div class="col-md-7">
                                        <input type="hidden" name="party_name" value="" class="form-control">
                                        <b><?php echo $details['TicketNo'];?></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Vehicle No</label>
                                    <div class="col-md-7">
                                        <input type="hidden" name="party_name" value="" class="form-control">
                                        <b><?php echo $details['VehicleNo'];?></b>
                                    </div>
                                </div>
                            </div></div><br>
                             <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Name of Party</label>
                                    <div class="col-md-7">
                                        <input type="hidden" name="party_name" value="" class="form-control">
                                        <b><?php echo $details['Party'];?></b>
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Product / Material</label>
                                    <div class="col-md-7">
                                        <input type="hidden" name="party_name" value="" class="form-control">
                                        <b><?php echo $details['Product'];?></b>
                                    </div>
                                </div>
                            </div>
                            </div><br>
                             <div class="row">
                                 <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Quantity</label>
                                    <div class="col-md-7">
                                        <input type="hidden" name="party_name" value="" class="form-control">
                                        <b><?php echo $details['Quantity'];?></b>
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Intime</label>
                                    <div class="col-md-7">
                                        <input type="hidden" name="party_name" value="" class="form-control">
                                       
                                        <b><?php echo $details['Intime'];?></b>
                                    </div>
                                </div>
                            </div>
                             </div><br>
                             <div class="row">
                                 <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Driver Name</label>
                                    <div class="col-md-7">
                                        <input type="hidden" name="party_name" value="" class="form-control">
                                        <b><?php echo $details['DriverName'];?></b>
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Phone No</label>
                                    <div class="col-md-7">
                                        <input type="hidden" name="party_name" value="" class="form-control">
                                        <b><?php echo $details['Phone'];?></b>
                                    </div>
                                </div>
                            </div>
                             </div><br>
                              <div class="row">
                                 <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Out Time</label>
                                    <div class="col-md-7">
                                        <input type="hidden" name="party_name" value="" class="form-control">
                                        <b><?php echo $details['outtime'] ?> &nbsp; <?php echo date('H:i:s');?></b>
                                    </div>
                                </div>
                            </div>
                             </div>
                            </div>
                        </div>
                            <div class="row">
                                <div class="col-md-offset-5 col-md-4">
                                     <input type="submit" class="btn blue tooltips" value="Submit" name="submit">
                                     <a href="<?php echo SITE_URL.'outward';?>" class="btn default">Cancel</a>
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
