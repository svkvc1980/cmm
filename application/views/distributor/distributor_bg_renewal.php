<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <form role="form" id="myform" class="form-horizontal" method="post" action="<?php echo SITE_URL;?>view_distributor_bg_renewal">
                        <div class="row">
                          <div class="col-sm-offset-2 col-sm-8 well">

                           <div class="form-group">
                                <label class="col-md-3 control-label">Choose Distributor </label>
                                <div class="col-md-8">
                                    <div class="input-icon right">
                                        <select class="form-control select2" name="distributor_id" >
                                            <option value="">-Select distributor- </option>

                                            <?php
                                            foreach($distributor_list as $dis)
                                            {
                                                echo '<option value="'.$dis['distributor_id'].'">'.$dis['distributor_code'].' - ('.$dis['agency_name'].')</option>';
                                            }?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <div class="col-sm-offset-5 col-sm-5">
                                    <button type="submit" title="Submit" name="submit" value="submit" class="btn blue submit">Submit</button>
                                    <a title="Cancel" href="<?php echo SITE_URL.'';?>" class="btn default">Cancel</a>
                                </div>
                            </div>
                        </div>
                        </div>    
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>  
<?php $this->load->view('commons/main_footer', $nestedView); ?>
