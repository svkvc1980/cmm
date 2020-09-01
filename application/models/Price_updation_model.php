<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Price_updation_model extends CI_Model {

	public function product_total_rows($searchParams)
	{		
		$this->db->select('p.*,lp.*');
		$this->db->from('product p');
		$this->db->join('loose_oil_product lp','p.loose_oil_product_id=lp.loose_oil_product_id');
		if($searchParams['product_name']!='')
			$this->db->where('p.product_name',$searchParams['product_name']);
		$this->db->group_by('p.product_id');
		$res = $this->db->get();
		return $res->num_rows();
	}

	public function product_results($searchParams, $per_page, $current_offset)
	{		
		$this->db->select('p.product_id as product_id, p.product_name as product_name, p.no_of_item_per_carton as no_of_item_per_carton, 
			p.status as status, lp.loose_oil_product_name as loose_oil_product_name, lp.status as statuss');
		$this->db->from('product p');
		$this->db->join('loose_oil_product lp','p.loose_oil_product_id=lp.loose_oil_product_id');
		if($searchParams['product_name']!='')
			$this->db->where('p.product_name',$searchParams['product_name']);
		$this->db->limit($per_page, $current_offset);
		$this->db->group_by('p.product_id');
		$res = $this->db->get();
		return $res->result_array();
	}

	public function product_details($searchParams)
	{		
		$this->db->select('p.*,lp.*');
		$this->db->from('product p');
		$this->db->join('loose_oil_product lp','p.loose_oil_product_id=lp.loose_oil_product_id');
		$this->db->group_by('p.product_id');
		$this->db->where('p.status',1);
		$res = $this->db->get();
		return $res->result_array();
	}

	/**
	* get units except distributor,head office blocks
	* author: prasad , created on: 6th feb 2017 12:39 PM, updated on: --
	* return: $plants(array)
	**/

	public function get_plant()
	{   
		
		$this->db->select('pb.plant_id as plant_id,pb.block_id block_id,p.name as plant_name,b.name as block_name,p.short_name as plant_short_name');
		$this->db->from('plant_block pb');
		$this->db->join('plant p','pb.plant_id=p.plant_id');
		$this->db->join('block b','pb.block_id=b.block_id');
		$in=array(2,3,4);
		$this->db->where_in('pb.block_id',$in);
		$this->db->where('pb.status',1);
		$this->db->order_by('b.block_id');
		$res=$this->db->get();
		return $res->result_array();

	}
	/**
	* get all loose oil types
	* author: prasad , created on: 6th feb 2017 12:39 PM, updated on: --
	* return: $loose_oil(array)
	**/

	public function get_products() 
	{
		$this->db->from('loose_oil');
		$this->db->where('status',1);
		$this->db->order_by('rank ASC');
		$res=$this->db->get();
		return $res->result_array();
	}

	/**
	* get all products based on loose oil type
	* author: prasad , created on: 6th feb 2017 12:39 PM, updated on: --
	* params: $loose_oil_id(int)
	* return: $products(array)
	**/
	public function get_sub_products_by_products($loose_oil_id)
	{
		$this->db->select('p.product_id,p.name');
		$this->db->from('product p');
		$this->db->join('product_capacity pc','pc.product_id = p.product_id');
		$this->db->join('capacity c','c.capacity_id = pc.capacity_id');
		$this->db->where('loose_oil_id',$loose_oil_id);
		$this->db->order_by('c.rank ASC');
		$this->db->where('p.status',1);
		$res=$this->db->get();
		return $res->result_array();
	}

    /**
	* get all products latest price based on price type and unit
	* author: prasad , created on: 8th feb 2017 12:39 PM, updated on: --
	* params: $distributor_type(int),$plant_id(int)
	* return: $product_latest_rate(array)
	**/
	public function get_all_products_latest_price_plant($distributor_type,$plant_id)
	{
		$query=	'SELECT * FROM product_price p WHERE p.start_date= (select max(p1.start_date) as start_date from product_price p1 where p1.product_id=p.product_id and p1.plant_id=p.plant_id and p1.price_type_id=p.price_type_id and p1.start_date <= "'.date('Y-m-d').'") and p.plant_id = "'.$plant_id.'" and p.price_type_id = "'.$distributor_type.'"';
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

	/**
	* get all products latest price from mrp price type and kakinada unit
	* author: prasad , created on: 8th feb 2017 12:39 PM, updated on: --
	* params: $distributor_type(int),$plant_id(int)
	* return: $product_latest_rate(array)
	**/
	public function get_latest_id_plant($plant_id,$mrp_plant)
	{
		$query=	'SELECT * FROM product_price p WHERE p.start_date= (select max(p1.start_date) as start_date from product_price p1 where p1.product_id=p.product_id and p1.plant_id=p.plant_id and p1.price_type_id=p.price_type_id and p1.start_date <= "'.date('Y-m-d').'") and p.plant_id = "'.$plant_id.'" and p.price_type_id = "'.$mrp_plant.'"';
	    $res=$this->db->query($query);
	    return $res->result_array();	
	}

	/**
	* get all products latest price based on price type 
	* author: prasad , created on: 8th feb 2017 12:39 PM, updated on: --
	* params: $distributor_type(int)
	* return: $product_latest_rates(array)
	**/
	public function get_all_products_latest_price($distributor_type)
	{
		$query=	'SELECT * FROM product_price p WHERE p.start_date= (select max(p1.start_date) as start_date from product_price p1 where p1.product_id=p.product_id  and p1.price_type_id=p.price_type_id and p1.start_date <= "'.date('Y-m-d').'")  and p.price_type_id = "'.$distributor_type.'"';
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

	/**
	* Updating latest previous product price end date 
	* author: prasad , created on: 9th feb 2017 12:39 PM, updated on: --
	* params: $dat(array),$product_price_id(int)
	**/
	public function update_product_date($dat,$product_price_id)
	{
		/*$this->db->from('product_price');
		$this->db->where('product_price_id',$product_price_id);
		$res=$this->db->get();
		$result=$res->row_array();
        $start_date=$result['start_date'];
       
        if(strtotime($start_date)!=strtotime($dat['start_date']))
        {*/   
            $data=array('end_date'=>$dat['start_date']);
			$this->db->where('product_price_id',$product_price_id);
			$this->db->update('product_price',$data);
	    //}

	}

	/**
	* Inserting latest product price 
	* author: prasad , created on: 9th feb 2017 12:39 PM, updated on: --
	* params: $dat(array),$product_price_id(int)
	*return: insert_id(int)
	**/
	public function insert_latest_data($dat,$product_price_id)
	{
		/*$this->db->from('product_price');
		$this->db->where('product_price_id',$product_price_id);
		$res=$this->db->get();
		$result=$res->row_array();
        $start_date=$result['start_date'];
      
        if(strtotime($start_date)!=strtotime($dat['start_date']))
        {   */
        	$this->db->insert('product_price',$dat);
        	/*return 1;
        }
        else
        {
        	return 2;
        }	*/
	}

	/**
	* Retreving product count based on unit,pricetype,start date execpt mrp price type
	* author: prasad , created on: 9th feb 2017 12:39 PM, updated on: --
	* params:$plant_id(int),$distributor_type(int),$start_date(string)
	*return: insert_id(int)
	**/
	public function get_product_count_start_date($plant_id,$distributor_type,$start_date)
	{
		$this->db->from('product_price');
		if($plant_id!='')
		{
		$this->db->where('plant_id',$plant_id);
	    }
	    else
	    {
	    	$this->db->where('plant_id is null');	
	    }
		$this->db->where('price_type_id',$distributor_type);
		$this->db->where('start_date',$start_date);
		$res=$this->db->get();
		return $res->num_rows();
	}

	/**
	* Retreving product count based on start date mrp price type
	* author: prasad , created on: 9th feb 2017 12:39 PM, updated on: --
	* params:$plant_id(int),$distributor_type(int),$start_date(string)
	*return: insert_id(int)
	**/
	public function get_mrp_count_start($distributor_type,$start_date)
	{
		$this->db->from('product_price');
		$this->db->where('price_type_id',$distributor_type);
		$this->db->where('start_date',$start_date);
		$res=$this->db->get();
		return $res->num_rows();
	}

	/**
	* get all products latest price based on price type,unit,start date
	* author: prasad , created on: 12th feb 2017 12:39 PM, updated on: --
	* params:$plant_id(int),$distributor_type(int),$start_date(string)
	*return: latest results based on date(array)
	**/
	public function get_all_products_latest_price_report_plant($price_type,$plant_id,$start_date)
	{
		$query=	'SELECT * FROM product_price p WHERE p.start_date= (select max(p1.start_date) as start_date from product_price p1 where p1.product_id=p.product_id and p1.plant_id=p.plant_id and p1.price_type_id=p.price_type_id and p1.start_date <= "'.$start_date.'") and p.plant_id = "'.$plant_id.'" and p.price_type_id = "'.$price_type.'"';
	    $res=$this->db->query($query);
	    return $res->result_array();	
	}

	/**
	* get all products latest price based on price type,start date
	* author: prasad , created on: 12th feb 2017 12:39 PM, updated on: --
	* params:$plant_id(int),$distributor_type(int),$start_date(string)
	*return: latest results based on date(array)
	**/
	public function get_all_products_latest_price_report($price_type,$start_date)
	{
		$query=	'SELECT * FROM product_price p WHERE p.start_date= (select max(p1.start_date) as start_date from product_price p1 where p1.product_id=p.product_id  and p1.price_type_id=p.price_type_id and p1.start_date <= "'.$start_date.'")  and p.price_type_id = "'.$price_type.'"';
	    $res=$this->db->query($query);
	    return $res->result_array();	
	}
	public function get_all_plants_latest_prices($price_type,$start_date)
	{
		$query=	'SELECT * FROM product_price p WHERE p.start_date= (select max(p1.start_date) as start_date from product_price p1 where p1.product_id=p.product_id and p1.plant_id=p.plant_id and p1.price_type_id=p.price_type_id and p1.start_date <= "'.$start_date.'") and p.plant_id = "4" and p.price_type_id = "'.$price_type.'"';
	    $res=$this->db->query($query);
	    return $res->result_array();
	}

	/**
	*** Get price last updated date for searched date
	*** @params: search_date (Date), price_type (int), plant_id (int) [optional]
	*** @Return: last_updated_date(Date)
	**/
	public function get_price_last_updated_date($search_date,$price_type,$plant_id='')
	{
		$this->db->select('max(start_date) as last_updated_date');
		$this->db->from('product_price');
		$this->db->where('start_date<=',$search_date);
		$this->db->where('price_type_id',$price_type);
		if($plant_id!='')
		$this->db->where('plant_id',$plant_id);
		$this->db->group_by('price_type_id');
		$res = $this->db->get();
		//echo $this->db->last_query();
		if($res->num_rows()>0)
		{
			$row = $res->row_array();
			return $row['last_updated_date'];
		}
	}

}