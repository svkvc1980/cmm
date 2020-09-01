<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">  
                <div class="portlet-body">
                    <form id="c_and_f_form" method="post" action="<?php SITE_URL;?>insert_c_and_f" class="form-horizontal">
                        <div class="row">           
                                <div class="form-group">
                                   <label class="col-md-4 control-label">C&F Unit :</label>
                                    <div class="col-md-5">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                        <select name="plant" class="form-control">
                                            <option value="">-Select C&F Unit-</option>
                                             <?php foreach($plantlist as $plant){
                                                $selected ='';
                                                if($plant['plant_id']==@$search_data['plant_id'])$selected ='selected';
                                                echo'<option value="'.$plant['plant_id'].'">'.$plant['name'].'</option>';
                                                }?>
                                        </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">  
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Bank :</label>
                                    <div class="col-md-5">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                           <?php echo form_dropdown('bank', $bank, @$search_data['bank_id'],'class="form-control" ');?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">           
                                <div class="form-group">
                                   <label class="col-md-4 control-label">DD Type :</label>
                                    <div class="col-md-5">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                         <?php echo form_dropdown('payment_mode', $payment_mode, @$search_data['pay_mode_id'],'class="form-control" ');?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">  
                                <div class="form-group">
                                    <label class="col-md-4 control-label">DD Number :</label>
                                    <div class="col-md-5">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" class="form-control" placeholder="DD Number" name="dd_number" value="" maxlength="15" id="dd_num">
                                            <p id="ddnumberValidating" class="hidden"><i class="fa fa-spinner fa-spin"></i> Checking...</p>
                                             <p id="ddnumberError" class="error hidden"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">           
                                <div class="form-group">
                                   <label class="col-md-4 control-label">DD Amount :</label>
                                    <div class="col-md-5">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                             <input type="text" class="form-control numeric" onkeyup="javascript:this.value=Comma(this.value);"  placeholder="DD Amount" name="amount" value="" maxlength="15">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">  
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Payment Date:</label>
                                    <div class="col-md-5">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="Payment Date" type="text" name="payment_date" />
                                        </div>
                                    </div>
                                </div>
                            </div>                     
                        <div class="form-group">
                            <div class="col-sm-offset-5 col-sm-4">
                                <button class="btn blue" type="submit" name="submit" onclick="return confirm('Are you sure you want to Submit?')"><i class="fa fa-check"></i> Submit</button>
                                <a class="btn default" href="<?php echo SITE_URL;?>c_and_f"><i class="fa fa-times"></i> Cancel</a>
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