<!DOCTYPE html>
<html>
<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 
</head>
<body>
	<h2 align="center">A.P.CO-OPERATIVE OIL SEEDS GROWER'S FEDERATION LIMITED</h2>
	<h3 align="center"><?php if($supplier_type!=''){ echo $supplier_type.' ';}?>Supplier Details</h3>
	<h4 align="center"><?php echo date('F, d, Y h:i:s A')?></h4>
	<br>
	<div class="table-scrollable">
        <table border="1px" align="center" width="1000" cellspacing="0" cellpadding="2">
            <thead>
                <tr style="background-color:#cccfff">
                	<th width="45">S. No</th>
                    <?php
                    if($supplier_type=='')
                    {
                    ?>
                    <th width="110">Supplier Type</th>
                    <?php
                    }
                    ?>
                	<th width="250">Agency Name [Code]</th>
                	<th width="200">Concerned Person</th>
                	<th width="200">Address</th>
                	<th width="150">Contact Nos</th>
                	<th width="45">Status</th>
                </tr>
            </thead>
            <tbody>
            	<?php $sn = 1;
                if($supplier_reports)
                {
                    foreach($supplier_reports as $row)
                    {
                        $contact_nos = array();
                        if($row['mobile']!='')
                        $contact_nos[] = trim($row['mobile'],', ');
                        if($row['alternate_mobile']!='')
                        $contact_nos[] = $row['alternate_mobile'];
                ?>
            	<tr>
            		<td> <?php echo $sn++ ?> </td>
                    <?php
                    if($supplier_type=='')
                    {
                    ?>
                    <td align="left"> <?php echo $row['type'] ?> </td>
                    <?php
                    }
                    ?>
            		<td align="left"> <?php echo $row['agency_name'].' ['.$row['supplier_code'].']' ?> </td>
            		<td align="left"> <?php echo $row['concerned_person'] ?> </td>
            		<td align="left"> <?php echo $row['address'] ?> </td>
            		<td align="left"><?php echo implode(', ', $contact_nos);?></td>
            		<td> <?php if($row['status']==1)
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
                    <tr><td colspan="6" align="center"><span class="label label-primary">No Records</span></td></tr>
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
    <a class="button print_element" href="<?php echo SITE_URL.'supplier_view_r';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>