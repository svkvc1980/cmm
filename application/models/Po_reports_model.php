<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Po_reports_model extends CI_Model
{
    //Mounika
/*
public function get()
    {
        $qry = 'SELECT pm_id FROM  packing_material
         WHERE pm_group_id IN (1) AND STATUS =1 ';
         $res = $this->db->query($qry);
         echo $res->num_rows().'pp';
         echo '<pre>';
         //print_r($res->result_array()).'<br>';
         //echo implode(',',$res->result_array());

         foreach ($res->result_array() as $key => $value) {
             $d[] = $value['pm_id'];
         }
         echo implode(',',$d);

         exit;
    }*/
    public function loose_oil_total_num_rows($search_params)
    {       
        $this->db->select('po.po_oil_id,po.po_number,po.po_date,po.loose_oil_id,po.supplier_id,po.broker_id,po.plant_id,po.status,l.loose_oil_id,l.name as loose_name,b.broker_id,b.agency_name as broker_name,s.supplier_id,s.agency_name as supplier_name,p.plant_id,p.name as plant_name');
        $this->db->from('po_oil po');
        $this->db->join('broker b', 'po.broker_id=b.broker_id');
        $this->db->join('loose_oil l', 'po.loose_oil_id=l.loose_oil_id');
        $this->db->join('supplier s', 'po.supplier_id=s.supplier_id');
        $this->db->join('plant_block pb','po.plant_id=pb.plant_id');
        $this->db->join('plant p','pb.plant_id=p.plant_id');
        if($search_params['po_number']!='')
            $this->db->where('po.po_number',$search_params['po_number']);
        if($search_params['start_date']!='')
            $this->db->where('po.po_date >=',$search_params['start_date']);
        if($search_params['end_date']!='')
            $this->db->where('po.po_date <=',$search_params['end_date']);
        if($search_params['status']!='')
            $this->db->where('po.status',$search_params['status']);
        if($search_params['loose_oil_id']!='')
            $this->db->where('l.loose_oil_id',$search_params['loose_oil_id']); 
        if($search_params['plant_id']!='')
            $this->db->where('p.plant_id',$search_params['plant_id']);
        if($search_params['broker_id']!='')
            $this->db->where('b.broker_id',$search_params['broker_id']);
        if($search_params['supplier_id']!='')
            $this->db->where('s.supplier_id',$search_params['supplier_id']);
        $this->db->order_by('po.po_oil_id DESC');
        $res = $this->db->get();
        return $res->num_rows();
    }
    
    public function loose_oil_results($search_params,$per_page,$current_offset)
    {       
        $this->db->select('po.po_oil_id,po.po_number,po.po_date,po.loose_oil_id,po.supplier_id,po.quantity as quantity,po.unit_price as unit_price ,po.broker_id,po.plant_id,po.status,l.loose_oil_id,l.name as loose_name,b.broker_id,b.agency_name as broker_name,s.supplier_id,s.agency_name as supplier_name,p.plant_id,p.name as plant_name');
        $this->db->from('po_oil po');
        $this->db->join('broker b', 'po.broker_id=b.broker_id');
        $this->db->join('loose_oil l', 'po.loose_oil_id=l.loose_oil_id');
        $this->db->join('supplier s', 'po.supplier_id=s.supplier_id');
        $this->db->join('plant_block pb','po.plant_id=pb.plant_id');
        $this->db->join('plant p','pb.plant_id=p.plant_id');
        if($search_params['po_number']!='')
            $this->db->where('po.po_number',$search_params['po_number']);
        if($search_params['start_date']!='')
            $this->db->where('po.po_date >=',$search_params['start_date']);
        if($search_params['end_date']!='')
            $this->db->where('po.po_date <=',$search_params['end_date']);
        if($search_params['status']!='')
{
         if($search_params['status'] == 1)
            $this->db->where('po.status<=',2);
         else
           $this->db->where('po.status',$search_params['status']);     
}
        if($search_params['loose_oil_id']!='')
            $this->db->where('l.loose_oil_id',$search_params['loose_oil_id']); 
        if($search_params['plant_id']!='')
            $this->db->where('p.plant_id',$search_params['plant_id']);
        if($search_params['broker_id']!='')
            $this->db->where('b.broker_id',$search_params['broker_id']);
        if($search_params['supplier_id']!='')
            $this->db->where('s.supplier_id',$search_params['supplier_id']);
        $this->db->order_by('po.po_number DESC');
        $this->db->limit($per_page, $current_offset);
        $res = $this->db->get();
        return $res->result_array();
    }

    //retriving data from loose table
    public function getloose_oil()
    { 
        $this->db->select('loose_oil_id,name as loose_name');
        $this->db->from('loose_oil');
        $this->db->where('status',1);
        $res = $this->db->get();
        return $res->result_array();
    }

    public function get_plant()
    {   
        $this->db->select('pb.plant_id as plant_id,pb.block_id block_id,p.name as plant_name');
        $this->db->from('plant_block pb');
        $this->db->join('plant p','pb.plant_id=p.plant_id');
        $this->db->where('pb.block_id',2);
        $res=$this->db->get();
        return $res->result_array();
    }
    //retriving data from broker table
    public function get_broker()
    {
        $this->db->select('broker_id,agency_name as broker_name');
        $this->db->from('broker b');
        $this->db->where('status',1);
        $res = $this->db->get();
        return $res->result_array();
    }
    //retriving data from supplier table
    public function get_supplier()
    {
        $this->db->select('supplier_id,agency_name as supplier_name');
        $this->db->from('supplier s');
        $this->db->join('supplier_type st','s.type_id=st.type_id');
        $this->db->where('st.type_id',1);
        $res = $this->db->get();
        return $res->result_array();
    }
    
    //retriving data from PO table for PDF download
    public function print_loose_oil($po_oil_id)
    {
        $this->db->select('po.po_oil_id,po.po_number,po.po_date,po.unit_price,po.quantity as quoted_qty,sum( (to.gross-to.tier)/1000) as received_qty,po.status,l.loose_oil_id,l.name as loose_name,pt.po_type_id,pt.name as type_name,s.supplier_id,s.agency_name as supplier_name,s.supplier_code,b.broker_id,b.agency_name as broker_name,b.broker_code,p.plant_id,p.name as plant_name,m.mtp_oil_id,m.mtp_number');
        $this->db->from('po_oil po');
        $this->db->join('loose_oil l','po.loose_oil_id=l.loose_oil_id');
        $this->db->join('po_oil_tanker pot','po.po_oil_id=pot.po_oil_id');
        $this->db->join('tanker_oil to','pot.tanker_id=to.tanker_id');
        $this->db->join('broker b','po.broker_id=b.broker_id');
        $this->db->join('supplier s','po.supplier_id=s.supplier_id');
        $this->db->join('plant p','po.plant_id=p.plant_id');
        $this->db->join('mtp_oil m','po.mtp_oil_id=m.mtp_oil_id','left');
        $this->db->join('po_type pt','po.po_type_id=pt.po_type_id');
        $this->db->where('po.po_oil_id',$po_oil_id);
        $res=$this->db->get();
        return $res->row_array();
    }

    public function get_loose_oil_reports($search_params)
    {
       $this->db->select('po.po_oil_id,po.po_number,po.po_date,po.unit_price,po.quantity as quoted_qty,sum( (to.gross-to.tier)/1000) as received_qty,po.status,l.loose_oil_id,l.name as loose_name,pt.po_type_id,pt.name as type_name,s.supplier_id,s.agency_name as supplier_name,s.supplier_code,b.broker_id,b.agency_name as broker_name,b.broker_code,p.plant_id,p.short_name as plant_name,m.mtp_oil_id,m.mtp_number,l.short_name as loose_short_name');
        $this->db->from('po_oil po');
        $this->db->join('loose_oil l','po.loose_oil_id=l.loose_oil_id');
        $this->db->join('po_oil_tanker pot','po.po_oil_id=pot.po_oil_id','left');
        $this->db->join('tanker_oil to','pot.tanker_id=to.tanker_id','left');
        $this->db->join('broker b','po.broker_id=b.broker_id');
        $this->db->join('supplier s','po.supplier_id=s.supplier_id');
        $this->db->join('plant p','po.plant_id=p.plant_id');
        $this->db->join('mtp_oil m','po.mtp_oil_id=m.mtp_oil_id','left');
        $this->db->join('po_type pt','po.po_type_id=pt.po_type_id');
       if($search_params['po_number']!='')
            $this->db->where('po.po_number',$search_params['po_number']);
        if($search_params['start_date']!='')
            $this->db->where('po.po_date >=',$search_params['start_date']);
        if($search_params['end_date']!='')
            $this->db->where('po.po_date <=',$search_params['end_date']);
        if($search_params['status']!='')
        {   
            if($search_params['status']==1)
            {
                $this->db->where('po.status <=',2);
            }
            else if($search_params['status']==3)
            {
                $this->db->where('po.status',3);
            }
             else if($search_params['status']==10)
            {
                $this->db->where('po.status',10);
            }
        }

        if($search_params['loose_oil_id']!='')
            $this->db->where('l.loose_oil_id',$search_params['loose_oil_id']); 
        if($search_params['plant_id']!='')
            $this->db->where('p.plant_id',$search_params['plant_id']);
        if($search_params['broker_id']!='')
            $this->db->where('b.broker_id',$search_params['broker_id']);
        if($search_params['supplier_id']!='')
            $this->db->where('s.supplier_id',$search_params['supplier_id']);
        $this->db->group_by('po.po_oil_id');
        $res = $this->db->get();
        return $res->result_array();
    }

     public function pm_total_num_rows($search_params)
    {       
       $this->db->select('pm.po_pm_id,pm.po_number,pm.po_date,pm.pm_id,pm.supplier_id,pm.plant_id,pm.status,pa.pm_id,pa.name as packing_name,s.supplier_id,s.agency_name as supplier_name,p.plant_id,p.name as plant_name');
       $this->db->from('po_pm pm');
       $this->db->join('packing_material pa','pm.pm_id=pa.pm_id');
      // $this->db->join('broker b','pm.broker_id=b.broker_id');
       $this->db->join('supplier s','pm.supplier_id=s.supplier_id');
       $this->db->join('plant_block pb','pm.plant_id=pb.plant_id');
       $this->db->join('plant p','pb.plant_id=p.plant_id');
        if($search_params['po_number']!='')
            $this->db->where('pm.po_number',$search_params['po_number']);
        if($search_params['start_date']!='')
            $this->db->where('pm.po_date >',$search_params['start_date']);
        if($search_params['end_date']!='')
            $this->db->where('pm.po_date <=',$search_params['end_date']);
        if($search_params['status']!='')
        {
            if($search_params['status']==1)
            {
                $this->db->where('pm.status <=',2);
            }
            else 
            {
                $this->db->where('pm.status',$search_params['status']);
            }
           
            
        }
        if($search_params['pm_id']!='')
            $this->db->where('pa.pm_id',$search_params['pm_id']); 
        if($search_params['plant_id']!='')
            $this->db->where('p.plant_id',$search_params['plant_id']);
        /*if($search_params['broker_id']!='')
            $this->db->where('b.broker_id',$search_params['broker_id']);*/
        if($search_params['supplier_id']!='')
            $this->db->where('s.supplier_id',$search_params['supplier_id']);
        $this->db->order_by('pm.po_pm_id DESC');
        $res = $this->db->get();
        return $res->num_rows();
    }
    

public function pm_results($search_params,$per_page,$current_offset)
    {       
         $this->db->select('pm.po_pm_id,pm.po_number,pm.po_date,pm.pm_id,pm.supplier_id,pm.plant_id,pm.status,pa.pm_id,pa.name as packing_name,s.supplier_id,s.agency_name as supplier_name,p.plant_id,p.name as plant_name');
       $this->db->from('po_pm pm');
       $this->db->join('packing_material pa','pm.pm_id=pa.pm_id');
       //$this->db->join('broker b','pm.broker_id=b.broker_id');
       $this->db->join('supplier s','pm.supplier_id=s.supplier_id');
       $this->db->join('plant_block pb','pm.plant_id=pb.plant_id');
       $this->db->join('plant p','pb.plant_id=p.plant_id');
        if($search_params['po_number']!='')
            $this->db->where('pm.po_number',$search_params['po_number']);
        if($search_params['start_date']!='')
            $this->db->where('pm.po_date >',$search_params['start_date']);
        if($search_params['end_date']!='')
            $this->db->where('pm.po_date <=',$search_params['end_date']);
        if($search_params['status']!='')
        {
            if($search_params['status']==1)
            {
                $this->db->where('pm.status <=',2);
            }
            else 
            {
                $this->db->where('pm.status',$search_params['status']);
            }
           
            
        }
        if($search_params['pm_id']!='')
            $this->db->where('pa.pm_id',$search_params['pm_id']); 
        if($search_params['plant_id']!='')
            $this->db->where('p.plant_id',$search_params['plant_id']);
        if($search_params['supplier_id']!='')
            $this->db->where('s.supplier_id',$search_params['supplier_id']);
        $this->db->order_by('pm.po_pm_id DESC');
        $this->db->limit($per_page, $current_offset);
        $res = $this->db->get();
        return $res->result_array();
    }
    

    //retriving data from loose table
    public function get_packing_material()
    { 
        $this->db->select('pm_id,name as packing_name');
        $this->db->from('packing_material');
        $this->db->where('status',1);
        $res = $this->db->get();
        return $res->result_array();
    }
     //retriving data from supplier table
    public function get_pm_supplier()
    {
        $this->db->select('supplier_id,agency_name as supplier_name');
        $this->db->from('supplier s');
        $this->db->join('supplier_type st','s.type_id=st.type_id');
        $this->db->where('st.type_id',2);
        $res = $this->db->get();
        return $res->result_array();
    }
  
    //retriving data from PO table for PDF download
    public function print_pm($po_pm_id)
    {
        $this->db->select('pm.po_pm_id,pm.po_number,pm.po_date,pm.unit_price,pm.quantity as pp_quantity,pm.status,pa.pm_id,pa.name as packing_name,pt.po_type_id,pt.name as type_name,s.supplier_id,s.agency_name as supplier_name,s.supplier_code,p.plant_id,p.name as plant_name,m.mtp_pm_id,m.mtp_number,pa.pm_category_id as pm_category_id');
        $this->db->from('po_pm pm');
        $this->db->join('packing_material pa','pm.pm_id=pa.pm_id');
        $this->db->join('supplier s','pm.supplier_id=s.supplier_id');
        $this->db->join('plant p','pm.plant_id=p.plant_id');
        $this->db->join('mtp_pm m','pm.mtp_pm_id=m.mtp_pm_id','left');
        $this->db->join('po_type pt','pm.po_type_id=pt.po_type_id');
        $this->db->where('po_pm_id',$po_pm_id);
        $res=$this->db->get();
        return $res->row_array(); 
    }

     public function get_pm_received_qty($po_pm_id,$pm_category_id)
    {
       if($pm_category_id==get_film_cat_id())
       {
           $this->db->select('sum(mpf.received_quantity) as pm_received_qty ');
           $this->db->from('po_pm_tanker ppt');
           $this->db->join('tanker_pm tp','ppt.tanker_id=tp.tanker_id');
           $this->db->join('mrr_pm mp','tp.tanker_pm_id=mp.tanker_pm_id');
           $this->db->join('mrr_pm_film mpf','mp.mrr_pm_id=mpf.mrr_pm_id');
           $this->db->where('ppt.po_pm_id',$po_pm_id);
           $res=$this->db->get();
           $result=$res->row_array();
           return $result['pm_received_qty'];
       }
       else
       {
           $this->db->select('sum(mp.received_qty) as pm_received_qty ');
           $this->db->from('po_pm_tanker ppt');
           $this->db->join('tanker_pm tp','ppt.tanker_id=tp.tanker_id');
           $this->db->join('mrr_pm mp','tp.tanker_pm_id=mp.tanker_pm_id');
           $this->db->where('ppt.po_pm_id',$po_pm_id);
           $res=$this->db->get();
           $result=$res->row_array();
           return $result['pm_received_qty'];
       }
    }

    public function get_pm_reports($search_params)
    {
        $this->db->select('pm.po_pm_id,pm.po_number,pm.po_date,pm.unit_price,pm.quantity as pp_quantity,pm.status,pa.pm_id,pa.name as packing_name,pt.po_type_id,pt.name as type_name,s.supplier_id,s.agency_name as supplier_name,s.supplier_code,p.plant_id,p.short_name as plant_name,m.mtp_pm_id,m.mtp_number,pa.pm_category_id as pm_category_id, pu.name as unit');
        $this->db->from('po_pm pm');
        $this->db->join('packing_material pa','pm.pm_id=pa.pm_id');
        $this->db->join('supplier s','pm.supplier_id=s.supplier_id');
        $this->db->join('plant p','pm.plant_id=p.plant_id');
        $this->db->join('mtp_pm m','pm.mtp_pm_id=m.mtp_pm_id','left');
        $this->db->join('po_type pt','pm.po_type_id=pt.po_type_id');
        $this->db->join('packing_material_category pmc','pmc.pm_category_id = pa.pm_category_id');
        $this->db->join('pm_unit pu','pmc.pm_unit = pu.pm_unit');
        if($search_params['po_number']!='')
            $this->db->where('pm.po_number',$search_params['po_number']);
        if($search_params['start_date']!='')
            $this->db->where('pm.po_date >=',$search_params['start_date']);
        if($search_params['end_date']!='')
            $this->db->where('pm.po_date <=',$search_params['end_date']);
        if($search_params['status']!='')
        {
            if($search_params['status']==1)
            {
                $this->db->where('pm.status<=',2);
            }
            else{
               $this->db->where('pm.status',$search_params['status']); 
            }
            
        }
        if($search_params['pm_id']!='')
            $this->db->where('pa.pm_id',$search_params['pm_id']); 
        if($search_params['plant_id']!='')
            $this->db->where('p.plant_id',$search_params['plant_id']);
        if($search_params['supplier_id']!='')
            $this->db->where('s.supplier_id',$search_params['supplier_id']);
        $this->db->order_by('pa.pm_id,pm.po_date asc');
        $res=$this->db->get();
        return $res->result_array(); 
    }

    public function get_pm_received_qty_report($po_pm_id,$pm_category_id)
    {
       if($pm_category_id==get_film_cat_id())
       {
           $this->db->select('sum(mpf.received_quantity) as pm_received_qty ');
           $this->db->from('po_pm_tanker ppt');
           $this->db->join('tanker_pm tp','ppt.tanker_id=tp.tanker_id');
           $this->db->join('mrr_pm mp','tp.tanker_pm_id=mp.tanker_pm_id');
           $this->db->join('mrr_pm_film mpf','mp.mrr_pm_id=mpf.mrr_pm_id','left');
           $this->db->where('ppt.po_pm_id',$po_pm_id);
           $res=$this->db->get();
           $result=$res->row_array();
           return $result['pm_received_qty'];
       }
       else
       {
           $this->db->select('sum(mp.received_qty) as pm_received_qty ');
           $this->db->from('po_pm_tanker ppt');
           $this->db->join('tanker_pm tp','ppt.tanker_id=tp.tanker_id');
           $this->db->join('mrr_pm mp','tp.tanker_pm_id=mp.tanker_pm_id');
           $this->db->where('ppt.po_pm_id',$po_pm_id);
           $res=$this->db->get();
           $result=$res->row_array();
           return $result['pm_received_qty'];
       }
    }
}    