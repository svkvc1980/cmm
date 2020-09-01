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
    <p align="center"><b>Stock position as on date <?php echo date('d-m-Y'); ?></b></p>
    <p align="center"><b>Unit : <?php echo $plant_name; ?></b></p>

    <br>
    <table  align="center" width="598" cellspacing="0" cellpadding="2" >
       <?php 
        $sno=1;
        $grand_total=0; $total_oil_weight = 0;
        if(count($product_results)>0)
        {
            foreach ($product_results as $key =>$value)
            {   ?>
                    <?php if($sno==1){ ?> 
                    <tr>
                        <td><b>SNO</b></td>
                        <td><b>Product Code</b></td>
                        <td align="right"><b>Price</b></td>
                        <td align="right"><b>Stock</b></td>
                        <td align="right"><b>Stock(C+P)</b></td>
                        <td align="right"><b>Value</b></td>
                    </tr>
                    <?php  } ?>
                    <tr align="center" style="background-color:#889ff3;">
                       <td></td><td colspan="5" class="black" align="left" style="color:white;"><b><?php echo $value['loose_oil']; ?></b></td>
                    </tr>
                    <?php
                    $oil_weight=0; $price = 0;
                    foreach(@$value['products'] as $keys =>$values)
                    {   
                        $qty = (@$stock_arr[$values['product_id']]['quantity']!='')?@$stock_arr[$values['product_id']]['quantity']:0;
                        $pouches=  round($qty* $values['items_per_carton']);
                        $unit_price = (@$latest_price_details[$values['product_id']]['latest_price']!='')?@$latest_price_details[$values['product_id']]['latest_price']:0;
                        $total=$unit_price*$pouches;
                        $grand_total+=$total;
                        $price += $total;
                        $oil_weight = $values['oil_weight']*$pouches;
                        $total_oil_weight += $oil_weight;
                        ?>
                        <tr>
                            <td><?php echo  $sno++; ?></td> 
                            <td><?php echo $values['product_name']; ?> </td>
                            <td align="right"><?php if(@$latest_price_details[$values['product_id']]['latest_price']!='') { echo price_format($latest_price_details[$values['product_id']]['latest_price']); } else { echo price_format(0); } ?></td>
                            <!-- <td align="right"><?php echo qty_format($values['oil_weight']);?></td> -->
                            <td align="right"><?php echo $pouches; ?></td>
                            <?php 
                            $cartons=(@$stock_arr[$values['product_id']]['quantity']!='')?@$stock_arr[$values['product_id']]['quantity']:0;
                            $cartons = floor($cartons);
                            $loose_pouches=(@$pouches%$values['items_per_carton']);
                            /*if(@$pouch_into_cartons !='')
                            {
                                $pic=floor($pouch_into_cartons);
                            }
                            else
                            {
                                $pic=0;
                            }
                            if(@$remaining_pouches !='')
                            {
                                $rp=floor($remaining_pouches);
                            }
                            else
                            {
                                $rp=0;
                            }*/ ?>
                            <td align="right"><?php echo $cartons.'+'.$loose_pouches.'('.$oil_weight.')';  ?></td>
                             <td align="right"><?php echo price_format($total); ?></td> 
                       </tr> <?php

                    
                } ?> <!-- <td colspan="6" align="right"><b>Total Value: &nbsp;</b><?php echo price_format($price); ?></td> --> <?php
                
            } 

        }
        else
        { ?>
         <p align="center"><b>No Records Found </b></p>
        <?php }
        ?>
        <!-- <tr> 
        <td colspan="6" align="right"><b>Grand Total Price: &nbsp;</b><?php echo price_format($grand_total); ?></td>   
        </tr> -->
    </table>
        <p align="center"><b>Total Stock Value: Rs. <?php echo price_format($grand_total);?></b></p>
        <p align="center"><b>Total Stock Quantity: <?php echo qty_format($total_oil_weight/1000);?> Mts</b></p>

    <div class="wrapper" style="text-align:center">
        <button class="print_element"  onclick="print_srn()">Print</button>
        <a class="button print_element" href="<?php echo SITE_URL.'home';?>">Cancel</a>
    </div>
    </form>
<script type="text/javascript">
    function print_srn()
    {
        window.print(); 
    }
</script>
</body>
</html>