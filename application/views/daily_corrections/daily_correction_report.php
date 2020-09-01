<!DOCTYPE html>
<html>
<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 
</head>
<body>
<h2 align="center">Daily Corrections Report</h2>
<h4 align="center"> <?php echo 'Corrections From : '.date('d-m-Y', strtotime($from_date)); ?> <span style="margin-left: 30px;"><?php echo 'TO : '.date('d-m-Y', strtotime($to_date)); ?></span> </h4> 
<table  border="1px" align="center" width="800" cellspacing="0" cellpadding="2">

        <tr style="background-color:#cccfff">
           
                <th>S.No</th>
                <th width="130px">Date / Time</th>
                <th width="130px">Approved By</th>
                <th>Activity</th>
           
        </tr>
        <tbody>
            <?php
            $sn=1;
            if($daily_correction_report_row){
                foreach($daily_correction_report_row as $row){
            ?>  
                <tr>
                    <td> <?php echo $sn++;?></td>
                    <td width="130px"> <?php echo date('d-m-y',strtotime($row['created_time'])).' / '.date('H:i:s',strtotime($row['created_time']));?> </td>
                    <td width="130px"> <?php echo $row['name'];?></td>
                    <td> <?php echo $row['activity'];?> </td>
                   </tr> 
                    
                <?php       
                }
                }   
            
            else
            {
            ?>
                <tr><td colspan="7" align="center"> No Records Found</td></tr>
                <?php
            }
            ?>
        </tbody>
    </table>

    <br><br><br><br><br>
    
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
    <a class="button print_element" href="<?php echo SITE_URL;?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>