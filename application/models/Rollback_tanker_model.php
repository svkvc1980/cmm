<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rollback_tanker_model extends CI_Model {

	
	public function get_tanker_data($tanker_id)
	{
		$this->db->select('tr.tanker_in_number,tr.tanker_id,tr.party_name,tr.vehicle_number,tt.name as type_name,lo.name as oil_name,pm.name as pm_name,fg.name as fg_name,p.name as plant_name');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_type tt','tt.tanker_type_id=tr.tanker_type_id');
		$this->db->join('tanker_oil to','to.tanker_id=tr.tanker_id','left');
		$this->db->join('loose_oil lo','lo.loose_oil_id=to.loose_oil_id','left');
		$this->db->join('tanker_pm tp','tp.tanker_id=tr.tanker_id','left');
		$this->db->join('packing_material pm','pm.pm_id=tp.pm_id','left');
		$this->db->join('tanker_fg tf','tf.tanker_id=tr.tanker_id','left');
		$this->db->join('free_gift fg','fg.free_gift_id=tf.free_gift_id','left');
		$this->db->join('plant p','p.plant_id=tr.plant_id');
		$this->db->where('tr.tanker_id',$tanker_id);
		$res=$this->db->get();
		return $res->row_array();
	}

}