<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <form  method="post" action="<?php echo SITE_URL.'daily_oil_report'?>">
                       <div class="row ">  
                            <div class="col-md-offset-3 col-md-6 well"> 
                                <?php if(get_ses_block_id() ==1){?>
                                <div class="row ">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Plant Name <span class="font-red required_fld">*</span></label> 
                                                <div class="col-md-7">
                                                    <select class="form-control" required name="plant_id" >
                                                        <option value="">Select Plant</option>
                                                        <?php   
                                                        foreach(@$plants as $row)
                                                        {
                                                            echo "<option value=".@$row['plant_id']." >".@$row['name']."</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                
                                </div><br> 
                                <?php }?>  
                                <div class="row ">
                                    <div class="col-md-12">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Report Date <span class="font-red required_fld">*</span></label> 
                                                <div class="col-md-7">                                            
                                                    <input class="form-control date-picker" required data-date-format="dd-mm-yyyy" placeholder="Report Date" type="text"  required value="<?php echo date('d-m-Y');?>" name="report_date" />    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><br>                         
                                <div class="form-group">
                                    <div class="col-md-4"></div>
                                        <div class="col-md-8">
                                            <input type="submit" class="btn blue tooltips" value="Print" name="submit">
                                            <a href="<?php echo SITE_URL;?>" class="btn default">Cancel</a>
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