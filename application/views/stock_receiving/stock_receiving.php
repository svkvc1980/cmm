 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">          
            <?php if(@$flag==1) { ?>                    
            <form id="ob_form" method="post" action="<?php echo SITE_URL.'stock_rec_invoice_products';?>" class="form-horizontal">
                <div class="col-md-12">
             		<div class="portlet light portlet-fit">                
        				<div class="portlet-body">
	        				<div class="row">
		        				<div class="col-md-offset-3 col-md-6 well">     
			                        <div class="form-group invoice_number">
					 					<label class="col-md-5 control-label mylabel">Enter Invoice Number<span class="font-red required_fld">*</span></label>
				 						<div class="col-md-5 mytext ">
				 							<div class="input-icon right">
				 								<i class="fa"></i>
				 								<input class="form-control" name="invoice_no[]"  placeholder="Invoice Number" type="text" required>
				 							</div>
				 						</div>
				 						<div class="col-md-2 mybutton">
				 							<a  class="btn blue tooltips add_invoice_info" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
				 						</div>
				 						<div class="col-md-2 deletebutton hide">
				 							<a  class="btn btn-danger tooltips delete" data-container="body" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
				 						</div>
			 					    </div>
			                        <div class="form-group">
			                            <div class="col-md-offset-5 col-md-7">
			                                <button class="btn blue" type="submit" name="submit" value="1"><i class="fa fa-check"></i> Submit</button>
			                                <a class="btn default" href="<?php echo SITE_URL;?>"><i class="fa fa-times"></i> Cancel</a>
			                            </div>
			                        </div>
			                    </div>
		                    	
		                    </div>
                		</div>
                	</div>
                </div>
            </form> 
            <?php } if(@$flag==2) { ?>                    
            <form id="ob_form" method="post" action="<?php echo SITE_URL.'confirm_products_free_gifts';?>" class="form-horizontal">
                <div class="col-md-offset-1 col-md-10">
             		<div class="portlet light portlet-fit"> 
             			<div class="portlet-body"> 
	             			<div class="padding"> 
	        					<div class="col-md-offset-1 col-md-10">
		        					<div class="col-md-4">
		        						<div class="form-group">
				                            <label class="col-sm-6 control-label">SRN No</label>
				                            <div class="col-sm-5">
				                            	<p class="form-control-static"><b><?php echo get_current_serial_number(array('value'=>'srn_number','table'=>'stock_receipt','where'=>'on_date')); ?></b></p>
				                            </div>
			                        	</div>
		        					</div>
		        					<div class="col-md-4">
		        						<div class="form-group">
				                            <label class="col-sm-6 control-label">Date</label>
				                            <div class="col-sm-5">
				                            	<p class="form-control-static"><b><?php echo date('d-m-Y'); ?></b></p>
				                            </div>
			                        	</div>
		        					</div>
	        					</div>
	                		</div>

	                		
                            <div class="form-group">
	                           
		                    </div>
                        </div>
                	</div>
                </div>
                <div class="col-md-offset-1 col-md-10">
                	<?php				    
				    foreach(@$invoice_product_free_items_results as $invoice_id => $value) 
				    {   ?>
					<input type="hidden" name="invoice_id[]" value="<?php echo $invoice_id ?>">
					<input type="hidden" name="invoice_number[<?php echo $invoice_id ?>]" value="<?php echo $value['invoice_num']; ?>">
	       			<div class="portlet box yellow">
		                <div class="portlet-title">
		                    <div class="caption">
		                        Invoice No: <?php echo $value['invoice_num']; ?> </div>
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
								        <th> Invoice Qty</th>
								        <th> Received Pouches </th>
								        <th> Shortage </th>
								    </tr>
								    <tbody>
								        <?php 
								        $sno = 1;
								         foreach(@$value['all_products'] as $keys =>$values) 
								         {  
								         	//echo '<pre>'; print_r($values); echo '</pre>';
								            if($values != '') 
								            { ?>
								        		<input type="hidden" name="invoice_do_product_ids[<?php echo $invoice_id ?>][]" value="<?php echo $values['invoice_do_product_id']; ?>">
								        		<input type="hidden" name="items_per_carton_arr[<?php echo $values['invoice_do_product_id']?>]" value="<?php echo $values['items_per_carton']; ?>">
								                <tr class="do_row">
								                    <td><?php echo $sno++; ?></td>
								                    <td>
								                    	<?php echo $values['product_name']; ?>
								                    	<input type="hidden" name="invoice_product_ids[<?php echo $values['invoice_do_product_id']?>]" value="<?php echo @$values['product_id']?>">
								                    </td>
								                    <td>								                    	
								                    	<input type="hidden" class="invoice_qty" name="product_invoice_qty[<?php echo $values['invoice_do_product_id']?>]" value="<?php echo @intval($values['invoice_qty'])*$values['items_per_carton']?>">
								                    	<?php echo   intval($values['invoice_qty'])*$values['items_per_carton'].'P  '.'('.intval($values['invoice_qty']).'C)'; ?>
								                    </td>
								                    <td><span class="received_quantity"><?php echo @intval($values['invoice_qty'])*$values['items_per_carton'].'P';?></span>
								                    	<input type="hidden" id="received_quantity" name="product_received_qty[<?php echo $values['invoice_do_product_id']?>]" value="<?php echo @intval($values['invoice_qty'])*$values['items_per_carton']?>">								                    	 
								                    </td> 
								                    <td style="width:15%;">								                    	
								                    	<input type="text" class="form-control shortage" name="invoice_product_shortage[<?php echo $values['invoice_do_product_id']?>]" style="width:80%" value="0">
								                    </td>								                    
								                </tr>
								                <?php   
								            }
								        } ?> 
								              
								    </tbody>
								    <br>
								     <?php if(count($value['packing_material']) !='') { ?>
								    <tr style="background-color:#bfcad1">
								       <td colspan="6">Packing Material</td>
								    </tr>
								    <tr style="background-color:#fafafa">
								        <th> S.No</th>
								        <th> Packing Material </th>
								        <th> Invoice Qty </th>
								        <th> Received Qty </th>
								        <th> Shortage </th>
								    </tr>
								    <tbody>
								        <?php $sn = 1;
								         foreach(@$value['packing_material'] as $keys =>$values) 
								         { 
								            if($values != '') 
								            { ?>								        	
								                <tr class="pm_row">
								                    <td><?php echo $sn++; ?></td>
								                    <td><?php echo $values['name']; ?>
								                    <input type="hidden" name="pm_id[<?php echo $invoice_id ?>][<?php echo $values['pm_id'] ?>]" value="<?php echo $values['pm_id']; ?>">
								                    <input type="hidden" name="pm_name[<?php echo $invoice_id ?>][<?php echo $values['pm_id'] ?>]" value="<?php echo $values['name']; ?>">
								                    <input type="hidden" name="pm_unit[<?php echo $invoice_id ?>][<?php echo $values['pm_id'] ?>]" value="<?php echo $values['pmunit']; ?>">
								                    </td>
								                    <td>
								                    	
								                    	<input type="hidden" class="pm_invoice_qty" name="pm_invoice_qty[<?php echo $invoice_id ?>][<?php echo $values['pm_id'] ?>]" value="<?php echo TrimTrailingZeroes(@$values['quantity'])?>">
								                    	<?php echo TrimTrailingZeroes($values['quantity']).' '.$values['pmunit']; ?>
								                    </td>
								                    <td><?php echo '<span class="pm_received_qty">'.TrimTrailingZeroes($values['quantity']).'</span> '.$values['pmunit']; ?>
								                    </td>
								                     <td style="width:15%;">								                    	
								                    	<input type="text" name="pm_shortage[<?php echo $invoice_id ?>][<?php echo $values['pm_id'] ?>]" value="0" class="form-control pm_shortage"  style="width:80%" required>
								                    </td>
								                </tr>
								                <?php   
								            }
								        } } ?>
								        </tbody>
								    <?php if(count($value['free_gifts']) !='' || count($value['free_products']) != '') { ?>
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
								         foreach(@$value['free_gifts'] as $keys =>$values) 
								         { 
								            if($values != '') 
								            { ?>								        	
								                <tr class="do_row">
								                    <td><?php echo $sn++; ?></td>
								                    <td><?php echo $values['free_gift_name']; ?>
								                    <input type="hidden" name="free_gift_id[<?php echo $invoice_id ?>][<?php echo $values['free_gift_id'] ?>]" value="<?php echo $values['free_gift_id']; ?>">
								                    <input type="hidden" name="free_gift_name[<?php echo $invoice_id ?>][<?php echo $values['free_gift_id'] ?>]" value="<?php echo $values['free_gift_name']; ?>">
								                    </td>
								                    <td>
								                    	<input type="hidden" name="free_gift_fg_scheme_id[<?php echo $invoice_id ?>][<?php echo $values['free_gift_id'] ?>]" value="<?php echo @$values['fg_scheme_id']?>">
								                    	<input type="hidden" class="invoice_qty" name="free_gift_invoice_qty[<?php echo $invoice_id ?>][<?php echo $values['free_gift_id'] ?>]" value="<?php echo @$values['invoice_qty']?>">
								                    	<?php echo $values['invoice_qty']; ?>
								                    </td>
								                    <td><span class="received_quantity_free_gift">0</span>
								                    <input type="hidden" id="received_quantity" name="free_gift_received_qty[<?php echo $invoice_id ?>][<?php echo $values['free_gift_id']?>]" value=""> 								                    	 
								                    </td> 
								                     <td style="width:15%;">								                    	
								                    	<input type="text" name="free_gift_shortage[<?php echo $invoice_id ?>][<?php echo $values['free_gift_id'] ?>]" class="form-control shortage"  style="width:80%" required>
								                    </td>
								                </tr>
								                <?php   
								            }
								        } ?>
								        <?php 
								         foreach(@$value['free_products'] as $keys =>$values) 
								         { 
								            if($values != '') 
								            { ?>
								        		<input type="hidden" name="free_product_items_per_carton[<?php echo $invoice_id ?>][<?php echo $values['product_id'] ?>]" value="<?php echo @$values['items_per_carton']?>">
								                <tr class="do_row">
								                    <td><?php echo $sno++; ?></td>
								                    <td><?php echo $values['product_name']; ?>
								                    	<input type="hidden" name="free_product_ids[<?php echo $invoice_id ?>][<?php echo $values['product_id']?>]" value="<?php echo @$values['product_id']?>">
								                    </td>
								                    <td>
								                    	<input type="hidden" name="free_product_fg_scheme_id[<?php echo $invoice_id ?>][<?php echo $values['product_id'] ?>]" value="<?php echo @$values['fg_scheme_id']?>">
								                    	<input type="hidden" name="free_product_invoice_qty[<?php echo $invoice_id ?>][<?php echo $values['product_id'] ?>]" class="invoice_qty" value="<?php echo @$values['invoice_qty']*$values['items_per_carton']?>">
								                    	<?php echo   intval($values['invoice_qty'])*$values['items_per_carton'].'P  '.'('.intval($values['invoice_qty']).'C)'; ?>
								                    </td>
								                     <td><span class="received_quantity">0</span>
								                    	<input type="hidden" id="received_quantity" name="free_product_received_qty[<?php echo $invoice_id ?>][<?php echo $values['product_id']?>]" value="">								                    	 
								                    </td> 
								                    <td style="width:15%;">								                    	
								                    	<input type="text" class="form-control shortage" name="shortage[<?php echo $invoice_id ?>][<?php echo $values['product_id'] ?>]" style="width:80%" required>
								                    </td>

								                </tr>
								                <?php   
								            }
								        } ?>  
								              
								    </tbody> 
								    <?php } ?>								    
							</table> 							
		                </div> 
	            	</div>
	            	<?php   
					}  ?>
       			</div>
       			<div class="form-group">								
					<div class="col-xs-offset-5 col-xs-5">
						<button type="submit" name="search_ob" value="1" class="btn blue tooltips"><i class="fa fa-check"></i>Submit</button>
                        <a type="submit" href="<?php echo SITE_URL.'stock_receiving';?>" class="btn default tooltips"><i class="fa fa-times"></i>Cancel</a>
					</div>
				</div>       			
            </form>
            <?php } ?>               
        </div>
    </div>
