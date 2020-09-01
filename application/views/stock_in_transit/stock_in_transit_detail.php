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
<h4 align="center">Stock In Transit</h4>
<?php if($lifting_point!='' || $order_for!='') {?>
<h4 align="center"><?php if($lifting_point!=''){ echo 'From : '.$lifting_point; }?><span style="margin-left: 50px;"><?php if($order_for!=''){ echo 'To : '.$order_for; }?></span></h4>
<?php } ?>
<h4 align="center"><?php echo $from_date .' - To - '. $to_date ?></h4>
 <table border="1px solid" align="center" cellspacing="0" cellpadding="2" width="750">
       <thead style="background-color:pink">
          <th>Sno</th>
          <th>Order For</th>
          <th>Invoice No</th>
          <th>Product</th>
          <th>Cartons</th>
          <th>Pouches</th>
          <th>Quantity(Kgs)</th>
          <th>Amount</th>
      </thead>
      <?php 
      if(count($stock_result) > 0)
      { 
        $sno=1;
        $total_qty=0;
        $total_amount=0;
        $total_cartons=0;
        $total_pouches=0;
        foreach($stock_result as $key => $value) {
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
          <td rowspan="<?php echo count($value['invoice_results']);?>"> <?php echo $row['plant']; ?></td>
          <td rowspan="<?php echo count($value['invoice_results']);?>"> <?php echo $row['invoice_number'].'/'.date('d-m-Y',strtotime($row['invoice_date']));?></td>
          <?php } ?>
          <td> <?php echo $row['short_name'];?></td>
          <td align="right"> <?php echo $row['qty'];?></td>
          <td align="right"> <?php echo $row['pouches'];?></td>
          <td align="right"> <?php echo qty_format($row['qty_in_kg']);?></td>
          <td align="right"> <?php echo price_format($row['amount']);?></td>
        </tr>

     <?php $j++; } ?>
           <tr>
            <td colspan="4" align="right"><b>Total</b></td>
            <td align="right"><b><?php echo $tc; ?></b></td>
            <td align="right"><b><?php echo $tp; ?></b></td>
            <td align="right"><b><?php echo qty_format($tq); ?></b></td>
            <td align="right"><b><?php echo price_format($ta); ?></b></td>
            </tr>
     <?php } ?>
          <tr>
            <td colspan="4" align="right"><b>Grand Total</b></td>
            <td align="right"><b><?php echo $total_cartons; ?></b></td>
            <td align="right"><b><?php echo $total_pouches; ?></b></td>
            <td align="right"><b><?php echo qty_format($total_qty); ?></b></td>
            <td align="right"><b><?php echo price_format($total_amount); ?></b></td>
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
    <br><br><br><br><br>
    <table align ="center" style="border:none !important;" width="700">
    <tr style="border:none !important;">
    <td style="border:none !important;" width="100"></td>
    <td style="border:none !important;" width="400"></td>
    <td style="border:none !important;" width="200">Authorised Signature </td>
    </tr>
    </table>
   <div class="row" style="text-align:center">
    <button class="button print_element"  onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'stock_in_transit';?>">Back</a>
    </div>
</body>
    <script type="text/javascript">
        function print_srn()
        {
            window.print();
        }
    </script>