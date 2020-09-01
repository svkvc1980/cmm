<!DOCTYPE html>
<html>
<head>
    <title>Agreement Expired Print</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 
</head>
<body>
    <h2 align="center">AP Cooperative Oilseeds Growers Federation Ltd</h2>
    <h4 align="center">Distributor <span style="color:red">Expired</span> Agreement Details Report </h4>
    <table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
        <tr style="background-color:#cccfff">   
            <th>S.No</th>
            <th>Distributor</th>
            <th>Start Date</th>
            <th>End Date</th>
        </tr> 
         
        <?php 
            if(count($agreement_expired)>0)
            {  
                $sn=1;
                foreach($agreement_expired as $row)
                { ?>
                <tr>
                    <td> <?php echo $sn++;?> </td>
                    <td> <?php echo ' '. $row['agency_name'].' ['.$row['distributor_code'].']['.$row['distributor_place'].']';?> </td>
                    <td> <?php echo ($row['agreement_start_date']==''||$row['agreement_start_date']=='0000-00-00')?$row['agreement_start_date']:format_date($row['agreement_start_date']);?> </td>
                    <td> <?php echo ($row['agreement_end_date']==''||$row['agreement_end_date']=='0000-00-00')?$row['agreement_end_date']:format_date($row['agreement_end_date']);?> </td>
                </tr>
                <?php 
                }  ?> 
            <?php 
            }
           else
            { ?>
            <tr><td colspan="6" align="center">-No Records Found- </td></tr>
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