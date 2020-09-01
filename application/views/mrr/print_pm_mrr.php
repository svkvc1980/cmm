<!DOCTYPE html>
<html>
<head>
    <title>MRR PM Print</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 
</head>
<style type="text/css">
    table tr td{
        height: 20px !important;
        font-size: 12px;
    }
</style>
<body>
<h2 align="center">A.P.CO-OPERATIVE OIL SEEDS GROWER'S FEDERATION LIMITED</h2>
<h3 align="center">Material Received Report(MRR) For Packing Material <span style="margin-left:50px;"><?php echo 'Dated : '.format_date(date('Y-m-d')); ?></span> </h3>
<br>
 <?php
/*    if($mrr_results['pm_category_id']==get_film_cat_id())
    {
        $units='Kgs';
    } 
    elseif($mrr_results['pm_id']==get_tape_650mt() || $mrr_results['pm_id']==get_tape_65mt())
    {
        $units='units';
    }
    else
    {
        $units='units';
    }*/
    //echo '<pre>';print_r($mrr_results);
    // Get packing material unit name (Ex:Kg, Mtrs, Units)
    $units = get_pm_unit($mrr_results['pm_id']);
    ?>
<table style="border:none !important" align="center" width="750">
            <tr style="border:none !important">
            <td style="border:none !important">
            
            <span style="margin-left:200px;"><b>Packing Material : </b> <?php echo $mrr_results['pm_name']?></span>
            </td>
            </tr>
        </table>
 <br>
