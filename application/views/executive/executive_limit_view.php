<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-6">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <form id="ob_form" method="post" action="<?php echo SITE_URL;?>executive_limit" class="form-horizontal">
                        <div class="form-group"  style="text-align:center;">                                        
                            <div class="col-md-offset-1 col-md-8"> 
                                <p class="form-control-static" style="text-align: center;"> At present limit for Executives are : <b style="color:#3A8ED6;"><?php echo ($exe_limit_status==1)?"ON":"OFF";?></b></p>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-offset-1 col-md-8">                 
                                <div class="form-group">
                                    <label class="col-sm-6 control-label">Executive Limit Status</label>
                                    <div class="col-sm-6">
                                        <div class="input-icon right">  
                                           <select name="status" class="form-control type_id" required="required">
                                                <option value="">Select Status</option>
                                                <option value="1">ON</option>
                                                <option value="2">OFF</option>       
                                           </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-offset-6 col-md-12">
                                        <button class="btn blue" type="submit" name="submit" value="1"><i class="fa fa-check"></i> Submit</button>
                                        <a class="btn default" href="<?php echo SITE_URL;?>executive_limit"><i class="fa fa-times"></i> Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <div class="row">
                        <form role="form" id="role_page_map" class="form-horizontal" method="post" action="<?php echo SITE_URL;?>executive_limit">
                            <input type="hidden" name="action" value="1">
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Executives</label>
                                <div class="col-sm-4">
                                    <select name="executive" class="form-control" onchange="this.form.submit()" id="">
                                        <option value="">Select Executive</option>
                                        <?php
                                        foreach ($executive as $rrow)
                                        {
                                            $selected = ($executive_id == $rrow['executive_id'])?'selected':'';
                                            echo '<option value="'.$rrow['executive_id'].'" '.$selected.'>'.$rrow['name'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php
                            if($executive_id>0)
                            {
                            ?>
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-5">
                                    <button type="submit" title="Submit" formaction="submit_executive_limit" name="save_changes" value="1" class="btn blue">Save Changes</button>
                                    <a title="Cancel" href="<?php echo SITE_URL.'executive_limit';?>" class="btn default">Cancel</a>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="table-scrollable">
                                    <table class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th><strong>S.No</strong></th>
                                                <th><strong>Loose Oil</strong></th>
                                                <th><strong>Limit (M.T)</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php $i=1;
                                            if(count(@$loose_oil)>0)
                                            {
                                                foreach(@$loose_oil as $row)
                                                {?>
                                                    <tr>
                                                        <td><?php echo $i++ ?></td>
                                                        <td><?php echo @$row['name'];?></td>
                                                        <?php $res=@$results[@$row['loose_oil_id']][$exe_id]; ?>
                                                        <td><input type="textbox" style="width: 80px" class="form-control numeric xs-box" name="limit[<?php echo @$row['loose_oil_id']?>]" placeholder="&nbsp;Limit" value="<?php if(@$results[@$row['loose_oil_id']][$exe_id]!='') {echo number_format($res,3); } else {echo '0.000';} ?>"></td>
                                                    </tr>
                                        <?php   }
                                            }
                                            else 
                                            {?>  
                                                <tr><td colspan="2" align="center"><span class="label label-primary">No Records</span></td></tr>
                                    <?php   } ?>
                                        </tbody>
                                    </table>
                                </div>   
                            </div>
                            <?php
                            }
                            ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>  
<?php $this->load->view('commons/main_footer', $nestedView); ?>
