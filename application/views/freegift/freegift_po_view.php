<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN BORDERED TABLE PORTLET-->
			<div class="portlet light portlet-fit">
				<div class="portlet-body">
					<?php
					if(isset($flag))
					{
						?>
						<form id="freegift_form" method="post" action="<?php echo $form_action;?>" class="form-horizontal srow">
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-4 control-label">Po Number</label>
										<div class="col-md-6">
											<b class="form-control-static"><?php echo  $po_number;?></b>
											<input type="hidden" name="po_no" value="<?php echo @$po_number;?>">
                                        </div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-4 control-label">Date</label>
										<div class="col-md-6">
											<input type="hidden" name="po_date" value="<?php echo date('Y-m-d');?>">
                                            <b class="form-control-static"><?php echo date('d-m-Y');?></b>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-4 control-label" for="form-field-1">FreeGift <span class="font-red required_fld">*</span></label>
										<div class="col-md-6">
											<div class="input-icon right">
												<i class="fa"></i>
												<select  id="type" name="freegift_type" class="form-control state" style="height:30px;"> 
												<option value="">-Select Freegift-</option>
												<?php 
													foreach($freegift as $row)
													{
														$selected = "";
														if($row['free_gift_id']== @$freegift_row['free_gift_id'])
															{ 
																$selected='selected';
															}
			                                        	echo '<option value="'.$row['free_gift_id'].'" '.$selected.'>'.$row['name'].'</option>';
			                                        }
												?>
												</select>	
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-4 control-label" for="form-field-1">Supplier <span class="font-red required_fld">*</span></label>
										<div class="col-md-6">
											<div class="input-icon right">
													<i class="fa"></i>
												<select  id="type" name="supplier" class="form-control state" style="height:30px;"> 
												<option value="">-Select Supplier-</option>
												<?php 
													foreach($supplier as $row)
													{
														$selected = "";
														if($row['supplier_id']== @$freegift_row['supplier_id'])
															{ 
																$selected='selected';
															}
			                                        	echo '<option value="'.$row['supplier_id'].'" '.$selected.'>'.$row['agency_name'].'</option>';
			                                        }
												?>
												</select>	
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-4 control-label" for="form-field-1">Quantity <span class="font-red required_fld">*</span></label>
										<div class="col-md-6">
											<div class="input-icon right">
												<i class="fa"></i>
												<input class="form-control quantity" name="quantity" value="<?php echo @$freegift_row['quantity'];?>"  type="number">
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-4 control-label" for="form-field-1">Rate <span class="font-red required_fld">*</span></label>
										<div class="col-md-6">
											<div class="input-icon right">
												<i class="fa"></i>
												<input class="form-control rate"  name="rate" value="<?php echo @$freegift_row['unit_price'];?>"  type="number">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-4 control-label" for="form-field-1">Total Amount <span class="font-red required_fld">*</span></label>
										<div class="col-md-6">
											<input class="form-control numeric t_amount" disabled name="t_amount" value="<?php echo @$lrow['t_amount'];?>"  type="text">
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-5 col-md-6">
                                        <button type="submit" class="btn blue" onclick="return confirm('Are you sure you want to Generate P.O.?')" name="submit">Generate P.O.</button>
                                        <a href="<?php echo SITE_URL.'freegift_po';?>" class="btn default">Cancel</a>
                                    </div>
                                </div>
                            </div>
						</form>
						<?php
					}
					if(isset($display_results)&&$display_results==1)
					{
					?>
						<form method="post" action="<?php echo SITE_URL.'freegift_po_list'?>">
							<div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input class="form-control" name="po_number" value="<?php echo @$search_data['po_number'];?>" placeholder="PO Number" type="text">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select  id="region" name="freegift_id" class="form-control">
                                        <option value="">-Select FreeGift-</option> 
                                        <?php
                                        foreach($freegift as $row)
                                        {
                                        	$selected = "";
											if($row['free_gift_id']== @$search_data['freegift_id'])
												{ 
													$selected='selected';
												}
                                        	echo '<option value="'.$row['free_gift_id'].'" '.$selected.'>'.$row['name'].'</option>';
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                       <input class="form-control date-picker date" data-date-format="dd-mm-yyyy" name="po_date" <?php if($search_data['po_date']!='') { ?> value="<?php echo date('d-m-Y',strtotime(@$search_data['po_date']));?>" <?php } ?> placeholder="Date" type="text">
                                    </div>
                                </div>
                                <div class=" col-sm-3">
                                    <div class="form-actions">
                                        <button type="submit" name="search_freegift" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                        <a  class="btn blue tooltips" href="<?php echo SITE_URL.'freegift_po_list';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
                                        <button type="submit" name="free_gift_report" value="1" formaction="<?php echo SITE_URL.'print_free_gift_report';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Print"><i class="fa fa-print"></i></button> 
                                        
                                    </div>
                                </div>
                            </div>
						</form>
						<div class="table-scrollable">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th width="10%"> S.No</th>
										<th width="10%">PO Number</th>
										<th width="20%">Free Gift Name</th>
										<th width="20%">Supplier</th>
										<th width="10%">Quantity</th>
										<th width="10%"h>Rate</th>
										<th width="10%">Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if($freegift_results){
										foreach($freegift_results as $row){
									?>	
										<tr>
											<td> <?php echo $sn++;?></td>
											<td> <?php echo $row['po_number'];?> </td>
                                        	<td> <?php echo $row['freegift_name'];?> </td>
                                        	<td> <?php echo $row['supplier_name'];?> </td>
                                        	<td> <?php echo $row['quantity'];?> </td>
                                        	<td> <?php echo $row['unit_price'];?> </td>
                                        	<td>
                                            <a class="btn btn-primary btn-xs tooltips" data-original-title="Print PO Free Gifts"  href="<?php echo SITE_URL;?>print_free_gift/<?php echo cmm_encode($row['po_fg_id']); ?>"><i class="fa fa-print"></i>Print</a> 
                                        </td>
										</tr>
										<?php		
										}
									}
									else
									{
									?>
										<tr><td colspan="6" align="center"> No Records Found</td></tr>
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
			<!-- END BORDERED TABLE PORTLET-->
		</div>
	</div>
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>