<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by maruthi on 15th Dec 2016 9:00AM
*/

class Packing_material_m extends CI_Model {

	public function packing_material_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('p.*,pt.packing_type_name');
		$this->db->from('packing_material_product p');
		$this->db->join('packing_type pt','p.packing_type_id=pt.packing_type_id');
		if($search_params['packing_material_name']!='')
			$this->db->like('p.packing_material_name',$search_params['packing_material_name']);		
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
	
	public function packing_material_total_num_rows($search_params)
	{		
		$this->db->select('p.*,pt.packing_type_name');
		$this->db->from('packing_material_product p');
		$this->db->join('packing_type pt','p.packing_type_id=pt.packing_type_id');
		if($search_params['packing_material_name']!='')
			$this->db->like('p.packing_material_name',$search_params['packing_material_name']);		
		$res = $this->db->get();
		return $res->num_rows();
	}
	
	public function packing_material_details($search_params)
	{		
		$this->db->select('p.*,pt.packing_type_name');
		$this->db->from('packing_material_product p');
		$this->db->join('packing_type pt','p.packing_type_id=pt.packing_type_id');
		if($search_params['packing_material_name']!='')
			$this->db->like('p.packing_material_name',$search_params['packing_material_name']);		
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_packing_type()
	{
	  $this->db->select('*');
	  $this->db->from('packing_type');
	  $res = $this->db->get();
	  return $res->result_array();
	}
}
?>