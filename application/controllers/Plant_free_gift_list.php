<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';
class Plant_free_gift_list extends Base_controller {
/*
 * created by Roopa on 2st march 2017 2:00PM
*/	
	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Plant_free_gift_m");
	}
    /*plant free gift list
    Author:Roopa
    Time: 06.26PM 02-03-2017 */
	public function plant_freegift_list()
	{
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Plant FreeGift List";
		$data['nestedView']['pageTitle'] = 'Plant FreeGift list';
        $data['nestedView']['cur_page'] = 'plant_freegift_list';
        $data['nestedView']['parent_page'] = 'Plant FreeGift list';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Plant FreeGift list', 'class' => '', 'url' => '');	
        
        $p_search=$this->input->post('search_plant_freegift_list', TRUE);
        if($p_search!='') 
        {
            $search_params=array(
                'plant_id' => $this->input->post('plant', TRUE)              
            
                              );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'plant_id'   => $this->session->userdata('plant')
                                  );
            }
            else {
                $search_params=array(
                      'plant_id'    => ''
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;
        


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'plant_freegift_list/';
        # Total Records
        $config['total_rows'] = $this->Plant_free_gift_m->plant_free_gift_total_num_rows($search_params);

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
        $data['plant'] = array('' =>'-Select Plant-')+$this->Common_model->get_dropdown('plant','plant_id','name');

        # Loading the data array to send to View
        $data['plant_free_gift_results'] = $this->Plant_free_gift_m->plant_free_gift_results($current_offset, $config['per_page'], $search_params);
       
        # Additional data
        $data['display_results'] = 1;
        $this->load->view('plant_free_gift_list/plant_freegift_view',$data);
    }
    /*plant free gift download...
    Author:Roopa
    Time: 06.26PM 02-03-2017 */
     public function download_plant_freegift_list()
    {
        if($this->input->post('download_plant_freegift_list')!='') 
        {
            $search_params=array(
                              'plant_id'        => $this->input->post('plant', TRUE)
                               
                                );
            $plant_freegift_details = $this->Plant_free_gift_m->plant_freegift_details($search_params);            
            $header = '';
            $data ='';
            $titles = array('S.NO','Unit','FreeGift Name','Quantity');
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
            if(count($plant_freegift_details)>0)
            {
                
                foreach($plant_freegift_details as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['plant_name'].'</td>'; 
                    $data.='<td align="center">'.$row['free_gift_name'].'</td>'; 
                    $data.='<td align="center">'.$row['quantity'].'</td>';                                      
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
            $xlFile='plant_free_gift'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
        }
    }
}