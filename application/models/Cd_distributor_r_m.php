<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cd_distributor_r_m extends CI_Model {
	
	public function get_active_distributor()
    {
    	$this->db->select('d.distributor_id,d.agency_name,d.distributor_code');
    	$this->db->from('distributor d');
    	$this->db->join('user u','u.user_id = d.user_id');
    	$this->db->where('u.status',1);
    	$this->db->order_by('CAST(d.distributor_code as unsigned) ASC');
    	$res = $this->db->get();
    	return $res->result_array();
    }

	public function get_dist_cd_list($search_params)
	{		
		$this->db->select('n.*,d.agency_name,d.distributor_code,d.distributor_place,cdp.name as purpose');
		$this->db->from('distributor_credit_debit_note n');
		$this->db->join('distributor d', 'd.distributor_id=n.distributor_id');
		$this->db->join('credit_debit_purpose cdp', 'n.purpose_id=cdp.purpose_id','left');
		if($search_params['distributor_id']!='')
			$this->db->where('n.distributor_id',$search_params['distributor_id']);
		if($search_params['from_date']!='')
			$this->db->where('n.on_date >=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('n.on_date <=',$search_params['to_date']);
		if($search_params['type_id']!='')
			$this->db->where('n.note_type',$search_params['type_id']);
		$res = $this->db->get();
		return $res->result_array();
	}

	//for xl download
	public function dist_cd_download($search_params)
	{
		$this->db->select('n.*,d.agency_name,d.distributor_code,d.distributor_place,cdp.name as purpose');
		$this->db->from('distributor_credit_debit_note n');
		$this->db->join('distributor d', 'd.distributor_id=n.distributor_id');
		$this->db->join('credit_debit_purpose cdp', 'n.purpose_id=cdp.purpose_id','left');
		if($search_params['distributor_id']!='')
			$this->db->where('n.distributor_id',$search_params['distributor_id']);
		if($search_params['from_date']!='')
			$this->db->where('n.on_date >=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('n.on_date <=',$search_params['to_date']);
		if($search_params['type_id']!='')
			$this->db->where('n.note_type',$search_params['type_id']);
		$res = $this->db->get();
		return $res->result_array();
	}
}