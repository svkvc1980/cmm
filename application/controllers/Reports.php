<?php defined('BASEPATH') OR exit('No direct script access allowed');
require_once 'Base_controller.php';
class Reports extends Base_controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Price_updation_model");
    }

    /*
      * Function   :  Product Price updation reports
      * Developer  :  Prasad created on: 6th Feb 1 PM updated on:      
     */
    public function product_price_report()
    {
    	
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="View Product Prices";
        $data['nestedView']['pageTitle'] = 'Price Updation Report';
        $data['nestedView']['cur_page'] = 'product_price_report';
        $data['nestedView']['parent_page'] = 'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/price_update_report.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Product price', 'class' => '', 'url' => ''); 

        $data['distributor'] = $this->Common_model->get_data('distributor_price_type',array('status'=>1),array('price_type_id','name'));
        
        //getting MRP id in distributor price type
        $row=$this->Common_model->get_data('distributor_price_type',array('name'=>'MRP'),array('price_type_id'));
        $data['mrp']=$row[0]; 
        
        //getting Raithu bazar id in distributor price type
        $row=$this->Common_model->get_data('distributor_price_type',array('name'=>'Raitu Bazar'),array('price_type_id'));
        $data['raitu_bazar']=$row[0];
        
        //getting plant except the headoffice and distributor
        $data['plant_results']=$this->Price_updation_model->get_plant();
          
        //for hiding plants dropdown  
        $data['unit_type']=2;
        $data['flag']=1;
        $this->load->view('product/update_price_report',$data); 
    }
     /*
      * Function   :  View Product Price Report
      * Developer  :  Prasad created on: 6th Feb 1 PM updated on:      
     */
    public function view_product_price_report()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "View Product Prices";
        $data['nestedView']['pageTitle'] = 'Price Updation Report';
        $data['nestedView']['cur_page'] = 'product_price_report';
        $data['nestedView']['parent_page'] = 'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
       /* $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/price_updation.js"></script>';*/
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Product price', 'class' => '', 'url' => SITE_URL . 'product_price_report');
         $data['nestedView']['breadCrumbOptions'][] = array('label' => 'View Product price', 'class' => '', 'url' => '');

        if($this->input->post('submit'))
        {
            $data['distributor_type']=$this->input->post('distributor');
            $start_date=$this->input->post('effective_date');
            $data['start_date']=$start_date;
            //retreving price type name based on price type id
            $row=$this->Common_model->get_data('distributor_price_type',array('price_type_id'=>$data['distributor_type']),array('name'));
            $price_type=$row[0]; 
            $type_name=$price_type['name'];
            $data['price_type_name']=$type_name;
            
            //setting session for mrp price type
            $data['plant_id']=$this->input->post('plant_name');
            $mrp_plant=$this->input->post('mrp_plant');
           
            //for heading
            if($data['plant_id'] !='')
            {
                 $row=$this->Common_model->get_data('plant',array('plant_id'=>$data['plant_id']),array('name'));
                 $ops_plant=$row[0]; 
                 $ops_plant_name=' for ops '.$ops_plant['name']; 
             }
            elseif($mrp_plant==get_all_plants())
            {
                 $ops_plant_name=' for all ops plants ';   
            }
            
            $data['ops']= @$ops_plant_name;

            if($mrp_plant==get_all_plants())
            {
                 $row=$this->Common_model->get_data('plant',array('plant_id'=>'4'),array('plant_id'));
                 $plant=$row[0]; 
                 $plant_name=$plant['plant_id']; 
                 $latest_details=$this->Price_updation_model->get_all_products_latest_price_report_plant($data['distributor_type'],$plant_name,date('Y-m-d',strtotime($start_date)));
            }
            else
            {
                if($data['plant_id']>0)
                {  
                   $latest_details=$this->Price_updation_model->get_all_products_latest_price_report_plant($data['distributor_type'],$data['plant_id'],date('Y-m-d',strtotime($start_date)));
                }
                else
                {   
                    $latest_details=$this->Price_updation_model->get_all_products_latest_price_report($data['distributor_type'],date('Y-m-d',strtotime($start_date)));
                }
            }
            //get products
            $products=$this->Price_updation_model->get_products();
            foreach($products as $key =>$value)
            {   $product_results[$value['loose_oil_id']]['loose_oil_name']=$value['loose_oil_id'];
                $product_results[$value['loose_oil_id']]['product_name']=$value['name'];
                $results=$this->Price_updation_model->get_sub_products_by_products($value['loose_oil_id']);
                $product_results[$value['loose_oil_id']]['sub_products']=$results;

            }
            
            $latest_price_details=array();
            foreach($latest_details as $key =>$value )
            {
                $latest_price_details[$value['product_id']]['old_price']=$value['value'];
                $latest_price_details[$value['product_id']]['product_price_id']=$value['product_price_id'];
            }

          
            $data['latest_price_details']=$latest_price_details;
            $data['product_results']=$product_results; 
        }
       // $data['flag']=2;
        $this->load->view('product/print_price_report',$data);
    }

    public function download_product_price_report()
    {
        if($this->input->post('download')!='')
        {
           
           $data['distributor_type']=$this->input->post('distributor_type');
           $start_date=$this->input->post('effective_date');
           $data['plant_id']=$this->input->post('plant_id'); 

           //retreving price type name based on price type id
            $row=$this->Common_model->get_data('distributor_price_type',array('price_type_id'=>$data['distributor_type']),array('name'));
            $price_type=$row[0]; 
            $price_type_name=$price_type['name'];
           
            
            //setting session for mrp price type
            //$data['plant_id']=$this->input->post('plant_name');
            $mrp_plant=$this->input->post('mrp_plant');
           

            //for heading
            if($data['plant_id'] !='')
            {
                 $row=$this->Common_model->get_data('plant',array('plant_id'=>$data['plant_id']),array('name'));
                 $ops_plant=$row[0]; 
                 $ops_plant_name='Price updation report for ops '.$ops_plant['name'].' '.'of'.$price_type_name.' price type'; 
                
            }
            elseif($mrp_plant==get_all_plants())
            {
                 $ops_plant_name='Price updation for all ops plants of '.$price_type_name.' price type';   
                  
            }
            else
            {
            	 $ops_plant_name='Price Updation of'.$price_type_name.' price type';
            		
            }
            
            if($mrp_plant==get_all_plants())
            {
                 $row=$this->Common_model->get_data('plant',array('plant_id'=>'3'),array('plant_id'));
                 $plant=$row[0]; 
                 $plant_name=$plant['plant_id']; 
                 $latest_details=$this->Price_updation_model->get_all_products_latest_price_report_plant($data['distributor_type'],$plant_name,date('Y-m-d',strtotime($start_date)));
            }
            else
            {
                if($data['plant_id']>0)
                {  
                   $latest_details=$this->Price_updation_model->get_all_products_latest_price_report_plant($data['distributor_type'],$data['plant_id'],date('Y-m-d',strtotime($start_date)));
                }
                else
                {   
                    $latest_details=$this->Price_updation_model->get_all_products_latest_price_report($data['distributor_type'],date('Y-m-d',strtotime($start_date)));
                }
            }
            //get products
            $products=$this->Price_updation_model->get_products();
            foreach($products as $key =>$value)
            {   $product_results[$value['loose_oil_id']]['loose_oil_name']=$value['loose_oil_id'];
                $product_results[$value['loose_oil_id']]['product_name']=$value['name'];
                $results=$this->Price_updation_model->get_sub_products_by_products($value['loose_oil_id']);
                $product_results[$value['loose_oil_id']]['sub_products']=$results;

            }
            
            $latest_price_details=array();
            foreach($latest_details as $key =>$value )
            {
                $latest_price_details[$value['product_id']]['old_price']=$value['value'];
                $latest_price_details[$value['product_id']]['product_price_id']=$value['product_price_id'];
            }

            
            $header = '';
            $data ='';

           
            $data = '<table border="1">';
           
            $data.='<tr>';
            $data.='<td colspan=5><b>'.$ops_plant_name.'</b></td>';
            $data.='</tr>';
            foreach ($product_results as $key => $value) 
            {
				$sno=1;
				$data.='<tr>';
				$data.='<td colspan=5 align="center"><b>'.$value['product_name'].'</b></td>';
                $data.='</tr>';            	
            
	            $data.='<tr>';
	            $data.='<td align="center"><b>'.'S.NO'.'</b></td>';
	            $data.='<td colspan=3 align="center"><b>'.'Product'.'</b></td>';
	            $data.='<td align="center"><b>'.'Price'.'</b></td>';
	            $data.='</tr>';
          
            	foreach($value['sub_products'] as $keys =>$values)
	            {
	                $data.='<tr>';
	                $data.='<td align="center">'.$sno++.'</td>';
	                $data.='<td align="center" colspan=3>'.$values['name'].'</td>';
                    if(@$latest_price_details[$values['product_id']]['old_price'] !='')
                    {
    	                $data.='<td align="center">'.$latest_price_details[$values['product_id']]['old_price'].'</td>';
                    }
                    else
                    {
                         $data.='<td align="center">0</td>';              
                    }
	                $data.='</tr>';
	                
	            }
           } 
           
            $data.='</table>';
            $time = date("Ymdhis");
            $xlFile='Product price'.$time.'.xls'; 
            header("Content-type: application/x-msdownload"); 
            # replace excelfile.xls with whatever you want the filename to default to
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
            
        }
    }
    public function product_price_report_units()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="View Product Prices";
        $data['nestedView']['pageTitle'] = 'Price Updation Report';
        $data['nestedView']['cur_page'] = 'product_price_report';
        $data['nestedView']['parent_page'] = 'reports';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
       /* $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/price_update_report.js"></script>';*/
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Manage Product price', 'class' => '', 'url' => ''); 

        $data['distributor'] = $this->Common_model->get_data('distributor_price_type',array('status'=>1),array('price_type_id','name'));
        
        //getting MRP id in distributor price type
        $row=$this->Common_model->get_data('distributor_price_type',array('name'=>'MRP'),array('price_type_id'));
        $data['mrp']=$row[0]; 
        
        //getting Raithu bazar id in distributor price type
        $row=$this->Common_model->get_data('distributor_price_type',array('name'=>'Raitu Bazar'),array('price_type_id'));
        $data['raitu_bazar']=$row[0];
        
        //getting plant except the headoffice and distributor
       // $data['plant_results']=$this->Price_updation_model->get_plant();
        
        $this->load->view('product/update_price_report_units',$data); 
    }
    public function view_product_price_report_units()
    {  
        if($this->input->post('submit'))
        {   
            $data['price_type']=$this->input->post('price_type');
            $row=$this->Common_model->get_data_row('distributor_price_type',array('price_type_id'=>$data['price_type']),array('name'));
            $data['distributor_price_type']=$row['name'];
            $start_date=$this->input->post('effective_date');
            $data['start_date']=$start_date;
            $search_date = format_date($start_date,'Y-m-d');
            $data['effective_from'] = $this->Price_updation_model->get_price_last_updated_date($search_date,$data['price_type']);
            //getting plant except the headoffice and distributor
            $units=$this->Price_updation_model->get_plant();
            $data['units']=$units;
            if($data['price_type']!=get_raithu_bazar_id())
            {
                $arr_unit=array();
                foreach($units as $key =>$value)
                {
                    $latest_details=$this->Price_updation_model->get_all_products_latest_price_report_plant($data['price_type'],$value['plant_id'],date('Y-m-d',strtotime($start_date)));
                    $arr_unit[$value['plant_id']]['plant_id']=$value['plant_id'];
                    $arr_unit[$value['plant_id']]['plant_results']=$latest_details;
                }
                

                $latest_price_details=array();
                foreach($arr_unit as $key =>$value )
                {  
                    foreach ($value['plant_results'] as $keys => $values) 
                    {
                        $latest_price_details[$key][$values['product_id']]['old_price']=$values['value'];
                        $latest_price_details[$key][$values['product_id']]['product_price_id']=$values['product_price_id'];
                    }
                }
            }
            else
            {
                $latest_details=$this->Price_updation_model->get_all_products_latest_price_report($data['price_type'],date('Y-m-d',strtotime($start_date)));  
                 $latest_price_details=array();
                foreach($latest_details as $key =>$value )
                {
                    $latest_price_details[$value['product_id']]['old_price']=$value['value'];
                    $latest_price_details[$value['product_id']]['product_price_id']=$value['product_price_id'];
                } 
            }
           //get products
            $products=$this->Price_updation_model->get_products();
            foreach($products as $key =>$value)
            {   $product_results[$value['loose_oil_id']]['loose_oil_name']=$value['loose_oil_id'];
                $product_results[$value['loose_oil_id']]['product_name']=$value['name'];
                $results=$this->Price_updation_model->get_sub_products_by_products($value['loose_oil_id']);
                $product_results[$value['loose_oil_id']]['sub_products']=$results;
            }
            $data['product_results']=$product_results;
            $data['latest_price_details']=$latest_price_details;
            $this->load->view('product/print_unit_price_report',$data); 
        }
    }
}