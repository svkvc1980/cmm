<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by maruthi on 15th Dec 2016 9:00AM
*/

class Loose_oil_po_m extends CI_Model {

	public function loose_oil_po_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('l.*');
		$this->db->from('loose_oil_po l');
		if($search_params['name']!='')
			$this->db->like('l.name',$search_params['name']);
		if($search_params['po_number']!='')
			$this->db->like('l.po_number',$search_params['po_number']);
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
	
	public function loose_oil_po_total_num_rows($search_params)
	{		
		$this->db->select('l.*');
		$this->db->from('loose_oil_po l');
		if($search_params['name']!='')
			$this->db->like('l.name',$search_params['name']);
		if($search_params['po_number']!='')
			$this->db->like('l.po_number',$search_params['po_number']);
		$res = $this->db->get();
		return $res->num_rows();
	}
	
	public function loose_oil_po_details($search_params)
	{		
		$this->db->select('l.*');
		$this->db->from('loose_oil_po l');
		if($search_params['name']!='')
			$this->db->like('l.name',$search_params['name']);
		if($search_params['po_number']!='')
			$this->db->like('l.po_number',$search_params['po_number']);
		$res = $this->db->get();
		
		return $res->result_array();
	}

        function get_broker()
        {
            $this->db->select('*');
            $this->db->from('broker');
            $res = $this->db->get();
            return $res->result_array();
        } 

         function get_supplier()
        {
            $this->db->select('*');
            $this->db->from('supplier');
            $res = $this->db->get();
            return $res->result_array();
        } 
	
}