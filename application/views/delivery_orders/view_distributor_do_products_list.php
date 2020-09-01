<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="portlet light portlet-fit">
	   <div class="portlet-body">
	   		<form class="form-horizontal" method="" action="<?php echo SITE_URL.'print_distributor_ob_products';?>">
		   		<div class="row">	   			
			   		<div class="col-md-12">
			   			<div class="col-md-3">
							<div class="form-group">
								<label class="control-label col-xs-5">DO Number</label>								
								<div class="col-xs-4">
									<p class="form-control-static"><b><?php echo @$do_number; ?></b></p>
								</div>
							</div>
						</div>
						<div class="col-md-3">
						<div class="form-group">
							<label class="control-label col-xs-5">Order Type</label>								
							<div class="col-xs-6">
								<p class="form-control-static"><b><?php echo $order_details[0]['ob_type']; ?></b></p>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label col-xs-6">Distributor</label>								
							<div class="col-xs-6">
								<p class="form-control-static"><b><?php echo $order_details[0]['distributor_name']; ?></b></p>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label col-xs-5">Lifting Point</label>								
							<div class="col-xs-6">
								<p class="form-control-static"><b><?php echo $order_details[0]['lifting_point']; ?></b></p>
							</div>
						</div>
					</div>		   			
			   		</div>		   		
		   		</div>
		   		<div class="row">
			   		<div class="col-md-12">
				   		<div class="table-scrollable">
			                <table class="table table-bordered table-striped">
			                 <?php
			                 	$ggd=0;
			                 	$gt_total =0;
			                 	
                                foreach($do_results as $key => $value) 
                                { 
                                	$order_number =  $this->Common_model->get_value('order',array('order_id'=>$key),'order_number');
                                    
                                ?>
			                	<thead>
			                       <th colspan="6">Order Number: <?php echo $order_number; ?></td>
			                    </thead>
			                    <tr style="background-color:#cccfff">
			                        <th> S.No</th>
			                        <th> Product Name </th>
			                        <th> Quantity </th>
			                        <th> Unit Price </th>
			                        <th> Add Price </th>
			                        <th> Total Price</th>
			                    </tr>
			                    <tbody>
			                    	<?php 
			                    	$gt=0;
			                    	$grand_total=0;
			                    	$sno = 1; 
			                    	 foreach($value['do_orders'] as $keys =>$values) 
			                    	 { 
			                    	    if($values != '') 
                                        { 
	                                    	$total=0;
	                                    	
	                                    	@$distributor_order_product = $this->Delivery_order_m->get_distributor_ob_price_details($values['order_id'],$values['product_id']);
	                                    	?>
				                    		<tr>
				                    			<td><?php echo $sno++; ?></td>
				                    			<td><?php echo $values['product_name']; ?></td>
				                    			<td><?php echo $values['quantity']; ?></td>
				                    			<td><?php echo @$distributor_order_product[0]['unit_price']; ?></td>
				                    			<td><?php  echo @$distributor_order_product[0]['add_price']; ?></td>
				                    			<td><?php $total_price = @$distributor_order_product[0]['total_price'] * @$values['quantity'];
				                    			echo $total_price; 
				                    			?></td>
				                    		</tr>
			                    			<?php   
                                        }
                                           $total+=$total_price; 
                                           $gt+=$total;
                                    } 
                                           
                                           $gt_total+=$gt;
                                           $grand_total+=$gt_total; ?>
			                    		<tr><td colspan="6" align="right"><b>Total: <?php echo $gt; //echo indian_format_price($grand_total);?></b></td></tr>
			                    </tbody> <?php   
			                }  ?>
			                    <tr><td colspan="6" align="right"><b>Grand Total: <?php echo $grand_total;//echo indian_format_price($grand_total);?></b></td></tr>
			                </table>
			            </div>
			            <div class="col-xs-offset-5 col-md-6">
			            	<a  href="<?php echo SITE_URL.'print_distributor_do_products/'.cmm_encode(@$do_id)?>" class="btn btn-default tooltips" data-container="body" data-placement="top" data-original-title="Print Products"><i class="fa fa-print"></i> Print</a>
	                    	<a class="btn btn-primary" href="<?php echo SITE_URL.'distributor_do_list';?>">Back</a>
	                    	
	                	</div>
	            	</div>
	            </div>
            </form>
	   </div>
   </div>
</div>

<?php $this->load->view('commons/main_footer', $nestedView); ?>