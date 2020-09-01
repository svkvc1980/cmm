<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                	<form method="post" class="form-horizontal" action="<?php echo $form_action?>">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                <label class="col-md-5 control-label">Loose Oil</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="loose_oil">
                                          <option value="">- Select Loose Oil -</option>
                                          <?php
                                                foreach($loose_oil as $row)
                                                {                                                    
                                                   echo '<option value="'.$row['loose_oil_id'].'">'.$row['name'].'</option>';
                                                }
                                            ?>
                                      </select> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if($block_id == 1){ ?>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                <label class="col-md-5 control-label">OPS <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="ops" required>
                                          <option value="">- Select OPS -</option>
                                          <?php
                                                foreach($ops_dropdown as $row)
                                                {                                                    
                                                   echo '<option value="'.$row['plant_id'].'">'.$row['name'].'</option>';
                                                }
                                            ?>
                                      </select> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="row">   
                            <div class="col-md-8">
                                <div class="form-group">
                                <label class="col-md-5 control-label">Date <span class="font-red required_fld">*</span></label>
	                                <div class="col-md-6">
	                                    <div class="input-group date-picker input-daterange" data-date-format="dd-mm-yyyy">
	                                        <input class="form-control" name="from_date" placeholder="From Date" type="text" value="<?php echo @$search_data['from_date'];?>">
	                                            <span class="input-group-addon"> to </span>
	                                        <input class="form-control" name="to_date" placeholder="To Date" type="text" value="<?php echo @$search_data['to_date'];?>">
	                                    </div>
	                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-offset-5 col-md-6">
                                <button type="submit" value="1" name="submit" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Submit">Submit</button>
                                <a href="<?php echo SITE_URL.'processing_loss_report';?>" class="btn default tooltips" data-container="body" data-placement="top" data-original-title="Reset">Reset</a>
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