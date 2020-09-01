<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <form id="wet_cartons_entry_form" method="post" action="<?php echo SITE_URL.'insert_wet_carton';?>" class="form-horizontal">
                        <div class="row ">  
                            <div class="col-md-offset-3 col-md-5"> 
                                    
                                    <div class="form-group">
                                            <label class="col-md-5 control-label" for="form-field-1">Date </label>
                                            <div class="col-md-6">
                                                <input class="form-control date-picker" placeholder="Date" name="on_date" data-date-format="dd-mm-yyyy" type="text"  />
                                            </div>
                                        </div>                         
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Unit</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static "><b><?php echo $plant_name ;?></b></p>
                                            <input class="form-control" name="unit" value="<?php echo $plant_name;?>"  type="hidden">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Product<span class="font-red required_fld">*</span></label>
                                        <div class="col-md-6">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                            <select name="product_id" class="form-control">
                                                <option value="">-Select Product-</option>
                                                <?php 
                                                    foreach($product as $pro)
                                                    {
                                                        $selected = '';
                                                        if($pro['product_id'] ==@$product_id ) $selected = 'selected';
                                                        echo '<option value="'.$pro['product_id'].'" '.$selected.'>'.$pro['name'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">No of Cartons<span class="font-red required_fld">*</span></label>
                                        <div class="col-md-6">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                           <input type="text" name="quantity" maxlength="15" class="form-control numeric">
                                        </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-4"></div>
                                            <div class="col-md-8">
                                                <input type="submit" class="btn blue tooltips"  onclick="return confirm('Are you sure you want to Submit Wet Cartons Entry?')"  value="submit" name="submit">
                                                <a href="<?php echo SITE_URL;?>" class="btn default">Cancel</a>
                                            </div>                                 
                                    </div>
                            </div>
                        </div>
                        
                    </form> 
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>                