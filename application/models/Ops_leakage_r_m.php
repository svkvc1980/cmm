<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by mastan on 16th Mar 2017 15:30PM
*/

class Ops_leakage_r_m extends CI_Model {

	public function get_leakage_products()
	{
		$this->db->select('p.product_id as product_id,p.name as product_name');
		$this->db->from('product p');
		$this->db->join('product_capacity pc','p.product_id=pc.product_id');
		$this->db->join('capacity c','pc.capacity_id=c.capacity_id');
		$this->db->join('loose_oil l','p.loose_oil_id=l.loose_oil_id');
		$this->db->where('p.status',1);
		$this->db->order_by('l.rank ASC,c.rank ASC');
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_loose_oils()
	{
		$this->db->from('loose_oil');
		$this->db->where('status',1);
		$this->db->order_by('rank ASC');
		$res=$this->db->get();
		return $res->result_array();
	}

	public function ops_leakage_report_total_rows($search_params,$plant_id)
	{
		$this->db->select('ol.*, p.name as product');
		$this->db->from('ops_leakage ol');
		$this->db->join('product p', 'p.product_id = ol.product_id');
		$this->db->where('ol.plant_id',$plant_id);
		if($search_params['product_id']!='')
			$this->db->where('p.product_id',$search_params['product_id']);
		if($search_params['loose_oil_id']!='')
			$this->db->where('p.loose_oil_id',$search_params['loose_oil_id']);
		if($search_params['from_date']!='')
			$this->db->where('ol.on_date >=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('ol.on_date <=',$search_params['to_date']);
		$res = $this->db->get();
		return $res->num_rows();
	}

	public function ops_leakage_report_results($search_params,$current_offset,$per_page,$plant_id)
	{
		$this->db->select('ol.*, p.name as product,p.oil_weight as oil_weight');
		$this->db->from('ops_leakage ol');
		$this->db->join('product p', 'p.product_id = ol.product_id');
		$this->db->where('ol.plant_id',$plant_id);
		if($search_params['product_id']!='')
			$this->db->where('p.product_id',$search_params['product_id']);
		if($search_params['loose_oil_id']!='')
			$this->db->where('p.loose_oil_id',$search_params['loose_oil_id']);
		if($search_params['from_date']!='')
			$this->db->where('ol.on_date >=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('ol.on_date <=',$search_params['to_date']);
		$this->db->order_by('ol.ops_leakage_id', 'DESC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function download_ops_leakage_report($search_params,$plant_id)
	{
		$this->db->select('ol.*, p.name as product,p.oil_weight as oil_weight');
		$this->db->from('ops_leakage ol');
		$this->db->join('product p', 'p.product_id = ol.product_id');
		$this->db->where('ol.plant_id',$plant_id);
		if($search_params['product_id']!='')
			$this->db->where('p.product_id',$search_params['product_id']);
		if($search_params['loose_oil_id']!='')
			$this->db->where('p.loose_oil_id',$search_params['loose_oil_id']);
		if($search_params['from_date']!='')
			$this->db->where('ol.on_date >=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('ol.on_date <=',$search_params['to_date']);
		$this->db->order_by('ol.ops_leakage_id', 'DESC');
		$res = $this->db->get();
		return $res->result_array();
	}

	/*	stock point leakage reports
		----Mastan----
	*/

	public function get_sp_leakage_products()
	{
		$this->db->select('p.name as product, p.product_id');
		$this->db->from('leakage_product lp');
		$this->db->join('product p', 'p.product_id = lp.product_id');
		$res = $this->db->get();
		return $res->result_array();
	}

	public function sp_leakage_report_total_rows($search_params)
	{
		$plant_id = $this->session->userdata('ses_plant_id');
		$this->db->select('le.*, lp.*,l.name as loose_oil, p.name as product');
		$this->db->from('leakage_entry le');
		$this->db->join('leakage_product lp', 'lp.leakage_id = le.leakage_id');
		$this->db->join('leakage_recovery lr', 'lr.leakage_id = le.leakage_id');
		$this->db->join('leakage_recovered_oil lro', 'lro.recovery_id = lr.recovery_id');
		$this->db->join('leakage_recovered_products lrp', 'lrp.recovery_id = lr.recovery_id');
		$this->db->join('loose_oil l', 'l.loose_oil_id = lro.loose_oil_id');
		$this->db->join('product p', 'p.product_id = lp.product_id');
		if($search_params['product_id']!='')
			$this->db->where('p.product_id',$search_params['product_id']);
		if($search_params['loose_oil_id']!='')
			$this->db->where('p.loose_oil_id',$search_params['loose_oil_id']);
		if($search_params['from_date']!='')
			$this->db->where('le.on_date >=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('le.on_date <=',$search_params['to_date']);
		$this->db->where('le.plant_id',$plant_id);
		$this->db->order_by('le.leakage_number ASC,le.on_date ASC');
		$res = $this->db->get();
		return $res->num_rows();
	}

	public function sp_leakage_report_results($search_params,$current_offset,$per_page)
	{
		$plant_id = $this->session->userdata('ses_plant_id');
		$this->db->select('le.leakage_number as leakage_number, p.name as product,lp.product_id,lp.leaked_pouches as leaked_pouches,lp.quantity as leakage_quantity,lrp.quantity as recovered_quantity,le.on_date as on_date,lro.oil_weight as oil_recovered,p.oil_weight as oil_weight');
		$this->db->from('leakage_entry le');
		$this->db->join('leakage_product lp', 'lp.leakage_id = le.leakage_id');
		$this->db->join('leakage_recovery lr', 'lr.leakage_id = le.leakage_id');
		$this->db->join('leakage_recovered_oil lro', 'lro.recovery_id = lr.recovery_id');
		$this->db->join('leakage_recovered_products lrp', 'lrp.recovery_id = lr.recovery_id');
		$this->db->join('loose_oil l', 'l.loose_oil_id = lro.loose_oil_id');
		$this->db->join('product p', 'p.product_id = lp.product_id');
		if($search_params['product_id']!='')
			$this->db->where('p.product_id',$search_params['product_id']);
		if($search_params['loose_oil_id']!='')
			$this->db->where('p.loose_oil_id',$search_params['loose_oil_id']);
		if($search_params['from_date']!='')
			$this->db->where('le.on_date >=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('le.on_date <=',$search_params['to_date']);
		$this->db->where('le.plant_id',$plant_id);
		$this->db->order_by('le.leakage_number ASC,le.on_date ASC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_ops_leakage_reports($search_params)
	{
		$plant_id = $this->session->userdata('ses_plant_id');
		$this->db->select('le.leakage_number as leakage_number, p.name as product,lp.product_id,lp.leaked_pouches as leaked_pouches,lp.quantity as leakage_quantity,lrp.quantity as recovered_quantity,le.on_date as on_date,lro.oil_weight as oil_recovered,p.oil_weight as oil_weight');
		$this->db->from('leakage_entry le');
		$this->db->join('leakage_product lp', 'lp.leakage_id = le.leakage_id');
		$this->db->join('leakage_recovery lr', 'lr.leakage_id = le.leakage_id');
		$this->db->join('leakage_recovered_oil lro', 'lro.recovery_id = lr.recovery_id');
		$this->db->join('leakage_recovered_products lrp', 'lrp.recovery_id = lr.recovery_id');
		$this->db->join('loose_oil l', 'l.loose_oil_id = lro.loose_oil_id');
		$this->db->join('product p', 'p.product_id = lp.product_id');
		if($search_params['product_id']!='')
			$this->db->where('p.product_id',$search_params['product_id']);
		if($search_params['loose_oil_id']!='')
			$this->db->where('p.loose_oil_id',$search_params['loose_oil_id']);
		if($search_params['from_date']!='')
			$this->db->where('le.on_date >=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('le.on_date <=',$search_params['to_date']);
		$this->db->where('le.plant_id',$plant_id);
		//$this->db->where('le.leakage_id');
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_all_products_latest_price_plant($distributor_type,$plant_id)
	{
		$query=	'SELECT * FROM product_price p WHERE p.start_date= (select max(p1.start_date) as start_date from product_price p1 where p1.product_id=p.product_id and p1.plant_id=p.plant_id and p1.price_type_id=p.price_type_id and p1.start_date <= "'.date('Y-m-d').'") and p.plant_id = "'.$plant_id.'" and p.price_type_id = "'.$distributor_type.'"';
	    $res=$this->db->query($query);
	    $product_latest_rates = array();
	   // $product_latest_details=array();
	    if($res->num_rows()>0)
	    {
	    	$results = $res->result_array();
	    	foreach ($results as $row) 
	    	{
	    		$product_latest_rates[$row['product_id']] = $row;
	    		//$product_latest_details[$row['product_id']] = $row;
	    	}
	    }
	    return $product_latest_rates;
	}

	/* Prasad Consolidated leakage report 29 Apr 2017 05:37 PM  start */
		public function get_units()
	{
		$this->db->select('p.*');
		$this->db->from('plant p');
		$this->db->join('plant_block pb','p.plant_id=pb.plant_id');
		$in=array(2,3);
		$this->db->where_in('pb.block_id',$in);
		$res=$this->db->get();
		return $res->result_array();
	}

	public function all_units_sp_leakage_report_results($from_date,$to_date,$plant_id)
	{
		$this->db->select('le.leakage_number as leakage_number, p.name as product,lp.product_id,lp.leaked_pouches as leaked_pouches,lp.quantity as leakage_quantity,lrp.quantity as recovered_quantity,le.on_date as on_date,lro.oil_weight as oil_recovered,p.oil_weight as oil_weight,le.plant_id as plant_id');
		$this->db->from('leakage_entry le');
		$this->db->join('leakage_product lp', 'lp.leakage_id = le.leakage_id');
		$this->db->join('leakage_recovery lr', 'lr.leakage_id = le.leakage_id');
		$this->db->join('leakage_recovered_oil lro', 'lro.recovery_id = lr.recovery_id');
		$this->db->join('leakage_recovered_products lrp', 'lrp.recovery_id = lr.recovery_id');
		$this->db->join('loose_oil l', 'l.loose_oil_id = lro.loose_oil_id');
		$this->db->join('product p', 'p.product_id = lp.product_id');
		if($plant_id !='')
		{
			$this->db->where('le.plant_id ',$plant_id);
		}
		if($from_date!='')
			$this->db->where('le.on_date >=',$from_date);
		if($to_date!='')
			$this->db->where('le.on_date <=',$to_date);
		$this->db->order_by('le.on_date ASC');
		$res = $this->db->get();
		return $res->result_array();
	}

	public function all_units_ops_leakage_report_results($from_date,$to_date,$plant_id)
	{
		$this->db->select('ol.*, p.name as product,p.oil_weight as oil_weight');
		$this->db->from('ops_leakage ol');
		$this->db->join('product p', 'p.product_id = ol.product_id');
		if($plant_id !='')
		{
			$this->db->where('ol.plant_id',$plant_id);
		}
		if($from_date!='')
			$this->db->where('ol.on_date >=',$from_date);
		if($to_date!='')
			$this->db->where('ol.on_date <=',$to_date);
		$this->db->order_by('ol.on_date ASC');
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_all_products_latest_price($distributor_type)
	{
		$query=	'SELECT * FROM product_price p WHERE p.start_date= (select max(p1.start_date) as start_date from product_price p1 where p1.product_id=p.product_id  and p1.price_type_id=p.price_type_id and p1.plant_id=p.plant_id and p1.start_date <= "'.date('Y-m-d').'")  and p.price_type_id = "'.$distributor_type.'" ';
	    $res=$this->db->query($query);
	    
	    return $res->result_array();
	}
	/* Prasad Consolidated leakage report  End */

}