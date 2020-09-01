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
                            <span class="caption-subject font-dark bold uppercase"><i class="fa fa-rupee?>"></i>Price List</span>
                        </div>
                </div>
                <div class="portlet-body">
                    <div class="tiles">
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'view_product_price_report_distributor/'.cmm_encode('1');?>">
                                    <div class="tile bg-blue">
                                        <div class="tile-body">
                                            <i class="fa fa-map-o"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Regular Price List</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'view_product_price_report_distributor/'.cmm_encode('3');?>">
                                    <div class="tile bg-purple">
                                        <div class="tile-body">
                                            <i class="fa fa-credit-card"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">CST Price List</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="col-md-3">
                                 <a href="<?php echo SITE_URL.'view_product_price_report_distributor/'.cmm_encode('5');?>">
                                    <div class="tile bg-green-jungle">
                                        <div class="tile-body">
                                            <i class="fa fa-rupee"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Rythu Bazar Price</div>
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
                            <span class="caption-subject font-dark bold uppercase"><i class="fa fa-rupee?>"></i>Distributor Information</span>
                        </div>
                </div>
                <div class="portlet-body">
                    <div class="tiles">
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'distributor_ledger';?>">
                                    <div class="tile bg-yellow-gold">
                                        <div class="tile-body">
                                            <i class="fa fa-briefcase"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Distributor Ledger</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'view_distributor_details/'.cmm_encode(get_sess_data('distributor_id'));?>">
                                    <div class="tile bg-green-steel">
                                        <div class="tile-body">
                                            <i class="fa fa-eye"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Details</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'login_dist_ob_print';?>">
                                    <div class="tile bg-yellow-casablanca">
                                        <div class="tile-body">
                                            <i class="fa fa-folder-open-o"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Pending OB</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'login_dist_do_print';?>">
                                    <div class="tile bg-yellow-saffron">
                                        <div class="tile-body">
                                            <i class="fa fa-tasks"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Pending DO</div>
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
                        <h5><b>Going to Expire:</b></h5>
                            <li><a href="<?php echo SITE_URL.'view_distributor_details/'.cmm_encode(get_sess_data('distributor_id'));?>">Bank Guarantee - (<?php echo get_no_of_bank_guarantee_going_expire(get_sess_data('distributor_id'));?>)</a></li>
                            <li><a href="<?php echo SITE_URL.'view_distributor_details/'.cmm_encode(get_sess_data('distributor_id'));?>">Agreements - (<?php echo get_no_of_agreements_going_expire(get_sess_data('distributor_id'));?>)</a></li>
                        <h5><b>Expired:</b></h5>
                            <li><a href="<?php echo SITE_URL.'view_distributor_details/'.cmm_encode(get_sess_data('distributor_id'));?>">Bank Guarantee - (<?php echo get_no_of_bank_guarantee_expired(get_sess_data('distributor_id'));?>)</a></li>
                            <li><a href="<?php echo SITE_URL.'view_distributor_details/'.cmm_encode(get_sess_data('distributor_id'));?>">Agreements - (<?php echo get_no_of_agreements_expired(get_sess_data('distributor_id'));?>)</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>