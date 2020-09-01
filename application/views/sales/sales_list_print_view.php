<!DOCTYPE html>
<html>
<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 
</head>
<style type="text/css">
    table tr td{
        height: 30px !important;
    }
</style>
<body >
<h2 align="center">AP Cooperative Oilseeds Growers Federation Ltd</h2>
<h4 align="center">Total sales of <?php echo date('F d, Y, h:i:s A') ?></h4>
	<table border="1px" align="center" width="500" cellspacing="0" cellpadding="2">
		<thead>
			<th>Units</th>
			<th>Total Sales(MT's)</th>
		</thead>
		<tbody>
			<?php
			if(count($sales_scroll)>0)
			 {
				foreach($sales_scroll as $row)
				{
					 ?>
							<tr>
								<td><?php echo $row['plant_name'];?></td>
								<td align="right"><?php echo qty_format($row['pending_qty']); ?></td>
							</tr> <?php
				} 
			}
			?>
		</tbody>
		<tfoot>
			<tr>
				<td><b>Total Sales</b></td>
				<td align="right"><b><?php echo qty_format($sales_sum); ?></b></td>
			</tr>
		</tfoot>
	</table><br>
<div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL;?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>
