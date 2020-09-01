 <?php $this->load->view('commons/main_template', $nestedView); ?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
        <?php if(isset($flg)) {                 		
            if($flg==1)
            {
		?>
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
                <div class="portlet-body" style="display: block; height:248px;">  
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
                <div class="portlet-body">                           
                      <table class="table table-striped table-bordered table-hover order-column table-fixed" id="sample_1">
                        <thead style="display:table;table-layout:fixed;width:100%">
                            <tr>
                                <th> S.No</th>
                                <th> Start Date </th>
                                <th> Expire Date </th> 
                                <th> Bank </th>
                                <th> BG Amount </th>             
                            </tr>
                        </thead>
                        <tbody style="display:block;height:80px;table-layout:fixed;overflow:auto">
                        	<tr style="display:table;width:100%;table-layout:fixed">
                        		<td>1</td>
                        		<td>2017-01-11</td>
                        		<td>2017-01-23</td>
                        		<td>SBI</td>
                        		<td><?php echo indian_format_price(1200.00) ?></td>
                        	</tr>
                        	<tr style="display:table;width:100%;table-layout:fixed">
                        		<td>1</td>
                        		<td>2017-01-11</td>
                        		<td>2017-01-23</td>
                        		<td>SBI</td>
                        		<td><?php echo indian_format_price(1400.00) ?></td>
                        	</tr>                        	
                        	
                        </tbody>
                        <tfoot>
                        	<tr style="display:table;width:100%;table-layout:fixed">
                        		<td colspan="5" align="right"><b>Total Amount:</b> &nbsp; <?php echo indian_format_price(2600.00) ?></td>
                        	</tr></tfoot>
                    </table>
                    <p align="right"><b>Available Amount:</b> &nbsp; <?php echo indian_format_price(5700.00) ?></p>
                </div> 
            </div>
       		</div>			
		</div>
		<div class="portlet box green">
            <div class="portlet-title">
                <div class="caption">
                   <!--  <i class="fa fa-gift"></i> --> Product Details</div>
                <div class="tools">
                    <a href="javascript:;" class="collapse"> </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class="panel-group accordion" id="accordion3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_1">Sun Flower Oil </a>
                            </h4>
                        </div>
                        <div id="collapse_3_1" class="panel-collapse in">
                            <div class="panel-body">
			                    <table class="table table-bordered" cellspacing="0" cellpadding="5" border="0" style="padding-left:50px;">
									<tr style="background-color:#ccc">								
										<th>Product Name</th>
										<th>Price &nbsp; &nbsp; + &nbsp; Added Price</th>													
										<th>Ordered Quantity</th>
										<th>Ordered Value</th>
									</tr>
									<tbody>
										<tr>
											<td>Sun Flower Oil 15 kg Jar</td>
											<td><input class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:50px" value="" type="text"> + <input id="" name="selectall" style="width:50px" value="" type="text"> = <input id="" name="selectall" style="width:70px" value="" type="text"> &nbsp; (1000)</td>
											<td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:80px;" value="" type="text"></td>
											<td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall"  style="width:80px" value="" type="text"></td>
										</tr>
										<tr>
											<td>Sun Flower Oil 1/2 Ltr Sachet</td>
											<td><input id="" name="selectall" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" style="width:50px" value="" type="text"> + <input id="" name="selectall" style="width:50px" value="" type="text"> = <input id="" name="selectall" style="width:70px" value="" type="text"> &nbsp; (1070)</td>
											<td><input id="" name="selectall" style="width:80px" value="" type="text"></td>
											<td><input id="" name="selectall" style="width:80px" value="" type="text"></td>
										</tr>
									</tbody>
								</table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_2"> Groundnut Oil </a>
                            </h4>
                        </div>
                        <div id="collapse_3_2" class="panel-collapse collapse">
                            <div class="panel-body" style="height:200px; overflow-y:auto;">
                                <table class="table table-bordered" cellspacing="0" cellpadding="5" border="0" style="padding-left:50px;">
									<tr style="background-color:#ccc">								
										<th>Product Name</th>
										<th>Price + Added Price</th>													
										<th>Ordered Quantity</th>
										<th>Ordered Value</th>
									</tr>
									<tbody>
										<tr>
											<td>Groundnut Oil 15 kg Jar</td>
											<td><input class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:50px" value="" type="text"> + <input id="" name="selectall" style="width:50px" value="" type="text"> = <input id="" name="selectall" style="width:70px" value="" type="text"> &nbsp; (1500)</td>
											<td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall"   style="width:80px" value="" type="text"></td>
											<td><input id="" name="selectall" style="width:80px"  value="" type="text"></td>
										</tr>
										<tr>
											<td>Groundnut Oil 1/2 Ltr Sachet</td>
											<td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:50px" value="" type="text"> + <input id="" name="selectall" style="width:50px" value="" type="text"> = <input id="" name="selectall" style="width:70px" value="" type="text"> &nbsp; (2000)</td>
											<td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:80px" value="" type="text"></td>
											<td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:80px" value="" type="text"></td>
										</tr>
									</tbody>
								</table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_3"> Soyabean Oil </a>
                            </h4>
                        </div>
                        <div id="collapse_3_3" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table class="table table-bordered" cellspacing="0" cellpadding="5" border="0" style="padding-left:50px;">
									<tr style="background-color:#ccc">								
										<th>Product Name</th>
										<th>Price + Added Price</th>													
										<th>Ordered Quantity</th>
										<th>Ordered Value</th>
									</tr>
									<tbody>
										<tr>
											<td>Soyabean Oil 15 kg Jar</td>
											<td><input class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:50px" value="" type="text"> + <input id="" name="selectall" style="width:50px" value="" type="text"> = <input id="" name="selectall" style="width:70px" value="" type="text"> &nbsp; (1230)</td>
											<td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall"  style="width:80px" value="" type="text"></td>
											<td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall"  style="width:80px" value="" type="text"></td>
										</tr>
										<tr>
											<td>Soyabean Oil 1/2 Ltr Sachet</td>
											<td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:50px" value="" type="text"> + <input id="" name="selectall" style="width:50px" value="" type="text"> = <input id="" name="selectall" style="width:70px" value="" type="text"> &nbsp; (1560)</td>
											<td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall"  style="width:80px" value="" type="text"></td>
											<td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:80px" value="" type="text"></td>
										</tr>
									</tbody>
								</table>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_4"> Coconut Oil </a>
                            </h4>
                        </div>
                        <div id="collapse_3_4" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table class="table table-bordered" cellspacing="0" cellpadding="5" border="0" style="padding-left:50px;">
									<tr style="background-color:#ccc">								
										<th>Product Name</th>
										<th>Price + Added Price</th>													
										<th>Ordered Quantity</th>
										<th>Ordered Value</th>
									</tr>
									<tbody>
										<tr>
											<td>Coconut Oil 15 kg Jar</td>
											<td><input class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:50px" value="" type="text"> + <input id="" name="selectall" style="width:50px" value="" type="text"> = <input id="" name="selectall" style="width:70px" value="" type="text"> &nbsp; (1060)</td>
											<td><input class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" id="" name="selectall"  style="width:80px"  value="" type="text"></td>
											<td><input class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" id="" name="selectall"  style="width:80px" value="" type="text"></td>
										</tr>
										<tr>
											<td>Coconut Oil 1/2 Ltr Sachet</td>
											<td><input class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" id="" name="selectall" style="width:50px" value="" type="text"> + <input id="" name="selectall" style="width:50px" value="" type="text"> = <input id="" name="selectall" style="width:70px" value="" type="text"> &nbsp; (1600)</td>
											<td><input class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" id="" name="selectall"  style="width:80px" value="" type="text"></td>
											<td><input class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" id="" name="selectall" style="width:80px" value="" type="text"></td>
										</tr>
									</tbody>
								</table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-5"></div>
                <div class="col-md-6">
                    <button class="btn green" type="submit" name="submitPage" value="button">Submit</button>
                    <a href="<?php echo SITE_URL.'order_booking';?>" class="btn default">Cancel</a>
                </div>
            </div>
            </div>
        </div>
       
      <?php } }
        if(@$display_results==1){
        ?>
            <div class="portlet light portlet-fit">
                <div class="portlet-body">                	
                	<form role="form" class="form-horizontal" method="post" action="<?php echo SITE_URL;?>view_order_booking">
                       <div class="row">
                       		<div class="col-md-3"></div>
							<div class="col-md-5">
								<div class="form-group">  
								  	<label for="inputName" class="col-sm-4 control-label" required>Agency Name <span class="font-red required_fld">*</span></label>
								  	<div class="col-sm-7">
								  		<?php $purpose = array(1 => "Sri Vinayaka Agencies", 2=>"Priya Agencies") ?>
                                       <select required class="form-control" name="employee" id="employee" required>
                                       <option value="0">- Select Agency Name-</option>
                                       	<?php foreach($purpose as $row) { ?>
	            							<option value="0"><?php echo $row ?></option>
	            						<?php } ?>
	            						</select>
								  	</div>
								</div>
								<div class="form-group">  
								  	<label for="inputName" class="col-sm-4 control-label">Stock Lifting Unit <span class="font-red required_fld">*</span></label>
								  	<div class="col-sm-7">
								  		<?php $purpose = array(1 => "Tirupathi Unit", 2=>"Priyanka Unit") ?>
                                       <select required class="form-control" name="employee" id="employee" required>
                                       <option value="0">- Select Stock Lifting Unit-</option>
                                       	<?php foreach($purpose as $row) { ?>
	            							<option value="0"><?php echo $row ?></option>
	            						<?php } ?>
	            						</select>
								  	</div>
								</div>
								<div class="col-sm-4"></div>
								<div class="col-sm-6">
								<button class="btn green" type="submit" name="submitPage" value="button"><i class="fa fa-check"></i>Submit</button>
                                <button class="btn defalut" type="submit" name="submitPage" value="button"><i class="fa fa-times"></i>Cancel</button>
							</div>
							</div>
						</div>
					</form>
                </div>
            </div>
            <?php }?>
        </div>
    </div>
</div>
<?php $this->load->view('commons/main_footer', $nestedView); ?>
<script>
$(document).ready(function() {
	$('.toggle').click(function(){
		if($(this).hasClass('fa-plus'))
		{
			$(this).removeClass('fa-plus');
			$(this).addClass('fa-minus');
			$(this).closest('tr').next().show();
		}
		else
		{
			$(this).removeClass('fa-minus');
			$(this).addClass('fa-plus');
			$(this).closest('tr').next().hide();
		}
		
	});

	// select all checkboxes
	$("#select_all").change(function(){  //"select all" change
    var status = this.checked; // "select all" checked status
    $('.checkbox').each(function(){ //iterate all listed checkbox items
        this.checked = status; //change ".checkbox" checked status
	    });
	});

	$('.checkbox').change(function(){ //".checkbox" change
	    //uncheck "select all", if one of the listed checkbox item is unchecked
	    if(this.checked == false){ //if this item is unchecked
	        $("#select_all")[0].checked = false; //change "select all" checked status to false
	    }
	   
	    //check "select all" if all checkbox items are checked
	    if ($('.checkbox:checked').length == $('.checkbox').length ){
	        $("#select_all")[0].checked = true; //change "select all" checked status to true
	    }
	});
});
</script>