 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                
                <div class="portlet-body">                    
                    <form id="oil_stock_balance_entry_form" method="post" action="<?php echo $form_action;?>"  autocomplete="on" class="form-horizontal">
                        <div class="alert alert-danger display-hide" style="display: none;">
                           <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                        </div>
                        <div class="row">                               
                            <div class="col-md-3">
                                <h4><?php echo '<b>OPS Name :</b>'.get_plant_name();?></h4>
                            </div>
                            <div class="col-md-3">
                               <h4> <?php echo '<b>Date :</b>'.date('d-M-Y');?></h4>
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
                                                    <div class="dummy">
                                                        <div class="input-icon right">
                                                            <i class="fa"></i>
                                                            <input type="text" class="form-control" value="<?php echo $value;?>" maxlength="25" name="opening_balance[<?php echo $key;?>]">
                                                            <?php echo get_pm_unit_name($key);?>
                                                        </div>
                                                    </div>
                                                </td>                                       
                                            </tr>
                                        <?php
                                       }
                                    }?>
                                </tbody>
                            </table>
                        </div>                                                               
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-5 col-md-6">
                                    <button type="submit" value="1" name="submit" class="btn blue">Submit</button>
                                    <a href="<?php echo SITE_URL.'';?>" class="btn default">Cancel</a>
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