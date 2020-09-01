<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

class Freegift_po extends Base_controller {
	public function __construct() 
    {
        parent::__construct();
        $this->load->model("Common_model");
        $this->load->model("Freegift_po_m");
    }
/*Freegift PO List details
Author:Srilekha
Time: 12.46PM 15-02-2017 */
    public function freegift_po_list()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="PO Free Gifts Reports";
        $data['nestedView']['pageTitle'] = 'PO Free Gifts Reports';
        $data['nestedView']['cur_page'] = 'po_free_gift_r';
        $data['nestedView']['parent_page'] = 'purchase_order';
        $data['nestedView']['list_page'] = 'po_reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'PO Free Gifts Reports', 'class' => '', 'url' => '');   

        # Search Functionality
        $p_search=$this->input->post('search_freegift', TRUE);
        if($this->input->post('po_date',TRUE)!='')
        {
            $in_time=date('Y-m-d', strtotime($this->input->post('po_date',TRUE)));  
        }
        else
        {
            $in_time = '';
        }
        
        if($p_search!='') 
        {
            $search_params=array(
                'po_number'         => $this->input->post('po_number', TRUE),
                'freegift_id'       => $this->input->post('freegift_id', TRUE),
                'po_date'           => $in_time
            
                                );
            $this->session->set_userdata($search_params);
        } 
        else 
        {
            
            if($this->uri->segment(2)!='')
            {
                $search_params=array(
                    'po_number'     => $this->session->userdata('po_number'),
                    'freegift_id'   => $this->session->userdata('freegift_id'),
                    'po_date'       => $this->session->userdata('po_date')
                                    );
            }
            else {
                $search_params=array(
                      'po_number'       => '',
                      'freegift_id'     => '',
                      'po_date'         => ''
                                 );
                $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_data'] = $search_params;
        


        # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'freegift_po_list/';
        # Total Records
        $config['total_rows'] = $this->Freegift_po_m->freegift_po_total_num_rows($search_params);

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
        $data['freegift_results'] = $this->Freegift_po_m->freegift_po_results($current_offset, $config['per_page'], $search_params);
        $data['freegift'] = $this->Common_model->get_data('free_gift',array('status'=>1));
        # Additional data
        $data['display_results'] = 1;

        $this->load->view('freegift/freegift_po_view',$data);

    }
/*Freegift PO details
Author:Srilekha
Time: 12.46PM 15-02-2017 */
	public function freegift_po()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Purchase Order (Free gifts)";
        $data['nestedView']['pageTitle'] = 'PO for Free gifts';
        $data['nestedView']['cur_page'] = 'po_free_gift';
        $data['nestedView']['parent_page'] = 'purchase_order';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/freegift_po.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Purchase Order (Free Gifts)', 'class' => 'active', 'url' =>'');
        

        $data['flag']=1;
        $data['supplier']=$this->Common_model->get_data('supplier', array('status'=>1,'type_id'=>3));
        $data['freegift']=$this->Common_model->get_data('free_gift', array('status'=>1));
        $data['po_number']=get_current_serial_number(array('value'=>'po_number','table'=>'po_free_gift','where'=>'created_time'));
		$data['form_action'] = SITE_URL.'insert_po_freegift';
        
        $this->load->view('freegift/freegift_po_view',$data);
	}
/*Inserting Freegift PO details
Author:Srilekha
Time: 03.15PM 15-02-2017 */
	public function insert_po_freegift()
	{
		$po_num = get_current_serial_number(array('value'=>'po_number','table'=>'po_free_gift','where'=>'created_time'));
		$data=array(

					'free_gift_id'	=>	$this->input->post('freegift_type'),
					'supplier_id'	=>	$this->input->post('supplier'),
					'po_number'		=>	$po_num,
					'po_date'		=>	$this->input->post('po_date'),
					'unit_price'	=>	$this->input->post('rate'),
					'quantity'		=>	$this->input->post('quantity'),
					'created_by'	=>	$this->session->userdata('user_id'),
					'created_time'	=>	date('Y-m-d H:i:s')
				   );
        $this->db->trans_begin();
		$po_freegift = $this->Common_model->insert_data('po_free_gift',$data);
        $data=array(
                    'po_fg_id'      =>  $po_freegift,
                    'unit_price'    =>  $this->input->post('rate'),
                    'quantity'      =>  $this->input->post('quantity'),
                    'supplier_id'   =>  $this->input->post('supplier'),
                    'created_by'    =>  $this->session->userdata('user_id'),
                    'created_time'  =>  date('Y-m-d H:i:s')
                   );

        $po_history=$this->Common_model->insert_data('po_fg_history',$data);
		if($this->db->trans_status() === FALSE)
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
          <strong>Success!</strong> PO Has Generated successfully! </div>');*/
			
		}
		
