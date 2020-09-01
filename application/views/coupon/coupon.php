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
                        <form class="form-horizontal" id="coupon_form" method="post" action="<?php echo $form_action;?>" >
                            <?php
                            if($flg==2){
                                ?>
                                <input type="hidden" name="encoded_id" value="<?php echo cmm_encode($lrow['coupon_id']);?>">
                                <?php
                               }
                            ?>
                            <input type="hidden" name="coupon_id" id="coupon_id" value="<?php echo @$lrow['coupon_id'] ?>">
                            <div class="alert alert-danger display-hide" style="display: none;">
                               <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                            </div>
                            <div class="form-group">
                                <label class="col-md-5 control-label"> Name<span class="font-red required_fld">*</span></label>
                                <div class="col-md-3">
                                    <div class="input-icon right">
                                    <i class="fa"></i>
                                        <input type="text" required name="name" value="<?php echo @$lrow['name'];?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-5 control-label"> No of Cartons<span class="font-red required_fld">*</span></label>
                                <div class="col-md-3">
                                    <div class="input-icon right">
                                    <i class="fa"></i>
                                        <input type="text" required name="no_of_cartons" value="<?php echo @$lrow['no_of_cartons'];?>" class="form-control numeric">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-5 control-label"> Start Date<span class="font-red required_fld">*</span></label>
                                <div class="col-md-3">
                                    <div class="input-icon right">
                                      <i class="fa"></i>
                                      <input type="text" required name="start_date"  <?php if(@$lrow['start_date']) { ?> value="<?php echo date('d-m-Y',strtotime(@$lrow['start_date']));?>" <?php } ?> class="form-control date-picker">
                                    </div>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-md-5 control-label"> End Date<span class="font-red required_fld">*</span></label>
                                <div class="col-md-3">
                                    <div class="input-icon right">
                                      <i class="fa"></i>
                                      <input type="text" required name="end_date" <?php if(@$lrow['end_date']) { ?> value="<?php echo date('d-m-Y',strtotime(@$lrow['end_date']));?>" <?php } ?>  class="form-control date-picker">
                                    </div>
                                </div>
                            </div>
                             <div class="form-group">
                                <label class="col-md-5 control-label"> Amount<span class="font-red required_fld">*</span></label>
                                <div class="col-md-3">
                                    <div class="input-icon right">
                                      <i class="fa"></i>
                                      <input type="text" required name="amount" value="<?php echo @$lrow['amount'];?>" class="form-control numeric">
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-5 col-md-6">
                                        <button type="submit" class="btn blue">Submit</button>
                                        <a href="<?php echo SITE_URL.'coupon';?>" class="btn default">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    <?php
                    }
                    if(isset($displayResults)&&$displayResults==1)
                    {
                    ?>
                    <form method="post" action="<?php echo SITE_URL.'coupon'?>">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="text" name="name" value="<?php echo @$search_params['name'];?>" id="" class="form-control" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group date-picker input-daterange " data-date-format="dd-mm-yyyy">
                                    <input class="form-control" name="start_date"  placeholder="Start Date" type="text" value="<?php if(@$search_Params['start_date']!=''){ echo @date('d-m-Y',strtotime($search_Params['start_date'])); }?>" >
                                    <span class="input-group-addon"> to </span>
                                        <input class="form-control " name="end_date" placeholder="End Date" type="text" value="<?php if(@$search_Params['end_date']!=''){ echo @date('d-m-Y',strtotime($search_Params['end_date'])); }?>">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-actions">
                                    <button type="submit" name="search_coupon" value="1" class="btn blue"><i class="fa fa-search"></i></button>
                                    <a class="btn blue tooltips" href="<?php echo SITE_URL.'coupon';?>" data-original-title="Refresh"> <i class="fa fa-refresh"></i></a>
                                    <button type="submit" name="download_coupon" value="1" formaction="<?php echo SITE_URL.'download_coupon';?>" class="btn blue"><i class="fa fa-cloud-download"></i></button>
                                    <a class="btn blue" href="<?php echo SITE_URL.'add_coupon';?>"><i class="fa fa-plus"></i></a>
                                </div>
                            </div>
                        </div>
                    </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th> Name</th>
                                        <th> No of Cartons</th>
                                        <th> Start Date</th>
                                        <th> End Date</th>
                                        <th> Amount</th>
                                        <th> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($coupon)
                                {
                                    foreach($coupon as $row){
                                ?>
                                    <tr>
                                        <td> <?php echo $sn++;?></td>
                                        <td> <?php echo $row['name'];?> </td>
                                        <td> <?php echo $row['no_of_cartons'];?> </td>
                                        <td> <?php echo date('d-m-Y',strtotime($row['start_date']));?> </td>
                                        <td> <?php echo date('d-m-Y',strtotime($row['end_date']));?> </td>
                                        <td> <?php echo $row['amount'];?> </td>
                                        <td>
                                            <a class="btn btn-default btn-xs" href="<?php echo SITE_URL.'edit_coupon/'.cmm_encode($row['coupon_id']);?>"><i class="fa fa-pencil"></i></a>
                                            <?php
                                            if($row['status']==1){
                                            ?>
                                            <a class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to Deactivate?')" href="<?php echo SITE_URL.'deactivate_coupon/'.cmm_encode($row['coupon_id']);?>"><i class="fa fa-trash-o"></i></a>
                                            <?php
                                            }
                                            if($row['status']==2){
                                            ?>
                                            <a class="btn btn-info btn-xs" onclick="return confirm('Are you sure you want to Activate?')" href="<?php echo SITE_URL.'activate_coupon/'.cmm_encode($row['coupon_id']);?>"><i class="fa fa-check"></i></a>
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