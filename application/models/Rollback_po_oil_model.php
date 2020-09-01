<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rollback_po_oil_model extends CI_Model {

	
	public function get_po_oil_data($po_number)
	{
		$this->db->select('po.*,l.name as oil_name,pt.name as po_type,s.agency_name as supplier_name,b.agency_name as broker_name,p.name as plant_name');
		$this->db->from('po_oil po');
		$this->db->join('loose_oil l','l.loose_oil_id=po.loose_oil_id');
		$this->db->join('po_type pt','pt.po_type_id=po.po_type_id');
		$this->db->join('supplier s','s.supplier_id=po.supplier_id');
		$this->db->join('broker b','b.broker_id=po.broker_id');
		$this->db->join('plant p','p.plant_id=po.plant_id');
		$this->db->where('po.po_number',$po_number);
		$this->db->order_by('po.po_oil_id DESC');
		$this->db->limit(1);
		$res=$this->db->get();
		return $res->row_array();
	}

	public function get_block()
	{
		$this->db->select('p.*');
		$this->db->from('plant p');
		$this->db->join('plant_block pb','pb.plant_id=p.plant_id');
		$this->db->where('pb.block_id',2);
		$res=$this->db->get();
		return $res->result_array();
	}

}