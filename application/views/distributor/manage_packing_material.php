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
                        <form id="packing_material_form" method="post" action="<?php echo $form_action;?>" class="form-horizontal">
                            <?php
                            if($flg==2)
                            {
                                ?>
                                <input type="hidden" name="encoded_id" value="<?php echo cmm_encode($packing_material_row['pm_id']);?>">
                                <input type="hidden" class="pm_id" name="pro_id" value="<?php echo $packing_material_row['pm_id'];?>">
                                <?php
                            }
                            ?>
                            
                            <div class="form-group">
                            <label for="inputName" class="col-sm-4 control-label">Test Category <span class="font-red required_fld">*</span></label>
                                <div class="col-sm-5">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <?php echo form_dropdown('category', $category, @$selected_category,'class="form-control" value="" name="category"');?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                            <label for="inputName" class="col-sm-4 control-label">Packing Material Group <span class="font-red required_fld">*</span></label>
                                <div class="col-sm-5">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <?php echo form_dropdown('pm_group', $pm_group_results, @$packing_material_row['pm_group_id'],'class="form-control" value="" name="pm_group"');?>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                            <label for="inputName" class="col-sm-4 control-label">Product Denomination <span class="font-red required_fld">*</span></label>
                                <div class="col-sm-5">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <select class="form-control capacity_id" name="capacity">
                                            <option selected value="">-Select Product Denomination-</option>
                                            <?php 
                                                foreach($capacity as $row)
                                                {  
                                                    $selected = '';
                                                    if($row['capacity_id'] == @$packing_material_row['capacity_id']) 
                                                    $selected = 'selected'; 
                                                    echo '<option value="'.$row['capacity_id'].'"'.$selected.'>'.$row['capacity'].' '.$row['unit'].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                            <label for="inputName" class="col-sm-4 control-label">Packing Material Name <span class="font-red required_fld">*</span></label>
                                <div class="col-sm-5">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="text" class="form-control" id="packingmaterialName" placeholder="Packing Material Name" name="packing_material" value="<?php echo @$packing_material_row['packing_material']; ?>" maxlength="150">
                                        <p id="packingmaterialnameValidating" class="hidden">
                                        <i class="fa fa-spinner fa-spin"></i> Checking...</p>
                                        <p id="packingmaterialError" class="error hidden"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputName" class="col-sm-4 control-label">Description </label>
                                    <div class="col-sm-5">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <textarea type="text" class="form-control" id="desc" placeholder="Enter Description Here..." name="description" maxlength="150"><?php echo @$packing_material_row['description']; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            <div class="form-group">
                                <div class="col-sm-offset-5 col-sm-6">
                                    <button class="btn blue" type="submit" name="submit" value="button"><i class="fa fa-check"></i> Submit</button>
                                    <a class="btn default" href="<?php echo SITE_URL;?>packing_material"><i class="fa fa-times"></i> Cancel</a>
                                </div>
                            </div>
                        </form>
                        <?php
                        }
                        if(isset($display_results) && $display_results==1)
                        {
                        ?>
                        <form role="form" class="form-horizontal" method="post" action="<?php echo SITE_URL;?>packing_material">
                            <div class="row">
                                <div class="col-sm-2">
                                  <input type="text" name="packing_material" value="<?php echo @$search_params['packing_material_name'];?>" class="form-control" placeholder="Packing Material Name">
                                </div>
                                <div class="col-sm-2">
                                    <?php echo form_dropdown('pm_group', $pm_group_results, @$search_params['pm_group'],'class="form-control" value="" name="pm_group"');?>
                                </div>
                                <div class="col-sm-2">
                                    <select class="form-control" name="pm_category_id" >
                                        <option value="">- Pm Category - </option>
                                          <?php 
                                           foreach($pm_category_list as $den)
                                            {
                                            $selected = "";
                                            if($den['pm_category_id']== @$search_params['pm_category_id'])
                                                { 
                                                    $selected='selected';
                                                }
                                            echo '<option value="'.$den['pm_category_id'].'" '.$selected.' >'.$den['name'].'</option>';
                                             }?>  
                                    </select>
                                </div>
                                <div class="col-sm-2">
                                    <select class="form-control" name="capacity_id" >
                                        <option value="">- Denomination -</option>
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
                                
                                <div class="col-sm-1">
                            <div class="form-group">
                                    <select name="status" class="form-control" >
                                        <option value="">- Status -</option>
                                        <option value="1" <?php if(@$search_params['status']==1){?>selected <?php } ?> >Active</option>
                                        <option value="2" <?php if(@$search_params['status']==2){?>selected <?php } ?> >InActive</option>
                                    </select>
                                
                            </div>
                        </div> 
                                <div class="col-sm-3">
                                     <button type="submit" name="search_packing_material" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i> </button>
                                    <button type="submit" name="download_packing_material" value="download" formaction="<?php echo SITE_URL;?>download_pm_master" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i> </button>
                                    <a  class="btn blue tooltips" href="<?php echo SITE_URL.'packing_material';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
                                    <a href="<?php echo SITE_URL;?>add_packing_material" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i> </a>
                                </div>
                            </div>
                        </form><br/>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th> Name </th>
                                        <th> PM Group</th>
                                        <th> Test Category </th>
                                        <th>Denomination </th>
                                        <th> Description </th>
                                        <th style="width:10%"> Actions </th>            
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($packing_material)
                                {
                                    foreach($packing_material as $row)
                                    {
                                ?>
                                    <tr>
                                        <td> <?php echo $sn++;?></td>
                                        <td> <?php echo $row['packing_material'];?> </td>
                                        <td> <?php echo $row['pm_group'];?> </td>
                                        <td> <?php echo $row['category'];?> </td>
                                        <td> <?php echo $row['capacity'].' '.$row['unit'];?> </td>
                                        <td> <?php echo $row['description'];?> </td>
                                        <td style="width:10%">
                                            <a class="btn btn-default btn-xs tooltips" data-container="body" data-placement="top" data-original-title="Edit" href="<?php echo SITE_URL;?>edit_packing_material/<?php echo @cmm_encode($row['pm_id']); ?>"><i class="fa fa-pencil"></i></a> 
                                            <?php
                                            if(@$row['packing_status'] == 1)
                                            {
                                                ?>
                                                <a class="btn btn-danger btn-xs tooltips" data-container="body" data-placement="top" data-original-title="De-Activate" href="<?php echo SITE_URL;?>deactivate_packing_material/<?php echo @cmm_encode($row['pm_id']); ?>" onclick="return confirm('Are you sure you want to Delete?')"><i class="fa fa-trash-o"></i></a>
                                                <?php
                                            }
                                            else
                                            {
                                                ?>
                                                <a class="btn btn-info btn-xs tooltips" data-container="body" data-placement="top" data-original-title="Activate" href="<?php echo SITE_URL;?>activate_packing_material/<?php echo @cmm_encode($row['pm_id']); ?>" onclick="return confirm('Are you sure you want to Activate?')"><i class="fa fa-check"></i></a>
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