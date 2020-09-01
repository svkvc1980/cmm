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
    <p align="center"><b>Distributor Invoice List</b><span style="margin-left: 20px;">
    <?php if($search_data['from_date']!='') { echo 'From : '.format_date($search_data['from_date']); }?></span><span style="margin-left: 20px;">
    <?php if($search_data['to_date']!='') { echo 'To : '.format_date($search_data['to_date']); }?></span>
        </p>
     <p align="center"><?php if($search_data['distributor_id']!='') { echo 'Dealer : '.get_distributor_name($search_data['distributor_id']); } ?> 
        </p>
    <table border="1px" align="center" width="1100" cellspacing="0" cellpadding="2">
       <tr style="background-color:#cccfff">
            <th width="20">S.No</th>
            <th width="200">Invoice Number</th>
            <th width="370">Distributor</th>
            <th width="120">Quantity(Kgs)</th>
            <th width="120">Value</th>
            <th width="120">VAT/CST Amount</th>
            <th width="150">Total Value inc.VAT/CST</th>
        </tr>
        <tbody>
        <?php
            if(@$invoice_results)
            {
                $sn=1; $tot_weight = $tot_val = $tot_tax_amt = $tot_inc_tax_amt = 0;
                foreach(@$invoice_results as $row)
                { 
                    $invoice_amt = $row['invoice_amount'];
                    $tot_inc_tax_amt += $invoice_amt;
                    $value = ($invoice_amt*100)/(100+$row['vat_percent']);
                    $tax_amt = $invoice_amt - $value;
                    $tot_val += $value;
                    $tot_tax_amt += $tax_amt;
                    $tot_weight += $row['invoice_weight'];
                 ?>                                    
            <tr>
                <td><?php echo $sn++;?></td>
                <td><?php echo $row['lifting_point'].' / '.$row['invoice_number'].' / '.format_date($row['invoice_date']);?> </td>
                <td><?php echo $row['agency_name'].' ['.$row['distributor_code'].'] ['.$row['distributor_place'].']';?> </td>
                <td align="right"><?php echo qty_format($row['invoice_weight']); ?></td>
                <td align="right"><?php echo price_format($value);?> </td>
                <td align="right"><?php echo price_format($tax_amt);?> </td>
                <td align="right"><?php echo price_format($invoice_amt);?> </td>
            </tr>
            <?php
                } ?>
                <tr>
                <td colspan="3" align="right"><b>Grand Total</b></td>
                <th align="right"><?php echo qty_format($tot_weight); ?></th>
                <th align="right"><?php echo price_format($tot_val); ?></th>
                <th align="right"><?php echo price_format($tot_tax_amt); ?></th>
                <th align="right"><?php echo price_format($tot_inc_tax_amt); ?></th>
                </tr>
           <?php  }
            else
            {
                ?> <tr><td colspan="6" align="center"> No Records Found</td></tr>      
        <?php   }
            ?>
        </tbody>
    </table>
    <br>
    <div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'manage_dist_invoice';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>