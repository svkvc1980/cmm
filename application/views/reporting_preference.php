 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <!-- <div class="portlet-title"> -->
                    <div class="caption">
                        <!-- <i class="fa fa-university  font-green"></i> -->
                        <span class="caption-subject font-green bold uppercase"><?php echo @$portlet_title;?></span>
                    </div>
                <!-- </div> -->
                <div class="portlet-body">
                    <?php
                    if(isset($flg)){
                    ?>
                        <form class="form-horizontal reporting_form" method="post" action="<?php echo $form_action;?>" >
                            <?php
                            if($flg==2){
                                ?>
                                <input type="hidden" name="encoded_id" value="<?php echo cmm_encode($lrow['rep_preference_id']);?>">
                                <?php
                               }
                            ?>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Section <span class="font-red required_fld">*</span></label>
                            <div class="col-md-5">
                                <div class="input-icon right">
                                        <i class="fa"></i>
                                    <input class="form-control" name="section"  value="<?php echo @$lrow['section']; ?>"  placeholder="Section" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Label <span class="font-red required_fld">*</span></label>
                            <div class="col-md-5">
                                <div class="input-icon right">
                                        <i class="fa"></i>
                                    <input class="form-control" name="label"  value="<?php echo @$lrow['label']; ?>"  placeholder="Label" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Name <span class="font-red required_fld">*</span></label>
                            <div class="col-md-5">
                                <div class="input-icon right">
                                        <i class="fa"></i>
                                    <input class="form-control" name="name"  value="<?php echo @$lrow['name']; ?>"  placeholder="Name" type="text">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Issue Raised By <span class="font-red required_fld">*</span></label>
                            <div class="col-md-5">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select class="form-control " name="issue_raised_by">
                                        <option value="">- Select Issue Raised By -</option>
                                        <?php foreach($designation_list as $row) { 
                                            $selected = '';
                                            if($row['block_designation_id'] == @$lrow['issue_raised_by']){ $selected = 'selected'; }?>

                                        <option value="<?php echo $row['block_designation_id']?>" <?php echo $selected; ?>><?php echo $row['name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Issue Closed By <span class="font-red required_fld">*</span></label>
                            <div class="col-md-5">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select class="form-control " name="issue_closed_by">
                                        <option value="">- Select Issue Closed By -</option>
                                        <?php foreach($designation_list as $row) { 
                                            $selected = '';
                                            if($row['block_designation_id'] == @$lrow['issue_closed_by']){ $selected = 'selected'; }?>

                                        <option value="<?php echo $row['block_designation_id']?>" <?php echo $selected; ?>><?php echo $row['name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Table Name </label>
                            <div class="col-md-5">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select class="form-control select2 table_name" name="table_name">
                                        <option value="">- Select Table Name -</option>
                                        <?php foreach($table_list as $row) { 
                                            $selected = '';
                                            if($row['table_name'] == @$lrow['table_name']){ $selected = 'selected'; }?>

                                        <option value="<?php echo $row['table_name']?>" <?php echo $selected; ?>><?php echo $row['table_name']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">Table Primary Column</label>
                            <div class="col-md-5">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select class="form-control  table_primary_column" name="table_primary_column">
                                    <option value="">-Select Table Primary Column-</option>
                                    <?php if($flg==2) { 
                                        foreach($table_column as $row) { 
                                        $selected = '';
                                        if($row['Field'] == @$lrow['table_primary_column']){ $selected = 'selected'; }?>

                                        <option value="<?php echo $row['Field']?>" <?php echo $selected; ?>><?php echo $row['Field']?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">Table Column</label>
                            <div class="col-md-5">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select class="form-control  table_column" name="table_column">
                                    <option value="">-Select Table Column-</option>
                                    <?php if($flg==2) { 
                                        foreach($table_column as $row) { 
                                        $selected = '';
                                        if($row['Field'] == @$lrow['table_column']){ $selected = 'selected'; }?>

                                        <option value="<?php echo $row['Field']?>" <?php echo $selected; ?>><?php echo $row['Field']?></option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            </div>
                        </div>


                          <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-5 col-md-6">
                                    <button type="submit" class="btn blue">Submit</button>
                                    <a href="<?php echo SITE_URL.'reporting_preference';?>" class="btn default">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
                    }
                    if(isset($displayResults)&&$displayResults==1)
                    {
                    ?>
                    <form method="post" action="<?php echo SITE_URL.'reporting_preference'?>">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <select class="form-control select2" name="label">
                                        <option value="">- Select Label -</option>
                                        <?php foreach($label_list as $row) { 
                                            $selected = '';
                                            if($row['rep_preference_id'] == @$search_data['label']){ $selected = 'selected'; }?>

                                        <option value="<?php echo $row['rep_preference_id']?>" <?php echo $selected; ?>><?php echo $row['label']?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-actions">
                                    <button type="submit" name="searchreporting_preference" value="1" class="btn blue"><i class="fa fa-search"></i></button>
                                    <a class="btn blue" href="<?php echo SITE_URL.'add_reporting_preference';?>"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>Section</th>
                                        <th>Name</th>
                                        <th>Raised By</th>
                                        <th>Closed By</th>
                                        <th>Label</th>
                                        <th>Table Name</th>
                                        <th>Table Column</th>
                                        <th> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                if(count($reportingResults)>0){

                                    foreach($reportingResults as $row){
                                ?>
                                    <tr>
                                        <td> <?php echo $sn++;?></td>
                                        <td> <?php echo @$row['section'];?> </td>
                                        <td> <?php echo @$row['name'];?> </td>
                                        <td> <?php echo @$row['issue_raised_by'];?> </td>
                                        <td> <?php echo @$row['issue_closed_by'];?> </td>
                                        <td> <?php echo @$row['label'];?> </td>
                                        <td> <?php echo @$row['table_name'];?> </td>
                                        <td> <?php echo @$row['table_column'];?> </td>
                                        <td>
                                            <a class="btn btn-default btn-xs" href="<?php echo SITE_URL.'edit_reporting_preference/'.cmm_encode($row['rep_preference_id']);?>"><i class="fa fa-pencil"></i></a>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                }
                                else
                                { ?>
                                    <tr><td colspan="6" align="center"> No Records Found </td></tr>
                                <?php }
                                ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-5 col-sm-5">
                                <div class="dataTables_info" role="status" aria-live="polite">
                                    <?php echo @$pagermessage; ?>
                                </div>
                            </div>
                            <div class="col-md-7 col-sm-7">
                                <div class="dataTables_paginate paging_bootstrap_full_number">
                                    <?php echo @$pagination_links; ?>
                                </div>
                            </div>
                        </div> 
                    <?php
                    }
                    ?>
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->

<?php $this->load->view('commons/main_footer', $nestedView); ?>