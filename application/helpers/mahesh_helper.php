<?php //Mahesh Helper


/*
** check is current page is authorized for the logged in user role
** @params: role_id(int), page_name(string)
** @return: true/flase(boolean)
** Created by: Mahesh 7th Dec 2016 03:50 pm, Updated by: --
*/
function is_authorized_page($block_designation_id,$page_name)
{
	$exclude_pages = array('home','unauthorized_request');
	if(in_array($page_name, $exclude_pages))
	{
		return true;
	}
	if($block_designation_id!=''&&$page_name!='')
	{
		$ci = & get_instance();
		$ci->db->from('block_designation_page bdp');
		$ci->db->join('page p','p.page_id = bdp.page_id','inner');
		$ci->db->where('bdp.block_designation_id',$block_designation_id);
		$ci->db->where('p.name',$page_name);
		$res = $ci->db->get();
		return ($res->num_rows()>0)?true:false;
	}
}

function get_logged_user_id()
{
	$ci = & get_instance();
	return $ci->session->userdata('user_id');
}

function get_logged_user_role()
{
	$ci = & get_instance();
	return $ci->session->userdata('block_id');
}

function is_user_logged_in()
{
	$ci = & get_instance();
	return ($ci->session->userdata('employee_id')>0)?TRUE:FALSE;

}

function get_financial_year()
{
	if(date('m')<4)
	{
		$start_date = (date('Y')-1).'-4-1';
		$end_date = date('Y').'-3-31';
	}
	else
	{
		$start_date = date('Y').'-4-1';
		$end_date = (date('Y')+1).'-3-31';
	}
	$fa = array('start_date'=>$start_date,'end_date'=>$end_date);
	return $fa;
}

function get_current_serial_number($data)
{
	$financial_year = get_financial_year();
	$ci = & get_instance();
	$ci->db->select('max('.$data['value'].') as csno');
	$ci->db->from($data['table']);
	$ci->db->where('DATE('.$data['where'].')>=',$financial_year['start_date']);
	$ci->db->where('DATE('.$data['where'].')<=',$financial_year['end_date']);
	if(isset($data['where2']))
	{
		$ci->db->where($data['where2']);
	}
	$res = $ci->db->get();
	if($res->num_rows()>0)
	{
		$row = $res->row_array();
		return $row['csno']+1;
	}
	else
	{
		return 1;
	}
}

/*
 * To insert / update into database
 * params: name(string),value(int),section(string)
 * return
 * created by  mahesh on 24th feb 2017
*/
function set_preference($name,$value,$section)
{
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->where('section',$section);
	$ci->db->where('name',$name);
	$ci->db->from('preference');
	$query = $ci->db->get(); 
	$num = $query->num_rows();
	
	if($num>0){
		$data=array(
					'value'	=>  $value,
					'modified_by' => $ci->session->userdata('user_id'),
					'modified_time' => date('Y-m-d H:i:s') 
					);
		$where=array(
					'section' =>$section,
					'name' =>$name,
					);
		
		$res=$ci->db->update('preference', $data,$where);			
	}
	else
	{
		$data=array(
					'name'=>$name,
					'value'=>$value,
					'section'=>$section,
					'created_by' => $ci->session->userdata('user_id'),
					'created_time' => date('Y-m-d H:i:s')
					);
		$res=$ci->db->insert('preference', $data); 
		
	}
	return $res;
}
	/*
 * To get data from database
 * params: name(string),section(string)
 * return: value(int)
 * created by mahesh on 24th feb 2017
*/
	
function get_preference($name,$section)
{
	
	$ci=& get_instance();
	$ci->load->database();
	$ci->db->where('section',$section);
	$ci->db->where('name',$name);
	$ci->db->from('preference');
	$query=$ci->db->get();
	$num = $query->num_rows();
	
	if($num>0)
	{
		$value = $query->row_array();
		return $value['value'];
	}
	
}

/*
 * Get Distributor order booking number
 * params: distributor_id(int)
 * return: value(int)
 * created by mahesh on 2nd Mar 2017 11:23 PM
*/
	
function get_distributor_ob_number()
{

	$financial_year = get_financial_year();
	$ci = & get_instance();
	$ci->db->select('max(o.order_number) as csno');
	$ci->db->from('order o');
	//$ci->db->join('distributor_order do','o.order_id = do.order_id');
	$ci->db->where('DATE(o.created_time)>=',$financial_year['start_date']);
	$ci->db->where('DATE(o.created_time)<=',$financial_year['end_date']);
	//$ci->db->where('do.distributor_id',$distributor_id);
	$res = $ci->db->get();
	if($res->num_rows()>0)
	{
		$row = $res->row_array();
		return $row['csno']+1;
	}
	else
	{
		return 1;
	}
	
}

