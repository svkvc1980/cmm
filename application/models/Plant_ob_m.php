<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

# Created by priyanka on 4th March,2017 5:15 PM
class Plant_ob_m extends CI_Model {

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

	# Get loose_oil_ids based on products
	public function get_loose_oil($product_id_arr)
	{		
		$this->db->select('product_id,loose_oil_id');
		$this->db->from('product');		
		$this->db->where_in('product_id',$product_id_arr);
		$this->db->order_by('rank ASC');
		$this->db->group_by('loose_oil_id');
		$res = $this->db->get();
		return $res->result_array();
	}

	# Get Product results
	public function get_product_results($loose_oil_id,$lifting_point_id)
	{		
		$this->db->select('pp.product_id');
		$this->db->from('plant_product pp');	
		$this->db->where('pp.plant_id',$lifting_point_id);
		$res = $this->db->get();
		$product_data_arr[] =  $res->result_array();
		foreach ($product_data_arr as $key => $value) 
		{
			$product_id_arr = array_column($value,'product_id');
		}
		if(@$product_id_arr != '')
		{
			$this->db->select('p.product_id,p.name as product_name,p.items_per_carton');
			$this->db->from('product p');		
			$this->db->where_in('p.product_id',$product_id_arr);
			$this->db->where('p.loose_oil_id',$loose_oil_id);
			$res = $this->db->get();
			return $res->result_array();
		}
		
	}

    # Get C_and_F Bank Guarantee Details
	public function get_bank_guarantee_details($c_and_f_id)
	{
	    $this->db->select('b.name as bank_name,bg.start_date,bg.end_date,bg.bg_amount');
	    $this->db->from('c_and_f_bank_gurantee bg');
	    $this->db->join('bank b','b.bank_id = bg.bank_id');
	    $this->db->where('bg.c_and_f_id',$c_and_f_id);
        $res = $this->db->get();
		return $res->result_array();
	}

