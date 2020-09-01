 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   /*roopa-4/4/2017*/
   // Modified By Maruthi on 28th april'17
class Rollback_production_model extends CI_Model {
   //getting production details....
     public function get_production_product_data($production_date,$plant_id)
    {
        $this->db->select('ppr.*,pp.quantity as product_quantity,pp.production_product_id as pdp_id,
            p.name as product_name,pp.product_id as product_id,pp.items_per_carton,ppr.plant_id as plant_id');
        $this->db->from('plant_production ppr');
        $this->db->join('production_product pp','ppr.plant_production_id=pp.plant_production_id');
        $this->db->join('product p','p.product_id=pp.product_id');
        if($production_date!='')
            $this->db->where('ppr.production_date',$production_date);
        if($plant_id!='')
            $this->db->where('ppr.plant_id',$plant_id);
        $this->db->order_by('ppr.plant_production_id DESC');
        $res=$this->db->get();
        return $res->result_array();
    }
   //getting plant details....
    public function get_plant_details()
    {
         $this->db->select('p.plant_id,p.name');
         $this->db->from('plant p');
         $this->db->join('plant_block pb','pb.plant_id=p.plant_id');
         $this->db->where('pb.block_id',2); 
         $this->db->where('p.status',1);    
         $res = $this->db->get();
         return $res->result_array();
    }    
    
}