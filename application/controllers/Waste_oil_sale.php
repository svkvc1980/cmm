<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
/*waste oil sale results
Author:Roopa
Time: 11.00AM 13-03-2017 */ 
class Waste_oil_sale extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Waste_oil_sale_m");
	}
    /*waste oil sale results
    Author:Roopa
    Time: 11.00AM 13-03-2017 */
	public function waste_oil_sale()
	{
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage Waste Oil Sale";
		$data['nestedView']['pageTitle'] = 'Manage Waste Oil Sale';
        $data['nestedView']['cur_page'] = 'waste_oil_sale';
        $data['nestedView']['parent_page'] = 'waste_oil';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Waste Oil Sale', 'class' => '', 'url' => '');
        $p_search=$this->input->post('search_waste_oil_sale', TRUE);
        if($p_search!='') 
        {
            $from_date=(($this->input->post('from_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('from_date', TRUE))):''; 
            $to_date=(($this->input->post('to_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('to_date', TRUE))):''; 

           $search_params=array(
                'buyer_name'         => $this->input->post('buyer_name'),
                'from_date'          => $from_date,
                'to_date'            => $to_date
               
                               );
            $this->session->set_userdata($search_params);
        } 
        else 
        { 
            
           if($this->uri->segment(2)!='')
            {

            $search_params=array(
                'buyer_name'         => $this->session->userdata('buyer_name'),
                'from_date'          => $this->session->userdata('from_date'),
                'to_date'            => $this->session->userdata('to_date')
                    );
               
            }
            else {
                $search_params=array(
                'buyer_name'         => '',   
                'from_date'          => '',
                'to_date'            => ''
                      
                                     );
                $this->session->set_userdata($search_params);
            }
        }
        $data['search_data'] = $search_params;
        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'waste_oil_sale/';
        # Total Records
        $config['total_rows'] = $this->Waste_oil_sale_m->sludge_sale_total_num_rows($search_params);
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
        $data['waste_oil_sale_results'] = $this->Waste_oil_sale_m->waste_oil_sale_results($current_offset, $config['per_page'], $search_params);
       
        # Additional data
        $data['display_results'] = 1;
        $this->load->view('waste_oil_sale_view',$data);
    }
    /*waste oil sale results
    Author:Roopa
    Time: 11.00AM 13-03-2017 */
    public function add_waste_oil_sale()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Add New Waste Oil Sale";
        $data['nestedView']['pageTitle'] = 'Add New Waste Oil Sale';
        $data['nestedView']['cur_page'] = 'waste_oil_sale';
        $data['nestedView']['parent_page'] = 'waste_oil';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
         $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/waste_oil_sale.js"></script>';
        $data['nestedView']['css_includes'] = array();
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Waste Oil Sale', 'class' => '', 'url' => SITE_URL.'waste_oil_sale');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add New Waste Oil Sale', 'class' => 'active', 'url' => '');
        # Search Functionality
        # Data
        $data['plant_recovery_oil'] =$this->Common_model->get_data('loose_oil',array());

        # Additional data
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_waste_oil_sale';
        $data['plant_id']=$this->session->userdata('ses_plant_id');
        $data['display_results'] = 0;
        $this->load->view('waste_oil_sale_view',$data);
    }
     /*waste oil sale results
    Author:Roopa
    Time: 11.00AM 13-03-2017 */
    public function insert_waste_oil_sale()
    {
        $on_date=date('Y-m-d',strtotime($this->input->post('on_date',TRUE)));
        // GETTING INPUT TEXT VALUES
        $data = array( 
                   'on_date'           => $on_date,
                   'plant_id'          => $this->input->post('plant_id'),
                   'buyer_name'        => $this->input->post('buyer_name'),
                   'contact_details'   => $this->input->post('mobile'),
                   'address'           => $this->input->post('address'),
                   'remarks'           => $this->input->post('remarks'),
                   'status'            => 1,
                   'created_by'        => $this->session->userdata('user_id'),
                   'created_time'      => date('Y-m-d H:i:s')                   
                    );
        $waste_sale_id = $this->Common_model->insert_data('waste_oil_sale',$data);
            $data1= array(
                        'waste_sale_id' => $waste_sale_id,
                        'loose_oil_id'  => $this->input->post('loose_oil_id'),
                        'quantity'      => $this->input->post('quantity'),
                        'unit_price'    => $this->input->post('cost'),
                        'created_by'    => $this->session->userdata('user_id'),
                        'created_time'  => date('Y-m-d H:i:s')
                         );
            $this->Common_model->insert_data('waste_oil_sale_product',$data1);
            $this->Waste_oil_sale_m->update_plant_recovery_oil($this->input->post('loose_oil_id'),$this->session->userdata('ses_plant_id'),$this->input->post('quantity',date('Y-m-d H:i:s')));

         if ($waste_sale_id>0)
        {
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Success!</strong> Waste Oil sale has been added successfully! </div>');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Error!</strong> Something went wrong. Please check. </div>');
        }
        redirect(SITE_URL.'waste_oil_sale');
    }

    public function get_loose_oil_details()
    {
        if($this->input->post('loose_oil_id'))
        {
            $loose_oil_id=$this->input->post('loose_oil_id');
            echo $this->Waste_oil_sale_m->get_loose_oil_details($loose_oil_id);
       }
    }
}