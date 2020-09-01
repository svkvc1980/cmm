<?php //Maruthi Helper

function dw_stock_leakage($loose_oil_id,$product_id,$from_date,$to_date)
{
    $CI = & get_instance();
    $qry2 ='SELECT ol.product_id, p.name, SUM( ol.leakage_quantity - ol.recovered_quantity ) as leakage_qty 
        FROM  `ops_leakage` AS ol
        INNER JOIN product AS p ON p.product_id = ol.product_id
        WHERE recover_type =2 AND ol.plant_id ="'.get_plant_id().'" AND ol.on_date >= "'.$from_date.'" 
                AND ol.on_date <= "'.$to_date.'" AND ol.product_id ="'.$product_id.'" 
                 AND p.loose_oil_id ="'.$loose_oil_id.'" ';
        $res2 =$CI->db->query($qry2);
        //echo $CI->db->last_query();
        //echo '<pre>'; print_r($res2->result_array());
        //exit;
        if($res2->num_rows()>0)
        {
            $result2 = $res2->row_array();
            $on_date_production = ($result2['leakage_qty']!='')?$result2['leakage_qty']:0;
        }
        else
        {
            $on_date_production = 0;
        }
    return $on_date_production;
}

function get_leakage_for_searched_date_to_today($loose_oil_id,$report_date,$product_id,$range=0)
{
    $CI = & get_instance();
    $qry2 ='SELECT ol.product_id, p.name, SUM( ol.leakage_quantity - ol.recovered_quantity ) as leakage_qty 
        FROM  `ops_leakage` AS ol
        INNER JOIN product AS p ON p.product_id = ol.product_id
        WHERE recover_type =2 AND ol.plant_id ="'.get_plant_id().'"
        AND ol.product_id="'.$product_id.'" AND p.loose_oil_id="'.$loose_oil_id.'"
          ';
        if($range == 0)
        {
            $qry2.=' AND ol.on_date >= "'.$report_date.'" ';
        }
        else
        {
           $qry2.=' AND ol.on_date = "'.$report_date.'" '; 
        }
        $res2 =$CI->db->query($qry2);
        //echo '<pre>'; print_r($res2->result_array());exit;
        if($res2->num_rows()>0)
        {
            $result2 = $res2->row_array();
            $production = ($result2['leakage_qty']!='')?$result2['leakage_qty']:0;
        }
        else
        {
            $production = 0;
        }
    return $production;
}
 function get_ops_dropdown()
{
    $CI = & get_instance();
    $CI->db->select('p.*');
    $CI->db->from('plant p');
    $CI->db->join('plant_block pb','pb.plant_id = p.plant_id');
    $CI->db->where('pb.block_id',2);
    $res = $CI->db->get();
    return $res->result_array();
}
function get_consumption_per_product($product_id,$qty,$pm_id,$consumption_per_unit,$micron_id=0,$pouches =0)
{ 
    /*$pm_id = 15;
    $product_id = 11;
    $qty = 90;
    $consumption_per_unit =1;*/
    //echo $product_id.'--'.$qty.'--'.$pm_id.'--'.$consumption_per_unit.'--'.$micron_id;exit;
    $CI = & get_instance();
    $pm_group_id = get_pm_group_id($pm_id);
    $items_per_carton = get_items_per_carton($product_id);
    switch ($pm_group_id)
    {
        case 1:
            $micron_id = ($micron_id!='')?$micron_id:2;
                $capacity_id = get_capacity_id($product_id);
                $packets_per_kg = $CI->Common_model->get_value('capacity_micron',array('capacity_id'=>$capacity_id,'micron_id'=>$micron_id),'value');
                if($pouches ==0)
                    $quantity = round((($qty*$items_per_carton)/$packets_per_kg),3); 
                else
                { 
                    //echo $qty.'kk';
                    $quantity = round(($qty/$packets_per_kg),4); 
                    //echo $quantity;exit;
                }
            break;  

        case 3:
        case 5:
        case 6:
        case 7:

                $quantity = ($qty*$items_per_carton*$consumption_per_unit);
                /*echo $qty.'pp'.$items_per_carton.'pp'.$consumption_per_unit.'<br>';
                echo $quantity;exit;*/
              
        break;
        case 2:
        case 4:
        case 8:
                $quantity = ($qty*$consumption_per_unit);
            break;
        
        default:
            # code...
            break;
    }
    return $quantity;
}
function get_pp_covars_group_id()
{
    return 8;
}
function get_tapes_group_id()
{
    return 4;
}
function on_date_leakage($pm_category_id,$pm_id,$from_date,$on_date =0)
{ 
    $CI = & get_instance();
    $CI->db->select('sum(lpm.quantity) as leakage_range_film_qty');
    if($pm_category_id == 1)
        $CI->db->from('leakage_pm_micron lpm');
    else
        $CI->db->from('leakage_pm lpm');
    $CI->db->join('ops_leakage opsl','opsl.ops_leakage_id = lpm.ops_leakage_id');
    if($on_date !=0)
        $CI->db->where('opsl.on_date =',$from_date); 
    else
        $CI->db->where('opsl.on_date >=',$from_date);    
    $CI->db->where('pm_id',$pm_id);   
    $CI->db->where('opsl.plant_id',get_plant_id());            
    $res1 = $CI->db->get();
    /*echo $CI->db->last_query();exit;
    echo '<pre>'; print_r($res1->row_array()); exit;*/
    if($res1->num_rows()>0)
    {
        $result1 = $res1->row_array();
        $dw_leakage_film = ($result1['leakage_range_film_qty']!='')?$result1['leakage_range_film_qty']:0.000;                
    }
    else
    {
        $dw_leakage_film = 0.000;
    }
    return $dw_leakage_film;


}
function dw_leakage_film_and_pm($pm_category_id,$pm_id,$from_date,$to_date)
{ 
    $CI = & get_instance();
    $CI->db->select('sum(lpm.quantity) as leakage_range_film_qty');
    if($pm_category_id == 1)
        $CI->db->from('leakage_pm_micron lpm');
    else
        $CI->db->from('leakage_pm lpm');
    $CI->db->join('ops_leakage opsl','opsl.ops_leakage_id = lpm.ops_leakage_id');
    $CI->db->where('opsl.on_date >=',$from_date);    
    $CI->db->where('opsl.on_date <=',$to_date);
    $CI->db->where('pm_id',$pm_id);   
    $CI->db->where('opsl.plant_id',get_plant_id());            
    $res1 = $CI->db->get();
    /*echo $CI->db->last_query();exit;
    echo '<pre>'; print_r($res1->row_array()); exit;*/
    if($res1->num_rows()>0)
    {
        $result1 = $res1->row_array();
        $dw_leakage_film = ($result1['leakage_range_film_qty']!='')?$result1['leakage_range_film_qty']:0.000;                
    }
    else
    {
        $dw_leakage_film = 0.000;
    }
    return $dw_leakage_film;


}
function dw_receipts($plant_id,$loose_oil_id,$from_date,$to_date)
{
    $CI = & get_instance();
    $qry ='SELECT sum(tol.gross - tol.tier)/1000 as mrr_data
                 FROM po_oil as pl
                LEFT JOIN po_oil_tanker as plt ON pl.po_oil_id = plt.po_oil_id
                LEFT JOIN tanker_register as tr ON tr.tanker_id = plt.tanker_id
                LEFT JOIN tanker_oil as tol ON tol.tanker_id = tr.tanker_id 
                LEFT JOIN mrr_oil as mo ON mo.tanker_oil_id = tol.tanker_oil_id
                WHERE  pl.loose_oil_id ="'.$loose_oil_id.'" AND pl.plant_id ="'.$plant_id.'"
                AND mo.mrr_date >= "'.$from_date.'" AND mo.mrr_date <= "'.$to_date.'"  ';
        $res2 = $CI->db->query($qry);
        //echo $CI->db->last_query();exit;
        if($res2->num_rows()>0)
        {
            $mrr_res = $res2->row_array();
            $mrr_data = ($mrr_res['mrr_data']!='')?$mrr_res['mrr_data']:0;
        }
        else
        {
            $mrr_data = 0;
        }
   //$res = $CI->db->query($qry);
    //echo $CI->db->last_query();exit;
  
    //echo $receipts;exit;
    return $mrr_data;
}
function get_ses_block_id()
{
    
    $ci = & get_instance();
    return $ci->session->userdata('block_id');
    //return 4;
}
function get_plant_address($plant_id)
{
    $CI = & get_instance();
    $CI->db->select('p.address');
    $CI->db->from('plant p');   
    $CI->db->where('p.plant_id', $plant_id);    
    $res=$CI->db->get();
    $result= $res->row_array();
    return $result['address'];
}
function get_dist_type_by_invoice($invoice_id)
{
    $CI = & get_instance();
    $CI->db->select('o.*');
    $CI->db->from('invoice i');
    $CI->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
    $CI->db->join('order o','o.order_id = ido.order_id');
    $CI->db->WHERE('i.invoice_id',$invoice_id);
    $res = $CI->db->get();
    $result = $res->row_array();
    //print_r($result);exit;
    return $result['ob_type_id'];

}
function get_invoice_pm($report_date,$pm_id,$on_date =0) 
{
     $CI = & get_instance();
    $CI->db->select('sum(ipm.quantity) as invoice_pm_qty');
    $CI->db->from('invoice i');
    $CI->db->join('invoice_pm ipm','i.invoice_id = ipm.invoice_id');
    if($on_date !=0)    
        $CI->db->where('i.invoice_date=',$report_date);
    else
       $CI->db->where('i.invoice_date >=',$report_date);
    $CI->db->where('i.plant_id',get_plant_id());
    $CI->db->where('ipm.pm_id',$pm_id);
    $inv_pm_res = $CI->db->get();
    if($inv_pm_res->num_rows()>0)
    {
        $inv_pm_result = $inv_pm_res->row_array();
        $inv_pm_data = ($inv_pm_result['invoice_pm_qty']!='')?$inv_pm_result['invoice_pm_qty']:'0.000';
    }
    else
    {
        $inv_pm_data = 0.000;
    }
return $inv_pm_data;
}
function dw_invoice_pm($pm_id,$from_date,$to_date) 
{
     $CI = & get_instance();
    $CI->db->select('sum(ipm.quantity) as invoice_pm_qty');
    $CI->db->from('invoice i');
    $CI->db->join('invoice_pm ipm','i.invoice_id = ipm.invoice_id');       
    $CI->db->where('i.invoice_date >=',$from_date);    
    $CI->db->where('i.invoice_date <=',$to_date);
    $CI->db->where('i.plant_id',get_plant_id());
    $CI->db->where('ipm.pm_id',$pm_id);
    $inv_pm_res = $CI->db->get();
    if($inv_pm_res->num_rows()>0)
    {
        $inv_pm_result = $inv_pm_res->row_array();
        $inv_pm_data = ($inv_pm_result['invoice_pm_qty']!='')?$inv_pm_result['invoice_pm_qty']:'0.000';
    }
    else
    {
        $inv_pm_data = 0.000;
    }
return $inv_pm_data;
}


