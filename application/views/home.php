<?php $this->load->view('commons/main_template',$nestedView); ?>
    <div class="container-fluid">
        <?php 
        $designation_id = $this->session->userdata('designation_id');
        switch(get_logged_user_role())
        {
            case 1: 
                if($designation_id == get_admin_designation())
                {
                    $this->load->view('commons/dashboard/admin-headoffice.php');
                }
                else if($designation_id == get_executive_designation())
                {
                    $this->load->view('commons/dashboard/executive-headoffice.php');
                }
                else if($designation_id == get_deputy_manager_designation())
                {
                    //$this->load->view('commons/dashboard/deputy_manager-headoffice.php');
                    $this->load->view('commons/dashboard/executive-headoffice.php');
                }
                else if($designation_id == get_manager_designation())
                {
                    //$this->load->view('commons/dashboard/manager-headoffice.php');
                    $this->load->view('commons/dashboard/executive-headoffice.php');
                }
                else if($designation_id == get_vc_designation())
                {
                    //$this->load->view('commons/dashboard/vc_md-headoffice.php');
                    $this->load->view('commons/dashboard/executive-headoffice.php');
                }
                break;

            case 2: 
                if($designation_id == get_manager_designation())
                {
                    $this->load->view('commons/dashboard/manager-ops.php');
                }
                else if($designation_id == get_production_designation())
                {
                    $this->load->view('commons/dashboard/production-ops.php');
                }
                else if($designation_id == get_lab_technician_designation())
                {
                    $this->load->view('commons/dashboard/lab-ops.php');
                }
                else if($designation_id == get_weigh_bridge_designation())
                {
                    $this->load->view('commons/dashboard/weigh_bridge-ops.php');
                }
                else if($designation_id == get_security_designation())
                {
                    $this->load->view('commons/dashboard/security-ops.php');
                }
                break;

            case 3: 
                if($designation_id == get_manager_designation())
                {
                    $this->load->view('commons/dashboard/manager-stockpoint.php');
                }
                break;

            case 4: 
                if($designation_id == get_manager_designation())
                {
                    $this->load->view('commons/dashboard/manager-candf.php');
                }
                break;
            case 5: 
                $this->load->view('commons/dashboard/distributor.php');
                break;
        }?> 

    </div>
<?php $this->load->view('commons/main_footer', $nestedView); ?>