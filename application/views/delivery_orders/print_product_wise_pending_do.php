<!DOCTYPE html>
<html>
<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <form  role="form" method="post" action="">
    <br>
    <h2 align="center">AP Cooperative Oilseeds Growers Federation Ltd</h2>
    <p align="center"><b>Productwise Pending DO From <?php echo $search_params['fromDate'];?> TO <?php echo $search_params['toDate'];?>, <?php echo $plant_name;?></b></p>

    <br>
    <table  align="center" width="750" cellspacing="0" cellpadding="2" >
       <?php 
        $sno=1;
        $tot_cartons = $tot_packets = $tot_weight = $tot_value = 0;
        if(count($loose_oils)>0)
        {
            foreach ($loose_oils as $lrow)
            {   ?>
                    <?php if($sno==1){ ?> 
                    <tr>
                        <td><b>Product Name</b></td>
                        <td ><b>Cartons</b></td>
                        <td ><b>Packets</b></td>
                        <td ><b>Qty in Kgs</b></td>
                        <td ><b>Value</b></td>
                    </tr>
                    <?php  } ?>
                    <tr align="center" style="background-color:#889ff3;">
                       <td colspan="5" class="black" align="left" style="color:white;"><b><?php echo $lrow['name']; ?></b></td>
                    </tr>
                    <?php
                    $cartons = $packets = $weight = $value = 0;
                    if(count(@$do_results[@$lrow['loose_oil_id']])>0)
                    {
                        foreach(@$do_results[@$lrow['loose_oil_id']] as $dop_row)
                        {   
                            $cartons += $dop_row['cartons'];
                            $packets += round($dop_row['packets']);
                            $weight += $dop_row['qty_in_kgs'];
                            $value += $dop_row['value_in_rupees'];
                            ?>
                            <tr>
                                <td><?php echo $dop_row['product_name']; ?> </td>
                                <td align="right"><?php echo round($dop_row['cartons']); ?> </td>
                                <td align="right"><?php echo round($dop_row['packets']); ?> </td>
                                <td align="right"><?php echo qty_format($dop_row['qty_in_kgs']); ?> </td>
                                <td align="right"><?php echo price_format($dop_row['value_in_rupees']); ?> </td>
                           </tr> <?php

                        
                        } 
                        $tot_cartons += $cartons;
                        $tot_packets += $packets;
                        $tot_weight += $weight;
                        $tot_value += $value;
                    }?> 
                <tr>
                    <th>Total in Qtys</th>
                    <th align="right"><?php echo $cartons;?></th>
                    <th align="right"><?php echo $packets;?></th>
                    <th align="right"><?php echo qty_format($weight);?></th>
                    <th align="right"><?php echo price_format($value);?></th>
                </tr>
                 <?php
                $sno++;
            } 

        }
        else
        { ?>
         <p align="center"><b>No Records Found </b></p>
        <?php }
        ?>
        <tr>
            <th>Grand Total</th>
            <th align="right"><?php echo $tot_cartons;?></th>
            <th align="right"><?php echo $tot_packets;?></th>
            <th align="right"><?php echo qty_format($tot_weight);?></th>
            <th align="right"><?php echo price_format($tot_value);?></th>
        </tr>
    </table>
    <br>
    <div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'product_wise_pending_do';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>