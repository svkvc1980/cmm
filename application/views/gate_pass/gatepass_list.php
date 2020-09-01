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
               		<form  method="post" action="<?php echo SITE_URL.'gate_pass_list'?>">
                        <div class="row">
                           <div class="col-sm-3">
                                <div class="form-group">
                                    <input class="form-control" name="gatepass_number" value="<?php echo @$search_params['gatepass_number'];?>" placeholder="Gatepass No" type="text">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input class="form-control" name="tanker_in_number" value="<?php echo @$search_params['tanker_in_number'];?>" placeholder="Tanker In Number" type="text">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <input class="form-control date-picker" data-date-format="dd-mm-yyyy" name="on_date" value="<?php  if($search_params['on_date']!=''){ echo date('d-m-Y',strtotime($search_params['on_date'])); } ?>"  placeholder="Gate pass Date" type="text">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" data-original-title="Search" name="submit" value="1" class="btn blue tooltips"><i class="fa fa-search"></i> </button>
                                <a  class="btn blue tooltips" href="<?php echo SITE_URL.'gate_pass';?>" data-original-title="Back to Gate Pass"> <i class="fa fa-chevron-left"></i></a>
                               
                            </div>
                        </div>
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th> S.No </th>
                                    <th> Tanker In Number </th>
                                    <th> Gatepass Number </th>
                                    <th> date</th>
                                    <th> Invoice Number </th>
                                     <th > Actions </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(count($view_gate_pass_list_results)>0)
                                {   $sno=1;
                                    foreach($view_gate_pass_list_results as $row)
                                    {
                                ?>
                                    <tr>
                                        <td> <?php echo $sno++;?> </td>
                                        <td> <?php echo $row['tanker_in_number'];?> </td>
                                        <td> <?php echo $row['gatepass_number'];?> </td>
                                        <td> <?php echo date('d-m-Y',strtotime($row['on_date'])); ?> </td>
                                        <td> <?php echo $row['invoice'];?> </td>
                                       <!--  <td> <?php echo $row['tanker_in_number'];?> </td> -->
                                        <td>
                                            <a class="btn btn-primary btn-xs" title="Edit" href="<?php echo SITE_URL;?>print_gate_pass_list/<?php echo cmm_encode($row['gatepass_id']); ?>">Print</a> 
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