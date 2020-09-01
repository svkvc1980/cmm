<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by mastan on 10th Mar 2017
*/

class Lab_test_rm extends CI_Model {

	public function get_oil_test_total_rows($search_params)
	{
		$this->db->select('po.*, tr.*,pt.*, tr.status as tanker_status, l.*,l.name as loose_oil,s.supplier_id,s.concerned_person as supplier,b.broker_code,
			b.concerned_person as broker,s.agency_name as s_agency,b.agency_name as b_agency');
		$this->db->from('po_oil po');
		$this->db->join('po_oil_tanker pot', 'po.po_oil_id = pot.po_oil_id');
		$this->db->join('tanker_register tr', 'pot.tanker_id = tr.tanker_id');
		$this->db->join('po_oil_lab_test pt', 'pt.tanker_id = tr.tanker_id');
		$this->db->join('supplier s', 's.supplier_id = po.supplier_id');
		$this->db->join('broker b', 'b.broker_id = po.broker_id');
		$this->db->join('loose_oil l', 'l.loose_oil_id = po.loose_oil_id');
		if($search_params['loose_oil']!='')
			$this->db->where('l.loose_oil_id',$search_params['loose_oil']);
		if($search_params['test_number']!='')
			$this->db->like('pt.test_number',$search_params['test_number']);
		if($search_params['start_date']!='')
			$this->db->where('pt.test_date >=',$search_params['start_date']);
			if($search_params['end_date']!='')
			$this->db->where('pt.test_date <=',$search_params['end_date']);
		$this->db->order_by('pt.lab_test_id', 'desc');
		$res=$this->db->get();
		return $res->num_rows();
	}

	public function get_oil_test_reports($current_offset, $per_page, $search_params)
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
		if($search_params['loose_oil']!='')
			$this->db->where('l.loose_oil_id',$search_params['loose_oil']);
		if($search_params['test_number']!='')
			$this->db->like('pt.test_number',$search_params['test_number']);
		if($search_params['start_date']!='')
			$this->db->where('pt.test_date >=',$search_params['start_date']);
			if($search_params['end_date']!='')
			$this->db->where('pt.test_date <=',$search_params['end_date']);
		$this->db->limit($per_page, $current_offset);
		$this->db->order_by('pt.lab_test_id', 'desc');
		$res=$this->db->get();
		return $res->result_array();
	}

	public function get_pm_test_total_rows($search_params)
	{
		$this->db->select('po.*, tr.*,pt.*, tr.status as tanker_status, pm.*,pm.name as packing_material,s.supplier_id,s.concerned_person as supplier,s.agency_name as s_agency');
		$this->db->from('po_pm po');
		$this->db->join('po_pm_tanker pot', 'po.po_pm_id = pot.po_pm_id');
		$this->db->join('tanker_register tr', 'pot.tanker_id = tr.tanker_id');
		$this->db->join('po_pm_lab_test pt', 'pt.tanker_id = tr.tanker_id');
		$this->db->join('supplier s', 's.supplier_id = po.supplier_id');
		$this->db->join('packing_material pm', 'pm.pm_id = po.pm_id');
		if($search_params['packing_material']!='')
			$this->db->where('pm.pm_id',$search_params['packing_material']);
		if($search_params['test_number']!='')
			$this->db->like('pt.test_number',$search_params['test_number']);
		if($search_params['start_date']!='')
			$this->db->where('pt.test_date >=',$search_params['start_date']);
			if($search_params['end_date']!='')
			$this->db->where('pt.test_date <=',$search_params['end_date']);
		$this->db->order_by('pt.lab_test_id', 'desc');
		$res=$this->db->get();
		return $res->num_rows();
	}

	public function get_pm_test_reports($current_offset, $per_page, $search_params)
	{
		$this->db->select('po.*, tr.*,pt.*, pt.status as test_status, pm.*,pm.name as packing_material,s.supplier_id,s.concerned_person as supplier,s.agency_name as s_agency');
		$this->db->from('po_pm po');
		$this->db->join('po_pm_tanker pot', 'po.po_pm_id = pot.po_pm_id');
		$this->db->join('tanker_register tr', 'pot.tanker_id = tr.tanker_id');
		$this->db->join('po_pm_lab_test pt', 'pt.tanker_id = tr.tanker_id');
		$this->db->join('supplier s', 's.supplier_id = po.supplier_id');
		$this->db->join('packing_material pm', 'pm.pm_id = po.pm_id');
		if($search_params['packing_material']!='')
			$this->db->where('pm.pm_id',$search_params['packing_material']);
		if($search_params['test_number']!='')
			$this->db->like('pt.test_number',$search_params['test_number']);
		if($search_params['start_date']!='')
			$this->db->where('pt.test_date >=',$search_params['start_date']);
			if($search_params['end_date']!='')
			$this->db->where('pt.test_date <=',$search_params['end_date']);
		$this->db->order_by('pt.lab_test_id', 'desc');
		$res=$this->db->get();
		return $res->result_array();
	}

