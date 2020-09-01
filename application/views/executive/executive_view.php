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
						<form id="exe_form" method="post" action="<?php echo $form_action;?>" class="form-horizontal">
							<?php
								if($flag==2)
								{
									?>
									<input type="hidden" id="eid" name="encoded_id" value="<?php echo cmm_encode($executive_row['executive_id']);?>">
									<?php
								}
								?>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label">Executive Name <span class="font-red required_fld">*</span></label>
											<div class="col-md-6">
                                    			<div class="input-icon right">
                                      				<i class="fa"></i>
                                      				<input class="form-control " maxlength="50" value="<?php echo @$executive_row['name'];?>" type="text" name="exe_name">	
                                      			</div>
                                			</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label">Executive Code <span class="font-red required_fld">*</span></label>
											<div class="col-md-6">
                                    			<div class="input-icon right">
                                      				<i class="fa"></i>
                                      				<input class="form-control" name="exe_code" id="exe_code"  type="text" value="<?php echo @$executive_row['executive_code']; ?>">
                                      				<p id="codeValidating" class="hidden"><i class="fa fa-spinner fa-spin"></i> Checking...</p>
                                      				<p id="codeError" class="error hidden"></p>
                                    			</div>
                                			</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label">Mobile Number <span class="font-red required_fld">*</span></label>
											<div class="col-md-6">
												<div class="input-icon right">
													<i class="fa"></i>
													<input class="form-control" maxlength="10" value="<?php echo @$executive_row['mobile'];?>" type="text" name="mobile">	
		                                    	</div>
		                                    </div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label">Address</label>
											<div class="col-md-6">
												<div class="input-icon right">
													<i class="fa"></i>
													<textarea class="form-control" maxlength="250" name="address"> <?php echo @$executive_row['address'];?> </textarea>	
		                                    	</div>
		                                    </div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label">Alternate Mobile Number</label>
											<div class="col-md-6">
												<input class="form-control " value="<?php echo @$executive_row['alternate_mobile'];?>" type="text" name="alt_mobile">	
		                                    </div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">State <span class="font-red required_fld">*</span></label>
											<div class="col-md-6">
											<div class="input-icon right">
													<i class="fa"></i>
												<select name="state" class="form-control state"> 
												<option value="">-Select State-</option>
												<?php 
													foreach($state as $stat)
													{
														$selected = "";
														if($stat['location_id']== @$state_parent_id)
															{ 
																$selected='selected';
															}
														echo '<option value="'.$stat['location_id'].'" '.$selected.' >'.$stat['name'].'</option>';
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
											<label class="col-md-4 control-label" for="form-field-1">Region <span class="font-red required_fld">*</span></label>
											<div class="col-md-6">
												<div class="input-icon right">
													<i class="fa"></i>
													<select name="region" class="form-control region_id"> 
													<option value="">-Select Region-</option>
													<?php if($flag==2)
													{
														foreach($region as $reg)
														{
															$selected = "";
															if($reg['location_id']== @$region_parent_id)
																{ 
																	$selected='selected';
																}
															echo '<option value="'.$reg['location_id'].'" '.$selected.' >'.$reg['name'].'</option>';
														}
													}
													?>
													</select>	
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">District <span class="font-red required_fld">*</span></label>
											<div class="col-md-6">
											<div class="input-icon right">
													<i class="fa"></i>
												<select name="district" class="form-control district"> 
												<option value="">-Select District-</option>
												<?php if($flag==2)
												{
													foreach($district as $dis)
													{
														$selected = "";
														if($dis['location_id']== @$district_parent_id)
															{ 
																$selected='selected';
															}
														echo '<option value="'.$dis['location_id'].'" '.$selected.' >'.$dis['name'].'</option>';
													}
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
											<label class="col-md-4 control-label" for="form-field-1">Mandal<span class="font-red required_fld">*</span></label>
											<div class="col-md-6">
											<div class="input-icon right">
													<i class="fa"></i>
												<select name="mandal" class="form-control mandal"> 
												<option value="">-Select Mandal-</option>
												<?php if($flag==2)
												{
													foreach($mandal as $man)
													{
														$selected = "";
														if($man['location_id']== @$mandal_parent_id)
															{ 
																$selected='selected';
															}
														echo '<option value="'.$man['location_id'].'" '.$selected.' >'.$man['name'].'</option>';
													}
												}
												?>
												</select>	
											</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">City/Town <span class="font-red required_fld">*</span></label>
											<div class="col-md-6">
											<div class="input-icon right">
													<i class="fa"></i>
												<select name="city" class="form-control area"> 
												<option value="">-Select City/Town-</option>
												<?php if($flag==2)
												{
													foreach($city as $cit)
													{
														$selected = "";
														if($cit['location_id']== @$city_parent_id)
															{ 
																$selected='selected';
															}
														echo '<option value="'.$cit['location_id'].'" '.$selected.' >'.$cit['name'].'</option>';
													}
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
											<label class="col-md-4 control-label">Email Id</label>
											<div class="col-md-6">
												<input class="form-control " value="<?php echo @$email;?>" type="text" name="email">	
		                                    </div>
										</div>
									</div>
								</div>
								<div class="form-actions">
			                        <div class="row">
			                            <div class="col-md-offset-5 col-md-6">
			                                <button type="submit" class="btn blue">Submit</button>
			                                <a href="<?php echo SITE_URL.'executive';?>" class="btn default">Cancel</a>
			                            </div>
			                        </div>
			                    </div>
						</form> <?php
					}
					if(isset($display_results)&&$display_results==1)
					{
						?>
						<form method="post" action="<?php echo SITE_URL.'executive'?>">
							<div class="row">
								<div class="col-sm-3">
                                    <div class="form-group">
                                        <input class="form-control" name="exe_name" value="<?php echo @$search_data['exe_name'];?>" placeholder="Name" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input class="form-control" name="exe_code" value="<?php echo @$search_data['exe_code'];?>" placeholder="Executive Code" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-actions">
                                        <button type="submit" name="search_executive" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                        <button type="submit" name="download_executive" value="1" formaction="<?php echo SITE_URL.'download_executive';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
                                        <a  class="btn blue tooltips" href="<?php echo SITE_URL.'executive';?>" data-original-title="Refresh"> <i class="fa fa-refresh"></i></a>
                                        <a href="<?php echo SITE_URL.'add_executive';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                        <button type="submit" name="executive_print" value="1" formaction="<?php echo SITE_URL.'executive_print';?>" class="btn btn-danger tooltips" data-container="body" data-placement="top" data-original-title="Print"><i class="fa fa-print"></i></button>
                                        
                                    </div>
                                </div>
							</div>
						</form>
						<div class="table-scrollable">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>S.No</th>
										<th>Executive Code</th>
										<th>Name</th>
										<th>Mobile Number</th>
										<th>Address</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if($executive_results)
									{
										foreach($executive_results as $row)
										{
											?>
											<tr>
												<td width="5%"> <?php echo $sn++;?></td>
												<td width="5%"> <?php echo $row['executive_code'];?> </td>
	                                        	<td width="10%"> <?php echo $row['name'];?> </td>
	                                        	<td width="10%"> <?php echo $row['mobile'];?></td>
	                                        	<td width="20%"> <?php echo $row['address'];?></td>
	                                        	<td width="5%"> 
		                                            <?php 
		                                            if($row['status']==1)
		                                            {
		                                            	?> <a class="btn btn-default btn-xs tooltips" href="<?php echo SITE_URL.'edit_executive/'.cmm_encode($row['executive_id']);?>"  data-container="body" data-placement="top" data-original-title="Edit Details"><i class="fa fa-pencil"></i></a>
		                                            <?php
		                                            }
		                                            if($row['status']==1){
		                                            ?>
		                                            <a class="btn btn-danger btn-xs tooltips"  onclick="return confirm('Are you sure you want to Deactivate?')" href="<?php echo SITE_URL.'deactivate_executive/'.cmm_encode($row['executive_id']);?>" data-container="body" data-placement="top" data-original-title="DeActivate"><i class="fa fa-trash-o"></i></a>
		                                            <?php
		                                            }
		                                            if($row['status']==2){
		                                            ?>
		                                            <a class="btn btn-info btn-xs tooltips"  onclick="return confirm('Are you sure you want to Activate?')" href="<?php echo SITE_URL.'activate_executive/'.cmm_encode($row['executive_id']);?>" data-container="body" data-placement="top" data-original-title="Activate"><i class="fa fa-check"></i></a>
		                                            <?php
		                                            }
		                                            ?>
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
                        </div> <?php
					} ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('commons/main_footer', $nestedView); ?>