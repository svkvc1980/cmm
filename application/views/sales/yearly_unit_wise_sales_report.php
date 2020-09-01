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
<h3 align="center"><span style="margin-left:50px">Yearly Sales Report From <?php echo $from_date.' To '.$to_date  ?></span></h3>
<br>
    <table border="1px" align="center" width="1200" cellspacing="0" cellpadding="2">
    	<thead style="background-color:#cccfff">
        <tr>
       		<th rowspan="2">Sno</th>
       		<th rowspan="2">Loose Oil</th>
            <?php foreach($months_array as $key =>$value) { ?>
            <th colspan="2"><?php echo $value ?></th> 
            <?php } ?>
            <th colspan="2">Total</th>
       	</tr>
        <tr>
        <?php foreach($months_array as $key =>$value) { ?>
            <th>WT(MT)</th>
            <th>Price</th>
            <?php } ?>
            <th>Total Weight</th>
            <th>Total Price</th>
            
        </tr>
       </thead>
       <?php
        $sn=1;
        $total_qty=0;
        $total_price=0;
        $grand_kgs = 0;
        $grand_total = 0;
        if(count($oils)>0)
        {
        	foreach($oils as $key =>$value)
        	{ ?>
        		<tr>
        			<td><?php echo $sn++; ?></td>
        			<td><?php echo $value['name'];?></td>

                    <?php $loose_total_qty=0;$loose_total_price=0;
                        foreach($months_array as $k1 =>$v1)
                    {?>
            			<td align="right"><?php if(@$msr[$value['loose_oil_id']][$k1]['month_quantity'] !='') { echo qty_format($msr[$value['loose_oil_id']][$k1]['month_quantity']); } else { echo "-"; } ?></td>
                        <td align="right"><?php
                        $loose_total_qty+=@$msr[$value['loose_oil_id']][$k1]['month_quantity'];
                        $loose_total_price+=@$msr[$value['loose_oil_id']][$k1]['month_price'];
                        if(@$msr[$value['loose_oil_id']][$k1]['month_price'] !='') { echo price_format($msr[$value['loose_oil_id']][$k1]['month_price']); } else { echo "-"; } ?> </td>
                    <?php } ?>
                    <td align="right"><?php echo qty_format($loose_total_qty);?></td>
                    <td align="right"><?php echo price_format($loose_total_price);?></td>
        		    
                </tr> <?php
        	} ?>
            <tr>
                 <td colspan="2" align="right"> Total</td>
      <?php  
        foreach($months_array as $k1 =>$v1)
        { 
            $ver_total = 0; $ver_kg = 0;
            foreach($oils as $key =>$value)
            {
                $ver_kg += @$msr[$value['loose_oil_id']][$k1]['month_quantity'];
                $ver_total += @$msr[$value['loose_oil_id']][$k1]['month_price']; 
            } 
            $grand_kgs += $ver_kg; 
            $grand_total += $ver_total;?>

            <td align="right"><?php echo qty_format($ver_kg); ?></td>
            <td align="right"><?php echo price_format($ver_total); ?></td><?php  
        } ?>
        <td align="right"><?php echo qty_format($grand_kgs); ?></td>
        <td align="right"><?php echo price_format($grand_total); ?></td>
        </tr>

        <?php
        }
        else
        { ?>
            <tr>
            <td colspan="16" align="right"><b>No Records Found </b> </td>
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
    <a class="button print_element" href="<?php echo SITE_URL.'yearly_unit_product_report';?>">Back</a>
    </div>
</body>
</html>
<script type="text/javascript">
    function print_srn()
    {
        window.print(); 
    }
</script>