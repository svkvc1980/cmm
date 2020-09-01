<?php $this->load->view('commons/main_template', $nestedView); ?>
<!-- BEGIN PAGE CONTENT INNER -->

<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">  
                <div class="portlet-body">
                    <div class="alert alert-danger display-hide" style="display: none;">
                       <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                    </div>
                       <form id="receipt_form" method="post" action="#" class="form-horizontal">
                         <div class="form-group">
                            <label for="inputName" class="col-sm-3 control-label"> Agency Name<span class="font-red required_fld">*</span></label>
                                <div class="col-sm-6">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                       <select class="form-control" name="type_id">
                                            <option selected value="">Select Agency Name</option>
                                            <?php foreach($types as $type)
                                                {   $selected='';
                                                    if($agency['agencyid']==@$search_data['agency_id']) $selected='selected';
                                                    echo '<option value="'.$agency['agency_id'].'"'.$selected.'>'.$agency['name'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                            <label for="inputName" class="col-sm-3 control-label"> Stock Lifting Unit<span class="font-red required_fld">*</span></label>
                                <div class="col-sm-6">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <select class="form-control" name="type_id">
                                            <option selected value="">Select Unit Code</option>
                                            <?php foreach($types as $type)
                                                {   $selected='';
                                                    if($unit['unitid']==@$search_data['unit_id']) $selected='selected';
                                                    echo '<option value="'.$unit['unit_id'].'"'.$selected.'>'.$unit['name'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                          <div class="form-group">
                              <div class="col-sm-offset-3 col-sm-10">
                                  <button class="btn blue" type="submit" name="submit" value="button"><i class="fa fa-check"></i> Submit</button>
                                  <a class="btn default" href="<?php echo SITE_URL;?>mmtc_module"><i class="fa fa-times"></i> Cancel</a>
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