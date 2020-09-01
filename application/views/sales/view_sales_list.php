<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">  
                <div class="portlet-body">
                	<div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="header text-center">
                                    <span class="timer_block" style="float:right; color:#3A8ED6">
                                        <i class="fa fa-clock-o"></i>
                                    <span id="timer"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        foreach ($sales_list as $row)
                        {?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="inputName" class="col-md-4 control-label">Customer Name :</label>
                                    <p><b><?php echo $row['customer_name']?></b></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label class="col-md-4 control-label">Bill Number :</label>
                                    <p><b><?php echo $row['bill_number'] ?></b></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label class="col-md-4 control-label">Category :</label>
                                    <p><b><?php echo $row['category']?></b></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">    
                                <label class="col-md-4 control-label">Payment Mode :</label>
                                    <p><b><?php echo $row['pay_mode']?></b></p>
                                </div>
                            </div>
                        </div> 
                        <?php } ?>   
	                	<div class="table-scrollable">
		                    <table class="table table-bordered table-striped table-hover" id="sales_list">
		                    	<thead>
		                    		<tr>
		                    			<th>S.No</th>
		                    			<th>Product Name</th>
		                    			<th>Price</th>
		                    			<th>Quantity</th>
		                    			<th>Amount</th>
		                    		</tr>
		                    	</thead>
		                    	<tbody>
	                    		<?php $sn=1;
	                    			if($sales_list)
	                    			{
	                    				foreach ($sales_list as $row) 
	                    				{?>
	                    				<tr>
	                    					<td><?php echo $sn++ ?></td>
	                    					<td><?php echo $row['product']?></td>
	                    					<td><?php echo $row['price']?></td>
	                    					<td><?php echo $row['quantity']?></td>
	                    					<td><?php echo $row['amount']?></td>
	                    				</tr>
	                    				<?php		
	                    				}
	                    			}
	                    		?>
	                    	</tbody>
	                    	<tfoot>
	                    		<?php
		                    	foreach ($sales_list as $row) 
		                    	{?>
	                    			<tr>
		                    			<td colspan="3"></td>
		                    			<td>
		                    				TOTAL BILL
		                    			</td>
		                    			<td>
		                    				<?php echo $row['total_bill'] ?>
		                    			</td>
		                    		</tr>
			                    	<?php
			                    	if($row['cs_pay_mode_id'] == 1)
		                    		{?>
			                    		<tr>
			                    			<td colspan="3"></td>
			                    			<td>
			                    				DENOMINATION
			                    			</td>
			                    			<td>
			                    				<?php echo $row['received_denomination'] ?>
			                    			</td>
			                    		</tr>
			                    		<tr>
			                    			<td colspan="3"></td>
			                    			<td>
			                    				PAY TO CUSTOMER
			                    			</td>
			                    			<td>
			                    				<?php echo $row['pay_customer'] ?>
			                    			</td>
			                    		</tr>
		                        <?php   }
		                    		else
		                    		{?>
		                    			<tr>
			                    			<td colspan="3"></td>
			                    			<td>
			                    				DD NUMBER
			                    			</td>
			                    			<td>
			                    				<?php echo $row['dd_number'] ?>
			                    			</td>
			                    		</tr>
			                    		<tr>
			                    			<td colspan="3"></td>
			                    			<td>
			                    				BANK NAME
			                    			</td>
			                    			<td>
			                    				<?php echo $row['bank'] ?>
			                    			</td>
			                    		</tr>
		                    <?php	}		
	                    		}?>
	                    	</tfoot>
	                    </table>
	                </div> 
	                <div class="row">
		                <div class="col-md-offset-5 col-md-4">
		                	<a  class="btn blue" href="<?php echo SITE_URL.'counter_sale_view';?>">Back</a>
		                </div> 
	                </div>  
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('commons/main_footer', $nestedView); ?>                