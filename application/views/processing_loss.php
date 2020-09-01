 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <?php
                    if(@$flag==1)
                    {
                    ?>
                    <form method="post" class="form-horizontal" action="<?php echo $form_action?>">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                <label class="col-md-5 control-label">Loose Oil <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="loose_oil" required>
                                          <option value="">- Select Loose Oil -</option>
                                          <?php
                                                foreach($loose_oil as $row)
                                                {                                                    
                                                   echo '<option value="'.$row['loose_oil_id'].'">'.$row['name'].'</option>';
                                                }
                                            ?>
                                      </select> 
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">   
                            <div class="col-md-8">
                                <div class="form-group">
                                <label class="col-md-5 control-label">Date <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <?php echo date('d-m-Y');?>
                                        <input type="hidden" name="date" value="<?php echo date('d-m-Y');?>">
                                        <!-- <input class="form-control date-picker" required data-date-format="dd-mm-yyyy" value="" type="text" name="date" placeholder="Enter Date">   -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">    
                            <div class="col-md-8">
                                <div class="form-group">
                                <label class="col-md-5 control-label">Quantity (Kgs) <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <input class="form-control" value="" required type="text" name="quantity" placeholder="Enter Quantity">  
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-offset-5 col-md-6">
                                <button type="submit" value="1" name="submit" class="btn blue">Submit</button>
                                <a href="<?php echo SITE_URL.'processing_loss';?>" class="btn default tooltips" data-container="body" data-placement="top" data-original-title="Back">Back</a>
                            </div>
                        </div>
                    </form>    
                    <?php
                    }
                    if(isset($display_results)&&$display_results==1)
                    {
                    ?>
                        <form method="post" action="<?php echo SITE_URL.'processing_loss'?>">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="input-group date-picker input-daterange" data-date-format="dd-mm-yyyy">
                                        <input class="form-control" name="from_date" placeholder="From Date" type="text" value="<?php echo @$search_data['from_date'];?>">
                                            <span class="input-group-addon"> to </span>
                                        <input class="form-control" name="to_date" placeholder="To Date" type="text" value="<?php echo @$search_data['to_date'];?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-control" name="loose_oil">
                                      <option value="">- Select Loose Oil -</option>
                                      <?php
                                            foreach($loose_oil as $row)
                                            {              
                                                $selected = (@$row['loose_oil_id']==@$search_data['loose_oil'])?'selected="selected"':'';
                                                echo '<option value="'.$row['loose_oil_id'].'" '.$selected.'>'.$row['name'].'</option>';
                                            }
                                        ?>
                                  </select> 
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-actions">
                                        <button type="submit" name="search_pro_loss" value="1" class="btn blue btn-sm tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                        <a href="<?php echo SITE_URL.'processing_loss';?>" class="btn blue btn-sm tooltips" data-container="body" data-placement="top" data-original-title="Refresh"><i class="fa fa-refresh"></i></a>
                                        <a href="<?php echo SITE_URL.'add_processing_loss';?>" class="btn blue btn-sm tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                        
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th> Loose Oil </th>
                                        <th> On Date </th>
                                        <th> Quantity (Kgs) </th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php

                                if($processing_loss){

                                    foreach($processing_loss as $row){
                                ?>
                                    <tr>
                                        <td> <?php echo $sn++;?></td>
                                        <td> <?php echo $row['loose_oil'];?> </td>
                                        <td> <?php echo format_date($row['on_date']);?> </td>
                                        <td align="right"> <?php echo qty_format($row['quantity']); ?></td>
                                    </tr>
                                <?php
                                    }
                                }
                                else
                                {
                            ?>      <tr><td colspan="4" align="center"> No Records Found</td></tr>      
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