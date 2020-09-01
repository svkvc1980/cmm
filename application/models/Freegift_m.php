<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Freegift_m extends CI_Model {

//starting of Bank crud methods//
	public function freegift_results($current_offset, $per_page, $searchParams)
	{
		
		$this->db->select('fg.*');
		$this->db->from('free_gift fg');
		if($searchParams['name']!='')
			$this->db->like('fg.name',$searchParams['name']);
		$this->db->limit($per_page, $current_offset);
		$this->db->order_by('fg.free_gift_id','DESC');
		$res = $this->db->get();
		return $res->result_array();
	}
	
	public function freegift_total_num_rows($searchParams)
	{
		
		$this->db->select('fg.*');
		$this->db->from('free_gift fg');
		if($searchParams['name']!='')
			$this->db->like('fg.name',$searchParams['name']);
		$res = $this->db->get();
		return $res->num_rows();
	}
	
	public function freegift_details($searchParams)
	{
		
		$this->db->select('fg.*');
		$this->db->from('free_gift fg');
		if($searchParams['name']!='')
			$this->db->like('fg.name',$searchParams['name']);
		$this->db->order_by('fg.free_gift_id','DESC');
		$res = $this->db->get();
		return $res->result_array();
	}


//uniqueness of Free Gift
	public function is_freegiftExist($name,$freegift_id)
    {       
        $this->db->select();
        $this->db->from('free_gift fg');
        $this->db->where('fg.name',$name);
        if($freegift_id!=0)
        {
            $this->db->where_not_in('fg.free_gift_id',$freegift_id);
        }
        $query = $this->db->get();
        return ($query->num_rows()>0)?1:0;
    }
//ending of Free Gift uniqueness methods//
}

