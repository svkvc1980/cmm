<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// created by Srilekha on 21st FEB 2017  11:40AM
class Free_sample_m extends CI_Model {

/*Free Sample num of rows
Author:Srilekha
Time: 11.40AM 21-02-2017 */
	public function freesample_total_num_rows($search_params)
	{	$plant_id = $this->session->userdata('ses_plant_id');	
		$this->db->select('fs.*,p.name as product_name');
		$this->db->from('free_sample fs');
		$this->db->join('product p','p.product_id=fs.product_id');
		if($search_params['do_number']!='')
			$this->db->where('fs.do_number',$search_params['do_number']);
		if($search_params['product']!='')
			$this->db->where('fs.product_id',$search_params['product']);
		if($search_params['from_date']!='')
			$this->db->where('fs.on_date>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('fs.on_date<=',$search_params['to_date']);
		$this->db->where('fs.plant_id',$plant_id);
		$res = $this->db->get();
		return $res->num_rows();
	}
/*Free Sample Results
Author:Srilekha
Time: 11.41AM 21-02-2017 */
	public function freesample_results($current_offset, $per_page, $search_params)
	{
		$plant_id = $this->session->userdata('ses_plant_id');			
		$this->db->select('fs.*,p.name as product_name');
		$this->db->from('free_sample fs');
		$this->db->join('product p','p.product_id=fs.product_id');
		if($search_params['do_number']!='')
			$this->db->where('fs.do_number',$search_params['do_number']);
		if($search_params['product']!='')
			$this->db->where('fs.product_id',$search_params['product']);
		if($search_params['from_date']!='')
			$this->db->where('fs.on_date>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('fs.on_date<=',$search_params['to_date']);
		$this->db->where('fs.plant_id',$plant_id);
		$this->db->order_by('fs.free_sample_id DESC');
		
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
/*Free Sample Details
Author:Srilekha
Time: 02.59AM 21-02-2017 */
	public function freesample_details($search_params)
	{
		$plant_id = $this->session->userdata('ses_plant_id');		
		$this->db->select('fs.*,p.name as product_name');
		$this->db->from('free_sample fs');
		$this->db->join('product p','p.product_id=fs.product_id');
		if($search_params['do_number']!='')
			$this->db->where('fs.do_number',$search_params['do_number']);
		if($search_params['product']!='')
			$this->db->where('fs.product_id',$search_params['product']);
		if($search_params['from_date']!='')
			$this->db->where('fs.on_date>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('fs.on_date<=',$search_params['to_date']);
		$this->db->where('fs.plant_id',$plant_id);
		$this->db->order_by('fs.free_sample_id DESC');
		$res = $this->db->get();		
		return $res->result_array();
	}
/*No of Items per carton details
Author:Srilekha
Time: 03.37PM 21-02-2017 */
	public function getitemsList($product_id)
	{

		$q=$product_id;
	    $this->db->select('p.items_per_carton');
	    $this->db->from('product p');
	    $this->db->where('p.product_id',$q);
	    $this->db->where('status',1);
        $res1 = $this->db->get();
		$res = $res1->result_array();
		
		$count = $res1->num_rows();

		$qry_data='';
        $qry_data = $res[0]['items_per_carton'];
		echo $qry_data;
    }
/*Quantity details
Author:Srilekha
Time: 12.49PM 04-03-2017 */
	public function getquantityList($product_id,$plant_id)
	{

		$q=$product_id;
	    $this->db->select('p.quantity');
	    $this->db->from('plant_product p');
	    $this->db->where('p.product_id',$q);
	    $this->db->where('p.plant_id',$plant_id);
        $res1 = $this->db->get();
		$res = $res1->result_array();
		
		$count = $res1->num_rows();

		$qry_data='';
		if(isset($res[0]['quantity'])!= '')
		{
		  $qry_data = $res[0]['quantity'];
		}
		else
		{
		 $qry_data = 0;
		} 
        
		echo $qry_data;
    }
}