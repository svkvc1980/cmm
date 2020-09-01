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
               		<form  method="post" action="<?php echo SITE_URL.'mrr_loose_oil_list'?>">
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
                                <button type="submit" name="search_oil" data-original-title="Search" value="1" class="btn blue tooltips"><i class="fa fa-search"></i> </button>
                                <a  class="btn blue tooltips" href="<?php echo SITE_URL.'mrr_loose_oil_list';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
                                <!-- <a  class="btn blue tooltips" href="<?php echo SITE_URL.'loose_oil_mrr';?>" data-original-title="Back to MRR Oil"> <i class="fa fa-chevron-left"></i></a> -->
                                <button type="submit" formaction="<?php echo SITE_URL.'print_mrr_oil_list'?>" name="print_mrr_list" data-original-title="Print" value="1" class="btn blue tooltips"><i class="fa fa-print"></i> </button>
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th> S.No </th>
                                     <th> PO Number </th>
                                    <th> MRR Number </th>
                                    <th> Tanker In No </th>
                                    <th> Unit</th>
                                    <th> Product </th>
                                    <th> Received Qty(MT)</th>
                                    <th > Actions </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(count($view_mrr_list_results)>0)
                                {   $sno=1;
                                    foreach($view_mrr_list_results as $row)
                                    {
                                ?>
                                    <tr>
                                        <td> <?php echo $sno++;?> </td>
                                        <td> <?php echo $row['po_number'].' / '.format_date($row['po_date']);?> </td>
                                        <td> <?php echo $row['mrr_number'].' / '.format_date($row['mrr_date']);?> </td>
                                        <td> <?php echo $row['tanker_in_number'];?> </td>
                                        <td> <?php echo $row['plant_name'];?> </td>
                                        <td> <?php echo $row['loose_oil_name'];?> </td>
                                        <td align="right"> <?php echo qty_format($row['received_qty']);?> </td>
                                        <td>
                                            <a class="btn btn-primary btn-xs tooltips" data-original-title="Print Oil M.R.R."  href="<?php echo SITE_URL;?>print_mrr_list/<?php echo cmm_encode($row['mrr_oil_id']); ?>"><i class="fa fa-print"></i>Print</a> 
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