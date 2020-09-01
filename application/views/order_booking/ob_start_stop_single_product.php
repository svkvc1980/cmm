<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                
                <div class="portlet-body">
                    <div class="col-md-offset-1 col-md-10">
                        <form id="ob_form" method="post" action="<?php echo $form_action;?>" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                <label class="col-sm-5 control-label">Select product to START/STOP Order bookings?<span class="font-red required_fld">*</span></label>
                                    <div class="col-sm-3">
                                        <?php echo form_dropdown('loose_oil',$loose_oil,@$oil_tanker_row['loose_oil_id'],'class="form-control" required ');?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-sm-5 control-label">what should be the future for above product</label>
                                    <div class="col-sm-3">
                                            <select name="value" class="form-control type_id" required="required">
                                        <option value="">-Select-</option>
                                        <option value="2">Stop OBs</option>
                                        <option value="1">Start OBs</option> 
                                        </select>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="form-group">
                                <div class="col-md-offset-5 col-md-4">
                                    <button class="btn blue" type="submit" name="submit" value="button"><i class="fa fa-check"></i> Submit</button>
                                    <a class="btn default" href="<?php echo SITE_URL;?>ob_booking_for_single_product"><i class="fa fa-times"></i> Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        
                                        <th>Loose Oil Name</th>
                                        <th>OB Status</th>
                                    </tr>
                                    <tbody>
                                        <?php
                                            if($oil_results)
                                            {
                                                foreach($oil_results as $row)
                                                {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $row['name'] ?> </td>
                                                        <td><?php echo ($row['ob_status']==1)?"ON":"OFF";?></td>
                                                    </tr> <?php
                                                }
                                            }
                                        ?>
                                    </tbody>
                                </thead>
                            </table>
                        </div>

                  </div>
            </div>
        </div>
    </div>
</div>  
<?php $this->load->view('commons/main_footer', $nestedView); ?>
