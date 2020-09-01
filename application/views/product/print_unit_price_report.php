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
<h3 align="center">All Products <?php echo @$distributor_price_type ; ?> Price List <span style="margin-left:50px;">Effective From: <?php echo format_date($effective_from); ?></span> <span style="margin-left:50px">Dated: <?php echo date('Y-m-d h:i A')?></span></h3>
<br>
 <?php if($price_type != get_raithu_bazar_id())  { ?>
<table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
<tr>   
		<th>Sno</th>
		<th>Product Code </th>
		<?php foreach ($units as $unit) { ?>
		  <th align="center"><?php echo $unit['plant_short_name']; ?> </th>  
		<?php } ?>
	</tr> 
    <?php $sno=1; foreach ($product_results as $key =>$value)
       {   ?>
    	
        <tr align="left"  style="background-color:#cccfff">
            <td></td>
        	<td colspan="<?php echo count($units)+1; ?>"><?php echo $value['product_name']; ?></td>
        	
        </tr>
       
        <tr>
            <?php foreach($value['sub_products'] as $keys =>$values)
              { ?>
            <td><?php echo  $sno++; ?></td> 
            <td><?php echo $values['name']; ?></td>
            <?php foreach ($units as $unit) { ?>
            	<td align="right"><?php if (@$latest_price_details[$unit['plant_id']][$values['product_id']]!='') { echo price_format($latest_price_details[$unit['plant_id']][$values['product_id']]['old_price']); } else { echo 0; } ?></td>
            	<?php } ?>
         </tr>
    <?php
    } } ?> </table> <?php 
    
    } 
    else { ?>  
    <table border="1px" align="center" width="650" cellspacing="0" cellpadding="2">
    	 <tr>
                    <td width="50"><b>SNO</b></td>
                    <td><b>Product Name</b></td>
                    <td><b>Price</b></td>
                </tr>
        <?php $sno=1; foreach ($product_results as $key =>$value)
            {   ?>
                <tr  style="background-color:#cccfff" align="center">
                   <td width="50"></td>
                   <td colspan="3" align="left"><?php echo $value['product_name']; ?></td>
                </tr>
               
                <tr>
                    <?php foreach($value['sub_products'] as $keys =>$values)
                      { ?>
                    <td width="50"><?php echo  $sno++; ?></td> 
                    <td><?php echo $values['name']; ?></td>
                    <td align="right"><?php if (@$latest_price_details[$values['product_id']]!='') { echo price_format($latest_price_details[$values['product_id']]['old_price']); } else { echo 0; } ?></td>
                 
                </tr>
            <?php
            } }  } ?> 

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
    <a class="button print_element" href="<?php echo SITE_URL.'product_price_report_units';?>">Back</a>
</div>
<script type="text/javascript">
    function print_srn()
    {
        window.print(); 
    }
</script>