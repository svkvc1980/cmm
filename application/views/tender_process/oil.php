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
                        <form method="post" action="<?php echo SITE_URL.'insert_po'?>" class="form-horizontal">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Purchase Order :</label>
                                            <div class="col-md-6">
                                                <input type="hidden" name="po_no" value="<?php echo @$po_number;?>">
                                                <input type="hidden" name="tender_oil_id" value="<?php echo @$tenders['tender_oil_id'];?>">
                                                <p class="form-control-static"><b><?php echo  $po_number;?></b></p>
                                            </div>
                                    </div>
                                </div>
                                <input type="hidden" name="mtp_oil_id" value="<?php echo $mtp_oil_id; ?>">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Date :</label>
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
                                        <label class="col-md-4 control-label">Quantity (MT)</label>
                                        <div class="col-md-6">
                                          <input class="form-control" disabled name="total_quantity" value="<?php echo @$tender_details['quantity'];?>"  type="hidden">
                                          <p class="form-control-static"><b><?php echo @$tender_details['quantity'] ;?></b></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label ">Required Qty</label>
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
                                        <label class="col-md-4 control-label">Loose Oil</label>
                                        <div class="col-md-6">
                                            <select name="loose_oil_id" disabled class="form-control">
                                                <option value="">-Select Loose Oil-</option>
                                                <?php
                                                    foreach($loose as $loo)
                                                    {
                                                        $selected = '';
                                                        if($loo['loose_oil_id'] ==$tender_details['loose_oil_id']) $selected = 'selected';
                                                        echo '<option value="'.$loo['loose_oil_id'].'" '.$selected.'>'.$loo['loose_name'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                            <input type="hidden" name="loose_oil_name" value="<?php echo @$tender_details['loose_oil_id'];?>"> 
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
                                        <label class="col-md-4 control-label">Broker</label>
                                        <div class="col-md-6">
                                            <select  class="form-control" disabled name="broker_id" >
                                                <option selected value="">-Select Broker Name-</option>
                                                <?php 
                                                    foreach($broker as $bro)
                                                    {
                                                        $selected = '';
                                                        if($bro['broker_id'] == $tenders['broker_id']) $selected = 'selected';
                                                        echo '<option value="'.$bro['broker_id'].'" '.$selected.'>'.$bro['agency_name'].'</option>';
                                                    }
                                                ?>
                                            </select> 
                                            <input type="hidden" name="broker_name" value="<?php echo @$tenders['broker_id'];?>"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Supplier</label>
                                            <div class="col-md-6">
                                                <select  class="form-control" disabled name="supplier_id" >
                                                    <option selected value="">-Select Supplier Name-</option>
                                                    <?php 
                                                        foreach($supplier as $supp)
                                                        {
                                                            $selected = '';
                                                            if($supp['supplier_id'] ==$tenders['supplier_id']) $selected = 'selected';
                                                            echo '<option value="'.$supp['supplier_id'].'" '.$selected.'>'.$supp['agency_name'].'</option>';
                                                        }
                                                    ?>
                                                </select>
                                                <input type="hidden" name="supplier_name" value="<?php echo @$tenders['supplier_id'];?>"> 
                                            </div>
                                    </div>
                                </div>
                            </div>
                             <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Ops</label>
                                        <div class="col-md-6">
                                           <select name="plant_name" disabled class="form-control">
                                                <option value="">-Select Ops-</option>
                                                    <?php 
                                                        foreach($plant as $pla)
                                                        {
                                                            $selected = '';
                                                            if($pla['plant_id'] ==$tender_details['plant_id'] ) $selected = 'selected';
                                                            echo '<option value="'.$pla['plant_id'].'" '.$selected.'>'.$pla['plant_name'].'</option>';
                                                        }
                                                    ?>
                                            </select>
                                            <input type="hidden" name="plant_id" value="<?php echo @$tender_details['plant_id'];?>"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label ">Offered Qty(MT)</label>
                                        <div class="col-md-6">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                           <input class="form-control numeric quantity" disabled value="<?php echo @$tenders['offered_qty'];?>"  type="text" required>
                                           <input type="hidden" name="quantity" value="<?php echo @$tenders['offered_qty'];?>"> 
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Rate per (MT)</label>
                                        <div class="col-md-6">
                                          <input class="form-control numeric rate1" disabled name="rate2" value="<?php echo @$tenders['min_quote'];?>"  type="text">
                                          <input type="hidden" name="price" value="<?php echo @$tenders['min_quote'];?>"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label ">Total Amount</label>
                                        <div class="col-md-6">
                                           <input class="form-control numeric t_amount" disabled name="t_amount" value="<?php echo @$lrow['t_amount'];?>"  type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-offset-5 col-md-4">
                                    <input type="submit" class="btn blue tooltips" onclick="return confirm('Are you sure you want to Generate P.O.?')"  value="Generate P.O." name="submit">
                                    <a href="<?php echo SITE_URL.'tender_process_details'?>" class="btn default">Cancel</a>
                                </div>
                            </div>
                       </div>
                            </div>

                        </div>
                        
                    </form>
                    <?php } 
                    if($flag==2){ ?>
                        <form id="oil_form" class="srow form-horizontal" method="post" action="<?php echo SITE_URL.'insert_po'?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Purchase Order :</label>
                                            <div class="col-md-6">
                                                <input type="hidden" name="purchase_order" value="<?php echo @$po_number;?>">
                                                <p class="form-control-static"><b><?php echo  $po_number;?></b></p>
                                            </div>
                                    </div>
                                </div>
                                <input type="hidden" name="mtp_oil_id" value="<?php echo $mtp_oil_id; ?>">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Date :</label>
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
                                        <label class="col-md-4 control-label">Loose Oil <span class="font-red required_fld">*</span></label>
                                        <div class="col-md-6">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                            <select name="loose_oil_name" class="form-control loose_oil_name">
                                                <option value="">-Select Loose Oil-</option>
                                                <?php 
                                                    foreach($loose as $loo)
                                                    {
                                                        $selected = '';
                                                        if($loo['loose_oil_id'] ==@$loose_oil_id ) $selected = 'selected';
                                                        echo '<option value="'.$loo['loose_oil_id'].'" '.$selected.'>'.$loo['loose_name'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                            <input type="hidden" class="add_loose_oil_name">
                                            <span class="loose_oil_error"></span>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Type <span class="font-red required_fld">*</span></label>
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
                                            <input type="hidden" class="repeat_order_id" name="repeat_order" value="<?php echo @$repeat_order;?>">
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="mtp_oil_id" value="<?php echo $mtp_oil_id; ?>">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Broker <span class="font-red required_fld">*</span></label>
                                        <div class="col-md-6">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                            <select  class="form-control broker_name" name="broker_name" >
                                                <option selected value="">-Select Broker Name-</option>
                                                <?php 
                                                    foreach($broker as $bro)
                                                    {
                                                        $selected = '';
                                                        if($bro['broker_id'] ==@$broker_id) $selected = 'selected';
                                                        echo '<option value="'.$bro['broker_id'].'" '.$selected.'>'.$bro['agency_name'].'('.$bro['broker_code'].')'.'</option>';
                                                    }
                                                ?>
                                            </select> 
                                            <input type="hidden" class="add_broker_name">
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Supplier <span class="font-red required_fld">*</span></label>
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
                                        <label class="col-md-4 control-label">Ops <span class="font-red required_fld">*</span></label>
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
                                        <label class="col-md-3 control-label ">Quantity(MT) <span class="font-red required_fld">*</span></label>
                                        <div class="col-md-6">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                           <input class="form-control qty" name="qty" value="<?php echo @$lrow['qty'];?>"  type="number">
                                           <input type="hidden" class="add_qty">
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Rate <span class="font-red required_fld">*</span></label>
                                        <div class="col-md-6">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                           <input class="form-control rate" name="rate" value="<?php echo @$lrow['rate'];?>"  type="number">
                                           <input type="hidden" class="add_rate">
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label ">Total Amount</label>
                                        <div class="col-md-6">
                                           <input class="form-control numeric total_amount" disabled name="total_amount" value="<?php echo @$lrow['total_amount'];?>"  type="text">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                    <div class="col-md-offset-5 col-md-4">
                                         <input type="submit" class="btn blue tooltips" onclick="return confirm('Are you sure you want to Generate P.O.?')" value="Generate P.O." name="submit">
                                         <a href="<?php echo SITE_URL.'oil'?>" class="btn default">Cancel</a>
                                   </div>
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
   var loose_oil=$('.loose_oil_name option:selected').text();
   var loose_oil_name=$('.loose_oil_name option:selected').val();

   if(repeat_order == id)
   {
        if(loose_oil_name!='')
       {  
          html='';
          $('.loose_oil_name').css("border-color","inherit");
          $('.loose_oil_error').html(html);
       }
       else
       {
          $('.loose_oil_name').css("border-color","red");
          $('.loose_oil_error').html('Please Select Loose Oil');         
       }
        $.ajax({
            type:"POST",
            url:SITE_URL+'get_repeat_order_details_oil',
            data:{loose_oil_id:loose_oil_name},
            cache:false,
            success:function(html)
            {   /*alert(html.unit_price);
                $('.qty').val(html.quantity);*/
                if(html!='null')
                {
                    var arr = jQuery.parseJSON(html);
                   
                    $('.loose_oil_name').val(arr['loose_oil_id']).attr("disabled","disabled").removeAttr("name","loose_oil_name");
                    $('.broker_name').val(arr['broker_id']).attr("disabled","disabled").removeAttr("name","broker_name");
                    $('.supplier_name').val(arr['supplier_id']).attr("disabled","disabled").removeAttr("name","supplier_name"); 
                    $('.plant_name').val(arr['plant_id']).attr("disabled","disabled").removeAttr("name","plant_id");
                    $('.qty').val(arr['quantity']).removeAttr("name","qty");
                    $('.rate').val(arr['unit_price']).removeAttr("name","rate");
                    $('.total_amount').val((parseInt(arr['quantity']))*(parseInt(arr['unit_price']))).attr("disabled","disabled").removeAttr("name","total_amount");

                    $('.add_loose_oil_name').val(arr['loose_oil_id']).attr("name","loose_oil_name");
                    $('.add_broker_name').val(arr['broker_id']).attr("name","broker_name");
                    $('.add_supplier_name').val(arr['supplier_id']).attr("name","supplier_name");
                    $('.add_plant_id').val(arr['plant_id']).attr("name","plant_id");
                    $('.add_qty').val(arr['quantity']).attr("name","qty");
                    $('.add_rate').val(arr['unit_price']).attr("name","rate");
                }
                else
                {
                    alert('No repeat order is available for '+loose_oil+'. Please proceed through other one');
                }
            }
        });
   }
   else
   {
        html='';
      $('.loose_oil_name').css("border-color","inherit");
      $('.loose_oil_error').html(html);

        $('.loose_oil_name').removeAttr("disabled").attr("name","loose_oil_name");
        $('.broker_name').val('').removeAttr("disabled").attr("name","broker_name");
        $('.supplier_name').val('').removeAttr("disabled").attr("name","supplier_name"); 
        $('.plant_name').val('').removeAttr("disabled").attr("name","plant_id");
        $('.qty').val('').removeAttr("disabled").attr("name","qty");
        $('.rate').val('').removeAttr("disabled").attr("name","rate");
        $('.total_amount').val('').attr("name","total_amount");

        $('.add_loose_oil_name').val('').removeAttr("name","loose_oil_name");
        $('.add_broker_name').val('').removeAttr("name","broker_name");
        $('.add_supplier_name').val('').removeAttr("name","supplier_name");
        $('.add_plant_id').val('').removeAttr("name","plant_id");
        $('.add_qty').val('').removeAttr("name","qty");
        $('.add_rate').val('').removeAttr("name","rate");
}
});

$('.loose_oil_name').change(function(){
    var loose_oil_name = $(this).val();
    if(loose_oil_name!='')
       {  
          html='';
          $('.loose_oil_name').css("border-color","inherit");
          $('.loose_oil_error').html(html);
          $('.po_type').val('');
          $('.po_type').prev('i').removeClass('fa-check fa-warning').addClass('fa');
          $('.po_type').closest('div.form-group').removeClass('has-success has-error');
       }
       else
       {
          $('.loose_oil_name').css("border-color","red");
          $('.loose_oil_error').html('Please Select Loose Oil');         
       }
})
</script>