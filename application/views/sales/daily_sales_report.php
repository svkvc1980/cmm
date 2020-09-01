<?php $this->load->view('commons/main_template', $nestedView); ?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN BORDERED TABLE PORTLET-->
			<div class="portlet light portlet-fit">
				<div class="portlet-body">
                    <form method="post" action="<?php echo SITE_URL.'daily_sales_report_print'?>">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <div class="input-group date-picker input-daterange " data-date-format="dd-mm-yyyy">
                                        <input class="form-control" required name="start_date"  placeholder="From Date" type="text" value="<?php if(@$search_data['start_date']!=''){ echo @date('d-m-Y',strtotime($search_data['from_date'])); } else { echo date('d-m-Y'); } ?>" >
                                    </div>
                                </div>
                            </div>
                            <?php  if($block_id==get_headoffice_block_id())
                            { ?>
                                <div class="col-md-2">
                                <div class="form-group">
                                    <select class="form-control" name="plant_id" required>
                                    <option value="" selected>Select Unit</option>
                                    <?php foreach ($get_units as $row) { ?>
                                        <option value="<?php echo $row['plant_id']; ?>"><?php echo $row['name']; ?></option>
                                 <?php   } ?>
                                    </select>
                                </div>
                            </div>
                           <?php } ?>
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