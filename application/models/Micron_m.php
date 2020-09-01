<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by maruthi on 15th Dec 2016 9:00AM
*/

class Micron_m extends CI_Model {

	public function micron_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('m.*');
		$this->db->from('micron m');
		if($search_params['name']!='')
			$this->db->like('m.name',$search_params['name']);
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
	
	public function micron_total_num_rows($search_params)
	{		
		$this->db->select('m.*');
		$this->db->from('micron m');
		if($search_params['name']!='')
			$this->db->like('m.name',$search_params['name']);
		$res = $this->db->get();
		return $res->num_rows();
	}
	
	public function micron_details($search_params)
	{		
		$this->db->select('m.*');
		$this->db->from('micron m');
		if($search_params['name']!='')
			$this->db->like('m.name',$search_params['name']);
		$res = $this->db->get();
		return $res->result_array();
	}
	public function is_nameExist($name,$micron_id)
    {       
        $this->db->select('m.*');
        $this->db->from('micron m');
        $this->db->where('name',$name);
        if($micron_id!=0)
        {
            $this->db->where_not_in('micron_id',$micron_id);
        }
        $query = $this->db->get();
        return ($query->num_rows()>0)?1:0;
    }
	
}