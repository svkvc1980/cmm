<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <form  method="post" action="<?php echo SITE_URL.'daily_pm_stock_report'?>">
                       <div class="row ">  
                            <div class="col-md-offset-3 col-md-5"> 
                                <div class="row ">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Report Date <span class="font-red required_fld">*</span></label> 
                                                <div class="col-md-7">                                            
                                                    <input class="form-control date-picker" data-date-format="dd-mm-yyyy" required placeholder="Report Date" type="text"  value="<?php echo date('d-m-Y');?>" name="report_date" />    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><br>                         
                                <div class="form-group">
                                    <div class="col-md-3"></div>
                                        <div class="col-md-8">
                                            <input type="submit" class="btn blue tooltips" value="Print" name="submit">
                                            <a href="<?php echo SITE_URL;?>" class="btn default">Cancel</a>
                                    </div>                                 
                                </div>
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