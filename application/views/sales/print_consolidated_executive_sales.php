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
<h3 align="center">Consolidated Executive Sales Report<span style="margin-left:50px;">From : <?php echo $from_date; ?></span><span style="margin-left:10px;">To : <?php echo $to_date; ?></span></h3>
<br>
<table border="1px" align="center" width="1050" cellspacing="0" cellpadding="2">
<tr>   
        <th align="center">Sno</th>
        <th align="center">Product Code </th>
        <?php foreach ($units as $unit) { ?>
          <th align="center"><?php echo $unit['short_name']; ?> </th>  
        <?php } ?>
        <th align="center">Sachets[Kgs]</th>
        <th align="center">Sales Value</th>
    </tr> 
    <?php $sno=1; 
          $grd_amount = 0; 
          $grd_pouch = 0; 
          $grd_wt = 0;
          $grd_p = array(); $executive_gt_wts = array();
          foreach ($product_results as $key =>$value)
        {   $grand_wt = 0; $grand_amount = 0; $grand_pouch = 0; $executive_wts = array();?>
        
        <tr align="left"  style="background-color:#cccfff">
            <td></td>
            <td colspan="<?php echo count($units)+3; ?>"><?php echo $value['product_name']; ?></td>
            
        </tr>
       
        <tr>
            <?php foreach($value['sub_products'] as $keys =>$values)
            { ?>
                <td><?php echo  $sno++; ?></td> 
                <td><?php echo $values['name']; ?></td>
                <?php $pouch_count = 0; $wt_count = 0; $amount_count = 0;  
                foreach ($units as $unit) 
                {  
                    if (@$sales_details[$unit['executive_id']][$values['product_id']]!='') { $pouch = $sales_details[$unit['executive_id']][$values['product_id']]['pouch']; } else { $pouch = 0; } 
                    $pouch_count+=$pouch;

                    if (@$sales_details[$unit['executive_id']][$values['product_id']]!='') { $weight = $sales_details[$unit['executive_id']][$values['product_id']]['weight']; } else { $weight = 0; } 
                    $wt_count+=$weight;

                    $executive_wts[$unit['executive_id']][]= $weight;

                    if (@$sales_details[$unit['executive_id']][$values['product_id']]!='') { $amount = $sales_details[$unit['executive_id']][$values['product_id']]['amount']; } else { $amount = 0; } 
                    $amount_count+=$amount;

                    ?>
                    <td align="right"><?php if (@$sales_details[$unit['executive_id']][$values['product_id']]!='') { echo round($sales_details[$unit['executive_id']][$values['product_id']]['pouch']); } else { echo '-'; } ?></td><?php 
                } ?>
                <?php $grand_amount += $amount_count; $grand_pouch += $pouch_count; $grand_wt += $wt_count; ?>
                <td align="right"><?php echo $pouch_count.' [ '.qty_format($wt_count).' ]'; ?></td>
                <td align="right"><?php echo price_format($amount_count); ?> </td>
             </tr><?php
         
    
            } ?>
            <tr>
            <td></td>
            <td align="right"><b>Total Qty in Kgs</b></td>
            <?php 
            foreach ($units as $unit) 
            {  /*$carton_count = 0;
                foreach($value['sub_products'] as $keys =>$values)
                { 
                    if (@$sales_details[$unit['executive_id']][$values['product_id']]!='') { $carton = $sales_details[$unit['executive_id']][$values['product_id']]['pouch']; } else { $carton = 0; }
                    $carton_count += $carton;
                    @$grd_p[$unit['executive_id']] += $carton;

                }*/ 
                $tot_wt = array_sum($executive_wts[$unit['executive_id']]);
                $executive_gt_wts[$unit['executive_id']][] = $tot_wt;
                ?>
                <td align="right"><b><?php echo qty_format($tot_wt); ?></b></td><?php 
            } $grd_amount += $grand_amount; 
              $grd_wt += $grand_wt; 
              $grd_pouch += $grand_pouch; ?> 
        <td align="right"><b><?php echo $grand_pouch.' [ '.qty_format($grand_wt).' ]'; ?></b></td>
        <td align="right"><b><?php echo price_format($grand_amount); ?></b></td>
        </tr>
        <?php
        }
         ?>
         <tr><td></td> <td align="right"><b>Grand Total</b></td> 
          <?php 
            foreach ($units as $unit) { 
                $gt_wt = array_sum($executive_gt_wts[$unit['executive_id']]);
                ?>
            <td align="right"><b><?php echo qty_format($gt_wt); ?></b></td> <?php }?>
            
            <td align="right"><b><?php echo $grd_pouch.' [ '.qty_format($grd_wt).' ]'; ?></b></td>
            <td align="right"><b><?php echo price_format($grd_amount); ?></b></td>
          </tr>
</table>

<br><br><br><br>
    
        <table style="border:none !important" align="center" width="750">
            <tr style="border:none !important">
            <td style="border:none !important">
            
            <span style="margin-left:550px;">Authorised Signature</span>
            </td>
            </tr>
        </table>
<div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'consolidated_executive_sales_view';?>">Back</a>
</div>
<script type="text/javascript">
    function print_srn()
    {
        window.print(); 
    }
</script>