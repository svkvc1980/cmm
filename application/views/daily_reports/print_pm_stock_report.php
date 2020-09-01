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
<h4 align="center"><?php echo get_plant_name();?> <span style="margin-left: 50px;">Daily Packing Material Report  : <?php echo $report_date;?> </span></h4>
<table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
    <thead>
        <tr>
            <td rowspan="2">SNo.</td>
            <td rowspan="2">Product Name</td>
            <td rowspan="2">Opening Stock</td>
            <td rowspan="2">RECEIPTS</td>
            <td align="center" colspan="3">ISSUES</td>
            <td rowspan="2">Closing Stock</td>
        </tr>
        <tr>
            <td>Packing</td>
            <td>Stock Transefer</td>
            <td> Leakage </td>
        </tr>
        
        
        <?php $i=1;
        foreach ($pm_grps as $pm_group_id => $pmgrp_name)
        {
            if(count(@$daily_report[$pm_group_id])!='' )
            {    ?> 
                <tr><th  style="background-color:#ccc" colspan="8" align = "left"><?php
                    if(get_film_category_id() == $pm_group_id || get_pp_covars_group_id() == $pm_group_id)
                        echo $i++.'. '.$pmgrp_name.'(In Kgs)';
                    else
                        if(get_tapes_group_id() == $pm_group_id)
                            echo $i++.'. '.$pmgrp_name.'(In mts)' ;
                        else
                            echo $i++.'. '.$pmgrp_name ;

                    ?>
                    </th>
                </tr>
            <?php
             $sn=1;  
             //echo count(@$daily_report[$pm_category_id]).'<br>';
            
                foreach ($daily_report[$pm_group_id] as $pm_id => $values)
                { ?>
                    <tr>
                        <td><?php  echo $sn++; ?></td>
                        
                        <td > <?php echo get_pm_name($pm_id);?></td>
                        
                        <?php
                        switch ($pm_group_id) {
                            case get_film_category_id():
                            case get_pp_covars_group_id() :
                            case get_tapes_group_id(): 
                            ?>
                            <td style="text-align:right"> <?php echo qty_format($values['opening_balance']);?>
                            <td style="text-align:right"> <?php echo qty_format($values['receipts']);?> </td>
                            <td style="text-align:right"> <?php echo qty_format($values['on_date_production']);?> </td>
                            <td style="text-align:right"> <?php echo qty_format($values['on_date_invoice']);?></td>
                            <td style="text-align:right"> <?php echo qty_format($values['on_date_leakage']);?></td>
                            <td style="text-align:right" > <?php echo qty_format($values['closing_balance']);?></td>
                            <?php
                                # code...
                                break;
                           

                            
                            default: ?>
                                <td style="text-align:right"> <?php echo $values['opening_balance'];?>
                                <td style="text-align:right"> <?php echo round($values['receipts']);?> </td>
                                <td style="text-align:right"> <?php echo round($values['on_date_production']);?> </td>
                                <td style="text-align:right"> <?php echo round($values['on_date_invoice']);?></td>
                                <td style="text-align:right"> <?php echo $values['on_date_leakage'];?></td>
                                <td style="text-align:right" > <?php echo $values['closing_balance'];?></td>
                               <?php break;
                        }?>
                            
                        
                    </tr>                                       
            <?php } 
            }                   
        }

        ?>
    </thead>
    <tbody>
    
    </tbody>
</table>
<br><br><br><br><br><br><br>
<table style="border:none !important" align="center" width="750">
    <tr style="border:none !important">
    <td style="border:none !important">
    
    <span style="margin-left:550px;">Authorised Signature</span>
    </td>
    </tr>
</table>
<div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'daily_pm_stock_report_search';?>">Back</a>
</div>
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