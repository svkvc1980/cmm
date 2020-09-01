<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Coupon extends Base_controller 
{
    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Coupon_model");
        $this->load->model("Common_model");               
    }
        public function coupon()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Coupon List";
        $data['nestedView']['pageTitle'] = 'Coupon List';
        $data['nestedView']['cur_page'] = 'coupon';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'coupon';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Coupon List', 'class' => '', 'url' =>'');

         # Search Functionality
        $psearch=$this->input->post('search_coupon', TRUE);
        if($psearch!='') {
            $start_date=$this->input->post('start_date');
            if($start_date=='')
            {
                $start_date='';
            }
            else
            {
                $start_date= date('Y-m-d',strtotime($this->input->post('start_date')));
            }
            //echo $start_date;exit;
            $end_date=$this->input->post('end_date');
            if($end_date=='')
            {
                $end_date='';
            }
            else
            {
                $end_date= date('Y-m-d',strtotime($this->input->post('end_date')));
            }
            $searchParams=array(
                        'name'          =>   $this->input->post('name'),
                        'start_date'    =>   $start_date,
                        'end_date'      =>   $end_date
                           );
        $this->session->set_userdata($searchParams);
        } else {

            if($this->uri->segment(2)!='')
            {
                $searchParams=array(
                        'name'         =>   $this->session->userdata('name'),
                        'start_date'   =>   $this->session->userdata('start_date'),
                        'end_date'     =>   $this->session->userdata('end_date')
                            );
            }
            else 
            {
                $searchParams=array(
                        'name'         =>  '',
                        'start_date'   =>  '',
                        'end_date'     =>  ''
                               );
                $this->session->set_userdata($searchParams);
            }
        }
        $data['search_data'] = $searchParams;

        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'coupon/';
        # Total Records
        $config['total_rows'] = $this->Coupon_model->coupon_total_num_rows($searchParams);

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
        $data['coupon'] = $this->Coupon_model->coupon_results($current_offset, $config['per_page'], $searchParams);
        
        # Additional data
        $data['displayResults'] = 1;
        $this->load->view('coupon/coupon',$data);
    }

    public function add_coupon()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Add Coupon";
        $data['nestedView']['pageTitle'] = 'Add Coupon';
        $data['nestedView']['cur_page'] = 'coupon';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'coupon';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/coupon.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Coupon List', 'class' => 'active', 'url' => 'coupon');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add Coupon', 'class' => 'active', 'url' => '');

        # Additional data
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_coupon';
        $data['displayResults'] = 0;
        $this->load->view('coupon/coupon',$data);
    }


    public function insert_coupon()
    {
        // GETTING INPUT TEXT VALUES
        $name= $this->input->post('name');
        $no_of_cartons= $this->input->post('no_of_cartons');
        $start_date= date('Y-m-d',strtotime($this->input->post('start_date')));
        $end_date= date('Y-m-d',strtotime($this->input->post('end_date')));
        $count=$this->Coupon_model->check_coupon_dates($start_date,$end_date);
        //echo $count;exit;
        //echo $no_of_cartons;exit;
        if($count<=0)
        {
            $data = array(
                      'name'           =>     $name,
                      'no_of_cartons'  =>     $no_of_cartons,
                      'start_date'     =>     $start_date,
                      'end_date'       =>     $end_date,
                      'amount'         =>     $this->input->post('amount',TRUE),
                      'created_by'     =>     $this->session->userdata('user_id'),
                      'created_time'   =>     date('Y-m-d H:i:s'),
                      'status'         =>     1
                    );
            $coupon_id = $this->Common_model->insert_data('coupon',$data);
            if($coupon_id>0)
            {
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                          <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                          <strong>Success!</strong> Coupon has been added successfully! </div>');
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
                                                      <strong>Error!</strong>Start Date and End Date Already Exist! Please check </div>');       
        }
        redirect(SITE_URL.'coupon');  
    }

    public function edit_coupon()
    {
        $coupon_id=@cmm_decode($this->uri->segment(2));
        
        if($coupon_id=='')
        {
            redirect(SITE_URL);
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Edit Coupon";
        $data['nestedView']['pageTitle'] = 'Edit Coupon';
        $data['nestedView']['cur_page'] = 'coupon';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'coupon';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/coupon.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Coupon List', 'class' => '', 'url' =>SITE_URL.'coupon');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Edit Coupon', 'class' => 'active', 'url' => '');

        # Additional data
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'update_coupon';
        $data['displayResults'] = 0;

        # Data
        $row = $this->Common_model->get_data('coupon',array('coupon_id'=>$coupon_id));
        
        $data['lrow'] = $row[0];
        $this->load->view('coupon/coupon',$data);
    }

    public function update_coupon()
    {
        $coupon_id=@cmm_decode($this->input->post('encoded_id',TRUE));
        if($coupon_id==''){
            redirect(SITE_URL);
            exit;
        }
        // GETTING INPUT TEXT VALUES
        $start_date= date('Y-m-d',strtotime($this->input->post('start_date')));
        $end_date= date('Y-m-d',strtotime($this->input->post('end_date')));
        $count=$this->Coupon_model->check_coupon_dates($start_date,$end_date);
        if($count<=0)
        {
            $data = array( 
                    'name'           =>     $this->input->post('name',TRUE),
                    'no_of_cartons'  =>     $this->input->post('no_of_cartons', TRUE),
                    'start_date'     =>     $start_date,
                    'end_date'       =>     $end_date,
                    'amount'         =>     $this->input->post('amount',TRUE),
                    'modified_by'    =>     $this->session->userdata('user_id'),
                    'modified_time'  =>     date('Y-m-d H:i:s'),
                    'status'         =>     1
                    );
            $where = array('coupon_id'=>$coupon_id);
            $res = $this->Common_model->update_data('coupon',$data,$where);
            if ($res)
            {
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Success!</strong> Coupon has been updated successfully! </div>');
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
                                                      <strong>Error!</strong>Start Date and End Date Already Exist! Please check </div>');       
        } 
        redirect(SITE_URL.'coupon');  
    }

    public function deactivate_coupon($encoded_id)
    {
    
        $coupon_id=@cmm_decode($encoded_id);
        if($coupon_id==''){
            redirect(SITE_URL);
            exit;
        }
        $where = array('coupon_id' => $coupon_id);
        //deactivating user
        $data_arr = array('status' => 2,
                          'modified_by'   => $this->session->userdata('user_id'),
                          'modified_time' => date('Y-m-d H:i:s'));
        $this->Common_model->update_data('coupon',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Coupon has been De-Activated successfully!</div>');
        redirect(SITE_URL.'coupon');

    }
    public function activate_coupon($encoded_id)
    {
        $coupon_id=@cmm_decode($encoded_id);
        if($coupon_id==''){
            redirect(SITE_URL);
            exit;
        }
        $where = array('coupon_id' => $coupon_id);
        //deactivating user
        $data_arr = array('status' => 1,
                          'modified_by'   => $this->session->userdata('user_id'),
                          'modified_time' => date('Y-m-d H:i:s'));
        $this->Common_model->update_data('coupon',$data_arr, $where);

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Coupon has been Activated successfully!</div>');
            redirect(SITE_URL.'coupon');
    }

    public function download_coupon()
    {
        if($this->input->post('download_coupon')!='') {
            
            $start_date=$this->input->post('start_date');
            if($start_date=='')
            {
                $start_date='';
            }
            else
            {
                $start_date= date('Y-m-d',strtotime($this->input->post('start_date')));
            }
            //echo $start_date;exit;
            $end_date=$this->input->post('end_date');
            if($end_date=='')
            {
                $end_date='';
            }
            else
            {
                $end_date= date('Y-m-d',strtotime($this->input->post('end_date')));
            }
            $search_params=array(
                        'start_date'    =>   $start_date,
                        'end_date'      =>   $end_date
                           );
            $coupon = @$this->Coupon_model->coupon_details($searchParams);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','No of Cartons','Start Date','End Date','Amount');
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
            if(count(@$coupon)>0)
              {
                foreach(@$coupon as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['no_of_cartons'].'</td>';
                    $data.='<td align="center">'.date('d-m-Y',strtotime($row['start_date'])).'</td>';
                    $data.='<td align="center">'.date('d-m-Y',strtotime($row['end_date'])).'</td>';
                    $data.='<td align="center">'.$row['amount'].'</td>';
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
            $xlFile='coupon_'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }

    public function consolidated_insurance_sales()
    {

        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Insurance Report";
        $data['nestedView']['pageTitle'] = 'Insurance Report';
        $data['nestedView']['cur_page'] = 'reports';
        $data['nestedView']['parent_page'] = 'insurance';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Insurance Report', 'class' => '', 'url' => '');  
        $data['distributor_list'] = $this->Insurance_product_m->get_active_distributor_list();
       // $data['loose_oils'] = $this->Insurance_product_m->get_oils();
        $data['units'] = $this->Insurance_product_m->get_units();
        $this->load->view('insurance/consolidated_insurance_sales',$data);
    }

    public function invoice_coupon_report()
    {

        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Invoice Coupon Report";
        $data['nestedView']['pageTitle'] = 'Invoice Coupon Report';
        $data['nestedView']['cur_page'] = 'invoice_coupon_report';
        $data['nestedView']['parent_page'] = 'invoice';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Invoice Coupon Report', 'class' => '', 'url' => '');   
        $data['loose_oil_list'] = $this->Common_model->get_data('loose_oil',array('status'=>1));
        $data['exec']=$this->Common_model->get_data('executive');
        $this->load->view('coupon/invoice_coupon_report',$data);
    }
    
    public function invoice_coupon_report_print()
    {
        
        $submit=$this->input->post('submit', TRUE);
        $from_date=date('Y-m-d', strtotime($this->input->post('from_date',TRUE)));
        $to_date=date('Y-m-d', strtotime($this->input->post('to_date',TRUE)));
        $executive_id=$this->input->post('executive_id');
        $data['executive']=$this->Common_model->get_data_row('executive',array('executive_id'=>$executive_id));
        $loose_oil_id=$this->input->post('loose_oil_id');
        $data['loose_oil']=$this->Common_model->get_data_row('loose_oil',array('loose_oil_id'=>$loose_oil_id));
       // $data['agency_name']=$dist['agency_name'];
        $data['coupons']=$this->Coupon_model->get_coupon_amount($from_date,$to_date);
        if(count($data['coupons']) > 0)
        {   
           $data['from_date']=date('d-m-Y',strtotime($from_date));
           $data['to_date']=date('d-m-Y',strtotime($to_date));
           $dist_sale_results=$this->Coupon_model->get_dist_sales_daily_report($from_date,$to_date,$executive_id,$loose_oil_id);
           //echo $this->db->last_query();
           $coupon_results=array();
                foreach($dist_sale_results as $key =>$value)
                {
                    if(array_key_exists(@$keys,$coupon_results))
                    {
                        $coupon_results[$value['distributor_id']] ['products'][] =array(
                            'product_id'     =>  $value['product_id'],
                            'product_name'   =>  $value['product_name'],
                            'invoice_number'=> $value['invoice_number'],
                            'invoice_date'  =>  $value['invoice_date'],
                            'quantity'      =>  $value['quantity'],
                            'amount'        =>  $value['amount'],
                             );
                    }
                    else
                    {
                        $coupon_results[$value['distributor_id']]['distributor_name']=$value['agency_name'].'['.$value['distributor_code'].']['.$value['location_name'].']';
                        $coupon_results[$value['distributor_id']] ['products'][] =array(
                            'product_id'     =>  $value['product_id'],
                            'product_name'   =>  $value['product_name'],
                            'invoice_number'=> $value['invoice_number'],
                            'invoice_date'  =>  $value['invoice_date'],
                            'quantity'      =>  $value['quantity'],
                            'amount'        =>  $value['amount'],
                             );
                    }
                }
                $data['coupon_results']=$coupon_results;
                //get coupons
               
                $this->load->view('coupon/invoice_coupon_report_print',$data);
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Error!</strong> No coupon exists in between dates </div>'); 
                redirect(SITE_URL.'invoice_coupon_report'); exit();
        }
    
    }

}