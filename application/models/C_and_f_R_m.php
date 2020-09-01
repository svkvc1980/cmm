<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_and_f_R_m extends CI_Model 
{
	/*CandF Payments number of rows
    Author:Aswini
    Time: 3.PM 20-03-2017 */
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

    public function get_c_and_f_dd_list($search_params)
    {       
        $this->db->select('cf.*,p.name as plant_name,b.name as bank_name');
        $this->db->from('c_and_f_payment cf'); 
        $this->db->join('plant p','p.plant_id=cf.plant_id');            
        $this->db->join('payment_mode pm','pm.pay_mode_id=cf.pay_mode_id');
        $this->db->join('bank b','b.bank_id=cf.bank_id');
        $this->db->join('c_and_f c','c.plant_id=p.plant_id');
        if($search_params['plant_id']!='')
            $this->db->where('cf.plant_id',$search_params['plant_id']);
        if($search_params['pay_mode_id']!='')
            $this->db->where('cf.pay_mode_id',$search_params['pay_mode_id']);
        if($search_params['bank_id']!='')
            $this->db->where('cf.bank_id',$search_params['bank_id']);
        if($search_params['dd_number']!='')
            $this->db->like('cf.dd_number',$search_params['dd_number']);
        if($search_params['from_date']!='')
            $this->db->where('cf.payment_date >=',$search_params['from_date']);
        if($search_params['to_date']!='')
            $this->db->where('cf.payment_date <=',$search_params['to_date']);
        if($search_params['status']!='')
            $this->db->where('cf.status',$search_params['status']);
        $this->db->order_by('b.bank_id ASC');
        $res = $this->db->get();        
        return $res->result_array();
    }

    public function c_and_f_payment_details($search_params)
    {       
        $this->db->select('cf.*,p.name as plant_name,b.name as bank_name');
        $this->db->from('c_and_f_payment cf'); 
        $this->db->join('plant p','p.plant_id=cf.plant_id');            
        $this->db->join('payment_mode pm','pm.pay_mode_id=cf.pay_mode_id');
        $this->db->join('bank b','b.bank_id=cf.bank_id');
        $this->db->join('c_and_f c','c.plant_id=p.plant_id');
        if($search_params['plant_id']!='')
            $this->db->where('cf.plant_id',$search_params['plant_id']);
        if($search_params['pay_mode_id']!='')
            $this->db->where('cf.pay_mode_id',$search_params['pay_mode_id']);
        if($search_params['bank_id']!='')
            $this->db->where('cf.bank_id',$search_params['bank_id']);
        if($search_params['dd_number']!='')
            $this->db->like('cf.dd_number',$search_params['dd_number']);
        if($search_params['from_date']!='')
            $this->db->where('cf.payment_date >=',$search_params['from_date']);
        if($search_params['to_date']!='')
            $this->db->where('cf.payment_date <=',$search_params['to_date']);
        if($search_params['status']!='')
            $this->db->where('cf.status',$search_params['status']);
        $this->db->order_by('b.bank_id ASC');        
        $res = $this->db->get();        
        return $res->result_array();
    }

}