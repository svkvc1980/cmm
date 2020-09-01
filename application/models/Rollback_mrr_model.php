<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rollback_mrr_model extends CI_Model {

	public function get_mrr_data($mrr_number)
	{
       	$this->db->select('m.mrr_oil_id as mrr_oil_id,m.mrr_number as mrr_number,m.mrr_date,pot.po_oil_id as po_oil_id,po.po_number,po.quantity as po_quantity,pot.tanker_id as tanker_id,tr.invoice_number as invoice_number,tr.vehicle_number as vehicle_number,tr.tanker_in_number as tanker_number,tr.dc_number as dc_number,(t.gross -t.tier)/1000 as net_weight,(t.invoice_gross -t.invoice_tier)/1000 as invoice_net_weight,t.gross as gross_weight,t.tier as tier_weight,t.tanker_oil_id as tanker_oil_id,po.po_number as po_number,po.quantity as quantity,po.po_date as po_date,po.unit_price as unit_price,lo.loose_oil_id as loose_oil_id,lo.name as loose_oil_name ,po.broker_id as broker_id,b.agency_name as broker_name,b.broker_code,po.supplier_id as supplier_id,s.agency_name as supplier_name,s.supplier_code,po.plant_id as plant_id,p.name as plant_name,pt.name as purchase_type,m.ledger_number as ledger_number,m.folio_number as folio_number,m.remarks as remarks,ot.name as oil_tank,polt.test_number as test_number,t.invoice_qty as invoice_qty');
        $this->db->from('mrr_oil m');
        $this->db->join('tanker_oil t','m.tanker_oil_id=t.tanker_oil_id');
        $this->db->join('tanker_register tr','t.tanker_id=tr.tanker_id');
        $this->db->join('po_oil_lab_test polt','tr.tanker_id=polt.tanker_id');
        $this->db->join('oil_tank ot','m.oil_tank_id=ot.oil_tank_id');
        $this->db->join('po_oil_tanker pot','tr.tanker_id=pot.tanker_id');
        $this->db->join('po_oil po','pot.po_oil_id=po.po_oil_id');
        $this->db->join('loose_oil lo','po.loose_oil_id=lo.loose_oil_id');
        $this->db->join('broker b','po.broker_id=b.broker_id');
        $this->db->join('supplier s','po.supplier_id=s.supplier_id');
        $this->db->join('plant p','po.plant_id=p.plant_id'); 
        $this->db->join('po_type as pt','po.po_type_id =pt.po_type_id'); 
        $this->db->where('m.mrr_number',$mrr_number);
        $this->db->order_by('m.mrr_oil_id Desc');
        $this->db->limit('1');
        $res=$this->db->get();
        return $res->row_array();
    }

    public function get_received_qty($po_oil_id)
    {
        $this->db->select('sum((to.gross-to.tier)/1000) as received_qty');
        $this->db->from('po_oil_tanker pot','po.po_oil_id=pot.po_oil_id');
        $this->db->join('tanker_oil to','pot.tanker_id=to.tanker_id');
        $this->db->where('pot.po_oil_id',$po_oil_id);
        $res=$this->db->get();
        $result=$res->row_array();
        return $result['received_qty'];
    }

    public function get_mrr_oil_stock_balance($plant_id,$loose_oil_id,$mrr_date)
    {
        $this->db->select('*');
        $this->db->from('oil_stock_balance');
        $this->db->where('plant_id',$plant_id);
        $this->db->where('loose_oil_id',$loose_oil_id);
        $this->db->where('on_date <=',$mrr_date);
        //$this->db->where('receipts !=',0);
        $this->db->order_by('on_date','desc');
        $this->db->limit(1);
        $res=$this->db->get();
        return  $res->row_array();
        
    }
     public function get_mrr_pm_stock_balance($plant_id,$pm_id,$mrr_date)
    {
        $this->db->select('*');
        $this->db->from('pm_stock_balance');
        $this->db->where('plant_id',$plant_id);
        $this->db->where('pm_id',$pm_id);
        $this->db->where('on_date <=',$mrr_date);
        //$this->db->where('receipts !=',0);
        $this->db->order_by('on_date','desc');
        $this->db->limit(1);
        $res=$this->db->get();
        return  $res->row_array();
        
    }

      public function get_mrr_plant_fg_stock_balance($plant_id,$free_gift_id)
    {
        $this->db->select('*');
        $this->db->from('plant_free_gift');
        $this->db->where('plant_id',$plant_id);
        $this->db->where('free_gift_id',$free_gift_id);
        $res=$this->db->get();
        return  $res->row_array();
        
    }

    public function get_mrr_oil_details($mrr_oil_id)
    {
        $this->db->select('m.mrr_oil_id,m.mrr_number,t.loose_oil_id,(t.gross -t.tier)/1000 as net_weight,tr.plant_id,tr.tanker_id,m.mrr_date');
        $this->db->from('mrr_oil m');
        $this->db->join('tanker_oil t','m.tanker_oil_id=t.tanker_oil_id');
        $this->db->join('tanker_register tr','t.tanker_id=tr.tanker_id');
        $this->db->where('m.mrr_oil_id',$mrr_oil_id);
        $res=$this->db->get();
        return $res->row_array();
    }

    public function get_mrr_pm_details($mrr_pm_id)
    {
        $this->db->select('m.mrr_pm_id,m.mrr_number,t.pm_id,m.received_qty,tr.plant_id,tr.tanker_id,m.mrr_date,pm.pm_category_id');
        $this->db->from('mrr_pm m');
        $this->db->join('tanker_pm t','m.tanker_pm_id=t.tanker_pm_id');
        $this->db->join('tanker_register tr','t.tanker_id=tr.tanker_id');
        $this->db->join('packing_material pm','t.pm_id=pm.pm_id');
        $this->db->where('m.mrr_pm_id',$mrr_pm_id);
        $res=$this->db->get();
        return $res->row_array();
    }

     public function get_mrr_fg_details($mrr_fg_id)
    {
        $this->db->select('m.mrr_fg_id,m.mrr_number,t.free_gift_id,m.received_qty,tr.plant_id,tr.tanker_id,m.mrr_date');
        $this->db->from('mrr_fg m');
        $this->db->join('tanker_fg t','m.tanker_fg_id=t.tanker_fg_id');
        $this->db->join('tanker_register tr','t.tanker_id=tr.tanker_id');
        $this->db->where('m.mrr_fg_id',$mrr_fg_id);
        $res=$this->db->get();
        return $res->row_array();
    }

    public function get_products()
	{
		$this->db->select('*');
		$this->db->from('loose_oil');
		$this->db->where('status',1);
		$res=$this->db->get();
		return $res->result_array();
	}

	public function get_ops()
	{
		$this->db->select('p.plant_id,p.name as plant_name');
        $this->db->from('plant p');
        $this->db->join('plant_block pb','p.plant_id=pb.plant_id');
        $this->db->where('pb.block_id',2);
        $res = $this->db->get();
        return $res->result_array();
	}

	//packing Material
	public function get_mrr_pm_data($mrr_number)
    {
         $this->db->select('m.mrr_pm_id as mrr_pm_id,m.mrr_date,m.mrr_number as mrr_number,po.quantity as pp_quantity,(t.invoice_gross-t.invoice_tier) as invoice_net_weight,m.received_qty as rec_qty,pot.po_pm_id as po_pm_id,pot.tanker_id as tanker_id,tr.invoice_number as invoice_number,tr.vehicle_number as vehicle_number,tr.tanker_in_number as tanker_number,tr.dc_number as dc_number,(t.gross -t.tier) as net_weight,t.gross as gross_weight,t.tier as tier_weight,t.tanker_pm_id as tanker_pm_id,po.po_number as po_number,po.quantity as quantity,po.po_date as po_date,po.unit_price as unit_price,lo.pm_id as pm_id,lo.name as pm_name,po.supplier_id as supplier_id,s.agency_name as supplier_name,s.supplier_code,po.plant_id as plant_id,p.name as plant_name,pt.name as purchase_type,m.ledger_number as ledger_number,m.folio_number as folio_number,m.remarks as remarks,lo.pm_category_id as pm_category_id,pmlt.test_number');
        $this->db->from('mrr_pm m');
        $this->db->join('tanker_pm t','m.tanker_pm_id=t.tanker_pm_id');
        $this->db->join('tanker_register tr','t.tanker_id=tr.tanker_id');
        $this->db->join('po_pm_lab_test pmlt','tr.tanker_id=pmlt.tanker_id');
        //$this->db->join('oil_tank ot','m.oil_tank_id=ot.oil_tank_id');
        $this->db->join('po_pm_tanker pot','tr.tanker_id=pot.tanker_id');
        $this->db->join('po_pm po','pot.po_pm_id=po.po_pm_id');
        $this->db->join('packing_material lo','po.pm_id=lo.pm_id');
        //$this->db->join('broker b','po.broker_id=b.broker_id');
        $this->db->join('supplier s','po.supplier_id=s.supplier_id');
        $this->db->join('plant p','po.plant_id=p.plant_id'); 
        $this->db->join('po_type as pt','po.po_type_id =pt.po_type_id'); 
        $this->db->where('m.mrr_number',$mrr_number);
        $this->db->order_by('m.mrr_pm_id desc');
        $this->db->limit('1');
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

    //Free Gift
    public function get_mrr_fg_data($mrr_number)
    {
        $this->db->select('m.*,name as fg_name,tr.tanker_in_number,tr.*,po.*,s.supplier_id,s.agency_name as supplier_name,s.supplier_code');
        $this->db->from('mrr_fg m');
        $this->db->join('tanker_fg t','m.tanker_fg_id=t.tanker_fg_id');
        $this->db->join('tanker_register tr','t.tanker_id=tr.tanker_id');
        $this->db->join('free_gift fg','t.free_gift_id=fg.free_gift_id');
        $this->db->join('po_fg_tanker pfg','t.tanker_id=pfg.tanker_id');
        $this->db->join('po_free_gift po','pfg.po_fg_id=po.po_fg_id');
        $this->db->join('supplier s','po.supplier_id=s.supplier_id');
        $this->db->where('m.mrr_number',$mrr_number);
        $this->db->order_by('m.mrr_fg_id desc');
        $this->db->limit('1');
        $res=$this->db->get();
        return $res->row_array();
    }

    public function get_fg_received_qty($po_fg_id)
    {
      $this->db->select('sum(mf.received_qty) as fg_received_qty ');
      $this->db->from('po_fg_tanker pft');
      $this->db->join('tanker_fg tf','pft.tanker_id=tf.tanker_id');
      $this->db->join('mrr_fg mf','tf.tanker_fg_id=mf.tanker_fg_id');
      $this->db->where('pft.po_fg_id',$po_fg_id);
      $res=$this->db->get();
      $result=$res->row_array();
      return $result['fg_received_qty'];
    }
}