 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oil_scrap_m extends CI_Model {

    public function oil_scrap_total_num_rows($search_params)
	{		
		$this->db->select('r.*,lo.name as oil_name,r.on_date as date');
		$this->db->from('recovered_oil_scrap r');
		$this->db->join('loose_oil lo','lo.loose_oil_id=r.loose_oil_id');
		$this->db->join('plant_recovery_oil po','po.loose_oil_id=r.loose_oil_id');
		if($search_params['loose_oil_id']!='')
			$this->db->like('r.loose_oil_id',$search_params['loose_oil_id']);
		if($search_params['from_date']!='')
			$this->db->where('r.on_date>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('r.on_date<=',$search_params['to_date']);
		$this->db->order_by('r.on_date');
		$res = $this->db->get();
		return $res->num_rows();
	}
    public function oil_scrap_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('r.*,lo.name as oil_name,r.on_date as date');
		$this->db->from('recovered_oil_scrap r');
		$this->db->join('loose_oil lo','lo.loose_oil_id=r.loose_oil_id');
		$this->db->join('plant_recovery_oil po','po.loose_oil_id=r.loose_oil_id');
		if($search_params['loose_oil_id']!='')
			$this->db->like('r.loose_oil_id',$search_params['loose_oil_id']);
		if($search_params['from_date']!='')
			$this->db->where('r.on_date>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('r.on_date<=',$search_params['to_date']);
		$this->db->order_by('r.on_date');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
   
	 public function get_plant_recovery_oil()
    {
        $this->db->select('lo.name,lo.loose_oil_id');
        $this->db->from('plant_recovery_oil po');
        $this->db->join('loose_oil lo','lo.loose_oil_id=po.loose_oil_id');
        $res = $this->db->get();        
        return $res->result_array();
    }
	public function get_oil_weight($loose_oil_id)
	{
	    $this->db->select('oil_weight');
	    $this->db->from('plant_recovery_oil');
	    $this->db->where('loose_oil_id',$loose_oil_id);
        $res = $this->db->get();
        $qry_data='';
		if($res->num_rows()>0)
		{
			$value = $res->row_array();
			$qry_data.= $value['oil_weight'];
		}
		else
		{
			$qry_data.= "0";
		}

		
		echo $qry_data;
    }
	

	}	