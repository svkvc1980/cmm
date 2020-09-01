<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 	 Created By 	:	Priyanka 
 	 Date 			: 	21st Feb 2017 11:45 AM
 	 Module 		:	Distributor Order Booking
*/

class Distributor_ob_m extends CI_Model {

	# Get Distributors List
	public function getDistributorList($distributor_type_id='')
	{
	    $this->db->select('d.distributor_id,concat(d.distributor_code, " - (" ,d.agency_name,")") as agency_name');
	    $this->db->from('distributor d');
	    $this->db->join('user u','u.user_id = d.user_id');
	    $this->db->where('u.status',1);
	    if($distributor_type_id!='')
	    	$this->db->where('type_id',$distributor_type_id);
		else
			$this->db->where_in('type_id',array(1,3,5,6)); // Regular, CST, Institution Agent, CST Institution Agent
	$this->db->order_by('CAST(distributor_code as unsigned) ASC');
        $res1 = $this->db->get();
        //echo $this->db->last_query();
		$res = $res1->result_array();
		$count = $res1->num_rows();
		$qry_data='';
        if($count>0)
		{
			$qry_data.='<option value="">- Select Distributor -</option>';
			foreach($res as $row1)
			{  
				$qry_data.='<option value="'.$row1['distributor_id'].'">'.$row1['agency_name'].'</option>';
			}
		} 
		else 
		{
			$qry_data.='<option value="">No Data Found</option>';
		}
		echo $qry_data;
    }

   public function getStockLiftingUnitList($distributor_id)
	{
	    $this->db->select('location_id');
	    $this->db->from('distributor');
	    $this->db->where('distributor_id',$distributor_id);
        $res1 = $this->db->get();
		$res = $res1->result_array();
		$location_id = $res[0]['location_id'];
		//echo $location_id;exit;
		if($location_id)
		{
			# Get District and Region Ids
			$this->db->select('l.location_id as area_id,l1.location_id as district_id,l2.location_id as region_id');
		    $this->db->from('location l');
		    $this->db->join('location l1','l.parent_id = l1.location_id','left');
		    $this->db->join('location l2','l1.parent_id = l2.location_id','left');		   
		    $this->db->join('territory_level le','le.level_id=l.level_id');
		    $this->db->where('l.location_id',$location_id);
		    $this->db->where('le.name','Area');
	        $res2 = $this->db->get();
	        //echo $this->db->last_query();exit;
	        $qry_data='';
			$qry_data.='<option value="">- Select Stock Lifting Unit -</option>';
	        if($res2->num_rows()>0)
	        {
				$result = $res2->result_array();
				$district_id = $result[0]['district_id'];
				$region_id = $result[0]['region_id'];
				$location_id1 = array('1' => $district_id,'2' => $region_id);

				# Get Plant List
				// Modified by Maruthi on 16th Mar 17
				$this->db->select('p.plant_id,p.name as plant_name');
			    $this->db->from('plant_location pl');
			    $this->db->join('plant p','p.plant_id = pl.plant_id','left');
			    $this->db->join('plant_block pb','pl.plant_id = pb.plant_id','left');
			    $this->db->where_in('pl.location_id',$location_id1);		    
			    $this->db->where_in('pb.block_id',$block_id);
		        $res3 = $this->db->get();
		       // echo $this->db->last_query();exit;
				$result = $res3->result_array();
				$count = $res3->num_rows();
				if($count>0)
				{
					
					foreach($result as $row1)
					{  
						$qry_data.='<option value="'.$row1['plant_id'].'">'.$row1['plant_name'].'</option>';
					}
				} 
			}

			// Get the ops and stock point data
			$block_ids =array(2,3);
			$this->db->select('p.*');
			$this->db->from('plant p');
			$this->db->join('plant_block pb','p.plant_id = pb.plant_id');
			$this->db->where_in('pb.block_id',$block_ids);
			$res2 =$this->db->get();
			$result2 = $res2->result_array();      
			
			foreach($result2 as $row2)
			{  
				$qry_data.='<option value="'.$row2['plant_id'].'">'.$row2['name'].'</option>';
			}
			
			echo $qry_data;
		}
		
    }

