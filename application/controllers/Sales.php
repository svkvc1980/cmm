<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';

class Sales extends Base_controller {

    public function __construct()
    {

        parent::__construct();
        $this->load->model("Sales_model");

	}



    /* Counter Sales

     * Created by mastan */

	public function counter_sale_view()

    {

    	 # Data Array to carry the require fields to View and Model

        $data['nestedView']['heading']="Counter Sales";

		$data['nestedView']['pageTitle'] = 'Counter Sales';

        $data['nestedView']['cur_page'] = 'counter_sale_view';

        $data['nestedView']['parent_page'] = 'sales';



        # Load JS and CSS Files

        $data['nestedView']['js_includes'] = array();

        $data['nestedView']['css_includes'] = array();



        # Breadcrumbs

        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));	

        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Counter Sales', 'class' => 'active', 'url' => '');

        

        # Search Functionality

        $psearch=$this->input->post('searchsales', TRUE);

        if($psearch!='') 

        {
            $date1 = $this->input->post('date', TRUE);
            if($date1=='')
            {
                $date = '';
            }
            else
            {
                $date = date('Y-m-d',strtotime($date1));
            }

            $search_params=array(

                    'customer_name' => $this->input->post('customer_name', TRUE),

                    'billno'        => $this->input->post('billno', TRUE),

                    'date'          => $date,

                    'category'      => $this->input->post('category', TRUE)

                    
                              );

            $this->session->set_userdata($search_params);

        } 

        else 

        {

            

            if($this->uri->segment(2)!='')

            {

            $search_params=array(

                    'customer_name' => $this->session->userdata('customer_name'),

                    'billno'        => $this->session->userdata('billno'),

		            'date'          => $this->session->userdata('date'),

		            'category'      => $this->session->userdata('category')

		       

                  );

            }

            else {

                $search_params=array(

                      'customer_name' => '',

                      'billno'        => '',

                      'date'          => '',

                      'category'      => ''

                       );

                $this->session->set_userdata($search_params);

            }

            

        }
        $data['search_data'] = $search_params;
        # Default Records Per Page - always 10

        /* pagination start */

        $config = get_paginationConfig();

        $config['base_url'] = SITE_URL . 'counter_sale_view/';

        # Total Records

        $config['total_rows'] = $this->Sales_model->sales_total_num_rows($search_params);



        $config['per_page'] = getDefaultPerPageRecords();

        $data['total_rows'] = $config['total_rows'];

        $this->pagination->initialize($config);

        $data['pagination_links'] = $this->pagination->create_links();

        $current_offset = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;

        if ($data['pagination_links'] != '') 

        {

            $data['last'] = $this->pagination->cur_page * $config['per_page'];

            if ($data['last'] > $data['total_rows']) {

                $data['last'] = $data['total_rows'];

            }

            $data['pagermessage'] = 'Showing ' . ((($this->pagination->cur_page - 1) * $config['per_page']) + 1) . ' to ' . ($data['last']) . ' of ' . $data['total_rows'];

        }

        $data['sn'] = $current_offset + 1;

        /* pagination end */



        # Loading the data array to send to View

        $data['salesResults'] = $this->Sales_model->sales_results($current_offset, $config['per_page'], $search_params);

        $data['category'] = $this->Common_model->get_data('cs_category',array('status'=>'1'));
        //print_r($data['category']); exit();

        # Additional data

        $data['displayResults'] = 1;



        $this->load->view('sales/counter_sale_view',$data);

    }


    public function delete_counter_sales()
    {
        if($this->input->post('submit_remarks', TRUE))
        {
            $counter_sale_id=@cmm_decode($this->uri->segment(2));
            $where = array('counter_sale_id' => $counter_sale_id);
            $dataArr = array(
                            'remarks' => $this->input->post('remarks'),
                            'status'  => 2
                            );
            $this->Common_model->update_data('counter_sale',$dataArr, $where);
            
            $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                    <strong>Success!</strong> Conter sale has been Deleted successfully!
                                 </div>');

            redirect(SITE_URL.'counter_sale_view');
        }
    }

    public function activate_counter_sales()
    {
        $counter_sale_id=@cmm_decode($this->uri->segment(2));
        $where = array('counter_sale_id' => $counter_sale_id);
        $dataArr = array('remarks' => $this->input->post('remarks'),'status' => 1);
        $this->Common_model->update_data('counter_sale',$dataArr, $where);
        
        $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <strong>Success!</strong> Conter sale has been Activated successfully!
                             </div>');

        redirect(SITE_URL.'counter_sale_view');
    }

	public function counter_sales()

	{

		# Data Array to carry the require fields to View and Model

		$data['nestedView']['heading'] = "Counter Sales";
        $data['nestedView']['pageTitle'] = 'Counter Sales';
		$data['nestedView']['cur_page'] = 'counter_sale_view';
        $data['nestedView']['parent_page'] = 'sales';

		

		# Load JS and CSS Files

		$data['nestedView']['js_includes'] = array();

		$data['nestedView']['css_includes'] = array();

		$data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/counter_sales.js"></script>';

		

		# Breadcrumbs

		

		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));

		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Counter Sales','class'=>'active','url'=>'');



		$data['product']= array(''=>'Select Product')+$this->Common_model->get_dropdown('product','product_id','name');

        $data['bank']= array(''=>'Select Bank')+$this->Common_model->get_dropdown('bank','bank_id','name');

        $data['cs_category']= $this->Common_model->get_data('cs_category',array('status' => 1));

        $data['cs_pay_mode'] = $this->Common_model->get_data('cs_pay_mode',array('status' => 1));



		$this->load->view('sales/counter_sales',$data);

	}



    public function insert_counter_sales()

    {
        $plant_id   = $this->session->userdata('ses_plant_id');
        $var = $this->input->post('submit',TRUE);

        if($var=='1')

        {

            //echo "ds"; exit();

            $product        =   $this->input->post('product');

            $price          =   $this->input->post('price');

            $bad_symbols    =   array(",");

            $price          =   str_replace($bad_symbols, "", $price);

            $quantity       =   $this->input->post('quantity');

            $amount         =   $this->input->post('amount');

            $total          =   $this->input->post('total');

            $denomination   =   $this->input->post('denomination');

            $bad_symbols    =   array(",");

            $denomination   =   str_replace($bad_symbols, "", $denomination);

            $pay_customer   =   $this->input->post('pay_customer');

            $dd_number      =   $this->input->post('dd_number');

            if($dd_number=='')

            {

                $dd_number = NULL;

            }

            $bank_id        =   $this->input->post('bank');
            //echo $bank_id; exit();

            if($bank_id=='')

            {

                $bank_id = NULL;

            }



            $customer_name  =   $this->input->post('customer_name');

            $bill_number    =   get_bill_number();

            $cs_category    =   $this->input->post('cs_category');

            $cs_paymode     =   $this->input->post('cs_paymode');



            $this->db->trans_begin();

            $dat=array(

                'bank_id'               =>   $bank_id,

                'counter_id'            =>   get_plant_counter_sale_id(),

                'cs_pay_mode_id'        =>   $cs_paymode,

                'cs_category_id'        =>   $cs_category,

                'on_date'               =>   date('Y-m-d'), 

                'bill_number'           =>   $bill_number,

                'customer_name'         =>   $customer_name,

                'dd_number'             =>   $dd_number,

                'received_denomination' =>   $denomination,

                'total_bill'            =>   $total,

                'pay_customer'          =>   $pay_customer,

                'status'                =>   1,

                'created_by'            =>   $this->session->userdata('user_id')

                            );

            $counter_sale_id = $this->Common_model->insert_data('counter_sale',$dat);


            for($i=1;$i<=count($product);$i++) 

            {

                $dat1=array(

                'counter_sale_id'   =>   $counter_sale_id, 

                'product_id'        =>   $product[$i],

                'price'             =>   $price[$i],

                'quantity'          =>   $quantity[$i],

                'amount'            =>   $amount[$i],

                'status'            =>   1,

                'created_by'        =>   $this->session->userdata('user_id')

                            );

                $this->Common_model->insert_data('cs_product',$dat1);

                $items_per_carton = $this->Common_model->get_value('product', array('product_id' => $product[$i]), 'items_per_carton');
                $counter_qty = $quantity[$i]/$items_per_carton;

                $counter_id = get_plant_counter_sale_id();
                //reducing stock in plant counter product table 
                $qry = 'UPDATE plant_counter_product SET quantity=quantity-'.$counter_qty.', updated_time = NOW() WHERE counter_id='.$counter_id.' and product_id='.$product[$i];
                $this->db->query($qry); 

                //reducing stock in plant product table 
                $qry = 'UPDATE plant_product SET quantity=quantity-'.$counter_qty.', updated_time = NOW() WHERE plant_id='.$plant_id.' and product_id='.$product[$i];
                $this->db->query($qry); 

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

                    $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">

                                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>

                                                            <strong>Success!</strong> Bill has been added successfully! </div>');

                         

                }



                redirect(SITE_URL.'counter_sale_view');

        }

    }

    public function view_sales_list()
    {
        $counter_sale_id=@cmm_decode($this->uri->segment(2));
        if($counter_sale_id=='')
        {
            redirect(SITE_URL);
            exit;
        }
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "View Sales List";
        $data['nestedView']['cur_page'] = 'counter_sale_view';
        $data['nestedView']['parent_page'] = 'sales';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['pageTitle'] = 'View Counter Sales';
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'View Sales List','class'=>'active','url'=>'');

        $data['sales_list'] = $this->Sales_model->view_sales_list($counter_sale_id);

        $this->load->view('sales/view_sales_list',$data);
    }

    public function get_raithu_bazar_price()
    {
        //$plant_id   = $this->session->userdata('ses_plant_id');
        $product_id = $this->input->post('product');
        $distributor_type= get_raithu_bazar_id();
        $this->Sales_model->get_raithu_bazar_price($product_id,$distributor_type);
    }

    public function get_counter_stock_in_counter_sale()
    {
        $plant_id   = $this->session->userdata('ses_plant_id');
        $product_id = $this->input->post('product');
        $items_per_carton = $this->Common_model->get_value('product', array('product_id' => $product_id), 'items_per_carton');
        $godown_stock = $this->Sales_model->get_counter_stock($product_id, $plant_id, $items_per_carton);
    }

