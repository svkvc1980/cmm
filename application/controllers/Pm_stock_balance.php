<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by maruthi 21th Feb 2017 09:00 AM

class Pm_stock_balance extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Production_m");
        $this->load->model("Pm_stock_balance_m");
	}
	public function manage_pm_stock_balance()
	{
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage Pm Stock Balance ";
		$data['nestedView']['pageTitle'] = 'Manage Pm Stock Balance';
        $data['nestedView']['cur_page'] = 'manage_pm_stock_balance';
        $data['nestedView']['parent_page'] = 'inventory';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Pm Stock Balance', 'class' => '', 'url' => '');	

        # Search Functionality
        $p_search=$this->input->post('search_pm_stock_balance', TRUE);
        if($p_search!='') 
        {
            $from_date=(($this->input->post('from_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('from_date', TRUE))):''; 
            $to_date=(($this->input->post('to_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('to_date', TRUE))):''; 
            $search_params=array(
                'pm_id'       => $this->input->post('pm_id', TRUE),                
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
                'pm_id'              => $this->session->userdata('pm_id'),                
                'from_date'          => $this->session->userdata('from_date'),
                'to_date'            => $this->session->userdata('to_date')
                    );
            }
            else 
            {
                $search_params=array(
                    'pm_id'             => '',
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
        $config['base_url'] = SITE_URL . 'manage_pm_stock_balance/';
        # Total Records
        $config['total_rows'] = $this->Pm_stock_balance_m->pm_stock_balance_total_num_rows($search_params);

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
        $data['pm_stock_balance_results'] = $this->Pm_stock_balance_m->pm_stock_balance_results($current_offset, $config['per_page'], $search_params);
        $data['packing_material']         = $this->Common_model->get_data('packing_material',array('status'=>'1'));
        # Additional data
        $data['display_results'] = 1;
        $this->load->view('pm_stock_balance/pm_stock_balance_entry_view',$data);
    } 
    // Other Than Film Category   
    public function pm_stock_balance_entry()
    {
       
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Pm Stock Balance Entry";
        $data['nestedView']['pageTitle'] = 'Pm Stock Balance Entry';
        $data['nestedView']['cur_page'] = 'manage_pm_stock_balance';
        $data['nestedView']['parent_page'] = 'inventory';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/pm_stock_balance_entry.js"></script>';

        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Pm Stock Balance Entry', 'class' => '', 'url' => SITE_URL.'manage_pm_stock_balance');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Pm Stock Balance Entry', 'class' => '', 'url' => '');
        
        # Additional data        
        $data['packing_material'] = $this->Common_model->get_data('packing_material',array('status'=>1,'pm_category_id!=' =>1));
        

        // checking if reading already taken for today or not
        //$err = $this->Pm_stock_balance_m->get_today_num_of_records();       
        if(@$err)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Sorry!</strong> Today Reading already Taken </div>');       
            redirect(SITE_URL.'manage_pm_stock_balance');

        }
        else
        {
           $res = $this->Pm_stock_balance_m->get_latest_stock_balance_record();
            if(@$res){
                $data['last_reading_taken']=date('d-m-Y',strtotime(@$res['on_date']));
                
            }else{
                $data['last_reading_taken']=date('d-m-Y');
            } 
                 
            $data['form_action'] = SITE_URL.'confirm_pm_stock_balance_entry';
            $data['flg']=1;

            if(@$this->input->post('cancel',TRUE) == 2)
            {
                $data['pm_stock_balance_entry_list']=$_POST;
                $this->load->view('pm_stock_balance/pm_stock_balance_entry_edit_view',$data); 
            }
            else
            {
                $this->load->view('pm_stock_balance/pm_stock_balance_entry_view',$data);  
            } 
        }                                    
    }    
    public function confirm_pm_stock_balance_entry()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Confirm Pm Stock Balance Entry";
        $data['nestedView']['pageTitle'] = 'Confirm Pm Stock Balance Entry';
        $data['nestedView']['cur_page'] = 'manage_pm_stock_balance';
        $data['nestedView']['parent_page'] = 'inventory';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/pm_stock_balance_entry.js"></script>';

        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Pm Stock Balance Entry', 'class' => '', 'url' => SITE_URL.'manage_pm_stock_balance');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Pm Stock Balance Entry', 'class' => 'active', 'url' => 'pm_stock_balance_entry');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Confirm Pm Stock Balance Entry', 'class' => 'active', 'url' => '');

        # Data
        
        # Additional data
        $res = $this->Pm_stock_balance_m->get_latest_stock_balance_record();
        if(@$res){
            $data['last_reading_taken']=date('d-m-Y',strtotime(@$res['on_date']));
            
        }else{
            $data['last_reading_taken']=date('d-m-Y');
        }
        $data['pm_stock_balance_entry_list'] = $_POST;
        
        
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_pm_stock_balance_entry';
        $data['display_results'] = 0;
        $this->load->view('pm_stock_balance/confirm_pm_stock_balance_entry_view',$data);
    }    
    public function insert_pm_stock_balance_entry()
    {
       
        foreach ($_POST['opening_balance'] as $key => $value) 
        {
            // Key is the Packing Material ID
            // checking for closing balance for latest record
            $res = $this->Pm_stock_balance_m->get_latest_stock_balance_record($key);
            
            if($value != 0)
            {
                if(@$res)
                {
                    
                    // closing balance Updation for previous record
                    $where=array('pm_stock_balance_id'=>$res['pm_stock_balance_id']);
                    $update_data = array(
                        'closing_balance'   => $value,
                        'modified_by'       => $this->session->userdata('user_id'),
                        'modified_time'     => date('Y-m-d H:i:s'),
                        
                        );
                    $this->Common_model->update_data('pm_stock_balance',$update_data,$where);

                    // opening balance insertion for today
                    $insert_data = array(
                            'pm_id'             => $key,
                            'plant_id'          => get_plant_id(),
                            'on_date'           => date('Y-m-d'),
                            'opening_balance'   => $value,
                            'created_by'        => $this->session->userdata('user_id'),
                            'created_time'      =>  date('Y-m-d H:i:s')
                            );
                    $this->Common_model->insert_data('pm_stock_balance',$insert_data);
                    $this->Pm_stock_balance_m->insert_update_pm_stock($key,$value);
                }
                else
                {
                    
                    // inserting opening balance when no records are in database
                    $first_time_insert_data = array(
                            'pm_id'             => $key,
                            'plant_id'          => get_plant_id(),
                            'on_date'           => date('Y-m-d'),
                            'opening_balance'   => $value,
                            'created_by'        => $this->session->userdata('user_id'),
                            'created_time'      => date('Y-m-d H:i:s')
                            );
                    $this->Common_model->insert_data('pm_stock_balance',$first_time_insert_data);
                    $this->Pm_stock_balance_m->insert_update_pm_stock($key,$value);
                } 
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
                                                    <strong>Success!</strong> Pm Stock Balance Entry  successfully! </div>');
        }
       
        redirect(SITE_URL.'manage_pm_stock_balance');
    }
    public function download_pm_stock_balance()
    {
        if($this->input->post('download_pm_stock_balance')!='') {
            
            $from_date=(($this->input->post('from_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('from_date', TRUE))):''; 
            $to_date=(($this->input->post('to_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('to_date', TRUE))):''; 
            $search_params=array(
                'loose_pm_id'       => $this->input->post('loose_pm_id', TRUE),
                'from_date'          => $from_date,
                'to_date'            => $to_date
                );
            $pm_stock_balance = $this->Pm_stock_balance_m->pm_Stock_balance_details($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','Plant','Loose Pm','Opening Bal(MT)','Date','Receipts(MT)','Production(MT)','Closing Balance(MT)','Wastage(KG)','allowable Wastage(KG)','status');
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
            if(count($pm_stock_balance)>0)
            {                
                foreach($pm_stock_balance as $row)
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
                    $data.='<td align="center">'.get_loose_pm_name($row['loose_pm_id']).'</td>';                   
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
            $xlFile='Pm Stock Balance'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }
    // For Films
    public function film_pm_stock_balance_entry()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Film Distribution";
        $data['nestedView']['pageTitle'] = 'Film Distribution Details';
        $data['nestedView']['cur_page'] = 'opening_stock_entry_for_film_type';
        $data['nestedView']['parent_page'] = 'opening_stock_entry';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Film Distribution Details', 'class' => '', 'url' => '');

        # Get Micron Data
        $data['micron']= $this->Common_model->get_data('micron',array('status'=>1));
        $qry = 'SELECT name FROM micron WHERE status = 1';
        $data['micron_count'] = $this->Common_model->get_no_of_rows($qry);

        # Get Capacity Micron Results
        $product_micron_results= $this->Common_model->get_data('plant_film_stock',array('status'=>1));

        foreach($product_micron_results as $key =>$value)
        {
            
            $results[$value['pm_id']][$value['micron_id']]=$value['quantity'];
        } 
        $data['results']=@$results;

        $plant_id=$this->session->userdata('ses_plant_id');
        $user_id=$this->session->userdata('user_id');
        $film_id=get_film_id();
        $data['capacity'] = get_film_order_by();

        // checking if reading already taken for today or not
        /*$err = $this->Pm_stock_balance_m->get_today_num_of_records();       
        if(@$err)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Sorry!</strong> Today Reading already Taken </div>');       
            redirect(SITE_URL.'manage_pm_stock_balance');

        }*/
        /*else
        {*/
           $res = $this->Pm_stock_balance_m->get_latest_stock_balance_record();
            if(@$res){
                $data['last_reading_taken']=date('d-m-Y',strtotime(@$res['on_date']));
                
            }else{
                $data['last_reading_taken']=date('d-m-Y');
            } 

        //}

        if($this->input->post('product_micron'))
        {
            $dat = $this->input->post('product_micron_value', TRUE); 
            //echo "<pre>"; print_r($dat);
            $this->db->trans_begin();
            foreach($dat as $key => $value)
            {
                
                if(count($value) !=0)
                {
                    $qry = 'SELECT quantity FROM plant_pm WHERE plant_id = "'.$plant_id.'" AND pm_id = "'.$key.'" ';
                    $product_pm_count = $this->Common_model->get_no_of_rows($qry);
                    $pm_quantity=array_sum($value);

                    if($pm_quantity>0)
                    {
                        if($product_pm_count>0)
                        {
                            $where=array('plant_id'=>$plant_id,'pm_id'=>$key);
                            $quant = array('quantity'=>$pm_quantity);
                            $this->Common_model->update_data('plant_pm',$quant,$where);
                        }
                        else
                        {
                            $plant_pm=array('pm_id'=>$key,'plant_id'=>$plant_id,'quantity'=>$pm_quantity,'updated_time'=>date('Y-m-d H:i:s'));
                            $this->Common_model->insert_data('plant_pm',$plant_pm);
                        }
                    }
                    $res = $this->Pm_stock_balance_m->get_latest_stock_balance_record($key);
                    if(@$res)
                    {
                        
                        if(count($value) != 0)
                        {
                           
                            // closing balance Updation for previous record
                            $balance=array_sum($value);
                            if($balance !=0)
                            {
                                $where=array('pm_stock_balance_id'=>$res['pm_stock_balance_id']);
                                $update_data = array(
                                    'closing_balance'   => $balance,
                                    'modified_by'       => $this->session->userdata('user_id'),
                                    'modified_time'     => date('Y-m-d H:i:s'),
                                    
                                    );
                                $this->Common_model->update_data('pm_stock_balance',$update_data,$where);

                                // opening balance insertion for today
                                $insert_data = array(
                                        'pm_id'             => $key,
                                        'plant_id'          => get_plant_id(),
                                        'on_date'           => date('Y-m-d'),
                                        'opening_balance'   => $balance,
                                        'created_by'        => $this->session->userdata('user_id'),
                                        'created_time'      =>  date('Y-m-d H:i:s')
                                        );

                                $this->Common_model->insert_data('pm_stock_balance',$insert_data);
                            }
                            
                        }
                        
                    }
                    else
                    {
                      if(count($value) !=0)
                       {
                              
                            // inserting opening balance when no records are in database
                            $balance=array_sum($value);
                            if($balance !=0)
                            {
                                $first_time_insert_data = array(
                                    'pm_id'             => $key,
                                    'plant_id'          => get_plant_id(),
                                    'on_date'           => date('Y-m-d'),
                                    'opening_balance'   => $balance,
                                    'created_by'        => $this->session->userdata('user_id'),
                                    'created_time'      => date('Y-m-d H:i:s')
                                    );
                                $this->Common_model->insert_data('pm_stock_balance',$first_time_insert_data);
                            }
                            
                        }
                     
                    }
                    foreach ($value as $key1 => $value1) 
                    {
                         
                        if($value1 !=0)
                        {
                            $qry = 'SELECT quantity FROM plant_film_stock WHERE plant_id = "'.$plant_id.'" AND micron_id="'.$key1.'" AND pm_id = "'.$key.'" ';
                            $product_micron_count = $this->Common_model->get_no_of_rows($qry);
                            if($product_micron_count>0)
                            {
                                $where=array('plant_id'=>$plant_id,'micron_id'=>$key1,'pm_id'=>$key);
                                $micron_quantity=array('quantity'=>$value1,'modified_by'=>$user_id,'modified_time'=>date('Y-m-d H:i:s'));
                                $this->Common_model->update_data('plant_film_stock',$micron_quantity,$where);
                            }
                            else
                            {
                                $product_micron_data = array('pm_id' => $key,'micron_id' => $key1,'quantity' => $value1,'plant_id'=>$plant_id);
                                $this->Common_model->insert_data('plant_film_stock',$product_micron_data);
                            }

                        }
                        
                    }
                }
                  
            } 
            if ($this->db->trans_status()===FALSE)
            {
                $this->db->rollback();
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Please check.</strong> No Changes Occured.  </div>'); 
                redirect(SITE_URL.'manage_pm_stock_balance');
            }
            else
            {
                $this->db->trans_commit();
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Product Micron Values has been added successfully! </div>');
                redirect(SITE_URL.'manage_pm_stock_balance');
            } 
        }
       
        $this->load->view('pm_stock_balance/product_micron_view',$data);
    }

/*Opening stock for packing material view
Author:Srilekha
Time: 01.03PM 05-03-2017 */
    public function view_pm_quantity()
    {
        
            //print_r($this->session->userdata('session_loose_oil_results'));exit;
            # Data Array to carry the require fields to View and Model
            $data['nestedView']['heading'] = "Opening stock updation for P.M.";
            $data['nestedView']['pageTitle'] = 'Opening stock updation for P.M.';
            $data['nestedView']['cur_page'] = 'opening_stock_entry_for_pm';
            $data['nestedView']['parent_page'] = 'opening_stock_entry';

            # Load JS and CSS Files
            $data['nestedView']['js_includes'] = array();
            $data['nestedView']['css_includes'] = array();

            # Breadcrumbs
            $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
            $data['nestedView']['breadCrumbOptions'][] = array('label' => 'opening stock entry for P.M.', 'class' => '', 'url' => SITE_URL . 'pm_quantity');
            $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Opening stock updation for P.M.', 'class' => 'active', 'url' => '');

          
            $plant_id=$this->session->userdata('ses_plant_id');

            // checking if reading already taken for today or not
            /*$err = $this->Pm_stock_balance_m->get_today_num_of_records();       
            if(@$err)
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                            <strong>Sorry!</strong> Today Reading already Taken </div>');       
                redirect(SITE_URL.'manage_pm_stock_balance');

            }*/
            /*else
            {*/
               $res = $this->Pm_stock_balance_m->get_latest_stock_balance_record();
               
                if(@$res){
                    $data['last_reading_taken']=date('d-m-Y',strtotime(@$res['on_date']));
                    
                }else{
                    $data['last_reading_taken']=date('d-m-Y');
                } 

            //}

            $pm=$this->Pm_stock_balance_m->get_pm();
            foreach($pm as $key =>$value)
            {   
                $pm_results[$value['pm_group_id']]['pm_category_name']=$value['pm_group_id'];
                $pm_results[$value['pm_group_id']]['pm_name']=$value['name'];
                $pm_results[$value['pm_group_id']]['plant_id']=$plant_id;
                $results=$this->Pm_stock_balance_m->get_sub_pm_by_pm($value['pm_group_id']);
                $pm_results[$value['pm_group_id']]['sub_products']=$results;
            }
            
            $data['plant_id']=$plant_id;
            @$product_id=$this->Common_model->get_data('plant_pm',array('plant_id'=>$plant_id));
            
            foreach($product_id as $key=>$value)
            {
                @$result[$value['plant_id']][$value['pm_id']]=$value['quantity'];
             
            } 
            //print_r($result);//exit;
            $data['results']=@$result;
            $plant_name=$this->Common_model->get_value('plant',array('plant_id'=>$plant_id),'name');

            $data['pm_results']=$pm_results;
            $data['portlet_title'] =$plant_name;
            $data['flag']=2;
            $this->load->view('pm_stock_balance/opening_stock_entry_view',$data);
        
    }
/*Insert Opening stock Quantity
Author:Srilekha
Time: 01.25PM 05-03-2017 */
    public function insert_latest_pmqty()
    { 
        
        $quantity=$this->input->post('quantity');
        $plant_id=$this->input->post('plant_id');
        $this->db->trans_begin();
        foreach($quantity as $key=>$value)
        {             
            if($value !=0)
            {
               
                $query = 'select * from plant_pm where pm_id="'.$key.'" AND plant_id="'.$plant_id.'"';
                $count = $this->Common_model->get_no_of_rows($query);
                if($count>0)
                {                  
                    
                    $a=$this->Common_model->update_data('plant_pm',array('quantity'=>$quantity[$key]),array('pm_id'=>$key,'plant_id'=>$plant_id));
                   
                }
                else
                {
                  
                   $pm[]= array( 
                        'quantity'      =>  $quantity[$key],
                        'plant_id'      =>  $this->input->post('plant_id'),                
                        'pm_id'         =>  $key,
                        'updated_time'  =>date('Y-m-d H:i:s')
                               ); 
               }
                
            }
            else
            {
                $query = $query = 'delete from plant_pm where pm_id="'.$key.'" AND plant_id="'.$plant_id.'"'; 
                $this->db->query($query);
            }
            $res = $this->Pm_stock_balance_m->get_latest_stock_balance_record($key);
            if(@$res)
            {
                
                if($value != 0)
                {
                   
                    // closing balance Updation for previous record
                    $where=array('pm_stock_balance_id'=>$res['pm_stock_balance_id']);
                    $update_data = array(
                        'closing_balance'   => $value,
                        'modified_by'       => $this->session->userdata('user_id'),
                        'modified_time'     => date('Y-m-d H:i:s'),
                        
                        );
                    $this->Common_model->update_data('pm_stock_balance',$update_data,$where);

                    // opening balance insertion for today
                    $insert_data = array(
                            'pm_id'             => $key,
                            'plant_id'          => $plant_id,
                            'on_date'           => date('Y-m-d'),
                            'opening_balance'   => $value,
                            'created_by'        => $this->session->userdata('user_id'),
                            'created_time'      =>  date('Y-m-d H:i:s')
                            );

                    $this->Common_model->insert_data('pm_stock_balance',$insert_data);
                }
                
            }
            else
            {
              if($value !=0)
               {
                    // inserting opening balance when no records are in database
                    $first_time_insert_data = array(
                            'pm_id'             => $key,
                            'plant_id'          => $plant_id,
                            'on_date'           => date('Y-m-d'),
                            'opening_balance'   => $value,
                            'created_by'        => $this->session->userdata('user_id'),
                            'created_time'      => date('Y-m-d H:i:s')
                            );
                    $this->Common_model->insert_data('pm_stock_balance',$first_time_insert_data);
                }
             
            }
                
        } 
        foreach($pm as $row)
        {          
           $pm_id = $this->Common_model->insert_data('plant_pm',$row);

        }   
        if($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <strong>Error!</strong> Something went wrong. Please check. </div>');

        }
        else
        {
            $this->db->trans_commit(); 
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                <strong>Success!</strong>Packing Material Stock Details has been added successfully! </div>');
        }
        redirect(SITE_URL.'manage_pm_stock_balance');
        
    } 
    
}