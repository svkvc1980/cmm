<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN BORDERED TABLE PORTLET-->
			<div class="portlet light portlet-fit">
				<div class="portlet-body">
						<form method="post" action="<?php echo SITE_URL.'ob_history_oil_R'?>">
							<div class="row">
								<div class="col-md-2">
                                    <div class="form-group">
                                            <?php echo form_dropdown('loose_oil',$loose_oil,@$oil_tanker_row['loose_oil_id'],'class="form-control"');?>
                                         </div>
                                    </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="From Date" type="text"  value="<?php if(@$searchParams['from_date']!=''){echo date('d-m-Y',strtotime(@$searchParams['from_date']));}?>" name="from_date" />    
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="To Date" type="text" value="<?php if(@$searchParams['to_date']!=''){echo date('d-m-Y',strtotime(@$searchParams['to_date']));}?>" name="to_date" />    
                                    </div>
                                </div>
                                 <div class=" col-sm-3">
                                    <div class="form-actions">
                                        <button type="submit" name="search_ob_history_oil_R" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                        <button type="submit" name="download_ob_history_oil_R" value="1" formaction="<?php echo SITE_URL.'download_ob_history_oil_R';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
                                        <a  class="btn blue tooltips" href="<?php echo SITE_URL.'ob_history_oil_R';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
                                    </div>
                                </div>
                            </div>
						</form>
						<div class="table-scrollable">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th> S.No</th>
										<th>Loose Oil</th>
										<th>Status</th>
                                        <th>Date</th>
                                        <th>Time</th>
									</tr>
								</thead>
								<tbody>
									<?php
									if($ob_history_oil_R_row){

										foreach($ob_history_oil_R_row as $row){
									?>	
										<tr>
											<td> <?php echo $sn++;?></td>
											<td> <?php echo $row['loose_oil_name'];?> </td>
											<td><?php echo ($row['status']==1)?"ON":"OFF";?></td>
                                            <td> <?php echo date('d-m-Y',strtotime($row['created_time']));?> </td>
                                            <td> <?php echo date('H:i:s',strtotime($row['created_time']));?> </td>
										</tr>
										<?php		
										}	
									}
									else
									{
									?>
										<tr><td colspan="8" align="center"> No Records Found</td></tr>
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
				</div>
			</div>
			<!-- END BORDERED TABLE PORTLET-->
		</div>
	</div>
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>