</div>
<!-- END PAGE CONTENT INNER -->

<?php $this->load->view('commons/main_footer', $nestedView); ?>

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

    ele_clone.find('.delete').click(function() {      
        $(this).closest('.invoice_number').remove();
      
    });
    ele.after(ele_clone);
    
});

$(document).on('blur','.shortage',function(){
	if($(this).val()!='')
     	var shortage = parseInt($(this).val());
 	else
 		var shortage = 0;
     var do_row = $(this).closest('.do_row');
     var invoice_qty = parseInt(do_row.find('.invoice_qty').val());
     if(shortage>invoice_qty)
     {
        alert('Shortage Should be less than Invoice Qty');
        $(this).val(0);
        return false;
     }

     var received_quantity = invoice_qty-shortage;
     do_row.find('.received_quantity').html(received_quantity+' P');
     do_row.find('#received_quantity').val(received_quantity);
     do_row.find('.received_quantity_free_gift').html(received_quantity);
  });

$(document).on('blur','.pm_shortage',function(){
	if($(this).val()!='')
     	var shortage = parseInt($(this).val());
 	else
 		var shortage = 0;
     var pm_row = $(this).closest('.pm_row');
     var pm_invoice_qty = parseInt(pm_row.find('.pm_invoice_qty').val());
     if(shortage>pm_invoice_qty)
     {
        alert('Shortage Should be less than Invoice Qty');
        $(this).val(0);
        return false;

     }

     var received_quantity = pm_invoice_qty-shortage;
     pm_row.find('.pm_received_qty').html(received_quantity);
  });
</script>