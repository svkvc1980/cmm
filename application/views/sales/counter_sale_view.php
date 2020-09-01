 <?php $this->load->view('commons/main_template', $nestedView); ?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                	<form method="post" action="<?php echo SITE_URL.'counter_sale_view'?>">
	                    <div class="row">           
	                        <div class="col-sm-2">
		                        <div class="form-group">
		                            <input class="form-control" maxlength="20" name="customer_name" value="<?php echo @$search_data['customer_name'];?>" placeholder="Customer Name" type="text">
		                        </div>
	                        </div>
	                        <div class="col-sm-2">
	                            <div class="form-group">
	                                <input class="form-control" name="billno" value="<?php echo @$search_data['billno'];?>" placeholder="Bill No" type="text">
	                            </div>
	                        </div>
	                        <div class="col-sm-2">
	                            <div class="form-group">
	                                <input type="name" class="form-control date-picker date" data-date-format="dd-mm-yyyy"  placeholder="Date" name="date" value="<?php if(@$search_data['date']!=''){ echo date('d-m-Y',strtotime(@$search_data['date'])); } ?>">
	                            </div>
	                        </div>
                            <div class="col-md-2">
                                <select class="form-control" name="category">
                                    <option selected value="">Select Category</option>
                                    <?php 
                                    	foreach($category as $row)
                                        {   
                                        	$selected='';
                                            if($row['cs_category_id']==@$search_data['category']) $selected='selected';
                                            echo '<option value="'.$row['cs_category_id'].'"'.$selected.'>'.$row['name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
	                        <div class="col-sm-2">
	                            <div class="form-actions">
	                                <button type="submit" name="searchsales" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
	                                <a  class="btn blue tooltips" href="<?php echo SITE_URL.'counter_sale_view';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
	                                <a href="<?php echo SITE_URL;?>counter_sales" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
	                            </div>
	                        </div>
	                    </div>
                	</form>
                	<div class="table-scrollable">
	                    <table class="table table-bordered table-striped table-hover" id="sales_list">
	                    	<thead>
	                    		<tr>
	                    			<th>S.No</th>
	                    			<th>Bill No</th>
	                    			<th>Date</th>
	                    			<th>Customer Name</th>
	                    			<th>Category</th>
	                    			<th>Amount</th>
	                    			<th>Actions</th>
	                    		</tr>
	                    	</thead>
	                    	<tbody>
	                    		<?php
	                    			if($salesResults)
	                    			{
	                    				foreach ($salesResults as $row) 
	                    				{?>
	                    					<tr>
	                    						<td><?php echo $sn++;?></td>
	                    						<td><?php echo $row['bill_number'];?></td>
	                    						<td><?php echo date('d-m-Y',strtotime($row['on_date']));?></td>
	                    						<td><?php echo $row['customer_name'];?></td>
                    							<td><?php echo $row['category'];?></td>
                    							<td><?php echo $row['total_bill'];?></td>
                    							<td>
		                                            <a class="btn btn-primary btn-xs tooltips" data-container="body" data-placement="top" data-original-title="View Sales List" href="<?php echo SITE_URL;?>view_sales_list/<?php echo @cmm_encode($row['counter_sale_id']); ?>"><i class="fa fa-eye"></i></a>
		                                            <a class="btn btn-success btn-xs tooltips" data-container="body" data-placement="top" data-original-title="Print Sales" href="<?php echo SITE_URL;?>print_counter_sales/<?php echo @cmm_encode($row['counter_sale_id']); ?>"><i class="fa fa-print"></i></a>
		                                           <!--  <?php
		                                            if(@$row['cs_status'] == 1)
		                                            {
		                                                ?>
		                                                <a href="<?php echo SITE_URL;?>delete_counter_sales/<?php echo @cmm_encode($row['counter_sale_id']); ?>" class="btn btn-danger btn-xs tooltips" data-toggle="modal" data-target="#myModal" data-container="body" data-placement="top" data-original-title="De-Activate"><i class="fa fa-trash-o"></i></a>
		                                                <?php
		                                            }
		                                            else
		                                            {
		                                                ?>
		                                                <a class="btn btn-info btn-xs tooltips" data-container="body" data-placement="top" data-original-title="Activate" onclick="return confirm('Are you sure you want to Activate?')" href="<?php echo SITE_URL;?>activate_counter_sales/<?php echo @cmm_encode($row['counter_sale_id']); ?>"><i class="fa fa-check"></i></a>
		                                                <?php
		                                            }
		                                            ?> -->
		                                        </td>
	                    					</tr>
	                    		<?php   }
	                    			}
	                    			else 
	                    			{ ?>
										<tr><td colspan="7" align="center"><span class="label label-primary">No Records</span></td></tr>
							<?php 	} ?>
	                    	</tbody>
	                    </table>
	                </div>
	                <div class="row">
                        <div class="col-md-5 col-sm-5">
                            <div class="dataTables_info" role="status" aria-live="polite">
                                <?php echo @$pagermessage; ?>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-7">
                            <div class="dataTables_paginate paging_bootstrap_full_number">
                                <?php echo @$pagination_links; ?>
                            </div>
                        </div>
                    </div>
                    <form method="post" action="<?php echo SITE_URL.'delete_counter_sales'?>">
	                    <div class="modal fade" id="myModal" role="dialog">
						    <div class="modal-dialog">
						        <!-- Modal content-->
						      	<div class="modal-content">
							        <div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<span class="modal-title font-purple-soft font-md bold uppercase">Enter Some Remarks Here...</span>
							        </div>
							        <div class="modal-body">
							        	<div class="col-sm-12">
					                        <div class="form-group">
					                            <textarea class="form-control" maxlength="120" name="remarks" value="" placeholder="Remarks..." type="text"></textarea>
					                        </div>
				                        </div>
							        </div>
							        <div class="modal-footer">
								        <div class="col-sm-12">
						                    <div class="form-group">
						                    	<input type="submit" name="submit_remarks" class="btn purple-soft btn-sm" value="submit">
									        	<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
									        </div>
								        </div>
							        </div>
						      	</div>  
						    </div>
						</div> 
					</form>		
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>