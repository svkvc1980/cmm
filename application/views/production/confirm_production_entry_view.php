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
                            <div class="col-md-2"></div>
                            <div class="col-md-3">
                                <h4><?php echo '<b>OPS Name :</b>'.get_plant_name();?></h4>
                            </div>
                            <div class="col-md-3">
                               <h4> <?php echo '<b>Date :</b>'.date('d-M-Y');?></h4>
                            </div>
                            <div class="col-md-1">                                
                            </div>
                        </div>
                        <div class="row">
                                <div class="col-md-2"></div>
                                <div class="col-md-10">
                                    <h6><b>Pre P</b>: Previous Day Pouches,<b>Cur P</b>: Current Day Pouches <b>Prod P</b>: Produced Pouches</h6>
                                   
                                </div>
                                
                        </div>
                        
                        <div class="table-scrollable form-body">
                            <table class="table table-bordered table-striped table-hover product_table">
                                <thead>
                                    <tr>
                                            <th style="width:25%"> Product </th>
                                            <th style="width:4%">  Pre P </th>                                            
                                            <th style="width:15%"> Qty(C) </th>
                                            <th style="width:7%">  Cur P </th>
                                            <th style="width:12%"> Prod P </th>                                                                                    
                                            <th style="width:10%">  Oil Weight </th>
                                            <th style="width:21%">  Film</th>
                                            <th style="width:15%">Micron Type</th>
                                            
                                        </tr>
                                </thead>
                                <tbody>  
                                <?php 
                                    if(@$production_entry_list)
                                    {
                                       foreach ($production_entry_list['product_id'] as $key => $value) {
                                        ?>
                                            <tr>

                                                <input type="hidden" name="per_carton[]"  value="<?php echo get_items_per_carton(@$value); ?>">
                                                <td>
                                                   <?php echo get_product_name($value);?> 
                                                   <input type="hidden" name="product_id[]"  value="<?php echo @$value; ?>">
                                                </td>
                                                <td>
                                                   <?php echo $production_entry_list['hidden_previous_lp'][$key];?>
                                                    <input type="hidden" name="hidden_previous_lp[]"  value="<?php echo @$production_entry_list['hidden_previous_lp'][$key]?>">
                                                </td>
                                                <td>
                                                   <?php echo $production_entry_list['quantity'][$key];?>
                                                    <input type="hidden" name="quantity[]"  value="<?php echo @$production_entry_list['quantity'][$key]; ?>">
                                                </td>
                                                <td>
                                                   <?php echo @$production_entry_list['loose_pouches'][$key];?>
                                                    <input type="hidden" name="loose_pouches[]"  value="<?php echo @$production_entry_list['loose_pouches'][$key]; ?>">
                                                </td>
                                                <td>
                                                    <?php echo $production_entry_list['hidden_sachets'][$key];?>
                                                    <input type="hidden" name="hidden_sachets[]"  value="<?php echo @$production_entry_list['hidden_sachets'][$key]; ?>">
                                                </td>
                                                <td>
                                                    <?php echo $production_entry_list['hidden_cal_oil_wt'][$key];?>
                                                    <input type="hidden" name="hidden_cal_oil_wt[]"  value="<?php echo @$production_entry_list['hidden_cal_oil_wt'][$key]; ?>">
                                                </td> 
                                                <td>
                                                   <?php echo get_pm_name(@$production_entry_list['pm_id'][$key]);?> 
                                                   <input type="hidden" name="pm_id[]"  value="<?php echo @$production_entry_list['pm_id'][$key]; ?>">
                                                </td>  
                                                <td>
                                                   <?php echo get_micron_name(@$production_entry_list['micron_id'][$key]);?> 
                                                   <input type="hidden" name="micron_id[]"  value="<?php echo @$production_entry_list['micron_id'][$key]; ?>">
                                                </td>                                                                                     
                                                <!-- <td ><a class="btn btn-danger btn-sm remove_product_row"> <i class="fa fa-trash-o"></i></a></td> -->
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
                                    <button type="submit" value="1" name="submit" class="btn blue">Submit</button>
                                    <button type="submit" formaction="<?php echo SITE_URL.'production_entry';?>" value="2"  class="btn default">Cancel</button>
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