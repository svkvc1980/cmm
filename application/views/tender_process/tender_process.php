<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                <?php if($flag==2)
                {
                ?>  <form id="tender_form" method="post" action="<?php echo SITE_URL.'insert_tender_process';?>" class="form-horizontal">
                    <div class="row">  
                        <div class="col-md-offset-3 col-md-5"> 
                                <div class="form-group">
                                    <label class="col-md-5 control-label">MTP No:</label>
                                    <div class="col-md-6">
                                      <input type="hidden" name="mtp_no" readonly class="form-control" value="<?php echo @$mtp_oil_id;?>">
                                        <b><p class="form-control-static"><?php echo  @$mtp_oil_id;?></p></b> 
                                    </div>
                                </div>                          
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Loose Oil<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                            <select name="loose_oil_name" class="form-control">
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
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Ops<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                    <div class="input-icon right">
                                    <i class="fa"></i>
                                        <select name="plant_id" class="form-control">
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
                                    <label class="col-md-5 control-label">Quantity(MT)<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                    <div class="input-icon right">
                                    <i class="fa"></i>
                                       <input type="number" name="quantity" maxlength="15" placeholder="Metric Tons" class="form-control">
                                    </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Tender Date<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                    <div class="input-icon right">
                                    <i class="fa"></i>
                                      <input type="text" name="tender_date" class="form-control date-picker" data-date-format="dd-mm-yyyy" data-date-start-date="+0d" value="<?php echo date('d-m-Y');?>">
                                    </div>
                                    </div>
                                </div><br>
                                <div class="form-group">
                                    <div class="col-md-3"></div>
                                        <div class="col-md-8">
                                            <input type="submit" class="btn blue tooltips" value="submit" name="submit">
                                            <a href="<?php echo SITE_URL.'tender_process_details';?>" class="btn default">Cancel</a>
                                        </div>                                 
                                </div>
                        </div>
                        </div>
                        
                    </form> 
                <?php } if($flag==1){ ?>

                    <form  method="post" action="<?php echo SITE_URL.'tender_process_details'?>">
                        <div class="row">
                           <div class="col-sm-3">
                                <div class="form-group">
                                    <input class="form-control" name="mtp_no" value="<?php echo @$search_params['mtp_no'];?>" placeholder="MTP No" type="text">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <select name="loose_oil_id" class="form-control">
                                        <option value="">-Select Loose Oil-</option>
                                        <?php 
                                            foreach($loose as $loo)
                                            {
                                                $selected = '';
                                                if($loo['loose_oil_id'] ==@$search_params['loose_oil_id'] ) $selected = 'selected';
                                                echo '<option value="'.$loo['loose_oil_id'].'" '.$selected.'>'.$loo['loose_name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <select name="plant_id" class="form-control">
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
                                <button type="submit" title="Search" name="search_tender" value="1" class="btn blue"><i class="fa fa-search"></i> </button>
                                <button title="Download" type="submit" name="download_tender" value="download" formaction="<?php echo SITE_URL;?>download_tender" class="btn blue"><i class="fa fa-cloud-download"></i> </button>
                                <a href="<?php echo SITE_URL;?>tender_process" title="Add New" class="btn blue"><i class="fa fa-plus"></i> </a>
                                
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th> MTP No </th>
                                    <th> Loose Oil</th>
                                    <th> OPS </th>
                                    <th> Quantity (MT)</th>
                                    <th> Tender Date</th>
                                    <th> Status</th>
                                    <th> Actions </th>            
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(count($tender)>0)
                                {  
                                    foreach($tender as $row)
                                    {
                                ?>
                                    <tr>
                                        <td width="10%"> <?php echo $row['mtp_number'];?> </td>
                                        <td width="15%"> <?php echo $row['loose_oil_name'];?> </td>
                                        <td width="15%"> <?php echo $row['plant_name'];?> </td>
                                        <td width="15%"> <?php echo $row['quantity'];?> </td>
                                        <td width="15%"> <?php echo date("d-m-Y", strtotime($row['tender_date']));?> </td>
                                        <td width="10%"> <?php echo get_status($row['status']);?> </td>
                                        <td width="15%">
                                       
                                             <a href="<?php echo SITE_URL;?>tender_details/<?php echo cmm_encode($row['mtp_oil_id']); ?>" class="btn purple btn-xs tooltips"  data-container="body" data-placement="top" data-original-title="Add Tender"><i class="fa fa-gavel"></i></a>
                                          <?php 
                                           if($row['status']==2 || $row['status']==3)
                                         {  
                                           ?> 
                                           <a disabled class="btn green btn-xs"><i class="fa fa-cart-arrow-down"></i></a>
                                        <?php  } else  {  ?>
                                            <a href="<?php echo SITE_URL;?>oil/<?php echo cmm_encode($row['mtp_oil_id']); ?>" class="btn green btn-xs tooltips" data-container="body" data-placement="top" data-original-title="Generate PO" ><i class="fa fa-cart-arrow-down"></i></a>  
                                           <?php
                                             }
                                            if($row['status']==2 || $row['status']==3)
                                            { ?>
                                                 <a  class="btn red btn-xs" disabled><i class="fa fa-remove"></i></a> 
                                            <?php }
                                            else
                                            { ?>
                                                 <a href="<?php echo SITE_URL;?>reject/<?php echo cmm_encode($row['mtp_oil_id']); ?>" class="btn red btn-xs tooltips"  data-container="body" data-placement="top" data-original-title="Reject"><i class="fa fa-remove"></i></a> 
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
                    <?php } if($flag==3){ ?>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">MTP No</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="mtp_no" value="<?php echo @$tender_details['mtp_number'];?>">
                                        <b><?php echo  $tender_details['mtp_number'];?></b>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Loose Oil</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="loose_oil_name" value="<?php echo @$tender_details['loose_oil_name'];?>">
                                        <b><?php echo  $tender_details['loose_oil_name'];?></b>
                                    </div>
                            </div>
                        </div><br><br>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Ops</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="plant_name" value="<?php echo @$tender_details['plant_name'];?>">
                                        <b><?php echo  $tender_details['plant_name'];?></b>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Tender Date</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="tender_date" data-date-format="dd-mm-yyyy" value="<?php echo @$tender_details['tender_date'];?>">
                                        <b><?php echo  date('d-m-Y',strtotime($tender_details['tender_date']));?></b>
                                    </div>
                            </div>
                        </div><br><br>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Quantity(MT)</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="quantity_rate" value="<?php echo @$tender_details['quantity'];?>">

                                        <b><?php echo  $tender_details['quantity'];?></b>
                                    </div>
                            </div>
                        </div>
                    </div><br>
                    <form id="tenders_form" method="post" action="<?php echo SITE_URL.'insert_add_tender'?>" enctype="multipart/form-data" class="form-horizontal">
                         <input type="hidden" name="mtp_oil_id" value="<?php echo $tender_details['mtp_oil_id'];?>">
                        <div class="table-scrollable" id="tender">
                            <table class="table table-bordered table-striped table-hover" id="ocb">
                                <thead>
                                    <tr>
                                        <th width="20%"> Broker Name </th>
                                        <th width="20%"> Supplier Name </th>
                                        <th width="10%"> Quoted Rate</th>
                                        <th width="15%"> Negotiated Rate</th>
                                        <th width="10%"> Quantity(MT)</th>
                                        <th width="10%"> Supporting Document</th>
                                        <th width="15%"> Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php
                                    if(count($addtenders)>0)
                                    {
                                        foreach($addtenders as $row)
                                        {
                                    ?>
                                        <tr>
                                            <td> <?php echo $row['broker_name'];?> </td>
                                            <td> <?php echo $row['supplier_name'];?> </td>
                                            <td> <?php echo $row['quoted_price'];?> </td>
                                            <td> <?php echo $row['negotiated_price'];?>
                                            <td> <?php echo $row['quantity'];?>
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
                                            <td> <?php 
                                            if(@$row['status']!=5)
                                            { ?>
                                                <a class="btn btn-default btn-xs" href="<?php echo SITE_URL;?>edit_tender/<?php echo cmm_encode($row['tender_oil_id']); ?>"><i class="fa fa-pencil"></i></a> 
                                                <?php if(@$row['status'] == 1)
                                                {
                                                    ?>
                                                    <a class="btn btn-danger btn-xs" title="De-Activate" href="<?php echo SITE_URL;?>deactivate_tender/<?php echo cmm_encode($row['tender_oil_id']) ?>/<?php echo $mtp_oil_id; ?>" onclick="return confirm('Are you sure you want to Deactivate?')"><i class="fa fa-trash-o"></i></a>
                                                    <?php
                                                }
                                                else if(@$row['status'] == 2)
                                                {
                                                    ?>
                                                    <a class="btn btn-info btn-xs" title="Activate" href="<?php echo SITE_URL;?>activate_tender/<?php echo cmm_encode($row['tender_oil_id']); ?>/<?php echo $mtp_oil_id; ?>" onclick="return confirm('Are you sure you want to Activate?')"><i class="fa fa-check"></i></a>
                                                    <?php
                                                } 
                                            }
                                            else
                                            {
                                                echo "P.O. Generated";
                                            }

                                                ?>
                                            </td>

                                        </tr>
                                        <?php
                                        } 
                                    } ?>
                                    <tr class="srow">
                                        <td>
                                            <select  class="form-control select2"  name="broker_name[1]" >
                                                <option selected value="">-Select Broker-</option>
                                                    <?php 
                                                     foreach($broker as $bro)
                                                        {
                                                            echo '<option value="'.$bro['broker_id'].'">'.$bro['broker_code'].'('.$bro['agency_name'].')</option>';
                                                        }
                                                    ?> 
                                            </select> 
                                        </td>
                                        <td>
                                            <select  class="form-control select2"  name="supplier_name[1]" >
                                                <option selected value="">-Select Supplier-</option>
                                                    <?php 
                                                        foreach($supplier as $supp)
                                                        {
                                                            echo '<option value="'.$supp['supplier_id'].'">'.$supp['supplier_code'].'('.$supp['agency_name'].')</option>';
                                                        }
                                                    ?> 
                                            </select> 
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
                                            <input class="form-control numeric" name="quantity[1]" type="text"> 
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
                                    <a href="<?php echo SITE_URL.'tender_process_details';?>" class="btn default">Cancel</a>
                                </div>
                            </div>                                 
                        </div>
                    </form>
                    <?php } else if($flag==4) { ?>
                        <form id="tenders_form" method="post" action="<?php echo SITE_URL.'update_tender'?>" enctype="multipart/form-data" class="form-horizontal">
                            <input type="hidden" name="tender_oil_id" value="<?php echo $add_tenders['tender_oil_id'];?>">
                            <input type="hidden" name="mtp_oil_id" value="<?php echo $add_tenders['mtp_oil_id'];?>">
                       
                        <div class="alert alert-danger display-hide" style="display: none;">
                           <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                        </div>
                        <div class="form-group">
                            
                                <label class="col-md-4 control-label">Broker<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-3">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <select  class="form-control select2"  name="broker_name" >
                                                <option selected value="">-Select Broker-</option>
                                                    <?php 
                                                        foreach($broker as $bro)
                                                        {
                                                            $selected = '';
                                                            if($bro['broker_id'] ==@$add_tenders['broker_id'] ) $selected = 'selected';
                                                            echo '<option value="'.$bro['broker_id'].'" '.$selected.'>'.$bro['agency_name'].'</option>';
                                                        }
                                                    ?> 
                                            </select> 
                                        </div>
                                    </div>
                                
                            </div>
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
                                                                if($supp['supplier_id'] ==@$add_tenders['supplier_id'] ) $selected = 'selected';
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
                                        <input type="number" class="form-control quoted_rate" name="quoted_rate" value="<?php echo @$add_tenders['quoted_price']; ?>" type="text"> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Negotiated Rate<span class="font-red required_fld">*</span></label>
                                <div class="col-md-3">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input class="form-control numeric negotiated_rate" name="negotiated_rate" value="<?php echo @$add_tenders['negotiated_price']; ?>" type="text"> 
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Quantity(MT)<span class="font-red required_fld">*</span></label>
                                <div class="col-md-3">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input type="text" class="form-control" name="quantity" value="<?php echo @$add_tenders['quantity']; ?>" type="number"> 
                                    </div>
                                </div>
                            </div>
                            <?php if($add_tenders['support_document']!='') { ?>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Old Support Document</label>
                                <div class="col-md-3">
                                    <a href="<?php echo get_tender_upload_url().$add_tenders['support_document'];?>" class="btn blue btn-xs" download><i class="fa fa-cloud-download"></i></a> <p class="form-control-static"> <?php echo $add_tenders['support_document'];?></p>
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
                                    <a class="btn default" href="<?php echo SITE_URL;?>tender_process_details"><i class="fa fa-times"></i> Cancel</a>
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

<?php $this->load->view('commons/main_footer', $nestedView); ?>
<script>
$(document).on('keyup','.negotiated_rate,.quoted_rate',function(){ 
  var ele_panel_body=$(this).closest('.srow');
  var quoted_rate=ele_panel_body.find('.quoted_rate').val();
  var negotiated_rate=ele_panel_body.find('.negotiated_rate').val();
  //alert (quoted_rate);
  if(parseInt(quoted_rate)<parseInt(negotiated_rate))
  {
    ele_panel_body.find('.quoted_rate').css("border-color","red");
    ele_panel_body.find('.negotiated_rate').css("border-color","red");
    ele_panel_body.find('.err_negotiated_rate').html('Negotiated Rate must be smaller than Quoted rate');
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
</script>