        $data['free_gift_results'] = $this->Freegift_po_m->print_free_gift($po_freegift); 
        $this->load->view('freegift/print_free_gift',$data);

	}
/*Download Freegift PO
Author:Srilekha
Time: 4.09PM 21-01-2017 */
    public function download_po_freegift()
    {
        if($this->input->post('download_freegift')!='') {
            
           $search_params=array(
                'po_number'         => $this->input->post('po_number', TRUE),
                'freegift_id'       => $this->input->post('freegift_id', TRUE),
                'po_date'           => $this->input->post('po_date', TRUE)
            
                                );    
            $freegift = $this->Freegift_po_m->freegift_po_details($search_params);
            
            $header = '';
            $data ='';
            $titles = array('S.NO','PO Number','Freegift Name','Supplier','Quantity','Rate');
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
            if(count($freegift)>0)
            {
                
                foreach($freegift as $row)
                {
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['po_number'].'</td>';                   
                    $data.='<td align="center">'.$row['freegift_name'].'</td>';
                    $data.='<td align="center">'.$row['supplier_name'].'</td>';
                    $data.='<td align="center">'.$row['quantity'].'</td>';
                    $data.='<td align="center">'.$row['unit_price'].'</td>';                   
                    
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
            $xlFile='Freegift_po'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }

    //Mounika
    public function print_free_gift()
    {
        
        $po_fg_id=@cmm_decode($this->uri->segment(2));
        if($po_fg_id=='')
        {
            redirect(SITE_URL);
            exit;
        }
          
        $data['free_gift_results'] = $this->Freegift_po_m->print_free_gift($po_fg_id); 
        //print_r($data['free_gift_results']);exit;
        /*$pdf_content = $this->load->view('freegift/print_free_gift',$data,true);
        //print_r($pdf_content); exit();

        $pdf = new Pdf('P', 'px', 'A4', true, 'UTF-8', false);    
        # set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetFont('dejavusans', '', 10);
        
        $pdf->AddPage();
        $pdf->writeHTML($pdf_content, true, false, true, false, '0');
        $pdf_name="PO Loose Oil"."_".date('M-d-Y_h:i:s').".pdf";
        ob_end_clean();
        $pdf->Output($pdf_name, 'D');*/
        $data['free_gift_id']=2;
        $this->load->view('freegift/print_free_gift',$data);
    }

    public function print_free_gift_report()
    {
        if($this->input->post('free_gift_report')!='') 
        {

            $search_params=array(
                'po_number'         => $this->input->post('po_number', TRUE),
                'free_gift_id'       => $this->input->post('freegift_id', TRUE),
                'po_date'           => $this->input->post('po_date', TRUE)
            
                                );  
            $free_gift_results = $this->Freegift_po_m->print_free_gift_report(@$search_params);
            $data['free_gift_results']=$free_gift_results;
            $data['search_params'] = $search_params;
            
        }
        $this->load->view('freegift/print_free_gift_report',$data);
    }

}