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
                            <form id="oil_tank_form" method="post" action="<?php echo $form_action;?>" class="form-horizontal">
                                <?php
                                if($flg==2){
                                    ?>
                                    <input type="hidden" name="encoded_id" value="<?php echo cmm_encode($oil_tanker_row['oil_tank_id']);?>">
                                    <?php
                                }
                                ?>
                                <input type="hidden" id="tank_id" name="en" value="<?php echo @$oil_tanker_row['oil_tank_id'] ?>">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">OPS<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                       <select  id="ops_id" name="ops" class="form-control"> 
                                            <option value="">Select Ops</option>
                                            <option value="1" <?php if(@$oil_tanker_row['ops_id']==1) {?> selected <?php } ?> >Vijayawada</option>
                                            <option value="2" <?php if(@$oil_tanker_row['ops_id']==2) {?> selected <?php } ?> >Kakinada</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Oil Tank Name <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control" name="oil_tank" id="tank_name" value="<?php echo @$oil_tanker_row['oil_tank_name'];?>" placeholder="Tank Name" type="text">
                                            <p id="tank_nameValidating" class="hidden"><i class="fa fa-spinner fa-spin"></i> Checking...</p>
                                            <p id="tankError" class="error hidden"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Oil Tanker Capacity <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control" name="tank_capacity" id="tank_name" value="<?php echo @$oil_tanker_row['oil_tank_capacity'];?>" placeholder="Tank Capacity" type="text">
                                            
                                        </div>
                                    </div>
                                </div>
                               <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-6">
                                            <button type="submit" value="1" class="btn blue">Submit</button>
                                            <a href="<?php echo SITE_URL.'oil_tanker';?>" class="btn default">Cancel</a>
                                        </div>
                                    </div>  
                                </div>
                            </form>
                        <?php
                    }
                    if(isset($display_results)&&$display_results==1)
                    {
                    ?>
                        <form method="post" action="<?php echo SITE_URL.'oil_tanker'?>">
                            <div class="row">
                               <div class="col-sm-3">
                                    <div class="form-group">
                                        <input class="form-control" name="oil_tank_name" value="<?php echo @$search_data['oil_tank_name'];?>" placeholder="Oil Tank Name" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-actions">
                                        <button type="submit" name="search_oil_tanker" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                        <button type="submit" name="download_oil_tanker" value="1" formaction="<?php echo SITE_URL.'download_oil_tanker';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
                                        <a href="<?php echo SITE_URL.'add_oil_tanker';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th> Oil Tank Name </th>
                                        <th> OPS </th>
                                        <th>Oil Tank Capacity</th>
                                        <th style="width:15%"> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                if($oil_tanker_results){

                                    foreach($oil_tanker_results as $row){
                                ?>
                                    <tr>
                                        <td> <?php echo $sn++;?></td>
                                        <td> <?php echo $row['oil_tank_name'];?> </td>
                                        <td> <?php  if($row['ops_id']==1)
                                                    {
                                                        echo 'Vijayawada';
                                                    }
                                                    else if($row['ops_id']==2)
                                                    {
                                                        echo 'Kakinada';
                                                    }
                                                    ?>
                                        </td>
                                        <td> <?php echo $row['oil_tank_capacity'];?> </td>
                                        <td>
                                            <a class="btn btn-default btn-xs tooltips" href="<?php echo SITE_URL.'edit_oil_tanker/'.cmm_encode($row['oil_tank_id']);?>"  data-container="body" data-placement="top" data-original-title="Edit Details"><i class="fa fa-pencil"></i></a>
                                            <?php
                                            if($row['status']==1){
                                            ?>
                                            <a class="btn btn-danger btn-xs tooltips"  onclick="return confirm('Are you sure you want to Deactivate?')" href="<?php echo SITE_URL.'deactivate_oil_tanker/'.cmm_encode($row['oil_tank_id']);?>" data-container="body" data-placement="top" data-original-title="DeActivate"><i class="fa fa-trash-o"></i></a>
                                            <?php
                                            }
                                            if($row['status']==2){
                                            ?>
                                            <a class="btn btn-info btn-xs tooltips"  onclick="return confirm('Are you sure you want to Activate?')" href="<?php echo SITE_URL.'activate_oil_tanker/'.cmm_encode($row['oil_tank_id']);?>" data-container="body" data-placement="top" data-original-title="Activate"><i class="fa fa-check"></i></a>
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