<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by maruthi on 15th Dec 2016 9:00AM
*/

class Pm_consumption_m extends CI_Model {

	public function get_primary_consumption_data($product_id)
	{
		$this->db->select('pm.pm_id,pm.name as pm_name,pmcat.pm_category_id as pm_cat_id,pmu.name as unit_name,ppm.quantity as quantity');
		$this->db->from('product_packing_material ppm');
		$this->db->join('packing_material_capacity pmc','pmc.pm_id = ppm.pm_id');
		$this->db->join('packing_material pm','pm.pm_id = pmc.pm_id');
		$this->db->join('packing_material_category pmcat','pmcat.pm_category_id = pm.pm_category_id');
		$this->db->join('pm_unit pmu','pmcat.pm_unit = pmu.pm_unit');
		$this->db->where('pmcat.packing_type_id',1);
		$this->db->where('ppm.product_id',$product_id);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_secondary_consumption_data($product_id)
	{
		$this->db->select('pm.pm_id,pmcat.pm_category_id as pm_cat_id,pm.name as pm_name,pmu.name as unit_name,ppm.quantity as quantity');
		$this->db->from('product_packing_material ppm');
		$this->db->join('packing_material_capacity pmc','pmc.pm_id = ppm.pm_id');
		$this->db->join('packing_material pm','pm.pm_id = pmc.pm_id');
		$this->db->join('packing_material_category pmcat','pmcat.pm_category_id = pm.pm_category_id');
		$this->db->join('pm_unit pmu','pmcat.pm_unit = pmu.pm_unit');
		$this->db->where('pmcat.packing_type_id',2);
                $this->db->group_by('pm.pm_id');
		$this->db->where('ppm.product_id',$product_id);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_primary_type($product_id)
	{
		$capacity_id = get_capacity_id($product_id);
		$this->db->select('pm.name as name,pm.pm_id as pm_id,pmu.name as u_type');		
		$this->db->from('packing_material_capacity pmc');
		$this->db->join('packing_material pm','pm.pm_id = pmc.pm_id');
		$this->db->join('packing_material_category pmcat','pmcat.pm_category_id = pm.pm_category_id');		
		$this->db->join('pm_unit pmu','pmu.pm_unit= pmcat.pm_unit');
		$this->db->where('pmcat.packing_type_id',1);		
		$this->db->where('pmc.capacity_id',$capacity_id);
		$res = $this->db->get();
		$pm_data=array();
		if($res->num_rows()>0){
				foreach ($res->result_array() as $row) {
				$pm_data[] =$row;			
			}
		}

		$this->db->select('pm.name as name,pm.pm_id as pm_id,pmu.name as u_type');		
		//$this->db->from('packing_material_capacity pmc');
		$this->db->from('packing_material pm');
		$this->db->join('packing_material_category pmcat','pmcat.pm_category_id = pm.pm_category_id');		
		$this->db->join('pm_unit pmu','pmu.pm_unit= pmcat.pm_unit');
		//$this->db->where('pmcat.packing_type_id',1);		
		//$this->db->where('pmc.capacity_id',$capacity_id);
		$this->db->where('pmcat.pm_category_id',get_tins_id());
		$res = $this->db->get();
		
		if($res->num_rows()>0){
				foreach ($res->result_array() as $row) {
				$pm_data[] =$row;			
			}
		}
		return $pm_data;
		/*echo '<pre>';
		print_r($res->result_array());exit;*/
		//return $res->result_array();

	}
	public function get_secondary_type($product_id)
	{
		$tapes = array(get_tapes_id()); // GET ALL ROLES EXCLUDING SUPER ADMIN, ADMIN
    	//$this->db->where_not_in('r.role_id',$not_include_tape);
    	$capacity_id = get_capacity_id($product_id);
		$this->db->select('pm.name as name,pm.pm_id as pm_id,pmu.name as u_type');		
		$this->db->from('packing_material_capacity pmc');
		$this->db->join('packing_material pm','pm.pm_id = pmc.pm_id');
		$this->db->join('packing_material_category pmcat','pmcat.pm_category_id = pm.pm_category_id');
		$this->db->join('pm_unit pmu','pmu.pm_unit= pmcat.pm_unit');	
		$this->db->where('pmcat.packing_type_id',2);
		
		//$this->db->where('pmc.capacity_id',$capacity_id);
		$this->db->where_not_in('pmcat.pm_category_id',$tapes);
		$res = $this->db->get();
		$pm_data=array();
		if($res->num_rows()>0){
				foreach ($res->result_array() as $row) {
				$pm_data[] =$row;			
			}
		}
		// get_only tapes 
		$this->db->select('pm.name as name,pm.pm_id as pm_id,pmu.name as u_type');		
		$this->db->from('packing_material_category pmcat');
		$this->db->join('packing_material pm','pm.pm_category_id = pmcat.pm_category_id');
		//$this->db->join('packing_material_capacity pmc','pm.pm_id = pmc.pm_id');
		$this->db->join('pm_unit pmu','pmu.pm_unit= pmcat.pm_unit');	
		$this->db->where('pmcat.packing_type_id',2);
		//$this->db->where('pmc.capacity_id',$capacity_id);
		$this->db->where('pmcat.pm_category_id',get_tapes_id());
		$res1 = $this->db->get();
		if($res1->num_rows()>0){
			foreach ($res1->result_array() as $row) {
			$pm_data[] =$row;
			}
		}
		return $pm_data;

	}
	public function insert_update_pm_consumption($product_id,$capacity_id,$pm_id,$quantity)
	{
		$qry = "INSERT INTO product_packing_material(product_id,capacity_id,pm_id,quantity) 
                    VALUES (".$product_id.",".$capacity_id.",".$pm_id.",".$quantity.")  
                    ON DUPLICATE KEY UPDATE quantity = VALUES(quantity) ;";
        $this->db->query($qry);
       // echo $this->db->last_query();
	}

	public function pm_consumption_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('p.*');
		$this->db->from('product p');
		if($search_params['product_id']!='')
			$this->db->like('p.product_id',$search_params['product_id']);
		$this->db->join('product_capacity pc','pc.product_id = p.product_id');
		$this->db->join('product_packing_material ppm','ppm.capacity_id = pc.capacity_id');
		$this->db->group_by('p.product_id');		
		$this->db->where('p.status',1);
		$this->db->limit($per_page, $current_offset);		
		$res = $this->db->get();		
		return $res->result_array();
	}
	
	public function pm_consumption_total_num_rows($search_params)
	{		
		$this->db->select('p.*');
		$this->db->from('product p');
		if($search_params['product_id']!='')
			$this->db->like('p.product_id',$search_params['product_id']);
		$this->db->join('product_capacity pc','pc.product_id = p.product_id');
		$this->db->join('product_packing_material ppm','ppm.capacity_id = pc.capacity_id');
		$this->db->where('p.status',1);
		$this->db->group_by('p.product_id');	
		$res = $this->db->get();
		return $res->num_rows();
	}	

	public function pm_consumption_details($search_params)
	{
		$this->db->select('p.*');
		$this->db->from('product p');
		if($search_params['product_id']!='')
			$this->db->like('p.product_id',$search_params['product_id']);
		$this->db->join('product_capacity pc','pc.product_id = p.product_id');
		$this->db->join('product_packing_material ppm','ppm.capacity_id = pc.capacity_id');
		$this->db->where('p.status',1);
		$this->db->group_by('p.product_id');	
		$res = $this->db->get();
		return $res->result_array();
	}	
}