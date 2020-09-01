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
<h3 align="center">Executive Wise Daily Sales Report</h3>
<h4 align="center">Executive Name : <?php echo $executive_name; ?><span style="margin-left:50px;"><?php echo 'On :'.$from_date; ?></span></h4>
 <table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
       <thead>
       <tr style="background-color:#cccfff">
       		<th>Sno</th>
       		<th>Dealer Agency[Code]</th>
            <th>Invoice No</th>
            <th>Product</th>
            <th>Cartons</th>
            <th>Pouches</th>
            <th>Quantity(Kgs)</th>
       		<th>Amount</th>
       	</tr>
      </thead>
      <?php 
      if(count($exec_results) > 0)
      { 
      	$sno=1;
      	$total_qty=0;
      	$total_amount=0;
        $total_cartons=0;
        $total_pouches=0;
      	foreach($exec_results as $key => $value) {
          $tq=0;
          $ta=0;
          $tc=0;
          $tp=0;
          $j=1;
          foreach ($value['invoice_results'] as $k1 => $row)
           {
          $tq+=$row['qty_in_kg'];
          $ta+=$row['amount'];
          $tc+=$row['qty'];
          $tp+=$row['pouches']; 
          $total_qty+=$row['qty_in_kg'];
      		$total_amount+=$row['amount'];
          $total_cartons+=$row['qty'];
          $total_pouches+=$row['pouches'];
      		?>
      	<tr>
      		<td> <?php echo $sno++; ?></td>
          <?php if($j==1) { ?>
      		<td rowspan="<?php echo count($value['invoice_results']);?>"> <?php echo $row['agency_name'].'['.$row['dist_code'].']'; ?></td>
      		<td rowspan="<?php echo count($value['invoice_results']);?>"> <?php echo $row['invoice_number'];?></td>
          <?php } ?>
          <td> <?php echo $row['short_name'];?></td>
          <td align="right"> <?php echo $row['qty'];?></td>
          <td align="right"> <?php echo $row['pouches'];?></td>
      		<td align="right"> <?php echo qty_format($row['qty_in_kg']);?></td>
      		<td align="right"> <?php echo price_format($row['amount']);?></td>
      	</tr>

     <?php $j++; } ?>
           <tr>
            <td colspan="4" align="right">Total</td>
            <td align="right"><?php echo $tc; ?></td>
            <td align="right"><?php echo $tp; ?></td>
            <td align="right"><?php echo qty_format($tq); ?></td>
            <td align="right"><?php echo price_format($ta); ?></td>
            </tr>
     <?php } ?>
          <tr>
           	<td colspan="4" align="right">Grand Total</td>
            <td align="right"><?php echo $total_cartons; ?></td>
            <td align="right"><?php echo $total_pouches; ?></td>
           	<td align="right"><?php echo qty_format($total_qty); ?></td>
           	<td align="right"><?php echo price_format($total_amount); ?></td>
           	</tr>
      <?php } 
        else
        { ?>
            <tr>
            <td colspan="8" align="center"><b>No Records Found </b> </td>
            </tr>
        <?php }
        ?>
        </table><br>
    <br>
    <br>
    <table align ="center" style="border:none !important;" width="750">
    <tr style="border:none !important;">
    <td style="border:none !important;" width="100"></td>
    <td style="border:none !important;" width="400"></td>
    <td  style="border:none !important;" width="200">Authorised Signature </td>
    </tr>
    </table>
    <br>
    <br>
   <div class="row" style="text-align:center">
    <button class="button print_element" style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'executive_daily_sales_report';?>">Back</a>
    </div>
</body>
    <script type="text/javascript">
        function print_srn()
        {
            window.print();
        }
    </script>