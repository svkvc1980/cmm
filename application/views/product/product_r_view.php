 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                
                <div class="portlet-body">
                    <form method="post" action="<?php echo SITE_URL.'print_product_report'?>">
                        <div class="row">
                            <div class="col-sm-offset-3 col-md-5">
                                <div class="form-group">
                                    <select class="form-control" name="status">
                                        <option value=""> - Select Product Status -</option>
                                        <option value="1">Active</option>
                                        <option value="2">In-Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">  
                            <div class="form-actions col-md-offset-4 col-md-4">
                                <input type="submit" name="submit" value="Submit" class="btn green">
                                <a type="button" href="<?php echo SITE_URL;?>" class="btn default">Cancel</a>
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