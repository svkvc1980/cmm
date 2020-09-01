<?php $this->load->view('commons/main_template', $nestedView); ?>



<!-- BEGIN PAGE CONTENT INNER -->

<div class="page-content-inner">

    <div class="row">

        <div class="col-md-12">

            <!-- BEGIN BORDERED TABLE PORTLET-->

            <div class="portlet light portlet-fit">

                <div class="portlet-body">

                	<?php if($flag==1){ ?>

					    <form  method="post" action="<?php echo SITE_URL.'mtp_packingmaterial'?>">

	                        <div class="row">

	                           <div class="col-sm-3">

	                                <div class="form-group">

	                                    <input class="form-control" name="mtp_no" value="<?php echo @$search_params['mtp_number'];?>" placeholder="MTP No" type="text">

	                                </div>

	                            </div>

	                            <div class="col-sm-3">

	                                <div class="form-group">

	                                    <select name="packing_name" class="form-control">

	                                        <option value="">-Select Packing Material-</option>

	                                        <?php 

	                                            foreach($packing as $pack)

	                                            {

	                                                $selected = '';

	                                                if($pack['pm_id'] ==@$search_params['pm_id'] ) $selected = 'selected';

	                                                echo '<option value="'.$pack['pm_id'].'" '.$selected.'>'.$pack['packing_name'].'</option>';

	                                            }

	                                        ?>

	                                    </select>

	                                </div>

	                            </div>

	                            <div class="col-sm-3">

	                                <div class="form-group">

	                                    <select name="plant_name" class="form-control">

	                                            <option value="">-Select Ops-</option>

	                                            <?php 

	                                                foreach($plant as $pla)

	                                                {

	                                                    $selected = '';

	                                                    if($pla['plant_id'] ==@$search_params['plant_id'] ) $selected = 'selected';

	                                                    echo '<option value="'.$pla['plant_id'].'" '.$selected.'>'.$pla['plant_name'].'</option>';

	                                                }

	                                            ?>

	                                        </select>

	                                </div>

	                            </div>

	                            <div class="col-sm-3">

	                                <button type="submit" title="Search" name="search_packing_material" value="1" class="btn blue"><i class="fa fa-search"></i> </button>

	                                <a href="<?php echo SITE_URL;?>mtp_packingmaterial_add" title="Add New" class="btn blue"><i class="fa fa-plus"></i> </a>

	                                <button title="Download" type="submit" name="download_packing_material" value="download" formaction="<?php echo SITE_URL;?>download_packing_material" class="btn blue"><i class="fa fa-cloud-download"></i> </button>

	                            </div>

	                        </div>

	                        <table class="table table-bordered table-striped table-hover">

	                            <thead>

	                                <tr>

	                                    <th> MTP No </th>

	                                    <th> Packing Material</th>

	                                    <th> OPS </th>

	                                    <th> Quantity </th>

	                                    <th> Tender Date</th>

	                                    <th> Status</th>

	                                    <th> Actions </th>            

	                                </tr>

	                            </thead>

	                            <tbody>

	                                <?php

	                                if(count($mtp_packing)>0)

	                                {  

	                                    foreach($mtp_packing as $row)

	                                    {

	                                ?>

	                                    <tr>

	                                        <td width="10%"> <?php echo $row['mtp_number'];?> </td>

	                                        <td width="15%"> <?php echo $row['packing_name'];?> </td>

	                                        <td width="15%"> <?php echo $row['plant_name'];?> </td>

	                                        <td width="15%"> <?php echo $row['quantity'];?> </td>

	                                        <td width="15%"> <?php echo date("d-m-Y", strtotime($row['mtp_date']));?> </td>

	                                        <td width="10%"> <?php echo get_status($row['status']);?> </td>

	                                        <td width="15%">

	                                             <a href="<?php echo SITE_URL;?>add_tender_details/<?php echo cmm_encode($row['mtp_pm_id']); ?>" class="btn purple btn-xs tooltips"  data-container="body" data-placement="top" data-original-title="Add Tender"><i class="fa fa-gavel"></i></a>


	                                           

	                                            <?php 

	                                                if($row['status']==2 || $row['status'] ==3)

	                                                {  ?>

	                                                    <a class="btn green btn-xs" disabled><i class="fa fa-cart-arrow-down"></i></a>  

	                                            <?php  } 

	                                                else

	                                                {  ?>

	                                                    <a href="<?php echo SITE_URL;?>po_packing_material/<?php echo cmm_encode($row['mtp_pm_id']); ?>" class="btn green btn-xs tooltips" data-container="body" data-placement="top" data-original-title="Generate PO" ><i class="fa fa-cart-arrow-down"></i></a>  

	                                            <?php    }

	                                            

	                                            if($row['status']==2 || $row['status']==3)

	                                            { ?>

	                                                 <a  class="btn red btn-xs" disabled><i class="fa fa-remove"></i></a> 

	                                            <?php }

	                                            else

	                                            { ?>

	                                                 <a href="<?php echo SITE_URL;?>reject_packingmaterial/<?php echo cmm_encode($row['mtp_pm_id']); ?>" class="btn red btn-xs tooltips"  data-container="body" data-placement="top" data-original-title="Reject"><i class="fa fa-remove"></i></a> 

	                                            <?php } ?>

	                                           

	                                        </td>

	                                    </tr>

	                                    <?php

	                                    }

	                                } 

	                                else 

	                                {

	                                ?>  

	                                    <tr><td colspan="7" align="center"><span class="label label-primary">No Records</span></td></tr>

	                                <?php   

	                                } ?>

	                            </tbody>

	                        </table>

	                    </form>

	                    <?php } 

	                    if($flag==2)

		                {

		                ?>  

		                <form id="mtp_pm_form" method="post" action="<?php echo SITE_URL.'mtp_packingmaterial_insert';?>" class="form-horizontal">

		                    <div class="row">  

		                        <div class="col-md-offset-3 col-md-5"> 

		                                <div class="form-group">

		                                    <label class="col-md-5 control-label">MTP No</label>

		                                    <div class="col-md-6">

		                                      <input type="hidden" name="mtp_no" readonly class="form-control" value="<?php echo @$mtp_pm_id;?>">

		                                        <b><p class="form-control-static"><?php echo  @$mtp_pm_id;?></p></b> 

		                                    </div>

		                                </div>                          

		                                <div class="form-group">

		                                    <label class="col-md-5 control-label">Packing Material<span class="font-red required_fld">*</span></label>

		                                    <div class="col-md-7">

		                                        <div class="input-icon right">

		                                        <i class="fa"></i>

		                                            <select name="packing_name" class="form-control packing_material">

		                                                <option value="">-Select Packing Material-</option>

		                                                <?php 

		                                                    foreach($packing as $pack)

		                                                    {

		                                                        $selected = '';

		                                                        if($pack['pm_id'] ==@$pm_id ) $selected = 'selected';

		                                                        echo '<option value="'.$pack['pm_id'].'" '.$selected.'>'.$pack['packing_name'].'</option>';

		                                                    }

		                                                ?>

		                                            </select>

		                                        </div>

		                                    </div>

		                                </div>

		                                <div class="form-group">

		                                    <label class="col-md-5 control-label">Ops<span class="font-red required_fld">*</span></label>

		                                    <div class="col-md-7">

		                                    <div class="input-icon right">

		                                    <i class="fa"></i>

		                                        <select name="plant_name" class="form-control">

		                                            <option value="">-Select Ops-</option>

		                                            <?php 

		                                                foreach($plant as $pla)

		                                                {

		                                                    $selected = '';

		                                                    if($pla['plant_id'] ==@$plant_id ) $selected = 'selected';

		                                                    echo '<option value="'.$pla['plant_id'].'" '.$selected.'>'.$pla['plant_name'].'</option>';

		                                                }

		                                            ?>

		                                        </select>

		                                    </div>

		                                    </div>

		                                </div>

		                                <div class="form-group">

		                                    <label class="col-md-5 control-label">Quantity <span class="font-red required_fld">*</span></label>

		                                    <div class="col-md-7">

		                                    <div class="input-icon right">

		                                    <i class="fa"></i>

		                                       <input type="number" name="quantity" maxlength="15" placeholder="Metric Tons" class="form-control ">

		                                    </div>

		                                    </div>

		                                </div>

		                                <div class="form-group">

		                                    <label class="col-md-5 control-label">MTP Date<span class="font-red required_fld">*</span></label>

		                                    <div class="col-md-7">

		                                    <div class="input-icon right">

		                                    <i class="fa"></i>

		                                      <input type="text" name="mtp_date" class="form-control date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d" value="<?php echo date('d-m-Y');?>">

		                                    </div>

		                                    </div>

		                                </div><br>

		                                <div class="form-group">

		                                    <div class="col-md-3"></div>

		                                        <div class="col-md-8">

		                                            <input type="submit" class="btn blue tooltips" value="submit" name="submit">

		                                            <a href="<?php echo SITE_URL.'mtp_packingmaterial';?>" class="btn default">Cancel</a>

		                                        </div>                                 

		                                </div>

		                            </div>

		                        </div>

		                    </form> 

                        <?php } 

                        if($flag==3)

                        { ?>

                        <div class="row">

	                        <div class="col-md-6">

	                            <div class="form-group">

	                                <label class="col-md-4 control-label">MTP No</label>

	                                    <div class="col-md-6">

	                                        <input type="hidden" name="mtp_no" value="<?php echo @$packing_material_insert_details['mtp_number'];?>">

	                                        <b><?php echo  $packing_material_insert_details['mtp_number'];?></b>

	                                    </div>

	                            </div>

	                        </div>

	                        <div class="col-md-6">

	                            <div class="form-group">

	                                <label class="col-md-4 control-label">Packing Material</label>

	                                    <div class="col-md-6">

	                                        <input type="hidden" name="packing_name" value="<?php echo @$packing_material_insert_details['packing_name'];?>">

	                                        <b><?php echo  $packing_material_insert_details['packing_name'];?></b>

	                                    </div>

	                            </div>

	                        </div><br><br>

	                        <div class="col-md-6">

	                            <div class="form-group">

	                                <label class="col-md-4 control-label">Ops</label>

	                                    <div class="col-md-6">

	                                        <input type="hidden" name="plant_name" value="<?php echo @$packing_material_insert_details['plant_name'];?>">

	                                        <b><?php echo  $packing_material_insert_details['plant_name'];?></b>

	                                    </div>

	                            </div>

	                        </div>

	                        <div class="col-md-6">

	                            <div class="form-group">

	                                <label class="col-md-4 control-label">MTP Date</label>

	                                    <div class="col-md-6">

	                                        <input type="hidden" name="mtp_date" data-date-format="dd-mm-yyyy" value="<?php echo @$packing_material_insert_details['mtp_date'];?>">

	                                        <b><?php echo  date('d-m-Y',strtotime($packing_material_insert_details['mtp_date']));?></b>

	                                    </div>

	                            </div>

	                        </div><br><br>

	                        <div class="col-md-6">

	                            <div class="form-group">

	                                <label class="col-md-4 control-label">Quantity </label>

	                                    <div class="col-md-6">

	                                        <input type="hidden" name="quantity_rate" value="<?php echo @$packing_material_insert_details['quantity'];?>">

											<b><?php echo  $packing_material_insert_details['quantity'];?></b>

	                                    </div>

	                            </div>

	                        </div>

	                    </div><br>

	                    <form id="pm_tenders_form" method="post" action="<?php echo SITE_URL.'insert_tender'?>" enctype="multipart/form-data" class="form-horizontal">

	                        <input type="hidden" name="mtp_pm_id" value="<?php echo $packing_material_insert_details['mtp_pm_id'];?>">

	                        <div class="table-scrollable" id="tender">

	                            <table class="table table-bordered table-striped table-hover" id="ocb">

	                                <thead>

	                                    <tr>

	                                        <th width="20%"> Supplier Name </th>

	                                         <th width="10%"> Quantity</th>

	                                        <th width="10%"> Quoted Rate</th>

	                                        <th width="10%"> Negotiated Rate</th>

	                                        <th width="15%"> Supporting Document</th>

	                                        <th width="15%"> Actions</th>

	                                    </tr>

	                                </thead>

	                                <tbody>

                                     <?php

                                    if($packing_material_addtender_details)

                                    {

                                        foreach($packing_material_addtender_details as $row)

                                        {

                                    ?>

                                        <tr>

                                            <td> <?php echo $row['supplier_name'];?> </td>

                                            <td> <?php echo $row['quantity'];?> </td>

                                            <td> <?php echo $row['quoted_price'];?> </td>

                                            <td> <?php echo $row['negotiated_price'];?>

                                            <td>

                                                <?php 

                                                    if($row['support_document']!='')

                                                    { ?>

                                                        <a href="<?php echo get_tender_upload_url().$row['support_document'];?>" class="btn blue btn-circle btn-xs" download><i class="fa fa-cloud-download"></i></a></td>

                                                    <?php }

                                                    else

                                                    { ?>

                                                        <a  disabled class="btn blue btn-circle btn-xs" download><i class="fa fa-cloud-download"></i></a></td>

                                                    <?php } ?>

                                            </td>

                                            <td><?php 
                                            if(@$row['status']!=5)
                                            { ?>

                                                <a class="btn btn-default btn-xs" href="<?php echo SITE_URL;?>edit_tender_details/<?php echo cmm_encode($row['tender_pm_id']); ?>"><i class="fa fa-pencil"></i></a> 

                                                <?php

                                                if(@$row['status'] == 1)

                                                {

                                                    ?>

                                                    <a class="btn btn-danger btn-xs" title="De-Activate" href="<?php echo SITE_URL;?>deactivate_tender_details/<?php echo cmm_encode($row['tender_pm_id']) ?>/<?php echo $mtp_pm_id; ?>" onclick="return confirm('Are you sure you want to Deactivate?')"><i class="fa fa-trash-o"></i></a>

                                                    <?php

                                                }

                                                else

                                                {

                                                    ?>

                                                    <a class="btn btn-info btn-xs" title="Activate" href="<?php echo SITE_URL;?>activate_tender_details/<?php echo cmm_encode($row['tender_pm_id']); ?>/<?php echo $mtp_pm_id; ?>" onclick="return confirm('Are you sure you want to Activate?')"><i class="fa fa-check"></i></a>

                                                    <?php

                                                }
                                               }
	                                               else
	                                            {
	                                                echo "P.O. Generated";
	                                            }?>

                                            </td>



                                        </tr>

                                        <?php

                                        } 

                                    } ?>

                                    <tr class="srow">

                                        <td>

                                            <select  class="form-control select2"  name="supplier_name[1]" >

                                                <option selected value="">-Select Supplier-</option>

                                                    <?php 

                                                        foreach($supplier as $supp)

                                                        {

                                                            $selected = '';

                                                            if($supp['supplier_id'] ==@$supplier_id ) $selected = 'selected';

                                                            echo '<option value="'.$supp['supplier_id'].'">'.$supp['supplier_code'].'('.$supp['agency_name'].')</option>';

                                                        }

                                                    ?> 

                                            </select> 

                                        </td>

                                        <td>

                                            <input class="form-control numeric quantity" name="quantity[1]"  type="text"> 

                    
                                        </td>

                                        <td>

                                            <input class="form-control numeric quoted_rate" name="quoted_rate[1]"  type="text"> 

                                            <span class="err_quoted_rate"></span>

                                        </td>

                                        <td>

                                            <input class="form-control numeric negotiated_rate" name="negotiated_rate[1]" type="text"> 

                                            <span class="err_negotiated_rate"></span>

                                        </td>

                                        <td>

                                            <input type="file" class="fileinput button" name="support_document_1" >

                                        </td>

                                        <td style="display:none">

                                        <button class="btn red btn-xs delete remove_tender" type="submit" name="remove" value="button"><i class="fa fa-trash"></i></button>

                                        </td>

                                    </tr>

                                </tbody>

	                            </table>

	                        </div>

	                         <button class="btn blue" type="submit" name="add" id="add" value="button"><i class="fa fa-plus"></i>Add New</button>

	                        <div class="form-group">

	                            <div class="row">

	                                <div class="col-md-5"></div>

	                                <div class="col-md-4">

	                                    <input type="submit" class="btn blue tooltips" value="submit" name="submit">

	                                    <a href="<?php echo SITE_URL.'mtp_packingmaterial';?>" class="btn default">Cancel</a>

	                                </div>

	                            </div>                                 

	                        </div>

	                    </form>

	                    <?php }

	                    if($flag==4) { ?>

                        <form id="tenders_form" method="post" action="<?php echo SITE_URL.'update_tender_details'?>" enctype="multipart/form-data" class="form-horizontal">

                            <input type="hidden" name="tender_pm_id" value="<?php echo $get_add_tenders['tender_pm_id'];?>">

                            <input type="hidden" name="mtp_pm_id" value="<?php echo $get_add_tenders['mtp_pm_id'];?>">

                       

                        <div class="alert alert-danger display-hide" style="display: none;">

                           <button class="close" data-close="alert"></button> You have some form errors. Please check below. 

                        </div>

                        <div class="srow">

                            <div class="form-group">

                               <label class="col-md-4 control-label">Supplier<span class="font-red required_fld">*</span></label>

                                    <div class="col-md-3">

                                        <div class="input-icon right">

                                            <i class="fa"></i>

                                                <select  class="form-control"  name="supplier_name" >

                                                    <option selected value="">-Select Supplier-</option>

                                                        <?php 

                                                            foreach($supplier as $supp)

                                                            {

                                                                $selected = '';

                                                                if($supp['supplier_id'] ==$get_add_tenders['supplier_id'] ) $selected = 'selected';

                                                                 echo '<option value="'.$supp['supplier_id'].'" '.$selected.'>'.$supp['agency_name'].'</option>';

                                                            }

                                                        ?> 

                                                </select> 

                                        </div>

                                    </div>

                            </div>

                            <div class="form-group">

                                <label class="col-md-4 control-label">Quoted Rate<span class="font-red required_fld">*</span></label>

                                    <div class="col-md-3">

                                        <div class="input-icon right">

                                            <i class="fa"></i>

                                            <input type="number" class="form-control quoted_rate" name="quoted_rate" value="<?php echo @$get_add_tenders['quoted_price']; ?>" type="text"> 

                                        	<span class="err_quoted_rate"></span>

                                        </div>

                                    </div>

                            </div>

                            <div class="form-group">

                                <label class="col-md-4 control-label">Negotiated Rate<span class="font-red required_fld">*</span></label>

                                <div class="col-md-3">

                                    <div class="input-icon right">

                                        <i class="fa"></i>

                                        <input class="form-control negotiated_rate" name="negotiated_rate" value="<?php echo @$get_add_tenders['negotiated_price']; ?>" type="number"> 

                                    	<span class="err_negotiated_rate"></span>

                                    </div>

                                </div>

                            </div>

                            <?php if($get_add_tenders['support_document']!='') { ?>

                            <div class="form-group">

                                <label class="col-md-4 control-label">Old Support Document</label>

                                <div class="col-md-3">

                                    <a href="<?php echo get_tender_upload_url().$get_add_tenders['support_document'];?>" class="btn blue btn-xs" download><i class="fa fa-cloud-download"></i></a> <p class="form-control-static"> <?php echo $get_add_tenders['support_document'];?></p>

                                </div>

                            </div>

                            <?php } ?>

                            <div class="form-group">

                                <label class="col-md-4 control-label">Support Document</label>

                                    <div class="col-md-3">

                                        <div class="input-icon right">

                                            <i class="fa"></i>

                                             <input type="file" class="fileinput button" name="support_document_1">

                                        </div>

                                    </div>

                            </div>

                            <div class="form-group">

                                <div class="col-md-offset-4 col-md-6">

                                    <button class="btn blue" type="submit" name="submit" value="submit"><i class="fa fa-check"></i> Submit</button>

                                    <a class="btn default" href="<?php echo SITE_URL;?>mtp_packingmaterial"><i class="fa fa-times"></i> Cancel</a>

                                </div>

                            </div>

                        </div>

                        </form>

                        <?php } ?>

	                    <div class="row">

                            <div class="col-md-5 col-sm-5">

                                <div class="dataTables_info" role="status" aria-live="polite">

                                    <?php echo @$pagermessage; ?>

                                </div>

                            </div>

                            <div class="col-md-7 col-sm-7">

                                <div class="dataTables_paginate paging_bootstrap_full_number">

                                    <?php echo @$pagination_links; ?>

                                </div>

                            </div>

                       </div>

                </div>

            </div>

            <!-- END BORDERED TABLE PORTLET-->

        </div>

    </div>               

