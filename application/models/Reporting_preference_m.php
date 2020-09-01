<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reporting_preference_m extends CI_Model {

	public function reporting_results($current_offset, $per_page, $searchParams)
	{
		$this->db->select('rp.*,
					       concat(d1.name, " (" ,b1.name,")") as issue_raised_by,
					       concat(d2.name, " (" ,b2.name,")") as issue_closed_by');
		$this->db->from('reporting_preference rp');
		$this->db->join('block_designation bd1','bd1.block_designation_id = rp.issue_raised_by');
		$this->db->join('block_designation bd2','bd2.block_designation_id = rp.issue_closed_by');
		$this->db->join('block b1','b1.block_id = bd1.block_id');
		$this->db->join('block b2','b2.block_id = bd2.block_id');
		$this->db->join('designation d1','d1.designation_id = bd1.designation_id');
		$this->db->join('designation d2','d2.designation_id = bd2.designation_id');
		if($searchParams['label']!='')
			$this->db->like('rp.rep_preference_id',$searchParams['label']);
		$this->db->where('rp.status',1);
		$this->db->order_by('rp.rep_preference_id','DESC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();
		return $res->result_array();
	}
	
	public function reporting_total_num_rows($searchParams)
	{
		$this->db->select('rp.*,
					       concat(d1.name, " (" ,b1.name,")") as issue_raised_by,
					       concat(d2.name, " (" ,b2.name,")") as issue_closed_by');
		$this->db->from('reporting_preference rp');
		$this->db->join('block_designation bd1','bd1.block_designation_id = rp.issue_raised_by');
		$this->db->join('block_designation bd2','bd2.block_designation_id = rp.issue_closed_by');
		$this->db->join('block b1','b1.block_id = bd1.block_id');
		$this->db->join('block b2','b2.block_id = bd2.block_id');
		$this->db->join('designation d1','d1.designation_id = bd1.designation_id');
		$this->db->join('designation d2','d2.designation_id = bd2.designation_id');
		if($searchParams['label']!='')
			$this->db->like('rp.rep_preference_id',$searchParams['label']);
		$this->db->where('rp.status',1);
		$this->db->order_by('rp.rep_preference_id','DESC');
		$res = $this->db->get();
		return $res->num_rows();
	}

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

	public function get_table_column($table_name)
	{
		$res1 = $this->db->query("desc  `".$table_name."`");
		$res = $res1->result_array();
		$count = $res1->num_rows();
		$qry_data='';
        if($count>0)
		{
			$qry_data.='<option value="">-Select Table Column-</option>';
			foreach($res as $row1)
			{  
				$qry_data.='<option value="'.$row1['Field'].'">'.$row1['Field'].'</option>';
			}
		} 
		else 
		{
			$qry_data.='<option value="">No Data Found</option>';
		}
		echo $qry_data;

	}
	public function get_table_primary_column($table_name)
	{
		$res1 = $this->db->query("desc  `".$table_name."`");
		$res = $res1->result_array();
		$count = $res1->num_rows();
		$qry_data='';
        if($count>0)
		{
			$qry_data.='<option value="">-Select Table Primary Column-</option>';
			foreach($res as $row1)
			{  
				$qry_data.='<option value="'.$row1['Field'].'">'.$row1['Field'].'</option>';
			}
		} 
		else 
		{
			$qry_data.='<option value="">No Data Found</option>';
		}
		echo $qry_data;

	}
}