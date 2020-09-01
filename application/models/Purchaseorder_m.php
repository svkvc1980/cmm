<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Purchaseorder_m extends CI_Model
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
		$res = $this->db->get();
        return $res->result_array();
    }

    //retriving data from product table
    public function getproduct()
	{ 
		$this->db->select('product_id,product_name');
		$this->db->from('product');
		$this->db->where('status',1);
		$res = $this->db->get();
        return $res->result_array();
    }

    public function get_po_id()
    {
    	$this->db->select('max(po_id) as po_id');
    	$this->db->from('loose_oil_po');
    	$res= $this->db->get();
        return $res->row_array();
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

    //retriving data from product table
    public function getpackingmaterial()
    { 
        $this->db->select('packing_material_product_id,packing_material_name');
        $this->db->from('packing_material_product');
        $this->db->where('status',1);
        $res = $this->db->get();
        return $res->result_array();
    }
}