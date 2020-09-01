 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <?php
                    if(isset($flg))
                    {
                        ?>
                            <form id="designation_form" method="post" action="<?php echo $form_action;?>" class="form-horizontal">
                                <?php
                                if($flg==2){
                                    ?>
                                    <input type="hidden" name="encoded_id" value="<?php echo cmm_encode($designation_row['designation_id']);?>">
                                    <input type="hidden" name="desig_id" id="designation_id" value="<?php echo $designation_row['designation_id']; ?>">
                                    <?php
                                }
                                ?>
                                <input type="hidden" id="designation_id" name="en" value="<?php echo @$designation_row['designtion_id'] ?>">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Designation Name <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-3">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control" name="designation_name" id="designation_name" value="<?php echo @$designation_row['name'];?>" placeholder="Description" type="text">
                                            <p id="designation_nameValidating" class="hidden"><i class="fa fa-spinner fa-spin"></i> Checking...</p>
                                            <p id="designationError" class="error hidden"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Description </label>
                                    <div class="col-md-3">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <textarea   id="agency" class=" form-control" style="height:30px;"  name="description"><?php echo @$designation_row['description'];?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Block<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                       <?php 
                                            foreach($block as $key => $value)
                                            {
                                                $checked = in_array($key,@$blockselected)?'checked':'';
                                                ?>
                                                <input type="checkbox" <?php echo $checked; ?> name="block_type[]" value="<?php echo $key?>">
                                                <label class="control-label"><?php echo $value;?></label> <br/>
                                                
                                            <?php
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-6">
                                            <button type="submit" value="1" class="btn blue">Submit</button>
                                            <a href="<?php echo SITE_URL.'designation';?>" class="btn default">Cancel</a>
                                        </div>
                                    </div>  
                                </div>
                            </form>
                        <?php
                    }
                    if(isset($display_results)&&$display_results==1)
                    {
                    ?>
                        <form method="post" action="<?php echo SITE_URL.'designation'?>">
                            <div class="row">
                               <div class="col-sm-3">
                                    <div class="form-group">
                                        <input class="form-control" name="desig_name" value="<?php echo @$search_data['name'];?>" placeholder="Designation" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-actions">
                                        <button type="submit" name="search_designation" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                        <button type="submit" name="download_designation" value="1" formaction="<?php echo SITE_URL.'download_designation';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
                                        <a  class="btn blue tooltips" href="<?php echo SITE_URL.'designation';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
                                        <a href="<?php echo SITE_URL.'add_designation';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th> Designation </th>
                                        <th> Block Name </th>
                                        <th style="width:15%"> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                if($designation_results){

                                    foreach($designation_results as $row){
                                ?>
                                    <tr>
                                            <td> <?php echo $sn++;?></td>
                                            <td> <?php echo $row['name'];?> </td>
                                            <td><?php echo $row['block_name']; ?></td>
                                            <td>
                                                <a class="btn btn-default btn-xs tooltips" href="<?php echo SITE_URL.'edit_designation/'.cmm_encode($row['designation_id']);?>"  data-container="body" data-placement="top" data-original-title="Edit Details"><i class="fa fa-pencil"></i></a>
                                                <?php
                                                if($row['status']==1){
                                                ?>
                                                <a class="btn btn-danger btn-xs tooltips"  onclick="return confirm('Are you sure you want to Deactivate?')" href="<?php echo SITE_URL.'deactivate_designation/'.cmm_encode($row['designation_id']);?>" data-container="body" data-placement="top" data-original-title="DeActivate"><i class="fa fa-trash-o"></i></a>
                                                <?php
                                                }
                                                if($row['status']==2){
                                                ?>
                                                <a class="btn btn-info btn-xs tooltips"  onclick="return confirm('Are you sure you want to Activate?')" href="<?php echo SITE_URL.'activate_designation/'.cmm_encode($row['designation_id']);?>" data-container="body" data-placement="top" data-original-title="Activate"><i class="fa fa-check"></i></a>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }
                                else
                                {
                            ?>      <tr><td colspan="4" align="center"> No Records Found</td></tr>      
                        <?php   }
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