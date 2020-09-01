<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
// created by maruthi 15th Nov 2016 09:00 AM
class Tender_process extends Base_controller {
    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Tender_process_model");
        $this->load->model("Po_reports_model");
    }
    //Mounika
    public function tender_process()

    { 

        # Data Array to carry the require fields to View and Model

        $data['nestedView']['heading']="Add New MTP(Oil)";

        $data['nestedView']['pageTitle'] = 'Add New MTP (Oil)';

        $data['nestedView']['cur_page'] = 'mtp_oil';

        $data['nestedView']['parent_page'] = 'purchase_order';
        $data['nestedView']['list_page'] = 'tender';



        # Load JS and CSS Files

        $data['nestedView']['js_includes'] = array();

        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/tender.js"></script>';

        $data['nestedView']['css_includes'] = array();



        # Breadcrumbs

        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));

        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MTP (Oil)', 'class' => '', 'url' => SITE_URL . 'tender_process_details');

        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Add New MTP (Oil)', 'class' => 'active', 'url' => '');



        $data['mtp_oil_id'] = get_current_serial_number(array('value'=>'mtp_number','table'=>'mtp_oil','where'=>'created_time'));

        //echo $data['mtp_oil_id'];exit;

        $data['plant'] = $this->Tender_process_model->get_plant();

        $data['loose'] = $this->Tender_process_model->getloose_oil();

        

         

        $data['flag']=2;

        $this->load->view('tender_process/tender_process',$data);

    }

    public function get_repeat_order_details_oil()

    {

        $loose_oil_id=$this->input->post('loose_oil_id');
       // echo $loose_oil_id;exit;

        $result=$this->Tender_process_model->get_latest_po_details($loose_oil_id);

        echo json_encode($result);

    }





    public function insert_tender_process()

    {

        if($this->input->post('submit',TRUE))

        {

            $mtp_number = get_current_serial_number(array('value'=>'mtp_number','table'=>'mtp_oil','where'=>'created_time'));

            $tender_date=$this->input->post('tender_date');

            $newDate = date("Y-m-d", strtotime($tender_date));

           

            $data=array(

                'mtp_number'    =>   $mtp_number,

                'loose_oil_id'  =>   $this->input->post('loose_oil_name'),

                'plant_id'      =>   $this->input->post('plant_id'),

                'quantity'      =>   $this->input->post('quantity'),

                'tender_date'   =>   $newDate,

                'created_by'    =>   $this->session->userdata('user_id'),

                'created_time'  =>   date('Y-m-d H:i:s')

                        );



            // Begin Transaction

            $this->db->trans_begin();

            $this->Common_model->insert_data('mtp_oil',$data);

            

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

        redirect(SITE_URL.'tender_process_details'); 

    }



    public function tender_process_details()

    { 

        # Data Array to carry the require fields to View and Model

        $data['nestedView']['heading']="Material Tender Process (Oil)";

        $data['nestedView']['pageTitle'] = 'MTP (Oil)';

        $data['nestedView']['cur_page'] = 'mtp_oil';

        $data['nestedView']['parent_page'] = 'purchase_order';
        $data['nestedView']['list_page'] = 'tender';



        # Load JS and CSS Files

        $data['nestedView']['js_includes'] = array();

        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/tender.js"></script>';

        $data['nestedView']['css_includes'] = array();



        # Breadcrumbs

        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));

        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MTP (Oil)', 'class' => '', 'url' => '');

        

        # Search Functionality

        $psearch=$this->input->post('search_tender', TRUE);

        if($psearch!='') {

        $search_params=array(

                        'mtp_no'   =>   $this->input->post('mtp_no', TRUE),

                        'loose_oil_id' =>   $this->input->post('loose_oil_id',TRUE),

                        'plant_id'     =>   $this->input->post('plant_id')

                              );

        $this->session->set_userdata($search_params);

        } else {

            

            if($this->uri->segment(2)!='')

            {

            $search_params=array(

                        'mtp_no'   =>   $this->session->userdata('mtp_no'),

                        'loose_oil_id' =>   $this->session->userdata('loose_oil_id'),

                        'plant_id'     =>   $this->session->userdata('plant_id')

                              );

            }

            else {

                $search_params=array(

                        'mtp_no'   =>  '',

                        'loose_oil_id' =>  '',

                        'plant_id'     =>  ''

                                  );

                $this->session->set_userdata($search_params);

            }

            

        }

        $data['search_params'] = $search_params;

        

         # Default Records Per Page - always 10

        /* pagination start */

        $config = get_paginationConfig();

        $config['base_url'] = SITE_URL . 'tender_process_details/';

        # Total Records

        $config['total_rows'] = $this->Tender_process_model->tender_total_num_rows($search_params);



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

        $data['tender'] = $this->Tender_process_model->tender_results($search_params,$config['per_page'], $current_offset);

        # Additional data

        $data['display_results'] = 1;



        $data['plant'] = $this->Tender_process_model->get_plant();

        $data['loose'] = $this->Tender_process_model->getloose_oil();

        

        $data['flag']=1;

        $this->load->view('tender_process/tender_process',$data);

     }



    public function tender_details()

    { 

        $mtp_oil_id=cmm_decode($this->uri->segment(2));

        $data['mtp_oil_id'] = $mtp_oil_id;

        $data['tender_details']=$this->Tender_process_model->get_tender_details($mtp_oil_id);





        # Data Array to carry the require fields to View and Model

        $data['nestedView']['heading']="Manage Tenders For MTP (Oil)";

        $data['nestedView']['pageTitle'] = 'Manage Tenders';

        $data['nestedView']['cur_page'] = 'mtp_oil';

        $data['nestedView']['parent_page'] = 'purchase_order';
        $data['nestedView']['list_page'] = 'tender';



        # Load JS and CSS Files

        $data['nestedView']['js_includes'] = array();

        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'pages/scripts/tenders.js"></script>';

        $data['nestedView']['css_includes'] = array();



        # Breadcrumbs

        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));

        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MTP List for Loose Oil', 'class' => '', 'url' => SITE_URL . 'tender_process_details');

        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Tenders', 'class' => '', 'url' => '');



        //$data['supplier'] = $this->Tender_process_model->getsupplier();
        $data['supplier']= $this->Common_model->get_data('supplier',array('status'=>1,'type_id'=>1),'','CAST(supplier_code as unsigned)ASC');
        //$data['broker'] = $this->Tender_process_model->getbroker();
        $data['broker']= $this->Common_model->get_data('broker',array('status'=>1),'','CAST(broker_code as unsigned)ASC');


        $data['addtenders']= $this->Tender_process_model->get_add_tender($mtp_oil_id);

        

        //print_r($data['tender']);exit;         

        

        $data['flag']=3;

        $this->load->view('tender_process/tender_process',$data);

    }



    public function download_tender()

    {

        if($this->input->post('download_tender')!='')

        {

            $searchParams=array(  'mtp_no'   =>   $this->input->post('mtp_no', TRUE),

                                  'loose_oil_id' =>   $this->input->post('loose_oil_id',TRUE),

                                  'plant_id'     =>   $this->input->post('plant_id',TRUE));

            $tenders = $this->Tender_process_model->tender_details($searchParams);

            

            $header = '';

            $data ='';

            $titles = array('S.NO','MTP No','Loose Oil','Ops','Quantity','tender_date','Status');

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

            if(count($tenders)>0)

            {

                foreach($tenders as $row)

                {

                    $data.='<tr>';

                    $data.='<td align="center">'.$j.'</td>';

                    $data.='<td align="center">'.$row['mtp_number'].'</td>';

                    $data.='<td align="center">'.$row['loose_oil_name'].'</td>';

                    $data.='<td align="center">'.$row['plant_name'].'</td>';

                    $data.='<td align="center">'.$row['quantity'].'</td>';

                    $data.='<td align="center">'.$row['tender_date'].'</td>';

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

            $xlFile='MTP(Oil)'.$time.'.xls'; 

            header("Content-type: application/x-msdownload"); 

            # replace excelfile.xls with whatever you want the filename to default to

            header("Content-Disposition: attachment; filename=".$xlFile."");

            header("Pragma: no-cache");

            header("Expires: 0");

            echo $data;

            

        }

    }





    public function insert_add_tender()

    {

        if($this->input->post('submit'))

        {



            $mtp_oil_id=$this->input->post('mtp_oil_id');

            //echo $mtp_oil_id;exit;

            $broker_id=$this->input->post('broker_name');

            $supplier_id=$this->input->post('supplier_name');

            //print_r($broker_id);exit;

            $quoted_rate=$this->input->post('quoted_rate');

            $negotiated_rate=$this->input->post('negotiated_rate');

            $quantity=$this->input->post('quantity');

            //print_r($negotiated_rate);exit;

            $this->db->trans_begin();

            foreach ($broker_id as $key => $value) 

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

                



                $add_tender=array(

                                'mtp_oil_id'          =>   $mtp_oil_id,

                                'broker_id'           =>   $broker_id[$key],

                                'supplier_id'         =>   $supplier_id[$key],

                                'quoted_price'        =>   $quoted_rate[$key],

                                'negotiated_price'    =>   $negotiated_rate[$key],

                                'quantity'            =>   $quantity[$key],

                                'support_document'    =>   $support_document,

                                'created_by'          =>   1/*$this->session->userdata('user_id')*/,

                                'created_time'        =>   date('Y-m-d H:i:s')

                                    );

                // Begin Transaction

                if($broker_id[$key]!='' && $supplier_id[$key]!='' && $quoted_rate[$key]!='')

                {

                    $this->Common_model->insert_data('tender_oil',$add_tender);

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

        redirect(SITE_URL.'tender_process_details'); 

    }



     public function edit_tender()

    {

        $tender_oil_id=@cmm_decode($this->uri->segment(2));

        if($tender_oil_id=='')

        {

            redirect(SITE_URL);

            exit;

        }



        # Data Array to carry the require fields to View and Model

        $data['nestedView']['pageTitle'] = 'Edit Tender Details';

        $data['nestedView']['heading'] = "Edit Tender Details";

        $data['nestedView']['cur_page'] = 'mtp_oil';

        $data['nestedView']['parent_page'] = 'purchase_order';
        $data['nestedView']['list_page'] = 'tender';

        

        # Load JS and CSS Files

        $data['nestedView']['js_includes'] = array();

        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/product.js"></script>';

        $data['nestedView']['css_includes'] = array();

        

        # Breadcrumbs

        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));

        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'MTP (Oil)','class'=>'active','url'=>SITE_URL.'tender_details');

        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Edit Tender Details','class'=>'active','url'=>'');



        # Additional data

        $data['flag'] = 4;

        $data['form_action'] = SITE_URL.'update_tender';

        $data['display_results'] = 0;

        $data['supplier'] = $this->Tender_process_model->getsupplier();

        $data['broker']   = $this->Tender_process_model->getbroker();



        # Data

        $row= $this->Common_model->get_data('tender_oil',array('tender_oil_id'=>$tender_oil_id));

        $data['add_tenders']=$row[0];

        //print_r($data['add_tenders']);exit;

        

        $this->load->view('tender_process/tender_process',$data);

    }



    public function update_tender()

    {

        $tender_oil_id=$this->input->post('tender_oil_id',TRUE);

       // echo $tender_oil_id;exit;

        if($tender_oil_id=='')

        {

            redirect(SITE_URL.'tender_details');

            exit;

        }

        $mtp_oil_id = $this->Common_model->get_value('tender_oil',array('tender_oil_id'=>$tender_oil_id),'mtp_oil_id');

        // GETTING INPUT TEXT VALUES

        $mtp_oil_id=$this->input->post('mtp_oil_id');

        $broker_id=$this->input->post('broker_name');

        $supplier_id=$this->input->post('supplier_name');

        $quoted_rate=$this->input->post('quoted_rate');

        $negotiated_rate=$this->input->post('negotiated_rate');

        $quantity=$this->input->post('quantity');

        $key=1;

        $old_support = $this->Common_model->get_value('tender_oil',array('tender_oil_id'=>$tender_oil_id),'support_document');



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

                    'mtp_oil_id'          =>   $mtp_oil_id,

                    'broker_id'           =>   $broker_id,

                    'supplier_id'         =>   $supplier_id,

                    'quoted_price'        =>   $quoted_rate,

                    'negotiated_price'    =>   $negotiated_rate,

                    'quantity'            =>   $quantity,

                    'support_document'    =>   $support_document,                

                    'modified_by'         =>   $this->session->userdata('user_id'),

                    'modified_time'       =>   date('Y-m-d H:i:s')

                    ); 

        $where = array('tender_oil_id'=>$tender_oil_id);

        $tender_oil_id = $this->Common_model->update_data('tender_oil',$data,$where);



        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">

                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>

                                                    <strong>Success!</strong> Tender has been updated successfully! </div>');

        

        redirect(SITE_URL.'tender_details/'.cmm_encode($mtp_oil_id).'/'); 

    

    }



    public function deactivate_tender()

    {

        $tender_oil_id=@cmm_decode($this->uri->segment(2));

        $mtp_oil_id = @$this->uri->segment(3);

        $where = array('tender_oil_id' => $tender_oil_id);

        $dataArr = array('status' => 2);

        $this->Common_model->update_data('tender_oil',$dataArr, $where);

        

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">

                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>

                                <strong>Success!</strong> Tender has been De-Activated successfully!

                             </div>');



        redirect(SITE_URL.'tender_details/'.cmm_encode($mtp_oil_id).'/');

    }



    public function activate_tender()

    {

        $tender_oil_id=@cmm_decode($this->uri->segment(2));

        $mtp_oil_id = @$this->uri->segment(3);

        $where = array('tender_oil_id' => $tender_oil_id);

        $dataArr = array('status' => 1);

        $this->Common_model->update_data('tender_oil',$dataArr, $where);

        

        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">

                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>

                                <strong>Success!</strong> Tender has been De-Activated successfully!

                             </div>');



        redirect(SITE_URL.'tender_details/'.cmm_encode($mtp_oil_id).'/');

    }





    public function oil()

    {

        # Data Array to carry the require fields to View and Model

        $data['nestedView']['heading']="Purchase Order (Oil)";

        $data['nestedView']['pageTitle'] = 'Purchase Order (Oil)';

        $data['nestedView']['cur_page'] = 'loose_oil_po';

        $data['nestedView']['parent_page'] = 'purchase_order';



        # Load JS and CSS Files

        $data['nestedView']['js_includes'] = array();

        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/oil.js"></script>';

        $data['nestedView']['css_includes'] = array();



        # Breadcrumbs

        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Purchase Order (Oil)', 'class' => '', 'url' =>'');
        //$data['supplier'] = $this->Tender_process_model->getsupplier();
        $data['supplier']= $this->Common_model->get_data('supplier',array('status'=>1,'type_id'=>1),'','CAST(supplier_code as unsigned)ASC');
        //$data['broker']   = $this->Tender_process_model->getbroker();
        $data['broker']= $this->Common_model->get_data('broker',array('status'=>1),'','CAST(broker_code as unsigned)ASC');
        $data['loose'] = $this->Tender_process_model->getloose_oil();
        $data['type']  = $this->Tender_process_model->gettype();
        $data['plant'] = $this->Tender_process_model->get_plant();
        $data['repeat_order']= get_repeat_order_id();
        $data['po_number'] = get_current_serial_number(array('value'=>'po_number','table'=>'po_oil','where'=>'created_time'));
        $mtp_oil_id=cmm_decode($this->uri->segment(2));
        $data['mtp_oil_id']=$mtp_oil_id;





        if($mtp_oil_id !='')

        {

            $data['tender_details']=$this->Tender_process_model->get_tender_details($mtp_oil_id);

            $tenders= $this->Tender_process_model->get_tender( $mtp_oil_id);

            $data['tenders']=$tenders;

            

            if(count($data['tenders']) >0)

            {   

                 //retreving quantity for mtp oil

                $max_quantity=$this->Tender_process_model->get_mtp_oil_quantity($mtp_oil_id);

                 

                //fetching quantity for generated PO's belonging to mtp oil id

                $received_qty=$this->Tender_process_model->get_po_generated_quantity($mtp_oil_id);

                $total_quantity=$received_qty + $tenders['offered_qty'];

            

                 if($total_quantity >= $max_quantity)

                {

                    $data['req_quantity']= $max_quantity-$received_qty;

                }

                else

                {

                    $data['req_quantity']=$tenders['offered_qty'];

                }



                $data['flag']=1;

            }

            else

            {

                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">

                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>

                                                    <strong>Error!</strong> No Tenders for MTP. </div>'); 

                redirect(SITE_URL.'tender_process_details'); exit;

            }

        }

        else

        {

            $data['flag']=2;

        }



        $this->load->view('tender_process/oil',$data);

    }



      public function insert_po()

    {

        if($this->input->post('submit'))

        {

            $po_no = get_current_serial_number(array('value'=>'po_number','table'=>'po_oil','where'=>'created_time'));

            $data['mtp_oil_ids']=$this->input->post('mtp_oil_id');

            if($this->input->post('mtp_oil_id') !='')

            { 

                $po_oil_id=$this->input->post('po_oil_id');

                $tender_oil_id=$this->input->post('tender_oil_id');



                //echo $po_oil_id;exit;

                $po_number=$po_no;

                $po_date=$this->input->post('po_date');

                $loose_oil_id=$this->input->post('loose_oil_name');

                $unit_price=$this->input->post('price');

                $entered_quantity=$this->input->post('quantity');

                $po_type_id=get_ocb_id();

                $supplier_id=$this->input->post('supplier_name');

                $broker_id=$this->input->post('broker_name');

                $plant_id=$this->input->post('plant_id');

                $mtp_oil_id=$this->input->post('mtp_oil_id');

               

                //retreving quantity for mtp oil

                $max_quantity=$this->Tender_process_model->get_mtp_oil_quantity($mtp_oil_id);

                 

                //fetching quantity for generated PO's belonging to mtp oil id

                $received_qty=$this->Tender_process_model->get_po_generated_quantity($mtp_oil_id);

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

                            'loose_oil_id'         =>   $loose_oil_id,

                            'unit_price'           =>   $unit_price,

                            'quantity'             =>   $quantity,

                            'po_type_id'           =>   $po_type_id,

                            'supplier_id'          =>   $supplier_id,

                            'broker_id'            =>   $broker_id,

                            'plant_id'             =>   $plant_id,

                            'mtp_oil_id'           =>   $mtp_oil_id,

                            'created_by'           =>   1/*$this->session->userdata('user_id')*/,

                            'created_time'         =>   date('Y-m-d H:i:s')

                            );

                    // Begin Transaction

                    $this->db->trans_begin();

                    $po_oil_id=$this->Common_model->insert_data('po_oil',$po);

                    $po1=array(

                            'po_oil_id'            =>   $po_oil_id,

                            'unit_price'           =>   $unit_price,

                            'quantity'             =>   $quantity,

                            'supplier_id'          =>   $supplier_id,

                            'broker_id'            =>   $broker_id,

                            'created_by'           =>   1/*$this->session->userdata('user_id')*/,

                            'created_time'         =>   date('Y-m-d H:i:s')

                            );

                    $this->Common_model->insert_data('po_oil_history',$po1);

                    if($total_quantity >= $max_quantity)

                    {

                        $this->Common_model->update_data('mtp_oil',array('status'=>2),array('mtp_oil_id'=>$mtp_oil_id));

                    }

                    $this->Common_model->update_data('tender_oil',array('status'=>5),array('tender_oil_id'=>$tender_oil_id));

                    if ($this->db->trans_status() === FALSE)

                    {

                        $this->db->trans_rollback();

                       /* $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">

                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>

                                                            <strong>Error!</strong> Something went wrong. Please check. </div>');*/       

                    }

                    else

                    {

                        $this->db->trans_commit();

                       /* $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">

                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>

                                                            <strong>Success!</strong> Purchase Order has been added successfully! </div>');*/

                    }  

            }

            else

            {

                $po_number=$po_no;

                $po_date=$this->input->post('po_date');

                $loose_oil_id=$this->input->post('loose_oil_name');

                $unit_price=$this->input->post('rate');

                $quantity=$this->input->post('qty');

                $po_type_id=$this->input->post('po_type');

                $supplier_id=$this->input->post('supplier_name');

                $broker_id=$this->input->post('broker_name');

                $plant_id=$this->input->post('plant_id');

            

                $po=array(

                            'po_number'            =>   $po_number,

                            'po_date'              =>   $po_date,

                            'loose_oil_id'         =>   $loose_oil_id,

                            'unit_price'           =>   $unit_price,

                            'quantity'             =>   $quantity,

                            'po_type_id'           =>   $po_type_id,

                            'supplier_id'          =>   $supplier_id,

                            'broker_id'            =>   $broker_id,

                            'plant_id'             =>   $plant_id,

                            'mtp_oil_id'           =>   NULL,

                            'created_by'           =>   1/*$this->session->userdata('user_id')*/,

                            'created_time'         =>   date('Y-m-d H:i:s')

                                        );

                    // Begin Transaction

                    $this->db->trans_begin();

                    $po_oil_id=$this->Common_model->insert_data('po_oil',$po);

                

                    if ($this->db->trans_status() === FALSE)

                    {

                        $this->db->trans_rollback();

                       /* $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">

                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>

                                                            <strong>Error!</strong> Something went wrong. Please check. </div>'); */      

                    }

                    else

                    {

                        $this->db->trans_commit();

                        /*$this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">

                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>

                                                            <strong>Success!</strong> Purchase Order has been added successfully! </div>');*/

                    } 

                  //  redirect(SITE_URL.'oil');exit;

            } 

             $data['loose_oil_results'] = $this->Po_reports_model->print_loose_oil($po_oil_id); 
             $this->load->view('po_reports/print_loose_oil',$data);
        }

        //redirect(SITE_URL.'tender_process_details'); 

    }
    
    public function reject()

    { 

        # Data Array to carry the require fields to View and Model

        $data['nestedView']['heading']="Rejection for Material Tender Process (Loose Oil)";

        $data['nestedView']['pageTitle'] = 'Rejection for Material Tender Process (Loose Oil)';

        $data['nestedView']['cur_page'] = 'reject';

        $data['nestedView']['parent_page'] = 'reject';



        # Load JS and CSS Files

        $data['nestedView']['js_includes'] = array();

        $data['nestedView']['css_includes'] = array();



        # Breadcrumbs

        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));

        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Loose Oil Tender Process', 'class' => '', 'url' => SITE_URL . 'tender_process_details');

        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Rejection for Material Tender Process', 'class' => '', 'url' => '');

        

        $mtp_oil_id=cmm_decode($this->uri->segment(2));

        //echo $mtp_oil_id;

        $data['mtp_oil_id']=$mtp_oil_id;

        $data['tender_details']=$this->Tender_process_model->get_tender_details($mtp_oil_id);  

       

           

       $this->load->view('tender_process/reject',$data);

    }



    public function insert_remarks()

    { 

       

        //echo $mtp_oil_id;

        $data['mtp_oil_id']=$this->input->post('mtp_oil_id');

        $data['tender_details']=$this->Tender_process_model->get_tender_details($data['mtp_oil_id']);

           



       if($this->input->post('submit'))

        {

            $mtp_oil_id= $data['mtp_oil_id'];

            //echo $mtp_oil_id;exit;

            $remarks=$this->input->post('remarks');

            

            // Begin Transaction

            $this->db->trans_begin();

            $this->Common_model->update_data('mtp_oil',array('remarks1'=>$remarks,'status'=>3),array('mtp_oil_id'=>$mtp_oil_id));

           

        

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

             redirect(SITE_URL.'tender_process_details'); 

        }

    }
}