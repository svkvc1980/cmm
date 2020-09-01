<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by Nagarjuna on 20th march 2017 12:40PM
*/
class Dist_bg_r_m extends CI_Model
{
	public function dist_bg_results()
	{
		$this->db->select('d.distributor_id,d.distributor_code,d.agency_name');
		$this->db->from('distributor d');
		$this->db->join('user u','u.user_id = d.user_id');
		$this->db->where('u.status',1);
		$this->db->order_by('CAST(d.distributor_code as unsigned) ASC');
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_dist_bg_details($distributor_id,$from_date, $to_date, $status)
	{
		$this->db->select('distributor_code,agency_name,agreement_start_date,agreement_end_date');
		$this->db->from('distributor');
		if($distributor_id!='')
		{
			$this->db->where('distributor_id', $distributor_id);
		}
		if($status == 1)
		{
			$this->db->where('agreement_start_date >=',$from_date);
		}
		else if($status == 2)
		{
			$this->db->where('agreement_end_date <=', $from_date);
		}
		else
		{
			$this->db->where('agreement_start_date >=',$from_date);
		    $this->db->where('agreement_end_date <=',$to_date);
		}
		$res = $this->db->get();
		return $res->result_array();
	}
}