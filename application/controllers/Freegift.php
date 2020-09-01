<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Freegift extends Base_controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Freegift_m");
        $this->load->model("Common_model");               
    }
        public function freegift()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Free Gifts List";
        $data['nestedView']['pageTitle'] = 'Free Gifts List';
        $data['nestedView']['cur_page'] = 'free_gift';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'product';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Free Gifts List', 'class' => '', 'url' =>'');

        # Search Functionality
        $psearch=$this->input->post('searchfreegift', TRUE);
        if($psearch!='') 
        {
            $searchParams=array(
                               'name' => $this->input->post('name', TRUE)
                               );
            $this->session->set_userdata($searchParams);
        } 
        else 
        {

        if($this->uri->segment(2)!='')
            {
            $searchParams=array(
                              'name'=>$this->session->userdata('name')
                              );
            }
            else {
                $searchParams=array(
                                    'name'=>''
                                   );
                $this->session->set_userdata($searchParams);
            }
            
        }
        $data['search_data'] = $searchParams;


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'freegift/';
        # Total Records
        $config['total_rows'] = $this->Freegift_m->freegift_total_num_rows($searchParams);

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
        $data['freegiftResults'] = $this->Freegift_m->freegift_results($current_offset, $config['per_page'], $searchParams);
        
        # Additional data
        $data['displayResults'] = 1;
        $this->load->view('freegift_view',$data);
    }

    public function add_freegift()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Add Free Gift";
        $data['nestedView']['pageTitle'] = 'Add Free Gift';
        $data['nestedView']['cur_page'] = 'free_gift';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'product';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/freegift.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Free Gifts List', 'class' => 'active', 'url' => 'freegift');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add Free Gift', 'class' => 'active', 'url' => '');

        # Additional data
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_freegift';
        $data['displayResults'] = 0;
        $this->load->view('freegift_view',$data);
    }

//Nagarjuna 21th Jan 2017 03:00 pm
public function insert_freegift()
    {
        $freegift_name=$this->input->post('name');
        $freegift_id=0;
        $unique=$this->Freegift_m->is_freegiftExist($freegift_name,$freegift_id);
        if($unique==0)
        {
           $data = array(
                      'name'          =>      $freegift_name,
                      'created_by'    =>      $this->session->userdata('user_id'),
                      'created_time'  =>      date('Y-m-d H:i:s'),
                      'status'        =>      1
                    );
            $free_gift_id = $this->Common_model->insert_data('free_gift',$data);
            if($free_gift_id>0)
            {
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                          <strong>Success!</strong> Free GIFT has been added successfully! </div>');
            }
            else
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                          <strong>Error!</strong> Something went wrong. Please check. </div>');       
            } 
        }
        else
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                          <strong>Error!</strong> Name Already Exist </div>');       
            } 

        redirect(SITE_URL.'freegift');  
    }

public function edit_freegift()
    {
        $free_gift_id=@cmm_decode($this->uri->segment(2));
        
        if($free_gift_id=='')
        {
            redirect(SITE_URL);
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Edit Free Gift";
        $data['nestedView']['pageTitle'] = 'Edit Free Gift';
        $data['nestedView']['cur_page'] = 'free_gift';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'product';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/freegift.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Free Gifts List', 'class' => '', 'url' =>SITE_URL.'freegift');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Edit Free Gift', 'class' => 'active', 'url' => '');

        # Additional data
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'update_freegift';
        $data['displayResults'] = 0;

        # Data
        $row = $this->Common_model->get_data('free_gift',array('free_gift_id'=>$free_gift_id));
        
        $data['lrow'] = $row[0];
        $this->load->view('freegift_view',$data);
    }

//Nagarjuna 21th Jan 2017 03:00 pm
public function update_freegift()
    {
        $free_gift_id=@cmm_decode($this->input->post('encoded_id',TRUE));
        if($free_gift_id==''){
            redirect(SITE_URL);
            exit;
        }
        // GETTING INPUT TEXT VALUES
        $freegift_name=$this->input->post('name');
        // server side validation for freegift name
        $unique=$this->Freegift_m->is_freegiftExist($freegift_name,$free_gift_id);
        if($unique==0)
        {
           $data = array( 
                    'name'                    =>      $this->input->post('name',TRUE),
                    'modified_by'             =>      $this->session->userdata('user_id'),
                    'modified_time'           =>      date('Y-m-d H:i:s'),
                    'status'                  =>      1
                    );
            $where = array('free_gift_id'=>$free_gift_id);
            $res = $this->Common_model->update_data('free_gift',$data,$where);

            if ($res)
            {
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Success!</strong> Free Gift has been updated successfully! </div>');
            }
            else
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Error!</strong> Something went wrong. Please check. </div>');       
            } 
        }
        else
            {
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Error!</strong> Name Already Exist </div>');       
            } 

        redirect(SITE_URL.'freegift');  
    }

