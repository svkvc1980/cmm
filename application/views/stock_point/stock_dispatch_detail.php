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
    <table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
        <tbody>
            <tr style="background-color:#cccfff">
                <th>S.No</th>
                <th width="300">Distributor </th>
                <th width="120">Invoice No</th>
                <th width="120">DO.No</th>
                <th>Quantity(Kg's)</th>
                <th>Value(Rs)</th>
            </tr>
            <?php   $sn = 1; $total = 0; $total_weight = 0;
                if(count($distributor)>0)
                {
                    foreach($distributor as $key => $value) 
                    { 
                        $total += ($dispatches_report[$value['invoice_id']]['tot_val']);
                        $total_weight += $dispatches_report[$value['invoice_id']]['tot_qty'];

                     ?>
                       <tr>
                            <td><?php echo $sn++ ?></td>
                            <td><?php echo $value['agency_name'].' ['.$value['distributor_code'].']'; ?></td>
                            <td  align="center"><?php echo $value['invoice_number'].' / '.date('d-m-Y', strtotime($value['invoice_date']))?> </td>
                            <td align="center"><?php echo $dispatches_report[$value['invoice_id']]['do_no']?> </td>
                            <td align="right"><?php echo qty_format($dispatches_report[$value['invoice_id']]['tot_qty']); ?></td>
                            <td align="right"><?php echo price_format($dispatches_report[$value['invoice_id']]['tot_val']);?></td>
                       </tr>
            <?php   } 
            ?>
            <tr>
                <td colspan="4" align="right"><b>Total</b></td>
                <th align="right"><?php echo qty_format($total_weight); ?></th>
                <th align="right"><?php echo price_format($total); ?></th>
            </tr>
            <?php
            }
            else
            { ?>
                <tr><td colspan="6" align="center">- No Records Found -</td></tr>
           <?php  }   

            ?>
        </tbody>
    </table>
    <br><br><br><br><br><br><br>
    <table style="border:none !important" align="center" width="750">
        <tr style="border:none !important">
        <td style="border:none !important">
        
        <span style="margin-left:550px;">Authorised Signature</span>
        </td>
        </tr>
    </table>
<div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'stock_dispatch_r';?>">Back</a>
    </div>

</body>
<script type="text/javascript">
    function print_srn()
    {
        window.print(); 
    }
</script>
