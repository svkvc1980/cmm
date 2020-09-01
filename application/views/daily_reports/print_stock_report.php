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
<h4 align="center">Daily Stock Report <span style="margin-left: 50px;">Stock Report as On : <?php echo $report_date;?> </span></h4>
<table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
    <thead>
        <tr>
            <td><b> Product </b></td>
            <td><b>Opening Stock</b></td>
            <td><b> Production</b> </td>
            <td><b> Invoices</b> </td>
            <td><b> Leakage </b> </td>
            <td><b> Closing Balance</b></td>
        </tr>
        <?php 
        $gt_opening_stock = 0;$gt_production = 0;$gt_invoice =0 ; $gt_leakage = 0; $gt_closing_stock =0;
        foreach ($loose_oils as $loose_oil_id => $loose_oil_name)
        {
           if(count(@$daily_report[$loose_oil_id])!='' )
            {
?> 
            <tr><td align="left" style="background-color:#ccc" colspan="6"><b><?php echo $loose_oil_name;?></b></td></tr>
            <?php
                 $t_opening_stock = 0;$t_production = 0;$t_invoice =0 ; $t_leakage = 0; $t_closing_stock =0;
            foreach ($daily_report[$loose_oil_id] as $product_id => $values)
            { ?>
                <tr>
                    <td> <?php echo $product_info[$product_id]['name'].'['.$product_info[$product_id]['oil_weight'].']';?></td>
                    <td align="right"> <?php echo $values['opening'];?></td>
                    <td align="right"> <?php echo $values['production'];?> </td>
                    <td align="right"> <?php echo $values['invoice'];?> </td>
                    <td align="right"> <?php echo $values['leakage'];?> </td>
                    <td align="right"> <?php echo $values['closing_balance'];?></td>
                </tr>
                
        <?php 
                //$t_qty_in_kg += ($values['opening']*get_items_per_carton($product_id)*get_oil_weight($product_id));
                $t_opening_stock += ($values['opening']*get_items_per_carton($product_id)*get_oil_weight($product_id));
                $t_production +=($values['production']*get_items_per_carton($product_id)*get_oil_weight($product_id));
                $t_invoice += ($values['invoice']*get_items_per_carton($product_id)*get_oil_weight($product_id));
                $t_leakage += ($values['leakage']*get_items_per_carton($product_id)*get_oil_weight($product_id));
                $t_closing_stock += ($values['closing_balance']*get_items_per_carton($product_id)*get_oil_weight($product_id)); 

        } ?>
        <tr>
            <th align="left">Qty in Kg</th>                                    
            <th align="right"><?php echo qty_format($t_opening_stock);?></th>
            <th align="right"><?php echo qty_format($t_production);?></th>
            <th align="right"><?php echo qty_format($t_invoice);?></th>
            <th align="right"><?php echo qty_format($t_leakage);?></th>
            <th align="right"><?php echo qty_format($t_closing_stock);?></th>
        </tr>

        <?php
            $gt_opening_stock += $t_opening_stock;
            $gt_production += $t_production;
            $gt_invoice += $t_invoice;
            $gt_leakage += $t_leakage;
            $gt_closing_stock += $t_closing_stock;
          } //End if
        } // End For

        ?>
    </thead>
    <tr>
            <th align="left">Grand Total</th>                                    
            <th align="right"><?php echo qty_format($gt_opening_stock);?></th>
            <th align="right"><?php echo qty_format($gt_production);?></th>
            <th align="right"><?php echo qty_format($gt_invoice);?></th>
            <th align="right"><?php echo qty_format($gt_leakage);?></th>
            <th align="right"><?php echo qty_format($gt_closing_stock);?></th>
        </tr>
</table>
<br><br><br><br>
    
        <table style="border:none !important" align="center" width="750">
            <tr style="border:none !important">
            <td style="border:none !important">
            
            <span style="margin-left:550px;">Authorised Signature</span>
            </td>
            </tr>
        </table>
<div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'daily_stock_report_search';?>">Back</a>
</div>
</body>
</html>
<script type="text/javascript">
    function print_srn()
    {
        window.print(); 
    }
</script>