// 5th Mar 2017 07:08 PM
function get_ob_product_do_qty($order_id,$product_id)
{
	if($order_id!=''&&$product_id!='')
	{
		$ci = & get_instance();
		$ci->db->select('sum(dop.quantity) as tot_do_qty');
	    $ci->db->from('do_order do');
	    $ci->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id','left');
	    $ci->db->where('do.order_id',$order_id);
	    $ci->db->where('dop.product_id',$product_id);
        $res = $ci->db->get();
        if($res->num_rows()>0)
        {
        	$row = $res->row_array();
        	return ($row['tot_do_qty']>0)?$row['tot_do_qty']:0;
        }
		
	}
	return 0;
}

// 5th Mar 2017 07:08 PM
function get_do_product_invoice_qty($order_id,$do_id,$product_id)
{
	if($order_id!=''&&$product_id!='')
	{
		$ci = & get_instance();
		$ci->db->select('sum(idop.quantity) as tot_do_qty');
	    $ci->db->from('invoice_do ido');
	    $ci->db->join('invoice_do_product idop','idop.invoice_do_id = ido.invoice_do_id','left');
	    $ci->db->where('ido.order_id',$order_id);
	    $ci->db->where('ido.do_id',$do_id);
	    $ci->db->where('idop.product_id',$product_id);
        $res = $ci->db->get();
        if($res->num_rows()>0)
        {
        	$row = $res->row_array();
        	return ($row['tot_do_qty']>0)?$row['tot_do_qty']:0;
        }
		
	}
	return 0;
}

//24th Mar 2017 08:02 am
function get_distributor_do_number()
{
	return get_current_serial_number(array('value'=>'do_number','table'=>'do','where'=>'created_time'));
}

//24th Mar 2017 08:07 am
function get_plant_do_number()
{
	return get_current_serial_number(array('value'=>'do_number','table'=>'do','where'=>'created_time'));
}

/*
 * Get Plant Invoice Number
 * 
 * return: value(int)
 * created by mahesh on 24th Mar 2017 8:18 am
*/
	
function get_plant_invoice_number()
{

	$financial_year = get_financial_year();
	$ci = & get_instance();
	$ci->db->select('max(i.invoice_number) as csno');
	$ci->db->from('invoice i');
	//$ci->db->join('distributor_order do','o.order_id = do.order_id');
	$ci->db->where('DATE(i.created_time)>=',$financial_year['start_date']);
	$ci->db->where('DATE(i.created_time)<=',$financial_year['end_date']);
	//$ci->db->where('do.distributor_id',$distributor_id);
	$res = $ci->db->get();
	//echo $ci->db->last_query();
	if($res->num_rows()>0)
	{
		$row = $res->row_array();
		if($row['csno']>0)
		return $row['csno']+1;
	}
	
	return 1; 
	
}

/*
 * Get Distributor Invoice Number
 * 
 * return: value(int)
 * created by mahesh on 24th Mar 2017 8:18 am
*/
	
function get_distributor_invoice_number()
{

	$financial_year = get_financial_year();
	$ci = & get_instance();
	$ci->db->select('max(i.invoice_number) as csno');
	$ci->db->from('invoice i');
	//$ci->db->join('distributor_order do','o.order_id = do.order_id');
	$ci->db->where('DATE(i.created_time)>=',$financial_year['start_date']);
	$ci->db->where('DATE(i.created_time)<=',$financial_year['end_date']);
	//$ci->db->where('do.distributor_id',$distributor_id);
	$res = $ci->db->get();
	if($res->num_rows()>0)
	{
		$row = $res->row_array();
		if($row['csno']>0)
		return $row['csno']+1;
	}
	
	return 1; 
	
}

/*
 * Get Prodcut price at plant on particular date
 * params: product_id(int),price_type(int), date(date), plant_id(int)
 * return: value(int)
 * created by mahesh on 26th Mar 2017 3:25 pm
*/
function get_product_price($product_id,$price_type,$date,$plant_id)
{
	if($product_id!=''&& $price_type != '' && $date !='' && $plant_id !='')
	{
		$ci = & get_instance();
		$query=	'SELECT * FROM product_price p WHERE p.start_date= (select max(p1.start_date) as start_date from product_price p1 where p1.product_id=p.product_id and p1.plant_id=p.plant_id and p1.price_type_id=p.price_type_id and p1.start_date <= "'.$date.'") and p.plant_id = "'.$plant_id.'" and p.price_type_id = "'.$price_type.'" and p.product_id = '.$product_id.' ORDER BY p.product_price_id DESC LIMIT 1';
	    $res=$ci->db->query($query);
	    //echo $ci->db->last_query();
	    if($res->num_rows()>0)
	    {
	    	$row = $res->row_array();
	    	return $row['value'];
		}
		return 0;

	}
}

// 8th Apr 2017 11:47 PM
function get_sd_amount($distributor_id,$transaction_date)
{
	$ci = & get_instance();
	$ci->db->select('sd_amount');
	/*$ci->db->from('distributor');
	$ci->db->where('distributor_id',$distributor_id);*/
	$ci->db->from('dist_sd_amount_history');
	$ci->db->where('distributor_id',$distributor_id);
	$where = '((start_date <= "'.$transaction_date.'" and end_date > "'.$transaction_date.'") OR (start_date <= "'.$transaction_date.'" AND end_date is null))';
	$ci->db->where($where);
	$ci->db->order_by('sd_amount_h_id','DESC');
	$ci->db->limit(1);
	$res = $ci->db->get();
	if($res->num_rows()>0)
	{
		$row = $res->row_array();
		return ($row['sd_amount']!='')?$row['sd_amount']:0;
	}
	return 0;
}

