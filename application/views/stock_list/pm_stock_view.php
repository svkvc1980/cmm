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
						<form method="post" action="<?php echo SITE_URL.'pm_stock'?>">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<input class="form-control" name="pm_name" value="<?php echo @$search_data['pm_name'];?>" placeholder="Packing Material Name" type="text">
									</div>
								</div>
								<div class="col-md-3">
                                    <div class="form-group">
                                        <select name="category" class="form-control">
                                        <option value="">-Select Category-</option> 
                                        <?php
                                        foreach($category as $row)
                                        {
                                        	$selected = "";
											if($row['pm_category_id']== @$search_data['category'])
												{ 
													$selected='selected';
												}
                                        	echo '<option value="'.$row['pm_category_id'].'" '.$selected.'>'.$row['name'].'</option>';
                                        }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <div class=" col-sm-3">
                                    <div class="form-actions">
                                        <button type="submit" name="search_stock" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                        <button type="submit" name="download_stock" value="1" formaction="<?php echo SITE_URL.'download_pm_stock';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
                                        <a  class="btn blue tooltips" href="<?php echo SITE_URL.'pm_stock';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
                                    </div>
                                </div>
							</div>
						</form>
						<div class="table-scrollable">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th> S.No</th>
										<th>Packing Material Name</th>
										<th>Category</th>
										<th>Quantity</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if($pm_results) {
										foreach($pm_results as $row)
										{
										?>
											<tr>
												<td><?php echo $sn++;?></td>
												<td><?php echo $row['name'];?></td>
												<td><?php echo $row['category'];?></td>
												<td><?php echo round($row['quantity']).' '.'('.$row['units'].')';?></td>
											</tr>
										<?php	
										}
									}
									else
									{
									 ?>	
									 	<tr><td colspan="5" align="center"> No Records Found</td></tr>
										<?php
									}
									?>
								</tbody>
							</table>
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