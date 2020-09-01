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
<h3 align="center">Dispatch particulars <span style="margin-left: 50px;">From: <?php echo date('d-m-Y', strtotime($from_date))?> </span><span style="margin-left: 20px;">To :<?php echo date('d-m-Y', strtotime($to_date)); ?></span></h3>
<h3 align="center"><?php foreach($plant_name as $row) { echo $row['name'];} ?></h3>
    <table border="1px solid" align="center" cellspacing="0" cellpadding="2" width="800">
       <thead style="background-color:#cccfff">
          <th>Sno</th>
          <th>Order For</th>
          <th>Invoice No</th>
          <th>Do No</th>
          <th>Product</th>
          <th>Cartons</th>
          <th>Pouches</th>
          <th>Quantity(Kgs)</th>
          <th>Amount</th>
      </thead>
      <?php 
      if(count($dispatches_result) > 0)
      { 
        $sno=1;
        $total_qty=0;
        $total_amount=0;
        $total_cartons=0;
        $total_pouches=0;
        foreach($dispatches_result as $key => $value) {
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
          <td rowspan="<?php echo count($value['invoice_results']);?>"> <?php echo $row['agency_name']; ?></td>
          <td rowspan="<?php echo count($value['invoice_results']);?>"> <?php echo $row['invoice_number'].' / '.date('d-m-Y',strtotime($row['invoice_date']));?></td>
          <td rowspan="<?php echo count($value['invoice_results']);?>"> <?php echo $value['do_number']; ?></td>
          <?php } ?>
          <td> <?php echo $row['short_name'];?></td>
          <td align="right"> <?php echo $row['qty'];?></td>
          <td align="right"> <?php echo $row['pouches'];?></td>
          <td align="right"> <?php echo qty_format($row['qty_in_kg']);?></td>
          <td align="right"> <?php echo price_format($row['amount']);?></td>
        </tr>

     <?php $j++; } ?>
           <tr>
            <td colspan="5" align="right"><b>Total</b></td>
            <td align="right"><b><?php echo $tc; ?></b></td>
            <td align="right"><b><?php echo $tp; ?></b></td>
            <td align="right"><b><?php echo qty_format($tq); ?></b></td>
            <td align="right"><b><?php echo price_format($ta); ?></b></td>
            </tr>
     <?php } ?>
          <tr>
            <td colspan="5" align="right"><b>Grand Total</b></td>
            <td align="right"><b><?php echo $total_cartons; ?></b></td>
            <td align="right"><b><?php echo $total_pouches; ?></b></td>
            <td align="right"><b><?php echo qty_format($total_qty); ?></b></td>
            <td align="right"><b><?php echo price_format($total_amount); ?></b></td>
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
    <!-- <table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
        <tbody>
            <tr style="background-color:#cccfff">
                <th>S.No</th>
                <th>Distributor </th>
                <th>Invoice No</th>
                <th>DO.No</th>
                <th>Quantity(Kg's)</th>
                <th>Value(Rs)</th>
            </tr>
            <?php   $sn = 1;
                if(count($distributor)>0)
                {
                    foreach($distributor as $key => $value) 
                    {?>
                       <tr>
                            <td><?php echo $sn++ ?></td>
                            <td><?php echo $value['agency_name'].' ['.$value['distributor_code'].']'; ?></td>
                            <td  align="center"><?php echo $value['invoice_number'].' / '.date('d-m-Y', strtotime($value['invoice_date']))?> </td>
                            <td align="center"><?php echo $dispatches_report[$value['invoice_id']]['do_no']?> </td>
                            <td align="right"><?php echo qty_format($dispatches_report[$value['invoice_id']]['tot_qty']); ?></td>
                            <td align="right"><?php echo price_format($dispatches_report[$value['invoice_id']]['tot_val']);?></td>
                       </tr>
            <?php   } 
            }
            else
            { ?>
                <tr><td colspan="6" align="center">- No Records Found -</td></tr>
           <?php  }   

            ?>
        </tbody>
    </table> -->
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
    <a class="button print_element" href="<?php echo SITE_URL.'product_wise_daily_dispatches';?>">Back</a>
    </div>

</body>
<script type="text/javascript">
    function print_srn()
    {
        window.print(); 
    }
</script>
