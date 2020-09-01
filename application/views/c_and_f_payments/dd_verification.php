 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                
                <div class="portlet-body">
                    <?php
                    if(isset($flg))
                    {
                        ?>
                            <form id="dd_verification_form" method="post" action="<?php echo $form_action;?>"  autocomplete="on" class="form-horizontal">
                                <?php
                                if($flg==2){
                                    ?>
                                    <input type="hidden" name="encoded_id" value="<?php echo cmm_encode($c_and_f_payment_row['payment_id']);?>">
                                    <input type="hidden" name="outstanding_amount" value="<?php echo @$outstanding_amount?>">
                                    <?php
                                }
                                ?>
                                 <input type="hidden" name="en" value="<?php echo @$c_and_f_payment_row['payment_id'] ?>">
                                  <div class="row">                                    
                                    <div class="col-md-6">
                                      <div class="form-group">
                                      <label class="col-md-7 control-label">Payment Mode :</label>
                                        <div class="col-md-5">
                                          <div class="input-icon right">
                                            <i class="fa"></i>
                                            <?php echo form_dropdown('pay_mode',$pay_mode,@$pay_mode_id['pay_mode_id'],'class="form-control"');?>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Bank :</label>
                                            <div class="col-md-5">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                   <?php echo form_dropdown('bank',$bank,@$bank_id['bank_id'],'class="form-control"');?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">                                    
                                    <div class="col-md-6">
                                      <div class="form-group">
                                      <label class="col-md-7 control-label">Unit :</label>
                                        <div class="col-md-5">
                                          <div class="input-icon right">
                                            <i class="fa"></i>
                                            <select name="plant_id" class="form-control">
                                                <option value="">-Select C&F Unit-</option>
                                                 <?php foreach($plant as $plant){
                                                    $selected ='';
                                                    if($plant['plant_id']==@$plant_id['plant_id'])$selected ='selected';
                                                    echo'<option value="'.$plant['plant_id'].'"'.$selected.'>'.$plant['name'].'</option>';
                                                    }?>
                                           </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">DD Number :</label>
                                            <div class="col-md-5">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                   <input class="form-control" type="text" name="dd_number" value="<?php echo @$c_and_f_payment_row['dd_number'];?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">                                    
                                    <div class="col-md-6">
                                      <div class="form-group">
                                      <label class="col-md-7 control-label">Payment Date :</label>
                                        <div class="col-md-5">
                                          <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control date-picker" value="<?php if($c_and_f_payment_row['payment_date']!=''){echo date('d-m-Y',strtotime(@$c_and_f_payment_row['payment_date']));}?>" placeholder="Date" name="payment_date" data-date-format="dd-mm-yyyy" type="text" >
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Amount :</label>
                                            <div class="col-md-5">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input type="hidden" name="amount" value="<?php echo @$c_and_f_payment_row['amount'];?>">
                                                    <p class="form-control-static"><b><?php echo @$c_and_f_payment_row['amount'];?></b>
                                                  </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-7 control-label">Outstanding Amount :</label>
                                            <div class="col-md-5">
                                                    <input type="hidden" name="outstanding_amount" value="<?php echo @$outstanding_amount;?>">
                                                    <p class="form-control-static"><b><?php if(@$outstanding_amount!='') {echo @$outstanding_amount; } else { echo "<b>0.00</b>"; }?></b>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Remarks :</label>
                                            <div class="col-md-5">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <textarea class="form-control remarks_req" cols="2" name="remarks2"></textarea>
                                                    <p id="remarksError" class="error hidden"></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                  
                               <div class="form-actions">
                                    <div class="row" style="text-align: center;">
                                        <div class="col-md-offset-3 col-md-6">
                                            <button type="submit" value="1" name ="submit" onclick="return confirm('Are you sure you want to Approve?')" class="btn btn-primary">Approval</button>
                                            <button type="submit"  value="2" name ="submit" onclick="return confirm('Are you sure you want to Reject?')" class="btn btn-danger remarks">Reject</button>
                                            <a href="<?php echo SITE_URL.'c_and_f_payments';?>" class="btn default">Cancel</a>
                                        </div>
                                    </div>  
                                </div>
                            </form>
                        <?php
                    }
                    if(isset($display_results)&&$display_results==1)
                    {
                    ?>
                        <form method="post" action="<?php echo SITE_URL.'c_and_f_payments'?>">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <select name="plant" class="form-control">
                                        <option value="">-Select C&F Unit-</option>
                                         <?php foreach($plant as $plant){
                                            $selected ='';
                                            if($plant['plant_id']==@$search_data['plant_id'])$selected ='selected';
                                            echo'<option value="'.$plant['plant_id'].'"'.$selected.'>'.$plant['name'].'</option>';
                                            }?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <?php echo form_dropdown('pay_mode',$pay_mode,@$search_data['pay_mode_id'],'class="form-control"');?>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <?php echo form_dropdown('bank',$bank,@$search_data['bank_id'],'class="form-control select2"');?>
                                    </div>
                                </div>   
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input class="form-control" name="dd_number" value="<?php echo @$search_data['dd_number'];?>" placeholder="DD Number" type="text">
                                    </div>
                                </div>
                                                                
                               <div class="col-sm-2">
                                    <div class="form-actions">
                                        <button type="submit" name="search_c_and_f_payments" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                        <button name="reset" value="" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="reset"><i class="fa fa-refresh"></i></button>
                                        <button type="submit" name="download_c_and_f_payments" value="1" formaction="<?php echo SITE_URL.'download_c_and_f_payments';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button>                 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                    <div class="input-group input-large date-picker input-daterange" data-date-format="dd-mm-yyyy">
                                           <input type="text" class="form-control" name="from_date" placeholder="From Date" value="<?php if($search_data['from_date']!='') { echo date('d-m-Y',strtotime($search_data['from_date'])); } ?>">
                                           <span class="input-group-addon"> to </span>
                                           <input type="text" class="form-control" name="to_date" placeholder="To Date" value="<?php if($search_data['to_date']!='') { echo date('d-m-Y',strtotime($search_data['to_date'])); } ?>"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <select name="status" class="form-control" >
                                            <option value="">Select Status</option>
                                            <option value="1" <?php if(@$search_data['status']==1){?>selected <?php } ?> >Pending</option>
                                            <option value="2" <?php if(@$search_data['status']==2){?>selected <?php } ?> >Approved</option>
                                            <option value="3" <?php if(@$search_data['status']==3){?>selected <?php } ?>>Rejected</option>
                                        </select>
                                    </div>
                                </div> 
                            </div>
                        </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No </th>
                                        <th> DD Number </th>
                                        <th> Date </th> 
                                        <th> Unit </th>
                                        <th> Bank </th>
                                        <th> Amount </th>
                                        <th> Status </th>
                                        <th> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($c_and_f_payment_results){
                                    foreach($c_and_f_payment_results as $row){
                                 ?>
                                    <tr>
                                        <td> <?php echo $sn++;?></td>
                                        <td> <?php echo $row['dd_number'];?> </td>
                                        <td> <?php echo date('d-m-Y',strtotime($row['payment_date']));?> </td>
                                        <td> <?php echo $row['plant_name'];?> </td>
                                        <td> <?php echo $row['bank_name'];?> </td>
                                        <td align="right"> <?php echo price_format($row['amount']);?> </td>             
                                        <td> <?php if($row['status']==1)
                                        {
                                            echo "Pending";
                                        }
                                        elseif($row['status']==2)
                                        {
                                            echo "Approved";
                                        }
                                        else
                                        {
                                            echo "Rejected";
                                        }
                                        ?> </td>  
                                        <?php if($row['status']==1){ ?>
                                        <td style="text-align: center;"><a class="btn btn-default btn-xs tooltips" href="<?php echo SITE_URL.'dd_verifications/'.cmm_encode($row['payment_id']);?>" data-container="body" data-placement="top" data-original-title="Verify"><i class="fa fa-pencil"></i></a>               
                                        </td><?php } ?>
                                        <?php if($row['status']==2){ ?>
                                        <td><p style="color: green;text-align: center;"><b><i class="fa fa-check fa-lg"></i></b></p>         
                                        </td><?php } ?>
                                        <?php if($row['status']==3){ ?>
                                        <td><p style="color: red;text-align: center;"><b><i class="fa fa-times fa-lg"></i></b></p>        
                                        </td><?php } ?>                                     
                                    </tr>
                                <?php
                                    }
                                }
                                else
                                {
                            ?>      <tr><td colspan="9" align="center"> No Records Found</td></tr>      
                        <?php   }
                                ?>
                                </tbody>
                            </table>
                        </div>
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
                    <?php
                    }
                    ?>
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>
<script type="text/javascript">
    $('.remarks').click(function(){
        var remarks=$(this).val();
        var remarks_val=$('.remarks_req').val();
        if(remarks==2)
        {
            if(remarks_val!='')
            {

            }
            else
            {
                $('.remarks_req').prev('i').removeClass('fa-check').addClass('fa-warning');
                $('.remarks_req').closest('div.form-group').removeClass('has-success').addClass('has-error');
                $('#remarksError').html('Please Fill Remarks');
                $("#remarksError").removeClass("hidden");
                return false;
            }     

        }
        else
        {

        }
        
    });
    $('.remarks_req').change(function(){
        var remarks_val=$(this).val();
        if(remarks_val!='')
        {
            $('.remarks_req').prev('i').removeClass('fa-warning').addClass('fa-check');
            $('.remarks_req').closest('div.form-group').removeClass('has-error').addClass('has-success');
            $('#remarksError').html('');
            $("#remarksError").addClass("hidden");
        }
    });
    // Function to prevent form submit on press of Enter button
    $('#dd_verification_form input').keypress(function(e) {
            if (e.which == 13) {
                //alert('inside');
                return false;
            }
        });
</script>