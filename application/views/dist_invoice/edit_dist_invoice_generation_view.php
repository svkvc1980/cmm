<?php $this->load->view('commons/main_template', $nestedView); ?>



<!-- BEGIN PAGE CONTENT INNER -->

<div class="page-content-inner">

    <!-- BEGIN BORDERED TABLE PORTLET-->

    <div class="row">


        <form class="form-horizontal" action="<?php echo SITE_URL.'confirm_dist_invoice_generation';?>" method="post">
            
            <div class="col-md-12">

                <div class="col-md-12">

                    <div class="portlet box green">

                        <div class="portlet-title">

                            <div class="caption">

                               <!--  <i class="fa fa-gift"></i> --> DO Products</div>

                            <div class="tools">

                                <a href="javascript:;" class="collapse"> </a>

                            </div>

                        </div>

                        <div class="portlet-body">  

                            <div class="row">

                                <div class="col-md-4">

                                    <div class="form-group">

                                        <label class="col-xs-6 control-label">Invoice Date</label>

                                        <div class="col-xs-5">

                                            <p class="form-control-static"><b><?php echo date('d-m-Y'); ?></b></p>

                                        </div>

                                    </div>

                                </div>

                                 <div class="col-md-4">

                                    <div class="form-group">

                                        <label class="col-xs-5 control-label">Stock Lifting Point</label>

                                        <div class="col-xs-7">

                                            <p class="form-control-static"><b><?php echo $stock_lifting_point; ?></b></p>
                                            <input type="hidden" name="stock_lifting_point" value="<?php echo $stock_lifting_point;?>">
                                            <input type="hidden" name="stock_lifting_id" value="<?php echo $stock_lifting_id;?>">
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-12">

                                    <div class="table-scrollable">

                                        <table class="table"> 

                                        <?php

                                        foreach($do_results as $key => $value) 

                                        { 

                                            $sno = 1; 

                                        ?>

                                            <thead>

                                                <th colspan="10"><?php echo "DO Number    - " .$value['do_number']. " DO Date  - " .$value['do_date']?></th>
                                                <input type="hidden"  name="do_number[<?php echo $value['do_id'];?>]" value="<?php echo $value['do_number'];?>">
                                                <input type="hidden"  name="do_date[<?php echo $value['do_id'];?>]" value="<?php echo $value['do_date'];?>">
                                                
                                            </thead>

                                           

                                            <tr style="background-color:#cccfff">

                                                <td>S No</td>

                                                <td></td>

                                                <td>Product Name</td>                                                

                                                <td>Price</td>

                                                <td>Items Per Carton</td>

                                                <td>DO Qty</td>                                                

                                                <td>Invoice Quantity</td>                                                

                                                <td> Stock </td>

                                                <td>Total Amount</td>

                                            </tr>

                                            <tbody>

                                            <?php 

                                            foreach($value['do_products'] as $keys =>$values)

                                            { 

                                                if($values != '') 

                                                { ?>

                                                    <tr class="i_row">



                                                        <td><?php echo $sno++?></td>

                                                        <td><input class="do_product" name="do_product[]" value="<?php echo $value['do_id']."_" . $values['product_id']?>" type="checkbox"></td>

                                                        <td>

                                                            <input type="hidden" name="product_name[<?php echo $value['do_id']?>][<?php echo $values['product_id']?>]" value="<?php echo $values['product_name']; ?>">

                                                            <?php echo $values['product_name']; ?>

                                                        </td>

                                                        <td>

                                                            <?php echo $values['price']; ?>

                                                            <input type="hidden" class="price" name="price[<?php echo $value['do_id']?>][<?php echo $values['product_id']?>]" value="<?php echo $values['price'];?>">

                                                        </td>

                                                        <td><input type="hidden" class="items_per_carton" name="items_per_carton[<?php echo $value['do_id']?>][<?php echo $values['product_id']?>]" value="<?php echo $values['p_items_per_carton']?>"> <?php echo intval($values['p_items_per_carton']); ?></td>

                                                        <td>

                                                            <input type="hidden" class="do_qty" name="do_quantity[<?php echo $value['do_id']?>][<?php echo $values['product_id']?>]"  value="<?php echo @$values['do_quantity']?>">

                                                            <?php echo  intval($values['do_quantity']);  ?>

                                                        </td>                                                        

                                                        <td><input disabled="" class="lifting_qty" style="width:60px" type="text" name="lifting_qty[<?php echo $value['do_id']?>][<?php echo $values['product_id']?>]" value="0" ></td>
                                                        <td><input readonly class="stock_qty" style="width:60px" type="text" name="stock_qty[<?php echo $value['do_id']?>][<?php echo $values['product_id']?>]" value="<?php echo intval($values['stock_qty']);?>" ></td>



                                                        

                                                        <td>
                                                        <input type="hidden" name="total_price[<?php echo $value['do_id']?>][<?php echo $values['product_id']?>]" value ="" class="total_price_val">
                                                        <span class="total_price">0</span>
                                                        </td>

                                                    </tr>

                                            <?php

                                                }

                                            }

                                            ?>

                                            </tbody>

                                           

                                        <?php } ?>

                                        </table>

                                    </div>

                                </div>

                            </div>
                            <div class="row">
                                <input type="checkbox" name="cbox" id="incl_pm">Include Paking Material
                                    <div class="form-group radio_dropdown hidden">
                                        <div class="col-md-3 spcls">
                                                
                                        </div>                                 
                                        <div class="col-md-3 ">
                                            <div class="form-group">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <select class="form-control"  name="pm_id[]" >
                                                        <option value="">Select Packing Material</option>
                                                        <?php   
                                                        foreach(@$packing_material as $row)
                                                        {
                                                            echo "<option value=".@$row['pm_id']." >".@$row['name']."</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>                                            
                                        </div>
                                        <div class="col-md-2 ">
                                            <div class="form-group">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input class="form-control"  placeholder="Quantity" name="pm_quantity[]"  type="text">
                                                </div>
                                            </div>                                      
                                        </div>
                                        <div class="col-md-1 mybutton">
                                            <a  id="" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                        </div>
                                        <div class="col-md-1 deletebutton hide">
                                            <a  class="btn btn-danger tooltips " data-container="body" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
                                        </div>                             
                                    </div>

                            </div>

                            <div class="row">

                                <div class="col-md-offset-5 col-md-5">

                                    <button type="submit" name="generate_do" class="btn btn-success" value="1">Generate Invoice</button>

                                    <a href="<?php echo SITE_URL.'dist_invoice_entry';?>" class="btn default">Cancel</a>

                                </div>

                                 <div class="col-md-2">

                                    <input type="hidden" id="grand_total" class="grand_total_val" value="" name="grand_total"><p >Grand Total &nbsp;: &nbsp;<b class="grand_total">0</b></p>

                                 </div>

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

