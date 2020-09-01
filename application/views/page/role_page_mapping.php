<?php
	$this->load->view('commons/main_template',$nestedView); 
?>
<?php

?>

<div class="row"> 
	<div class="col-sm-12 col-md-12">
		<div class="portlet light portlet-fit">
			<table class="table table-bordered"></table>
			<div class="portlet-body">
				<div class="row">
					<form role="form" id="role_page_map" class="form-horizontal" method="post" action="<?php echo SITE_URL;?>rolePageMapping">
						<input type="hidden" name="action" value="1">
						<div class="form-group">
							<label class="col-sm-2 control-label">Block Designation</label>
							<div class="col-sm-4">
                                <select name="block_designation_id" class="form-control" onchange="this.form.submit()" id="map_role_id">
                                	<option value="">Choose Block Designation</option>
                                	<?php
                                	foreach ($block_designation_list as $rrow) {
                                		$selected = ($block_designation_id == $rrow['block_designation_id'])?'selected':'';
                                		echo '<option value="'.$rrow['block_designation_id'].'" '.$selected.'>'.$rrow['desig_name'].'  ('.$rrow['block_name'].')</option>';
                                	}
                                	?>
                                </select>
							</div>
						</div>
						<?php
						if($block_designation_id>0){
						?>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-5">
								<button type="submit" title="Submit" formaction="submit_rolePageMapping" name="save_changes" value="1" class="btn blue">Save Changes</button>
								<a title="Cancel" href="<?php echo SITE_URL.'rolePageMapping';?>" class="btn default">Cancel</a>
							</div>
						</div>
						<div class="table-scrollable">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th><strong>Page Name</strong></th>
										<th><strong>Enable</strong></th>
									</tr>
								</thead>
								<tbody>
								<?php
									
									if(count(@$pageSearch)>0)
									{
										foreach(@$pageSearch as $row)
										{
											$chkd = (in_array(@$row['page_id'], $bd_pages))?'checked':'';
											?>
											<tr>
												<td><?php echo @$row['name'];?></td>
												<td><input type="checkbox" name="page[]" <?php echo $chkd;?> value="<?php echo @$row['page_id'];?>"></td>
											</tr>
								<?php	}
									} else {
									?>	<tr><td colspan="2" align="center"><span class="label label-primary">No Records</span></td></tr>
							<?php 	} ?>
								</tbody>
							</table>
						</div>
						<?php
						}
						?>
					</form>
				</div>
			</div>
		</div>				
	</div>
</div>
	
<?php
	$this->load->view('commons/main_footer.php',$nestedView); 
?>