<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
        <!-- BEGIN BORDERED TABLE PORTLET-->
			<div class="portlet box purple ">
			    <div class="portlet-title">
			        <div class="caption">
			            <i class="fa fa-gift"></i>Monthly Godown Stock Report
                    </div>
			    </div>
			    <div class="portlet-body form">
			        <form class="form-horizontal " role="form" method="post" action="<?php echo SITE_URL.'print_monthly_stock_report';?>">
			            <div class="form-body">
                            <div class="form-group">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                	<div class="input-group input-large date-picker input-daterange" data-date-format="dd-mm-yyyy">
                                        <input type="text" class="form-control" name="from_date" placeholder="From Date" >
                                        <span class="input-group-addon"> to </span>
                                        <input type="text" class="form-control" name="to_date" placeholder="To Date"> 
                                    </div>
                                </div>
                           </div> 
                           <?php if(@$plants !='') { ?>
                           <div class="form-group">
    			                    <label class="col-md-4 control-label">Select Unit</label>
                                        <div class="col-md-4">
                                            <select class="form-control " required  name="plant_id">
		                                    <option value="">Select Unit</option>
    		                                    <?php 
            		                                foreach($plants as $type) 
            		                                { ?>
            		                                <option value="<?php echo @$type['plant_id']; ?>"><?php echo @$type['plant_name']; ?></option>
            		                                <?php }                                        
    		                                    ?>                                          
		                                    </select> 
    			                        </div>
			                     </div>
			                  <?php } ?>
                        </div>
    			            <div class="form-actions right">
    			                <input type="submit" name="submit" value="submit" class="btn green">
                                <a type="button" href="<?php echo SITE_URL.'stock_point_product_balance';?>" class="btn default">Cancel</a>
    			            </div>
			            </form>
                     </div>
               </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>
</div>
<?php $this->load->view('commons/main_footer', $nestedView); ?>