<!DOCTYPE html>
<html>
<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 
</head>
<body>
    <br>
    <h2 align="center">AP Cooperative Oilseeds Growers Federation Ltd</h2>
    <p align="center" style="margin-left: 20px;"><b>Distributor Pending OB List
        </p>
     <p align="center"><?php if($distributor_id!='') { echo 'Dealer : '.get_distributor_name($distributor_id); } ?></p>
    <table  align="center" width="950" cellspacing="0" cellpadding="2" >
       <thead class="blue_head">
            <tr>
                <th>S.No</th>
                <th width="120">OB Number</th>
                <th>Lifting</th>
                <th>Product </th>
                <th>OB Qty</th>
                <th>Pending Qty</th>
                <th align="right">Price</th>
                <th align="right">Value</th>
            </tr>
        </thead>
        <tbody>
        <?php
            if(@$ob_results)
            {
                $sn=1; $value=0;
            foreach(@$ob_results as $row)
                { $value+=($row['quantity']*$row['items_per_carton']*$row['product_price']);?>                                    
            <tr>
                <td><?php echo $sn++;?></td>
                <td><?php echo $row['order_number'].' / '.date('d-m-Y',strtotime($row['order_date']));?> </td>
                <td><?php echo $row['lifting_point'];?> </td>
                <td><?php echo $row['product_name'];?> </td>
                <?php /*$invoice_qty = get_do_product_invoice_qty($row['order_id'],$row['do_identity'],$row['product_id']); 
                        $pending_qty = ($row['do_quantity'] - $invoice_qty)*/?>
                <td align="right"><?php echo round($row['quantity']);?> </td>
                <td align="right"><?php echo round($row['pending_qty']);?> </td>
                <td align="right"><?php echo price_format($row['product_price']);?> </td>
                <td align="right"><?php echo price_format($row['quantity']*$row['items_per_carton']*$row['product_price']);?></td>
                
            </tr>
            <?php
                } ?>
                <tr><td align="right" colspan="7">Grand Total :</td><td align="right"><?php echo price_format($value); ?></td></tr>
          <?php  }
            else
            {
                ?> <tr><td colspan="10" align="center"> No Records Found</td></tr>      
        <?php   }
            ?>
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