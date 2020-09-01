<li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "home") echo 'active'; ?>">
    <a href="<?php echo SITE_URL; ?>"> Home
        <span class="arrow"></span>
    </a>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "Price list") echo 'active'; ?>">
    <a href="javascript:;"> Price List
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "") echo 'active'; ?>">
        <a href="<?php echo SITE_URL.'view_product_price_report_distributor/'.cmm_encode('1');?>" class="nav-link">Regular</a>
      </li>
      <li class="<?php if($cur_page == "") echo 'active'; ?>">
        <a href="<?php echo SITE_URL.'view_product_price_report_distributor/'.cmm_encode('3');?>" class="nav-link">CST</a>
      </li>
      <li class="<?php if($cur_page == "") echo 'active'; ?>">
        <a href="<?php echo SITE_URL.'view_product_price_report_distributor/'.cmm_encode('5');?>" class="nav-link">Rythu Bazar Price</a>
      </li>
    </ul>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "OB & DO") echo 'active'; ?>">
    <a href="javascript:;"> OB & DO
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "") echo 'active'; ?>">
        <a href="<?php echo SITE_URL.'login_dist_ob_print';?>" class="nav-link">Pending OB</a>
      </li>
      <li class="<?php if($cur_page == "") echo 'active'; ?>">
        <a href="<?php echo SITE_URL.'login_dist_do_print';?>" class="nav-link">Pending DO</a>
      </li>
    </ul>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "Distributor Ledger") echo 'active'; ?>">
    <a href="javascript:;"> Distributor Ledger
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "") echo 'active'; ?>">
        <a href="<?php echo SITE_URL.'distributor_ledger';?>" class="nav-link">Distributor Ledger</a>
      </li>
    </ul>
</li>
