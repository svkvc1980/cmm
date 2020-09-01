<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Packing_material_category_m extends CI_Model {

/*Getting Category num of rows
Author:Srilekha
Time: 11.32AM 24-02-2017 */
public function category_total_num_rows($search_params)
	{		
		$this->db->select('pm.*,pt.name as type,pu.name as unit');
		$this->db->from('packing_material_category pm');
		$this->db->join('packing_type pt','pt.packing_type_id=pm.packing_type_id');
		$this->db->join('pm_unit pu','pu.pm_unit=pm.pm_unit');
		if($search_params['name']!='')
			$this->db->like('pm.name',$search_params['name']);
		$this->db->order_by('pm.pm_category_id DESC');
		$res = $this->db->get();
		return $res->num_rows();
	}
/*Getting Category Results
Author:Srilekha
Time: 11.36AM 24-02-2017 */
public function category_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('pm.*,pt.name as type,pu.name as unit');
		$this->db->from('packing_material_category pm');
		$this->db->join('packing_type pt','pt.packing_type_id=pm.packing_type_id');
		$this->db->join('pm_unit pu','pu.pm_unit=pm.pm_unit');
		if($search_params['name']!='')
			$this->db->like('pm.name',$search_params['name']);
		$this->db->order_by('pm.pm_category_id DESC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();
		return $res->result_array();
	}
/*Getting Packing Material Category details for Download
Author:Srilekha
Time: 12.13PM 24-01-2017 */
public function category_details($search_params)
	{		
		$this->db->select('pm.*,pt.name as type,pu.name as unit');
		$this->db->from('packing_material_category pm');
		$this->db->join('packing_type pt','pt.packing_type_id=pm.packing_type_id');
		$this->db->join('pm_unit pu','pu.pm_unit=pm.pm_unit');
		if($search_params['name']!='')
			$this->db->like('pm.name',$search_params['name']);
		$this->db->where('pm.status',1);
		$this->db->order_by('pm.pm_category_id DESC');
		$res = $this->db->get();
		return $res->result_array();
	}


//uniqueness of Category name
	public function is_categoryExist($material_name,$category_id)
    {       
        
        $this->db->from('packing_material_category');
        $this->db->where('name',$material_name);
        if($category_id!=0)
        {
            $this->db->where_not_in('pm_category_id',$category_id);
        }
        $query = $this->db->get();
        return ($query->num_rows()>0)?1:0;
    }

}