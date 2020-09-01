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
                    <form method="post" name="pm_lab_test_form" action="<?php echo SITE_URL.'pm_lab_test_detail';?>" class="form-horizontal pm_lab_test">
                        <div class="row">
                           <div class="col-md-offset-3 col-md-6 well">
                                <div class="form-group">
                                <label class="col-xs-5 control-label">Purchase Order No <span class="font-red required_fld">*</span></label>
                                    <div class="col-xs-6">
                                        <div class="input-icon right">
                                           <i class="fa"></i>
                                           <input type="text" name="po_no" class="form-control" placeholder="Purchase Order No">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                <label class="col-xs-5 control-label">Tanker Register No <span class="font-red required_fld">*</span></label>
                                    <div class="col-xs-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                           <input type="text" name="tank_reg_no" class="form-control" placeholder="Tanker Register No">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-6"></div>
                                    <div class="col-xs-6">
                                        <input type="submit" class="btn blue" name="submit" value="submit">
                                        <a href="<?php echo SITE_URL.'packing_material_test';?>" class="btn default">Cancel</a>
                                    </div>                                 
                                </div>
                            </div>
                        </div>                         
                    </form>
                    <?php 
                    }
                    if(@$flag==2)
                    {  ?>
                    <form method="post" class="insert_test_reports" action="<?php echo $form_action?>">
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <tr class="bg-blue" align="center">
                                        <td colspan="4" style="color:white;" valign="top"><b><?php echo $test_reports[0]['packing_material'] ?> ANALYSIS REPORT</b></td>
                                    </tr>
                                    <tr>
                                        <th width="25">Test Number</th>
                                        <td><?php echo get_test_pm_number(); ?></td> 
                                        <th width="25">Test Date</th>
                                        <td><?php echo date('d-M-Y'); ?></td>   
                                    </tr>
                                    <tr>
                                        <th width="25">Name of the Supplier</th>
                                        <td><?php echo $test_reports[0]['s_agency'] ?></td>
                                        <th width="25">Vehicle No</th>
                                        <td> <?php echo $test_reports[0]['vehicle_number'] ?></td>
                                    </tr>
                                    <tr>
                                        <th width="25">Purchase Order Number</th>
                                        <td><?php echo $test_reports[0]['po_number'] ?></td>
                                        <th width="25">Invoice Number</th>
                                        <td><?php echo $test_reports[0]['invoice_number'] ?></td>
                                    </tr>
                                    <tr>
                                        <th width="25">Date Of Reciept</th>
                                        <td><?php echo date('d-M-Y'); ?></td>
                                        <th width="25">Date Of Unloading/Rejection</th>
                                        <td><?php echo date('d-M-Y'); ?></th>
                                    </tr>
                                    <tr>
                                        <th width="25">Rate</td>
                                        <td><?php echo $test_reports[0]['unit_price'] ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped">
                                <tbody>
                                    <input type="hidden" name="po_no" value="<?php echo $po_no; ?>">
                                    <input type="hidden" name="tank_reg_no" value="<?php echo $reg_no; ?>">
                                    <tr class="bg-blue" align="center">
                                        <td colspan="4" style="color:white;" valign="top"><b>TEST REPORT</b></td>
                                    </tr>
                                        <?php 
                                        foreach($pm_tests as $test_row)
                                        { ?>
                                            <tr class="bg-grey-steel">
                                                <th> Test Name </th>
                                                <th> Value Obtained </th>
                                                <th> Permissible Range </th>
                                            </tr>
                                            <tr>
                                                <td> <?php echo $test_row['test_name']?></td>
                                                <td> 
                                                    <div class="form-group">
                                                        <?php
                                                        switch($test_row['range_type_id'])
                                                        {
                                                            case 1: case 4:
                                                        ?>
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input type="text" data-range-type="<?php echo $test_row['range_type_id'] ?>" data-l-limit="<?php echo $test_row['lower_limit'] ?>" data-u-limit="<?php echo $test_row['upper_limit'] ?>" data-l-check="<?php echo $test_row['lower_check'] ?>" data-u-check="<?php echo $test_row['upper_check'] ?>" value="<?php echo $lab_tests['test_result'][$test_row['test_id']]?>" class="form-control test_value" required name="test_result[<?php echo $test_row['test_id'] ?>]">
                                                        </div>
                                                        <?php
                                                            break;
                                                            case 2:$i=1;
                                                                foreach ($test_row['options'] as $option_row) 
                                                                {
                                                                    $checked = (($i==1 && !isset($lab_tests['test_result'][$test_row['test_id']])) || ($option_row['key']==$lab_tests['test_result'][$test_row['test_id']]))?'checked':'';
                                                                    echo '<input type="radio" data-allowed="['.$option_row["allowed"].']" class="test_value2" '.$checked.' value="'.$option_row['key'].'" name="test_result['.$test_row['test_id'].']">' .$option_row['value'];
                                                                }?>
                                                                <span class="test_radio hidden font-red-thunderbird" style="margin-left:50px"> Wrong Value </span>
                                                                <?php
                                                            break;
                                                            case 3:
                                                                echo '<select name="test_result['.$test_row['test_id'].']" class="form-control test_value1">';
                                                                foreach ($test_row['options'] as $option_row) 
                                                                {
                                                                    $selected='';
                                                                    if($option_row['key']== $lab_tests['test_result'][$test_row['test_id']]) $selected='selected';
                                                                    echo '<option value="'.$option_row['key'].'" '.$selected.' data-allowed="['.$option_row["allowed"].']"> '.$option_row['value'].' </option>';
                                                                }
                                                                echo '</select>';
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

                                                                        $range = ($test_row['lower_limit']+$test_row['upper_limit'])/2 .'±'. ($test_row['upper_limit']-$test_row['lower_limit'])/2;
                                                                        //$range = '> '.$test_row['lower_limit'].' TO '.' < '.$test_row['upper_limit'];
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
                                            </tr>
                                        <?php } //end of test rows?>
                                </tbody>
                            </table>
                        </div>
                        <div class="row">
                            <div class="col-md-offset-5 col-md-4">
                                <input type="submit" id="submit_oil_test" class="btn blue tooltips" value="submit" name="submit">
                                <a href="<?php echo SITE_URL.'packing_material_test';?>" class="btn default">Cancel</a>
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