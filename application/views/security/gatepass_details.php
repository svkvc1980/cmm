<?php $this->load->view('commons/main_template', $nestedView); ?>
<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">   
    <!-- BEGIN BORDERED TABLE PORTLET-->
    <div class="portlet light portlet-fit">
        <div class="portlet-body">
        	 <div class="row">				
					<div class="form-group">
						<div class="col-md-8">
                        <label class="col-md-2 control-label">Gate Pass No</label>
                        <div class="col-md-2">
                            <input type="hidden" name="party_name" value="" class="form-control">
                            <b><?php echo "4474"; ?></b>
                        </div>                    
                        <label class="col-md-2 control-label">Vehicle No</label>
                        <div class="col-md-2">
                            <input type="hidden" name="party_name" value="" class="form-control">
                            <b><?php echo "AP5TC4877"; ?></b>
                        </div>                    
                        <label class="col-md-1 control-label">Date</label>
                        <div class="col-md-3">
                            <input type="hidden" name="party_name" value="" class="form-control">
                            <b><?php echo date("d-m-Y"); ?> &nbsp; <?php echo date('H:i:s');?></b>
                        </div>
                        </div>
                        <div class="col-md-6">
                        	<div class="table-scrollable">
	                            <table class="table table-bordered table-striped table-hover">
	                                <thead>
	                                    <tr>
	                                        <th> S.No</th>
	                                        <th> Invoice No </th>
	                                        <th> Distributor name </th>
	                                        <th>  Code </th>
	                                        <th> Town </th>            
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                	<tr>
	                                		<td>1</td>
	                                		<td>37677</td>
	                                		<td>Venkateswara Enterprises</td>
	                                		<td>552</td>
	                                		<td>Kakinada</td>
	                                	</tr>
	                                	<tr>
	                                		<td>2</td>
	                                		<td>37678</td>
	                                		<td>Venkateswara Enterprises</td>
	                                		<td>552</td>
	                                		<td>Kakinada</td>
	                                	</tr>
	                                	<tr>
	                                		<td>3</td>
	                                		<td>37679</td>
	                                		<td>Venkateswara Enterprises</td>
	                                		<td>552</td>
	                                		<td>Kakinada</td>
	                                	</tr>
	                                	<tr>
	                                		<td>4</td>
	                                		<td>37680</td>
	                                		<td>Venkateswara Enterprises</td>
	                                		<td>552</td>
	                                		<td>Kakinada</td>
	                                	</tr>
	                                </tbody>
	                            </table>
                            </div>
                        </div>
                        <div class="col-md-6">
                        	<div class="table-scrollable">
	                            <table class="table table-bordered table-striped table-hover">
	                            	
	                                <thead>
	                                    <tr>
	                                        <th> SN</th>
	                                        <th> Product </th>
	                                        <th colspan="3"> Quantity </th>	                                               
	                                    </tr>
	                                </thead>
	                              
	                                    <tr style="background-color:#ccff">
	                                        <th colspan="2"></th>	                                       
	                                        <th> CBs </th>
	                                        <th> Sachets </th>	
	                                        <th> Weight</th>                                               
	                                    </tr>
	                                
	                                <tbody>
	                                	<tr>
	                                		<td>1</td>
	                                		<td>RBD1LtS</td>
	                                		<td>110</td>
	                                		<td>1760</td>
	                                		<td>1584</td>
	                                	</tr>
	                                	<tr>
	                                		<td>1</td>
	                                		<td>RBD550</td>
	                                		<td>20</td>
	                                		<td>320</td>
	                                		<td>240</td>
	                                	</tr>
	                                	<tr>
	                                		<td colspan="5" align="right">Total Weight: 1824</td>
	                                	</tr>
	                                </tbody>
	                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('commons/main_footer', $nestedView); ?>