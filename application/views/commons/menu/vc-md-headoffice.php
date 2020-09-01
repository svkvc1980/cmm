.<li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "home") echo 'active'; ?>">
    <a href="<?php echo SITE_URL; ?>"> Home
        <span class="arrow"></span>
    </a>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "master") echo 'active'; ?>">
    <a href="javascript:;"> Masters
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "broker") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>add_broker" class="nav-link">Broker </a>
      </li>
       <li class="<?php if($cur_page == "supplier") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>add_supplier" class="nav-link">Supplier </a>
      </li>
      <li class="<?php if($cur_page == "distributor") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>distributor_selection" class="nav-link">Distributor </a>
      </li>
      <li class="<?php if($cur_page == "executive") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>executive" class="nav-link">Executive </a>
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
              <li class="<?php if($cur_page == "distributor_credit_debit_note") echo 'active'; ?>">
                <a href="<?php echo SITE_URL;?>distributor_credit_debit_note" class="nav-link">Credit/Debit </a>
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
              <li class="<?php if($cur_page == "c_and_f_credit_debit_note") echo 'active'; ?>">
                <a href="<?php echo SITE_URL;?>c_and_f_credit_debit_note" class="nav-link">Credit/Debit </a>
              </li>
          </ul>
        </li>
    </ul>
</li>

<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "purchase_order") echo 'active'; ?>">
    <a href="javascript:;"> Purchase Order
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
    <a href="javascript:;"> Transactions
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "distributor_ob") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>distributor_ob" class="nav-link">Distributor Order Booking</a>
      </li>
      <li class="<?php if($cur_page == "plant_ob") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>plant_ob" class="nav-link">Plant Order Booking</a>
      </li>
      <li class="<?php if($cur_page == "delivery_order") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>delivery_order" class="nav-link">Distributor Delivery Order</a>
      </li>
      <li class="<?php if($cur_page == "plant_do") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>plant_do" class="nav-link">Plant Delivery Order</a>
      </li>
    </ul>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "price_updation") echo 'active'; ?>">
    <a href="javascript:;"> Price Updation
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "product_price") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>product_price_report_units" class="nav-link">Price Updation </a>
      </li>
    </ul>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "scheme_management") echo 'active'; ?>">
    <a href="javascript:;"> Schemes
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "welfare_scheme") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>welfare_scheme" class="nav-link">Welfare Scheme</a>
      </li>
      <li class="<?php if($cur_page == "freegift_scheme") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>freegift_scheme" class="nav-link">Free Gift Scheme </a>
      </li>
    </ul>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "ob_control") echo 'active'; ?>">
    <a href="javascript:;"> OB Control
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
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
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "reports") echo 'active'; ?>">
    <a href="javascript:;"> Reports
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
    	<li class="<?php if($cur_page == "product_price_report") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>product_price_report_units" class="nav-link">Product Price</a>
      </li>
      <li class="<?php if($cur_page == "distributor_r") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>distributor_r" class="nav-link">Distributor Report</a>
      </li>
      <li class="<?php if($cur_page == "broker_r") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>broker_r" class="nav-link">Broker Report</a>
      </li>
       <li class="<?php if($cur_page == "product_r") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>product_r" class="nav-link">Products Report</a>
      </li>
      <li class="<?php if($cur_page == "supplier_r") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>supplier_r" class="nav-link">Supplier Report</a>
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
            <li class="<?php if($cur_page == "distributor_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>distributor_ob_list" class="nav-link">Distributor O.B.</a>
            </li>
            <li class="<?php if($cur_page == "plant_ob_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>plant_ob_list" class="nav-link">Unit O.B.</a>
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
          </ul>
        </li>
      <li class="dropdown-submenu <?php if(@$list_page=="ob_control_r") echo 'active'; ?> ">
        <a href="#" class="nav-link nav-toggle ">
            OB Control
            <span class="arrow"></span>
        </a>
        <ul class="dropdown-menu">
          <li class="<?php if($cur_page == "ob_control_all_products_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>ob_history_R" class="nav-link">OB control (all Products)</a>
            </li>
            
            <li class="<?php if($cur_page == "ob_control_oil_r") echo 'active'; ?>">
              <a href="<?php echo SITE_URL;?>ob_history_oil_R" class="nav-link">OB Control (individual Products)</a>
            </li>
        </ul>
      </li>
    </ul>
</li>