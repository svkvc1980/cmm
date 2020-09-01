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
<h4 align="center">Production Consumption <span style="margin-left: 50px;">Report as on : <?php echo date('Y-m-d');?> </span></h4>
<!-- <?php echo 'Report Taken Date'.$report_date.'<br>'.'Replort as On'.$report_date;?> -->
<table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
    <thead>
        <tr>
            <th> S.No </th>
            <th> Production Date </th>
            <th> Product </th>
            <th> Production Qty</th>
            <th> Packing Material</th>
            <th> Consumed Qty</th>
            <th> Estimated Qty</th>
            <th> Accuracy </th>
        </tr>
    </thead>
    <tbody>
        <?php
        if(count($production_consumption)>0)
        {  


            $count =0 ;
            $sn_sum =0;
            $production_qty_sum =0;
            $consumed_qty_sum = 0;
            $estimated_qty_sum = 0;
            foreach($production_consumption as $row)
            {
                
                $new_production_product_id =  $row['production_product_id'];
                if($new_production_product_id == @$old_production_product_id || $count == 0 )
                { 

                    $row_span = count($con_arr[$new_production_product_id]);
                    
                ?>
                    <tr>
                        <?php if($count ==0){?>
                        <td rowspan="<?php echo $row_span;?>" > <?php echo $sn++;?> </td>
                        <input type="hidden" value="<?php echo $row['production_product_id'];?>">
                        <td rowspan="<?php echo $row_span;?>" > <?php echo date('d-m-Y',strtotime($row['production_date']));?> </td>
                        <td rowspan="<?php echo $row_span;?>" > <?php echo $row['product_name'];?> </td>
                        <td align="right" rowspan="<?php echo $row_span;?>" > <?php echo $row['production_qty'];?> </td> 
                        <?php
                        $production_qty_sum += $row['production_qty'];
                         }?>
                        <td> <?php
                        $micron_name = (@$row['mc_name']!='')?'('.@$row['mc_name'].')':'';
                         echo $row['packing_name'].' ' .@$micron_name;?> </td>
                        <td align="right" > <?php echo $row['pm_qty'];?> </td>
                        <td align="right" > <?php $estimated = qty_format(get_consumption_per_product($row['product_id'],$row['production_qty'],$row['pm_id'],$row['consumption_per_unit'],$row['mic_id']),3);
                        echo $estimated;
                        ?></td>
                       <?php
                         if($estimated !=$row['pm_qty'])
                         { ?>
                                <td>  <span class="label label-danger">Not OK</span></td>
                   <?php }
                         else
                         { ?>
                                <td> <span class="label label-success"> Ok</span></td>
                    <?php }

                       ?>
                    </tr>
                    <?php
                        $old_production_product_id = $row['production_product_id'];
                        $count =1;
                        $consumed_qty_sum += $row['pm_qty']; 
                        $estimated_qty_sum += $estimated; 

                }
                else
                {
                    $count =0;
                    $row_span = count($con_arr[$new_production_product_id]);
                    $old_production_product_id = $row['production_product_id'];
                    ?>

                    <tr>
                        <td colspan="7" > &nbsp; </td>
                    </tr>
                    <tr>
                        <?php if($count ==0){?>
                        <td rowspan="<?php echo $row_span;?>" > <?php echo $sn++;?> </td>
                         <input type="hidden" value="<?php echo $row['production_product_id'];?>">
                        <td rowspan="<?php echo $row_span;?>" > <?php echo date('d-m-Y',strtotime($row['production_date']));?> </td>
                        <td rowspan="<?php echo $row_span;?>" > <?php echo $row['product_name'];?> </td>
                        <td align="right" rowspan="<?php echo $row_span;?>" > <?php echo $row['production_qty'];?> </td>
                        <?php 
                        $production_qty_sum += $row['production_qty'];
                        } ?>
                        <td> <?php
                        $micron_name = (@$row['mc_name']!='')?'('.@$row['mc_name'].')':'';
                         echo $row['packing_name']. ''.$micron_name;?> </td>
                        <td align="right"> <?php echo $row['pm_qty'];?> </td>
                        <td align="right"> <?php $estimated = qty_format(get_consumption_per_product($row['product_id'],$row['production_qty'],$row['pm_id'],$row['consumption_per_unit'],$row['mic_id']),3);
                        echo $estimated;
                        ?></td>
                        <?php
                         if($estimated !=$row['pm_qty'])
                         { ?>
                                <td>  <span class="label label-danger">Not Ok</span></td>
                   <?php }
                         else
                         { ?>
                                <td> <span class="label label-success"> Ok</span></td>
                    <?php }

                       ?>
                    </tr>
                <?php  $count= 1;
                    $consumed_qty_sum += $row['pm_qty']; 
                    $estimated_qty_sum += $estimated; 
                 }
            } ?>
            <tr>
                        <td colspan="3" > Total </td>
                        <td align="right"> <?php echo $production_qty_sum;?></td>
                        <td> </td>
                        <td align="right"><?php echo $consumed_qty_sum;?> </td>
                        <td align="right"><?php echo $estimated_qty_sum;?> </td>
                        <?php 
                         if($consumed_qty_sum !=$estimated_qty_sum)
                         { ?>
                                <td>  <span class="label label-danger">Please Check</span></td>
                   <?php }
                         else
                         { ?>
                                <td> <span class="label label-success"> Success</span></td>
                    <?php }
                        ?>

             </tr>
            <?php

        } 
        else 
        {
        ?>  
            <tr><td colspan="10" align="center"><span class="label label-primary">No Records</span></td></tr>
        <?php   
        } ?> 
    </tbody>
</table><br>
<table border="1px" align="center" width="750" cellspacing="0" cellpadding="2" style="border: none !important">
    <tr>
        <td style="border: none !important">
            <b>This is for your kind Information</b><br>
            <b>Thanking you Sir,</b><br>
            <b>Yours faithfully,</b>
            <br><br><br><br>
            <br><b>Manager(Tech),</b><br>
            <b>OPS KAKINADA.</b>

        </td>
    </tr>
</table>
<br>
<div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'leakage_consumption';?>">Back</a>
</div>
</b>
</b>
</td>
</tr>
</thead>
</table>
</body>
</html>
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