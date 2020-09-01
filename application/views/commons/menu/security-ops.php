<li aria-haspopup="true" class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "home") echo 'active'; ?>">
    <a href="<?php echo SITE_URL; ?>"> Home
        <span class="arrow"></span>
    </a>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "Logistics") echo 'active'; ?>">
    <a href="javascript:;"> Logistics
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "tanker_in") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>tanker_registration" class="nav-link">Vehicle In</a>
      </li>
      <li class="<?php if($cur_page == "tanker_out") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>tanker_out_details" class="nav-link">Vehicle Out </a>
      </li>
    </ul>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "#") echo 'active'; ?>">
    <a href="javascript:;">Reports
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "tanker_register_r") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>tanker_register" class="nav-link">Vehicle Register List</a>
      </li>
      
    </ul>
</li>