<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Freegift_scheme_m extends CI_Model 
{
	public function freegift_scheme_total_num_rows($searchParams)
	{
		$this->db->select();
		$this->db->from('free_gift_scheme fgs');
		$this->db->join('scheme_type st','st.type_id = fgs.type_id');
		if($searchParams['scheme_name']!='')
			$this->db->like('fgs.name like "%'.$searchParams['scheme_name'].'%"');
		if($searchParams['type_id']!='')
			$this->db->where('fgs.type_id',$searchParams['type_id']);
		$this->db->where('st.status',1);
		$this->db->order_by('fgs.fg_scheme_id','DESC');
		$res = $this->db->get();
		return $res->num_rows();
	}

	public function freegift_scheme_results($current_offset, $per_page, $searchParams)
	{
		$this->db->select('fgs.*,st.name as scheme_type_name');
		$this->db->from('free_gift_scheme fgs');
		$this->db->join('scheme_type st','st.type_id = fgs.type_id');
		if($searchParams['scheme_name']!='')
			$this->db->like('fgs.name like "%'.$searchParams['scheme_name'].'%"');
		if($searchParams['type_id']!='')
			$this->db->where('fgs.type_id',$searchParams['type_id']);
		$this->db->where('st.status',1);
		$this->db->order_by('fgs.fg_scheme_id','DESC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_packed_product()
	{
		$this->db->select('p.product_id,p.name as product_name,c.name as capacity_name,u.name as unit_name');
		$this->db->from('product p');
		$this->db->join('product_capacity pc','pc.product_id = p.product_id');
		$this->db->join('capacity c','c.capacity_id = pc.capacity_id');
		$this->db->join('unit u','u.unit_id = c.unit_id');
		$res = $this->db->get();
		return $res->result_array();
	}
}