 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welfare_scheme_m extends CI_Model { 

	/* fetching data of welfare scheme
    Author:Aswini
    Time:28-02-2017*/
 public function welfare_scheme_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('w.*');
		$this->db->from('welfare_scheme w');
		if($search_params['name']!='')
			$this->db->like('w.name',$search_params['name']);
		if($search_params['start_date']!='')
			$this->db->where('DATE(w.start_date)>=',$search_params['start_date']);
		if($search_params['end_date']!='')
			$this->db->where('DATE(w.end_date)<=',$search_params['end_date']);
		if($search_params['discount_percentage']!='')
			$this->db->where('w.discount_percentage',$search_params['discount_percentage']);
        $this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}	
	/* fetching rows of welfare scheme
    Author:Aswini
    Time:28-02-2017*/
	public function welfare_scheme_rows($search_params)
	{		
		$this->db->select('w.*');
		$this->db->from('welfare_scheme w');
		if($search_params['name']!='')
			$this->db->like('w.name',$search_params['name']);
		if($search_params['start_date']!='')
			$this->db->where('DATE(w.start_date)>=',$search_params['start_date']);
		if($search_params['end_date']!='')
			$this->db->where('DATE(w.end_date)<=',$search_params['end_date']);
		if($search_params['discount_percentage']!='')
			$this->db->where('w.discount_percentage',$search_params['discount_percentage']);
				$res = $this->db->get();		
		return $res->num_rows(); 

	}
	/* details of welfare schem
    Author:Aswini
    Time:28-02-2017*/
	public function welfare_scheme_details($search_params)
	{		
		$this->db->select('w.*');
		$this->db->from('welfare_scheme w');
		if($search_params['name']!='')
			$this->db->like('w.name',$search_params['name']);
		if($search_params['start_date']!='')
			$this->db->where('DATE(w.start_date)>=',$search_params['start_date']);
		if($search_params['end_date']!='')
			$this->db->where('DATE(w.end_date)<=',$search_params['end_date']);
		if($search_params['discount_percentage']!='')
			$this->db->where('w.discount_percentage',$search_params['discount_percentage']);
		$res = $this->db->get();		
		return $res->result_array(); 

	}
}