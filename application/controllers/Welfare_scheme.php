<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Welfare_scheme extends CI_Controller{

	public function __construct() 
    {
        parent::__construct();
        $this->load->model("Welfare_scheme_m");

    }

/* search welfare details
Author:Aswini
Time: 3.22PM 28-02-2017 */
public function welfare_scheme()
	{
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="welfare scheme List";
		$data['nestedView']['pageTitle'] = 'welfare scheme List';
        $data['nestedView']['cur_page'] = 'welfare_scheme';
        $data['nestedView']['parent_page'] = 'scheme_management';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'welfare scheme List', 'class' => 'active', 'url' => '');	

        # Search Functionality
        $p_search=$this->input->post('search_welfare_scheme', TRUE);
        if($p_search!='') 
        {
            $start_date = $this->input->post('start_date',TRUE);
            if($start_date=='') $start_date = '';
            else $start_date = date('Y-m-d',strtotime($start_date));

            $end_date = $this->input->post('end_date',TRUE);
            if($end_date=='') $end_date = '';
            else $end_date = date('Y-m-d',strtotime($end_date));

            $search_params=array(
                'name'                  =>    $this->input->post('name', TRUE),
                'start_date'            =>    $start_date,                             
                'end_date'              =>    $end_date,
                'discount_percentage'   =>    $this->input->post('discount_percentage',TRUE)
                               );
            $this->session->set_userdata($search_params);
        } 
        else 
        {  $start_date = $this->input->post('start_date',TRUE);
            if($start_date=='') $start_date = '';
            else $start_date = date('Y-m-d',strtotime($start_date));

            $end_date = $this->input->post('end_date',TRUE);
            if($end_date=='') $end_date = '';
            else $end_date = date('Y-m-d',strtotime($end_date));
            
           if($this->uri->segment(2)!='')
            {
                $search_params=array(
                'name'                  =>    $this->session->userdata('name'),
                'start_date'            =>    $start_date,
                'end_date'              =>    $end_date,
                'discount_percentage'   =>    $this->input->post('discount_percentage')
                                    );
            }
            else {
                $search_params=array(
                      'name'               => '',
                      'start_date'         => '',
                      'end_date'           => '',
                      'discount_percentage'=> ''
                                     );
                $this->session->set_userdata($search_params);
                 }
        }
        $data['search_data'] = $search_params;
        
         # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        
        # Total Records
        $config['base_url'] = SITE_URL . 'welfare_scheme/';
        $config['total_rows'] = $this->Welfare_scheme_m->welfare_scheme_rows($search_params);

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
        $data['welfare_scheme_row'] = $this->Welfare_scheme_m->welfare_scheme_results($current_offset, $config['per_page'], $search_params);
        # Additional data
        $data['display_results'] = 1;
        $this->load->view('welfare_scheme',$data);

   
    }
   /*Adding welfare scheme details
    Author:aswini
   Time: 4.50PM 28-02-2017 */
	public function add_welfare_scheme()
	{
        $welfare_scheme_id=@cmm_decode($this->uri->segment(2));
        if($welfare_scheme_id=='')
        
		# Data Array to carry the require fields to View and Model
	    $data['nestedView']['heading']="Add Welfare Scheme";
        $data['nestedView']['pageTitle'] = "Add Welfare Scheme";
	    $data['nestedView']['cur_page'] = 'welfare_scheme';
        $data['nestedView']['parent_page'] = 'scheme_management';


	    # Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/welfare_scheme.js" type="text/javascript"></script>';
		$data['nestedView']['css_includes'] = array();

		# Breadcrumbs
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>"Welfare Scheme List",'class'=>'','url'=>SITE_URL.'welfare_scheme');
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>"Add Welfare Scheme",'class'=>'active','url'=>'');
        
        # Additional data
        $data['flg']=1;
        $data['form_action'] = SITE_URL.'insert_welfare_scheme';

		 $this->load->view('welfare_scheme',$data);
	}

    /*insert welfare scheme details
    Author:aswini
       Time: 6pm 28-02-2017 */
  public function insert_welfare_scheme()
  {       
        $start_date = date('Y-m-d', strtotime($this->input->post('start_date',TRUE)));
        $end_date = date('Y-m-d', strtotime($this->input->post('end_date',TRUE)));

         // GETTING INPUT TEXT VALUES
      $data=array(
            'name'                 =>     $this->input->post('name'),
            'description'          =>     $this->input->post('description'),
            'start_date'           =>     $start_date,
            'end_date'             =>     $end_date,
            'discount_percentage'  =>     $this->input->post('discount_percentage')
            //'status'        =>   1
                  );
       
            $this->db->trans_begin();
            $where= array('welfare_scheme_id'=>$welfare_scheme_id);
            $plant = $this->Common_model->insert_data('welfare_scheme',$data,$where);
      
           if ($this->db->trans_status()===FALSE)
            {
                $this->db->trans_rollback();
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Error!</strong> Something went wrong. Please check. </div>'); 
            }
            else
            {
                $this->db->trans_commit();
                    $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Success!</strong> welfare scheme has been added successfully! </div>');
            }
          
          
        redirect(SITE_URL.'welfare_scheme');
  }
  /*edit welfare scheme details
   Author:aswini
     Time: 6.00PM 28-02-2017 */

 public function edit_welfare_scheme()
    {
        $welfare_scheme_id=@cmm_decode($this->uri->segment(2));
        if($welfare_scheme_id==''){
            redirect(SITE_URL.'welfare_scheme');
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Edit welfare scheme";
        $data['nestedView']['pageTitle'] = 'Edit welfare scheme';
        $data['nestedView']['cur_page'] = 'welfare_scheme';
        $data['nestedView']['parent_page'] = 'scheme_management';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/welfare_scheme.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage welfare scheme', 'class' => '', 'url' => SITE_URL.'welfare_scheme');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Edit welfare scheme', 'class' => 'active', 'url' => '');

        # Additional data
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'update_welfare_scheme';
        $data['display_results'] = 0;

        # Data
        $row = $this->Common_model->get_data('welfare_scheme',array('welfare_scheme_id'=>$welfare_scheme_id));
        $data['welfare_scheme_row'] = $row[0];
         $this->load->view('welfare_scheme',$data);
    }
    /*update welfare scheme details
     Author:aswini
    Time: 6.00PM 28-02-2017 */

    public function update_welfare_scheme()
    {
       
        $welfare_scheme_id=@cmm_decode($this->input->post('encoded_id',TRUE));
        if($welfare_scheme_id==''){
            redirect(SITE_URL);
            exit;
             }
        // GETTING INPUT TEXT VALUES
         $start_date = date('Y-m-d', strtotime($this->input->post('start_date',TRUE)));
         $end_date   = date('Y-m-d', strtotime($this->input->post('end_date',TRUE)));
          $data = array( 
                    'name'                =>     $this->input->post('name'),
                    'description'         =>     $this->input->post('description'),
                    'start_date'          =>     $start_date,
                    'end_date'            =>     $end_date,
                    'discount_percentage' =>     $this->input->post('discount_percentage'),
                    'modified_by'         =>     $this->session->userdata('user_id'),
                    'modified_time'       =>     date('Y-m-d H:i:s')
                       );
        
         $where = array('welfare_scheme_id'=>$welfare_scheme_id);
         $res = $this->Common_model->update_data('welfare_scheme',$data,$where);

         $welfare_scheme_id=@cmm_decode($this->input->post('encoded_id',TRUE));
           

        if ($res)
        {
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> welfare scheme  has been updated successfully! </div>');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Something went wrong. Please check. </div>');       
        }

        redirect(SITE_URL.'welfare_scheme');  
    }
   /*deactivating welfare scheme details
    Author:aswini
    Time: 10.00Am 01-03-2017 */
    public function deactivate_welfare_scheme($encoded_id)
    {
    
        $welfare_scheme_id=@cmm_decode($encoded_id);
        if($welfare_scheme_id==''){
            redirect(SITE_URL);
            exit;
        }
       
            $where = array('welfare_scheme_id' => $welfare_scheme_id);
            //deactivating user
            $data_arr = array('status' => 2);
            $this->Common_model->update_data('welfare_scheme',$data_arr, $where);
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> welfare scheme  has been De-Activated successfully!</div>');
            redirect(SITE_URL.'welfare_scheme');           
     }
    /*activating welfare scheme details
      Author:aswini
       Time: 10.00Am 01-03-2017 */
    public function activate_welfare_scheme($encoded_id)
    {
        $welfare_scheme_id=@cmm_decode($encoded_id);
        if($welfare_scheme_id==''){
            redirect(SITE_URL);
            exit;
        }
        $where = array('welfare_scheme_id' => $welfare_scheme_id);
        //deactivating user
        $data_arr = array('status' => 1);

        $this->Common_model->update_data('welfare_scheme',$data_arr, $where);
        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> welfare scheme has been Activated successfully!</div>');
        redirect(SITE_URL.'welfare_scheme');

    }
   /* downloading welfare scheme details
Author:aswini
Time: 10.00Am 01-03-2017 */
    public function download_welfare_scheme()
    {
        if($this->input->post('download_welfare_scheme')!='') {
            
            $search_params=array(
                'name'     => $this->input->post('name', TRUE),
                              
                              );
            $welfare_schemes = $this->Welfare_scheme_m->welfare_scheme_details($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','Name','Description','Start date','End date','Discount percentage');
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
            if(count($welfare_schemes)>0)
            {
                
                foreach($welfare_schemes as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['name'].'</td>';                   
                    $data.='<td align="center">'.$row['description'].'</td>';                   
                    $data.='<td align="center">'.$row['start_date'].'</td>';
                    $data.='<td align="center">'.$row['end_date'].'</td>';
                    $data.='<td align="center">'.$row['discount_percentage'].'</td>';
                   
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
            $xlFile='Welfare scheme'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }
}


