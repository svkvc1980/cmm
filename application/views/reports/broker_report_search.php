<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <form  method="post" action="<?php echo SITE_URL.'broker_report_search'?>">
                        <div class="row">
                            <div class="col-sm-2">
                                <input type="text" name="broker_code" maxlength="150" value="<?php echo @$search_data['broker_code'];?>" class="form-control" placeholder="Broker Code">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" name="agency_name" maxlength="150" value="<?php echo @$search_data['agency_name'];?>" class="form-control" placeholder="Agency Name">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" name="concerned_person" maxlength="150" value="<?php echo @$search_data['concerned_person'];?>" class="form-control" placeholder="Concerned Person">
                            </div>
                            <div class="col-sm-2">
                                <select name="status" class="form-control type_id" >
                                   <option value="">-Status-</option>
                                   <option value="1">Active</option>
                                   <option value="2">Inactive</option>    
                                </select>  
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" title="Search" name="search_broker_r" value="1" class="btn blue"><i class="fa fa-search"></i> </button>
                                <a  class="btn blue tooltips" href="<?php echo SITE_URL.'broker_report_search';?>" data-original-title="Refresh"> <i class="fa fa-refresh"></i></a>
                                <button type="submit" name="broker_report_details" value="1" formaction="<?php echo SITE_URL.'broker_report_details';?>" class="btn btn-danger tooltips" data-container="body" data-placement="top" data-original-title="Print"><i class="fa fa-print"></i></button>
                                
                            </div>
                        </div>
                    </form>
                    <div class="table-scrollable">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th> S.No </th>
                                    <th> Broker Code</th>
                                    <th> Agency name</th>
                                    <th> Concerned Person</th>
                                    <th> Address</th>
                                    <th> Mobile Number</th>
                                    <th> Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(count($broker)>0)
                                {  
                                    foreach($broker as $row)
                                    { 
                                        $contact_nos = array();
                                                if($row['mobile']!='')
                                                $contact_nos[] = trim($row['mobile'],', ');
                                                if($row['alternate_mobile']!='')
                                                $contact_nos[] = $row['alternate_mobile'];
                                    ?>
                                    <tr>
                                        <td> <?php echo $sn++;?> </td>
                                        <td> <?php echo $row['broker_code'];?> </td>
                                        <td> <?php echo $row['agency_name'];?> </td>
                                        <td> <?php echo $row['concerned_person'];?> </td>
                                        <td> <?php echo $row['address'];?> </td>
                                        <td> <?php echo implode(', ', $contact_nos);?></td>
                                        <td> <?php if($row['status']==1)
                                                {
                                                    echo "Active";
                                                }
                                                else
                                                {
                                                    echo "Inactive";
                                                }
                                                ?> 
                                            </td>
                                    </tr>
                                    <?php
                                    }
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
<?php $this->load->view('commons/main_footer',$nestedView); ?>