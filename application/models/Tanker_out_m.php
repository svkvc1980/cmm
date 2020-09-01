<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tanker_out_m extends CI_Model {

/* 
 	Created By 		:	Koushik
 	Module 			:	Tanker Out
 	Created Time 	:	21th Feb 2017 06:39 AM
 	Modified Time 	:	
*/
 	public function get_tanker_oil_details($tanker_id)
	{
		$this->db->select('tr.*,lo.name as oil_name,lo.loose_oil_id as loose_oil_id,to.*,tt.name as tanker_type');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_type tt','tt.tanker_type_id = tr.tanker_type_id');
		$this->db->join('tanker_oil to','to.tanker_id=tr.tanker_id');
		$this->db->join('loose_oil lo','lo.loose_oil_id=to.loose_oil_id');
		$this->db->where('to.tanker_id',$tanker_id);
		$res=$this->db->get();
		return $res->result_array();
	}
	
	public function get_tanker_pm_details($tanker_id)
	{
		$this->db->select('tr.*,pm.name as packing_mtrl_name,tpm.*,tt.name as tanker_type');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_type tt','tt.tanker_type_id = tr.tanker_type_id');
		$this->db->join('tanker_pm as tpm','tpm.tanker_id=tr.tanker_id');
		$this->db->join('packing_material pm','pm.pm_id=tpm.pm_id');
		$this->db->where('tpm.tanker_id',$tanker_id);
		$res=$this->db->get();
		return $res->result_array();
	}

	public function get_empty_truck_details($tanker_id)
	{
		$this->db->select('tr.*,tpd.tier,tt.name as tanker_type,tpd.tanker_pp_delivery_id');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_type tt','tt.tanker_type_id = tr.tanker_type_id');
		$this->db->join('tanker_pp_delivery tpd','tpd.tanker_id=tr.tanker_id');
		$this->db->where('tpd.tanker_id',$tanker_id);
		$res=$this->db->get();
		return $res->result_array();
	}

	public function get_tanker_free_gift_details($tanker_id)
	{
		$this->db->select('tr.*,fg.name as free_gift_name,tfg.*,tt.name as tanker_type');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_type tt','tt.tanker_type_id = tr.tanker_type_id');
		$this->db->join('tanker_fg tfg','tfg.tanker_id=tr.tanker_id');
		$this->db->join('free_gift fg','fg.free_gift_id=tfg.free_gift_id');
		$this->db->where('tr.tanker_id',$tanker_id);
		$res=$this->db->get();
		return $res->result_array();
	}

	public function get_packed_product_details($tanker_id)
	{
		$this->db->select('tr.*,tt.name as tanker_type');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_type tt','tt.tanker_type_id = tr.tanker_type_id');
		$this->db->where('tr.tanker_id',$tanker_id);
		$res=$this->db->get();
		return $res->result_array();

	}
	 public function get_tanker_id_rows($tanker_number,$plant_id)
    {
        $this->db->select('tanker_id');
        $this->db->from('tanker_register');
        $this->db->where('tanker_in_number',$tanker_number);
        $this->db->where('plant_id',$plant_id);
        $res=$this->db->get();
        return $res->num_rows();
    }
     public function get_tanker_id($tanker_number)
    {
        $this->db->select('tanker_id,tanker_type_id');
        $this->db->from('tanker_register');
        $this->db->where('tanker_in_number',$tanker_number);
        $this->db->order_by('tanker_id','DESC');
        $this->db->limit(1);
        $res = $this->db->get();
        return $res->row_array();
    }
	
}