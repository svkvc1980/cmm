<!DOCTYPE html>
<html>
<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
</head>

<body>
<h2 align="center">A.P.CO-OPERATIVE OIL SEEDS GROWER'S FEDERATION LIMITED</h2>
 <h3 align="center">Gate Pass <span style="margin-left:50px;">Unit :  <?php echo $this->session->userdata('plant_name') ;?></span></h3>
<br>
<table align="center" style="border:none !important;" width="700">
  <tr style="border:none !important;">
      <td style="border:none !important;"><b>GatePass Number </b><?php echo $details['gatepass_number']; ?></td>
      <td style="border:none !important;"><b> Vehicle Number </b><?php echo $details['vehicle_number']; ?></td>
      <td style="border:none !important;"><b> Date </b><?php echo format_date($details['on_date']); ?> </td>
  </tr>
</table>
<br>
<table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
<!-- <tr>
<td colspan='4' align="center"><b>REFINED <?php echo $mrr_results['loose_oil_name']?> MRR</b></td>
</tr> -->
<tr style="background-color:#cccfff">
	<th rowspan="2">Sno</th>
	<th rowspan="2" >Invoice Number</th>
  <th rowspan="2"> Waybill Number</th>
  <th rowspan="2">Name[code][town]</th>
	<th rowspan="2" >product</th>
	<th colspan="3" align="center">Quantity</th>
</tr>
<tr style="background-color:#cccfff">
	<th>CB's</th>
	<th>Sachets</th>
	<th>Weight</th>
</tr>
<?php 
	$sno=1;
  $total_weight=0;
  if(count($gatepass_results) > 0)
  { 
   foreach($gatepass_results as $key =>$value) {
    $j=1;
   	  foreach ($value['products'] as $keys => $values) { 
       $total_weight +=$values['weight']; ?>
      
   <tr>
   		<td align="center"><?php echo  $sno++; ?></td>
   		  <?php
        if($j==1)
        {
        ?>
  			<td align="left"  valign="top" rowspan="<?php echo count($value['products']);?>"><?php echo  $values['invoice_number']; ?></td>
        <td align="left" valign="top"  rowspan="<?php echo count($value['products']);?>"><?php echo  $value['waybill_number']; ?></td>
        <td align="left" valign="top" rowspan="<?php echo count($value['products']);?>"><?php echo  get_distributor_based_invoice($values['invoice_id']); ?></td>
        <?php
          }
        ?>
  		  <td align="center"><?php echo  $values['product_name']; ?></td>
  			<td align="right"><?php echo $values['cbs']; ?></td>	
  			<td align="right"><?php echo  round($values['sachets']); ?></td>	
  			<td align="right"><?php echo  qty_format($values['weight']); ?></td>	
  		
   </tr>
	   
 	<?php $j++; } } } else { ?>
    <tr>
        <td colspan="5">No records found</td>
    </tr>
    <?php } ?>
    <tr>
 <td style="text-align:right;" colspan="8"><b>Total Weight:  <?php echo qty_format($total_weight); ?></b></td>	
 </tr>
</table>


</br>
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
    <span style="margin-left:300px;">Manager</span>
    </td>
</tr>
</table>
<br>
<div class="row" style="text-align:center">
    <button class="button print_element" style="background-color:#3598dc"  onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'gate_pass_list';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
    function print_srn()
    {
        window.print();
    }
</script>

  

    

