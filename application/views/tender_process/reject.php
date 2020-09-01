<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">MTP No</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="mtp_no" value="<?php echo @$tender_details['mtp_number'];?>">
                                        <b><?php echo  $tender_details['mtp_number'];?></b>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Loose Oil</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="loose_oil_name" value="<?php echo @$tender_details['loose_oil_name'];?>">
                                        <b><?php echo  $tender_details['loose_oil_name'];?></b>
                                    </div>
                            </div>
                        </div><br><br>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Ops</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="plant_name" value="<?php echo @$tender_details['plant_name'];?>">
                                        <b><?php echo  $tender_details['plant_name'];?></b>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Tender Date</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="tender_date" data-date-format="dd-mm-yyyy" value="<?php echo @$tender_details['tender_date'];?>">
                                        <b><?php echo  date('d-m-Y',strtotime($tender_details['tender_date']));?></b>
                                    </div>
                            </div>
                        </div><br><br>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Quantity (MT)</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="quantity_rate" value="<?php echo @$tender_details['quantity'];?>">

                                        <b><?php echo  $tender_details['quantity'];?></b>
                                    </div>
                            </div>
                        </div>
                    </div><br>
                    <form method="post" action="<?php echo SITE_URL.'insert_remarks'?>">
                        <div class="form-group">
                           <label class="col-md-2 control-label ">Remarks<span class="font-red required_fld">*</span> </label>
                            <div class="col-md-3">
                                <textarea type="textarea" class="form-control" name="remarks"></textarea> 
                            </div>
                        </div>
                        <input type="hidden" name="mtp_oil_id" value="<?php echo @$tender_details['mtp_oil_id'];?>">
                       
                        <div class="row">
                            <div class="col-md-offset-5 col-md-5">
                                 <input type="submit" class="btn blue tooltips" name="submit">
                                 <a href="<?php echo SITE_URL.'tender_process_details';?>" class="btn default">Cancel</a>
                           </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->

<?php $this->load->view('commons/main_footer', $nestedView); ?>

