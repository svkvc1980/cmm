<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rollback_do_model extends CI_Model {

	public function get_do_data($do_number)
	{
		$this->db->select('o.type as ob_type,`o`.`order_id`, `doo`.`lifting_point`,o.order_number as order_number,
						 `doo`.`do_number`, `doo`.`do_id`, `doo`.`do_date`, `d`.`agency_name` as `distributor_name`, d.distributor_id as distributor_id,
						 `d`.`distributor_code`,po.plant_id as receiving_plant_id,pl.name as plant_name');
		$this->db->from('order o');
		$this->db->join('distributor_order do','o.order_id=do.order_id','left');
		$this->db->join('distributor d','do.distributor_id=d.distributor_id','left');
		$this->db->join('plant_order po','po.order_id = o.order_id','left');
		$this->db->join('do_order od','o.order_id=od.order_id');
		$this->db->join('do doo','od.do_id=doo.do_id');
		$this->db->join('plant pl','o.lifting_point=pl.plant_id');
		$this->db->where('doo.do_number',$do_number);
		$this->db->order_by('doo.do_id','DESC');
		$this->db->limit('1');
		$res=$this->db->get();
		return $res->result_array();
	}

	public function get_doProducts($do_id)
	{
	    $this->db->select('dop.product_id as product_id,dop.do_ob_product_id as do_ob_product_id,
	    					p.name as product_name,dop.quantity as do_qty,dop.product_price,dop.items_per_carton,
	    					dop.pending_qty,do.order_id as order_id,do.do_ob_id as do_ob_id');
	    $this->db->from('do_order_product dop');
	    $this->db->join('do_order do','do.do_ob_id = dop.do_ob_id');
	    /*$this->db->join('order o','o.order_id = do.order_id');
	    $this->db->join('order_product op','o.order_id= op.order_id');	    */
	    $this->db->join('product p','p.product_id = dop.product_id');	    
	    $this->db->where('do.do_id',$do_id);
	    //$this->db->where('dop.status<=',2);
        $res = $this->db->get();
        if($res->num_rows()>0)
        	return $res->result_array();
        else
        	return FALSE;

	}
	public function get_doProducts_by_do_ob_product_id($do_ob_product_id)
	{
	    $this->db->select('dop.product_id as product_id,dop.do_ob_product_id as do_ob_product_id,
	    					p.name as product_name,dop.quantity as do_qty,dop.product_price,dop.items_per_carton,
	    					dop.pending_qty,do.order_id as order_id,do.do_ob_id as do_ob_id');
	    $this->db->from('do_order_product dop');
	    $this->db->join('do_order do','do.do_ob_id = dop.do_ob_id');
	    /*$this->db->join('order o','o.order_id = do.order_id');
	    $this->db->join('order_product op','o.order_id= op.order_id');	    */
	    $this->db->join('product p','p.product_id = dop.product_id');	    
	    $this->db->where('dop.do_ob_product_id',$do_ob_product_id);
	    //$this->db->where('dop.status<=',2);
        $res = $this->db->get();
        if($res->num_rows()>0)
        	return $res->result_array();
        else
        	return FALSE;

	}
	public function get_do_data_by_do_ob_product_id($do_ob_product_id)
	{
		$this->db->select('d.*');
		$this->db->from('do d');
		$this->db->join('do_order do','d.do_id = do.do_id');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id');
		$this->db->where('do_ob_product_id',$do_ob_product_id);
		$res = $this->db->get();
		return $res->row_array();
	}

	public function get_ops()
	{
		$this->db->select('p.plant_id,p.name as plant_name');
        $this->db->from('plant p');
        $this->db->join('plant_block pb','p.plant_id=pb.plant_id');
        $this->db->where_in('pb.block_id',array(2,3));
        $res = $this->db->get();
        return $res->result_array();
	}
	public function get_order_data($order_id)
	{
		$this->db->select('o.type as ob_type,`o`.`order_id`, `o`.`lifting_point`,o.order_number as order_number,
						 `d`.`agency_name` as `distributor_name`, d.distributor_id as distributor_id,
						 `d`.`distributor_code` ');
		$this->db->from('order o');
		$this->db->join('distributor_order do','o.order_id=do.order_id','left');
		$this->db->join('distributor d','do.distributor_id=d.distributor_id','left');
		$this->db->join('plant_order po','po.order_id = o.order_id','left');
		$this->db->join('plant pl','o.lifting_point=pl.plant_id');
		$this->db->where('o.order_id',$order_id);		
		$res=$this->db->get();
		return $res->row_array();
	}


}