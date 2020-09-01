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
    <h4 align="center"><span style="margin-left:50px;"><?php if($ops!='') { echo $ops; } ?></span> Processing Loss Perticulars <span style="margin-left:50px;"><?php if($from_date!='') { echo 'From '.format_date($from_date); } ?></span><span style="margin-left:10px;"><?php if($to_date!='') { echo ' To '.format_date($to_date); } ?></span></h4>
    <table border="1px" align="center" width="500" cellspacing="0" cellpadding="2">
        <tr>   
            <th>S.No</th>
            <th>Date</th>
            <th>OPS</th>
            <th>Quantity(KGs)</th>
        </tr> 
         
        <?php 
            if(count($processing_loss_results)>0)
            {  
                $total_qty = 0;
                $grand_tot_qty = 0;
                $sn=1; $cur_product = '';
                foreach($processing_loss_results as $row)
                {
                    $product_name = $row['loose_oil_name'];
                    if($sn>1&&$cur_product!=$product_name)
                    {
                        ?>
                        <tr><th  colspan="3" align="right">Total</th>
                        <th align="right"><?php echo qty_format($total_qty);?></th></tr>
                        <?php
                        $total_qty = 0;
                    }
                    
                    if($cur_product!=$product_name)
                    {
                        ?>
                        <tr style="background-color:#cccfff">
                            <td></td>
                            <td colspan="3"><?php echo $product_name?></td>
                            
                        </tr>
                        <?php
                    }
                    $qty = qty_format($row['quantity']);
            ?>
                <tr>
                    <td><?php echo $sn++;?></td>
                    <td> <?php echo format_date($row['on_date']);?> </td>
                    <td><?php echo $row['plant'];?> </td>
                    <td align="right"> <?php echo qty_format($qty);?> </td>
                </tr>
            <?php 
                $total_qty += $row['quantity'];
                $grand_tot_qty += $row['quantity'];
                if(($sn-1)==count($processing_loss_results))
                {
                    ?>
                        <tr><th colspan="3" align="right">Total</th>
                        <th align="right"><?php echo qty_format($total_qty);?></th>
                        </tr>
                        
                        <?php
                        $total_qty = 0;
                }
                $cur_product = $product_name;
            }
                ?>
                <tr>
                    <th colspan="3" align="right">Grand Total</th>
                    <th align="right"><?php echo qty_format($grand_tot_qty);?></th>
                </tr>
                <?php
            }
           else
            { ?>
            
            <tr><td colspan="4" align="center">-No Records Found- </td></tr>
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
    <button class="button print_element" style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'processing_loss_report';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>