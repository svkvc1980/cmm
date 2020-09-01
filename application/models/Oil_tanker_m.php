 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oil_tanker_m extends CI_Model {

    public function oil_tanker_total_num_rows($search_params)
	{		
		$this->db->select('o.*,p.name as plant_name,lo.name as loose_oil_name');
		$this->db->from('oil_tank o');
		$this->db->join('plant p','p.plant_id=o.plant_id');
		$this->db->join('loose_oil lo','lo.loose_oil_id=o.loose_oil_id');
		if($search_params['name']!='')
			$this->db->like('o.name',$search_params['name']);
		if($search_params['loose_oil_id']!='')
			$this->db->like('o.loose_oil_id',$search_params['loose_oil_id']);
		$res = $this->db->get();
		return $res->num_rows();
	}
    public function oil_tanker_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('o.*,p.name as plant_name,lo.name as loose_oil_name');
		$this->db->from('oil_tank o');
		$this->db->join('plant p','p.plant_id=o.plant_id');
		$this->db->join('loose_oil lo','lo.loose_oil_id=o.loose_oil_id');
		if($search_params['name']!='')
			$this->db->like('o.name',$search_params['name']);
		if($search_params['loose_oil_id']!='')
			$this->db->like('o.loose_oil_id',$search_params['loose_oil_id']);
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
    public function oil_tanker_details($search_params)
	{		
		$this->db->select('o.*,p.name as plant_name,lo.name as loose_oil_name');
		$this->db->from('oil_tank o');
		$this->db->join('plant p','p.plant_id=o.plant_id');
		$this->db->join('loose_oil lo','lo.loose_oil_id=o.loose_oil_id');
		if($search_params['name']!='')
			$this->db->like('o.name',$search_params['name']);
		if($search_params['loose_oil_id']!='')
			$this->db->like('o.loose_oil_id',$search_params['loose_oil_id']);
		$res = $this->db->get();
		return $res->result_array();
	}	
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
    public function get_oil_tank_id($oil_tank_id,$loose_oil)
    {
    	$this->db->select('oil_tank_id');
    	$this->db->from('oil_tank');
    	$this->db->where('oil_tank_id',$oil_tank_id);
    	$this->db->where('loose_oil_id',$loose_oil);
    	$res=$this->db->get();
    	return $res->num_rows();
    }
}