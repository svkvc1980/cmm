<!DOCTYPE html>
<html>
<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 
</head>
<body>
    <form  role="form" method="post" action="">
    <br>
    <h2 align="center">AP Cooperative Oilseeds Growers Federation Ltd</h2>
    <p align="center"><b><?php if($distributor_type!=''){ echo $distributor_type.' ';}?><?php if($region['location_id'] !=''){ echo "Region : ".$region['name'];} if($district['location_id'] !=''){ echo "District : ".$district['name'];}?> Distributors List <?php if($executive_name!=''){ echo ' Of '.$executive_name;}?></b></p>

    <br>
    <table border="1px" align="center" width="1100" cellspacing="0" cellpadding="2">
       <thead class="blue_head black">
            <tr>
                <th>S.No</th>
                <?php 
                if($distributor_type=='')
                {
                ?>
                <th>Type</th>
                <?php
                }   
                ?>
                <th>Agency Name</th>
                <th>Address</th>
                <th>Contact Nos</th>
                <?php 
                if($executive_name=='')
                {
                ?>
                <th>Executive</th>
                <?php
                }   
                ?>
                <th>SD Amount</th>  
                <th>Available Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sn=1;
            if($distributor_results){
                foreach($distributor_results as $row) {
                    $bg_amount = ($row['bg_amt']>0)?$row['bg_amt']:0;
                    $address = array(); $contact_nos = array();
                    if($row['address']!='')
                    $address[] = trim($row['address'],', ');
                    if($row['distributor_place']!='')
                    $address[] = $row['distributor_place'];

                    if($row['mobile']!='')
                    $contact_nos[] = trim($row['mobile'],', ');
                    if($row['landline']!='')
                    $contact_nos[] = $row['landline'];
                    if($row['alternate_mobile']!='')
                    $contact_nos[] = $row['alternate_mobile'];
                ?>
                <tr>
                    <td align="left"><?php echo $sn++; ?></td>
                    <?php 
                    if($distributor_type=='')
                    {
                    ?>
                    <td align="left"><?php echo $row['type_name']; ?></td>
                    <?php
                    }   
                    ?>
                    <td align="left"><?php echo $row['agency_name'].'['.$row['distributor_code'].']'; ?></td>
                    <td align="left"><?php echo implode(', ', $address); ?></td>
                    <td align="left"><?php echo implode(', ', $contact_nos);?></td>
                    <?php 
                    if($executive_name=='')
                    {
                    ?>
                    <td align="left"><?php echo $row['exe_name']; ?></td>
                    <?php
                    }   
                    ?>
                    <td align="right"><?php if($row['sd_amount']){ echo $row['sd_amount'];} else { echo '--';} ?></td>
                    <td align="right"><?php if($row['type_id']!=2 && $row['type_id']!=4 ){ echo  $row['outstanding_amount']+$row['sd_amount']+$bg_amount;} else { echo '--';} ?></td>
                </tr> <?php
                }
            }
            else
            {
                ?>
                <tr><td colspan="8" align="center"> No Records Found</td></tr>
                <?php
            } ?>
        </tbody>
    </table>
    
    <div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'region_wise_distributor_r';?>">Back</a>
    </div>
    </form>

</body>
</html>
<script type="text/javascript">
    function print_srn()
    {
        window.print(); 
    }
</script>