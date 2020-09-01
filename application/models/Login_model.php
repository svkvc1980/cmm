<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model 
{
	public function ServerloginCheck($username = 0, $password = 0)
	{
		$this->db->select('login_id');
		$this->db->from('login');
		$this->db->where('user_name',$username);
		$this->db->where('password',$password);
		$res = $this->db->get();
		if($res->num_rows() > 0)
		{
			$data = $res->row_array();
			$ret = $data['login_id'];
		}
		else $ret = 0;
		return $ret;
	}

	public function loginCheck($username = 0, $password = 0)
	{
		$this->db->select('user_id');
		$this->db->from('user');
		$this->db->where('username',$username);
		$this->db->where('password',md5($password));
		$this->db->where('status',1);
		$res = $this->db->get();
		if($res->num_rows() > 0)
		{
			$data = $res->row_array();
			$ret = $data['user_id'];
		}
		else $ret = 0;
		return $ret;
	}

	public function getUserRole($user_id = 0)
	{
		$this->db->select('role_id');
		$this->db->from('user');
		$this->db->where('user_id',$user_id);
		$res = $this->db->get();
		if($res->num_rows() > 0)
		{
			$data = $res->row_array();
			$ret = $data['role_id'];
		}
		else $ret = 0;
		return $ret;
	}

	public function getUserDetails($user_id = 0)
	{
		$dis = array(1,3);//for active users and admin,superadmin
		$this->db->select('u.*,p.plant_id,p.name as plant_name,b.name as block_name,d.name as designation_name,d.designation_id,bd.block_designation_id');
		$this->db->from('user u');
		$this->db->join('block b','u.block_id = b.block_id');
		$this->db->join('designation d','d.designation_id = u.designation_id');
		$this->db->join('block_designation bd','bd.designation_id = u.designation_id AND bd.block_id = u.block_id');
		$this->db->join('plant p','p.plant_id = u.plant_id');
		$this->db->where('u.user_id',$user_id);
		$this->db->where('u.status',1);
		$this->db->where('p.status',1);
		$this->db->where('b.status',1);
		$this->db->where_in('d.status',$dis);
		$res = $this->db->get();
		if($res->num_rows() > 0)
		{
			$ret = $res->row_array();
		}
		else $ret = array();
		return $ret;
	}

	public function getUserBranch($user_id = 0)
	{
		$this->db->select('branch_id');
		$this->db->from('user_branch');
		$this->db->where('user_id',$user_id);
		$res = $this->db->get();
		if($res->num_rows() > 0)
		{
			$data = $res->row_array();
			$ret = $data['branch_id'];
		}
		else $ret = 0;
		return $ret;
	}	

	public function getCustomerFromBranch($branch_id = 0)
	{
		$this->db->select('customer_id');
		$this->db->from('branch');
		$this->db->where('branch_id',$branch_id);
		$res = $this->db->get();
		if($res->num_rows() > 0)
		{
			$data = $res->row_array();
			$ret = $data['customer_id'];
		}
		else $ret = 0;
		return $ret;
	}

	public function getCustomerBranches($customer_id = 0)
	{
		$branch = array();
		$this->db->select('branch_id');
		$this->db->from('branch');
		$this->db->where('customer_id',$customer_id);
		$res = $this->db->get();
		if($res->num_rows() > 0)
		{
			$data = $res->result_array();
			$i = 0;
			foreach($data as $row)
			{
				$branch[$i] = $row['branch_id'];
				$i++;
			}
			$ret = $data['customer_id'];
		}
		return $branch;
	}

	public function is_usernameExist($username)
	{		
		$this->db->select();
		$this->db->where('username',$username);
		$query = $this->db->get('user');
		return ($query->num_rows()>0)?1:0;
	}

	public function checkOldPassword($password, $user_id)
	{
		$this->db->select();
		$this->db->where('user_id',$user_id);
		$this->db->where('password',md5($password));
		$query = $this->db->get('user');
		return ($query->num_rows()>0)?1:0;
	}
}