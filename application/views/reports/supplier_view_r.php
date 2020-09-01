<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <form  method="post" action="<?php echo SITE_URL.'supplier_view_r'?>">
                        <div class="row">
                            <div class="col-sm-2">
                                <input type="text" name="supplier_code" maxlength="150" value="<?php echo @$search_data['supplier_code'];?>" class="form-control" placeholder="Supplier Code">
                            </div>
                            <div class="col-sm-2">
                                <?php echo form_dropdown('supplier_type',$supplier_type,@$search_data['type_id'],'class="form-control" name="supplier_type"');?>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" name="concerned_person" maxlength="150" value="<?php echo @$search_data['concerned_person'];?>" class="form-control" placeholder="Concerned Person">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" name="agency_name" maxlength="150" value="<?php echo @$search_data['agency_name'];?>" class="form-control" placeholder="Agency Name">
                            </div>
                            <div class="col-sm-2">
                                <select class="form-control" name="status">
                                    <option value="" selected="">-Status-</option>
                                    <option value="1"<?php if(@$search_data['status']==1){?>selected <?php } ?> >Active</option>
                                    <option value="2" <?php if(@$search_data['status']==2){?>selected <?php } ?>>InActive</option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" title="Search" name="search_supplier_r" value="1" class="btn blue"><i class="fa fa-search"></i> </button>
                                <a  class="btn blue tooltips" href="<?php echo SITE_URL.'supplier_view_r';?>" data-original-title="Refresh"> <i class="fa fa-refresh"></i></a>
                                <button type="submit" name="print_supplier" value="1" formaction="<?php echo SITE_URL.'print_supplier';?>" class="btn btn-danger tooltips" data-container="body" data-placement="top" data-original-title="Print"><i class="fa fa-print"></i></button>
                            </div>
                        </div>
                    </form>
                    <div class="table-scrollable">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                   <th width="45">S. No</th>
                                    <?php
                                    if($supplier_type=='')
                                    {
                                    ?>
                                    <th width="110">Supplier Type</th>
                                    <?php
                                    }
                                    ?>
                                    <th width="250">Agency Name [Code]</th>
                                    <th width="200">Concerned Person</th>
                                    <th width="200">Address</th>
                                    <th width="150">Mobile Number</th>
                                    <th width="45">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sn = 1;
                                if($supplier)
                                {
                                    foreach($supplier as $row)
                                    {
                                        $contact_nos = array();
                                        if($row['mobile']!='')
                                        $contact_nos[] = trim($row['mobile'],', ');
                                        if($row['alternate_mobile']!='')
                                        $contact_nos[] = $row['alternate_mobile'];
                                ?>
                                <tr>
                                    <td> <?php echo $sn++ ?> </td>
                                    <?php
                                    if($supplier_type=='')
                                    {
                                    ?>
                                    <td align="left"> <?php echo $row['type'] ?> </td>
                                    <?php
                                    }
                                    ?>
                                    <td align="left"> <?php echo $row['agency_name'].' ['.$row['supplier_code'].']' ?> </td>
                                    <td align="left"> <?php echo $row['concerned_person'] ?> </td>
                                    <td align="left"> <?php echo $row['address'] ?> </td>
                                    <td align="left"><?php echo implode(', ', $contact_nos);?></td>
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