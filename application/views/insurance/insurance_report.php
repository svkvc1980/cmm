<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <form role="form" id="myform" class="form-horizontal" method="post" action="<?php echo SITE_URL;?>insurance_report_detail">
                        <div class="row">
                        <div class="col-sm-offset-2 col-sm-8 well">

                            <div class="form-group">
                                <label class="col-md-3 control-label">Invoice Number</label>
                                <div class="col-md-7">
                                    <div class="input-icon right">
                                        <input type="text" name="invoice_no" class="form-control" placeholder="Invoice Number">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Distributor </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <select class="form-control select2" name="distributor_id" >
                                            <option value="">-Select distributor- </option>

                                            <?php
                                            foreach($distributor_list as $dis)
                                            {
                                                echo '<option value="'.$dis['distributor_id'].'">'.$dis['distributor_code'].' - ('.$dis['agency_name'].')</option>';
                                            }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                            <label class="col-xs-3 control-label">Date </label>
                                <div class="col-xs-7">
                                    <div class="input-icon right">
                                       <i class="fa"></i>
                                       <div class="input-group date-picker input-daterange" data-date-format="dd-mm-yyyy">
                                            <input class="form-control from" name="from_date" placeholder="From Date" type="text" value="">
                                                <span class="input-group-addon"> to </span>
                                            <input class="form-control to" name="to_date" placeholder="To Date" type="text" value="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-5 col-sm-5">
                                    <button type="submit" title="Submit" name="submit" value="submit" class="btn blue submit">Submit</button>
                                    <a title="Cancel" href="<?php echo SITE_URL.'insurance_report';?>" class="btn default">Cancel</a>
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
