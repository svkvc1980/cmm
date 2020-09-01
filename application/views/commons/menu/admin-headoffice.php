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
     
      <li class="<?php if($cur_page == "plant") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>plant" class="nav-link">Units/C&F </a>
      </li>
      <li class="<?php if($cur_page == "designation") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>designation" class="nav-link">Designation </a>
      </li>
      <li class="<?php if($cur_page == "bank") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>bank" class="nav-link">Bank </a>
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

    </ul>
</li>
<li class="menu-dropdown classic-menu-dropdown <?php if($parent_page == "system_management") echo 'active'; ?>">
    <a href="javascript:;"> System Management
        <span class="arrow"></span>
    </a>
    <ul class="dropdown-menu pull-left">
      <li class="<?php if($cur_page == "user") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>user" class="nav-link">User </a>
      </li>
      <li class="<?php if($cur_page == "general_settings") echo 'active'; ?>">
        <a href="<?php echo SITE_URL;?>edit_general_settings" class="nav-link">Settings</a>
      </li>
    </ul>
</li>


