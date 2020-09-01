<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by maruthi on 15th Dec 2016 9:00AM
*/

class Loose_oil_product_m extends CI_Model {

	public function loose_oil_product_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('l.*');
		$this->db->from('loose_oil_product l');
		if($search_params['loose_oil_product_name']!='')
			$this->db->like('l.loose_oil_product_name',$search_params['loose_oil_product_name']);
		if($search_params['code']!='')
			$this->db->like('l.code',$search_params['v']);
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
	
	public function loose_oil_product_total_num_rows($search_params)
	{		
		$this->db->select('l.*');
		$this->db->from('loose_oil_product l');
		if($search_params['loose_oil_product_name']!='')
			$this->db->like('l.loose_oil_product_name',$search_params['loose_oil_product_name']);
		if($search_params['code']!='')
			$this->db->like('l.code',$search_params['code']);
		$res = $this->db->get();
		return $res->num_rows();
	}
	
	public function loose_oil_product_details($search_params)
	{		
		$this->db->select('l.*');
		$this->db->from('loose_oil_product l');
		if($search_params['loose_oil_product_name']!='')
			$this->db->like('l.loose_oil_product_name',$search_params['loose_oil_product_name']);
		if($search_params['code']!='')
			$this->db->like('l.code',$search_params['v']);
		$res = $this->db->get();
		
		return $res->result_array();
	}

    public function is_productExist($loose_oil_product_name,$loose_oil_product_id)
    {       
        $this->db->select();
        $this->db->from('loose_oil_product');
        $this->db->where('loose_oil_product_name',$loose_oil_product_name);
        if($loose_oil_product_id!=0)
        {
            $this->db->where_not_in('loose_oil_product_id',$loose_oil_product_id);
        }
        $query = $this->db->get();
        return ($query->num_rows()>0)?1:0;
    }
	
}