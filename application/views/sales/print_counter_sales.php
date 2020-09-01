<br><br><br><br><br>
<body>    
    <?php
    foreach ($sales_list as $row)
    {?>
        <pre>
            DATE: <?php echo date('d-m-Y H:i') ?><br>
            Customer Name : <?php echo $row['customer_name']?><br>
            Bill Number : <?php echo $row['bill_number'] ?><br>
            Category : <?php echo $row['category']?><br>
            Payment Mode : <?php echo $row['pay_mode']?><br>
            Product name: <?php echo $row['product']?><br>
            Price: <?php echo $row['price']?><br>
            Quantity: <?php echo $row['quantity']?><br>
            Amount: <?php echo $row['amount']?><br>
            Total Bill: <?php echo $row['total_bill'] ?>
        </pre>
<?php } 
        if($row['cs_pay_mode_id'] == 1)
        {?>
            <pre>
                Denomination: <?php echo $row['received_denomination'] ?><br>
                Pay to customer: <?php echo $row['pay_customer'] ?>
            </pre>
      <?php   }
        else
        {?>
            <pre>
                DD number: <?php echo $row['dd_number'] ?><br>
                Bank Name: <?php echo $row['bank'] ?>
            </pre>
 <?php  }?>