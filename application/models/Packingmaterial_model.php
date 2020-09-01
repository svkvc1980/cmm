<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Packingmaterial_model extends CI_Model
 {

    //retriving data from broker table
    public function getbroker()
	{ 
		$this->db->select('broker_id,agency_name');
		$this->db->from('broker');
		$this->db->where('status',1);
		$res = $this->db->get();
        return $res->result_array();
    }

    //retriving data from supplier table
    public function getagency()
	{ 
		$this->db->select('supplier_id,agency_name');
		$this->db->from('supplier');
		$this->db->where('status',1);
        $this->db->where('supplier_type_id',2);
		$res = $this->db->get();
        return $res->result_array();
    }

    //retriving data from product table
    public function getpackingmaterial()
	{ 
		$this->db->select('pmp.packing_material_product_id,pmp.packing_material_name,pt.packing_type_name');
		$this->db->from('packing_material_product pmp');
		$this->db->join('packing_type pt','pt.packing_type_id = pmp.packing_type_id');
		$this->db->where('pmp.status',1);
		$res = $this->db->get();
        return $res->result_array();
    }

    //getting suppliers based on agency name
	public function get_supplier_based_on_agency($supplier_id)
	{
		$this->db->select('*');
		$this->db->from('supplier');
		$this->db->where('supplier_id',$supplier_id);
		$res = $this->db->get();
        return $res->row_array();  
    }
}