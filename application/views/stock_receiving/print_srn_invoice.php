<style type="text/css">
.button
{
  horizontal-align: 400px;
  width: 150px;
  text-align: center;
  margin:0 auto;

}
</style>
<br>
<h2 align="center">A.P.CO-OPERATIVE OIL SEEDS GROWER'S FEDERATION LIMITED</h2>
<h3 align="center">SRN Details</h3>
<br>
<div class="row">
<div style="max-width:500px;position: relative"></div>
	<p style="margin-left:20%">SRN Number<span style="margin-left:1%"><b><?php echo $srn_number?></b></span><span style="margin-left:17%">SRN Date</span><span style="margin-left:1%"><b><?php echo date('d-m-Y',strtotime($srn_date))?></b></span><span style="margin-left:15%">Vehicle Number</span><span style="margin-left:1%"><b><?php echo $vehicle_number?></b></span></p>
	<?php if(count(@$lit_results)>0) { ?>
	<p style="margin-left:20%">Transporter Name<span style="margin-left:1%"><b><?php echo @$lit_results[0]['transporter_name']?></b></span><span style="margin-left:12%">LR Date</span><span style="margin-left:1%"><b><?php echo date('d-m-Y',strtotime(@$lit_results[0]['lr_date']))?></b></span><span style="margin-left:16%">Remarks</span><span style="margin-left:1%"><b><?php echo $lit_results[0]['remarks']?></b></span></p>
	<?php } ?>
</div>
<br>
<div class="row">
<table border="1px" align="center" width="60%" cellspacing="0" cellpadding="2">
<?php				    
foreach(@$invoice_results as $stock_receipt_id => $value) 
{   if(count(@$value['product_details'] )>0) { ?>

	<tr style="background-color:#bfcad1">
		<td colspan="6" align="center"> <b>Invoice No: <?php echo $value['invoice_number']; ?></b></td>
	</tr>
	<tr style="background-color:#e1e5ec">
       <td colspan="6">Products</td>
    </tr>
    <tr style="background-color:#fafafa">
        <td> <b>S.No</b></td>
        <td> <b>Product Name </b></td>
        <td>  <b>Invoice Qty </b></td>
        <td>  <b>Received Qty</b></td>
        <td>  <b>Shortage </b></td>
    </tr>
    <tbody>
        <?php 
        $sno = 1;
         foreach(@$value['product_details'] as $keys =>$values) 
         {  
            if($values != '') 
            { ?>
                <tr class="do_row">
                    <td><?php echo $sno++; ?></td>
                    <td><?php echo $values['product_name']?></td>
                    <td><?php echo $values['invoice_quantity']?></td>
                    <td style="width:15%;"><?php echo $values['received_quantity']?></td>
                    <td><?php echo $values['shortage']?></td> 
                </tr>
                <?php   
            }
        } ?>               
    </tbody>
    <tr style="background-color:#e9edef  ">
	      <td colspan="6">Free Gift Items</td>
	    </tr>
	    <tr style="background-color:#fafafa">
	        <th> S.No</th>
	        <th> Free Gift Item </th>
	        <th> Invoice Qty </th>
	        <th> Received Qty </th>
	        <th> Shortage </th>
	    </tr>
	    <tbody>
	        <?php $sn = 1;
	        if(count(@$value['free_gift_details'])>0||count(@$value['free_product_details'])>0)
	        {
		         foreach(@$value['free_gift_details'] as $keys =>$values) 
		         { 
		            if($values != '') 
		            { ?>
		                <tr class="do_row">
		                    <td><?php echo $sn++; ?></td>
		                    <td><?php echo $values['free_gift_name']; ?></td>
		                    <td><?php echo $values['invoice_quantity']?>
		                    </td>
		                    <td style="width:15%;"><?php echo $values['received_quantity']?>
		                    </td>
		                    <td><?php echo $values['shortage']?></td> 
		                </tr>
		                <?php   
		            }
		        } ?>
		        <?php 
		         foreach(@$value['free_product_details'] as $keys =>$values) 
		         { 
		            if($values != '') 
		            { ?>
		                <tr class="do_row">
		                    <td><?php echo $sno++; ?></td>
		                    <td><?php echo $values['product_name']; ?></td>
		                    <td><?php echo $values['invoice_quantity']?>
		                    </td>
		                    <td style="width:15%;"> <?php echo $values['received_quantity']?>
		                    </td>
		                    <td><?php echo $values['shortage']?></td> 
		                </tr>
		                <?php   
		            }
		        } 
	        }?> 
	    </tbody> 
	    <?php } }?> 
</table>
</div>
<br>
<div class="row" style="text-align:center">
<button class="button"  onclick="print_srn()" style="background-color:#3598dc">Print</button>
<a href="<?php echo SITE_URL.'stock_receiving_list';?>" style="background-color:#3598dc">Back</a>
</div>
<script type="text/javascript">
	function print_srn()
	{
		window.print();	
	}
</script>

