<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_m extends CI_Model {
	

	public function get_products()
	{
		$this->db->select('*');
		$this->db->from('loose_oil_product');
		$this->db->where('status',1);
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_sub_products_by_products($loose_oil_product_id)
	{
		//$this->db->select('p.*,lp.*');
		$query='select * from raitu_bazar_price as rb1 left join (select raitu_bazar_id from raitu_bazar_price group by product_id desc) rb2 on rb1.raitu_bazar_id=rb2.raitu_bazar_id left join product p on rb1.product_id=p.product_id where p.loose_oil_product_id="'.$loose_oil_product_id.'" order by rb1.date ';
		$res=$this->db->query($query);
		return $res->result_array();
	}

	public function update_price_list($dat)
	{
		$this->db->select('*');
		$this->db->from('raitu_bazar_price');
		$this->db->where('date',$dat['date']);
		$this->db->where('product_id',$dat['product_id']);
		$res=$this->db->get();
		$count =$res->num_rows();
		if($count<=0)
		{   //echo 'hi';
			$this->db->insert('raitu_bazar_price',$dat);
			return $this->db->insert_id();
		}
		else
		{   //echo 'hello';
			return 0;
		}
	}

	public function get_updated_price_list($rbp_id)
	{
		$this->db->select('p.product_name as product_name,rbp.rate as rate,lop.loose_oil_product_name as loose_oil_product_name');
		$this->db->from('raitu_bazar_price rbp');
		$this->db->join('product p','rbp.product_id=p.product_id');
		$this->db->join('loose_oil_product lop','p.loose_oil_product_id=lop.loose_oil_product_id');
		$this->db->where('rbp.raitu_bazar_id',$rbp_id);
		$res=$this->db->get();
		return $res->result_array();

	}

}