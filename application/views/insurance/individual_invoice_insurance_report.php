<!DOCTYPE html>
<html>
<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" />
</head>
<body>
<p align="center"><?php echo"Date : " .date('d-m-Y'); ?></p>
<P style="margin-left:200px">To</P>
<p style="margin-left:200px">The V.C. &  Managing Director</p>
<p style="margin-left:200px">APOILFED</p>
<br>
<br>
<p style="margin-left:200px">Sir</p>
<u style="margin-left:200px">Sub :- </u><p style="margin-left:240px">Submission of Leakage Claims – Reg <?php  echo $insurance_report[0]['agency_name']; ?>. </p>
<br>
  <table style="border:none  ; margin-left:200px !important;" width="700">
    <tr style="border:none !important;">
    <td style="border:none !important;" width="100"
    >We have received the stock on <?php echo $insurance_report[0]['received_date']; ?>  , as against the invoice No <?php echo $insurance_report[0]['invoice_number']; ?>.	
    dated  <?php echo $insurance_report[0]['invoice_date']; ?>   from <?php echo $insurance_report[0]['plant_name']; ?> . In this consignment, we have received the  following stocks in leakage condition.</td>
    </tr>
    
    </table>        
<p  style="margin-left:200px"><b>Invoice Details : </b></p>

<table border="1px solid" cellspacing="0" align ="center" cellpadding="2" width="750">
       <thead style="background-color:#cccfff">
          <th>Sno</th>
          <th>Product</th>
          <th>Carton</th>
          <th>Pouches</th>
          <th>Price Per Unit</th>
          <th>Amount</th>
        </thead>
        <tbody>
	        <?php $sn=1; $t1=0; foreach($invoice_products as $row)
	        {  $total_amount=$row['packets']*$row['rate'] ;
	           $t1+=$total_amount; ?>
                 <tr>
                 	<td><?php echo $sn++; ?></td>
                 	<td><?php echo $row['product_name']; ?></td>
                 	<td  align="right"><?php echo $row['carton_qty']; ?></td>
                 	<td  align="right"><?php echo $row['packets']; ?></td>
                 	<td align="right"><?php echo price_format($row['rate']); ?></td>
                 	<td align="right"><?php echo price_format($total_amount); ?></td>
                 	</tr>
	      <?php  } ?>
	      <tr>
	      <td align="right" colspan="5">Amount</td>
	      <td align="right" ><?php echo price_format($t1); ?></td>
	      </tr>
	    </tbody>
</table>
<br>
<p style="margin-left:200px"><b>Leakage Details</b></p>
<table border="1px solid"  align ="center" cellspacing="0" cellpadding="2" width="750">
       <thead style="background-color:#cccfff">
          <th>Sno</th>
          <th>Product</th>
          <th>Leaked Pouches</th>
          <th>Recovered Oil</th>
          <th>Oil Loss</th>
          <th>Amount</th>
        </thead>
        <tbody>
	        <?php $sn=1; $t2=0; foreach($product_results as $row)
	        {  //$total_amount=$row['packets']*$row['rate'] ;
	           $t2+=$row['net_loss_amount']; ?>
                 <tr>
                 	<td><?php echo $sn++; ?></td>
                 	<td><?php echo $row['product_name']; ?></td>
                 	<td  align="right"><?php echo $row['leaked_pouches']; ?></td>
                 	<td  align="right"><?php echo qty_format($row['recovered_oil']); ?></td>
                 	<td align="right"><?php echo qty_format($row['net_loss']); ?></td>
                 	<td align="right"><?php echo price_format($row['net_loss_amount']); ?></td>
                 	</tr>
	      <?php  } ?>
	      <tr>
	       <td align="right" colspan="5"> Loss Amount</td>
	      <td align="right"><?php echo price_format($t2); ?></td>
	      </tr>
	      <tr>
	      	<td align="right" colspan="5">Net Transit Loss</td>
	      <td align="right"><?php echo price_format($t1-$t2); ?></td>
	      </tr>
	    </tbody>
</table>
<br><br>
<p style="margin-left:220px">This is for your kind information and necessary action please.</p>
<br>
<p style="margin-left:220px" >Thanking you</p>
<br>
<p style="margin-left:220px">Yours faithfully</p>
<br><br>
 <table  style="border:none ; margin-left:220px !important;" width="700">
 <tr style="border:none !important;">
    
    <td style="border:none !important;" width="200">Authorised Signature </td>
    </tr>
   </table>
 <div class="row" style="text-align:center">
    <button class="button print_element"  onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'individual_insurance_invoice';?>">Back</a>
    </div>
</body>
    <script type="text/javascript">
        function print_srn()
        {
            window.print();
        }
    </script>