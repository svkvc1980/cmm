 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                
                <div class="portlet-body"> 
                    
                        <form method="post" action="<?php echo SITE_URL.'manage_dist_invoice'?>">
                            <div class="row">                                
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="form-control"  placeholder="Invoice Number" type="text"  value="<?php echo @$searchParams['invoice_number'];?>" name="invoice_number" />    
                                    </div>
                                </div>
                                <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control select2" name="distributor_id" >
                                                <option value="">-Select distributor- </option>
                                                <?php
                                                foreach($distributor_list as $dis)
                                                {  
                                                    $selected = "";
                                                    if($dis['distributor_id'] == @$searchParams['distributor_id']){ $selected = "selected"; }
                                                    echo '<option value="'.$dis['distributor_id'].'" '.$selected.'>'.$dis['distributor_code'].' - ('.$dis['agency_name'].')</option>';
                                                }?>
                                             </select>
                                </div>
                            </div>
                                <div class="col-md-3">
                                <div class="form-group">
                                    <div class="input-group date-picker input-daterange " data-date-format="dd-mm-yyyy">
                                        <input class="form-control"  name="from_date"  placeholder="From Date" type="text" value="<?php if(@$searchParams['from_date']!=''){echo date('d-m-Y',strtotime(@$searchParams['from_date']));}?>" >
                                        <span class="input-group-addon"> to </span>
                                            <input class="form-control"  name="to_date" placeholder="To Date" type="text" value="<?php if(@$searchParams['to_date']!=''){echo date('d-m-Y',strtotime(@$searchParams['to_date']));}?>">
                                    </div>
                                </div>
                            </div>
                                                       
                                <div class="col-md-3">
                                    <div class="form-actions">
                                        <button type="submit" name="search_dist_invoice" value="1" class="btn btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search" ><i class="fa fa-search"></i></button>
                                        <a  class="btn btn blue tooltips" href="<?php echo SITE_URL.'manage_dist_invoice';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
                                        <!-- <button type="submit" name="download_dist_invoice" value="1" formaction="<?php echo SITE_URL.'download_dist_invoice';?>" class="btn btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download"><i class="fa fa-cloud-download"></i></button> -->
                                        <button type="submit" name="print_dist_invoice_list" value="1" formaction="<?php echo SITE_URL.'print_dist_invoice_list';?>" class="btn btn-danger tooltips" data-container="body" data-placement="top" data-original-title="Print"><i class="fa fa-print"></i></button>
                                        
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th> Invoice Number </th>
                                        <th> Distributor </th>
                                        <th> Total Value</th>
                                        
                                        <th> Actions </th>                                                   
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                if($dist_invoice_results){

                                    foreach($dist_invoice_results as $row){
                                ?>
                                    <tr>
                                        <td> <?php echo $sn++;?></td>
                                        <td> <?php echo $row['lifting_point']. ' / '.$row['invoice_number']. ' / '.format_date($row['invoice_date']);?> </td>
                                        <td> <?php echo $row['agency_name'].' ['.$row['distributor_code'].']'.' ['.$row['distributor_place'].']';?> </td>
                                        <td align="right"> <?php echo price_format($row['invoice_amount']);?> </td>
                                        
                                        <td> <a href="<?php echo SITE_URL.'view_dist_invoice_details/'.cmm_encode($row['invoice_id']);?>"  class="btn btn-default btn-xs tooltips" data-container="body" data-placement="top" data-original-title="View Invoice Details">View</a>
                                        <a class="btn btn-primary print_btn btn-xs tooltips" data-container="body" data-placement="top" data-original-title="Print"  href="<?php echo SITE_URL.'print_dist_invoice_details/'.cmm_encode($row['invoice_id']);?>"><i class="fa fa-print"></i></a></td>
                                        
                                    </tr>
                                <?php
                                    }
                                }
                                else
                                {
                            ?>      <tr><td colspan="6" align="center"> No Records Found</td></tr>      
                        <?php   }
                                ?>
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
