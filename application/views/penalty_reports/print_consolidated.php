<!DOCTYPE html>
<html>
<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
</head>
<body>
<h2 align="center">AP Cooperative Oilseeds Growers Federation Ltd</h2>

<h4 align="center">Order Booking Penalties 
<?php 

if(@$search_params['fromDate']!='')
{
    $from_to_string = 'From '.format_date(@$search_params['fromDate']). ' To '.format_date(@$search_params['toDate']);
}


echo $from_to_string;

?></h4>
<table width="650" align="center" border="1px" align="center" cellspacing="0" cellpadding="1">
    <thead>
        <tr style="background-color:#ccc" align="center">
            <th> S.No </th>
            <th> Dealer Name/Code </th>
            <th> Penalty</th>                                                 
        </tr> 
        <?php 
            $sn = 1;
            $all_dealers_total = 0;
            if(count($penalty_dist_ids) > 0)
            {
                foreach ($penalty_dist_ids as $distributor_ids)
                {
                    
                    foreach ($penalty_data[$distributor_ids['distributor_id']] as $penalties)
                    { ?>
                      <tr align="center">
                        <td><?php echo $sn++;?> </td>
                        <td align="left"> <?php $dist_data =get_distribuutor_name_and_code($distributor_ids['distributor_id']); 
                            echo $dist_data['agency_name'].'['.$dist_data['distributor_code'].']';?> </td>
                        <td align="right"> <?php echo $penalties['consolidated_penalty'];?></td>                                                 
                    </tr> <?php
                    } ?>
                     <?php
                        $all_dealers_total += $penalties['consolidated_penalty'];                
                } ?> 
                    <tr>
                        <th align="right" colspan="2"> All Dealers Penalty</th>
                        
                        <th align="right"> <?php echo price_format(@$all_dealers_total);?> </th>
                     </tr><?php
           }
           else
           {?>
                <tr>
                    <td colspan="10" align="center">
                           No Records Found 
                    </td>
                </tr>
            <?php
           }?>
                   
    </thead>
    <tbody>

    </tbody>
</table>

<div class="row" style="text-align:center">
    <button class="button print_element"  onclick="print_srn()">Print</button>
    <a class="button" href="<?php echo SITE_URL.'consolidated_penalty_report';?>">Cancel</a>
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
</body>
</html>