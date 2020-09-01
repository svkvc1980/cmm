<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Regionwise_distributor_rm extends CI_Model {

	public function region_wise_dist_report_total_rows($search_params)
	{		
		$this->db->select('d.*,dt.name as type_name,e.name as exe_name,l.name as location_name');
		$this->db->from('distributor d');
		$this->db->join('distributor_type dt','dt.type_id=d.type_id');
		$this->db->join('executive e','e.executive_id=d.executive_id','left');
		$this->db->join('location l','l.location_id=d.location_id');
		$this->db->join('location l1','l1.location_id = l.parent_id');
		$this->db->join('location l2','l2.location_id = l1.parent_id');
		if($search_params['dist_type']!='')
			$this->db->where('d.type_id',$search_params['dist_type']);
		if($search_params['dist_code']!='')
			$this->db->where('d.distributor_code',$search_params['dist_code']);
		if($search_params['dist_name']!='')
			$this->db->like('d.agency_name',$search_params['dist_name']);
		if($search_params['executive']!='')
			$this->db->where('d.executive_id',$search_params['executive']);
		if($search_params['district']!='')
		{
			$where='(l1.location_id='.$search_params['district'].' or l1.parent_id='.$search_params['district'].')';
			$this->db->where($where);
		}
		if($search_params['region']!='')
		{
			$where='(l2.location_id='.$search_params['region'].' or l2.parent_id='.$search_params['region'].')';
			$this->db->where($where);
		}
		$res = $this->db->get();
		return $res->num_rows();
	}

	public function region_wise_dist_report_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('d.*,dt.name as type_name,e.name as exe_name,l.name as location_name, l1.name as district, l2.name as region, 
			(SELECT SUM(bg_amount) FROM bank_guarantee bg WHERE bg.distributor_id = d.distributor_id AND bg.end_date >= CURDATE())
			AS bg_amt');
		$this->db->from('distributor d');
		$this->db->join('distributor_type dt','dt.type_id=d.type_id');
		$this->db->join('executive e','e.executive_id=d.executive_id','left');
		$this->db->join('location l','l.location_id=d.location_id');
		$this->db->join('location l1','l1.location_id = l.parent_id');
		$this->db->join('location l2','l2.location_id = l1.parent_id');
		if($search_params['dist_type']!='')
			$this->db->where('d.type_id',$search_params['dist_type']);
		if($search_params['dist_code']!='')
			$this->db->where('d.distributor_code',$search_params['dist_code']);
		if($search_params['dist_name']!='')
			$this->db->like('d.agency_name',$search_params['dist_name']);
		if($search_params['executive']!='')
			$this->db->where('d.executive_id',$search_params['executive']);
		if($search_params['district']!='')
		{
			$where='(l1.location_id='.$search_params['district'].' or l1.parent_id='.$search_params['district'].')';
			$this->db->where($where);
		}
		if($search_params['region']!='')
		{
			$where='(l2.location_id='.$search_params['region'].' or l2.parent_id='.$search_params['region'].')';
			$this->db->where($where);
		}
		$this->db->order_by('CAST(d.distributor_code AS unsigned) ASC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_district_based_region($region_id)
	{
		$this->db->select('location_id, name');
		$this->db->where('parent_id', $region_id);
		$res1 = $this->db->get('location');
		$res = $res1->result_array();
		$count = $res1->num_rows();
		$qry_data='';
        if($count>0)
		{
			$qry_data.='<option value="">-Select District-</option>';
			foreach($res as $row1)
			{  
				$qry_data.='<option value="'.$row1['location_id'].'">'.$row1['name'].'</option>';
			}
		} 
		else 
		{
			$qry_data.='<option value="">No Data Found</option>';
		}
		return $qry_data;
	}

	public function regionwise_dist_details($search_params)
	{
		$this->db->select('d.*,dt.name as type_name,e.name as exe_name,l.name as location_name, l1.name as district, l2.name as region, 
			(SELECT SUM(bg_amount) FROM bank_guarantee bg WHERE bg.distributor_id = d.distributor_id AND bg.end_date >= CURDATE())
			AS bg_amt');
		$this->db->from('distributor d');
		$this->db->join('distributor_type dt','dt.type_id=d.type_id');
		$this->db->join('executive e','e.executive_id=d.executive_id','left');
		$this->db->join('location l','l.location_id=d.location_id');
		$this->db->join('location l1','l1.location_id = l.parent_id');
		$this->db->join('location l2','l2.location_id = l1.parent_id');
		if($search_params['dist_type']!='')
			$this->db->where('d.type_id',$search_params['dist_type']);
		if($search_params['dist_code']!='')
			$this->db->where('d.distributor_code',$search_params['dist_code']);
		if($search_params['dist_name']!='')
			$this->db->like('d.agency_name',$search_params['dist_name']);
		if($search_params['executive']!='')
			$this->db->where('d.executive_id',$search_params['executive']);
		if($search_params['district']!='')
		{
			$where='(l1.location_id='.$search_params['district'].' or l1.parent_id='.$search_params['district'].')';
			$this->db->where($where);
		}
		if($search_params['region']!='')
		{
			$where='(l2.location_id='.$search_params['region'].' or l2.parent_id='.$search_params['region'].')';
			$this->db->where($where);
		}
		$this->db->order_by('CAST(d.distributor_code AS unsigned) ASC');
		$res = $this->db->get();
		return $res->result_array();
	}
}