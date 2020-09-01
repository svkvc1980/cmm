<br>
<h1 align="center">A.P.CO-OPERATIVE OIL SEEDS GROWER'S FEDERATION LIMITED</h1>
 <h3 align="center">Oil Packing Station <?php echo $this->session->userdata('sess_plant_id') ;?></h3>
<h2 align="center">Gate Pass</h2>
<br>
<p><b>GatePass Number </b><?php echo $details['gatepass_number']; ?> &nbsp;&nbsp;&nbsp;<b> Vehicle Number </b><?php echo $details['vehicle_number']; ?>&nbsp;&nbsp;&nbsp;<b> Date </b><?php echo $details['on_date']; ?> </p>
<table border="1px" align="center" width="100%" cellspacing="0" cellpadding="2">
<!-- <tr>
<td colspan='4' align="center"><b>REFINED <?php echo $mrr_results['loose_oil_name']?> MRR</b></td>
</tr> -->
<tr>
	<th rowspan="2">Sno</th>
	<th rowspan="2" >Invoice Number</th>
  <th rowspan="2" colspan="2">Unit[town]</th>
	<th rowspan="2" colspan="2">product</th>
	<th colspan="3" align="center">Quantity</th>
</tr>
<tr>
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
        <td align="left" valign="top" colspan="2" rowspan="<?php echo count($value['products']);?>"><?php echo  get_plant_based_invoice($values['invoice_id']); ?></td>
        <?php
          }
        ?>
  		  <td align="center" colspan="2"><?php echo  $values['product_name']; ?></td>
  			<td align="center"><?php echo  $values['cbs']; ?></td>	
  			<td align="center"><?php echo  $values['sachets']; ?></td>	
  			<td align="center"><?php echo  round($values['weight'],2); ?></td>	
  		
   </tr>
	   
 	<?php $j++; } } } else { ?>
    <tr>
        <td colspan="5">No records found</td>
    </tr>
    <?php } ?>
 	
</table>
<p style="text-align:right;"><b>Total Weight: </b><?php echo $total_weight; ?></p>
</br>
</br>
</br>
</br>
<br></br>
<br></br>
<br></br>

<table width="100%">
<tr>
    <td style="text-align:center;">Verified by </td>
    <td style="text-align:center;">Owner Signature</td>
</tr>
</table>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<table width="100%">
    <tr>
      <td style="text-align:center;"> Supervisor </td>
      <td style="text-align:center;  ;">Officer In-charge </td>
    </tr>
</table>