<!DOCTYPE html>
<html>
<head>
    <title>Bank Guarantee Going to Expired Print</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 
</head>
<body>
    <h2 align="center">AP Cooperative Oilseeds Growers Federation Ltd</h2>
    <h4 align="center">Distributor <span style="color:#FF7300">Going to Expire</span> Bank Guarantee Details Report </h4>
    <table border="1px" align="center" width="1050" cellspacing="0" cellpadding="2">
        <tr style="background-color:#cccfff">   
            <th>S.No</th>
            <th>Distributor</th>
            <th>Bank</th>
            <th>Account No</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Amount</th>
        </tr> 
         
        <?php 
            if(count($bg_going_expired)>0)
            {  
                $sn=1;
                foreach($bg_going_expired as $row)
                { ?>
                <tr>
                    <td> <?php echo $sn++;?> </td>
                    <td> <?php echo ' '. $row['distributor_name'].' ['.$row['distributor_code'].']['.$row['distributor_place'].']';?> </td>
                    <td> <?php echo $row['bank_name'] ;?> </td>
                    <td> <?php echo $row['account_no'];?> </td>
                    <td> <?php echo date('d-m-Y',strtotime($row['start_date']));?> </td>
                    <td> <?php echo date('d-m-Y',strtotime($row['end_date']));?> </td>
                    <td align="right"> <?php echo $row['bg_amount'];?> </td>
                </tr>
                <?php 
                }  ?> 
            <?php 
            }
           else
            { ?>
            <tr><td colspan="7" align="center">-No Records Found- </td></tr>
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
    <a class="button print_element" href="<?php echo SITE_URL.'';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>