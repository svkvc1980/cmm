 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                
                <div class="portlet-body">                    
                    <form id="production_entry_form" method="post" action="<?php echo $form_action;?>"  autocomplete="on" class="form-horizontal">
                        <div class="alert alert-danger display-hide" style="display: none;">
                           <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                        </div>
                        <div class="row">
                               
                                <div class="col-md-3">
                                    <h4><?php echo '<b>OPS Name :</b>'.get_plant_name();?></h4>
                                </div>
                                <div class="col-md-3">
                                   <h4> <?php echo '<b>Date :</b>'.date('d-m-Y');?></h4>
                                </div>
                                 <div class="col-md-6">
                                     <h4> <?php echo '<b>Last Reading Taken On</b>:'.@$last_reading_taken;?></h4>
                                 </div>
                                
                            </div>
                        
                        <div class="table-scrollable form-body">
                            <table class="table table-bordered table-striped table-hover product_table">
                                <thead>
                                    <tr>
                                        <th style="width:40%">Packing Material </th>
                                        <th style="width:30%">Opening Balance </th>                                            
                                    </tr>
                                </thead>
                                <tbody>  
                                <?php 
                                    if(@$pm_stock_balance_entry_list)
                                    {
                                       foreach ($pm_stock_balance_entry_list['opening_balance'] as $key => $value) {
                                        ?>
                                            <tr>
                                                <td>
                                                   <?php echo get_pm_name($key);?>
                                                   
                                                </td>
                                                <td>
                                                   <?php echo $value.' '.get_pm_unit_name($key);?>
                                                    <input type="hidden" name="opening_balance[<?php echo $key;?>]"  value="<?php echo @$value; ?>">
                                                </td>                                      
                                            </tr>

                                         <?php  
                                        } 
                                    }  ?>                                             
                                    
                                </tbody>
                            </table>
                        </div>                                                               
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-5 col-md-6">
                                    <button type="submit" value="1" name="submit" class="btn blue">Proceed</button>
                                    <button type="submit" formaction="<?php echo SITE_URL.'pm_stock_balance_entry';?>" value="2" name="cancel" class="btn default">Cancel</button>
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
<script type="text/javascript">
$('.remove_product_row').on('click',function(){
    if(confirm('are you sure to Delete this Product Entry details?'))
    {
        $(this).closest('tr').remove();
    }
});
</script>