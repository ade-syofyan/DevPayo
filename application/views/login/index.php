<!DOCTYPE html>
<html lang="en">
<?php
$this->input->cookie('user');
?>
<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <!-- Required meta tags -->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Payo Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/simple-line-icons/css/simple-line-icons.css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="<?= base_url(); ?>asset/node_modules/perfect-scrollbar/dist/css/perfect-scrollbar.min.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?= base_url(); ?>asset/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="<?= base_url(); ?>asset/images/logo.png" />
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper">
            <div class="row">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-full-bg">
                    <div class="row w-100">
                        <div class="col-lg-4 mx-auto">
                            <div class="auth-form-light text-left p-5">
                                <?php if ($this->session->flashdata()) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $this->session->flashdata('error'); ?>
                                    </div>
                                <?php endif; ?>
                                <h2>Login</h2>
                                <h4 class="font-weight-light">Halo! Bersiaplah untuk hari ini</h4>
                                <?= form_open_multipart('login/aksi_login'); ?>
                                <div class="form-group">
                                    <label for="exampleInputEmail1"></label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Username" name="user_name" required>
                                    <i class="mdi mdi-account"></i>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1"></label>
                                    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password" name="password" required>
                                    <i class="mdi mdi-eye"></i>
                                </div>
                                <div class="mt-5">
                                    <button type="submit" class="btn btn-block btn-lg font-weight-medium" style="color: #fff;background: linear-gradient(88deg, #0064D3, #6DC0FF);border-color: #03a9f3;">Login</button>
                                    <br>
                                    <span class="text-muted d-block text-center  justify-center ">Copyright © 2020 <a class="text-success" href="#">PayoApp-Team</a>. All rights reserved.</span>
                                </div>
                                <?= form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- row ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="<?= base_url(); ?>asset/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="<?= base_url(); ?>asset/node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="<?= base_url(); ?>asset/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="<?= base_url(); ?>asset/node_modules/perfect-scrollbar/dist/js/perfect-scrollbar.jquery.min.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="<?= base_url(); ?>asset/js/off-canvas.js"></script>
    <script src="<?= base_url(); ?>asset/js/hoverable-collapse.js"></script>
    <script src="<?= base_url(); ?>asset/js/misc.js"></script>
    <script src="<?= base_url(); ?>asset/js/settings.js"></script>
    <script src="<?= base_url(); ?>asset/js/todolist.js"></script>
    <!-- endinject -->
</body>

</html>