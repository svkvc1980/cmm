 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                
                <div class="portlet-body">                    
                        
                    <div class="table">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <td> Product <br> Type of Pack</td>
                                    <td> Opening Stock</td>
                                    <td> Production </td>
                                    <td> Invoices </td>
                                    <td> Closing Balance</td>
                                </tr>
                                <?php 
                                foreach ($loose_oils as $loose_oil_id => $loose_oil_name)
                                {?> 
                                    <tr><td colspan="5"><?php echo $loose_oil_name;?></td></tr>
                                    <?php
                                         $t_opening_stock = 0;$t_production = 0;$t_invoice =0 ; $t_closing_stock =0;
                                    foreach ($daily_report[$loose_oil_id] as $product_id => $values)
                                    { ?>
                                        <tr>
                                            <td> <?php echo get_product_name($product_id);?></td>
                                            <td> <?php echo $values['opening'];?></td>
                                            <td> <?php echo $values['production'];?> </td>
                                            <td> <?php echo $values['invoice'];?> </td>
                                            <td> <?php echo $values['closing_balance'];?></td>
                                        </tr>
                                        
                                <?php 
                                        //$t_qty_in_kg += ($values['opening']*get_items_per_carton($product_id)*get_oil_weight($product_id));
                                        $t_opening_stock += ($values['opening']*get_items_per_carton($product_id)*get_oil_weight($product_id));
                                        $t_production +=($values['production']*get_items_per_carton($product_id)*get_oil_weight($product_id));
                                        $t_invoice += ($values['invoice']*get_items_per_carton($product_id)*get_oil_weight($product_id));
                                        $t_closing_stock += ($values['closing_balance']*get_items_per_carton($product_id)*get_oil_weight($product_id)); 

                                } ?>
                                <tr>
                                    <td>Qty in Kg </td>                                    
                                    <td><?php echo $t_opening_stock;?></td>
                                    <td><?php echo $t_production;?></td>
                                    <td><?php echo $t_invoice;?></td>
                                    <td><?php echo $t_closing_stock;?></td>
                                </tr>

                                <?php
                                }

                                ?>
                            </thead>
                            <tbody>
                            
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>
