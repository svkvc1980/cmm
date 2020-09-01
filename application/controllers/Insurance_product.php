<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';

class Insurance_product extends CI_Controller {

	public function __construct() 
	{
    	parent::__construct();
        $this->load->model("Insurance_product_m");
         $this->load->model("Distributor_invoice_m");
         $this->load->model("Sales_model");
	}

	public function Insurance_product()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']=" Distributor Insurance Product";
		$data['nestedView']['pageTitle'] = 'Distributor Insurance Product';
        $data['nestedView']['cur_page'] = 'insurance_product';
        $data['nestedView']['parent_page'] = 'insurance';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Insurance Product', 'class' => '', 'url' => '');	

        $data['flag'] = 1;
        $this->load->view('insurance/insurance_product', $data);
	}
	public function plant_insurance_product()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Unit Insurance Product";
		$data['nestedView']['pageTitle'] = 'Unit Insurance Product';
        $data['nestedView']['cur_page'] = 'insurance_product';
        $data['nestedView']['parent_page'] = 'insurance';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Insurance Product', 'class' => '', 'url' => '');	

        $data['flag'] = 3;
        $this->load->view('insurance/insurance_product', $data);
	}

	public function submit_insurance_product()
	{
		$data['nestedView']['heading']="Distributor Insurance Product";
		$data['nestedView']['pageTitle'] = 'Distributor Insurance Product';
        $data['nestedView']['cur_page'] = 'insurance_product';
        $data['nestedView']['parent_page'] = 'insurance';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/insurance_product.js" type="text/javascript"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Insurance Product', 'class' => '', 'url' => '');

        $plant_id = $this->session->userdata('ses_plant_id');
        if($this->input->post('submit')!='')
        { 
        	$invoice_no = $this->input->post('invoice_no');
	        $data['invoice_no'] = $invoice_no;
	        //checking whether invoice id belongs to plant or distributor
	        $type=$this->Insurance_product_m->get_invoice_type($invoice_no);
	        $data['type']=$type;
	        if($type['invoice_type']==1)
	        {
	        	$invoice_id = $this->Insurance_product_m->get_latest_invoice_number($invoice_no);
	        	$data['inv_products']=$this->Insurance_product_m->get_distributor_invoice_details($invoice_no);
	        	  $inv_dos= $this->Distributor_invoice_m->get_invoice_dos($invoice_id);
				$inv_obs= $this->Distributor_invoice_m->get_invoice_obs($invoice_id);
				       // echo '<pre>'; print_r($inv_dos);exit;
				$d=array();       
		        foreach ($inv_dos as $value) {
		          $d[]=$value['do_number'];
		          $do_date[] =date('d-m-Y',strtotime($value['do_date']));
		        }        
		        $data['inv_dos'] =implode(',',$d);
		        $data['inv_do_dates'] =implode(',',$do_date);

		        foreach ($inv_obs as $value) {
		          $ob[]=$value['order_number'];
		          $ob_date[] =date('d-m-Y',strtotime($value['order_date']));
		        }

		        $data['inv_obs'] =implode(',',$ob);
		        $data['inv_ob_dates'] =implode(',',$ob_date);
	        	//print_r($data['inv_products']);exit;
	        	
	        }
	       /* elseif($type['invoice_type']==2)
	        {
	        	$invoice_id=$this->Insurance_product_m->get_plant_invoice_number($invoice_no);
	        	$data['inv_products']=$this->Insurance_product_m->get_plant_invoice_details($invoice_no);
	        }*/
	      
	        if($invoice_id != 0)
	        {
	        	$insurance_count = $this->Common_model->get_value('insurance',array('invoice_id'=>$invoice_id),'insurance_id');
	        	if($insurance_count!='')
	        	{
	        		$this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Insurance is already claimed for Invoice No.:<strong> '.$invoice_no.'</strong> </div>'); 
	        		redirect(SITE_URL .'insurance_product'); exit();

	        	}
	        	$data['invoice_product'] = $this->Insurance_product_m->get_invoice_product_details($invoice_id);
	        	$data['products'] = $this->Insurance_product_m->get_invoice_products($invoice_id);
	        }
	        else
	        {
	        	$this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Invoice number not found. Please check. </div>'); 
	        redirect(SITE_URL .'insurance_product');
	        }
	        $data['invoice_id'] = $invoice_id;
	        $products = $data['products'];
	        $data['count']=count($products);
	        $data['flag'] = 2;
        }
        else
        {
        	redirect(SITE_URL .'insurance_product');
        }
        
        $this->load->view('insurance/insurance_product', $data);
	}

	public function submit_insurance_product_plant()
	{
		$data['nestedView']['heading']="Unit Insurance Product";
		$data['nestedView']['pageTitle'] = 'Unit Insurance Product';
        $data['nestedView']['cur_page'] = 'insurance_product';
        $data['nestedView']['parent_page'] = 'insurance';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script src="'.assets_url().'pages/scripts/insurance_product.js" type="text/javascript"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Insurance Product', 'class' => '', 'url' => '');

        $plant_id = $this->session->userdata('ses_plant_id');
        if($this->input->post('submit')!='')
        { 
        	$invoice_no = $this->input->post('invoice_no');
	        $data['invoice_no'] = $invoice_no;
	        //checking whether invoice id belongs to plant or distributor
	        $type=$this->Insurance_product_m->get_invoice_type_plant($invoice_no);
	        $data['type']=$type;
            if($type['invoice_type']==2)
	        {
	        $invoice_id=$this->Insurance_product_m->get_plant_invoice_number($invoice_no);
        	$data['inv_products']=$this->Insurance_product_m->get_plant_invoice_details($invoice_no);
	       
	        $inv_dos= $this->Distributor_invoice_m->get_invoice_dos($invoice_id);
				$inv_obs= $this->Distributor_invoice_m->get_invoice_obs($invoice_id);
				       // echo '<pre>'; print_r($inv_dos);exit;
				        
		        foreach ($inv_dos as $value) {
		          $d[]=$value['do_number'];
		          $do_date[] =date('d-m-Y',strtotime($value['do_date']));
		        }        
		        $data['inv_dos'] =implode(',',$d);
		        $data['inv_do_dates'] =implode(',',$do_date);

		        foreach ($inv_obs as $value) {
		          $ob[]=$value['order_number'];
		          $ob_date[] =date('d-m-Y',strtotime($value['order_date']));
		        }

		        $data['inv_obs'] =implode(',',$ob);
		        $data['inv_ob_dates'] =implode(',',$ob_date);
	        	//print_r($data['inv_products']);exit;
		    }
	        if($invoice_id != 0)
	        {
	        	$insurance_count = $this->Common_model->get_value('insurance',array('invoice_id'=>$invoice_id),'insurance_id');
	        	if($insurance_count!='')
	        	{
	        		$this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Insurance is already claimed for Invoice No.:<strong> '.$invoice_no.'</strong> </div>'); 
	        		redirect(SITE_URL .'plant_insurance_product'); exit();

	        	}
	        	$data['invoice_product'] = $this->Insurance_product_m->get_invoice_product_details($invoice_id);
	        	$data['products'] = $this->Insurance_product_m->get_invoice_products($invoice_id);
	        }
	        else
	        {
	        	$this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Invoice number not found. Please check. </div>'); 
	        redirect(SITE_URL .'plant_insurance_product');
	        }
	        $data['invoice_id'] = $invoice_id;
	        $products = $data['products'];
	        $data['count']=count($products);
	        $data['flag'] = 2;
        }
        else
        {
        	redirect(SITE_URL .'plant_insurance_product');
        }
        
        $this->load->view('insurance/insurance_product', $data);
	}

	public function get_oil_weight()
	{
		$product_id = $this->input->post('product');
		echo json_encode($this->Insurance_product_m->get_oil_weight_by_product_id($product_id));
	}

	//getting product price based on recovered oil weight
	public function get_product_price()
	{
		$product_id = $this->input->post('product');
		$invoice_id = $this->input->post('invoice_id');
		$result=$this->Insurance_product_m->get_product_price($product_id, $invoice_id);
		echo json_encode($result);
	}

	public function insert_insurance_product()
	{   //exit;
		if($this->input->post('submit'))
		{  // echo 'hi'.$this->input->post('invoice_id'); exit;
			if($this->input->post('invoice_id')!='' && $this->input->post('invoice_id')!=0)
			{
				$invoice_id = $this->input->post('invoice_id');
				$lr_no = $this->input->post('lr_no');
				$product_id = $this->input->post('product_id', TRUE);
				$leaked_pouches = $this->input->post('leaked_pouches');
				$recovered_oil = $this->input->post('recovered_oil');
				$net_loss = $this->input->post('net_loss');
				$net_loss_amount = $this->input->post('net_loss_amount');
				$invoice_do_product_id=$this->input->post('invoice_do_product_id');
				//print_r($invoice_do_product_id);exit;
				$this->db->trans_begin();
				$dat = array(
					'invoice_id' 	=> $invoice_id,
					'received_date' => date('Y-m-d'),
					'lr_number'     => $lr_no,
					'status'        => 1,
					'created_by'	=> $this->session->userdata('user_id'),
					'created_time'	=> date('Y-m-d H:i:s')
					);
				$insurance_id = $this->Common_model->insert_data('insurance', $dat);
                
				foreach($product_id as $i =>$value)
				{
					$dat1 = array(
						'insurance_id'  	=> $insurance_id,
						'product_id'		=> $value,
						'leaked_pouches'	=> $leaked_pouches[$i],
						'recovered_oil'		=> $recovered_oil[$i],
						'net_loss'			=> $net_loss[$i],
						'net_loss_amount'	=> $net_loss_amount[$i],
						'invoice_do_product_id'=>$invoice_do_product_id[$i]
						);
						//print_r($dat1);exit;
					$this->Common_model->insert_data('insurance_product', $dat1);
						
				}

				if($this->db->trans_status()===FALSE)
	            {
	                $this->db->rollback();
	                $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
	                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
	                                <strong>Error!</strong> Something went wrong. Please check. </div>'); 
	            }
	            else
	            {
	                $this->db->trans_commit();
	                $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
	                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
	                                <strong>Success!</strong> Insurance generated successfully </div>');
	            }

			}
			else
			{
				$this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
	                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
	                                <strong>Error!</strong> Something went wrong. Please check. </div>');
				redirect(SITE_URL.'insurance_product'); exit();
			}
			
		}
		redirect(SITE_URL.'insurance_product');
	}

	public function insurance_report()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Insurance Report";
		$data['nestedView']['pageTitle'] = 'Insurance Report';
        $data['nestedView']['cur_page'] = 'reports';
        $data['nestedView']['parent_page'] = 'insurance';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Insurance Report', 'class' => '', 'url' => '');	
        $data['distributor_list'] = $this->Insurance_product_m->get_active_distributor_list();
        $this->load->view('insurance/insurance_report', $data);
	}

	public function insurance_report_detail()
	{
		$invoice_no = $this->input->post('invoice_no');
		$distributor_id = $this->input->post('distributor_id');
		$from = $this->input->post('from_date');
		if($from!='')
		{
			$from_date = date('Y-m-d', strtotime($from));
		}
		else
		{
			$from_date = '';
		}
		$to = $this->input->post('to_date');
		if($to!='')
		{
			$to_date = date('Y-m-d', strtotime($to));
		}
		else
		{
			$to_date = '';
		}
		
        $data['from_date'] = $from_date; 
        $data['to_date'] = $to_date;
		$insurance_report= $this->Insurance_product_m->insurance_report($distributor_id,$invoice_no, $from_date, $to_date);
		$stock_result = array();
    	foreach ($insurance_report as $key => $value) 
    	{
    		$stock_result[$value['insurance_id']]['invoice_number']=$value['invoice_number'];
    		$stock_result[$value['insurance_id']]['invoice_date']=$value['invoice_date'];
    		$stock_result[$value['insurance_id']]['distributor']=$value['agency_name'];
    		$stock_result[$value['insurance_id']]['plant_name']=$value['plant_name'];
            $results=$this->Insurance_product_m->get_insurance_product_result($value['insurance_id']);
            $stock_result[$value['insurance_id']]['insurance_results']=$results;
    	}
    	//echo "<pre>"; 
    	//print_r($stock_result); exit();
    	//$this->Insurance_product_m->get_detailed_invoice_results($distributor_id,$invoice_no, $from_date, $to_date);
    	$data['insurance_result'] = $stock_result;
		$this->load->view('insurance/insurance_report_detail', $data);
	}
	public function individual_insurance_invoice()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Insurance Report Distributor";
		$data['nestedView']['pageTitle'] = 'Distributor Insurance Report';
        $data['nestedView']['cur_page'] = 'reports';
        $data['nestedView']['parent_page'] = 'insurance';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Insurance Report', 'class' => '', 'url' => '');	
        $this->load->view('insurance/individual_insurance_report', $data);
	}

	public function individual_insurance_invoice_plant()
	{
		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Unit Insurance Report";
		$data['nestedView']['pageTitle'] = 'Unit Insurance Report';
        $data['nestedView']['cur_page'] = 'reports';
        $data['nestedView']['parent_page'] = 'insurance';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Insurance Report', 'class' => '', 'url' => '');	
        $this->load->view('insurance/plant_individual_insurance_report', $data);
	}
	public function individual_insurance_invoice_report()
	{
		if($this->input->post('submit'))
		{
   			$invoice_no=$this->input->post('invoice_no');
            $invoice_count=$this->Insurance_product_m->check_invoice_number($invoice_no);
           //echo $invoice_count;exit;
            if($invoice_count >0)
            {   
            	$invoice_results=$this->Insurance_product_m->check_invoice_number_distributor($invoice_no);
	   			$count=$invoice_results[0];
	   			if($count >0)
	   			{   

	   				$results=$invoice_results[1];
	   				$data['results']=$results;
	   				$distributor_id='';
	   				$to_date='';
	   				$from_date='';
	   				$data['insurance_report']= $this->Insurance_product_m->insurance_report($distributor_id,$invoice_no, $from_date, $to_date);
	   				$data['invoice_products']=$this->Insurance_product_m->get_insurance_invoice_products($invoice_no);
	   				$data['product_results']=$this->Insurance_product_m->get_invoice_insurance_product_result($results['invoice_id']);
	   				$this->load->view('insurance/individual_invoice_insurance_report',$data);
	   			}
	   			else
	   			{
	   				 $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Sorry ,Invoice Number belongs to unit. </div>');   
                     redirect(SITE_URL.'individual_insurance_invoice');
	   			}
	   		}
	   		else
	   		{
	   			 $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong>Incorrect Invoice Number OR Insurance is not generated for '.$invoice_no.'. </div>');   
                 redirect(SITE_URL.'individual_insurance_invoice');     
            }

       
		}

	}
	public function plant_individual_insurance_invoice_report()
	{
		if($this->input->post('submit'))
		{
   			$invoice_no=$this->input->post('invoice_no');
            $invoice_count=$this->Insurance_product_m->check_invoice_number($invoice_no);
           //echo $invoice_count;exit;
            if($invoice_count >0)
            {   
            	$invoice_results=$this->Insurance_product_m->check_invoice_number_plant($invoice_no);
	   			$count=$invoice_results[0];
	   			if($count >0)
	   			{   

	   				$results=$invoice_results[1];
	   				$data['results']=$results;
	   				$data['insurance_report']= $this->Insurance_product_m->plant_insurance_report($invoice_no);
	   				$data['invoice_products']=$this->Insurance_product_m->get_plant_insurance_invoice_products($invoice_no);
	   				$data['product_results']=$this->Insurance_product_m->get_invoice_insurance_product_result($results['invoice_id']);
	   				$this->load->view('insurance/individual_invoice_insurance_report_plant',$data);
	   			}
	   			else
	   			{
	   				 $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong> Sorry ,Invoice Number belongs to Ditributor. </div>');   
                     redirect(SITE_URL.'individual_insurance_invoice_plant');
	   			}
	   		}
	   		else
	   		{
	   			 $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                    <strong>Error!</strong>Incorrect Invoice Number OR Insurance is not generated for '.$invoice_no.'. </div>');   
                 redirect(SITE_URL.'individual_insurance_invoice_plant');     
            }

       
		}
	}

	public function consolidated_insurance_sales()
	{

		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Insurance Report";
		$data['nestedView']['pageTitle'] = 'Insurance Report';
        $data['nestedView']['cur_page'] = 'reports';
        $data['nestedView']['parent_page'] = 'insurance';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Insurance Report', 'class' => '', 'url' => '');	
        $data['distributor_list'] = $this->Insurance_product_m->get_active_distributor_list();
       // $data['loose_oils'] = $this->Insurance_product_m->get_oils();
        $data['units'] = $this->Insurance_product_m->get_units();
        $this->load->view('insurance/consolidated_insurance_sales',$data);
	}

	public function print_consolidated_insurance_sales()
	{
		if($this->input->post('submit'))
		{   
			if($this->input->post('from_date')!='')
			{
				$from_date=date('Y-m-d',strtotime($this->input->post('from_date')));
		    }
		    else
		    {
		    	$from_date='';
		    }
		    if($this->input->post('to_date') !='')
		    {
		    	$to_date=date('Y-m-d',strtotime($this->input->post('to_date')));
		    }
		    else
		    {
		    	$to_date='';
		    }
		    $data['from_date']=$from_date;
		    $data['to_date']=$to_date;
		    $plant_id=$this->input->post('plant_id');
		    $distributor_id=$this->input->post('distributor_id');

		    $products=array();
		    //get insurance generated loose oils
		    $loose_oils=$this->Insurance_product_m->get_insurance_generated_loose_oils($from_date,$to_date,$distributor_id,$plant_id);
		    foreach($loose_oils as $oil)
		    {
		    	$products[$oil['loose_oil_id']]['loose_name']=$oil['name'];
		    	if($plant_id =='' && $distributor_id =='')
				{
					$dist_products=$this->Insurance_product_m->get_dist_insurance_products($oil['loose_oil_id'],$from_date,$to_date,$distributor_id,$plant_id);
		    	   $products[$oil['loose_oil_id']]['dist_products']=$dist_products;
		    	   $plant_products=$this->Insurance_product_m->get_plant_insurance_products($oil['loose_oil_id'],$from_date,$to_date,$distributor_id,$plant_id);
		    	   $products[$oil['loose_oil_id']]['plant_products']=$plant_products; 
				}
				elseif($plant_id!=''&&$distributor_id =='')
				{
					$products[$oil['loose_oil_id']]['dist_products']=array();
		    	   $plant_products=$this->Insurance_product_m->get_plant_insurance_products($oil['loose_oil_id'],$from_date,$to_date,$distributor_id,$plant_id);
		    	   $products[$oil['loose_oil_id']]['plant_products']=$plant_products; 
				}
				elseif($plant_id==''&&$distributor_id !='')
				{
					$dist_products=$this->Insurance_product_m->get_dist_insurance_products($oil['loose_oil_id'],$from_date,$to_date,$distributor_id,$plant_id);
		    	    $products[$oil['loose_oil_id']]['dist_products']=$dist_products;
		    	     $products[$oil['loose_oil_id']]['plant_products']=array(); 
				}
		    }
		  // print_r($products);exit;
		    $data['products']=$products;
		     $this->load->view('insurance/print_consolidated_insurance_sales',$data);

	    }
	}
	// 19 APR 2017
	public function consolidated_insurance_sales_declaration()
	{

		# Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Insurance Sales Declaration";
		$data['nestedView']['pageTitle'] = 'Insurance Sales Declaration';
        $data['nestedView']['cur_page'] = 'consolidated_insurance_sales_declaration';
        $data['nestedView']['parent_page'] = 'insurance';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL .'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Insurance Sales Declaration', 'class' => '', 'url' => '');	
        $data['distributor_list'] = $this->Insurance_product_m->get_active_distributor_list();
       // $data['loose_oils'] = $this->Insurance_product_m->get_oils();
        $data['units'] = $this->Insurance_product_m->get_units();
        $this->load->view('insurance/consolidated_insurance_sales_declaration',$data);
	}

