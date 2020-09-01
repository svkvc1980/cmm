<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <form  method="post" action="<?php echo SITE_URL.'dw_daily_stock_report'?>">
                       <div class="row ">  
                            <div class="col-md-offset-3 col-md-6 well"> 
                                <div class="row ">
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">                                
                                            <div class="col-xs-12">
                                                <div class="input-group input-large date-picker input-daterange" data-date-format="dd-mm-yyyy">
                                                    <input type="text" class="form-control" name="fromDate" placeholder="From Date" value="">
                                                    <span class="input-group-addon"> to </span>
                                                    <input type="text" class="form-control" name="toDate" placeholder="To Date" value=""> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><br>                         
                                <div class="form-group">
                                    <div class="col-md-4"></div>
                                        <div class="col-md-8">
                                            <input type="submit" class="btn blue tooltips" value="Print" name="submit">
                                            <a href="#" class="btn default">Cancel</a>
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