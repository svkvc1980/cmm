<?php //Prasad Helper
function get_all_plants()
{
	return 2;
}

function get_loose_oil_tank_id()
{
	return 1;
}
function get_pm_tank_id()
{
	return 2;
}
function get_pm_film_id()
{
	return 7;
}
function get_empty_truck_id()
{
	return 3;
}
function get_blocks($block_id)
{
   if($block_id ==3 || $block_id ==4)
   {
   	 return 2;
   }
   else
   {
   	 return 1;
   }
}
function get_godown()
{
	return 1;
}
function get_counter_sale()
{
	return 2;
}
 function get_film_cat_id()
{
   return 1;
}
function get_tape_650mt()
{
   return 3;
}
function get_tape_65mt()
{
   return 4;
}
//for FFA ground nut
function gn_loose_oil_id()
{
   return 1;
}
function get_ffa_test_id()
{
   return 9;
}
function get_ops_block_id()
{
   return 2;
}
function get_candf_block_id()
{
   return 4;
}
function get_stock_block_id()
{
   return 3;
}
function get_type_name($type_id)
{
   if($type_id==1)
   {
      return "Godown";
   }
   elseif($type_id==2)
   {
      return "Counter Sale";
   }
}
function get_distributor_based_invoice($invoice_id)
{
   $ci=  & get_instance();
   $ci->db->select('n.distributor_place as location_name,n.distributor_code as distributor_code,n.agency_name as agency_name,p.name as plant_name');
   $ci->db->from('invoice_do id');
   $ci->db->join('do_order d','id.do_id=d.do_id','left');
   $ci->db->join('order o','d.order_id=o.order_id','left');
   $ci->db->join('distributor_order do','o.order_id=do.order_id','left');
   $ci->db->join('distributor n','do.distributor_id=n.distributor_id','left');
  // $ci->db->join('location l','n.location_id=l.location_id','left');
   $ci->db->join('plant_order po','o.order_id=po.order_id','left');
   $ci->db->join('plant p','po.plant_id=p.plant_id','left');
   $ci->db->join('location l','p.location_id=l.location_id or n.location_id=l.location_id ','left');
   $ci->db->where('id.invoice_id',$invoice_id);
   $res=$ci->db->get();
   $name=$res->row_array();
   //print_r($res->row_array());exit;
   return @$name['agency_name'].@$name['plant_name'].'['.@$name['distributor_code'].']'.'['.@$name['location_name'].']'; 
   
}
function get_plant_based_invoice($invoice_id)
{
   $ci=  & get_instance();
   $ci->db->select('l.name as location_name,p.name as plant_name');
   $ci->db->from('invoice_do id');
   $ci->db->join('do_order d','id.do_id=d.do_id','left');
   $ci->db->join('order o','d.order_id=o.order_id','left');
   $ci->db->join('plant_order po','o.order_id=po.order_id','left');
   $ci->db->join('plant p','po.plant_id=p.plant_id','left');
   $ci->db->join('location l','p.location_id=l.location_id','left');
   $ci->db->where('id.invoice_id',$invoice_id);
   $res=$ci->db->get();
   $name=$res->row_array();
   //print_r($res->row_array());exit;
   return $name['plant_name'].'['.$name['location_name'].']'; 
}
function get_raithu_bazar_id()
{
   return 5;
}
function get_headoffice_block_id()
{
	return 1;
}

function get_regular_price_id()
{
   return 1;
}