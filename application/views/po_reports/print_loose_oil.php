<!DOCTYPE html>
<html>
<head>
    <title>Po Oils Print</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 
</head>
<style>
    table tr {
    height:25px;
    }
 
</style>
<body>
<h2 align="center">A.P.CO-OPERATIVE OIL SEEDS GROWER'S FEDERATION LIMITED</h2>
<h3 align="center">Purchase Order For Loose Oil (<?php echo $loose_oil_results['plant_name'];?>)</h3>
<br>
<table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
    <tr>
	   <th align="left" colspan="1">PO Number</th>
	   <td align="left" colspan="1"><?php echo $loose_oil_results['po_number'];?></td>
	</tr>
	<tr>
	   <th align="left" colspan="1">PO Date</th>
	   <td align="left" colspan="1"><?php echo date('d-m-Y',strtotime($loose_oil_results['po_date']));?></td>
    </tr>
    <tr>
       <th align="left" colspan="1">PO Type</th>
	   <td align="left" colspan="1"><?php echo $loose_oil_results['type_name'];?></td>
	</tr>
    <tr>
      <?php if($loose_oil_results['mtp_number'] !='') { ?>
	   <th align="left" colspan="1">MTP No</th>
	   <td align="left" colspan="1"><?php echo $loose_oil_results['mtp_number'];?></td>
	   <?php } else { ?>
	   <th align="left" colspan="1">MTP No</th>
	   <td align="left" colspan="1">--</td>
	   <?php } ?>
    </tr>
    <tr>
	   <th align="left" colspan="1">Loose Oil</th>
	   <td align="left" colspan="1"><?php echo $loose_oil_results['loose_name'];?></td>
	</tr>
	<tr>
	   <th align="left" colspan="1">Supplier</th>
	   <td align="left" colspan="1"><?php echo ($loose_oil_results['supplier_name'].'['.$loose_oil_results['supplier_code'].']');?></td>
    </tr>
    <tr>
	   <th align="left" colspan="1">Broker</th>
	   <td align="left" colspan="1"><?php echo ($loose_oil_results['broker_name'].'['.$loose_oil_results['broker_code'].']');?></td>
	</tr>
	<tr>
	   <th align="left" colspan="1">Unit Price</th>
	   <td align="left" colspan="1"><?php echo price_format($loose_oil_results['unit_price']);?></td>
    </tr>
    <tr>
	   <th align="left" colspan="1">Quoted Quantity</th>
	   <td align="left" colspan="1"><?php echo qty_format($loose_oil_results['quoted_qty']);?></td>
	</tr>
	<tr>
	   <th align="left" colspan="1">Pending Quantity</th>
	   <td align="left" colspan="1"><?php echo qty_format(($loose_oil_results['quoted_qty']- $loose_oil_results['received_qty']));?></td>
	</tr>
	<tr>
	   <th align="left" colspan="1">Received Quantity</th>
	   <?php if($loose_oil_results['received_qty']!='')
	   { ?>
	   <td align="left" colspan="1"><?php echo qty_format($loose_oil_results['received_qty']);?></td>
	   <?php }
	   else
	    { ?>
          <td align="left" colspan="1">0</td>
        <?php } ?>
    </tr>
    <tr>
	   <th align="left" colspan="1">Status</th>
	   <td align="left" colspan="1"><?php echo get_po_status_value($loose_oil_results['status']);?></td>
    </tr>
</table>
<br><br><br><br><br><br>
    
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
    <?php if(@$oil_id==3)
    { ?>
    <a class="button print_element" href="<?php echo SITE_URL.'loose_oil_report';?>">Cancel</a>
    <?php }
    elseif(@$mtp_oil_ids!='')
    {?>
    	<a class="button print_element" href="<?php echo SITE_URL.'tender_process_details';?>">Cancel</a>
    <?php }
    else{?>
    	<a class="button print_element" href="<?php echo SITE_URL.'oil';?>">Cancel</a>
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