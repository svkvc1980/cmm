 <?php $this->load->view('commons/main_template', $nestedView); ?>

 <!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
 		<div class="portlet light portlet-fit">                
			<div class="portlet-body"> 
				<div class="row">
					<div class="col-sm-offset-1 col-sm-10 padding">
						<form id="ob_form" method="post" class="form-horizontal">
        					<div class="col-xs-4">                 
		                        <div class="form-group">
		                            <label class="col-sm-6 control-label">SRN Number</label>
		                            <div class="col-sm-6">
		                            	<p class="form-control-static"><b><?php echo $srn_number; ?></b></p>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="col-xs-4">                 
		                        <div class="form-group">
		                            <label class="col-sm-6 control-label">SRN Date</label>
		                            <div class="col-sm-6">
		                            	<p class="form-control-static"><b><?php echo date('d-m-Y',strtotime($srn_date)); ?></b></p>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="col-xs-4">                 
		                        <div class="form-group">
		                            <label class="col-sm-6 control-label">Vehicle Number</label>
		                            <div class="col-sm-6">
		                            	<p class="form-control-static"><b><?php echo $vehicle_number; ?></b></p>
		                            </div>
		                        </div>
		                    </div>
		                     <?php if(count(@$lit_results) >0) { ?>
                   			<div class="col-xs-4">                 
		                        <div class="form-group">
		                            <label class="col-sm-6 control-label">Transporter Name</label>
		                            <div class="col-sm-6">
		                            	<p class="form-control-static"><b><?php echo @$lit_results[0]['transporter_name']; ?></b></p>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="col-xs-4">                 
		                        <div class="form-group">
		                            <label class="col-sm-6 control-label">LR Number</label>
		                            <div class="col-sm-6">
		                            	<p class="form-control-static"><b><?php echo @$lit_results[0]['lr_number']; ?></b></p>
		                            </div>
		                        </div>
		                    </div>
		                    <div class="col-xs-4">                 
		                        <div class="form-group">
		                            <label class="col-sm-6 control-label">LR Date</label>
		                            <div class="col-sm-6">
		                            	<p class="form-control-static"><b><?php echo date('d-m-Y'); ?></b></p>
		                            </div>
		                        </div>
		                    </div>

                			<?php } ?>
	                    </form>
                    </div>
                </div>	                   
				<div class="row">
					<div class="col-md-offset-1 col-md-10">							
	                	<?php				    
					    foreach(@$invoice_results as $stock_receipt_id => $value) 
					    {   
					    	if(count(@$value['product_details'] )>0) { ?>

						<input type="hidden" name="invoice_id[]" value="<?php echo $stock_receipt_id ?>">
		       			<div class="portlet box yellow">
			                <div class="portlet-title">
			                    <div class="caption">
			                        Invoice No: <?php echo $value['invoice_number']; ?> </div>
			                    <div class="tools">
			                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
			                    </div>
			                </div>
			                <div class="portlet-body"> 
			                	<table class="table table-bordered" cellpadding="0" border="0" align="center" cellspacing="0" style="width:90%" >
								
									    <thead>
									       <th colspan="6">Products</th>
									    </thead>
									    <tr style="background-color:#fafafa">
									        <th> S.No</th>
									        <th> Product Name </th>
									        <th> Invoice Qty </th>
									        <th> Received Qty </th>
									        <th> Shortage </th>
									    </tr>
									    <tbody>
									        <?php 
									        $sno = 1;
									         foreach(@$value['product_details'] as $keys =>$values) 
									         {  
									            if($values != '') 
									            { ?>
									                <tr class="do_row">
									                    <td><?php echo $sno++; ?></td>
									                    <td>
									                    	<?php echo $values['product_name']?>
									                    </td>
									                    <td><?php echo $values['invoice_quantity']?>
									                    </td>
									                    <td style="width:15%;">								                    	<?php echo $values['received_quantity']?>
									                    </td>
									                    <td><?php echo $values['shortage']?></td> 
									                </tr>
									                <?php   
									            }
									        } ?> 
									              
									    </tbody> 
									    <?php
									   
									    if(count(@$value['free_gift_details'])>0||count(@$value['free_product_details'])>0)
									    {
									    ?>
									    <tr style="background-color:#bfcad1">
									       <td colspan="6">Free Gift Items</td>
									    </tr>
									    <tr style="background-color:#fafafa">
									        <th> S.No</th>
									        <th> Free Gift Item </th>
									        <th> Invoice Qty </th>
									        <th> Received Qty </th>
									        <th> Shortage </th>
									    </tr>
									    <tbody>
									        <?php $sn = 1;
									         foreach(@$value['free_gift_details'] as $keys =>$values) 
									         { 
									            if($values != '') 
									            { ?>
									                <tr class="do_row">
									                    <td><?php echo $sn++; ?></td>
									                    <td><?php echo $values['free_gift_name']; ?></td>
									                    <td><?php echo $values['invoice_quantity']?>
									                    </td>
									                    <td style="width:15%;">								                    	<?php echo $values['received_quantity']?>
									                    </td>
									                    <td><?php echo $values['shortage']?></td> 
									                </tr>
									                <?php   
									            }
									        } ?>
									        <?php 
									         foreach(@$value['free_product_details'] as $keys =>$values) 
									         { 
									            if($values != '') 
									            { ?>
									                <tr class="do_row">
									                    <td><?php echo $sno++; ?></td>
									                    <td><?php echo $values['product_name']; ?></td>
									                    <td><?php echo $values['invoice_quantity']?>
									                    </td>
									                    <td style="width:15%;"><?php echo $values['received_quantity']?>
									                    </td>
									                    <td><?php echo $values['shortage']?></td> 
									                </tr>
									                <?php   
									            }
									        } ?>  
									              
									    </tbody> 		
									    <?php
										}
									    ?>						    
								</table> 							
			                </div> 
		            	</div>
		            	<?php   
						}  }?>
	       			</div> 
	       			<div class="col-md-offset-1 col-md-10">
	       				<div class="portlet light portlet-fit"> 
	             			<div class="portlet-body">
	             				<div class="form-group">								
									<div class="col-xs-offset-5 col-xs-5">
										<a  href="<?php echo SITE_URL.'print_srn_invoice_details/'.cmm_encode(@$srn_number)?>" class="btn btn-primary tooltips" data-container="body" data-placement="top" data-original-title="Print SRN Details"><i class="fa fa-list"></i>Print</a>
	                                    <a type="submit" href="<?php echo SITE_URL.'stock_receiving_list';?>"  class="btn default tooltips"><i class="fa fa-arrow-left"></i>Back</a>
									</div>
								</div>
	             			</div>
	         			</div>
	       			</div> 
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->load->view('commons/main_footer', $nestedView); ?>