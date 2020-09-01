<?php $this->load->view('commons/main_template', $nestedView); ?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="row">
        <form class="form-horizontal" action="<?php echo SITE_URL.'insert_plant_invoice_generation';?>" method="post">
            <?php /*foreach ($data['do_numbers'] as $key => $value) {?>
                <input type="hidden" name="do_number[<?php echo $key;?>]" value="<?php echo $value;?>">
           <?php }*/?>
            <input type="hidden"  name="invoice_type" value="<?php echo @$invoice_type;?>">
            <input type="hidden"  name="scheme_id" value="<?php echo @$scheme_id;?>">

            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="portlet box green">
                        <div class="portlet-title">
                            <div class="caption">
                               <!--  <i class="fa fa-gift"></i> --> Invoice Products</div>
                            <div class="tools">
                                <a href="javascript:;" class="collapse"> </a>
                            </div>
                        </div>
                        <div class="portlet-body">  
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="col-xs-10 control-label">Invoice Number</label>
                                        <div class="col-xs-2">
                                            <p class="form-control-static"><b><?php echo  get_plant_invoice_number(); ?></b></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-xs-8 control-label">Invoice Date</label>
                                        <div class="col-xs-4">
                                            <p class="form-control-static"><b><?php echo date('d-m-Y'); ?></b></p>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-xs-7 control-label">Stock Lifting Point</label>
                                        <div class="col-xs-5">
                                            <p class="form-control-static"><b><?php echo $data['stock_lifting_point']; ?></b></p>
                                            <input type="hidden" name="stock_lifting_id" value="<?php echo $data['stock_lifting_id'];?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-xs-5 control-label">Vehicle Number</label>
                                        <div class="col-xs-7">                                            
                                            <input type="text" required name="vehicle_number" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-scrollable">
                                        <table class="table"> 
                                        <?php
                                        foreach($data['do_number'] as $do_id=>$do_number) 
                                        { 
                                            if(count(@$data['lifting_qty'][$do_id])>0)
                                            {
                                                $sno = 1; 
                                                ?>
                                                <thead>
                                                    <th colspan="10">
                                                    <input type="hidden" name="do_id[]" value="<?php echo $do_id;?>">
                                                    <?php echo "DO Number    - " .$do_number. " DO Date  - " .$data['do_date'][$do_id]?>
                                                    </th>                                            
                                                </thead>                                           
                                                <tr style="background-color:#cccfff">
                                                    <td>S No</td>
                                                    <td>Product Name</td> 
                                                    <td> OB Date </td>
                                                    <td> OB number </td>                                               
                                                    <td>Price</td>
                                                    <!-- <td>Items Per Carton</td> -->
                                                    <td>DO Qty</td>
                                                    <td>Pending Qty</td>                                                
                                                    <td>Invoice Qty</td>                                                
                                                    <td>Stock </td>
                                                    <td>Total Amount</td>
                                                </tr>
                                                <tbody>
                                                <?php 
                                                foreach($data['lifting_qty'][$do_id] as $order_id => $lq_row)
                                                { 
                                                    if(count($lq_row)>0) 
                                                    { 
                                                        foreach ($lq_row as $product_id => $lifting_qty)
                                                        {
                                                        ?>
                                                            <tr class="i_row">
                                                                <td><?php echo $sno++?></td>
                                                                <td>
                                                                    <input type="hidden" name="do_ob_product_id[<?php echo $do_id;?>][<?php echo $order_id?>][<?php echo $product_id?>]" value="<?php echo $data['do_ob_product_id'][$do_id][$order_id][$product_id]; ?>">
                                                                    <input type="hidden" name="do_order_product[]" value="<?php echo $do_id.'_'.$order_id.'_'.$product_id;?>">
                                                                    <input type="hidden" name="product_name[<?php echo $do_id;?>][<?php echo $order_id?>][<?php echo $product_id?>]" value="<?php echo $data['product_name'][$do_id][$order_id][$product_id]; ?>">
                                                                    <?php echo $data['product_name'][$do_id][$order_id][$product_id]; ?>
                                                                </td>
                                                                <td><?php echo get_ob_date($order_id);?> </td>
                                                                <td><?php echo get_ob_number($order_id);?> </td>
                                                                <td>
                                                                    <?php echo $data['price'][$do_id][$order_id][$product_id]; ?>
                                                                    <input type="hidden" class="price" name="price[<?php echo $do_id;?>][<?php echo $order_id?>][<?php echo $product_id?>]" value="<?php echo $data['price'][$do_id][$order_id][$product_id];?>">
                                                                </td>
                                                                <td>
                                                                <input type="hidden" class="items_per_carton" name="items_per_carton[<?php echo $do_id;?>][<?php echo $order_id?>][<?php echo $product_id?>]" value="<?php echo $data['items_per_carton'][$do_id][$order_id][$product_id];?>"> 
                                                                <input type="hidden" class="do_qty" name="do_quantity[<?php echo $do_id;?>][<?php echo $order_id?>][<?php echo $product_id?>]"  value="<?php echo @$data['do_quantity'][$do_id][$order_id][$product_id]?>">
                                                                <?php echo  intval($data['do_quantity'][$do_id][$order_id][$product_id]);  ?>
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" class="pending_qty" name="pending_qty[<?php echo $do_id;?>][<?php echo $order_id?>][<?php echo $product_id?>]"  value="<?php echo @$data['pending_qty'][$do_id][$order_id][$product_id]?>">
                                                                    <?php echo  intval($data['pending_qty'][$do_id][$order_id][$product_id]);  ?>
                                                                </td>                                                        
                                                                <td><input readonly class="lifting_qty" style="width:60px" type="text" name="lifting_qty[<?php echo $do_id;?>][<?php echo $order_id?>][<?php echo $product_id?>]" value="<?php echo @$data['lifting_qty'][$do_id][$order_id][$product_id]?>" ></td>
                                                                <td><input readonly class="stock_qty" style="width:60px" type="text" name="stock_qty[<?php echo $do_id;?>][<?php echo $order_id?>][<?php echo $product_id?>]" value="<?php echo intval(@$data['stock_qty'][$do_id][$order_id][$product_id]);?>" ></td>                                                        
                                                                <td>
                                                                <input type="hidden" name="total_price[<?php echo $do_id;?>][<?php echo $order_id?>][<?php echo $product_id?>]" value ="<?php echo $data['total_price'][$do_id][$order_id][$product_id];?>" class="total_price_val">
                                                                <span class="total_price"><?php echo $data['total_price'][$do_id][$order_id][$product_id];?></span></td>
                                                            </tr>
                                                            
                                                <?php
                                                        } // end product foreach
                                                    } // end if
                                                } // end order foreach
                                                ?>

                                                </tbody>                                           
                                            <?php 
                                            } // end if
                                        } // end do foreach
                                        ?>
                                        <tr>
                                            <td colspan="7"></td> 
                                            <td>
                                                <input type="hidden" id="" class="total_lifting_qty_val" value="<?php echo $data['total_lifting_qty'];?>" name="total_lifting_qty">
                                                <p >Total Lifting Qty &nbsp;: &nbsp;<b class="total_lifting_qty"><?php echo $data['total_lifting_qty'];?></b></p>
                                             </td>
                                             <td></td>
                                            <td>
                                                <input type="hidden" id="grand_total" class="grand_total_val" value="<?php echo $data['grand_total'];?>" name="grand_total"><p >Grand Total &nbsp;: &nbsp;<b class="grand_total"><?php echo $data['grand_total'];?></b></p>
                                             </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                            </div>
                            <?php

                            if(isset($fg_schemes))
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
                                        <td>Scheme</td>                                                
                                        <td>Scheme Type</td>
                                        <td>Scheme Product</td>
                                        <td>Free Product</td>
                                        <td>Qty(Pcs)</td>                                                
                                        <td>Lifting Qty</td>
                                    </tr>
                                    <?php
                                    $fg_sn = 1;
                                    foreach ($fg_schemes as $srow)
                                    {?>
                                        <input type="hidden" name="fg_scheme[]" value="<?php echo $srow['fg_scheme_id'];?>">
                                        <?php
                                        foreach ($srow['scheme_product'] as $key => $sp_row)
                                        {
                                            ?>
                                            <tr>
                                                <td><?php echo $fg_sn++;?></td>
                                                <td><?php echo $srow['name'];?></td>
                                                <td><?php echo $srow['scheme_type'];?></td>
                                                <td>
                                                    <?php echo $srow['scheme_product'][$key]['product_name'];?>
                                                    <input type="hidden" name="scheme_product[<?php echo $srow['fg_scheme_id'];?>][]" value="<?php echo $srow['scheme_product'][$key]['product_id']?>">
                                                    
                                                </td>
                                                <td><?php echo $srow['gift_product'][$key]['free_product'];?></td>
                                                <td><?php 
                                                /*if($srow['scheme_product'][$key]['gift_type_id'] == 1)
                                                {
                                                    if($srow['scheme_product'][$key]['item_type_id'] == 1)
                                                    {
                                                        $fg_qty = ($product_tot_lifting_qty[$srow['scheme_product'][$key]['product_id']]/$srow['scheme_product'][$key]['quantity']); 
                                                        
                                                    }
                                                    else
                                                    {
                                                        $fg_qty *= $srow['scheme_product'][$key]['items_per_carton']; 
                                                    }
                                                    
                                                    if($srow['gift_product'][$key][''])
                                                }
                                                else
                                                {

                                                }*/


                                                $fg_qty = ($product_tot_lifting_qty[$srow['scheme_product'][$key]['product_id']]/$srow['scheme_product'][$key]['quantity'])*$srow['gift_product'][$key]['quantity'];
                                                if($srow['scheme_product'][$key]['item_type_id'] == 2)
                                                    $fg_qty *= $srow['scheme_product'][$key]['items_per_carton'];
                                                $fg_qty = round($fg_qty);
                                                echo $fg_qty;
                                                ?></td>
                                                <td>
                                                    <?php
                                                    $free_product_id = ($sp_row['gift_type_id']==1)?$srow['gift_product'][$key]['product_id']:$srow['gift_product'][$key]['free_gift_id']
                                                    ?>
                                                    <input type="hidden" name="fp_items_per_carton[<?php echo $srow['fg_scheme_id']?>][<?php echo $sp_row['gift_type_id']?>][<?php echo $free_product_id?>]" value="<?php echo @$srow['gift_product'][$key]['items_per_carton']?>">
                                                    <input type="hidden" name="free_product[<?php echo $srow['fg_scheme_id']?>][]" value="<?php echo $free_product_id;?>">
                                                    <input type="text" style="width:60px" value="<?php echo $fg_qty;?>" class="fg_lifting_qty" max="<?php echo $fg_qty;?>" name="fg_lifting_qty[<?php echo $srow['fg_scheme_id']?>][<?php echo $sp_row['gift_type_id']?>][<?php echo $free_product_id?>]">
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </table>
                                <?php
                            }
                            ?>
                            <?php 
                                if(@$data['pm_id'][0]!='')
                                {
                                    ?>
                                    <table class="table" style="width:40%;" align="center">
                                        <thead>
                                            <th colspan="3">
                                                Extra Packing Materials
                                            </th>                                            
                                        </thead>                                           
                                        <tr style="background-color:#cccfff">
                                            <td>S No</td>
                                            <td>Packing Material</td>                                                
                                            <td>Qty</td>
                                        </tr>
                                    
                                    <?php
                                    $ex_pm_sn=1;
                                    foreach ($data['pm_id'] as $key => $value)
                                     {
                                        if($value!='' && $data['pm_quantity'][$key]!='')
                                        {
                                        ?>
                                        <tr>
                                            <td><?php echo $ex_pm_sn++;?></td>
                                            <td>
                                                <?php echo get_pm_name($value);?> 
                                                <input type="hidden" name="pm_id[]" value="<?php echo $value?>">
                                            </td>
                                            <td>
                                                <?php echo $data['pm_quantity'][$key]?>                                     
                                                <input type="hidden" name="pm_quantity[]" value="<?php echo $data['pm_quantity'][$key];?>">  
                                            </td>
                                        </tr>
                                        <!-- <div class="row">                                            
                                            <div class="form-group ">
                                                <div class="col-md-2 ">
                                                        
                                                </div>                                 
                                                <div class="col-md-4 ">
                                                                                               
                                                </div>
                                                <div class="col-md-2 ">
                                                                                             
                                                </div>                                                                             
                                            </div>
                                        </div>        -->                                
                                <?php  }  // end of if
                                    }   // end of for
                                ?>
                                </table>
                                <?php
                                }?>                            
                            <div class="row">
                                <div class="col-md-offset-4 col-md-4">
                                    <button type="submit" name="generate_do"  class="btn btn-success" value="1">Proceed</button>

                                    <!-- <a formaction="<?php echo SITE_URL.'plant_invoice_entry';?>" class="btn default">Back</a> -->
                                     <button type="submit" formaction="<?php echo SITE_URL.'plant_invoice_entry';?>" value="2" name="cancel" class="btn default">Back</button>
                                </div>
                                <!-- <div class="col-md-2">
                                    <input type="hidden" id="" class="total_lifting_qty_val" value="<?php echo $data['total_lifting_qty'];?>" name="total_lifting_qty">
                                    <p >Total Lifting Qty &nbsp;: &nbsp;<b class="total_lifting_qty"><?php echo $data['total_lifting_qty'];?></b></p>
                                 </div>
                                 <div class="col-md-2">
                                    <input type="hidden" id="grand_total" class="grand_total_val" value="<?php echo $data['grand_total'];?>" name="grand_total"><p >Grand Total &nbsp;: &nbsp;<b class="grand_total"><?php echo $data['grand_total'];?></b></p>
                                 </div> -->
                            </div>  
                        </div>
                    </div>
                </div>
            </div>  
        <!--</div>-->
        </form>
    </div>
</div>
<?php $this->load->view('commons/main_footer', $nestedView); ?>