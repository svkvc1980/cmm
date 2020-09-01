<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by Srilekha on 25th MAR 2017 02:48 PM
*/

class Packing_station_m extends CI_Model {

	public function oil_reports($loose_oil_id,$from_date,$to_date)
	{
		$plant_id=$this->session->userdata('ses_plant_id');
		$this->db->select('tr.*,to.*');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_oil to','to.tanker_id=tr.tanker_id');
		$this->db->join('loose_oil lo','lo.loose_oil_id=to.loose_oil_id');
		$this->db->join('tanker_type tt','tt.tanker_type_id=tr.tanker_type_id');
		$this->db->where_in('to.loose_oil_id',$loose_oil_id);
		$this->db->where('date(tr.in_time)>=',$from_date);
		$this->db->where('date(tr.out_time)<=',$to_date);
		$this->db->where('tt.tanker_type_id',1);
		$this->db->where('tr.plant_id',$plant_id);
		$res=$this->db->get();
		return $res->result_array();
	}

	public function pm_reports($pm_id,$from_date,$to_date)
	{
		$plant_id=$this->session->userdata('ses_plant_id');
		$this->db->select('tr.*,tp.*');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_pm tp','tp.tanker_id=tr.tanker_id');
		$this->db->join('packing_material pm','pm.pm_id=tp.pm_id');
		$this->db->join('tanker_type tt','tt.tanker_type_id=tr.tanker_type_id');
		$this->db->where_in('tp.pm_id',$pm_id);
		$this->db->where('date(tr.in_time)>=',$from_date);
		$this->db->where('date(tr.out_time)<=',$to_date);
		$this->db->where('tt.tanker_type_id',2);
		$this->db->where('tr.plant_id',$plant_id);
		$res=$this->db->get();
		return $res->result_array();
	}

	public function fg_reports($fg_id,$from_date,$to_date)
	{
		$plant_id=$this->session->userdata('ses_plant_id');
		$this->db->select('tr.*,tf.*');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_fg tf','tf.tanker_id=tr.tanker_id');
		$this->db->join('free_gift ft','ft.free_gift_id=tf.free_gift_id');
		$this->db->join('tanker_type tt','tt.tanker_type_id=tr.tanker_type_id');
		$this->db->where_in('tf.free_gift_id',$fg_id);
		$this->db->where('date(tr.in_time)>=',$from_date);
		$this->db->where('date(tr.out_time)<=',$to_date);
		$this->db->where('tt.tanker_type_id',5);
		$this->db->where('tr.plant_id',$plant_id);
		$res=$this->db->get();
		return $res->result_array();
	}

	public function get_empty_truck_reports($from_date,$to_date)
	{
		$this->db->select('tr.*,tpd.*,tt.name as tanker_type');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_pp_delivery tpd','tpd.tanker_id = tr.tanker_id');
		$this->db->join('tanker_type tt','tt.tanker_type_id=tr.tanker_type_id');
		$this->db->where('date(tr.in_time)>=',$from_date);
		$this->db->where('date(tr.out_time)<=',$to_date);
		$this->db->where('tr.tanker_type_id',3);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_empty_truck_invoice_details($tanker_id)
	{
		$this->db->select('tr.*,tpd.*,tt.name as tanker_type,GROUP_CONCAT(i.invoice_number SEPARATOR",") as invoice_no,GROUP_CONCAT(gpi.invoice_id SEPARATOR",") as invoice_ids,gpi.invoice_id as single');
		$this->db->from('tanker_register tr');
		$this->db->join('tanker_type tt','tt.tanker_type_id=tr.tanker_type_id');
		$this->db->join('tanker_pp_delivery tpd','tpd.tanker_id = tr.tanker_id');
		$this->db->join('gatepass gp','gp.tanker_id = tr.tanker_id','left');
		$this->db->join('gatepass_invoice gpi','gpi.gatepass_id = gp.gatepass_id');
		$this->db->join('invoice i','i.invoice_id = gpi.invoice_id');
		$this->db->where_in('tr.tanker_id',$tanker_id);
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
		foreach ($res->result_array() as $key => $value)
		 {
			if($value['distributor_code']!='')
			{
				return $party_name = $value['agency_name'].''.$value['distributor_code']  ;
			}
			else
			{
				return $party_name = $value['plant_name'];
			}
		

		}
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