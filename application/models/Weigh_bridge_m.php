<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
 	Created By 		:	Nagarjuna 
 	Module 			:	WeighBridge
 	Created Time 	:	14th Feb 2017 11:23 AM
 	Modified Time 	:	
*/
class Weigh_bridge_m extends CI_Model 
{
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

	//Nagarjuna Weigh Bridge work models 	
	public function get_oil_name($tanker_id,$oil_type)
	{
		$this->db->select('tr.*,lo.name as oil_name,lo.loose_oil_id as loose_oil_id');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_oil to','to.tanker_id=tr.tanker_id');
		$this->db->join('loose_oil lo','lo.loose_oil_id=to.loose_oil_id');
		$this->db->where('tr.tanker_in_number',$tanker_id);
		$this->db->where('to.loose_oil_id',$oil_type);
		$res=$this->db->get();
		return $res->result_array();
	}

	public function get_tanker_oil_details($tanker_id)
	{
		$this->db->select('tr.*,lo.name as oil_name,lo.loose_oil_id as loose_oil_id,to.*,tt.name as tanker_type');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_type tt','tt.tanker_type_id = tr.tanker_type_id');
		$this->db->join('tanker_oil to','to.tanker_id=tr.tanker_id');
		$this->db->join('loose_oil lo','lo.loose_oil_id=to.loose_oil_id');
		$this->db->where('to.tanker_id',$tanker_id);
		$res=$this->db->get();
		return $res->result_array();
	}

	public function get_empty_truck_details($tanker_id)
	{
		$this->db->select('tr.*,tpd.tier,tt.name as tanker_type,tpd.tanker_pp_delivery_id');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_type tt','tt.tanker_type_id = tr.tanker_type_id');
		$this->db->join('tanker_pp_delivery tpd','tpd.tanker_id=tr.tanker_id');
		$this->db->where('tpd.tanker_id',$tanker_id);
		$res=$this->db->get();
		return $res->result_array();
	}

	public function get_freegift_tanker_details($tanker_id)
	{
		$this->db->select('tr.*,fr.name as freegift_name,tfg.*,tt.name as tanker_type');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_type tt','tt.tanker_type_id = tr.tanker_type_id');
		$this->db->join('tanker_fg as tfg','tfg.tanker_id=tr.tanker_id');
		$this->db->join('free_gift fr','fr.free_gift_id=tfg.free_gift_id');
		$this->db->where('tr.tanker_id',$tanker_id);
		$res=$this->db->get();
		return $res->result_array();
	}

	public function get_tanker_pm_details($tanker_id)
	{
		$this->db->select('tr.*,pm.name as packing_mtrl_name,tpm.*,tt.name as tanker_type');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_type tt','tt.tanker_type_id = tr.tanker_type_id');
		$this->db->join('tanker_pm as tpm','tpm.tanker_id=tr.tanker_id');
		$this->db->join('packing_material pm','pm.pm_id=tpm.pm_id');
		$this->db->where('tpm.tanker_id',$tanker_id);
		$res=$this->db->get();
		return $res->result_array();
	}

