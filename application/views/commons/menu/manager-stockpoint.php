<li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "home") echo 'active'; ?>">
    <a href="<?php echo SITE_URL; ?>"> Home
        <span class="arrow"></span>
    </a>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "Transactions") echo 'active'; ?>">
    <a href="javascript:;"> Orders
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "distributor_ob") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>distributor_ob" class="nav-link">Distributor O.B.</a>
      </li>
      
      <li class="<?php if($cur_page == "delivery_order") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>delivery_order" class="nav-link">Distributor D.O.</a>
      </li>
      <li class="<?php if($cur_page == "plant_ob") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>plant_ob" class="nav-link">Unit O.B.</a>
      </li>
      <li class="<?php if($cur_page == "plant_do") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>plant_do" class="nav-link">Unit D.O.</a>
      </li>
    </ul>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "payment") echo 'active'; ?>">
    <a href="javascript:;"> Receipts
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "dd_receipts") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>dd_receipts" class="nav-link">D.D. Receipt</a>
      </li>
    </ul>
</li>

<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "#") echo 'active'; ?>">
    <a href="javascript:;"> Sales
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "manage_dist_invoice") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>dist_invoice_entry" class="nav-link">Invoice Entry</a>
      </li>
      
      <li class="<?php if($cur_page == "free_sample_list") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>free_sample_list" class="nav-link">Free Samples</a>
      </li>
      <li class="<?php if($cur_page == "counter_sale_view") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>counter_sale_view" class="nav-link">Counter Sales</a>
      </li>
      <li class="<?php if($cur_page == "insurance_product") echo 'active'; ?>">
          <a href="<?php echo SITE_URL;?>insurance_product" class="nav-link">Add Distributor Insurance</a>
      </li>
      <li class="<?php if($cur_page == "plant_insurance_product") echo 'active'; ?>">
          <a href="<?php echo SITE_URL;?>plant_insurance_product" class="nav-link">Add Unit Insurance</a>
      </li>
    </ul>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "stock_transfer") echo 'active'; ?>">
    <a href="javascript:;"> Stocks
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "stock_receiving") echo 'active'; ?>">
      <a href="<?php echo SITE_URL;?>stock_receiving" class="nav-link">Stock Receiving</a>
    </li>
      <li class="<?php if($cur_page == "godown_to_countersale") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>godown_to_countersale" class="nav-link">Godown to Counter</a>
      </li>
       <li class="<?php if($cur_page == "countersale_to_godown") echo 'active'; ?>">
      <a href="<?php echo SITE_URL;?>countersale_to_godown" class="nav-link">Counter to Godown</a>
    </li>
    </ul>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "Leakage") echo 'active'; ?>">
    <a href="javascript:;">Leakage
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "godown_leakage_entry") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>godown_leakage_entry" class="nav-link">Godown Leakage </a>
      </li>
      <li class="<?php if($cur_page == "counter_leakage_entry") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>counter_leakage_entry" class="nav-link">Counter Leakage</a>
      </li>
      <li class="<?php if($cur_page == "oil_product") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>oil_product" class="nav-link">Loose Oil to Product Conversion</a>
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
        <li class="dropdown-submenu <?php if(@$list_page=="stock_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Stock Reports
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
              <li class="<?php if($cur_page == "daily_stock_report") echo 'active'; ?>">
	        <a href="<?php echo SITE_URL;?>stock_point_product_balance" class="nav-link">Daily Stock Report</a>
	      </li>
	      <li class="<?php if($cur_page == "monthly_godown_stock_report") echo 'active'; ?>">
	        <a href="<?php echo SITE_URL;?>monthly_godown_stock_report" class="nav-link">Monthly Stock Report</a>
	      </li>
	      <li class="<?php if($cur_page == "unit_wise_stock") echo 'active'; ?>">
	        <a href="<?php echo SITE_URL;?>unit_wise_stock" class="nav-link">Available Product Stock</a>
	      </li> 
	      <li class="<?php if($cur_page == "pm_stock") echo 'active'; ?>">
	         <a href="<?php echo SITE_URL;?>pm_stock" class="nav-link">Available Packing Material Stock</a>
	      </li>
          </ul>
        </li>
        
	<li class="dropdown-submenu <?php if(@$list_page=="master_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Master Reports
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
          	<li class="<?php if($cur_page == "product_r") echo 'active'; ?>">
        		<a href="<?php echo SITE_URL;?>product_r" class="nav-link">Products Report</a>
     		 </li>
          	 <li class="<?php if($cur_page == "product_price_report") echo 'active'; ?>">
        		<a href="<?php echo SITE_URL;?>product_price_report" class="nav-link">Product Price</a>
                 </li>
                 <li class="<?php if($cur_page == "distributor_r") echo 'active'; ?>">
        		<a href="<?php echo SITE_URL;?>distributor_r" class="nav-link">Distributor Report</a>
      	         </li>
      	         <li class="<?php if($cur_page == "dist_bg_r") echo 'active'; ?>">
	        <a href="<?php echo SITE_URL;?>dist_bg_r" class="nav-link">Distributor Agreements</a>
	      </li>
      	          <li class="<?php if($cur_page == "product_price_report") echo 'active'; ?>">
	        <a href="<?php echo SITE_URL;?>product_price_report_units" class="nav-link">Product Price At All Units</a>
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
        <li class="dropdown-submenu <?php if(@$list_page=="consolidated_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Consolidated Reports
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
            
            <li class="<?php if($cur_page == "consolidated_sales_report") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>consolidated_sales_view" class="nav-link">Consolidated Unit Sales Report</a>
            </li>
            <li class="<?php if($cur_page == "print_consolidated_closing_stock") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>print_consolidated_closing_stock" class="nav-link">Consolidated Closing Stock Report</a>
            </li>
            <li class="<?php if($cur_page == "yearly_unit_product_report") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>yearly_unit_product_report" class="nav-link">Yearly Sales Report</a>
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
            <li class="<?php if($cur_page == "penalty_report") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>penalty_report" class="nav-link">Penalty Report</a>
            </li>
            <li class="<?php if($cur_page == "consolidated_penalty_report") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>consolidated_penalty_report" class="nav-link">Dealer Wise Penalty Report</a>
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
            <li class="<?php if($cur_page == "executive_delivery_order") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>all_executive_pending_do" class="nav-link">All Executives Pending DOs</a>
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
              <a href="<?php echo SITE_URL;?>c_d_distributor_r" class="nav-link">Distributor Credit/Debit Notes</a>
            </li>
            
          </ul>
        </li>
        <li class="dropdown-submenu <?php if(@$list_page=="po_reports") echo 'active'; ?> ">
          <a href="#" class="nav-link nav-toggle ">
              Insurance Reports
              <span class="arrow"></span>
          </a>
          <ul class="dropdown-menu">
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
      
        <li class="<?php if($cur_page == "distributor_ledger") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>distributor_ledger" class="nav-link">Distributor Ledger</a>
            </li>
        <li class="<?php if($cur_page == "sp_leakage_r") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>sp_leakage_r" class="nav-link">Leakage Report</a>
      </li>
      
      <li class="<?php if($cur_page == "stock_receiving_r") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>stock_receiving_list" class="nav-link">Stock Receiving Report</a>
      </li>
     
      

      
       
    </ul>
</li>
