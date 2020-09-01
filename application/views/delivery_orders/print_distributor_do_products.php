<br>
<h2 align="center">A.P.CO-OPERATIVE OIL SEEDS GROWER'S FEDERATION LIMITED</h2>
<h3 align="center">Distributor Ordered Product List</h3>
<br>
<table border="1px" align="center" width="60%" cellspacing="0" cellpadding="2">
  <?php
    $ggd=0;
    $gt_total =0;
    $sno = 1; 
    foreach($do_results as $key => $value) 
    { 
        $order_number =  $this->Common_model->get_value('order',array('order_id'=>$key),'order_number');
        
    ?>
    <thead>
       <th colspan="6">Order Number: <?php echo $order_number; ?></th>
    </thead>
    <tr style="background-color:#cccfff">
        <th> S.No</th>
        <th> Product Name </th>
        <th> Quantity </th>
        <th> Unit Price </th>
        <th> Add Price </th>
        <th> Total Price</th>
    </tr>
    <tbody>
        <?php 
        $gt=0;
        $grand_total=0;
         foreach($value['do_orders'] as $keys =>$values) 
         { 
            if($values != '') 
            { 
                $total=0;
                
                @$distributor_order_product = $this->Delivery_order_m->get_distributor_ob_price_details($values['order_id'],$values['product_id']);
                ?>
                <tr>
                    <td><?php echo $sno++; ?></td>
                    <td><?php echo $values['product_name']; ?></td>
                    <td><?php echo $values['quantity']; ?></td>
                    <td><?php echo @$distributor_order_product[0]['unit_price']; ?></td>
                    <td><?php  echo @$distributor_order_product[0]['add_price']; ?></td>
                    <td><?php $total_price = @$distributor_order_product[0]['total_price'] * @$values['quantity'];
                    echo $total_price; 
                    ?></td>
                </tr>
                <?php   
            }
               $total+=$total_price; 
               $gt+=$total;
        } 
               
               $gt_total+=$gt;
               $grand_total+=$gt_total; ?>
            <tr><td colspan="6" align="right"><b>Total: <?php echo $gt; //echo indian_format_price($grand_total);?></b></td></tr>
    </tbody> <?php   
}  ?>
    <tr><td colspan="6" align="right"><b>Grand Total: <?php echo $grand_total;//echo indian_format_price($grand_total);?></b></td></tr>
</table>

<div class="wrapper">
<button class="button"  onclick="myFunction()">Print</button>


</div>
<script type="text/javascript">
	function myFunction()
	{
		window.print();	
	}

</script>
<style>
	.wrapper {
    text-align: center;
}

.button {
    position: absolute;
    top: 87%;
}
</style>