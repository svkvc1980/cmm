<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="portlet light portlet-fit">
	   <div class="portlet-body">
	   		<form class="form-horizontal" method="post" action="<?php echo SITE_URL;?>distributor_do_list">
				
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <div class="col-xs-12">   
                                    <input class="form-control" name="do_number" value="<?php echo @$search_data['do_number'];?>" placeholder="DO Number" type="text">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <select name="executive" class="form-control">
                                <option value="">Select Executive</option>
                                <?php
                                foreach($executives as $ex_row)
                                {
                                    $selected = (@$search_data['executive']==$ex_row['executive_id'])?'selected':'';
                                    echo '<option value="'.$ex_row['executive_id'].'" '.$selected.'>'.$ex_row['name'].'</option>';
                                }
                                ?>
                            </select>
                        </div>

                       
                        <div class="col-md-5">
                            <div class="form-group">                                
                                <div class="col-xs-12">
                                    <select class="form-control select2" name="distributor_id">
                                        <option value="">- Distributor -</option>
                                        <?php 
                                            foreach($distributor_list as $row)
                                            {
                                                $selected = "";
                                                if($row['distributor_id']== @$search_data['distributor_id'] )
                                                    { 
                                                        $selected='selected';
                                                    }
                                                echo '<option value="'.$row['distributor_id'].'" '.$selected.' >'.$row['distributor_code'].' - ('.$row['agency_name'].')</option>';
                                            }
                                        ?>
                                   </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <select class="form-control select2" name="product_id">
                                        <option value="">- Products -</option>
                                        <?php 
                                            foreach($product_list as $row)
                                            {
                                                $selected = "";
                                                if($row['product_id']== @$search_data['product_id'] )
                                                    { 
                                                        $selected='selected';
                                                    }
                                                echo '<option value="'.$row['product_id'].'" '.$selected.' >'.$row['product_name'].'</option>';
                                            }
                                        ?>
                                   </select>
                                </div>
                            </div>
                        </div>
                        
                        
                    </div>
                    <div class="col-md-12">
                        <?php $block_id = $this->session->userdata('block_id');
                        if($block_id != 2){ 
                            ?>
                        <div class="col-md-2">
                            <div class="form-group">                                
                                <div class="col-xs-12">
                                    <select class="form-control" name="lifting_point_id">
                                        <option value="">- Lifting Point -</option>
                                        <?php 
                                            foreach($lifting_point as $row)
                                            {
                                                $selected = "";
                                                if($row['plant_id']== @$search_data['lifting_point_id'] )
                                                    { 
                                                        $selected='selected';
                                                    }
                                                echo '<option value="'.$row['plant_id'].'" '.$selected.' >'.$row['name'].'</option>';
                                            }
                                        ?>
                                   </select>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <select name="status" class="form-control" >
                                        <option value="">- Status -</option>
                                        <option value="1" <?php if(@$search_data['status']==1){?>selected <?php } ?> >Pending D.O.</option>
                                        <option value="2" <?php if(@$search_data['status']==2){?>selected <?php } ?> >Completed D.O.</option>
                                    </select>
                                </div>
                            </div>
                        </div> 
                        <div class="col-md-4">
                            <div class="form-group">                                
                                <div class="col-xs-12">
                                    <div class="input-group input-large date-picker input-daterange" data-date-format="dd-mm-yyyy">
                                        <input type="text" class="form-control" name="fromDate" placeholder="From Date" value="<?php if($search_data['fromDate']!=''){ echo date('d-m-Y',strtotime($search_data['fromDate']));} ?>">
                                        <span class="input-group-addon"> to </span>
                                        <input type="text" class="form-control" name="toDate" placeholder="To Date" value="<?php if($search_data['toDate']!=''){ echo date('d-m-Y',strtotime($search_data['toDate']));} ?>"> 
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="col-md-2">
                            <div class="form-group">
                                <div class="col-xs-12">                             
                                    <select class="form-control" name="order_type_id">
                                        <option value="">- DO Type -</option>
                                        <?php 
                                            foreach($distributor_type as $row)
                                            {
                                                $selected = "";
                                                if($row['ob_type_id']== @$search_data['order_type_id'] )
                                                    { 
                                                        $selected='selected';
                                                    }
                                                echo '<option value="'.$row['ob_type_id'].'" '.$selected.' >'.$row['name'].'</option>';
                                            }
                                        ?>
                                   </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-2">
                            <div class="form-group">                                
                                <div class="col-xs-12">
                                    <button type="submit" name="search_do" value="1" class="btn btn-xs blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                    <button type="submit" name="download_do" value="1" formaction="<?php echo SITE_URL.'download_do_list';?>" class="btn blue btn-xs tooltips" data-container="body" data-placement="top" data-original-title="Download DO"><i class="fa fa-cloud-download"></i></button>
                                    <button name="reset" formaction="<?php echo SITE_URL.'distributor_do_list';?>" class="btn blue btn-xs tooltips" data-container="body" data-placement="top" data-original-title="reset"><i class="fa fa-refresh"></i></button>
                                    <button type="submit" name="print_distributor_do" value="1" formaction="<?php echo SITE_URL.'print_distributor_do';?>" class="btn btn-xs btn-danger tooltips" data-container="body" data-placement="top" data-original-title="Print DO"><i class="fa fa-print"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
			</form>
			<div class="row">
				<div class="col-md-12">
					<div class="table-scrollable">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <th>S.No</th>
                                <th>DO Number</th>
                                <th>Distributor</th>
                                <th>Lifting</th>
                                <th>Product </th>
                                <th>DO Qty</th>
                                <th>Pending</th>
                                <th align="right">Price</th>
                                <th align="right">Value</th>
                                <th>Status</th>
                            </thead>
                            <tbody>
                            <?php
                                if(@$do_results)
                                {

                                foreach(@$do_results as $row)
                                	{ ?>                                	
                            	<tr>
                            		<td><?php echo $sn++;?></td>
                            		<td><?php echo $row['do_number'].' / '.DateFormat($row['do_date']);?> </td>
                                    <td><?php echo $row['distributor_code'].' - ('.$row['agency_name'].')'?> </td>
                                    <td><?php echo $row['lifting_point'];?> </td>
                                    <td><?php echo $row['product_name'];?> </td>
                                    <?php /*$invoice_qty = get_do_product_invoice_qty($row['order_id'],$row['do_identity'],$row['product_id']); 
                                            $pending_qty = ($row['do_quantity'] - $invoice_qty)*/?>
                                    <td><?php echo round($row['do_quantity']);?> </td>
                                    <td><?php echo round($row['pending_qty']);?> </td>
                                    <td align="right"><?php echo price_format($row['product_price']);?> </td>
                                    <td align="right"><?php echo price_format($row['do_quantity']*$row['items_per_carton']*$row['product_price']);?></td>
                            		<td><?php if($row['order_status']<=2) { echo "Pending"; }
                                                else { echo "completed"; }?> </td>
                            		
                            	</tr>
                            	<?php
                                    }
                                }
                                else
                                {
                            		?> <tr><td colspan="8" align="center"> No Records Found</td></tr>      
                        <?php   }
                                ?>
                            </tbody>
                        </table>
                    </div>
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
		</div>
	</div>
</div>

<?php $this->load->view('commons/main_footer', $nestedView); ?>