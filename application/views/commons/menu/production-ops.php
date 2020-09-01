<li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "home") echo 'active'; ?>">
    <a href="<?php echo SITE_URL; ?>"> Home
        <span class="arrow"></span>
    </a>
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
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "#") echo 'active'; ?>">
    <a href="javascript:;">Reports
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "ops_leakage_r") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>ops_leakage_r" class="nav-link">Leakage Entry Report</a>
      </li>
      <li class="<?php if($cur_page == "production_report") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>production_report" class="nav-link">Production Report</a>
      </li>
      
    </ul>
</li>