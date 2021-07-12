<!-- partial -->
<div class="content-wrapper">
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

            <div class="tab-minimal tab-minimal-success">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="tab-2-1" data-toggle="tab" href="#ride-2-1" role="tab"
                            aria-controls="ride-2-1" aria-selected="true">
                            NEWS
                        </a>

                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="tab-2-2" data-toggle="tab" href="#bike-2-2" role="tab"
                            aria-controls="bike-2-2" aria-selected="false">
                            BLOG
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" id="tab-2-3" data-toggle="tab" href="#car-2-3" role="tab"
                            aria-controls="car-2-2" aria-selected="false">
                            CATEGORY
                        </a>
                    </li>
                </ul>


                <div class="tab-content">
                    <!-- news -->
                    <div class="tab-pane fade show active" id="ride-2-1" s="s" role="tabpanel"
                        aria-labelledby="tab-2-1">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <a class="btn btn-info" href="<?= base_url(); ?>news/tambah"><i
                                            class="mdi mdi-plus-circle-outline"></i>Add News</a>
                                </div>
                                <br>
                                <h4 class="card-title">News</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table id="order-listing" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Image</th>
                                                        <th>Purpose</th>
                                                        <th>Title</th>
                                                        <th>Create On</th>
                                                        <th>Category</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1;
                                                    foreach ($news as $nw) { ?>
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td>
                                                            <img
                                                                src="<?= base_url('images/berita/') . $nw['foto_berita']; ?>">
                                                        </td>
                                                        <td>
                                                            <?php if ($nw['purpose'] == 'P') { ?>
                                                            <label class="badge badge-primary">Pelanggan</label>
                                                            <?php } else if($nw['purpose'] == 'M') { ?>
                                                            <label class="badge badge-info">Mitra</label>
                                                            <?php } else { ?>
                                                            <label class="badge badge-dark">Driver</label>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?= $nw['title']; ?></td>
                                                        <td><?= tanggal_indonesia($nw['created_berita']); ?></td>
                                                        <td><?= $nw['kategori']; ?></td>
                                                        <td>
                                                            <?php if ($nw['status_berita'] == 1) { ?>
                                                            <label class="badge badge-success">Active</label>
                                                            <?php } else { ?>
                                                            <label class="badge badge-danger">Non Active</label>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <a
                                                                href="<?= base_url(); ?>news/ubah/<?= $nw['id_berita']; ?>">
                                                                <button class="btn btn-outline-primary">Edit</button>
                                                            </a>
                                                            <a href="<?= base_url(); ?>news/hapus/<?= $nw['id_berita']; ?>"
                                                                onclick="return confirm ('are you sure?')">
                                                                <button class="btn btn-outline-danger">Delete</button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php $i++;
                                                    } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- blog -->
                    <div class="tab-pane fade" id="bike-2-2" role="tabpanel" aria-labelledby="tab-2-2">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <a class="btn btn-info" href="<?= base_url(); ?>news/tambahblog"><i
                                            class="mdi mdi-plus-circle-outline"></i>Add Blog</a>
                                </div>
                                <br>
                                <h4 class="card-title">Blog</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table id="order-listing" class="table">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Image</th>
                                                        <th>Purpose</th>
                                                        <th>Title</th>
                                                        <th>Create On</th>
                                                        <th>Category</th>
                                                        <th>Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1;
                                                    foreach ($blog as $b) { ?>
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td>
                                                            <img
                                                                src="<?= base_url('images/berita/') . $b['foto_berita']; ?>">
                                                        </td>
                                                        <td>
                                                            <?php if ($b['purpose'] == 'P') { ?>
                                                            <label class="badge badge-primary">Pelanggan</label>
                                                            <?php } else if($b['purpose'] == 'M') { ?>
                                                            <label class="badge badge-info">Mitra</label>
                                                            <?php } else { ?>
                                                            <label class="badge badge-dark">Driver</label>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?= $b['title']; ?></td>
                                                        <td><?= tanggal_indonesia($b['created_berita']); ?></td>
                                                        <td><?= $b['kategori']; ?></td>
                                                        <td>
                                                            <?php if ($b['status_berita'] == 1) { ?>
                                                            <label class="badge badge-success">Active</label>
                                                            <?php } else { ?>
                                                            <label class="badge badge-danger">Non Active</label>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <a
                                                                href="<?= base_url(); ?>news/ubahblog/<?= $b['id_berita']; ?>">
                                                                <button class="btn btn-outline-primary">Edit</button>
                                                            </a>
                                                            <a href="<?= base_url(); ?>news/hapusblog/<?= $b['id_berita']; ?>"
                                                                onclick="return confirm ('are you sure?')">
                                                                <button class="btn btn-outline-danger">Delete</button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php $i++;
                                                    } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>




                    <!-- kategori -->
                    <div class="tab-pane fade" id="car-2-3" role="tabpanel" aria-labelledby="tab-2-3">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <a class="btn btn-info" href="<?= base_url(); ?>news/tambahcategory"><i
                                            class="mdi mdi-plus-circle-outline"></i>Add Category</a>
                                </div>
                                <br>
                                <h4 class="card-title">Category</h4>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="table-responsive">
                                            <table id="order-listing1" class="table">
                                                <thead>
                                                    <tr>

                                                        <th>No.</th>
                                                        <th>Category</th>
                                                        <th>Created On</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $i = 1;
                                                    foreach ($kategori as $knw) { ?>
                                                    <tr>
                                                        <td><?= $i ?></td>
                                                        <td><?= $knw['kategori']; ?></td>
                                                        <td><?= tanggal_indonesia($knw['created']); ?></td>
                                                        <td>
                                                            <a
                                                                href="<?= base_url(); ?>news/hapuscategory/<?= $knw['id_kategori_news']; ?>"><button
                                                                    class="btn btn-outline-danger">Delete</button></a>
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

                </div>
            </div>
        </div>
    </div>
</div>
<!-- content-wrapper ends -->