
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
                    <form id="production_details_form" method="post" action="<?php echo SITE_URL.'production_details';?>" class="form-horizontal">
                        <div class="row">                                    
                            <div class="col-md-6">
                              <div class="form-group">
                              <label class="col-md-7 control-label">Date :<span class="font-red required_fld">*</span></label>
                                <div class="col-md-5">
                                  <div class="input-icon right">
                                    <i class="fa"></i>
                                     <input class="form-control date-picker" placeholder="Date" name="production_date" data-date-format="dd-mm-yyyy" type="text" >                               
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
                                    <a href="<?php echo SITE_URL.'change_production_date';?>" class="btn default">Cancel</a>
                                </div>                                 
                        </div>
                   </form>
                    <?php }
                    else if($flag==2) { 
                    ?> 
                    <form id="update_production_date_form" method="post" action="<?php echo SITE_URL.'update_production_date';?>" class="form-horizontal">
                        
                           <input type="hidden" name="plant_id" value="<?php echo @$production_details[0]['plant_id'];?>">
                            <div class="row">                                    
                                <div class="col-md-6">
                                  <div class="form-group">
                                  <label class="col-md-7 control-label">Select New Production Date :<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-5">
                                      <div class="input-icon right">
                                        <i class="fa"></i>
                                         <input class="form-control date-picker" required placeholder="Date" name="updated_date" data-date-format="dd-mm-yyyy" type="text" >
                                      </div>
                                    </div>
                                  </div>
                                </div>  
                                                        
                            </div>
                            <div class="row">
                                 <div class="col-md-7">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Remarks</label>
                                        <div class="col-md-7">
                                            <textarea name="remarks" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                           
                            <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        
                                        <th style="width: 10%"> S.No</th>                                        
                                        <th style="width: 10%">Product</th>
                                        <th style="width: 10%"> Quantity</th>
                                        
                                    </tr>
                                    <tbody>
                                        <?php
                                            
                                            if($production_details)
                                            {

                                                //$first_ptp_id = 0;
                                                foreach($production_details as $row)
                                                {
                                                    if($row['plant_production_id'] != @$loop_ptp_id)
                                                    {
                                                    ?>

                                                    <tr>
                                                        <td> <input  name="plant_production_id" value="<?php echo $row['plant_production_id'];?>" type="radio" >
                                                             <input  name="existing_production_date" value="<?php echo $row['production_date'];?>" type="hidden">
                                                        </td>
                                                         <td> Production Date : <?php 
                                                            $sn=1;
                                                           // $loop_ptp_id =0;
                                                          echo date('Y-m-d',strtotime(@$production_details[0]['production_date']))?></td>
                                                    </tr>
                                                    <?php }?>
                                                    <tr>
                                                        
                                                        <td style="width: 10%"> <?php echo $sn++;?></td>
                                                        
                                                        <td style="width: 80%"><?php echo $row['product_name'] ?> </td>
                                                        <td style="width: 10%"><?php echo $row['product_quantity'] ?> </td>
                                                        
                                                        <input type="hidden" name="existing_production_date" value="<?php echo $row['production_date'];?>">
                                                    </tr> <?php
                                                        $loop_ptp_id = $row['plant_production_id'];
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
                                        <button type="submit" class="btn blue" name="submit">Submit</button>
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