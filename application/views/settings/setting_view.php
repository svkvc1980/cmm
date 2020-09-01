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
                    {
                        if($flg==1){
                        ?>
                            <form id="general_settings_form" method="post" action="<?php echo $form_action;?>" class="form-horizontal">
                            <input type="hidden" id="preference_id" name="preference_id" value="<?php echo @$preference_row['preference_id'] ?>">
                                 <div class="form-group">
                                    <label class="col-md-4 control-label">Section<span class="font-red required_fld">*</span></label>
                                      <div class="col-md-5">
                                        <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input class="form-control" name="section"  value="<?php echo @$preference_row['section'];?>" placeholder="Section" type="text" id="preferenceSection">

                                        </div>
                                     </div>
                                  </div>
                                 <div class="form-group">
                                    <label class="col-md-4 control-label">Name<span class="font-red required_fld">*</span></label>
                                      <div class="col-md-5">
                                        <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input class="form-control" name="name" value="<?php echo @$preference_row['name'];?>" placeholder="Name" type="text" id="preferenceName">
                                           <p id="preferencenameValidating" class="hidden"><i class="fa fa-spinner fa-spin"></i> Checking...</p>
                                          <p id="preferenceError" class="error hidden"></p>
                                        </div>
                                     </div>
                                  </div>
                                   <div class="form-group">
                                    <label class="col-md-4 control-label">value<span class="font-red required_fld">*</span></label>
                                      <div class="col-md-5">
                                        <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input class="form-control" name="value" value="<?php echo @$preference_row['value'];?>" placeholder="Value" type="text">                                   
                                        </div>
                                     </div>
                                  </div>
                                   <div class="form-group">
                                    <label class="col-md-4 control-label">Lable<span class="font-red required_fld">*</span></label>
                                      <div class="col-md-5">
                                        <div class="input-icon right">
                                          <i class="fa"></i>
                                          <input class="form-control" name="lable" value="<?php echo @$preference_row['lable'];?>" placeholder="Lable" type="text">                                   
                                        </div>
                                     </div>
                                  </div> 
                                   <div class="form-group">
                                    <label class="col-md-4 control-label">type<span class="font-red required_fld">*</span></label>
                                      <div class="col-md-5">
                                        <div class="input-icon right">
                                          <i class="fa"></i>
                                          <select class="form-control" name="type">
                                           <option value="">-Select Type-</option>

                                           <option value="1" <?php if(@$preference_row['type']==1){?> selected <?php } ?>>Type1</option>
                                           <option value="2" <?php if(@$preference_row['type']==2){?> selected <?php } ?>>Type2</option>
                                          </select>                         
                                        </div>
                                     </div>
                                  </div>                             
                               <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-5 col-md-6">
                                            <button type="submit" value="1" name="submit" class="btn blue">Submit</button>
                                            <a href="<?php echo SITE_URL.'settings_list';?>" class="btn default">Cancel</a>
                                        </div>
                                    </div>  
                                </div>
                            </form>
                        <?php
                            }
                        }
                        if(@$flg==2)
                        {
                        ?>
                      <form id="update_settings" method="post" action="<?php echo $form_action;?>" class="form-horizontal">
                        <?php foreach ($preference_list as $pre) {?>
                        <input type="hidden" name="old[<?php echo $pre['preference_id']; ?>]"  value="<?php echo $pre['value']; ?>">
                        <div class="form-group">
                            <label class="col-md-4 control-label"><?php echo $pre['lable'];?> <span class="font-red required_fld">*</span></label>
                            <div class="col-md-5">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input class="form-control" type="text" name="preference[<?php echo $pre['preference_id']; ?>]" value=" <?php echo $pre['value'];?>">
                                 </div>
                            </div>
                        </div>
                        <?php }?>                                            
                       <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-5 col-md-6">
                                    <button type="submit" value="1" name="submit" class="btn blue">Submit</button>
                                    <a href="<?php echo SITE_URL.'settings_list';?>" class="btn default">Cancel</a>
                                </div>
                            </div>  
                        </div>
                      </form>
                      <?php
                        }
                    if(isset($display_results)&&$display_results==1)
                    {
                    ?>
                        <form method="post" action="<?php echo SITE_URL.'settings_list'?>">
                            <div class="row">                                
                                <div class="col-sm-offset-3 col-sm-3">
                                    <div class="form-group">
                                      <input class="form-control" name="name" value="<?php echo @$search_data['name'];?>" placeholder="name" type="text">
                                    </div>
                                </div>                              
                                <div class="col-sm-4">
                                    <div class="form-actions">
                                        <button type="submit" name="search_settings_list" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                        <button name="reset" value="" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="reset"><i class="fa fa-refresh"></i></button>
                                        <a href="<?php echo SITE_URL.'add_general_settings';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>                                      
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                    <th style="text-align: center;"> S.No </th>
                                    <th style="text-align: center;"> Section </th>
                                    <th style="text-align: center;"> Name </th>
                                    <th style="text-align: center;"> Value </th>
                                    <th style="text-align: center;"> lable </th>
                                    <th style="text-align: center;"> Type </th>
                                    <th style="text-align: center;"> Actions </th> 
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($settings_results)
                                {
                                    foreach($settings_results as $row)
                                    {
                                ?>
                                    <tr>
                                        <td style="text-align: center;"> <?php echo $sn++;?></td>
                                        <td style="text-align: center;"> <?php echo $row['section'];?> </td>
                                        <td style="text-align: center;"> <?php echo $row['name'];?> </td>
                                        <td style="text-align: center;"> <?php echo $row['value'];?> </td>
                                        <td style="text-align: center;"> <?php echo $row['lable'];?> </td>
                                        <td style="text-align: center;"> <?php if($row['type']==1)
                                        {
                                            echo "Type1";
                                        }                                       
                                        else
                                        {
                                            echo "Type2";
                                        }
                                        ?></td>
                                        <td style="text-align: center;">
                                            <a class="btn btn-default btn-xs" href="<?php echo SITE_URL.'edit_settings/'.cmm_encode($row['preference_id']);?>"  data-container="body" data-placement="top" data-original-title="Manage Values"><i class="fa fa-pencil"></i></a>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                }
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


