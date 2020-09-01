<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="portlet light portlet-fit">
	   <div class="portlet-body">
	   		<form class="form-horizontal" method="post" action="<?php echo SITE_URL;?>penalty_report">
				<div class="row">
                    <div class="col-md-12">                        
                        <div class="col-md-5">
                            <div class="form-group">                                
                                <div class="col-xs-12">
                                    <select class="form-control select2" name="distributor_id">
                                        <option value="">- Distributor -</option>
                                        <?php 
                                            foreach($distributor_list as $row)
                                            {
                                                $selected = "";                                                
                                                echo '<option value="'.$row['distributor_id'].'" '.$selected.' >'.$row['distributor_code'].' - ('.$row['agency_name'].')</option>';
                                            }
                                        ?>
                                   </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-xs-12">                             
                                    <select class="form-control" name="days">
                                        <option value="">- Days -</option>
                                        <?php 
                                            foreach($penalty_arr as $row)
                                            {                                               
                                                echo '<option value="'.$row['penalty_days'].'"  >'.$row['penalty_days'].'</option>';
                                            }
                                        ?>
                                   </select>
                                </div>
                            </div>
                        </div>
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