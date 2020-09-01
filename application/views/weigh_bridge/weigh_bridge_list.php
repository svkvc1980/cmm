<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                	<form method="post" action="<?php echo SITE_URL;?>weigh_bridge_list">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <?php echo form_dropdown('tanker_type',$tanker_type,@$search_data['tanker_type'],'class="form-control"');?>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group date-picker input-daterange " data-date-format="dd-mm-yyyy">
                                    <input class="form-control" name="from_date" placeholder="From Date" type="text" value="<?php if(@$search_data['from_date']!=''){ echo @date('d-m-Y',strtotime($search_data['from_date'])); }?>" >
                                        <span class="input-group-addon"> to </span>
                                    <input class="form-control" name="to_date" placeholder="To Date" type="text" value="<?php if(@$search_data['to_date']!=''){ echo @date('d-m-Y',strtotime($search_data['to_date'])); }?>">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input type="text" name="tanker_no" class="form-control numeric" value="<?php echo @$search_data['tanker_no'];?>" placeholder="Tanker-In-Number">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?php echo form_dropdown('loose_oil',$loose_oil,@$search_data['loose_oil'],'class="form-control"');?>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <input type="text" name="vehicle_no" maxlength="150" value="<?php echo @$search_data['vehicle_no'];?>" class="form-control" placeholder="Vehicle Number">
                                </div>
                            </div>
                            
                            <div class="col-md-3">
                                <button type="submit" name="serach_wb_list" value="1" class="btn blue tooltips btn-sm" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                            	<button name="reset" value="reset" class="btn blue tooltips btn-sm" data-container="body" data-placement="top" data-original-title="Reset"><i class="fa fa-refresh"></i></button>
                            </div>
                        </div>
                    </form>
                    <form role="form" class="form-horizontal" method="post" action="<?php echo SITE_URL;?>view_weigh_bridge_list">
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                    	<th>S. No</th>
                                        <th>Product</th>
                                        <th>Tanker Type</th>
                                    	<th>Vehicle No</th>
                                    	<th>Tanker in No </th>
                                    	<th>Invoice No</th>
                                    	<th>DC No</th>
                                    	<th>Party Name</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                	<?php
                                    if($weigh_bridge_list)
                                    {
                                        foreach($weigh_bridge_list as $row)
                                        {
                                    ?>
                                    	<tr>
                                            <td><?php echo $sn++; ?></td> 
                                            <td><?php
                                                switch ($row['tanker_type_id']) 
                                                {
                                                    case 1:
                                                        echo $row['loose_oil'];
                                                    break;

                                                    case 2:
                                                        echo $row['packing_material'];
                                                    break;

                                                    case 5:
                                                        echo $row['free_gift'];
                                                    break;    
                                                     
                                                    default:
                                                        echo "--";
                                                    break;
                                                }?>
                                            </td>
                                            <td><?php echo $row['tanker_type'] ?></td>    
                                            <td><?php echo $row['vehicle_number'] ?></td>
                                            <td><?php echo $row['tanker_in_number'] ?></td>
                                            <td><?php echo $row['invoice_number'] ?></td>
                                            <td><?php echo $row['dc_number'] ?></td>
                                            <td><?php echo $row['party_name'] ?></td>
                                            <td>
                                                <a class="btn btn-success btn-xs tooltips" data-container="body" data-placement="top" data-original-title="Print Weigh Bridge Details" href="<?php echo SITE_URL;?>download_weigh_bridge_list/<?php echo @cmm_encode($row['tr_tanker_id']); ?>"><i class="fa fa-print"></i></a>
                                            </td>
                                    	</tr>
                                	<?php } 
                                	}
                                	else 
    	                            {
    	                            ?>  
    	                                <tr><td colspan="7" align="center"><span class="label label-primary">No Records</span></td></tr>
    	                            <?php   
                                	} ?>
                                </tbody>
                            </table>
                        </div>
                    </form>        
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