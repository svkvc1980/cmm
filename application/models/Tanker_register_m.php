<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class tanker_register_m extends CI_Model {

/* 
 	Created By 		:	Priyanka 
 	Module 			:	Tanker Registration - Tanker In, Tanker Out
 	Created Time 	:	10th Feb 2017 11:23 AM
 	Modified Time 	:	
*/
	public function check_po_number($po_no)
	{
		$this->db->select('lop.*,s.*,p.loose_oil_product_name');
		$this->db->from('loose_oil_po lop');
	    	$this->db->join('supplier s','lop.supplier_id=s.supplier_id');
	    	$this->db->join('loose_oil_po_product loppr','lop.po_id=loppr.po_id');
	    	$this->db->join('loose_oil_product p','p.loose_oil_product_id=loppr.product_id');
		$this->db->where('lop.po_number',$po_no);
		$res=$this->db->get();
		return array($res->num_rows(),$res->row_array());
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

	/** Mounika Edit Tanker Details 29 Apr 2017 06:25 PM Start **/

	public function get_tanker_in_details($tanker_in_number)
	{
		$this->db->from('tanker_register tr');
		$this->db->where('tr.tanker_in_number',$tanker_in_number);
		$this->db->order_by('tr.in_time DESC');
		$this->db->limit(1);
		$res=$this->db->get();
		return $res->row_array();
	}
	public function get_tanker_details_oil($tanker_in_number)
	{
		$this->db->select('tr.*,tt.tanker_type_id,tt.name as tanker_type_name,to.*,l.loose_oil_id,l.name as loose_name');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_type tt','tt.tanker_type_id=tr.tanker_type_id');
		$this->db->join('tanker_oil to', 'to.tanker_id = tr.tanker_id','left');
		$this->db->join('loose_oil l', 'l.loose_oil_id = to.loose_oil_id','left');
		$this->db->where('tr.tanker_in_number',$tanker_in_number);
		//$this->db->order_by('tr.tanker_id DESC');
		$this->db->order_by('tr.in_time DESC');
		$this->db->limit(1);
		$res=$this->db->get();
		return $res->row_array();
	}

	public function get_tanker_details_pm($tanker_in_number)
	{
		$this->db->select('tr.*,tt.tanker_type_id,tt.name as tanker_type_name,p.pm_id,p.name as packing_name,tp.*');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_type tt','tt.tanker_type_id=tr.tanker_type_id');
		$this->db->join('tanker_pm tp', 'tp.tanker_id = tr.tanker_id','left');
		$this->db->join('packing_material p', 'p.pm_id = tp.pm_id','left');
		$this->db->where('tr.tanker_in_number',$tanker_in_number);
		//$this->db->order_by('tr.tanker_id DESC');
		$this->db->order_by('tr.in_time DESC');
		$this->db->limit(1);
		$res=$this->db->get();
		return $res->row_array();
	}

	public function get_tanker_details_fg($tanker_in_number)
	{
		$this->db->select('tr.*,tt.tanker_type_id,tt.name as tanker_type_name,tf.*,fg.free_gift_id,fg.name as free_gift_name');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_type tt','tt.tanker_type_id=tr.tanker_type_id');
		$this->db->join('tanker_fg tf', 'tf.tanker_id = tr.tanker_id','left');
		$this->db->join('free_gift fg', 'fg.free_gift_id = tf.free_gift_id','left');
		$this->db->where('tr.tanker_in_number',$tanker_in_number);
		//$this->db->order_by('tr.tanker_id DESC');
		$this->db->order_by('tr.in_time DESC');
		$this->db->limit(1);
		$res=$this->db->get();
		return $res->row_array();
	}

	public function get_tanker_details_empty_truck($tanker_in_number)
	{
		$this->db->select('tr.*,tt.tanker_type_id,tt.name as tanker_type_name');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_type tt','tt.tanker_type_id=tr.tanker_type_id');
		$this->db->join('tanker_pp_delivery tpp','tr.tanker_id=tpp.tanker_id','left');
		$this->db->where('tr.tanker_in_number',$tanker_in_number);
		//$this->db->order_by('tr.tanker_id DESC');
		$this->db->order_by('tr.in_time DESC');
		$this->db->limit(1);
		$res=$this->db->get();
		return $res->row_array();
	}

	public function getloose_oil()
	{
		$this->db->select('l.loose_oil_id,l.name as loose_name');
		$this->db->from('loose_oil l');
		$this->db->where('status',1);
		$res=$this->db->get();
		return $res->result_array();
    }

    public function get_packing_material()
	{
		$this->db->select('pm.pm_id,pm.name as packing_name');
		$this->db->from('packing_material pm');
		$this->db->where('status',1);
		$res=$this->db->get();
		return $res->result_array();
    }

    public function get_free_gift()
    {
    	$this->db->select('fg.free_gift_id,fg.name as free_gift_name');
    	$this->db->from('free_gift fg');
    	$this->db->where('status',1);
    	$res=$this->db->get();
    	return $res->result_array();
    }
    
	/** Mounika Edit Tanker Details 29 Apr 2017 06:25 PM End **/
}