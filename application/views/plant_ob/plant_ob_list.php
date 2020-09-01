<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="portlet light portlet-fit">
	   <div class="portlet-body">
	   		<form class="form-horizontal" method="post" action="<?php echo SITE_URL;?>plant_ob_list">
				<div class="row">
                    <div class="col-md-12">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="col-xs-12">   
                                    <input class="form-control" name="ob_number" value="<?php echo @$search_data['ob_number'];?>" placeholder="Order Number" type="text">
                                </div>
                            </div>
                        </div>

                        <?php $block_id = $this->session->userdata('block_id');
                        /*if($block_id == 1)*/{ ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <select name="order_for" class="form-control">
                                        <option value="">-Select Unit -</option>
                                        <?php foreach ($plant_block as  $block_id=>$value) {?>
                                            <optgroup label="<?php echo $value['block_name'];?>">
                                            <?php foreach ($value['plants'] as $key=>$row) {
                                                $selected = "";
                                                if($row['plant_id']== @$search_data['order_for'])
                                                    { 
                                                        $selected='selected';
                                                    } 
                                                echo '<option value="'.$row['plant_id'].'" '.$selected.' >'.$row['plant_name'].'</option>';
                                             } 
                                                ?></optgroup><?php
                                            }?>
                                    
                                    </select>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <select name="lifting_point_id" class="form-control">
                                        <option value="">- Select Lifting Point -</option>
                                        <?php foreach ($lifting_points as  $block_id=>$value) {?>
                                            <optgroup label="<?php echo $value['block_name'];?>">
                                            <?php foreach ($value['plants'] as $key=>$row) {
                                                $selected = "";
                                                if($row['plant_id']== @$search_data['lifting_point_id'])
                                                    { 
                                                        $selected='selected';
                                                    }
                                                echo '<option value="'.$row['plant_id'].'" '.$selected.' >'.$row['plant_name'].'</option>';
                                                
                                             } 
                                                ?></optgroup><?php
                                            }?>
                                    
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <select name="status" class="form-control" >
                                        <option value="">- Status -</option>
                                        <option value="1" <?php if(@$search_data['status']==1){?>selected <?php } ?> >Pending O.B.</option>
                                        <option value="2" <?php if(@$search_data['status']==2){?>selected <?php } ?> >Completed O.B.</option>
                                    </select>
                                </div>
                            </div>
                        </div> 
                        
                        
                        
                    </div>
                    <div class="col-md-12">
                        
                        
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
                        <div class=" col-md-3">
                            <div class="form-group">                                
                                <div class="col-xs-12">
                                    <button type="submit" name="search_plant_ob" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                    <button type="submit" name="download_ob" value="1" formaction="<?php echo SITE_URL.'download_plant_ob';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download OB"><i class="fa fa-cloud-download"></i></button>
                                    <button name="reset" formaction="<?php echo SITE_URL.'plant_ob_list';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="reset"><i class="fa fa-refresh"></i></button>
                                    <button type="submit" name="print_ob_list" value="1" formaction="<?php echo SITE_URL.'print_unit_ob_list';?>" class="btn btn-danger tooltips" data-container="body" data-placement="top" data-original-title="Print OB"><i class="fa fa-print"></i></button>
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
                                <th> S.No</th>
                                <th> Order Number </th>
                                <th> Order For </th>
                                <th> Lifting Point </th>
                                <th> Order Date </th>
                                <th> Status </th>
                                <th style="width: 10%"> Actions </th>
                            </thead>
                            <tbody>
                            <?php
                            	
                                if(@$ob_results)
                                {

                                foreach(@$ob_results as $row)
                                	{ ?>                                	
                            	<tr>
                            		<td><?php echo $sn++;?></td>
                            		<td><?php echo $row['order_number'];?> </td>
                                    <td><?php echo $row['plant_name'];?> </td>
                                    <td><?php echo $row['lifting_point_name'];?> </td>
                            		<td><?php echo date('d-m-Y',strtotime($row['order_date']));?> </td>
                                    <td><?php if($row['order_status']<=2) { echo "Pending"; }
                                                else { echo "completed"; }?> </td>
                            		
                            		<td style="width: 10%"><a  href="<?php echo SITE_URL.'view_plant_ob_products/'.cmm_encode(@$row['order_id']).'/'.cmm_encode(@$row['order_number']);?>" class="btn btn-xs btn-default btn-circle btn-sm tooltips" data-container="body" data-placement="top" data-original-title="View Products"><i class="fa fa-eye"></i></a>
                                    </td>
                            	        
                                </tr>
                            	<?php
                                    }
                                }
                                else
                                {
                            		?> <tr><td colspan="7" align="center"> No Records Found</td></tr>      
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