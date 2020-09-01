<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Freegift_po_m extends CI_Model{

/*Getting Freegift PO num of rows
Author:Srilekha
Time: 12.38PM 06-02-2017 */
	public function freegift_po_total_num_rows($search_params)
	{		
		$this->db->select('po.*,fg.name as freegift_name,s.agency_name as supplier_name');
		$this->db->from('po_free_gift po');
		$this->db->join('free_gift fg','fg.free_gift_id=po.free_gift_id');
		$this->db->join('supplier s','s.supplier_id=po.supplier_id');
		if($search_params['po_number']!='')
			$this->db->where('po.po_number',$search_params['po_number']);
		if($search_params['freegift_id']!='')
			$this->db->where('fg.free_gift_id',$search_params['freegift_id']);
		if($search_params['po_date']!='')
			$this->db->where('date(po.po_date)',$search_params['po_date']);
		$this->db->order_by('po.po_fg_id DESC');
		$res = $this->db->get();
		return $res->num_rows();
	}
/*Getting Free Gift po Results
Author:Srilekha
Time: 12.22PM 16-02-2017 */
	public function freegift_po_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('po.*,fg.name as freegift_name,s.agency_name as supplier_name');
		$this->db->from('po_free_gift po');
		$this->db->join('free_gift fg','fg.free_gift_id=po.free_gift_id');
		$this->db->join('supplier s','s.supplier_id=po.supplier_id');
		if($search_params['po_number']!='')
			$this->db->where('po.po_number',$search_params['po_number']);
		if($search_params['freegift_id']!='')
			$this->db->where('fg.free_gift_id',$search_params['freegift_id']);
		if($search_params['po_date']!='')
			$this->db->where('date(po.po_date)',$search_params['po_date']);
		$this->db->order_by('po.po_fg_id DESC');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
/*Getting Freegift PO details for Download
Author:Srilekha
Time: 01.30PM 20-02-2017 */
public function freegift_po_details($search_params)
	{		
		$this->db->select('po.*,fg.name as freegift_name,s.concerned_person as supplier_name');
		$this->db->from('po_free_gift po');
		$this->db->join('free_gift fg','fg.free_gift_id=po.free_gift_id');
		$this->db->join('supplier s','s.supplier_id=po.supplier_id');
		if($search_params['po_number']!='')
			$this->db->where('po.po_number',$search_params['po_number']);
		if($search_params['freegift_id']!='')
			$this->db->where('fg.free_gift_id',$search_params['freegift_id']);
		if($search_params['po_date']!='')
			$this->db->where('date(po.po_date)',$search_params['po_date']);
		$this->db->order_by('po.po_fg_id DESC');
		$res = $this->db->get();
		return $res->result_array();
	}
/*Freegift PO details
Author:Srilekha
Time: 01.22PM 15-02-2017 */
	public function get_po_num($current_year,$previous_year)
	{
		$qry = "SELECT max(po_number) as po_number FROM po_free_gift WHERE created_time <= '".$current_year."' AND created_time >= '".$previous_year."'";
		$res1 = $this->db->query($qry);
		$qry_data = $res1->result_array();
		$count = $res1->num_rows();
		$po_number = $qry_data[0]['po_number'];
		if($count != '')
		{
			$num = $po_number;
			$po_number = $num+1;
			return $po_number;
		}
		else
		{
			$num =  0;
			$po_number = $num+1;
			return $po_number;
		}
    }

    //retriving data from PO table for PDF download
    //Mounika
    public function print_free_gift($po_fg_id)
    {
    	$this->db->select('po.po_fg_id,po.po_number,po.po_date,po.unit_price,po.quantity,po.status,f.free_gift_id,f.name as free_gift_name,s.supplier_id,s.agency_name as supplier_name,s.supplier_code');
    	$this->db->from('po_free_gift po');
    	$this->db->join('free_gift f','po.free_gift_id=f.free_gift_id');
        $this->db->join('supplier s','po.supplier_id=s.supplier_id');
    	$this->db->where('po.po_fg_id',$po_fg_id);
        $res=$this->db->get();
        return $res->row_array();
    }

    public function print_free_gift_report($search_params)
    {
    	$this->db->select('po.po_fg_id,po.po_number,po.po_date,po.unit_price,po.quantity,po.status,fg.free_gift_id,fg.name as free_gift_name,s.supplier_id,s.agency_name as supplier_name,s.supplier_code, sum(mfg.received_qty) as received_qty');
    	$this->db->from('po_free_gift po');
    	$this->db->join('free_gift fg','po.free_gift_id=fg.free_gift_id');
        $this->db->join('supplier s','po.supplier_id=s.supplier_id');
        $this->db->join('po_fg_tanker pft','pft.po_fg_id = po.po_fg_id','left');
        $this->db->join('tanker_fg tfg','tfg.tanker_id = pft.tanker_id','left');
        $this->db->join('mrr_fg mfg','tfg.tanker_fg_id = mfg.tanker_fg_id','left');
        if($search_params['po_number']!='')
			$this->db->where('po.po_number',$search_params['po_number']);
		if($search_params['free_gift_id']!='')
			$this->db->where('fg.free_gift_id',$search_params['free_gift_id']);
		if($search_params['po_date']!='')
			$this->db->where('date(po.po_date)',$search_params['po_date']);
		$this->db->group_by('po.po_fg_id');
		$res = $this->db->get();
		return $res->result_array();	
    }

}