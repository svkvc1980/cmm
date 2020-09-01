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
                    <form id="counter_to_godown" method="post" action="<?php echo $form_action;?>"  autocomplete="on" class="form-horizontal weigh_bridge_form">
                        <p align="right" style="color:#3A8ED6;"><b>
                            <span class="timer_block">
                            <i class="fa fa-clock-o"></i>
                            <span id="timer"></span>
                            </span></b></p>
                            <div class="row" id="godown">
                                <div class="col-md-12 stock_row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label class="col-md-5 control-label">Products <span class="font-red required_fld">*</span></label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <select name="product[]" class="form-control product"> 
                                                        <option value="">-Select Product-</option>
                                                        <?php 
                                                            foreach($product as $pp)
                                                            {
                                                                echo '<option value="'.$pp['product_id'].'">'.$pp['product_name'].''.$pp['capacity_name'].''.$pp['unit_name'].'</option>';
                                                            }
                                                        ?>
                                                   </select> 
                                                </div>
                                            </div>
                                       </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                        <label class="col-md-6 control-label">Available Qty</label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input type="text" style="color: #217EBD; font-weight: bold;" name="avail_qty[]" readonly="readonly" class="form-control stock">
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                        <label class="col-md-6 control-label">Transfer Qty <span class="font-red required_fld">*</span></label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input type="text" name="trans_qty[]" maxlength="6" class="form-control numeric trans_qty" placeholder="Qty">
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn blue btn-sm" id="add" value="ADD"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                        <label class="col-md-5 control-label">Remarks </label>
                                            <div class="col-md-7">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <textarea type="text" name="remarks" placeholder="Remarks..." class="col-md-6 form-control"></textarea>  
                                                </div>  
                                            </div>
                                       </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-5 col-md-4">
                                        <input type="submit" value="submit" class="btn blue submit tooltips" data-container="body" data-placement="top" data-original-title="Submit" name="bridge">
                                        <a type="sumbit" href="<?php echo SITE_URL.'countersale_to_godown';?>" value="CANCEl" class="btn default tooltips" data-container="body" data-placement="top" data-original-title="Cancel">cancel</a>
                                    </div>
                                </div>
                            </div>
                        </form> 
                        <?php
                        }
                        if(@$flag==2){?>
                        <form id="" method="post" action="<?php echo SITE_URL.'insert_countersale_to_godown';?>" autocomplete="on" class="form-horizontal">
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th> Product Name </th>
                                        <th> Transfered Qty </th>          
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sn=1; 
                                    foreach($product_qty as $row)
                                    {
                                        ?>
                                        <tr>
                                            <input type="hidden" name="products[]" value="<?php echo $row['product_id'];?>">
                                            <input type="hidden" name="qty[]" value="<?php echo $row['qty'];?>">
                                            <input type="hidden" name="remarks" value="<?php echo $row['remarks'];?>">
                                            <td><?php echo @$sn++;?></td>
                                            <td><?php echo @$row['product_name'];?></td>
                                            <td><?php echo @$row['qty'];?></td>
                                        </tr> 
                                        <?php
                                    }?>
                                    
                                </tbody>
                            </table>
                        </div>
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-5 col-md-4">
                                    <button type="Process" value="Process" class="btn blue" name="bridge">Process</button>
                                    <a href="<?php echo SITE_URL.'countersale_to_godown';?>" class="btn default">Back</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php }?>
                </div>
            </div>
        </div>
             <!-- END BORDERED TABLE PORTLET-->
    </div>            
</div>
    <!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>