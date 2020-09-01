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
<h3 align="center">Consolidated Closing Stock Report <span style="margin-left: 50px;">As On Date : <?php echo date('d-m-Y H:i:s A'); ?></span></h3>
<br>
<table border="1px" align="center" width="1050" cellspacing="0" cellpadding="2">
<tr>   
		<td align="center">sno</td>
		<td align="center">Product Code </td>
		<?php foreach ($units as $unit) { ?>
		  <td align="center"><?php echo $unit['plant_name']; ?> </td>  
		<?php } ?>
        <td align="center">Sachets[Kgs]</td>
	</tr> 
    <?php $sno=1; 
    	  $grd_pouch = 0;
    	  $grd_wt = 0;
    	  $grd_carton = array();
          $grad_wt = array();
    	  foreach ($product_results as $key =>$value)
        {   $grand_wt = 0; $grand_pouch = 0; ?>
    	
        <tr align="left"  style="background-color:#cccfff">
            <td></td>
        	<td colspan="<?php echo count($units)+2; ?>"><?php echo $value['product_name']; ?></td>
        	
        </tr>
       
        <tr>
            <?php foreach($value['sub_products'] as $keys =>$values)
            { ?>
                <td><?php echo  $sno++; ?></td> 
                <td><?php echo $values['name']; ?></td>
                <?php $pouch_count = 0; $wt_count = 0;  
                foreach ($units as $unit) 
                {  
                    if (@$closing_stock_details[$unit['plant_id']][$values['product_id']]!='') { $pouch = $closing_stock_details[$unit['plant_id']][$values['product_id']]['pouch']; } else { $pouch = 0; } 
                    $pouch_count+=$pouch;

                    if (@$closing_stock_details[$unit['plant_id']][$values['product_id']]!='') { $weight = $closing_stock_details[$unit['plant_id']][$values['product_id']]['weight']; } else { $weight = 0; } 
                    $wt_count+=$weight;

                    ?>
                	<td align="right"><?php if (@$closing_stock_details[$unit['plant_id']][$values['product_id']]!='') { echo round($closing_stock_details[$unit['plant_id']][$values['product_id']]['pouch']); } else { echo '-'; } ?></td><?php 
                } ?>
                <?php $grand_pouch += $pouch_count; $grand_wt += $wt_count; ?>
                <td align="right"><?php echo round($pouch_count).' [ '.qty_format($wt_count).' ]'; ?></td>
             </tr><?php
         
    
            } ?>
            <tr>
            <td></td>
            <td align="right"><b>Total Qty</b></td>
            <?php 
            foreach ($units as $unit) 
            {  $carton_count = 0; $carton_wt = 0;
                foreach($value['sub_products'] as $keys =>$values)
                { 
                    if (@$closing_stock_details[$unit['plant_id']][$values['product_id']]!='') { $carton = $closing_stock_details[$unit['plant_id']][$values['product_id']]['pouch']; } else { $carton = 0; }
                    $carton_count += $carton;
                    @$grd_carton[$unit['plant_id']] += $carton;


                    if (@$closing_stock_details[$unit['plant_id']][$values['product_id']]!='') { $wt = $closing_stock_details[$unit['plant_id']][$values['product_id']]['weight']; } else { $wt = 0; }
                    $carton_wt += $wt;
                    @$grad_wt[$unit['plant_id']] += $wt;

                } ?>
                <td align="right"><b><?php echo qty_format($carton_wt); ?></b></td><?php 
            }
            $grd_pouch += $grand_pouch;
            $grd_wt += $grand_wt; ?>
        <td align="right"><b><?php echo round($grand_pouch).' [ '.qty_format($grand_wt).' ]'; ?></b></td>
        </tr>
        <?php
        } ?> 
        <tr>
        <td></td>
        <td align="right"><b>Grand Total</b></td>
        <?php 
            foreach ($units as $unit) { ?>
            <!-- <td align="right"><b><?php echo round($grd_carton[$unit['plant_id']]); ?></b></td> -->
            <td align="right"><b><?php echo qty_format($grad_wt[$unit['plant_id']]); ?></b></td>
            <?php } ?>
            <td align="right"><b><?php echo round($grd_pouch).' [ '.qty_format($grd_wt).' ]'; ?></b></td>
        </tr>
</table>

<br><br><br><br>
    
        <table style="border:none !important" align="center" width="1050">
            <tr style="border:none !important">
            <td style="border:none !important">
            
            <span style="margin-left:800px;">Authorised Signature</span>
            </td>
            </tr>
        </table>
<div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL;?>">Back</a>
</div>
<script type="text/javascript">
    function print_srn()
    {
        window.print(); 
    }
</script>