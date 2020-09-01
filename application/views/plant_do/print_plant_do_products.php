<br>
<h2 align="center">A.P.CO-OPERATIVE OIL SEEDS GROWER'S FEDERATION LIMITED</h2>
<h3 align="center">Plant D.O. Product List</h3>
<br>
<div class="row">
    <table  align="center" width="100%" >
        <thead>
            <tr><th align="right"> DO Number :</th><td><?php echo $do_details['do_number']; ?></td>
            <th align="right"> DO Date :</th><td><?php echo date('d-m-Y',strtotime($do_details['do_date'])); ?></td>
            <th align="right">Order For :</th><td><?php echo $do_details['order_for']; ?></td>
            <th align="right">Lifting Point :</th><td><?php echo $do_details['lifting_point_name']; ?></td></tr>
        </thead> 
    </table>
    <table border="1px" align="center" width="100%" cellspacing="0" cellpadding="2">
        <thead>
            <th> S.No</th>
                                <th> Product Name </th>
                                <th> Pending Qty </th>
                                <th> Invoiced Qty </th>
                                <th> Unit Price </th>
                                <th> Add Price </th>
                                <th> Total Price</th>
        </thead>
         <tbody>
            <?php $sn = 1; $grand_total = 0;
                 foreach($do_products as $row) 
                { ?>
                    <tr>
                        <td><?php echo $sn++; ?></td>
                        <td><?php echo $row['product_name']; ?></td>
                        <td><?php echo round($row['pending_qty']).' (c)'; ?></td>
                        <td><?php echo round($row['raised_qty']).' (c)'; ?></td>
                        <td><?php echo $row['unit_price']; ?></td>
                        <td><?php echo $row['add_price']; ?></td>
                        <td><?php echo round($row['total_price'],2); ?></td>
                        <?php $grand_total+= $row['total_price'];?>
                    </tr>
                    
                <?php 
                    } ?>
                <tr><td colspan="7" align="right"><b>Total Price: <?php echo $grand_total;?></b></td></tr>
        </tbody>
    </table>
</div>
<br>
<div class="row" style="text-align:center">
<button class="button"  onclick="print_srn()" style="background-color:#3598dc">Print</button>
</div>
<script type="text/javascript">
    function print_srn()
    {
        window.print(); 
    }
</script>
