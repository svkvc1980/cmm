<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_and_f_m extends CI_Model 
{
	/*Getting plant details
	Author:Gowripriya
	Time: 6:30PM 21-02-2017 */
	public function get_plant_details()
	{
		$c_f_id = get_c_and_f_block_id();
		$this->db->select('p.plant_id,p.name');
		$this->db->from('plant p');		
		$this->db->join('plant_block pb','pb.plant_id=p.plant_id');
		$this->db->where('pb.block_id',$c_f_id);
		$res = $this->db->get();		
		return $res->result_array();
	}
	public function is_numberExist($dd_number)
    {       
        $this->db->select('dd_number');
        $this->db->from('c_and_f_payment');
        $this->db->where('dd_number',$dd_number);
        $query = $this->db->get();
        return ($query->num_rows()>0)?1:0;
    }
    /*CandF Payments number of rows
    Author:Roopa
    Time: 11.26AM 21-02-2017 */
     public function c_and_f_payment_total_num_rows($search_params)
    {       
        $this->db->select('cf.*,p.name as plant_name,pm.name as pay_mode_name,b.name as bank_name');
        $this->db->from('c_and_f_payment cf');      
        $this->db->join('plant p','p.plant_id=cf.plant_id');            
        $this->db->join('payment_mode pm','pm.pay_mode_id=cf.pay_mode_id');
        $this->db->join('bank b','b.bank_id=cf.bank_id');
        if($search_params['plant_id']!='')
            $this->db->where('cf.plant_id',$search_params['plant_id']);
        if($search_params['pay_mode_id']!='')
            $this->db->where('cf.pay_mode_id',$search_params['pay_mode_id']);
        if($search_params['bank_id']!='')
            $this->db->where('cf.bank_id',$search_params['bank_id']);
        if($search_params['dd_number']!='')
            $this->db->like('cf.dd_number',$search_params['dd_number']);
        if($search_params['status']!='')
            $this->db->where('cf.status',$search_params['status']);
        if($search_params['from_date']!='')
            $this->db->where('cf.payment_date >=',$search_params['from_date']);
        if($search_params['to_date']!='')
            $this->db->where('cf.payment_date <=',$search_params['to_date']);
        $this->db->order_by('cf.payment_id DESC');
        $res = $this->db->get();
        return $res->num_rows();
    }
    /*c and f Payments results
    Author:Roopa
    Time: 11.26AM 21-02-2017 */
    public function c_and_f_payment_results($current_offset, $per_page, $search_params)
    {       
        $this->db->select('cf.*,p.name as plant_name,pm.name as pay_mode_name,b.name as bank_name');
        $this->db->from('c_and_f_payment cf'); 
        $this->db->join('plant p','p.plant_id=cf.plant_id');            
        $this->db->join('payment_mode pm','pm.pay_mode_id=cf.pay_mode_id');
        $this->db->join('bank b','b.bank_id=cf.bank_id');
        if($search_params['plant_id']!='')
            $this->db->like('cf.plant_id',$search_params['plant_id']);
        if($search_params['pay_mode_id']!='')
            $this->db->like('cf.pay_mode_id',$search_params['pay_mode_id']);
        if($search_params['bank_id']!='')
            $this->db->like('cf.bank_id',$search_params['bank_id']);
        if($search_params['dd_number']!='')
            $this->db->like('cf.dd_number',$search_params['dd_number']);
        if($search_params['status']!='')
            $this->db->like('cf.status',$search_params['status']);
        if($search_params['from_date']!='')
            $this->db->where('cf.payment_date >=',$search_params['from_date']);
        if($search_params['to_date']!='')
            $this->db->where('cf.payment_date <=',$search_params['to_date']);
        $this->db->order_by('cf.payment_id DESC');
        $this->db->limit($per_page, $current_offset);
        $res = $this->db->get();        
        return $res->result_array();
    }
    /*C&F Payments details for download...
    Author:Roopa
    Time: 11.26AM 21-02-2017 */
    public function c_and_f_payment_details($search_params)
    {       
        $this->db->select('cf.*,p.name as plant_name,p.short_name as unit_name,pm.name as pay_mode_name,b.name as bank_name');
        $this->db->from('c_and_f_payment cf');      
        $this->db->join('plant p','p.plant_id=cf.plant_id');       
        $this->db->join('payment_mode pm','pm.pay_mode_id=cf.pay_mode_id');
        $this->db->join('bank b','b.bank_id=cf.bank_id');
        if($search_params['plant_id']!='')
            $this->db->like('cf.plant_id',$search_params['plant_id']);
        if($search_params['pay_mode_id']!='')
            $this->db->like('cf.pay_mode_id',$search_params['pay_mode_id']);
        if($search_params['bank_id']!='')
            $this->db->like('cf.bank_id',$search_params['bank_id']);
        if($search_params['dd_number']!='')
            $this->db->like('cf.dd_number',$search_params['dd_number']);
        if($search_params['status']!='')
            $this->db->where('cf.status',$search_params['status']);
        if($search_params['from_date']!='')
            $this->db->where('cf.payment_date >=',$search_params['from_date']);
        if($search_params['to_date']!='')
            $this->db->where('cf.payment_date <=',$search_params['to_date']);
        $this->db->order_by('cf.payment_id DESC');
        $res = $this->db->get();      
        return $res->result_array();
    }
	
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

      public function get_distributor_details()
    {
         $this->db->select('d.distributor_id,d.outstanding_amount');
         $this->db->from('distributor d');          
         $res = $this->db->get();
         return $res->result_array();
    }
}