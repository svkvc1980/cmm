<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';

class Tally extends Base_controller {
	public function __construct()
    {

        parent::__construct();
        $this->load->model("Tally_model");

	}
	public function tally_report()
	{
		 # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Tally Report";
        $data['nestedView']['pageTitle'] = 'Tally Report';
        $data['nestedView']['cur_page'] = 'tally_report';
        $data['nestedView']['parent_page'] = 'tally_report';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Tally Report', 'class' => '', 'url' => '');
        $this->load->view('tally/tally_report',$data);
	}
	public function tally_report_print()
	{
		if($this->input->post('submit'))
		{
			 $from_date=date('Y-m-d', strtotime($this->input->post('start_date',TRUE)));
             $to_date=date('Y-m-d', strtotime($this->input->post('end_date',TRUE)));
             $tally_results=$this->Tally_model->get_invoice_tally_results($from_date,$to_date);
            // echo "<pre>"; print_r($tally_results);
            $header = '';
            $data ='';

            $total=0; $i=0;
            foreach ($tally_results as $key => $value) 
            {
            	if($value['type']==1)
	            {
	            	$code=$value['distributor_code'];
	            	$name=$value['agency_name'];
	            }
	            $total+=$value['amount'];
	           
               if($i>0)
                $data .= "\r\n";
				$data.=$value['invoice_number'].', ,'.format_date($value['invoice_date'],'d/m/Y').','.$value['loose_oil_code'].','.$value['product_code'].','.TrimTrailingZeroes($value['quantity']).','.TrimTrailingZeroes($value['qty_in_kg']).','.TrimTrailingZeroes($value['mt_in_kg']).','.TrimTrailingZeroes($value['no_of_pouches']).','.TrimTrailingZeroes($value['amount']).','.$code.','.'1'.','.$value['do_number'].','.format_date($value['do_date'],'d/m/Y').','.$value['tally_code'].','.$name;
	            //echo $data;
                $i++;
	          
            }// echo $total;exit;
           
            $time = date("Ymdhis");
            $xlFile='Tally Report'.$time.'.txt'; 
            header("Content-type:text/plain"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
		}
	}

}
