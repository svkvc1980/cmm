<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Coupon_model extends CI_Model {

	public function coupon_results($current_offset, $per_page, $searchParams)
	{
		$this->db->select('c.*');
		$this->db->from('coupon c');
		if($searchParams['name']!='')
            $this->db->like('c.name',$searchParams['name']);
		if($searchParams['start_date']!='')
            $this->db->where('c.start_date >=',$searchParams['start_date']);
        if($searchParams['end_date']!='')
            $this->db->where('c.end_date <=',$searchParams['end_date']);
        $this->db->order_by('c.coupon_id','DESC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();
		return $res->result_array();
	}
	
	public function coupon_total_num_rows($searchParams)
	{
		$this->db->select('c.*');
		$this->db->from('coupon c');
		if($searchParams['name']!='')
            $this->db->like('c.name',$searchParams['name']);
		if($searchParams['start_date']!='')
            $this->db->where('c.start_date >=',$searchParams['start_date']);
        if($searchParams['end_date']!='')
            $this->db->where('c.end_date <=',$searchParams['end_date']);
		$res = $this->db->get();
		return $res->num_rows();
	}
	
	public function coupon_details($searchParams)
	{
		$this->db->select('c.*');
		$this->db->from('coupon c');
		if($searchParams['name']!='')
            $this->db->like('c.name',$searchParams['name']);
		if($searchParams['start_date']!='')
            $this->db->where('c.start_date >=',$searchParams['start_date']);
        if($searchParams['end_date']!='')
            $this->db->where('c.end_date <=',$searchParams['end_date']);
        $this->db->order_by('c.coupon_id','DESC');
		$res = $this->db->get();
		return $res->result_array();
	}

	public function check_coupon_dates($start_date,$end_date)
	{
		$this->db->select('c.*');
		$this->db->from('coupon c');
		$this->db->where('c.start_date',$start_date);
		$this->db->where('c.end_date',$end_date);
		$res=$this->db->get();
		return $res->num_rows();
	}

	public function get_dist_sales_daily_report($from_date,$to_date,$executive_id,$loose_oil_id)
	{
		$this->db->select('i.invoice_number  as invoice_number,i.invoice_date ,(idop.quantity) as quantity,
			(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount,dist.distributor_id,dist.distributor_code,dist.agency_name,l.name as location_name,p.name as product_name,p.product_id');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('product_pm_weight ppw','p.product_id = ppw.product_id','left');
		$this->db->join('do d','d.do_id = ido.do_id ');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->join('order ord','ord.order_id = ido.order_id');
		//$this->db->join('distributor_order dio','dio.order_id=do.order_id');
		$this->db->join('distributor dist','dist.distributor_id=d.do_distributor_id');
		$this->db->join('executive e','dist.executive_id=e.executive_id');
		$this->db->join('location l','dist.location_id = l.location_id');
		$this->db->where('ord.type',1);
		//$this->db->where('dist.distributor_id',$dist_id);	
		$this->db->where('i.invoice_date >=',$from_date);
		$this->db->where('i.invoice_date >=',$to_date);
		if($executive_id !='')
		{
			$this->db->where('e.executive_id',$executive_id);
		}
		if($loose_oil_id !='')
		{
			$this->db->where('p.loose_oil_id',$loose_oil_id);
		}	
		//$this->db->where('i.plant_id',$plant_id);
		$this->db->group_by('i.invoice_number');
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_coupon_amount($from_date,$to_date)
	{
		$this->db->select('*');
		$this->db->from('coupon');
		$this->db->where('start_date <=',$from_date);
		$this->db->where('start_date <=',$to_date);
		$this->db->where('end_date >=',$from_date);
		$this->db->where('end_date >=',$to_date);
		$this->db->order_by('coupon_id');
		$this->db->limit('1');
		$res=$this->db->get();
		return $res->row_array();
	}
}