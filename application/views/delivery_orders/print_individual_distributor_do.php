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
<h3 align="center">Distributor DO Product List</h3>
<br>
<table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">

   <tr>
        <td><b>DO Number : </b><?php  echo $dist_do[0]['do_number'] ; ?></td>
        <td><b>DO Date : </b><?php  echo date('d-m-Y',strtotime($dist_do[0]['do_date'])) ; ?></td>
   </tr>
   <tr>
        <td><b>Order Booking Number : </b><?php  echo $order_no ; ?></td>
        <td><b>Order Date : </b><?php  echo $order_date ; ?></td>
   </tr>
    <tr>
        <td><b>Lifting Point : </b><?php  echo $dist_do[0]['lifting_point'] ; ?></td>
        <td colspan="2"><b>Distributor : </b><?php  echo $dist_do[0]['distributor'].'['.$dist_do[0]['dist_code'].']' ; ?></td>
   </tr>
</table>
<br>
<table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
    <tr style="background-color:#cccfff">
        <th> S.No</th>
        <th> Prdouct Name </th>
        <th> Quantity </th>
        <th> Pending Quantity </th>
        <th> Price </th>
        <th> Value</th>
    </tr>
     <tbody>
        <?php $sn = 1; $grand_total = 0;
         foreach($dist_do as $row) { 
            $total = $row['product_price']*$row['quantity']*$row['items_per_carton'];
            $grand_total+=$total;
            ?>
            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $row['product']; ?></td>
                <td  align="right"><?php echo round($row['quantity']); ?></td>
                <td  align="right"><?php echo round($row['pending_qty']); ?></td>
                <td  align="right"><?php echo price_format($row['product_price']); ?></td>
                <td  align="right"><?php echo price_format($total);?></td>
            </tr>
            <?php } ?>
            <tr><td colspan="6" align="right"><b>Total Price: <?php echo price_format($grand_total); ?></b></td></tr>
    </tbody>
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
    <a class="button print_element" href="<?php echo SITE_URL.'individual_dist_do';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>