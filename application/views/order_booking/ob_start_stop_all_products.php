<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                
                <div class="portlet-body">
                     
                        <form id="ob_form" method="post" action="<?php echo $form_action;?>" class="form-horizontal">
                            
                                    <div class="form-group"  style="text-align:center;">                                        
                                            <div class="col-md-offset-4 col-md-4">
                                                    
                                                    <p class="form-control-static" style="text-align: center;"> At present All Product Order bookings are : <b><?php echo ($ob_status==1)?"ON":"OFF";?></b></p>
                                                
                                            </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-6 well">                 
                                            <div class="form-group">
                                                <label class="col-sm-5 control-label">Order Booking Status</label>
                                                    <div class="col-sm-5">
                                                        <div class="input-icon right">
                                                            
                                                           <select name="status" class="form-control type_id" required="required">
                                                                <option value="">-Select Status-</option>
                                                                <option value="1">Start</option>
                                                                <option value="2">Stop</option>       
                                                           </select>
                                                        </div>
                                                    </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-md-offset-5 col-md-7">
                                                    <button class="btn blue" type="submit" name="submit" value="1"><i class="fa fa-check"></i> Submit</button>
                                                    <a class="btn default" href="<?php echo SITE_URL;?>ob_booking_for_all_products"><i class="fa fa-times"></i> Cancel</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        </form>

                  </div>
            </div>
        </div>
    </div>
</div>  
<?php $this->load->view('commons/main_footer', $nestedView); ?>
