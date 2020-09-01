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
    <h4 align="center">Lab Test Report for Packing Material <span style="margin-left:50px;"><?php if($search_params['start_date']!='') { echo 'From : '.format_date($search_params['start_date']); } ?></span><span style="margin-left:10px;"><?php if($search_params['end_date']!='') { echo 'To : '.format_date($search_params['end_date']); } ?></span></h4>
    <table border="1px" align="center" width="1050" cellspacing="0" cellpadding="2">
        <tr>   
            <th>S.No</th>
            <th>PO NO</th>
            <th>Test Number</th>
            <th>Invoice/DC No</th>
            <th>Supplier</th>
            <th>Unit Price</th>
            <th>Received Qty</th>
            <th>Value</th>
            <th>Result</th>
        </tr> 
         
        <?php 
            if(count($lab_test_pm_report)>0)
            {  
                $sn=1;$cur_product = '';$total_received_qty = $total_received_value = $gt_rec_qty = $gt_rec_val = 0;
                foreach($lab_test_pm_report as $row)
                {
                    $product_name = $row['packing_material'];
                    if($sn>1&&$cur_product!=$product_name)
                    {
                        ?>
                        <tr><th colspan="6" align="right">Total</th>
                        <th align="right"><?php echo ($total_received_qty);?></th><th align="right"><?php echo ($total_received_value);?></th></tr>

                        <?php
                        $total_received_qty = $total_received_value = 0;
                    }
                    
                    if($cur_product!=$product_name)
                    {
                        ?>
                        <tr style="background-color:#cccfff">
                            <td></td>
                            <td colspan="8"><?php echo $product_name.' ('.$row['unit'].')'?></td>
                        </tr>
                        <?php
                    }
                    $received_qty = ($row['test_status']==1)?($row['received_qty']):0;
                    if($row['pm_category_id']==get_film_category_id())
                    {
                        $received_qty -= $row['no_of_rolls']*$row['core_carton_weight'];
                    }
                    $value = ($row['test_status']==1)?($received_qty*$row['unit_price']):0;
            ?>
                <tr>
                    <td width="45"> <?php echo $sn++;?> </td>
                    <td width="45"> <?php echo $row['po_number'];?> </td>
                    <td width="150"> <?php echo $row['test_number'].' / '.format_date($row['test_date']);?> </td>
                    <td width="120"> <?php echo ($row['invoice_number']!='')?$row['invoice_number']:$row['dc_number'];?> </td>
                    <td width="250"> <?php echo $row['s_agency'];?> </td>
                    <td width="65" align="right"> <?php echo price_format($row['unit_price']);?> </td>
                    <td width="70" align="right"> <?php echo $received_qty;?> </td>
                    <td width="125" align="right"> <?php echo price_format($value);?> </td>
                    <td width="35">
                        <?php
                            if($row['test_status']==1)
                            {
                                echo "<span class='label label-success'>Pass</span>";
                            }
                            else
                            {
                                echo "<span class='label label-danger'>Fail</span>";
                            }
                        ?>
                    </td>
                </tr>
            <?php 
                $total_received_qty += $received_qty;
                $total_received_value += price_format($value);
                $gt_rec_qty += $received_qty;
                $gt_rec_val += price_format($value);
                if(($sn-1)==count($lab_test_pm_report))
                {
                    ?>
                        <tr><th colspan="6" align="right">Total</th>
                        <th align="right"><?php echo ($total_received_qty);?></th>
                        <th align="right"><?php echo price_format($total_received_value);?></th></tr>

                        <?php
                        $total_received_qty = $total_received_value = 0;
                }
                $cur_product = $product_name;
            }
            ?>
                <tr>
                    <th colspan="6" align="right">Grand Total</th>
                    <th align="right"><?php echo $gt_rec_qty;?></th>
                    <th align="right"><?php echo price_format($gt_rec_val);?></th>
                    <td></td>
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
    <a class="button print_element" href="<?php echo SITE_URL.'pm_test_r';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>