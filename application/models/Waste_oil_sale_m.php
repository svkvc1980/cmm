<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by Roopa on 13th march 2017 11:00AM
*/

class Waste_oil_sale_m extends CI_Model {
    /*waste oil sale results
    Author:Roopa
    Time: 11.00AM 13-03-2017 */
    public function waste_oil_sale_results($current_offset, $per_page, $search_params)
    {       
        $this->db->select('wos.*,wosp.quantity as oil_quantity,wosp.unit_price as oil_cost');
        $this->db->from('waste_oil_sale wos');
        $this->db->join('waste_oil_sale_product wosp','wosp.waste_sale_id=wos.waste_sale_id');
        if($search_params['buyer_name']!='')
            $this->db->like('wos.buyer_name',$search_params['buyer_name']);
        if($search_params['from_date']!='')
            $this->db->where('wos.on_date>=',$search_params['from_date']);
        if($search_params['to_date']!='')
            $this->db->where('wos.on_date<=',$search_params['to_date']);
        $this->db->order_by('wos.on_date');
        $this->db->limit($per_page, $current_offset);
        $res = $this->db->get();        
        return $res->result_array();
    }
    /*getting total rows of waste oil sale...
    Author:Roopa
    Time: 11.00AM 13-03-2017 */
    public function sludge_sale_total_num_rows($search_params)
    {       
        $this->db->select('wos.*,wosp.quantity as oil_quantity,wosp.unit_price as oil_cost');
        $this->db->from('waste_oil_sale wos');
        $this->db->join('waste_oil_sale_product wosp','wosp.waste_sale_id=wos.waste_sale_id');
        if($search_params['buyer_name']!='')
            $this->db->like('wos.buyer_name',$search_params['buyer_name']);
        if($search_params['from_date']!='')
            $this->db->where('wos.on_date>=',$search_params['from_date']);
        if($search_params['to_date']!='')
            $this->db->where('wos.on_date<=',$search_params['to_date']);
        $this->db->order_by('wos.on_date');
        $res = $this->db->get();
        return $res->num_rows();
    }
    /*getting waste oil entry results
    Author:Roopa
    Time: 11.00AM 13-03-2017 */
    public function get_plant_recovery_oil()
    {
        $this->db->select('pro.*,lo.name as loose_oil_name');
        $this->db->from('plant_recovery_oil pro');
        $this->db->join('loose_oil lo','lo.loose_oil_id=pro.loose_oil_id');
        $res = $this->db->get();        
        return $res->result_array();
    }
    /*getting plant recovery oil results
    Author:Roopa
    Time: 11.00AM 13-03-2017 */
    public function update_plant_recovery_oil($loose_oil_id,$plant_id,$quantity)
    {
        $qry = 'UPDATE plant_recovery_oil SET oil_weight = oil_weight -'.$quantity.',updated_time = "'.date('Y-m-d H:i:s').'" WHERE loose_oil_id ='.$loose_oil_id.' AND plant_id = '.$plant_id.'  ';
        $this->db->query($qry);
    }
    /*getting oil weight details
    Author:Roopa
    Time: 11.00AM 13-03-2017 */
    public function get_loose_oil_details($loose_oil_id)
    {
      $this->db->select('oil_weight');
      $this->db->from('plant_recovery_oil ');
      $this->db->where('loose_oil_id',$loose_oil_id);
      $res=$this->db->get();
      $qry_data='';
      if($res->num_rows()>0)
      {
        $value=$res->row_array();
        $qry_data.=$value['oil_weight'];
      }
      else
      {
        $qry_data.="0";
      }
      echo $qry_data;
    }

}