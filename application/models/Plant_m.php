<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Plant_m extends CI_Model {

/*Getting Plant num of rows
Author:Srilekha
Time: 12.38PM 06-02-2017 */
public function plant_total_num_rows($search_params)
	{		
		$this->db->select('p.*,b.name as block_name,b.block_id as bid, pb.plant_id,pb.block_id,l.name as location_name');
		$this->db->from('plant p');
		$this->db->join('plant_block pb','pb.plant_id=p.plant_id');
		$this->db->join('block b','pb.block_id=b.block_id');
		$this->db->join('location l','p.location_id=l.location_id');
		if($search_params['name']!='')
			$this->db->like('p.name',$search_params['name']);
		if($search_params['location']!='')
			$this->db->where('p.location_id',$search_params['location']);
		if($search_params['block']!='')
			$this->db->where('pb.block_id',$search_params['block']);
		$this->db->where('p.plant_id>',3);
		$res = $this->db->get();
		return $res->num_rows();
	}
/*Getting Plant Results
Author:Srilekha
Time: 12.38PM 06-02-2017 */
public function plant_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('p.*,b.name as block_name,b.block_id as bid,  pb.plant_id,pb.block_id,l.name as location_name');
		$this->db->from('plant p');
		$this->db->join('plant_block pb','pb.plant_id=p.plant_id');
		$this->db->join('block b','pb.block_id=b.block_id');
		$this->db->join('location l','p.location_id=l.location_id','left');
		if($search_params['name']!='')
			$this->db->like('p.name',$search_params['name']);
		if($search_params['location']!='')
			$this->db->where('p.location_id',$search_params['location']);
		if($search_params['block']!='')
			$this->db->where('pb.block_id',$search_params['block']);
		$this->db->where('p.plant_id>',3);
		$this->db->order_by('p.plant_id ASC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
/*Getting Plant details for Download
Author:Srilekha
Time: 4.08PM 21-01-2017 */
public function plant_details($search_params)
	{		
		$this->db->select('p.*,b.name as block_name,b.block_id as bid,  pb.plant_id,pb.block_id,l.name as location_name');
		$this->db->from('plant p');
		$this->db->join('plant_block pb','pb.plant_id=p.plant_id');
		$this->db->join('block b','pb.block_id=b.block_id');
		$this->db->join('location l','p.location_id=l.location_id','left');
		if($search_params['name']!='')
			$this->db->like('p.name',$search_params['name']);
		if($search_params['location']!='')
			$this->db->where('p.location_id',$search_params['location']);
		if($search_params['block']!='')
			$this->db->where('pb.block_id',$search_params['block']);
		$this->db->order_by('p.plant_id DESC');
		$this->db->where('p.plant_id>',3);
		$res = $this->db->get();
		return $res->result_array();
	}
/*Getting Block details 
Author:Srilekha
Time: 6.10PM 06-02-2017 */
public function get_block_data()
	{		
		$this->db->select();
		$this->db->from('block');
		$this->db->where_not_in('block_id',1);
		$this->db->where_not_in('block_id',5);
		$res = $this->db->get();
		return $res->result_array();
	}

/*Getting Distrct results
Author:Srilekha
Time: 12.40PM 06-02-2017 */
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
    /*Getting Mandal results
Author:Srilekha
Time: 2.52PM 25-01-2017 */
	public function getmandalList($district_id)
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
			$qry_data.='<option value="">-Select Mandal-</option>';
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
    /*Getting Area results
Author:Srilekha
Time: 2.52PM 25-01-2017 */
	public function getareaList($mandal_id)
	{
	    $this->db->select('location_id,name');
	    $this->db->from('location');
	    $this->db->where('parent_id',$mandal_id);
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

/*Getting Distrctcf results
Author:Srilekha
Time: 04.50PM 06-02-2017 */
	public function getregionListcf($state_id)
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
	public function getdistrictListcf($region_id)
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
			$qry_data.=' <label class="control-label"></label>';
			foreach($res as $row1)
			{  
				$qry_data.='<input type="checkbox" class="district_id" name="district_cf[]" value="'. $row1['location_id'].' "> <label class="control-label">'. $row1['name'].'</label> <br/>';
			}
		} 
		else 
		{
			$qry_data.='<option value="">No Data Found</option>';
		}
		echo $qry_data;
    }
/*Getting Mandal results
Author:Mounika */
	public function getmandalListcf($district_id)
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
			$qry_data.='<option value="">-Select Mandal-</option>';
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
   /*Getting Area results
Author:Mounika */
	public function getareaListcf($mandal_id)
	{
	    $this->db->select('location_id,name');
	    $this->db->from('location');
	    $this->db->where('parent_id',$mandal_id);
	    $this->db->where('status', 1);
        $res1 = $this->db->get();
		$res = $res1->result_array();
		$count = $res1->num_rows();
		$qry_data='';
        if($count>0)
		{
			$qry_data.='<option value="">-Select Area-</option>';
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
/*Inserting Plant location district updated data
Author:Srilekha
Time: 10.32AM 10-02-2017 */
public function insert_update($district,$plant_id)
	{
		$qry = "INSERT INTO plant_location( location_id, plant_id, status) 
                    VALUES (".$district.",".$plant_id.",'1')  
                    ON DUPLICATE KEY UPDATE status = VALUES(status);";
        $this->db->query($qry);
	}
/*Inserting Plant location region updated data
Author:Srilekha
Time: 10.39AM 10-02-2017 */
public function insert_update_region($plant_region,$plant_id)
	{
		$qry = "INSERT INTO plant_location( location_id, plant_id, status) 
                    VALUES (".$plant_region.",".$plant_id.",'1')  
                    ON DUPLICATE KEY UPDATE status = VALUES(status);";
        $this->db->query($qry);
	}
/*Inserting Plant location state updated data
Author:Srilekha
Time: 10.40AM 10-02-2017 */
public function insert_update_state($plant_state,$plant_id)
	{
		$qry = "INSERT INTO plant_location( location_id, plant_id, status) 
                    VALUES (".$plant_state.",".$plant_id.",'1')  
                    ON DUPLICATE KEY UPDATE status = VALUES(status);";
        $this->db->query($qry);
	}

}