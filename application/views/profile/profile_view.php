<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN BORDERED TABLE PORTLET-->
			<div class="portlet light portlet-fit">
				<div class="portlet-body">
					<?php
					if($flag==1)
					{
						?>
						<form id="freegift_form" method="post"  class="form-horizontal">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label class="col-md-4 control-label">Name :</label>
									<div class="col-md-6">
										<b class="form-control-static"><?php echo  $ops[0]['name'] ;?> </b>
                                    </div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="col-md-5 control-label">Designation :</label>
									<div class="col-md-6">
										<b class="form-control-static"><?php echo  $ops[0]['designation_name'] ;?> </b>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="col-md-4 control-label">Plant :</label>
									<div class="col-md-6">
										<b class="form-control-static"><?php echo  $ops[0]['plant_name'] ;?> </b>
                                    </div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label class="col-md-4 control-label">Block :</label>
									<div class="col-md-6">
										<b class="form-control-static"><?php echo  $ops[0]['block_name'] ;?> </b>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="col-md-5 control-label">Mobile Number :</label>
									<div class="col-md-5">
										<b class="form-control-static"><?php echo  $ops[0]['mobile'] ;?> </b>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="col-md-4 control-label">Email id :</label>
									<div class="col-md-6">
										<b class="form-control-static"><?php echo  $ops[0]['email'] ;?> </b>
									</div>
								</div>
							</div>
						</div> <?php
					} 
					if($flag==2)
					{ ?>
						<form id="freegift_form" method="post"  class="form-horizontal">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label class="col-md-5 control-label">Name :</label>
									<div class="col-md-6">
										<b class="form-control-static"><?php echo  $distributor[0]['concerned_person'] ;?> </b>
                                    </div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="col-md-5 control-label">Plant :</label>
									<div class="col-md-6">
										<b class="form-control-static"><?php echo  $distributor[0]['plant_name'] ;?> </b>
                                    </div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="col-md-5 control-label">Block :</label>
									<div class="col-md-6">
										<b class="form-control-static"><?php echo  $distributor[0]['block_name'] ;?> </b>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label class="col-md-5 control-label">Distributor Type :</label>
									<div class="col-md-6">
										<b class="form-control-static"><?php echo  $distributor[0]['type_name'] ;?> </b>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="col-md-5 control-label">Distributor Code :</label>
									<div class="col-md-6">
										<b class="form-control-static"><?php echo  $distributor[0]['distributor_code'] ;?> </b>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="col-md-5 control-label">Agency Name :</label>
									<div class="col-md-6">
										<b class="form-control-static"><?php echo  $distributor[0]['agency_name'] ;?> </b>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label class="col-md-5 control-label">Mobile Number :</label>
									<div class="col-md-6">
										<b class="form-control-static"><?php echo  $distributor[0]['mobile'] ;?> </b>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="col-md-5 control-label">Aadhar Number :</label>
									<div class="col-md-6">
										<b class="form-control-static"><?php echo  $distributor[0]['aadhar_no'] ;?> </b>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="col-md-5 control-label">Pan Number :</label>
									<div class="col-md-6">
										<b class="form-control-static"><?php echo  $distributor[0]['pan_no'] ;?> </b>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label class="col-md-5 control-label">Tan Number :</label>
									<div class="col-md-6">
										<b class="form-control-static"><?php echo  $distributor[0]['tan_no'] ;?> </b>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="col-md-5 control-label">VAT Number :</label>
									<div class="col-md-6">
										<b class="form-control-static"><?php echo  $distributor[0]['vat_no'] ;?> </b>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label class="col-md-5 control-label">SD Amount :</label>
									<div class="col-md-6">
										<b class="form-control-static"><?php echo  $distributor[0]['sd_amount'] ;?> </b>
									</div>
								</div>
							</div>
						</div>
						<div class="table-scrollable">
							<table class="table table-bordered table-striped table-hover" id="bank_table">
								<thead>
									<tr>
										<th style="width:15%">Bank Name</th>
										<th>IFSC Code</th>
										<th>Account number</th>
										<th>BG Amount</th>
										<th>Start Date</th>
										<th>End Date</th>
									</tr>
								</thead>
								<tbody>
									<?php
									foreach($bank_details as $row)
										{
											?>
											<tr>
												<td><?php echo $row['bank_name'];?></td>
												<td><?php echo $row['ifsc_code'];?></td>
												<td><?php echo $row['account_no'];?></td>
												<td><?php echo $row['bg_amount'];?></td>
												<td><?php echo date('d-m-Y',strtotime($row['start_date']))?></td>
												<td><?php echo date('d-m-Y',strtotime($row['end_date']))?></td>
											</tr> <?php
										}?>
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