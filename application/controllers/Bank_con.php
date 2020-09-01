<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Bank_con extends Base_controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Bank_model");
        $this->load->model("Common_model");               
    }
        public function bank()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Bank ";
        $data['nestedView']['pageTitle'] = 'BANK';
        $data['nestedView']['cur_page'] = 'bank';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Bank', 'class' => 'active', 'url' => 'bank');

        # Search Functionality
        $psearch=$this->input->post('searchbank', TRUE);
        if($psearch!='') 
        {
            $searchParams=array(
                               'bank_name' => $this->input->post('bank_name', TRUE)
                               );
            $this->session->set_userdata($searchParams);
        } 
        else 
        {

        if($this->uri->segment(2)!='')
            {
            $searchParams=array(
                              'bank_name'=>$this->session->userdata('bank_name')
                              );
            }
            else {
                $searchParams=array(
                                    'bank_name'=>''
                                   );
                $this->session->set_userdata($searchParams);
            }
            
        }
        $data['search_data'] = $searchParams;


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'bank/';
        # Total Records
        $config['total_rows'] = $this->Bank_model->bank_total_num_rows($searchParams);

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
        $data['bankResults'] = $this->Bank_model->bank_results($current_offset, $config['per_page'], $searchParams);
        
        # Additional data
        $data['portlet_title'] = '';
        $data['displayResults'] = 1;

        $this->load->view('Bank',$data);

    }

public function add_bank()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="BANK";
        $data['nestedView']['pageTitle'] = 'Add New Bank';
        $data['nestedView']['cur_page'] = 'bank';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/bank.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add New Bank', 'class' => 'active', 'url' => '');

        # Additional data
        $data['portlet_title'] = 'Add New Bank';
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_bank';
        $data['displayResults'] = 0;
        $this->load->view('Bank',$data);
    }

//Nagarjuna 21th Jan 2017 03:00 pm
public function insert_bank()
    {
        $data = array(
                      'name'    =>      $this->input->post('bank_name',TRUE),
                      'created_by'    =>  $this->session->userdata('user_id')
                    );
        $bank_id = $this->Common_model->insert_data('bank',$data);
        if($bank_id>0)
        {
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                      <strong>Success!</strong> Bank has been added successfully! </div>');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                      <strong>Error!</strong> Something went wrong. Please check. </div>');       
        }

        redirect(SITE_URL.'bank');  
    }

public function edit_bank()
    {
        $bank_id=@cmm_decode($this->uri->segment(2));
        if($bank_id=='')
        {
            redirect(SITE_URL);
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="BANK";
        $data['nestedView']['pageTitle'] = 'Edit Bank';
        $data['nestedView']['cur_page'] = 'bank';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/bank.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Edit Bank', 'class' => 'active', 'url' => '');

        # Additional data
        $data['portlet_title'] = 'Edit Bank Name';
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'update_bank';
        $data['displayResults'] = 0;

        # Data
        $row = $this->Common_model->get_data('bank',array('bank_id'=>$bank_id));
        $data['lrow'] = $row[0];
        $this->load->view('Bank',$data);
    }

//Nagarjuna 21th Jan 2017 03:00 pm
public function update_bank()
    {
        $bank_id=@cmm_decode($this->input->post('encoded_id',TRUE));
        if($bank_id==''){
            redirect(SITE_URL);
            exit;
        }
        // GETTING INPUT TEXT VALUES
        /*$user_id=1;*/
        $data = array( 
                    'name'               =>      $this->input->post('bank_name',TRUE),
                    'modified_by'             =>      $this->session->userdata('user_id'),
                    'modified_time'           =>      date('Y-m-d H:i:s')
                    );
        $where = array('bank_id'=>$bank_id);
        $res = $this->Common_model->update_data('bank',$data,$where);

        if ($res)
        {
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Bank has been updated successfully! </div>');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Something went wrong. Please check. </div>');       
        }

        redirect(SITE_URL.'bank');  
    }

public function deactivate_bank($encoded_id)
    {
    
        $bank_id=@cmm_decode($encoded_id);
        if($bank_id==''){
            redirect(SITE_URL);
            exit;
        }
        $where = array('bank_id' => $bank_id);
        //deactivating user
        $data_arr = array('status' => 2,
                          'modified_by'   => $this->session->userdata('user_id'),
                          'modified_time' => date('Y-m-d H:i:s'));
        $this->Common_model->update_data('bank',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Bank has been De-Activated successfully!</div>');
        redirect(SITE_URL.'bank');

    }
public function activate_bank($encoded_id)
    {
        $bank_id=@cmm_decode($encoded_id);
        if($bank_id==''){
            redirect(SITE_URL);
            exit;
        }
        $where = array('bank_id' => $bank_id);
        //deactivating user
        $data_arr = array('status' => 1,
                          'modified_by'   => $this->session->userdata('user_id'),
                          'modified_time' => date('Y-m-d H:i:s'));
        $this->Common_model->update_data('bank',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Bank has been Activated successfully!</div>');
            redirect(SITE_URL.'bank');

    }
public function download_bank()
    {
        if($this->input->post('downloadbank')!='') {
            
            $searchParams=array(
                               'bank_name' => $this->input->post('bank_name', TRUE)
                               );
            $bank = @$this->Bank_model->bank_details($searchParams);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','Bank');
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
            if(count(@$bank)>0)
              {
                foreach(@$bank as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['bank_name'].'</td>';
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
            $xlFile='bank_'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }

//Function to check the uniqueness of Bank_name
    public  function is_bankExist()
    {
        $bank_name = $this->input->post('bank_name');
        $bank_id = $this->input->post('bank_id');
        echo $this->Bank_model->is_bankExist($bank_name,$bank_id);
    }
//ending of Uniqueness of bankname - nagarjune//
}

