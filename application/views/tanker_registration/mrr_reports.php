<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                <div class="portlet-body">
                <?php if($flag==1)
                {
                ?>  <form method="post" action="<?php echo SITE_URL.'mrr_reports_details';?>" class="form-horizontal">
                    <div class="row">  
                        <div class="col-md-offset-3 col-md-5 jumbotron">                           
                                <div class="form-group">
                                    <label class="col-xs-6 control-label">Purchase Order No
                                    </label>
                                    <div class="col-xs-6">
                                       <input type="text" name="po_no" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-3"></div>
                                     <div class="col-xs-8">
                                    <input type="submit" class="btn blue tooltips" name="submit">                                    
                                       <a href="<?php echo SITE_URL.'mrr_reports';?>" class="btn default">Cancel</a>
                                    </div>                                 
                                </div>
                        </div>
                        </div>
                        
                    </form> 
                <?php } if($flag==2){ ?>
                    <form method="post" action="<?php echo SITE_URL.'mrr_reports'?>">
                        <table align="center" width="100%" border="1px">
                            <tr class="bg-blue-steel" align="center">
                                <td height="2" colspan="5" style="color:white;" valign="top"><b>MATERIAL RECEIPT REPORT(MRR)</b></td>
                            </tr>
                            <tr align="center">
                                <td colspan="2" width="40%" align="left"><b>MRR Reference No:4461</b></td>
                                <td colspan="1" width="20%" align="left"><b>Tanker Register No</b></td>  
                                <td colspan="1" width="20%" align="left"><b></b></td> 
                                <td colspan="1" width="20%" align="left"><b>Date:31/01/2017</b></td>     
                            </tr>
                            <tr align="center">
                                <td colspan="2" width="40%" align="left"><b>B.V.Traders[327]</b></td>
                                <td colspan="1" width="20%" align="left"><b>Purchase Order No</b></td>  
                                <td colspan="1" width="20%" align="left"><b></b></td> 
                                <td colspan="1" width="20%" align="left"><b></b></td>     
                            </tr>
                            <tr align="center">
                                <td colspan="2" width="40%" align="left"><b>CHEEMAKURTHY</b></td>
                                <td colspan="1" width="20%" align="left"><b>D.C. /Invoice No</b></td>  
                                <td colspan="1" width="20%" align="left"><b></b></td> 
                                <td colspan="1" width="20%" align="left"><b></b></td>     
                            </tr>
                            <tr align="center">
                                <td colspan="2" width="40%" align="left"><b>Phone No:123456789</b></td>
                                <td colspan="1" width="20%" align="left"><b>D.C. /Invoice Date</b></td>  
                                <td colspan="1" width="20%" align="left"><b>31/01/2017</b></td> 
                                <td colspan="1" width="20%" align="left"><b></b></td>     
                            </tr>
                            <tr align="center">
                                <td colspan="2" width="40%" align="left"><b>Tin No</b></td>
                                <td colspan="3" width="20%" align="left"><b></b></td>     
                            </tr>
                        </table><br>
                        <table align="center" width="100%" border="1px">
                            <tr class="bg-yellow-soft" align="center">
                                <td colspan="1" width="10%" align="left"><b>S.No</b></td>
                                <td colspan="1" width="20%" align="left"><b>Product Description</b></td>  
                                <td colspan="1" width="10%" align="left"><b>Qty as per DC</b></td> 
                                <td colspan="1" width="10%" align="left"><b>Qty recd</b></td>
                                <td colspan="1" width="10%" align="left"><b>Qty Accepted</b></td> 
                                <td colspan="1" width="10%" align="left"><b>Excess/Shortage</b></td> 
                                <td colspan="1" width="10%" align="left"><b>Remarks</b></td>   
                            </tr>
                             <tr  align="center">
                                <td colspan="1" width="10%" align="left"><b>1</b></td>
                                <td colspan="1" width="15%" align="left">
                                    <input type="text" placeholder="Product Description">
                                </td>  
                                <td colspan="1" width="10%" align="left">
                                    <input type="text" placeholder="Qty per DC">
                                </td> 
                                <td colspan="1" width="15%" align="left">
                                    <input type="text" placeholder="Qty recd">
                                </td>
                                <td colspan="1" width="10%" align="left">
                                    <input type="text" placeholder="Qty Accepted"> 
                                </td> 
                                <td colspan="1" width="10%" align="left">
                                     <input type="text" placeholder="Excesss/Shortage">
                                </td> 
                                <td colspan="1" width="10%" align="left">
                                     <input type="text" placeholder="Remarks">
                                </td>   
                            </tr>
                            <tr align="center" colspan="7">
                                <td colspan="2" width="25%" align="left"><b>Lab Report No</b></td>
                                <td colspan="5" width="55%" align="left"><b></b></td>
                            </tr>
                            <tr align="center" colspan="7">
                                <td colspan="2" width="25%" align="left"><b>Stock Entered in Ledger No</b></td>
                                <td colspan="5" width="55%" align="left">
                                    <input type="text" placeholder="Stock Ledger No">
                                </td>
                            </tr>
                            <tr align="center" colspan="7">
                                <td colspan="2" width="25%" align="left"><b>At Folio No</b></td>
                                <td colspan="1" width="55%" align="left">
                                    <input type="text" placeholder="Folio no">
                                </td>
                                <td colspan="2" width="20%" align="left"><b>Dated</b></td>
                                <td colspan="2" width="20%" align="left"><b>31/1/2017</b></td>
                            </tr>
                            <tr align="center" colspan="7">
                                <td colspan="3" width="20%" align="left"><b>Select Tanker</b>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="delivery_to">
                                        <option value="">Select Tanker</option>
                                        <option value="1">RSF 500MT Tank1</option>
                                        <option value="2">GN 500MT Tank1</option>
                                        <option value="3">COCO 20MT Tank1</option>
                                        <option value="4">GING 20MT Tank1</option>
                                        <option value="5">RRB 50MT Tank1</option>
                                    </select>
                                </td>
                                <td colspan="4" width="20%" align="left"><b>Purchase Order Status</b>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<select name="delivery_to">
                                        <option value="">Select Status</option>
                                        <option value="1">Oil Received Full</option>
                                        <option value="2">Oil Received Partially</option>
                                    </select>
                                </td>
                            </tr>
                        </table><br>
                        <div class="row">
                            <div class="col-md-offset-5 col-md-4">
                                <input type="submit" class="btn blue tooltips" name="submit">
                                <a href="<?php echo SITE_URL.'mrr_reports';?>" class="btn default">Cancel</a>
                            </div>
                        </div>
                    </form>
                    <?php } ?>
                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->

<?php $this->load->view('commons/main_footer', $nestedView); ?>


