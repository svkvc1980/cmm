<?php $this->load->view('commons/main_template', $nestedView); ?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                <?php if($flag==1) { ?>
                    <form method="post" action="<?php echo SITE_URL.'confirm_leakage_entry';?>" class="form-horizontal leakage_form">
                        <div class="row "> 
                            <div class="col-md-12"> 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-9 control-label">Leakage No :</label>
                                        <div class="col-md-3">
                                            <input class="form-control" name="leakage_number" value="<?php echo $leakage_number;?>"  type="hidden">
                                            <p class="form-control-static"><b><?php echo $leakage_number;?></b></p>
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="col-md-5 control-label">Unit :</label>
                                        <div class="col-md-6">
                                            <p class="form-control-static "><b><?php echo $plant_name ;?></b></p>
                                            <input class="form-control" name="unit" value="<?php echo $plant_name;?>"  type="hidden">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                            <label class="col-md-3 control-label" for="form-field-1">Date </label>
                                            <div class="col-md-6">
                                                <input  name="on_date" data-date-format="dd-mm-yyyy" type="hidden" value="<?php echo date('d-m-Y');?>">
                                                 <p class="form-control-static"><b><?php echo date('d-m-Y'); ?></b></p>
                                            </div>
                                        </div> 
                                </div>
                                
                                
                            </div> 
                            <div class="col-md-offset-3 col-md-6 jumbotron" style="    background-color: rgba(104, 110, 104, 0.04);">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Product <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                            <select name="product_id"  class="form-control product">
                                                <option value="">-Select Product-</option>
                                                <?php 
                                                    foreach($product as $pro)
                                                    {
                                                        $selected = '';
                                                        if($pro['product_id'] ==@$product_id ) $selected = 'selected';
                                                        echo '<option value="'.$pro['product_id'].'" '.$selected.'>'.$pro['product_name'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="items_per_carton" class="form-control items_per_carton">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Cartons Leaked <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                           <input type="text"  name="no_of_cartons" maxlength="15" placeholder="No of Cartons" class="form-control no_of_cartons numeric">
                                        </div>
                                       
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Pouches Leaked <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                           <input type="text" name="no_of_pouches" maxlength="15" placeholder="No of Pouches" class="form-control no_of_pouches numeric">
                                        </div>
                                        <span class="err_pouch"></span>
                                    </div>
                                </div>
                                <div class="col-md-offset-2 col-md-10">
                                    <div class="mt-radio-list">
                                       <label class="mt-radio">Replace Leaked Pouches with New Pouches
                                            <input type="radio" value="1" checked="checked"  name="type" class="type" />
                                            <span></span>
                                        </label>
                                        <label class="mt-radio">Cut Loose Pouches and Pour back in Oil tank
                                            <input type="radio" value="2" name="type" class="type" />
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-md-5 control-label">Recovered Cartons <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                            <input type="text" readonly  name="cartons" placeholder="Cartons" class="form-control numeric cartons">
                                        </div>
                                         <span class="err_cartons"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Recovered Pouches <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                             <input type="text" readonly  name="pouches" placeholder="Pouches" class="form-control numeric pouches">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Recovered Oil <span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                        <i class="fa"></i>
                                           <input type="text" name="recovered_oil" maxlength="15" placeholder="Recovered Oil" class="form-control numeric recovered_oil">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Remarks</label>
                                    <div class="col-md-6">
                                        <div class="input-icon right">
                                            <i class="fa"></i>
                                            <textarea class="form-control" name="remarks" placeholder="remarks"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-4"></div>
                                        <div class="col-md-8">
                                            <input type="submit" class="btn blue tooltips leakage_submit" value="submit" name="submit">
                                            <a href="<?php echo SITE_URL.'leakage_entry';?>" class="btn default">Cancel</a>
                                        </div>                                 
                                </div>
                            </div>
                        </div>
                    </form> 
                    <?php } elseif($flag ==2) { ?>
                         <form method="post" action="<?php echo SITE_URL.'insert_leakage_entry';?>" class="form-horizontal leakage_form">
                         <div class="row ">  
                            <div class="col-md-offset-3 col-md-5">
                                
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Date :</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="on_date" data-date-format="dd-mm-yyyy" value="<?php echo date('Y-m-d');?>">
                                        <p class="form-control-static"><b><?php echo date('d-m-Y');?></b></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Leakage No :</label>
                                    <div class="col-md-6">
                                        <input class="form-control" name="leakage_number" value="<?php echo $dat['leakage_number'];?>"  type="hidden">
                                        <p class="form-control-static"><b><?php echo $dat['leakage_number'];?></b></p>
                                    </div>
                                </div>                            
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Unit :</label>
                                    <div class="col-md-6">
                                        <p class="form-control-static "><b><?php echo $dat['plant_name'] ;?></b></p>
                                        <input class="form-control" name="unit" value="<?php echo $dat['plant_name'];?>"  type="hidden">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Product :</label>
                                    <div class="col-md-6">
                                        <input class="form-control" name="product_id" value="<?php echo $dat['product_id'];?>"  type="hidden">
                                        <p class="form-control-static"><b><?php echo $dat['product_name'];?></b></p>
                                    </div>
                                </div>
                                <input type="hidden" name="items_per_carton" value="<?php echo $dat['items_per_carton'];?>">
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Cartons Leaked :</label>
                                    <div class="col-md-6">
                                        <input class="form-control" name="no_of_cartons" value="<?php echo $dat['no_of_cartons'];?>"  type="hidden">
                                        <p class="form-control-static"><b><?php echo $dat['no_of_cartons'];?></b></p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Pouches Leaked :<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                       <input class="form-control" name="no_of_pouches" value="<?php echo $dat['no_of_pouches'];?>"  type="hidden">
                                       <p class="form-control-static"><b><?php echo $dat['no_of_pouches'];?></b></p> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Type :<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                    <input type="hidden" name="type" value="<?php echo $dat['type'];?>">
                                       <?php if ($dat['type']==1)
                                           {  ?>
                                       <p class="form-control-static"><b><?php echo "Replace Leaked Pouches with New Pouches";?></b></p> 
                                       <?php } else { ?>
                                        <p class="form-control-static"><b><?php echo "Cut Loose Pouches and Pour back in Oil tank";?></b></p>
                                       <?php } ?>
                                    </div>
                                </div> 
                                 <div class="form-group">
                                    <label class="col-md-5 control-label">Recovered Cartons :<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                       <input class="form-control" name="cartons" value="<?php echo $dat['cartons'];?>"  type="hidden">
                                       <p class="form-control-static"><b><?php echo $dat['cartons'];?></b></p> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Recovered Pouches :<span class="font-red required_fld">*</span></label>
                                    <div class="col-md-6">
                                       <input class="form-control" name="pouches" value="<?php echo $dat['pouches'];?>"  type="hidden">
                                       <p class="form-control-static"><b><?php echo $dat['pouches'];?></b></p> 
                                    </div>
                                </div>
                               
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Recovered Oil :</label>
                                    <div class="col-md-6">
                                       <input class="form-control" name="recovered_oil" value="<?php echo $dat['recovered_oil'];?>"  type="hidden">
                                             <p class="form-control-static"><b><?php echo $dat['recovered_oil'];?></b></p> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5 control-label">Remarks :</label>
                                    <div class="col-md-6">
                                       <input class="form-control" name="remarks" value="<?php echo $dat['remarks'];?>"  type="hidden">
                                             <p class="form-control-static"><b><?php echo $dat['remarks'];?></b></p> 
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-3"></div>
                                        <div class="col-md-8">
                                            <input type="submit" class="btn blue tooltips" value="submit" name="submit">
                                            <a href="<?php echo SITE_URL.'leakage_entry';?>" class="btn default">Cancel</a>
                                        </div>                                 
                                </div>
                            </div>
                        </div>
                    </form> 

                    <?php } ?>
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>  

<script type="text/javascript">

</script>              