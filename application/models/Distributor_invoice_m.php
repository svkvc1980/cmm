<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by maruthi on 21th Feb 2017 9:00AM
*/

class Distributor_invoice_m extends CI_Model {
        public function get_distributor_ids($do_numbers)
	{
		$this->db->select('disto.distributor_id');
		$this->db->from('do d');
		$this->db->join('do_order doo','doo.do_id = d.do_id');
		$this->db->join('order o','o.order_id = doo.order_id');
		$this->db->join('distributor_order disto','disto.order_id = o.order_id');
		$this->db->where_in('do_number',$do_numbers);
		$res = $this->db->get();
		return $res->result_array();

	}


	public function get_do_details($do_number)
	{
		$this->db->select('d.*');
		$this->db->from('do d');
		/*$this->db->join('do_order doo','d.do_id = doo.do_id');
		$this->db->join('order o','o.order_id = doo.order_id');
		$this->db->join('distributor_order disto','disto.order_id = o.order_id');*/
		$this->db->where('d.lifting_point',get_plant_id());
		$this->db->where('d.do_number',$do_number);
		$this->db->order_by('d.do_id','DESC');
		$this->db->limit('1');
		$res = $this->db->get();
		return $res->row_array();
	}
	
	public function get_do_products($do_number)
	{
		$this->db->select('ptp.quantity as stock_qty,p.name as product_name,p.product_id as product_id,p.items_per_carton as p_items_per_carton,
			d.do_number,d.do_date,dop.quantity as do_quantity, dop.pending_qty,
			pt.plant_id as stock_lifting_id,pt.name as stock_lifting_point,
			(dop.product_price) as price, doo.order_id, dop.do_ob_product_id');
		$this->db->from('do d');
		$this->db->join('do_order doo','d.do_id = doo.do_id');
		$this->db->join('do_order_product dop','doo.do_ob_id = dop.do_ob_id');
		$this->db->join('product p','dop.product_id = p.product_id');		
		//$this->db->join('order disto','disto.order_id = doo.order_id');
		//$this->db->join('order_product distop','distop.order_id = doo.order_id AND dop.product_id = distop.product_id');		
		$this->db->join('plant pt','pt.plant_id = d.lifting_point');
		$this->db->join('plant_product ptp','p.product_id = ptp.product_id AND ptp.plant_id = d.lifting_point','left');		
		$this->db->where('d.do_number',$do_number);
		$this->db->where('d.lifting_point',get_plant_id());
		$this->db->where('dop.status<=',2); // 1-pending, 2-invoice partial
		//$this->db->group_by('ptp.product_id'); // check this condition for
		// when have 3 same products in different obs
		$res = $this->db->get();
		//echo $this->db->last_query();exit;
		if($res->num_rows()>0)
		{
			return $res->result_array();
		}
		
	}
	public function get_invoice_dos($invoice_id)
	{
		$this->db->select('d.*');
		$this->db->from('invoice_do ido');
		$this->db->join('do d','d.do_id = ido.do_id');
		$this->db->where('ido.invoice_id',$invoice_id);
		$this->db->group_by('ido.do_id');
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_invoice_obs($invoice_id)
	{
		$this->db->select('o.*');
		$this->db->from('invoice_do ido');
		$this->db->join('order o','o.order_id = ido.order_id');
		$this->db->where('ido.invoice_id',$invoice_id);
		$this->db->group_by('ido.order_id');
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_invoice_products($invoice_id)
	{
		$block_id = $this->session->userdata('block_id');
		$this->db->select('l.name as location_name,i.*,
			dist.*,dist.address as dist_address,p.name as product_name,p.short_name as short_name,idop.quantity as carton_qty,
			(idop.quantity*idop.items_per_carton) as packets,(idop.quantity*idop.items_per_carton*p.oil_weight) as qty_in_kg,
			(idop.quantity*ppw.weight) as pm_weight,
			(dop.product_price) as rate,idop.items_per_carton,idop.quantity,						
			(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('product_pm_weight ppw','p.product_id = ppw.product_id','left');
		//$this->db->join('plant_product ptp','p.product_id = ptp.product_id');
		//$this->db->join('do d','d.do_id = ido.do_id');
		//$this->db->join('do_order doo','d.do_id =doo.do_id');
		//$this->db->join('order disto','disto.order_id=doo.order_id');
		$this->db->join('do d','d.do_id = ido.do_id ');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		//$this->db->join('plant_order po','po.order_id = o.order_id');
		$this->db->join('distributor_order dio','dio.order_id=do.order_id');
		$this->db->join('distributor dist','dist.distributor_id=dio.distributor_id');

		if($block_id!=1)
		{
			$this->db->where('d.lifting_point',get_plant_id());
		}
		//$this->db->join('order_product op','op.order_id = ido.order_id AND op.product_id=idop.product_id');		
		//$this->db->join('plant pt','pt.plant_id = disto.lifting_point');
		$this->db->join('location l','dist.location_id = l.location_id');
		//$this->db->group_by('p.product_id');
		$this->db->where('i.invoice_id',$invoice_id);
		$res = $this->db->get();
		//echo $this->db->last_query();exit;

		return $res->result_array();
	}

	public function dist_invoice_results($current_offset, $per_page, $search_params)
	{	
		$block_id = $this->session->userdata('block_id');			
		$this->db->select('i.*,sum(idp.quantity*idp.items_per_carton*dop.product_price) as invoice_amount,DATE(i.created_time) as time,dis.distributor_code,dis.agency_name,dis.distributor_place, ip.short_name as lifting_point');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','ido.invoice_id = i.invoice_id');
		$this->db->join('invoice_do_product idp','idp.invoice_do_id = ido.invoice_do_id');
		$this->db->join('do_order_product dop','dop.do_ob_product_id = idp.do_ob_product_id');
		$this->db->join('order o','o.order_id = ido.order_id');
		$this->db->join('do d','d.do_id = ido.do_id');
		$this->db->join('distributor_order do','do.order_id = o.order_id');
		$this->db->join('distributor dis','dis.distributor_id = d.do_distributor_id');
		$this->db->join('plant ip','ip.plant_id = i.plant_id');
		$this->db->where('o.type',1);
		if($block_id!=1)
		{
			$this->db->where('i.plant_id',get_plant_id());
		}
		
		if($search_params['invoice_number']!='')
			$this->db->where('i.invoice_number',$search_params['invoice_number']);	
		if($search_params['distributor_id']!='')
			$this->db->where('dis.distributor_id',$search_params['distributor_id']);	
		if($search_params['from_date']!='')
			$this->db->where('i.invoice_date >=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('i.invoice_date <=',$search_params['to_date']);		
		$this->db->order_by('i.invoice_id','DESC');	
		$this->db->group_by('ido.invoice_id');
		$this->db->limit($per_page, $current_offset);		
		$res = $this->db->get();
		return $res->result_array();
		
	}
	
	public function dist_invoice_total_num_rows($search_params)
	{
		$block_id = $this->session->userdata('block_id');			
		$this->db->select('i.*,DATE(i.created_time) as time,concat(dis.distributor_code, " -(" ,dis.agency_name,")") as agency_name');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','ido.invoice_id = i.invoice_id');
		$this->db->join('do d','d.do_id = ido.do_id');
		$this->db->join('do_order doo','doo.do_id = ido.do_id');
		$this->db->join('order o','o.order_id = doo.order_id');
		$this->db->join('distributor_order do','do.order_id = o.order_id');
		$this->db->join('distributor dis','dis.distributor_id = d.do_distributor_id');
		//$this->db->join('distributor_order disto','disto.order_id = o.order_id');
		if($block_id!=1)
		{
			$this->db->where('d.lifting_point',get_plant_id());
		}
		if($search_params['invoice_number']!='')
			$this->db->where('i.invoice_number',$search_params['invoice_number']);	
		if($search_params['distributor_id']!='')
			$this->db->where('dis.distributor_id',$search_params['distributor_id']);	
		if($search_params['from_date']!='')
			$this->db->where('i.invoice_date >=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('i.invoice_date <=',$search_params['to_date']);	
		$this->db->order_by('i.invoice_id','DESC');	
		$this->db->group_by('ido.invoice_id');
		$res = $this->db->get();
		//echo $res->num_rows();exit;
		return $res->num_rows();
	}
	
	public function dist_invoice_details($search_params)
	{	
		$block_id = $this->session->userdata('block_id');			
		$this->db->select('i.*,sum(idp.quantity*idp.items_per_carton*dop.product_price) as invoice_amount,DATE(i.created_time) as time,dis.distributor_code,dis.agency_name,dis.distributor_place, ip.short_name as lifting_point, sum(idp.quantity*idp.items_per_carton*p.oil_weight) as invoice_weight');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','ido.invoice_id = i.invoice_id');
		$this->db->join('invoice_do_product idp','idp.invoice_do_id = ido.invoice_do_id');
		$this->db->join('do d','d.do_id = ido.do_id');
		$this->db->join('do_order_product dop','dop.do_ob_product_id = idp.do_ob_product_id');
		$this->db->join('order o','o.order_id = ido.order_id');
		$this->db->join('distributor_order do','do.order_id = o.order_id');
		$this->db->join('distributor dis','dis.distributor_id = d.do_distributor_id');
		$this->db->join('plant ip','ip.plant_id = i.plant_id');
		$this->db->join('product p','p.product_id = idp.product_id');
		$this->db->where('o.type',1);
		if($block_id!=1)
		{
			$this->db->where('i.plant_id',get_plant_id());
		}
		if($search_params['invoice_number']!='')
			$this->db->where('i.invoice_number',$search_params['invoice_number']);	
		if($search_params['distributor_id']!='')
			$this->db->where('dis.distributor_id',$search_params['distributor_id']);	
		if($search_params['from_date']!='')
			$this->db->where('i.invoice_date >=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('i.invoice_date <=',$search_params['to_date']);	
		$this->db->order_by('i.invoice_date ASC, i.invoice_number ASC');	
		$this->db->group_by('i.invoice_id');		
		$res = $this->db->get();
		return $res->result_array();
	}
	
	//mahesh 5th Mar 2017 04:20 pm
	public function updateDOStatus($do_id)
	{
		if($do_id!='')
		{
			// get order products length
			$this->db->select('count(*) as dop_count');
			$this->db->from('do_order_product dop');
			$this->db->join('do_order do','do.do_ob_id=dop.do_ob_id');
			$this->db->where('do.do_id',$do_id);
			$res = $this->db->get();
			$row = $res->row_array();
			$dop_count = $row['dop_count'];

			// get DO Full raised order products length
			$this->db->select('count(*) as do_full_op_count');
			$this->db->from('do_order_product dop');
			$this->db->join('do_order do','do.do_ob_id=dop.do_ob_id');
			$this->db->where('do.do_id',$do_id);
			$this->db->where('dop.status>=',3); // full invoice raised do products
			$res = $this->db->get();
			$row = $res->row_array();
			$do_full_op_count = $row['do_full_op_count'];

			$status = ($do_full_op_count == $dop_count)?3:2;
			// update order status
			$data = array('status'=>$status,'modified_by'=>$this->session->userdata('user_id'),'modified_time'=>date('Y-m-d H:i:s'));
			$where = array('do_id'=>$do_id);
			$this->db->update('do',$data,$where);
		}
	}

	public function get_distributor_schemes()
	{
		$this->db->select('st.name as scheme_type,fgs.*');
		$this->db->from('free_gift_scheme fgs');
		$this->db->join('scheme_type st','st.type_id=fgs.type_id');
		//$this->db->where('fgs.type_id>=',1);
		$this->db->where('fgs.start_date<=',date('Y-m-d'));
		$this->db->where('fgs.end_date>=',date('Y-m-d'));
		$res = $this->db->get();
		if($res->num_rows()>0)
		{
			return $res->result_array();
		}
	}

	public function get_schemes($fg_scheme_id)
	{
		$this->db->select('st.name as scheme_type,fgs.*');
		$this->db->from('free_gift_scheme fgs');
		$this->db->join('scheme_type st','st.type_id=fgs.type_id');
		//$this->db->where('fgs.type_id>=',1);
		$this->db->where('fgs.start_date<=',date('Y-m-d'));
		$this->db->where('fgs.end_date>=',date('Y-m-d'));
		$this->db->where('fgs.fg_scheme_id',$fg_scheme_id);
		$res = $this->db->get();
		if($res->num_rows()>0)
		{
			return $res->result_array();
		}
	}

	// mahesh 6th Mar 2017 06:53 pm
	public function get_scheme_products($scheme_id,$products)
	{
		if($scheme_id!=''&&count($products)>0)
		{
			$this->db->select('fgsp.*,p.name as product_name,p.items_per_carton');
			$this->db->from('free_gift_scheme fgs');
			$this->db->join('fg_scheme_product fgsp','fgs.fg_scheme_id=fgsp.fg_scheme_id');
			$this->db->join('product p','p.product_id=fgsp.product_id');
			$this->db->where('fgs.fg_scheme_id',$scheme_id);
			$this->db->where_in('fgsp.product_id',$products);
			$res = $this->db->get();
			return $res->result_array();
		}
	}

	// mahesh 6th Mar 2017 06:53 pm
	public function get_scheme_gift_product($fgs_product_id,$gift_type)
	{
		if($fgs_product_id!=''&&$gift_type)
		{
			switch($gift_type)
			{
				case 1:
					$this->db->select('sfp.*,p.name as free_product,p.items_per_carton');
					$this->db->from('fgs_free_product sfp');
					$this->db->join('product p','sfp.product_id=p.product_id');
					$this->db->where('sfp.fgs_product_id',$fgs_product_id);
					//$this->db->where('sfp.gift_type_id',$gift_type);
					$res = $this->db->get();
					return $res->row_array();
				break;
				case 2:
					$this->db->select('sfg.*,fg.name as free_product');
					$this->db->from('fgs_free_gift sfg');
					$this->db->join('free_gift fg','sfg.free_gift_id=fg.free_gift_id');
					$this->db->where('sfg.fgs_product_id',$fgs_product_id);
					//$this->db->where('sfg.gift_type_id',$gift_type);
					$res = $this->db->get();
					return $res->row_array();
				break;
			}
			
		}
	}
	public function get_free_products($invoice_id)
	{
		$this->db->select('ifp.*,sc.name as scheme_type,p.name as product_name,fgs.name as scheme_name');
		$this->db->from('invoice_scheme ism');
		$this->db->join('invoice_free_product ifp','ifp.invoice_scheme_id = ism.invoice_scheme_id');
		$this->db->join('free_gift_scheme fgs','fgs.fg_scheme_id = ism.fg_scheme_id');
		$this->db->join('scheme_type sc','sc.type_id = fgs.type_id');
		$this->db->join('product p','p.product_id = ifp.product_id');
		$this->db->where('ism.invoice_id',$invoice_id);
		$res = $this->db->get();
		if($res->num_rows()>0)
			return $res->result_array();		
	}
	public function get_free_gifts($invoice_id)
	{
		$this->db->select('ifg.*,sc.name as scheme_type,fg.name as free_gift_name,fgs.name as scheme_name');
		$this->db->from('invoice_scheme ism');
		$this->db->join('invoice_free_gift ifg','ifg.invoice_scheme_id = ism.invoice_scheme_id');
		$this->db->join('free_gift_scheme fgs','fgs.fg_scheme_id = ism.fg_scheme_id');
		$this->db->join('scheme_type sc','sc.type_id = fgs.type_id');
		$this->db->join('free_gift fg','fg.free_gift_id = ifg.free_gift_id');
		$this->db->where('ism.invoice_id',$invoice_id);
		$res = $this->db->get();
		if($res->num_rows()>0)
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