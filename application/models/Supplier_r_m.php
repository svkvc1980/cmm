<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by mastan on 10th Mar 2017
*/

class Supplier_r_m extends CI_Model {

	public function supplier_total_num_rows($search_params)
    {       
        $this->db->select('s.*, l.name as location, st.name as type');
		$this->db->from('supplier s');
		$this->db->join('location l', 'l.location_id = s.location_id','left');
		$this->db->join('supplier_type st', 'st.type_id = s.type_id');
		if($search_params['status']!='')
			$this->db->where('s.status',$search_params['status']);
		if($search_params['supplier_code']!='')
			$this->db->like('s.supplier_code',$search_params['supplier_code']);
		if($search_params['type_id']!='')
			$this->db->where('s.type_id',$search_params['type_id']);
		if($search_params['concerned_person']!='')
			$this->db->like('s.concerned_person',$search_params['concerned_person']);
		if($search_params['agency_name']!='')
			$this->db->like('s.agency_name',$search_params['agency_name']);
		$this->db->order_by('CAST(s.supplier_code as unsigned) ASC');
        $res = $this->db->get();
        return $res->num_rows();
    }
    
    public function supplier_results($search_params,$per_page,$current_offset)
    {       
        $this->db->select('s.*, l.name as location, st.name as type');
		$this->db->from('supplier s');
		$this->db->join('location l', 'l.location_id = s.location_id','left');
		$this->db->join('supplier_type st', 'st.type_id = s.type_id');
		if($search_params['status']!='')
			$this->db->where('s.status',$search_params['status']);
		if($search_params['supplier_code']!='')
			$this->db->like('s.supplier_code',$search_params['supplier_code']);
		if($search_params['type_id']!='')
			$this->db->where('s.type_id',$search_params['type_id']);
		if($search_params['concerned_person']!='')
			$this->db->like('s.concerned_person',$search_params['concerned_person']);
		if($search_params['agency_name']!='')
			$this->db->like('s.agency_name',$search_params['agency_name']);
		$this->db->order_by('CAST(s.supplier_code as unsigned) ASC');
        $this->db->limit($per_page, $current_offset);
        $res = $this->db->get();
        return $res->result_array();
    }

	public function supplier_report_results($search_params)
	{
		$this->db->select('s.*, l.name as location, st.name as type');
		$this->db->from('supplier s');
		$this->db->join('location l', 'l.location_id = s.location_id','left');
		$this->db->join('supplier_type st', 'st.type_id = s.type_id');
		if($search_params['status']!='')
			$this->db->where('s.status',$search_params['status']);
		if($search_params['supplier_code']!='')
			$this->db->like('s.supplier_code',$search_params['supplier_code']);
		if($search_params['type_id']!='')
			$this->db->where('s.type_id',$search_params['type_id']);
		if($search_params['concerned_person']!='')
			$this->db->like('s.concerned_person',$search_params['concerned_person']);
		if($search_params['agency_name']!='')
			$this->db->like('s.agency_name',$search_params['agency_name']);
		$this->db->order_by('CAST(s.supplier_code as unsigned) ASC');
		$res = $this->db->get();		
		return $res->result_array();
	}

	
}