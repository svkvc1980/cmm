<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 
</head>
<h2 align="center">A.P.CO-OP. OILSEEDS GROWER'S FEDN LTD</h2>
<h3 align="center">OIl PACKING STATION -<?php echo $packing_station_name;?> </h3>
<h4 align="center">Finished Detailed Daily Report  From <?php echo date('d-F-Y', strtotime($from_date)) ?> TO <?php echo date('d-F-Y', strtotime($to_date)) ?> </h4>
<?php
 	if(@$oil_results !='')
 	{
 		foreach($oil_results as $key=>$value)
 		{
 			if(count($value['sub_products']) !='')
 			{
 			?>	<br/>
 				<table border="1px" align="center" width="850" cellspacing="0" cellpadding="2">
				 	<tr>
				 		<td colspan="11"><b>MATERIAL NAME</b>:<?php echo $value['loose_oil_name'];?></td>
				 	</tr>
				 	<tr style="background-color:#ccc">
				 		<th>Ticket No</th>
				 		<th>In Time</th>
				 		<th>Out Time</th>
				 		<th>Party Name</th>
				 		<th>Vehicle No</th>
				 		<th>Gross Weight</th>
				 		<th>Tare Weight</th>
				 		<th>Net Weight</th>
				 		<th>Diff Weight</th>
				 		<th>Invoice/ DC no</th>
				 		<th>Invoice Qty</th>
				 	</tr>
				 	<?php
				 	$tanker_list=0;
				 	$tot_weight=0;
				 	foreach($value['sub_products'] as $keys=>$values)
				 	{
				 		
				 		if(count($values)!='' && $values['gross']!='' && $values['tier']!='')
				 		{
				 			$tanker_list+=count($values['tanker_in_number']);
				 			$tot_weight+=($values['gross']-$values['tier']);
				 			?>
				 			<tr>
				 				<td><?php echo $values['tanker_in_number'];?></td>
				 				<td style="width:13%"><?php echo date('d-m-Y H:i:s', strtotime($values['in_time']));?></td>
				 				<td style="width:13%"><?php echo date('d-m-Y H:i:s', strtotime($values['out_time']));?></td>
				 				<td><?php echo $values['party_name'];?></td>
				 				<td style="width:13%" align="center"><?php echo $values['vehicle_number'];?></td>
				 				<td align="right"><?php echo $values['gross'];?></td>
				 				<td align="right"><?php echo $values['tier'];?></td>
				 				<td align="right"><?php echo $values['gross']-$values['tier'];?></td>
				 				<td align="right"><?php echo round(($values['invoice_qty']*1000)-($values['gross']-$values['tier']),3);?></td>
				 				<td align="right"><?php echo $values['dc_number'];?></td>
				 				<td align="right"><?php echo ($values['invoice_qty']*1000);?></td>
				 			</tr><?php

				 		}
				 	}?><tr><td colspan="11" align="center"><b>Total No Of Vehicles</b>: <?php echo $tanker_list;?><span style="margin-left:10%"><b> Total Weight</b>: <?php echo $tot_weight;?></span></td></tr>
				</table><?php
 			}
 		}
 	}
 ?>
 <?php
 	if(@$pm_results !='')
 	{
 		foreach(@$pm_results as $key=>$value)
 		{
 			if(count($value['sub_products']) !='')
 			{
 			?>	<br/>
 				
	 			<table border="1px" align="center" width="850" cellspacing="0" cellpadding="2">
				 	<tr >
				 		<td colspan="11" align="left"><b>MATERIAL NAME</b>:<?php echo $value['pm_name'];?></td>
				 	</tr>
				 	<tr style="background-color:#ccc">
				 		<th>Ticket No</th>
				 		<th>In Time</th>
				 		<th>Out Time</th>
				 		<th>Party Name</th>
				 		<th>Vehicle No</th>
				 		<th>Gross Weight</th>
				 		<th>Tare Weight</th>
				 		<th>Net Weight</th>
				 		<th>Diff Weight</th>
				 		<th>Invoice/ DC no</th>
				 		<th>Invoice Qty</th>
				 	</tr>
				 	<?php
				 	$tanker_list=0;
				 	$tot_weight=0;
				 	foreach($value['sub_products'] as $keys=>$values)
				 	{
				 		
				 		if(count($values)!='' && $values['gross']!='' && $values['tier']!='')
				 		{
				 			$tanker_list+=count($values['tanker_in_number']);
				 			$tot_weight+=($values['gross']-$values['tier']);
				 			?>
				 			<tr>
				 				<td><?php echo $values['tanker_in_number'];?></td>
				 				<td style="width:13%"><?php echo date('d-m-Y H:i:s', strtotime($values['in_time']));?></td>
				 				<td style="width:13%"><?php echo date('d-m-Y H:i:s', strtotime($values['out_time']));?></td>
				 				<td><?php echo $values['party_name'];?></td>
				 				<td style="width:13%" align="center"><?php echo $values['vehicle_number'];?></td>
				 				<td align="right"><?php echo $values['gross'];?></td>
				 				<td align="right"><?php echo $values['tier'];?></td>
				 				<td align="right"><?php echo $values['gross']-$values['tier'];?></td>
				 				<td align="right"><?php echo round(($values['invoice_quantity']*1000)-($values['gross']-$values['tier']),3);?></td>
				 				<td align="right"><?php echo $values['dc_number'];?></td>
				 				<td align="right"><?php echo ($values['invoice_quantity']*1000);?></td>
				 			</tr><?php

				 		}
				 	}?><tr><td colspan="11" align="center"><b>Total No Of Vehicles</b>: <?php echo $tanker_list;?><span style="margin-left:10%"><b> Total Weight</b>: <?php echo $tot_weight;?></span></td></tr>
				</table><?php
 			}
 		}
 	}
 ?>
 <?php
 	if(@$fg_results !='')
 	{
 		foreach($fg_results as $key=>$value)
 		{
 			if(count($value['sub_products']) !='')
 			{
 			?>	<br/>
 				<table border="1px" align="center" width="850" cellspacing="0" cellpadding="2">
				 	<tr>
				 		<td colspan="11"><b>MATERIAL NAME</b>:<?php echo $value['fg_name'];?></td>
				 	</tr>
				 	<tr style="background-color:#ccc">
				 		<th>Ticket No</th>
				 		<th>In Time</th>
				 		<th>Out Time</th>
				 		<th>Party Name</th>
				 		<th>Vehicle No</th>
				 		<th>Gross Weight</th>
				 		<th>Tare Weight</th>
				 		<th>Net Weight</th>
				 		<th>Diff Weight</th>
				 		<th>Invoice/ DC no</th>
				 		<th>Invoice Qty</th>
				 	</tr>
				 	<?php
				 	$tanker_list=0;
				 	$tot_weight=0;
				 	foreach($value['sub_products'] as $keys=>$values)
				 	{
				 		
				 		if(count($values)!='' && $values['gross']!='' && $values['tier']!='')
				 		{
				 			$tanker_list+=count($values['tanker_in_number']);
				 			$tot_weight+=($values['gross']-$values['tier']);
				 			?>
				 			<tr>
				 				<td><?php echo $values['tanker_in_number'];?></td>
				 				<td style="width:13%"><?php echo date('d-m-Y H:i:s', strtotime($values['in_time']));?></td>
				 				<td style="width:13%"><?php echo date('d-m-Y H:i:s', strtotime($values['out_time']));?></td>
				 				<td><?php echo $values['party_name'];?></td>
				 				<td style="width:13%" align="center"><?php echo $values['vehicle_number'];?></td>
				 				<td align="right"><?php echo $values['gross'];?></td>
				 				<td align="right"><?php echo $values['tier'];?></td>
				 				<td align="right"><?php echo $values['gross']-$values['tier'];?></td>
				 				<td align="right"><?php echo round(($values['invoice_qty']*1000)-($values['gross']-$values['tier']),3);?></td>
				 				<td align="right"><?php echo $values['dc_number'];?></td>
				 				<td align="right"><?php echo ($values['invoice_qty']*1000);?></td>
				 			</tr><?php

				 		}
				 	}?><tr><td colspan="11" align="center"><b>Total No Of Vehicles</b>: <?php echo $tanker_list;?><span style="margin-left:10%"><b> Total Weight</b>: <?php echo $tot_weight;?></span></td></tr>
				</table><?php
 			}
 		}
 	}
 ?>
 <?php
 	if(@$invoice_details !='')
 	{
 		foreach($invoice_details as $key=>$value)
 		{
 			    if(count($value) !='')
	 			{ 
	 				$tanker_list=0;
	 				$tot_weight=0;
	 				foreach($value as $row)
	 				{ //echo "<pre>"; print_r($value); exit;
	 				?>
	 					<br/>
 						<table border="1px" align="center" width="850" cellspacing="0" cellpadding="2">
						 	<tr>
						 		<td colspan="11"><b>Tanker_type</b>:<?php echo $row['tanker_type'];?></td>
						 	</tr>
						 	<tr style="background-color:#ccc">
						 		<th>Ticket No</th>
						 		<th>In Time</th>
						 		<th>Out Time</th>
						 		<th>Party Name</th>
						 		<th>Vehicle No</th>
						 		<th>Gross Weight</th>
						 		<th>Tare Weight</th>
						 		<th>Net Weight</th>
						 		<th>Diff Weight</th>
						 		<th>Invoice/ DC no</th>
						 		<th>Invoice Qty</th>
						 	</tr>
						 	<?php
						 	if(count($row)!='' && $row['gross']!='' && $row['tier']!='')
					 		{
					 			$tanker_list+=count($row['tanker_in_number']);
					 			$tot_weight+=($row['gross']-$row['tier']);
					 			?>
					 			<tr>
					 				<td><?php echo $row['tanker_in_number'];?></td>
					 				<td style="width:13%"><?php echo date('d-m-Y H:i:s', strtotime($row['in_time']));?></td>
					 				<td style="width:13%"><?php echo date('d-m-Y H:i:s', strtotime($row['out_time']));?></td>
					 				<td><?php echo $row['agency_name']?></td>
					 				<td style="width:13%" align="center"><?php echo $row['vehicle_number'];?></td>
					 				<td align="right"><?php echo $row['gross'];?></td>
					 				<td align="right"><?php echo $row['tier'];?></td>
					 				<td align="right"><?php echo $row['gross']-$row['tier'];?></td>
					 				<td align="right"><?php echo round(($row['weight'])-($row['gross']-$row['tier']),3);?></td>
					 				<td align="right"><?php if($row['dc_number']!=''){ echo $row['dc_number']; } else {echo 'NONE'; }?></td>
					 				<td align="right"><?php echo ($row['weight']*1000);?></td>
					 			</tr><?php

					 		}
						 	?><tr><td colspan="11" align="center"><b>Total No Of Vehicles</b>:<?php echo $tanker_list;?> <span style="margin-left:10%"><b> Total Weight</b>: <?php echo $tot_weight;?></span></td></tr>
						</table><?php
	 				}
	 			}
 			
 			
 			
 		}
 	}
 	?>
<br><br><br><br><br><br><br>
    <table style="border:none !important" align="center" width="750">
        <tr style="border:none !important">
        <td style="border:none !important">
        
        <span style="margin-left:550px;">Authorised Signature</span>
        </td>
        </tr>
    </table>
<div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'packing_station_tanker_view';?>">Back</a>
</div>
<script type="text/javascript">
    function print_srn()
    {
        window.print();
    }
</script>

 
