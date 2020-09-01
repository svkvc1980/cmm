<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by maruthi on 15th Dec 2016 9:00AM
*/

class Icds_m extends CI_Model {

	public function icds_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('i.*');
		$this->db->from('icds i');
		if($search_params['icds_code']!='')
			$this->db->like('i.icds_code',$search_params['icds_code']);
		if($search_params['icds_name']!='')
			$this->db->like('i.icds_name',$search_params['icds_name']);
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
	
	public function icds_total_num_rows($search_params)
	{		
		$this->db->select('i.*');
		$this->db->from('icds i');
		if($search_params['icds_code']!='')
			$this->db->like('i.icds_code',$search_params['icds_code']);
		if($search_params['icds_name']!='')
			$this->db->like('i.icds_name',$search_params['icds_name']);
		$res = $this->db->get();
		return $res->num_rows();
	}
	
	public function icds_details($search_params)
	{		
		$this->db->select('i.*');
		$this->db->from('icds i');
		if($search_params['icds_code']!='')
			$this->db->like('i.icds_code',$search_params['icds_code']);
		if($search_params['icds_name']!='')
			$this->db->like('i.icds_name',$search_params['icds_name']);
		$res = $this->db->get();
		return $res->result_array();
	}
	
}