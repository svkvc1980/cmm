 <?php 
// created by maruthi 15th Nov 2016 11:00 AM
 $this->load->view('commons/main_template', $nestedView);
  ?>
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
                            <form id="location_form" method="post" action="<?php echo SITE_URL; ?>location_add" class="form-horizontal">
                                <input type="hidden" name="location_id" value="<?php echo @$mandal_edit[0]['location_id']?>">
                                <input type="hidden" name="level_id" value="<?php echo @$level_id ?>">
                                <input type="hidden" name="edit_parent_id" value="<?php echo @$parentInfo['location_id'] ?>">
                                
                                <div class="alert alert-danger display-hide" style="display: none;">
                                   <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                                </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">District <span class="font-red required_fld">*</span></label>
                                        <div class="col-md-6">
                                            <?php @$readonly=(@$val==1)?'disabled':'';?>
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <select class="form-control" id="parent_id" name="parent" <?php echo @$readonly;?> >
                                                    <option value="">Select District</option>
                                                    <?php
                                                      foreach(@$district_details as $row)
                                                      {
                                                      $selected = (@$row['location_id']==@$parentInfo['location_id'])?'selected="selected"':'';
                                                      echo '<option value="'.@$row['location_id'].'"  '.$selected.'>'.@$row['name'].'</option>';
                                                      }
                                                      ?>
                                                </select>
                                           </div>     
                                        </div>
                                    </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Mandal <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <?php if(@$flg==2)
                                            {?>
                                            <input class="form-control" name="name" id="name"  value="<?php echo @$mandal_edit[0]['name'];?>" placeholder="Mandal" type="text">
                                            <p id="locationnameValidating" class="hidden"><i class="fa fa-spinner fa-spin"></i> Checking...</p>
                                            <p id="locationError" class="error hidden"></p>
                                            <?php }
                                            else
                                            { ?>
                                            <input class="form-control" name="name" id="name" readonly="readonly" value="<?php echo @$mandal_edit[0]['name'];?>" placeholder="Mandal" type="text">
                                            <p id="locationnameValidating" class="hidden"><i class="fa fa-spinner fa-spin"></i> Checking...</p>
                                            <p id="locationError" class="error hidden"></p>
                                            <?php  } ?>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-6">
                                            <button type="submit" value="1" name="submit_location" class="btn blue">Submit</button>
                                            <a href="<?php echo SITE_URL.'mandal';?>" class="btn default">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php
                    }
                    if(isset($display_results)&&$display_results==1)
                    {
                    ?>
                        <form method="post" action="<?php echo SITE_URL.'mandal'?>">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <select class="form-control"  id="region_id" name="region">
                                            <option value="">Select Region</option>
                                            <?php
                                              foreach(get_regions() as $row)
                                              {
                                              $selected = (@$row['location_id']==@$searchParams['region_id'])?'selected="selected"':'';
                                              echo '<option value="'.@$row['location_id'].'"  '.$selected.'>'.@$row['name'].'</option>';
                                              }
                                              ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <select class="form-control" id="district_id" name="district">
                                            <option value="">Select District</option>
                                           <?php
                                            if(@$searchParams['district_id']!=''){
                                                foreach ($districts as $row) {
                                                    $sselected = ($row['location_id']==@$searchParams['district_id'])?'selected':'';
                                                    echo '<option value="'.$row['location_id'].'" '.$sselected.'>'.$row['name'].'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input class="form-control" name="mandal_name" value="<?php echo @$searchParams['mandal_name'];?>" placeholder="Mandal" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-actions">
                                        <button type="submit" name="search_mandal" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search" ><i class="fa fa-search"></i></button>
                                        <a  class="btn blue tooltips" href="<?php echo SITE_URL.'mandal';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
                                        <a href="<?php echo SITE_URL.'add_mandal';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th> Region </th>
                                        <th> District </th>
                                        <th> Mandal </th>
                                        <th> Actions </th>            
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                if(count($mandal_details)>0){

                                    foreach(@$mandal_details as $row){
                                ?>
                                    <tr>
                                        <td> <?php echo @$sn++;?></td>
                                        <td> <?php echo @$row['region_name'];?> </td>
                                        <td> <?php echo @$row['district_name'];?> </td>
                                        <td> <?php echo @$row['name'];?> </td>

                                        <td>
                                            <a  href="<?php echo SITE_URL.'edit_mandal/'.eip_encode(@$row['location_id']);?>" class="btn btn-default btn-circle btn-sm tooltips" data-container="body" data-placement="top" data-original-title="Edit Details"><i class="fa fa-pencil"></i></a>
                                            
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
<script type="text/javascript">
$(document).on("change","#region_id",function() {     
    $.ajax({
        type: "POST",
        url: SITE_URL+"Ajax_ci/ajax_get_districts_by_region_id",
        data:'region_id='+$(this).val(),        
        success: function(data){        
        $("#district_id").html(data);
        $(this).focus();        
    }
    });
    
});
</script>