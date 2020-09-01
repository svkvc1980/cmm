<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by Roopa on 1st march 2017 9:00AM
*/
class Settings_m extends CI_Model {
	/*settings results
    Author:Roopa
    Time: 11.26AM 01-03-2017 */
	public function settings_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('p.*');
		$this->db->from('preference p');
		if($search_params['name']!='')
			$this->db->like('p.name',$search_params['name']);
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
	/*settings number of rows
    Author:Roopa
    Time: 11.26AM 01-03-2017 */
	public function settings_total_num_rows($search_params)
	{		
		$this->db->select('p.*');
		$this->db->from('preference p');
		if($search_params['name']!='')
			$this->db->like('p.name',$search_params['name']);
		$res = $this->db->get();
		return $res->num_rows();
	}
	 public function is_nameExist($name,$preference_id,$section)
    {       
        $this->db->select();
        $this->db->from('preference');
        $this->db->where('name',$name);
        $this->db->where('section',$section);
        if($preference_id!=0)
        {
            $this->db->where_not_in('preference_id',$preference_id);
        }
        $query = $this->db->get();        
        return ($query->num_rows()>0)?1:0;
    }	
}