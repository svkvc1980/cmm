<li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "home") echo 'active'; ?>">
    <a href="<?php echo SITE_URL; ?>"> Home
        <span class="arrow"></span>
    </a>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "master") echo 'active'; ?>">
    <a href="javascript:;"> Masters
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="dropdown-submenu <?php if(@$list_page=="ops") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              OPS Masters
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "unit_measure") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>unit_measure" class="nav-link">Unit Measures</a>
            </li>
            <li class="<?php if($cur_page == "capacity") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>capacity" class="nav-link">Denomination</a>
            </li>
            <li class="<?php if($cur_page == "micron") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>micron" class="nav-link">Film Specification</a>
            </li>
            <li class="<?php if($cur_page == "capacity_micron") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>capacity_micron" class="nav-link">Film Distribution</a>
            </li>
            <li class="<?php if($cur_page == "oil_tanker") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>oil_tanker" class="nav-link">Oil Tank </a>
            </li>
            <li class="<?php if($cur_page == "manage_pm_consumption") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>manage_pm_consumption" class="nav-link">Packing Material Consumption Per Product</a>
            </li>
             <li class="<?php if($cur_page == "product_pm_weight") echo 'active'; ?>">
               <a href="<?php echo SITE_URL;?>product_pm_weight" class="nav-link">PM weight per Product</a>
            </li>
            <li class="<?php if($cur_page == "freegift") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>freegift" class="nav-link">Free Gifts</a>
            </li>
          </ul>
      </li>
        <li class="dropdown-submenu <?php if(@$list_page=="lab_test") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Lab Test Masters
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "test_unit") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>test_unit" class="nav-link">Test Unit</a>
            </li>
            <li class="<?php if($cur_page == "loose_oil_lab_test") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>loose_oil_lab_test" class="nav-link">Lab Test (oil)</a>
            </li>
            <li class="<?php if($cur_page == "packing_material_lab_test") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>packing_material_lab_test" class="nav-link">Lab Test (Packing Material)</a>
            </li>
          </ul>
        </li>
    </ul>
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

<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "sales") echo 'active'; ?>">
    <a href="javascript:;">Sales
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "dist_invoice_entry") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>dist_invoice_entry" class="nav-link">Distributor Invoice Entry</a>
      </li>
      <li class="<?php if($cur_page == "plant_invoice_entry") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>plant_invoice_entry" class="nav-link">Unit Invoice Entry</a>
      </li>
            <li class="<?php if($cur_page == "free_sample_list") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>free_sample_list" class="nav-link">Free Samples</a>
      </li>
    </ul>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "Production") echo 'active'; ?>">
    <a href="javascript:;">Production
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "manage_production") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>manage_production" class="nav-link">Production Entry</a>
      </li>
    </ul>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "inventory") echo 'active'; ?>">
    <a href="javascript:;">Inventory
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      
      <li class="<?php if($cur_page == "manage_oil_stock_balance") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>manage_oil_stock_balance" class="nav-link">Daily Stock Balance (Oils)</a>
      </li>
      <li class="<?php if($cur_page == "manage_pm_stock_balance") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>manage_pm_stock_balance" class="nav-link">Daily Stock Balance (Packing Materials)</a>
      </li>

     

    </ul>
</li>

<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "Logistics") echo 'active'; ?>">
    <a href="javascript:;"> Logistics
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "tanker_in") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>tanker_registration" class="nav-link">Vehicle In</a>
      </li>
      <li class="<?php if($cur_page == "weigh_bridge") echo 'active'; ?>">
      <a href="<?php echo SITE_URL;?>weighbridge" class="nav-link">Weigh Bridge</a>
    </li>
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
      <li class="dropdown-submenu <?php if(@$list_page=="mrr") echo 'active'; ?> ">
        <a href="#" class="nav-link nav-toggle ">
          M.R.R. <span class="arrow"></span></a>
          <ul class="dropdown-menu">
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
      <li class="<?php if($cur_page == "gate_pass") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>gate_pass" class="nav-link">Gate Pass</a>
      </li>
      <li class="<?php if($cur_page == "tanker_out") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>tanker_out_details" class="nav-link">Vehicle Out </a>
      </li>
      <li class="<?php if($cur_page == "edit_tanker_details") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>edit_tanker_details" class="nav-link">Edit Vehicle In </a>
      </li>
      <li class="<?php if($cur_page == "gate_pass_delete") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>gate_pass_delete" class="nav-link">Delete Gate Pass </a>
      </li>
    </ul>
