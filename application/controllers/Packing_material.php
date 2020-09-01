<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by maruthi 15th Nov 2016 09:00 AM

class Packing_material extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Packing_material_model");
	}

    public function packing_material()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Manage Packing Material';
        $data['nestedView']['heading'] = "Manage Packing Material";
        $data['nestedView']['cur_page'] = 'packing_material';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'product';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Manage Packing Material','class'=>'active','url'=>'');
        $data['denomination_list']=$this->Packing_material_model->get_unit_capacity();
        $data['pm_category_list'] = $this->Common_model->get_data('packing_material_category',array('status'=>1));
        # Search Functionality
        $psearch=$this->input->post('search_packing_material', TRUE);
        if($psearch!='') {
        $search_params=array(
                        'packing_material_name'   =>   $this->input->post('packing_material', TRUE),
                        'capacity_id'  =>$this->input->post('capacity_id',TRUE),
                        'pm_category_id'=>$this->input->post('pm_category_id',TRUE),
                        'pm_group'=>$this->input->post('pm_group',TRUE),
                        'status'	=>$this->input->post('status',TRUE)
                              );
        $this->session->set_userdata($search_params);
        } else {
            
            if($this->uri->segment(2)!='')
            {
            $search_params=array(
                        'packing_material_name'   =>   $this->session->userdata('packing_material_name'),
                        'capacity_id'   =>   $this->session->userdata('capacity_id'),
                        'pm_category_id'=>$this->session->userdata('pm_category_id'),
                        'pm_group'=>$this->session->userdata('pm_group'),
                        'status'=>$this->session->userdata('status')
                              );
            }
            else {
                $search_params=array(
                        'packing_material_name'   =>'',
                        'capacity_id'   =>'',
                        'pm_category_id'=>'',
                        'pm_group'=>'',
                        'status'=>''
                                  );
                $this->session->unset_userdata(array_keys($search_params));
            }
            
        }
        $data['search_params'] = $search_params;
        
         # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'packing_material/';
        # Total Records
        $config['total_rows'] = $this->Packing_material_model->packing_material_total_num_rows($search_params);

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
        $data['packing_material'] = $this->Packing_material_model->Packing_material_results($search_params,$config['per_page'], $current_offset);
        $data['pm_group_results'] = array(''=>'-PM Group-')+$this->Common_model->get_dropdown('pm_group','pm_group_id','name',array('status'=>1));
        # print_r($data['packing_material']); exit();
        # Additional data
        $data['display_results'] = 1;

        $this->load->view('product/manage_packing_material',$data);
    }

    public function add_packing_material()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Add Packing Material';
        $data['nestedView']['heading'] = "Add Packing Material";
        $data['nestedView']['cur_page'] = 'packing_material';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'product';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/packing_material.js"></script>';
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Manage Packing Material','class'=>'active','url'=>SITE_URL.'packing_material');
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Add Packing Material','class'=>'active','url'=>'');

        # Data
        
        # Additional data
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_packing_material';
        $data['category'] = array(''=>'-Select Test Category-')+$this->Common_model->get_dropdown('packing_material_category','pm_category_id','name',array('status'=>1));
        $data['capacity'] = $this->Packing_material_model->get_capacity();
        $data['pm_group_results'] = array(''=>'-Select Group-')+$this->Common_model->get_dropdown('pm_group','pm_group_id','name',array('status'=>1));
        $data['display_results'] = 0;
        $this->load->view('product/manage_packing_material',$data);
    }

    public function insert_packing_material()
    {
        // GETTING INPUT TEXT VALUES
        $data = array( 
                    'pm_category_id'                 =>  $this->input->post('category', TRUE),
                    'pm_group_id'                   =>  $this->input->post('pm_group', TRUE),
                    'name'                          =>  $this->input->post('packing_material', TRUE),
                    'pm_code'                       =>  $this->input->post('pm_code', TRUE),
                    'description'                   =>  $this->input->post('description', TRUE),                  
                    'created_by'                    =>  $this->session->userdata('user_id'),
                    'created_time'                  =>  date('Y-m-d H:i:s'),
                    'status'                        =>  1
                    );
        
        $packing_id = $this->Common_model->insert_data('packing_material',$data);

        $data1 = array( 
                    'pm_id'                 =>  $packing_id,
                    'capacity_id'           =>  $this->input->post('capacity', TRUE)
                    );
        
        $this->Common_model->insert_data('packing_material_capacity',$data1);

        if ($packing_id>0)
        {
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Packing Material has been added successfully! </div>');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Something went wrong. Please check. </div>');       
        }

        redirect(SITE_URL.'packing_material'); 
    }

    public function edit_packing_material()
    {
        $packing_id=@cmm_decode($this->uri->segment(2));
        if($packing_id=='')
        {
            redirect(SITE_URL);
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Edit Packing Material';
        $data['nestedView']['heading'] = "Edit Packing Material";
        $data['nestedView']['cur_page'] = 'packing_material';
        $data['nestedView']['parent_page'] = 'master';
        $data['nestedView']['list_page'] = 'product';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/packing_material.js"></script>';
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Manage Packing Material','class'=>'active','url'=>SITE_URL.'packing_material');
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Edit Packing Material','class'=>'active','url'=>'');

        # Additional data
        $data['flg'] = 2;
        $data['form_action'] = SITE_URL.'update_packing_material';
        $data['category'] = array(''=>'-Select Category-')+$this->Common_model->get_dropdown('packing_material_category','pm_category_id','name');
        $data['selected_category'] = $this->Common_model->get_value('packing_material',array('pm_id'=>$packing_id),'pm_category_id');
        $data['capacity'] = $this->Packing_material_model->get_capacity();
        $data['display_results'] = 0;
        $data['pm_group_results'] = array(''=>'-Select Group-')+$this->Common_model->get_dropdown('pm_group','pm_group_id','name',array('status'=>1));
        # Data
        $row = $this->Packing_material_model->packing_material($packing_id);
        $data['packing_material_row'] = $row[0];
        //echo '<pre>'; print_r($row); exit;
        $this->load->view('product/manage_packing_material',$data);
    }

    public function update_packing_material()
    {
        $packing_id=@cmm_decode($this->input->post('encoded_id',TRUE));
        if($packing_id=='')
        {
            redirect(SITE_URL);
            exit;
        }

        // GETTING INPUT TEXT VALUES
        $data = array( 
                    'pm_category_id'                =>  $this->input->post('category', TRUE),
                    'name'                          =>  $this->input->post('packing_material', TRUE),
                    'pm_code'                       =>  $this->input->post('pm_code', TRUE),
                    'pm_group_id'                   =>  $this->input->post('pm_group', TRUE),
                    'description'                   =>  $this->input->post('description', TRUE),                  
                    'modified_by'                   =>  $this->session->userdata('user_id')
                    );
        $where = array('pm_id'=>$packing_id);
        $packing_material_id = $this->Common_model->update_data('packing_material',$data,$where);

        $data1 = array( 
                    'pm_id'                 =>  $packing_id,
                    'capacity_id'           =>  $this->input->post('capacity', TRUE)
                    );
        
        $this->Common_model->update_data('packing_material_capacity',$data1,$where);

        if ($packing_material_id>0)
        {
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Packing Material has been updated successfully! </div>');
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Something went wrong. Please check. </div>');       
        }

        redirect(SITE_URL.'packing_material'); 
    }

    public function deactivate_packing_material()
    {
        $packing_id=@cmm_decode($this->uri->segment(2));
        $where = array('pm_id' => $packing_id);
        $dataArr = array('status' => 2);
        $this->Common_model->update_data('packing_material',$dataArr, $where);
        
        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <strong>Success!</strong> Packing Material has been De-Activated successfully!
                             </div>');

        redirect(SITE_URL.'packing_material');
    }

    public function activate_packing_material()
    {
        $packing_id=@cmm_decode($this->uri->segment(2));
        $where = array('pm_id' => $packing_id);
        $dataArr = array('status' => 1);
        $this->Common_model->update_data('packing_material',$dataArr, $where);
        
        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <strong>Success!</strong> Packing Material has been De-Activated successfully!
                             </div>');

        redirect(SITE_URL.'packing_material');
    }

        public function download_packing_material()
    {
        if($this->input->post('download_packing_material')!='')
        {
            $searchParams=array(
                                  'packing_material_name'   =>   $this->input->post('packing_material', TRUE),
                                    'capacity_id'  =>$this->input->post('capacity_id',TRUE),
                                    'pm_category_id'=>$this->input->post('pm_category_id',TRUE),
                                    'pm_group'=>$this->input->post('pm_group',TRUE),
                                    'status'    =>$this->input->post('status',TRUE)
                                        );
            $products = $this->Packing_material_model->packing_material_details($searchParams);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','Packing Material','PM Group','Test Category','Capacity','Description');
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
            if(count($products)>0)
            {
                foreach($products as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="left">'.$j.'</td>';
                    $data.='<td align="left">'.$row['packing_material'].'</td>';
                    $data.='<td align="left">'.$row['pm_group'].'</td>';
                    $data.='<td align="left">'.$row['category'].'</td>';
                    $data.='<td align="left">'.$row['capacity'].' '.$row['unit'].'</td>';
                    $data.='<td align="left">'.$row['description'].'</td>';             
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
            $xlFile='Packing_material'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data; 
        }
    }

    /*Opening stock for packing material
Author:Srilekha
Time: 12.45PM 05-03-2017 */
    public function pm_quantity()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Opening Stock Entry For Packing Material ";
        $data['nestedView']['pageTitle'] = 'Opening Stock Entry For Packing Material';
        $data['nestedView']['cur_page'] = 'opening_stock_entry_for_pm';
        $data['nestedView']['parent_page'] = 'opening_stock_entry';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Opening Stock Entry For Packing Material', 'class' => 'active', 'url' => ''); 
        $data['flag']=1;
        $data['portlet_title'] = 'Opening Stock Entry For Packing Material';
       
        $this->load->view('stock_entry/opening_stock_entry_view',$data);
    }
/*Opening stock for packing material view
Author:Srilekha
Time: 01.03PM 05-03-2017 */
    public function view_pm_quantity()
    {
        if($this->input->post('plant_id',TRUE))
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

          
                $plant_id=$this->input->post('plant_id');

                $pm=$this->Packing_material_model->get_pm();
                foreach($pm as $key =>$value)
                {   
                    $pm_results[$value['pm_category_id']]['pm_category_name']=$value['pm_category_id'];
                    $pm_results[$value['pm_category_id']]['pm_name']=$value['name'];
                    $pm_results[$value['pm_category_id']]['plant_id']=$plant_id;
                    $results=$this->Packing_material_model->get_sub_pm_by_pm($value['pm_category_id']);
                    $pm_results[$value['pm_category_id']]['sub_products']=$results;
                }
            $data['plant_id']=$plant_id;
            @$product_id=$this->Common_model->get_data('plant_pm',array('plant_id'=>$plant_id));
            
            foreach($product_id as $key=>$value)
            {
                @$result[$value['plant_id']][$value['pm_id']]=$value['quantity'];
             
            } 
            
            $data['results']=@$result;
            $plant_name=$this->Common_model->get_value('plant',array('plant_id'=>$plant_id),'name');

            $data['pm_results']=$pm_results;
            $data['portlet_title'] =$plant_name;
            $data['flag']=2;
            $this->load->view('stock_entry/opening_stock_entry_view',$data);
        }
        else
        {
            redirect(SITE_URL.'pm_quantity');
        }
        
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

             
            if($value !='')
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
        redirect(SITE_URL.'pm_quantity');
        
    } 
    public  function is_pm_name_Exist()
    {
        $name = $this->input->post('pm_name');
        $pm_id = $this->input->post('pm_id');
        $capacity_id =$this->input->post('capacity_id');
        echo $this->Packing_material_model->is_nameExist($name,$pm_id,$capacity_id);
    }
}