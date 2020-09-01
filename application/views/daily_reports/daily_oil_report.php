 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                
                <div class="portlet-body">                    
                        
                    <div class="table">
                        <table border='1'>
                            <thead>
                                <tr>
                                    <td> </td>
                                    <td> Name of the Oil </td>
                                    <td>   </td>
                                    <td>   </td>
                                    <td> Opening</td>
                                    <td> Receipts  </td>
                                    <td> Sales </td> 
                                    <td> Transfer </td>
                                    <td> CI Stock</td>                                                  
                                </tr>
                                <tr>
                                    <td> </td>
                                    <td><b>RBDP Bulk Mktg Oil Tanker No.6</b> </td>
                                    <td>   </td>
                                    <td>   </td>
                                    <td> 0.000</td>
                                    <td> 0.000  </td>
                                    <td> 0.000 </td> 
                                    <td>  </td>
                                    <td> 0.000</td>                                                  
                                </tr>
                                <tr>
                                    <td> Sl.No</td>
                                    <td> Name of the Oil </td>
                                    <td>   </td>
                                    <td>   </td>
                                    <td> Opening</td>
                                    <td> Receipts  </td>
                                    <td> Production </td> 
                                    <td>  </td>
                                    <td> CI Stock</td>                                                  
                                </tr>
                                <tr>
                                    <td> </td>
                                    <td>  </td>
                                    <td>   </td>
                                    <td>   </td>
                                    <td> in MTS</td>
                                    <td> in MTS  </td>
                                    <td> Dispatches </td> 
                                    <td>  </td>
                                    <td> in MTS</td>                                                  
                                </tr>
                                <?php 
                                    $sn = 1;
                                    foreach ($loose_oils as $loose_oil_id => $name) 
                                    { $loose = 0;
                                        foreach ($daily_report[$loose_oil_id] as  $loose_and_packed) 
                                        { ?>
                                             <tr>
                                                <td><?php echo $sn++; ?> </td>
                                                <td><?php echo ($loose==0)?$name.'Loose Oil':$name.'Packed Oil';?>  </td>
                                                <td>   </td>
                                                <td>   </td>
                                                <td> <?php echo number_format($loose_and_packed['opening'],3);?></td>
                                                <td> <?php echo number_format($loose_and_packed['receipts'],3);?>  </td>
                                                <td> <?php echo number_format($loose_and_packed['sales'],3);?> </td> 
                                                <td>  </td>
                                                <td> <?php echo number_format($loose_and_packed['closing_balance'],3);?></td>
                                            </tr>
                                            <?php  $loose++; 
                                        } ?>
                                            <tr>
                                                <td> </td>
                                                <td>  </td>
                                                <td>   </td>
                                                <td>   </td>
                                                <td> </td>
                                                <td>  </td>
                                                <td> </td> 
                                                <td>  </td>
                                                <td> </td>                                                  
                                            </tr>

                            <?php   } ?>

                                    <tr>
                                                                                     
                                </tr>


                            
                                
                                
                                
                                <tr>
                                    <td> </td>
                                    <td>  </td>
                                    <td> Oil to Be   </td>
                                    <td>Loose at   </td>
                                    <td>Packed </td>
                                    <td> Pending </td>
                                    <td>Pending Order </td> 
                                    <td>Oil Available</td>
                                    <td> </td>                                                  
                                </tr>
                                <tr>
                                    <td> </td>
                                    <td> Name Of the Oil  </td>
                                    <td> Received   </td>
                                    <td><?php echo get_plant_name() ;?>  </td>
                                    <td> Oil In</td>
                                    <td> Delivery </td>
                                    <td> Booking</td> 
                                    <td>For Order  </td>
                                    <td> </td>                                                  
                                </tr>
                                <tr>
                                    <td>Sl.No </td>
                                    <td>  </td>
                                    <td> in MTS  </td>
                                    <td>in MTS   </td>
                                    <td>in MTS </td>
                                    <td> Orders </td>
                                    <td>in MTS </td> 
                                    <td> Booking </td>
                                    <td> </td>                                                  
                                </tr>
                                <tr>
                                    <td> </td>
                                    <td>  </td>
                                    <td>    </td>
                                    <td>  </td>
                                    <td> </td>
                                    <td>In MTS  </td>
                                    <td> </td> 
                                    <td>In MTS  </td>
                                    <td> </td>                                                  
                                </tr>
                                <?php 
                                $sn =1;
                                foreach ($all_types as $key =>  $all_type_data)
                                        {
                                            $available = $all_type_data['t_qty']+ $daily_report[$key][0]['closing_balance'] +$daily_report[$key][1]['closing_balance']- $obs[$key]['ob_qty'] - $dos[$key]['do_qty'] ;
                                         ?>
                                            <tr>
                                                <td><?php echo $sn++; ?> </td>
                                                <td><?php echo get_loose_oil_name($key);?>  </td>                                                
                                                <td> <?php echo number_format($all_type_data['t_qty'],3);?>   </td>
                                                <td> <?php echo number_format($daily_report[$key][0]['closing_balance'],3);?></td>
                                                <td> <?php echo number_format($daily_report[$key][1]['closing_balance'],3)?>  </td>                                                
                                                <td> <?php echo number_format($dos[$key]['do_qty'],3);?> </td> 
                                                <td> <?php echo number_format($obs[$key]['ob_qty'],3);?> </td> 
                                                <td> <?php echo $available;?>  </td>
                                                <td></td>
                                            </tr>
                                         <?php                                          
                                         }       ?>
                            </thead>
                            <tbody>
                            
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>
