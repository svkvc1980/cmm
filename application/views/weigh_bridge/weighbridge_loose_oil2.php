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
                    <form id="" method="post" action="<?php echo $form_action;?>"  autocomplete="on" class="form-horizontal weighbridge_form">
                        <div class="row"> 
                            <div class="col-md-offset-3 col-md-6 jumbotron">                       
                                <div class="col-md-12">
                                    <div class="form-group">
                                      <label class="col-md-5 control-label">Tanker Register No <span class="font-red required_fld">*</span></label>
                                      <div class="col-md-6">
                                          <div class="input-icon right">
                                              <i class="fa"></i>
                                              <input class="form-control numeric" type="text" name="tanker_id" maxlength="20" required>  
                                          </div>
                                      </div>
                                     </div>  
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-4 col-md-8">
                                            <button type="submit" class="btn blue" name="bridge">Submit</button>
                                            <a href="<?php echo SITE_URL.'weighbridge';?>" class="btn default">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>  
                    </form> 

                    <?php
                    }
                    else if($flag==2)
                    {
                      if($tanker_row['status']==1)
                      {
                        ?>
                    <form id="" method="post" action="<?php echo $form_action;?>" class="form-horizontal">
                    <div class="row">
                        <div class="col-md-offset-1 col-md-10 well">
                        <div class="col-md-offset-9 col-md-3">
                                <p align="left" style="color:#3A8ED6;"><b>
                                <span class="timer_block" style="float:right;">
                                <i class="fa fa-clock-o"></i>
                                <span id="timer"></span>
                                </span></b></p>
                            </div>
                            <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                <label class="col-md-5 control-label">Tanker Type :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo $tanker_row['tanker_type'] ;?></b></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Tanker In No :</label>
                                    <div class="col-md-7">
                                       <p class="form-control-static"><b><?php echo $tanker_row['tanker_in_number'] ;?></b></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Vehicle No :</label>
                                    <div class="col-md-7"> 
                                        <p class="form-control-static"><b><?php echo $tanker_row['vehicle_number'] ;?></b></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Intime :</label>
                                    <div class="col-md-7">
                                       <p class="form-control-static"><b><?php echo date('d-m-Y H:i:s A',strtotime($tanker_row['in_time']));?></b></p>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label class="col-md-5 control-label">Oil Type :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo $tanker_row['oil_name'] ;?></b></p>                                     
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">DC No. :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo $tanker_row['dc_number'] ;?></b></p> 
                                    </div>
                                </div>
                            </div>
                        </div>
                         
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                <label class="col-md-5 control-label">Invoice No. :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo $tanker_row['invoice_number'] ;?></b></p>                                      
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                <label class="col-md-5 control-label">Invoice Quantity :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo $tanker_row['invoice_qty'] ;?></b></p>    
                                    </div>
                                </div>
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Invoice Gross :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo $tanker_row['invoice_gross'] ;?></b></p> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Invoice Tare :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo $tanker_row['invoice_tier'] ;?></b></p> 
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Party Name <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo $tanker_row['party_name'] ;?></b></p> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Broker Name <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo $tanker_row['broker_name'] ;?></b></p> 
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                <label class="col-md-5 control-label">Gross Weight <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7">
                                        <input type="text" readonly class="form-control numeric gross_weight" placeholder="Gross Weight" name="gross" maxlength="20" required>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix">
                                <a class="btn btn-sm blue get_weight"><i class="fa fa-file-o"></i> Get weight</a>
                                <p id="usernameValidating" class="hidden"><i class="fa fa-spinner fa-spin"></i> Checking...</p>
                            </div>
                        </div> 
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-5 col-md-4">
                                    <button type="submit" class="btn blue">Submit</button>
                                    <a href="<?php echo SITE_URL.'weighbridge';?>" class="btn default">Cancel</a>
                                </div>
                            </div>
                        </div>   
                        
                            
                        </div>
                            
                    </div>
                    </form> <?php
                      }
                      
                    }
                    else if($flag==3)
                    {
                      if($tanker_row['status']==3)
                      {
                        ?>
                        <form method="post" action="<?php echo $form_action;?>"  autocomplete="on" class="form-horizontal">
                        <div class="row">
                        <div class="col-md-offset-1 col-md-10 well">
                            <div class="col-md-offset-9 col-md-3">
                                <p align="left" style="color:#3A8ED6;"><b>
                                <span class="timer_block" style="float:right;">
                                <i class="fa fa-clock-o"></i>
                                <span id="timer"></span>
                                </span></b></p>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                    <label class="col-md-5 control-label">Tanker Type :</label>
                                        <div class="col-md-7">
                                            <p class="form-control-static"><b><?php echo $tanker_row['tanker_type'] ;?></b></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Tanker In No :</label>
                                        <div class="col-md-7">
                                           <p class="form-control-static"><b><?php echo $tanker_row['tanker_in_number'] ;?></b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Vehicle No :</label>
                                        <div class="col-md-7"> 
                                            <p class="form-control-static"><b><?php echo $tanker_row['vehicle_number'] ;?></b></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Intime :</label>
                                        <div class="col-md-7">
                                           <p class="form-control-static"><b><?php echo date('d-m-Y H:i:s A',strtotime($tanker_row['in_time']));?></b></p>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Oil Type :</label>
                                        <div class="col-md-7">
                                            <p class="form-control-static"><b><?php echo $tanker_row['oil_name'] ;?></b></p>                                     
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">DC No. :</label>
                                        <div class="col-md-7">
                                            <p class="form-control-static"><b><?php echo $tanker_row['dc_number'] ;?></b></p> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                         
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Invoice No. :</label>
                                        <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo $tanker_row['invoice_number'] ;?></b></p>                                      
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Invoice Quantity :</label>
                                        <div class="col-md-7">
                                            <p class="form-control-static"><b><?php echo $tanker_row['invoice_qty'] ;?></b></p>    
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Invoice Gross :</label>
                                        <div class="col-md-7">
                                            <p class="form-control-static"><b><?php echo $tanker_row['invoice_gross'] ;?></b></p> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Invoice Tare :</label>
                                        <div class="col-md-7">
                                            <p class="form-control-static"><b><?php echo $tanker_row['invoice_tier'] ;?></b></p> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Party Name <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo $tanker_row['party_name'] ;?></b></p> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Broker Name <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo $tanker_row['broker_name'] ;?></b></p> 
                                    </div>
                                </div>
                            </div>
                        </div>  
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                    <label class="col-md-5 control-label">Gross Weight :</label>
                                        <div class="col-md-7">
                                            <p class="form-control-static"><b><?php echo $tanker_row['gross'] ;?></b></p> 
                                        </div>
                                        </div>
                                    </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                    <label class="col-md-5 control-label">Tare <span class="font-red required_fld">*</span></label>
                                        <div class="col-md-7">
                                            <div class="input-icon right">
                                                <i class="fa"></i>
                                                <input type="text" class="form-control numeric" placeholder="Tier Weight" name="tier" maxlength="20" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            </div> 
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-5 col-md-4">
                                    <button type="submit" class="btn blue">Submit</button>
                                    <a href="<?php echo SITE_URL.'weighbridge';?>" class="btn default">Cancel</a>
                                </div>
                            </div>
                        </div>   
                        
                            
                        </div>
                            
                    </div>
                        
                        </form>  <?php
                      }
                      
                    } 
                    else
                    { 
                        echo "No Records Found";
                    }?>
                 </div>
              </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
     </div>               
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>
<script>
 $(document).ready(function(){
    $('#usernameValidating').addClass("hidden");
    $('.get_weight').click(function(){
        $('#usernameValidating').removeClass("hidden");
       $.ajax({
          type: 'GET', 
          url: 'http://localhost/serialport/read.php',
          success: function(data) {
            $('#usernameValidating').addClass("hidden");
            alert(data);
            $('.gross_weight').val(data);
          }
    });
    });
 });

</script>