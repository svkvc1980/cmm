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
    <h4 align="center">Vehicle Details <span style="margin-left:50px;"><?php if($search_params['start_date']!='') { echo 'From : '.format_date($search_params['start_date']); } ?></span><span style="margin-left:10px;"><?php if($search_params['end_date']!='') { echo 'To : '.format_date($search_params['end_date']); } ?></span></h4>
    <table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
        <tr style="background-color:#cccfff">   
            <th>Product</th>
            <th>Unit Name</th>
            <th>Tanker In No</th>
            <th>Tanker Type</th>
            <th>Party Name</th>
            <th>Broker</th>
            <th>In Time</th>
            <th>Out Time</th>
        </tr> 
         
        <?php 
            if(count($print_vehicle_details)>0)
            {  
                foreach($print_vehicle_details as $row)
                {
            ?>
                <tr>
                    <td><?php
                        switch ($row['tanker_type_id']) 
                        {
                            case 1:
                                echo $row['loose_oil'];
                            break;

                            case 2:
                                echo $row['packing_material'];
                            break;

                            case 5:
                                echo $row['free_gift'];
                            break;    
                             
                            default:
                                echo "--";
                            break;
                        }?>
                    </td>
                    <td><?php echo $this->session->userdata('plant_name'); ?></td>
                    <td><?php echo $row['tanker_in_number'];?></td>
                    <td><?php echo $row['tanker_name'];?></td>
                    <td><?php echo $row['party_name'];?></td>
                    <td><?php echo $row['broker_name'];?></td>
                    <td><?php echo date('d-m-Y H:i:s',strtotime($row['in_time']));?></td>
                    <td><?php if($row['out_time']!=''){ echo date('d-m-Y H:i:s',strtotime($row['out_time'])); }?></td>
                </tr>
            <?php 
            }
            }
           else
            { ?>
            
            <tr><td colspan="8" align="center">-No Records Found- </td></tr>
            <?php }?>

        
    </table>

    <br><br><br><br><br><br><br>
    
        <table style="border:none !important" align="center" width="750">
            <tr style="border:none !important">
            <td style="border:none !important">
            
            
            </td>
            </tr>
        </table>
    <br><br><br><br><br>
    <div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'tanker_register';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>