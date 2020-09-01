<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


 // created by maruthi 6th Dec 2016 11:00 AM
class Location_m extends CI_Model {

	// State
		public function state_results($current_offset, $per_page, $search_params)
		{
			$this->db->select('l.*');
			$this->db->from('location l');
			if($search_params['state_name']!='')
				$this->db->like('l.name',$search_params['state_name']);			
			$this->db->where('tl.name','State');
			$this->db->join('territory_level tl ','tl.level_id = l.level_id');
			$this->db->limit($per_page, $current_offset);
			$res = $this->db->get();
			return $res->result_array();
		}

		public function state_details($search_params)
		{
			$this->db->select('l.*');
			$this->db->from('location l');
			if($search_params['state_name']!='')
				$this->db->like('l.name',$search_params['state_name']);			
			$this->db->where('tl.level_id',2);
			$this->db->join('territory_level tl ','tl.level_id = l.level_id');
			$res = $this->db->get();
			return $res->result_array();
		}

		public function state_total_num_rows($search_params)
		{
			$this->db->from('location l');
			if($search_params['state_name']!='')
				$this->db->like('l.name',$search_params['state_name']);			
			$this->db->where('tl.level_id',2);
			$this->db->join('territory_level tl ','tl.level_id = l.level_id');
			$res = $this->db->get();
			return $res->num_rows();
		}
	// Region
		public function region_results($searchParams, $per_page, $current_offset)
		{
			$this->db->select('l.location_id, l.name, l1.name as state_name,l.status');
			$this->db->from('location l');
			if($searchParams['region_name']!='')
				$this->db->like('l.name',$searchParams['region_name']);
			if($searchParams['state_id']!='')
				$this->db->where('l.parent_id',$searchParams['state_id']);
			$this->db->join('location l1','l1.location_id = l.parent_id','left');
			$this->db->where('tl.name', 'Region');
			$this->db->join('territory_level tl ','tl.level_id = l.level_id');
			$this->db->limit($per_page, $current_offset);
			$res = $this->db->get();	
			
			return $res->result_array();
		}

		public function regionDetails($searchParams)
		{
			$this->db->select('l.location_id, l.name, l1.name as state_name,l.status');
			$this->db->from('location l');
			if($searchParams['region_name']!='')
				$this->db->like('l.name',$searchParams['region_name']);
			if($searchParams['state_id']!='')
				$this->db->where('l.parent_id',$searchParams['state_id']);
			$this->db->join('location l1','l1.location_id = l.parent_id','left');
			$this->db->where('tl.name', 'Region');
			$this->db->join('territory_level tl ','tl.level_id = l.level_id');
			$this->db->where('tl.name', 'Region');
			$this->db->join('territory_level tl ','tl.level_id = l.level_id');
			$res = $this->db->get();
			return $res->result_array();
		}

		public function region_total_rows($searchParams)
		{
			$this->db->select('l.location_id, l.name, l1.name as state_name,l.status');
			$this->db->from('location l');
			if($searchParams['region_name']!='')
				$this->db->like('l.name',$searchParams['region_name']);
			if($searchParams['state_id']!='')
				$this->db->where('l.parent_id',$searchParams['state_id']);
			$this->db->join('location l1','l1.location_id = l.parent_id','left');
			$this->db->where('tl.name', 'Region');
			$this->db->join('territory_level tl ','tl.level_id = l.level_id');
			$res = $this->db->get();
			return $res->num_rows();
		}
	// District	
		public function district_results($searchParams, $per_page, $current_offset)
		{
			$this->db->select('l.location_id, l.name, l1.name as region_name,l.status');
			$this->db->from('location l');
			if($searchParams['district_name']!='')
				$this->db->like('l.name',$searchParams['district_name']);
			if($searchParams['region_id']!='')
				$this->db->where('l.parent_id',$searchParams['region_id']);
			$this->db->join('location l1','l1.location_id = l.parent_id','left');
			$this->db->where('tl.name', 'District');
			$this->db->join('territory_level tl ','tl.level_id = l.level_id');
			$this->db->limit($per_page, $current_offset);
			$res = $this->db->get();			
			return $res->result_array();
		}

