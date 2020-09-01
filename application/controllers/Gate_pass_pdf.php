<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';

class Gate_pass_pdf extends Base_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("Gate_pass_model");
        $this->load->library('Pdf');
        $this->load->library('Numbertowords');
        $this->load->model('Plant_gate_pass_model');
    }

    public function print_gate_pass_list()
    {
        $gatepass_id=@cmm_decode($this->uri->segment(2));
        if($gatepass_id=='')
        {
            redirect(SITE_URL);
            exit;
        }
        else
        {   
            $gatepass_results=array();
            $details=$this->Gate_pass_model->get_gate_pass_details($gatepass_id);
            $data['details']=$details;
            $gate_pass=$this->Gate_pass_model->get_gate_invoice_details($gatepass_id);
            foreach($gate_pass as $key=> $row )
            {
                $gatepass_results[$row['invoice_id']]['invoice']=$row['invoice_number'];
                $products=$this->Gate_pass_model->get_do_products_details($row['invoice_id']);
                $gatepass_results[$row['invoice_id']]['products']=$products;
            }
            //print_r($gatepass_results);exit;
            $data['gatepass_results']=$gatepass_results;
            $pdf_content=$this->load->view('gate_pass/print_gatepass_list',$data,true);  

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
            $pdf_name="MRR Loose Oil"."_".date('M-d-Y_h:i:s').".pdf";
            ob_end_clean();
            $pdf->Output($pdf_name, 'D');   

        }
    }
    public function print_plant_gate_pass_list()
    {
        $gatepass_id=@cmm_decode($this->uri->segment(2));
        if($gatepass_id=='')
        {
            redirect(SITE_URL);
            exit;
        }
        else
        {   
            $gatepass_results=array();
            $details=$this->Plant_gate_pass_model->get_plant_gate_pass_details($gatepass_id);
            $data['details']=$details;
            $gate_pass=$this->Plant_gate_pass_model->get_plant_gate_invoice_details($gatepass_id);
            foreach($gate_pass as $key=> $row )
            {
                $gatepass_results[$row['invoice_id']]['invoice']=$row['invoice_number'];
                $products=$this->Plant_gate_pass_model->get_plant_do_products_details($row['invoice_id']);
                $gatepass_results[$row['invoice_id']]['products']=$products;
            }
            //print_r($gatepass_results);exit;
            $data['gatepass_results']=$gatepass_results;
            $pdf_content=$this->load->view('plant_gate_pass/print_plant_gatepass',$data,true);  

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
            $pdf_name="Gatepass for Plant"."_".date('M-d-Y_h:i:s').".pdf";
            ob_end_clean();
            $pdf->Output($pdf_name, 'D');   

        }
    }
}