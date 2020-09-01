<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock_point_report_m extends CI_Model
{
	public function get_units()
	{
		$this->db->select('p.plant_id as plant_id,p.name as plant_name');
		$this->db->from('plant p');
		$this->db->join('plant_block pb','p.plant_id=pb.plant_id');
		$this->db->where('pb.block_id',3);
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_products()
	{
		$this->db->select('p.product_id as product_id,p.short_name as short_name,l.loose_oil_id as loose_oil_id,l.name as loose_oil_name,p.oil_weight as oil_weight,p.items_per_carton as items_per_carton');
		$this->db->from('product p');
		$this->db->join('product_capacity pc','p.product_id=pc.product_id');
		$this->db->join('capacity c','pc.capacity_id=c.capacity_id');
		$this->db->join('loose_oil l','p.loose_oil_id=l.loose_oil_id');
		$this->db->where('p.status',1);
		$this->db->order_by('l.rank ASC,c.rank ASC');
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_product_stock($plant_id,$effective_date)
	{
		$this->db->select('sum(rip.received_quantity*p.oil_weight*p.items_per_carton) as receipt_quantity,sum(rip.received_quantity) as carton_receipt_quantity,sum(rip.received_quantity*p.items_per_carton) as pouch_receipt_quantity,rip.product_id as product_id');
		$this->db->from('stock_receipt sr');
		$this->db->join('receipt_invoice ri','sr.stock_receipt_id=ri.stock_receipt_id');
		$this->db->join('receipt_invoice_product rip','ri.receipt_invoice_id=rip.receipt_invoice_id');
		$this->db->join('product p','rip.product_id=p.product_id');
		$this->db->where('sr.plant_id',$plant_id);
		$this->db->where('sr.on_date >=',$effective_date);
		$this->db->where('sr.on_date <=',date('Y-m-d'));
		$this->db->group_by('rip.product_id');
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_stock_receipt_search_date($ops_plant_id,$effective_date)
	{
		$this->db->select('sum(rip.received_quantity*p.oil_weight*p.items_per_carton) as receipt_quantity,sum(rip.received_quantity*p.items_per_carton) as pouch_receipt_quantity,rip.product_id as product_id');
		$this->db->from('stock_receipt sr');
		$this->db->join('receipt_invoice ri','sr.stock_receipt_id=ri.stock_receipt_id');
		$this->db->join('receipt_invoice_product rip','ri.receipt_invoice_id=rip.receipt_invoice_id');
		$this->db->join('user u','sr.created_by=u.user_id','left');
		$this->db->join('product p','rip.product_id=p.product_id');
		$this->db->where('u.plant_id',$ops_plant_id);
		$this->db->where('sr.on_date',$effective_date);
		$this->db->group_by('rip.product_id');
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_invoice_stock($plant_id,$effective_date)
	{
		$this->db->select('sum(idp.quantity*p.items_per_carton*p.oil_weight) as invoice_quantity,sum(idp.quantity) as carton_invoice_quantity,sum(idp.quantity*p.items_per_carton) as pouch_invoice_quantity,idp.product_id as product_id');
		$this->db->from('invoice i');
		$this->db->join('invoice_do id','id.invoice_id=i.invoice_id');
		$this->db->join('invoice_do_product idp','id.invoice_do_id=idp.invoice_do_id','left');
		//$this->db->join('plant_order po','id.order_id=po.order_id','left');
		$this->db->join('product p','idp.product_id=p.product_id');
		$this->db->where('i.plant_id',$plant_id);
		//$this->db->where('idp.product_id',$product_id);
		$this->db->where('i.invoice_date >=',$effective_date);
		$this->db->where('i.invoice_date <=',date('Y-m-d'));
		$this->db->where('id.status',1);
		$this->db->group_by('idp.product_id');
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_search_date_invoice_stock($plant_id,$effective_date)
	{
		$this->db->select('sum(idp.quantity*p.oil_weight*p.items_per_carton) as invoice_quantity,sum(idp.quantity) as invoice_carton_quantity,sum(idp.quantity*p.items_per_carton) as pouch_invoice_quantity,idp.product_id as product_id');
		$this->db->from('invoice i');
		$this->db->join('invoice_do id','id.invoice_id=i.invoice_id');
		$this->db->join('invoice_do_product idp','id.invoice_do_id=idp.invoice_do_id','left');
		//$this->db->join('plant_order po','id.order_id=po.order_id','left');
		$this->db->join('product p','idp.product_id=p.product_id');
		$this->db->where('i.plant_id ',$plant_id);
		//$this->db->where('idp.product_id',$product_id);
		$this->db->where('i.invoice_date ',$effective_date);
		//$this->db->where('id.status',1);
		$this->db->group_by('idp.product_id');
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_leakage_stock($plant_id,$effective_date)
	{	
		$this->db->select('sum((lp.leaked_pouches/lp.items_per_carton)*p.oil_weight) as leakage_quantity,sum(lp.leaked_pouches) as leaked_pouches,lp.product_id as product_id');
		$this->db->from('leakage_entry le');
		$this->db->join('leakage_product lp','le.leakage_id=lp.leakage_id');
		$this->db->join('product p','lp.product_id=p.product_id');
		$this->db->where('le.plant_id',$plant_id);
	    $this->db->where('le.on_date >=',$effective_date);
		$this->db->where('le.on_date <=',date('Y-m-d'));
		$this->db->where('lp.status',1);
		$this->db->where('le.type',1);
		$this->db->group_by('lp.product_id');
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_search_date_leakage_quantity($plant_id,$effective_date)
	{
		$this->db->select('sum((lp.leaked_pouches/lp.items_per_carton)*p.oil_weight) as leakage_quantity,sum(lp.leaked_pouches) as leaked_pouches,lp.product_id as product_id');
		$this->db->from('leakage_entry le');
		$this->db->join('leakage_product lp','le.leakage_id=lp.leakage_id');
		$this->db->join('product p','lp.product_id=p.product_id');
		$this->db->where('le.plant_id',$plant_id);
	    $this->db->where('le.on_date ',$effective_date);
		$this->db->where('lp.status',1);
		$this->db->where('le.type',1);
		$this->db->group_by('lp.product_id');
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_recovery_stock($plant_id,$effective_date)
	{
		$this->db->select('sum(lrp.quantity) as recovery_quantity,lrp.product_id as product_id');
		$this->db->from('leakage_recovery lr');
		$this->db->join('leakage_recovered_products lrp','lr.recovery_id=lrp.recovery_id');
		$this->db->join('leakage_entry le','lr.leakage_id=le.leakage_id');
		$this->db->where('le.plant_id',$plant_id);
		$this->db->where('lr.on_date >=',$effective_date);
		$this->db->where('lr.on_date <=',date('Y-m-d'));
		$this->db->group_by('lrp.product_id');
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_ops_units($block_id)
	{
		$this->db->select('p.short_name as short_name,p.plant_id as plant_id');
		$this->db->from('plant p');
		$this->db->join('plant_block pb','p.plant_id=pb.plant_id');
		$this->db->where('pb.block_id',$block_id);
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_production_data($plant_id,$effective_date)
	{
		$this->db->select('ropp.product_id as product_id,sum(ropp.item_qty*p.oil_weight) as production_qty,sum(ropp.item_qty) as pouch_production_qty,sum(ropp.item_qty) as carton_production_qty');
		$this->db->from('recovered_oil_production rop');
		$this->db->join('rop_product ropp','rop.ro_production_id=ropp.ro_production_id');
		$this->db->join('product p','ropp.product_id=p.product_id');
		$this->db->where('rop.plant_id',$plant_id);
		$this->db->where('rop.on_date',$effective_date);
		$this->db->group_by('ropp.product_id');
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_stock_to_counter_data($plant_id,$effective_date)
	{
			
		$this->db->select('sum(gstp.quantity*p.items_per_carton*p.oil_weight) as gst_quantity,sum(gstp.quantity) as gst_carton_quantity,sum(gstp.quantity*p.items_per_carton) as pouch_gst_quantity,gstp.product_id as product_id');
		$this->db->from('plant_counter pc');
		$this->db->join('godown_stock_transfer gst','pc.counter_id=gst.counter_id');
		$this->db->join('gst_product gstp','gst.gst_id=gstp.gst_id');
		$this->db->join('product p','gstp.product_id=p.product_id');
		$this->db->where('pc.plant_id',$plant_id);
		$this->db->where('gst.on_date',$effective_date);
		$this->db->where('gst.st_type_id',1);
		$this->db->group_by('gstp.product_id');
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_search_date_free_sample($plant_id,$effective_date)
	{
		$this->db->select('sum(f.quantity*p.items_per_carton*p.oil_weight) as free_quantity,sum(f.quantity) as free_quantity_cartons,sum(f.quantity*p.items_per_carton) as pouch_free_quantity,f.product_id as product_id');
		$this->db->from('free_sample f');
		$this->db->join('product p','f.product_id=p.product_id');
		$this->db->where('f.plant_id',$plant_id);
		$this->db->where('f.on_date >=',$effective_date);
		$this->db->where('f.on_date <=',date('Y-m-d'));
		$this->db->group_by('f.product_id');
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_free_sample_data($plant_id,$effective_date)
	{
		$this->db->select('sum(f.quantity*p.items_per_carton*p.oil_weight) as free_quantity,sum(f.quantity) as free_quantity_cartons,sum(f.quantity*p.items_per_carton) as pouch_free_quantity,f.product_id as product_id');
		$this->db->from('free_sample f');
		$this->db->join('product p','f.product_id=p.product_id');
		$this->db->where('plant_id',$plant_id);
		$this->db->where('on_date',$effective_date);
		$this->db->group_by('f.product_id');
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_plant_product_quantity($plant_id)
	{
		$this->db->select('(pp.quantity*p.items_per_carton*p.oil_weight) as quantity,(pp.quantity*p.items_per_carton) as pouch_quantity,sum(pp.quantity) as cartons,pp.product_id as product_id');
		$this->db->from('plant_product pp');
		$this->db->join('product p','pp.product_id=p.product_id');
		$this->db->where('pp.plant_id',$plant_id);
		$this->db->group_by('pp.product_id');
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_loose_oils()
	{
		$this->db->select('loose_oil_id,name');
		$this->db->from('loose_oil');
		$this->db->where('status',1);
		$this->db->order_by('rank ASC');
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_recovered_oil_production($plant_id,$effective_date)
	{
		$this->db->select('rop.loose_oil_id as loose_oil_id,sum(ropp.item_qty*p.oil_weight) as production_oil_qty');
		$this->db->from('recovered_oil_production rop');
		$this->db->join('rop_product ropp','rop.ro_production_id=ropp.ro_production_id');
		$this->db->join('product p','ropp.product_id=p.product_id');
		$this->db->where('rop.plant_id',$plant_id);
		$this->db->where('rop.on_date >=',$effective_date);
		$this->db->where('rop.on_date <=',date('Y-m-d'));
		$this->db->group_by('rop.loose_oil_id');
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_rop_date($plant_id,$effective_date)
	{
		$this->db->select('rop.loose_oil_id as loose_oil_id,sum(ropp.item_qty*p.oil_weight) as production_oil_qty');
		$this->db->from('recovered_oil_production rop');
		$this->db->join('rop_product ropp','rop.ro_production_id=ropp.ro_production_id');
		$this->db->join('product p','ropp.product_id=p.product_id');
		$this->db->where('rop.plant_id',$plant_id);
		$this->db->where('rop.on_date ',$effective_date);
		$this->db->group_by('rop.loose_oil_id');
		$res=$this->db->get();
		//echo $this->db->last_query();
		return $res->result_array();
	}
	public function get_leakage_recovered_stock($plant_id,$effective_date)
	{
		$this->db->select('sum(lro.oil_weight) as recovered_oil_weight,lro.loose_oil_id as loose_oil_id');
		$this->db->from('leakage_entry le');
		$this->db->join('leakage_recovery lr','le.leakage_id=lr.leakage_id');
		$this->db->join('leakage_recovered_oil lro','lr.recovery_id=lro.recovery_id');
		$this->db->where('le.plant_id',$plant_id);
		$this->db->where('lr.on_date >=',$effective_date);
		$this->db->where('lr.on_date <=',date('Y-m-d'));
		$this->db->group_by('lro.loose_oil_id');
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_curr_leakage_recovered_qty($plant_id,$effective_date)
	{
		$this->db->select('sum(lro.oil_weight) as recovered_oil_weight,lro.loose_oil_id as loose_oil_id');
		$this->db->from('leakage_entry le');
		$this->db->join('leakage_recovery lr','le.leakage_id=lr.leakage_id');
		$this->db->join('leakage_recovered_oil lro','lr.recovery_id=lro.recovery_id');
		$this->db->where('le.plant_id',$plant_id);
		$this->db->where('lr.on_date',$effective_date);
		$this->db->group_by('lro.loose_oil_id');
		$res=$this->db->get();
		return $res->result_array();
	}

	// Get counter sale product qty
	public function get_counter_sale_cur_stock($plant_id)
	{
		$this->db->select('pcp.product_id, pcp.quantity, (pcp.quantity*p.items_per_carton) as cs_pouch_stock');
		$this->db->from('plant_counter_product pcp');
		$this->db->join('plant_counter pc','pc.counter_id = pcp.counter_id');
		$this->db->join('product p','p.product_id = pcp.product_id');
		$this->db->where('pc.plant_id',$plant_id);
		//$this->db->group_by('pcp.product_id');
		$res=$this->db->get();
		return $res->result_array();
	}

	// Get Counter Sale sales between search date and current date
	public function get_cs_product_sales($plant_id,$effective_date)
	{
		$this->db->select('csp.product_id, sum(csp.quantity) as cs_pouch_sale');
		$this->db->from('counter_sale cs');
		$this->db->join('cs_product csp','cs.counter_sale_id = csp.counter_sale_id');
		$this->db->join('product p','p.product_id = csp.product_id');
		$this->db->join('plant_counter pc','pc.counter_id = cs.counter_id');
		$this->db->where('pc.plant_id',$plant_id);
		$this->db->where('cs.on_date >=',$effective_date);
		$this->db->where('cs.on_date <=',date('Y-m-d'));
		$this->db->group_by('csp.product_id');
		$res=$this->db->get();
		return $res->result_array();
	} 

	// Get Godown to Counter stock transfer between search date and current date
	public function get_godown_to_counter_stock_transfer($plant_id,$effective_date)
	{
		$this->db->select('gstp.product_id, sum(gstp.quantity) as gd_cs_stock, sum(gstp.quantity*gstp.items_per_carton) as gd_cs_pouch_stock,sum(gstp.quantity*gstp.items_per_carton*p.oil_weight) as gd_cs_oil_weight');
		$this->db->from('godown_stock_transfer gst');
		$this->db->join('gst_product gstp','gstp.gst_id = gst.gst_id');
		$this->db->join('product p','p.product_id = csp.product_id');
		$this->db->join('plant_counter pc','pc.counter_id = gst.counter_id');
		$this->db->where('pc.plant_id',$plant_id);
		$this->db->where('gst.on_date >=',$effective_date);
		$this->db->where('gst.on_date <=',date('Y-m-d'));
		$this->db->where('gst.st_type_id',1);
		$this->db->group_by('gstp.product_id');
		$res=$this->db->get();
		return $res->result_array();
	} 

	// Get Counter to Godown stock transfer between search date and current date
	public function get_counter_to_godown_stock_transfer($plant_id,$effective_date)
	{
		$this->db->select('gstp.product_id, sum(gstp.quantity) as gd_cs_stock, sum(gstp.quantity*gstp.items_per_carton) as gd_cs_pouch_stock,sum(gstp.quantity*gstp.items_per_carton*p.oil_weight) as gd_cs_oil_weight');
		$this->db->from('godown_stock_transfer gst');
		$this->db->join('gst_product gstp','gstp.gst_id = gst.gst_id');
		$this->db->join('product p','p.product_id = csp.product_id');
		$this->db->join('plant_counter pc','pc.counter_id = gst.counter_id');
		$this->db->where('pc.plant_id',$plant_id);
		$this->db->where('gst.on_date >=',$effective_date);
		$this->db->where('gst.on_date <=',date('Y-m-d'));
		$this->db->where('gst.st_type_id',2);
		$this->db->group_by('gstp.product_id');
		$res=$this->db->get();
		return $res->result_array();
	} 

	public function get_plant_receits($plant_id,$effective_date)
	{
		$this->db->select('sum(rip.received_quantity*p.oil_weight*p.items_per_carton) as tot_oil_weight,sum(rip.received_quantity) as carton_receipt_quantity,sum(rip.received_quantity*p.items_per_carton) as pouch_receipt_quantity,rip.product_id as product_id,i.plant_id');
		$this->db->from('stock_receipt sr');
		$this->db->join('receipt_invoice ri','sr.stock_receipt_id=ri.stock_receipt_id');
		$this->db->join('receipt_invoice_product rip','ri.receipt_invoice_id=rip.receipt_invoice_id');
		$this->db->join('product p','rip.product_id=p.product_id');
		$this->db->join('invoice i','i.invoice_id = ri.invoice_id');
		$this->db->where('sr.plant_id',$plant_id);
		$this->db->where('sr.on_date ',$effective_date);
		$this->db->group_by('rip.product_id,i.plant_id');
		$res=$this->db->get();
		return $res->result_array();
	}
	//get total production qty from effective date to current date for all products
	public function get_recovered_oil_production_qty($plant_id,$effective_date)
	{
		$this->db->select('ropp.product_id,sum(ropp.item_qty) as tot_production_qty,sum(ropp.item_qty * p.oil_weight) as tot_production_weight');
		$this->db->from('recovered_oil_production rop');
		$this->db->join('rop_product ropp','rop.ro_production_id=ropp.ro_production_id');
		$this->db->join('product p','ropp.product_id=p.product_id');
		$this->db->where('rop.plant_id',$plant_id);
		$this->db->where('rop.on_date >=',$effective_date);
		$this->db->where('rop.on_date <=',date('Y-m-d'));
		$this->db->group_by('ropp.product_id');
		$res=$this->db->get();
		return $res->result_array();
	}

	/**
	*** Get Production stock between from_date and to_date 
	*** Mahesh 14 APr 2017 7:09 AM
	**/

	public function get_monthly_production_data($plant_id,$from_date,$to_date)
	{
		$this->db->select('ropp.product_id as product_id,sum(ropp.item_qty*p.oil_weight) as production_qty,sum(ropp.item_qty) as pouch_production_qty,sum(ropp.item_qty) as carton_production_qty');
		$this->db->from('recovered_oil_production rop');
		$this->db->join('rop_product ropp','rop.ro_production_id=ropp.ro_production_id');
		$this->db->join('product p','ropp.product_id=p.product_id');
		$this->db->where('rop.plant_id',$plant_id);
		$this->db->where('rop.on_date>=',$from_date);
		$this->db->where('rop.on_date<=',$to_date);
		$this->db->group_by('ropp.product_id');
		$res=$this->db->get();
		return $res->result_array();
	}

	/**
	*** Get Invoice Sales between from_date and to_date 
	*** Mahesh 14 APr 2017 7:09 AM
	**/
	public function get_monthly_invoice_sales($plant_id,$from_date,$to_date)
	{
		$this->db->select('sum(idp.quantity*p.oil_weight*p.items_per_carton) as invoice_quantity,sum(idp.quantity) as invoice_carton_quantity,sum(idp.quantity*p.items_per_carton) as pouch_invoice_quantity,idp.product_id as product_id');
		$this->db->from('invoice i');
		$this->db->join('invoice_do id','id.invoice_id=i.invoice_id');
		$this->db->join('invoice_do_product idp','id.invoice_do_id=idp.invoice_do_id','left');
		//$this->db->join('plant_order po','id.order_id=po.order_id','left');
		$this->db->join('product p','idp.product_id=p.product_id');
		$this->db->where('i.plant_id ',$plant_id);
		//$this->db->where('idp.product_id',$product_id);
		$this->db->where('i.invoice_date>=',$from_date);
		$this->db->where('i.invoice_date<=',$to_date);
		//$this->db->where('id.status',1);
		$this->db->group_by('idp.product_id');
		$res=$this->db->get();
		return $res->result_array();
	}

	/**
	*** Get Stock to counter between from_date and to_date 
	*** Mahesh 14 APr 2017 7:09 AM
	**/
	public function get_monthly_stock_transfer_counter($plant_id,$from_date,$to_date)
	{
			
		$this->db->select('sum(gstp.quantity*p.items_per_carton*p.oil_weight) as gst_quantity,sum(gstp.quantity) as gst_carton_quantity,sum(gstp.quantity*p.items_per_carton) as pouch_gst_quantity,gstp.product_id as product_id');
		$this->db->from('plant_counter pc');
		$this->db->join('godown_stock_transfer gst','pc.counter_id=gst.counter_id');
		$this->db->join('gst_product gstp','gst.gst_id=gstp.gst_id');
		$this->db->join('product p','gstp.product_id=p.product_id');
		$this->db->where('pc.plant_id',$plant_id);
		$this->db->where('gst.on_date>=',$from_date);
		$this->db->where('gst.on_date>=',$to_date);
		$this->db->where('gst.st_type_id',1);
		$this->db->group_by('gstp.product_id');
		$res=$this->db->get();
		return $res->result_array();
	}

	/**
	*** Get free samples between from_date and to_date 
	*** Mahesh 14 APr 2017 7:09 AM
	**/
	public function get_monthly_free_samples($plant_id,$from_date,$to_date)
	{
		$this->db->select('sum(f.quantity*p.items_per_carton*p.oil_weight) as free_quantity,sum(f.quantity) as free_quantity_cartons,sum(f.quantity*p.items_per_carton) as pouch_free_quantity,f.product_id as product_id');
		$this->db->from('free_sample f');
		$this->db->join('product p','f.product_id=p.product_id');
		$this->db->where('plant_id',$plant_id);
		$this->db->where('on_date>=',$from_date);
		$this->db->where('on_date<=',$to_date);
		$this->db->group_by('f.product_id');
		$res=$this->db->get();
		return $res->result_array();
	}

	/**
	*** Get leaked stock between from_date and to_date 
	*** Mahesh 14 APr 2017 7:09 AM
	**/
	public function get_monthly_leaked_stock($plant_id,$from_date,$to_date)
	{
		$this->db->select('sum((lp.leaked_pouches/lp.items_per_carton)*p.oil_weight) as leakage_quantity,sum(lp.leaked_pouches) as leaked_pouches,lp.product_id as product_id');
		$this->db->from('leakage_entry le');
		$this->db->join('leakage_product lp','le.leakage_id=lp.leakage_id');
		$this->db->join('product p','lp.product_id=p.product_id');
		$this->db->where('le.plant_id',$plant_id);
	    $this->db->where('le.on_date>=',$from_date);
	    $this->db->where('le.on_date<=',$to_date);
		$this->db->where('lp.status',1);
		$this->db->where('le.type',1);
		$this->db->group_by('lp.product_id');
		$res=$this->db->get();
		return $res->result_array();
	}

	/**
	*** Get stock receipts between from_date and to_date 
	*** Mahesh 14 APr 2017 7:09 AM
	**/
	public function get_monthly_stock_receipts($plant_id,$from_date,$to_date)
	{
		$this->db->select('sum(rip.received_quantity*p.oil_weight*p.items_per_carton) as tot_oil_weight,sum(rip.received_quantity) as carton_receipt_quantity,sum(rip.received_quantity*p.items_per_carton) as pouch_receipt_quantity,rip.product_id as product_id,i.plant_id');
		$this->db->from('stock_receipt sr');
		$this->db->join('receipt_invoice ri','sr.stock_receipt_id=ri.stock_receipt_id');
		$this->db->join('receipt_invoice_product rip','ri.receipt_invoice_id=rip.receipt_invoice_id');
		$this->db->join('product p','rip.product_id=p.product_id');
		$this->db->join('invoice i','i.invoice_id = ri.invoice_id');
		$this->db->where('sr.plant_id',$plant_id);
		$this->db->where('sr.on_date>=',$from_date);
		$this->db->where('sr.on_date<=',$to_date);
		$this->db->group_by('rip.product_id,i.plant_id');
		$res=$this->db->get();
		return $res->result_array();
	}

	/**
	*** Get production between from_date and to_date 
	*** Mahesh 14 APr 2017 7:09 AM
	**/
	public function get_monthly_porduction($plant_id,$from_date,$to_date)
	{
		$this->db->select('rop.loose_oil_id as loose_oil_id,sum(ropp.item_qty*p.oil_weight) as production_oil_qty');
		$this->db->from('recovered_oil_production rop');
		$this->db->join('rop_product ropp','rop.ro_production_id=ropp.ro_production_id');
		$this->db->join('product p','ropp.product_id=p.product_id');
		$this->db->where('rop.plant_id',$plant_id);
		$this->db->where('rop.on_date>=',$from_date);
		$this->db->where('rop.on_date<=',$to_date);
		$this->db->group_by('rop.loose_oil_id');
		$res=$this->db->get();
		//echo $this->db->last_query();
		return $res->result_array();
	}

	/**
	*** Get recovered oil between from_date and to_date 
	*** Mahesh 14 APr 2017 7:09 AM
	**/
	public function get_monthly_recovered_oil($plant_id,$from_date,$to_date)
	{
		$this->db->select('sum(lro.oil_weight) as recovered_oil_weight,lro.loose_oil_id as loose_oil_id');
		$this->db->from('leakage_entry le');
		$this->db->join('leakage_recovery lr','le.leakage_id=lr.leakage_id');
		$this->db->join('leakage_recovered_oil lro','lr.recovery_id=lro.recovery_id');
		$this->db->where('le.plant_id',$plant_id);
		$this->db->where('lr.on_date>=',$from_date);
		$this->db->where('lr.on_date<=',$to_date);
		$this->db->group_by('lro.loose_oil_id');
		$res=$this->db->get();
		return $res->result_array();
	}
}
