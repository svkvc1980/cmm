<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by maruthi on 21th Feb 2017 9:00AM
*/

class Production_m extends CI_Model {

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

	public function production_results($current_offset, $per_page, $search_params)
	{	
					
		$this->db->select('lo.name as lo_name,p.name as p_name,pdp.quantity as quantity,pdp.loose_pouches,
						((pdp.quantity*pdp.items_per_carton)+loose_pouches) as sachets,
						(((pdp.quantity*pdp.items_per_carton)+loose_pouches)*p.oil_weight) as tot_oil_wt,
						DATE(ptp.production_date) as production_date,u.name as user_name');
		$this->db->from('loose_oil lo');
		if($search_params['loose_oil_id']!='')
			$this->db->where('lo.loose_oil_id',$search_params['loose_oil_id']);
		if($search_params['created_by']!='')
			$this->db->where('ptp.created_by',$search_params['created_by']);
		if($search_params['product_id']!='')
			$this->db->where('p.product_id',$search_params['product_id']);
		if($search_params['from_date']!='')
			$this->db->where('DATE(ptp.production_date)>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('DATE(ptp.production_date)<=',$search_params['to_date']);
		$this->db->order_by('ptp.production_date','DESC');
		$this->db->limit($per_page, $current_offset);
		$this->db->join('product p','p.loose_oil_id=lo.loose_oil_id');
		$this->db->join('production_product pdp','p.product_id=pdp.product_id');
		$this->db->join('plant_production ptp','ptp.plant_production_id=pdp.plant_production_id');
		$this->db->join('user u','u.user_id=ptp.created_by','left');
		$plant_id = get_plant_id();
		$this->db->where('ptp.plant_id',$plant_id);
		$res = $this->db->get();
		return $res->result_array();
	}
	
	public function production_total_num_rows($search_params)
	{		
		$this->db->select('lo.name as lo_name,p.name as p_name,pdp.quantity as quantity,pdp.loose_pouches,
						((pdp.quantity*pdp.items_per_carton)+loose_pouches) as sachets,
						(((pdp.quantity*pdp.items_per_carton)+loose_pouches)*p.oil_weight) as tot_oil_wt,
						DATE(ptp.production_date) as production_date,u.name as user_name');
		$this->db->from('loose_oil lo');
		if($search_params['loose_oil_id']!='')
			$this->db->where('lo.loose_oil_id',$search_params['loose_oil_id']);
		if($search_params['created_by']!='')
			$this->db->where('ptp.created_by',$search_params['created_by']);
		if($search_params['product_id']!='')
			$this->db->where('p.product_id',$search_params['product_id']);
		if($search_params['from_date']!='')
			$this->db->where('DATE(ptp.production_date)>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('DATE(ptp.production_date)<=',$search_params['to_date']);
		$this->db->order_by('ptp.production_date','DESC');
		$this->db->join('product p','p.loose_oil_id=lo.loose_oil_id');
		$this->db->join('production_product pdp','p.product_id=pdp.product_id');
		$this->db->join('plant_production ptp','ptp.plant_production_id=pdp.plant_production_id');
		$this->db->join('user u','u.user_id=ptp.created_by','left');
		$plant_id = get_plant_id();
		$this->db->where('ptp.plant_id',$plant_id);
		$res = $this->db->get();
		return $res->num_rows();
	}
	
	public function production_details($search_params)
	{		
		$this->db->select('lo.name as lo_name,p.name as p_name,pdp.quantity as quantity,
						(pdp.quantity*pdp.items_per_carton) as sachets,
						(pdp.quantity*pdp.items_per_carton*p.oil_weight) as tot_oil_wt,
						DATE(ptp.production_date) as production_date,u.name as user_name');
		$this->db->from('loose_oil lo');
		if($search_params['loose_oil_id']!='')
			$this->db->where('lo.loose_oil_id',$search_params['loose_oil_id']);
		if($search_params['created_by']!='')
			$this->db->where('ptp.created_by',$search_params['created_by']);
		if($search_params['product_id']!='')
			$this->db->where('p.product_id',$search_params['product_id']);
		if($search_params['from_date']!='')
			$this->db->where('DATE(ptp.production_date)>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('DATE(ptp.production_date)<=',$search_params['to_date']);
		$this->db->order_by('ptp.production_date','DESC');
		$this->db->join('product p','p.loose_oil_id=lo.loose_oil_id');
		$this->db->join('production_product pdp','p.product_id=pdp.product_id');
		$this->db->join('plant_production ptp','ptp.plant_production_id=pdp.plant_production_id');
		$this->db->join('user u','u.user_id=ptp.created_by','left');
		$plant_id = get_plant_id();
		$this->db->where('ptp.plant_id',$plant_id);		
		$res = $this->db->get();
		return $res->result_array();
	}


	public function insert_update_production($product_id,$quantity,$loose_pouches)
	{
		$qry = "INSERT INTO plant_product(plant_id,product_id,quantity,loose_pouches,updated_time) 
                    VALUES (".get_plant_id().",".$product_id.",".$quantity.",".$loose_pouches.",'".date('Y-m-d H:i:s')."')  
                    ON DUPLICATE KEY UPDATE quantity = quantity+VALUES(quantity), loose_pouches = VALUES(loose_pouches),updated_time = VALUES(updated_time) ;";
        $this->db->query($qry);
       // echo $this->db->last_query();
	}

	public function get_today_production_based_on_plant($on_date)
	{
		$this->db->select('sum(p.oil_weight*p.items_per_carton*pdp.quantity)/1000 as production,p.loose_oil_id');
		$this->db->from('plant_production ptp');
		$this->db->join('production_product pdp','ptp.plant_production_id=pdp.plant_production_id');
		$this->db->join('product p','p.product_id=pdp.product_id');
		$this->db->where('ptp.plant_id',get_plant_id());
		//$this->db->where('ptp.production_date  = CURDATE()');
		$this->db->where('ptp.production_date >=', $on_date);
		$this->db->where('ptp.production_date <= CURDATE()');
		$this->db->group_by('p.loose_oil_id');
		$res = $this->db->get();
		/*print_r($res->result_array());exit;
		echo $this->db->last_query();exit;*/
		return $res->result_array();

		/*$qry="select sum(p.oil_weight*p.items_per_carton*pdp.quantity)/1000 as production,p.loose_oil_id
				from plant_production ptp
				JOIN production_product pdp ON ptp.plant_production_id=pdp.plant_production_id
				JOIN product p ON p.product_id=pdp.product_id
				where ptp.plant_id='.get_plant_id().' AND ptp.production_date=DATE(NOW())
				group by p.loose_oil_id";
		$res=$this->db->query($qry);
		return $res->result_array();*/
	}


	// Paking Material
	public function get_latest_pm_stock_balance_record($pm_id=0)
	{
		$this->db->select('psb.*');
		$this->db->from('pm_stock_balance psb');		
		if($pm_id !== 0)
			$this->db->where('psb.pm_id',$pm_id);
		$this->db->where('psb.closing_balance IS NULL',NULL);
		$this->db->where('psb.plant_id',get_plant_id());
		$this->db->order_by('psb.on_date','DESC');
		$this->db->limit('1');
		$res = $this->db->get();

		if($res->num_rows()>0)
			return $res->row_array();
		else
			return FALSE;
	}
	/*public function get_packets_per_kg($pm_id,$micron_id)
	{
		$this->db->select('cm.value,pfs.quantity as present_quantity,pfs.plant_film_stock_id as pfs_id');
		$this->db->from('plant_film_stock pfs');
		$this->db->where('pfs.plant_id',get_plant_id());
		$this->db->where('pfs.pm_id',$pm_id);		
		$this->db->where('pfs.micron_id',$micron_id);
		$res = $this->db->get();
		if($res->num_rows()>0)
		{
			return $res->row_array();
		}
		else{
			return FALSE;
		}
	}*/
	public function get_packets_per_kg($product_id,$pm_id,$micron_id)
	{
		$capacity_id = get_capacity_id($product_id);
		$this->db->select('cm.value,pfs.quantity as present_quantity,pfs.plant_film_stock_id as pfs_id');
		$this->db->from('plant_film_stock pfs');	
		$this->db->join('micron m','m.micron_id = pfs.micron_id');
		$this->db->join('capacity_micron cm','cm.micron_id = m.micron_id');
		//$this->db->where('tr.status',get_tanker_received_pm_status());// get received pm status weather goods received or not
		$this->db->where('pfs.plant_id',get_plant_id());	
		$this->db->where('pfs.micron_id',$micron_id);
		$this->db->where('pfs.pm_id',$pm_id);
		$this->db->where('cm.capacity_id',$capacity_id);
		$this->db->limit('1');		
		$res = $this->db->get();
		/*echo $this->db->last_query();
		print_r($res->result_array());exit;*/
		if($res->num_rows()>0)
		{
			return $res->row_array();
		}
		else{
			return FALSE;
		}
	}
	
	public function update_plant_film_stock($pfs_id,$film_consumption)
	{
		$qry ='UPDATE plant_film_stock SET quantity = quantity - "'.$film_consumption.'"
                WHERE plant_film_stock_id = '.$pfs_id.' ';
        $this->db->query($qry);
	}
	
	
}