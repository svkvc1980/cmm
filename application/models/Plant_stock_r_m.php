<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by nagajuna on 1st MAR 2017 1:45 PM
*/

class Plant_stock_r_m extends CI_Model {
	
	

	public function get_loose_oil($product_id)
	{
		$this->db->select('product_id,loose_oil_id');
		$this->db->from('product');
		$this->db->where('status',1);
		$this->db->where_in('product_id',$product_id);
		
		$this->db->group_by('loose_oil_id');
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_product_results($loose_oil_id,$plant_id)
	{		
		$this->db->select('pp.product_id,pp.quantity,pp.loose_pouches');
		$this->db->from('plant_product pp');	
		$this->db->where('pp.plant_id',$plant_id);
		$res = $this->db->get();
		$product_data_arr[] =  $res->result_array();

		foreach ($product_data_arr as $key => $value) 
		{
			foreach($value as $row)
			{

				$this->db->select('p.*,(((p.items_per_carton)*"'.$row['quantity'].'")+"'.$row['loose_pouches'].'") as carton_items');
				$this->db->from('product p');
				$this->db->where_in('product_id',$row['product_id']);
				$this->db->where('loose_oil_id',$loose_oil_id);
				$res = $this->db->get();
				$result[] = $res->result_array();
			}
			return $result;
		}
		
	}

	public function get_product_latest_price($price_type_id)
	{
		$query=	'SELECT * FROM product_price p WHERE p.start_date= (select max(p1.start_date) as start_date from product_price p1 where p1.product_id=p.product_id  and p1.price_type_id=p.price_type_id and p1.start_date <= "'.date('Y-m-d').'")  and p.price_type_id = "'.$price_type_id.'"';
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