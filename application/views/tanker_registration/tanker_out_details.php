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
                ?>  <form method="post" action="<?php echo SITE_URL.'tanker_out_details';?>" class="form-horizontal">
                        <div class="row">                        
                            <div class="col-md-offset-3 col-md-6 jumbotron">
                                <div class="form-group">
                                    <label class="col-xs-5 control-label">Vehicle In Number</label>
                                    <div class="col-xs-6">
                                        <input type="text" name="tanker_in_number" class="form-control number" maxlength="20">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-5"></div>
                                     <div class="col-xs-7">
                                     <input type="submit" class="btn blue tooltips" name="submit" value="submit">
                                     <a href="<?php echo SITE_URL.'tanker_out_details';?>" class="btn default">Cancel</a>  
                                    </div>                                 
                                </div>
                            </div>
                        </div>
                    </form> 
                <?php 
                }
                else if($flag==2)
                {
                ?>
                    <form method="post" action="<?php echo SITE_URL.'insert_tanker_out_details'?>" class="form-horizontal">
                    <div class="col-md-offset-1 col-md-10 well">
                        <div class="col-md-offset-9 col-md-3">
                            <p align="left" style="color:#3A8ED6;"><b>
                            <span class="timer_block" style="float:right;">
                            <i class="fa fa-clock-o"></i>
                            <span id="timer"></span>
                            </span></b></p>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label class="col-md-5 control-label">Tanker Type :</label>
                                    <div class="col-md-7">                                        
                                        <p class="form-control-static"><b><?php echo $tanker_row['tanker_type'] ?></b></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Tanker In No :</label>
                                    <div class="col-md-7">
                                        <input type="hidden" name="tanker_in_no" value="<?php echo $tanker_row['tanker_in_number'];?>">
                                       <p class="form-control-static"><b><?php echo $tanker_row['tanker_in_number']; ?> </b></p>
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Vehicle No :</label>
                                    <div class="col-md-7">                                       
                                        <p class="form-control-static"><b><?php echo $tanker_row['vehicle_number']; ?></b></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-5 control-label">Invoice No :</label>
                                    <div class="col-md-7">
                                         <p class="form-control-static"><b><?php echo $tanker_row['invoice_number']; ?> </b></p>                                   
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">DC No :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo $tanker_row['dc_number']; ?></b></p>
                                    </div>
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">In time :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo $tanker_row['in_time']; ?></b></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Out time :</label>
                                    <div class="col-md-7">
                                        <p class="form-control-static"><b><?php echo date("Y-m-d H:i:s") ?></b></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Remarks :</label>
                                    <div class="col-md-7">
                                        <textarea class="form-control" cols="2" name="remark"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                                                 
                        </div>                       
                        <div>
                            <div class="row">
                                <div class="col-md-offset-5 col-md-4">
                                     <button type="submit" class="btn blue tooltips" name="submit">Submit</button>
                                     <a href="<?php echo SITE_URL.'tanker_out_details';?>" class="btn default">Cancel</a>
                               </div>
                            </div>
                       </div>
                    </form>
                    <?php }
                     ?>
                    
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->

<?php $this->load->view('commons/main_footer', $nestedView); ?>

