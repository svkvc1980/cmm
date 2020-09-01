 <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';

class c_and_f_payments_R extends Base_controller{

	public function __construct()
	{
        parent::__construct();
		$this->load->model('C_and_f_R_m');
    }

    public function c_and_f_payments_R()
    {           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="C&F DD Payments";
        $data['nestedView']['pageTitle'] = 'C&F DD Payments';
        $data['nestedView']['cur_page'] = 'c_and_f_payments_R';
		$data['nestedView']['parent_page'] = 'reports';
		$data['nestedView']['list_page'] = 'payment_reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'C&F DD Payments', 'class' => 'active', 'url' => '');     
     
        # Additional data
        $data['bank'] = array(''=>'Select Bank')+$this->Common_model->get_dropdown('bank','bank_id','name');
        $data['pay_mode'] = array(''=>'Select Pay mode')+$this->Common_model->get_dropdown('payment_mode','pay_mode_id','name');
        $data['plant'] = $this->C_and_f_R_m->get_plant_details();
        $data['display_results'] = 1;
        $this->load->view('c_and_f_payment_report/c_and_f_payments_R',$data);
        
    }

    public function print_c_and_f_dd_payment_list()
    {
        $submit = $this->input->post('submit',TRUE);
        if($submit!='')
        {
            $from_date = $this->input->post('from_date',TRUE);
            if($from_date!=''){ $fromdate = date('Y-m-d',strtotime($from_date)); } else { $fromdate = " ";}

            $to_date = $this->input->post('to_date',TRUE);
            if($to_date!=''){ $todate = date('Y-m-d',strtotime($to_date)); } else { $todate = " ";}

            $searchParams=array(
                'from_date'            => $fromdate,
                'to_date'              => $todate,
                'plant_id'             => $this->input->post('plant_id', TRUE),
                'pay_mode_id'          => $this->input->post('pay_mode_id', TRUE),
                'bank_id'              => $this->input->post('bank_id', TRUE),
                'dd_number'            => $this->input->post('dd_number', TRUE),
                'status'               => $this->input->post('status', TRUE)
                              );

            $dd_list = $this->C_and_f_R_m->get_c_and_f_dd_list($searchParams);
            $data['dd_list'] = $dd_list;
            $data['search_params'] = $searchParams;
            $this->load->view('c_and_f_payment_report/print_c_and_f_payment_list',$data);

        }
        else
        {
            redirect(SITE_URL.'c_and_f_payments_R'); exit();
        }

    }


    public function download_c_and_f_payments_R()
    { 
        if($this->input->post('download_c_and_f_payments_R')!='') 
        {
             $from_date = $this->input->post('from_date',TRUE);
            if($from_date!=''){ $fromdate = date('Y-m-d',strtotime($from_date)); } else { $fromdate = " ";}

            $to_date = $this->input->post('to_date',TRUE);
            if($to_date!=''){ $todate = date('Y-m-d',strtotime($to_date)); } else { $todate = " ";}
            $searchParams=array(
                'from_date'            => $fromdate,
                'to_date'              => $todate,
                'plant_id'             => $this->input->post('plant_id', TRUE),
                'pay_mode_id'          => $this->input->post('pay_mode_id', TRUE),
                'bank_id'              => $this->input->post('bank_id', TRUE),
                'dd_number'            => $this->input->post('dd_number', TRUE),
                'status'               => $this->input->post('status', TRUE)
                              );
            $c_and_f_payment = $this->C_and_f_R_m->c_and_f_payment_details($searchParams);            
            $header = '';
            $data ='';
            $titles = array('S.No','dd No/ Date','C and F','Bank Name','Amount');
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
             $j=1; $grand_total = 0;
            if(count($c_and_f_payment)>0)
            {                
                foreach($c_and_f_payment as $row)
                {
                    $grand_total+= $row['amount'];
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['dd_number'].'/'.date('d-m-Y',strtotime($row['payment_date'])).'</td>';
                    $data.='<td align="center">'.$row['plant_name'].'</td>'; 
                    $data.='<td align="center">'.$row['bank_name'].'</td>'; 
                    $data.='<td align="right">'.$row['amount'].'</td>';              
                    $data.='</tr>';
                    $j++;
                }
            }
            else
            {
                $data.='<tr><td colspan="'.(count($titles)+1).'" align="center">No Results Found</td></tr>';
            }
            $data.='<tr>';
                    $data.='<td align="right" colspan="4">'."Grand Total".'</td>';
                    $data.='<td align="right" >'.$grand_total.'</td>';
                 $data.='</tr>';
            $data.='</tbody>';
            $data.='</table>';
            $time = date("Ymdhis");
            $xlFile='c_and_f_payment'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
        }
    }
}