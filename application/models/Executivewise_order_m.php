<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Executivewise_order_m extends CI_Model 
{
	public function get_executives_list()
	{
		$this->db->select('e.executive_id,e.name as executive_name,e.short_name as short_name');
		$this->db->from('executive e');
		$this->db->join('user u','u.user_id = e.user_id');
		$this->db->where('u.status',1);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_executivewise_pending_ob_list($from_date,$to_date,$executive_id,$loose_oil_id)
	{
		$block_id = $this->session->userdata('block_id');
		$plant_id = $this->session->userdata('ses_plant_id');
		$this->db->select('sum(op.pending_qty*pro.items_per_carton*pro.oil_weight) as pending_qty');
		$this->db->from('order o');
		$this->db->join('order_product op','op.order_id = o.order_id');
		$this->db->join('product pro','pro.product_id = op.product_id');
		$this->db->join('loose_oil l','l.loose_oil_id = pro.loose_oil_id');
		$this->db->join('distributor_order do','do.order_id=o.order_id','inner');
		$this->db->join('distributor d','d.distributor_id=do.distributor_id','left');
		$this->db->join('executive e','d.executive_id = e.executive_id','left');
		$this->db->join('user u','u.user_id = e.user_id');
		$this->db->where('o.order_date >=',$from_date);
		$this->db->where('o.order_date <=',$to_date);
		$this->db->where('o.type',1);
		$this->db->where('o.status <',3);
		if($block_id == 2)
		{
			$this->db->where('o.lifting_point',$plant_id);
		}
		$this->db->where('e.executive_id',$executive_id);
		$this->db->where('l.loose_oil_id',$loose_oil_id);
		$this->db->where('u.status',1);
		$this->db->group_by('l.loose_oil_id');
		$res = $this->db->get();	
		if($res->num_rows()>0)
		{
			$value = $res->row_array();
			return $value['pending_qty'];
		}
		else
		{
			return $value = "0.00";
		}
	}
	
	public function get_executivewise_pending_do_list($from_date,$to_date,$executive_id,$loose_oil_id)
	{
		$block_id = $this->session->userdata('block_id');
		$plant_id = $this->session->userdata('ses_plant_id');
			
		$this->db->select('sum(dop.pending_qty * p.items_per_carton * p.oil_weight) AS pending_qty');
		$this->db->from('do d');
		$this->db->join('do_order doo','d.do_id = doo.do_id');
		$this->db->join('order disto','disto.order_id = doo.order_id');
		$this->db->join('do_order_product dop','doo.do_ob_id = dop.do_ob_id');
		$this->db->join('product p','dop.product_id = p.product_id');		
		$this->db->join('distributor_order do','disto.order_id = do.order_id');
		$this->db->join('distributor dis','dis.distributor_id = do.distributor_id','left');
		$this->db->join('executive e','dis.executive_id = e.executive_id','left');
		$this->db->join('user u','u.user_id = e.user_id');		
		$this->db->join('plant pt','pt.plant_id = d.lifting_point');
		$this->db->where('d.do_date >=',$from_date);
		$this->db->where('d.do_date <=',$to_date);
		if($block_id == 2)
		{
			$this->db->where('o.lifting_point',$plant_id);
		}
		$this->db->where('dis.executive_id',$executive_id);
		$this->db->where('p.loose_oil_id',$loose_oil_id);
		$this->db->where('dop.status <',3);
		$this->db->where('u.status',1);
		$this->db->group_by('p.loose_oil_id');
	        
		$res = $this->db->get();	
		if($res->num_rows()>0)
		{
			$value = $res->row_array();
			return $value['pending_qty'];
		}
		else
		{
			return $value = "0.00";
		}
	}
	
	public function product_wise_pending_ob($search_params)
	{
		$this->db->select('p.name as product_name, p.short_name, sum(op.pending_qty) as cartons, sum(op.pending_qty*op.items_per_carton) as packets, sum(op.pending_qty*op.items_per_carton*p.oil_weight) as qty_in_kgs, sum(op.pending_qty*op.items_per_carton*(op.unit_price+op.add_price)) as value_in_rupees, p.loose_oil_id, p.product_id ');
		$this->db->from('order o');
		$this->db->join('order_product op','o.order_id=op.order_id');
		$this->db->join('product p','op.product_id = p.product_id');
		$this->db->join('product_capacity pc','p.product_id=pc.product_id');
		$this->db->join('capacity c','pc.capacity_id = c.capacity_id');
		$this->db->join('loose_oil lo','p.loose_oil_id = lo.loose_oil_id');
		$this->db->where('op.status<=',2);

		if($search_params['fromDate'])
			$this->db->where('o.order_date >=',$search_params['fromDate']);
		if($search_params['toDate'])
			$this->db->where('o.order_date <=',$search_params['toDate']);
		if($search_params['lifting_point_id'])
			$this->db->where('o.lifting_point <=',$search_params['lifting_point_id']);
		$this->db->group_by('p.product_id');
		$this->db->order_by('lo.rank ASC, c.rank ASC');
		$res = $this->db->get();
		//echo $this->db->last_query(); exit;
		if($res->num_rows()>0)
			return $res->result_array();
		else
			return 0;
	}
	public function get_executivewise_sales_list($from_date,$to_date,$executive_id,$loose_oil_id)
	{
		$block_id = $this->session->userdata('block_id');
		$plant_id = $this->session->userdata('ses_plant_id');
			
		$this->db->select('sum(idp.quantity * p.items_per_carton * p.oil_weight) AS invoice_kgs,
						   sum(idp.quantity * p.items_per_carton * dop.product_price) AS invoice_amount');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ivdo','ivdo.invoice_id = i.invoice_id');
		$this->db->join('invoice_do_product idp','idp.invoice_do_id = ivdo.invoice_do_id');
		//$this->db->join('do d','d.do_id = ivdo.do_id');
		//$this->db->join('do_order doo','d.do_id = doo.do_id');
		$this->db->join('order disto','disto.order_id = ivdo.order_id');
		$this->db->join('do_order_product dop','idp.do_ob_product_id = dop.do_ob_product_id');
		$this->db->join('product p','dop.product_id = p.product_id');		
		$this->db->join('distributor_order do','disto.order_id = do.order_id');
		$this->db->join('distributor dis','dis.distributor_id = do.distributor_id','left');
		$this->db->join('executive e','dis.executive_id = e.executive_id','left');
		$this->db->join('user u','u.user_id = e.user_id');		
		$this->db->join('plant pt','pt.plant_id = i.plant_id');
		$this->db->where('i.invoice_date >=',$from_date);
		$this->db->where('i.invoice_date <=',$to_date);
		if($block_id == 2)
		{
			$this->db->where('o.lifting_point',$plant_id);
		}
		$this->db->where('dis.executive_id',$executive_id);
		$this->db->where('p.loose_oil_id',$loose_oil_id);
		$this->db->where('disto.type',1);
		$this->db->where('u.status',1);
		$this->db->group_by('p.loose_oil_id');
	        
		$res = $this->db->get();	
		if($res->num_rows()>0)
		{
			$value = $res->row_array();
			return $value;
		}
		else
		{
			return $value = array('invoice_kgs'=>'0.00','invoice_amount'=>'0.00');
		}
	}
}