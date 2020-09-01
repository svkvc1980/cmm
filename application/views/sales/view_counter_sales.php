<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">  
                <div class="portlet-body">
                	<div class="table-scrollable">
	                    <table class="table table-bordered table-striped table-hover" id="sales">
	                        <thead>
	                            <tr>
	                            	<th width="10"> Bill No </th>
	                            	<th width="10"> Date </th>
	                            	<th width="20"> Customer Name </th>
	                            	<th width="10"> Category </th>
	                                <th width="20"> Product Name </th>
	                                <th width="10"> Price </th>
	                                <th width="10"> Quantity </th>
	                                <th width="20"> Amount </th>          
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	<tr>
	                        		<td> 2 </td>
	                        		<td> 26-12-2016 </td>
	                        		<td> Mastan </td>
	                        		<td> Public </td>
	                        		<td> Sun Flower Oil 5ltr Jar </td>
	                        		<td> 500 </td>
	                        		<td> 20 </td>
	                        		<td> 10000 </td>
	                        	</tr>
	                        	<tr>
	                        		<td> 3 </td>
	                        		<td> 27-12-2016 </td>
	                        		<td> Nagarjuna </td>
	                        		<td> Public </td>
	                        		<td> Rice Bran 5ltr Jar </td>
	                        		<td> 600 </td>
	                        		<td> 20 </td>
	                        		<td> 12000 </td>
	                        	</tr>
	                        	<tr>
	                        		<td> 4 </td>
	                        		<td> 27-12-2016 </td>
	                        		<td> Mounika </td>
	                        		<td> Public </td>
	                        		<td> Sun Flowre 1ltr Sachet </td>
	                        		<td> 100 </td>
	                        		<td> 20 </td>
	                        		<td> 2000 </td>
	                        	</tr>
	                        	<tr>
	                        		<td> 5 </td>
	                        		<td> 27-12-2016 </td>
	                        		<td> Srilekha </td>
	                        		<td> Public </td>
	                        		<td> Rice Bran 5ltr Jar </td>
	                        		<td> 600 </td>
	                        		<td> 20 </td>
	                        		<td> 12000 </td>
	                        	</tr>
	                        </tbody>
	                    </table>
	                </div>    
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('commons/main_footer', $nestedView); ?>                