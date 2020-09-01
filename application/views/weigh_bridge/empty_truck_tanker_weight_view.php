<?php $this->load->view('commons/main_template', $nestedView); ?>
<?php
// Get weight capturing mode 1: Auto 2: Manual
$weight_capture_mode = get_preference('weight_capture_mode','weigh_bridge');
?>
<!-- BEGIN PAGE CONTENT INNER -->
<div id="loaderID" style="position:fixed; top:50%; left:50%; z-index:2; opacity:0"><img src="<?php echo assets_url();?>pages/img/ajax-loading-img.gif" /></div>
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
              <div class="portlet-body">
                    <?php
                    if($flag==2)
                    {
                      if($tanker_row['status']==1)
                      {
                        ?>
                    <form method="post" action="<?php echo $form_action;?>" class="form-horizontal weighbridge_form">
                    <input type="hidden" name="tanker_id" value="<?php echo $tanker_row['tanker_pp_delivery_id'];?>">
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
                                    <label class="col-md-5 control-label">Party Name <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo $tanker_row['party_name'] ;?></b></p> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                <label class="col-md-5 control-label">Invoice No. :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo $tanker_row['invoice_number'] ;?></b></p>                                      
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label class="col-md-5 control-label">Tare Weight (Kg) <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-4">
                                    <div class="input-icon right">
                                    <i class="fa"></i> 
                                        <input type="text" <?php if($weight_capture_mode==1) echo 'readonly';?> class="form-control numeric weight" placeholder="Tare Weight" name="tare" maxlength="20" required="required">
                                    </div>
                                    </div>
                                    <?php
                                    if($weight_capture_mode==1) // Auto
                                    {
                                    ?>
                                    <div class="col-md-3">
                                        <a class="btn btn-sm blue get_weight"><i class="fa fa-file-o"></i> Get weight</a>
                                        <p id="usernameValidating" class="hidden"><i class="fa fa-spinner fa-spin"></i> Checking...</p>
                                    </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="form-group">
                                <label class="col-md-5 control-label">Remarks </label>
                                    <div class="col-md-7">
                                        <textarea class="form-control" name="Remarks" cols="2"></textarea>
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
                    </form> <?php
                      }
                      
                    }
                    else if($flag==3)
                    {
                      if($tanker_row['status']==3 || $tanker_row['status']==2)
                      {
                        ?>
                        <form method="post" action="<?php echo $form_action;?>" class="form-horizontal">
                        <input type="hidden" name="tanker_id" value="<?php echo $tanker_row['tanker_pp_delivery_id'];?>">
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
                                        <label class="col-md-5 control-label">Party Name <span class="font-red required_fld">*</span></label>
                                        <div class="col-md-7">
                                            <p class="form-control-static"><b><?php echo $tanker_row['party_name'] ;?></b></p> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Invoice No. :</label>
                                        <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo $tanker_row['invoice_number'] ;?></b></p>                                      
                                        </div>
                                    </div>
                                </div>
                            </div>
                              
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                    <label class="col-md-5 control-label">Tare Weight (Kg) :</label>
                                        <div class="col-md-7">
                                            <p class="form-control-static"><b><?php echo $tanker_row['tier'] ;?></b></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Gross Weight (Kg) :<span class="font-red required_fld">*</span></label>
                                        <div class="col-md-4">
                                            <input type="text"  <?php if($weight_capture_mode==1) echo 'readonly';?> class="form-control numeric weight" id="gross_weight" placeholder="Gross Weight" name="gross" maxlength="20" required="required">
                                        </div>
                                        <?php
                                        if($weight_capture_mode==1) // Auto
                                        {
                                        ?>
                                        <div class="col-md-4">
                                            <a class="btn btn-sm blue get_weight"><i class="fa fa-file-o"></i> Get weight</a>
                                            <p id="usernameValidating" class="hidden"><i class="fa fa-spinner fa-spin"></i> Checking...</p>
                                        </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <input type="hidden" name="tare_weight" id="tare_weight" value="<?php echo $tanker_row['tier'];?>">
                                    <div class="form-group">
                                    <label class="col-md-5 control-label">Net Weight (Kg) :</label>
                                        <div class="col-md-7">
                                            <p class="form-control-static"><b id="net_weight_disp">-</b></p> 
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                    <label class="col-md-5 control-label">Remarks </label>
                                        <div class="col-md-7">
                                            <textarea class="form-control" name="Remarks" cols="2"></textarea>
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
    <?php
    if($weight_capture_mode==1)
    {
    ?>
        $('.get_weight').click(function(){
            //$('#loader').removeClass("hidden");
            $(".page-content-inner").css("opacity",0.5);
            $("#loaderID").css("opacity",1);
            var weight_url = '<?php echo get_preference("kkd_weight_path","weigh_bridge");?>';
           $.ajax({
              type: 'GET', 
              url: weight_url,
              success: function(data) {
                //$('#loader').addClass("hidden");
                $(".page-content-inner").css("opacity",1);
                $("#loaderID").css("opacity",0);
                if(confirm('Confirm weight reading \n \t\t '+data))
                {
                    $('.weight').val(data);
                    calculate_netWeight();
                }
                
              }
            });
        });
    <?php
    }
    ?>
    $('#gross_weight').blur(function(){
        calculate_netWeight();
    });

    function calculate_netWeight()
    {
        var gross_weight = parse_int($('#gross_weight').val());
        var tare_weight = parse_int($('#tare_weight').val());
        

        var net_weight = gross_weight - tare_weight;
        $('#net_weight_disp').html(net_weight);

        /*var invoice_net = parse_int($('#invoice_net').val());
        var inv_diff = net_weight - invoice_net;
        var inv_diff_str = '';
        if(inv_diff>=0)
            inv_diff_str = '(+) ';
        else
            inv_diff_str = '(-) ';
        inv_diff_str += Math.abs(inv_diff);
        //alert(gross_weight+'--'+tare_weight+'--'+net_weight+'--'+inv_diff+'--'+inv_diff_str);
        
        $('#inv_diff_disp').html(inv_diff_str);*/
    }

    function parse_int(val)
    {
        if(val!='')
            val = parseInt(val);
        else
            val=0;
        return val;
    }
 });

</script>