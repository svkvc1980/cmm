 <?php $price_alert =  price_change_alert_text();
if($price_alert!='')
{
 ?>
 <marquee class="font-blue-steel bold" onmouseover="this.stop();" onmouseout="this.start();">
 <?php echo $price_alert;?>   
 </marquee>
 <?php
}
 ?>
<div class="row">
    <div class="col-md-8">
       <div class="block-flat">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="col-sm-0"></div>
                        <div class="caption">
                            <i class="icon-edit font-dark"></i>
                            <span class="caption-subject font-dark bold uppercase"><i class="fa fa-rupee?>"></i>Sales</span>
                        </div>
                </div>
                <div class="portlet-body">
                    <div class="tiles">
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'distributor_ob'?>">
                                    <div class="tile bg-yellow-saffron">
                                        <div class="tile-body">
                                            <i class="fa fa-tasks"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Unit O.B.</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'plant_do'?>">
                                    <div class="tile bg-green-steel">
                                        <div class="tile-body">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Unit D.O.</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'distributor_ob'?>">
                                    <div class="tile bg-yellow-casablanca">
                                        <div class="tile-body">
                                            <i class="fa fa-edit"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Dist O.B.</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'delivery_order'?>">
                                    <div class="tile bg-yellow">
                                        <div class="tile-body">
                                            <i class="fa fa-tasks"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Dist D.O.</div>
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
                            <span class="caption-subject font-dark bold uppercase"><i class="fa fa-rupee?>"></i>Entries</span>
                        </div>
                </div>
                <div class="portlet-body">
                    <div class="tiles">
                        <div class="tile">
                            
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'dd_receipts';?>">
                                    <div class="tile bg-yellow-gold">
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
                                <a href="<?php echo SITE_URL.'dist_invoice_entry'?>">
                                    <div class="tile bg-blue">
                                        <div class="tile-body">
                                            <i class="fa fa-gg"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Invoice</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'stock_receiving'?>">
                                    <div class="tile bg-green-jungle">
                                        <div class="tile-body">
                                            <i class="fa fa-clone"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Stock Receving</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'godown_leakage_entry'?>">
                                    <div class="tile bg-red">
                                        <div class="tile-body">
                                            <i class="fa fa-map-o"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Godown Leakage</div>
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
                        <li><a href="<?php echo SITE_URL.'distributor_do_list';?>">Pending Do's- (<?php echo get_pending_do_count();?>)</a></li>
                            <h5><b>Today Actions:</b></h5>
                        <li><a href="<?php echo SITE_URL.'manage_dist_invoice';?>">Sales- (<?php echo get_no_of_sales();?>)</a></li>
                        <li><a href="<?php echo SITE_URL.'stock_receiving';?>">Stock Receving- (<?php echo get_stock_receiving_count();?>)</a></li>
                        <li><a href="<?php echo SITE_URL.'godown_to_countersale';?>">Godown-Counter- (<?php echo get_godown_count();?>)</a></li>
                        <li><a href="<?php echo SITE_URL.'countersale_to_godown';?>">Counter-Godown- (<?php echo get_counter_count();?>)</a></li>
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