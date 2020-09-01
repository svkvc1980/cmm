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
							<label class="control-label col-xs-6">DO Number :</label>								
							<div class="col-xs-6">
								<p class="form-control-static"><b><?php echo $do_details['do_number']; ?></b></p>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label col-xs-5">DO Date :</label>								
							<div class="col-xs-6">
								<p class="form-control-static"><b><?php echo date('d-m-Y',strtotime($do_details['do_date'])); ?></b></p>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label col-xs-5">Order For :</label>								
							<div class="col-xs-7">
								<p class="form-control-static"><b><?php echo $do_details['order_for']; ?></b></p>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label col-xs-5">Lifting Point:</label>								
							<div class="col-xs-6">
								<p class="form-control-static"><b><?php echo $do_details['lifting_point_name']; ?></b></p>
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
		                        <th> Pending Qty </th>
		                        <th> Invoiced Qty </th>
		                        <th> Unit Price </th>
		                        <th> Add Price </th>
		                        <th> Total Price</th>
		                    </thead>
		                    <tbody>
		                    	<?php $sn = 1; $grand_total = 0;
		                    	 foreach($do_products as $row) 
		                    	{ ?>
	                    	 		<tr>
		                    			<td><?php echo $sn++; ?></td>
		                    			<td><?php echo $row['product_name']; ?></td>
		                    			<td><?php echo round($row['pending_qty']).' (c)'; ?></td>
		                    			<td><?php echo round($row['raised_qty']).' (c)'; ?></td>
		                    			<td><?php echo $row['unit_price']; ?></td>
		                    			<td><?php echo $row['add_price']; ?></td>
		                    			<td><?php echo round($row['total_price'],2); ?></td>
		                    			<?php $grand_total+= $row['total_price'];?>
	                    			</tr>
	                    			
		                    	<?php 
		                    		} ?>
		                    	<tr><td colspan="7" align="right"><b>Total Price: <?php echo $grand_total;?></b></td></tr>
							</tbody>
		                </table>
		            </div>
		            <div class="col-xs-offset-5 col-md-6">   
		            	               	
                    	<a class="btn btn-default" href="<?php echo SITE_URL.'print_plant_do_products'.'/'.cmm_encode($lifting_point_id).'/'.cmm_encode($do_number);?>"><i class="fa fa-print"></i> Print</a>
                    	<a class="btn btn-primary" href="<?php echo SITE_URL.'plant_do_list';?>">Back</a> 
                	</div>
            	</div>
            </div>
	   </div>
   </div>
</div>

<?php $this->load->view('commons/main_footer', $nestedView); ?>