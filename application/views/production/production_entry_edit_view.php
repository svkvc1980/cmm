 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                
                <div class="portlet-body">                    
                    <form id="production_entry_form" method="post" action="<?php echo $form_action;?>"  autocomplete="on" class="form-horizontal">
                        <div class="alert alert-danger display-hide" style="display: none;">
                           <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                        </div>
                        <div class="row">
                            <div class="col-md-2"></div>
                            <div class="col-md-3">
                                <h4><?php echo '<b>OPS Name :</b>'.get_m_plant_name();?></h4>
                            </div>
                            <div class="col-md-3">
                               <h4> <?php echo '<b>Date :</b>'.date('d-M-Y');?></h4>
                            </div>
                            <div class="col-md-1">                                
                            </div>
                        </div>
                        <a  id="add_product" class="btn blue tooltips">Add New</i></a>
                        <div class="table-scrollable form-body">
                            <table class="table table-bordered table-striped table-hover product_table">
                                <thead>
                                    <tr>
                                         <th style="width:40%">Product </th>
                                            <th style="width:5%">Previous Loose Pouches</th>                                            
                                            <th style="width:5%">Qty(Cartons)</th>
                                            <th style="width:5%">Current Loose Pouches</th>
                                            <th style="width:5%">Produced Pouches</th>                                                                                    
                                            <th style="width:5%">Oil Weight(Kg)</th>
                                            <th style="width:30%">Micron Type</th>
                                            <th style="width:5%">Actions</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    if(@$production_entry_list)
                                    {   
                                        $i=1;
                                       foreach ($production_entry_list['product_id'] as $key => $value) {
                                            $display=($i==1)?'display:none;':'';$i++;
                                        ?>                                                 
                                            <tr>
                                                <td>
                                                    <input type="hidden" name="per_carton[]" class="per_carton" value="<?php echo get_items_per_carton(@$value); ?>">
                                                    <input type="hidden" name="oil_weight[]" class="oil_weight" value="<?php echo get_oil_weight(@$value); ?>">
                                                    <input type="hidden" name="hidden_previous_lp[]" class="hidden_previous_lp" value="<?php echo @$production_entry_list['hidden_previous_lp'][$key];?>">
                                                    <input type="hidden" name="hidden_sachets[]" class="hidden_sachets" value="<?php echo @$production_entry_list['hidden_sachets'][$key];?>">
                                                    <input type="hidden" name="hidden_cal_oil_wt[]" class="hidden_cal_oil_wt" value="<?php echo @$production_entry_list['hidden_cal_oil_wt'][$key];?>">
                                                    
                                                    <div class="dummy">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>
                                                        <select name="product_id[]" class="form-control product_id">
                                                        <option value="">Select Product</option>                                                       

                                                            
                                                            <?php foreach ($loose_oil as  $l_row)
                                                                  { 
                                                                    if(count($products[$l_row['loose_oil_id']])>0)
                                                                    { ?>
                                                                        <optgroup label="<?php echo $l_row['name'];?>">
                                                                        <?php foreach ($products[$l_row['loose_oil_id']] as $p_row) 
                                                                                { 
                                                                                    $selected = (@$p_row['product_id']==@$value)?'selected="selected"':'';
                                                                                    echo '<option value="'.@$p_row['product_id'].'"  '.$selected.'>'.@$p_row['name'].'</option>';
                                                                                 } 
                                                                        ?>
                                                                        </optgroup>
                                                                      
                                                                        <?php
                                                                    }
                                                                    }
                                                                ?>
                                                    
                                                    </select>
                                                    </div>
                                                    </div>
                                                </td>
                                                <td class="previous_lp">
                                                    <?php echo $production_entry_list['hidden_previous_lp'][$key];?> 
                                                    <input type="hidden" name="hidden_previous_lp[]" class="hidden_previous_lp" value=" <?php echo @$production_entry_list['hidden_previous_lp'][$key];?> ">                                                   
                                                </td>
                                                <td>
                                                    <div class="dummy">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input type="text" class="form-control qty" value="<?php echo @$production_entry_list['quantity'][$key];?>" maxlength="25" name="quantity[]">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="dummy">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input type="text" class="form-control loose_pouches" value="<?php echo @$production_entry_list['loose_pouches'][$key];?>" maxlength="25" name="loose_pouches[]">
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="sachets">
                                                    <?php echo @$production_entry_list['hidden_sachets'][$key];?>                                                    
                                                </td>
                                                <td class="cal_oil_wt">
                                                    <?php echo @$production_entry_list['hidden_cal_oil_wt'][$key];?>
                                                    
                                                </td>
                                                <td>
                                                    <div class="dummy">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <select name="pm_id[]" class="form-control pm_id">
                                                            <option value="">Select Packing Material</option>
                                                            <?php 
                                                                if($production_entry_list['pm_id'][$key]!=''){
                                                                foreach ($pm_details as $p_row) {
                                                                        $selected = (@$p_row['pm_id']==@$production_entry_list['pm_id'][$key])?'selected="selected"':'';
                                                                        echo '<option value="'.@$p_row['pm_id'].'"  '.$selected.'>'.@$p_row['name'].'</option>';
                                                                 }
                                                                }?>
                                                        
                                                        </select>
                                                        </div>
                                                    </div>
                                                </td> 
                                                <td>
                                                    <div class="dummy">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <select name="micron_id[]" class="form-control micron_id">
                                                            <option value="">Select Product</option>
                                                            <?php 
                                                                if($production_entry_list['micron_id'][$key]!=''){
                                                                foreach ($micron_details as $p_row) {
                                                                        $selected = (@$p_row['micron_id']==@$production_entry_list['micron_id'][$key])?'selected="selected"':'';
                                                                        echo '<option value="'.@$p_row['micron_id'].'"  '.$selected.'>'.@$p_row['name'].'</option>';
                                                                 }
                                                                }?>
                                                        
                                                        </select>
                                                        </div>
                                                    </div>
                                                </td>


                                                <td style="<?php echo $display;?>"><a class="btn btn-danger btn-sm remove_product_row"> <i class="fa fa-trash-o"></i></a></td>
                                            </tr>
                                        <?php
                                       }
                                    }?>
                                </tbody>
                            </table>
                        </div>                                                               
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-5 col-md-6">
                                    <button type="submit" value="1" name="submit" class="btn blue">Submit</button>
                                    <a href="<?php echo SITE_URL.'manage_production';?>" class="btn default">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>