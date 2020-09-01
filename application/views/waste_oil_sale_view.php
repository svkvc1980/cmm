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
                        ?>
                            <form id="waste_oil_sale_form" method="post" action="<?php echo $form_action;?>"  autocomplete="on" class="form-horizontal">
                             <input type="hidden" value="<?php echo $plant_id;?>" name="plant_id">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Buyer Name<span class="font-red required_fld">*</span></label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input  class="form-control" type="text" name="buyer_name">  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">On Date<span class="font-red required_fld">*</span></label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input  class="form-control date-picker" type="text" name="on_date">  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Mobile<span class="font-red required_fld">*</span></label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input  class="form-control numeric" minlength="6" maxlength="12" type="text" name="mobile">  
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Address<span class="font-red required_fld">*</span></label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <textarea class="form-control" style="width: 250px; height: 30px;"></textarea>   
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Loose Oil<span class="font-red required_fld">*</span></label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                   <i class="fa"></i>
                                                     <select  name="loose_oil_id" class="form-control loose_oil_id">
                                                      <option value="">-Select Loose Oil-</option>
                                                        <?php 
                                                         foreach($plant_recovery_oil as $row)
                                                         {
                                                            echo '<option value="'.$row['loose_oil_id'].'">'.$row['name'].'</option>';
                                                         }
                                                         ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Available Quantity<span class="font-red required_fld">*</span></label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <p class="old_quantity" name="old_quantity"><b>--</b></p> 
                                                    <input class="form-control available_qty" type="hidden" name="old_quantity">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Selling Quantity<span class="font-red required_fld">*</span></label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <input class="form-control oil_weight numeric" type="text" maxlength="6" name="quantity">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Cost<span class="font-red required_fld">*</span></label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                   <input class="form-control numeric" type="text" maxlength="6" name="cost">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="col-md-4 control-label">Remarks</label>
                                            <div class="col-md-6">
                                                <div class="input-icon right">
                                                    <i class="fa"></i>
                                                    <textarea class="form-control" name="remarks"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-offset-5 col-md-6">
                                            <button type="submit" name="submit" value="1" class="btn blue">Submit</button>
                                            <a href="<?php echo SITE_URL.'waste_oil_sale';?>" class="btn default">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        <?php
                    }
                    if(isset($display_results)&&$display_results==1)
                    {
                    ?>
                        <form method="post" action="<?php echo SITE_URL.'waste_oil_sale'?>">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <input class="form-control" name="buyer_name" value="<?php echo @$search_data['buyer_name'];?>" placeholder="Buyer Name" type="text">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="From Date" type="text"  value="<?php if(@$search_data['from_date']!=''){echo date('d-m-Y',strtotime(@$search_data['from_date']));}?>" name="from_date" />    
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <input class="form-control date-picker" data-date-format="dd-mm-yyyy" placeholder="To Date" type="text" value="<?php if(@$search_data['to_date']!=''){echo date('d-m-Y',strtotime(@$search_data['to_date']));}?>" name="to_date" />    
                                    </div>
                                </div>
                               <div class="col-sm-4">
                                    <div class="form-actions">
                                        <button type="submit" name="search_waste_oil_sale" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                        <a  class="btn blue tooltips" href="<?php echo SITE_URL.'waste_oil_sale';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
                                        <a href="<?php echo SITE_URL.'add_waste_oil_sale';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>                                        
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th> Buyer Name </th>
                                        <th> Mobile</th> 
                                        <th> Address</th> 
                                        <th> On Date</th>
                                        <th> Quantity </th>
                                        <th> Cost</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if($waste_oil_sale_results){

                                    foreach($waste_oil_sale_results as $row){
                                ?>
                                    <tr>
                                        <td> <?php echo $sn++;?></td>
                                        <td> <?php echo $row['buyer_name'];?> </td>
                                        <td> <?php echo $row['contact_details'];?> </td>
                                        <td> <?php echo $row['address'];?> </td>
                                        <td> <?php echo $row['on_date'];?> </td>
                                        <td> <?php echo $row['oil_quantity'];?> </td>
                                        <td> <?php echo $row['oil_cost'];?> </td>
                                       
                                    </tr>
                                <?php
                                    }
                                }
                                else
                                {
                            ?>      <tr><td colspan="6" align="center"> No Records Found</td></tr>      
                        <?php   }
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
