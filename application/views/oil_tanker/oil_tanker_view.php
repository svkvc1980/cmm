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
                                    <label class="col-md-3 control-label">OilTank Name <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <?php if($flg==2) 
                                            {
                                                ?>  <p class="form-control-static"><b><?php echo @$oil_tanker_row['name'];?></b></p>
                                                <?php
                                            }
                                            else
                                            {?>

                                                <input class="form-control" name="oil_tank_name" value="<?php echo @$oil_tanker_row['oil_tank_name'];?>" placeholder="Tank Name" type="text">
                                            <?php
                                            }?>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">OilTank Capacity <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <?php if($flg==2) 
                                            {
                                                ?>  <p class="form-control-static"><b><?php echo @$oil_tanker_row['capacity'];?></b></p>
                                                <?php
                                            }
                                            else
                                            {?>

                                                <input class="form-control" name="tank_capacity"   placeholder="Tank Capacity" type="text">
                                            <?php
                                            }?>
                                            
                                            
                                        </div>
                                    </div>
                                </div>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Unit Name<span class="font-red required_fld">*</span></label>
                                         <div class="col-md-6">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                            <?php
                                            if($flg==2)
                                            {
                                              ?>
                                              <p class="form-control-static"><b><?php echo $plant_id['name'];?></b></p> 
                                              <?php 
                                            }
                                            else
                                            {?>
                                               <select  name="plant_id" class="form-control">
                                               <option value="">-Select Plant-</option>
                                                <?php 
                                                    foreach($plantlist as $plant)
                                                    {
                                                        $selected = '';
                                                        if($plant['plant_id'] == @$oil_tanker_row['plant_id']) $selected = 'selected';
                                                        echo '<option value="'.$plant['plant_id'].'" '.$selected.'>'.$plant['name'].'</option>';
                                                    }
                                                ?>
                                                </select> <?php
                                             }?> 
                                           </div>  
                                        </div>
                                    </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">LooseOil Name<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                       <div class="input-icon right">
                                            <i class="fa"></i>
                                            <?php echo form_dropdown('loose_oil',$loose_oil,@$oil_tanker_row['loose_oil_id'],'class="form-control"');?>
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
                                        <input class="form-control" name="name" value="<?php echo @$search_data['name'];?>" placeholder="Oil Tank Name" type="text">
                                    </div>
                                </div>                                
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <?php echo form_dropdown('loose_oil',$loose_oil,@$oil_tanker_row['loose_oil_id'],'class="form-control"');?>
                                    </div>
                                </div>                                
                                <div class="col-sm-4">
                                    <div class="form-actions">
                                        <button type="submit" name="search_oil_tanker" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                        <button type="submit" name="download_oil_tank" value="1" formaction="<?php echo SITE_URL.'download_oil_tank';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
                                        <a href="<?php echo SITE_URL.'add_oil_tank';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;"> S.No</th>
                                        <th style="text-align: center;"> OilTank Name </th>                                       
                                        <th style="text-align: center;">OilTank Capacity</th>
                                         <th style="text-align: center;">Unit Name</th>
                                         <th style="text-align: center;">LooseOil Name</th>
                                        <th style="text-align: center;"> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                if($oil_tanker_results){

                                    foreach($oil_tanker_results as $row){
                                ?>
                                    <tr>
                                        <td style="text-align: center;"> <?php echo $sn++;?></td>
                                        <td style="text-align: center;"> <?php echo $row['name'];?> </td>
                                        <td style="text-align: center;"> <?php echo $row['capacity'];?> </td>                                  
                                        <td style="text-align: center;"> <?php echo $row['plant_name'];?> </td>
                                        <td style="text-align: center;"> <?php echo $row['loose_oil_name'];?> </td>
                                           <td style="text-align: center;">
                                            <a class="btn btn-success" href="<?php echo SITE_URL.'edit_oil_tank/'.cmm_encode($row['oil_tank_id']);?>">Change Oil</a>
                                            <?php
                                            if($row['status']==1){
                                            ?>
                                            <a class="btn btn-danger  tooltips"  onclick="return confirm('Are you sure you want to Deactivate?')" href="<?php echo SITE_URL.'deactivate_oil_tank/'.cmm_encode($row['oil_tank_id']);?>" data-container="body" data-placement="top" data-original-title="DeActivate"><i class="fa fa-trash-o"></i></a>
                                            <?php
                                            }
                                            if($row['status']==2){
                                            ?>
                                            <a class="btn btn-info  tooltips"  onclick="return confirm('Are you sure you want to Activate?')" href="<?php echo SITE_URL.'activate_oil_tank/'.cmm_encode($row['oil_tank_id']);?>" data-container="body" data-placement="top" data-original-title="Activate"><i class="fa fa-check"></i></a>
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