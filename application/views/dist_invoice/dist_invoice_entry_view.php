 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">                
                <div class="portlet-body">                    
                    <form id="distributor_form" method="post" action="<?php echo SITE_URL.'dist_invoice_generation'?>" class="form-horizontal">
                        <div class="form-group ">
                                <label class="col-md-5 control-label">Invoice Type :</label>
                                <div class="col-md-4">
                                    <div class="mt-radio-inline">
                                        <label class="mt-radio">
                                            <input type="radio" name="invoice_type" class="invoice_type" value="1" checked > Non Scheme 
                                            <span></span>
                                        </label>
                                        <label class="mt-radio">
                                            <input type="radio" name="invoice_type" class="invoice_type"  value="2" > Scheme 
                                            <span></span>
                                        </label>
                                        
                                    </div>
                                </div>
                        </div>
                        <div class="form-group schemes_dropdown hidden">
                            <label class="col-md-5 control-label mylabel">Select Scheme <span class="font-red required_fld">*</span></label>
                            <div class="col-md-3">
                                <div class="input-icon right">
                                        <select class="form-control" id="scheme_id" name="scheme_id">
                                            <option value="">Select Scheme</option>
                                           <?php                                            
                                                foreach (@$schemes as $row) {                                                    
                                                    echo '<option value="'.$row['fg_scheme_id'].'" >'.$row['name'].'</option>';
                                                }
                                           
                                            ?>
                                        </select>
                                   
                                </div>
                            </div>
                            
                        </div>
                        <div class="form-group order_number">
                            <label class="col-md-5 control-label mylabel">Enter Delivery Order Number <span class="font-red required_fld">*</span></label>
                            <div class="col-md-3 mytext ">
                                <div class="input-icon right">
                                    <i class="fa"></i>
                                    <input class="form-control value " required name="do_number[]" id="order_number_id" type="text">
                                </div>
                            </div>
                            <div class="col-md-2 mybutton">
                                <a  id="add_order_info" class="btn blue tooltips" data-container="body" data-placement="top" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                            </div>
                            <div class="col-md-2 deletebutton hide">
                                <a  class="btn btn-danger tooltips " data-container="body" data-placement="top" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
                            </div>
                        </div>
                        
                        <div class="form-actions">
                            <div class="row">
                                <div class="col-md-offset-5 col-md-6">
                                   <button type="submit" value="1" name="submit" class="btn blue">Submit</button>
                                    <a href="<?php echo SITE_URL.'manage_dist_invoice';?>" class="btn default">Cancel</a>
                                </div>
                            </div>  
                        </div>
                    </form>            

                </div>
            </div>
            <!-- END BORDERED TABLE PORTLET-->
        </div>
    </div>               
</div>
<!-- END PAGE CONTENT INNER -->
<?php $this->load->view('commons/main_footer', $nestedView); ?>
<script type="text/javascript">
var max_limit =10;
var x =1;
$('#add_order_info').click(function()
{
    
    if(x < max_limit)
    {
        x++;
        var ele = $('.order_number:last');  
        var ele_clone = ele.clone();
        ele_clone.find('.mylabel').text('');
        ele_clone.find('.value').val('');
        ele_clone.find('.mybutton').remove();
        ele_clone.find('.deletebutton').addClass('show');
        
        ele_clone.find('.deletebutton').click(function() {      
            $(this).closest('.order_number').remove();
            x--;
        });
        ele.after(ele_clone);
    }
});

</script>