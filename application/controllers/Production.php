<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by maruthi 21th Feb 2017 09:00 AM

class Production extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Production_m");
        $this->load->model("Pm_consumption_m");
	}
	public function manage_production()
	{

        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Manage Production ";
		$data['nestedView']['pageTitle'] = 'Manage Production ';
        $data['nestedView']['cur_page'] = 'manage_production';
        $data['nestedView']['parent_page'] = 'manage_production';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Production', 'class' => '', 'url' => '');	

        # Search Functionality
        $p_search=$this->input->post('search_production', TRUE);
        if($p_search!='') 
        {
            $from_date=(($this->input->post('from_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('from_date', TRUE))):''; 
            $to_date=(($this->input->post('to_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('to_date', TRUE))):''; 
            $search_params=array(
                'loose_oil_id'       => $this->input->post('loose_oil_id', TRUE),
                'product_id'         => $this->input->post('product_id', TRUE),
                'created_by'         => $this->input->post('entry_by', TRUE),
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
                'product_id'         => $this->session->userdata('product_id'),
                'created_by'         => $this->session->userdata('created_by'),
                'from_date'          => $this->session->userdata('from_date'),
                'to_date'            => $this->session->userdata('to_date')
                    );
            }
            else 
            {
                $search_params=array(
                    'loose_oil_id'      => '',
                    'product_id'        => '',
                    'created_by'        => '',
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
        $config['base_url'] = SITE_URL . 'manage_production/';
        # Total Records
        $config['total_rows'] = $this->Production_m->production_total_num_rows($search_params);

        $config['per_page'] = getDefaultPerPageRecords_ops();

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

        if($search_params['loose_oil_id']!='')
        {
            $data['products']           = $this->Common_model->get_data('product',array('status'=>'1','loose_oil_id'=>$search_params['loose_oil_id']));
        }
        else
        {
            $data['products']           = $this->Common_model->get_data('product',array('status'=>'1'));
        }

        # Loading the data array to send to View
        $data['production_results'] = $this->Production_m->production_results($current_offset, $config['per_page'], $search_params);
        $data['loose_oils']         = $this->Common_model->get_data('loose_oil',array('status'=>'1'));
        
        $data['users']              = $this->Common_model->get_data('user',array('status'=>'1','plant_id'=>get_plant_id()));
        


        # Additional data
        $data['display_results'] = 1;
        $this->load->view('production/production_entry_view',$data);
    }    
    public function production_entry()
    {
        $oil_stock_balance = $this->Common_model->get_data('oil_stock_balance',array('plant_id'=>get_plant_id()));
        $pm_stock_balance = $this->Common_model->get_data('pm_stock_balance',array('plant_id'=>get_plant_id()));
        if(count($oil_stock_balance) == 0 || count($pm_stock_balance) == 0)
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Error!</strong> Please Take opening balance for oils or packing Materials. </div>');       
            redirect(SITE_URL.'manage_production');
        }
        $openig_balance = $this->Common_model->get_data('oil_stock_balance',array('plant_id'=>get_plant_id(),'on_date'=>date('Y-m-d')));
        //echo count($openig_balance);exit;
        if(count($openig_balance)== 0)
        {
            $this->session->set_flashdata('response','<div class="alert alert-warning alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Warning!</strong> Oil Opening balance stock entry not yet taken today.please do  . </div>');       
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Production Entry";
        $data['nestedView']['pageTitle'] = 'Production Entry';
        $data['nestedView']['cur_page'] = 'production_entry';
        $data['nestedView']['parent_page'] = 'mange_production_entry';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/production_entry.js"></script>';

        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Production Entry', 'class' => '', 'url' => SITE_URL.'manage_production');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'production Entry', 'class' => '', 'url' => '');
        
        # Additional data

        $data['product_details'] = $this->Common_model->get_data('product',array('status'=>'1')); 
        $data['loose_oil']= $this->Common_model->get_data('loose_oil',array('status'=>1)); 
        $data['micron_details']= $this->Common_model->get_data('micron',array('status'=>1)); 
          
        foreach ($data['loose_oil'] as $value) 
        {
            $results = $this->Common_model->get_data('product',array('status'=>'1','loose_oil_id'=>$value['loose_oil_id'])); 
            $products[$value['loose_oil_id']]=$results;                  
        }
        $data['products']= $products;    
        $data['form_action'] = SITE_URL.'confirm_production_entry';
        $data['flg']=1;

        if(@$this->input->post('cancel',TRUE) == 2)
        {
            $data['production_entry_list']=$_POST;
            //echo '<pre>';print_r($data['production_entry_list']);exit;
            $this->load->view('production/production_entry_edit_view',$data); 
        }
        else
        {
            $this->load->view('production/production_entry_view',$data);  
        }                        
    }    
    public function confirm_production_entry()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Confirm Production Entry";
        $data['nestedView']['pageTitle'] = 'Confirm Production Entry';
        $data['nestedView']['cur_page'] = 'confirm_production_entry';
        $data['nestedView']['parent_page'] = 'production_entry';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/production_entry.js"></script>';

        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Production Entry', 'class' => '', 'url' => SITE_URL.'manage_production');  
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Production Entry', 'class' => 'active', 'url' => 'production_entry');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Confirm Production Entry', 'class' => 'active', 'url' => '');

        # Data
        
        # Additional data
        $data['production_entry_list']=$_POST;

       /*echo '<pre>';
        print_r($data['production_entry_list']);exit;*/
         /*
        foreach ($data['production_entry_list']['product_id'] as $key => $value) {
            echo '<pre>';
            echo get_product_name($value);
            echo $_POST['quantity'][$key];
            echo $_POST['per_carton'][$key];
            # code...
        }
        exit;*/
        
        $data['flg'] = 1;
        $data['form_action'] = SITE_URL.'insert_production_entry';
        $data['display_results'] = 0;
        $this->load->view('production/confirm_production_entry_view',$data);
    }    
    public function insert_production_entry()
    {
        /*echo '<pre>';
        print_r($_POST);
        exit;*/

        
        
        
        $this->db->trans_begin();
        // checking emplty recods in oil stock balance
        $res=$this->Production_m->get_latest_stock_balance_record();
        //print_r($res);exit;
        if(@$res)
        {   
            // Insert into Plant Production Table            
            $plant_production_data=array(
                        'plant_id'        => get_plant_id(),
                        'production_date' => date('Y-m-d'),
                        'created_by'      => $this->session->userdata('user_id'),
                        'created_time'    => date('Y-m-d H:i:s')
                    );
            $plant_production_id = $this->Common_model->insert_data('plant_production',$plant_production_data);
            //echo $this->db->last_query().'<br>';
            foreach ($_POST['product_id'] as $key => $value) 
            {                
                $quantity = $_POST['quantity'][$key] ;
                $loose_pouches = ($_POST['loose_pouches'][$key]!='')?$_POST['loose_pouches'][$key]:0;

                /*echo $quantity; echo '<br>';
                echo $loose_pouches;exit;*/
                $production_product_data = array(
                                'plant_production_id' => @$plant_production_id,
                                'product_id'          => $value,
                                'quantity'            => $quantity,
                                'items_per_carton'    => $_POST['per_carton'][$key],
                                'loose_pouches'       => $loose_pouches,
                                );
                $produced_pouches = $_POST['hidden_sachets'][$key];
                $production_product_id = $this->Common_model->insert_data('production_product',$production_product_data);                
                //echo $this->db->last_query().'<br>';
                // Production Entry Update in Oil Stock Balance
                    $oil_wt = get_oil_weight($value);
                    $production_oil = (((($quantity*$_POST['per_carton'][$key]) + $loose_pouches)*$oil_wt)/1000);
                    $qry ='UPDATE oil_stock_balance SET production = production+'.$production_oil.'
                             WHERE plant_id = '.get_plant_id().' AND loose_oil_id ='.get_loose_oil_id($value).' AND closing_balance IS NULL';
                    $this->db->query($qry); 
                   // echo $this->db->last_query().'<br>';
                    //echo $this->db->last_query();exit;

                // Production Entry in PM stock Balance  

                    // Secondary Consumption Calculation
                    $secondary_consumption = $this->Pm_consumption_m->get_secondary_consumption_data($value);
                   /* echo $this->db->last_query().'<br>';
                    echo '<pre>';
                    print_r($secondary_consumption);*///exit;
                    // Check the condition for records
                    if(count($secondary_consumption)>0)
                    {
                        foreach ($secondary_consumption as  $row1)
                        {
                            $pm_val = $this->Common_model->get_value('plant_pm',array('plant_id'=>get_plant_id(),'pm_id'=>$row1['pm_id']),'quantity');
                            /*echo $this->db->last_query().'<br>';
                                print_r($pm_val);*/
                            //exit;
                            if(@$pm_val)
                            { 

                                                               
                                //echo $this->db->last_query().'<br>';
                                //echo $this->db->last_query();exit;

                                // checking pm stock balance entry for that caegory
                                $pm_stock_records = $this->Production_m->get_latest_pm_stock_balance_record($row1['pm_id']);
                               // echo $this->db->last_query().'<br>';
                                /*echo $this->db->last_query();
                               print_r($pm_stock_records);exit;*/
                                if(@$pm_stock_records){
                                    // updating in plant_pm
                                    $qry ='UPDATE plant_pm SET quantity = quantity-'.$quantity*$row1['quantity'].'
                                             WHERE plant_id = '.get_plant_id().' AND pm_id ='.$row1['pm_id'].'';
                                    $this->db->query($qry);
                                    //echo 'hi';
                                    // updating in pm_stock_balace
                                    $qry ='UPDATE pm_stock_balance SET production = production +'.$quantity*$row1['quantity'].'
                                         WHERE plant_id = '.get_plant_id().' AND pm_id ='.$row1['pm_id'].' AND closing_balance IS NULL';
                                    $this->db->query($qry);
                                    // inserting in production_pm table
                                    $production_pm_data = array(
                                        'production_product_id' => @$production_product_id,
                                        'pm_id'                 => $row1['pm_id'],
                                        'quantity'              => ($quantity*$row1['quantity'])
                                        
                                        );   
                            
                                    $this->Common_model->insert_data('production_pm',$production_pm_data);
                                    //echo $this->db->last_query().'<br>';
                                     //echo $this->db->last_query();//exit;
                                    /*$production = $quantity*$value['quantity'];
                                    $data = array('production'=>'production+'.$production);
                                    $this->Common_model->update_data('pm_stock_balace',$data,$where);*/
                                }//exit;
                                else
                                {
                                    $this->db->trans_rollback();
                                     $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                                <strong>Error!</strong> Packing Material Opening Balance Not Taken,So Please Take opening Balance. </div>');       
                                    redirect(SITE_URL.'manage_production');
                                }

                            }
                            /*else
                            {
                                //exit;
                                // Packing Material Not Found For this Product
                                $this->db->trans_rollback();
                                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                                <strong>Error!</strong> Packing Material Quantity Not Found in Stock. </div>');       
                                redirect(SITE_URL.'manage_production');
                            }*/
                        }
                    }//exit;

                    // Primary Consumption Calculation
                    $primary_consumption = $this->Pm_consumption_m->get_primary_consumption_data($value);
                   /* echo $this->db->last_query().'<br>';
                    echo '<pre>';print_r($primary_consumption);*///exit;
                    // Film Deduction
                    if($_POST['pm_id'][$key]!='' && $_POST['micron_id'][$key]!='')
                    {   
                       //echo 'jo';//exit; 
                        $packets_per_kg_data = $this->Production_m->get_packets_per_kg($value,$_POST['pm_id'][$key],$_POST['micron_id'][$key]);
                        /*echo $this->db->last_query().'<br>';
                          echo '<pre>';print_r($packets_per_kg_data);*///exit;                  
                        if($packets_per_kg_data)
                        { 
                            //echo 'yes';exit;
                            $film_quantity = $packets_per_kg_data['present_quantity'];
                            $expected_pouches =$packets_per_kg_data['value'];
                            //$film_pouches = round($expected_pouches*$film_quantity);                        
                            
                            $film_consumption = round(($produced_pouches/$expected_pouches),3);
                            $a =$this->Production_m->update_plant_film_stock($packets_per_kg_data['pfs_id'],$film_consumption);
                            //echo $this->db->last_query();  //echo $a;exit;                               
                            //echo $this->db->last_query().'<br>'; 
                             // Inserting in Production_pm_micron

                            $production_pm_micron_data = array(
                                        'production_product_id' => @$production_product_id,
                                        'pm_id'                 => $_POST['pm_id'][$key],
                                        'quantity'              => $film_consumption,
                                        'micron_id'             => $_POST['micron_id'][$key],                                               
                                        );   
                            
                            $this->Common_model->insert_data('production_pm_micron',$production_pm_micron_data);
                             //echo $this->db->last_query().'<br>';
                            $qry ='UPDATE plant_pm SET quantity = quantity-'.$film_consumption.'
                                     WHERE plant_id = '.get_plant_id().' AND pm_id ='.$_POST['pm_id'][$key].' ';
                            $this->db->query($qry); 
                            //echo $this->db->last_query().'<br>';
                            //echo $this->db->last_query(); //exit;                               
                             $qry ='UPDATE pm_stock_balance SET production = production +'.$film_consumption.'
                                 WHERE plant_id = '.get_plant_id().' AND pm_id ='.$_POST['pm_id'][$key].' AND closing_balance IS NULL';
                            $this->db->query($qry);
                            //echo $this->db->last_query().'<br>';
                            //echo $this->db->last_query(); exit;                               
                        }
                        /*else
                        { 
                            $this->db->trans_rollback();
                            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Error!</strong> Packing Material For Film Not Found. So Please take Plant Film Stock </div>');       
                            redirect(SITE_URL.'manage_production');
                        }*/
                    }
                    //echo '<pre>'; print_r($primary_consumption); exit;
                    // Check the condition for records
                    if(count($primary_consumption)>0)
                    {
                        foreach ($primary_consumption as $key => $row2)
                        {
                            // hecking Stock is Available inn that plant 
                            $pm_val = $this->Common_model->get_value('plant_pm',array('plant_id'=>get_plant_id(),'pm_id'=>$row2['pm_id']),'quantity');
                            
                            // For Only Film  Category
                            
                            // Other Than Film Category
                            if($row2['pm_cat_id']!= get_film_category_id())
                            {
                                //echo '123';exit;
                               // updating in plant_pm
                                
                                //echo $this->db->last_query().'<br>';
                                // checking pm stock balance entry for that plant and pm
                                $pm_stock_records = $this->Production_m->get_latest_pm_stock_balance_record($row2['pm_id']);
                                if(@$pm_stock_records)
                                {
                                    $qry ='UPDATE plant_pm SET quantity = quantity-'.$produced_pouches*$row2['quantity'].'
                                        WHERE plant_id = '.get_plant_id().' AND pm_id ='.$row2['pm_id'].'';
                                    $this->db->query($qry);
                                    // updating in pm_stock_balace
                                    $qry ='UPDATE pm_stock_balance SET production = production +'.$produced_pouches*$row2['quantity'].'
                                             WHERE plant_id = '.get_plant_id().' AND pm_id ='.$row2['pm_id'].' AND closing_balance IS NULL';
                                        $this->db->query($qry);


                                    // inserting in production pm 
                                        $production_pm_data = array(
                                        'production_product_id' => @$production_product_id,
                                        'pm_id'                 => $row2['pm_id'],
                                        'quantity'              => ($produced_pouches*$row2['quantity'])                                        
                                        );  
                            
                                    $this->Common_model->insert_data('production_pm',$production_pm_data);
                                        //echo $this->db->last_query().'<br>';
                                }
                                /*else
                                {
                                   // $this->db->trans_rollback();
                                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                                <strong>Error!</strong> Packing Material Opening Balance Not Taken,So Please Take opening Balance. </div>');       
                                } */
                            }  
                            //echo 'lp';exit;              
                        } 
                    }               
                $this->Production_m->insert_update_production($value,$quantity,$loose_pouches);
               // echo $this->db->last_query().'<br>';                
            }  
            //print_r($tf);      
            //exit;
            if ($this->db->trans_status() === FALSE)
            { //echo 'pop';exit;
                $this->db->trans_rollback();
                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Error!</strong> Something went wrong. Please check. </div>');       
                
            }
            else
            { //echo 'success';exit;
                $this->db->trans_commit();//exit;
                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Production Entry successfully! </div>');
            }
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                            <strong>Error!</strong> No Records Found or Opening Balance Not yet taken  !  </div>');       
            
        }       
        redirect(SITE_URL.'manage_production');
    }
    public function download_production()
    {
        if($this->input->post('download_production')!='') {
            
            $from_date=(($this->input->post('from_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('from_date', TRUE))):''; 
            $to_date=(($this->input->post('to_date',TRUE))!='')?date('Y-m-d',strtotime($this->input->post('to_date', TRUE))):''; 
            $search_params=array(
                'loose_oil_id'       => $this->input->post('loose_oil_id', TRUE),
                'product_id'         => $this->input->post('product_id', TRUE),
                'created_by'         => $this->input->post('entry_by', TRUE),
                'from_date'          => $from_date,
                'to_date'            => $to_date
                );
            $production = $this->Production_m->production_details($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','Loose Oil','Product','Quantity','Production Date','Entry By');
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
            if(count($production)>0)
            {
                
                foreach($production as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['lo_name'].'</td>';                   
                    $data.='<td align="center">'.$row['p_name'].'</td>';                   
                    $data.='<td align="center">'.$row['quantity'].'</td>';
                    $data.='<td align="center">'.$row['production_date'].'</td>';
                    $data.='<td align="center">'.$row['user_name'].'</td>';                   
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
            $xlFile='Production'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }
    
}