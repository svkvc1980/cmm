<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ops_wet_cartons_model extends CI_Model {

	//Mounika
	//retriving data from Plant Product table
    public function get_product()
    { 
        $this->db->select('p.product_id,p.name as product_name');
        $this->db->from('plant_product pp');
        $this->db->join('product p','pp.product_id=p.product_id');
        $res = $this->db->get();
        return $res->result_array();
    }

    public function get_secondary_consumption_data($product_id)
	{
		$this->db->select('pm.pm_id,pmcat.pm_category_id as pm_cat_id,pm.name as pm_name,ppm.quantity as quantity');
		$this->db->from('product_packing_material ppm');
		//$this->db->join('packing_material_capacity pmc','pmc.pm_id = ppm.pm_id');
		$this->db->join('packing_material pm','ppm.pm_id = pm.pm_id','left');
		$this->db->join('packing_material_category pmcat','pmcat.pm_category_id = pm.pm_category_id','left');
		//$this->db->join('pm_unit pmu','pmcat.pm_unit = pmu.pm_unit');
		$this->db->where('pmcat.packing_type_id',2);
		$this->db->where('ppm.product_id',$product_id);
		$res = $this->db->get();
		return $res->result_array();
	}
	public function update_plant_pm_quantity($quantity,$plant_id,$pm_id)
	{
		$qry = "INSERT INTO plant_pm(plant_id,pm_id,quantity,updated_time) 
                    VALUES (".$plant_id.",".$pm_id.",".-$quantity.",'".date('Y-m-d H:i:s')."')  
                    ON DUPLICATE KEY UPDATE quantity = quantity+VALUES(quantity),updated_time = VALUES(updated_time) ;";
        $this->db->query($qry);
	}
}