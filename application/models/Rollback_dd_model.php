<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*Created By Srilekha
Rollback DD Changes*/

class Rollback_dd_model extends CI_Model {

	public function is_numberExist($dd_number)
    {       
        $this->db->select('dd_number');
        $this->db->from('distributor_payment');
        $this->db->where('dd_number',$dd_number);
        $query = $this->db->get();
		return ($query->num_rows()>0)?1:0;
    }

	public function get_active_distributor()
    {
    	$this->db->select('d.distributor_id,d.agency_name,d.distributor_code');
    	$this->db->from('distributor d');
    	$this->db->join('user u','u.user_id = d.user_id');
    	$this->db->where('u.status',1);
    	$this->db->order_by('CAST(d.distributor_code as unsigned) ASC');
    	$res = $this->db->get();
    	return $res->result_array();
    }

	public function get_dd_data($distributor_id,$dd_number,$dd_amount)
	{
		$this->db->select('dp.*,d.agency_name,d.distributor_code,d.outstanding_amount,b.name,pm.name as payment_mode');
		$this->db->from('distributor_payment dp');
		$this->db->join('distributor d','d.distributor_id=dp.distributor_id');
		$this->db->join('bank b','b.bank_id=dp.bank_id');
		$this->db->join('payment_mode pm','pm.pay_mode_id=dp.pay_mode_id');
		if($distributor_id!='')
			$this->db->where('dp.distributor_id',$distributor_id);
		if($dd_number!='')
			$this->db->where('dp.dd_number',$dd_number);
		if($dd_amount!='')
			$this->db->where('dp.amount',$dd_amount);
		$this->db->order_by('dp.payment_id DESC');
		$this->db->limit(1);
		$res=$this->db->get();
		return $res->row_array();
	}

	public function get_po_oil_data($po_number)
	{
		$this->db->select('po.*,l.name as oil_name,pt.name as po_type,s.agency_name as supplier_name,b.agency_name as broker_name');
		$this->db->from('po_oil po');
		$this->db->join('loose_oil l','l.loose_oil_id=po.loose_oil_id');
		$this->db->join('po_type pt','pt.po_type_id=po.po_type_id');
		$this->db->join('supplier s','s.supplier_id=po.supplier_id');
		$this->db->join('broker b','b.broker_id=po.broker_id');
		$this->db->where('po.po_number',$po_number);
		$res=$this->db->get();
		return $res->row_array();
	}

}