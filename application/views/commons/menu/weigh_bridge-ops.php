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
      <li class="<?php if($cur_page == "weigh_bridge") echo 'active'; ?>">
      <a href="<?php echo SITE_URL;?>weighbridge" class="nav-link">Weigh Bridge</a>
    </li>
    </ul>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "#") echo 'active'; ?>">
    <a href="javascript:;">Reports
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "weigh_bridge_r") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>weigh_bridge_list" class="nav-link">weigh bridge Report</a>
      </li>
      <li class="<?php if($cur_page == "packing_station_tanker_view") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>packing_station_tanker_view" class="nav-link">Finished Detailed Daily Report</a>
      </li>
      <li class="<?php if($cur_page == "packing_station_tanker_abstract_view") echo 'active'; ?>">
         <a href="<?php echo SITE_URL;?>packing_station_tanker_abstract_view" class="nav-link">Finished Abstract Daily Report</a>
      </li>
      
    </ul>
</li>


