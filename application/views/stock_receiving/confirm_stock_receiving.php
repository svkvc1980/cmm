<?php $this->load->view('commons/main_template', $nestedView);  ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
             <form id="ob_form" method="post" action="<?php echo SITE_URL.'insert_products_free_gifts';?>" class="form-horizontal">
                <div class="col-md-12">
             		<div class="portlet light portlet-fit">                
        				<div class="portlet-body">
	        				<div class="row">
	        					<div class="padding"> 
		        					<div class="col-md-12">
			        					<div class="col-md-4">
			        						<div class="form-group">
					                            <label class="col-sm-5 control-label">SRN No</label>
					                            <div class="col-sm-7">
					                            	<input type="text" name="srn_number" class="form-control" value="<?php echo get_current_serial_number(array('value'=>'srn_number','table'=>'stock_receipt','where'=>'on_date')); ?>" readonly>
					                            </div>
				                        	</div>
			        					</div>			        					
			        					<div class="col-md-3">
			        						<div class="form-group">
					                            <label class="col-sm-4 control-label">Date</label>
					                            <div class="col-sm-8">
					                            	<input type="text" name="srn_number" class="form-control" value="<?php echo date('d-m-Y') ?>" readonly>
					                            </div>
				                        	</div>
			        					</div>
			        					<div class="col-md-4">
			        						<div class="form-group">
					                            <label class="col-sm-5 control-label">Vehicle No</label>
					                            <div class="col-sm-7">
					                            	<input type="text" name="vehicle_number" required class="form-control" value="">
					                            </div>
				                        	</div>
			        					</div>
		        					</div>
		        				</div>
		        				</div><br>
		        				<div class="row">	        					
		        					<div class="col-md-12">
		        						<table class="table table-bordered" cellpadding="0" border="0" align="center" cellspacing="0" style="width:90%" >
											<?php foreach($products_free_gift_results as $invoice_id=>$value){ 
													?>
											
											<thead>
												<input type="hidden" name="invoice_id[]" value="<?php echo $invoice_id ?>">
								       			<th colspan="6">Invoice Number:<?php echo $invoice_number[$invoice_id]; ?></th>
								    		</thead>
								    		<tr style="background-color:#ccc">
								    			<td colspan="5" align="center"><b>Products</b></td>
								    		</tr>
								    		<tr style="background-color:#fafafa">
										        <td> S.No</td>
										        <td> Product Name </td>
										        <td> Invoice Qty</td>
										        <td> Received Pouches </td>
										        <td> Shortage </td>
										    </tr>
										    <tbody>
										        <?php 
										        $sno = 1;
										        
										         foreach(@$value['all_products'] as $invoice_do_product_id =>$values) 
										         {  
										            if($values != '') 
										            { 
										            	?>	
										            	<input type="hidden" name="invoice_do_product_ids[<?php echo $invoice_id ?>][]" value="<?php echo $invoice_do_product_id ?>">							        		
										                <tr class="do_row">
										                	<input type="hidden" name="items_per_carton_arr[<?php echo $invoice_do_product_id;?>]" value="<?php echo $values['items_per_carton']; ?>">
										                    <td><?php echo $sno++; ?></td>
										                    <td>
										                    	<?php echo $values['product_name']; ?>
										                    	<input type="hidden" name="invoice_product_ids[<?php echo $invoice_do_product_id;?>]" value="<?php echo @$values['product_id']?>">								                    	
										                    </td>
										                    <td>
										                    	<?php echo   intval($values['invoice_qty'])*$values['items_per_carton'].'P  '.'('.intval($values['invoice_qty']).'C)'; ?>
										                    	<input type="hidden" class="invoice_qty" name="product_invoice_qty[<?php echo $invoice_do_product_id;?>]" value="<?php echo @intval($values['invoice_qty']) ?>">
										                    </td>
										                    <td>
										                    	<span class="received_quantity"><?php echo $values['received_qty']." P";?></span>								                    	
										                    	<input type="hidden"  name="product_received_qty[<?php echo $invoice_do_product_id;?>]" value="<?php echo $values['received_qty']?>">								                    	 
										                    </td> 
										                    <td style="width:15%;">								                    	
										                    	<span><?php 
										                    	$shortage_val = ($values['shortage']>0)?$values['shortage']:0;
										                    	echo $shortage_val." P";?></span>
										                    	<input type="hidden"  name="invoice_product_shortage[<?php echo $invoice_do_product_id;?>]" value="<?php echo $shortage_val;?>">
										                    </td>								                    
										                </tr>
										                <?php   
										            }
										        }
										        ?> 								              
										    </tbody>
										    <?php if(count(@$value['free_gifts']) !='' || count(@$value['free_products']) != '') { ?>
								    		<tr style="background-color:#ffdccc">
								    			<td colspan="5" align="center"><b>Free Gifts</b></td>
								    		</tr>
								    		<tr style="background-color:#fafafa">
										        <td> S.No</td>
										        <td> Product Name </td>
										        <td> Invoice Qty</td>
										        <td> Received Pouches </td>
										        <td> Shortage </td>
										    </tr>
										    <tbody>
									        <?php $sn = 1;
									         foreach(@$value['free_gifts'] as $keys =>$values) 
									         { 
									            if($values != '') 
									            { ?>								        	
									                <tr class="do_row">
									                    <td><?php echo $sn++; ?></td>
									                    <td><?php echo $values['product_name']; ?>
									                    </td>
									                    <td>
									                    	<?php echo intval($values['invoice_qty']); ?>
									                    	<input type="hidden" name="free_gift_fg_scheme_id[<?php echo $invoice_id ?>][<?php echo $values['product_id'] ?>]" value="<?php echo @$values['fg_scheme_id']?>">
									                    	<input type="hidden" name="free_gift_invoice_qty[<?php echo $invoice_id ?>][<?php echo $values['product_id'] ?>]" value="<?php echo @$values['invoice_qty']?>">
									                    </td>
									                    <td>
									                    	<span class="received_quantity"><?php echo $values['received_qty'];?></span>
									                    	<input type="hidden" id="received_quantity" name="free_gift_received_qty[<?php echo $invoice_id ?>][<?php echo $values['product_id']?>]" value="<?php echo $values['received_qty'];?>"> 								                    	 								                    	
									                    </td> 
									                    <td style="width:15%;">								                    	
									                    	<span><?php 
									                    	$shortage_val = ($values['shortage']>0)?$values['shortage']:0;
									                    	echo $shortage_val;?></span>
									                    	<input type="hidden"  name="free_gift_shortage[<?php echo $invoice_id ?>][<?php echo $values['product_id']?>]" value="<?php echo $shortage_val;?>">
									                    </td>
									                </tr>
									                <?php   
									            }
									        } ?>
									        <?php 
									         foreach(@$value['free_products'] as $keys =>$values) 
									         { 
									            if($values != '') 
									            { ?>
									        		<input type="hidden" name="free_product_items_per_carton[<?php echo $invoice_id ?>][<?php echo $values['product_id'] ?>]" value="<?php echo @$values['items_per_carton']?>">
									                <tr class="do_row">
									                    <td><?php echo $sn++; ?></td>
									                    <td><?php echo $values['product_name']; ?>
									                    </td>
									                    <td>
									                    	<?php echo intval($values['invoice_qty']); ?>
									                    	<input type="hidden" name="free_product_fg_scheme_id[<?php echo $invoice_id ?>][<?php echo $values['product_id'] ?>]" value="<?php echo @$values['fg_scheme_id']?>">
									                    	<input type="hidden" name="free_product_invoice_qty[<?php echo $invoice_id ?>][<?php echo $values['product_id'] ?>]" value="<?php echo @$values['invoice_qty'] ?>">
									                    </td>
									                    <td>
									                    	<span class="received_quantity"><?php echo $values['received_qty']." P";?></span>
									                    	<input type="hidden" name="free_product_received_qty[<?php echo $invoice_id ?>][<?php echo $values['product_id']?>]" value="<?php echo $values['received_qty']?>">								                    	 								                    	
									                    </td> 
									                    <td style="width:15%;">								                    	
									                    	<span><?php 
									                    	$shortage_val = ($values['shortage']>0)?$values['shortage']:0;
									                    	echo $shortage_val." P";?></span>
									                    	<input type="hidden"  name="shortage[<?php echo $invoice_id ?>][<?php echo $values['product_id']?>]" value="<?php echo $shortage_val;?>">
									                    </td>
									                </tr>
									                <?php   
									            }
									        }
									        	 }  ?> 
								              
								    	</tbody>
								    	 <br>
								     <?php if(count(@$value['packing_material']) !='') { ?>
								    		<tr style="background-color:#ffdccc">
								    			<td colspan="5" align="center"><b>Packing Material</b></td>
								    		</tr>
								    		<tr style="background-color:#fafafa">
										        <td> S.No</td>
										        <td> Packing Material </td>
										        <td> Invoice Qty</td>
										        <td> Received Qty</td>
										        <td> Shortage </td>
										    </tr>
										    <tbody>
									        <?php $sn = 1;
									         foreach(@$value['packing_material'] as $keys =>$values) 
									         { 
									            if($values != '') 
									            { ?>								        	
									                <tr class="do_row">
									                    <td><?php echo $sn++; ?></td>
									                    <td><?php echo $values['product_name']; ?>
									                    </td>
									                    <td>
									                    	<?php echo TrimTrailingZeroes($values['invoice_qty']).' '.$values['pm_unit']; ?>
									                    	<input type="hidden" name="invoice_qty[<?php echo $invoice_id ?>][<?php echo $values['pm_id'] ?>]" value="<?php echo TrimTrailingZeroes(@$values['invoice_qty'])?>">
									                    	<input type="hidden" name="pm_id[<?php echo $invoice_id ?>][<?php echo $values['pm_id'] ?>]" value="<?php echo @$values['pm_id']?>">
									                    </td>
									                    <td> <?php 
									                    	$shortage_val = ($values['shortage']>0)?$values['shortage']:0;
									                    	echo TrimTrailingZeroes($values['invoice_qty']-$shortage_val).' '.$values['pm_unit']; ?></td>
									                   
									                    <td style="width:15%;">								                    	
									                    	<span><?php 
									                    	
									                    	echo $shortage_val;?></span>
									                    	<input type="hidden"  name="pm_shortage[<?php echo $invoice_id ?>][<?php echo $values['pm_id']?>]" value="<?php echo $shortage_val;?>">
									                    </td>
									                </tr>
									                <?php   
									            }
									        } } } ?>
								        </tbody> 
								    	
							    		</table>
		        					</div>
		        					</div>		        					
		        					<?php 
		        					if(isset($shortage_div))
		        					{ ?><hr>
		        						<div class="col-md-12">
				        					<div class="col-md-6">
				        						<div class="form-group">
						                            <label class="col-sm-5 control-label">Transporter Name</label>
						                            <div class="col-sm-7">
						                            	<input type="text" class="form-control" name="transporter_name" required>
						                            </div>
					                        	</div>
				        					</div>
				        					<div class="col-md-6">
				        						<div class="form-group">
						                            <label class="col-sm-5 control-label">LR Number</label>
						                            <div class="col-sm-6">
						                            	<input type="text" class="form-control" name="lr_number" required>
						                            </div>
					                        	</div>
				        					</div>
				        					<div class="col-md-6">
				        						<div class="form-group">
						                            <label class="col-sm-5 control-label">Remarks</label>
						                            <div class="col-sm-7">
						                            	<textarea class="form-control" name="remarks" required></textarea>
						                            </div>
					                        	</div>
				        					</div>
				        					<div class="col-md-6">
				        						<div class="form-group">
						                            <label class="col-sm-5 control-label">LR Date</label>
						                            <div class="col-sm-6">
						                            	<p class="form-control-static"><b><?php echo date('d-m-Y'); ?></b></p>
						                            </div>
					                        	</div>
				        					</div>
		        						</div>
		        			 <?php  } ?>
	                			</div>
	                			
	                			<div class="form-group">								
									<div class="col-xs-offset-5 col-xs-5">
										<button type="submit" name="search_ob" value="1" class="btn blue tooltips">Submit</button>
		                                <a type="submit" href="<?php echo SITE_URL.'stock_receiving';?>" class="btn default tooltips">Back</a>
									</div>
								</div><br>
	        				</div>
        				</div>

        				
    				</div>

				</div>
			</form>
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->

<?php $this->load->view('commons/main_footer', $nestedView); ?>
