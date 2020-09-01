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
                        <form id="oil_stock_balance_entry_form" method="post" action="<?php echo $form_action;?>"  autocomplete="on" class="form-horizontal">
                            <div class="row">
                               
                                <div class="col-md-offset-1 col-md-3">
                                    <h4><?php echo '<b>OPS Name :</b>'.get_plant_name();?></h4>
                                </div>
                                <div class="col-md-3">
                                   <h4> <?php echo '<b>Date :</b>'.date('d-m-Y');?></h4>
                                </div>
                                 <div class="col-md-5">
                                     <h4> <?php echo '<b>Last Reading Taken On</b>:'.@$last_reading_taken;?></h4>
                                 </div>
                                
                            </div>
                            <div class="col-md-offset-2 col-md-8">
                                <div class="table-scrollable form-body">
                                    <table class="table table-bordered table-striped table-hover product_table">
                                        <thead>
                                            <tr>
                                                <th style="width:40%">Packing Material </th>
                                                <th style="width:30%">Opening Balance </th>                                            
                                            </tr>
                                        </thead>
                                        <tbody> 
                                        <?php
                                             foreach($packing_material as $packing_materials)
                                                {?>                                                
                                            <tr>
                                                <td>                                     
                                                    <?php echo $packing_materials['name']; ?>
                                                </td>
                                                <td>
                                                    <div class="col-md-10">
                                                    <div class="col-md-8">
                                                        <div class="dummy">
                                                            <div class="input-icon right">
                                                                <i class="fa"></i>
                                                                <input type="text" style="width:130px;" class="form-control numeric"  maxlength="25" name="opening_balance[<?php echo $packing_materials['pm_id'];?>]" value="<?php echo '0';?>">
                                                            
                                                            </div>
                                                        </div>
                                                    </div>
                                                        <div class="col-md-2">
                                                            <p class="form-control-static"><?php echo get_pm_unit_name(@$packing_materials['pm_id']);?></p>
                                                        </div>
                                                    </div>

                                                </td>                                 
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>  
                            </div>                                                             
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-5 col-md-6">
                                        <button type="submit" value="1" name="submit" class="btn blue">Submit</button>
                                        <a href="<?php echo SITE_URL.'manage_oil_stock_balance';?>" class="btn default">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form>

                       <?php
                    }
                    if(isset($display_results)&&$display_results==1)
                    {
                    ?>
                        <form method="post" action="<?php echo SITE_URL.'manage_pm_stock_balance'?>">
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <select class="form-control"  id="pm_id" name="pm_id">
                                            <option value="">Select Packing Material</option>
                                            <?php
                                              foreach($packing_material as $row)
                                              {
                                              $selected = (@$row['pm_id']==@$searchParams['pm_id'])?'selected="selected"':'';
                                              echo '<option value="'.@$row['pm_id'].'"  '.$selected.'>'.@$row['name'].'</option>';
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
                                <div class="col-md-6">
                                    <div class="form-actions">
                                        <button type="submit" name="search_pm_stock_balance" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search" ><i class="fa fa-search"></i></button>
                                        <a  class="btn blue tooltips" href="<?php echo SITE_URL.'manage_pm_stock_balance';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
                                        <!-- <button type="submit" name="download_pm_stock_balance" value="1" formaction="<?php echo SITE_URL.'download_pm_stock_balance';?>" class="btn btn-xs blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button> -->
                                        <a href="<?php echo SITE_URL.'view_pm_quantity';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New for packing materials">PM Opening balance</a>
                                        <a href="<?php echo SITE_URL.'product_micron';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New for films">Film Opening Balance</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th> Plant </th>
                                        <th> Packing Material </th>
                                        <th> Opening Bal </th>
                                        <th> Date</th>
                                        <th> Receipts  </th>
                                        <th> Production </th> 
                                        <th> Closing Bal</th>
                                        <th> Wastage  </th>
                                        <th> Allowable Wastage</th>
                                        <th> Status </th>           
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                if($pm_stock_balance_results){

                                    foreach($pm_stock_balance_results as $row){
                                ?>
                                    <tr>
                                        <td> <?php echo $sn++;?></td>
                                        <td> <?php echo get_plant_name();?> </td>
                                        <td> <?php echo get_pm_name($row['pm_id']);?> </td>
                                        <td> <?php echo $row['opening_balance'];?> </td>
                                        <td> <?php echo $row['on_date'];?></td>
                                        <td> <?php echo $row['receipts'];?> </td>
                                        <td> <?php echo $row['production'];?> </td>
                                        <td> 
                                        <?php echo ($row['closing_balance']!='')?$row['closing_balance']:'N/A';?> 
                                        </td>
                                        <td> <?php echo ($row['closing_balance']!='')?$row['wastage']:'N/A';?> </td>

                                        <?php 
                                            $allowed    = @$row['production']*(get_allowed_percentage()/100);?>
                                            <td> <?php echo ($row['closing_balance']!='')?$allowed:'N/A';?> </td>
                                            <?php
                                            if($row['closing_balance']!='')
                                            {
                                                if($row['wastage'] > $allowed)
                                                {?>
                                                   <td>  <span class="label label-danger">Limit Exceeded</span></td>
                                                <?php
                                                }
                                                else
                                                {?>
                                                   <td> <span class="label label-success">Within Range</span></td>
                                            <?php
                                                }
                                            }
                                            else
                                            {?>
                                                <td> N/A</td>
                                        <?php

                                            }
                                        ?>
                                        
                                    </tr>
                                <?php
                                    }
                                }
                                else
                                {
                            ?>      <tr><td colspan="11" align="center"> No Records Found</td></tr>      
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