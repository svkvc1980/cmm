<head>
	<title>Dist. Invoice Print</title>
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 
</head>
<style>
body,table,td {
    margin: 0;
    padding: 0;
    font: 12px;


}
table {
    border-collapse: collapse;
}
table, th, td {
    border: 1px solid black;
}
.header {
    position: relative;
    height: 130px;
}
.data1 {
    position: relative;
    height: 200px;
}
.data2 {
    position: relative;
    height: 540px;
}

.data3 {
    position: relative;
    height: 50px; 
}
.footer {
    position: relative;
    height: 180px;
}
table.product_info td {
    border-bottom: none;
    border-top: none;
    position: relative;
}
.header1 {
    margin-top:5px;
}
.page {
    width: 21cm;
    min-height: 29.7cm;
    padding: 0cm;
    margin: 1cm auto;
    background: white;
   
     background: url('<?php echo assets_url() . "layouts/layout3/img/30.png"; ?>');
    background-repeat: no-repeat;
    background-position: center;
    background-size: 450px 400px;
    opacity: 1;
    z-index: -1;
}

@page {
  size: A4;
  margin: 0cm auto;
}
@media print 
{
  html, body 
  {
    width: 21cm;
    height: 29.7cm;
    margin:10px;
  }
  .no-print, .no-print *
    {
        display: none !important;
    }
}
.terms {
    font-size: 10px;
}
.terms ul{
    list-style-type: decimal;
    padding: 0px 0px 0px 15px;

}
.terms ul li{
    margin: 5px 0px;
}
.terms ul li.eoe{
    list-style: none;
    float: right;
    margin-right: 5px;
}
.forap{
    margin-top: 5px;
    font-size: 13px;
} 
.authorised_signature{
    margin-left:10%;
    position: absolute;
    bottom: 0;
}
.tax {
    margin-left: 270px;
}
.highlight {
    font-size: 11px;
}
.label {
    width: 400px;
}
.instruction {
    font-size: 12px;
    margin:8px; 
    position: absolute;
    bottom: 0;
}
.tin {
    position: absolute;
    bottom: 0;
    font-size: 14px;

}
.address {
    font-size: 14px;
    margin-left: 8px;
    margin-top: 8px;
}
.invoice {
    font-size: 14px;
    margin-left: 5px;
    margin-top: 8px;
}
</style>
<body>
   
    <div class="page">
        <div class="header">
            <table width="100%"  class="header" style="border-bottom: none;">
                <tr  style="border-bottom: 0px;">
                    <td width="10%" style="border-right: 0px;">
                         <img src='<?php echo assets_url()."layouts/layout3/img/fullcolor.png"?>' style="max-width:100%; height:auto; padding: 15px; margin:2px;"/>
                    </td>
                    <td width="90%" style="border-left: 0px;">
                        
                        <span align="center" style="color: green;margin-left:35px;font-size: 23px;" class="header1"><b>Andhra Pradesh Cooperative Oilseeds Grower's Federation Ltd.</b></span>
                        <br>

                        <span align="center" style="margin-left: 115px;"> 3rd Floor, 'C' Block, BRKR Bhavan, Saifabad, Hyderabad - 500063.</span><br>
                        
                        <span align="center" style="margin-left: 115px;">Phone & Fax No : 040-23220360, email : apoilfedbrkr@gmail.com </span>
                        <br><br>


                        <span class="tax"><b>TAX INVOICE</b></span>
                    </td>
                </tr>
            </table>
        </div>
        <div class="data1">
        <table  class="data1" align="center" width="100%">
            <tr>
                <td width="50%" style="height: 127px;" valign="top">
                    <div class="address">
                    To<br>
                        <b><?php 
