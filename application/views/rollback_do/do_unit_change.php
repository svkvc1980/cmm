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
                      <form id="do_unit_form" method="post" action="<?php echo SITE_URL.'do_unit_details_change';?>"  class="form-horizontal">
                        <div class="row ">  
                            <div class="col-md-offset-3 col-md-5"> 
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Enter DO Number</label>
                                    <div class="col-md-7">
                                        <input type="text" name="do_no" class="form-control numeric"> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-5"></div>
                                        <div class="col-md-6">
                                            <input type="submit" class="btn blue tooltips"  value="Proceed" name="submit">
                                            <a href="<?php echo SITE_URL.'do_unit_change';?>" class="btn default">Cancel</a>
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
                       <form id="do_unit_form" method="post" action="<?php echo SITE_URL.'insert_do_unit_change';?>" class="form-horizontal">
                            
                            <input type="hidden" name="existing_lifting_point" value="<?php echo $do_list[0]['plant_name']; ?>"> 
                            <input type="hidden" name="existing_do_number" value="<?php echo $do_list[0]['do_number']; ?>">
                            <input type="hidden" name="do_number" value="<?php echo $do_list[0]['do_number'] ;?>" > 
                            <input type="hidden" name="do_id" value="<?php echo $do_list[0]['do_id'] ;?>" > 
                            <input type="hidden" name="lifting_point" value="<?php echo $do_list[0]['lifting_point'] ;?>" > 
                            <input type="hidden" name="receiving_plant_id" value="<?php echo @$do_list[0]['receiving_plant_id'] ;?>" >
                            <input type="hidden" name="distributor_code" value="<?php echo @$do_list[0]['distributor_code'] ;?>" > 
                            <input type="hidden" name="distributor_id" value="<?php echo @$do_list[0]['distributor_id'] ;?>" > 
                            <input type="hidden" name="ob_type" value="<?php echo $do_list[0]['ob_type'] ;?>" > 
                            <input type="hidden" name="do_date" value="<?php echo $do_list[0]['do_date'] ;?>" > 
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">DO Number :</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo $do_list[0]['do_number'] ;?></b>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">DO Date :</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo  date('d-m-Y', strtotime($do_list[0]['do_date']));?></b>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="row">   
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <?php if($do_list[0]['ob_type'] == 1){ ?>
                                            <label class="col-md-4 control-label">Distributor :</label>
                                        <div class="col-md-6">
                                             <b class="form-control-static"><?php echo  $do_list[0]['distributor_name'].'['.$do_list[0]['distributor_code'].']';?></b>
                                        </div>

                                    <?php } else
                                           { ?>  
                                                <label class="col-md-4 control-label">plant  :</label>
                                        <div class="col-md-6">
                                             <b class="form-control-static"><?php echo  get_plant_name_not_in_session($do_list[0]['receiving_plant_id']);?></b>
                                        </div>

                                     <?php } ?>
                                        

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-md-4 control-label">Lifting Point :</label>
                                        <div class="col-md-6">
                                            <b class="form-control-static"><?php echo  get_plant_name_not_in_session($do_list[0]['lifting_point']);?></b>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-md-offset-3 col-md-5">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Select New Lifting Point</label>
                                        <div class="col-md-7">
                                            <select  class="form-control select2" required name="new_lifting_point">
                                                <option selected value="">-Select Lifting Point-</option>
                                                <?php 
                                                    foreach($ops_list as $row)
                                                    {
                                                        echo '<option value="'.$row['plant_id'].'" '.$selected.' >'.$row['plant_name'].'</option>'; 
                                                        
                                                    }
                                                ?>
                                            </select> 
                                        </div>
                                    </div>    
                                </div> 

                            </div>
                            <div class="row ">
                                <div class="col-md-2"></div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Remarks</label>
                                        <div class="col-md-7">
                                            <textarea name="remarks" class="form-control" required></textarea>
                                        </div>
                                    </div>
                                </div>    
                            </div>
                            <div class="table">
                            <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th> S.No </th>
                                    <th> Product</th>
                                    <th> Ordered Qty </th>
                                    <th> Pending Qty</th>
                                    <th> Price</th>
                                    <th> Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1;
                                $total=0;
                                if($do_list)
                                {  
                                    foreach($results as $key => $value)
                                    { 
                                        $amount = $value['do_qty']*$value['items_per_carton']*$value['product_price'];
                                        $total+=$amount;
                                ?>
                                    <tr>
                                        <td width="10%"> <?php echo $i++;?> </td>
                                        <td width="15%"> <?php echo $value['product_name'];?> </td>
                                        <td width="15%"> <?php echo $value['do_qty'];?> </td>
                                        <td width="15%"> <?php echo $value['pending_qty'];?> </td>
                                        <td width="15%"> <?php echo $value['product_price'];?> </td>
                                        <td width="10%"> <?php echo $amount;?> </td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="6" align="right">Total Amount:<strong><?php echo $total; ?></strong></td>
                                    </tr><?php
                                } 
                                else 
                                {
                                ?>  
                                    <tr><td colspan="7" align="center"><span class="label label-primary">No Records</span></td></tr>
                                <?php   
                                } ?>
                            </tbody>
                        </table>
                        </div>
                                <div class="row">
                                    <div class="col-md-offset-5 col-md-6">
                                        <button type="submit" class="btn blue"  name="submit">Submit</button>
                                        <a href="<?php echo SITE_URL.'do_unit_change';?>" class="btn default">Cancel</a>
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