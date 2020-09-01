<!DOCTYPE html>
<html>
<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 
</head>
<body>
<h2 align="center">AP Cooperative Oilseeds Growers Federation Ltd</h2>
<table border="1px" style="border:none !important" align="center" width="750" cellspacing="0" cellpadding="2">
<tr>
    <td style="border:none !important" align="left">To</td>
</tr>
<tr>
    <td style="border:none !important" align="left">The V.C & Managing Director,</td>
</tr>
<tr>
    <td style="border:none !important" align="left">A.P Oil Federation,</td>
</tr>
<tr>
    <td style="border:none !important" align="left">Hyderabad.</td>
</tr>

<tr>
    <td style="border:none !important" align="left">Monthly Sales report    From <?php echo date('d F, Y', strtotime($from_date)) ?> TO <?php echo date('d F, Y', strtotime($to_date)) ?> </td>
</tr>
<tr>
    <td style="border:none !important" align="left">Distributor Name[Code] : <?php echo $dist['agency_name'].'['.$dist['distributor_code'] .']'; ?> </td>
</tr>
</table>
<br>
 <table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
       <tr style="background-color:#cccfff">
       		<th>Sno</th>
       		<th>Invoice Number</th>
            <th>Invoice Date</th>
            <th>Quantity</th>
       		<th>Amount</th>
      </tr>
      <?php 
      if(count($dist_sale_results) > 0)
      { 
      	$sno=1;
      	$total_qty=0;
      	$total_amount=0;
      	foreach($dist_sale_results as $row) { 
      		$total_qty+=$row['qty_in_kg'];
      		$total_amount+=$row['amount'];
      		?>
      	<tr>
      		<td> <?php echo $sno++; ?></td>
      		<td> <?php echo $row['invoice_number']; ?></td>
      		<td> <?php echo date('d-m-Y',strtotime($row['invoice_date']));?></td>
      		<td align="right"> <?php echo qty_format($row['qty_in_kg']);?></td>
      		<td align="right"> <?php echo price_format($row['amount']);?></td>
      	</tr>

     <?php } ?>
          <tr>
           	<td colspan="3" align="right">Total</td>
           	<td align="right"><?php echo qty_format($total_qty); ?></td>
           	<td align="right"><?php echo price_format($total_amount); ?></td>
           	</tr>
      <?php } 
        else
        { ?>
            <tr>
            <td colspan="5" align="center"><b>No Records Found </b> </td>
            </tr>
        <?php }
        ?>
        </table>
        <br><br><br><br><br>
    
        <table style="border:none !important" align="center" width="750">
            <tr style="border:none !important">
            <td style="border:none !important">
            
            <span style="margin-left:550px;">Authorised Signature</span>
            </td>
            </tr>
        </table>
    <br>
    <div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'distributor_monthly_sales_report';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>