<?php $this->load->view('commons/main_template',$nestedView); ?>
    <div class="container-fluid">
        <?php 
        $designation_id = $this->session->userdata('designation_id');
        switch(get_logged_user_role())
        {
            case 1: 
                if($designation_id == get_admin_designation())
                {
                    $this->load->view('user_manuals/admin-headoffice.php');
                }
                else if($designation_id == get_executive_designation())
                {
                    $this->load->view('user_manuals/manager_head_ofc.php');
                }
                else if($designation_id == get_deputy_manager_designation())
                {
                    $this->load->view('user_manuals/deputy_manager-headoffice.php');
                }
                else if($designation_id == get_manager_designation())
                {
                    $this->load->view('user_manuals/manager-headoffice.php');
                }
                else if($designation_id == get_vc_designation())
                {
                    $this->load->view('user_manuals/vc_md-headoffice.php');
                }
                break;

            case 2: 
                if($designation_id == get_manager_designation())
                {
                    $this->load->view('user_manuals/manager_ops.php');
                }
                else if($designation_id == get_production_designation())
                {
                    $this->load->view('user_manuals/production_ops.php');
                }
                else if($designation_id == get_lab_technician_designation())
                {
                    $this->load->view('user_manuals/lab_ops.php');
                }
                else if($designation_id == get_weigh_bridge_designation())
                {
                    $this->load->view('user_manuals/weigh_bridge_ops.php');
                }
                else if($designation_id == get_security_designation())
                {
                    $this->load->view('user_manuals/security-ops.php');
                }
                break;

            case 3: 
                if($designation_id == get_manager_designation())
                {
                    $this->load->view('user_manuals/manager_stock_point.php');
                }
                break;

            case 4: 
                if($designation_id == get_manager_designation())
                {
                    $this->load->view('user_manuals/manager-candf.php');
                }
                break;
            case 5: 
                $this->load->view('user_manuals/distributor.php');
                break;
        }?> 

    </div>
<?php $this->load->view('commons/main_footer', $nestedView); ?>