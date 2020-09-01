<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Page_model extends CI_Model {
	
	public function pageResults($searchParams, $per_page, $current_offset)
	{
		
		$this->db->select('page_id, name,  status');
		$this->db->from('page');
		if($searchParams['pageName']!='')
		$this->db->like('name',$searchParams['pageName']);
		$this->db->limit($per_page, $current_offset);
		$this->db->order_by('page_id','DESC');
		$res = $this->db->get();
		return $res->result_array();
	}
	
	public function pageTotalRows($searchParams)
	{
		
		$this->db->from('page');
		if($searchParams['pageName']!='')
		$this->db->like('name',$searchParams['pageName']);
		$res = $this->db->get();
		return $res->num_rows();
	}
	
	public function pageDetails($searchParams)
	{
		
		$this->db->select('p.*,CONCAT(u1.name,"(",u1.username,")") as created_user, CONCAT(u2.name,"(",u2.username,")") as modified_user');
		$this->db->from('page p');
		$this->db->join('user u1','u1.user_id = p.created_by','left');
		$this->db->join('user u2','u2.user_id = p.modified_by','left');
		if($searchParams['pageName']!='')
		$this->db->like('p.name',$searchParams['pageName']);
		$this->db->where('p.status', 1);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_block_designation()
	{
		$this->db->select('b.name as block_name,d.name as desig_name,bd.block_designation_id');
		$this->db->from('block_designation bd');
		$this->db->join('designation d','d.designation_id = bd.designation_id');
		$this->db->join('block b','b.block_id = bd.block_id');
		$this->db->where('b.status',1);
		$this->db->where('d.status',1);
		$this->db->where('bd.status',1);
		$res = $this->db->get();
		return $res->result_array();
	}

}