//$to_location = ($distributor['location_id']==2||$distributor['location_id']==3)?$distributor['distributor_place']:$distributor['location_name'];
echo @$distributor['agency_name'].' - [ '. @$distributor['distributor_code'].' ]';?></b><br>
                        Address : <?php echo @$distributor['address'].','.$distributor['distributor_place'];?>
                        <br><br>
                        

                    TIN No : <?php echo @$distributor['vat_no'];?><span style="margin-left: 60px;"> Phone : <?php echo @$distributor['mobile'];?></span>
                    </div>
                </td>
                <td width="50%" rowspan="2" valign="top">
                    <div class="invoice">
                        <div class="label">
                            <b>INVOICE No. </b><span>: <?php echo ' '. $inv_products[0]['invoice_number'];?></span>
                            <span style="margin-left: 30px;"><b>Date :</b></span>
                            <span>
                                <?php echo ' '. date('d-m-Y',strtotime($inv_products[0]['invoice_date'])); ?>
                            </span>
                        </div><br>

                        <div>
                            <b>O.B No :</b><?php echo $inv_obs;?>
                            <span style="margin-left: 20px;"><b>Date :</b><?php echo $inv_ob_dates;?></span>
                        </div><br>
                        <div>
                            <b>D.O No :</b>
                                <?php echo $inv_dos;?>
                                <span style="margin-left: 20px;"><b>Date : </b><?php echo $inv_do_dates;?></span>
                        </div>
                    </div>
                    <span class="instruction"> "I/We hereby certify that food/foods mentioned in this invoice is/are warranted to be of the nature and quality which it/these purports/purport to be"</span>
                </td>
            </tr>
            <tr>
                <td valign="top">
                <div class="address">
                   Despatch through :<br>
                   LR/RR Truck No : <?php echo ' '. $inv_products[0]['vehicle_number'];?>
                   <br>From : <?php echo get_plant_name_not_in_session($inv_products[0]['plant_id']);?>
                   <span style="margin-left: 5px;">To : <?php echo @$distributor['distributor_place'];?></span>
                </div>
                </td>
            </tr>
        </table>
        </div>
        <div class="data2">
        <table class ="product_info" align="center" width="100%" cellspacing="0" cellpadding="2">
            <tr style="height:10% !important">
                <th width="5%" style="font-size: 12px;"><b>S.no</b></th>
                <th width="21%" style="font-size: 12px;"><b>Product Details</b></th>              
                <th width="7%" style="font-size: 12px;"><b>Units</b></th>
                <th width="7%" style="font-size: 12px;"><b>Cartons</b></th>
                <th width="10%" style="font-size: 12px;"><b>Qty in Kgs</b></th>
                <th width="10%" style="font-size: 12px;"><b>Price Per Unit</b></th>
                <th width="10%" style="font-size: 12px;"><b>Value</b></th>
                <th width="10%" style="font-size: 12px;"><b>Rate of VAT/CST</b></th>
                <th width="10%" style="font-size: 12px;"><b>VAT/CST Amount</b></th>
                <th width="10%" style="font-size: 12px;"><b>Total Value inc.VAT/CST</b></th>                                    
            </tr>
                <?php 
                $sno=1;
                $sum_of_qty = 0;
                $t_amount =0;
                $t_actual_amount =0;
                $t_vat_amount = 0;
                $t_pm_weight = 0;
                $t_gross = 0;
                $product_count = count($inv_products);
                foreach($inv_products as $keys =>$values)
                { 
                    if($values != '')
                    { ?>
                        <tr class="i_row">
                            <td align="center"><?php echo $sno++?></td>
                            <td > <?php echo $values['short_name']; ?> </td>
                            <td align="right"> <?php echo round($values['packets']); ?></td>
                            <td align="right"> <?php echo round($values['carton_qty'],2); ?></td>
                            
                            <td align="right"> <?php echo qty_format($values['qty_in_kg']); ?></td>
                            <td align="right"> <?php echo price_format($values['rate']); ?></td>
                            <?php
                                // total oil weight
                                $sum_of_qty = $sum_of_qty + $values['qty_in_kg'];
                                 // total pm weight
                                $t_pm_weight = $t_pm_weight + $values['pm_weight'];
                                // Total Gross
                                $t_gross = $sum_of_qty + $t_pm_weight ; 
                                // total incl.VAT
                                $t_amount =$t_amount + $values['amount']; 

                                $actual_amount =(($values['amount']*100)/(100+$inv_products[0]['vat_percent']));
                                $vat_amount = $values['amount'] - $actual_amount;
                                // total actual value
                                $t_actual_amount = $t_actual_amount + $actual_amount;
                                // total vat value
                                $t_vat_amount = $t_vat_amount + $vat_amount;
                            ?>
                            <td align="right"> <?php echo price_format($actual_amount);?></td> 
                            <td align="right"> <?php echo $inv_products[0]['vat_percent'];?></td>                                                       
                           
                            <td align="right"><?php echo price_format($vat_amount);?> </td>
                            <td align="right"> <?php echo price_format($values['amount']); ?></td>
                        </tr><?php }        }
                $column_count = 10;
                $inv_count = isset($invoice_pm)?count($invoice_pm):0;
                $horizontal_line = 26-$product_count-$inv_count;
                for($i = 1; $i <= $horizontal_line; $i++)
                { ?>
                    <tr> <?php
                        for($j = 1; $j<= $column_count; $j++)
                        { ?>
                            <td>&nbsp;</td>
                       <?php } ?>

                    </tr>
               <?php  }
               if(isset($invoice_pm))
                {   $sn1 =1;
                    foreach($invoice_pm as $key =>$value)
                    { 
                        if($values != '')
                        { ?>
                            <tr class="i_row">
                                <td align="center"><?php echo $sn1++?></td>
                                <td ><span style="margin-left:3px;"> <?php echo get_pm_code($value['pm_id']); ?></span> </td>
                                <td align="right"><span style="margin-right:3px;"><?php echo TrimTrailingZeroes($value['quantity']); ?></span></td>
                                <td align="right"><span style="margin-right:3px;"></span></td>
                                
                                <td align="right"><span style="margin-right:3px;"></span></td>
                                <td align="right"><span style="margin-right:3px;"></span></td>

                                <td align="center">  </td> 
                                <td align="center">  </td>
                                <td align="center">  </td>
                                <td align="right"><span style="margin-right:3px;"></span></td>
                            </tr><?php 
                        }        
                    }
                }


                ?>
                <tr>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>                                             
                    <td align="right"><b><?php echo qty_format($sum_of_qty);?></b></td>
                    <td> </td>
                    <td align="right"><b><?php echo price_format($t_actual_amount);?></b></td> 
                    <td> </td>
                    <td align="right"><b><?php echo price_format($t_vat_amount);?></b></td>
                    <td ></td>
                </tr>
        </table>
        </div>
        <div class="data3">
        <table width="100%">
        <tr style="height: 25px">
            <td width="50%">Gross Wt : <b><?php echo qty_format($t_gross);?></b></td>
            <td width="50%" align="right">Total : <b><?php echo price_format($t_amount);?></b></td>
        </tr>
        <tr style="height: 25px">
            <td width="100%" colspan="2">
                Rupees in words : <?php echo ucfirst(convert_number_to_words(round($t_amount))); ?>
            </td>
        </tr>
        </table>
        </div>
        <div class="footer">
            <table>
                <tr>

                <td width="40%" class="terms" rowspan="2">
                    <ul>
                        <li>All disputes are subject to Hyderabad Jursidiction Only.</li>
                        <li>If payment is not received with in 20 days from the date of 
                        invoice interest @ 14% will be charged.</li>
                        <li>We hereby certify that eligible oil mentioned in this
                        invoice or warrented to be of the nature and quality 
                         which they purport to be.</li>
                        <li>Our responsibility ceases on delivery of the goods
                         to the carrier or your representative.</li>
                        <li>Goods once sold will not be taken back.</li>
                        <li><b class="highlight">TIN : 37280114257</b></li>
                        <li><b class="highlight">FSSAI Lic. No.KKD : 10012044000272</b></li>
                        <li class="eoe">E. & O.E.</li>
                    </ul>
                </td>
                <td width="20%" valign="top" align="center" height="75px">
                    Prepared by
                    
                </td>
                 <td width="40%" valign="top" rowspan="2" class="footer3">
                    <p class="forap">For <b>Andhra Pradesh Co-op Oilseeds Grower's Fedn.Ltd</b></p>
                        <p class="authorised_signature" align="center">Authorised Signatory</p>
                </td>
            </tr>
            <tr>
                <td>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="center" height="28px">
                    <p style="font-size: 13px;">D.No.55-17, 2 to 4, 4th Floor, "C" Block, Road No.2, Jawahar Autonagar, Vijayawada - 520007, Ph: 0866-2974545, Krishna Dist. AP.</p>
                </td>
            </tr>
            </table>
        </div>
    </div>
    
    
<div class="row no-print" style="text-align:center">
    <button class="button"  onclick="print_srn()" style="background-color:#3598dc">Print</button>
    <a class="button" href="<?php echo SITE_URL.'manage_dist_invoice';?>">Cancel</a>
</div><br>
</body>
<script type="text/javascript">
    function print_srn()
    {
        window.print(); 
    }
</script>