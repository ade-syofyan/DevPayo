<!-- partial -->
<div class="content-wrapper">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div>
                    <a class="btn btn-info" href="<?= base_url(); ?>agen/tambah">
                        <i class="mdi mdi-plus-circle-outline"></i>Add Agent</a>
                </div>
                <br>
                <?php if ($this->session->flashdata('demo') or $this->session->flashdata('hapus')) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $this->session->flashdata('demo'); ?>
                        <?php echo $this->session->flashdata('hapus'); ?>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('ubah') or $this->session->flashdata('tambah')) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $this->session->flashdata('ubah'); ?>
                        <?php echo $this->session->flashdata('tambah'); ?>
                    </div>
                <?php endif; ?>
                <h4 class="card-title">Agent</h4>
                <table class="table">
                    <tr>
                        <td>
                            <label><b>Fliter Province</b></label>
                            <select class="js-example-basic-single" id="province">
                                <option value="0">Choice Province</option>
                                <!-- <?php foreach ($province as $prov) : ?>
                                    <option value="<?= $prov['id'] ?>"><?= $prov['name'] ?></option>
                                <?php endforeach; ?> -->
                            </select>
                        </td>
                        <!-- <td>
                            <label><b>Fliter Regency</b></label>
                            <select name="regency" class="js-example-basic-single" id="regency">
                                <option>Choice Regency</option>
                                <?php foreach ($regency as $prov) : ?>
                                    <option value="<?= $prov['id'] ?>"><?= $prov['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td> -->
                    </tr>
                </table>
                <div class="tab-minimal tab-minimal-success">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-2-1" data-toggle="tab" href="#allusers-2-1" role="tab" aria-controls="allusers-2-1" aria-selected="true">
                                <i class="mdi mdi-account"></i>All Agent</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-2-2" data-toggle="tab" href="#blocked-2-2" role="tab" aria-controls="blocked-2-2" aria-selected="false">
                                <i class="mdi mdi-account-off"></i>Blocked Users</a>
                        </li>
                    </ul>
                    <div class="tab-content">

                        <!-- all users -->
                        <div class="tab-pane fade show active" id="allusers-2-1" role="tabpanel" aria-labelledby="tab-2-1">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">All Users</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="order-listing" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Users Id</th>
                                                            <th>Profile Pic</th>
                                                            <th>Full Name</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                            <th>From</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1;
                                                        foreach ($agen as $ag) { ?>
                                                            <tr>
                                                                <td><?= $i ?></td>
                                                                <td><?= $ag['id'] ?></td>
                                                                <td>
                                                                    <img src="<?= base_url('images/pelanggan/') . $ag['fotopelanggan']; ?>">
                                                                </td>
                                                                <td><?= $ag['fullnama'] ?></td>
                                                                <td><?= $ag['email'] ?></td>
                                                                <td><?= $ag['no_telepon'] ?></td>
                                                                <td><?= $ag['province_name'] ?>, <?= $ag['regency_name'] ?></td>
                                                                <td>
                                                                    <?php if ($ag['status'] == 1) { ?>
                                                                        <label class="badge badge-success">Active</label>
                                                                    <?php } else { ?>
                                                                        <label class="badge badge-dark">Blocked</label>
                                                                    <?php } ?>
                                                                </td>
                                                                <td>
                                                                    <a href="<?= base_url(); ?>users/detail/<?= $ag['id'] ?>">
                                                                        <button class="btn btn-outline-primary mr-2">View</button>
                                                                    </a>
                                                                    <?php if ($ag['status'] == 0) { ?>
                                                                        <a href="<?= base_url(); ?>users/userunblock/<?= $ag['id'] ?>">
                                                                            <button class="btn btn-outline-success text-red mr-2">Unblock</button>
                                                                        </a>
                                                                    <?php } else { ?>
                                                                        <a href="<?= base_url(); ?>users/userblock/<?= $ag['id'] ?>">
                                                                            <button class="btn btn-outline-dark text-dark mr-2">Block</button>
                                                                        </a>
                                                                    <?php } ?>
                                                                    <a href="<?= base_url(); ?>users/hapususers/<?= $ag['id'] ?>">
                                                                        <button onclick="return confirm ('Are You Sure?')" class="btn btn-outline-danger text-red mr-2">Delete</button>
                                                                    </a>
                                                                </td>
                                                            <?php $i++;
                                                        } ?>
                                                            </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of all users -->

                        <!-- blocked users -->
                        <!-- <div class="tab-pane fade" id="blocked-2-2" role="tabpanel" aria-labelledby="tab-2-2">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">All Users</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="order-listing" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Users Id</th>
                                                            <th>Profile Pic</th>
                                                            <th>Full Name</th>
                                                            <th>Email</th>
                                                            <th>Phone</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1;
                                                        foreach ($user as $us) {
                                                            if ($us['status'] == 0) { ?>
                                                                <tr>
                                                                    <td><?= $i ?></td>
                                                                    <td><?= $us['id'] ?></td>
                                                                    <td>
                                                                        <img src="<?= base_url('images/pelanggan/') . $us['fotopelanggan']; ?>">
                                                                    </td>
                                                                    <td><?= $us['fullnama'] ?></td>
                                                                    <td><?= $us['email'] ?></td>
                                                                    <td><?= $us['no_telepon'] ?></td>
                                                                    <td>
                                                                        <?php if ($us['status'] == 1) { ?>
                                                                            <label class="badge badge-success">Active</label>
                                                                        <?php } else { ?>
                                                                            <label class="badge badge-dark">Blocked</label>
                                                                        <?php } ?>
                                                                    </td>
                                                                    <td>
                                                                        <a href="<?= base_url(); ?>users/detail/<?= $us['id'] ?>">
                                                                            <button class="btn btn-outline-primary mr-2">View</button>
                                                                        </a>
                                                                        <a href="<?= base_url(); ?>users/userunblock/<?= $us['id'] ?>">
                                                                            <button class="btn btn-outline-success text-red mr-2">Unblock</button>
                                                                        </a>

                                                                        <a href="<?= base_url(); ?>users/hapususers/<?= $us['id'] ?>">
                                                                            <button class="btn btn-outline-danger text-red mr-2">Delete</button>
                                                                        </a>
                                                                    </td>
                                                            <?php $i++;
                                                            }
                                                        } ?>
                                                                </tr>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <!-- end of blocked -->

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- content-wrapper ends -->