	public function weigh_bridge_list_num_rows($search_params)
	{
		$plant_id = $this->session->userdata('ses_plant_id');
		$this->db->select('to.*, tr.*, tt.*, tp.*, tf.*, l.name as loose_oil, p.name as packing_material, fg.name as free_gift');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_type tt', 'tt.tanker_type_id = tr.tanker_type_id','left');
		$this->db->join('tanker_oil to', 'to.tanker_id = tr.tanker_id','left');
		$this->db->join('tanker_pm tp', 'tp.tanker_id = tr.tanker_id','left');
		$this->db->join('tanker_fg tf', 'tf.tanker_id = tr.tanker_id','left');
		$this->db->join('loose_oil l', 'l.loose_oil_id = to.loose_oil_id','left');
		$this->db->join('packing_material p', 'p.pm_id = tp.pm_id','left');
		$this->db->join('free_gift fg', 'fg.free_gift_id = tf.free_gift_id','left');
		if($search_params['tanker_type']!='')
			$this->db->where('tr.tanker_type_id',$search_params['tanker_type']);
		if($search_params['from_date']!='')
			$this->db->where('date(tr.in_time)>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('date(tr.out_time)<=',$search_params['to_date']);
		if($search_params['tanker_no']!='')
			$this->db->where('tr.tanker_in_number',$search_params['tanker_no']);
		if($search_params['loose_oil']!='')
			$this->db->where('to.loose_oil_id',$search_params['loose_oil']);
		if($search_params['vehicle_no']!='')
			$this->db->like('tr.vehicle_number',$search_params['vehicle_no']);
		$this->db->where('tr.status>=',2);
		$this->db->where('tr.plant_id',$plant_id);
		$this->db->order_by('tr.tanker_id DESC');
		$res = $this->db->get();
		return $res->num_rows();
	}

	public function get_weigh_bridge_list($current_offset, $per_page, $search_params)
	{
		$plant_id = $this->session->userdata('ses_plant_id');
		$this->db->select('to.*, tr.*, tt.*, tp.*, tf.*, l.name as loose_oil, p.name as packing_material, fg.name as free_gift,
			tr.tanker_id as tr_tanker_id, tt.name as tanker_type');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_type tt', 'tt.tanker_type_id = tr.tanker_type_id','left');
		$this->db->join('tanker_oil to', 'to.tanker_id = tr.tanker_id','left');
		$this->db->join('tanker_pm tp', 'tp.tanker_id = tr.tanker_id','left');
		$this->db->join('tanker_fg tf', 'tf.tanker_id = tr.tanker_id','left');
		$this->db->join('loose_oil l', 'l.loose_oil_id = to.loose_oil_id','left');
		$this->db->join('packing_material p', 'p.pm_id = tp.pm_id','left');
		$this->db->join('free_gift fg', 'fg.free_gift_id = tf.free_gift_id','left');
		if($search_params['tanker_type']!='')
			$this->db->where('tr.tanker_type_id',$search_params['tanker_type']);
		if($search_params['from_date']!='')
			$this->db->where('date(tr.in_time)>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('date(tr.out_time)<=',$search_params['to_date']);
		if($search_params['tanker_no']!='')
			$this->db->where('tr.tanker_in_number',$search_params['tanker_no']);
		if($search_params['loose_oil']!='')
			$this->db->where('to.loose_oil_id',$search_params['loose_oil']);
		if($search_params['vehicle_no']!='')
			$this->db->like('tr.vehicle_number',$search_params['vehicle_no']);
		$this->db->where('tr.status>=',2);
		$this->db->where('tr.plant_id', $plant_id);
		$this->db->order_by('tr.tanker_id DESC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_weigh_bridge_loose_oil($tanker_id)
	{
		$plant_id = $this->session->userdata('ses_plant_id');
		$this->db->select('to.*, tr.*,(to.invoice_qty * 1000) as invoice_quantity,l.name as loose_oil_name');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_oil to', 'to.tanker_id = tr.tanker_id');
		$this->db->join('loose_oil l', 'l.loose_oil_id = to.loose_oil_id');
		$this->db->where('tr.tanker_id', $tanker_id);
		$this->db->where('tr.plant_id', $plant_id);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_weigh_bridge_packing_material($tanker_id)
	{
		$plant_id = $this->session->userdata('ses_plant_id');
		$this->db->select('tpm.*, tr.*,pm.name as packing_material_name,pm.pm_category_id');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_pm tpm', 'tpm.tanker_id = tr.tanker_id');
		$this->db->join('packing_material pm', 'pm.pm_id = tpm.pm_id');
		$this->db->where('tr.tanker_id', $tanker_id);
		$this->db->where('tr.plant_id', $plant_id);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_weigh_bridge_empty_truck($tanker_id)
	{
		$this->db->select('tr.*,tpd.*,GROUP_CONCAT(i.invoice_number SEPARATOR",") as invoice_no,GROUP_CONCAT(gpi.invoice_id SEPARATOR",") as invoice_ids,gpi.invoice_id as single');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_pp_delivery tpd','tpd.tanker_id = tr.tanker_id');
		$this->db->join('gatepass gp','gp.tanker_id = tr.tanker_id','left');
		$this->db->join('gatepass_invoice gpi','gpi.gatepass_id = gp.gatepass_id','left');
		$this->db->join('invoice i','i.invoice_id = gpi.invoice_id','left');
		
		$this->db->where('tr.tanker_id',$tanker_id);
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_party_name($invoice_id)
	{
		$this->db->select('d.distributor_code,d.agency_name,p.name as plant_name');
		$this->db->from('invoice_do ido');
		$this->db->join('distributor_order do','do.order_id = ido.order_id','left');
		$this->db->join('distributor d','d.distributor_id = do.distributor_id','left');
		$this->db->join('plant_order po','po.order_id = ido.order_id','left');
		$this->db->join('plant p','p.plant_id = po.plant_id','left');
		$this->db->where('ido.invoice_id',$invoice_id);
		$this->db->group_by('ido.invoice_id');
		$this->db->limit(1);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_weigh_bridge_free_gifts($tanker_id)
	{
		$this->db->select('tr.*,tfg.*,fg.name as free_gift_name');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_fg tfg','tfg.tanker_id = tr.tanker_id');
		$this->db->join('free_gift fg','fg.free_gift_id = tfg.free_gift_id');
		$this->db->where('tr.tanker_id',$tanker_id);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_invoice_products($invoice_id)
	{
		$this->db->select('(idop.quantity*idop.items_per_carton*p.oil_weight) as qty_in_kg,
			(idop.quantity*ppw.weight) as pm_weight');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('product_pm_weight ppw','p.product_id = ppw.product_id','left');	
		$this->db->where('i.invoice_id',$invoice_id);
		$res = $this->db->get();
		return $res->result_array();
	}
}