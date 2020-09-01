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
    <p align="center"><b>Unit Invoice List</b><span style="margin-left: 20px;">
    <?php if($search_data['from_date']!='') { echo 'From : '.format_date($search_data['from_date']); }?></span><span style="margin-left: 20px;">
    <?php if($search_data['to_date']!='') { echo 'To : '.format_date($search_data['to_date']); }?></span>
        </p>
     <p align="center"><?php if($search_data['plant_id']!='') { echo 'Unit : '.get_plant_name_by_id($search_data['plant_id']); } ?> 
        </p>
    <table border="1px" align="center" width="890" cellspacing="0" cellpadding="2">
       <tr style="background-color:#cccfff">
            <th width="20">S.No</th>
            <th width="200">Invoice Number</th>
            <th width="370">Unit</th>
            <th width="150">Quantity (Kgs)</th>
            <th width="150">Total Value</th>
        </tr>
        <tbody>
        <?php
            if(@$invoice_results)
            {
                $sn=1; $tot_weight = $total = 0;
            foreach(@$invoice_results as $row)
                { 
                $total += $row['invoice_amount']; 
                $tot_weight += $row['invoice_weight'];
                ?>                                    
            <tr>
                <td><?php echo $sn++;?></td>
                <td><?php echo $row['lifting_point'].' / '.$row['invoice_number'].' / '.format_date($row['invoice_date']);?> </td>
                <td><?php echo $row['plant_name'];?> </td>
                <td align="right"><?php echo qty_format($row['invoice_weight']); ?></td>
                <td align="right"><?php echo price_format($row['invoice_amount']);?> </td>
            </tr>
            <?php
                } ?>
                <tr>
                <td colspan="3" align="right"><b>Total</b></td>
                <th align="right"><?php echo qty_format($tot_weight); ?></th>
                <td align="right"><b><?php echo price_format($total); ?></b></td>
                </tr>
           <?php  }
            else
            {
                ?> <tr><td colspan="4" align="center"> No Records Found</td></tr>      
        <?php   }
            ?>
        </tbody>
    </table>
    <br>
    <div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'manage_plant_invoice';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>