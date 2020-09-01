<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Stock_m extends CI_Model {

/*Getting Stock num of rows
Author:Srilekha
Time: 04.30PM 02-03-2017 */
	public function stock_total_num_rows($search_params)
	{
		$plant_id = $this->session->userdata('ses_plant_id');	
		$this->db->select('pm.*,pl.quantity as quantity,pc.name as category,pu.name as units');
		$this->db->from('packing_material pm');
		$this->db->join('plant_pm pl','pl.pm_id=pm.pm_id');
		$this->db->join('packing_material_category pc','pc.pm_category_id=pm.pm_category_id');
		$this->db->join('pm_unit pu','pu.pm_unit=pc.pm_unit');
		if($search_params['pm_name']!='')
			$this->db->like('pm.name',$search_params['pm_name']);
		if($search_params['category']!='')
			$this->db->where('pc.pm_category_id',$search_params['category']);
		$this->db->where('pl.plant_id',$plant_id);
		$this->db->order_by('pm.pm_id DESC');
		$res = $this->db->get();
		return $res->num_rows();
	}
/*Getting Stock Results
Author:Srilekha
Time: 04.32PM 02-03-2017 */
	public function stock_results($current_offset, $per_page, $search_params)
	{
		$plant_id = $this->session->userdata('ses_plant_id');		
		$this->db->select('pm.*,pl.quantity as quantity,pc.name as category,pu.name as units');
		$this->db->from('packing_material pm');
		$this->db->join('plant_pm pl','pl.pm_id=pm.pm_id');
		$this->db->join('packing_material_category pc','pc.pm_category_id=pm.pm_category_id');
		$this->db->join('pm_unit pu','pu.pm_unit=pc.pm_unit');
		if($search_params['pm_name']!='')
			$this->db->like('pm.name',$search_params['pm_name']);
		if($search_params['category']!='')
			$this->db->where('pc.pm_category_id',$search_params['category']);
		$this->db->where('pl.plant_id',$plant_id);
		$this->db->order_by('pm.pm_id DESC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
/*Getting Stock details for Download
Author:Srilekha
Time: 04.34PM 02-03-2017 */
public function stock_details($search_params)
	{
		$plant_id = $this->session->userdata('ses_plant_id');		
		$this->db->select('pm.*,pl.quantity as quantity,pc.name as category,pu.name as units');
		$this->db->from('packing_material pm');
		$this->db->join('plant_pm pl','pl.pm_id=pm.pm_id');
		$this->db->join('packing_material_category pc','pc.pm_category_id=pm.pm_category_id');
		$this->db->join('pm_unit pu','pu.pm_unit=pc.pm_unit');
		if($search_params['pm_name']!='')
			$this->db->like('pm.name',$search_params['pm_name']);
		if($search_params['category']!='')
			$this->db->where('pc.pm_category_id',$search_params['category']);
		$this->db->where('pl.plant_id',$plant_id);
		$this->db->order_by('pm.pm_id DESC');
		$res = $this->db->get();
		return $res->result_array();
	}
/*Getting Product num of rows
Author:Srilekha
Time: 04.55PM 02-03-2017 */
	public function product_total_num_rows($search_params)
	{		
		$this->db->select('pl.name as plant,p.*,pp.quantity,pp.loose_pouches,l.name as oil');
		$this->db->from('plant pl');
		$this->db->join('plant_product pp','pp.plant_id=pl.plant_id');
		$this->db->join('product p','p.product_id=pp.product_id');
		$this->db->join('loose_oil l','l.loose_oil_id=p.loose_oil_id');
		$this->db->join('product_capacity pc','pc.product_id = p.product_id');
		$this->db->join('capacity c','c.capacity_id = pc.capacity_id');
		if($search_params['product_name']!='')
			$this->db->where('p.product_id',$search_params['product_name']);
		if($search_params['plant']!='')
			$this->db->where('pl.plant_id',$search_params['plant']);
		if($search_params['loose_oil']!='')
			$this->db->where('l.loose_oil_id',$search_params['loose_oil']);
		$this->db->order_by('pl.plant_id ASC,l.rank ASC,c.rank ASC');
		$this->db->where('p.status',1);
		$res = $this->db->get();
		return $res->num_rows();
	}
/*Getting Product Results
Author:Srilekha
Time: 05.00PM 02-03-2017 */
	public function product_results($current_offset, $per_page, $search_params)
	{	
		$this->db->select('pl.name as plant,p.*,pp.quantity,pp.loose_pouches,l.name as oil');
		$this->db->from('plant pl');
		$this->db->join('plant_product pp','pp.plant_id=pl.plant_id');
		$this->db->join('product p','p.product_id=pp.product_id');
		$this->db->join('loose_oil l','l.loose_oil_id=p.loose_oil_id');
		$this->db->join('product_capacity pc','pc.product_id = p.product_id');
		$this->db->join('capacity c','c.capacity_id = pc.capacity_id');
		if($search_params['product_name']!='')
			$this->db->where('p.product_id',$search_params['product_name']);
		if($search_params['plant']!='')
			$this->db->where('pl.plant_id',$search_params['plant']);
		if($search_params['loose_oil']!='')
			$this->db->where('l.loose_oil_id',$search_params['loose_oil']);
		$this->db->order_by('pl.plant_id ASC,l.rank ASC,c.rank ASC');
		$this->db->where('p.status',1);
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
/*Getting Product details for Download
Author:Srilekha
Time: 05.05PM 02-03-2017 */
public function product_details($search_params)
	{	
		$this->db->select('pl.name as plant,p.*,pp.quantity,pp.loose_pouches,l.name as oil');
		$this->db->from('plant pl');
		$this->db->join('plant_product pp','pp.plant_id=pl.plant_id');
		$this->db->join('product p','p.product_id=pp.product_id');
		$this->db->join('loose_oil l','l.loose_oil_id=p.loose_oil_id');
		$this->db->join('product_capacity pc','pc.product_id = p.product_id');
		$this->db->join('capacity c','c.capacity_id = pc.capacity_id');
		if($search_params['product_name']!='')
			$this->db->where('p.product_id',$search_params['product_name']);
		if($search_params['plant']!='')
			$this->db->where('pl.plant_id',$search_params['plant']);
		if($search_params['loose_oil']!='')
			$this->db->where('l.loose_oil_id',$search_params['loose_oil']);
		$this->db->order_by('pl.plant_id ASC,l.rank ASC,c.rank ASC');
		$this->db->where('p.status',1);
		$res = $this->db->get();
		return $res->result_array();
	}
	/*Stock Details for scrolling 
Author:Srilekha
Time: 04.53PM 18-03-2017 */
	public function get_stock_details()
	{
		$block_id=array(2,3,4);
		$this->db->select('p.name,(sum(pp.quantity*pr.items_per_carton*pr.oil_weight)/1000) as tot_oil_weight');
		$this->db->from('plant_product pp');
		$this->db->join('plant p','p.plant_id=pp.plant_id');
		$this->db->join('product pr','pr.product_id=pp.product_id');
		$this->db->join('plant_block pb','pb.plant_id=p.plant_id');
		$this->db->where_in('pb.block_id',$block_id);
		$this->db->group_by('p.plant_id');
		$this->db->order_by('pb.block_id');
		$res = $this->db->get();
		return $res->result_array();
	}
}