 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ob_history_oil_R_m extends CI_Model {

    public function ob_history_oil_R_total_num_rows($search_params)
	{		
		$this->db->select('oobh.*,lo.name as loose_oil_name');
		$this->db->from('oil_ob_status_history oobh');
		$this->db->join('loose_oil lo','lo.loose_oil_id=oobh.loose_oil_id');
		if($search_params['loose_oil_id']!='')
			$this->db->like('oobh.loose_oil_id',$search_params['loose_oil_id']);
		if($search_params['from_date']!='')
			$this->db->where('oobh.created_time>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('oobh.created_time<=',$search_params['to_date']);
		$res = $this->db->get();
		return $res->num_rows();
	}
    public function ob_history_oil_R_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('oobh.*,lo.name as loose_oil_name');
		$this->db->from('oil_ob_status_history oobh');
		$this->db->join('loose_oil lo','lo.loose_oil_id=oobh.loose_oil_id');
		if($search_params['loose_oil_id']!='')
			$this->db->like('oobh.loose_oil_id',$search_params['loose_oil_id']);
		if($search_params['from_date']!='')
			$this->db->where('oobh.created_time>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('oobh.created_time<=',$search_params['to_date']);
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
	 public function ob_history_oil_R_details($search_params)
	{		
		$this->db->select('oobh.*,lo.name as loose_oil_name');
		$this->db->from('oil_ob_status_history oobh');
		$this->db->join('loose_oil lo','lo.loose_oil_id=oobh.loose_oil_id');
		if($search_params['loose_oil_id']!='')
			$this->db->like('oobh.loose_oil_id',$search_params['loose_oil_id']);
		if($search_params['from_date']!='')
			$this->db->where('oobh.created_time>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('oobh.created_time<=',$search_params['to_date']);
		$res = $this->db->get();
		return $res->result_array();
	}	
}