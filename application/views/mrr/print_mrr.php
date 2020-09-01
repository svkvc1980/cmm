<!DOCTYPE html>
<html>
<head>
    <title>MRR Oils Print</title>
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
<h3 align="center">Material Received Report(MRR) For Oils<span style="margin-left:50px"><?php echo 'Dated : '.format_date(date('Y-m-d')); ?></span></h3>

<?php //echo '<pre>'; print_r($mrr_results);?>
<table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
<tr>
<td><b>MRR Number / Date</b></td>
<td><?php echo  $mrr_results['mrr_number'].' / '.format_date($mrr_results['mrr_date']); ?></td>
<td><b>Supplier Invoice/DC No</b></td>
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
<td><b>PO Number / Date</b></td>
<td><?php echo  $mrr_results['po_number'].' / '.format_date($mrr_results['po_date']); ?></td>
<td><b>Lab Report No / Date</b></td>
<td><?php echo  $mrr_results['test_number'].' / '.format_date($mrr_results['test_date']); ?></td>
</tr>

<tr>
<td><b>Broker Name</b></td>
<td><?php echo  $mrr_results['broker_name']; ?></td>
<td><b>Supplier Name</b> </td>
<td><?php echo  $mrr_results['supplier_name']; ?></td>
</tr>
<tr>
<td><b>PO Quantity(MT)</b></td>
<td align="right"><?php echo  $mrr_results['po_quantity']; ?></td>

<td><b>Vehicle Number / Tanker In No</b> </td>
<td><?php echo  $mrr_results['vehicle_number'].' / '.$mrr_results['tanker_number']; ?></td>
</tr>



</table>
<br><br>
<table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
    <thead>
     	<tr style="background-color:#cccfff">
     		<th> S.No </th>
            <th> Description </th>
            <th> DC Qty (MT)</th>
            <th> Qty Received  (MT)</th>
            <th> Excess/Shortage Qty (MT)</th>
     	</tr>
    </thead>
    <tbody>
     	<tr>
            <?php
            $inv_weight = max($mrr_results['invoice_net_weight'],$mrr_results['invoice_qty']);
            $diff_qty = ($mrr_results['net_weight'])-($inv_weight);
            $sign_lable = ($diff_qty<0)?'-':'+';
            if($diff_qty==0) $sign_lable = '';
            
            ?>
     		<td align="left">1</td>
     		<td align="left"><?php echo $mrr_results['loose_oil_name']; ?></td>
     		<td align="right"><?php echo qty_format(max($mrr_results['invoice_net_weight'],$mrr_results['invoice_qty'])); ?></td>
            <td align="right"><?php echo qty_format($mrr_results['net_weight']); ?></td>
            <td align="right"><?php echo $sign_lable.qty_format(abs($diff_qty)); ?>
            </td>
     	</tr>
    </tbody>
</table>
<br>
<br>
 <table border="1px" align="center" width="450" cellspacing="0" cellpadding="2">
    <tbody>
<?php
if($mrr_results['loose_oil_id']==gn_loose_oil_id())
 { ?>
    <tr>
        <td colspan="2" align="left"><b>Unit Price :</b></td>
        <td align="right"><?php echo  $mrr_results['unit_price']; ?></td>
    </tr>
    <tr><?php 
         $rebate=($total_rebate*$mrr_results['unit_price']* $mrr_results['net_weight'])/100;
         $payable_amount=($mrr_results['unit_price']* $mrr_results['net_weight'])-$rebate; ?>
        <td colspan="2" align="left"><b>Total Amount :</b></td>
        <td align="right"><?php echo price_format($mrr_results['unit_price']* $mrr_results['net_weight']); ?></td>
    </tr>
    <tr>
        <td colspan="2" align="left"><b>FFA :</b></td>
        <td align="right" ><?php echo  $ffa_value; ?></td>
    </tr>
    <tr>
       <td colspan="2" align="left"><b>Rebate :</b></td>
       <td align="right" ><?php echo qty_format($rebate); ?></td>
    </tr>
    <tr>
       <td colspan="2" align="left"><b>Payable Amount :</b></td>
       <td align="right" ><?php echo  price_format($payable_amount); ?></td>   
    </tr>
    <tr>
        <td colspan="2" align="left"><b>Remarks :</b></td>
        <td ><?php echo  $mrr_results['remarks']; ?></td>   
    </tr>
   <?php } else { ?>
   <tr>
        <td colspan="2" align="left"><b>Unit Price :</b></td>
        <td align="right" ><?php echo  $mrr_results['unit_price']; ?></td>
    </tr>
    <tr><?php 
        $rebate=0;
        $payable_amount=($mrr_results['unit_price']* $mrr_results['net_weight'])-$rebate; ?>
        <td colspan="2" align="left"><b>Total Amount :</b></td>
        <td align="right"><?php echo price_format($mrr_results['unit_price']* $mrr_results['net_weight']); ?></td>
    </tr>
    <tr>
        <td colspan="2" align="left"><b>Rebate (if any):</b></td>
        <td align="right"><?php echo '0'; ?></td>
    </tr>
    <tr>
        <td colspan="2" align="left"><b>Payable Amount :</b></td>
        <td align="right"><?php echo  price_format($payable_amount); ?></td>   
    </tr>
     <tr>
        <td colspan="2" align="left"><b>Remarks :</b></td>
        <td ><?php echo  $mrr_results['remarks']; ?></td>   
    </tr>
   <?php } ?>
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
    <a class="button print_element" href="<?php echo SITE_URL.'mrr_loose_oil_list';?>">Back</a>
    </div>
</body>
</html> 
<script type="text/javascript">
    function print_srn()
    {
        window.print();
    }
</script>
