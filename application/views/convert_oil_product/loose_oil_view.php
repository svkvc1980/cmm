<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN BORDERED TABLE PORTLET-->
			<div class="portlet light portlet-fit">
				<div class="portlet-body">
					<?php
					if($flag==1)
					{
						?>
						<form method="post" action="<?php echo $form_action;?>" class="form-horizontal" id="form">
							<div class="form-group">
                                    <label class="col-md-5 control-label">Loose oil <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-3">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <select name="loose_oil" class="form-control area"> 
												<option value="">-Select Loose Oil-</option>
												<?php
													foreach($loose_oil as $id=>$name)
													{
														
														echo '<option value="'.$id.'"  >'.$name.'</option>';
													} ?>
											</select>
                                        </div>
                                    </div>
                            </div>
	                        <div class="form-actions">
		                        <div class="row">
		                            <div class="col-md-offset-5 col-md-6">
		                                <button type="submit" class="btn blue">Submit</button>
		                                <a href="<?php echo SITE_URL;?>" class="btn default">Back</a>
		                            </div>
		                        </div>
		                    </div>
						</form> <?php
					}
					if($flag==2)
					{
						?>
						 <form method="post" action="<?php echo $form_action;?>" class="form-horizontal" id="oil_recover"> 
							<input type="hidden" name="encoded_id" value="<?php echo cmm_encode($loose_oil_id);?>" id="form">
							<div class="col-md-12">
								<div class="col-md-5">
									<div class="form-group">
										<label class="col-md-5 control-label">Oil Name:</label>
										<div class="col-md-7">
											<b class="form-control-static"><?php echo  $loose_oil_name;?></b>
											<input type="hidden" name="loose_oil_id" value="<?php echo @$loose_oil_id;?>">
											<input type="hidden" name="loose_oil_name" value="<?php echo @$loose_oil_name;?>">
	                                    </div>
	                                </div>
	                            </div>
	                            <div class="col-md-7">
	                                <div class="form-group">
									    <label class="col-md-4 control-label">Oil Quantity(kg):</label>
										<div class="col-md-6">
											<b class="form-control-static"><?php echo  $quantity;?></b>
											<input type="hidden" name="quantity" value="<?php echo @$quantity;?>" class="quantity">
	                                    </div>
	                                </div>
	                            </div>
                            </div>
                            <div class="col-md-12 invoice_number">
	                            <div class="col-md-5">
									<div class="form-group">
		                                <label class="col-md-5 control-label mytext">Product<span class="font-red required_fld">*</span></label>
		                                <div class="col-md-7 mytext ">
		                                    <div class="input-icon right">
		                                     	<i class="fa"></i>
		                                     	<select name="product[]" class="form-control product_id"> 
													<option value="">-Select Product-</option>
													<?php
														foreach($product as $row)
														{
															
															echo '<option value="'.$row['product_id'].'" data-oil-weight="'.@$row['oil_weight'].'" >'.$row['name'].'</option>';
														} ?>
												</select>
		                                    </div> 
		                                    <input type="hidden" value="" class="oil_wt_cls" name="oil_weight[]">                                    
		                                </div>
		                            </div>
		                        </div>
		                        <div class="col-md-7">
		                            <div class="form-group">
		                                <label class="col-md-4 control-label mytext">Item Quantity<span class="font-red required_fld">*</span></label>
		                                <div class="col-md-5 mytext ">
		                                    <div class="input-icon right">
		                                        <i class="fa"></i>
		                                        <input class="form-control type numeric" name="loose_type[]" maxlength="10" type="text">
		                                    </div>                                     
		                                </div>
		                                <div class="col-md-2 mybutton">
		                                    <a  class="btn blue tooltips add_invoice_info" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
		                                </div>
		                                <div class="col-md-2 deletebutton hide">
		                                    <a  class="btn btn-danger tooltips delete" data-container="body" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
		                                </div>
									</div>
								</div>
							</div>
							<div class="col-md-12">
								<div class="col-md-5">
									<div class="form-group">
									<label class="col-md-5 control-label">Remarks </label>
		                                <div class="col-md-7">
		                                    <div class="input-icon right">
		                                        <i class="fa"></i>
		                                        <textarea type="text" name="remarks" placeholder="Remarks..." class="col-md-6 form-control"></textarea>  
		                                    </div>  
		                                </div>
									</div>
								</div>
							</div>
							<div class="form-actions">
		                        <div class="row">
		                            <div class="col-md-offset-5 col-md-6">
		                                <button type="submit" class="btn blue validate_weight">Submit</button>
		                                <a href="<?php echo SITE_URL.'oil_product';?>" class="btn default">Cancel</a>
		                            </div>
		                        </div>
		                    </div>
						</form> <?php
					} 
					if($flag==3)
					{
						?>
						<form  method="post" action="<?php echo $form_action;?>" class="form-horizontal">
							<div class="row">
								<div class="col-md-5">
									<div class="form-group">
										<label class="col-md-4 control-label">Oil Name:</label>
										<div class="col-md-4">
											<b class="form-control-static"><?php echo  $loose_oil_name;?></b>
											<input type="hidden" name="loose_oil_name" value="<?php echo @$loose_oil_name;?>">
											<input type="hidden" name="loose_oil_id" value="<?php echo $loose_oil_id;?>">
                                        </div>
									</div>
								</div>
								<div class="col-md-5">
									<div class="form-group">
										<label class="col-md-4 control-label">Oil Quantity(kg):</label>
										<div class="col-md-6">
											<b class="form-control-static"><?php echo  $oil_quantity;?></b>
											<input type="hidden" name="quantity" value="<?php echo @$oil_quantity;?>">
                                        </div>
									</div>
								</div>
							</div>
							<div class="table-scrollable">
								<table class="table table-bordered table-striped table-hover">
									<thead>
	                                    <tr>
	                                        <th> S.No</th>
	                                        <th> Product Name </th>
	                                        <th> Item Quantity </th>
	                                        <th> Oil Weight(kg)</th>          
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                	<?php
	                                	$sn=1;
	                                	foreach($product as $row)
	                                	{
	                                		?>
	                                		<tr>
	                                			<input type="hidden" name="products[]" value="<?php echo $row['product_id']; ?>">
	                                			
	                                			<td> <?php echo @$sn++; ?></td>
	                                			<td> <?php echo @$row['product_name']; ?></td>
	                                			<td> 
	                                			<?php echo @$row['loose_item']; ?>
	                                			<input type="hidden" name="loose_items[<?php echo $row['product_id'] ?>]" value="<?php echo $row['loose_item']; ?>">
	                                			</td>
	                                			<td> <?php echo @$row['oil_weight']; ?></td>
	                                		</tr> <?php
	                                	} ?>
	                                	<tr>
	                                		<td colspan="4" align="right" style="padding-left:300px;">
		                                		<b class="form-control-static" >Total Oil Weight <?php echo  $total_oil_weight;?></b>
												<input type="hidden" name="total" value="<?php echo @$total_oil_weight;?>">
											</td>
										</tr>
	                                </tbody>
								</table>
							</div>
							<div class="form-actions">
	                            <div class="row">
	                                <div class="col-md-offset-5 col-md-4">
	                                    <button type="Process" value="Process" class="btn blue" name="bridge">Process</button>
	                                    <a href="<?php echo SITE_URL.'oil_product';?>" class="btn default">Cancel</a>
	                                </div>
	                            </div>
                        	</div>
						</form> <?php
					} ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('commons/main_footer', $nestedView); ?>