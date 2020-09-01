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
    <td style="border:none !important" align="center">Executive Wise Sales report    From <?php echo date('d-m-Y', strtotime($from_date)) ?> TO <?php echo date('d-m-Y', strtotime($to_date)) ?> </td>
</tr>
<tr>
    <td style="border:none !important" align="center">Executive Name :  <?php echo $executive_name; ?> </td>
</tr>
</table>
<br>
 <table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
   <tr style="background-color:#cccfff">
       		<th>Sno</th>
            <th>Dealer Agency</th>
       		 <th>Invoice No</th>
            <th>Quantity</th>
       		<th>Amount</th>
      </tr>
      <?php 
      if(count($product_results) > 0)
      { 
        $sno=1;
        $grand_qty=0;
        $grand_total=0;
        foreach($product_results as $key => $value)
        {
         $total_qty=0;
         $total_amount=0;  ?>
             <tr align="left"  style="background-color:#cccfff;">
                <td></td>
                <td colspan="4"><b><?php echo $value['distributor_name']; ?></b></td>
                </tr> 
      	 <?php 
          	foreach($value['products'] as $keys => $values) { 
          		$total_qty+=$values['qty_in_kg'];
          		$total_amount+=$values['amount'];
                $grand_qty+=$values['qty_in_kg'];
                $grand_total+=$values['amount'];
          		?>
          	<tr>
          		<td> <?php echo $sno++; ?></td>
                <td></td>
          		<td> <?php echo $values['invoice_number'].'/ '.format_date($values['invoice_date']);?></td>
          		<td align="right"> <?php echo qty_format($values['qty_in_kg']);?></td>
          		<td align="right"> <?php echo price_format($values['amount']);?></td>
          	</tr>

         <?php } ?>
              <tr>
               	<td colspan="3" align="right">Total</td>
               	<td align="right"><?php echo qty_format($total_qty); ?></td>
               	<td align="right"><?php echo price_format($total_amount); ?></td>
               	</tr>
          <?php } 
          ?>
           <tr>
                <td colspan="3" align="right">Grand Total</td>
                <td align="right"><?php echo qty_format($grand_qty); ?></td>
                <td align="right"><?php echo price_format($grand_total); ?></td>
                </tr>
                <?php }
        else
        { ?>
            <tr>
            <td colspan="5" align="center"><b>No Records Found </b> </td>
            </tr>
        <?php }
        ?>
        </table><br>
        <br><br><br><br><br>
    
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
    <a class="button print_element" href="<?php echo SITE_URL.'executive_wise_invoice_sales_report';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>