<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock_receiving_m extends CI_Model {

	# Created By    :  Priyanka
	# Date  		:  1st March,2017 11:20 AM
	# Module 		:  Stock Receiving For C & F

	# Get Invoice Product Results
	public function get_all_products($invoice_id)
	{
	    $this->db->select('p.name as product_name, p.product_id,idp.quantity as invoice_qty, p.items_per_carton, idp.invoice_do_product_id, ind.do_id');
	    $this->db->from('invoice_do_product idp');
	    $this->db->join('invoice_do ind','ind.invoice_do_id = idp.invoice_do_id','left');
	    $this->db->join('product p','p.product_id = idp.product_id','left');
	    $this->db->where_in('ind.invoice_id',$invoice_id);
	    $this->db->where('idp.status',1);
        $res = $this->db->get();
		return $res->result_array();
	}

	# Get Invoice Product Results
	public function get_invoice_ids($invoice_nums)
	{
		$results = array();
		if(isset($invoice_nums)&&count($invoice_nums)>0)
		{
			foreach ($invoice_nums as $invoice_num) 
			{
				$this->db->select('*');
				$this->db->from('invoice');
				$this->db->where('invoice_number',$invoice_num);
				$this->db->where('status',1);
				$this->db->order_by('invoice_id','DESC');
				$this->db->limit(1);
				$res = $this->db->get();
			    $results[] = $res->row_array();
			}
		}
		return $results;
	}

	# Get Free Gifts Details
	public function get_free_gifts($invoice_scheme_id,$invoice_id)
	{
	    $this->db->select('fg.name as free_gift_name,ifg.free_gift_id,is.fg_scheme_id,ifg.quantity as invoice_qty');
	    $this->db->from('invoice_free_gift ifg');
	    $this->db->join('invoice_scheme is','is.invoice_scheme_id = ifg.invoice_scheme_id','left');
	    $this->db->join('free_gift fg','fg.free_gift_id = ifg.free_gift_id','left');
	    $this->db->where_in('ifg.invoice_scheme_id',$invoice_scheme_id);
	    $this->db->where_in('is.invoice_id',$invoice_id);
	    $this->db->where('ifg.status',1);
        $res = $this->db->get();
		return $res->result_array();
	}
	# Get Free Products Details
	public function get_free_products($invoice_scheme_id,$invoice_id)
	{
	    $this->db->select('p.name as product_name,p.items_per_carton,ifp.product_id,is.fg_scheme_id,ifp.quantity as invoice_qty');
	    $this->db->from('invoice_free_product ifp');
	    $this->db->join('invoice_scheme is','is.invoice_scheme_id = ifp.invoice_scheme_id','left');
	    $this->db->join('product p','p.product_id = ifp.product_id','left');
	    $this->db->where_in('ifp.invoice_scheme_id',$invoice_scheme_id);
	    $this->db->where('is.invoice_id',$invoice_id);
	    $this->db->where('ifp.status',1);
        $res = $this->db->get();
		return $res->result_array();
	}

	# Insert & Update plant_product
	public function insert_update_plant_product($plant_id,$product_id,$quantity)
	{
		$qry = "INSERT INTO plant_product(plant_id,product_id,quantity,updated_time) 
                    VALUES (".$plant_id.",".$product_id.",".$quantity.",'".date('Y-m-d H:i:s')."')  
                    ON DUPLICATE KEY UPDATE quantity = quantity+VALUES(quantity), updated_time = VALUES(updated_time) ;";
        $this->db->query($qry);
	}

	# Insert & Update plant_free_gift
	public function insert_update_plant_free_gift($plant_id,$free_gift_id,$quantity)
	{
		$qry = "INSERT INTO plant_free_gift(plant_id,free_gift_id,quantity,updated_time) 
                    VALUES (".$plant_id.",".$free_gift_id.",".$quantity.",'".date('Y-m-d H:i:s')."')  
                    ON DUPLICATE KEY UPDATE quantity = quantity+VALUES(quantity), updated_time = VALUES(updated_time) ;";
        $this->db->query($qry);
	}

	# SRN List Functions Starts from here

	# Stock Receiving Total Num Rows
	public function stock_receipt_num_rows($search_params)
	{	$plant_id = $this->session->userdata('ses_plant_id');	
		$this->db->select('sr.*,GROUP_CONCAT(i.invoice_number SEPARATOR ", ") as invoice_number');
		$this->db->from('stock_receipt sr');
		$this->db->join('receipt_invoice ri','sr.stock_receipt_id = ri.stock_receipt_id');
		$this->db->join('invoice i','i.invoice_id =ri.invoice_id');
		if($search_params['srn_number']!='')
			$this->db->like('sr.srn_number',$search_params['srn_number']);
		if($search_params['vehicle_number']!='')
			$this->db->where('sr.vehicle_number',$search_params['vehicle_number']);
		if($search_params['invoice_number']!='')
			$this->db->where('i.invoice_number',$search_params['invoice_number']);
		if($search_params['fromDate']!='')
			$this->db->where('sr.on_date>=',$search_params['fromDate']);
		if($search_params['toDate']!='')
			$this->db->where('sr.on_date<=',$search_params['toDate']);
		$this->db->where('sr.status',1);
		$this->db->where('sr.plant_id',$plant_id);
		$this->db->group_by('ri.stock_receipt_id');
		//$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();
		//echo $this->db->last_query();exit;
		return $res->num_rows();
	}

	# Stock Receiving Total results
	public function stock_receipt_results($current_offset, $per_page,$search_params)
	{	$plant_id = $this->session->userdata('ses_plant_id');	
		$this->db->select('sr.*,GROUP_CONCAT(i.invoice_number SEPARATOR ", ") as invoice_number');
		$this->db->from('stock_receipt sr');
		$this->db->join('receipt_invoice ri','sr.stock_receipt_id = ri.stock_receipt_id');
		$this->db->join('invoice i','i.invoice_id =ri.invoice_id');
		if($search_params['srn_number']!='')
			$this->db->like('sr.srn_number',$search_params['srn_number']);
		if($search_params['vehicle_number']!='')
			$this->db->where('sr.vehicle_number',$search_params['vehicle_number']);
		if($search_params['invoice_number']!='')
			$this->db->where('i.invoice_number',$search_params['invoice_number']);
		if($search_params['fromDate']!='')
			$this->db->where('sr.on_date>=',$search_params['fromDate']);
		if($search_params['toDate']!='')
			$this->db->where('sr.on_date<=',$search_params['toDate']);
		$this->db->where('sr.status',1);
		$this->db->where('sr.plant_id',$plant_id);
		$this->db->group_by('ri.stock_receipt_id');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();	
		//echo $this->db->last_query();exit;	

		return $res->result_array();
	}

	# Get Invoice Product Results
	public function get_receipt_invoice_products($receipt_invoice_id)
	{
	    $this->db->select('rip.received_quantity,p.name as product_name,rip.invoice_quantity,(rip.invoice_quantity-rip.received_quantity) as shortage');
	    $this->db->from('receipt_invoice_product rip');
	    $this->db->join('product p','p.product_id = rip.product_id','left');
	    $this->db->where('rip.receipt_invoice_id',$receipt_invoice_id);
	  
        $res = $this->db->get();
		return $res->result_array();
	}

	# Get Receipt Free Gift Results
	public function get_receipt_free_gift($receipt_invoice_id)
	{
	    $this->db->select('rfg.received_quantity, fg.name as free_gift_name,rfg.invoice_quantity,(rfg.invoice_quantity-rfg.received_quantity) as shortage');
	    $this->db->from('receipt_free_gift rfg');
	    $this->db->join('free_gift fg','fg.free_gift_id = rfg.free_gift_id','left');
	    $this->db->where('rfg.receipt_invoice_id',$receipt_invoice_id);
	  
        $res = $this->db->get();
		return $res->result_array();
	}

	# Get Receipt Free Product Results
	public function get_receipt_free_products($receipt_invoice_id)
	{
	    $this->db->select('rfp.received_quantity,p.name as product_name,rfp.invoice_quantity,(rfp.invoice_quantity-rfp.received_quantity) as shortage');
	    $this->db->from('receipt_free_product rfp');
	    $this->db->join('product p','p.product_id = rfp.product_id','left');
	    $this->db->where('rfp.receipt_invoice_id',$receipt_invoice_id);
	  
        $res = $this->db->get();
		return $res->result_array();
	}

	# Get Invoice Number based on receipt_invoice_id
	public function get_invoice_number($receipt_invoice_id)
	{
	    $this->db->select('i.invoice_number');
	    $this->db->from('receipt_invoice ri');
	    $this->db->join('invoice i','i.invoice_id = ri.invoice_id','left');
	    $this->db->where('ri.receipt_invoice_id',$receipt_invoice_id);
	  	$this->db->where('ri.status',1);
        $res = $this->db->get();
		return $res->result_array();
	}

	# Download SRN Details
	public function download_srn_list($search_params)
	{	$plant_id = $this->session->userdata('ses_plant_id');	
		$this->db->select('sr.*,GROUP_CONCAT(i.invoice_number SEPARATOR ", ") as invoice_number');
		$this->db->from('stock_receipt sr');
		$this->db->join('receipt_invoice ri','sr.stock_receipt_id = ri.stock_receipt_id');
		$this->db->join('invoice i','i.invoice_id =ri.invoice_id');
		if($search_params['srn_number']!='')
			$this->db->like('sr.srn_number',$search_params['srn_number']);
		if($search_params['vehicle_number']!='')
			$this->db->where('sr.vehicle_number',$search_params['vehicle_number']);
		if($search_params['invoice_number']!='')
			$this->db->where('i.invoice_number',$search_params['invoice_number']);
		if($search_params['fromDate']!='')
			$this->db->where('sr.on_date>=',$search_params['fromDate']);
		if($search_params['toDate']!='')
			$this->db->where('sr.on_date<=',$search_params['toDate']);
		$this->db->where('sr.status',1);
		$this->db->where('sr.plant_id',$plant_id);
		$this->db->group_by('ri.stock_receipt_id');
		$res = $this->db->get();	
		//echo $this->db->last_query();exit;	

		return $res->result_array();
	}

	# Get Loss in transit Results
	public function get_lit_results($invoice_id_arr)
	{
	    $this->db->select('*');
	    $this->db->from('loss_in_transit');	    
	    $this->db->where_in('invoice_id',$invoice_id_arr);
	    $this->db->where('status',1);
        $res = $this->db->get();
		return $res->result_array();
	}

	public function get_packing_material($invoice_id)
	{
		$this->db->select('pm.*,ip.*,pu.name as pmunit');
		$this->db->from('invoice_pm ip');
		$this->db->join('packing_material pm','ip.pm_id=pm.pm_id');
		$this->db->join('packing_material_category pmc','pm.pm_category_id = pmc.pm_category_id');
		$this->db->join('pm_unit pu','pmc.pm_unit = pu.pm_unit');
		$this->db->where('ip.status',1);
		$this->db->where('ip.invoice_id',$invoice_id);
		$res=$this->db->get();
		return $res->result_array();
	}

}