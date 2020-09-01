<li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "home") echo 'active'; ?>">
    <a href="<?php echo SITE_URL; ?>">Home
        <span class="arrow"></span>
    </a>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "master") echo 'active'; ?>">
    <a href="javascript:;"> Masters
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
    	<li class="dropdown-submenu <?php if(@$list_page=="user_master") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              User Masters
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
          	<li class="<?php if($cur_page == "user") echo 'active'; ?>">
	          <a href="<?php echo SITE_URL;?>user" class="nav-link">Add User</a>
	        </li>
              <li class="<?php if($cur_page == "broker") echo 'active'; ?>">
        	<a href="<?php echo SITE_URL;?>add_broker" class="nav-link">Broker </a>
	      </li>
	      <li class="<?php if($cur_page == "broker_list") echo 'active'; ?>">
	        <a href="<?php echo SITE_URL;?>broker" class="nav-link">Broker List</a>
	      </li>
	       <li class="<?php if($cur_page == "supplier") echo 'active'; ?>">
	        <a href="<?php echo SITE_URL;?>add_supplier" class="nav-link">Supplier </a>
	      </li>
	      <li class="<?php if($cur_page == "supplier_list") echo 'active'; ?>">
	        <a href="<?php echo SITE_URL;?>supplier" class="nav-link">Supplier List</a>
	      </li>
	      <li class="<?php if($cur_page == "distributor") echo 'active'; ?>">
	        <a href="<?php echo SITE_URL;?>distributor_selection" class="nav-link">Distributor </a>
	      </li>
	       <li class="<?php if($cur_page == "distributor_list") echo 'active'; ?>">
	        <a href="<?php echo SITE_URL;?>distributor" class="nav-link">Distributor List</a>
	      </li>
	      <li class="<?php if($cur_page == "executive") echo 'active'; ?>">
	        <a href="<?php echo SITE_URL;?>executive" class="nav-link">Executive </a>
	      </li>
            
          </ul>
      </li>
      <li class="dropdown-submenu <?php if(@$list_page=="product") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Product
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "loose_oil") echo 'active'; ?>">
            <a href="<?php echo SITE_URL;?>loose_oil" class="nav-link">Loose Oils</a>
            </li>
            <li class="<?php if($cur_page == "packing_material_category") echo 'active'; ?>">
            <a href="<?php echo SITE_URL;?>packing_material_category" class="nav-link">Packing Material Category</a>
            </li>

            <li class="<?php if($cur_page == "packing_material") echo 'active'; ?>">
               <a href="<?php echo SITE_URL;?>packing_material" class="nav-link">Packing Materials</a>
            </li>
            <li class="<?php if($cur_page == "productt") echo 'active'; ?>">
               <a href="<?php echo SITE_URL;?>product" class="nav-link">Packed Products</a>
            </li>
            <li class="<?php if($cur_page == "free_gift") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>freegift" class="nav-link">Free Gifts </a>
            </li>
          </ul>
      </li>
      <li class="dropdown-submenu <?php if(@$list_page=="ops") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              OPS Masters
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "unit_measure") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>unit_measure" class="nav-link">Unit Measures </a>
            </li>
            <li class="<?php if($cur_page == "capacity") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>capacity" class="nav-link">Denomination </a>
            </li>
            <li class="<?php if($cur_page == "micron") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>micron" class="nav-link">Film Specification</a>
            </li>
            <li class="<?php if($cur_page == "capacity_micron") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>capacity_micron" class="nav-link">Film Distribution </a>
            </li>
            <li class="<?php if($cur_page == "oil_tanker") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>oil_tanker" class="nav-link">Oil Tank </a>
            </li>
            <li class="<?php if($cur_page == "manage_pm_consumption") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>manage_pm_consumption" class="nav-link">Packing Material Consumption Per Product </a>
            </li>
          </ul>
      </li>
      <li class="dropdown-submenu <?php if(@$list_page=="location") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Locations
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "state") echo 'active'; ?>">
                 <a href="<?php echo SITE_URL;?>state" class="nav-link">State </a>
              </li>
            <li class="<?php if($cur_page == "region") echo 'active'; ?>">
                 <a href="<?php echo SITE_URL;?>region" class="nav-link">Region</a>
              </li>
              <li class="<?php if($cur_page == "district") echo 'active'; ?>">
                 <a href="<?php echo SITE_URL;?>district" class="nav-link">District</a>
              </li>
               <li class="<?php if($cur_page == "mandal") echo 'active'; ?>">
                 <a href="<?php echo SITE_URL;?>mandal" class="nav-link">Mandal</a>
              </li>

              <li class="<?php if($cur_page == "area") echo 'active'; ?>">
                 <a href="<?php echo SITE_URL;?>area" class="nav-link">Area</a>
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
        <li class="dropdown-submenu <?php if(@$list_page=="scheme") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Schemes 
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "welfare_scheme") echo 'active'; ?>">
	        <a href="<?php echo SITE_URL;?>welfare_scheme" class="nav-link">Welfare Scheme</a>
	      </li>
	      <li class="<?php if($cur_page == "freegift_scheme") echo 'active'; ?>">
	        <a href="<?php echo SITE_URL;?>freegift_scheme" class="nav-link">Free Gift Scheme </a>
	      </li>
          </ul>
        </li>
         <li class="dropdown-submenu <?php if(@$list_page=="ob_control") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              OB Control
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
              <li class="<?php if($cur_page == "ob_booking_for_all_products") echo 'active'; ?>">
	        <a href="<?php echo SITE_URL;?>ob_booking_for_all_products" class="nav-link">OB Start/Stop All Products</a>
	      </li>
	      <li class="<?php if($cur_page == "ob_booking_for_single_product") echo 'active'; ?>">
	        <a href="<?php echo SITE_URL;?>ob_booking_for_single_product" class="nav-link">OB Start/Stop Individual Product</a>
	      </li>
	      <li class="<?php if($cur_page == "executive_limit_ob") echo 'active'; ?>">
	        <a href="<?php echo SITE_URL;?>executive_limit" class="nav-link">OB Start/Stop For Executives</a>
	      </li>
          </ul>
        </li>
        <li class="dropdown-submenu <?php if(@$list_page=="settings") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Settings
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
             <li class="<?php if($cur_page == "general_settings") echo 'active'; ?>">
         	<a href="<?php echo SITE_URL;?>edit_general_settings" class="nav-link">General Settings</a>
             </li>
             <li class="<?php if($cur_page == "reportee_designation") echo 'active'; ?>">
         	<a href="<?php echo SITE_URL;?>reportee_designation" class="nav-link">Designation Hierarchy</a>
             </li>
             <li class="<?php if($cur_page == "rollback_settings") echo 'active'; ?>">
         	<a href="<?php echo SITE_URL;?>rollback_settings" class="nav-link">Rollback Approval Settings</a>
             </li>
          </ul>
      </li>
      
      <li class="<?php if($cur_page == "plant") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>plant" class="nav-link">Units/C&F </a>
      </li>
      
      <li class="<?php if($cur_page == "designation") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>designation" class="nav-link">Designation </a>
      </li>
      <li class="<?php if($cur_page == "bank") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>bank" class="nav-link">Bank </a>
      </li>
      
      
        
    </ul>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "payment") echo 'active'; ?>">
    <a href="javascript:;"> Payments
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="dropdown-submenu <?php if(@$list_page=="distributor_list") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Distributors
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            
              <li class="<?php if($cur_page == "dd_receipts") echo 'active'; ?>">
                <a href="<?php echo SITE_URL;?>dd_receipts" class="nav-link">D.D. Receipt</a>
              </li>
              
              <li class="<?php if($cur_page == "distributor_dd_verify") echo 'active'; ?>">
                <a href="<?php echo SITE_URL;?>distributor_payments" class="nav-link">DD Verification </a>
              </li>
              <li class="<?php if($cur_page == "distributor_credit_debit_note") echo 'active'; ?>">
                <a href="<?php echo SITE_URL;?>credit_debit_notes" class="nav-link">Credit/Debit </a>
              </li>
          </ul>
        </li>
        <li class="dropdown-submenu <?php if(@$list_page=="c_and_f_list") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              C&F's
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            
              <li class="<?php if($cur_page == "c_and_f_dd") echo 'active'; ?>">
                <a href="<?php echo SITE_URL;?>c_and_f" class="nav-link">D.D. Receipt</a>
              </li>
              
              <li class="<?php if($cur_page == "c_and_f_dd_view") echo 'active'; ?>">
                <a href="<?php echo SITE_URL;?>c_and_f_payments" class="nav-link">DD Verification </a>
              </li>
              <li class="<?php if($cur_page == "c_and_f_credit_debit_note") echo 'active'; ?>">
                <a href="<?php echo SITE_URL;?>c_and_f_credit_debit_notes" class="nav-link">Credit/Debit </a>
              </li>
          </ul>
        </li>
    </ul>
