<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Penalty_reports_m extends CI_Model {

	public function get_distributor_ids($search_params)
	{
		$this->db->select('pen.distributor_id');
		$this->db->from('dist_ob_penalty pen');		
		if($search_params['fromDate']!='')
			$this->db->where('pen.penalty_date>=',$search_params['fromDate']);
		if($search_params['toDate']!='')
			$this->db->where('pen.penalty_date<=',$search_params['toDate']);
		if(@$search_params['days']!='')
			$this->db->where('pen.penalty_day',$search_params['days']);
		if(get_ses_block_id() == 1)
		{ 
			if(@$search_params['distributor_id']!='')
				$this->db->where('pen.distributor_id',@$search_params['distributor_id']);
		}
		else
		{
			if(@$search_params['distributor_id']!='')
				$this->db->where('pen.distributor_id',@$search_params['distributor_id']);
			$this->db->join('order o','o.order_id = pen.order_id');
			$this->db->where('o.lifting_point',get_plant_id());
		}
		$this->db->group_by('pen.distributor_id');		
		$res = $this->db->get();
		/*echo '<pre>';
		echo $this->db->last_query();//exit;
		 echo '<pre>'; print_r($res->result_array());exit;*/
		return $res->result_array();
	}

	public function get_penalty_data($distributor_id,$search_params)
	{
		$this->db->select('pen.*,op.items_per_carton');
		$this->db->from('dist_ob_penalty pen');		
		$this->db->where('pen.distributor_id',$distributor_id);
		if($search_params['fromDate']!='')
			$this->db->where('pen.penalty_date>=',$search_params['fromDate']);
		if($search_params['toDate']!='')
			$this->db->where('pen.penalty_date<=',$search_params['toDate']);
		if(@$search_params['days']!='')
			$this->db->where('pen.penalty_day',$search_params['days']);
		$this->db->join('order o','o.order_id = pen.order_id');
		$this->db->join('order_product op','pen.order_id = op.order_id AND pen.product_id = op.product_id');
		if(get_ses_block_id() == 1)
		{ 
			
		}
		else
		{			
			
			$this->db->where('o.lifting_point',get_plant_id());
		}		
		$this->db->order_by('pen.penalty_day ASC');
		$res = $this->db->get();
		/*echo $this->db->last_query();
		echo '<pre>'; print_r($res->result_array());exit;*/
		return $res->result_array();
	}
	public function consolidated_get_penalty_data($distributor_id)
	{
		$this->db->select('sum(total_amount) as consolidated_penalty');
		$this->db->from('dist_ob_penalty pen');		
		$this->db->where('pen.distributor_id',$distributor_id);	
		if(get_ses_block_id() == 1)
		{ 
			
		}
		else
		{			
			$this->db->join('order o','o.order_id = pen.order_id');
			$this->db->where('o.lifting_point',get_plant_id());
		}	
		$this->db->order_by('pen.penalty_day ASC');
		$res = $this->db->get();
		/*echo $this->db->last_query();
		echo '<pre>'; print_r($res->result_array());exit;*/
		return $res->result_array();
	}
	public function get_bank_guarantee_details($distributor_id)
	{
	    $this->db->select('b.name as bank_name,bg.start_date,bg.end_date,bg.bg_amount');
	    $this->db->from('bank_guarantee bg');
	    $this->db->join('bank b','b.bank_id = bg.bank_id');
	    $this->db->where('bg.distributor_id',$distributor_id);
        $res = $this->db->get();
		return $res->result_array();
	}

	# Get Ordered product Details
	public function getOrderedProductDetails($distributor_id,$stock_lifting_unit_id,$ob_type_id)
	{
	    $this->db->select('p.name as product_name,op.items_per_carton,op.unit_price,op.add_price,op.quantity as ordered_quantity');
	    $this->db->from('order_product op');
	    $this->db->join('distributor_order do','do.order_id = op.order_id','left');
	    $this->db->join('product p','p.product_id = op.product_id','left');
	    $this->db->where('do.distributor_id',$distributor_id);
	    $this->db->where('do.lifting_point',$stock_lifting_unit_id);
	    $this->db->where('do.ob_type_id',$ob_type_id);
	    $this->db->where('do.status',1);
        $res = $this->db->get();
		return $res->result_array();
	}

	# Get Distributor Order Details
	public function get_orderedProducts($order_id)
	{
	    $this->db->select('	p.product_id,p.name as product_name,op.quantity as ordered_quantity,op.unit_price,op.add_price,op.items_per_carton,op.pending_qty');
	    $this->db->from('order_product op');
	    $this->db->join('product p','p.product_id = op.product_id','left');
	    /*$this->db->join('do_order do','do.order_id = op.order_id','left');
	    $this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.product_id = op.product_id','left');
	    $this->db->group_by('do.order_id');*/
	    $this->db->where('op.order_id',$order_id);
	    $this->db->where('op.status<=',2);
        $res = $this->db->get();
		return $res->result_array();
	}

	# Get DO Total Num Rows
	public function distributor_do_num_rows($search_params)
	{
		$block_id = $this->session->userdata('block_id');
		$plant_id = $this->session->userdata('ses_plant_id');	
		$this->db->select();
		$this->db->from('do d');
		$this->db->join('do_order doo','d.do_id = doo.do_id');
		$this->db->join('order disto','disto.order_id = doo.order_id');
		$this->db->join('do_order_product dop','doo.do_ob_id = dop.do_ob_id');
		$this->db->join('product p','dop.product_id = p.product_id');		
		$this->db->join('distributor_order do','disto.order_id = do.order_id');
		$this->db->join('distributor dis','dis.distributor_id = do.distributor_id');		
		$this->db->join('plant pt','pt.plant_id = d.lifting_point');
		$this->db->join('user u','u.user_id = d.created_by','left');

		if($search_params['executive']!='')
			$this->db->where('dis.executive_id',$search_params['executive']);
		if($search_params['do_number']!='')
			$this->db->like('d.do_number',$search_params['do_number']);
		if($search_params['order_type_id']!='')
			$this->db->where('disto.ob_type_id',$search_params['order_type_id']);
		if($search_params['distributor_id']!='')
			$this->db->where('do.distributor_id',$search_params['distributor_id']);
		if($search_params['product_id']!='')
			$this->db->where('dop.product_id',$search_params['product_id']);
		/*if($block_id == 1)
		{
			if($search_params['lifting_point_id']!='')
			$this->db->where('d.lifting_point',$search_params['lifting_point_id']);
		}
		else
		{
			$this->db->where('d.lifting_point',$plant_id);
		}*/
		if($block_id != 2) // If it is not OPS
		{
			if($block_id == 1) // If it is Head Office
			{
				if($search_params['lifting_point_id']!='')
				{
					$this->db->where('d.lifting_point',$search_params['lifting_point_id']);
				}
			}
			else
			{
				if($search_params['lifting_point_id']!='')
				{
					$this->db->where('d.lifting_point = "'.$search_params['lifting_point_id'].'" AND u.plant_id = "'.get_plant_id().'"');
				}
				else{ // ** to display dos which are raised by SP or lifting point be the SP
					$this->db->where('(d.lifting_point = "'.get_plant_id().'" OR u.plant_id = "'.get_plant_id().'")');
				}
			}
			
		}
		else
		{
			$this->db->where('d.lifting_point',$plant_id);
		}
		if($search_params['fromDate']!='')
			$this->db->where('d.do_date>=',$search_params['fromDate']);
		if($search_params['toDate']!='')
			$this->db->where('d.do_date<=',$search_params['toDate']);
		if($search_params['status']!='')
		{
			if($search_params['status'] ==1)
			{
				$this->db->where('dop.status<=',2);// 1-pending, 2-invoice partial
			}
			else if($search_params['status']==2)
			{
				$this->db->where('dop.status',3);//3-completed
			}
		}
		$this->db->order_by('CAST(d.do_number AS unsigned) DESC');
		$res = $this->db->get();
		//echo $this->db->last_query();exit;
		return $res->num_rows();
	}

	public function distributor_do_results($current_offset, $per_page, $search_params)
	{
		$block_id = $this->session->userdata('block_id');
		$plant_id = $this->session->userdata('ses_plant_id');		
		$this->db->select('p.name as product_name,p.product_id as product_id,
			dop.quantity as do_quantity,dop.pending_qty,d.do_number,pt.short_name as lifting_point,dis.agency_name,dis.distributor_code,
			doo.order_id,doo.do_id as do_identity,dop.status as order_status, e.name as executive_name,d.do_date,dop.items_per_carton,dop.product_price');
		$this->db->from('do d');
		$this->db->join('do_order doo','d.do_id = doo.do_id');
		$this->db->join('order disto','disto.order_id = doo.order_id');
		$this->db->join('do_order_product dop','doo.do_ob_id = dop.do_ob_id');
		$this->db->join('product p','dop.product_id = p.product_id');		
		$this->db->join('distributor_order do','disto.order_id = do.order_id');
		$this->db->join('distributor dis','dis.distributor_id = do.distributor_id');		
		$this->db->join('plant pt','pt.plant_id = d.lifting_point');
		$this->db->join('executive e','e.executive_id = dis.executive_id');
		$this->db->join('user u','u.user_id = d.created_by','left');
		if($search_params['executive']!='')
			$this->db->where('dis.executive_id',$search_params['executive']);
		if($search_params['do_number']!='')
			$this->db->like('d.do_number',$search_params['do_number']);
		if($search_params['order_type_id']!='')
			$this->db->where('disto.ob_type_id',$search_params['order_type_id']);
		if($search_params['distributor_id']!='')
			$this->db->where('do.distributor_id',$search_params['distributor_id']);
		if($search_params['product_id']!='')
			$this->db->where('dop.product_id',$search_params['product_id']);
		if($block_id != 2) // If it is not OPS
		{
			if($block_id == 1) // If it is Head Office
			{
				if($search_params['lifting_point_id']!='')
				{
					$this->db->where('d.lifting_point',$search_params['lifting_point_id']);
				}
			}
			else
			{
				if($search_params['lifting_point_id']!='')
				{
					$this->db->where('d.lifting_point = "'.$search_params['lifting_point_id'].'" AND u.plant_id = "'.get_plant_id().'"');
				}
				else{ // ** to display dos which are raised by SP or lifting point be the SP
					$this->db->where('(d.lifting_point = "'.get_plant_id().'" OR u.plant_id = "'.get_plant_id().'")');
				}
			}
			
		}
		else
		{
			$this->db->where('d.lifting_point',$plant_id);
		}
		if($search_params['fromDate']!='')
			$this->db->where('d.do_date>=',$search_params['fromDate']);
		if($search_params['toDate']!='')
			$this->db->where('d.do_date<=',$search_params['toDate']);
		if($search_params['status']!='')
		{
			if($search_params['status'] ==1)
			{
				$this->db->where('dop.status<=',2);// 1-pending, 2-invoice partial
			}
			else if($search_params['status']==2)
			{
				$this->db->where('dop.status',3);//3-completed
			}
		}
		$this->db->order_by('CAST(dis.distributor_code AS unsigned) DESC,CAST(d.do_number AS unsigned) DESC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();	
		//echo $this->db->last_query();exit;	

		return $res->result_array();
	}

	////# Get Distributor DO Products Details
	public function get_distributor_do_products($order_id)
	{
	    $this->db->select('p.name as product_name,op.quantity,op.unit_price,op.add_price,((op.unit_price + op.add_price)*op.quantity) as total_price');
	    $this->db->from('do_order doo');
	    $this->db->join('order o','do.order_id = doo.order_id');
	    $this->db->join('order_product op','do.order_id = op.order_id');
	    $this->db->join('product p','p.product_id = op.product_id');
	    $this->db->where('doo.order_id',$order_id);
        $res = $this->db->get();
		return $res->result_array();
	}

	public function get_distributor_do_orders($order_id,$do_id)
	{
	    $this->db->select('do.order_id,dop.product_id,p.name as product_name,dop.quantity,dop.items_per_carton');
	    $this->db->from('do_order_product dop');
	    $this->db->join('do_order do','do.do_ob_id = dop.do_ob_id');
	    $this->db->join('product p','p.product_id = dop.product_id');
	    $this->db->where_in('do.order_id',$order_id);
	   $this->db->where_in('do.do_id',$do_id);
        $res = $this->db->get();
		return $res->result_array();
	}

	# Get Distributor Order price Details
	public function get_distributor_ob_price_details($order_id,$product_id)
	{
	    $this->db->select('op.unit_price,op.add_price,(op.unit_price + op.add_price) as total_price');
	    $this->db->from('order_product op');
	    $this->db->where('op.order_id',$order_id);
	    $this->db->where('op.product_id',$product_id);
        $res = $this->db->get();
		return $res->result_array();
		
		/*$this->db->select('do.order_id,dop.quantity,p.product_id,p.name as product_name');
	    $this->db->from('do_order_product dop');
	    $this->db->join('do_order do','do.do_ob_id = dop.do_ob_id','left');
	    $this->db->join('do d','d.do_id = do.do_id','left');
	    $this->db->join('order o','o.order_id = do.order_id','left');
	    $this->db->join('product p','p.product_id = dop.product_id','left');
	    $this->db->group_by('do.order_id');
	    $this->db->where('do.order_id',$order_id);
	    $this->db->where('dop.status',3);
        $res = $this->db->get();
		return $res->result_array();*/
	}

	# Download DO List
	public function download_do_list($search_params)
	{		
		$block_id = $this->session->userdata('block_id');
		$plant_id = $this->session->userdata('ses_plant_id');
		$this->db->select('p.name as product_name,p.product_id as product_id,
			dop.quantity as do_quantity,dop.pending_qty,d.do_number,pt.short_name as lifting_point,dis.agency_name,dis.distributor_code,
			doo.order_id,doo.do_id as do_identity,dop.status as order_status, e.name as executive_name,d.do_date,dop.items_per_carton,dop.product_price, da.name as remarks');
		$this->db->from('do d');
		$this->db->join('do_order doo','d.do_id = doo.do_id');
		$this->db->join('order disto','disto.order_id = doo.order_id');
		$this->db->join('do_order_product dop','doo.do_ob_id = dop.do_ob_id');
		$this->db->join('product p','dop.product_id = p.product_id');		
		$this->db->join('distributor_order do','disto.order_id = do.order_id');
		$this->db->join('distributor dis','dis.distributor_id = do.distributor_id');		
		$this->db->join('plant pt','pt.plant_id = d.lifting_point');
		$this->db->join('executive e','e.executive_id = dis.executive_id');
		$this->db->join('do_against da','da.do_against_id = d.do_against_id');
		$this->db->join('user u','u.user_id = d.created_by','left');

		if($search_params['executive']!='')
			$this->db->where('dis.executive_id',$search_params['executive']);
		if($search_params['do_number']!='')
			$this->db->like('d.do_number',$search_params['do_number']);
		if($search_params['order_type_id']!='')
			$this->db->where('disto.ob_type_id',$search_params['order_type_id']);
		if($search_params['distributor_id']!='')
			$this->db->where('do.distributor_id',$search_params['distributor_id']);
		if($search_params['product_id']!='')
			$this->db->where('dop.product_id',$search_params['product_id']);
		/*if($block_id == 1)
		{
			if($search_params['lifting_point_id']!='')
			$this->db->where('d.lifting_point',$search_params['lifting_point_id']);
		}
		else
		{
			$this->db->where('d.lifting_point',$plant_id);
		}*/
		if($block_id != 2) // If it is not OPS
		{
			if($block_id == 1) // If it is Head Office
			{
				if($search_params['lifting_point_id']!='')
				{
					$this->db->where('d.lifting_point',$search_params['lifting_point_id']);
				}
			}
			else
			{
				if($search_params['lifting_point_id']!='')
				{
					$this->db->where('d.lifting_point = "'.$search_params['lifting_point_id'].'" AND u.plant_id = "'.get_plant_id().'"');
				}
				else{ // ** to display dos which are raised by SP or lifting point be the SP
					$this->db->where('(d.lifting_point = "'.get_plant_id().'" OR u.plant_id = "'.get_plant_id().'")');
				}
			}
			
		}
		else
		{
			$this->db->where('d.lifting_point',$plant_id);
		}
		if($search_params['fromDate']!='')
			$this->db->where('d.do_date>=',$search_params['fromDate']);
		if($search_params['toDate']!='')
			$this->db->where('d.do_date<=',$search_params['toDate']);
		if($search_params['status']!='')
		{
			if($search_params['status'] ==1)
			{
				$this->db->where('dop.status<=',2);// 1-pending, 2-invoice partial
			}
			else if($search_params['status']==2)
			{
				$this->db->where('dop.status',3);//3-completed
			}
		}
		$this->db->order_by('CAST(d.do_number AS unsigned) DESC');
		$res = $this->db->get();	
		//echo $this->db->last_query(); exit;
		return $res->result_array();
	}

	# Get Order  Details
	public function get_order_details($order_id)
	{
	    $this->db->select('o.order_number,o.order_date,obt.name as ob_type,d.agency_name as distributor_name,p.name as lifting_point');
	    $this->db->from('order o');
	    $this->db->join('ob_type obt','obt.ob_type_id = o.ob_type_id');
	    $this->db->join('distributor_order do','o.order_id = do.order_id');
	    $this->db->join('distributor d','d.distributor_id = do.distributor_id');
	    $this->db->join('plant p','p.plant_id = o.lifting_point');
	    $this->db->where('o.order_id',$order_id);
	    $this->db->where('o.type',1);
        $res = $this->db->get();
		return $res->result_array();
	}

	# Get Orders
	public function get_orders($do_id)
	{
	    $this->db->select('do.*');
	    $this->db->from('do_order do');
	    $this->db->where('do.do_id',$do_id);
	    $this->db->group_by('do.order_id');
        $res = $this->db->get();
		return $res->result_array();
	}
	public function get_product_list()
	{
		$this->db->select('p.product_id,p.name as product_name');
		$this->db->from('product p');
		$this->db->join('loose_oil l','l.loose_oil_id = p.loose_oil_id');
		$this->db->join('product_capacity pc','pc.product_id = p.product_id');
		$this->db->join('capacity c','c.capacity_id = pc.capacity_id');
		$this->db->where('p.status',1);
		$this->db->order_by('l.rank ASC,c.rank ASC');
		$res = $this->db->get();
		return $res->result_array();

	}

	// mahesh 3rd Mar 2017 0:07 
	public function get_distributor_orders($distributor_id,$ob_type)
	{
		$this->db->select('p.short_name as ob_lifting_point, o.*');
		$this->db->from('order o');
		$this->db->join('distributor_order do','o.order_id = do.order_id');
		$this->db->join('plant p','p.plant_id = o.lifting_point');
		$this->db->where('do.distributor_id',$distributor_id);
		$this->db->where('o.ob_type_id',$ob_type);
		$this->db->where('o.status<=',2);
		$res = $this->db->get();
		if($res->num_rows()>0)
		{
			return $res->result_array();
		}
		else{
			return array();
		}
	}

	//mahesh 4th Mar 2017 04:20 pm
	public function updateOrderStatus($order_id)
	{
		if($order_id!='')
		{
			// get order products length
			$this->db->select('count(*) as op_count');
			$this->db->from('order_product');
			$this->db->where('order_id',$order_id);
			$res = $this->db->get();
			$row = $res->row_array();
			$op_count = $row['op_count'];

			// get DO Full raised order products length
			$this->db->select('count(*) as do_full_op_count');
			$this->db->from('order_product');
			$this->db->where('order_id',$order_id);
			$this->db->where('status>=',3);
			$res = $this->db->get();
			$row = $res->row_array();
			$do_full_op_count = $row['do_full_op_count'];

			$status = ($do_full_op_count == $op_count)?3:2;
			// update order status
			$data = array('status'=>$status,'modified_by'=>$this->session->userdata('user_id'),'modified_time'=>date('Y-m-d H:i:s'));
			$where = array('order_id'=>$order_id);
			$this->db->update('order',$data,$where);
			return $status;
		}
	}
	public function get_lifting_point_list()
	{
		$block_list = array(2,3,4);
		$this->db->select('p.plant_id,p.name');
		$this->db->from('plant p');
		$this->db->join('plant_block pb','pb.plant_id = p.plant_id');
		$this->db->where_in('pb.block_id',$block_list); 
		$this->db->where('p.status',1);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_do_products($do_number,$lifting_point_id,$do_status)
	{
		$this->db->select('p.name as product_name,p.product_id as product_id,
			dop.quantity as do_quantity,
			p.items_per_carton,
			distop.unit_price as unit_price,
			distop.add_price as add_price,
			((dop.quantity * p.items_per_carton) * (distop.unit_price + distop.add_price)) as total_price,
			 doo.order_id');
		$this->db->from('do d');
		$this->db->join('do_order doo','d.do_id = doo.do_id');
		$this->db->join('do_order_product dop','doo.do_ob_id = dop.do_ob_id');
		$this->db->join('product p','dop.product_id = p.product_id');		
		$this->db->join('order disto','disto.order_id = doo.order_id');
		$this->db->join('order_product distop','distop.order_id = doo.order_id AND dop.product_id = distop.product_id');		
		$this->db->join('plant pt','pt.plant_id = disto.lifting_point');
		$this->db->join('plant_product ptp','p.product_id = ptp.product_id AND ptp.plant_id = disto.lifting_point','left');	
		if($do_status <=2)
		{
			$this->db->where('dop.status<=',2);// 1-pending, 2-invoice partial
		}
		else
		{
			$this->db->where('dop.status',3);//3-completed
		}		
		$this->db->where('d.do_number',$do_number);
		$this->db->where('disto.lifting_point',$lifting_point_id); // 1-pending, 2-invoice partial
		//$this->db->group_by('ptp.product_id'); // check this condition for
		// when have 3 same products in different obs
		$res = $this->db->get();
		//echo $this->db->last_query();exit;
		if($res->num_rows()>0)
		{
			return $res->result_array();
		}
		
	}
	public function get_do_details($do_number,$lifting_point_id)
	{
		$this->db->select('d.*,ot.name as order_type,di.agency_name as distributor_name,p.name as lifting_point');
		$this->db->from('do d');
		$this->db->join('do_order doo','d.do_id = doo.do_id');
		$this->db->join('order o','o.order_id = doo.order_id');
		$this->db->join('ob_type ot','ot.ob_type_id = o.ob_type_id');
		$this->db->join('distributor_order disto','disto.order_id = o.order_id');
		$this->db->join('distributor di','di.distributor_id = disto.distributor_id');
		$this->db->join('plant p','p.plant_id = o.lifting_point');
		$this->db->where('o.lifting_point',$lifting_point_id);
		$this->db->where('d.do_number',$do_number);
		$res = $this->db->get();
		return $res->row_array();
	}

	// mahesh 26th Mar 2017 04:40 pm
	public function get_distributor_pending_dos($distributor_id,$ob_type)
	{
		$this->db->select('p.short_name as do_lifting_point, d.*');
		$this->db->from('do d');
		$this->db->join('do_order dob','d.do_id = dob.do_id');
		$this->db->join('plant p','p.plant_id = d.lifting_point');
		$this->db->join('order o','o.order_id = dob.order_id');
		$this->db->join('distributor_order do','do.order_id = o.order_id');
		$this->db->where('do.distributor_id',$distributor_id);
		$this->db->where('o.ob_type_id',$ob_type);
		$this->db->where('d.status<=',2);
		$res = $this->db->get();
		if($res->num_rows()>0)
		{
			return $res->result_array();
		}
		else{
			return array();
		}
	}

	# mahesh 26th Mar 2017 04:40 pm
	public function get_doProducts($do_id)
	{
	    $this->db->select('	p.product_id,p.name as product_name,dop.quantity ,dop.product_price,dop.items_per_carton,dop.pending_qty');
	    $this->db->from('do_order_product dop');
	    $this->db->join('do_order do','do.do_ob_id = dop.do_ob_id');
	    $this->db->join('product p','p.product_id = dop.product_id','left');
	    /*$this->db->join('do_order do','do.order_id = op.order_id','left');
	    $this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.product_id = op.product_id','left');
	    $this->db->group_by('do.order_id');*/
	    $this->db->where('do.do_id',$do_id);
	    $this->db->where('dop.status<=',2);
        $res = $this->db->get();
		return $res->result_array();
	}

	// Mahesh 5th Apr 2017 1:40 AM
	public function product_wise_pending_do($search_params)
	{
		$this->db->select('p.name as product_name, p.short_name, sum(dop.pending_qty) as cartons, sum(dop.pending_qty*dop.items_per_carton) as packets, sum(dop.pending_qty*dop.items_per_carton*p.oil_weight) as qty_in_kgs, sum(dop.pending_qty*dop.items_per_carton*dop.product_price) as value_in_rupees, p.loose_oil_id, p.product_id ');
		$this->db->from('do d');
		$this->db->join('do_order do','d.do_id=do.do_id');
		$this->db->join('do_order_product dop','do.do_ob_id=dop.do_ob_id');
		$this->db->join('product p','dop.product_id = p.product_id');
		$this->db->join('product_capacity pc','p.product_id=pc.product_id');
		$this->db->join('capacity c','pc.capacity_id = c.capacity_id');
		$this->db->join('loose_oil lo','p.loose_oil_id = lo.loose_oil_id');
		$this->db->where('dop.status<=',2);

		if($search_params['fromDate'])
			$this->db->where('d.do_date >=',$search_params['fromDate']);
		if($search_params['toDate'])
			$this->db->where('d.do_date <=',$search_params['toDate']);
		if($search_params['lifting_point_id'])
			$this->db->where('d.lifting_point <=',$search_params['lifting_point_id']);
		$this->db->group_by('p.product_id');
		$this->db->order_by('lo.rank ASC, c.rank ASC');
		$res = $this->db->get();
		//echo $this->db->last_query(); exit;
		if($res->num_rows()>0)
			return $res->result_array();
		else
			return array('hi');
	}
}