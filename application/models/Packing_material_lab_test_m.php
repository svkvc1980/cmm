<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by maruthi on 15th Dec 2016 9:00AM
*/

class Packing_material_lab_test_m extends CI_Model {

	public function packing_material_category_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('pmc.*');
		$this->db->from('packing_material_category pmc');
		if($search_params['pm_category_id']!='')
			$this->db->like('pmc.pm_category_id',$search_params['pm_category_id']);
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
	
	public function packing_material_category_total_num_rows($search_params)
	{		
		$this->db->select('pmc.*');
		$this->db->from('packing_material_category pmc');
		if($search_params['pm_category_id']!='')
			$this->db->like('pmc.pm_category_id',$search_params['pm_category_id']);
		$res = $this->db->get();
		return $res->num_rows();
	}
	

	public function get_tests($pm_category_id)
	{
		$this->db->select('pmt.*,u.name as unit');
		$this->db->from('packing_material_test pmt');
		$this->db->join('test_unit u','u.test_unit_id=pmt.test_unit_id','left');
		$this->db->where('pmt.pm_category_id',$pm_category_id);
		$this->db->where('pmt.status',1);
		$res=$this->db->get();
		return $res->result_array();
	}

	public function get_range_dropdown_options($pm_test_id)
	{
		$this->db->select('pmto.*,pmt.*');
		$this->db->from('pm_test_option pmto');
		$this->db->join('packing_material_test pmt','pmt.pm_test_id = pmto.pm_test_id');		
		$this->db->where('pmto.pm_test_id',$pm_test_id);
		$this->db->where('pmto.status',1);
		$res=$this->db->get();
		return $res->result_array();
	}
	
}