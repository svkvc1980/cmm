<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by nagajuna on 1st MAR 2017 1:45 PM
*/

class Stock_transfer_m extends CI_Model {

	public function get_product_id($plant_id)
	{	
		$this->db->select('product_id');
		$this->db->from('plant_product');
		$this->db->where('plant_id',$plant_id);
		$this->db->where('quantity>',0);
		$res = $this->db->get();
		foreach ($res->result_array() as $key => $value) {
			$sam[] = $value['product_id'];
		}
		
		if(count(@$sam)==0)
		{
			return 0;
		}
		else
		{
			return $sam;
		}
		
	}

	public function get_product_based_on_plant($plant_data)
	{
		$this->db->select('p.product_id,p.name as product_name,c.name as capacity_name,u.name as unit_name');
		$this->db->from('product p');
		$this->db->join('product_capacity pc','pc.product_id = p.product_id');
		$this->db->join('capacity c','c.capacity_id = pc.capacity_id');
		$this->db->join('unit u','u.unit_id = c.unit_id');
		$this->db->where_in('p.product_id',$plant_data);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_godown_stock($product_id, $plant_id)
	{
		$this->db->select("pp.quantity as qty1,pcp.quantity as qty2,p.items_per_carton,pp.loose_pouches");
		$this->db->from('plant_product pp');
		$this->db->join('plant_counter pc', 'pp.plant_id = pc.plant_id');
		$this->db->join('plant_counter_product pcp', 'pcp.product_id = pp.product_id AND pc.counter_id= pcp.counter_id','left');
		$this->db->join('product p','p.product_id = pp.product_id');
		$this->db->where('pp.product_id', $product_id);
		$this->db->where('pp.plant_id', $plant_id);
		$res1 = $this->db->get();
		//echo $this->db->last_query(); exit();
		$res = $res1->result_array();
		$count = $res1->num_rows();
		$qry_data='';
        if($count>0)
		{
			$qry_data.='';
			foreach($res as $row1)
			{  
				if($row1['qty2']==NULL){ $qty2 = 0;}
				else{ $qty2 = $row1['qty2'];}
				$count = $row1['qty1']-$qty2;
				$total = $count*$row1['items_per_carton']+$row1['loose_pouches'];
				$qry_data.=$total;
			}
		} 
		else 
		{
			$qry_data.="No Data";
		}
		echo $qry_data;
	}

	public function get_counter_stock($product_id, $plant_id)
	{
		$this->db->select("pcp.quantity as counter_qty");
		$this->db->from('plant_product pp');
		$this->db->join('plant_counter pc', 'pp.plant_id = pc.plant_id');
		$this->db->join('plant_counter_product pcp', 'pcp.product_id = pp.product_id AND pc.counter_id= pcp.counter_id','left');
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
				if($row1['counter_qty']==0 || $row1['counter_qty']==NULL){ $qty = 0; }
					else{ $qty = $row1['counter_qty']; }
				$qry_data.=$qty;
			}
		} 
		else 
		{
			$qry_data.="no data";
		}
		echo $qry_data;
	}
}