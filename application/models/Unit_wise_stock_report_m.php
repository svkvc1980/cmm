<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unit_wise_stock_report_m extends CI_Model
{
	public function get_products()
	{
		$this->db->select('p.product_id as product_id,p.short_name as short_name,l.loose_oil_id as loose_oil_id,l.name as loose_oil_name,p.oil_weight as oil_weight,p.items_per_carton as items_per_carton');
		$this->db->from('product p');
		$this->db->join('product_capacity pc','p.product_id=pc.product_id');
		$this->db->join('capacity c','pc.capacity_id=c.capacity_id');
		$this->db->join('loose_oil l','p.loose_oil_id=l.loose_oil_id');
		$this->db->where('p.status',1);
		$this->db->order_by('l.rank ASC,c.rank ASC');
		$res=$this->db->get();
		return $res->result_array();
	}
	/**
	* get all products latest price based on price type and unit
	* author: prasad , created on: 8th feb 2017 12:39 PM, updated on: --
	* params: $distributor_type(int),$plant_id(int)
	* return: $product_latest_rate(array)
	**/
	public function get_all_products_latest_price_plant($distributor_type,$plant_id)
	{
		$query=	'SELECT * FROM product_price p WHERE p.start_date= (select max(p1.start_date) as start_date from product_price p1 where p1.product_id=p.product_id and p1.plant_id=p.plant_id and p1.price_type_id=p.price_type_id and p1.start_date <= "'.date('Y-m-d').'") and p.plant_id = "'.$plant_id.'" and p.price_type_id = "'.$distributor_type.'"';
	    $res=$this->db->query($query);
	    $product_latest_rates = array();
	   // $product_latest_details=array();
	    if($res->num_rows()>0)
	    {
	    	$results = $res->result_array();
	    	foreach ($results as $row) 
	    	{
	    		$product_latest_rates[$row['product_id']] = $row;
	    		//$product_latest_details[$row['product_id']] = $row;
	    	}
	    }
	    return $product_latest_rates;
	}
}