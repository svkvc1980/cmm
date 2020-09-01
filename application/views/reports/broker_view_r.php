<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                	<form role="form" class="form-horizontal" method="post" action="<?php echo SITE_URL;?>broker_r">
                        <div class="row">
                            <div class="col-sm-3">
                                <input type="text" name="broker_code" maxlength="150" value="<?php echo @$search_data['broker_code'];?>" class="form-control" placeholder="Broker Code">
                            </div>
                            <div class="col-sm-3">
                                <input type="text" name="concerned_person" maxlength="150" value="<?php echo @$search_data['concerned_person'];?>" class="form-control" placeholder="Concerned Person">
                            </div>
                            <div class="col-sm-3">
                                <input type="text" name="agency_name" maxlength="150" value="<?php echo @$search_data['agency_name'];?>" class="form-control" placeholder="Agency Name">
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" name="serach_broker_r" value="1" class="btn blue tooltips btn-sm" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i> </button>
                                <button type="submit" name="download_broker_r" value="download" formaction="<?php echo SITE_URL;?>download_broker_r" class="btn blue tooltips btn-sm" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i> </button>
                            	<button name="reset" value="" class="btn blue tooltips btn-sm" data-container="body" data-placement="top" data-original-title="Reset"><i class="fa fa-refresh"></i></button>
                            </div>
                        </div>
                    </form>
                    <div class="table-scrollable">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                	<th>S. No</th>
                                	<th>Broker Code</th>
                                	<th>Agency Name</th>
                                	<th>Concerned Person</th>
                                	<th>Location</th>
                                	<th>Mobile</th>
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                                if($broker_reports)
                                {
                                    foreach($broker_reports as $row)
                                    {
                                ?>
                            	<tr>
                            		<td> <?php echo $sn++ ?> </td>
                            		<td> <?php echo $row['broker_code'] ?> </td>
                            		<td> <?php echo $row['agency_name'] ?> </td>
                            		<td> <?php echo $row['concerned_person'] ?> </td>
                            		<td class="tooltips" data-container="body" data-placement="top" data-original-title="<?php echo $row['address'] ?>"> <?php echo $row['location'] ?> </td>
                            		<td> <?php echo $row['mobile'] ?> </td>
                            	</tr>
                            	<?php } 
                            	}
                            	else 
	                            {
	                            ?>  
	                                <tr><td colspan="6" align="center"><span class="label label-primary">No Records</span></td></tr>
	                            <?php   
                            	} ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="col-md-5 col-sm-5">
                            <div class="dataTables_info" role="status" aria-live="polite">
                                <?php echo @$pagermessage; ?>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-7">
                            <div class="dataTables_paginate paging_bootstrap_full_number">
                                <?php echo @$pagination_links; ?>
                            </div>
                        </div>
                    </div>            
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>