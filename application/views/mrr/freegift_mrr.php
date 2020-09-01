<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
        	 <?php if(@$flag==2)
                {
                ?>
             <form class="form-horizontal " role="form" method="post" action="<?php echo SITE_URL.'insert_free_gift_mrr_details';?>"> 
        	<div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-list"></i>Free Gift MRR Details 
                    </div>
                </div>
                <div class="portlet-body">                
                	<div class="row">                		
                		<div class="col-md-4">
                			<div class="form-group">
                                <label class="col-xs-6 control-label">Tanker In Number</label>
                                <div class="col-xs-6">
                                   <p class="form-control-static"><b><?php echo @$tanker_register[0]['tanker_in_number']?></b></p>
                                </div>
                            </div>
                		</div>
						<div class="col-md-4">
                			<div class="form-group">
                                <label class="col-xs-6 control-label">PO Number</label>
                                <div class="col-xs-6">
                                  <p class="form-control-static"><b><?php echo @$po_free_gift_details[0]['po_number']?></b></p>
                                </div>
                            </div>
                		</div>
                		<div class="col-md-4">
                			<div class="form-group">
                                <label class="col-xs-4 control-label">Tanker In Date</label>
                                <div class="col-xs-7">
                                    <p class="form-control-static"><b><?php echo @$tanker_register[0]['in_time']?></b></p>
                                </div>
                            </div>
                		</div>
                	</div>
                	<div class="row">                		
                		<div class="col-md-4">
                			<div class="form-group">
                                <label class="col-xs-6 control-label">Invoice No</label>
                                <div class="col-xs-6">
                                    <p class="form-control-static"><b><?php echo @$tanker_register[0]['invoice_number']?></b></p>
                                </div>
                            </div>
                		</div>
						<div class="col-md-4">
                			<div class="form-group">
                                <label class="col-xs-6 control-label">Free Gift</label>
                                <div class="col-xs-6">
                                  <p class="form-control-static"><b><?php echo @$free_gift_name?></b></p>
                                </div>
                            </div>
                		</div>
                		<div class="col-md-4">
                			<div class="form-group">
                                <label class="col-xs-4 control-label">Supplier</label>
                                <div class="col-xs-7">
                                   <p class="form-control-static"><b><?php echo @$supplier_name?></b></p>
                                </div>
                            </div>
                		</div>
                	</div>
                	<div class="row">                		
                		<div class="col-md-4">
                			<div class="form-group">
                                <label class="col-xs-6 control-label">PO Date</label>
                                <div class="col-xs-6">
                                   <p class="form-control-static"><b><?php echo @$po_free_gift_details[0]['po_date']?></b></p>
                                </div>
                            </div>
                		</div>
						<div class="col-md-4">
                			<div class="form-group">
                                <label class="col-xs-6 control-label">Vehicle Number</label>
                                <div class="col-xs-6">
                                   <p class="form-control-static"><b><?php echo @$tanker_register[0]['vehicle_number']?></b></p>
                                </div>
                            </div>
                		</div>
                		<div class="col-md-4">
                			<div class="form-group">
                                <label class="col-xs-4 control-label">Unit Price</label>
                                <div class="col-xs-7">
                                  <p class="form-control-static"><b><?php echo @$po_free_gift_details[0]['unit_price']?></b></p>
                                </div>
                            </div>
                		</div>
                	</div>
                	<div class="row">                		 
						<div class="col-md-4">
                			<div class="form-group">
                                <label class="col-xs-6 control-label">Gross Weight</label>
                                <div class="col-xs-6">
                                   <p class="form-control-static"><b><?php echo @$tanker_fg[0]['gross']?></b></p>
                                </div>
                            </div>
                		</div>
                		<div class="col-md-4">
                			<div class="form-group">
                                <label class="col-xs-6 control-label">Tare Weight</label>
                                <div class="col-xs-6">
                                   <p class="form-control-static"><b><?php echo @$tanker_fg[0]['tier']?></b></p>
                                </div>
                            </div>
                		</div>
                		<div class="col-md-4">
                			<div class="form-group">
                                <label class="col-xs-4 control-label">Net Weight</label>
                                <div class="col-xs-8">
                                  <p class="form-control-static"><b><?php echo @$tanker_fg[0]['gross']-@$tanker_fg[0]['tier']?></b></p>
                                </div>
                            </div>
                		</div>
                	</div>                	
                </div>
           </div>
           <div class="portlet light portlet-fit">
                <div class="portlet-body">
                	<div class="row srow">  
                	<input type="hidden" class="form-control" id="tanker_fg_id" name="tanker_fg_id" value="<?php echo @$tanker_fg[0]['tanker_fg_id']?>">
                	<input type="hidden" class="form-control" id="tanker_id" name="tanker_id" value="<?php echo @$tanker_register[0]['tanker_id']?>">              		
                		<div class="col-md-4">
                			<div class="form-group">
                                <label class="col-xs-6 control-label">Invoice Quantity</label>
                                <div class="col-xs-6">
                                    <input type="hidden" class="form-control " id="invoice_quantity" name="tanker_in_num" value="<?php echo @$tanker_fg[0]['invoice_qty']?>">
                                   <p class="form-control-static"><b><?php echo @$tanker_fg[0]['invoice_qty']?></b></p>
                                </div>
                            </div>
                		</div>
						<div class="col-md-4">
                			<div class="form-group">
                                <label class="col-xs-6 control-label">Received Quantity</label>
                                <div class="col-xs-6">
                                  <input type="text" class="form-control received_quantity" required id="received_quantity" name="received_quantity">
                                  <span class="err_received_quantity"></span>
                                </div>
                            </div>
                		</div>
                		<div class="col-md-4">
                			<div class="form-group">
                                <label class="col-xs-4 control-label">Balance Qty</label>
                                <div class="col-xs-7">
                                  <input type="text" class="form-control" required id="net_quantity" name="net_quantity" disabled="">
                                </div>
                            </div>
                		</div>
                	</div>
                	<div class="row">                		
                		<div class="col-md-4">
                			<div class="form-group">
                                <label class="col-xs-6 control-label">Ledger No</label>
                                <div class="col-xs-6">
                                   <input type="text" class="form-control" required name="ledger_number" >
                                </div>
                            </div>
                		</div>
						<div class="col-md-4">
                			<div class="form-group">
                                <label class="col-xs-6 control-label">Folio No </label>
                                <div class="col-xs-6">
                                  <input type="text" class="form-control" required  name="folio_number" >
                                </div>
                            </div>
                		</div>
                		<div class="col-md-4">
                			<div class="form-group">
                                <label class="col-xs-4 control-label">MRR Date</label>
                                <div class="col-xs-7">
                                  <input type="hidden" class="form-control" name="mrr_date" value="<?php echo date('Y-m-d'); ?>">
                                  <p class="form-control-static"><b><?php echo date('d-m-Y'); ?></b></p>
                                </div>
                            </div>
                		</div>
                		<div class="col-md-4">
                			<div class="form-group">
	                                <label class="col-xs-6 control-label">Remarks</label>
	                                <div class="col-xs-6">
	                                  <textarea class="form-control" name="remarks"></textarea> 
	                                </div>
	                            </div>
                		</div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-xs-6 control-label">M.R.R. No.</label>
                                <div class="col-xs-6">
                                    <p class="form-control-static"><b><?php echo $mrr_no ?></b></p>
                                </div>
                            </div>
                        </div>
                	</div>
                	<div class="row">                		
                		<div class="col-md-offset-5 col-md-4">
                			<button class="btn btn-primary">Submit</button>
                			<a href="<?php echo SITE_URL.'freegift_mrr';?>" class="btn btn-default">Cancel</a>
                		</div>
                	</div>
                </div>
            </div>
        </form>

           <?php } ?>
           <?php if(@$flag==1)
                {
                ?> 
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                 <form method="post" action="<?php echo SITE_URL.'freegift_insert_po_fg';?>" class="form-horizontal">
                        <div class="row">                        
                            <div class="col-md-offset-3 col-md-6 well">
                                <div class="form-group">
                                    <label class="col-xs-5 control-label">PO Number</label>
                                    <div class="col-xs-6">
                                      <input type="text" class="form-control" name="po_num" maxlength="20" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-5 control-label">Tanker In Number</label>
                                    <div class="col-xs-6">
                                      <input type="text" class="form-control" name="tanker_in_num" maxlength="20"  required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-5"></div>
                                     <div class="col-xs-7">
                                    <button type="submit" class="btn blue tooltips" name="submit">Submit</button>                                    
                                       <a href="<?php echo SITE_URL.'freegift_mrr';?>" class="btn default">Cancel</a>  
                                    </div>                                 
                                </div>
                            </div>
                        </div>
                    </form> 
                <?php 
                } ?>
                
                    
                </div>

            </div>

            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->

<?php $this->load->view('commons/main_footer', $nestedView); ?>
<script>
$(document).on('keyup','.received_quantity',function()
{ 
  var ele_panel_body=$(this).closest('.srow');
  var invoice_quantity=$('#invoice_quantity').val();
  var received_quantity=$('#received_quantity').val();
  //alert (received_quantity);
  if(parseInt(received_quantity) > parseInt(invoice_quantity) || received_quantity == '')
  {
  	if(received_quantity != '')
  	{
	  	//alert('ok');
	    ele_panel_body.find('.quoted_rate').css("border-color","red");
	    ele_panel_body.find('.received_quantity').css("border-color","red");
	    ele_panel_body.find('.err_received_quantity').html('Received Qty must be smaller than Invoice Qty');  
	    $('#net_quantity').val('');  
	    return false;
	}
	 	$('#net_quantity').val('');
  }
  else
  {
    html='';
    ele_panel_body.find('.quoted_rate').css("border-color","green");
    ele_panel_body.find('.received_quantity').css("border-color","green");
    ele_panel_body.find('.err_received_quantity').html(html);
    var net_quantity = invoice_quantity - received_quantity;
    $('#net_quantity').val(net_quantity);
  }
});
</script>
