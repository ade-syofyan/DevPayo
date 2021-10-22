<?php if ($cek > 0) { ?>
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
                    <h4 class="card-title">List Komisi</h4>
                    <div class="tab-minimal tab-minimal-success">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="allusers-2-1" role="tabpanel" aria-labelledby="tab-2-1">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Komisi</h4>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table id="order-listing" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Bulan</th>
                                                                <th>Tangggal Paid</th>
                                                                <th>Fee</th>
                                                                <th>Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($komisi as $no => $ag) : ?>
                                                                <?php
                                                                if ($ag['status'] == 'P') {
                                                                    $status = 'Paid';
                                                                    $color  = 'success';
                                                                    $waktu  = tanggal_indonesia($ag['waktu']);
                                                                } else {
                                                                    $status = 'Unpaid';
                                                                    $color  = 'warning';
                                                                    $waktu  = "-";
                                                                }
                                                                $a = $ag['waktu'];
                                                                $time = explode("-", $a);
                                                                $bulan = $time[1];

                                                                ?>
                                                                <tr>
                                                                    <td><?= $no + 1 ?></td>
                                                                    <td><?= bulanIndo($bulan) ?></td>
                                                                    <td><?= $waktu ?></td>
                                                                    <td><?= formatRupiah($ag['jumlah']) ?></td>
                                                                    <td><span class="badge badge-<?= $color ?>"><?= $status ?></span></td>
                                                                </tr>
                                                            <?php endforeach; ?>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
<?php } else { ?>
    <div class="content-wrapper">
        <div class="row justify-content-md-center">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <?php if ($this->session->flashdata('demo')) : ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $this->session->flashdata('demo'); ?>
                            </div>
                        <?php endif; ?>
                        <h4 class="card-title">Wallet</h4>
                        <?= form_open_multipart('agent/komisi'); ?>

                        <div class="form-group">
                            <label for="nama">Name</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Enter your name" value="">
                        </div>
                        <div class="form-group">
                            <label for="no_rekening">Wallet Number</label>
                            <input type="number" class="form-control" id="no_rekening" name="no_rekening" placeholder="enter wallet number" value="">
                        </div>
                        <button type="submit" class="btn btn-success mr-2">Submit</button>
                        <a class="btn btn-danger text-white" href="<?= base_url(); ?>wallet">Cancel</a>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>