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
    <p align="center"><b>Distributor Pending DO List
       </p>
     <p align="center"><?php if($distributor_id!='') { echo 'Dealer : '.get_distributor_name($distributor_id); } ?> 
        </p>
    <table border="1px" align="center" width="1000" cellspacing="0" cellpadding="2">
       <tr style="background-color:#cccfff">
            <th width="10">S.No</th>
            <th width="120">DO Number</th>
            <th width="25">Lifting</th>
            <th width="200">Product </th>
            <th width="65">DO Qty</th>
            <th width="65">Pending Qty</th>
            <th width="20">Price</th>
            <th width="30">Value</th>
        </tr>
        <tbody>
        <?php
            if(@$do_results)
            {
                $sn=1; $total = 0;
            foreach(@$do_results as $row)
                { 
                $total += ($row['do_quantity']*$row['items_per_carton']*$row['product_price']); ?>                                    
            <tr>
                <td><?php echo $sn++;?></td>
                <td><?php echo $row['do_number'].' / '.format_date($row['do_date']);?> </td>
                <td><?php echo $row['lifting_point'];?> </td>
                <td><?php echo $row['product_name'];?> </td>
                <?php /*$invoice_qty = get_do_product_invoice_qty($row['order_id'],$row['do_identity'],$row['product_id']); 
                        $pending_qty = ($row['do_quantity'] - $invoice_qty)*/?>
                <td align="right"><?php echo round($row['do_quantity']);?> </td>
                <td align="right"><?php echo round($row['pending_qty']);?> </td>
                <td align="right"><?php echo price_format($row['product_price']);?> </td>
                <td align="right"><?php echo price_format($row['do_quantity']*$row['items_per_carton']*$row['product_price']);?></td>
                
            </tr>
            <?php
                } ?>
                <tr>
                <td colspan="7" align="right"><b>Total</b></td>
                <td align="right"><b><?php echo price_format($total); ?></b></td>
                </tr>
           <?php  }
            else
            {
                ?> <tr><td colspan="10" align="center"> No Records Found</td></tr>      
        <?php   }
            ?>
        </tbody>
    </table>
    <br>
    <div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>