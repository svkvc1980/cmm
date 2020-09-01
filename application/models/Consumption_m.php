<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Consumption_m extends CI_Model {	

	public function production_consumption_total_num_rows($search_params)
    {         
        $qry = 'SELECT  `ppp`.`product_id`, `ppp`.`production_product_id`, `ppp`.`quantity` as `production_qty`,
                `prm`.`pm_id`,`prm`.`quantity` as `consumption_per_unit`,
                `pp`.`production_date`,
                 case when pm.pm_group_id =1 then `ppmic`.`quantity` 
                 else `ppm`.`quantity` end as `pm_qty`,
                 `p`.`product_id`, `p`.`name` as `product_name`,`pm`.`name` as `packing_name`,`m`.`name` as `mc_name`
                FROM `plant_production` `pp` 
                INNER JOIN `production_product` `ppp` ON `pp`.`plant_production_id`=`ppp`.`plant_production_id` 
                INNER JOIN `product` `p` ON `ppp`.`product_id`=`p`.`product_id`
                LEFT JOIN `product_packing_material` `prm` ON `prm`.`product_id`=`ppp`.`product_id` 
                LEFT JOIN `packing_material` `pm` ON `prm`.`pm_id`=`pm`.`pm_id`
                LEFT JOIN `production_pm` `ppm` ON `ppp`.`production_product_id`=`ppm`.`production_product_id` and `ppm`.`pm_id`=`prm`.`pm_id`
                LEFT JOIN `production_pm_micron` `ppmic` ON `ppp`.`production_product_id`=`ppmic`.`production_product_id` and `ppmic`.`pm_id`=`prm`.`pm_id`
                LEFT JOIN micron as m ON m.micron_id = ppmic.micron_id
                WHERE p.status =1 '; 
        if($search_params['start_date']!='')
            $qry .='AND pp.production_date >="'.$search_params['start_date'].'" ';
        if($search_params['end_date']!='')
            $qry .='AND pp.production_date <="'.$search_params['end_date'].'" ';
        if($search_params['product_id']!='')
            $qry.='AND ppp.product_id ="'.$search_params['product_id'].'" '; 
        if($search_params['pm_id']!='')
            $qry .= 'AND prm.pm_id = "'.$search_params['pm_id'].'" ';
        $res = $this->db->query($qry);
        //echo $this->db->last_query();exit;
        //echo $res->num_rows();exit;
        return $res->num_rows();
    }

    public function production_consumption_results($search_params,$per_page,$current_offset)
    {      
         $qry = 'SELECT  `ppp`.`product_id`, `ppp`.`production_product_id`, `ppp`.`quantity` as `production_qty`,
                `prm`.`pm_id`,`prm`.`quantity` as `consumption_per_unit`,
                `pp`.`production_date`,
                 case when pm.pm_group_id =1 then `ppmic`.`quantity` 
                 else `ppm`.`quantity` end as `pm_qty`,
                 `p`.`product_id`, `p`.`short_name` as `product_name`,`pm`.`name` as `packing_name`,`m`.`name` as `mc_name`,m.micron_id as mic_id
                FROM `plant_production` `pp` 
                INNER JOIN `production_product` `ppp` ON `pp`.`plant_production_id`=`ppp`.`plant_production_id` 
                INNER JOIN `product` `p` ON `ppp`.`product_id`=`p`.`product_id`
                LEFT JOIN `product_packing_material` `prm` ON `prm`.`product_id`=`ppp`.`product_id` 
                LEFT JOIN `packing_material` `pm` ON `prm`.`pm_id`=`pm`.`pm_id`
                LEFT JOIN `production_pm` `ppm` ON `ppp`.`production_product_id`=`ppm`.`production_product_id` and `ppm`.`pm_id`=`prm`.`pm_id`
                LEFT JOIN `production_pm_micron` `ppmic` ON `ppp`.`production_product_id`=`ppmic`.`production_product_id` and `ppmic`.`pm_id`=`prm`.`pm_id`
                LEFT JOIN micron as m ON m.micron_id = ppmic.micron_id
                WHERE p.status =1 '; 
        if($search_params['start_date']!='')
            $qry .='AND pp.production_date >="'.$search_params['start_date'].'" ';
        if($search_params['end_date']!='')
            $qry .='AND pp.production_date <="'.$search_params['end_date'].'" ';
        if($search_params['product_id']!='')
            $qry.='AND ppp.product_id ="'.$search_params['product_id'].'" '; 
        if($search_params['pm_id']!='')
            $qry .= 'AND prm.pm_id = "'.$search_params['pm_id'].'" ';       
        $qry.='ORDER BY pp.production_date DESC,ppp.production_product_id DESC ';
        $qry.=' LIMIT '.$current_offset.','.$per_page.' ';  
        /*echo $qry; die();*/               
        $res1 = $this->db->query($qry);
        /*echo $this->db->last_query();exit;
        echo $res1->num_rows();exit;        */
        /*echo '<pre>';
        print_r($res1->result_array());exit;*/
        return $res1->result_array();
    }
    public function leakage_consumption_total_num_rows($search_params)
    {         
        $qry = 'SELECT  `opsl`.`product_id`, `opsl`.`ops_leakage_id`, `opsl`.`leaked_pouches` as `leakage_qty`,
                opsl.oil_recovered as recovered_oil, (opsl.leaked_pouches*p.items_per_carton*p.oil_weight) as actual_oil_weight,
                `prm`.`pm_id`,`prm`.`quantity` as `consumption_per_unit`,
                `opsl`.`on_date`,
                 case when pm.pm_group_id =1 and opsl.recover_type =1 then `lpmic`.`quantity` 
                 else `lpm`.`quantity`  end as `pm_qty`,
                 `p`.`product_id`, `p`.`name` as `product_name`,`pm`.`name` as `packing_name`,`m`.`name` as `mc_name`
                FROM `ops_leakage` `opsl`                
                INNER JOIN `product` `p` ON `opsl`.`product_id`=`p`.`product_id`
                LEFT JOIN `product_packing_material` `prm` ON `prm`.`product_id`=`opsl`.`product_id` 
                LEFT JOIN `packing_material` `pm` ON `prm`.`pm_id`=`pm`.`pm_id`
                LEFT JOIN `leakage_pm` `lpm` ON `lpm`.`ops_leakage_id`=`opsl`.`ops_leakage_id` and `lpm`.`pm_id`=`prm`.`pm_id`
                LEFT JOIN `leakage_pm_micron` `lpmic` ON `lpmic`.`ops_leakage_id`=`opsl`.`ops_leakage_id` and `lpmic`.`pm_id`=`prm`.`pm_id`
                LEFT JOIN micron as m ON m.micron_id = lpmic.micron_id
                WHERE p.status =1 '; 
        if($search_params['start_date']!='')
            $qry .='AND opsl.on_date >="'.$search_params['start_date'].'" ';
        if($search_params['end_date']!='')
            $qry .='AND opsl.on_date <="'.$search_params['end_date'].'" ';
        if($search_params['product_id']!='')
            $qry.='AND opsl.product_id ="'.$search_params['product_id'].'" '; 
        if($search_params['pm_id']!='')
            $qry .= 'AND prm.pm_id = "'.$search_params['pm_id'].'" ';
        $res = $this->db->query($qry);
        //echo $this->db->last_query();exit;
        //echo $res->num_rows();exit;
        return $res->num_rows();
    }

    public function leakage_consumption_results($search_params,$per_page,$current_offset)
    {      
         $qry = 'SELECT  `opsl`.`product_id`, `opsl`.`ops_leakage_id`, `opsl`.`leakage_quantity` as `leakage_qty`,
                `opsl`.`leaked_pouches` as `leakage_pouches`,pm.pm_group_id as pm_group_id,
                opsl.oil_recovered as recovered_oil, (opsl.leaked_pouches*p.oil_weight) as oil_weight,
                `prm`.`pm_id`,`prm`.`quantity` as `consumption_per_unit`,
                `opsl`.`on_date`,opsl.recover_type,lpmic.leakage_pm_id,
                 case when pm.pm_group_id =1 and opsl.recover_type =1 then `lpmic`.`quantity` 
                 else `lpm`.`quantity`  end as `pm_qty`,
                 `p`.`product_id`, `p`.`short_name` as `product_name`,`pm`.`name` as `packing_name`,`m`.`name` as `mc_name`,m.micron_id as mic_id
                FROM `ops_leakage` `opsl`                
                INNER JOIN `product` `p` ON `opsl`.`product_id`=`p`.`product_id`
                LEFT JOIN `product_packing_material` `prm` ON `prm`.`product_id`=`opsl`.`product_id` 
                LEFT JOIN `packing_material` `pm` ON `prm`.`pm_id`=`pm`.`pm_id`
                LEFT JOIN `leakage_pm` `lpm` ON `lpm`.`ops_leakage_id`=`opsl`.`ops_leakage_id` and `lpm`.`pm_id`=`prm`.`pm_id`
                LEFT JOIN `leakage_pm_micron` `lpmic` ON `lpmic`.`ops_leakage_id`=`opsl`.`ops_leakage_id` and `lpmic`.`pm_id`=`prm`.`pm_id`
                LEFT JOIN micron as m ON m.micron_id = lpmic.micron_id
                WHERE p.status =1 '; 
        if($search_params['start_date']!='')
            $qry .='AND opsl.on_date >="'.$search_params['start_date'].'" ';
        if($search_params['end_date']!='')
            $qry .='AND opsl.on_date <="'.$search_params['end_date'].'" ';
        if($search_params['product_id']!='')
            $qry.='AND opsl.product_id ="'.$search_params['product_id'].'" '; 
        if($search_params['pm_id']!='')
            $qry .= 'AND prm.pm_id = "'.$search_params['pm_id'].'" ';      
        $qry.='ORDER BY opsl.on_date DESC,opsl.ops_leakage_id DESC';
        $qry.=' LIMIT '.$current_offset.','.$per_page.' ';  
        /*echo $qry; die();*/               
        $res1 = $this->db->query($qry);
        /*echo $this->db->last_query();exit;
        echo $res1->num_rows();exit;        */
        /*echo '<pre>';
        print_r($res1->result_array());exit;*/
        return $res1->result_array();
    }
    function get_product_pm_data($product_id=0)
    {
        $this->db->select('pm.pm_id,pm.name as pm_name');
        $this->db->from('packing_material as pm');       
        if(@$product_id!=0)
        {
           $this->db->join('product_packing_material as pdpm','pm.pm_id = pdpm.pm_id');        
            $this->db->where('pdpm.product_id',$product_id);
        }
        $this->db->where('pm.status',1);
        $res= $this->db->get();
        return $res->result_array();
    }

}

