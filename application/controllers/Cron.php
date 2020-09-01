<?php defined('BASEPATH') OR exit('No direct script access allowed');
// created by maruthi 25th Feb 2017 09:00 AM

class Cron extends CI_Controller {

	public function __construct() 
	{
    	parent::__construct();
        
        $this->load->model("Cron_m");
       //$this->load->model("Distributor_invoice_m");
	}
	public function dist_penalty()
	{

        // Check if cron runs for this day
        if($this->Cron_m->check_cron_already_runs('penalty_daily_cron',date('Y-m-d')))
        {
            exit;
        }
        // Insert cron data
        $cron_data = array(
                    'cron_type' => 'penalty_daily_cron',
                    'cron_time' => date('Y-m-d H:i:s'),
                    );
        $this->Common_model->insert_data('cron_history',$cron_data);
        $this->db->trans_begin();
        $pending_orders = $this->Cron_m->get_pending_obs();
        //echo '<pre>'; print_r($pending_orders);//exit;
        if(count($pending_orders)>0)
        { 
            foreach ($pending_orders as $results)
            {
                if(in_array($results['days'],penalties_array()))
                {
                    $ob_penalty_arr = get_penalty_price($results['days']);
                    $penalty_price = $ob_penalty_arr['penalty'];
                    $ob_penalty_id = $ob_penalty_arr['ob_penalty_id'];
                    //echo $penalty_price.$ob_penalty_id;exit;
                    $penalty_data = $this->Cron_m->caluculate_penalty($results['order_id']);
                    /*echo count($penalty_data);
                    echo '<pre>'; print_r($penalty_data);exit;*/

                    if(count($penalty_data)>0)
                    {
                        $total_penalty = 0;
                        foreach ($penalty_data as $key => $values)
                        {
                            $dist_arr = get_distribuutor_name_and_code($values['distributor_id']);
                            $dist_code = $dist_arr['distributor_code'];
                            $pen_data = array(
                                    'distributor_id'     => $values['distributor_id'],
                                    'distributor_code'   => $dist_code,
                                    'order_id'           => $values['order_id'],
                                    'product_id'         => $values['product_id'],
                                    'quantity'           => $values['pending_qty'],
                                    'weight'             => qty_format($values['weight']),
                                    'total_product_price'=> price_format($values['total_product_price']),
                                    'total_amount'       => price_format(($values['weight']*$penalty_price)),
                                    'penalty_day'        => $results['days'],
                                    'penalty_date'       => date('Y-m-d'),
                                    'created_time'       => date('Y-m-d H:i:s'),
                                    'penalty_price'      => $penalty_price,
                                    'ob_penalty_id'      => $ob_penalty_id
                                                );

                            //$inser[]= $insert_data;
                            //echo '<pre>'; print_r($pen_data);exit;
                            $this->Common_model->insert_data('dist_ob_penalty',$pen_data);
                            // updating status in order,order product
                            if($results['days'] == 31)
                            {
                                // update order product 
                                $op_data = array('status'=>10); $op_where = array('order_id'=>$values['order_id']);
                                $this->Common_model->update_data('order_product',$op_data,$op_where);
                                $this->Common_model->update_data('order',$op_data,$op_where);
                            }
                            $total_penalty += $pen_data['total_amount'];
                            /*echo $this->db->last_query();//exit;
                            echo $a;exit;*/
                        } 
                        // updating  in distributor and distributor transacrion
                        if($results['days']!=31)
                        {
                            $outstanding_amount = $this->Common_model->get_value('distributor',array('distributor_id'=>$pen_data['distributor_id']),'outstanding_amount');
                            // echo $total_penalty.'pp'.$outstanding_amount.'<br>';//exit;
                            $dist_trans_data = array(
                                    'distributor_id'     => $pen_data['distributor_id'],
                                    'trans_type_id'      => 3,
                                    'trans_amount'       => (-$total_penalty),
                                    'outstanding_amount' => $outstanding_amount,
                                    'trans_date'        => date('Y-m-d'),
                                    'created_time'       => date('Y-m-d H:i:s'),
                                    'remarks'            => 'penalty for '.$results['days']. 'days',
                                                );
                            $this->Common_model->insert_data('distributor_trans',$dist_trans_data);
                            // echo $this->db->last_query().'<br>';
                            // Update in Distributor table
                            $qry =' UPDATE distributor SET outstanding_amount = outstanding_amount - '.$total_penalty.' WHERE distributor_id ='.$pen_data['distributor_id'].'';
                            $this->db->query($qry);
                            //echo $this->db->last_query();//exit;  
                        }
                    }                    
                }
            }            
        } 
        if ($this->db->trans_status() === FALSE)
        {
           $this->db->trans_rollback();
           echo 'Failed';
           /*$this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                        <strong>Error!</strong> Something went wrong. Please check. </div>');*/       
        }
        else
        {
            $this->db->trans_commit(); 
            echo 'Success';               
            /*$this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Success!</strong> Penalties has been generated successfully with </div>');*/
        }       
    } 


    
}