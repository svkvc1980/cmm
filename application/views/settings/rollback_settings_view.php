<?php $this->load->view('commons/main_template', $nestedView); ?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <form  method="post" action="<?php echo $form_action;?>" class="form-horizontal">
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="4%">Sno</th>
                                        <th width="46%">Label</th>
                                        <th width="25%">Issue Raised By</th>
                                        <th width="25%">Issue Closed By</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php  $sno = 1;
                                    foreach ($preference_list as $pre) 
                                    {  ?>
                                    <input type="hidden" name="old_issue_raised_by[<?php echo $pre['rep_preference_id']; ?>]"  value="<?php echo $pre['issue_raised_by']; ?>">
                                    <input type="hidden" name="old_issue_closed_by[<?php echo $pre['rep_preference_id']; ?>]"  value="<?php echo $pre['issue_closed_by']; ?>">
                                    <tr>
                                        <td> <?php echo $sno++; ?></td>
                                        <td><b><?php echo $pre['label']; ?></b></td>
                                        <td><select class="form-control" name="new_issue_raised_by[<?php echo $pre['rep_preference_id']; ?>]" required>
                                                <option value="">-Issue Raised By- </option>
                                                <?php 
                                                foreach($designation_list as $row)
                                                {
                                                    $selected = "";
                                                    if($row['block_designation_id']== @$pre['issue_raised_by'])
                                                        { 
                                                            $selected='selected';
                                                        }
                                                    echo '<option value="'.$row['block_designation_id'].'" '.$selected.' >'.$row['name'].'</option>';
                                                } ?>
                                            </select>
                                        </td>
                                        <td><select class="form-control" name="new_issue_closed_by[<?php echo $pre['rep_preference_id']; ?>]" required>
                                                <option value="">-Issue Closed By- </option>
                                                <?php 
                                                foreach($designation_list as $row)
                                                {
                                                    $selected = "";
                                                    if($row['block_designation_id']== @$pre['issue_closed_by'])
                                                        { 
                                                            $selected='selected';
                                                        }
                                                    echo '<option value="'.$row['block_designation_id'].'" '.$selected.' >'.$row['name'].'</option>';
                                                } ?>
                                            </select>
                                        </td>
                                    </tr><?php 
                                    }   ?>
                                </tbody>
                            </table>
                        </div>
                                                                    
                       <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-5 col-md-6">
                                    <button type="submit" value="1" name="submit" class="btn blue">Submit</button>
                                    <a href="<?php echo SITE_URL;?>" class="btn default">Cancel</a>
                                </div>
                            </div>  
                        </div>
                      </form>
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->

<?php $this->load->view('commons/main_footer', $nestedView); ?>


