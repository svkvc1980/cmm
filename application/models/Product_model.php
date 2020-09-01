<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product_model extends CI_Model {

  
    public function product_total_num_rows($search_params)
	{		
		$this->db->select();
		$this->db->from('product p');
		$this->db->join('product_capacity pc', 'p.product_id=pc.product_id');
		$this->db->join('capacity c', 'pc.capacity_id=c.capacity_id');
		$this->db->join('loose_oil l', 'p.loose_oil_id=l.loose_oil_id');
		$this->db->join('unit u', 'c.unit_id=u.unit_id');
		$this->db->join('product_packing_type ppt', 'ppt.product_packing_type_id=p.product_packing_type_id');
		if($search_params['product']!='')
			$this->db->like('p.name',$search_params['product']);
		if($search_params['capacity_id']!='')
			$this->db->where('pc.capacity_id',$search_params['capacity_id']);
		if($search_params['loose_oil_id']!='')
			$this->db->where('p.loose_oil_id',$search_params['loose_oil_id']);
		if($search_params['product_packing_type_id']!='')
			$this->db->where('p.product_packing_type_id',$search_params['product_packing_type_id']);
		if($search_params['status']!='')
			$this->db->where('p.status',$search_params['status']);
		$this->db->order_by('l.rank ASC, c.rank ASC');
		$res = $this->db->get();
		return $res->num_rows();
	}
	public function product_results($search_params,$per_page,$current_offset)
	{		
		$this->db->select('p.product_id, p.items_per_carton,p.name as product, p.short_name,p.status as status,p.oil_weight as product_oil_weight,c.name as capacity, l.name as loose_oil,l.short_name as short_name,u.name as unit,ppt.name as ppt_name,p.short_name as p_short_name');
		$this->db->from('product p');
		$this->db->join('product_capacity pc', 'p.product_id=pc.product_id');
		$this->db->join('capacity c', 'pc.capacity_id=c.capacity_id');
		$this->db->join('loose_oil l', 'p.loose_oil_id=l.loose_oil_id');
		$this->db->join('unit u', 'c.unit_id=u.unit_id');
		$this->db->join('product_packing_type ppt', 'ppt.product_packing_type_id=p.product_packing_type_id');
		if($search_params['product']!='')
			$this->db->like('p.name',$search_params['product']);
		if($search_params['capacity_id']!='')
			$this->db->where('pc.capacity_id',$search_params['capacity_id']);
		if($search_params['loose_oil_id']!='')
			$this->db->where('p.loose_oil_id',$search_params['loose_oil_id']);
		if($search_params['product_packing_type_id']!='')
			$this->db->where('p.product_packing_type_id',$search_params['product_packing_type_id']);
		if($search_params['status']!='')
			$this->db->where('p.status',$search_params['status']);
		$this->db->order_by('l.rank ASC, c.rank ASC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();
		return $res->result_array();
	}
	public function product_details($search_params)
	{
		$this->db->select('p.product_id, p.name as product, p.status as status,p.oil_weight as product_oil_weight,c.name as capacity, l.name as loose_oil,l.short_name as short_name,u.name as unit,ppt.name as ppt_name,p.short_name as p_short_name');
		$this->db->from('product p');
		$this->db->join('product_capacity pc', 'p.product_id=pc.product_id');
		$this->db->join('capacity c', 'pc.capacity_id=c.capacity_id');
		$this->db->join('loose_oil l', 'p.loose_oil_id=l.loose_oil_id');
		$this->db->join('unit u', 'c.unit_id=u.unit_id');
		$this->db->join('product_packing_type ppt', 'ppt.product_packing_type_id=p.product_packing_type_id');
		if($search_params['product']!='')
			$this->db->like('p.name',$search_params['product']);
		if($search_params['capacity_id']!='')
			$this->db->where('pc.capacity_id',$search_params['capacity_id']);
		if($search_params['loose_oil_id']!='')
			$this->db->where('p.loose_oil_id',$search_params['loose_oil_id']);
		if($search_params['product_packing_type_id']!='')
			$this->db->where('p.product_packing_type_id',$search_params['product_packing_type_id']);
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_capacity()
	{
		$this->db->select('c.capacity_id,c.name as capacity,u.name as unit');
		$this->db->from('capacity c');
		$this->db->join('unit u', 'c.unit_id=u.unit_id');
		$this->db->where('c.status',1);
		$this->db->where('u.status',1);
		$res = $this->db->get();		
		return $res->result_array();
	}
	 public function is_nameExist($name,$product_id,$capacity_id)
    {       
        $this->db->select();
        $this->db->from('product p');
        $this->db->join('product_capacity pc','pc.product_id=p.product_id');
        if($product_id!=0)
        {
            $this->db->where_not_in('p.product_id',$product_id);
        }
        $this->db->where('p.name',$name);
        $this->db->where('pc.capacity_id',$capacity_id);
        $query = $this->db->get();        
        return ($query->num_rows()>0)?1:0;
    }
}