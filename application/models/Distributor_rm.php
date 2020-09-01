<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Distributor_rm extends CI_Model {

	/*Getting Distributor Results num of rows
	Author:Srilekha
	Time: 12.50PM 10-03-2017 */
	public function distreport_total_num_rows($search_params)
	{		
		$this->db->select('d.*,dt.name as type_name,e.name as exe_name,l.name as location_name');
		$this->db->from('distributor d');
		$this->db->join('distributor_type dt','dt.type_id=d.type_id');
		$this->db->join('executive e','e.executive_id=d.executive_id','left');
		$this->db->join('location l','l.location_id=d.location_id');
		
		if($search_params['dist_type']!='')
			$this->db->where('d.type_id',$search_params['dist_type']);
		if($search_params['dist_code']!='')
			$this->db->where('d.distributor_code',$search_params['dist_code']);
		if($search_params['dist_name']!='')
			$this->db->like('d.agency_name',$search_params['dist_name']);
		if($search_params['executive']!='')
			$this->db->where('d.executive_id',$search_params['executive']);
		$res = $this->db->get();
		return $res->num_rows();
	}

	/*Getting Distributor Results Results
	Author:Srilekha
	Time: 01.03PM 10-03-2017 */
	public function distreport_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('d.*,dt.name as type_name,e.name as exe_name,l.name as location_name, 

			(SELECT SUM(bg_amount) FROM bank_guarantee bg WHERE bg.distributor_id = d.distributor_id AND bg.end_date >= CURDATE())
			AS bg_amt
			');
		$this->db->from('distributor d');
		$this->db->join('distributor_type dt','dt.type_id=d.type_id');
		$this->db->join('executive e','e.executive_id=d.executive_id','left');
		$this->db->join('location l','l.location_id=d.location_id');
		if($search_params['dist_type']!='')
			$this->db->where('d.type_id',$search_params['dist_type']);
		if($search_params['dist_code']!='')
			$this->db->where('d.distributor_code',$search_params['dist_code']);
		if($search_params['dist_name']!='')
			$this->db->like('d.agency_name',$search_params['dist_name']);
		if($search_params['executive']!='')
			$this->db->where('d.executive_id',$search_params['executive']);
		$this->db->order_by('CAST(d.distributor_code AS unsigned) ASC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
	
	public function distreport_details($search_params)
	{
		$this->db->select('d.*,dt.name as type_name,e.name as exe_name,l.name as location_name, 

			(SELECT SUM(bg_amount) FROM bank_guarantee bg WHERE bg.distributor_id = d.distributor_id AND bg.end_date >= CURDATE())
			AS bg_amt
			');
		$this->db->from('distributor d');
		$this->db->join('distributor_type dt','dt.type_id=d.type_id');
		$this->db->join('executive e','e.executive_id=d.executive_id','left');
		$this->db->join('location l','l.location_id=d.location_id');
		if($search_params['dist_type']!='')
			$this->db->where('d.type_id',$search_params['dist_type']);
		if($search_params['dist_code']!='')
			$this->db->where('d.distributor_code',$search_params['dist_code']);
		if($search_params['dist_name']!='')
			$this->db->like('d.agency_name',$search_params['dist_name']);
		if($search_params['executive']!='')
			$this->db->where('d.executive_id',$search_params['executive']);
		$this->db->order_by('CAST(d.distributor_code AS unsigned) ASC');
		$res = $this->db->get();		
		return $res->result_array();
	}
	/*View Distributor Reports List details
Author:Srilekha
Time: 01.37PM 20-03-2017 */
	public function view_distributor_details($distributor_id)
	{
		$this->db->select('d.*,dt.name as type_name,l.name as location_name');
		$this->db->from('distributor d');
		$this->db->join('distributor_type dt','dt.type_id=d.type_id');
		$this->db->join('location l','l.location_id=d.location_id');
		$this->db->where('d.distributor_id',$distributor_id);
		$res = $this->db->get();		
		return $res->result_array();

	}
/*View Distributor Bank List details
Author:Srilekha
Time: 01.37PM 20-03-2017 */
	public function distributor_bank_details($distributor_id)
	{
		$this->db->select('bg.*,b.name as bank_name');
		$this->db->from('bank_guarantee bg');
		$this->db->join('bank b','b.bank_id=bg.bank_id');
		$this->db->where('bg.distributor_id',$distributor_id);
		$this->db->where('bg.status',1);
		$res = $this->db->get();		
		return $res->result_array();

	}

	//Mahesh 5th Apr 2017 04:02 PM
	public function get_distributors()
	{
		$this->db->select();
		$this->db->from('distributor');
		$this->db->order_by('CAST(distributor_code AS unsigned) ASC');
		$res = $this->db->get();		
		return $res->result_array();
	}

	// Mahesh 6th Apr 2017 08:04 AM
	public function get_ledger_dates($search_params)
	{
		$qry = 'SELECT payment_date as transaction_date FROM distributor_payment WHERE distributor_id = '.$search_params['distributor_id'].' AND payment_date >= "'.$search_params['from_date'].'" AND payment_date <= "'.$search_params['to_date'].'" 
				UNION
				(SELECT d.do_date as transaction_date FROM do d 
					JOIN do_order do ON do.do_id = d.do_id
					JOIN distributor_order disto ON disto.order_id = do.order_id
					WHERE  disto.distributor_id = '.$search_params['distributor_id'].' AND d.do_date >= "'.$search_params['from_date'].'" AND d.do_date <= "'.$search_params['to_date'].'" 
				)
				UNION
				(SELECT on_date as transaction_date FROM distributor_credit_debit_note 
					WHERE  distributor_id = '.$search_params['distributor_id'].' AND on_date >= "'.$search_params['from_date'].'" AND on_date <= "'.$search_params['to_date'].'" 
				)
				UNION
				(SELECT penalty_date as transaction_date FROM dist_ob_penalty 
					WHERE  distributor_id = '.$search_params['distributor_id'].' AND penalty_date >= "'.$search_params['from_date'].'" AND penalty_date <= "'.$search_params['to_date'].'"   AND total_amount > 0 
				)
				';
		$qry.= ' UNION
				 (SELECT i.invoice_date as transaction_date FROM invoice i 
					JOIN invoice_do id ON i.invoice_id = id.invoice_id
					JOIN distributor_order disto ON disto.order_id = id.order_id
					WHERE  disto.distributor_id = '.$search_params['distributor_id'].' AND i.invoice_date >= "'.$search_params['from_date'].'" AND i.invoice_date <= "'.$search_params['to_date'].'"
				)';
		$qry .= ' ORDER BY transaction_date ASC';
		$res = $this->db->query($qry);
		//echo $this->db->last_query();
		return $res->result_array();
	}

	//Mahesh 6th Apr 2017 08:55 AM
	public function get_dd_receipts($search_params)
	{
		$this->db->select('*');
		$this->db->from('distributor_payment');
		$this->db->where('distributor_id',$search_params['distributor_id']);
		$this->db->where('payment_date>=',$search_params['from_date']);
		$this->db->where('payment_date<=',$search_params['to_date']);
		$this->db->where('status<=',2); // Pending, Approved only
		$res = $this->db->get();
		//echo $this->db->last_query().'<br>';		
		return $res->result_array();
	}

	//Mahesh 6th Apr 2017 08:55 AM
	public function get_do_results($search_params)
	{
		$this->db->select('d.*,sum(dop.quantity*dop.items_per_carton*dop.product_price) as do_amt');
		$this->db->from('do d');
		$this->db->join('do_order do','do.do_id = d.do_id');
		$this->db->join('distributor_order disto','disto.order_id = do.order_id');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id');
		$this->db->where('disto.distributor_id',$search_params['distributor_id']);
		$this->db->where('d.do_date>=',$search_params['from_date']);
		$this->db->where('d.do_date<=',$search_params['to_date']);
		$this->db->group_by('d.do_id');
		$res = $this->db->get();
		//echo $this->db->last_query();		
		return $res->result_array();
	}

	//Mahesh 6th Apr 2017 08:55 AM
	public function get_credit_debit_notes($search_params)
	{
		$this->db->select('cdn.*,p.name as purpose');
		$this->db->from('distributor_credit_debit_note cdn');
		$this->db->join('credit_debit_purpose p','p.purpose_id = cdn.purpose_id','left');
		$this->db->where('cdn.distributor_id',$search_params['distributor_id']);
		$this->db->where('cdn.on_date>=',$search_params['from_date']);
		$this->db->where('cdn.on_date<=',$search_params['to_date']);
		$res = $this->db->get();		
		return $res->result_array();
	}

	//Mahesh 6th Apr 2017 08:55 AM
	public function get_penalities($search_params)
	{
		$this->db->select('sum(total_amount) as penality_amount,penalty_date as penality_date');
		$this->db->from('dist_ob_penalty');
		$this->db->where('distributor_id',$search_params['distributor_id']);
		$this->db->where('penalty_date>=',$search_params['from_date']);
		$this->db->where('penalty_date<=',$search_params['to_date']);
		$this->db->group_by('penalty_date');
		$res = $this->db->get();		
		return $res->result_array();
	}

	//Mahesh 6th Apr 2017 08:55 AM
	public function get_invoices($search_params)
	{
		$this->db->select('i.*, SUM(idp.quantity*idp.items_per_carton*dop.product_price) as invoice_amt');
		$this->db->from('invoice i');
		$this->db->join('invoice_do id','id.invoice_id = i.invoice_id');
		$this->db->join('invoice_do_product idp','id.invoice_do_id = idp.invoice_do_id');
		$this->db->join('do_order_product dop','dop.do_ob_product_id = idp.do_ob_product_id');
		$this->db->join('distributor_order disto','disto.order_id = id.order_id');
		$this->db->where('disto.distributor_id',$search_params['distributor_id']);
		$this->db->where('i.invoice_date>=',$search_params['from_date']);
		$this->db->where('i.invoice_date<=',$search_params['to_date']);
		$this->db->group_by('i.invoice_id');
		$res = $this->db->get();
		return $res->result_array();
	}

	//Mahesh 8th Apr 2017 10:45 PM
	public function dd_receipts_sum($search_params)
	{
		$this->db->select('sum(amount) as dd_amount_total');
		$this->db->from('distributor_payment');
		$this->db->where('distributor_id',$search_params['distributor_id']);
		$this->db->where('payment_date>=',$search_params['from_date']);
		$this->db->where('payment_date<=',$search_params['to_date']);
		$this->db->where('status<=',2); // Pending, Approved only
		$this->db->group_by('distributor_id');
		$res = $this->db->get();		
		if($res->num_rows()>0)
		{
			$row = $res->row_array();
			return ($row['dd_amount_total']!='')?$row['dd_amount_total']:0;
		}		
		return 0;
	}

	//Mahesh 8th Apr 2017 10:45 PM
	public function do_sum($search_params)
	{
		$this->db->select('sum(dop.quantity*dop.items_per_carton*dop.product_price) as do_amt_total');
		$this->db->from('do d');
		$this->db->join('do_order do','do.do_id = d.do_id');
		$this->db->join('distributor_order disto','disto.order_id = do.order_id');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id');
		$this->db->where('disto.distributor_id',$search_params['distributor_id']);
		$this->db->where('d.do_date>=',$search_params['from_date']);
		$this->db->where('d.do_date<=',$search_params['to_date']);
		$this->db->group_by('disto.distributor_id');
		$res = $this->db->get();
		//echo $this->db->last_query();		
		if($res->num_rows()>0)
		{
			$row = $res->row_array();
			return ($row['do_amt_total']!='')?$row['do_amt_total']:0;
		}		
		return 0;
	}

	//Mahesh 8th Apr 2017 10:45 PM
	public function credit_note_sum($search_params)
	{
		$this->db->select('sum(cdn.amount) as credit_amount_total');
		$this->db->from('distributor_credit_debit_note cdn');
		$this->db->join('credit_debit_purpose p','p.purpose_id = cdn.purpose_id');
		$this->db->where('cdn.distributor_id',$search_params['distributor_id']);
		$this->db->where('cdn.on_date>=',$search_params['from_date']);
		$this->db->where('cdn.on_date<=',$search_params['to_date']);
		$this->db->where('cdn.note_type',1);
		$res = $this->db->get();		
		if($res->num_rows()>0)
		{
			$row = $res->row_array();
			return ($row['credit_amount_total']!='')?$row['credit_amount_total']:0;
		}		
		return 0;
	}

	//Mahesh 8th Apr 2017 10:45 PM
	public function debit_note_sum($search_params)
	{
		$this->db->select('sum(cdn.amount) as debit_amount_total');
		$this->db->from('distributor_credit_debit_note cdn');
		$this->db->join('credit_debit_purpose p','p.purpose_id = cdn.purpose_id');
		$this->db->where('cdn.distributor_id',$search_params['distributor_id']);
		$this->db->where('cdn.on_date>=',$search_params['from_date']);
		$this->db->where('cdn.on_date<=',$search_params['to_date']);
		$this->db->where('cdn.note_type',2);
		$res = $this->db->get();		
		if($res->num_rows()>0)
		{
			$row = $res->row_array();
			return ($row['debit_amount_total']!='')?$row['debit_amount_total']:0;
		}		
		return 0;
	}

	//Mahesh 8th Apr 2017 10:45 PM
	public function penalities_sum($search_params)
	{
		$this->db->select('sum(total_amount) as penality_amount_total');
		$this->db->from('dist_ob_penalty');
		$this->db->where('distributor_id',$search_params['distributor_id']);
		$this->db->where('penalty_date>=',$search_params['from_date']);
		$this->db->where('penalty_date<=',$search_params['to_date']);
		$this->db->group_by('distributor_id');
		$res = $this->db->get();
		if($res->num_rows()>0)
		{
			$row = $res->row_array();
			return ($row['penality_amount_total']!='')?$row['penality_amount_total']:0;
		}		
		return 0;
	}

	//Mahesh 22nd Apr 2017 05:15 PM
	public function current_pending_do_amount($distributor_id)
	{
		$this->db->select('sum(dop.pending_qty*dop.items_per_carton*dop.product_price) as do_amt_total');
		$this->db->from('do d');
		$this->db->join('do_order do','do.do_id = d.do_id');
		$this->db->join('distributor_order disto','disto.order_id = do.order_id');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id');
		$this->db->where('disto.distributor_id',$distributor_id);
		$this->db->where('dop.status<=',2);
		$this->db->group_by('disto.distributor_id');
		$res = $this->db->get();
		//echo $this->db->last_query();		
		if($res->num_rows()>0)
		{
			$row = $res->row_array();
			return ($row['do_amt_total']!='')?$row['do_amt_total']:0;
		}		
		return 0;
	}

	//Mahesh 22nd Apr 2017 03:51 PM
	public function invoice_sum($search_params)
	{
		$this->db->select('sum(idp.quantity*idp.items_per_carton*dop.product_price) as invoice_amount_total');
		$this->db->from('invoice i');
		$this->db->join('invoice_do id','id.invoice_id = i.invoice_id');
		$this->db->join('invoice_do_product idp','id.invoice_do_id = idp.invoice_do_id');
		$this->db->join('do_order_product dop','dop.do_ob_product_id = idp.do_ob_product_id');
		$this->db->join('distributor_order disto','disto.order_id = id.order_id');
		$this->db->where('disto.distributor_id',$search_params['distributor_id']);
		$this->db->where('i.invoice_date>=',$search_params['from_date']);
		$this->db->where('i.invoice_date<=',date('Y-m-d'));
		$this->db->group_by('disto.distributor_id');
		$res = $this->db->get();
		if($res->num_rows()>0)
		{
			$row = $res->row_array();
			return ($row['invoice_amount_total']!='')?$row['invoice_amount_total']:0;
		}		
		return 0;
	}

	//Mahesh 22nd Apr 2017 05:15 PM
	public function pending_do_sum($search_params)
	{
		$this->db->select('sum(dop.pending_qty*dop.items_per_carton*dop.product_price) as do_amt_total');
		$this->db->from('do d');
		$this->db->join('do_order do','do.do_id = d.do_id');
		$this->db->join('distributor_order disto','disto.order_id = do.order_id');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id');
		$this->db->where('disto.distributor_id',$search_params['distributor_id']);
		/*$where = '(d.do_date < "'.$search_params['from_date'].'" AND (dop.status<=2 OR (dop.status=3 AND DATE(dop.modified_time)> "'.$search_params['from_date'].'" AND DATE(dop.modified_time)<= "'.$search_params['to_date'].'") ) )';
		$this->db->where($where);*/
		$this->db->where('d.do_date<',$search_params['from_date']);
		$this->db->where('dop.status<=',2);
		$this->db->group_by('disto.distributor_id');
		$res = $this->db->get();
		//echo $this->db->last_query();		
		if($res->num_rows()>0)
		{
			$row = $res->row_array();
			return ($row['do_amt_total']!='')?$row['do_amt_total']:0;
		}		
		return 0;
	}

	//Mahesh 22nd Apr 2017 05:15 PM
	public function pending_do_invoice_sum($search_params)
	{
		$this->db->select('sum(idp.quantity*idp.items_per_carton*dop.product_price) as pendng_do_invoice_amt_total');
		$this->db->from('do d');
		$this->db->join('do_order do','do.do_id = d.do_id');
		$this->db->join('distributor_order disto','disto.order_id = do.order_id');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id');

		$this->db->join('invoice_do_product idp','idp.do_ob_product_id = dop.do_ob_product_id');
		$this->db->join('invoice_do id','id.invoice_do_id = idp.invoice_do_id');
		$this->db->join('invoice i','id.invoice_id = i.invoice_id');
		$this->db->where('disto.distributor_id',$search_params['distributor_id']);
		$where = '(d.do_date < "'.$search_params['from_date'].'" AND (dop.status<=2 OR (dop.status=3 AND DATE(dop.modified_time)>= "'.$search_params['from_date'].'" ) ) )';
		$this->db->where($where);
		$this->db->where('i.invoice_date >=',$search_params['from_date']);
		/*$this->db->where('i.invoice_date >=',$search_params['from_date']);
		$this->db->where('i.invoice_date <=',$search_params['to_date']);*/
		$this->db->group_by('disto.distributor_id');
		$res = $this->db->get();
		//echo $this->db->last_query();		
		if($res->num_rows()>0)
		{
			$row = $res->row_array();
			return ($row['pendng_do_invoice_amt_total']!='')?$row['pendng_do_invoice_amt_total']:0;
		}		
		return 0;
	}

	//Mahesh 03 Jun 2017 06:42 PM
	public function pending_do_amount1_on_date($distributor_id,$on_date)
	{
		$this->db->select('sum(dop.pending_qty*dop.items_per_carton*dop.product_price) as do_amt_total');
		$this->db->from('do d');
		$this->db->join('do_order do','do.do_id = d.do_id');
		$this->db->join('distributor_order disto','disto.order_id = do.order_id');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id');
		$this->db->where('disto.distributor_id',$distributor_id);
		$this->db->where('dop.status<=',2);
		$this->db->where('d.do_date<',$on_date);
		$this->db->group_by('disto.distributor_id');
		$res = $this->db->get();
		//echo $this->db->last_query();		
		if($res->num_rows()>0)
		{
			$row = $res->row_array();
			return ($row['do_amt_total']!='')?$row['do_amt_total']:0;
		}		
		return 0;
	}

	//Mahesh 03 Jun 2017 06:42 PM
	public function pending_do_amount2_on_date($distributor_id,$on_date)
	{
		$st_ar = array(2,3);
		$this->db->select('sum(idp.quantity*idp.items_per_carton*dop.product_price) as do_amt_total');
		$this->db->from('do d');
		$this->db->join('do_order do','do.do_id = d.do_id');
		$this->db->join('distributor_order disto','disto.order_id = do.order_id');
		$this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id');
		$this->db->join('invoice_do_product idp','dop.do_ob_product_id = idp.do_ob_product_id');
		$this->db->join('invoice_do id','idp.invoice_do_id = id.invoice_do_id');
		$this->db->join('invoice i','id.invoice_id = i.invoice_id');
		$this->db->where('disto.distributor_id',$distributor_id);
		$this->db->where_in('dop.status',$st_ar);
		$this->db->where('d.do_date<',$on_date);
		//$this->db->where('DATE(dop.modified_time)>=',$on_date);
		$this->db->where('i.invoice_date>=',$on_date);
		$this->db->group_by('disto.distributor_id');
		$res = $this->db->get();
		//echo $this->db->last_query();		
		if($res->num_rows()>0)
		{
			$row = $res->row_array();
			return ($row['do_amt_total']!='')?$row['do_amt_total']:0;
		}		
		return 0;
	}

	//Mahesh 03 Jun 2017 06:42 PM
	public function pending_do_amount_on_date($search_params)
	{
		$amt1 = $this->pending_do_amount1_on_date($search_params['distributor_id'],$search_params['from_date']);
		$str = $this->db->last_query().'<br>'; 
		$amt2 = $this->pending_do_amount2_on_date($search_params['distributor_id'],$search_params['from_date']);
		$str .=$this->db->last_query().'<br>'; 
		$str .= $amt1.'-->'.$amt2; 
		//echo $str ; exit;
		return ($amt1+$amt2);
	}
}