</li>

<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "purchase_order") echo 'active'; ?>">
    <a href="javascript:;">P.O.
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="dropdown-submenu <?php if(@$list_page=="tender") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Tenders
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "mtp_oil") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>tender_process_details" class="nav-link">Material Tender Process (Oil)</a>
            </li>
            <li class="<?php if($cur_page == "mtp_packingmaterial") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>mtp_packingmaterial" class="nav-link">Material Tender Process (Packing Material)</a>
            </li>
          </ul>
        </li>
      <li class="<?php if($cur_page == "loose_oil_po") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>oil" class="nav-link">Purchase Order (Oil)</a>
      </li>
      <li class="<?php if($cur_page == "po_purchase_order") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>po_packing_material" class="nav-link">Purchase Order (Packing Material)</a>
      </li>
      <li class="<?php if($cur_page == "po_free_gift") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>freegift_po" class="nav-link">Purchase Order (Free Gifts)</a>
      </li>
    </ul>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "Transactions") echo 'active'; ?>">
    <a href="javascript:;"> OB & DO
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "distributor_ob") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>distributor_ob" class="nav-link">Distributor Order Booking</a>
      </li>
      <li class="<?php if($cur_page == "plant_ob") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>plant_ob" class="nav-link">Unit Order Booking</a>
      </li>
      <li class="<?php if($cur_page == "delivery_order") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>delivery_order" class="nav-link">Distributor Delivery Order</a>
      </li>
      <li class="<?php if($cur_page == "plant_do") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>plant_do" class="nav-link">Unit Delivery Order</a>
      </li>
      
    </ul>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "price_updation") echo 'active'; ?>">
    <a href="javascript:;"> Prices
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "product_price") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>product_price" class="nav-link">Price Updation </a>
      </li>
    </ul>
