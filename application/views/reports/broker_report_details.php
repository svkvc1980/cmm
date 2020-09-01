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
<h4 align="center">Broker Report</h4>
 <table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
<h4 align="center"><?php echo date('F d, Y, h:i:s A') ?> </h4>
                                    <thead class="blue_head black">
                                        <tr>
                                            <th>S. No</th>
                                            <th>Agency Name[Code]</th>
                                            <th>Concerned Person</th>
                                            <th>Address</th>
                                            <th>Contact Nos</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $sn = 1;
                                        if($broker_reports)
                                        {
                                            foreach($broker_reports as $row)
                                            {
                                                $contact_nos = array();
                                                if($row['mobile']!='')
                                                $contact_nos[] = trim($row['mobile'],', ');
                                                if($row['alternate_mobile']!='')
                                                $contact_nos[] = $row['alternate_mobile'];
                                        ?>
                                        <tr>
                                            <td align="left"> <?php echo $sn++ ?> </td>
                                            <td align="left"> <?php echo $row['agency_name'].'['.$row['broker_code'].']' ?> </td>
                                            <td align="left"> <?php echo $row['concerned_person'] ?> </td>
                                            <td align="left"> <?php echo $row['address'] ?> </td>
                                            <td align="left"><?php echo implode(', ', $contact_nos);?></td>
                                            <td align="left"> <?php if($row['status']==1)
                                                {
                                                    echo "Active";
                                                }
                                                else
                                                {
                                                    echo "Inactive";
                                                }
                                                ?> 
                                            </td>
                                        </tr>
                                        <?php } 
                                        }
                                        else 
                                        {
                                        ?>  
                                            <tr><td colspan="7" align="center"><span class="label label-primary">No Records</span></td></tr>
                                        <?php   
                                        } ?>
                                    </tbody>
                                </table>
                                 <br><br><br><br><br><br><br>
    
        <table style="border:none !important" align="center" width="750">
            <tr style="border:none !important">
            <td style="border:none !important">
            
            <span style="margin-left:550px;">Authorised Signature</span>
            </td>
            </tr>
        </table>
    <div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'broker_report_search';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>