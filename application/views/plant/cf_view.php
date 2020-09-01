<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN BORDERED TABLE PORTLET-->
			<div class="portlet light portlet-fit"  id="form_wizard_1">
				<div class="portlet-body form">
					<?php
					if(isset($flg))
					{
					?>
						<form class="form-horizontal" action="<?php echo $form_action;?>" id="submit_form" method="POST">
						<?php
						if($flg==2)
						{
							?>
							<input type="hidden" name="encoded_id" value="<?php echo cmm_encode($plant_row['plant_id']);?>">
							<?php
						}
						?>

						<div class="form-wizard">
							<div class="form-body">
								<ul class="nav nav-pills nav-justified steps" style="margin-bottom : 1px; padding:1px !important; margin-top : 0px;">
									<li class="active">
                                        <a href="#tab1" data-toggle="tab" class="step" >
                                            <span class="number"> 1 </span>
                                            <span class="desc">
                                                <i class="fa fa-check"></i> C&F Primary Details </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab2" data-toggle="tab" class="step">
                                            <span class="number"> 2 </span>
                                            <span class="desc">
                                                <i class="fa fa-check"></i> C&F Secondary Details  </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#tab3" data-toggle="tab" class="step active">
                                            <span class="number"> 3 </span>
                                            <span class="desc">
                                                <i class="fa fa-check"></i> Location </span>
                                        </a>
                                    </li>
								</ul>
								<div id="bar" class="progress progress-striped" role="progressbar">
									<div class="progress-bar progress-bar-success"> </div>
								</div>
								<div class="tab-content">
									<div class="alert alert-success display-none">
										<button class="close" data-dismiss="alert"></button> Your form validation is successful!
									</div>
									<div class="tab-pane active" id="tab1">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-4 control-label">C&F Name <span class="font-red required_fld">*</span></label>
													<div class="col-md-6">
														<div class="input-icon right">
															<i class="fa"></i>
															<input  class="form-control" style="height:30px;" value="<?php echo @$plant_row['name'];?>" type="text" name="cf_name">
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
															<textarea   id="agency" class=" form-control" style="height:30px;"  name="description" ><?php echo @$plant_row['description'];?></textarea>
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
															<select  id="type" name="region" class="form-control region_id" style="height:30px;"> 
															<option value="">-Select Region-</option>
															<?php if($flg==2)
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
															<select  id="type" name="mandal" class="form-control mandal" style="height:30px;"> 
															<option value="">-Select Mandal-</option>
															<?php if($flg==2)
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
															<select  id="type" name="city" class="form-control area" style="height:30px;"> 
															<option value="">-Select City/Town-</option>
															<?php if($flg==2)
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
													<label class="col-md-4 control-label">Short Name <span class="font-red required_fld">*</span></label>
													<div class="col-md-6">
														<div class="input-icon right">
															<i class="fa"></i>
															<input  class="form-control" style="height:30px;" value="<?php echo @$plant_row['short_name'];?>" type="text" name="short_name">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="tab2">
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-4 control-label" for="form-field-1">Concerned Person <span class="font-red required_fld">*</span></label>
													<div class="col-md-6">
														<div class="input-icon right">
															<i class="fa"></i>
															<input  id="dateFrom" class="form-control form-control " value="<?php echo @$c_f_row['concerned_person'];?>" style="height:30px;" type="text" name="concerned_person">	
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-4 control-label" for="form-field-1">Mobile <span class="font-red required_fld">*</span></label>
													<div class="col-md-6">
														<input id="dateFrom" class="form-control form-control" value="<?php echo @$c_f_row['mobile'];?>" style="height:30px;" type="text" name="mobile_number">
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-4 control-label" for="form-field-1">Alternate Mobile</label>
													<div class="col-md-6">
														<input id="dateFrom" class="form-control form-control" value="<?php echo @$c_f_row['alternate_mobile'];?>" style="height:30px;" type="text" name="alternate_mobile_no">
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-4 control-label" for="form-field-1">Pin Code </label>
													<div class="col-md-6">
														<input   id="dateFrom" class="form-control form-control" value="<?php echo @$c_f_row['pincode'];?>" style="height:30px;" type="text" name="pin_code">	
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-4 control-label" for="form-field-1">VAT No <span class="font-red required_fld">*</span></label>
													<div class="col-md-6">
														<div class="input-icon right">
															<i class="fa"></i>
															<input   id="dateFrom" class="form-control form-control" value="<?php echo @$c_f_row['vat_no'];?>" style="height:30px;" type="text" name="vat_no">
														</div>	
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-4 control-label" for="form-field-1">Adharcard Number<span class="font-red required_fld">*</span></label>
													<div class="col-md-6">
														<div class="input-icon right">
															<i class="fa"></i>
															<input   id="dateFrom" class="form-control form-control" value="<?php echo @$c_f_row['aadhar_no'];?>" style="height:30px;" type="text" name="adhar_no">
														</div>	
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-4 control-label" for="form-field-1">PAN No <span class="font-red required_fld">*</span></label>
													<div class="col-md-6">
														<div class="input-icon right">
															<i class="fa"></i>
															<input   id="dateFrom" class="form-control form-control" value="<?php echo @$c_f_row['pan_no'];?>" style="height:30px;" type="text" name="pan_no">
														</div>	
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-4 control-label" for="form-field-1">TAN No <span class="font-red required_fld">*</span></label>
													<div class="col-md-6">
														<div class="input-icon right">
															<i class="fa"></i>
															<input   id="dateFrom" class="form-control form-control" value="<?php echo @$c_f_row['tan_no'];?>" style="height:30px;" type="text" name="tan_no">
														</div>	
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-4 control-label" for="form-field-1">SD Amount <span class="font-red required_fld">*</span></label>
													<div class="col-md-6">
														<input id="dateFrom" value="<?php echo @$c_f_row['sd_amount'];?>" class="form-control numeric" onkeyup="javascript:this.value=Comma(this.value);" style="height:30px;" type="text" name="sd_amount">		
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-4 control-label" for="form-field-1">Agreement Start Date <span class="font-red required_fld">*</span> </label>
													<div class="col-md-6">
														<div class="input-icon right">
															<i class="fa"></i>
															<input   id="dateFrom" class="form-control date-picker start_date" data-date-format="dd-mm-yyyy" placeholder="Agreement Start Date" type="text" style="height:30px;" name="agr_start_date" <?php if(@$c_f_row['agreement_start_date']) { ?> value="<?php echo date('d-m-Y',strtotime(@$c_f_row['agreement_start_date']));?>" <?php } ?> />	
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label class="col-md-4 control-label" for="form-field-1">Agreement Exp Date <span class="font-red required_fld">*</span> </label>
													<div class="col-md-6">
														<div class="input-icon right">
															<i class="fa"></i>
															<input   id="dateFrom" class="form-control date-picker start_date" data-date-format="dd-mm-yyyy" placeholder="Agreement Expiry Date" type="text" style="height:30px;" name="agr_exp_date" <?php if(@$c_f_row['agreement_end_date']) { ?> value="<?php echo date('d-m-Y',strtotime(@$c_f_row['agreement_end_date']));?>" <?php } ?> />	
														</div>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<div class="col-md-12">
												<div class="col-md-3">
													<h3>Bank Details</h3>
												</div>
											</div> 	
										<div class="table-scrollable">
											<table class="table table-bordered table-striped table-hover" id="bank_table">
												<thead>
													<tr>
														<th style="width:15%">Bank Name</th>
														<th>IFSC Code</th>
														<th>Account number</th>
														<th>BG Amount</th>
														<th>Start Date</th>
														<th>End Date</th>
														<th>Delete</th>
													</tr>
												</thead>
												<tbody>
												
												<?php
													if(count(@$bank_details)>0)
													{
														$i=0;
														foreach($bank_details as $row)
														{
															//print_r($bank_type); exit();
														$disabled=($i==0)?'style="display:none" ':'';
														$i++;
													?>	
															<tr>
																<input type="hidden" class="form-control" name="bank_id[]" />
																<td>
																	<div class="dummy">
																		<select  id="type" name="bank_type[]" class="form-control" > 
																			<option value="">Bank</option>
																			<?php 
																				foreach($bank_type as $bank)
																				{
																					$selected = ' ';
																					if($bank['bank_id'] == $row['bank_id'])
																					{
																						$selected = 'selected';
																					}
																					echo '<option value="'.$bank['bank_id'].'" '.$selected.'>'.$bank['name'].'</option>';
																				}
																			?>
																		</select>
																	</div>
																	</td>
																	<td>
																		<div class="dummy">
										                                	<div class="input-icon right">
						                    									<i class="fa"></i>
								                                				<input type="text" class="form-control" style="width:135px"  name="ifsc_code[]" value="<?php echo $row['ifsc_code'];?>"/>
								                                			</div>
								                                		</div>
																	</td>
																	<td>
																		<div class="dummy">
										                                	<div class="input-icon right">
						                    									<i class="fa"></i>
								                                				<input type="text" class="form-control" style="width:135px"  name="account_no[]" value="<?php echo $row['account_no'];?>"/>
								                                			</div>
								                                		</div>
																	</td>
																	<td>
																		<div class="dummy">
										                                	<div class="input-icon right">
						                    									<i class="fa"></i>
								                                				<input type="text" class="form-control numeric" style="width:135px" onkeyup="javascript:this.value=Comma(this.value);" name="bg_amount[]" value="<?php echo $row['bg_amount'];?>"/>
								                                			</div>
								                                		</div>
																	</td>
																	<td>
																		<div class="dummy">
																			<div class="input-icon right">
																				<i class="fa"></i>
										                                		<input class="form-control date-picker start_date" placeholder="Start Date" name="start_date[]" style="width:135px;" data-date-format="dd-mm-yyyy" type="text" <?php if(@$row['start_date']) { ?> value="<?php echo date('d-m-Y',strtotime(@$row['start_date']));?>" <?php } ?> />	
								                                			</div>
								                                		</div>
																	</td>
																	<td>
																		<div class="dummy">
																			<div class="input-icon right">
																				<i class="fa"></i>	
										                                		<input class="form-control date-picker end_date" placeholder="End Date" name="end_date[]" style="width:135px;" data-date-format="dd-mm-yyyy" type="text" <?php if(@$row['end_date']) { ?> value="<?php echo date('d-m-Y',strtotime(@$row['end_date']));?>" <?php } ?> />	
								                                			</div>
								                                		</div>
																	</td>
																	<td <?php echo $disabled;?> ><a class="btn btn-danger btn-circle btn-sm tooltips remove_bank_row" href="javascript:void(0);" id="remove_bank_row"> <i class="fa fa-trash-o"></i></a></td>
															</tr>
														 <?php		
														} 
													}
													else
													{
												?>		
															<tr>
																<td>
																	<div class="dummy">
																		<div class="input-icon right">
																			<i class="fa"></i>
																			<select  id="type" name="bank_type[]" class="form-control" > 
																				<option value="">Bank</option>
																				<?php 
																					foreach($bank_type as $bank)
																					{
																						echo '<option value="'.$bank['bank_id'].'">'.$bank['name'].'</option>';
																					}
																				?>
																			</select>
																		</div>
																	</div>
																</td>
																<td>
																	<div class="dummy">
									                                	<div class="input-icon right">
					                    									<i class="fa"></i>
							                                				<input type="text" class="form-control"  name="ifsc_code[]"/>
							                                			</div>
							                                		</div>
																</td>
																	<td>
																		<div class="dummy">
										                                	<div class="input-icon right">
						                    									<i class="fa"></i>
								                                				<input type="text" class="form-control"  name="account_no[]" value=""/>
								                                			</div>
								                                		</div>
																	</td>
																	<td>
																		<div class="dummy">
										                                	<div class="input-icon right">
						                    									<i class="fa"></i>
								                                				<input type="text" class="form-control numeric" onkeyup="javascript:this.value=Comma(this.value);" name="bg_amount[]" />
								                                			</div>
								                                		</div>
																	</td>
																	<td>
																		<div class="dummy">
																			<div class="input-icon right">
																				<i class="fa"></i>
										                                		<input class="form-control date-picker start_date" placeholder="Start Date" name="start_date[]"  data-date-format="dd-mm-yyyy" type="text" />	
								                                			</div>
								                                		</div>
																	</td>
																	<td>
																		<div class="dummy">
								                                			<div class="input-icon right">
								                                				<i class="fa"></i>
								                                				<input class="form-control date-picker start_date" placeholder="End Date" name="end_date[]"  data-date-format="dd-mm-yyyy" type="text" />	
								                                			</div>
								                                		</div>
																	</td>
																	
															        <td style="display:none" ><a class="btn btn-danger btn-circle btn-sm tooltips remove_bank_row" href="javascript:void(0);" id="remove_bank_row"> <i class="fa fa-trash-o"></i></a></td>
															</tr>
														<?php	
													}
												?>
												</tbody>
											</table>
										</div>
										<div class="col-md-offset-10">
													<a  id="add_bank_info" class="btn blue tooltips" ><i class="fa fa-plus"></i> Add New</a>
												</div>
										</div>

									</div>

									<div class="tab-pane" id="tab3">
									<?php $divClass = "hidden"; 
											if($flg==2){
												$divClass = '';
												}?>
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">State <span class="font-red required_fld">*</span></label>
											<div class="col-md-3 multiselectbox">
												<div class="input-icon right">
														<i class="fa"></i>
													<select  id="state" name="state_cf" class="form-control state_cf"> 
													<option value="">-Select State-</option>
													<?php 
														foreach($state as $stat)
														{
															$selected = "";
															if($stat['location_id']== @$selected_state)
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
										<div class="form-group <?php echo $divClass; ?>">
											<label class="col-md-4 control-label" for="form-field-1">Region <span class="font-red required_fld">*</span></label>
											<div class="col-md-3">
												<div class="input-icon right">
														<i class="fa"></i>
													
													<select  id="region" name="region_cf" class="form-control  region_cf"> 
													<option value="">-Select Region-</option>
													<?php if($flg==2)
													{
														foreach($regionn as $reg)
														{
															$selected = "";
															if($reg['location_id']== @$selected_region)
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
										<div class="form-group dist <?php echo $divClass;?> <?php if(@$flggg==4) { ?> hidden <?php } ?>">
											<label class="col-md-4 control-label" for="form-field-1">District</label>
											<div class="col-md-6">
												<div class="input-icon right">
														<i class="fa"></i>
													<div class="district_id" style="  width:35%; height: 100px; overflow-y: scroll;">
													<?php if($flg==2  && @$flgg==3)
													{
														foreach(@$districtt as $dis)
														{
															$checked = "";
															foreach($selected_district as $seldis)
															{
																if($dis['location_id']== @$seldis['location_id'])
																{ 
																	$checked='checked';
																	break;
																} 
															}
														echo '<input type="checkbox" class="district_id" name="district_cf[]" value="'. $dis['location_id'].'" '.$checked.'> <label class="control-label">'. $dis['name'].'</label> <br/>';
																
																
	                                    				}
													}
													?>
														
													</div>
													
													
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="form-actions">
								<div class="row">
									<div class="col-md-offset-5 col-md-9">
										<a  class="btn default button-previous"><i class="fa fa-angle-left"></i> Back </a>
										<a  class="btn btn-outline green button-next"> Continue<i class="fa fa-angle-right"></i></a>
										<button type="submit" class="btn green button-submit"> Submit<i class="fa fa-check"></i></button>
									</div>
								</div>
							</div>
						</div>
					</form>
					<?php
					}
					?>
					
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('commons/main_footer', $nestedView); ?>