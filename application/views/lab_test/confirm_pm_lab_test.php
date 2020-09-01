<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
	                <form id="test_confirmation" method="post" action="<?php echo SITE_URL.'insert_pm_lab_test';?>">
	                	<div class="table-scrollable">
                        	<table class="table table-bordered table-striped">
                                <tbody>
                                	<tr class="bg-blue" align="center">
		                                <td colspan="4" style="color:white;" valign="top"><b>TEST REPORT</b></td>
		                            </tr>
		                            <input type="hidden" name="tanker_id" value="<?php echo $tanker_id; ?>">
		                            <?php 
	                            	foreach ($pm_tests as $test_row) 
	                            	{ ?>
	                            		<tr class="bg-grey-steel">
                                            <th> Test Name </th>
                                            <th> Value Obtained </th>
                                            <th> Permissible Range </th>
		                            		<th> Test Status </th>
                                        </tr>
                            			<tr>
                            				<td> <?php echo $test_row['test_name']?></td>
                                            <td> 
                                                <div class="form-group">
                                                    <?php
                                                    switch($test_row['range_type_id'])
			                            			{
			                            				case 1: case 4:
			                            				?>
			                            				
	                            						<?php
	                            							echo $pm_test_results[$test_row['test_id']]['result'];
	                            						break;
	                            						case 2: case 3:
	                            						?>
			                            				
	                            						<?php
		                            						echo get_pm_test_option_value_by_key($pm_test_results[$test_row['test_id']]['result'],$test_row['test_id']);
	                            						break;
	                            					} //end of switch
                                                    ?>
                                                    <input type="hidden" name="test_result[<?php echo $test_row['test_id'] ?>]" value="<?php echo $pm_test_results[$test_row['test_id']]['result']; ?>">
                                                </div>
                                            </td>
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
                            					if($pm_test_results[$test_row['test_id']]['test_status']==1)
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
                                    <?php } //end of test rows?>
                                </tbody>
                                <tfoot>
                                	<tr><td colspan="4">Lab Test Result: 
                                	<?php 	if($overall_test_status==1)
		                                	{ 
		                                		echo "<span class='label label-success'>Pass</span>";
		                                	} 
		                                	else
		                                	{ 
		                                		echo "<span class='label label-danger'>Fail</span>";
		                                	} ?>
                                	</td></tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row">
	                        <div class="col-md-offset-5 col-md-4">
	                            <input type="submit" name="submit" id="submit_pm_test" onclick="return confirm('Are you sure you want to Submit Lab Test Details?')"  class="btn blue" title="Confirm Test" value="submit">
	                            <a href="<?php echo SITE_URL.'pm_lab_test_detail';?>" class="btn default" title="Back To Previous Page"><i class="fa fa-chevron-left"></i>Back</a>
	                        </div>
	                    </div>      
	                </form>
                </div>
            </div>
        </div>
    </div>
</div>   
<?php $this->load->view('commons/main_footer', $nestedView); ?>             