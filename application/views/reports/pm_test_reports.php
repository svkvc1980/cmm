<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                	<form role="form" class="form-horizontal" method="post" action="<?php echo SITE_URL;?>pm_test_r">
                        <div class="row">
                            <div class="col-sm-3">
                                <?php echo form_dropdown('packing_material',$packing_material,@$search_data['packing_material'],'class="form-control" name="packing_material"');?>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" name="test_number" maxlength="150" value="<?php echo @$search_data['test_number'];?>" class="form-control" placeholder="Test Number">
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group date-picker input-daterange " data-date-format="dd-mm-yyyy">
                                    <input class="form-control" name="start_date"  placeholder="From Date" type="text" value="<?php if(@$search_data['start_date']!=''){ echo @date('d-m-Y',strtotime($search_data['start_date'])); }?>" >
                                    <span class="input-group-addon"> to </span>
                                        <input class="form-control " name="end_date" placeholder="To Date" type="text" value="<?php if(@$search_data['end_date']!=''){ echo @date('d-m-Y',strtotime($search_data['end_date'])); }?>">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" name="serach_test" value="1" class="btn blue tooltips btn-sm" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i> </button>
                            	<button name="reset" value="" class="btn blue tooltips btn-sm" data-container="body" data-placement="top" data-original-title="Reset"><i class="fa fa-refresh"></i></button>
                                <button type="submit" name="print_lab_test_pm" value="1" formaction="<?php echo SITE_URL.'print_lab_test_pm';?>" class="btn btn-danger tooltips btn-sm" data-container="body" data-placement="top" data-original-title="Print"><i class="fa fa-print"></i></button>
                            </div>
                        </div>
                    </form>
	                <div class="table-scrollable">
		                <table class="table table-bordered table-striped table-hover">
		                    <thead>
		                        <tr>
		                        	<th>PO No</th>
                            		<th>Test For</th>
                            		<th>Test No</th>
                            		<th>Test Date</th>
                            		<th>Invoice No</th>
                            		<th>Supplier</th>
                            		<th>Test Status</th>
                                    <th>Print</th>
		                        </tr>
		                    </thead>
		                    <tbody>
                            	<?php
                            	if($pm_test_reports)
                            	{ 
                            		foreach ($pm_test_reports as $row) 
                            		{ ?>
                            			<tr>
                            				<td><?php echo $row['po_number']?></td>
                            				<td><?php echo $row['packing_material']?></td>
                            				<td><?php echo $row['test_number']?></td>
                            				<td><?php echo date('d-m-Y',strtotime($row['test_date']));?></td>
                            				<td><?php echo $row['invoice_number']?></td>
                            				<td><?php echo $row['s_agency']?></td>
                            				<td>
                        					<?php
                            					if($row['test_status']==1)
                            					{
                            						echo "<span class='label label-success'>Pass</span>";
                            					}
                            					else
                            					{
                            						echo "<span class='label label-danger'>Fail</span>";
                            					}
                        					?>
                        				    </td>
                                            <td>
                                                <a class="btn btn-success btn-xs tooltips" data-container="body" data-placement="top" data-original-title="Print Packing Material Test" href="<?php echo SITE_URL;?>download_pm_test_r/<?php echo @cmm_encode($row['lab_test_id']); ?>"><i class="fa fa-print"></i></a>
                                            </td>
                            			</tr>
                            	<?php }
                            	}
                            	else 
	                            {
	                            ?>  
	                                <tr><td colspan="8" align="center"><span class="label label-primary">No Records</span></td></tr>
	                            <?php   
                            	} ?>		
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
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>