    public function get_distributor_orders($distributor_id,$ob_type)
	{
		$this->db->select('p.short_name as ob_lifting_point, o.*');
		$this->db->from('order o');
		$this->db->join('distributor_order do','o.order_id = do.order_id');
		$this->db->join('plant p','p.plant_id = o.lifting_point');
		$this->db->where('do.distributor_id',$distributor_id);
		//$this->db->where('o.lifting_point',$lifting_point);
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

	# Get Distributor Order Details
	public function get_orderedProducts($order_id)
	{
	    $this->db->select('	p.product_id,p.name as product_name,op.quantity as ordered_quantity,op.unit_price,op.add_price,op.items_per_carton');
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
	
    # Get Bank Guarantee Details
	public function get_bank_guarantee_details($distributor_id)
	{
	    $this->db->select('b.name as bank_name,bg.start_date,bg.end_date,bg.bg_amount');
	    $this->db->from('bank_guarantee bg');
	    $this->db->join('bank b','b.bank_id = bg.bank_id');
	    $this->db->where('bg.distributor_id',$distributor_id);
	    $this->db->where('bg.status',1);
	    //$this->db->where('bg.end_date>=',date('Y-m-d')); 
            $res = $this->db->get();
		return $res->result_array();
	}

	public function get_unitPrice($ob_type_id,$params)
	{
		# Get Price Type Id based on ob_type_id
		$price_type_id = $this->Common_model->get_value('ob_type', array('ob_type_id'=>$ob_type_id), 'price_type_id');
		$query=	'SELECT * FROM product_price p WHERE p.start_date= (select max(p1.start_date) as start_date from product_price p1 where p1.product_id=p.product_id and p1.plant_id=p.plant_id and p1.price_type_id=p.price_type_id and p1.start_date <= "'.date('Y-m-d').'") and p.plant_id = "'.$params['stock_lifting_unit_id'].'" and p.price_type_id = "'.$price_type_id.'"';
	    $res=$this->db->query($query);
	    $product_latest_rates = array();
	   // $product_latest_details=array();
	    if($res->num_rows()>0)
	    {
	    	$results = $res->result_array();
	    	foreach ($results as $row) 
	    	{
	    		$unit_price = $row['value'];
	    		switch ($ob_type_id) {
	    			case 2: case 4: // Instituional OB , CST Institutional OB
	    				if($params['commission']!='')
	    				$unit_price = ($row['value']*(100-$params['commission'])/100);
	    				break;
	    			case 5: // Welfare scheme OB
	    				$discount = $this->Common_model->get_value('welfare_scheme',array('welfare_scheme_id'=>$params['welfare_scheme']),'discount_percentage');
	    				$unit_price = ($row['value']*(100-$discount)/100);
	    			break;
	    		}
	    		$product_latest_rates[$row['product_id']]['value'] = $unit_price;
	    		//$product_latest_details[$row['product_id']] = $row;
	    	}
	    }
	    return $product_latest_rates;
	}

	public function get_MRPprice($mrp_price_type_id,$stock_lifting_unit_id)
	{
		$query=	'SELECT * FROM product_price p WHERE p.start_date= (select max(p1.start_date) as start_date from product_price p1 where p1.product_id=p.product_id and p1.plant_id=p.plant_id and p1.price_type_id=p.price_type_id and p1.start_date <= "'.date('Y-m-d').'") and p.plant_id = "'.$stock_lifting_unit_id.'" and p.price_type_id = "'.$mrp_price_type_id.'"';
	    $res=$this->db->query($query);
	    $product_latest_rates = array();
	   // $product_latest_details=array();
	    if($res->num_rows()>0)
	    {
	    	$results = $res->result_array();
	    	foreach ($results as $row) 
	    	{
	    		$product_latest_rates[$row['product_id']] = $row;
	    		//$product_latest_details[$row['product_id']] = $row;
	    	}
	    }
	    return $product_latest_rates;
	}

	# Get Order Booking Total Num Rows
	public function distributor_ob_num_rows($search_params)
	{
		$block_id = $this->session->userdata('block_id');
		$plant_id = $this->session->userdata('ses_plant_id');	
		$this->db->select('o.order_number,o.order_date,d.agency_name as distributor_name,e.name as executive_name,obt.name as ob_type,p.name as lifting_point');
		$this->db->from('order o');
		$this->db->join('user u','u.user_id = o.created_by','left');
		$this->db->join('distributor_order do','do.order_id=o.order_id','inner');
		$this->db->join('distributor d','d.distributor_id=do.distributor_id','left');
		
		$this->db->join('executive e','d.executive_id = e.executive_id','left');
		$this->db->join('ob_type obt','obt.ob_type_id=o.ob_type_id','left');
		$this->db->join('plant p','p.plant_id=o.lifting_point','left');
		if($search_params['order_type_id']!='')
			$this->db->where('o.ob_type_id',$search_params['order_type_id']);
		if($search_params['ob_number']!='')
			$this->db->like('o.order_number',$search_params['ob_number']);
		if($search_params['distributor_id']!='')
			$this->db->where('do.distributor_id',$search_params['distributor_id']);
		if($search_params['executive_id']!='')
			$this->db->where('d.executive_id',$search_params['executive_id']);
		
		if($block_id != 2) // If it is not OPS
		{
			if($block_id == 1) // If it is Head Office
			{
				if($search_params['lifting_point_id']!='')
				{
					$this->db->where('o.lifting_point',$search_params['lifting_point_id']);
				}
			}
			else
			{
				if($search_params['lifting_point_id']!='')
				{
					$this->db->where('o.lifting_point = "'.$search_params['lifting_point_id'].'" AND u.plant_id = "'.get_plant_id().'"');
				}
				else{
					$this->db->where('(o.lifting_point = "'.get_plant_id().'" OR u.plant_id = "'.get_plant_id().'")');
				}
			}
			
		}
		else
		{
			$this->db->where('o.lifting_point',$plant_id);
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
			else if($search_params['status']==3)
			{
				$this->db->where('o.status',10);
			}
		}
		$this->db->where('o.type',1);
		$this->db->order_by('o.order_date DESC');
		$this->db->order_by('CAST(o.order_number AS unsigned) DESC');
		$res = $this->db->get();
		return $res->num_rows();
	}

	public function distributor_ob_results($current_offset, $per_page, $search_params)
	{
		$block_id = $this->session->userdata('block_id');
		$plant_id = $this->session->userdata('ses_plant_id');		
		$this->db->select('o.order_number,o.order_date,d.agency_name as distributor_name,e.name as executive_name,d.distributor_code,obt.name as ob_type,p.short_name as lifting_point,o.status as order_status,o.order_id');
		$this->db->from('order o');
		$this->db->join('distributor_order do','do.order_id=o.order_id','inner');
		$this->db->join('distributor d','d.distributor_id=do.distributor_id','left');
		$this->db->join('user u','u.user_id = o.created_by','left');
		$this->db->join('executive e','d.executive_id = e.executive_id','left');
		$this->db->join('ob_type obt','obt.ob_type_id=o.ob_type_id','left');
		$this->db->join('plant p','p.plant_id=o.lifting_point','left');
		if($search_params['order_type_id']!='')
			$this->db->where('o.ob_type_id',$search_params['order_type_id']);
		if($search_params['ob_number']!='')
			$this->db->like('o.order_number',$search_params['ob_number']);
		if($search_params['distributor_id']!='')
			$this->db->where('do.distributor_id',$search_params['distributor_id']);
		if($search_params['executive_id']!='')
			$this->db->where('d.executive_id',$search_params['executive_id']);
		
		if($block_id != 2) // If it is not OPS
		{
			if($block_id == 1) // If it is Head Office
			{
				if($search_params['lifting_point_id']!='')
				{
					$this->db->where('o.lifting_point',$search_params['lifting_point_id']);
				}
			}
			else
			{
				if($search_params['lifting_point_id']!='')
				{
					$this->db->where('o.lifting_point = "'.$search_params['lifting_point_id'].'" AND u.plant_id = "'.get_plant_id().'"');
				}
				else{
					$this->db->where('(o.lifting_point = "'.get_plant_id().'" OR u.plant_id = "'.get_plant_id().'")');
				}
			}
			
		}
		else
		{
			$this->db->where('o.lifting_point',$plant_id);
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
			else if($search_params['status']==3)
			{
				$this->db->where('o.status',10);
			}
		}
		$this->db->where('o.type',1);
		/*$this->db->order_by('o.order_date DESC');
		$this->db->order_by('CAST(o.order_number AS unsigned) DESC');*/
		$this->db->order_by('CAST(d.distributor_code AS unsigned) ASC, o.order_date ASC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();	
		return $res->result_array();
	}

	# Get Distributor Order Products Details
	public function get_distributor_ob_products($order_id)
	{
	    $this->db->select('p.name as product_name,op.quantity,op.unit_price,op.add_price,((op.unit_price + op.add_price) * op.quantity*op.items_per_carton) as total_price');
	    $this->db->from('order_product op');
	    $this->db->join('product p','p.product_id = op.product_id');
	    $this->db->where('op.order_id',$order_id);
        $res = $this->db->get();
		return $res->result_array();
	}

	# download OB List
	public function download_ob_list($search_params)
	{		
		$block_id = $this->session->userdata('block_id');
		$plant_id = $this->session->userdata('ses_plant_id');		
		$this->db->select('o.order_number,o.order_date,d.agency_name,e.name as executive_name,d.distributor_code,obt.name as ob_type,pt.short_name as lifting_point,o.status as order_status,o.order_id,
			p.name as product_name, op.quantity,op.pending_qty,(op.unit_price+op.add_price) as product_price, op.items_per_carton');
		$this->db->from('order o');
		$this->db->join('order_product op','o.order_id = op.order_id');
		$this->db->join('product p','op.product_id = p.product_id');
		$this->db->join('distributor_order do','do.order_id=o.order_id','inner');
		$this->db->join('distributor d','d.distributor_id=do.distributor_id','left');
		$this->db->join('user u','u.user_id = o.created_by','left');
		$this->db->join('executive e','d.executive_id = e.executive_id','left');
		$this->db->join('ob_type obt','obt.ob_type_id=o.ob_type_id','left');
		$this->db->join('plant pt','pt.plant_id=o.lifting_point','left');

		if($search_params['order_type_id']!='')
			$this->db->where('o.ob_type_id',$search_params['order_type_id']);
		if($search_params['ob_number']!='')
			$this->db->like('o.order_number',$search_params['ob_number']);
		if($search_params['distributor_id']!='')
			$this->db->where('do.distributor_id',$search_params['distributor_id']);
		if($search_params['executive_id']!='')
			$this->db->where('d.executive_id',$search_params['executive_id']);
		
		if($block_id != 2) // If it is not OPS
		{
			if($block_id == 1) // If it is Head Office
			{
				if($search_params['lifting_point_id']!='')
				{
					$this->db->where('o.lifting_point',$search_params['lifting_point_id']);
				}
			}
			else
			{
				if($search_params['lifting_point_id']!='')
				{
					$this->db->where('o.lifting_point = "'.$search_params['lifting_point_id'].'" AND u.plant_id = "'.get_plant_id().'"');
				}
				else{
					$this->db->where('(o.lifting_point = "'.get_plant_id().'" OR u.plant_id = "'.get_plant_id().'")');
				} 
			}
			
		}
		else
		{
			$this->db->where('o.lifting_point',$plant_id);
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
			else if($search_params['status']==3)
			{
				$this->db->where('o.status',10);
			}
		}
		$this->db->where('o.type',1);
		//$this->db->order_by('o.order_date DESC');
		$this->db->order_by('CAST(d.distributor_code AS unsigned) ASC, o.order_date ASC');
		$res = $this->db->get();		
		return $res->result_array();
	}

	# Get Order  Details
	public function get_order_details($order_id)
	{
	    $this->db->select('o.order_number,o.order_date,obt.name as ob_type,d.agency_name as distributor_name,d.distributor_code, d.distributor_place ,p.name as lifting_point');
	    $this->db->from('order o');
		$this->db->join('distributor_order do','do.order_id=o.order_id','inner');
	    $this->db->join('ob_type obt','obt.ob_type_id = o.ob_type_id');
	    $this->db->join('distributor d','d.distributor_id = do.distributor_id');
	    $this->db->join('plant p','p.plant_id = o.lifting_point');
	    $this->db->where('o.order_id',$order_id);
        $res = $this->db->get();
		return $res->result_array();
	}

	// mahesh 4th Mar 2017
	public function get_welfare_schemes()
	{
		$this->db->from('welfare_scheme');
		$this->db->where('status',1);
		$this->db->where('start_date <= ',date('Y-m-d'));
		$this->db->where('end_date >= ',date('Y-m-d'));
		$res = $this->db->get();
		//echo $this->db->last_query();
		if($res->num_rows()>0)
		{
			return $res->result_array();
		}
		else
		{
			return array();
		}
	}
	
	# Get Distributor ordere ids for displaying pending orders for distributors
	public function get_order_ids($ob_type_id,$distributor_id,$lifting_point_id)
	{
		$this->db->select('o.order_id');
	    $this->db->from('order o');
		$this->db->join('distributor_order do','o.order_id=do.order_id','inner');
	    $this->db->join('ob_type obt','obt.ob_type_id = o.ob_type_id','inner');
	    $this->db->where('do.distributor_id',$distributor_id);
	    $this->db->where('o.lifting_point',$lifting_point_id);
	    $this->db->where('o.ob_type_id',$ob_type_id);
	    $this->db->where('o.type',1);
	    $this->db->where('o.status<=',2);
        $res = $this->db->get();
		return $res->result_array();
	}

	# Get Distributor ordered product details for displaying pending orders for distributors
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
	public function get_order_id_count($order_number)
	{
		$this->db->select('order_number ,order_id');
		$this->db->from('order');
		$this->db->where('order_number',$order_number);
		$this->db->where('type',1);
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

	# Get Total Active BG Amount, Mahesh 27 Apr 2017 01:25 AM
	public function get_total_bg_amount($distributor_id)
	{
	    $this->db->select('sum(bg.bg_amount) as tot_bg_amt');
	    $this->db->from('bank_guarantee bg');
	    $this->db->where('bg.distributor_id',$distributor_id);
	    $this->db->where('bg.status',1);
	    $this->db->where('bg.end_date>=',date('Y-m-d')); 
	    $this->db->group_by('bg.distributor_id');
        $res = $this->db->get();
        if($res->num_rows()>0)
        {
        	$row = $res->row_array();
        	return ($row['tot_bg_amt']>0)?$row['tot_bg_amt']:0;
        }
		return 0;
	}
}