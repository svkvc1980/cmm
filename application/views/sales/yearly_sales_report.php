<?php $this->load->view('commons/main_template', $nestedView); ?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN BORDERED TABLE PORTLET-->
			<div class="portlet light portlet-fit">
				<div class="portlet-body">
                    <form method="post" action="<?php echo SITE_URL.'yearly_unit_product_report_print'?>">
                        <div class="row">
                            
                           
                                <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control" name="years" required>
                                    <option value="" selected>Select Year</option>
                                    <?php for($i='2015' ;$i<="2035" ; $i++) { ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                 <?php   } ?>
                                    </select>
                                </div>
                            </div>
                          
                            <div class=" col-sm-3">
                                <div class="form-actions">
                                    <button type="submit" name="search_sales" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
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