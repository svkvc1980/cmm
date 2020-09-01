<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Processing_loss_m extends CI_Model 
{
	public function processing_loss_num_rows($search_params)
	{
		$plant_id = get_plant_id();
		$this->db->select('pl.*');
		$this->db->join('loose_oil l', 'l.loose_oil_id = pl.loose_oil_id');
		$this->db->join('plant p', 'p.plant_id = pl.plant_id');
		$this->db->where('pl.plant_id',$plant_id);
		if($search_params['from_date']!='')
			$this->db->where('pl.on_date >=',format_date($search_params['from_date'],'Y-m-d'));
		if($search_params['to_date']!='')
			$this->db->where('pl.on_date <=',format_date($search_params['to_date'],'Y-m-d'));
		if($search_params['loose_oil']!='')
			$this->db->where('pl.loose_oil_id',$search_params['loose_oil']);
		$res = $this->db->get('ops_processing_loss pl');
		return $res->num_rows();
	}

	public function processing_loss_results($per_page,$current_offset,$search_params)
	{
		$plant_id = get_plant_id();
		$this->db->select('pl.*, l.name as loose_oil, p.name as plant');
		$this->db->join('loose_oil l', 'l.loose_oil_id = pl.loose_oil_id');
		$this->db->join('plant p', 'p.plant_id = pl.plant_id');
		$this->db->where('pl.plant_id',$plant_id);
		if($search_params['from_date']!='')
			$this->db->where('pl.on_date >=',format_date($search_params['from_date'],'Y-m-d'));
		if($search_params['to_date']!='')
			$this->db->where('pl.on_date <=',format_date($search_params['to_date'],'Y-m-d'));
		if($search_params['loose_oil']!='')
			$this->db->where('pl.loose_oil_id',$search_params['loose_oil']);
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get('ops_processing_loss pl');
		//echo $this->db->last_query(); exit;
		return $res->result_array();
	}

	// 31 may 2017 12:26 PM
	public function print_processing_loss($from_date, $to_date, $loose_oil, $ops)
	{
		$plant_id = get_plant_id();  $block_id = get_ses_block_id();
		$this->db->select('pl.*, l.name as loose_oil_name, p.short_name as plant');
		$this->db->join('loose_oil l', 'l.loose_oil_id = pl.loose_oil_id');
		$this->db->join('plant p', 'p.plant_id = pl.plant_id');
		if($from_date!='')
		{
			$this->db->where('pl.on_date >=',format_date($from_date,'Y-m-d'));
		}
		if($to_date!='')
		{
			$this->db->where('pl.on_date <=',format_date($to_date,'Y-m-d'));
		}
		if($loose_oil!='')
		{
			$this->db->where('pl.loose_oil_id',$loose_oil);
		}
		if($block_id == 1)
		{
			$this->db->where('pl.plant_id',$ops);
		}
		else
		{
			$this->db->where('pl.plant_id',$plant_id);
		}
		$this->db->order_by('l.rank, pl.on_date ASC');
		$res = $this->db->get('ops_processing_loss pl');
		//echo $this->db->last_query(); die;
		return $res->result_array();
	}
}