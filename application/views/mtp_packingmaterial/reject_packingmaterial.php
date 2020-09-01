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

                                        <input type="hidden" name="mtp_no" value="<?php echo @$packing_material_insert_details['mtp_number'];?>">

                                        <b><?php echo  $packing_material_insert_details['mtp_number'];?></b>

                                    </div>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label class="col-md-4 control-label">Packing Material</label>

                                    <div class="col-md-6">

                                        <input type="hidden" name="packing_name" value="<?php echo @$packing_material_insert_details['packing_name'];?>">

                                        <b><?php echo  $packing_material_insert_details['packing_name'];?></b>

                                    </div>

                            </div>

                        </div><br><br>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label class="col-md-4 control-label">Ops</label>

                                    <div class="col-md-6">

                                        <input type="hidden" name="plant_name" value="<?php echo @$packing_material_insert_details['plant_name'];?>">

                                        <b><?php echo  $packing_material_insert_details['plant_name'];?></b>

                                    </div>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label class="col-md-4 control-label">MTP Date</label>

                                    <div class="col-md-6">

                                        <input type="hidden" name="mtp_date" data-date-format="dd-mm-yyyy" value="<?php echo @$packing_material_insert_details['mtp_date'];?>">

                                        <b><?php echo  date('d-m-Y',strtotime($packing_material_insert_details['mtp_date']));?></b>

                                    </div>

                            </div>

                        </div><br><br>

                        <div class="col-md-6">

                            <div class="form-group">

                                <label class="col-md-4 control-label">Quantity </label>

                                    <div class="col-md-6">

                                        <input type="hidden" name="quantity_rate" value="<?php echo @$packing_material_insert_details['quantity'];?>">

                                        <b><?php echo  $packing_material_insert_details['quantity'];?></b>

                                    </div>

                            </div>

                        </div>

                    </div><br>

                    <form method="post" action="<?php echo SITE_URL.'reject_packingmaterial_remarks'?>">

                        <div class="form-group">

                           <label class="col-md-2 control-label ">Remarks<span class="font-red required_fld">*</span> </label>

                            <div class="col-md-3">

                                <textarea type="textarea" class="form-control" name="remarks"></textarea> 

                            </div>

                        </div>

                        <input type="hidden" name="mtp_pm_id" value="<?php echo @$packing_material_insert_details['mtp_pm_id'];?>">

                       

                        <div class="row">

                            <div class="col-md-offset-5 col-md-5">

                                 <input type="submit" class="btn blue tooltips" name="submit">

                                 <a href="<?php echo SITE_URL.'mtp_packingmaterial';?>" class="btn default">Cancel</a>

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



