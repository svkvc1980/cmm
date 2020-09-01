<div class="row">
    <div class="col-md-8">
       <div class="block-flat">
            <div class="portlet light">
                <div class="portlet-title">
                    <div class="col-sm-0"></div>
                        <div class="caption">
                            <i class="icon-edit font-dark"></i>
                            <span class="caption-subject font-dark bold uppercase"><i class="fa fa-rupee?>"></i>Lab Test</span>
                        </div>
                </div>
                <div class="portlet-body">
                    <div class="tiles">
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'lab_test_report'?>">
                                    <div class="tile bg-blue">
                                        <div class="tile-body">
                                            <i class="fa fa-edit"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Lab Test (Oils)</div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="tile">
                            <div class="col-md-3">
                                <a href="<?php echo SITE_URL.'packing_material_test'?>">
                                    <div class="tile bg-purple">
                                        <div class="tile-body">
                                            <i class="fa fa-edit"></i>
                                        </div>
                                        <div class="tile-object">
                                            <div class="name">Lab Test (Packing Materials)</div>
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
                            <h5><b>Today Actions:</b></h5>
                        <li><a href="<?php echo SITE_URL.'tanker_register';?>">Lab Test Oils - (<?php echo get_no_of_tanker_in();?>)</a></li>
                        <li><a href="<?php echo SITE_URL.'manage_dist_invoice';?>">Lab Test Packing Materials - (<?php echo get_no_of_sales();?>)</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>