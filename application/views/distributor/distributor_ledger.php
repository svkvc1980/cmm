 <?php $this->load->view('commons/main_template', $nestedView); ?>
<?php
// Current Financial Year Start Date
$year = (date('m')>=4)?date('Y'):(date('Y')-1);
$fy_start_date = '01-04-'.$year;
?>
 <!-- BEGIN PAGE CONTENT INNER -->
 <div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
              <div class="portlet-body">
                <form id="" class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL.'print_distributor_ledger';?>">
                  <div class="form-group">
                        <label form="inputName" class="col-sm-4 control-label">Date: <span class="font-red required_fld">*</span></label>
                            <div class="col-sm-5">
                            <div class="input-group input-large date-picker input-daterange" data-date-format="dd-mm-yyyy">
                                    <input type="text" class="form-control" required name="from_date" placeholder="From Date"  value="<?php echo $fy_start_date;?>">
                                    <span class="input-group-addon"> to </span>
                                    <input type="text" class="form-control" name="to_date" placeholder="To Date"   required value="<?php echo date('d-m-Y');?>"> 
                                </div>
                            </div>
                       </div>
                       <?php
                       $block_id = get_sess_data('block_id');
                       if($block_id==5)
                       {
                        ?> 
                          <input type="hidden" name="distributor_id" value="<?php echo get_sess_data('distributor_id')?>">
                        <?php
                       }
                       else
                       {
                       ?>
                       <div class="form-group">
                        <label form="inputName" class="col-sm-4 control-label">Distributor <span class="font-red required_fld">*</span></label>
                            <div class="col-sm-4">
                                    <select class="form-control select2" required name="distributor_id">
                                        <option value="">Select Distributor</option>
                                        <?php
                                        foreach ($distributors as $drow) {
                                          echo '<option value="'.$drow['distributor_id'].'">'.$drow['distributor_code'].' - ('.$drow['agency_name'].')</option>';
                                        }
                                        ?>
                                    </select>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                            <div class="form-group">
                                <div class="col-sm-offset-5 col-sm-7">
                                <input type="submit" name="print_dist_ledger" value="Submit"  class="proceed btn green">
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