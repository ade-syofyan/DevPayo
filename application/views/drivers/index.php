<!-- partial -->
<div class="content-wrapper">

    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <?php if ($this->session->flashdata('tambah') or $this->session->flashdata('ubah')) : ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $this->session->flashdata('tambah'); ?>
                        <?php echo $this->session->flashdata('ubah'); ?>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('demo') or $this->session->flashdata('hapus')) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $this->session->flashdata('demo'); ?>
                        <?php echo $this->session->flashdata('hapus'); ?>
                    </div>
                <?php endif; ?>
                <h4 class="card-title">Driver</h4>
                <?php if ($this->session->userdata('level_id') == 1) { ?>
                    <table class="table">
                        <tr>
                            <td>
                                <label><b>Fliter</b></label>
                                <select class="js-example-basic-single" id="regency">
                                    <option value="0">Pilih Kota / Kabupaten</option>
                                    <?php foreach ($regency as $reg) : ?>
                                        <option value="<?= $reg['id'] ?>"><?= $reg['name'] ?></option>
                                    <?php endforeach; ?>
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
                <?php } ?>
                <div class="tab-minimal tab-minimal-success">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-2-1" data-toggle="tab" href="#alldrivers-2-1" role="tab" aria-controls="alldrivers-2-1" aria-selected="true">
                                <i class="mdi mdi-motorbike"></i>Semua Driver</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-2-2" data-toggle="tab" href="#active-2-2" role="tab" aria-controls="active-2-2" aria-selected="false">
                                <i class="mdi mdi-account-settings"></i>Driver Aktif</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-2-3" data-toggle="tab" href="#nonactive-2-3" role="tab" aria-controls="nonactive-2-3" aria-selected="false">
                                <i class="mdi mdi-sleep"></i>Driver Tidak Aktif</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-2-4" data-toggle="tab" href="#suspended-2-4" role="tab" aria-controls="suspended-2-4" aria-selected="false">
                                <i class="mdi mdi-account-off"></i>Driver Ditangguhkan</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- all driver -->
                        <div class="tab-pane fade show active" id="alldrivers-2-1" role="tabpanel" aria-labelledby="tab-2-1">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">All Drivers</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <?php if ($this->session->userdata('level_id') == 1) { ?>
                                                    <table id="order-listing" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>ID Driver</th>
                                                                <th>Foto Profil</th>
                                                                <th>Nama Lengkap</th>
                                                                <th>No Hp</th>
                                                                <th>Alamat</th>
                                                                <th>Rating</th>
                                                                <th>Layanan</th>
                                                                <th>Status</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody></tbody>
                                                    </table>
                                                <?php } else { ?>
                                                    <table id="order-listing4" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Foto</th>
                                                                <th>ID Driver</th>
                                                                <th>Nama</th>
                                                                <th>No Hp</th>
                                                                <!-- <th>Alamat</th> -->
                                                                <th>Rating</th>
                                                                <th>Layanan</th>
                                                                <th>Status</th>
                                                                <th>Actions</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($driver as $no => $drv) : ?>
                                                                <tr>
                                                                    <td><?= $no + 1 ?></td>
                                                                    <td><img src="<?= base_url('images/fotodriver/') . $drv['foto']; ?>"></td>
                                                                    <td><?= $drv['id'] ?></td>
                                                                    <td><?= $drv['nama_driver'] ?></td>
                                                                    <td>+<?= $drv['no_telepon'] ?></td>
                                                                    <!-- <td><?= strtolower($drv['province_name']) ?>, <?= strtolower($drv['regency_name']) ?></td> -->
                                                                    <td><?= number_format($drv['rating'], 1) ?></td>
                                                                    <td><?= $drv['driver_job'] ?></td>
                                                                    <td>
                                                                        <?php if ($drv['status'] == 3) { ?>
                                                                            <label class="badge badge-dark">Banned</label>
                                                                        <?php } elseif ($drv['status'] == 0) { ?>
                                                                            <label class="badge badge-secondary text-dark">New Reg</label>
                                                                            <?php } else {
                                                                            if ($drv['status_job'] == 1) { ?>
                                                                                <label class="badge badge-primary">Active</label>
                                                                            <?php }
                                                                            if ($drv['status_job'] == 2) { ?>
                                                                                <label class="badge badge-info">Pick'up</label>
                                                                            <?php }
                                                                            if ($drv['status_job'] == 3) { ?>
                                                                                <label class="badge badge-success">work</label>
                                                                            <?php }
                                                                            if ($drv['status_job'] == 4) { ?>
                                                                                <label class="badge badge-danger">Non Active</label>
                                                                            <?php }
                                                                            if ($drv['status_job'] == 5) { ?>
                                                                                <label class="badge badge-danger">Log Out</label>
                                                                        <?php }
                                                                        } ?>
                                                                    </td>
                                                                    <td>
                                                                        <a href="<?= base_url(); ?>driver/detail/<?= $drv['id'] ?>">
                                                                            <button class="btn btn-outline-primary mr-2">View</button>
                                                                        </a>
                                                                        <?php
                                                                        if ($drv['status'] != 0) {
                                                                            if ($drv['status'] != 3) { ?>
                                                                                <a href="<?= base_url(); ?>driver/block/<?= $drv['id'] ?>"><button class="btn btn-outline-dark text-red mr-2">Block</button></a>
                                                                            <?php } else { ?>
                                                                                <a href="<?= base_url(); ?>driver/unblock/<?= $drv['id'] ?>"><button class="btn btn-outline-success text-red mr-2">Unblock</button></a>
                                                                        <?php }
                                                                        } ?>
                                                                        <!-- <a href="<?= base_url(); ?>driver/hapus/<?= $drv['id'] ?>">
                                                                            <button onclick="return confirm ('Are You Sure?')" class="btn btn-outline-danger text-red mr-2">Delete</button>
                                                                        </a> -->

                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                    </table>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of all driver -->

                        <!-- active driver -->
                        <div class="tab-pane fade" id="active-2-2" role="tabpanel" aria-labelledby="tab-2-2">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Active Drivers</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="order-listing1" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Foto</th>
                                                            <th>ID Driver</th>
                                                            <th>Nama</th>
                                                            <th>No HP</th>
                                                            <th>Rating</th>
                                                            <th>Layanan</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1;
                                                        foreach ($driver as $drv) {
                                                            if ($drv['status'] != 3) {
                                                                if ($drv['status_job'] == 1 or $drv['status_job'] == 2 or $drv['status_job'] == 3) { ?>
                                                                    <tr>
                                                                        <td>
                                                                            <?= $i ?>
                                                                        </td>
                                                                        <td>
                                                                            <img src="<?= base_url('images/fotodriver/') . $drv['foto']; ?>">
                                                                        </td>
                                                                        <td><?= $drv['id'] ?></td>
                                                                        <td><?= $drv['nama_driver'] ?></td>
                                                                        <td><?= $drv['no_telepon'] ?></td>
                                                                        <td><?= number_format($drv['rating'], 1) ?></td>
                                                                        <td><?= $drv['driver_job'] ?></td>
                                                                        <td>
                                                                            <?php if ($drv['status'] == 3) { ?>
                                                                                <label class="badge badge-dark">Banned</label>
                                                                            <?php } elseif ($drv['status'] == 0) { ?>
                                                                                <label class="badge badge-secondary text-dark">New Reg</label>
                                                                                <?php } else {
                                                                                if ($drv['status_job'] == 1) { ?>
                                                                                    <label class="badge badge-primary">Active</label>
                                                                                <?php }
                                                                                if ($drv['status_job'] == 2) { ?>
                                                                                    <label class="badge badge-info">Pick'up</label>
                                                                                <?php }
                                                                                if ($drv['status_job'] == 3) { ?>
                                                                                    <label class="badge badge-success">work</label>
                                                                                <?php }
                                                                                if ($drv['status_job'] == 4) { ?>
                                                                                    <label class="badge badge-danger">Non Active</label>
                                                                            <?php }
                                                                            } ?>
                                                                        </td>
                                                                        <td>
                                                                            <a href="<?= base_url(); ?>driver/detail/<?= $drv['id'] . '/edit' ?>">
                                                                                <button class="btn btn-outline-primary mr-2">View</button>
                                                                            </a>
                                                                            <a href="<?= base_url(); ?>driver/block/<?= $drv['id'] ?>">
                                                                                <button class="btn btn-outline-dark text-red mr-2">Block</button>
                                                                            </a>
                                                                            <a href="<?= base_url(); ?>driver/hapus/<?= $drv['id'] ?>">
                                                                                <button class="btn btn-outline-danger text-red mr-2">Delete</button>
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                        <?php $i++;
                                                                }
                                                            }
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of active driver -->

                        <!-- non active driver -->
                        <div class="tab-pane fade" id="nonactive-2-3" role="tabpanel" aria-labelledby="tab-2-3">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">NonActive Drivers</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="order-listing2" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Foto</th>
                                                            <th>ID Driver</th>
                                                            <th>Nama</th>
                                                            <th>No HP</th>
                                                            <th>Rating</th>
                                                            <th>Layanan</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1;
                                                        foreach ($driver as $drv) {
                                                            if ($drv['status_job'] == 4 or $drv['status_job'] == 5 and $drv['status'] != 0 and $drv['status'] != 3) { ?>
                                                                <tr>
                                                                    <td>
                                                                        <?= $i ?>
                                                                    </td>
                                                                    <td>
                                                                        <img src="<?= base_url('images/fotodriver/') . $drv['foto']; ?>">
                                                                    </td>
                                                                    <td><?= $drv['id'] ?></td>
                                                                    <td><?= $drv['nama_driver'] ?></td>
                                                                    <td><?= $drv['no_telepon'] ?></td>
                                                                    <td><?= number_format($drv['rating'], 1) ?></td>
                                                                    <td><?= $drv['driver_job'] ?></td>
                                                                    <td>
                                                                        <?php if ($drv['status'] == 3) { ?>
                                                                            <label class="badge badge-dark">Banned</label>
                                                                        <?php } elseif ($drv['status'] == 0) { ?>
                                                                            <label class="badge badge-secondary text-dark">New Reg</label>
                                                                            <?php } else {
                                                                            if ($drv['status_job'] == 1) { ?>
                                                                                <label class="badge badge-primary">Active</label>
                                                                            <?php }
                                                                            if ($drv['status_job'] == 2) { ?>
                                                                                <label class="badge badge-info">Pick'up</label>
                                                                            <?php }
                                                                            if ($drv['status_job'] == 3) { ?>
                                                                                <label class="badge badge-success">work</label>
                                                                            <?php }
                                                                            if ($drv['status_job'] == 4) { ?>
                                                                                <label class="badge badge-danger">Non Active</label>
                                                                            <?php }
                                                                            if ($drv['status_job'] == 5) { ?>
                                                                                <label class="badge badge-danger">Log out</label>
                                                                        <?php }
                                                                        } ?>
                                                                    </td>
                                                                    <td>
                                                                        <a href="<?= base_url(); ?>driver/detail/<?= $drv['id'] ?>">
                                                                            <button class="btn btn-outline-primary mr-2">View</button>
                                                                        </a>
                                                                        <a href="<?= base_url(); ?>driver/block/<?= $drv['id'] ?>">
                                                                            <button class="btn btn-outline-dark text-red mr-2">Block</button>
                                                                        </a>
                                                                        <a href="<?= base_url(); ?>driver/hapus/<?= $drv['id'] ?>">
                                                                            <button class="btn btn-outline-danger text-red mr-2">Delete</button>
                                                                        </a>

                                                                    </td>
                                                                </tr>
                                                        <?php $i++;
                                                            }
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of non active driver -->

                        <!-- suspended drivers -->
                        <div class="tab-pane fade" id="suspended-2-4" role="tabpanel" aria-labelledby="tab-2-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Suspended Drivers</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="order-listing3" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Foto</th>
                                                            <th>ID Driver</th>
                                                            <th>Nama</th>
                                                            <th>No HP</th>
                                                            <th>Rating</th>
                                                            <th>Layanan</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 1;
                                                        foreach ($driver as $drv) {
                                                            if ($drv['status'] == 3) { ?>
                                                                <tr>
                                                                    <td>
                                                                        <?= $i ?>
                                                                    </td>
                                                                    <td>
                                                                        <img src="<?= base_url('images/fotodriver/') . $drv['foto']; ?>">
                                                                    </td>
                                                                    <td><?= $drv['id'] ?></td>
                                                                    <td><?= $drv['nama_driver'] ?></td>
                                                                    <td><?= $drv['no_telepon'] ?></td>
                                                                    <td><?= number_format($drv['rating'], 1) ?></td>
                                                                    <td><?= $drv['driver_job'] ?></td>
                                                                    <td>
                                                                        <?php if ($drv['status'] == 3) { ?>
                                                                            <label class="badge badge-dark">Banned</label>
                                                                        <?php } elseif ($drv['status'] == 0) { ?>
                                                                            <label class="badge badge-secondary text-dark">New Reg</label>
                                                                            <?php } else {
                                                                            if ($drv['status_job'] == 1) { ?>
                                                                                <label class="badge badge-primary">Active</label>
                                                                            <?php }
                                                                            if ($drv['status_job'] == 2) { ?>
                                                                                <label class="badge badge-info">Pick'up</label>
                                                                            <?php }
                                                                            if ($drv['status_job'] == 3) { ?>
                                                                                <label class="badge badge-success">work</label>
                                                                            <?php }
                                                                            if ($drv['status_job'] == 4) { ?>
                                                                                <label class="badge badge-danger">Non Active</label>
                                                                        <?php }
                                                                        } ?>
                                                                    </td>
                                                                    <td>
                                                                        <a href="<?= base_url(); ?>driver/detail/<?= $drv['id'] ?>">
                                                                            <button class="btn btn-outline-primary mr-2">View</button>
                                                                        </a>
                                                                        <a href="<?= base_url(); ?>driver/unblock/<?= $drv['id'] ?>">
                                                                            <button class="btn btn-outline-success text-red mr-2">Unblock</button>
                                                                        </a>
                                                                        <a href="<?= base_url(); ?>driver/hapus/<?= $drv['id'] ?>">
                                                                            <button class="btn btn-outline-danger text-red mr-2">Delete</button>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                        <?php $i++;
                                                            }
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of suspended driver -->

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- content-wrapper ends -->

<script>
    $(document).ready(function() {
        $('#regency').change(function() {
            let a = $(this).val();
            // console.log(a);
            driver();
        })
    });

    function driver() {
        var regency = $('#regency').val();
        $.ajax({
            url: "<?= base_url('Driver/load_regency') ?>",
            data: "id=" + regency,
            success: function(data) {
                // console.log(data);
                $("#order-listing").html(data);
            }
        })
    }
</script>

<!-- <script>
    $(document).ready(function() {
        $("#driver").DataTable({
            aLengthMenu: [
                [5, 10, 15, -1],
                [5, 10, 15, "All"]
            ],
            iDisplayLength: 5,
            ordering: false,
            language: {
                search: ""
            }
        });
        $("#driver").each(function() {
            var datatable = $(this);
            // SEARCH - Add the placeholder for Search and Turn this into in-line form control
            var search_input = datatable
                .closest(".dataTables_wrapper")
                .find("div[id$=_filter] input");
            search_input.attr("placeholder", "Search");
            search_input.removeClass("form-control-sm");
            // LENGTH - Inline-Form control
            var length_sel = datatable
                .closest(".dataTables_wrapper")
                .find("div[id$=_length] select");
            length_sel.removeClass("form-control-sm");
        });
    });
</script> -->