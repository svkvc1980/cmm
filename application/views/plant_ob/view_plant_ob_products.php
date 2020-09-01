<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="portlet light portlet-fit">
	   <div class="portlet-body">
	   		<div class="row">
	   			<form class="form-horizontal" method="" action="">
			   		<div class="col-md-12">
			   			<div class="col-md-3">
							<div class="form-group">
								<label class="control-label col-xs-6">Order No</label>								
								<div class="col-xs-6">
									<p class="form-control-static"><b><?php echo $order_details[0]['order_number']; ?></b></p>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label col-xs-5">Order Date</label>								
								<div class="col-xs-6">
									<p class="form-control-static"><b><?php echo $order_details[0]['order_date']; ?></b></p>
								</div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								<label class="control-label col-xs-6">Order For</label>								
								<div class="col-xs-6">
									<p class="form-control-static"><b><?php echo $order_details[0]['order_for_plant']; ?></b></p>
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
		   		</form>
	   		</div>
	   		<div class="row">
		   		<div class="col-md-12">
			   		<div class="table-scrollable">
		                <table class="table table-bordered table-striped table-hover">
		                    <thead>
		                        <th> S.No</th>
		                        <th> Product Name </th>
		                        <th> Quantity </th>
		                        <th> Unit Price </th>
		                        <th> Add Price </th>
		                        <th> Total Price</th>
		                    </thead>
		                    <tbody>
		                    	<?php $sn = 1;
		                    	 foreach($orderd_product_details as $row) { ?>
		                    		<tr>
		                    			<td><?php echo $sn++; ?></td>
		                    			<td><?php echo $row['product_name']; ?></td>
		                    			<td align="right"><?php echo round($row['quantity']); ?></td>
		                    			<td align="right"><?php echo price_format($row['unit_price']); ?></td>
		                    			<td align="right"><?php echo price_format($row['add_price']); ?></td>
		                    			<td align="right"><?php echo price_format($row['total_price']);  ?></td>
		                    		</tr>
		                    	<?php } ?>
		                    		<tr><td colspan="6" align="right"><b>Total Price: <?php echo price_format($grand_total);?></b></td></tr>
		                    </tbody>
		                </table>
		            </div>
		            <div class="col-xs-offset-5 col-md-6">                    	
                    	<a class="btn btn-default" href="<?php echo SITE_URL.'print_plant_ob_products'.'/'.cmm_encode(@$order_id).'/'.cmm_encode(@$order_number);?>"><i class="fa fa-print"></i> Print</a>
                    	<a class="btn btn-primary" href="<?php echo SITE_URL.'plant_ob_list';?>">Back</a> 
                	</div>
            	</div>
            </div>
	   </div>
   </div>
</div>

<?php $this->load->view('commons/main_footer', $nestedView); ?>