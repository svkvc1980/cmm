<!DOCTYPE html>
<html>
<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" />
</head>
<body class="image">
<h2 align="center">A.P.CO-OPERATIVE OIL SEEDS GROWER'S FEDERATION LIMITED</h2>
<h3 align="center">Insurance Report</h3>
<h4 align="center"><?php if($from_date!='') { echo  'From : '.date('d-m-Y',strtotime($from_date)); }?><span style="margin-left: 50px;"><?php if($from_date!='') { echo  'To : '.date('d-m-Y',strtotime($to_date)); }?></span></h4>
 <table border="1px solid" align="center" cellspacing="0" cellpadding="2" width="750">
       <thead style="background-color:pink">
          <th>Sno</th>
          <th>Invoice Number</th>
          <th>Distributor</th>
          <th>Unit</th>
          <th>Product</th>
          <th>Leaked Pouches</th>
          <th>Wastage Oil [Kgs]</th>
          <th>lost Amount</th>
      </thead>
      <?php 
      if(count($insurance_result) > 0)
      { 
        $sno=1;
        $total_qty=0;
        $total_amount=0;
        foreach($insurance_result as $key => $value) {
          $tq=0;
          $ta=0;
          $j=1;
          foreach ($value['insurance_results'] as $k1 => $row)
           {
          $tq+=$row['net_loss'];
          $ta+=$row['net_loss_amount'];
          $total_qty+=$row['net_loss'];
          $total_amount+=$row['net_loss_amount'];
          ?>
        <tr>
          <td> <?php echo $sno++; ?></td>
          <?php if($j==1) { ?>
          <td rowspan="<?php echo count($value['insurance_results']);?>"> <?php echo $value['invoice_number'].'/'.date('d-m-Y',strtotime($value['invoice_date'])); ?></td>
          <td rowspan="<?php echo count($value['insurance_results']);?>"> <?php echo $value['distributor']; ?></td>
          <td rowspan="<?php echo count($value['insurance_results']);?>"> <?php echo $value['plant_name']; ?></td>
          <?php } ?>
          <td> <?php echo $row['product_name'];?></td>
          <td align="right"> <?php echo $row['leaked_pouches'];?></td>
          <td align="right"> <?php echo $row['net_loss'];?></td>
          <td align="right"> <?php echo $row['net_loss_amount'];?></td>
        </tr>

     <?php $j++; } ?>
           <tr>
            <td colspan="6" align="right"><b>Total</b></td>
            <td align="right"><b><?php echo qty_format($tq); ?></b></td>
            <td align="right"><b><?php echo price_format($ta); ?></b></td>
            </tr>
     <?php } ?>
          <tr>
            <td colspan="6" align="right"><b>Grand Total</b></td>
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
    <a class="button print_element" href="<?php echo SITE_URL.'insurance_report';?>">Back</a>
    </div>
</body>
    <script type="text/javascript">
        function print_srn()
        {
            window.print();
        }
    </script>