	# Get Order Booking Total Num Rows
	public function plant_ob_num_rows($search_params)
	{
		$block_id = $this->session->userdata('block_id');
	        $plant_id = $this->session->userdata('ses_plant_id');		
		$this->db->select();
		$this->db->from('order o');
		$this->db->join('plant_order po','o.order_id=po.order_id');
		$this->db->join('plant pt1','pt1.plant_id = po.plant_id');		
		$this->db->join('plant pt2','pt2.plant_id = o.lifting_point');
		if($search_params['ob_number']!='')
			$this->db->like('o.order_number',$search_params['ob_number']);
		if($block_id == 1)
		{
			if($search_params['order_for']!='')
			$this->db->where('po.plant_id',$search_params['order_for']);
			if($search_params['lifting_point_id']!='')
			$this->db->where('o.lifting_point',$search_params['lifting_point_id']);
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
						$this->db->where('o.lifting_point = '.$plant_id);
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
					$this->db->where('po.plant_id = '.$plant_id1.' AND o.lifting_point = '.$plant_id2);
				}
			}
			else
			{
				$this->db->where('(po.plant_id = '.$plant_id.' OR o.lifting_point = '.$plant_id.')');
			}
			
		}
		if($search_params['fromDate']!='')
			$this->db->where('o.order_date>=',$search_params['fromDate']);
		if($search_params['toDate']!='')
			$this->db->where('o.order_date<=',$search_params['toDate']);
		if($search_params['status']!='')
		{
			if($search_params['status']==1)
			{
				$this->db->where('o.status<=',2);
			}
			else if($search_params['status']==2)
			{
				$this->db->where('o.status',3);
			}
		}
		$this->db->where('o.ob_type_id',1);
		$this->db->where('o.type',2);
		$this->db->order_by('CAST(o.order_number AS unsigned) DESC');
		$res = $this->db->get();
		return $res->num_rows();
	}

	public function plant_ob_results($current_offset, $per_page, $search_params)
	{
		$block_id = $this->session->userdata('block_id');
	    $plant_id = $this->session->userdata('ses_plant_id');		
		$this->db->select('o.order_number,o.order_id,o.order_date,pt2.name as lifting_point_name,pt1.name as plant_name,o.status as order_status');
		$this->db->from('order o');
		$this->db->join('plant_order po','o.order_id=po.order_id');
		$this->db->join('plant pt1','pt1.plant_id = po.plant_id');		
		$this->db->join('plant pt2','pt2.plant_id = o.lifting_point');
		if($search_params['ob_number']!='')
			$this->db->like('o.order_number',$search_params['ob_number']);
		if($block_id == 1)
		{
			if($search_params['order_for']!='')
			$this->db->where('po.plant_id',$search_params['order_for']);
			if($search_params['lifting_point_id']!='')
			$this->db->where('o.lifting_point',$search_params['lifting_point_id']);
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
						$this->db->where('o.lifting_point = '.$plant_id);
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
					$this->db->where('po.plant_id = '.$plant_id1.' AND o.lifting_point = '.$plant_id2);
				}
			}
			else
			{
				$this->db->where('(po.plant_id = '.$plant_id.' OR o.lifting_point = '.$plant_id.')');
			}
			
		}
		if($search_params['fromDate']!='')
			$this->db->where('o.order_date>=',$search_params['fromDate']);
		if($search_params['toDate']!='')
			$this->db->where('o.order_date<=',$search_params['toDate']);
		if($search_params['status']!='')
		{
			if($search_params['status']==1)
			{
				$this->db->where('o.status<=',2);
			}
			else if($search_params['status']==2)
			{
				$this->db->where('o.status',3);
			}
		}
		$this->db->where('o.ob_type_id',1);
		$this->db->where('o.type',2);
		$this->db->order_by('CAST(o.order_number AS unsigned) DESC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();	
		//echo $this->db->last_query();exit;	

		return $res->result_array();
	}

	# Get Ordered Products Details
	public function get_plant_ob_products($order_id)
	{
	    $this->db->select('p.name as product_name,op.quantity,op.unit_price,op.add_price,((op.unit_price + op.add_price) * op.quantity*op.items_per_carton) as total_price');
	    $this->db->from('order_product op');
	    $this->db->join('product p','p.product_id = op.product_id');
	    $this->db->where('op.order_id',$order_id);
        $res = $this->db->get();
		return $res->result_array();
	}

	# Get Order  Details
	public function get_order_details($order_id)
	{
	    $this->db->select('o.order_number,o.order_date,pp.name as order_for_plant,p.name as lifting_point,obt.name as obt_type');
	    $this->db->from('order o');
		$this->db->join('plant_order po','o.order_id=po.order_id','inner');
		$this->db->join('plant pp','pp.plant_id = po.plant_id');
		$this->db->join('ob_type obt','obt.ob_type_id = o.ob_type_id');
	    $this->db->join('plant p','p.plant_id = o.lifting_point');
	    $this->db->where('o.order_id',$order_id);
        $res = $this->db->get();
		return $res->result_array();
	}

	# plant ob list for downloads
	public function plant_ob_details( $search_params)
	{	$block_id = $this->session->userdata('block_id');
	    $plant_id = $this->session->userdata('ses_plant_id');		
		$this->db->select('o.order_number,o.order_id,o.order_date,pt1.short_name as order_for, pt2.short_name as lifting_point,pt1.name as plant_name,o.status as order_status,p.name as product_name, op.quantity,op.pending_qty,(op.unit_price+op.add_price) as product_price, op.items_per_carton');
		$this->db->from('order o');
		$this->db->join('order_product op','o.order_id = op.order_id');
		$this->db->join('product p','p.product_id = op.product_id');
		$this->db->join('plant_order po','o.order_id=po.order_id');
		$this->db->join('plant pt1','pt1.plant_id = po.plant_id');		
		$this->db->join('plant pt2','pt2.plant_id = o.lifting_point');
		if($search_params['ob_number']!='')
			$this->db->like('o.order_number',$search_params['ob_number']);
		if($block_id == 1)
		{
			if($search_params['order_for']!='')
			$this->db->where('po.plant_id',$search_params['order_for']);
			if($search_params['lifting_point_id']!='')
			$this->db->where('o.lifting_point',$search_params['lifting_point_id']);
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
						$this->db->where('o.lifting_point = '.$plant_id);
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
					$this->db->where('po.plant_id = '.$plant_id1.' AND o.lifting_point = '.$plant_id2);
				}
			}
			else
			{
				$this->db->where('(po.plant_id = '.$plant_id.' OR o.lifting_point = '.$plant_id.')');
			}
			
		}
		if($search_params['fromDate']!='')
			$this->db->where('o.order_date>=',$search_params['fromDate']);
		if($search_params['toDate']!='')
			$this->db->where('o.order_date<=',$search_params['toDate']);
		if($search_params['status']!='')
		{
			if($search_params['status']==1)
			{
				$this->db->where('o.status<=',2);
			}
			else if($search_params['status']==2)
			{
				$this->db->where('o.status',3);
			}
		}
		$this->db->where('o.ob_type_id',1);
		$this->db->where('o.type',2);
		$this->db->order_by('CAST(o.order_number AS unsigned) DESC');
		$res = $this->db->get();	
		//echo $this->db->last_query();exit;	

		return $res->result_array();
	}

	# Get Plant ordere ids for displaying pending orders for Plants
	public function get_order_ids($ordered_plant_id,$lifting_point_id,$ob_type_id,$type)
	{
		$this->db->select('o.order_id');
	    $this->db->from('order o');
		$this->db->join('plant_order po','o.order_id=po.order_id','inner');
	    $this->db->where('po.plant_id',$ordered_plant_id);
	    $this->db->where('o.lifting_point',$lifting_point_id);
	    $this->db->where('o.ob_type_id',$ob_type_id);
	    $this->db->where('o.type',$type);
	    $this->db->where('o.status<=',2);
        $res = $this->db->get();
		return $res->result_array();
	}

	# Get Plant ordered product details for displaying pending orders for plants
	public function get_ordered_product_details($order_id)
	{
		$this->db->select('op.quantity,op.unit_price,op.add_price,op.items_per_carton,p.name as product_name');
	    $this->db->from('order_product op');
	     $this->db->join('product p','p.product_id = op.product_id','left');
	    $this->db->where('op.status<=',2);
	     $this->db->where('op.order_id',$order_id);
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
	public function get_order_id_count($order_number)
	{
		$this->db->select('order_number ,order_id');
		$this->db->from('order');
		$this->db->where('order_number',$order_number);
		$this->db->where('type',2);
		$res=$this->db->get();
		return array($res->row_array(),$res->num_rows());
	}
	
	public function get_sub_products($loose_oil_id)
	{
		$this->db->select('p.*');
		$this->db->from('product p');
		$this->db->join('product_capacity pc','pc.product_id = p.product_id');
		$this->db->join('capacity c','c.capacity_id = pc.capacity_id');
		$this->db->where('loose_oil_id',$loose_oil_id);
		$this->db->order_by('c.rank ASC');
		$this->db->where('p.status',1);
		$res=$this->db->get();
		return $res->result_array();
	}
}
