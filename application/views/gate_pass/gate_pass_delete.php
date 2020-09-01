<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                <?php if($flag==1)
                {
                ?>  <form method="post" action="<?php echo SITE_URL.'gate_pass_delete_details';?>" class="form-horizontal">
                        <div class="row"> 
                            <div class="col-md-offset-3 col-md-6 jumbotron">                       
                                <div class="col-md-12">
                                    <div class="form-group">
                                      <label class="col-md-5 control-label">Gate Pass Number <span class="font-red required_fld">*</span></label>
                                      <div class="col-md-6">
                                          <div class="input-icon right">
                                              <i class="fa"></i>
                                              <input class="form-control " type="text" name="gate_pass_number" placeholder="Gate Pass Number" required>  
                                          </div>
                                      </div>
                                     </div>  
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <button type="submit" class="btn blue" name="bridge">Submit</button>
                                            <a href="<?php echo SITE_URL.'gate_pass_delete';?>" class="btn default">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </form> 
                <?php 
                }
                else if($flag==2)
                {?>
                    <form method="post" action="<?php echo SITE_URL.'delete_gp_delete'?>" class="form-horizontal">
                    <input type="hidden" name="tanker_id" value="<?php echo $gate_pass['tanker_id'];?>">
                    <div class="col-md-offset-1 col-md-10">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                <label class="col-md-5 control-label">Gate Pass Number:</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo $gate_pass['gatepass_number']; ?></b></p>
                                         <input type="hidden" name="gatepass_number" value="<?php echo $gate_pass['gatepass_number'] ?>" >
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Date:</label>
                                    <div class="col-md-7">
                                       <p class="form-control-static"><b><?php echo date('d-m-Y',strtotime($gate_pass['on_date'])); ?></b></p>
                                        <input type="hidden" name="on_date" value="<?php echo $gate_pass['on_date'] ?>" >
                                        <input type="hidden" name="tanker_id" value="<?php echo $gate_pass['tanker_id'] ?>" >
                                        <input type="hidden" name="gatepass_id" value="<?php echo $gate_pass['gatepass_id'] ?>" >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                           <!--  <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Invoice Date:</label>
                                    <div class="col-md-7">
                                       <p class="form-control-static"><b><?php echo date('d-m-Y',strtotime($gate_pass[0]['invoice_date'])); ?></b></p>
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Vehicle Number:</label>
                                    <div class="col-md-7">
                                       <p class="form-control-static"><b><?php echo $gate_pass['vehicle_number']; ?></b></p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">Remarks:</label>
                                <div class="col-md-3">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <textarea class="form-control" name="remarks" placeholder="remarks"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                <label class="col-md-5 control-label">Invoice Number:</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo $invoice_nos; ?></b></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                <label class="col-md-5 control-label">Way Bill Number:</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo $wb_nos; ?></b></p>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                     <!--    <div class="row">
                         <div class="form-group">
                                <label class="col-md-2 control-label">Remarks:</label>
                                <div class="col-md-3">
                                    <div class="input-icon right">
                                        <i class="fa"></i>
                                        <textarea class="form-control" name="remarks" placeholder="remarks"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div> 
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th> S.No </th>
                                <th> Way Bill Number </th>
                                <th> Invoice Number </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if(count($gate_pass_invoice)>0)
                            {   $sno=1;
                                foreach($gate_pass_invoice as $row)
                                { ?>
                                <input type="hidden" name="invoice_no[]" value="<?php echo $row['invoice_number']; ?>" >
                                <input type="hidden" name="waybill_no[]" value="<?php echo $row['waybill_number'] ; ?>">
                                <tr>
                                    <td> <?php echo $sno++;?> </td>
                                    <td> <?php echo $row['waybill_number'];?> </td>
                                    <td> <?php echo $row['invoice_number'];?> </td>
                                </tr>
                                <?php
                                }
                            } 
                            else 
                            {
                            ?>  
                                <tr><td colspan="3" align="center"><span class="label label-primary">No Records</span></td></tr>
                            <?php   
                            } ?>
                        </tbody>
                    </table>
                   <!--  <?php foreach($gate_pass as $key =>$value)
                    { ?>
                        <input type="hidden" name="invoice_no[]" value="<?php echo $value['invoice_no']; ?>" >
                        <input type="hidden" name="waybill_no[]" value="<?php echo $value['wb_no'] ; ?>">
                    <?php  }   ?>  -->                   
                        <div>
                            <div class="row">
                                <div class="col-md-offset-5 col-md-4">
                                     <input type="submit" class="btn blue tooltips" name="submit" value="delete">
                                     <a href="<?php echo SITE_URL.'gate_pass_delete';?>" class="btn default">Cancel</a>
                               </div>
                            </div>
                       </div>
                    </form>
                <?php }?>
                </div>
            </div>
        </div>
    </div>
</div>