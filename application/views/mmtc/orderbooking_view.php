<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                
                <div class="portlet-body">
                <form id="orderbooking_form" method="post" action="orderbooking" class="form-horizontal">
					<div class="form-group">
					    <label class="col-md-3 control-label">Agency Name <span class="font-red required_fld">*</span></label>
					    <div class="col-md-6">
					        <div class="input-icon right">
					            <i class="fa"></i>
					           <select class="form-control" name="agency_name">
					           <option value="" >Select Agency Name</option>
					           <option>Aditya</option>
					           <option>Hanuman</option>
					           </select>
					        </div>
					    </div>
					</div>
					<div class="form-group">
                        <label class="col-md-3 control-label">Stock Lifting Unit <span class="font-red required_fld">*</span></label>
                        <div class="col-md-6">
                            <div class="input-icon right">
                                <i class="fa"></i>
                               <select class="form-control" name="unit_code">
                               <option value="" >Select Unit Code</option>
                               <option>	Vizag Unit</option>
                               <option>	Karnool Unit</option>
                              </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-3 col-md-6">
                                    <button type="submit" value="1" class="btn blue">Submit</button>
                                    <a href="<?php echo SITE_URL.'orderbooking';?>" class="btn default">Cancel/Home</a>
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