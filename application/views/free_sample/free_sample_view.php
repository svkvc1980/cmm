<?php $this->load->view('commons/main_template', $nestedView); ?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN BORDERED TABLE PORTLET-->
			<div class="portlet light portlet-fit">
				<div class="portlet-body">
				<?php $get_per_carton_items=get_per_carton_items();?>
					<?php
					if(isset($flag))
					{
						?>
						<form id="freesample_form" method="post" action="<?php echo $form_action;?>" class="form-horizontal srow">
							<?php
								if($flag==2)
								{
									?>
									<input type="hidden" name="encoded_id" value="<?php echo cmm_encode($freegift_row['po_fg_id']);?>">
									<?php
								}
								?>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label">Free Gift Number :</label>
											<div class="col-md-6">
												<p class="form-control-static"><b><?php echo @$do_number; ?></b></p>
		                                    </div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label">Date <span class="font-red required_fld">*</span></label>
											<div class="col-md-6">
												<div class="input-icon right">
													<i class="fa"></i>
													<input  class="form-control date-picker" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y') ?>" type="text" name="on_date">
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">Product <span class="font-red required_fld">*</span></label>
											<div class="col-md-6">
												<div class="input-icon right">
													<i class="fa"></i>
													<select name="product_id" class="form-control product" > 
														<option value="">-Select Product-</option>
															<?php 
															foreach($product as $row)
															{
																echo '<option value="'.$row['product_id'].'">'.$row['name'].'</option>';
															} ?>
													</select>
												</div>
											</div>
										</div>	
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label">Quantity <span class="font-red required_fld">*</span></label>
											<div class="col-md-2">
											<div class="input-icon right">
													<i class="fa"></i>
												<input  class="form-control numeric" maxlength="7" type="text" name="quantity">
											</div>
											</div>
											<div class="col-md-4">
												<select name="sample_type" class="form-control"> 
														<?php 
														foreach($freesample_type as $row)
														{
															echo '<option value="'.$row['item_type_id'].'">'.$row['name'].'</option>';
														} ?>
												</select>
											</div>
											
										</div>
									</div>	
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label">Description <span class="font-red required_fld">*</span></label>
											<div class="col-md-6">
												<div class="input-icon right">
													<i class="fa"></i>
													<input type="text" class="form-control" name="description" maxlength="50" >
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label">Items Per Carton :</label>
											<div class="col-md-2">
												<input  class="form-control item" readonly type="text" name="items_per_carton">
											</div>
											<div class="col-md-6">
												<label class="col-md-6 control-label">Stock Qty.</label>
												<div class="col-md-5">
													<input  class="form-control quantity" readonly type="text" name="stock_quantity">
													<!-- <p class="form-control-static "><b class="quantity"></b></p> -->
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="form-actions">
			                        <div class="row">
			                            <div class="col-md-offset-5 col-md-6">
			                                <button type="submit" class="btn blue">Submit</button>
			                                <a href="<?php echo SITE_URL.'free_sample_list';?>" class="btn default">Cancel</a>
			                            </div>
			                        </div>
			                    </div>
	                	</form> <?php
					} 
					if(isset($display_results)&&$display_results==1)
					{
					?>
						<form method="post" action="<?php echo SITE_URL.'free_sample_list'?>">
							<div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input class="form-control" name="do_number" value="<?php echo @$search_data['do_number'];?>" placeholder="DO Number" type="text">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select name="product" class="form-control">
                                        <option value="">-Select Product-</option> 
                                        <?php
                                        foreach($product as $row)
                                        {
                                        	$selected = "";
											if($row['product_id']== @$search_data['product'])
												{ 
													$selected='selected';
												}
                                        	echo '<option value="'.$row['product_id'].'" '.$selected.'>'.$row['name'].'</option>';
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="input-group date-picker input-daterange " data-date-format="dd-mm-yyyy">
                                        <input class="form-control " name="from_date"  placeholder="From" type="text" <?php if($search_data['from_date']!='') { ?> value="<?php echo date('d-m-Y',strtotime(@$search_data['from_date']));?>" <?php } ?> >
                                        <span class="input-group-addon"> to </span>
                                        <input class="form-control " name="to_date"  placeholder="To" type="text" <?php if($search_data['to_date']!='') { ?> value="<?php echo date('d-m-Y',strtotime(@$search_data['to_date']));?>" <?php } ?> >
                                    </div>
                                </div>
                                <div class=" col-sm-3">
                                    <div class="form-actions">
                                        <button type="submit" name="search_freesample" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                        <button type="submit" name="download_freesample" value="1" formaction="<?php echo SITE_URL.'download_freesamples';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
                                        <a  class="btn blue tooltips" href="<?php echo SITE_URL.'free_sample_list';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
                                        <a href="<?php echo SITE_URL.'add_free_samples';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                        
                                    </div>
                                </div>
                            </div>
						</form>
						<div class="table-scrollable">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>S.No</th>
										<th>DO Number</th>
										<th>Product Name</th>
										
										<th>Date</th>
										<th>Quantity</th>
										<th>Description</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if($freesample_results){
										foreach($freesample_results as $row){
									?>	
										<tr>
											<td> <?php echo $sn++;?></td>
											<td> <?php echo $row['do_number'];?> </td>
											<td> <?php echo $row['product_name'];?> </td>
                                        	
                                        	<td> <?php echo date('d-m-Y',strtotime($row['on_date']));?></td>
                                        	<?php $item = round($row['quantity']*$row['items_per_carton']); ?>
                                        	<td> <?php echo $item.' '.'Item(s)'?></td>
                                        	<td> <?php echo $row['description'];?></td>
                                        </tr>
										<?php		
										}
									}
									else
									{
									?>
										<tr><td colspan="7" align="center"> No Records Found</td></tr>
										<?php
									}
									?>
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
                    <?php	
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var plant_id=<?php echo $this->session->userdata('ses_plant_id'); ?>;
</script>
<?php $this->load->view('commons/main_footer', $nestedView); ?>