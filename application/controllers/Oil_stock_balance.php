<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by maruthi 21th Feb 2017 09:00 AM

class Oil_stock_balance extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Production_m");
        $this->load->model("Oil_stock_balance_m");
	}
	public function manage_oil_stock_balance()
	{
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage Oil Stock Balance ";
		$data['nestedView']['pageTitle'] = 'Manage Oil Stock Balance';
        $data['nestedView']['cur_page'] = 'manage_oil_stock_balance';
        $data['nestedView']['parent_page'] = 'inventory';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Oil Stock Balance', 'class' => '', 'url' => '');	

        # Search Functionality
        $p_search=$this->input->post('search_oil_stock_balance', TRUE);
        if($p_search!='') 
        {
            $from_date=(($this->input->post('from_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('from_date', TRUE))):''; 
            $to_date=(($this->input->post('to_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('to_date', TRUE))):''; 
            $search_params=array(
                'loose_oil_id'       => $this->input->post('loose_oil_id', TRUE),                
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
                'loose_oil_id'       => $this->session->userdata('loose_oil_id'),                
                'from_date'          => $this->session->userdata('from_date'),
                'to_date'            => $this->session->userdata('to_date')
                    );
            }
            else 
            {
                $search_params=array(
                    'loose_oil_id'      => '',
                    'from_date'         => '',
                    'to_date'           => ''
                        );
                $this->session->set_userdata($search_params);
            }            
        }
        /*echo '<pre>';
        print_r($search_params);exit;*/
        $data['searchParams'] = $search_params;

        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'manage_oil_stock_balance/';
        # Total Records
        $config['total_rows'] = $this->Oil_stock_balance_m->oil_stock_balance_total_num_rows($search_params);

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
        $data['oil_stock_balance_results'] = $this->Oil_stock_balance_m->oil_stock_balance_results($current_offset, $config['per_page'], $search_params);
        $data['loose_oils']         = $this->Common_model->get_data('loose_oil',array('status'=>'1'));
        # Additional data
        $data['display_results'] = 1;
        $this->load->view('oil_stock_balance/oil_stock_balance_entry_view',$data);
    }    
    public function oil_stock_balance_entry()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Oil Stock Balance Entry";
        $data['nestedView']['pageTitle'] = 'Oil Stock Balance Entry';
        $data['nestedView']['cur_page'] = 'manage_oil_stock_balance';
        $data['nestedView']['parent_page'] = 'inventory';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/oil_stock_balance_entry.js"></script>';

        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Oil Stock Balance Entry', 'class' => '', 'url' => SITE_URL.'manage_oil_stock_balance');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Oil Stock Balance Entry', 'class' => '', 'url' => '');
        
        # Additional data        
        $data['loose_oil']= $this->Common_model->get_data('loose_oil',array('status'=>1));

        // Checking 10:30 time to restict opening balace taken
        $myTime = get_opening_balance_reading_time();
        if (date('H:i') >= date('H:i', strtotime($myTime))) {

             $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Sorry!</strong> You are not allowed to take reading after'.$myTime.' </div>');       
            redirect(SITE_URL.'manage_oil_stock_balance');
           
        }
        

        // checking if reading already taken for today or not
        $err = $this->Oil_stock_balance_m->get_today_num_of_records();       
        if(@$err)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Sorry!</strong> Today Reading already Taken </div>');       
            redirect(SITE_URL.'manage_oil_stock_balance');

        }
        else
        {
           $res = $this->Oil_stock_balance_m->get_latest_stock_balance_record();
            if(@$res){
                $data['last_reading_taken']=date('d-m-Y',strtotime(@$res['on_date']));
                
            }else{
                $data['last_reading_taken']=date('d-m-Y');
            } 
                 
            $data['form_action'] = SITE_URL.'confirm_oil_stock_balance_entry';
            $data['flg']=1;

            if(@$this->input->post('cancel',TRUE) == 2)
            {
                $data['oil_stock_balance_entry_list']=$_POST;
                //echo '<pre>';print_r( $data['oil_stock_balance_entry_list']);exit;
                $this->load->view('oil_stock_balance/oil_stock_balance_entry_edit_view',$data); 
            }
            else
            {
                $this->load->view('oil_stock_balance/oil_stock_balance_entry_view',$data);  
            } 
        }
                                    
    }    
    public function confirm_oil_stock_balance_entry()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Confirm Oil Stock Balance Entry";
        $data['nestedView']['pageTitle'] = 'Confirm Oil Stock Balance Entry';
        $data['nestedView']['cur_page'] = 'manage_oil_stock_balance';
        $data['nestedView']['parent_page'] = 'inventory';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/oil_stock_balance_entry.js"></script>';

        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Oil Stock Balance Entry', 'class' => '', 'url' => SITE_URL.'manage_oil_stock_balance_entry');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Oil Stock Balance Entry', 'class' => 'active', 'url' => 'oil_stock_balance_entry');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Confirm Oil Stock Balance Entry', 'class' => 'active', 'url' => '');

        # Data
        
        # Additional data
        $res = $this->Oil_stock_balance_m->get_latest_stock_balance_record();
        if(@$res){
            $data['last_reading_taken']=date('d-m-Y',strtotime(@$res['on_date']));
            
        }else{
            $data['last_reading_taken']=date('d-m-Y');
        }
        $data['oil_stock_balance_entry_list'] = $_POST;
        /*echo '<pre>';
        print_r($data['oil_stock_balance_entry_list']);exit;*/
        
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_oil_stock_balance_entry';
        $data['display_results'] = 0;
        $this->load->view('oil_stock_balance/confirm_oil_stock_balance_entry_view',$data);
    }    
    public function insert_oil_stock_balance_entry()
    {
        /*echo '<pre>';
        print_r($_POST);
        exit;*/
        
        

        foreach ($_POST['opening_balance'] as $key => $value) 
        {
            // checking for closing balance for latest record
            $res = $this->Oil_stock_balance_m->get_latest_stock_balance_record($key);
            /*echo '<pre>';
            print_r($res);exit;*/
            if(@$res)
            {
                //echo '<pre>';
                //print_r($res);exit;
                // closing balance Updation for previous record
                $where=array('oil_stock_balance_id'=>$res['oil_stock_balance_id']);
                $update_data=array(
                    'closing_balance'   => $value,
                    'modified_by'       => $this->session->userdata('user_id'),
                    'modified_time'     => date('Y-m-d H:i:s'),
                    
                    );
                $this->Common_model->update_data('oil_stock_balance',$update_data,$where);

                // opening balance insertion for today
                $first_time_insert_data = array(
                        'loose_oil_id'      => $key,
                        'plant_id'          => get_plant_id(),
                        'on_date'           => date('Y-m-d'),
                        'opening_balance'   => $value,
                        'created_by'        => $this->session->userdata('user_id'),
                        'created_time'      =>  date('Y-m-d H:i:s')
                        );
                $this->Common_model->insert_data('oil_stock_balance',$first_time_insert_data);
            }
            else
            {
              //exit;  
                // inserting opening balance when no records are in database
                $first_time_insert_data = array(
                        'loose_oil_id'      => $key,
                        'plant_id'          => get_plant_id(),
                        'remarks'           => $this->input->post('remarks',TRUE)[$key],
                        'on_date'           => date('Y-m-d'),
                        'opening_balance'   => $value,
                        'created_by'        => $this->session->userdata('user_id'),
                        'created_time'      => date('Y-m-d H:i:s')
                        );
                $this->Common_model->insert_data('oil_stock_balance',$first_time_insert_data);

            }
        }   
        
       
        

        if ($this->db->trans_status() === FALSE)
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
                                                    <strong>Success!</strong> Oil Stock Balance Entry  successfully! </div>');
        }
       
        redirect(SITE_URL.'manage_oil_stock_balance');
    }
    public function download_oil_stock_balance()
    {
        if($this->input->post('download_oil_stock_balance')!='') {
            
            $from_date=(($this->input->post('from_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('from_date', TRUE))):''; 
            $to_date=(($this->input->post('to_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('to_date', TRUE))):''; 
            $search_params=array(
                'loose_oil_id'       => $this->input->post('loose_oil_id', TRUE),
                'from_date'          => $from_date,
                'to_date'            => $to_date
                );
            $oil_stock_balance = $this->Oil_stock_balance_m->oil_Stock_balance_details($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','Plant','Loose Oil','Opening Bal(MT)','Date','Receipts(MT)','Production(MT)','Closing Balance(MT)','Wastage(KG)','allowable Wastage(KG)','status');
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
            if(count($oil_stock_balance)>0)
            {                
                foreach($oil_stock_balance as $row)
                {
                    $allowed    = $row['production']*(get_allowed_percentage()/100);
                    if($row['closing_balance']!='')
                    {
                        if($row['wastage'] > $allowed)
                        {
                            $status = 'Limit Exceed';
                        }
                        else
                        {   
                            $status='Within Range';
                        }
                    }
                    else
                    {
                        $status ='N/A';
                    }
                    $closing_bal = ($row['closing_balance']!='')?$row['closing_balance']:"N/A";
                    $wastage = ($row['closing_balance']!='')?$row['wastage']*1000:"N/A";
                    $allowed = ($row['closing_balance']!='')?$allowed*1000:"N/A";
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.get_plant_name().'</td>';                   
                    $data.='<td align="center">'.get_loose_oil_name($row['loose_oil_id']).'</td>';                   
                    $data.='<td align="center">'.$row['opening_balance'].'</td>';
                    $data.='<td align="center">'.date('Y-m-d',strtotime($row['on_date'])).'</td>';
                    $data.='<td align="center">'.$row['receipts'].'</td>';
                    $data.='<td align="center">'.$row['production'].'</td>'; 
                    $data.='<td align="center">'.$closing_bal.'</td>';  
                    $data.='<td align="center">'.$wastage.'</td>';  
                    $data.='<td align="center">'.$allowed.'</td>';                   
                    $data.='<td align="center">'.$status.'</td>';                   
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
            $xlFile='Oil Stock Balance'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }
    
}