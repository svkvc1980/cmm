<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by maruthi on 21th Feb 2017 9:00AM
*/

class Pm_stock_balance_m extends CI_Model {

	public function pm_stock_balance_results($current_offset, $per_page, $search_params)
	{	
					
		$this->db->select('pmsb.*,(pmsb.opening_balance+pmsb.receipts-pmsb.production-pmsb.closing_balance) as wastage');
		$this->db->select('');
		$this->db->from('pm_stock_balance pmsb');
		if($search_params['pm_id']!='')
			$this->db->where('pmsb.pm_id',$search_params['pm_id']);		
		if($search_params['from_date']!='')
			$this->db->where('pmsb.on_date>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('pmsb.on_date<=',$search_params['to_date']);
		//$this->db->where('pmsb.closing_balance IS NOT NULL',NULL);
		$this->db->where('pmsb.plant_id',get_plant_id());
		$this->db->order_by('pmsb.on_date','DESC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();
		return $res->result_array();
	}	
	public function pm_stock_balance_total_num_rows($search_params)
	{		
		$this->db->select('pmsb.*,(pmsb.opening_balance+pmsb.receipts-pmsb.production-pmsb.closing_balance) as wastage');
		$this->db->select('');
		$this->db->from('pm_stock_balance pmsb');
		if($search_params['pm_id']!='')
			$this->db->where('pmsb.pm_id',$search_params['pm_id']);		
		if($search_params['from_date']!='')
			$this->db->where('pmsb.on_date>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('pmsb.on_date<=',$search_params['to_date']);
		//$this->db->where('pmsb.closing_balance IS NOT NULL',NULL);
		$this->db->where('pmsb.plant_id',get_plant_id());
		$this->db->order_by('pmsb.on_date','DESC');
		$res = $this->db->get();
		return $res->num_rows();
	}	
	public function pm_stock_balance_details($search_params)
	{		
		$this->db->select('pmsb.*,(pmsb.opening_balance+pmsb.receipts-pmsb.production-pmsb.closing_balance) as wastage');
		$this->db->select('');
		$this->db->from('pm_stock_balance pmsb');
		if($search_params['pm_id']!='')
			$this->db->where('pmsb.pm_id',$search_params['pm_id']);		
		if($search_params['from_date']!='')
			$this->db->where('pmsb.on_date>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('pmsb.on_date<=',$search_params['to_date']);
		//$this->db->where('pmsb.closing_balance IS NOT NULL',NULL);
		$this->db->where('pmsb.plant_id',get_plant_id());
		$this->db->order_by('pmsb.on_date','DESC');	
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_latest_stock_balance_record($pm_id=0)
	{
		$this->db->select('pmsb.*');
		$this->db->from('pm_stock_balance pmsb');		
		if($pm_id !== 0)
			$this->db->where('pmsb.pm_id',$pm_id);
		$this->db->where('pmsb.closing_balance IS NULL',NULL);
		$this->db->where('pmsb.plant_id',get_plant_id());
		$this->db->order_by('pmsb.on_date','DESC');
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
		$this->db->select('pmsb.*');
		$this->db->from('pm_stock_balance pmsb');		
		$this->db->where('pmsb.closing_balance IS NULL',NULL);
		$this->db->where('pmsb.plant_id',get_plant_id());
		$this->db->where('pmsb.on_date = CURDATE()');
		$this->db->order_by('pmsb.on_date','DESC');
		$this->db->limit('1');
		$res = $this->db->get();
		if($res->num_rows()>0)
			return $res->row_array();
		else
			return FALSE;
	}
	public function insert_update_pm_stock($pm_id,$quantity)
	{
		$qry = "INSERT INTO plant_pm(plant_id,pm_id,quantity,updated_time) 
                    VALUES (".get_plant_id().",".$pm_id.",".$quantity.",'".date('Y-m-d H:i:s')."')  
                    ON DUPLICATE KEY UPDATE quantity = VALUES(quantity),updated_time = VALUES(updated_time) ;";
        $this->db->query($qry);
       // echo $this->db->last_query();
	}

	/*Packing Material Category List
	Author:Srilekha
	Time: 01.01PM 05-03-2017 */
	public function get_pm() 
	{
		$block_id = $this->session->userdata('block_id');
		$this->db->from('pm_group');
		$this->db->where('status',1);
		$res=$this->db->get();
		
		if($block_id!=2)
		{
			$this->db->where_not_in('pm_group_id',1);
		}
		
		return $res->result_array();
	}
	/*Packing Material List
	Author:Srilekha
	Time: 01.01PM 05-03-2017 */
	public function get_sub_pm_by_pm($pm_category_id)
	{	$film_id = get_film_id();
		$this->db->from('packing_material');
		$this->db->where('pm_group_id',$pm_category_id);
		$this->db->where('status',1);
		$this->db->where_not_in('pm_group_id',$film_id);
		$this->db->order_by('name');
		$res=$this->db->get();
		return $res->result_array();
	}
	
}