function get_pm_category_id($pm_id)
{
    $CI = & get_instance();
    $CI->db->select('pm_category_id');
    $CI->db->from('packing_material');
    $CI->db->where('pm_id',$pm_id);
    $res = $CI->db->get();
    $result = $res->row_array();
    return $result['pm_category_id'];
}
function get_pm_group_id($pm_id)
{
    $CI = & get_instance();
    $CI->db->select('pm_group_id');
    $CI->db->from('packing_material');
    $CI->db->where('pm_id',$pm_id);
    $res = $CI->db->get();
    $result = $res->row_array();
    return $result['pm_group_id'];
}
function get_pm_receipts($report_date,$pm_id,$on_date=0)
{
  $CI = & get_instance();
    $qry ='SELECT sum(mrrpm.received_qty) as mrr_rage_film_qty
            FROM po_pm as pp
            INNER JOIN po_pm_tanker as ppt ON pp.po_pm_id = ppt.po_pm_id
            INNER JOIN tanker_register as tr ON tr.tanker_id = ppt.tanker_id
            INNER JOIN tanker_pm as tp ON tp.tanker_id = tr.tanker_id                           
            INNER JOIN mrr_pm as mrrpm ON tp.tanker_pm_id = mrrpm.tanker_pm_id                          
            WHERE  pp.pm_id ="'.$pm_id.'" AND tr.plant_id ="'.get_plant_id().'" ';
    if($on_date!=0)
        $qry.=' AND mrrpm.mrr_date = "'.$report_date.'" ';
    else
        $qry.=' AND mrrpm.mrr_date >= "'.$report_date.'" ';
    $res = $CI->db->query($qry);
    //echo $CI->db->last_query();
    //echo '<pre>'; print_r($res->result_array());exit;
    $pm_category_id = get_pm_category_id($pm_id);
    if($res->num_rows()>0)
    {
        $result1 = $res->row_array();                       
        $mrr_rage_film_qty =($result1['mrr_rage_film_qty'])?$result1['mrr_rage_film_qty']:'0.000';
    }
    else
    {
        $mrr_rage_film_qty = 0.000;
    }
    return $mrr_rage_film_qty;
}
function dw_pm_receipts($pm_id,$from_date,$to_date)
{
  $CI = & get_instance();
    $qry ='SELECT sum(mrrpm.received_qty) as mrr_rage_film_qty
            FROM po_pm as pp
            INNER JOIN po_pm_tanker as ppt ON pp.po_pm_id = ppt.po_pm_id
            INNER JOIN tanker_register as tr ON tr.tanker_id = ppt.tanker_id
            INNER JOIN tanker_pm as tp ON tp.tanker_id = tr.tanker_id                           
            INNER JOIN mrr_pm as mrrpm ON tp.tanker_pm_id = mrrpm.tanker_pm_id                          
            WHERE  pp.pm_id ="'.$pm_id.'" AND tr.plant_id ="'.get_plant_id().'"
            AND mrrpm.mrr_date >= "'.$from_date.'" AND mrrpm.mrr_date <= "'.$to_date.'" ';
    
    $res = $CI->db->query($qry);
    /*echo $CI->db->last_query();
    echo '<pre>'; print_r($res->result_array());exit;*/
    
    if($res->num_rows()>0)
    {
        $result1 = $res->row_array();                       
        $mrr_rage_film_qty =($result1['mrr_rage_film_qty'])?$result1['mrr_rage_film_qty']:'0.000';
    }
    else
    {
        $mrr_rage_film_qty = 0.000;
    }
    return $mrr_rage_film_qty;
}
function get_production_pm_consumption($report_date,$pm_id,$on_date=0)
{
    $CI = & get_instance();
    $CI->db->select('sum(ppm.quantity) as prd_range_film_qty');
    $CI->db->from('production_pm ppm');
    $CI->db->join('production_product pdp','pdp.production_product_id = ppm.production_product_id');
    $CI->db->join('plant_production ptp','ptp.plant_production_id =pdp.plant_production_id');
    if($on_date!=0)
        $CI->db->where('ptp.production_date =',$report_date);
    else
        $CI->db->where('ptp.production_date >=',$report_date);
    $CI->db->where('pm_id',$pm_id);   
    $CI->db->where('ptp.plant_id',get_plant_id());            
    $res1 = $CI->db->get();
    /*echo $CI->db->last_query();exit;
    echo '<pre>'; print_r($res1->row_array()); exit;*/
    if($res1->num_rows()>0)
    {
        $result1 = $res1->row_array();
        $prd_range_film_qty = ($result1['prd_range_film_qty']!='')?$result1['prd_range_film_qty']:0.000;                
    }
    else
    {
        $prd_range_film_qty = 0.000;
    }
    return $prd_range_film_qty;
}
function dw_production_pm_consumption($pm_id,$from_date,$to_date)
{
    $CI = & get_instance();
    $CI->db->select('sum(ppm.quantity) as prd_range_film_qty');
    $CI->db->from('production_pm ppm');
    $CI->db->join('production_product pdp','pdp.production_product_id = ppm.production_product_id');
    $CI->db->join('plant_production ptp','ptp.plant_production_id =pdp.plant_production_id');
    
    $CI->db->where('ptp.production_date >=',$from_date);
    
    $CI->db->where('ptp.production_date <=',$to_date);
    $CI->db->where('pm_id',$pm_id);   
    $CI->db->where('ptp.plant_id',get_plant_id());            
    $res1 = $CI->db->get();
    /*echo $CI->db->last_query();exit;
    echo '<pre>'; print_r($res1->row_array()); exit;*/
    if($res1->num_rows()>0)
    {
        $result1 = $res1->row_array();
        $prd_range_film_qty = ($result1['prd_range_film_qty']!='')?$result1['prd_range_film_qty']:0.000;                
    }
    else
    {
        $prd_range_film_qty = 0.000;
    }
    return $prd_range_film_qty;
}


