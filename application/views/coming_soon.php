<?php $this->load->view('commons/main_template', $nestedView); ?>
 <!-- BEGIN PAGE CONTENT INNER -->

<div class="page-content-inner">
    <div class="header text-center">
        <span class="timer_block" style="float:right;">
        <i class="fa fa-clock-o"></i>
        <span id="timer"></span>
        </span>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                	<div class="row">
                        <div class="col-md-12 page-404">
                            <div class="number font-red"><h1>Coming Soon</h1></div>
                            <div class="details">
                                <h3>Page Under Construction !</h3>
                                <p> We will update the page you're looking for.
                                    <br/>
                                    <a href="<?php echo SITE_URL;?>"> <u>Back to Home</u></a> </p>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    
</div>
<?php $this->load->view('commons/main_footer', $nestedView); ?>