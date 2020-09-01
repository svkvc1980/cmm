<?php $this->load->view('commons/main_template', $nestedView); ?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="row">
        <form class="form-horizontal" action="" method="post">
            <input type="hidden" name="invoice_id" value="<?php echo $inv_products[0]['invoice_id'];?>">
                <div class="col-md-12">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                                <label align="center">TAX INVOICE</label> 
                            </div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"> </a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="row">
                                <div class="padding">
                                    <div class="col-md-12">
                                        <div class="col-md-6">
                                           <div class="form-group">
                                                <label><b>TO</b></label>                                                
                                                <h5><b><?php 
//$to_location = ($inv_products[0]['location_id']==2||$inv_products[0]['location_id']==3)?$inv_products[0]['distributor_place']:$inv_products[0]['location_name'];
echo  @$distributor['agency_name'].' <b> '.'['. @$distributor['distributor_code'].']</b>';?></b></h5>
                                                <h5><b><?php echo @$distributor['address'].',  '.@$distributor['distributor_place'];?></b></h5>
                                                <h5><b>Ph No<b style="padding-left:35px;">:&nbsp;&nbsp;&nbsp;<?php echo @$distributor['mobile'];?></b></h5>
                                                <h5><b>Tin No<b style="padding-left:30px;">:&nbsp;&nbsp;&nbsp;<?php echo @$distributor['vat_no'];?></b></h5><br>
                                                <h5><b>Despatch through<b style="padding-left:30px;">:&nbsp;&nbsp;&nbsp;<?php echo '';?></b></h5>
                                                <h5><b>LR/RR Truck No<b style="padding-left:50px;">:&nbsp;&nbsp;&nbsp;<?php echo @$inv_products[0]['vehicle_number'];?></b></h5>
                                                <h5><b>From<b style="padding-left:20px;">:&nbsp;&nbsp;&nbsp;<?php echo get_plant_name_not_in_session($inv_products[0]['plant_id']);?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>To<b style="padding-left:20px;">:&nbsp;&nbsp;&nbsp;
                                                <?php 
                                                //$to_location = ($inv_products[0]['location_id']==2||$inv_products[0]['location_id']==3)?$inv_products[0]['distributor_place']:$inv_products[0]['location_name'];
                                                echo $distributor['distributor_place'];
                                                ?></b></h5><br>
                                             </div>
                                        </div>
                                        <div class="padding">
                                            <div class="col-md-6">
                                                <div class="form-group">                                               
                                                    <label ></label> 
                                                    <h5><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Invoice No</b><b style="padding-left:30px;">:&nbsp;&nbsp;<?php echo $inv_products[0]['invoice_number'];?></b><b style="padding-left:90px;">Date</b><b style="padding-left:30px;">&nbsp;:&nbsp;&nbsp;<?php echo date('d-m-Y',strtotime($inv_products[0]['invoice_date']));?></b></h5> 
                                                    <h5><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;O.B No</b><b style="padding-left:55px;">:&nbsp;&nbsp;<?php echo $inv_obs;?></b></h5>
                                                    <h5><b style="padding-left:20px;">Date</b><b style="padding-left:70px;">&nbsp;:&nbsp;&nbsp;<?php echo $inv_ob_dates;?></b></h5><br>
                                                    <h5><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;D.O No</b><b style="padding-left:55px;">:&nbsp;&nbsp;<?php echo $inv_dos;?></b></h5>
                                                    <h5><b style="padding-left:20px;">Date</b><b style="padding-left:70px;">&nbsp;:&nbsp;&nbsp;<?php echo $inv_do_dates;?></b></h5> 
                                                </div>                                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-12">    
                                    <div class="table-scrollable">
                                        <table class="table">                                 
                                            <tr style="background-color:#cccfff">
                                                <th>Sl.No</th>
                                                <th>Product Description</th>
                                                <th>Units</th>
                                                <th>Cartons</th>
                                                <th>Qty.in Kgs</th>
                                                <th>Price Per Unit </th>
                                                <th>Value</th>
                                                <th>Rate of VAT/CST</th>
                                                <th>VAT/CST Amount</th>
                                                <th>Total Value inc.VAT/CST </th>                                       
                                            </tr>
                                            <tbody>
                                                <?php 
                                                $sno=1;
                                                $sum_of_qty = 0;
                                                $t_amount =0;
                                                $t_actual_amount =0;
                                                $t_vat_amount = 0;
                                                $t_pm_weight = 0;
                                                $t_gross = 0;
                                                foreach($inv_products as $keys =>$values)
                                                { 
                                                    if($values != '')
                                                    { ?>
                                                        <tr class="i_row">
                                                            <td><?php echo $sno++?></td>
                                                            <td> <?php echo $values['short_name']; ?> </td>
                                                            <td align="right"> <?php echo round($values['packets']); ?></td>
                                                            <td align="right"> <?php echo price_format($values['carton_qty']); ?></td>
                                                            
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

                                                ?>
                                                <tr>
                                                    <td colspan="3"> Gross Weight :<b><?php echo qty_format($t_gross) ;?></b> </td>
                                                    <td><b>Total</b></td>                                             
                                                    <td align="right"><b><?php echo qty_format($sum_of_qty);?></b></td>
                                                    <td> </td>
                                                    <td align="right"><b><?php echo price_format($t_actual_amount);?></b></td> 
                                                    <td> </td>
                                                    <td align="right"><b><?php echo price_format($t_vat_amount);?></b></td>
                                                    <td align="right"><b><?php echo price_format($t_amount);?></b></td>
                                                </tr>
                                                 <!-- <tr>
                                                     <td colspan="8"></td>
                                                     <td><b> Discount</b></td>
                                                     <td> <b><?php echo $values['discount'];?></b></td>
                                                 </tr>
                                                 <tr>
                                                     <td colspan="8"></td>
                                                     <td><b> Grand Total</b></td>
                                                     <td> <b><?php 
                                                    if($values['discount']!=0)
                                                            $dis_amt = ($t_amount*$values['discount'])/100;
                                                    else
                                                        $dis_amt = 0;
                                                     echo ($t_amount - $dis_amt);
                                                     ?></b></td>
                                                 </tr> -->
                                            </tbody>
                                      </table>
                                      <?php if(isset($free_products) || isset($free_gifts))
                                        {
                                      ?>
                                           <table class="table">                                 
                                                <thead>
                                                    <th colspan="7">
                                                        Free Gifts
                                                    </th>                                            
                                                </thead>                                           
                                                <tr style="background-color:#cccfff">
                                                    <td>S No</td>
                                                    <td>Scheme Type </td>                                                
                                                    <td>Scheme Name</td>
                                                    <td>Free Product</td>
                                                    <td>Qty(Pcs)</td>                                                
                                                </tr>
                                                <tbody>
                                                    <?php 
                                                     $sn = 1;
                                                    if(isset($free_products) && count(@$free_products)>0)
                                                    {
                                                        foreach ($free_products as $key => $value)
                                                        {?> <tr>
                                                                <td><?php echo $sn++;?></td>
                                                                <td><?php echo $value['scheme_type'];?></td>
                                                                <td><?php echo $value['scheme_name'];?></td>
                                                                <td><?php echo $value['product_name'];?></td>
                                                                <td><?php echo $value['quantity'];?></td>
                                                            </tr>
                                                     <?php }
                                                    }
                                                    if(isset($free_gifts) && count(@$free_gifts)>0)
                                                    {
                                                        foreach ($free_gifts as $key => $value2)
                                                        {?>
                                                            <tr>
                                                                <td><?php echo $sn++;?></td>
                                                                <td><?php echo $value2['scheme_type'];?></td>
                                                                <td><?php echo $value2['scheme_name'];?></td>
                                                                <td><?php echo $value2['free_gift_name'];?></td>
                                                                <td><?php echo $value2['quantity'];?></td>
                                                            </tr>
                                                      <?php }
                                                    } ?>
                                                </tbody>
                                            </table>
                                        <?php }?> 
                                    </div>
                                </div>
                            </div>                    
                            <?php if(isset($invoice_pm)){?>
                            <div class="col-md-offset-3 col-md-6">
                                <div class="table-scrollable">
                                    <table class="table">
                                        <thead>
                                            <tr style="background-color:#cccfff">
                                                <th> S.No</th>
                                                <th>Extra Packing Material </th>
                                                <th>Quantity</th>
                                            </tr>
                                        </thead>
                                     <?php 
                                     $sn = 1;
                                        foreach ($invoice_pm as $key => $value)
                                         {?>            
                                        <tbody>
                                            <tr>
                                                 <td> <?php echo $sn++;?></td>
                                                 <td> <?php echo get_pm_code($value['pm_id']); ?> </td>
                                                 <td> <?php echo $value['quantity']; ?> </td>
                                            </tr>
                                        </tbody>                                          
                                        <?php }?>
                                    </table>
                                </div>
                            </div>
                            <?php
                            }?> 
                            <div class="row">
                                <div class="col-md-offset-5 col-md-5">
                                    <button type="submit" name="generate_do" formaction="<?php echo SITE_URL.'print_dist_invoice_details';?>" class="btn btn-success" value="1">Print</button>
                                   <a href="<?php echo SITE_URL.'manage_dist_invoice';?>" class="btn default">Back</a>
                                </div>
                            </div>
                      </div>
                    </div>
                </div>
            </div>  
        </form>
    </div>
</div>
<?php $this->load->view('commons/main_footer', $nestedView); ?>