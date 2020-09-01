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
    <p align="center" ><b>Unit DO List</b><span style="margin-left: 20px;">
    <?php if($search_data['fromDate']!='') { echo 'From : '.format_date($search_data['fromDate']); }?></span><span style="margin-left: 20px;">
    <?php if($search_data['toDate']!='') { echo 'To : '.format_date($search_data['toDate']); }?></span></p>
     <p align="center"><?php if($search_data['order_for']!='') { echo 'Unit : '.get_plant_name_by_id($search_data['order_for']); } ?> 
        <span style="margin-left: 20px;" align="center">
        <?php if($search_data['lifting_point_id']!='') { echo 'lifting point : '.get_plant_name_by_id($search_data['lifting_point_id']); }?></span>
        <span style="margin-left: 20px;" align="center">
           <?php 
            if($search_data['status']!='') 
            { echo " DO Status : "; 
            switch($search_data['status'])
                {
                    case 1:
                        echo "Pending";
                        break;
                    case 2:
                        echo "Complete";
                        break;
                }
            }?>
        </span></p>

    <br>
    <table border="1px" align="center" width="800" cellspacing="0" cellpadding="2">
            <tr style="background-color:#cccfff">
                <th>S.No</th>
                <th width="120">DO Number</th>
                <th>Unit</th>
                <th>Lifting Point</th>
                <th>Product</th>
                <th>DO Qty</th>
                <th>Pending</th>
                <th align="right">Price</th>
                <th align="right">Value</th>
            </tr>
        <tbody>
        <?php
            
            if(@$do_results)
            {
                $sn=1; $total =0;
            foreach(@$do_results as $row)
                { $total += ($row['do_quantity']*$row['items_per_carton']*$row['product_price']); ?>                                    
            <tr>
                <td><?php echo $sn++;?></td>
                <td><?php echo $row['do_number'].'/ '.date('d-m-Y',strtotime($row['do_date']));?> </td>
                <td><?php echo $row['order_for'];?> </td>
                <td><?php echo $row['lifting_point'];?> </td>
                <td><?php echo $row['product_name'];?> </td>
                <td align="right"><?php echo round($row['do_quantity']);?> </td>
                <td align="right"><?php echo round($row['pending_qty']);?> </td>
                <td align="right"><?php echo price_format($row['product_price']);?> </td>
                <td align="right"><?php echo price_format($row['do_quantity']*$row['items_per_carton']*$row['product_price']);?></td>
            </tr>
            <?php
                } ?>
                <tr>
                <td colspan="8" align="right"><b>Total</b></td>
                <td align="right"><b><?php echo price_format($total); ?></b></td>
                </tr>
                
            <?php }
            else
            {
                ?> <tr><td colspan="10" align="center"> No Records Found</td></tr>      
    <?php   }
            ?>
        </tbody>
    </table>
    <br>
    <div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'plant_do_list';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>