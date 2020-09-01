<!DOCTYPE html>
<html>
<head>
    <title>Po Oils Print</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 
</head>
<body>
    <h2 align="center">AP Cooperative Oilseeds Growers Federation Ltd</h2>
    <h4 align="center">Purchase Order for Oils Report <span style="margin-left:50px;"><?php if($search_params['start_date']!='') { echo 'From : '.format_date($search_params['start_date']); } ?></span><span style="margin-left:10px;"><?php if($search_params['end_date']!='') { echo 'To : '.format_date($search_params['end_date']); } ?></span></h4>
    <h4 align="center"><?php if($search_params['status']!='') { echo 'Status : '.get_po_status_value($search_params['status']); } ?> </h4>
    <table border="1px" align="center" width="1050" cellspacing="0" cellpadding="2">
        <tr>   
            <th>S.No</th>
            <th>Loose Oil</th>
            <th>PO NO / PO Date</th>
            <th>OPS</th>
            <th>MTP No</th>
            <th>Broker</th>
            <th>Supplier</th>
            
            <th>Price Per Unit</th>
            <th>PO Qty</th>
            <th>Received Qty</th>
            <th>Pending Qty</th>
            
        </tr> 
         
        <?php 
            if(count($lor)>0)
            {  
                $sn=1; $gt_po_qty = $gt_received_qty = $gt_pending_qty = 0;
                foreach($lor as $key =>$value)
                  {  $rec_qty=0;
                     $quoted_qty=0;
                     $pending_qty=0; ?>
                    <tr style="background-color:#cccfff">
                        <td></td>
                        <td colspan="12" align="left" > <?php echo $value['loose_oil'];?> </td>
                    </tr>
                   <?php 
                    foreach($value['products'] as $k1 =>$row)
                     {  $rec_qty+=$row['received_qty'];
                        $quoted_qty+=$row['quoted_qty'];
            ?>
                <tr>
                    <td > <?php echo $sn++;?> </td>
                    <td > <?php echo $row['loose_short_name'];?> </td>
                    <td > <?php echo $row['po_number'].' / '. date('d-m-Y',strtotime($row['po_date'])) ;?> </td>
                    <td > <?php echo $row['plant_name'];?> </td>
                    <?php if($row['mtp_number'] !='') { ?>
                      <td> <?php echo $row['mtp_number'];?> </td>
                    <?php } else { ?>
                       <td> --- </td>
                    <?php } ?>
                   <td > <?php echo $row['broker_name'];?> </td>
                    <td > <?php echo $row['supplier_name'];?> </td>
                    <td  align="right"> <?php echo price_format($row['unit_price']);?> </td>
                    <td align="right" > <?php echo qty_format($row['quoted_qty']); ?></td>
                    <?php if($row['received_qty']!='')
                    { ?>
                    <td align="right" > <?php echo qty_format($row['received_qty']); ?></td>
                    <?php }
                    else
                    { ?>
                      <td align="right" > 0 </td>
                    <?php } ?>
                    <td align="right" > <?php $pen_qty=$row['quoted_qty']-$row['received_qty']; if($pen_qty > 0 ) { $pending_qty+=$pen_qty; echo qty_format($pen_qty); } else  { echo 0; } ?></td>
                  
                </tr>
            <?php 
            }  ?> 
            <tr>
            <td colspan="8" align="right"><b>Total</b></td>
            <td align="right"><b><?php echo qty_format($quoted_qty) ;?></b></td>
             <td align="right"><b><?php echo qty_format($rec_qty) ;?></b></td>
             <td align="right"><b><?php echo qty_format($pending_qty) ;?></b></td>
            </tr>
           <?php
                    $gt_po_qty += $quoted_qty;
                    $gt_received_qty += $rec_qty;
                    $gt_pending_qty += $pending_qty;
             }
             ?>
             <tr>
                <td colspan="8" align="right"><b>Grand Total</b></td>
                <td align="right"><b><?php echo qty_format($gt_po_qty) ;?></b></td>
                <td align="right"><b><?php echo qty_format($gt_received_qty) ;?></b></td>
                <td align="right"><b><?php echo qty_format($gt_pending_qty) ;?></b></td>
            </tr>
             <?php
            }
           else
            { ?>
            
            <tr><td colspan="14" align="center">-No Records Found- </td></tr>
            <?php }?>

        
    </table>
    <br><br><br><br><br>
    
        <table style="border:none !important" align="center" width="750">
            <tr style="border:none !important">
            <td style="border:none !important">
            
            <span style="margin-left:550px;">Authorised Signature</span>
            </td>
            </tr>
        </table>
    
    <div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'loose_oil_report';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>