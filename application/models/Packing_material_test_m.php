<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
	* Packing Material lab test details
	* auther: mastan
*/

class Packing_material_test_m extends CI_Model {
	/*
	* auther: mastan 17-02-2017
	* params: po number & tanker in number
	* desc: for dispalying test details in test view page
	* return: array
	*/
	public function pm_test_details($po_no,$tanker_id)
	{
		$plant_id = $this->session->userdata('ses_plant_id');
		$this->db->select('po.*, tr.*,tr.status as tanker_status,pm.*,pm.name as packing_material,s.supplier_id,s.concerned_person as supplier,s.agency_name as s_agency');
		$this->db->from('po_pm po');
		$this->db->join('po_pm_tanker pot', 'po.po_pm_id = pot.po_pm_id');
		$this->db->join('tanker_pm tp', 'pot.tanker_id = tp.tanker_id');
		$this->db->join('tanker_register tr', 'tr.tanker_id = tp.tanker_id');
		$this->db->join('supplier s', 's.supplier_id = po.supplier_id');
		$this->db->join('packing_material pm', 'pm.pm_id = po.pm_id');
		$this->db->where('po.po_number',$po_no);
		$this->db->where('tr.tanker_id',$tanker_id);
		$this->db->where('tr.plant_id',$plant_id);
		$this->db->where('tr.status',2);
		$res=$this->db->get();
		if($res->num_rows()>0)
		{
			return $res->result_array();
		}
		else
		{
			return array();
		}
	}

	/*
	* auther: mastan 17-02-2017
	* params: 
	* desc: getting test names
	* return : array
	*/
	public function get_pm_tests($pm_category_id)
	{
		$this->db->select('pt.*,pt.pm_test_id as test_id,pt.name as test_name, u.name as unit');
		$this->db->from('packing_material_test pt');
		$this->db->join('test_unit u', 'u.test_unit_id = pt.test_unit_id','left');
		$this->db->where('pt.pm_category_id',$pm_category_id);
		$res=$this->db->get();
		return $res->result_array();
	}

	public function check_pm_test_option($result,$test_id)
	{
		if($result!=''&&$test_id!='')
		{
			$this->db->from('pm_test_option');
			$this->db->where('pm_test_id',$test_id);
			$this->db->where('key',$result);
			$this->db->where('allowed',1);
			$this->db->where('status',1);
			$res = $this->db->get();
			return ($res->num_rows()>0)?TRUE:FALSE;
		}
	}

	public function get_pm_test_results($lab_test_id)
	{
		$this->db->select('pt.*, pr.*,pmt.*, pmt.pm_test_id as test_id, pmt.name as packing_material_test, tu.name as unit,pt.status as individual_status,pr.status as individual_status,pt.status as overall_status');
		$this->db->from('po_pm_lab_test pt');
		$this->db->join('po_pm_lab_test_results pr', 'pr.lab_test_id = pt.lab_test_id');
		$this->db->join('packing_material_test pmt', 'pmt.pm_test_id = pr.pm_test_id');
		$this->db->join('test_unit tu', 'tu.test_unit_id = pmt.test_unit_id','left');
		$this->db->where('pt.lab_test_id',$lab_test_id);
		$res=$this->db->get();
		return $res->result_array();
	}

	public function get_list_of_test_results($tanker_id)
	{
		$this->db->select('po.*, tr.*,pt.*, pt.status as test_status, pm.*,pm.name as packing_material,s.supplier_id,s.concerned_person as supplier,s.agency_name as s_agency');
		$this->db->from('po_pm po');
		$this->db->join('po_pm_tanker pot', 'po.po_pm_id = pot.po_pm_id');
		$this->db->join('tanker_register tr', 'pot.tanker_id = tr.tanker_id');
		$this->db->join('po_pm_lab_test pt', 'pt.tanker_id = tr.tanker_id');
		$this->db->join('supplier s', 's.supplier_id = po.supplier_id');
		$this->db->join('packing_material pm', 'pm.pm_id = po.pm_id');
		$this->db->where('tr.tanker_id',$tanker_id);
		$res=$this->db->get();
		return $res->result_array();
	}

	public function get_pm_lab_test_id($test_number)
	{
		$this->db->select('lab_test_id');
		$this->db->from('po_pm_lab_test');
		$this->db->where('test_number',$test_number);
		$this->db->order_by('lab_test_id DESC');
		$this->db->limit('1');
		$res=$this->db->get();
		$res1= $res->row_array();
		return $res1['lab_test_id'];
	}
}