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
    <p align="center"><b>Distributors Agreements</b></p>
    <p align="center"><b><?php if($status==1) { echo "Active List"; } else{ echo "Inactive List";} ?></b></p>
    <p align="center"><b><?php  echo date('d-m-Y',strtotime($from_date));?> To <?php  echo  date('d-m-Y',strtotime($to_date)); ?></b></p>
    <br>
    <table border="1px" align="center" width="900" cellspacing="0" cellpadding="2">
       <thead class="blue_head black">
            <tr>
                <th>S.No</th>
                <th>Distributor Name</th>
                <th>Agreement Start Date</th>
                <th>Agreement End Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sn=1;
            if($distributor_results){
                foreach($distributor_results as $row) 
                {
                ?>
                <tr>
                    <td><?php echo $sn++; ?></td>
                    <td><?php echo $row['agency_name'].'['.$row['distributor_code'].']'; ?></td>
                    <td><?php echo  date('d-m-Y',strtotime($row['agreement_start_date'])); ?></td>
                    <td><?php echo date('d-m-Y',strtotime($row['agreement_end_date'])); ?></td>
                </tr> 
                <?php
                }
            }
            else
            {
                ?>
                <tr><td colspan="4" align="center"> No Records Found</td></tr>
                <?php
            } ?>
        </tbody>
    </table>
    <br><br><br>
    <div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'dist_bg_r';?>">Back</a>
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