function get_film_receipts($report_date,$pm_id,$on_date=0)
{
    $CI = & get_instance();
    $qry ='SELECT sum(mrrfilm.received_quantity) as mrr_range_film_qty
             FROM po_pm as pp
            LEFT JOIN po_pm_tanker as ppt ON pp.po_pm_id = ppt.po_pm_id
            LEFT JOIN tanker_register as tr ON tr.tanker_id = ppt.tanker_id
            LEFT JOIN tanker_pm as tp ON tp.tanker_id = tr.tanker_id                            
            LEFT JOIN mrr_pm as mrrpm ON tp.tanker_pm_id = mrrpm.tanker_pm_id 
            LEFT JOIN mrr_pm_film as mrrfilm ON mrrfilm.mrr_pm_id = mrrpm.mrr_pm_id             
            WHERE  pp.pm_id ="'.$pm_id.'" AND tr.plant_id = "'.get_plant_id().'"  ';
    if($on_date!=0)    
        $qry.= 'AND mrrpm.mrr_date = "'.$report_date.'" ';
    else
        $qry.= 'AND mrrpm.mrr_date >= "'.$report_date.'" ';
    $res = $CI->db->query($qry);
    /*echo $CI->db->last_query();
    echo '<pre>'; print_r($res->result_array());exit;*/
    $mrr_receipts = 0;
    if($res->num_rows()>0)
    {
        $result1 = $res->row_array();                       
        $mrr_range_film_qty =($result1['mrr_range_film_qty'])?$result1['mrr_range_film_qty']:'0.000';
    }
    else
    {
        $mrr_range_film_qty = 0.000;
    }
    return $mrr_range_film_qty;
}
function dw_film_receipts($pm_id,$from_date,$to_date)
{
    $CI = & get_instance();
    $qry ='SELECT sum(mrrfilm.received_quantity) as mrr_range_film_qty
             FROM po_pm as pp
            LEFT JOIN po_pm_tanker as ppt ON pp.po_pm_id = ppt.po_pm_id
            LEFT JOIN tanker_register as tr ON tr.tanker_id = ppt.tanker_id
            LEFT JOIN tanker_pm as tp ON tp.tanker_id = tr.tanker_id                            
            LEFT JOIN mrr_pm as mrrpm ON tp.tanker_pm_id = mrrpm.tanker_pm_id 
            LEFT JOIN mrr_pm_film as mrrfilm ON mrrfilm.mrr_pm_id = mrrpm.mrr_pm_id             
            WHERE  pp.pm_id ="'.$pm_id.'" AND tr.plant_id = "'.get_plant_id().'" 
            AND mrrpm.mrr_date >= "'.$from_date.'" AND mrrpm.mrr_date <= "'.$to_date.'"';
   
    $res = $CI->db->query($qry);
    /*echo $CI->db->last_query();
    echo '<pre>'; print_r($res->result_array());exit;*/
    $mrr_receipts = 0;
    if($res->num_rows()>0)
    {
        $result1 = $res->row_array();                       
        $mrr_range_film_qty =($result1['mrr_range_film_qty'])?$result1['mrr_range_film_qty']:'0.000';
    }
    else
    {
        $mrr_range_film_qty = 0.000;
    }
    return $mrr_range_film_qty;
}
function get_production_film_consumption($report_date,$pm_id,$on_date=0)
{
    $CI = & get_instance();
    $CI->db->select('sum(ppm.quantity) as prd_range_film_qty');
    $CI->db->from('production_pm_micron ppm');
    $CI->db->join('production_product pdp','pdp.production_product_id = ppm.production_product_id');
    $CI->db->join('plant_production ptp','ptp.plant_production_id =pdp.plant_production_id');
    if($on_date !=0)
        $CI->db->where('ptp.production_date =',$report_date);    
    else
        $CI->db->where('ptp.production_date >=',$report_date);
    $CI->db->where('ptp.plant_id',get_plant_id());
    $CI->db->where('pm_id',$pm_id);               
    $res1 = $CI->db->get();
    //echo $CI->db->last_query();exit;
    //echo '<pre>'; print_r($res1->row_array()); exit;
    if($res1->num_rows()>0)
    {
        $result1 = $res1->row_array();
        $prd_range_film_qty = ($result1['prd_range_film_qty']!='')?$result1['prd_range_film_qty']:0.000;                
    }
    else
    {
        $prd_range_film_qty = 0.000;
    }
    return $prd_range_film_qty;
}
function dw_production_film_consumption($pm_id,$from_date,$to_date)
{
    $CI = & get_instance();
    $CI->db->select('sum(ppm.quantity) as prd_range_film_qty');
    $CI->db->from('production_pm_micron ppm');
    $CI->db->join('production_product pdp','pdp.production_product_id = ppm.production_product_id');
    $CI->db->join('plant_production ptp','ptp.plant_production_id =pdp.plant_production_id');
    $CI->db->where('ptp.production_date >=',$from_date);   
    $CI->db->where('ptp.production_date <=',$to_date);
    $CI->db->where('ptp.plant_id',get_plant_id());
    $CI->db->where('pm_id',$pm_id);               
    $res1 = $CI->db->get();
    //echo $CI->db->last_query();exit;
    //echo '<pre>'; print_r($res1->row_array()); exit;
    if($res1->num_rows()>0)
    {
        $result1 = $res1->row_array();
        $prd_range_film_qty = ($result1['prd_range_film_qty']!='')?$result1['prd_range_film_qty']:0.000;                
    }
    else
    {
        $prd_range_film_qty = 0.000;
    }
    return $prd_range_film_qty;
}
function get_invoice_stock_for_on_date($report_date,$loose_oil_id,$product_id)
{
    $CI = & get_instance();
    $qry2 ='SELECT  sum(idop.quantity) as invoice_production 
                FROM invoice  as i 
                INNER JOIN invoice_do as ido ON i.invoice_id = ido.invoice_id
                INNER JOIN invoice_do_product as idop ON ido.invoice_do_id = idop.invoice_do_id
                INNER JOIN product as p ON p.product_id = idop.product_id 
                WHERE i.invoice_date = "'.$report_date.'"  AND p.loose_oil_id="'.$loose_oil_id.'"
                AND p.product_id ="'.$product_id.'" AND i.plant_id="'.get_plant_id().'" ';
        $res2 =$CI->db->query($qry2);

        if($res2->num_rows()>0)
        {
            $result2 =$res2->row_array();
            $on_date_invoice = ($result2['invoice_production']!='')?$result2['invoice_production']:0;
        }
        else
        {
            $on_date_invoice = 0;
        }
        return $on_date_invoice;
}
function dw_invoice_stock($loose_oil_id,$product_id,$from_date,$to_date)
{
    $CI = & get_instance();
    $qry2 ='SELECT  sum(idop.quantity) as invoice_production 
                FROM invoice  as i 
                INNER JOIN invoice_do as ido ON i.invoice_id = ido.invoice_id
                INNER JOIN invoice_do_product as idop ON ido.invoice_do_id = idop.invoice_do_id
                INNER JOIN product as p ON p.product_id = idop.product_id 
                WHERE i.invoice_date >= "'.$from_date.'" AND i.invoice_date <= "'.$to_date.'"
                 AND p.loose_oil_id="'.$loose_oil_id.'" AND p.product_id ="'.$product_id.'"
                  AND i.plant_id="'.get_plant_id().'" ';
        $res2 =$CI->db->query($qry2);

        if($res2->num_rows()>0)
        {
            $result2 =$res2->row_array();
            $on_date_invoice = ($result2['invoice_production']!='')?$result2['invoice_production']:0;
        }
        else
        {
            $on_date_invoice = 0;
        }
        return $on_date_invoice;
}
function get_stock_for_on_date($report_date,$loose_oil_id,$product_id)
{
    $CI = & get_instance();
    $qry2 ='SELECT sum(pp.quantity) as qty
                FROM plant_production as ptp
                INNER JOIN production_product as pp ON ptp.plant_production_id = pp.plant_production_id
                INNER JOIN product as p ON p.product_id =pp.product_id 
                WHERE ptp.plant_id ="'.get_plant_id().'" AND DATE(ptp.production_date) = "'.$report_date.'"
                AND p.product_id ="'.$product_id.'"  AND p.loose_oil_id ="'.$loose_oil_id.'" ';
        $res2 =$CI->db->query($qry2);
        //echo $CI->db->last_query();
        //echo '<pre>'; print_r($res2->result_array());
        //exit;
        if($res2->num_rows()>0)
        {
            $result2 = $res2->row_array();
            $on_date_production = ($result2['qty']!='')?$result2['qty']:0;;
        }
        else
        {
            $on_date_production = 0;
        }
    return $on_date_production;
}
function dw_stock_production($loose_oil_id,$product_id,$from_date,$to_date)
{
    $CI = & get_instance();
    $qry2 ='SELECT sum(pp.quantity) as qty
                FROM plant_production as ptp
                INNER JOIN production_product as pp ON ptp.plant_production_id = pp.plant_production_id
                INNER JOIN product as p ON p.product_id =pp.product_id 
                WHERE ptp.plant_id ="'.get_plant_id().'" AND DATE(ptp.production_date) >= "'.$from_date.'" 
                AND DATE(ptp.production_date) <= "'.$to_date.'" AND p.product_id ="'.$product_id.'" 
                 AND p.loose_oil_id ="'.$loose_oil_id.'" ';
        $res2 =$CI->db->query($qry2);
        //echo $CI->db->last_query();
        //echo '<pre>'; print_r($res2->result_array());
        //exit;
        if($res2->num_rows()>0)
        {
            $result2 = $res2->row_array();
            $on_date_production = ($result2['qty']!='')?$result2['qty']:0;;
        }
        else
        {
            $on_date_production = 0;
        }
    return $on_date_production;
}
function  get_invoice_stock_for_searched_date_to_today($loose_oil_id,$report_date,$product_id)
{
    $CI = & get_instance();
    $qry2 ='SELECT  sum(idop.quantity) as invoice_production 
                    FROM invoice  as i 
                    INNER JOIN invoice_do as ido ON i.invoice_id = ido.invoice_id
                    INNER JOIN invoice_do_product as idop ON ido.invoice_do_id = idop.invoice_do_id
                    INNER JOIN product as p ON p.product_id = idop.product_id 
                    WHERE i.invoice_date >= "'.$report_date.'"  AND p.loose_oil_id ="'.$loose_oil_id.'"
                     AND p.product_id="'.$product_id.'" AND i.plant_id="'.get_plant_id().'" ';
                $res2 =$CI->db->query($qry2); 

                if($res2->num_rows()>0)
                {
                    $result2 =$res2->row_array();
                    $s_invoice_production = ($result2['invoice_production']!='')?$result2['invoice_production']:0;
                }
                else
                {
                    $s_invoice_production = 0;
                }
                return $s_invoice_production ;
}
function get_stock_for_searched_date_to_today($loose_oil_id,$report_date,$product_id)
{
    $CI = & get_instance();
$qry2 ='SELECT sum(pp.quantity) as production_qty
                FROM plant_production as ptp
                INNER JOIN production_product as pp ON ptp.plant_production_id = pp.plant_production_id
                INNER JOIN product as p ON p.product_id =pp.product_id 
                WHERE ptp.plant_id ="'.get_plant_id().'" AND DATE(ptp.production_date) >= "'.$report_date.'"
                 AND p.product_id="'.$product_id.'" AND p.loose_oil_id="'.$loose_oil_id.'" ';
                $res2 =$CI->db->query($qry2);
                //echo '<pre>'; print_r($res2->result_array());exit;
                if($res2->num_rows()>0)
                {
                    $result2 = $res2->row_array();
                    $production = ($result2['production_qty']!='')?$result2['production_qty']:0;
                }
                else
                {
                    $production = 0;
                }
    return $production;
}
function get_total_stock_till_today($loose_oil_id,$product_id)
{
    $CI = & get_instance();
    $qry1 ='SELECT ptp.quantity as packed_production
                FROM product as p
                INNER JOIN plant_product as ptp ON p.product_id = ptp.product_id                
                WHERE ptp.plant_id ="'.get_plant_id().'" AND p.loose_oil_id="'.$loose_oil_id.'" 
                AND p.product_id="'.$product_id.'" ';
            $res1 = $CI->db->query($qry1);
            //echo '<pre>'; print_r($res1->result_array());exit;
            //echo $res1->num_rows();exit;
            if($res1->num_rows()>0)
            {
                $result1 =$res1->row_array();
                $packed_data = $result1['packed_production'];
            }
            else
            {
                $packed_data = 0;
            }
        return $packed_data;
}

