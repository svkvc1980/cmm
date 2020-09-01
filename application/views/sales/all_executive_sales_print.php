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
    <h4 align="center">All Executive Sales <span style="margin-left: 50px;">From: <?php echo $from_date; ?></span>
    <span style="margin-left: 50px;">To: <?php echo $to_date; ?></span></h4>
    <table border="1px" align="center" width="900" cellspacing="0" cellpadding="2">
        <tr style="background-color:#cccfff">   
            <th width="170"> Executive name </th>
    		<?php foreach($executive_list as $key) {?>
                <th align="center"><?php echo $key['short_name']; ?></th>
            <?php } ?>
            <th>Total (Kgs)</th>
            <th> Value</th>
        </tr>
        <tr style="background-color:#cccfff">

            <?php $i = 1; foreach($executive_list as $key) {?>
                <th align="center" <?php if($i==1){ ?> width="170"<?php }?> > <?php if($i==1){ echo "Product"; } ?></th>
            <?php $i++; } ?>
            <th> </th>
            <th></th>
            <th></th>
        </tr>
        
        <?php $grand_total_kg = 0; $grand_total_amt = 0;

            foreach($loose_oil_list as $keys => $values)
            
            { $total_kg = 0; $total_amt = 0; ?>
                <tr>
                <td width="170"><?php echo $values['name'] ?></td>
                <?php
                foreach ($executive_list as $key => $value)
                { 
                    $total_kg += $pending_qty_list[$value['executive_id']][$values['loose_oil_id']]['invoice_kgs']; 
                    $total_amt += $pending_qty_list[$value['executive_id']][$values['loose_oil_id']]['invoice_amount']; 
                     ?> 
                    <td align="right"><?php echo qty_format($pending_qty_list[$value['executive_id']][$values['loose_oil_id']]['invoice_kgs']);?></td>
                <?php } 
                $grand_total_kg+=$total_kg;
                $grand_total_amt += $total_amt; ?>
                <td align="right"><?php echo qty_format($total_kg); ?></td>
                <td align="right"><?php echo price_format($total_amt); ?></td>
                    
                </tr>

        <?php 

        } ?>
        <tr>
            <td align="right"><b>Total Qty</b></td>
            <?php 
            foreach ($executive_list as $key => $value) 
            { $column_count = 0;
                foreach($loose_oil_list as $keys => $values)
                {
                    $column_count+=$pending_qty_list[$value['executive_id']][$values['loose_oil_id']]['invoice_kgs'];

                } ?>
                <td align="right"><b><?php echo qty_format($column_count); ?> </b></td>

           <?php } ?>

            <td align="right"><b><?php echo qty_format($grand_total_kg)?></b></td>
            <td align="right"><b><?php echo price_format($grand_total_amt)?></b></td>

        </tr>
        
    </table>

    <br><br><br><br><br><br><br>
    
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
    <a class="button print_element" href="<?php echo SITE_URL.'all_executive_sales_view';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>