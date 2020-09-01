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
                        <form class="form-horizontal" method="post" action="<?php echo $form_action;?>" >
                        <input type="hidden" name="encoded_id" value="<?php echo cmm_encode($approval_info['approval_id']);?>">
                        <div class="row">
                            <div class="col-md-offset-1 col-md-10">
                                <div class="portlet box green">
                                    <div class="portlet-title">
                                        <div class="caption">
                                            <i class="fa fa-bank"></i>Verified By Details</div>
                                        <div class="tools">
                                            <a href="javascript:;" class="expand" data-original-title="" title=""> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body" style="display: none;"> 

                                          <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th> S.No</th>
                                                    <th>User</th>
                                                    <th>Remarks </th> 
                                                    <th>Date</th>            
                                                </tr>
                                            </thead>
                                            <tbody >
                                                <?php $sn=1; 
                                                foreach($approval_hist_info as $row)
                                                { ?>
                                                    <tr>
                                                        <td> <?php echo $sn++;?></td>
                                                        <td> <?php echo $row['created_name'].' / '.$row['issued_by'];?> </td>
                                                        <td> <?php echo $row['remarks'];?> </td>
                                                        <td> <?php echo format_date($row['created_time']);?> </td>
                                                    </tr><?php
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div> 
                                </div>
                            </div>  
                        </div>
                        <div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Issue <span class="font-red required_fld">*</span></label>
                                <div class="col-md-7">
                                    <p class="form-control-static"><b><?php echo $approval_info['name']; ?></b></p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Remarks <span class="font-red required_fld">*</span></label>
                                <div class="col-md-7">
                                    <textarea class="form-control" name="remarks" required></textarea>
                                </div>
                            </div>

                        </div>
                        <div class="form-actions">
                            <div class="row" style="text-align: center;">
                                <div class="col-md-offset-3 col-md-6">
                                    <button type="submit" value="1" name ="submit" onclick="return confirm('Are you sure you want to Approve?')"  class="btn btn-primary">Approval</button>
                                    <button type="submit"  value="2" onclick="return confirm('Are you sure you want to Reject?')"name ="submit" class="btn btn-danger remarks">Reject</button>
                                    <a href="<?php echo SITE_URL.'approval_list';?>" class="btn default">Cancel</a>
                                </div>
                            </div>  
                        </div>
                    </form>
                    <?php
                    }
                    if(isset($displayResults)&&$displayResults==1)
                    {
                    ?>
                    <form method="post" action="<?php echo SITE_URL.'approval_list'?>">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input class="form-control" name="approval_number" value="<?php echo @$search_data['approval_number'];?>" placeholder="Approval Number" type="text">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <div class="input-group input-large date-picker input-daterange" data-date-format="dd-mm-yyyy">
                                       <input type="text" class="form-control" name="from_date" placeholder="From Date" value="<?php if($search_data['from_date']!='') { echo date('d-m-Y',strtotime($search_data['from_date'])); } ?>">
                                       <span class="input-group-addon"> to </span>
                                       <input type="text" class="form-control" name="to_date" placeholder="To Date" value="<?php if($search_data['to_date']!='') { echo date('d-m-Y',strtotime($search_data['to_date'])); } ?>"> 
                                    </div>
                                </div>
                            </div>
                             <div class="col-sm-4">
                                <div class="form-group">
                                   <select class="form-control " name="label" >
                                        <option value="">-Select Type- </option>
                                        <?php
                                        foreach($label_list as $label)
                                        {  
                                            $selected = "";
                                            if($label['rep_preference_id'] == $search_data['label']){ $selected = "selected"; }
                                            echo '<option value="'.$label['rep_preference_id'].'" '.$selected.'>'.$label['label'].'</option>';
                                        }?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                   <select class="form-control " name="issue_at" >
                                        <option value="">-Select Issue At- </option>
                                        <?php
                                        foreach($designation_list as $desig)
                                        {  
                                            $selected = "";
                                            if($desig['block_designation_id'] == $search_data['issue_at']){ $selected = "selected"; }
                                            echo '<option value="'.$desig['block_designation_id'].'" '.$selected.'>'.$desig['name'].'</option>';
                                        }?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <select name="status" class="form-control" >
                                        <option value="">Select Status</option>
                                        <option value="1" <?php if(@$search_data['status']==1){?>selected <?php } ?> >Pending</option>
                                        <option value="2" <?php if(@$search_data['status']==2){?>selected <?php } ?> >Approved</option>
                                        <option value="3" <?php if(@$search_data['status']==3){?>selected <?php } ?>>Rejected</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-actions">
                                    <button type="submit" name="searchapproval" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search" ></i></button>
                                    <button name="reset" href="<?php echo SITE_URL.'approval_list';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="reset"><i class="fa fa-refresh"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th>Approval Number</th>
                                        <th> Type </th>
                                        <th>Purpose</th>
                                        <th width="8%"> Date </th>
                                        <th> Issue At</th>
                                        <th> Action </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                if(count($approvalResults)>0){

                                    foreach($approvalResults as $row){
                                ?>
                                    <tr>
                                        <td> <?php echo $sn++;?></td>
                                        <td> <?php echo $row['approval_number'];?> </td>
                                        <td> <?php echo $row['label'];?> </td>
                                        <td> <?php echo $row['name'];?> </td>
                                        <td> <?php echo format_date($row['created_time']);?> </td>
                                        <td> <?php echo $row['issue_name'];?> </td>
                                        <td>
                                            
                                            <?php
                                            if($row['status']==1 && $row['issue_at']==$this->session->userdata('block_designation_id')){
                                            ?>
                                            <a class="btn btn-default btn-xs tooltips" href="<?php echo SITE_URL.'view_approval_information/'.cmm_encode($row['approval_id']);?>"  data-container="body" data-placement="top" data-original-title="View Info"><i class="fa fa-pencil"></i></a>
                                            <?php
                                            }
                                            if($row['status']==1 && $row['issue_at']!=$this->session->userdata('block_designation_id'))
                                            { ?>
                                                <p style="color: orange;text-align: center;" class="tooltips" data-container="body" data-placement="top" data-original-title="Pending"><b><i class="fa fa-exclamation-triangle fa-lg"></i></b></p> 
                                            <?php }
                                            if($row['status']==2){
                                            ?>
                                            <p style="color: green;text-align: center;" class="tooltips" data-container="body" data-placement="top" data-original-title="Approved"><b><i class="fa fa-check fa-lg"></i></b></p> 
                                            <?php
                                            }
                                            if($row['status']==3){
                                            ?>
                                            <p style="color: red;text-align: center;" class="tooltips" data-container="body" data-placement="top" data-original-title="Rejected"><b><i class="fa fa-times fa-lg"></i></b></p> 
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
                                    <tr><td colspan="7" align="center"> No Records Found </td></tr>
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