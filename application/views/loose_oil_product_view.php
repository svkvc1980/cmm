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
                            <form id="loose_oil_product_form" method="post" action="<?php echo $form_action;?>" class="form-horizontal">
                                <?php
                                if($flg==2){
                                    ?>
                                    <input type="hidden" name="encoded_id" value="<?php echo cmm_encode($loose_oil_product_row['loose_oil_product_id']);?>">
                                    <?php
                                }
                                ?>
                                <input type="hidden" id="loose_oil_product_id" name="productid" value="<?php echo @$loose_oil_product_row['loose_oil_product_id'] ?>">

                                <div class="alert alert-danger display-hide" style="display: none;">
                                   <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                                </div>
                                 <div class="form-group">
                                    <label class="col-md-3 control-label">Name<span class="font-red required_fld">*</span></label>
                                      <div class="col-md-6">
                                        <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input class="form-control" name="loose_oil_product_name" value="<?php echo @$loose_oil_product_row['loose_oil_product_name'];?>" id="productName" placeholder="Name" type="text">
                                          <p id="productnameValidating" class="hidden"><i class="fa fa-spinner fa-spin"></i> Checking...</p>
                                          <p id="productError" class="error hidden"></p>
                                        </div>
                                     </div>
                                  </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Code<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control" name="code" value="<?php echo @$loose_oil_product_row['code'];?>" placeholder="code" type="text">
                                        </div>
                                    </div>
                                </div>
                                
                               <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-6">
                                            <button type="submit" value="1" class="btn blue">Submit</button>
                                            <a href="<?php echo SITE_URL.'loose_oil_product';?>" class="btn default">Cancel</a>
                                        </div>
                                    </div>  
                                </div>
                            </form>
                        <?php
                    }
                    if(isset($display_results)&&$display_results==1)
                    {
                    ?>
                        <form method="post" action="<?php echo SITE_URL.'loose_oil_product'?>">
                            <div class="row">
                                
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input class="form-control" name="loose_oil_product_name" value="<?php echo @$search_data['loose_oil_product_name'];?>" placeholder="Name" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input class="form-control" name="code" value="<?php echo @$search_data['code'];?>" placeholder="code" type="text">
                                    </div>
                                </div>
                                
                                
                                <div class="col-sm-4">
                                    <div class="form-actions">
                                        <button type="submit" name="search_loose_oil_product" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                       <button type="submit" name="download_loose_oil_product" value="1" formaction="<?php echo SITE_URL.'download_loose_oil_product';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
                                        <a href="<?php echo SITE_URL.'add_loose_oil_product';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                       <!-- <a  class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Upload "  href="<?php echo SITE_URL.'bulkupload_loose_oil_po';?>"  ><i class="fa fa-cloud-upload"></i> </a>
                                      <!-- <button type="submit" name="download_loose_oil_po_template" value="1" formaction="<?php echo SITE_URL.'download_loose_oil_po_template';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download Sample Template To upload "><i class="fa fa-cloud-download"></i></button>-->
                                        
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;"> S.No</th>
                                        <th style="text-align: center;"> Name </th>
                                        <th style="text-align: center;"> Code</th>
                                        <th style="text-align: center; width:15%"> Actions </th>            
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                if($loose_oil_product_results){

                                    foreach($loose_oil_product_results as $row){
                                ?>
                                    <tr>
                                        <td style="text-align: center;"> <?php echo $sn++;?></td>
                                        <td style="text-align: center;"> <?php echo $row['loose_oil_product_name'];?> </td>
                                        <td style="text-align: center;"> <?php echo $row['code'];?> </td>
                                        <td style="text-align: center;">   
                                            <a class="btn btn-default btn-xs" href="<?php echo SITE_URL.'edit_loose_oil_product/'.cmm_encode($row['loose_oil_product_id']);?>"  data-container="body" data-placement="top" data-original-title="Edit Details"><i class="fa fa-pencil"></i></a>
                                            <?php
                                            if($row['status']==1){
                                            ?>
                                            <a class="btn btn-danger btn-xs"  onclick="return confirm('Are you sure you want to Deactivate?')" href="<?php echo SITE_URL.'deactivate_loose_oil_product/'.cmm_encode($row['loose_oil_product_id']);?>">
                                            <i class="fa fa-trash-o"></i>
                                            </a>
                                            <?php
                                            }
                                            if($row['status']==2){
                                            ?>
                                            <a class="btn btn-info btn-xs tooltips"  onclick="return confirm('Are you sure you want to Activate?')" href="<?php echo SITE_URL.'activate_loose_oil_product/'.cmm_encode($row['loose_oil_product_id']);?>">
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
    $(document).on("change","#echelon_id",function() {    
   // var frequency = $('#equipment_id').val();
    var echelon_id = $('#echelon_id').val();
        $.ajax({
            type: "POST",
            url: SITE_URL+"Designation/get_loose_oil_product_by_echelon",
            data:'echelon_id='+echelon_id,
            success: function(data){             
            $("#loose_oil_product_id").html(data);
        }
        });
     
});
</script>