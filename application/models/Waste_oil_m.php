 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Waste_oil_m extends CI_Model {
	/*  get waste oil details
        Author:gowripriya
        Time: 11am 15-03-2017 */

    public function waste_oil_total_num_rows($search_params)
	{		
		$this->db->select('w.*,lo.name as oil_name');
		$this->db->from('waste_oil_entry w');
		$this->db->join('loose_oil lo','lo.loose_oil_id= w.loose_oil_id');
		if($search_params['loose_oil_id']!='')
			$this->db->like('w.loose_oil_id',$search_params['loose_oil_id']);
		if($search_params['from_date']!='')
			$this->db->where('DATE(w.created_time)>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('DATE(w.created_time)<=',$search_params['to_date']);
		//$this->db->order_by('w.on_date');
		$res = $this->db->get();
		return $res->num_rows();
	}
    public function waste_oil_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('w.*,lo.name as oil_name');
		$this->db->from('waste_oil_entry w');
		$this->db->join('loose_oil lo','lo.loose_oil_id= w.loose_oil_id');
		if($search_params['loose_oil_id']!='')
			$this->db->like('w.loose_oil_id',$search_params['loose_oil_id']);
		if($search_params['from_date']!='')
			$this->db->where('DATE(w.created_time)>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('DATE(w.created_time)<=',$search_params['to_date']);
		//$this->db->order_by('w.on_date');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
   
	public function get_products()
	{
		$value=array(1,3);
		$this->db->select('loose_oil_id,name');
		$this->db->from('loose_oil');
		$this->db->where_in('status',$value);
		$res = $this->db->get();		
		return $res->result_array();
	}

	public function insert_update_waste_oil($quantity,$loose_oil_id)
	{
		$qry = "INSERT INTO plant_recovery_oil(plant_id,loose_oil_id,oil_weight,updated_time) 
                VALUES (".$this->session->userdata('ses_plant_id').",".$loose_oil_id.",".$quantity.",'".date('Y-m-d H:i:s')."')  
                    ON DUPLICATE KEY UPDATE oil_weight = oil_weight+VALUES(oil_weight), updated_time = VALUES(updated_time) ;";
        $this->db->query($qry);
	}
}	