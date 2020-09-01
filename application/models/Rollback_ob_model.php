<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rollback_ob_model extends CI_Model {

	public function get_ob_data($order_id)
	{
		$this->db->select('o.order_number,o.order_date,o.order_id,o.lifting_point,p.name as plant_name,d.agency_name,d.distributor_code,d.distributor_id,op.quantity,op.items_per_carton,op.unit_price,op.add_price,pr.product_id,pr.name as product_name,pr.short_name,op.order_product_id');
		$this->db->from('order o');
		$this->db->join('distributor_order do','do.order_id=o.order_id');
		$this->db->join('distributor d','d.distributor_id=do.distributor_id');
		$this->db->join('order_product op','op.order_id=o.order_id');
		$this->db->join('plant p','p.plant_id=o.lifting_point');
		$this->db->join('product pr','pr.product_id=op.product_id','left');
		$this->db->where('o.order_id',$order_id);
		
		//$this->db->where('op.status<=',2);
		$res=$this->db->get();
		return $res->result_array();
	}

	public function get_plant_ob_data($order_id)
	{
		$this->db->select('o.order_number,o.order_date,o.lifting_point,o.order_id,p.name as plant_name,p.plant_id as plant_id,op.quantity,op.unit_price,op.add_price,pr.product_id,pr.name as product_name,pr.short_name,op.order_product_id');
		$this->db->from('order o');
		$this->db->join('plant_order po','po.order_id=o.order_id');
		$this->db->join('plant p','po.plant_id=p.plant_id');
		$this->db->join('order_product op','op.order_id=o.order_id');
		//$this->db->join('plant p','p.plant_id=o.lifting_point');
		$this->db->join('product pr','pr.product_id=op.product_id','left');
		$this->db->where('o.order_id',$order_id);
		
		//$this->db->where('op.status<=',2);
		$res=$this->db->get();
		return $res->result_array();
	}

	public function get_order_id($order_number)
	{
		$this->db->select('*');
		$this->db->from('order');
		$this->db->where('order_number',$order_number);
		$this->db->order_by('order_id desc');
		$this->db->limit('1');
		$res=$this->db->get();
		return $res->row_array();
	}
		public function get_latest_order_id($order_number)
	{
		$this->db->select('o.order_id');
		$this->db->from('order o');
		$this->db->where('o.order_number',$order_number);
		$this->db->order_by('o.order_id','DESC');
		$this->db->limit('1');
		$res= $this->db->get();
		if($res->num_rows()>0)
		{
		 $data = $res->row_array();
		 return $data['order_id'];
		}
		else
		{
			return false;
		}
	}

}