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
                                    <input type="hidden" class="product_id" name="pro_id" value="<?php echo $product_row['product_id'];?>">
                                    <?php
                                }
                                ?>
                                 <div class="row">                                    
                                    <div class="col-md-6">
                                      <div class="form-group">
                                      <label class="col-md-4 control-label">Oil Category<span class="font-red required_fld">*</span></label>
                                        <div class="col-md-6">
                                          <div class="input-icon right">
                                            <i class="fa"></i>
                                             <?php echo form_dropdown('loose_oil', $loose_oil, @$product_row['loose_oil_id'],'class="form-control" value="<?php echo @$product_row1["loose_oil_name"];?>" name="loose_oil"');?>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Product Denomination<span class="font-red required_fld">*</span></label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <select class="form-control capacity_id" name="capacity">
                                                        <option selected value="">-Select Denomination-</option>
                                                        <?php 
                                                            foreach($capacity as $row)
                                                            {   
                                                               $selected='';
                                                               if($row['capacity_id']==@$capacity_id)
                                                                $selected='selected';
                                                                echo '<option value="'.$row['capacity_id'].'"'.$selected.'>'.$row['capacity'].' '.$row['unit'].'</option>';
                                                            }
                                                        ?>
                                                    </select>   
                                               </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">                                    
                                    <div class="col-md-6">
                                      <div class="form-group">
                                      <label class="col-md-4 control-label">Name<span class="font-red required_fld">*</span></label>
                                        <div class="col-md-6">
                                          <div class="input-icon right">
                                            <i class="fa"></i>
                                             <input type="text" class="form-control" id="productName" placeholder="Product Name" name="product" value="<?php echo @$product_row['name']; ?>" maxlength="30">
                                             <p id="productnameValidating" class="hidden"><i class="fa fa-spinner fa-spin"></i> Checking...</p>
                                             <p id="ProductError" class="error hidden"></p>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Short Name<span class="font-red required_fld">*</span></label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                     <input type="name" class="form-control" placeholder="Short Name" name="short_name" value="<?php echo @$product_row['short_name']; ?>">
                                               </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">                                    
                                    <div class="col-md-6">
                                      <div class="form-group">
                                      <label class="col-md-4 control-label">Items Per Carton <span class="font-red required_fld">*</span></label>
                                        <div class="col-md-6">
                                          <div class="input-icon right">
                                            <i class="fa"></i>
                                        <input type="name" class="form-control numeric" placeholder="Items Per Carton" name="items_per_carton" value="<?php echo @$product_row['items_per_carton']; ?>" maxlength="10">
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Oil Weight Per Packet <span class="font-red required_fld">*</span></label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                        <input type="name" class="form-control" placeholder="Oil Weight" name="oil_weight" value="<?php echo @$product_row['oil_weight']; ?>" maxlength="10">
                                               </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row"> 
                                <div class="col-md-6">
                                      <div class="form-group">
                                      <label class="col-md-4 control-label">Product Packing Type<span class="font-red required_fld">*</span></label>
                                        <div class="col-md-6">
                                          <div class="input-icon right">
                                            <i class="fa"></i>
                                             <?php echo form_dropdown('product_packing_type', $product_packing_type, @$product_row['product_packing_type_id'],'class="form-control"');?>
                                          </div>
                                        </div>
                                      </div>
                                    </div>                                     
                                    <div class="col-md-6">
                                      <div class="form-group">
                                      <label class="col-md-4 control-label">Description</label>
                                        <div class="col-md-6">
                                          <div class="input-icon right">
                                            <i class="fa"></i>
                                            <textarea type="text" class="form-control" id="desc" placeholder="Enter Description Here..." name="description" cols="2" maxlength="100"><?php echo @$product_row['description']; ?></textarea>
                                          </div>
                                        </div>
                                      </div>
                                    </div>                                    
                                </div>
                                <div class="form-group">
                                 <div class="col-sm-offset-5 col-sm-6">
                                    <button class="btn blue" type="submit" name="submit" value="button"><i class="fa fa-check"></i> Submit</button>
                                    <a class="btn default" href="<?php echo SITE_URL;?>product"><i class="fa fa-times"></i> Cancel</a>
                                 </div>
                                </div>
                        </form>
                        <?php
                        }
                        if(isset($display_results) && $display_results==1)
                        {
                        ?>
                        <form method="post" action="<?php echo SITE_URL.'product'?>">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input type="text" name="product" maxlength="150" value="<?php echo @$search_params['product'];?>" id="" class="form-control" placeholder="Product Name">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <?php echo form_dropdown('oil_category', $oil_cotegory, @$search_params['loose_oil_id'],'class="form-control"');?>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                         <?php echo form_dropdown('product_packing_type', $product_packing_type, @$search_params['product_packing_type_id'],'class="form-control"');?>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <select class="form-control plantid" name="capacity_id" >
                                    <option value="">- denomination -</option>

                                    <?php 
                                    foreach($denomination_list as $den)
                                    {
                                        $selected = "";
                                        if($den['capacity_id']== @$search_params['capacity_id'])
                                            { 
                                                $selected='selected';
                                            }
                                        echo '<option value="'.$den['capacity_id'].'" '.$selected.' >'.$den['capacity'].' '.$den['unit'].'</option>';
                                    }?>
                                </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                	<div class="form-group">
                                    <select name="status" class="form-control" >
                                        <option value="">- Status -</option>
                                        <option value="1" <?php if(@$search_params['status']==1){?>selected <?php } ?> >Active</option>
                                        <option value="2" <?php if(@$search_params['status']==2){?>selected <?php } ?> >InActive</option>
                                    </select>
                            </div>
                        </div> 
                               <div class="col-sm-offset-9 col-sm-3">
                                    <button type="submit" title="Search" name="search_product" value="1" class="btn blue"><i class="fa fa-search"></i> </button>
                                    <button title="Download" type="submit" name="download_product" value="download" formaction="<?php echo SITE_URL;?>download_product" class="btn blue"><i class="fa fa-cloud-download"></i> </button>
                                    <a  class="btn blue tooltips" href="<?php echo SITE_URL.'product';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
                                    <a href="<?php echo SITE_URL;?>add_product" title="Add New" class="btn blue"><i class="fa fa-plus"></i> </a>
                                </div>
                            </div>
                        </form><br/>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th>Name </th>
                                        <th> Oil Category</th>
                                        <th>Denomination </th>
                                        <th>Short Name</th>
                                        <th>Oil Weight</th>
                                        <th>Product Packing Type</th>
                                        <th>Items Per Carton</th>
                                        <th style="width:10%"> Actions </th>            
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
                                        <td style="width: 10%"> <?php echo $sn++;?></td>
                                        <td style="width: 20%"> <?php echo $row['product'];?> </td>
                                        <td style="width: 10%"> <?php echo $row['short_name'];?> </td>
                                        <td style="width: 10%"> <?php echo $row['capacity'].' '.$row['unit'];?> </td>
                                        <td style="width: 10%"> <?php echo $row['p_short_name'];?> </td>
                                        <td style="width: 10%"> <?php echo $row['product_oil_weight'];?> </td>
                                        <td style="width: 5%"> <?php echo $row['ppt_name'];?> </td>
                                        <td style="width: 5%"> <?php echo $row['items_per_carton'];?> </td>
                                        
                                        <td style="width: 10%">
                                            <a class="btn btn-default btn-xs" href="<?php echo SITE_URL;?>edit_product/<?php echo @cmm_encode($row['product_id']); ?>"><i class="fa fa-pencil"></i></a> 
                                            <?php
                                            if(@$row['status'] == 1)
                                            {
                                                ?>
                                                <a class="btn btn-danger btn-xs" title="De-Activate" href="<?php echo SITE_URL;?>deactivate_product/<?php echo @cmm_encode($row['product_id']); ?>" onclick="return confirm('Are you sure you want to Delete?')"><i class="fa fa-trash-o"></i></a>
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
                                <tr><td colspan="5" align="center"><span class="label label-primary">No Records</span></td></tr>
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