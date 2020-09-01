<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit">                
                <div class="portlet-body">
                	<form id="broker_form" method="post" action="<?php echo SITE_URL;?>product_micron" class="form-horizontal">
                	<div class="row">
                               
                        <div class="col-md-offset-1 col-md-3">
                            <h4><?php echo '<b>OPS Name :</b>'.get_plant_name();?></h4>
                        </div>
                        <div class="col-md-3">
                           <h4> <?php echo '<b>Date :</b>'.date('d-m-Y');?></h4>
                        </div>
                         <div class="col-md-5">
                             <h4> <?php echo '<b>Last Reading Taken On</b>:'.@$last_reading_taken;?></h4>
                         </div>
                        
                    </div>
                    <div class="table-scrollable">                		
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Packed Product</th>
                                    <th colspan="<?php echo $micron_count; ?>"> Microns </th>                                                
                                </tr>
                            </thead>
                            <tr style="background-color:#ccc">
                            	<td></td>
                            	<?php foreach($micron as $row) { ?>
                            	<td style="width:10%"><?php echo $row['name']; ?></td>
                            	<?php } ?>
                            </tr>
                            <tbody>
                            	<?php foreach($capacity as $capacity_result) { ?>
                            	<tr>
                            		<td style="width:10%">
                            		<?php echo $capacity_result['name']; ?> 
                            		</td>
                            		<?php foreach($micron as $micron_result) { ?>
	                            	<td style="width:10%">	                            		
	                            		<input type="text" required class="form-control numeric" style="width:135px" name="product_micron_value[<?php echo $capacity_result['pm_id']; ?>][<?php echo $micron_result['micron_id'];?>]" value="<?php if(@$results[@$capacity_result['pm_id']][@$micron_result['micron_id']]!=''){ echo @$results[@$capacity_result['pm_id']][@$micron_result['micron_id']]; }else{ echo 0;} ?>">
	                            	</td>
	                            	<?php } ?>
                            		
                            	</tr>
                            	<?php } ?>
                            </tbody>
                        </table>                        
                    </div>
                    <div class="row">
	                    <div class="col-md-offset-5 col-md-6">
	                        <button type="submit" value="1" name="product_micron" onclick="return confirm('Are you sure you want to Submit?')" class="btn blue">Submit</button>
	                         <a type="submit" href="<?php echo SITE_URL.'manage_pm_stock_balance';?>" class="btn default">Cancel</a>
	                    </div>
                	</div>  
                	</form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('commons/main_footer', $nestedView); ?>