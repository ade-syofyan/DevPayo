<div class="content-wrapper">
    <div class="row">
        <div class="col-md-8 offset-md-2 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h4 class="card-title">Admin Settings</h4>
                    </div>
                    <?php if ($this->session->flashdata('send') or $this->session->flashdata('ubah')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $this->session->flashdata('send'); ?>
                            <?php echo $this->session->flashdata('ubah'); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($this->session->flashdata('demo')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $this->session->flashdata('demo'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="tab-minimal tab-minimal-success">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="tab-2-1" data-toggle="tab" href="#app-2-1" role="tab" aria-controls="app-2-1" aria-selected="true">
                                    <i class="mdi mdi-cellphone-android"></i>Komisi</a>
                            </li>
                        </ul>

                        <div class="tab-content col-12 justify-content-center">
                            <div class="tab-pane fade show active" id="app-2-1" role="tabpanel" aria-labelledby="tab-2-1">
                                <div class="col-12 grid-margin">
                                    <div class="card">
                                        <div class="card-body">
                                            <h4 class="card-title">Admin Settings</h4>
                                            <br>
                                            <?= form_open_multipart('adminsetting/ubah'); ?>
                                            <input type="hidden" class="form-control" name="id" value="<?= $komisi['id']; ?>">
                                            <div class="form-group">
                                                <label>Komisi Agent</label>
                                                <input type="text" class="form-control" id="komisi" name="komisi" value="<?= $komisi['komisi_agent']; ?>%">
                                            </div>
                                            <button type="submit" class="btn btn-success mr-2">Submit</button>
                                            <?= form_close(); ?>
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