public function print_consolidated_insurance_sales_declaration()
	{
		if($this->input->post('submit'))
		{   
			if($this->input->post('from_date')!='')
			{
				$from_date=date('Y-m-d',strtotime($this->input->post('from_date')));
		    }
		    else
		    {
		    	$from_date='';
		    }
		    if($this->input->post('to_date') !='')
		    {
		    	$to_date=date('Y-m-d',strtotime($this->input->post('to_date')));
		    }
		    else
		    {
		    	$to_date='';
		    }
		    $data['from_date']=$from_date;
		    $data['to_date']=$to_date;
		    $plant_id=$this->input->post('plant_id');
		    $distributor_id=$this->input->post('distributor_id');

		    $products=array();
		    //get insurance generated loose oils
		    $loose_oils=$this->Insurance_product_m->get_invoice_generated_loose_oils($from_date,$to_date,$distributor_id,$plant_id);
		    foreach($loose_oils as $oil)
		    {
		    	$products[$oil['loose_oil_id']]['loose_name']=$oil['name'];
		    	if($plant_id =='' && $distributor_id =='')
				{
					$dist_products=$this->Insurance_product_m->get_dist_invoice_products($oil['loose_oil_id'],$from_date,$to_date,$distributor_id,$plant_id);
		    	   $products[$oil['loose_oil_id']]['dist_products']=$dist_products;
		    	   $plant_products=$this->Insurance_product_m->get_plant_invoice_products($oil['loose_oil_id'],$from_date,$to_date,$distributor_id,$plant_id);
		    	   $products[$oil['loose_oil_id']]['plant_products']=$plant_products; 
				}
				elseif($plant_id!=''&&$distributor_id =='')
				{
					$products[$oil['loose_oil_id']]['dist_products']=array();
		    	   $plant_products=$this->Insurance_product_m->get_plant_invoice_products($oil['loose_oil_id'],$from_date,$to_date,$distributor_id,$plant_id);
		    	   $products[$oil['loose_oil_id']]['plant_products']=$plant_products; 
				}
				elseif($plant_id==''&&$distributor_id !='')
				{
					$dist_products=$this->Insurance_product_m->get_dist_invoice_products($oil['loose_oil_id'],$from_date,$to_date,$distributor_id,$plant_id);
		    	    $products[$oil['loose_oil_id']]['dist_products']=$dist_products;
		    	     $products[$oil['loose_oil_id']]['plant_products']=array(); 
				}
		    }
		  // print_r($products);exit;
		    $data['products']=$products;
		     $this->load->view('insurance/print_consolidated_insurance_sales_declaration',$data);

	    }
	}

