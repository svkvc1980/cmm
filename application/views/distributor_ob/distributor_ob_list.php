<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="portlet light portlet-fit">
	   <div class="portlet-body">
	   		<form class="form-horizontal" method="post" action="<?php echo SITE_URL;?>distributor_ob_list">
				<div class="row">
					<div class="col-md-12">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <div class="col-xs-12">   
                                    <input class="form-control" name="ob_number" value="<?php echo @$search_data['ob_number'];?>" placeholder="Order Number" type="text">
                                </div>
                            </div>
                        </div>

						<div class="col-md-2">
							<div class="form-group">
								<div class="col-xs-12">								
									<select class="form-control" name="order_type_id">
                                   		<option value="">-  OB Type -</option>
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
                                    <select class="form-control select2" name="executive_id">
                                        <option value="">- Executive -</option>
                                        <?php 
                                            foreach($executive_list as $row)
                                            {
                                                $selected = "";
                                                if($row['executive_id']== @$search_data['executive_id'] )
                                                    { 
                                                        $selected='selected';
                                                    }
                                                echo '<option value="'.$row['executive_id'].'" '.$selected.' >'.$row['executive_code'].' - ('.$row['name'].')</option>';
                                            }
                                        ?>
                                   </select>
                                </div>
                            </div>
                        </div>			
                        
                    </div>
                    <div class="col-md-12">
                        <?php $block_id = $this->session->userdata('block_id'); 
                        /*if($block_id == 1)*/
                        {?>
                        
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
                                        <option value="1" <?php if(@$search_data['status']==1){?>selected <?php } ?> >Pending O.B.</option>
                                        <option value="2" <?php if(@$search_data['status']==2){?>selected <?php } ?> >Completed O.B.</option>
                                        <option value="3" <?php if(@$search_data['status']==3){?>selected <?php } ?> >Expired O.B.</option>
                                    </select>
                                </div>
                            </div>
                        </div> 
						<div class="col-md-5">
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
						<div class="col-md-3">
							<div class="form-group">								
								<div class="col-xs-12">
									<button type="submit" name="search_ob" value="1" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Search"><i class="fa fa-search"></i></button>
                                    <button type="submit" name="download_ob" value="1" formaction="<?php echo SITE_URL.'download_ob_list';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Download OB"><i class="fa fa-cloud-download"></i></button>
                                    <button name="reset" formaction="<?php echo SITE_URL.'distributor_ob_list';?>" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="reset"><i class="fa fa-refresh"></i></button>
                                    <button type="submit" name="print_ob" value="1" formaction="<?php echo SITE_URL.'print_distributor_ob_list';?>" class="btn btn-danger tooltips" data-container="body" data-placement="top" data-original-title="Print OB List"><i class="fa fa-print"></i></button>
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
                                <th> Order Date </th>
                                <th> Order Type </th>
                                <th> Distributor </th>
                                <th> Lifting Point </th>
                                <th> Executive </th>
                                <th> Status </th>
                                <th style="width:10px"> Actions </th>
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
                            		<td><?php echo date('d-m-Y',strtotime($row['order_date']));?> </td>
                            		<td><?php echo $row['ob_type'];?> </td>
                            		<td><?php echo $row['distributor_code'].' - ('.$row['distributor_name'].')'?> </td>
                            		<td><?php echo $row['lifting_point'];?> </td>
                                    <td><?php echo $row['executive_name'];?> </td>
                                    <td><?php if($row['order_status']<=2) { echo "Pending"; }
                                                else if($row['order_status']==3) { echo "completed"; }
                                                else if($row['order_status']==10) { echo "Expired"; }?> </td>
                            		<td style="width:10px">
                                        <a  href="<?php echo SITE_URL.'view_distributor_ob/'.cmm_encode(@$row['order_id']).'/'.cmm_encode(@$row['order_number']);?>" class="btn btn-xs btn-default btn-circle btn-sm tooltips" data-container="body" data-placement="top" data-original-title="View Products"><i class="fa fa-eye"></i></a>
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
<script type="text/javascript">
	
    $('.distributor_type').change(function(){
    var distributor_type_id = $(this).val();
   // alert(distributor_type_id);
    if(distributor_type_id=='')
    {
        $('.distributor').html('<option value="">Distributor</option');
        
    }
    else
    {
        //alert(distributor_type_id);
        $.ajax({
            type:"POST",
            url:SITE_URL+'getDistributors',
            data:{distributor_type_id:distributor_type_id},
            cache:false,
            success:function(html){
                $('.distributor').html(html);
            }
        });
    }
});
$('.distributor').change(function(){
    var distributor_id=$(this).val();
    //alert(distributor);
    if(distributor_id!='')
    {
        //alert(distributor_id);
        $.ajax({
        type:"POST",
        url:SITE_URL+'getStockLiftingUnit',
        data:{distributor_id:distributor_id},
        cache:false,
        success:function(html){
            $('.stockLiftingUnit').html(html);
        }
    });
       
    }
    else
    {
         $('.stockLiftingUnit').html('<option value="">-Select Stock Lifting Unit</option');
    }

});


</script>