// 8th Apr 2017 11:47 PM
function get_bg_amount($distributor_id,$transaction_date)
{
	$ci = & get_instance();
	$ci->db->select('sum(bg_amount) as bg_amount_total');
	$ci->db->from('bank_guarantee');
	$ci->db->where('distributor_id',$distributor_id);
	$ci->db->where('end_date>=',$transaction_date);
	$res = $ci->db->get();
	if($res->num_rows()>0)
	{
		$row = $res->row_array();
		return ($row['bg_amount_total']!='')?$row['bg_amount_total']:0;
	}
	return 0;
}

function format_date($date,$format='d-m-Y')
{
	$timestamp = strtotime($date);
	return date($format,$timestamp);
}

// 21 apr 2017 3:03 pm
function get_pm_unit($pm_id)
{
	$ci = & get_instance();
	$ci->db->select('pu.name as unit');
	$ci->db->from('packing_material pm');
	$ci->db->join('packing_material_category pmc','pm.pm_category_id = pmc.pm_category_id');
	$ci->db->join('pm_unit pu','pmc.pm_unit = pu.pm_unit');
	$res = $ci->db->get();
	if($res->num_rows()>0)
	{
		$row = $res->row_array();
		return $row['unit'];
	}
}

function get_sess_data($param)
{
	$ci = & get_instance();
	return $ci->session->userdata($param);
}

function get_no_of_days_between_two_dates($date1,$date2)
{
	$dt1 = strtotime($date1); // or your date as well
	$dt2 = strtotime($date2);
	$datediff = $dt1 - $dt2;
	return floor($datediff / (60 * 60 * 24));
}

function check_distributor_bg_expired($distributor_id)
{
	$ci = & get_instance();
    $ci->db->from('bank_guarantee bg');
    $ci->db->where('bg.distributor_id',$distributor_id);
    $ci->db->where('bg.status',1);
    $ci->db->where('bg.end_date<',date('Y-m-d')); 
    $res = $ci->db->get();
    return ($res->num_rows()>0)?TRUE:FALSE;
}

function get_going_to_expire_days()
{
	return get_preference("going_to_expire_days","general_settings");
}

function price_change_alert_text($plant_id='')
{
	$ci = & get_instance();
	//$date=date('Y-m-d',strtotime('-1 days'));
	$query=	'SELECT GROUP_CONCAT(distinct(pt.name)) as price_types, p.start_date FROM product_price p JOIN distributor_price_type pt  ON p.price_type_id = pt.price_type_id WHERE p.start_date= (select max(p1.start_date) as start_date from product_price p1 where p1.product_id=p.product_id and p1.plant_id=p.plant_id and p1.price_type_id=p.price_type_id and (p1.start_date = CURDATE())) ';
	if($plant_id!='')
		$query .=  'and p.plant_id = "'.$plant_id.'" ';
	//$query .= ' ORDER BY p.product_price_id DESC LIMIT 1';
    $res=$ci->db->query($query);
    //echo $ci->db->last_query();
    if($res->num_rows()>0)
    {
    	$row = $res->row_array();
    	if($row['price_types']!=''&&$row['start_date']!='')
    		return $row['price_types'].' Price has been changed on '.format_date($row['start_date']);
	}

}

function get_po_status_text($po_status)
{
	$status_text = '';
	switch($po_status)
	{
		case 1:
			$status_text = 'Pending';
		break;
		case 2:
			$status_text = 'Pending';
		break;
		case 3:
			$status_text = 'Closed';
		break;
		case 10:
			$status_text = 'Rejected';
		break;
	}
	return $status_text;
}

// 16 may 17
function get_invoice_ob_type($invoice_id)
{
	if($invoice_id)
	{
		$ci = & get_instance();
		$ci->db->select('o.ob_type_id,d.do_distributor_id');
		$ci->db->from('invoice i');
		$ci->db->join('invoice_do id','id.invoice_id = i.invoice_id');
		$ci->db->join('do d','d.do_id = id.do_id');
		$ci->db->join('order o','o.order_id = id.order_id');
		$ci->db->where('i.invoice_id',$invoice_id);
		$res = $ci->db->get();
		if($res->num_rows()>0)
		{
			$row = $res->row_array();
			return $row;
		}
	}
}

// Get distributor details by id
function get_distributor_details_by_id($distributor_id)
{
	if($distributor_id)
	{
		$ci = & get_instance();
		$ci->db->from('distributor');
		$ci->db->where('distributor_id',$distributor_id);
		$res = $ci->db->get();
		if($res->num_rows()>0){
			return $res->row_array();
		}
		
	}
}

//22 may 2017
function TrimTrailingZeroes($nbr) {
    return strpos($nbr,'.')!==false ? rtrim(rtrim($nbr,'0'),'.') : $nbr;
}