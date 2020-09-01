<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Approval_list_m extends CI_Model 
{
	public function get_designation_list()
	{
		$this->db->select('bd.block_designation_id,concat(d.name, " (" ,b.name,")") as name');
		$this->db->from('block_designation bd');
		$this->db->join('block b','b.block_id = bd.block_id');
		$this->db->join('designation d','d.designation_id = bd.designation_id');
		$this->db->where('b.block_id',1);
		$res = $this->db->get();
		return $res->result_array();
	}
	public function approval_results($current_offset, $per_page, $searchParams)
	{
		$this->db->select('al.*,rp.label,
					       concat(d.name, " (" ,b.name,")") as issue_name');
		$this->db->from('approval_list al');
		$this->db->join('reporting_preference rp','rp.rep_preference_id = al.rep_preference_id');
		$this->db->join('block_designation bd','bd.block_designation_id = al.issue_at');
		$this->db->join('block b','b.block_id = bd.block_id');
		$this->db->join('designation d','d.designation_id = bd.designation_id');
		if($searchParams['label']!='')
			$this->db->where('rp.rep_preference_id',$searchParams['label']);
		if($searchParams['approval_number']!='')
			$this->db->like('al.approval_number',$searchParams['approval_number']);
		if($searchParams['issue_at']!='')
		{
			$this->db->where('al.issue_at',$searchParams['issue_at']);
		}
		/*else
		{
			$this->db->where('al.issue_at',$this->session->userdata('block_designation_id'));
		}*/
		if($searchParams['from_date']!='')
			$this->db->where('al.created_time >=',$searchParams['from_date']);
		if($searchParams['to_date']!='')
			$this->db->where('al.created_time <=',$searchParams['to_date']);
		if($searchParams['status']!='')
			$this->db->where('al.status',$searchParams['status']);
		$this->db->order_by('al.approval_id','DESC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();
		return $res->result_array();
	}
	
	public function approval_total_num_rows($searchParams)
	{
		$this->db->select('al.*,rp.label,
					       concat(d.name, " (" ,b.name,")") as issue_at');
		$this->db->from('approval_list al');
		$this->db->join('reporting_preference rp','rp.rep_preference_id = al.rep_preference_id');
		$this->db->join('block_designation bd','bd.block_designation_id = al.issue_at');
		$this->db->join('block b','b.block_id = bd.block_id');
		$this->db->join('designation d','d.designation_id = bd.designation_id');
		if($searchParams['label']!='')
			$this->db->where('rp.rep_preference_id',$searchParams['label']);
		if($searchParams['approval_number']!='')
			$this->db->like('al.approval_number',$searchParams['approval_number']);
		if($searchParams['issue_at']!='')
		{
			$this->db->where('al.issue_at',$searchParams['issue_at']);
		}
		/*else
		{
			$this->db->where('al.issue_at',$this->session->userdata('block_designation_id'));
		}*/
		if($searchParams['from_date']!='')
			$this->db->where('al.created_time >=',$searchParams['from_date']);
		if($searchParams['to_date']!='')
			$this->db->where('al.created_time <=',$searchParams['to_date']);
		if($searchParams['status']!='')
			$this->db->where('al.status',$searchParams['status']);
		$this->db->order_by('al.approval_id','DESC');
		$res = $this->db->get();
		return $res->num_rows();
	}

	public function get_approval_hist($approval_id)
	{
		$this->db->select('alh.remarks,concat(d.name, " (" ,b.name,")") as issued_by,u.name as created_name,alh.created_time');
		$this->db->from('approval_list_history alh');
		$this->db->join('block_designation bd','bd.block_designation_id = alh.issued_by');
		$this->db->join('block b','b.block_id = bd.block_id');
		$this->db->join('designation d','d.designation_id = bd.designation_id');
		$this->db->join('user u','u.user_id = alh.created_by');
		$this->db->where('alh.approval_id',$approval_id);
		$this->db->order_by('alh.approval_his_id DESC');
		$res = $this->db->get();
		return $res->result_array();
	}
}