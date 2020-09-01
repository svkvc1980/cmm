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
                            <form id="loose_oil_form" method="post" action="<?php echo $form_action;?>" class="form-horizontal">
                                <?php
                                if($flg==2){
                                    ?>
                                    <input type="hidden" name="encoded_id" value="<?php echo cmm_encode($loose_oil_row['loose_oil_id']);?>">
                                    <?php
                                }
                                ?>
                                <input type="hidden" id="loose_oil_id" name="looseoilid" value="<?php echo @$loose_oil_row['loose_oil_id'] ?>">

                                <div class="alert alert-danger display-hide" style="display: none;">
                                   <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                                </div>
                                 <div class="form-group">
                                    <label class="col-md-3 control-label">Loose Oil Name <span class="font-red required_fld">*</span></label>
                                      <div class="col-md-6">
                                        <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input class="form-control" name="name" value="<?php echo @$loose_oil_row['name'];?>" id="looseoilName" placeholder="name" type="text">
                                          <p id="looseoilnameValidating" class="hidden"><i class="fa fa-spinner fa-spin"></i> Checking...</p>
                                          <p id="looseoilError" class="error hidden"></p>
                                        </div>
                                     </div>
                                  </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Description</label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control" name="description" value="<?php echo @$loose_oil_row['description'];?>" placeholder="description" type="text">
                                        </div>
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Short Name <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control" name="short_name" value="<?php echo @$loose_oil_row['short_name'];?>" placeholder="short name" type="text">
                                        </div>
                                    </div>
                                </div>
                               <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-6">
                                            <button type="submit" value="1" class="btn blue">Submit</button>
                                            <a href="<?php echo SITE_URL.'loose_oil';?>" class="btn default">Cancel</a>
                                        </div>
                                    </div>  
                                </div>
                            </form>
                        <?php
                    }
                    if(isset($display_results)&&$display_results==1)
                    {
                    ?>
                        <form method="post" action="<?php echo SITE_URL.'loose_oil'?>">
                            <div class="row">                                
                                <div class="col-sm-3">
                                    <div class="form-group">
                                      <input class="form-control" name="name" value="<?php echo @$search_data['name'];?>" placeholder="name" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input class="form-control" name="short_name" value="<?php echo @$search_data['short_name'];?>" placeholder="short name" type="text">
                                    </div>
                                </div>                                       
                                <div class="col-sm-4">
                                    <div class="form-actions">
                                        <button type="submit" name="search_loose_oil" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                       <button type="submit" name="download_loose_oil" value="1" formaction="<?php echo SITE_URL.'download_loose_oil';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
                                        <a href="<?php echo SITE_URL.'add_loose_oil';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>                                      
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th > S.No</th>
                                        <th > Name </th>
                                        <th >Short Name</th>
                                        <th > Description</th>
                                        <th > Actions </th>            
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                if(count($loose_oil_results)>0)
                                {
                                    foreach($loose_oil_results as $row)
                                    {
                                         ?>
                                    <tr>
                                        <td > <?php echo $sn++;?></td>
                                        <td > <?php echo $row['name'];?> </td>
                                        <td > <?php echo $row['short_name'];?> </td>
                                        <td > <?php echo $row['description'];?> </td>
                                        
                                        <td >   
                                            <a class="btn btn-default btn-xs" href="<?php echo SITE_URL.'edit_loose_oil/'.cmm_encode($row['loose_oil_id']);?>"  data-container="body" data-placement="top" data-original-title="Edit Details"><i class="fa fa-pencil"></i></a>
                                            <?php
                                            if($row['status']==1)
                                            {
                                            ?>
                                            <a class="btn btn-danger btn-xs"  onclick="return confirm('Are you sure you want to Deactivate?')" href="<?php echo SITE_URL.'deactivate_loose_oil/'.cmm_encode($row['loose_oil_id']);?>">
                                            <i class="fa fa-trash-o"></i>
                                            </a>
                                            <?php
                                            }
                                            if($row['status']==2)
                                            {
                                            ?>
                                            <a class="btn btn-info btn-xs tooltips"  onclick="return confirm('Are you sure you want to Activate?')" href="<?php echo SITE_URL.'activate_loose_oil/'.cmm_encode($row['loose_oil_id']);?>">
                                            <i class="fa fa-check"></i>
                                            </a>
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
                                    <tr><td colspan="5" align="center">-No Records Found-</td></tr>
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


