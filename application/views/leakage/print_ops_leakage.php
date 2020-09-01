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
    <h4 align="center"> Leakage Report At <?php echo $this->session->userdata('plant_name') ; ?> <span style="margin-left:50px;"><?php if($search_params['from_date']!='') { echo 'From : '.format_date($search_params['from_date']); } ?></span><span style="margin-left:10px;"><?php if($search_params['to_date']!='') { echo 'To : '.format_date($search_params['to_date']); } ?></span></h4>
     <table style="border:none !important" align="center" width="750">
            <tr style="border:none !important">
            <td style="border:none !important">
            
            <span>Note : Loss amount is calculated based on current regular price</span>
            </td>
            </tr>
        </table>
    <table border="1px" align="center" width="900" cellspacing="0" cellpadding="2">
        <tr style="background-color:#cccfff">  
           <th>Sno</th> 
            <th>Product</th>
            <th>Date</th>
            <th>Leaked Cartons</th>
            <th>Leaked Pouches</th>
            <th>Recovered Cartons</th>
            <th>Recovered Oil(Kgs)</th>
            <th>Oil Loss(Kgs)</th>
            <th>Loss Amount</th>
        </tr> 
         
        <?php 
            if(count($print_ops_leakage)>0)
            {  $sn=1;
               $total_oil_loss=0;
               $total_amount_loss=0;
                foreach($print_ops_leakage as $row)
                { 
                    $oil_loss=(($row['leaked_pouches']*$row['oil_weight'])-$row['oil_recovered']);
                   $loss_amount=($oil_loss*(($latest_price_details[$row['product_id']]['old_price'])/$row['oil_weight']));
                   $total_oil_loss+=$oil_loss;
                   $total_amount_loss+=$loss_amount; ?>
                    <tr>
                        <td><?php echo $sn++?></td>
                        <td><?php echo $row['product']?></td>
                        <td><?php echo date('d-m-Y',strtotime($row['on_date']));?></td>
                        <td align="right"><?php echo $row['leakage_quantity']?></td>
                        <td  align="right"><?php echo $row['leaked_pouches']?></td>
                        <td  align="right"><?php echo $row['recovered_quantity']?></td>
                        <td  align="right"><?php echo qty_format($row['oil_recovered'])?></td>
                        <td  align="right"><?php echo qty_format($oil_loss) ; ?></td>
                       
                        <td  align="right"><?php echo price_format($loss_amount) ; ?></td>
                </tr>
            <?php 
            } ?>
                    <tr style="background-color:#cccfff">
                        <td colspan="7" align="right"><b>Grand Total</b></td>
                        <td align="right"><b><?php echo qty_format($total_oil_loss); ?></b></td>
                        <td align="right"><b><?php echo price_format($total_amount_loss); ?></b></td>
                    </tr>
         <?php   }
           else
            { ?>
            
            <tr><td colspan="9" align="center">-No Records Found- </td></tr>
            <?php }?>

        
    </table>

    <br><br><br><br><br><br><br>
    
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
    <a class="button print_element" href="<?php echo SITE_URL.'sp_leakage_r';?>">Back</a>
    </div>
</body>
<script type="text/javascript">
        function print_srn()
        {
            window.print(); 
        }
    </script>
</html>