	public function get_lab_test_oil_reports($search_params)
	{
		$this->db->select('po.*, tr.*,pt.*, pt.status as test_status, l.*,l.name as loose_oil,s.supplier_id,s.concerned_person as supplier,b.broker_code,
			b.concerned_person as broker,s.agency_name as s_agency,b.agency_name as b_agency, (to.gross-to.tier)/1000 as received_qty');
		$this->db->from('po_oil po');
		$this->db->join('po_oil_tanker pot', 'po.po_oil_id = pot.po_oil_id');
		$this->db->join('tanker_register tr', 'pot.tanker_id = tr.tanker_id');
		$this->db->join('tanker_oil to','to.tanker_id = tr.tanker_id');
		$this->db->join('po_oil_lab_test pt', 'pt.tanker_id = tr.tanker_id');
		$this->db->join('supplier s', 's.supplier_id = po.supplier_id');
		$this->db->join('broker b', 'b.broker_id = po.broker_id');
		$this->db->join('loose_oil l', 'l.loose_oil_id = po.loose_oil_id');
		if($search_params['loose_oil']!='')
			$this->db->like('l.loose_oil_id',$search_params['loose_oil']);
		if($search_params['test_number']!='')
			$this->db->like('pt.test_number',$search_params['test_number']);
		if($search_params['start_date']!='')
            $this->db->where('pt.test_date >=',$search_params['start_date']);
        if($search_params['end_date']!='')
            $this->db->where('pt.test_date <=',$search_params['end_date']);
		//$this->db->group_by('po.po_oil_id');
		$this->db->order_by('l.rank ASC,pt.test_date ASC');
        $res = $this->db->get();
        return $res->result_array();
	}

	public function get_lab_test_pm_reports($search_params)
	{
		$this->db->select('po.*, tr.*,pt.*, pt.status as test_status, pm.*,pm.name as packing_material,s.supplier_id,s.concerned_person as supplier,s.agency_name as s_agency, m.received_qty, mf.no_of_rolls,mf.core_carton_weight, pmu.name as unit');
		$this->db->from('po_pm po');
		$this->db->join('po_pm_tanker pot', 'po.po_pm_id = pot.po_pm_id');
		$this->db->join('tanker_register tr', 'pot.tanker_id = tr.tanker_id');
		$this->db->join('tanker_pm tp', 'tp.tanker_id = tr.tanker_id');
		$this->db->join('mrr_pm m', 'm.tanker_pm_id = tp.tanker_pm_id','left');
		$this->db->join('mrr_pm_film mf', 'mf.mrr_pm_id = m.mrr_pm_id','left');
		$this->db->join('po_pm_lab_test pt', 'pt.tanker_id = tr.tanker_id');
		$this->db->join('supplier s', 's.supplier_id = po.supplier_id');
		$this->db->join('packing_material pm', 'pm.pm_id = po.pm_id');
		$this->db->join('packing_material_category pmc', 'pm.pm_category_id = pmc.pm_category_id');
		$this->db->join('pm_unit pmu', 'pmu.pm_unit = pmc.pm_unit');
		if($search_params['packing_material']!='')
			$this->db->like('pm.pm_id',$search_params['packing_material']);
		if($search_params['test_number']!='')
			$this->db->like('pt.test_number',$search_params['test_number']);
		if($search_params['start_date']!='')
            $this->db->where('pt.test_date >=',$search_params['start_date']);
        if($search_params['end_date']!='')
            $this->db->where('pt.test_date <=',$search_params['end_date']);
        $this->db->order_by('pm.pm_group_id ASC, pm.pm_id ASC,pt.test_date ASC');
		$res=$this->db->get();
		return $res->result_array();
	}
}