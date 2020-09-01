<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once 'Base_controller.php';


class Page extends Base_controller {

	public function __construct() 
	{
        parent::__construct();
		$this->load->model("Page_model");
	}

	
	public function pageList()
	{
		# Data Array to carry the require fields to View and Model
		$data['nestedView']['heading'] = "Manage Pages";
		$data['nestedView']['cur_page'] = 'page';
		$data['nestedView']['parent_page'] = 'page';
		
		# Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['css_includes'] = array();
		
		# Breadcrumbs
		$data['nestedView']['pageTitle'] = 'Manage Pages';
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Manage Pages','class'=>'active','url'=>'');
		
		# Search Functionality
		$psearch=$this->input->post('searchPage', TRUE);
		if($psearch!='') {
		$searchParams=array(
					  'pageName'=>$this->input->post('pageName', TRUE)
					 		  );
		$this->session->set_userdata($searchParams);
		} else {
			
			if($this->uri->segment(2)!='')
			{
			$searchParams=array(
					  'pageName'=>$this->session->userdata('pageName')
							  );
			}
			else {
				$searchParams=array(
					  'pageName'=>''
					  			  );
				$this->session->unset_userdata(array_keys($searchParams));
			}
			
		}
		$data['searchParams'] = $searchParams;
		
		/* pagination start */
		$config = get_paginationConfig();
		$config['base_url'] = SITE_URL.'page/'; 
		# Total Records
	    $config['total_rows'] = $this->Page_model->pageTotalRows($searchParams);
		//echo $config['total_rows'];
		$config['per_page'] = getDefaultPerPageRecords();
		$data['total_rows'] = $config['total_rows'];
        $this->pagination->initialize($config);
		$data['pagination_links'] = $this->pagination->create_links(); 
		$current_offset = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
		if($data['pagination_links']!= '') {
			$data['last']=$this->pagination->cur_page*$config['per_page'];
			if($data['last']>$data['total_rows']){
				$data['last']=$data['total_rows'];
			}
			$data['pagermessage'] = 'Showing '.((($this->pagination->cur_page-1)*$config['per_page'])+1).' to '.($data['last']).' of '.$data['total_rows'];
         } 
		 $data['sn'] = $current_offset + 1;
		/* pagination end */
		
		# Search Results
	   	$data['pageSearch'] = $this->Page_model->pageResults($searchParams,$config['per_page'], $current_offset);
	   //	print_r($data['pageSearch']); exit;
		$data['displayList'] = 1;
		$this->load->view('page/pageView', $data);

	}

	public function addPage()
	{
		# Data Array to carry the require fields to View and Model
		$data['nestedView']['heading'] = "Manage Page";
		$data['nestedView']['cur_page'] = 'page';
		$data['nestedView']['parent_page'] = 'page';
		
		# Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'custom/js/page.js"></script>';
		$data['nestedView']['css_includes'] = array();
		
		# Breadcrumbs
		$data['nestedView']['pageTitle'] = 'Manage Page';
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Manage Page','class'=>'active','url'=>SITE_URL.'page');
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Add Page','class'=>'active','url'=>'');

		$data['flg'] = 1;
		$data['val'] = 0;
		# Load page with all shop details
		$this->load->view('page/pageView', $data);


	}

	public function editPage($encoded_id)
	{
		# Data Array to carry the require fields to View and Model
		$data['nestedView']['heading'] = "Manage Page";
		$data['nestedView']['cur_page'] = 'page';
		$data['nestedView']['parent_page'] = 'page';
		
		# Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['js_includes'][] = '<script type="text/javascript" src="'.assets_url().'custom/js/page.js"></script>';
		$data['nestedView']['css_includes'] = array();
		
		# Breadcrumbs
		$data['nestedView']['pageTitle'] = 'Manage Page';
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Manage Page','class'=>'active','url'=>SITE_URL.'page');
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Edit Page','class'=>'active','url'=>'');
		//echo $encoded_id.'-->'.cmm_decode($encoded_id); exit;
		if(@cmm_decode($encoded_id)!='')
		{
			
			$value = @cmm_decode($encoded_id);
			$where = array('page_id' => $value);
			$data['pageEdit'] = $this->Common_model->get_data('page', $where);
			//print_r($data['pageEdit']); exit;
			//$data['companyEdit'] = $this->AdminModel->editCompanyDetails($value);
		}
		//$this->validateEditUrl(@$data['pageEdit'],'page');
		$data['flg'] = 1;
		$data['val'] = 1;
		# Load page with all shop details
		$this->load->view('page/pageView', $data);
	}