function get_rankwise_products($loose_oil_id=0)
{
    $CI = & get_instance();
    $CI->db->select('p.*');
    $CI->db->from('product p');
    $CI->db->join('product_capacity pc','p.product_id = pc.product_id');
    $CI->db->join('capacity c','c.capacity_id = pc.capacity_id');
    $CI->db->where('p.status',1);
    if($loose_oil_id!=0)
        $CI->db->where('p.loose_oil_id',$loose_oil_id);
    $CI->db->order_by('p.loose_oil_id ASC,c.rank ASC');
    $res =$CI->db->get();
    return $res->result_array();
}
function get_pending_mrrs($plant_id,$loose_oil_id,$report_date)
{
    $CI = & get_instance();
    //$loose_oil_id =4;
    // get all raise quantity status <=2
    $qryt = 'SELECT loose_oil_id,sum(quantity) as quantity 
             FROM po_oil WHERE loose_oil_id ="'.$loose_oil_id.'" 
             and status <= 2 and po_date <="'.$report_date.'" AND plant_id ="'.$plant_id.'" ';
    $res1 = $CI->db->query($qryt);
    /*echo $CI->db->last_query();//exit;*/
    //echo '<pre>'; print_r($res1->result_array());//exit; 
    //echo $total_mrrs.'<br>';exit;
    // get received mrr status <=2
    $qry ='SELECT sum(tol.gross - tol.tier)/1000 as mrr_data
             FROM po_oil as pl
            LEFT JOIN po_oil_tanker as plt ON pl.po_oil_id = plt.po_oil_id
            LEFT JOIN tanker_register as tr ON tr.tanker_id = plt.tanker_id
            LEFT JOIN tanker_oil as tol ON tol.tanker_id = tr.tanker_id 
            LEFT JOIN mrr_oil as mo ON mo.tanker_oil_id = tol.tanker_oil_id
            WHERE  pl.loose_oil_id ="'.$loose_oil_id.'" AND po_date <="'.$report_date.'" 
            AND pl.plant_id ="'.$plant_id.'" AND mo.mrr_date <= "'.$report_date.'"  
            AND pl.status <=2 ';
    $res2 = $CI->db->query($qry);
    //echo $CI->db->last_query();exit;
    //echo '<pre>'; print_r($res2->result_array());//exit;

    // get closed quantity
    $qryt = 'SELECT loose_oil_id,po_oil_id,sum(quantity) as quantity ,status
             FROM po_oil WHERE loose_oil_id ="'.$loose_oil_id.'" AND status =3 
             AND po_date <="'.$report_date.'" and DATE(closed_time) > "'.$report_date.'"
              AND plant_id = "'.$plant_id.'" ';
    $res3 = $CI->db->query($qryt);
    //echo $CI->db->last_query();//exit;
    //echo '<pre>'; print_r($res3->result_array());//exit;  
    //echo $total_mrrs.'<br>';exit;
    // get received mrr status <=2
    $qry ='SELECT pl.po_oil_id,sum(tol.gross - tol.tier)/1000 as mrr_data
             FROM po_oil as pl
            LEFT JOIN po_oil_tanker as plt ON pl.po_oil_id = plt.po_oil_id
            LEFT JOIN tanker_register as tr ON tr.tanker_id = plt.tanker_id
            LEFT JOIN tanker_oil as tol ON tol.tanker_id = tr.tanker_id 
            LEFT JOIN mrr_oil as mo ON mo.tanker_oil_id = tol.tanker_oil_id
            WHERE  pl.loose_oil_id ="'.$loose_oil_id.'" AND pl.plant_id ="'.$plant_id.'" 
            AND pl.po_date <="'.$report_date.'" AND DATE(pl.closed_time) > "'.$report_date.'" 
            AND pl.status =3 AND mo.mrr_date <= "'.$report_date.'"  group by pl.po_oil_id ';
    $res4 = $CI->db->query($qry);
    //echo $CI->db->last_query();//exit;
    //echo '<pre>'; print_r($res4->result_array());exit;    
    if($res1->num_rows()>0){ 
        $result1 = $res1->row_array();
        $q1_data = $result1['quantity'];
    }
    else{
        $q1_data = 0;
    }
    if($res2->num_rows()>0){ 
        $result2 = $res2->row_array();
        $q2_data = $result2['mrr_data'];
    }
    else{
        $q2_data = 0;
    }
    if($res3->num_rows()>0){ 
        $result3 = $res3->row_array();
        $q3_data = $result3['quantity'];
    }
    else{
        $q3_data = 0;
    }
    if($res4->num_rows()>0){ 
        $result4 = $res4->row_array();
        $q4_data = $result4['mrr_data'];
    }
    else{
        $q4_data = 0;
    }
    $t_qty = $q1_data - $q2_data + $q3_data- $q4_data;   
     //echo $t_qty;exit;
    $total = array(
            't_qty' => $t_qty
            );
    /*echo $t_qty;
    exit;*/
    return $total;
}



