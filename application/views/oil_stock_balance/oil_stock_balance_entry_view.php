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
                            <div class="alert alert-danger display-hide" style="display: none;">
                               <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                            </div>
                            <div class="row">
                               
                                <div class="col-md-3">
                                    <h4><?php echo '<b>OPS Name :</b>'.get_plant_name();?></h4>
                                </div>
                                <div class="col-md-3">
                                   <h4> <?php echo '<b>Date :</b>'.date('d-M-Y');?></h4>
                                </div>
                                 <div class="col-md-6">
                                     <h4> <?php echo '<b>Last Reading Taken On</b>:'.@$last_reading_taken;?></h4>
                                 </div>
                                
                            </div>
                            
                            <div class="table-scrollable form-body">
                                <table class="table table-bordered table-striped table-hover product_table">
                                    <thead>
                                        <tr>
                                            <th style="width:20%">Loose Oil </th>
                                            <th style="width:30%">Opening Balance (MT)</th>
                                            <th style="width:40%">Remarks</th>

                                        </tr>
                                    </thead>
                                    <tbody> 
                                    <?php
                                         foreach($loose_oil as $loose_oils)
                                            {?>                                                
                                        <tr>
                                            <td>                                     
                                                <?php echo $loose_oils['name']; ?>
                                            </td>
                                            <td>
                                                <div class="dummy">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>
                                                        <input type="text" class="form-control" required maxlength="25" name="opening_balance[<?php echo $loose_oils['loose_oil_id'];?>]">
                                                    </div>
                                                </div>
                                            </td> 
                                            <td>
                                                <div class="dummy">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>
                                                        <input type="text" class="form-control"  maxlength="255" name="remarks[<?php echo $loose_oils['loose_oil_id'];?>]">
                                                    </div>
                                                </div>
                                            </td>                                
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
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
                        <form method="post" action="<?php echo SITE_URL.'manage_oil_stock_balance'?>">
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
                                        <input class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="From Date" type="text"  value="<?php if(@$searchParams['from_date']!=''){echo date('d-m-Y',strtotime(@$searchParams['from_date']));}?>" name="from_date" />    
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="To Date" type="text" value="<?php if(@$searchParams['to_date']!=''){echo date('d-m-Y',strtotime(@$searchParams['to_date']));}?>" name="to_date" />    
                                    </div>
                                </div>                                                      
                                <div class="col-md-3">
                                    <div class="form-actions">
                                        <button type="submit" name="search_oil_stock_balance" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search" ><i class="fa fa-search"></i></button>
                                        <a  class="btn blue tooltips" href="<?php echo SITE_URL.'manage_oil_stock_balance';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
                                        <button type="submit" name="download_oil_stock_balance" value="1" formaction="<?php echo SITE_URL.'download_oil_stock_balance';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
                                        <a href="<?php echo SITE_URL.'oil_stock_balance_entry';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
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
                                        <th> Loose Oil </th>
                                        <th> Opening Bal (MT)</th>
                                        <th width="10%"> Date</th>
                                        <th> Receipts (MT) </th>
                                        <th> Production (MT)</th> 
                                        <th> Closing Bal(MT)</th>
                                        <th> Recovered (KG)</th>	
                                        <th> Wastage  (KG)</th>
                                        <th> Allowable Wastage (KG)</th>
                                        <th> Status </th>           
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                if($oil_stock_balance_results){

                                    foreach($oil_stock_balance_results as $row){
                                ?>
                                    <tr>
                                        <td> <?php echo $sn++;?></td>
                                        <td> <?php echo get_plant_name();?> </td>
                                        <td> <?php echo get_loose_oil_name($row['loose_oil_id']);?> </td>
                                        <td> <?php echo qty_format($row['opening_balance']);?> </td>
                                        <td width="10%" > <?php echo format_date($row['on_date']);?></td>
                                        <td> <?php echo qty_format($row['receipts']);?> </td>
                                        <td> <?php echo qty_format($row['production']);?> </td>
                                        <td> 
                                        <?php echo ($row['closing_balance']!='')?$row['closing_balance']:'N/A';?> 
                                        </td>
                                        <td> <?php echo qty_format($row['recovered']*1000);?> </td>
                                        <td> <?php echo ($row['closing_balance']!='')?$row['wastage']*1000:'N/A';?> </td>

                                        <?php 
                                            $allowed    = @$row['production']*(get_allowed_percentage()/100);?>
                                            <td> <?php echo ($row['closing_balance']!='')?$allowed*1000:'N/A';?> </td>
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