	public function deletePage($encoded_id)
	{
		$page_id=@cmm_decode($encoded_id);
		$where = array('page_id' => $page_id);
		$dataArr = array('status' => 2);
		$this->Common_model->update_data('page',$dataArr, $where);
		
		$this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
								<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								
								<strong>Success!</strong> Page has been De-Activated successfully!
							 </div>');
		redirect(SITE_URL.'page');
	}

	public function activatePage($encoded_id)
	{
		$page_id=@cmm_decode($encoded_id);
		$where = array('page_id' => $page_id);
		$dataArr = array('status' => 1);
		$this->Common_model->update_data('page',$dataArr, $where);
		
		$this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
								<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
								
								<strong>Success!</strong> Page has been Activated successfully!
							 </div>');
		redirect(SITE_URL.'page');
	}

	public function pageAdd()
	{
		if($this->input->post('submitPage') != "")
		{
			//print_r($_POST);
			$page_id = $this->input->post('page_id');
			$dataArr = array(
					'name' => $this->input->post('page_name'));
			//$dataArr = $_POST[];
			if($page_id == "")
			{
				$dataArr['created_by'] = $this->session->userdata('user_id');
				$dataArr['created_time'] = date('Y-m-d H:i:s');
				//Insert
				$this->Common_model->insert_data('page',$dataArr);
				
				$this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
										<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
										
										<strong>Success!</strong> Page has been added successfully!
									 </div>');
			}
			else
			{	
				$dataArr['modified_by'] = $this->session->userdata('user_id');
				$dataArr['modified_time'] = date('Y-m-d H:i:s');
				$where = array('page_id' => $page_id);

				//Update
				$this->Common_model->update_data('page',$dataArr, $where);
				//echo $this->db->last_query();
				$this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
										<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
										
										<strong>Success!</strong> Page has been updated successfully!
									 </div>');
			}
			redirect(SITE_URL.'page');
		}
	}

