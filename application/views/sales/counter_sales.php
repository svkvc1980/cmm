<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->

<div class="page-content-inner">

    <div class="row">

        <div class="col-md-12">

            <!-- BEGIN BORDERED TABLE PORTLET-->

            <div class="portlet light portlet-fit">

                <div class="portlet-body">

                    <form  method="post" action="<?php echo SITE_URL;?>insert_counter_sales" class="form-horizontal counter_sale_form">

                        <div class="row">

                            <div class="form-group">

                                <div class="col-md-12">

                                    <div class="header text-center">

                                        <span class="timer_block" style="float:right; color:#3A8ED6">

                                            <i class="fa fa-clock-o"></i>

                                        <span id="timer"></span>

                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="inputName" class="col-md-6 control-label">Customer Name <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-5">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" class="form-control" required id="customer_name" placeholder="Customer Name" name="customer_name" value="" maxlength="150">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">

                                <div class="form-group">

                                <label class="col-md-4 control-label">Bill No :</label>

                                    <div class="col-md-5">

                                        <p class="form-control-static"><b><?php echo get_bill_number(); ?></b></p>

                                    </div>

                                </div>

                            </div>

                            

                        </div>

                        <div class="row">

                            <div class="col-md-6">

                                <div class="form-group">

                                <label class="col-md-6 control-label">Category :</label>

                                    <div class="col-md-5 form-control-static">

                                        <?php $i=1;

                                            foreach ($cs_category as $row) 

                                            {

                                                $checked = ($i==1)?'checked':'';

                                                echo '<input type="radio" class="category" '.$checked.' value="'.$row['cs_category_id'].'" name="cs_category">' .$row['name'];echo"&nbsp;&nbsp;&nbsp;";

                                                $i++;

                                            }

                                         ?>

                                    </div>

                                </div>

                            </div>

                            

                            <div class="col-md-6">

                                <div class="form-group">    

                                <label class="col-md-4 control-label">Payment Mode :</label>

                                    <div class="col-md-5 form-control-static">

                                        <?php $i=1;

                                            foreach ($cs_pay_mode as $row) 

                                            {

                                                $checked = ($i==1)?'checked':'';

                                                echo '<input type="radio" id="paymode" class="paymode" '.$checked.' value="'.$row['cs_pay_mode_id'].'" name="cs_paymode">' .$row['name']; echo"&nbsp;&nbsp;&nbsp;";

                                                $i++;

                                            }

                                         ?>

                                    </div>

                                </div>

                            </div>

                        </div>    

                        <div class="table-scrollable">

                            <table class="table table-bordered table-striped table-hover sales" id="sales">

                                <thead>

                                    <tr>

                                        <th width="20%"> Product Name </th>

                                        <th width="20%"> Price </th>

                                        <th width="20%"> Available Quantity </th>

                                        <th width="20%"> Quantity </th>

                                        <th width="20%"> Amount </th>

                                        <th> Action </th>            

                                    </tr>

                                </thead>

                                <tbody> 

                                    <tr class="sales_row">

                                        <td>
                                            <div class="dummy">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                <?php echo form_dropdown('product[1]', $product, @$search_data['product_id'],'class="form-control product" required id="product" value="" name="product"');?>
                                                </div>
                                            </div>

                                        </td>

                                        <td>
                                            <div class="dummy">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input type="text" class="form-control numeric price" required id="price" onkeyup="javascript:this.value=Comma(this.value);" placeholder="Price" name="price[1]" value="" maxlength="15">
                                                </div>
                                            </div>
                                        </td>

                                         <td>

                                            <input type="text" style="color: #217EBD; font-weight: bold;" class="form-control numeric available_qty" id="avail_qty" readonly name="avail_quantity" value="">

                                        </td>

                                        <td>
                                            <div class="dummy">
                                                <div class="sale_qty">
                                                    <div class="input-icon right">
                                                        <i class="fa"></i>
                                                        <input type="text" class="form-control numeric qty" required id="qty" placeholder="Quantity" name="quantity[1]" value="" maxlength="15">
                                                    </div>
                                                </div>  
                                            </div>          
                                        </td>

                                        <td align="right">

                                            <span class="amount"></span>

                                            <input type="hidden" name="amount[1]" class="amount1">

                                        </td>

                                        <td >

                                            <button class="btn blue btn-xs add" type="submit" name="add" id="add" value="ADD"><i class="fa fa-plus"></i></button>

                                            <button style="display:none" class="btn red btn-xs remove" type="submit" name="remove" id="remove" value="button"><i class="fa fa-trash"></i></button>

                                        </td>

                                    </tr>

                                </tbody>

                                <tfoot>

                                    <tr>

                                        <td colspan="3"></td>

                                        <td>

                                            Total Bill:

                                        </td>

                                        <td align="right">

                                            <span id="total"></span>

                                            <input type="hidden" name="total" id="total1">

                                        </td>

                                        <td></td>

                                    </tr>

                                    <tr class="denom">

                                        <td colspan="3">

                                        </td>

                                        <td>

                                            Denomination Recieved:

                                        </td>

                                        <td align="right">
                                            <div class="dummy">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input type="text" id="den" class="form-control numeric" onkeyup="javascript:this.value=Comma(this.value);"  placeholder="Denomination" name="denomination"  maxlength="15">
                                                </div>
                                            </div>

                                        </td>

                                        <td>

                                        </td>

                                    </tr>

                                    <tr class="denom">

                                        <td colspan="3">

                                        </td>

                                        <td>

                                            Pay To Customer:

                                        </td>

                                        <td align="right">

                                            <span id="pay_customer"></span>

                                            <input type="hidden" name="pay_customer" id="pay_customer1">

                                        </td>

                                        <td>

                                        </td>

                                    </tr>

                                    <tr hidden class="dd">

                                        <td colspan="3"></td>

                                        <td> DD Number: </td>

                                        <td>
                                            <div class="dummy">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input type="text" name="dd_number" class="form-control number" id="dd_no" placeholder="DD Number" value="" maxlength="15">
                                                </div>
                                            </div>
                                        </td>

                                        <td></td>

                                    </tr>

                                    <tr hidden class="dd">

                                        <td colspan="3"></td>

                                        <td> Bank Name: </td>

                                        <td>
                                            <div class="dummy">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <?php echo form_dropdown('bank', $bank, @$search_data['bank_id'],'class="form-control"');?>
                                                </div>
                                            </div>
                                        </td>

                                        <td></td>

                                    </tr>

                                </tfoot>

                            </table>

                        </div>

                        <div class="row">

                            <div class="col-md-offset-5 col-md-4">

                                

                                <button class="btn blue" type="submit" name="submit" value="1">Submit</button>

                                <a href="<?php echo SITE_URL;?>counter_sale_view" class="btn default tooltips" data-container="body" data-placement="top" data-original-title="Cancel"> Cancel</a>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

            <!-- END BORDERED TABLE PORTLET-->

        </div>

    </div>               

</div>

<!-- END PAGE CONTENT INNER -->

<?php $this->load->view('commons/main_footer', $nestedView); ?>