<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Consolidated_sales_m extends CI_Model 
{
	public function get_plant()
	{   
		$this->db->select('pb.plant_id as plant_id,pb.block_id as block_id,p.short_name as plant_name,b.name as block_name');
		$this->db->from('plant_block pb');
		$this->db->join('plant p','pb.plant_id=p.plant_id');
		$this->db->join('block b','pb.block_id=b.block_id');
		$in=array(2,3,4);
		$this->db->where_in('pb.block_id',$in);
		$this->db->where('pb.status',1);
		$this->db->order_by('b.block_id');
		$res=$this->db->get();
		return $res->result_array();
	}

	public function get_products() 
	{
		$this->db->from('loose_oil');
		$this->db->where('status',1);
		$this->db->order_by('rank ASC');
		$res=$this->db->get();
		return $res->result_array();
	}

	public function get_sub_products_by_products($loose_oil_id)
	{
		$this->db->select('p.product_id,p.name');
		$this->db->from('product p');
		$this->db->join('product_capacity pc','pc.product_id = p.product_id');
		$this->db->join('capacity c','c.capacity_id = pc.capacity_id');
		$this->db->where('loose_oil_id',$loose_oil_id);
		$this->db->order_by('c.rank ASC');
		$this->db->where('p.status',1);
		$res=$this->db->get();
		return $res->result_array();
	}

	public function get_all_product_sales_list($plant_id,$from_date,$to_date)
	{
		$this->db->select('p.product_id as product_id,sum(idop.quantity) as qty,sum(idop.quantity *idop.items_per_carton) as pouches,sum(idop.quantity*idop.items_per_carton*p.oil_weight) as qty_in_kg,
			sum(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('do d','d.do_id = ido.do_id');
		$this->db->join('user u','d.created_by = u.user_id','left');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->join('order ord','ord.order_id = ido.order_id');
		$this->db->where('i.invoice_date >=',$from_date);
		$this->db->where('i.invoice_date <=',$to_date);
		$this->db->where('i.plant_id',$plant_id);
		$this->db->where('ord.type',1);
		$this->db->group_by('idop.product_id');
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_all_closing_stock_list($plant_id)
	{
		$this->db->select('p.product_id,(pp.quantity * p.items_per_carton) as pouches,(pp.quantity * p.items_per_carton * p.oil_weight) as qty_in_kg');
		$this->db->from('plant_product pp');
		$this->db->join('product p','p.product_id = pp.product_id');
		$this->db->where('pp.plant_id',$plant_id);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_stock_in_transit_list()
	{
		$this->db->select('p.product_id,
			sum(idop.quantity*idop.items_per_carton*p.oil_weight) as qty_in_kg,
			sum(idop.quantity *idop.items_per_carton) as pouches');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('do d','d.do_id = ido.do_id ');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('order o', 'o.order_id = do.order_id');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->join('plant_order po','po.order_id=o.order_id');
		$this->db->join('plant pt','pt.plant_id=po.plant_id');
		$this->db->join('plant p1','p1.plant_id=pt.plant_id');	
		$this->db->where('i.status',1);
		$this->db->where('o.type', 2);
		$this->db->group_by('idop.product_id');
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_executive_list()
	{
		$this->db->select('e.executive_id,e.name,e.short_name');
		$this->db->from('executive e');
		$this->db->join('user u','u.user_id = e.user_id');
		$this->db->where('u.status',1);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_all_product_executive_sales_list($executive_id,$from_date,$to_date)
	{
		$this->db->select('p.product_id as product_id,sum(idop.quantity) as qty,sum(idop.quantity *idop.items_per_carton) as pouches,sum(idop.quantity*idop.items_per_carton*p.oil_weight) as qty_in_kg,
			sum(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('do d','d.do_id = ido.do_id');
		$this->db->join('user u','d.created_by = u.user_id','left');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->join('order o','o.order_id = ido.order_id');
		$this->db->join('distributor_order diso','diso.order_id = o.order_id');
		$this->db->join('distributor dist','dist.distributor_id = diso.distributor_id');
		$this->db->join('executive e','e.executive_id = dist.executive_id');
		$this->db->where('i.invoice_date >=',$from_date);
		$this->db->where('i.invoice_date <=',$to_date);
		$this->db->where('e.executive_id',$executive_id);
		$this->db->where('o.type',1);
		$this->db->group_by('idop.product_id');
		$res = $this->db->get();
		return $res->result_array();
	}
}