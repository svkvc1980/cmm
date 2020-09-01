<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <form  method="post" action="<?php echo SITE_URL.'pm_report'?>">
                        <div class="row">
                        	<div class="col-sm-4">
                                <div class="form-group">
                                    <input class="form-control" name="po_no" value="<?php echo @$search_params['po_number'];?>" placeholder="PO No" type="text">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <select name="pm_id" class="form-control select2">
                                        <option value="">-Select Product-</option>
                                        <?php 
                                            foreach($packing as $pack)
                                            {
                                                $selected = '';
                                                if($pack['pm_id'] ==@$search_params['pm_id'] ) $selected = 'selected';
                                                echo '<option value="'.$pack['pm_id'].'" '.$selected.'>'.$pack['packing_name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <select name="plant_id" class="form-control">
                                            <option value="">-Select Ops-</option>
                                            <?php 
                                                foreach($plant as $pla)
                                                {
                                                    $selected = '';
                                                    if($pla['plant_id'] ==@$search_params['plant_id'] ) $selected = 'selected';
                                                    echo '<option value="'.$pla['plant_id'].'" '.$selected.'>'.$pla['plant_name'].'</option>';
                                                }
                                            ?>
                                        </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        	<div class="col-sm-4">
                                <div class="form-group">
                                    <select name="supplier_id" class="form-control select2">
                                        <option value="">-Select Supplier-</option>
                                        <?php 
                                            foreach($supplier as $supp)
                                            {
                                                $selected = '';
                                                if($supp['supplier_id'] ==@$search_params['supplier_id'] ) $selected = 'selected';
                                                echo '<option value="'.$supp['supplier_id'].'" '.$selected.'>'.$supp['supplier_name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <select name="status" class="form-control">
                                        <option value="">-Select Status-</option>
                                        <?php 
                                            foreach($status as $key =>$value)
                                            {
                                                $selected = '';
                                                if($key ==@$search_params['status'] ) $selected = 'selected';
                                                echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
	                            <div class="input-group date-picker input-daterange " data-date-format="dd-mm-yyyy">
								 	<input class="form-control" name="start_date"  placeholder="From Date" type="text" value="<?php if(@$search_params['start_date']!=''){ echo @date('d-m-Y',strtotime($search_params['start_date'])); }?>" >
									<span class="input-group-addon"> to </span>
	                                    <input class="form-control " name="end_date" placeholder="To Date" type="text" value="<?php if(@$search_params['end_date']!=''){ echo @date('d-m-Y',strtotime($search_params['end_date'])); }?>">
	                            </div>
							</div>
							<div class="col-sm-4">
                                <button type="submit" title="Search" name="search_pm" value="1" class="btn blue"><i class="fa fa-search"></i> </button>
                                <a  class="btn blue tooltips" href="<?php echo SITE_URL.'pm_report';?>" data-original-title="Refresh"> <i class="fa fa-refresh"></i></a>
                                <button type="submit" name="print_pm" value="1" formaction="<?php echo SITE_URL.'print_pm_report';?>" class="btn btn-danger tooltips" data-container="body" data-placement="top" data-original-title="Print"><i class="fa fa-print"></i></button>
                            </div>
                        </div>
                        <div class="table-scrollable">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th> S.No </th>
                                    <th> PO No </th>
                                    <th> OPS </th>
                                    <th> Packing Material</th>
                                    <th> Supplier</th>
                                    <th> Status</th>
                                    <th> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(count($packing_material)>0)
                                {  
                                    foreach($packing_material as $row)
                                    {
                                ?>
                                    <tr>
                                    	<td width="10%"> <?php echo $sn++;?> </td>
                                        <td width="10%"> <?php echo $row['po_number'];?> </td>
                                        <td width="15%"> <?php echo $row['plant_name'];?> </td>
                                        <td width="25%"> <?php echo $row['packing_name'];?> </td>
                                        <td width="15%"> <?php echo $row['supplier_name'];?> </td>
                                        <td width="15%"> <?php echo get_po_pm_status_value($row['status']);?> </td>
                                    	<td width="10%">
                                            <a class="btn btn-primary btn-xs tooltips" data-original-title="Print PO Packing Material"  href="<?php echo SITE_URL;?>print_pm/<?php echo cmm_encode($row['po_pm_id']); ?>"><i class="fa fa-print"></i>Print</a> 
                                        </td>
                                    </tr>
                                    <?php
                                    }
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