<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock_in_transit_m extends CI_Model {

	public function get_plant_invoices($from_date, $to_date, $plant_from, $plant_to)
	{
		$this->db->select('i.invoice_number,i.invoice_id');
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
		$this->db->where('i.invoice_date>=', $from_date);
		$this->db->where('i.invoice_date<=', $to_date);
		$this->db->where('i.status',1);
		if($plant_from!='')
		{
			$this->db->where('i.plant_id',$plant_from);
		}
		if($plant_to!='')
		{
			$this->db->where('po.plant_id',$plant_to);
		}

		$this->db->distinct('ido.invoice_id');
		$this->db->where('o.type', 2);
		$this->db->order_by('i.invoice_id ASC');
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_stock_in_transit_report($from_date, $to_date, $plant_from, $plant_to, $invoice_id)
	{
		$this->db->select('
			i.invoice_date as invoice_date, 
			pt.name as lifting_point,
			p1.name as plant,i.invoice_number  as invoice_number ,
			(idop.quantity*idop.items_per_carton*p.oil_weight) as qty_in_kg,
			(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount,
			p.product_id as product_id,p.short_name as short_name,
			(idop.quantity) as qty,
			(idop.quantity *idop.items_per_carton) as pouches');
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
		$this->db->where('i.invoice_date>=', $from_date);
		$this->db->where('i.invoice_date<=', $to_date);
		$this->db->where('i.invoice_id', $invoice_id);
		$this->db->where('i.status',1);
		if($plant_from!='')
		{
			$this->db->where('i.plant_id',$plant_from);
		}
		if($plant_to!='')
		{
			$this->db->where('po.plant_id',$plant_to);
		}
		$this->db->where('o.type', 2);
		$this->db->distinct('ido.invoice_id');
		$this->db->order_by('i.invoice_id ASC');
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_plant_list()
	{
		$block_ids = array(2,3,4);
		$this->db->select('p.plant_id,p.name');
		$this->db->from('plant p');
		$this->db->join('plant_block pb','pb.plant_id = p.plant_id');
		$this->db->where_in('pb.block_id',$block_ids);
		$res = $this->db->get();
		return $res->result_array();
	}
}