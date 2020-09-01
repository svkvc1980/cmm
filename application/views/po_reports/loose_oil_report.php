<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <form  method="post" action="<?php echo SITE_URL.'loose_oil_report'?>">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <input class="form-control" name="po_no" value="<?php echo @$search_params['po_number'];?>" placeholder="PO No" type="text">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <select name="loose_oil_id" class="form-control">
                                        <option value="">-Select Product-</option>
                                        <?php 
                                            foreach($loose as $loo)
                                            {
                                                $selected = '';
                                                if($loo['loose_oil_id'] ==@$search_params['loose_oil_id'] ) $selected = 'selected';
                                                echo '<option value="'.$loo['loose_oil_id'].'" '.$selected.'>'.$loo['loose_name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <select name="plant_id" class="form-control">
                                            <option value="">-Select Ops-</option>
                                            <?php 
                                                foreach($plant as $pla)
                                                {
                                                    $selected = '';
                                                    if($pla['plant_id'] ==@$search_params['plant_id'] ) $selected = 'selected';
                                                    echo '<option value="'.$pla['plant_id'].'" '.$selected.'>'.$pla['plant_name'].'</option>';
                                                }
                                            ?>
                                        </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <select name="broker_id" class="form-control">
                                        <option value="">-Select Broker-</option>
                                        <?php 
                                            foreach($broker as $bro)
                                            {
                                                $selected = '';
                                                if($bro['broker_id'] ==@$search_params['broker_id'] ) $selected = 'selected';
                                                echo '<option value="'.$bro['broker_id'].'" '.$selected.'>'.$bro['broker_name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <select name="supplier_id" class="form-control">
                                        <option value="">-Select Supplier-</option>
                                        <?php 
                                            foreach($supplier as $supp)
                                            {
                                                $selected = '';
                                                if($supp['supplier_id'] ==@$search_params['supplier_id'] ) $selected = 'selected';
                                                echo '<option value="'.$supp['supplier_id'].'" '.$selected.'>'.$supp['supplier_name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <select name="status" class="form-control">
                                        <option value="">-Select Status-</option>
                                        <?php 
                                            foreach($status as $key =>$value)
                                            {
                                                $selected = '';
                                                if($key ==@$search_params['status'] ) $selected = 'selected';
                                                echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group date-picker input-daterange " data-date-format="dd-mm-yyyy">
                                    <input class="form-control" name="start_date"  placeholder="From Date" type="text" value="<?php if(@$search_params['start_date']!=''){ echo @date('d-m-Y',strtotime($search_params['start_date'])); }?>" >
                                    <span class="input-group-addon"> to </span>
                                        <input class="form-control " name="end_date" placeholder="To Date" type="text" value="<?php if(@$search_params['end_date']!=''){ echo @date('d-m-Y',strtotime($search_params['end_date'])); }?>">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <button type="submit" title="Search" name="search_loose_oil" value="1" class="btn blue"><i class="fa fa-search"></i> </button>
                                <a  class="btn blue tooltips" href="<?php echo SITE_URL.'loose_oil_report';?>" data-original-title="Refresh"> <i class="fa fa-refresh"></i></a>
                                <button type="submit" name="print_loose_oil" value="1" formaction="<?php echo SITE_URL.'print_loose_oil_report';?>" class="btn btn-danger tooltips" data-container="body" data-placement="top" data-original-title="Print"><i class="fa fa-print"></i></button>
                                
                            </div>
                        </div>
                        </form>
                        <div class="table-scrollable">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th width="5%"> S.No </th>
                                    <th> PO No </th>
                                    <th> PO Date </th>
                                    <th> OPS </th>
                                    <th> Loose Oil</th>
                                    <th> Broker</th>
                                    <th> Supplier</th>
                                    <th> Quantity</th>
                                    <th> Pending Qty </th>
                                    <th> Amount</th>
                                    <th> Status</th>
                                    <th> Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if(count($loose_oil)>0)
                                {  $t_pending_po_qty = 0;
                                    $t_qty = 0;
                                    foreach($loose_oil as $row)
                                    {
                                      $t_qty += $row['quantity'];
                                ?>
                                    <tr>
                                        <td width="5%"> <?php echo $sn++;?> </td>
                                        <td width="10%"> <?php echo $row['po_number'];?> </td>
                                        <td width="10%"> <?php echo format_date($row['po_date']);?> </td> 

                                        <td width="10%"> <?php echo $row['plant_name'];?> </td>
                                        <td width="10%"> <?php echo $row['loose_name'];?> </td>
                                        <td width="15%"> <?php echo $row['broker_name'];?> </td>
                                        <td width="15%"> <?php echo $row['supplier_name'];?> </td>
                                        <td width="15%">  <?php echo $row['quantity']; ?></td>
                                        <td width="15%">  
                                            <?php 
                                            $t_pending_po_qty += pending_po_oil($row['po_oil_id']);
                                            echo pending_po_oil($row['po_oil_id']); ?>
                                        </td>
                                        <td width="15%"> <?php echo $row['unit_price'];?> </td>
                                        <td width="10%"> <?php echo get_po_status_value($row['status']);?> </td>
                                        <td>
                                            <a class="btn btn-primary btn-xs tooltips" data-original-title="Print"  href="<?php echo SITE_URL;?>print_loose_oil/<?php echo cmm_encode($row['po_oil_id']); ?>"><i class="fa fa-print"></i></a> 
                                        </td>
                                    </tr>
                                     
                                    <?php
                                    }
                                    ?>
                                    <tr>
                                         <td colspan="6"></td>
                                         <td> Total </td>
                                         <td><?php echo $t_qty;?></td>
                                         <td><?php echo $t_pending_po_qty;?></td>
                                       </tr>
                                    <?php
                                } 
                                else 
                                {
                                ?>  
                                    <tr><td colspan="11" align="center"><span class="label label-primary">No Records</span></td></tr>
                                <?php   
                                } ?> 
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
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer',$nestedView); ?>