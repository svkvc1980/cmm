 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
        <div class="col-md-12">
     		<div class="portlet light portlet-fit">                
				<div class="portlet-body"> 
					<div class="row">
						<form id="ob_form" method="post" action="<?php echo SITE_URL.'stock_receiving_list';?>" class="form-horizontal">
    						<div class="col-md-12">
	        					<div class="col-md-4">                 
			                        <div class="form-group">
			                            <label class="col-sm-4 control-label">SRN Number</label>
			                            <div class="col-sm-8">
			                            	<input type="text" name="srn_number" placeholder="SRN Number" value="<?php echo @$search_data['srn_number']; ?>"class="form-control">
			                            </div>
			                        </div>
			                    </div>
			                    <div class="col-md-5">                 
			                        <div class="form-group">
			                        	<label class="col-sm-3 control-label">Date</label>
			                        	<div class="col-sm-9">
											<div class="input-group input-large date-picker input-daterange" data-date-format="yyyy-mm-dd">
							                    <input type="text" class="form-control" name="fromDate"  value="<?php echo @$search_data['fromDate'] ?>">
							                    <span class="input-group-addon"> to </span>
							                    <input type="text" class="form-control" name="toDate"  value="<?php echo @$search_data['toDate'] ?>"> 
						               		</div>
					               		</div>
									</div>
			                    </div>		                       
	                        </div>
	                        <div class="col-md-12">
	        					<div class="col-md-4">                 
			                        <div class="form-group">
			                            <label class="col-sm-4 control-label">Vehicle No</label>
			                            <div class="col-sm-8">
			                            	<input type="text" name="vehicle_number" placeholder="Vehicle Number" value="<?php echo @$search_data['vehicle_number']; ?>" class="form-control">
			                            </div>
			                        </div>
			                    </div>
			                    <div class="col-md-5">                 
			                        <div class="form-group">
			                        	<label class="col-sm-3 control-label">Invoice No</label>
			                        	<div class="col-sm-9">
											<input type="text" name="invoice_number" placeholder="Invoice Number" value="<?php echo @$search_data['invoice_number']; ?>" class="form-control">
					               		</div>
									</div>
			                    </div>
			                    <div class="col-md-2"> 
			                    	<div class="form-group">								
										<div class="col-xs-12">
											<button type="submit" name="search_srn" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
		                                    <button type="submit" class="btn blue tooltips" name="download_srn" value="1" formaction="<?php echo SITE_URL.'download_srn_list';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>
		                                    <a  class="btn blue tooltips" href="<?php echo SITE_URL.'stock_receiving';?>" data-original-title="Back to Stock Receiving"> <i class="fa fa-chevron-left"></i></a>
		                                </div>
									</div>
			                    </div>		                       
	                        </div>
                        </form>
                    </div>
                    <div class="row">
						<div class="col-md-12">
							<div class="table-scrollable">
		                        <table class="table table-bordered table-striped table-hover">
		                            <thead>
		                                <th> S.No</th>
		                                <th> SRN Number </th>
		                                <th> Invoice Number </th>
		                                <th> Vehicle Number </th>
		                                <th> Date </th>
		                                <th> Actions </th>
		                            </thead>
		                            <tbody>
		                            	<?php
		                                if(@$srn_results)
		                                {

		                                foreach(@$srn_results as $row)
		                                	{ ?>                                	
		                            	<tr>
		                            		<td><?php echo $sn++;?></td>
		                            		<td><?php echo $row['srn_number'];?> </td>
		                            		<td><?php echo $row['invoice_number'];?> </td>
		                            		<td><?php echo $row['vehicle_number'];?> </td>
		                            		<td><?php echo $row['on_date'];?> </td>
		                            		<td><a  href="<?php echo SITE_URL.'view_srn_invoice_details/'.cmm_encode(@$row['srn_number']);?>" class="btn btn-default btn-circle btn-xs tooltips" data-container="body" data-placement="top" data-original-title="View SRN Invoice Details"><i class="fa fa-eye"></i></a>
		                                        <a  href="<?php echo SITE_URL.'print_srn_invoice_details/'.cmm_encode(@$row['srn_number']);?>" class="btn btn-default btn-circle btn-xs tooltips" data-container="body" data-placement="top" data-original-title="Print SRN Details"><i class="fa fa-list"></i></a>
		                                        </td>
		                            	</tr>
		                            	<?php
		                                    }
		                                }
		                                else
		                                {
		                            		?> <tr><td colspan="7" align="center"> No Records Found</td></tr>      
		                        <?php   }
		                                ?>
		                            </tbody>
	                            </table>
                            </div>
						</div>
					 </div>
        		</div>
        	</div>
        </div>
    </div>   
</div>


<?php $this->load->view('commons/main_footer', $nestedView); ?>