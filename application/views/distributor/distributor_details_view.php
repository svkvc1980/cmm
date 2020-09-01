<br> <br>
<h2 align="center">AP Cooperative Oilseeds Growers Federation Ltd</h2>
<h4 align="center">Distributor Details <?php echo date('F d, Y, h:i:s A') ?></h4>
<table border="1px solid" align="center" cellspacing="0" cellpadding="2" style="width:50%">
	<tr>
		<td><b>Distributor Name</b></td>
		<td><?php echo $distributor_details[0]['concerned_person'];?></td>
	</tr>
	<tr>
		<td><b>Distributor type</b></td>
		<td><?php echo $distributor_details[0]['type_name'];?></td>
	</tr>
	<tr>
		<td><b>Distributor Code</b></td>
		<td><?php if($distributor_details[0]['distributor_code']) {echo $distributor_details[0]['distributor_code'];} else { echo '--';}?></td>
	</tr>
	<tr>
		<td><b>Agency Name</b></td>
		<td><?php if($distributor_details[0]['agency_name']) {echo $distributor_details[0]['agency_name'];} else { echo '--';}?></td>
	</tr>
	<tr>
		<td><b>Address</b></td>
		<td><?php if($distributor_details[0]['address']) {echo $distributor_details[0]['address'];} else { echo '--';};?></td>
	</tr>
	<tr>
		<td><b>Location</b></td>
		<td><?php if($distributor_details[0]['location_name']) {echo $distributor_details[0]['location_name'];} else { echo '--';}?></td>
	</tr>
	<tr>
		<td><b>Mobile Number</b></td>
		<td><?php if($distributor_details[0]['mobile']) {echo $distributor_details[0]['mobile'];} else { echo '--';}?></td>
	</tr>
	<tr>
		<td><b>Vat Number</b></td>
		<td><?php if($distributor_details[0]['vat_no']) {echo $distributor_details[0]['vat_no'];} else { echo '--';}?></td>
	</tr>
	<tr>
		<td><b>PAN Number</b></td>
		<td><?php if($distributor_details[0]['pan_no']) {echo $distributor_details[0]['pan_no'];} else { echo '--';}?></td>
	</tr>
	<tr>
		<td><b>TAN Number</b></td>
		<td><?php if($distributor_details[0]['tan_no']) {echo $distributor_details[0]['tan_no'];} else { echo '--';};?></td>
	</tr>
	<tr>
		<td><b>Aadhar Number</b></td>
		<td><?php if($distributor_details[0]['aadhar_no']) {echo $distributor_details[0]['aadhar_no'];} else { echo '--';}?></td>
	</tr>
	<tr>
		<td><b>SD Amount</b></td>
		<td><?php if($distributor_details[0]['sd_amount']) { echo $distributor_details[0]['sd_amount'];} else{echo '--';} ?></td>
	</tr>
	<tr>
		<td><b>Date Of Birth</b></td>
		<td><?php if($distributor_details[0]['date_of_birth']) { echo date('d-m-Y',strtotime($distributor_details[0]['date_of_birth']));} else { echo '--';} ?></td>
	</tr>
	<tr>
		<td><b>Agreement Start Date</b></td>
		<td><?php if($distributor_details[0]['agreement_start_date']) {echo date('d-m-Y',strtotime($distributor_details[0]['agreement_start_date']));} else {echo '--'; }?></td>
	</tr>
	<tr>
		<td><b>Agreement End Date</b></td>
		<td><?php if($distributor_details[0]['agreement_end_date']!=''&&$distributor_details[0]['agreement_end_date']!='0000-00-00') {
			$cur_date = date('Y-m-d');
            $days_diff = get_no_of_days_between_two_dates($distributor_details[0]['agreement_end_date'],$cur_date);
            $going_to_expire_days = get_going_to_expire_days();
			echo format_date($distributor_details[0]['agreement_end_date']);
			// IF Agreement going to expire
			if($days_diff>=0&&$days_diff<=$going_to_expire_days)
            {
                $exp_str = ($days_diff==0)?'Today':'in '.$days_diff.' days';
                echo ' <span style="color:#FF7300"><b>Going to Expire '.$exp_str.'<b></span>';
            }
            // IF Agreement expired
            if($days_diff<0)
            {
                echo ' <span style="color:red"><b>Expired</b></span>';
            }
			;} else{ echo '--';} ?></td>
	</tr>
	<?php
	if($type_id==1 || $type_id==3 || $type_id==5 || $type_id==6)
	{
	?>	
	<tr>
		<td><b>Available Amount</b></td>
		<td><?php echo $available_amount;?></td>
	</tr> <?php
	}
	?>

</table> <br>
<?php
if($type_id==1 || $type_id==3 || $type_id==5 || $type_id==6)
{
?>
	<table border="1px solid" align="center" cellspacing="0" cellpadding="2" style="width:60%">
		<thead>
			<th>Bank Name</th>
			<th>Account Number</th>
			<th>IFSC Code</th>
			<th>BG Amount</th>
			<th>Start Date</th>
			<th>End Date</th>
		</thead>
		<?php
			if(count(@$distributor_bank_details)>0)
			{
				foreach($distributor_bank_details as $row)
				{
					?>
					<tr>
						<td><?php echo $row['bank_name'];

						$cur_date = date('Y-m-d');
			            $days_diff = get_no_of_days_between_two_dates($row['end_date'],$cur_date);
			            $going_to_expire_days = get_going_to_expire_days();
						// IF Agreement going to expire
						if($days_diff>=0&&$days_diff<=$going_to_expire_days)
			            {
			                $exp_str = ($days_diff==0)?'Today':'in '.$days_diff.' days';
			                echo '<br><span style="color:#FF7300"><b>Going to Expire '.$exp_str.'<b></span>';
			            }
			            // IF Agreement expired
			            if($days_diff<0)
			            {
			                echo '<br><span style="color:red"><b>Expired</b></span>';
			            }
						 ?></td>
						<td><?php if($row['account_no']) {echo $row['account_no'];} else {echo '--';} ?></td>
						<td><?php if($row['ifsc_code']) {echo $row['ifsc_code'];} else {echo '--';} ?></td>
						<td><?php echo $row['bg_amount']; ?></td>
						<td><?php if($row['start_date']!=''&&$row['start_date']!='0000-00-00') { echo format_date($row['start_date']);}else {echo '--';} ?></td>
						<td><?php if($row['end_date']!=''&&$row['end_date']!='0000-00-00') { echo format_date($row['end_date']);}else {echo '--';} ?></td>
					</tr> <?php
				}
			}?>
	</table> <?php
}
?> <br>
<div class="row" style="text-align:center">
	<button class="button" onclick="print_srn()" style="background-color:#3598dc">Print</button>
</div>
<script type="text/javascript">
	function print_srn()
	{
		window.print();
	}
</script>