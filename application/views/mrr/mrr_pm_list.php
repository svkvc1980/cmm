<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
               <div class="portlet-body">
               <?php if($flag==1)
               { ?>
               		<form  method="post" action="<?php echo SITE_URL.'mrr_pm_list'?>">
                        <div class="row">
                           <div class="col-sm-2">
                                <div class="form-group">
                                    <input class="form-control" name="po_no" value="<?php echo @$search_params['po_number'];?>" placeholder="PO No" type="text">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input class="form-control" name="mrr_number" value="<?php echo @$search_params['mrr_number'];?>" placeholder="MRR Number" type="text">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="form-group">
                                    <input class="form-control" name="tanker_in_number" value="<?php echo @$search_params['tanker_in_number'];?>" placeholder="Tanker Number" type="text">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="input-group date-picker input-daterange " data-date-format="dd-mm-yyyy">
                                    <input class="form-control" name="start_date"  placeholder="From Date" type="text" value="<?php if(@$search_params['start_date']!=''){ echo @date('d-m-Y',strtotime($search_params['start_date'])); }?>" >
                                    <span class="input-group-addon"> to </span>
                                        <input class="form-control " name="end_date" placeholder="To Date" type="text" value="<?php if(@$search_params['end_date']!=''){ echo @date('d-m-Y',strtotime($search_params['end_date'])); }?>">
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" data-original-title="Search" name="search_oil" value="1" class="btn blue tooltips"><i class="fa fa-search"></i> </button>
                                <a  class="btn blue tooltips" href="<?php echo SITE_URL.'mrr_pm_list';?>" data-original-title="Back to MRR P.M."> <i class="fa fa-refresh"></i></a>
                                <button type="submit" formaction="<?php echo SITE_URL.'print_mrr_pm_list'?>" name="print_mrr_pm_list" data-original-title="Print" value="1" class="btn blue tooltips"><i class="fa fa-print"></i> </button>
                               
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th> S.No </th>
                                    <th> MRR Number </th>
                                    <th> PO Number </th>
                                    <th> Tanker No </th>
                                    <th> Unit</th>
                                    <th> Packing Material </th>
                                    <th> Received Qty</th>
                                    <th> Actions </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(count($view_mrr_list_results)>0)
                                {   $sno=1; $total_received_qty = 0;
                                    foreach($view_mrr_list_results as $row)
                                    {
                                        $received_qty = $row['received_qty'];
                                        if($row['pm_category_id']==get_film_category_id())
                                        {
                                            //$received_qty -= $row['no_of_rolls']*$row['core_carton_weight'];
                                            $received_qty = TrimTrailingZeroes($row['film_received_qty']);
                                        }
                                        /*$value = ($row['test_status']==1)?$received_qty*$row['unit_price']):0;
                                        $total_received_qty += $received_qty;
                                        $total_received_value += $value;*/
                                ?>
                                    <tr>
                                        <td> <?php echo $sno++;?> </td>
                                        <td> <?php echo $row['mrr_number'].' / '.format_date($row['mrr_date']);?> </td>
                                        <td align="center"> <?php echo $row['po_number'];?> </td>
                                        <td align="center"> <?php echo $row['tanker_in_number'];?> </td>
                                        <td> <?php echo $row['plant_name'];?> </td>
                                        <td> <?php echo $row['packing_material'].' ('.$row['unit'].')';?> </td>
                                        <td align="right"> <?php echo $received_qty;?> </td>
                                        <td>
                                            <a class="btn btn-primary btn-xs tooltips" data-original-title="Print P.M. M.R.R."  href="<?php echo SITE_URL;?>print_mrr_pm_list/<?php echo cmm_encode($row['mrr_pm_id']); ?>"><i class="fa fa-print"></i>Print</a> 
                                        </td>
                                    </tr>
                                    <?php
                                    }
                                } 
                                else 
                                {
                                ?>  
                                    <tr><td colspan="10" align="center"><span class="label label-primary">No Records</span></td></tr>
                                <?php   
                                } ?>
                            </tbody>
                        </table>
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
                    </form>
              <?php } ?>
               </div>
            </div>
        </div>
            <!-- END BORDERED TABLE PORTLET-->
    </div>
</div>               
<!-- </div> -->
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>