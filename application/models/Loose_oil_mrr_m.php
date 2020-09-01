<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Loose_oil_mrr_m extends CI_Model

 {

    /**
    * get tanker details based on tanker number
    * author: prasad , created on: 12th feb 2017 12:39 PM, updated on: --
    * params: $tanker_number(int)
    * return: $tanker details(row_array),$count(int)
    **/

  	public function get_tanker_details($tanker_number)

  	{

        $plant_id = $this->session->userdata('ses_plant_id');
	    $type_id=get_loose_oil_tank_id();
	    $this->db->select('tr.*');
        $this->db->from('po_oil_tanker pot');
        $this->db->join('tanker_register tr','pot.tanker_id=tr.tanker_id');
        $this->db->join('po_oil po','pot.po_oil_id=po.po_oil_id');
        $this->db->where('tr.tanker_in_number',$tanker_number);
        $this->db->where('tr.tanker_type_id',$type_id);
        $this->db->where('tr.plant_id',$plant_id);
        $this->db->where('po.status !=',3);
        $this->db->order_by('tr.tanker_id','DESC');
        $this->db->limit(1);
        $res = $this->db->get();
        return array($res->num_rows(),$res->row_array());

  	}

    

    /**
    * get mrr details based on tanker id linked to purchase order
    * author: prasad , created on: 13th feb 2017 3:30 PM, updated on: --
    * params: $tanker_id(int)
    * return: $mrr_results(row_array)
    **/

    public function get_mrr_loose_oil_details($tanker_id)

    {

  	    $this->db->select('pot.po_oil_id as po_oil_id,pot.tanker_id as tanker_id,po.quantity as po_quantity,tr.invoice_number as invoice_number,tr.vehicle_number as vehicle_number,tr.tanker_in_number as tanker_number,tr.dc_number as dc_number,(t.gross -t.tier)/1000 as net_weight,(t.invoice_gross -t.invoice_tier)/1000 as invoice_net_weight,t.gross as gross_weight,t.tier as tier_weight,t.tanker_oil_id as tanker_oil_id,po.po_number as po_number,po.quantity as quantity,po.po_date as po_date,po.unit_price as unit_price,lo.loose_oil_id as loose_oil_id,lo.name as loose_oil_name ,po.broker_id as broker_id,b.agency_name as broker_name,po.supplier_id as supplier_id,s.agency_name as supplier_name,po.plant_id as plant_id,p.name as plant_name,pt.name as purchase_type,t.invoice_qty as invoice_qty');

  	    $this->db->from('po_oil_tanker pot');

  	    $this->db->join('tanker_register tr','pot.tanker_id=tr.tanker_id');

  	    $this->db->join('tanker_oil t','tr.tanker_id=t.tanker_id');

  	    $this->db->join('po_oil po','pot.po_oil_id=po.po_oil_id');

  	    $this->db->join('loose_oil lo','po.loose_oil_id=lo.loose_oil_id');

  	    $this->db->join('broker b','po.broker_id=b.broker_id');

  	    $this->db->join('supplier s','po.supplier_id=s.supplier_id');

  	    $this->db->join('plant p','po.plant_id=p.plant_id'); 

  	    $this->db->join('po_type as pt','po.po_type_id =pt.po_type_id'); 

  	    //$this->db->join('mtp_oil mo','po.mtp_oil_id=mo.mtp_oil_id');

  	    $this->db->where('pot.tanker_id',$tanker_id);

  	    $res=$this->db->get();

  	    return $res->row_array();

    }



    /**
    * get maximum mtp number
    * author: prasad , created on: 13th feb 2017 3:30 PM, updated on: --
    * return: $max_mtp(row_array)
    **/

    public function get_max_mtp()

    {

        $this->db->select('max(mrr_oil_id) as mrr_number');

        $this->db->from('mrr_oil');

        $res=$this->db->get();

        return $res->row_array();

    }



    /**
    * get mrr details from looseoil mrr
    * author: prasad , created on: 14th feb 2017 3:30 PM, updated on: --
    * params: $mrr_oil_id(int)
    * return: $max_mtp(row_array)
    **/

    public function get_details_mrr($mrr_oil_id)

    {

        $this->db->from('mrr_oil mo');

        $this->db->join('oil_tank ot','mo.oil_tank_id=ot.oil_tank_id');

        $this->db->where('mrr_oil_id',$mrr_oil_id);

        $res=$this->db->get();

        return $res->row_array();

    }



    /**
    * get mrr details from looseoil mrr
    * author: prasad , created on: 14th feb 2017 3:30 PM, updated on: --
    * params: $mrr_oil_id(int)
    * return: $max_mtp(row_array)
    **/

    public function insert_mrr_loose_oil_details($dat)

    {

        $this->db->from('mrr_oil mo');

        $this->db->where('tanker_oil_id',$dat['tanker_oil_id']);

        $res=$this->db->get();

        $res1=$res->row_array();

        if($res->num_rows()>0)

        {

           $this->db->update('mrr_oil',array('remarks'=>$dat['remarks'],'folio_number'=>$dat['folio_number'],'ledger_number'=>$dat['ledger_number']),array('tanker_oil_id'=>$dat['tanker_oil_id']));

           return $res1['mrr_oil_id'];

        }

        else

        {

            $this->db->insert('mrr_oil',$dat);

            return $this->db->insert_id();

        }

    }



     public function get_mrr_list_total_num_rows($search_params)

    {       

        $this->db->select('*');
        $this->db->from('mrr_oil m');
        $this->db->join('tanker_oil to','m.tanker_oil_id=to.tanker_oil_id');
        $this->db->join('tanker_register tr','to.tanker_id=tr.tanker_id');
        $this->db->join('po_oil_tanker pot','tr.tanker_id=pot.tanker_id');
        $this->db->join('po_oil po','pot.po_oil_id=po.po_oil_id');
        $this->db->join('loose_oil lo','po.loose_oil_id=lo.loose_oil_id');
        $this->db->join('plant p','po.plant_id=p.plant_id'); 

        if($search_params['po_number']!='')
            $this->db->where('po.po_number',$search_params['po_number']);
        if($search_params['mrr_number']!='')
            $this->db->where('m.mrr_number',$search_params['mrr_number']);
        if($search_params['start_date']!='')
            $this->db->where('m.mrr_date>=',format_date($search_params['start_date'],'Y-m-d'));
        if($search_params['end_date']!='')
            $this->db->where('m.mrr_date<=',format_date($search_params['end_date'],'Y-m-d'));
        if($search_params['tanker_in_number']!='')
            $this->db->where('tr.tanker_in_number',$search_params['tanker_in_number']);
        $this->db->order_by('m.mrr_oil_id DESC');

        $res = $this->db->get();

        return $res->num_rows();

    }



    public function view_mrr_list_results($search_params,$per_page,$current_offset)
    {       
        $this->db->select('m.mrr_oil_id as mrr_oil_id,m.mrr_number as mrr_number,tr.tanker_in_number as tanker_in_number,po.po_number as po_number,p.short_name as plant_name,lo.name as loose_oil_name,m.mrr_date as mrr_date, (to.gross-to.tier)/1000 as received_qty, po.po_date');
        $this->db->from('mrr_oil m');
        $this->db->join('tanker_oil to','m.tanker_oil_id=to.tanker_oil_id');
        $this->db->join('tanker_register tr','to.tanker_id=tr.tanker_id');
        $this->db->join('po_oil_tanker pot','tr.tanker_id=pot.tanker_id');
        $this->db->join('po_oil po','pot.po_oil_id=po.po_oil_id');
        $this->db->join('loose_oil lo','po.loose_oil_id=lo.loose_oil_id');
        $this->db->join('plant p','po.plant_id=p.plant_id'); 

        if($search_params['po_number']!='')
            $this->db->where('po.po_number',$search_params['po_number']);
        if($search_params['mrr_number']!='')
            $this->db->where('m.mrr_number',$search_params['mrr_number']); 
        if($search_params['start_date']!='')
            $this->db->where('m.mrr_date>=',format_date($search_params['start_date'],'Y-m-d'));
        if($search_params['end_date']!='')
            $this->db->where('m.mrr_date<=',format_date($search_params['end_date'],'Y-m-d'));
        if($search_params['tanker_in_number']!='')
            $this->db->where('tr.tanker_in_number',$search_params['tanker_in_number']);
        $this->db->order_by('m.mrr_oil_id DESC');
        $this->db->limit($per_page, $current_offset);

        $res = $this->db->get();
        return $res->result_array();
    }



    public function print_mrr_list_results($mrr_oil_id)

    {
        $this->db->select('m.mrr_oil_id as mrr_oil_id,m.mrr_number as mrr_number,pot.po_oil_id as po_oil_id,po.quantity as po_quantity,pot.tanker_id as tanker_id,tr.invoice_number as invoice_number,tr.vehicle_number as vehicle_number,tr.tanker_in_number as tanker_number,tr.dc_number as dc_number,(t.gross -t.tier)/1000 as net_weight,(t.invoice_gross -t.invoice_tier)/1000 as invoice_net_weight,t.gross as gross_weight,t.tier as tier_weight,t.tanker_oil_id as tanker_oil_id,po.po_number as po_number,po.quantity as quantity,po.po_date as po_date,po.unit_price as unit_price,lo.loose_oil_id as loose_oil_id,lo.name as loose_oil_name ,po.broker_id as broker_id,b.agency_name as broker_name,po.supplier_id as supplier_id,s.agency_name as supplier_name,po.plant_id as plant_id,p.name as plant_name,pt.name as purchase_type,m.ledger_number as ledger_number,m.folio_number as folio_number,m.remarks as remarks,ot.name as oil_tank,polt.test_number as test_number,t.invoice_qty as invoice_qty,m.mrr_date,polt.test_date');
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
        $this->db->where('mrr_oil_id',$mrr_oil_id);
        $res=$this->db->get();
        return $res->row_array();

    }



    //retreving weight in stock list

    public function get_receipt_weight_stock_list($mrr_results)

    {

        $this->db->select('*');

        $this->db->from('oil_stock_balance');

        $this->db->where('plant_id',$mrr_results['plant_id']);

        $this->db->where('loose_oil_id',$mrr_results['loose_oil_id']);

        //$this->db->where('on_date = CURDATE()');

        $this->db->where('closing_balance is null');

        $this->db->order_by('on_date','desc');

        $this->db->limit(1);

        $res=$this->db->get();

        return $res->row_array();

    }



    public function get_ffa_value($test_id,$tanker_id)

    {

        $this->db->select('r.value as ffa_value');

        $this->db->from('po_oil_lab_test_results r');

        $this->db->join('po_oil_lab_test p','r.lab_test_id=p.lab_test_id');

        $this->db->join('loose_oil_test l','r.test_id=l.test_id');

        $this->db->where('r.test_id',$test_id);

        $this->db->where('p.tanker_id',$tanker_id);

        $res=$this->db->get();

        $q=$res->row_array();

        return $q['ffa_value'];

    }
    public function get_ffa_range($ffa_value)
    {
    	//echo $ffa_value; exit;
        $this->db->select('*');
        $this->db->from('ffa_rebate');
        $this->db->where('lower_limit <',$ffa_value);
        $res = $this->db->get();
        //echo $this->db->last_query();
        return $res->result_array();
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

    public function print_mrr_oil_results($search_params)
    {       
        $this->db->select('m.mrr_oil_id as mrr_oil_id,m.mrr_number as mrr_number,tr.tanker_in_number as tanker_in_number,po.po_number as po_number,p.short_name as plant_name,lo.name as loose_oil_name,m.mrr_date as mrr_date, (to.gross-to.tier)/1000 as received_qty, po.po_date,po.unit_price, polt.test_number, polt.status as test_status, polt.test_date, s.agency_name as supplier');
        $this->db->from('mrr_oil m');
        $this->db->join('tanker_oil to','m.tanker_oil_id=to.tanker_oil_id');
        $this->db->join('tanker_register tr','to.tanker_id=tr.tanker_id');
        $this->db->join('po_oil_lab_test polt','polt.tanker_id=tr.tanker_id');
        $this->db->join('po_oil_tanker pot','tr.tanker_id=pot.tanker_id');
        $this->db->join('po_oil po','pot.po_oil_id=po.po_oil_id');
        $this->db->join('supplier s','s.supplier_id = po.supplier_id');
        $this->db->join('loose_oil lo','po.loose_oil_id=lo.loose_oil_id');
        $this->db->join('plant p','po.plant_id=p.plant_id'); 

        if($search_params['po_number']!='')
            $this->db->where('po.po_number',$search_params['po_number']);
        if($search_params['mrr_number']!='')
            $this->db->where('m.mrr_number',$search_params['mrr_number']); 
        if($search_params['start_date']!='')
            $this->db->where('m.mrr_date>=',format_date($search_params['start_date'],'Y-m-d'));
        if($search_params['end_date']!='')
            $this->db->where('m.mrr_date<=',format_date($search_params['end_date'],'Y-m-d'));
        if($search_params['tanker_in_number']!='')
            $this->db->where('tr.tanker_in_number',$search_params['tanker_in_number']);
        $this->db->order_by('lo.rank ASC,m.mrr_date ASC');

        $res = $this->db->get();
        return $res->result_array();
    }

 }