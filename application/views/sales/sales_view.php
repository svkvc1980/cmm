 <?php $this->load->view('commons/main_template', $nestedView); ?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
  <div class="row">
    <div class="col-md-12">
 <!-- BEGIN BORDERED TABLE PORTLET-->
      <div class="portlet light portlet-fit">
        <div class="portlet-body">
                <form method="post" action="<?php echo SITE_URL.'sales_view'?>">
                    <div class="row">           
                       <div class="col-sm-2">
                         <div class="form-group">
                            <input class="form-control" maxlength="20" name="customer_name" value="<?php echo @$search_data['customer_name'];?>" placeholder="Customer Name" type="text">
                         </div>
                       </div>
                         <div class="col-sm-2">
                           <div class="form-group">
                              <input class="form-control" name="billno" value="<?php echo @$search_data['billno'];?>" placeholder="Bill No" type="text">
                           </div>
                         </div>
                           <div class="col-sm-2">
                            <div class="input-icon right">
                              <input type="name" class="form-control date-picker date" data-date-format="yyyy-mm-dd" id="dd_date" placeholder="Date" name="dd_date" value="" maxlength="150">
                           </div>
                          </div>
                             <div class="col-md-3">
                                <select class="form-control" name="type_id">
                                    <option selected value="">Select Type</option>
                                    <?php foreach($types as $type)
                                        {   $selected='';
                                            if($type['typeid']==@$search_data['type_id']) $selected='selected';
                                            echo '<option value="'.$type['type_id'].'"'.$selected.'>'.$type['name'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        <div class="col-sm-2" align="right">
                            <div class="form-actions">
                                <button type="submit" name="searchsales" value="1" class="btn blue"><i class="fa fa-search"></i></button>
                                <a href="<?php echo SITE_URL;?>counter_sales" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-scrollable">
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th align="center"> S.No</th>
                                <th align="center"> Bill No</th>
                                <th align="center"> Date</th>
                                <th align="center"> Customer Name </th>
                                <th align="center"> Type</th>
                                <th align="center"> Amount</th>
                                <th align="center"> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                         <tr>
                                <td style="width:10%"> <?php echo $sn++;?></td>
                                <td style="width:15%"> 1101</td>
                                <td style="width:15%"> 2017-01-28</td>
                                <td style="width:15%"> Nagarjuna</td>
                                <td style="width:15%"> Staff</td>
                                <td style="width:15%"> 1,00,000</td>
                                <td style="width:15%">

                                <a href="<?php echo SITE_URL;?>view_counter_sales" class="btn btn-primary btn-circle btn-xs"><i class="fa fa-eye"></i></a>
                                <a class="btn btn-danger btn-circle btn-xs" href="<?php echo SITE_URL;?>print_counter_sales"><i class="fa fa-trash-o"></i></a>
                                <a class="btn btn-success btn-circle btn-xs" href="<?php echo SITE_URL;?>print_counter_sales"><i class="fa fa-print"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:10%"> <?php echo $sn++;?></td>
                                <td style="width:15%"> 1102</td>
                                <td style="width:15%"> 2017-01-28</td>
                                <td style="width:15%"> Mastan</td>
                                <td style="width:15%"> Public</td>
                                <td style="width:15%"> 1,00,000</td>
                                <td style="width:15%">

                                <a href="<?php echo SITE_URL;?>view_counter_sales" class="btn btn-primary btn-circle btn-xs"><i class="fa fa-eye"></i></a>
                                <a class="btn btn-danger btn-circle btn-xs" href="<?php echo SITE_URL;?>print_counter_sales"><i class="fa fa-trash-o"></i></a>
                                <a class="btn btn-success btn-circle btn-xs" href="<?php echo SITE_URL;?>print_counter_sales"><i class="fa fa-print"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:10%"> <?php echo $sn++;?></td>
                                <td style="width:15%"> 1103</td>
                                <td style="width:15%"> 2017-01-28</td>
                                <td style="width:15%"> Mounika</td>
                                <td style="width:15%"> Public</td>
                                <td style="width:15%"> 2,00,000</td>
                                <td style="width:15%">

                                <a href="<?php echo SITE_URL;?>view_counter_sales" class="btn btn-primary btn-circle btn-xs"><i class="fa fa-eye"></i></a>
                                <a class="btn btn-danger btn-circle btn-xs" href="<?php echo SITE_URL;?>print_counter_sales"><i class="fa fa-trash-o"></i></a>
                                <a class="btn btn-success btn-circle btn-xs" href="<?php echo SITE_URL;?>print_counter_sales"><i class="fa fa-print"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:10%"> <?php echo $sn++;?></td>
                                <td style="width:15%"> 1104</td>
                                <td style="width:15%"> 2017-01-28</td>
                                <td style="width:15%"> srilekha</td>
                                <td style="width:15%"> Public</td>
                                <td style="width:15%"> 2,00,000</td>
                                <td style="width:15%">

                                <a href="<?php echo SITE_URL;?>view_counter_sales" class="btn btn-primary btn-circle btn-xs"><i class="fa fa-eye"></i></a>
                                <a href="<?php echo SITE_URL;?>print_counter_sales" class="btn btn-danger btn-circle btn-xs"><i class="fa fa-trash-o"></i></a>
                                <a href="<?php echo SITE_URL;?>print_counter_sales" class="btn btn-success btn-circle btn-xs"><i class="fa fa-print"></i></a>
                                </td>
                            </tr>
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
