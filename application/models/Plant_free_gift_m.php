<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by Roopa on 2st march 2017 2:00PM
*/
class Plant_free_gift_m extends CI_Model {
	/*plant free gift results
    Author:Roopa
    Time: 06.26PM 02-03-2017 */
	public function plant_free_gift_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('pfg.*,p.name as plant_name,fg.name as free_gift_name');
		$this->db->from('plant_free_gift pfg');
		$this->db->join('plant p','p.plant_id=pfg.plant_id');
		$this->db->join('free_gift fg','fg.free_gift_id=pfg.free_gift_id');
		if($search_params['plant_id']!='')
			$this->db->like('p.plant_id',$search_params['plant_id']);
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
	/*plant free gift number of rows
    Author:Roopa
    Time: 06.26PM 02-03-2017 */
	public function plant_free_gift_total_num_rows($search_params)
	{		
		$this->db->select('pfg.*,p.name as plant_name,fg.name as free_gift_name');
		$this->db->from('plant_free_gift pfg');
		$this->db->join('plant p','p.plant_id=pfg.plant_id');
		$this->db->join('free_gift fg','fg.free_gift_id=pfg.free_gift_id');
		if($search_params['plant_id']!='')
			$this->db->like('p.plant_id',$search_params['plant_id']);
		$res = $this->db->get();
		return $res->num_rows();
	}
	public function plant_freegift_details($search_params)
	{		
		$this->db->select('pfg.*,p.name as plant_name,fg.name as free_gift_name');
		$this->db->from('plant_free_gift pfg');
		$this->db->join('plant p','p.plant_id=pfg.plant_id');
		$this->db->join('free_gift fg','fg.free_gift_id=pfg.free_gift_id');
		if($search_params['plant_id']!='')
			$this->db->like('p.plant_id',$search_params['plant_id']);
		$res = $this->db->get();
		return $res->result_array();
	}		
}