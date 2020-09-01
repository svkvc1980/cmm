 <!--  created by maruthi 6th Dec 2016 11:00 AM -->
 <?php $this->load->view('commons/main_template', $nestedView);?>
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
                            <form id="state_form" method="post" action="<?php echo SITE_URL; ?>location_add" class="form-horizontal">
                                <input type="hidden" name="location_id"  value="<?php echo @$state_edit[0]['location_id']?>">
                                <input type="hidden" name="level_id" value="<?php echo @$level_id ?>">
                                <input type="hidden" name="parent"  value="<?php echo @$parent_id ?>">       
   
                                <div class="alert alert-danger display-hide" style="display: none;">
                                   <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">State <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control" name="name" id="state_name" value="<?php echo @$state_edit[0]['name'];?>" placeholder="State" type="text">
                                            <p id="statenameValidating" class="hidden"><i class="fa fa-spinner fa-spin"></i> Checking...</p>
                                            <p id="stateError" class="error hidden"></p>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-6">
                                            <button type="submit" value="1" name="submit_location" class="btn blue">Submit</button>
                                            <a href="<?php echo SITE_URL.'state';?>" class="btn default">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php
                    }
                    if(isset($display_results)&&$display_results==1)
                    {
                    ?>
                        <form method="post" action="<?php echo SITE_URL.'state'?>">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input class="form-control" name="state_name" value="<?php echo @$search_data['state_name'];?>" placeholder="State" type="text">
                                    </div>
                                </div>                         
                                <div class="col-sm-3">
                                    <div class="form-actions">
                                        <button type="submit" name="search_state" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search" ><i class="fa fa-search"></i></button>
                                        <a  class="btn blue tooltips" href="<?php echo SITE_URL.'state';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>

                                        <a href="<?php echo SITE_URL.'add_state';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th> State </th>
                                        <th> Actions </th>            
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                if(count($state_results)>0){

                                    foreach(@$state_results as $row){
                                ?>
                                    <tr>
                                        <td> <?php echo @$sn++;?></td>
                                        <td> <?php echo @$row['name'];?> </td>
                                        <td>
                                            <a  href="<?php echo SITE_URL.'edit_state/'.eip_encode(@$row['location_id']);?>" class="btn btn-default btn-circle btn-sm tooltips" data-container="body" data-placement="top" data-original-title="Edit Details"><i class="fa fa-pencil"></i></a>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                }
                                else
                                { ?>
                                    <tr><td colspan="7" align="center">-No Records Found-</td></tr>
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