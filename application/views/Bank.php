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
                        <form class="form-horizontal bank_form" method="post" action="<?php echo $form_action;?>" >
                            <?php
                            if($flg==2){
                                ?>
                                <input type="hidden" name="encoded_id" value="<?php echo cmm_encode($lrow['bank_id']);?>">
                                <?php
                               }
                            ?>
                            <input type="hidden" name="b_id" id="bank_id" value="<?php echo @$lrow['bank_id'] ?>">
                            <div class="alert alert-danger display-hide" style="display: none;">
                               <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                            </div>
                            <div class="form-group">
                        <label class="col-md-3 control-label">Bank Name<span class="font-red required_fld">*</span></label>
                          <div class="col-md-6">
                            <div class="input-icon right">
                              <i class="fa"></i>
                              <input class="form-control" name="bank_name" value="<?php echo @$lrow['bank_name'];?>" id="bankName" placeholder="Bank Name" type="text">
                              <p id="banknameValidating" class="hidden"><i class="fa fa-spinner fa-spin"></i> Checking...</p>
                              <p id="bankError" class="error hidden"></p>
                            </div>
                         </div>
                      </div>
                          <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-6">
                                    <button type="submit" class="btn blue">Submit</button>
                                    <a href="<?php echo SITE_URL.'bank';?>" class="btn default">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php
                    }
                    if(isset($displayResults)&&$displayResults==1)
                    {
                    ?>
                    <form method="post" action="<?php echo SITE_URL.'bank'?>">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input class="form-control" name="bank_name" value="<?php echo @$search_data['bank_name'];?>" placeholder="Bank" type="text">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-actions">
                                    <button type="submit" name="searchbank" value="1" class="btn blue"><i class="fa fa-search"></i></button>
                                    <button type="submit" name="downloadbank" value="1" formaction="<?php echo SITE_URL.'download_bank';?>" class="btn blue"><i class="fa fa-cloud-download"></i></button>
                                    <a class="btn blue" href="<?php echo SITE_URL.'add_bank';?>"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th> Bank</th>
                                        <th> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                if($bankResults){

                                    foreach($bankResults as $row){
                                ?>
                                    <tr>
                                        <td style="width:20%"> <?php echo $sn++;?></td>
                                        <td style="width:50%"> <?php echo @$row['name'];?> </td>
                                        <td style="width:30%">
                                            <a class="btn btn-default btn-xs" href="<?php echo SITE_URL.'edit_bank/'.cmm_encode($row['bank_id']);?>"><i class="fa fa-pencil"></i></a>
                                            <?php
                                            if($row['status']==1){
                                            ?>
                                            <a class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to Deactivate?')" href="<?php echo SITE_URL.'deactivate_bank/'.cmm_encode($row['bank_id']);?>"><i class="fa fa-trash-o"></i></a>
                                            <?php
                                            }
                                            if($row['status']==2){
                                            ?>
                                            <a class="btn btn-info btn-xs" onclick="return confirm('Are you sure you want to Activate?')" href="<?php echo SITE_URL.'activate_bank/'.cmm_encode($row['bank_id']);?>"><i class="fa fa-check"></i></a>
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