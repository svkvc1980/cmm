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
<h4 align="center">3rd Floor, 'C' Block, BRKR Bhavan, Saifabad, Hyderabad - 500063.</h4>
<h4 align="center">Phone & Fax No : 040-23220360, email : apoilfedbrkr@gmail.com</h4>
<p align="center">Datewise Order bookings PENALTY report <b>From <?php echo format_date($search_params['fromDate'])?> To <?php echo format_date($search_params['toDate'])?></b></p>

<table width="740" align="center" border="1px" align="center" cellspacing="0" cellpadding="1">
    <tr>
        <th colspan="2" align="center">Debit Note</th>
    </tr>
    <tr>
        <td align="left" width="50%">
            <b>TO</b><br>
            <?php 
                    echo $dist_data['agency_name'].'['.$dist_data['distributor_code'].']';
                ?><br>
            <?php echo trim($dist_data['address'],' ,').', '.$dist_data['distributor_place'];?>
        </td>
        <td width="50%">
            <b>PN/</b><br>
            <b>Dated: <?php echo date('d-m-Y');?></b>
        </td>
    </tr>
    <tr>
        <th colspan="2" align="center">Particulars</th>
    </tr>
    <tr>
        <th colspan="2" align="left">We are here with debiting the following amounts towards penalities for the stocks not lifted with in stipulated period against order bookings</th>
    </tr>
</table>
<table width="740" align="center" border="1px" align="center" cellspacing="0" cellpadding="1">
    <thead>
        <tr style="background-color:#ccc" align="center">
            <th width="40"> S.No </th>
            <th width="250"> OB No/Date/Penalty Date </th>
            <th width="150"> Product </th>
            <th width="100"> Qty </th> 
            <!-- <th width="53"> Price </th> -->
            <th width="100"> Kgs </th> 
            <th width="100"> Amount(Rs.)</th>                                                 
        </tr> 
        <?php 
            $sn = 1;
            $all_dealers_total = 0;
            if(count($penalty_data) > 0)
            {
                    $dealer_total = 0;
                    foreach ($penalty_data as $penalties)
                    { ?>
                      <tr align="center">
                        <td><?php echo $sn++;?> </td>
                        <td align="left">
                            <?php 
                            $ob_data = get_ob_number_and_date($penalties['order_id']);
                            echo $ob_data['order_number'].'/'.format_date($ob_data['order_date']).'/'.format_date($penalties['penalty_date']).'['.$penalties['penalty_day'].']'
                            ?>
                        </td>
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
                        <th colspan="5" align="right">Total Penalty Value</th>
                        <th align="right"> <?php echo price_format(@$dealer_total);?> </th>
                    </tr>
                    <tr>
                        <td colspan="6" align="left"> Rupees in words : <?php echo strtoupper(convert_number_to_words(round($dealer_total)).' ONLY'); ?></td>
                    </tr> <?php                
                ?> <?php
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
<br><br><br><br><br>
    
        <table style="border:none !important" align="center" width="740">
            <tr style="border:none !important" >
                <th style="border:none !important" align="left">
                    <p>Copy To : Manager(Finance) for information.</p>
                    <p>Copy To : Executive (Marketing).</p>
                </th>  
                <th style="border:none !important" align="right">Authorised Signatory.</th>
            </tr>
        </table>
    <br><br>
<div class="row" style="text-align:center">
    <button class="button print_element"  onclick="print_srn()">Print</button>
    <a class="button" href="<?php echo SITE_URL.'dealerwise_penalty_report';?>">Back</a>
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
    h2,h3,h4{ margin: 2px;}
</style>
</body>
</html>