<!DOCTYPE html>
<html>
<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <h2 align="center">AP Cooperative Oilseeds Growers Federation Ltd</h2>
    <p align="center"><b>Godown stock report as on date <?php echo date('d-m-Y',strtotime($start_date)); ?></b></p>
    <p align="center"><b>Unit : <?php echo $plant_name; ?></b></p>
    <table border="1px" align="center" width="730" cellspacing="0" cellpadding="2">
        <tr>   
    		<th rowspan="2" width="250">Product [Oil Wt]</th>
    		<th rowspan="2" width="56">Opening Stock</th>
            <th rowspan="1" colspan="<?php echo count($units)+1;?>" > Receipts </th>
            
            <th rowspan="2" width="62"> Invoice Sales </th>
            <th rowspan="2" width="46"> Stock To Counter </th>
            <th rowspan="2" width="44"> Free Samples </th>
            <th rowspan="2" width="42"> Leakage </th>
            <th rowspan="2" width="56"> Closing Stock</th>
        </tr>
        <tr>
    		<?php foreach ($units as $unit) { ?>
    		<th rowspan="1" width="65"><?php echo $unit['short_name']; ?> </th> 
    	
    	  <?php } ?> 
            <th rowspan="1" width="34"> PROD </th>
        </tr>
        <?php 

        $gt_opening_stock = $gt_production = $gt_invoice =  $gt_stc = $gt_free = $gt_leakage = $gt_closing = 0;
        $gt_receits = array();
        foreach ($product_results as $key =>$value)
           {  $sno=1; 
              $total_opening_stock=0;
              $receipts=array();
              $production=0;
              $invoice=0;
              $stc=0;
              $free=0;
              $leakage=0;
              $closing=0;
                ?>
        	
            <tr align="left"  style="background-color:#cccfff">
                <td colspan="<?php echo count($units)+8; ?>"><b><?php echo $value['loose_oil']; ?></b></td>
            	
            </tr>
           
           
                <?php  foreach($value['products'] as $keys =>$values)
                  { ?>
                   <tr>
                    <td><?php echo $values['product_name']; ?></td>
                    <td align="right">
                    <?php 
                    // Current Stock
                    $opening_stock=@$present_stock[$values['product_id']]['opening_stock'];
                    // (-) receipt stock
                    $opening_stock-= @$present_stock[$values['product_id']]['receipt_stock'];
                    // (-) production weight
                    $opening_stock -= @$present_stock[$values['product_id']]['tot_production_weight'];
                    // (+) Invoice Stock
                    $opening_stock+= @$present_stock[$values['product_id']]['invoice_stock'];
                    // (+)  leakage stock
                    $opening_stock+= @$present_stock[$values['product_id']]['leakage_stock']; 

                    // (+)Current Stock in pouches
                    $pouch_opening_stock=@$present_stock[$values['product_id']]['pouch_opening_stock'];
                    //echo $pouch_opening_stock.'--';
                    // (-)pouches received
                    $pouch_opening_stock-=@$present_stock[$values['product_id']]['pouch_receipt_stock'];
                    // (-) production
                    if(@$present_stock[$values['product_id']]['tot_production_qty']!='')
                    $pouch_opening_stock-= @$present_stock[$values['product_id']]['tot_production_qty'];
                    //echo $pouch_opening_stock.'--';
                    // (+)Invoice qty in pouches
                    $pouch_opening_stock+=@$present_stock[$values['product_id']]['pouch_invoice_stock'];
                    //echo $pouch_opening_stock.'--';
                    // (+)pouches received
                    $pouch_opening_stock+=@$present_stock[$values['product_id']]['pouch_leakage_stock'];
                    //echo $pouch_opening_stock.'--';
                    // (+)pouches received
                    $pouch_opening_stock+=round(@$present_stock[$values['product_id']]['pouch_search_day_free_qty']);
                    //$pouch_opening_stock.'--';

                    $pouch_into_cartons=(@$pouch_opening_stock/$values['items_per_carton']);
                    $remaining_pouches=(@$pouch_opening_stock%$values['items_per_carton']);
                    if($pouch_into_cartons !='')
                    {
                        $pic=floor($pouch_into_cartons);
                    }
                    else
                    {
                        $pic=0;
                    }
                    if($remaining_pouches !='')
                    {
                        $rp= ($remaining_pouches);
                    }
                    else
                    {
                        $rp=0;
                    }
                    if($pouch_opening_stock !='') { echo round($pouch_opening_stock) ; }  else { echo 0 ; } 
                    //echo ' ('.$pic.' + '.$rp.' )'; 
                    $receipt_qty=0; $receipt_qty_oil=0; ?></td> 
                    <?php 
                    $total_opening_stock+=(round($pouch_opening_stock)*$values['oil_weight']);
                    foreach ($units as $unit) { 
                         if (@$stock_received[$unit['plant_id']][$values['product_id']]['pouches']!='') { $receipt_pouch_qty = $stock_received[$unit['plant_id']][$values['product_id']]['pouches']; } else { $receipt_pouch_qty = 0; } 
                        @$receipts[$unit['plant_id']]+=($receipt_pouch_qty*$values['oil_weight']);
                        $receipt_qty+=@$stock_received[$unit['plant_id']][$values['product_id']]['pouches']; 
                        $receipt_qty_oil+=@$stock_received[$unit['plant_id']][$values['product_id']]['oil_weight']; 
                        ?>
                    <td align="right"><?php echo $receipt_pouch_qty; ?></td>
                    <?php } ?>
                	<td align="right">
                	<?php if (@$present_stock[$values['product_id']]['pouch_production_qty']!='') { $prod_pouch_qty = $present_stock[$values['product_id']]['pouch_production_qty']; } else {  $prod_pouch_qty = 0; } 
                       $production += ($prod_pouch_qty*$values['oil_weight']);
                       echo $prod_pouch_qty; ?></td>
                     <td align="right"><?php if (@$present_stock[$values['product_id']]['pouch_curr_invoice_qty']!='') { $invoice_po_qty =  $present_stock[$values['product_id']]['pouch_curr_invoice_qty']; } else { $invoice_po_qty = 0; }
                     $invoice += ($invoice_po_qty*$values['oil_weight']);
                     echo $invoice_po_qty; ?></td>
                    <td align="right"><?php if (@$present_stock[$values['product_id']]['pouch_curr_gst_qty']!='') { $stock_pouch_qty = $present_stock[$values['product_id']]['pouch_curr_gst_qty']; } else { $stock_pouch_qty = 0; }
                    $stc += ($stock_pouch_qty*$values['oil_weight']);
                    echo $stock_pouch_qty; ?></td>
                    <td align="right"><?php if (@$present_stock[$values['product_id']]['pouch_curr_free_qty']!='') { $free_pouch_qty = $present_stock[$values['product_id']]['pouch_curr_free_qty']; } else { $free_pouch_qty = 0; } 
                    $free += ($free_pouch_qty*$values['oil_weight']);
                    echo $free_pouch_qty; ?></td>
                     <td align="right"><?php if (@$present_stock[$values['product_id']]['curr_pouch_leakage_qty']!='') { $leakage_pouch_qty =  $present_stock[$values['product_id']]['curr_pouch_leakage_qty']; } else { $leakage_pouch_qty = 0; }
                     $leakage += ($leakage_pouch_qty*$values['oil_weight']);
                     echo $leakage_pouch_qty; ?></td>
                     
                     
                     <?php
                      $closing_stock=@$pouch_opening_stock+@$receipt_qty+@$present_stock[$values['product_id']]['pouch_production_qty']-@$present_stock[$values['product_id']]['pouch_curr_invoice_qty']-@$present_stock[$values['product_id']]['pouch_curr_gst_qty']-@$present_stock[$values['product_id']]['pouch_curr_free_qty']-@$present_stock[$values['product_id']]['curr_pouch_leakage_qty'];
                      $closing_pouches_into_cartons=(@$closing_stock/$values['items_per_carton']);
                      $closing_remaining_cartons=(@$closing_stock%$values['items_per_carton']);
                        if($closing_pouches_into_cartons !='')
                        {
                            $cpic=$closing_pouches_into_cartons;
                        }
                        else
                        {
                            $cpic=0;
                        }
                        if($closing_remaining_cartons !='')
                        {
                            $crc=$closing_remaining_cartons;
                        }
                        else
                        {
                            $crc=0;
                        }
                     ?>
                     
                    <td align="right"><?php if($closing_stock !='') { echo round($closing_stock) ; }  else { echo 0 ; } 
                     ?></td> 
             </tr>
        <?php                                                                           
            
        } ?>
        <tr>
        <th align="right">Qty in Kgs</th>
        <th align="right"><?php echo qty_format($total_opening_stock);?></th>
         <?php $rec_value = 0; foreach($receipts as $key =>$value) 
         {  $rec_value+=$value; ?> 
         <th align="right"><?php  echo qty_format(@$value); ?></th> 
         <?php
            @$gt_receits[$key] += qty_format($value);
          } ?>
         <th align="right"><?php echo qty_format($production);?></th>
         <th align="right"><?php echo qty_format($invoice);?></th>
         <th align="right"><?php echo qty_format($stc);?></th>
         <th align="right"><?php echo qty_format($free);?></th>
         <th align="right"><?php echo qty_format($leakage);?></th>
         <th align="right"><?php $closing = $total_opening_stock+$rec_value+$production-$invoice-$stc-$free-$leakage; echo qty_format($closing);?></th>
        </tr> 
        <?php 
        $gt_opening_stock += qty_format($total_opening_stock);
        $gt_production += qty_format($production);
        $gt_invoice += qty_format($invoice);
        $gt_stc += qty_format($stc);
        $gt_free += qty_format($free);
        $gt_leakage += qty_format($leakage);
        $gt_closing += qty_format($closing);

        }  ?> 
        <tr>
            <th align="right">Grand Total</th>
            <th align="right"><?php echo qty_format($gt_opening_stock);?></th>
             <?php foreach($gt_receits as $key =>$gt_value) 
             {   ?> 
             <th align="right"><?php  echo qty_format($gt_value); ?></th> 
             <?php
              } ?>
             <th align="right"><?php echo qty_format($gt_production);?></th>
             <th align="right"><?php echo qty_format($gt_invoice);?></th>
             <th align="right"><?php echo qty_format($gt_stc);?></th>
             <th align="right"><?php echo qty_format($gt_free);?></th>
             <th align="right"><?php echo qty_format($gt_leakage);?></th>
             <th align="right"><?php echo qty_format($gt_closing);?></th>
            </tr> 
        </table> 
    <br>
    <br>
    <table border="1px" align="center" width="626" cellspacing="0" cellpadding="2">
        <tr>
            <th>Product</th>
            <th>Opening Stock</th>
            <th>Loose Recovery</th>
            <th>Production</th>
            <th>Closing Stock</th>
        </tr>
        <?php 
        $to_opening_stock = $to_recovery = $to_production = $to_closing_stock = 0;
        foreach ($loose_oils as $oils) 
        { ?>
        <tr>
            <td><?php echo $oils['name']; ?> </td>
            <td align="right"> <?php @$oil_opening_stock=$present_oil_stock[$oils['loose_oil_id']]['net_stock']+$present_oil_stock[$oils['loose_oil_id']]['production_oil']-$present_oil_stock[$oils['loose_oil_id']]['recovered_oil'];
            $oil_opening_stock = (@$oil_opening_stock !='')?$oil_opening_stock:0;
            echo $oil_opening_stock;
            $to_opening_stock += $oil_opening_stock;
             ?></td>
            <td align="right"><?php 
                $oil_leakage_recovery = (@$present_oil_stock[$oils['loose_oil_id']]['curr_recovered_oil']!='')?$present_oil_stock[$oils['loose_oil_id']]['curr_recovered_oil']:0;
                echo $oil_leakage_recovery;
                 $to_recovery +=  $oil_leakage_recovery;
            ?></td>
            <td align="right"><?php 
                $recovery_production = (@$present_oil_stock[$oils['loose_oil_id']]['curr_production_oil']!='')?$present_oil_stock[$oils['loose_oil_id']]['curr_production_oil']:0;
                echo $recovery_production;
                $to_production += $recovery_production;
                ?></td>
            <td align="right"><?php 

            @$oil_closing_stock=$oil_opening_stock+$oil_leakage_recovery- $recovery_production;
            echo @$oil_closing_stock;
            $to_closing_stock += $oil_closing_stock;
             ?></td>
        </tr>
        <?php
         } ?>
         <tr>
            <th align="right">Total in Kgs</th>
            <th align="right"><?php echo $to_opening_stock;?></th>
            <th align="right"><?php echo $to_recovery;?></th>
            <th align="right"><?php echo $to_production;?></th>
            <th align="right"><?php echo $to_closing_stock?></th>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <br>
    <table width="626" align="center" class="noborder">
        <tr>
            <td align="left" class="noborder">Godown Incharge </td>
            <td align="right" class="noborder">Officer Incharge</td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <br>

    <div class="row" style="text-align:center">
    <button class="button print_element"  onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'stock_point_product_balance';?>">Back</a>
    </div>
    <script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</body>
</html>