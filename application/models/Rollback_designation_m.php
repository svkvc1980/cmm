<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rollback_designation_m extends CI_Model {

	public function get_designations()
	{
		$this->db->select('bd.block_designation_id,d.name,b.name as block_name');
		$this->db->from('block_designation bd');
		$this->db->join('designation d','d.designation_id=bd.designation_id');
		$this->db->join('block b','b.block_id=bd.block_id');
		$this->db->where('bd.block_id',1);
		$res = $this->db->get();
        return $res->result_array();
	}

	public function reportee_designation_total_num_rows($search_params)
	{
		$this->db->select('dr.reportee_id,dr.reporting_id,d.name as reportee_name,d1.name as reporting_name,b.name as block_name');
		$this->db->from('designation_reporting dr');
		$this->db->join('block_designation bd','dr.reportee_id=bd.block_designation_id');
		$this->db->join('block b','b.block_id=bd.block_id');
		$this->db->join('block_designation bd1','dr.reporting_id=bd1.block_designation_id');
		$this->db->join('designation d','d.designation_id=bd.designation_id');
		$this->db->join('designation d1','d1.designation_id=bd1.designation_id');
		if($search_params['reportee_id']!='')
			$this->db->where('dr.reportee_id',$search_params['reportee_id']);
		if($search_params['reporting_id']!='')
			$this->db->where('dr.reporting_id',$search_params['reporting_id']);
		$this->db->where('dr.status',1);
		$res = $this->db->get();
		return $res->num_rows();
	}

	public function reportee_designation_results($current_offset, $per_page, $search_params)
	{
		$this->db->select('dr.reportee_id,dr.reporting_id,d.name as reportee_name,d1.name as reporting_name,b.name as block_name');
		$this->db->from('designation_reporting dr');
		$this->db->join('block_designation bd','dr.reportee_id=bd.block_designation_id');
		$this->db->join('block b','b.block_id=bd.block_id');
		$this->db->join('block_designation bd1','dr.reporting_id=bd1.block_designation_id');
		$this->db->join('designation d','d.designation_id=bd.designation_id');
		$this->db->join('designation d1','d1.designation_id=bd1.designation_id');
		if($search_params['reportee_id']!='')
			$this->db->where('dr.reportee_id',$search_params['reportee_id']);
		if($search_params['reporting_id']!='')
			$this->db->where('dr.reporting_id',$search_params['reporting_id']);
		$this->db->where('dr.status',1);
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}

	public function reportee_designation_details($search_params)
	{
		$this->db->select('dr.reportee_id,dr.reporting_id,d.name as reportee_name,d1.name as reporting_name,b.name as block_name');
		$this->db->from('designation_reporting dr');
		$this->db->join('block_designation bd','dr.reportee_id=bd.block_designation_id');
		$this->db->join('block b','b.block_id=bd.block_id');
		$this->db->join('block_designation bd1','dr.reporting_id=bd1.block_designation_id');
		$this->db->join('designation d','d.designation_id=bd.designation_id');
		$this->db->join('designation d1','d1.designation_id=bd1.designation_id');
		if($search_params['reportee_id']!='')
			$this->db->where('dr.reportee_id',$search_params['reportee_id']);
		if($search_params['reporting_id']!='')
			$this->db->where('dr.reporting_id',$search_params['reporting_id']);
		$this->db->where('dr.status',1);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function insert_update($reportee_id,$reporting_id)
	{
		$qry = "INSERT INTO designation_reporting( reportee_id, reporting_id, status) 
                    VALUES (".$reportee_id.",".$reporting_id.",'1')  
                    ON DUPLICATE KEY UPDATE status = VALUES(status);";
        $this->db->query($qry);
	}

}