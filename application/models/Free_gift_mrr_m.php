<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Free_gift_mrr_m extends CI_Model {

	/*Getting MRR Results num of rows
	Author:Srilekha
	Time: 02.40PM 11-03-2017 */
	public function mrr_fg_total_num_rows($search_params)
	{		
		$this->db->select('m.*,fg.name as freegift_name,tr.tanker_in_number');
		$this->db->from('mrr_fg m');
		$this->db->join('tanker_fg t','t.tanker_fg_id=m.tanker_fg_id');
		$this->db->join('tanker_register tr','tr.tanker_id=t.tanker_id');
		$this->db->join('free_gift fg','fg.free_gift_id=t.free_gift_id');
		if($search_params['mrr_number']!='')
			$this->db->where('m.mrr_number',$search_params['mrr_number']);
		if($search_params['from_date']!='')
			$this->db->where('m.mrr_date>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('m.mrr_date<=',$search_params['to_date']);
		//$this->db->group_by('fg.free_gift_id');
		$res = $this->db->get();
		return $res->num_rows();
	}

	/*Getting MRR Results
	Author:Srilekha
	Time: 02.43PM 11-03-2017 */
	public function mrr_fg_results($current_offset, $per_page, $search_params)
	{		
		$this->db->select('m.*,fg.name as freegift_name,tr.tanker_in_number');
		$this->db->from('mrr_fg m');
		$this->db->join('tanker_fg t','t.tanker_fg_id=m.tanker_fg_id');
		$this->db->join('tanker_register tr','tr.tanker_id=t.tanker_id');
		$this->db->join('free_gift fg','fg.free_gift_id=t.free_gift_id');
		if($search_params['mrr_number']!='')
			$this->db->where('m.mrr_number',$search_params['mrr_number']);
		if($search_params['from_date']!='')
			$this->db->where('m.mrr_date>=',$search_params['from_date']);
		if($search_params['to_date']!='')
			$this->db->where('m.mrr_date<=',$search_params['to_date']);
		$this->db->order_by('m.mrr_date DESC, m.mrr_fg_id DESC');
		//$this->db->group_by('fg.free_gift_id');
		$this->db->limit($per_page, $current_offset);
		$res = $this->db->get();		
		return $res->result_array();
	}
/*MRR Free Gift Details
Author:Srilekha
Time: 03.15PM 11-03-2017 */
	public function mrr_fg_details($search_params)
	{		
		$this->db->select('m.*,fg.name freegift_name,tr.tanker_in_number,s.agency_name as supplier, pfg.po_number, pfg.unit_price, pfg.po_date');
		$this->db->from('mrr_fg m');
		$this->db->join('tanker_fg t','t.tanker_fg_id=m.tanker_fg_id');
		$this->db->join('tanker_register tr','tr.tanker_id=t.tanker_id');
		$this->db->join('po_fg_tanker pft','pft.tanker_id = tr.tanker_id');
		$this->db->join('po_free_gift pfg','pfg.po_fg_id = pft.po_fg_id');
		$this->db->join('supplier s','pfg.supplier_id = s.supplier_id');
		$this->db->join('free_gift fg','fg.free_gift_id=pfg.free_gift_id');
		if($search_params['mrr_number']!='')
			$this->db->where('m.mrr_number',$search_params['mrr_number']);
		if($search_params['from_date']!='')
			$this->db->where('m.mrr_date>=',format_date($search_params['from_date'],'Y-m-d'));
		if($search_params['to_date']!='')
			$this->db->where('m.mrr_date<=',format_date($search_params['to_date'],'Y-m-d'));
		$this->db->order_by('fg.free_gift_id ASC, m.mrr_date ASC');
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