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
                                if($flg==2){
                                    ?>
                                    <input type="hidden" name="encoded_id" value="<?php echo cmm_encode($packing_material_row['packing_material_product_id']);?>">
                                    <?php

                                }
                                
                                ?>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Packing Material Name <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-5">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control" name="packing_material_product_name" value="<?php echo @$packing_material_row['packing_material_name'];?>" placeholder="packing material Name" type="text">
                                        </div>
                                    </div>
                                </div> 
                                <div class="form-group">
                                <label class="col-md-4 control-label">Packing Type <span class="font-red required_fld">*</span></label>
                                <div class="col-md-5">
                                <div class="input-icon right">
                                        <i class="fa"></i>
                                <select class="form-control" name="packing_type_id" >
                                    <option value="">-Select Packing Type- </option>
                                        <?php 
                                            foreach($packing_type as $pack)
                                            {
                                                $selected = '';
                                                if($pack['packing_type_id'] == @$packing_material_row['packing_type_id']) 
                                                     $selected = 'selected'; 
                                                echo '<option value="'.$pack['packing_type_id'].'" '.$selected.'>'.$pack['packing_type_name'].'</option>';
                                            }
                                        ?>
                                </select>
                                </div>
                                   
                                </div>
                            </div>     
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-5 col-md-6">
                                        <button type="submit" value="1" class="btn blue">Submit</button>
                                        <a href="<?php echo SITE_URL.'packing_material';?>" class="btn default">Cancel</a>
                                    </div>
                                </div>  
                            </div>
                            </form>
                        <?php
                    }
                    if(isset($display_results)&&$display_results==1)
                    {
                    ?>
                        <form method="post" action="<?php echo SITE_URL.'packing_material'?>">
                            <div class="row">
                                
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input class="form-control" name="packing_material_name" value="<?php echo @$search_data['packing_material_name'];?>" placeholder="packing Material name" type="text">
                                    </div>
                                </div>

                                
                                <div class="col-sm-4">
                                    <div class="form-actions">
                                        <button type="submit" name="search_packing_material" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search">
                                            <i class="fa fa-search"></i></button>
                                       <button type="submit" name="download_packing_material" value="1" formaction="<?php echo SITE_URL.'download_packing_material';?>" class="btn blue tooltips" data-container="body" 
                                        data-placement="top" data-original-title="Download">
                                        <i class="fa fa-cloud-download"></i></button> 
                                        <a href="<?php echo SITE_URL.'add_packing_material';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th> Packing material Name</th>
                                        <th> Packing type</th>
                                        <th style="width:15%"> Actions </th>            
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                if($packing_material_results){

                                    foreach($packing_material_results as $row){
                                ?>
                                    <tr>
                                        <td> <?php echo $sn++;?></td>
                                        <td> <?php echo $row['packing_material_name'];?> </td>
                                        <td> <?php echo $row['packing_type_name'];?></td>
                                        <td>   
                                            <a class="btn btn-default btn-xs tooltips" 
                                            href="<?php echo SITE_URL.'edit_packing_material/'.cmm_encode($row['packing_material_product_id']);?>"  data-container="body"
                                             data-placement="top" data-original-title="Edit Details"><i class="fa fa-pencil"></i></a>
                                             <?php
                                             if($row['status']==1)
                                             {
                                                ?>
                                             <a class="btn btn-danger btn-xs" onclick="return confirm('Are you sure you want to deactivate?')" href="<?php echo SITE_URL.'deactivate_packing_material/'.cmm_encode($row['packing_material_product_id']);?>"><i class="fa fa-trash-o"></i></a>
                                             <?php
                                             }                                           
                                            if($row['status']==2){
                                             ?>
                                             <a class="btn btn-info btn-xs tooltips" onclick="return confirm('Are you sure you want to activate?')" href="<?php echo SITE_URL.'activate_packing_material/'.cmm_encode($row['packing_material_product_id']);?>"><i class="fa fa-check"></i></a>
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
            url: SITE_URL+"Designation/get_packing_type_by_echelon",
            data:'echelon_id='+echelon_id,
            success: function(data){             
            $("#packing_type_id").html(data);
        }
        });
     
});
</script>