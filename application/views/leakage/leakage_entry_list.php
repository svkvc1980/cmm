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
               		<form  method="post" action="<?php echo SITE_URL.'leakage_entry_list'?>">
                        <div class="row">
                           <div class="col-sm-3">
                                <div class="form-group">
                                    <input class="form-control" name="leakage_number" value="<?php echo @$search_params['leakage_number'];?>" placeholder="Leakage No" type="text">
                                </div>
                            </div>
                            <!-- <div class="col-sm-3">
                                <div class="form-group">
                                    <select class="form-control" name="product">
                                        <option value="">Select Product </option>
                                        <?php 
                                            foreach($product_results as $row)
                                            {
                                                echo '<option value="'.$row['product_id'].'">'.$row['product_name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="on_date" value="<?php  if($search_params['on_date']!=''){ echo date('d-m-Y',strtotime($search_params['on_date'])); } ?>"  placeholder="Date" type="text">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" title="Search" name="submit" value="1" class="btn blue"><i class="fa fa-search"></i> </button>
                                <a href="<?php echo SITE_URL;?>leakage_entry" title="Add New leakage Entry" class="btn blue tooltips"><i class="fa fa-plus"></i> </a>
                               
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th> S.No </th>
                                    <th> Leakage Number </th>
                                    <th> date</th>
                                    <th > Actions </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(count($view_leakage_results)>0)
                                {   $sno=1;
                                    foreach($view_leakage_results as $row)
                                    {
                                ?>
                                    <tr>
                                        <td> <?php echo $sno++;?> </td>
                                        <td> <?php echo $row['leakage_number'];?> </td>
                                        <td> <?php echo date('d-m-Y',strtotime($row['on_date'])); ?> </td>
                                        <td>
                                            <a class="btn btn-primary btn-xs" title="Edit" href="<?php echo SITE_URL.'print_leakage_entry_list/'.cmm_encode($row['leakage_id']);?>">
                                            Print</a> 


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