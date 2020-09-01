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
	                                    <label class="col-md-5 control-label">Enter Tanker In Number<span class="font-red required_fld">*</span></label>
	                                    <div class="col-md-6">
		                                    <div class="input-icon right">
			                                    <i class="fa"></i>
		                                      <input type="text" name="tanker_in_no" class="form-control" value="">
		                                    </div>
	                                    </div>
	                                </div>                          
	                                <div class="form-group">
	                                    <div class="col-md-3"></div>
	                                        <div class="col-md-8">
	                                            <input type="submit" class="btn blue tooltips" value="Proceed" name="submit">
	                                            <a href="<?php echo SITE_URL.'gate_pass';?>" class="btn default">Cancel</a>
	                                        </div>                                 
	                                </div>
	                            </div>
	                            <div class="row">
                                <div class="col-md-offset-9     col-md-2">
                                    <a class="btn btn-default" href="<?php echo SITE_URL.'plant_gate_pass_list'?>"><i class="fa fa-pencil"></i>Plant Gate Pass list</a>
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
	                        <div class="col-md-offset-3 col-md-5"> 
	                        	<div class="form-group">
                                    <label class="col-md-5 control-label">Gatepass Number</label>
                                    <div class="col-md-7">
	                                    <div class="input-icon right">
		                                    <i class="fa"></i>
		                                    <p class="form-control-static"><b><?php echo $gatepass_number ;?></b></p>
		                                    <input type="hidden" name="tanker_id" value="<?php echo $results['tanker_id'] ; ?>">
		                                </div>
                                    </div>
	                            </div>
	                        	<div class="form-group">
                                    <label class="col-md-5 control-label">Tanker In Number</label>
                                    <div class="col-md-7">
	                                    <div class="input-icon right">
		                                    <i class="fa"></i>
		                                    <p class="form-control-static"><b><?php echo $results['tanker_in_number'] ;?></b></p>
		                                    <input type="hidden" name="tanker_id" value="<?php echo $results['tanker_id'] ; ?>">
		                                     <input type="hidden" name="tanker_in_no" value="<?php echo $results['tanker_in_number'] ; ?>">
		                                </div>
                                    </div>
	                            </div> 
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Vehicle Number</label>
                                    <div class="col-md-7">
	                                    <div class="input-icon right">
		                                    <i class="fa"></i>
		                                    <p class="form-control-static"><b><?php echo $results['vehicle_number'] ;?></b></p>
		                                </div>
                                    </div>
                                </div>
                                  <div class="form-group">
                                    <label class="col-md-5 control-label">Party Name</label>
                                    <div class="col-md-7">
	                                    <div class="input-icon right">
		                                    <i class="fa"></i>
		                                    <p class="form-control-static"><b><?php echo $results['party_name'] ;?></b></p>
		                                </div>
                                    </div>
                                </div>                       
	                            
	                            
	                            <div class="form-group invoice_number">
			 						<label class="col-md-5 control-label mylabel">Enter Invoice Number<span class="font-red required_fld">*</span></label>
			 						<div class="col-md-5 mytext ">
			 							<div class="input-icon right">
			 								<i class="fa"></i>
			 								<input class="form-control value invoice_no" name="invoice_no[]"  placeholder="Invoice Number" type="text">
			 								<p  class="hidden invoiceValidating"><i class="fa fa-spinner fa-spin"></i> Checking...</p>
                                          <p  class="error hidden invoiceError"></p>
			 							</div>
			 						</div>
			 						<div class="col-md-2 mybutton">
			 							<a  class="btn blue tooltips add_invoice_info" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
			 						</div>
			 						<div class="col-md-2 deletebutton hide">
			 							<a  class="btn btn-danger tooltips " data-container="body" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
			 						</div>
	 					        </div>
	 					         <div class="form-group">
                                    <label class="col-md-5 control-label">Remarks</label>
                                    <div class="col-md-7">
	                                    <div class="input-icon right">
		                                    <i class="fa"></i>
		                                    <input type="text" name="remarks" placeholder="Remarks" value="<?php echo @$gate_pass1['remarks']; ?>"class="form-control ">
		                                </div>
                                    </div>
	                            </div>
                                <div class="form-group">
                                    <div class="col-md-4"></div>
                                        <div class="col-md-8">
                                            <input type="submit" class="btn blue tooltips" value="Generate Gate Pass" name="submit">
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
<script>
$('.add_invoice_info').click(function()
{   var counter = 2;
    var ele = $('.invoice_number:eq(0)');  
    var ele_clone = ele.clone();
    ele_clone.find('.mylabel').text('');
    ele_clone.find('.value').val('');
    ele_clone.find('.mybutton').remove();
    ele_clone.find('.deletebutton').addClass('show');
    ele_clone.find('div.form-group .invoice_no').removeClass('has-error has-success');
    ele_clone.find('div.input-icon i').removeClass('fa-check fa-warning').addClass('fa');
    // replaces [1] with new counter value [counter] at all name occurances
    ele_clone.html(function(i, oldHTML) {
        return oldHTML.replace(/\[1\]/g, '['+counter+']');
    });

    ele_clone.find('.deletebutton').click(function() {      
        $(this).closest('.invoice_number').remove();
      
    });
    ele.after(ele_clone);
    
});
</script>