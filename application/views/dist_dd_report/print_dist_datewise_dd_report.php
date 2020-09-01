<!DOCTYPE html>
<html>
<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
</head>
<body>
    <h2 align="center">AP Cooperative Oilseeds Growers Federation Ltd</h2>
    <p align="center"><b>Distributor DD Report</b><span style="margin-left: 50px"><b>From : </b><?php echo date('d-m-Y',strtotime($search_params['from_date']));?>
            <span style="margin-left: 50px"><b>To :</b> <?php echo date('d-m-Y',strtotime($search_params['to_date']));?> </span></span></p>
    <table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
        <tr style="background-color:#cccfff">   
    		<th  width="50">S.No</th>
    		<th  width="225">DD.No / Date</th>
            
            <th  width="250"> Distributor </th>
            <th  width="75"> Unit </th>
            <th  width="150"> Bank Name </th>
            <th  width="75"> Amount </th>
        </tr>
        
        <?php $sno=1; $grand_amount = 0;
        if(count($dd_list)>0)
        {	
            foreach ($dd_list as $key)
            { $grand_amount+=$key['amount']; ?>
            <tr>
                <td width="50"><?php echo $sno++; ?></td>
                <td width="225"><?php echo $key['dd_number'].' / '.date('d-m-Y',strtotime($key['payment_date'])); ?></td>
                <td width="250"><?php echo $key['distributor_name'].' ('.$key['distributor_code'].') ['.$key['distributor_place'].']'; ?></td>
                <td width="50"><?php echo $key['unit_name']; ?></td>
                <td width="150"><?php echo $key['bank_name']; ?></td>
                <td width="75" align="right"><?php echo price_format($key['amount']); ?></td>
            </tr>

        <?php } 

        } 
        else
        { ?>
            <tr><td colspan="7" align="center">-No Records Found- </td></tr>

        <?php }?>
        
        <?php if($sno>1)
        { ?>
        	<tr><td colspan="5" align="right">Grand Total</td>
        	    <td align="right"> <?php echo price_format($grand_amount); ?></td>
        	</tr>
        
       <?php } ?>
        
        
    </table>
    <br><br><br><br><br><br><br><br><br><br>
    
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
    <a class="button print_element" href="<?php echo SITE_URL.'dist_dd_r';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>