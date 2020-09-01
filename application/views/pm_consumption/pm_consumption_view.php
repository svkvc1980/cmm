 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">                
                <div class="portlet-body">
                
                    <?php
                    if(isset($flg))
                    {?>
                    <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-3">
                        <h4><?php echo '<b>Product:</b>'.get_product_name(@$product_id);?></h4>
                        
                    </div>                                    
                                                   
                </div>
                    <h3> Primary Packing Material</h3>
                    <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th> Packing Material </th>
                                        <th> Quantity </th>                                             
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($results1)
                                {   $sn=1;
                                    foreach($results1 as $row)
                                    {?>
                                        <tr>
                                            <td> <?php echo $sn++;?></td>
                                            <td> <?php echo $row['pm_name'];?> </td>
                                            <td> <?php echo $row['quantity'].$row['unit_name'];?> </td>                                
                                           
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

                        <h3> Secondary Packing Material</h3>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th> Packing Material </th>
                                        <th> Quantity </th>                                             
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($results1)
                                {$sn=1;
                                    foreach($results2 as $row2)
                                    {?>
                                        <tr>
                                            <td> <?php echo $sn++;?></td>
                                            <td> <?php echo $row2['pm_name'];?> </td>
                                            <td> <?php echo $row2['quantity'].$row2['unit_name'];?> </td>                                
                                           
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
                        <?php 
                    }
                    if(isset($display_results)&&$display_results==1)
                    {
                    ?>
                        <form method="post" action="<?php echo SITE_URL.'manage_pm_consumption'?>">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">                                        
                                        <select class="form-control"  id="" name="product_id">
                                            <option value="">Select Product</option>
                                            <?php
                                              foreach($product as $row)
                                              {
                                              $selected = (@$row['product_id']==@$search_data['product_id'])?'selected="selected"':'';
                                              echo '<option value="'.@$row['product_id'].'"  '.$selected.'>'.@$row['name'].'</option>';
                                              }
                                              ?>
                                        </select>
                                    </div>
                                </div>
                                
                               <div class="col-sm-4">
                                    <div class="form-actions">
                                        <button type="submit" name="search_pm_consumption" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                        <a  class="btn blue tooltips" href="<?php echo SITE_URL.'manage_pm_consumption';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
                                        <a href="<?php echo SITE_URL.'add_pm_consumption';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                        
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th> Product </th>
                                        <th> Short Name</th>                                        
                                        <th> Actions </th>            
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($pm_consumption_results)
                                {
                                    foreach($pm_consumption_results as $row)
                                    {?>
                                        <tr>
                                            <td> <?php echo $sn++;?></td>
                                            <td> <?php echo $row['name'];?> </td>
                                            <td> <?php echo $row['short_name'];?> </td>                                        
                                            <td> <?php if(@$row['status']!=2){?>
                                                <a class="btn btn-default btn-xs tooltips" href="<?php echo SITE_URL.'edit_pm_consumption/'.cmm_encode($row['product_id']);?>"  data-container="body" data-placement="top" data-original-title="Edit Details"><i class="fa fa-pencil"></i></a>
                                                <a class="btn btn-default btn-xs tooltips" href="<?php echo SITE_URL.'view_pm_consumption/'.cmm_encode($row['product_id']);?>"  data-container="body" data-placement="top" data-original-title="View Details"><i class="fa fa-eye"></i></a>
                                                <?php
                                                }
                                                
                                                ?>
                                            </td>
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
                    <?php
                    }
                    ?>
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>