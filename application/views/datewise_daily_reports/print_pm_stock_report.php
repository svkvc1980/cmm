<br>
<h2 align="center">A.P.CO-OPERATIVE OIL SEEDS GROWER'S FEDERATION LIMITED</h2>
<h3 align="center"><?php echo get_plant_name();?></h3>
<h4 align="center">Daily Packing Material Report  : <?php echo $report_date;?> </h4>
<!-- <?php echo 'Report Taken Date'.$report_date;?> -->
<table width="100%" align="center" border="1px" cellspacing="0" cellpadding="1">
    <thead>
        <tr>
            <td rowspan="2">Slno</td>
            <td rowspan="2">Product Name</td>
            <td rowspan="2">Opening Stock</td>
            <td rowspan="2">RECEIPTS</td>
            <td align="center" colspan="2">ISSUES</td>
            <td rowspan="2">Closing Stock</td>
        </tr>
        <tr>
            <td>Packing</td>
            <td>Stock Transefer</td>
        </tr>
        
        
        <?php $i=1;
        foreach ($pm_cats as $pm_category_id => $pmc_name)
        {
            if(count(@$daily_report[$pm_category_id])!='' )
            {    ?> 
                <tr><td  style="background-color:#ccc" colspan="7" align = "center"><?php
                    if(get_film_category_id() == $pm_category_id)
                        echo $i++.'. '.$pmc_name.'(In Kgs)';
                    else
                        echo $i++.'. '.$pmc_name ;

                    ?>
                    </td>
                </tr>
            <?php
             $sn=1;  
             //echo count(@$daily_report[$pm_category_id]).'<br>';
            
                foreach ($daily_report[$pm_category_id] as $pm_id => $values)
                { ?>
                    <tr>
                        <td><?php  echo $sn++; ?></td>
                        
                        <td > <?php echo get_pm_name($pm_id);?></td>
                        <td style="text-align:right"> <?php echo $values['opening_balance'];?></td>
                        <td style="text-align:right"> <?php echo $values['receipts'];?> </td>
                        <td style="text-align:right"> <?php echo $values['on_date_production'];?> </td>
                        <td style="text-align:right"> <?php echo $values['on_date_invoice'];?></td>
                        <td style="text-align:right" > <?php echo $values['closing_balance'];?></td>
                    </tr>                                       
            <?php } 
            }                   
        }

        ?>
    </thead>
    <tbody>
    
    </tbody>
</table>
                  
<br>
<div class="row" style="text-align:center">
    <button class="button print_element"  onclick="print_srn()">Print</button>
    <a class="button" href="<?php echo SITE_URL.'daily_pm_stock_report_search';?>">Cancel</a>
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