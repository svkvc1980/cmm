 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
               
                <div class="portlet-body">
                    <?php
                    if(isset($flg)){
                    ?>
                        <form id="user" method="post" action="<?php echo $form_action;?>" class="form-horizontal">
                        <?php
                             // flg = 3 for Change Password
                            if($flg==3){
                                /*print_r($lrow['user_id']);exit;*/
                                ?>
                                <input type="hidden" name="encoded_id" value="<?php echo cmm_encode($lrrow['user_id']);?>">
                                <input type="hidden" name="username" value="<?php echo $lrrow['username'];?>">
                                <div class="form-group">
                                    <div class="input-icon right">
                                    <i class="fa"></i>
                                    <label class="col-md-4 control-label">User Name</label>
                                    <div class="col-md-5">
                                        <p class="form-control-static"><b><?php echo $lrrow['username'];?></b></p>
                                    </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">New Password</label>
                                    <div class="col-md-5">
                                    <div class="input-icon right">
                                        <i class="fa"></i>                                    
                                        <input class="form-control form-control-solid placeholder-no-fix" type="text" maxlength="50" minlength="6" id="n_password" name="n_password" placeholder="Enter Password"  maxlength="20">
                                    </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Confirm Password</label>
                                    <div class="col-md-5">
                                     <div class="input-icon right">
                                        <i class="fa"></i>
                                        <input class="form-control form-control-solid placeholder-no-fix" type="text" maxlength="50" name="c_password" id="c_password" placeholder="Enter Password"  maxlength="20">
                                    </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-4 col-md-5">
                                        <button type="submit" class="btn blue" name="submitChangePassword">Submit</button>
                                        <a href="<?php echo SITE_URL.'user';?>" class="btn default">Cancel</a>
                                    </div>
                                </div>
                            </div>
                                <?php } ?>
                            
                            <?php
                            if($flg==1){
                                ?>
                            <input type="hidden" name="block_id" class="blockid" value="<?php echo @$blockid; ?>">
                            <input type="hidden" name="encoded_id" value="<?php echo cmm_encode(@$lrow['user_id']);?>">
                            <input type="hidden" name="e_id" class="user_id" value="<?php echo @$lrow['user_id'];?>">

                            <div class="form-group">
                                <label class="col-md-4 control-label">Unit <span class="font-red required_fld">*</span></label>
                                <div class="col-md-5">
                                <div class="input-icon right">
                                        <i class="fa"></i>
                                <select class="form-control plantid" name="plant_id" >
                                    <option value="">-Select Unit- </option>

                                    <?php if($flag==2){ 
                                    foreach($plant as $pla)
                                    {
                                        $selected = "";
                                        if($pla['plant_id']== @$lrow['plant_id'])
                                            { 
                                                $selected='selected';
                                            }
                                        echo '<option value="'.$pla['plant_id'].'" '.$selected.' >'.$pla['name'].'</option>';
                                    }

                                    } ?>
                                </select>
                                </div>
                                   
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Designation <span class="font-red required_fld">*</span></label>
                                <div class="col-md-5">
                                <div class="input-icon right">
                                        <i class="fa"></i>
                                <select class="form-control desigid" name="desig_id" >
                                    <option value="">-Select Designation- </option>
                                    <?php if($flag==2){ 
                                    foreach($designation as $desig)
                                    {
                                        $selected = "";
                                        if($desig['designation_id']== @$lrow['designation_id'])
                                            { 
                                                $selected='selected';
                                            }
                                        echo '<option value="'.$desig['designation_id'].'" '.$selected.' >'.$desig['name'].'</option>';
                                    }

                                     } ?>
                                </select>
                                </div>
                                   
                                </div>
                            </div>
                            <div class="form-group">
                            <label class="col-md-4 control-label">UserName<span class="font-red required_fld">*</span></label>
                                <div class="col-md-5">
                                    <div class="input-icon right">
                                      <i class="fa"></i>
                                      <input class="form-control" name="user_name" id="userName" placeholder="UserName For Login" type="text" value="<?php echo @$lrow['username']; ?>">
                                      <p id="usernameValidating" class="hidden"><i class="fa fa-spinner fa-spin"></i> Checking...</p>
                                      <p id="userError" class="error hidden"></p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="col-md-4 control-label">Name <span class="font-red required_fld">*</span></label>
                                <div class="col-md-5">
                                <div class="input-icon right">
                                        <i class="fa"></i>
                                    <input class="form-control" name="full_name" maxlength="50" value="<?php echo @$lrow['name']; ?>"  placeholder="Full Name" type="text">
                                </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Mobile No</label>
                                <div class="col-md-5">
                                <div class="input-icon right">
                                        <i class="fa"></i>
                                    <input class="form-control numeric" name="mobile" maxlength="10" value="<?php echo @$lrow['mobile']; ?>" placeholder="Mobile No" type="text">
                                </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Email</label>
                                <div class="col-md-5">
                                    <input class="form-control" maxlength="64" name="email" value="<?php echo @$lrow['email']; ?>" placeholder="Email" type="email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="form-field-1">Address</label>
                                <div class="col-md-5">
                                    <textarea class=" form-control" rows="2" name="address"><?php echo @$lrow['address']; ?></textarea>    
                                </div>
                            </div>
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-5 col-md-6">
                                        <button type="submit" class="btn blue">Submit</button>
                                        <a href="<?php echo SITE_URL.'user';?>" class="btn default">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php
                            if($flg==10)
                            { ?>
                            <div class="row">                        
                            <div class="col-md-12">
                                <div class="col-md-offset-2 col-md-2" style="padding:4px 20px">
                                    <div class="mt-widget-3">
                                        <div class="mt-head bg-blue-hoki">
                                            <div class="mt-head-icon">
                                                <i class="fa fa-university" aria-hidden="true"></i>
                                            </div>
                                            <div class="mt-head-desc"><b>Head Office</b></div>
                                            <div class="mt-head-button">
                                                <button type="submit" class="btn btn-circle btn-outline white btn-sm" formaction="<?php echo SITE_URL.'add_user/'.cmm_encode(1);?>">Add</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-2" style="padding:4px 20px">
                                    <div class="mt-widget-3">
                                        <div class="mt-head bg-red">
                                            <div class="mt-head-icon">
                                                <i class="fa fa-cogs" aria-hidden="true"></i>
                                            </div>
                                            <div class="mt-head-desc"><b>OPS</b></div>
                                            <div class="mt-head-button">
                                                <button type="submit" class="btn btn-circle btn-outline white btn-sm" formaction="<?php echo SITE_URL.'add_user/'.cmm_encode(2);?>">Add</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-2" style="padding:4px 20px">
                                    <div class="mt-widget-3">
                                        <div class="mt-head bg-yellow">
                                            <div class="mt-head-icon">
                                                <i class="fa fa-clipboard" aria-hidden="true"></i>
                                            </div>
                                            <div class="mt-head-desc"><b>Stock Point</b></div>
                                            <div class="mt-head-button">
                                                <button type="submit" class="btn btn-circle btn-outline white btn-sm" formaction="<?php echo SITE_URL.'add_user/'.cmm_encode(3);?>">Add</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-md-2" style="padding:4px 20px">
                                    <div class="mt-widget-3">
                                        <div class="mt-head" style="background-color: #6eafb5">
                                            <div class="mt-head-icon">
                                                <i class="fa fa-truck" aria-hidden="true"></i>
                                            </div>
                                            <div class="mt-head-desc"><b>C&F</b></div>
                                            <div class="mt-head-button">
                                                <button type="submit" class="btn btn-circle btn-outline white btn-sm" formaction="<?php echo SITE_URL.'add_user/'.cmm_encode(4);?>">Add</button>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php 
                            } ?>
                        </form>
                    <?php
                    }
                    if(isset($displayResults)&&$displayResults==1)
                    {
                    ?>
                        <form method="post" action="<?php echo SITE_URL.'user'?>">
                        <input type="hidden" name="block_id" class="blockid" value="">
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input class="form-control" name="usnam" value="<?php echo @$search_data['usnam'];?>" placeholder="User Name" type="text">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <select class="form-control bloid" name="bloid" >
                                    <option value="">-Select User Type- </option>
                                        <?php 
                                            foreach($blocklist as $block)
                                                {
                                                    $selected = '';
                                                    if($block['block_id'] == @$search_data['bloid']) $selected = 'selected';
                                                    echo '<option value="'.$block['block_id'].'" '.$selected.'>'.$block['name'].'</option>';
                                                }
                                        ?>
                                </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <select class="form-control plantid" name="plaid" >
                                    <option value="">-Select Unit- </option>
                                        <?php if(@$search_data['flg']==1){
                                            foreach($plant as $pla)
                                                {
                                                    $selected = '';
                                                    if($pla['plant_id'] == @$search_data['plaid']) $selected = 'selected';
                                                    echo '<option value="'.$pla['plant_id'].'" '.$selected.'>'.$pla['name'].'</option>';
                                                }
                                        }
                                        ?>
                                </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <select class="form-control desigid" name="deid" >
                                    <option value="">-Select Designation- </option>
                                        <?php if(@$search_data['flg']==1) {
                                            foreach($designation as $des)
                                                {
                                                    $selected = '';
                                                    if($des['designation_id'] == @$search_data['deid']) $selected = 'selected';
                                                    echo '<option value="'.$des['designation_id'].'" '.$selected.'>'.$des['name'].'</option>';
                                                }
                                        }
                                        ?>
                                </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-actions">
                                        <button type="submit" name="searchUser" value="1" class="btn blue"><i class="fa fa-search"></i></button>
                                        <button type="submit" name="downloadUser" value="1" formaction="<?php echo SITE_URL.'download_user';?>" class="btn blue"><i class="fa fa-cloud-download"></i></button>
                                        <a class="btn blue" href="<?php echo SITE_URL.'usertab';?>"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th>User Name </th>
                                        <th>Full Name </th>
                                        <th>User Type </th>
                                        <th>Unit</th>
                                        <th>Designation </th>
                                        <th style="width:15%"> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                if($userResults){

                                    foreach($userResults as $row){
                                ?>
                                    <tr>
                                        <td> <?php echo $sn++;?></td>
                                        <td> <?php echo $row['username'];?> </td>
                                        <td> <?php echo $row['full_name'];?> </td>
                                        <td> <?php echo $row['block_name'];?> </td>
                                        <td> <?php echo $row['plant_name'];?> </td>
                                        <td> <?php echo $row['designation_id'] ;?> </td>
                                        <td>
                                            <a class="btn btn-default btn-xs" href="<?php echo SITE_URL.'edit_user/'.cmm_encode($row['user_id']);?>"><i class="fa fa-pencil"></i></a>
                                            <a class="btn btn-primary btn-xs" href="<?php echo SITE_URL.'change_password/'.cmm_encode($row['user_id']);?>"><i class="fa fa-key"></i></a>
                                            <?php
                                            if($row['status']==1){
                                            ?>
                                            <a class="btn btn-danger btn-xs"  onclick="return confirm('Are you sure you want to Deactivate?')" href="<?php echo SITE_URL.'deactivate_user/'.cmm_encode($row['user_id']);?>"><i class="fa fa-trash-o"></i></a>
                                            <?php
                                            }
                                            if($row['status']==2){
                                            ?>
                                            <a class="btn btn-info btn-xs"  onclick="return confirm('Are you sure you want to Activate?')" href="<?php echo SITE_URL.'activate_user/'.cmm_encode($row['user_id']);?>"><i class="fa fa-check"></i></a>
                                            <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                }
                                else
                                { ?>
                                    <tr><td colspan="7" align="center">-No Records Found-</td></tr>
                               <?php }
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