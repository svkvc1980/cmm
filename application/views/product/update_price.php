 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
        <!-- BEGIN BORDERED TABLE PORTLET-->
			<div class="portlet box blue">
			    <div class="portlet-title">
			        <div class="caption">
			            <i class="fa fa-gift"></i><?php echo $portlet_title; ?>
                    </div>
			    </div>

			    <div class="portlet-body form">
                    <?php if(@$flag==1) { ?>
                        <form class="form-horizontal price_view" role="form" method="post" action="<?php echo SITE_URL.'view_product_price';?>">
			                <div class="form-body">
			                    <div class="form-group">
    			                    <label class="col-md-4 control-label">Price Type</label>
                                        <div class="col-md-4">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
    			                                <select class="form-control distributor"  name="price_type">
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
                	                                    <input type="radio" class="plant_value" name="mrp_plant"  value="2"> All Plants
                	                                    <span></span>
                	                                </label>
	                                            </div>
                                        </div>
	                            </div>
	                            <div class="form-group plant_block">
			                        <label class="col-md-4 control-label">Unit</label>
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
                                <a type="button" href="<?php echo SITE_URL.'product_price';?>" class="btn default">Cancel</a>
    			            </div>
			            </form>
			            <?php } 
			            elseif(@$flag==2) 
                        { ?>
                        <form class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL.'update_product_price';?>">
			        	    <div class="portlet box blue">
                                <div class="portlet-body">                           
                                    <div class="col-md-offset-3 col-md-6">
                            	        <div class="form-group">
                            	           <label class="col-xs-4 control-label">Date</label>
                                            	<div class="col-xs-6">
                                            		<input type="text" name="effective_date" class="form-control date-picker date" data-date-format="dd-mm-yyyy" value="<?php echo (isset($price_data['effective_date']))?$price_data['effective_date']:date('d-m-Y');?> ">
                                            		<input type="hidden" name="distributor_type" value="<?php echo $distributor_type; ?>">
                                            		<input type="hidden" name="plant_id" value="<?php echo $plant_id; ?>">
                                                    <input type="hidden" name="mrp_plant" value="<?php echo $mrp_plant; ?>">
                                                    <input type="hidden" name="portlet_title" value="<?php echo $portlet_title?>">
                                            	</div>
                            	        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                   <?php $sno=1; foreach ($product_results as $key =>$value)
                                                    {   ?>
                                                        <tr align="center" style="background-color:#889ff3;">
                                                           <td colspan="4" style="color:white;"><b><?php echo $value['product_name']; ?></b></td>
                                                        </tr>
                                                       <?php if($sno==1){ ?> 
                                                        <tr>
                                                            <td><b>SNO</b></td>
                                                       		<td><b>Product Name</b></td>
                                                       		<td align="center"><b>Old Price</b></td>
                                                       		<td align="center"><b>New Price</b></td>
                                                   		</tr>
                                                        <?php } ?>
                                                        <tr>
                                                            <?php foreach($value['sub_products'] as $keys =>$values)
                                                              { ?>
                                                            <td><?php echo  $sno++; ?></td> 
                                                            <td><?php echo $values['name']; ?></td>
                                                            <td align="right"><?php if (@$latest_price_details[$values['product_id']]!='') { echo price_format($latest_price_details[$values['product_id']]['old_price']); } else { echo price_format(0); } ;?></td>
                                                            <td align="right"><input type="text" name="new_price[<?php echo $values['product_id'];?>]" class="form-control new_price input-sm" value="<?php if(isset($price_data['new_price'][$values['product_id']])){ echo @$price_data['new_price'][$values['product_id']];} ?>" style="width:135px"></td>
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
                                </div>
                                <div class="form-actions right">
                                    <input type="submit" name="submit"  value="submit" class="proceed btn green">
        			                <a type="button" href="<?php echo SITE_URL.'product_price';?>" class="btn default">Cancel</a>
        			            </div>
                            </div>
                        </form>
                        <?php }
			            elseif(@$flag==3) 
                        { ?>
			        	<form class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL.'insert_latest_price';?>">
			        	    <div class="portlet box blue">
                                <div class="portlet-body">
                                    <?php 
                                        foreach ($loose_oil_results as $key =>$value)
                                            {  $sno=1; ?>    
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="table-responsive">
                                                            <table class="table table-bordered">
                                                                <tr class="bg-blue-steel" align="center">
                                                                    <td colspan="6" style="color:white;"><?php echo $value['loose_oil']; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><b>SNO</b></td>
                                                                    <td><b>Product Name</b></td>
                                                                    <td><b>Old Price</b></td>
                                                               		<td><b>New Price</b></td>
                                                               		<td><b>Effective Date</b></td>
                                                               		<td><b>Action</b></td>
                                                                </tr>
                                                                <?php foreach($value['products'] as $keys =>$values)
                                                                { ?>
                                                                <tr>
                                                                    <td><?php echo  $sno++; ?></td> 
                                                                    <td><?php echo $values['product']; ?></td>
                                                                    <td><?php echo price_format($values['old_price']); ?></td>
                                                                    <td><?php echo price_format($values['new_price']); ?></td>
                                                                    <td><?php echo $values['start_date']; ?></td>
                                                                    <td> <a class='btn btn-danger btn-circle btn-sm delete_row'  onclick='return confirm('Are you sure you want to Delete?')'><i class='fa fa-trash-o'></i></a></td>
                                                                    <input type="hidden" name="product_id[]" value="<?php echo $values['product_id'];?> ">
                                                                    <input type="hidden" name="product_price_id[]" value="<?php echo $values['product_price_id'];?> ">
                                                                    <input type="hidden" name="loose_oil[]" value="<?php echo $values['loose_oil'];?>">
                                                                    <input type="hidden" name="product[]" value="<?php echo $values['product'];?>">
                                                                    <input type="hidden" name="new_price[]" value="<?php echo $values['new_price'];?>">
                                                                    <input type="hidden" name="old_price[]" value="<?php echo $values['old_price'];?>">
                                                                    <input type="hidden" name="start_date[]" value="<?php echo $values['start_date'];?>">
                                                                    <input type="hidden" name="distributor_type" value="<?php echo $values['distributor_type']; ?>">
                                                    		        <input type="hidden" name="plant_id" value="<?php echo $values['plant_id']; ?>">
                                                                    <input type="hidden" name="mrp_plant" value="<?php echo $mrp_plant; ?>">
                                                                </tr>
                                                                <?php 
                                                                } } ?>    
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                </div>
                                    <div class="form-actions right">
                                    <input type="submit" name="submit" value="confirm" class="btn green">
        			                <a type="button" href="<?php echo SITE_URL.'view_product_price';?>" class="btn default">Cancel</a>
        			            </div>
                            </div>
                        </form>
                        <?php } ?>
			    </div>
			</div>
			<!-- END BORDERED TABLE PORTLET-->
		</div>
	</div>
</div>
<?php $this->load->view('commons/main_footer', $nestedView); ?>
<script type="text/javascript">
$(document).ready(function()
{
     $('.delete_row').click(function()
        { 
          alert('Are you want to delete');
          $(this).parents("tr").remove();
          return false;
        });
         $('.proceed').click(function(){
        //alert('hi');
        var i=0;
        $('.new_price').each(function(){
           var rate=$(this).val();
           if(rate!='')
           {
                i++;
           }
           
       });
        if(i<=0)
        { 
          alert('Please enter atleast one value in newprice');
         return false;
        }
       });
});
</script>