		public function district_details($searchParams)
		{
			$this->db->select('l.location_id, l.name, l1.name as region_name,l.status');
			$this->db->from('location l');
			if($searchParams['district_name']!='')
				$this->db->like('l.name',$searchParams['district_name']);
			if($searchParams['region_id']!='')
				$this->db->where('l.parent_id',$searchParams['region_id']);
			$this->db->join('location l1','l1.location_id = l.parent_id','left');
			$this->db->where('tl.name', 'District');
			$this->db->join('territory_level tl ','tl.level_id = l.level_id');
			$res = $this->db->get();
			return $res->result_array();
		}

		public function district_total_num_rows($searchParams)
		{
			$this->db->from('location l');
			if($searchParams['district_name']!='')
				$this->db->like('l.name',$searchParams['district_name']);
			if($searchParams['region_id']!='')
				$this->db->where('l.parent_id',$searchParams['region_id']);
			$this->db->join('location l1','l1.location_id = l.parent_id','left');
			$this->db->where('tl.name', 'District');
			$this->db->join('territory_level tl ','tl.level_id = l.level_id');
			$res = $this->db->get();
			return $res->num_rows();
		}
	    
	    // Mandal
        public function mandal_results($searchParams, $per_page, $current_offset)
		{
			$this->db->select('l.location_id, l.name, l1.name as district_name, l2.name as region_name,l.status');
			$this->db->from('location l');
			if($searchParams['mandal_name']!='')
				$this->db->like('l.name',$searchParams['mandal_name']);
			if($searchParams['district_id']!='')
				$this->db->where('l.parent_id',$searchParams['district_id']);
			if($searchParams['region_id']!='')
				$this->db->where('l1.parent_id',$searchParams['region_id']);
			$this->db->join('location l1','l1.location_id = l.parent_id','left');
			$this->db->join('location l2','l2.location_id = l1.parent_id','left');
			$this->db->where('tl.name', 'Mandal');
			$this->db->join('territory_level tl ','tl.level_id = l.level_id');
			$this->db->limit($per_page, $current_offset);
			$res = $this->db->get();		
			return $res->result_array();
		}

		public function districtDetails($searchParams)
		{
			$this->db->select('l.location, l.created_time, l.modified_by, l.modified_time, l1.location as RegionName, l2.location as CountryName');
			$this->db->from('location l');
			if($searchParams['districtName']!='')
			$this->db->like('l.location',$searchParams['districtName']);
			if($searchParams['region_id']!='')
			$this->db->where('l.parent_id',$searchParams['region_id']);
			if($searchParams['region_id']!='')
			$this->db->where('l1.parent_id',$searchParams['region_id']);
			$this->db->join('location l1','l1.location_id = l.parent_id','left');
			$this->db->join('location l2','l2.location_id = l1.parent_id','left');
			$this->db->where('tl.name', 'Mandal');
			$this->db->join('territory_level tl ','tl.level_id = l.level_id');
			$res = $this->db->get();
			return $res->result_array();
		}

		public function mandal_total_num_rows($searchParams)
		{
			$this->db->from('location l');
			if($searchParams['mandal_name']!='')
				$this->db->like('l.name',$searchParams['mandal_name']);
			if($searchParams['district_id']!='')
				$this->db->where('l.parent_id',$searchParams['district_id']);
			if($searchParams['region_id']!='')
				$this->db->where('l1.parent_id',$searchParams['region_id']);
			$this->db->join('location l1','l1.location_id = l.parent_id','left');
			$this->db->join('location l2','l2.location_id = l1.parent_id','left');
			$this->db->where('tl.name', 'Mandal');
			$this->db->join('territory_level tl ','tl.level_id = l.level_id');
			$res = $this->db->get();
			return $res->num_rows();
		}
		public function is_locationExist($location_name,$parent_id,$location_id)
		{		
			$this->db->select();
			$this->db->from('location l');
			$this->db->where('l.parent_id',$parent_id);
			$this->db->where('l.name',$location_name);	
			if($location_id != 0)
				$this->db->where_not_in('l.location_id',$location_id);			
			$this->db->where('l.status',1);
			$query = $this->db->get();
			return ($query->num_rows()>0)?1:0;
		}
		public function check_state($state_name,$location_id)
		{		
			$this->db->select();
			$this->db->from('location l');
			$this->db->where('l.parent_id',1);
			$this->db->where('l.name',$state_name);
			if($location_id != 0)
				$this->db->where_not_in('l.location_id',$location_id);		
			$this->db->where('l.status',1);
			$query = $this->db->get();
			return ($query->num_rows()>0)?1:0;
		}
		/*public function get_regions()
		{
			$this->db->select('l.location_id,concat(l.name," (",l1.name,") ") as location_name');
			$this->db->from('location l');		
			$this->db->join('location l1','l1.location_id = l.parent_id','left');
			$this->db->where('tl.name', 'Region');
			$this->db->join('territory_level tl ','tl.level_id = l.level_id');
			$res=$this->db->get();
			return $res->result_array();
		}*/

