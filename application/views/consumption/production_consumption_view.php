<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <form  method="post" action="<?php echo SITE_URL.'production_consumption'?>">
                        <div class="row">
                        	<div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control"  id="product_id" name="product_id">
                                        <option value="">Select Product</option>
                                        <?php
                                          foreach($products as $row)
                                          {
                                          $selected = (@$row['product_id']==@$search_params['product_id'])?'selected="selected"':'';
                                          echo '<option value="'.@$row['product_id'].'"  '.$selected.'>'.@$row['name'].'</option>';
                                          }
                                          ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control" id="pm_id" name="pm_id">
                                        <option value="">Select Packing Material</option>
                                       <?php                                            
                                            foreach ($pms as $row) {
                                                $sselected = ($row['pm_id']==@$search_params['pm_id'])?'selected':'';
                                                echo '<option value="'.$row['pm_id'].'" '.$sselected.'>'.$row['pm_name'].'</option>';
                                            }
                                       
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
	                            <div class="input-group date-picker input-daterange " data-date-format="dd-mm-yyyy">
								 	<input class="form-control" name="start_date"  placeholder="From Date" type="text" value="<?php if(@$search_params['start_date']!=''){ echo @date('d-m-Y',strtotime($search_params['start_date'])); }?>" >
									<span class="input-group-addon"> to </span>
	                                <div class="input-icon right">
	                              	    <i class="fa"></i>
	                                    <input class="form-control " name="end_date" placeholder="To Date" type="text" value="<?php if(@$search_params['end_date']!=''){ echo @date('d-m-Y',strtotime($search_params['end_date'])); }?>">
	                                </div>
	                            </div>
							</div>
							<div class="col-sm-3">
                                <button type="submit" title="Search" name="search_production_consumption" value="1" class="btn blue"><i class="fa fa-search"></i> </button>
                                <a class="btn blue tooltips" href="<?php echo SITE_URL.'production_consumption';?>" data-original-title="Refresh"> <i class="fa fa-refresh"></i></a>
                                <button type="submit" value="2" formaction="<?php echo SITE_URL.'print_production_consumption';?>" name="print_production_consumption"  class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Print"><i class="fa fa-print"></i></button>
                            </div>
                        </div>
                        </form>
                        <div class="table-scrollable">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th> S.No </th>

                                    <th> Production Date </th>
                                    <th> Product </th>
                                    <th> Production Qty</th>
                                    <th> Packing Material</th>
                                    <th> Consumed Qty</th>
                                    <th> Estimated Qty</th>
                                    <th> Accuracy </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(count($production_consumption)>0)
                                {  


                                    $count =0 ;
                                    $sn_sum =0;
                                    $production_qty_sum =0;
                                    $consumed_qty_sum = 0;
                                    $estimated_qty_sum = 0;
                                    foreach($production_consumption as $row)
                                    {
                                        
                                        $new_production_product_id =  $row['production_product_id'];
                                        if($new_production_product_id == @$old_production_product_id || $count == 0 )
                                        { 

                                            $row_span = count($con_arr[$new_production_product_id]);
                                            
                                        ?>
                                            <tr>
                                                <?php if($count ==0){?>
                                            	<td rowspan="<?php echo $row_span;?>" > <?php echo $sn++;?> </td>
                                                <input type="hidden" value="<?php echo $row['production_product_id'];?>">
                                                <td rowspan="<?php echo $row_span;?>" > <?php echo date('d-m-Y',strtotime($row['production_date']));?> </td>
                                                <td rowspan="<?php echo $row_span;?>" > <?php echo $row['product_name'];?> </td>
                                                <td align="right" rowspan="<?php echo $row_span;?>" > <?php echo $row['production_qty'];?> </td> 
                                                <?php
                                                $production_qty_sum += $row['production_qty'];
                                                 }?>
                                                <td> <?php
                                                $micron_name = (@$row['mc_name']!='')?'('.@$row['mc_name'].')':'';
                                                 echo $row['packing_name'].' ' .@$micron_name;?> </td>
                                                <td align="right" > <?php echo $row['pm_qty'];?> </td>
                                                <td align="right" > <?php $estimated = qty_format(get_consumption_per_product($row['product_id'],$row['production_qty'],$row['pm_id'],$row['consumption_per_unit'],$row['mic_id']),3);
                                                echo $estimated;
                                                ?></td>
                                               <?php
                                                 if($estimated !=$row['pm_qty'])
                                                 { ?>
                                                        <td>  <span class="label label-danger">Not OK</span></td>
                                           <?php }
                                                 else
                                                 { ?>
                                                        <td> <span class="label label-success"> Ok</span></td>
                                            <?php }

                                               ?>
                                            </tr>
                                            <?php
                                                $old_production_product_id = $row['production_product_id'];
                                                $count =1;
                                                $consumed_qty_sum += $row['pm_qty']; 
                                                $estimated_qty_sum += $estimated; 

                                        }
                                        else
                                        {
                                            $count =0;
                                            $row_span = count($con_arr[$new_production_product_id]);
                                            $old_production_product_id = $row['production_product_id'];
                                            ?>

                                            <tr>
                                                <td colspan="7" > &nbsp; </td>
                                            </tr>
                                            <tr>
                                                <?php if($count ==0){?>
                                                <td rowspan="<?php echo $row_span;?>" > <?php echo $sn++;?> </td>
                                                 <input type="hidden" value="<?php echo $row['production_product_id'];?>">
                                                <td rowspan="<?php echo $row_span;?>" > <?php echo date('d-m-Y',strtotime($row['production_date']));?> </td>
                                                <td rowspan="<?php echo $row_span;?>" > <?php echo $row['product_name'];?> </td>
                                                <td align="right" rowspan="<?php echo $row_span;?>" > <?php echo $row['production_qty'];?> </td>
                                                <?php 
                                                $production_qty_sum += $row['production_qty'];
                                                } ?>
                                                <td> <?php
                                                $micron_name = (@$row['mc_name']!='')?'('.@$row['mc_name'].')':'';
                                                 echo $row['packing_name']. ''.$micron_name;?> </td>
                                                <td align="right"> <?php echo $row['pm_qty'];?> </td>
                                                <td align="right"> <?php $estimated = qty_format(get_consumption_per_product($row['product_id'],$row['production_qty'],$row['pm_id'],$row['consumption_per_unit'],$row['mic_id']),3);
                                                echo $estimated;
                                                ?></td>
                                                <?php
                                                 if($estimated !=$row['pm_qty'])
                                                 { ?>
                                                        <td>  <span class="label label-danger">Not Ok</span></td>
                                           <?php }
                                                 else
                                                 { ?>
                                                        <td> <span class="label label-success"> Ok</span></td>
                                            <?php }

                                               ?>
                                            </tr>
                                        <?php  $count= 1;
                                            $consumed_qty_sum += $row['pm_qty']; 
                                            $estimated_qty_sum += $estimated; 
                                         }
                                    } ?>
                                    <tr>
                                                <td colspan="3" > Total </td>
                                                <td align="right"> <?php echo $production_qty_sum;?></td>
                                                <td> </td>
                                                <td align="right"><?php echo $consumed_qty_sum;?> </td>
                                                <td align="right"><?php echo $estimated_qty_sum;?> </td>
                                                <?php 
                                                 if($consumed_qty_sum !=$estimated_qty_sum)
                                                 { ?>
                                                        <td>  <span class="label label-danger">Please Check</span></td>
                                           <?php }
                                                 else
                                                 { ?>
                                                        <td> <span class="label label-success"> Success</span></td>
                                            <?php }
                                                ?>

                                     </tr>
                                    <?php

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
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer',$nestedView); ?>
<script type="text/javascript">
$(document).on("change","#product_id",function() {   
    var product_id = $('#product_id').val();
    if(product_id!=''){
        $.ajax({
            type: "POST",
            url: SITE_URL+"Ajax_ci/ajax_get_pms_by_product",
            data:'product_id='+product_id,
            success: function(data){      
            $("#pm_id").html(data);
             }
        });
    }
    else
    {
        $.ajax({
            type: "POST",
            url: SITE_URL+"Ajax_ci/ajax_get_pms_by_product",
            data:'product_id='+product_id,
            success: function(data){      
            $("#pm_id").html(data);
             }
        });
    }
    
});

</script>