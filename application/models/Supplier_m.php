<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * created by Roopa on 12th jan 2017 9:00AM
*/

class Supplier_m extends CI_Model {

	public function supplier_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('b.*,st.name as supplier_type');
		$this->db->from('supplier b');
		$this->db->join('supplier_type st','st.type_id = b.type_id');
		if($search_params['supplier_code']!='')
			$this->db->like('b.supplier_code',$search_params['supplier_code']);
		if($search_params['agency_name']!='')
			$this->db->like('b.agency_name',$search_params['agency_name']);
		$this->db->where('st.status',1);
		$this->db->order_by('CAST(b.supplier_code AS unsigned) ASC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}	
	public function supplier_total_num_rows($search_params)
	{		
		$this->db->select('b.*');
		$this->db->from('supplier b');
		$this->db->join('supplier_type st','st.type_id = b.type_id');
		if($search_params['supplier_code']!='')
			$this->db->like('b.supplier_code',$search_params['supplier_code']);
		if($search_params['agency_name']!='')
			$this->db->like('b.agency_name',$search_params['agency_name']);
		$this->db->where('st.status',1);
		$res = $this->db->get();
		return $res->num_rows();
	}	
	public function supplier_details($search_params)
	{		
		$this->db->select('b.*');
		$this->db->from('supplier b');
		$this->db->join('supplier_type st','st.type_id = b.type_id');
		if($search_params['supplier_code']!='')
			$this->db->like('b.supplier_code',$search_params['supplier_code']);
		if($search_params['agency_name']!='')
			$this->db->like('b.agency_name',$search_params['agency_name']);
		$this->db->where('st.status',1);
		$res = $this->db->get();
		return $res->result_array();
	}
	
}