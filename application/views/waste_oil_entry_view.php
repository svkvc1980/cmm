 <?php $this->load->view('commons/main_template', $nestedView); ?>

 <!-- BEGIN PAGE CONTENT INNER -->
 <div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
              <div class="portlet-body">
              <?php
                if(isset($flag))
                {
                    ?> 
                      <form id="waste_oil_form" class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL.'insert_waste_oil';?>">
                        <div class="form-group">
                        <label for="inputName" class="col-sm-4 control-label">loose oil <span class="font-red required_fld">*</span></label>
                            <div class="col-sm-5">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <select class="form-control" name="loose_oil">
                                        <option selected value="">-Select loose oil-</option>
                                        <?php 
                                            foreach($loose_oil as $row)
                                            {   
                                               $selected='';
                                               if($row['loose_oil_id']==@$loose_oil_id)
                                                $selected='selected';
                                                echo '<option value="'.$row['loose_oil_id'].'"'.$selected.'>'.$row['name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        <label for="inputName" class="col-sm-4 control-label">quantity<span class="font-red required_fld">*</span></label>
                            <div class="col-sm-5">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input type="text" class="form-control numeric" placeholder="quantity in Kgs" name="quantity" id="quantity">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                        <label for="inputName" class="col-sm-4 control-label">remarks</label>
                            <div class="col-sm-5">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <textarea class="form-control" placeholder="remarks" name="remarks" value="" id="remarks"></textarea>
                                </div>
                            </div>
                        </div>
                            <div class="form-group">
                                <div class="col-sm-offset-4 col-sm-10">
                                <input type="submit" name="submit"  class="proceed btn green">
                                <a type="button" href="<?php echo SITE_URL.'waste_oil';?>" class="btn default">Cancel</a>
                                </div>
                            </div>
                    </form>
                      <?php
                        } 
                        if(isset($display_results)&&$display_results==1)
                         {?>
                        <form method="post" action="<?php echo SITE_URL.'waste_oil'?>">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
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
                                    <div class="col-sm-3">
                                        <div class="form-actions">
                                            <button type="submit" name="search_waste_oil" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                            <button type="submit" href="<?php echo SITE_URL.'waste_oil';?>" name="reset_waste_oil" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="reset"><i class="fa fa-refresh"></i></button>
                                            <a href="<?php echo SITE_URL.'view_waste_oil';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="table-scrollable">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th> S.NO</th>
                                            <th>Loose Oil Name </th>
                                            <th>On Date</th>
                                            <th>quantity</th>
                                            <th>Remarks</th>         
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if($waste_oil_results){
                                        foreach($waste_oil_results as $row){
                                    ?>
                                        <tr>
                                            <td> <?php echo $sn++;?></td>
                                            <td> <?php echo $row['oil_name'];?> </td>
                                            <td> <?php echo date('d-m-Y',strtotime($row['created_time'])); ?> </td>
                                           <td> <?php echo $row['quantity'];?> </td>
                                           <td> <?php echo $row['remarks'];?> </td>
                                        </tr>
                                    <?php
                                        }
                                    }
                                    else {
                                        ?>
                                         <tr><td colspan="8" align="center">NO Records Found</td></tr>
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
        </div>
    </div>
 </div>
 <?php $this->load->view('commons/main_footer', $nestedView); ?>