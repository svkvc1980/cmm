 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    
                    <form method="post" action="<?php echo SITE_URL.'print_dist_datewise_dd_report'?>">
                    <div class="row">
                    <div class=" col-md-offset-2 col-md-8">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input class="form-control" name="dd_number" value="<?php echo @$search_data['dd_number'];?>" placeholder="DD Number" type="text">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php echo form_dropdown('pay_mode_id',$pay_mode,@$search_data['pay_mode_id'],'class="form-control"');?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <?php echo form_dropdown('bank_id',$bank,@$search_data['bank_id'],'class="form-control select2"');?>
                                </div>
                            </div>  
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <select name="status" class="form-control" >
                                        <option value="">Select Status</option>
                                        <option value="2" <?php if(@$search_data['status']==2){?>selected <?php } ?> >Approved</option>
                                        <option value="3" <?php if(@$search_data['status']==3){?>selected <?php } ?>>Rejected</option>
                                    </select>
                                </div>
                            </div>  
                            
                            
                        </div>
                        <div class="row">
                            <div class="col-sm-offset-3 col-sm-6">
                                <div class="form-group">
                                   <select class="form-control select2" name="distributor_id" >
                                            <option value="">-Select distributor- </option>
                                            <?php
                                            foreach($distributor as $dis)
                                            { 
                                                echo '<option value="'.$dis['distributor_id'].'">'.$dis['distributor_code'].' - ('.$dis['agency_name'].')</option>';
                                            }?>
                                         </select>
                                </div>
                            </div>
                        </div>
                        <?php $block_id =$this->session->userdata('block_id');
                        if($block_id ==1)
                        {
                        ?>
                        <div class="row">
                            <div class="col-sm-offset-3 col-sm-6">
                                <div class="form-group">
                                   <select class="form-control" name="plant_id" >
                                            <option value="">-Select Unit- </option>
                                            <?php
                                            foreach($plant_list as $plant)
                                            {  
                                                echo '<option value="'.$plant['plant_id'].'">'.$plant['name'].'</option>';
                                            }?>
                                         </select>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="row">  
                            <div class="col-sm-offset-3 col-md-6">
                                <div class="form-group">
                                    <div class="input-group date-picker input-daterange " data-date-format="dd-mm-yyyy">
                                        <input class="form-control" required name="from_date"  placeholder="From Date" type="text" >
                                        <span class="input-group-addon"> to </span>
                                            <input class="form-control" required name="to_date" placeholder="To Date" type="text">
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">  
                            <div class="form-actions col-md-offset-4 col-md-4">
                                <input type="submit" name="submit" value="submit" class="btn green">
                                <a type="button" href="<?php echo SITE_URL;?>" class="btn default">Cancel</a>
                                <button type="submit" name="download_dd_payment" value="1" formaction="<?php echo SITE_URL.'download_distributor_dd_payment';?>" class="btn blue"><i class="fa fa-cloud-download"></i></button>
                            </div>                               
                        </div>
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