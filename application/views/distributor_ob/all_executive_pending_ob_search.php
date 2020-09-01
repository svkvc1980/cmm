<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <form  method="post" action="<?php echo SITE_URL.'all_executive_pending_ob_print'?>">
                       <div class="row "> 
                            <div class="col-sm-offset-4 col-md-4">
                                <div class="form-group">
                                    <div class="input-group date-picker input-daterange " data-date-format="dd-mm-yyyy">
                                        <input class="form-control" required name="from_date"  placeholder="From Date" type="text" >
                                        <span class="input-group-addon"> to </span>
                                            <input class="form-control" required name="to_date" placeholder="To Date" type="text">
                                    </div>
                                </div>
                            </div> 
                            <div class="col-md-offset-3 col-md-5">                  
                                <div class="form-group">
                                    <div class="col-md-offset-4 col-md-5">
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