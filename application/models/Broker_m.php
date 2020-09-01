<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by maruthi on 15th Dec 2016 9:00AM
*/

class Broker_m extends CI_Model {

	public function broker_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('b.*');
		$this->db->from('broker b');
		if($search_params['broker_code']!='')
			$this->db->like('b.broker_code',$search_params['broker_code']);
		if($search_params['agency_name']!='')
			$this->db->like('b.agency_name',$search_params['agency_name']);
		$this->db->order_by('CAST(b.broker_code AS unsigned) ASC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
	
	public function broker_total_num_rows($search_params)
	{		
		$this->db->select();
		$this->db->from('broker b');
		if($search_params['broker_code']!='')
			$this->db->like('b.broker_code',$search_params['broker_code']);
		if($search_params['agency_name']!='')
			$this->db->like('b.agency_name',$search_params['agency_name']);
		$res = $this->db->get();
		return $res->num_rows();
	}
	
	public function broker_details($search_params)
	{		
		$this->db->select('b.*');
		$this->db->from('broker b');
		if($search_params['broker_code']!='')
			$this->db->like('b.broker_code',$search_params['broker_code']);
		if($search_params['agency_name']!='')
			$this->db->like('b.agency_name',$search_params['agency_name']);
		$res = $this->db->get();
		return $res->result_array();
	}
	
}