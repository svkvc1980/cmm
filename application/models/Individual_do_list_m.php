<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Individual_do_list_m extends CI_Model {

	public function get_individual_dist_do($do_no)
	{
		$this->db->select('do.do_date, do.do_number, pr.name as product, p.name as lifting_point, d.agency_name as distributor, d.distributor_code as dist_code, dop.quantity, dop.pending_qty, dop.product_price,dop.items_per_carton,o.order_number,o.order_date');
		$this->db->from('do do');
		$this->db->join('do_order dor', 'dor.do_id = do.do_id');
		$this->db->join('do_order_product dop', 'dop.do_ob_id = dor.do_ob_id');
		$this->db->join('order o', 'o.order_id = dor.order_id');
		$this->db->join('plant p', 'do.lifting_point = p.plant_id');
		$this->db->join('product pr', 'pr.product_id = dop.product_id');
		$this->db->join('distributor_order dio', 'dio.order_id = dor.order_id');
		$this->db->join('distributor d', 'd.distributor_id = do.do_distributor_id');
		$this->db->where('do.do_number', $do_no);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_individual_unit_do($do_no)
	{
		$this->db->select('do.do_date, do.do_number, pr.name as product, p.name as lifting_point, p1.name as plant, dop.quantity, dop.pending_qty, dop.product_price,dop.items_per_carton,o.order_number,o.order_date');
		$this->db->from('do do');
		$this->db->join('do_order dor', 'do.do_id = dor.do_id');
		$this->db->join('do_order_product dop', 'dor.do_ob_id = dop.do_ob_id');
		$this->db->join('order o', 'o.order_id = dor.order_id');
		$this->db->join('plant_order po', 'po.order_id = o.order_id');
		$this->db->join('plant p', 'p.plant_id = do.lifting_point');
		$this->db->join('plant p1', 'po.plant_id = p1.plant_id');
		$this->db->join('product pr', 'pr.product_id = dop.product_id');
		$this->db->where('do.do_number', $do_no);
		$this->db->group_by('dop.product_id');
		$res = $this->db->get();
		return $res->result_array();
	}
}