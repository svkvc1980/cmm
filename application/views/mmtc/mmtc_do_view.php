 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                
                <div class="portlet-body">
                    
                            <form id="mmtc_do" method="post" action="#" class="form-horizontal">
                                 
                               


                                <div class="form-group">
                                    <label class="col-md-3 control-label">MMTC DO Date<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control date-picker date" date-date-format="yyyy-mm-dd" name="date" value="<?php echo @$mmtc_do['Date'];?>" placeholder="Date" type="text">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Enter MMTC DO Qty<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control" name="Quantity" value="<?php echo @$mmtc_do['Quantity'];?>" placeholder="Quantity" type="text area">
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-md-3 control-label">Enter MMTC DO No<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control" name="DD_No" value="<?php echo @$mmtc_do['DD_No'];?>" placeholder="DO No" type="text">
                                        </div>
                                    </div>
                                </div>

                                
                               <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-3 col-md-6" align="center">
                                            <button type="submit" value="1" class="btn blue">Submit</button>
                                            <button type="reset"  value="1" class="btn red">Reset</button>
                                            <a href="<?php echo SITE_URL.'mmtc_do';?>" class="btn default">Cancel</a>
                                           
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
