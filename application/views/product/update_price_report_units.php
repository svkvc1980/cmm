<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
        <!-- BEGIN BORDERED TABLE PORTLET-->
			<div class="portlet box purple ">
			    <div class="portlet-title">
			        <div class="caption">
			            <i class="fa fa-gift"></i>Product Price Updation Report 
                    </div>
			    </div>
			    <div class="portlet-body form">
                   <form class="form-horizontal report_price_view" role="form" method="post" action="<?php echo SITE_URL.'view_product_price_report_units';?>">
			                <div class="form-body">
                           <!--  <div class="row"> -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Date</label>
                                    <div class="col-md-4">                                          
                                            <input type="text" name="effective_date" class="form-control date-picker date" data-date-format="dd-mm-yyyy" value="<?php echo date('d-m-Y');?>"> 
                                       
                                     </div>
                                </div>
                          <!--   </div> -->
			                    <div class="form-group">
    			                    <label class="col-md-4 control-label">Price Type</label>
                                        <div class="col-md-4">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
    			                                <select class="form-control distributor" required  name="price_type">
    		                                    <option value="">Select Price Type</option>
        		                                    <?php 
                		                                foreach($distributor as $type) 
                		                                { ?>
                		                                <option value="<?php echo @$type['price_type_id']; ?>"><?php echo @$type['name']; ?></option>
                		                                <?php }                                        
        		                                    ?>                                          
    		                                    </select> 
    			                            </div>
                                        </div>
			                    </div>
                            </div>
    			            <div class="form-actions right">
    			                <input type="hidden" name="mrp" value="<?php  echo $mrp['price_type_id'];  ?>" class="mrp" >
                                <input type="hidden" name="raitu_bazar" value="<?php  echo $raitu_bazar['price_type_id'];  ?>" class="raitu_bazar" >
    			                <input type="submit" name="submit" value="submit" class="btn green">
                                <a type="button" href="<?php echo SITE_URL.'product_price_report';?>" class="btn default">Cancel</a>
    			            </div>
			            </form>
			     </div>
			</div>
			<!-- END BORDERED TABLE PORTLET-->
		</div>
	</div>
</div>
<?php $this->load->view('commons/main_footer', $nestedView); ?>