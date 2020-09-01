<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                <form class="form-horizontal" method="post" action="<?php echo SITE_URL;?>insert_distributor_ob_products">
                	<input type="hidden" name="distributor_id" value="<?php echo $distributor_id; ?>">
                	<input type="hidden" name="distributor_name" value="<?php echo $agency_name; ?>">
                	<input type="hidden" name="lifting_point" value="<?php echo $stock_lifting_unit_id; ?>">
                	<input type="hidden" name="lifting_point_name" value="<?php echo $lifting_point_name; ?>">
                	<input type="hidden" name="ob_type_id" value="<?php echo $ob_type_id; ?>">
                	<input type="hidden" name="items_per_carton" value="<?php echo $ob_type_id; ?>">
                	<div class="col-md-offset-1 col-md-10">
                		<h3 class="text-primary">Andhra Pradesh Cooperative Oil Seeds Growers Federation Limited</h3>
                	</div>
                	<div class="col-md-offset-5 col-md-6">
                		<h4><b>Order Booking</b></h4><br>
                	</div>
                	<div class="col-md-offset-1 col-md-10 padding">
                        <div class="col-md-12">
	                    <div class="col-md-6">
	                     	<div class="form-group padding">
	                            <label class="col-md-4 control-label">Agency</label>
	                            <div class="col-md-8">
	                                <p class="form-control-static"><b><?php echo $agency_name."(" .$distributor_code.")"; ?></b></p>
	                            </div>
	                        </div>
	                    </div>
	                     <div class="col-md-6">
	                     	<div class="form-group padding">
	                            <label class="col-md-4 control-label">Order Type</label>
	                            <div class="col-md-8">
	                                <p class="form-control-static"><b><?php echo $ob_type; ?></b></p>
	                            </div>
	                        </div>
	                    </div>
                        </div>
                        <div class="col-md-12">
	                    <div class="col-md-6">
	                     	<div class="form-group padding">
	                            <label class="col-md-4 control-label">OB No</label>
	                            <div class="col-md-8">
                                    <?php $order_number = get_distributor_ob_number();?>
	                               <input type="hidden" name="order_number" value="<?php echo @$order_number; ?>">
                                   <p class="form-control-static"><b><?php echo @$order_number; ?></b></p>
	                            </div>
	                        </div>
	                    </div>	                    
	                     <div class="col-md-6">
	                     	<div class="form-group padding">
	                            <label class="col-md-4 control-label">Lifting Point</label>
	                            <div class="col-md-8">
	                                <p class="form-control-static"><b><?php echo $lifting_point_name; ?></b></p>
	                            </div>
	                        </div>
	                    </div>
                        </div>
                        <div class="col-md-12">
	                    <div class="col-md-6">
	                     	<div class="form-group padding">
	                            <label class="col-md-5 control-label">Agency Address</label>
	                            <div class="col-md-7">
	                                <p class="form-control-static"><b><?php echo $distributor_address; ?></b></p>
	                            </div>
	                        </div>
	                    </div>
                        </div>
                    </div>
                    <div class="col-md-offset-1 col-md-10">
                    <div class="table-scrollable">
                        <table class="table table-bordered"> 
                        <thead style="background-color:#cccfff">
                        	<td>S No</td>
                        	<td>Product Name</td>
                        	<td>Unit Price</td>
                        	<td>Quantity</td>
                        	<td>Total Amount</td>
                        </thead>
                        <tbody>
                        <?php $sno=1;
                        //print_r($value['products']);exit;	
                        foreach($product_results as $keys =>$values)
                        {  

                            if($values['quantity']>0)
                            {
                            ?>
                                <input type="hidden" name="product_id[<?php echo $values['product_id']; ?>]" value="<?php echo $values['product_id']; ?>">
                                <input type="hidden" name="unit_price[<?php echo $values['product_id']; ?>]" value="<?php echo $values['unit_price']; ?>">
                                <input type="hidden" name="added_price[<?php echo $values['product_id']; ?>]" value="<?php echo $values['added_price']; ?>">
                                <input type="hidden" name="total_price[<?php echo $values['product_id']; ?>]" value="<?php echo $values['total_price']; ?>">
                                <input type="hidden" name="items_per_carton[<?php echo @$values['product_id']?>]" value="<?php echo @$values['items_per_carton']; ; ?>">
                                <input type="hidden" name="quantity[<?php echo @$values['product_id']?>]" value="<?php echo @$values['quantity'] ?>">
                                <input type="hidden" name="distributor_id" value="<?php echo @$distributor_id; ?>">
                                <input type="hidden" name="stock_lifting_unit_id" value="<?php echo @$stock_lifting_unit_id; ?>">
                                
                            	<tr>
                            		<td><?php echo $sno++; ?></td>
                            		<td><?php echo $values['product_name']; ?></td>
                            		<td align="right"><?php echo price_format($values['unit_price']+$values['added_price']); ?></td>
                            		<td align="right"><?php echo price_format($values['quantity']); ?></td>
                            		<td align="right"><?php echo price_format(($values['total_value'])); ?></td>
                            	</tr>
                        	<?php 
                            }
                        } ?>
                        </tbody>
                    </table>
                    </div>
                </div>
                        </br>
                        <div >
                            <div class="row">
                                <div class="col-md-offset-5 col-md-4">
                                     <button type="submit" class="btn blue tooltips" onclick="return confirm('Are you sure you want to Place Order?')" name="submit" value="Submit">Place Order</button>
                                     <a href="<?php echo SITE_URL.'distributor_ob';?>" class="btn default">Cancel</a>

                               </div>
                            </div>
                            </form>
                       </div><br>
                    </form>
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->

<?php $this->load->view('commons/main_footer', $nestedView); ?>
