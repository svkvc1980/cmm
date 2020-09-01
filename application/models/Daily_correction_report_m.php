<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Daily_correction_report_m extends CI_Model {

public function daily_correction_report($from_date,$to_date)
	{		
		$this->db->select('d.*,u.name');
		$this->db->from('daily_corrections d');	
		$this->db->join('user u','u.user_id=d.created_by');	
		if($from_date!='')
			$this->db->where('DATE(d.created_time)>=',$from_date);
		if($to_date!='')
			$this->db->where('DATE(d.created_time)<=',$to_date);
		$res = $this->db->get();		
		return $res->result_array(); 

	}
}