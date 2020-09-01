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
    <h4 align="center"><?php echo get_po_status_text(@$search_params['status']);?> Purchase Orders Of Packing Materials Report</h4>
    <table border="1px" align="center" width="950" cellspacing="0" cellpadding="2">
        <tr>   
            <th>S.No</th>
            <th>PO NO</th>
            <th>OPS</th>
            <th>MTP No</th>
            <th>Supplier</th>
            <th>Unit Price</th>
            <th>PO Qty</th>
            <th>Received Qty</th>
            <th>Pending Qty</th>
        </tr> 
         
        <?php 
            if(count($print_pm_report)>0)
            {  
                $sn=1; $cur_product = ''; $tot_po_qty = $tot_rec_qty = $tot_pending_qty = 0; 
                $gt_po_qty = $gt_rec_qty = $gt_pending_qty = 0;
                foreach($print_pm_report as $row)
                {
                    if($sn>1&&$cur_product!=$row['packing_name'])
                    {
                        ?>
                        <tr><th colspan="6" align="right">Total</th><th align="right"><?php echo qty_format($tot_po_qty);?></th>
                        <th align="right"><?php echo qty_format($tot_rec_qty);?></th><th align="right"><?php echo qty_format($tot_pending_qty);?></th></tr>

                        <?php
                        $tot_po_qty = $tot_rec_qty = $tot_pending_qty = 0;
                    }
                    
                    if($cur_product!=$row['packing_name'])
                    {
                        ?>
                        <tr style="background-color:#cccfff">
                            <td></td>
                            <td colspan="8"><?php echo $row['packing_name'].' ('.$row['unit'].')'?></td>
                        </tr>
                        <?php
                    }


            ?>
                <tr>
                    <td> <?php echo $sn++;?> </td>
                    <td> <?php echo $row['po_number'].' / '.format_date($row['po_date']);?> </td>
                    <td> <?php echo $row['plant_name'];?> </td>
                    <?php if($row['mtp_number'] !='') { ?>
                      <td> <?php echo $row['mtp_number'];?> </td>
                    <?php } else { ?>
                       <td> --- </td>
                    <?php } ?>
                    <td> <?php echo $row['supplier_name'];?> </td>
                    <td align="right"> <?php echo $row['unit_price'];?> </td>
                    <td align="right"> <?php echo qty_format($row['pp_quantity']); ?></td>
                    <?php if(@$row['received_qty']!='')
                    { ?>
                    <td align="right"> <?php echo ' '. qty_format(@$row['received_qty']); ?></td>
                    <?php }
                    else
                    { ?>
                      <td align="right"><?php echo '0'; ?></td>
                    <?php } ?>

                    <td align="right"> <?php $diff_qty = ($row['pp_quantity']- @$row['received_qty']);
                    $pending_qty = ($diff_qty>0)?$diff_qty:0;
                    echo qty_format($pending_qty);
                     ?></td>
                </tr>
            <?php 
                $tot_po_qty += $row['pp_quantity'];
                $tot_rec_qty += $row['received_qty'];
                $tot_pending_qty += $pending_qty;
                $gt_po_qty += $row['pp_quantity'];
                $gt_rec_qty += $row['received_qty'];
                $gt_pending_qty += $pending_qty;
                if(($sn-1)==count($print_pm_report))
                {
                    ?>
                    <tr><th colspan="6" align="right">Total</th><th align="right"><?php echo qty_format($tot_po_qty);?></th>
                        <th align="right"><?php echo qty_format($tot_rec_qty);?></th><th align="right"><?php echo qty_format($tot_pending_qty);?></th></tr>
                        <?php
                        $tot_po_qty = $tot_rec_qty = $tot_pending_qty = 0;
                }
                $cur_product = $row['packing_name'];
                
            }
                ?>
                <tr><th colspan="6" align="right">Grand Total</th><th align="right"><?php echo qty_format($gt_po_qty);?></th>
                        <th align="right"><?php echo qty_format($gt_rec_qty);?></th><th align="right"><?php echo qty_format($gt_pending_qty);?></th></tr>
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
    <a class="button print_element" href="<?php echo SITE_URL.'pm_report';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>