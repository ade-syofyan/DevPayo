<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        <?php if ($this->session->userdata('level_id') == 1) { ?>
            Admin Panel
        <?php } else { ?>
            Agent Panel
        <?php } ?>
    </title>
    <!-- plugins:css -->

    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/font-awesome/css/font-awesome.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/jquery-bar-rating/dist/themes/fontawesome-stars.css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/dropify/dist/css/dropify.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/pwstabs/assets/jquery.pwstabs.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/icheck/skins/all.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/select2/dist/css/select2.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/select2-bootstrap-theme/dist/select2-bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/perfect-scrollbar/dist/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/dragula/dist/dragula.min.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/summernote/dist/summernote-bs4.css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/quill/dist/quill.snow.css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/simplemde/dist/simplemde.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.8/css/intlTelInput.css" />
    <!-- <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="<?= base_url(); ?>asset/css/bootstrap-toggle.min.css">

    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?= base_url(); ?>asset/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="<?= base_url(); ?>asset/images/logo.png" />
    <style type="text/css">
        @media screen and (max-width: 500px) {
            #mobileshow {
                display: none;
            }
        }
    </style>
</head>

<body>
    <script src="<?= base_url(); ?>asset/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.22.0/axios.min.js" integrity="sha512-m2ssMAtdCEYGWXQ8hXVG4Q39uKYtbfaJL5QMTbhl2kc6vYyubrKHhr6aLLXW4ITeXSywQLn1AhsAaqrJl8Acfg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <div class="container-scroller">
        <!-- partial:../../partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
                <a class="navbar-brand brand-logo" href="<?= base_url(); ?>"><img src="<?= base_url(); ?>asset/images/logo_dashboard.png" alt="logo" style="display: none;" /><b style="color: red;">DEVELOP</b></a>
                <a class="navbar-brand brand-logo-mini" href="<?= base_url(); ?>"><img src="<?= base_url(); ?>asset/images/logo.png" alt="logo" /></a>
            </div>

            <div class="navbar-menu-wrapper d-flex align-items-center">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="icon-menu"></span>
                </button>
                <b style="color: red;float: right !important;position: absolute;right: 1%;">DEVELOPMENT ONLY</b>
            </div>
        </nav>
        <!-- partial -->

        <div class="container-fluid page-body-wrapper">
            <div class="row row-offcanvas row-offcanvas-right">
                <!-- partial:../../partials/_sidebar.html -->
                <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                        <li class="nav-item nav-profile">
                            <div class="nav-link">
                                <div class="profile-image">
                                    <?php if ($this->session->userdata('level_id') == 1) { ?>
                                        <img src="<?= base_url(); ?>images/admin/<?= $this->session->userdata('image') ?>" onerror="this.onerror=null;this.src='<?= base_url(); ?>asset/images/logo.png';" />
                                    <?php } else { ?>
                                        <img src="<?= base_url(); ?>images/agent/<?= $this->session->userdata('image') ?>" onerror="this.onerror=null;this.src='<?= base_url(); ?>asset/images/logo.png';" />
                                    <?php } ?>
                                    <span class="online-status online"></span>
                                    <!--change class online to offline or busy as needed-->
                                </div>
                                <?php
                                $id    = $this->session->userdata('regency');
                                $id_wa = $this->session->userdata('wallet_id');
                                $kota  = $this->db->query('SELECT name as aby FROM wa_regency WHERE id = ' . $id . '')->row_array();
                                $norek = $this->db->query('SELECT no_rekening FROM wallet_agent WHERE id_wa = ' . $id_wa . '')->row_array();
                                $uncang = $norek['no_rekening'];
                                $null = '';
                                ?>
                                <div class="profile-name">
                                    <p class="name">
                                        <?= $this->session->userdata('nama_lengkap') ?>
                                    </p>
                                    <p class="designation">
                                        <?php if ($this->session->userdata('level_id') == 1) { ?>
                                            Superadmin
                                        <?php } else { ?>
                                            Agent <?= $kota['aby'] ?>
                                        <?php } ?>
                                    </p>

                                    <?php if ($uncang === NULL) { ?>
                                        <?= $null ?>
                                    <?php } else { ?>
                                        <p class="name">
                                            Rek Uncang : <?= $norek['no_rekening'] ?>
                                        </p>
                                    <?php } ?>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(); ?>">
                                <i class="icon-rocket menu-icon"></i>
                                <span class="menu-title">Dashboard</span>
                            </a>
                        </li>
                        <?php if ($this->session->userdata('level_id') == 1) { ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url(); ?>transaction">
                                    <i class="icon-list menu-icon"></i>
                                    <span class="menu-title">Transaksi</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-toggle="collapse" href="#tables" aria-expanded="false" aria-controls="tables">
                                    <i class="icon-wallet menu-icon"></i>
                                    <span class="menu-title">Keuangan</span>
                                    <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                                </a>
                                <div class="collapse" id="tables">
                                    <ul class="nav flex-column sub-menu">
                                        <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>wallet">Wallet</a></li>
                                        <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>wallet/tambahtopup">Manual Top Up</a></li>
                                        <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>wallet/tambahwithdraw">Manual Withdraw</a></li>
                                    </ul>
                                </div>
                            </li>
                            <!-- <li class="nav-item">
                                    <a class="nav-link" href="<?= base_url(); ?>Agent">
                                        <i class="icon-people menu-icon"></i>
                                        <span class="menu-title">Agen</span>
                                    </a>
                                </li> -->
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="collapse" href="#agent" aria-expanded="false" aria-controls="agent">
                                    <i class="icon-people menu-icon"></i>
                                    <span class="menu-title">Agen</span>
                                    <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                                </a>

                                <div class="collapse" id="agent">
                                    <ul class="nav flex-column sub-menu">
                                        <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>Agent">List Agen</a></li>
                                        <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>Agent/list_komisi">List Komisi</a></li>
                                        <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>Adminsetting">Setting Komisi</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="collapse" href="#drivers" aria-expanded="false" aria-controls="drivers">
                                    <i class="icon-people menu-icon"></i>
                                    <span class="menu-title">Drivers</span>
                                    <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                                </a>

                                <div class="collapse" id="drivers">
                                    <ul class="nav flex-column sub-menu">
                                        <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>driver">Drivers</a></li>
                                        <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>newregistration">Validasi Mitra Baru</a></li>
                                        <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>driver/tracking_driver">Lacak Driver</a></li>
                                        <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>bank/requestdriver">Request Bank</a></li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-toggle="collapse" href="#users" aria-expanded="false" aria-controls="users">
                                    <i class="icon-people menu-icon"></i>
                                    <span class="menu-title">Users</span>
                                    <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                                </a>
                                <div class="collapse" id="users">
                                    <ul class="nav flex-column sub-menu">
                                        <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>users">List User</a></li>
                                        <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>bank/requestmitra">Request Bank</a></li>
                                    </ul>
                                </div>
                            </li>

                            <!-- <li class="nav-item">
                                <a class="nav-link" href="<?= base_url(); ?>users">
                                    <i class="icon-people menu-icon"></i>
                                    <span class="menu-title">User</span>
                                </a>
                            </li> -->

                            <li class="nav-item">
                                <a class="nav-link" data-toggle="collapse" href="#tables2" aria-expanded="false" aria-controls="tables2">
                                    <i class="icon-basket-loaded menu-icon"></i>
                                    <span class="menu-title">Merchant</span>
                                    <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                                </a>
                                <div class="collapse" id="tables2">
                                    <ul class="nav flex-column sub-menu">
                                        <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>categorymerchant">Kategori Mitra</a></li>
                                        <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>mitra">All Mitra</a></li>
                                        <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>mitra/newregmitra">Validasi Mitra Baru</a></li>
                                        <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>bank/requestmitra">Request Bank</a></li>
                                    </ul>
                                </div>

                            </li>

                            <li class="nav-item">
                                <a class="nav-link" data-toggle="collapse" href="#service" aria-expanded="false" aria-controls="tables2">
                                    <i class="icon-layers menu-icon"></i>
                                    <span class="menu-title">Layanan</span>
                                    <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                                </a>
                                <div class="collapse" id="service">
                                    <ul class="nav flex-column sub-menu">
                                        <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>services">Layanan</a></li>
                                        <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>partnerjob">Tipe Kendaraan</a></li>
                                    </ul>
                                </div>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url(); ?>promocode">
                                    <i class="icon-tag menu-icon"></i>
                                    <span class="menu-title">Kode Voucher</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url(); ?>promoslider">
                                    <i class="icon-screen-smartphone menu-icon"></i>
                                    <span class="menu-title">Slider</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url(); ?>news">
                                    <i class="icon-docs menu-icon"></i>
                                    <span class="menu-title">Berita</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url(); ?>sendemail">
                                    <i class="icon-envelope-letter menu-icon"></i>
                                    <span class="menu-title">Kirim Email</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url(); ?>appnotification">
                                    <i class="icon-paper-plane menu-icon"></i>
                                    <span class="menu-title">Notifikasi Aplikasi</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url(); ?>appsettings">
                                    <i class="icon-settings menu-icon"></i>
                                    <span class="menu-title">Pengaturan Aplikasi</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url(); ?>profile">
                                    <i class="icon-user-following menu-icon"></i>
                                    <span class="menu-title">Profil Admin</span>
                                </a>
                            </li>
                        <?php } else { ?>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="collapse" href="#drivers" aria-expanded="false" aria-controls="drivers">
                                    <i class="icon-people menu-icon"></i>
                                    <span class="menu-title">Drivers</span>
                                    <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                                </a>

                                <div class="collapse" id="drivers">
                                    <ul class="nav flex-column sub-menu">
                                        <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>driver">Drivers</a></li>
                                        <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>newregistration">Validasi Mitra Baru</a></li>
                                    </ul>
                                </div>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="collapse" href="#tables2" aria-expanded="false" aria-controls="tables2">
                                    <i class="icon-basket-loaded menu-icon"></i>
                                    <span class="menu-title">Merchant</span>
                                    <span class="badge badge-white"><i class="mdi mdi-menu-down mdi-24px text-primary"></i></span>
                                </a>
                                <div class="collapse" id="tables2">
                                    <ul class="nav flex-column sub-menu">
                                        <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>mitra">List Merchant</a></li>
                                        <li class="nav-item"> <a class="nav-link" href="<?= base_url(); ?>mitra/newregmitra">Validasi Merchant</a></li>
                                    </ul>
                                </div>

                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url(); ?>profile/profileAgent">
                                    <i class="icon-user-following menu-icon"></i>
                                    <span class="menu-title">Profil</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url(); ?>agent/komisi">
                                    <i class="icon-wallet menu-icon"></i>
                                    <span class="menu-title">Komisi</span>
                                </a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="<?= base_url(); ?>agent/komisi">
                                    <i class="icon-wallet menu-icon"></i>
                                    <span class="menu-title">Komisi</span>
                                </a>
                            </li> -->
                        <?php } ?>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url(); ?>login/logout">
                                <i class="icon-logout menu-icon"></i>
                                <span class="menu-title">Logout</span>
                            </a>
                        </li>

                    </ul>
                </nav>