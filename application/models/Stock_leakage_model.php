<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock_leakage_model extends CI_Model
{

    public function get_max_leakage_number($plant_id)
    {
        $financial_year = get_financial_year();
        $this->db->select('max(leakage_number) as leakage_number');
        $this->db->from('leakage_entry');
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
     public function get_product()
    { 
        $this->db->select('p.product_id,p.name as product_name');
        $this->db->from ('product p');
        $this->db->where('p.status',1);
        $res = $this->db->get();
        return $res->result_array();
    }

    public function update_recovery_oil($loose_oil_id,$recovered_oil,$plant_id)
    {
        $qry = "INSERT INTO plant_recovery_oil(plant_id,loose_oil_id,oil_weight,updated_time) 
                    VALUES (".$plant_id.",".$loose_oil_id.",".$recovered_oil.",'".date('Y-m-d H:i:s')."')  
                    ON DUPLICATE KEY UPDATE oil_weight = oil_weight+VALUES(oil_weight),updated_time = VALUES(updated_time) ;";
        $this->db->query($qry);
    }
    public function update_plant_product_stock($product_id,$leaked_pouches,$plant_id)
    {
         $qry = "INSERT INTO plant_product(plant_id,product_id,quantity,updated_time) 
                    VALUES (".$plant_id.",".$product_id.",".-$leaked_pouches.",'".date('Y-m-d H:i:s')."')  
                    ON DUPLICATE KEY UPDATE quantity = quantity+VALUES(quantity),updated_time = VALUES(updated_time) ;";
        $this->db->query($qry);
    }
    public function update_plant_counter_quantity($counter_id,$product_id,$leaked_pouches)
    {
        $qry = "INSERT INTO plant_counter_product(counter_id,product_id,quantity,updated_time) 
                    VALUES (".$counter_id.",".$product_id.",".-$leaked_pouches.",'".date('Y-m-d H:i:s')."')  
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
    public function update_plant_pm_quantity($quantity,$plant_id,$pm_id)
    {
        $qry = "INSERT INTO plant_pm(plant_id,pm_id,quantity,updated_time) 
                    VALUES (".$plant_id.",".$pm_id.",".-$quantity.",'".date('Y-m-d H:i:s')."')  
                    ON DUPLICATE KEY UPDATE quantity = quantity+VALUES(quantity),updated_time = VALUES(updated_time) ;";
        $this->db->query($qry);
    }
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
    public function get_product_quantity_count($product_id,$plant_id,$carton_quantity)
    {
        $this->db->from('plant_product');
        $this->db->where('product_id',$product_id);
        $this->db->where('plant_id',$plant_id);
        $this->db->where('quantity >=',$carton_quantity);
        $res=$this->db->get();
        return $res->num_rows();
    }

    public function get_counter_quantity_count($product_id,$plant_id,$carton_quantity)
    {
        $this->db->select("pp.quantity as qty1,pcp.quantity as qty2,p.items_per_carton,pp.loose_pouches");
        $this->db->from('plant_product pp');
        $this->db->join('plant_counter pc', 'pp.plant_id = pc.plant_id');
        $this->db->join('plant_counter_product pcp', 'pcp.product_id = pp.product_id AND pc.counter_id= pcp.counter_id','left');
        $this->db->join('product p','p.product_id = pp.product_id');
        $this->db->where('pp.product_id', $product_id);
        $this->db->where('pp.plant_id', $plant_id);
        $this->db->where('pcp.quantity >=',$carton_quantity);
        $res=$this->db->get();
        return $res->num_rows();
    }
}