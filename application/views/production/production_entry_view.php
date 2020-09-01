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
                        <form id="production_entry_form" method="post" action="<?php echo $form_action;?>"  autocomplete="on" class="form-horizontal">
                            <div class="alert alert-danger display-hide" style="display: none;">
                               <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-3">
                                    <h4><?php echo '<b>OPS Name :</b>'.get_plant_name();?></h4>
                                </div>
                                <div class="col-md-3">
                                   <h4> <?php echo '<b>Date :</b>'.date('d-M-Y');?></h4>
                                </div>
                                <div class="col-md-1">                                
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-10">
                                    <h6><b>Pre P</b>: Previous Day Pouches,<b>Cur P</b>: Current Day Pouches <b>Prod P</b>: Produced Pouches</h6>
                                   
                                </div>
                                
                            </div>
                            <a  id="add_product" class="btn blue tooltips">Add New</i></a>
                            <div class="table-scrollable form-body">
                                <table class="table table-bordered table-striped table-hover product_table">
                                    <thead>
                                        <tr>
                                            <th style="width:25%"> Product </th>
                                            <th style="width:4%">  Pre P </th>                                            
                                            <th style="width:13%"> Qty(C) </th>
                                            <th style="width:9%">  Cur P </th>
                                            <th style="width:12%"> Prod P </th>                                                                                    
                                            <th style="width:10%">  Oil Weight </th>
                                            <th style="width:18%">  Film</th>
                                            <th style="width:20%">Micron Type</th>
                                            <th style="width:2%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>                                                 
                                        <tr>
                                            <td>
                                                <input type="hidden" name="per_carton[]" class="per_carton" value="">
                                                <input type="hidden" name="oil_weight[]" class="oil_weight" value="">
                                                <input type="hidden" name="hidden_previous_lp[]" class="hidden_previous_lp" value="">
                                                <input type="hidden" name="hidden_sachets[]" class="hidden_sachets" value="">
                                                <input type="hidden" name="hidden_cal_oil_wt[]" class="hidden_cal_oil_wt" value="">
                                                <div class="dummy">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>                                                    
                                                        <select name="product_id[]" class="form-control product_id">
                                                        <option value="">-Products-</option>
                                                            <?php foreach ($loose_oil as  $l_row)
                                                                  { 
                                                                    if(count($products[$l_row['loose_oil_id']])>0)
                                                                    { ?>
                                                                        <optgroup label="<?php echo $l_row['name'];?>">
                                                                        <?php foreach ($products[$l_row['loose_oil_id']] as $p_row) 
                                                                                {?>
                                                                            <option value="<?php echo $p_row['product_id'];?>"><?php echo $p_row['name'];?></option>
                                                                         <?php } 
                                                                        ?></optgroup>
                                                                      
                                                                        <?php
                                                                    }
                                                                }?>
                                                        
                                                        </select>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="previous_lp">
                                                
                                            </td>
                                            <td>
                                                <div class="dummy">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>
                                                        <input type="text" class="form-control qty" maxlength="25" name="quantity[]">
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="dummy">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>
                                                        <input type="text" class="form-control current_lp" maxlength="25" name="loose_pouches[]">
                                                    </div>
                                                </div>
                                            </td>                                            
                                            <td class="sachets"> </td>
                                            <td class="cal_oil_wt"> </td>
                                            <td>
                                                <div class="dummy pm_id_cls hidden">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>                                                    
                                                            <select name="pm_id[]" class="form-control pm_id">
                                                                <option value="">-Packing Material-</option>                                                                                                                   
                                                            </select>
                                                        </div>
                                                </div>  
                                            </td>

                                            <td>
                                                <div class="dummy micron_id_cls hidden">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>                                                    
                                                            <select name="micron_id[]" class="form-control micron_id">
                                                                <option value="">-Microns-</option>                                                                                                                   
                                                            </select>
                                                        </div>
                                                </div>  
                                            </td>                                                                                     
                                            <td style="display:none;" ><a class="btn btn-danger btn-sm remove_product_row"> <i class="fa fa-trash-o"></i></a></td>
                                        </tr>
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

                       <?php
                    }
                    if(isset($display_results)&&$display_results==1)
                    {
                    ?>
                        <form method="post" action="<?php echo SITE_URL.'manage_production'?>">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select class="form-control"  id="loose_oil_id" name="loose_oil_id">
                                            <option value="">Select Loose Oil</option>
                                            <?php
                                              foreach($loose_oils as $row)
                                              {
                                              $selected = (@$row['loose_oil_id']==@$searchParams['loose_oil_id'])?'selected="selected"':'';
                                              echo '<option value="'.@$row['loose_oil_id'].'"  '.$selected.'>'.@$row['name'].'</option>';
                                              }
                                              ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select class="form-control" id="product_id" name="product_id">
                                            <option value="">Select Product</option>
                                           <?php                                            
                                                foreach ($products as $row) {
                                                    $sselected = ($row['product_id']==@$searchParams['product_id'])?'selected':'';
                                                    echo '<option value="'.$row['product_id'].'" '.$sselected.'>'.$row['name'].'</option>';
                                                }
                                           
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="From Date" type="text"  value="<?php if(@$searchParams['from_date']!=''){echo date('d-m-Y',strtotime(@$searchParams['from_date']));}?>" name="from_date" />    
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="To Date" type="text" value="<?php if(@$searchParams['to_date']!=''){echo date('d-m-Y',strtotime(@$searchParams['to_date']));}?>" name="to_date" />    
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select class="form-control" name="entry_by">
                                            <option value="">Select User</option>
                                           <?php                                            
                                                foreach ($users as $row) {
                                                    $sselected = ($row['user_id']==@$searchParams['created_by'])?'selected':'';
                                                    echo '<option value="'.$row['user_id'].'" '.$sselected.'>'.$row['name'].'</option>';
                                                }                                           
                                            ?>
                                        </select>
                                    </div>
                                </div>                       
                                <div class="col-md-2">
                                    <div class="form-actions">
                                        <button type="submit" name="search_production" value="1" class="btn btn-xs blue tooltips" data-container="body" data-placement="top" data-original-title="Search" ><i class="fa fa-search"></i></button>
                                        <a  class="btn btn-xs blue tooltips" href="<?php echo SITE_URL.'manage_production';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
                                        <button type="submit" name="download_production" value="1" formaction="<?php echo SITE_URL.'download_production';?>" class="btn btn-xs blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
                                        <a href="<?php echo SITE_URL.'production_entry';?>" class="btn btn-xs blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th> Loose Oil </th>
                                        <th> Product </th>
                                        <th> Quantity </th>
                                        <th> Loose Pouches</th>
                                        <th> Sachets </th>
                                        <th> Oil Weight </th>
                                        <th> Production Date </th>
                                        <th> Entry By </th>            
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                if($production_results){

                                    foreach($production_results as $row){
                                ?>
                                    <tr>
                                        <td> <?php echo $sn++;?></td>
                                        <td> <?php echo $row['lo_name'];?> </td>
                                        <td> <?php echo $row['p_name'];?> </td>
                                        <td  align="right"> <?php echo round($row['quantity']);?> </td>
                                        <td  align="right" > <?php echo round($row['loose_pouches']);?> </td>
                                        <td  align="right"> <?php echo round($row['sachets']);?> </td>
                                        <td align="right"> <?php echo qty_format($row['tot_oil_wt']);?> </td>

                                        <td> <?php echo format_date($row['production_date']);?> </td>
                                        <td> <?php echo $row['user_name'];?> </td>
                                        
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
<?php unset($_SESSION['response']); $this->load->view('commons/main_footer', $nestedView); ?>
<script type="text/javascript">
$(document).on("change","#loose_oil_id",function() {   
    var loose_oil_id = $('#loose_oil_id').val();
    if(loose_oil_id!=''){
        $.ajax({
            type: "POST",
            url: SITE_URL+"Ajax_ci/ajax_get_products_by_loose_oil",
            data:'loose_oil_id='+loose_oil_id,
            success: function(data){      
            $("#product_id").html(data);
             }
        });
    }
    else
    {
        $.ajax({
            type: "POST",
            url: SITE_URL+"Ajax_ci/ajax_get_products_by_loose_oil",
            data:'loose_oil_id='+loose_oil_id,
            success: function(data){      
            $("#product_id").html(data);
             }
        });
    }
    
});

</script>