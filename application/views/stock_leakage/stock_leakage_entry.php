<?php $this->load->view('commons/main_template', $nestedView); ?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                	<?php if($flag==1) { ?>
                    <form id="leakage_form" method="post" action="<?php echo SITE_URL.'confirm_stock_leakage_entry';?>" class="form-horizontal">
                        <div class="row ">  
                            <div class="col-md-offset-3 col-md-5">
                                
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Date</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="on_date" data-date-format="dd-mm-yyyy" value="<?php echo date('Y-m-d');?>">
                                        <p class="form-control-static"><b><?php echo date('d-m-Y');?></b></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Leakage No</label>
                                    <div class="col-md-6">
                                        <input class="form-control" name="leakage_number" value="<?php echo $leakage_number;?>"  type="hidden">
                                        <p class="form-control-static"><b><?php echo $leakage_number;?></b></p>
                                    </div>
                                </div>                            
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Unit</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static "><b><?php echo $plant_name ;?></b></p>
                                        <input class="form-control" name="unit" value="<?php echo $plant_name;?>"  type="hidden">
                                    </div>
                                </div><?php if($type == 1)
                                {
                                 $location ="Godown";
                                } else
                                {
                                	$location ="Counter Sale";
                                } ?>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Location</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static "><b><?php echo $location ;?></b></p>
                                        <input class="form-control" name="type" value="<?php echo $type;?>"  type="hidden">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Product<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                            <select name="product_id" required class="form-control product">
                                                <option value="">-Select Product-</option>
                                                <?php 
                                                    foreach($product as $pro)
                                                    {
                                                        $selected = '';
                                                        if($pro['product_id'] ==@$product_id ) $selected = 'selected';
                                                        echo '<option value="'.$pro['product_id'].'" '.$selected.'>'.$pro['product_name'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="items_per_carton" class="form-control items_per_carton">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Cartons Leaked<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                           <input type="text" required name="no_of_cartons" maxlength="15" placeholder="No of Cartons" class="form-control no_of_cartons numeric">
                                        </div>
                                       
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Pouches Leaked<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                           <input type="text" required name="no_of_pouches" maxlength="15" placeholder="No of Pouches" class="form-control no_of_pouches numeric">
                                        </div>
                                        <span class="err_pouch"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Recovered Cartons<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                            <input type="text" readonly required name="cartons" placeholder="Cartons" class="form-control numeric cartons">
                                        </div>
                                         <span class="err_cartons"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Recovered Pouches<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                             <input type="text" readonly required name="pouches" placeholder="Pouches" class="form-control numeric pouches">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Recovered Oil<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                           <input type="text" required name="recovered_oil" maxlength="15" placeholder="Recovered Oil" class="form-control numeric recovered_oil">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Remarks</label>
                                    <div class="col-md-7">
	                                    <div class="input-icon right">
		                                    <i class="fa"></i>
		                                    <input type="text" name="remarks" placeholder="Remarks" class="form-control ">
		                                </div>
                                    </div>
	                            </div>
                                <div class="form-group">
                                    <div class="col-md-3"></div>
                                        <div class="col-md-8">
                                            <input type="submit" class="btn blue tooltips submit leakage_submit" value="submit"  name="submit">
                                            <a href="<?php if($type =='1') { echo SITE_URL.'godown_leakage_entry'; } else { echo SITE_URL.'counter_leakage_entry'; }?>" class="btn default">Cancel</a>
                                        </div>                                 
                                </div>
                            </div>
                        </div>
                    </form> 
                    <?php } elseif($flag ==2) { ?>
                         <form id="leakage_form" method="post" action="<?php echo SITE_URL.'insert_stock_leakage_entry';?>" class="form-horizontal">
                         <div class="row ">  
                            <div class="col-md-offset-3 col-md-5">
                                
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Date :</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="on_date" data-date-format="dd-mm-yyyy" value="<?php echo date('Y-m-d');?>">
                                        <p class="form-control-static"><b><?php echo date('d-m-Y');?></b></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Leakage No :</label>
                                    <div class="col-md-6">
                                        <input class="form-control" name="leakage_number" value="<?php echo $dat['leakage_number'];?>"  type="hidden">
                                        <p class="form-control-static"><b><?php echo $dat['leakage_number'];?></b></p>
                                    </div>
                                </div>                            
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Unit :</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static "><b><?php echo $dat['plant_name'] ;?></b></p>
                                        <input class="form-control" name="unit" value="<?php echo $dat['plant_name'];?>"  type="hidden">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Product :</label>
                                    <div class="col-md-6">
                                        <input class="form-control" name="product_id" value="<?php echo $dat['product_id'];?>"  type="hidden">
                                        <p class="form-control-static"><b><?php echo $dat['product_name'];?></b></p>
                                    </div>
                                </div>
                                <input type="hidden" name="items_per_carton" value="<?php echo $dat['items_per_carton'];?>">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Cartons Leaked :</label>
                                    <div class="col-md-6">
                                        <input class="form-control" name="no_of_cartons" value="<?php echo $dat['no_of_cartons'];?>"  type="hidden">
                                        <p class="form-control-static"><b><?php echo $dat['no_of_cartons'];?></b></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Pouches Leaked :<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                       <input class="form-control" name="no_of_pouches" value="<?php echo $dat['no_of_pouches'];?>"  type="hidden">
                                       <p class="form-control-static"><b><?php echo $dat['no_of_pouches'];?></b></p> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Type :<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                    <input type="hidden" name="type" value="<?php echo $dat['type'];?>">
                                       <?php if ($dat['type']==1)
                                           {  ?>
                                       <p class="form-control-static"><b><?php echo "Godown";?></b></p> 
                                       <?php } else { ?>
                                        <p class="form-control-static"><b><?php echo "Counter Sale";?></b></p>
                                       <?php } ?>
                                    </div>
                                </div> 
                                 <div class="form-group">
                                    <label class="col-md-5 control-label">Recovered Cartons :<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                       <input class="form-control" name="cartons" value="<?php echo $dat['cartons'];?>"  type="hidden">
                                       <p class="form-control-static"><b><?php echo $dat['cartons'];?></b></p> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Recovered Pouches :<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                       <input class="form-control" name="pouches" value="<?php echo $dat['pouches'];?>"  type="hidden">
                                       <p class="form-control-static"><b><?php echo $dat['pouches'];?></b></p> 
                                    </div>
                                </div>
                               
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Recovered Oil :</label>
                                    <div class="col-md-6">
                                       <input class="form-control" name="recovered_oil" value="<?php echo $dat['recovered_oil'];?>"  type="hidden">
                                             <p class="form-control-static"><b><?php echo $dat['recovered_oil'];?></b></p> 
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-md-5 control-label">Remarks :</label>
                                    <div class="col-md-6">
                                       <input class="form-control" name="remarks" value="<?php echo $dat['remarks'];?>"  type="hidden">
                                             <p class="form-control-static"><b><?php echo $dat['remarks'];?></b></p> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-3"></div>
                                        <div class="col-md-8">
                                            <input type="submit" class="btn blue tooltips" value="submit" name="submit">
                                             <a href="<?php if($dat['type'] =='1') { echo SITE_URL.'godown_leakage_entry'; } else { echo SITE_URL.'counter_leakage_entry'; }?>" class="btn default">Cancel</a>
                                        </div>                                 
                                </div>
                            </div>
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
    $(document).on('change','.product',function(){
     var product_id= $(this).val();
      $.ajax({
            type:"POST",
            url:SITE_URL+'get_carton_per_product',
            data:{product_id:product_id},
            cache:false,
            success:function(html)
            { 
                $('.items_per_carton').val(html);
                $('.pouches').val('');
                $('.no_of_pouches').val('');
                $('.no_of_cartons').val('');
               
            }
        });
    });
});
$(document).on('change','.type,.no_of_pouches,.no_of_cartons',function(){
   var no_of_cartons=parseInt($('.no_of_cartons').val());
   var type=$('input[name="type"]:checked').val();
   var no_of_pouches=parseInt($('.no_of_pouches').val());
   var items_per_carton=parseInt($('.items_per_carton').val());
   var arr_carton=(no_of_cartons*items_per_carton)-(no_of_pouches);
   var cartons=(arr_carton)/(items_per_carton);
   var pouches=arr_carton-(parseInt(cartons)*items_per_carton);
  // alert(no_of_pouches+'hi'+no_of_cartons+'hi'+items_per_carton);
  if(no_of_pouches > (no_of_cartons*items_per_carton))
  {
    $('.no_of_pouches').css("border-color","red");
    $('.err_pouch').html('Leaked Pouches('+no_of_pouches+') exceeded carton size('+no_of_cartons*items_per_carton+')');
      // return false;
  }
  else
  {
      if(isNaN(pouches)) {
         var pouches = 0;
        }
      if(isNaN(cartons)) {
         var cartons = 0;
        }
       
           $('.pouches').val(pouches);
           $('.cartons').val(parseInt(cartons));
           $('.no_of_pouches').css("border-color","inherit");
           $('.err_pouch').html('');

    }
});
$('.leakage_submit').click(function(){
   var no_of_pouches=parseInt($('.no_of_pouches').val());
   var items_per_carton=parseInt($('.items_per_carton').val()); 
   var no_of_cartons=parseInt($('.no_of_cartons').val());
   if(no_of_pouches > (no_of_cartons*items_per_carton))
   {
     $('.no_of_pouches').css("border-color","red");
     $('.err_pouch').html('Leaked Pouches('+no_of_pouches+') exceeded carton size('+no_of_cartons*items_per_carton+')');
       return false;
   }
   else
   {
     $('.no_of_pouches').css("border-color","inherit");
     $('.err_pouch').html('');
   }

});
</script> 