<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Waste_oil extends CI_Controller{

	public function __construct() 
    {
        parent::__construct();
        $this->load->model("Waste_oil_m");
    }

    /*  waste oil details
        Author:gowripriya
        Time: 11am 15-03-2017 */
public function waste_oil()
	{  
       $data['nestedView']['heading']="Manage Waste oil";
        $data['nestedView']['pageTitle'] = 'Manage Waste oil';
        $data['nestedView']['cur_page'] = 'waste_oil_entry';
        $data['nestedView']['parent_page'] = 'waste_oil';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Waste Oil', 'class' => '', 'url' => '');
        # Search Functionality
        $p_search=$this->input->post('search_waste_oil', TRUE);
        if($p_search!='') 
        {
             $from_date=(($this->input->post('from_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('from_date', TRUE))):''; 
            $to_date=(($this->input->post('to_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('to_date', TRUE))):''; 

           $search_params=array(
                'loose_oil_id'          =>    $this->input->post('loose_oil'),
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
        $config['base_url'] = SITE_URL . 'waste_oil';
        $config['total_rows'] = $this->Waste_oil_m->waste_oil_total_num_rows($search_params);

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
        $data['waste_oil_results'] = $this->Waste_oil_m->waste_oil_results($current_offset, $config['per_page'], $search_params);
       
        # Additional data
         $data['loose_oil'] = array('' =>'-Select loose oil-')+$this->Common_model->get_dropdown('loose_oil','loose_oil_id','name');
         
        $data['display_results'] = 1;
        $this->load->view('waste_oil_entry_view',$data);

   
    }

    /*  add waste oil details
        Author:gowripriya
        Time: 11am 15-03-2017 */
	public function view_waste_oil()
	{
        $data['nestedView']['heading']="Add New Waste Oil";
        $data['nestedView']['pageTitle'] = 'Add New Waste Oil';
        $data['nestedView']['cur_page'] = 'waste_oil_entry';
        $data['nestedView']['parent_page'] = 'waste_oil';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/waste_oil.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Waste Oil', 'class' => '', 'url' => SITE_URL.'waste_oil');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add New Waste Oil', 'class' => 'active', 'url' =>'');
          $data['flg']=1;
          $data['loose_oil'] = $this->Waste_oil_m->get_products();
       // $data['loose_oil']=$this->Waste_oil_m->get_products();
        //print_r($data['loose_oil']);exit;
          
        $data['form_action'] = SITE_URL.'insert_waste_oil';
        $data['flag']=2;
		# Additional data
		 $this->load->view('waste_oil_entry_view',$data);
	}

        /*insert waste oil details
        Author:gowripriya
        Time: 11am 15-03-2017 */
  public function insert_waste_oil()
  {       
              // GETTING INPUT TEXT VALUES
        $loose_oil_id=$this->input->post('loose_oil',TRUE);
        $quantity=$this->input->post('quantity',TRUE);
        $remarks=$this->input->post('remarks',TRUE);
                $data = array(
                    'plant_id'             => $this->session->userdata('ses_plant_id'),
                    'loose_oil_id'         => $loose_oil_id,
                    'quantity'             => $quantity,
                    'remarks'              => $remarks,
                    'status'               => 1,
                    'created_by'           => $this->session->userdata('user_id'),
                    'created_time'         => date('Y-m-d H:i:s'),
                    //'on_date'      =>  date('Y-m-d H:i:s')
                    );
            $waste_oil_entry=$this->Common_model->insert_data('waste_oil_entry',$data);
            $this->Waste_oil_m->insert_update_waste_oil($quantity,$loose_oil_id,$this->session->userdata('ses_plant_id'));
        
        if($waste_oil_entry>0)
        {

            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <strong>Success!</strong>Stock Details has been added successfully! </div>');
             redirect(SITE_URL.'waste_oil');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <strong>Error!</strong> Something went wrong. Please check. </div>');
             redirect(SITE_URL.'waste_oil');
        }
        
      
 
}
public function waste_oil_quantity()
    {
         # Data Array to carry the require fields to View and Model
            $data['nestedView']['heading'] = "Opening stock entry for Waste/Recovery Oil";
            $data['nestedView']['pageTitle'] = 'Opening stock Entry for Waste/Recovery Oil';
            $data['nestedView']['cur_page'] = 'waste_oil_quantity';
            $data['nestedView']['parent_page'] = 'opening_stock_entry';

            # Load JS and CSS Files
            $data['nestedView']['js_includes'] = array();
            $data['nestedView']['css_includes'] = array();

            # Breadcrumbs
            $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
            $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Opening stock Entry for Waste/Recovery Oil', 'class' => 'active', 'url' => '');

            $qry = 'SELECT * FROM loose_oil WHERE status = 1 or status = 3';
            $data['loose_oil'] = $this->Common_model->get_query_result($qry);
            $plant_id=$this->session->userdata('ses_plant_id');
            $data['plant_id'] = $plant_id;
            $query='SELECT * FROM plant_recovery_oil';
            $recovered_oil = $this->Common_model->get_query_result($query);
            foreach($recovered_oil as $key =>$value)
            {
                
                @$result[$value['loose_oil_id']][$value['plant_id']]=$value['oil_weight'];
            }
            $data['results']=@$result;
            # $data['loose_oil']=$this->Common_model->get_data('loose_oil',array('status' !=2 'status'=>3));
            if($this->input->post('oil_quantity'))
            {
                $quantity=$this->input->post('quantity');
                $oil_id=$this->input->post('oil_id');
                
                $this->db->trans_begin();
                foreach($quantity as $key=>$value)
                {
                    if($value !='')
                    {
                       
                        $query = 'select * from plant_recovery_oil where loose_oil_id="'.$key.'" AND plant_id="'.$plant_id.'"';
                        $count = $this->Common_model->get_no_of_rows($query);
                        if($count>0)
                        {
                           
                            
                            $a=$this->Common_model->update_data('plant_recovery_oil',array('oil_weight'=>$quantity[$key]),array('loose_oil_id'=>$key,'plant_id'=>$plant_id));
                           
                        }
                        else
                        {
                          
                           $pm= array( 
                                'oil_weight'    =>  $quantity[$key],
                                'plant_id'      =>  $plant_id,                
                                'loose_oil_id'  =>  $key,
                                'updated_time'  =>date('Y-m-d H:i:s')
                                       );
                           $oil_quantity = $this->Common_model->insert_data('plant_recovery_oil',$pm);
                       }
                        
                    }
                }
                if($this->db->trans_status() === FALSE)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <strong>Error!</strong> Something went wrong. Please check. </div>');
                    redirect(SITE_URL.'waste_oil_quantity');

                }
                else
                {
                    $this->db->trans_commit(); 
                    $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <strong>Success!</strong>Oil Recovery Stock Details has been added successfully! </div>');
                    redirect(SITE_URL.'waste_oil_quantity');
                }
            }
           

            $this->load->view('stock_entry/waste_oil_stock_entry',$data);

          

    }

}
