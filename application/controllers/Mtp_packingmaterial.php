<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'Base_controller.php';

 // created by maruthi 15th Nov 2016 09:00 AM



class Mtp_packingmaterial extends Base_controller {



    public function __construct() 

    {

        parent::__construct();

        $this->load->model("Mtp_packingmaterial_model");
         $this->load->model("Po_reports_model");

    }



    //Mounika

    public function mtp_packingmaterial()

    { 

        # Data Array to carry the require fields to View and Model

        $data['nestedView']['heading']="MTP for Packing Material";

        $data['nestedView']['pageTitle'] = 'MTP for Packing Material';

        $data['nestedView']['cur_page'] = 'mtp_packingmaterial';
        $data['nestedView']['parent_page'] = 'purchase_order';
        $data['nestedView']['list_page'] = 'tender';




        # Load JS and CSS Files

        $data['nestedView']['js_includes'] = array();

       //$data['nestedView']['js_includes'][] = array();

        $data['nestedView']['css_includes'] = array();



        # Breadcrumbs

        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));

        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MTP for Packing Material', 'class' => 'active', 'url' => '');



         # Search Functionality

        $psearch=$this->input->post('search_packing_material', TRUE);

        if($psearch!='') {

        $search_params=array(

                        'mtp_number'   =>   $this->input->post('mtp_no', TRUE),

                        'pm_id'        =>   $this->input->post('packing_name',TRUE),

                        'plant_id'     =>   $this->input->post('plant_name')

                              );

        $this->session->set_userdata($search_params);

        } else {

            

            if($this->uri->segment(2)!='')

            {

            $search_params=array(

                        'mtp_number'   =>   $this->session->userdata('mtp_no'),

                        'pm_id'        =>   $this->session->userdata('packing_name'),

                        'plant_id'     =>   $this->session->userdata('plant_name')

                              );

            }

            else {

                $search_params=array(

                        'mtp_number'   =>  '',

                        'pm_id'        =>  '',

                        'plant_id'     =>  ''

                                  );

                $this->session->unset_userdata(array_keys($search_params));

            }

            

        }

        $data['search_params'] = $search_params;

        

         # Default Records Per Page - always 10

        /* pagination start */

        $config = get_paginationConfig();

        $config['base_url'] = SITE_URL . 'mtp_packingmaterial/';

        # Total Records

        $config['total_rows'] = $this->Mtp_packingmaterial_model->packing_material_total_num_rows($search_params);



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

        $data['mtp_packing'] = $this->Mtp_packingmaterial_model->packing_material_results($search_params,$config['per_page'], $current_offset);

        # Additional data

        //$data['display_results'] = 1;

        $data['mtp_pm_id'] = get_current_serial_number(array('value'=>'mtp_number','table'=>'mtp_pm','where'=>'created_time'));

       

        $data['plant'] = $this->Mtp_packingmaterial_model->get_plant();

        $data['packing'] = $this->Mtp_packingmaterial_model->getpacking_material();



        $data['flag']=1;

        $this->load->view('mtp_packingmaterial/mtp_packingmaterial',$data);

    }



    public function mtp_packingmaterial_add()

    { 

        $mtp_pm_id=cmm_decode($this->uri->segment(2));

        $data['mtp_pm_id'] = $mtp_pm_id;

        

        # Data Array to carry the require fields to View and Model

        $data['nestedView']['heading']="Manage Tenders";

        $data['nestedView']['pageTitle'] = 'Manage Tenders';
        $data['nestedView']['cur_page'] = 'mtp_packingmaterial';
        $data['nestedView']['parent_page'] = 'purchase_order';
        $data['nestedView']['list_page'] = 'tender';



        # Load JS and CSS Files

        $data['nestedView']['js_includes'] = array();

        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/mtp_packingmaterial_add.js"></script>';

        $data['nestedView']['css_includes'] = array();



        # Breadcrumbs

        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));

        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MTP List for Packing Material', 'class' => '', 'url' => SITE_URL . 'mtp_packingmaterial');

        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Tenders', 'class' => '', 'url' => '');



        $data['mtp_pm_id'] = get_current_serial_number(array('value'=>'mtp_number','table'=>'mtp_pm','where'=>'created_time'));



        $data['plant'] = $this->Mtp_packingmaterial_model->get_plant();

        $data['packing'] = $this->Mtp_packingmaterial_model->getpacking_material();     

        

        $data['flag']=2;

        $this->load->view('mtp_packingmaterial/mtp_packingmaterial',$data);

    }



     public function mtp_packingmaterial_insert()

    {

        if($this->input->post('submit',TRUE))

        {



            $mtp_number = get_current_serial_number(array('value'=>'mtp_number','table'=>'mtp_pm','where'=>'created_time'));

          

            $mtp_date=$this->input->post('mtp_date');

            $newDate = date("Y-m-d", strtotime($mtp_date));

           

            $data=array(

                'mtp_number'    =>   $mtp_number,

                'pm_id'         =>   $this->input->post('packing_name'),

                'plant_id'      =>   $this->input->post('plant_name'),

                'quantity'      =>   $this->input->post('quantity'),

                'mtp_date'      =>   $newDate,

                'created_by'    =>   1/*$this->session->userdata('user_id')*/,

                'created_time'  =>   date('Y-m-d H:i:s')

                        );



            // Begin Transaction

            $this->db->trans_begin();

            $this->Common_model->insert_data('mtp_pm',$data);

            

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

                                                    <strong>Success!</strong> Tender has been added successfully! </div>');

            }

        }

        redirect(SITE_URL.'mtp_packingmaterial'); 

    }



    public function add_tender_details()

    { 

        $mtp_pm_id=cmm_decode($this->uri->segment(2));

        $data['mtp_pm_id'] = $mtp_pm_id;

        $data['packing_material_insert_details']=$this->Mtp_packingmaterial_model->get_tender_details($mtp_pm_id);





        # Data Array to carry the require fields to View and Model

        $data['nestedView']['heading']="Add Tenders";

        $data['nestedView']['pageTitle'] = 'Add Tenders';
        $data['nestedView']['cur_page'] = 'mtp_packingmaterial';
        $data['nestedView']['parent_page'] = 'purchase_order';
        $data['nestedView']['list_page'] = 'tender';



        # Load JS and CSS Files

        $data['nestedView']['js_includes'] = array();

        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/mtp_packingmaterial.js"></script>';

        $data['nestedView']['css_includes'] = array();



        # Breadcrumbs

        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));

        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MTP List for Packing Material', 'class' => '', 'url' => SITE_URL . 'mtp_packingmaterial');

        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add Tenders', 'class' => '', 'url' => '');



        //$data['supplier'] = $this->Mtp_packingmaterial_model->getsupplier();
        $data['supplier']= $this->Common_model->get_data('supplier',array('status'=>1,'type_id'=>2),'','CAST(supplier_code as unsigned)ASC');
        
        $data['packing_material_addtender_details']= $this->Mtp_packingmaterial_model->get_add_tender($mtp_pm_id);

        $data['flag']=3;

        $this->load->view('mtp_packingmaterial/mtp_packingmaterial',$data);

    }



    public function insert_tender()

    {

        if($this->input->post('submit'))

        {

            $mtp_pm_id=$this->input->post('mtp_pm_id');

            $supplier_id=$this->input->post('supplier_name');

            $quoted_rate=$this->input->post('quoted_rate');

            $negotiated_rate=$this->input->post('negotiated_rate');

            $quantity=$this->input->post('quantity');
           

            $this->db->trans_begin();

            foreach ($supplier_id as $key => $value) 

            {

                

                if($_FILES['support_document_'.$key]['name']!='')

                {

                    $config['file_name'] = date('YmdHis').'-'.$key.'.'.get_file_extension($_FILES['support_document_'.$key]['name']);

                    $config['upload_path'] = get_tender_upload_path();

                    $config['allowed_types'] = 'gif|jpg|png|pdf|csv|doc|docx|txt';



                    $this->load->library('upload', $config);

                    $this->upload->initialize($config);

                    $this->upload->do_upload('support_document_'.$key);

                    $fileData = $this->upload->data();

                    $support_document = $config['file_name'];

                }

                else{

                    $support_document = '';

                }

                



                $insert_tender=array(

                                'mtp_pm_id'           =>   $mtp_pm_id,

                                'supplier_id'         =>   $supplier_id[$key],

                                'quoted_price'        =>   $quoted_rate[$key],

                                'negotiated_price'    =>   $negotiated_rate[$key],

                                'support_document'    =>   $support_document,

                                'quantity'            =>   $quantity[$key],

                                'created_by'          =>   1/*$this->session->userdata('user_id')*/,

                                'created_time'        =>   date('Y-m-d H:i:s')

                                    );

                // Begin Transaction

                if($supplier_id[$key]!='' && $quoted_rate[$key]!='')

                {

                    $this->Common_model->insert_data('tender_pm',$insert_tender);

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

                                                    <strong>Success!</strong> Tender has been added successfully! </div>');

            } 

        }

        redirect(SITE_URL.'mtp_packingmaterial'); 

    }



    public function edit_tender_details()

    {

        $tender_pm_id=@cmm_decode($this->uri->segment(2));

        if($tender_pm_id=='')

        {

            redirect(SITE_URL);

            exit;

        }



        # Data Array to carry the require fields to View and Model

        $data['nestedView']['pageTitle'] = 'Manage Tender';

        $data['nestedView']['heading'] = "Manage Tender";
        $data['nestedView']['cur_page'] = 'mtp_packingmaterial';
        $data['nestedView']['parent_page'] = 'purchase_order';
        $data['nestedView']['list_page'] = 'tender';

        

        # Load JS and CSS Files

        $data['nestedView']['js_includes'] = array();

        $data['nestedView']['js_includes'][] = array();

        $data['nestedView']['css_includes'] = array();

        

        # Breadcrumbs

        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));

        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Manage Tender','class'=>'active','url'=>SITE_URL.'add_tender_details');

        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Edit Tender Details','class'=>'active','url'=>'');



        # Additional data

        $data['flag'] = 4;

        $data['form_action'] = SITE_URL.'update_tender_details';

        $data['supplier']= $this->Common_model->get_data('supplier',array('status'=>1,'type_id'=>2),'','CAST(supplier_code as unsigned)ASC');

        # Data

        $row= $this->Common_model->get_data('tender_pm',array('tender_pm_id'=>$tender_pm_id));
      
        $data['get_add_tenders']=$row[0];

        //print_r($data['get_add_tenders']);exit;

        

        $this->load->view('mtp_packingmaterial/mtp_packingmaterial',$data);

    }



     public function update_tender_details()

    {

        $tender_pm_id=$this->input->post('tender_pm_id',TRUE);

       // echo $tender_oil_id;exit;

        if($tender_pm_id=='')

        {

            redirect(SITE_URL.'add_tender_details');

            exit;

        }

        $mtp_pm_id = $this->Common_model->get_value('tender_pm',array('tender_pm_id'=>$tender_pm_id),'mtp_pm_id');

        // GETTING INPUT TEXT VALUES

        $mtp_pm_id=$this->input->post('mtp_pm_id');

        $supplier_id=$this->input->post('supplier_name');

        $quoted_rate=$this->input->post('quoted_rate');

        $negotiated_rate=$this->input->post('negotiated_rate');

        $key=1;

        $old_support = $this->Common_model->get_value('tender_pm',array('tender_pm_id'=>$tender_pm_id),'support_document');



         if($_FILES['support_document_'.$key]['name']!='')

            {

                $config['file_name'] = date('YmdHis').'-'.$key.'.'.get_file_extension($_FILES['support_document_'.$key]['name']);

                $config['upload_path'] = get_tender_upload_path();

                $config['allowed_types'] = 'gif|jpg|png|pdf|csv|doc|docx|txt';



                $this->load->library('upload', $config);

                $this->upload->initialize($config);

                $this->upload->do_upload('support_document_'.$key);

                $fileData = $this->upload->data();

                $support_document = $config['file_name'];

            }

            else{

                $support_document = $old_support;

            }



        $data = array( 

                    'mtp_pm_id'           =>   $mtp_pm_id,

                    'supplier_id'         =>   $supplier_id,

                    'quoted_price'        =>   $quoted_rate,

                    'negotiated_price'    =>   $negotiated_rate,

                    'support_document'    =>   $support_document,                

                    'modified_by'         =>   1/* $this->session->userdata('user_id')*/,

                    'modified_time'       =>   date('Y-m-d H:i:s')

                    ); 

        $where = array('tender_pm_id'=>$tender_pm_id);

        $tender_pm_id = $this->Common_model->update_data('tender_pm',$data,$where);



        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">

                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>

                                                    <strong>Success!</strong> Tender has been updated successfully! </div>');

        

        redirect(SITE_URL.'add_tender_details/'.cmm_encode($mtp_pm_id).'/'); 

    

    }



      public function deactivate_tender_details()

    {

        $tender_pm_id=@cmm_decode($this->uri->segment(2));

        $mtp_pm_id = @$this->uri->segment(3);

        $where = array('tender_pm_id' => $tender_pm_id);

        $dataArr = array('status' => 2);

        $this->Common_model->update_data('tender_pm',$dataArr, $where);

        

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">

                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>

                                <strong>Success!</strong> Tender has been De-Activated successfully!

                             </div>');



        redirect(SITE_URL.'add_tender_details/'.cmm_encode($mtp_pm_id).'/');

    }



    public function activate_tender_details()

    {

        $tender_pm_id=@cmm_decode($this->uri->segment(2));

        $mtp_pm_id = @$this->uri->segment(3);

        $where = array('tender_pm_id' => $tender_pm_id);

        $dataArr = array('status' => 1);

        $this->Common_model->update_data('tender_pm',$dataArr, $where);

        

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">

                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>

                                <strong>Success!</strong> Tender has been De-Activated successfully!

                             </div>');



        redirect(SITE_URL.'add_tender_details/'.cmm_encode($mtp_pm_id).'/');

    }

    

     public function po_packing_material()

    {
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();

        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/po_packingmaterial.js"></script>';

        $data['nestedView']['css_includes'] = array();



        # Breadcrumbs

        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));

        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO for Packing Material', 'class' => 'active', 'url' =>'');

         

        $data['supplier']= $this->Common_model->get_data('supplier',array('status'=>1,'type_id'=>2),'','CAST(supplier_code as unsigned)ASC');
        
        $data['packing'] = $this->Mtp_packingmaterial_model->getpacking_material();

        $data['type']     = $this->Mtp_packingmaterial_model->gettype();

        $data['plant'] = $this->Mtp_packingmaterial_model->get_plant();



        //retreving  repeat order id from helper

        $data['repeat_order']=get_repeat_order_id();

        //print_r($data['repeat_order']);exit;

        $data['po_number'] = get_current_serial_number(array('value'=>'po_number','table'=>'po_pm','where'=>'created_time'));

       

        $mtp_pm_id=cmm_decode($this->uri->segment(2));

        $data['mtp_pm_id']=$mtp_pm_id;

        if($mtp_pm_id !='')

        {
            //echo $mtp_pm_id;exit;
            $data['packing_material_insert_details']=$this->Mtp_packingmaterial_model->get_tender_details($mtp_pm_id);

            $packing_material_tenders= $this->Mtp_packingmaterial_model->get_least_tender($mtp_pm_id);
            //print_r($packing_material_tenders);exit;
            $data['packing_material_tenders']=$packing_material_tenders;

            //print_r($data['packing_material_tenders']);exit;

            if(count($data['packing_material_tenders']) >0)

            {
                 //retreving quantity for mtp pm

                $max_quantity=$this->Mtp_packingmaterial_model->get_mtp_pm_quantity($mtp_pm_id);
                 
                //fetching quantity for generated PO's belonging to mtp pm id

                $received_qty=$this->Mtp_packingmaterial_model->get_po_generated_quantity($mtp_pm_id);

                $total_quantity=$received_qty + $packing_material_tenders['offered_qty'];
            
                 if($total_quantity >= $max_quantity)
                {

                    $data['req_quantity']= $max_quantity-$received_qty;

                }
                else
                {

                    $data['req_quantity']=$packing_material_tenders['offered_qty'];

                }
                $data['nestedView']['heading']="Purchase Order (Packing Material)";
                $data['nestedView']['pageTitle'] = 'PO for Packing Material';
                $data['nestedView']['cur_page'] = 'mtp_packingmaterial';
                $data['nestedView']['parent_page'] = 'purchase_order';
                $data['nestedView']['list_page'] = 'tender';

                $data['flag']=1;

            }

            else

            {

                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">

                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>

                                                    <strong>Error!</strong> No Tenders for MTP. </div>'); 

                redirect(SITE_URL.'mtp_packingmaterial'); exit;

            }

        }

        else

        {
        $data['nestedView']['heading']="Purchase Order (Packing Material)";
        $data['nestedView']['pageTitle'] = 'PO for Packing Material';
        $data['nestedView']['cur_page'] = 'po_purchase_order';
        $data['nestedView']['parent_page'] = 'purchase_order';

            $data['flag']=2;

        }
    $this->load->view('mtp_packingmaterial/po_packing_material',$data);

    }



    //getting repeat order latest values

    public function get_repeat_order_details()

    {

        $pm_id=$this->input->post('pm_id');

        $result=$this->Mtp_packingmaterial_model->get_latest_po_details($pm_id);

        echo json_encode($result);

    }



    public function po_packing_material_insert()

    {

        if($this->input->post('submit'))

        {

            $po_no= get_current_serial_number(array('value'=>'po_number','table'=>'po_pm','where'=>'created_time'));

           

            if($this->input->post('mtp_pm_id') !='')

            {

                $po_number=$po_no;

                $po_date=$this->input->post('po_date');

                $pm_id=$this->input->post('packing_name');

                $unit_price=$this->input->post('rate1');

                $entered_quantity=$this->input->post('quantity');

                $po_type_id=get_ocb_id();

                $supplier_id=$this->input->post('supplier_name');

                $plant_id=$this->input->post('plant_id');

                $mtp_pm_id=$this->input->post('mtp_pm_id');

                $tender_pm_id=$this->input->post('tender_pm_id');

                //retreving quantity for mtp oil

                $max_quantity=$this->Mtp_packingmaterial_model->get_mtp_pm_quantity($mtp_pm_id);
                 
                //fetching quantity for generated PO's belonging to mtp oil id

                $received_qty=$this->Mtp_packingmaterial_model->get_po_generated_quantity($mtp_pm_id);

                $total_quantity=$entered_quantity+$received_qty;

                if($total_quantity >= $max_quantity)

                {

                    $quantity= $max_quantity-$received_qty;

                }

                else

                {

                    $quantity=$entered_quantity;
                }

                $po=array(

                            'po_number'            =>   $po_number,

                            'po_date'              =>   $po_date,

                            'pm_id'                =>   $pm_id,

                            'unit_price'           =>   $unit_price,

                            'quantity'             =>   $quantity,

                            'po_type_id'           =>   $po_type_id,

                            'supplier_id'          =>   $supplier_id,

                           'plant_id'             =>   $plant_id,

                            'mtp_pm_id'            =>   $mtp_pm_id,

                            'created_by'           =>   1/*$this->session->userdata('user_id')*/,

                            'created_time'         =>   date('Y-m-d H:i:s')

                            );

                    // Begin Transaction

                    $this->db->trans_begin();

                    $po_pm_id=$this->Common_model->insert_data('po_pm',$po);

                    $po1=array(

                            'po_pm_id'             =>   $po_pm_id,

                            'unit_price'           =>   $unit_price,

                            'quantity'             =>   $quantity,

                            'supplier_id'          =>   $supplier_id,
                           
                            'created_by'           =>   1/*$this->session->userdata('user_id')*/,

                            'created_time'         =>   date('Y-m-d H:i:s')

                            );
                    

                    $this->Common_model->insert_data('po_pm_history',$po1);
                    
                    if($po['pm_id']==get_tape_650mt() || $po['pm_id']==get_tape_65mt() ) 
		        {
		            $preference=$this->Common_model->get_data_row('preference',array('name'=>$po['pm_id']));
		            $data['meters']=$preference['value'];
		        } 
		        else
		        {
		            $data['meters']=1;
		        }

                     if($total_quantity >= $max_quantity)
                    
                     {   

                        $this->Common_model->update_data('mtp_pm',array('status'=>2),array('mtp_pm_id'=>$mtp_pm_id));

                    }

                    $this->Common_model->update_data('tender_pm',array('status'=>5),array('tender_pm_id'=>$tender_pm_id));

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
                         $data['pm_results'] = $this->Po_reports_model->print_pm($po_pm_id); 
            		$this->load->view('po_reports/print_pm',$data);

                        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">

                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>

                                                            <strong>Success!</strong> Purchase Order has been added successfully! </div>');

                    }  

            }

            else

            {

                $po_number=$po_no;

                $po_date=$this->input->post('po_date');

                $pm_id=$this->input->post('packing_name');

                $unit_price=$this->input->post('rate');

                $quantity=$this->input->post('qty');

                $po_type_id=$this->input->post('po_type');

                $supplier_id=$this->input->post('supplier_name');

                $plant_id=$this->input->post('plant_id');

                

                $po=array(

                            'po_number'            =>   $po_number,

                            'po_date'              =>   $po_date,

                            'pm_id'                =>   $pm_id,

                            'unit_price'           =>   $unit_price,

                            'quantity'             =>   $quantity,

                            'po_type_id'           =>   $po_type_id,

                            'supplier_id'          =>   $supplier_id,

                            'plant_id'             =>   $plant_id,

                            'mtp_pm_id'            =>   NULL,

                            'created_by'           =>   1/*$this->session->userdata('user_id')*/,

                            'created_time'         =>   date('Y-m-d H:i:s')

                                        );

                    // Begin Transaction

                    $this->db->trans_begin();

                    $po_pm_id = $this->Common_model->insert_data('po_pm',$po);

                	if($po['pm_id']==get_tape_650mt() || $po['pm_id']==get_tape_65mt() ) 
		        {
		            $preference=$this->Common_model->get_data_row('preference',array('name'=>$po['pm_id']));
		            $data['meters']=$preference['value'];
		        } 
		        else
		        {
		            $data['meters']=1;
		        }

                    if ($this->db->trans_status() === FALSE)

                    {

                        $this->db->trans_rollback();

                      /*  $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">

                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>

                                                            <strong>Error!</strong> Something went wrong. Please check. </div>');      */ 

                    }

                    else

                    {

                        $this->db->trans_commit(); 
                        $data['pm_results'] = $this->Po_reports_model->print_pm($po_pm_id); 
            		$this->load->view('po_reports/print_pm',$data);
                	

                    }

                    //redirect(SITE_URL.'pm_report');  

            } 
           

            

        }

       // redirect(SITE_URL.'mtp_packingmaterial'); 

    }



    public function reject_packingmaterial()

    { 

        # Data Array to carry the require fields to View and Model

        $data['nestedView']['heading']="Rejection for Material Tender Process (Packing Material)";

        $data['nestedView']['pageTitle'] = 'Rejection for Material Tender Process (Packing Material)';

        $data['nestedView']['cur_page'] = 'reject';

        $data['nestedView']['parent_page'] = 'reject';



        # Load JS and CSS Files

        $data['nestedView']['js_includes'] = array();

        $data['nestedView']['css_includes'] = array();



        # Breadcrumbs

        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));

        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Packing Material Tender Process', 'class' => '', 'url' => SITE_URL . 'mtp_packingmaterial');

        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Rejection for Material Tender Process', 'class' => '', 'url' => '');

        

        $mtp_pm_id=cmm_decode($this->uri->segment(2));

        $data['mtp_pm_id']=$mtp_pm_id;

        $data['packing_material_insert_details']=$this->Mtp_packingmaterial_model->get_tender_details($mtp_pm_id); 

       

           

       $this->load->view('mtp_packingmaterial/reject_packingmaterial',$data);

    }



    public function reject_packingmaterial_remarks()

    { 

        $data['mtp_pm_id']=$this->input->post('mtp_pm_id');

        $data['packing_material_insert_details']=$this->Mtp_packingmaterial_model->get_tender_details($mtp_pm_id);

           



       if($this->input->post('submit'))

        {

            $mtp_pm_id= $data['mtp_pm_id'];

            $remarks=$this->input->post('remarks');

            

            // Begin Transaction

            $this->db->trans_begin();

            $this->Common_model->update_data('mtp_pm',array('remarks1'=>$remarks,'status'=>3),array('mtp_pm_id'=>$mtp_pm_id));

           

        

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

                                                    <strong>Success!</strong> Remarks has been added successfully! </div>');

            }  

             redirect(SITE_URL.'mtp_packingmaterial'); 

        }

    }



    public function download_packing_material()

    {

        if($this->input->post('download_packing_material')!='')

        {

            $searchParams=array(  'mtp_number'   =>   $this->input->post('mtp_no', TRUE),

                                  'pm_id'        =>   $this->input->post('packing_name',TRUE),

                                  'plant_id'     =>   $this->input->post('plant_name',TRUE)

                                  );

            $pm_tenders = $this->Mtp_packingmaterial_model->packing_material_details($searchParams);

            

            $header = '';

            $data ='';

            $titles = array('S.NO','MTP No','Packing Material','Ops','Quantity','Mtp Date','Status');

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

            if(count($pm_tenders)>0)

            {

                foreach($pm_tenders as $row)

                {

                    $data.='<tr>';

                    $data.='<td align="center">'.$j.'</td>';

                    $data.='<td align="center">'.$row['mtp_number'].'</td>';

                    $data.='<td align="center">'.$row['packing_name'].'</td>';

                    $data.='<td align="center">'.$row['plant_name'].'</td>';

                    $data.='<td align="center">'.$row['quantity'].'</td>';

                    $data.='<td align="center">'.$row['mtp_date'].'</td>';

                    $data.='<td align="center">'.$row['status'].'</td>';            

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

            $xlFile='Packing Material Tender'.$time.'.xls'; 

            header("Content-type: application/x-msdownload"); 

            # replace excelfile.xls with whatever you want the filename to default to

            header("Content-Disposition: attachment; filename=".$xlFile."");

            header("Pragma: no-cache");

            header("Expires: 0");

            echo $data;

            

        }

    }
}