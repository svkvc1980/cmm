<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <!-- BEGIN BORDERED TABLE PORTLET-->
           
                <div class="portlet-body">
	                <form class="form-horizontal" method="post" action="">
	                	<div class="col-md-offset-1 col-md-10">
	                		<h3 class="text-primary">Andhra Pradesh Cooperative Oil Seeds Growers Federation Limited</h3>
	                	</div>
	                	<div class="col-md-offset-5 col-md-6">
	                		<h4><b>Order Booking</b></h4><br>
	                	</div>
	                	<div class="col-md-offset-1 col-md-10">
		                    <div class="col-md-6">
		                     	<div class="form-group">
		                            <label class="col-md-5 control-label">Order No</label>
		                            <div class="col-md-7">
		                                <p class="form-control-static"><b><?php echo $order_details[0]['order_number']; ?></b></p>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="col-md-6">
		                     	<div class="form-group">
		                            <label class="col-md-5 control-label">Order Date</label>
		                            <div class="col-md-7">
		                                <p class="form-control-static"><b><?php echo date('d-m-Y') ?></b></p>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="col-md-6">
		                     	<div class="form-group">
		                            <label class="col-md-5 control-label">Distributor</label>
		                            <div class="col-md-7">
		                                <p class="form-control-static"><b><?php echo $distributor_name; ?></b></p>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="col-md-6">
		                     	<div class="form-group">
		                            <label class="col-md-5 control-label">Lifting Point</label>
		                            <div class="col-md-7">
		                                <p class="form-control-static"><b><?php echo $lifting_point_name; ?></b></p>
		                            </div>
		                        </div>
		                    </div>
		                     <div class="row">
                                <div class="col-md-offset-5 col-md-4">
                                     <a href="<?php //echo SITE_URL.'purchase_order';?>" class="btn btn-primary">Print</a>

                               </div>
                            </div>
		                </div>
	                </form>
            	</div>
        	
    	</div>
	</div>
</div>

<?php $this->load->view('commons/main_footer', $nestedView); ?>