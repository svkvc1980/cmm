 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    
                    <form method="post" action="<?php echo SITE_URL.'print_dist_bg'?>">
                    <div class="row">
                    <div class=" col-md-offset-2 col-md-8"> 
                        <div class="row">
                            <div class="col-sm-offset-3 col-sm-6">
                                <div class="form-group">
                                   <select class="form-control select2" name="distributor_id" >
                                            <option value="">-Select distributor- </option>
                                            <?php
                                            foreach($dist_bg as $row)
                                           {
                                            $selected = "";
                                            if($row['distributor_id']== @$search_data['distributor_id'])
                                                { 
                                                    $selected='selected';
                                                }
                                            echo '<option value="'.$row['distributor_id'].'">'.$row['distributor_code'].' - ('.$row['agency_name'].')</option>';
                                           }?>
                                   </select>
                                </div>
                            </div>
                        </div>
                          <div class="row">  
                            <div class="col-sm-offset-3 col-md-6">
                                <div class="form-group">
                                    <div class="input-group date-picker input-daterange " data-date-format="dd-mm-yyyy">
                                        <input class="form-control" required name="from_date"  placeholder="From Date" type="text" >
                                        <span class="input-group-addon"> to </span>
                                            <input class="form-control" required name="to_date" placeholder="To Date" type="text">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-offset-3 col-md-6">
                                <div class="form-group">
                                    <select name="status" class="form-control" >
                                        <option value="">Select Status</option>
                                        <option value="1">Active</option>
                                        <option value="2">Inactive</option>
                                    </select>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row">  
                            <div class="form-actions col-md-offset-5 col-md-4">
                                <input type="submit" name="submit" value="submit" class="btn blue">
                                <a type="button" href="<?php echo SITE_URL;?>" class="btn default">Cancel</a>
                            </div>                               
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