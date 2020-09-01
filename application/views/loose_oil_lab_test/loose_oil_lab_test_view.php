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
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr class="bg-blue" align="center">
                                        <td colspan="4" style="color:white;" valign="top"><b>TESTS</b></td>
                                    </tr>
                                        <?php 
                                        if(@$loose_oil_tests)
                                        {
                                            foreach ($loose_oil_tests as $group_row) 
                                            { ?>
                                                <tr class="bg-grey">
                                                    <th> <?php echo $group_row['group_name'] ?></th>
                                                    <th> Test Values </th>
                                                    <th> Test Units</th>
                                                    <th> Actions </th>
                                                </tr>   
                                                 <?php
                                                foreach ($group_row['test'] as $test_row) 
                                                { 
                                                    
                                                        ?>
                                                    <tr>
                                                        <td><?php echo $test_row['name'];?></td>
                                                        
                                                        <td>
                                                            <?php
                                                            //print_r($test_row); 
                                                            switch($test_row['range_type_id'])
                                                            {
                                                                case 1: 
                                                                    if($test_row['lower_limit'] != NULL && $test_row['upper_limit'] != NULL)
                                                                    {
                                                                        if($test_row['lower_check']==1)
                                                                        {
                                                                            if($test_row['upper_check']==1)
                                                                            {
                                                                                $range = $test_row['lower_limit'].' TO '.$test_row['upper_limit'];
                                                                            }
                                                                            else
                                                                            {
                                                                                $range = $test_row['lower_limit'].' TO '.' <'.$test_row['upper_limit'];
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            if($test_row['upper_check']==1)
                                                                            {
                                                                                $range = '> '.$test_row['lower_limit'].' TO '.' <= '.$test_row['upper_limit'];
                                                                            }
                                                                            else
                                                                            {
                                                                                $range = '> '.$test_row['lower_limit'].' TO '.' < '.$test_row['upper_limit'];
                                                                            }
                                                                        }
                                                                    }
                                                                    else
                                                                    {
                                                                        if($test_row['lower_limit']==NULL)
                                                                        {
                                                                            if($test_row['upper_check']==1)
                                                                            {
                                                                                $range = '<= '.$test_row['upper_limit'];
                                                                            }
                                                                            else
                                                                            {
                                                                                $range = '< '.$test_row['upper_limit'];
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            if($test_row['lower_check']==1)
                                                                            {
                                                                                $range = '>= '.$test_row['lower_limit'];
                                                                            }
                                                                            else
                                                                            {
                                                                                $range = '> '.$test_row['lower_limit'];
                                                                            }
                                                                        }
                                                                    }
                                                                    echo $range;
                                                                break;
                                                                case 2: case 3:
                                                                    echo 'Specification: '.$test_row['specification'];
                                                                    foreach ($test_row['options'] as $key => $value) { ?>
                                                                        <div class="row">
                                                                            <div class="col-md-4">Value:<?php echo $value['value'];?></div>                                                                
                                                                            <div class="col-md-2">
                                                                                <div class="input-group">                                                                                                                                                                     
                                                                                    <?php if($value['allowed']==1){?>
                                                                                             <i class="fa fa-check " style="color:green"> </i>
                                                                                             <?php
                                                                                            }
                                                                                            else
                                                                                            {?>
                                                                                            <i class="fa fa-close" style="color:red"> </i>
                                                                                            <?php
                                                                                            }?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php
                                                                    }                                                                
                                                                break;
                                                                case 4:
                                                                    echo $test_row['lower_limit'];
                                                                break;
                                                            } //end of switch
                                                            ?>
                                                        </td>
                                                        <td> <?php echo $test_row['unit'];?></td> 
                                                        <td> <a class="btn btn-default btn-xs tooltips" href="<?php echo SITE_URL.'edit_loose_oil_lab_test/'.cmm_encode(@$test_row['test_id']).'/'.cmm_encode(@$test_row['loose_oil_id']);?>"  data-container="body" data-placement="top" data-original-title="Edit Details">Edit Test</i></a></td>  
                                                    </tr>
                                                        
                                            <?php } // end of test rows?>
                                            <?php } //end of test groups
                                        }
                                          else
                                            {
                                        ?>      <tr><td colspan="6" align="center"> No Tests Found</td></tr>      
                                    <?php   }
                                            ?>

                                </tbody>
                            </table>
                        </div><?php 
                    }
                    if(isset($display_results)&&$display_results==1)
                    {
                    ?>
                        <form method="post" action="<?php echo SITE_URL.'loose_oil_lab_test'?>">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">                                        
                                        <select class="form-control"  id="" name="loose_oil_id">
                                            <option value="">Select Loose Oil</option>
                                            <?php
                                              foreach($loose_oil_details as $row)
                                              {
                                              $selected = (@$row['loose_oil_id']==@$search_data['loose_oil_id'])?'selected="selected"':'';
                                              echo '<option value="'.@$row['loose_oil_id'].'"  '.$selected.'>'.@$row['name'].'</option>';
                                              }
                                              ?>
                                        </select>
                                    </div>
                                </div>
                                
                               <div class="col-sm-4">
                                    <div class="form-actions">
                                        <button type="submit" name="search_loose_oil" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                        <a  class="btn blue tooltips" href="<?php echo SITE_URL.'loose_oil_lab_test';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
                                        <a href="<?php echo SITE_URL.'add_loose_oil_lab_test';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                        
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th> Loose Oil </th>
                                        <th> Short Name</th>                                        
                                        <th> Actions </th>            
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($loose_oil_results)
                                {
                                    foreach($loose_oil_results as $row)
                                    {?>
                                        <tr>
                                            <td> <?php echo $sn++;?></td>
                                            <td> <?php echo $row['name'];?> </td>
                                            <td> <?php echo $row['short_name'];?> </td>                                        
                                            <td> <?php if(@$row['status']!=2){?>
                                                <a class="btn btn-default btn-xs tooltips" href="<?php echo SITE_URL.'view_loose_oil_lab_tests/'.cmm_encode($row['loose_oil_id']);?>"  data-container="body" data-placement="top" data-original-title="View Tests">View Tests</i></a>
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