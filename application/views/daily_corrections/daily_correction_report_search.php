<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <form  method="post" action="<?php echo SITE_URL.'daily_correction_report'?>">
                        <div class="form-group">
                            <label class="col-md-1 control-label">Date</label>
                              <div class="col-md-1">
                                <div class="input-icon right">
                                  <i class="fa"></i>
                                  <div class="input-group input-large date-picker input-daterange col-md-4" data-date-format="dd-mm-yyyy">
                                    <input type="text" class="form-control" name="from_date" placeholder="From Date"  value="<?php echo date('d-m-Y');?>">
                                    <span class="input-group-addon"> to </span>
                                    <input type="text" class="form-control" name="to_date" placeholder="To Date"  value="<?php echo date('d-m-Y');?>">
                                  </div>        
                                </div>
                             </div>
                          </div>  

                          <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-3">
                                    <input type="submit" class="btn blue tooltips" value="Submit" name="submit">
                                    <a href="<?php echo SITE_URL?>" class="btn default">Cancel</a>
                                </div>
                            </div>  
                        </div>
                      <!--  <div class="row ">  
                             <div class="form-group">
                        <label class="col-md-4 control-label">Date</label>
                
                        <div class="input-group input-large date-picker input-daterange" data-date-format="dd-mm-yyyy">
                        <input type="text" class="form-control" name="from_date" placeholder="From Date"  value="<?php echo date('d-m-Y');?>">
                        <span class="input-group-addon"> to </span>
                        <input type="text" class="form-control" name="to_date" placeholder="To Date"  value="<?php echo date('d-m-Y');?>">
                        </div>
                              </div>
                              <br>

                               <div class="form-group">
                                <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <input type="submit" class="btn blue tooltips" value="submit" name="submit">
                                        <a href="#" class="btn default">Cancel</a>
                                </div>                                 
                            </div>
                        </div> -->
                </form>                    
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>