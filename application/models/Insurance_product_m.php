<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by mastan on 27th Mar 2016 12:00PM
 */

class Insurance_product_m extends CI_Model {

	public function get_latest_invoice_number($invoice_no)
	{
		$block_id = $this->session->userdata('block_id');
		$plant_id = $this->session->userdata('ses_plant_id');
		$this->db->select('invoice_id');
		$this->db->from('invoice');
		if($block_id==1)
		{
			$this->db->where('invoice_number',$invoice_no);
		}
		else
		{
			$this->db->where('plant_id',$plant_id);
			$this->db->where('invoice_number',$invoice_no);

		}
		$this->db->order_by('invoice_id DESC');
		$this->db->limit(1);
		$res = $this->db->get();
		if($res->num_rows()>0)
		{
			$row = $res->row_array();
			return $row['invoice_id'];
		}
		else
		{
			return 0;
		}

	}
	public function get_plant_invoice_number($invoice_no)
	{
		$this->db->select('invoice_id');
		$this->db->from('invoice');
		$this->db->where('invoice_number',$invoice_no);
		$this->db->order_by('invoice_id DESC');
		$this->db->limit(1);
		$res = $this->db->get();
		if($res->num_rows()>0)
		{
			$row = $res->row_array();
			return $row['invoice_id'];
		}
		else
		{
			return 0;
		}
	}

	public function get_insurance_generated_loose_oils($from_date,$to_date,$distributor_id,$plant_id)
	{
		$this->db->select('p.loose_oil_id,lo.name');
		$this->db->from('insurance_product ip');
		$this->db->join('insurance i','ip.insurance_id=i.insurance_id');
		$this->db->join('invoice_do_product idop','ip.invoice_do_product_id=idop.invoice_do_product_id');
		$this->db->join('invoice_do ido','idop.invoice_do_id = ido.invoice_do_id');
		$this->db->join('order ord','ord.order_id = ido.order_id');
		if($plant_id !='' && $distributor_id !='')
		{
			 $this->db->join('plant_order po','ido.order_id=po.order_id','left');
			 $this->db->join('distributor_order dio','ido.order_id=dio.order_id','left');
		}
		elseif($plant_id!=''&&$distributor_id =='')
		{
			$this->db->join('plant_order po','ido.order_id=po.order_id','left');
		}
		elseif($plant_id==''&&$distributor_id!='')
		{
			$this->db->join('distributor_order dio','ido.order_id=dio.order_id','left');
		}
		$this->db->join('product p','ip.product_id=p.product_id');
		$this->db->join('loose_oil lo','p.loose_oil_id=lo.loose_oil_id');
		if($from_date !='')
		{
           $this->db->where('i.received_date >=',$from_date);
		}
		if($to_date !='')
		{
           $this->db->where('i.received_date <=',$to_date);
		}
		if($distributor_id !='')
		{
           $this->db->where('dio.distributor_id ',$distributor_id);
		}
		if($plant_id !='')
		{
           $this->db->where('po.plant_id ',$plant_id);
		}
		$this->db->group_by('p.loose_oil_id');
		$res=$this->db->get();
		return $res->result_array();
	}

