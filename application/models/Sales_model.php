<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sales_model extends CI_Model 
{
	public function sales_total_num_rows($search_params)
	{
		$this->db->select('cs.*, cp.name as paymode, csc.name as category');
		$this->db->from('counter_sale cs');
		$this->db->join('cs_pay_mode cp', 'cp.cs_pay_mode_id = cs.cs_pay_mode_id');
		$this->db->join('cs_category csc', 'csc.cs_category_id = cs.cs_category_id');
		if($search_params['customer_name']!='')
			$this->db->like('cs.customer_name',$search_params['customer_name']);
		if($search_params['date']!='')
			$this->db->where('cs.on_date',$search_params['date']);
		if($search_params['billno']!='')
			$this->db->where('cs.bill_number',$search_params['billno']);
		if($search_params['category']!='')
			$this->db->where('csc.cs_category_id',$search_params['category']);
		$res = $this->db->get();
		return $res->num_rows();
	}
	public function sales_results($current_offset, $per_page, $search_params)
	{
		$this->db->select('cs.*, cs.status as cs_status, cp.name as paymode, csc.name as category');
		$this->db->from('counter_sale cs');
		$this->db->join('cs_pay_mode cp', 'cp.cs_pay_mode_id = cs.cs_pay_mode_id');
		$this->db->join('cs_category csc', 'csc.cs_category_id = cs.cs_category_id');
		if($search_params['customer_name']!='')
			$this->db->like('cs.customer_name',$search_params['customer_name']);
		if($search_params['date']!='')
			$this->db->where('cs.on_date',$search_params['date']);
		if($search_params['billno']!='')
			$this->db->where('cs.bill_number',$search_params['billno']);
		if($search_params['category']!='')
			$this->db->where('csc.cs_category_id',$search_params['category']);
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function view_sales_list($counter_sale_id)
	{
		$this->db->select('cs.*, csp.*, p.name as product, cp.cs_pay_mode_id, cp.name as pay_mode, csc.name as category, b.name as bank');
		$this->db->from('counter_sale cs');
		$this->db->join('cs_product csp', 'csp.counter_sale_id = cs.counter_sale_id');
		$this->db->join('cs_pay_mode cp', 'cp.cs_pay_mode_id = cs.cs_pay_mode_id');
		$this->db->join('cs_category csc', 'csc.cs_category_id = cs.cs_category_id');
		$this->db->join('product p', 'p.product_id = csp.product_id');
		$this->db->join('bank b', 'b.bank_id = cs.bank_id','left');
		$this->db->where('cs.counter_sale_id', $counter_sale_id);
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_raithu_bazar_price($product_id, $distributor_type)
	{
		$query=	'SELECT * FROM product_price p WHERE p.start_date= (select max(p1.start_date) as start_date from product_price p1 where p1.product_id=p.product_id and p1.price_type_id=p.price_type_id and p1.start_date <= "'.date('Y-m-d').'"  and p.price_type_id = "'.$distributor_type.'") and p.product_id="'.$product_id.'"';
		$res1 = $this->db->query($query);
		$res = $res1->result_array();
		$count = $res1->num_rows();
		$qry_data='';
        if($count>0)
		{
			foreach($res as $row1)
			{  
				$qry_data.=$row1['value'];
			}
		} 
		else 
		{
			$qry_data.= "0";
		}
		echo $qry_data;
	}

	public function get_counter_stock($product_id, $plant_id, $items)
	{
		$this->db->select("pcp.quantity as counter_qty");
		$this->db->from('plant_product pp');
		$this->db->join('plant_counter pc', 'pp.plant_id = pc.plant_id');
		$this->db->join('plant_counter_product pcp', 'pcp.product_id = pp.product_id');
		$this->db->where('pp.product_id', $product_id);
		$this->db->where('pp.plant_id', $plant_id);
		$res1 = $this->db->get();
		$res = $res1->result_array();
		$count = $res1->num_rows();
		$qry_data='';
        if($count>0)
		{
			foreach($res as $row1)
			{  
				$avail_qty = $row1['counter_qty']*$items;
				$qry_data.=$avail_qty;
			}
		} 
		else 
		{
			$qry_data.="0";
		}
		echo $qry_data;
	}

/*Sales Details for scrolling 
Author:Srilekha
Time: 04.06PM 21-03-2017 */
	public function get_sales_details($plant_id)
	{
		$date=date('Y-m-d');
		$this->db->select('sum((idop.quantity*idop.items_per_carton*p.oil_weight)/1000) as tot_sales');
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
		$this->db->join('order ord','ord.order_id = ido.order_id');	
		$this->db->join('location l','dist.location_id = l.location_id');
		$this->db->where('ord.type',1);
		$this->db->where('i.plant_id',$plant_id);
		$this->db->where('i.invoice_date',$date);
		$this->db->group_by('i.plant_id');
		$res = $this->db->get();
		if($res->num_rows()>0)
		{
			$value = $res->row_array();
			return $value['tot_sales'];

		}
		else
		{
			return $value = '0.000';
		}

	}
	
/*PLant Block List
Author:Srilekha
Time: 04.15PM 21-03-2017 */
	public function get_plant_block()
	{
		$block_id=array(2,3,4);
		$this->db->select('p.*');
		$this->db->from('plant p');
		$this->db->join('plant_block pb','pb.plant_id=p.plant_id');
		$this->db->where_in('pb.block_id',$block_id);
		$res = $this->db->get();
		return $res->result_array();
	}
	/*Daily Sales Report
Author:Srilekha
Time: 12.48PM 23-03-2017 */
	public function get_sales_daily_report($from_date,$plant_id)
	{
		//$plant_id=$this->session->userdata('ses_plant_id');
		$this->db->select('p.loose_oil_id as loose_oil_id,sum(idop.quantity*idop.items_per_carton*p.oil_weight) as qty_in_kg,
			sum(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('product_pm_weight ppw','p.product_id = ppw.product_id','left');
		$this->db->join('do d','d.do_id = ido.do_id ');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('order ord','ord.order_id = ido.order_id');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->join('distributor_order dio','dio.order_id=do.order_id');
		$this->db->join('distributor dist','dist.distributor_id=dio.distributor_id');
			
		$this->db->join('location l','dist.location_id = l.location_id');
		$this->db->where('d.lifting_point',$plant_id);	
		$this->db->where('i.invoice_date',$from_date);
		$this->db->where('i.plant_id',$plant_id);
		$this->db->where('ord.type',1);
		$this->db->group_by('p.loose_oil_id');
		$res = $this->db->get();
		return $res->result_array();

	}
	
	public function get_sales_daily_product_report($from_date,$plant_id)
	{
		$this->db->select('p.product_id as product_id,sum(idop.quantity) as qty,sum(idop.quantity *idop.items_per_carton) as pouches,sum(idop.quantity*idop.items_per_carton*p.oil_weight) as qty_in_kg,
			sum(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('do d','d.do_id = ido.do_id');
		$this->db->join('user u','d.created_by = u.user_id','left');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('order ord','ord.order_id = ido.order_id');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->where('i.invoice_date',$from_date);
		$this->db->where('i.plant_id',$plant_id);
		$this->db->where('ord.type',1);
		$this->db->where('d.lifting_point',$plant_id);
		$this->db->group_by('idop.product_id');
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_sales_monthly_product_report($from_date,$to_date,$plant_id)
	{
		$this->db->select('p.product_id as product_id,sum(idop.quantity) as qty,sum(idop.quantity *idop.items_per_carton) as pouches,sum(idop.quantity*idop.items_per_carton*p.oil_weight) as qty_in_kg,
			sum(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('do d','d.do_id = ido.do_id');
		$this->db->join('user u','d.created_by = u.user_id','left');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->join('order ord','ord.order_id = ido.order_id');
		$this->db->where('i.invoice_date >=',$from_date);
		$this->db->where('i.invoice_date <=',$to_date);
		$this->db->where('i.plant_id',$plant_id);
		$this->db->where('ord.type',1);
		$this->db->where('d.lifting_point',$plant_id);
		$this->db->group_by('idop.product_id');
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_exec_sales_daily_product_report($from_date,$exec_id)
	{
		$this->db->select('p.product_id as product_id,sum(idop.quantity) as qty,sum(idop.quantity *idop.items_per_carton) as pouches,sum(idop.quantity*idop.items_per_carton*p.oil_weight) as qty_in_kg,
			sum(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('product_pm_weight ppw','p.product_id = ppw.product_id','left');
		$this->db->join('do d','d.do_id = ido.do_id ');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->join('order ord','ord.order_id = ido.order_id');
		$this->db->join('distributor_order dio','dio.order_id=do.order_id');
		$this->db->join('distributor dist','dist.distributor_id=dio.distributor_id');
		$this->db->join('executive e','dist.executive_id=e.executive_id');	
		$this->db->join('location l','dist.location_id = l.location_id');
		$this->db->where('ord.type',1);
		$this->db->where('dist.executive_id',$exec_id);	
		$this->db->where('i.invoice_date',$from_date);
		//$this->db->where('i.plant_id',$plant_id);
		$this->db->group_by('p.product_id');
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_exec_sales_daily_report($from_date,$exec_id,$invoice_id)
	{
		$this->db->select('i.invoice_date as invoice_date,dist.agency_name as agency_name,dist.distributor_code as dist_code,dist.distributor_id as distributor_id,i.invoice_number  as invoice_number ,sum(idop.quantity*idop.items_per_carton*p.oil_weight) as qty_in_kg,
			sum(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount,p.product_id as product_id,p.short_name as short_name,sum(idop.quantity) as qty,sum(idop.quantity *idop.items_per_carton) as pouches');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('product_pm_weight ppw','p.product_id = ppw.product_id','left');
		$this->db->join('do d','d.do_id = ido.do_id ');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->join('order ord','ord.order_id = ido.order_id');
		$this->db->join('distributor_order dio','dio.order_id=do.order_id');
		$this->db->join('distributor dist','dist.distributor_id=dio.distributor_id');
		$this->db->join('executive e','dist.executive_id=e.executive_id');	
		$this->db->join('location l','dist.location_id = l.location_id');
		$this->db->where('ord.type',1);
		$this->db->where('dist.executive_id',$exec_id);	
		$this->db->where('i.invoice_date',$from_date);
		$this->db->where('i.invoice_id',$invoice_id);
		$this->db->group_by('p.product_id');
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_executive_invoices($from_date,$exec_id)
	{
		$this->db->select('i.invoice_number,i.invoice_id');
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
		$this->db->join('executive e','dist.executive_id=e.executive_id');	
		$this->db->join('location l','dist.location_id = l.location_id');
		$this->db->where('dist.executive_id',$exec_id);	
		$this->db->where('i.invoice_date',$from_date);
		//$this->db->where('i.plant_id',$plant_id);
		$this->db->group_by('i.invoice_id');
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_dist_sales_daily_report($from_date,$dist_id)
	{
		$this->db->select('i.invoice_number  as invoice_number,i.invoice_date ,sum(idop.quantity*idop.items_per_carton*p.oil_weight) as qty_in_kg,
			sum(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('product_pm_weight ppw','p.product_id = ppw.product_id','left');
		$this->db->join('do d','d.do_id = ido.do_id ');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->join('order ord','ord.order_id = ido.order_id');
		$this->db->join('distributor_order dio','dio.order_id=do.order_id');
		$this->db->join('distributor dist','dist.distributor_id=dio.distributor_id');
		$this->db->join('location l','dist.location_id = l.location_id');
		$this->db->where('ord.type',1);
		$this->db->where('dist.distributor_id',$dist_id);	
		$this->db->where('i.invoice_date',$from_date);
		//$this->db->where('i.plant_id',$plant_id);
		$this->db->group_by('i.invoice_number');
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_exec_sales_monthly_report($from_date,$to_date,$exec_id)
	{
		$this->db->select('dist.agency_name as agency_name,dist.distributor_code as dist_code,dist.distributor_id as distributor_id,GROUP_CONCAT(DISTINCT(i.invoice_number) SEPARATOR ",")  as invoice_number ,sum(idop.quantity*idop.items_per_carton*p.oil_weight) as qty_in_kg,
			sum(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('product_pm_weight ppw','p.product_id = ppw.product_id','left');
		$this->db->join('do d','d.do_id = ido.do_id ');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->join('order ord','ord.order_id = ido.order_id');
		$this->db->join('distributor_order dio','dio.order_id=do.order_id');
		$this->db->join('distributor dist','dist.distributor_id=dio.distributor_id');
		$this->db->join('executive e','dist.executive_id=e.executive_id');	
		$this->db->join('location l','dist.location_id = l.location_id');
                $this->db->where('ord.type',1);
		$this->db->where('dist.executive_id',$exec_id);	
		$this->db->where('i.invoice_date >=',$from_date);
		$this->db->where('i.invoice_date <=',$to_date);
		//$this->db->where('i.plant_id',$plant_id);
		$this->db->group_by('dist.distributor_id');
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_dist_sales_monthly_report($from_date,$to_date,$dist_id)
	{
		$this->db->select('i.invoice_number  as invoice_number,i.invoice_date ,sum(idop.quantity*idop.items_per_carton*p.oil_weight) as qty_in_kg,
			sum(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('product_pm_weight ppw','p.product_id = ppw.product_id','left');
		$this->db->join('do d','d.do_id = ido.do_id ');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->join('order ord','ord.order_id = ido.order_id');
		$this->db->join('distributor_order dio','dio.order_id=do.order_id');
		$this->db->join('distributor dist','dist.distributor_id=dio.distributor_id');
		$this->db->join('location l','dist.location_id = l.location_id');
		$this->db->where('dist.distributor_id',$dist_id);	
		$this->db->where('i.invoice_date >=',$from_date);
		$this->db->where('i.invoice_date <=',$to_date);
		$this->db->where('ord.type',1);
		//$this->db->where('i.plant_id',$plant_id);
		$this->db->group_by('i.invoice_number');
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_exec_sales_monthly_product_report($from_date,$to_date,$exec_id)
	{
		$plant_id=$this->session->userdata('ses_plant_id');
		$this->db->select('p.product_id as product_id,sum(idop.quantity) as qty,sum(idop.quantity *idop.items_per_carton) as pouches,sum(idop.quantity*idop.items_per_carton*p.oil_weight) as qty_in_kg,
			sum(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('product_pm_weight ppw','p.product_id = ppw.product_id','left');
		$this->db->join('do d','d.do_id = ido.do_id ');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->join('order ord','ord.order_id = ido.order_id');
		$this->db->join('distributor_order dio','dio.order_id=do.order_id');
		$this->db->join('distributor dist','dist.distributor_id=dio.distributor_id');
		$this->db->join('executive e','dist.executive_id=e.executive_id');	
		$this->db->join('location l','dist.location_id = l.location_id');
		$this->db->where('ord.type',1);
		$this->db->where('dist.executive_id',$exec_id);	
		$this->db->where('i.invoice_date >=',$from_date);
		$this->db->where('i.invoice_date <=',$to_date);
		//$this->db->where('i.plant_id',$plant_id);
		$this->db->group_by('p.product_id');
		$res = $this->db->get();
		return $res->result_array();
	}
	
	public function get_previous_sales_daily_report($prev_date,$plant_id,$fin_start_date)
	{
		$this->db->select('p.loose_oil_id as loose_oil_id,sum(idop.quantity*idop.items_per_carton*p.oil_weight) as pre_qty_in_kg,
			sum(idop.quantity*idop.items_per_carton*(dop.product_price)) as pre_amount');
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
		$this->db->where('d.lifting_point',$plant_id);
		$this->db->where('i.invoice_date>=',$fin_start_date);	
		$this->db->where('i.invoice_date<=',$prev_date);
		$this->db->where('i.plant_id',$plant_id);
		//$this->db->group_by('p.loose_oil_id');
		$res = $this->db->get();
		return $res->row_array();
	}
	
	public function get_oils()
	{
		$this->db->select('loose_oil_id,name');
		$this->db->from('loose_oil');
		$this->db->order_by('rank');
		$this->db->where('status !=',3);
		$res=$this->db->get();
		return $res->result_array();
	}

/*Monthly Sales Report results
Author:Srilekha
Time: 03.38PM 23-03-2017 */
	public function monthly_reports_results($from_date,$to_date,$plant_id)
	{
		$this->db->select('p.loose_oil_id as loose_oil_id,sum(idop.quantity*idop.items_per_carton*p.oil_weight) as qty_in_kg,
			sum(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('product_pm_weight ppw','p.product_id = ppw.product_id','left');
		$this->db->join('do d','d.do_id = ido.do_id ');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->join('order ord','ord.order_id = ido.order_id');
		$this->db->join('distributor_order dio','dio.order_id=do.order_id');
		$this->db->join('distributor dist','dist.distributor_id=dio.distributor_id');
		$this->db->join('location l','dist.location_id = l.location_id');
		$this->db->where('d.lifting_point',$plant_id);	
		$this->db->where('i.invoice_date >=',$from_date);
		$this->db->where('i.invoice_date <=',$to_date);
		$this->db->where('ord.type',1);
		$this->db->where('i.plant_id',$plant_id);
		$this->db->group_by('p.loose_oil_id');
		$res = $this->db->get();
		return $res->result_array();
	}
/*District Sales Report results
Author:Srilekha
Time: 03.41PM 24-03-2017 */
	public function district_reports_results($from_date,$to_date,$location_id)
	{
		$plant_id=$this->session->userdata('ses_plant_id');
		$this->db->select('i.invoice_number,l.name,d.agency_name,d.distributor_code,i.invoice_date,sum((op.unit_price+op.add_price)*idp.quantity*idp.items_per_carton) as tot_price,(sum(idp.quantity*idp.items_per_carton*p.oil_weight)/1000) as tot_weight');
		$this->db->from('invoice i');
		$this->db->join('user u','u.user_id=i.created_by');
		$this->db->join('invoice_do id','id.invoice_id=i.invoice_id');
		$this->db->join('do_order doo','doo.do_id=id.do_id');
		$this->db->join('order o','o.order_id=doo.order_id');
		$this->db->join('order_product op','op.order_id=doo.order_id');
		$this->db->join('invoice_do_product idp','idp.invoice_do_id=id.invoice_do_id');
		$this->db->join('product p','p.product_id=idp.product_id');
		$this->db->join('loose_oil lo','lo.loose_oil_id=p.loose_oil_id');
		$this->db->join('distributor_order dio','dio.order_id=o.order_id');
		$this->db->join('distributor d','d.distributor_id=dio.distributor_id');
		$this->db->join('location l','l.location_id=d.location_id');
		$this->db->join('location l1','l1.location_id = l.parent_id');
		$this->db->where('date(i.invoice_date)>=',$from_date);
		$this->db->where('date(i.invoice_date)<=',$to_date);
		$where='(l1.location_id='.$location_id.' or l1.parent_id='.$location_id.')';
		$this->db->where($where);
		/*$this->db->or_where('l.location_id',$location_id);
		$this->db->or_where('l1.parent_id',$location_id);*/
		//$this->db->where('u.plant_id',$plant_id);
		$this->db->where('o.type',1);
		$this->db->group_by('p.loose_oil_id');
		$this->db->order_by('i.invoice_id DESC');
		$res = $this->db->get();
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
	public function get_units()
	{
		$this->db->select('p.*');
		$this->db->from('plant p');
		$this->db->join('plant_block pb','p.plant_id=pb.plant_id');
		$in=array(2,3,4);
		$this->db->where_in('pb.block_id',$in);
		$res=$this->db->get();
		return $res->result_array();
	}
	
	public function get_cs_daily_report($from_date,$counter_id)
	{
		$this->db->select('sum(csp.quantity*p.oil_weight) as cs_qty_in_kg,sum(amount) as cs_amount,p.loose_oil_id');
		$this->db->from('counter_sale cs');
		$this->db->join('cs_product csp ','cs.counter_sale_id=csp.counter_sale_id');
		$this->db->join('product p','csp.product_id=p.product_id');
		$this->db->where('cs.on_date',$from_date);
		$this->db->where('cs.counter_id',$counter_id);
		$this->db->group_by('p.loose_oil_id');
		$res = $this->db->get();
		return $res->result_array();
	}
	
	public function get_distributor()
	{
		$this->db->select('d.distributor_id ,d.distributor_code,d.agency_name');
		$this->db->from('distributor d');
		$this->db->join('user u','d.user_id=u.user_id');
		$this->db->where('u.status',1);
		$this->db->order_by('CAST(d.distributor_code as unsigned) ASC');
		$res=$this->db->get();
		return $res->result_array();
	}
	
	public function get_previous_csdsr($prev_date,$counter_id,$fin_start_date)
	{
		$this->db->select('sum(csp.quantity*p.oil_weight) as cs_qty_in_kg,sum(amount) as cs_amount,p.loose_oil_id');
		$this->db->from('counter_sale cs');
		$this->db->join('cs_product csp ','cs.counter_sale_id=csp.counter_sale_id');
		$this->db->join('product p','csp.product_id=p.product_id');
		$this->db->where('cs.on_date>=',$fin_start_date);	
		$this->db->where('cs.on_date<=',$prev_date);
		$this->db->where('cs.counter_id',$counter_id);
		//$this->db->group_by('p.loose_oil_id');
		$res = $this->db->get();
		return $res->row_array();
	}
	
	public function get_all_units_inc_ops()
	{
		$this->db->select('p.plant_id as plant_id,p.name as plant_name');
		$this->db->from('plant p');
		$this->db->join('plant_block pb','p.plant_id=pb.plant_id');
		$in=array(2,3,4);
		$this->db->where_in('pb.block_id',$in);
		$res=$this->db->get();
		return $res->result_array();
	}
	public function get_md_daily_sales_report($start_date)
	{
		//$plant_id=$this->session->userdata('ses_plant_id');
		$this->db->select('i.plant_id as plant_id,sum((idop.quantity*idop.items_per_carton*p.oil_weight)/1000) as mt_in_kg,
			sum(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount');
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
		$this->db->join('order ord','ord.order_id = ido.order_id');	
		$this->db->join('location l','dist.location_id = l.location_id');
		$this->db->where('ord.type',1);
		$this->db->where('i.invoice_date',$start_date);
		$this->db->group_by('i.plant_id');
		$res = $this->db->get();
		return $res->result_array();

	}
	
	public function get_previous_sales_daily_report_md($month_first_day,$start_date)
	{
		$this->db->select('sum((idop.quantity*idop.items_per_carton*p.oil_weight)/1000) as pre_mt_in_kg,
			sum(idop.quantity*idop.items_per_carton*(dop.product_price)) as pre_amount');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('product_pm_weight ppw','p.product_id = ppw.product_id','left');
		$this->db->join('do d','d.do_id = ido.do_id ');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('order ord','ord.order_id = ido.order_id');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->join('distributor_order dio','dio.order_id=do.order_id');
		$this->db->join('distributor dist','dist.distributor_id=dio.distributor_id');
			
		$this->db->join('location l','dist.location_id = l.location_id');
		$this->db->where('i.invoice_date>=',$month_first_day);	
		$this->db->where('i.invoice_date<',$start_date);
		$this->db->where('ord.type',1);
		$res = $this->db->get();
		return $res->row_array();
	}
	public function get_exec_md_sales_daily_report($start_date)
	{
		$this->db->select('sum((idop.quantity*idop.items_per_carton*p.oil_weight)/1000) as mt_in_kg,e.executive_id as executive_id,p.loose_oil_id as loose_oil_id');
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
		$this->db->join('executive e','dist.executive_id=e.executive_id');	
		$this->db->join('location l','dist.location_id = l.location_id');
		$this->db->where('i.invoice_date',$start_date);
		$this->db->group_by('p.loose_oil_id,e.executive_id');
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_md_monthly_sales_report($start_date,$end_date)
	{
		//$plant_id=$this->session->userdata('ses_plant_id');
		$this->db->select('i.plant_id as plant_id,sum((idop.quantity*idop.items_per_carton*p.oil_weight)/1000) as mt_in_kg,
			sum(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount');
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
		$this->db->join('order ord','ord.order_id = ido.order_id');	
		$this->db->join('location l','dist.location_id = l.location_id');
		$this->db->where('ord.type',1);
		$this->db->where('i.invoice_date >=',$start_date);
		$this->db->where('i.invoice_date <=',$end_date);
		$this->db->group_by('i.plant_id');
		$res = $this->db->get();
		return $res->result_array();

	}
	
	public function get_exec_md_sales_monthly_report($start_date,$end_date)
	{
		$this->db->select('sum((idop.quantity*idop.items_per_carton*p.oil_weight)/1000) as mt_in_kg,e.executive_id as executive_id,p.loose_oil_id as loose_oil_id');
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
		$this->db->join('executive e','dist.executive_id=e.executive_id');	
		$this->db->join('location l','dist.location_id = l.location_id');
		$this->db->where('i.invoice_date >=',$start_date);
		$this->db->where('i.invoice_date <=',$end_date);
		$this->db->group_by('p.loose_oil_id,e.executive_id');
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_yearly_oil_report($fin_start_date,$fin_end_date)
	{
		$this->db->select('p.loose_oil_id as loose_oil_id,sum((idop.quantity*idop.items_per_carton*p.oil_weight)/1000) as qty_in_kg,
			sum(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount,MONTH(i.invoice_date) as invoice_month');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('product_pm_weight ppw','p.product_id = ppw.product_id','left');
		$this->db->join('do d','d.do_id = ido.do_id ');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('order ord','ord.order_id = ido.order_id');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->join('distributor_order dio','dio.order_id=do.order_id');
		$this->db->join('distributor dist','dist.distributor_id=dio.distributor_id');
		$this->db->join('location l','dist.location_id = l.location_id');
		$this->db->where('ord.type',1);
		$this->db->where('i.invoice_date >=',$fin_start_date);
		$this->db->where('i.invoice_date <=',$fin_end_date);
		//$this->db->where('i.plant_id',$plant_id);
		$this->db->group_by('p.loose_oil_id,MONTH(i.invoice_date)');
		$res = $this->db->get();
		return $res->result_array();
	}
	
	public function get_exec_wise_invoice_sales($from_date,$to_date,$exec_id)
	{
		$this->db->select('dist.agency_name as agency_name,dist.distributor_code as dist_code,dist.distributor_id as distributor_id,i.invoice_number  as invoice_number,i.invoice_date ,sum(idop.quantity*idop.items_per_carton*p.oil_weight) as qty_in_kg,
			sum(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount,l.name as location_name');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('do d','d.do_id = ido.do_id ');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->join('order ord','ord.order_id = ido.order_id');
		$this->db->join('distributor_order dio','dio.order_id=do.order_id');
		$this->db->join('distributor dist','dist.distributor_id=dio.distributor_id');
		$this->db->join('executive e','dist.executive_id=e.executive_id');	
		$this->db->join('location l','dist.location_id = l.location_id');
                $this->db->where('ord.type',1);
		$this->db->where('dist.executive_id',$exec_id);	
		$this->db->where('i.invoice_date >=',$from_date);
		$this->db->where('i.invoice_date <=',$to_date);
		//$this->db->where('i.plant_id',$plant_id);
		$this->db->group_by('i.invoice_id');
		$res = $this->db->get();
		return $res->result_array();
	}
	public function get_all_units_monthly_product_report($from_date,$to_date,$plant_id)
	{
		$this->db->select('p.product_id as product_id,sum(idop.quantity) as qty,sum(idop.quantity *idop.items_per_carton) as pouches,sum(idop.quantity*idop.items_per_carton*p.oil_weight) as qty_in_kg,
			sum(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('do d','d.do_id = ido.do_id');
		$this->db->join('user u','d.created_by = u.user_id','left');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->join('order ord','ord.order_id = ido.order_id');
		$this->db->where('i.invoice_date >=',$from_date);
		$this->db->where('i.invoice_date <=',$to_date);
		$this->db->where('ord.type',1);
		if($plant_id !='')
		{
			$this->db->where('i.plant_id',$plant_id);
			$this->db->where('d.lifting_point',$plant_id);
		}
		$this->db->group_by('idop.product_id');
		$res = $this->db->get();
		return $res->result_array();
	}
	
	
	public function get_dist_sales_report($from_date,$to_date)
	{
		$this->db->select('dist.distributor_id,dist.agency_name,dist.distributor_code,l.name as location_name,sum(idop.quantity*idop.items_per_carton*p.oil_weight)/1000 as qty_in_kg,e.name as executive_name,
			sum(idop.quantity*idop.items_per_carton*(dop.product_price)) as amount');
		$this->db->from('invoice i');
		$this->db->join('invoice_do ido','i.invoice_id = ido.invoice_id');
		$this->db->join('invoice_do_product idop','ido.invoice_do_id = idop.invoice_do_id');
		$this->db->join('product p','idop.product_id = p.product_id');
		$this->db->join('do d','d.do_id = ido.do_id ');
		$this->db->join('do_order do','do.do_id = d.do_id ');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idop.do_ob_product_id');
		$this->db->join('order ord','ord.order_id = ido.order_id');
		$this->db->join('distributor_order dio','dio.order_id=do.order_id');
		$this->db->join('distributor dist','dist.distributor_id=dio.distributor_id');
		$this->db->join('executive e','dist.executive_id=e.executive_id');
		$this->db->join('location l','dist.location_id = l.location_id');
		$this->db->where('i.invoice_date >=',$from_date);
		$this->db->where('i.invoice_date <=',$to_date);
		$this->db->where('ord.type',1);
		$this->db->group_by('dist.distributor_id');
		$this->db->order_by('qty_in_kg desc');
		$res = $this->db->get();
		return $res->result_array();
	}
	
}