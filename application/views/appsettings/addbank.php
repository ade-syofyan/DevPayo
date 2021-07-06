<!-- partial -->
<div class="content-wrapper">
    <div class="row justify-content-md-center">
        <div class="col-md-6 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <?php if ($this->session->flashdata('demo')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $this->session->flashdata('demo'); ?>
                        </div>
                    <?php endif; ?>
                    <h4 class="card-title">Add Bank</h4>

                    <?= form_open_multipart('appsettings/adddatabank'); ?>
                    <div class="form-group">
                        <input type="file" class="dropify" name="image_bank" data-max-file-size="3mb" required />
                    </div>
                    <div class="form-group">
                        <label for="birthdate">Bank Name</label>
                        <input type="text" class="form-control" id="" name="nama_bank" placeholder="enter bank name" required>
                    </div>
                    <div class="form-group">
                        <label for="birthdate">Account Number</label>
                        <input type="text" class="form-control" id="" name="rekening_bank" placeholder="enter bank name" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">status</label>
                        <select class="js-example-basic-single" name="status_bank" style="width:100%">
                            <option value="1">Active</option>
                            <option value="0">Nonactive</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <a class="btn btn-danger text-white" href="<?= base_url(); ?>appsettings/index">Cancel</a>
                    <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>