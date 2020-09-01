<?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit">                
                <div class="portlet-body">
                    <form id="broker_form" method="post" action="<?php echo SITE_URL;?>freegift_quantity" class="form-horizontal">
                    <div class="table-scrollable">                      
                        <table class="table table-bordered">
                                <tr align="center" style="background-color:#889ff3;">
                                   <td colspan="4" style="color:white;"><b>Free Gifts</b></td>
                                </tr>
                                <tr>
                                    <td><b>SNO</b></td>
                                    <td><b>Free Gift</b></td>
                                    <td><b>Quantity</b></td>
                                </tr>
                                <?php $sno=1;
                                     if($free_gift)
                                      { 
                                        foreach($free_gift as $row)
                                        {
                                          ?>
                                          <tr>
                                              <td><?php echo  $sno++; ?></td> 
                                              <td><?php echo $row['name']; ?>
                                                <input type="hidden" name="oil_id[]" value="<?php echo $row['free_gift_id'];?>">
                                              </td>
                                              <td><input type="text" name="quantity[<?php echo $row['free_gift_id'];?>]" class="form-control numeric"  style="width:135px" value="<?php if(@$results[@$row['free_gift_id']][$plant_id]!=''){ echo @$results[@$row['free_gift_id']][$plant_id]; }else{ echo '';} ?>"></td>  
                                              </tr> <?php
                                        }
                                      }
                                     else
                                      { ?>
                                        <tr>
                                          <td colspan="3" align="center"><span class="label label-primary">No Records</span></td>
                                        </tr> <?php
                                      }?>    
                        </table>                        
                    </div>
                    <div class="row">
                        <div class="col-md-offset-5 col-md-6">
                            <button type="submit" value="1" name="fg_quantity" onclick="return confirm('Are you sure you want to Submit?')" class="btn blue">Submit</button>
                             <a type="submit" href="<?php echo SITE_URL;?>" class="btn default">Reset</a>
                        </div>
                    </div>  
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('commons/main_footer', $nestedView); ?>