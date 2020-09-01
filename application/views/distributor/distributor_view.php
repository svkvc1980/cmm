 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                	<form id="distributor_form" method="post" action="<?php echo @$form_action;?>" class="form-horizontal">
                    <?php if(@$flg==1)
                    { ?>
                            <input type="hidden" name="encoded_id" value="<?php echo cmm_encode(@$distributor_row['distributor_id']);?>">
                            <input type="hidden" name="user_id" id="uid" value="<?php echo @$user['user_id']; ?>">
                            <input type="hidden" name="type_id" value="<?php echo $type_id; ?>">
                            	<div class="row">
                            		<div class="col-md-6">
                            			<div class="form-group">
                            			<label class="col-md-4 control-label">UserName <span class="font-red required_fld">*</span></label>
                                			<div class="col-md-6">
                                    			<div class="input-icon right">
                                      				<i class="fa"></i>
                                      				<input class="form-control" name="user_name" id="userName" placeholder="UserName For Login" type="text" value="<?php echo @$user['username']; ?>">
                                      				<p id="usernameValidating" class="hidden"><i class="fa fa-spinner fa-spin"></i> Checking...</p>
                                      				<p id="userError" class="error hidden"></p>
                                    			</div>
                                			</div>
                            			</div>
                        			</div>
                        			<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label"><?php echo $type_name ?> Code <span class="font-red required_fld">*</span></label>
											<div class="col-md-6">
												<div class="input-icon right">
													<i class="fa"></i>
													<input  class="form-control" value="<?php echo @$distributor_row['distributor_code'];?>" type="text" name="distributor_code">	
												</div>
											</div>
										</div>
									</div>
                            	</div>
                                <div class="row">
									
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">Agency Name <span class="font-red required_fld">*</span></label>
											<div class="col-md-6">
												<div class="input-icon right">
													<i class="fa"></i>
													<textarea class=" form-control" style="height:30px;" name="agency_name"><?php echo @$distributor_row['agency_name'];?></textarea>	
												</div>	
											</div>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">Concerned Person <span class="font-red required_fld">*</span></label>
											<div class="col-md-6">
												<div class="input-icon right">
													<i class="fa"></i>
													<input class="form-control " value="<?php echo @$distributor_row['concerned_person'];?>" type="text" name="concerned_person">	
												</div>
											</div>
										</div>
									</div>
									
								</div>

								<div class="row">
									
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">Address </label>
											<div class="col-md-6">
												<div class="input-icon right">
													<i class="fa"></i>
													<textarea class="form-control" style="height:30px;" name="address"><?php echo @$distributor_row['address'];?></textarea>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">State</label>
											<div class="col-md-6">
											<div class="input-icon right">
													<i class="fa"></i>
												<select name="state"  class="form-control state"> 
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
											<label class="col-md-4 control-label" for="form-field-1">Region </label>
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
											<label class="col-md-4 control-label" for="form-field-1">District </label>
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
											<label class="col-md-4 control-label" for="form-field-1">Mandal</label>
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
											<label class="col-md-4 control-label" for="form-field-1"> Area</label>
											<div class="col-md-6">
											<div class="input-icon right">
													<i class="fa"></i>
												<select name="location_id" class="form-control area"> 
												<option value="">-Select Area-</option>
												<?php if($flag==2)
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
											<label class="col-md-4 control-label" for="form-field-1">Pin Code </label>
											<div class="col-md-6">
												<input class="form-control" value="<?php echo @$distributor_row['pincode'];?>" type="text" name="pincode">	
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">LandLine No. </label>
											<div class="col-md-6">
											<div class="input-icon right">
												<i class="fa"></i>
												<input class="form-control numeric" maxlength="14" value="<?php echo @$distributor_row['landline'];?>" type="text" name="landline">	
											</div>	
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">Mobile No. </label>
											<div class="col-md-6">
												<div class="input-icon right">
													<i class="fa"></i>
													<input class="form-control numeric" maxlength="12" value="<?php echo @$distributor_row['mobile'];?>" type="text" name="mobile">
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">Email </label>
											<div class="col-md-6">
												<div class="input-icon right">
													<i class="fa"></i>
													<input class="form-control" value="<?php echo @$user['email'];?>" type="email" name="email">
												</div>
											</div>
										</div>
									</div>
								</div>
							 
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">Alternate Mobile No.</label>
											<div class="col-md-6">
												<input class="form-control numeric" maxlength="12" value="<?php echo @$distributor_row['alternate_mobile'];?>" type="text" name="alternate_mobile">
											</div>
										</div>
									</div>
									<?php if($type_id==1 || $type_id==3 || $type_id==5 || $type_id==6 ){ ?>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">VAT No </label>
											<div class="col-md-6">
												<div class="input-icon right">
													<i class="fa"></i>
													<input class="form-control" value="<?php echo @$distributor_row['vat_no'];?>" maxlength="25" type="text" name="vat_no">
												</div>	
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">Adhar Card Number</label>
											<div class="col-md-6">
												<div class="input-icon right">
													<i class="fa"></i>
													<input class="form-control" value="<?php echo @$distributor_row['aadhar_no'];?>" maxlength="30" type="text" name="aadhar_no">
												</div>	
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">PAN No</label>
											<div class="col-md-6">
												<div class="input-icon right">
													<i class="fa"></i>
													<input class="form-control" maxlength="20" value="<?php echo @$distributor_row['pan_no'];?>" type="text" name="pan_no">
												</div>	
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">TAN No </label>
											<div class="col-md-6">
												<div class="input-icon right">
													<i class="fa"></i>
													<input class="form-control" maxlength="30" value="<?php echo @$distributor_row['tan_no'];?>" type="text" name="tan_no">
												</div>	
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">Agreement Start Date </label>
											<div class="col-md-6">
												<div class="input-icon right">
													<i class="fa"></i>
													<input class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="Agreement Start Date" type="text" name="agreement_start_date" <?php if(@$distributor_row['agreement_start_date']) { ?> value="<?php echo date('d-m-Y',strtotime(@$distributor_row['agreement_start_date']));?>" <?php } ?> />	
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">Agreement End Date</label>
											<div class="col-md-6">
												<div class="input-icon right">
													<i class="fa"></i>
													<input class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="Agreement Expiry Date" type="text" name="agreement_end_date" <?php if(@$distributor_row['agreement_end_date']) { ?> value="<?php echo date('d-m-Y',strtotime(@$distributor_row['agreement_end_date']));?>" <?php } ?> />	
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">Marriage Date </label>
											<div class="col-md-6">
												<input class="form-control date-picker" placeholder="Marriage Date" name="marriage_date" data-date-format="dd-mm-yyyy" type="text" <?php if(@$distributor_row['marriage_date']) { ?> value="<?php echo date('d-m-Y',strtotime(@$distributor_row['marriage_date']));?>" <?php } ?> />
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">SD Amount </label>
											<div class="col-md-6">
												<div class="input-icon right">
													<i class="fa"></i>
													<input value="<?php echo @indian_format_price($distributor_row['sd_amount'])?>" class="form-control numeric" onkeyup="javascript:this.value=Comma(this.value);" type="text" name="sd_amount">
												</div>		
											</div>
										</div>
									</div>	
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">Date of Birth</label>
											<div class="col-md-6">
												<input class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="Date Of Birth" type="text" name="date_of_birth" <?php if(@$distributor_row['date_of_birth']) { ?> value="<?php echo date('d-m-Y',strtotime(@$distributor_row['date_of_birth']));?>" <?php } ?> />	
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">Executive Code </label>
											<div class="col-md-6">
											<div class="input-icon right">
													<i class="fa"></i>
												<select name="executive_id" class="form-control"> 
												<option value="">-Select Executive-</option>
												<?php 
													foreach($executive_list as $stat)
													{
														$selected = "";
														if($stat['executive_id']== @$distributor_row['executive_id'])
															{ 
																$selected='selected';
															}
														echo '<option value="'.$stat['executive_id'].'" '.$selected.' >'.$stat['executive_code'].' - ('.$stat['name'].')</option>';
													}
												?>
												</select>	
											</div>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">Oustanding Amount </label>
											<div class="col-md-6">
												<div class="input-icon right">
													<i class="fa"></i>
													<input value="<?php echo @$distributor_row['outstanding_amount'];?>" class="form-control"  type="text" name="outstanding_amount">
												</div>		
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label class="col-md-4 control-label" for="form-field-1">Distributor Place</label>
											<div class="col-md-6">
												<div class="input-icon right">
													<i class="fa"></i>
													<input type="text" class=" form-control" style="height:30px;" name="distributor_place" placeholder = "Distributor Place" value="<?php echo @$distributor_row['distributor_place'];?>">
												</div>	
											</div>
										</div>
									</div>
								</div>
								<?php } 
								if($type_id==2 || $type_id==4){ ?>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label class="col-md-4 control-label" for="form-field-1"><?php echo $type_name; ?> Agent <span class="font-red required_fld">*</span></label>
												<div class="col-md-6">
												<div class="input-icon right">
														<i class="fa"></i>
													<select name="agent_id" class="form-control"> 
													
													<?php 
													
													if(count(@$agentlist)>0)
													{ ?>
														<option value="">-Select <?php echo $type_name; ?> Agent-</option>
														<?php
														foreach($agentlist as $agent)
														{
															$selected = "";
															if($agent['distributor_id']== @$distributor_row['agent_id'])
																{ 
																	$selected='selected';
																}
															echo '<option value="'.$agent['distributor_id'].'" '.$selected.' >'.$agent['name'].'</option>';
														}
													}
													else
													{
														echo '<option value="" >No Records Found</option>';

													}

														
													?>
													</select>	
												</div>
												</div>
											</div>
										</div>
									</div>
									<?php } ?>
								
								<?php if($type_id==1 || $type_id==3 || $type_id==5 || $type_id==6 ){ ?>
								<a  id="add_bank_info" class="btn blue tooltips">Add New</i></a>
								<div class="table-scrollable form-body">
									<table class="table table-bordered table-striped table-hover bank_table">
										<thead>
											<tr>
												<th style="width:17%">Bank Name</th>
												<th style="width:17%">Account No.</th>
												<th style="width:15%">IFSC Code</th>
												<th style="width:15%">BG Amount</th>
												<th style="width:13%">Start Date</th>
												<th style="width:13%">End Date</th>
												<th style="width:10%">Delete</th>
											</tr>
										</thead>
										<tbody>
										<?php
											if(count(@$bank_g)>0)
											{
												$i=0;
												foreach($bank_g as $bg)
												{
													//print_r($bank_type); exit();
												$disabled=($i==0)?'style="display:none" ':'';
												$i++;
											?>	
													<tr>
														<td style="width:17%">
															<div class="dummy">
															<div class="input-icon right">
																<i class="fa"></i>
																<select name="bank_id[]" class="form-control" > 
																	<option value="">Select Bank</option>
																	<?php 
																		foreach($bank as $ban)
																		{
																			$selected = '';
																			if($ban['bank_id'] == @$bg['bank_id'])
																			{
																				$selected = 'selected';
																			}
																			echo '<option value="'.$ban['bank_id'].'" '.$selected.'>'.$ban['name'].'</option>';
																		}
																	?>
																</select>
															</div>
															</div>
															</td>
															<td style="width:17%">
																<div class="dummy">
								                                	<div class="input-icon right">
				                    									<i class="fa"></i>
						                                				<input type="text" class="form-control" maxlength="25" name="account_no[]" value="<?php echo $bg['account_no'];?>"/>
						                                			</div>
						                                		</div>
															</td>
															<td style="width:15%">
																<div class="dummy">
								                                	<div class="input-icon right">
				                    									<i class="fa"></i>
						                                				<input type="text" class="form-control" name="ifsc_code[]" value="<?php echo $bg['ifsc_code'];?>"/>
						                                			</div>
						                                		</div>
															</td>
															<td style="width:15%">
																<div class="dummy">
								                                	<div class="input-icon right">
				                    									<i class="fa"></i>
						                                				<input type="text" class="form-control numeric" onkeyup="javascript:this.value=Comma(this.value);" name="bg_amount[]" value="<?php echo $bg['bg_amount'];?>"/>
						                                			</div>
						                                		</div>
															</td>
															<td style="width:13%">
																<div class="dummy">
																	<div class="input-icon right">
																		<i class="fa"></i>
								                                		<input class="form-control date-picker start_date" placeholder="Start Date" name="start_date[]" data-date-format="dd-mm-yyyy" type="text" value="<?php echo date('d-m-Y',strtotime(@$bg['start_date']));?>">
								                                	</div>	
						                                		</div>
															</td>
															<td style="width:13%">
																<div class="dummy">
																	<div class="input-icon right">
																		<i class="fa"></i>
								                                		<input class="form-control date-picker end_date" placeholder="End Date" name="end_date[]" data-date-format="dd-mm-yyyy" type="text" value="<?php echo date('d-m-Y',strtotime(@$bg['end_date']));?>"/>
								                                	</div>	
						                                		</div>
															</td>
															
													        <td <?php echo $disabled;?> style="width:10%" ><a  class="btn btn-danger btn-sm remove_bank_row" > <i class="fa fa-trash-o"></i></a></td>
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
																	<select name="bank_id[]" class="form-control" > 
																		<option value="">Select Bank</option>
																		<?php 
																			foreach($bank as $bank)
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
						                                				<input type="text" class="form-control" maxlength="25" name="account_no[]">
						                                			</div>
						                                		</div>
															</td>
															<td>
																<div class="dummy">
								                                	<div class="input-icon right">
				                    									<i class="fa"></i>
						                                				<input type="text" class="form-control" name="ifsc_code[]">
						                                			</div>
						                                		</div>
															</td>
															<td>
																<div class="dummy">
								                                	<div class="input-icon right">
				                    									<i class="fa"></i>
						                                				<input type="text" class="form-control numeric"onkeyup="javascript:this.value=Comma(this.value);" name="bg_amount[]" />
						                                			</div>
						                                		</div>
															</td>
															<td>
																<div class="dummy">
																	<div class="input-icon right">
																		<i class="fa"></i>
									                                	<input class="form-control date-picker start_date" placeholder="Start Date" name="start_date[]" data-date-format="dd-mm-yyyy" type="text" />
									                                </div>	
						                                		</div>
															</td>
															<td>
																<div class="dummy">
																	<div class="input-icon right">
																		<i class="fa"></i>
						                                				<input class="form-control date-picker start_date" placeholder="End Date" name="end_date[]" data-date-format="dd-mm-yyyy" type="text" />
						                                			</div>	
						                                		</div>
															</td>
															
													        <td style="display:none;" ><a class="btn btn-danger btn-sm remove_bank_row"> <i class="fa fa-trash-o"></i></a></td>
													</tr>
													
												 <?php	
											}
										?>
										</tbody>
									</table>
								</div>
								<?php } ?>


								
								<div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-5 col-md-6">
                                        <button type="submit" class="btn blue">Submit</button>
                                        <a href="<?php echo SITE_URL.'distributor';?>" class="btn default">Cancel</a>
                                    </div>
                                </div>
                            </div>
                           
                        <?php
                    } ?>
                    <?php if(@$flg==3){ ?>
                    <div class="row">                        
                            <div class="col-md-12">
                                <div class=" col-md-2" style="padding:4px 20px">
                                    <div class="mt-widget-3">
                                        <div class="mt-head bg-blue-hoki">
                                            <div class="mt-head-icon">
                                                <i class="fa fa-users" aria-hidden="true"></i>
                                            </div>
                                            <div class="mt-head-desc" style="padding-bottom:20px;"><b>Regular</b></div>
                                            <div class="mt-head-button">
                                                <button type="submit" class="btn btn-circle btn-outline white btn-sm" formaction="<?php echo SITE_URL.'add_distributor/'.cmm_encode(1);?>">Add</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-2" style="padding:4px 20px">
                                    <div class="mt-widget-3">
                                        <div class="mt-head bg-yellow">
                                            <div class="mt-head-icon">
                                                <i class="fa fa-street-view" aria-hidden="true"></i>
                                            </div>
                                            <div class="mt-head-desc" style="padding-bottom:20px;"><b>CST (Regular)</b></div>
                                            <div class="mt-head-button">
                                                <button type="submit" class="btn btn-circle btn-outline white btn-sm" formaction="<?php echo SITE_URL.'add_distributor/'.cmm_encode(3);?>">Add</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-2" style="padding:4px 20px">
                                    <div class="mt-widget-3">
                                        <div class="mt-head" style="background-color: #86c556;">
                                            <div class="mt-head-icon">
                                                <i class="fa fa-user" aria-hidden="true"></i> 	
                                            </div>
                                            <div class="mt-head-desc" style="padding-bottom:20px;"><b>Institution Agent</b></div>
                                            <div class="mt-head-button">
                                                <button type="submit" class="btn btn-circle btn-outline white btn-sm" formaction="<?php echo SITE_URL.'add_distributor/'.cmm_encode(5);?>">Add</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-2" style="padding:4px 20px">
                                    <div class="mt-widget-3">
                                        <div class="mt-head bg-red">
                                            <div class="mt-head-icon">
                                                <i class="fa fa-male" aria-hidden="true"></i>
                                            </div>
                                            <div class="mt-head-desc" style="padding-bottom:20px;"><b>Institution</b></div>
                                            <div class="mt-head-button">
                                                <button type="submit" class="btn btn-circle btn-outline white btn-sm" formaction="<?php echo SITE_URL.'add_distributor/'.cmm_encode(2);?>">Add</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-2" style="padding:4px 20px">
                                    <div class="mt-widget-3">
                                        <div class="mt-head" style="background-color:#bb7878;">
                                            <div class="mt-head-icon">
                                                <i class="fa fa-user-secret" aria-hidden="true"></i>
                                            </div>
                                            <div class="mt-head-desc"><b>CST (Institution) Agent</b></div>
                                            <div class="mt-head-button">
                                                <button type="submit" class="btn btn-circle btn-outline white btn-sm" formaction="<?php echo SITE_URL.'add_distributor/'.cmm_encode(6);?>">Add</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                
                                <div class="col-md-2" style="padding:4px 20px">
                                    <div class="mt-widget-3">
                                        <div class="mt-head" style="background-color: #6eafb5">
                                            <div class="mt-head-icon">
                                                <i class="fa fa-user-plus" aria-hidden="true"></i>
                                            </div>
                                            <div class="mt-head-desc" style="padding-bottom:20px;"><b>CST (Institution)</b></div>
                                            <div class="mt-head-button">
                                                <button type="submit" class="btn btn-circle btn-outline white btn-sm" formaction="<?php echo SITE_URL.'add_distributor/'.cmm_encode(4);?>">Add</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                
                                
                            </div>
                        </div>

                    <?php
                	} ?>
                	 </form>
                	 <?php
                    if(isset($display_results)&&$display_results==1)
                    {
                    ?>
                        <form method="post" action="<?php echo SITE_URL.'distributor'?>">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input class="form-control" name="distributor_code" value="<?php echo @$search_data['distributor_code'];?>" placeholder="Distributor Code" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input class="form-control" name="agency_name" value="<?php echo @$search_data['agency_name'];?>" placeholder="Agency Name" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <select class="form-control" name="type_id" >
                                    <option value="">-Select Type- </option>
                                        <?php 
                                            foreach($typelist as $type)
                                            {
                                                $selected = '';
                                                if($type['type_id'] == @$search_data['type_id']) $selected = 'selected';
                                                echo '<option value="'.$type['type_id'].'" '.$selected.'>'.$type['name'].'</option>';
                                            }
                                        ?>
                                </select>
                                    </div>
                                </div>
                               <div class="col-sm-3">
                                    <div class="form-actions">
                                        <button type="submit" name="search_distributor" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                        <button type="submit" name="download_distributor" value="1" formaction="<?php echo SITE_URL.'download_distributor';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
                                        <a  class="btn blue tooltips" href="<?php echo SITE_URL.'distributor';?>" data-original-title="Refresh"> <i class="fa fa-refresh"></i></a>
                                        <a href="<?php echo SITE_URL.'distributor_selection';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                        
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th> Distributor Code </th>
                                        <th> Agency Name </th>
                                        <th> Concerned Person </th>
                                        <th> Phone Number </th>
                                        <th> Type </th>
                                        <th> Actions </th>            
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                if($distributor_results){

                                    foreach($distributor_results as $row){
                                ?>
                                    <tr>
                                        <td> <?php echo $sn++;?></td>
                                        <td> <?php echo $row['distributor_code'];?> </td>
                                        <td> <?php echo $row['agency_name'];?> </td>
                                        <td> <?php echo $row['concerned_person'];?> </td>
                                        <td> <?php echo $row['mobile'];?> </td>
                                        <td> <?php echo $row['type_name'];?> </td>
                                        <td> 
                                            <a class="btn btn-default btn-xs tooltips" href="<?php echo SITE_URL.'edit_distributor/'.cmm_encode($row['distributor_id']);?>"  data-container="body" data-placement="top" data-original-title="Edit Details"><i class="fa fa-pencil"></i></a>
                                            <?php
                                            if($row['status']==1){
                                            ?>
                                            <a class="btn btn-danger btn-xs tooltips"  onclick="return confirm('Are you sure you want to Deactivate?')" href="<?php echo SITE_URL.'deactivate_distributor/'.cmm_encode($row['distributor_id']);?>" data-container="body" data-placement="top" data-original-title="DeActivate"><i class="fa fa-trash-o"></i></a>
                                            <?php
                                            }
                                            if($row['status']==2){
                                            ?>
                                            <a class="btn btn-info btn-xs tooltips"  onclick="return confirm('Are you sure you want to Activate?')" href="<?php echo SITE_URL.'activate_distributor/'.cmm_encode($row['distributor_id']);?>" data-container="body" data-placement="top" data-original-title="Activate"><i class="fa fa-check"></i></a>
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
							?>		<tr><td colspan="7" align="center"> No Records Found</td></tr>		
						<?php	}
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