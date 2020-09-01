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
height:23px !important;
}
</style>
<body>
<h2 align="center">AP Cooperative Oilseeds Growers Federation Ltd</h2>
<br><br>
<table style="border:none !important" align="center" width="700">
<tr style="border:none !important">
    <td style="border:none !important" align="left">To</td>
</tr>
<tr style="border:none !important">
    <td style="border:none !important" align="left">The V.C & Managing Director,</td>
</tr>
<tr style="border:none !important">
    <td style="border:none !important" align="left">A.P Oil Federation,</td>
</tr>
<tr style="border:none !important">
    <td style="border:none !important" align="left">Hyderabad.</td>
</tr>
<tr style="border:none !important">
    <td style="border:none !important" align="left">Sub : Submission of sales particulars of <u><?php echo $plant_name ;?> </u></td>
</tr>
<tr style="border:none !important">
    <td  style="border:none !important" align="left">Monthly Sales report for <?php echo $plant_name ;?>  From <?php echo date('d F, Y', strtotime($from_date)) ?> TO <?php echo date('d F, Y', strtotime($to_date)) ?> </td>
</tr>
</table>
<br>
    <table border="1px" align="center" width="700" cellspacing="0" cellpadding="2">
    	<thead style="background-color:#cccfff">
       		<th>Sno</th>
       		<th>Product</th>
       		<th>Total Weight(Kgs)</th>
            <th>Total Value</th>
       </thead>
       <?php
        $sn=1;
        $total_qty=0;
        $total_price=0;
        if($oils)
        {
        	foreach($oils as $key =>$value)
        	{ 
                $total_qty+=@$msr[$value['loose_oil_id']]['month_quantity'];
                $total_price+=@$msr[$value['loose_oil_id']]['month_price'];
        		?>
        		<tr>
        			<td><?php echo $sn++; ?></td>
        			<td><?php echo $value['name'];?></td>
        			<td align="right"><?php if(@$msr[$value['loose_oil_id']]['month_quantity'] !='') { echo qty_format($msr[$value['loose_oil_id']]['month_quantity']); } else { echo qty_format('0'); } ?></td>
                    <td align="right"><?php if(@$msr[$value['loose_oil_id']]['month_price'] !='') { echo price_format($msr[$value['loose_oil_id']]['month_price']); } else { echo price_format('0'); } ?> </td>
        		</tr> <?php
        	} ?>
            <tr>
                <td colspan="2" align="right"> Total</td>
                <td align="right"><?php echo qty_format($total_qty);?></td>
                <td align="right"><?php echo price_format($total_price);?></td>
            </tr>
      <?php  }
        else
        { ?>
            <tr>
            <td colspan="4" align="right"><b>No Records Found </b> </td>
            </tr>
        <?php }
        ?>
    </table><br>
    <br><br><br><br><br><br><br>
    
        <table style="border:none !important" align="center" width="700">
            <tr style="border:none !important">
            <td style="border:none !important">
            
            <span style="margin-left:550px;">Authorised Signature</span>
            </td>
            </tr>
        </table>
    <br>
    <div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'monthly_sales_report';?>">Back</a>
    </div>
</body>
</html>
<script type="text/javascript">
    function print_srn()
    {
        window.print(); 
    }
</script>