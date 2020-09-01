 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                <?php
                    if(isset($display_results)&&$display_results==1)
                    {
                    ?>
                        <form method="post" action="<?php echo SITE_URL.'plant_freegift_list'?>">
                            <div class="row">                                
                                <div class="col-sm-offset-3 col-sm-3">
                                    <div class="form-group">
                                      <?php echo form_dropdown('plant',$plant,@$search_data['plant_id'],'class="form-control"');?>
                                    </div>
                                </div>                              
                                <div class="col-sm-4">
                                    <div class="form-actions">
                                        <button type="submit" name="search_plant_freegift_list" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                        <button name="reset" value="" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="reset"><i class="fa fa-refresh"></i></button>
                                        <button type="submit" name="download_plant_freegift_list" value="1" formaction="<?php echo SITE_URL.'download_plant_freegift_list';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                    <th style="text-align: center;"> S.No </th>
                                    <th style="text-align: center;"> Unit </th>
                                    <th style="text-align: center;"> Freegift Name </th>
                                    <th style="text-align: center;"> Quantity </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($plant_free_gift_results)
                                {
                                    foreach($plant_free_gift_results as $row)
                                    {
                                ?>
                                    <tr>
                                        <td style="text-align: center;"> <?php echo $sn++;?></td>
                                        <td style="text-align: center;"> <?php echo $row['plant_name'];?> </td>
                                        <td style="text-align: center;"> <?php echo $row['free_gift_name'];?> </td>
                                        <td style="text-align: center;"> <?php echo $row['quantity'];?> </td>
                                    </tr>
                                <?php
                                    }
                                }
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