// get production On Searched Date For Loose Oil In MT
// Note you can directly take from oil stock balance
function get_on_date_production($report_date,$loose_oil_id)
{
    $CI = & get_instance();
    $qry2 ='SELECT sum(pp.quantity*p.items_per_carton*p.oil_weight)/1000 as qty_in_kg
            FROM plant_production as ptp
            INNER JOIN production_product as pp ON ptp.plant_production_id = pp.plant_production_id
            INNER JOIN product as p ON p.product_id =pp.product_id 
            WHERE ptp.plant_id ="'.get_plant_id().'" AND DATE(ptp.production_date) = "'.$report_date.'"  
            AND p.loose_oil_id="'.$loose_oil_id.'" ';
    $res2 =$CI->db->query($qry2);
    if($res2->num_rows()>0)
    {
        $result2 = $res2->row_array();
        $production = ($result2['qty_in_kg']);
    }
    else
    {
        $production = 0.000;
    }
    return $production;
}

function dw_production($plant_id,$loose_oil_id,$from_date,$to_date)
{
    $CI = & get_instance();
    $qry2 ='SELECT sum(pp.quantity*p.items_per_carton*p.oil_weight)/1000 as qty_in_kg
            FROM plant_production as ptp
            INNER JOIN production_product as pp ON ptp.plant_production_id = pp.plant_production_id
            INNER JOIN product as p ON p.product_id =pp.product_id 
            WHERE ptp.plant_id ="'.$plant_id.'" AND DATE(ptp.production_date) >= "'.$from_date.'"  
            AND DATE(ptp.production_date) <= "'.$to_date.'"  
            AND p.loose_oil_id="'.$loose_oil_id.'" ';
    $res2 =$CI->db->query($qry2);
    if($res2->num_rows()>0)
    {
        $result2 = $res2->row_array();
        $production = ($result2['qty_in_kg']);
    }
    else
    {
        $production = 0.000;
    }
    return $production;
}
// Whole production till today in MT for a Loose Oil
function get_whole_packed_oil($plant_id,$loose_oil_id)
{  
    $CI = & get_instance();  
    $qry1 ='SELECT sum(p.items_per_carton*p.oil_weight*ptp.quantity)/1000 as packed_production
            FROM product as p
            INNER JOIN plant_product as ptp ON p.product_id = ptp.product_id                
            WHERE ptp.plant_id ="'.$plant_id.'" AND p.loose_oil_id="'.$loose_oil_id.'" ';
    $res1 = $CI->db->query($qry1);
    //echo '<pre>'; print_r($res1->result_array());exit;
    if($res1->num_rows()>0)
    {
        $result1 =$res1->row_array();
        $packed_data = ($result1['packed_production']!='')?($result1['packed_production']):'0.000';
    }
    else
    {
        $packed_data =0.000;
    }
    return $packed_data;

}
// Get Production From Searched Date to Today in loose oil MT
function get_searched_date_to_today_production($plant_id,$report_date,$loose_oil_id)
{
     $CI = & get_instance();
    $qry2 ='SELECT sum(pp.quantity*p.items_per_carton*p.oil_weight) as qty_in_kg
            FROM plant_production as ptp
            INNER JOIN production_product as pp ON ptp.plant_production_id = pp.plant_production_id
            INNER JOIN product as p ON p.product_id =pp.product_id 
            WHERE ptp.plant_id ="'.$plant_id.'" AND DATE(ptp.production_date) >= "'.$report_date.'" 
             AND p.loose_oil_id="'.$loose_oil_id.'" ';
            $res2 =$CI->db->query($qry2);
            if($res2->num_rows()>0)
            {
                $result2 = $res2->row_array();
                $production = (($result2['qty_in_kg'])/1000);
            }
            else
            {
                $production = 0.000;
            }
        return $production;
}

// Invoice From searched date to today in Loose oil MT
function get_searched_date_to_today_invoice($plant_id,$report_date,$loose_oil_id,$cumulative = 0)
{
    $first_day = date('Y-m-01', strtotime($report_date));
    //echo $first_day;exit;
    $CI = & get_instance();
    $qry2 ='SELECT  sum(idop.items_per_carton*p.oil_weight*idop.quantity)/1000 as invoice_production 
        FROM invoice  as i 
        INNER JOIN invoice_do as ido ON i.invoice_id = ido.invoice_id
        INNER JOIN invoice_do_product as idop ON ido.invoice_do_id = idop.invoice_do_id
        INNER JOIN product as p ON p.product_id = idop.product_id 
        WHERE  p.loose_oil_id="'.$loose_oil_id.'" AND i.plant_id="'.$plant_id.'" ';
        if($cumulative!= 0)
        {

             $qry2.='AND i.invoice_date >= "'.$first_day.'" AND i.invoice_date <= "'.$report_date.'"  ';   
        }
        else
        {
            $qry2.='AND i.invoice_date = "'.$report_date.'" ';
        }

        $res2 =$CI->db->query($qry2); 
        //echo $CI->db->last_query();exit;
        if($res2->num_rows()>0)
        {
            $result2 =$res2->row_array();
            $s_invoice_production = ($result2['invoice_production']!='')?($result2['invoice_production']):'0.000';
        }
        else
        {
            $s_invoice_production = 0.000;
        }
        return $s_invoice_production;
}
function dw_invoice($plant_id,$loose_oil_id,$from_date,$to_date,$type = 1)
{
    
    //echo $first_day;exit;
    $CI = & get_instance();
    $qry2 ='SELECT  sum(idop.items_per_carton*p.oil_weight*idop.quantity)/1000 as invoice_production 
        FROM invoice  as i 
        INNER JOIN invoice_do as ido ON i.invoice_id = ido.invoice_id
        INNER JOIN invoice_do_product as idop ON ido.invoice_do_id = idop.invoice_do_id
        INNER JOIN `order` as o ON ido.order_id = o.order_id  
        INNER JOIN product as p ON p.product_id = idop.product_id 
        WHERE  p.loose_oil_id="'.$loose_oil_id.'" AND i.plant_id="'.$plant_id.'" ';
        $qry2.='AND i.invoice_date >= "'.$from_date.'" AND i.invoice_date <= "'.$to_date.'" 
        AND o.type ="'.$type.'" ';   
        

        $res2 =$CI->db->query($qry2); 
        //echo $CI->db->last_query();exit;
        if($res2->num_rows()>0)
        {
            $result2 =$res2->row_array();
            $s_invoice_production = ($result2['invoice_production']!='')?($result2['invoice_production']):'0.000';
        }
        else
        {
            $s_invoice_production = 0.000;
        }
        return $s_invoice_production;
}
function get_total_invoice_fromdate_to_today($plant_id,$from_date,$loose_oil_id)
{
    
    //echo $first_day;exit;
    $CI = & get_instance();
    $qry2 ='SELECT  sum(idop.items_per_carton*p.oil_weight*idop.quantity)/1000 as invoice_production 
        FROM invoice  as i 
        INNER JOIN invoice_do as ido ON i.invoice_id = ido.invoice_id
        INNER JOIN invoice_do_product as idop ON ido.invoice_do_id = idop.invoice_do_id
        INNER JOIN product as p ON p.product_id = idop.product_id 
        WHERE  p.loose_oil_id="'.$loose_oil_id.'" 
        AND i.plant_id="'.$plant_id.'"  AND i.invoice_date >= "'.$from_date.'" ';
        
            
       

        $res2 =$CI->db->query($qry2); 
        //echo $CI->db->last_query();exit;
        if($res2->num_rows()>0)
        {
            $result2 =$res2->row_array();
            $s_invoice_production = ($result2['invoice_production']!='')?($result2['invoice_production']):'0.000';
        }
        else
        {
            $s_invoice_production = 0.000;
        }
        return $s_invoice_production;
}
// Leakeage From Searched Date to Today
function get_searched_date_to_today_leakage($plant_id,$report_date,$loose_oil_id)
{
     $CI = & get_instance();
   $CI->db->select('(sum((opsl.leaked_pouches*p.oil_weight) - opsl.oil_recovered))/1000 as leaked_qty');
    $CI->db->from('ops_leakage opsl');
    $CI->db->join('product p','p.product_id = opsl.product_id');
    $CI->db->where('opsl.plant_id',$plant_id);
    $CI->db->where('p.loose_oil_id',$loose_oil_id);
    $CI->db->where('recover_type',2);
    $CI->db->where('opsl.on_date >=',$report_date);
    $res = $CI->db->get();
    //echo $CI->db->last_query();exit;
    //echo $res->num_rows();exit;
    if($res->num_rows()>0)
    {
        $result1 = $res->row_array();
        $leakage = ($result1['leaked_qty'])?$result1['leaked_qty']:'0.000';
    }
    else
    {
        $leakage = 0.000;
    }
    return $leakage;
}

