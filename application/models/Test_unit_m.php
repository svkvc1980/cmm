<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_unit_m extends CI_Model {

//starting of Test Unit crud methods//
	public function unit_results($current_offset, $per_page, $searchParams)
	{
		
		$this->db->select('tu.*');
		$this->db->from('test_unit tu');
		if($searchParams['name']!='')
			$this->db->like('tu.name',$searchParams['name']);
		$this->db->limit($per_page, $current_offset);
		$this->db->order_by('tu.test_unit_id','DESC');
		$res = $this->db->get();
		return $res->result_array();
	}
	
	public function unit_total_num_rows($searchParams)
	{
		
		$this->db->select('tu.*');
		$this->db->from('test_unit tu');
		if($searchParams['name']!='')
			$this->db->like('tu.name',$searchParams['name']);
		$res = $this->db->get();
		return $res->num_rows();
	}
	
	public function test_unit_details($searchParams)
	{
		
		$this->db->select('tu.*');
		$this->db->from('test_unit tu');
		if($searchParams['name']!='')
			$this->db->like('tu.name',$searchParams['name']);
		$this->db->order_by('tu.test_unit_id','DESC');
		$res = $this->db->get();
		return $res->result_array();
	}

//uniqueness of Test Unit 
	public function is_test_unitExist($name,$test_unit_id)
    {
        $this->db->select();
        $this->db->from('test_unit tu');
        $this->db->where('tu.name',$name);
        if($test_unit_id!=0)
        {
            $this->db->where_not_in('tu.test_unit_id',$test_unit_id);
        }
        $query = $this->db->get();
        return ($query->num_rows()>0)?1:0;
    }
//ending of Test Unit uniqueness methods//
}

