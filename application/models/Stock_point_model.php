<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock_point_model extends CI_Model 
{
	public function get_dispatches_report($from_date, $to_date, $plant_id,$distributor_id)
	{
		$this->db->select('sum(idp.quantity*p.items_per_carton*p.oil_weight) as quantity, i.invoice_id, 
			GROUP_CONCAT(DISTINCT do.do_number SEPARATOR ",") as do_no, sum(idp.quantity*idp.items_per_carton*dop.product_price) as total');
		$this->db->from('invoice i');
		$this->db->join('invoice_do id', 'id.invoice_id = i.invoice_id');
		$this->db->join('invoice_do_product idp', 'idp.invoice_do_id = id.invoice_do_id');
        	$this->db->join('do_order_product dop','dop.do_ob_product_id = idp.do_ob_product_id');
		$this->db->join('do do', 'id.do_id = do.do_id');
		$this->db->join('order ord','ord.order_id  =id.order_id');
		$this->db->join('distributor_order diso','diso.order_id = ord.order_id');
		$this->db->join('product p', 'p.product_id = idp.product_id');
		if($from_date!='')
		$this->db->where('i.invoice_date>=', $from_date);
		if($to_date!='')
		$this->db->where('i.invoice_date<=', $to_date);
		if($plant_id!='')
		$this->db->where('i.plant_id', $plant_id);
		if($distributor_id!='')
		$this->db->where('diso.distributor_id', $distributor_id);
		$this->db->group_by('i.invoice_id');
		$this->db->where('i.status',1);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_invoice_distributor($from_date, $to_date, $plant_id,$distributor_id)
	{
		$this->db->select('d.distributor_code, d.agency_name, i.invoice_id, i.invoice_number, i.invoice_date, id.do_id');
		$this->db->from('invoice i');
		$this->db->join('invoice_do id', 'i.invoice_id=id.invoice_id');
		$this->db->join('do d1','d1.do_id = id.do_id');
		$this->db->join('distributor_order do', 'id.order_id=do.order_id');
		$this->db->join('distributor d', 'd1.do_distributor_id=d.distributor_id');
		if($from_date!='')
		$this->db->where('i.invoice_date>=', $from_date);
		if($to_date!='')
		$this->db->where('i.invoice_date<=', $to_date);
		if($plant_id!='')
		$this->db->where('i.plant_id', $plant_id);
		if($distributor_id!='')
		$this->db->where('d.distributor_id', $distributor_id);
		$this->db->group_by('i.invoice_id');
		$this->db->where('i.status',1);
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_plant()
	{
	$block_id = array(2,3,4);
	$this->db->select('p.plant_id,p.name');
	$this->db->from('plant p');
	$this->db->join('plant_block pb','pb.plant_id = p.plant_id');
	$this->db->where_in('pb.block_id',$block_id);
	$this->db->where('p.status',1);
	$res = $this->db->get();
	return $res->result_array();
	}
	
	public function get_active_distributor()
	    {
	    	$this->db->select('d.distributor_id,d.agency_name,d.distributor_code');
	    	$this->db->from('distributor d');
	    	$this->db->join('user u','u.user_id = d.user_id');
	    	$this->db->where('u.status',1);
	    	$this->db->order_by('CAST(d.distributor_code as unsigned) ASC');
	    	$res = $this->db->get();
	    	return $res->result_array();
	    }
}