	public function downloadPage()
	{
		if($this->input->post('downloadPage')!='') {
			
			$searchParams=array( 'pageName'=>$this->input->post('pageName', TRUE));
			$pages = $this->Page_model->pageDetails($searchParams);
			
			$header = '';
			$data ='';
			$titles = array('Page ID','Page','Created Time', 'Created By', 'Modified By','Modified Time');
			$data = '<table border="1">';
			$data.='<thead>';
			$data.='<tr>';
			foreach ( $titles as $title)
			{
				$data.= '<th>'.$title.'</th>';
			}
			$data.='</tr>';
			$data.='</thead>';
			$data.='<tbody>';
			 $j=1;
			if(count($pages)>0)
			{
				
				foreach($pages as $page)
				{
					$data.='<tr>';
					$data.='<td align="center">'.$page['page_id'].'</td>';
					$data.='<td>'.$page['name'].'</td>';
					$data.='<td>'.DateFormatAM($page['created_time']).'</td>';
					$data.='<td>'.$page['created_user'].'</td>';
					$data.='<td>'.$page['modified_user'].'</td>';
					$data.='<td>'.DateFormatAM($page['modified_time']).'</td>';
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
			$xlFile='page_'.$time.'.xls'; 
			header("Content-type: application/x-msdownload"); 
			# replace excelfile.xls with whatever you want the filename to default to
			header("Content-Disposition: attachment; filename=".$xlFile."");
			header("Pragma: no-cache");
			header("Expires: 0");
			echo $data;
			
		}
	}

	//26th july 2016 02:52 PM , updated 28th july 2016 06:00 pm
	public function role_page_mapping(){

		# Data Array to carry the require fields to View and Model
		$data['nestedView']['heading'] = "Manage Block Designation Page Mapping";
		$data['nestedView']['cur_page'] = 'page';
		$data['nestedView']['parent_page'] = 'page';
		
		# Load JS and CSS Files
		$data['nestedView']['js_includes'] = array();
		$data['nestedView']['css_includes'] = array();
		
		# Breadcrumbs
		$data['nestedView']['pageTitle'] = 'Manage Role Page Mapping';
		$data['nestedView']['breadCrumbOptions'] = array( array('label'=>'Home','class'=>'','url'=>SITE_URL.'home'));
		$data['nestedView']['breadCrumbOptions'][] = array('label'=>'Role Page Mapping','class'=>'active','url'=>'');
		
		# Search Functionality
		$psearch=$this->input->post('action', TRUE);
		if($psearch!='') {
		$searchParams=array(
					  'block_designation_id'=>$this->input->post('block_designation_id', TRUE)
					 		  );
		$this->session->set_userdata($searchParams);
		} else {
			
			if($this->uri->segment(2)!='')
			{
			$searchParams=array(
					  'block_designation_id'=>$this->session->userdata('block_designation_id')
							  );
			}
			else {
				$searchParams=array(
					  'block_designation_id'=>''
					  			  );
				$this->session->unset_userdata(array_keys($searchParams));
			}
			
		}
		$data['block_designation_id'] = @$searchParams['block_designation_id'];
		//$data['cur_role_id'] = @$this->input->post('role_id', TRUE);
		$bd_pages = array();
		if(@$data['block_designation_id']>0){
			//Get current role mapped pages
			$results = $this->Common_model->get_data('block_designation_page',array('block_designation_id'=>@$data['block_designation_id'],'status'=>1));
			foreach ($results as $bdp_row) {
				$bd_pages[]=$bdp_row['page_id'];
			}

		}
		$data['bd_pages'] = $bd_pages;

		# Search Results
		$pqry = 'SELECT * FROM page WHERE status = 1 ORDER BY page_id';
		$pres = $this->db->query($pqry);
		$data['pageSearch'] = $pres->result_array();

	   	// get roles not including super user
	   	$data['block_designation_list'] = $this->Page_model->get_block_designation();
	   //	print_r($data['pageSearch']); exit;
		$data['displayList'] = 1;
		$this->load->view('page/role_page_mapping', $data);
	}

	//mahesh 28th july 2016 06:53 pm
	public function submit_rolePageMapping(){

		if($this->input->post('save_changes')!=''){
			$this->db->trans_begin();
			$block_designation_id = $this->input->post('block_designation_id');
			// remove existed mapped pages
			$this->Common_model->update_data('block_designation_page',array('status'=>2),array('block_designation_id'=>$block_designation_id));
			// insert current checked pages
			$pages = $this->input->post('page');
			if($pages){
				$batch_data = array();
				//looping 
				foreach ($pages as $page_id) 
				{
					$qry = "INSERT INTO block_designation_page(block_designation_id,page_id,status) 
                    VALUES (".$block_designation_id.",".$page_id.",1)  
                    ON DUPLICATE KEY UPDATE status = VALUES(status);";
                    $this->db->query($qry);

				}

				if ($this->db->trans_status() === FALSE)
				{
						$this->db->trans_rollback();
						$this->session->set_flashdata('response','<div class="alert alert-danger alert-dismissable">
											<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
											
											<strong>Error!</strong> There\'s a problem occured while saving role page mapping!
										 </div>');
						
				}
				else
				{
					$this->db->trans_commit();
					$this->session->set_flashdata('response','<div class="alert alert-success alert-dismissable">
											<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
											
											<strong>Success!</strong> Changes have been saved successfully!
										 </div>');
				}
			}
		}

		redirect(SITE_URL.'rolePageMapping/1');
	}

	/**
	* check page exist or not
	* author: mahesh , created on: 26th july 2016 02:35 PM, updated on: --
	* @param: $page_name(string)
	* @param: $page_id(int)
	* return: 1/0(boolean)
	**/
	function is_pageAlreadyExist(){
		$page_name = $this->input->post('page_name');
		$page_id = $this->input->post('page_id');

		$this->db->select();
		$this->db->where('name',$page_name);
		if($page_id!='')
		$this->db->where('page_id<>',$page_id);
		$query = $this->db->get('page');
		echo ($query->num_rows()>0)?1:0;
  	}

}