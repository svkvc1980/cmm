<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rollback_stock_updation_model extends CI_Model {

	public function get_ops()
	{
		$this->db->select('p.plant_id,p.name as plant_name');
        $this->db->from('plant p');
        $this->db->join('plant_block pb','p.plant_id=pb.plant_id');
        $this->db->where_in('pb.block_id',array(2,3));
        $this->db->where('p.status',1);
        $res = $this->db->get();
        return $res->result_array();
	}

	public function get_products()
	{
		$this->db->select('p.product_id,p.name as product_name');
		$this->db->from('product p');
		$this->db->join('loose_oil l','l.loose_oil_id = p.loose_oil_id');
		$this->db->join('product_capacity pc','pc.product_id = p.product_id');
		$this->db->join('capacity c','c.capacity_id = pc.capacity_id');
		$this->db->where('p.status',1);
		$this->db->order_by('l.rank ASC','c.rank ASC');
		$res = $this->db->get();
        return $res->result_array();
	}

	public function get_product_stock_details($product_id,$plant_id)
	{
		$this->db->select("pp.quantity,p.items_per_carton");
		$this->db->from('plant_product pp');
		$this->db->join('product p','p.product_id = pp.product_id');
		$this->db->where('pp.product_id', $product_id);
		$this->db->where('pp.plant_id', $plant_id);
		$res1 = $this->db->get();
		$res = $res1->result_array();
		$count = $res1->num_rows();
		$qry_data='';
        if($count>0)
		{
			$qry_data.='';
			foreach($res as $row1)
			{  
				if($row1['quantity']==0 || $row1['quantity']==NULL)
				{ 
					$qty = 0; 
				}
				else
				{ 
					$qty = round($row1['quantity']*$row1['items_per_carton']); 
				}
				$qry_data.=$qty;
			}
		} 
		else 
		{
			$qry_data.=0;
		}
		echo $qry_data;
	}
}