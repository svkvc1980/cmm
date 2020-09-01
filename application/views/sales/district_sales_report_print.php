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
<h3 align="center"><?php echo $location_name;?> Sales  From <?php echo date('d F, Y', strtotime($from_date)) ?> TO <?php echo date('d F, Y', strtotime($to_date)) ?> </h3>
<h4 align="center"><?php echo date('F d, Y, h:i:s A') ?> </h4>
    <table border="1px solid" align="center" cellspacing="0" cellpadding="2" style="width:50%">
    	<thead style="background-color:#cccfff">
       		<th>Sno</th>
       		<th>Agency Name</th>
       		<th>Town</th>
       		<th>Invoice NO</th>
            <th>Quantity(MT)</th>
            <th>Total Amount(MT)</th>
       </thead>
       <?php
        $sn=1;
        $total_qty=0;
        $total_amount=0;
        if($sales_results)
        {
        	foreach($sales_results as $row)
        	{
        		if($row['invoice_number']!='')
                {
                    $total_qty+=$row['tot_weight'];
                    $total_amount+=$row['tot_price'];
                ?>
            		<tr>
            			<td><?php echo $sn++; ?></td>
            			<td><?php echo $row['agency_name'].'['.$row['distributor_code'].']';?></td>
                        <td><?php echo $row['name'];?></td>
                        <td><?php echo $row['invoice_number'].'/ '.$row['invoice_date'];?></td>
                        <td align="right"><?php echo qty_format($row['tot_weight']);?></td>
            			<td align="right"><?php echo price_format($row['tot_price']);?></td>
            			
            		</tr> <?php
        	   }  
              
            } ?>
            <tr>
                    <td colspan="4" align="right"><b>Grand Total</b></td>
                    <td align="right"><b><?php echo qty_format($total_qty); ?></b></td>
                    <td align="right"><b><?php echo price_format($total_amount); ?></b></td>
               </tr>
      <?php  }
        else
        { ?>
            <tr>
            <td colspan="6" align="center"><b>No Records Found </b> </td>
            </tr>
        <?php }
        ?>
    </table>
    <br><br><br><br><br><br><br>
    
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
    <a class="button print_element" href="<?php echo SITE_URL.'district_sales_report';?>">Back</a>
    </div>
</body>
</html>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
