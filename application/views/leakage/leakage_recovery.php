<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                <br>
                   <?php
                    if($flag==1)
	                {
	                ?>  
	                <form id="leakage_form" method="post" action="<?php echo SITE_URL.'add_leakage_recovery';?>" class="form-horizontal">
	                    <div class="row">  
	                        <div class="col-md-offset-3 col-md-5"> 
	                                <div class="form-group">
	                                    <label class="col-md-5 control-label">Leakage Number<span class="font-red required_fld">*</span></label>
	                                    <div class="col-md-6">
		                                    <div class="input-icon right">
			                                    <i class="fa"></i>
		                                      <input type="text" name="leakage_no" class="form-control" value="">
		                                    </div>
	                                    </div>
	                                </div>                          
	                                <div class="form-group">
	                                    <div class="col-md-3"></div>
	                                        <div class="col-md-8">
	                                            <input type="submit" class="btn blue tooltips" value="Submit" name="submit">
	                                            <a href="<?php echo SITE_URL.'view_leakage_recovery_details';?>" class="btn default">Cancel</a>
	                                        </div>                                 
	                                </div>
	                            </div>
	                        </div>
	                    </form> 
                    <?php }
                    if($flag==2)
	                {
	                ?>  
	                <form id="leakage_form" method="post" action="<?php echo SITE_URL.'leakage_recovery_details';?>" class="form-horizontal">
                        <div class="row">
                            <div class="col-md-6">
								<div class="form-group">
									<label class="col-md-4 control-label">Leakage Number</label>
									<div class="col-md-6">
										<input  type="hidden" name="leakage_no" value="<?php echo $leakage_entry['leakage_number'];?>">
										<input  type="hidden" name="leakage_id" value="<?php echo $leakage_entry['leakage_id'];?>">
                                        <b class="form-control-static"><?php echo $leakage_entry['leakage_number'];?></b>
		                            </div>
                                </div>
                            </div>
                            <div class="col-md-6">
	                            <div class="form-group">
		                            <label class="col-md-4 control-label">Date</label>
		                            <div class="col-md-6">
			                            <input type="hidden" name="on_date"  value="<?php echo $leakage_entry['on_date'];?>">
                                        <b class="form-control-static"><?php echo  $leakage_entry['on_date'];?></b>
		                            </div>
	                             </div>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-md-4 control-label">Unit</label>
									<div class="col-md-6">
										<input  type="hidden" name="unit" value="<?php echo @$plant_name;?>">
		                                <b class="form-control-static"><?php echo $plant_name;?></b>
		                            </div>
                                </div>
                            </div>
                            <div class="col-md-6">
								<div class="form-group">
									<label class="col-md-4 control-label">Location</label>
									<div class="col-md-6">
										<input type="hidden"  name="type" value="<?php echo $leakage_entry['type'];?>">
		                                <b class="form-control-static"><?php echo get_type($leakage_entry['type']);?></b>
		                            </div>
                                </div>
                            </div>
                        </div>
	                    <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="25%"> Product </th>
                                        <th width="25%"> Leakage Quantity </th>
                                        <th width="25%"> Recovered Quantity</th>
                                        <th width="25%"> Recovered Pouches</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(count($leakage_product)>0)
                                    {
                                        foreach($leakage_product as $row)
                                        {
                                    ?>
                                        <tr>
                                            <td> <?php echo $row['product_name'];?> </td>
                                            <td> <?php echo $row['leakage_qty'];?> </td>
                                            <td>
                                            	<input type="hidden" name="leakage_qty[<?php echo $row['product_id'];?>]" value="<?php echo $row['leakage_qty'];?>">
                                            	<input type="hidden" name="product_id[<?php echo $row['product_id'];?>]" value="<?php echo $row['product_id'];?>">
                                            	<input type="hidden" name="product_name[<?php echo $row['product_id'];?>]" value="<?php echo $row['product_name'];?>">
                                            	<input type="hidden" name="item_qty[<?php echo $row['product_id'];?>]" value="<?php echo $row['items_per_carton'];?>">
                                            	<input class="form-control numeric" required name="recovery_qty[<?php echo $row['product_id'];?>]"  type="text"> 
                                            </td>
                                            <td>
                                            	<input class="form-control numeric" required name="recovery_pouches[<?php echo $row['product_id'];?>]" type="text"> 
                                            </td>
                                        </tr>
                                        <?php
                                        } 
                                    } ?> 
                                </tbody>
                            </table>
                        </div>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="25%"> Loose Oil </th>
                                        <th width="25%"> Quantity (Kg's) </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(count($leakage_product)>0)
                                    {
                                        foreach($leakage_product as $row)
                                        {
                                    ?>
                                        <tr>
                                            <td> <?php echo $row['loose_name'];?> </td>
                                            <td>
                                            	<input type="hidden" name="product_id[<?php echo $row['product_id'];?>]" value="<?php echo $row['product_id'];?>">
                                            	<input type="hidden" name="product_name[<?php echo $row['product_id'];?>]" value="<?php echo $row['product_name'];?>">
                                            	<input type="hidden" name="loose_name[<?php echo $row['product_id'];?>]" value="<?php echo $row['loose_name'];?>">
                                            	<input class="form-control numeric" required name="oil_weight[<?php echo $row['product_id'];?>]"  type="text"> 
                                            </td>
                                        </tr>
                                        <?php
                                        } 
                                    } ?> 
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-5"></div>
                                <div class="col-md-4">
                                    <input type="submit" class="btn blue tooltips" value="submit" name="submit">
                                    <a href="<?php echo SITE_URL.'leakage_recovery';?>" class="btn default">Cancel</a>
                                </div>
                            </div>                                 
                        </div>
                    </form> 
                    <?php } 
                    if($flag==3)
	                {
	                ?>  
	                <form id="leakage_form" method="post" action="<?php echo SITE_URL.'insert_leakage_details';?>" class="form-horizontal">
	                	<div class="row">
                            <div class="col-md-6">
								<div class="form-group">
									<label class="col-md-4 control-label">Leakage Number</label>
									<div class="col-md-6">
										<input  type="hidden" name="leakage_no" value="<?php echo $dat1['leakage_no'];?>">
										<input  type="hidden" name="leakage_id" value="<?php echo $dat1['leakage_id'];?>">
										<b class="form-control-static"><?php echo $dat1['leakage_no'];?></b>
		                            </div>
                                </div>
                            </div>
                            <div class="col-md-6">
	                            <div class="form-group">
		                            <label class="col-md-4 control-label">Date</label>
		                            <div class="col-md-6">
			                            <input type="hidden" name="on_date"  value="<?php echo $dat1['on_date'];?>">
                                        <b class="form-control-static"><?php echo  $dat1['on_date'];?></b>
		                            </div>
	                             </div>
                            </div>
                        </div>
                        <div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="col-md-4 control-label">Unit</label>
									<div class="col-md-6">
										<input  type="hidden" name="unit" value="<?php echo $dat1['unit'];?>">
		                                <b class="form-control-static"><?php echo $dat1['unit'];?></b>
		                            </div>
                                </div>
                            </div>
                            <div class="col-md-6">
								<div class="form-group">
									<label class="col-md-4 control-label">Location</label>
									<div class="col-md-6">
										<input type="hidden"  name="type" value="<?php echo $dat1['type'];?>">
		                                <b class="form-control-static"><?php echo get_type($dat1['type']);?></b>
		                            </div>
                                </div>
                            </div>
                        </div>
	                    <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="25%"> Product </th>
                                        <th width="25%"> Leakage Quantity </th>
                                        <th width="25%"> Recovery Quantity</th>
                                        <th width="25%"> Recovery Pouches</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(count($dat)>0)
                                    {
                                        foreach($dat as $row)
                                        {
                                    ?>
                                        <tr>
                                            <td> <?php echo $row['product_name'];?> </td>
                                            <td> <?php echo $row['leakage_qty'];?> </td>
                                            <td> <?php echo $row['recovery_qty'];?> </td>
                                            <td> <?php echo $row['recovery_pouches'];?>
	                                            <input type="hidden" name="product_id[<?php echo $row['product_id'];?>]" value="<?php echo $row['product_id'];?>">
	                                            <input type="hidden" name="product_name[<?php echo $row['product_id'];?>]" value="<?php echo $row['product_name'];?>">
	                                        	<input type="hidden" name="leakage_qty[<?php echo $row['product_id'];?>]" value="<?php echo $row['leakage_qty'];?>">
	                                        	<input type="hidden" name="item_qty[<?php echo $row['product_id'];?>]" value="<?php echo $row['items_per_carton'];?>">
	                                        	<input type="hidden" name="recovery_qty[<?php echo $row['product_id'];?>]" value="<?php echo $row['recovery_qty'];?>">
	                                       		<input type="hidden" name="recovery_pouches[<?php echo $row['product_id'];?>]" value="<?php echo $row['recovery_pouches'];?>">
                                       		</td>
                                       	</tr>
                                        <?php
                                        } 
                                    } ?> 
                                </tbody>
                            </table>
                        </div>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th width="50%"> Loose Oil </th>
                                        <th width="50%"> Quantity (Kg's)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(count($dat)>0)
                                    {
                                        foreach($dat as $row)
                                        {
                                    ?>
                                        <tr>
                                            <td> <?php echo $row['loose_name'];?> </td>
                                            <td> <?php echo $row['oil_weight'];?> 
                                                <input type="hidden" name="product_id[<?php echo $row['product_id'];?>]" value="<?php echo $row['product_id'];?>">
	                                            <input type="hidden" name="product_name[<?php echo $row['product_id'];?>]" value="<?php echo $row['product_name'];?>">
	                                            <input type="hidden" name="loose_name[<?php echo $row['product_id'];?>]" value="<?php echo $row['loose_name'];?>">
	                                        	<input type="hidden" name="oil_weight[<?php echo $row['product_id'];?>]" value="<?php echo $row['oil_weight'];?>">
	                                        </td>
                                       	</tr>
                                        <?php
                                        } 
                                    } ?> 
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-5"></div>
                                <div class="col-md-4">
                                    <input type="submit" class="btn blue tooltips" value="submit" name="submit">
                                    <a href="<?php echo SITE_URL.'leakage_recovery';?>" class="btn default">Cancel</a>
                                </div>
                            </div>                                 
                        </div>
                    </form> 
                    <?php } 
                    if($flag==4)
	                {
	                ?>  
	                <form id="leakage_form" method="post" action="<?php echo SITE_URL.'view_leakage_recovery_details';?>" class="form-horizontal">
                	    <div class="row">
                	        <div class="col-md-3">
								<input type="text" class="form-control numeric" name="leakage_number" value="<?php echo @$search_params['leakage_number'];?>" placeholder="Leakage Number">
							</div>
							<div class="col-md-3">
								<input class="form-control date-picker date" data-date-format="dd-mm-yyyy" name="on_date" value="<?php if($search_params['on_date']!='') { echo date('d-m-Y',strtotime(@$search_params['on_date'])); } ?>" placeholder="Date" type="text">
							</div>
							<div class="col-md-3">
								<button type="submit" title="Search" name="search_leakage_recovery" value="1" class="btn blue"><i class="fa fa-search"></i> </button>
								<a href="<?php echo SITE_URL;?>leakage_recovery" title="Add New" class="btn blue"><i class="fa fa-plus"></i> </a>
							</div>
						</div>
						<input type="hidden" name="recovery_id" value="<?php echo @$leakage_details['recovery_id'];?>">
	                	<div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                    	<th width="10%"> S.No </th>
                                        <th width="20%"> Leakage Number </th>
                                        <th width="20%"> On Date </th>
                                        <th width="25%"> Entry By </th>
                                        <th width="10%"> Actions </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(count($leakage_details)>0)
                                    {
                                        foreach($leakage_details as $row)
                                        {
                                    ?>
                                        <tr>
                                        	<td> <?php echo $sn++;?> </td>
                                            <td> <?php echo $row['leakage_number'];?> </td>
                                            <td> <?php echo date("d-m-Y", strtotime($row['on_date']));?> </td>
                                            <td> <?php echo get_user_name($row['created_by']);?> </td>
                                            <td> 
                                                <a class="btn btn-default btn-xs" title="View Details" href="<?php echo SITE_URL;?>leakage_details/<?php echo cmm_encode($row['recovery_id']); ?>"><i class="fa fa-eye "></i></a> 
                                            </td>
                                        </tr>
                                        <?php
                                        } 
                                    }
                                    else
                                    {?>
                                		<tr><td colspan="5" align="center"> No Records Found</td></tr>
									<?php
                                    }?>
                                </tbody>
                            </table>

                        </div>
                    </form> 
                    <?php } 
                    if($flag==5)
	                {
	                ?>  
	                <form id="leakage_form" method="post" action="<?php echo SITE_URL.'';?>" class="form-horizontal">
	                   <input type="hidden" name="recovery_id" value="<?php echo @$leakage_details['recovery_id'];?>">
	                   <h5><b> Products</b></h5>
                	 	<div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                    	<th width="10%"> S.No </th>
                                        <th width="20%"> Product Name </th>
                                        <th width="15%"> Quantity (Cartons) </th>
                                        <th width="15%"> Items Per Carton</th>
                                        <th width="15%"> Loose Pouches (Kg's)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(count($leakage_recovered_products)>0)
                                    {
                                        $sn=1;
                                        foreach($leakage_recovered_products as $row)
                                        { 
                                    ?>
                                        <tr>
                                        	<td> <?php echo $sn++;?> </td>
                                            <td> <?php echo $row['product_name'];?> </td>
                                            <td> <?php echo $row['quantity'];?> </td>
                                            <td> <?php echo $row['items_per_carton'];?> </td>
                                            <td> <?php echo $row['recovered_pouches'];?> </td>
                                        </tr>
                                        <?php
                                        } 
                                    } ?> 
                                </tbody>
                            </table>
                        </div><br>
                        <h5><b>Oils</b></h5>
                        <div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                    	<th width="10%"> S.No </th>
                                        <th width="20%"> Loose Oil Name </th>
                                        <th width="15%"> Oil Weight </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(count($leakage_recovered_oil)>0)
                                    {
                                        $sn=1;
                                        foreach($leakage_recovered_oil as $row)
                                        {
                                    ?>
                                        <tr>
                                        	<td> <?php echo $sn++;?> </td>
                                            <td> <?php echo $row['loose_name'];?> </td>
                                            <td> <?php echo $row['oil_weight'];?> </td>
                                        </tr>
                                        <?php
                                        } 
                                    } ?> 
                                </tbody>
                            </table>

                        </div>
                        <div class="row">
                        <div class="col-md-offset-5 col-md-4">
                            <a  class="btn blue" href="<?php echo SITE_URL.'view_leakage_recovery_details';?>">Back</a>
                        </div> 
                    </div> 
                    </form> 
                    <?php } 
                    ?>
	                <div class="row">
                        <div class="col-md-5 col-sm-5">
                            <div class="dataTables_info" role="status" aria-live="polite">
                                <?php echo @$pagermessage; ?>
                            </div>
                        </div>
                        <div class="col-md-7 col-sm-7">
                            <div class="dataTables_paginate paging_bootstrap_full_number">
                                <?php echo @$pagination_links; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer',$nestedView); ?>
