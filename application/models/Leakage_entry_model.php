<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Leakage_entry_model extends CI_Model {

	public function get_leakage_number($plant_id)
	{
		$financial_year = get_financial_year();
		$this->db->select('max(l.leakage_number) as leakage_number');
		$this->db->from('leakage_entry l');
		$this->db->join('plant_leakage pl','l.leakage_id=pl.leakage_id');
		$this->db->where('pl.plant_id',$plant_id);
		$this->db->where('DATE(created_time)>=',$financial_year['start_date']);
		$this->db->where('DATE(created_time)<=',$financial_year['end_date']);
		$res = $this->db->get();
		if($res->num_rows()>0)
		{
			$row = $res->row_array();
			$leakage_number=$row['leakage_number']+1;
		}
		else
		{
			$leakage_number='1';
		}

		$this->db->select('max(l.leakage_number) as leakage_number');
		$this->db->from('leakage_entry l');
		$this->db->join('counter_leakage cl','l.leakage_id=cl.leakage_id');
		$this->db->join('plant_counter pc','cl.counter_id=pc.counter_id');
		$this->db->where('pc.plant_id',$plant_id);
		$this->db->where('DATE(created_time)>=',$financial_year['start_date']);
		$this->db->where('DATE(created_time)<=',$financial_year['end_date']);
		$res = $this->db->get();
		if($res->num_rows()>0)
		{
			$row = $res->row_array();
			$counter_leakage = $row['leakage_number']+1;
		}
		else
		{
			$counter_leakage ='1';
		}

		return max($counter_leakage,$leakage_number);
	}

	public function get_product_id($plant_id)
	{	
		$this->db->select('product_id');
		$this->db->from('plant_product');
		$this->db->where('plant_id',$plant_id);
		$this->db->where('quantity!=',0);
		$res = $this->db->get();
		foreach ($res->result_array() as $key => $value) {
			$sam[] = $value['product_id'];
		}
		return $sam;
	}

	public function get_product_results($product_id,$plant_data)
	{
		//$this->db->select('CONCAT_WS(c.name,p.short_name,u.name) as product_name');
		$this->db->select('p.product_id as product_id,p.items_per_carton,p.name as product_name');
		$this->db->from('product p');
		$this->db->join('product_capacity pc','p.product_id=pc.product_id');
        $this->db->join('capacity c','pc.capacity_id=c.capacity_id');
        $this->db->join('unit u','c.unit_id=u.unit_id');
        $this->db->where_in('p.product_id',$plant_data);
        if($product_id !='')
        {
        	$this->db->where('p.product_id',$product_id);
        }
        $res = $this->db->get();
        if($product_id !='')
        {
        	return $res->row_array();
        }
        else
        {
        	return $res->result_array();
        }
	}

	public function get_leakage_list_total_num_rows($search_params,$block_id,$plant_id)
	{
		$this->db->select('l.*');
		$this->db->from('leakage_entry l');
		if($block_id == get_ops_block_id())
		{
			$this->db->join('plant_leakage pl','l.leakage_id=pl.leakage_id');
			$this->db->where('pl.plant_id',$plant_id);
		}
		if($block_id == get_candf_block_id() OR $block_id == get_stock_block_id())
		{
			$this->db->join('plant_leakage pl','l.leakage_id=pl.leakage_id');
			$this->db->join('counter_leakage cl','l.leakage_id=cl.leakage_id');
			$this->db->join('plant_counter pc','cl.counter_id=pc.counter_id');
			$where="(pl.plant_id=".$plant_id." OR pc.plant_id=".$plant_id.")";
			$this->db->where($where);
		}
        if($search_params['leakage_number']!='')
            $this->db->where('l.leakage_number',$search_params['leakage_number']);
        if($search_params['on_date']!='')
            $this->db->where('l.on_date',$search_params['on_date']);
        $this->db->order_by('l.leakage_id DESC');
        $res = $this->db->get();
        return $res->num_rows();
	}

	public function view_leakage_results($search_params, $per_page ,$current_offset,$block_id,$plant_id)
	{
		$this->db->select('l.*');
		$this->db->from('leakage_entry l');
		if($block_id == get_ops_block_id())
		{
			$this->db->join('plant_leakage pl','l.leakage_id=pl.leakage_id','left');
			$this->db->where('pl.plant_id',$plant_id);
		}
		if($block_id == get_candf_block_id() OR $block_id == get_stock_block_id())
		{
			$this->db->join('plant_leakage pl','l.leakage_id=pl.leakage_id','left');
			$this->db->join('counter_leakage cl','l.leakage_id=cl.leakage_id','left');
			$this->db->join('plant_counter pc','cl.counter_id=pc.counter_id','left');
			$where="(pl.plant_id=".$plant_id."  OR pc.plant_id=".$plant_id.")";
			$this->db->where($where);
		}
        if($search_params['leakage_number']!='')
            $this->db->where('l.leakage_number',$search_params['leakage_number']);
        if($search_params['on_date']!='')
            $this->db->where('l.on_date',$search_params['on_date']);
        $this->db->order_by('l.leakage_id DESC');
        $this->db->limit($per_page, $current_offset);
        $res = $this->db->get();
        return $res->result_array();
	}

	public function get_leakage_products($leakage_id)
    {
       $this->db->select('lp.quantity,lp.items_per_carton,p.name');
       $this->db->from('leakage_product lp');
       $this->db->join('product p','lp.product_id=p.product_id');
       $this->db->where('lp.leakage_id',$leakage_id);
       $res=$this->db->get();
       return $res->result_array();
	}
}