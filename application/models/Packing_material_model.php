<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Packing_material_model extends CI_Model {

	public function packing_material_total_num_rows($search_params)
	{		
		$this->db->select('p.pm_id, p.name as packing_material, ct.name as category, c.name as capacity, cp.capacity_id as capacity_id');
		$this->db->from('packing_material p');
		$this->db->join('packing_material_category ct', 'p.pm_category_id=ct.pm_category_id');
		$this->db->join('packing_material_capacity cp', 'p.pm_id=cp.pm_id');
		$this->db->join('capacity c', 'cp.capacity_id=c.capacity_id');
		$this->db->join('unit u', 'c.unit_id=u.unit_id');
		if($search_params['packing_material_name']!='')
			$this->db->like('p.name',$search_params['packing_material_name']);
		if($search_params['capacity_id']!='')
			$this->db->where('cp.capacity_id',$search_params['capacity_id']);
		if($search_params['pm_category_id']!='')
			$this->db->where('ct.pm_category_id',$search_params['pm_category_id']);
		if($search_params['pm_group']!='')
			$this->db->where('p.pm_group_id',$search_params['pm_group']);
		if($search_params['status']!='')
			$this->db->where('p.status',$search_params['status']);
		$this->db->where('ct.status',1);
		$this->db->order_by('p.name ASC,c.rank ASC');
		$res = $this->db->get();
		return $res->num_rows();
	}

	public function packing_material_results($search_params,$per_page,$current_offset)
	{		
		$this->db->select('p.pm_id,pg.name as pm_group, p.name as packing_material, p.description, p.status as packing_status, ct.name as category, c.name as capacity, cp.capacity_id as capacity_id, u.name as unit');
		$this->db->from('packing_material p');
		$this->db->join('packing_material_category ct', 'p.pm_category_id=ct.pm_category_id');
		$this->db->join('packing_material_capacity cp', 'p.pm_id=cp.pm_id');
		$this->db->join('capacity c', 'cp.capacity_id=c.capacity_id');
		$this->db->join('unit u', 'c.unit_id=u.unit_id');
		$this->db->join('pm_group pg','p.pm_group_id = pg.pm_group_id');
		if($search_params['packing_material_name']!='')
			$this->db->like('p.name',$search_params['packing_material_name']);
		if($search_params['capacity_id']!='')
			$this->db->where('cp.capacity_id',$search_params['capacity_id']);
		if($search_params['pm_category_id']!='')
			$this->db->where('ct.pm_category_id',$search_params['pm_category_id']);
		if($search_params['pm_group']!='')
			$this->db->where('p.pm_group_id',$search_params['pm_group']);
		if($search_params['status']!='')
			$this->db->where('p.status',$search_params['status']);
		$this->db->where('ct.status',1);
		$this->db->order_by('p.name ASC,c.rank ASC');				
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();
		return $res->result_array();
	}

	//for xl download
	public function packing_material_details($search_params)
	{
		$this->db->select('p.pm_id,pg.name as pm_group, p.name as packing_material, p.description, p.status as packing_status, ct.name as category, c.name as capacity, cp.capacity_id as capacity_id, u.name as unit');
		$this->db->from('packing_material p');
		$this->db->join('packing_material_category ct', 'p.pm_category_id=ct.pm_category_id');
		$this->db->join('packing_material_capacity cp', 'p.pm_id=cp.pm_id');
		$this->db->join('capacity c', 'cp.capacity_id=c.capacity_id');
		$this->db->join('unit u', 'c.unit_id=u.unit_id');
		$this->db->join('pm_group pg','p.pm_group_id = pg.pm_group_id');
		if($search_params['packing_material_name']!='')
			$this->db->like('p.name',$search_params['packing_material_name']);
		if($search_params['capacity_id']!='')
			$this->db->where('cp.capacity_id',$search_params['capacity_id']);
		if($search_params['pm_category_id']!='')
			$this->db->where('ct.pm_category_id',$search_params['pm_category_id']);
		if($search_params['pm_group']!='')
			$this->db->where('p.pm_group_id',$search_params['pm_group']);
		if($search_params['status']!='')
			$this->db->where('p.status',$search_params['status']);
		$this->db->where('ct.status',1);
		$this->db->order_by('p.name ASC,c.rank ASC');
		$res = $this->db->get();
		return $res->result_array();
	}

	//getting corresponding values for editing
	public function packing_material($packing_id)
	{
		$this->db->select('p.pm_id,p.pm_group_id, p.name as packing_material, p.description, p.status as packing_status,cp.capacity_id as capacity_id, p.pm_code');
		$this->db->from('packing_material p');
		$this->db->join('packing_material_category ct', 'p.pm_category_id=ct.pm_category_id');
		$this->db->join('packing_material_capacity cp', 'p.pm_id=cp.pm_id');
		$this->db->where('p.pm_id',$packing_id);
		$res = $this->db->get();
		return $res->result_array();
	}

	//for getting capacity dropdown
	public function get_capacity()
	{
		$this->db->select('c.capacity_id,c.name as capacity,u.name as unit');
		$this->db->from('capacity c');
		$this->db->join('unit u', 'c.unit_id=u.unit_id');
		$res = $this->db->get();		
		return $res->result_array();
	}

	/*Block List
Author:Srilekha
Time: 01.00PM 05-03-2017 */
	public function get_required_block()
	{
		$var = array(2);
		$this->db->select('b.block_id,b.name');
		$this->db->from('block b');
		$this->db->where_in('b.block_id',$var);
		$res = $this->db->get();		
		return $res->result_array();
    }
/*PLant List
Author:Srilekha
Time: 01.01PM 05-03-2017 */
    public function get_plant_details($block_id)
	{
		$this->db->select('p.plant_id,p.name');
		$this->db->from('plant p');		
		$this->db->join('plant_block pb','pb.plant_id=p.plant_id');
		$this->db->where('pb.block_id',$block_id);
		$res = $this->db->get();		
		return $res->result_array();
	}
/*Packing Material Category List
Author:Srilekha
Time: 01.01PM 05-03-2017 */
	public function get_pm() 
	{
		$block_id = $this->session->userdata('block_id');
		$this->db->from('packing_material_category');
		$this->db->where('status',1);
		$res=$this->db->get();
		
		if($block_id!=2)
		{
			$this->db->where_not_in('pm_category_id',1);
		}
		
		return $res->result_array();
	}
/*Packing Material List
Author:Srilekha
Time: 01.01PM 05-03-2017 */
	public function get_sub_pm_by_pm($pm_category_id)
	{	$film_id = get_film_id();
		$this->db->from('packing_material');
		$this->db->where('pm_category_id',$pm_category_id);
		$this->db->where('status',1);
		$this->db->where_not_in('pm_category_id',$film_id);
		$this->db->order_by('name');
		$res=$this->db->get();
		return $res->result_array();
	}
	/*Packing Material name Unique...
    Author:Srilekha
    Time: 01.01PM 20-03-2017 */
	 public function is_nameExist($name,$pm_id,$capacity_id)
    {       
        $this->db->select();
        $this->db->from('packing_material p');
        $this->db->join('packing_material_capacity pmc','pmc.pm_id=p.pm_id');
        if($pm_id!=0)
        {
            $this->db->where_not_in('p.pm_id',$pm_id);
        }
        $this->db->where('p.name',$name);
        $this->db->where('pmc.capacity_id',$capacity_id);
        $query = $this->db->get();        
        return ($query->num_rows()>0)?1:0;
    }
    /*getting unit capacity List
    Author:Roopa
    Time: 01.01PM 20-03-2017 */ 
    public function get_unit_capacity()
	{
		$this->db->select('c.capacity_id,c.name as capacity,u.name as unit');
		$this->db->from('capacity c');
		$this->db->join('unit u', 'c.unit_id=u.unit_id');
		$this->db->where('c.status',1);
		$this->db->where('u.status',1);
		$res = $this->db->get();		
		return $res->result_array();
	}

}
?>