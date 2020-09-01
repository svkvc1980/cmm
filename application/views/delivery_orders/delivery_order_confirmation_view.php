 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">

    <div class="row">
        <div class="col-md-12">
        <?php if(isset($flg)) {                 		
            if($flg==1)
            {
		?>
        <div class="portlet light portlet-fit">
         <div class="portlet-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">  
                        <label for="inputName" class="col-sm-5 control-label" required><b>DO No</b></label>
                        <div class="col-sm-6">
                          <label>36603</label>  
                        </div>
                </div>
                </div>
                 <div class="col-md-3">
                    <div class="form-group">  
                        <label for="inputName" class="col-sm-5 control-label" required><b>DO Date</b></label>
                        <div class="col-sm-6">
                          <label>2017-01-11</label>  
                        </div>
                </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">  
                        <label for="inputName" class="col-sm-5 control-label" required><b>DB No</b></label>
                        <div class="col-sm-6">
                          <label>26319</label>  
                        </div>
                </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">  
                        <label for="inputName" class="col-sm-5 control-label" required><b>OB Date</b></label>
                        <div class="col-sm-6">
                          <label>2017-01-11</label>  
                        </div>
                </div>
                </div>

            </div>
            </div>
         </div>
         </div>
		<div class="row">
       		<div class="col-md-6">
       		<div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-map-marker"></i> Distributor Address </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                    </div>
                </div>
                <div class="portlet-body" style="display: block; height:230px;">  
                	<div class="col-sm-6">
                	<p><b>Details</b> &nbsp; Testing Dealer</p>	
                	<p><b>Phone</b> &nbsp; 254055</p>	
                	<p><b>SD Amount</b> &nbsp; <?php echo indian_format_price(1400.00) ?></p>
                	<p><b>Agreement Start Date</b> &nbsp; 2016-01-11</p>                	
			        </div>
			        <div class="col-sm-6">
                	<p><b></b>&nbsp;</p>	
                		
                	<p><b>Mobile</b> &nbsp; 91+ 8096636672</p>
                	<p><b>Total Outstanding</b> &nbsp; <?php echo indian_format_price(1700.00) ?></p>
                	<p><b>Agreement Expire Date</b> &nbsp; 2016-01-22</p>	
			        </div>
                	<form class="form-horizontal" role="form">
	                	<div class="form-group">
			               
			            </div>
                    </form>
                </div>
            </div>
       		</div>	
       		<div class="col-md-6">
       			<div class="portlet box green">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-bank"></i> Bank Guarantee </div>
                    <div class="tools">
                        <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>                       
                    </div>
                </div>
                <div class="portlet-body" style="display: block; height:230px;">                   
                    <table class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th> S.No</th>
                                <th> Start Date </th>
                                <th> Expire Date </th> 
                                 <th> Bank </th>
                                <th> BG Amount </th>             
                            </tr>
                        </thead>
                        <tbody>
                        	<tr>
                        		<td>1</td>
                        		<td>2017-01-11</td>
                        		<td>2017-01-23</td>
                        		<td>SBI</td>
                        		<td><?php echo indian_format_price(1200.00) ?></td>
                        	</tr>
                        	<tr>
                        		<td>1</td>
                        		<td>2017-01-11</td>
                        		<td>2017-01-23</td>
                        		<td>SBI</td>
                        		<td><?php echo indian_format_price(1400.00) ?></td>
                        	</tr>
                        	<tr>
                        		<td colspan="5" align="right"><b>Total Amount:</b> &nbsp; <?php echo indian_format_price(2600.00) ?></td>
                        	</tr>
                        	<br>
                        </tbody>
                    </table>
                    <p align="right"><b>Available Amount:</b> &nbsp; <?php echo indian_format_price(5700.00) ?></p>
                </div> 
            </div>
       		</div>			
		</div>
		<form id="bank_info_form" method="post" action="<?php echo SITE_URL;?>delivery_order_confirmation_view" enctype="multipart/form-data">                                        
            <input type="hidden" class="form-control" name="encoded_id" value="" />  

            <div class="alert alert-danger display-hide" style="display: none;">
               <button class="close" data-close="alert"></button> Please Fill All Fields mentioned Below. 
            </div>
            
            <div class="table-scrollable">
                <table class="table table-bordered table-striped table-hover" id="bank_info">
                    <thead>
                        <tr>
                            
                            <th> S.NO </th>
                            <th> Product Name </th>
                            <th> Price </th>                                                          
                            <th> No. of cartoons </th>
                            <th> No. of Packets </th>
                            <th> Quantity in Kgs </th>
                            <th> Amount </th>
                                      
                        </tr>
                    </thead>
                    <tbody>
                        
                        <div class="form-group">
                                <tr>
                                    <td>1</td>
                                    <td> Sun1LtSH</td>
                                    <td>76.5</td>
                                    <td>1</td>
                                    <td>16</td>
                                    <td>14.57</td>
                                    <td>1217</td>
                                </tr> 
                                <tr>
                                  
                                    <td colspan="7" align="right">
                                       <b>Total:</b> &nbsp; 1217
                                    </td>
                                </tr>     
                                                                                                 
                        </div>
                       
                    

                    
                    </tbody>
                </table>
            </div>
            <div class="form-actions">
                <div class="row">
                    <div class="col-md-offset-3 col-md-6">
                        <a href="#" class="btn blue">Send SMS</a>
                        <a href="#" class="btn blue">New DO</a>
                          <a href="#" class="btn blue">Main Page</a>
                        
                    </div>
                </div>  
            </div>

            
        </form>
            
       
        <?php } }
        ?>
        </div>
    </div>
</div>
<?php $this->load->view('commons/main_footer', $nestedView); ?>
