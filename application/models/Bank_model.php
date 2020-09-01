<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bank_model extends CI_Model {

//starting of Bank crud methods//
	public function bank_results($current_offset, $per_page, $searchParams)
	{
		
		$this->db->select('b.*');
		$this->db->from('bank b');
		if($searchParams['bank_name']!='')
			$this->db->like('b.bank_name',$searchParams['bank_name']);
		$this->db->limit($per_page, $current_offset);
		$this->db->order_by('b.bank_id','DESC');
		$res = $this->db->get();
		return $res->result_array();
	}
	
	public function bank_total_num_rows($searchParams)
	{
		
		$this->db->select('b.*');
		$this->db->from('bank b');
		if($searchParams['bank_name']!='')
			$this->db->like('b.bank_name',$searchParams['bank_name']);
		$res = $this->db->get();
		return $res->num_rows();
	}
	
	public function bank_details($searchParams)
	{
		
		$this->db->select('b.*');
		$this->db->from('bank b');
		if($searchParams['bank_name']!='')
			$this->db->like('b.bank_name',$searchParams['bank_name']);
		$this->db->order_by('b.bank_id','DESC');
		$res = $this->db->get();
		return $res->result_array();
	}


//uniqueness of bank name
	public function is_bankExist($bank_name,$bank_id)
    {       
        $this->db->select();
        $this->db->from('bank b');
        $this->db->where('b.name',$bank_name);
        if($bank_id!=0)
        {
            $this->db->where_not_in('b.bank_id',$bank_id);
        }
        $query = $this->db->get();
        return ($query->num_rows()>0)?1:0;
    }
//ending of Bank Name uniqueness methods//
}

