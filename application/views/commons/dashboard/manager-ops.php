<div class="row">
    <div class="col-md-8">
       <div class="block-flat">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="col-sm-0"></div>
                        <div class="caption">
                            <i class="icon-edit font-dark"></i>
                            <span class="caption-subject font-dark bold uppercase"><i class="fa fa-rupee?>"></i>Production</span>
                        </div>
                </div>
                <div class="portlet-body">
                    <div class="tiles">
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'view_oil_details'?>">
                                    <div class="tile bg-blue">
                                        <div class="tile-body">
                                            <i class="fa fa-edit"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Purchase Order (Oils)</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'manage_oil_stock_balance'?>">
                                    <div class="tile bg-purple">
                                        <div class="tile-body">
                                            <i class="fa fa-credit-card"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Stock Balance(Oil)</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="">
                                    <div class="tile bg-green-jungle">
                                        <div class="tile-body">
                                            <i class="fa fa-clone"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Stock Balance(PM)</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'product_stock'?>">
                                    <div class="tile bg-red">
                                        <div class="tile-body">
                                            <i class="fa fa-map-o"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Stock List</div>
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
                            <span class="caption-subject font-dark bold uppercase"><i class="fa fa-rupee?>"></i>Sales</span>
                        </div>
                </div>
                <div class="portlet-body">
                    <div class="tiles">
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'manage_dist_invoice'?>">
                                    <div class="tile bg-yellow-gold">
                                        <div class="tile-body">
                                            <i class="fa fa-bullhorn"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Dist Invoice</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'plant_invoice_entry'?>">
                                    <div class="tile bg-green-steel">
                                        <div class="tile-body">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Plant Invoice</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'free_sample_list'?>">
                                    <div class="tile bg-yellow-casablanca">
                                        <div class="tile-body">
                                            <i class="fa fa-edit"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Free Samples</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'loose_oil_mrr'?>">
                                    <div class="tile bg-yellow-saffron">
                                        <div class="tile-body">
                                            <i class="fa fa-tasks"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Oil M.R.R.</div>
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
                        <?php $on_date = get_oil_stock_balance_entry_record();
                              $current_time = strtotime(get_current_time());
                              $check_time = strtotime(get_opening_balance_reading_time());
                              $from_time = strtotime(date("H:i",strtotime('-30 minutes',$check_time)));
                        if($on_date==0 && $current_time<=$check_time) { ?>


                        <li><a href="<?php echo SITE_URL.'manage_oil_stock_balance';?>">Oil Opening Balance Entry</a>
                      <?php if($on_date==0 && $current_time>=$from_time && $current_time<=$check_time)
                            {?>
                            <span>
                                <div class="round-button">
                                    <div class="round-button-circle equip-warning blink_me">
                                        <span class="round-button round-button round-button-circle equip-warning blink_me"></span>
                                    </div>
                                </div>
                            </span><?php } echo "</li>"; }?>
                            <h5><b>Today Actions:</b></h5>
                        <li><a href="<?php echo SITE_URL.'tanker_register';?>">Tanker In's - (<?php echo get_no_of_tanker_in();?>)</a></li>
                        <li><a href="<?php echo SITE_URL.'manage_dist_invoice';?>">Sales - (<?php echo get_no_of_sales();?>)</a></li>
                        <li><a href="<?php echo SITE_URL.'production_report';?>">Production Entry's - (<?php echo get_no_of_production_entry();?>)</a></li>
                            
                        <?php if($on_date==0 && $current_time>=$check_time){?>
                            <h5><b>Missed Actions:</b></h5>
                        <li><a href="" style="color: red;">Oil Opening Balance Entry</a></li>
                        <?php } ?>
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