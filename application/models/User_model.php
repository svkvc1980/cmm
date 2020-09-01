<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

	public function user_results($current_offset, $per_page, $searchParams)
	{
		$val = array(5,6);
		$this->db->select('u.user_id,u.name as full_name,u.username,b.name as block_name,p.name as plant_name,d.name as designation_id,u.status');
		$this->db->from('user u');
		$this->db->join('block b','u.block_id = b.block_id');
		$this->db->join('plant p','u.plant_id = p.plant_id');
		$this->db->join('designation d','u.designation_id = d.designation_id');
		if($searchParams['usnam']!='')
			$this->db->where('u.username like "%'.$searchParams['usnam'].'%"');
		if($searchParams['bloid']!='')
			$this->db->where('u.block_id',$searchParams['bloid']);
		if($searchParams['plaid']!='')
			$this->db->where('u.plant_id',$searchParams['plaid']);
		if($searchParams['deid']!='')
			$this->db->where('u.designation_id',$searchParams['deid']);
		$this->db->where('b.status',1);
		$this->db->where('p.status',1);
		$this->db->where('d.status',1);
		$this->db->where_not_in('u.block_id',$val);
		$this->db->order_by('u.user_id','DESC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();
		return $res->result_array();
	}
	
	public function user_total_num_rows($searchParams)
	{
		$val = array(5,6);
		$this->db->select('u.user_id,u.name as full_name,u.username,b.name as block_name,p.name as plant_name,d.name as designation_id,u.status');
		$this->db->from('user u');
		$this->db->join('block b','u.block_id = b.block_id');
		$this->db->join('plant p','u.plant_id = p.plant_id');
		$this->db->join('designation d','u.designation_id = d.designation_id');
		if($searchParams['usnam']!='')
			$this->db->where('u.username like "%'.$searchParams['usnam'].'%"');
		if($searchParams['bloid']!='')
			$this->db->where('u.block_id',$searchParams['bloid']);
		if($searchParams['plaid']!='')
			$this->db->where('u.plant_id',$searchParams['plaid']);
		if($searchParams['deid']!='')
			$this->db->where('u.designation_id',$searchParams['deid']);
		$this->db->where('b.status',1);
		$this->db->where('p.status',1);
		$this->db->where('d.status',1);
		$this->db->where_not_in('u.block_id',$val);
		$this->db->order_by('u.user_id','DESC');
		$res = $this->db->get();
		return $res->num_rows();
	}
	
	public function user_details($searchParams)
	{
		$val = array(5,6);
		$this->db->select('u.*,u.name as full_name,u.username,b.name as block_name,p.name as plant_name,d.name as designation,u.status');
		$this->db->from('user u');
		$this->db->join('block b','u.block_id = b.block_id');
		$this->db->join('plant p','u.plant_id = p.plant_id');
		$this->db->join('designation d','u.designation_id = d.designation_id');
		if($searchParams['usnam']!='')
			$this->db->where('u.username like "%'.$searchParams['usnam'].'%"');
		if($searchParams['bloid']!='')
			$this->db->where('u.block_id',$searchParams['bloid']);
		if($searchParams['plaid']!='')
			$this->db->where('u.plant_id',$searchParams['plaid']);
		if($searchParams['deid']!='')
			$this->db->where('u.designation_id',$searchParams['deid']);
		$this->db->where('b.status',1);
		$this->db->where('p.status',1);
		$this->db->where('d.status',1);
		$this->db->where_not_in('u.block_id',$val);
		$this->db->order_by('u.user_id','DESC');
		$res = $this->db->get();
		return $res->result_array();
	}

	public function getplantList($blockid)
	{
	    $this->db->select('p.plant_id,p.name');
	    $this->db->from('plant p');
	    $this->db->join('plant_block pb','pb.plant_id = p.plant_id');
	    $this->db->where('pb.block_id',$blockid);
	    $this->db->where('p.status', 1);
	    $this->db->where('p.plant_id>', 1);
        $res1 = $this->db->get();
		$res = $res1->result_array();
		$count = $res1->num_rows();
		$qry_data='';
        if($count>0)
		{
			$qry_data.='<option value="">-Select Unit-</option>';
			foreach($res as $row1)
			{  
				$qry_data.='<option value="'.$row1['plant_id'].'">'.$row1['name'].'</option>';
			}
		} 
		else 
		{
			$qry_data.='<option value="">No Data Found</option>';
		}
		echo $qry_data;
    }
    public function getdisignationList($blockid)
	{
	    $this->db->select('d.designation_id,d.name');
	    $this->db->from('designation d');
	    $this->db->join('block_designation bd','bd.designation_id = d.designation_id');
	    $this->db->where('bd.block_id',$blockid);
	    $this->db->where('d.status', 1);
        $res1 = $this->db->get();
		$res = $res1->result_array();
		$count = $res1->num_rows();
		$qry_data='';
        if($count>0)
		{
			$qry_data.='<option value="">-Select Designation-</option>';
			foreach($res as $row1)
			{  
				$qry_data.='<option value="'.$row1['designation_id'].'">'.$row1['name'].'</option>';
			}
		} 
		else 
		{
			$qry_data.='<option value="">No Data Found</option>';
		}
		echo $qry_data;
    }
    public function is_userExist($user_name,$user_id)
    {
    	$this->db->select();
		$this->db->from('user');
		//$this->db->where('block_id',$block_id);
		//$this->db->where('plant_id',$plant_id);
		//$this->db->where('designation_id',$designation_id);
		$this->db->where('username',$user_name);
		if($user_id!=0)
		{
			$this->db->where_not_in('user_id',$user_id);
		}
		$this->db->where('status',1);
		$query = $this->db->get();
		return ($query->num_rows()>0)?1:0;
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
    public function get_plant_by_block($block_id)
    {
    	$this->db->select('p.plant_id,p.name');
	    $this->db->from('plant p');
	    $this->db->join('plant_block pb','pb.plant_id = p.plant_id');
	    $this->db->where('pb.block_id',$block_id);
	    $this->db->where('p.status', 1);
	    $this->db->where('p.plant_id>', 1);
        $res1 = $this->db->get();
		return $res1->result_array();
    }
    public function get_designation_by_block($block_id)
    {
    	$this->db->select('d.designation_id,d.name');
	    $this->db->from('designation d');
	    $this->db->join('block_designation bd','bd.designation_id = d.designation_id');
	    $this->db->where('bd.block_id',$block_id);
	    $this->db->where('d.status', 1);
        $res1 = $this->db->get();
		return $res1->result_array();
	}
	public function get_block_list()
	{
		$val = array(5,6);
		$this->db->select('block_id,name');
		$this->db->from('block');
		$this->db->where('status',1);
		$this->db->where_not_in('block_id',$val);
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_limit_product($loose_oil_id)
	{
		if($loose_oil_id==6)
		{
			$capacity_id = array(4);
		}
		else
		{
			$capacity_id = array(1,2,3,10);
		}
		$this->db->select('p.product_id,p.name');
		$this->db->from('product p');
		$this->db->join('loose_oil l','l.loose_oil_id = p.loose_oil_id');
		$this->db->join('product_capacity pc','pc.product_id = p.product_id');
		$this->db->join('capacity c','c.capacity_id = pc.capacity_id');
		$this->db->where_in('c.capacity_id',$capacity_id);
		$this->db->where('p.loose_oil_id',$loose_oil_id);
		$this->db->where('p.status',1);
		$this->db->order_by('l.rank ASC','c.rank ASC');
		$res = $this->db->get();
		return $res->result_array();
		
	}
}