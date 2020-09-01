<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <form method="post" action="<?php echo SITE_URL.'carry_bag_recepits'?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Product Name<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <select  class="form-control"  name="product_name" >
                                            <option selected value="">-Select Product Name-</option>
                                            <option value="1">Carry Bags</option>
                                        </select> 
                                    </div>
                                </div>
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">quantity</label>
                                    <div class="col-md-6">
                                       <input type="text" class="form-control" name="quantity" value="<?php echo @$quantity;?>">
                                    </div>
                                </div>
                            </div>
                        </div></br>
                        <div class="row">
                            <div class="col-md-offset-5 col-md-4">
                                <button type="submit" class="btn blue tooltips" name="submit">Update Stock</button>
                                <a href="<?php echo SITE_URL.'carrybag_recepits';?>" class="btn default">Cancel</a>
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

