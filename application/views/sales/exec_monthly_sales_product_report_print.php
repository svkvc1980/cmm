<!DOCTYPE html>
<html>
<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 
</head>
<body>
<h2 align="center">AP Cooperative Oilseeds Growers Federation Ltd</h2>
<table style="border:none !important" border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
<tr>
    <td style="border:none !important" align="left">To</td>
</tr>
<tr>
    <td style="border:none !important" align="left">The V.C & Managing Director,</td>
</tr>
<tr>
    <td style="border:none !important" align="left">A.P Oil Federation,</td>
</tr>
<tr>
    <td style="border:none !important" align="left">Hyderabad.</td>
</tr>

<tr>
    <td style="border:none !important" align="left">Monthly Sales report    From <?php echo date('d F, Y', strtotime($from_date)) ?> TO <?php echo date('d F, Y', strtotime($to_date)) ?> </td>
</tr>
<tr>
    <td style="border:none !important" align="left">Executive Name :  <?php echo $executive_name; ?> </td>
</tr>
</table>
<br>
    <table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
       <tr>
		<th>Sno</th>
		<th>product</th>
	        <th>cartons</th>
	        <th>pouches</th>
		<th>Qty(Kgs)</th>
		<th>Value</th>
       </tr>
       <?php
        $sn=1;
        $grand_cartons=0;
        $grand_pouches=0;
        $grand_qty=0;
        $grand_total=0;
        //$total_qty=0;
        //$total_price=0;
        if(@$product_results)
        {
        	foreach($product_results as $key =>$value)
            {  $total_cartons=0;
               $total_pouches=0;
               $total_qty=0;
               $total_price =0; ?>
                <tr align="left"  style="background-color:#cccfff;">
                <td></td>
                <td colspan="5"><b><?php echo $value['loose_oil']; ?></b></td>
                </tr>
                <?php foreach($value['products'] as $keys => $values) 
                {  $total_cartons+=@$dpsr[$values['product_id']]['quantity'];
                   $total_pouches+=@$dpsr[$values['product_id']]['pouches'];
                   $total_qty+=@$dpsr[$values['product_id']]['quantity_in_kgs'];
                   $total_price+=@$dpsr[$values['product_id']]['price'];

                   $grand_cartons+=@$dpsr[$values['product_id']]['quantity'];
                   $grand_pouches+=@$dpsr[$values['product_id']]['pouches'];
                   $grand_qty+=@$dpsr[$values['product_id']]['quantity_in_kgs'];
                   $grand_total+=@$dpsr[$values['product_id']]['price'];
                    ?>
                   <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $values['product_name'] ; ?></td>
                        <td align="right"><?php if(@$dpsr[$values['product_id']]['quantity'] !='') {echo qty_format($dpsr[$values['product_id']]['quantity']) ; } else { echo qty_format('0'); } ?></td>
                        <td align="right"><?php if(@$dpsr[$values['product_id']]['pouches'] !='') {echo $dpsr[$values['product_id']]['pouches'] ; } else { echo 0; } ?></td>
                        <td align="right"><?php if(@$dpsr[$values['product_id']]['quantity_in_kgs'] !='') { echo qty_format($dpsr[$values['product_id']]['quantity_in_kgs']) ; } else { echo qty_format('0'); } ?></td>
                       <td align="right"><?php if(@$dpsr[$values['product_id']]['price'] !='') { echo price_format($dpsr[$values['product_id']]['price']) ; } else { echo price_format('0'); } ?></td>
                   </tr>
      <?php  } ?>
                  <tr>
                    <td align="right" colspan="2"><b>Total</b></td>
                    <td align="right"><b><?php echo qty_format($total_cartons);?></b></td>
                    <td align="right"><b><?php echo $total_pouches; ?></b></td>
                    <td align="right"><b><?php echo qty_format($total_qty);?></b></td>
                    <td align="right"><b><?php echo price_format($total_price);?></b></td>
                  </tr>
     <?php  } ?>
                <tr>
                    <td align="right" colspan="2"><b>Grand Total</b></td>
                    <td align="right"><b><?php echo qty_format($grand_cartons);?></b></td>
                    <td align="right"><b><?php echo $grand_pouches; ?></b></td>
                    <td align="right"><b><?php echo qty_format($grand_qty);?></b></td>
                    <td align="right"><b><?php echo price_format($grand_total);?></b></td>
                  </tr>
  <?php  }
        else
        { ?>
            <tr>
            <td colspan="4" align="center"><b>No Records Found </b> </td>
            </tr>
        <?php }
        ?>
    </table>
    <br><br><br><br>
    
        <table style="border:none !important" align="center" width="750">
            <tr style="border:none !important">
            <td style="border:none !important">
            
            <span style="margin-left:550px;">Authorised Signature</span>
            </td>
            </tr>
        </table>
    <br>
    <div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'monthly_exec_product_sale_report';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>