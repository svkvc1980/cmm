<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by maruthi on 21th Feb 2017 9:00AM
*/

class Oil_stock_balance_m extends CI_Model {

	public function oil_stock_balance_results($current_offset, $per_page, $search_params)
	{	
					
		$this->db->select('osb.*,(osb.opening_balance+osb.receipts+osb.recovered-osb.production-osb.closing_balance) as wastage');
		$this->db->from('oil_stock_balance osb');
		if($search_params['loose_oil_id']!='')
			$this->db->where('osb.loose_oil_id',$search_params['loose_oil_id']);		
		if($search_params['from_date']!='')
			$this->db->where('osb.on_date>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('osb.on_date<=',$search_params['to_date']);
		//$this->db->where('osb.closing_balance IS NOT NULL',NULL);
		$this->db->where('osb.plant_id',get_plant_id());
		$this->db->order_by('osb.oil_stock_balance_id','DESC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();
		return $res->result_array();
	}	
	public function oil_stock_balance_total_num_rows($search_params)
	{		
		$this->db->select('osb.*,(osb.opening_balance+osb.receipts+osb.recovered-osb.production-osb.closing_balance) as wastage');
		$this->db->from('oil_stock_balance osb');
		if($search_params['loose_oil_id']!='')
			$this->db->where('osb.loose_oil_id',$search_params['loose_oil_id']);		
		if($search_params['from_date']!='')
			$this->db->where('osb.on_date>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('osb.on_date<=',$search_params['to_date']);
		//$this->db->where('osb.closing_balance IS NOT NULL',NULL);
		$this->db->where('osb.plant_id',get_plant_id());
		$this->db->order_by('osb.oil_stock_balance_id','DESC');
		$res = $this->db->get();
		return $res->num_rows();
	}	
	public function oil_stock_balance_details($search_params)
	{		
		$this->db->select('osb.*,(osb.opening_balance+osb.receipts+osb.recovered-osb.production-osb.closing_balance) as wastage');
		$this->db->from('oil_stock_balance osb');
		if($search_params['loose_oil_id']!='')
			$this->db->where('osb.loose_oil_id',$search_params['loose_oil_id']);		
		if($search_params['from_date']!='')
			$this->db->where('osb.on_date>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('osb.on_date<=',$search_params['to_date']);
		//$this->db->where('osb.closing_balance IS NOT NULL',NULL);
		$this->db->where('osb.plant_id',get_plant_id());
		$this->db->order_by('osb.oil_stock_balance_id','DESC');	
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_latest_stock_balance_record($loose_oil_id=0)
	{
		$this->db->select('osb.*');
		$this->db->from('oil_stock_balance osb');		
		if($loose_oil_id !== 0)
			$this->db->where('osb.loose_oil_id',$loose_oil_id);
		$this->db->where('osb.closing_balance IS NULL',NULL);
		$this->db->where('osb.plant_id',get_plant_id());
		$this->db->order_by('osb.on_date','DESC');
		$this->db->limit('1');
		$res = $this->db->get();
		if($res->num_rows()>0)
			return $res->row_array();
		else
			return FALSE;
	}

	// checking while taking reading to allow one time reading in a day
	public function get_today_num_of_records($loose_oil_id=0)
	{
		$this->db->select('osb.*');
		$this->db->from('oil_stock_balance osb');		
		$this->db->where('osb.closing_balance IS NULL',NULL);
		$this->db->where('osb.plant_id',get_plant_id());
		$this->db->where('osb.on_date = CURDATE()');
		$this->db->order_by('osb.on_date','DESC');
		$this->db->limit('1');
		$res = $this->db->get();
		if($res->num_rows()>0)
			return $res->row_array();
		else
			return FALSE;
	}
	

	
	
	
}