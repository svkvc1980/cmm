<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Distributor_login_m extends CI_Model {	
	# download OB List
		public function download_ob_list($distributor_id)
		{		
		$block_id = $this->session->userdata('block_id');
		$plant_id = $this->session->userdata('ses_plant_id');		
		$this->db->select('o.order_number,o.order_date,d.agency_name,e.name as executive_name,d.distributor_code,obt.name as ob_type,pt.short_name as lifting_point,o.status as order_status,o.order_id,
			p.name as product_name, op.quantity,op.pending_qty,(op.unit_price+op.add_price) as product_price, op.items_per_carton');
		$this->db->from('order o');
		$this->db->join('order_product op','o.order_id = op.order_id');
		$this->db->join('product p','op.product_id = p.product_id');
		$this->db->join('distributor_order do','do.order_id=o.order_id','inner');
		$this->db->join('distributor d','d.distributor_id=do.distributor_id','left');
		$this->db->join('user u','u.user_id = o.created_by','left');
		$this->db->join('executive e','d.executive_id = e.executive_id','left');
		$this->db->join('ob_type obt','obt.ob_type_id=o.ob_type_id','left');
		$this->db->join('plant pt','pt.plant_id=o.lifting_point','left');

		
		$this->db->where('do.distributor_id',$distributor_id);
		
		$this->db->where('o.status<=',2);
		$this->db->where('o.type',1);
		$this->db->order_by('o.order_date DESC');
		$this->db->order_by('CAST(o.order_number AS unsigned) DESC');
		$res = $this->db->get();		
		return $res->result_array();
		}
    public function download_do_list($distributor_id)
	   {		
		$block_id = $this->session->userdata('block_id');
		$plant_id = $this->session->userdata('ses_plant_id');
		$this->db->select('p.name as product_name,p.product_id as product_id,
			dop.quantity as do_quantity,dop.pending_qty,d.do_number,pt.short_name as lifting_point,dis.agency_name,dis.distributor_code,
			doo.order_id,doo.do_id as do_identity,dop.status as order_status, e.name as executive_name,d.do_date,dop.items_per_carton,dop.product_price, da.name as remarks');
		$this->db->from('do d');
		$this->db->join('do_order doo','d.do_id = doo.do_id');
		$this->db->join('order disto','disto.order_id = doo.order_id');
		$this->db->join('do_order_product dop','doo.do_ob_id = dop.do_ob_id');
		$this->db->join('product p','dop.product_id = p.product_id');		
		$this->db->join('distributor_order do','disto.order_id = do.order_id');
		$this->db->join('distributor dis','dis.distributor_id = do.distributor_id');		
		$this->db->join('plant pt','pt.plant_id = d.lifting_point');
		$this->db->join('executive e','e.executive_id = dis.executive_id');
		$this->db->join('do_against da','da.do_against_id = d.do_against_id');
		$this->db->join('user u','u.user_id = d.created_by','left');
		$this->db->where('do.distributor_id',$distributor_id);
		$this->db->where('dop.status<=',2);
		$this->db->order_by('CAST(d.do_number AS unsigned) DESC');
		$res = $this->db->get();	
		//echo $this->db->last_query(); exit;
		return $res->result_array();
	}

	}