//  Invoice Data For Searched date 
function get_on_date_invoice($plant_id,$report_date,$loose_oil_id,$type=1)
{
     $CI = & get_instance();
    $qry2 ='SELECT  sum(idop.items_per_carton*p.oil_weight*idop.quantity) as invoice_production 
            FROM invoice  as i 
            INNER JOIN invoice_do as ido ON i.invoice_id = ido.invoice_id            
            INNER JOIN invoice_do_product as idop ON ido.invoice_do_id = idop.invoice_do_id
            INNER JOIN product as p ON p.product_id = idop.product_id
            INNER JOIN `order` as o ON ido.order_id = o.order_id  
            WHERE i.invoice_date = "'.$report_date.'"  AND p.loose_oil_id="'.$loose_oil_id.'" 
            AND i.plant_id = "'.$plant_id.'"  ';
    // 3 for both distributor and plant .so no condition check
    if($type!=3)
    {
        $qry2 .= 'AND o.type="'.$type.'" ';
    }

    $res2 =$CI->db->query($qry2); 
    //echo $CI->db->last_query();exit;

    if($res2->num_rows()>0)
    {
        $result2 =$res2->row_array();
        $invoice_production = ($result2['invoice_production']/1000);
    }
    else
    {
        $invoice_production = 0.000;
    }
return $invoice_production;
}


function get_tins_id()
{
    return 3;
}
function get_vat_percentage($order_id)
{
    $dist_type = get_dist_type_by_order($order_id);
    //echo $dist_type;exit;
    if($dist_type == 3)
        return get_preference('cst_vat','general_settings');
    else
        return get_preference('regular_vat','general_settings');
}
function get_dist_type_by_order($order_id)
{
    $CI = & get_instance();
    $CI->db->select('o.*');
    $CI->db->from('order o');    
    $CI->db->where('o.order_id',$order_id);
    $res = $CI->db->get();
    $result = $res->row_array();
    //print_r($result);exit;
    return $result['ob_type_id'];

}

function pending_po_oil($po_oil_id)
{
        $CI = & get_instance();
        $qry ='SELECT pl.quantity as ordered_qty,sum(tol.gross - tol.tier)/1000 as mrr_data
             FROM po_oil as pl
             LEFT JOIN po_oil_tanker as plt ON pl.po_oil_id = plt.po_oil_id
            LEFT JOIN tanker_register as tr ON tr.tanker_id = plt.tanker_id
            LEFT JOIN tanker_oil as tol ON tol.tanker_id = tr.tanker_id 
            LEFT JOIN mrr_oil as mo ON mo.tanker_oil_id = tol.tanker_oil_id
            WHERE pl.po_oil_id = "'.$po_oil_id.'"  ';
          if(get_ses_block_id()==1)
          {
          	$qry .= ' group by pl.po_oil_id ';
          }
          else
          {
                  $qry .= 'AND pl.plant_id ="'.get_plant_id().'"  group by pl.po_oil_id ';
          }
    $res = $CI->db->query($qry);
   // echo $CI->db->last_query();exit;
    //echo '<pre>'; print_r($res->result_array());exit;
    $t_qty = 0;
    if($res->num_rows()>0)
    {           
        foreach ($res->result_array() as $rec) {
            $t_qty += ($rec['ordered_qty'] - $rec['mrr_data']);
        }
        //$t_qty = ($t_qty/1000);
        $total = $t_qty;
    }
    else
    {
        $total = 0.000;
    }
    

    return $total;
    
}
function get_ob_date($order_id)
{
    $CI = & get_instance();
    $CI->db->select('o.order_date');
    $CI->db->from('order o');   
    $CI->db->where('o.order_id', $order_id);    
    $res=$CI->db->get();    
    $result = $res->row_array();
    return $result['order_date'];
    
}
function get_ob_number($order_id)
{
    $CI = & get_instance();
    $CI->db->select('o.order_number');
    $CI->db->from('order o');   
    $CI->db->where('o.order_id', $order_id);    
    $res=$CI->db->get();    
    $result = $res->row_array();
    return $result['order_number']; 
}
function get_micron_drop_down()
{
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('micron');     
    $CI->db->where('status', 1);    
    $res = $CI->db->get();
    //$micron_results="<option value=''>-Select Micron-</option>";
    $micron_results='';

    if($res->num_rows()>0)
    {
        $i = 1;
        
        foreach($res->result_array() as $micron)
        {
            $selected = ($i==2)?'selected':'';
            $micron_results.='<option value="'.$micron['micron_id'].'" '.$selected.' >'.$micron['name'].'</option>';      
            $i++;
        }
    }
    else
    {
        $micron_results.="<option value=''>-No Data Found-</option>"; 
    }

    return $micron_results;
}

function get_film_pms($product_id)
{
    $CI = & get_instance();
    $CI->db->select('pm.pm_id as pm_id,pm.name as name');
    $CI->db->from('product_packing_material ppm');
    $CI->db->join('packing_material_capacity pmc','ppm.pm_id = pmc.pm_id');
    $CI->db->join('packing_material pm','pm.pm_id = pmc.pm_id');   
    $CI->db->where('ppm.product_id', $product_id);
    $CI->db->where('pm.pm_category_id',get_film_category_id());      
    $res=$CI->db->get();
   // $film_results="<option value=''>-Packing Material-</option>";
    $film_results ='';

    if($res->num_rows()>0)
    {
        foreach($res->result_array() as $film)
        {
            $film_results.='<option value="'.$film['pm_id'].'">'.$film['name'].'</option>';      
        }
    }
    else
    {
        $film_results.="<option value=''>-No Data Found-</option>"; 
    }

    return $film_results;
}

function check_pm_has_film_cat($pm_id_arr)
{
    foreach ($pm_id_arr as  $value) {
        $pm_id_arr2[] =$value['pm_id'];
    }
    $pm_id_string = implode(",", $pm_id_arr2);
    /*echo '<pre>';
    print_r($pm_id_string);exit;*/
    $CI = & get_instance();
    $CI->db->select('pm.*');
    $CI->db->from('packing_material pm');
    $CI->db->where('pm.pm_category_id',get_film_category_id());   
    $CI->db->where_in('pm.pm_id',$pm_id_string);    
    $res=$CI->db->get();
    //echo $res->num_rows();exit;
    if($res->num_rows()>0)
    {
        return 1;
    }
    else
    {
        return 0;
    }

}
function get_film_category_id()
{
    return 1;
}
function get_packing_material_ids($product_id)
{
    $CI = & get_instance();
    $CI->db->select('ppm.pm_id');
    $CI->db->from('product_packing_material ppm');
    $CI->db->join('packing_material_capacity pmc','ppm.pm_id = pmc.pm_id');
    $CI->db->join('packing_material pm','pm.pm_id = pmc.pm_id');   
    $CI->db->where('ppm.product_id', $product_id);
    $CI->db->where('pm.pm_category_id',get_film_category_id());      
    $res=$CI->db->get();
    if($res->num_rows()>0)
    {
        return 1;
    }
    else
    {
        return 0;
    }
}
function get_micron_name($micron_id)
{
    $CI = & get_instance();
    $CI->db->select('m.name');
    $CI->db->from('micron m');   
    $CI->db->where('m.micron_id', $micron_id);    
    $res=$CI->db->get();
    $result= $res->row_array();
    return $result['name']; 
}

