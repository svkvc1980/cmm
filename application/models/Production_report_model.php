<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Production_report_model extends CI_Model {

	//Mounika
        public function get_production_details($start_date,$end_date,$loose_oil_id)
	{
		$this->db->select('pp.production_product_id,sum(pp.quantity) as quantity,pp.items_per_carton,ppr.plant_production_id,ppr.production_date,p.product_id,p.name as product_name,p.oil_weight,pl.plant_id,pl.name as plant_name');
		$this->db->from('production_product pp');
		$this->db->join('plant_production ppr', 'pp.plant_production_id=ppr.plant_production_id');
        $this->db->join('product p', 'pp.product_id=p.product_id');
        $this->db->join('loose_oil l','l.loose_oil_id = p.loose_oil_id');
        $this->db->join('product_capacity pc','pc.product_id = p.product_id');
        $this->db->join('capacity c','c.capacity_id = pc.capacity_id');
        $this->db->join('plant pl','ppr.plant_id=pl.plant_id');
        $this->db->where('ppr.production_date >=',$start_date);
        $this->db->where('ppr.production_date <=',$end_date);
        if($loose_oil_id!='')
        {
        	$this->db->where('l.loose_oil_id',$loose_oil_id);
        }
        $this->db->group_by('pp.product_id,ppr.production_date');
        $this->db->order_by('ppr.production_date ASC','l.rank ASC','c.rank ASC');
        $res = $this->db->get();
		return $res->result_array();
	}
}