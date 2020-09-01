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
                ?>  <form method="post" action="<?php echo SITE_URL.'mrr_pouch_details';?>" class="form-horizontal">
                        <div class="row">                        
                            <div class="col-md-offset-3 col-md-5 jumbotron">
                                <div class="form-group">
                                    <label class="col-xs-5 control-label">Purchase Order No</label>
                                    <div class="col-xs-7">
                                       <input type="text" name="po_no" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-xs-3"></div>
                                     <div class="col-xs-8">
                                    <input type="submit" class="btn blue tooltips" name="submit">                                    
                                       <a href="<?php echo SITE_URL.'mrr_pouch';?>" class="btn default">Cancel</a>  
                                    </div>                                 
                                </div>
                            </div>
                        </div>
                    </div>
                    </form> 
                    <?php }
                    if($flag==2)
                        { ?>
                    <form method="post" action="<?php echo SITE_URL.'mrr_pouch'?>">
                        <table align="center" width="100%" border="1px">
                            <tr class="bg-blue-steel" align="center">
                                <td height="2" colspan="6" style="color:white;" valign="top"><b>MATERIAL RECEIVED RECEIPT FOR POUCH FILM</b></td>
                            </tr>
                            <tr align="center">
                                <td colspan="1" width="10%" align="left"><b>A</b></td>
                                <td colspan="2" width="20%" align="left"><b>Supplier Name</b></td><td colspan="3" width="50%" align="left">
                                    <input type="text" placeholder="Supplier Name">
                                </td> 
                            </tr>
                            <tr align="center">
                                <td colspan="1" width="10%" align="left"><b>B</b></td>
                                <td colspan="2" width="20%" align="left"><b>PO & Date</b></td>
                                <td colspan="3" width="20%" align="left">
                                    <input type="text" placeholder="PO & Date">
                                </td> 
                            </tr>
                            <tr align="center">
                                <td colspan="1" width="10%" align="left"><b>C</b></td>
                                <td colspan="2" width="20%" align="left"><b>Invoice No & Date</b></td>
                                <td colspan="2" width="20%" align="left">
                                    <input type="text"  placeholder="Invoice No">
                                </td> 
                                <td colspan="2" width="20%" align="left">
                                    <input type="text" placeholder="DD-MM-YY" class="date-picker date">
                                </td>
                            </tr>
                            <tr align="center">
                                <td colspan="1" width="10%" align="left"><b>D</b></td>
                                <td colspan="2" width="20%" align="left"><b>Invoice Qty</b></td>
                                <td colspan="3" width="20%" align="left">
                                    <input type="text" placeholder="Invoice Qty">
                                </td> 
                            </tr>
                            <tr align="center">
                                <td colspan="1" width="10%" align="left"><b>E</b></td>
                                <td colspan="2" width="20%" align="left"><b>Date of Receipt</b></td>
                                <td colspan="3" width="20%" align="left">
                                    <input type="text" placeholder="DD-MM-YY" class="date-picker date">
                                </td> 
                            </tr>
                            <tr align="center">
                                <td colspan="1" width="10%" align="left"><b>F</b></td>
                                <td colspan="2" width="20%" align="left"><b>Vehicle No</b></td>
                                <td colspan="3" width="20%" align="left">
                                    <input type="text" placeholder="Vehicle No">
                                </td> 
                            </tr>
                            <tr align="center">
                                <td colspan="6" width="80%" align="left"><b>MRP No:1905/</b></td>
                            </tr>
                            <tr class="bg-yellow-soft" align="center">
                                <td colspan="1" width="10%" align="left"><b>S No</b></td>
                                <td colspan="1" width="20%" align="left"><b>Product</b></td>
                                <td colspan="1" width="20%" align="left"><b>PO Qty</b></td>
                                <td colspan="1" width="20%" align="left"><b>Received Qty</b></td>
                                <td colspan="1" width="20%" align="left"><b>Accepted Qty</b></td>
                                <td colspan="1" width="20%" align="left"><b>Shortage/Rejected</b></td>
                            </tr>
                            <tr align="center">
                                <td colspan="1" width="10%" align="left"><b>1</b></td>
                                <td colspan="1" width="20%" align="left">
                                    <input type="text" placeholder="Product">
                                </td>
                                <td colspan="1" width="20%" align="left">
                                    <input type="text" placeholder="PO Qty">
                                </td>
                                <td colspan="1" width="20%" align="left">
                                    <input type="text" placeholder="Received Qty">
                                </td>
                                <td colspan="1" width="20%" align="left">
                                    <input type="text" placeholder="Accepted Qty">
                                </td>
                                <td colspan="1" width="20%" align="left">
                                    <input type="text" placeholder="Shortage/Rejected">
                                </td>
                            </tr>
                            <tr class="bg-yellow-soft" align="center">
                                <td colspan="1" width="10%" align="left"><b></b></td>
                                <td colspan="1" width="20%" align="left"><b>Tests</b></td>
                                <td colspan="2" width="20%" align="left"><b>Obtained Values</b></td>
                                <td colspan="2" width="20%" align="left"><b>Permissible Range</b></td>
                            </tr>
                            <tr align="center">
                                <td colspan="1" width="10%" align="left"><b>A</b></td>
                                <td colspan="1" width="20%" align="left"><b>Thickness (in microns)</b></td>
                                <td colspan="2" width="20%" align="left">
                                    <input type="text" placeholder="Thickenss">
                                </td>
                                <td colspan="2" width="20%" align="left"><b>110=5 microns</b></td>
                            </tr>
                            <tr align="center">
                                <td colspan="1" width="10%" align="left"><b>B</b></td>
                                <td colspan="1" width="20%" align="left"><b>No of Layers</b></td>
                                <td colspan="2" width="20%" align="left">
                                    <input type="text"  placeholder="No of Layers">
                                </td>
                                <td colspan="2" width="20%" align="left"><b>5 layers/3 layers</b></td>
                            </tr>
                            <tr align="center">
                                <td colspan="1" width="10%" align="left"><b>C</b></td>
                                <td colspan="1" width="20%" align="left"><b>Width</b></td>
                                <td colspan="2" width="20%" align="left">
                                    <input type="text" placeholder="Width">
                                </td>
                                <td colspan="2" width="20%" align="left"><b>328mm+</b></td>
                            </tr>
                            <tr align="center">
                                <td colspan="1" width="10%" align="left"><b>D</b></td>
                                <td colspan="1" width="20%" align="left"><b>No of Colours</b></td>
                                <td colspan="2" width="20%" align="left">
                                    <input type="text" placeholder="No of Colours">
                                </td>
                                <td colspan="2" width="20%" align="left"><b>2,4 & 6</b></td>
                            </tr>
                            <tr align="center">
                                <td colspan="1" width="10%" align="left"><b>E</b></td>
                                <td colspan="1" width="20%" align="left"><b>Photocel Identification</b></td>
                                <td align="center" colspan="2">
                                    <select name="photocel">
                                        <option value="">Select </option>
                                        <option value="1">Yes</option>
                                        <option value="2">No</option>
                                    </select>
                                </td>
                                <td colspan="2" width="20%" align="left"><b></b></td>
                            </tr>
                            <tr align="center">
                                <td colspan="4" width="50%" align="left"><b>Received item got required parameters </b></td>
                                <td align="center" colspan="2">
                                    <select name="parameters">
                                        <option value="">Select </option>
                                        <option value="1">Yes</option>
                                        <option value="2">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr align="center">
                                <td colspan="4" width="50%" align="left"><b>Received total purchased order quantity </b></td>
                                <td align="center" colspan="2">
                                    <select name="purchased">
                                        <option value="">Select </option>
                                        <option value="1">Yes</option>
                                        <option value="2">No</option>
                                    </select>
                                </td>
                            </tr>
                        </table><br>
                       
                        <div class="row">
                            <div class="col-md-offset-5 col-md-4">
                                <input type="submit" class="btn blue tooltips" name="submit">
                                <a href="<?php echo SITE_URL.'mrr_pouch';?>" class="btn default">Cancel</a>
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


