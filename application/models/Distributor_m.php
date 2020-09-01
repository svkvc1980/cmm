<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Distributor_m extends CI_Model {

/*Getting Distributor num of rows
Author:Srilekha
Time: 3.30PM 21-01-2017 */
 public function get_active_distributor_list()
	{
		$this->db->select('d.distributor_id,d.agency_name,d.distributor_code');
    	$this->db->from('distributor d');
    	$this->db->join('user u','u.user_id = d.user_id');
    	$this->db->where('u.status',1);
    	$this->db->order_by('CAST(d.distributor_code as unsigned) ASC');
    	$res = $this->db->get();
    	return $res->result_array();
	}


public function get_dist_bg_expired_details($distributor_id)
	{
		$this->db->select('*');
		$this->db->from('bank_guarantee bg');
		$this->db->join('bank b','bg.bank_id=b.bank_id');
		$this->db->where('bg.distributor_id',$distributor_id);
		$this->db->where('bg.end_date < ',date('Y-m-d'));
		$this->db->where('bg.status',1);
		$res = $this->db->get();
    	return $res->result_array();
	}
public function get_agent_list($agent_id)
{
	$this->db->select('d.distributor_id,CONCAT(d.distributor_code," - (",d.agency_name,")") as name');
	$this->db->from('distributor d');
	$this->db->join('user u','u.user_id = d.user_id');
	$this->db->where('d.type_id',$agent_id);
	$this->db->where('u.status',1);
	$this->db->order_by('d.distributor_id ASC');
	$res = $this->db->get();
	return $res->result_array();
}

public function get_latest_agreement($distributor_id)
{
	$this->db->select('*');
	$this->db->from('distributor_agreement_history');
	$this->db->where('distributor_id',$distributor_id);
	$this->db->order_by('dah_id DESC');
	$res = $this->db->get();
	return $res->row_array();
}

public function distributor_total_num_rows($search_params)
	{		
		$this->db->select('d.*,u.status,dt.name as type_name');
		$this->db->from('distributor d');
		$this->db->join('distributor_type dt','dt.type_id = d.type_id');
		$this->db->join('user u','u.user_id= d.user_id');
		if($search_params['distributor_code']!='')
			$this->db->where('d.distributor_code',$search_params['distributor_code']);
		if($search_params['type_id']!='')
			$this->db->where('d.type_id',$search_params['type_id']);
		if($search_params['agency_name']!='')
			$this->db->like('d.agency_name',$search_params['agency_name']);
		$this->db->where('dt.status',1);
		$this->db->order_by('d.distributor_id ASC');
		$res = $this->db->get();
		return $res->num_rows();
	}
/*Getting Distributor results
Author:Srilekha
Time: 3.33PM 21-01-2017 */
public function distributor_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('d.*,u.status,dt.name as type_name');
		$this->db->from('distributor d');
		$this->db->join('distributor_type dt','dt.type_id = d.type_id');
		$this->db->join('user u','u.user_id= d.user_id');
		if($search_params['distributor_code']!='')
			$this->db->where('d.distributor_code',$search_params['distributor_code']);
		if($search_params['type_id']!='')
			$this->db->where('d.type_id',$search_params['type_id']);
		if($search_params['agency_name']!='')
			$this->db->like('d.agency_name',$search_params['agency_name']);
		$this->db->where('dt.status',1);
		$this->db->order_by('d.distributor_id ASC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
/*Getting Distributor results
Author:Srilekha
Time: 4.08PM 21-01-2017 */
public function distributor_details($search_params)
	{		
		$this->db->select('d.*,u.status,dt.name as type_name,u.username');
		$this->db->from('distributor d');
		$this->db->join('distributor_type dt','dt.type_id = d.type_id');
		$this->db->join('user u','u.user_id= d.user_id');
		if($search_params['distributor_code']!='')
			$this->db->where('d.distributor_code',$search_params['distributor_code']);
		if($search_params['type_id']!='')
			$this->db->where('d.type_id',$search_params['type_id']);
		if($search_params['agency_name']!='')
			$this->db->like('d.agency_name',$search_params['agency_name']);
		$this->db->where('dt.status',1);
		$this->db->order_by('d.distributor_id ASC');
		$res = $this->db->get();
		return $res->result_array();
	}
/*Getting Distrct results
Author:Srilekha
Time: 2.52PM 25-01-2017 */
	public function getregionList($state_id)
	{
	    $this->db->select('location_id,name');
	    $this->db->from('location');
	    $this->db->where('parent_id',$state_id);
	    $this->db->where('status', 1);
        $res1 = $this->db->get();
		$res = $res1->result_array();
		$count = $res1->num_rows();
		$qry_data='';
        if($count>0)
		{
			$qry_data.='<option value="">-Select Region-</option>';
			foreach($res as $row1)
			{  
				$qry_data.='<option value="'.$row1['location_id'].'">'.$row1['name'].'</option>';
			}
		} 
		else 
		{
			$qry_data.='<option value="">No Data Found</option>';
		}
		echo $qry_data;
    }
/*Getting Distrct results
Author:Srilekha
Time: 2.52PM 25-01-2017 */
	public function getdistrictList($region_id)
	{
	    $this->db->select('location_id,name');
	    $this->db->from('location');
	    $this->db->where('parent_id',$region_id);
	    $this->db->where('status', 1);
        $res1 = $this->db->get();
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
		echo $qry_data;
    }
/*Getting Distrct results
Author:Srilekha
Time: 2.52PM 25-01-2017 */
	/*public function getareaList($district_id)
	{
	    $this->db->select('location_id,name');
	    $this->db->from('location');
	    $this->db->where('parent_id',$district_id);
	    $this->db->where('status', 1);
        $res1 = $this->db->get();
		$res = $res1->result_array();
		$count = $res1->num_rows();
		$qry_data='';
        if($count>0)
		{
			$qry_data.='<option value="">-Select City/Town-</option>';
			foreach($res as $row1)
			{  
				$qry_data.='<option value="'.$row1['location_id'].'">'.$row1['name'].'</option>';
			}
		} 
		else 
		{
			$qry_data.='<option value="">No Data Found</option>';
		}
		echo $qry_data;
    }*/
  /*Getting Mandal results
    Author:Mounika*/
	public function getmandalList($district_id)
	{
	    $this->db->select('location_id,name');
	    $this->db->from('location');
	    $this->db->where('parent_id',$district_id);
	    $this->db->where('status', 1);
        $res1 = $this->db->get();
		$res = $res1->result_array();
		$count = $res1->num_rows();
		$qry_data='';
        if($count>0)
		{
			$qry_data.='<option value="">-Select Mandal-</option>';
			foreach($res as $row1)
			{  
				$qry_data.='<option value="'.$row1['location_id'].'">'.$row1['name'].'</option>';
			}
		} 
		else 
		{
			$qry_data.='<option value="">No Data Found</option>';
		}
		echo $qry_data;
    }
    /*Getting Area results
      Author:Mounika */
	public function getareaList($mandal_id)
	{
		//echo $mandal_id;exit;
	    $this->db->select('location_id,name');
	    $this->db->from('location');
	    $this->db->where('parent_id',$mandal_id);
	    $this->db->where('status', 1);
        $res1 = $this->db->get();
		$res = $res1->result_array();
		$count = $res1->num_rows();
		$qry_data='';
        if($count>0)
		{
			$qry_data.='<option value="">-Select City/Town-</option>';
			foreach($res as $row1)
			{  
				$qry_data.='<option value="'.$row1['location_id'].'">'.$row1['name'].'</option>';
			}
		} 
		else 
		{
			$qry_data.='<option value="">No Data Found</option>';
		}
		echo $qry_data;
    }
    public function check_user_availability($username,$user_id)
    {
    	$this->db->select();
		$this->db->from('user');
		//$this->db->where('block_id',$block_id);
		//$this->db->where('plant_id',$plant_id);
		//$this->db->where('designation_id',$designation_id);
		$this->db->where('username',$username);
		if($user_id!=0)
		{
			$this->db->where_not_in('user_id',$user_id);
		}
		$this->db->where('status',1);
		$query = $this->db->get();
		return ($query->num_rows()>0)?1:0;
    }

    public function get_bg_expired_details()
    {
    	$date=date('Y-m-d');
		$this->db->select('bg.bg_id,bg.account_no,bg.bg_amount,bg.start_date,bg.end_date,d.distributor_id,d.agency_name as distributor_name,d.distributor_code,d.distributor_place,b.bank_id,b.name as bank_name');
		$this->db->from('bank_guarantee bg');
		$this->db->join('distributor d','bg.distributor_id=d.distributor_id');
		$this->db->join('bank b','bg.bank_id=b.bank_id');
		$this->db->where('bg.end_date<=',$date);
		$this->db->where('bg.status',1);
	    $res=$this->db->get();
        return $res->result_array();
    }

    public function get_agreement_expired_details()
    {
    	$date=date('Y-m-d');
		$this->db->select('d.*');
		$this->db->from('distributor d');
		$this->db->where('agreement_end_date<=',$date);
		$res=$this->db->get();
        return $res->result_array();
    }

    public function get_bg_going_expired_details()
    {
    	$no_of_days=get_preference("going_to_expire_days","general_settings");
    	$date=date('Y-m-d',strtotime("+".$no_of_days."days"));
    	$this->db->select('bg.bg_id,bg.account_no,bg.bg_amount,bg.start_date,bg.end_date,d.distributor_id,d.agency_name as distributor_name,d.distributor_code,d.distributor_place,b.bank_id,b.name as bank_name');
		$this->db->from('bank_guarantee bg');
		$this->db->join('distributor d','bg.distributor_id=d.distributor_id');
		$this->db->join('bank b','bg.bank_id=b.bank_id');
		$this->db->where('end_date>=',date('Y-m-d'));
		$this->db->where('end_date<=',$date);
		$this->db->where('bg.status',1);
	    $res=$this->db->get();
        return $res->result_array();
	    //echo $this->db->last_query();exit;
    }

    public function get_agreement_going_expired_details()
    {
    	$no_of_days=get_preference("going_to_expire_days","general_settings");
    	$date=date('Y-m-d',strtotime("+".$no_of_days."days"));
		$this->db->select('d.*');
		$this->db->from('distributor d');
		$this->db->where('agreement_end_date>=',date('Y-m-d'));
		$this->db->where('agreement_end_date<=',$date);
		$res=$this->db->get();
        return $res->result_array();
    }

}