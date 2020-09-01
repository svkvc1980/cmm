<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tally_model extends CI_Model 
{


	public function get_invoice_tally_results($from_date,$to_date)
	{
		$this->db->select('i.invoice_number,i.invoice_date,p.loose_oil_id as loose_oil_id,p.product_code as product_code,idop.quantity,(idop.quantity*idop.items_per_carton*p.oil_weight) as qty_in_kg,((idop.quantity*idop.items_per_carton*p.oil_weight)/1000) as mt_in_kg,(idop.quantity*idop.items_per_carton) as no_of_pouches,dop.product_price,
			(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount,dist.distributor_code,d.do_number,d.do_date,ord.type,i.plant_id as lifting_point,dist.agency_name,lo.loose_oil_code,pl.tally_code');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('loose_oil lo','p.loose_oil_id=lo.loose_oil_id');
		$this->db->join('product_pm_weight ppw','p.product_id = ppw.product_id','left');
		$this->db->join('do d','d.do_id = ido.do_id ');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->join('order ord','ord.order_id = ido.order_id');
		//$this->db->join('distributor_order dio','dio.order_id=do.order_id');
		$this->db->join('distributor dist','dist.distributor_id=d.do_distributor_id','left');
		$this->db->join('plant pl','i.plant_id=pl.plant_id');
		
		$this->db->join('location l','dist.location_id = l.location_id');
		$this->db->where('ord.type',1);
		$this->db->where('i.invoice_date >=',$from_date);
		$this->db->where('i.invoice_date <=',$to_date);
		$this->db->order_by('i.invoice_date, i.invoice_number');
		$res = $this->db->get();
		return $res->result_array();
	}
}