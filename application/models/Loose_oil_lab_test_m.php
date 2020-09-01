<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by maruthi on 15th Dec 2016 9:00AM
*/

class Loose_oil_lab_test_m extends CI_Model {

	public function loose_oil_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('lo.*');
		$this->db->from('loose_oil lo');
		if($search_params['loose_oil_id']!='')
			$this->db->like('lo.loose_oil_id',$search_params['loose_oil_id']);
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
	
	public function loose_oil_total_num_rows($search_params)
	{		
		$this->db->select('lo.*');
		$this->db->from('loose_oil lo');
		if($search_params['loose_oil_id']!='')
			$this->db->like('lo.loose_oil_id',$search_params['loose_oil_id']);		
		$res = $this->db->get();
		return $res->num_rows();
	}
	public function get_test_groups($loose_oil_id)
	{
		$this->db->select('tg.test_group_id, tg.name as group_name,lt.name as loose_oil_test');
		$this->db->from('loose_oil_test lt');
		$this->db->join('test_group tg', 'tg.test_group_id = lt.test_group_id');
		$this->db->where('loose_oil_id',$loose_oil_id);
		$this->db->order_by('lt.order');
		$this->db->group_by('tg.test_group_id');
		$res=$this->db->get();
		return $res->result_array();
	}

	public function get_tests($loose_oil_id,$test_group_id)
	{
		$this->db->select('lt.*, u.name as unit');
		$this->db->from('loose_oil_test lt');
		$this->db->join('test_unit u','u.test_unit_id=lt.test_unit_id','left');
		$this->db->where('lt.loose_oil_id',$loose_oil_id);
		$this->db->where('lt.test_group_id',$test_group_id);
		$this->db->order_by('lt.order');
		$res=$this->db->get();
		//echo $this->db->last_query();exit;
		return $res->result_array();
	}
	public function get_range_dropdown_options($test_id)
	{
		$this->db->select('lt.*,to.*,rt.*');
		$this->db->from('loose_oil_test lt');
		$this->db->join('test_option to','to.test_id=lt.test_id');
		$this->db->join('range_type rt','rt.range_type_id=lt.range_type_id');
		$this->db->where('lt.test_id',$test_id);
		$this->db->where('to.status',1);
		$res=$this->db->get();
		return $res->result_array();
	}
	
}