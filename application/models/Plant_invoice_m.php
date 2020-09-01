<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by maruthi on 21th Feb 2017 9:00AM
*/

class Plant_invoice_m extends CI_Model {

	public function get_do_details($do_number)
	{
		$this->db->select('d.*');
		$this->db->from('do d');
		$this->db->join('do_order doo','d.do_id = doo.do_id');
		//$this->db->join('order o','o.order_id = doo.order_id');
		$this->db->join('plant_order po','po.order_id = doo.order_id');
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
			d.do_number,d.do_date,dop.quantity as do_quantity,
			pt.plant_id as stock_lifting_id,pt.name as stock_lifting_point,
			(dop.product_price) as price, doo.order_id, dop.do_ob_product_id');
		$this->db->from('do d');
		$this->db->join('do_order doo','d.do_id = doo.do_id');
		$this->db->join('do_order_product dop','doo.do_ob_id = dop.do_ob_id');
		$this->db->join('product p','dop.product_id = p.product_id');
		
		$this->db->join('order disto','disto.order_id = doo.order_id');
		$this->db->join('order_product distop','distop.order_id = doo.order_id AND dop.product_id = distop.product_id');		
		$this->db->join('plant pt','pt.plant_id = disto.lifting_point');		
		$this->db->join('plant_product ptp','p.product_id = ptp.product_id AND ptp.plant_id = disto.lifting_point');		
		$this->db->where('d.do_number',$do_number);
		$this->db->where('d.lifting_point',get_plant_id());
		$this->db->where('dop.status<=',2); // 1-pending, 2-invoice partial
		$this->db->group_by('ptp.product_id'); // check this condition for
		// when have 3 same products in different obs
		$res = $this->db->get();
		//echo $this->db->last_query();exit;
		return $res->result_array();
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
	public function get_invoice_products($invoice_id)
	{
		$block_id = $this->session->userdata('block_id');
		/*$this->db->select('i.*,po.plant_id as receiving_plant_id,p.name as product_name,idop.quantity as carton_qty,(idop.quantity*idop.items_per_carton) as packets,(idop.quantity*idop.items_per_carton*p.oil_weight) as qty_in_kg,
			(op.unit_price+op.add_price) as rate,idop.items_per_carton,						
			(idop.quantity*idop.items_per_carton*(op.unit_price+op.add_price)) as amount');*/
		$this->db->select('i.*,po.plant_id as receiving_plant_id,p.name as product_name,p.short_name as short_name,idop.quantity as carton_qty,
			(idop.quantity*idop.items_per_carton) as packets,(idop.quantity*idop.items_per_carton*p.oil_weight) as qty_in_kg,
			(idop.quantity*ppw.weight) as pm_weight,
			(dop.product_price) as rate,idop.items_per_carton,idop.quantity,						
			(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('product_pm_weight ppw','p.product_id = ppw.product_id','left');	
		$this->db->join('do d','d.do_id = ido.do_id');
		$this->db->join('do_order do','do.do_id = d.do_id');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->join('plant_order po','po.order_id = do.order_id');
		if($block_id!=1)
		{
		$this->db->where('d.lifting_point',get_plant_id());
		}
		$this->db->where('i.invoice_id',$invoice_id);
		$res = $this->db->get();
		//echo $this->db->last_query();exit;

		return $res->result_array();
	}

	public function plant_invoice_results($current_offset, $per_page, $search_params)
	{	
		$block_id = $this->session->userdata('block_id');			
		$this->db->select('i.*,sum(idp.quantity*idp.items_per_carton*dop.product_price) as invoice_amount,p.name as plant_name, ip.short_name as lifting_point');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','ido.invoice_id = i.invoice_id');
		$this->db->join('invoice_do_product idp','idp.invoice_do_id = ido.invoice_do_id');
		$this->db->join('do_order_product dop','dop.do_ob_product_id = idp.do_ob_product_id');
		$this->db->join('order o','o.order_id = ido.order_id');
		$this->db->join('plant_order po','po.order_id = ido.order_id');
		$this->db->join('plant p','p.plant_id = po.plant_id');
		$this->db->join('plant ip','ip.plant_id = i.plant_id');
		$this->db->where('o.type',2);
		/* if($block_id!=1)
		{
		$this->db->where('d.lifting_point',get_plant_id());
		} */
		if($search_params['plant_id']!='')
			$this->db->where('p.plant_id',$search_params['plant_id']);
		if($search_params['invoice_number']!='')
			$this->db->where('i.invoice_number',$search_params['invoice_number']);		
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
	
	public function plant_invoice_total_num_rows($search_params)
	{
		$block_id = $this->session->userdata('block_id');		
		$this->db->select('');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','ido.invoice_id = i.invoice_id');		
		$this->db->join('do d','d.do_id = ido.do_id');
		$this->db->join('plant_order po','po.order_id = ido.order_id');
		$this->db->join('plant p','p.plant_id = po.plant_id');
		/* if($block_id!=1)
		{
		$this->db->where('d.lifting_point',get_plant_id());
		} */
		if($search_params['plant_id']!='')
			$this->db->where('p.plant_id',$search_params['plant_id']);
		if($search_params['invoice_number']!='')
			$this->db->where('i.invoice_number',$search_params['invoice_number']);		
		if($search_params['from_date']!='')
			$this->db->where('i.invoice_date >=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('i.invoice_date <=',$search_params['to_date']);		
		$this->db->order_by('i.invoice_id','DESC');	
		$this->db->group_by('ido.invoice_id');	
		$res = $this->db->get();
		return $res->num_rows();
	}
	
	public function plant_invoice_details($search_params)
	{
		$block_id = $this->session->userdata('block_id');		
		$this->db->select('i.*,sum(idp.quantity*idp.items_per_carton*dop.product_price) as invoice_amount,p.name as plant_name, ip.short_name as lifting_point, sum(idp.quantity*idp.items_per_carton*pr.oil_weight) as invoice_weight');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','ido.invoice_id = i.invoice_id');
		$this->db->join('invoice_do_product idp','idp.invoice_do_id = ido.invoice_do_id');
		$this->db->join('do_order_product dop','dop.do_ob_product_id = idp.do_ob_product_id');
		$this->db->join('order o','o.order_id = ido.order_id');
		$this->db->join('plant_order po','po.order_id = ido.order_id');
		$this->db->join('plant p','p.plant_id = po.plant_id');
		$this->db->join('plant ip','ip.plant_id = i.plant_id');
		$this->db->join('product pr','pr.product_id = idp.product_id');
		$this->db->where('o.type',2);
		/* if($block_id!=1)
		{
		$this->db->where('d.lifting_point',get_plant_id());
		} */
		if($search_params['plant_id']!='')
			$this->db->where('p.plant_id',$search_params['plant_id']);
		if($search_params['invoice_number']!='')
			$this->db->where('i.invoice_number',$search_params['invoice_number']);		
		if($search_params['from_date']!='')
			$this->db->where('i.invoice_date >=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('i.invoice_date <=',$search_params['to_date']);		
		$this->db->order_by('i.invoice_date ASC, i.invoice_number ASC');	
		$this->db->group_by('i.invoice_id');		
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_plant_list()
	    {
	    	$blocks = array(2,3,4);
	    	$this->db->select('p.plant_id,p.name');
	    	$this->db->from('plant p');
	    	$this->db->join('plant_block pb','p.plant_id= pb.plant_id');
	    	$this->db->where('p.status',1);
	    	$this->db->where_in('pb.block_id',$blocks);
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

	public function get_plant_schemes()
	{
		$this->db->select('st.name as scheme_type,fgs.*');
		$this->db->from('free_gift_scheme fgs');
		$this->db->join('scheme_type st','st.type_id=fgs.type_id');
		//$this->db->where('fgs.type_id>',1);
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
}