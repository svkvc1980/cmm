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
                    <form id="dd_number_form" method="post" action="<?php echo SITE_URL.'dd_number_change_details';?>" class="form-horizontal">
                        <div class="row ">  
                            <div class="form-group">
                                <label class="col-md-4 control-label">Distributor <span class="font-red required_fld">*</span></label>
                                <div class="col-md-5">
                                    <select  class="form-control select2" name="distributor_name" required>
                                        <option selected value="">-Select distributor-</option>
                                        <?php 
                                            foreach($distributor as $dist)
                                            {
                                                $selected = '';
                                                if($dist['distributor_id'] ==@$distributor_id) $selected = 'selected';
                                                echo '<option value="'.$dist['distributor_id'].'" '.$selected.'>'.$dist['distributor_code'].' - ('.$dist['agency_name'].')'.'</option>';
                                            }
                                        ?>
                                    </select> 
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">DD Number <span class="font-red required_fld">*</span></label>
                                <div class="col-md-5">
                                    <input type="text" name="dd_number" maxlength="15" class="form-control numeric" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">DD Amount</label>
                                <div class="col-md-5">
                                    <input type="text" name="dd_amount" maxlength="15" class="form-control numeric">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-5"></div>
                                    <div class="col-md-7">
                                        <input type="submit" class="btn blue tooltips"  value="Proceed" name="submit">
                                        <a href="<?php echo SITE_URL.'dd_number_change';?>" class="btn default">Cancel</a>
                                    </div>                                 
                            </div>
                        </div>
                    </form> 
                    <?php }
                    else if($flag==2) { 
                    ?> 
                        <form id="dd_number_form" method="post" action="<?php echo SITE_URL.'insert_rollback_dd_number';?>" class="form-horizontal">
                            <input type="hidden" name="payment_id" value="<?php echo $dd_number['payment_id'];?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Distributor</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo  $dd_number['distributor_code'].' - ('.$dd_number['agency_name'].')' ;?></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Bank Name :</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo  $dd_number['name'];?></b>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Existing DD Number :</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo  $dd_number['dd_number'];?></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">DD Amount :</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo  $dd_number['amount'];?></b>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Payment Mode :</label>
                                        <div class="col-md-6">
                                            <p><b class="form-control-static"><?php echo  $dd_number['payment_mode'];?></b> </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Payment Date :</label>
                                        <div class="col-md-6">
                                            <p><b class="form-control-static"><?php echo  date('d-m-Y',strtotime($dd_number['payment_date']));?></b> </p>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <div class="row ">
                                <div class="col-md-offset-3 col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Enter New DD Number <span class="font-red required_fld">*</span></label>
                                        <div class="col-md-5">
                                            <input type="text" class="form-control numeric" name="dd_number" required>
                                        </div>
                                    </div>    
                                </div>    
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
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-5 col-md-6">
                                        <button type="submit" class="btn blue" onclick="return confirm('Are you sure you want to Submit?')" name="submit">Submit</button>
                                        <a href="<?php echo SITE_URL.'dd_number_change';?>" class="btn default">Cancel</a>
                                    </div>
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