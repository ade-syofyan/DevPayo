<!-- partial -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<div class="content-wrapper">
    <div class="row ">
        <div class="col-md-8 offset-md-2 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Add Agent</h4>
                    <?php if ($this->session->flashdata() or validation_errors()) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?= validation_errors() ?>
                            <?php echo $this->session->flashdata('invalid'); ?>
                            <?php echo $this->session->flashdata('demo'); ?>
                        </div>
                    <?php endif; ?>
                    <?= form_open_multipart('Agent/tambah'); ?>

                    <div class="form-group row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Profile Picture</label>
                                <input type="file" name="foto" id="foto" class="dropify" data-max-file-size="3mb">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Foto KTP</label>
                                <input type="file" name="ktp" id="ktp" class="dropify" data-max-file-size="3mb">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Foto Selfie Dengan Ktp</label>
                                <input type="file" name="selfie" id="selfie" class="dropify" data-max-file-size="3mb">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="user_name">No NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" placeholder="input no nik sesuai ktp" <?php if ($_POST != NULL) { ?> value="<?= $_POST['nik']; ?>" <?php } ?> required>
                    </div>
                    <div class="form-group">
                        <label for="fullname">Nama Lengkap</label>
                        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="enter fullname" <?php if ($_POST != NULL) { ?> value="<?= $_POST['nama_lengkap']; ?>" <?php } ?> required>
                    </div>
                    <div class="form-group">
                        <label for="user_name">Username</label>
                        <input type="text" class="form-control" id="user_name" name="user_name" placeholder="enter username" <?php if ($_POST != NULL) { ?> value="<?= $_POST['user_name']; ?>" <?php } ?> required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="enter email " <?php if ($_POST != NULL) { ?> value="<?= $_POST['email']; ?>" <?php } ?> required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="text" class="form-control" id="password" name="password" placeholder="enter a password " <?php if ($_POST != NULL) { ?> value="<?= $_POST['password']; ?>" <?php } ?> required>
                    </div>


                    <label class="text-small">Phone Number</label>
                    <div class="row">

                        <div class="form-group col-2">
                            <input type="tel" id="txtPhone" class="form-control" name="countrycode" placeholder="+1 " <?php if ($_POST != NULL) { ?> value="<?= $_POST['countrycode']; ?>" <?php } ?> required>
                        </div>
                        <div class=" form-group col-10">
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="enter phone number" <?php if ($_POST != NULL) { ?> value="<?= $_POST['phone']; ?>" <?php } ?>>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="province">Provinsi</label>
                        <select id="province" class="js-example-basic-single" style="width:100%" name="province">
                            <option value="0">Pilih Provinsi</option>
                            <?php foreach ($prov as $pv) : ?>
                                <option value="<?= $pv['id'] ?>"><?= $pv['name'] ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="regency">Kota / Kabupaten</label>
                        <select id="regency" class="js-example-basic-single regency" style="width:100%" name="regency">
                            <option value="0">Pilih Kota / Kabupaten</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="district">Kecamatan</label>
                        <select id="district" class="js-example-basic-single district" style="width:100%" name="district">
                            <option value="0">Pilih Kecamatan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="village">Kelurahan</label>
                        <select id="village" class="js-example-basic-single village" style="width:100%" name="village">
                            <option value="0">Pilih Kelurahan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="enter address " <?php if ($_POST != NULL) { ?> value="<?= $_POST['alamat']; ?>" <?php } ?> required>
                    </div>
                    <button type="submit" class="btn btn-success mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                    <?= form_close(); ?>
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

<script>
    $(document).ready(function() {
        $('#province').change(function() {
            var id = $(this).val();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/Agent/get_regency",
                method: "POST",
                data: {
                    id: id
                },
                async: false,
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                    }
                    $('.regency').html(html);

                }
            });
        });
        $('#regency').change(function() {
            var id = $(this).val();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/Agent/get_district",
                method: "POST",
                data: {
                    id: id
                },
                async: false,
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                    }
                    $('.district').html(html);

                }
            });
        });

        $('#district').change(function() {
            var id = $(this).val();
            $.ajax({
                url: "<?php echo base_url(); ?>index.php/Agent/get_village",
                method: "POST",
                data: {
                    id: id
                },
                async: false,
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    var i;
                    for (i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                    }
                    $('.village').html(html);

                }
            });
        });
    });
</script>
<!-- end of content wrapper -->