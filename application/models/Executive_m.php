<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Executive_m extends CI_Model {

/*Getting Executive num of rows
Author:Srilekha
Time: 11.01AM 01-03-2017 */

public function executive_total_num_rows($search_params)
	{		
		$this->db->select('e.*,u.status as status');
		$this->db->from('executive e');
		$this->db->join('user u','u.user_id=e.user_id');
		if($search_params['exe_name']!='')
			$this->db->like('e.name',$search_params['exe_name']);
		if($search_params['exe_code']!='')
			$this->db->where('e.executive_code',$search_params['exe_code']);
		$this->db->order_by('e.executive_id DESC');
		$res = $this->db->get();
		return $res->num_rows();
	}
/*Getting Executive results
Author:Srilekha
Time: 11.05AM 01-03-2017 */
public function executive_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('e.*,u.status as status');
		$this->db->from('executive e');
		$this->db->join('user u','u.user_id=e.user_id');
		if($search_params['exe_name']!='')
			$this->db->like('e.name',$search_params['exe_name']);
		if($search_params['exe_code']!='')
			$this->db->where('e.executive_code',$search_params['exe_code']);
		$this->db->order_by('e.executive_id DESC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
/*Getting Executive results for download
Author:Srilekha
Time: 01.48PM 01-03-2017 */
public function executive_details($search_params)
	{		
		$this->db->select('e.*,l.name as city');
		$this->db->from('executive e');
		$this->db->join('location l','l.location_id=e.location_id');
		if($search_params['exe_name']!='')
			$this->db->like('e.name',$search_params['exe_name']);
		if($search_params['exe_code']!='')
			$this->db->where('e.executive_code',$search_params['exe_code']);
		$this->db->order_by('e.executive_id DESC');
		$res = $this->db->get();
		return $res->result_array();
	}

	public function get_edit_details($exe_id)
	{
		$this->db->select('e.*,u.status as status');
		$this->db->from('executive e');
		$this->db->join('user u','u.user_id=e.user_id');
		$this->db->where('e.executive_id',$exe_id);
		$res = $this->db->get();
		return $res->result_array();
	}
/*Getting Distrct results
Author:Srilekha
Time: 2.52PM 25-01-2017 */
	public function getregionList($state_id)
	{
	    $this->db->select('location_id,name');
	    $this->db->from('location');
	    $this->db->where('parent_id',$state_id);
	    $this->db->where('status', 1);
        $res1 = $this->db->get();
		$res = $res1->result_array();
		$count = $res1->num_rows();
		$qry_data='';
        if($count>0)
		{
			$qry_data.='<option value="">-Select Region-</option>';
			foreach($res as $row1)
			{  
				$qry_data.='<option value="'.$row1['location_id'].'">'.$row1['name'].'</option>';
			}
		} 
		else 
		{
			$qry_data.='<option value="">No Data Found</option>';
		}
		echo $qry_data;
    }
/*Getting Distrct results
Author:Srilekha
Time: 2.52PM 25-01-2017 */
	public function getdistrictList($region_id)
	{
	    $this->db->select('location_id,name');
	    $this->db->from('location');
	    $this->db->where('parent_id',$region_id);
	    $this->db->where('status', 1);
        $res1 = $this->db->get();
		$res = $res1->result_array();
		$count = $res1->num_rows();
		$qry_data='';
        if($count>0)
		{
			$qry_data.='<option value="">-Select District-</option>';
			foreach($res as $row1)
			{  
				$qry_data.='<option value="'.$row1['location_id'].'">'.$row1['name'].'</option>';
			}
		} 
		else 
		{
			$qry_data.='<option value="">No Data Found</option>';
		}
		echo $qry_data;
    }
/*Getting Distrct results
Author:Srilekha
Time: 2.52PM 25-01-2017 */
	public function getareaList($district_id)
	{
	    $this->db->select('location_id,name');
	    $this->db->from('location');
	    $this->db->where('parent_id',$district_id);
	    $this->db->where('status', 1);
        $res1 = $this->db->get();
		$res = $res1->result_array();
		$count = $res1->num_rows();
		$qry_data='';
        if($count>0)
		{
			$qry_data.='<option value="">-Select City/Town-</option>';
			foreach($res as $row1)
			{  
				$qry_data.='<option value="'.$row1['location_id'].'">'.$row1['name'].'</option>';
			}
		} 
		else 
		{
			$qry_data.='<option value="">No Data Found</option>';
		}
		echo $qry_data;
    }

/*Function to check the uniqueness of Category Name
Author:Srilekha
Time: 11.41AM 01-03-2017 */
	public function is_executiveExist($exe_code,$exe_id)
    {       
        
        $this->db->from('executive');
        $this->db->where('executive_code',$exe_code);
        if($exe_id!=0)
        {
            $this->db->where_not_in('executive_id',$exe_id);
        }
        $query = $this->db->get();
        return ($query->num_rows()>0)?1:0;
    }

    //Print Executive Results
	//Mounika
	public function get_executive_print($search_params)
	{		
		$this->db->select('e.*,l.name as city');
		$this->db->from('executive e');
		$this->db->join('location l','l.location_id=e.location_id');
		if($search_params['exe_name']!='')
			$this->db->like('e.name',$search_params['exe_name']);
		if($search_params['exe_code']!='')
			$this->db->where('e.executive_code',$search_params['exe_code']);
		$this->db->group_by('e.executive_id');
        $res = $this->db->get();
        return $res->result_array();
	}

}