<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tanker_registration_m extends CI_Model {

	/*Getting Plant num of rows
	Author:Srilekha
	Time: 12.38PM 06-02-2017 */
	public function tanker_total_num_rows($search_params)
	{
		$plant_id = $this->session->userdata('ses_plant_id');	
		$this->db->select('tr.*,tt.name as tanker_name');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_type tt','tt.tanker_type_id=tr.tanker_type_id');
		$this->db->join('tanker_oil to', 'to.tanker_id = tr.tanker_id','left');
		$this->db->join('tanker_pm tp', 'tp.tanker_id = tr.tanker_id','left');
		$this->db->join('tanker_fg tf', 'tf.tanker_id = tr.tanker_id','left');
		$this->db->join('loose_oil l', 'l.loose_oil_id = to.loose_oil_id','left');
		$this->db->join('packing_material p', 'p.pm_id = tp.pm_id','left');
		$this->db->join('free_gift fg', 'fg.free_gift_id = tf.free_gift_id','left');
		if($search_params['vehicle_num']!='')
			$this->db->like('tr.vehicle_number',$search_params['vehicle_num']);
		if($search_params['tanker_type']!='')
			$this->db->where('tr.tanker_type_id',$search_params['tanker_type']);
		if($search_params['start_date']!='')
			$this->db->where('tr.in_time >=',$search_params['start_date']);
		if($search_params['end_date']!='')
			$this->db->where('tr.out_time <=',$search_params['end_date']);
		$this->db->where('tr.plant_id',$plant_id);
		$this->db->order_by('tr.tanker_id DESC');
		$res = $this->db->get();
		return $res->num_rows();
	}

	/*Getting Tanker Results
	Author:Srilekha
	Time: 12.22PM 16-02-2017 */
	public function tanker_results($current_offset, $per_page, $search_params)
	{
		$plant_id = $this->session->userdata('ses_plant_id');	
		$this->db->select('tr.*,tt.*,tt.name as tanker_name,l.name as loose_oil, p.name as packing_material, fg.name as free_gift,
			tr.tanker_id as tr_tanker_id');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_type tt','tt.tanker_type_id=tr.tanker_type_id');
		$this->db->join('tanker_oil to', 'to.tanker_id = tr.tanker_id','left');
		$this->db->join('tanker_pm tp', 'tp.tanker_id = tr.tanker_id','left');
		$this->db->join('tanker_fg tf', 'tf.tanker_id = tr.tanker_id','left');
		$this->db->join('loose_oil l', 'l.loose_oil_id = to.loose_oil_id','left');
		$this->db->join('packing_material p', 'p.pm_id = tp.pm_id','left');
		$this->db->join('free_gift fg', 'fg.free_gift_id = tf.free_gift_id','left');
		if($search_params['vehicle_num']!='')
			$this->db->like('tr.vehicle_number',$search_params['vehicle_num']);
		if($search_params['tanker_type']!='')
			$this->db->where('tr.tanker_type_id',$search_params['tanker_type']);
		if($search_params['start_date']!='')
			$this->db->where('tr.in_time >=',$search_params['start_date']);
		if($search_params['end_date']!='')
			$this->db->where('tr.out_time <=',$search_params['end_date']);
		$this->db->where('tr.plant_id',$plant_id);
		$this->db->order_by('tr.tanker_id DESC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}

	/*Getting Tanker details for Download
	Author:Srilekha
	Time: 12.39PM 16-02-2017 */
	public function tanker_details($search_params)
	{
		$plant_id = $this->session->userdata('ses_plant_id');	
		$this->db->select('tr.*,tt.name as tanker_name');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_type tt','tt.tanker_type_id=tr.tanker_type_id');
		if($search_params['vehicle_num']!='')
			$this->db->like('tr.vehicle_number',$search_params['vehicle_num']);
		if($search_params['tanker_type']!='')
			$this->db->where('tr.tanker_type_id',$search_params['tanker_type']);
		if($search_params['start_date']!='')
			$this->db->where('tr.in_time >=',$search_params['start_date']);
		if($search_params['end_date']!='')
			$this->db->where('tr.out_time <=',$search_params['end_date']);
		$this->db->where('tr.plant_id',$plant_id);
		$this->db->order_by('tr.tanker_id DESC');
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_tanker_in_details($tanker_id)
	{
		$this->db->select('tr.*,tt.*,tt.name as tanker_name,l.name as loose_oil, p.name as packing_material, fg.name as free_gift,
			tr.tanker_id as tr_tanker_id');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_type tt','tt.tanker_type_id=tr.tanker_type_id');
		$this->db->join('tanker_oil to', 'to.tanker_id = tr.tanker_id','left');
		$this->db->join('tanker_pm tp', 'tp.tanker_id = tr.tanker_id','left');
		$this->db->join('tanker_fg tf', 'tf.tanker_id = tr.tanker_id','left');
		$this->db->join('loose_oil l', 'l.loose_oil_id = to.loose_oil_id','left');
		$this->db->join('packing_material p', 'p.pm_id = tp.pm_id','left');
		$this->db->join('free_gift fg', 'fg.free_gift_id = tf.free_gift_id','left');
		$this->db->where('tr.tanker_id',$tanker_id);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_tanker_type_plant()
	{
		$value = array(3,6);
		$this->db->select('tt.tanker_type_id,tt.name');
		$this->db->from('tanker_type tt');
		$this->db->where_in('tt.tanker_type_id',$value);
		$this->db->where('tt.status',1);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function print_vehicle_details($search_params)
	{
		$plant_id = $this->session->userdata('ses_plant_id');
		$this->db->select('tr.*,tt.*,tt.name as tanker_name,l.name as loose_oil, p.name as packing_material, fg.name as free_gift,
			tr.tanker_id as tr_tanker_id');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_type tt','tt.tanker_type_id=tr.tanker_type_id');
		$this->db->join('tanker_oil to', 'to.tanker_id = tr.tanker_id','left');
		$this->db->join('tanker_pm tp', 'tp.tanker_id = tr.tanker_id','left');
		$this->db->join('tanker_fg tf', 'tf.tanker_id = tr.tanker_id','left');
		$this->db->join('loose_oil l', 'l.loose_oil_id = to.loose_oil_id','left');
		$this->db->join('packing_material p', 'p.pm_id = tp.pm_id','left');
		$this->db->join('free_gift fg', 'fg.free_gift_id = tf.free_gift_id','left');
		if($search_params['vehicle_num']!='')
			$this->db->like('tr.vehicle_number',$search_params['vehicle_num']);
		if($search_params['tanker_type']!='')
			$this->db->where('tr.tanker_type_id',$search_params['tanker_type']);
		if($search_params['start_date']!='')
            $this->db->where('tr.in_time >=',$search_params['start_date']);
        if($search_params['end_date']!='')
            $this->db->where('tr.in_time <=',$search_params['end_date']);
        $this->db->where('tr.plant_id',$plant_id);
        $this->db->order_by('tr.tanker_id DESC');
		$res=$this->db->get();
		return $res->result_array();
	}
}