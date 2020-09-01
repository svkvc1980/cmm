<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

class Broker extends CI_Controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Broker_m");
	}


	public function broker()
	{
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage Broker";
		$data['nestedView']['pageTitle'] = 'Broker';
        $data['nestedView']['cur_page'] = 'broker_list';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Broker', 'class' => 'active', 'url' => '');	

        # Search Functionality
        $p_search=$this->input->post('search_broker', TRUE);
        if($p_search!='') 
        {
            $search_params=array(
                'broker_code' => $this->input->post('broker_code', TRUE),
                'agency_name'       => $this->input->post('agency_name', TRUE)
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'broker_code'   => $this->session->userdata('broker_code'),
                    'agency_name'   => $this->session->userdata('agency_name'),
                    
                                  );
            }
            else {
                $search_params=array(
                      'broker_code'    => '',
                      'agency_name'    => '',
                     
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;
        


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'broker/';
        # Total Records
        $config['total_rows'] = $this->Broker_m->broker_total_num_rows($search_params);

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
        $data['broker_results'] = $this->Broker_m->broker_results($current_offset, $config['per_page'], $search_params);
       
        # Additional data
        $data['display_results'] = 1;

        $this->load->view('broker_view',$data);

    }
    
    public function add_broker()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Add Broker";
        $data['nestedView']['pageTitle'] = 'Add Broker';
        $data['nestedView']['cur_page'] = 'broker';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/broker.js"></script>';
        //$data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/location_ajax.js"></script>';

        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Broker', 'class' => '', 'url' => SITE_URL.'broker');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add New Broker', 'class' => 'active', 'url' => '');

        # Data
        
        # Additional data
        $data['state']= $this->Common_model->get_data('location',array('level_id'=>2,'status'=>1));
        $data['bank'] = $this->Common_model->get_data('bank',array('status'=>1));
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_broker';
        $data['display_results'] = 0;
        //echo '123';exit;
        $this->load->view('broker_view',$data);
    }

    public function insert_broker()
    {
       
        // GETTING INPUT TEXT VALUES
        $data = array( 
                    'broker_code'       => $this->input->post('broker_code',TRUE),
                    'agency_name'       => $this->input->post('agency_name',TRUE),
                    'concerned_person'  =>$this->input->post('concerned_person',TRUE),
                    'address'           =>$this->input->post('address',TRUE),
                    'pincode'           =>$this->input->post('pincode',TRUE),
                    'vat_no'            =>$this->input->post('vat_no',TRUE),
                    'mobile'            =>$this->input->post('mobile',TRUE),                    
                    'alternate_mobile'  =>$this->input->post('alternate_mobile',TRUE),
                    'aadhar_no'         =>$this->input->post('aadhar_no',TRUE),
                    'pan_no'            =>$this->input->post('pan_no',TRUE),
                    'tan_no'            =>$this->input->post('tan_no',TRUE),                    
                    'created_by'        =>$this->session->userdata('user_id')
                    //'created_time'      =>date('Y-m-d H:i:s')
                    );
        $city = $this->input->post('city',TRUE);
        if($city!='')
        {
            $data['location_id'] = $city;
        }
        $broker_id = $this->Common_model->insert_data('broker',$data);

        $banks = $this->input->post('bank_id',TRUE);
        $banks = array_filter($banks);
        if($banks)
        {
            for($i = 0; $i < count($this->input->post('bank_id',TRUE)); $i++)
            {
               /* $symbols        = array(",");
                $bgamount = $this->input->post('bg_amount',TRUE)[$i];
                $bg_amount      = str_replace($symbols, "", $bgamount);*/
                $bank_data=array(
                      'bank_id'               =>     $this->input->post('bank_id',TRUE)[$i],
                      'broker_id'             =>     $broker_id,
                      'ifsc_code'             =>     $this->input->post('ifsc_code',TRUE)[$i],
                      'account_no'            =>     $this->input->post('account_no',TRUE)[$i],
                      /*'bg_amount'             =>     $bg_amount,
                      'start_date'            =>     date('Y-m-d', strtotime($this->input->post('start_date',TRUE)[$i])),
                      'end_date'              =>     date('Y-m-d', strtotime($this->input->post('end_date',TRUE)[$i])),*/
                      'status'                =>     1
                      );
                    $this->Common_model->insert_data('broker_bank_guarantee',$bank_data);
            }
        }

        if ($broker_id>0)
        {
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Broker has been added successfully! </div>');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Something went wrong. Please check. </div>');       
        }

        redirect(SITE_URL.'broker');  
    }

     public function edit_broker()
    {
        $broker_id=@cmm_decode($this->uri->segment(2));
        if($broker_id=='')
        {
            redirect(SITE_URL.'broker');
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Edit Broker";
        $data['nestedView']['pageTitle'] = 'Edit Broker';
        $data['nestedView']['cur_page'] = 'broker';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/broker.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Broker', 'class' => '', 'url' => SITE_URL.'broker');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Edit Broker', 'class' => 'active', 'url' => '');

        # Additional data
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'update_broker';
        $data['display_results'] = 0;

        # Data
        $row = $this->Common_model->get_data('broker',array('broker_id'=>$broker_id));
        $data['state']= $this->Common_model->get_data('location',array('level_id'=>2,'status'=>1));
        $data['broker_row'] = $row[0];

        /*koushik*/
        $city_id = $row[0]['location_id'];

        $city_parent_id = $this->Common_model->get_value('location',array('location_id'=>$city_id),'parent_id');
        $data['city_parent_id'] = $city_id;
        $data['city'] = $this->Common_model->get_data('location',array('parent_id'=>$city_parent_id));

        $mandal_parent_id = $this->Common_model->get_value('location',array('location_id'=>$city_parent_id),'parent_id');
        $data['mandal_parent_id'] = $city_parent_id;
        $data['mandal'] = $this->Common_model->get_data('location',array('parent_id'=>$mandal_parent_id));

        $district_parent_id = $this->Common_model->get_value('location',array('location_id'=>$mandal_parent_id),'parent_id');
        $data['district_parent_id'] = $mandal_parent_id;
        $data['district'] = $this->Common_model->get_data('location',array('parent_id'=>$district_parent_id));

        $region_parent_id = $this->Common_model->get_value('location',array('location_id'=>$district_parent_id),'parent_id');
        $data['region_parent_id'] = $district_parent_id;
        $data['region'] = $this->Common_model->get_data('location',array('parent_id'=>$region_parent_id));

        $data['loacation_parent_id'] = $region_parent_id;
        $data['location']= $this->Common_model->get_data('location',array('location_id','status'=>1));

        $data['bank'] = $this->Common_model->get_data('bank',array('status'=>1));
        $data['bank_g'] = $this->Common_model->get_data('broker_bank_guarantee',array('broker_id'=>$broker_id));
        
        $this->load->view('broker_view',$data);
    }

    public function update_broker()
    {
        $broker_id=@cmm_decode($this->input->post('encoded_id',TRUE));
        if($broker_id==''){
            redirect(SITE_URL);
            exit;
        }
        // GETTING INPUT TEXT VALUES
        $location_id = $this->input->post('city',TRUE);
        $data = array( 
                    'broker_code'       => $this->input->post('broker_code',TRUE),
                    'agency_name'       => $this->input->post('agency_name',TRUE),
                    'concerned_person'  =>$this->input->post('concerned_person',TRUE),
                    'address'           =>$this->input->post('address',TRUE),
                    'pincode'           =>$this->input->post('pincode',TRUE),
                    'vat_no'            =>$this->input->post('vat_no',TRUE),
                    'mobile'            =>$this->input->post('mobile',TRUE),                    
                    'alternate_mobile'  =>$this->input->post('alternate_mobile',TRUE),
                    'aadhar_no'         =>$this->input->post('aadhar_no',TRUE),
                    'pan_no'            =>$this->input->post('pan_no',TRUE),
                    'tan_no'            =>$this->input->post('tan_no',TRUE),                    
                    'modified_by'       =>$this->session->userdata('user_id'),
                    'modified_time'     =>date('Y-m-d H:i:s')
                    );
                    if($location_id != '') { $data['location_id'] = $location_id; }
        
        $where = array('broker_id'=>$broker_id);
        $res=$this->Common_model->update_data('broker',$data,$where);

        $this->Common_model->delete_data('broker_bank_guarantee',array('broker_id'=>$broker_id));
              
              for($i = 0; $i < count($this->input->post('bank_id',TRUE)); $i++)
                {
                    if($this->input->post('bank_id',TRUE)[$i] != '')
                    {
                        /*$symbols        = array(",");
                        $bgamount = $this->input->post('bg_amount',TRUE)[$i];
                        $bg_amount      = str_replace($symbols, "", $bgamount);*/
                        $bank_data=array(
                                  'bank_id'               =>     $this->input->post('bank_id',TRUE)[$i],
                                  'broker_id'             =>     $broker_id,
                                  'ifsc_code'             =>     $this->input->post('ifsc_code',TRUE)[$i],
                                  'account_no'            =>     $this->input->post('account_no',TRUE)[$i],
                                 /* 'bg_amount'             =>     $bg_amount,
                                  'start_date'            =>     date('Y-m-d', strtotime($this->input->post('start_date',TRUE)[$i])),
                                  'end_date'              =>     date('Y-m-d', strtotime($this->input->post('end_date',TRUE)[$i])),*/
                                  'status'                =>     1
                                  );
                        $this->Common_model->insert_data('broker_bank_guarantee',$bank_data);
                    }
                }
        $employee_id=@cmm_decode($this->input->post('encoded_id',TRUE));
        
        if ($res)
        {
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Broker Type has been updated successfully! </div>');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Something went wrong. Please check. </div>');       
        }

        redirect(SITE_URL.'broker');  
    }

    public function deactivate_broker($encoded_id)
    {
    
        $broker_id=@cmm_decode($encoded_id);
        if($broker_id==''){
            redirect(SITE_URL);
            exit;
        }
       
            $where = array('broker_id' => $broker_id);
            //deactivating user
            $data_arr = array('status' => 2);
            $this->Common_model->update_data('broker',$data_arr, $where);
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Broker  has been De-Activated successfully!</div>');
            redirect(SITE_URL.'broker');           
     }
    
    public function activate_broker($encoded_id)
    {
        $broker_id=@cmm_decode($encoded_id);
        if($broker_id==''){
            redirect(SITE_URL);
            exit;
        }
        $where = array('broker_id' => $broker_id);
        //deactivating user
        $data_arr = array('status' => 1);

        $this->Common_model->update_data('broker',$data_arr, $where);
        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Broker has been Activated successfully!</div>');
        redirect(SITE_URL.'broker');

    }
    
    public function download_broker()
    {
        if($this->input->post('download_broker')!='') {
            
            $search_params=array(
                'broker_code'     => $this->input->post('broker_code', TRUE),
                'agency_name' => $this->input->post('agency_name', TRUE),                
                              );
            $brokers = $this->Broker_m->broker_details($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','Broker Code','Agency Name','Concerned Person','Mobile Number','Address');
            $data = '<table border="1">';
            $data.='<thead>';
            $data.='<tr>';
            foreach ( $titles as $title)
            {
                $data.= '<th align="center">'.$title.'</th>';
            }
            $data.='</tr>';
            $data.='</thead>';
            $data.='<tbody>';
             $j=1;
            if(count($brokers)>0)
            {
                
                foreach($brokers as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['broker_code'].'</td>';                   
                    $data.='<td align="center">'.$row['agency_name'].'</td>';                   
                    $data.='<td align="center">'.$row['concerned_person'].'</td>';
                    $data.='<td align="center">'.$row['mobile'].'</td>';
                    $data.='<td align="center">'.$row['address'].'</td>';
                    $data.='</tr>';
                    $j++;
                }
            }
            else
            {
                $data.='<tr><td colspan="'.(count($titles)+1).'" align="center">No Results Found</td></tr>';
            }
            $data.='</tbody>';
            $data.='</table>';
            $time = date("Ymdhis");
            $xlFile='Broker'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }
}