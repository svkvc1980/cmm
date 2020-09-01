 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                
                <div class="portlet-body">
                    <form method="post" action="<?php echo SITE_URL.'print_c_and_f_cd_report'?>">
                        <div class="row">
                            <div class="col-sm-offset-3 col-md-5">
                                <div class="form-group">
                                   <select class="form-control" name="plant_id" >
                                            <option value="">-Select C and F- </option>
                                            <?php
                                            foreach($plant_list as $dis)
                                            { 
                                                echo '<option value="'.$dis['plant_id'].'">'.$dis['name'].'</option>';
                                            }?>
                                         </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-offset-3 col-md-5">
                                <div class="form-group">
                                    <select class="form-control" name="type_id">
                                        <option value="">Select Type</option>
                                        <option value="1" <?php if(@$search_params['note_type']==1){?>selected <?php } ?> >Credit</option>
                                        <option value="2" <?php if(@$search_params['note_type']==2){?>selected <?php } ?> >Debit</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">  
                            <div class="col-sm-offset-3 col-md-5">
                                <div class="form-group">
                                    <div class="input-group date-picker input-daterange " data-date-format="dd-mm-yyyy">
                                        <input class="form-control" required name="from_date"  placeholder="From Date" type="text" >
                                        <span class="input-group-addon"> to </span>
                                            <input class="form-control" required name="to_date" placeholder="To Date" type="text">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">  
                            <div class="form-actions col-md-offset-4 col-md-4">
                                <input type="submit" name="submit" value="Submit" class="btn green">
                                <a type="button" href="<?php echo SITE_URL;?>" class="btn default">Cancel</a>
                                <button type="submit" name="download_c_and_f_cd_report" value="download" formaction="<?php echo SITE_URL.'download_c_and_f_cd_report';?>" class="btn blue"><i class="fa fa-cloud-download"></i>Download</button>
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