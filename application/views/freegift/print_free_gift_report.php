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
    <h4 align="center">Purchase Order for Free Gifts Report</h4>
    <table border="1px" align="center" width="950" cellspacing="0" cellpadding="2">
        <tr>   
            <th>S.No</th>
            <th>PO NO</th>
            <th>Supplier</th>
            <th>Unit Price</th>
            <th>PO Qty</th>
            <th>Received Qty</th>
            <th>Pending Qty</th>
        </tr> 
         
        <?php 
            if(count($free_gift_results)>0)
            {  
                $sn=1; $cur_product = ''; $tot_po_qty = $tot_rec_qty = $tot_pending_qty = 0; 
                $gt_po_qty = $gt_rec_qty = $gt_pending_qty = 0;
                foreach($free_gift_results as $row)
                {
                    if($sn>1&&$cur_product!=$row['free_gift_name'])
                    {
                        ?>
                        <tr><th colspan="4" align="right">Total</th><th align="right"><?php echo ($tot_po_qty);?></th>
                        <th align="right"><?php echo ($tot_rec_qty);?></th><th align="right"><?php echo ($tot_pending_qty);?></th></tr>

                        <?php
                        $tot_po_qty = $tot_rec_qty = $tot_pending_qty = 0;
                    }
                    
                    if($cur_product!=$row['free_gift_name'])
                    {
                        ?>
                        <tr style="background-color:#cccfff">
                            <td></td>
                            <td colspan="6"><?php echo $row['free_gift_name']?></td>
                        </tr>
                        <?php
                    }
            ?>
                <tr>
                    <td> <?php echo $sn++;?> </td>
                    <td> <?php echo $row['po_number'].' / '.format_date($row['po_date']);?> </td>
                    <td> <?php echo $row['supplier_name'];?> </td>
                    <td align="right"> <?php echo $row['unit_price'];?> </td>
                    <td align="right"> <?php echo ($row['quantity']); ?></td>
                    <?php if(@$row['received_qty']!='')
                    { ?>
                    <td align="right"> <?php echo ' '. (@$row['received_qty']); ?></td>
                    <?php }
                    else
                    { ?>
                      <td align="right"><?php echo '0'; ?></td>
                    <?php } ?>

                    <td align="right"> <?php $diff_qty = ($row['quantity']- @$row['received_qty']);
                    $pending_qty = ($diff_qty>0)?$diff_qty:0;
                    echo ($pending_qty);
                     ?></td>
                </tr>
            <?php 
                $tot_po_qty += $row['quantity'];
                $tot_rec_qty += @$row['received_qty'];
                $tot_pending_qty += $pending_qty;
                $gt_po_qty += $row['quantity'];
                $gt_rec_qty += @$row['received_qty'];
                $gt_pending_qty += $pending_qty;
                if(($sn-1)==count($free_gift_results))
                {
                    ?>
                    <tr><th colspan="4" align="right">Total</th><th align="right"><?php echo ($tot_po_qty);?></th>
                        <th align="right"><?php echo ($tot_rec_qty);?></th><th align="right"><?php echo ($tot_pending_qty);?></th></tr>
                        <?php
                        $tot_po_qty = $tot_rec_qty = $tot_pending_qty = 0;
                }
                $cur_product = $row['free_gift_name'];
            }
            ?>
                <tr><th colspan="4" align="right">Grand Total</th><th align="right"><?php echo ($gt_po_qty);?></th>
                        <th align="right"><?php echo ($gt_rec_qty);?></th><th align="right"><?php echo ($gt_pending_qty);?></th></tr>
                <?php
            }
           else
            { ?>
            <tr><td colspan="14" align="center">-No Records Found- </td></tr>
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
    <a class="button print_element" href="<?php echo SITE_URL.'freegift_po_list';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>