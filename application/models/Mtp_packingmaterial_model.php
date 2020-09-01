<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Mtp_packingmaterial_model extends CI_Model

 {



 	//Mounika

    public function packing_material_total_num_rows($search_params)

    {       

        $this->db->select('m.mtp_pm_id,m.mtp_number,m.mtp_date,m.quantity,m.status,pm.pm_id,pm.name as packing_name,pb.plant_id,p.plant_id,p.name as plant_name');

        $this->db->from('mtp_pm m');

        $this->db->join('packing_material pm', 'm.pm_id=pm.pm_id');

        $this->db->join('plant_block pb','m.plant_id=pb.plant_id');

        $this->db->join('plant p','pb.plant_id=p.plant_id');

        if($search_params['mtp_number']!='')

            $this->db->where('m.mtp_number',$search_params['mtp_number']);

        if($search_params['pm_id']!='')

            $this->db->where('pm.pm_id',$search_params['pm_id']); 

        if($search_params['plant_id']!='')

            $this->db->where('p.plant_id',$search_params['plant_id']);

        $this->db->order_by('m.mtp_pm_id DESC');

        $res = $this->db->get();

        return $res->num_rows();

    }



    public function packing_material_results($search_params,$per_page,$current_offset)

    {       

        $this->db->select('m.mtp_pm_id,m.mtp_number,m.mtp_date,m.quantity,m.status,pm.pm_id,pm.name as packing_name,pb.plant_id,p.plant_id,p.name as plant_name');

        $this->db->from('mtp_pm m');

        $this->db->join('packing_material pm', 'm.pm_id=pm.pm_id');

        $this->db->join('plant_block pb','m.plant_id=pb.plant_id');

        $this->db->join('plant p','pb.plant_id=p.plant_id');

        if($search_params['mtp_number']!='')

            $this->db->where('m.mtp_number',$search_params['mtp_number']);

        if($search_params['pm_id']!='')

            $this->db->where('pm.pm_id',$search_params['pm_id']); 

        if($search_params['plant_id']!='')

            $this->db->where('p.plant_id',$search_params['plant_id']);

        $this->db->order_by('m.mtp_pm_id DESC');

        $this->db->limit($per_page, $current_offset);

        $res = $this->db->get();

        return $res->result_array();

    }



    public function packing_material_details($search_params)

    {

        $this->db->select('m.mtp_pm_id,m.mtp_number,m.mtp_date,m.quantity,m.status,pm.pm_id,pm.name as packing_name,pb.plant_id,p.plant_id,p.name as plant_name');

        $this->db->from('mtp_pm m');

        $this->db->join('packing_material pm', 'm.pm_id=pm.pm_id');

        $this->db->join('plant_block pb','m.plant_id=pb.plant_id');

        $this->db->join('plant p','pb.plant_id=p.plant_id');

        if($search_params['mtp_number']!='')

            $this->db->where('m.mtp_number',$search_params['mtp_number']);

        if($search_params['pm_id']!='')

            $this->db->where('pm.pm_id',$search_params['pm_id']); 

        if($search_params['plant_id']!='')

            $this->db->where('p.plant_id',$search_params['plant_id']);

        $this->db->order_by('m.mtp_pm_id DESC');

        $res = $this->db->get();

        return $res->result_array();

    }



 	//retriving data from Packing Material category table

    public function getpacking_material_category()

	{ 

		$this->db->select('pm_category_id,name as category_name');

		$this->db->from('packing_material_category');

		$this->db->where('status',1);

		$res = $this->db->get();

        return $res->result_array();

    }



    //retriving data from Packing Material table

    public function getpacking_material()

    { 

        $this->db->select('pm_id,name as packing_name,pm_category_id');

        $this->db->from('packing_material');

        $this->db->where('status',1);

        $res = $this->db->get();

        return $res->result_array();

    }







    //getting Packing material based on  Packing Category

    public function get_material_based_on_category($pm_category_id)



    {

       $this->db->from('packing_material ');

       $this->db->where('pm_category_id',$pm_category_id);

        $res1 = $this->db->get();

        $res = $res1->result_array();

        $count = $res1->num_rows();

        $qry_data='';

          

        if($count>0)

        {

            $qry_data.='<option value="">-Packing Material-</option>';

            foreach($res as $row1)

            {  

                $qry_data.='<option value="'.$row1['pm_id'].'">'.$row1['name'].'</option>';

            }

        } 

        else 

        {

            $qry_data.='<option value="">No Data Found</option>';

        }

        echo $qry_data;

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



    public function get_mtp_pm_id($current_year,$previous_year)

    {

        $qry = "SELECT max(mtp_number) as mtp_no FROM mtp_pm WHERE created_time <= '".$current_year."' AND created_time >= '".$previous_year."'";

        $res1 = $this->db->query($qry);

        $qry_data = $res1->result_array();

        $count = $res1->num_rows();

        $mtp_no = $qry_data[0]['mtp_no'];

        if($count != '')

        {

            $num = $mtp_no;

            $mtp_number = $num+1;

            return $mtp_number;

        }

        else

        {

            $num =  0;

            $mtp_number = $num+1;

            return $mtp_number;

        }

    }



    public function get_po_number($current_year,$previous_year)

    {

        $qry = "SELECT max(po_number) as po_no FROM po_pm WHERE created_time <= '".$current_year."' AND created_time >= '".$previous_year."'";

        $res1 = $this->db->query($qry);

        $qry_data = $res1->result_array();

        $count = $res1->num_rows();

        $po_no = $qry_data[0]['po_no'];

        if($count != '')

        {

            $num = $po_no;

            $po_num = $num+1;

            return $po_num;

        }

        else

        {

            $num =  0;

            $po_num = $num+1;

            return $po_num;

        }

    }



    public function get_tender_details($mtp_pm_id)

    {

        $this->db->select('m.mtp_pm_id,m.mtp_number,m.mtp_date,m.quantity as quantity,m.status,pm.pm_id,pm.name as packing_name,pb.plant_id,p.plant_id,p.name as plant_name');

        $this->db->from('mtp_pm m');

        $this->db->join('packing_material pm', 'm.pm_id=pm.pm_id');

        $this->db->join('plant_block pb','m.plant_id=pb.plant_id');

        $this->db->join('plant p','pb.plant_id=p.plant_id');

        $this->db->where('m.mtp_pm_id',$mtp_pm_id);

        $res = $this->db->get();

        return $res->row_array();

    }



    //retriving data from supplier table

    public function getsupplier()

    { 

        $this->db->select('supplier_id,agency_name');

        $this->db->from('supplier');

        $this->db->where('type_id',2);

        $this->db->where('status',1);

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



    public function get_add_tender($mtp_pm_id)

    {

        $this->db->select('t.tender_pm_id,t.quoted_price,t.negotiated_price,t.support_document,t.quantity,t.status,s.supplier_id,s.agency_name as supplier_name,m.mtp_pm_id');

        $this->db->from('tender_pm t');

        $this->db->join('mtp_pm m','t.mtp_pm_id=m.mtp_pm_id');

        $this->db->join('supplier s','t.supplier_id=s.supplier_id');

        $this->db->where('t.mtp_pm_id',$mtp_pm_id);

        $res = $this->db->get();

        return $res->result_array();

    }



    public function get_least_tender($mtp_pm_id)

    {

    $query='select t1.tender_pm_id,t1.quoted_price,t1.quantity as offered_qty,t1.negotiated_price,t1.support_document,t1.status,s.supplier_id,s.agency_name as supplier_name,m.mtp_pm_id,

            case when t1.negotiated_price is null AND t1.negotiated_price<=0 

            then t1.quoted_price 

            else  least(t1.negotiated_price,t1.quoted_price) 

            end as min_quote 

            from tender_pm t1 

            inner join mtp_pm m on t1.mtp_pm_id=m.mtp_pm_id

            inner join supplier s on t1.supplier_id=s.supplier_id

            where t1.mtp_pm_id='.$mtp_pm_id.' and t1.status= 1 order by min_quote limit 1 ';

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



    public function view_pm_total_num_rows($search_params)

    {       

        $this->db->select('po.po_pm_id,po.po_number,po.po_date,po.quantity,po.unit_price,po.status,pm.pm_id,pm.name as packing_name,pb.plant_id,p.plant_id,p.name as plant_name,b.broker_id,b.agency_name as broker_name,s.supplier_id,s.agency_name as supplier_name,pt.po_type_id,pt.name');

        $this->db->from('po_pm po');

        $this->db->join('packing_material pm','po.pm_id=pm.pm_id');

        $this->db->join('plant_block pb','po.plant_id=pb.plant_id');

        $this->db->join('broker b','po.broker_id=b.broker_id');

        $this->db->join('supplier s','po.supplier_id=s.supplier_id');

        $this->db->join('po_type pt','po.po_type_id=pt.po_type_id');

        $this->db->join('plant p','pb.plant_id=p.plant_id');

        $this->db->where('mtp_pm_id is null');

        if($search_params['po_number']!='')

            $this->db->where('po.po_number',$search_params['po_number']);

        if($search_params['pm_id']!='')

            $this->db->where('pm.pm_id',$search_params['pm_id']); 

        if($search_params['plant_id']!='')

            $this->db->where('p.plant_id',$search_params['plant_id']); 

        $res = $this->db->get();

        return $res->num_rows();

    }



    public function  view_pm_results($search_params,$per_page,$current_offset)

    {       

        $this->db->select('po.po_pm_id,po.po_number,po.po_date,po.quantity,po.unit_price,po.status,pm.pm_id,pm.name as packing_name,pb.plant_id,p.plant_id,p.name as plant_name,b.broker_id,b.agency_name as broker_name,s.supplier_id,s.agency_name as supplier_name,pt.po_type_id,pt.name,po.mtp_pm_id as mtp_pm_id');

        $this->db->from('po_pm po');

        $this->db->join('packing_material pm','po.pm_id=pm.pm_id');

        $this->db->join('plant_block pb','po.plant_id=pb.plant_id');

        $this->db->join('broker b','po.broker_id=b.broker_id');

        $this->db->join('supplier s','po.supplier_id=s.supplier_id');

        $this->db->join('po_type pt','po.po_type_id=pt.po_type_id');

        $this->db->join('plant p','pb.plant_id=p.plant_id');

        //$this->db->where('mtp_pm_id is null');

        if($search_params['po_number']!='')

            $this->db->where('po.po_number',$search_params['po_number']);

        if($search_params['pm_id']!='')

            $this->db->where('pm.pm_id',$search_params['pm_id']); 

        if($search_params['plant_id']!='')

            $this->db->where('p.plant_id',$search_params['plant_id']); 

        $this->db->limit($per_page, $current_offset);

        $res = $this->db->get();

        return $res->result_array();

    }



    public function get_latest_po_details($pm_id)

    {

       $query='SELECT * FROM po_pm po where po.created_time=(SELECT max(p1.created_time) from po_pm p1 where p1.pm_id='.$pm_id.')';

        $res=$this->db->query($query);

        return $res->row_array();

    }

     public function get_mtp_pm_quantity($mtp_pm_id)

   {

      $this->db->select('quantity');

      $this->db->from('mtp_pm');

      $this->db->where('mtp_pm_id',$mtp_pm_id);

      $query=$this->db->get();

      $res=$query->row_array();

      return $res['quantity'];

   }
    
   public function get_po_generated_quantity($mtp_pm_id)

   {

      $this->db->select('sum(quantity) as received_qty');

      $this->db->from('po_pm');

      $this->db->where('mtp_pm_id',$mtp_pm_id);

      $query=$this->db->get();

      $res=$query->row_array();

      return $res['received_qty'];

   }

   public function get_existed_broker_tenders_for_po_pm($mtp_pm_id)
   {
        $this->db->select('b.broker_id,b.agency_name');
        $this->db->from('tender_pm t');
        $this->db->join('broker b','t.broker_id=b.broker_id');
        $this->db->where('t.mtp_pm_id',$mtp_pm_id);
        $this->db->group_by('t.broker_id');
        $res = $this->db->get();
        return $res->result_array();
   }

   public function get_existed_supplier_tenders_for_po_pm($mtp_pm_id)
   {
        $this->db->select('s.supplier_id,s.agency_name');
        $this->db->from('tender_pm t');
        $this->db->join('supplier s','t.supplier_id=s.supplier_id');
        $this->db->where('t.mtp_pm_id',$mtp_pm_id);
        $this->db->group_by('t.supplier_id');
        $res = $this->db->get();
        return $res->result_array();
   }

}