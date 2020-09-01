<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 	 Created By 	:	Maruthi 
 	 Date 			: 	8th April 2017 11:45 AM
 	 Module 		:	Distributor Penalties
*/

class Cron_m extends CI_Model {

	# Get Distributors List
	

    public function get_pending_obs()
	{
		$curr_date = date('Y-m-d');
		//echo $curr_date;exit;	
		$ob_type_arr = array(1,3); // penalty for regular and CST Regular
		$this->db->select('o.order_date,o.order_id,DATEDIFF("'.$curr_date.'",order_date) as days');
		$this->db->from('order o');
		$this->db->join('distributor_order do','o.order_id = do.order_id');	
		$this->db->where('o.status<=',2);
		$this->db->where_in('o.ob_type_id',$ob_type_arr);
		//$this->db->order
		$res = $this->db->get();
		/*echo '<pre>';
		echo $this->db->last_query();//exit;
		print_r($res->result_array());
		exit;*/
		if($res->num_rows()>0)
		{
			return $res->result_array();
		}
		else
		{
			return array();
		}
	}

	# Get Distributor Order Details
	public function caluculate_penalty($order_id)
	{
	    $this->db->select('disto.distributor_id,o.order_id,p.product_id,op.pending_qty,
	    	(op.pending_qty*op.items_per_carton*p.oil_weight) as weight,
	    	((op.unit_price+op.add_price)*op.items_per_carton*op.pending_qty) as total_product_price');
	    $this->db->from('order_product op');
	    $this->db->join('product p','p.product_id = op.product_id');
	    $this->db->join('order o','op.order_id = o.order_id');
	    $this->db->join('distributor_order disto','disto.order_id = o.order_id');	    
	    $this->db->where('op.order_id',$order_id);
	    $this->db->where('op.status<=',2);
        $res = $this->db->get();
		return $res->result_array();
	}
	
	public function check_cron_already_runs($cron_type,$date)
	{
		if($cron_type!=''&&$date!='')
		{
			$this->db->select();
			$this->db->from('cron_history');
			$this->db->where('cron_type',$cron_type);
			$this->db->where('DATE(cron_time)',$date);
			$res = $this->db->get();
			return ($res->num_rows()>0)?TRUE:FALSE;
		}
	}
}