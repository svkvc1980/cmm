<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by Roopa on 12th jan 2017 9:00AM
class Supplier extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Supplier_m");
	}
	public function supplier()
	{           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage Supplier";
		$data['nestedView']['pageTitle'] = 'Supplier';
        $data['nestedView']['cur_page'] = 'supplier_list';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Supplier', 'class' => '', 'url' => '');	

        # Search Functionality
        $p_search=$this->input->post('search_supplier', TRUE);
        if($p_search!='') 
        {
            $search_params=array(
                'supplier_code'     => $this->input->post('supplier_code', TRUE),
                'agency_name'       => $this->input->post('agency_name', TRUE)
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'supplier_code'       => $this->session->userdata('supplier_code'),
                    'agency_name'         => $this->session->userdata('agency_name')                    
                                  );
            }
            else {
                $search_params=array(
                      'supplier_code'    => '',
                      'agency_name'      => ''                     
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;
        # Default Records Per Page - always 10
        /* pagination start */
         $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'supplier/';
        # Total Records
        $config['total_rows'] = $this->Supplier_m->supplier_total_num_rows($search_params);

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
        $data['supplier_results'] = $this->Supplier_m->supplier_results($current_offset, $config['per_page'], $search_params);
       
        # Additional data
        $data['display_results'] = 1;
        $this->load->view('supplier/supplier_view',$data);
    }
    
    public function add_supplier()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Add Supplier";
        $data['nestedView']['pageTitle'] = 'Add Supplier';
        $data['nestedView']['cur_page'] = 'supplier';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/supplier.js"></script>';
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/location_ajax.js"></script>';

        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Supplier', 'class' => '', 'url' => SITE_URL.'supplier');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add New Supplier', 'class' => 'active', 'url' => '');
        $data['type'] = array('' =>'Select Type')+$this->Common_model->get_dropdown('supplier_type','type_id','name');
        //$data['location'] = array('' =>'Select Location')+$this->Common_model->get_dropdown('location','location_id','name');
        # Data
        
        # Additional data
        $data['state']= $this->Common_model->get_data('location',array('level_id'=>2,'status'=>1));
        $data['bank'] = $this->Common_model->get_data('bank',array('status'=>1));
       // $data['bank_type'] = $this->Common_model->get_data('bank',array('status'=>1));
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_supplier';
        $data['display_results'] = 0;
        $this->load->view('supplier/supplier_view',$data);
    }
    public function insert_supplier()
    {        
        // GETTING INPUT TEXT VALUES
        $data = array( 
                    'type_id'           => $this->input->post('type',TRUE),
                    'supplier_code'     => $this->input->post('supplier_code',TRUE),
                    'agency_name'       => $this->input->post('agency_name',TRUE),
                    'concerned_person'  =>$this->input->post('concerned_person',TRUE),
                    'address'           =>$this->input->post('address',TRUE),
                    'pincode'           =>$this->input->post('pincode',TRUE),
                    'mobile'            =>$this->input->post('mobile',TRUE),
                    'alternate_mobile'  =>$this->input->post('alternate_mobile',TRUE),                    
                    'aadhar_no'         =>$this->input->post('aadhar_no',TRUE),
                    'pan_no'            =>$this->input->post('pan_no',TRUE),
                    'tan_no'            =>$this->input->post('tan_no',TRUE),             
                    'created_by'        =>$this->session->userdata('user_id'),
                    'created_time'      =>date('Y-m-d H:i:s')
                    );
        if($this->input->post('location_id',TRUE)!='')
        {
            $data['location_id'] = $this->input->post('location_id',TRUE);
        }
   
        $supplier_id = $this->Common_model->insert_data('supplier',$data);

        for($i = 0; $i < count($this->input->post('bank_id',TRUE)); $i++)
        {
            /*$symbols        = array(",");
            $bgamount = $this->input->post('bg_amount',TRUE)[$i];
            $bg_amount      = str_replace($symbols, "", $bgamount);*/
            $bank_data=array(
                  'bank_id'               =>     $this->input->post('bank_id',TRUE)[$i],
                  'supplier_id'           =>     $supplier_id,
                  'ifsc_code'             =>     $this->input->post('ifsc_code',TRUE)[$i],
                  'account_no'            =>     $this->input->post('account_no',TRUE)[$i],
                  /*'bg_amount'             =>     $bg_amount,
                  'start_date'            =>     date('Y-m-d', strtotime($this->input->post('start_date',TRUE)[$i])),
                  'end_date'              =>     date('Y-m-d', strtotime($this->input->post('end_date',TRUE)[$i])),*/
                  'status'                =>     1
                  );
                $this->Common_model->insert_data('supplier_bank_guarantee',$bank_data);
        }
    
        if ($supplier_id>0)
        {
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Supplier has been added successfully! </div>');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Something went wrong. Please check. </div>');       
        }

        redirect(SITE_URL.'supplier');  
    }
     public function edit_supplier()
    {
        $supplier_id=@eip_decode($this->uri->segment(2));
        if($supplier_id==''){
            redirect(SITE_URL);
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Edit Supplier";
        $data['nestedView']['pageTitle'] = 'Edit Supplier';
        $data['nestedView']['cur_page'] = 'supplier';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/supplier.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Supplier', 'class' => '', 'url' => SITE_URL.'supplier');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Edit Supplier', 'class' => 'active', 'url' => '');
        $data['type'] = array('' =>'Select Type')+$this->Common_model->get_dropdown('supplier_type','type_id','name');
        //$data['location'] = array('' =>'Select Location')+$this->Common_model->get_dropdown('location','location_id','name');

        # Additional data
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'update_supplier';
        $data['display_results'] = 0;

        # Data
        $row = $this->Common_model->get_data('supplier',array('supplier_id'=>$supplier_id));
       
        $data['supplier_row'] = $row[0];
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

        $data['state_parent_id'] = $region_parent_id;
        $data['state']= $this->Common_model->get_data('location',array('level_id'=>2,'status'=>1));

        $data['bank'] = $this->Common_model->get_data('bank',array('status'=>1));
        $data['bank_g'] = $this->Common_model->get_data('supplier_bank_guarantee',array('supplier_id'=>$supplier_id));

        # Data       
        $this->load->view('supplier/supplier_view',$data);
    }
    public function update_supplier()
    {
        $supplier_id=@eip_decode($this->input->post('encoded_id',TRUE));
        if($supplier_id==''){
            redirect(SITE_URL);
            exit;
        } 
        $location_id = $this->input->post('location_id',TRUE);       
        $data = array( 
                    'type_id'             => $this->input->post('type',TRUE),
                    'supplier_code'       => $this->input->post('supplier_code',TRUE),
                    'agency_name'         => $this->input->post('agency_name',TRUE),
                    'concerned_person'    =>$this->input->post('concerned_person',TRUE),
                    'address'             =>$this->input->post('address',TRUE),
                    'pincode'             =>$this->input->post('pincode',TRUE),
                    'mobile'              =>$this->input->post('mobile',TRUE),
                    'alternate_mobile'    =>$this->input->post('alternate_mobile',TRUE),                    
                    'aadhar_no'           =>$this->input->post('aadhar_no',TRUE),
                    'pan_no'              =>$this->input->post('pan_no',TRUE),
                    'tan_no'              =>$this->input->post('tan_no',TRUE),                    
                    'modified_by'          =>$this->session->userdata('user_id'),
                    'modified_time'        =>date('Y-m-d H:i:s')
                    );
                    if($location_id !='') {  $data['location_id']=$location_id; }
        
        $where = array('supplier_id'=>$supplier_id);
        $res=$this->Common_model->update_data('supplier',$data,$where);

        $this->Common_model->delete_data('supplier_bank_guarantee',array('supplier_id'=>$supplier_id));
        
                for($i = 0; $i < count($this->input->post('bank_id',TRUE)); $i++)
                {
                    if($this->input->post('bank_id',TRUE)[$i] != '')
                    {
                       /* $symbols        = array(",");
                        $bgamount = $this->input->post('bg_amount',TRUE)[$i];
                        $bg_amount      = str_replace($symbols, "", $bgamount);*/
                        $bank_data=array(
                                  'bank_id'               =>     $this->input->post('bank_id',TRUE)[$i],
                                  'supplier_id'           =>     $supplier_id,
                                  'ifsc_code'             =>     $this->input->post('ifsc_code',TRUE)[$i],
                                  'account_no'            =>     $this->input->post('account_no',TRUE)[$i],
                                  /*'bg_amount'             =>     $bg_amount,
                                  'start_date'            =>     date('Y-m-d', strtotime($this->input->post('start_date',TRUE)[$i])),
                                  'end_date'              =>     date('Y-m-d', strtotime($this->input->post('end_date',TRUE)[$i])),*/
                                  'status'                =>     1
                                  );
                        $this->Common_model->insert_data('supplier_bank_guarantee',$bank_data);
                    }
                }
        if ($res)
        {
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Supplier Type has been updated successfully! </div>');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Something went wrong. Please check. </div>');       
        }

        redirect(SITE_URL.'supplier');  
    }
    public function deactivate_supplier($encoded_id)
    {
    
        $supplier_id=@eip_decode($encoded_id);
        if($supplier_id==''){
            redirect(SITE_URL);
            exit;
        }      
            $where = array('supplier_id' => $supplier_id);
            //deactivating user
            $data_arr = array('status' => 2);
            $this->Common_model->update_data('supplier',$data_arr, $where);
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Supplier  has been De-Activated successfully!</div>');
            redirect(SITE_URL.'supplier');
    }    
    public function activate_supplier($encoded_id)
    {
        $supplier_id=@eip_decode($encoded_id);
        if($supplier_id==''){
            redirect(SITE_URL);
            exit;
        }
        $where = array('supplier_id' => $supplier_id);
        //deactivating user
        $data_arr = array('status' => 1);
        $this->Common_model->update_data('supplier',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Supplier has been Activated successfully!</div>');
        redirect(SITE_URL.'supplier');
    }    
    public function download_supplier()
    {
        if($this->input->post('download_supplier')!='') {
            
            $search_params=array(
                'supplier_code'     => $this->input->post('supplier_code', TRUE),
                'agency_name'       => $this->input->post('agency_name', TRUE)                
                              );
            $suppliers = $this->Supplier_m->supplier_details($search_params);            
            $header = '';
            $data ='';
            $titles = array('S.NO','Supplier Code','Agency Name','Concerned Person','Phone Number','Pin Code','Address');
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
            if(count($suppliers)>0)
            {
                
                foreach($suppliers as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['supplier_code'].'</td>';                   
                    $data.='<td align="center">'.$row['agency_name'].'</td>';                   
                    $data.='<td align="center">'.$row['concerned_person'].'</td>';
                    $data.='<td align="center">'.$row['mobile'].'</td>';
                    $data.='<td align="center">'.$row['pincode'].'</td>';
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
            $xlFile='Supplier'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }  

}