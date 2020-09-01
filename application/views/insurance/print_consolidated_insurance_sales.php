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
    <h4 align="center">Insurance Declaration <?php if($from_date !=''){ echo 'From '. format_date($from_date,$format='d-m-Y').' ' ; } if($to_date !=''){ echo ' To '. format_date($to_date,$format='d-m-Y') ; } ?> </h4>
    <table border="1px" align="center" width="950" cellspacing="0" cellpadding="2">
        <tr>   
            <th>S.No</th>
            <th>Invoice No</th>
            <th>Unit</th>
            <th>Pack</th>
            <th>Rate</th>
            <th>Quantity</th>
            <th>Value</th>
        </tr> 
         
        <?php 
            if(count($products)>0)
            {     $total_qty1= $total_value1=$total_qty2= $total_value2=0; 
                foreach ($products as $key => $value) 
                { 
                    $oil_tot_qty = $oil_tot_value = 0;
                    ?>
                     <tr>
                        <td></td>
                        <td colspan="7"><b><?php echo $value['loose_name']; ?></b></td>
                    </tr>
                    <?php
                    $sn=1; $plant_sn=1;$dist_sn=1; $cur_product = ''; $dist_qty = $plant_qty = $dist_value= $plant_value = 0;
                   
                   // print_r($value['dist_products']);exit;
                    if(count($value['dist_products'])> 0)
                    {
                    foreach(@$value['dist_products'] as $row)
                    {
                        if($dist_sn>1&&$cur_product!=$row['agency_name'])
                        {
                            ?>
                            <tr>
                                <th colspan="5" align="right">Total</th><th align="right"><?php echo qty_format($dist_qty);?></th>
                                <th align="right"><?php echo price_format($dist_value);?></th>
                            </tr>

                            <?php
                            $dist_qty = $dist_value = 0;
                        }
                        
                        if($cur_product!=$row['agency_name'])
                        {
                            ?>
                            <tr style="background-color:#cccfff">
                                <td></td>
                                <td colspan="7"><?php echo $row['agency_name'].' ('.$row['distributor_code'].')'?></td>
                            </tr>
                            <?php
                        }


                ?>
                    <tr>
                        <td> <?php $dist_sn++; echo $sn++;?> </td>
                        <td> <?php echo $row['invoice_number'].' / '.format_date($row['invoice_date']);?> </td>
                        <td> <?php echo get_plant_name_by_id($row['invoice_plant']);?> </td>
                       
                        <td> <?php echo $row['product_name'];?> </td>
                        <td align="right"> <?php echo $row['product_price'];?> </td>
                        <td align="right"> <?php echo qty_format($row['net_loss']); ?></td>
                        <td align="right"> <?php echo price_format($row['net_loss_amount']); ?></td>
                    </tr>
                <?php 
                  
                    $dist_qty += $row['net_loss'];
                    $dist_value += $row['net_loss_amount'];
                    $total_qty1 += $row['net_loss'];
                    $total_value1 += $row['net_loss_amount'];

                    $oil_tot_qty += $row['net_loss'];
                    $oil_tot_value += $row['net_loss_amount'];
                    if(($dist_sn-1)==count($value['dist_products']))
                    {
                        ?>
                        <tr>
                                <th colspan="5" align="right">Total</th><th align="right"><?php echo qty_format($dist_qty);?></th>
                                <th align="right"><?php echo price_format($dist_value);?></th>
                            </tr>

                            <?php
                            $dist_qty = $dist_value = 0;
                    }
                    $cur_product = $row['agency_name'];
                    
                    }
                }
                if(count($value['plant_products']) > 0)
                {
                    foreach(@$value['plant_products'] as $row)
                    {
                        if($plant_sn>1&&$cur_product!=$row['plant_name'])
                        {
                            ?>
                            <tr>
                                <th colspan="5" align="right">Total</th><th align="right"><?php echo qty_format($plant_qty);?></th>
                                <th align="right"><?php echo price_format($plant_value);?></th>
                            </tr>

                            <?php
                            $plant_qty = $plant_value = 0;
                        }
                        
                        if($cur_product!=$row['plant_name'])
                        {
                            ?>
                            <tr style="background-color:#cccfff">
                                <td></td>
                                <td colspan="7"><?php echo $row['plant_name']; ?></td>
                            </tr>
                            <?php
                        }


                ?>
                    <tr>
                        <td> <?php $plant_sn++; echo $sn++;?> </td>
                        <td> <?php echo $row['invoice_number'].' / '.format_date($row['invoice_date']);?> </td>
                        <td> <?php echo get_plant_name_by_id($row['invoice_plant']);?> </td>
                       
                        <td> <?php echo $row['product_name'];?> </td>
                        <td align="right"> <?php echo $row['product_price'];?> </td>
                        <td align="right"> <?php echo qty_format($row['net_loss']); ?></td>
                        <td align="right"> <?php echo price_format($row['net_loss_amount']); ?></td>
                    </tr>
                <?php 
                   
                    $plant_qty += $row['net_loss'];
                    $plant_value += $row['net_loss_amount'];
                    $total_qty2 += $row['net_loss'];
                    $total_value2 += $row['net_loss_amount'];

                    $oil_tot_qty += $row['net_loss'];
                    $oil_tot_value += $row['net_loss_amount'];
                    if(($plant_sn-1)==count($value['plant_products']))
                    {
                        ?>
                        <tr>
                                <th colspan="5" align="right">Total</th><th align="right"><?php echo qty_format($plant_qty);?></th>
                                <th align="right"><?php echo price_format($plant_value);?></th>
                            </tr>

                            <?php
                            $plant_qty = $plant_value = 0;
                    }
                    $cur_product = $row['plant_name'];
                    
                    }
                } 

                ?>
                <tr>
                    <th colspan="5" align="right"><?php echo $value['loose_name'];?> Product Total</th>
                    <th align="right"><?php echo qty_format($oil_tot_qty);?></th>
                    <th align="right"><?php echo price_format($oil_tot_value);?></th>
                </tr>
                <?php
            } // end of loose oil loop
                    ?>
                     <tr>
                            <th colspan="5" align="right">Grand Total</th><th align="right"><?php echo qty_format($total_qty1+$total_qty2);?></th>
                            <th align="right"><?php echo price_format($total_value1+$total_value2);?></th>
                            </tr>
                    <?php
                }
           else
            { ?>
            
            <tr><td colspan="9" align="center">-No Records Found- </td></tr>
            <?php }?>

        
    </table>

    <br><br><br><br><br><br><br>
    
        <table style="border:none !important" align="center" width="750">
            <tr style="border:none !important">
            <td style="border:none !important">
            
            
            </td>
            </tr>
        </table>
    <br><br><br><br><br>
    <div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'consolidated_insurance_sales';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>