</div>

<!-- END PAGE CONTENT INNER -->

<?php $this->load->view('commons/main_footer',$nestedView); ?>

<script>

$(document).on('keyup','.negotiated_rate',function(){ 

  var ele_panel_body=$(this).closest('.srow');

  var quoted_rate=ele_panel_body.find('.quoted_rate').val();

  var negotiated_rate=ele_panel_body.find('.negotiated_rate').val();

  //alert (quoted_rate);

  if(parseInt(quoted_rate)<parseInt(negotiated_rate))

  {

    ele_panel_body.find('.quoted_rate').css("border-color","red");

    ele_panel_body.find('.negotiated_rate').css("border-color","red");

    ele_panel_body.find('.err_negotiated_rate').html('Negotiated Rate must be Less than Quoted rate');

    return false;

  }

  else

  {

    html='';

     ele_panel_body.find('.quoted_rate').css("border-color","inherit");

    ele_panel_body.find('.negotiated_rate').css("border-color","inherit");

    ele_panel_body.find('.err_negotiated_rate').html(html);

  }

 /* var total_amount=quantity*rate;

  ele_panel_body.find('.total_amount').val(total_amount);*/

});



$(".packing_category").change(function (){ 



    var packing_category=$(this).val();

    if(packing_category=='')

    {

        $(".packing_material").html('<option value="">-Select Packing Material-</option');

        $(this).focus();

    }

    else

    {

        $.ajax({

            type:"POST",

            url:SITE_URL+'ajax_packing_material',

            data:{pm_category_id:packing_category},

            cache:false,

            success:function(html){

                

                $(".packing_material").html(html);

            }

        });

    }

});

</script>

	         

