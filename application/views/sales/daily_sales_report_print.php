<!DOCTYPE html>
<html>
<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 

</head>
<style>
table tr td{
	height:20px !important;
}
</style>

<body>

<h2 align="center">AP Cooperative Oilseeds Growers Federation Ltd</h2>
<h4 align="center">Daily Sales report For <?php echo $plant_name .' On '. $from_date ?></h4>
    <table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
       <thead style="background-color:#cccfff">
          <tr>
       		<th rowspan="2" width="50">Sno</th>
       		<th rowspan="2" width="200">Loose Oil</th>
       		<th colspan="2" width="250">Unit</th>
       		<th width="250" colspan="2">Counter Sales</th>
          </tr>
          <tr>
          <th> Qty(Kgs)</th>
          <th> Value</th>
           <th> Qty(Kgs)</th>
          <th> Value</th>
          </tr>
       </thead>
       <?php
        $sn=1;
        $total_qty=0;
        $total_price=0;
        $cs_total_qty=0;
        $cs_amount=0;
        if(@$oils)
        {
        	foreach(@$oils as $key =>$value)
        	{  
                 $total_qty+=@$dsr[$value['loose_oil_id']]['quantity'];
                 $total_price+=@$dsr[$value['loose_oil_id']]['price'];
                 $cs_total_qty+=@$csdsr[$value['loose_oil_id']]['cs_quantity'];
                  $cs_amount+=@$csdsr[$value['loose_oil_id']]['cs_amount'];
        		?>
        		<tr>
        			<td ><?php echo $sn++; ?></td>
        			<td ><?php echo $value['name'];?></td>
        			<td  align="right"><?php if(@$dsr[$value['loose_oil_id']]['quantity'] !='') { echo qty_format($dsr[$value['loose_oil_id']]['quantity']); } else { echo qty_format('0'); } ?></td>
        			<td  align="right"><?php if(@$dsr[$value['loose_oil_id']]['price'] !='') { echo price_format($dsr[$value['loose_oil_id']]['price']); } else { echo price_format('0'); } ?> </td>
                    <td  align="right"><?php if(@$csdsr[$value['loose_oil_id']]['cs_quantity'] !='') { echo qty_format($csdsr[$value['loose_oil_id']]['cs_quantity']); } else { echo qty_format('0'); } ?></td>
                    <td  align="right"><?php if(@$csdsr[$value['loose_oil_id']]['cs_amount'] !='') { echo price_format($csdsr[$value['loose_oil_id']]['cs_amount']); } else { echo price_format('0'); } ?> </td>
        		</tr> <?php
        	}
           ?> 
           <tr>
                <td colspan="2" align="right">Total</td>
                <td align="right"><?php  echo qty_format($total_qty) ; ?></td>
                <td align="right"><?php  echo price_format($total_price) ; ?></td>
                <td align="right"><?php  echo qty_format($cs_total_qty) ; ?></td>
                <td align="right"><?php  echo price_format($cs_amount) ; ?></td>
           </tr>
      <?php  }
        else
        { ?>
            <tr>
            <td colspan="4" align="center"><b>No Records Found </b> </td>
            </tr>
        <?php }
        ?>
    </table><br><br>
    <table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
    <tr style="background-color:#cccfff">
        <th  width="300"></th>
        <th colspan="2" width="250">Unit</th>
        <th colspan="2" width="250">Counter Sales</th>
    </tr>
    <tr>
    	<th></th>
        <th>Qty(Kgs)</th>
        <th>Value</th>
        <th>Qty(Kgs)</th>
        <th>Value</th>
    </tr>
    <tr>
        <td>Grand Total</td>
        <td align="right"><?php echo qty_format($total_qty); ?></td>
        <td align="right"><?php echo price_format($total_price); ?></td>
        <td align="right"><?php  echo qty_format($cs_total_qty) ; ?></td>
        <td align="right"><?php  echo price_format($cs_amount) ; ?></td>
    </tr>
    <tr>
        <td>Cumulatives as On <?php echo $prev_date ?></td>
        <td align="right"><?php $pd=$previous_sales['pre_qty_in_kg']; if($pd !=''){ echo qty_format($pd) ; } else { echo 0; } ?></td>
        <td align="right"><?php $pds=$previous_sales['pre_amount']; if ($pds !='') { echo price_format($pds); } else { echo 0; }?></td>
        <td align="right"><?php $cspd=$cs_previous_sales['cs_qty_in_kg']; if($cspd !=''){ echo qty_format($cspd) ; } else { echo 0; } ?></td>
        <td align="right"><?php $cspds=$cs_previous_sales['cs_amount']; if ($cspds !='') { echo price_format($cspds); } else { echo 0; }?></td>
    </tr>
    <tr>
        <td>Cumulatives as On <?php echo $from_date ?></td>
        <td align="right"><?php $pd=$total_qty+$previous_sales['pre_qty_in_kg']; echo qty_format($pd);?></td>
        <td align="right"><?php $pds=$total_price+$previous_sales['pre_amount']; echo price_format($pds);?></td>
        <td align="right"><?php $cspd=$cs_total_qty+$cs_previous_sales['cs_qty_in_kg'];  echo qty_format($cspd) ;  ?></td>
        <td align="right"><?php $cspds=$cs_amount+$cs_previous_sales['cs_amount'];  echo price_format($cspds); ?></td>
    </tr>
    </table>
    <br>
    <br>
    <br><br><br><br><br>
    
        <table style="border:none !important" align="center" width="750">
            <tr style="border:none !important">
            <td style="border:none !important">
            
            <span style="margin-left:550px;">Authorised Signature</span>
            </td>
            </tr>
        </table>
    <br><br>
    <div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'daily_sales_report';?>">Back</a>
    </div>
</body>
</html>
<script type="text/javascript">
function print_srn()
{
    window.print(); 
}
</script>
    