<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <?php
                    if($flag==1)
                    {
                      ?>
                      <form id="dd_date_form" method="post" action="<?php echo SITE_URL.'rollback_tanker_register';?>" class="form-horizontal">
                        <div class="row ">  
                            <div class="col-md-offset-3 col-md-5"> 
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Enter Tanker Number</label>
                                    <div class="col-md-7">
                                        <input type="text" name="tanker_no" class="form-control numeric"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-5"></div>
                                        <div class="col-md-6">
                                            <input type="submit" class="btn blue tooltips"  value="Proceed" name="submit">
                                            <a href="<?php echo SITE_URL;?>" class="btn default">Cancel</a>
                                        </div>                                 
                                </div>
                            </div>
                        </div>
                    </form><?php  
                    } 
                    if($flag==2)
                    { 
                      //echo "<pre>"; print_r($dd_list); exit;
                       ?>
                       <form id="dd_date_form" method="post" action="<?php echo SITE_URL.'insert_rollback_tanker_register';?>" class="form-horizontal">
                            <input type="hidden" name="tanker_id" value="<?php echo $tanker_list['tanker_id']; ?>">
                            <input type="hidden" name="tanker_number" value="<?php echo $tanker_list['tanker_in_number']; ?>">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Tanker Number :</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo  $tanker_list['tanker_in_number']. ' of '.$tanker_list['plant_name'] ;?></b>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-scrollable">
                                        <table class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <th> Party Name </th>
                                                <th> Vehicle Number </th>
                                                <th> Product </th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    
                                                    <td><?php echo $tanker_list['party_name'];?> </td>
                                                    <td><?php echo $tanker_list['vehicle_number'];?> </td>
                                                    <?php 
                                                        if($tanker_list['oil_name'] !='')
                                                        {
                                                            ?>
                                                            <td><?php echo $tanker_list['oil_name'];?></td> <?php
                                                        }
                                                        elseif ($tanker_list['pm_name'] !='')
                                                        {
                                                            ?>
                                                            <td><?php echo $tanker_list['pm_name'];?></td> <?php
                                                        }
                                                        elseif ($tanker_list['fg_name'] !='')
                                                        {
                                                           ?>
                                                            <td><?php echo $tanker_list['fg_name'];?></td> <?php 
                                                        }
                                                        else
                                                        {
                                                            ?>
                                                            <td><?php echo 'Empty tanker';?></td> </tr> <?php
                                                        }
                                                    ?>
                                                    
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-offset-5 col-md-6">
                                    <button type="submit" class="btn blue"  name="submit">Submit</button>
                                    <a href="<?php echo SITE_URL.'delete_tanker';?>" class="btn default">Cancel</a>
                                </div>
                            </div>
                        </form><?php
                    }?>
                    
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>                