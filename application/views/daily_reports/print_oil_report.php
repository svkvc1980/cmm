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
<h3 align="center"> <?php echo get_plant_name_not_in_session($plant_id);?></h3>
<h4 align="center">Daily Oil Report <span style="margin-left: 50px;">Report as On : <?php echo $report_date;?> </span></h4>
<!-- <?php echo 'Report Taken Date'.$report_date.'<br>'.'Replort as On'.$report_date;?> -->
<table border="1px" align="center" width="950" cellspacing="0" cellpadding="2">
    <thead>
        <tr style="background-color:#ccc" align="center">
            <td>  </td>
            <td><b> Name of the Oil</b> </td>
            <td>  </td>
            <td>  </td>
            <td><b> opening</b> </td>
            <td><b> Receipts</b> </td>
            <td><b> Sales</b> </td> 
            <td><b> Stock Transfer</b> </td>
            <td width="70"><b>Processing Loss</b></td>
            <td><b>Leakage1</b></td>
            <td><b>Leakage2</b></td>
            <td><b> CI Stock</b> </td>                                                  
        </tr>
        <tr>
            <td> </td>
            <td> <b>RBDP Bulk Mktg Oil Tanker No.6</b> </td>
            <td> </td>
            <td> </td>
            <td align="right"> 0.000 </td>
            <td align="right"> 0.000 </td>
            <td align="right"> 0.000 </td> 
            <td>  </td>
            <td> </td>
            <td>  </td>
            <td>  </td>
            <td align="right"> 0.000 </td>                                                  
        </tr>
        <tr style="background-color:#ccc" align="center">
            <td><b> Sl.No </b></td>
            <td><b> Name of the Oil</b> </td>
            <td> </td>
            <td> </td>
            <td><b> Opening </b></td>
            <td><b> Receipt </b></td>
            <td><b> Production </b></td> 
            <td> </td>
            <td>  </td>
            <td>  </td>
            <td>  </td>
            <td><b> CI Stock </b></td>                                                  
        </tr>
        <tr style="background-color:#ccc" align="center">
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td><b> in MTS</b> </td>
            <td><b> in MTS </b></td>
            <td><b> Dispatches</b></td> 
            <td> </td>
            <td>  </td>
            <td>  </td>
            <td>  </td>
            <td><b> in MTS</b> </td>                                                  
        </tr>
        <?php 
            $sn = 1;
            foreach ($loose_oils as $loose_oil_id => $name) 
            { 
                $loose = 0;
                foreach ($daily_report[$loose_oil_id] as  $loose_and_packed) 
                { ?>
                    <tr>
                        <td><?php echo $sn++; ?> </td>
                        <td><?php echo ($loose==0)?$name.' Loose Oil':$name.' Packed Oil';?>  </td>
                        <td>   </td>
                        <td>   </td>
                        <td align="right"> <?php echo qty_format($loose_and_packed['opening']);?></td>
                        <td align="right"> <?php echo qty_format($loose_and_packed['receipts']);?>  </td>
                        <td align="right"> <?php echo qty_format($loose_and_packed['sales']);?> </td> 
                        <td align="right"> <?php echo qty_format($loose_and_packed['stock_transfer']);?> </td> 
                        <td align="right"> <?php echo ($loose==0)?qty_format(@$processing_loss_arr[@$loose_oil_id]):'';?> </td> 
                        <td align="right"> <?php echo ($loose==0)?qty_format(@$type1_leakage_arr[@$loose_oil_id]):'';?> </td> 
                        <td align="right"> <?php echo ($loose==0)?qty_format(@$type2_leakage_arr[@$loose_oil_id]['tot_rec_oil']):qty_format(@$type2_leakage_arr[@$loose_oil_id]['lost_packed_oil']);?> </td> 
                        <td align="right"> <?php 
                        $closing_balance = $loose_and_packed['closing_balance'];
                        if($loose==0)
                        {
                            $closing_balance -= @$type1_leakage_arr[@$loose_oil_id];
                            $closing_balance += @$type2_leakage_arr[$loose_oil_id]['tot_rec_oil'];
                            $closing_balance -= @$processing_loss_arr[@$loose_oil_id];
                        }
                        else
                        {
                            $closing_balance -= @$type2_leakage_arr[$loose_oil_id]['lost_packed_oil'];
                        }
                        echo qty_format($closing_balance);?></td>
                    </tr>
                    <?php  $loose++; 
                } ?>
    <?php   } ?>

        <tr align="center" style="background-color:#ccc">
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td><b> in MTS</b> </td>
            <td>  </td>
            <td></td> 
            <td> </td>
            <td> </td>
            <td> </td>
            <td>  </td>
            <td></td>                                                  
        </tr>
        <tr align="center" style="background-color:#ccc">
            <td> </td>
            <td> </td>
            <td> </td>
            <td><b>Dispatches on</b> </td>
            <td> <b>Cumulative </b></td>
            <td>  </td>
            <td></td> 
            <td> </td>
            <td> </td>
            <td> </td>
            <td>  </td>
            <td></td>                                                  
        </tr>
        <tr align="center" style="background-color:#ccc">
            <td> </td>
            <td><b> Dispatches during this Month</b></td>
            <td> </td>
            <td><b><?php echo $report_date;?> </b></td>
            <td> <b>Dispatches</b> </td>
            <td>  </td>
            <td></td> 
            <td> </td>
            <td> </td>
            <td> </td>
            <td>  </td>
            <td></td>                                                  
        </tr>
        <?php 
            $sn = 1;
             //$loose = 0;
             $t_on_date = 0;
             $t_cumulative = 0;
                foreach ($dispatches as $loose_oil_id =>$cur_and_cumulative) 
                { ?>
                    <tr>
                        <td><?php echo $sn++; ?> </td>
                        <td><?php echo get_loose_oil_name($loose_oil_id);?>  </td>
                        <td>   </td>                        
                        <td align="right"> <?php 
                        
                        echo qty_format($cur_and_cumulative[0]);
                        
                        $t_on_date += $cur_and_cumulative[0];
                        ?></td>
                        <td align="right"> <?php echo qty_format($cur_and_cumulative[1]);
                        $t_cumulative += $cur_and_cumulative[1];
                        ?>  </td>
                        
                        <td>  </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>  </td>
                    </tr>
                    <?php  
                 
                  } ?>
                  <tr>
                        <td> </td>
                        <td align="right">Grand Total </td>
                        <td>   </td>                        
                        <td align="right"> <?php 
                        
                        echo '<b>'.qty_format($t_on_date).'<b>';
                        
                       
                        ?></td>
                        <td align="right"> <?php echo '<b>'.qty_format($t_cumulative).'</b>';
                        
                        ?>  </td>
                        
                        <td>  </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>  </td>
                    </tr>
                  
        <tr align="center" style="background-color:#ccc">
            <td> </td>
            <td> </td>
            <td><b> Oil to Be <b></td>
            <td><b> Loose at </b></td>
            <td><b> Packed </b></td>
            <td><b> Pending</b> </td>
            <td><b> Pending Order</b> </td> 
            <td><b> Oil Available </b></td>
            <td> </td>
            <td> </td>
            <td> </td> 
            <td></td>                                                 
        </tr>
        <tr  style="background-color:#ccc" align="center">
            <td> </td>
            <td><b> Name Of the Oil </b> </td>
            <td><b> Received </b>  </td>
            <td><b><?php echo get_plant_name_not_in_session($plant_id) ;?></b>  </td>
            <td><b>Oil In</b></td>
            <td><b> Delivery</b> </td>
            <td><b> Booking</b></td> 
            <td><b>For Order </b> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td></td>                                                  
        </tr>
        <tr style="background-color:#ccc" align="center">
            <td><b>Sl.No</b> </td>
            <td> </td>
            <td><b> in MTS</b> </td>
            <td><b> in MTS </b></td>
            <td><b> in MTS</b> </td>
            <td><b> Orders </b></td>
            <td> <b>in MTS </b></td> 
            <td><b> Booking </b></td>
            <td> </td>
            <td> </td>
            <td> </td>  
            <td></td>                                                
        </tr>
        <tr style="background-color:#ccc" align="center">
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td> </td>
            <td><b>In MTS</b> </td>
            <td> </td> 
            <td><b>In MTS </b></td>
            <td> </td>
            <td>  </td>
            <td> </td>
            <td> </td>                                                  
        </tr>
        <?php 
        $sn =1;
        foreach ($all_types as $key =>  $all_type_data)
                {
                    $available = $all_type_data['t_qty']+ $daily_report[$key][0]['closing_balance'] +$daily_report[$key][1]['closing_balance']- $obs[$key]['ob_qty'] - $dos[$key]['do_qty'] ;
                 ?>
                    <tr>
                        <td><?php echo $sn++; ?> </td>
                        <td><?php echo get_loose_oil_name($key);?>  </td>                                                
                        <td align="right"> <?php echo qty_format($all_type_data['t_qty']);?>   </td>
                        <td align="right"> <?php echo qty_format($daily_report[$key][0]['closing_balance']);?></td>
                        <td align="right"> <?php echo qty_format($daily_report[$key][1]['closing_balance'])?>  </td>                                                
                        <td align="right"> <?php echo qty_format($dos[$key]['do_qty']);?> </td> 
                        <td align="right"> <?php echo qty_format($obs[$key]['ob_qty']);?> </td> 
                        <td align="right"> <?php echo qty_format($available);?>  </td>
                        <td></td>
                        <td></td>
                        <td>  </td>
                        <td></td>
                    </tr>
                 <?php                                          
                 }  ?>
    </thead>
    <tbody>

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
    <a class="button print_element" href="<?php echo SITE_URL.'oil_report_search';?>">Back</a>
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