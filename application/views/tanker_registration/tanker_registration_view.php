<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN BORDERED TABLE PORTLET-->
			<div class="portlet light portlet-fit">
				<div class="portlet-body">
					<?php
					if(isset($display_results)&&$display_results==1)
					{
						?>
						<form method="post" action="<?php echo SITE_URL.'tanker_register'?>">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<input class="form-control" name="vehicle_num" value="<?php echo @$search_data['vehicle_num'];?>" placeholder="Vehicle Number" type="text">
									</div>
								</div>
								<div class="col-md-3">
                                    <div class="form-group">
                                        <select name="tanker_type" class="form-control">
                                        <option value="">-Select Vehicle Type-</option> 
                                        <?php
                                        foreach($tanker as $row)
                                        {
                                        	$selected = "";
											if($row['tanker_type_id']== @$search_data['tanker_type'])
												{ 
													$selected='selected';
												}
                                        	echo '<option value="'.$row['tanker_type_id'].'" '.$selected.'>'.$row['name'].'</option>';
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                <div class="input-group date-picker input-daterange " data-date-format="dd-mm-yyyy">
                                    <input class="form-control" name="start_date"  placeholder="From Date" type="text" value="<?php if(@$search_data['start_date']!=''){ echo @date('d-m-Y',strtotime($search_data['start_date'])); }?>" >
                                    <span class="input-group-addon"> to </span>
                                        <input class="form-control " name="end_date" placeholder="To Date" type="text" value="<?php if(@$search_data['end_date']!=''){ echo @date('d-m-Y',strtotime($search_data['end_date'])); }?>">
                                </div>
                            </div>
                                <div class=" col-sm-3">
                                    <div class="form-actions">
                                        <button type="submit" name="search_tanker" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                        <button type="submit" name="download_tanker" value="1" formaction="<?php echo SITE_URL.'download_tanker_details';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
                                        <a  class="btn blue tooltips" href="<?php echo SITE_URL.'tanker_register';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
                                    	  <button type="submit" name="print_vehicle_details" value="1" formaction="<?php echo SITE_URL.'print_vehicle_details';?>" class="btn btn-danger tooltips" data-container="body" data-placement="top" data-original-title="Print"><i class="fa fa-print"></i></button>
                                    </div>
                                </div>
							</div>
						</form>
						<div class="table-scrollable">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>S.No</th>
										<th>Product</th>
										<th>Vehicle In Number</th>
										<th>Vehicle Type</th>
										<th>Vehicle Number</th>
										<th>In Time</th>
										<th>Actions </th>
									</tr>
								</thead>
								<tbody>
									<?php
									if($tanker_results) {
										foreach($tanker_results as $row)
										{
										?>
											<tr>
												<td><?php echo $sn++;?></td>
												<td><?php
	                                                switch ($row['tanker_type_id']) 
	                                                {
	                                                    case 1:
	                                                        echo $row['loose_oil'];
	                                                    break;

	                                                    case 2:
	                                                        echo $row['packing_material'];
	                                                    break;

	                                                    case 5:
	                                                        echo $row['free_gift'];
	                                                    break;    
	                                                     
	                                                    default:
	                                                        echo "--";
	                                                    break;
	                                                }?>
                                            	</td>
												<td><?php echo $row['tanker_in_number'];?></td>
												<td><?php echo $row['tanker_name'];?></td>
												<td><?php echo $row['vehicle_number'];?></td>
												<td><?php echo date('d-m-Y H:i:s',strtotime($row['in_time']));?></td>
												<td><a class="btn btn-default btn-xs tooltips" data-container="body" data-placement="top" data-original-title="Print"  href="<?php echo SITE_URL.'print_tanker_details/'.cmm_encode($row['tanker_id']);?>"><i class="fa fa-print"></i></a></td>
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
		</div>
	</div>
</div>
<?php $this->load->view('commons/main_footer', $nestedView); ?>