<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pm_mrr_m extends CI_Model
 {
    /**
    * get tanker details based on tanker number,purchase order number
    * author: prasad , created on: 17th feb 2017 12:39 PM, updated on: --
    * params: $tanker_number(int),$po_number(int)
    * return: $tanker details(row_array),$count(int)
    **/
    public function get_pm_tanker_details($tanker_number,$po_number)
    { 
        $plant_id = $this->session->userdata('ses_plant_id');
        $type_id=get_pm_tank_id();
        $this->db->select('tr.*');
        $this->db->from('po_pm_tanker ppt');
        $this->db->join('tanker_register tr','ppt.tanker_id=tr.tanker_id'); 
        $this->db->join('po_pm pp','ppt.po_pm_id=pp.po_pm_id'); 
        $this->db->where('tr.tanker_in_number',$tanker_number);
        $this->db->where('tr.plant_id',$plant_id);
        $this->db->where('tr.tanker_type_id',$type_id);
        $this->db->where('pp.po_number',$po_number);
        $this->db->where('pp.status!=',3);
        $res=$this->db->get();
        return array($res->num_rows(),$res->row_array());
    }

    /**
    * get mrr pm details based on tanker id linked to purchase order
    * author: prasad , created on: 17th feb 2017 3:30 PM, updated on: --
    * params: $tanker_id(int)
    * return: $mrr_results(row_array)
    **/
    public function get_mrr_pm_details($tanker_id)
    {
        $this->db->select('ppt.po_pm_id as po_pm_id,ppt.tanker_id as tanker_id,pp.quantity as pp_quantity,tr.invoice_number as invoice_number,tr.vehicle_number as vehicle_number,tr.tanker_in_number as tanker_number,tr.dc_number as dc_number,(t.gross -t.tier) as net_weight,(t.invoice_gross-t.invoice_tier) as invoice_net_weight,t.gross as gross_weight,t.tier as tier_weight,t.tanker_pm_id as tanker_pm_id,pp.po_number as po_number,pp.quantity as quantity,pp.po_date as po_date,pp.unit_price as unit_price,pm.pm_id as pm_id,pm.name as packing_material_name ,pp.supplier_id as supplier_id,s.agency_name as supplier_name,pp.plant_id as plant_id,p.name as plant_name,pt.name as purchase_type,pm.pm_category_id as pm_category_id, t.invoice_quantity');
        $this->db->from('po_pm_tanker ppt');
        $this->db->join('tanker_register tr','ppt.tanker_id=tr.tanker_id');
        $this->db->join('tanker_pm t','tr.tanker_id=t.tanker_id');
        $this->db->join('po_pm pp','ppt.po_pm_id=pp.po_pm_id');
        $this->db->join('packing_material pm','pp.pm_id=pm.pm_id');
       // $this->db->join('broker b','pp.broker_id=b.broker_id');
        $this->db->join('supplier s','pp.supplier_id=s.supplier_id');
        $this->db->join('plant p','pp.plant_id=p.plant_id'); 
        $this->db->join('po_type as pt','pp.po_type_id =pt.po_type_id');
        //$this->db->join('mtp_oil mo','po.mtp_oil_id=mo.mtp_oil_id');
        $this->db->where('ppt.tanker_id',$tanker_id);
        $res=$this->db->get();
        return $res->row_array();
    }

  
     /**
    * get mrr details from packing material mrr based on tanker pm id
    * author: prasad , created on: 20th feb 2017 3:30 PM, updated on: --
    * params: $dat(array)
    * return: $insert id(int)
    **/
    public function insert_mrr_pm_details($dat)
    {
        $this->db->from('mrr_pm ');
        $this->db->where('tanker_pm_id',$dat['tanker_pm_id']);
        $res=$this->db->get();
        $res1=$res->row_array();
        if($res->num_rows()>0)
        {
           $this->db->update('mrr_pm',array('remarks'=>$dat['remarks'],'folio_number'=>$dat['folio_number'],'ledger_number'=>$dat['ledger_number'],'received_qty'=>$dat['received_qty']),array('tanker_pm_id'=>$dat['tanker_pm_id']));
           return $res1['mrr_pm_id'];
        }
        else
        {
            $this->db->insert('mrr_pm',$dat);
            return $this->db->insert_id();
        }
    }

    public function get_pm_mrr_list_total_num_rows($search_params)
    {       
        $this->db->select('*');
        $this->db->from('mrr_pm m');
        $this->db->join('tanker_pm tp','m.tanker_pm_id=tp.tanker_pm_id');
        $this->db->join('tanker_register tr','tp.tanker_id=tr.tanker_id');
        $this->db->join('po_pm_tanker ppt','tr.tanker_id=ppt.tanker_id');
        $this->db->join('po_pm pp','ppt.po_pm_id=pp.po_pm_id');
        $this->db->join('packing_material mp','pp.pm_id=mp.pm_id');
        $this->db->join('plant p','pp.plant_id=p.plant_id'); 
        if($search_params['po_number']!='')
            $this->db->where('pp.po_number',$search_params['po_number']);
        if($search_params['mrr_number']!='')
            $this->db->where('m.mrr_number',$search_params['mrr_number']); 
        if($search_params['start_date']!='')
            $this->db->where('m.mrr_date>=',format_date($search_params['start_date'],'Y-m-d'));
        if($search_params['end_date']!='')
            $this->db->where('m.mrr_date<=',format_date($search_params['end_date'],'Y-m-d'));
        if($search_params['tanker_in_number']!='')
            $this->db->where('tr.tanker_in_number',$search_params['tanker_in_number']);
        $this->db->order_by('m.mrr_pm_id DESC');
        $res = $this->db->get();
        return $res->num_rows();
    }

    public function view_pm_mrr_list_results($search_params,$per_page,$current_offset)
    {       
        $this->db->select('m.mrr_pm_id as mrr_pm_id,m.mrr_number as mrr_number,tr.tanker_in_number as tanker_in_number,pp.po_number as po_number,p.short_name as plant_name,mp.name as packing_material,m.mrr_date as mrr_date, pu.name as unit, m.received_qty, mpf.no_of_rolls, mpf.core_carton_weight, mp.pm_category_id,mpf.received_quantity as film_received_qty');
        $this->db->from('mrr_pm m');
        $this->db->join('tanker_pm tp','m.tanker_pm_id=tp.tanker_pm_id');
        $this->db->join('tanker_register tr','tp.tanker_id=tr.tanker_id');
        $this->db->join('po_pm_tanker ppt','tr.tanker_id=ppt.tanker_id');
        $this->db->join('po_pm pp','ppt.po_pm_id=pp.po_pm_id');
        $this->db->join('packing_material mp','pp.pm_id=mp.pm_id');
        $this->db->join('packing_material_category pmc','pmc.pm_category_id = mp.pm_category_id');
        $this->db->join('pm_unit pu','pu.pm_unit = pmc.pm_unit');
        $this->db->join('plant p','pp.plant_id=p.plant_id');
        $this->db->join('mrr_pm_film mpf','mpf.mrr_pm_id = m.mrr_pm_id','left');
        if($search_params['po_number']!='')
            $this->db->where('pp.po_number',$search_params['po_number']);
        if($search_params['mrr_number']!='')
            $this->db->where('m.mrr_number',$search_params['mrr_number']);
        if($search_params['start_date']!='')
            $this->db->where('m.mrr_date>=',format_date($search_params['start_date'],'Y-m-d'));
        if($search_params['end_date']!='')
            $this->db->where('m.mrr_date<=',format_date($search_params['end_date'],'Y-m-d')); 
        if($search_params['tanker_in_number']!='')
            $this->db->where('tr.tanker_in_number',$search_params['tanker_in_number']);
        $this->db->order_by('m.mrr_pm_id DESC');
        $this->db->limit($per_page, $current_offset);
        $res = $this->db->get();
        return $res->result_array();
    }

     public function print_mrr_pm_list_results($mrr_pm_id)
    {
         $this->db->select('m.mrr_pm_id as mrr_pm_id,m.mrr_number as mrr_number,po.quantity as pp_quantity,(t.invoice_gross-t.invoice_tier) as invoice_net_weight,m.received_qty as rec_qty,pot.po_pm_id as po_pm_id,pot.tanker_id as tanker_id,tr.invoice_number as invoice_number,tr.vehicle_number as vehicle_number,tr.tanker_in_number as tanker_number,tr.dc_number as dc_number,(t.gross -t.tier) as net_weight,t.gross as gross_weight,t.tier as tier_weight,t.tanker_pm_id as tanker_pm_id,po.po_number as po_number,po.quantity as quantity,po.po_date as po_date,po.unit_price as unit_price,lo.pm_id as pm_id,lo.name as pm_name,po.supplier_id as supplier_id,s.agency_name as supplier_name,po.plant_id as plant_id,p.name as plant_name,pt.name as purchase_type,m.ledger_number as ledger_number,m.folio_number as folio_number,m.remarks as remarks,lo.pm_category_id as pm_category_id,t.invoice_quantity as invoice_quantity,m.mrr_date as mrr_date');
        $this->db->from('mrr_pm m');
        $this->db->join('tanker_pm t','m.tanker_pm_id=t.tanker_pm_id');
        $this->db->join('tanker_register tr','t.tanker_id=tr.tanker_id');
        //$this->db->join('oil_tank ot','m.oil_tank_id=ot.oil_tank_id');
        $this->db->join('po_pm_tanker pot','tr.tanker_id=pot.tanker_id');
        $this->db->join('po_pm po','pot.po_pm_id=po.po_pm_id');
        $this->db->join('packing_material lo','po.pm_id=lo.pm_id');
        //$this->db->join('broker b','po.broker_id=b.broker_id');
        $this->db->join('supplier s','po.supplier_id=s.supplier_id');
        $this->db->join('plant p','po.plant_id=p.plant_id'); 
        $this->db->join('po_type as pt','po.po_type_id =pt.po_type_id'); 
        $this->db->where('mrr_pm_id',$mrr_pm_id);
        $this->db->order_by('lo.pm_group_id ASC, lo.pm_id ASC, m.mrr_date ASC');
        $res=$this->db->get();
        return $res->row_array();
    }

    //retreving weight in stock list
    public function get_receipt_weight_stock_list($mrr_results)
    {
        $this->db->select('*');
        $this->db->from('pm_stock_balance');
        $this->db->where('plant_id',$mrr_results['plant_id']);
        $this->db->where('pm_id',$mrr_results['pm_id']);
        //$this->db->where('on_date = CURDATE()');
        $this->db->where('closing_balance is null');
        $this->db->order_by('on_date','desc');
        $this->db->limit(1);
        $res=$this->db->get();
        return $res->row_array();
    }

    public function update_plant_pm($plant_pm)
    {
        $qry = "INSERT INTO plant_pm(plant_id,pm_id,quantity,updated_time) 
                    VALUES (".$plant_pm['plant_id'].",".$plant_pm['pm_id'].",".$plant_pm['quantity'].",'".date('Y-m-d H:i:s')."')  
                    ON DUPLICATE KEY UPDATE quantity = quantity+VALUES(quantity),updated_time = VALUES(updated_time) ;";
        $this->db->query($qry);
    }
     public function update_plant_film_stock($dat2)
    {
        $this->db->select('*');
        $this->db->from('plant_film_stock');
        $this->db->where('plant_id',$dat2['plant_id']);
        $this->db->where('pm_id',$dat2['pm_id']);
        $this->db->where('micron_id',$dat2['micron_id']);
        $res=$this->db->get();
        if($res->num_rows()>0)
        { 
            /*$results=$res->row_array();
            $quantity=$results['quantity']+$dat2['quantity'];*/
            $query='update plant_film_stock set quantity=quantity+"'.$dat2['quantity'].'" where plant_id="'.$dat2['plant_id'].'" and pm_id="'.$dat2['pm_id'].'" and micron_id="'.$dat2['micron_id'].'"';
            $this->db->query($query);
        }
        else
        {
            $this->Common_model->insert_data('plant_film_stock',$dat2);
        }
    }
    public function get_pm_received_qty($po_pm_id,$pm_category_id)
    {
       if($pm_category_id==get_film_cat_id())
       {
           $this->db->select('sum(mp.received_qty-(mpf.no_of_rolls*mpf.core_carton_weight)) as pm_received_qty ');
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
    public function get_mrr_received_qty($mrr_pm_id,$pm_category_id)
    {
        if($pm_category_id==get_film_cat_id())
       {
           $this->db->select('mpf.received_quantity as pm_received_qty ');
           $this->db->from('mrr_pm mp');
           $this->db->join('mrr_pm_film mpf','mp.mrr_pm_id=mpf.mrr_pm_id');
           $this->db->where('mp.mrr_pm_id',$mrr_pm_id);
           $res=$this->db->get();
           $result=$res->row_array();
           return $result['pm_received_qty'];
       }
       else
       {
           $this->db->select('mp.received_qty as pm_received_qty ');
           $this->db->from('mrr_pm mp');
           $this->db->where('mp.mrr_pm_id',$mrr_pm_id);
           $res=$this->db->get();
           $result=$res->row_array();
           return $result['pm_received_qty'];
       }
    }

    public function print_mrr_pm_list($search_params)
    {       
        $this->db->select('m.mrr_pm_id as mrr_pm_id,m.mrr_number as mrr_number,tr.tanker_in_number as tanker_in_number,pp.po_number as po_number,p.short_name as plant_name,mp.name as packing_material,m.mrr_date as mrr_date, pu.name as unit, m.received_qty, mpf.no_of_rolls, mpf.core_carton_weight, mp.pm_category_id,pp.unit_price, s.agency_name as supplier, pplt.test_number,mpf.received_quantity as film_received_qty');
        $this->db->from('mrr_pm m');
        $this->db->join('tanker_pm tp','m.tanker_pm_id=tp.tanker_pm_id');
        $this->db->join('tanker_register tr','tp.tanker_id=tr.tanker_id');
        $this->db->join('po_pm_tanker ppt','tr.tanker_id=ppt.tanker_id');
        $this->db->join('po_pm pp','ppt.po_pm_id=pp.po_pm_id');
        $this->db->join('packing_material mp','pp.pm_id=mp.pm_id');
        $this->db->join('packing_material_category pmc','pmc.pm_category_id = mp.pm_category_id');
        $this->db->join('pm_unit pu','pu.pm_unit = pmc.pm_unit');
        $this->db->join('plant p','pp.plant_id=p.plant_id');
        $this->db->join('mrr_pm_film mpf','mpf.mrr_pm_id = m.mrr_pm_id','left');
        $this->db->join('supplier s','s.supplier_id = pp.supplier_id');
        $this->db->join('po_pm_lab_test pplt','pplt.tanker_id = tr.tanker_id');
        if($search_params['po_number']!='')
            $this->db->where('pp.po_number',$search_params['po_number']);
        if($search_params['mrr_number']!='')
            $this->db->where('m.mrr_number',$search_params['mrr_number']);
        if($search_params['start_date']!='')
            $this->db->where('m.mrr_date>=',format_date($search_params['start_date'],'Y-m-d'));
        if($search_params['end_date']!='')
            $this->db->where('m.mrr_date<=',format_date($search_params['end_date'],'Y-m-d')); 
        if($search_params['tanker_in_number']!='')
            $this->db->where('tr.tanker_in_number',$search_params['tanker_in_number']);
        $this->db->order_by('mp.pm_group_id ASC, mp.pm_id ASC, m.mrr_date ASC');
        $res = $this->db->get();
        return $res->result_array();
    }
    
     public function get_tanker_id($tanker_number)
    {
        $this->db->select('tanker_id');
        $this->db->from('tanker_register');
        $this->db->where('tanker_in_number',$tanker_number);
        $this->db->order_by('tanker_id','DESC');
        $this->db->limit(1);
        $res = $this->db->get();
        $res1=$res->row_array();
        return $res1['tanker_id'];
    }
  }