<!DOCTYPE html>
<html>
<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 
</head>
<style>
    @media print {
     .print_element{display:none;}
    }
    table tr {
    height:25px;
    }
 
</style>
<body>
<h2 align="center">A.P.CO-OPERATIVE OIL SEEDS GROWER'S FEDERATION LIMITED</h2>
<h3 align="center">Purchase Order For Packing Material(<?php echo $pm_results['plant_name'];?>)</h3>
<br>
 <?php
    if($pm_results['pm_category_id']==get_film_cat_id())
    {
        $units='Kgs';
    } 
    elseif($pm_results['pm_id']==get_tape_650mt() || $pm_results['pm_id']==get_tape_65mt())
    {
        $units='Units';
    }
    else
    {
        $units='Units';
    }
    ?>
<table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
    <tr>
	   <th align="left" colspan="1">PO Number</th>
	   <td align="left" colspan="1"><?php echo $pm_results['po_number'];?></td>
	</tr>
	<tr>
	   <th align="left" colspan="1">PO Date</th>
	   <td align="left" colspan="1"><?php echo date('d-m-Y',strtotime($pm_results['po_date']));?></td>
    </tr>
    <tr>
       <th align="left" colspan="1">PO Type</th>
	   <td align="left" colspan="1"><?php echo $pm_results['type_name'];?></td>
	</tr>
    <tr>
      <?php if($pm_results['mtp_number'] !='') { ?>
	   <th align="left" colspan="1">MTP No</th>
	   <td align="left" colspan="1"><?php echo $pm_results['mtp_number'];?></td>
	   <?php } else { ?>
	   <th align="left" colspan="1">MTP No</th>
	   <td align="left" colspan="1">--</td>
	   <?php } ?>
    </tr>
    <tr>
	   <th align="left" colspan="1">Packing Material</th>
	   <td align="left" colspan="1"><?php echo $pm_results['packing_name'];?></td>
	</tr>
	<tr>
	   <th align="left" colspan="1">Supplier</th>
	   <td align="left" colspan="1"><?php echo ($pm_results['supplier_name'].'['.$pm_results['supplier_code'].']');?></td>
    </tr>
    <tr>
	   <th align="left" colspan="1">Unit Price</th>
	   <td align="left" colspan="1"><?php echo $pm_results['unit_price'];?></td>
    </tr>
    <tr>
	   <th align="left" colspan="1">Quoted Quantity</th>
	   <td align="left" colspan="1"><?php echo ' '. $pm_results['pp_quantity'].' '.$units; ?></td>
	</tr>
	<tr>
	   <?php if($pm_results['pp_quantity'] >= (@$pm_received_qty/$meters)) { ?>
	    <th align="left" colspan="1">Pending Quantity</th>
        <td><?php echo ($pm_results['pp_quantity']- (@$pm_received_qty/$meters)).' '.$units;?></td> 
        <?php } else { ?> 
        <th align="left" colspan="1">Exceeded Quantity </th>
        <td><?php echo ((@$pm_received_qty/$meters)- $pm_results['pp_quantity']).' '.$units;?></td>
        <?php } ?> 
	</tr>
	<tr>
	   <th align="left" colspan="1">Received Quantity</th>
	   <?php if((@$pm_received_qty/$meters) !='') { ?>
	   <td align="left" colspan="1"><?php echo ' '. (@$pm_received_qty/$meters).' '.$units; ?>  </td>
	   <?php } else { ?>
	    <td align="left" colspan="1"><?php echo ' '. '0 '.$units; ?>  </td>
	   <?php } ?>
	</tr>
	<tr>
	   <th align="left" colspan="1">Status</th>
	   <td align="left" colspan="1"><?php echo  get_po_pm_status_value($pm_results ['status']);?></td>
    </tr>
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
    <?php if(@$pm_id==2)
    { ?>
    <a class="button print_element" href="<?php echo SITE_URL.'pm_report';?>">Back</a>
    <?php }
    else
    {?>
    	<a class="button print_element" href="<?php echo SITE_URL.'po_packing_material';?>">Back</a>
    <?php }
    ?>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>
