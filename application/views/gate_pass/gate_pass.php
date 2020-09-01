<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                <br>
                   <?php
                    if($flag==1)
	                {
	                ?>  
	                <form id="gate_pass_form" method="post" action="<?php echo SITE_URL.'add_gate_pass';?>" class="form-horizontal">
	                    <div class="row">  
	                        <div class="col-md-offset-3 col-md-6 well"> 
	                                <div class="form-group">
	                                    <label class="col-md-5 control-label">Vehicle In Number<span class="font-red required_fld">*</span></label>
	                                    <div class="col-md-6">
		                                      <input type="text" name="tanker_in_no" class="form-control" placeholder="Vechicle In No" required="required">
	                                    </div>
	                                </div>                          
	                                <div class="form-group">
	                                    <div class="col-md-5"></div>
	                                        <div class="col-md-7">
	                                            <input type="submit" class="btn blue tooltips" value="Proceed" name="submit">
	                                            <a href="<?php echo SITE_URL.'gate_pass';?>" class="btn default">Cancel</a>
	                                        </div>                                 
	                                </div>
	                            </div>
	                        </div>
	                    </form> 
                    <?php }
                    if($flag==2)
	                {
	                ?>  
	                <form id="gate_pass_form" method="post" action="<?php echo SITE_URL.'generate_gate_pass';?>" class="form-horizontal">
	                    <div class="row"> 
	                    	<div class="col-md-offset-9 col-md-3">
                                <p align="left" style="color:#3A8ED6;"><b>
                                <span class="timer_block" style="float:right;">
                                <i class="fa fa-clock-o"></i>
                                <span id="timer"></span>
                                </span></b></p>
                            </div> 
	                        <div class="row">
	                        	<div class="col-md-6">
		                        	<div class="form-group">
	                                    <label class="col-md-7 control-label">Gatepass Number :</label>
	                                    <div class="col-md-5">
		                                    <div class="input-icon right">
			                                    <i class="fa"></i>
			                                    <p class="form-control-static"><b><?php echo $gatepass_number ;?></b></p>
			                                    <input type="hidden" name="tanker_id" value="<?php echo $results['tanker_id'] ; ?>">
			                                </div>
	                                    </div>
		                            </div>
	                            </div>
	                            <div class="col-md-6">
		                        	<div class="form-group">
	                                    <label class="col-md-4 control-label">Tanker In Number :</label>
	                                    <div class="col-md-4">
		                                    <div class="input-icon right">
			                                    <i class="fa"></i>
			                                    <p class="form-control-static"><b><?php echo $results['tanker_in_number'] ;?></b></p>
			                                    <input type="hidden" name="tanker_id" value="<?php echo $results['tanker_id'] ; ?>">
			                                     <input type="hidden" name="tanker_in_no" value="<?php echo $results['tanker_in_number'] ; ?>">
			                                </div>
	                                    </div>
		                            </div> 
	                            </div>
	                        </div>
	                        <div class="row">
	                           <div class="col-md-6">
	                                <div class="form-group">
	                                    <label class="col-md-7 control-label">Vehicle Number :</label>
	                                    <div class="col-md-5">
		                                    <div class="input-icon right">
			                                    <i class="fa"></i>
			                                    <p class="form-control-static"><b><?php echo $results['vehicle_number'] ;?></b></p>
			                                </div>
	                                    </div>
	                                </div>
                                </div>
                                <div class="col-md-6">
	                                  <div class="form-group">
	                                    <label class="col-md-4 control-label">Party Name :</label>
	                                    <div class="col-md-8">
		                                    <div class="input-icon right">
			                                    <i class="fa"></i>
			                                    <p class="form-control-static"><b><?php echo $results['party_name'] ;?></b></p>
			                                </div>
	                                    </div>
	                                </div>
                                </div>
                            </div> 
                            <div class="row invoice_number">  
                            	<div class="col-md-5">                    
			                        <div class="form-group ">
				 						<label class="col-md-7 control-label mylabel">Invoice No.<span class="font-red required_fld">*</span></label>
				 						<div class="col-md-5">
				 							<div class="input-icon right">
				 								<i class="fa"></i>
				 								<input type="text" name="invoice_number[]" placeholder="Invoice Number"  class="form-control">
				 							</div>
				 						</div>
				 					</div>
				 				</div>
				 				<div class="col-md-5">                    
			                        <div class="form-group ">
				 						<label class="col-md-4 control-label mylabel">Waybill No.<span class="font-red required_fld">*</span></label>
				 						<div class="col-md-7 mytext ">
				 							<div class="input-icon right">
				 								<i class="fa"></i>
				 								<input type="text" name="waybill_number[]" placeholder="Waybill Number"  class="form-control">
				 							</div>
				 						</div>
				 					</div>
				 				</div>
				 				<div class="col-md-1">                    
			                        <div class="form-group">
				 						<div class="col-md-2 mybutton">
				 							<a  class="btn blue tooltips add_invoice_info" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
				 						</div>
				 						<div class="col-md-2 deletebutton hide">
				 							<a  class="btn btn-danger tooltips " data-container="body" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
				 						</div>
			 					    </div>
			 					</div>
			 				</div>
			 				<div class="row">
			 					<div class="col-md-offset-3 col-md-5">
									<div class="form-group">
	                                    <label class="col-md-5 control-label">Remarks</label>
	                                    <div class="col-md-6">
		                                    <div class="input-icon right">
			                                    <i class="fa"></i>
			                                    <textarea class="form-control" name="remarks"></textarea>
			                                </div>
	                                    </div>
		                            </div>
	                            </div>
	                        </div>
	                        <div class="row">
			 					<div class="col-md-offset-5 col-md-6">
                                <div class="form-group">
                                        <div class="col-md-12">
                                            <input type="submit" class="btn blue tooltips" value="Genarate GatePass" name="submit" onclick="return confirm('Are you sure you want to generate gate pass?')">
                                            <a href="<?php echo SITE_URL.'gate_pass';?>" class="btn default">Cancel</a>
                                        </div>                                 
                                	</div>
	                            </div>
	                        </div>
	                        
	                    </form> 
                    <?php } 
                    ?>
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
<?php $this->load->view('commons/main_footer',$nestedView); ?>