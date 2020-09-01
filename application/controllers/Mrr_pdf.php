<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';

class Mrr_pdf extends Base_Controller 
{
    function __construct()
    {
        parent::__construct();
        $this->load->model("Pm_mrr_m");
        $this->load->model("Loose_oil_mrr_m");
        $this->load->library('Pdf');
        $this->load->library('Numbertowords');
    }

    /*
      * Function   : MRR List Print for packing material
      * Developer  :  Prasad created on: 24th Feb 11 PM updated on:      
    */

 public function print_mrr_pm_list()
    {
        
        $mrr_pm_id=@cmm_decode($this->uri->segment(2));
        if($mrr_pm_id=='')
        {
            redirect(SITE_URL);
            exit;
        }
          
        $mrr_results = $this->Pm_mrr_m->print_mrr_pm_list_results($mrr_pm_id);
        $data['mrr_results']=$mrr_results;
        //retreving pending qty for that particular po
        $data['pm_received_qty']=$this->Pm_mrr_m->get_pm_received_qty($mrr_results['po_pm_id'],$mrr_results['pm_category_id']); 
        // retreving received qty for that particular mrr.
        $data['mrr_received_qty']=$this->Pm_mrr_m->get_mrr_received_qty($mrr_results['mrr_pm_id'],$mrr_results['pm_category_id']);
        if($mrr_results['pm_id']==get_tape_650mt() || $mrr_results['pm_id']==get_tape_65mt() ) 
            {
                $preference=$this->Common_model->get_data_row('preference',array('name'=>$mrr_results['pm_id']));
                $data['meters']=$preference['value'];
            } 
            else
            {
                $data['meters']=1;
            }
            //echo $data['meters'];exit;
         $this->load->view('mrr/print_pm_mrr',$data);
      
    }

    /*
      * Function   : MRR List Print for loose oil
      * Developer  :  Prasad created on: 24th Feb 11 PM updated on:      
    */

    public function print_mrr_list()
     {  
       
        $mrr_oil_id=@cmm_decode($this->uri->segment(2));
        if($mrr_oil_id=='')
        {
            redirect(SITE_URL);
            exit;
        }
        else
        {  
            $mrr_results= $this->Loose_oil_mrr_m->print_mrr_list_results($mrr_oil_id); 

            if($mrr_results['loose_oil_id']==gn_loose_oil_id())
            {
                $test_id= get_ffa_test_id();
                $ffa_value=$this->Loose_oil_mrr_m->get_ffa_value($test_id,$mrr_results['tanker_id']);
                
                $results=$this->Common_model->get_data('ffa_rebate',array('lower_limit <'=>$ffa_value));
               
                $total_rebate=0;

                foreach($results as $row)
                {
                    if($row['upper_limit'] <= $ffa_value)
                    {
                        $total_rebate+=($row['upper_limit']-$row['lower_limit'])*$row['multiplier'];
                    }
                    else
                    {
                        $total_rebate+=($row['upper_limit']-$ffa_value)*$row['multiplier'];
                        break;
                    }
                }

            $data['total_rebate']=$total_rebate;
            $data['ffa_value']=$ffa_value;
               
            }


        $data['mrr_results']=$mrr_results;
        $this->load->view('mrr/print_mrr',$data);
         
        }
     }
}