<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Oil_tanker extends CI_Controller
{

	public function __construct() 
    {
        parent::__construct();
        $this->load->model("Common_model");
        $this->load->model("Oil_tanker_m"); 
    }

/*Search Tanker details
 Author:Roopa
 Time: 1.30PM 11-02-2017*/
    public function oil_tanker()
    {           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage Oil Tank";
        $data['nestedView']['pageTitle'] = 'Oil Tank';
        $data['nestedView']['cur_page'] = 'oil_tanker';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'ops';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/oil_tanker.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Oil Tank', 'class' => '', 'url' => '');    

        # Search Functionality
        $p_search=$this->input->post('search_oil_tanker', TRUE);
        if($p_search!='') 
        {
            $search_params=array(
                'name'          => $this->input->post('name', TRUE),
                'loose_oil_id'  => $this->input->post('loose_oil', TRUE)            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'name'           => $this->session->userdata('name'),
                    'loose_oil_id'   => $this->session->userdata('loose_oil')
                    
                    
                                  );
            }
            else {
                $search_params=array(
                      'name'            => '',
                      'loose_oil_id'   =>''
                     
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;
        


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'oil_tanker/';
        # Total Records
        $config['total_rows'] = $this->Oil_tanker_m->oil_tanker_total_num_rows($search_params);

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
        //$data['plantlist']=$this->Oil_tanker_m->getdetails();
        $data['loose_oil'] = array('' =>'Loose Oil')+$this->Common_model->get_dropdown('loose_oil','loose_oil_id','name');
        /* pagination end */

        # Loading the data array to send to View
        $data['oil_tanker_results'] = $this->Oil_tanker_m->oil_tanker_results($current_offset, $config['per_page'], $search_params);
       
        # Additional data
        $data['display_results'] = 1;
        
        $this->load->view('oil_tanker/oil_tanker_view',$data);

    }


/*Adding Distributor details
Author:Roopa
Time: 2.50PM 11-02-2017 */
	public function add_oil_tank()
	{        
		# Data Array to carry the require fields to View and Model
	    $data['nestedView']['heading']="Manage Oil Tank";
	    $data['nestedView']['cur_page'] = 'oil_tanker';
	    $data['nestedView']['pageTitle'] = 'Manage Oil Tank';
	    $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'ops';


	    # Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/oil_tanker.js"></script>';
		
		$data['nestedView']['css_includes'] = array();

		# Breadcrumbs
		$data['nestedView']['pageTitle'] = 'Add Oil Tank';
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Add Oil Tank','class'=>'active','url'=>'');

       $data['plantlist']=$this->Oil_tanker_m->get_plant_details();
       $data['loose_oil'] = array('' =>'Select Loose Oil')+$this->Common_model->get_dropdown('loose_oil','loose_oil_id','name');
       //print_r($data['plantlist']);exit();

		# Additional data
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_oil_tank';
        $data['display_results'] = 0;      
    	
        $this->load->view('oil_tanker/oil_tanker_view',$data);
	}
/*Insert Oil_tanker details
Author:Roopa
Time: 5.40AM 11-02-2017 */
    public function insert_oil_tank()
    {
        // GETTING INPUT TEXT VALUES
        $data=array(
                'name'           =>     $this->input->post('oil_tank_name'),                       
                'capacity'       =>     $this->input->post('tank_capacity'),
                'plant_id'       =>     $this->input->post('plant_id'),
                'loose_oil_id'   =>     $this->input->post('loose_oil')
                    );
        $this->db->trans_begin();
        $oil_tanker = $this->Common_model->insert_data('oil_tank',$data);
        
        $data1=array(
                    'oil_tank_id'      =>    $oil_tanker,                      
                    'loose_oil_id'     =>    $this->input->post('loose_oil'),
                    'start_date'       =>    date('Y-m-d H:i:s'),
                    'created_by'       =>    $this->session->userdata('user_id')     
                ); 

        $oil_tanker = $this->Common_model->insert_data('oil_tank_history',$data1);           
        if ($this->db->trans_status=== FALSE)
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
                                                    <strong>Success!</strong> Oil Tanker has been added successfully! </div>');
        }                  
            
        redirect(SITE_URL.'oil_tanker');
    } 
    /*Insert Oil_tanker details
      Author:Gowri
      Time: 5.40AM 11-02-2017 */
    public function edit_oil_tank()
    {
        $oil_tank_id=@eip_decode($this->uri->segment(2));
        if($oil_tank_id==''){
            redirect(SITE_URL);
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Change OilTank";
        $data['nestedView']['pageTitle'] = 'Change OilTank';
        $data['nestedView']['cur_page'] = 'oil_tanker';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'ops';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/oiltank.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage OilTank', 'class' => '', 'url' => SITE_URL.'oil_tanker');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Change Oil Tank', 'class' => 'active', 'url' => '');

       $data['plantlist']=$this->Oil_tanker_m->get_plant_details();
       $data['loose_oil'] = array('' =>'Select Loose Oil')+$this->Common_model->get_dropdown('loose_oil','loose_oil_id','name');
        # Additional data
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'update_oil_tank';
        $data['display_results'] = 0;

        # Data
        $row = $this->Common_model->get_data('oil_tank',array('oil_tank_id'=>$oil_tank_id));
        $plant_id=$row[0]['plant_id'];
        $data['oil_tanker_row'] = $row[0];

        $row1= $this->Common_model->get_data('plant',array('plant_id'=>$plant_id));       
        $data['plant_id']=$row1[0];
        
        $this->load->view('oil_tanker/oil_tanker_view',$data);
    }
     /*Insert Oil_tanker details
      Author:Gowri
      Time: 5.40AM 11-02-2017 */
    public function update_oil_tank()
    {
        $oil_tank_id=@eip_decode($this->input->post('encoded_id',TRUE));
        $loose_oil =  $this->input->post('loose_oil',TRUE);
        $get_oil_tank_id=$this->Oil_tanker_m->get_oil_tank_id($oil_tank_id,$loose_oil);      
        if($get_oil_tank_id != '')
        {
              $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> no changes!</div>');
            redirect(SITE_URL.'oil_tanker');

        }
        else
        {
           
            $where = array('oil_tank_id' => $oil_tank_id);
            $data  = array(
                    'loose_oil_id'  => $loose_oil,
                    'modified_by'   => $this->session->userdata('user_id'), 
                    'modified_time' => date('Y-m-d H:i:s')
                );            
            $this->Common_model->update_data('oil_tank',$data,$where);

            #update history table

            $get_oth_id = $this->Common_model->get_value('oil_tank_history',array('oil_tank_id' => $oil_tank_id,'end_date' => null),'oth_id');
            
            $update_data  = array(
                    'end_date' => date('Y-m-d H:i:s'),
                    'modified_by' => $this->session->userdata('user_id') 
                    );
            $where1 = array('oth_id' => $get_oth_id);           
            $this->Common_model->update_data('oil_tank_history',$update_data,$where1); 

            $insert_data  = array(
                    'oil_tank_id' => $oil_tank_id,
                    'loose_oil_id' => $loose_oil,
                    'start_date' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('user_id') 
                    );
            $oth_id = $this->Common_model->insert_data('oil_tank_history',$insert_data);         
            if($oth_id != '')
            {
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> oiltank  has been changed successfully!</div>');
            redirect(SITE_URL.'oil_tanker');
            }
            else
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong>error!</div>');
                redirect(SITE_URL.'oil_tanker');
            }

        }
        redirect(SITE_URL.'oil_tanker');  
    }
    /*Insert Oil_tanker details
      Author:Gowri
      Time: 5.40AM 11-02-2017 */
    public function deactivate_oil_tank($encoded_id)
    {
    
        $oil_tank_id=@eip_decode($encoded_id);
        if($oil_tank_id==''){
            redirect(SITE_URL);
            exit;
        }
        $where = array('oil_tank_id' => $oil_tank_id);
        //deactivating user
        $data_arr = array('status' => 2);
        $this->Common_model->update_data('oil_tank',$data_arr, $where);
        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                <strong>Success!</strong> oiltank  has been De-Activated successfully!</div>');
        redirect(SITE_URL.'oil_tanker');           
        

    }
     /*Insert Oil_tanker details
      Author:Gowri
      Time: 5.40AM 11-02-2017 */
    public function activate_oil_tank($encoded_id)
    {
        $oil_tank_id=@eip_decode($encoded_id);
        if($oil_tank_id==''){
            redirect(SITE_URL.'oil_tanker');
            exit;
        }
        $where = array('oil_tank_id' => $oil_tank_id);
        //deactivating user
        $data_arr = array('status' => 1);
        $this->Common_model->update_data('oil_tank',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> oiltank has been Activated successfully!</div>');
        redirect(SITE_URL.'oil_tanker');

    }
     /*Insert Oil_tanker details
      Author:Aswini
      Time: 5.40AM 11-02-2017 */
   public function download_oil_tank()
    {
        if($this->input->post('download_oil_tank')!='') 
        {
            $search_params=array(
                              'name'        => $this->input->post('name', TRUE),
                              'loose_oil_id' => $this->input->post('loose_oil', TRUE)   
                                );
            $oil_tanker = $this->Oil_tanker_m->oil_tanker_details($search_params);            
            $header = '';
            $data ='';
            $titles = array('S.NO','name','capacity','plant_id');
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
            if(count($oil_tanker)>0)
            {
                
                foreach($oil_tanker as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['name'].'</td>'; 
                    $data.='<td align="center">'.$row['capacity'].'</td>'; 
                    $data.='<td align="center">'.$row['plant_name'].'</td>';                                      
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
            $xlFile='oil_tank'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
        }
    }
	
}
?>