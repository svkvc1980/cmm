<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <form method="post" action="<?php echo SITE_URL.'insert_po'?>">
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Purchase Order</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="purchase_order" value="<?php echo @$po_id;?>">
                                        <b><?php echo  @$po_id;?></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Date</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="date" value="<?php echo date('Y-m-d');?>">
                                        <b><?php echo date('Y-m-d');?></b>
                                    </div>
                                </div>
                            </div>
                        </div></br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Broker Name<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <select  class="form-control"  name="broker_name" >
                                            <option selected value="">-Select Broker Name-</option>
                                            <?php 
                                             foreach($broker as $bro)
                                                {
                                                    $selected = '';
                                                    if($bro['broker_id'] ==@$broker_id ) $selected = 'selected';
                                                    echo '<option value="'.$bro['broker_id'].'" '.$selected.'>'.$bro['agency_name'].'</option>';
                                                }
                                            ?>
                                        </select> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Agency Name<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <select  class="form-control agency_name"  name="agency_name" >
                                            <option selected value="">-Select Agency Name-</option>
                                            <?php 
                                             foreach($agency as $ag)
                                                {
                                                    $selected = '';
                                                    if($ag['supplier_id'] ==@$supplier_id ) $selected = 'selected';
                                                    echo '<option value="'.$ag['supplier_id'].'" '.$selected.'>'.$ag['agency_name'].'</option>';
                                                }
                                            ?>
                                        </select> 
                                    </div>
                                </div>
                            </div>
                        </div></br>
                        <div class="agency_hide">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label ">Supplier Name</label>
                                    <div class="col-md-6">
                                       <input type="hidden" name="supplier_name">
                                       <b><span class="supplier_name"></span></b>
                                    </div>
                                </div>
                            </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Supplier Code</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="supplier_code">
                                        <b><span class="supplier_code"></span></b>
                                    </div>
                                </div>
                            </div>
                        </div></br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Address</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="address">
                                        <b><span class="address"></span></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Mobile Number</label>
                                    <div class="col-md-6">
                                       <input type="hidden" name="mobile_number">
                                       <b><span class="mobile_number"></span></b>
                                    </div>
                                </div>
                            </div>
                        </div></br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Town/City</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="city">
                                        <b><span class="city"></span></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">TIN Number</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="tin_number">
                                        <b><span class="tin_number"></span></b>
                                    </div>
                                </div>
                            </div>
                        </div></br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">State</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="state">
                                        <b><span class="state"></span></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Pin Number</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="pin_number">
                                        <b><span class="pin_number"></span></b>
                                    </div>
                                </div>
                            </div>
                        </div></br></br>
                        </div>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> Product Name</th>
                                        <th> Qty in M.T.S </th>
                                        <th> Rate Per M.T</th>
                                        <th> Delivery to</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="srow">
                                        <td>
                                            <select name="product_name" class="form-control">
                                                <option value="">Select Product</option>
                                                <?php 
                                                foreach($product as $pro)
                                                {
                                                    $selected = '';
                                                    if($pro['loose_oil_product_id'] ==$product_id ) $selected = 'selected';
                                                    echo '<option value="'.$pro['loose_oil_product_id'].'" '.$selected.'>'.$pro['loose_oil_product_name'].'</option>';
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input class="form-control numeric" name="qty" value="<?php echo @$lrow['qty'];?>"  type="text">
                                        </td>
                                        <td>
                                            <input class="form-control numeric" name="rate" value="<?php echo @$lrow['rate'];?>" type="text"> 
                                        </td>
                                        <td>
                                           <select name="delivery_to" class="form-control">
                                                <option value="">Select OPS Name</option>
                                                <option value="1">Hyderabad OPS</option>
                                                <option value="2">Kakinada OPS</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div></br>
                        <div >
                            <div class="row">
                                <div class="col-md-offset-5 col-md-4">
                                     <input type="submit" class="btn blue tooltips" name="submit">
                                     <a href="<?php echo SITE_URL.'purchase_order';?>" class="btn default">Cancel</a>
                               </div>
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

<script type="text/javascript">
$(document).ready(function(){
    $('.agency_hide').hide();
        $('.agency_name').change(function(){
            var supplier_id=$('.agency_name').val();
            if(supplier_id=='')
                {
                    $('.agency_hide').hide();
                    $(".agency_name").html('<option value="">-Select Agency Name-</option');
                    $(this).focus();
                }
            else
            {  
                $.ajax({
                type:"POST",
                    url:SITE_URL+'ajax_agency_name',
                    data:{supplier_id:supplier_id},
                    cache:false,
                    dataType:'json',
                    success:function(html){
                        $('.supplier_name').html(html.concerned_person);
                        $('.supplier_code').html(html.supplier_code);
                        $('.address').html(html.address);
                        $('.mobile_number').html(html.phone_number);
                        $('.city').html(html.city);
                        $('.tin_number').html(html.vat_no);
                        $('.state').html(html.state);
                        $('.pin_number').html(html.pin_code);
                        $('.agency_hide').show();
                       
                    }
                });
            }
        });
});


</script>