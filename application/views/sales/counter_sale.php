<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">  
                <div class="portlet-body">
                    <div class="alert alert-danger display-hide" style="display: none;">
                       <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                    </div>
                    <form id="counter_sales_form" method="post" action="<?php echo SITE_URL;?>counter_sales" class="form-horizontal">
                        <div class="row">
	                        <div class="col-md-12">
		                        <div class="col-md-6">
		                        	<div class="col-md-3">
		                        		<strong>DATE</strong>
		                        	</div>
		                        	<div class="col-md-6">
		                        		<?php echo date('d-M-Y h:i:s A'); ?>
		                        	</div>
		                        </div>
		                        <div class="form-group">
		                        <label for="inputName" class="col-sm-2 control-label">Customer Name<span class="font-red required_fld">*</span></label>
		                            <div class="col-sm-3">
		                                <div class="input-icon right">
		                                    <i class="fa"></i>
		                                    <input type="text" class="form-control" id="" placeholder="Customer Name" name="customer" value="" maxlength="150">
		                                </div>
		                            </div>
		                        </div>
	                        </div>
                        </div>
                        <div class="row">
	                        <div class="col-md-12">
		                        <div class="col-md-6">
		                        	<div class="col-md-3">
		                        		<strong>BILL NO</strong>
		                        	</div>
		                        	<div class="col-md-6">
		                        		<?php echo 2 ?>
		                        	</div>
		                        </div>
		                        <div class="col-md-6">
		                        	<div class="col-md-2">
		                        		<strong>CATEGORY</strong>
		                        	</div>
		                        	<div class="col-md-6">
		                        		<input type="radio" name="category" value="public" checked> Public &nbsp;
  										<input type="radio" name="category" value="staff"> Staff
		                        	</div>
		                        </div>
		                    </div>
                        </div>
                    </form>
                    <div class="table-scrollable">
	                    <table class="table table-bordered table-striped table-hover" id="sales">
	                        <thead>
	                            <tr>
	                                <th width="20"> Product Name </th>
	                                <th width="20"> Price </th>
	                                <th width="20"> Quantity </th>
	                                <th width="20"> Amount </th>
	                                <th width="20"> Delete </th>            
	                            </tr>
	                        </thead>
	                        <tbody> 
	                        	<tr>
	                        		<td>
			                    		<?php echo form_dropdown('product', $product, @$search_data['product_id'],'class="form-control" name="product"');?>
	                        		</td>
	                        		<td>
		                                <input type="text" class="form-control numeric price" id="price" onkeyup="javascript:this.value=Comma(this.value);" placeholder="Price" name="price" maxlength="15">
	                        		</td>
	                        		<td>
		                                <input type="text" class="form-control numeric qty" id="qty" placeholder="Quantity" name="quantity" maxlength="15">
	                        		</td>
	                        		<td align="right">
		                                <span class="amount"></span>
	                        		</td>
	                        		<td style="display:none">
	                        		    <button class="btn red btn-xs" type="submit" name="remove" id="remove" value="button"><i class="fa fa-trash"></i></button>
	                        		</td>
	                        	</tr>
	                        </tbody>
	                        <tfoot>
	                        	<tr>
		                        	<td colspan="2">
		                        	</td>
		                        	<td>
		                        		Total Bill:
		                        	</td>
		                        	<td align="right">
		                        		<span id="total"></span>
		                        	</td>
		                        	<td>
		                        	</td>
	                        	</tr>
	                        	<tr>
	                        		<td colspan="2">
		                        	</td>
		                        	<td>
		                        		Denomination Recieved:
		                        	</td>
		                        	<td align="right">
		                        		<input type="text" id="den" class="form-control numeric " onkeyup="javascript:this.value=Comma(this.value);"  placeholder="Denomination" name="denomination"  maxlength="15">
		                        	</td>
		                        	<td>
		                        	</td>
	                        	</tr>
	                        	<tr>
	                        		<td colspan="2">
		                        	</td>
		                        	<td>
		                        		Pay To Customer:
		                        	</td>
		                        	<td align="right">
		                        		<span id="pay_customer"></span>
		                        	</td>
		                        	<td>
		                        	</td>
	                        	</tr>
	                        </tfoot>
	                    </table>
	                </div>
	                <button class="btn blue" type="submit" name="add" id="add" value="button"><i class="fa fa-plus"></i>Add New</button>
	                <a class="btn blue" type="submit" href="<?php echo SITE_URL;?>print_counter_sales" name="print" id="print" value="button"><i class="fa fa-print"></i>Print</a><br>
	            	<span class="dd">CASH</span>
	            	<input type="checkbox" id="checkbox" name="dd" checked>
	            	<p style="color:blue;"> (Uncheck for DD)</p>
            	</div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>