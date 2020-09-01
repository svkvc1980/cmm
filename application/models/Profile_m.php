<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_m extends CI_Model {

/*User details for ops,headoffice,C&F and stock point
Author:Srilekha
Time: 04.17PM 22-02-2017 */
	public function get_ops_details($block_id)
	{
		$this->db->select('u.*,p.name as plant_name,b.name as block_name,d.name as designation_name');
		$this->db->from('user u');
		$this->db->join('plant p','p.plant_id=u.plant_id');
		$this->db->join('block b','b.block_id=u.block_id');
		$this->db->join('designation d','d.designation_id=u.designation_id');
		$this->db->where('u.block_id',$block_id);
		$this->db->where('u.status',1);
		$res = $this->db->get();		
		return $res->result_array();
	}
/*User details for Distributor
Author:Srilekha
Time: 05.04PM 22-02-2017 */
	public function get_distributor_details($block_id)
	{
		$this->db->select('u.*,p.name as plant_name,b.name as block_name,d.*,bg.*,dt.name as type_name');
		$this->db->from('user u');
		$this->db->join('plant p','p.plant_id=u.plant_id');
		$this->db->join('block b','b.block_id=u.block_id');
		$this->db->join('distributor d','d.user_id=u.user_id');
		$this->db->join('bank_guarantee bg','bg.distributor_id=d.distributor_id');
		$this->db->join('distributor_type dt','dt.type_id=d.type_id');
		$this->db->where('u.block_id',$block_id);
		$this->db->where('u.status',1);
		$res = $this->db->get();		
		return $res->result_array();
	}
/*User details for Distributor Bank Details
Author:Srilekha
Time: 11.47PM 2-02-2017 */
	public function get_bank_details($distributor_id)
	{
		$this->db->select('bg.*,b.name as bank_name');
		$this->db->from('bank_guarantee bg');
		$this->db->join('bank b','b.bank_id=bg.bank_id');
		$this->db->where('bg.distributor_id',$distributor_id);
		$this->db->where('bg.status',1);
		$res=$this->db->get();
		return $res->result_array();
	}
}