<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by Roopa on 11th Dec 2016 9:00AM
*/

class Loose_oil_m extends CI_Model {

	public function loose_oil_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('l.*');
		$this->db->from('loose_oil l');
		if($search_params['name']!='')
			$this->db->like('l.name',$search_params['name']);
                if($search_params['short_name']!='')
			$this->db->like('l.short_name',$search_params['short_name']);
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}	
	public function loose_oil_total_num_rows($search_params)
	{		
		$this->db->select('l.*');
		$this->db->from('loose_oil l');
		if($search_params['name']!='')
			$this->db->like('l.name',$search_params['name']);
		if($search_params['short_name']!='')
			$this->db->like('l.short_name',$search_params['short_name']);
		$res = $this->db->get();
		return $res->num_rows();
	}	
	public function loose_oil_details($search_params)
	{		
		$this->db->select('l.*');
		$this->db->from('loose_oil l');
		if($search_params['name']!='')
			$this->db->like('l.name',$search_params['name']);
		if($search_params['short_name']!='')
			$this->db->like('l.short_name',$search_params['short_name']);
		$res = $this->db->get();
		
		return $res->result_array();
	}
    public function is_nameExist($name,$loose_oil_id)
    {       
        $this->db->select();
        $this->db->from('loose_oil');
        $this->db->where('name',$name);
        if($loose_oil_id!=0)
        {
            $this->db->where_not_in('loose_oil_id',$loose_oil_id);
        }
        $query = $this->db->get();
        return ($query->num_rows()>0)?1:0;
    }
	
}