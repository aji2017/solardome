<div class="nav-left-sidebar sidebar-dark">
            <div class="menu-list">
                <nav class="navbar navbar-expand-lg navbar-light">
                    <a class="d-xl-none d-lg-none" href="#">Beranda</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav flex-column">
                            <li class="nav-divider">
                                Menu
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link active" href="<?= base_url('beranda');?>"><i class="fa fa-fw fas fa-qrcode"></i>Dashboard <span class="badge badge-success"></span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2" aria-controls="submenu-2"><i class="fa fa-fw fa-rocket"></i>Pengaturan</a>
                                <div id="submenu-2" class="collapse submenu" style="">
                                    <ul class="nav flex-column">
                                    <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('histori');?>">Histori Data</a>
                                        </li>
                                   <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('kontrol');?>">Kontrol On/Off Kipas</a>
                                        </li>
                                    <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('esp');?>">Restart Kontaktor</a>
                                        </li>
                                    <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('plc');?>">Restart Alat</a>
                                        </li>
                                    <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('set');?>">Setting</a>
                                        </li>
                                    <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('statkon');?>">Status Kontaktor</a>
                                        </li>
                                    <li class="nav-item">
                                            <a class="nav-link" href="<?= base_url('ota');?>">OTA</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>