/*Sales Details for scrolling 
Author:Srilekha
Time: 04.06PM 21-03-2017 */
    public function sales_scroll()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']=" Product Sales List";
        $data['nestedView']['pageTitle'] = 'Product Sales List';
        $data['nestedView']['cur_page'] = 'product_sales';
        $data['nestedView']['parent_page'] = 'inventory';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        $plant = $this->Sales_model->get_plant_block();
        $sales_scroll = array();
        foreach ($plant as $key => $value) 
        {
            $sales_scroll[$key]['plant_name'] = $value['name'];
            $pending_qty = $this->Sales_model->get_sales_details($value['plant_id']);
            $sales_scroll[$key]['pending_qty'] = $pending_qty;
            
        }
        $data['sales_scroll'] = $sales_scroll;

        $this->load->view('commons/dashboard/admin-headoffice',$data);

        
    }

/*Sales Details for Print
Author:Srilekha
Time: 05.46PM 18-03-2017 */
    public function sales_print_scroll()
    {
        
        $plant = $this->Sales_model->get_plant_block();
        $sales_scroll = array();
        foreach ($plant as $key => $value) 
        {
            $sales_scroll[$key]['plant_name'] = $value['name'];
            $pending_qty = $this->Sales_model->get_sales_details($value['plant_id']);
            $sales_scroll[$key]['pending_qty'] = $pending_qty;
            
        }
        $data['sales_scroll'] = $sales_scroll;
        $column=array_column($data['sales_scroll'],'pending_qty');
        $data['sales_sum']=array_sum($column);

        $this->load->view('sales/sales_list_print_view',$data);
    }
    
   /*Daily Sales Report
Author:Srilekha
Time: 12.43PM 23-03-2017 */
    public function daily_sales_report()
    {

        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "View Sales Report";
        $data['nestedView']['cur_page'] = 'view sales report';
        $data['nestedView']['parent_page'] = 'sales';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['pageTitle'] = 'View Sales Report';
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'View Sales Report','class'=>'active','url'=>'');
        
        $data['block_id']=$this->session->userdata('block_id'); 
        if($data['block_id']==get_headoffice_block_id())
        {
            $data['get_units']=$this->Sales_model->get_units();
        }
        $this->load->view('sales/daily_sales_report',$data);

    }

