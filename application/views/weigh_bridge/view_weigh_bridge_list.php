<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">  
                <div class="portlet-body">
                	<div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="header text-center">
                                    <span class="timer_block" style="float:right; color:#3A8ED6">
                                        <i class="fa fa-clock-o"></i>
                                    <span id="timer"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                        foreach ($view_list as $row)
                        {?>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label for="inputName" class="col-md-4 control-label">Vehicle Number :</label>
                                    <p><b><?php echo $row['vehicle_number']?></b></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label class="col-md-4 control-label">Product Name :</label>
                                    <p><b><?php
                                    	switch($row['tanker_type_id']) 
                                        {
                                            case 1:
                                                echo $row['loose_oil'];
                                            break;

                                            case 2:
                                                echo $row['packing_material'];
                                            break;

                                            case 5:
                                                echo $row['free_gift'];
                                            break;    
                                             
                                            default:
                                                echo "None";
                                            break;
                                        }
                                     ?></b></p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label class="col-md-4 control-label">Invoice Number:</label>
                                    <p><b><?php echo $row['invoice_number']?></b></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">    
                                <label class="col-md-4 control-label">Dc Number :</label>
                                    <p><b><?php echo $row['dc_number']?></b></p>
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                <label class="col-md-4 control-label">Party Name:</label>
                                    <p><b><?php echo $row['party_name']?></b></p>
                                </div>
                            </div>
                        </div> 
                        <?php } 
                    	if($view_list)
                    	{
                    		foreach ($view_list as $row)
                    		{?>	
                    			<h5 style="color: #3598DC"><strong>Weight In Kg's:</strong></h5>
                    			<div class="table-scrollable">
                            		<table class="table table-bordered table-striped table-hover">
                            			<thead>
                            				<tr>
                            					<th>Gross</th>
                            					<th>tare</th>
                            					<th>Net</th>
                            				</tr>
                            			</thead>
                            			<tbody>
                            				<tr>
                            					<td><?php 
														switch ($row['tanker_type_id']) 
														{
														 	case 1:
														 		echo $row['to_gross'];
														 	break;

														 	case 2:
														 		echo $row['tp_gross'];
														 	break;

														 	case 5:
														 		echo $row['tf_gross'];
														 	break;
														 	
														 	default:
														 		echo "None";
														 	break;
													} ?>
												</td>
                            					<td>
                            						<?php 
														switch ($row['tanker_type_id']) 
														{
														 	case 1:
														 		echo $row['to_tier'];
														 	break;

														 	case 2:
														 		echo $row['tp_tier'];
														 	break;

														 	case 5:
														 		echo $row['tf_tier'];
														 	break;
														 	
														 	default:
														 		echo "None";
														 	break;
													} ?>
                            					</td>
                            					<td>
                            						<?php 
														switch ($row['tanker_type_id']) 
														{
														 	case 1:
														 		echo $row['to_gross']-$row['to_tier'];
														 	break;

														 	case 2:
														 		echo $row['tp_gross']-$row['tp_tier'];
														 	break;

														 	case 5:
														 		echo $row['tf_gross']-$row['tf_tier'];
														 	break;
														 	
														 	default:
														 		echo "None";
														 	break;
													} ?>
                            					</td>
                            				</tr>
                            			</tbody>
                            		</table>
                            	</div>
	                    <?php   }
	                    	}?>
	                <div class="row">
		                <div class="col-md-offset-10 col-md-4">
		                	<a class="btn blue" href="<?php echo SITE_URL.'weigh_bridge_list';?>"><i class="glyphicon glyphicon-chevron-left"></i>Back</a>
		                </div> 
	                </div>  
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('commons/main_footer', $nestedView); ?>  
<style type="text/css">
	div .line
	{
	    padding-top: 5px;
	    border-top: 2px solid #66BDA9;
	    text-align: center;
	}
</style>              