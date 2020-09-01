 <?php $this->load->view('commons/main_template', $nestedView); ?>

 <!-- BEGIN PAGE CONTENT INNER -->
 <div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
              <div class="portlet-body">
                <form id="" class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL.'print_product_wise_pending_do';?>">
                  <div class="form-group">
                        <label form="inputName" class="col-sm-4 control-label">Date: <span class="font-red required_fld">*</span></label>
                            <div class="col-sm-5">
                            <div class="input-group input-large date-picker input-daterange" data-date-format="dd-mm-yyyy">
                                    <input type="text" class="form-control" name="from_date" placeholder="From Date"  value="<?php echo date('d-m-Y');?>">
                                    <span class="input-group-addon"> to </span>
                                    <input type="text" class="form-control" name="to_date" placeholder="To Date"   required value="<?php echo date('d-m-Y');?>"> 
                                </div>
                            </div>
                       </div>
                       <div class="form-group">
                        <label form="inputName" class="col-sm-4 control-label">Unit <span class="font-red required_fld">*</span></label>
                            <div class="col-sm-4">
                                    <select class="form-control" required name="lifting_point_id">
                                        <option value="">- Select Lifting Point -</option>
                                        <?php foreach ($lifting_points as  $block_id=>$value) {?>
                                            <optgroup label="<?php echo $value['block_name'];?>">
                                            <?php foreach ($value['plants'] as $key=>$row) {
                                                $selected = "";
                                                if($row['plant_id']== @$search_data['lifting_point_id'])
                                                    { 
                                                        $selected='selected';
                                                    }
                                                echo '<option value="'.$row['plant_id'].'" '.$selected.' >'.$row['plant_name'].'</option>';
                                                
                                             } 
                                                ?></optgroup><?php
                                            }?>
                                    </select>
                            </div>
                        </div>
                            <div class="form-group">
                                <div class="col-sm-offset-5 col-sm-7">
                                <input type="submit" name="print_product_wise_pending_do" value="Submit"  class="proceed btn green">
                                <a type="button" href="<?php echo SITE_URL.'home';?>" class="btn default">Cancel</a>
                                </div>
                            </div>
                     </form>

                 </div>
              </div>
            </div>
         </div>
        </div>
         <?php $this->load->view('commons/main_footer', $nestedView); ?>