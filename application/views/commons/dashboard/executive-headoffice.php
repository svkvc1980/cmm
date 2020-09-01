<div class="row">
    <div class="col-md-8">
       <div class="block-flat">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="col-sm-0"></div>
                        <div class="caption">
                            <i class="icon-edit font-dark"></i>
                            <span class="caption-subject font-dark bold uppercase"><i class="fa fa-rupee?>"></i>Payments</span>
                        </div>
                </div>
                <div class="portlet-body">
                    <div class="tiles">
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'dd_receipts';?>">
                                    <div class="tile bg-blue">
                                        <div class="tile-body">
                                            <i class="fa fa-edit"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">DD Entry (Dist)</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'distributor_credit_debit_note';?>">
                                    <div class="tile bg-purple">
                                        <div class="tile-body">
                                            <i class="fa fa-credit-card"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Credit/Debit (Dist)</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'c_and_f';?>">
                                    <div class="tile bg-green-jungle">
                                        <div class="tile-body">
                                            <i class="fa fa-edit"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">DD Entry (C&F)</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'c_and_f_credit_debit_note';?>">
                                    <div class="tile bg-red">
                                        <div class="tile-body">
                                            <i class="fa fa-credit-card"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Credit/Debit (C&F)</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block-flat">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="col-sm-0"></div>
                        <div class="caption">
                            <i class="icon-edit font-dark"></i>
                            <span class="caption-subject font-dark bold uppercase"><i class="fa fa-rupee?>"></i>Order Booking</span>
                        </div>
                </div>
                <div class="portlet-body">
                    <div class="tiles col-md-offset-1">
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'distributor_ob';?>">
                                    <div class="tile bg-yellow-gold">
                                        <div class="tile-body">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Order Booking</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'delivery_order';?>">
                                    <div class="tile bg-green-steel">
                                        <div class="tile-body">
                                            <i class="fa fa-bullhorn"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Delivery Order</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'product_price';?>">
                                    <div class="tile bg-yellow-casablanca">
                                        <div class="tile-body">
                                            <i class="fa fa-rupee"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Price Updation</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="block-flat">
            <div class="portlet light" style="padding-bottom: 10px;padding-left: 15px;padding-right: 15px;padding-top: 0px;">
                <div style="background:#ff7300;color:#ffffff;padding-left:20px;" class="header row">
                    <h4><i class="fa fa-warning"></i><b> Alerts</b></h4>
                </div><br>
                <div class="content">
                    <ul class="list-unstyled">
                            <h5><b>Pending Tasks:</b></h5>
                        <li><a href="<?php echo SITE_URL.'distributor_payments';?>">Distributors DD Verification- (<?php echo get_dist_dd_entry();?>)</a></li>
                        <li><a href="<?php echo SITE_URL.'cd_candf_r';?>">C&F Credit/Debit- (<?php echo get_candf_credit_debit_count();?>)</a></li>
                        <li><a href="<?php echo SITE_URL.'c_and_f_payments';?>">C&F DD Verification- (<?php echo get_candf_dd_entry();?>)</a></li>
                        <li><a href="<?php echo SITE_URL.'approval_list';?>">Pending Approvals (<?php echo get_pending_approvals();?>)</a>
                            <?php  $value = get_pending_approvals();
                             if($value>0)
                            {?>
                            <span>
                                <div class="round-button">
                                    <div class="round-button-circle equip-warning blink_me">
                                        <span class="round-button round-button round-button-circle equip-warning blink_me"></span>
                                    </div>
                                </div>
                            </span><?php } ?></li>
                            <h5><b>Today Actions:</b></h5>
                        <li><a href="<?php echo SITE_URL.'distributor_ob_list';?>">Order Booking's- (<?php echo get_order_booking_entry();?>)</a></li>
                        <li><a href="<?php echo SITE_URL.'distributor_do_list';?>">Delivery Order's- (<?php echo get_delivery_order_entry();?>)</a></li>
                        <li><a href="<?php echo SITE_URL.'c_d_distributor_r';?>">Distributors Credit/Debit- (<?php echo get_dist_credit_debit_entry();?>)</a></li>
                        <li><a href="<?php echo SITE_URL.'cd_candf_r';?>">C&F Credit/Debit- (<?php echo get_candf_credit_debit_entry();?>)</a></li>
                            <h5><b>Going to Expire:</b></h5>
                        <li><a href="<?php echo SITE_URL.'bg_going_expired_print';?>">Bank Guarantee - (<?php echo get_no_of_bank_guarantee_going_expire();?>)</a></li>
                        <li><a href="<?php echo SITE_URL.'agreement_going_expired_print';?>">Agreements - (<?php echo get_no_of_agreements_going_expire();?>)</a></li>
                            <h5><b>Expired:</b></h5>
                        <li><a href="<?php echo SITE_URL.'bg_expired_print';?>">Bank Guarantee - (<?php echo get_no_of_bank_guarantee_expired();?>)</a></li>
                        <li><a href="<?php echo SITE_URL.'agreement_expired_print';?>">Agreements - (<?php echo get_no_of_agreements_expired();?>)</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
    <marquee class="bg-default bg-font-default" onmouseover="this.stop();" onmouseout="this.start();">
    <span style="color:#000000"><b>Godown Stock---></b></span>
    <span style="color:red">At Present Available Stocks Are <b style="color:#8877A9"><?php echo qty_format($sum); ?></b> (MT's)</span>
    <span style="color:#FF9900"><b>::</b></span>
    <?php 
    foreach($stock_scroll as $row)
    {
    ?>  
        <span style="color:#000000"><?php echo $row['name'].'-' ?></span>
        <span style="color:#000000"><b><?php echo qty_format($row['tot_oil_weight']).'(MT)' ?></b></span>
        <span style="color:#FF9900"><b>::</b></span> <?php
    }
    ?>
    <a type="submit" href="<?php echo SITE_URL?>stock_print_scroll" style="color:#FF9900">Click Here To print</a></marquee>
    </div>
    <div class="row"> <?php  $column=array_column($sales_scroll,'pending_qty');
        $sales_sum=array_sum($column) ?>
    <marquee class="bg-default bg-font-default" onmouseover="this.stop();" onmouseout="this.start();">
    <span style="color:#000000"><b>Sales---></b></span>
    <span style="color:red">At Present Sales Are <b style="color:#8877A9"><?php echo qty_format($sales_sum); ?></b> (MT's)</span>
    <span style="color:#FF9900"><b>::</b></span>
    <?php 
    if(count($sales_scroll)>0)
    {
        foreach($sales_scroll as $value)
        { ?>
                <span style="color:#000000"><?php echo $value['plant_name'].'-' ?></span>
                <span style="color:#000000"><b><?php echo qty_format($value['pending_qty']); ?></b></span>
                <span style="color:#FF9900"><b>::</b></span> 
        <?php 
            
          
        }
    }?>

    <a type="submit" href="<?php echo SITE_URL?>sales_print_scroll" style="color:#FF9900">Click Here To print</a></marquee>
    </div>
</div>
