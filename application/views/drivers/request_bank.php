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
                <h4 class="card-title">Request Bank Driver</h4>
                <div class="tab-minimal tab-minimal-success">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tab-2-1" data-toggle="tab" href="#approve-2-1" role="tab" aria-controls="approve-2-1" aria-selected="true">
                                <i class="mdi mdi-motorbike"></i>Approve</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tab-2-2" data-toggle="tab" href="#reject-2-2" role="tab" aria-controls="reject-2-2" aria-selected="false">
                                <i class="mdi mdi-account-settings"></i>Reject</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- approve -->
                        <div class="tab-pane fade show active" id="approve-2-1" role="tabpanel" aria-labelledby="tab-2-1">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Approve Bank</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <div class="table-fixed">
                                                    <table id="order-listing" class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama</th>
                                                                <th>Nama Bank</th>
                                                                <th>No Rekening</th>
                                                                <th>Atas Nama</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($active as $no => $ac) : ?>
                                                                <tr>
                                                                    <td><?= $no + 1 ?></td>
                                                                    <td><?= $ac['nama_driver'] ?></td>
                                                                    <td><label class="badge badge-info"><?= $ac['nama_bank'] ?></label></td>
                                                                    <td><?= $ac['norek'] ?></td>
                                                                    <td><?= $ac['atas_nama'] ?></td>
                                                                </tr>
                                                            <?php endforeach ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of active -->

                        <!-- reject bank -->
                        <div class="tab-pane fade" id="reject-2-2" role="tabpanel" aria-labelledby="tab-2-2">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Reject Bank</h4>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="order-listing1" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>No</th>
                                                            <th>Nama</th>
                                                            <th>Nama Bank</th>
                                                            <th>No Rekening</th>
                                                            <th>Atas Nama</th>
                                                            <th>Catatan</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($reject as $no => $rj) : ?>
                                                            <tr>
                                                                <td><?= $no + 1 ?></td>
                                                                <td><?= $rj['nama_driver'] ?></td>
                                                                <td><label class="badge badge-info"><?= $rj['nama_bank'] ?></label></td>
                                                                <td><?= $rj['norek'] ?></td>
                                                                <td><?= $rj['atas_nama'] ?></td>
                                                                <td><?= $rj['catatan_reject'] ?></td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of reject bank -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- content-wrapper ends -->