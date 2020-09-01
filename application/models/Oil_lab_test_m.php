<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Oil_lab_test_m extends CI_Model {

	/*
	* lab test details
	* auther: mastan
	*/

	public function test_report_details($po,$tanker_id)
	{
		$this->db->select('po.*, tr.*,tr.status as tanker_status,l.*,l.name as loose_oil,s.supplier_id,s.concerned_person as supplier,b.broker_code,
			b.concerned_person as broker,s.agency_name as s_agency,b.agency_name as b_agency');
		$this->db->from('po_oil po');
		$this->db->join('po_oil_tanker pot', 'po.po_oil_id = pot.po_oil_id');
		$this->db->join('tanker_register tr', 'pot.tanker_id = tr.tanker_id');
		$this->db->join('supplier s', 's.supplier_id = po.supplier_id');
		$this->db->join('broker b', 'b.broker_id = po.broker_id');
		$this->db->join('loose_oil l', 'l.loose_oil_id = po.loose_oil_id');
		$this->db->where('po.po_number',$po);
		$this->db->where('tr.tanker_id',$tanker_id);
		$this->db->where('tr.tanker_type_id',1);
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

	public function get_test_groups($loose_oil_id)
	{
		$this->db->select('tg.test_group_id, tg.name as group_name');
		$this->db->from('loose_oil_test lt');
		$this->db->join('test_group tg', 'tg.test_group_id = lt.test_group_id');
		$this->db->where('loose_oil_id',$loose_oil_id);
		$this->db->order_by('tg.order');
		$this->db->group_by('tg.test_group_id');
		$res=$this->db->get();
		return $res->result_array();
	}

	public function get_tests($loose_oil_id,$test_group_id)
	{
		$this->db->select('lt.*, u.name as unit');
		$this->db->from('loose_oil_test lt');
		$this->db->join('test_unit u', 'u.test_unit_id = lt.test_unit_id','LEFT');
		$this->db->where('lt.loose_oil_id',$loose_oil_id);
		$this->db->where('lt.test_group_id',$test_group_id);
		$this->db->order_by('lt.order');
		$res=$this->db->get();
		return $res->result_array();
	}

	public function check_oil_test_option($result,$test_id)
	{
		if($result!=''&&$test_id!='')
		{
			$this->db->from('test_option');
			$this->db->where('test_id',$test_id);
			$this->db->where('key',$result);
			$this->db->where('allowed',1);
			$this->db->where('status',1);
			$res = $this->db->get();
			return ($res->num_rows()>0)?TRUE:FALSE;
		}
	}

	public function get_test_results($lab_test_id)
	{
		$this->db->select('pt.*, pr.*,lt.*, lt.name as loose_oil_test, tg.test_group_id, tg.name as test_group, tu.name as unit,pr.status as individual_status,pt.status as overall_status');
		$this->db->from('po_oil_lab_test pt');
		$this->db->join('po_oil_lab_test_results pr', 'pr.lab_test_id = pt.lab_test_id');
		$this->db->join('loose_oil_test lt', 'lt.test_id = pr.test_id');
		$this->db->join('test_group tg', 'tg.test_group_id = lt.test_group_id');
		$this->db->join('test_unit tu', 'tu.test_unit_id = lt.test_unit_id','left');
		$this->db->where('pt.lab_test_id',$lab_test_id);
		$res=$this->db->get();
		return $res->result_array();
	}

	public function get_list_of_test_results($tanker_id)
	{
		$this->db->select('po.*, tr.*,pt.*, pt.status as test_status, l.*,l.name as loose_oil,s.supplier_id,s.concerned_person as supplier,b.broker_code,
			b.concerned_person as broker,s.agency_name as s_agency,b.agency_name as b_agency');
		$this->db->from('po_oil po');
		$this->db->join('po_oil_tanker pot', 'po.po_oil_id = pot.po_oil_id');
		$this->db->join('tanker_register tr', 'pot.tanker_id = tr.tanker_id');
		$this->db->join('po_oil_lab_test pt', 'pt.tanker_id = tr.tanker_id');
		$this->db->join('supplier s', 's.supplier_id = po.supplier_id');
		$this->db->join('broker b', 'b.broker_id = po.broker_id');
		$this->db->join('loose_oil l', 'l.loose_oil_id = po.loose_oil_id');
		$this->db->where('tr.tanker_id',$tanker_id);
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_lab_test_id($test_number)
	{
		$this->db->select('lab_test_id');
		$this->db->from('po_oil_lab_test');
		$this->db->where('test_number',$test_number);
		$this->db->order_by('lab_test_id DESC');
		$this->db->limit('1');
		$res=$this->db->get();
		$res1= $res->row_array();
		return $res1['lab_test_id'];
	}
}