</li>

<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "Leakage") echo 'active'; ?>">
    <a href="javascript:;">Leakage
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "wet_cartons_entry") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>wet_cartons_entry" class="nav-link">Wet Entry</a>
      </li>
      <li class="<?php if($cur_page == "leakage_entry") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>leakage_entry" class="nav-link">Leakage Entry</a>
      </li>
      
      <li class="<?php if($cur_page == "processing_loss") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>processing_loss" class="nav-link">Processing Loss Entry</a>
      </li>
    </ul>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "waste_oil") echo 'active'; ?>">
    <a href="javascript:;">Waste Oils
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "waste_oil_entry") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>waste_oil" class="nav-link">Waste Oil Entry</a>
      </li>
      <li class="<?php if($cur_page == "waste_oil_sale") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>waste_oil_sale" class="nav-link">Waste Oil Sale</a>
      </li>
      <li class="<?php if($cur_page == "waste_oil_scrap") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>oil_scrap" class="nav-link">Waste oil scrap</a>
      </li>
    </ul>
</li>



<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "reports") echo 'active'; ?>">
    <a href="javascript:;"> Reports
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
	        <li class="<?php if($cur_page == "daily_product_stock_report") echo 'active'; ?>">
                  <a href="<?php echo SITE_URL;?>daily_stock_report_search" class="nav-link">Daily Product Stock Report</a>
                </li>
                <li class="<?php if($cur_page == "dw_daily_stock_report_search") echo 'active'; ?>">
                  <a href="<?php echo SITE_URL;?>dw_daily_stock_report_search" class="nav-link">DateWise Product Stock Report</a>
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
      <li class="dropdown-submenu <?php if(@$list_page=="master_report") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Masters Report
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "distributor_r") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>distributor_r" class="nav-link">Distributor Report</a>
      </li>
      <li class="<?php if($cur_page == "broker_r") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>broker_report_search" class="nav-link">Broker Report</a>
      </li>
      <li class="<?php if($cur_page == "product_r") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>product_r" class="nav-link">Products Report</a>
      </li>
      <li class="<?php if($cur_page == "supplier_r") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>supplier_view_r" class="nav-link">Supplier Report</a>
      </li>
           </ul>
      </li>
      <li class="dropdown-submenu <?php if(@$list_page=="invoice_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Invoice Reports
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "manage_dist_invoice") echo 'active'; ?>">
	         <a href="<?php echo SITE_URL;?>manage_dist_invoice" class="nav-link">Distributor Invoice List</a>
	      </li>
            <li class="<?php if($cur_page == "plant_invoice") echo 'active'; ?>">
	         <a href="<?php echo SITE_URL;?>manage_plant_invoice" class="nav-link">Unit Invoice List</a>
	      </li>
	      
	      <li class="<?php if($cur_page == "stock_in_transit") echo 'active'; ?>">
	         <a href="<?php echo SITE_URL;?>stock_in_transit" class="nav-link">Stock In Transit</a>
	      </li>
	      <li class="<?php if($cur_page == "stock_transfer_view") echo 'active'; ?>">
	         <a href="<?php echo SITE_URL;?>stock_transfer_view" class="nav-link">Stock Transfer Report</a>
	      </li>
	      <li class="<?php if($cur_page == "stock_dispatch_r") echo 'active'; ?>">
         	<a href="<?php echo SITE_URL;?>stock_dispatch_r" class="nav-link">Daily Dispatched Invoice Report</a>
	      </li>
	      <li class="<?php if($cur_page == "product_wise_daily_dispatches") echo 'active'; ?>">
	         <a href="<?php echo SITE_URL;?>product_wise_daily_dispatches" class="nav-link">Product Wise Daily dispatches</a>
	      </li>
          </ul>
        </li>
       	<li class="dropdown-submenu <?php if(@$list_page=="logistics_report") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Logistics Report
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
           	<li class="<?php if($cur_page == "tanker_register_r") echo 'active'; ?>">
	           <a href="<?php echo SITE_URL;?>tanker_register" class="nav-link">Vehicle Register List</a>
	        </li>
	        <li class="<?php if($cur_page == "weigh_bridge_r") echo 'active'; ?>">
                  <a href="<?php echo SITE_URL;?>weigh_bridge_list" class="nav-link">weigh bridge Report</a>
                </li>
      		<li class="<?php if($cur_page == "oil_test_r") echo 'active'; ?>">
	         <a href="<?php echo SITE_URL;?>oil_test_r" class="nav-link">Lab Test (Oil)</a>
	      </li>
	      <li class="<?php if($cur_page == "pm_test_r") echo 'active'; ?>">
	         <a href="<?php echo SITE_URL;?>pm_test_r" class="nav-link">Lab Test (Packing Material)</a>
	      </li>
	      <li class="<?php if($cur_page == "gate_pass_list") echo 'active'; ?>">
	         <a href="<?php echo SITE_URL;?>gate_pass_list" class="nav-link">Gate Pass Report</a>
	      </li>
	      <li class="<?php if($cur_page == "packing_station_tanker_view") echo 'active'; ?>">
	         <a href="<?php echo SITE_URL;?>packing_station_tanker_view" class="nav-link">Finished Detailed Daily Report</a>
	      </li>
	      <li class="<?php if($cur_page == "packing_station_tanker_abstract_view") echo 'active'; ?>">
	         <a href="<?php echo SITE_URL;?>packing_station_tanker_abstract_view" class="nav-link">Finished Abstract Daily Report</a>
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
        <li class="dropdown-submenu <?php if(@$list_page=="ob_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              O.B. Reports
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
          	<li class="<?php if($cur_page == "single_ob_list") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>single_do_ob_list" class="nav-link">Individual Distributor O.B.</a>
            </li>
            <li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>distributor_ob_list" class="nav-link">Distributor O.B. List</a>
            </li>
            
            <li class="<?php if($cur_page == "single_plant_ob_list") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>single_plant_ob_list" class="nav-link">Individual Unit O.B.</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>plant_ob_list" class="nav-link">Unit O.B. List</a>
            </li>
            <li class="<?php if($cur_page == "product_wise_pending_ob") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>product_wise_pending_ob" class="nav-link">Productwise Pending O.B.</a>
            </li>
          </ul>
        </li>
        <li class="dropdown-submenu <?php if(@$list_page=="do_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              D.O. Reports
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "distributor_do_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>distributor_do_list" class="nav-link">Distributor D.O.</a>
            </li>
            <li class="<?php if($cur_page == "plant_do_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>plant_do_list" class="nav-link">Unit D.O.</a>
            </li>
            <li class="<?php if($cur_page == "product_wise_pending_do") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>product_wise_pending_do" class="nav-link">Productwise Pending D.O.</a>
            </li>
          </ul>
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
        <li class="<?php if($cur_page == "unit_wise_stock") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>unit_wise_stock" class="nav-link">Available Product Stock</a>
      </li> 
      
     <li class="<?php if($cur_page == "product_price_report") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>product_price_report_units" class="nav-link">Product Price At Units</a>
      </li>
      <li class="<?php if($cur_page == "production_report") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>production_report" class="nav-link">Production Report</a>
      </li>
      <li class="<?php if($cur_page == "ops_leakage_r") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>ops_leakage_r" class="nav-link">Leakage Report</a>
      </li>
      <li class="<?php if($cur_page == "processing_loss_report") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>processing_loss_report" class="nav-link">Processing Loss Report</a>
      </li>
    </ul>
</li>


