
<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <?php if($flag==1)
                    { ?>
                    <form id="production_details_form" method="post" action="<?php echo SITE_URL.'rollback_delete_production';?>" class="form-horizontal">
                        <div class="row">                                    
                            <div class="col-md-6">
                              <div class="form-group">
                              <label class="col-md-7 control-label">Date :<span class="font-red required_fld">*</span></label>
                                <div class="col-md-5">
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                     <input class="form-control date-picker" required placeholder="Date" name="production_date" data-date-format="dd-mm-yyyy" type="text" >                               
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Ops :<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-5">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                           <select  name="plant_id"  required class="form-control">
                                               <option value="">-Select Plant-</option>
                                                <?php 
                                                    foreach($plantlist as $plant)
                                                    {
                                                        $selected = '';
                                                        if($plant['plant_id'] == @$oil_tanker_row['plant_id']) $selected = 'selected';
                                                        echo '<option value="'.$plant['plant_id'].'" '.$selected.'>'.$plant['name'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-4"></div>
                            <div class="col-md-8">
                                <input type="submit" class="btn blue tooltips"  value="Proceed" name="submit">
                                <a href="<?php echo SITE_URL;?>" class="btn default">Cancel</a>
                            </div>                                 
                        </div>
                   </form>
                    <?php }
                    else if($flag==2) { 
                    ?> 
                    <form id="update_production_date_form" method="post" action="<?php echo SITE_URL.'delete_rb_production';?>" class="form-horizontal">
                            <h4><?php echo 'Production Date :'.$production_date;?> </h4>
                            <input type="hidden" name="plant_id" value="<?php echo $plant_id;?>">
                            <input type="hidden" name="production_date" value="<?php echo $production_date;?>">
                            <div class="row ">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Remarks <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-5">
                                        <textarea name="remarks" class="form-control" required></textarea>
                                    </div>
                                </div>   
                            </div>
                            <div class="table-scrollable">

                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 10%">Select </th>
                                        <th style="width: 10%"> S.No</th>                                        
                                        <th style="width: 10%">Product</th>
                                        <th style="width: 10%"> Quantity</th>
                                        
                                    </tr>
                                    <tbody>
                                        <?php
                                            $sn=1;
                                            if($production_details)
                                            {

                                                foreach($production_details as $row)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td style="width: 10%"><input type="checkbox" name="pdp_id_arr[]" value="<?php echo $row['pdp_id'];?>"> </td>
                                                        <td style="width: 10%"> <?php echo $sn++;?></td>
                                                        <!-- <td style="width: 10%"> <?php echo date('Y-m-d',strtotime($row['production_date']))?> </td> -->
                                                        <td style="width: 10%"><?php echo $row['product_name'] ?> </td>
                                                        <td style="width: 10%" ><?php echo $row['product_quantity'] ?> </td> 
                                                        <input type="hidden" name="pd_qty[<?php echo $row['pdp_id'];?>]" value="<?php echo $row['product_quantity'] ?>" >                                               
                                                        <input type="hidden" name="product_id[<?php echo $row['pdp_id'];?>]" value="<?php echo $row['product_id'] ?>" >                                               
                                                        
                                                    </tr> <?php
                                                    }
                                                }
                                                else
                                                {
                                            ?>      <tr><td colspan="6" align="center"> No Records Found</td></tr>      
                                        <?php   }
                                                ?>
                                    </tbody>
                                </thead>
                            </table>
                        </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-5 col-md-6">
                                        <button type="submit"  value ="1" class="btn blue" name="submit">Delete Production</button>
                                        <a href="<?php echo SITE_URL.'change_production_date';?>" class="btn default">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form><?php
                    }?>
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>                