<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cd_candf_r_m extends CI_Model {

	public function get_plant_details()
    {
        $c_f_id = get_c_and_f_block_id();
        $this->db->select('p.plant_id,p.name');
        $this->db->from('plant p');     
        $this->db->join('plant_block pb','pb.plant_id=p.plant_id');
        $this->db->where('pb.block_id',$c_f_id);
        $res = $this->db->get();        
        return $res->result_array();
    }

	public function cd_candf_total_num_rows($search_params)
	{		
		$this->db->select('n.*,cf.concerned_person as concerned_person,cdp.name as purpose,cdp.type as type,p.name as name');
		$this->db->from('c_and_f_credit_debit_note n');
		$this->db->join('plant p', 'p.plant_id=n.plant_id');
		$this->db->join('credit_debit_purpose cdp', 'n.purpose_id=cdp.purpose_id');
		$this->db->join('c_and_f cf', 'cf.plant_id=p.plant_id');
		if($search_params['c_and_f_id']!='')
			$this->db->like('cf.c_and_f_id',$search_params['c_and_f_id']);
		if($search_params['on_date']!='')
			$this->db->like('n.on_date',$search_params['on_date']);
		if($search_params['note_type']!='')
			$this->db->like('n.note_type',$search_params['note_type']);
		$res = $this->db->get();
		return $res->num_rows();
	}

	public function get_c_and_f_cd_list($search_params)
	{		
		$this->db->select('n.*,cdp.name as purpose,p.name as name');
		$this->db->from('c_and_f_credit_debit_note n');
		$this->db->join('plant p', 'p.plant_id=n.plant_id');
		$this->db->join('credit_debit_purpose cdp', 'n.purpose_id=cdp.purpose_id');
		$this->db->join('c_and_f cf', 'cf.plant_id=p.plant_id');
		if($search_params['plant_id']!='')
			$this->db->like('cf.plant_id',$search_params['plant_id']);
		if($search_params['from_date']!='')
			$this->db->where('n.on_date >=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('n.on_date <=',$search_params['to_date']);
		if($search_params['type_id']!='')
			$this->db->like('n.note_type',$search_params['type_id']);
		$this->db->order_by('n.on_date ASC');
		$res = $this->db->get();
		return $res->result_array();
	}

	//for xl download
	public function c_and_f_cd_download($search_params)
	{
		$this->db->select('n.*,cdp.name as purpose,p.name as name');
		$this->db->from('c_and_f_credit_debit_note n');
		$this->db->join('plant p', 'p.plant_id=n.plant_id');
		$this->db->join('credit_debit_purpose cdp', 'n.purpose_id=cdp.purpose_id');
		$this->db->join('c_and_f cf', 'cf.plant_id=p.plant_id');
		if($search_params['plant_id']!='')
			$this->db->like('cf.plant_id',$search_params['plant_id']);
		if($search_params['from_date']!='')
			$this->db->where('n.on_date >=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('n.on_date <=',$search_params['to_date']);
		if($search_params['type_id']!='')
			$this->db->like('n.note_type',$search_params['type_id']);
		$this->db->order_by('n.on_date ASC');
		$res = $this->db->get();
		return $res->result_array();
	}
}