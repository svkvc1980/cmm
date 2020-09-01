<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Exec_wise_dist_list_r_m extends CI_Model {

	public function view_exec_dist_list($executive,$to_date,$from_date)
	{
		$this->db->select('dp.*,d.*,p.short_name as unit_name,b.name as bank_name');
		$this->db->from('distributor d');
		$this->db->join('distributor_payment dp','d.distributor_id=dp.distributor_id');
		$this->db->join('bank b','b.bank_id = dp.bank_id');
		$this->db->join('user u','u.user_id = dp.created_by');
		$this->db->join('plant p','p.plant_id = u.plant_id');
		$this->db->where('d.executive_id',$executive);
		$this->db->where('dp.payment_date>=',$from_date);
		$this->db->where('dp.payment_date<=',$to_date);
		$this->db->order_by('payment_date ASC');
		$res = $this->db->get();		
		return $res->result_array();
	}	



}