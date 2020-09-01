<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

# Created by priyanka on 5th March,2017 4:46 PM
class Plant_do_m extends CI_Model {

	# Get Blocks(C & F and Stock Point)
	public function get_blocks()
	{		
		$this->db->select('block_id,name as block_name');
		$this->db->from('block');		
		$this->db->where_in('block_id',array(3,4));
		$res = $this->db->get();
		return $res->result_array();
	}

	# Get Plants(C & F and Stock Point) 
	public function get_plants($block_id)
	{		
		$this->db->select('pb.plant_id,p.name as plant_name');
		$this->db->from('plant_block pb');	
		$this->db->join('plant p','p.plant_id=pb.plant_id','left');	
		$this->db->where('pb.block_id',$block_id);
		$res = $this->db->get();
		return $res->result_array();
	}

	# Get Blocks(OPS and C & F and Stock Point)
	public function ops_cf_stock_blocks()
	{		
		$this->db->select('block_id,name as block_name');
		$this->db->from('block');		
		$this->db->where_in('block_id',array(2,3,4));
		$res = $this->db->get();
		return $res->result_array();
	}

	# Get Ordered products based on lifting point, ordered plant, ob type,type
	public function get_plant_ob_orders($ordered_plant_id,$ob_type_id,$type_id)
	{
		$this->db->select('p.short_name as ob_lifting_point, o.order_number,o.order_id,o.order_date');
		$this->db->from('order o');
		$this->db->join('plant_order po','o.order_id = po.order_id');
		$this->db->join('plant p','p.plant_id = o.lifting_point');
		$this->db->where('po.plant_id',$ordered_plant_id);
		//$this->db->where('o.lifting_point',$lifting_point);
		$this->db->where('o.ob_type_id',$ob_type_id);
		$this->db->where('o.type',$type_id);
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

	# Get Plant Ordered Product Details
	public function get_orderedProducts($order_id)
	{
	    $this->db->select('p.product_id,p.name as product_name,op.quantity as ordered_quantity,op.unit_price,op.add_price,op.items_per_carton, op.pending_qty');
	    $this->db->from('order_product op');
	    $this->db->join('product p','p.product_id = op.product_id','left');
	   /* $this->db->join('do_order do','do.order_id = op.order_id','left');
	    $this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.product_id = op.product_id','left');
	    $this->db->group_by('do.order_id');*/
	    $this->db->where('op.order_id',$order_id);
	    $this->db->where('op.status<=',2);
        $res = $this->db->get();
		return $res->result_array();
	}

	# Update Order Status
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

	# Get DO Total Num Rows
	public function plant_do_num_rows($search_params)
	{	$block_id = $this->session->userdata('block_id');
	    $plant_id = $this->session->userdata('ses_plant_id');	
		$this->db->select();
		$this->db->from('do d');
		$this->db->join('do_order doo','d.do_id = doo.do_id');
		$this->db->join('order o','o.order_id = doo.order_id');
		$this->db->join('do_order_product dop','doo.do_ob_id = dop.do_ob_id');
		$this->db->join('product p','dop.product_id = p.product_id');
		$this->db->join('loose_oil l','l.loose_oil_id = p.loose_oil_id');	
		$this->db->join('plant_order po','o.order_id = po.order_id');
		$this->db->join('plant pt1','pt1.plant_id = po.plant_id');		
		$this->db->join('plant pt2','pt2.plant_id = d.lifting_point');
		$this->db->join('user u','u.user_id = d.created_by','left');
		if($search_params['do_number']!='')
			$this->db->like('d.do_number',$search_params['do_number']);
		if($block_id == 1)
		{
			if($search_params['order_for']!='')
			$this->db->where('po.plant_id',$search_params['order_for']);
			if($search_params['lifting_point_id']!='')
			$this->db->where('d.lifting_point',$search_params['lifting_point_id']);
		}
		else
		{
			if($search_params['order_for']!=''||$search_params['lifting_point_id']!='')
			{
				if($search_params['order_for']=='') // If lifting point filter seleced
				{
					$plant_id1 = $plant_id;
					$plant_id2 = $search_params['lifting_point_id'];
					if($search_params['lifting_point_id']==$plant_id)
					{
						$this->db->where('d.lifting_point = '.$plant_id);
						$plant_id2 = '';
					}
				}
				else if($search_params['lifting_point_id']=='') // IF order for filter selected
				{
					$plant_id1 = $search_params['order_for'];
					$plant_id2 = $plant_id;
					if($search_params['order_for']==$plant_id)
					{
						$this->db->where('po.plant_id = '.$plant_id);
						$plant_id2 = '';
					}
				}
				else // IF both order for , lifting point selected
				{
					if($search_params['order_for']==$plant_id || $search_params['lifting_point_id'] == $plant_id)
					{
						$plant_id1 = $search_params['order_for'];
						$plant_id2 = $search_params['lifting_point_id'];
					}
				}

				if(@$plant_id1!=''&&$plant_id2!='')
				{
					$this->db->where('po.plant_id = '.$plant_id1.' AND d.lifting_point = '.$plant_id2);
				}
			}
			else
			{
				$this->db->where('(po.plant_id = '.$plant_id.' OR d.lifting_point = '.$plant_id.')');
			}
			
		}			
		
		if($search_params['fromDate']!='')
			$this->db->where('d.do_date>=',$search_params['fromDate']);
		if($search_params['product_id']!='')
			$this->db->where('dop.product_id',$search_params['product_id']);
		if($search_params['toDate']!='')
			$this->db->where('d.do_date<=',$search_params['toDate']);
		if($search_params['status']!='')
		{
			if($search_params['status']==1)
			{
				$this->db->where('dop.status<=',2);
			}
			else if($search_params['status']==2)
			{
				$this->db->where('dop.status',3);
			}
		}
		$this->db->where('o.type',2);
		//$this->db->where('obt.ob_type_id',1);
		$this->db->order_by('CAST(d.do_number AS unsigned) DESC');
		$res = $this->db->get();
		return $res->num_rows();
	}

	public function plant_do_results($current_offset, $per_page, $search_params)
	{
		$block_id = $this->session->userdata('block_id');
	    $plant_id = $this->session->userdata('ses_plant_id');	
	    $this->db->select('p.name as product_name,p.product_id as product_id,
			dop.quantity as do_quantity,dop.pending_qty,d.do_number,pt1.short_name as order_for,pt2.short_name as lifting_point,
			doo.order_id,doo.do_id as do_identity,dop.status as order_status,d.do_date,dop.items_per_carton,dop.product_price');
		$this->db->from('do d');
		$this->db->join('do_order doo','d.do_id = doo.do_id');
		$this->db->join('order o','o.order_id = doo.order_id');
		$this->db->join('do_order_product dop','doo.do_ob_id = dop.do_ob_id');
		$this->db->join('product p','dop.product_id = p.product_id');
		$this->db->join('loose_oil l','l.loose_oil_id = p.loose_oil_id');		
		$this->db->join('plant_order po','o.order_id = po.order_id');
		$this->db->join('plant pt1','pt1.plant_id = po.plant_id');		
		$this->db->join('plant pt2','pt2.plant_id = d.lifting_point');
		$this->db->join('user u','u.user_id = d.created_by','left');
		if($search_params['do_number']!='')
			$this->db->like('d.do_number',$search_params['do_number']);
		if($block_id == 1)
		{
			if($search_params['order_for']!='')
			$this->db->where('po.plant_id',$search_params['order_for']);
			if($search_params['lifting_point_id']!='')
			$this->db->where('d.lifting_point',$search_params['lifting_point_id']);
		}
		else
		{
			if($search_params['order_for']!=''||$search_params['lifting_point_id']!='')
			{
				if($search_params['order_for']=='') // If lifting point filter seleced
				{
					$plant_id1 = $plant_id;
					$plant_id2 = $search_params['lifting_point_id'];
					if($search_params['lifting_point_id']==$plant_id)
					{
						$this->db->where('d.lifting_point = '.$plant_id);
						$plant_id2 = '';
					}
				}
				else if($search_params['lifting_point_id']=='') // IF order for filter selected
				{
					$plant_id1 = $search_params['order_for'];
					$plant_id2 = $plant_id;
					if($search_params['order_for']==$plant_id)
					{
						$this->db->where('po.plant_id = '.$plant_id);
						$plant_id2 = '';
					}
				}
				else // IF both order for , lifting point selected
				{
					if($search_params['order_for']==$plant_id || $search_params['lifting_point_id'] == $plant_id)
					{
						$plant_id1 = $search_params['order_for'];
						$plant_id2 = $search_params['lifting_point_id'];
					}
				}

				if(@$plant_id1!=''&&$plant_id2!='')
				{
					$this->db->where('po.plant_id = '.$plant_id1.' AND d.lifting_point = '.$plant_id2);
				}
			}
			else
			{
				$this->db->where('(po.plant_id = '.$plant_id.' OR d.lifting_point = '.$plant_id.')');
			}
			
		}			
		
		if($search_params['fromDate']!='')
			$this->db->where('d.do_date>=',$search_params['fromDate']);
		if($search_params['product_id']!='')
			$this->db->where('dop.product_id',$search_params['product_id']);
		if($search_params['toDate']!='')
			$this->db->where('d.do_date<=',$search_params['toDate']);
		if($search_params['status']!='')
		{
			if($search_params['status']==1)
			{
				$this->db->where('dop.status<=',2);
			}
			else if($search_params['status']==2)
			{
				$this->db->where('dop.status',3);
			}
		}
		$this->db->where('o.type',2);
		//$this->db->where('obt.ob_type_id',1);
		$this->db->order_by('CAST(d.do_number AS unsigned) DESC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();	
		//echo $this->db->last_query();exit;	

		return $res->result_array();
	}

	# Get DO Products Details
	public function get_plant_do_products($order_id)
	{
	    /*$this->db->select('p.name as product_name,op.quantity,op.unit_price,op.add_price,((op.unit_price + op.add_price) * op.quantity) as total_price');
	    $this->db->from('order_product op');
	    $this->db->join('product p','p.product_id = op.product_id');
	    $this->db->where('op.order_id',$order_id);
        $res = $this->db->get();
		return $res->result_array();
		*/
		$this->db->select('do.order_id,dop.quantity,p.product_id,p.name as product_name');
	    $this->db->from('do_order_product dop');
	    $this->db->join('do_order do','do.do_ob_id = dop.do_ob_id','left');
	    $this->db->join('do d','d.do_id = do.do_id','left');
	    $this->db->join('order o','o.order_id = do.order_id','left');
	    $this->db->join('product p','p.product_id = dop.product_id','left');
	    $this->db->group_by('do.order_id');
	    $this->db->where('do.order_id',$order_id);
        $res = $this->db->get();
		return $res->result_array();
	}

	# Get Plant Order price Details
	public function get_plant_do_price_details($order_id,$product_id)
	{
	    $this->db->select('op.unit_price,op.add_price,(op.unit_price + op.add_price) as total_price');
	    $this->db->from('order_product op');
	    $this->db->where('op.order_id',$order_id);
	    $this->db->where('op.product_id',$product_id);
        $res = $this->db->get();
		return $res->result_array();
	}

	# Get DO Order  Details
	public function get_order_details($order_id)
	{
	    $this->db->select('d.do_number,d.do_date,pp.name as order_for_plnat,p.name as lifting_point');
	    $this->db->from('do d');
	    $this->db->join('do_order dor','d.do_id=dor.do_id','left');
		$this->db->join('plant_order po','po.order_id=dor.order_id','inner');
		$this->db->join('order o','o.order_id=dor.order_id','left');
		$this->db->join('plant pp','pp.plant_id = po.plant_id');
	    $this->db->join('plant p','p.plant_id = o.lifting_point');
	    $this->db->where('o.order_id',$order_id);
        $res = $this->db->get();
		return $res->result_array();
	}

	# DO List for downloads
	public function plant_do_details( $search_params)
	{		
		$block_id = $this->session->userdata('block_id');
	    $plant_id = $this->session->userdata('ses_plant_id');
		$this->db->select('p.name as product_name,p.product_id as product_id,
			dop.quantity as do_quantity,dop.pending_qty,d.do_number,pt1.short_name as order_for,pt2.short_name as lifting_point,
			doo.order_id,doo.do_id as do_identity,dop.status as order_status,d.do_date,dop.items_per_carton,dop.product_price');
		$this->db->from('do d');
		$this->db->join('do_order doo','d.do_id = doo.do_id');
		$this->db->join('order o','o.order_id = doo.order_id');
		$this->db->join('do_order_product dop','doo.do_ob_id = dop.do_ob_id');
		$this->db->join('product p','dop.product_id = p.product_id');		
		$this->db->join('plant_order po','o.order_id = po.order_id');
		$this->db->join('plant pt1','pt1.plant_id = po.plant_id');		
		$this->db->join('plant pt2','pt2.plant_id = d.lifting_point');
		$this->db->join('user u','u.user_id = d.created_by','left');
		if($search_params['do_number']!='')
			$this->db->like('d.do_number',$search_params['do_number']);
		if($block_id == 1)
		{
			if($search_params['order_for']!='')
			$this->db->where('po.plant_id',$search_params['order_for']);
			if($search_params['lifting_point_id']!='')
			$this->db->where('d.lifting_point',$search_params['lifting_point_id']);
		}
		else
		{
			if($search_params['order_for']!=''||$search_params['lifting_point_id']!='')
			{
				if($search_params['order_for']=='') // If lifting point filter seleced
				{
					$plant_id1 = $plant_id;
					$plant_id2 = $search_params['lifting_point_id'];
					if($search_params['lifting_point_id']==$plant_id)
					{
						$this->db->where('d.lifting_point = '.$plant_id);
						$plant_id2 = '';
					}
				}
				else if($search_params['lifting_point_id']=='') // IF order for filter selected
				{
					$plant_id1 = $search_params['order_for'];
					$plant_id2 = $plant_id;
					if($search_params['order_for']==$plant_id)
					{
						$this->db->where('po.plant_id = '.$plant_id);
						$plant_id2 = '';
					}
				}
				else // IF both order for , lifting point selected
				{
					if($search_params['order_for']==$plant_id || $search_params['lifting_point_id'] == $plant_id)
					{
						$plant_id1 = $search_params['order_for'];
						$plant_id2 = $search_params['lifting_point_id'];
					}
				}

				if(@$plant_id1!=''&&$plant_id2!='')
				{
					$this->db->where('po.plant_id = '.$plant_id1.' AND d.lifting_point = '.$plant_id2);
				}
			}
			else
			{
				$this->db->where('(po.plant_id = '.$plant_id.' OR d.lifting_point = '.$plant_id.')');
			}
			
		}			
		
		if($search_params['fromDate']!='')
			$this->db->where('d.do_date>=',$search_params['fromDate']);
		if($search_params['product_id']!='')
			$this->db->where('dop.product_id',$search_params['product_id']);
		if($search_params['toDate']!='')
			$this->db->where('d.do_date<=',$search_params['toDate']);
		if($search_params['status']!='')
		{
			if($search_params['status']==1)
			{
				$this->db->where('dop.status<=',2);
			}
			else if($search_params['status']==2)
			{
				$this->db->where('dop.status',3);
			}
		}
		$this->db->where('o.type',2);
		//$this->db->where('obt.ob_type_id',1);
		$this->db->order_by('CAST(d.do_number AS unsigned) DESC');
		$res = $this->db->get();	
		//echo $this->db->last_query();exit;	

		return $res->result_array();
	}


	public function get_do_details($do_number,$lifting_point_id)
	{
		$this->db->select('d.*,p.name as lifting_point_name,pp.name as order_for');
		$this->db->from('do d');
		$this->db->join('do_order doo','d.do_id = doo.do_id');
		$this->db->join('order o','o.order_id = doo.order_id');
		$this->db->join('plant p','p.plant_id = o.lifting_point');
		$this->db->join('plant_order po','po.order_id = o.order_id');
		$this->db->join('plant pp','po.plant_id = pp.plant_id');
		$this->db->where('o.lifting_point',$lifting_point_id);
		$this->db->where('d.do_number',$do_number);
		$res = $this->db->get();
		return $res->row_array();
	}

	public function get_do_products($do_number,$lifting_point_id,$do_status)
	{
		$this->db->select('p.name as product_name,p.product_id as product_id,
			dop.quantity as do_quantity,
			((dop.quantity * p.items_per_carton)*(distop.unit_price + distop.add_price))  as total_price,
			distop.unit_price as unit_price,
			distop.add_price as add_price,
			doo.order_id');
		$this->db->from('do d');
		$this->db->join('do_order doo','d.do_id = doo.do_id');
		$this->db->join('do_order_product dop','doo.do_ob_id = dop.do_ob_id');
		$this->db->join('product p','dop.product_id = p.product_id');
		
		$this->db->join('order disto','disto.order_id = doo.order_id');
		$this->db->join('order_product distop','distop.order_id = doo.order_id AND dop.product_id = distop.product_id');		
		$this->db->join('plant pt','pt.plant_id = disto.lifting_point');		
		$this->db->join('plant_product ptp','p.product_id = ptp.product_id AND ptp.plant_id = disto.lifting_point');
		if($do_status <=2)
		{
			$this->db->where('dop.status<=',2);// 1-pending, 2-invoice partial
		}
		else
		{
			$this->db->where('dop.status',3);//3-completed
		}		
		$this->db->where('d.do_number',$do_number);
		$this->db->where('disto.lifting_point',$lifting_point_id); 
		$this->db->group_by('ptp.product_id'); // check this condition for
		// when have 3 same products in different obs
		$res = $this->db->get();
		//echo $this->db->last_query();exit;
		return $res->result_array();
	}

	// mahesh 27th Mar 2017 00:28 am
	public function get_plant_pending_dos($plant_id,$ob_type)
	{
		$this->db->select('p.short_name as do_lifting_point, d.*');
		$this->db->from('do d');
		$this->db->join('do_order dob','d.do_id = dob.do_id');
		$this->db->join('plant p','p.plant_id = d.lifting_point');
		$this->db->join('order o','o.order_id = dob.order_id');
		$this->db->join('plant_order po','po.order_id = o.order_id');
		$this->db->where('po.plant_id',$plant_id);
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

	// Mahesh 27th Mar 2017 00:33 am
	public function get_doProducts($do_id)
	{
	    $this->db->select('p.product_id,p.name as product_name,dop.quantity as do_quantity,dop.product_price,dop.items_per_carton, dop.pending_qty');
	    $this->db->from('do d');
	   	$this->db->join('do_order do','do.do_id = d.do_id','left');
	    $this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id','left');
	    $this->db->join('product p','p.product_id = dop.product_id','left');
	    /* $this->db->group_by('do.order_id');*/
	    $this->db->where('d.do_id',$do_id);
	    $this->db->where('dop.status<=',2);
        $res = $this->db->get();
		return $res->result_array();
	}
}