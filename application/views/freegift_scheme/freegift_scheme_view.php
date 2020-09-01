<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN BORDERED TABLE PORTLET-->
			<div class="portlet light portlet-fit">
				<div class="portlet-body">
					<?php
					if(@$flg==1)
					{
					?>
						<form class="form-horizontal" action="<?php echo $form_action;?>" id="submit_form" method="POST">
						<div class="col-md-12">
								<div class="col-md-6">
									
									<div class="form-group">
										<label class="col-md-4 control-label">Scheme Name <span class="font-red required_fld">*</span></label>
										<div class="col-md-8">
												<input  class="form-control" required value="<?php echo @$fg_row['name'];?>" type="text" maxlength="25" name="scheme_name">
											</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-3 control-label" for="form-field-1">Scheme Type <span class="font-red required_fld">*</span></label>
										<div class="col-md-6">
												<select name="scheme_type_id" class="form-control" required> 
												<option value="">-Select Scheme Type-</option>
												<?php 
													foreach($scheme_type_list as $key => $value)
													{
														$selected = "";
														if($key == @$fg_row['type_id'])
															{ 
																$selected='selected';
															}
														echo '<option value="'.$key.'" '.$selected.' >'.$value.'</option>';
													}
												?>
												</select>	
										</div>
									</div>
									
								</div>
							</div>
							<div class="col-md-12">
								<div class="col-md-6">
									<div class="form-group">
			                       <label class="col-md-4 control-label">Date Range<span class="font-red  spcls required_fld">*</span></label>
			                       <div class="col-md-8">
			                            <div class="input-group date-picker input-daterange " data-date-format="dd-mm-yyyy">
										 	<input class="form-control" name="start_date" required placeholder="Start Date" type="text" value="<?php if(@$welfare_scheme_row['start_date']!=''){ echo @date('d-m-Y',strtotime($welfare_scheme_row['start_date'])); }?>" >
											<span class="input-group-addon"> to </span>
			                                    <input class="form-control " name="end_date" required placeholder="End Date" type="text" value="<?php if(@$welfare_scheme_row['end_date']!=''){ echo @date('d-m-Y',strtotime($welfare_scheme_row['end_date'])); }?>">
			                            </div>
									</div>
								</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
									<label class="col-md-3 control-label">Description</label>
									<div class="col-md-6">
										<div class="input-icon right">
											<i class="fa"></i>
											<textarea class=" form-control" cols="2" name="description" ><?php echo @$fg_row['description'];?></textarea>
										</div>
									</div>
								</div>
								</div>
							</div>
								
								
								
								
							<div class="row">
							<div class="col-md-offset-11 col-md-1">
                            <a  id="add_new" style="float: right;" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i>Add New </a></div></div>
							<div class="col-md-12 well">
								<div class="col-md-1">
								<span class="test_sno">1)</span>
								</div>
                                    <div class="col-md-4">
											<label class="col-md-5 control-label" for="form-field-1">Product <span class="font-red required_fld">*</span></label>
											<div class="col-md-7">
						                            <select class="form-control" name="product_id[]" required="required">
						                        	<option value="">-Select Product- </option>
						                            <?php 
						                                foreach($packed_product_list as $pp)
						                                    {
						                                        echo '<option value="'.$pp['product_id'].'">'.$pp['product_name'].''.$pp['capacity_name'].''.$pp['unit_name'].'</option>';
						                                    }
						                            ?>
						                    		</select>
				                    		</div>
									</div> 
									<div class="col-md-3">
											<label class="col-md-5 control-label" for="form-field-1">Type <span class="font-red required_fld">*</span></label>
											<div class="col-md-7">
						                            <select class="form-control" name="type_id[]" required="required">
						                        	<option value="">-Type- </option>
						                            <?php 
						                                foreach($item_type_list as $key => $value)
						                                    {
						                                        $selected = '';
						                                        if($key == @$fg_row['item_type_id']) $selected = 'selected';
						                                        echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
						                                    }
						                            ?>
						                    		</select>
				                    		</div>
									</div> 
									<div class="col-md-3">
											<label class="col-md-5 control-label" for="form-field-1">Gift Type<span class="font-red required_fld">*</span></label>
											<div class="col-md-7">
						                            <select class="form-control gift_type" name="gift_type_id[]" required="required">
						                        	<option value="">-Gift Type- </option>
						                            <?php 
						                                foreach($gift_type_list as $key => $value)
						                                    {
						                                        $selected = '';
						                                        if($key == @$fg_row['gift_type_id']) $selected = 'selected';
						                                        echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
						                                    }
						                            ?>
						                    		</select>
				                    		</div>
									</div>
									<div class="col-md-1 div_remove" style="display: none">
										<div class="form-group">
                                            <a   class="btn btn-sm btn-danger deletebutton tooltips" data-container="body" data-placement="top" data-original-title="Delete"><i class="fa fa-remove"></i></a>
                                        </div>
                                    </div>
								<div class="col-md-12 horizontal" style="display:none"><hr style="border-top: 2px solid #b7bdba;"></div>
								<div class="col-md-12 packedproduct" style="display: none">
									<div class="col-md-offset-1 col-md-4">
										<div class="form-group">
											<label class="col-md-5 control-label" for="form-field-1">Packed Product <span class="font-red required_fld">*</span></label>
											<div class="col-md-7">
						                            <select class="form-control" name="Packed_product_id[]">
						                        	<option value="">-Select Product- </option>
						                            <?php 
						                                foreach($packed_product_list as $pp)
						                                    {
						                                        echo '<option value="'.$pp['product_id'].'">'.$pp['product_name'].''.$pp['capacity_name'].''.$pp['unit_name'].'</option>';
						                                    }
						                            ?>
						                    		</select>
				                    		</div>
				                        </div>

									</div> 
									<div class="col-md-3">
										<div class="form-group">
											<label class="col-md-5 control-label" for="form-field-1">Quantity <span class="font-red required_fld">*</span></label>
											<div class="col-md-7">
													<input type="text" name="pp_quantity[]" class="form-control number" maxlength="5">
												
				                    		</div>
				                        </div>
									</div> 
								</div>
								<div class="col-md-12 freegift" style="display: none">
									<div class="col-md-offset-1 col-md-4">
										<div class="form-group">
											<label class="col-md-5 control-label" for="form-field-1">Gift Product <span class="font-red required_fld">*</span></label>
											<div class="col-md-7">
						                            <select class="form-control" name="fg_product_id[]">
						                        	<option value="">-Select Product- </option>
						                            <?php 
						                                foreach($free_gift_list as $key => $value)
						                                    {
						                                        echo '<option value="'.$key.'">'.$value.'</option>';
						                                    }
						                            ?>
						                    		</select>
						                    	
				                    		</div>
				                        </div>

									</div> 
									<div class="col-md-3">
										<div class="form-group">
											<label class="col-md-5 control-label" for="form-field-1">Quantity <span class="font-red required_fld">*</span></label>
											<div class="col-md-7">
													<input type="text" name="fg_quantity[]" class="form-control number" maxlength="5">
												
				                    		</div>
				                        </div>
									</div> 
								</div>
							</div>
							<div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-5 col-md-6">
                                        <button type="submit"  class="btn blue">Submit</button>
                                        <a href="<?php echo SITE_URL.'freegift_scheme';?>" class="btn default">Cancel</a>
                                    </div>
                                </div>
                            </div>
						</div>
					</form>
					<?php
					}
					if(@$flg == 2){ ?>

					<div>
					<div class="col-md-12">
								<div class="col-md-6">
									
									<div class="form-group">
										<label class="col-md-4 control-label">Scheme Name </label>
										<div class="col-md-8">
										<p class="form-control-static"><b><?php echo $freegift_scheme[0]['name']; ?></b></p>
											</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label class="col-md-3 control-label" for="form-field-1">Scheme Type </label>
										<div class="col-md-6">
												<?php 
													foreach($scheme_type_list as $key => $value)
													{
														$selected = "";
														if($key == @$freegift_scheme[0]['type_id'])
															{ 
																echo "<p class='form-control-static'><b>".$value."</b></p>";
															}
													}
												?>
										</div>
									</div>
									
								</div>
							</div>

					<div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-5 col-md-6">
                                        <a href="<?php echo SITE_URL.'freegift_scheme';?>" class="btn blue">Back</a>
                                    </div>
                                </div>
                            </div>

					</div>

						<?php }
					if(isset($display_results)&&$display_results==1)
					{
					?>
						<form method="post" action="<?php echo SITE_URL.'freegift_scheme'?>">
							<div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <input class="form-control" name="scheme_name" value="<?php echo @$search_data['scheme_name'];?>" placeholder="Scheme Name" type="text">
                                    </div>
                                </div>
		                        <div class="col-sm-3">
                                    <div class="form-group">
                                        <select class="form-control" name="scheme_type_id" >
                                    	<option value="">-Select Scheme Type- </option>
                                        <?php 
                                            foreach($scheme_type_list as $key => $value)
                                                {
                                                    $selected = '';
                                                    if($key == @$search_data['type_id']) $selected = 'selected';
                                                    echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                                                }
                                        ?>
                                		</select>
                                    </div>
                                </div>
                                <div class=" col-sm-3">
                                    <div class="form-actions">
                                        <button type="submit" name="searchFreegift" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                        <!-- <button type="submit" name="download_plant" value="1" formaction="<?php echo SITE_URL.'download_plant';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button> -->
                                        <a  class="btn blue tooltips" href="<?php echo SITE_URL.'freegift_scheme';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
                                        <a href="<?php echo SITE_URL.'add_freegift_scheme';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                        
                                    </div>
                                </div>
                            </div>
						</form>
						<div class="table-scrollable">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th> S.No</th>
										<th>Scheme Name</th>
										<th>Type</th>
										<th>Start Date</th>
										<th>End Date</th>
										<!-- <th>Actions</th> -->
									</tr>
								</thead>
								<tbody>
									<?php
									if(count($freegift_scheme_Results)>0){
										foreach($freegift_scheme_Results as $row){
									?>	
										<tr>
											<td> <?php echo $sn++;?></td>
											<td> <?php echo $row['name'];?> </td>
                                        	<td> <?php echo $row['scheme_type_name']; ?> </td>
                                        	<td> <?php echo date('d-m-Y',strtotime($row['start_date']));?> </td>
                                        	<td> <?php echo date('d-m-Y',strtotime($row['end_date']));?> </td>
                                        	
                                        	<!-- <td>
                                        				<a class="btn btn-default btn-xs tooltips" href="<?php echo SITE_URL.'view_freegift_scheme/'.cmm_encode($row['fg_scheme_id']);?>"  data-container="body" data-placement="top" data-original-title="Edit Details"><i class="fa fa-pencil"></i></a>
	                                            
	                                             <?php
	                                            if($row['status']==1){
	                                            ?>
	                                            <a class="btn btn-danger btn-xs tooltips"  onclick="return confirm('Are you sure you want to Deactivate?')" href="<?php echo SITE_URL.'deactivate_plant/'.cmm_encode($row['fg_scheme_id']);?>" data-container="body" data-placement="top" data-original-title="DeActivate"><i class="fa fa-trash-o"></i></a>
	                                            <?php
	                                            }
	                                            if($row['status']==2){
	                                            ?>
	                                            <a class="btn btn-info btn-xs tooltips"  onclick="return confirm('Are you sure you want to Activate?')" href="<?php echo SITE_URL.'activate_plant/'.cmm_encode($row['fg_scheme_id']);?>" data-container="body" data-placement="top" data-original-title="Activate"><i class="fa fa-check"></i></a>
	                                            <?php
	                                            }
	                                            ?>
	                                        </td> -->
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