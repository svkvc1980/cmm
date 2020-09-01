 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class c_and_f_payment_model extends CI_Model { 

	/* fetching data of distributor credit debit list
    Author:Aswini
    Time:21-02-2017*/


    public function credit_debit_list($current_offset, $per_page, $search_params)
	{		
		$this->db->select('c.*,p.name as purpose_name,pt.name as plant_name,');
		$this->db->from('c_and_f_credit_debit_note c');
		$this->db->join('credit_debit_purpose p','p.purpose_id=c.purpose_id','left');
		$this->db->join('plant pt','pt.plant_id=c.plant_id');
	   
		
		if($search_params['plant_id']!='')
		       $this->db->like('c.plant_id',$search_params['plant_id']);
		   if($search_params['on_date']!='')
		       $this->db->like('c.on_date',$search_params['on_date']);
		   if($search_params['note_type']!='')
		       $this->db->like('c.note_type',$search_params['note_type']);
		   if($search_params['purpose_id']!='')
		       $this->db->like('c.purpose_id',$search_params['purpose_id']);
	
		//$this->db->where('n.status',1);
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();
		//echo $this->db->last_query();exit;		
		return $res->result_array(); 
	}
	/* fetching rows of distributor credit debit list
    Author:Aswini
    Time:21-02-2017*/
	public function credit_debit_num_rows($search_params)
	{		
		$this->db->select('c.*,p.name as purpose_name,pt.name as plant_name');
		$this->db->from('c_and_f_credit_debit_note c');
		$this->db->join('credit_debit_purpose p','p.purpose_id=c.purpose_id','left');
		$this->db->join('plant pt','pt.plant_id=c.plant_id');
		if($search_params['plant_id']!='')
		     $this->db->like('c.plant_id',$search_params['plant_id']);
		 if($search_params['on_date']!='')
		     $this->db->like('c.on_date',$search_params['on_date']);
		 if($search_params['note_type']!='')
		     $this->db->like('c.note_type',$search_params['note_type']);
		 if($search_params['purpose_id']!='')
		     $this->db->like('c.purpose_id',$search_params['purpose_id']);
		 
		//$this->db->where('n.status',1);
	    //$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->num_rows(); 

	}
	/* details of credit debit details
    Author:Aswini
    Time:21-02-2017*/
	public function credit_debit_details($search_params)
	{		
		$this->db->select('c.*,p.name as purpose_name,pt.name as plant_name');
		$this->db->from('c_and_f_credit_debit_note c');
		$this->db->join('credit_debit_purpose p','p.purpose_id=c.purpose_id','left');
		$this->db->join('plant pt','pt.plant_id=c.plant_id');		
		if($search_params['plant_id']!='')
		     $this->db->like('c.plant_id',$search_params['plant_id']);
		 if($search_params['on_date']!='')
		     $this->db->like('c.on_date',$search_params['on_date']);
		 if($search_params['note_type']!='')
		     $this->db->like('c.note_type',$search_params['note_type']);
		 if($search_params['purpose_id']!='')
		     $this->db->like('c.purpose_id',$search_params['purpose_id']);
		
		//$this->db->where('n.status',1);
	    //$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array(); 

	}
	/* getting purpose
    Author:Aswini
    Time:21-02-2017*/
    public function getpurpose($type_id)
	{
	    $this->db->select('purpose_id,name');
	    $this->db->from('credit_debit_purpose');
	    $this->db->where('type',$type_id);
	    $this->db->where('status', 1);
        $res1 = $this->db->get();
		$res = $res1->result_array();
		$count = $res1->num_rows();
		$qry_data='';
        if($count>0)
		{
			$qry_data.='<option value="">-Select Purpose-</option>';
			foreach($res as $row1)
			{  
				$qry_data.='<option value="'.$row1['purpose_id'].'">'.$row1['name'].'</option>';

			}
			$qry_data.='<option value="9999">others</option>';
		} 
		else 
		{
			$qry_data.='<option value="">No Data Found</option>';
		}
		echo $qry_data;
    }
/* getting plant details
    Author:Aswini
    Time:21-02-2017*/

     public function get_plant_details()
    {
         $this->db->select('p.plant_id,p.name');
         $this->db->from('plant p');
         $this->db->join('plant_block pb','pb.plant_id=p.plant_id');
         $this->db->where('pb.block_id',4); 
         //$this->db->where('p.status',1);    
         $res = $this->db->get();
         return $res->result_array();
    }
      public function get_distributor_details()
    {
         $this->db->select('d.distributor_id,d.outstanding_amount');
         $this->db->from('distributor d');          
         $res = $this->db->get();
         return $res->result_array();
    }

 }
?>
