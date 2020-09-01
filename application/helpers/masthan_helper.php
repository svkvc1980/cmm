<?php //Masthan Helper

/*
 * GET auto Generated test number
 * created by mastan on 13/2/2017
*/
function get_test_number()
{
	return get_current_serial_number(array('value'=>'test_number','table'=>'po_oil_lab_test','where'=>'created_time'));
}

/*
 * GET auto Generated bill number for counter sales
 * created by mastan on 13/2/2017
*/
function get_bill_number()
{
	return get_current_serial_number(array('value'=>'bill_number','table'=>'counter_sale','where'=>'created_time'));
}
function get_test_pm_number()
{
	return get_current_serial_number(array('value'=>'test_number','table'=>'po_pm_lab_test','where'=>'created_time'));
}

/*
* Getting option value by key for oil lab test
*/
function get_oil_test_option_value_by_key($key,$test_id)
{
	if($key!='')
	{
		$ci = & get_instance();
		$ci->db->select('value');
		$ci->db->from('test_option');
		$ci->db->where('test_id',$test_id);
		$ci->db->where('key',$key);
		$res = $ci->db->get();
		if($res->num_rows()>0)
		{
			$row = $res->row_array();
			return $row['value'];
		}
	}
}

/*
* Getting option value by key for packing material lab test
*/
function get_pm_test_option_value_by_key($key,$test_id)
{
	if($key!='')
	{
		$ci = & get_instance();
		$ci->db->select('value');
		$ci->db->from('pm_test_option');
		$ci->db->where('pm_test_id',$test_id);
		$ci->db->where('key',$key);
		$res = $ci->db->get();
		if($res->num_rows()>0)
		{
			$row = $res->row_array();
			return $row['value'];
		}
	}
}

// get plant id in counter sales
function get_plant_counter_sale_id()
{
	$ci = & get_instance();
	$plant_id = $ci->session->userdata('ses_plant_id');
	$ci->db->select('counter_id');
	$ci->db->from('plant_counter');
	$ci->db->where('plant_id',$plant_id);
	$res = $ci->db->get();
	if($res->num_rows()>0)
	{
		$row = $res->row_array();
		return $row['counter_id'];
	}
}