<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                <?php 
                    if(@$flag==1)
                    {
                    ?>
	                <form method="post"  action="<?php echo SITE_URL.'get_oil_test_result';?>" class="form-horizontal">
                        <div class="row">
                           <div class="col-md-offset-3 col-md-6 well">
                                <div class="form-group">
                                    <label for="inputName" class="col-sm-5 control-label"> Oil Lab Test Number:<span class="font-red required_fld">*</span></label>
                                    <div class="col-sm-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input type="text" class="form-control" required placeholder="Enter Test Number" name="test_number" value="" maxlength="150">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-5"></div>
                                    <div class="col-md-6">
                               			<input type="submit" class="btn blue" name="submit" value="submit">
                                 		<a href="<?php echo SITE_URL.'';?>" class="btn default">Cancel</a>
                            	   </div>                                 
                                </div>
                            </div>
                        </div>                         
                    </form>
                <?php } 
                if(@$flag==2){
                ?>
                <form method="post" action="<?php echo SITE_URL.'update_oil_test_status';?>">
                    <div class="table-scrollable">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr class="bg-blue" align="center">
                                    <td colspan="4" style="color:white;" valign="top"><b>TEST RESULTS</b></td>
                                </tr>
                                <?php 
                                    foreach ($test_results as $key => $value) 
                                    { ?>
                                        <tr class="bg-grey-steel">
                                            <th> <?php echo $value['test_group']; ?></th>
                                            <th> Value Obtained </th>
                                            <th> Permissible Range </th>
                                            <th> Test Status </th>
                                        </tr>
                                        <?php 
                                            #echo '<pre>';print_r($value['tests']);
                                            foreach($value['tests'] as $keys =>$test_row)
                                                { ?>
                                        <tr>
                                            <td> <?php echo $test_row['loose_oil_test'];  ?></td>
                                            <input type="hidden" name="test_number" value="<?php echo $test_row['test_number'];?>">
                                             <input type="hidden" name="lab_test_id" value="<?php echo $test_row['lab_test_id'];?>">
                                            <td>
                                                <div class="form-group">
                                                <?php
                                                switch($test_row['range_type_id'])
                                                {
                                                    case 1: case 4:
                                                    ?>
                                                    <?php
                                                        echo $test_row['value'];
                                                    break;
                                                    case 2: case 3:
                                                    ?>
                                                    <?php
                                                        echo get_oil_test_option_value_by_key($test_row['value'],$test_row['test_id']);
                                                    break;
                                                } //end of switch
                                                ?>
                                                </div>
                                            </td>    
                                            <td>
                                                <?php
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
                                                            echo $range.' '.$test_row['unit'];
                                                        break;
                                                        case 2: case 3:
                                                            echo $test_row['specification'];
                                                        break;
                                                        case 4:
                                                            echo $test_row['lower_limit'];
                                                        break;
                                                    } //end of switch
                                                    ?>
                                                </td>
                                                <td>
                                                <?php
                                                    if($test_row['individual_status']==1)
                                                    {
                                                        echo "<span class='label label-success'>Pass</span>";
                                                    }
                                                    else
                                                    {
                                                        echo "<span class='label label-danger'>Fail</span>";
                                                    }
                                                ?>
                                                </td>
                                            </tr>
                                <?php   }
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr><td colspan="4">Lab Test Result: 
                                    <?php   if($test_row['overall_status']==1)
                                            { 
                                                echo "<span class='label label-success'>Pass</span>";
                                            } 
                                            else
                                            { 
                                                echo "<span class='label label-danger'>Fail</span>";
                                            } ?>
                                    </td></tr>
                                </tfoot>
                            </table>
                        </div>
                         <div class="row ">
                                <div class=" col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Remarks <span class="font-red required_fld">*</span></label>
                                        <div class="col-md-6">
                                            <textarea class="form-control" name="remarks" required></textarea> 
                                        </div>
                                    </div>    
                                </div>    
                            </div>
                        <div class="row">
                            <div class="col-md-offset-5 col-md-3">
                                <input type="submit" class="btn blue" name="submit" onclick="return confirm('Are you sure you want to Proceed?')" value="PassTest">
                                <a href="<?php echo SITE_URL.'rollback_oil_test';?>" class="btn default">Cancel</a>
                            </div>
                        </div>
                    </form>    
                <?php } ?>
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->

<?php $this->load->view('commons/main_footer', $nestedView); ?>    