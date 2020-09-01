<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

class Free_samples extends Base_controller {
	public function __construct() 
    {
        parent::__construct();
        $this->load->model("Common_model");
        $this->load->model("Free_sample_m");
    }
/*Free Sampls List details
Author:Srilekha
Time: 11.24AM 21-02-2017 */
	public function free_sample_list()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage Freesample List";
        $data['nestedView']['pageTitle'] = 'Manage Freesample List';
        $data['nestedView']['cur_page'] = 'free_sample_list';
        $data['nestedView']['parent_page'] = 'sales';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Freegift List', 'class' => 'active', 'url' => '');   

        # Search Functionality
        $p_search=$this->input->post('search_freesample', TRUE);
        
		if($this->input->post('from_date',TRUE)!='')
        {
            $from_date=date('Y-m-d', strtotime($this->input->post('from_date',TRUE)));  
        }
        else
        {
            $from_date = '';
        }
        if($this->input->post('to_date',TRUE)!='')
        {
            $to_date=date('Y-m-d', strtotime($this->input->post('to_date',TRUE)));  
        }
        else
        {
            $to_date = '';
        }
        if($p_search!='') 
        {
            $search_params=array(
                'do_number'         => $this->input->post('do_number', TRUE),
                'product'       	=> $this->input->post('product', TRUE),
                'from_date'         => $from_date,
                'to_date'			=> $to_date
            
                                );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'do_number'     => $this->session->userdata('do_number'),
                    'product'   	=> $this->session->userdata('product'),
                    'from_date'     => $this->session->userdata('from_date'),
                    'to_date'       => $this->session->userdata('to_date')
                                    );
            }
            else {
                $search_params=array(
                      'do_number'       => '',
                      'product'     	=> '',
                      'from_date'       => '',
                      'to_date'			=> ''
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;
        


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'free_sample_list/';
        # Total Records
        $config['total_rows'] = $this->Free_sample_m->freesample_total_num_rows($search_params);

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
        $data['freesample_results'] = $this->Free_sample_m->freesample_results($current_offset, $config['per_page'], $search_params);
        $data['product']=$this->Common_model->get_data('product', array('status'=>1));
        # Additional data
        $data['display_results'] = 1;

        $this->load->view('free_sample/free_sample_view',$data);
	}
/*Free Sample details
Author:Srilekha
Time: 11.34AM 21-02-2017 */
	public function add_free_samples()
	{

		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Add FreeSample";
        $data['nestedView']['pageTitle'] = 'Add Freesample';
        $data['nestedView']['cur_page'] = 'free_sample_list';
        $data['nestedView']['parent_page'] = 'sales';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/free_sample.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Freesample List', 'class' => '', 'url' => SITE_URL.'free_sample_list');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add FreeSample', 'class' => 'active', 'url' => '');

        $data['flag']=1;
        
        $data['product']=$this->Common_model->get_data('product', array('status'=>1));
        $data['freesample_type']=$this->Common_model->get_data('item_type',array('status'=>1));

        
		$data['do_number']=get_current_serial_number(array('value'=>'do_number','table'=>'free_sample','where'=>'created_time'));
		$data['carton_list']=get_per_carton_items();
        $data['form_action'] = SITE_URL.'insert_freesamples';
        
        $this->load->view('free_sample/free_sample_view',$data);
	}
