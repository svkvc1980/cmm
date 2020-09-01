 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
              <div class="portlet-body">
                    <?php
                    if(isset($flag))
                    {
                    ?>
                    <form id="broker_form" method="post" action="<?php echo $form_action;?>"  autocomplete="on" class="form-horizontal">
                        <?php
                        if($flag==2){
                            ?>
                             <input type="hidden" name="reportee_id" value="<?php echo cmm_encode($designation_row['reportee_id']);?>">
                             <input type="hidden" name="reporting_id" value="<?php echo cmm_encode($designation_row['reporting_id']) ;?>">
                            <?php
                        }
                        ?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Reportee Designation <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <select class="form-control"  name="reportee_designation" required >
                                            <option value="">Select Designation</option>
                                            <?php
                                              foreach($designation as $row)
                                              {
                                                $selected = "";
                                                if($row['block_designation_id']== @$reportee_id)
                                                { 
                                                    $selected='selected';
                                                }
                                              echo '<option value="'.@$row['block_designation_id'].'" '.$selected.'>'.@$row['name'].' ( '.$row['block_name'].' )'. '</option>';
                                              }
                                              ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Reporting Designation <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <select class="form-control"  name="reporting_designation" required >
                                            <option value="">Select Designation</option>
                                            <?php
                                              foreach($designation as $row)
                                              {
                                                $selected = "";
                                                if($row['block_designation_id']== @$reporting_id)
                                                { 
                                                    $selected='selected';
                                                }
                                              echo '<option value="'.@$row['block_designation_id'].'" '.$selected.'>'.@$row['name'].' ( '.$row['block_name'].' )'. '</option>';
                                              }
                                              ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-5 col-md-6">
                                    <button type="submit" class="btn blue">Submit</button>
                                    <a href="<?php echo SITE_URL.'reportee_designation';?>" class="btn default">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
                    }
                    if(isset($display_results)&&$display_results==1)
                    {
                    ?>
                        <form method="post" action="<?php echo SITE_URL.'reportee_designation'?>">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <select class="form-control"  name="reportee_id" required >
                                            <option value="">Select Reportee Designation</option>
                                            <?php
                                              foreach($designation as $row)
                                              {
                                                $selected = "";
                                                if($row['block_designation_id']== @$search_data['reportee_id'])
                                                { 
                                                    $selected='selected';
                                                }
                                              echo '<option value="'.@$row['block_designation_id'].'" '.$selected.' >'.@$row['name'].' ( '.$row['block_name'].' )'. '</option>';
                                              }
                                              ?>
                                        </select>
                                    </div>
                                </div>
                                  <div class="col-sm-3">
                                    <div class="form-group">
                                       <select class="form-control"  name="reporting_id" required >
                                            <option value="">Select Reporting Designation</option>
                                            <?php
                                              foreach($designation as $row)
                                              {
                                                $selected = "";
                                                if($row['block_designation_id']== @$search_data['reporting_id'])
                                                { 
                                                    $selected='selected';
                                                }
                                              echo '<option value="'.@$row['block_designation_id'].'" '.$selected.' >'.@$row['name'].' ( '.$row['block_name'].' )'. '</option>';
                                              }
                                              ?>
                                        </select>
                                    </div>
                                 </div>
                                   <div class="col-sm-4">
                                     <div class="form-actions">
                                        <button type="submit" name="search_designation" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                        <button type="submit" name="download_designation" value="1" formaction="<?php echo SITE_URL.'download_reportee_designation';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
                                        <a  class="btn blue tooltips" href="<?php echo SITE_URL.'reportee_designation';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
                                        <a href="<?php echo SITE_URL.'add_reportee_designation';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                        
                                    </div>
                                </div>
                            </div>
                        </form>
                           <div class="table-scrollable">
                             <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th> Reportee Designation </th>
                                        <th> Reporting Designation </th>
                                        <th> Actions </th>            
                                    </tr>
                                </thead>
                                  <tbody>
                                     <?php

                                     if(count($reporting_manager_results)>0){

                                    foreach($reporting_manager_results as $row){
                                     ?>
                                     <tr>
                                        <td> <?php echo $sn++;?></td>
                                        <td> <?php echo $row['reportee_name'].' ( '.$row['block_name'].' )';?> </td>
                                        <td> <?php echo $row['reporting_name'].' ( '.$row['block_name'].' )';?> </td>
                                        <td>
                                            <a class="btn btn-default btn-xs tooltips" href="<?php echo SITE_URL.'edit_reportee_designation/'.cmm_encode($row['reportee_id']).'/'.cmm_encode($row['reporting_id']);?>"  data-container="body" data-placement="top" data-original-title="Edit Details"><i class="fa fa-pencil"></i></a>
                                            
                                        </td>
                                    </tr>
                                <?php
                                    }
                                }
                                else
                                {
                            ?>      <tr><td colspan="6" align="center"> No Records Found</td></tr>      
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