</li>

<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "insurance") echo 'active'; ?>">
    <a href="javascript:;">Insurance
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
    	<li class="<?php if($cur_page == "insurance_product") echo 'active'; ?>">
          <a href="<?php echo SITE_URL;?>insurance_product" class="nav-link">Add Distributor Insurance</a>
      </li>
      <li class="<?php if($cur_page == "plant_insurance_product") echo 'active'; ?>">
          <a href="<?php echo SITE_URL;?>plant_insurance_product" class="nav-link">Add Unit Insurance</a>
      </li>
      
    </ul>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "reports") echo 'active'; ?>">
    <a href="javascript:;"> Reports
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
     <li class="dropdown-submenu <?php if(@$list_page=="sales_report") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Sales Reports
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "daily_sales_report") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>daily_sales_report" class="nav-link">Daily Sales</a>
            </li>
            <li class="<?php if($cur_page == "monthly_sales_report") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>monthly_sales_report" class="nav-link">Monthly Sales</a>
            </li>
            <li class="<?php if($cur_page == "daily_product_sale_report") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>daily_product_sale_report" class="nav-link">Daily Product Sales</a>
            </li>
            <li class="<?php if($cur_page == "monthly_product_sale_report") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>monthly_product_sale_report" class="nav-link">Monthly Product Sales</a>
            </li>
            <li class="<?php if($cur_page == "executive_daily_sales_report") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>executive_daily_sales_report" class="nav-link">Executive Wise Daily Sales</a>
            </li>
            <li class="<?php if($cur_page == "executive_monthly_sales_report") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>executive_monthly_sales_report" class="nav-link">Executive Wise Monthly Sales</a>
            </li>
            <li class="<?php if($cur_page == "daily_exec_product_sale_report") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>daily_exec_product_sale_report" class="nav-link"> Executive Wise Daily Product Sales</a>
            </li>
            <li class="<?php if($cur_page == "monthly_exec_product_sale_report") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>monthly_exec_product_sale_report" class="nav-link">Executive Wise Monthly Product Sales</a>
            </li>
            <li class="<?php if($cur_page == "all_executive_sales_view") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>all_executive_sales_view" class="nav-link">All Executives Sales</a>
            </li>
            <li class="<?php if($cur_page == "distributor_daily_sales_report") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>distributor_daily_sales_report" class="nav-link">Distributor Wise Daily Sales</a>
            </li>
            <li class="<?php if($cur_page == "distributor_monthly_sales_report") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>distributor_monthly_sales_report" class="nav-link">Distributor Wise Monthly Sales</a>
            </li>
            <li class="<?php if($cur_page == "district_sales_report") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>district_sales_report" class="nav-link">District Wise Sales</a>
            </li>
            
          </ul>
        </li>
        
        <li class="dropdown-submenu <?php if(@$list_page=="dist_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
             Distributor Reports
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
          	<li class="<?php if($cur_page == "distributor_r") echo 'active'; ?>">
			<a href="<?php echo SITE_URL;?>distributor_r" class="nav-link">Distributor Report</a>
		</li>
		<li class="<?php if($cur_page == "region_wise_distributor_r") echo 'active'; ?>">
			<a href="<?php echo SITE_URL;?>region_wise_distributor_r" class="nav-link">Region Wise Distributor Report</a>
		</li>

	        <li class="<?php if($cur_page == "dist_bg_r") echo 'active'; ?>">
	        	<a href="<?php echo SITE_URL;?>dist_bg_r" class="nav-link">Distributor Agreements</a>
	        </li>
	        <li class="<?php if($cur_page == "distributor_ledger") echo 'active'; ?>">
              		<a href="<?php echo SITE_URL;?>distributor_ledger" class="nav-link">Distributor Ledger</a>
            	</li>
            	<li class="<?php if($cur_page == "distributor_bg_renewal") echo 'active'; ?>">
              		<a href="<?php echo SITE_URL;?>distributor_bg_renewal" class="nav-link">Distributor Bank Guarantee Renewals</a>
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
            <li class="<?php if($cur_page == "single_plant_ob_list") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>single_plant_ob_list" class="nav-link">Individual Unit O.B.</a>
            </li>
            <li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>distributor_ob_list" class="nav-link">Distributor O.B.</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>plant_ob_list" class="nav-link">Unit O.B.</a>
            </li>
            <li class="<?php if($cur_page == "penalty_report") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>penalty_report" class="nav-link">Penalty Report</a>
            </li>
            <li class="<?php if($cur_page == "dealerwise_penalty_report") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>dealerwise_penalty_report" class="nav-link">Dealer Wise Penaltys</a>
            </li>
            <li class="<?php if($cur_page == "consolidated_penalty_report") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>consolidated_penalty_report" class="nav-link">Consolidated All Dealers Penalty Report</a>
            </li>
            <li class="<?php if($cur_page == "product_wise_pending_ob") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>product_wise_pending_ob" class="nav-link">Productwise Pending O.B.</a>
            </li>
             <li class="<?php if($cur_page == "all_executive_pending_ob") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>all_executive_pending_ob" class="nav-link">All Executives Pending OBs</a>
            </li>
          </ul>
        </li>
        <li class="dropdown-submenu <?php if(@$list_page=="do_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              D.O. Reports
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
           <li class="<?php if($cur_page == "individual_dist_do") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>individual_dist_do" class="nav-link">Individual Distributor D.O.</a>
            </li>
            <li class="<?php if($cur_page == "individual_unit_do") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>individual_unit_do" class="nav-link">Individual Unit D.O.</a>
            </li>
            <li class="<?php if($cur_page == "distributor_do_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>distributor_do_list" class="nav-link">Distributor D.O.</a>
            </li>
            <li class="<?php if($cur_page == "plant_do_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>plant_do_list" class="nav-link">Unit D.O.</a>
            </li>
            <li class="<?php if($cur_page == "product_wise_pending_do") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>product_wise_pending_do" class="nav-link">Productwise Pending D.O.</a>
            </li>
            <li class="<?php if($cur_page == "executive_delivery_order") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>all_executive_pending_do" class="nav-link">All Executives Pending DOs</a>
            </li>
          </ul>
        </li>
        <li class="dropdown-submenu <?php if(@$list_page=="consolidated_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Consolidated Reports
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            
            <li class="<?php if($cur_page == "consolidated_sales_report") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>consolidated_sales_view" class="nav-link">Consolidated Unit Sales Report</a>
            </li>
            <li class="<?php if($cur_page == "consolidated_executive_sales_view") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>consolidated_executive_sales_view" class="nav-link">Consolidated Executive Sales Report (Products)</a>
            </li>
            <li class="<?php if($cur_page == "print_consolidated_closing_stock") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>print_consolidated_closing_stock" class="nav-link">Consolidated Closing Stock Report</a>
            </li>
            <li class="<?php if($cur_page == "yearly_unit_product_report") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>yearly_unit_product_report" class="nav-link">Yearly Sales Report</a>
            </li>
            <li class="<?php if($cur_page == "print_available_product_stock") echo 'active'; ?>">
         	<a href="<?php echo SITE_URL;?>print_available_product_stock" class="nav-link">Available Stock Products At Unit</a>
      	    </li>
      	    <li class="<?php if($cur_page == "consolidated_leakage_report") echo 'active'; ?>">
               <a href="<?php echo SITE_URL;?>consolidated_leakage_report" class="nav-link">Consolidated Leakage Report</a>
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
         	<a href="<?php echo SITE_URL;?>stock_dispatch_r" class="nav-link">Dispatched Invoice Report</a>
	      </li>
	      <li class="<?php if($cur_page == "product_wise_daily_dispatches") echo 'active'; ?>">
	         <a href="<?php echo SITE_URL;?>product_wise_daily_dispatches" class="nav-link">Product Wise Daily dispatches</a>
	      </li>
          </ul>
        </li>
        <li class="dropdown-submenu <?php if(@$list_page=="master_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Master Reports
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            
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
        
        <li class="dropdown-submenu <?php if(@$list_page=="daily_report") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              OPS Reports
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
                <li class="<?php if($cur_page == "oil_test_r") echo 'active'; ?>">
	         <a href="<?php echo SITE_URL;?>oil_test_r" class="nav-link">Lab Test (Oil)</a>
	      </li>
	      <li class="<?php if($cur_page == "pm_test_r") echo 'active'; ?>">
	         <a href="<?php echo SITE_URL;?>pm_test_r" class="nav-link">Lab Test (Packing Material)</a>
	      </li>
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
      
      <li class="dropdown-submenu <?php if(@$list_page=="payment_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Payment Reports
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "dist_dd_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>dist_dd_r" class="nav-link">Distributor d.d. Payments</a>
            </li>
            <li class="<?php if($cur_page == "exec_wise_dist_list") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>exec_wise_dist_list" class="nav-link">Executive Wise d.d. Payments</a>
            </li>
            <li class="<?php if($cur_page == "c_d_distributor_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>c_d_distributor_r" class="nav-link">Distributor Credit/Debit Payments</a>
            </li>
            <li class="<?php if($cur_page == "c_and_f_payments_R") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>c_and_f_payments_R" class="nav-link">C&f d.d. Entry</a>
            </li>
             
            <li class="<?php if($cur_page == "cd_candf_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>cd_candf_r" class="nav-link">C&f Credit/Debit Notes</a>
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
        
        <li class="dropdown-submenu <?php if(@$list_page=="po_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Insurance Reports
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
           <li class="<?php if($cur_page == "consolidated_insurance_sales") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>consolidated_insurance_sales" class="nav-link">Consolidated Report</a>
            </li>
            <li class="<?php if($cur_page == "insurance_report") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>insurance_report" class="nav-link">Distributor Insurance</a>
            </li>
            <li class="<?php if($cur_page == "individual_insurance_invoice") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>individual_insurance_invoice" class="nav-link">Individual Distributor Insurance</a>
            </li>
            <li class="<?php if($cur_page == "individual_insurance_invoice_plant") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>individual_insurance_invoice_plant" class="nav-link">Individual Unit Insurance</a>
            </li>
          </ul>
        </li>
        <li class="dropdown-submenu <?php if(@$list_page=="md_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              M.D. Reports
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "daily_sales_report_md") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>daily_sales_report_md" class="nav-link">Daily Sales Report</a>
            </li>
            <li class="<?php if($cur_page == "monthly_sales_report_md") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>monthly_sales_report_md" class="nav-link">Monthly Sales Report</a>
            </li>
            <li class="<?php if($cur_page == "oil_report_search") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>oil_report_search" class="nav-link">Daily Oil Report At OPS</a>
            </li>
            <li class="<?php if($cur_page == "dw_oil_report_search") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>dw_oil_report_search" class="nav-link">DateWise Oil Report At OPS</a>
            </li>
          </ul>
        </li>
        <li class="<?php if($cur_page == "product_price_report") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>product_price_report_units" class="nav-link">Price List All Units</a>
      </li>
      
    </ul>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "roll_back") echo 'active'; ?>">
    <a href="javascript:;">Roll Back
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
    	<li class="dropdown-submenu <?php if(@$list_page=="po_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Purchase Orders
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
          	<li class="dropdown-submenu <?php if(@$list_page=="oil_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Oils
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>po_oil_delete" class="nav-link">Delete PO</a>
            </li>
            <li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>po_oil_date" class="nav-link">PO Date Change</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>po_oil_quantity" class="nav-link">PO Quantity Change</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>po_oil_price" class="nav-link">PO Price Change</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>po_oil_product" class="nav-link">PO Product Change</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>po_oil_supplier" class="nav-link">PO Supplier Change</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>po_oil_broker" class="nav-link">PO Broker Change</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>po_oil_block" class="nav-link">PO Plant Change</a>
            </li>
          </ul>
        </li>
        <li class="dropdown-submenu <?php if(@$list_page=="pm_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Packing Materials
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
          	<li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>po_delete_pm" class="nav-link">Delete PO</a>
            </li>
            <li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>po_pm_date_change" class="nav-link">PO Date Change</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>po_pm_quantity_change" class="nav-link">PO Quantity Change</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>po_pm_rate_change" class="nav-link">PO Price Change</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>po_pm_product_change" class="nav-link">PO Product Change</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>po_pm_supplier_change" class="nav-link">PO Supplier Change</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>po_pm_ops_change" class="nav-link">PO Plant Change</a>
            </li>
            
          </ul>
        </li> 
        <li class="dropdown-submenu <?php if(@$list_page=="fg_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Free Gifts
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
          	<li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>po_delete_fg" class="nav-link">Delete PO</a>
            </li>
            <li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>po_fg_date_change" class="nav-link">PO Date Change</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>po_fg_quantity_change" class="nav-link">PO Quantity Change</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>po_fg_rate_change" class="nav-link">PO Price Change</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>po_fg_product_change" class="nav-link">PO Product Change</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>po_fg_supplier_change" class="nav-link">PO Supplier Change</a>
            </li>
            
          </ul>
        </li> 
        
        
            
            
            
          </ul>
        </li> 
        <li class="dropdown-submenu <?php if(@$list_page=="demand_draft") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Demand Drafts
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "Rollabck DD") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>distributor_dd" class="nav-link">DD Distributor Change</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>dd_amount" class="nav-link">DD Amount Change</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>dd_type" class="nav-link">DD Type Change</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>dd_date_change" class="nav-link">DD Date Change</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>dd_number_change" class="nav-link">DD Number Change</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>dd_bank_change" class="nav-link">DD Bank Change</a>
            </li>
             <li class="<?php if($cur_page == "distributor_delete_dd") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>distributor_delete_dd" class="nav-link">Delete DD</a>
            </li>
          </ul>
        </li>   
        <li class="dropdown-submenu <?php if(@$list_page=="ob_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Order Bookings
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "ob_delete") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>ob_delete" class="nav-link">Delete Complete O.B.</a>
            </li>
            <li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>ob_activate" class="nav-link">Activate Complete Order Booking</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>ob_product_activate" class="nav-link">Activate Product In Order Booking</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>ob_product_delete" class="nav-link">Delete Product From Order Booking</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>ob_distributor" class="nav-link">Change Order Booking Of Distributor</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>ob_stocks" class="nav-link">Change Order Booking Stocks</a>
            </li>
          </ul>
        </li>
        <li class="dropdown-submenu <?php if(@$list_page=="ob_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Delivery Orders
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>do_delete" class="nav-link">Delete Delivery Order</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>do_delete_items" class="nav-link">Delete Item From Delivery Order</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>do_reduce_stock  " class="nav-link">Reduce Stock From Delivery Order</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>do_unit_change" class="nav-link">Change DO UNIT</a>
            </li>
          </ul>
        </li>
        <li class="dropdown-submenu <?php if(@$list_page=="ob_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              MRRs
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>mrr_date_change" class="nav-link">Change MRR Date(Oil)</a>
            </li>
            <li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>mrr_delete_entry" class="nav-link">Delete MRR Entry(Oil)</a>
            </li>
            <li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>mrr_pm_date_change" class="nav-link">Change MRR Date(PM)</a>
            </li>
            <li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>mrr_pm_delete_entry" class="nav-link">Delete MRR Entry(PM)</a>
            </li>
            <li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>mrr_fg_date_change" class="nav-link">Change MRR Date(FG)</a>
            </li>
            <li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>mrr_fg_delete_entry" class="nav-link">Delete MRR Entry(FG)</a>
            </li>
          </ul>
        </li>
        <li class="dropdown-submenu <?php if(@$list_page=="ob_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Invoices
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>delete_invoice" class="nav-link">Delete Invoice</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>invoice_product_delete" class="nav-link">Delete Item From Invoice</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>date_change  " class="nav-link">Change Date of Invoice</a>
            </li>
          </ul>
        </li>
        
        <li class="dropdown-submenu <?php if(@$list_page=="ob_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Tanker Register
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>delete_tanker" class="nav-link">Delete Tanker Entry</a>
            </li>
          </ul>
        </li>
        <li class="dropdown-submenu <?php if(@$list_page=="ob_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Quality Testing
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>rollback_oil_test" class="nav-link">Passing Oil Test</a>
            </li>
            <li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>rollback_pm_test" class="nav-link">Passing PM Test</a>
            </li>
          </ul>
        </li> 
        <li class="dropdown-submenu <?php if(@$list_page=="ob_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Production
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>change_production_date" class="nav-link">Change Production Date</a>
            </li>
            <li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>delete_production" class="nav-link">Delete Production Entry</a>
            </li>
          </ul>
        </li> 
        
        <li class="dropdown-submenu <?php if(@$list_page=="ob_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Stock Updation
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>stock_add" class="nav-link">Adding Of Stock</a>
            </li>
            <li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>stock_reduce" class="nav-link">Reducing Of Stock</a>
            </li>
          </ul>
        </li>
        <li class="dropdown-submenu <?php if(@$list_page=="ob_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Reports
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>daily_correction_report_search" class="nav-link">Daily Correction Report</a>
            </li>
          </ul>
        </li>   
    </ul>    
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "reports") echo 'active'; ?>">
    <a href="javascript:;">Reports2
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="dropdown-submenu <?php if(@$list_page=="tender") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Stock Reports
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            <li class="<?php if($cur_page == "stock_point_product_balance") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>stock_point_product_balance" class="nav-link">Daily Stock Report</a>
            </li>
            <li class="<?php if($cur_page == "monthly_godown_stock_report") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>monthly_godown_stock_report" class="nav-link">Monthly Stock Report</a>
            </li>
          </ul>
        </li>
        <li class="<?php if($cur_page == "tally_report") echo 'active'; ?>">
             <a href="<?php echo SITE_URL;?>tally_report" class="nav-link">Export To Tally</a>
        </li>
        <li class="<?php if($cur_page == "coupon") echo 'active'; ?>">
             <a href="<?php echo SITE_URL;?>coupon" class="nav-link">Coupon Master</a>
        </li>
        <li class="<?php if($cur_page == "invoice_coupon_report") echo 'active'; ?>">
             <a href="<?php echo SITE_URL;?>invoice_coupon_report" class="nav-link">Coupon Report</a>
        </li>
        <li class="<?php if($cur_page == "consolidated_insurance_sales_declaration") echo 'active'; ?>">
             <a href="<?php echo SITE_URL;?>consolidated_insurance_sales_declaration" class="nav-link">Inurance Sales Declaration</a>
        </li>
        <li class="<?php if($cur_page == "monthly_product_ins_dec") echo 'active'; ?>">
             <a href="<?php echo SITE_URL;?>monthly_product_ins_dec" class="nav-link">Productwise Inurance Declaration</a>
        </li>
         <li class="<?php if($cur_page == "executive_wise_invoice_sales_report") echo 'active'; ?>">
             <a href="<?php echo SITE_URL;?>executive_wise_invoice_sales_report" class="nav-link">Executive Wise Sales Report</a>
        </li>
        <li class="<?php if($cur_page == "distributor_sales_report") echo 'active'; ?>">
             <a href="<?php echo SITE_URL;?>distributor_sales_report" class="nav-link">Top 10 Distributor Sales Report</a>
        </li>
    </ul>
</li>