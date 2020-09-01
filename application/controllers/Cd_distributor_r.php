<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
 // created by Roopa 20th march 2017 02:00 PM

class Cd_distributor_r extends Base_controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Cd_distributor_r_m");
    }
    public function c_d_distributor_r()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle'] = 'Distributor Credit Debit Reports';
        $data['nestedView']['heading'] = "Distributor Credit Debit Reports";
        $data['nestedView']['cur_page'] = 'c_d_distributor_r';
        $data['nestedView']['parent_page'] = 'Distributor Credit Debit';
        $data['nestedView']['list_page'] = 'Distributor Credit Debit';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Distributor Credit Debit Reports','class'=>'active','url'=>'');

       $data['distributor'] =  $this->Cd_distributor_r_m->get_active_distributor();
       $this->load->view('credit_debit_reports/cd_distributor_r_view',$data);
    }

    public function print_dist_cd_report()
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
                'type_id'              => $this->input->post('type_id', TRUE)
                              );

            $dist_cd_list = $this->Cd_distributor_r_m->get_dist_cd_list($searchParams);
            $data['dist_cd_list'] = $dist_cd_list;
            $data['search_params'] = $searchParams;
            $this->load->view('credit_debit_reports/print_dist_cd_report',$data);
        }
        else
        {
            redirect(SITE_URL.'dist_dd_r'); exit();
        }
    }  
    public function download_dist_cd_report()
    {
        if($this->input->post('download_dist_cd_report')!='') {
            $from_date = $this->input->post('from_date',TRUE);
            if($from_date!=''){ $fromdate = date('Y-m-d',strtotime($from_date)); } else { $fromdate = " ";}

            $to_date = $this->input->post('to_date',TRUE);
            if($to_date!=''){ $todate = date('Y-m-d',strtotime($to_date)); } else { $todate = " ";}
            
             $searchParams=array(
                'from_date'            => $fromdate,
                'to_date'              => $todate,
                'distributor_id'       => $this->input->post('distributor_id', TRUE),
                'type_id'              => $this->input->post('type_id', TRUE)
                              );
            $distributor_reports = $this->Cd_distributor_r_m->dist_cd_download($searchParams);
            
            $header = '';
            $data ='';
            $titles = array('S.No','Date','Distributor','Purpose','Amount');
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
            if(count($distributor_reports)>0)
            {
                foreach($distributor_reports as $row)
                {
                    if($row['purpose_id']!='')
                    {
                        $purpose = $row['purpose'];
                    }
                    else
                    {
                        $purpose = $row['remarks'];
                    }

                    $data.='<tr>';
                    $data.='<td align="center">'.$j.'</td>';
                    $data.='<td align="center">'.date('d-m-Y',strtotime($row['on_date'])).'</td>'; 
                    $data.='<td align="center">'.$row['agency_name'].' ('.$row['distributor_code'].') ['.$row['distributor_place'].'].</td>';
                    $data.='<td align="center">'.$purpose.'</td>';
                    $data.='<td align="center">'.price_format($row['amount']).'</td>';
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
            $xlFile='dist_cd_list'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }
}