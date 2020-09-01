 <?php $this->load->view('commons/main_template', $nestedView); ?>

<!-- BEGIN PAGE CONTENT INNER -->
<div class="page-content-inner">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN BORDERED TABLE PORTLET-->
            <div class="portlet light portlet-fit">
                
                <div class="portlet-body">                    
                        
                    <div class="table">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <td rowspan="2">Slno</td>
                                    <td rowspan="2">Product Name</td>
                                    <td rowspan="2">Opening Stock</td>
                                    <td rowspan="2">RECEIPTS</td>
                                    <td colspan="2">ISSUES</td>
                                    <td rowspan="2">Closing Stock</td>
                                </tr>
                                <tr>
                                    <td>Packing</td>
                                    <td>Stock Transefer</td>
                                </tr>
                                
                                
                                <?php $i=1;
                                foreach ($pm_cats as $pm_category_id => $pmc_name)
                                {
                                    if(count(@$daily_report[$pm_category_id])!='' )
                                    {    ?> 
                                        <tr><td colspan="7"><?php
                                            if(get_film_category_id() == $pm_category_id)
                                                echo $i++.'. '.$pmc_name.'(In Kgs)';
                                            else
                                                echo $i++.'. '.$pmc_name ;

                                            ?>
                                            </td>
                                        </tr>
                                    <?php
                                     $sn=1;  
                                     //echo count(@$daily_report[$pm_category_id]).'<br>';
                                    
                                        foreach ($daily_report[$pm_category_id] as $pm_id => $values)
                                        { ?>
                                            <tr>
                                                <td></td>
                                                
                                                <td > <?php echo $sn++.') '.get_pm_name($pm_id);?></td>
                                                <td style="text-align:right"> <?php echo $values['opening_balance'];?></td>
                                                <td style="text-align:right"> <?php echo $values['receipts'];?> </td>
                                                <td style="text-align:right"> <?php echo $values['on_date_production'];?> </td>
                                                <td style="text-align:right"> <?php echo $values['on_date_invoice'];?></td>
                                                <td style="text-align:right" > <?php echo $values['closing_balance'];?></td>
                                            </tr>                                       
                                    <?php } 
                                    }                   
                                }

                                ?>
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
