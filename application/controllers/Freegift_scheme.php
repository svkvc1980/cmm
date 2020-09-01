<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Freegift_scheme extends Base_controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Freegift_scheme_m");              
    }

    public function freegift_scheme()
	{
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage FreeGift Scheme";
		$data['nestedView']['pageTitle'] = 'Manage FreeGift Scheme';
        $data['nestedView']['cur_page'] = 'freegift_scheme';
        $data['nestedView']['parent_page'] = 'scheme_management';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage FreeGift Scheme', 'class' => 'active', 'url' => '');

        # Search Functionality
        $fgsearch=$this->input->post('searchFreegift', TRUE);
        if($fgsearch!='') 
        {
            $searchParams=array(
                'scheme_name' => $this->input->post('scheme_name', TRUE),
                'type_id'     => $this->input->post('schemetype_id',TRUE)
                              );
            $this->session->set_userdata($searchParams);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
            $searchParams=array(
               'scheme_name'   => $this->session->userdata('scheme_name'),
               'type_id'       => $this->session->userdata('type_id')
                              );
            }
            else {
                $searchParams=array(
                      'scheme_name' => '',
                      'type_id'     => ''
                                  );
                $this->session->set_userdata($searchParams);
            }
            
        }
        $data['search_data'] = $searchParams;


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'freegift_scheme/';
        # Total Records
        $config['total_rows'] = $this->Freegift_scheme_m->freegift_scheme_total_num_rows($searchParams);
        $config['per_page'] = getDefaultPerPageRecords();
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
        $data['freegift_scheme_Results'] = $this->Freegift_scheme_m->freegift_scheme_results($current_offset, $config['per_page'], $searchParams);
        //print_r($data['userResults']); exit();
        
        # Additional data
        $data['scheme_type_list'] = $this->Common_model->get_dropdown('scheme_type','type_id','name',array('status'=>1));
        $data['display_results'] = 1;

        $this->load->view('freegift_scheme/freegift_scheme_view',$data);

    }

    public function add_freegift_scheme()
    {
		# Data Array to carry the require fields to View and Model
	    $data['nestedView']['heading']=  'Add FreeGift Scheme' ;
	    $data['nestedView']['pageTitle'] = 'Add FreeGift Scheme';
	    $data['nestedView']['cur_page'] = 'freegift_scheme';
	    $data['nestedView']['parent_page'] = 'scheme_management';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/freegift_scheme.js" type="text/javascript"></script>';
        $data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/jquery.bootstrap.wizard.min.js" type="text/javascript"></script>';
        $data['nestedView']['css_includes'] = array();
		

		# Breadcrumbs
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage FreeGift Scheme', 'class' => '', 'url' => SITE_URL.'freegift_scheme');
	    $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Add FreeGift Scheme','class'=>'active','url'=>'');



		# Additional data
        $data['flg'] = 1;
        $data['scheme_type_list'] = $this->Common_model->get_dropdown('scheme_type','type_id','name',array('status'=>1));
        $data['item_type_list'] = $this->Common_model->get_dropdown('item_type','item_type_id','name',array('status'=>1));
        $data['gift_type_list'] = $this->Common_model->get_dropdown('gift_type','gift_type_id','name',array('status'=>1));
        $data['free_gift_list'] = $this->Common_model->get_dropdown('free_gift','free_gift_id','name',array('status'=>1));
        $data['packed_product_list'] = $this->Freegift_scheme_m->get_packed_product();
        //print_r($data['packed_product_list']); exit();
        $data['form_action'] = SITE_URL.'insert_freegift_scheme';
		$data['display_results'] = 0;
        $this->load->view('freegift_scheme/freegift_scheme_view',$data);
    }

    public function insert_freegift_scheme()
    {
        $start_date = date('Y-m-d',strtotime($this->input->post('start_date',TRUE)));
        $end_date = date('Y-m-d',strtotime($this->input->post('end_date',TRUE)));
        $scheme_data = array('type_id'     => $this->input->post('scheme_type_id',TRUE),
                             'name'        => $this->input->post('scheme_name',TRUE),
                             'start_date'  => $start_date,
                             'end_date'    => $end_date,
                             'description' => $this->input->post('description',TRUE),
                             'created_by'  => $this->session->userdata('user_id'),
                             'created_time'=> date('Y-m-d H:i:s'));
        $this->db->trans_begin();
        $freegift_scheme_id = $this->Common_model->insert_data('free_gift_scheme',$scheme_data);

        for($i=0; $i<count($this->input->post('product_id'));$i++)
        {

            $fg_scheme_product_data = array('fg_scheme_id'  =>  $freegift_scheme_id,
                                            'item_type_id'  =>  $this->input->post('type_id',TRUE)[$i],
                                            'gift_type_id'  =>  $this->input->post('gift_type_id',TRUE)[$i],
                                            'product_id'    =>  $this->input->post('product_id',TRUE)[$i],
                                            'quantity'      =>  1,
                                            'status'        =>  1,
                                            'created_by'    =>  $this->session->userdata('user_id'),
                                            'created_time'  =>  date('Y-m-d H:i:s'));
            $fg_scheme_data = $this->Common_model->insert_data('fg_scheme_product',$fg_scheme_product_data);

            $gt_id = $this->input->post('gift_type_id',TRUE)[$i];
            $items_per_carton = $this->Common_model->get_value('product',array('product_id'=>$this->input->post('Packed_product_id',TRUE)[$i]),'items_per_carton');
            
            $ppro_id = $this->input->post('Packed_product_id',TRUE)[$i];
            $pp_qty = $this->input->post('pp_quantity',TRUE)[$i];
            $fg_pro_id = $this->input->post('fg_product_id',TRUE)[$i];
            $fg_qty = $this->input->post('fg_quantity',TRUE)[$i];

            if($gt_id == 1 && $ppro_id != '' && $pp_qty != '')
            {
                $pp_data = array('fgs_product_id'  =>  $fg_scheme_data,
                                 'product_id'      =>  $ppro_id,
                                 'quantity'        =>  $pp_qty,
                                 'items_per_carton'=>  $items_per_carton,
                                 'status'          =>  1,
                                 'created_by'      =>  $this->session->userdata('user_id'),
                                 'created_time'    =>  date('Y-m-d H:i:s'),
                                 'item_type_id'    =>  2);
                $this->Common_model->insert_data('fgs_free_product',$pp_data);
            }
            if($gt_id == 2 && $fg_pro_id !='' && $fg_qty != '' )
            {
                $fg_data = array('fgs_product_id'  =>  $fg_scheme_data,
                                 'free_gift_id'    =>  $fg_pro_id,
                                 'quantity'        =>  $this->input->post('fg_quantity',TRUE)[$i],
                                 'status'          =>  1,
                                 'created_by'      =>  $this->session->userdata('user_id'),
                                 'created_time'    =>  date('Y-m-d H:i:s'));
                $this->Common_model->insert_data('fgs_free_gift',$fg_data);
            }

        }
        if($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
             $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <strong>Sorry!</strong>Something Went Wrong., Please  Check. !
                             </div>');
        }
        else
        {
            $this->db->trans_commit();
             $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Success!</strong>New Free Gift Scheme added successfully! </div>');
        }
        redirect(SITE_URL.'freegift_scheme');

    }
    public function view_freegift_scheme()
    {
        $scheme_id=@cmm_decode($this->uri->segment(2));
        if($scheme_id==''){
            redirect(SITE_URL.'freegift_scheme');
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']=  'View FreeGift Scheme' ;
        $data['nestedView']['page'] = 'View FreeGift Scheme';
        $data['nestedView']['cur_page'] = 'freegift_scheme';
        $data['nestedView']['parent_page'] = 'scheme_management';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Free Gift Scheme List', 'class' => '', 'url' => SITE_URL.'freegift_scheme');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' =>'View FreeGift Scheme ', 'class' => 'active', 'url' => '');

        # Additional data
        $data['freegift_scheme'] = $this->Common_model->get_data('free_gift_scheme',array('fg_scheme_id'=>$scheme_id));
        $data['scheme_type_list'] = $this->Common_model->get_dropdown('scheme_type','type_id','name',array('status'=>1));
        $data['flg'] = 2;
        //$data['form_action'] = SITE_URL.'update_user';
        $data['displayResults'] = 0;

        # Data
        $this->load->view('freegift_scheme/freegift_scheme_view',$data);
    }
}