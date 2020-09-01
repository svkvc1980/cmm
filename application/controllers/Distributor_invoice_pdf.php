<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by maruthi 25th Feb 2017 09:00 AM

class Distributor_invoice_pdf extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        
        $this->load->model("Distributor_invoice_m");
        $this->load->model("Plant_invoice_m");
        $this->load->library('Numbertowords');
	}
	public function print_dist_invoice_details()
    {      
        $invoice_id_list = @$this->input->post('invoice_id');

        $invoice_id_direct = @cmm_decode($this->uri->segment(2));

        if($invoice_id_list=='' && $invoice_id_direct == ''){
            redirect(SITE_URL);
            exit;
        }
        if($invoice_id_list!='')
        {
            $invoice_id = $invoice_id_list;
        }
        else
        {
            $invoice_id = $invoice_id_direct;
        }
        $data['invoice_id'] = $invoice_id;
        $data['plant_name']=$this->session->userdata('plant_name');
        $inv_products = $this->Distributor_invoice_m->get_invoice_products($invoice_id);

        //echo '<pre>'; echo $this->db->last_query(); echo '<br>'; print_r($inv_products);exit;
        if($inv_products[0]['invoice_type_id'] == 2)
        {
            $data['free_products'] =$this->Distributor_invoice_m->get_free_products($inv_products[0]['invoice_id']);
            $data['free_gifts'] =$this->Distributor_invoice_m->get_free_gifts($inv_products[0]['invoice_id']);
        }
        //echo '<pre>'; echo count($data['free_gifts']).'--';exit;print_r($data['free_gifts']);exit;
        $inv_dos= $this->Distributor_invoice_m->get_invoice_dos($invoice_id);
        $inv_obs= $this->Distributor_invoice_m->get_invoice_obs($invoice_id);
        //echo '<pre>'; print_r($inv_obs);exit;
        $inv_ob_res = get_invoice_ob_type($invoice_id);
        $distributor_id = ($inv_ob_res['do_distributor_id']!='')?$inv_ob_res['do_distributor_id']:$inv_products[0]['distributor_id'];
        // Get distributor details
        $data['distributor'] = $this->Common_model->get_data_row('distributor',array('distributor_id'=>$distributor_id));
        //echo '<pre>';print_r($data['distributor']); exit;
        foreach ($inv_dos as $value) {
          $d[]=$value['do_number'];
          $do_date[] =date('d-m-Y',strtotime($value['do_date']));
        }        
        $data['inv_dos'] =implode(', ',$d);
        $data['inv_do_dates'] =implode(', ',$do_date);

        foreach ($inv_obs as $value) {
          $ob[]=$value['order_number'];
          $ob_date[] =date('d-m-Y',strtotime($value['order_date']));
        }

        $data['inv_obs'] =implode(', ',$ob);
        $data['inv_ob_dates'] =implode(', ',$ob_date);
       // $data['inv_dos']=$inv_dos;
       // echo $data['inv_dos'];exit;
        //echo $this->db->last_query();exit; 
        /*echo '<pre>';
        print_r($inv_dos);exit;*/
        @$invoice_pm = $this->Common_model->get_data('invoice_pm',array('invoice_id'=>$invoice_id));
        // echo $this->db->last_query();exit;

        // echo '<pre>'; print_r($inv_products);exit; 
        $data['inv_products']= $inv_products;
        if(count($invoice_pm))
        {
            $data['invoice_pm'] = $invoice_pm;
        }
        $this->load->view('dist_invoice/print_invoice_details',$data);
    }

    public function print_plant_invoice_details()
    {        
        $invoice_id_list = $this->input->post('invoice_id');
        $invoice_id_direct = @cmm_decode($this->uri->segment(2));

        if($invoice_id_list=='' && $invoice_id_direct == ''){
            redirect(SITE_URL);
            exit;
        }
        if($invoice_id_list!='')
        {
            $invoice_id = $invoice_id_list;
        }
        else
        {
            $invoice_id = $invoice_id_direct;
        }

        $inv_products = $this->Plant_invoice_m->get_invoice_products($invoice_id);
        if($inv_products[0]['invoice_type_id'] == 2)
        {
            $data['free_products'] =$this->Distributor_invoice_m->get_free_products($inv_products[0]['invoice_id']);
            $data['free_gifts'] =$this->Distributor_invoice_m->get_free_gifts($inv_products[0]['invoice_id']);
        }
        $inv_dos= $this->Distributor_invoice_m->get_invoice_dos($invoice_id);
        $inv_obs= $this->Distributor_invoice_m->get_invoice_obs($invoice_id);
        //echo '<pre>'; print_r($inv_obs);exit;
        
        foreach ($inv_dos as $value) {
          $d[]=$value['do_number'];
          $do_date[] =date('d-m-Y',strtotime($value['do_date']));
        }        
        $data['inv_dos'] =implode(',',$d);
        $data['inv_do_dates'] =implode(',',$do_date);

        foreach ($inv_obs as $value) {
          $ob[]=$value['order_number'];
          $ob_date[] =date('d-m-Y',strtotime($value['order_date']));
        }

        $data['inv_obs'] =implode(',',$ob);
        $data['inv_ob_dates'] =implode(',',$ob_date);
        @$invoice_pm = $this->Common_model->get_data('invoice_pm',array('invoice_id'=>$invoice_id));
        
        $data['inv_products']= $inv_products;
        if(count($invoice_pm))
        {
            $data['invoice_pm'] = $invoice_pm;
        }
        $this->load->view('plant_invoice/print_plant_invoice_details',$data);
    }
}