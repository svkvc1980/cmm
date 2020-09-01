<!DOCTYPE html>
<html>
<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 
</head>
<body>
<h2 align="center">A.P.CO-OPERATIVE OIL SEEDS GROWER'S FEDERATION LIMITED</h2>

<br>
<table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
 <?php foreach($order_details as $od) 
 { ?>
   <tr>
        <td><b>Order Number : </b><?php  echo $od['order_number'] ; ?></td>
        <td><b>Order Date : </b><?php  echo date('d-m-Y',strtotime($od['order_date'])) ; ?></td>
   </tr>
    <tr>
        <td><b>Order Type : </b><?php  echo $od['obt_type'] ; ?></td>
        <td><b>Lifting Point : </b><?php  echo $od['lifting_point'] ; ?></td>
   </tr>
    <tr>
        <td colspan="2"><b>Order For : </b><?php  echo $od['order_for_plant'] ; ?></td>
    </tr>
 <?php  }
 ?>
</table>
<br>
<div class="row">
    <table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
        <thead>
            <th> S.No</th>
            <th> Product Name </th>
            <th> Quantity </th>
            <th> Unit Price </th>
            <th> Add Price </th>
            <th> Total Price</th>
        </thead>
         <tbody>
            <?php $sn = 1;
             foreach($orderd_product_details as $row) { ?>
                <tr>
                    <td><?php echo $sn++; ?></td>
                    <td><?php echo $row['product_name']; ?></td>
                    <td align="right"><?php echo round($row['quantity']); ?></td>
                    <td align="right"><?php echo price_format($row['unit_price']); ?></td>
                    <td align="right"><?php echo price_format($row['add_price']); ?></td>
                    <td align="right"><?php echo price_format($row['total_price']);  ?></td>
                </tr>
            <?php } ?>
                <tr><td colspan="6" align="right"><b>Total Price: <?php echo price_format($grand_total);?></b></td></tr>
        </tbody>
    </table>
</div>
<br>
<div class="wrapper" style="text-align:center">
    <button class="button print_element" style="background-color:#3598dc"  onclick="print_srn()">Print</button>
    <?php if(@$cancel_type==1)
    { ?>
    <a class="button print_element" href="<?php echo SITE_URL.'plant_ob_list';?>">Cancel</a>
    <?php }
    elseif(@$cancel_type==2)
    {?>
        <a class="button print_element" href="<?php echo SITE_URL.'single_plant_ob_list';?>">Cancel</a>
    <?php }
     ?>
</div>
<script type="text/javascript">
    function print_srn()
    {
        window.print(); 
    }
</script>
<style>
    @media print {
     .print_element{display:none;}
    }
    .wrapper {
    text-align: center;
}
</style>
