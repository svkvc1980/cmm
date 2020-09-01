 <?php $this->load->view('commons/main_template', $nestedView); ?>

  <!-- BEGIN PAGE CONTENT INNER -->
 <div class="page-content-inner">
 	<div class="row">
 		<div class="col-md-offset-2 col-md-8">
 			<!-- BEGIN BORDERED TABLE PORTLET-->
 			<div class="portlet light portlet-fit">
				<div class="portlet-body">
            	<?php if(@$flag==1) { ?>
	            	<form class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL.'insert_product_pm_weight';?>">
	            		<div class="row">
        					<div class="col-md-12">
        						<div class="table-responsive">
        							<table class="table table-bordered">
        								<tr align="center" style="background-color:#889ff3;">
        									<td colspan="4" style="color:white;"><b>Products</b></td>
        								</tr>
        								<tr>
                                            <td><b>Product Name</b></td>
                                            <td><b>Packing Material Weight</b></td>
                                        </tr>
                                        	<?php 
                                        	foreach($product as $row)
                                        	{
                                        	?>
											<tr style="height:30px">
                                        		<td><?php echo $row['name']; ?>
                                                    <input type="hidden" name="product_id[]" value="<?php echo $row['product_id'];?>">
                                                </td>
                                                <td><input type="text" name="pm_weight[<?php echo @$row['product_id'];?>]" class="form-control numeric xs-box"  style="width:135px;" value="<?php echo 
                                                   @$results[@$row['product_id']];  
                                                  ?>"  ></td>
                                        	
                                       		</tr> <?php
                                       		} 
                                        ?>
        							</table>
        						</div>
        					</div>
        				</div>
            			<div class="form-actions">
            				<div class="row">
            					<div class="col-md-offset-5 col-md-5">
            						<input type="submit" name="submit"   class="proceed btn green">
                            		<a type="button" href="<?php echo SITE_URL.'product_pm_weight';?>" class="btn default">Cancel</a>
            					</div>
            				</div>
                        </div> <?php
                        } ?>
	            	</form>
            	</div>
 			</div>
 		</div>
 	</div>
 </div>
 <?php $this->load->view('commons/main_footer', $nestedView); ?>