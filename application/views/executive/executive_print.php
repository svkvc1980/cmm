<!DOCTYPE html>
<html>
<head>
    <title>Executive Print</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 
</head>
<body>
    <h2 align="center">AP Cooperative Oilseeds Growers Federation Ltd</h2>
    <h4 align="center">Executive Report </h4>
    <table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
        <tr style="background-color:#cccfff">   
            <th>S.No</th>
            <th>Executive Code</th>
            <th>Name</th>
            <th>Mobile Number</th>
            <th>Address</th>
        </tr> 
        <?php 
            if(count($executive_print)>0)
            {  
                $sn=1;
                foreach($executive_print as $row)
                { ?>
                <tr>
                    <td> <?php echo $sn++;?> </td>
                    <td> <?php echo $row['executive_code'];?> </td>
                    <td> <?php echo $row['name'];?> </td>
                    <td> <?php echo $row['mobile'];?> </td>
                    <td> <?php echo $row['address'];?> </td>
                </tr>
                <?php 
                } 
            }
           else
            { ?>
            <tr><td colspan="5" align="center">-No Records Found- </td></tr>
            <?php }?>
    </table>
    <br><br><br><br><br>
    
        <table style="border:none !important" align="center" width="750">
            <tr style="border:none !important">
            <td style="border:none !important">
            
          
            </td>
            </tr>
        </table>
    
    <div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'executive';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>