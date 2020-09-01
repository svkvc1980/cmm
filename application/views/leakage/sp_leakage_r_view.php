<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                	<form role="form" class="form-horizontal" method="post" action="<?php echo SITE_URL;?>sp_leakage_r">
                        <div class="row">
                            <div class="col-sm-3">
                                <select name="product" class="form-control product" > 
                                    <option value="">-Select Leaked Product-</option>
                                        <?php 
                                        foreach($product as $row)
                                        {   
                                            $selected = (@$search_data['product_id'] == $row['product_id'])?'selected':'';
                                            echo '<option value="'.$row['product_id'].'"'.$selected.'>'.$row['product_name'].'</option>';
                                        }?>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select name="loose_oil" class="form-control loose_oil" > 
                                    <option value="">-Select Loose Oil-</option>
                                        <?php 
                                        foreach($loose_oil as $row)
                                        {   
                                            $selected = ($row['loose_oil_id'] == @$search_data['loose_oil_id'])?'selected':'';
                                            echo '<option value="'.$row['loose_oil_id'].'"'.$selected.'>'.$row['name'].'</option>';
                                        }?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group date-picker input-daterange " data-date-format="dd-mm-yyyy">
                                    <input class="form-control" name="from_date" placeholder="From Date" type="text" value="<?php if(@$search_data['from_date']!=''){ echo @date('d-m-Y',strtotime($search_data['from_date'])); }?>" >
                                        <span class="input-group-addon"> to </span>
                                    <input class="form-control" name="to_date" data-date-format="dd-mm-yyyy" placeholder="To Date" type="text" value="<?php if(@$search_data['to_date']!=''){ echo @date('d-m-Y',strtotime($search_data['to_date'])); }?>">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" name="serach_leakage" value="1" class="btn blue tooltips btn-sm" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i> </button>
                                <button name="reset" value="" class="btn blue tooltips btn-sm" data-container="body" data-placement="top" data-original-title="Reset"><i class="fa fa-refresh"></i></button>
                                <button type="submit" name="print_ops_leakage" value="1" formaction="<?php echo SITE_URL.'print_ops_leakage';?>" class="btn btn-danger tooltips btn-sm" data-container="body" data-placement="top" data-original-title="Print"><i class="fa fa-print"></i></button>
                            </div>
                        </div>
                    </form>
	                <div class="table-scrollable">
		                                      <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>S.No</th>
                                    <th>Product</th>
                                    <th> Date </th>
                                    <th>Leaked Cartons</th>
                                    <th>Leaked Pouches</th>
                                    <th>Oil Recovered(Kgs)</th>
                                    <th>Recovered Cartons</th>
                                    <th>Oil Loss(Kgs)</th>
                                    <th>Amount Loss</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if($sp_leakage_reports)
                                { 
                                    foreach ($sp_leakage_reports as $row) 
                                    {  $oil_loss=(($row['leaked_pouches']*$row['oil_weight'])-$row['oil_recovered']);
                                       $loss_amount=($oil_loss*(($latest_price_details[$row['product_id']]['old_price'])/$row['oil_weight'])); ?>
                                        <tr>
                                            <td><?php echo $sn++?></td>
                                            <td><?php echo $row['product']?></td>
                                            <td><?php echo date('d-m-Y',strtotime($row['on_date']));?></td>
                                            <td align="right"><?php echo $row['leakage_quantity']?></td>
                                            <td  align="right"><?php echo $row['leaked_pouches']?></td>
                                             <td  align="right"><?php echo qty_format($row['oil_recovered'])?></td>
                                            <td  align="right"><?php echo $row['recovered_quantity']?></td>
                                            <td  align="right"><?php echo qty_format($oil_loss) ; ?></td>
                                           
                                            <td  align="right"><?php echo price_format($loss_amount) ; ?></td>
                                            
                                        </tr>
                                <?php }
                                }
                                else 
                                {
                                ?>  
                                    <tr><td colspan="8" align="center"><span class="label label-primary">No Records</span></td></tr>
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
<?php $this->load->view('commons/main_footer', $nestedView); ?>