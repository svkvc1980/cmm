<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                    <form method="post" action="<?php echo SITE_URL.'oil'?>">
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-md-4 control-label">Purchase Order</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="purchase_order" value="<?php echo @$po_id;?>">
                                        <b><?php echo  @$po_id;?></b>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Date</label>
                                    <div class="col-md-6">
                                        <input type="hidden" name="date" value="<?php echo date('Y-m-d');?>">
                                        <b><?php echo date('Y-m-d');?></b>
                                    </div>
                                </div>
                            </div>
                        </div></br>
                          <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Free Gifts</label>
                                    <div class="col-md-6">
                                        <select name="free_gifts" class="form-control">
                                            <option value="">Select Free Gifts</option>
                                            <option value="1">Coconut hair oil</option>
                                            <option value="1">Colgate 100gm</option>
                                            <option value="1">Honey 50gm</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Purchase Mode</label>
                                    <div class="col-md-6">
                                        <select  class="form-control purchase_mode"  name="purchase_mode" >
                                            <option selected value="">-Select Purchase Mode-</option>
                                            <option value="1">OCB(Open Competition Bid)</option>
                                            <option value="2">Nomination</option>
                                            <option value="3">Repeat Order</option>
                                        </select> 
                                    </div>
                                </div>
                            </div>
                        </div></br>
                         <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label ">Quantity(Mts)</label>
                                    <div class="col-md-6">
                                       <input class="form-control numeric" name="qty" value="<?php echo @$lrow['qty'];?>"  type="text">
                                    </div>
                                </div>
                            </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Rate</label>
                                    <div class="col-md-6">
                                       <input class="form-control numeric" name="rate" value="<?php echo @$lrow['rate'];?>"  type="text">
                                    </div>
                                </div>
                            </div>
                        </div></br>
                        <div class="table-scrollable ocb">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> Broker Name</th>
                                        <th> Distributor</th>
                                        <th> Qty in M.T.S </th>
                                        <th> Rate Per M.T</th>
                                        <th> Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="srow">
                                        <td>
                                            <select  class="form-control"  name="broker_name" >
                                                <option selected value="">-Select Broker Name-</option>
                                                <?php 
                                                 foreach($broker as $bro)
                                                    {
                                                        $selected = '';
                                                        if($bro['broker_id'] ==@$broker_id ) $selected = 'selected';
                                                        echo '<option value="'.$bro['broker_id'].'" '.$selected.'>'.$bro['agency_name'].'</option>';
                                                    }
                                                ?>
                                            </select> 
                                        </td>
                                        <td>
                                            <input class="form-control" name="distributor" value="<?php echo @$lrow['distributor'];?>"  type="text">
                                        </td>
                                        <td>
                                            <input class="form-control numeric" name="qty" value="<?php echo @$lrow['qty'];?>"  type="text">
                                        </td>
                                        <td>
                                            <input class="form-control numeric" name="rate" value="<?php echo @$lrow['rate'];?>" type="text"> 
                                        </td>
                                        <td>
                                            <input class="form-control numeric" name="Total_amount" value="<?php echo @$lrow['total_amount'];?>" type="text"> 
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div></br>
                        <div class="nomination">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">Broker Name</label>
                                    <div class="col-md-6">
                                        <select  class="form-control"  name="broker_name" >
                                            <option selected value="">-Select Broker Name-</option>
                                            <?php 
                                             foreach($broker as $bro)
                                                {
                                                    $selected = '';
                                                    if($bro['broker_id'] ==@$broker_id ) $selected = 'selected';
                                                    echo '<option value="'.$bro['broker_id'].'" '.$selected.'>'.$bro['agency_name'].'</option>';
                                                }
                                            ?>
                                        </select> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Distributor</label>
                                    <div class="col-md-6">
                                       <input class="form-control" name="distributor" value="<?php echo @$lrow['distributor'];?>"  type="text">
                                    </div>
                                </div>
                            </div>
                        </div></br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label ">Quantity(Mts)</label>
                                    <div class="col-md-6">
                                       <input class="form-control numeric" name="qty" value="<?php echo @$lrow['qty'];?>"  type="text">
                                    </div>
                                </div>
                            </div>
                              <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Rate</label>
                                    <div class="col-md-6">
                                       <input class="form-control numeric" name="rate" value="<?php echo @$lrow['rate'];?>"  type="text">
                                    </div>
                                </div>
                            </div>
                        </div></br>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-4 control-label ">Total Amount</label>
                                    <div class="col-md-6">
                                       <input class="form-control numeric" name="total_amount" value="<?php echo @$lrow['total_amount'];?>"  type="text">
                                    </div>
                                </div>
                            </div>
                        </div></br>
                        </div>
                        <div>
                            <div class="row">
                                <div class="col-md-offset-5 col-md-4">
                                     <input type="submit" class="btn blue tooltips" name="submit">
                                     <a href="<?php echo SITE_URL.'oil';?>" class="btn default">Cancel</a>
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
$(document).ready(function(){
    $('.ocb,.nomination').hide();
    $('.purchase_mode').change(function(){
    var mode=$(this).val();
   // alert(mode);
    if(mode==1)
    {
        $('.ocb').show();
        $('.nomination').hide();
    }
    else
    {
        $('.ocb').hide();
        $('.nomination').show();   
    }
    });

});
    
   
</script>