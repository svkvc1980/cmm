<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="row">
        <!-- Distributor Details,Bank Guarantee and Product Price Details-->
        <form class="form-horizontal" action="<?php echo SITE_URL;?>submit_delivery_order" method="post">
            <input type="hidden" name="ob_type_id" value="<?php echo $ob_type_id;?>">
            <input type="hidden" name="distributor_id" value="<?php echo $distributor_id;?>">
            <input type="hidden" name="stock_lifting_unit_id" value="<?php echo $stock_lifting_unit_id;?>">
            <input type="hidden" name="lifing_point_name" value="<?php echo $lifting_point_name;?>">
            <input type="hidden" name="do_for" value="<?php echo @$do_for;?>">
            <div class="col-md-12">
                <div class="col-xs-6">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-map-marker"></i> Distributor Address </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                            </div>
                        </div>
                        <div class="portlet-body" style="display: block; height:248px;"> 
                            <div class="col-md-12">
                                <p><b>Agency Name</b> &nbsp; <?php echo $distributor_details[0]['agency_name'].' ('.$distributor_details[0]['distributor_code'].')'?></p>    
                            </div> 
                            <div class="col-sm-6">                              
                                <p><b>Mobile</b> &nbsp; 91+<?php echo $distributor_details[0]['mobile']?></p>   
                                <p><b>SD Amount</b> &nbsp; <?php echo ($distributor_details[0]['sd_amount'])?></p>
                                <p><b>Agreement Start</b> &nbsp; <?php echo date('d-m-Y',strtotime($distributor_details[0]['agreement_start_date']))?></p>   </div>
                            <div class="col-sm-6">                              
                                <p><b>Phone</b> &nbsp;  <?php echo $distributor_details[0]['landline']?></p>
                                <p><b>Total Outstanding</b> &nbsp; <?php echo (intval($distributor_details[0]['outstanding_amount']))?></p>
                                <p><b>Agreement Expire</b> &nbsp; <?php echo date('d-m-Y',strtotime($distributor_details[0]['agreement_end_date']))?></p>
                            </div>
                            <?php
                            if($do_for>0)
                            {
                            ?>
                            <div class="col-md-12" style="margin-top:10px;">
                                <b>DO in the name of: </b>
                                <?php
                                $do_distributor = get_distributor_details_by_id($do_for);
                                echo $do_distributor['agency_name'].' ['.$do_distributor['distributor_code'].'] ['.$do_distributor['distributor_place'].']';
                                ?>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-bank"></i> Bank Guarantee </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                            </div>
                        </div>
                        <div class="portlet-body">                           
                              <table class="table table-striped table-bordered table-hover order-column table-fixed" id="sample_1">
                                <thead style="display:table;table-layout:fixed;width:100%">
                                    <tr>
                                        <th> S.No</th>
                                        <th> Start Date </th>
                                        <th> Expire Date </th> 
                                        <th> Bank </th>
                                        <th> BG Amount </th>             
                                    </tr>
                                </thead>
                                <tbody style="display:block;height:80px;table-layout:fixed;overflow:auto">
                                <?php foreach($bank_guarantee_details as $row) { ?>
                                    <tr style="display:table;width:100%;table-layout:fixed">
                                        <td>1</td>
                                        <td><?php echo $row['start_date']; ?></td>
                                        <td><?php echo $row['end_date']; ?></td>
                                        <td><?php echo $row['bank_name']; ?></td>
                                        <td><?php echo ($row['bg_amount']); ?></td>
                                    </tr>                                   
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr style="display:table;width:100%;table-layout:fixed">
                                        <td colspan="5" align="right"><b>Total Amount:</b> &nbsp; <?php echo ($total_bg_amount) ?></td>
                                    </tr></tfoot>
                            </table>
                            <p align="right"><b>Available Amount:</b> &nbsp; <?php echo ($available_amount) ?></p>
                        </div> 
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                               <!--  <i class="fa fa-gift"></i> --> DO Products</div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"> </a>
                            </div>
                        </div>
                        <div class="portlet-body">  
                            <div class="row">
                            <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-xs-6 control-label">DO Number</label>
                                        <div class="col-xs-5">
                                            <p class="form-control-static"><b><?php echo $do_number; ?></b></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-xs-6 control-label">Delivery Order Date</label>
                                        <div class="col-xs-5">
                                            <p class="form-control-static"><b><?php echo date('d-m-Y'); ?></b></p>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-xs-5 control-label">Stock Lifting Point</label>
                                        <div class="col-xs-7">
                                            <p class="form-control-static"><b><?php echo $lifting_point_name; ?></b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-scrollable">
                                        <table class="table"> 
                                            <tr style="background-color:#cccfff">
                                                <td>S No</td>
                                                <td>Product Name</td>                                                
                                                <td>Price</td>
                                                <td>No of Cartons</td>
                                                <td>No of Packets</td>
                                                <td>Qty in Kgs</td>                                               
                                                <td>Amount</td>
                                            </tr>
                                            <tbody>
                                            <?php 
                                            $sno = 1;$total_amount = 0;
                                            foreach($do_products as $op_key => $dp_row)
                                            { 
                                                 ?>
                                                <input class="ob_product" name="order_product[]" value="<?php echo $dp_row['order_id']."_" . $dp_row['product_id']?>" type="hidden">
                                                <input type="hidden" class="price" name="price[<?php echo $dp_row['order_id']?>][<?php echo $dp_row['product_id']?>]" value="<?php echo $dp_row['price'];?>">
                                                <input type="hidden" class="items_per_carton" name="items_per_carton[<?php echo $dp_row['order_id']?>][<?php echo $dp_row['product_id']?>]" value="<?php echo $dp_row['items_per_carton']?>">
                                                <input type="hidden" name="ordered_qty[<?php echo $dp_row['order_id']?>][<?php echo $dp_row['product_id']?>]" value="<?php echo @$dp_row['ordered_qty']?>">
                                                <input type="hidden" name="pending_qty[<?php echo $dp_row['order_id']?>][<?php echo $dp_row['product_id']?>]" value="<?php echo @$dp_row['pending_qty']?>">
                                                <input type="hidden" name="lifting_qty[<?php echo $dp_row['order_id']?>][<?php echo $dp_row['product_id']?>]" value="<?php echo @$dp_row['lifting_qty']?>">
                                                <tr class="do_row">
                                                    <td>
                                                        <?php echo $sno++?>
                                                    </td>
                                                    <td><?php echo $dp_row['product_name']; ?></td>
                                                    <td><?php echo price_format($dp_row['price']); ?></td>
                                                    <td><?php echo $dp_row['lifting_qty']; ?></td>
                                                    <td>
                                                        <?php 
                                                        $total_items = $dp_row['lifting_qty']*$dp_row['items_per_carton']; 
                                                        echo $total_items;
                                                        ?>
                                                    </td>
                                                    <td><?php echo $total_items*$dp_row['oil_weight']; ?></td>
                                                    <td>
                                                        <?php 
                                                        $amount = $total_items*$dp_row['price'];
                                                        echo price_format($amount); 
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php
                                                $total_amount += $amount;
                                            }
                                            ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="6" align="right"><strong>Total Amount</strong></td>
                                                    <td><?php echo price_format($total_amount);?></td>
                                                </tr>
                                                <tr>
                                                    <td colspan="6" align="right"><strong>Current Available Balance</strong></td>
                                                    <td><?php echo price_format(($available_amount - $total_amount));?>
                                                        <input type="hidden" name="gd_total" value="<?php echo price_format(($available_amount - $total_amount));?>" >
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-offset-5 col-md-5">
                                    <button type="submit" name="proceed_do" class="btn btn-success" onclick="return confirm('Are you sure you want to Place D.O?')" value="1">Place D.O</button>
                                    <a href="<?php echo SITE_URL.'delivery_order';?>" class="btn default">Cancel</a>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>  
        </div>
        </form>
    </div>
</div>

<?php $this->load->view('commons/main_footer', $nestedView); ?>