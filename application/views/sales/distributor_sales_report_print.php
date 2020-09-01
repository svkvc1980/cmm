<!DOCTYPE html>
<html>
<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 
</head>
<body>
<h2 align="center">AP Cooperative Oilseeds Growers Federation Ltd</h2>
<table border="1px" style="border:none !important" align="center" width="750" cellspacing="0" cellpadding="2">
<tr>
    <td style="border:none !important" align="center">Distributor Sales report    From <?php echo date('d-m-Y', strtotime($from_date)) ?> TO <?php echo date('d-m-Y', strtotime($to_date)) ?> </td>
</tr>

</table>
<br>
 <table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
       <tr style="background-color:#cccfff">
       		<th>Sno</th>
       		<th>Agency Name /Code /Area /Executive</th>
            <th>Quantity(MT)</th>
       		<th>Amount</th>
            <th>Percentage</th>
      </tr>
      <?php 
      if(count($dist_sale_results) > 0)
      { 
      	$sno=1;
      	$total_qty=0;
      	$total_amount=0;
        $top1=0;$top2=0;$top3=0;$top4=0;$top5=0;$top6=0;$top7=0;$top8=0;$top9=0;$top10=0;$top11=0;
      	foreach($dist_sale_results as $row) { 
      		$total_qty+=$row['qty_in_kg'];
      		$total_amount+=$row['amount'];
      		?>
      	<tr>
      		<td> <?php echo $sno++; ?></td>
      		<td> <?php echo $row['agency_name'].' ['.$row['distributor_code'].'] '.$row['location_name'].' ('.$row['executive_name'].')'; ?></td>
      		<td align="right"> <?php echo qty_format($row['qty_in_kg']);?></td>
      		<td align="right" <?php if($sno <=11) { ?> style="color:red" <?php } ?> > <?php echo price_format($row['amount']);?></td>
            <td align="right"><?php $t1=($row['qty_in_kg']/$total_percent)*100; echo round(($row['qty_in_kg']/$total_percent)*100,3).'%'; ?></td>
      	</tr>
        <?php  
        $value=($row['qty_in_kg']/$total_percent);
         if($t1>=5)
                    $top1=$top1+1;
                    
                    if($t1>=3 && $t1<5)
                    $top2=$top2+1;
                    
                    if($t1>=2 && $t1<3)
                    $top3=$top3+1;
                    
                    if($t1>=1 && $t1<2)
                    $top4=$top4+1;
                    
                    if($t1>0.8 && $t1<1)
                    $top5=$top5+1;

                    if($t1>0.4 && $t1<0.8)
                    $top6=$top6+1;
                    
                    if($t1>0.10 && $t1<0.4)
                    $top7=$top7+1;
                    
                    if($t1>0.05 && $t1<0.10)
                    $top8=$top8+1;
                    
                    if($t1>0 && $t1<0.05)
                    $top9=$top9+1;
                    
                    if($t1<=0)
                    $top10=$top10+1;
                    if($value>3 && $value<5)
                    $top1=$top1+1;

      } ?>
          <tr>
           	<td colspan="2" align="right">Total</td>
           	<td align="right"><?php echo qty_format($total_qty); ?></td>
           	<td align="right"><?php echo price_format($total_amount); ?></td>
            <td></td>
           	</tr>
      <?php } 
     
        else
        { ?>
            <tr>
            <td colspan="5" align="center"><b>No Records Found </b> </td>
            </tr>
        <?php }
        ?>
        </table>
        <br><br><br>
         <table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
         <tr> 
            <td colspan="2"> 
              <div align="center"><b><font size="2">
                Performance at a glance</font></b></div>
            </td>
          </tr>
          <tr> 
            <td width="49%"><b><font size="2">Percentage 
              Range</font></b></td>
            <td width="51%"><b><font size="2">Number 
              of Distributors</font></b></td>
          </tr>
          <tr> 
            <td width="49%"><font size="2"> 
              Above 5%</font></td>
            <td width="51%"><font size="2"> 
              <?php echo $top1 ?>
              Distributors </font></td>
          </tr>
          <tr> 
            <td width="49%"> <font size="2">3% 
              - 5%</font></td>
            <td width="51%"> <font size="2"> 
<?php echo $top2 ?>              Distributors&nbsp; </font></b></td>
          </tr>
          <tr> 
            <td width="49%"> <font size="2">2% 
              - 3%</font></td>
            <td width="51%"> <font size="2"> 
              <?php echo $top3 ?>
              Distributors</font></td>
          </tr>
          <tr> 
            <td width="49%"><font size="2">1% 
              - 2%</font></td>
            <td width="51%"><font size="2"> 
              <?php echo $top4 ?>
              Distributors</font></td>
          </tr>
          <tr> 
            <td width="49%"><font size="2">0.8% 
              - 1%</font></td>
            <td width="51%"><font size="2"> 
              <?php echo $top5 ?>
              Distributors</font></td>
          </tr>
          <tr> 
            <td width="49%"><font size="2">0.4% 
              - 0.8%</font></td>
            <td width="51%"><font size="2"> 
              <?php echo $top6 ?>
              Distributors</font></td>
          </tr>
          <tr> 
            <td width="49%"><font size="2">0.10% 
              - 0.4%</font></td>
            <td width="51%"><font size="2"> 
              <?php echo $top7 ?>
              Distributors</font></td>
          </tr>
          <tr> 
            <td width="49%"><font size="2">0.05% 
              - 0.10%</font></td>
            <td width="51%"><font size="2"> 
              <?php echo $top8 ?>
              Distributors</font></td>
          </tr>
          <tr> 
            <td width="49%"><font size="2">Greater 
              than 0% - 0.05%</font></td>
            <td width="51%"><font size="2"> 
              <?php echo $top9 ?>
              Distributors</font></td>
          </tr>
          <tr> 
            <td width="49%"><font size="2">Zero 
              Transactions</font></td>
            <td width="51%"><font size="2"> 
              <?php echo $top10 ?>
              Distributors</font></td>
          </tr>
          <tr> 
            <td colspan="2">&nbsp;</td>
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
    <a class="button print_element" href="<?php echo SITE_URL.'distributor_sales_report';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>