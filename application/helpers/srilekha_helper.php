<?php //Srilekha Helper
//Created by: Srilekha 21st Feb 2017 11:28 am,
function get_per_carton_items()
{
	return 16;
}
/*Free Sample Types
Author:Srilekha
Time: 12.07PM 21-02-2017 */
function get_freesample_type()
{
	$freesample_type=array(1=>'Carton',2=>'Pouch');
	return $freesample_type;
}
/*Reporting Managaer Details 
Author:Srilekha
Time: 12.17PM 02-03-2017 */
function reporting_manager($parent_id)
{
	$ci = & get_instance();
	$ci->db->select('name as reporting');
	$ci->db->from('designation');
	$ci->db->where('designation_id',$parent_id);
	$res = $ci->db->get();
	$result =$res->result_array();
	$manager=$result[0]['reporting'];
	return $manager;
}
/*Get Product Price Type*/
function get_product_price_type()
{
	return 2;
}	
/* Film Category
Author:Srilekha
Time: 01.26PM 16-03-2017 */
function get_film_id()
{
	return 1;
}
function get_film_order_by()
{

	$ci = & get_instance();
	$film_id = get_film_id();
	$ci->db->select('*');
	$ci->db->from('packing_material');
	$ci->db->where('pm_category_id',$film_id);
	$ci->db->order_by('name');
	$res = $ci->db->get();
	return $res->result_array();
}