	public function get_dist_insurance_products($loose_oil_id,$from_date,$to_date,$distributor_id,$plant_id)
	{
		$this->db->select('ip.*,ii.*,dist.distributor_code,dop.product_price,dist.agency_name,i.invoice_date,i.plant_id as invoice_plant,p.short_name as product_name,i.invoice_number');
		$this->db->from('insurance ii');
		$this->db->join('insurance_product ip','ii.insurance_id=ip.insurance_id');
		$this->db->join('invoice_do_product idop','ip.invoice_do_product_id=idop.invoice_do_product_id');
		$this->db->join('do_order_product dop','idop.do_ob_product_id=dop.do_ob_product_id');
		$this->db->join('invoice_do ido','idop.invoice_do_id = ido.invoice_do_id');
		$this->db->join('invoice i','ido.invoice_id=i.invoice_id');
		$this->db->join('order ord','ord.order_id = ido.order_id');
		$this->db->join('distributor_order dio','ido.order_id=dio.order_id');
		$this->db->join('distributor dist','dist.distributor_id=dio.distributor_id');
		$this->db->join('product p','ip.product_id=p.product_id');
		$this->db->where('p.loose_oil_id',$loose_oil_id);
		if($from_date !='')
		{
           $this->db->where('ii.received_date >=',$from_date);
		}
		if($to_date !='')
		{
           $this->db->where('ii.received_date <=',$to_date);
		}
		if($distributor_id !='')
		{
           $this->db->where('dio.distributor_id ',$distributor_id);
		}
		$this->db->order_by('dist.distributor_id');
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_plant_insurance_products($loose_oil_id,$from_date,$to_date,$distributor_id,$plant_id)
	{
		$this->db->select('ip.*,ii.*,pl.plant_id,dop.product_price,pl.name as plant_name,i.invoice_date,i.plant_id as invoice_plant,p.short_name as product_name,i.invoice_number');
		$this->db->from('insurance ii');
		$this->db->join('insurance_product ip','ii.insurance_id=ip.insurance_id');
		$this->db->join('invoice_do_product idop','ip.invoice_do_product_id=idop.invoice_do_product_id');
		$this->db->join('do_order_product dop','idop.do_ob_product_id=dop.do_ob_product_id');
		$this->db->join('invoice_do ido','idop.invoice_do_id = ido.invoice_do_id');
		$this->db->join('invoice i','ido.invoice_id=i.invoice_id');
		//$this->db->join('order ord','ord.order_id = ido.order_id');
		$this->db->join('plant_order po','ido.order_id=po.order_id');
		$this->db->join('plant pl','pl.plant_id=po.plant_id');
		$this->db->join('product p','ip.product_id=p.product_id');
		$this->db->where('p.loose_oil_id',$loose_oil_id);
		if($from_date !='')
		{
           $this->db->where('ii.received_date >=',$from_date);
		}
		if($to_date !='')
		{
           $this->db->where('ii.received_date <=',$to_date);
		}
		if($plant_id !='')
		{
           $this->db->where('po.plant_id ',$plant_id);
		}
		$res = $this->db->get();
		return $res->result_array();
	}

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

	public function get_active_distributor_list()
	{
		$this->db->select('d.distributor_id,d.agency_name,d.distributor_code');
    	$this->db->from('distributor d');
    	$this->db->join('user u','u.user_id = d.user_id');
    	$this->db->where('u.status',1);
    	$this->db->order_by('CAST(d.distributor_code as unsigned) ASC');
    	$res = $this->db->get();
    	return $res->result_array();
	}

	public function get_invoice_product_details($invoice_id)
	{
		//$plant_id = $this->session->userdata('ses_plant_id');
		$this->db->select('i.invoice_number, i.invoice_id, p.product_id as product_id, p.name as product, dop.product_price, dop.items_per_carton, idop.quantity, idop.items_per_carton as ipc, i.total');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('do d','d.do_id = ido.do_id ');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->where('i.invoice_id',$invoice_id);
		//$this->db->where('i.plant_id',$plant_id);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_invoice_products($invoice_id)
	{
		//$plant_id = $this->session->userdata('ses_plant_id');
		$this->db->select('p.name as product, p.product_id as product_id');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('do d','d.do_id = ido.do_id ');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->where('i.invoice_id',$invoice_id);
		//$this->db->where('i.plant_id',$plant_id);
		$this->db->group_by('dop.product_id');
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_oil_weight_by_product_id($product_id)
	{
		$this->db->select('oil_weight');
		$this->db->from('product');
		$this->db->where('product_id', $product_id);
		$res = $this->db->get();
		return $res->row_array();
	}

	public function get_product_price($product_id, $invoice_id)
	{
		$this->db->select('dop.product_price as product_price,idp.invoice_do_product_id');
		$this->db->from('invoice i');
		$this->db->join('invoice_do id', 'i.invoice_id = id.invoice_id');
		$this->db->join('invoice_do_product idp', 'id.invoice_do_id = idp.invoice_do_id');
		//$this->db->join('do_order do', 'id.do_id = do.do_id');
		$this->db->join('do_order_product dop', 'idp.do_ob_product_id = dop.do_ob_product_id');
		//$this->db->join('product p', 'idp.product_id = p.product_id');
		$this->db->where('i.invoice_id', $invoice_id);
		$this->db->where('dop.product_id', $product_id);
		$this->db->order_by('dop.product_price desc');
		$this->db->limit(1);
		//$this->db->group_by('idp.product_id');
		$res1 = $this->db->get();
		return $res1->row_array();
		//echo $res['product_price'];
	}
	 public function get_distributor_invoice_details($invoice_no)
	 {
	 	$this->db->select('inv.*,l.name as location_name,
			d.*,d.address as dist_address');
	 	$this->db->from('invoice inv');
	 	$this->db->join('invoice_do invdo','invdo.invoice_id = inv.invoice_id');
		$this->db->join('order o','o.order_id = invdo.order_id');
		$this->db->join('distributor_order di','di.order_id = o.order_id');
		$this->db->join('distributor d','di.distributor_id = d.distributor_id');
		$this->db->join('location l','d.location_id = l.location_id');
		$this->db->where('inv.invoice_number', $invoice_no);
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_plant_invoice_details($invoice_no)
	{   $this->db->select('inv.*,po.plant_id as receiving_plant_id');
		$this->db->from('invoice inv');
	 	$this->db->join('invoice_do invdo','invdo.invoice_id = inv.invoice_id');
		$this->db->join('order o','o.order_id = invdo.order_id');
		$this->db->join('plant_order po','po.order_id = o.order_id');
		$this->db->join('plant p','po.plant_id = p.plant_id');
		$this->db->where('inv.invoice_number', $invoice_no);
		$res=$this->db->get();
		return $res->result_array();
	}
	public function insurance_report($distributor_id,$invoice_no, $from_date, $to_date)
	{
		$this->db->select('i.*,i.invoice_id,inv.invoice_number,invoice_date,concat(d.distributor_code, " - (" ,d.agency_name,")") as agency_name,pla.short_name as plant_name');
		$this->db->from('insurance i');
		$this->db->join('invoice inv','inv.invoice_id = i.invoice_id');
		$this->db->join('invoice_do invdo','invdo.invoice_id = inv.invoice_id');
		$this->db->join('order o','o.order_id = invdo.order_id');
		$this->db->join('distributor_order di','di.order_id = o.order_id');
		$this->db->join('distributor d','di.distributor_id = d.distributor_id');
		$this->db->join('insurance_product ip', 'i.insurance_id = ip.insurance_id');
		$this->db->join('plant pla','pla.plant_id = inv.plant_id');
		$this->db->join('product p', 'p.product_id = ip.product_id');
		if($invoice_no!='')
		{
			$this->db->where('inv.invoice_number', $invoice_no);
		}
		if($from_date!='')
		{
			$this->db->where('i.received_date >=', $from_date);
		}
		
		if($to_date!='')
		{
			$this->db->where('i.received_date <=', $to_date);
		}
		if($distributor_id!='')
		{
			$this->db->where('d.distributor_id',$distributor_id);
		}
		$this->db->where('i.status',1);
		$res = $this->db->get();
		return $res->result_array();
	}
	public function plant_insurance_report($invoice_no)
	{
		$this->db->select('i.*,i.invoice_id,inv.invoice_number,invoice_date,po.plant_id as ordered_plant,pla.short_name as plant_name');
		$this->db->from('insurance i');
		$this->db->join('invoice inv','inv.invoice_id = i.invoice_id');
		$this->db->join('invoice_do invdo','invdo.invoice_id = inv.invoice_id');
		$this->db->join('order o','o.order_id = invdo.order_id');
		$this->db->join('plant_order po','po.order_id = o.order_id');
		$this->db->join('insurance_product ip', 'i.insurance_id = ip.insurance_id');
		$this->db->join('plant pla','pla.plant_id = inv.plant_id');
		$this->db->join('product p', 'p.product_id = ip.product_id');
		if($invoice_no!='')
		{
			$this->db->where('inv.invoice_number', $invoice_no);
		}
		$this->db->where('i.status',1);
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_insurance_product_result($insurance_id)
	{
		$this->db->select('i.*,ip.*,p.short_name as product_name');
		$this->db->from('insurance i');
		$this->db->join('insurance_product ip', 'i.insurance_id = ip.insurance_id');
		$this->db->join('product p', 'p.product_id = ip.product_id');
		$this->db->where('i.insurance_id',$insurance_id);
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_invoice_insurance_product_result($invoice_id)
	{
		$this->db->select('i.*,ip.*,p.short_name as product_name');
		$this->db->from('insurance i');
		$this->db->join('insurance_product ip', 'i.insurance_id = ip.insurance_id');
		$this->db->join('product p', 'p.product_id = ip.product_id');
		$this->db->where('i.invoice_id',$invoice_id);
		$res = $this->db->get();
		return $res->result_array();
	}
	public function check_invoice_number_distributor($invoice_no)
	{   
		$this->db->select('i.*');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('order ord','ord.order_id = ido.order_id');	
		$this->db->where('invoice_number',$invoice_no);
		$this->db->where('ord.type',1);
		$res=$this->db->get();
		return array($res->num_rows(),$res->row_array());
	}
	public function get_invoice_type($invoice_no)
	{
		$this->db->select('ord.type as invoice_type');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('order ord','ord.order_id = ido.order_id');	
		$this->db->where('ord.type',1);
		$this->db->where('invoice_number',$invoice_no);
		$res=$this->db->get();
		return $res->row_array();
	}
	public function get_invoice_type_plant($invoice_no)
	{
		$this->db->select('ord.type as invoice_type');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('order ord','ord.order_id = ido.order_id');	
		$this->db->where('ord.type',2);
		$this->db->where('invoice_number',$invoice_no);
		$res=$this->db->get();
		return $res->row_array();
	}
	public function check_invoice_number_plant($invoice_no)
	{   
		$this->db->select('i.*');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('order ord','ord.order_id = ido.order_id');	
		$this->db->where('invoice_number',$invoice_no);
		$this->db->where('ord.type',2);
		$res=$this->db->get();
		return array($res->num_rows(),$res->row_array());
	}
	public function check_invoice_number($invoice_no)
	{
		$this->db->from('invoice i');
		$this->db->join('insurance is','i.invoice_id=is.invoice_id');
		$this->db->where('i.invoice_number',$invoice_no);
		$res=$this->db->get();
		return $res->num_rows();
	}

	public function get_insurance_invoice_products($invoice_no)
	{
		$this->db->select('l.name as location_name,i.*,
			dist.*,dist.address as dist_address,p.name as product_name,p.short_name as short_name,idop.quantity as carton_qty,
			(idop.quantity*idop.items_per_carton) as packets,(idop.quantity*idop.items_per_carton*p.oil_weight) as qty_in_kg,
			(idop.quantity*ppw.weight) as pm_weight,
			(dop.product_price) as rate,idop.items_per_carton,idop.quantity,						
			(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('product_pm_weight ppw','p.product_id = ppw.product_id','left');
		
		$this->db->join('do d','d.do_id = ido.do_id ');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
	
		$this->db->join('distributor_order dio','dio.order_id=do.order_id');
		$this->db->join('distributor dist','dist.distributor_id=dio.distributor_id');

		$this->db->join('location l','dist.location_id = l.location_id');
		
		$this->db->where('i.invoice_number',$invoice_no);
		/*if($block_id!=1)
		{
		$this->db->where('d.lifting_point',get_plant_id());
		}*/
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_plant_insurance_invoice_products($invoice_no)
	{
		//$block_id = $this->session->userdata('block_id');
		
		$this->db->select('i.*,po.plant_id as receiving_plant_id,p.name as product_name,p.short_name as short_name,idop.quantity as carton_qty,
			(idop.quantity*idop.items_per_carton) as packets,(idop.quantity*idop.items_per_carton*p.oil_weight) as qty_in_kg,
			(idop.quantity*ppw.weight) as pm_weight,
			(dop.product_price) as rate,idop.items_per_carton,idop.quantity,						
			(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('product_pm_weight ppw','p.product_id = ppw.product_id','left');	
		$this->db->join('do d','d.do_id = ido.do_id');
		$this->db->join('do_order do','do.do_id = d.do_id');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->join('plant_order po','po.order_id = do.order_id');
		/*if($block_id!=1)
		{
		$this->db->where('d.lifting_point',get_plant_id());
		}*/
		$this->db->where('i.invoice_number',$invoice_no);
		$res = $this->db->get();
		return $res->result_array();
	}
	
	// 19 MAY 17
	public function get_invoice_generated_loose_oils($from_date,$to_date,$distributor_id,$plant_id)
	{
		$this->db->select('p.loose_oil_id,lo.name');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('order ord','ord.order_id = ido.order_id');
		if($plant_id !='' && $distributor_id !='')
		{
			 $this->db->join('plant_order po','ido.order_id=po.order_id','left');
			 $this->db->join('distributor_order dio','ido.order_id=dio.order_id','left');
		}
		elseif($plant_id!=''&&$distributor_id =='')
		{
			$this->db->join('plant_order po','ido.order_id=po.order_id','left');
		}
		elseif($plant_id==''&&$distributor_id!='')
		{
			$this->db->join('distributor_order dio','ido.order_id=dio.order_id','left');
		}
		$this->db->join('product p','idop.product_id=p.product_id');
		$this->db->join('loose_oil lo','p.loose_oil_id=lo.loose_oil_id');
		if($from_date !='')
		{
           $this->db->where('i.invoice_date >=',$from_date);
		}
		if($to_date !='')
		{
           $this->db->where('i.invoice_date <=',$to_date);
		}
		if($distributor_id !='')
		{
           $this->db->where('dio.distributor_id =',$distributor_id);
		}
		if($plant_id !='')
		{
           $this->db->where('po.plant_id =',$plant_id);
		}
		$this->db->group_by('p.loose_oil_id');
		$res=$this->db->get();
		return $res->result_array();
	}

public function get_dist_invoice_products($loose_oil_id,$from_date,$to_date,$distributor_id,$plant_id)
	{
		$this->db->select('dist.distributor_code,dop.product_price,dist.agency_name,i.invoice_date,i.plant_id as invoice_plant,p.short_name as product_name,i.invoice_number,(idop.quantity*idop.items_per_carton*p.oil_weight) as quantity, (idop.quantity*idop.items_per_carton*dop.product_price) as value');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('do_order_product dop','idop.do_ob_product_id=dop.do_ob_product_id');
		$this->db->join('order ord','ord.order_id = ido.order_id');
		$this->db->join('distributor_order dio','ido.order_id=dio.order_id');
		$this->db->join('distributor dist','dist.distributor_id=dio.distributor_id');
		$this->db->join('product p','idop.product_id=p.product_id');
		$this->db->where('p.loose_oil_id',$loose_oil_id);
		if($from_date !='')
		{
           $this->db->where('i.invoice_date >=',$from_date);
		}
		if($to_date !='')
		{
           $this->db->where('i.invoice_date <=',$to_date);
		}
		if($distributor_id !='')
		{
           $this->db->where('dio.distributor_id =',$distributor_id);
		}
		$this->db->order_by('dist.distributor_id');
		$res = $this->db->get();
		return $res->result_array();
	}

public function get_plant_invoice_products($loose_oil_id,$from_date,$to_date,$distributor_id,$plant_id)
	{
		$this->db->select('pl.plant_id,dop.product_price,pl.name as plant_name,i.invoice_date,i.plant_id as invoice_plant,p.short_name as product_name,i.invoice_number,(idop.quantity*idop.items_per_carton*p.oil_weight) as quantity, (idop.quantity*idop.items_per_carton*dop.product_price) as value');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('do_order_product dop','idop.do_ob_product_id=dop.do_ob_product_id');
		
		//$this->db->join('order ord','ord.order_id = ido.order_id');
		$this->db->join('plant_order po','ido.order_id=po.order_id');
		$this->db->join('plant pl','pl.plant_id=po.plant_id');
		$this->db->join('product p','idop.product_id=p.product_id');
		$this->db->where('p.loose_oil_id',$loose_oil_id);
		if($from_date !='')
		{
           $this->db->where('i.invoice_date >=',$from_date);
		}
		if($to_date !='')
		{
           $this->db->where('i.invoice_date <=',$to_date);
		}
		if($plant_id !='')
		{
           $this->db->where('po.plant_id =',$plant_id);
		}
		$res = $this->db->get();
		return $res->result_array();
	}
}