<?php $this->load->view('commons/main_template', $nestedView); ?>



<!-- BEGIN PAGE CONTENT INNER -->

<div class="page-content-inner">

    <div class="row">

        <div class="col-md-12">

            <!-- BEGIN BORDERED TABLE PORTLET-->

            <div class="portlet light portlet-fit">

                <div class="portlet-body">

                   <?php 

                    if($flag==1)

                    { ?>

                        <form method="post" class="form-horizontal" action="<?php echo SITE_URL.'po_packing_material_insert'?>">

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="col-md-4 control-label">Purchase Order</label>

                                            <div class="col-md-6">

                                                <input type="hidden" name="po_no" value="<?php echo @$po_number;?>">
                                                 <input type="hidden" name="tender_pm_id" value="<?php echo @$packing_material_tenders['tender_pm_id'];?>">

                                                <b><?php echo  $po_number;?></b>

                                            </div>

                                    </div>

                                </div>

                                <input type="hidden" name="mtp_pm_id" value="<?php echo $mtp_pm_id; ?>">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="col-md-3 control-label">PO Date</label>

                                        <div class="col-md-6">

                                            <input type="hidden" name="po_date" data-date-format="dd-mm-yyyy" value="<?php echo date('Y-m-d');?>">

                                            <b><?php echo date('d-m-Y');?></b>

                                        </div>

                                    </div>

                                </div>

                            </div>
                             <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="col-md-4 control-label">Quantity </label>

                                        <div class="col-md-6">

                                          <input class="form-control" disabled name="total_quantity" value="<?php echo @$packing_material_insert_details['quantity'];?>"  type="hidden">

                                          <p class="form-control-static"><b><?php echo @$packing_material_insert_details['quantity'] ;?></b></p>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="col-md-3 control-label">Required Qty</label>

                                        <div class="col-md-6">

                                           <input class="form-control " disabled name="req_quantity" value="<?php echo $req_quantity;?>"  type="hidden">

                                           <p class="form-control-static"><b><?php echo $req_quantity;?></b></p>

                                        </div>

                                    </div>

                                </div>
                                
                            </div>

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="col-md-4 control-label">Packing Material</label>

                                        <div class="col-md-6">

                                            <select name="packing_id" disabled class="form-control">

                                                <option value="">-Select Packing Material-</option>

                                                <?php 

                                                    foreach($packing as $pack)

                                                    {

                                                        $selected = '';

                                                        if($pack['pm_id'] ==@$packing_material_insert_details['pm_id'] ) $selected = 'selected';

                                                        echo '<option value="'.$pack['pm_id'].'" '.$selected.'>'.$pack['packing_name'].'</option>';

                                                    }

                                                ?>

                                            </select>

                                            <input type="hidden" name="packing_name" value="<?php echo @$packing_material_insert_details['pm_id'];?>"> 

                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="col-md-3 control-label"> Type</label>

                                        <div class="col-md-6">

                                            <select name="po_type" disabled class="form-control">

                                                <option value="1" selected>OCB (Open Competition Bid)</option>

                                                <?php 

                                                    foreach($type as $ty)

                                                    {

                                                        $selected = '';

                                                        if($ty['po_type_id'] ==$po_type_id ) $selected = 'selected';

                                                        echo '<option value="'.$ty['po_type_id'].'" '.$selected.'>'.$ty['name'].'</option>';

                                                    }

                                                ?> 

                                            </select>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="col-md-4 control-label">Supplier</label>

                                            <div class="col-md-6">

                                                <select  class="form-control" disabled name="supplier_id" >

                                                    <option selected value="">-Select Supplier Name-</option>

                                                    <?php 

                                                        foreach($supplier as $supp)

                                                        {

                                                            $selected = '';

                                                            if($supp['supplier_id'] ==$packing_material_tenders['supplier_id']) $selected = 'selected';

                                                            echo '<option value="'.$supp['supplier_id'].'" '.$selected.'>'.$supp['agency_name'].'</option>';

                                                        }

                                                      

                                                    ?>

                                                </select>

                                                <input type="hidden" name="supplier_name" value="<?php echo @$packing_material_tenders['supplier_id'];?>">

                                            </div>

                                    </div>

                                </div>

                                 <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="col-md-3 control-label">Ops</label>

                                        <div class="col-md-6">

                                           <select name="plant_name" disabled class="form-control">

                                                <option value="">-Select Ops-</option>

                                                    <?php 

                                                        foreach($plant as $pla)

                                                        {

                                                            $selected = '';

                                                            if($pla['plant_id'] ==$packing_material_insert_details['plant_id'] ) $selected = 'selected';

                                                            echo '<option value="'.$pla['plant_id'].'" '.$selected.'>'.$pla['plant_name'].'</option>';

                                                        }

                                                    ?>

                                            </select>

                                            <input type="hidden" name="plant_id" value="<?php echo @$packing_material_insert_details['plant_id'];?>">

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="row">

                             

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="col-md-4 control-label ">Offered Quantity <span class="font-red required_fld">*</span></label>

                                        <div class="col-md-6">

                                           <input class="form-control quantity" value="<?php echo @$packing_material_tenders['offered_qty'];?>" disabled type="number">

                                            <input type="hidden" name="quantity" value="<?php echo @$packing_material_tenders['offered_qty'];?>"> 

                                        </div>

                                    </div>

                                </div>
                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="col-md-3 control-label">Rate</label>

                                        <div class="col-md-6">

                                           <input class="form-control rate1" disabled name="rate2" value="<?php echo @$packing_material_tenders['min_quote'];?>"  type="number">

                                           <input type="hidden" name="rate1" value="<?php echo @$packing_material_tenders['min_quote'];?>">

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="col-md-4 control-label ">Total Amount</label>

                                        <div class="col-md-6">

                                           <input class="form-control numeric t_amount" disabled name="t_amount" value="<?php echo @$lrow['t_amount'];?>"  type="text">

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <div>

                            <div class="row">

                                <div class="col-md-offset-5 col-md-4">

                                     <input type="submit" class="btn blue tooltips" onclick="return confirm('Are you sure you want to Generate P.O.?')" value="Generate P.O." name="submit">

                                     <a href="<?php echo SITE_URL.'mtp_packingmaterial';?>" class="btn default">Cancel</a>

                               </div>

                            </div>

                       </div>

                    </form>

                    <?php } 

                    if($flag==2){ ?>

                        <form id="po_packing_material_form" class="form-horizontal srow" method="post" action="<?php echo SITE_URL.'po_packing_material_insert'?>">

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="col-md-4 control-label">Purchase Order</label>

                                            <div class="col-md-6">

                                                <input type="hidden" name="purchase_order" value="<?php echo @$po_number;?>">

                                                <p class="form-control-static"><b><?php echo  $po_number;?></b></p>

                                            </div>

                                    </div>

                                </div>

                                <input type="hidden" name="mtp_pm_id" value="<?php echo $mtp_pm_id; ?>">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="col-md-3 control-label">PO Date</label>

                                        <div class="col-md-6">

                                            <input type="hidden" name="po_date" data-date-format="dd-mm-yyyy" value="<?php echo date('Y-m-d');?>">

                                            <p class="form-control-static"><b><?php echo date('d-m-Y');?></b></p>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="col-md-4 control-label">Packing Material<span class="font-red required_fld">*</span></label>

                                        <div class="col-md-6">

                                        <div class="input-icon right">

                                            <i class="fa"></i>

                                            <select name="packing_name" class="form-control packing_material">

                                                <option value="">-Select Packing Material-</option>

                                                <?php 

                                                    foreach($packing as $pack)

                                                    {

                                                        echo '<option value="'.$pack['pm_id'].'" data-pm-category="'.$pack['pm_category_id'].'">'.$pack['packing_name'].'</option>';

                                                    }

                                                ?>

                                            </select>

                                            <span class="pm_error"></span> 

                                            <input type="hidden" class="add_packing_name">

                                        </div>

                                        </div>

                                    </div>

                                </div>

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="col-md-3 control-label">Type<span class="font-red required_fld">*</span></label>

                                        <div class="col-md-6">

                                        <div class="input-icon right">

                                            <i class="fa"></i>

                                            <select name="po_type" class="form-control po_type">

                                                <option value="">-Select Type-</option>

                                                <?php 

                                                    foreach($type as $ty)

                                                    {

                                                        $selected = '';

                                                        if($ty['po_type_id'] ==@$po_type_id ) $selected = 'selected';

                                                        echo '<option value="'.$ty['po_type_id'].'" '.$selected.'>'.$ty['name'].'</option>';

                                                    }

                                                ?>

                                            </select>

                                            <input type="hidden" class="repeat_order_id" name="repeat_order" value="<?php echo $repeat_order;?>">

                                        </div>

                                        </div>

                                    </div>

                                </div>

                                <input type="hidden" name="mtp_pm_id" value="<?php echo $mtp_pm_id; ?>">

                            </div>

                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="col-md-4 control-label">Ops<span class="font-red required_fld">*</span></label>

                                        <div class="col-md-6">

                                        <div class="input-icon right">

                                        <i class="fa"></i>

                                            <select name="plant_id" class="form-control plant_name">

                                                <option value="">-Select Ops-</option>

                                                    <?php 

                                                        foreach($plant as $pla)

                                                        {

                                                            $selected = '';

                                                            if($pla['plant_id'] ==@$plant_id) $selected = 'selected';

                                                            echo '<option value="'.$pla['plant_id'].'" '.$selected.'>'.$pla['plant_name'].'</option>';

                                                        }

                                                    ?>

                                            </select>

                                            <input type="hidden" class="add_plant_id">

                                        </div>

                                        </div>

                                    </div>

                                </div>

                                 <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="col-md-3 control-label">Supplier<span class="font-red required_fld">*</span></label>

                                            <div class="col-md-6">

                                            <div class="input-icon right">

                                            <i class="fa"></i>

                                                <select  class="form-control supplier_name" name="supplier_name" >

                                                    <option selected value="">-Select Supplier Name-</option>

                                                    <?php 

                                                        foreach($supplier as $supp)

                                                        {

                                                            $selected = '';

                                                            if($supp['supplier_id'] ==@$supplier_id) $selected = 'selected';

                                                            echo '<option value="'.$supp['supplier_id'].'" '.$selected.'>'.$supp['agency_name'].'('.$supp['supplier_code'].')'.'</option>';

                                                        }

                                                    ?>

                                                </select>

                                                <input type="hidden" class="add_supplier_name">

                                            </div>

                                            </div>

                                    </div>

                                </div>
                               

                            </div>

                            <div class="row">

                               

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="col-md-4 control-label kou">Quantity <span class="font-red required_fld">*</span></label>

                                        <div class="col-md-6">

                                        <div class="input-icon right">

                                        <i class="fa"></i>

                                           <input class="form-control qty" name="qty" placeholder="Quantity" value="<?php echo @$lrow['qty'];?>"  type="number">

                                           <input type="hidden" class="add_qty">

                                        </div>

                                        </div>

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="col-md-3 control-label">Rate <span class="font-red required_fld">*</span></label>

                                        <div class="col-md-6">

                                        <div class="input-icon right">

                                        <i class="fa"></i>

                                           <input class="form-control rate" placeholder="Rate" name="rate" value="<?php echo @$lrow['rate'];?>"  type="number">

                                           <input type="hidden" class="add_rate">

                                        </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="row">


                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label class="col-md-4 control-label ">Total Amount</label>

                                        <div class="col-md-6">

                                           <input class="form-control numeric total_amount" disabled name="total_amount" value="<?php echo @$lrow['total_amount'];?>"  type="text">

                                           <input type="hidden" class="add_total_amount">

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-offset-5 col-md-4">

                                     <input type="submit" onclick="return confirm('Are you sure you want to Generate P.O.?')" class="btn blue tooltips" value="Generate P.O." name="submit">

                                     <a href="<?php echo SITE_URL; ?>" class="btn default">Cancel</a>

                               </div>

                            </div>

                       

                        <div>

                        </div>

                    </form>

                        <?php } ?>

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



    var quantity=$('.quantity').val();

    var rate1=$('.rate1').val();

    var t_amount=quantity*rate1;

    $('.t_amount').val(t_amount);

});

