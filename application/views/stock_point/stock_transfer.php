<?php $this->load->view('commons/main_template', $nestedView); ?>

<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">  
                <div class="portlet-body">
                    <div class="alert alert-danger display-hide" style="display: none;">
                       <button class="close" data-close="alert"></button> You have some form errors. Please check below. 
                    </div>
                    <div class="clearfix">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#tab_1" data-toggle="tab"> <b>Stock Transfer From Counter To Godown</b> </a>
                            </li>
                            <li>
                                <a href="#tab_2" data-toggle="tab"> <b>Stock Transfer From Godown To Counter</b> </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                            <div class="panel-group accordion" id="accordion3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_1">SUNFLOWER OIL </a>
                            </h4>
                        </div>
                        <div id="collapse_3_1" class="panel-collapse in">
                            <div class="panel-body">
                                <table class="table table-bordered" cellspacing="0" cellpadding="5" border="0" style="padding-left:50px;">
                                    <tr style="background-color:#ccc">                         
                                        <th>Product Name</th>
                                        <th>Price &nbsp; &nbsp; + &nbsp; Added Price</th>                                                   
                                        <th>Transfered Quantity</th>
                                        <th>Transfered Value</th>
                                        <th>Transfered Date</th>
                                    </tr>
                                    <tbody>
                                        <tr>
                                            <td>Sun Flower Oil 15 kg Jar</td>
                                            <td><input class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:50px" value="" type="text"> + <input id="" name="selectall" style="width:50px" value="" type="text"> = <input id="" name="selectall" style="width:70px" value="" type="text"> &nbsp; </td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:80px;" value="" type="text"></td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall"  style="width:80px" value="" type="text"></td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall"  style="width:80px" value="" type="text"></td>                                        </tr>
                                        <tr>
                                            <td>Sun Flower Oil 1/2 Ltr Sachet</td>
                                            <td><input id="" name="selectall" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" style="width:50px" value="" type="text"> + <input id="" name="selectall" style="width:50px" value="" type="text"> = <input id="" name="selectall" style="width:70px" value="" type="text"> &nbsp; </td>
                                            <td><input id="" name="selectall" style="width:80px" value="" type="text"></td>
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
                                <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-arent="#accordion3" href="#collapse_3_2"> GROUNDNUT OIL </a>
                            </h4>
                        </div>
                        <div id="collapse_3_2" class="panel-collapse collapse">
                            <div class="panel-body" style="height:200px; overflow-y:auto;">
                                <table class="table table-bordered" cellspacing="0" cellpadding="5" border="0" style="padding-left:50px;">
                                    <tr style="background-color:#ccc">                           
                                        <th>Product Name</th>
                                        <th>Price &nbsp; &nbsp; + &nbsp; Added Price</th>                                                   
                                        <th>Transfered Quantity</th>
                                        <th>Transfered Value</th>
                                        <th>Transfered Date</th>
                                    </tr>
                                    <tbody>
                                        <tr>
                                            <td>Groundnut Oil 15 kg Jar</td>
                                            <td><input class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:50px" value="" type="text"> + <input id="" name="selectall" style="width:50px" value="" type="text"> = <input id="" name="selectall" style="width:70px" value="" type="text"> &nbsp; </td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall"   style="width:80px" value="" type="text"></td>
                                            <td><input id="" name="selectall" style="width:80px"  value="" type="text"></td>
                                            <td><input id="" name="selectall" style="width:80px"  value="" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td>Groundnut Oil 1/2 Ltr Sachet</td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:50px" value="" type="text"> + <input id="" name="selectall" style="width:50px" value="" type="text"> = <input id="" name="selectall" style="width:70px" value="" type="text"> &nbsp; </td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:80px" value="" type="text"></td>
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
                                <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_3"> RBD PALMOLEIN Oil </a>
                            </h4>
                        </div>
                        <div id="collapse_3_3" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table class="table table-bordered" cellspacing="0" cellpadding="5" border="0" style="padding-left:50px;">
                                    <tr style="background-color:#ccc">                           
                                        <th>Product Name</th>
                                        <th>Price &nbsp; &nbsp; + &nbsp; Added Price</th>                                                   
                                        <th>Transfered Quantity</th>
                                        <th>Transfered Value</th>
                                        <th>Transfered Date</th>
                                    </tr>
                                    <tbody>
                                        <tr>
                                            <td>RBD Palmolein Oil 15 kg Jar</td>
                                            <td><input class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:50px" value="" type="text"> + <input id="" name="selectall" style="width:50px" value="" type="text"> = <input id="" name="selectall" style="width:70px" value="" type="text"> &nbsp; </td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall"  style="width:80px" value="" type="text"></td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall"  style="width:80px" value="" type="text"></td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall"  style="width:80px" value="" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td>RBD Palmolein  Oil 1/2 Ltr Sachet</td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:50px" value="" type="text"> + <input id="" name="selectall" style="width:50px" value="" type="text"> = <input id="" name="selectall" style="width:70px" value="" type="text"> &nbsp; </td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall"  style="width:80px" value="" type="text"></td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:80px" value="" type="text"></td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:80px" value="" type="text"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
                </div>
                            </div>
                            <div class="tab-pane" id="tab_2">
                                                <div class="panel-group accordion" id="accordion3">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_1">SUNFLOWER OIL </a>
                            </h4>
                        </div>
                        <div id="collapse_3_1" class="panel-collapse in">
                            <div class="panel-body">
                                <table class="table table-bordered" cellspacing="0" cellpadding="5" border="0" style="padding-left:50px;">
                                    <tr style="background-color:#ccc">                         
                                        <th>Product Name</th>
                                        <th>Price &nbsp; &nbsp; + &nbsp; Added Price</th>                                                   
                                        <th>Transfered Quantity</th>
                                        <th>Transfered Value</th>
                                        <th>Transfered Date</th>
                                    </tr>
                                    <tbody>
                                        <tr>
                                            <td>Sun Flower Oil 15 kg Jar</td>
                                            <td><input class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:50px" value="" type="text"> + <input id="" name="selectall" style="width:50px" value="" type="text"> = <input id="" name="selectall" style="width:70px" value="" type="text"> &nbsp; </td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:80px;" value="" type="text"></td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall"  style="width:80px" value="" type="text"></td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall"  style="width:80px" value="" type="text"></td>                                        </tr>
                                        <tr>
                                            <td>Sun Flower Oil 1/2 Ltr Sachet</td>
                                            <td><input id="" name="selectall" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" style="width:50px" value="" type="text"> + <input id="" name="selectall" style="width:50px" value="" type="text"> = <input id="" name="selectall" style="width:70px" value="" type="text"> &nbsp; </td>
                                            <td><input id="" name="selectall" style="width:80px" value="" type="text"></td>
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
                                <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-arent="#accordion3" href="#collapse_3_2"> GROUNDNUT OIL </a>
                            </h4>
                        </div>
                        <div id="collapse_3_2" class="panel-collapse collapse">
                            <div class="panel-body" style="height:200px; overflow-y:auto;">
                                <table class="table table-bordered" cellspacing="0" cellpadding="5" border="0" style="padding-left:50px;">
                                    <tr style="background-color:#ccc">                           
                                        <th>Product Name</th>
                                        <th>Price &nbsp; &nbsp; + &nbsp; Added Price</th>                                                   
                                        <th>Transfered Quantity</th>
                                        <th>Transfered Value</th>
                                        <th>Transfered Date</th>
                                    </tr>
                                    <tbody>
                                        <tr>
                                            <td>Groundnut Oil 15 kg Jar</td>
                                            <td><input class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:50px" value="" type="text"> + <input id="" name="selectall" style="width:50px" value="" type="text"> = <input id="" name="selectall" style="width:70px" value="" type="text"> &nbsp; </td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall"   style="width:80px" value="" type="text"></td>
                                            <td><input id="" name="selectall" style="width:80px"  value="" type="text"></td>
                                            <td><input id="" name="selectall" style="width:80px"  value="" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td>Groundnut Oil 1/2 Ltr Sachet</td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:50px" value="" type="text"> + <input id="" name="selectall" style="width:50px" value="" type="text"> = <input id="" name="selectall" style="width:70px" value="" type="text"> &nbsp; </td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:80px" value="" type="text"></td>
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
                                <a class="accordion-toggle accordion-toggle-styled collapsed" data-toggle="collapse" data-parent="#accordion3" href="#collapse_3_3"> RBD PALMOLEIN Oil </a>
                            </h4>
                        </div>
                        <div id="collapse_3_3" class="panel-collapse collapse">
                            <div class="panel-body">
                                <table class="table table-bordered" cellspacing="0" cellpadding="5" border="0" style="padding-left:50px;">
                                    <tr style="background-color:#ccc">                           
                                        <th>Product Name</th>
                                        <th>Price &nbsp; &nbsp; + &nbsp; Added Price</th>                                                   
                                        <th>Transfered Quantity</th>
                                        <th>Transfered Value</th>
                                        <th>Transfered Date</th>
                                    </tr>
                                    <tbody>
                                        <tr>
                                            <td>RBD Palmolein Oil 15 kg Jar</td>
                                            <td><input class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:50px" value="" type="text"> + <input id="" name="selectall" style="width:50px" value="" type="text"> = <input id="" name="selectall" style="width:70px" value="" type="text"> &nbsp; </td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall"  style="width:80px" value="" type="text"></td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall"  style="width:80px" value="" type="text"></td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall"  style="width:80px" value="" type="text"></td>
                                        </tr>
                                        <tr>
                                            <td>RBD Palmolein  Oil 1/2 Ltr Sachet</td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:50px" value="" type="text"> + <input id="" name="selectall" style="width:50px" value="" type="text"> = <input id="" name="selectall" style="width:70px" value="" type="text"> &nbsp; </td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall"  style="width:80px" value="" type="text"></td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:80px" value="" type="text"></td>
                                            <td><input id="" class="numeric" id="" onkeyup="javascript:this.value=Comma(this.value);" name="selectall" style="width:80px" value="" type="text"></td>
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
            </div>
        </div>
    </div>
</div>                    

<?php $this->load->view('commons/main_footer', $nestedView); ?>