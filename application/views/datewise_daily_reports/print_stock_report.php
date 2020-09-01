<br>
<h2 align="center">A.P.CO-OPERATIVE OIL SEEDS GROWER'S FEDERATION LIMITED</h2>
<h3 align="center">Daily Stock Report</h3>
<h4 align="center">Stock Report as On : <?php echo $report_date;?> </h4>
<!-- <?php echo 'Report Taken Date'.$report_date;?> -->
<table width="100%" align="center" border="1px" cellspacing="0" cellpadding="1">
    <thead>
        <tr>
            <td><b> Product <br> Type of Pack</b></td>
            <td><b>Opening Stock</b></td>
            <td><b> Production</b> </td>
            <td><b> Invoices</b> </td>
            <td><b> Closing Balance</b></td>
        </tr>
        <?php 
        foreach ($loose_oils as $loose_oil_id => $loose_oil_name)
        {
           if(count(@$daily_report[$loose_oil_id])!='' )
            {
?> 
            <tr><td align="center" style="background-color:#ccc" colspan="5"><b><?php echo $loose_oil_name;?></b></td></tr>
            <?php
                 $t_opening_stock = 0;$t_production = 0;$t_invoice =0 ; $t_closing_stock =0;
            foreach ($daily_report[$loose_oil_id] as $product_id => $values)
            { ?>
                <tr>
                    <td> <?php echo get_product_name($product_id);?></td>
                    <td align="right"> <?php echo $values['opening'];?></td>
                    <td align="right"> <?php echo $values['production'];?> </td>
                    <td align="right"> <?php echo $values['invoice'];?> </td>
                    <td align="right"> <?php echo $values['closing_balance'];?></td>
                </tr>
                
        <?php 
                //$t_qty_in_kg += ($values['opening']*get_items_per_carton($product_id)*get_oil_weight($product_id));
                $t_opening_stock += ($values['opening']*get_items_per_carton($product_id)*get_oil_weight($product_id));
                $t_production +=($values['production']*get_items_per_carton($product_id)*get_oil_weight($product_id));
                $t_invoice += ($values['invoice']*get_items_per_carton($product_id)*get_oil_weight($product_id));
                $t_closing_stock += ($values['closing_balance']*get_items_per_carton($product_id)*get_oil_weight($product_id)); 

        } ?>
        <tr>
            <td><b>Qty in Kg</b> </td>                                    
            <td align="right"><b><?php echo qty_format($t_opening_stock);?></b></td>
            <td align="right"><b><?php echo qty_format($t_production);?></b></td>
            <td align="right"><b><?php echo qty_format($t_invoice);?></b></td>
            <td align="right"><b><?php echo qty_format($t_closing_stock);?></b></td>
        </tr>

        <?php
          } //End if
        } // End For

        ?>
    </thead>
    <tbody>
    
    </tbody>
</table>
                  
<br>
<div class="row" style="text-align:center">
    <button class="button print_element"  onclick="print_srn()">Print</button>
    <a class="button" href="<?php echo SITE_URL.'daily_stock_report_search';?>">Cancel</a>
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
 
</style>