 <?php $this->load->view('commons/main_template', $nestedView); ?>

 <!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN BORDERED TABLE PORTLET-->
			<div class="portlet light portlet-fit">
				<div class="portlet-body">
					<?php
					if(isset($display_results)&& $display_results==1)
					{
						?>
						<form method="post" action="<?php echo SITE_URL.'region_wise_distributor_r'?>">
							<div class="row">
								<div class="col-md-2">
									<div class="form-group">
										<input type="text" class="form-control" name="dist_code" value="<?php echo @$search_data['dist_code']?>" placeholder="Distributor Code">
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<input type="text" class="form-control" name="dist_name" value="<?php echo @$search_data['dist_name']?>" placeholder="Distributor Name">
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<select  id="region" name="d_type" class="form-control">
                                        <option value="">-Select Distributor Type-</option> 
                                        <?php
                                        foreach($distributor_type as $row)
                                        {
                                        	$selected = "";
											if($row['type_id']== @$search_data['dist_type'])
												{ 
													$selected='selected';
												}
                                        	echo '<option value="'.$row['type_id'].'" '.$selected.'>'.$row['name'].'</option>';
                                        }
                                        ?>
                                        </select>	
									</div>	
								</div>
								<div class="col-md-3">
									<div class="form-group">
										<select  id="region" name="executive" class="form-control">
                                        <option value="">-Select Executive-</option> 
                                        <?php
                                        foreach($executive as $row)
                                        {
                                        	$selected = "";
											if($row['executive_id']== @$search_data['executive'])
												{ 
													$selected='selected';
												}
                                        	echo '<option value="'.$row['executive_id'].'" '.$selected.'>'.$row['name'].'</option>';
                                        }
                                        ?>
                                        </select>	
									</div>
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<select id="region" name="region" class="form-control region">
                                        <option value="">-Select Region-</option> 
                                        <?php
                                        foreach($region as $row)
                                        {
                                        	$selected = "";
											if($row['location_id']== @$search_data['region'])
												{ 
													$selected='selected';
												}
                                        	echo '<option value="'.$row['location_id'].'" '.$selected.'>'.$row['name'].'</option>';
                                        }
                                        ?>
                                        </select>	
									</div>	
								</div>
								<div class="col-md-2">
									<div class="form-group">
										<select  name="district" class="form-control district">
                                        	<option value="">-Select District-</option>
                                        	<?php
                                        	if(count($search_data)!='')
                                        		foreach($dist as $row)
                                        		{
                                        			$selected="";
                                        			if($row['location_id']==@$search_data['district'])
                                        			{
                                        				$selected='selected';
                                        			}
                                        			echo '<option value="'.$row['location_id'].'" '.$selected.'>'.$row['name'].'</option>';
                                        		}
                                        	?>
                                        </select>
                                    </div>	
								</div>
								<input type="hidden" name="dist" class="dist_name" value="<?php echo $search_data['district']?>">
								<div class="col-sm-3">
									<div class="form-actions">
										<button type="submit" name="search_dist" value="1" class="btn blue btn-sm tooltips search" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
										<button type="submit" name="print_distributor_list" value="1" formaction="<?php echo SITE_URL.'download_region_wise_distributor_r';?>" class="btn blue btn-sm tooltips" data-container="body" data-placement="top" data-original-title="Print"><i class="fa fa-print"></i></button>
										<a class="btn blue btn-sm tooltips" href="<?php echo SITE_URL.'region_wise_distributor_r';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
									</div>
								</div>
							</div>
						</form>
						<div class="table-scrollable">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>S.No</th>
										<th>Type</th>
										<th>Agency Name</th>
										<th>Address</th>
										<th>Phone</th>
										<th>Executive</th>
										<th>SD Amount</th>	
										<th>Available Amount</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$sn=1;
									if($distributor_results){
										foreach($distributor_results as $row) {
											$address = array();
											$bg_amount = ($row['bg_amt']>0)?$row['bg_amt']:0;
											if($row['address']!='')
											$address[] = trim($row['address'],', ');
											if($row['distributor_place']!='')
											$address[] = $row['distributor_place'];
										?>
										<tr>
											<td><?php echo $sn++; ?></td>
											<td><?php echo $row['type_name']; ?></td>
											<td><?php echo $row['agency_name'].'['.$row['distributor_code'].']'; ?></td>
											<td><?php echo implode(', ', $address); ?></td>
											<td><?php echo $row['mobile'];?></td>
											<td><?php echo $row['exe_name']; ?></td>
											<td align="right"><?php if($row['sd_amount']){ echo price_format($row['sd_amount']);} else { echo '--';} ?></td>
											<td align="right"><?php if($row['type_id']!=2 && $row['type_id']!=4 ){ echo  price_format($row['outstanding_amount']+$row['sd_amount']+$bg_amount);} else { echo '--';} ?></td>
											<td>
												<a class="btn btn-default btn-xs tooltips" href="<?php echo SITE_URL.'view_distributor_details/'.cmm_encode($row['distributor_id']);?>"  data-container="body" data-placement="top" data-original-title="View Details"><i class="fa fa-eye" aria-hidden="true"></i></a>
											</td>
										</tr> <?php
										}
									}
									else
									{
										?>
										<tr><td colspan="8" align="center"> No Records Found</td></tr>
										<?php
									} ?>
								</tbody>
							</table>
						</div> <?php
					} ?>
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
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('commons/main_footer', $nestedView); ?>
<script type="text/javascript">
$(document).ready(function(){
	$(".region").change(function () { 
    var region_id=$(this).val();
    
    if(region_id=='')
    {
        $(".district").html('<option value="">-Select Type-</option');
        $(this).focus();
    }
    else
    {  
        $.ajax({
        type:"POST",
            url:SITE_URL+'get_district_based_region',
            data:{region_id:region_id},
            cache:false,
            success:function(html){
                $(".district").html(html);
            }
        });
    }
});
});
</script>