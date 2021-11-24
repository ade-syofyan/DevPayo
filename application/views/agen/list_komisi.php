<!-- partial -->
<div class="content-wrapper">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
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
                </div>
                <hr>

                <div class="tab-minimal tab-minimal-success">
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

    <div class="modal fade" id="bayars" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="editLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editLabel">Konfirmasi Pembayaran</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="form">
                        <input type="hidden" id="id">
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
                    <!-- <button class="btn btn-outline-warning" type="button" data-dismiss="modal">Close</button> -->
                    <button class="btn btn-outline-success" type="button" id="bayarkan" name="update">Save</button>
                </div>

            </div>
        </div>
    </div>

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

    function bayar(id) {
        $('#bayars').modal('show')
        $('#bayarkan').click(function() {
            // alert(id);
            var id = $('#id').val()
            var status = $('#status').val();
            // var data = $('#form').serialize();
            $.ajax({
                url: "<?= base_url('Agent/bayarKomisi') ?>",
                type: 'POST',
                data: {
                    'id': id,
                    'status': status,
                },
                cache: false,
                success: function(data) {
                    $('#bayars').modal('hide')
                    // autoload()
                }
            })
        });
    }
</script>