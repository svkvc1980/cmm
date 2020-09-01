 <?php $this->load->view('commons/main_template', $nestedView); ?>

 <!-- BEGIN PAGE CONTENT INNER -->
 <div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
              <div class="portlet-body">
                <form id="" class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL.'view_exec_dist_list';?>">
                  <div class="form-group">
                        <label form="inputName" class="col-sm-4 control-label">Date: <span class="font-red required_fld">*</span></label>
                            <div class="col-sm-5">
                            <div class="input-group input-large date-picker input-daterange" data-date-format="dd-mm-yyyy">
                                    <input type="text" class="form-control" name="from_date" placeholder="From Date" required>
                                    <span class="input-group-addon"> to </span>
                                    <input type="text" class="form-control" name="to_date" placeholder="To Date"   required> 
                                </div>
                            </div>
                       </div>
                       <div class="form-group">
                        <label form="inputName" class="col-sm-4 control-label">Executive <span class="font-red required_fld">*</span></label>
                            <div class="col-sm-4">
                                    <select class="form-control" required name="executive">
                                        <option selected value="">-Executive-</option>
                                        <?php 
                                           foreach($executive_list as $row)
                                            {
                                                $selected = "";
                                                if($row['executive_id']== @$search_data['executive_id'] )
                                                    { 
                                                        $selected='selected';
                                                    }
                                                echo '<option value="'.$row['executive_id'].'" '.$selected.' >'.$row['executive_code'].' - ('.$row['name'].')</option>';
                                            }
                                        ?>
                                    </select>
                            </div>
                        </div>
                            <div class="form-group">
                                <div class="col-sm-offset-5 col-sm-7">
                                <input type="submit" name="submit"  class="proceed btn green">
                                <a type="button" href="<?php echo SITE_URL.'exec_wise_dist_list';?>" class="btn default">Cancel</a>
                                </div>
                            </div>
                     </form>

                 </div>
              </div>
            </div>
         </div>
        </div>
         <?php $this->load->view('commons/main_footer', $nestedView); ?>