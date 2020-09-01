 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
        <!-- BEGIN BORDERED TABLE PORTLET-->
			<div class="portlet box purple ">
			    <div class="portlet-title">
			        <div class="caption">
			            <i class="fa fa-gift"></i>Product Price Updation Report <?php if(@$flag==2 ||@$flag==3){ echo 'of'.' '. @$price_type_name .' '.'Price type '.@$ops; } ?>
                    </div>
			    </div>
			    <div class="portlet-body form">
                    <?php if(@$flag==1) { ?>
                        <form class="form-horizontal report_price_view" role="form" method="post" action="<?php echo SITE_URL.'view_product_price_report';?>">
			                <div class="form-body">
                           <!--  <div class="row"> -->
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Effective Date</label>
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
    			                                <select class="form-control distributor" required  name="distributor">
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
                                <div class="form-group plant  ">
	                                <label class="col-md-4 control-label" >Select Unit</label>
                                        <div class="input-icon right">
                                            <i class="fa"></i>
	                                           <div class="mt-radio-inline control-label col-md-3">
	                                                <label class="mt-radio">
    	                                                <input type="radio" class="plant_value" name="mrp_plant"  value="1" > Individual
    	                                                <span></span>
	                                                </label>
                	                                <label class="mt-radio">
                	                                    <input type="radio" class="plant_value" name="mrp_plant" value="2"> All Plants
                	                                    <span></span>
                	                                </label>
	                                            </div>
                                        </div>
	                            </div>
	                            <div class="form-group plant_block">
			                        <label class="col-md-4 control-label"> Unit</label>
			                            <div class="col-md-4">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
  			                                    <select class="form-control pb"  name="plant_name">
      		                                        <option value="">Select Unit</option>
                  		                                <?php 
                      		                                foreach($plant_results as $result) 
                      		                                { ?>
                      		                                    <option value="<?php echo $result['plant_id']; ?>"><?php echo $result['plant_name']; ?></option>
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
			            <?php }
                        elseif (@$flag==2)
                         {
                           ?>
                           <form class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL.'update_product_price';?>">
                            <div class="portlet box blue">
                                <div class="portlet-body">
                                    <div class="row">                          
                                        <div class="col-md-offset-4 col-md-6">
                                            <!-- <div class="form-group"> -->
                                               <label class="col-xs-3 control-label">Effective Date</label>
                                                    <div class="col-xs-6">
                                                       <p class="form-control-static"><?php echo ' '.$start_date; ?> </p>
                                                        <input type="hidden" name="distributor_type" value="<?php echo $distributor_type; ?>">
                                                        <input type="hidden" name="plant_id" value="<?php echo $plant_id; ?>">
                                                        <input type="hidden" name="effective_date" value="<?php echo $start_date; ?>" >
                                                    </div>
                                            <!-- </div> -->
                                            <p><button type="submit" name="download" value="1" formaction="<?php echo SITE_URL.'download_product_price_report';?>" class="form-control-static btn blue btn-xs"><i class="fa fa-cloud-download fa-lg"></i></button></p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                   <?php foreach ($product_results as $key =>$value)
                                                    {  $sno=1; ?>
                                                        <tr class="bg-blue-steel" align="center">
                                                           <td colspan="4" style="color:white;"><?php echo $value['product_name']; ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td><b>SNO</b></td>
                                                            <td><b>Product Name</b></td>
                                                            <td><b>Price</b></td>
                                                            <!-- <td><b>New Price</b></td> -->
                                                        </tr>
                                                        <tr>
                                                            <?php foreach($value['sub_products'] as $keys =>$values)
                                                              { ?>
                                                            <td><?php echo  $sno++; ?></td> 
                                                            <td><?php echo $values['name']; ?></td>
                                                            <td><?php if (@$latest_price_details[$values['product_id']]!='') { echo $latest_price_details[$values['product_id']]['old_price']; } else { echo 0; } ?></td>
                                                           <!--  <td><input type="text" name="new_price[<?php echo $values['product_id'];?>]" class="form-control numeric new_price input-sm" style="width:135px"></td> -->
                                                            <input type="hidden" name="product_id[<?php echo $values['product_id'];?>]" value="<?php echo $values['product_id'];?> ">
                                                            <input type="hidden" name="product_price_id[<?php echo $values['product_id'];?>]" value="<?php echo @$latest_price_details[$values['product_id']]['product_price_id'];?> ">
                                                            <input type="hidden" name="loose_oil[<?php echo $values['product_id'];?>]" value="<?php echo $value['product_name'];?>">
                                                            <input type="hidden" name="product[<?php echo $values['product_id'];?>]" value="<?php echo $values['name'];?>">
                                                            <input type="hidden" name="old_price[<?php echo $values['product_id'];?>]" value="<?php if (@$latest_price_details[$values['product_id']]!='') { echo $latest_price_details[$values['product_id']]['old_price']; } else { echo 0; } ;?>">
                                                            <input type="hidden" name="loose_oil_id[<?php echo $values['product_id'];?>]" value="<?php echo $value['loose_oil_name'];?>">
                                                        </tr>
                                                    <?php
                                                    } } ?>    
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-offset-5 col-md-4">
                                             <a type="button" href="<?php echo SITE_URL.'product_price_report';?>" class="btn default">Back</a>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                       
                        <?php }
			            ?>
			        	
			    </div>
			</div>
			<!-- END BORDERED TABLE PORTLET-->
		</div>
	</div>
</div>
<?php $this->load->view('commons/main_footer', $nestedView); ?>