function get_product_stock($product_id)
{
    $CI = & get_instance();
    $CI->db->select('p.items_per_carton,p.oil_weight,pp.quantity,pp.loose_pouches');
    $CI->db->from('product p'); 
    $CI->db->join('plant_product pp','p.product_id = pp.product_id','left');
    $CI->db->where('p.product_id', $product_id);    
    $res=$CI->db->get();
    if($res->num_rows()>0){
        return $res->row_array();
    }else{
        return FALSE;
    }  

}
function get_allowed_percentage()
{
    return 0.04;
}
function get_plant_name_not_in_session($plant_id)
{
    $CI = & get_instance();
    $CI->db->select('p.name');
    $CI->db->from('plant p');   
    $CI->db->where('p.plant_id', $plant_id);    
    $res=$CI->db->get();
    $result= $res->row_array();
    return $result['name'];
}
function get_plant_name()
{
    $ci = & get_instance();
    return $ci->session->userdata('plant_name');
}
function get_plant_id()
{
    
    $ci = & get_instance();
    return $ci->session->userdata('ses_plant_id');
    //return 4;
}
function get_m_plant_name()
{
   $ci = & get_instance();
    return $ci->session->userdata('plant_name'); 
}
function get_tanker_received_pm_status()
{
    return 5;
}
function get_opening_balance_reading_time()
{
    $CI = & get_instance();
    $CI->db->select('value');
    $CI->db->from('preference');     
    $CI->db->where('type', 1);
    $CI->db->where('name', 'opening_stock_entry_time'); 
    $res = $CI->db->get(); 
    if($res->num_rows()>0)
    {
        $row = $res->row_array();
        return $row['value'];
    }
    else
    {
        return '10:30';
    }  
    
}


function get_items_per_carton($product_id)
{
    $CI = & get_instance();
    $CI->db->select('p.items_per_carton');
    $CI->db->from('product p');   
    $CI->db->where('p.product_id', $product_id);    
    $res=$CI->db->get();
    $result= $res->row_array();
    return $result['items_per_carton'];
}

function get_oil_weight($product_id)
{
    $CI = & get_instance();
    $CI->db->select('p.oil_weight');
    $CI->db->from('product p');   
    $CI->db->where('p.product_id', $product_id);    
    $res=$CI->db->get();
    $result= $res->row_array();
    return $result['oil_weight'];
}

function get_loose_oil_id($product_id)
{
    $CI = & get_instance();
    $CI->db->select('p.loose_oil_id');
    $CI->db->from('product p');   
    $CI->db->where('p.product_id', $product_id);    
    $res=$CI->db->get();
    $result= $res->row_array();
    return $result['loose_oil_id'];
}
function get_product_name($product_id)
{
    $CI = & get_instance();
    $CI->db->select('p.name');
    $CI->db->from('product p');   
    $CI->db->where('p.product_id', $product_id);    
    $res=$CI->db->get();
    $result= $res->row_array();
    return $result['name'];
}
function get_pm_code($pm_id)
{
    $CI = & get_instance();
    $CI->db->select('pm.pm_code');
    $CI->db->from('packing_material pm');   
    $CI->db->where('pm.pm_id', $pm_id);    
    $res=$CI->db->get();
    $result= $res->row_array();
    return $result['pm_code'];
}
function get_pm_name($pm_id)
{
    $CI = & get_instance();
    $CI->db->select('pm.name');
    $CI->db->from('packing_material pm');   
    $CI->db->where('pm.pm_id', $pm_id);    
    $res=$CI->db->get();
    $result= $res->row_array();
    return $result['name'];
}
function get_tapes_id()
{
    return 4;
}

function get_pm_unit_name($pm_id)
{
    $CI = & get_instance();
    $CI->db->select('pmu.name');
    $CI->db->from('packing_material pm');  
    $CI->db->join('packing_material_category pmc','pmc.pm_category_id = pm.pm_category_id');
    $CI->db->join('pm_unit pmu','pmu.pm_unit = pmc.pm_unit'); 
    $CI->db->where('pm.pm_id',$pm_id);    
    $res=$CI->db->get();
    $result= $res->row_array();
    return $result['name'];
}
function get_loose_oil_name($loose_oil_id)
{
    $CI = & get_instance();
    $CI->db->select('lo.name');
    $CI->db->from('loose_oil lo');   
    $CI->db->where('lo.loose_oil_id', $loose_oil_id);    
    $res=$CI->db->get();
    $result= $res->row_array();
    return $result['name'];
}


function get_capacity_id($product_id)
{
    $CI = & get_instance();
    $CI->db->select('pc.capacity_id as capacity_id');
    $CI->db->from('product_capacity pc');   
    $CI->db->where('pc.product_id', $product_id);    
    $res=$CI->db->get();
    $result= $res->row_array();
    return $result['capacity_id'];  
}
function get_product_full_name($product_id)
{
    $CI = & get_instance();
    $CI->db->select('concat(p.name,c.name,u.name) as name');
    $CI->db->from('product_capacity pc'); 
    $CI->db->join('capacity c','pc.capacity_id = c.capacity_id');
    $CI->db->join('unit u','u.unit_id =c.capacity_id');
    $CI->db->join('product p','p.product_id = pc.capacity_id');
    $CI->db->where('pc.product_id', $product_id);    
    $res=$CI->db->get();
    $result= $res->row_array();
    return $result['name']; 
}
function get_order($tablename)
{
    $CI = & get_instance();
    $qry = "SELECT MAX(lt.order) as order_v FROM ".$tablename." lt";
    $res = $CI->db->query($qry);
   // echo $CI->db->last_query();exit;
    if($res->num_rows()>0)
    {
      $result=$res->row_array();
      return $result['order_v']+5;
    }
    else
    {
      return 5;
    }
    
}
function get_state_details()
{
    $CI = & get_instance();
    $CI->db->select('l.*');
    $CI->db->from('location l');            
    $CI->db->where('tl.name','State');
    $CI->db->join('territory_level tl ','tl.level_id = l.level_id');
    $res = $CI->db->get();
    if($res->num_rows()>0)    
        return $res->result_array();   
    else
        return FALSE;    
}

function getParentLocation($location_id)
{
  $CI = & get_instance();
  if($location_id != '')
  {
    $q = "SELECT l1.location_id, CASE WHEN (l1.level_id = 2) then l1.name else
        concat(l1.name, ' (', l2.name, ')') end as name from location l
        LEFT JOIN location l1 on l1.location_id = l.parent_id
        LEFT JOIN location l2 on l2.location_id = l1.parent_id
        WHERE l.location_id = '".$location_id."'";
    $res = $CI->db->query($q);
    if($res->num_rows() > 0)
    {
      $data = $res->result_array();
      return $data[0];
    }
    else
      return array('location_id' => '', 'name' => '-Select Parent-');   
  }
  else
    return array('location_id' => '', 'name' => '-Select Parent-');
}

 
function eip_decode($id){
    $CI = & get_instance();
    $id=str_replace(array('asdf99797',' '), array('/','+'), $id);
     return $CI->encrypt->decode($id);
  }

  function eip_encode($id)
{
    $CI = & get_instance(); 
    return str_replace(array('/'), array('asdf99797'),$CI->encrypt->encode($id));
}


