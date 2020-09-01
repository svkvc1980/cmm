<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
</head>
<br>
<body>
<h2 align="center">A.P.CO-OPERATIVE OIL SEEDS GROWER'S FEDERATION LIMITED</h2>
<h3 align="center">Executive Wise DD Payments <span style="margin-left: 50px"><b>From :</b> <?php echo date('d-m-Y',strtotime($from_date));?>
            <span style="margin-left: 50px"><b>To :</b> <?php echo date('d-m-Y',strtotime($to_date));?> </span></span></h3>
<h3 align="center"> <?php echo '<b> Executive: </b>'.$executive_list['name']; ?></h3>
<br>

<table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
    <?php 
    	if(count($results)>0) 
    	{
	         $sno=1; $grand_total = 0;
	         foreach($results as $key)
	          {
		         if($sno==1)
		         { ?>
		        <tr style="background-color:#cccfff">   
	    		<th  width="50">S.No</th>
	    		<th  width="200">DD.No / Date</th>
	            
	            	<th  width="250"> Distributor </th>
	            	<th  width="75"> Unit </th>
	            	<th  width="150"> Bank Name </th>
	            	<th  width="75"> Amount </th>
	        	</tr>
		       <?php  } 
		       $grand_total+= $key['amount']?>
				
			<tr> 
			    <td width="50"><?php echo $sno++; ?></td>
	                <td width="200"><?php echo $key['dd_number'].' / '.date('d-m-Y',strtotime($key['payment_date'])); ?></td>
	                <td width="250"><?php echo $key['agency_name'].' ['.$key['distributor_code'].'] ['.$key['distributor_place'].']'; ?></td>
	                <td width="75"><?php echo $key['unit_name']; ?></td>
	                <td width="150"><?php echo $key['bank_name']; ?></td>
	                <td width="75" align="right"><?php echo price_format($key['amount']); ?></td>
		 </tr>
      <?php } } else  { ?>
      <tr>
      	<td colspan ="7" align="center">No Records Found </td>
      </tr>
    <?php  } ?>
    <?php if($sno>1)
        { ?>
        	<tr><td colspan="5" align="right">Grand Total</td>
        	    <td align="right"> <?php echo price_format($grand_total); ?></td>
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
<a class="button print_element" href="<?php echo SITE_URL.'exec_wise_dist_list';?>">Back</a>
</div>
</body>
<script type="text/javascript">
function print_srn()
{
    window.print(); 
}
</script>
