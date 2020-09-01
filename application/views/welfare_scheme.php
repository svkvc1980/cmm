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
						<form id="welfare_scheme_form" method="post" action="<?php echo $form_action;?>" class="form-horizontal">
							<?php
							if($flg==2)
							{
								?>
								<input type="hidden" name="encoded_id" value="<?php echo cmm_encode($welfare_scheme_row['welfare_scheme_id']);?>">
								<?php
							}
							?>
							<div class="alert alert-danger display-hide" style="display: none;">
								<button class="close" data-close="alert"></button> You have some form errors. Please check below. 
							</div>
					<div class="form-group">
                      <label class="col-md-4 control-label">Scheme Name<span class="font-red  spcls required_fld">*</span></label>
                        <div class="col-md-4">
                          <div class="input-icon right">
                             <i class="fa"></i>
                           <input class="form-control" placeholder="name" name="name" type="text" value="<?php echo @$welfare_scheme_row['name'];?>" >
                          </div>  
                        </div>
                    </div>
					<div class="form-group">
                      <label class="col-md-4 control-label">Description<span ></span></label>
                       <div class="col-md-4">
                          <div class="input-icon right">
                              <i class="fa"></i>
								<textarea  class="form-control" style="height:50px;"  name="description"><?php echo @$welfare_scheme_row['description'];?></textarea>
							</div>
						</div>
					</div>
								
					<div class="form-group">
                       <label class="col-md-4 control-label">Date Range<span class="font-red  spcls required_fld">*</span></label>
                       <div class="col-md-4">
                            <div class="input-group date-picker input-daterange " data-date-format="dd-mm-yyyy">
							 	<input class="form-control" name="start_date"  placeholder="Start Date" type="text" value="<?php if(@$welfare_scheme_row['start_date']!=''){ echo @date('d-m-Y',strtotime($welfare_scheme_row['start_date'])); }?>" >
								<span class="input-group-addon"> to </span>
                                <div class="input-icon right">
                              	    <i class="fa"></i>
                                    <input class="form-control " name="end_date" placeholder="End Date" type="text" value="<?php if(@$welfare_scheme_row['end_date']!=''){ echo @date('d-m-Y',strtotime($welfare_scheme_row['end_date'])); }?>">
                                </div>
                            </div>
						</div>
					</div>
					
					<div class="form-group">
                      <label class="col-md-4 control-label">Discount(%)on MRP<span class="font-red  spcls required_fld">*</span></label>
                       <div class="col-md-4">
                          <div class="input-icon right">
                              <i class="fa"></i>
							<input  type="number"  class="form-control" placeholder="(0-100)%" style="height:30px;"  name="discount_percentage"  value="<?php echo @$welfare_scheme_row['discount_percentage'];?>" >
							</div>
						</div>
					</div>
					<div class="form-actions">
                       <div class="row">
                          <div class="col-md-offset-5 col-md-6">
                           <button type="submit" class="btn blue" name="submit" value="button">Submit</button>
                            <a href="<?php echo SITE_URL.'welfare_scheme';?>" class="btn default">Cancel</a>
                          </div>
                      </div>
                    </div>
			      </form>
						<?php
					}
					if(isset($display_results)&&$display_results==1)
					{
					?>
						<form method="post" action="<?php echo SITE_URL.'welfare_scheme'?>">
							<div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="form-control" name="name" value="<?php echo @$search_data['name'];?>" placeholder="Name" type="text">
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="start_date" value="<?php if(@$search_data['start_date']!=''){ echo date('d-m-Y',strtotime($search_data['start_date'])); }?>" placeholder="From date" type="text">
                                    </div>
                                </div>

                                 <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="end_date" value="<?php if(@$search_data['end_date']!=''){ echo date('d-m-Y',strtotime($search_data['end_date'])); }?>" placeholder="To date" type="text">
                                    </div>
                                </div>

                                 <div class="col-md-2">
                                    <div class="form-group">
                                        <input type="number" class="form-control" name="discount_percentage" value="<?php echo @$search_data['discount_percentage'];?>" placeholder="percentage" >
                                    </div>
                                </div>
                                
                                <div class=" col-sm-3">
                                    <div class="form-actions">
                                        <button type="submit" name="search_welfare_scheme" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                        <button type="submit" name="download_welfare_scheme" value="1" formaction="<?php echo SITE_URL.'download_welfare_scheme';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
                                        <a  class="btn blue tooltips" href="<?php echo SITE_URL.'welfare_scheme';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
                                        <a href="<?php echo SITE_URL.'add_welfare_scheme';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                        
                                    </div>
                                </div>
                            </div>
						</form>
						<div class="table-scrollable">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th> S.No</th>
										<th>Name</th>
										<th>Description</th>
										<th>Start Date</th>
										<th>End Date </th>
										<th>Discount percentage</th>
										<th>action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if($welfare_scheme_row){
										foreach($welfare_scheme_row as $row){
									?>	
										<tr>
											<td> <?php echo $sn++;?></td>
											<td> <?php echo $row['name'];?> </td>
                                        	<td> <?php echo $row['description'];?> </td>
                                        	<td> <?php echo date('d-m-Y',strtotime($row['start_date']));?> </td>
                                        	<td> <?php echo date('d-m-Y',strtotime($row['end_date']));?> </td>
                                        	<td> <?php echo $row['discount_percentage'];?> </td>
                                        	<td>  
                                              <a class="btn btn-default btn-xs tooltips" href="<?php echo SITE_URL.'edit_welfare_scheme/'.cmm_encode($row['welfare_scheme_id']);?>"  data-container="body" data-placement="top" data-original-title="Edit Details"><i class="fa fa-pencil"></i></a>
                                        		<?php
	                                            
	                                            if($row['status']==1){
	                                            ?>
	                                            <a class="btn btn-danger btn-xs tooltips"  onclick="return confirm('Are you sure you want to Deactivate?')" href="<?php echo SITE_URL.'deactivate_welfare_scheme/'.cmm_encode($row['welfare_scheme_id']);?>" data-container="body" data-placement="top" data-original-title="DeActivate"><i class="fa fa-trash-o"></i></a>
	                                            <?php
	                                            }
	                                           else{
	                                            ?>
	                                            <a class="btn btn-info btn-xs tooltips"  onclick="return confirm('Are you sure you want to Activate?')" href="<?php echo SITE_URL.'activate_welfare_scheme/'.cmm_encode($row['welfare_scheme_id']);?>" data-container="body" data-placement="top" data-original-title="Activate"><i class="fa fa-check"></i></a>
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
			<!-- END BORDERED TABLE PORTLET-->
		</div>
	</div>
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>