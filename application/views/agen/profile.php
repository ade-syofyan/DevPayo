<div class="content-wrapper">
    <div class="row user-profile">
        <div class="col-md-8 offset-md-2 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <?php if ($this->session->flashdata('ubah')) : ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $this->session->flashdata('ubah'); ?>
                        </div>
                    <?php endif; ?>
                    <?php if ($this->session->flashdata('demo')) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $this->session->flashdata('demo'); ?>
                        </div>
                    <?php endif; ?>
                    <div class="wrapper d-block d-sm-flex align-items-center justify-content-between">

                        <h4 class="card-title mb-0">Profile</h4>
                        <ul class="nav nav-tabs tab-solid tab-solid-primary mb-0" id="myTab" role="tablist">
                            <li class="nav-item">
                                <span class="nav-link active" id="info-tab" data-toggle="tab" role="tab" aria-controls="info" aria-expanded="true">Info</span>
                            </li>
                        </ul>
                    </div>
                    <div class="wrapper">
                        <hr>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info">
                                <?= form_open_multipart('profile/ubahagent'); ?>
                                <div class="form-group">
                                    <label>Image Profile</label>
                                    <input type="file" class="dropify" data-max-file-size="1mb" name="image" data-default-file="<?= base_url('images/agent/') . $image ?>" />
                                    <div class="form-group mt-5">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Fullname</label>
                                        <input type="text" class="form-control" name="fullname" id="fullname" value="<?= $nama_lengkap ?>" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" value="<?= $email ?>" required>
                                    </div>
                                    <label class="text-small">Phone Number</label>
                                    <div class="row">
                                        <div class="form-group col-2">
                                            <input type="tel" id="txtPhone" class="form-control" name="countrycode" placeholder="+1 " <?php if ($_POST != NULL) { ?> value="<?= $_POST['countryCode']; ?>" <?php } ?>>
                                        </div>
                                        <div class=" form-group col-10">
                                            <input type="text" class="form-control" id="phone" name="phone" placeholder="enter phone number" value="<?= $phone ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Password</label>
                                        <input type="password" class="form-control" name="password" id="email" placeholder="change password here">
                                    </div>
                                    <div class="form-group mt-5">
                                        <button type="submit" class="btn btn-success mr-2">Update</button>
                                    </div>
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

<script type="text/javascript">
    $(function() {
        var code = "+62"; // Assigning value from model.
        $('#txtPhone').val(code);
        $('#txtPhone').intlTelInput({
            autoHideDialCode: true,
            autoPlaceholder: "ON",
            dropdownContainer: document.body,
            formatOnDisplay: true,
            hiddenInput: "full_number",
            initialCountry: "auto",
            nationalMode: true,
            placeholderNumberType: "MOBILE",
            preferredCountries: ['US'],
            separateDialCode: false
        });
        console.log(code)
    });
</script>