/*Daily Sales Report Print
Author:Srilekha
Time: 12.46PM 30-03-2017 */
     public function daily_sales_report_print()
    {
        $submit=$this->input->post('search_sales', TRUE);
        $from_date=date('Y-m-d', strtotime($this->input->post('start_date',TRUE)));
        if($submit!='')
        {   
            $data['from_date']=date('d-m-Y', strtotime($this->input->post('start_date',TRUE)));
            $prev_date= date('Y-m-d', strtotime('-1 day', strtotime($from_date)));
            $data['prev_date']=date('d-m-Y',strtotime($prev_date));
            $oils=$this->Sales_model->get_oils();
            $dsr=array();
            $csdsr=array();
             $data['block_id']=$this->session->userdata('block_id'); 
            if($data['block_id']==get_headoffice_block_id())
            {
               $plant_id=$this->input->post('plant_id');
               $res=$this->Common_model->get_data_row('plant',array('plant_id'=>$plant_id),array('name'));
               $data['plant_name']=$res['name'];
               //retreving counter id
             $counter_id=$this->Common_model->get_value('plant_counter',array('plant_id'=>$plant_id),'counter_id');
            }
            else
            {
                $plant_id=$this->session->userdata('ses_plant_id');
                $data['plant_name']=$this->session->userdata('plant_name');
                //retreving counter id
                $counter_id=$this->Common_model->get_value('plant_counter',array('plant_id'=>$plant_id),'counter_id');
            }
            $sales_results= $this->Sales_model->get_sales_daily_report($from_date,$plant_id);
            $cs_results=$this->Sales_model->get_cs_daily_report($from_date,$counter_id);
            foreach($sales_results as $key =>$value)
            {
                $dsr[$value['loose_oil_id']]['quantity']=$value['qty_in_kg'];
                $dsr[$value['loose_oil_id']]['price']=$value['amount'];
            }
            foreach($cs_results as $k1=>$v1)
            {
                $csdsr[$v1['loose_oil_id']]['cs_quantity']=$v1['cs_qty_in_kg'];
                $csdsr[$v1['loose_oil_id']]['cs_amount']=$v1['cs_amount'];
            }
            $fin_start_date=get_financial_year();
            $data['previous_sales']=$this->Sales_model->get_previous_sales_daily_report($prev_date,$plant_id,$fin_start_date['start_date']
            );
            $data['cs_previous_sales']=$this->Sales_model->get_previous_csdsr($prev_date,$counter_id,$fin_start_date['start_date']);
            $data['dsr']=$dsr;
          //  print_r($data['cs_previous_sales']);exit;
            $data['csdsr']=$csdsr;
            $data['oils']=$oils;
            $data['from_date']=date('d-m-Y',strtotime($from_date));
            $this->load->view('sales/daily_sales_report_print',$data);
        }
        

    }

    

