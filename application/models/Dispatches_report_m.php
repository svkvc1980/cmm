<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dispatches_report_m extends CI_Model 
{
	public function get_dispatched_invoices($from_date, $to_date, $plant_id,$distributor_id)
	{
		$this->db->select('i.invoice_number,i.invoice_id,dist.distributor_id');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('do d','d.do_id = ido.do_id ');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('order o', 'o.order_id = do.order_id');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		//$this->db->join('distributor_order diso','diso.order_id=o.order_id');
		$this->db->join('distributor dist','dist.distributor_id = d.do_distributor_id');	
		$this->db->where('i.invoice_date >=', $from_date);
		$this->db->where('i.invoice_date <=', $to_date);
		if($plant_id!='')
		$this->db->where('i.plant_id',$plant_id);
		if($distributor_id!='')
		$this->db->where('dist.distributor_id',$distributor_id);
		$this->db->distinct('ido.invoice_id');
		$this->db->where('o.type', 1);
		$this->db->order_by('i.invoice_id ASC');
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_dispatches_report($from_date, $to_date, $plant_id, $invoice_id,$distributor_id)
	{
		$this->db->select('
			i.invoice_date as invoice_date,
			i.invoice_number as invoice_number ,
			p.product_id as product_id,
			p.short_name as short_name,
			concat(dist.distributor_code, " - (" ,dist.agency_name,")") as agency_name,
			(idop.quantity) as qty,
			(idop.quantity*idop.items_per_carton*p.oil_weight) as qty_in_kg,
			(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount,
			(idop.quantity *idop.items_per_carton) as pouches');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('do d','d.do_id = ido.do_id ');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('order o', 'o.order_id = do.order_id');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->join('distributor_order diso','diso.order_id=o.order_id');
		$this->db->join('distributor dist','dist.distributor_id = d.do_distributor_id');	
		$this->db->where('i.invoice_date>=', $from_date);
		$this->db->where('i.invoice_date<=', $to_date);
		$this->db->where('i.invoice_id', $invoice_id);
		if($plant_id!='')
		$this->db->where('i.plant_id',$plant_id);
		if($distributor_id!='')
		$this->db->where('dist.distributor_id',$distributor_id);
		$this->db->where('o.type', 1);
		$this->db->group_by('idop.invoice_do_product_id');
		$this->db->order_by('i.invoice_id ASC');
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_do_number_by_invoice($from_date, $to_date, $plant_id, $invoice_id)
	{
		$this->db->select('GROUP_CONCAT(DISTINCT d.do_number SEPARATOR ",") as do_no');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','ido.invoice_id = i.invoice_id');
		$this->db->join('do d','d.do_id = ido.do_id');
		$this->db->where('i.invoice_date >=', $from_date);
		$this->db->where('i.invoice_date <=', $to_date);
		$this->db->where('i.invoice_id', $invoice_id);
		if($plant_id!='')
		$this->db->where('i.plant_id',$plant_id);
		$this->db->distinct('ido.invoice_id');
		$res = $this->db->get();
		$data = $res->row_array();
		return $data['do_no']; 
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
	public function get_stock_transfer_invoices($from_date, $to_date, $plant_id)
	{
		$this->db->select('ri.receipt_invoice_id,sr.stock_receipt_id,ri.invoice_id,i.invoice_date,i.invoice_number,p.name as plant_name, p.short_name as plant_short_name');
		$this->db->from('stock_receipt sr');
		$this->db->join('receipt_invoice ri','sr.stock_receipt_id = ri.stock_receipt_id');
		$this->db->join('invoice i','i.invoice_id = ri.invoice_id');
		$this->db->join('invoice_do id','id.invoice_id = i.invoice_id');
		$this->db->join('order o','o.order_id = id.order_id');
		$this->db->join('plant_order po','po.order_id = o.order_id');
		$this->db->join('plant p','p.plant_id = po.plant_id');
		if($plant_id!='')
		{
			$this->db->where('sr.plant_id',$plant_id);
		}
		if($from_date!='')
		{
			$this->db->where('sr.on_date >=',$from_date);
		}
		if($to_date!='')
		{
			$this->db->where('sr.on_date <=',$to_date);
		}
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_stock_receive_products($receipt_invoice_id)
	{
		$this->db->select('p.short_name as product_name,
						   rip.invoice_quantity,
						   rip.received_quantity,
						   (rip.received_quantity*idp.items_per_carton*dop.product_price) as total_price,
						   (rip.received_quantity*idp.items_per_carton*p.oil_weight) as total_oil_weight');
		$this->db->from('receipt_invoice_product rip');
		$this->db->join('invoice_do_product idp','idp.invoice_do_product_id = rip.invoice_do_product_id');
		$this->db->join('do_order_product dop','dop.do_ob_product_id = idp.do_ob_product_id');
		$this->db->join('product p','p.product_id = rip.product_id');
		$this->db->where('rip.receipt_invoice_id',$receipt_invoice_id);
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_invoice_do_number($invoice_id)
	{
		$this->db->select('GROUP_CONCAT(DISTINCT d.do_number SEPARATOR ",") as do_no');
		$this->db->from('invoice i');
		$this->db->join('invoice_do id','id.invoice_id = i.invoice_id');
		$this->db->join('do d','d.do_id = id.do_id');
		$this->db->where('i.invoice_id',$invoice_id);
		$this->db->distinct('id.invoice_id');
		$res = $this->db->get();
		$data = $res->row_array();
		return $data['do_no']; 
	}
	    
}