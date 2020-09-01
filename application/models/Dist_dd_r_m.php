 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dist_dd_r_m extends CI_Model { 

	

    /*dist_dd_r details
Author:gowri
Time: 3-21-17*/ 
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

    public function get_datewise_dd_list($search_params)
    {
        $status = array(1,2);
        $plant_id = $this->session->userdata('ses_plant_id'); 
        $block_id = $this->session->userdata('block_id');  
        $this->db->select('dp.*,d.agency_name as distributor_name,d.distributor_code,d.distributor_place,pm.name as pay_mode_name,b.name as bank_name,p.short_name as unit_name');
        $this->db->from('distributor_payment dp');       
        $this->db->join('distributor d','d.distributor_id=dp.distributor_id');
        $this->db->join('payment_mode pm','pm.pay_mode_id=dp.pay_mode_id');
        $this->db->join('bank b','b.bank_id=dp.bank_id');
        $this->db->join('user u','u.user_id = dp.created_by');
        $this->db->join('plant p','p.plant_id = u.plant_id');
        if($search_params['distributor_id']!='')
            $this->db->where('dp.distributor_id',$search_params['distributor_id']);
        if($search_params['pay_mode_id']!='')
            $this->db->like('dp.pay_mode_id',$search_params['pay_mode_id']);
        if($search_params['bank_id']!='')
            $this->db->where('dp.bank_id',$search_params['bank_id']);
        if($search_params['dd_number']!='')
            $this->db->where('dp.dd_number',$search_params['dd_number']);
        if($search_params['from_date']!='')
            $this->db->where('dp.payment_date>=',$search_params['from_date']);
        if($search_params['to_date']!='')
            $this->db->where('dp.payment_date<=',$search_params['to_date']);
        if($search_params['status']!='')
        {
            if($search_params['status']==2)
            {
                $this->db->where('dp.status<=',$search_params['status']);
            }
            else
            {
                $this->db->where('dp.status',$search_params['status']);
            }
            
        }
        else
        {
            $this->db->where_in('dp.status',$status); 
        }
        if($block_id!=1)
        {
            $this->db->where('p.plant_id',$plant_id);
        }
        else
        {
            if($search_params['plant_id']!='')
            $this->db->where('p.plant_id',$search_params['plant_id']);
        }

        $this->db->order_by('dp.bank_id ASC');
        $res = $this->db->get();        
        return $res->result_array();
    }
    public function get_plant_list()
    {
        $block_ids = array(3,4);
        $this->db->select('p.name,p.plant_id');
        $this->db->from('plant p');
        $this->db->join('plant_block pb','pb.plant_id = p.plant_id');
        $this->db->where_in('pb.block_id',$block_ids);
        $this->db->where('p.status',1);
        $res = $this->db->get();
        return $res->result_array();
    }
    public function dist_dd_payment_download($search_params)
    {
    	$status = array(1,2);
        $plant_id = $this->session->userdata('ses_plant_id'); 
        $block_id = $this->session->userdata('block_id');  
        $this->db->select('dp.*,d.agency_name as distributor_name,d.distributor_code,d.distributor_place,pm.name as pay_mode_name,b.name as bank_name,p.name as unit_name');
        $this->db->from('distributor_payment dp');       
        $this->db->join('distributor d','d.distributor_id=dp.distributor_id');
        $this->db->join('payment_mode pm','pm.pay_mode_id=dp.pay_mode_id');
        $this->db->join('bank b','b.bank_id=dp.bank_id');
        $this->db->join('user u','u.user_id = dp.created_by');
        $this->db->join('plant p','p.plant_id = u.plant_id');
        if($search_params['distributor_id']!='')
            $this->db->where('dp.distributor_id',$search_params['distributor_id']);
        if($search_params['pay_mode_id']!='')
            $this->db->like('dp.pay_mode_id',$search_params['pay_mode_id']);
        if($search_params['bank_id']!='')
            $this->db->where('dp.bank_id',$search_params['bank_id']);
        if($search_params['dd_number']!='')
            $this->db->where('dp.dd_number',$search_params['dd_number']);
        if($search_params['from_date']!='')
            $this->db->where('dp.payment_date>=',$search_params['from_date']);
        if($search_params['to_date']!='')
            $this->db->where('dp.payment_date<=',$search_params['to_date']);
        if($search_params['status']!='')
        {
            if($search_params['status']==2)
            {
                $this->db->where('dp.status<=',$search_params['status']);
            }
            else
            {
                $this->db->where('dp.status',$search_params['status']);
            }
            
        }
        else
        {
            $this->db->where_in('dp.status',$status); 
        }
        if($block_id!=1)
        {
            $this->db->where('p.plant_id',$plant_id);
        }
        else
        {
            if($search_params['plant_id']!='')
            $this->db->where('p.plant_id',$search_params['plant_id']);
        }

        $this->db->order_by('dp.bank_id ASC');
        $res = $this->db->get();        
        return $res->result_array();
    
    }
	

 }
