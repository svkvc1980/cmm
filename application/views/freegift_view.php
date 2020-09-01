 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <?php
                    if(isset($flg)){
                    ?>
                        <form class="form-horizontal freegift_form" method="post" action="<?php echo $form_action;?>" >
                            <?php
                            if($flg==2){
                                ?>
                                <input type="hidden" name="encoded_id" value="<?php echo cmm_encode($lrow['free_gift_id']);?>">
                                <?php
                               }
                            ?>
                            <input type="hidden" name="freegift_id" id="freegift_id" value="<?php echo @$lrow['free_gift_id'] ?>">
                            <div class="alert alert-danger display-hide" style="display: none;">
                               <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                            </div>
                            <div class="form-group">
                        <label class="col-md-5 control-label"> Free Gift Name<span class="font-red required_fld">*</span></label>
                          <div class="col-md-3">
                            <div class="input-icon right">
                              <i class="fa"></i>
                              <input class="form-control" name="name" value="<?php echo @$lrow['name'];?>" id="freegift" placeholder="Name" type="text">
                              <p id="freegiftnameValidating" class="hidden"><i class="fa fa-spinner fa-spin"></i> Checking...</p>
                              <p id="freegiftError" class="error hidden"></p>
                            </div>
                         </div>
                      </div>
                          <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-5 col-md-6">
                                    <button type="submit" class="btn blue">Submit</button>
                                    <a href="<?php echo SITE_URL.'freegift';?>" class="btn default">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
                    }
                    if(isset($displayResults)&&$displayResults==1)
                    {
                    ?>
                    <form method="post" action="<?php echo SITE_URL.'freegift'?>">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input class="form-control" name="name" value="<?php echo @$search_data['name'];?>" placeholder="Free Gift" type="text">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-actions">
                                    <button type="submit" name="searchfreegift" value="1" class="btn blue"><i class="fa fa-search"></i></button>
                                    <button type="submit" name="downloadfreegift" value="1" formaction="<?php echo SITE_URL.'download_freegift';?>" class="btn blue"><i class="fa fa-cloud-download"></i></button>
                                    <a class="btn blue" href="<?php echo SITE_URL.'add_freegift';?>"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th> Free Gift</th>
                                        <th> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                if($freegiftResults){

                                    foreach($freegiftResults as $row){
                                ?>
                                    <tr>
                                        <td style="width:20%"> <?php echo $sn++;?></td>
                                        <td style="width:50%"> <?php echo @$row['name'];?> </td>
                                        <td style="width:30%">
                                            <a class="btn btn-default btn-xs" href="<?php echo SITE_URL.'edit_freegift/'.cmm_encode($row['free_gift_id']);?>"><i class="fa fa-pencil"></i></a>
                                            <?php
                                            if($row['status']==1){
                                            ?>
                                            <a class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to Deactivate?')" href="<?php echo SITE_URL.'deactivate_freegift/'.cmm_encode($row['free_gift_id']);?>"><i class="fa fa-trash-o"></i></a>
                                            <?php
                                            }
                                            if($row['status']==2){
                                            ?>
                                            <a class="btn btn-info btn-xs" onclick="return confirm('Are you sure you want to Activate?')" href="<?php echo SITE_URL.'activate_freegift/'.cmm_encode($row['free_gift_id']);?>"><i class="fa fa-check"></i></a>
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