<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tender_process_model extends CI_Model
 {

	//Mounika
    public function tender_total_num_rows($search_params)
    {       
        $this->db->select('m.mtp_oil_id,m.mtp_number,m.tender_date,m.quantity,m.status,l.loose_oil_id,l.name as loose_oil_name,pb.plant_id,p.plant_id,p.name as plant_name');
        $this->db->from('mtp_oil m');
        $this->db->join('loose_oil l', 'm.loose_oil_id=l.loose_oil_id');
        $this->db->join('plant_block pb','m.plant_id=pb.plant_id');
        $this->db->join('plant p','pb.plant_id=p.plant_id');
        if($search_params['mtp_no']!='')
            $this->db->where('m.mtp_number',$search_params['mtp_no']);
        if($search_params['loose_oil_id']!='')
            $this->db->where('l.loose_oil_id',$search_params['loose_oil_id']); 
        if($search_params['plant_id']!='')
            $this->db->where('p.plant_id',$search_params['plant_id']);
        $this->db->order_by('m.mtp_oil_id DESC');
        $res = $this->db->get();
        return $res->num_rows();
    }

    public function tender_results($search_params,$per_page,$current_offset)
    {       
        $this->db->select('m.mtp_oil_id,m.mtp_number,m.tender_date,m.quantity,m.status,l.loose_oil_id,l.name as loose_oil_name,pb.plant_id,p.plant_id,p.name as plant_name');
        $this->db->from('mtp_oil m');
        $this->db->join('loose_oil l', 'm.loose_oil_id=l.loose_oil_id');
        $this->db->join('plant_block pb','m.plant_id=pb.plant_id');
        $this->db->join('plant p','pb.plant_id=p.plant_id');
        if($search_params['mtp_no']!='')
            $this->db->where('m.mtp_number',$search_params['mtp_no']);
        if($search_params['loose_oil_id']!='')
            $this->db->where('l.loose_oil_id',$search_params['loose_oil_id']); 
        if($search_params['plant_id']!='')
            $this->db->where('p.plant_id',$search_params['plant_id']); 
        $this->db->order_by('m.mtp_oil_id DESC');
        $this->db->limit($per_page, $current_offset);
        $res = $this->db->get();
        return $res->result_array();
    }

    public function tender_details($search_params)
    {
       $this->db->select('m.mtp_oil_id,m.mtp_number,m.tender_date,m.quantity,m.status,l.loose_oil_id,l.name as loose_oil_name,pb.plant_id,p.plant_id,p.name as plant_name');
        $this->db->from('mtp_oil m');
        $this->db->join('loose_oil l', 'm.loose_oil_id=l.loose_oil_id');
        $this->db->join('plant_block pb','m.plant_id=pb.plant_id');
        $this->db->join('plant p','pb.plant_id=p.plant_id');
        if($search_params['mtp_no']!='')
            $this->db->where('m.mtp_number',$search_params['mtp_no']);
        if($search_params['loose_oil_id']!='')
            $this->db->where('l.loose_oil_id',$search_params['loose_oil_id']); 
        if($search_params['plant_id']!='')
            $this->db->where('p.plant_id',$search_params['plant_id']); 
        $this->db->order_by('m.mtp_oil_id DESC');
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

   //retriving data from product table
    public function getsupplier()
    { 
        $this->db->select('supplier_id,agency_name');
        $this->db->from('supplier');
        $this->db->where('status',1);
        $this->db->where('type_id',1);
        $res = $this->db->get();
        return $res->result_array();
    }

  //retriving data from broker table
    public function getbroker()
	{ 
		$this->db->select('broker_id,agency_name');
		$this->db->from('broker');
		$this->db->where('status',1);
		$res = $this->db->get();
        return $res->result_array();
    }

    public function get_tender_details($mtp_oil_id)
    {
        $this->db->select('m.mtp_oil_id,m.mtp_number,m.tender_date,m.quantity,m.status,l.loose_oil_id,l.name as loose_oil_name,pb.plant_id,p.plant_id,p.name as plant_name,m.quantity as quantity');
        $this->db->from('mtp_oil m');
        $this->db->join('loose_oil l', 'm.loose_oil_id=l.loose_oil_id');
        $this->db->join('plant_block pb','m.plant_id=pb.plant_id');
        $this->db->join('plant p','pb.plant_id=p.plant_id');
        $this->db->where('m.mtp_oil_id',$mtp_oil_id);
        $res = $this->db->get();
        return $res->row_array();
    }
    
    public function get_add_tender($mtp_oil_id)
    {
        $this->db->select('t.tender_oil_id,t.quoted_price,t.negotiated_price,t.quantity,t.support_document,t.status,b.broker_id,b.agency_name as broker_name,s.supplier_id,s.agency_name as supplier_name,m.mtp_oil_id');
        $this->db->from('tender_oil t');
        $this->db->join('mtp_oil m','t.mtp_oil_id=m.mtp_oil_id');
        $this->db->join('broker b','t.broker_id=b.broker_id');
        $this->db->join('supplier s','t.supplier_id=s.supplier_id');
        $this->db->where('t.mtp_oil_id',$mtp_oil_id);
        $res = $this->db->get();
        return $res->result_array();
    }

    public function get_tender($mtp_oil_id)
    {
    $query='select t1.tender_oil_id as tender_oil_id,t1.quoted_price,t1.negotiated_price,t1.support_document,t1.quantity as offered_qty,t1.status,b.broker_id,b.agency_name as broker_name,s.supplier_id,s.agency_name as supplier_name,m.mtp_oil_id,
            case when t1.negotiated_price is null OR t1.negotiated_price<=0
            then t1.quoted_price 
            else  least(t1.negotiated_price,t1.quoted_price) 
            end as min_quote 
            from tender_oil t1 
            inner join mtp_oil m on t1.mtp_oil_id=m.mtp_oil_id
            inner join broker b on t1.broker_id=b.broker_id
            inner join supplier s on t1.supplier_id=s.supplier_id
            where t1.mtp_oil_id='.$mtp_oil_id.' and t1.status= 1 order by min_quote limit 1 ';
        $res = $this->db->query($query);
        return $res->row_array();
    }

    //retriving data from po type table
    public function gettype()
    { 
        $this->db->select('po_type_id,name');
        $this->db->from('po_type');
        $this->db->where('po_type_id!=',1);
        $this->db->where('status',1);
        $res = $this->db->get();
        return $res->result_array();
    }

    //retriving data from po type table
    public function gettype_ocb()
    { 
        $this->db->select('po_type_id,name');
        $this->db->from('po_type');
        $this->db->where('status',1);
        $res = $this->db->get();
        return $res->result_array();
    }

    public function view_oil_total_num_rows($search_params)
    {       
        $this->db->select('po.po_oil_id,po.po_number,po.po_date,po.quantity,po.unit_price,po.status,l.loose_oil_id,l.name as loose_oil_name,pb.plant_id,p.plant_id,p.name as plant_name,b.broker_id,b.agency_name as broker_name,s.supplier_id,s.agency_name as supplier_name,pt.po_type_id,pt.name');
        $this->db->from('po_oil po');
        $this->db->join('loose_oil l', 'po.loose_oil_id=l.loose_oil_id');
        $this->db->join('plant_block pb','po.plant_id=pb.plant_id');
        $this->db->join('broker b','po.broker_id=b.broker_id');
        $this->db->join('supplier s','po.supplier_id=s.supplier_id');
        $this->db->join('po_type pt','po.po_type_id=pt.po_type_id');
        $this->db->join('plant p','pb.plant_id=p.plant_id');
        if($search_params['po_number']!='')
            $this->db->where('po.po_number',$search_params['po_number']);
        if($search_params['loose_oil_id']!='')
            $this->db->where('l.loose_oil_id',$search_params['loose_oil_id']); 
        if($search_params['plant_id']!='')
            $this->db->where('p.plant_id',$search_params['plant_id']); 
        $this->db->order_by('po.po_oil_id DESC');
        $res = $this->db->get();
        return $res->num_rows();
    }

    public function  view_oil_results($search_params,$per_page,$current_offset)
    {       
            
        $this->db->select('po.po_oil_id,po.po_number,po.po_date,po.quantity,po.unit_price,po.status,l.loose_oil_id,l.name as loose_oil_name,pb.plant_id,p.plant_id,p.name as plant_name,b.broker_id,b.agency_name as broker_name,s.supplier_id,s.agency_name as supplier_name,pt.po_type_id,pt.name,po.mtp_oil_id as mtp_oil_id');
        $this->db->from('po_oil po');
        $this->db->join('loose_oil l', 'po.loose_oil_id=l.loose_oil_id');
        $this->db->join('plant_block pb','po.plant_id=pb.plant_id');
        $this->db->join('broker b','po.broker_id=b.broker_id');
        $this->db->join('supplier s','po.supplier_id=s.supplier_id');
        $this->db->join('po_type pt','po.po_type_id=pt.po_type_id');
        $this->db->join('plant p','pb.plant_id=p.plant_id');
        if($search_params['po_number']!='')
            $this->db->where('po.po_number',$search_params['po_number']);
        if($search_params['loose_oil_id']!='')
            $this->db->where('l.loose_oil_id',$search_params['loose_oil_id']); 
        if($search_params['plant_id']!='')
            $this->db->where('p.plant_id',$search_params['plant_id']);
        $this->db->order_by('po.po_oil_id DESC');
        $this->db->limit($per_page, $current_offset);
        $res = $this->db->get();
        return $res->result_array();
    }
    public function get_latest_po_details($loose_oil_id)
    {
       $query='SELECT * FROM po_oil po where po.created_time=(SELECT max(p1.created_time) from po_oil p1 where p1.loose_oil_id='.$loose_oil_id.')';
        $res=$this->db->query($query);
        return $res->row_array();
    }
  
   public function get_mtp_oil_quantity($mtp_oil_id)
   {
      $this->db->select('quantity');
      $this->db->from('mtp_oil');
      $this->db->where('mtp_oil_id',$mtp_oil_id);
      $query=$this->db->get();
      $res=$query->row_array();
      return $res['quantity'];
   }
    
   public function get_po_generated_quantity($mtp_oil_id)
   {
      $this->db->select('sum(quantity) as received_qty');
      $this->db->from('po_oil');
      $this->db->where('mtp_oil_id',$mtp_oil_id);
      $query=$this->db->get();
      $res=$query->row_array();
      return $res['received_qty'];
   }

   public function get_existed_broker_tenders_for_po_oil($mtp_oil_id)
   {
        $this->db->select('b.broker_id,b.agency_name');
        $this->db->from('tender_oil t');
        $this->db->join('broker b','t.broker_id=b.broker_id');
        $this->db->where('t.mtp_oil_id',$mtp_oil_id);
        $this->db->group_by('t.broker_id');
        $res = $this->db->get();
        return $res->result_array();
   }

   public function get_existed_supplier_tenders_for_po_oil($mtp_oil_id)
   {
        $this->db->select('s.supplier_id,s.agency_name');
        $this->db->from('tender_oil t');
        $this->db->join('supplier s','t.supplier_id=s.supplier_id');
        $this->db->where('t.mtp_oil_id',$mtp_oil_id);
        $this->db->group_by('t.supplier_id');
        $res = $this->db->get();
        return $res->result_array();
   }
}