<html>
<style type="text/css">
	table, td, th{
		border: 1px solid black;
		border-collapse: collapse;
	}
</style>
<body>
<br>
<h2 align="center">A.P.CO-OPERATIVE OIL SEEDS GROWER'S FEDERATION LIMITED</h2>
<h3 align="center">Tanker Details</h3>
<h2 align="center">Tanker In  Number : <?php echo $tanker_details[0]['tanker_in_number']; ?></h2>

	<br>
	<table width="50%" align="center">
		<?php foreach ($tanker_details as $tanker) { ?>
		<tr>
			<th>Unit Name</th>
			<td><?php echo $this->session->userdata('plant_name'); ?></td>
		</tr>
		<tr>
			<th>Product</th>
			<td><?php
                switch ($tanker['tanker_type_id']) 
                {
                    case 1:
                        echo $tanker['loose_oil'];
                    break;

                    case 2:
                        echo $tanker['packing_material'];
                    break;

                    case 5:
                        echo $tanker['free_gift'];
                    break;    
                     
                    default:
                        echo "--";
                    break;
                }?>
        	</td>
		</tr>
		<tr>
			<th>Tanker In Number</th>
			<td><?php echo $tanker['tanker_in_number'] ?></td>
		</tr>
		<tr>
			<th>Tanker Type</th>
			<td><?php echo $tanker['tanker_name']; ?></td>
		</tr>
		<tr>
			<th>Party Name</th>
			<td><?php echo $tanker['party_name'] ?></td>
		</tr>
		<tr>
			<th>Broker Name</th>
			<td><?php echo $tanker['broker_name'] ?></td>
		</tr>
		<tr>
			<th>In time </th>
			<td><?php echo date('d-m-Y H:i:s',strtotime($tanker['in_time'])); ?></td>
		</tr>
		<tr>
			<th>Out time </th>
			<td><?php if($tanker['out_time']!=''){ echo date('d-m-Y H:i:s',strtotime($tanker['out_time'])); }?></td>
		</tr>
		<tr>
			<th>Remarks 1 </th>
			<td><?php echo $tanker['remarks1'] ?></td>
		</tr>
		<tr>
			<th>Remarks 2</th>
			<td><?php echo $tanker['remarks2'] ?></td>
		</tr>

		<?php } ?>
	</table>
</body>
</html><br>
<div class="row" style="text-align:center">
    <button class="button"  onclick="print_srn()" style="background-color:#3598dc; color:white;">Print</button>
    <a type="button" class="button" href="<?php echo SITE_URL.'tanker_register';?>">Back</a>
</div>
</body>
<script type="text/javascript">
    function print_srn()
    {
        window.print(); 
    }
</script>