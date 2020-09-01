<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';

class Dist_dd_r extends Base_controller {

	public function __construct()
	{
        parent::__construct();
		$this->load->model("Dist_dd_r_m");
	}
    /*dist_dd_r details
Author:gowri
Time: 3-21-17*/ 
    public function dist_dd_r()
    {           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="distributor D.D. Report";
        $data['nestedView']['pageTitle'] = 'distributor D.D. Report';
        $data['nestedView']['cur_page'] = 'dist_dd_r';
        $data['nestedView']['parent_page'] = 'dist_dd_r';
        $data['nestedView']['list_page'] = 'distributor_list';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'distributor D.D. Report', 'class' => 'active', 'url' => '');   
       
        # Additional data
        $data['bank'] = array(''=>'Select Bank')+$this->Common_model->get_dropdown('bank','bank_id','name');
        $data['pay_mode'] = array(''=>'Select Pay mode')+$this->Common_model->get_dropdown('payment_mode','pay_mode_id','name');
        $data['distributor'] = $this->Dist_dd_r_m->get_active_distributor();
        $data['plant_list'] = $this->Dist_dd_r_m->get_plant_list();
        $this->load->view('dist_dd_report/dist_dd_r_view',$data);
    }
    public function print_dist_datewise_dd_report()
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
                'distributor_id'       => $this->input->post('distributor_id', TRUE),
                'pay_mode_id'          => $this->input->post('pay_mode_id', TRUE),
                'bank_id'              => $this->input->post('bank_id', TRUE),
                'dd_number'            => $this->input->post('dd_number', TRUE),
                'status'               => $this->input->post('status', TRUE),
                'plant_id'             => $this->input->post('plant_id',TRUE)
                              );

            $dd_list = $this->Dist_dd_r_m->get_datewise_dd_list($searchParams);
            $data['dd_list'] = $dd_list;
            $data['search_params'] = $searchParams;
            $this->load->view('dist_dd_report/print_dist_datewise_dd_report',$data);

        }
        else
        {
            redirect(SITE_URL.'dist_dd_r'); exit();
        }
    }
    
    public function download_distributor_dd_payment()
    {
        if($this->input->post('download_dd_payment')!='') 
        {
            $from_date = $this->input->post('from_date',TRUE);
            if($from_date!=''){ $fromdate = date('Y-m-d',strtotime($from_date)); } else { $fromdate = " ";}

            $to_date = $this->input->post('to_date',TRUE);
            if($to_date!=''){ $todate = date('Y-m-d',strtotime($to_date)); } else { $todate = " ";}

            $searchParams=array(
                'from_date'            => $fromdate,
                'to_date'              => $todate,
                'distributor_id'       => $this->input->post('distributor_id', TRUE),
                'pay_mode_id'          => $this->input->post('pay_mode_id', TRUE),
                'bank_id'              => $this->input->post('bank_id', TRUE),
                'dd_number'            => $this->input->post('dd_number', TRUE),
                'status'               => $this->input->post('status', TRUE),
                'plant_id'             => $this->input->post('plant_id',TRUE)
                              );
                              
            $distributor = $this->Dist_dd_r_m->dist_dd_payment_download($searchParams);            
            $header = '';
            $data ='';
            $titles = array('S.No','dd number/date','distributor','unit','bank','amount');
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
            if(count($distributor)>0)
            {                
                foreach($distributor as $row)
                { $grand_total+= $row['amount'];
                	$amount = price_format($row['amount']);
                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.$row['dd_number'].'/'.date('d-m-Y',strtotime($row['payment_date'])).'</td>'; 
                    $data.='<td align="center">'.$row['distributor_name'].' ( '.$row['distributor_code'].' ) [ '.$row['distributor_place'].' ]'.'</td>';
                    $data.='<td align="center">'.$row['unit_name'].'</td>';
                    $data.='<td align="center">'.$row['bank_name'].'</td>';   
                    $data.='<td align="right">'.$amount.'</td>';
                    $data.='</tr>';
                    $j++;
                }
            }
            else
            {
                $data.='<tr><td colspan="'.(count($titles)).'" align="center">No Results Found</td></tr>';
            }
            	$grd_amount = price_format($grand_total);
            	 $data.='<tr>';
                    $data.='<td align="right" colspan="5">'."Grand Total".'</td>';
                    $data.='<td align="right" >'.$grd_amount.'</td>';
                 $data.='</tr>';
            
            $data.='</tbody>';
            $data.='</table>';
            $time = date("Ymdhis");
            $xlFile='dist_dd_payment'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
        }
    }
}