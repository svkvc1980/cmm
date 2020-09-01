<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by maruthi 15th Nov 2016 09:00 AM

class Loose_oil_product extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Loose_oil_product_m");
	}


	public function loose_oil_product()
	{
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage loose oil product";
		$data['nestedView']['pageTitle'] = 'loose oil product';
        $data['nestedView']['cur_page'] = 'loose_oil_product';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage loose oil product', 'class' => '', 'url' => '');	

        # Search Functionality
        $p_search=$this->input->post('search_loose_oil_product', TRUE);
        if($p_search!='') 
        {
            $search_params=array(
                'loose_oil_product_name' => $this->input->post('loose_oil_product_name', TRUE),
                'code'       => $this->input->post('code', TRUE)
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'loose_oil_product_name'   => $this->session->userdata('loose_oil_product_name'),
                    'code'         => $this->session->userdata('code'),
                    
                                  );
            }
            else {
                $search_params=array(
                      'loose_oil_product_name'    => '',
                      'code'          => '',
                     
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;
        


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'loose_oil_product/';
        # Total Records
        $config['total_rows'] = $this->Loose_oil_product_m->loose_oil_product_total_num_rows($search_params);

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
        $data['loose_oil_product_results'] = $this->Loose_oil_product_m->loose_oil_product_results($current_offset, $config['per_page'], $search_params);
       
        # Additional data
        $data['display_results'] = 1;

        $this->load->view('loose_oil_product_view',$data);

    }
    public function add_loose_oil_product()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Add loose_oil_product";
        $data['nestedView']['pageTitle'] = 'Add loose_oil_product';
        $data['nestedView']['cur_page'] = 'add_loose_oil_product';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/loose_oil_product.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage loose_oil_product', 'class' => '', 'url' => SITE_URL.'broker');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add New loose_oil_product', 'class' => 'active', 'url' => '');
        
        # Data
        
        # Additional data
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_loose_oil_product';
        $data['display_results'] = 0;
        $this->load->view('loose_oil_product_view',$data);
    }

    public function insert_loose_oil_product()
    {
        $this->session->set_userdata('user_id','1');
        // GETTING INPUT TEXT VALUES
        $data = array( 
                    'loose_oil_product_name'       =>$this->input->post('loose_oil_product_name',TRUE),
                    'code'       =>$this->input->post('code',TRUE),                                                  
                    'created_by'       => $this->session->userdata('user_id'),
                    'created_time'     => date('Y-m-d H:i:s')                    
                    );
        
        $po_id = $this->Common_model->insert_data('loose_oil_product',$data);

        if ($po_id>0)
        {
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Loose_Oil_Product has been added successfully! </div>');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Something went wrong. Please check. </div>');       
        }

        redirect(SITE_URL.'loose_oil_product');  
    }

    public function edit_loose_oil_product()
    {
        $loose_oil_product_id=@cmm_decode($this->uri->segment(2));
        if($loose_oil_product_id==''){
            redirect(SITE_URL);
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Edit loose_oil_product";
        $data['nestedView']['pageTitle'] = 'Edit loose_oil_product';
        $data['nestedView']['cur_page'] = 'edit_loose_oil_product';
        $data['nestedView']['parent_page'] = 'master';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/loose_oil_product.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage loose_oil_product', 'class' => '', 'url' => SITE_URL.'broker');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Edit loose_oil_product', 'class' => 'active', 'url' => '');

        # Additional data
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'update_loose_oil_product';
        $data['display_results'] = 0;

        # Data
        $row = $this->Common_model->get_data('loose_oil_product',array('loose_oil_product_id'=>$loose_oil_product_id));
        $data['loose_oil_product_row'] = $row[0];
       
        
        $this->load->view('loose_oil_product_view',$data);
    }

    public function update_loose_oil_product()
    {
        $loose_oil_product_id=@cmm_decode($this->input->post('encoded_id',TRUE));
        if($loose_oil_product_id==''){
            redirect(SITE_URL);
            exit;
        }
        // GETTING INPUT TEXT VALUES
        $data = array( 
                     'loose_oil_product_name'       =>$this->input->post('loose_oil_product_name',TRUE),
                    'code'       =>$this->input->post('code',TRUE),                                                  
                    'created_by'       => $this->session->userdata('user_id'),
                    'created_time'     => date('Y-m-d H:i:s')                    
                    );

        $where = array('loose_oil_product_id'=>$loose_oil_product_id);
        $res = $this->Common_model->update_data('loose_oil_product',$data,$where);

        if ($res)
        {
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Loose_Oil_Product Type has been updated successfully! </div>');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Something went wrong. Please check. </div>');       
        }

        redirect(SITE_URL.'loose_oil_product');  
    }

   
     public function deactivate_loose_oil_product($encoded_id)
    {
    
        $loose_oil_product_id=@cmm_decode($encoded_id);
        if($loose_oil_product_id==''){
            redirect(SITE_URL);
            exit;
        }
        $where = array('loose_oil_product_id' => $loose_oil_product_id);
        //deactivating user
        $data_arr = array('status' => 2);
        $this->Common_model->update_data('loose_oil_product',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Loose_Oil_Product has been De-Activated successfully!</div>');
        redirect(SITE_URL.'loose_oil_product');

    }
    
    public function activate_loose_oil_product($encoded_id)
    {
        $loose_oil_product_id=@cmm_decode($encoded_id);
        if($loose_oil_product_id==''){
            redirect(SITE_URL);
            exit;
        }
        $where = array('loose_oil_product_id' => $loose_oil_product_id);
        //deactivating user
        $data_arr = array('status' => 1);
        $this->Common_model->update_data('loose_oil_product',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Loose_Oil_Product has been Activated successfully!</div>');
            redirect(SITE_URL.'loose_oil_product');
    }    
    public function download_loose_oil_product()
    {
        if($this->input->post('download_loose_oil_product')!='') {
            
            $search_params=array(
                'loose_oil_product_name'     => $this->input->post('loose_oil_product_name', TRUE),
                'code' => $this->input->post('code', TRUE)
                              );
            $loose_oil_product = $this->Loose_oil_product_m->loose_oil_product_details($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','loose_oil_product');
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
            if(count($loose_oil_product)>0)
            {
                
                foreach($loose_oil_product as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['loose_oil_product_name'].'</td>';                   
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
            $xlFile='Loose_oil_product_m'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }
public  function is_productExist()
    {
        $loose_oil_product_name = $this->input->post('product_name');
        $loose_oil_product_id = $this->input->post('identity');
        echo $this->Loose_oil_product_m->is_productExist($loose_oil_product_name,$loose_oil_product_id);
    }

}