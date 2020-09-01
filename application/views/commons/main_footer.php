                                </div>
                                <!-- END PAGE CONTENT BODY -->
                            </div>
                            <!-- END CONTENT BODY -->
                        </div>
                        <!-- END CONTENT -->
                    </div>
                    <!-- END CONTAINER -->
                </div>
            </div>
            <div class="page-wrapper-row">
                <div class="page-wrapper-bottom">
                    <!-- BEGIN FOOTER -->
                    <!-- BEGIN INNER FOOTER -->
                    <div class="page-footer">
                        <div class="container"> 
                            <?php echo date('Y');?> &copy; AP OIL FED
                            <a style="float:right; margin-right:50px" href="<?php echo SITE_URL.'user_manuals';?>">User Manuals</a>
                        </div>
                    </div>
                    <div class="scroll-to-top">
                        <i class="icon-arrow-up"></i>
                    </div>
                    <!-- END INNER FOOTER -->
                    <!-- END FOOTER -->
                </div>
            </div>
        </div>

        <!-- BEGIN QUICK NAV -->
        <!--
        <nav class="quick-nav">
            <a class="quick-nav-trigger" href="#0">
                <span aria-hidden="true"></span>
            </a>
            <ul>
                <li>
                    <a href="https://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes" target="_blank" class="active">
                        <span>Purchase Metronic</span>
                        <i class="icon-basket"></i>
                    </a>
                </li>
                <li>
                    <a href="https://themeforest.net/item/metronic-responsive-admin-dashboard-template/reviews/4021469?ref=keenthemes" target="_blank">
                        <span>Customer Reviews</span>
                        <i class="icon-users"></i>
                    </a>
                </li>
                <li>
                    <a href="http://keenthemes.com/showcast/" target="_blank">
                        <span>Showcase</span>
                        <i class="icon-user"></i>
                    </a>
                </li>
                <li>
                    <a href="http://keenthemes.com/metronic-theme/changelog/" target="_blank">
                        <span>Changelog</span>
                        <i class="icon-graph"></i>
                    </a>
                </li>
            </ul>
            <span aria-hidden="true" class="quick-nav-bg"></span>
        </nav>
        <div class="quick-nav-overlay"></div>
        -->
        <!-- END QUICK NAV -->
        <!--[if lt IE 9]>
<script src="<?php echo assets_url(); ?>global/plugins/respond.min.js"></script>
<script src="<?php echo assets_url(); ?>global/plugins/excanvas.min.js"></script> 
<script src="<?php echo assets_url(); ?>global/plugins/ie8.fix.min.js"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo assets_url(); ?>global/plugins/jquery.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_url(); ?>global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_url(); ?>global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_url(); ?>global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_url(); ?>global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_url(); ?>global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="<?php echo assets_url(); ?>global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo assets_url();?>global/plugins/jquery-validation/js/jquery.validate.js"></script>
        <script src="<?php echo assets_url(); ?>global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>

        <script src="<?php echo assets_url(); ?>global/scripts/app.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo assets_url(); ?>pages/scripts/components-select2.js"></script>
        <script src="<?php echo assets_url(); ?>pages/scripts/components-date-time-pickers.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_url(); ?>pages/scripts/timer.js" type="text/javascript"></script>

        
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN EXTERNAL JS -->
        <?php
        if(isset($js_includes))
        {
            if(count($js_includes)>0)
            {
              foreach($js_includes as $js_file)
              {
                  echo @$js_file;
              }
            }
        }
        ?>
        <!-- END EXTERNAL JS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="<?php echo assets_url(); ?>layouts/layout3/scripts/layout.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_url(); ?>layouts/layout3/scripts/demo.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_url(); ?>layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="<?php echo assets_url(); ?>layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        <script type="text/javascript">
       	$('.numeric').bind('keypress', function(e){  
            var asciiCodeOfNumbers = [ 8, 48,46, 49, 50, 51, 52, 53, 54, 54, 55, 56, 57];
            var keynum = (!window.event) ? e.which : e.keyCode; 
            var val = this.value;
            var numlenght = val.length;
            var splitn = val.split("."); 
            var decimal = splitn.length;
            var precision = splitn[1];
            var startPos = this.selectionStart;
            var decimalIndex = val.indexOf('.'); 
            if(decimal == 2) {  
                if(decimalIndex < startPos){
                    if(precision.length >= 2){
                      e.preventDefault();  
                    }
                } 
            } 
            if( keynum == 46 ){  
                if(startPos < (numlenght-2)){
                    e.preventDefault(); 
                }
                if(decimal >= 2) { e.preventDefault(); }  
            } 
            if ($.inArray(keynum, asciiCodeOfNumbers) == -1)
                e.preventDefault();    
        });

        function Comma(Num)
        {
            Num += '';
            Num = Num.replace(/,/g, '');

            x = Num.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';

            var rgx = /(\d)((\d)(\d{2}?)+)$/;

            while (rgx.test(x1))

            x1 = x1.replace(rgx, '$1' + ',' + '$2');

            return x1 + x2;        
        }
        </script>
    </body>
<?php //update_userLastActive();?>
</html>