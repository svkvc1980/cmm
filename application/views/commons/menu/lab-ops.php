<li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "home") echo 'active'; ?>">
    <a href="<?php echo SITE_URL; ?>"> Home
        <span class="arrow"></span>
    </a>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "purchase_order") echo 'active'; ?>">
    <a href="javascript:;"> P.O.
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "po_purchase_order") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>po_packing_material" class="nav-link">Purchase Order (Packing Material)</a>
      </li>
      <li class="<?php if($cur_page == "po_free_gift") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>freegift_po" class="nav-link">Purchase Order (Free Gifts)</a>
      </li>
    </ul>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "Logistics") echo 'active'; ?>">
    <a href="javascript:;"> Logistics
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
    <li class="dropdown-submenu <?php if(@$list_page=="quality_check") echo 'active'; ?> ">
      <a href="#" class="nav-link nav-toggle ">
        Quality Check <span class="arrow"></span></a>
        <ul class="dropdown-menu">
          <li class="<?php if($cur_page == "oil_lab_test") echo 'active'; ?>">
            <a href="<?php echo SITE_URL;?>lab_test_report" class="nav-link">Lab Test (Oil)</a>
          </li>
          <li class="<?php if($cur_page == "packing_material_test") echo 'active'; ?>">
            <a href="<?php echo SITE_URL;?>packing_material_test" class="nav-link">Lab Test (Packing Material)</a>
          </li>
        </ul>
    </li>
    </ul>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "mrr_report") echo 'active'; ?>">
    <a href="javascript:;">M.R.R.
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "loose_oil_mrr") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>loose_oil_mrr" class="nav-link">Oil M.R.R.</a>
      </li>
      <li class="<?php if($cur_page == "pm_mrr") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>pm_mrr" class="nav-link">Packing Material M.R.R.</a>
      </li>
      <li class="<?php if($cur_page == "freegift_mrr") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>freegift_mrr" class="nav-link">Free Gift M.R.R.</a>
      </li>
    </ul>
</li>

<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "#") echo 'active'; ?>">
    <a href="javascript:;">Reports
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
    	<li class="dropdown-submenu <?php if(@$list_page=="daily_report") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Daily Reports
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
           	<li class="<?php if($cur_page == "daily_oil_report") echo 'active'; ?>">
        	  <a href="<?php echo SITE_URL;?>oil_report_search" class="nav-link">Daily Oil Report</a>
                </li>
                <li class="<?php if($cur_page == "dw_oil_report_search") echo 'active'; ?>">
        	  <a href="<?php echo SITE_URL;?>dw_oil_report_search" class="nav-link">DateWise Oil Report</a>
                </li>
	        
      		<li class="<?php if($cur_page == "daily_pm_stock_report") echo 'active'; ?>">
                  <a href="<?php echo SITE_URL;?>daily_pm_stock_report_search" class="nav-link">Daily P.M. Stock Report</a>
                </li>
                <li class="<?php if($cur_page == "dw_daily_pm_stock_report_search") echo 'active'; ?>">
                  <a href="<?php echo SITE_URL;?>dw_daily_pm_stock_report_search" class="nav-link">DateWise P.M. Stock Report</a>
                </li>
           </ul>
      </li>
      <li class="dropdown-submenu <?php if(@$list_page=="daily_report") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Consumption Reports
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "production_consumption") echo 'active'; ?>">
            <a href="<?php echo SITE_URL;?>production_consumption" class="nav-link">Production Consumption</a>
                </li>
                <li class="<?php if($cur_page == "leakage_consumption") echo 'active'; ?>">
            <a href="<?php echo SITE_URL;?>leakage_consumption" class="nav-link">Leakage Consumption</a>
                </li>
          
           </ul>
      </li>
      <li class="<?php if($cur_page == "oil_test_r") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>oil_test_r" class="nav-link">Lab Test (Oil)</a>
      </li>
      <li class="<?php if($cur_page == "pm_test_r") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>pm_test_r" class="nav-link">Lab Test (Packing Material)</a>
      </li>
      
      <li class="dropdown-submenu <?php if(@$list_page=="mrr_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
             M.R.R.
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "mrr_loose_oil_list") echo 'active'; ?>">
               <a href="<?php echo SITE_URL;?>mrr_loose_oil_list" class="nav-link">Oils M.R.R. Reports</a>
            </li>
            <li class="<?php if($cur_page == "mrr_pm_list") echo 'active'; ?>">
               <a href="<?php echo SITE_URL;?>mrr_pm_list" class="nav-link">Packing Material M.R.R. Reports</a>
            </li>
            <li class="<?php if($cur_page == "free_gift_mrr_r") echo 'active'; ?>">
               <a href="<?php echo SITE_URL;?>mrr_fg_list" class="nav-link">Free Gift M.R.R. Reports</a>
            </li>
          </ul>
        </li>
        <li class="dropdown-submenu <?php if(@$list_page=="po_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Purchase Order Reports
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "po_oil_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>loose_oil_report" class="nav-link">Oils</a>
            </li>
            <li class="<?php if($cur_page == "po_pm_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>pm_report" class="nav-link">Packing Materials</a>
            </li>
            <li class="<?php if($cur_page == "po_free_gift_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>freegift_po_list" class="nav-link">Free Gifts</a>
            </li>
            
          </ul>
        </li>
      
    </ul>
</li>