function ajax_get_regions_by_state_id($state_id)
{
    $CI = & get_instance();
    $CI->db->select('l.location_id,concat(l.name," (",l1.name,") ") as name');
    $CI->db->from('location l');      
    $CI->db->join('location l1','l1.location_id = l.parent_id','left');
    $CI->db->where('l1.location_id',$state_id);
    $CI->db->where('l.status', 1);
    $CI->db->join('territory_level tl ','tl.level_id = l.level_id');
    $res = $CI->db->get();
    $region_results="<option value=''>-Select Region-</option>";
    if($res->num_rows()>0)
    {
        foreach($res->result_array() as $region)
        {
            $region_results.='<option value="'.$region['location_id'].'">'.$region['name'].'</option>';      
        }
    }
    else
    {
        $region_results.="<option value=''>-No Data Found-</option>"; 
    }
    return $region_results;
}

function ajax_get_districts_by_region_id($region_id)
{
    $CI = & get_instance();
    $CI->db->select('l.*');
    $CI->db->from('location l');            
    $CI->db->where('tl.name','District');
    $CI->db->where('l.parent_id',$region_id);
    $CI->db->where('l.status', 1);
    $CI->db->join('territory_level tl ','tl.level_id = l.level_id');
    $res = $CI->db->get();
    $district_results="<option value=''>-Select District-</option>";

    if($res->num_rows()>0)
    {
        foreach($res->result_array() as $dictrict)
        {
            $district_results.='<option value="'.$dictrict['location_id'].'">'.$dictrict['name'].'</option>';      
        }
    }
    else
    {
        $district_results.="<option value=''>-No Data Found-</option>"; 
    } 
    return $district_results;
}

function ajax_get_areas_by_district_id($district_id)
{
    $CI = & get_instance();
    $CI->db->select('l.*');
    $CI->db->from('location l');            
    $CI->db->where('tl.name','Area');
    $CI->db->where('l.parent_id',$district_id);
    $CI->db->where('l.status', 1);
    $CI->db->join('territory_level tl ','tl.level_id = l.level_id');
    $res = $CI->db->get();
    $area_results="<option value=''>-Select City/Town-</option>";   

    if($res->num_rows()>0)
    {   
        foreach($res->result_array() as $area)
        {
            $area_results.='<option value="'.$area['location_id'].'">'.$area['name'].'</option>';      
        }
    }
    else
    {
        $area_results.="<option value=''>-No Data Found-</option>";
    }
    return $area_results;
}

 function get_regions()
  {
    $CI = & get_instance();
    $CI->db->select('l.location_id,concat(l.name," (",l1.name,") ") as name');
    $CI->db->from('location l');    
    $CI->db->join('location l1','l1.location_id = l.parent_id','left');
    $CI->db->where('tl.name', 'Region');
    $CI->db->join('territory_level tl ','tl.level_id = l.level_id');
    $res=$CI->db->get();
    return $res->result_array();
  }

function ajax_get_products_by_loose_oil($loose_oil_id)
{
    $CI = & get_instance();
    $CI->db->select('p.product_id as product_id,p.name as name');
    $CI->db->from('loose_oil lo');      
    $CI->db->join('product p','p.loose_oil_id = lo.loose_oil_id');
    if($loose_oil_id!='')
        $CI->db->where('lo.loose_oil_id',$loose_oil_id);
    $CI->db->where('lo.status', 1);
    $CI->db->where('p.status', 1);    
    $res = $CI->db->get();
    $product_results="<option value=''>-Select Product-</option>";
    if($res->num_rows()>0)
    {
        foreach($res->result_array() as $product)
        {
            $product_results.='<option value="'.$product['product_id'].'">'.$product['name'].'</option>';      
        }
    }
    else
    {
        $product_results.="<option value=''>-No Data Found-</option>"; 
    }
    return $product_results;
}
function ajax_get_pms_by_product($product_id)
{
    $CI = & get_instance();
    $CI->db->select('pm.pm_id as pm_id,pm.name as name');
    $CI->db->from('product_packing_material pdpm');      
    $CI->db->join('packing_material pm','pm.pm_id = pdpm.pm_id');
    if($product_id!='')
        $CI->db->where('pdpm.product_id',$product_id);    
    $CI->db->where('pm.status', 1);    
    $res = $CI->db->get();
    $product_results="<option value=''>-Select PM-</option>";
    if($res->num_rows()>0)
    {
        foreach($res->result_array() as $product)
        {
            $product_results.='<option value="'.$product['pm_id'].'">'.$product['name'].'</option>';      
        }
    }
    else
    {
        $product_results.="<option value=''>-No Data Found-</option>"; 
    }
    return $product_results;
}
function penalties_array()
{
    $penalties_array = array(16,23,31);
    return $penalties_array;
}
function get_penalty_price($days)
{
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('ob_penalty');
    $CI->db->where('penalty_days',$days);
    $res = $CI->db->get();
    return $res->row_array();
    //print_r($result);exit;
    //return $['penalty']; 
}
function get_distribuutor_name_and_code($distributor_id)
{
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('distributor');
    $CI->db->where('distributor_id',$distributor_id);
    $res = $CI->db->get();
    return $res->row_array();
}
function get_ob_number_and_date($order_id)
{
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->from('order');
    $CI->db->where('order_id',$order_id);
    $res = $CI->db->get();
    return $res->row_array();
}
function get_product_short_name($product_id)
{
    $CI = & get_instance();
    $CI->db->select('p.short_name');
    $CI->db->from('product p');   
    $CI->db->where('p.product_id', $product_id);    
    $res=$CI->db->get();
    $result= $res->row_array();
    return $result['short_name'];
}

function update_rb($approval_id,$name,$remarks,$single_level)
{
    $ci=& get_instance();
    $approval_data = $ci->Common_model->get_data_row('approval_list',array('approval_id'=>$approval_id));
    $pref_data = $ci->Common_model->get_data_row('reporting_preference',array('rep_preference_id'=>$approval_data['rep_preference_id']));

    
    if($single_level == 0)
    {
        $update_approval_data = array('status'        => 2,
                                      'modified_by'   => $ci->session->userdata('user_id'),
                                      'modified_time' => date('Y-m-d H:i:s'));
        $updata_approval_where = array('approval_id'  => $approval_id);
        $ci->Common_model->update_data('approval_list',$update_approval_data,$updata_approval_where);

        $insert_data = array('approval_id'   => $approval_id,
                             'issued_by'     => $ci->session->userdata('block_designation_id'),
                             'remarks'       => $remarks,
                             'created_by'    =>  $ci->session->userdata('user_id'),
                             'created_time'  =>  date('Y-m-d H:i:s'));
        $ci->Common_model->insert_data('approval_list_history',$insert_data);
    }

    $daily_data=  array('activity'      =>  $name,
                        'created_by'    =>  $ci->session->userdata('user_id'),
                        'created_time'  =>  date('Y-m-d H:i:s')
                        );
    $ci->Common_model->insert_data('daily_corrections',$daily_data);
}
function ajax_get_mandals_by_district_id($district_id)
{
    $CI = & get_instance();
    $CI->db->select('l.*');
    $CI->db->from('location l');            
    $CI->db->where('tl.name','Mandal');
    $CI->db->where('l.parent_id',$district_id);
    $CI->db->where('l.status', 1);
    $CI->db->join('territory_level tl ','tl.level_id = l.level_id');
    $res = $CI->db->get();
    $mandal_results="<option value=''>-Select Mandal-</option>";   

    if($res->num_rows()>0)
    {   
        foreach($res->result_array() as $mandal)
        {
            $mandal_results.='<option value="'.$mandal['location_id'].'">'.$mandal['name'].'</option>';      
        }
    }
    else
    {
        $mandal_results.="<option value=''>-No Data Found-</option>";
    }
    return $mandal_results;
}

function ajax_get_areas_by_mandal_id($mandal_id)
{
    $CI = & get_instance();
    $CI->db->select('l.*');
    $CI->db->from('location l');            
    $CI->db->where('tl.name','Area');
    $CI->db->where('l.parent_id',$mandal_id);
    $CI->db->where('l.status', 1);
    $CI->db->join('territory_level tl ','tl.level_id = l.level_id');
    $res = $CI->db->get();
    $area_results="<option value=''>-Select City/Town-</option>";   

    if($res->num_rows()>0)
    {   
        foreach($res->result_array() as $area)
        {
            $area_results.='<option value="'.$area['location_id'].'">'.$area['name'].'</option>';      
        }
    }
    else
    {
        $area_results.="<option value=''>-No Data Found-</option>";
    }
    return $area_results;
}