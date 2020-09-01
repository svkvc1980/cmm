<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rollback_po_pm_model extends CI_Model {

	public function get_po_pm_data($po_number)
	{
		$this->db->select('po.*,p.name as packing_name,pt.name as po_type,s.agency_name as supplier_name,s.supplier_code,pl.plant_id,pl.name as plant_name');
		$this->db->from('po_pm po');
		$this->db->join('packing_material p','p.pm_id=po.pm_id');
		$this->db->join('po_type pt','pt.po_type_id=po.po_type_id');
		$this->db->join('supplier s','s.supplier_id=po.supplier_id');
		$this->db->join('plant pl','po.plant_id=pl.plant_id');
		$this->db->where('po.po_number',$po_number);
		$this->db->order_by('po.po_pm_id DESC');
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
}