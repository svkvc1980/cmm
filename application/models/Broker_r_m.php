<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by mastan on 10th Mar 2017
*/

class Broker_r_m extends CI_Model {

	public function broker_total_num_rows($search_params)
    {       
        $this->db->select('b.*, l.name as location');
		$this->db->from('broker b');
		$this->db->join('location l', 'l.location_id = b.location_id');
		if($search_params['broker_code']!='')
			$this->db->like('b.broker_code',$search_params['broker_code']);
		if($search_params['concerned_person']!='')
			$this->db->like('b.concerned_person',$search_params['concerned_person']);
		if($search_params['agency_name']!='')
			$this->db->like('b.agency_name',$search_params['agency_name']);
		if($search_params['status']!='')
            $this->db->like('b.status',$search_params['status']);
        $this->db->order_by('CAST(b.broker_code as unsigned) ASC');
        $res = $this->db->get();
        return $res->num_rows();
    }
    
    public function broker_results($search_params,$per_page,$current_offset)
    {       
        $this->db->select('b.*, l.name as location');
		$this->db->from('broker b');
		$this->db->join('location l', 'l.location_id = b.location_id');
		if($search_params['broker_code']!='')
			$this->db->like('b.broker_code',$search_params['broker_code']);
		if($search_params['concerned_person']!='')
			$this->db->like('b.concerned_person',$search_params['concerned_person']);
		if($search_params['agency_name']!='')
			$this->db->like('b.agency_name',$search_params['agency_name']);
		if($search_params['status']!='')
            $this->db->like('b.status',$search_params['status']);
        $this->db->order_by('CAST(b.broker_code as unsigned) ASC');
        $this->db->limit($per_page, $current_offset);
        $res = $this->db->get();
        return $res->result_array();
    }

	public function broker_report_results($search_params)
	{
		$this->db->select('b.*, l.name as location');
		$this->db->from('broker b');
		$this->db->join('location l', 'l.location_id = b.location_id');
		if($search_params['broker_code']!='')
			$this->db->like('b.broker_code',$search_params['broker_code']);
		if($search_params['concerned_person']!='')
			$this->db->like('b.concerned_person',$search_params['concerned_person']);
		if($search_params['agency_name']!='')
			$this->db->like('b.agency_name',$search_params['agency_name']);
		if($search_params['status']!='')
            $this->db->like('b.status',$search_params['status']);
        $this->db->order_by('CAST(b.broker_code as unsigned) ASC');
		$res = $this->db->get();		
		return $res->result_array();
	}
}