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
<h3 align="center"><?php echo @$price_type_name .' '.'Price type '.@$ops;  ?><span style="margin-left:50px;">As on Date :<?php echo $start_date; ?></span></h3>
<br>
	 <table border="1px" align="center" width="550" cellspacing="0" cellpadding="2">
	   <tr>
	            <td><b>SNO</b></td>
	            <td><b>Product Name</b></td>
	            <td><b>Price</b></td>
	            <!-- <td><b>New Price</b></td> -->
	        </tr>
	   <?php foreach ($product_results as $key =>$value)
	    {  $sno=1; ?>
	        <tr align="center" style="background-color:#cccfff" >
	           <td colspan="4"><?php echo $value['product_name']; ?></td>
	        </tr>
	        
	        <tr>
	            <?php foreach($value['sub_products'] as $keys =>$values)
	              { ?>
	            <td><?php echo  $sno++; ?></td> 
	            <td><?php echo $values['name']; ?></td>
	            <td align="right"><?php if (@$latest_price_details[$values['product_id']]!='') { echo price_format($latest_price_details[$values['product_id']]['old_price']); } else { echo price_format(0); } ?></td>
	            <input type="hidden" name="distributor_type" value="<?php echo $distributor_type; ?>">
                <input type="hidden" name="plant_id" value="<?php echo $plant_id; ?>">
                <input type="hidden" name="effective_date" value="<?php echo $start_date; ?>" >
	           
	           
	        </tr>
	    <?php
	    } } ?>    
	</table>
<br><br><br><br><br>
    
        <table style="border:none !important" align="center" width="550">
            <tr style="border:none !important">
            <td style="border:none !important">
            
            <span style="margin-left:350px;">Authorised Signature</span>
            </td>
            </tr>
        </table>
    <br><br>
<div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'product_price_report';?>">Back</a>
    </div>

<script type="text/javascript">
    function print_srn()
    {
        window.print(); 
    }
</script>