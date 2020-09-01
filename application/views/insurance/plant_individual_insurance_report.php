<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <form role="form" id="myform" class="form-horizontal" method="post" action="<?php echo SITE_URL;?>plant_individual_insurance_invoice_report">
                        <div class="row">
                        <div class="col-sm-offset-3 col-sm-6 well">

                            <div class="form-group">
                                <label class="col-md-3 control-label">Invoice Number</label>
                                <div class="col-md-7">
                                    <div class="input-icon right">
                                        <input type="text" name="invoice_no" class="form-control" placeholder="Invoice Number" required>
                                    </div>
                                </div>
                            </div>
                           <div class="form-group">
                                <div class="col-sm-offset-5 col-sm-5">
                                    <button type="submit" title="Submit" name="submit" value="submit" class="btn blue submit">Submit</button>
                                    <a title="Cancel" href="<?php echo SITE_URL.'individual_insurance_invoice';?>" class="btn default">Cancel</a>
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
