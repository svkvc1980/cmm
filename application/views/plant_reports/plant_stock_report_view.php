 <?php $this->load->view('commons/main_template', $nestedView); ?>

 <!-- BEGIN PAGE CONTENT INNER -->
 <div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet box blue">
                <div class="portlet-title">
                  <div class="caption">
                      <i class="fa fa-gift"></i><?php echo $portlet_title; ?>
                    </div>
              </div>
              <div class="portlet-body form">
                <?php if(@$flag==1) { ?>
                <form class="form-horizontal" role="form" method="post" action="<?php echo SITE_URL.'insert_latest_quantity';?>">
                    <!-- <input type="hidden" name="plant_id" id="plant_id" value="<?php echo $plant_id?>"> -->
                    <div class="portlet box blue">
                        <div class="portlet-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                           <?php 
                                            $sno=1;
                                            $grand_total=0;
                                            if(count(@$product_results)>0)
                                            {
                                                foreach ($product_results as $key =>$value)
                                                {  
                                                   //echo "<pre>"; print_r($value); 
                                                   if(count(@$value['sub_products']) != '')
                                                   { ?>
                                                        <tr align="center" style="background-color:#889ff3;">
                                                           <td colspan="5" style="color:white;"><b><?php echo @$value['loose_oil_name']; ?></b></td>
                                                          
                                                        </tr>
                                                       <?php if($sno==1){ ?> 
                                                        <tr>
                                                            <td><b>SNO</b></td>
                                                            <td><b>Product Name</b></td>
                                                            <td><b>Pouches</b></td>
                                                            <td><b>Oil Weight</b></td>
                                                            <td><b>Total Price</b></td>
                                                        </tr>
                                                        <?php  }
                                                        $oil_weight=0;
                                                        foreach(@$value['sub_products'] as $keys =>$values)
                                                        { 
                                                            if(count($values)!='')
                                                            { 
                                                                $total=((@$product_latest_price[$values[0]['product_id']])*(@$values[0]['carton_items']));
                                                                $grand_total+=$total;
                                                                $Weight=round(((@$values[0]['carton_items'])*(@$values[0]['oil_weight'])),2);
                                                                $oil_weight+=$Weight;
                                                                ?>
                                                                <tr>
                                                                    <td><?php echo  $sno++; ?></td> 
                                                                    <td><?php echo @$values[0]['name']; ?> </td>
                                                                    <td><?php echo round(@$values[0]['carton_items']);?></td>
                                                                    <td><?php echo round(((@$values[0]['carton_items'])*(@$values[0]['oil_weight'])),2);?></td>
                                                                    <td>
                                                                        <input type="hidden" class="grand_total" name="grand_total" value="<?php echo ((@$product_latest_price[$values[0]['product_id']])*(@$values[0]['carton_items'])); ?>">
                                                                        <?php echo ((@$product_latest_price[$values[0]['product_id']])*(@$values[0]['carton_items'])); ?>
                                                                    </td>
                                                               </tr> <?php

                                                            }
                                                        } ?> <td colspan="4" align="right"><b>Total Oil Weight: &nbsp;</b><?php echo $oil_weight; ?></td> <?php
                                                    }
                                                } 

                                            }
                                            else
                                            { ?>
                                                <div class="col-md-offset-5 col-md-7">
                                                <p class="form-control-static" align="center"><b>No Records Found </b></p>
                                                </div>
                                            <?php }
                                            ?>
                                            <tr> 
                                            <td colspan="5" align="right"><b>Grand Total Price: &nbsp;</b><?php echo indian_format_price(round($grand_total)).'.00'; ?></td>   
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                 <?php }
                        ?>
              </div>
            </div>
        </div>
    </div>
 </div>
 <?php $this->load->view('commons/main_footer', $nestedView); ?>
 