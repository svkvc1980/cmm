<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Unit_measure_m extends CI_Model {

	public function unit_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('u.*');
		$this->db->from('unit u');
		if($search_params['name']!='')
			$this->db->like('u.name',$search_params['name']);		
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
	
	public function unit_total_num_rows($search_params)
	{		
		$this->db->select('u.*');
		$this->db->from('unit u');
		if($search_params['name']!='')
			$this->db->like('u.name',$search_params['name']);			
		$res = $this->db->get();
		return $res->num_rows();
	}
	
	public function unit_details($search_params)
	{		
		$this->db->select('u.*');
		$this->db->from('unit u');
		if($search_params['name']!='')
			$this->db->like('u.name',$search_params['name']);		
		$res = $this->db->get();
		return $res->result_array();
	}
	
 public function is_unitExist($name,$unit_id)
    {       
        $this->db->select();
        $this->db->from('unit');
        $this->db->where('name',$name);
        if($unit_id!=0)
        {
            $this->db->where_not_in('unit_id',$unit_id);
        }
        $query = $this->db->get();
        return ($query->num_rows()>0)?1:0;
    }
}