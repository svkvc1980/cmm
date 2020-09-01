<!DOCTYPE html>
<html>
<head>
    <title>Invoice Dispatched Report</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 
</head>
<body>
<h2 align="center">A.P.CO-OPERATIVE OIL SEEDS GROWER'S FEDERATION LIMITED</h2>
<h3 align="center">Stock Transfer particulars <span style="margin-left: 50px;">From: <?php echo date('d-m-Y', strtotime($from_date))?> </span><span style="margin-left: 20px;">To :<?php echo date('d-m-Y', strtotime($to_date)); ?></span></h3>
<h3 align="center"><?php foreach($plant_name as $row) { echo $row['name'];} ?></h3>
    <table border="1px solid" align="center" cellspacing="0" cellpadding="2" width="800">
       <thead style="background-color:#cccfff">
          <th>Sno</th>
          <th>Unit</th>
          <th>Invoice No</th>
          <th>Do No</th>
          <th>Product</th>
          <th>Invoiced Cartons</th>
          <th>Received Cartons</th>
          <th>Oil Weight(Kgs)</th>
          <th>Value</th>
      </thead>
      <?php 
      if(count($stock_receive_result) > 0)
      { 
        $sno=1;
        $grd_inv_carton = 0;
        $grd_rec_carton = 0;
        $grd_amount = 0;
        $grd_oil_weight = 0;

        foreach($stock_receive_result as $key => $value) 
        {
          $total_inv_carton = 0;
          $total_rec_carton = 0;
          $total_amount = 0;
          $total_oil_weight = 0;
          $j = 1;
          foreach ($value['invoice_results'] as $k1 => $row)
           {
              $total_inv_carton += $row['invoice_quantity'];
              $total_rec_carton += $row['received_quantity'];
              $total_amount += $row['total_price'];
              $total_oil_weight += $row['total_oil_weight'];
          ?>
        <tr>
          <td width="30"> <?php echo $sno++; ?></td>
          <?php if($j==1) { ?>
          <td width="30" rowspan="<?php echo count($value['invoice_results']);?>"> <?php echo $value['plant_short_name']; ?></td>
          <td width="90" rowspan="<?php echo count($value['invoice_results']);?>"> <?php echo $value['invoice_number'].' / '.$value['invoice_date'];?></td>
          <td width="30" rowspan="<?php echo count($value['invoice_results']);?>"> <?php echo $value['do_number']; ?></td>
          <?php } ?>
          <td width="130"> <?php echo $row['product_name'];?></td>
          <td width="80" align="right"> <?php echo round($row['invoice_quantity']);?></td>
          <td width="80" align="right"> <?php echo round($row['received_quantity']);?></td>
          <td width="80" align="right"><?php echo qty_format($row['total_oil_weight']);?></td>
          <td width="80" align="right"> <?php echo price_format($row['total_price']);?></td>
        </tr>

     <?php $j++; } 
          $grd_inv_carton += $total_inv_carton;
          $grd_rec_carton += $total_rec_carton;
          $grd_amount += $total_amount;
          $grd_oil_weight += $total_oil_weight; ?>
           <tr>
            <td colspan="5" align="right"><b>Total</b></td>
            <td align="right"><b><?php echo round($total_inv_carton); ?></b></td>
            <td align="right"><b><?php echo round($total_rec_carton); ?></b></td>
            <td align="right"><b><?php echo qty_format($total_oil_weight); ?></b></td>
            <td align="right"><b><?php echo price_format($total_amount); ?></b></td>
            </tr>
     <?php } ?>
          <tr>
            <td colspan="5" align="right"><b>Grand Total</b></td>
            <td align="right"><b><?php echo round($grd_inv_carton); ?></b></td>
            <td align="right"><b><?php echo round($grd_rec_carton); ?></b></td>
            <td align="right"><b><?php echo qty_format($grd_oil_weight); ?></b></td>
            <td align="right"><b><?php echo price_format($grd_amount); ?></b></td>
            </tr>
      <?php } 
        else
        { ?>
            <tr>
            <td colspan="9" align="center"><b>No Records Found </b> </td>
            </tr>
        <?php }
        ?>
        </table><br>
    <br><br><br><br><br>
    <table style="border:none !important" align="center" width="750">
        <tr style="border:none !important">
        <td style="border:none !important">
        
        <span style="margin-left:550px;">Authorised Signature</span>
        </td>
        </tr>
    </table>
<div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'stock_transfer_view';?>">Back</a>
    </div>

</body>
<script type="text/javascript">
    function print_srn()
    {
        window.print(); 
    }
</script>
