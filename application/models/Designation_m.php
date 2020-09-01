<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Designation_m extends CI_Model {

/*Getting Designation num of rows
Author:Srilekha
Time: 12.38PM 06-02-2017 */
public function designation_total_num_rows($search_params)
	{	
		$status_designation = array(1,2);//to get active and inactive user	
		$this->db->select('d.*,GROUP_CONCAT(b.name SEPARATOR",") as block_name');
		$this->db->from('designation d');
		$this->db->join('block_designation bd','bd.designation_id=d.designation_id AND bd.status=1');
		$this->db->join('block b','bd.block_id=b.block_id AND b.status=1');
		if($search_params['name']!='')
			$this->db->like('d.name',$search_params['name']);
		$this->db->where_in('d.status',$status_designation);
		$this->db->group_by('d.designation_id');
		
		$res = $this->db->get();
		return $res->num_rows();
	}
/*Getting Designation Results
Author:Srilekha
Time: 12.38PM 06-02-2017 */
public function designation_results($current_offset, $per_page, $search_params)
	{
		$status_designation = array(1,2);//to get active and inactive user			
		$this->db->select('d.*,GROUP_CONCAT(b.name SEPARATOR",") as block_name');
		$this->db->from('designation d');
		$this->db->join('block_designation bd','bd.designation_id=d.designation_id AND bd.status=1');
		$this->db->join('block b','bd.block_id=b.block_id AND b.status=1');
		if($search_params['name']!='')
			$this->db->like('d.name',$search_params['name']);
		
		$this->db->where_in('d.status',$status_designation);
		$this->db->group_by('d.designation_id');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		

		return $res->result_array();
	}
/*Getting Plant details for Download
Author:Srilekha
Time: 4.08PM 21-01-2017 */
public function designation_details($search_params)
	{	
	    $status_designation = array(1,2);//to get active and inactive user		
		$this->db->select('d.*,GROUP_CONCAT(b.name SEPARATOR",") as block_name');
		$this->db->from('designation d');
		$this->db->join('block_designation bd','bd.designation_id=d.designation_id AND bd.status=1');
		$this->db->join('block b','bd.block_id=b.block_id AND b.status=1');
		if($search_params['name']!='')
			$this->db->like('d.name',$search_params['name']);
		$this->db->where_in('d.status',$status_designation);
		$this->db->group_by('d.designation_id');
		$res = $this->db->get();
		return $res->result_array();
	}
/*Getting Block id
Author:Srilekha
Time: 11.48AM 13-02-2017 */
public function get_block_name($designation_id)
	{		
		$this->db->select('b.name');
		$this->db->from('designation d');
		$this->db->join('block_designation bd','bd.designation_id=d.designation_id');
		$this->db->join('block b','bd.block_id=b.block_id');
		$this->db->where('bd.designation_id',$designation_id);
		$this->db->where('b.status',1);
		$this->db->where('bd.status',1);
		$res = $this->db->get();
		return $res->result_array();
	}
public function insert_update($block_id,$designation_id)
	{
		$qry = "INSERT INTO block_designation( block_id, designation_id, status) 
                    VALUES (".$block_id.",".$designation_id.",'1')  
                    ON DUPLICATE KEY UPDATE status = VALUES(status);";
        $this->db->query($qry);
	}

//uniqueness of bank name
	public function is_designationExist($designation_name,$designation_id)
    {       
        $this->db->select();
        $this->db->from('designation d');
        $this->db->where('d.name',$designation_name);
        if($designation_id!=0)
        {
            $this->db->where_not_in('d.designation_id',$designation_id);
        }
        $query = $this->db->get();
        return ($query->num_rows()>0)?1:0;
    }

}