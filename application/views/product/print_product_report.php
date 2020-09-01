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
    <p align="center"><b><?php if($status==1){ echo "Active"; } else{ echo "Inactive";} ?> Products List</b></p>
    <table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
        <tr style="background-color:#cccfff">   
    		<th>S.No</th>
            <th>Oil Type</th>
            <th> Product Name </th>
            <th> Short Name </th>
            <th> Packing Type </th>
            <th> Items Per Carton</th>
            <th> Oil Weight(Kgs) </th>
            
        </tr>
        
        <?php $sno=1;
        if(count($product_list)>0)
        {
            foreach ($product_list as $key)
            { ?>
            <tr>
                <td width="50"><?php echo $sno++; ?></td>
                <td><?php echo $key['loose_oil_name']; ?></td>
                <td><?php echo $key['name']; ?></td>
                <td><?php echo $key['short_name']; ?></td>
                <td><?php echo $key['packing_type']; ?></td>
                <td align="right"><?php echo $key['items_per_carton']; ?></td>
                <td align="right"><?php echo qty_format($key['oil_weight']); ?></td>
                
            </tr>

        <?php } 

        } 
        else
        { ?>
            <tr><td colspan="7" align="center">-No Records Found- </td></tr>

        <?php }?>
        
    </table>

    <br><br><br><br><br><br><br>
    
        <table style="border:none !important" align="center" width="750">
            <tr style="border:none !important">
            <td style="border:none !important">
            
            <span style="margin-left:550px;">Authorised Signature</span>
            </td>
            </tr>
        </table>
    <br><br><br><br><br>
    <div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'product_r';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>