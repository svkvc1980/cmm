<!DOCTYPE html>
<html>
<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <h2 align="center">AP Cooperative Oilseeds Growers Federation Ltd</h2>
    <p align="center"><b>Distributor Credit/Debit Report</b></p>
    <p align="center"><b>From : <?php echo date('d-m-Y',strtotime($search_params['from_date']));?>
            <span style="margin-left: 50px">To : <?php echo date('d-m-Y',strtotime($search_params['to_date']));?> </span>
    </b></p>
    <table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
        <tr style="background-color:#cccfff">   
    		<th  width="50">S.No</th>
            <th  width="100"> Date</th>
            <th  width="350"> Distributor </th>
            <th  width="150"> Purpose</th>
            <th  width="150"> Amount </th>
        </tr>
        
        <?php $sno=1; $credit_amount = 0; $debit_amount = 0;
        if(count($dist_cd_list)>0)
        {
            foreach ($dist_cd_list as $key)
            { 
                if($key['note_type']==1)
                {
                    $credit_amount+= $key['amount'];
                }
                else if($key['note_type'] == 2)
                {
                    $debit_amount+= $key['amount'];
                }?>
            <tr>
                <td width="50"><?php echo $sno++; ?></td>
                <td width="100"><?php echo date('d-m-Y',strtotime($key['on_date'])); ?></td>
                <td width="350"><?php echo $key['agency_name'].' ['.$key['distributor_code'].'] ['.$key['distributor_place'].']'; ?></td>
                <td width="150"><?php if($key['purpose_id']!=''){ echo $key['purpose']; } else { echo $key['remarks']; }; ?></td>
                <td width="75" align="right"><?php echo price_format($key['amount']); ?></td>
            </tr>

        <?php } 

        } 
        else
        { ?>
            <tr><td colspan="7" align="center">-No Records Found- </td></tr>

        <?php }?>
        
    </table>
    <br>
    <table style="border:none !important" align="center" width="750">
        <tr style="border:none !important">
        <td style="border:none !important">
        <span style="margin-left:200px;">Total Credit : <?php echo price_format($credit_amount); ?></span>
        <span style="margin-left:70px;">Total Debit : <?php echo price_format($debit_amount); ?></span>
        </td>
        </tr>
    </table>

    <br><br><br><br><br><br><br>
    
        <table style="border:none !important" align="center" width="750">
            <tr style="border:none !important">
            <td style="border:none !important">
            <span style="margin-left:50px;">Exe(Mktg)</span>
            <span style="margin-left:100px;">Dy.Manager(Mktg)</span>
            <span style="margin-left:100px;">Manager(Mktg)</span>
            <span style="margin-left:100px;">Manager(Fin)</span>
            </td>
            </tr>
        </table>
    <br><br><br><br><br>
    <div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'c_d_distributor_r';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>