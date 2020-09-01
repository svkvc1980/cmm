<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                
                <div class="portlet-body">
                    
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th > S.No</th>
                                        <th > Work Flow Name </th>
                                        <th > View</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <tr>
                                <td>1</td>
                                <td>Lab Test(oil) Master</td>
                                <td><a class="btn btn-default btn-xs tooltips" href="<?php echo assets_url();?>user_manuals/lab_test_oil.pdf"  data-container="body" data-placement="top" data-original-title="View Details">View</a></td>
                                </tr>
                                <tr>
                                <td>2</td>
                                <td>Lab Test(Packing material) Master</td>
                                <td><a class="btn btn-default btn-xs tooltips" href="<?php echo assets_url();?>user_manuals/lab_test_packingmaterial.pdf"  data-container="body" data-placement="top" data-original-title="View Details">View</a></td>
                                </tr>
                                
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
                   
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->

<?php $this->load->view('commons/main_footer', $nestedView); ?>