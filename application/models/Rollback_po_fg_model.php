<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rollback_po_fg_model extends CI_Model {

	public function get_po_fg_data($po_number)
	{
		$this->db->select('po.*,f.name as fg_name,s.agency_name as supplier_name,s.supplier_code');
		$this->db->from('po_free_gift po');
		$this->db->join('free_gift f','f.free_gift_id=po.free_gift_id');
		$this->db->join('supplier s','s.supplier_id=po.supplier_id');
		$this->db->where('po.po_number',$po_number);
		$this->db->order_by('po.po_fg_id DESC');
		$this->db->limit('1');
		$res=$this->db->get();
		
		return $res->row_array();
	}

	public function get_ops()
	{
		$this->db->select('p.plant_id,p.name as plant_name');
        $this->db->from('plant p');
        $this->db->join('plant_block pb','p.plant_id=pb.plant_id');
        $this->db->where('pb.block_id',2);
        $res = $this->db->get();
        return $res->result_array();
	}
	public function get_free_gifts()
	{
		$this->db->select('*');
		$this->db->from('free_gift');
		$this->db->where('status',1);
		$res=$this->db->get();
		return $res->result_array();

	}
}