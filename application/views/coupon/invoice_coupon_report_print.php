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
    <td style="border:none !important" align="left">Executive and Productwise Sales From <?php echo date('d-m-Y', strtotime($from_date)) ?> TO <?php echo date('d-m-Y', strtotime($to_date)) ?> </td>
</tr>
 <tr>
    <td style="border:none !important" align="left"><?php if($executive['name']!='') { ?> Executive Name :  <?php echo $name;   }  if($loose_oil['loose_oil_id'] !='') { echo 'Sales of'.$loose_oil['name'].'with offer' ; } ?> </td>
</tr> 
</table>
<br>
    <table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
       <tr>
		<th>Invoice No</th>
		<th>product</th>
	    <th>cartons</th>
	    <th>Value</th>

        <th>Coupons(<?php echo $coupons['no_of_cartons']; ?>)</th>
        <th>Coupon Value(@<?php echo $coupons['amount']; ?> )</th>
       </tr>
       <?php
        $sn=1;
        $grand_cartons=0;
       
        if(@$coupon_results)
        {
        	foreach($coupon_results as $key =>$value)
            {  $total_cartons=0;
               
                ?>
                <tr align="left"  style="background-color:#cccfff;">
                <td></td>
                <td colspan="5"><b><?php echo $value['distributor_name']; ?></b></td>
                </tr>
                <?php foreach($value['products'] as $keys => $values) 
                {  /*$total_cartons+=@$dpsr[$values['product_id']]['quantity'];
                   $total_pouches+=@$dpsr[$values['product_id']]['pouches'];
                   $total_qty+=@$dpsr[$values['product_id']]['quantity_in_kgs'];
                   $total_price+=@$dpsr[$values['product_id']]['price'];

                   $grand_cartons+=@$dpsr[$values['product_id']]['quantity'];
                   $grand_pouches+=@$dpsr[$values['product_id']]['pouches'];
                   $grand_qty+=@$dpsr[$values['product_id']]['quantity_in_kgs'];
                   $grand_total+=@$dpsr[$values['product_id']]['price'];*/
                   $total_cartons+=$values['quantity'];
                   $grand_cartons+=$values['quantity'];
                    ?>
                   <tr>
                        <td><?php echo $values['invoice_number']; ?></td>
                        <td><?php echo $values['product_name'] ; ?></td>
                        <td align="right"><?php echo qty_format($values['quantity']) ; ?></td>
                        <td align="right"><?php echo price_format($values['amount']) ; ?></td>
                        <td></td>
                        <td></td>
                   </tr>
      <?php  } ?>
                  <tr>
                  <?php
                  $coupon_cartons=($total_cartons/$coupons['no_of_cartons']);
                  $coupon_amount=round($coupon_cartons)*$coupons['amount']; ?>
                   <td align="right" colspan="4"><b>Total</b></td>
                    <?php if($coupon_cartons > 0) { ?>
                    <td align="right"><b><?php echo round($coupon_cartons);?></b></td>
                    <td align="right"><b><?php echo $coupon_amount; ?></b></td>
                    <?php } else 
                    { ?>
                    <td align="right"><b><?php echo 0;?></b></td>
                    <td align="right"><b><?php echo 0;?></b></td> 
                    <?php } ?>
                  </tr>
     <?php  } ?>
                <tr>
                  <?php
                  $grand_coupon_cartons=($grand_cartons/$coupons['no_of_cartons']);
                  $grand_coupon_amount=round($coupon_cartons)*$coupons['amount']; ?>
                   <td align="right" colspan="4"><b>Total</b></td>
                    <?php if($coupon_cartons > 0) { ?>
                    <td align="right"><b><?php echo round($grand_coupon_cartons);?></b></td>
                    <td align="right"><b><?php echo $grand_coupon_amount; ?></b></td>
                    <?php } else 
                    { ?>
                    <td align="right"><b><?php echo 0;?></b></td>
                    <td align="right"><b><?php echo 0;?></b></td> 
                    <?php } ?>
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
    <a class="button print_element" href="<?php echo SITE_URL.'invoice_coupon_report';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>