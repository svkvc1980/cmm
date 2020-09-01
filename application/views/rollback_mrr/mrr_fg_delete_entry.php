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
                    {
                      ?>
                      <form id="mrr_fg_date_form" method="post" action="<?php echo SITE_URL.'mrr_fg_delete_entry_details';?>"  class="form-horizontal">
                        <div class="row ">  
                            <div class="col-md-offset-3 col-md-5"> 
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Enter MRR Number</label>
                                    <div class="col-md-7">
                                        <input type="text" name="mrr_no" required class="form-control numeric"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-5"></div>
                                        <div class="col-md-6">
                                            <input type="submit" class="btn blue tooltips"  value="Proceed" name="submit">
                                            <a href="<?php echo SITE_URL.'mrr_fg_delete_entry';?>" class="btn default">Cancel</a>
                                        </div>                                 
                                </div>
                            </div>
                        </div>
                    </form><?php  
                    } 
                    if($flag==2)
                    { ?>
                        <form id="mrr_fg_date_form" method="post" action="<?php echo SITE_URL.'update_mrr_fg_delete_details';?>" class="form-horizontal">
                        <input type="hidden" name="mrr_fg_id" value="<?php echo $mrr_fg_list['mrr_fg_id'] ; ?>">
                            <div class="padding">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">MRR Number :</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo $mrr_fg_list['mrr_number'] ;?></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Existing MRR Date :</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo  date('d-m-Y', strtotime($mrr_fg_list['mrr_date']));?></b>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="row">   
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">PO Number :</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo  $mrr_fg_list['po_number'];?></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Invoice Number :</label>
                                        <div class="col-md-6">
                                             <b class="form-control-static"><?php echo  $mrr_fg_list['invoice_number'];?></b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">   
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Supplier :</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo  $mrr_fg_list['supplier_name'].'['.$mrr_fg_list['supplier_code'].']';?></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Vehicle No :</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo  $mrr_fg_list['vehicle_number'];?></b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">   
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Ledger No :</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo  $mrr_fg_list['ledger_number'];?></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Folio Number :</label>
                                        <div class="col-md-6">
                                             <b class="form-control-static"><?php echo  $mrr_fg_list['folio_number'];?></b>
                                        </div>
                                    </div>
                                </div>
                            </div><br>
                           
                            <div class="row ">
                               <div class=" col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Remarks :<span class="font-red required_fld">*</span></label>
                                        <div class="col-md-6">
                                            <textarea class="form-control" name="remarks" required ></textarea> 
                                        </div>
                                    </div>    
                                </div>  
                            </div>
                            </div><br>
                            <div class="table">
                                <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No </th>
                                        <th> Product</th>
                                        <th> Quoted Qty </th>
                                        <th> Received Qty</th>
                                        <th> Pending/Excess Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i=1;
                                     ?>
                                       <tr>
                                            <td width="10%"> <?php echo $i++;?> </td>
                                            <td width="15%"> <?php echo $mrr_fg_list['fg_name'];?> </td>
                                            <td width="15%"> <?php echo $mrr_fg_list['quantity'];?> </td>
                                            <td width="15%"> <?php echo $received_qty;?> </td>
                                            <td  width="15%">
                                                <?php if($mrr_fg_list['quantity']>$received_qty)
                                                    { 
                                                        echo '-'.($mrr_fg_list['quantity']-$received_qty);
                                                    }
                                                    else
                                                    {
                                                        echo '+'.($received_qty-$mrr_fg_list['quantity']);
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-offset-5 col-md-6">
                                    <button type="submit" class="btn blue"  name="submit">Change Date</button>
                                    <a href="<?php echo SITE_URL.'mrr_fg_delete_entry';?>" class="btn default">Cancel</a>
                                </div>
                            </div>
                        </form>
                    <?php
                    }?>
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>                