/*Insert Free Sample details
Author:Srilekha
Time: 01.30PM 21-02-2017 */
	public function insert_freesamples()
	{
        $do_number = get_current_serial_number(array('value'=>'do_number','table'=>'free_sample','where'=>'created_time'));
		$quant = $this->input->post('quantity',TRUE);
        $stock_quantity=$this->input->post('stock_quantity',TRUE);
        $type = $this->input->post('sample_type',TRUE);
        $items_per_carton=$this->input->post('items_per_carton');

        if($type==1)
        {
            $quantity = $quant;
        }
        else if($type==2)
        {
            $quantity = $quant/$items_per_carton;
        }
        if($stock_quantity>=$quant)
        {
            $plant_id = $this->Common_model->get_value('user',array('user_id'=>$this->session->userdata('user_id')),'plant_id');
            $product_id=$this->input->post('product_id');
                $on_date=date('Y-m-d', strtotime($this->input->post('on_date',TRUE)));
                // GETTING INPUT TEXT VALUES
                $data=array(
                            'do_number'             =>     $do_number,
                            'description'           =>     $this->input->post('description'),
                            'product_id'            =>     $this->input->post('product_id'),
                            'quantity'              =>     $quantity,
                            'plant_id'              =>     $plant_id,
                            'on_date'               =>     $on_date,
                            'items_per_carton'      =>     $items_per_carton,
                            'created_by'            =>     $this->session->userdata('user_id'),
                            'created_time'          =>     date('Y-m-d H:i:s')
                            );
                
                $this->db->trans_begin();
                $this->Common_model->insert_data('free_sample',$data);
                $query = 'select * from plant_product where product_id="'.$product_id.'" AND plant_id="'.$plant_id.'"';
                $count = $this->Common_model->get_no_of_rows($query);
                if($count>0)
                {
                    $qry='UPDATE plant_product set quantity=quantity-'.$quantity.' where product_id='.$product_id.' and plant_id='.$plant_id;
                    $this->db->query($qry);
                }
                else
                {
                    $insert_data = array('product_id'  => $product_id,
                                         'plant_id'=> $plant_id,
                                         'quantity'  => $quantity,
                                         'loose_pouches' => 0,
                                         'updated_time' => date('Y-m-d H:i:s'));
                    $this->Common_model->insert_data('plant_product',$insert_data);
                }
                

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
                        <strong>Success!</strong> Free Samples has been added successfully! </div>');
                    }
                
                
              redirect(SITE_URL.'free_sample_list');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        <strong>Error!</strong> Quantity Should be less than Stock Quantity. Please check. </div>');
            redirect(SITE_URL.'add_free_samples');
        }
        
			
        
	}
/*Download Free Sample details
Author:Srilekha
Time: 12.35PM 16-02-2017 */
	public function download_freesamples()
    {
        if($this->input->post('download_freesample')!='') {
            
           $search_params=array(
                'do_number'         => $this->input->post('do_number', TRUE),
                'product'       	=> $this->input->post('product', TRUE),
                'from_date'         => $this->input->post('from_date', TRUE),
                'to_date'			=> $this->input->post('to_date', TRUE)
            
                                );   
            $free_sample = $this->Free_sample_m->freesample_details($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','Product Name','DO Number','Date','Quantity','No of Items','description');
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
            if(count($free_sample)>0)
            {
                
                foreach($free_sample as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['product_name'].'</td>';
                    $data.='<td align="center">'.$row['do_number'].'</td>';
                    $data.='<td align="center">'.date('d-m-Y',strtotime($row['on_date'])).'</td>';
                    $data.='<td align="center">'.$row['quantity'].'</td>'; 
                    $data.='<td align="center">'.$row['items_per_carton'].'</td>';
                    $data.='<td align="center">'.$row['description'].'</td>';                    
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
            $xlFile='Free_samples'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }

    }
/*No of Items per carton details
Author:Srilekha
Time: 03.35PM 21-02-2017 */
    public function getitemsList()
    {

    	$product_id = $this->input->post('product_id',TRUE);
    	
    	echo $this->Free_sample_m->getitemsList($product_id);
    }
/*Quantity details
Author:Srilekha
Time: 12.48PM 04-03-2017 */
    public function getquantityList()
    {

        $product_id = $this->input->post('product_id',TRUE);
        $plant_id   = $this->input->post('plant_id',TRUE);
        
        echo $this->Free_sample_m->getquantityList($product_id,$plant_id);
    }
}