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
                            <form id="icds_form" method="post" action="<?php echo $form_action;?>" class="form-horizontal">
                                <?php
                                if($flg==2){
                                    ?>
                                    <input type="hidden" name="encoded_id" value="<?php echo cmm_encode($icds_row['icds_id']);?>">
                                    <?php
                                }
                                ?>
                                <div class="alert alert-danger display-hide" style="display: none;">
                                   <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Icds Code <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control" name="icds_code" value="<?php echo @$icds_row['icds_code'];?>" placeholder="icds code" type="text" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Icds Name <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control" name="icds_name" value="<?php echo @$icds_row['icds_name'];?>" placeholder="Icds Name" type="text" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Marketing Exe Code <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control" name="mrkexe_code" value="<?php echo @$icds_row['mrkexe_code'];?>" placeholder="MarketingExe Code" type="text" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Mobile Number <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control" name="ph_num" value="<?php echo @$icds_row['ph_num'];?>" placeholder="Mobile Number" type="text" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-6">
                                            <button type="submit" value="1" class="btn blue">Submit</button>
                                            <a href="<?php echo SITE_URL.'icds';?>" class="btn default">Cancel</a>
                                        </div>
                                    </div>  
                                </div>
                            </form>
                        <?php
                    }
                    if(isset($display_results)&&$display_results==1)
                    {
                    ?>
                        <form method="post" action="<?php echo SITE_URL.'icds'?>">
                            <div class="row">
                                
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input class="form-control" name="icds_code" value="<?php echo @$search_data['icds_code'];?>" placeholder="Icds Code" type="text">
                                    </div>
                                </div><div class="col-sm-3">
                                    <div class="form-group">
                                        <input class="form-control" name="icds_name" value="<?php echo @$search_data['icds_name'];?>" placeholder="Icds Name" type="text">
                                    </div>
                                </div>
                                
                                
                                <div class="col-sm-4">
                                    <div class="form-actions">
                                        <button type="submit" name="search_icds" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                        <button type="submit" name="download_icds" value="1" formaction="<?php echo SITE_URL.'download_icds';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button> 
                                        <a href="<?php echo SITE_URL.'add_icds';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                        <!-- <a  class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Upload "  href="<?php echo SITE_URL.'bulkupload_icds';?>"  ><i class="fa fa-cloud-upload"></i> </a>
                                        <button type="submit" name="download_broker_template" value="1" formaction="<?php echo SITE_URL.'download_icds_template';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download Sample Template To upload "><i class="fa fa-cloud-download"></i></button> -->
                                        
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th> Icds Code </th>
                                        <th> Icds Name </th>
                                        <th> MarketingExe Code </th> 
                                        <th> Mobile Number </th> 
                                        <th> Actions </th>          
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                if($icds_results){

                                    foreach($icds_results as $row){
                                ?>
                                    <tr>
                                        <td> <?php echo $sn++;?></td>
                                        <td> <?php echo $row['icds_code'];?> </td>
                                        <td> <?php echo $row['icds_name'];?> </td>
                                        <td> <?php echo $row['mrkexe_code'];?> </td>
                                        <td> <?php echo $row['ph_num'];?> </td>
                                        <td>   
                                            <a class="btn btn-default btn-xs tooltips" href="<?php echo SITE_URL.'edit_icds/'.cmm_encode($row['icds_id']);?>"  data-container="body" data-placement="top" data-original-title="Edit Details"><i class="fa fa-pencil"></i></a>
                                             <?php
                                            if($row['status']==1){
                                            ?>
                                            <a class="btn btn-danger btn-xs"  onclick="return confirm('Are you sure you want to Deactivate?')" href="<?php echo SITE_URL.'deactivate_icds/'.cmm_encode($row['icds_id']);?>"><i class="fa fa-trash-o"></i></a>
                                            <?php
                                            }
                                            if($row['status']==2){
                                            ?>
                                            <a class="btn btn-info btn-xs"  onclick="return confirm('Are you sure you want to Activate?')" href="<?php echo SITE_URL.'activate_icds/'.cmm_encode($row['icds_id']);?>"><i class="fa fa-check"></i></a>
                                            <?php
                                            }
                                            ?>
                                            
                                        </td>
                                    </tr>
                                <?php
                                    }
                                }
                                    else
                                    { ?>
                                    <tr><td colspan='6' align="center">-No Records Found-</td></tr>
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
