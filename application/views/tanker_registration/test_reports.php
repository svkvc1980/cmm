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
                ?>  <form method="post" action="<?php echo SITE_URL.'test_report_details';?>" class="form-horizontal">
                        <div class="row">
                           <div class="col-md-offset-3 col-md-5 jumbotron">
                                <div class="form-group">
                                    <label class="col-xs-6 control-label">Tanker Register No
                                    </label>
                                    <div class="col-xs-6">
                                       <input type="text" name="tank_reg_no" class="form-control">
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <div class="col-xs-4"></div>
                                     <div class="col-xs-8">
                                   <input type="submit" class="btn blue tooltips" name="submit" value="submit">
                                     <a href="<?php echo SITE_URL.'tanker_register_out';?>" class="btn default">Cancel</a>
                                    </div>                                 
                                </div>
                            </div>
                        </div>                         
                    </form> 
                <?php 
                }
                 if($flag==2){  ?>
                    <form method="post" action="<?php echo SITE_URL.'test_results'?>">
                        <table align="center" width="80%" border="1px">
                            <tr class="bg-blue-steel" align="center">
                                <td height="2" colspan="4" style="color:white;" valign="top"><b>REFINED SUNFLOWER OIL ANALYSIS REPORT</b></td>
                            </tr>
                            <tr align="center">
                                <td colspan="2" width="50%" align="left"><b>Test Report No</b></td>
                                <td colspan="2" width="50%" align="left"><b>4846</b></td>      
                            </tr>
                            <tr align="center">
                                <td colspan="2" width="50%" align="left"><b>Test Date</b></td>
                                <td colspan="2" width="50%" align="left"><b>28/01/2017</b></td>      
                            </tr>
                             <tr align="center">
                                <td colspan="2" width="50%" align="left"><b>Name of the Supplier</b></td>
                                <td colspan="2" width="50%" align="left"><b></b></td>      
                            </tr>
                             <tr align="center">
                                <td colspan="2" width="50%" align="left"><b>Truck No</b></td>
                                <td colspan="2" width="50%" align="left"><b></b></td>      
                            </tr>
                            <tr align="center">
                                <td colspan="2" width="50%" align="left"><b>Purchase Order No</b></td>
                                <td colspan="2" width="50%" align="left"><b></b></td>      
                            </tr>
                            <tr align="center">
                                <td colspan="2" width="50%" align="left"><b>Invoice No</b></td>
                                <td colspan="2" width="50%" align="left"><b></b></td>      
                            </tr>
                            <tr align="center">
                                <td colspan="2" width="50%" align="left"><b>Date of Receipt</b></td>
                                <td colspan="2" width="50%" align="left"><b>--</b></td>      
                            </tr>
                            <tr align="center">
                                <td colspan="2" width="50%" align="left"><b>Date of Unloading/Rejection</b></td>
                                <td colspan="2" width="50%" align="left"><b></b></td>      
                            </tr>
                            <tr align="center">
                                <td colspan="2" width="50%" align="left"><b>rate</b></td>
                                <td colspan="2" width="50%" align="left"><b>0.00</b></td>      
                            </tr>
                            <tr align="center">
                                <td colspan="2" width="50%" align="left"><b>Name of the Broker</b></td>
                                <td colspan="2" width="50%" align="left"><b>Mastan</b></td>      
                            </tr>
                            <tr class="bg-blue-steel" align="left">
                                <td height="2" colspan="4" style="color:white;" valign="top"><b>TEST REPORT</b></td>
                            </tr>
                            <tr class="bg-yellow-soft" align="center" colspan="3">
                                <td colspan="2" width="50%" align="left"><b>Tests</b></td>
                                <td colspan="1" width="20%" align="left"><b>Value Obtained</b></td>  
                                <td colspan="1" width="30%" align="left"><b>Required Range</b></td>    
                            </tr>
                            <tr align="center" colspan="3">
                                <td colspan="2" width="50%" align="left"><b>B.R.Reading at 40Deg.C</b></td>
                                <td colspan="1" width="20%" align="left">
                                    <input class="test_reports" type="text" placeholder="B.R.Reading" data-min="57.1" data-max="65">
                                </td>  
                                <td colspan="1" width="30%" align="left"><b>57.1 to 65</b></td>    
                            </tr>
                            <tr align="center" colspan="3">
                                <td colspan="2" width="50%" align="left"><b>Iodine Value(WDS)</b></td>
                                <td colspan="1" width="20%" align="left">
                                    <input class="test_reports" type="text" placeholder="Iodine Value" data-min="100" data-max="145">
                                </td>  
                                <td colspan="1" width="30%" align="left"><b>100 to 145</b></td>    
                            </tr>
                            <tr align="center" colspan="3">
                                <td colspan="2" width="50%" align="left"><b>Saponification Value</b></td>
                                <td colspan="1" width="20%" align="left">
                                    <input class="test_reports" type="text" placeholder="Saponification Value" data-min="188" data-max="194">
                                </td>  
                                <td colspan="1" width="30%" align="left"><b>188 to 194</b></td>    
                            </tr>
                            <tr align="center" colspan="3">
                                <td colspan="2" width="50%" align="left"><b>Unsaponifiable matter(%)</b></td>
                                <td colspan="1" width="20%" align="left">
                                    <input class="test_reports" type="text" placeholder="Unsaponification matter" data-min="1.5" data-max="1.5">
                                </td>  
                                <td colspan="1" width="30%" align="left"><b>1.5</b></td>    
                            </tr>
                            <tr align="center" colspan="3">
                                <td colspan="2" width="50%" align="left"><b>Free Fatty Acid Value(FFA%)</b></td>
                                <td colspan="1" width="20%" align="left">
                                    <input class="test_reports" type="text" placeholder="Free Fatty Acid Value" data-min="0.15" data-max="0.15">
                                </td>  
                                <td colspan="1" width="30%" align="left"><b>0.15</b></td>    
                            </tr>
                            <tr align="center" colspan="3">
                                <td colspan="2" width="50%" align="left"><b>Moisture/M.I.V. %</b></td>
                                <td colspan="1" width="20%" align="left">
                                    <input class="test_reports" type="text" placeholder="Moisture" data-min="0.10" data-max="0.10">
                                </td>  
                                <td colspan="1" width="30%" align="left"><b>0.10</b></td>    
                            </tr>
                            <tr align="center" colspan="3">
                                <td colspan="2" width="50%" align="left"><b>Peroxide Value</b></td>
                                <td colspan="1" width="20%" align="left">
                                    <input class="test_reports" type="text" placeholder="Peroxide Value" data-min="10" data-max="10">
                                </td>  
                                <td colspan="1" width="30%" align="left"><b>10 Milli Eq/1000gr.</b></td>    
                            </tr>
                            <tr class="bg-yellow-soft" align="center" colspan="3">
                                <td colspan="4" width="50%" align="left"><b>Adulteration Tests</b></td>
                            </tr>
                            <tr align="center" colspan="3">
                                <td colspan="2" width="50%" align="left"><b>Castor oil</b></td>
                                <td colspan="1" width="20%" align="left"><b>Negative</b></td>  
                                <td colspan="1" width="30%" align="left"><b>Should be Negative</b></td>    
                            </tr>
                            <tr align="center" colspan="3">
                                <td colspan="2" width="50%" align="left"><b>Halphenes(Cottonseed)</b></td>
                                <td colspan="1" width="20%" align="left"><b>Negative</b></td>  
                                <td colspan="1" width="30%" align="left"><b>Should be Negative</b></td>    
                            </tr>
                            <tr align="center" colspan="3">
                                <td colspan="2" width="50%" align="left"><b>Mineral Oil Test</b></td>
                                <td colspan="1" width="20%" align="left"><b>Negative</b></td>  
                                <td colspan="1" width="30%" align="left"><b>Should be Negative</b></td>    
                            </tr>
                            <tr align="center" colspan="3">
                                <td colspan="2" width="50%" align="left"><b>Argemone Test</b></td>
                                <td colspan="1" width="20%" align="left"><b>Negative</b></td>  
                                <td colspan="1" width="30%" align="left"><b>Should be Negative</b></td>    
                            </tr>
                            <tr class="bg-yellow-soft" align="center" colspan="3">
                                <td colspan="4" width="50%" align="left"><b>Other Tests</b></td>
                            </tr>
                            <tr align="center" colspan="3">
                                <td colspan="2" width="50%" align="left"><b>Colour in 5/1/4" Cell as Y+5R</b></td>
                                <td colspan="1" width="20%" align="left">
                                    <input class="test_reports" type="text" placeholder="Colour in 5/1/4" data-min="9.5" data-max="9.5">
                                </td>  
                                <td colspan="1" width="30%" align="left"><b>9.5LU</b></td>    
                            </tr>
                            <tr align="center" colspan="3">
                                <td colspan="2" width="50%" align="left"><b>Cloud Point/ Wax/ Sediments</b></td>
                                <td colspan="1" width="20%" align="left">
                                    <input class="test_reports" type="text" placeholder="Cloud Point" data-min="0" data-max="18">
                                </td>  
                                <td colspan="1" width="30%" align="left"><b>Nil at 18Deg.C</b></td>    
                            </tr>
                            <tr align="center" colspan="3">
                                <td colspan="2" width="50%" align="left"><b>Remarks</b></td>
                                <td colspan="2" width="50%" align="left"><b></b></td>
                            </tr>
                        </table><br>
                        <div class="row">
                            <div class="col-md-offset-5 col-md-4">
                                <input type="submit" class="btn blue tooltips" name="submit">
                                <a href="<?php echo SITE_URL.'test_reports';?>" class="btn default">Cancel</a>
                            </div>
                        </div>
                    </form>
                    <?php }
                    if($flag==3)
                    { ?>
                        <form method="post" action="<?php echo SITE_URL.'test_reports';?>"
                       <div class="well">
                       Test Passed</div>
                        <div class="row">
                            <div class="col-md-offset-5 col-md-4">
                                <input type="submit" class="btn blue tooltips" value="Ok" name="submit">
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

<script type="text/javascript">
$(document).ready(function(){
    $('.test_reports').blur(function(){
     var br_reading=$(this).val();
     var max=$(this).data('max');
     var min=$(this).data('min');
     if((parseFloat(br_reading)>parseFloat(max)) ||(parseFloat(br_reading)<parseFloat(min)))
     {
        $(this).css("border-color","red");
        return false;
        //alert('hi');
     }
     else
     {
         $(this).css("border-color","inherit");  
     }
     
    });
    });
</script>

