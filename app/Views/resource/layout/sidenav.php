<div class="navbar-content">
      <ul class="pc-navbar">
        <li class="pc-item">
          <a href="<?= base_url('beranda'); ?>" class="pc-link">
            <span class="pc-micon"><i class="ti ti-dashboard"></i></span>
            <span class="pc-mtext">Beranda</span>
          </a>
        </li>
        <li class="pc-item pc-hasmenu">
          <a href="#!" class="pc-link"><span class="pc-micon"><i class="ti ti-menu"></i></span><span class="pc-mtext">Pengaturan</span><span class="pc-arrow"><i data-feather="chevron-right"></i></span></a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="<?= base_url('histori');?>"><i class="ti ti-antenna-bars-5"></i> Histori Data</a></li>
            <li class="pc-item"><a class="pc-link" href="<?= base_url('kontrol');?>"><i class="ti ti-toggle-right"></i> Kontrol On/Off Kipas</a></li>
            <li class="pc-item"><a class="pc-link" href="<?= base_url('esp');?>"><i class="ti ti-rotate-clockwise"></i> Restart Kontaktor</a></li>
            <li class="pc-item"><a class="pc-link" href="<?= base_url('plc');?>"><i class="ti ti-rotate-clockwise"></i> Restart Alat</a></li>
            <li class="pc-item"><a class="pc-link" href="<?= base_url('set');?>"><i class="ti ti-settings"></i> Setting</a></li>
            <li class="pc-item"><a class="pc-link" href="<?= base_url('statkon');?>"><i class="ti ti-report"></i> Status Kontaktor</a></li>
            <li class="pc-item"><a class="pc-link" href="<?= base_url('ota');?>"><i class="ti ti-settings"></i> OTA</a></li>
            <li class="pc-item"><a class="pc-link" target="_blank" href="https://bit.ly/SolardomeApps"><i class="ti ti-device-mobile"></i> Download Versi Apps</a></li>
            <li class="pc-item"><a class="pc-link" target="_blank" href="http://localhost:8000"><i class="ti ti-device-mobile"></i> Apps (Local)</a></li>
          </ul>
        </li>
        </div>
    </div>
</nav>
<!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
<header class="pc-header">
  <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
<div class="me-auto pc-mob-drp">
  <ul class="list-unstyled">
    <!-- ======= Menu collapse Icon ===== -->
    <li class="pc-h-item pc-sidebar-collapse">
      <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>
    <li class="pc-h-item pc-sidebar-popup">
      <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>
  </ul>
</div>
<!-- [Mobile Media Block end] -->
<div class="ms-auto">
  <ul class="list-unstyled">
    <li class="dropdown pc-h-item header-user-profile">
        <img src="../assets/images/logoutama.png" alt="logo" class="b-brand logo-md" width="50%">
      </a>
    </li>
  </ul>
</div>
 </div>
</header>
<!-- [ Header ] end -->