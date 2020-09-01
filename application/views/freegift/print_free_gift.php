<html>
<style>
    @media print {
     .print_element{display:none;}
    }
table.tr {
height:35px;
}

 
</style>
<body>
<br>
<h3 align="center">A.P.CO-OPERATIVE OIL SEEDS GROWER'S FEDERATION LIMITED</h3>
<h4 align="center">Purchase Order For Free Gifts</h4>
<table border="1px" colspan="2" align="center" width="70%" cellspacing="0" cellpadding="1" >
    <tr style="height:35px;">
	   <th align="left" colspan="1">PO Number</th>
	   <td align="left" colspan="1"><?php echo $free_gift_results['po_number'];?></td>
	</tr>
	<tr>
	   <th align="left" colspan="1">PO Date</th>
	   <td align="left" colspan="1"><?php echo date('d-m-Y',strtotime($free_gift_results['po_date']));?></td>
    </tr>
   
    <tr>
	   <th align="left" colspan="1">Free Gift Name</th>
	   <td align="left" colspan="1"><?php echo $free_gift_results['free_gift_name'];?></td>
	</tr>
	<tr>
	   <th align="left" colspan="1">Supplier</th>
	   <td align="left" colspan="1"><?php echo ($free_gift_results['supplier_name'].'['.$free_gift_results['supplier_code'].']');?></td>
    </tr>
    <tr>
	   <th align="left" colspan="1">Unit Price</th>
	   <td align="left" colspan="1"><?php echo $free_gift_results['unit_price'];?></td>
    </tr>
    <tr>
	   <th align="left" colspan="1">Quantity</th>
	   <td align="left" colspan="1"><?php echo $free_gift_results['quantity'];?></td>
	</tr>
</table>
<br>
<div class="row" style="text-align:center">
    <button class="button print_element"  onclick="print_srn()">Print</button>
    <?php if(@$free_gift_id==2)
    { ?>
    <a class="button" href="<?php echo SITE_URL.'freegift_po_list';?>">Cancel</a>
    <?php }
   else{?>
    	<a class="button" href="<?php echo SITE_URL.'freegift_po';?>">Cancel</a>
    <?php }
    ?>
 </div>
 </body>
 </html>
<script type="text/javascript">
    function print_srn()
    {
        window.print(); 
    }
</script>
