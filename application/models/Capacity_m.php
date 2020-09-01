<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by Roopa on 24th feb 2017 9:00AM
*/

class Capacity_m extends CI_Model {
	/*Capacity results
    Author:Roopa
    Time: 11.26AM 24-02-2017 */
	public function capacity_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('c.*,u.name as unit_name');
		$this->db->from('capacity c');
                $this->db->join('unit u','c.unit_id=u.unit_id');                
		if($search_params['name']!='')
			$this->db->like('c.name',$search_params['name']);
                if($search_params['unit_id']!='')
			$this->db->like('c.unit_id',$search_params['unit_id']);
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
	/*Capacity number of rows
    Author:Roopa
    Time: 11.26AM 24-02-2017 */
	public function capacity_total_num_rows($search_params)
	{		
		$this->db->select('c.*,u.name as unit_name');
		$this->db->from('capacity c');
                $this->db->join('unit u','c.unit_id=u.unit_id');
		if($search_params['name']!='')
			$this->db->like('c.name',$search_params['name']);
		if($search_params['unit_id']!='')
			$this->db->like('c.unit_id',$search_params['unit_id']);
		$res = $this->db->get();
		return $res->num_rows();
	}
	/*Capacity details for download...
    Author:Roopa
    Time: 11.26AM 24-02-2017 */
	public function capacity_details($search_params)
	{		
		$this->db->select('c.*,u.name as unit_name');
		$this->db->from('capacity c');
                $this->db->join('unit u','c.unit_id=u.unit_id');
		if($search_params['name']!='')
			$this->db->like('c.name',$search_params['name']);
		if($search_params['unit_id']!='')
			$this->db->like('c.unit_id',$search_params['unit_id']);
		$res = $this->db->get();		
		return $res->result_array();
	}
    public function is_nameExist($name,$capacity_id,$unit_id)
    {       
        $this->db->select();
        $this->db->from('capacity');
        $this->db->where('name',$name);
        $this->db->where('unit_id',$unit_id);
        if($capacity_id!=0)
        {
            $this->db->where_not_in('capacity_id',$capacity_id);
        }
        $query = $this->db->get();        
        return ($query->num_rows()>0)?1:0;
    }
}