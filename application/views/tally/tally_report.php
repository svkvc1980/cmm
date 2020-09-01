<?php $this->load->view('commons/main_template', $nestedView); ?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN BORDERED TABLE PORTLET-->
			<div class="portlet light portlet-fit">
				<div class="portlet-body">
                    <form method="post" action="<?php echo SITE_URL.'tally_report_print'?>">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <div class="input-group date-picker input-daterange " data-date-format="dd-mm-yyyy">
                                        <input class="form-control" required name="start_date"  placeholder="From Date" type="text" value="<?php if(@$search_data['start_date']!=''){ echo @date('d-m-Y',strtotime($search_data['from_date'])); } else { echo date('d-m-Y'); } ?>" >
                                        <span class="input-group-addon"> to </span>
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control" required name="end_date" placeholder="To Date" type="text" value="<?php if(@$search_data['end_date']!=''){ echo @date('d-m-Y',strtotime($search_data['to_date'])); } else { echo date('d-m-Y'); } ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>
                             
                            <div class=" col-sm-3">
                                <div class="form-actions">
                                    <button type="submit" class="btn blue tooltips" value="1" name="submit">Generate</button> 
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