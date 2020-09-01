<?php
	$this->load->view('commons/main_template',$nestedView); 
?>
	<?php
		if(@$flg != '')
		{
			//$flg = @$this->global_functions->decode_icrm($_REQUEST['flg']);
			if($flg == 1)
			{
				if($val == 1)
				{
					$formHeading = 'Edit Page Details';
				}
				else
				{
					$formHeading = 'Add New Page';
				}
				?>
					<div class="row"> 
						<div class="col-sm-12 col-md-12">
							<div class="portlet light portlet-fit">
								<!-- <div class="portlet-title">							
									<h4><?php echo $formHeading;?></h4>
								</div> -->
								<div class="portlet-body">
									<form class="form-horizontal" role="form" action="<?php echo SITE_URL; ?>pageAdd"  method="post">
										<input type="hidden" name="page_id" id="page_id" value="<?php echo @$pageEdit[0]['page_id']?>">
										<div class="form-group">
											<label for="inputName" class="col-sm-3 control-label">Page Name <span class="font-red required_fld">*</span></label>
											<div class="col-sm-6">
                                                <input type="name" required class="form-control " id="page_name" placeholder="Page Name" name="page_name" value="<?php echo @$pageEdit[0]['name']; ?>" maxlength="150">
                                                <p id="page_nameValidating" class="hidden"><i class="fa fa-spinner fa-spin"></i> Checking...</p>
												<p id="page_nameError" class="font-red hidden"></p>
											</div>
										</div>
										<div class="form-group">
											<div class="col-sm-offset-3 col-sm-10">
												<button class="btn blue" type="submit" name="submitPage" value="button"><i class="fa fa-check"></i> Submit</button>
												<a class="btn default" href="<?php echo SITE_URL;?>page"><i class="fa fa-times"></i> Cancel</a>
											</div>
										</div>
									</form>
								</div>
							</div>				
						</div>
					</div><br>

					<?php
			}
		}
	?>
<?php
if(@$displayList==1) 
{
?>

<div class="row"> 
	<div class="col-sm-12 col-md-12">
		<div class="portlet light portlet-fit">
			<div class="portlet-body">
				<div class="row">
					<form role="form" class="form-horizontal" method="post" action="<?php echo SITE_URL;?>page">
						<div class="row">
							<label class="col-sm-3 control-label">Page Name</label>
							<div class="col-sm-2">
                                <input type="text" name="pageName" maxlength="150" value="<?php echo @$searchParams['pageName'];?>" id="pageName" class="form-control" placeholder="Page Name">
							</div>
							
							<div class="col-sm-5">
								<button type="submit" title="Search" name="searchPage" value="1" class="btn blue"><i class="fa fa-search"></i> </button>
								<button title="Download" type="submit" name="downloadPage" value="downloadPage" formaction="<?php echo SITE_URL;?>downloadPage" class="btn blue"><i class="fa fa-cloud-download"></i> </button>
								<a href="<?php echo SITE_URL;?>addPage" title="Add New" class="btn blue"><i class="fa fa-plus"></i> </a>
							</div>
						</div>
					</form>
				</div>
				<div class="header"></div>
				<div class="table-scrollable">
					<table class="table table-bordered hover">
						<thead>
							<tr>
								<th class="text-center"><strong>Page ID</strong></th>
								<th class="text-center"><strong>Page Name</strong></th>
								<!--<th class="text-center"><strong>Module</strong></th>-->
								<th class="text-center"><strong>Actions</strong></th>
							</tr>
						</thead>
						<tbody>
						<?php
							
							if(@$total_rows>0)
							{
								foreach(@$pageSearch as $row)
								{?>
									<tr>
										<td class="text-center"><?php echo @$row['page_id'];;?></td>
										<td class="text-center"><?php echo @$row['name'];?></td>
										<td class="text-center">
											<a class="btn btn-default btn-xs" href="<?php echo SITE_URL;?>editPage/<?php echo @cmm_encode($row['page_id']); ?>"><i class="fa fa-pencil"></i></a> 
											<?php
											if(@$row['status'] == 1)
											{
												?>
												<a class="btn btn-danger btn-xs" href="<?php echo SITE_URL;?>deletePage/<?php echo @cmm_encode($row['page_id']); ?>" onclick="return confirm('Are you sure you want to Delete?')"><i class="fa fa-trash-o"></i></a>
												<?php
											}
											else
											{
												?>
												<a class="btn btn-info btn-xs" title="Activate" style="padding:3px 3px;" href="<?php echo SITE_URL;?>activatePage/<?php echo @cmm_encode($row['page_id']); ?>"  onclick="return confirm('Are you sure you want to Activate?')"><i class="fa fa-check"></i></a>
												<?php
											}
											?>
										</td>
									</tr>
						<?php	}
							} else {
							?>	<tr><td colspan="3" align="center"><span class="label label-primary">No Records</span></td></tr>
					<?php 	} ?>
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
			</div>
		</div>				
	</div>
</div>
	
<?php
}
$this->load->view('commons/main_footer', $nestedView);
?>