<table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
	<tbody>
	 	<!-- <tr>
	 		<td colspan="4" align="center"><b><?php echo $mrr_results['pm_name']?> MRR</b></td>
	 	</tr> -->
	 	<tr>
	 		<th colspan="1" align="left">MRR Number / Date</th>
	 		<td colspan="1"><?php echo $mrr_results['mrr_number'].' / '.format_date(@$mrr_results['mrr_date']); ?></td>
	 		<th colspan="1" align="left">Invoice / DC No</th>
	 		<td><?php 

        if($mrr_results['invoice_number']!='' && $mrr_results['dc_number']!='' && strtolower($mrr_results['invoice_number'])!='none' && strtolower($mrr_results['dc_number'])!='none')
        {
            echo  $mrr_results['invoice_number'].'/'.$mrr_results['dc_number'];
        }
        else
        {
           echo ($mrr_results['invoice_number']!=''&&strtolower($mrr_results['invoice_number'])!='none')?$mrr_results['invoice_number']:$mrr_results['dc_number'];
        }
         ?></td>
	 	</tr>
	 	<tr>
	 		<th colspan="1" align="left">Ledger Number</th>
	 		<td colspan="1"><?php echo  $mrr_results['ledger_number']; ?></td>
	 		<th colspan="1" align="left">Folio Number</th>
	 		<td colspan="1"><?php echo $mrr_results['folio_number'];?></td>
	 	</tr>
	 	<tr>
	 		<th colspan="1" align="left">PO Number / Date</th>
	 		<td colspan="1"><?php echo  $mrr_results['po_number'].' / '.format_date($mrr_results['po_date']) ;?></td>
	 		<th colspan="1" align="left">Purchase Mode</th>
            <td colspan="1"><?php echo  $mrr_results['purchase_type']; ?></td>
	 	</tr>
	 	<tr>
	 		<th colspan="1" align="left">PO Quantity (<?php echo $units;?>)</th>
	 		<td colspan="1" align="right"><?php echo  round(@$mrr_results['pp_quantity'],2); ?></td>
            <th colspan="1" align="left">Vehicle Number / Vehicle In No</th>
            <td colspan="1"><?php echo  $mrr_results['vehicle_number'].' / '.$mrr_results['tanker_number']; ?></td>
	 	</tr>
	 	<tr>
	 		<th colspan="1" align="left">Gross Weight (Kgs)</th>
	 		<td colspan="1" align="right"><?php echo  round($mrr_results['gross_weight'],3); ?></td>
	 		<th colspan="1" align="left">Tare Weight (Kgs)</th>
	 		<td colspan="1" align="right"><?php echo  round($mrr_results['tier_weight'],3); ?></td>
	 	</tr>
        <tr>
            
            <th colspan="1" align="left">Net Weight (Kgs)</th>
            <td colspan="1" align="right"><?php echo  round($mrr_results['net_weight'],3); ?></td>
            <th colspan="1" align="left">Supplier</th>
            <td colspan="1"><?php echo  $mrr_results['supplier_name'];?></td>
            
        </tr>
	 	</tbody>
	 	</table>
	<br>
	<table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
	<thead>
     	<tr style="background-color:#cccfff">
     		<th> S.No </th>
            <th> Description </th>
            <th> DC Qty </th>
            <th> Qty Received </th>
            <th> Excess/Shortage (Qty)</th>
     	</tr>
    </thead>
	 	<tr>
            <?php
            $received_qty = ($mrr_received_qty/$meters);
            $diff_qty = $received_qty - $mrr_results['invoice_quantity'];
            ?>
	 		<td align="left">1</td>
	 		<td align="left"><?php echo $mrr_results['pm_name'] .' ('.$units.')'; ?></td>
	 		<td align="right"><?php echo  round($mrr_results['invoice_quantity'],2); ?></td>
	 		<td align="right"><?php echo  $received_qty; ?></td>
            <td align="right">
                <?php
                $sign_lable = ($diff_qty<0)?'-':'+';
                if($diff_qty==0) $sign_lable = '';
                echo $sign_lable.abs($diff_qty);
                ?>
            </td>
	 		<!-- <th colspan="1" align="left">Unit Price</th>
	 		<td colspan="1"><?php echo  $mrr_results['unit_price']; ?></td> -->
	 	</tr>
	 </table>
	 <br>
	  <table border="1px" align="center" width="450" cellspacing="0" cellpadding="2">
    <tbody>
    <tr>
    	<td colspan="2" align="left"><b>Unit :</b></td>
	 	<td align="right"><?php echo  $mrr_results['plant_name']; ?></td>
    </tr>
    <tr>
        <td colspan="2" align="left"><b>Unit Price :</b></td>
        <td align="right" ><?php echo  $mrr_results['unit_price']; ?></td>
    </tr>
    <tr><?php 
        
        $payable_amount=($mrr_results['unit_price']* ($mrr_received_qty/$meters)) ?>
        <td colspan="2" align="left"><b>Total Amount :</b></td>
        <td align="right"><?php echo price_format($mrr_results['unit_price']* ($mrr_received_qty/$meters)); ?></td>
    </tr>
    
    <tr>
        <td colspan="2" align="left"><b>Payable Amount :</b></td>
        <td align="right"><?php echo  price_format($payable_amount); ?></td>   
    </tr>
     <tr>
        <td colspan="2" align="left"><b>Remarks :</b></td>
        <td ><?php echo  $mrr_results['remarks']; ?></td>   
    </tr>
  
   </tbody>
</table> 
	 <br> 
 <br></br>
</br>
</br></br>
</br>
</br>
<br>
<br>

<table width="750" align="center" style="border:none !important;" >
<tr style="border:none !important;">
    <td style="text-align:center; border:none !important;">
    <span >Verified by </span>
    <span style="margin-left:300px;">Owner Signature</span>
    </td>
</tr>
</table>
<br>
<br>
<br>
<br></br>
</br>

<table width="750" style="border:none !important;" align="center">
    <tr style="border:none !important;">
    <td style="text-align:center; border:none !important;">
    <span >Supervisor </span>
    <span style="margin-left:300px;">Manager Incharge</span>
    </td>
</tr>
</table>
<br>
<div class="row" style="text-align:center">
    <button class="button print_element" style="background-color:#3598dc"  onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'mrr_pm_list';?>">Back</a>
    </div>
</body>
</html> 
<script type="text/javascript">
    function print_srn()
    {
        window.print();
    }
</script>