/*Monthly Sales Report
Author:Srilekha
Time: 03.18PM 23-03-2017 */
   public function monthly_sales_report()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Monthly Sales Report";
        $data['nestedView']['pageTitle'] = 'Monthly Sales Report';
        $data['nestedView']['cur_page'] = 'Monthly Sales Report';
        $data['nestedView']['parent_page'] = 'Sales';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Monthly Sales Report', 'class' => '', 'url' => '');
        $data['block_id']=$this->session->userdata('block_id'); 
        if($data['block_id']==get_headoffice_block_id())
        {
            $data['get_units']=$this->Sales_model->get_units();
        }   

        $this->load->view('sales/monthly_sales_report',$data);

    }
/*Monthly Sales Report Print
Author:Srilekha
Time: 11.40AM 24-03-2017 */
    public function monthly_sales_report_print()
    {
        $submit=$this->input->post('search_sales', TRUE);
        $from_date=date('Y-m-d', strtotime($this->input->post('start_date',TRUE)));
        $to_date=date('Y-m-d', strtotime($this->input->post('end_date',TRUE)));

        if($submit!='')
        {   
            $data['oils']=$this->Sales_model->get_oils();
            $data['block_id']=$this->session->userdata('block_id'); 
            if($data['block_id']==get_headoffice_block_id())
            {
               $plant_id=$this->input->post('plant_id');
               $res=$this->Common_model->get_data_row('plant',array('plant_id'=>$plant_id),array('name'));
               $data['plant_name']=$res['name'];
            }
            else
            {
                $plant_id=$this->session->userdata('ses_plant_id');
                $data['plant_name']=$this->session->userdata('plant_name');
            }
            $sales_results = $this->Sales_model->monthly_reports_results($from_date,$to_date,$plant_id);
            $msr=array();
            foreach ($sales_results as $key => $value)
            {
                $msr[$value['loose_oil_id']]['month_quantity']=$value['qty_in_kg'];
                $msr[$value['loose_oil_id']]['month_price']=$value['amount'];
            }
            $data['from_date']=date('d-m-Y',strtotime($from_date));
            $data['to_date']=date('d-m-Y',strtotime($to_date));
            $data['msr']=$msr;
        }
        $this->load->view('sales/monthly_sales_report_print',$data);

    }
/*District Wise Sales Report
Author:Srilekha
Time: 03.29PM 24-03-2017 */
   public function district_sales_report()
    {
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="District Sales Report";
        $data['nestedView']['pageTitle'] = 'District Sales Report';
        $data['nestedView']['cur_page'] = 'District Sales Report';
        $data['nestedView']['parent_page'] = 'Sales';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'District Sales Report', 'class' => '', 'url' => '');   

        $data['district_list']=$this->Common_model->get_data('location',array('level_id'=>4));
        $this->load->view('sales/district_sales_report',$data);

    }
