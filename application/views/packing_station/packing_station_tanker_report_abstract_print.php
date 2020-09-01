<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 
</head>
<h2 align="center">A.P.CO-OP. OILSEEDS GROWER'S FEDN LTD</h2>
<h3 align="center">OIl PACKING STATION -<?php echo $packing_station_name;?> </h3>
<h4 align="center">Finished Abstract Daily Report  From <?php echo date('d-F-Y', strtotime($from_date)) ?> TO <?php echo date('d-F-Y', strtotime($to_date)) ?> </h4>
<?php
 	$total_oil_tanks=0;
 	$total_pm_tanks=0;
 	$total_fg_tanks=0;
 	$total_empty_tanks=0;
 	$total_oil_weight=0;
 	$total_pm_weight=0;
 	$total_fg_weight=0;
 	$total_empty_weight=0;
 	if(@$oil_results !='')
 	{
 		foreach($oil_results as $key=>$value)
 		{
 			if(count($value['sub_products']) !='')
 			{
 			?>	<br/>
 				<table border="1px" align="center" width="850" cellspacing="0" cellpadding="2">
				 	<tr>
				 		<td colspan="9"><b>MATERIAL NAME</b>:<?php echo $value['loose_oil_name'];?></td>
				 	</tr>
				 	<tr style="background-color:#ccc">
				 		<th>Ticket No</th>
				 		<th>Party Name</th>
				 		<th>Vehicle No</th>
				 		<th>Gross Weight</th>
				 		<th>Tare Weight</th>
				 		<th>Net Weight</th>
				 		<th>Diff Weight</th>
				 		<th>Invoice/ DC no</th>
				 		<th>Invoice Qty</th>
				 	</tr>
				 	<tbody>
				 	<?php
				 	$oil_tanker=0;
				 	$tot_weight=0;
				 	foreach($value['sub_products'] as $keys=>$values)
				 	{
				 		
				 		if(count($values)!='' && $values['gross']!='' && $values['tier']!='')
				 		{
				 			$oil_tanker+=count($values['tanker_in_number']);
				 			$total_oil_tanks+=count($values['tanker_in_number']);
				 			$tot_weight+=($values['gross']-$values['tier']);
				 			$total_oil_weight+=($values['gross']-$values['tier']);
				 			?>
				 			<tr>
				 				<td><?php echo $values['tanker_in_number'];?></td>
				 				<td><?php echo $values['party_name'];?></td>
				 				<td style="width:13%"><?php echo $values['vehicle_number'];?></td>
				 				<td align="right"><?php echo $values['gross'];?></td>
				 				<td align="right"><?php echo $values['tier'];?></td>
				 				<td align="right"><?php echo $values['gross']-$values['tier'];?></td>
				 				<td align="right"><?php echo round(($values['invoice_qty']*1000)-($values['gross']-$values['tier']),3);?></td>
				 				<td align="right"><?php echo $values['dc_number'];?></td>
				 				<td align="right"><?php echo ($values['invoice_qty']*1000);?></td>
				 			</tr><?php

				 		}
				 	}?>
				 	</tbody>
				 	<tfoot>
				 		<tr><td colspan="9" align="center"><b>Total No Of Vehicles</b>: <?php echo $oil_tanker;?><span style="margin-left:10%"><b> Total Weight</b>: <?php echo $tot_weight;?></span></td></tr>
					</tfoot>
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
				 	<tr>
				 		<td colspan="9"><b>MATERIAL NAME</b>:<?php echo $value['pm_name'];?></td>
				 	</tr>
				 	<tr style="background-color:#ccc">
				 		<th>Ticket No</th>
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
				 	$pm_tanker=0;
				 	$tot_weight=0;
				 	foreach($value['sub_products'] as $keys=>$values)
				 	{
				 		
				 		if(count($values)!='' && $values['gross']!='' && $values['tier']!='')
				 		{
				 			$pm_tanker+=count($values['tanker_in_number']);
				 			$total_pm_tanks+=count($values['tanker_in_number']);
				 			$tot_weight+=($values['gross']-$values['tier']);
				 			$total_pm_weight+=($values['gross']-$values['tier']);
				 			?>
				 			<tr>
				 				<td><?php echo $values['tanker_in_number'];?></td>
				 				<td><?php echo $values['party_name'];?></td>
				 				<td style="width:13%"><?php echo $values['vehicle_number'];?></td>
				 				<td align="right"><?php echo $values['gross'];?></td>
				 				<td align="right"><?php echo $values['tier'];?></td>
				 				<td align="right"><?php echo $values['gross']-$values['tier'];?></td>
				 				<td align="right"><?php echo round(($values['invoice_quantity']*1000)-($values['gross']-$values['tier']),3);?></td>
				 				<td align="right"><?php echo $values['dc_number'];?></td>
				 				<td align="right"><?php echo ($values['invoice_quantity']*1000);?></td>
				 			</tr><?php

				 		}
				 	}?><tr><td colspan="9" align="center"><b>Total No Of Vehicles</b>: <?php echo $pm_tanker;?><span style="margin-left:10%"><b> Total Weight</b>: <?php echo $tot_weight;?></span></td></tr>
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
				 		<td colspan="9"><b>MATERIAL NAME</b>:<?php echo $value['fg_name'];?></td>
				 	</tr>
				 	<tr style="background-color:#ccc">
				 		<th>Ticket No</th>
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
				 	$fg_tanker=0;
				 	$tot_weight=0;
				 	foreach($value['sub_products'] as $keys=>$values)
				 	{
				 		
				 		if(count($values)!='' && $values['gross']!='' && $values['tier']!='')
				 		{
				 			$fg_tanker+=count($values['tanker_in_number']);
				 			$total_fg_tanks+=count($values['tanker_in_number']);
				 			$tot_weight+=($values['gross']-$values['tier']);
				 			$total_fg_weight+=($values['gross']-$values['tier']);
				 			?>
				 			<tr>
				 				<td><?php echo $values['tanker_in_number'];?></td>
				 				<td><?php echo $values['party_name'];?></td>
				 				<td><?php echo $values['vehicle_number'];?></td>
				 				<td align="right"><?php echo $values['gross'];?></td>
				 				<td align="right"><?php echo $values['tier'];?></td>
				 				<td align="right"><?php echo $values['gross']-$values['tier'];?></td>
				 				<td align="right"><?php echo round(($values['invoice_qty']*1000)-($values['gross']-$values['tier']),3);?></td>
				 				<td align="right"><?php echo $values['dc_number'];?></td>
				 				<td align="right"><?php echo ($values['invoice_qty']*1000);?></td>
				 			</tr><?php

				 		}
				 	}?><tr><td colspan="9" align="center"><b>Total No Of Vehicles</b>: <?php echo $fg_tanker;?><span style="margin-left:10%"><b> Total Weight</b>: <?php echo $tot_weight;?></span></td></tr>
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
 				$empty_tanker=0;
				$tot_weight=0;
				foreach($value as $row)
				{
					?>
					<br/>
 					<table border="1px" align="center" width="850" cellspacing="0" cellpadding="2">
					 	<tr>
					 		<td colspan="9"><b>TANKER TYPE</b>:<?php echo $row['tanker_type'];?></td>
					 	</tr>
					 	<tr style="background-color:#ccc">
					 		<th>Ticket No</th>
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
					 			$empty_tanker+=count($row['tanker_in_number']);
					 			$total_empty_tanks+=count($row['tanker_in_number']);
					 			$tot_weight+=($row['gross']-$row['tier']);
					 			$total_empty_weight+=($row['gross']-$row['tier']);
					 			?>
					 			<tr>
					 				<td><?php echo $row['tanker_in_number'];?></td>
					 				<td><?php echo $row['agency_name'];?></td>
					 				<td><?php echo $row['vehicle_number'];?></td>
					 				<td align="right"><?php echo $row['gross'];?></td>
					 				<td align="right"><?php echo $row['tier'];?></td>
					 				<td align="right"><?php echo $row['gross']-$row['tier'];?></td>
					 				<td align="right"><?php echo round(($row['weight'])-($row['gross']-$row['tier']),3);?></td>
					 				<td align="right"><?php if($row['dc_number']!=''){ echo $row['dc_number']; } else {echo 'NONE'; }?></td>
					 				<td align="right"><?php echo ($row['weight']);?></td>
					 			</tr><?php

					 		}
					 	?><tr><td colspan="9" align="center"><b>Total No Of Vehicles</b>: <?php echo $empty_tanker;?><span style="margin-left:10%"><b> Total Weight</b>: <?php echo $tot_weight;?></span></td></tr>
					</table><?php
				}
 				
 			}
 		}
 	}
 ?>
 <br>
 <hr >
 	<p><span style="margin-left:35%;"><b>Total No Of Vehicles:&nbsp; <?php echo $total_oil_tanks+$total_pm_tanks+$total_fg_tanks+$total_empty_tanks;?></b></span><span style="margin-left:15%"><b>Total Weight:&nbsp; <?php echo $total_oil_weight+$total_pm_weight+$total_fg_weight+$total_empty_weight; ?></b></span></p>
 <hr >
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
    <a class="button print_element" href="<?php echo SITE_URL.'packing_station_tanker_abstract_view';?>">Back</a>
    </div>
    <script type="text/javascript">
        function print_srn()
        {
            window.print();
        }
    </script>

 
