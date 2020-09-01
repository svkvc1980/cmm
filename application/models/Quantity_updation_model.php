<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quantity_updation_model extends CI_Model {

	public function product_total_rows($searchParams)
	{		
		$this->db->select('p.*,lp.*');
		$this->db->from('product p');
		$this->db->join('loose_oil_product lp','p.loose_oil_product_id=lp.loose_oil_product_id');
		if($searchParams['product_name']!='')
			$this->db->where('p.product_name',$searchParams['product_name']);
		$this->db->group_by('p.product_id');
		$res = $this->db->get();
		return $res->num_rows();
	}

	public function product_results($searchParams, $per_page, $current_offset)
	{		
		$this->db->select('p.product_id as product_id, p.product_name as product_name, p.no_of_item_per_carton as no_of_item_per_carton, 
			p.status as status, lp.loose_oil_product_name as loose_oil_product_name, lp.status as statuss');
		$this->db->from('product p');
		$this->db->join('loose_oil_product lp','p.loose_oil_product_id=lp.loose_oil_product_id');
		if($searchParams['product_name']!='')
			$this->db->where('p.product_name',$searchParams['product_name']);
		$this->db->limit($per_page, $current_offset);
		$this->db->group_by('p.product_id');
		$res = $this->db->get();
		return $res->result_array();
	}

	public function product_details($searchParams)
	{		
		$this->db->select('p.*,lp.*');
		$this->db->from('product p');
		$this->db->join('loose_oil_product lp','p.loose_oil_product_id=lp.loose_oil_product_id');
		$this->db->group_by('p.product_id');
		$this->db->where('p.status',1);
		$res = $this->db->get();
		return $res->result_array();
	}

	
	public function get_products() 
	{
		$this->db->from('loose_oil');
		$this->db->where('status',1);
		$res=$this->db->get();
		return $res->result_array();
	}

	/**
	* get all products based on loose oil type
	* */
	public function get_sub_products_by_products($loose_oil_id)
	{
		$this->db->from('product');
		$this->db->where('loose_oil_id',$loose_oil_id);
		$this->db->where('status',1);
		$res=$this->db->get();
		return $res->result_array();
	}

   
}