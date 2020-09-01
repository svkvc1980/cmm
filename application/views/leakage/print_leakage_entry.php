<br>
<h2 align="center">A.P.CO-OPERATIVE OIL SEEDS GROWER'S FEDERATION LIMITED</h2>
<h3 align="center"><?php echo $block_name.' '.$plant_name; ?></h3> 
<h3 align="center">Leakage Entry List</h3>
<br>
<div class="wrapper " width="20%">
<p><b>Leakage Number  </b><?php echo $leakage_results['leakage_number']; ?> </p>
<p><b> Location </b>&nbsp;&nbsp;&nbsp;<?php echo get_type_name($leakage_results['type']); ?></p>
<p><b> Date </b>&nbsp;&nbsp;&nbsp;<?php echo $leakage_results['on_date']; ?> </p>
</div>
<table border="1px" align="center" width="60%" cellspacing="0" cellpadding="2">
<!-- <tr>
<td colspan='4' align="center"><b>REFINED <?php echo $mrr_results['loose_oil_name']?> MRR</b></td>
</tr> -->
<tr>
	<th>Sno</th>
	<th>Product</th>
	<th>Leakage Qty</th>
	<th>Item Per Carton</th>
</tr>

<?php 
	$sno=1;
   foreach($leakage_products as $values) { ?>
   	<tr>
   		<td align="center"><?php echo  $sno++; ?></td>
   		<td align="center"><?php echo  $values['name']; ?></td>
        <td align="center"><?php echo  $values['quantity']; ?></td>
    	<td align="center"><?php echo  $values['items_per_carton']; ?></td>	
  	</tr>
	<?php }   ?>
 	
</table>
<br>
<div class="wrapper">
<p><b>Verified by </b> &nbsp;&nbsp;&nbsp;<b>Owner Signature </b>&nbsp;&nbsp;&nbsp;<b> Supervisor </b> 
 &nbsp;&nbsp;&nbsp; <b>Officer In-charge </b></p>
</div>
<div class="wrapper">
<button class="button" onclick="myFunction()">Print</button>
</div>
<script type="text/javascript">
	function myFunction()
	{
		window.print();	
	}

</script>
<style>
	.wrapper {
    text-align: center;
}

.button {
    position: absolute;
    top: 70%;
}
</style>