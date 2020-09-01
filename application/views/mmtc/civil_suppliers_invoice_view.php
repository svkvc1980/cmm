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
	 					<div class="form-group order_number">
	 						<label class="col-md-5 control-label mylabel">Enter Delivery Order Number<span class="font-red required_fld">*</span></label>
	 						<div class="col-md-2 mytext ">
	 							<div class="input-icon right">
	 								<i class="fa"></i>
	 								<input class="form-control value " name="oil_tank" id="order_number_id" type="text">
	 							</div>
	 						</div>
	 						<div class="col-md-2 mybutton">
	 							<a  id="add_order_info" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
	 						</div>
	 						<div class="col-md-2 deletebutton hide">
	 							<a  class="btn btn-danger tooltips " data-container="body" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
	 						</div>
	 					</div>
	 					<div class="form-actions">
	                        <div class="row">
	                            <div class="col-md-offset-5 col-md-6">
	                                <a  class="btn blue">Submit</a>
	                                <a  class="btn default">Cancel</a>
	                            </div>
	                        </div>  
	                    </div>
	 				</form>
	 			</div>
	 		</div>
 		</div>
 	</div>
 </div>
 <?php $this->load->view('commons/main_footer', $nestedView); ?>