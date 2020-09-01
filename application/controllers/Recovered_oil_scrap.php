<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Recovered_oil_scrap extends CI_Controller{

	public function __construct() 
    {
        parent::__construct();
        $this->load->model("Oil_scrap_m");

    }

    /* oil scrap details
    Author:aswini
       Time: 6pm 05-02-2017 */
public function oil_scrap()
	{
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Recovered Oil Scrap List";
		    $data['nestedView']['pageTitle'] = 'Recovered Oil Scrap List';
        $data['nestedView']['cur_page'] = 'waste_oil_scrap';
        $data['nestedView']['parent_page'] = 'waste_oil';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Recovered Oil Scrap List', 'class' => '', 'url' => '');	

        # Search Functionality
        $p_search=$this->input->post('search_recovered_oil_scarp', TRUE);
        if($p_search!='') 
        {
             $from_date=(($this->input->post('from_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('from_date', TRUE))):''; 
            $to_date=(($this->input->post('to_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('to_date', TRUE))):''; 

           $search_params=array(
                'loose_oil_id'       => $this->input->post('loose_oil'),
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
                'loose_oil_id'       =>     $this->session->userdata('loose_oil'),
                'from_date'          =>     $this->session->userdata('from_date'),
                'to_date'            =>     $this->session->userdata('to_date')
                    );
               
            }
            else {
                $search_params=array(
                'loose_oil_id'            =>    '',   
                'from_date'               =>    '',
                'to_date'                 =>    ''
                      
                                     );
                
                $this->session->set_userdata($search_params);
                 }
        }
        $data['search_data'] = $search_params;
        
         # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        
        # Total Records
        $config['base_url'] = SITE_URL . 'oil_scrap';
        $config['total_rows'] = $this->Oil_scrap_m->oil_scrap_total_num_rows($search_params);

        $config['per_page'] = getDefaultPerPageRecords();
        $data['total_rows'] = $config['total_rows'];
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        $current_offset = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        if ($data['pagination_links'] != '') {
            $data['last'] = $this->pagination->cur_page * $config['per_page'];
            if ($data['last'] > $data['total_rows']){
                $data['last'] = $data['total_rows'];
            }
            $data['pagermessage'] = 'Showing ' . ((($this->pagination->cur_page - 1) * $config['per_page']) + 1) . ' to ' . ($data['last']) . ' of ' . $data['total_rows'];
        }
        $data['sn'] = $current_offset + 1;
        /* pagination end */

        # Loading the data array to send to View
        $data['recovered_oil_scarp_row'] = $this->Oil_scrap_m->oil_scrap_results($current_offset, $config['per_page'], $search_params);
       
        # Additional data
        $data['loose_oil'] = array('' =>'Select Loose Oil')+$this->Common_model->get_dropdown('loose_oil','loose_oil_id','name');
        $data['plant_recovery_oil']=$this->Oil_scrap_m->get_plant_recovery_oil();
        $data['display_results'] = 1;
        $this->load->view('recovered_oil_scrap_view',$data);

   
    }

    /*add oil scrap details
    Author:aswini
       Time: 6pm 05-02-2017 */
	public function add_recovered_oil_scrap()
	{
        $oil_scrap_id=@cmm_decode($this->uri->segment(2));
        if($oil_scrap_id=='')
        
		# Data Array to carry the require fields to View and Model
	    $data['nestedView']['heading']="Add Recovered Oil Scrap";
        $data['nestedView']['pageTitle'] = "Add Recovered Oil Scrap";
	    $data['nestedView']['cur_page'] = 'waste_oil_scrap';
	    $data['nestedView']['parent_page'] = 'waste_oil';


	    # Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		
		$data['nestedView']['css_includes'] = array();

		# Breadcrumbs
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/recovered_oil_scrap.js" type="text/javascript"></script>';
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>"Manage Recovered Oil Scrap",'class'=>'active','url'=>'oil_scrap');
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>"Add Recovered Oil Scrap",'class'=>'active','url'=>'');
          $data['flg']=1;
         
         
        $data['form_action'] = SITE_URL.'insert_recovered_oil_scrap';
        $data['plant_recovery_oil']=$this->Common_model->get_data('loose_oil',array());
		# Additional data
		 $this->load->view('recovered_oil_scrap_view',$data);
	}

    public function get_oil_weight()
    {
        $loose_oil_id = $this->input->post('loose_oil_id');
        echo $this->Oil_scrap_m->get_oil_weight($loose_oil_id);
    }

    /*insert oil scrap details
    Author:aswini
       Time: 6pm 05-02-2017 */
  public function insert_recovered_oil_scrap()
  {       
            $on_date = $this->input->post('on_date',TRUE);
            $date=date('Y-m-d',strtotime($on_date));
            $plant_id = $this->session->userdata('ses_plant_id');
            $oil_weight=$this->input->post('oil_weight',TRUE);
            $loose_oil_id=$this->input->post('loose_oil',TRUE);
            $oil_scrap_id=$this->input->post('oil_scrap_id',TRUE);
            $remarks=$this->input->post('remarks',TRUE);
            $this->db->trans_begin();
           
             $data=array(
                'plant_id'             =>     $plant_id,
                'on_date'              =>     $date,
                'loose_oil_id'         =>     $loose_oil_id,
                'oil_weight'           =>     $oil_weight,
                'remarks'              =>     $remarks,
                'status'               =>     1,
                'created_by'           =>     $this->session->userdata('user_id'),
                'created_time'         =>     date('Y-m-d H:i:s')
                         );
                   
            $this->Common_model->insert_data('recovered_oil_scrap',$data);
               
            $old_oil_weight = $this->Common_model->get_value('plant_recovery_oil',array('plant_id'=>$plant_id,'loose_oil_id'=>$loose_oil_id),'oil_weight'); 
            $calculate_oil = $old_oil_weight-$oil_weight;

            $update_data = array('oil_weight'   => $calculate_oil,
                                 'updated_time' => date('Y-m-d H:i:s'));
            $where1 = array('plant_id'     =>  $plant_id,
                            'loose_oil_id' =>  $loose_oil_id);
            $this->Common_model->update_data('plant_recovery_oil',$update_data,$where1);
               
         // GETTING INPUT TEXT VALUES
      
      
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
                                                        <strong>Success!</strong> Oil Scrap has been added successfully! </div>');
            }
          
          
        redirect(SITE_URL.'oil_scrap');
  }
 
}


