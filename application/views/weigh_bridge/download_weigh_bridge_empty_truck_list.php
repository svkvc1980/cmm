<br>
<head>
<style>
table, th, td {
    border: none; 
    width: 1000px;
    font-size:24px;
} 

th, td {
    padding: 7px;
    height: 50px;
    text-align: left;    
}
@media print 
{
  .no-print, .no-print *
    {
        display: none !important;
    }
}

</style>
</head>
<body>
<h2 align="center">A.P.CO-OPERATIVE OIL SEEDS GROWER'S FEDERATION LIMITED</h2>
<h3 align="center"><?php echo $plant_name;?> <span style="margin-left: 50px;">date : <?php echo date('d-m-Y H:i:s'); ?></span></h3><hr>
    <?php
    foreach ($view_list as $row)
    { ?>

    <table align="center">
        <tbody>
            <tr>
                <td >Vehicle In Number :</td>
                    <td ><b><?php echo $row['tanker_in_number']?></b></td>
                <td >Vehicle Number :</td>
                    <td ><b><?php echo $row['vehicle_number']?></b></td>
                
            </tr>
            <tr>
                <td >Invoice No. :</td>
                    <td ><b><?php if($row['invoice_no']!='') { echo $row['invoice_no'];} else { echo "--"; } ?></b></td>
                <td >Invoice Qty (Kgs) :</td>
                    <td ><b><?php if($total_weight!='') {echo price_format(@$total_weight);} else { echo "--"; } ?></b></td>
            </tr>
             <tr>
             <?php foreach ($party_name as $key) { ?>
             
                <td >Party Name :</td>
                    <?php if($key['distributor_code']!='')
                    { ?>
                        <td style="font-size: 15pt;"><b><?php echo $key['distributor_code'].' - ('.$key['agency_name'].')'; ?></b></td>
                   <?php }
                   if($key['plant_name']!='')
                   { ?>
                        <td style="font-size: 15pt;"><b><?php echo $key['plant_name']; ?></b></td>
                  <?php } } ?>
                    
                
            </tr>
            <tr>
                <td>Vehicle In Time :</td> 
                    <td><b><?php echo date('d-m-Y H:i:s',strtotime($row['in_time']));?></b></td>
                <td>Vehicle Out Time :</td> 
                    <td><b><?php if($row['out_time']!='') { echo date('d-m-Y H:i:s',strtotime($row['out_time'])); } else { echo "--";}?></b></td>
            </tr>
        </tbody>
    </table><br>
    <?php } ?>
    <hr>
    <table align="center">
        <tbody>
         <?php  
            if($view_list)
            {
                foreach ($view_list as $row)
                {?>
                <tr>
                    <th colspan="3">Weight(Kgs)</th>
                    <th colspan="3">Date</th>
                    <th colspan="3">Time</th>
                </tr>
                <tr>
                    <td colspan="3">Gross : &nbsp;<b><?php if($row['gross']!='') { echo $row['gross']; } else { echo "--"; } ?></b></td>
                    <td colspan="3"><b><?php  if($row['gross_time']!='') { echo date('d-m-Y',strtotime($row['gross_time'])); } else { echo "--"; }?></b></td>
                    <td colspan="3"><b><?php  if($row['gross_time']!='') { echo date('H:i:s A',strtotime($row['gross_time'])); } else { echo "--"; }?></b></td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;&nbsp;Tare : &nbsp;<b><?php if($row['tier']!='') { echo $row['tier']; } else { echo "--"; } ?></b></td>
                    <td colspan="3"><b><?php  if($row['tare_time']!='') { echo date('d-m-Y',strtotime($row['tare_time'])); } else { echo "--"; }?></b></td>
                    <td colspan="3"><b><?php  if($row['tare_time']!='') { echo date('H:i:s A',strtotime($row['tare_time'])); } else { echo "--"; }?></b></td>
                </tr>
                
                <tr>   
                    <td  colspan="3">
                        &nbsp;&nbsp; Net : &nbsp;<b><?php 
                                    if($row['gross']!='' && $row['tier']!='')
                                    {
                                         echo price_format($row['gross']-$row['tier']);
                                    }
                                    else
                                    {
                                        echo "--";
                                    }?></b>
                    </td>
                    <td colspan="3">
                        Excess/Less Wt : &nbsp;<b>
                                    <?php
                                        if($row['gross']!='' && $row['tier']!='' && $total_weight!='')
                                    {
                                        echo price_format(($row['gross'] - $row['tier'] ) - $total_weight);
                                    }
                                    else
                                    {
                                        echo "--";
                                    } ?>
                                    </b>
                    </td>
                </tr>    
        <?php }
            }?>
        </tbody>
        <tfoot>
            <tr style="height:220px">
                <td>Driver</td><td></td><td>Asst.</td><td></td><td>Dy.Manager</td><td></td><td>Manager(Tech)</td>
            </tr>
        </tfoot>
    </table><br>
<div class="no-print" style="text-align:center">
    <button class="button"  onclick="print_srn()" style="background-color:#3598dc; color:white;">Print</button>
    <a type="button" class="button" href="<?php echo SITE_URL.'weigh_bridge_list';?>">Back</a>
</div>
</body>
<script type="text/javascript">
    function print_srn()
    {
        window.print(); 
    }
</script>