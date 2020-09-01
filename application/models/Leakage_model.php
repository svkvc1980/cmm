<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Leakage_model extends CI_Model
{
	//Mounika
   //retriving data from Plant Product table
    public function get_packets_per_kg1($product_id,$pm_id,$micron_id)
    {
        $capacity_id = get_capacity_id($product_id);
        $this->db->select('cm.value,pfs.quantity as present_quantity,pfs.plant_film_stock_id as pfs_id');
        $this->db->from('plant_film_stock pfs');       
        $this->db->join('micron m','m.micron_id = pfs.micron_id');
        $this->db->join('capacity_micron cm','cm.micron_id = m.micron_id');
        //$this->db->where('tr.status',get_tanker_received_pm_status());// get received pm status weather goods received or not
        $this->db->where('pfs.plant_id',get_plant_id());
        $this->db->where('pfs.pm_id',$pm_id);
        $this->db->where('pfs.status',1);
        $this->db->where('cm.capacity_id',$capacity_id);
        $this->db->where('cm.micron_id',$micron_id);
        $this->db->order_by('pfs.plant_film_stock_id','DESC');
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
    public function get_micron_and_pm_id($product_id)
    {
        $this->db->select('ppm.*');
        $this->db->from('production_pm_micron ppm');
        $this->db->join('production_product pp','ppm.production_product_id = pp.production_product_id');
        $this->db->join('plant_production ptp','pp.plant_production_id = ptp.plant_production_id');
        $this->db->where('ptp.plant_id',get_plant_id());
        $this->db->where('pp.product_id',$product_id);
        $res = $this->db->get();
        $result = $res->row_array();
        return $result['micron_id'];
    }
    public function get_product()
    { 
        $this->db->select('p.product_id,p.name as product_name');
        $this->db->from('product p');
        $this->db->where('p.status',1);
       // $this->db->join('product p','pp.product_id=p.product_id');
        $res = $this->db->get();
        return $res->result_array();
    }
    public function get_max_leakage_number($plant_id)
    {
        $financial_year = get_financial_year();
        $this->db->select('max(leakage_number) as leakage_number');
        $this->db->from('ops_leakage');
        $this->db->where('DATE(created_time)>=',$financial_year['start_date']);
        $this->db->where('DATE(created_time)<=',$financial_year['end_date']);
        $this->db->where('plant_id',$plant_id);
        $res = $this->db->get();
        if($res->num_rows()>0)
        {
            $row = $res->row_array();
            return $row['leakage_number']+1;
        }
        else
        {
            return 1;
        }
    }
    public function update_plant_pm_quantity($quantity,$plant_id,$pm_id)
    {
        $qry = "INSERT INTO plant_pm(plant_id,pm_id,quantity,updated_time) 
                    VALUES (".$plant_id.",".$pm_id.",".-$quantity.",'".date('Y-m-d H:i:s')."')  
                    ON DUPLICATE KEY UPDATE quantity = quantity+VALUES(quantity),updated_time = VALUES(updated_time) ;";
        $this->db->query($qry);
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
    // update film Stock in Consumption Quantity
    public function update_plant_film_stock($pfs_id,$film_consumption)
    {
        $qry ='UPDATE plant_film_stock SET quantity = quantity - "'.$film_consumption.'"
                WHERE plant_film_stock_id = '.$pfs_id.' ';
        $this->db->query($qry);
    }
    public function update_plant_film_stock_status($pfs_id,$film_consumption)
    {
        $qry ='UPDATE plant_film_stock SET status=2,consumed_quantity = consumed_quantity + '.$film_consumption.'
                WHERE plant_film_stock_id = '.$pfs_id.' ';
        $this->db->query($qry);
    }
     public function update_carton_diff($product_id,$diff_cartons)
    {
        $qry = "INSERT INTO plant_product(plant_id,product_id,quantity,updated_time) 
                    VALUES (".get_plant_id().",".$product_id.",".-$diff_cartons.",'".date('Y-m-d H:i:s')."')  
                    ON DUPLICATE KEY UPDATE quantity = quantity+VALUES(quantity),updated_time = VALUES(updated_time) ;";
        $this->db->query($qry);
    }
    public function get_product_quantity_count($product_id,$plant_id,$carton_quantity)
    {
        $this->db->from('plant_product');
        $this->db->where('product_id',$product_id);
        $this->db->where('plant_id',$plant_id);
        $this->db->where('quantity >=',$carton_quantity);
        $res=$this->db->get();
        return $res->num_rows();
    }
}