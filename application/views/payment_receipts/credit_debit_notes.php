<?php $this->load->view('commons/main_template', $nestedView); ?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit">                
                <div class="portlet-body">
                 <form id="credit_debit_form" method="post" action="<?php SITE_URL;?>insert_credit_debit" class="form-horizontal">
                   <div class="row">        
                          <div class="form-group">
                             <label class="col-md-4 control-label">Distributor:</label>
                              <div class="col-md-5">
                                  <div class="input-icon right">
                                  <i class="fa"></i>
                                  <select class="form-control select2" name="distributor_id" >
                                    <option value="">-Select distributor- </option>
                                    <?php
                                    foreach($distributor as $dis)
                                    {  
                                        $selected = "";
                                        if($dis['distributor_id'] == $distributor_payment_row['distributor_id']){ $selected = "selected"; }
                                        echo '<option value="'.$dis['distributor_id'].'" '.$selected.'>'.$dis['distributor_code'].' - ('.$dis['agency_name'].')</option>';
                                    }?>
                                 </select>
                                  </div>
                              </div>
                          </div>
                  </div>
                   <div class="row"> 
                          <div class="form-group">
                              <label class="col-md-4 control-label">Amount :</label>
                              <div class="col-md-5">
                                  <div class="input-icon right">
                                      <i class="fa"></i>
                                      <input class="form-control numeric" onkeyup="javascript:this.value=Comma(this.value);" maxlength="25" placeholder="Amount" type="text" name="amount">
                                  </div>
                              </div>
                          </div>
                   </div>
                   <div class="row">           
                          <div class="form-group">
                             <label class="col-md-4 control-label">Date:</label>
                              <div class="col-md-5">
                                  <div class="input-icon right">
                                  <i class="fa"></i>
                                   <input class="form-control date-picker" placeholder="Date" name="on_date" data-date-format="dd-mm-yyyy" type="text" >
                                  </div>
                              </div>
                          </div>
                   </div>
                   <div class="row"> 
                          <div class="form-group">
                              <label class="col-md-4 control-label">type :</label>
                              <div class="col-md-5">
                                  <div class="input-icon right">
                                      <i class="fa"></i>
                                      <select name="note_type" class="form-control type_id">
                                          <option value="">-Select Type-</option>
                                          <option value="1">Credit</option>
                                          <option value="2">Debit</option>    
                                      </select>
                                  </div>
                              </div>
                      </div>
                   </div>
                   <div class="row">            
                          <div class="form-group">
                             <label class="col-md-4 control-label">purpose:</label>
                              <div class="col-md-5">
                                  <div class="input-icon right">
                                  <i class="fa"></i>
                                   <select name="purpose_id" id="purpose_rq" class="form-control purpose_id">
                                    <option value="">-Select Purpose-</option>  
                                </select>
                                  </div>
                              </div>
                          </div>
                    </div>
                   <div class="row"> 
                          <div class="form-group">
                              <label class="col-md-4 control-label">Reason :</label>
                              <div class="col-md-5">
                                  <div class="input-icon right">
                                      <i class="fa"></i>
                                      <textarea class="form-control reason"  cols="2" name="reason"></textarea>
                                  </div>
                              </div>
                          </div>
                  </div>
                  <div class="form-actions">
                     <div class="row">
                      <div class="col-md-offset-5 col-md-6">
                        <button class="btn blue" type="submit" onclick="return confirm('Are you sure you want to Submit.?')" name="submit" value="button"><i class="fa fa-check"></i> Submit</button>
                        <a href="<?php echo SITE_URL.'credit_debit_notes';?>" class="btn default">Cancel</a>
                      </div>
                    </div>  
                   </div>
                </form>
              </div>
            </div>
        </div>
    </div>
</div>  
<?php $this->load->view('commons/main_footer', $nestedView); ?>
