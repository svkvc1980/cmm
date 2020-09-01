<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

/*
Rollback Lab Tests
auther: Mastan
created on: 10th APR 2017 3.24pm
*/

class Rollback_lab_test extends Base_controller {

	public function __construct() 
	{
    	parent::__construct();
        #$this->load->model("Rollback_lab_test_m");
        $this->load->model("Oil_lab_test_m");
        $this->load->model("Packing_material_test_m");
	}

	public function rollback_oil_test()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Oil Quality Test";
		$data['nestedView']['pageTitle'] = 'Oil Quality Test';
        $data['nestedView']['cur_page'] = 'rollback_oil_test';
        $data['nestedView']['parent_page'] = 'rollback';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Oil Quality Test', 'class' => 'active', 'url' => '');
        $data['flag'] = 1;
        $this->load->view('rollback_lab_tests/rollback_oil_test', $data);
	}

	public function get_oil_test_result()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Oil Quality Test";
		$data['nestedView']['pageTitle'] = 'Oil Quality Test';
        $data['nestedView']['cur_page'] = 'rollback_oil_test';
        $data['nestedView']['parent_page'] = 'rollback';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Oil Quality Test', 'class' => 'active', 'url' => '');
		

		$test_number = $this->input->post('test_number');
		$lab_test_id = $this->Oil_lab_test_m->get_lab_test_id($test_number);
        $test_results=array();
        $result = $this->Oil_lab_test_m->get_test_results($lab_test_id);
        
        foreach($result as $results)
        {   
            if($results['range_type_id'] == 2 || $results['range_type_id'] == 3)
            {
                //get test options
                $test_options = $this->Common_model->get_data('test_option',array('test_id'=>$results['test_id'],'status'=>1));
                $results['options'] = $test_options;
                if(array_key_exists(@$keys, $test_results)) 
                {
                    $test_results[$results['test_group_id']]['tests'][$results['test_id']]=$results;
                } 
                else
                {
                    $test_results[$results['test_group_id']]['test_group']=$results['test_group'];
                    $test_results[$results['test_group_id']]['tests'][$results['test_id']]=$results;
                }
            }
            else
            {
                if(array_key_exists(@$keys, $test_results)) 
                {
                    $test_results[$results['test_group_id']]['tests'][$results['test_id']]=$results;
                } 
                else
                {
                    $test_results[$results['test_group_id']]['test_group']=$results['test_group'];
                    $test_results[$results['test_group_id']]['tests'][$results['test_id']]=$results;
                }   
            }
        }
        if(count($test_results)>0)
        {
            
            $data['test_results']=$test_results;
            $data['flag'] = 2;
            
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Invalid Test Number. Please check. </div>');
            redirect(SITE_URL.'rollback_oil_test');
        }
        
        $this->load->view('rollback_lab_tests/rollback_oil_test', $data);
		
	}

	public function update_oil_test_status()
	{
		$test_number = $this->input->post('test_number');
		$remarks=$this->input->post('remarks');
        $lab_test_id=$this->input->post('lab_test_id');
       
        $name="PO Oil Lab Test  Has been passed FOR Test Number ".$test_number."";
         $po_oil_details = $this->Common_model->get_data('po_oil_lab_test_results',array('lab_test_id'=>$lab_test_id,'status'=>2));
      
        foreach($po_oil_details as $row)
        { 
            if($row['status']==1)
            {
                $status='Pass';
            }
            else
            {
                $status= 'Fail';
            }
            $d[]=array(
                'lab_test_id'=>$row['lab_test_id'],
                'test_id'    =>$row['test_id'],
                'value'      =>$row['value'],
                'status'     =>$status
                );
        }
        $failed_results=json_encode($d);
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('po_oil_lab_test_pass','lab_test');
        if($issue_at=='')
        {
            $issue_at = $pref['issue_raised_by'];
        }

        $issue_closed_by = $pref['issue_closed_by'];
        if($issue_closed_by == $issued_by)
        {
            $status = 2;
            $issue_at = $issued_by;
        }
        else
        {
            $status = 1;
        }

        $approval_data = array('rep_preference_id' => $pref['rep_preference_id'],
                               'approval_number'   => $approval_number,
                               'primary_key'       => $lab_test_id,
                               'old_value'         => $failed_results,
                               'new_value'         => 1,
                               'issue_at'          => $issue_at,
                               'name'              => $name,
                               'status'            => $status,
                               'created_by'        => $this->session->userdata('user_id'),
                               'created_time'      => date('Y-m-d H:i:s'));
      $this->db->trans_begin();
        $approval_id = $this->Common_model->insert_data('approval_list',$approval_data);
        $approval_history_data = array('approval_id'       =>     $approval_id,
                                       'issued_by'         =>     $issued_by,
                                       'remarks'           =>     $remarks,
                                       'created_by'        =>     $this->session->userdata('user_id'),
                                       'created_time'      =>     date('Y-m-d H:i:s'));
        $this->Common_model->insert_data('approval_list_history',$approval_history_data);
      //  echo $this->db->last_query();exit;
        if($issue_closed_by == $issued_by)
        {
            update_single_column_rollback($approval_id,$name,$remarks);
        }
     
        if ($this->db->trans_status()===FALSE)
        {
            $this->db->rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Error!</strong> Something went wrong. Please check. </div>'); 
        }
        else
        {
            $this->db->trans_commit();
            //exit;
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Success!</strong> PO Oil Lab Test Has successfully Passed for Lab Test Number '.$test_number.' </div>');
        }
        redirect(SITE_URL.'rollback_oil_test');
           
	}

	public function rollback_pm_test()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Packing Material Quality Test";
		$data['nestedView']['pageTitle'] = 'Packing Material Quality Test';
        $data['nestedView']['cur_page'] = 'rollback_pm_test';
        $data['nestedView']['parent_page'] = 'rollback';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Packing Material Quality Test', 'class' => 'active', 'url' => '');
        $data['flag'] = 1;
        $this->load->view('rollback_lab_tests/rollback_pm_test', $data);
	}

	public function get_pm_test_result()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Packing Material Quality Test";
		$data['nestedView']['pageTitle'] = 'Packing Material Quality Test';
        $data['nestedView']['cur_page'] = 'rollback_pm_test';
        $data['nestedView']['parent_page'] = 'rollback';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Packing Material Quality Test', 'class' => 'active', 'url' => '');
		
		$test_number = $this->input->post('test_number');
		$lab_test_id = $this->Packing_material_test_m->get_pm_lab_test_id($test_number);
        	$test_results=array();
            $result = $this->Packing_material_test_m->get_pm_test_results($lab_test_id);
           // print_r($result);exit;
            foreach($result as $results)
            {   
                if($results['range_type_id'] == 2 || $results['range_type_id'] == 3)
                {
                    //get test options
                    $test_options = $this->Common_model->get_data('pm_test_option',array('pm_test_id'=>$results['pm_test_id'],'status'=>1));
                    $results['options'] = $test_options;
                    if(array_key_exists(@$keys, $test_results))
                    {
                        $test_results[$results['test_id']] = $results;
                    } 
                    else
                    {
                        $test_results[$results['test_id']] = $results;
                    }
                }
                else
                {
                    if(array_key_exists(@$keys, $test_results)) 
                    {
                        $test_results[$results['test_id']] = $results;
                    } 
                    else
                    {
                        $test_results[$results['test_id']] = $results;
                    }
                }
            }
        if(count($test_results)>0)
        {
            
            $data['test_results']=$test_results;
            $data['flag'] = 2;
            
        }
        else
        {
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Invalid Test Number. Please check. </div>');
            redirect(SITE_URL.'rollback_pm_test');
        }
            # print_r($test_results);exit;
            
		$this->load->view('rollback_lab_tests/rollback_pm_test', $data);
	}

	public function update_pm_test_status()
	{
       $test_number = $this->input->post('test_number');
        $remarks=$this->input->post('remarks');
        $lab_test_id=$this->input->post('lab_test_id');
       
        $name="PO PM Lab Test  Has been passed FOR Test Number ".$test_number."";
         $po_pm_details = $this->Common_model->get_data('po_pm_lab_test_results',array('lab_test_id'=>$lab_test_id,'status'=>2));
      
        foreach($po_pm_details as $row)
        { 
            if($row['status']==1)
            {
                $status='Pass';
            }
            else
            {
                $status= 'Fail';
            }
            $d[]=array(
                'lab_test_id'=>$row['lab_test_id'],
                'test_id'    =>$row['pm_test_id'],
                'value'      =>$row['value'],
                'status'     =>$status
                );
        }
        $failed_results=json_encode($d);
        $approval_number = get_approval_number();
        $issued_by = $this->session->userdata('block_designation_id');
        $issue_at = $this->Common_model->get_value('designation_reporting',array('reportee_id'=>$issued_by),'reporting_id');
        $pref = get_reporting_preference('po_pm_lab_test_pass','lab_test');
        if($issue_at=='')
        {
            $issue_at = $pref['issue_raised_by'];
        }

        $issue_closed_by = $pref['issue_closed_by'];
        if($issue_closed_by == $issued_by)
        {
            $status = 2;
            $issue_at = $issued_by;
        }
        else
        {
            $status = 1;
        }

        $approval_data = array('rep_preference_id' => $pref['rep_preference_id'],
                               'approval_number'   => $approval_number,
                               'primary_key'       => $lab_test_id,
                               'old_value'         => $failed_results,
                               'new_value'         => 1,
                               'issue_at'          => $issue_at,
                               'name'              => $name,
                               'status'            => $status,
                               'created_by'        => $this->session->userdata('user_id'),
                               'created_time'      => date('Y-m-d H:i:s'));
      $this->db->trans_begin();
        $approval_id = $this->Common_model->insert_data('approval_list',$approval_data);
        $approval_history_data = array('approval_id'       =>     $approval_id,
                                       'issued_by'         =>     $issued_by,
                                       'remarks'           =>     $remarks,
                                       'created_by'        =>     $this->session->userdata('user_id'),
                                       'created_time'      =>     date('Y-m-d H:i:s'));
        $this->Common_model->insert_data('approval_list_history',$approval_history_data);
      //  echo $this->db->last_query();exit;
        if($issue_closed_by == $issued_by)
        {
            update_single_column_rollback($approval_id,$name,$remarks);
        }
     
        if ($this->db->trans_status()===FALSE)
        {
            $this->db->rollback();
            $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Error!</strong> Something went wrong. Please check. </div>'); 
        }
        else
        {
            $this->db->trans_commit();
            //exit;
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <strong>Success!</strong> PO Packing Material Lab Test Has successfully Passed for Lab Test Number '.$test_number.' </div>');
        }
        redirect(SITE_URL.'rollback_pm_test');
	}
}
