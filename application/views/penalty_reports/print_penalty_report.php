<!DOCTYPE html>
<html>
<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
</head>
<body><br>
<!-- <h2 align="center">A.P.CO-OPERATIVE OIL SEEDS GROWER'S FEDERATION LIMITED</h2> -->
<h2 align="center">AP Cooperative Oilseeds Growers Federation Ltd</h2>
<p align="center">Order Booking Penalties 
<?php 

if(@$search_params['days']!='' )
{
    $days_string = 'After'. ($search_params['days'] -1) .'Days Report' ;
    
}
if(@$search_params['fromDate']!='')
{
    $from_to_string = 'From '.format_date(@$search_params['fromDate']). ' To '.format_date(@$search_params['toDate']);
}

/*
if(@$search_params['distributor_id']!='' && @$search_params['days']!='')
{
    @$days_string = 'After'. (@$search_params['days'] -1) .'Days Report' ;
    if(@$search_params['fromDate']!='')
    {
        $from_to_string = 'From'.@$search_params['fromDate']. 'To'.@$search_params['fromDate'];
    }
    
}
if(@$search_params['distributor_id']!='' && @$search_params['fromDate']!='' && @$search_params['days']!='')
{
    @$days_string = 'After'. ($search_params['days'] -1) .'Days Report' ;
    if($search_params['fromDate']!='')
    {
        $from_to_string = 'From'.@$search_params['fromDate']. 'To'.@$search_params['fromDate'];
    }
   
}*/
echo @$days_string.@$from_to_string;

?></p>
<table width="901" align="center" border="1px" align="center" cellspacing="0" cellpadding="1">
    <thead>
        <tr style="background-color:#ccc" align="center">
            <th width="37"> S.No </th>
            <!-- <th> OB No </th>
            <th> Date </th>
            <th> Penalty Date </th>
            <th> Penalty Day </th> -->
            <th width="250"> OB No/Date/Penalty Date </th>
            <th width="340"> Dealer Name/Code </th>
            <th width="104"> Product </th>
            <th width="49"> Qty </th> 
            <!-- <th width="53"> Price </th> -->
            <th width="53"> Kgs </th> 
            <th width="84"> Penalty</th>                                                 
        </tr> 
        <?php 
            $sn = 1;
            $all_dealers_total = 0;
            if(count($penalty_dist_ids) > 0)
            {
                foreach ($penalty_dist_ids as $distributor_ids)
                {
                    $dealer_total = 0;
                    foreach ($penalty_data[$distributor_ids['distributor_id']] as $penalties)
                    { ?>
                      <tr align="center">
                        <td><?php echo $sn++;?> </td>
                        <!-- <td> <?php 
                            
                                echo $ob_data['order_number'];?> </td>
                        <td> <?php echo $ob_data['order_date'];?> </td>
                        <td> <?php echo $penalties['penalty_date'];?> </td>
                        <td> <?php echo $penalties['penalty_day'];?></td> -->
                        <td align="left">
                            <?php 
                            $ob_data = get_ob_number_and_date($penalties['order_id']);
                            echo $ob_data['order_number'].'/'.format_date($ob_data['order_date']).'/'.format_date($penalties['penalty_date']).'['.$penalties['penalty_day'].']'
                            ?>
                        </td>
                        <td align="left"> <?php $dist_data =get_distribuutor_name_and_code($penalties['distributor_id']); 
                            echo $dist_data['agency_name'].'['.$dist_data['distributor_code'].']';?> </td>
                        <td align="left"> <?php echo get_product_short_name($penalties['product_id']);?></td>
                        <td align="right"> <?php echo $penalties['quantity']*$penalties['items_per_carton'];?> </td> 
                        <!-- <td align="right"> <?php echo $penalties['total_product_price'];?> </td> -->
                        <td align="right"> <?php echo $penalties['weight'];?> </td> 
                        <td align="right"> <?php 
                                $dealer_total += $penalties['total_amount'];
                        echo ($penalties['penalty_day']!=31)?$penalties['total_amount']:'Lapsed';?></td>                                                 
                    </tr> <?php
                    } ?>
                    <tr>
                        <th colspan="6" align="right">Total Dealer Penalty</th>
                        <th align="right"> <?php echo price_format(@$dealer_total);?> </th>
                    </tr> <?php
                        $all_dealers_total += $dealer_total;                
                } ?> 
                    <tr>
                        <th colspan="6" align="right"> All Dealers Penalty</th>
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
    <a class="button" href="<?php echo SITE_URL.'penalty_report';?>">Cancel</a>
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