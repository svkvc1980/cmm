<!DOCTYPE html>
<html>
<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 
</head>
<body>
<h2 align="center">AP Cooperative Oilseeds Grower's Federation Ltd</h2>
<h4 align="center">Production Particulars From &nbsp;<?php echo date('d-m-Y',strtotime($start_date));?> &nbsp;To&nbsp; <?php echo date('d-m-Y',strtotime($end_date));?></h4>
<h4 align="center"><?php if(@$loose_oil_name!=''){ echo 'Oil Type : '.$loose_oil_name; } ?><span style="margin-left:50px;"><?php echo $this->session->userdata('plant_name'); ?></span></h4>
<table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
	<tr>
		<th>S.NO</th>
		<th>Date</th>
		<th>Product</th>
		<th>No of Cartons</th>
		<th>No of Packs</th>
		<th>Qty in Kgs</th> 
	</tr>
	<tr>
		<?php   
		if(count($production)>0)
        {  
        	$sn=1;
        	$total_cartons=0;
        	$total_packs=0;
        	$total_qty=0; $datewise_tot_cartons = $datewise_tot_packs = $datewise_tot_weight = array();
        	$cur_date = '';
			foreach($production as $row)
	        {
	        	$datewise_tot_cartons[$row['production_date']][] = $row['quantity'];
	        	$datewise_tot_packs[$row['production_date']][] = $row['quantity']*$row['items_per_carton'];
	        	$datewise_tot_weight[$row['production_date']][] = $row['quantity']*$row['items_per_carton']* $row['oil_weight'];
	        	if(($sn>1&&$cur_date!=$row['production_date']))
            	{
            		?>
            		<tr>
            			<th colspan="3" align="right">Total</th>
            			<th align="right"><?php echo array_sum($datewise_tot_cartons[$cur_date])?></th>
            			<th align="right"><?php echo array_sum($datewise_tot_packs[$cur_date])?></th>
            			<th align="right"><?php echo qty_format(array_sum($datewise_tot_weight[$cur_date]))?></th>
            		</tr>
            		<?php
            	}
	        	?>
	            <tr>
	            	<td width="5%"> <?php echo $sn++;?> </td>
	                <td width="10%"> <?php echo date('d-m-Y',strtotime($row['production_date']));?> </td>
	                <td width="20%"> <?php echo $row['product_name'];?> </td>
	                <td width="10%" align="right"> <?php echo $row['quantity'];?> </td>
	                <td width="10%" align="right"> <?php echo $row['items_per_carton']*$row['quantity'];?> </td>
	                <td width="10%" align="right"> <?php echo qty_format(($row['items_per_carton']*$row['quantity'])*$row['oil_weight']);?> </td>
	            </tr>
            <?php
            	if(count($production)==($sn-1))
            	{
            		?>
            		<tr>
            			<th colspan="3" align="right">Total</th>
            			<th align="right"><?php echo array_sum($datewise_tot_cartons[$cur_date])?></th>
            			<th align="right"><?php echo array_sum($datewise_tot_packs[$cur_date])?></th>
            			<th align="right"><?php echo qty_format(array_sum($datewise_tot_weight[$cur_date]))?></th>
            		</tr>
            		<?php
            	}
	            $total_cartons+=$row['quantity'];
	            $total_packs+=$row['items_per_carton']*$row['quantity'];
	            $total_qty+=($row['items_per_carton']*$row['quantity'])* $row['oil_weight'];
	            $cur_date = $row['production_date'];
	        }?>
	        <tr>
	        	<td colspan="3" align="right"><b>Grand Total</b></td>
	        	<th align="right"><?php echo $total_cartons;?> </th>
	        	<th align="right"><?php echo $total_packs;?> </th>
	        	<th align="right"><?php echo qty_format($total_qty);?> </th>
	        </tr>
	    <?php }
        else 
        {
        ?>  
            <tr><td colspan="7" align="center"><span class="label label-primary">No Records</span></td></tr>
        <?php   
        } ?>
	</tr>
</table>
<br><br><br><br><br><br>
    
<table style="border:none !important" align="center" width="750">
    <tr style="border:none !important">
    <td style="border:none !important">
    
    <span style="margin-left:550px;">Authorised Signature</span>
    </td>
    </tr>
</table>
<div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <input type="hidden" name="start_date" value="<?php echo date('d-m-Y',strtotime($start_date));?>">
	<input type="hidden" name="end_date" value="<?php echo date('d-m-Y',strtotime($end_date))?>">
    <a class="button print_element" href="<?php echo SITE_URL.'production_report';?>">Back</a>
    </div>
<script type="text/javascript">
    function print_srn()
    {
        window.print(); 
    }
</script>
<style>
	@media print {
	 .print_element{display:none;}
	}
 
</style>