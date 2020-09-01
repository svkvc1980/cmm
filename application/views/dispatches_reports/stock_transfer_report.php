<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
	                <form method="post" name="stock_dispatch_form" action="<?php echo SITE_URL.'stock_transfer_print';?>" class="form-horizontal">
                        <div class="row">
                           <div class="col-md-offset-2 col-md-8 well">
                                <div class="form-group">
                                <label class="col-xs-3 control-label">Date </label>
                                    <div class="col-xs-7">
	                                    <div class="input-icon right">
	                                       <i class="fa"></i>
	                                       <div class="input-group date-picker input-daterange " data-date-format="dd-mm-yyyy">
                                                <input class="form-control" required name="from_date" placeholder="From Date" type="text" value="<?php echo date('d-m-Y'); ?>" >
                                                    <span class="input-group-addon"> to </span>
                                                <input class="form-control" required name="to_date" placeholder="To Date" type="text" value="<?php echo date('d-m-Y'); ?>">
                                            </div>
	                                    </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                <label class="col-xs-3 control-label">Unit </label>
                                    <div class="col-xs-7">
	                                    <div class="input-icon right">
	                                        <i class="fa"></i>
	                                        <select name="plant_id" class="form-control" > 
                                                    <option value="">-Select Unit-</option>
                                                    <?php 

                                                foreach($plant as $stat)
                                                {
                                                    echo '<option value="'.$stat['plant_id'].'" >'.$stat['name'].'</option>';
                                                }
                                            ?>
                                            </select> 
	                                    </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-5"></div>
                                 	<div class="col-xs-6">
                               			<input type="submit" class="btn blue" name="submit" value="submit">
                                 		<a href="<?php echo SITE_URL;?>" class="btn default">Back</a>
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