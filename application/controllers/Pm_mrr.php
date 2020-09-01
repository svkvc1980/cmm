<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';
class Pm_mrr extends Base_controller
{

    public function __construct() 
    {
        parent::__construct();
        $this->load->model("Pm_mrr_m");
    }

    /*
      * Function   : Packing material mrr
      * Developer  :  Prasad created on: 17th Feb 12 PM updated on:      
     */
    public function pm_mrr()
    {       
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']='M.R.R. For Packing Material';  
        $data['nestedView']['pageTitle'] = 'M.R.R. For PM';
        $data['nestedView']['cur_page'] = 'pm_mrr';
        $data['nestedView']['parent_page'] = 'mrr_report';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/mrr_pm_details.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'M.R.R. For Packing Material', 'class' => 'active', 'url' => '');

        $data['flag']=1;
        $this->load->view('mrr/pm_mrr',$data);
    }

    /*
      * Function   :  Retreving details for packing material based on tanker id annd purchase order
      * Developer  :  Prasad created on: 17th Feb 9 PM updated on:      
     */
    public function pm_mrr_details()
    { 
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']="M.R.R. PM Details";
        $data['nestedView']['pageTitle'] = 'M.R.R. For Packing Material Details';
        $data['nestedView']['cur_page'] = 'pm_mrr_details';
        $data['nestedView']['parent_page'] = 'pm_mrr';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/mrr_pm_details.js"></script>';
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'M.R.R. Packing Material', 'class' => '', 'url' => SITE_URL . 'pm_mrr');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'M.R.R. PM Details', 'class' => 'active', 'url' => '');
        
        if($this->input->post('submit'))
        {
            $tanker_number=$this->input->post('tanker_number');
            $po_number=$this->input->post('po_number');
            $tanker_id =$this->Pm_mrr_m->get_tanker_id($tanker_number);
            $po_pm_id= $this->Common_model->get_value('po_pm',array('po_number'=>$po_number),'po_pm_id');
            $pm_id = $this->Common_model->get_value('tanker_pm',array('tanker_id'=>$tanker_id),'pm_id');
            $pm_category_id = $this->Common_model->get_value('packing_material',array('pm_id'=>$pm_id),'pm_category_id');
        
        if($pm_category_id == 8)
        {
        	 if($tanker_id!='' && $po_pm_id != '')
            {
                $qry = "SELECT * FROM po_pm_tanker where po_pm_id='".$po_pm_id."' AND tanker_id ='".$tanker_id."' AND status = 1";
                $count = $this->Common_model->get_no_of_rows($qry);
                if($count==0)
                {
               		$qry = "SELECT * FROM po_pm_tanker where tanker_id ='".$tanker_id."' AND status = 1";
                	$countt = $this->Common_model->get_no_of_rows($qry);
                	if($countt==1)
                	{
                		$update_data = array('po_pm_id' => $po_pm_id);
                		$where1 = array('tanker_id' => $tanker_id);
                		$this->Common_model->update_data('po_pm_tanker',$update_data,$where1);
                	}
                	else
                	{
                		$this->Common_model->insert_data('po_pm_tanker',array('po_pm_id'=>$po_pm_id,'tanker_id'=>$tanker_id,'status'=>1,'created_by'=>$this->session->userdata('user_id'),'created_time'=>date('Y-m-d H:i:s')));
                	}
                
                    
                }

            }
        	
        }
            $tanker_details=$this->Pm_mrr_m->get_pm_tanker_details($tanker_number,$po_number);
            $tanker_count=$tanker_details[0];
            $tanker_results=$tanker_details[1];
            if($tanker_count > 0)
            {  //echo 'hi';  exit;
               //checking tanker register status to generate MRR
               if($tanker_results['status']==1)
               {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <strong>Sorry!</strong>Please complete weighbride gross weight process to generate MRR!
                             </div>');

                redirect(SITE_URL.'pm_mrr');exit;
               }

               elseif($tanker_results['status']==2)
               {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <strong>Sorry!</strong>Please complete lab Test process To generate MRR!
                             </div>');

                redirect(SITE_URL.'pm_mrr');exit;
               }

              elseif($tanker_results['status']==3)
               {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <strong>Sorry!</strong>Please complete weighbride tier weight process to generate MRR!
                             </div>');

                redirect(SITE_URL.'pm_mrr');exit;
               }

               elseif($tanker_results['status']==5)
               {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <strong>Sorry!</strong>MRR is already generated.!
                             </div>');

                redirect(SITE_URL.'pm_mrr');exit;
               }

               elseif($tanker_results['status']==6)
               {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <strong>Sorry!</strong>MRR is already generated.tanker is registered out!
                             </div>');

                redirect(SITE_URL.'pm_mrr');exit;
               }

                elseif($tanker_results['status']==10)
               {
                    $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <strong>Sorry!</strong>Lab test is failed.MRR will not be generated!
                             </div>');

                redirect(SITE_URL.'pm_mrr');exit;
               }

               else
               {	
                    $mrr_results=$this->Pm_mrr_m->get_mrr_pm_details($tanker_results['tanker_id']);
                   
                    $data['mrr_results']=$mrr_results;
                    $data['flag']=2;
                    //Retreving Max mrr number from mrr_pm
                    $data['mrr_number']=get_current_serial_number(array('value'=>'mrr_number','table'=>'mrr_pm','where'=>'created_time'));

                    //retreving packing material id
                    $data['film_id']=get_pm_film_id();
                    if($mrr_results['pm_category_id']==get_film_cat_id())
                    {
                        $data['micron']=$this->Common_model->get_data('micron',array('status'=>1));
                    }
                    //print_r($data['mrr_results']);exit;
                    $this->load->view('mrr/pm_mrr',$data);
                    
               }

            }

            else
            {
               $this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
                                <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                <strong>Sorry!</strong> Invalid Tanker Registration Number Or PO is completed!
                             </div>');

               redirect(SITE_URL.'pm_mrr'); exit;
            }
        }
    }

    /*
      * Function   :  Insertion of MRR details for Packing material
      * Developer  :  Prasad created on: 12th Feb 9 PM updated on:      
    */

    public function insert_pm_mrr_details()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['heading']=" M.R.R. for Packing Material details";
        $data['nestedView']['pageTitle'] = 'M.R.R. for Packing Material details';
        $data['nestedView']['cur_page'] = 'pm_mrr';
        $data['nestedView']['parent_page'] = 'mrr_report';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
       /* $data['nestedView']['js_includes'][] = '<script type="text/javascript" src="' . assets_url() . 'pages/scripts/price_updation.js"></script>';*/
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MRR for Packing Material', 'class' => '', 'url' => SITE_URL . 'pm_mrr');
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'MRR Details', 'class' => 'active', 'url' => '');

        if($this->input->post('submit'))
        {   
            $tanker_id =  $this->input->post('tanker_id');
            $po_status= $this->input->post('po_status');
            $po_pm_id = $this->input->post('po_pm_id');
          
            $plant_id=$this->session->userdata('ses_plant_id');
            
            //retreving mrr Packing Material details
            $mrr_results=$this->Pm_mrr_m->get_mrr_pm_details($tanker_id);
            
            $net_weight=$mrr_results['net_weight'];
            

            if($mrr_results['pm_category_id']==get_film_cat_id())
            {  
              $micron_id=   $this->input->post('micron');
              $core_weight=   $this->input->post('core_weight');
              $rolls=   $this->input->post('rolls');
              $carton_weight=   $this->input->post('carton_weight');
              $received_weight=$net_weight; 
            }
            elseif($mrr_results['pm_id']==get_tape_650mt() || $mrr_results['pm_id']==get_tape_65mt())
            {    
                $qty=$this->input->post('received_qty');
                $preference=$this->Common_model->get_data_row('preference',array('name'=>$mrr_results['pm_id']));
                $received_weight=$qty*$preference['value'];

                $data['total_meters']=$received_weight;
               
            }
            else
            {
              $received_weight= $this->input->post('received_qty');
              $qty = $received_weight;
            }
            $quantity=$received_weight;
            //Retreving Max mrr number from mrr_pm
            $mrr_number=get_current_serial_number(array('value'=>'mrr_number','table'=>'mrr_pm','where'=>'created_time'));
            $dat=array(
              'mrr_number'       =>  $mrr_number,
              'tanker_pm_id'     =>  $this->input->post('tanker_pm_id'),
              'folio_number'     =>  $this->input->post('folio_number'),
              'ledger_number'    =>  $this->input->post('ledger_number'),
              'received_qty'     =>  $received_weight,
              'remarks'          =>  $this->input->post('remarks'),
              'mrr_date'         =>  date('Y-m-d'),
              'created_by'       =>  $this->session->userdata('user_id')
              );

          
          

           
           //retreving data from plant pm
          // $quantity=$this->Common_model->get_value('plant_pm',array('pm_id'=>$mrr_results['pm_id'],'plant_id'=>$plant_id),'quantity');
            /*if($mrr_results['pm_id']==get_tape_650mt() || $mrr_results['pm_id']==get_tape_65mt() ) 
            {
                $preference=$this->Common_model->get_data_row('preference',array('name'=>$mrr_results['pm_id']));
                $qty1=$this->input->post('received_qty');
                $meters=$qty1*$preference['value'];
                $data['total_meters']=$meters;
                $quantity=$meters;

            } 
            elseif($mrr_results['pm_category_id']==get_film_cat_id()) 
            {   
                $received_weight=$net_weight-($rolls*($core_weight+$carton_weight));
                $invoice_net_weight=$this->input->post('invoice_net_weight');
                if($invoice_net_weight <= $received_weight)
                {
                    $quantity=$invoice_net_weight;
                }
                else
                {
                    $quantity=$received_weight;
                }
            }
            else
            {
                $quantity=$dat['received_qty'];
            }*/
          //Retreving receipts weight in stock list based on plantid,date,pm id
            /*$results=$this->Pm_mrr_m->get_receipt_weight_stock_list($mrr_results);
            $receipts=$results['receipts'];
            if($mrr_results['pm_id']==get_tape_650mt() || $mrr_results['pm_id']==get_tape_65mt() ) 
            {
                $receipts+=$dat['received_qty'];
            } 
            elseif($mrr_results['pm_category_id']==get_film_cat_id())
            {   
                $received_weight=$net_weight-($rolls*($core_weight+$carton_weight));
                $invoice_net_weight=$this->input->post('invoice_net_weight');
                if($invoice_net_weight <= $received_weight)
                {
                    $receipts+=$invoice_net_weight;
                }
                else
                {
                    $receipts+=$received_weight;
                }
            } 
            else
            {
                $receipts+=$dat['received_qty'];
            }*/    
            $this->db->trans_begin();
            $mrr_pm_id = $this->Pm_mrr_m->insert_mrr_pm_details($dat);
            
             if($mrr_results['pm_id']==get_tape_650mt() || $mrr_results['pm_id']==get_tape_65mt() ) 
            {
                $preference=$this->Common_model->get_data_row('preference',array('name'=>$mrr_results['pm_id']));
                $data['meters']=$preference['value'];
            } 
            else
            {
                $data['meters']=1;
            }
            $this->Common_model->update_data('tanker_register',array('status' =>5),array('tanker_id'=>$tanker_id));
            $this->Common_model->update_data('po_pm',array('status' =>$po_status),array('po_pm_id'=>$po_pm_id));
            
              //updating data in stock list if type is tape
            if($mrr_results['pm_category_id']==get_film_cat_id()) 
            {   
                $received_weight=$net_weight-($rolls*($core_weight+$carton_weight));
                $invoice_quantity=$this->input->post('invoice_quantity');
                if($invoice_quantity <= $received_weight)
                {
                    $qty=$invoice_quantity;
                }
                else
                {
                    $qty=$received_weight;
                }

                $quantity = $qty;
                $core_carton_weight=$core_weight+$carton_weight;
                $dat1=array(
                    'mrr_pm_id'=>$mrr_pm_id,
                    'micron_id'=>$micron_id,
                    'received_quantity'=>$qty,
                    'core_carton_weight'=>$core_carton_weight,
                    'no_of_rolls'=>$rolls
                    );
                $dat2=array(
                  'pm_id'=>$mrr_results['pm_id'],
                  'micron_id'=>$micron_id,
                  'plant_id'=>$plant_id,
                  'quantity'=>$qty
                  );
                $this->Common_model->insert_data('mrr_pm_film',$dat1);
                //echo $this->db->last_query();
                //exit;
                $this->Pm_mrr_m->update_plant_film_stock($dat2);
                //echo $this->db->last_query();//exit;
            }
            // retreving received qty for that particular mrr.
            $data['mrr_received_qty']=$this->Pm_mrr_m->get_mrr_received_qty($mrr_pm_id,$mrr_results['pm_category_id']);
            //retreving pending qty for that particular po
            $data['pm_received_qty']=$this->Pm_mrr_m->get_pm_received_qty($mrr_results['po_pm_id'],$mrr_results['pm_category_id']);
            //updating data in plant pm
            $plant_pm=array(
                'pm_id'=>$mrr_results['pm_id'],
                'plant_id'=>$plant_id,
                'updated_time'=>date('Y-m-d H:i:s'),
                'quantity'=>$quantity
                );
            $this->Pm_mrr_m->update_plant_pm($plant_pm);
            //echo $this->db->last_query();
            // check entry exist in pm_stock_balance
            $this->db->where('plant_id',$mrr_results['plant_id']);
            $this->db->where('pm_id',$mrr_results['pm_id']);
            $this->db->where('closing_balance is null');
            $this->db->from('pm_stock_balance');
            $res = $this->db->get();
            if($res->num_rows()>0)
            {
              //updating data in pm stock balance
              $this->db->set('receipts', 'receipts+'.$quantity, FALSE);
              $this->db->where('plant_id',$mrr_results['plant_id']);
              $this->db->where('pm_id',$mrr_results['pm_id']);
              $this->db->where('closing_balance is null');
              $this->db->order_by('on_date','desc');
              $this->db->limit(1);
              $this->db->update('pm_stock_balance');
            }
            else
            {
              // Insert data in pm stock balance
              $pm_data = array('pm_id' => $mrr_results['pm_id'],
                               'plant_id' => $mrr_results['plant_id'],
                               'opening_balance'  => 0,
                               'receipts' => $quantity,
                               'on_date'  => date('Y-m-d'),
                               'status' =>  1,
                               'created_by' => $this->session->userdata('user_id'),
                               'created_time' => date('Y-m-d H:i:s')
                               );
              $this->Common_model->insert_data('pm_stock_balance',$pm_data);
            }
            //echo $this->db->last_query();exit;
            //$this->Common_model->update_data('pm_stock_balance',array('receipts' =>$receipts),array('pm_stock_balance_id'=>$results['pm_stock_balance_id']));

            if($this->db->trans_status()===FALSE)
            {
              $this->db->trans_rollback();
            }
            else
            {
              $this->db->trans_commit();
              $this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                <strong>Success!</strong>PM M.R.R. are inserted successfully! </div>');

            }
           
            //retreving mrr Material ledger details
            $data['mrr_details']=$this->Common_model->get_data_row('mrr_pm',array('mrr_pm_id'=>$mrr_pm_id));
           

            $data['flag']=3;
             $data['mrr_results']=$mrr_results;
            $this->load->view('mrr/pm_mrr',$data);
        }
    }

    public function download_pm_mrr()
     {
        if($this->input->post('download')!='')
        {
            $tanker_id   = $this->input->post('tanker_id');
            $mrr_pm_id  = $this->input->post('mrr_pm_id');

            //retreving mrr Packing Material details
            $mrr_results=$this->Pm_mrr_m->get_mrr_pm_details($tanker_id);
           
           //retreving mrr Material ledger details
            $mrr_details=$this->Common_model->get_data_row('mrr_pm',array('mrr_pm_id'=>$mrr_pm_id));
            //retreving pending qty for that particular po
            $pm_received_qty=$this->Pm_mrr_m->get_pm_received_qty($mrr_results['po_pm_id'],$mrr_results['pm_category_id']);
            
             // retreving received qty for that particular mrr.
            $mrr_received_qty=$this->Pm_mrr_m->get_mrr_received_qty($mrr_pm_id,$mrr_results['pm_category_id']);
            if($mrr_results['pm_id']==get_tape_650mt() || $mrr_results['pm_id']==get_tape_65mt() ) 
            {
                $preference=$this->Common_model->get_data_row('preference',array('name'=>$mrr_results['pm_id']));
                $meters=$preference['value'];
            } 
            else
            {
                $meters=1;
            }
            if($mrr_results['pm_category_id']==get_film_cat_id())
            {
                $units='Kgs';
            } 
            elseif($mrr_results['pm_id']==get_tape_650mt() || $mrr_results['pm_id']==get_tape_65mt())
            {
                $units='Units';
            }
            else
            {
                $units='units';
            }
                        
            $header = '';
            $data ='';

            $data = '<table border="1">';
            $data.= '<thead>';
            $data.='<h3 align="center"> Material Receipt Report(MRR)</h3>';
            $data.='</thead>';
            $data.='<tbody>';
            $data.='<tr>';
            $data.='<td><b>MRR Reference Number : </b>'.$mrr_details['mrr_number'].'</td>';
            $data.='<td><b>Tanker Register Number : </b>'. $mrr_results['tanker_number'].'</td>';  
            $data.='<td><b>PO Number : </b>'.$mrr_results['po_number'].'</td>'; 
            $data.='<td><b>Date : </b>'.date('d-m-Y').'</td>';                           
            $data.='</tr>';

            $data.='<tr>';
            $data.='<td><b>Invoice Number : </b>'.$mrr_results['invoice_number'].'</td>';
            $data.='<td><b>Loose Oil : </b>'. $mrr_results['packing_material_name'].'</td>';  
            $data.='<td><b>Supplier: </b>'.$mrr_results['supplier_name'].'</td>';
            $data.='<td><b>Quoted Quantity: </b>'.$mrr_results['pp_quantity'].$units.'</td>';                           
            $data.='</tr>';

            $data.='<tr>';
            
            $data.='<td><b>Received Qty : </b>'.($mrr_received_qty/$meters).$units.'</td>'; 
            $data.='<td><b>Unit Name : </b>'.$mrr_results['plant_name'].'</td>';
            if($mrr_results['pp_quantity'] >= ($pm_received_qty/$meters)) { 
                $data.='<td><b>Pending Quantity :</b>'.($mrr_results['pp_quantity']- ($pm_received_qty/$meters)).$units.'</td> ';
             } else { 
                $data.='<td ><b>Exceeded Quantity :</b>'.(($pm_received_qty/$meters)- $mrr_results['pp_quantity']).$units.'</td>';
             } 
            
            $data.='<td><b>PO Date : </b>'.$mrr_results['po_date'].'</td>'; 
            $data.='</tr>';

            $data.='<tr>';
            $data.='<td><b>Unit Price : </b>'. $mrr_results['unit_price'].'</td>';
            $data.='<td><b>Gross Weight : </b>'.$mrr_results['gross_weight'].' Kgs'.'</td>'; 
            $data.='<td><b>Tier Weight : </b>'.$mrr_results['tier_weight'].' Kgs'.'</td>';   
            $data.='<td><b>Net Quantity : </b>'. $mrr_results['net_weight'].' Kgs'.'</td>'; 
            $data.='</tr>';

            $data.='<tr>';
            $data.='<td><b>Ledger Number : </b>'.$mrr_details['ledger_number'].'</td>';
            $data.='<td><b>Folio Number : </b>'. $mrr_details['folio_number'].'</td>';
            $data.='<td><b>DC Number : </b>'.$mrr_results['dc_number'].'</td>';
            $data.='<td><b>Vehicle Number: </b>'.$mrr_results['vehicle_number'].'</td>'; 
            $data.='</tr>';

            if($mrr_details['remarks'] !='')
            {
               $data.='<tr>';
               $data.='<td colspan="2"><b>Ledger Number : </b>'.$mrr_details['remarks'].'</td>';
               $data.='<td colspan="2"><b>Purchase Mode : </b>'.$mrr_results['purchase_type'].'</td>';  
               $data.='</tr>';
            }

            $data.='</tbody>';
            $data.='</table>';
            $data.='</div>';
            $data.='</div>';
            $time = date("Ymdhis");
            $xlFile='Packing_material_MRR_'.$time.'.xls'; 
            header("Content-type: application/x-msdownload");
            header("Content-Disposition: attachment; filename=".$xlFile."");
            header("Pragma: no-cache");
            header("Expires: 0");
            echo $data;
        }
     }

      /*
      * Function   : List of MRR's for pm
      * Developer  :  Prasad created on: 27th Feb 10:30 AM updated on:      
    */
    public function mrr_pm_list()
    {
        # Data Array to carry the require fields to View and Model
        $data['nestedView']['pageTitle']="M.R.R. For PM List";
        $data['nestedView']['heading'] = 'M.R.R. For Packing Material List';
        $data['nestedView']['cur_page'] = 'pm_mrr';
        $data['nestedView']['parent_page'] = 'mrr_report';

        # Load JS and CSS Files
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['js_includes'] = array();
        $data['nestedView']['css_includes'] = array();

        # Breadcrumbs
        $data['nestedView']['breadCrumbOptions'] = array(array('label' => 'Home', 'class' => '', 'url' => SITE_URL . 'home'));
        $data['nestedView']['breadCrumbOptions'][] = array('label' => 'M.R.R. PM List', 'class' => '', 'url' => '');
        
        # Search Functionality
        $psearch=$this->input->post('search_oil', TRUE);
        if($psearch!='') {
        $search_params=array(
                        'po_number'            =>   $this->input->post('po_number', TRUE),
                        'mrr_number'           =>   $this->input->post('mrr_number',TRUE),
                        'start_date'           =>   $this->input->post('start_date', TRUE),
                        'end_date'             =>   $this->input->post('end_date',TRUE),
                        'tanker_in_number'     =>   $this->input->post('tanker_in_number')
                              );
         $this->session->set_userdata($search_params);
        } else {
            
            if($this->uri->segment(2)!='')
            {
            $search_params=array(
                        'po_number'         =>   $this->session->userdata('po_number'),
                        'mrr_number'         =>   $this->session->userdata('mrr_number'),
                        'start_date'         =>    $this->session->userdata('start_date'),
                        'end_date'         =>   $this->session->userdata('end_date'),
                        'tanker_in_number'   =>   $this->session->userdata('tanker_in_number')
                              );
            }
            else {
                $search_params=array(
                        'po_number'         =>  '',
                        'mrr_number'        =>  '',
                        'start_date'        =>  '',
                        'end_date'          =>  '',
                        'tanker_in_number'  =>  ''
                                  );
                 $this->session->set_userdata($search_params);
            }
            
        }
        $data['search_params'] = $search_params;
        
         # Default Records Per Page - always 10
        /* pagination start */
        $config = get_paginationConfig();
        $config['base_url'] = SITE_URL . 'mrr_pm_list/';
        # Total Records
        $config['total_rows'] = $this->Pm_mrr_m->get_pm_mrr_list_total_num_rows($search_params);

        $config['per_page'] = getDefaultPerPageRecords();
        $data['total_rows'] = $config['total_rows'];
        $this->pagination->initialize($config);
        $data['pagination_links'] = $this->pagination->create_links();
        $current_offset = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        if ($data['pagination_links'] != '') {
            $data['last'] = $this->pagination->cur_page * $config['per_page'];
            if ($data['last'] > $data['total_rows']) {
                $data['last'] = $data['total_rows'];
            }
            $data['pagermessage'] = 'Showing ' . ((($this->pagination->cur_page - 1) * $config['per_page']) + 1) . ' to ' . ($data['last']) . ' of ' . $data['total_rows'];
        }
        $data['sn'] = $current_offset + 1;
        /* pagination end */

        # Loading the data array to send to View
        $data['view_mrr_list_results'] = $this->Pm_mrr_m->view_pm_mrr_list_results($search_params, $config['per_page'] ,$current_offset);
        //print_r( $data['view_mrr_list_results']);exit;
        # Additional data
        
        $data['flag']=1;
        $this->load->view('mrr/mrr_pm_list',$data);        
    }

    public function print_mrr_pm_list()
    {
        # Search Functionality
        $psearch=$this->input->post('print_mrr_pm_list', TRUE);
        if($psearch!='') {
        $search_params=array(
                        'po_number'            =>   $this->input->post('po_number', TRUE),
                        'mrr_number'           =>   $this->input->post('mrr_number',TRUE),
                        'start_date'           =>   $this->input->post('start_date', TRUE),
                        'end_date'             =>   $this->input->post('end_date',TRUE),
                        'tanker_in_number'     =>   $this->input->post('tanker_in_number')
                              );
         $this->session->set_userdata($search_params);
        } 
        $data['search_params'] = $search_params;

        $data['mrr_pm_results'] = $this->Pm_mrr_m->print_mrr_pm_list($search_params);
        $this->load->view('mrr/print_mrr_pm_list',$data);        
    }
}