 <?php $this->load->view('commons/main_template', $nestedView); ?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
	<div class="portlet light portlet-fit">
		<div class="portlet-body">
		    <div class="row">
		    	<form class="form-horizontal" role="form">
		    	<div class="col-md-3">
		    		<div class="form-group">
                        <label class="col-sm-3 control-label"><b>Dealer</b></label>
                        <div class="col-sm-9">
                            <p class="form-control-static"> Testing-1 </p>
                        </div>
                    </div>

		    	</div>
		    	<div class="col-md-3">
		    		<div class="form-group">
                        <label class="col-sm-3 control-label"><b>Place</b></label>
                        <div class="col-sm-9">
                            <p class="form-control-static"> Hyderabad </p>
                        </div>
                    </div>
		    	</div>
		    	</form>
		        <div class="col-md-12">
		        	<div class="table-scrollable">
                            <table class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th> S.No</th>
                                         <th></th>
                                        <th> DO No </th>
                                        <th> DO Date </th>
                                        <th> Product Name </th>
                                        <th> Price </th>
                                        <th> DO Quantity </th>  
                                        <th> Invoice Quantity / Stocks</th>            
                                    </tr>
                                </thead>
                                <tbody>
                                	<tr>
                                		<td>1</td>
                                		<td><input type="checkbox" class=""> </td>
                                		<td>36603</td>
                                		<td>2017-01-18</td>
                                		<td><input type="text" value="Sun1LtSH" class=""> </td>
                                		<td><input type="text" value="76.1" style="width:50px" class=""> </td>
                                		<td><input type="text" value="1" style="width:40px" class=""> </td>
                                		<td><input id="" name="selectall" class="" id="" onkeyup="javascript:this.value=Comma(this.value);" style="width:50px" value="0" type="text">  <input id="" name="selectall" style="width:50px" value="9" type="text"></td>
                                	</tr>
                                </tbody>
                            </table>
                        </div>
		        </div>
		    </div>
	    </div>
    </div>
</div>