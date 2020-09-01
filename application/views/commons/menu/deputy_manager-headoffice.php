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
    </ul>
</li>


