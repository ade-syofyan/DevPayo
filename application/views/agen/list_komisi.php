<!-- partial -->
<div class="content-wrapper">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <!-- <div>
                    <a class="btn btn-info" href="<?= base_url(); ?>Agent/tambah">
                        <i class="mdi mdi-plus-circle-outline"></i>Add Agent</a>
                </div>
                <br> -->
                <?php if ($this->session->flashdata('demo') or $this->session->flashdata('hapus')) : ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $this->session->flashdata('demo'); ?>
                        <?php echo $this->session->flashdata('hapus'); ?>
                    </div>
                <?php endif; ?>
                <?php if ($this->session->flashdata('ubah') or $this->session->flashdata('tambah')) : ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $this->session->flashdata('ubah'); ?>
                        <?php echo $this->session->flashdata('tambah'); ?>
                    </div>
                <?php endif; ?>
                <h4 class="card-title">Komisi Agent</h4>
                <hr>
                <!-- <?= form_open_multipart('agent/list_komisi'); ?> -->
                <div class="row">
                    <div class="col-md-1">
                        <label><b>Fliter</b></label>
                    </div>
                    <div class="col-md-5">
                        <select class="form-control" name="bulan" id="bulan">
                            <option value="0">Choice Month</option>
                            <?php for ($x = 1; $x <= 12; $x++) { ?>
                                <option value="<?= $x ?>"><?= bulanIndo($x) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <!-- <div class="col-md-3">
                        <button type="submit" class="btn btn-success mr-2">Submit</button>
                    </div> -->
                </div>
                <!-- <?= form_close(); ?> -->
                <hr>

                <div class="tab-minimal tab-minimal-success">
                    <!-- <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-2-1" data-toggle="tab" href="#allusers-2-1" role="tab" aria-controls="allusers-2-1" aria-selected="true">
                                <i class="mdi mdi-account"></i>All Agent</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-2-2" data-toggle="tab" href="#blocked-2-2" role="tab" aria-controls="blocked-2-2" aria-selected="false">
                                <i class="mdi mdi-account-off"></i>Blocked Users</a>
                        </li>
                    </ul> -->

                    <div class="tab-content">

                        <!-- all users -->
                        <div class="tab-pane fade show active" id="allusers-2-1" role="tabpanel" aria-labelledby="tab-2-1">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">List Komisi Agent</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="order-listing" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Profile Pic</th>
                                                            <th>Full Name</th>
                                                            <th>Nilai Transaksi</th>
                                                            <th>Fee</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of all users -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php foreach ($data as $a) : ?>
        <div class="modal fade" id="bayar<?= $a['id'] ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editLabel">Konfirmasi Pembayaran</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <form action="module/user/aksi_edit.php" method="POST">
                            <div class="form-group">
                                <label for="nilai">Ganti Status</label>
                                <select name="status" id="status" class="form-control">
                                    <option value="">Pilih Status</option>
                                    <option value="P">Paid</option>
                                    <option value="U">Unpaid</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-outline-warning" type="button" data-dismiss="modal">Close</button>
                        <button class="btn btn-outline-success" type="submit" name="update">Save</button>
                    </div>

                </div>
            </div>
        </div>
    <?php endforeach ?>

</div>
<!-- content-wrapper ends -->

<script>
    $(document).ready(function() {
        $('#bulan').change(function() {
            let a = $(this).val();
            // console.log(a);
            komisi();
        })
    });

    function komisi() {
        var bulan = $('#bulan').val();
        $.ajax({
            url: "<?= base_url('Agent/load_komisi') ?>",
            data: "bulan=" + bulan,
            success: function(data) {
                // console.log(data);
                $("#order-listing tbody").html(data);
            }
        })
    }
</script>