 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ob_history_R_m extends CI_Model {

    public function ob_history_R_total_num_rows($search_params)
	{		
		$this->db->select('obh.*');
		$this->db->from('ob_status_history obh');
		if($search_params['from_date']!='')
			$this->db->where('obh.created_time>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('obh.created_time<=',$search_params['to_date']);
		$res = $this->db->get();
		return $res->num_rows();
	}
    public function ob_history_R_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('obh.*');
		$this->db->from('ob_status_history obh');
		if($search_params['from_date']!='')
			$this->db->where('obh.created_time>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('obh.created_time<=',$search_params['to_date']);
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
	 public function ob_history_R_details($search_params)
	{		
		$this->db->select('obh.*');
		$this->db->from('ob_status_history obh');
		if($search_params['from_date']!='')
			$this->db->where('obh.created_time>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('obh.created_time<=',$search_params['to_date']);
		$res = $this->db->get();
		return $res->result_array();
	}	
}