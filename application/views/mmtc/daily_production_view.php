<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
 <div class="page-content-inner">
 	<div class="row">
 		<div class="col-md-12">

 			<!-- BEGIN BORDERED TABLE PORTLET-->
 			<div class="portlet light portlet-fit">
 				<div class="portlet-body">
 					<form id="distributor_form" method="post" action="<?php echo $form_action;?>" class="form-horizontal">
 						<div class="alert alert-danger display-hide" style="display: none;">
	 						<button class="close" data-close="alert"></button> You have some form errors. Please check below. 
	 					</div>
	 					<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-md-4 control-label" for="form-field-1">Date:<?php echo date("d-m-y  h:i:a")  ?></label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-md-4 control-label" for="form-field-1">Select OPs Code<span class="font-red required_fld">*</span></label>
									<div class="col-md-6">
										<div class="input-icon right">
											<i class="fa"></i>
											<select id="type" name="mktg_exe_code" class="form-control" style="height:30px;">
												<option value=""> Select Code</option>
												<option value="1" >Kakinada OPS</option>
												<option value="2" >Vijayawada OPs</option>	
											</select>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- <div class="col-md-3"> </div>
						<div class="col-md-6">
                            <div class="portlet box green">
				                <div class="portlet-title">
				                    <div class="caption col-md-6">RBD PALMOLEIN OIL </div>
				                </div>
				                
            				</div>
                        </div> -->
						<div class="table-scrollable">
	 						<table class="table table-bordered table-striped table-hover" id="bank_table">
	 							<tr style="background-color:white;">
									<th>RBD PAMOLEIN OIL</th>
								</tr>
								<tr style="background-color:#6B9BCF !important; color:white;">
									<th></th>
									<th>Product Name</th>
									<th>Quantity in Cartons</th>
								</tr>
								<tr>
									<td>1</td>
									<td>RBDP 1LT Sachet</td>
									<td><input type="text" class="form-control" style="width:200px;"></td>
								</tr>
	 						</table>
	 					</div>
	 				</form>
 				</div>
 			</div>
 		</div>
 	</div>
 </div>

 <?php $this->load->view('commons/main_footer', $nestedView); ?>