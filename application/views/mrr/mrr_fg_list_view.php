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
						<form method="post" action="<?php echo SITE_URL.'mrr_fg_list'?>">
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										<input class="form-control" type="text" value="<?php echo @$search_data['mrr_number'];?>" name="mrr_number" placeholder="MRR Number">
									</div>
								</div>
								<div class="col-md-3">
                                    <div class="input-group date-picker input-daterange " data-date-format="dd-mm-yyyy">
                                        <input class="form-control " name="from_date"  placeholder="From" type="text" <?php if($search_data['from_date']!='') { ?> value="<?php echo date('d-m-Y',strtotime(@$search_data['from_date']));?>" <?php } ?> >
                                        <span class="input-group-addon"> to </span>
                                        <input class="form-control " name="to_date"  placeholder="To" type="text" <?php if($search_data['to_date']!='') { ?> value="<?php echo date('d-m-Y',strtotime(@$search_data['to_date']));?>" <?php } ?> >
                                    </div>
                                </div> 
								<div class=" col-sm-3">
									<div class="form-actions">
										<button type="submit" name="search_mrr" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
										<!-- <button type="submit" name="download_mrr" value="1" formaction="<?php echo SITE_URL.'download_mrr_fg';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button> -->
										<a  class="btn blue tooltips" href="<?php echo SITE_URL.'mrr_fg_list';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
										<button type="submit" name="print_mrr_fg_list" value="1" formaction="<?php echo SITE_URL.'print_mrr_fg_list';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Print"><i class="fa fa-print"></i></button>
									</div>
								</div>
							</div>
						</form>
						<div class="table-scrollable">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th>S.No</th>
										<th>MRR Number</th>
										<th>Tanker Number</th>
										<th>MRR Date</th>
										<th>Free Gift Name</th>
										<th>Received Quantity</th>
										<th>Ledger Number</th>
										<th>Folio Number</th>
									</tr>
								</thead>
								<tbody>
									<?php
									$sn=1;
									if($mrr_fg_results){
										foreach($mrr_fg_results as $row) {
										?>
										<tr>
											<td><?php echo $sn++; ?></td>
											<td><?php echo $row['mrr_number']; ?></td>
											<td><?php echo $row['tanker_in_number']; ?></td>
											<td><?php echo date('d-m-Y',strtotime($row['mrr_date'])); ?></td>
											<td><?php echo $row['freegift_name']; ?></td>
											<td><?php echo $row['received_qty']; ?></td>
											<td><?php echo $row['ledger_number']; ?></td>
											<td><?php echo $row['folio_number']; ?></td>
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
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('commons/main_footer', $nestedView); ?>