$(document).on('blur','.qty,.rate',function(){

    var quantity=$('.qty').val();

    var rate1=$('.rate').val();

    var t_amount=quantity*rate1;

    $('.total_amount').val(t_amount);

});



$(document).on('blur','.quantity',function(){ 

 // var ele_panel_body=$(this).closest('.srow');

  var quantity=$(this).val();

  var rate=$('.rate1').val();

  var total_amount=quantity*rate;

  $('.t_amount').val(total_amount);

});



$('.po_type').change(function()

{

   var repeat_order=$('.repeat_order_id').val();

   var id=$(this).val();

    var pm_name=$('.packing_material option:selected').text();

   var packing_material=$('.packing_material option:selected').val();



   if(repeat_order == id)

   {

        if(packing_material!='')

       {  

          html='';

          $('.packing_material').css("border-color","inherit");

          $('.pm_error').html(html);

       }

       else

       {

          $('.packing_material').css("border-color","red");

          $('.pm_error').html('Please Select Packing Material');         

       }

        $.ajax({

            type:"POST",

            url:SITE_URL+'get_repeat_order_details',

            data:{pm_id:packing_material},

            cache:false,

            success:function(html)

            {   /*alert(html.unit_price);

                $('.qty').val(html.quantity);*/

                if(html!='null')

                {

                    var arr = jQuery.parseJSON(html);

                   

                    $('.packing_material').val(arr['pm_id']).attr("disabled","disabled").removeAttr("name","packing_name");

                    $('.supplier_name').val(arr['supplier_id']).attr("disabled","disabled").removeAttr("name","supplier_name"); 

                    $('.plant_name').val(arr['plant_id']).attr("disabled","disabled").removeAttr("name","plant_id");

                    $('.qty').val(arr['quantity']).removeAttr("name","qty");

                    $('.rate').val(arr['unit_price']).removeAttr("name","rate");

                    $('.total_amount').val((parseInt(arr['quantity']))*(parseInt(arr['unit_price']))).attr("disabled","disabled").removeAttr("name","total_amount");



                    $('.add_packing_name').val(arr['pm_id']).attr("name","packing_name");

                    $('.add_supplier_name').val(arr['supplier_id']).attr("name","supplier_name");

                    $('.add_plant_id').val(arr['plant_id']).attr("name","plant_id");

                    $('.add_qty').val(arr['quantity']).attr("name","qty");

                    $('.add_rate').val(arr['unit_price']).attr("name","rate");

                }

                else

                {

                    alert('No repeat order is available for '+pm_name+'. Please proceed through other one');

                }

            }

        });

   }

   else

   {

        html='';

      $('.packing_material').css("border-color","inherit");

      $('.pm_error').html(html);



        $('.packing_category').val('').removeAttr("disabled");

       // $('.packing_material').val('').removeAttr("disabled").attr("name","packing_name");

        $('.supplier_name').val('').removeAttr("disabled").attr("name","supplier_name"); 

        $('.plant_name').val('').removeAttr("disabled").attr("name","plant_id");

        $('.qty').val('').removeAttr("disabled").attr("name","qty");

        $('.rate').val('').removeAttr("disabled").attr("name","rate");

        $('.total_amount').val('').attr("name","total_amount");



       // $('.add_packing_name').val('').removeAttr("name","packing_name");

        $('.add_supplier_name').val('').removeAttr("name","supplier_name");

        $('.add_plant_id').val('').removeAttr("name","plant_id");

        $('.add_qty').val('').removeAttr("name","qty");

        $('.add_rate').val('').removeAttr("name","rate");

}

});

$('.packing_material').change(function(){

    var packing_material = $(this).val();
    var pm_category_id = $(this).find('option:selected').data('pm-category');
    if(pm_category_id == 1)
    {
        $('.kou').html('Quantity (Kgs) <span class="font-red required_fld">*</span>');
    }
    else
    {
        $('.kou').html('Quantity <span class="font-red required_fld">*</span>');
    }
    if(packing_material!='')

       {  

          html='';

          $('.packing_material').css("border-color","inherit");

          $('.pm_error').html(html);

          $('.po_type').val('');

          $('.po_type').prev('i').removeClass('fa-check fa-warning').addClass('fa');

          $('.po_type').closest('div.form-group').removeClass('has-success has-error');

       }

       else

       {

          $('.packing_material').css("border-color","red");

          $('.pm_error').html('Please Select Packing Material');         

       }

});
</script>