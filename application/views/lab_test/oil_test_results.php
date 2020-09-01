<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                	<form id="test_confirmation" method="post" action="<?php echo SITE_URL.'oil_test_results';?>">
                		<div class="table-scrollable">
                        	<table class="table table-bordered table-striped">
                                <tbody>
                                 	<tr class="bg-blue" align="center">
		                                <td colspan="4" style="color:white;" valign="top"><b>REFINED <?php echo $test_reports[0]['loose_oil'] ?> ANALYSIS REPORT</b></td>
		                            </tr>
                                    <tr>
                                    	<th width="25">Test Number</th>
		                                <td><?php echo get_test_number(); ?></td> 
		                                <th width="25">Test Date</th>
		                                <td><?php echo date('d-M-Y'); ?></td>   
		                            </tr>
		                            <tr>
		                            	<th width="25">Name of the Supplier</th>
		                                <td><?php echo $test_reports[0]['s_agency'] ?></td>
		                            	<th width="25">Vehicle No</th>
		                            	<td> <?php echo $test_reports[0]['vehicle_number'] ?></td>
		                            </tr>
		                            <tr>
		                            	<th width="25">Purchase Order Number</th>
		                            	<td><?php echo $test_reports[0]['po_number'] ?></td>
		                            	<th width="25">Invoice Number</th>
		                            	<td><?php echo $test_reports[0]['invoice_number'] ?></td>
		                            </tr>
		                            <tr>
		                            	<th width="25">Date Of Reciept</th>
		                            	<td><?php echo date('d-M-Y'); ?></td>
		                            	<th width="25">Date Of Unloading/Rejection</th>
		                            	<td><?php echo date('d-M-Y'); ?></th>
		                            </tr>
		                            <tr>
		                            	<th width="25">Rate</td>
		                            	<td><?php echo $test_reports[0]['unit_price'] ?></td>
		                            	<th width="25">Name Of The Broker</th>
		                            	<td><?php echo $test_reports[0]['b_agency'] ?></td>
		                            </tr>
                                </tbody>
                            </table>
                        </div>
	            		<div class="table-scrollable">
	                    	<table class="table table-bordered table-striped">
	                            <tbody>
	                            	<tr class="bg-blue" align="center">
		                                <td colspan="4" style="color:white;" valign="top"><b>TEST RESULTS</b></td>
		                            </tr>
		                            <?php 
		                            	foreach ($test_results as $key => $value) 
		                            	{ ?>
		                            		<tr class="bg-grey-steel">
		                            			<th> <?php echo $value['test_group']; ?></th>
		                            			<th> Value Obtained </th>
		                            			<th> Permissible Range </th>
		                            			<th> Test Status </th>
		                            		</tr>
		                            		<?php 
		                            			#echo '<pre>';print_r($value['tests']);
		                            			foreach($value['tests'] as $keys =>$test_row)
		                            				{ ?>
		                            		<tr>
		                            			<td> <?php echo $test_row['loose_oil_test'];  ?></td>
		                            			<td>
	                            					<div class="form-group">
	                            					<?php
	                            					switch($test_row['range_type_id'])
			                            			{
			                            				case 1: case 4:
			                            				?>
			                            				
	                            						<?php
	                            							echo $test_row['value'];
	                            						break;
	                            						case 2: case 3:
	                            						?>
			                            				
	                            						<?php
		                            						echo get_oil_test_option_value_by_key($test_row['value'],$test_row['test_id']);
	                            						break;
	                            					} //end of switch
	                            					?>
	                            					<input type="hidden" name="test_result[<?php echo $test_row['test_id'] ?>]" value="<?php echo $test_row['value']; ?>">
	                            					</div>
		                            			<td>
		                            					<?php
		                            					switch($test_row['range_type_id'])
				                            			{
				                            				case 1: 
				                            					if($test_row['lower_limit'] != NULL && $test_row['upper_limit'] != NULL)
				                            					{
				                            						if($test_row['lower_check']==1)
				                            						{
				                            							if($test_row['upper_check']==1)
				                            							{
				                            								$range = $test_row['lower_limit'].' TO '.$test_row['upper_limit'];
				                            							}
				                            							else
				                            							{
				                            								$range = $test_row['lower_limit'].' TO '.' <'.$test_row['upper_limit'];
				                            							}
				                            						}
				                            						else
				                            						{
				                            							if($test_row['upper_check']==1)
				                            							{
				                            								$range = '> '.$test_row['lower_limit'].' TO '.' <= '.$test_row['upper_limit'];
				                            							}
				                            							else
				                            							{
				                            								$range = '> '.$test_row['lower_limit'].' TO '.' < '.$test_row['upper_limit'];
				                            							}
				                            						}
				                            					}
				                            					else
				                            					{
				                            						if($test_row['lower_limit']==NULL)
				                            						{
				                            							if($test_row['upper_check']==1)
				                            							{
				                            								$range = '<= '.$test_row['upper_limit'];
				                            							}
				                            							else
				                            							{
				                            								$range = '< '.$test_row['upper_limit'];
				                            							}
				                            						}
				                            						else
				                            						{
				                            							if($test_row['lower_check']==1)
				                            							{
				                            								$range = '>= '.$test_row['lower_limit'];
				                            							}
				                            							else
				                            							{
																			$range = '> '.$test_row['lower_limit'];
				                            							}
				                            						}
				                            					}
				                            					echo $range.' '.$test_row['unit'];
				                            				break;
				                            				case 2: case 3:
				                            					echo $test_row['specification'];
				                            				break;
				                            				case 4:
		                            					 		echo $test_row['lower_limit'];
		                            						break;
		                            					} //end of switch
		                            					?>
		                            				</td>
		                            				<td>
	                            					<?php
		                            					if($test_row['status']==1)
		                            					{
		                            						echo "<span class='label label-success'>Pass</span>";
		                            					}
		                            					else
		                            					{
		                            						echo "<span class='label label-danger'>Fail</span>";
		                            					}
	                            					?>
	                            				</td>
		                            		</tr>
		                         <?php  }
		                    			}
		                                ?>
		                           </tbody>
		                        </table>
		                    </div>
		                    <div class="row">
		                        <div class="col-md-offset-5 col-md-4">
		                            <a class="btn blue btn-sm tooltips" data-container="body" data-placement="top" data-original-title="Print Test Results" href="<?php echo SITE_URL;?>print_oil_test_results/<?php echo @cmm_encode($test_row['lab_test_id']); ?>"><i class="fa fa-print"></i>PRINT</a>
		                            <a class="btn blue btn-sm tooltips" data-toggle="modal" data-target="#myModal" data-container="body" data-placement="top" data-original-title="View Test Results"><i class="fa fa-eye"></i>View Tests</a>
								</div>
							</div>      
                	</form>
                	<div class="modal fade" id="myModal" role="dialog">
					    <div class="modal-dialog modal-lg">
					        <!-- Modal content-->
					      	<div class="modal-content">
						        <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<span class="modal-title font-purple-soft font-md bold uppercase">LAB TEST RESULTS</span>
						        </div>
						        <div class="modal-body">
						        	<div class="table-scrollable">
			                        	<table class="table table-bordered table-striped">
			                                <tbody>
			                                	<tr class="bg-blue bg-font-blue">
			                                		<th>PO No</th>
			                                		<th>Test For</th>
			                                		<th>Test No</th>
			                                		<th>Test Date</th>
			                                		<th>Invoice No</th>
			                                		<th>Supplier</th>
			                                		<th>Broker</th>
			                                		<th>Test Status</th>
			                                	</tr>
			                                	<?php
			                                	if($results_list)
			                                	{	$j=1;
			                                		foreach ($results_list as $row) 
			                                		{ ?>
			                                			<tr>
			                                				<td><?php echo $row['po_number']?></td>
			                                				<td><?php echo $row['loose_oil']?></td>
			                                				<td><?php echo $row['test_number']?></td>
			                                				<td><?php echo $row['test_date']?></td>
			                                				<td><?php echo $row['invoice_number']?></td>
			                                				<td><?php echo $row['s_agency']?></td>
			                                				<td><?php echo $row['b_agency']?></td>
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
			                                			</tr>
			                                <?php	}
			                                
			                               		}
			                                	?>
									        </tbody>		
									    </table>
						        	</div>
						        </div>
						        <div class="modal-footer">
							        <div class="col-sm-12">
					                    <div class="form-group">
								        	<button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
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
</div>   
<?php $this->load->view('commons/main_footer', $nestedView); ?>             