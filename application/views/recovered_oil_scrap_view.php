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
                        <form id="recovered_oil_scarp_form" method="post" action="<?php echo $form_action;?>" class="form-horizontal">
                            <?php
                            if($flg==2)
                            {
                                ?>
                                <input type="hidden" name="encoded_id" value="<?php echo cmm_encode($recovered_oil_scarp_row['oil_scrap_id']);?>">
                                <?php
                            }
                            ?>

                           <div class="form-group">
                                    <label class="col-md-3 control-label">Loose Oil <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-5">
                                       <div class="input-icon right">
                                            <i class="fa"></i>
                                            <select class="form-control loose_oil_id" name="loose_oil" >
                                                <option value="">-Select Loose Oil- </option>
                                                <?php foreach($plant_recovery_oil as $oil)
                                                {
                                                    echo '<option value="'.$oil['loose_oil_id'].'" >'.$oil['name'].'</option>';
                                                }?>
                                            </select>
                                         </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">On Date <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-5">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control date-picker" placeholder="Date" name="on_date" value="" data-date-format="dd-mm-yyyy" type="text" >
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Available Quantity <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-5">                                            
                                        <p class="form-control-static previous_oil_weight"><b>--</b></p>
                                         <input type="hidden" name="available_qty"   value="" class="form-control available_qty">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Oil Scrap <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-5">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <input class="form-control oil_weight numeric" maxlength="6" placeholder="oil weight(in kgs)" name="oil_weight" type="text" >
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-md-3 control-label">Remarks</label>
                                    <div class="col-md-5">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <textarea class="form-control "  name="remarks" value=""  type="text" ></textarea>
                                        </div>
                                    </div>
                                </div>

                    <div class="form-actions">
                        <div class="row">
                            <div class="col-md-offset-5 col-md-6">
                                <button type="submit" value="1" class="btn blue">Submit</button>
                                <a href="<?php echo SITE_URL.'oil_scrap';?>" class="btn default">Cancel</a>
                            </div>
                        </div>  
                    </div>     
        
                   
                  </form>
                        <?php
                    }
                    if(isset($display_results)&&$display_results==1)
                    {
                    ?>
                        <form method="post" action="<?php echo SITE_URL.'oil_scrap'?>">
                            <div class="row">
                             <div class="col-sm-3">
                                    <div class="form-group">
                                       <?php echo form_dropdown('loose_oil',$loose_oil,@$search_data['loose_oil_id'],'class="form-control"');?>
                                    </div>
                                </div> 

                                <div class="col-sm-3">
                                        <div class="input-group date-picker input-daterange " data-date-format="dd-mm-yyyy">
                                        <input class="form-control " name="from_date"  placeholder="From" type="text" <?php if($search_data['from_date']!='') { ?> value="<?php echo date('d-m-Y',strtotime(@$search_data['from_date']));?>" <?php } ?> >
                                        <span class="input-group-addon"> to </span>
                                        <input class="form-control " name="to_date"  placeholder="To" type="text" <?php if($search_data['to_date']!='') { ?> value="<?php echo date('d-m-Y',strtotime(@$search_data['to_date']));?>" <?php } ?> >
                                    </div>
                                </div>
                                 <div class=" col-sm-6">
                                    <div class="form-actions">
                                        <button type="submit" name="search_recovered_oil_scarp" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                        
                                        <a  class="btn blue tooltips" href="<?php echo SITE_URL.'oil_scrap';?>" data-original-title="Reset"> <i class="fa fa-refresh"></i></a>
                                        <a href="<?php echo SITE_URL.'add_recovered_oil_scrap';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                        
                                    </div>
                                </div>
                           
                        </div>
                        </form>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                        <th>Loose Oil</th>
                                        <th>Date</th>
                                        <th>Weight</th>
                                        <th>Remarks</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if($recovered_oil_scarp_row){
                                        foreach($recovered_oil_scarp_row as $row){
                                    ?>  
                                        <tr>
                                            <td> <?php echo $sn++;?></td>
                                            <td> <?php echo $row['oil_name'];?> </td>
                                            <td> <?php echo date('d-m-Y',strtotime($row['date']));?> </td>
                                            <td> <?php echo $row['oil_weight'];?> </td>
                                            <td> <?php echo $row['remarks'];?> </td>
                                            
                                        </tr>
                                        <?php       
                                        }   
                                    }
                                    else
                                    {
                                    ?>
                                        <tr><td colspan="8" align="center"> No Records Found</td></tr>
                                        <?php
                                    }
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