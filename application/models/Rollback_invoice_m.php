<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rollback_invoice_m extends CI_Model {

    public function get_invoice_type($invoice_id)
    {
        $this->db->select('o.type');
        $this->db->from('invoice i');
        $this->db->join('invoice_do id','id.invoice_id=i.invoice_id');
        $this->db->join('order o','o.order_id=id.order_id');
        $this->db->where('i.invoice_id',$invoice_id);
        $res=$this->db->get();
        return $res->row_array();
    }

    public function get_invoice_do_product($invoice_id)
    {
        $this->db->select('i.*,pl.name as to,p1.name as from,(idp.quantity*idp.items_per_carton) as packets,(idp.quantity*idp.items_per_carton*p.oil_weight) as qty_in_kg,(idp.quantity*ppw.weight) as pm_weight,(dop.product_price) as rate,idp.items_per_carton,idp.quantity as carton_qty,(idp.quantity*idp.items_per_carton*(dop.product_price)) as amount,idp.invoice_do_product_id,
            p.name as product,p.product_id,p.short_name');
        $this->db->from('invoice i');
        $this->db->join('invoice_do id','id.invoice_id=i.invoice_id');
        $this->db->join('invoice_do_product idp','idp.invoice_do_id=id.invoice_do_id');
        $this->db->join('product p','idp.product_id=p.product_id');
        $this->db->join('product_pm_weight ppw','p.product_id = ppw.product_id','left');
        $this->db->join('do d','d.do_id = id.do_id ');
        $this->db->join('do_order do','do.do_id = d.do_id ');
        $this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idp.do_ob_product_id');
        $this->db->join('order o','o.order_id = id.order_id');
        $this->db->join('plant_order po','po.order_id = o.order_id');
        $this->db->join('plant pl','pl.plant_id=po.plant_id');
        $this->db->join('plant p1','p1.plant_id=i.plant_id');
        $this->db->where('i.invoice_id',$invoice_id);
        $res=$this->db->get();
        return $res->result_array();
    }

    public function get_invoice_do_distributor_product($invoice_id)
    {
        $this->db->select('i.*,
                           l.name as location_name,
                           pl.name as lifting,(idp.quantity*idp.items_per_carton) as packets,
                           (idp.quantity*idp.items_per_carton*p.oil_weight) as qty_in_kg,
                           (idp.quantity*ppw.weight) as pm_weight,
                           (dop.product_price) as rate,
                           idp.invoice_do_product_id,
                           idp.items_per_carton,
                           idp.quantity as carton_qty,
                           (idp.quantity*idp.items_per_carton*dop.product_price) as amount,
                           du.*,
                           p.name as product,
                           p.product_id,
                           p.short_name');
        $this->db->from('invoice i');
        $this->db->join('invoice_do id','id.invoice_id=i.invoice_id');
        $this->db->join('invoice_do_product idp','idp.invoice_do_id=id.invoice_do_id');
        $this->db->join('product p','idp.product_id=p.product_id');
        $this->db->join('product_pm_weight ppw','p.product_id = ppw.product_id','left');
        $this->db->join('do d','d.do_id = id.do_id ');
        $this->db->join('do_order do','do.do_id = d.do_id ');
        $this->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id AND dop.do_ob_product_id = idp.do_ob_product_id');
        $this->db->join('order o','o.order_id = id.order_id');
        $this->db->join('distributor_order di','di.order_id = o.order_id');
        $this->db->join('distributor du','di.distributor_id = du.distributor_id');
        $this->db->join('location l','du.location_id = l.location_id');
        $this->db->join('plant pl','pl.plant_id=d.lifting_point');
        $this->db->where('i.invoice_id',$invoice_id);
        $res=$this->db->get();
        return $res->result_array();
    }
    public function get_invoice_dos($invoice_id)
    {
        $this->db->select('d.*');
        $this->db->from('invoice_do ido');
        $this->db->join('do d','d.do_id = ido.do_id');
        $this->db->where('ido.invoice_id',$invoice_id);
        $this->db->group_by('ido.do_id');
        $res = $this->db->get();
        return $res->result_array();
    }
    public function get_invoice_obs($invoice_id)
    {
        $this->db->select('o.*');
        $this->db->from('invoice_do ido');
        $this->db->join('order o','o.order_id = ido.order_id');
        $this->db->where('ido.invoice_id',$invoice_id);
        $this->db->group_by('ido.order_id');
        $res = $this->db->get();
        return $res->result_array();
    }

    public function get_invoice_id($invoice_number)
    {
        $this->db->select('invoice_id');
        $this->db->from('invoice');
        $this->db->where('invoice_number',$invoice_number);
        $this->db->order_by('invoice_date DESC');
        $this->db->limit(1);
        $res = $this->db->get();
        $value =  $res->row_array();
        return $value['invoice_id'];
    }

    public function get_invoice_detial($invoice_id)
    {
        $this->db->select('ido.*,idop.*,i.invoice_number,i.plant_id');
        $this->db->from('invoice i');
        $this->db->join('invoice_do ido','ido.invoice_id = i.invoice_id');
        $this->db->join('invoice_do_product idop','idop.invoice_do_id = ido.invoice_do_id');
        $this->db->where('i.invoice_id',$invoice_id);
        $res = $this->db->get();
        return $res->result_array();
    }

    public function get_invoice_product_detial($checked_data)
    {
        $this->db->select('ido.*,idop.*,i.invoice_number,i.plant_id');
        $this->db->from('invoice i');
        $this->db->join('invoice_do ido','ido.invoice_id = i.invoice_id');
        $this->db->join('invoice_do_product idop','idop.invoice_do_id = ido.invoice_do_id');
        $this->db->where_in('idop.invoice_do_product_id',$checked_data);
        $res = $this->db->get();
        return $res->result_array();
    }

}