/*District Wise Sales Report Print
Author:Srilekha
Time: 03.40PM 24-03-2017 */
    public function district_sales_report_print()
    {
        $submit=$this->input->post('search_sales', TRUE);
        $from_date=date('Y-m-d', strtotime($this->input->post('start_date',TRUE)));
        $to_date=date('Y-m-d', strtotime($this->input->post('end_date',TRUE)));
        $location_id=$this->input->post('location',TRUE);
        if($submit!='')
        {
            $data['sales_results'] = $this->Sales_model->district_reports_results($from_date,$to_date,$location_id);
            $data['from_date']=$from_date;
            $data['to_date']=$to_date;
            $data['location_name']=$this->Common_model->get_value('location',array('location_id'=>$location_id),'name');
            #echo "<pre>"; print_r($data['sales_results']); exit;
        }
        $this->load->view('sales/district_sales_report_print',$data);
    }
    public function daily_product_sale_report()
    {
       
           
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Daily Product Sales Report";
        $data['nestedView']['pageTitle'] = 'Daily Product Sales Report';
        $data['nestedView']['cur_page'] = 'daily_product_sale_report';
        $data['nestedView']['parent_page'] = 'Sales';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Product Sales Report', 'class' => '', 'url' => '');
        $data['block_id']=$this->session->userdata('block_id'); 
        if($data['block_id']==get_headoffice_block_id())
        {
            $data['get_units']=$this->Sales_model->get_units();
        }    

        $this->load->view('sales/daily_product_sales_report',$data);

    }
    public function daily_product_sales_report_print()
    {
        $submit=$this->input->post('search_sales', TRUE);
        $from_date=date('Y-m-d', strtotime($this->input->post('start_date',TRUE)));
        if($submit!='')
        {   
           $data['from_date']=date('d-m-Y',strtotime($from_date));
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
            $data['block_id']=$this->session->userdata('block_id'); 
            if($data['block_id']==get_headoffice_block_id())
            {
               $plant_id=$this->input->post('plant_id');
               $res=$this->Common_model->get_data_row('plant',array('plant_id'=>$plant_id),array('name'));
               $data['plant_name']=$res['name'];
            }
            else
            {
                $plant_id=$this->session->userdata('ses_plant_id');
                $data['plant_name']=$this->session->userdata('plant_name');
            }
            $product_sale_results=$this->Sales_model->get_sales_daily_product_report($from_date,$plant_id);
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
            $this->load->view('sales/daily_sales_product_report_print',$data);
        }
    }
    public function daily_exec_product_sale_report()
    {
         # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Executive Wise Product Sales Report";
        $data['nestedView']['pageTitle'] = 'Executive Wise Product Sales Report';
        $data['nestedView']['cur_page'] = 'daily_exec_product_sale_report';
        $data['nestedView']['parent_page'] = 'Sales';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Exec Wise Product Sales Report', 'class' => '', 'url' => '');   
        $data['exec']=$this->Common_model->get_data('executive');
        $this->load->view('sales/exec_daily_product_sales_report',$data);
    }
    public function daily_exec_product_sales_report_print()
    {
        $submit=$this->input->post('search_sales', TRUE);
        $from_date=date('Y-m-d', strtotime($this->input->post('start_date',TRUE)));
        $exec_id=$this->input->post('executive');
        $exec=$this->Common_model->get_data_row('executive',array('executive_id'=>$exec_id));
        $data['executive_name']=$exec['name'];
        if($submit!='')
        {   
           $data['from_date']=date('d-m-Y',strtotime($from_date));
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
            $product_sale_results=$this->Sales_model->get_exec_sales_daily_product_report($from_date,$exec_id);
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
            $this->load->view('sales/daily_exec_product_sales_print',$data);
        }
    }
    public function monthly_product_sale_report()
    {
         # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Monthly Product Sales Report";
        $data['nestedView']['pageTitle'] = 'Monthly Product Sales Report';
        $data['nestedView']['cur_page'] = 'monthly_product_sale_report';
        $data['nestedView']['parent_page'] = 'Sales';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Monthly Product Sales Report', 'class' => '', 'url' => '');   
         $data['block_id']=$this->session->userdata('block_id'); 
        if($data['block_id']==get_headoffice_block_id())
        {
            $data['get_units']=$this->Sales_model->get_units();
        } 

        $this->load->view('sales/monthly_product_sales_report',$data);
    }
    public function monthly_product_sales_report_print()
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
            $data['block_id']=$this->session->userdata('block_id'); 
            if($data['block_id']==get_headoffice_block_id())
            {
               $plant_id=$this->input->post('plant_id');
               $res=$this->Common_model->get_data_row('plant',array('plant_id'=>$plant_id),array('name'));
               $data['plant_name']=$res['name'];
            }
            else
            {
                $plant_id=$this->session->userdata('ses_plant_id');
                $data['plant_name']=$this->session->userdata('plant_name');
            }
            $product_sale_results=$this->Sales_model->get_sales_monthly_product_report($from_date,$to_date,$plant_id);
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
            $this->load->view('sales/monthly_sales_product_report_print',$data);
        }
    }
    public function monthly_exec_product_sale_report()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Executive Wise Product Sales Report";
        $data['nestedView']['pageTitle'] = 'Executive Wise Product Sales Report';
        $data['nestedView']['cur_page'] = 'monthly_exec_product_sale_report';
        $data['nestedView']['parent_page'] = 'Sales';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Exec Wise Product Sales Report', 'class' => '', 'url' => '');   
        $data['exec']=$this->Common_model->get_data('executive');
        $this->load->view('sales/exec_monthly_product_sales_report',$data);
    }
    public function monthly_exec_product_sales_report_print()
     {
        $submit=$this->input->post('search_sales', TRUE);
        $from_date=date('Y-m-d', strtotime($this->input->post('start_date',TRUE)));
        $to_date=date('Y-m-d', strtotime($this->input->post('end_date',TRUE)));
        $exec_id=$this->input->post('executive');
        $exec=$this->Common_model->get_data_row('executive',array('executive_id'=>$exec_id));
        $data['executive_name']=$exec['name'];
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
            $product_sale_results=$this->Sales_model->get_exec_sales_monthly_product_report($from_date,$to_date,$exec_id);
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
            $this->load->view('sales/exec_monthly_sales_product_report_print',$data);
        }
    }

    public function executive_daily_sales_report()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Executive Wise  Sales Report";
        $data['nestedView']['pageTitle'] = 'Executive Wise  Sales Report';
        $data['nestedView']['cur_page'] = 'executive_daily_sales_report';
        $data['nestedView']['parent_page'] = 'Sales';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Exec Wise Sales Report', 'class' => '', 'url' => '');   
        $data['exec']=$this->Common_model->get_data('executive');
        $this->load->view('sales/exec_daily_sales_report',$data);
    }
    public function executive_daily_sales_report_print()
    {
        $submit=$this->input->post('search_sales', TRUE);
        $from_date=date('Y-m-d', strtotime($this->input->post('start_date',TRUE)));
        $exec_id=$this->input->post('executive');
        $exec=$this->Common_model->get_data_row('executive',array('executive_id'=>$exec_id));
        $data['executive_name']=$exec['name'];
        if($submit!='')
        {   
           $data['from_date']=date('d-m-Y',strtotime($from_date));
           $invoices=$this->Sales_model->get_executive_invoices($from_date,$exec_id);
           $exec_results=array();
           foreach ($invoices as $key => $value)
           {
                $exec_results[$value['invoice_id']]['invoice']=$value['invoice_number'];
                $executive_sale_results=$this->Sales_model->get_exec_sales_daily_report($from_date,$exec_id,$value['invoice_id']);
                $exec_results[$value['invoice_id']]['invoice_results']=$executive_sale_results;
           }
           $data['exec_results']=$exec_results;
           $this->load->view('sales/daily_exec_sales_print',$data);
        }
    }
    public function executive_monthly_sales_report()
    {
       # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Monthly  Executive Wise Sales Report";
        $data['nestedView']['pageTitle'] = 'Executive Wise Product Sales Report';
        $data['nestedView']['cur_page'] = 'executive_monthly_sales_report';
        $data['nestedView']['parent_page'] = 'Sales';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Exec Wise Product Sales Report', 'class' => '', 'url' => '');   
        $data['exec']=$this->Common_model->get_data('executive');
        $this->load->view('sales/exec_monthly_sales_report',$data); 
    }
    public function executive_monthly_sales_report_print()
    {
        $submit=$this->input->post('search_sales', TRUE);
        $from_date=date('Y-m-d', strtotime($this->input->post('start_date',TRUE)));
        $to_date=date('Y-m-d', strtotime($this->input->post('end_date',TRUE)));
        $exec_id=$this->input->post('executive');
        $exec=$this->Common_model->get_data_row('executive',array('executive_id'=>$exec_id));
        $data['executive_name']=$exec['name'];
        if($submit!='')
        {   
           $data['from_date']=date('d-m-Y',strtotime($from_date));
           $data['to_date']=date('d-m-Y',strtotime($to_date));
            $data['executive_sale_results']=$this->Sales_model->get_exec_sales_monthly_report($from_date,$to_date,$exec_id); 
           $this->load->view('sales/monthly_exec_sales_print',$data);
        }
    }
    public function distributor_daily_sales_report()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Distributor Wise  Sales Report";
        $data['nestedView']['pageTitle'] = 'Distributor Wise  Sales Report';
        $data['nestedView']['cur_page'] = 'distributor_daily_sales_report';
        $data['nestedView']['parent_page'] = 'Sales';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Dist Wise Sales Report', 'class' => '', 'url' => '');   
        $data['dist']=$this->Sales_model->get_distributor();
        $this->load->view('sales/dist_daily_sales_report',$data);
    }
    public function distributor_daily_sales_report_print()
    {
        $submit=$this->input->post('search_sales', TRUE);
        $from_date=date('Y-m-d', strtotime($this->input->post('start_date',TRUE)));
        $dist_id=$this->input->post('distributor');
        $data['dist']=$this->Common_model->get_data_row('distributor',array('distributor_id'=>$dist_id));
       // $data['agency_name']=$dist['agency_name'];
        if($submit!='')
        {   
           $data['from_date']=date('d-m-Y',strtotime($from_date));
           $data['dist_sale_results']=$this->Sales_model->get_dist_sales_daily_report($from_date,$dist_id);
            $this->load->view('sales/daily_dist_sales_print',$data);
        }
    }
    public function distributor_monthly_sales_report()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Distributor Wise Monthly Sales Report";
        $data['nestedView']['pageTitle'] = 'Distributor Wise Monthly Sales Report';
        $data['nestedView']['cur_page'] = 'executive_monthly_sales_report';
        $data['nestedView']['parent_page'] = 'Sales';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Distributor Wise Monthly Sales Report', 'class' => '', 'url' => '');   
         $data['dist']=$this->Sales_model->get_distributor();
        $this->load->view('sales/dist_monthly_sale_report',$data);
    }
    public function distributor_monthly_sales_report_print()
    {
        $submit=$this->input->post('search_sales', TRUE);
        $from_date=date('Y-m-d', strtotime($this->input->post('start_date',TRUE)));
        $to_date=date('Y-m-d', strtotime($this->input->post('end_date',TRUE)));
        $dist_id=$this->input->post('distributor');
        $data['dist']=$this->Common_model->get_data_row('distributor',array('distributor_id'=>$dist_id));
        if($submit!='')
        {   
           $data['from_date']=date('d-m-Y',strtotime($from_date));
           $data['to_date']=date('d-m-Y',strtotime($to_date));
            $data['dist_sale_results']=$this->Sales_model->get_dist_sales_monthly_report($from_date,$to_date,$dist_id); 
           $this->load->view('sales/monthly_dist_sales_print',$data);
        }
    }
    
    public function daily_sales_report_md()
    {
         # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "View Sales Report";
        $data['nestedView']['cur_page'] = 'view sales report';
        $data['nestedView']['parent_page'] = 'sales';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['pageTitle'] = 'View Sales Report';
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'View Sales Report','class'=>'active','url'=>'');
        
        $this->load->view('sales/md_daily_sales_report',$data);
    }

 public function daily_sales_report_md_print()
    {
        if($this->input->post('search_sales'))
        {
            $start_date=date('Y-m-d', strtotime($this->input->post('start_date',TRUE)));
            //retreiving current month starting day
            $month_first_day=date('Y-m-01', strtotime($this->input->post('start_date',TRUE)));
            $data['units']=$this->Sales_model->get_all_units_inc_ops();
            $sales_results=$this->Sales_model->get_md_daily_sales_report($start_date);
            $dsr=array();
            foreach($sales_results as $key =>$value)
            {
                $dsr[$value['plant_id']]['quantity']=$value['mt_in_kg'];
                $dsr[$value['plant_id']]['price']=$value['amount'];
            }
            $data['previous_sales']=$this->Sales_model->get_previous_sales_daily_report_md($month_first_day,$start_date);
            $data['dsr']=$dsr;
            $data['from_date']=$start_date;
             $data['prev_date']= date('Y-m-d', strtotime('-1 day', strtotime($start_date)));

            //for executive wise sales report
             $data['exec']=$this->Common_model->get_data('executive');
            $executive_sale_results=$this->Sales_model->get_exec_md_sales_daily_report($start_date);
            $data['oils']=$this->Sales_model->get_oils();
            $edsr=array();
            foreach ($executive_sale_results as $k1 => $v1) 
            {
                $edsr[$v1['loose_oil_id']][$v1['executive_id']]['mt_in_kg']=$v1['mt_in_kg'];
            }
            $data['edsr']=$edsr;
            //print_r($data['edsr']);exit;
            $this->load->view('sales/md_daily_sales_report_print',$data); 
        }
    }
    
     public function yearly_unit_product_report()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "Yearly Sales Report";
        $data['nestedView']['cur_page'] = 'Yearly sales report';
        $data['nestedView']['parent_page'] = 'yearly_unit_product_report';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['pageTitle'] = 'Yearly Sales Report';
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'Yearly Sales Report','class'=>'active','url'=>'');
        $this->load->view('sales/yearly_sales_report',$data);
    }
    
      public function monthly_sales_report_md()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading'] = "View Sales Report";
        $data['nestedView']['cur_page'] = 'view sales report';
        $data['nestedView']['parent_page'] = 'sales';
        
        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();
        
        # Breadcrumbs
        $data['nestedView']['pageTitle'] = 'View Sales Report';
        $data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label'=>'View Sales Report','class'=>'active','url'=>'');
        
        $this->load->view('sales/md_monthly_sales_report',$data);
    }

     public function monthly_sales_report_md_print()
    {
        if($this->input->post('search_sales'))
        {
            $start_date=date('Y-m-d', strtotime($this->input->post('start_date',TRUE)));
            $end_date=date('Y-m-d', strtotime($this->input->post('end_date',TRUE)));
            
            $data['units']=$this->Sales_model->get_all_units_inc_ops();
            $sales_results=$this->Sales_model->get_md_monthly_sales_report($start_date,$end_date);
            $dsr=array();
            foreach($sales_results as $key =>$value)
            {
                $dsr[$value['plant_id']]['quantity']=$value['mt_in_kg'];
                $dsr[$value['plant_id']]['price']=$value['amount'];
            }
           
            $data['dsr']=$dsr;
            $data['from_date']=$start_date;
            $data['to_date']= $end_date;

            //for executive wise sales report
            $data['exec']=$this->Common_model->get_data('executive');
            $executive_sale_results=$this->Sales_model->get_exec_md_sales_monthly_report($start_date,$end_date);
            $data['oils']=$this->Sales_model->get_oils();
            $edsr=array();
            foreach ($executive_sale_results as $k1 => $v1) 
            {
                $edsr[$v1['loose_oil_id']][$v1['executive_id']]['mt_in_kg']=$v1['mt_in_kg'];
            }
            $data['edsr']=$edsr;
            //print_r($data['edsr']);exit;
            $this->load->view('sales/md_monthly_sales_report_print',$data); 
        }
    }

 public function yearly_unit_product_report_print()
    {   
        if($this->input->post('search_sales',true))
        {
            $fin_year=$this->input->post('years');
            if(date('m')<4)
                {
                    $fin_start_date = ($fin_year-1).'-4-1';
                    $fin_end_date = $fin_year.'-3-31';
                }
                else
                {
                    $fin_start_date = $fin_year.'-4-1';
                    $fin_end_date = ($fin_year+1).'-3-31';
                }
            $data['oils']=$this->Sales_model->get_oils();
            $data['months_array']=array(04=>'Apr',05=>'May',06=>'Jun',07=>'Jul',08=>'Aug',09=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec',01=>'Jan',02=>'Feb',03=>'Mar');
            $sales_results = $this->Sales_model->get_yearly_oil_report($fin_start_date,$fin_end_date);
            $msr=array();
            foreach ($sales_results as $key => $value)
            {
                $msr[$value['loose_oil_id']][$value['invoice_month']]['month_quantity']=$value['qty_in_kg'];
                $msr[$value['loose_oil_id']][$value['invoice_month']]['month_price']=$value['amount'];
            }
            $data['from_date']=date('d-m-Y',strtotime($fin_start_date));
            $data['to_date']=date('d-m-Y',strtotime($fin_end_date));
            $data['msr']=$msr;
            $this->load->view('sales/yearly_unit_wise_sales_report',$data);
        }
    }
    
     public function executive_wise_invoice_sales_report()
    {
       # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']=" Executive Wise Sales Report";
        $data['nestedView']['pageTitle'] = 'Executive Wise  Sales Report';
        $data['nestedView']['cur_page'] = 'executive_wise_invoice_sales_report';
        $data['nestedView']['parent_page'] = 'Sales';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Exec Wise Sales Report', 'class' => '', 'url' => '');   
        $data['exec']=$this->Common_model->get_data('executive');
        $this->load->view('sales/exec_wise_sales_report',$data); 
    }

    public function executive_wise_invoice_sales_report_print()
    {
        $submit=$this->input->post('submit', TRUE);
        $from_date=date('Y-m-d', strtotime($this->input->post('start_date',TRUE)));
        $to_date=date('Y-m-d', strtotime($this->input->post('end_date',TRUE)));
        $exec_id=$this->input->post('executive');
        $exec=$this->Common_model->get_data_row('executive',array('executive_id'=>$exec_id));
        $data['executive_name']=$exec['name'];
        if($submit!='')
        {   
           $data['from_date']=date('d-m-Y',strtotime($from_date));
           $data['to_date']=date('d-m-Y',strtotime($to_date));
           $executive_sale_results=$this->Sales_model->get_exec_wise_invoice_sales($from_date,$to_date,$exec_id);
            $product_results=array();
                foreach($executive_sale_results as $key =>$value)
                {
                    if(array_key_exists(@$keys,$product_results))
                    {
                        $product_results[$value['distributor_id']] ['products'][] =array(
                            'invoice_number'=> $value['invoice_number'],
                            'invoice_date'  => $value['invoice_date'],
                            'qty_in_kg'      =>  $value['qty_in_kg'],
                            'amount'        =>  $value['amount']
                             );
                    }
                    else
                    {
                        $product_results[$value['distributor_id']]['distributor_name']=$value['agency_name'].'['.$value['dist_code'].']['.$value['location_name'].']';
                        $product_results[$value['distributor_id']] ['products'][] =array(
                             'invoice_number'=> $value['invoice_number'],
                            'invoice_date'  => $value['invoice_date'],
                            'qty_in_kg'      =>  $value['qty_in_kg'],
                            'amount'        =>  $value['amount']
                             );
                    }
                }
                $data['product_results']=$product_results; 
               $this->load->view('sales/exec_wise_sales_report_print',$data);
        }
    }
    
     public function distributor_sales_report()
    {
         # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="Distributor Sales Report";
        $data['nestedView']['pageTitle'] = 'Distributor Report';
        $data['nestedView']['cur_page'] = 'distributor_sales_report';
        $data['nestedView']['parent_page'] = 'Sales';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'Distributor Sales Report', 'class' => '', 'url' => '');   
         $data['dist']=$this->Sales_model->get_distributor();
        $this->load->view('sales/distributor_sales_report',$data);
    }

    public function distributor_sales_report_print()
    {
        $submit=$this->input->post('search_sales', TRUE);
        $from_date=date('Y-m-d', strtotime($this->input->post('start_date',TRUE)));
        $to_date=date('Y-m-d', strtotime($this->input->post('end_date',TRUE)));
       /* $dist_id=$this->input->post('distributor');
        $data['dist']=$this->Common_model->get_data_row('distributor',array('distributor_id'=>$dist_id));*/
        if($submit!='')
        {   
           $data['from_date']=date('d-m-Y',strtotime($from_date));
           $data['to_date']=date('d-m-Y',strtotime($to_date));
           $dist_sale_results=$this->Sales_model->get_dist_sales_report($from_date,$to_date); 
           $total_percent=0;
           foreach($dist_sale_results as $val)
           {
                $total_percent+=$val['qty_in_kg'];
           }
           $data['total_percent']=$total_percent;
           $data['dist_sale_results']=$dist_sale_results;

             

       
           $this->load->view('sales/distributor_sales_report_print',$data);
        }
    }
}