public function deactivate_freegift($encoded_id)
    {
    
        $free_gift_id=@cmm_decode($encoded_id);
        if($free_gift_id==''){
            redirect(SITE_URL);
            exit;
        }
        $where = array('free_gift_id' => $free_gift_id);
        //deactivating user
        $data_arr = array('status' => 2,
                          'modified_by'   => $this->session->userdata('user_id'),
                          'modified_time' => date('Y-m-d H:i:s'));
        $this->Common_model->update_data('free_gift',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Free Gift has been De-Activated successfully!</div>');
        redirect(SITE_URL.'freegift');

    }
public function activate_freegift($encoded_id)
    {
        $free_gift_id=@cmm_decode($encoded_id);
        if($free_gift_id==''){
            redirect(SITE_URL);
            exit;
        }
        $where = array('free_gift_id' => $free_gift_id);
        //deactivating user
        $data_arr = array('status' => 1,
                          'modified_by'   => $this->session->userdata('user_id'),
                          'modified_time' => date('Y-m-d H:i:s'));
        $this->Common_model->update_data('free_gift',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Free Gift has been Activated successfully!</div>');
            redirect(SITE_URL.'freegift');

    }
public function download_freegift()
    {
        if($this->input->post('downloadfreegift')!='') {
            
            $searchParams=array(
                               'name' => $this->input->post('name', TRUE)
                               );
            $freegift = @$this->Freegift_m->freegift_details($searchParams);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','Freegift');
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
            if(count(@$freegift)>0)
              {
                foreach(@$freegift as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['name'].'</td>';
                    $data.='</tr>';
                    $j++;
                }
            }
            else
            {
                $data.='<tr><td colspan="'.(count($titles)).'" align="center">No Results Found</td></tr>';
            }
            $data.='</tbody>';
            $data.='</table>';
            $time = date("Ymdhis");
            $xlFile='freegift_'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }

//Function to check the uniqueness of freegiftname
    public  function is_freegiftExist()
    {
        $name = $this->input->post('name');
        $freegift_id = $this->input->post('freegift_id');
        echo $this->Freegift_m->is_freegiftExist($name,$freegift_id);
    }
//ending of Uniqueness of freegiftname - nagarjune//
    /*Opening Free Gifts Quantity
Author:Nagarjuna
Time: 1.00PM 17-03-2017 */
    public function freegift_quantity()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Opening Stock Entry For Free Gifts ";
        $data['nestedView']['pageTitle'] = 'Opening Stock Entry For Free Gifts';
        $data['nestedView']['cur_page'] = 'freegift_quantity';
        $data['nestedView']['parent_page'] = 'opening_stock_entry';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Opening Stock Entry For Free Gifts', 'class' => 'active', 'url' => ''); 

            
            $data['free_gift'] = $this->Common_model->get_data('free_gift',array('status'=>1));
            $plant_id=$this->session->userdata('ses_plant_id');
            $data['plant_id'] = $plant_id;
            $query='SELECT * FROM plant_free_gift';
            $freegift = $this->Common_model->get_query_result($query);
            foreach($freegift as $key =>$value)
            {
                
                @$result[$value['free_gift_id']][$value['plant_id']]=$value['quantity'];
            }
            $data['results']=@$result;
            # $data['loose_oil']=$this->Common_model->get_data('loose_oil',array('status' !=2 'status'=>3));
            if($this->input->post('fg_quantity'))
            {
                $quantity=$this->input->post('quantity');
                
                $this->db->trans_begin();
                foreach($quantity as $key=>$value)
                {
                    if($value !='')
                    {
                       
                        $query = 'select * from plant_free_gift where free_gift_id="'.$key.'" AND plant_id="'.$plant_id.'"';
                        $count = $this->Common_model->get_no_of_rows($query);
                        if($count>0)
                        {
                           
                            
                            $a=$this->Common_model->update_data('plant_free_gift',array('quantity'=>$quantity[$key]),array('free_gift_id'=>$key,'plant_id'=>$plant_id));
                           
                        }
                        else
                        {
                          
                           $pm= array( 
                                'quantity'      =>  $quantity[$key],
                                'plant_id'      =>  $plant_id,                
                                'free_gift_id'  =>  $key,
                                'updated_time'  =>date('Y-m-d H:i:s')
                                       );
                           $fg_quantity = $this->Common_model->insert_data('plant_free_gift',$pm);
                       }
                        
                    }
                     else
                    {
                        $query = 'select * from plant_free_gift where free_gift_id="'.$key.'" AND plant_id="'.$plant_id.'"';
                        $count = $this->Common_model->get_no_of_rows($query);
                        if($count>0)
                        {
                            $qry='DELETE FROM plant_free_gift WHERE free_gift_id='.$key.' and plant_id='.$plant_id;
                            $this->db->query($qry);
                           
                        }
                           
                    }
                }
                if($this->db->trans_status() === FALSE)
                {
                    $this->db->trans_rollback();
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <strong>Error!</strong> Something went wrong. Please check. </div>');
                    redirect(SITE_URL.'freegift_quantity');

                }
                else
                {
                    $this->db->trans_commit(); 
                    $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                        <strong>Success!</strong>Free Gifts has been added successfully! </div>');
                    redirect(SITE_URL.'freegift_quantity');
                }
            }
       
        $this->load->view('freegift/freegift_quantity_view',$data);
    }
}

