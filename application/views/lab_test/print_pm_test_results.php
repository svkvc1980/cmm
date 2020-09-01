<!DOCTYPE html>
<html>
<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 
</head>
<style type="text/css">
    table tr td{
        height: 20px !important;
    }
</style>
<body class="image">
<h2 align="center">AP Cooperative Oilseeds Growers Federation Ltd</h2>
<h3 align="center">PM Test Report   date On : <?php echo date('d-m-Y',strtotime($test_date)); ?><span style="margin-left: 50px;">Unit : <?php echo get_plant_name_by_id($plant_idd); ?></span></h3>
<table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
    <tbody>
        <tr>
            <td colspan="4" style="background-color:#cccfff" align="center"><b><?php echo $results_list[0]['packing_material'] ?> ANALYSIS REPORT</b></td>
        </tr>
        <tr>
            <th>Test Number</th>
            <td><?php echo $test_number; ?></td> 
            <th>Test Date</th>
            <td><?php echo date('d-m-Y',strtotime($test_date)); ?></td>   
        </tr>
        <tr>
            <th>Name of the Supplier</th>
            <td><?php echo $results_list[0]['s_agency'] ?></td>
            <th>Vehicle No</th>
            <td> <?php echo $results_list[0]['vehicle_number'] ?></td>
        </tr>
        <tr>
            <th>Purchase Order Number</th>
            <td><?php echo $results_list[0]['po_number'] ?></td>
            <th>Invoice Number</th>
            <td><?php echo $results_list[0]['invoice_number'] ?></td>
        </tr>
        <tr>
            <th>Date Of Reciept</th>
            <td><?php echo date('d-m-Y',strtotime($test_date)); ?></td>
            <th>Date Of Unloading/Rejection</th>
            <td><?php echo date('d-m-Y',strtotime($test_date)); ?></td>
        </tr>
        <tr>
            <th>Rate</th>
            <td><?php echo $results_list[0]['unit_price'] ?></td>
            <td></td>
            <td></td>
        </tr>
    </tbody>
</table><br><br><br>
<table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
<tbody>
	<tr style="background-color:#cccfff">
        <td colspan="4" align="center"><b>TEST RESULTS</b></td>
    </tr>
    <tr style="background-color:#cccfff">
        <th> Test Name </th>                                                
        <th> Value Obtained </th>
        <th> Permissible Range </th>
        <th> Test Status </th>
    </tr>
    <?php
    	foreach ($test_results as $test_row) 
    	{ ?>
    		
    		<tr>
    			<td> <?php echo $test_row['packing_material_test'];  ?></td>
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
    						echo get_pm_test_option_value_by_key($test_row['value'],$test_row['test_id']);
						break;
					} //end of switch
					?>
					<input type="hidden" name="test_result[<?php echo $test_row['test_id'] ?>]" value="<?php echo $test_row['value']; ?>">
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
 <?php  
		}
        ?>
    </tbody>
</table>
<br><br><br><br><br><br><br><br>
    
        <table style="border:none !important" align="center" width="750">
            <tr style="border:none !important">
            <td style="border:none !important">
            <span style="margin-left:80px;">Q.C. Officer</span>
            <span style="margin-left:150px;">Dy.Manager(Q.C.)</span>
            <span style="margin-left:150px;">Manager(Tech)</span>
            </td>
            </tr>
        </table><br>
    <div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'pm_test_r';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>