 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_model extends CI_Model { 

	/* fetching data of distributor credit debit list
    Author:Aswini
    Time:17-02-2017*/


    public function credit_debit_list($current_offset, $per_page, $search_params)
	{		
		$this->db->select('n.*,p.name as purpose_name,d.concerned_person as concerned_name');
		$this->db->from('distributor_credit_debit_note n');
		$this->db->join('credit_debit_purpose p','p.purpose_id=n.purpose_id','left');
		$this->db->join('distributor d','d.distributor_id=n.distributor_id');
		
		if($search_params['distributor_id']!='')
		       $this->db->where('n.distributor_id',$search_params['distributor_id']);
		   if($search_params['on_date']!='')
		       $this->db->where('n.on_date',$search_params['on_date']);
		   if($search_params['note_type']!='')
		       $this->db->where('n.note_type',$search_params['note_type']);
		   if($search_params['purpose_id']!='')
		       $this->db->where('n.purpose_id',$search_params['purpose_id']);
	
		//$this->db->where('n.status',1);
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();
		//echo $this->db->last_query();exit;		
		return $res->result_array(); 
	}
	/* fetching rows of distributor credit debit list
    Author:Aswini
    Time:17-02-2017*/
	public function credit_debit_num_rows($search_params)
	{		
		$this->db->select('n.*,p.name as purpose_name,d.concerned_person as concerned_name');
		$this->db->from('distributor_credit_debit_note n');
		$this->db->join('credit_debit_purpose p','p.purpose_id=n.purpose_id','left');
		$this->db->join('distributor d','d.distributor_id=n.distributor_id');
		if($search_params['distributor_id']!='')
		     $this->db->where('n.distributor_id',$search_params['distributor_id']);
		 if($search_params['on_date']!='')
		     $this->db->where('n.on_date',$search_params['on_date']);
		 if($search_params['note_type']!='')
		     $this->db->where('n.note_type',$search_params['note_type']);
		 if($search_params['purpose_id']!='')
		     $this->db->where('n.purpose_id',$search_params['purpose_id']);
		 
		$res = $this->db->get();		
		return $res->num_rows(); 

	}
	/* details of credit debit details
    Author:Aswini
    Time:16-02-2017*/
	public function credit_debit_details($search_params)
	{		
		$this->db->select('n.*,p.name as purpose_name,d.concerned_person as concerned_name');
		$this->db->from('distributor_credit_debit_note n');
		$this->db->join('credit_debit_purpose p','p.purpose_id=n.purpose_id','left');
		$this->db->join('distributor d','d.distributor_id=n.distributor_id');		
		if($search_params['distributor_id']!='')
		     $this->db->where('n.distributor_id',$search_params['distributor_id']);
		 if($search_params['on_date']!='')
		     $this->db->where('n.on_date',$search_params['on_date']);
		 if($search_params['note_type']!='')
		     $this->db->where('n.note_type',$search_params['note_type']);
		 if($search_params['purpose_id']!='')
		     $this->db->where('n.purpose_id',$search_params['purpose_id']);
		
		//$this->db->where('n.status',1);
	    //$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array(); 

	}
	/* getting purpose
    Author:Aswini
    Time:15-02-2017*/
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

    /*distributor Payments number of rows
    Author:Roopa
    Time: 11.26AM 17-02-2017 */
     public function distributor_payment_total_num_rows($search_params)
    {       
        $this->db->select('dp.*,d.agency_name,d.distributor_code,pm.name as pay_mode_name,b.name as bank_name,p.short_name as unit_name');
        $this->db->from('distributor_payment dp');      
        $this->db->join('distributor d','d.distributor_id=dp.distributor_id');
        $this->db->join('user u','u.user_id = dp.created_by');
        $this->db->join('plant p','p.plant_id = u.plant_id');
        $this->db->join('payment_mode pm','pm.pay_mode_id=dp.pay_mode_id');
        $this->db->join('bank b','b.bank_id=dp.bank_id');
        if($search_params['distributor_id']!='')
            $this->db->where('dp.distributor_id',$search_params['distributor_id']);
        if($search_params['pay_mode_id']!='')
            $this->db->where('dp.pay_mode_id',$search_params['pay_mode_id']);
        if($search_params['bank_id']!='')
            $this->db->where('dp.bank_id',$search_params['bank_id']);
        if($search_params['dd_number']!='')
            $this->db->like('dp.dd_number',$search_params['dd_number']);
        if($search_params['from_date']!='')
            $this->db->where('dp.payment_date>=',$search_params['from_date']);
        if($search_params['to_date']!='')
            $this->db->where('dp.payment_date<=',$search_params['to_date']);
        if($search_params['plant_id']!='')
            $this->db->where('p.plant_id',$search_params['plant_id']);
        if($search_params['status']!='')
            $this->db->where('dp.status',$search_params['status']);
         $this->db->order_by('payment_date DESC');
        $res = $this->db->get();
        return $res->num_rows();
    }
    /*distributor Payments results
    Author:Roopa
    Time: 11.26AM 17-02-2017 */
    public function distributor_payment_results($current_offset, $per_page, $search_params)
    {       
       	$this->db->select('dp.*,d.agency_name,d.distributor_code,pm.name as pay_mode_name,b.name as bank_name,p.short_name as unit_name');
        $this->db->from('distributor_payment dp');      
        $this->db->join('distributor d','d.distributor_id=dp.distributor_id');
        $this->db->join('user u','u.user_id = dp.created_by');
        $this->db->join('plant p','p.plant_id = u.plant_id');
        $this->db->join('payment_mode pm','pm.pay_mode_id=dp.pay_mode_id');
        $this->db->join('bank b','b.bank_id=dp.bank_id');
        if($search_params['distributor_id']!='')
            $this->db->where('dp.distributor_id',$search_params['distributor_id']);
        if($search_params['pay_mode_id']!='')
            $this->db->where('dp.pay_mode_id',$search_params['pay_mode_id']);
        if($search_params['bank_id']!='')
            $this->db->where('dp.bank_id',$search_params['bank_id']);
        if($search_params['dd_number']!='')
            $this->db->like('dp.dd_number',$search_params['dd_number']);
        if($search_params['from_date']!='')
            $this->db->where('dp.payment_date>=',$search_params['from_date']);
        if($search_params['to_date']!='')
            $this->db->where('dp.payment_date<=',$search_params['to_date']);
        if($search_params['plant_id']!='')
            $this->db->where('p.plant_id',$search_params['plant_id']);
        if($search_params['status']!='')
            $this->db->where('dp.status',$search_params['status']);
        $this->db->order_by('payment_date DESC');
        $this->db->limit($per_page, $current_offset);
        $res = $this->db->get();        
        return $res->result_array();
    }
    
    /*end */  

    /* 
 	Created By 		:	Gowripriya 
 	Module 			:	 dd Receipts
 	Created Time 	:	14th Feb 2017 11:23 AM
 	Modified Time 	:	
*/
 // get total valuse
	public function get_dd_receipts()
	{
		
		$this->db->from('distributor_payment');
		$res = $this->db->get();		
		return $res->result_array();
	}
// validating dd number
	public function is_numberExist($dd_number)
    {       
        $this->db->select('dd_number');
        $this->db->from('distributor_payment');
        $this->db->where('dd_number',$dd_number);
        $query = $this->db->get();
		return ($query->num_rows()>0)?1:0;
    }

    public function get_active_distributor()
    {
    	$this->db->select('d.distributor_id,d.agency_name,d.distributor_code');
    	$this->db->from('distributor d');
    	$this->db->join('user u','u.user_id = d.user_id');
    	$this->db->where('u.status',1);
    	$this->db->order_by('CAST(d.distributor_code as unsigned) ASC');
    	$res = $this->db->get();
    	return $res->result_array();
    }

    public function get_plant_list()
    {
    	$blocks = array(1,3,4);
    	$this->db->select('p.plant_id,p.name');
    	$this->db->from('plant p');
    	$this->db->join('plant_block pb','p.plant_id= pb.plant_id');
    	$this->db->where('p.status',1);
    	$this->db->where_in('pb.block_id',$blocks);
    	$res = $this->db->get();
    	return $res->result_array();
    }
 }
