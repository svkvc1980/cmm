 <?php $this->load->view('commons/main_template', $nestedView); ?>
 <!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
					
					<form role="form" id="myform" class="form-horizontal" method="post" action="<?php echo SITE_URL;?>insert_distributor_bg_renewal">
					<input type="hidden" name="distributor_id" value="<?php echo $distributor_id ;?>"> <?php if(count($results) > 0) { ?>
						<h4> Expired Bank Details : <?php echo get_distributor_name($distributor_id); ?></h4>
						<div class="table-scrollable ">
						<table class="table table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th style="width:17%">Bank Name</th>
									<th style="width:17%">Account No.</th>
									<th style="width:15%">IFSC Code</th>
									<th style="width:15%">BG Amount</th>
									<th style="width:13%">Start Date</th>
									<th style="width:13%">End Date</th>
									
								</tr>
							</thead>
							<tbody>
								<?php foreach($results as $res)
								{ ?>
									<tr>
										<td><?php echo $res['name']; ?></td>
										<td><?php echo $res['account_no']; ?></td>
										<td><?php echo $res['ifsc_code']; ?></td>
										<td><?php echo $res['bg_amount']; ?></td>
										<td><?php echo date('d-m-Y',strtotime($res['start_date'])); ?></td>
										<td><?php echo date('d-m-Y',strtotime($res['end_date'])); ?></td>
										<input type="hidden" name="bg_id[]" value="<?php echo $res['bg_id'];?>">
									</tr>
							    <?php } ?>
							</tbody>
						</table>
						</div>
						<?php } 
						else
						{ ?>
							<h4>No expired bank details found</h4>
						<?php } ?>
						<br>
						<a  id="add_bank_info" class="btn blue tooltips">Add New</i></a>
						<div class="table-scrollable form-body">
						<table class="table table-bordered table-striped table-hover bank_table">
							<thead>
								<tr>
									<th style="width:17%">Bank Name</th>
									<th style="width:17%">Account No.</th>
									<th style="width:15%">IFSC Code</th>
									<th style="width:15%">BG Amount</th>
									<th style="width:13%">Start Date</th>
									<th style="width:13%">End Date</th>
									<th style="width:10%">Delete</th>
								</tr>
							</thead>

								<tr>
										<td>
											<div class="dummy">
											<div class="input-icon right">
												<i class="fa"></i>
												<select name="bank_id[]"  class="form-control" > 
													<option value="">Select Bank</option>
													<?php 
														foreach($bank as $bank)
														{
															echo '<option value="'.$bank['bank_id'].'">'.$bank['name'].'</option>';
														}
													?>
												</select>
											</div>
											</div>
										</td>
										<td>
											<div class="dummy">
						                    	<div class="input-icon right">
													<i class="fa"></i>
						            				<input type="text" class="form-control" maxlength="25" name="account_no[]">
						            			</div>
						            		</div>
										</td>
										<td>
											<div class="dummy">
						                    	<div class="input-icon right">
													<i class="fa"></i>
						            				<input type="text"  class="form-control" name="ifsc_code[]">
						            			</div>
						            		</div>
										</td>
										<td>
											<div class="dummy">
						                    	<div class="input-icon right">
													<i class="fa"></i>
						            				<input type="text"  class="form-control numeric"onkeyup="javascript:this.value=Comma(this.value);" name="bg_amount[]" />
						            			</div>
						            		</div>
										</td>
										<td>
											<div class="dummy">
												<div class="input-icon right">
													<i class="fa"></i>
						                        	<input class="form-control date-picker start_date"  placeholder="Start Date" name="start_date[]" data-date-format="dd-mm-yyyy" type="text" />
						                        </div>	
						            		</div>
										</td>
										<td>
											<div class="dummy">
												<div class="input-icon right">
													<i class="fa"></i>
						            				<input class="form-control date-picker start_date"  placeholder="End Date" name="end_date[]" data-date-format="dd-mm-yyyy" type="text" />
						            			</div>	
						            		</div>
										</td>
										
								        <td style="display:none;" ><a class="btn btn-danger btn-sm remove_bank_row"> <i class="fa fa-trash-o"></i></a></td>
								</tr>
								
							</tbody>
						</table>
						</div>
						<br>
						<div class="form-group">
					        <div class="col-sm-offset-5 col-sm-5">
					            <button type="submit" title="Submit" name="submit" value="submit" class="btn blue submit">Submit</button>
					            <a title="Cancel" href="<?php echo SITE_URL.'distributor_bg_renewal';?>" class="btn default">Cancel</a>
					        </div>
					    </div>
					   </form>
					
   
      </div>
            </div>
        </div>
    </div>
</div>  

<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>