<!DOCTYPE html>
<html>
<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 

</head>
<style>
table tr td{
  height:20px !important;
}
</style>

<body>

<h2 align="center">AP Cooperative Oilseeds Growers Federation Ltd</h2>
<br>
<table style="border:none !important" align="center" width="750">
      <tr style="border:none !important">
        <td style="border:none !important">
          <span style="margin-left:0px;"><b>DETAILS OF SALE OF OILS From :</b>  <?php echo format_date($from_date) ?> <b>To : </b> <?php echo format_date($to_date) ?>  </span>
        </td>
     </tr>
    </table>

    <table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
       <thead style="background-color:#cccfff">
          <tr>
          <th  width="50">Sno</th>
          <th  width="300">Place</th>
          <th width="200">Qty(MT)</th>
          <th width="200">Value(Rs.Ps)</th>
          </tr>
        </thead>
       <?php
        $sn=1;
        $total_qty=0;
        $total_price=0;
        if(@$units)
        {
          foreach(@$units as $key =>$value)
          {  
                 $total_qty+=@$dsr[$value['plant_id']]['quantity'];
                 $total_price+=@$dsr[$value['plant_id']]['price'];
            ?>
            <tr>
              <td ><?php echo $sn++; ?></td>
              <td ><?php echo $value['plant_name'];?></td>
              <td  align="right"><?php if(@$dsr[$value['plant_id']]['quantity'] !='') { echo qty_format($dsr[$value['plant_id']]['quantity']); } else { echo qty_format('0'); } ?></td>
              <td  align="right"><?php if(@$dsr[$value['plant_id']]['price'] !='') { echo price_format($dsr[$value['plant_id']]['price']); } else { echo price_format('0'); } ?> </td>
               </tr> <?php
          }
           ?> 
           <tr>
                <td colspan="2" align="right"><b>Total</b></td>
                <td align="right"><b><?php  echo qty_format($total_qty) ; ?></b></td>
                <td align="right"><b><?php  echo price_format($total_price) ; ?></b></td>
               
           </tr>
      <?php  }
        else
        { ?>
            <tr>
            <td colspan="4" align="center"><b>No Records Found </b> </td>
            </tr>
        <?php }
        ?>
    </table><br>
<!--     <table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
      <tr style="background-color:#cccfff">
        <th  width="350"></th>
        <th width="190">Qty(MT)</th>
        <th>Value</th>
        
    </tr>
    <tr>
        <td >Grand Total On <?php echo format_date($from_date) ?> </td>
        <td align="right"><?php echo qty_format($total_qty); ?></td>
        <td align="right"><?php echo price_format($total_price); ?></td>
       
    </tr>
    <tr>
        <td >Upto <?php echo format_date($prev_date) ?></td>
        <td align="right"><?php $pd=$previous_sales['pre_mt_in_kg']; if($pd !=''){ echo qty_format($pd) ; } else { echo 0; } ?></td>
        <td align="right"><?php $pds=$previous_sales['pre_amount']; if ($pds !='') { echo price_format($pds); } else { echo 0; }?></td>
        
    </tr>
    <tr>
        <td width="300"><b>Cumulatives Upto <?php echo format_date($from_date) ?></b></td>
        <td align="right"><b><?php $pd=$total_qty+$previous_sales['pre_mt_in_kg']; echo qty_format($pd);?></b></td>
        <td align="right"><b><?php $pds=$total_price+$previous_sales['pre_amount']; echo price_format($pds);?></b></td>
       
    </tr>
    </table> -->
    <br>
    <br><br>
    <table style="border:none !important" align="center" width="750">
      <tr style="border:none !important">
        <td style="border:none !important">
          <span style="margin-left:0px;"><b>ALL EXECUTIVES SALES From </b>  <?php echo format_date($from_date).'<b>'.' To '.'</b>'.format_date($to_date) ; ?> </span>
        </td>
     </tr>
    </table>
    <table border="1px" align="center" width="750" cellspacing="0" cellpadding="2">
       <thead style="background-color:#cccfff">
          <tr>
            <td></td>
            <?php foreach($exec as $ex) { ?>
            <th><?php echo $ex['short_name']; ?></th>
            <?php } ?>
            <td>Total</td>
          </tr>
          <tr>
            <td>Product</td>
            <?php foreach($exec as $ex) { ?>
            <td></td>
            <?php } ?>
            <td></td>
          </tr>
       </thead>
       <tbody>
       <?php foreach($oils as $k2 =>$v2) { 
       $quantity=0; ?>
        <tr>
        <td><?php echo $v2['name'];?></td>
        <?php foreach($exec as $row) { 
        $quantity+=@$edsr[$v2['loose_oil_id']][$row['executive_id']]['mt_in_kg']; ?>
            <td align="right"> <?php if(@$edsr[$v2['loose_oil_id']][$row['executive_id']]['mt_in_kg'] !='') { echo qty_format($edsr[$v2['loose_oil_id']][$row['executive_id']]['mt_in_kg']); } else { echo qty_format('0') ; } ?></td>
          <?php  } ?>
          <td align="right"><?php echo qty_format($quantity); ?></td>
        </tr>
      <?php } ?>
      <tr>
        <td align="right"><b>Total Qty</b></td>
        <?php $grand_total=0;
        foreach($exec as $row)
        {
           $total_qty=0;
            foreach($oils as $k5=>$v5)
            {
                $total_qty+=@$edsr[$v5['loose_oil_id']][$row['executive_id']]['mt_in_kg'];
                $grand_total+=@$edsr[$v5['loose_oil_id']][$row['executive_id']]['mt_in_kg'];
            } ?>
            <td align="right"><b><?php echo qty_format($total_qty); ?></b></td>
       <?php  } ?>
             <td align="right"><b><?php echo qty_format($grand_total); ?></b></td>
      </tr>
       </tbody>
    </table>
    <br>
    <br>
    <br><br><br><br><br>
    
        <table style="border:none !important" align="center" width="750">
            <tr style="border:none !important" >
            <td style="border:none !important; margin-left:10px">Executive(MKtg)</td>
            <td style="border:none !important">Dy.Manager(MKtg)</td>
            <td style="border:none !important">Manager(MKtg)</td>   
            <td style="border:none !important">V.C. & M.D.</td>
            </tr>
        </table>
    <br><br>
    <div class="row" style="text-align:center">
    <button class="button print_element"  style="background-color:#3598dc" onclick="print_srn()">Print</button>
    <a class="button print_element" href="<?php echo SITE_URL.'monthly_sales_report_md';?>">Back</a>
    </div>
</body>
</html>
<script type="text/javascript">
function print_srn()
{
    window.print(); 
}
</script>
    