		/*public function ajax_get_district_details($region_id)
		{
			$this->db->select('l.location_id, l.name');
			$this->db->from('location l');		
			if($region_id!='')
				$this->db->where('l.parent_id',$region_id);
			$this->db->join('location l1','l1.location_id = l.parent_id','left');
			$this->db->where('tl.name', 'District');
			$this->db->join('territory_level tl ','tl.level_id = l.level_id');
			$res1 = $this->db->get();
			
			$district_options="<option value=''>-Select District-</option>";
			if($res1->num_rows()>0)
   			{ 
			    foreach($res1->result_array() as $state){
			        $district_options.='<option value="'.$state['location_id'].'">'.$state['name'].'</option>';      
			    }
			}
			 else
		    {
		        $district_options.="<option value=''>-No Data Found-</option>";
		    }
		    return $district_options  ;
		}*/

		public function get_district_details($region_id)
		{
			$this->db->select('l.location_id, l.name');
			$this->db->from('location l');		
			if($region_id!='')
				$this->db->where('l.parent_id',$region_id);
			$this->db->join('location l1','l1.location_id = l.parent_id','left');
			$this->db->where('tl.name', 'District');
			$this->db->join('territory_level tl ','tl.level_id = l.level_id');
			$res = $this->db->get();
			return $res->result_array();
		}

		// Area
        public function area_results($searchParams, $per_page, $current_offset)
		{
			$this->db->select('l.location_id, l.name, l1.name as mandal_name, l2.name as district_name,l3.name as region_name,l.status');
			$this->db->from('location l');
		    $this->db->join('location l1','l1.location_id = l.parent_id','left');
			$this->db->join('location l2','l2.location_id = l1.parent_id','left');
			$this->db->join('location l3','l3.location_id = l2.parent_id','left');
			$this->db->join('territory_level tl ','tl.level_id = l.level_id');
			if($searchParams['area_name']!='')
				$this->db->like('l.name',$searchParams['area_name']);
			if($searchParams['mandal_id']!='')
				$this->db->where('l1.location_id',$searchParams['mandal_id']);
			if($searchParams['district_id']!='')
				$this->db->where('l2.location_id',$searchParams['district_id']);
			if($searchParams['region_id']!='')
				$this->db->where('l3.location_id',$searchParams['region_id']);
			$this->db->where('tl.name', 'Area');
			$this->db->limit($per_page, $current_offset);
			$res = $this->db->get();		
			return $res->result_array();
		}

		public function area_total_num_rows($searchParams)
		{
			$this->db->select('l.location_id, l.name, l1.name as mandal_name, l2.name as district_name,l3.name as region_name,l.status');
			$this->db->from('location l');
		    $this->db->join('location l1','l1.location_id = l.parent_id','left');
			$this->db->join('location l2','l2.location_id = l1.parent_id','left');
			$this->db->join('location l3','l3.location_id = l2.parent_id','left');
			$this->db->join('territory_level tl ','tl.level_id = l.level_id');
			if($searchParams['area_name']!='')
				$this->db->like('l.name',$searchParams['area_name']);
			if($searchParams['mandal_id']!='')
				$this->db->where('l1.location_id',$searchParams['mandal_id']);
			if($searchParams['district_id']!='')
				$this->db->where('l2.location_id',$searchParams['district_id']);
			if($searchParams['region_id']!='')
				$this->db->where('l3.location_id',$searchParams['region_id']);
			$this->db->where('tl.name', 'Area');
			$res = $this->db->get();
			return $res->num_rows();
		}

		public function get_mandal_details($district_id)
		{
			$this->db->select('l.location_id, l.name');
			$this->db->from('location l');		
			if($district_id!='')
				$this->db->where('l.parent_id',$district_id);
			$this->db->join('location l1','l1.location_id = l.parent_id','left');
			$this->db->where('tl.name', 'Mandal');
			$this->db->join('territory_level tl ','tl.level_id = l.level_id');
			$res = $this->db->get();
			return $res->result_array();
		}

		

		


		
}