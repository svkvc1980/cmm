<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="portlet light portlet-fit">
	   <div class="portlet-body">
	   		<form class="form-horizontal" method="post" action="<?php echo SITE_URL;?>consolidated_penalty_report">
				<div class="row">
                    <div class="col-md-12">                        
                        
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
                    </div>             
                </div>
                <div class="form-group">
                    <div class="col-md-4"></div>
                        <div class="col-md-8">
                            <input type="submit" class="btn blue tooltips" value="submit" name="penalty_search">
                            <a href="#" class="btn default">Cancel</a>
                    </div>                                 
                </div>
			</form>
						
		</div>
	</div>
</div>

<?php $this->load->view('commons/main_footer', $nestedView); ?>