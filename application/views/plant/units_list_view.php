<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- BEGIN BORDERED TABLE PORTLET-->
			<div class="portlet light portlet-fit">
				<div class="portlet-body">
					<?php
					if(isset($flg))
					{
					?>
						<form id="plant_form" method="post" action="<?php echo @$form_action;?>" class="form-horizontal">
							 <div class="row">                        
                            <div class="col-md-12">
                                
                                <div class="col-md-offset-3 col-md-2" style="padding:4px 20px">
                                    <div class="mt-widget-3">
                                        <div class="mt-head bg-red">
                                            <div class="mt-head-icon">
                                                <i class="fa fa-cogs" aria-hidden="true"></i>
                                            </div>
                                            <div class="mt-head-desc"><b>OPS</b></div>
                                            <div class="mt-head-button">
                                                <button type="submit" name="submit" class="btn btn-circle btn-outline white btn-sm" value="2">Add</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-2" style="padding:4px 20px">
                                    <div class="mt-widget-3">
                                        <div class="mt-head bg-yellow">
                                            <div class="mt-head-icon">
                                                <i class="fa fa-clipboard" aria-hidden="true"></i>
                                            </div>
                                            <div class="mt-head-desc"><b>Stock Point</b></div>
                                            <div class="mt-head-button">
                                                <button type="submit" name="submit" class="btn btn-circle btn-outline white btn-sm" value="3">Add</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-2" style="padding:4px 20px">
                                    <div class="mt-widget-3">
                                        <div class="mt-head bg-green">
                                            <div class="mt-head-icon">
                                                <i class="fa fa-expand" aria-hidden="true"></i>
                                            </div>
                                            <div class="mt-head-desc"><b>C&F</b></div>
                                            <div class="mt-head-button">
                                                <button type="submit" name="submit" class="btn btn-circle btn-outline white btn-sm" value="4">Add</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
						</form>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $this->load->view('commons/main_footer', $nestedView); ?>