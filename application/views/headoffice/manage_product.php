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
                            <form id="product_form" method="post" action="<?php echo $form_action;?>" class="form-horizontal">
                                <?php
                                if($flg==2)
                                {
                                    ?>
                                    <input type="hidden" name="encoded_id" value="<?php echo cmm_encode($product_row['product_id']);?>">
                                    <?php
                                }
                                ?>
                            <div class="alert alert-danger display-hide" style="display: none;">
                               <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                            </div>
                            <div class="form-group">
                            <label for="inputName" class="col-sm-3 control-label">Product Code <span class="font-red required_fld">*</span></label>
                                <div class="col-sm-6">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="name" class="form-control" id="product_code" placeholder="Product Code" name="product_code" value="<?php echo @$product_row['product_code']; ?>" maxlength="150">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                            <label for="inputName" class="col-sm-3 control-label">Product Name <span class="font-red required_fld">*</span></label>
                                <div class="col-sm-6">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="name" class="form-control" id="product_name" placeholder="Product Name" name="product_name" value="<?php echo @$product_row['product_name']; ?>" maxlength="150">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-3 control-label">Loose Oil Product Name<span class="font-red required_fld">*</span></label>
                                <div class="col-sm-6">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <?php echo form_dropdown('loose_oil_product', $loose_oil, @$search_data['loose_oil_product_id'],'class="form-control" value="<?php echo @$product_row["loose_oil_product_name"];?>" name="loose_oil_product"');?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-3 control-label">Number Of Items Per Carton <span class="font-red required_fld">*</span></label>
                                <div class="col-sm-6">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="name" class="form-control numeric" id="" placeholder="Number Of Items Per Carton" name="no_of_items" value="<?php echo @$product_row['no_of_item_per_carton']; ?>" maxlength="9">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-10">
                                    <button class="btn blue" type="submit" name="submit" value="button"><i class="fa fa-check"></i> Submit</button>
                                    <a class="btn default" href="<?php echo SITE_URL;?>product"><i class="fa fa-times"></i> Cancel</a>
                                </div>
                            </div>
                        </form>
                        <?php
                        }
                        if(isset($display_results)&&$display_results==1)
                        {
                        ?>
                        <form role="form" class="form-horizontal" method="post" action="<?php echo SITE_URL;?>product">
                            <div class="row">
                                <label class="col-sm-3 control-label">Product Name</label>
                                <div class="col-sm-3">
                                    <input type="text" name="product_name" maxlength="150" value="<?php echo @$searchParams['product_name'];?>" id="" class="form-control" placeholder="Product Name">
                                </div>
                                
                                <div class="col-sm-5">
                                    <button type="submit" title="Search" name="search_product" value="1" class="btn blue"><i class="fa fa-search"></i> </button>
                                    <button title="Download" type="submit" name="download_product" value="download" formaction="<?php echo SITE_URL;?>download_product" class="btn blue"><i class="fa fa-cloud-download"></i> </button>
                                    <a href="<?php echo SITE_URL;?>add_product" title="Add New" class="btn blue"><i class="fa fa-plus"></i> </a>
                                </div>
                            </div>
                        </form><br/>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th> Product Name </th>
                                        <th> Loose Oil Product Name </th>
                                        <th> Number Of Items Per Carton </th>
                                        <th> Actions </th>            
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($product)
                                {

                                    foreach($product as $row)
                                    {
                                ?>
                                    <tr>
                                        <td> <?php echo $sn++;?></td>
                                        <td> <?php echo $row['product_name'];?> </td>
                                        <td> <?php echo $row['loose_oil_product_name'];?> </td>
                                        <td> <?php echo $row['no_of_item_per_carton'];?> </td>
                                        <td>
                                            <a class="btn btn-default btn-xs" href="<?php echo SITE_URL;?>edit_product/<?php echo @cmm_encode($row['product_id']); ?>"><i class="fa fa-pencil"></i></a> 
                                            <?php
                                            if(@$row['status'] == 1)
                                            {
                                                ?>
                                                <a class="btn btn-danger btn-xs" title="De-Activate" href="<?php echo SITE_URL;?>delete_product/<?php echo @cmm_encode($row['product_id']); ?>" onclick="return confirm('Are you sure you want to Delete?')"><i class="fa fa-trash-o"></i></a>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <a class="btn btn-info btn-xs" title="Activate" href="<?php echo SITE_URL;?>activate_product/<?php echo @cmm_encode($row['product_id']); ?>" onclick="return confirm('Are you sure you want to Activate?')"><i class="fa fa-check"></i></a>
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
                            ?>  
                                <tr><td colspan="6" align="center"><span class="label label-primary">No Records</span></td></tr>
                            <?php   
                            } ?>
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