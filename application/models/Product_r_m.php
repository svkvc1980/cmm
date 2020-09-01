<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by Nagarjuna on 10th march 2017 12:31 PM
*/

class Product_r_m extends CI_Model
{
	public function get_products_list($status)
	{	
		$this->db->select('p.*,l.name as loose_oil_name,ppt.name as packing_type');
		$this->db->from('product p');
		$this->db->join('loose_oil l','l.loose_oil_id = p.loose_oil_id');
		$this->db->join('product_capacity pc','pc.product_id=p.product_id');
		$this->db->join('capacity c','c.capacity_id=pc.capacity_id');
		$this->db->join('product_packing_type ppt','ppt.product_packing_type_id = p.product_packing_type_id','left');
		$this->db->where('p.status',$status);
		$this->db->order_by('l.rank ASC','c.rank ASC');
		$res = $this->db->get();
		return $res->result_array();
	}
}