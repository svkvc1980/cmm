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
                                <a href="<?php echo SITE_URL.'manage_production'?>">
                                    <div class="tile bg-blue">
                                        <div class="tile-body">
                                            <i class="fa fa-edit"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Production Entry</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'leakage_entry_list'?>">
                                    <div class="tile bg-yellow-casablanca">
                                        <div class="tile-body">
                                            <i class="fa fa-edit"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Leakage Entry</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'view_leakage_recovery_details'?>">
                                    <div class="tile bg-yellow-saffron">
                                        <div class="tile-body">
                                            <i class="fa fa-tasks"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Leakage Recovery</div>
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
                        <?php $on_date = get_oil_stock_balance_entry_record();
                              $current_time = get_current_time();
                        if($on_date==0 && $current_time<=date('10:30:00')) { ?>


                        <li><a href="<?php echo SITE_URL.'manage_oil_stock_balance';?>">Oil Opening Balance Entry</a>
                      <?php if($on_date==0 && $current_time>=date('10:00:00') && $current_time<=date('10:30:00'))
                            {?>
                            <span>
                                <div class="round-button">
                                    <div class="round-button-circle equip-warning blink_me">
                                        <span class="round-button round-button round-button-circle equip-warning blink_me"></span>
                                    </div>
                                </div>
                            </span><?php } echo "</li>"; }?>
                            <h5><b>Today Actions:</b></h5>
                        <li><a href="<?php echo SITE_URL.'manage_production';?>">Production Entry's - (<?php echo get_no_of_production_entry();?>)</a></li>
                            
                        <?php if($on_date==0 && $current_time>=date('10:30:01')){?>
                            <h5><b>Missed Actions:</b></h5>
                        <li><a href="">Oil Opening Balance Entry</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>