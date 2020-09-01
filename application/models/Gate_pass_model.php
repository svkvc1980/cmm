<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gate_pass_model extends CI_Model {

	public function get_tanker_no_details($tanker_in_no,$tanker_type_id)
	{
		$plant_id = $this->session->userdata('ses_plant_id');
		$this->db->from('tanker_register');
		$this->db->where('tanker_type_id',$tanker_type_id);
		$this->db->where('tanker_in_number',$tanker_in_no);
		$this->db->where('plant_id',$plant_id);
		$this->db->order_by('in_time','DESC');
		$this->db->limit(1);
		//$this->db->where('status',2);
		$res=$this->db->get();
		return array($res->num_rows(),$res->row_array());
	}
	
	public function get_latest_invoice_id($invoice_no)
	{
		$this->db->select('invoice_id');
		$this->db->from('invoice');
		$this->db->where('invoice_number',$invoice_no);
		$this->db->order_by('invoice_id','DESC');
		$this->db->limit(1);
		$res=$this->db->get();
		return $res->row_array();
	}
	
	public function get_invoice_count($invoice_id)
	{
		$this->db->from('gatepass_invoice');
		$this->db->where('invoice_id',$invoice_id);
		$res=$this->db->get();
		return $res->num_rows();
	}
	public function insert_gate_pass_invoice($dat1,$invoice_id)
	{
		$this->db->select('*');
		$this->db->from('gatepass_invoice');
		$this->db->where('invoice_id',$invoice_id);
		$res=$this->db->get();
		//echo $res->num_rows();exit;
		if($res->num_rows()<=0)
		{
			$this->db->insert('gatepass_invoice',$dat1);
			 return $this->db->insert_id();
		}
	}
	public function insert_gate_pass_data($tanker_id,$dat)
	{
		$this->db->select('*');
		$this->db->from('gatepass');
		$this->db->where('tanker_id',$tanker_id);
		$res=$this->db->get();
		if($res->num_rows()<=0)
		{
			$this->db->insert('gatepass',$dat);
			 return $this->db->insert_id();
		}
	}

	public function get_gate_pass_list_total_num_rows($search_params)
	{
		$plant_id = $this->session->userdata('ses_plant_id');
		$this->db->select('*');
		$this->db->from('gatepass g');
        $this->db->join('tanker_register tr','g.tanker_id=tr.tanker_id');
        $this->db->join('gatepass_invoice gi','g.gatepass_id=gi.gatepass_id');
        $this->db->join('invoice i','gi.invoice_id=i.invoice_id');
        if($search_params['tanker_in_number']!='')
            $this->db->where('tr.tanker_in_number',$search_params['tanker_in_number']);
        if($search_params['gatepass_number']!='')
            $this->db->where('g.gatepass_number',$search_params['gatepass_number']); 
        if($search_params['on_date']!='')
            $this->db->where('g.on_date',$search_params['on_date']);
        $this->db->where('i.plant_id',$plant_id);
        $this->db->order_by('g.gatepass_id DESC');
        $this->db->group_by('g.gatepass_id');
        $res = $this->db->get();
        return $res->num_rows();
	}

	public function view_gate_pass_results($search_params, $per_page ,$current_offset)
	{
		$plant_id = $this->session->userdata('ses_plant_id');
		$this->db->select('g.*,tr.tanker_in_number,GROUP_CONCAT(i.invoice_number) as invoice ');
		$this->db->from('gatepass g');
        $this->db->join('tanker_register tr','g.tanker_id=tr.tanker_id');
        //$this->db->join('gatepass g','tr.tanker_id=g.tanker_id');
        $this->db->join('gatepass_invoice gi','g.gatepass_id=gi.gatepass_id');
        $this->db->join('invoice i','gi.invoice_id=i.invoice_id');
        if($search_params['tanker_in_number']!='')
            $this->db->where('tr.tanker_in_number',$search_params['tanker_in_number']);
        if($search_params['gatepass_number']!='')
            $this->db->where('g.gatepass_number',$search_params['gatepass_number']); 
        if($search_params['on_date']!='')
            $this->db->where('g.on_date',$search_params['on_date']);
        $this->db->where('i.plant_id',$plant_id);
        $this->db->order_by('g.gatepass_id DESC');
        $this->db->group_by('g.gatepass_id');
        $this->db->limit($per_page, $current_offset);
        $res = $this->db->get();
        return $res->result_array();
	}

	public function get_gate_invoice_details($gatepass_id)
	{
		$this->db->select('i.invoice_id,i.invoice_number,gi.waybill_number');
		$this->db->from('gatepass_invoice gi','g.gatepass_id=gi.gatepass_id');
		$this->db->join('invoice i','gi.invoice_id=i.invoice_id');
		$this->db->where('gi.gatepass_id',$gatepass_id);
		//$this->db->group_by('g.gatepass_id');
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_gate_pass_details($gatepass_id)
	{
		$this->db->select('g.gatepass_id,gatepass_number,g.on_date,tr.vehicle_number');
		$this->db->from('gatepass g');
		$this->db->join('tanker_register tr','g.tanker_id=tr.tanker_id');
		$this->db->where('g.gatepass_id',$gatepass_id);
		$res=$this->db->get();
		return $res->row_array();
	}

	

	public function get_do_products_details($invoice_id)
	{
		$this->db->select('id.invoice_id,idp.quantity as cbs,(idp.items_per_carton*idp.quantity) as sachets,p.name as product_name,i.invoice_number,(p.oil_weight * idp.items_per_carton*idp.quantity) as weight');
		$this->db->from('invoice_do id');
		$this->db->join('invoice_do_product idp','id.invoice_do_id=idp.invoice_do_id');
		$this->db->join('product p','idp.product_id=p.product_id');
		$this->db->join('invoice i','id.invoice_id=i.invoice_id');
		//$this->db->join('do_order do','id.do_id=do.do_id');
		$this->db->where('id.invoice_id',$invoice_id);
		$res=$this->db->get();
		return $res->result_array();
	}

	/** MOUNIKA 30 APR 2017 GATE PASS DELETE   START **/
	public function get_gatepass_details($gatepass_number)
	{
		$this->db->select('g.*,tr.*');
		$this->db->from('gatepass g');
		$this->db->join('tanker_register tr','g.tanker_id=tr.tanker_id');
		$this->db->where('g.gatepass_number',$gatepass_number);
		$this->db->order_by('g.created_time DESC');	
		$this->db->limit(1);
		$res=$this->db->get();
		return $res->row_array();
	}

	public function get_invoice_gatepass_details($gatepass_id)
	{
		$this->db->select('gi.*,i.invoice_number');
		$this->db->from('gatepass_invoice gi');
		//$this->db->join('gatepass_invoice gi','g.gatepass_id=gi.gatepass_id');
		$this->db->join('invoice i','gi.invoice_id=i.invoice_id');
		//$this->db->join('tanker_register tr','g.tanker_id=tr.tanker_id');
		$this->db->where('gi.gatepass_id',$gatepass_id);
		$res=$this->db->get();
		return $res->result_array();
	}
	/** MOUNIKA 30 APR 2017 GATE PASS DELETE   END **/
};