public function monthly_product_ins_dec()
    {
         # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Monthly Product Wise Insurance Declaration";
        $data['nestedView']['pageTitle'] = 'Monthly Product Wise Insurance Declaration';
        $data['nestedView']['cur_page'] = 'monthly_product_ins_dec';
        $data['nestedView']['parent_page'] = 'Sales';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Monthly Product Wise Insurance Declaration', 'class' => '', 'url' => '');   
         $data['get_units']=$this->Sales_model->get_units();
        $this->load->view('insurance/monthly_product_ins_dec',$data);
    }
    public function monthly_product_ins_dec_print()
    {
        $submit=$this->input->post('search_sales', TRUE);
        $from_date=date('Y-m-d', strtotime($this->input->post('start_date',TRUE)));
        $to_date=date('Y-m-d', strtotime($this->input->post('end_date',TRUE)));
        if($submit!='')
        {   
           $data['from_date']=date('d-m-Y',strtotime($from_date));
           $data['to_date']=date('d-m-Y',strtotime($to_date));
            $products=$this->Sales_model->get_products();
            if(count($products) >0)
            {
                $product_results=array();
                foreach($products as $key =>$value)
                {
                    if(array_key_exists(@$keys,$product_results))
                    {
                        $product_results[$value['loose_oil_id']] ['products'][$value['product_id']] =array(
                            'product_id'     =>  $value['product_id'],
                            'product_name'   =>  $value['short_name'].' '.'['.$value['oil_weight'].']',
                            'items_per_carton'=> $value['items_per_carton']
                             );
                    }
                    else
                    {
                        $product_results[$value['loose_oil_id']]['loose_oil']=$value['loose_oil_name'];
                        $product_results[$value['loose_oil_id']] ['products'][$value['product_id']] =array(
                            'product_id'     =>  $value['product_id'],
                            'product_name'   =>  $value['short_name'].' '.'['.$value['oil_weight'].']',
                            'items_per_carton' => $value['items_per_carton']
                            );
                    }
                }
            }
            $plant_id=$this->input->post('plant_id');
            $data['plant_id']=$plant_id;
            $product_sale_results=$this->Sales_model->get_all_units_monthly_product_report($from_date,$to_date,$plant_id);
            $dpsr=array();
            foreach($product_sale_results as $key2 =>$value2)
            {
                $dpsr[$value2['product_id']]['quantity_in_kgs']=$value2['qty_in_kg'];
                $dpsr[$value2['product_id']]['price']=$value2['amount'];
                $dpsr[$value2['product_id']]['quantity']=$value2['qty'];
                $dpsr[$value2['product_id']]['pouches']=$value2['pouches'];
            }
            $data['dpsr']=$dpsr;
            $data['product_results']=$product_results;
            $this->load->view('insurance/monthly_product_ins_dec_print',$data);
        }
    }
}