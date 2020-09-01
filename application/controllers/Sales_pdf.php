<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';

class Sales_pdf extends Base_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("Sales_model");
        $this->load->library('Pdf');
        $this->load->library('Numbertowords');
    }

    public function print_counter_sales()
    {
        $counter_sale_id=@cmm_decode($this->uri->segment(2));
        if($counter_sale_id=='')
        {
            redirect(SITE_URL);
            exit;
        }
        $data['sales_list'] = $this->Sales_model->view_sales_list($counter_sale_id);
        $pdf_content = $this->load->view('sales/print_counter_sales',$data,true);
        //print_r($pdf_content); exit;

        $pdf = new Pdf('P', 'px', 'A4', true, 'UTF-8', false);    
        # set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetFont('dejavusans', '', 9);
        
        $pdf->AddPage();
        $pdf->writeHTML($pdf_content, true, false, true, false, '0');
        $pdf_name="Sales"."_".date('M-d-Y_h:i:s').".pdf";
        ob_end_clean();
        $pdf->Output($pdf_name, 'D');
    }
}