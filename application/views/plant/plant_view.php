<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN BORDERED TABLE PORTLET-->
			<div class="portlet light portlet-fit">
				<div class="portlet-body">
					<?php
					if(isset($flg))
					{
						?>
						<form id="plant_form" method="post" action="<?php echo $form_action;?>" class="form-horizontal">
							<?php
							if($flg==2)
							{
								?>
								<input type="hidden" name="encoded_id" value="<?php echo cmm_encode($plant_row['plant_id']);?>">
								<?php
							}
							?>
							<div class="alert alert-danger display-hide" style="display: none;">
								<button class="close" data-close="alert"></button> You have some form errors. Please check below. 
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-4 control-label">Plant Name <span class="font-red required_fld">*</span></label>
										<div class="col-md-6">
											<div class="input-icon right">
												<i class="fa"></i>
												<input  class="form-control" style="height:30px;" value="<?php echo @$plant_row['name'];?>" type="text" name="plant_name">
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-4 control-label">Description</label>
										<div class="col-md-6">
											<div class="input-icon right">
												<i class="fa"></i>
												<textarea   id="agency" class=" form-control" style="height:30px;"  name="description"><?php echo @$plant_row['description'];?></textarea>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-4 control-label">Address</label>
										<div class="col-md-6">
											<div class="input-icon right">
												<i class="fa"></i>
												<textarea  class=" form-control" style="height:30px;"  name="address" ><?php echo @$plant_row['address'];?></textarea>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-4 control-label" for="form-field-1">State <span class="font-red required_fld">*</span></label>
										<div class="col-md-6">
											<div class="input-icon right">
													<i class="fa"></i>
												<select  id="type" name="state" class="form-control state" style="height:30px;"> 
												<option value="">-Select State-</option>
												<?php 
													foreach($state as $stat)
													{
														$selected = "";
														if($stat['location_id']== @$state_id)
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
												<select  id="type" name="region" class="form-control region_id" style="height:30px;"> 
												<option value="">-Select Region-</option>
												<?php if($flg==2)
												{
													foreach($region as $reg)
													{
														$selected = "";
														if($reg['location_id']== @$region_id)
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
										<label class="col-md-4 control-label" for="form-field-1">District<span class="font-red required_fld">*</span></label>
										<div class="col-md-6">
											<div class="input-icon right">
													<i class="fa"></i>
												<select  id="type" name="district" class="form-control district" style="height:30px;"> 
												<option value="">-Select District-</option>
												<?php if($flg==2)
												{
													foreach($district as $dis)
													{
														$selected = "";
														if($dis['location_id']== @$district_id)
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
												<select  id="type" name="mandal" class="form-control mandal" style="height:30px;"> 
												<option value="">-Select Mandal-</option>
												<?php if($flg==2)
												{
													foreach($mandal as $man)
													{
														$selected = "";
														if($man['location_id']== @$mandal_id)
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
										<label class="col-md-4 control-label" for="form-field-1">Area <span class="font-red required_fld">*</span></label>
										<div class="col-md-6">
											<div class="input-icon right">
													<i class="fa"></i>
												<select  id="type" name="city" class="form-control area" style="height:30px;"> 
												<option value="">-Select City/Town-</option>
												<?php if($flg==2)
												{
													foreach($city as $cit)
													{
														$selected = "";
														if($cit['location_id']== @$city_id)
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
										<label class="col-md-4 control-label">Short Name <span class="font-red required_fld">*</span></label>
										<div class="col-md-6">
											<div class="input-icon right">
												<i class="fa"></i>
												<input type="text" class=" form-control" maxlength="15" name="short_name" value="<?php echo @$plant_row['short_name'];?>">
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-5 col-md-6">
                                        <button type="submit" class="btn blue" formaction="<?php echo SITE_URL.'plant_view'; ?>">Submit</button>
                                        <a href="<?php echo SITE_URL.'plant';?>" class="btn default">Cancel</a>
                                    </div>
                                </div>
                            </div>
						</form>
						<?php
					}
					if(isset($display_results)&&$display_results==1)
					{
					?>
						<form method="post" action="<?php echo SITE_URL.'plant'?>">
							<div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input class="form-control" name="plant_name" value="<?php echo @$search_data['name'];?>" placeholder="Unit Name" type="text">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select  id="region" name="block" class="form-control">
                                        <option value="">-Select Block-</option> 
                                        <?php
                                        foreach($block as $block_type)
                                        {
                                        	$selected = "";
											if($block_type['block_id']== @$search_data['block'])
												{ 
													$selected='selected';
												}
                                        	echo '<option value="'.$block_type['block_id'].'" '.$selected.'>'.$block_type['name'].'</option>';
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <select  id="region" name="location" class="form-control">
                                        <option value="">-Select Location-</option> 
                                        <?php
                                        foreach($location as $loc)
                                        {
                                        	$selected = "";
											if($loc['location_id']== @$search_data['location'])
												{ 
													$selected='selected';
												}
                                        	echo '<option value="'.$loc['location_id'].'" '.$selected.'>'.$loc['name'].'</option>';
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class=" col-sm-3">
                                    <div class="form-actions">
                                        <button type="submit" name="search_plant" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                        <button type="submit" name="download_plant" value="1" formaction="<?php echo SITE_URL.'download_plant';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
                                        <a  class="btn blue tooltips" href="<?php echo SITE_URL.'plant';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
                                        <a href="<?php echo SITE_URL.'add_unit';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                        
                                    </div>
                                </div>
                            </div>
						</form>
						<div class="table-scrollable">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th> S.No</th>
										<th>Unit Name</th>
										<th>Short Name</th>
										<th>Type</th>
										<th>Location</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if($plant_results){
										foreach($plant_results as $row){
									?>	
										<tr>
											<td> <?php echo $sn++;?></td>
											<td> <?php echo $row['name'];?> </td>
											<td> <?php echo $row['short_name'];?> </td>
                                        	<td> <?php echo $row['block_name'];?> </td>
                                        	<td> <?php echo $row['location_name'];?> </td>
                                        	
                                        	<td>    <?php if(@$row['status']!=2){ 
                                        			if(@$row['bid']==2 || @$row['bid'] == 3)
                                        			{
                                        				?>
                                        				<a class="btn btn-default btn-xs tooltips" href="<?php echo SITE_URL.'edit_plant/'.cmm_encode($row['plant_id']);?>"  data-container="body" data-placement="top" data-original-title="Edit Details"><i class="fa fa-pencil"></i></a>
                                        				<?php
                                        			} 
                                        			else 
                                        			{
                                        				?>
                                        				<a class="btn btn-default btn-xs tooltips" href="<?php echo SITE_URL.'edit_cf/'.cmm_encode($row['plant_id']);?>"  data-container="body" data-placement="top" data-original-title="Edit Details"><i class="fa fa-pencil"></i></a>
                                        				<?php
                                        			} ?>
	                                            
	                                            <?php
	                                            }
	                                            if($row['status']==1){
	                                            ?>
	                                            <a class="btn btn-danger btn-xs tooltips"  onclick="return confirm('Are you sure you want to Deactivate?')" href="<?php echo SITE_URL.'deactivate_plant/'.cmm_encode($row['plant_id']);?>" data-container="body" data-placement="top" data-original-title="DeActivate"><i class="fa fa-trash-o"></i></a>
	                                            <?php
	                                            }
	                                            if($row['status']==2){
	                                            ?>
	                                            <a class="btn btn-info btn-xs tooltips"  onclick="return confirm('Are you sure you want to Activate?')" href="<?php echo SITE_URL.'activate_plant/'.cmm_encode($row['plant_id']);?>" data-container="body" data-placement="top" data-original-title="Activate"><i class="fa fa-check"></i></a>
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
										<tr><td colspan="4" align="center"> No Records Found</td></tr>
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