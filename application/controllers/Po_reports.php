<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';
class Po_reports extends Base_controller
{

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Po_reports_model");
        $this->load->library('Pdf');
        //$this->load->library('Numbertowords');
    }
    
    //Mounika
    public function loose_oil_report()
    {    
         //$this->Po_reports_model->get();exit;    
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Purchase Order (Oil) Report";  
        $data['nestedView']['pageTitle'] = 'Purchase Order (Oil) Report';
        $data['nestedView']['cur_page'] = 'po_oil_r';
        $data['nestedView']['parent_page'] = 'reports';
        $data['nestedView']['list_page'] = 'po_reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Purchase Order (Oil) Report', 'class' => '', 'url' => '');

        # Search Functionality
        $psearch=$this->input->post('search_loose_oil', TRUE);
        if($psearch!='') {
            $start_date=$this->input->post('start_date');
            if($start_date=='')
            {
                $start_date='';
            }
            else
            {
                $start_date= date('Y-m-d',strtotime($this->input->post('start_date')));
            }
            //echo $start_date;exit;
            $end_date=$this->input->post('end_date');
            if($end_date=='')
            {
                $end_date='';
            }
            else
            {
                $end_date= date('Y-m-d',strtotime($this->input->post('end_date')));
            }
            $search_params=array(
                        'po_number'     =>   $this->input->post('po_no', TRUE),
                        'plant_id'      =>   $this->input->post('plant_id'),
                        'loose_oil_id'  =>   $this->input->post('loose_oil_id',TRUE),
                        'broker_id'     =>   $this->input->post('broker_id',TRUE),
                        'supplier_id'   =>   $this->input->post('supplier_id',TRUE),
                        'status'        =>   $this->input->post('status',TRUE),
                        'start_date'    =>   $start_date,
                        'end_date'      =>   $end_date
                           );
        $this->session->set_userdata($search_params);
        } else {

            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                        'po_number'    =>   $this->session->userdata('po_number'),
                        'plant_id'     =>   $this->session->userdata('plant_id'),
                        'loose_oil_id' =>   $this->session->userdata('loose_oil_id'),
                        'broker_id'    =>   $this->session->userdata('broker_id'),
                        'supplier_id'  =>   $this->session->userdata('supplier_id'),
                        'status'       =>   $this->session->userdata('status'),
                        'start_date'   =>   $this->session->userdata('start_date'),
                        'end_date'     =>   $this->session->userdata('end_date')
                            );
            }
            else 
            {
                $search_params=array(
                        'po_number'    =>  '',
                        'plant_id'     =>  '',
                        'loose_oil_id' =>  '',
                        'broker_id'    =>  '',
                        'supplier_id'  =>  '',
                        'status'       =>  1,
                        'start_date'   =>  '',
                        'end_date'     =>  ''
                               );
                $this->session->set_userdata($search_params);
            }
        }
        $data['search_params'] = $search_params;
        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'loose_oil_report/';
        # Total Records
        $config['total_rows'] = $this->Po_reports_model->loose_oil_total_num_rows($search_params);
        $config['per_page'] = getDefaultPerPageRecords_ops();
        $data['total_rows'] = $config['total_rows'];
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        $current_offset = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        if ($data['pagination_links'] != '') {
            $data['last'] = $this->pagination->cur_page * $config['per_page'];
            if ($data['last'] > $data['total_rows']) {
                $data['last'] = $data['total_rows'];
            }
            $data['pagermessage'] = 'Showing ' . ((($this->pagination->cur_page - 1) * $config['per_page']) + 1) . ' to ' . ($data['last']) . ' of ' . $data['total_rows'];
        }
        $data['sn'] = $current_offset + 1;
        /* pagination end */
        # Loading the data array to send to View

        $data['loose_oil'] = $this->Po_reports_model->loose_oil_results($search_params,$config['per_page'], $current_offset);
        $data['plant'] = $this->Po_reports_model->get_plant();
        $data['loose'] = $this->Po_reports_model->getloose_oil();
        $data['broker']= $this->Po_reports_model->get_broker();
        $data['supplier']= $this->Po_reports_model->get_supplier();
        $data['status']= get_po_status();
        $this->load->view('po_reports/loose_oil_report',$data);
    }

    public function print_loose_oil()
    {
        
        $po_oil_id=@cmm_decode($this->uri->segment(2));
        if($po_oil_id=='')
        {
            redirect(SITE_URL);
            exit;
        }
          
        $data['loose_oil_results'] = $this->Po_reports_model->print_loose_oil($po_oil_id); 
        
        $data['oil_id']=3;
        $this->load->view('po_reports/print_loose_oil',$data);
    }

    public function print_loose_oil_report()
    {
        if($this->input->post('print_loose_oil')!='') {
            
            $start_date=$this->input->post('start_date');
            if($start_date=='')
            {
                $start_date='';
            }
            else
            {
                $start_date= date('Y-m-d',strtotime($this->input->post('start_date')));
            }
            //echo $start_date;exit;
            $end_date=$this->input->post('end_date');
            if($end_date=='')
            {
                $end_date='';
            }
            else
            {
                $end_date= date('Y-m-d',strtotime($this->input->post('end_date')));
            }
            $search_params=array(
                        'po_number'     =>   $this->input->post('po_no', TRUE),
                        'plant_id'      =>   $this->input->post('plant_id'),
                        'loose_oil_id'  =>   $this->input->post('loose_oil_id',TRUE),
                        'broker_id'     =>   $this->input->post('broker_id',TRUE),
                        'supplier_id'   =>   $this->input->post('supplier_id',TRUE),
                        'status'        =>   $this->input->post('status',TRUE),
                        'start_date'    =>   $start_date,
                        'end_date'      =>   $end_date
                        );
            
            $loose_oil_report = $this->Po_reports_model->get_loose_oil_reports(@$search_params);
            $lor=array();
                foreach($loose_oil_report as $key =>$value)
                {
                    if(array_key_exists(@$keys,$lor))
                    {
                        $lor[$value['loose_oil_id']] ['products'][] =array(
                           'po_oil_id' => $value['po_oil_id'],
                           'loose_short_name'=>$value['loose_short_name'],
                           'status' => $value['status'],
                           'po_number' => $value['po_number'],
                           'po_date' => $value['po_date'],
                           'unit_price' => $value['unit_price'],
                           'quoted_qty' => $value['quoted_qty'],
                           'received_qty' => $value['received_qty'],
                           'loose_oil_id' => $value['loose_oil_id'],
                           'loose_name' => $value['loose_name'],
                           'po_type_id' => $value['po_type_id'],
                           'type_name' => $value['type_name'],
                           'supplier_id' => $value['supplier_id'],
                           'supplier_name' => $value['supplier_name'],
                           'supplier_code' => $value['supplier_code'],
                           'broker_id' => $value['broker_id'],
                           'broker_name' => $value['broker_name'],
                           'broker_code' => $value['broker_code'],
                           'plant_id' => $value['plant_id'],
                           'plant_name' => $value['plant_name'],
                           'mtp_number' => $value['mtp_number']
                             );
                    }
                    else
                    {
                        $lor[$value['loose_oil_id']]['loose_oil']=$value['loose_name'];
                        $lor[$value['loose_oil_id']] ['products'][] =array(
                          'po_oil_id' => $value['po_oil_id'],
                          'status' => $value['status'],
                          'loose_short_name'=>$value['loose_short_name'],
                           'po_number' => $value['po_number'],
                           'po_date' => $value['po_date'],
                           'unit_price' => $value['unit_price'],
                           'quoted_qty' => $value['quoted_qty'],
                           'received_qty' => $value['received_qty'],
                           'loose_oil_id' => $value['loose_oil_id'],
                           'loose_name' => $value['loose_name'],
                           'po_type_id' => $value['po_type_id'],
                           'type_name' => $value['type_name'],
                           'supplier_id' => $value['supplier_id'],
                           'supplier_name' => $value['supplier_name'],
                           'supplier_code' => $value['supplier_code'],
                           'broker_id' => $value['broker_id'],
                           'broker_name' => $value['broker_name'],
                           'broker_code' => $value['broker_code'],
                           'plant_id' => $value['plant_id'],
                           'plant_name' => $value['plant_name'],
                           'mtp_number' => $value['mtp_number']
                            );
                    }
                }
            $data['lor']=$lor;
           
        }

       $data['search_params']=$search_params;
       //print_r($data['loose_oil_report']);exit;
        $this->load->view('po_reports/print_loose_oil_report',$data);
    }

    public function pm_report()
    {       
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO Packing Material Report";  
        $data['nestedView']['pageTitle'] = 'PO Packing Material Report';
        $data['nestedView']['cur_page'] = 'po_pm_r';
        $data['nestedView']['parent_page'] = 'reports';
        $data['nestedView']['list_page'] = 'po_reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        //$data['nestedView']['js_includes'][] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO Packing Material Report', 'class' => '', 'url' => '');

        # Search Functionality
        $psearch=$this->input->post('search_pm', TRUE);
        if($psearch!='') {
            $start_date=$this->input->post('start_date');
            if($start_date=='')
            {
                $start_date='';
            }
            else
            {
                $start_date= date('Y-m-d',strtotime($this->input->post('start_date')));
            }
            //echo $start_date;exit;
            $end_date=$this->input->post('end_date');
            if($end_date=='')
            {
                $end_date='';
            }
            else
            {
                $end_date= date('Y-m-d',strtotime($this->input->post('end_date')));
            }
            $search_params=array(
                        'po_number'     =>   $this->input->post('po_no', TRUE),
                        'plant_id'      =>   $this->input->post('plant_id'),
                        'pm_id'         =>   $this->input->post('pm_id',TRUE),
                        'supplier_id'   =>   $this->input->post('supplier_id',TRUE),
                        'status'        =>   $this->input->post('status',TRUE),
                        'start_date'    =>   $start_date,
                        'end_date'      =>   $end_date
                           );
        $this->session->set_userdata($search_params);
        } else {

            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                        'po_number'    =>   $this->session->userdata('po_number'),
                        'plant_id'     =>   $this->session->userdata('plant_id'),
                        'pm_id'        =>   $this->session->userdata('pm_id'),
                        'supplier_id'  =>   $this->session->userdata('supplier_id'),
                        'status'       =>   $this->session->userdata('status'),
                        'start_date'   =>   $this->session->userdata('start_date'),
                        'end_date'     =>   $this->session->userdata('end_date')
                            );
            }
            else 
            {
                $search_params=array(
                        'po_number'    =>  '',
                        'plant_id'     =>  '',
                        'pm_id'        =>  '',
                        'supplier_id'  =>  '',
                        'status'       =>  1,
                        'start_date'   =>  '',
                        'end_date'     =>  ''
                               );
                $this->session->set_userdata($search_params);
            }
        }
        $data['search_params'] = $search_params;
        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'pm_report/';
        # Total Records
        $config['total_rows'] = $this->Po_reports_model->pm_total_num_rows($search_params);
        $config['per_page'] = getDefaultPerPageRecords();
        $data['total_rows'] = $config['total_rows'];
        //print_r($data['total_rows']);exit;
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        $current_offset = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        if ($data['pagination_links'] != '') {
            $data['last'] = $this->pagination->cur_page * $config['per_page'];
            if ($data['last'] > $data['total_rows']) {
                $data['last'] = $data['total_rows'];
            }
            $data['pagermessage'] = 'Showing ' . ((($this->pagination->cur_page - 1) * $config['per_page']) + 1) . ' to ' . ($data['last']) . ' of ' . $data['total_rows'];
        }
        $data['sn'] = $current_offset + 1;
        /* pagination end */
        # Loading the data array to send to View

        $data['packing_material'] = $this->Po_reports_model->pm_results($search_params,$config['per_page'], $current_offset);
        //print_r($data['packing']);exit;
        $data['plant'] = $this->Po_reports_model->get_plant();
        $data['packing'] = $this->Po_reports_model->get_packing_material();
        //$data['broker']= $this->Po_reports_model->get_broker();
        $data['supplier']= $this->Po_reports_model->get_pm_supplier();
        $data['status']= get_po_pm_status();
        //print_r($data['status']);exit;
        $this->load->view('po_reports/pm_report',$data);
    }

     public function print_pm()
    {
        
        $po_pm_id=@cmm_decode($this->uri->segment(2));
        if($po_pm_id=='')
        {
            redirect(SITE_URL);
            exit;
        }
          
        $pm_results = $this->Po_reports_model->print_pm($po_pm_id); 
        $data['pm_results']=$pm_results;
         if($pm_results['pm_id']==get_tape_650mt() || $pm_results['pm_id']==get_tape_65mt() ) 
        {
            $preference=$this->Common_model->get_data_row('preference',array('name'=>$pm_results['pm_id']));
            $data['meters']=$preference['value'];
        } 
        else
        {
            $data['meters']=1;
        }
        $data['pm_received_qty']=$this->Po_reports_model->get_pm_received_qty($pm_results['po_pm_id'],$pm_results['pm_category_id']);
        $data['pm_id']=2;
        
        $this->load->view('po_reports/print_pm',$data);
    }

    public function print_pm_report()
    {
        if($this->input->post('print_pm')!='') {
            
            $start_date=$this->input->post('start_date');
            if($start_date=='')
            {
                $start_date='';
            }
            else
            {
                $start_date= date('Y-m-d',strtotime($this->input->post('start_date')));
            }
            //echo $start_date;exit;
            $end_date=$this->input->post('end_date');
            if($end_date=='')
            {
                $end_date='';
            }
            else
            {
                $end_date= date('Y-m-d',strtotime($this->input->post('end_date')));
            }
            $search_params=array(
                        'po_number'     =>   $this->input->post('po_no', TRUE),
                        'plant_id'      =>   $this->input->post('plant_id'),
                        'pm_id'         =>   $this->input->post('pm_id',TRUE),
                        'supplier_id'   =>   $this->input->post('supplier_id',TRUE),
                        'status'        =>   $this->input->post('status',TRUE),
                        'start_date'    =>   $start_date,
                        'end_date'      =>   $end_date
                           );
            
            $print_pm_report = $this->Po_reports_model->get_pm_reports($search_params);
            $data['search_params'] = $search_params;
            foreach ($print_pm_report as $key => $value) 
            {
                $pm_received_qty=$this->Po_reports_model->get_pm_received_qty_report($value['po_pm_id'],$value['pm_category_id']);
                if($value['pm_id']==get_tape_650mt() || $value['pm_id']==get_tape_65mt() ) 
                {
                    $preference=$this->Common_model->get_data_row('preference',array('name'=>$value['pm_id']));
                    $meters=$preference['value'];
                } 
               else
                {
                    $meters=1;
                }
                //echo $this->db->last_query().'<br>';
                $print_pm_report[$key]['received_qty'] = $pm_received_qty/$meters;
            }
            //exit;
            //echo '<pre>';print_r($print_pm_report); exit();
            $data['print_pm_report']=$print_pm_report;
            //echo $this->db->last_query();exit;
            //print_r($data['pm_received_qty']);exit;
        }
        //print_r($data['loose_oil_report']);exit;
        $this->load->view('po_reports/print_pm_report',$data);
    }

}